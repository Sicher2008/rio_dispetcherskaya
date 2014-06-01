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
if ($_POST['adress']){
$date = date("H:i:s").'|';
$day = date("dmy");
# Соединяемся с базой
include("db.php");
# Деления на дома
$_POST['mabbr'] = _strtolower($_POST['mabbr']);
$str = str_replace("|", "", $_POST['adress']);
$home = str_replace("|", "", $_POST['mdom']);
$ab = trim(str_replace("|", "", $_POST['mabbr']));

$st = explode(' ',$str);
$s = $st[0].' '.$st[1];
//print($s);
if ($result = $mysqli->query("SELECT dom FROM streets WHERE st LIKE '%".$s."%'")){
$row = $result->fetch_array();
if (trim($row[0])){
$dr = explode(',',$row[0]);
if (in_array($home.$ab, $dr)) $_POST['motdel'] = 'orders_2';
}
}
# Определяем куда пойдет заказ
if ($_POST['motdel']){
$table = $_POST['motdel'];
}else{
$st = $mysqli->query("SELECT fil FROM streets WHERE id = ".$_POST['id']);
$row = $st->fetch_assoc();
if ($row['fil'] == 1) $table = 'orders_10'; else $table = 'orders_2';
}
NumbFile($table.'.txt');
# Получаем данные
if ($_POST['mdom']) $dom = ' [дом '.$_POST['mdom'].']';
if ($_POST['mabbr']) $abbr = ' [абр. '.$_POST['mabbr'].']';
if ($_POST['mkorp']) $korp = ' [корп. '.$_POST['mkorp'].']';
if ($_POST['mkv']) $kv = ' [кв. '.$_POST['mkv'].']';
if ($_POST['mofis']) $ofis = ' [офис '.$_POST['mofis'].']';
if ($_POST['mpodz']) $podz = ' [подъезд '.$_POST['mpodz'].']';
if ($_POST['metaj']) $etaj = ' [этаж '.$_POST['metaj'].']';
if ($_POST['moname'] == 'Введите название организации...') $_POST['moname'] = '';
if ($_POST['mztime'] == 'Введите время доставки...') $_POST['mztime'] = '';
if ($_POST['bn'] > 0) $_POST['text'] = $_POST['text'].'|Безналичный расчет';
$_POST['menu'] = substr($_POST['menu'], 0, strlen($_POST['menu'])-1);

$adress = mysqli_escape_string($mysqli,$_POST['adress']).$dom.$abbr.$korp.$podz.$etaj.$kv.$ofis.'|';

# Выполняем запрос на новый заказ
$mysqli->query("INSERT INTO ".$table." (adress, fio, number, menu, date, oname, ztime, info, day, summ, nomer, bn, user) 
VALUES (
'".$adress."', 
'".mysqli_escape_string($mysqli,$_POST['fio'])."|', 
'".mysqli_escape_string($mysqli,$_POST['number'])."|', 
'".mysqli_escape_string($mysqli,$_POST['menu'])."', 
'".$date."', 
'".mysqli_escape_string($mysqli,$_POST['moname'])."|', 
'".mysqli_escape_string($mysqli,$_POST['mztime'])."|', 
'".mysqli_escape_string($mysqli,$_POST['text'])."|','".$day."','".mysqli_escape_string($mysqli,$_POST['summ'])."', '".$num."', '".$_POST['bn']."', '".$_POST['user']."');") 
or die($mysqli->error);
//include("sclad.php");
print('Заказ успешно добавлен');
}else print('Массив данных пуст');
?>