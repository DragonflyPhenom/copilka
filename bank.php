<?php
	$id = $_GET['id'];
	include 'header.php';
	//Достаём счет из БД
	$bank = $db->prepare("SELECT name,money FROM bank WHERE id = '$id'");
	$bank->execute();
	$myrow = $bank->fetch(PDO::FETCH_ASSOC);
	$name = $myrow['name'];
	$money = $myrow['money'];
	$date = 0;
	$plus = 0;
	$minus = 0;
	$allplus = 0;
	$allminus = 0;
	$allobor = 0;
?>
<script>
	var idbank = <?php echo $id; ?>;
</script>
<div class="info"><div style="float: left;" class="bankname"><?php echo $name;?></div> : <?php echo $money.'руб.';?></div>
<!--Радактирование имени-->
<div id="editname" class="other_block_bank">
	Новое имя счёта:<br>
	<input id="newnamebank" type="text">
	<div id="<?php echo $id;?>" onclick=rename(this.id); class="bank_other_bot">Принять</div>
	<a class="cancel_new_bank" href="#">Отмена</a>
</div>
<!--Удаление счёта-->
<div id="delbank" class="other_block_bank">
	Хотите удалить счёт?<br>
	<a href="delbank.php?id=<?php echo $id;?>"><div class="bank_other_bot">Принять</div></a>
	<a class="cancel_new_bank1" href="#">Отмена</a>
</div>
<!--новая операция-->
<div id="newoperation" class="other_block_bank" style="height: 170px;">
<form action="addoperation.php?id=<?php echo $id;?>" method='post'>
	Имя операции:<br>
	<input name="nameoper" type="text" id="nameoperatin" placeholder="Зарплата/Продукты"><br>
	Сумма:
	<input name="sumoper" type="text" id="sumoper" placeholder="1000"><br>
	Доход:<input class="bank_radio" type="radio" name="hwo" value="1"> Расход:<input class="bank_radio" type="radio" name="hwo" value="net">
	<input type="submit" value="Принять" class="bank_sub"><br>
	<a class="cancel_new_bank2" href="#">Отмена</a>
</form>
</div>
<!--новый перевод-->
<div id="newperevod" class="other_block_bank" style="height: 170px;">
<form action="perevod.php?id=<?php echo $id;?>" method='post'>
	Имя счёта:<br>
	<select name="cell">
		<?php
			$namebank = $db->prepare("SELECT id, name, money FROM bank");
			$namebank->execute();
			while($mybank = $namebank->fetch(PDO::FETCH_ASSOC)){
				if ($mybank['id'] != $id){
				$idbankn = $mybank['id'];
				$namebankn = $mybank['name'];
				$moneybankn = $mybank['money'];
				echo '<option value="'.$idbankn.'">'.$namebankn.' ('.$moneybankn.'p)</option>';
				}
			}
		?>
		<option value="res">Резерв (<?php echo $reserve.'p';?>)</option>
	</select>
	Сумма:
	<input name="sumoper" type="text" id="sumoper" placeholder="1000"><br>
	<input type="submit" value="Перевести" class="bank_sub"><br>
	<a class="cancel_new_bank3" href="#">Отмена</a>
</form>
</div>
<!--Статистика-->
<div class="bank_stat_win">
  Год: <input id="ear" type="text" placeholder="2016">
  Месяц: <input id="mes" type="text" placeholder="05">
  <div id="see_stat" class="bank_sub">Показать</div>
  <a class="cancel_new_bank4" href="#">Закрыть</a>
  <img id='stat_img' src="">
</div>
<!--Основа-->
<div class="global">
<div class="menu">
	<div id="addoper" class="menu_bot">Новая операция</div>
	<div id="perevod" class="menu_bot">Переводы</div>
  <div id="stat" class="menu_bot">Статистика</div>
	<div id="editbank" class="menu_bot">Редактировать</div>
	<div id="delbanklink" class="menu_bot">Удалить</div>
</div>
<div class="content">
	<div class="head_content">
		<div class="type_head_content">Дата</div>
		<div class="type_head_content">Расход</div>
		<div class="type_head_content">Доход</div>
		<div class="type_head_content">Оборот</div>
	</div>
<?php
	//Достаём историю
	$bank = $db->prepare("SELECT date FROM history WHERE bank = '$id' ORDER BY date");
	$bank->execute();
	while($myrow = $bank->fetch(PDO::FETCH_ASSOC)){
		//строго по дате
		if ($date != $myrow['date']){
			$date = $myrow['date'];
				//считаем + и -
				$oborotmysql = $db->prepare("SELECT plus, minus FROM history WHERE date = '$date' AND bank = '$id'");
				$oborotmysql->execute();
				while($myrowobor = $oborotmysql->fetch(PDO::FETCH_ASSOC)){
					$plus = $plus + $myrowobor['plus'];
					$minus = $minus + $myrowobor['minus'];
					$oborot = $plus - $minus;
					$allplus = $allplus + $myrowobor['plus'];
					$allminus = $allminus + $myrowobor['minus'];
					$allobor = $allplus - $allminus;
					if ($oborot < 0){
						$colorfont = 'style="color: red;"';
					} else {
						$colorfont = ' ';
					}
				}
			//выводим инфу
			printf ('
				<div onclick=openblock(this.id) id="'.$date.'" class="history_block">
					<div class="type_head_content">'.$date.'</div>
					<div class="type_head_content">'.$minus.' р</div>
					<div class="type_head_content">'.$plus.' р</div>
					<div '.$colorfont.' class="type_head_content">'.$oborot.' р</div>
				</div>
				<div id="'.$date.'block" class="win_history">
					<div class="win_history_info"></div>
				</div>
			');
			$plus = 0;
			$minus = 0;
			$oborot = 0;
		}
	}
?>
</div>
</div>
<div class="footbank">
Расход всего: <?php echo $allminus.'p.';?> Доход всего: <?php echo $allplus.'p.';?> Оборот всего: <?php echo $allobor.'p.';?>
</div>
<script>
function openblock(idshka){
	var need = '#' + idshka + 'block';
	var ciska = $(need).css('display');
	if (ciska == 'none'){
	$(need).css('display','block');
	$(need).load('fullhistory.php', {infa: idshka, bank: idbank});
	} else {
		$(need).css('display','none');
	}
}
$('#editbank').click(function(){
	$('#editname').css('display','block');
});
$('#delbanklink').click(function(){
	$('#delbank').css('display','block');
});
$('#addoper').click(function(){
	$('#newoperation').css('display','block');
});
$('#perevod').click(function(){
	$('#newperevod').css('display','block');
});
$('#stat').click(function(){
	$('.bank_stat_win').css('display','block');
});
$('.cancel_new_bank').click(function(){
	$('#editname').css('display','none');
});
$('.cancel_new_bank1').click(function(){
	$('#delbank').css('display','none');
});
$('.cancel_new_bank2').click(function(){
	$('#newoperation').css('display','none');
});
$('.cancel_new_bank3').click(function(){
	$('#newperevod').css('display','none');
});
$('.cancel_new_bank4').click(function(){
  $('.bank_stat_win').css('display','none');
});
function rename(nameid){
	var newname = $('#newnamebank').val();
	$.post('renamebank.php', {id: nameid, name: newname} );
	$('.bankname').text(newname);
	$('#editname').css('display','none');
}
$('#see_stat').click(function(){
  var god = $('#ear').val();
  var mes = $('#mes').val();
  var urli = 'bank_graph.php?id=<?php echo $id;?>&god='+god+'&mes='+mes;
  $('#stat_img').attr('src',urli);
});
</script>
<?php
	include 'footer.php';
?>
