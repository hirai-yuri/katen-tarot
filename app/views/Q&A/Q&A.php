<!-- 質問フォームの画面を提供しています。ユーザーは名前、メールアドレス、問い合わせ内容などを入力して確認画面に進むことができます。
フォームの送信先は Q&AController.php に設定されています。 -->


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Q&A</title>
  <link rel="stylesheet" href="/public/css/Q&A.css">
</head>

<body>
  <div class="qa-form-container">
    <h1>質問フォーム</h1>
    <form action="/app/Controllers/Q&AController.php" method="post">
      <div class="form-group">
        <label for="name">お名前:</label>
        <input type="text" id="name" name="name" required>
      </div>

      <div class="form-group">
        <label for="email">メールアドレス:</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="reason">お問い合わせ内容:</label>
        <select id="reason" name="reason">
          <option value="相談内容">相談内容</option>
          <option value="全体運">全体運</option>
          <option value="恋愛相談">恋愛相談</option>
          <option value="相手の気持ち">相手の気持ち</option>
          <option value="その他">その他</option>
        </select>
      </div>

      <div class="form-group">
        <label for="address">詳細内容:</label>
        <textarea id="address" name="address" rows="5" required></textarea>
      </div>

      <div class="form-actions">
        <button type="submit">確認画面へ</button>
        <button type="button" onclick="history.back()">キャンセル</button>
      </div>
    </form>
  </div>
  <script src="/public/js/Q&A.js"></script>
</body>

</html>