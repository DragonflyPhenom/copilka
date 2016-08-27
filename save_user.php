<?php
	$mydate = date("Y-m-d");
	session_start();
	if (isset($_POST['login'])) { $login=$_POST['login']; if ($login =='') { unset($login);} }
	if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
 if (empty($password) or empty($login))
    {
	$_SESSION['error'] = 'Вы не ввели все данные';
    header('Location: index.php');
    exit ();
    }
if  (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $login))
    {
	$_SESSION['error'] = 'Вы не ввели правильный Email';
    header('Location: index.php');
	exit();
	}

 	$password = stripslashes($password);
    $password = htmlspecialchars($password);

    $password = trim($password);

	if (strlen($password) > 15 || strlen($password) < 3) {
		$_SESSION['error'] = 'Пароль должен быть не более 15 и не менее 3 знаков';
		header('Location: index.php');
		exit();
	}

    include ("my_con.php");
		$bank = $db->prepare("SELECT id FROM users WHERE email = '$login'");
		$bank->execute();
		$myrow = $bank->fetch(PDO::FETCH_ASSOC);
    if (!empty($myrow['id'])) {
	$_SESSION['error'] = 'Такой Email уже зарегистрирован';
    header('Location: index.php');
	exit();
    }
		$stmt = $db->prepare("INSERT INTO users (email, password, datereg) VALUES (:id, :dat, :one)");
		$stmt->bindParam(':id', $login);
		$stmt->bindParam(':dat', $password);
		$stmt->bindParam(':one', $mydate);
		$stmt->execute();

		$bank = $db->prepare("SELECT id FROM users WHERE email = '$login'");
		$bank->execute();
		$myrow = $bank->fetch(PDO::FETCH_ASSOC);
    $activation = $myrow['id'];
	  $mycode = $myrow['id'];
 		$subject = "Подтверждение регистрации";
    $message = "Здравствуйте! Спасибо за регистрацию на to-des.ru.\n
            		Перейдите по ссылке, чтобы активировать ваш аккаунт:\n http://to-des.ru/activation.php?id=".$mycode."&code=".$activation."\nС уважением,\n
            		Администрация сайта\n
								Пожалуйста не отвечайте на это письмо.";
    mail($login,$subject, $message);

		$_SESSION['error'] = "Вам было отправленно письмо с подтверждением регистрации";
  	header('Location: index.php');
		exit();
?>
