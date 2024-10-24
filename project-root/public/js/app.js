const totalCards = 22;
let tarotType;

// タロットページ表示関数
function showTarot(tarotIdToShow, tarotIdToHide) {
  document.querySelector(".tarot-main").style.display = "none";
  document.querySelector(".tarot-text-box").style.display = "none";

  document.getElementById(tarotIdToShow).style.display = "flex";
  document.getElementById(tarotIdToHide).style.display = "none";

  document.getElementById("message1-tarot1").style.display = "none";
  document.getElementById("message1-tarot2").style.display = "none";
  document.getElementById("message2-tarot1").style.display = "none";
  document.getElementById("message2-tarot2").style.display = "none";

  tarotType = tarotIdToShow === "tarot1" ? "今日の運勢" : "恋愛運";

  document.querySelectorAll(".tarot-page").forEach((page) => {
    page.style.display = "none";
  });

  document.getElementById(tarotIdToShow).style.display = "flex";
  generateCards(tarotIdToShow);
}

function generateCards(displayId) {
  const displayElement = document
    .getElementById(displayId)
    .querySelector(".card-display");
  displayElement.innerHTML = "";

  for (let i = 0; i < totalCards; i++) {
    const card = document.createElement("div");
    card.className = "card";
    card.dataset.id = i;
    const img = document.createElement("img");
    img.src = "../../../public/images/cards/rowsen_cross.jpg";
    img.alt = "tarot card";
    card.appendChild(img);
    displayElement.appendChild(card);
  }
}

function toggleButtonDisplay(buttonIds, displayState) {
  buttonIds.forEach((id) => {
    const button = document.getElementById(id);
    if (button) {
      button.style.display = displayState;
    }
  });
}

function shuffleCards(displayId) {
  toggleButtonDisplay(["shuffleButton1", "shuffleButton2"], "none");

  const cardDisplay = document.getElementById(displayId);
  const cards = Array.from(cardDisplay.querySelectorAll(".card"));

  shuffleArray(cards);

  cards.forEach((card, index) => {
    const startX = Math.floor(Math.random() * 200 - 100);
    const startY = Math.floor(Math.random() * 200 - 100);
    const startRotation =
      Math.floor(Math.random() * 360) * (Math.random() < 0.5 ? 1 : -1);
    card.style.transition = "transform 2s ease";
    card.style.transform = `translate(${startX}px, ${startY}px) rotate(${startRotation}deg)`;
  });

  setTimeout(() => {
    arrangeBundles(splitIntoBundles(cards, 3));
    document.getElementById("message1-tarot1").style.display = "block";
    document.getElementById("message1-tarot2").style.display = "block";
  }, 2000);
}

function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
  return array;
}

function splitIntoBundles(cards, numBundles) {
  const bundles = [];
  const bundleSize = Math.floor(cards.length / numBundles);
  let remainder = cards.length % numBundles;

  let startIndex = 0;

  for (let i = 0; i < numBundles; i++) {
    let size = bundleSize;
    if (remainder > 0) {
      size += 1;
      remainder -= 1;
    }

    bundles.push(cards.slice(startIndex, startIndex + size));
    startIndex += size;
  }

  return bundles;
}

function arrangeBundles(bundles) {
  const bundleOffsets = [-125, 0, 125];
  const clickedBundles = [];

  bundles.forEach((bundle, index) => {
    const offsetX = bundleOffsets[index];

    bundle.forEach((card) => {
      card.style.transition = "transform 1s ease";
      card.style.transform = `translate(${offsetX}px, 0) rotate(0deg)`;
      card.style.pointerEvents = "auto";

      card.addEventListener("click", () => {
        if (!clickedBundles.includes(bundle)) {
          clickedBundles.push(bundle);
        }
        card.classList.add("bundle-clicked");

        if (clickedBundles.length === 3) {
          stackBundles(clickedBundles);
          document.getElementById("message1-tarot1").style.display = "none";
          document.getElementById("message1-tarot2").style.display = "none";
          document.getElementById("message2-tarot1").style.display = "block";
          document.getElementById("message2-tarot2").style.display = "block";
        }
      });
    });
  });
}

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
      card.style.pointerEvents = "none";
    });

    if (index === 0) {
      topCard = bundle[0];
    }
  });

  if (topCard) {
    topCard.style.pointerEvents = "auto";
    topCard.addEventListener("click", () => {
      flipCard(topCard);
      document.getElementById("message2-tarot1").style.display = "none";
      document.getElementById("message2-tarot2").style.display = "none";
    });
  }
}

function flipCard(card) {
  card.style.transition = "none";
  card.style.transform = "translate(0px, 0px) rotate(0deg)";

  const allCards = document.querySelectorAll(".card");
  allCards.forEach((otherCard) => {
    if (otherCard !== card) {
      otherCard.style.display = "none";
    }
  });

  setTimeout(() => {
    card.style.transition = "transform 0.8s ease";
    card.style.transform = "rotateY(180deg)";
  }, 50);

  const cardId = parseInt(card.dataset.id, 10);
  const flippedCard = cardData.find((c) => c.id === cardId);

  setTimeout(() => {
    if (flippedCard) {
      const img = card.querySelector("img");
      img.src = flippedCard.img;
      img.alt = flippedCard.name;

      const descriptionElement1 = document.getElementById("cardDescription1");
      descriptionElement1.innerHTML = `
        <p>カードの意味</p>
        <div class="meaning"><strong>${flippedCard.meaning}</strong></div>
        <p>キーワード</p>
        <div class="keyword"><strong>${flippedCard.keyword}</strong></div>
        <div class="description" id="description1">${flippedCard.description1}</div>`;
      descriptionElement1.style.display = "block";

      document.getElementById("showModalButton").style.display = "block";
      document.getElementById("index_to_button").style.display = "block";
    }

    if (tarotType === "今日の運勢") {
      captureTarotResult("tarot1");
    } else if (tarotType === "恋愛運") {
      captureTarotResult("tarot2");
    }

    card.style.pointerEvents = "none";
  }, 400);
}
