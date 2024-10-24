<?php

// 新規ユーザー登録のページです。ユーザーがメールアドレスとパスワードを入力し、パスワードの確認が一致した場合に、ユーザー情報がデータベースに保存されます。登録が完了すると自動的にログインし、トップページにリダイレクトします。

session_start();
require '../../config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
  $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
  $confirmPassword = htmlspecialchars($_POST['confirm_password'], ENT_QUOTES, 'UTF-8');

  // パスワードの確認
  if ($password !== $confirmPassword) {
    $error = 'パスワードが一致しません。';
  } else {
    // パスワードのハッシュ化
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ユーザー情報をデータベースに挿入
    $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $email, $hashed_password);

    if ($stmt->execute()) {
      $_SESSION['user_id'] = $stmt->insert_id;
      $_SESSION['email'] = $email;
      header("Location: /public/index.php");
      exit();
    } else {
      $error = 'ユーザー登録に失敗しました。';
    }

    $stmt->close();
  }
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録</title>
  <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>
  <div class="register-container">
    <h1>新規登録</h1>
    <?php if ($error): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="register.php" method="POST">
      <div class="form-group">
        <label for="email">メールアドレス:</label>
        <input type="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">パスワード:</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="confirm_password">パスワード確認:</label>
        <input type="password" name="confirm_password" required>
      </div>
      <div class="form-actions">
        <button type="submit">登録する</button>
      </div>
    </form>
    <div class="login-link">
      <p>既にアカウントをお持ちですか？ <a href="login.php">ログイン</a></p>
    </div>
  </div>
</body>

</html>