<?php
session_start();
require './backend/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];

  // 入力チェック
  if (!empty($email) && !empty($password) && !empty($confirmPassword)) {
    // パスワードの一致を確認
    if ($password === $confirmPassword) {
      // メールアドレスがすでに存在しないか確認
      $sql = "SELECT user_id FROM users WHERE email = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
        // メールアドレスが既に存在する場合
        $error = "このメールアドレスは既に登録されています。";
      } else {
        // パスワードをハッシュ化
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 新規ユーザーをデータベースに挿入
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $hashedPassword);

        if ($stmt->execute()) {
          // 登録成功、ログイン状態にしてリダイレクト
          $_SESSION['user_id'] = $stmt->insert_id; // 登録されたユーザーIDをセッションに保存
          header("Location: ./index.php"); // index.phpにリダイレクト
          exit();
        } else {
          $error = "登録に失敗しました。もう一度お試しください。";
        }
      }
    } else {
      $error = "パスワードが一致しません。";
    }
  } else {
    $error = "すべてのフィールドを入力してください。";
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録</title>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="stylesheet" href="./css/pc-style.css" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200..900&display=swap"
    rel="stylesheet" />

</head>

<body class="login">
  <h1>新規登録</h1>
  <?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
  <?php endif; ?>
  <form action="./register.php" method="post">
    <label for="email">メールアドレス</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="password">パスワード</label>
    <input type="password" name="password" id="password" required>
    <br>
    <label for="confirm_password">パスワードを確認</label>
    <input type="password" name="confirm_password" id="confirm_password" required>
    <br>
    <button type="submit">新規登録</button>
  </form>
  <a href="./login.php">すでにアカウントをお持ちの方はこちら</a>
</body>

</html>