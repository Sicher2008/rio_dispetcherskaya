<script>
function print_doc(){
$('#stp').attr('style','display:yes;');
window.print();
$('#stp').attr('style','display:none;');
}
</script>
<?php
error_reporting(1);
# Категории Начало;
$type[1] = 'Пельмени';
$type[2] = 'Салат';
$type[3] = 'Лапша';
$type[4] = 'Горачие закуски';
$type[5] = 'Горячие блюда';
$type[6] = 'Паста';
$type[7] = 'Драники';
$type[8] = 'Блинчики';
$type[9] = 'Гарниры';
$type[10] = 'Соусы к гарнирам';
$type[11] = 'Пиццы';
$type[12] = 'Обеды';
$type[13] = 'Суши';
$type[14] = 'Напитки';
$q[1] = 0;
$q[2] = 0;
$q[3] = 0;
$q[4] = 0;
$q[5] = 0;
$q[6] = 0;
$q[7] = 0;
$q[8] = 0;
$q[9] = 0;
$q[10] = 0;
$q[11] = 0;
$q[12] = 0;
$q[13] = 0;
$q[14] = 0;
# Категории Конец;

$id = trim($_GET['id']);
$d = array();
include('db.php');
$res = $mysqli->query("SELECT menu FROM ".$id." WHERE otk = 0") or die($mysqli->error);
while($row = $res->fetch_row()){
$str .= trim($row[0]);
}
//print($str.'<hr>');
$a = explode('|',$str);
$j=0;
for ($i=0;$i<count($a);$i++){
$b[$j] = explode(' кол-во:',$a[$i]);
$b[$j][0] = trim(preg_replace("/\\s\\S+$/u", "", $b[$j][0]));
//if (trim($b[$j][0])) 
//$b[$j][0]=trim(preg_replace('/\d/','',$b[$j][0])); //Убираем цифры из названия
$d[$b[$j][0]] += trim($b[$j][1]);
$j++;
}
$i=1;
foreach ($d as $k => $v) {
//Получаем категорию
$k = trim($k);
$res = $mysqli->query("SELECT price,cat FROM menu WHERE name LIKE '".trim($k)."'") or die($mysqli->error);
//if ($row = $res->fetch_row()) print('|'.$k.'|YES<br>'); else print('|'.$k.'| NO<br>'); 
////
$row = $res->fetch_row();
//if ($row) print('|'.$k.'|YES<br>'); else print('|'.$k.'| NO<br>');
if (!$row){ 
//print($k.'|<br>');
$k = trim(preg_replace('/\d/','',$k)); 
$res = $mysqli->query("SELECT price,cat FROM menu WHERE name LIKE '".trim($k)."'") or die($mysqli->error);
$row = $res->fetch_row();
//print($k.'}<br>');
}
///
//$row = $res->fetch_row();
$f[$row[1]][$q[$row[1]]][0] = $k;
$f[$row[1]][$q[$row[1]]][1] = $v;
$f[$row[1]][$q[$row[1]]][2] = $row[0];
$q[$row[1]] += 1;

//print($k.' '.$v.' '.$row[0].'<br>');
//print('|'.$k.'|<br>');
//print('<tr><td>'.$i.'</td><td>'.$k.'</td><td>'.$v.'</td></tr>');
//$i++;
}
//print_r($f);
print('<div class="hero-unit"><h2><a href="javascript:{}" onclick="print_doc();"><b>Печать</b></a></h2>
<table class="table"><tr><th>№</th><th>Название</th><th>Кол-во</th><th>Сумма</th></tr>');
$summ = 0;
$FSumm = 0;
for ($i=1;$i<=14;$i++){
print('<tr><td colspan="3"><b>'.$type[$i].'</b></td><td></td><td></td><td></td></tr>');
for ($j=0;$j<count($f[$i]);$j++){
$b = $f[$i][$j][1]*$f[$i][$j][2];
print('<tr><td>'.($j+1).'</td><td>'.$f[$i][$j][0].'</td><td>'.$f[$i][$j][1].'</td><td>'.$b.' руб.</td></tr>');
$summ += $b;
}
print('<tr><td></td><td></td><td colspan="3"><b>Итого: '.$summ.' руб.</b></td><td></td></tr>');
$FSumm += $summ;
$summ = 0;
}
print('<tr><td></td><td></td><td colspan="3"><b>Общая сумма: '.$FSumm.' руб.</b></td><td></td></tr>');
print('</table></div>');
//print_r($f);
?>
