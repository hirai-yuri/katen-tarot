<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // 入力チェック
  if (!empty($email) && !empty($password)) {
    // ユーザーをデータベースで確認
    $sql = "SELECT user_id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();

    // パスワードの検証
    if ($userId && password_verify($password, $hashedPassword)) {
      // ログイン成功、セッションにユーザーIDを保存
      $_SESSION['user_id'] = $userId;
      header("Location: ../frontend/index.php"); // index.phpにリダイレクト
      exit();
    } else {
      // エラーメッセージは htmlspecialchars でエスケープ
      $error = "メールアドレスまたはパスワードが正しくありません";
    }
    $stmt->close();
  } else {
    $error = "すべてのフィールドを入力してください";
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン</title>
</head>

<body>
  <h1>ログイン</h1>
  <?php if (isset($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
  <?php endif; ?>
  <form action="../backend/login.php" method="post">
    <label for="email">メールアドレス:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="password">パスワード:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <button type="submit">ログイン</button>
  </form>
  <a href="./register.php">新規登録はこちら</a>
</body>

</html>