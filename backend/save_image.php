<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "tarot_db";

// dockerを使用する場合の変数
$servername = "db";  // Docker ComposeのMySQLサービス名に変更
$username = "root";  // 環境変数MYSQL_USERに設定した値
$password = "";      // 環境変数MYSQL_PASSWORDに設定した値（空ならそのまま）
$dbname = "tarot_db";  // データベース名

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続エラーのチェック
if ($conn->connect_error) {
  die("接続失敗: " . $conn->connect_error);
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

// リクエストボディを取得して変数に保存
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

// デバッグ用: データが正しく受け取れているか確認
file_put_contents('php_debug.log', print_r($data, true), FILE_APPEND);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 必要なデータがあるか確認
  if (isset($data['imgData']) && isset($data['user_name'])) {
    $imgData = $data['imgData'];
    $userName = $conn->real_escape_string($data['user_name']);
    $tarotResult = $conn->real_escape_string($data['tarot_result']);


    $imgData = str_replace('data:image/jpeg;base64,', '', $imgData);
    $imgData = str_replace(' ', '+', $imgData);

    // バイナリデータに変換
    $decodedData = base64_decode($imgData);

    // 画像ファイル名の生成
    $filename = 'tarot_result_' . time() . '.jpg';

    // 画像を保存
    $filePath = '../images/' . $filename;
    if (file_put_contents($filePath, $decodedData) === false) {
      echo json_encode(['success' => false, 'error' => '画像の保存に失敗しました。']);
      exit();
    }

    // MySQLに保存
    $sql = "INSERT INTO tarot_results (user_name, tarot_result, image_path) VALUES ('$userName', '$tarotResult', '$filePath')";
    if ($conn->query($sql) === TRUE) {
      // 共有用URLの生成
      $url = 'http://your-domain.com/images/' . $filename;

      // 成功時にURLも返す
      echo json_encode(['success' => true, 'filename' => $filename, 'url' => $url]);
    } else {
      echo json_encode(['success' => false, 'error' => 'データベース保存に失敗しました。']);
    }
  } else {
    echo json_encode(['success' => false, 'error' => '必要なデータがありません。']);
  }
}
$conn->close();
