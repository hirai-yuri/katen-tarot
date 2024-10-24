<?php

// ユーザーがメールアドレスとパスワードを使用してログインするためのページです。正しい情報が提供された場合に、セッションにユーザーIDが保存され、ログイン後はトップページにリダイレクトします。

session_start();
require '../../config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
  $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

  // データベースからユーザー情報を取得
  $sql = "SELECT id, password FROM users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $stmt->bind_result($user_id, $hashed_password);
  $stmt->fetch();

  // パスワードが一致するか確認
  if ($user_id && password_verify($password, $hashed_password)) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['email'] = $email;
    header("Location: /public/index.php");
    exit();
  } else {
    $error = 'メールアドレスまたはパスワードが正しくありません。';
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン</title>
  <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>
  <div class="login-container">
    <h1>ログイン</h1>
    <?php if ($error): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
      <div class="form-group">
        <label for="email">メールアドレス:</label>
        <input type="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">パスワード:</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-actions">
        <button type="submit">ログイン</button>
      </div>
    </form>
    <div class="register-link">
      <p>アカウントをお持ちでない場合: <a href="register.php">新規登録</a></p>
    </div>
  </div>
</body>

</html>