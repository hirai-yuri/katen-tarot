<?php

use PHPUnit\Framework\TestCase;
use app\Services\UserService;

class UserTest extends TestCase
{
  protected $userService;

  protected function setUp(): void
  {
    // UserService のインスタンスを作成
    $this->userService = new UserService();
  }

  public function testRegisterUser(): void
  {
    // テストデータ
    $email = "test@example.com";
    $password = "password123";

    // モックのデータベース接続
    $mockDb = $this->createMock(mysqli::class);

    // prepare メソッドでの期待される動作を定義
    $mockStmt = $this->createMock(mysqli_stmt::class);
    $mockStmt->expects($this->once())
      ->method('execute')
      ->willReturn(true); // 実行成功

    $mockDb->expects($this->once())
      ->method('prepare')
      ->willReturn($mockStmt); // prepare メソッドはモックのステートメントを返す

    // UserService にモックのDB接続を設定
    $this->userService->setDbConnection($mockDb);

    // ユーザー登録の結果を確認
    $result = $this->userService->registerUser($email, $password);
    $this->assertTrue($result);
  }

  public function testLoginUser(): void
  {
    // テストデータ
    $email = "test@example.com";
    $password = "password123";
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // モックのデータベース接続
    $mockDb = $this->createMock(mysqli::class);

    // prepare メソッドでの期待される動作を定義
    $mockStmt = $this->createMock(mysqli_stmt::class);
    $mockStmt->expects($this->once())
      ->method('bind_param')
      ->willReturn(true);
    $mockStmt->expects($this->once())
      ->method('execute')
      ->willReturn(true);
    $mockStmt->expects($this->once())
      ->method('bind_result')
      ->willReturn(true);
    $mockStmt->expects($this->once())
      ->method('fetch')
      ->willReturnCallback(function () use (&$userId, &$fetchedHashedPassword) {
        $userId = 1; // ダミーユーザーID
        $fetchedHashedPassword = password_hash("password123", PASSWORD_DEFAULT); // ハッシュされたパスワード
        return true;
      });

    $mockDb->expects($this->once())
      ->method('prepare')
      ->willReturn($mockStmt); // prepare メソッドはモックのステートメントを返す

    // UserService にモックのDB接続を設定
    $this->userService->setDbConnection($mockDb);

    // ユーザーログインの結果を確認
    $result = $this->userService->loginUser($email, $password);
    $this->assertTrue($result);
  }

  public function testValidatePassword(): void
  {
    // パスワードの検証が正しいか確認
    $password = "password123";
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // パスワードが正しい場合
    $this->assertTrue($this->userService->validatePassword($password, $hashedPassword));

    // パスワードが間違っている場合
    $this->assertFalse($this->userService->validatePassword("wrongpassword", $hashedPassword));
  }
}
