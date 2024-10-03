const totalCards = 22;

// タロットページ表示関数
function showTarot(tarotIdToShow, tarotIdToHide) {
  document.getElementById(tarotIdToShow).style.display = "block";
  document.getElementById(tarotIdToHide).style.display = "none";

  document.querySelectorAll(".tarot-page").forEach((page) => {
    page.style.display = "none";
  });
  document.getElementById(tarotIdToShow).style.display = "block";
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
  const cardDisplay = document.getElementById(displayId);
  const cards = cardDisplay.querySelectorAll(".card");
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
  }, 2500); // 3秒後に初期位置に戻る

  // シャッフル後に3つのグループに分ける
  const bundle1 = cardArray.slice(0, Math.floor(cardArray.length / 3)); // 最初の1/3のカードを束1に
  const bundle2 = cardArray.slice(
    Math.floor(cardArray.length / 3),
    Math.floor((2 * cardArray.length) / 3)
  ); // 次の1/3を束2に
  const bundle3 = cardArray.slice(Math.floor((2 * cardArray.length) / 3)); // 残りのカードを束3に

  setTimeout(() => {
    arrangeBundles([bundle1, bundle2, bundle3]); // シャッフル後に束を配置する
  }, 3500); // 3.5秒後に配置を開始
}

// 3つの束を画面上で別々の位置に配置し、それぞれの位置を揃える関数
function arrangeBundles(bundles) {
  const bundleOffsets = [-150, 0, 150]; // 束を左 (-150px)、中央 (0px)、右 (+150px) に配置するオフセット

  bundles.forEach((bundle, index) => {
    const offsetX = bundleOffsets[index]; // 各束のX軸オフセット
    const offsetY = 0; // Y軸のオフセットは同じ高さに固定

    // 束のカードを同じ位置に揃えて表示する
    bundle.forEach((card) => {
      card.style.transition = "transform 1s ease"; // 束を1秒かけて配置するアニメーション

      // カードのランダムな位置と回転をリセットしてから、束の位置を適用
      card.style.transform = `translate(${offsetX}px, ${offsetY}px) rotate(0deg)`; // X軸位置を揃えて配置
    });
  });
}
