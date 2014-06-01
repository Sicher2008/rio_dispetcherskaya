<?
    if (!$autorized) {
        include("index.php");
        exit();
    }
?>
<style>
    body {
        padding-top: 60px;
    }

    .inp4 {
        display: block;
        width: 80%;
        min-height: 30px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .inp1 {
        display: block;
        width: 20%;
        min-height: 30px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    #box, #mlist {
        display: none;
        position: absolute;
        width: 300px;
        z-index: 99;
        left: auto;
        top: auto;
        background-color: #EEF2F6;
        border-radius: 10px;
        padding-bottom: 5px;
    }

    .itm {
        height: 25px;
        cursor: pointer;
        padding-left: 3px;
        padding-top: 2px;
        font-size: 12px;
        margin-top: 2px;
    }

    .itm:hover {
        background-color: #6D8EB2;
        color: #fff;
    }
</style>
<script type="text/javascript" src="searchg63.js"></script>
<script>
    var o_count = 0;
    function getCookie(name) {
        var begin = document.cookie.indexOf(name + '=');
        if (-1 == begin) return null;
        begin += name.length + 1;
        end = document.cookie.indexOf('; ', begin);
        if (-1 == end) end = document.cookie.length;
        return document.cookie.substring(begin, end);
    }
    function setCookie(name, value) {
        var today = new Date();
        var expiration = new Date(today.getTime() + 31 * 24 * 60 * 60 * 1000);  // 31 день
        document.cookie = name + '=' + value + '; path=/; expires=' + expiration.toGMTString();
    }
    function GoUser() {
        var id = $('#user').val();
        setCookie('user', id);
        window.location = '';
    }
    //Проверка на выбора оператора
    $(document).ready(function () {
        var u = getCookie('user');
        if (!u) {
            $('#modal').modal();
        }

    });
    function GetOperator() {
        var a = (new Date()).getDay();
        var h = (new Date()).getHours();
        var b = 5;
        if ((a == 6) || (a == 7) || (h >= 17)) {
            b = 5;
        } else {
            b = 3;
        }
        if (getCookie('user') == b) {
            $('#a_online').attr('style', 'display:yes;');
        }
        return b;
    }
    function GoTabs(a, b, c, d, e) {
        $('#' + a).attr('style', 'display:yes');
        $('#' + b).attr('style', 'display:none');
        $('#' + c).attr('style', 'display:none');
        $('#' + d).attr('style', 'display:none');
        $('#' + e).attr('style', 'display:none');
    }
    function GetTable(u) {
        u = u || '';
        var a = '';
        var b = '';
        if ($('#lsr1').val()) {
            a = $('#lsr1').val()
        }
        $.get('list.php?type=1&s=' + a + '&user=' + u, function (data) {
            $('#list_10').html(data);
        });
        if ($('#lsr2').val()) {
            b = $('#lsr2').val()
        }
        $.get('list.php?type=2&s=' + b + '&user=' + u, function (data) {
            $('#list_2').html(data);
        });
        $.get('list_online.php', function (data) {
            $('#d_online').html(data);
        });

        $.get('count_list.php?id=' + u, function (data) {
            $('#count').html(data);
        });
    }
    ;
    function key(k) {
        window.status = event.keyCode;
        if (event.keyCode == 13) {
            if (k == 'fio') {
                if (!sid) $('#otdel').attr('style', 'display:yes');
            }
            document.getElementById(k).select();
        }
    }
    ;
    function GoNline() {
        $.get('gonline32rio.php?t=1', function (data) {
            if (o_count < data) {
                o_count = data;
                /* if (getCookie('user') == GetOperator()){$('#a_online').attr('style','display:yes; background:red;'); } */
                $('#a_online').attr('style', 'display:yes; background:red;');
                var audio = document.getElementsByTagName("audio")[0];
                audio.play();
            }
        });
    }
    function OnlineClick() {
        $.get('list_online.php', function (data) {
            $('#d_online').html(data);
        });
        //if (getCookie('user') == GetOperator()){$('#a_online').attr('style','display:yes; background:transparent;'); }
        $('#a_online').attr('style', 'display:yes; background:transparent;');
    }
    setInterval('GoNline()', 2000);
    GetTable();
</script>
<audio>
    <source src="1.mp3">
</audio>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="/">Рио Диспетчер ver 2.1</a>
            <ul class="nav">
                <li class="active"><a href="javascript:{}"
                                      onclick="GoTabs('forms','list_10','list_2','d_online','count');">Форма</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">10 Микрорайон <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:{}"
                               onclick="GoTabs('list_10','forms','list_2','d_online','count'); GetTable(getCookie('user'));">Мои
                                заявки</a></li>
                        <li><a href="javascript:{}"
                               onclick="GoTabs('list_10','forms','list_2','d_online','count'); GetTable();">Общий
                                список</a></li>
                        <li><a href="javascript:{}"
                               onclick="GoTabs('count','list_10','forms','list_2','d_online'); GetTable('orders_10');">Кол-во
                                продаж</a></li>
                        <!--  <li><a href="javascript:{}" onclick="alert('Идет калибровка таблицы disp_stats. Подождите.');">Кол-во продаж</a></li> -->
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">2 Брянск <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:{}"
                               onclick="GoTabs('list_2','forms','list_10','d_online','count'); GetTable(getCookie('user'));">Мои
                                заявки</a></li>
                        <li><a href="javascript:{}"
                               onclick="GoTabs('list_2','forms','list_10','d_online','count'); GetTable();">Общий
                                список</a></li>
                        <li><a href="javascript:{}"
                               onclick="GoTabs('count','list_10','forms','list_2','d_online'); GetTable('orders_2');">Кол-во
                                продаж</a></li>
                        <!-- <li><a href="javascript:{}" onclick="alert('Идет калибровка таблицы disp_stats. Подождите.');">Кол-во продаж</a></li> -->
                    </ul>
                </li>
                <li id="a_online" style="display:yes;"><a href="javascript:{}"
                                                          onclick="GoTabs('d_online','forms','list_10','list_2'); OnlineClick();">Заказы
                        онлайн</a></li>
                <li id="exit" style="display:yes;">
                    <form action="/" method="post">
                        <input type="submit" name="exit" value="Выйти"
                               style="width: 150px;margin-left: 80px;margin-top: 10px;">
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Сетка -->
<div class="container-fluid fill" id="forms">
    <div class="span5 hero-unit filler">
        <form id="myform" method="POST">
            <fieldset>
                <legend>Информация о клиенте</legend>
                <label>Номер телефона:</label>
                <input type="text" class="input-block-level" maxlength="100" autocomplete="off" id="number"
                       name="number" onkeydown="key('adress');"/>

                <label>Адрес доставки:</label>
                <input type="text" class="input-block-level" maxlength="100" autocomplete="off" id="adress"
                       name="adress" onkeydown="search('adress','box','engine.php'); key('dom');"/>

                <div id="box"></div>
                <table>
                    <tr>
                        <td>Дом:</td>
                        <td>Аббр:</td>
                        <td>Корпус:</td>
                        <td>Кв:</td>
                    </tr>
                    <tr>
                        <td><input type="text" class="input-block-level" autocomplete="off" id="dom" name="dom"
                                   onkeydown="key('abbr');"/></td>
                        <td><input type="text" class="input-block-level" autocomplete="off" id="abbr" name="abbr"
                                   onkeydown="key('korp');"/></td>
                        <td><input type="text" class="input-block-level" autocomplete="off" id="korp" name="korp"
                                   onkeydown="key('kv');"/></td>
                        <td><input type="text" class="input-block-level" autocomplete="off" id="kv" name="kv"
                                   onkeydown="key('ofis');"/></td>
                    </tr>
                    <tr>
                        <td>Офис:</td>
                        <td>Подъезд:</td>
                        <td>Этаж:</td>
                    </tr>
                    <td><input type="text" class="input-block-level" autocomplete="off" id="ofis" name="ofis"
                               onkeydown="key('podz');"/></td>
                    <td><input type="text" class="input-block-level" autocomplete="off" id="podz" name="podz"
                               onkeydown="key('etaj');"/></td>
                    <td><input type="text" class="input-block-level" autocomplete="off" id="etaj" name="etaj"
                               onkeydown="key('fio');"/></td>
                </table>

                <div id="otdel" style="display:none;"><label>Выбор отделения:</label>
                    <select class="input-block-level" id="fil" name="fil" style="width: 304px;">
                        <option value="">Укажите отделение</option>
                        <option value="orders_10">Бежицкий район</option>
                        <option value="orders_2">2 Брянск</option>
                    </select>
                </div>

                <label>ФИО:</label>
                <input type="text" class="input-block-level" maxlength="100" autocomplete="off" id="fio" name="fio"
                       onkeydown="key('oname');"/>

                <label>Название организации:</label>
                <input type="text" class="input-block-level" maxlength="100" autocomplete="off" id="oname" name="oname"
                       onkeydown="key('ztime');"/>

                <label>Время заказа:</label>
                <input type="text" class="input-block-level" maxlength="100" autocomplete="off" id="ztime" name="ztime"
                       onkeydown="key('text');"/>

                <label>Дополнительная информация:</label>
                <textarea id="text" class="input-block-level" name="text" cols="70" rows="2"/></textarea>
            </fieldset>
    </div>
    <div class="span5 hero-unit filler">
        <fieldset id="orders">
            <legend>Список заказываемой продукции:</legend>
            <div id="mspis"><input type="text" class="inp4" autocomplete="off" id="order1" name="orders[]"
                                   onkeydown="AddField();"/><input type="text" class="inp1" autocomplete="off"
                                                                   id="kolvo1" name="kolvo[]" value="1"/><br></div>
            <div id="mlist"></div>

            <label class="radio inline">
                <input type="radio" name="rachet" value="0" checked> Наличный расчет
            </label>
            <label class="radio inline">
                <input type="radio" name="rachet" value="1"> Безналичный расчет
            </label>
            <input type="button" id="gsum" class="btn btn-large btn-block" onclick="GoSumm(); $('#modal').modal();"
                   value="Сумма"/>
            <input type="button" id="submit" class="btn btn-large btn-primary btn-block" onclick="addzakaz();"
                   value="Добавить заказ"/>
        </fieldset>
    </div>
    </form>
</div>
<!-- Сетка -->

<!-- Блок информации -->
<div class="container" id="list_10" style="display:none"></div>

<div class="container" id="list_2" style="display:none"></div>

<div class="container" id="d_online" style="display:none"></div>

<div class="container" id="count" style="display:none"></div>
<!-- Блок информации -->
<script type="text/javascript" src="templates/bootstrap/js/bootstrap.min.js"></script>

<!-- Модальное окно -->
<div id="modal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Информация</h3>
    </div>
    <div class="modal-body" id="m_other">
        <label>Выберите оператора:</label>
        <select id="user">
            <option value="1">Оператор 1</option>
            <option value="2">Оператор 2</option>
            <option value="3">Оператор 3</option>
            <option value="4">Оператор 4</option>
            <option value="5">Оператор 5</option>
        </select><br />
        <input type="button" id="gsum" class="btn btn-large btn-primary" onclick="GoUser();" value="Войти"/>
    </div>
</div>
<!-- Модальное окно -->