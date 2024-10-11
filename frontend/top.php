<?php
session_start(); // セッションを開始

// ユーザーがログインしているかどうかをチェック
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KATEN TAROT</title>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
  <link rel="stylesheet" href="./css/top.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200..900&display=swap"
    rel="stylesheet" />

</head>

<body>
  <!-- トップページ -->
  <div class="top">
    <div class="title">
      <p>KATEN</p>
      <p>タロット占い</p>
    </div>
    <img src="../img/TOP猫画像.jpg" alt="猫画像">
    <form action="./index.php" method="GET">
      <label for="username1" class="name-input"></label>
      <input type="text" class="name-input" id="username1" name="username1" placeholder="あなたのニックネームを教えてね" autocomplete="off" />
      <input type="text" class="name-input" id="username2" name="username2" placeholder="気になるあの子のニックネームを教えてね" autocomplete="off" /><br>
      <input type="submit" class="start-button" value="開始">
    </form>
  </div>
</body>

</html>