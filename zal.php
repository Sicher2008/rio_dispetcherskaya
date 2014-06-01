<?php
error_reporting(1);
$q = $_GET['q'];
include("db.php");
$text = '';
$res = $mysqli->query("SELECT * FROM menu WHERE cat = $q AND price <> ''");
	while($row = $res->fetch_row()){
		$text .= trim($row[1]).' '.$row[2].'|';
	}
	print($text);
?>