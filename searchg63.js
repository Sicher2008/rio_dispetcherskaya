var sid = '';
var o = 1;
var visib = false;
var quer;
var ra;
var boxcont = '';
var type = 'adress';
var summ = '';
var foc = '';
function search(id, s, f) {
    type = id;
    quer = $("#" + id).val();
    if (quer.length > 2) {
        boxcont = '';
        $.post(f, {q: quer }, function (data) {

            if (data != '') {

                if (!visib) {
                    $("#" + s).fadeIn(100);
                    visib = true;
                }
                boxcont = '';
                ra = data.split('$$');
                for (var i = 0; i < Math.round(ra.length / 2); i++) {
                    boxcont = boxcont + '<div class="itm" cat="' + ra[i * 2 + 1] + '">' + ra[i * 2] + '</div>';
                }
                $("#" + s).html(boxcont);
                $(".itm").bind("click", itmclick);
            } else {
                $("#" + s).fadeOut(100);
                visib = false;
            }

        });

    } else {
        $("#box").fadeOut(100);
        visib = false;
    }
    foc = $("input:focus").attr('id');
};

function itmclick() {
    if (type == 'adress') {
        sid = $(this).attr("cat");
        $('#adress').val($(this).html());
        document.getElementById('dom').select();
    } else {
        //$("#order"+o).attr("value",$(this).html());
        //alert(foc);
        $("#" + foc).val($(this).html());
        o += 1;
        $("#mspis").append('<input type="text" class="inp4" autocomplete="off" id="order' + o + '" name="orders[]" onkeydown="AddField();" /><input type="text" class="inp1" autocomplete="off" id="kolvo' + o + '" name="kolvo[]" value="1" /><br>');
        document.getElementById('order' + o).select();
    }
    $("#box").fadeOut(100);
    $("#mlist").fadeOut(100);
    visib = false;
};

function addzakaz() {
    var outData = {
        adress: $("#adress").val(),
        fio: $("#fio").val(),
        number: $("#number").val(),
        text: $("#text").val(),
        id: sid,
        cmenu: o,
        mdom: $("#dom").val(),
        mabbr: $("#abbr").val(),
        mkorp: $("#korp").val(),
        mkv: $("#kv").val(),
        mofis: $("#ofis").val(),
        mpodz: $("#podz").val(),
        metaj: $("#etaj").val(),
        moname: $("#oname").val(),
        mztime: $("#ztime").val(),
        motdel: $("#fil").val(),
        bn: $(":radio[name=rachet]").filter(":checked").val(),
        summ: GoSumm(),
        menu: objToString(),
        user: getCookie('user')
    };

    $.ajax({
        url: 'takemy32.php',
        type: 'POST',
        data: outData,
        success: function (data) {
            $('#m_other').html(data);
            $('#modal').modal();
        }
    });
    $("#orders").html('<legend>Список заказываемой продукции:</legend><div id="mspis"><input type="text" class="inp4" autocomplete="off" id="order1" name="orders[]" onkeydown="AddField();" /><input type="text" class="inp1" autocomplete="off" id="kolvo1" name="kolvo[]" value="1" /><br></div><div id="mlist"></div><label class="radio inline"><input type="radio" name="rachet" value="0" checked> Наличный расчет</label><label class="radio inline"><input type="radio" name="rachet" value="1"> Безналичный расчет</label><input type="button" id="gsum" class="btn btn-large btn-primary btn-block" onclick="GoSumm(); $(\'#modal\').modal();" value="Сумма"/><input type="button" id="submit" class="btn btn-large btn-primary btn-block" onclick="addzakaz();" value="Добавить заказ"/>');
    document.getElementById('myform').reset();
    o = 1;
    sid = '';
    $('#otdel').attr('style', 'display:none');
    summ = '';
}

function AddField() {
    if(event.keyCode == 13){
        o += 1;
        $("#mspis").append('<input type="text" class="inp4" autocomplete="off" id="order' + o + '" name="orders[]" onkeydown="AddField();" /><input type="text" class="inp1" autocomplete="off" id="kolvo' + o + '" name="kolvo[]" value="1" /><br>');
        document.getElementById('order' + o).select();
    }else{
        search($("input:focus").attr('id'), 'mlist', 'smenu.php');
    }
}

function objToString() {
    var s = '';
    var m = '';
    for (i = 1; i < o; i++) {
        if ($("#order" + i).val()) {
            if (($("#kolvo" + i).val() * 1) > 99) {
                m = $("#kolvo" + i).val() + ' гр.';
            } else {
                m = $("#kolvo" + i).val();
            }
            s += $("#order" + i).val() + ' кол-во:' + m + '|';
            /* m = $("#order"+i).val();
             arr = m.split(" ");
             summ = summ * 1 + (arr[arr.length-1] * $("#kolvo"+i).val());
             arr = '';
             */
        }
    }
    return s + '|';
}

function conf(t, id) {
    var x = confirm("Отменить заказ?", "Отмена заказа")
    if (x) {
        $.get('otkaza63.php?key=dq34Wy7a5GDfZc0h&table=orders_' + t + '&id=' + id, function (data) {
            alert(data);
        });
        GetTable();
    }
}

function udriver(t) {
    var d = new Date();
    var h = d.getHours();
    if (h >= 14) {
        $.get('http://212.224.113.37/api.php?key=dq34Wy7a5GDfZc0h&type=udriver&table=orders_' + t, function (data) {
            if (data) {
                alert(data);
            }
        });
    }
}

function GoSumm() {
    var m = '';
    var sum = '';
    for (i = 1; i < o; i++) {
        if ($("#order" + i).val()) {
            if (($("#kolvo" + i).val() * 1) > 99) {
                m = $("#order" + i).val();
                arr = m.split(' ');
                sum = sum * 1 + arr[arr.length - 1] / 100 * $("#kolvo" + i).val();
            } else {
                m = $("#order" + i).val();
                arr = m.split(" ");
                sum = sum * 1 + (arr[arr.length - 1] * $("#kolvo" + i).val());
            }
            arr = '';
        }
    }
    $('#m_other').html('Стоимость заказа составляет: ' + sum + ' руб.');
    return sum;
}