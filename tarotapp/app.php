<?php
session_start();


// ログインしているかどうかの確認
$isLoggedIn = isset($_SESSION['user_id']);

// セッションからユーザー名を取得
$username1 = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
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
</head>

<body class="stars">

  <!-- タロット占いページ -->
  <div class="tarot-main">

    <div class="login-button-area">

      <a href="./index.php">
        <button class="results-button">戻る</button>
      </a>


    </div>



    <div class="tarot-button" id="tarot-button">
      <div onclick="showTarot('tarot1', 'tarot2')" id="tarot-button1">
        <span>▶︎</span>今日の運勢
      </div>
      <div onclick="showTarot('tarot2', 'tarot1')" id="tarot-button2">
        <span>▶︎</span>恋愛運
      </div>
    </div>

    <div class="tarot-text-box">
      <div class="katenname">KATEN</div>
      <div id="tarot-text" class="tarot-text"></div>
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

    <div class="message1" id="message1-tarot1">カードを好きな順番にクリック</div>
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
    <div class="message1" id="message1-tarot2">カードを好きな順番にクリック</div>
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
      <div class="button_area">

        <div id="showModalButton">ダウンロード</div>

        <div id="index_to_button"><a href="./app.php">戻る</a></div>
      </div>
    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
  <script src="./js/cardData.js"></script>
  <script src="./js/stars.js"></script>
  <script src="./js/app.js"></script>
  <script src="./js/captureTarotResult.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // PHPから取得したユーザー名をJSON形式でJavaScriptに渡す
      const userName = <?php echo json_encode($username1, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

      // ユーザー名が存在する場合、対話を開始
      if (userName) {
        startDialogue(userName);
      }
    });

    const tarotText = [
      "はじめまして、〇〇ちゃん。",
      "タロット占い師のKARENと申します。",
      "ぼくがこの先起こる〇〇ちゃんの未来を占います。",
      "今日の運勢、または恋愛運、どちらを占いますか？",
    ];

    const dialogueElement = document.getElementById("tarot-text");
    let currentText = "";
    let textIndex = 0;
    let charIndex = 0;
    let delayBetweenLines = 1000;

    function startDialogue(userName) {
      const dialogueText = tarotText.map((text) => text.replace(/〇〇ちゃん/g, userName + "ちゃん"));

      typeText(dialogueText);
    }

    function typeText(dialogueText) {
      if (textIndex < dialogueText.length) {
        const currentLine = dialogueText[textIndex];
        if (charIndex < currentLine.length) {
          currentText += currentLine[charIndex];
          dialogueElement.innerHTML = currentText;
          charIndex++;
          setTimeout(() => typeText(dialogueText), 50);
        } else {
          setTimeout(() => {
            charIndex = 0;
            currentText += "<br>";
            textIndex++;
            typeText(dialogueText);
          }, delayBetweenLines);
        }
      }
    }
  </script>
</body>

</html>