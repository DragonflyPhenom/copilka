<?php
session_start();
////////////////////////
if (isset($_COOKIE['auto']) and    isset($_COOKIE['login']) and isset($_COOKIE['password'])){
if ($_COOKIE['auto'] == 'yes') {
$_SESSION['password']=strrev(md5($_COOKIE['password']))."b3p6f";
$_SESSION['login']=$_COOKIE['login'];
$_SESSION['user_id']=$_COOKIE['id'];
exit(header('Location: main.php?id='.$_SESSION['user_id']));
}
}
////////////////////////
	if (!empty($_SESSION['error'])){
		$error = $_SESSION['error'];
	} else {
		$error = ' ';
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Мои финансы</title>
		<link rel="stylesheet" href="style/index.css" type="text/css"/>
		<script type="text/javascript" src='jquery-1.11.3.min.js'></script>
	</head>
	<body>
		<div class="head">
			<div class="title_head">Мои финансы</div>
		</div>
		<div class="main_win">
			<div class='content1'>
				<center><div class='enter'>
					Вход/Регистрация
				</div>
				<div class='con'>
				<div class='form_reg' id='con'>
					<div class='con_enter'>
						<form action='test_reg.php' method='post'>
							<input class='in_login' type='text' name='login' placeholder="Email">
							<input class='in_pass' type='password' name='password' placeholder="Password"><br>
							<input class='in_sub' value='Войти' type='submit' name='sub'>
						</form>
					</div>
					<div class='con_reg'>
						<form action='save_user.php' method='post'>
							<input class='reg_login' type='text' name='login' placeholder="Email">
							<input class='reg_pass' type='password' name='password' placeholder="Password"><br>
							<input class='reg_sub' value='Зарегистрироваться' type='submit' name='sub'>
						</form>
					</div>
					<div class='con_for'>
						<form action='forgot.php'>
							<input class='for_login' type='text' name='login'  placeholder="Email"><br>
							<input class='for_sub' value='Восстановить' type='submit' name='sub'>
						</form>
					</div>
				</div>
				<div class='content_bot'>
				<div class='reg_bot' id='reg'>Регистрация</div>
				<div class='for_bot' id='for'>Забыли пароль?</div>
				</div>
				</div>
			<div class='error'><?php echo $error; ?></div>
			</center>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				$('#reg').click(function(){
					$mar = $('.form_reg').css('margin-left');
					mar = parseInt($mar);
					if (mar == 0 || mar == -640){
					$('#con').animate({'marginLeft': '-320'}, 200);
					} else {
						$('#con').animate({'marginLeft': '0'}, 200);
					}
				});
			});
		</script>
		<script>
			$(document).ready(function(){
				$('#for').click(function(){
					$mar = $('.form_reg').css('margin-left');
					mar = parseInt($mar);
					if (mar == -320 || mar == 0){
					$('#con').animate({'marginLeft': '-640'}, 200);
					} else {
						$('#con').animate({'marginLeft': '0'}, 200);
					}
				});
			});
		</script>
	</body>
</html>
