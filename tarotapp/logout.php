<?php
session_start();
session_destroy(); // セッションを破棄
header("Location: ./index.php"); // index.phpにリダイレクト
exit();
