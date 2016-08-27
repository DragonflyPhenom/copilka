<?php
  include 'header.php';
?>
<div class="cell_head">
  <div class="cell_head_center">
    <div class="cell_new_cell" contenteditable>Цель...</div>
    <input type="text" placeholder="Сумма..." class="cell_cell_sum">
    <div class="cell_head_bot">Сохранить</div>
  </div>
</div>
<div class="cell_win"></div>
<script>
  $(document).ready(function loadcell (){
    $('.cell_win').load('all_cell.php');
  });
  $('.cell_head_bot').click(function (){
    var newtema = $('.cell_new_cell').text();
    var newmon = $('.cell_cell_sum').val();
    newmon = parseInt(newmon);
    $.post('addnewcell.php', {name: newtema, mon: newmon}, oky);
    function oky(dater){
      $('.cell_win').load('all_cell.php');
    }
  });
  function openblock(idblock){
    var newblock = '#' + idblock + 'block';
    var dis =  $(newblock).css('display');
    if (dis == 'none'){
      $(newblock).css('display','block');
    } else {
      $(newblock).css('display','none');
    }
  }
  function delcell(iddell){
    $.post('delcell.php', {name: iddell}, oky);
    function oky(dater){
      $('.cell_win').load('all_cell.php');
    }
  }
  function editcell(editid){
    var mytext = '#' + editid + 'text';
    var mysum = '#' + editid + 'sum';
    var fulltext = $(mytext).text();
    var fullsum = $(mysum).text();
    fullsum = parseInt(fullsum);
    $.post('editcell.php', {id: editid, sum: fullsum, text: fulltext}, oky);
    function oky(dater){
      $('.cell_win').load('all_cell.php');
    }
  }
</script>
<?php
  include 'footer.php';
?>
