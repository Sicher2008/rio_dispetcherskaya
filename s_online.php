<?php
error_reporting(1);
$q = $_GET['q'];
if (strlen($q) < 3) exit;
include("db.php");
$text = '';
$res = $mysqli->query("SELECT * FROM streets WHERE st LIKE '%" . $q . "%'") or die(mysql_error());
$rn = mysqli_num_rows($res);
while ($row = $res->fetch_row()) {
    if (trim($row[2])) {
        $row[2] = '[' . $row[2] . ']';
    }
    $text .= trim($row[1]) . ' (' . $row[3] . ')$$' . $row[0] . '$$';
}
echo substr($text, 0, -2);
?>