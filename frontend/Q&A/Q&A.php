<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");

// 
$to="yoshinori52671@gmail.com";
$Mail = 'yoshinori52671@gmail.com';
$name = $_POST['name'];
$birthday = $_POST['birthday'];
$Email = $_POST['Email'];
$THOTH = $_POST['THOTH'];
$address = $_POST['address'];
$message = <<<EOF
名前：{$name}
生年月日：{$birthday}
メールアドレス:{$Email}
占い内容：{$THOTH}
記入欄：{$address}
EOF;
$headers = "From: {$Mail}\nReply-To: {$Mail}\nContent-Type: text/plain;";
mb_send_mail($to, $Mail,$message,$headers);
// if (mb_send_mail($to, $Mail,$message,$headers)) {
//   echo "メール送信成功です";
// } elseif (empty($_POST['check_data'])) {
//   echo "未記入があります。";
// } else {
//   echo "メール送信失敗です";
// }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>完了画面</title>
<style type="text/css">
	body {
		background-color: #f9fff2;
	}
</style>
</head>
<body>
	<h2>お問い合わせ完了</h2>
 	<p>お問い合わせありがとうございました。</p>
 	<p>今後とも当サイトをよろしくお願いいたします。</p>
 	<p><a href="index.php">お問い合わせトップへ</p>
</body>
</html>