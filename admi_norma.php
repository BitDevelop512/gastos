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
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
  <script type="text/javascript" src="alertas/lib/alertify.js"></script>
  <link rel="stylesheet" href="alertas/themes/alertify.core.css">
  <link rel="stylesheet" href="alertas/themes/alertify.default.css">
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
          <h3>Cargue Normatividad</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Descripci&oacute;n</font></label>
                  <input type="hidden" name="conse" id="conse" class="form-control numero" value="0" readonly="readonly">
                  <input type="text" name="nombre" id="nombre" class="form-control" value="" onblur="val_caracteres('nombre');" maxlength="100" autocomplete="off" tabindex="1">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo</font></label>
                  <select name="tipo" id="tipo" class="form-control select2" tabindex="2">
                    <option value="1">LEYES</option>
                    <option value="2">DECRETOS</option>
                    <option value="3">RESOLUCIONES</option>
                    <option value="4">MANUALES</option>
                    <option value="5">DIRECTIVAS</option>
                    <option value="6">PLANES</option>
                    <option value="7">CIRCULARES</option>
                    <option value="8">BOLETINES INSTRUCTIVOS</option>
                    <option value="9">OTRAS COMUNICACIONES</option>
                    <option value="0">DESACTIVAR</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Descarga</font></label>
                  <select name="descarga" id="descarga" class="form-control select2" tabindex="3">
                    <option value="1">SI</option>
                    <option value="0">NO</option>
                  </select>
                </div>
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                  <br><br>
                  <a href="#" onclick="cargar(); return false;">
                    <img src="imagenes/clip.png" name="archivo" id="archivo" border="0" title="Cargar PDF">
                  </a>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
									<br>
                  <input type="button" name="aceptar" id="aceptar" value="Crear">
                  <input type="button" name="actualiza" id="actualiza" value="Actualizar">
                </div>
              </div>
              <hr>
              <br>
              <div class="row">
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><div class="centrado"><font face="Verdana" size="2">Buscar por Descripci&oacute;n:</font></div></label>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <input type="text" name="filtro" id="filtro" class="form-control" maxlength="50" autocomplete="off">
                </div>
              </div>
              <div id="espacio1"></div>
              <div id="tabla3"></div>
              <div id="resultados4"></div>
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
            <div id="vinculo"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 220,
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
  $("#dialogo1").dialog({
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
        validacionData();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza").button();
  $("#actualiza").click(pregunta);
  $("#actualiza").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza").hide();
  trae_normas();
  $("#archivo").hide();
  $("#filtro").keyup(trae_normas1);
  $("#nombre").focus();
  $("#nombre").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
});
function trae_normas()
{
  var tipo = "0";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_normas.php",
    data:
    {
      tipo: tipo
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
      $("#tabla3").html('');
      $("#resultados4").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='69%' height='35'><font size='2'><b>Descripci&oacute;n</b></font></td><td width='20%' height='35'><font size='2'><b>Tipo</b></font></td><td width='35%' height='35'><font size='2'><b>Descarga</b></center></td><td width='6%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.conse+'\",\"'+value.nombre+'\",\"'+value.tipo+'\",\"'+value.descarga+'\"';
        salida2 += "<tr>";
        salida2 += "<td width='70%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='20%' height='35'>"+value.tipo1+"</td>";
        salida2 += "<td width='5%' height='35'>"+value.descarga1+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu("+paso+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>"
        salida2 += "</tr>";
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados4").append(salida2);
    }
  });
}
function trae_normas1()
{
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_normas.php",
    data:
    {
      tipo: tipo,
      nombre: $("#filtro").val()
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
      $("#tabla3").html('');
      $("#resultados4").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='69%' height='35'><font size='2'><b>Descripci&oacute;n</b></font></td><td width='20%' height='35'><font size='2'><b>Tipo</b></font></td><td width='35%' height='35'><font size='2'><b>Descarga</b></center></td><td width='6%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.conse+'\",\"'+value.nombre+'\",\"'+value.tipo+'\",\"'+value.descarga+'\"';
        salida2 += "<tr>";
        salida2 += "<td width='70%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='20%' height='35'>"+value.tipo1+"</td>";
        salida2 += "<td width='5%' height='35'>"+value.descarga1+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu("+paso+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>"
        salida2 += "</tr>";
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados4").append(salida2);
    }
  });
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function cargar()
{
  var conse = $("#conse").val();
  var tipo = $("#tipo").val();
  var url = "<a href='./subir28.php?conse="+conse+"' name='link1' id='link1' class='pantalla-modal'>Link</a>";
  $("#vinculo").hide();
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#link1").click();
}
function validacionData()
{
  var salida = true, detalle = '';
  var valor = $("#nombre").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Descripción de la Norma</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var valida1 = $("#conse").val();
    if (valida1 == "0")
    {
      nuevo(1);
    }
    else
    {
      nuevo(2);
    }
  }
}
function nuevo(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "norma_grab.php",
    data:
    {
      actu: valor,
      conse: $("#conse").val(),
      descripcion: $("#nombre").val(),
      tipo: $("#tipo").val(),
      descarga: $("#descarga").val()
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
      var consecu = registros.consecu;
      if (salida == "1")
      {
        trae_normas();
        $("#conse").val(consecu);
        $("#nombre").prop("disabled",true);
        $("#tipo").prop("disabled",true);
        $("#descarga").prop("disabled",true);
        $("#archivo").show();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function actu(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3;
  $("#conse").val(valor);
  $("#nombre").val(valor1);
  $("#tipo").val(valor2);
  $("#descarga").val(valor3);
  $("#aceptar").hide();
  $("#archivo").show();
  $("#actualiza").show();
}
function val_caracteres(valor)
{
  var valor;
  var detalle = $("#"+valor).val();
  detalle = detalle.replace(/[•]+/g, "*");
  detalle = detalle.replace(/[●]+/g, "*");
  detalle = detalle.replace(/[é́]+/g, "é");
  detalle = detalle.replace(/[]+/g, "*");
  detalle = detalle.replace(/[]+/g, "*");
  detalle = detalle.replace(/[]+/g, "*");
  detalle = detalle.replace(/[ ]+/g, " ");
  detalle = detalle.replace(/[ ]+/g, '');
  detalle = detalle.replace(/[‐]+/g, '-');
  detalle = detalle.replace(/[–]+/g, "-");
  detalle = detalle.replace(/[—]+/g, '-');
  detalle = detalle.replace(/[…]+/g, "..."); 
  detalle = detalle.replace(/[“”]+/g, '"');
  detalle = detalle.replace(/[‘]+/g, '´');
  detalle = detalle.replace(/[’]+/g, '´');
  detalle = detalle.replace(/[′]+/g, '´');
  detalle = detalle.replace(/[']+/g, '´');
  detalle = detalle.replace(/[™]+/g, '');
  $("#"+valor).val(detalle);
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
function alerta2(valor)
{
  alertify.log(valor);
}
</script>
</body>
</html>
<?php
}
?>