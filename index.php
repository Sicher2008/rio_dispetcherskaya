<?php
header("Content-Type: text/html; charset=UTF-8");
include ("session.php");
include ("db.php");
include ("auth.php");
?>
<html>
<head>
<?
	include ("head.php");
?>
</head>
<body>
<?
if (!$autorized){
	include ("auth_form.php");
}else{
	if (isset($_REQUEST["page"])){
		include ($_REQUEST["page"].".php");
	}else{
		include ("main_page.php");
	}
}
?>
</body>
</html>