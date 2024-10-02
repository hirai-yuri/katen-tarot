document.querySelectorAll(".card").forEach((card) => {
  card.addEventListener("click", function () {
    this.classList.toggle("is-flipped");

    // カードのIDを取得し、AJAXでカードの意味を取得
    const cardId = this.dataset.id;
    fetchMeaning(cardId);
  });
});

function fetchMeaning(cardId) {
  fetch(`getCardMeaning.php?cardId=${cardId}`)
    .then((response) => response.json())
    .then((data) => {
      // カードの意味を表示
      document.getElementById("meaning").innerText = data.meaning;
    });
}
