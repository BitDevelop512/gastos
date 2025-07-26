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
          <h3>Creaci&oacute;n Gastos</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Gasto</font></label>
                  <input type="hidden" name="conse" id="conse" class="form-control numero" value="0" readonly="readonly">
                  <input type="text" name="gasto" id="gasto" class="form-control" value="" onblur="val_caracteres('gasto');" maxlength="150" autocomplete="off" tabindex="1">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo</font></label>
                  <select name="tipo" id="tipo" class="form-control select2" tabindex="2">
                    <option value="">NO APLICA</option>
                    <option value="B">BIENES</option>
                    <option value="C">COMBUSTIBLE</option>
                    <!--<option value="G">GRASAS Y LUBRICANTES</option>-->
                    <option value="M">MANTENIMIENTO</option>
                    <option value="T">TÉCNICO MECÁNICA</option>
                    <option value="L">LLANTAS</option>
                    <option value="S">SOAT</option>
                    <option value="P">POLIZA TODO RIESGO</option>
                    <option value="R">REINTEGRO</option>
                    <option value="X">DESACTIVAR</option>
                  </select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo de Necesidad</font></label>
                  <select name="necesidad" id="necesidad" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas tipos de necesidad" tabindex="3">
                    <option value="1">GASTOS EN ACTIVIDADES</option>
                    <option value="3">GASTOS DE PROTECCIÓN</option>
                    <option value="4">IDENTIDAD DE COBERTURA</option>
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
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu1" method="post">
              <div class="row">
                <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7">
                  <label><font face="Verdana" size="2">Soporte Documento</font></label>
                  <input type="hidden" name="conse1" id="conse1" class="form-control numero" value="0" readonly="readonly">
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
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu2" method="post">
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Repuesto</font></label>
                  <input type="hidden" name="conse2" id="conse2" class="form-control numero" value="0" readonly="readonly">
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
                  <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly">
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
          <h3>Creaci&oacute;n Gastos Presupuesto</h3>
          <div>
            <div id="load3">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu3" method="post">
              <div class="row">
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Concepto</font></label>
                  <input type="hidden" name="conse3" id="conse3" class="form-control numero" value="0" readonly="readonly">
                  <input type="text" name="gasto3" id="gasto3" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onblur="val_caracteres('gasto3');" maxlength="150" autocomplete="off" tabindex="1">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Gasto</font></label>
                  <select name="gasto4" id="gasto4" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione" tabindex="2"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Estado</font></label>
                  <select name="estado3" id="estado3" class="form-control select2" tabindex="3">
                    <option value="">ACTIVAR</option>
                    <option value="X">DESACTIVAR</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <input type="button" name="aceptar3" id="aceptar3" value="Crear">
                  <input type="button" name="actualiza3" id="actualiza3" value="Actualizar">
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
                  <input type="text" name="filtro3" id="filtro3" class="form-control" maxlength="50" autocomplete="off">
                </div>
              </div>
              <div id="espacio1"></div>
              <div id="tabla11"></div>
              <div id="resultados13"></div>
            </form>
            <div id="dialogo6"></div>
            <div id="dialogo7"></div>
          </div>
          <h3>Creaci&oacute;n Recursos Especiales</h3>
          <div>
            <div id="load4">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu4" method="post">
              <div class="row">
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Recurso</font></label>
                  <input type="hidden" name="conse4" id="conse4" class="form-control numero" value="0" readonly="readonly">
                  <input type="text" name="gasto5" id="gasto5" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onblur="val_caracteres('gasto5');" maxlength="150" autocomplete="off" tabindex="1">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Estado</font></label>
                  <select name="estado4" id="estado4" class="form-control select2" tabindex="2">
                    <option value="">ACTIVAR</option>
                    <option value="X">DESACTIVAR</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <input type="button" name="aceptar4" id="aceptar4" value="Crear">
                  <input type="button" name="actualiza4" id="actualiza4" value="Actualizar">
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
                  <input type="text" name="filtro4" id="filtro4" class="form-control" maxlength="50" autocomplete="off">
                </div>
              </div>
              <div id="espacio1"></div>
              <div id="tabla13"></div>
              <div id="resultados14"></div>
            </form>
            <div id="dialogo8"></div>
            <div id="dialogo9"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#load1").hide();
  $("#load2").hide();
  $("#load3").hide();
  $("#load4").hide();
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
  $("#dialogo6").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 170,
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
  $("#dialogo7").dialog({
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
        validacionData3();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo8").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 170,
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
  $("#dialogo9").dialog({
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
        validacionData4();
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
  $("#aceptar3").button();
  $("#aceptar3").click(pregunta3);
  $("#aceptar3").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza3").button();
  $("#actualiza3").click(pregunta3);
  $("#actualiza3").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza3").hide();
  $("#aceptar4").button();
  $("#aceptar4").click(pregunta4);
  $("#aceptar4").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza4").button();
  $("#actualiza4").click(pregunta4);
  $("#actualiza4").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza4").hide();
  trae_gastos();
	trae_gastos2();
  trae_documentos();
  trae_repuestos();
  trae_presupuestos();
  trae_recursos();
  $("#filtro").keyup(trae_gastos1);
  $("#filtro1").keyup(trae_documentos1);
  $("#filtro2").keyup(trae_repuestos1);
  $("#filtro3").keyup(trae_presupuestos1);
  $("#filtro4").keyup(trae_recursos1);
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
  $("#necesidad").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#gasto4").select2.defaults.set("width", "100%");
  $("#gasto4").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#gasto, #soporte, #repuesto, #gasto3").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
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
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='39%' height='35'><font size='2'><b>Gasto</b></font></td><td width='20%' height='35'><font size='2'><b>Tipo</b></font></td><td width='35%' height='35'><font size='2'><b>Tipo de Necesidad</b></center></td><td width='6%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.tipo+'\",\"'+value.gasto+'\"';
        salida2 += "<tr>";
        salida2 += "<td width='40%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='20%' height='35'>"+value.tipo1+"</td>";
        salida2 += "<td width='35%' height='35'>"+value.gasto1+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu("+paso+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>"
        salida2 += "</tr>";
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
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='39%' height='35'><font size='2'><b>Gasto</b></font></td><td width='20%' height='35'><font size='2'><b>Tipo</b></font></td><td width='35%' height='35'><font size='2'><b>Tipo de Necesidad</b></center></td><td width='6%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.tipo+'\",\"'+value.gasto+'\"';
        salida2 += "<tr>";
        salida2 += "<td width='40%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='20%' height='35'>"+value.tipo1+"</td>";
        salida2 += "<td width='35%' height='35'>"+value.gasto1+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu("+paso+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>"
        salida2 += "</tr>";
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados4").append(salida2);
    }
  });
}
function trae_gastos2()
{
  var tipo = "0";
  $("#gasto4").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_pago.php",
    data:
    {
      tipo: tipo
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "<option value='0'>- NO APLICA -</option>";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#gasto4").append(salida);
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
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu1("+paso+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td></tr>";
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
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu1("+paso+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td></tr>";
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
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu2("+paso+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td></tr>";
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
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu2("+paso+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla8").append(salida1);
      $("#resultados11").append(salida2);
    }
  });
}
function trae_presupuestos()
{
  var tipo = "0";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_presupuestos.php",
    data:
    {
      tipo: tipo
    },
    beforeSend: function ()
    {
      $("#load3").show();
    },
    error: function ()
    {
      $("#load3").hide();
    },
    success: function (data)
    {
      $("#load3").hide();
      $("#tabla11").html('');
      $("#resultados13").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='75%' height='35'><font size='2'><b>Concepto</b></font></td><td width='20%' height='35'><center><font size='2'><b>Estado</b></font></center></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.gasto+'\",\"'+value.estado+'\"';
        salida2 += "<tr><td width='75%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='20%' height='35'>"+value.estado1+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu3("+paso+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla11").append(salida1);
      $("#resultados13").append(salida2);
    }
  });
}
function trae_presupuestos1()
{
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_presupuestos.php",
    data:
    {
      tipo: tipo,
      nombre: $("#filtro3").val()
    },
    beforeSend: function ()
    {
      $("#load3").show();
    },
    error: function ()
    {
      $("#load").hide();
    },
    success: function (data)
    {
      $("#load3").hide();
      $("#tabla11").html('');
      $("#resultados13").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='75%' height='35'><font size='2'><b>Concepto</b></font></td><td width='20%' height='35'><center><font size='2'><b>Estado</b></font></center></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.estado+'\"';
        salida2 += "<tr><td width='75%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='20%' height='35'>"+value.estado1+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu3("+paso+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla11").append(salida1);
      $("#resultados13").append(salida2);
    }
  });
}
function trae_recursos()
{
  var tipo = "0";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_recursos.php",
    data:
    {
      tipo: tipo
    },
    beforeSend: function ()
    {
      $("#load4").show();
    },
    error: function ()
    {
      $("#load4").hide();
    },
    success: function (data)
    {
      $("#load4").hide();
      $("#tabla13").html('');
      $("#resultados14").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='39%' height='35'><font size='2'><b>Recurso</b></font></td><td width='55%' height='35'><font size='2'><b>Estado</b></font></td><td width='6%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.estado+'\"';
        salida2 += "<tr>";
        salida2 += "<td width='40%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='55%' height='35'>"+value.estado+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu4("+paso+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>"
        salida2 += "</tr>";
      });
      salida2 += "</table>";
      $("#tabla13").append(salida1);
      $("#resultados14").append(salida2);
    }
  });
}
function trae_recursos1()
{
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_recursos.php",
    data:
    {
      tipo: tipo,
      nombre: $("#filtro4").val()
    },
    beforeSend: function ()
    {
      $("#load4").show();
    },
    error: function ()
    {
      $("#load4").hide();
    },
    success: function (data)
    {
      $("#load4").hide();
      $("#tabla13").html('');
      $("#resultados14").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='39%' height='35'><font size='2'><b>Recurso</b></font></td><td width='55%' height='35'><font size='2'><b>Estado</b></font></td><td width='6%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.estado+'\"';
        salida2 += "<tr>";
        salida2 += "<td width='40%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='55%' height='35'>"+value.estado+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu4("+paso+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>"
        salida2 += "</tr>";
      });
      salida2 += "</table>";
      $("#tabla13").append(salida1);
      $("#resultados14").append(salida2);
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
function pregunta3()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo7").html(detalle);
  $("#dialogo7").dialog("open");
  $("#dialogo7").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta4()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo9").html(detalle);
  $("#dialogo9").dialog("open");
  $("#dialogo9").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function validacionData()
{
  var salida = true, detalle = '';

  var necesidad = $("#necesidad").select2('val');
  if (necesidad == null)
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar un Tipo de Necesidad</h3></center>";
  }
  var valor = $("#gasto").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Descripción del Gasto</h3></center>";
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
    detalle += "<center><h3>Debe ingresar la Descripción del Soporte</h3></center>";
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
    detalle += "<center><h3>Debe ingresar la Descripción del Repuesto</h3></center>";
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
function validacionData3()
{
  var salida = true, detalle = '';
  var valor = $("#gasto3").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Descripción del Gasto</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo6").html(detalle);
    $("#dialogo6").dialog("open");
    $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var valida1 = $("#conse3").val();
    if (valida1 == "0")
    {
      nuevo3(1);
    }
    else
    {
      nuevo3(2);
    }
  }
}
function validacionData4()
{
  var salida = true, detalle = '';
  var valor = $("#gasto5").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Descripción del Recurso</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo8").html(detalle);
    $("#dialogo8").dialog("open");
    $("#dialogo8").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var valida1 = $("#conse4").val();
    if (valida1 == "0")
    {
      nuevo4(1);
    }
    else
    {
      nuevo4(2);
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
      tipo: $("#tipo").val(),
      necesidad: $("#necesidad").val()
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
        $("#necesidad").val("[]").trigger("change");
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
function nuevo3(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "gasto1_grab.php",
    data:
    {
      actu: valor,
      conse: $("#conse3").val(),
      gasto: $("#gasto3").val(),
      gasto1: $("#gasto4").val(),
      estado: $("#estado3").val()
    },
    beforeSend: function ()
    {
      $("#load3").show();
    },
    error: function ()
    {
      $("#load3").hide();
    },
    success: function (data)
    {
      $("#load3").hide();
      var registros = JSON.parse(data);
      var confirma = registros.confirma;
      if (confirma == "1")
      {
        $("#conse3").val('0');
        $("#gasto3").val('');
        $("#gasto4").val("[]").trigger("change");
        $("#estado3").val('');
        trae_presupuestos();
        $("#gasto3").focus();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo6").html(detalle);
        $("#dialogo6").dialog("open");
        $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function nuevo4(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "recurso_grab.php",
    data:
    {
      actu: valor,
      conse: $("#conse4").val(),
      recurso: $("#gasto5").val(),
      estado: $("#estado4").val()
    },
    beforeSend: function ()
    {
      $("#load4").show();
    },
    error: function ()
    {
      $("#load4").hide();
    },
    success: function (data)
    {
      $("#load4").hide();
      var registros = JSON.parse(data);
      var confirma = registros.confirma;
      if (confirma == "1")
      {
        $("#conse4").val('0');
        $("#gasto5").val('');
        $("#estado4").val('');
        trae_recursos();
        $("#gasto5").focus();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo8").html(detalle);
        $("#dialogo8").dialog("open");
        $("#dialogo8").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function actu(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3, valor4;
  $("#conse").val(valor);
  $("#gasto").val(valor1);
  $("#tipo").val(valor2);
  valor3 = valor3.trim();
  if (valor3 == "")
  {
    alerta("Sin Asignación de Tipo de Necesidad");
  }
  var var_ocu = valor3.split('|');
  var var_ocu1 = var_ocu.length;
  var paso = "";
  for (var i=0; i<var_ocu1; i++)
  {
    valor4 = var_ocu[i].trim();
    paso += "'"+valor4+"',";
  }
  paso = paso.substr(0, paso.length-1);
  paso = "["+paso+"]";
  var final = '$("#necesidad").val('+paso+').trigger("change");';
  eval(final);
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
function actu3(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3, valor4;
  $("#conse3").val(valor);
  $("#gasto3").val(valor1);
  valor2 = valor2.trim();
  if (valor2 == "")
  {
    alerta("Sin Asignación de Gasto Relacionado");
  }
  var var_ocu = valor2.split('|');
  var var_ocu1 = var_ocu.length;
  var paso = "";
  for (var i=0; i<var_ocu1; i++)
  {
    valor4 = var_ocu[i].trim();
    paso += "'"+valor4+"',";
  }
  paso = paso.substr(0, paso.length-1);
  paso = "["+paso+"]";
  var final = '$("#gasto4").val('+paso+').trigger("change");';
  eval(final);
  $("#estado3").val(valor3);
  $("#aceptar3").hide();
  $("#actualiza3").show();
}
function actu4(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $("#conse4").val(valor);
  $("#gasto5").val(valor1);
  $("#estado4").val(valor2);
  $("#aceptar4").hide();
  $("#actualiza4").show();
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
// 09/02/2024 - Ajuste exportacion a excel de repuestos
// 29/11/2024 - Ajuste inclusion gastos presupuesto
?>