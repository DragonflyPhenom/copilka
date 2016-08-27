<?php
session_start();
unset($_SESSION['error']);
unset($_SESSION['login']);
unset($_SESSION['user_id']);
setcookie("auto", "", time()+9999999);
setcookie("login", "", time()+9999999);
setcookie("password", "", time()+9999999);
setcookie("id", "", time()+9999999);

header('Location: index.php');
?>
