<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

class UserService
{
  private $logger;

  public function __construct()
  {
    // ロガーの初期化
    $this->logger = new Logger('UserService');
    $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../storage/logs/php_errors.log', Logger::DEBUG));
  }

  /**
   * ユーザーを登録する
   *
   * @param array $userData ユーザーのデータ
   * @return bool ユーザー登録が成功したか
   */
  public function registerUser(array $userData): bool
  {
    try {
      // パスワードのハッシュ化
      $hashedPassword = password_hash($userData['password'], PASSWORD_BCRYPT);

      // ユーザーの作成
      $user = new User();
      $user->email = $userData['email'];
      $user->password = $hashedPassword;

      if ($user->save()) {
        $this->logger->info('ユーザー登録に成功しました。', ['email' => $userData['email']]);
        return true;
      } else {
        $this->logger->error('ユーザー登録に失敗しました。', ['email' => $userData['email']]);
        return false;
      }
    } catch (Exception $e) {
      $this->logger->error('ユーザー登録時にエラーが発生しました。', ['error' => $e->getMessage()]);
      return false;
    }
  }

  /**
   * ユーザーのログイン処理
   *
   * @param string $email
   * @param string $password
   * @return bool ログインが成功したか
   */
  public function loginUser(string $email, string $password): bool
  {
    try {
      // メールアドレスでユーザーを検索
      $user = User::findByEmail($email);

      if (!$user) {
        $this->logger->error('ログイン失敗: ユーザーが見つかりません。', ['email' => $email]);
        return false;
      }

      // パスワードを検証
      if (password_verify($password, $user->password)) {
        // セッションにユーザー情報を保存
        $_SESSION['user_id'] = $user->id;
        $this->logger->info('ログインに成功しました。', ['email' => $email]);
        return true;
      } else {
        $this->logger->error('ログイン失敗: パスワードが間違っています。', ['email' => $email]);
        return false;
      }
    } catch (Exception $e) {
      $this->logger->error('ログイン処理中にエラーが発生しました。', ['error' => $e->getMessage()]);
      return false;
    }
  }

  /**
   * パスワードリセット用のメールを送信する
   *
   * @param string $email
   * @return bool
   */
  public function sendPasswordResetEmail(string $email): bool
  {
    $mail = new PHPMailer(true);

    try {
      // メール設定
      $mail->isSMTP();
      $mail->Host = 'smtp.example.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'your_email@example.com';
      $mail->Password = 'your_email_password';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      // 送信者情報
      $mail->setFrom('no-reply@example.com', 'Your App');
      $mail->addAddress($email);

      // メール内容
      $mail->isHTML(true);
      $mail->Subject = 'パスワードリセットのお知らせ';
      $mail->Body    = 'パスワードリセットのリンクを以下に示します: <a href="your-reset-link">リセットリンク</a>';

      $mail->send();
      $this->logger->info('パスワードリセットメールを送信しました。', ['email' => $email]);
      return true;
    } catch (MailException $e) {
      $this->logger->error('パスワードリセットメールの送信に失敗しました。', ['email' => $email, 'error' => $e->getMessage()]);
      return false;
    }
  }
}
