<?
include("session.php");
include("db.php");
include("auth.php");
if (!$autorized) {
    include("min_index.php");
    exit();
}
header("Content-Type: text/html; charset=UTF-8");
?>
    <script>
        function GoAdd(url) {
            $.get('gonline.php?' + url, function (data) {
                alert(data);
                OnlineClick();
            });
        }

        function Oedit(id) {
            var x = $('#d_menu_' + id).val();
            var y = $('#d_info_' + id).val();
            var a = x.replace(/\r\n|\r|\n/g, '|');
            $.get('oedit.php?m=' + a + '&id=' + id + '&d=' + y, function (data) {
                alert(data);
                $('#od_' + id).modal('hide');
                OnlineClick();
            });
        }
    </script>
<?php
//error_reporting(1);
date_default_timezone_set('Europe/Moscow');
?>
<div class="hero-unit">
    <table class="table">
    <tr>
        <th>№</th>
        <th>Адрес</th>
        <th>ФИО (Организ.)</th>
        <th>Номер телефона</th>
        <th>Время</th>
        <th>Сумма</th>
        <th>Статус</th>
        <th>Комментарий</th>
    </tr>
<?
$i = 1;
$result = $mysqli->query("SELECT * FROM orders_o ORDER by id ASC");
while ($row = $result->fetch_array()) {
    $menu = str_replace("|", PHP_EOL, $row[4]);
    $row[4] = str_replace("|", "<br>", $row[4]);
    $row = str_replace("|", "", $row);
    ?>
    <div id="o_<?= $row[0] ?>" class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Заказ № <?= $row[0] ?></h3>
        </div>
        <div class="modal-body">
            <?= $row[4] ?>
        </div>
    </div>

    <div id="od_<?= $row[0] ?>" class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Заказ № <?= $row[0] ?></h3>
        </div>
        <div class="modal-body">
            <textarea id="d_menu_<?= $row[0] ?>" class="input-block-level" name="text" cols="70"
                      rows="10"><?= $menu ?></textarea>
            <textarea id="d_info_<?= $row[0] ?>" class="input-block-level" name="text" cols="70"
                      rows="5"><?= $row[8] ?></textarea>
            <input type="button" id="d_edit" class="btn btn-large btn-primary btn-block"
                   onclick="Oedit('<?= $row[0] ?>');" value="Редактировать"/>
        </div>
    </div>
    <?
    if ($row[17] == 0){
        $status = '<a href="javascript:{}" onclick="GoAdd(\'id=' . $row[0] . '\');">о</a>
        /<a href="javascript:{}" onclick="GoAdd(\'t=2&id=' . $row[0] . '\');">у</a>
        /<a href="javascript:{}" onclick="$(\'#od_' . $row[0] . '\').modal();">р</a>';
    } else{
        $status = 'Отправлен';
    }
    ?>

    <tr>
    <td align="center">
    <a href="javascript:{}" onclick="$('#o_<?= $row[0] ?>').modal();"><?= $i ?></a>
    </td>
    <td class="<?= $td ?>"><?= $row[1] ?></td>
    <td align="center" class="<?=  $td ?>"><?=  $row[2] ?> <?=  $row[6] ?></td>
    <td align="center" class="<?=  $td ?>"><?=  $row[3] ?></td>
    <td align="center" class="<?=  $td ?>"><?=  $row[5] ?></td>
    <td align="center" class="<?=  $td ?>"><?=  $row[12] ?>  руб.</td>
    <td><?=  $status ?></td><td><?=  $row[8] ?></td></tr>

    <?
    $i++;
}
?>
</table></div>
