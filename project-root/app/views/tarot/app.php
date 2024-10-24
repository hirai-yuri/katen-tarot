<?php

// タロット占いのメインページ。占いの選択肢が表示され、「今日の運勢」か「恋愛運」を選び、それぞれのカードをシャッフルしてめくる機能を提供します。

session_start();

// ユーザーがログインしているか確認
$isLoggedIn = isset($_SESSION['user_id']);
$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>タロット占い</title>
  <link rel="stylesheet" href="/public/css/style.css">
  <script>
    const userName = '<?php echo $userName; ?>'; // PHPのセッションからユーザー名を取得
  </script>
</head>

<body>
  <div class="tarot-main">
    <div class="login-button-area">
      <a href="./index.php">
        <button class="results-button">戻る</button>
      </a>
    </div>

    <div class="tarot-button" id="tarot-button">
      <div onclick="showTarot('tarot1', 'tarot2')" id="tarot-button1">
        <img src="/public/images/ui/今日の運勢ボタン.png" alt="今日の運勢">
      </div>
      <div onclick="showTarot('tarot2', 'tarot1')" id="tarot-button2">
        <img src="/public/images/ui/恋愛運ボタン.png" alt="恋愛運">
      </div>
    </div>

    <div class="tarot-text-box">
      <div class="katenname">KATEN</div>
      <div id="tarot-text" class="tarot-text"></div>
      <span class="cursor"></span>
    </div>
    <img src="/public/images/ui/KATEN画像.png" alt="KATEN画像" id="katen-img" class="fade-in">
  </div>

  <!-- 今日の運勢のタロットページ -->
  <div id="tarot1" class="tarot-page">
    <div class="card-display" id="cardDisplay1"></div>
    <div class="card-description" id="cardDescription1"></div>
    <button class="shuffleButton" id="shuffleButton1" onclick="shuffleCards('cardDisplay1')">
      シャッフルスタート
    </button>
    <div class="message1" id="message1-tarot1">カードを好きな順番にクリック</div>
    <div class="message2" id="message2-tarot1">カードをクリックしてめくってね</div>
  </div>

  <!-- 恋愛占いのタロットページ -->
  <div id="tarot2" class="tarot-page">
    <div class="card-display" id="cardDisplay2"></div>
    <div class="card-description" id="cardDescription2"></div>
    <button class="shuffleButton" id="shuffleButton2" onclick="shuffleCards('cardDisplay2')">
      シャッフルスタート
    </button>
    <div class="message1" id="message1-tarot2">カードを好きな順番にクリック</div>
    <div class="message2" id="message2-tarot2">カードをクリックしてめくってね</div>
  </div>

  <div id="downloadModal" class="modal">
    <div class="modal-content">
      <p>タロットの結果をダウンロードしますか？</p>
      <img id="modalImage" src="" alt="タロット結果画像" />
      <button id="confirmDownload">はい</button>
      <button id="cancelDownload">いいえ</button>
    </div>
  </div>

  <script src="/public/js/app.js"></script>
  <script src="/public/js/captureTarotResult.js"></script>
</body>

</html>