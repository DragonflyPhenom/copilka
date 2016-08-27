<?php
  include 'my_con.php';
  $user_id = $_COOKIE['id'];
  //Достаём деньги
  $fullmoney = 0;
  $bank = $db->prepare("SELECT money FROM bank WHERE user = '$user_id'");
	$bank->execute();
	while($myrow = $bank->fetch(PDO::FETCH_ASSOC)){
		$money = $myrow['money'];
		$fullmoney = $fullmoney + $money;
  }
	//Достаём цели
	$cell = $db->prepare("SELECT * FROM cell WHERE user = '$user_id' ORDER BY date");
	$cell->execute();
	while($mycell = $cell->fetch(PDO::FETCH_ASSOC)){
    $name = $mycell['tema'];
    $cellid = $mycell['id'];
    $cellsum = $mycell['sum'];
    $celldate = $mycell['date'];
    if ($cellsum <= $fullmoney){
      $color = "background: aquamarine;";
    } else {
      $color = " ";
    }
    printf('
      <div onclick="openblock(this.id)" class="cell_info" id="'.$cellid.'">
        <div class="cell_name">'.$name.'</div>
        <div class="cell_name" style="'.$color.'height: 37px; padding-top: 3px;">'.$cellsum.'p<br>('.$fullmoney.')</div>
        <div class="cell_name">'.$celldate.'</div>
      </div>
      <div id="'.$cellid.'block" class="edit_cell_win">
        <div id="'.$cellid.'text" class="edit_cell_info" contenteditable>'.$name.'</div>
        <div id="'.$cellid.'sum" class="edit_cell_info" contenteditable>'.$cellsum.'</div>
        <div class="edit_cell_foot">
          <div onclick="editcell(this.id)" id="'.$cellid.'" class="edit_cell_bot">Сохранить</div>
          <div onclick="delcell(this.id)" id="'.$cellid.'" class="edit_cell_bot">Удалить</div>
        </div>
      </div>
    ');
	}
?>
