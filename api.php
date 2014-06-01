<?php
error_reporting(1);
header('Content-Type: text/html; charset=utf-8', true);
$key = 'dq34Wy7a5GDfZc0h';
include('ArrayToXML.php');
if ($_GET['key'] == $key){
# Соединяемся с базой
include("db.php");

if(!$_GET['table']){die('Не указана таблица');}
if ($_GET['type'] == 'mnu'){
$result = $mysqli->query("SELECT menu FROM ".$_GET['table']." WHERE id = ".$_GET['id']);
$row = $result->fetch_array();
print($row[0]);
}elseif ($_GET['type'] == 'summa'){
if ((date("G") == 0) || (date("G") == 1)) $d = date("dmy",time() - 24 * 60 * 60); else  $d = date("dmy");
$result = $mysqli->query("SELECT summ FROM ".$_GET['table']." WHERE driver LIKE '".$_GET['driver']."%' AND day = ".$d." AND otk = 0 AND bn = 0 AND date <= '11:45'");
 while( $row = $result->fetch_array() ){
$s1 +=$row[0];
 }
 print('Сумма за первый заезд: '.$s1.' руб.<br>');
 $result = $mysqli->query("SELECT summ FROM ".$_GET['table']." WHERE driver LIKE '".$_GET['driver']."%' AND day = ".$d." AND otk = 0 AND bn = 0 AND date > '11:45' AND date <= '14:05'");
 while( $row = $result->fetch_array() ){
$s2 +=$row[0];
 }
print('Сумма за второй заезд: '.$s2.' руб.<br>');
$s = $s1+$s2;
print('Общая сумма: '.$s.' руб.');
}elseif ($_GET['type'] == 'udriver'){
if ((date("G") == 0) || (date("G") == 1)) $d = date("dmy",time() - 24 * 60 * 60); else  $d = date("dmy");
$result = $mysqli->query("SELECT nomer,date FROM orders_10 WHERE driver = '' AND day = ".$d." AND otk = 0");
 while( $row = $result->fetch_array() ){
if (date("H:i",strtotime($row[1]) + 30*60) >= date("H:i")){ $text .= $row[0].','; }
 }
 $text = substr($text, 0, strlen($text)-1);
 if(trim($text)) $text = 'В 10 микрорайоне не указаны водители заявок: '.$text.'. '; 
$res = $mysqli->query("SELECT nomer,date FROM orders_2 WHERE driver = '' AND day = ".$d." AND otk = 0");
 while( $r = $res->fetch_array() ){ 
 if (date("H:i",strtotime($row[1]) + 30*60) >= date("H:i")){ $tex .= $r[0].','; }
 }
 $tex = substr($tex, 0, strlen($tex)-1); 
 if(trim($tex))$tex = 'На 2 Брянске не указаны водители заявок: '.$tex;
print(trim($text.$tex));
 }elseif ($_GET['type'] == 'color'){
$result = $mysqli->query("SELECT nomer FROM ".$_GET['table']." WHERE otk = 1 AND day = ".$_GET['day']);
 while( $row = $result->fetch_array() ){ 
 $str .= ($row[0]+0).'|'; 
 }
 $str = '|'.$str;
 print($str);
}elseif ($_GET['type'] == 'divr32e'){
if ($_GET['pole'] == 'driver'){ $_GET['param'] = $_GET['param'].' ('.date("H:i").')';}
$result = $mysqli->query("UPDATE ".$_GET['table']." SET ".$_GET['pole']." = '".$_GET['param']."' WHERE id IN (".$_GET['list'].")");
}elseif ($_GET['type'] == 'last'){

print(mysqli_num_rows($mysqli->query("SELECT LAST_INSERT_ID() FROM ".$_GET['table'])));

}elseif ($_GET['type'] == 'sel'){
if ($_GET['count'] == 1) $z = '='; else $z = '>';
if ($_GET['id']){$where = 'WHERE id '.$z.' '.$_GET['id'];}
$result = $mysqli->query("SELECT * FROM ".$_GET['table']." ".$where);
//вывод
 while( $row = $result->fetch_array() ){
 if ($row[15] == 1){$row[8] .= 'БЕЗНАЛИЧНЫЙ РАСЧЕТ|';} 
 $xml[] = $row[2].$row[1].$row[6].$row[3].$row[5].'Время доставки: '.$row[7].$row[8].$row[4].$row[0].'|';
 }
 //print_r($xml);
 $result->close();
$converter = new ArrayToXML();
$xmlStr = $converter->convert($xml);
header('Content-type: application/xml');
echo $xmlStr; 
}elseif ($_GET['type'] == 'numb'){
$result = $mysqli->query("SELECT * FROM ".$_GET['table']." WHERE day = ".$_GET['day']);
//вывод
 while( $row = $result->fetch_array() ){ 
 if ($row[15] == 1){$row[8] .= 'БЕЗНАЛИЧНЫЙ РАСЧЕТ|';}
 $xml[] = $row[2].$row[1].$row[6].$row[3].$row[5].'Время доставки: '.$row[7].$row[8].$row[4].$row[0].'|';
 }
 //print_r($xml);
 $result->close();
$converter = new ArrayToXML();
$xmlStr = $converter->convert($xml);
header('Content-type: application/xml');
echo $xmlStr;
}else{die('Не верный запрос');}
$mysqli->close(); 
}else{die("Доступ запрещен");}
//hg954gr987wf48fwe8e
//66924ce07da259bd364e9a4a8584f1bf

/*
function printGo()
begin
with Printer do
  begin
    BeginDoc;
    Canvas.TextOut(100,100,'по русски');
    EndDoc;
  end;
end;
*/
?>