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

  // Fisher-Yatesアルゴリズムで配列をシャッフルする
  for (let i = cardArray.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [cardArray[i], cardArray[j]] = [cardArray[j], cardArray[i]];
  }

  // 現在のカードをすべて削除し、シャッフルされた順に再表示
  cardDisplay.innerHTML = "";
  cardArray.forEach((card) => {
    cardDisplay.appendChild(card);
  });

  console.log(cardArray);
}
