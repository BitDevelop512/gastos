<!doctype html>
<?php
session_start();
error_reporting(0);
date_default_timezone_set("America/Bogota");
require('conf.php');
function decrypt2($string, $key)
{
  $result = '';
  $string = base64_decode($string);
  for ($i=0; $i<strlen($string); $i++)
  {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result .= $char;
  }
  return $result;
}
function hourIsBetween1($from, $to, $input)
{
  $dateFrom = DateTime::createFromFormat('!H:i', $from);
  $dateTo = DateTime::createFromFormat('!H:i', $to);
  $dateInput = DateTime::createFromFormat('!H:i', $input);
  if ($dateFrom > $dateTo) $dateTo->modify('+1 day');
  return ($dateFrom <= $dateInput && $dateInput <= $dateTo) || ($dateFrom <= $dateInput->modify('+1 day') && $dateInput <= $dateTo);
}
$ano = date('Y');
$fecha = date('d/m/Y');
$fecha1 = strtoupper(md5($fecha));
$fecha1 = substr($fecha1,0,10);
$v1 = $_GET['v1'];                                              // Interno
$v2 = $_GET['v2'];                                              // Usuario
$v3 = $_GET['v3'];                                              //
$v4 = $_GET['v4'];                                              //
$v4 = decrypt2($v4, "cx");
$v5 = explode(":", $v4);
$v6 = $v5[0];
$v7 = $v5[1];
$v6 = intval($v6);
$v8 = $v6+1;
$v8 = $v8.":".$v7;
$v9 = date('H:i');
$val_hora = (hourIsBetween1($v4, $v8, $v9) ? '1' : '0');
if (trim($fecha1) == ($v3))
{
  $val_fecha = "1";
  $val_hora = $val_hora;
}
else
{
  $val_fecha = "0";
  $val_hora = "0";
}
$consu = "SELECT nombre, clave FROM cx_usu_web WHERE conse='$v1' AND usuario='$v2'";
$cur = odbc_exec($conexion, $consu);
$nom_usuario = trim(utf8_encode(odbc_result($cur,1)));
$cla_usuario = trim(odbc_result($cur,2));
?>
<html lang="es">
<head>
  <title>:: SIGAR :: Sistema Integrado de Gastos Reservados ::</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta http-equiv="Expires" content="0">
  <link rel="shortcut icon" href="imagenes/cx.ico">
  <link rel="icon" href="imagenes/cx.ico" type="image/ico">
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
</head>
<body style="overflow-x:hidden; overflow-y:auto;">
<?php
include('encabezado.php');
?>
<div>
  <section class="content-header">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="soportes">
          <h3>Cambio de Clave</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  A continuaci&oacute;n podr&aacute; cambiar su clave.
                  <hr><center><b>Reglas generales de validaci&oacute;n del password:</b></center><br>
                  1) El password debe contener entre <strong>6 - 10 caracteres</strong> de longitud.
                  <br>2) El password debe contener al menos <strong>una letra may&uacute;scula</strong>.
                  <br>3) El password debe contener al menos <strong>una letra min&uacute;scula</strong>.
                  <br>4) El password debe contener al menos <strong>un n&uacute;mero</strong>.
                  <br>5) La validaci&oacute;n del password diferencia <strong>may&uacute;sculas y min&uacute;sculas</strong>.
                  <hr>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Usuario:</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="hidden" name="conse" id="conse" class="form-control" value="<?php echo $v1; ?>" tabindex="1" readonly="readonly">
                  <input type="text" name="login" size="15" class="form-control" value="<?php echo $v2; ?>" tabindex="2" onfocus="blur();" readonly="readonly">
                  <input type="hidden" name="valida1" id="valida1" class="form-control" value="<?php echo $val_fecha; ?>" readonly="readonly">
                  <input type="hidden" name="valida2" id="valida2" class="form-control" value="<?php echo $val_hora; ?>" readonly="readonly">
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Nombre Usuario:</font></div></label>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <input type="text" name="nombre" size="45" class="form-control" value="<?php echo $nom_usuario; ?>" tabindex="3" onfocus="blur();" readonly="readonly">
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Password:</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="password" name="clave1" id="clave1" class="form-control" maxlength="10" tabindex="4">
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Confirmaci&oacute;n:</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="password" name="clave2" id="clave2" class="form-control" maxlength="10" tabindex="5">
                </div>
              </div>
              <center>
                <input type="button" name="aceptar" id="aceptar" value="Actualizar" tabindex="6" onclick="valida(this.form.clave1.value)">
                <input type="hidden" name="clave3" id="clave3" class="form-control" value="<?php echo $cla_usuario; ?>" tabindex="7" readonly="readonly">
              </center>
            </td>
          </tr>
        </table>
      </form>
      <div id="dialogo"></div>
    </div>
  </div>
</div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
    width: 470,
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
  $("#aceptar").button();
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#clave1").focus();
  link();
});
function link()
{
  var valida1 = $("#valida1").val();
  var valida2 = $("#valida2").val();
  if (valida1 == "0")
  {
    $("#clave1").prop("disabled", true);
    $("#clave2").prop("disabled", true);
    $("#aceptar").hide();
    var detalle = "<center><h3>Link deshabilitado por vencimiento de fecha permitida</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    if (valida2 == "0")
    {
      $("#clave1").prop("disabled", true);
      $("#clave2").prop("disabled", true);
      $("#aceptar").hide();
      var detalle = "<center><h3>Link deshabilitado por vencimiento de hora permitida</h3></center>";
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
    else
    {
      $("#clave1").prop("disabled", false);
      $("#clave2").prop("disabled", false);
      $("#clave1").val('');
      $("#clave2").val('');
      $("#clave1").focus();
    }
  }
}
function graba()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "clav_actu.php",
    data:
    {
      conse: $("#conse").val(),
      clave: $("#clave1").val(),
      clave1: $("#clave3").val()
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
      var valida, detalle;
      valida = registros.salida;
      if (valida == "1")
      {
        redirecciona();
      }
      else
      {
        if (valida == "2")
        {
          detalle = "<center><h3>Password Actual No Válido</h3></center>";
        }
        else
        if (valida == "0")
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
        }
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function valida(tx)
{
  var tx;
  if ((formu.clave1.value) != (formu.clave2.value))
  {
    detalle = "<center><h3>El Password y la Confirmación No Concuerdan</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    return (false);
  }
  var nMay = 0, nMin = 0, nNum = 0;
  var t1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  var t2 = "abcdefghijklmnopqrstuvwxyz";
  var t3 = "0123456789";
  if (tx.length < 6)
  {
    detalle = "<center><h3>El Password debe tener al menos 6 caracteres</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    return (false);
  }
  else
  {
    for (i=0;i<tx.length;i++)
    {
      if (t1.indexOf(tx.charAt(i)) != -1 ) {nMay++}
      if (t2.indexOf(tx.charAt(i)) != -1 ) {nMin++}
      if (t3.indexOf(tx.charAt(i)) != -1 ) {nNum++}
    }
    if (nMay>0 && nMin>0 && nNum>0)
    {
      graba();
    }
    else
    {
      detalle = "<center><h3>El Password no cumple con las Reglas Generales</h3></center>";
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      return (false);
    }
  }
}
function redirecciona()
{
  location.href = "index.php";
}
</script>
</body>
</html>