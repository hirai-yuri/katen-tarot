<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require '../config/db_connection.php';

// エラーログを有効化し、ログファイルに出力
ini_set('display_errors', 0); //画面にエラーを表示しない
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/path_to_your_logs/php_errors.log');

// エラーログの出力先を指定
ini_set('log_errors', 1);
ini_set('error_log', '/storage/logs/php_errors.log'); // ログファイルのパスを指定

try {
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

  // データが正しいか確認
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 必要なデータが存在するか確認
    if (!isset($data['imgData'], $data['tarot_result'], $data['tarot_type'])) {
      throw new Exception("必要なデータが不足しています。");
    }
    // 画像データの処理
    $imgData = str_replace('data:image/jpeg;base64,', '', $data['imgData']);
    $imgData = str_replace(' ', '+', $imgData);
    $decodedData = base64_decode($imgData);

    // 画像ファイル名の生成
    $filename = 'tarot_result_' . time() . '.jpg';
    $filePath = '/var/www/html/storage/images/' . $filename;

    // 画像を保存し、失敗した場合はエラーログに記録
    if (file_put_contents($filePath, $decodedData) === false) {
      throw new Exception("画像の保存に失敗しました。");
    }

    // データベースへの保存
    $sql = "INSERT INTO tarot_results (user_id, tarot_result, image_path, tarot_type, created_at) 
VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql); // prepare を追加

    // prepare が失敗した場合のエラーチェック
    if (!$stmt) {
      throw new Exception("SQL prepare エラー: " . $conn->error);
    }

    $stmt->bind_param("isss", $user_id, $tarotResult, $filePath, $tarotType); // 変更したbind_param

    // SQL実行と例外処理
    if (!$stmt->execute()) {
      throw new Exception("SQLエラー: " . $conn->error);
    }

    // 成功メッセージを返す
    $url = 'http://your-domain.com/images/' . $filename;
    echo json_encode(['success' => true, 'filename' => $filename, 'url' => $url]);

    $stmt->close();
  }
} catch (Exception $e) {
  // エラーメッセージをログに記録し、一般的なエラーメッセージをユーザーに返す
  error_log($e->getMessage());
  echo json_encode(['success' => false, 'error' => 'エラーが発生しました。管理者にお問い合わせください。']);
} finally {
  $conn->close();
}
