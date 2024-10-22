<?php
session_start();


// ログインしているかどうかの確認
$isLoggedIn = isset($_SESSION['user_id']);


// GETリクエストからユーザー名を取得
if (isset($_GET['userName'])) {
  // HTMLエンティティをエスケープしてからセッションに保存
  $username1 = htmlspecialchars($_GET['userName'], ENT_QUOTES, 'UTF-8');
  $_SESSION['user_name'] = $username1;  // セッションに保存
} else {
  // セッションに保存されているユーザー名を使用
  $username1 = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KATEN TAROT</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/pc-style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200..900&display=swap" rel="stylesheet" />

</head>

<body>


  <div class="main">
    <div class="login-button-area">
      <?php if ($isLoggedIn): ?>
        <a href="./app.php">
          <button class="results-button">タロット占い</button>
        </a>
        <a href="./tarotresult.php">
          <button class="results-button">占い結果を見る</button>
        </a>
        <a href="./Q&A_a.php">
          <button class="QA-button">Q&A</button>
        </a>
        <a href="./logout.php">
          <button class="logout-button">ログアウト</button>
        </a>
        <a href="../top.php">
          <button class="login-button">名前変更</button>
        </a>
      <?php else: ?>
        <a href="../top.php">
          <button class="results-button">タロット占い</button>
        </a>
        <a href="./login.php">
          <button class="login-button">ログイン</button>
        </a>
        <a href="../top.php">
          <button class="login-button">名前変更</button>
        </a>
      <?php endif; ?>
    </div>
    <div class="tarot-text-box">
      <div class="katenname">猫</div>
      <div class="main-text" id="main-text"></div>
      <span class="cursor"></span>
    </div>
    <img src="../img/main猫画像.jpg" alt="猫画像">
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // セッションから取得したユーザー名をJavaScriptに渡す
      const userName = <?php echo json_encode($username1, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

      // ユーザー名が存在する場合、対話を開始
      if (userName) {
        startDialogue(userName);
      }
    });

    // 対話文とタイピングアニメーション
    const meinText = [
      "はじめまして、〇〇ちゃん。",
      "当サイトでは今日の運勢または恋愛運を",
      "神主KATENが占います。",
      "会員登録すると占い結果を保存できたり、",
      "KATENにメールで個別相談もできるよ。",
    ];

    const dialogueElement = document.getElementById("main-text");
    let currentText = "";
    let textIndex = 0;
    let charIndex = 0;
    let delayBetweenLines = 1000; // 台詞間の遅延 (ミリ秒)

    // 対話のアニメーションを開始
    function startDialogue(userName) {
      const dialogueText = meinText.map((text) => text.replace(/〇〇ちゃん/g, userName + "ちゃん"));

      // テキストタイピングアニメーションを実行
      typeText(dialogueText);
    }

    function typeText(dialogueText) {
      if (textIndex < dialogueText.length) {
        const currentLine = dialogueText[textIndex];
        if (charIndex < currentLine.length) {
          currentText += currentLine[charIndex];
          dialogueElement.innerHTML = currentText;
          charIndex++;
          setTimeout(() => typeText(dialogueText), 50); // タイピング速度
        } else {
          setTimeout(() => {
            charIndex = 0;
            currentText += "<br>"; // 改行を追加
            textIndex++;
            typeText(dialogueText);
          }, delayBetweenLines); // 台詞間の遅延
        }
      }
    }
  </script>
</body>

</html>