<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$name = $_POST['name'];
$birthday = $_POST['birthday'];
$Email = $_POST['Email'];
$THOTH = $_POST['THOTH'];
$address = $_POST['address'];
$gmail = "From: yoshinori52671@gmail.com";

if (mb_send_mail($name, $birthday, $Email, $THOTH, $address, $gmail)) {
  echo "メール送信成功です";
} elseif (empty($_POST['check_data'])) {
  echo "未記入があります。";
} else {
  echo "メール送信失敗です";
}
