<?php
	$name = $_POST['nameoper'];
	$hwo = $_POST['hwo'];
	$mydate = date("Y-m-d");
	include 'my_con.php';
	//достаём сумма счёта
	$bank = $db->prepare("SELECT ok FROM reserv WHERE id = '1'");
	$bank->execute();
	$myrow = $bank->fetch(PDO::FETCH_ASSOC);
	//+ или -
	if ($hwo == 'net'){
		$one = '0';
		$two = $_POST['sumoper'];
		$money = $myrow['ok'] - $_POST['sumoper'];
	} else {
		$one = $_POST['sumoper'];
		$two = '0';
		$money = $myrow['ok'] + $_POST['sumoper'];
	}
	//обновляем счёт
	$STH = $db->prepare("UPDATE reserv SET ok = '$money' WHERE id = '1'");
	$STH->execute();
	//заносим историю
	$stmt = $db->prepare("INSERT INTO history_res (date, plus, minus, tema) VALUES (:dat, :one, :two, :tema)");
	$stmt->bindParam(':dat', $mydate);
	$stmt->bindParam(':one', $one);
	$stmt->bindParam(':two', $two);
	$stmt->bindParam(':tema', $name);
	$stmt->execute();
	exit(header("location: reserve.php"));
?>