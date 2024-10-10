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

  <!-- メインページ -->
  <div class="main">

    <?php if ($isLoggedIn): ?>
      <!-- ログインしている場合に表示されるリンク -->
      <a href="../backend/tarotresult.php">
        <button class="results-button">占い結果を見る</button>
      </a>
      <a href="logout.php">
        <button class="logout-button">ログアウト</button>
      </a>
    <?php else: ?>
      <!-- ログインしていない場合に表示されるリンク -->
      <a href="login.php">
        <button class="login-button">ログイン</button>
      </a>
    <?php endif; ?>


    <div class="tarot-button" id="tarot-button">
      <div onclick="showTarot('tarot1', 'tarot2')" id="tarot-button1">
        <span>▶︎</span>今日の運勢
      </div>
      <div onclick="showTarot('tarot2', 'tarot1')" id="tarot-button2">
        <span>▶︎</span>恋愛運
      </div>
    </div>

    <div class="dialogue-box">
      <div class="katenname">KATEN</div>
      <div id="dialogue" class="dialogue-text"></div>
      <span class="cursor"></span>
    </div>
  </div>

  <!-- 今日の運勢のタロットページ -->
  <div id="tarot1" class="tarot-page">
    <div class="card-display" id="cardDisplay1"></div>
    <div class="card-description" id="cardDescription1"></div>
    <button
      class="shuffleButton"
      id="shuffleButton1"
      onclick="shuffleCards('cardDisplay1')">
      シャッフルスタート
    </button>
    <div class="message1" id="message1-tarot1">
      カードを好きな順番にクリック
    </div>
    <div class="message2" id="message2-tarot1">カードをクリックしてめくってね</div>
  </div>

  <!-- 恋占いのタロットページ -->
  <div id="tarot2" class="tarot-page">
    <div class="card-display" id="cardDisplay2"></div>
    <div class="card-description" id="cardDescription2"></div>
    <button
      class="shuffleButton"
      id="shuffleButton2"
      onclick="shuffleCards('cardDisplay2')">
      シャッフルスタート
    </button>
    <div class="message1" id="message1-tarot2">
      カードを好きな順番にクリック
    </div>
    <div class="message2" id="message2-tarot2">カードをクリックしてめくってね</div>
  </div>

  <!-- モーダルの構造 -->
  <div id="downloadModal" class="modal">
    <div class="modal-content">
      <p>タロットの結果をダウンロードしますか？</p>
      <img id="modalImage" src="" alt="タロット結果画像" />
      <button id="confirmDownload">はい</button>
      <button id="cancelDownload">いいえ</button>
    </div>
  </div>

  <div>
    <div class="button_area">
      <div id="showModalButton">ダウンロード</div>
      <div id="index_to_button">戻る</div>
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