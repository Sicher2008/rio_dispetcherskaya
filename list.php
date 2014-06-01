<script>
function lsr(table,z){ 
var id = '';
if (table == 'orders_10'){ id = 'two'; }else{ id = 'three';}
$.get('search.php?tb='+table+'&zp='+$('#'+z).val(), function(data) {
  $('#'+id).html(data);
});
}
</script>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<style>
.otkaz{
    background: #ccc; /* Цвет фона строки заголовка */
    color: #ffe; /* Цвет текста */
    text-align: left; /* Выравнивание по левому краю */
    font-family: Arial, Helvetica, sans-serif; /* Выбор гарнитуры */
    font-size: 0.9em; /* Размер текста */
   }

.table td.gr{
border-bottom:3px solid green;
border-collapse:collapse;
}
.table td.bl{
border-bottom:3px solid blue;
border-collapse:collapse;
}
.table td.or{
border-bottom:3px solid orange;
border-collapse:collapse;
}
</style>
<?php
date_default_timezone_set('Europe/Moscow');
# Соединяемся с базой
include("db.php");
if ((date("G") == 0) || (date("G") == 1)) $d = date("dmy",time() - 24 * 60 * 60); else  
$d = date("dmy");
//$d = date("dmy");
function GetMax($table,$time,$st){
global $mysqli, $d;
$result = $mysqli->query("SELECT date FROM ".$table." WHERE day = ".$d);
$max = $st;
 while( $row = $result->fetch_array() ){
 if (($row[0]> $max) && ($row[0] <= $time)) $max = $row[0];
 }
 return $max;
}
if ($_GET['user']){ $user = ' AND user = '.$_GET['user']; }
if ($_GET['s']){ $sear = " AND adress LIKE '%".$_GET['s']."%'";}
if ($_GET['type'] == 1){
print('<div class="hero-unit"><div class="input-append"><input class="input-block-level" id="lsr1" type="text"><button class="btn" type="button" onclick="GetTable();">Искать</button></div><table class="table"><tr><th>№</th><th>Адрес</th><th>ФИО (Организ.)</th><th>Номер телефона</th><th>Время</th><th>Статус</th><th>Водитель</th><th>Сумма</th></tr>');
$result = $mysqli->query("SELECT * FROM orders_10 WHERE day = ".$d.$sear.$user." ORDER by id ASC") or die($mysqli->error);
$i = 1;
 $m1 = GetMax('orders_10', '09:45:00|', '08:00:00|');
 $m2 = GetMax('orders_10', '11:45:00|', '09:46:00|');
 $m3 = GetMax('orders_10', '14:05:00|', '11:46:00|');
 while( $row = $result->fetch_array() ){
$row[4] = str_replace("|", "<br>", $row[4]);
 if ($row[5] == $m1){ $td = 'gr';}
 if ($row[5] == $m2){ $td = 'bl';}
 if ($row[5] == $m3){ $td = 'or';}
 if ($row[15] == 1){ $row[12] = 0;}
 if ($row[13] == 1){ $class = ' class="otkaz"'; $row[12] = 0;}
 if ($row[10] == 1) $row[10] = '<img src="plus.png" onclick="conf(\'10\',\''.$row[0].'\');">'; else $row[10] = '<img src="minus.png" onclick="conf(\'10\',\''.$row[0].'\');">';
 $row = str_replace("|", "", $row);
 if ($row[6]) $row[6] = ' ('.$row[6].')';
 $row[9] = str_replace("_", " ", $row[9]);
 $summa += $row[12];
 $row[4] = preg_replace('/([А-Я])/u', '<br>$1', $row[4]);
 print('<div id="o10_'.$row[0].'" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Заказ № '.$row[0].'</h3>
	</div>	
	<div class="modal-body">
		'.$row[4].'
	</div>
</div>');
 print('<tr'.$class.'><td align="center" class="'.$td.'"><a href="javascript:{}" onclick="$(\'#o10_'.$row[0].'\').modal();">'.$row[0].'</a></td><td class="'.$td.'">'.$row[1].'</td><td align="center" class="'.$td.'">'.$row[2].$row[6].'</td><td align="center" class="'.$td.'">'.$row[3].'</td><td align="center" class="'.$td.'">'.$row[5].'</td><td align="center" class="'.$td.'">'.$row[10].'</td><td align="center" class="'.$td.'">'.$row[9].'</td><td align="center" class="'.$td.'">'.$row[12].'  руб.</td></tr>');
 $class = '';
 $i++;
 $td = '';
 }
print('<tr><td colspan="8" align="right">Итого: '.$summa.' руб.</td></tr>');
print('</table></div>');
}elseif ($_GET['type'] == 2){
print('<div class="hero-unit"><div class="input-append"><input class="input-block-level" id="lsr2" type="text"><button class="btn" type="button" onclick="GetTable();">Искать</button></div><table class="table"><tr><th>№</th><th>Адрес</th><th>ФИО (Организ.)</th><th>Номер телефона</th><th>Время</th><th>Статус</th><th>Водитель</th><th>Сумма</th></tr>');
$result = $mysqli->query("SELECT * FROM orders_2 WHERE day = ".$d.$sear.$user." ORDER by id ASC");
$i = 1;
 $m1 = GetMax('orders_2', '09:35:00|', '08:00:00|');
 $m2 = GetMax('orders_2', '11:45:00|', '09:36:00|');
 $m3 = GetMax('orders_2', '13:35:00|', '11:46:00|');
 while( $row = $result->fetch_array() ){
 $row[4] = str_replace("|", "<br>", $row[4]);
 if ($row[5] == $m1){ $td = 'gr';}
 if ($row[5] == $m2){ $td = 'bl';}
 if ($row[5] == $m3){ $td = 'or';}
 if ($row[13] == 1){ $class = ' class="otkaz"'; $row[12] = 0;}
 if ($row[15] == 1){ $row[12] = 0;}
 if ($row[10] == 1) $row[10] = '<img src="plus.png" onclick="conf(\'2\',\''.$row[0].'\');">'; else $row[10] = '<img src="minus.png" onclick="conf(\'2\',\''.$row[0].'\');">';
 $row = str_replace("|", "", $row);
 if ($row[6]) $row[6] = ' ('.$row[6].')';
 $row[9] = str_replace("_", " ", $row[9]);
 $summa += $row[12];
  $row[4] = preg_replace('/([А-Я])/u', '<br>$1', $row[4]);
 print('<div id="o2_'.$row[0].'" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Заказ № '.$row[0].'</h3>
	</div>	
	<div class="modal-body">
		'.$row[4].'
	</div>
</div>');
 print('<tr'.$class.'><td align="center" class="'.$td.'"><a href="javascript:{}" onclick="$(\'#o2_'.$row[0].'\').modal();">'.$row[0].'</a></td><td class="'.$td.'">'.$row[1].'</td><td align="center" class="'.$td.'">'.$row[2].$row[6].'</td><td align="center" class="'.$td.'">'.$row[3].'</td><td align="center" class="'.$td.'">'.$row[5].'</td><td align="center" class="'.$td.'">'.$row[10].'</td><td align="center" class="'.$td.'">'.$row[9].'</td><td align="center" class="'.$td.'">'.$row[12].'  руб.</td></tr>');
 $class = '';
 $i++;
 $td = '';
 }
print('<tr><td colspan="8" align="right">Итого: '.$summa.' руб.</td></tr>');
print('</table>');
}else print('Ошибка. У нас нет такого раздела!');
?>