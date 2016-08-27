<?php
	$name = $_POST['name'];
	$id = $_POST['id'];
	//вносим инфу в БД
	include 'my_con.php';
	//
	$STH = $db->prepare("UPDATE bank SET name = '$name' WHERE id = '$id'");
	$STH->execute();
?>