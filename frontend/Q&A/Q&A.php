<?php
//直リンクされた場合index.phpにリダイレクト
if($_SERVER["REQUEST_METHOD"] != "POST"){
	header("Location: Q&A.html");
	exit();
}
mb_language("Japanese");
mb_internal_encoding("UTF-8");

// 
$to="yoshinori52671@gmail.com";
$Mail = 'yoshinori52671@gmail.com';
$name = $_POST['name'];
$Email = $_POST['Email'];
$sex = $_POST['sex'];
$address = $_POST['address'];

$message = <<<EOF
お問い合わせありがとうございました。

以下の内容で承りました。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
【お名前】
{$_POST['name']}

【メールアドレス】
{$_POST['Email']}

【性別】
{$_POST['sex']}

【お問い合わせ理由】
{$_POST['reason']}

【お問い合わせ内容】
{$_POST['address']}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
EOF;

$headers = "From: {$Mail}\nReply-To: {$Mail}\nContent-Type: text/plain;";
//メール送信
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
 	<p><a href="Q&A.html">お問い合わせトップへ</p>
</body>
</html>