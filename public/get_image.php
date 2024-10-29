<?php
// 必要な設定やセッションを開始
session_start();
require '../config/db_connection.php';

if (!isset($_GET['id'])) {
    header("HTTP/1.0 400 Bad Request");
    exit("ID is required");
}

// 画像IDを取得
$image_id = (int)$_GET['id'];

// データベースから画像パスを取得
$sql = "SELECT image_path FROM tarot_results WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $image_id, $_SESSION['user_id']); // ユーザーIDもチェック、セキュリティを確保
$stmt->execute();
$stmt->bind_result($image_path);
$stmt->fetch();
$stmt->close();
$conn->close();

if ($image_path && file_exists($image_path)) {
    // MIMEタイプを設定して画像を返す
    header("Content-Type: image/jpeg"); // 画像形式に応じて調整
    readfile($image_path);
    exit;
} else {
    header("HTTP/1.0 404 Not Found");
    echo "Image not found.";
}
