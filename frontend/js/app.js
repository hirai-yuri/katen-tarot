// カードのシャッフル関数
function shuffleCards() {
  const cards = document.querySelectorAll(".card");
  cards.forEach((card) => {
    const randomPos = Math.floor(Math.random() * 22);
    card.style.order = randomPos;
    card.style.animation = "shuffle 1s ease";
  });
}

// カードのめくりと意味取得
document.querySelectorAll(".card").forEach((card) => {
  card.addEventListener("click", function () {
    this.classList.toggle("is-flipped");
    const cardId = this.dataset.id;
    fetchCardMeaning(cardId);
  });
});

// PHPからカードの意味を取得
function fetchCardMeaning(cardId) {
  fetch(`php/getCardMeaning.php?cardId=${cardId}`)
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("meaning").innerText = data.meaning;
    })
    .catch((error) => console.error("Error:", error));
}

// ページ読み込み時にカードをシャッフル
window.onload = shuffleCards;
