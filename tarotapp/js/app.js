const totalCards = 22;
let tarotType;

// タロットページ表示関数
function showTarot(tarotIdToShow, tarotIdToHide) {
  document.querySelector(".tarot-main").style.display = "none"; // タロット占いメインページ部分を非表示
  document.querySelector(".tarot-text-box").style.display = "none"; // ダイアログボックスを非表示
  document.getElementById(tarotIdToShow).style.display = "flex"; // 表示するタロットページを表示
  document.getElementById(tarotIdToHide).style.display = "none"; // 非表示にするタロットページを隠す
  document.querySelector(".message1").style.display = "none"; // メッセージ1を隠す
  document.querySelector(".message2").style.display = "none"; // メッセージ2を隠す

  // 占いの種類を記録する
  tarotType = tarotIdToShow === "tarot1" ? "今日の運勢" : "恋愛運";

  console.log(tarotType);

  // 他のすべてのタロットページを非表示にする
  document.querySelectorAll(".tarot-page").forEach((page) => {
    page.style.display = "none";
  });

  // 表示するタロットページを表示
  document.getElementById(tarotIdToShow).style.display = "flex";

  // カードを生成
  generateCards(tarotIdToShow);
}

// カード生成関数
function generateCards(displayId) {
  const displayElement = document
    .getElementById(displayId)
    .querySelector(".card-display");
  displayElement.innerHTML = ""; // 既存のカードをクリア

  // 22枚のカードを生成
  for (let i = 0; i < totalCards; i++) {
    const card = document.createElement("div");
    card.className = "card";
    card.dataset.id = i; // カードIDを設定
    const img = document.createElement("img");
    img.src = "./img/rowsen_cross.jpg"; // 画像パスを設定
    img.alt = "tarot card";
    card.appendChild(img);
    displayElement.appendChild(card);
  }
}

// ボタンの表示切り替え関数
function toggleButtonDisplay(buttonIds, displayState) {
  buttonIds.forEach((id) => {
    const button = document.getElementById(id);
    if (button) {
      button.style.display = displayState; // ボタンの表示/非表示を切り替える
    }
  });
}

// カードをシャッフルする機能
function shuffleCards(displayId) {
  // シャッフルボタンを非表示
  toggleButtonDisplay(["shuffleButton1", "shuffleButton2"], "none");

  // カードが表示されている場所の取得
  const cardDisplay = document.getElementById(displayId);
  const cards = Array.from(cardDisplay.querySelectorAll(".card")); // カードを配列に変換

  // シャッフルアルゴリズムを適用
  shuffleArray(cards);

  // カードをランダムな位置に配置
  cards.forEach((card, index) => {
    const startX = Math.floor(Math.random() * 200 - 100); // -100pxから100pxの範囲でランダムに配置
    const startY = Math.floor(Math.random() * 200 - 100);
    const startRotation =
      Math.floor(Math.random() * 360) * (Math.random() < 0.5 ? 1 : -1); // ランダムに回転
    card.style.transition = "transform 2s ease"; // トランジション効果を設定
    card.style.transform = `translate(${startX}px, ${startY}px) rotate(${startRotation}deg)`; // カードをランダムに配置
  });

  // 2秒後に束を配置する
  setTimeout(() => {
    arrangeBundles(splitIntoBundles(cards, 3)); // カードを3つの束に分ける
  }, 2000);
}

// 配列シャッフル関数（Fisher-Yatesアルゴリズム）
function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]]; // 配列要素を交換
  }
  return array;
}

// カードを3つの束に分ける
function splitIntoBundles(cards, numBundles) {
  const bundles = [];
  const bundleSize = Math.floor(cards.length / numBundles); // 各束の標準サイズ
  let remainder = cards.length % numBundles; // 余りのカードの数

  let startIndex = 0;

  // 各束にカードを割り当てる
  for (let i = 0; i < numBundles; i++) {
    let size = bundleSize;

    // 余りのカードを均等に分ける
    if (remainder > 0) {
      size += 1; // 1枚追加
      remainder -= 1; // 残りの余りを減らす
    }

    bundles.push(cards.slice(startIndex, startIndex + size)); // 束にカードを分割して追加
    startIndex += size; // 次の束の開始位置を更新
  }

  return bundles;
}

// 束を配置する関数
function arrangeBundles(bundles) {
  const bundleOffsets = [-125, 0, 125];
  const clickedBundles = [];

  bundles.forEach((bundle, index) => {
    const offsetX = bundleOffsets[index];

    bundle.forEach((card) => {
      card.style.transition = "transform 1s ease";
      card.style.transform = `translate(${offsetX}px, 0) rotate(0deg)`;
      card.style.pointerEvents = "auto"; // カードをクリック可能にする

      // カードクリック時の処理
      card.addEventListener("click", () => {
        if (!clickedBundles.includes(bundle)) {
          clickedBundles.push(bundle);
        }
        card.classList.add("bundle-clicked");

        // クリックされた束を3つに制限
        if (clickedBundles.length === 3) {
          stackBundles(clickedBundles);

          // メッセージ1を表示 (束が3つ揃った時点で表示)
          document.querySelector(".message1").style.display = "block";

          // メッセージ2はまだ表示しない
          document.querySelector(".message2").style.display = "none";
        }
      });
    });
  });
}

// 束をクリック順に重ねる関数
function stackBundles(clickedBundles) {
  const totalBundles = clickedBundles.length;
  let topCard;

  clickedBundles.forEach((bundle, index) => {
    const offsetX = 0;
    const offsetY = 0;
    const zIndex = totalBundles - index;

    bundle.forEach((card) => {
      card.style.transition = "transform 1s ease";
      card.style.transform = `translate(${offsetX}px, ${offsetY}px) rotate(0deg)`;
      card.style.zIndex = zIndex;
      card.style.pointerEvents = "none"; // クリック後に無効化
    });

    if (index === 0) {
      topCard = bundle[0]; // 一番上のカードのみクリック可能
    }
  });

  // 束が重なった後にメッセージ2を表示
  document.querySelector(".message2").style.display = "block";

  if (topCard) {
    topCard.style.pointerEvents = "auto"; // 一番上のカードのみクリック可能にする
    topCard.addEventListener("click", () => {
      flipCard(topCard); // カードをめくる処理
    });
  }
}

// カードをめくる関数
function flipCard(card) {
  // めくる前にすべてのtransformをリセット
  card.style.transition = "none"; // トランジションを無効化
  card.style.transform = "translate(0px, 0px) rotate(0deg)"; // 元の位置と回転にリセット

  // 他のカードを非表示にする処理
  const allCards = document.querySelectorAll(".card");
  allCards.forEach((otherCard) => {
    if (otherCard !== card) {
      otherCard.style.display = "none"; // 他のカードを非表示
    }
  });

  // メッセージ2を非表示
  document.querySelector(".message2").style.display = "none";

  // 少し時間を空けてからめくるアニメーションを設定
  setTimeout(() => {
    card.style.transition = "transform 0.8s ease"; // 0.8秒でカードをめくる
    card.style.transform = "rotateY(180deg)"; // Y軸方向に180度回転させてめくる
  }, 50); // 少し時間を空けてアニメーションを適用

  // カードIDを取得して対応する裏面の画像を表示
  const cardId = parseInt(card.dataset.id, 10); // データ属性からカードIDを取得
  const flippedCard = cardData.find((c) => c.id === cardId); // カードIDに対応するデータを検索

  // カードがめくられて180度回転した後に裏面の画像を表示
  setTimeout(() => {
    if (flippedCard) {
      const img = card.querySelector("img");
      img.src = flippedCard.img; // カードデータから裏面の画像を設定
      img.alt = flippedCard.name; // 代替テキストを設定

      // カードの説明を表示
      const descriptionElement1 = document.getElementById("cardDescription1");
      descriptionElement1.innerHTML = `
        <p>カードの意味</p>
        <div class="meaning"><strong>${flippedCard.meaning}</strong></div>
        <p>キーワード</p>
        <div class="keyword"><strong>${flippedCard.keyword}</strong></div>
        <div class="description" id="description1">${flippedCard.description1}</div>`;
      descriptionElement1.style.display = "block"; // カードの説明を表示

      // 恋愛運の場合の説明も表示
      const descriptionElement2 = document.getElementById("cardDescription2");
      descriptionElement2.innerHTML = `
        <p>カードの意味</p>
        <div class="meaning"><strong>${flippedCard.meaning}</strong></div>
        <p>キーワード</p>
        <div class="keyword"><strong>${flippedCard.keyword}</strong></div>
        <div class="description" id="description2">${flippedCard.description2}</div>`;
      descriptionElement2.style.display = "block"; // カードの説明を表示

      // ダウンロードボタンを表示
      document.getElementById("showModalButton").style.display = "block";
      document.getElementById("index_to_button").style.display = "block";

      function returnToMain() {
        // タロットページや他の不要な要素を非表示にする
        document.getElementById("tarot1").style.display = "none";
        document.getElementById("tarot2").style.display = "none";
        document.querySelector(".form-container").style.display = "none";

        // メインページを表示する
        document.querySelector(".main").style.display = "block";
      }
    }

    // タロットの結果を画像としてキャプチャし、保存する
    captureTarotResult();

    // カードのクリックを無効化
    card.style.pointerEvents = "none"; // カードがクリックされないようにする
  }, 400); // 回転が完了した後に画像を変更し、説明を表示
}
// タロット結果をキャプチャする関数
function captureTarotResult() {
  const tarotPage = document.querySelector(".tarot-page");

  // html2canvasを使ってタロット結果をキャプチャ
  html2canvas(tarotPage, { backgroundColor: "#044b74" }).then((canvas) => {
    const imgData = canvas.toDataURL("image/jpeg"); // 画像をJPEG形式に変換

    // サーバーに画像データを送信
    fetch("../backend/save_image.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ imgData: imgData }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          console.log("画像が保存されました: " + data.url);
        } else {
          console.error("エラーが発生しました:", data.error);
        }
      })
      .catch((error) => {
        console.error("リクエストに失敗しました:", error);
      });
  });
}
