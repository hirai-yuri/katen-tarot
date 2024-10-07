const totalCards = 22;

// タロットページ表示関数
function showTarot(tarotIdToShow, tarotIdToHide) {
  document.getElementById("tarot-button").style.display = "none";
  document.getElementById(tarotIdToShow).style.display = "flex";
  document.getElementById(tarotIdToHide).style.display = "none";
  document.querySelector(".dialogue-box").style.display = "none";
  document.querySelector(".main").style.display = "none";

  document.querySelectorAll(".tarot-page").forEach((page) => {
    page.style.display = "none";
  });
  document.getElementById(tarotIdToShow).style.display = "flex";
  generateCards(tarotIdToShow);



}

// カード生成関数
function generateCards(displayId) {
  const displayElement = document
    .getElementById(displayId)
    .querySelector(".card-display");
  displayElement.innerHTML = ""; // 既存のカードをクリア

  for (let i = 0; i < totalCards; i++) {
    const card = document.createElement("div");
    card.className = "card";
    card.dataset.id = i;
    const img = document.createElement("img");
    img.src = "./img/rowsen_cross.jpg";
    img.alt = "tarot card";
    card.appendChild(img);
    displayElement.appendChild(card);
  }
}

// カードをシャッフルする機能
function shuffleCards(displayId) {
  // シャッフルボタンを非表示にする
  const shuffleButtons = ["shuffleButton1", "shuffleButton2"];

  shuffleButtons.forEach((id) => {
    const button = document.getElementById(id);
    if (button) {
      button.style.display = "none"; // ボタンを非表示にする
    }
  });




  //カードが表示されている場所の取得
  const cardDisplay = document.getElementById(displayId);

  //カードを取得
  const cards = cardDisplay.querySelectorAll(".card");

  //配列にカードを入れる
  const cardArray = Array.from(cards);

  // Fisher-Yatesアルゴリズムで配列をシャッフルする
  for (let i = cardArray.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [cardArray[i], cardArray[j]] = [cardArray[j], cardArray[i]];
  }

  // カードをランダムにシャッフル（最初のランダムな配置）
  cardArray.forEach((card) => {
    const startX = Math.floor(Math.random() * 200 - 100); // -100pxから100pxの範囲でランダム移動
    const startY = Math.floor(Math.random() * 200 - 100); // -100pxから100pxの範囲でランダム移動
    const startRotation =
      Math.floor(Math.random() * 360) * (Math.random() < 0.5 ? 1 : -1); // ランダムな回転
    card.style.transition = "transform 0.5s ease"; // 0.5秒でランダム位置に移動
    card.style.transform = `translate(${startX}px, ${startY}px) rotate(${startRotation}deg)`;
  });

  // 0.5秒後にランダムなシャッフルを再度適用
  setTimeout(() => {
    cardArray.forEach((card) => {
      const randomX = Math.floor(Math.random() * 200 - 100); // -100pxから100pxの範囲でランダム移動
      const randomY = Math.floor(Math.random() * 200 - 100); // -100pxから100pxの範囲でランダム移動
      const randomRotation =
        Math.floor(Math.random() * 360) * (Math.random() < 0.5 ? 1 : -1); // ランダムな回転
      card.style.transform = `translate(${randomX}px, ${randomY}px) rotate(${randomRotation}deg)`;
    });
  }, 500); // シャッフルアニメーションの開始を0.5秒遅らせる

  // 3秒後に初期位置に戻るアニメーション
  setTimeout(() => {
    cardArray.forEach((card, index) => {
      card.style.transition = "transform 1s ease"; // 1秒かけて初期位置に戻るアニメーション
      card.style.transform = "translate(0px, 0px) rotate(0deg)"; // 初期位置に戻る

      // z-indexを利用してカードの重なりを変更する
      card.style.zIndex = cardArray.length - index; // 新しい順序を反映
    });
  }, 2000); // 3秒後に初期位置に戻る

  // シャッフル後に3つのグループに分ける
  const bundle1 = cardArray.slice(0, Math.floor(cardArray.length / 3)); // 最初の1/3のカードを束1に
  const bundle2 = cardArray.slice(
    Math.floor(cardArray.length / 3),
    Math.floor((2 * cardArray.length) / 3)
  ); // 次の1/3を束2に
  const bundle3 = cardArray.slice(Math.floor((2 * cardArray.length) / 3)); // 残りのカードを束3に

  setTimeout(() => {
    arrangeBundles([bundle1, bundle2, bundle3]); // シャッフル後に束を配置する
  }, 2000); // 2秒後に配置を開始


}

// 3つの束を画面上で別々の位置に配置し、それぞれの位置を揃える関数
// 3つの束を画面上で別々の位置に配置し、それぞれの位置を揃える関数
function arrangeBundles(bundles) {
  const bundleOffsets = [-125, 0, 125]; // 束を左 (-150px)、中央 (0px)、右 (+150px) に配置するオフセット
  const clickedBundles = []; // クリックされた順に束を記録する配列

  bundles.forEach((bundle, index) => {
    const offsetX = bundleOffsets[index]; // 各束のX軸オフセット
    const offsetY = 0; // Y軸のオフセットは同じ高さに固定

    // 束のカードを同じ位置に揃えて表示する
    bundle.forEach((card) => {
      card.style.transition = "transform 1s ease"; // 束を1秒かけて配置するアニメーション
      card.style.transform = `translate(${offsetX}px, ${offsetY}px) rotate(0deg)`; // X軸位置を揃えて配置

      //メッセージ１を表示
      document.querySelector(".message1").style.display = "block";

      //カードをクリック
      card.addEventListener("click", () => {
        //クリックした束をclickedBundlesに記録
        if (!clickedBundles.includes(bundle)) {
          clickedBundles.push(bundle);
        }

        // クリックされたら枠を追加
        card.classList.add("bundle-clicked");

        // 3つの束がクリックされたら、順番に重ねる処理を実行
        if (clickedBundles.length === 3) {
          stackBundles(clickedBundles);
        }
      });
    });
  });
}

// 束をクリック順に重ねる関数
function stackBundles(clickedBundles) {
  const totalBundles = clickedBundles.length;
  let topCard; // 一番上のカードを保持する変数

  // クリックした束の位置を設定する
  clickedBundles.forEach((bundle, index) => {
    const offsetX = 0; // 束を中央に集めるためにX軸位置を0に設定
    const offsetY = 0; // Y軸も同じ高さに固定
    const zIndex = totalBundles - index; // 束をクリック順に重ねるためのz-index

    // 束内の各カードに対して処理
    bundle.forEach((card) => {
      card.style.transition = "transform 1s ease"; // 1秒かけて重ねるアニメーション
      card.style.transform = `translate(${offsetX}px, ${offsetY}px) rotate(0deg)`; // 中央に集める
      card.style.zIndex = zIndex; // z-indexを設定してクリック順に重ねる

      // カードのクリックイベントを無効化（重なった束のカードをクリックできないようにする）
      card.style.pointerEvents = "none";
    });

    // 一番上の束の最初のカード（z-indexが最も高いカード）をtopCardに設定
    if (index === 0) {
      topCard = bundle[0]; // 一番上の束の最初のカードを取得
    }
  });

  //メッセージ１を非表示、メッセージ２を表示
  document.querySelector(".message1").style.display = "none";
  document.querySelector(".message2").style.display = "block";


  // 一番上のカードをクリックできるようにする
  if (topCard) {
    topCard.style.pointerEvents = "auto"; // 一番上のカードのみクリックを許可
    topCard.addEventListener("click", () => {
      flipCard(topCard); // カードをめくる処理
    });
  }
}

function flipCard(card) {
  // めくる前にすべてのtransformをリセットする
  card.style.transition = "none"; // 一旦トランジションを無効化
  card.style.transform = "translate(0px, 0px) rotate(0deg)"; // 元の位置と回転にリセット

  // 他のカードを非表示にする処理
  const allCards = document.querySelectorAll(".card");
  allCards.forEach((otherCard) => {
    if (otherCard !== card) {
      otherCard.style.display = "none"; // 他のカードを非表示にする
    }


  });

  //メッセージ2を非表示
  document.querySelector(".message2").style.display = "none";

  // 少し時間を空けてからめくるアニメーションを設定
  setTimeout(() => {
    card.style.transition = "transform 0.8s ease"; // 0.8秒でカードをめくる
    card.style.transform = "rotateY(180deg)"; // Y軸方向に180度回転させてめくる
  }, 50); // 少し時間を空けてアニメーションを適用

  // カードIDを取得して対応する裏面の画像を表示する
  const cardId = parseInt(card.dataset.id, 10);
  const flippedCard = cardData.find((c) => c.id === cardId);

  // カードがめくられて180度回転した後に裏面の画像を表示する
  setTimeout(() => {
    if (flippedCard) {
      const img = card.querySelector("img");
      img.src = flippedCard.img; // カードデータから裏面の画像を設定
      img.alt = flippedCard.name; // 代替テキストを設定

      // カードの説明を表示
      const descriptionElement1 = document.getElementById("cardDescription1");
      descriptionElement1.innerHTML =
        `
        <p>カードの意味</p>
        <div class="meaning">
        <strong>${flippedCard.meaning}</strong>
        </div>
        <p>キーワード</p>
        <div class="keyword">
        <strong>${flippedCard.keyword}</strong>
        </div>
      <div class="description" id="description1">${flippedCard.description1}</div>`;

      descriptionElement1.style.display = "block"; // カードの説明を表示

      // カードの説明を表示
      const descriptionElement2 = document.getElementById("cardDescription2");
      descriptionElement2.innerHTML =
        `
      <p>カードの意味</p>
      <div class="meaning">
      <strong>${flippedCard.meaning}</strong>
      </div>

      <p>キーワード</p>
      <div class="keyword">
      <strong>${flippedCard.keyword}</strong>
      </div>

      <div class="description" id="description2">${flippedCard.description2}</div>`;


      descriptionElement2.style.display = "block"; // カードの説明を表示

      // // ここでタロットの結果を送信
      // const userName = document.getElementById("name").value; // ユーザー名を取得
      // saveResult(userName, flippedCard.name); // 名前とタロット結果をセッションに保存
    }


    // カードのクリックを無効化
    card.style.pointerEvents = "none"; // カードがクリックされないようにする
  }, 400); // 回転が完了した後に画像を変更し、説明を表示



}
