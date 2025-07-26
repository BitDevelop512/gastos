<!doctype html>
<?php
session_start();
error_reporting(0);

if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('conf.php');
  include('funciones.php');
  include('permisos.php');
  $fecha = date('Y/m/d');
  $verifica = time();
  $alea = strtoupper(md5($verifica));
  $alea = substr($alea,0,5);
  // Usuarios a asignar pqr
  $query = "SELECT usuario FROM cx_usu_web WHERE super!='0' AND usuario NOT LIKE 'CX-%'";
  $cur = odbc_exec($conexion, $query);
  $usuarios = "";
  while($j<$row=odbc_fetch_array($cur))
  {
    $v_usuario = trim(odbc_result($cur,1));
    $usuarios .= "<option value='".$v_usuario."'>".$v_usuario."</option>";
  }
  // Usuarios asignados
  $query_a = "SELECT DISTINCT asigna FROM cx_pqr_reg WHERE asigna!='' ORDER BY asigna";
  $sql_a = odbc_exec($conexion, $query_a);
  $usuarios1 = "<option value='-''>- SELECCIONAR -</option>";
  $i=1;
  while($i<$row=odbc_fetch_array($sql_a))
  {
    $usuario = trim(odbc_result($sql_a,1));
    $usuarios1 .= "<option value=$usuario>".$usuario."</option>";
    $i++;
  }
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
<body>
<?php
include('titulo.php');
?>
<div>
  <div id="soportes">
    <h3>Soporte T&eacute;cnico</h3>
    <div>
      <form name="formu" method="post">
        <div class="row">
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Tipo</font></label>
            <select name="tipo" id="tipo" class="form-control select2" tabindex="1">
              <option value="1">SOLICITUD</option>
              <option value="2">SOPORTE</option>
              <option value="3">OTRO</option>
            </select>
          </div>
          <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
            <label><font face="Verdana" size="2">M&oacute;dulo</font></label>
            <select name="modulo" id="modulo" class="form-control select2" tabindex="2">
              <option value="A">PLANEACI&Oacute;N</option>
              <option value="B">EJECUCI&Oacute;N</option>
              <option value="C">SOPORTES DE EJECUCI&Oacute;N</option>
              <option value="D">LIBROS AUXILIARES</option>
              <option value="E">RECOMPENSAS</option>
              <option value="F">PRESUPUESTO</option>
              <option value="G">ADMINISTRADOR</option>
              <option value="H">BIENES</option>
              <option value="I">ESTAD&Iacute;STICAS</option>
              <option value="J">TRANSPORTES</option>
            </select>
          </div>
          <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
            <label><font face="Verdana" size="2">Sub M&oacute;dulo</font></label>
            <select name="modulo1" id="modulo1" class="form-control select2" tabindex="3"></select>
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">C&oacute;digo</font></label>
            <input type="text" name="codigo" id="codigo" class="form-control fecha" value="<?php echo $alea; ?>" readonly="readonly" tabindex="4">
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Confirmar C&oacute;digo</font></label>
            <input type="text" name="codigo1" id="codigo1" class="form-control fecha" onchange="javascript:this.value=this.value.toUpperCase();" value="" maxlength="5" tabindex="5" autocomplete="off">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-10 col-sm-10 col-md-10 col-xs-10">
            <label><font face="Verdana" size="2">Descripci&oacute;n</font></label>
            <textarea name="concepto" id="concepto" class="form-control" rows="5" onblur="val_caracteres('concepto');" tabindex="6"></textarea>
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Nombre Contacto</font></label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <input type="text" name="nombre" id="nombre" class="form-control" value="" onkeypress="return check2(event);" maxlength="60" tabindex="7" autocomplete="off">
            </div>
            <br>
            <label><font face="Verdana" size="2">Tel&eacute;fono Contacto</font></label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-phone"></i>
              </div>
              <input type="text" name="telefono" id="telefono" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask tabindex="8">
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
            <center>
              <input type="button" name="aceptar" id="aceptar" value="Continuar">
              <input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly">
              <input type="hidden" name="usuario" id="usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly">
              <input type="hidden" name="n_unidad" id="n_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="v_super" id="v_super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="usuarios" id="usuarios" class="form-control" value="<?php echo $usuarios; ?>" readonly="readonly">
              <input type="hidden" name="usuario1" id="usuario1" class="form-control" value="" readonly="readonly">
              <input type="hidden" name="paso" id="paso" class="form-control" value="" readonly="readonly">
              <div id="link"></div>
            </center>
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <center>
              <a href="#" name="lnk1" id="lnk1" onclick="subir(1);"><img src="imagenes/clip.png" border="0" title="Anexar Evidencia"></a>
            </center>
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Enviar</font></label>
            <input type="text" name="asignar" id="asignar" class="form-control" readonly="readonly">
            <input type="hidden" name="asignar1" id="asignar1" class="form-control" readonly="readonly">
          </div>
        </div>
      </form>
    </div>
    <h3>Relaci&oacute;n Soportes</h3>
    <div>
      <div id="load1">
        <center>
          <img src="imagenes/cargando1.gif" alt="Cargando...">
        </center>
      </div>
      <div class="row">
				<div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
					<label><font face="Verdana" size="2">A&ntilde;o</font></label>
					<select name="ano1" id="ano1" class="form-control select2" onchange="trae_registros();"></select>
				</div>
        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
          <label><font face="Verdana" size="2">Estado</font></label>
          <select name="estado2" id="estado2" class="form-control select2" onchange="trae_registros();">
            <option value="-">- SELECCIONAR -</option>
            <option value="">ENVIADA</option>
            <option value="A">EN TRAMITE</option>
            <option value="C">PENDIENTE CONFIRMACI&Oacute;N</option>
            <option value="B">CERRADA</option>
            <option value="Y">RECHAZADA</option>
            <option value="D">ASIGNADA A USUARIO</option>
          </select>
        </div>
        <div id="lbl1">
          <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
            <label><font face="Verdana" size="2">Unidad</font></label>
            <select name="batallon" id="batallon" class="form-control select2" onchange="trae_registros();"></select>
          </div>
        </div>
        <div id="lbl2">
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Asignado</font></label>
            <select name="asignados" id="asignados" class="form-control select2" onchange="trae_registros();">
              <?php echo $usuarios1; ?>
            </select>
          </div>
        </div>
      </div>
      <br>
      <div id="tabla3"></div>
      <div id="resultados5"></div>
    </div>
    <h3>Detalles</h3>
    <div>
      <div id="load">
        <center>
          <img src="imagenes/cargando1.gif" alt="Cargando...">
        </center>
      </div>
      <form name="formu1" method="post">
        <div class="row">
          <div class="col col-lg-10 col-sm-10 col-md-10 col-xs-10">
            <label><font face="Verdana" size="2">Descripci&oacute;n</font></label>
            <textarea name="concepto1" id="concepto1" class="form-control" rows="5" readonly="readonly"></textarea>
            <input type="hidden" name="conse1" id="conse1" class="form-control" readonly="readonly">
            <input type="hidden" name="ano1" id="ano1" class="form-control" readonly="readonly">
            <input type="hidden" name="unidad1" id="unidad1" class="form-control" readonly="readonly">
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Nombre Contacto</font></label>
            <input type="text" name="nombre1" id="nombre1" class="form-control" value="" readonly="readonly">
            <br>
            <label><font face="Verdana" size="2">Tel&eacute;fono Contacto</font></label>
            <input type="text" name="telefono1" id="telefono1" class="form-control" readonly="readonly">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
            <label><font face="Verdana" size="2">Resultado de la Revisi&oacute;n</font></label>
            <input type="hidden" name="estado" id="estado" class="form-control" readonly="readonly">
            <select name="estado1" id="estado1" class="form-control select2" onchange="valida();">
              <option value="-">- SELECCIONAR -</option>
              <option value="A">EN TRAMITE</option>
              <option value="C">PENDIENTE CONFIRMACI&Oacute;N</option>
              <option value="B">CERRADA</option>
              <option value="Y">RECHAZADA</option>
              <option value="D">ASIGNAR A USUARIO</option>
            </select>
            <br>
            <label><font face="Verdana" size="2">Usuario a Enviar</font></label>
            <input type="text" name="envia" id="envia" class="form-control" autocomplete="off">
            <select name="envia1" id="envia1" class="form-control select2" onchange="asigna();">
              <?php echo $usuarios; ?>
            </select>
          </div>
          <div class="col col-lg-9 col-sm-9 col-md-9 col-xs-9">
            <label><font face="Verdana" size="2">Respuesta</font></label>
            <textarea name="respuesta" id="respuesta" class="form-control" rows="5" onblur="val_caracteres('respuesta');"></textarea>
            <textarea name="respuesta1" id="respuesta1" class="form-control" rows="5" readonly="readonly"></textarea>
            <input type="hidden" name="carpeta" id="carpeta" class="form-control fecha" value="" readonly="readonly">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
          <div class="col col-lg-10 col-sm-10 col-md-10 col-xs-10">
            <center>
              <input type="button" name="aceptar1" id="aceptar1" value="Continuar">
            </center>
          </div>
          <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
            <center>
              <a href="#" name="lnk2" id="lnk2" onclick="subir(2);"><img src="imagenes/clip.png" border="0" title="Ver Evidencia"></a>
            </center>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <label><font face="Verdana" size="2">Historial de Respuestas</font></label>
            <textarea name="respuesta2" id="respuesta2" class="form-control" rows="8" readonly="readonly"></textarea>
          </div>
        </div>
      </form>
    </div>
    <h3>Consultas</h3>
    <div>
      <div id="load2">
        <center>
          <img src="imagenes/cargando1.gif" alt="Cargando...">
        </center>
      </div>
      <div class="row">
				<div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
					<label><font face="Verdana" size="2">Tipo de Consulta</font></label>
					<select name="tipo_c" id="tipo_c" class="form-control select2">
						<option value="1">REPORTE EXCEL - SAP</option>
						<option value="2">ESTAD&Iacute;STICA</option>
					</select>
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
        <form name="formu_excel" id="formu_excel" action="pqr_x.php" target="_blank" method="post">
          <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
        </form>
      </div>
      <br>
      <div id="res_grafica"></div>
      <div id="dialogo"></div>
			<div id="dialogo1"></div>
			<div id="dialogo2"></div>
			<div id="dialogo3"></div>
      <div id="dialogo4"></div>
    </div>
  </div>
</div>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="js4/highcharts.js"></script>
<script src="js4/modules/data.js"></script>
<script src="js4/modules/drilldown.js?1.0.0"></script>
<script src="js4/modules/highcharts-3d.js"></script>
<script src="js4/modules/exporting.js?1.0.0"></script>
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
  $("#load").hide();
  $("#load1").hide();
  $("#load2").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 265,
    width: 650,
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
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo2").dialog({
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
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo3").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 170,
    width: 700,
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
  $("#dialogo4").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 400,
    width: 600,
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
  $("#modulo").change(trae_modulos);
  $("#aceptar").button();
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").click(pregunta);
  $("#aceptar1").button();
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").click(pregunta1);
  $("#aceptar1").hide();
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#envia1").hide();
  $("#respuesta1").hide();
  $("#codigo").prop("disabled",true);
  $("#asignar").prop("disabled",true);
  $("#concepto1").prop("disabled",true);
  $("#nombre1").prop("disabled",true);
  $("#telefono1").prop("disabled",true);
  $("#respuesta").prop("disabled",true);
  $("#carpeta").prop("disabled",true);
  $("#estado1").prop("disabled",true);
  $("#envia").prop("disabled",true);
  $("[data-mask]").inputmask();
  trae_unidades();
  trae_modulos();
  trae_enviar();
  $("#codigo1").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#codigo1").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#nombre").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#nombre").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#telefono").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#telefono").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#concepto").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  var v_super = $("#v_super").val();
  if ((v_super == "1") || (v_super == "2"))
  {
    $("#lbl1").show();
    $("#lbl2").show();
  }
  else
  {
    $("#lbl1").hide();
    $("#lbl2").hide();
  }
  $("#lnk2").mousedown(function(event) {
    switch (event.which)
    {
      case 3:
        trae_codigo();
        break;
      default:
        break;
    }
  });
  $("#batallon").select2.defaults.set("width", "100%");
  $("#batallon").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
});
function trae_unidades()
{
  $("#batallon").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unid.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      salida += "<option value='0'>- SELECCIONAR -</option>";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#batallon").append(salida);
      trae_ano();
    }
  });
}
function trae_ano()
{
  $("#ano1").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_ano.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "<option value='-'>- SELECCIONAR -</option>";
      var j = 0;
      for (var i in registros) 
      {
        j = j+1;
        var ano = registros[i].ano;
        salida += "<option value='"+ano+"'>"+ano+"</option>";
      }
      $("#ano1").append(salida);
    }
  });
}
function trae_modulos()
{
  var modulo = $("#modulo").val();
  $("#modulo1").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_modulo.php",
    data:
    {
      modulo: modulo
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
      var salida = "";
      for (var i in registros) 
      {
        var conse = registros[i].conse;
        var nombre = registros[i].nombre;
        salida += "<option value='"+conse+"'>"+nombre+"</option>";
      }
      $("#modulo1").append(salida); 
    }
  });
}
function trae_enviar()
{
  var usuario = $("#usuario").val();
  var unidad = $("#n_unidad").val();
  var tipo = "3";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_enviar.php",
    data:
    {
      usuario: usuario,
      unidad: unidad,
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
      var registros = JSON.parse(data);
      var envia = registros.envia;
      $("#asignar").val(envia);
      var envia1 = registros.envia1;
      $("#asignar1").val(envia1);
    }
  });
}
function trae_registros()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "pqr_consu.php",
    data:
    {
      ano: $("#ano1").val(),
      estado: $("#estado2").val(),
      batallon: $("#batallon").val(),
      asignados: $("#asignados").val()
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
      $("#tabla3").html('');
      $("#resultados5").html('');
      var registros = JSON.parse(data);
      var valida, valida1, valida2;
      var salida1 = "";
      var salida2 = "";
      listareg = [];
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
      salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='7%'><b>No.</b></td><td height='35' width='12%'><b>Fecha</b></td><td height='35' width='8%'><b>Usuario</b></td><td height='35' width='7%'><b>Unidad</b></td><td height='35' width='7%'><b>Tipo</b></td><td height='35' width='16%'><b>M&oacute;dulo - Sub M&oacute;dulo</b></td><td height='35' width='13%'><b>Estado</b></td><td height='35' width='14%'><b>D&iacute;as</b></td><td height='35' width='10%'><b>Asignado</b></td><td height='35' width='3%'>&nbsp;</td><td height='35' width='3%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var v1 = value.conse;
        var v2 = value.contador;
        valida2 = value.conse+','+value.ano+','+value.unidad;
        salida2 += "<tr><td height='35' width='7%' id='l1_"+v1+"'>"+value.conse+" - "+value.ano+"</td>";
        salida2 += "<td height='35' width='12%' id='l2_"+v1+"'>"+value.fecha+"</td>";
        salida2 += "<td height='35' width='8%' id='l3_"+v1+"'>"+value.usuario+"</td>";
        salida2 += "<td height='35' width='7%' id='l4_"+v1+"'>"+value.n_unidad+"</td>";
        salida2 += "<td height='35' width='7%' id='l5_"+v1+"'>"+value.n_tipo+"</td>";
        salida2 += "<td height='35' width='16%' id='l6_"+v1+"'>"+value.n_modulo+"<br>"+value.n_submodulo+"</td>";
        salida2 += "<td height='35' width='13%' id='l7_"+v1+"'>"+value.n_estado+"</td>";
        salida2 += "<td height='35' width='14%' id='l8_"+v1+"'>"+value.fechaf+" - "+value.solucion+"</td>";
        salida2 += "<td height='35' width='10%' id='l9_"+v1+"'>"+value.asigna+"</td>";
        salida2 += "<td height='35' width='3%' id='l10_"+v1+"'><center><a href='#' onclick='javascript:highlightText2("+v1+",11); veri("+valida2+")'><img src='imagenes/ver.png' border='0' title='Ver Información'></a></center></td>";
        if (v2 == "0")
        {
          salida2 += "<td height='35' width='3%' id='l11_"+v1+"'>&nbsp;</td>";
        }
        else
        {
          salida2 += "<td height='35' width='3%' id='l11_"+v1+"'><center><a href='#' onclick='javascript:highlightText2("+v1+",11); vali("+valida2+")'><img src='imagenes/usuarios.png' border='0' title='Ver Asignación de Usuarios'></a></center></td>";
        }
        salida2 += "</tr>";
        listareg.push(v1);
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados5").append(salida2);

    }
  });
}
function trae_codigo()
{
  var alea = $("#carpeta").val();
  alerta(alea);
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
  $("#dialogo2").html(detalle);
  $("#dialogo2").dialog("open");
  $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function validacionData()
{
  var salida = true, detalle = "";
  var valor = $("#codigo1").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el C&oacute;digo de Confirmaci&oacute;n</h3></center>";
    $("#codigo1").addClass("ui-state-error");
  }
  else
  {
    var valor1 = $("#codigo").val();
    var valor2 = $("#codigo1").val();
    if (valor1 != valor2)
    {
      salida = false;
      detalle += "<center><h3>El C&oacute;digo de Confirmaci&oacute;n No Concuerda</h3></center>";
      $("#codigo1").addClass("ui-state-error");
    }
    else
    {
      $("#codigo1").removeClass("ui-state-error");
    }
  }
  var valor1 = $("#concepto").val();
  valor1 = valor1.trim().length;
  if (valor1 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Descripci&oacute;n</h3></center>";
    $("#concepto").addClass("ui-state-error");
  }
  else
  {
    $("#concepto").removeClass("ui-state-error");
  }
  var valor2 = $("#nombre").val();
  valor2 = valor2.trim().length;
  if (valor2 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Nombre de Contacto</h3></center>";
    $("#nombre").addClass("ui-state-error");
  }
  else
  {
    $("#nombre").removeClass("ui-state-error");
  }
  var valor3 = $("#telefono").val();
  valor3 = valor3.trim().length;
  if (valor3 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Tel&eacute;fono de Contacto</h3></center>";
    $("#telefono").addClass("ui-state-error");
  }
  else
  {
    var str = "_";
    var txt = $("#telefono").val();
    txt = txt.toLowerCase();
    if (txt.indexOf(str) > -1)
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar un Tel&eacute;fono V&aacute;lido</h3></center>";
      $("#telefono").addClass("ui-state-error");
    }
    else
    {
      $("#telefono").removeClass("ui-state-error");
    }
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    nuevo();
  }
}
function validacionData1()
{
  var salida = true, detalle = "";
  var valor = $("#respuesta").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Respuesta</h3></center>";
    $("#respuesta").addClass("ui-state-error");
  }
  else
  {
    $("#respuesta").removeClass("ui-state-error");
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    actualiza();
  }
}
function valida()
{
  $("#envia").show();
  $("#envia1").hide();
  var usuario1 = $("#usuario1").val();
  $("#envia").val(usuario1);
  var valida = $("#estado1").val();
  if (valida == "-")
  {
    $("#respuesta").prop("disabled",true);
    $("#aceptar1").hide();
  }
  else
  {
    if (valida == "D")
    {
      $("#envia").hide();
      $("#envia1").show();
      $("#envia1").prop("disabled",false);
      asigna();
    }
    $("#respuesta").prop("disabled",false);
    $("#aceptar1").show();
  }
}
function asigna()
{

  var v_super = $("#v_super").val();
  var usuario1 = $("#asignar").val();
  if (v_super == "0")
  {
    var opcion = "<option value='"+usuario1+"'>"+usuario1+"</option>";
    $("#envia1").html('');
    $("#envia1").append(opcion);
  }
  var usuario = $("#envia1").val();
  $("#envia").val(usuario);
}
function subir(valor)
{
  var valor;
  if (valor == "1")
  {
    var alea = $("#alea").val();
		var url = "<a href='./subir9.php?alea="+alea+"' name='link1' id='link1' class='pantalla-modal'>Link</a>";
		$("#link").hide();
		$("#link").html('');
		$("#link").append(url);
		$(".pantalla-modal").magnificPopup({
			type: 'iframe',
			preloader: false,
			modal: false
		});
		$("#link1").click();
  }
  else
  {
  	var alea = $("#carpeta").val();
	  $.ajax({
	    type: "POST",
	    datatype: "json",
	    url: "pqr_consu3.php",
	    data:
	    {
	      alea: alea
	    },
	    success: function (data)
	    {
	      var registros = JSON.parse(data);
	      var archivo = registros.archivo;
	      if (archivo === null)
	      {
	        var detalle = "<center><h3>Evidencia No Encontrada o No Cargada</h3></center>";
	        $("#dialogo3").html(detalle);
	        $("#dialogo3").dialog("open");
	        $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
	      }
	      else
	      {
    			var ruta = "\\upload\\pqr\\"+alea+"\\";
    			var url = "<a href='./ver_pqr.php?valor="+ruta+"&valor1="+archivo+"&valor2="+alea+"' name='link2' id='link2' class='pantalla-modal'></a>";
	        $("#link").html('');
	        $("#link").append(url);
	        $(".pantalla-modal").magnificPopup({
	          type: 'iframe',
	          preloader: false,
	          modal: false
	        });
	        $("#link2").click();
	      }
	    }
	  });
  }
}
function nuevo()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "pqr_grab.php",
    data:
    {
    	usuario: $("#usuario").val(),
    	unidad: $("#n_unidad").val(),
      tipo: $("#tipo").val(),
      modulo: $("#modulo").val(),
      modulo1: $("#modulo1").val(),
      alea: $("#alea").val(),
      concepto: $("#concepto").val(),
      nombre: $("#nombre").val(),
      telefono: $("#telefono").val(),
      asignar: $("#asignar").val(),
      asignar1: $("#asignar1").val()
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
      var valida = registros.salida;
      if (valida == "1")
      {
        $("#aceptar").hide();
        trae_registros();
        $("#lnk1").hide();
        $("#tipo").prop("disabled",true);
        $("#modulo").prop("disabled",true);
        $("#modulo1").prop("disabled",true);
        $("#codigo1").prop("disabled",true);
        $("#concepto").prop("disabled",true);
        $("#nombre").prop("disabled",true);
        $("#telefono").prop("disabled",true);
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar").show();
      }
    }
  });
}
function actualiza()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "pqr_actu.php",
    data:
    {
      conse: $("#conse1").val(),
      ano: $("#ano1").val(),
      estado: $("#estado1").val(),
      carpeta: $("#carpeta").val(),
      usuario: $("#envia").val(),
      unidad: $("#unidad1").val(),
      respuesta: $("#respuesta").val(),
      respuesta1: $("#respuesta1").val(),
      usuario1: $("#usuario").val(),
      unidad1: $("#n_unidad").val()
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
      var valida = registros.salida;
      if (valida == "1")
      {
        $("#envia").show();
        $("#envia1").hide();
        $("#envia1").prop("disabled",true);
        $("#aceptar1").hide();
        trae_registros();
        $("#estado1").prop("disabled",true);
        $("#respuesta").prop("disabled",true);
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar1").show();
      }
    }
  });  
}
function veri(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "pqr_consu1.php",
    data:
    {
      conse: valor,
      ano: valor1,
      unidad: valor2
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
      $("#soportes").accordion({active: 2});
      var registros = JSON.parse(data);
      var estado = registros.estado;
      estado = estado.trim();
      if (estado == "")
      {
        estado = "-";
      }
      $("#carpeta").val(registros.repositorio);
      $("#concepto1").val(registros.concepto);
      $("#nombre1").val(registros.contacto);
      $("#telefono1").val(registros.telefono);
      $("#estado").val(estado);
      $("#conse1").val(registros.conse);
      $("#ano1").val(registros.ano);
      $("#unidad1").val(registros.unidad);
      $("#envia").val(registros.usuario);
      $("#usuario1").val(registros.usuario);
      $("#respuesta1").val(registros.solucion);
      $("#estado1").val('-');
      $("#respuesta").val('');
      var v_super = $("#v_super").val();
      if (v_super == "1")
      {
        $("#estado1").prop("disabled",false);
      }
      else
      {
        $("#estado1").prop("disabled",true);
      }
      var estado = $("#estado").val();
      $("#estado1").val(estado);
      if (estado == "B")
      {
        $("#estado1").prop("disabled",true);
      }
      else
      {
        if (estado == "C")
        {
          if (v_super == "1")
          {
            $("#estado1").prop("disabled",true);
          }
          else
          {
            $("#estado1").val('A');
            $("#envia").val('ADM_SIGAR');
            $("#respuesta").prop("disabled",false);
            $("#aceptar1").show();
          }
        }
        else
        {
          if (estado == "D")
          {
            var usuario = $("#usuario").val();
            var envia = $("#envia").val();
            if (usuario == envia)
            {
            }
            else
            {
              $("#estado1").val('-');
              $("#estado1").prop("disabled",false);
              $("#estado1>option[value='-']").attr("disabled","disabled");
              $("#estado1>option[value='A']").attr("disabled","disabled");
              $("#respuesta").prop("disabled",false);
              $("#aceptar1").show();
            }
          }
        }
      }
      var solucion = registros.solucion;
      var text = String.fromCharCode(13);
      var var_ocu = solucion.split('<br>');
      var var_ocu1 = var_ocu.length;
      for (var i=0; i<var_ocu1; i++)
      {
        solucion = solucion.replace("<br>", text);
      }
      $("#respuesta2").val(solucion);
      valida();
    }
  });
}
function vali(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "pqr_consu4.php",
    data:
    {
      conse: valor,
      ano: valor1,
      unidad: valor2
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
      var valores = registros.valores;
      var var_ocu = valores.split('#');
      var var_ocu1 = var_ocu.length;
      var salida = "<table width='100%' align='center' border='1' id='a-table1'>";
      salida += "<tr>";
      salida += "<td height='35' width='30%'><center><b>Fecha</b></center></td>";
      salida += "<td height='35' width='20%'><center><b>Envia</b></center></td>";
      salida += "<td height='35' width='20%'><center><b>Recibe</b></center></td>";
      salida += "<td height='35' width='30%'><center><b>Tiempo</b></center></td>";
      salida += "</tr>";
      for (var i=0; i<var_ocu1-1; i++)
      {
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("|");
        var p1 = var_2[0];
        var p2 = var_2[1];
        var p3 = var_2[2];
        var p4 = var_2[3];
        salida += "<tr>";
        salida += "<td height='35' width='30%'>"+p1+"</td>";
        salida += "<td height='35' width='20%'>"+p2+"</td>";
        salida += "<td height='35' width='20%'>"+p3+"</td>";
        salida += "<td height='35' width='30%'>"+p4+"</td>";
        salida += "</tr>";
      }
      $("#dialogo4").html(salida);
      $("#dialogo4").dialog("open");
      $("#dialogo4").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
  });
}
function consultar()
{
	var fecha1 = $("#fecha1").val();
	var fecha2 = $("#fecha2").val();
  var tipo = $("#tipo_c").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "pqr_consu2.php",
    data:
    {
    	tipo: tipo,
      fecha1: fecha1,
      fecha2: fecha2
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
      var total = registros.total;
      if (total > 0)
      {
      	if (tipo == "1")
      	{
	      	$("#paso_excel").val(registros.valores);
		      excel();
		    }
		    else
		    {
		    	$("#res_grafica").html('');
          var datos = registros.datos;
          var datos1 = registros.datos1;
          var datos2 = registros.datos2;
          var datos3 = registros.datos3;
          if (fecha1 == "")
          {
            var titulo = "Solicitudes PQR";
          }
          else
          {
            var titulo = "Solicitudes PQR entre "+fecha1+' y '+fecha2;
          }
          var salida = "";
          salida += "<div id='grafica1' style='width: 100%; height: 600px; margin: 0 auto'></div>";
          $("#res_grafica").append(salida);
          var grafica1 = '$("#grafica1").highcharts({ chart: { type: "column" }, title: { text: "'+titulo+'" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, xAxis: { categories: [ '+datos+' ], crosshair: true }, yAxis: { min: 0, title: { text: "Totales" } }, tooltip: { pointFormat: "<span style=\'color:{series.color}\'>{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>", shared: true }, credits: { enabled: false }, plotOptions: { column: { stacking: \'percent\', dataLabels: { enabled: true } } }, series: [{ name: \'Solicitudes\', data: [ '+datos1+' ] }, { name: \'Soportes\', data: [ '+datos2+' ] }, { name: \'Otros\', data: [ '+datos3+' ] }] });';
          eval(grafica1);
		    }
	    }
      else
      {
        var detalle = "<center><h3>No se encontraron registros para la consulta</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
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
function check2(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[a-zA-ZáéíóúÁÉÍÓÚñÑ ]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function excel()
{
  formu_excel.submit();
}
function alerta(valor)
{
  alertify.error(valor);
}
</script>
</body>
</html>
<?php
}
// 02/08/2023 - Inclusión click derecho sobre boton de evidencia para obtener codigo
// 02/08/2023 - Retira consulta automatica de los registro pqr - validación boton ver evidencias
// 18/08/2023 - Ajuste envio a usuarios pqrs
// 20/11/2023 - Ajuste casilla de usuario a asignar pqr bloqueado
// 05/12/2023 - Inclusión usuario asignado
// 22/02/2024 - Ajuste validacion asignar usuario inactivo
// 05/05/2025 - Ajuste buscador campo unidad
?>