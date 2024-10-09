<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  $sql = "SELECT user_name, tarot_result, image_path, tarot_type FROM tarot_results WHERE user_name = '$userName'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<div>";
      echo "<h3>" . $row["tarot_type"] . "</h3>";
      echo "<p>" . $row["tarot_result"] . "</p>";
      echo "<img src='" . $row["image_path"] . "' alt='タロット結果画像'>";
      echo "</div>";
    }
  }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
  <script src="./js/cardData.js"></script>
  <script src="./js/stars.js"></script>
  <script src="./js/dialogue.js"></script>
  <script src="./js/app.js"></script>
  <script src="./js/captureTarotResult.js"></script>
</body>

</html>