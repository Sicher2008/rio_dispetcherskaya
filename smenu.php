<?php
error_reporting(1);
$q = $_POST['q'];
if(strlen($q)<3) exit;
include("db.php");
$text = '';
$res = $mysqli->query("SELECT * FROM menu WHERE name LIKE '%".$q."%' LIMIT 11");
$rn = mysqli_num_rows($res);
	while($row = $res->fetch_row()){
		$text .= trim($row[1]).' '.$row[2].'$$'.$row[0].'$$';
	}
	echo substr($text, 0, -2);
?>