<?php
$id = $_POST['bank'];
$date = $_POST['infa'];
include 'my_con.php';
?>
Доход:<br><br>
<?php
$oborotmysql = $db->prepare("SELECT plus,tema FROM history WHERE date = '$date' AND bank = '$id'");
$oborotmysql->execute();
while($myrowobor = $oborotmysql->fetch(PDO::FETCH_ASSOC)){
	if ($myrowobor['plus'] != 0){
	$plus = $myrowobor['plus'];
	$tema = $myrowobor['tema'];
	echo $tema.': '.$plus,'p<br>';
	}
}
?>
<br>
Расход:<br><br>
<?php
$oborotmysql = $db->prepare("SELECT minus,tema FROM history WHERE date = '$date' AND bank = '$id'");
$oborotmysql->execute();
while($myrowobor = $oborotmysql->fetch(PDO::FETCH_ASSOC)){
	if ($myrowobor['minus'] != 0){
	$minus = $myrowobor['minus'];
	$tema = $myrowobor['tema'];
	echo $tema.': '.$minus.'p<br>';
	}
}
?>