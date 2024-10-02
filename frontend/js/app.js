function showTarot1() {
  document.getElementById("home").style.display = "none";
  document.getElementById("tarot1").style.display = "block";
}

function showTarot2() {
  document.getElementById("home").style.display = "none";
  document.getElementById("tarot2").style.display = "block";
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
