<?php
$servername = "tarot-db-instance.cujbwcxqcbel.us-east-1.rds.amazonaws.com";
$username = "root";
$password = "fOm36AO6U7v7Y6CcvUyc";
$dbname = "tarot_db";

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset('utf8mb4');  // 文字セットをutf8mb4に設定


// 接続エラーのチェック
if ($conn->connect_error) {
  die("データベース接続に失敗しました: " . $conn->connect_error);
}
