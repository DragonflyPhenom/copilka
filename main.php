<?php
	include 'header.php';
	$bank = $db->prepare("SELECT money FROM bank WHERE user = '$user_id'");
	$bank->execute();
	while($myrow = $bank->fetch(PDO::FETCH_ASSOC)){
		$money = $myrow['money'];
		$fullmoney = $fullmoney + $money;
	}
?>
<div class="info">Все счета: <?php echo $fullmoney.'p.';?></div>
<!--Форма регистрации нового счёта-->
<div class="new_bank_form">
<center>
	<form action='new_bank.php' method='post'>
		Имя нового счёта:
		<input type="text" class="new_name_bank" name="name_bank">
		Начальная сумма:
		<input type="text" class="new_name_bank" name="money_bank">
		<input type='submit' class="new_name_bank_bot">
	</form>
	<a class="cancel_new_bank" href="#">Отмена</a>
</center>
</div>
<!--Конец формы-->
<div class="bank_list">
	<div id="new_b" class="bank_icon">
		<div class="bank_new_icon">
			<img width="100px" height="100px" src="/img/add2.png">
		</div>
	</div>
<!--Достаём счета из БД-->
<?php
	$bank = $db->prepare("SELECT id,name,money FROM bank WHERE user = '$user_id' ORDER BY money");
	$bank->execute();
	while($myrow = $bank->fetch(PDO::FETCH_ASSOC)){
		$id = $myrow['id'];
		$name = $myrow['name'];
		$money = $myrow['money'];
		echo '<div class="bank_icon"><div class="bank_new_icon"><a href="bank.php?id='.$id.'"><div class="bank_info">'.$name.'</div></a><div id="'.$id.'_mon" class="bank_info">'.$money.'p</div><div class="bank_info"><div onclick="plusbk(this.id)" id="'.$id.'" class="change_bank_index">+</div><div onclick="minusbk(this.id)" id="'.$id.'" class="change_bank_index">-</div></div></div><div mouseleave="ubr(this.id)" id="'.$id.'_nm" class="new_mon"><input id="'.$id.'_text" name="" type="text" class="new_mon_input"><div id="'.$id.'" onclick="nm(this.id)" class="go_mon">Ок!</div></div></div>';
	}
?>
<!--Конец "достаём счета"-->
</div>
<!-- Скрипты -->
<script>
	$('#new_b').click(function(){
		$('.new_bank_form').css('display','block');
	});
	$('.cancel_new_bank').click(function(){
		$('.new_bank_form').css('display','none');
	});
	function plusbk(idblock){
		var idnm = '#' + idblock + '_nm';
		var montext = '#' + idblock + '_text';
		$(idnm).css('display','block');
		$(montext).attr('name','plus');
	}
	function minusbk(idblock){

		var idnm = '#' + idblock + '_nm';
		var montext = '#' + idblock + '_text';
		$(idnm).css('display','block');
		$(montext).attr('name','minus');
	}
	function nm(idblock){
		var idnm = '#' + idblock + '_nm';
		var idshka = '#' + idblock + '_text';
		var name = $(idshka).attr('name');
		var valy = parseInt($(idshka).val());
		var idsa = '#' + idblock + '_mon';
		var moneybk = parseInt($(idsa).text());
		if (name == 'plus') {
			var plusik = moneybk + valy;
			$.post('fast_money.php', {id: idblock, money: plusik, hoo: 'pl', start: moneybk, che: valy} );
			$(idsa).text(plusik);
			$(idshka).val(0);
			$(idnm).css('display','none');
		} else {
			var plusik = moneybk - valy;
			$.post('fast_money.php', {id: idblock, money: plusik, hoo: 'mn', che: valy} );
			$(idsa).text(plusik);
			$(idshka).val(0);
			$(idnm).css('display','none');
		}
	}
$('.new_mon').mouseleave(function(){
	$(this).css('display','none');
});
</script>
<?php
	include 'footer.php';
?>
