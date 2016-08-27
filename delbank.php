<?php
include 'my_con.php';
//удалить счёт
$sql = "DELETE FROM bank WHERE id =  :myid";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':myid', $_GET['id'], PDO::PARAM_INT);   
	$stmt->execute();
//удалить историю
$sql = "DELETE FROM history WHERE bank =  :myid";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':myid', $_GET['id'], PDO::PARAM_INT);   
	$stmt->execute();
exit(header('Location: index.php'));
?>