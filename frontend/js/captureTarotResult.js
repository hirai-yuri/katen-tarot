let imgData = null;

// モーダル要素を取得
const downloadModal = document.getElementById("downloadModal");
const modalImage = document.getElementById("modalImage");
const confirmDownloadButton = document.getElementById("confirmDownload");
const cancelDownloadButton = document.getElementById("cancelDownload");
const showModalButton = document.getElementById("showModalButton");

// 占い結果の画像データを生成
function captureTarotResult() {
  const tarotPage = document.querySelector(".tarot-page");

  // 必要なデータ
  const tarotResult = document.querySelector(".card-description").innerText; // 実際の結果に変更

  setTimeout(() => {
    // canvasとしてページ全体をキャプチャ
    html2canvas(tarotPage, {
      backgroundColor: "#044b74", // 任意の背景色を指定
    }).then((canvas) => {
      const ctx = canvas.getContext("2d");
      // 画面の中央部分を取得 (例: 中央300x300の領域)
      const centerX = canvas.width / 2 - 175; // 中央部分から幅300px分
      const centerY = canvas.height / 2 - 300; // 中央部分から高さ300px分

      // 中央部分を切り抜くために新しいCanvasを作成
      const croppedCanvas = document.createElement("canvas");
      const croppedCtx = croppedCanvas.getContext("2d");

      croppedCanvas.width = 350; // 切り抜く領域の幅
      croppedCanvas.height = 600; // 切り抜く領域の高さ

      // 元のキャンバスから中央部分をコピー
      croppedCtx.drawImage(canvas, centerX, centerY, 350, 600, 0, 0, 350, 600);

      // JPEG形式で画像データを取得（第2引数で圧縮率を指定: 0.0 - 1.0）
      imgData = croppedCanvas.toDataURL("image/jpeg", 0.8); // 圧縮率を0.8に設定

      // 画像データをサーバーに送信
      fetch("../backend/save_image.php", {
        method: "POST",
        body: JSON.stringify({
          imgData: imgData,
          user_name: userName,
          tarot_result: tarotResult,
        }),
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("HTTPエラー " + response.status);
          }
          return response.json();
        })
        .then((data) => {
          if (data.success) {
            alert("画像を保存しました！");
          } else {
            console.error("サーバーエラー:", data.error); // サーバーのエラーメッセージを表示
            alert("エラーが発生しました。");
          }
        })
        .catch((error) => {
          console.error("エラー:", error);
          alert("リクエストに失敗しました。");
        });
    });
  }, 1000); // 1000ミリ秒（1秒後にキャプチャ）、アニメーション時間に合わせて調整
}

function downloadTarotResultImage() {
  if (imgData) {
    // ダウンロードリンクを作成
    const downloadLink = document.createElement("a");
    downloadLink.href = imgData;
    downloadLink.download = "tarot_result.jpg"; // ダウンロードするファイル名
    downloadLink.style.display = "none";

    // ダウンロードリンクをDOMに追加し、クリックしてダウンロード
    document.body.appendChild(downloadLink);
    downloadLink.click();

    // ダウンロード後、リンクをDOMから削除
    document.body.removeChild(downloadLink);
  } else {
    alert("画像がまだ生成されていません。まず画像を生成してください。");
  }
}

// ダウンロードを確認するモーダルを表示する関数
function showDownloadModal(imgSrc) {
  // 画像をモーダルに表示
  modalImage.src = imgSrc;

  // モーダルを表示
  downloadModal.style.display = "block";
}

// ダウンロードボタンを押したときのイベント
confirmDownloadButton.addEventListener("click", () => {
  // ダウンロードを実行
  downloadTarotResultImage();

  // モーダルを閉じる
  downloadModal.style.display = "none";
});

// キャンセルボタンを押したときのイベント
cancelDownloadButton.addEventListener("click", () => {
  downloadModal.style.display = "none";
});

// 背景クリックでモーダルを閉じる処理
window.addEventListener("click", (event) => {
  if (event.target == downloadModal) {
    downloadModal.style.display = "none";
  }
});

// モーダル表示ボタンのクリックイベント
showModalButton.addEventListener("click", () => {
  if (imgData) {
    showDownloadModal(imgData);
  } else {
    alert("画像がまだ生成されていません。まず画像を生成してください。");
  }
});
