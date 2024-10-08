function captureTarotResult() {
  // 1. tarotPageが正しく取得できているか確認
  const tarotPage = document.querySelector(".tarot-page");
  console.log("Tarot page element:", tarotPage); // デバッグ用ログ

  // 必要なデータ
  const tarotResult = document.querySelector(".card-description").innerText; // 実際の結果に変更

  // デバッグ: 取得した値をコンソールに表示
  console.log("User Name:", userName);
  console.log("Tarot Result:", tarotResult);

  setTimeout(() => {
    // canvasとしてページ全体をキャプチャ
    html2canvas(tarotPage, {
      // scale: 2, // スケーリング。解像度を2倍にして、より高品質な画像にする
      // width: 300, // 固定幅 (ピクセル単位)
      // height: 600, // 固定高さ (ピクセル単位)
      backgroundColor: "#044b74", // 任意の背景色を指定
    }).then((canvas) => {
      const ctx = canvas.getContext("2d");

      // キャンバスのサイズはブラウザの表示サイズに対応しています
      console.log("キャンバス全体のサイズ:", canvas.width, canvas.height);

      // 画面の中央部分を取得 (例: 中央300x300の領域)
      const centerX = canvas.width / 2 - 175; // 中央部分から幅300px分
      const centerY = canvas.height / 2 - 300; // 中央部分から高さ300px分

      // 中央部分を切り抜くために新しいCanvasを作成
      const croppedCanvas = document.createElement("canvas");
      const croppedCtx = croppedCanvas.getContext("2d");

      console.log("画面の中央部分を取得", canvas.width, canvas.height);

      croppedCanvas.width = 350; // 切り抜く領域の幅
      croppedCanvas.height = 600; // 切り抜く領域の高さ

      // 元のキャンバスから中央部分をコピー
      croppedCtx.drawImage(canvas, centerX, centerY, 350, 600, 0, 0, 350, 600);

      // JPEG形式で画像データを取得（第2引数で圧縮率を指定: 0.0 - 1.0）
      const imgData = croppedCanvas.toDataURL("image/jpeg", 0.8); // 圧縮率を0.8に設定

      // データが正しく生成されているか確認
      console.log("Image Data:", imgData);

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
