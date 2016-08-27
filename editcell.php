<?php
  $id = $_POST['id'];
  $text = $_POST['text'];
  $sum = $_POST['sum'];
  include 'my_con.php';
  $STH = $db->prepare("UPDATE cell SET tema = '$text', sum = '$sum' WHERE id = '$id'");
  $STH->execute();
  echo 'ok!';
?>
