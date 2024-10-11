const meinText = [
  "はじめまして、〇〇ちゃん。",
  "当サイトでは今日の運勢または恋愛運を神主KARENが占います。",
  "会員登録すると占い結果を保存できたり、",
  "KARENにメールで個別相談もできるよ。",
];

const dialogueElement = document.getElementById("main-text");
let currentText = "";
let textIndex = 0;
let charIndex = 0;
let delayBetweenLines = 1000; // 台詞間の遅延 (ミリ秒)
let userName = ""; // ユーザーの名前を格納する変数

function startDialogue(userName) {
  // 名前を置き換えた台詞を準備
  const dialogueText = meinText.map((text) =>
    text.replace(/〇〇ちゃん/g, userName + "ちゃん")
  );

  // 台詞の初期表示を開始
  typeText(dialogueText);
}

function typeText(dialogueText) {
  if (textIndex < dialogueText.length) {
    const currentLine = dialogueText[textIndex];
    if (charIndex < currentLine.length) {
      currentText += currentLine[charIndex];
      dialogueElement.textContent = currentText;
      charIndex++;
      setTimeout(() => typeText(dialogueText), 50); // 文字ごとの表示速度
    } else {
      // 次の台詞に移るための遅延
      setTimeout(() => {
        charIndex = 0;
        currentText += "\n"; // 改行を追加
        textIndex++;
        typeText(dialogueText);
      }, delayBetweenLines);
    }
  }
}
