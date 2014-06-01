<?
date_default_timezone_set('Europe/Moscow');
header('Content-Type: text/html; charset=utf-8', true);
function _strtolower($string)
{
    $small = array('а','б','в','г','д','е','ё','ж','з','и','й',
                   'к','л','м','н','о','п','р','с','т','у','ф',
                   'х','ч','ц','ш','щ','э','ю','я','ы','ъ','ь',
                   'э', 'ю', 'я');
    $large = array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й',
                   'К','Л','М','Н','О','П','Р','С','Т','У','Ф',
                   'Х','Ч','Ц','Ш','Щ','Э','Ю','Я','Ы','Ъ','Ь',
                   'Э', 'Ю', 'Я');
    return str_replace($large, $small, $string);  
}
function NumbFile($name){
global $num;
$num = trim(file_get_contents('http://212.224.113.37/'.$name));
$num = $num+1;
$f=fopen($name,'w');
fputs($f,$num);
fclose($f);
}
if ($_GET['adress']){
$date = date("H:i:s").'|';
$day = date("dmy");
# Соединяемся с базой
include("db.php");
# Получаем данные
$a = rawurldecode($_GET['sid']);
$b = rawurldecode($_GET['adress']).'|';
$c = rawurldecode($_GET['fio']);
$d = rawurldecode($_GET['oname']);
$e = rawurldecode($_GET['menu']);
$f = rawurldecode($_GET['summa']);
$s = rawurldecode($_GET['numb']);
$m = rawurldecode($_GET['com']);
//print $e;
# Определяем куда пойдет заказ
$st = $mysqli->query("SELECT fil FROM streets WHERE id = '".$a."'") or die($mysqli->error);
$row = $st->fetch_assoc();
if ($row['fil'] == 1) $table = '10'; else $table = '2';
NumbFile($table.'.txt');
# Выполняем запрос на новый заказ
$mysqli->query("INSERT INTO orders_o (adress, fio, number, menu, date, oname, ztime, info, day, summ, nomer, bn, user) 
VALUES (
'".$b."', 
'".$c."|', 
'".$s."|', 
'".$e."', 
'".$date."', 
'".$d."|', 
'".$_POST['mztime']."|', 
'".$m."|','".$day."','".$f."', '".$table."', '".$_POST['bn']."', '0');") 
or die($mysqli->error);
print('Заказ успешно добавлен');
}else print('Массив данных пуст');
?>