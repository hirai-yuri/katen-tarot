<?php
session_start();

// エラーログを有効化し、ログファイルに出力
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// エラーログの出力先を指定
ini_set('log_errors', 1);
ini_set('error_log', '/path_to_your_logs/php_errors.log'); // ログファイルのパスを指定

$servername = "tarot-db-instance.cujbwcxqcbel.us-east-1.rds.amazonaws.com";
$username = "root";
$password = "fOm36AO6U7v7Y6CcvUyc";
$dbname = "tarot_db";

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset('utf8mb4');

// 接続エラーのチェック
if ($conn->connect_error) {
  die("接続失敗: " . $conn->connect_error);
}

// セッションから user_id を取得
if (!isset($_SESSION['user_id'])) {
  error_log("ユーザーがログインしていません。");
  echo json_encode(['success' => false, 'error' => 'ログインしてください。']);
  exit();
} else {
  error_log("セッションから user_id を取得: " . $_SESSION['user_id']);
}

$user_id = $_SESSION['user_id'];

// リクエストボディを取得して変数に保存
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

// 受け取ったデータをログに出力（デバッグ用）
error_log("Received data: " . print_r($data, true));

// エラーハンドリング: データが正しいか確認
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 必要なデータが存在するか確認
  if (isset($data['imgData']) && isset($data['tarot_result']) && isset($data['tarot_type'])) {
    $imgData = $data['imgData'];
    $tarotResult = $conn->real_escape_string($data['tarot_result']);
    $tarotType = $conn->real_escape_string($data['tarot_type']);

    // // ユーザー名を users テーブルから取得
    // $sql = "SELECT user_name FROM users WHERE user_id = ?";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("i", $user_id);
    // $stmt->execute();
    // $stmt->bind_result($userName);
    // $stmt->fetch();
    // $stmt->close();

    // // ユーザー名が取得できない場合のエラー処理
    // if (!$userName) {
    //   echo json_encode(['success' => false, 'error' => 'ユーザー名が見つかりません。']);
    //   exit();
    // }

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
    $sql = "INSERT INTO tarot_results (user_id, tarot_result, image_path, tarot_type, created_at) 
VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql); // prepare を追加

    // prepare が失敗した場合のエラーチェック
    if (!$stmt) {
      error_log("SQL prepare エラー: " . $conn->error);
      echo json_encode(['success' => false, 'error' => 'SQLの準備に失敗しました。']);
      exit();
    }

    $stmt->bind_param("isss", $user_id, $tarotResult, $filePath, $tarotType); // 変更したbind_param

    if ($stmt->execute()) {
      $url = 'http://your-domain.com/images/' . $filename;
      echo json_encode(['success' => true, 'filename' => $filename, 'url' => $url]);
    } else {
      error_log("SQLエラー: " . $conn->error); // SQLエラーのログ出力
      echo json_encode(['success' => false, 'error' => 'データベース保存に失敗しました。']);
    }
    $stmt->close();
  } else {
    error_log("Missing data: " . print_r($data, true)); // データが不足している場合のエラーログ
    echo json_encode(['success' => false, 'error' => '必要なデータがありません。']);
  }
}

$conn->close();
