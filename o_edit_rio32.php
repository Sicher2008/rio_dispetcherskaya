<?php
error_reporting(1);
$d = $_GET['d'];
$m = $_GET['m'];
$m = str_replace(PHP_EOL, "|", $m);
$s = explode('|',$m);
for ($i=0;$i<count($s);$i++){
preg_match_all('|\d+|', $s[$i], $t);
if (count($t[0]) > 2){ $a = count($t[0])-1; $b = count($t[0])-2;}else{ $a = 0; $b = 1; }
$summ += $t[0][$a] * $t[0][$b];
}
$id = $_GET['id'];
include("db.php");
if($res = $mysqli->query("UPDATE orders_o SET menu = '$m', summ = '$summ', info = '$d|' WHERE id = $id") or die(mysql_error())) print('Заявка успешно отредактирована');
else print('Ошибка при редактировании');
?>