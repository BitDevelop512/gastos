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
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
  <link rel="stylesheet" href="src/richtext.min.css">
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
          <h3>Mensajes Informativos</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <input type="hidden" name="editor" id="editor" class="form-control" value="" readonly="readonly">
                  <input type="hidden" name="usuario" id="usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly">
                  <textarea class="content" name="mensaje" id="mensaje"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="button" name="aceptar" id="aceptar" value="Enviar">
                </div>
            </form>
          </div>
          <div id="dialogo"></div>
        </div>
      </div>
    </div>
  </section>
</div>
<style>
.ui-widget-header
{
  color: #000000;
  font-weight: bold;
}
</style>
<script type="text/javascript" src="src/jquery.richtext.js"></script>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 170,
    width: 450,
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
    buttons: {
      "Aceptar": function() {
        $(this).dialog("close");
        grabar();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $(".content").richText();
  inicio();
});
function inicio()
{
  var editor = $("#editor").val();
  $("#"+editor).focus();
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo").html(detalle);
  $("#dialogo").dialog("open");
  $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function grabar()
{
  var usuario = $("#usuario").val();
  var mensaje = $("#mensaje").val();
  mensaje = mensaje.replace(/[•]+/g, "*");
  mensaje = mensaje.replace(/[●]+/g, "*");
  mensaje = mensaje.replace(/[é́]+/g, "é");
  mensaje = mensaje.replace(/[]+/g, "*");
  mensaje = mensaje.replace(/[]+/g, "*");
  mensaje = mensaje.replace(/[]+/g, "*");
  mensaje = mensaje.replace(/[ ]+/g, " ");
  mensaje = mensaje.replace(/[ ]+/g, '');
  mensaje = mensaje.replace(/[–]+/g, "-");
  mensaje = mensaje.replace(/[—]+/g, '-');
  mensaje = mensaje.replace(/[…]+/g, "..."); 
  mensaje = mensaje.replace(/[“”]+/g, '"');
  mensaje = mensaje.replace(/[‘]+/g, '´');
  mensaje = mensaje.replace(/[’]+/g, '´');
  mensaje = mensaje.replace(/[′]+/g, '´');
  mensaje = mensaje.replace(/[']+/g, '´');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "men_grab.php",
    data:
    {
      usuario: usuario,
      mensaje: mensaje
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
      var salida = registros.salida;
      if (salida == "1")
      {
        $("#aceptar").hide();
        var editor = $("#editor").val();
        $("#"+editor).html('');
        alerta1("Mensaje enviado correctamente");
      }
      else
      {
        alerta("Error durante el envío del mensaje");
      }
    }
  });
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
// 20/12/2023 - Mensajes
?>