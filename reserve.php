<?php
	include 'header.php';
	$bank = $db->prepare("SELECT min,ok FROM reserv WHERE id = '1'");
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
<!--Окно настройки резерва-->
<div id="block1" class="other_block_bank">
	Новая сумма резерва:<br>
	<input id="newnamebank" type="text">
	<div class="bank_other_bot">Принять</div>
	<a class="cancel_new_bank" href="#">Отмена</a>
</div>
<!--новая операция-->
<div id="newoperation" class="other_block_bank" style="height: 170px;">
<form action="addoperationres.php" method='post'>
	Имя операции:<br>
	<input name="nameoper" type="text" id="nameoperatin" placeholder="Зарплата/Продукты"><br>
	Сумма:
	<input name="sumoper" type="text" id="sumoper" placeholder="1000"><br>
	Доход:<input class="bank_radio" type="radio" name="hwo" value="1"> Расход:<input class="bank_radio" type="radio" name="hwo" value="net">
	<input type="submit" value="Принять" class="bank_sub"><br>
	<a class="cancel_new_bank1" href="#">Отмена</a>
</form>
</div>
<!--новый перевод-->
<div id="newperevod" class="other_block_bank" style="height: 170px;">
<form action="perevodres.php" method='post'>
	Имя счёта:<br>
	<select name="cell">
		<?php
			$namebank = $db->prepare("SELECT id, name, money FROM bank");
			$namebank->execute();
			while($mybank = $namebank->fetch(PDO::FETCH_ASSOC)){
				$idbankn = $mybank['id'];
				$namebankn = $mybank['name'];
				$moneybankn = $mybank['money'];
				echo '<option value="'.$idbankn.'">'.$namebankn.' ('.$moneybankn.'p)</option>';
			}
		?>
	</select>
	Сумма:
	<input name="sumoper" type="text" id="sumoper" placeholder="1000"><br>
	<input type="submit" value="Перевести" class="bank_sub"><br>
	<a class="cancel_new_bank2" href="#">Отмена</a>
</form>
</div>
<!--Бошка страницы с настройкой резерва-->
<div class="head_reserv">
	<div class="head_head_res">
		<div class="set_head_res">Настроить</div>    <!--Кнопка set резерва-->
	</div>
	<div class="head_res_con">
		<div id="res_mon1" <?php echo $style;?> class="head_res_money"><?php echo $reserve.'p'?></div>
		<div id="res_mon2" class="head_res_money"><?php echo $need.'p';?></div>
	</div>
</div>
<!--История резерва-->
<div class="history_reserv">
	<div id="head_his_res" class="head_his_res">Новая операция</div>
	<div id="head_his_res2" class="head_his_res">Перевод</div><br>
	<div class="his_content">
		<div class="his_content_head">
		<div class="head_content">
			<div class="type_head_content">Дата</div>
			<div class="type_head_content">Расход</div>
			<div class="type_head_content">Доход</div>
			<div class="type_head_content">Имя опрерации</div>
		</div>
		<div>
	<?php
		$historsql = $db->prepare("SELECT id,plus,minus,date,tema FROM history_res");
		$historsql->execute();
		while($myhis = $historsql->fetch(PDO::FETCH_ASSOC)){
			$id = $myhis['id'];
			$plus = $myhis['plus'];
			$minus = $myhis['minus'];
			$date = $myhis['date'];
			$tema = $myhis['tema'];
			printf ('
				<div class="history_block">
					<div class="type_head_content">'.$date.'</div>
					<div class="type_head_content">'.$minus.' р</div>
					<div class="type_head_content">'.$plus.' р</div>
					<div class="type_head_content" style="overflow: hidden;">'.$tema.'</div>
				</div>
				<div id="'.$date.'block" class="win_history">
					<div class="win_history_info"></div>
				</div>
			');
		}
	?>
	</div>
</div>
<!--скрипты-->
<script>
$('.set_head_res').click(function(){
	$('#block1').css('display','block');
});
$('.cancel_new_bank').click(function(){
	$('#block1').css('display','none');
});
$('.bank_other_bot').click(function(){
	var mon = $('#newnamebank').val();
	$('#res_mon2').text(mon + 'p');
	$('#block1').css('display','none');
	$.post('new_reserve.php', {sum: mon});
});
$('#head_his_res').click(function(){
	$('#newoperation').css('display','block');
});
$('.cancel_new_bank1').click(function(){
	$('#newoperation').css('display','none');
});
$('#head_his_res2').click(function(){
	$('#newperevod').css('display','block');
});
$('.cancel_new_bank2').click(function(){
	$('#newperevod').css('display','none');
});
</script>
<?php
	include 'footer.php';
?>