<link rel="stylesheet" href="../css/confirm.css">
<?php
//直リンクされた場合index.phpにリダイレクト
if ($_SERVER["REQUEST_METHOD"] != "POST") {
	header("Location: Q&A_a.php");
	exit();
}

//各項目を内容を取得
$name = $_POST['name'];
$Email = $_POST['Email'];
$address = $_POST['address'];
$reason = $_POST['reason'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>確認画面</title>
</head>

<body>
	<form action="Q&A.php" method="post" class="text-from">
		<h2>お問い合わせ内容確認</h2>
		<div class="tarot-area">
			<p>名前</p>
			<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>
		</div>
		<div class="tarot-area">
			<p>メールアドレス</p>
			<?php echo htmlspecialchars($Email, ENT_QUOTES, 'UTF-8'); ?>
		</div>
		<div class="tarot-area">
			<p>お問い合わせ理由</p>
			<?php echo $reason; ?>
		</div>
		<div class="tarot-area">
			<p>お問い合わせ内容</p>
			<?php echo nl2br(htmlspecialchars($address, ENT_QUOTES, 'UTF-8')); ?>
		</div>
		<div class="tarot-area">
			<input type='button' onclick='history.back()' value='戻る' class="btn-border">
			<input type="submit" name="submit" value="送信" class="btn-border">
			<input type="hidden" name="name" value="<?php echo $name; ?>">
			<input type="hidden" name="Email" value="<?php echo $Email; ?>">
			<input type="hidden" name="reason" value="<?php echo $reason; ?>">
			<input type="hidden" name="address" value="<?php echo $address; ?>">
		</div>
	</form>
</body>

</html>