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
          <h3>Creaci&oacute;n Gastos</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7">
                  <label><font face="Verdana" size="2">Gasto</font></label>
                  <input type="hidden" name="conse" id="conse" class="form-control numero" value="0" readonly="readonly" tabindex="0">
                  <input type="text" name="gasto" id="gasto" class="form-control" value="" onblur="val_caracteres('gasto');" maxlength="150" autocomplete="off" tabindex="1">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo</font></label>
                  <select name="tipo" id="tipo" class="form-control select2" tabindex="2">
                    <option value="">NO APLICA</option>
                    <option value="B">BIENES</option>
                    <option value="C">COMBUSTIBLE</option>
                    <option value="G">GRASAS Y LUBRICANTES</option>
                    <option value="M">MANTENIMIENTO</option>
                    <option value="T">T&Eacute;CNICO MEC&Aacute;NICA</option>
                    <option value="L">LLANTAS</option>
                    <option value="R">REINTEGRO</option>
                    <option value="X">DESACTIVAR</option>
                  </select>
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
          </div>
          <h3>Creaci&oacute;n Soportes Documentos</h3>
          <div>
            <div id="load1">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu1" method="post">
              <div class="row">
                <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7">
                  <label><font face="Verdana" size="2">Soporte Documento</font></label>
                  <input type="hidden" name="conse1" id="conse1" class="form-control numero" value="0" readonly="readonly" tabindex="0">
                  <input type="text" name="soporte" id="soporte" class="form-control" value="" onblur="val_caracteres('soporte');" maxlength="150" autocomplete="off" tabindex="1">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Estado</font></label>
                  <select name="tipo1" id="tipo1" class="form-control select2" tabindex="2">
                    <option value="">ACTIVAR</option>
                    <option value="X">DESACTIVAR</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <input type="button" name="aceptar1" id="aceptar1" value="Crear">
                  <input type="button" name="actualiza1" id="actualiza1" value="Actualizar">
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
                  <input type="text" name="filtro1" id="filtro1" class="form-control" maxlength="50" autocomplete="off">
                </div>
              </div>
              <div id="espacio1"></div>
              <div id="tabla5"></div>
              <div id="resultados10"></div>
            </form>
            <div id="dialogo2"></div>
            <div id="dialogo3"></div>
          </div>
          <h3>Creaci&oacute;n Repuestos</h3>
          <div>
            <div id="load2">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu2" method="post">
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Repuesto</font></label>
                  <input type="hidden" name="conse2" id="conse2" class="form-control numero" value="0" readonly="readonly" tabindex="0">
                  <input type="text" name="repuesto" id="repuesto" class="form-control" value="" onblur="val_caracteres('repuesto');" maxlength="150" autocomplete="off" tabindex="1">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Medida</font></label>
                  <select name="medida" id="medida" class="form-control select2" tabindex="2">
                    <option value="1">UNIDAD</option>
                    <option value="2">JUEGO</option>
                    <option value="3">COPAS</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Tipo</font></label>
                  <select name="tipo3" id="tipo3" class="form-control select2" tabindex="3">
                    <option value="1">AUTOM&Oacute;VILES</option>
                    <option value="2">MOTOCICLETAS</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Estado</font></label>
                  <select name="tipo2" id="tipo2" class="form-control select2" tabindex="4">
                    <option value="">ACTIVAR</option>
                    <option value="X">DESACTIVAR</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <input type="button" name="aceptar2" id="aceptar2" value="Crear">
                  <input type="button" name="actualiza2" id="actualiza2" value="Actualizar">
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
                  <input type="text" name="filtro2" id="filtro2" class="form-control" maxlength="50" autocomplete="off">
                  <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                </div>
              </div>
              <div id="espacio1"></div>
              <div id="tabla8"></div>
              <div id="resultados11"></div>
            </form>
            <form name="formu_excel" id="formu_excel" action="trans_repu_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
            </form>
            <div id="dialogo4"></div>
            <div id="dialogo5"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#load1").hide();
  $("#load2").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 220,
    width: 410,
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
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 220,
    width: 410,
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
  $("#dialogo3").dialog({
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
        validacionData1();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo4").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 220,
    width: 410,
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
  $("#dialogo5").dialog({
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
        validacionData2();
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
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta1);
  $("#aceptar1").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza1").button();
  $("#actualiza1").click(pregunta1);
  $("#actualiza1").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza1").hide();
  $("#aceptar2").button();
  $("#aceptar2").click(pregunta2);
  $("#aceptar2").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza2").button();
  $("#actualiza2").click(pregunta2);
  $("#actualiza2").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza2").hide();
  trae_gastos();
  trae_documentos();
  trae_repuestos();
  $("#filtro").keyup(trae_gastos1);
  $("#filtro1").keyup(trae_documentos1);
  $("#filtro2").keyup(trae_repuestos1);
  $("#gasto").focus();
  var v_unidad = $("#v_unidad").val();
  if ((v_unidad == "1") || (v_unidad == "2"))
  {
    $("#aceptar").show();
    $("#aceptar1").show();
    $("#aceptar2").show();
    $("#soportes").accordion({active: 0});
  }
  else
  {
    $("#aceptar").hide();
    $("#aceptar1").hide();
    $("#aceptar2").show();
    $("#soportes").accordion({active: 2});
  }
});
function trae_gastos()
{
  var tipo = "0";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_gastos.php",
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
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='70%' height='35'><font size='2'><b>Gasto</b></font></td><td width='25%' height='35'><center><font size='2'><b>Tipo</b></font></center></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.tipo+'\"';
        salida2 += "<tr><td width='70%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='25%' height='35'>"+value.tipo1+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu("+paso+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados4").append(salida2);
    }
  });
}
function trae_gastos1()
{
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_gastos.php",
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
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='70%' height='35'><font size='2'><b>Material</b></font></td><td width='25%' height='35'><center><font size='2'><b>Tipo</b></font></center></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.tipo+'\"';
        salida2 += "<tr><td width='70%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='25%' height='35'>"+value.tipo1+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu("+paso+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados4").append(salida2);
    }
  });
}
function trae_documentos()
{
  var tipo = "0";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_documentos.php",
    data:
    {
      tipo: tipo
    },
    beforeSend: function ()
    {
      $("#load1").show();
    },
    error: function ()
    {
      $("#load1").hide();
    },
    success: function (data)
    {
      $("#load1").hide();
      $("#tabla5").html('');
      $("#resultados10").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='85%' height='35'><font size='2'><b>Soporte Documento</b></font></td><td width='10%' height='35'><center><font size='2'><b>Estado</b></font></center></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.estado+'\"';
        salida2 += "<tr><td width='85%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='10%' height='35'><center>"+value.estado+"</center></td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu1("+paso+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla5").append(salida1);
      $("#resultados10").append(salida2);
    }
  });
}
function trae_documentos1()
{
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_documentos.php",
    data:
    {
      tipo: tipo,
      nombre: $("#filtro1").val()
    },
    beforeSend: function ()
    {
      $("#load1").show();
    },
    error: function ()
    {
      $("#load1").hide();
    },
    success: function (data)
    {
      $("#load1").hide();
      $("#tabla5").html('');
      $("#resultados10").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='85%' height='35'><font size='2'><b>Soporte Documento</b></font></td><td width='10%' height='35'><center><font size='2'><b>Estado</b></font></center></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.estado+'\"';
        salida2 += "<tr><td width='85%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='10%' height='35'><center>"+value.estado+"</center></td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu1("+paso+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla5").append(salida1);
      $("#resultados10").append(salida2);
    }
  });
}
function trae_repuestos()
{
  var tipo = "0";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_repuestos.php",
    data:
    {
      tipo: tipo
    },
    beforeSend: function ()
    {
      $("#load1").show();
    },
    error: function ()
    {
      $("#load1").hide();
    },
    success: function (data)
    {
      $("#load2").hide();
      $("#tabla8").html('');
      $("#resultados11").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<div class='row'><div class='col col-lg-11 col-sm-11 col-md-11 col-xs-11'></div>";
      salida1 += "<div class='col col-lg-1 col-sm-1 col-md-1 col-xs-1'><center><a href='#' id='excel' onclick='excel(); return false;'><img src='dist/img/excel.png' title='Descargar Repuestos a Excel - SAP'></a></center></div></div>";
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='65%' height='35'><font size='2'><b>Repuesto</b></font></td><td width='20%' height='35'><font size='2'><b>Tipo</b></font></td><td width='10%' height='35'><center><font size='2'><b>Estado</b></font></center></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      var v_var1 = "";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.medida+'\",\"'+value.estado+'\",\"'+value.tipo+'\"';
        salida2 += "<tr><td width='65%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='20%' height='35'>"+value.tipo1+"</td>";
        salida2 += "<td width='10%' height='35'><center>"+value.estado+"</center></td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu2("+paso+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td></tr>";
        v_var1 += value.codigo+"|"+value.nombre+"|"+value.medida+"|"+value.estado+"|"+value.tipo+"|#";
      });
      salida2 += "</table>";
      $("#paso_excel").val(v_var1);
      $("#tabla8").append(salida1);
      $("#resultados11").append(salida2);
    }
  });
}
function trae_repuestos1()
{
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_repuestos.php",
    data:
    {
      tipo: tipo,
      nombre: $("#filtro2").val()
    },
    beforeSend: function ()
    {
      $("#load2").show();
    },
    error: function ()
    {
      $("#load2").hide();
    },
    success: function (data)
    {
      $("#load2").hide();
      $("#tabla8").html('');
      $("#resultados11").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='65%' height='35'><font size='2'><b>Repuesto</b></font></td><td width='20%' height='35'><font size='2'><b>Tipo</b></font></td><td width='10%' height='35'><center><font size='2'><b>Estado</b></font></center></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.medida+'\",\"'+value.estado+'\",\"'+value.tipo+'\"';
        salida2 += "<tr><td width='65%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='20%' height='35'>"+value.tipo1+"</td>";
        salida2 += "<td width='10%' height='35'><center>"+value.estado+"</center></td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu2("+paso+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla8").append(salida1);
      $("#resultados11").append(salida2);
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
function pregunta1()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo3").html(detalle);
  $("#dialogo3").dialog("open");
  $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta2()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo5").html(detalle);
  $("#dialogo5").dialog("open");
  $("#dialogo5").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function validacionData()
{
  var salida = true, detalle = '';
  var valor = $("#gasto").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Descripci&oacute;n del Gasto</h3></center>";
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
function validacionData1()
{
  var salida = true, detalle = '';
  var valor = $("#soporte").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Descripci&oacute;n del Soporte</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo2").html(detalle);
    $("#dialogo2").dialog("open");
    $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var valida1 = $("#conse1").val();
    if (valida1 == "0")
    {
      nuevo1(1);
    }
    else
    {
      nuevo1(2);
    }
  }
}
function validacionData2()
{
  var salida = true, detalle = '';
  var valor = $("#repuesto").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Descripci&oacute;n del Repuesto</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo4").html(detalle);
    $("#dialogo4").dialog("open");
    $("#dialogo4").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var valida1 = $("#conse2").val();
    if (valida1 == "0")
    {
      nuevo2(1);
    }
    else
    {
      nuevo2(2);
    }
  }
}
function nuevo(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "gasto_grab.php",
    data:
    {
      actu: valor,
      conse: $("#conse").val(),
      gasto: $("#gasto").val(),
      tipo: $("#tipo").val()
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
        $("#conse").val('0');
        $("#gasto").val('');
        $("#tipo").val('');
        trae_gastos();
        $("#gasto").focus();
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
function nuevo1(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "soporte_grab.php",
    data:
    {
      actu: valor,
      conse: $("#conse1").val(),
      soporte: $("#soporte").val(),
      tipo: $("#tipo1").val()
    },
    beforeSend: function ()
    {
      $("#load1").show();
    },
    error: function ()
    {
      $("#load1").hide();
    },
    success: function (data)
    {
      $("#load1").hide();
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        $("#conse1").val('0');
        $("#soporte").val('');
        $("#tipo1").val('');
        trae_documentos();
        $("#soporte").focus();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
        $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function nuevo2(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "repuesto_grab.php",
    data:
    {
      actu: valor,
      conse: $("#conse2").val(),
      repuesto: $("#repuesto").val(),
      medida: $("#medida").val(),
      tipo: $("#tipo2").val(),
      tipo1: $("#tipo3").val()
    },
    beforeSend: function ()
    {
      $("#load2").show();
    },
    error: function ()
    {
      $("#load2").hide();
    },
    success: function (data)
    {
      $("#load2").hide();
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        $("#conse2").val('0');
        $("#repuesto").val('');
        $("#medida").val('1');
        $("#tipo2").val('');
        trae_repuestos();
        $("#repuesto").focus();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo4").html(detalle);
        $("#dialogo4").dialog("open");
        $("#dialogo4").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function actu(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $("#conse").val(valor);
  $("#gasto").val(valor1);
  $("#tipo").val(valor2);
  $("#aceptar").hide();
  $("#actualiza").show();
}
function actu1(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $("#conse1").val(valor);
  $("#soporte").val(valor1);
  $("#tipo1").val(valor2);
  $("#aceptar1").hide();
  $("#actualiza1").show();
}
function actu2(valor, valor1, valor2, valor3, valor4)
{
  var valor, valor1, valor2, valor3, valor4;
  $("#conse2").val(valor);
  $("#repuesto").val(valor1);
  $("#medida").val(valor2);
  $("#tipo2").val(valor3);
  $("#tipo3").val(valor4);
  $("#aceptar2").hide();
  $("#actualiza2").show();
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
</script>
</body>
</html>
<?php
}
// 09/02/2024 - Exportacion a excel de repuestos
?>