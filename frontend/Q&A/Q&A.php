<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to='yoshinori52671';
$name = $_POST['name'];
$birthday = $_POST['birthday'];
$Email = $_POST['Email'];
$THOTH = $_POST['THOTH'];
$address = $_POST['address'];
$Mail = "From: {$Email}\nReply-To: {$Email}\nContent-Type: text/plain;";
$result = mb_send_mail(

  $name,       // 名前
  $birthday,  // 生年月日
  $Email,  // メアド
  $THOTH,   // 案件
  $address  //記載欄

);

if (mb_send_mail($name, $birthday, $Email, $THOTH, $address, $Mail)) {
  echo "メール送信成功です";
} elseif (empty($_POST['check_data'])) {
  echo "未記入があります。";
} else {
  echo "メール送信失敗です";
}
