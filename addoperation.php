<?php
	$id = $_GET['id'];
	$name = $_POST['nameoper'];
	$hwo = $_POST['hwo'];
	$mydate = date("Y-m-d");
	include 'my_con.php';
	//достаём сумма счёта
	$bank = $db->prepare("SELECT money FROM bank WHERE id = '$id'");
	$bank->execute();
	$myrow = $bank->fetch(PDO::FETCH_ASSOC);
	//+ или -
	if ($hwo == 'net'){
		$one = '0';
		$two = $_POST['sumoper'];
		$money = $myrow['money'] - $_POST['sumoper'];
	} else {
		$one = $_POST['sumoper'];
		$two = '0';
		$money = $myrow['money'] + $_POST['sumoper'];
	}
	//обновляем счёт
	$STH = $db->prepare("UPDATE bank SET money = '$money' WHERE id = '$id'");
	$STH->execute();
	//заносим историю
	$stmt = $db->prepare("INSERT INTO history (bank, date, plus, minus, tema) VALUES (:id, :dat, :one, :two, :tema)");
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':dat', $mydate);
	$stmt->bindParam(':one', $one);
	$stmt->bindParam(':two', $two);
	$stmt->bindParam(':tema', $name);
	$stmt->execute();
	exit(header("location: bank.php?id=".$id));
?>