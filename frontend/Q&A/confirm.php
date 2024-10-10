<?php
//直リンクされた場合index.phpにリダイレクト
if ($_SERVER["REQUEST_METHOD"] != "POST") {
	header("Location: Q&A.html");
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
	<title>確認画面</title>
	<style type="text/css">
		body {
			height: 100vh;
			width: 100%;
			background-image: url(../img/35_R_Member-registration画像.jpg);
			background-repeat: no-repeat;
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		.tarot-area {
			margin-bottom: 20px;
			width: 100%;
			min-width: 200px;
			height: 30px;
			padding-left: 10px;
			padding-right: 10px;

		}

		p {
			font-weight: bold;
			font-size: 20px;
			/* border-bottom: 5px solid #000; */
			padding-top: 20px;
		}

		.text-from {
			background-color: #eae5e3;
			margin-top: 250px;
			padding: 35px;
			border: 2px solid #000;


		}

		.text-from h2 {
			font-size: 20px;
		}

		.btn-border {
			display: inline-block;
			max-width: 180px;
			text-align: left;
			border: 2px solid #9ec34b;
			font-size: 15px;
			color: #9ec34b;
			text-decoration: none;
			font-weight: bold;
			padding: 8px 16px;
			border-radius: 4px;
			transition: .4s;
		}

		.btn-border:hover {
			background-color: #9ec34b;
			border-color: #cbe585;
			color: #FFF;
		}

		@media(min-width:410px) {
			body {
				background-image: url(../img/25_Member-registration画像.jpg);
				align-items: center;
			}

			.tarot-area {
				width: 180px;
				min-width: 270px;
				height: 40px;
			}

			p {
				font-size: 15px;
			}

			.tarot-area p .required::after {
				content: '必須';
				font-size: 13px;
				color: crimson;
				margin-left: 10px;
			}

			textarea {
				width: 450px;
				height: 200px;
				overflow-y: scroll;
			}
			.btn-border {
			display: inline-block;
			max-width: 180px;
			text-align: left;
			border: 2px solid #9ec34b;
			font-size: 15px;
			color: #9ec34b;
			text-decoration: none;
			font-weight: bold;
			padding: 8px 16px;
			border-radius: 4px;
			transition: .4s;
		}

		.btn-border:hover {
			background-color: #9ec34b;
			border-color: #cbe585;
			color: #FFF;
		}

		}
	</style>
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