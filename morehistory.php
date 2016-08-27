<?php
$idpost = $_POST['infa'];
include 'my_con.php';
// Достаём данные
$infosql = $db->prepare("SELECT plus,minus,bank,comment,tema FROM history WHERE id = '$idpost'");
$infosql->execute();
$myinfo = $infosql->fetch(PDO::FETCH_ASSOC);
//Достаём имя банка
$nameb = $myinfo['bank'];
$bnamesql = $db->prepare("SELECT name FROM bank WHERE id = '$nameb'");
$bnamesql->execute();
$namebank = $bnamesql->fetch(PDO::FETCH_ASSOC);
//Присваиваем данные
if ($myinfo['plus'] != 0){
  $sum = $myinfo['plus'];
} else {
  $sum = $myinfo['minus'];
}
if (empty($myinfo['comment'])){
  $text = 'Описание отсутствует...';
} else {
  $text = $myinfo['comment'];
}
$name = $namebank['name'];
$tema = $myinfo['tema'];
?>
<div class='more_history_win'>
<div onclick='closeblock()' class="history_exit"></div>
  <div class="history_photo_block">
<?php
//Достаём имг
$i = 0;
$imgsql = $db->prepare("SELECT id,src FROM his_img WHERE id_oper = '$idpost'");
$imgsql->execute();
while ($rowimg = $imgsql->fetch(PDO::FETCH_ASSOC)) {
    $img = $rowimg['src'];
    $id_img = $rowimg['id'];
    echo '<img id="'.$id_img.'img" class="history_photo" src="'.$img.'">';
    ++$i;
}
if ($i != 3){
  while ($i <= 2) {
    echo '<img id="0" class="history_photo" src="/img/noimg.jpg">';
    ++$i;
  }
}
?>
  </div>
  <div class="history_mini_info">Сумма: <div contenteditable="false" id="money" class="sum_his"><?php echo $sum; ?></div>p</div>
  <div class="history_mini_info">Счёт: <?php echo $name; ?></div>
  <div class="history_mini_info">Имя: <div contenteditable="false" id="name" class="sum_his"><?php echo $tema; ?></div></div>
  <div class="history_more_textblock">
    Описание:<br>
    <div contenteditable="false" class="history_more_text"><?php echo $text; ?></div>
  </div>
  <div class="history_more_botblock">
    <div id="<?php echo $idpost; ?>" onclick="edithis(this.id)" class="history_more_bot">Редактировать</div>
    <div id="<?php echo $idpost; ?>" onclick="savehis(this.id)" class="history_more_bot">Сохранить</div>
    <a href="del_oper.php?id=<?php echo $idpost; ?>"><div class="history_more_bot">Удалить</div>
  </div>
</div>
