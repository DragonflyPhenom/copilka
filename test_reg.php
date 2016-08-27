<?php
    session_start();
if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} }
if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
if (empty($login) or empty($password))
    {
    $_SESSION['error'] = "Вы не ввели все данные";
	exit(header('Location: index.php'));
    }
////////////////////
if  (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $login))
    {
		$_SESSION['error'] = "Не правильно введён Email";
exit(header('Location: index.php'));

	}
	$password = stripslashes($password);
    $password = htmlspecialchars($password);
    $password = trim($password);
//21
   include "my_con.php";
/////////////////////
$id_test1 = $db->query("SELECT id FROM users WHERE Email = '$login' AND Password = '$password' AND active = 1");
    $id_test1->setFetchMode(PDO::FETCH_ASSOC);
    $myrow1 = $id_test1->fetch();
    $id_test1 = $myrow1['id'];
if (!empty($id_test1)) {
    unset($_SESSION['error']);
    $_SESSION['login']=$login;
    $_SESSION['user_id'] = $id_test1;
//////////////////////////////
	setcookie("auto", "yes", time()+9999999);
            setcookie("login", $login, time()+9999999);
            setcookie("password", $password, time()+9999999);
            setcookie("id", $id_test1, time()+9999999);
////////////////////////////////
	exit(header('Location: main.php'));
}
    $_SESSION['error'] = "Такой Email и пароль не зарегистрирован";
    exit(header('Location: index.php'));
?>
