<?php
	$id = $_GET['id'];
	$name = $_POST['cell'];
	$mydate = date("Y-m-d");
	$nol = 0;
  $dva = 2;
	$denga = $_POST['sumoper'];
	include 'my_con.php';
	//достаём имя
	$bank = $db->prepare("SELECT name FROM bank WHERE id = '$id'");
	$bank->execute();
	$myrow = $bank->fetch(PDO::FETCH_ASSOC);
	$namebank = $myrow['name'];
	//банк или резерв?
	if ($name == 'res'){
		$nameb = 'Резерв';
		$bank = $db->prepare("SELECT ok FROM reserv"); //Достаём сумму счёта на который переводим
		$bank->execute();
		$myrow = $bank->fetch(PDO::FETCH_ASSOC);
		$money = $myrow['ok'] + $denga; //суммируем
		$STH = $db->prepare("UPDATE reserv SET ok = '$money'"); //обновляем
		$STH->execute();
		//заносим историю
		$text = 'Перевод ('.$namebank.')';
		$stmt = $db->prepare("INSERT INTO history_res (date, plus, minus, tema, what) VALUES (:dat, :one, :two, :tema, :what)");
		$stmt->bindParam(':dat', $mydate);
		$stmt->bindParam(':one', $denga);
		$stmt->bindParam(':two', $nol);
		$stmt->bindParam(':tema', $text);
    $stmt->bindParam(':what', $dva);
		$stmt->execute();
	} else {
		$bank = $db->prepare("SELECT name,money FROM bank WHERE id = '$name'"); //Достаём сумму счёта на который переводим
		$bank->execute();
		$myrow = $bank->fetch(PDO::FETCH_ASSOC);
		$nameb = $myrow['name'];
		$money = $myrow['money'] + $denga; //суммируем
		$STH = $db->prepare("UPDATE bank SET money = '$money' WHERE id = '$name'"); //обновляем
		$STH->execute();
		//заносим историю
		$text = 'Перевод со счёта - '.$namebank;
		$stmt = $db->prepare("INSERT INTO history (bank, date, plus, minus, tema, what) VALUES (:id, :dat, :one, :two, :tema, :what)");
		$stmt->bindParam(':id', $name);
		$stmt->bindParam(':dat', $mydate);
		$stmt->bindParam(':one', $denga);
		$stmt->bindParam(':two', $nol);
		$stmt->bindParam(':tema', $text);
    $stmt->bindParam(':what', $dva);
		$stmt->execute();
	}
	//достаём сумма счёта
	$bank = $db->prepare("SELECT money FROM bank WHERE id = '$id'");
	$bank->execute();
	$myrow = $bank->fetch(PDO::FETCH_ASSOC);
	//-
	$two = $_POST['sumoper'];
	$money = $myrow['money'] - $_POST['sumoper'];
	//обновляем счёт
	$STH = $db->prepare("UPDATE bank SET money = '$money' WHERE id = '$id'");
	$STH->execute();
	//заносим историю
	$text = 'Перевод на счёт - '.$nameb;
	$stmt = $db->prepare("INSERT INTO history (bank, date, plus, minus, tema, what) VALUES (:id, :dat, :one, :two, :tema, :what)");
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':dat', $mydate);
	$stmt->bindParam(':one', $nol);
	$stmt->bindParam(':two', $denga);
	$stmt->bindParam(':tema', $text);
  $stmt->bindParam(':what', $dva);
	$stmt->execute();
	exit(header("location: bank.php?id=".$id));
?>
