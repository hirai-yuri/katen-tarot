<?php

// ユーザーからの問い合わせ内容をデータベースに保存するモデルです。saveInquiry()メソッドを使用して問い合わせデータを保存します。

namespace App\Models;

class QAModel
{
  private $conn;

  public function __construct()
  {
    // データベース接続を読み込む
    $this->conn = include '../config/db.php';
  }

  // 問い合わせ内容を保存するメソッド
  public function saveInquiry($data)
  {
    $stmt = $this->conn->prepare("INSERT INTO inquiries (name, email, reason, message, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $data['name'], $data['email'], $data['reason'], $data['message']);

    return $stmt->execute();
  }
}
