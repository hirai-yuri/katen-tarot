<?php
session_start(); // セッションを開始

// ユーザーがログインしているかどうかをチェック
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KATEN TAROT</title>
  <link rel="stylesheet" href="./css/styles.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200..900&display=swap"
    rel="stylesheet" />
</head>

<body class="stars">
  <!-- トップページ -->
  <div class="form-container">
    <div class="title">
      <p>KATENタロット</p>

      <label for="name" class="name-input"></label>
      <input type="text" class="name-input" id="usernameInput" placeholder="あなたのニックネームを入力してね" />
      <button class="start-button" onclick="startDialogue()">開始</button>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
  <script src="./js/cardData.js"></script>
  <script src="./js/stars.js"></script>
  <script src="./js/dialogue.js"></script>
  <script src="./js/app.js"></script>
  <script src="./js/captureTarotResult.js"></script>

</body>

</html>