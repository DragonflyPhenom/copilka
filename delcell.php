<?php
include 'my_con.php';
//удалить счёт
$sql = "DELETE FROM cell WHERE id =  :myid";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':myid', $_POST['name'], PDO::PARAM_INT);
	$stmt->execute();
  echo 'ok!';
?>
