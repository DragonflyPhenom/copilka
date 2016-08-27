<?php
session_start();
$user_id = $_COOKIE['id'];
if (empty($user_id)){
	exit(header('Location: index.php'));
}
////////////////////////
	include 'my_con.php';
	$bank = $db->prepare("SELECT min,ok FROM reserv WHERE user = '$user_id'");
	$bank->execute();
	$myrow = $bank->fetch(PDO::FETCH_ASSOC);
	$need = $myrow['min'];
	$reserve = $myrow['ok'];
	if ($reserve < $need){
		$style = 'style="background: red; color: #fff;"';
	} else {
		$style = '';
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Копилка</title>
		<link rel="stylesheet" href="style/style.css" type="text/css"/>
		<link rel="stylesheet" href="style/main.css" type="text/css"/>
		<link rel="stylesheet" href="style/bank.css" type="text/css"/>
		<link rel="stylesheet" href="style/reserve.css" type="text/css"/>
		<link rel="stylesheet" href="style/dohras.css" type="text/css"/>
		<link rel="stylesheet" href="style/cell.css" type="text/css"/>
		<script type="text/javascript" src='jquery-1.11.3.min.js'></script>
	</head>
	<body>
	<div class="head">
		<a href='main.php'><p>Мои финансы</p></a>
		<div class="head_nav">
			<a href="dohras.php"><div class="head_nav_bot">Доход/расход</div></a>
			<a href="mes.php"><div class="head_nav_bot">Месяцы</div></a>
			<div class="head_nav_bot">Годы</div>
			<a href="cel.php"><div class="head_nav_bot">Цели</div></a>
			<a href="reserve.php"><div <?php echo $style;?> class="head_nav_bot">Резерв</div></a>
			<a href="exit.php"><div class="head_nav_bot">Выход</div></a>
		</div>
	</div>
