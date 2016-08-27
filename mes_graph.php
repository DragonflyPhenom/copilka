<?php
include 'my_con.php';
/* Include the pData class */
include 'pChart/pData.class';
include 'pChart/pCache.class';
include 'pChart/pChart.class';
$da = 0;
$su = 0;
$mi = 0;
$bank = $_GET['id'];
//создаем объект данных
$myData = new pData();

/* Connect to the MySQL database */
$db = mysql_connect("localhost", "root", "");
if ( $db == "" ) { echo " DB Connection error...\r\n"; exit(); }

mysql_select_db("cop",$db);

$Requete = "SELECT `date` FROM `history` WHERE `bank` = '$bank'";
$result = mysql_query($Requete,$db);
while($row = mysql_fetch_array($result)){
  if ($da != $row["date"]){
  $da = $row["date"];
  $inhisrow = "SELECT `plus`,`minus` FROM `history` WHERE `date` = '$da' AND `bank` = '$bank'";
  $resultrow = mysql_query($inhisrow,$db);
  while($rowq = mysql_fetch_array($resultrow)){
    $su = $su + $rowq["plus"];
    $mi = $rowq["minus"];
  }
  $myData->AddPoint($da,"id");
  $myData->AddPoint($su,"summa");
  $myData->AddPoint($mi,"summam");
  $su = 0;
  $mi = 0;
}
//$myData->AddPoint($row["date"],"id");
//$myData->AddPoint($row["plus"],"summa");
//$myData->AddPoint($row["minus"],"summam");
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
//рисуем заполненный четырехугольник
//$graph->drawFilledRoundedRectangle(7,7,993,493,5,240,
//240,240);
//теперь незаполненный для эффекта тени
//$graph->drawRoundedRectangle(5,5,995,495,5,230,
//230,230);
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
// пишем в подвале некоторый текст
//$graph->setFontProperties("Fonts/tahoma.ttf",10);
//$graph->drawTextBox(870,450,990,460,"Powered By pChart",
//0,250,250,250,ALIGN_CENTER,TRUE,-1,-1,-1,30);
//$graph->drawTextBox(805,470,990,480,"http://pchart.sourceforge.net",
//0,250,250,250,ALIGN_CENTER,TRUE,-1,-1,-1,30);
//$graph->drawTextBox(15,450,140,460,"Developed By kv4nt",
//0,250,250,250,ALIGN_CENTER,TRUE,-1,-1,-1,30);
//$graph->drawTextBox(10,470,140,480,"http://www.piarcom.com",
//0,250,250,250,ALIGN_CENTER,TRUE,-1,-1,-1,30);
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
