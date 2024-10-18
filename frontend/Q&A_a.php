<?php
?>
<!DOCTYPE html>
<html lang="Ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="../css/Q&A.css"> -->
  <link rel="stylesheet" href="../css/Q&A_mobile.css">
  <link rel="stylesheet" href="../css/Q&A_web.css">
  <title>Q&A</title>
</head>

<body>
    <form action="./confirm.php" method="post" class="mailform">
      <h2>質問メール</h2>

      <div class="tarot-area">
        <p><span class="required">名前</span></p>
        <input type="text" name="name" class="input-pro" placeholder="例）木崎　鈴里" required>
      </div>

      <div class="tarot-area">
        <p><span class="required">メールアドレス</span></p>
        <input type="email" name="Email" class="input-pro" placeholder="例）abc@abc.com" required>
      </div>

      <div class="tarot-area">
        <p>お問い合わせ理由</p>
        <select name="reason" id="ALM">
        <option value="相談内容">相談内容</option>
        <option value="全体運">全体運</option>
        <option value="恋愛相談">恋愛相談</option>
        <option value="相手の心">相手の気持ち</option>
        <option value="その他">その他</option>
      </select>
      </div>

      <div class="tarot-area">
        <p> <span class="required">お問い合わせ内容</span></p>
        <textarea name="address" rows="5" placeholder="例）具体的な内容を記載" required></textarea>
      </div>
      <div class="tarot-area" id="submit">
        <input type="button" onclick="location.href='index.php'" value="トップへ戻る" class="btn-border" >
        <input type="submit" name="submit" value="確認画面へ" class="btn-border">
      <!-- <p><a href="index.php" class="return-top">お問い合わせトップへ 
      </a></p> -->
      </div>
    </form>
    
 
    <script src="../js/Q&A.js"></script>
</body>

</html>