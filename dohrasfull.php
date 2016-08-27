<?php
$date = $_POST['infa'];
include 'my_con.php';
$user_id = $_COOKIE['id'];
?>
Доход:<br><br>
<?php
$oborotmysql = $db->prepare("SELECT id,plus,tema,bank FROM history WHERE date = '$date' AND user = '$user_id'");
$oborotmysql->execute();
while($myrowobor = $oborotmysql->fetch(PDO::FETCH_ASSOC)){
	if ($myrowobor['plus'] != 0){
  $idbank = $myrowobor['bank'];
  //Достаём имя банка
  $banknamesql = $db->prepare("SELECT name FROM bank WHERE id = '$idbank'");
  $banknamesql->execute();
  $mynamebank = $banknamesql->fetch(PDO::FETCH_ASSOC);
  $name = $mynamebank['name'];
  //Присваиваем значения из старого СЕЛЕКТА
	$plus = $myrowobor['plus'];
	$tema = $myrowobor['tema'];
  $id = $myrowobor['id'];
	echo '<a onclick="openmore(this.id)" id="'.$id.'" href="#"><span id="'.$id.'tpl">'.$tema.'</span>: <span id="'.$id.'pl">'.$plus.'</span>p Счёт: '.$name.'</a><br>';
	}
}
?>
<br>
Расход:<br><br>
<?php
$oborotmysql = $db->prepare("SELECT id,minus,tema,bank FROM history WHERE date = '$date' AND user = '$user_id'");
$oborotmysql->execute();
while($myrowobor = $oborotmysql->fetch(PDO::FETCH_ASSOC)){
	if ($myrowobor['minus'] != 0){
  $idbank = $myrowobor['bank'];
  //Достаём имя банка
  $banknamesql = $db->prepare("SELECT name FROM bank WHERE id = '$idbank'");
  $banknamesql->execute();
  $mynamebank = $banknamesql->fetch(PDO::FETCH_ASSOC);
  $name = $mynamebank['name'];
  //писваиваем данные из прошлого селекта
	$minus = $myrowobor['minus'];
	$tema = $myrowobor['tema'];
  $id = $myrowobor['id'];
	echo '<a onclick="openmore(this.id)" id="'.$id.'" href="#"><span id="'.$id.'tmn">'.$tema.'</span>: <span id="'.$id.'mn">'.$minus.'</span>p Счёт: '.$name.'</a><br>';
	}
}
?>
