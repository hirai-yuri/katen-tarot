<?php

// Q&A.php で入力された情報を確認する画面です。ユーザーは送信内容を確認して、問題がなければサーバーに送信、問題があれば戻って修正できます。
// POST データが渡されない場合、トップページにリダイレクトされます。



// POSTメソッドでリクエストされた場合のみ処理
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /public/index.php');
  exit();
}

// フォームデータの取得
$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
$reason = htmlspecialchars($_POST['reason'], ENT_QUOTES, 'UTF-8');
$address = nl2br(htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8'));
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>確認画面</title>
  <link rel="stylesheet" href="/public/css/Q&A.css">
</head>

<body>
  <div class="qa-confirm-container">
    <h1>お問い合わせ内容確認</h1>
    <div class="form-group">
      <p><strong>お名前:</strong> <?php echo $name; ?></p>
    </div>
    <div class="form-group">
      <p><strong>メールアドレス:</strong> <?php echo $email; ?></p>
    </div>
    <div class="form-group">
      <p><strong>お問い合わせ理由:</strong> <?php echo $reason; ?></p>
    </div>
    <div class="form-group">
      <p><strong>お問い合わせ内容:</strong><br><?php echo $address; ?></p>
    </div>

    <form action="/app/Controllers/Q&AController.php" method="post">
      <input type="hidden" name="name" value="<?php echo $name; ?>">
      <input type="hidden" name="email" value="<?php echo $email; ?>">
      <input type="hidden" name="reason" value="<?php echo $reason; ?>">
      <input type="hidden" name="address" value="<?php echo $address; ?>">

      <div class="form-actions">
        <button type="submit" name="confirm">送信</button>
        <button type="button" onclick="history.back()">戻る</button>
      </div>
    </form>
  </div>
</body>

</html>