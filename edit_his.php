<?php
  $id = $_POST['id'];
  $text = $_POST['text'];
  $money = $_POST['money'];
  $newname = $_POST['name'];
  include 'my_con.php';
  //достаём деньги
  $infosql = $db->prepare("SELECT plus,minus,bank FROM history WHERE id = '$id'");
  $infosql->execute();
  $myinfo = $infosql->fetch(PDO::FETCH_ASSOC);
  $bank = $myinfo['bank'];
  if ($myinfo['plus'] != 0){
    $banksql = $db->prepare("SELECT money FROM bank WHERE id = '$bank'");
    $banksql->execute();
    $mybank = $banksql->fetch(PDO::FETCH_ASSOC);
    $sum = $money - $myinfo['plus'];
    $newsum = $mybank['money'] + $sum;
    //обновляем банк
    $STH = $db->prepare("UPDATE bank SET money = '$newsum' WHERE id = '$bank'");
    $STH->execute();
    //обновляем историю
    $STH = $db->prepare("UPDATE history SET plus = '$money', comment = '$text', tema = '$newname' WHERE id = '$id'");
    $STH->execute();
    echo 'plus';
  } else {
    $banksql = $db->prepare("SELECT money FROM bank WHERE id = '$bank'");
    $banksql->execute();
    $mybank = $banksql->fetch(PDO::FETCH_ASSOC);
    $sum = $money - $myinfo['minus'];
    $newsum = $mybank['money'] - $sum;
    //обновляем банк
    $STH = $db->prepare("UPDATE bank SET money = '$newsum' WHERE id = '$bank'");
    $STH->execute();
    //обновляем историю
    $STH = $db->prepare("UPDATE history SET minus = '$money', comment = '$text', tema = '$newname' WHERE id = '$id'");
    $STH->execute();
    echo 'minus';
  }
?>
