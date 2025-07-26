<!doctype html>
<?php
session_start();
error_reporting(0);
$_SESSION["chat"] = "SI";
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('conf.php');
  include('funciones.php');
  include('permisos.php');
  $mes = date('m');
  $mes = intval($mes);
  $ano = date('Y');
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
  <script type="text/javascript" src="alertas/lib/alertify.js"></script>
  <link rel="stylesheet" href="alertas/themes/alertify.core.css"/>
  <link rel="stylesheet" href="alertas/themes/alertify.default.css"/>
</head>
<body style="overflow-x:hidden; overflow-y:hidden;">
<?php
include('titulo.php');
?>
<div>
  <section class="content-header">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="soportes">
          <h3>Consulta Recursos Formalizados</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo de Recurso</font></label>
                  <?php
                  $menu2_2 = odbc_exec($conexion,"SELECT * FROM cx_ctr_pag WHERE codigo IN ('36', '38', '39', '40', '42', '44', '45', '46') ORDER BY codigo");
                  $menu2 = "<select name='gasto' id='gasto' class='form-control select2' multiple='multiple' data-placeholder='&nbsp;Seleccione uno o mas recursos'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu2_2))
                  {
                    $nombre = trim(utf8_encode($row['nombre']));
                    $menu2 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  $menu2 .= "\n</select>";
                  echo $menu2;
                  ?>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Unidad</font></label>
                  <?php
                  $menu1_1 = odbc_exec($conexion,"SELECT subdepen, sigla FROM dbo.cf_sigla(1) ORDER BY sigla");
                  $menu1 = "<select name='unidad' id='unidad' class='form-control select2'>";
                  $i = 1;
                  $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
                  while($i<$row=odbc_fetch_array($menu1_1))
                  {
                    $nombre = trim($row['sigla']);
                    $menu1 .= "\n<option value=$row[subdepen]>".$nombre."</option>";
                    $i++;
                  }
                  $menu1 .= "\n</select>";
                  echo $menu1;
                  ?>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">&nbsp;</font></label>
                  <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <center>
                    <input type="button" name="consultar" id="consultar" value="Consultar">
                  </center>
                </div>
              </div>
            </form>
            <form name="formu_excel" id="formu_excel" action="recursos_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
            </form>
          </div>
          <div id="dialogo"></div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
<style>
.ui-widget-header
{
  color: #000000;
  font-weight: bold;
}
</style>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 7,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };
  $.datepicker.setDefaults($.datepicker.regional['es']);
  $("#load").hide();
  $("#fecha1").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fecha2").prop("disabled", false);
      $("#fecha2").datepicker("destroy");
      $("#fecha2").val('');
      $("#fecha2").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha1").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
    },
  });
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 230,
    width: 500,
    modal: true,
    closeOnEscape: false,
    resizable: false,
    draggable: false,
    show:
    {
      effect: "blind",
      duration: 1000
    },
    hide:
    {
      effect: "explode",
      duration: 1000
    },
    buttons: [
      {
        text: "Ok",
        click: function() {
          $(this).dialog("close");
        }
      }
    ]
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#gasto").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#unidad").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
});
function consultar()
{
  var salida = true;
  var gasto = $("#gasto").select2('val');
  var unidad = $("#unidad").val();
  var fecha2 = $("#fecha2").val();
  if (fecha2 == "")
  {
    salida = false;
    alerta("Debe seleccionar fecha final");
  }
  var fecha1 = $("#fecha1").val();
  if (fecha1 == "")
  {
    salida = false;
    alerta("Debe seleccionar fecha inicial");
  }
  if (salida == false)
  {
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "recu_consu1.php",
      data:
      {
        gasto: gasto,
        unidad: unidad,
        fecha1: $("#fecha1").val(),
        fecha2: $("#fecha2").val()
      },
      beforeSend: function ()
      {
        $("#load").show();
      },
      error: function ()
      {
        $("#load").hide();
      },
      success: function (data)
      {
        $("#load").hide();
        var registros = JSON.parse(data);
        $("#paso_excel").val(registros.valores);
        excel();
      }
    });
  }
}
function excel()
{
  formu_excel.submit();
}
function alerta(valor)
{
  alertify.error(valor);
}
function alerta1(valor)
{
  alertify.success(valor);
}
</script>
</body>
</html>
<?php
}
// 11/03/2024 - Ajuste consulta cambio de siglas
?>