<?php
session_start();

// ログインしているかどうかの確認
$isLoggedIn = isset($_SESSION['user_id']);

// GETリクエストからユーザー名を取得
$username1 = isset($_GET['userName']) ? htmlspecialchars($_GET['userName'], ENT_QUOTES, 'UTF-8') : '';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KATEN TAROT</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="stylesheet" href="./css/pc-style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200..900&display=swap" rel="stylesheet" />
  <script>
    // PHPで取得したユーザー名をJSON形式でJavaScriptに渡す
    const userName = <?php echo json_encode($username1, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

    // ユーザー名が存在する場合、自動的に対話を開始
    if (userName) {
      window.addEventListener('DOMContentLoaded', () => {
        startDialogue(userName);
      });
    }
  </script>
</head>

<body>

  <img src="./img/main画像.jpg" alt="">

  <div class="main">
    <div class="login-button-area">
      <?php if ($isLoggedIn): ?>
        <a href="./tarotresult.php">
          <button class="results-button">占い結果を見る</button>
        </a>
        <a href="">
          <button class="QA-button">Q&A</button>
        </a>
        <a href="./logout.php">
          <button class="logout-button">ログアウト</button>
        </a>
      <?php else: ?>
        <a href="./app.php">
          <button class="results-button">タロット占い</button>
        </a>
        <a href="./login.php">
          <button class="login-button">ログイン</button>
        </a>
      <?php endif; ?>
    </div>

    <div class="main-text" id="main-text"></div>
    <img src="./img/main猫画像.jpg" alt="猫画像">
  </div>
</body>

</html>