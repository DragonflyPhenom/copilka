<?php
	$name = $_POST['cell']; //id банка в который переводим
	$mydate = date("Y-m-d");
	$nol = 0; // ноль
	$dva = 2;
	$denga = $_POST['sumoper']; // сумма перевода
	include 'my_con.php';
		$bank = $db->prepare("SELECT name,money FROM bank WHERE id = '$name'"); //Достаём сумму счёта на который переводим
		$bank->execute();
		$myrow = $bank->fetch(PDO::FETCH_ASSOC);
		$nameb = $myrow['name'];
		$money = $myrow['money'] + $denga; //суммируем
		$STH = $db->prepare("UPDATE bank SET money = '$money' WHERE id = '$name'"); //обновляем
		$STH->execute();
		//заносим историю
		$text = 'Перевод из резерва';
		$stmt = $db->prepare("INSERT INTO history (bank, date, plus, minus, tema) VALUES (:id, :dat, :one, :two, :tema, :what)");
		$stmt->bindParam(':id', $name);
		$stmt->bindParam(':dat', $mydate);
		$stmt->bindParam(':one', $denga);
		$stmt->bindParam(':two', $nol);
		$stmt->bindParam(':tema', $text);
		$stmt->bindParam(':what', $dva);
		$stmt->execute();
	//достаём сумма счёта
	$bank = $db->prepare("SELECT ok FROM reserv WHERE id = '1'");
	$bank->execute();
	$myrow = $bank->fetch(PDO::FETCH_ASSOC);
	//-
	$two = $_POST['sumoper'];
	$money = $myrow['ok'] - $_POST['sumoper'];
	//обновляем счёт
	$STH = $db->prepare("UPDATE reserv SET ok = '$money' WHERE id = '1'");
	$STH->execute();
	//заносим историю
	$text = 'Перевод на '.$nameb;
	$stmt = $db->prepare("INSERT INTO history_res (date, plus, minus, tema, what) VALUES (:dat, :one, :two, :tema, :what)");
	$stmt->bindParam(':dat', $mydate);
	$stmt->bindParam(':one', $nol);
	$stmt->bindParam(':two', $denga);
	$stmt->bindParam(':tema', $text);
	$stmt->bindParam(':what', $dva);
	$stmt->execute();
	exit(header("location: reserve.php"));
?>
