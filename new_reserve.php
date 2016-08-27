<?php
	include 'my_con.php';
	$mon = $_POST['sum'];
	$STH = $db->prepare("UPDATE reserv SET min = '$mon' WHERE id = '1'");
	$STH->execute();
?>