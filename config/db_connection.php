<?php
// $servername = getenv('DB_HOST');
// $username = getenv('DB_USER');
// $password = getenv('DB_PASS');
// $dbname = getenv('DB_NAME');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tarot_db";


// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset('utf8mb4');  // 文字セットをutf8mb4に設定


// 接続エラーのチェック
if ($conn->connect_error) {
  die("データベース接続に失敗しました: " . $conn->connect_error);
}
