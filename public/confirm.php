<!-- <link rel="stylesheet" href="../css/confirm.css"> -->
<link rel="stylesheet" href="./css/Q&A_mobile.css">
<link rel="stylesheet" href="./css/Q&A_web.css">
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
	<form action="Q&A.php" method="post" class="text-from" name="form">
		<h2>お問い合わせ内容確認</h2>
		<div class="form-area">
			<p>名前</p>
			<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>
		</div>
		<div class="form-area">
			<p>メールアドレス</p>
			<?php echo htmlspecialchars($Email, ENT_QUOTES, 'UTF-8'); ?>
		</div>
		<div class="form-area">
			<p>お問い合わせ理由</p>
			<?php echo $reason; ?>
		</div>
		<div class="form-area">
			<p>お問い合わせ内容</p>
			<?php echo nl2br(htmlspecialchars($address, ENT_QUOTES, 'UTF-8')); ?>
		</div>
		<div class="form-area">
			<input type='button' onclick='history.back()' value='戻る' class="btn-border">
			<input type="submit" id="Flere210" name="lord" value="送信" class="btn-border">
			<div id="loading">
				<div class="kvArea" id="loading_logo">
					<div class="img_box"><img src="./svg/829.svg" alt="太極図" class="salvare"></div>
				</div>
				<div id="loading_text"></div>
			</div>
			<input type="hidden" name="name" value="<?php echo $name; ?>">
			<input type="hidden" name="Email" value="<?php echo $Email; ?>">
			<input type="hidden" name="reason" value="<?php echo $reason; ?>">
			<input type="hidden" name="address" value="<?php echo $address; ?>">
		</div>
	</form>
	<script src="./js/jquery-3.7.1.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/1.1.0/progressbar.min.js"></script>
	<script src="./js/Flere.js"></script>
</body>

</html>