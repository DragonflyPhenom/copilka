<?php
  include 'my_con.php';
  $name = $_POST['name'];
  $mon = $_POST['mon'];
  $mydate = date("Y-m-d");
  $stmt = $db->prepare("INSERT INTO cell (tema, date, sum) VALUES (:id, :dat, :one)");
	$stmt->bindParam(':id', $name);
	$stmt->bindParam(':dat', $mydate);
  $stmt->bindParam(':one', $mon);
	$stmt->execute();
?>
