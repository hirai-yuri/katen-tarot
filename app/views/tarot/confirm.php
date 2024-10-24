<?php

// タロット占いの確認ページ。ユーザーが選択した占いの種類と名前を表示し、結果を送信する確認画面です。

// POSTメソッドでリクエストされた場合のみ処理
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /public/index.php');
  exit();
}

// フォームデータの取得
$tarotType = htmlspecialchars($_POST['tarot_type'], ENT_QUOTES, 'UTF-8');
$userName = htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>占い結果確認</title>
  <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>
  <div class="tarot-confirm-container">
    <h1>タロット占い結果確認</h1>
    <p>ユーザー名: <?php echo $userName; ?></p>
    <p>占いタイプ: <?php echo $tarotType; ?></p>

    <form action="/app/Controllers/TarotController.php" method="post">
      <input type="hidden" name="user_name" value="<?php echo $userName; ?>">
      <input type="hidden" name="tarot_type" value="<?php echo $tarotType; ?>">

      <div class="form-actions">
        <button type="submit" name="confirm">占い結果を送信</button>
        <button type="button" onclick="history.back()">戻る</button>
      </div>
    </form>
  </div>
</body>

</html>