<?php
include 'my_con.php';
/* Include the pData class */
include 'pChart/pData.class';
include 'pChart/pCache.class';
include 'pChart/pChart.class';
$su = 0;
$mi = 0;
$bank = $_GET['id'];
$mes = $_GET['mes'];
$god = $_GET['god'];
//создаем объект данных
$myData = new pData();

/* Connect to the MySQL database */
$db = mysql_connect("localhost", "root", "");
if ( $db == "" ) { echo " DB Connection error...\r\n"; exit(); }

mysql_select_db("cop",$db);
//Достаём деньги по дате через цикл
for ($i = 1; $i <= 31; $i++){
  $mydate = $god.'-'.$mes.'-'.$i;
  $Requete = "SELECT `plus`,`minus` FROM `history` WHERE `date` = '$mydate' AND `bank` = '$bank'";
  $result = mysql_query($Requete,$db);
  while($row = mysql_fetch_array($result)){
    $su = $su + $row["plus"];
    $mi = $mi + $row["minus"];
  }
  $myData->AddPoint($i,"id");
  $myData->AddPoint($su,"summa");
  $myData->AddPoint($mi,"summam");
  $su = 0;
  $mi = 0;
}
//устанавливаем точки с датами
//на ось абсцисс
$myData->SetAbsciseLabelSerie("id");
//помечаем данные как предназначеные для
//отображения
$myData->AddSerie("summa");
//устанавливаем имена
$myData->SetSerieName(
mb_convert_encoding("Сумма",'utf-8','utf-8'),
"summa");
//помечаем данные как предназначеные для
//отображения2
$myData->AddSerie("summam");
//устанавливаем имена
$myData->SetSerieName(
mb_convert_encoding("Расход",'utf-8','utf-8'),
"summam");
//создаем график шириной в 600 и высотой в 450 px
$graph = new pChart(600,250);
//устанавливаем шрифт и размер шрифта
$graph->setFontProperties("Fonts/tahoma.ttf",10);
//координаты левой верхней вершины и правой нижней
//вершины графика
$graph->setGraphArea(55,30,500,200);
//прорисовываем фон графика
$graph->drawGraphArea(255,255,255,TRUE);
//устанавливаем данные для графиков
$graph->drawScale($myData->GetData(),
$myData->GetDataDescription(),
SCALE_NORMAL,150,150,150,true,0,2);
//рисуем сетку для графика
$graph->drawGrid(4,TRUE,230,230,230,50);
//прорисовываем линейные графики
$graph->drawLineGraph($myData->GetData(),
$myData->GetDataDescription());
// рисуем точки на графике
$graph->drawPlotGraph($myData->GetData(),
$myData->GetDataDescription(),3,2,255,255,255);
//ложим легенду
$graph->drawLegend(50,35,$myData->GetDataDescription(),255,255,255);
//Пишем заголовок
$graph->setFontProperties("Fonts/tahoma.ttf",15);
$graph->drawTitle(250,22,
mb_convert_encoding("График",
'utf-8','utf-8'),
150,150,150,-1,-1,false);
//выводим в браузер
$graph->Stroke();
/**
* @return array
*/
function getdata($file)
{
if (file_exists($file)) {
$lines = file($file);
$data = array('date' => array(), 'oplacheno' => array(), 'summa' => array(), 'summam' => array());
foreach ($lines as $line) {
$tmp = explode(' ', trim($line));
$data['date'][] = $tmp[0];
$data['oplacheno'][] = trim($tmp[1]);
$data['summa'][] = trim($tmp[2]);
$data['summam'][] = trim($tmp[3]);
}
return $data;
} else {
return false;
}
}
?>
