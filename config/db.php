<?php

// 接続情報の定義:
// host、dbname、username、password は、データベース接続に必要な情報です。これは、Docker環境で実行されることを前提にしており、Docker Composeで設定されたデータベースサービスに接続します。
// 接続の初期化:
// new mysqli() でデータベースに接続し、接続エラーがあればメッセージを表示して停止します。
// 文字エンコードの設定:
// utf8mb4 は UTF-8 の完全なバージョンで、絵文字などの文字もサポートします。


 <?php
$host = 'db';            // Docker Composeで定義されたデータベースのホスト名
$dbname = 'tarot_db';     // 使用するデータベース名
$username = 'test';       // データベースユーザー名
$password = 'testpass';   // データベースパスワード

// データベース接続の設定
$conn = new mysqli($host, $username, $password, $dbname);

// 接続エラーをチェック
if ($conn->connect_error) {
    die("データベース接続に失敗しました: " . $conn->connect_error);
}

// UTF-8エンコーディングを設定
$conn->set_charset('utf8mb4');
?>
