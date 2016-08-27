<?php
	$id = $_POST['id'];
	$money = $_POST['money'];
	$hoo = $_POST['hoo'];
	$che = $_POST['che'];
	//подключаем БД и обновляем бабки в банке
	include 'my_con.php';
	$STH = $db->prepare("UPDATE bank SET money = '$money' WHERE id = '$id'");
	$STH->execute();
	//заносим в историю
	//если минус
	if ($hoo == 'mn'){
		$one = '0';
		$two = $che;
	} else {
		$one = $che;
		$two = '0';
	}
	$mydate = date("Y-m-d");
	$stmt = $db->prepare("INSERT INTO history (bank, date, plus, minus) VALUES (:id, :dat, :one, :two)");
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':dat', $mydate);
	$stmt->bindParam(':one', $one);
	$stmt->bindParam(':two', $two);
	$stmt->execute();
?>