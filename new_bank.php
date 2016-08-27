<?php
	$name = $_POST['name_bank'];
	$money = $_POST['money_bank'];
	//вносим инфу в БД
	include 'my_con.php';
	//
	$mydate = date("Y-m-d");
	$stmt = $db->prepare("INSERT INTO bank (name, money, date) VALUES (:name, :money, :dat)");
	$stmt->bindParam(':name', $name);
	$stmt->bindParam(':money', $money);
	$stmt->bindParam(':dat', $mydate);
	$stmt->execute();
	exit(header('Location: index.php'));
?>