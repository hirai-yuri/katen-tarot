<?php
// 必要な設定やセッションを開始
session_start();
require '../config/db_connection.php';


try {

    //IDパラメータが存在するかチェック
    if (!isset($_GET['id'])) {
        header("HTTP/1.0 400 Bad Request");
        exit("ID is required");
    }

    // ユーザーがログインしているかチェック
    if (!isset($_SESSION['user_id'])) {
        throw new Exception("User not logged in.");
    }

    // 画像IDを取得
    $image_id = (int)$_GET['id'];

    // データベースから画像パスを取得
    $sql = "SELECT image_path FROM tarot_results WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("SQL preparation failed: " . $conn->error);
    }

    $stmt->bind_param("ii", $image_id, $_SESSION['user_id']); // ユーザーIDもチェック、セキュリティを確保
    $stmt->execute();
    $stmt->bind_result($image_path);
    $stmt->fetch();
    $stmt->close();
    $conn->close();


    // 画像パスとファイル存在チェック
    if ($image_path) {
        if (file_exists($image_path)) {
            // MIMEタイプを設定して画像を返す
            header("Content-Type: image/jpeg"); // 画像形式に応じて調整
            readfile($image_path);
            exit;
        } else {
            throw new Exception("Image file does not exist at path: " . $image_path);
        }
    } else {
        throw new Exception("Image path not found for ID: " . $image_id . " and User ID: " . $_SESSION['user_id']);
    }
} catch (Exception $e) {
    // エラーログに記録し、ユーザーにエラーメッセージを返す
    error_log("Error: " . $e->getMessage());
    header("HTTP/1.0 500 Internal Server Error");
    echo "An error occurred. Please try again later.";
}
