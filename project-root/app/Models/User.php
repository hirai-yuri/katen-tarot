<?php

// ユーザー認証や登録を行うモデルです。パスワードのハッシュ化、ユーザーの認証（ログイン）、新規登録を処理します。
// authenticate()メソッドでログイン認証を行い、createUser()で新規ユーザーを登録します。

namespace App\Models;

class User
{
  private $conn;

  public function __construct()
  {
    // データベース接続を読み込む
    $this->conn = include '../config/db.php';
  }

  // ユーザーを認証するメソッド
  public function authenticate($email, $password)
  {
    $stmt = $this->conn->prepare("SELECT user_id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if ($userId && password_verify($password, $hashedPassword)) {
      $this->userId = $userId;
      return true;
    }
    return false;
  }

  // 新規ユーザーを作成するメソッド
  public function createUser($email, $password)
  {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);

    if ($stmt->execute()) {
      $this->userId = $stmt->insert_id;
      return true;
    } else {
      error_log("SQLエラー: " . $stmt->error);
      return false;
    }
  }

  // ユーザーIDを取得するメソッド
  public function getUserId()
  {
    return $this->userId;
  }

  // ユーザー名を取得するメソッド
  public function getUserName()
  {
    $stmt = $this->conn->prepare("SELECT user_name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $this->userId);
    $stmt->execute();
    $stmt->bind_result($userName);
    $stmt->fetch();
    $stmt->close();

    return $userName;
  }
}
