<?php
    if (isset($_POST['login'])and isset($_POST['password'])){//авторизация

        $login = $_POST['login'];
        if ($login == ''){
            unset($login);
        }

        $password=$_POST['password'];
        if ($password =='') {
            unset($password);
        }

        if (empty($login) or empty($password)){
            exit ("Вы ввели не всю информацию, <a href=\"/\">вернитесь назад</a> и заполните все поля!");
            echo "<meta http-equiv='Refresh' content='0; URL=index.php'>";
        }

        $login = stripslashes($login);
        $login = htmlspecialchars($login);

        $password = stripslashes($password);
        $password = htmlspecialchars($password);

        $login = trim($login);
        $password = trim($password);

        $ip=getenv("HTTP_X_FORWARDED_FOR");
        if (empty($ip) || $ip=='unknown') {
            $ip=getenv("REMOTE_ADDR");
        }

        $mysqli->query("DELETE FROM oshibka WHERE UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date) > 900");

        $result = $mysqli->query("SELECT col FROM oshibka WHERE ip='".$ip."'");

        $myrow = mysqli_fetch_array($result);

        if ($myrow['col'] > 15) {
            exit("Вы набрали логин или пароль неверно 3 раза. Подождите 15 минут до следующей попытки.");
            echo "<meta http-equiv='Refresh' content='0; URL=index.php'>";
        }

        $solt = "b3p6f";
        $password = $password.$solt;
        $password = strrev($password);
        $password = md5($password);

        $result = $mysqli->query("SELECT * FROM users WHERE login='$login' AND password='$password'");
        $myrow = mysqli_fetch_array($result);
        if (empty($myrow['id'])){
            $select = $mysqli->query ("SELECT ip FROM oshibka WHERE ip='$ip'");
            $tmp = mysqli_fetch_row ($select);
            if ($ip == $tmp[0]) {
                $result52 = $mysqli->query("SELECT col FROM oshibka WHERE ip='$ip'");
                $myrow52 = mysqli_fetch_array($result52);

                $col = $myrow52[0] + 1;
                $mysqli->query ("UPDATE oshibka SET col=$col,date=NOW() WHERE ip='$ip'");
            }else{
                $mysqli->query ("INSERT INTO oshibka (ip,date,col) VALUES ('$ip',NOW(),'1')");
            }
            exit ("Извините, введённый вами логин или пароль неверный.  <a href=\"/\">Назад</a>");
            echo "<meta http-equiv='Refresh' content='900; URL=index.php'>";
        }else{
            $_SESSION['password']=$myrow['password'];
            $_SESSION['login']=$myrow['login'];
            $_SESSION['id']=$myrow['id'];
            //if (isset($_POST['save'])){
            //	setcookie("login", $_POST["login"], time()+9999999);
            //	setcookie("password", $_POST["password"], time()+9999999);
            //}
        }

        //echo "<meta http-equiv='Refresh' content='0; URL=index.php'>";
    }
    if (isset($_REQUEST['exit'])){//выход из профиля
        unset($_SESSION['login']);
        unset($_SESSION['password']);
    }

    $autorized=false;
    if (!empty($_SESSION['login']) and !empty($_SESSION['password'])){
        $login = $_SESSION['login'];
        $password = $_SESSION['password'];
        $result = $mysqli->query("SELECT login,password FROM users WHERE login='$login' AND password='$password'",$db);
        $myrow = mysqli_fetch_array($result);
        //извлекаем нужные данные о пользователе
    }
    if ((!isset($myrow['password']) or $myrow['password']=='') & (!isset($myrow['login']) or $myrow['login']=='')){
        $autorized=false;
    }else{
        $autorized=true;
    }
?>