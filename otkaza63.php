<?
error_reporting(1);
$key = 'dq34Wy7a5GDfZc0h';
if ($_GET['key'] == $key){
# Соединяемся с базой
include("db.php");

$result = $mysqli->query("UPDATE ".$_GET['table']." SET otk = 1 WHERE id = ".$_GET['id']);
print('запись успешно обновлена');
}else die('Доступ закрыт');
?>