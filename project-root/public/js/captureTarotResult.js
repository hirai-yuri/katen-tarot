let imgData = null;

const downloadModal = document.getElementById("downloadModal");
const modalImage = document.getElementById("modalImage");
const confirmDownloadButton = document.getElementById("confirmDownload");
const cancelDownloadButton = document.getElementById("cancelDownload");
const showModalButton = document.getElementById("showModalButton");

function captureTarotResult(tarotPageId) {
  const tarotPage = document.getElementById(tarotPageId);
  const tarotResult = document.querySelector(".card-description").innerText;

  const scale = window.devicePixelRatio || 1;
  const viewportWidth = window.innerWidth;
  const viewportHeight = window.innerHeight;

  html2canvas(tarotPage, {
    backgroundColor: "#044b74",
    scale: scale,
  }).then((canvas) => {
    const ctx = canvas.getContext("2d");

    const centerX = viewportWidth / 2 - 200;
    const centerY = viewportHeight / 2 - 400;

    const croppedCanvas = document.createElement("canvas");
    const croppedCtx = croppedCanvas.getContext("2d");

    croppedCanvas.width = 400;
    croppedCanvas.height = 800;

    croppedCtx.drawImage(
      canvas,
      centerX,
      centerY,
      croppedCanvas.width,
      croppedCanvas.height,
      0,
      0,
      croppedCanvas.width,
      croppedCanvas.height
    );

    imgData = croppedCanvas.toDataURL("image/jpeg");
    modalImage.src = imgData;
    downloadModal.style.display = "flex";

    confirmDownloadButton.addEventListener("click", () => {
      const link = document.createElement("a");
      link.href = imgData;
      link.download = `tarot_result_${Date.now()}.jpg`;
      link.click();
      downloadModal.style.display = "none";
    });

    cancelDownloadButton.addEventListener("click", () => {
      downloadModal.style.display = "none";
    });
  });
}

showModalButton.addEventListener("click", () => {
  downloadModal.style.display = "flex";
});
