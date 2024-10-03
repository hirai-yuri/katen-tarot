const totalCards = 22;

// 今日の運勢タロットページ表示関数
function showTarot1(tarotId) {
  document.getElementById("tarot1").style.display = "block";
  document.getElementById("tarot2").style.display = "none";

  document.querySelectorAll(".tarot-page").forEach((page) => {
    page.style.display = "none";
  });
  document.getElementById(tarotId).style.display = "block";
  generateCards(tarotId);
}

// 恋占いタロットページ表示関数
function showTarot2(tarotId) {
  document.getElementById("tarot1").style.display = "none";
  document.getElementById("tarot2").style.display = "block";
  document.querySelectorAll(".tarot-page").forEach((page) => {
    page.style.display = "none";
  });
  document.getElementById(tarotId).style.display = "block";
  generateCards(tarotId);
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

/* カードをシャッフルする機能 */
function shuffleCards() {
  const cards = document.querySelectorAll(".card-display .card");
  const cardDisplay = document.querySelector(".card-display");
  const cardArray = Array.from(cards);

  // カードの位置をリセット（全てのカードを元の位置に戻す）
  cardArray.forEach((card) => {
    card.style.transform = `translate(0px, 0px) rotate(0deg)`;
  });

  // 少し遅らせてカードをシャッフルするようにランダムに動かす
  setTimeout(() => {
    cardArray.forEach((card) => {
      const randomX = Math.floor(Math.random() * 200 - 100); // -100pxから100pxの範囲でランダム移動
      const randomY = Math.floor(Math.random() * 200 - 100); // -100pxから100pxの範囲でランダム移動
      const randomRotation = Math.floor(Math.random() * 360); // 0度から360度までランダム回転
      card.style.transform = `translate(${randomX}px, ${randomY}px) rotate(${randomRotation}deg)`;
    });

    // Fisher-Yatesアルゴリズムで配列をシャッフルする
    for (let i = cardArray.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [cardArray[i], cardArray[j]] = [cardArray[j], cardArray[i]];
    }

    // シャッフル後に表示を更新
    const cardDisplay = document.querySelector(".card-display");
    cardDisplay.innerHTML = "";
    cardArray.forEach((card) => {
      cardDisplay.appendChild(card);
    });

    console.log(cardArray);
  }, 300); // シャッフルアニメーションの開始を0.3秒遅らせる
}
