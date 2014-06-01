<?
# Соединяемся с базой
include("db.php");
$st = explode(' ',$_POST['st']);
$s = $st[0].' '.$st[1];
if ($result = $mysqli->query("SELECT dom FROM streets WHERE st LIKE '%".$s."%'")){
$row = $result->fetch_array();
if (trim($row[0])){
$d = explode(',',$row[0]);
if (in_array($_POST['d'], $d)) print('y');
}
}
$mysqli->close();
?>