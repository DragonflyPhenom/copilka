<?php
    try{
	$db = new PDO('mysql:host=localhost;dbname=cop', 'root', "");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("set names utf8");
	}
	catch(PDOException $e){
	echo $e->getMessage();
	}
?>
