const dialogueText = [
  "はじめまして、〇〇ちゃん。",
  "タロット占い師のKARENと申します。",
  "ぼくがこの先起こる〇〇ちゃんの未来を占います。",
  "今日の運勢、または恋愛運、どちらを占いますか？",
];

const dialogueElement = document.getElementById("dialogue");
let currentText = "";
let textIndex = 0;
let charIndex = 0;
let delayBetweenLines = 1000; // 台詞間の遅延 (ミリ秒)
let userName = ""; // ユーザーの名前を格納する変数

function startDialogue() {
  // フォームで入力された名前を取得
  const userNameElement = document.getElementById("usernameInput").value;
  if (userNameElement.trim() === "") {
    alert("名前を入力してください！");
    return;
  }
  userName = userNameElement.trim(); // 名前をトリムして格納

  // 名前を置き換えた台詞を準備
  for (let i = 0; i < dialogueText.length; i++) {
    dialogueText[i] = dialogueText[i].replace(
      /〇〇ちゃん/g,
      userName + "ちゃん"
    );
  }

  // フォームを非表示にし、ダイアログボックスを表示
  document.querySelector(".form-container").style.display = "none";
  document.querySelector(".main").style.display = "block";
  document.querySelector(".tarot-button").style.display = "flex";
  document.querySelector(".dialogue-box").style.display = "block";

  // 台詞の初期表示を開始
  typeText();
}

function typeText() {
  if (textIndex < dialogueText.length) {
    const currentLine = dialogueText[textIndex];
    if (charIndex < currentLine.length) {
      currentText += currentLine[charIndex];
      dialogueElement.textContent = currentText;
      charIndex++;
      setTimeout(typeText, 50); // 文字ごとの表示速度
    } else {
      // 次の台詞に移るための遅延
      setTimeout(() => {
        charIndex = 0;
        currentText += "\n"; // 改行を追加
        textIndex++;
        typeText();
      }, delayBetweenLines);
    }
  }
}
