<?php

// ユーザーの認証（ログイン・登録・ログアウト）を管理します。
// パスワードの一致確認やセッション管理、エラーログの出力も含みます。

namespace App\Controllers;

use App\Models\User;
use App\Services\LogService;

class UserController
{
  private $logService;

  public function __construct()
  {
    $this->logService = new LogService();
  }

  // ログイン処理
  public function login($email, $password)
  {
    $user = new User();
    if ($user->authenticate($email, $password)) {
      session_start();
      $_SESSION['user_id'] = $user->getUserId();
      $_SESSION['user_name'] = $user->getUserName();
      $this->logService->logInfo('User logged in successfully');
      header('Location: ../public/index.php');
      exit();
    } else {
      $this->logService->logError('Failed to log in');
      return false;
    }
  }

  // 登録処理
  public function register($email, $password, $confirmPassword)
  {
    if ($password !== $confirmPassword) {
      return false; // パスワード不一致
    }

    $user = new User();
    if ($user->createUser($email, $password)) {
      $this->logService->logInfo('User registered successfully');
      return true;
    } else {
      $this->logService->logError('Failed to register user');
      return false;
    }
  }

  // ログアウト処理
  public function logout()
  {
    session_start();
    session_destroy();
    $this->logService->logInfo('User logged out successfully');
    header('Location: ../public/index.php');
    exit();
  }
}
