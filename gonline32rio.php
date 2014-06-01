<?php
    include ("session.php");
    include ("db.php");
    include ("auth.php");
	if (!$autorized){
		include ("min_index.php");
		exit();
	}

	if ($_GET['t'] == '1') {
		$result = $mysqli->query("select count(*) from orders_o");
		$row = $result->fetch_array();
		print($row[0]);
	} elseif ($_GET['t'] == '2') {
		if (!$_GET['id']) {
			die();
		}
		if ($res = $mysqli->query("DELETE FROM orders_o WHERE id = " . $_GET['id'])) {
			print('Запись успешно удалена');
		} else {
			print('Ошибка при удалении');
		}
	} else {
		if (!$_GET['id']) {
			die();
		}
		$result = $mysqli->query("SELECT nomer FROM orders_o WHERE id = " . $_GET['id']);
		$row = $result->fetch_array();
		$query = "INSERT INTO orders_" . $row[0] . "
			(adress,fio,number,menu,date,oname,ztime,info,driver,status,day,summ,otk,nomer,bn,user,type)
			SELECT adress,fio,number,menu,date,oname,ztime,info,driver,status,day,summ,otk,nomer,bn,user,type
			FROM orders_o
			WHERE id = " . $_GET['id'];
		if ($res = $mysqli->query($query) or die($mysqli->error)) {
			$mysqli->query("UPDATE orders_o SET type = 1 WHERE id = " . $_GET['id']);
			print('Данные успешно обновлены');
		} else {
			print('Ошибка при добавлении');
		}
	}
?>