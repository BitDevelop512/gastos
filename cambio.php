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
  include('permisos.php');
  $tipo = $_GET["tipo"];
  $mensaje = $_GET["mensaje"];
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
</head>
<body style="overflow-x:hidden; overflow-y:auto;">
<?php
include('titulo.php');
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
                  <?php
                  if ($mensaje == "0")
                  {
                  ?>
                    A continuaci&oacute;n debera cambiar y confirmar la clave que le fue asignada por defecto.
                  <?php
                  }
                  else
                  {
                  ?>
                    A continuaci&oacute;n podr&aacute; cambiar su clave.
                  <?php
                  }
                  ?>
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
                  <input type="hidden" name="conse" id="conse" class="form-control" value="<?php echo $con_usuario; ?>" tabindex="1" readonly="readonly">
                  <input type="text" name="login" size="15" class="form-control" value="<?php echo $usu_usuario; ?>" tabindex="2" onfocus="blur();" readonly="readonly">
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
                <input type="hidden" name="tipo" id="tipo" class="form-control" value="<?php echo $tipo; ?>" tabindex="8" readonly="readonly">
                <input type="hidden" name="v_men" id="v_men" class="form-control" value="<?php echo $mensaje; ?>" tabindex="9" readonly="readonly">
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
    width: 350,
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
});
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
        var valida1 = $("#tipo").val();
        var valida2 = $("#v_men").val();
        if (valida2 == "0")
        {
          if (valida1 == "0")
          {
            redirecciona();         
          }
          else
          {
            redirecciona1();
          }
        }
        else
        {
          redirecciona2();
        }
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
  location.href = "usu_compania.php";
}
function redirecciona1()
{
  location.href = "principal.php";
}
function redirecciona2()
{
  top.location.href = "principal.php";
}
</script>
</body>
</html>
<?php
}
?>