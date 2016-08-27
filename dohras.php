<?php
	include 'header.php';
?>
<script>
var sid = 0;
var smon = 0;
var dopname = 0;
</script>
<div class="more_history_info"></div>
<div class="content">
	<div class="head_content">
		<div class="type_head_content">Дата</div>
		<div class="type_head_content">Расход</div>
		<div class="type_head_content">Доход</div>
		<div class="type_head_content">Оборот</div>
	</div>
<?php
	//Достаём историю
	$bank = $db->prepare("SELECT date FROM history WHERE what <> '2' AND user = '$user_id' ORDER BY date");
	$bank->execute();
	while($myrow = $bank->fetch(PDO::FETCH_ASSOC)){
		//строго по дате
		if ($date != $myrow['date']){
			$date = $myrow['date'];
				//считаем + и -
				$oborotmysql = $db->prepare("SELECT plus, minus FROM history WHERE date = '$date' AND user = '$user_id'");
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
<script>
function openblock(idshka){
	var need = '#' + idshka + 'block';
	var ciska = $(need).css('display');
	if (ciska == 'none'){
	$(need).css('display','block');
	$(need).load('dohrasfull.php', {infa: idshka});
	} else {
		$(need).css('display','none');
	}
}
function openmore(myid){
	$('.more_history_info').text('');
	$('.more_history_info').css('display','block');
	$('.more_history_info').load('morehistory.php', {infa: myid});
}
function closeblock(){
	$('.more_history_info').css('display','none');
}
function edithis(bid){
	$('#money').css('background','#C8C8C8');
	$('#money').attr('contenteditable','true');
	$('#name').css('background','#C8C8C8');
	$('#name').attr('contenteditable','true');
	$('.history_more_text').css('background','#C8C8C8');
	$('.history_more_text').attr('contenteditable','true');
}
function savehis(sid){
	$('.more_history_info').css('display','none');
	var stext = $('.history_more_text').text();
	smon = $('#money').text();
	dopname = $('#name').text();
	var fdf = parseInt(smon);
	$.post('edit_his.php', {id: sid, text: stext, money: fdf, name: dopname}, newmoney);
	function newmoney(newdata){
		if (newdata == 'plus'){
			var rid = '#'+sid+'pl';
			$(rid).text(smon);
			rid = '#'+sid+'tpl';
			$(rid).text(dopname);
		} else {
			var rid = '#'+sid+'mn';
			$(rid).text(smon);
			rid = '#'+sid+'tmn';
			$(rid).text(dopname);
		}
	}
}
</script>
<?php
	include 'footer.php';
?>
