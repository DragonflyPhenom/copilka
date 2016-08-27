<?php
include 'my_con.php';
$id = $_GET['id'];
//Достаём историю
$imgsql = $db->prepare("SELECT bank,plus,minus FROM history WHERE id = '$id'");
$imgsql->execute();
$rowimg = $imgsql->fetch(PDO::FETCH_ASSOC);
$bank = $rowimg['bank'];
if ($rowimg['plus'] != 0){
  $sum = $rowimg['plus'];
} else {
  $sum = 0 - $rowimg['minus'];
}
$imgsql = $db->prepare("SELECT money FROM bank WHERE id = '$bank'");
$imgsql->execute();
$rowimg = $imgsql->fetch(PDO::FETCH_ASSOC);
$money = $rowimg['money'] - $sum;
//Заносим деньги в банк
$STH = $db->prepare("UPDATE bank SET money = '$money' WHERE id = '$bank'");
$STH->execute();
//удалить счёт
$sql = "DELETE FROM history WHERE id =  :myid";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':myid', $_GET['id'], PDO::PARAM_INT);
	$stmt->execute();
//удалить историю
$sql = "DELETE FROM his_img WHERE id_oper =  :myid";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':myid', $_GET['id'], PDO::PARAM_INT);
	$stmt->execute();
exit(header('Location: dohras.php'));
?>
