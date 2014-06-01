<?php
    /* Подключение к серверу MySQL */
    //ini_set("display_errors", 0);
    //ini_set("error_reporting", E_NONE);
    $mysqli = new mysqli('212.224.113.37', 'rio32ru', 'aI,Q!#*{#WB9', 'rio32ru');
    $mysqli->query('SET NAMES  utf8');
    if (mysqli_connect_errno()) {
       printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
       exit();
    }
?>