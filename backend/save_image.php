<?php
// エラーログを有効化し、ログファイルに出力
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// エラーログの出力先を指定
ini_set('log_errors', 1);
ini_set('error_log', '/path_to_your_logs/php_errors.log'); // ログファイルのパスを指定

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tarot_db";

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset('utf8mb4');

// 接続エラーのチェック
if ($conn->connect_error) {
  die("接続失敗: " . $conn->connect_error);
}

// リクエストボディを取得して変数に保存
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

// 受け取ったデータをログに出力（デバッグ用）
error_log("Received data: " . print_r($data, true));

// エラーハンドリング: データが正しいか確認
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 必要なデータが存在するか確認
  if (isset($data['imgData']) && isset($data['user_name']) && isset($data['tarot_result']) && isset($data['tarot_type'])) {
    $imgData = $data['imgData'];
    $userName = $conn->real_escape_string($data['user_name']);
    $tarotResult = $conn->real_escape_string($data['tarot_result']);
    $tarotType = $conn->real_escape_string($data['tarot_type']); // 修正: ペイロードに合わせてキー名を変更

    // 画像データの処理
    $imgData = str_replace('data:image/jpeg;base64,', '', $imgData);
    $imgData = str_replace(' ', '+', $imgData);
    $decodedData = base64_decode($imgData);

    // 画像ファイル名の生成
    $filename = 'tarot_result_' . time() . '.jpg';

    // 画像を保存し、失敗した場合はエラーログに記録
    $filePath = '../images/' . $filename;
    if (file_put_contents($filePath, $decodedData) === false) {
      error_log("Failed to save image: " . $filename); // 画像保存エラーのログ出力
      echo json_encode(['success' => false, 'error' => '画像の保存に失敗しました。']);
      exit();
    }

    // データベースへの保存
    $sql = "INSERT INTO tarot_results (user_name, tarot_result, image_path, tarot_type, created_at) 
        VALUES ('$userName', '$tarotResult', '$filePath', '$tarotType', NOW())";

    if ($conn->query($sql) === TRUE) {
      $url = 'http://your-domain.com/images/' . $filename;
      echo json_encode(['success' => true, 'filename' => $filename, 'url' => $url]);
    } else {
      error_log("SQLエラー: " . $conn->error); // SQLエラーのログ出力
      echo json_encode(['success' => false, 'error' => 'データベース保存に失敗しました。']);
    }
  } else {
    error_log("Missing data: " . print_r($data, true)); // データが不足している場合のエラーログ
    echo json_encode(['success' => false, 'error' => '必要なデータがありません。']);
  }
}

$conn->close();
