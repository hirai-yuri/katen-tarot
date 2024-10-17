<?php
session_start();
unset($_SESSION['user_id']); // 特定のセッション変数を削除
header("Location: ./index.php");
exit();
