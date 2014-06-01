<?php
    /* Подключение к серверу MySQL */
    //ini_set("display_errors", 0);
    //ini_set("error_reporting", E_NONE);
    $mysqli = new mysqli('localhost', 'root', '', 'rio_dispetcherskaya');
    $mysqli->query('SET NAMES  utf8');
    if (mysqli_connect_errno()) {
       printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
       exit();
    }
?>