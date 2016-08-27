<?php
try{
	$DBH = new PDO("mysql:host=localhost;dbname=cop", root, '');
}
catch(PDOException $e) {
    echo $e->getMessage();
}
if (mysqli_connect_errno()) {
    printf("Подключение невозможно: %s\n", mysqli_connect_error());
    exit();
}
if (isset($_GET['code'])){
	$code =$_GET['code'];
}
else {
	exit("Вы зашли на страницу без кода подтверждения!");
}
if (isset($_GET['id'])) {
	$id=$_GET['id'];
}
else {
	exit("Вы зашли на страницу без id!");
}
$activation = $id;
if ( $activation == $code ) {
	$STH = $DBH->prepare("UPDATE users set active = '1' where id=$id");
	$STH->execute();
	///
	$nol = 0;
	$noli = 10000;
	$stmt = $db->prepare("INSERT INTO reserv (min, ok, user) VALUES (:id, :dat, :one)");
	$stmt->bindParam(':id', $noli);
	$stmt->bindParam(':dat', $nol);
	$stmt->bindParam(':one', $id);
	$stmt->execute();
	///
	$_SESSION['login']=$login;
	$_SESSION['user_id'] = $id_test1;
//////////////////////////////
	setcookie("auto", "yes", time()+9999999);
	setcookie("login", $login, time()+9999999);
	setcookie("password", $password, time()+9999999);
	setcookie("id", $id_test1, time()+9999999);
////////////////////////////////
	///
	$_SESSION['error'] = "Ваш Email подтверждён";
	header('Location: main.php');
	exit();
}
else {
	echo "Ошибка! Ваш Е-мейл не подтвержден! <a href='index.php'>Главная страница</a>";
}
?>
