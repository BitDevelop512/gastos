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
  $verifica = time();
  $alea = strtoupper(md5($verifica));
  $alea = substr($alea,0,5);
  $fecha = date('Y/m/d');
  $ano = date('Y');
  $mes = date('m');
  $mes = intval($mes);
  $mes1 = $mes;
  $mes2 = $mes-1;
  if ($mes == "12")
  {
    $mes = 1;
    $ano = $ano+1;
  }
  else
  {
    $mes = $mes+1;
  }
  $ano1 = date('Y');
  $n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
  $n_periodo = $n_meses[$mes1-1];
  $n_periodo1 = $n_meses[$mes2-1];
  $periodos = "<option value='$mes1'>$n_periodo1</option><option value='$mes'>$n_periodo</option>";
  // Se consulta unidad centralizadora
  $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur1 = odbc_exec($conexion, $query);
  $n_unidad = odbc_result($cur1,1);
  $n_unidad = intval($n_unidad);
  $n_dependencia = odbc_result($cur1,2);
  if ($n_unidad > 3)
  {
    $query1 = "SELECT subdependencia, firma1, firma2, firma3, cargo1, cargo2, cargo3 FROM cx_org_sub WHERE unidad='$n_unidad' AND unic='1'";
  }
  else
  {
    $query1 = "SELECT subdependencia, firma1, firma2, firma3, cargo1, cargo2, cargo3 FROM cx_org_sub WHERE dependencia='$n_dependencia' AND unic='1'";
  }
  $cur2 = odbc_exec($conexion, $query1);
  $unic = odbc_result($cur2,1);
  $query2 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $sql2 = odbc_exec($conexion, $query2);
  $sigla = trim(odbc_result($sql2,1));
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
<body style="overflow-x:hidden; overflow-y:auto;">
<?php
include('titulo.php');
?>
<div>
  <section class="content-header">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="soportes">
          <h3>Informe Ejecutivo de Resultados</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <div id="l_mision">
                  	<label><font face="Verdana" size="2">ORDOP</font></label>
                  </div>
                  <input type="hidden" name="centra" id="centra" class="form-control" value="<?php echo $unic; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="mes" id="mes" class="form-control" value="<?php echo $mes1; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="ano1" id="ano1" class="form-control" value="<?php echo $ano1; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="paso" id="paso" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="paso1" id="paso1" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="paso2" id="paso2" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly">
                  <input type="hidden" name="sigla" id="sigla" class="form-control" value="<?php echo $sigla; ?>" readonly="readonly">
                  <input type="hidden" name="url" id="url" class="form-control" value="<?php echo $url; ?>" readonly="readonly">
                  <select name="mision" id="mision" class="form-control select2" tabindex="1"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <div id="l_mision1">
                  	<label><font face="Verdana" size="2">Misi&oacute;n</font></label>
                  </div>
                  <select name="mision1" id="mision1" class="form-control select2" onchange="trae_mision2();" tabindex="2"></select>
                </div>
              </div>
              <br>
              <div id="datos">
                <div class="row">
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                    <label><font face="Verdana" size="2">Sitio de Desarrollo</font></label>
                    <input type="text" name="area" id="area" class="form-control" maxlength="250" readonly="readonly" tabindex="3">
                  </div>
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                    <label><font face="Verdana" size="2">Factor de Amenaza</font></label>
                    <input type="text" name="factor" id="factor" class="form-control" readonly="readonly" tabindex="4">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Lapso de la ORDOP / Misi&oacute;n</font></label>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Recursos Asigandos</font></label>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Tipo de Cargue</font></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="fechai" id="fechai" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                    <input type="hidden" name="fechai_a" id="fechai_a" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="fechaf" id="fechaf" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                    <input type="hidden" name="fechaf_a" id="fechaf_a" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="valor" id="valor" class="form-control numero" value="0.00" readonly="readonly">
                    <input type="hidden" name="valor1" id="valor1" class="form-control numero" value="0">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <select name="tipo" id="tipo" class="form-control select2">
                      <option value="1">MANUAL</option>
                      <option value="2">ARCHIVO</option>
                    </select>
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <a href="#" id="word" onclick="subir(); return false;">
                      <img src="dist/img/word1.png" width="30" title="Anexar Archivo">
                    </a>
                    <div id="vinculo"></div>
                  </div>
                </div>
                <br>
                <div id="c1">
                  <div class="row">
                    <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                      <label><font face="Verdana" size="2">Actividades de Inteligencia y Contrainteligencia Realizadas</font></label>
                      <textarea name="actividades" id="actividades" class="form-control" rows="4" onblur="val_caracteres('actividades');"></textarea>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                      <label><font face="Verdana" size="2">Sintesis de la Producci&oacute;n</font></label>
                      <textarea name="sintesis" id="sintesis" class="form-control" rows="4" onblur="val_caracteres('sintesis');"></textarea>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                      <label><font face="Verdana" size="2">Aspectos Administrativos</font></label>
                      <textarea name="aspectos" id="aspectos" class="form-control" rows="4" onblur="val_caracteres('aspectos');"></textarea>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                      <label><font face="Verdana" size="2">Bienes Adquiridos en Desarrollo de la ORDOP o Misi&oacute;n</font></label>
                      <textarea name="bienes" id="bienes" class="form-control" rows="4" onblur="val_caracteres('bienes');"></textarea>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                      <label><font face="Verdana" size="2">Personal Participante</font></label>
                      <textarea name="personal" id="personal" class="form-control" rows="4" onblur="val_caracteres('personal');"></textarea>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                      <label><font face="Verdana" size="2">Equipo Especializado y Automotor Empleado</font></label>
                      <textarea name="equipo" id="equipo" class="form-control" rows="4" onblur="val_caracteres('equipo');"></textarea>
                    </div>
                  </div>
                </div>
                <br>
                <div id="c2">
                  <div class="row">
                    <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                      <label><font face="Verdana" size="2">Responsable</font></label>
                      <input type="text" name="responsable" id="responsable" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                    </div>
                    <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                      <label><font face="Verdana" size="2">Elaboro</font></label>
                      <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" autocomplete="off">
                    </div>
                  </div>
                  <br>
                  <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_ciudad" id="v_ciudad" class="form-control" value="<?php echo $ciu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_click" id="v_click" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <center>
                    <font face="Verdana" size="2" color="#ff0000"><b>Presione una sola vez el bot&oacute;n Continuar</b></font>
                    <br><br>
                    <input type="button" name="aceptar" id="aceptar" value="Continuar">
                    <input type="button" name="aceptar2" id="aceptar2" value="Actualizar">
                    <input type="button" name="aceptar1" id="aceptar1" value="Visualizar">
                  </center>
                </div>
              </div>
            </form>
          </div>
          <h3>Consultas</h3>
          <div>
            <div class="row">
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
            <br>
            <div id="tabla3"></div>
            <div id="resultados5"></div>
            <form name="formu3" action="ver_infe.php" method="post" target="_blank">
              <input type="hidden" name="plan_conse" id="plan_conse" class="form-control" readonly="readonly">
              <input type="hidden" name="plan_ano" id="plan_ano" class="form-control" readonly="readonly">
            </form>
            <form name="formu4" action="ver_info.php" method="post" target="_blank">
              <input type="hidden" name="paso_url" id="paso_url" class="form-control" readonly="readonly">
            </form>
          </div>
          <div id="dialogo"></div>
          <div id="dialogo1"></div>
          <div id="dialogo2"></div>
        </div>
      </div>
    </div>
  </section>
</div>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
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
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
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
  $("#fechai").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fechaf").prop("disabled", false);
      $("#fechaf").datepicker("destroy");
      $("#fechaf").val('');
      $("#fechaf").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fechai").val(),
        changeYear: true,
        changeMonth: true
      });
    },
  });
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
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
    width: 420,
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
        paso();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 245,
    width: 620,
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
      "Si": function() {
        $(this).dialog("close");
      },
      "No": function() {
        $(this).dialog("close");
        fechas();
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  //trae_mision();
  $("#c1").hide();
  $("#c2").hide();
  $("#word").hide();
  $("#tipo").change(cargar);
  $("#aceptar").button();
  $("#aceptar").click(pregunta1);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(link);
  $("#aceptar1").hide();
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(actualiza);
  $("#aceptar2").hide();
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#compro").prop("disabled",true);
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#mision").change(trae_mision1);
  $("#fechai").prop("disabled",true);
  $("#fechaf").prop("disabled",true);
  $("#tipo").prop("disabled",true);
  // Cambio para deshabilitar nuevos informes
  $("#mision").prop("disabled",true);
  $("#mision1").prop("disabled",true);
});
function cargar()
{
  var valida = $("#tipo").val();
  if (valida == "1")
  {
    $("#c1").show();
    $("#c2").show();
    $("#word").hide();
  }
  else
  {
    $("#c1").hide();
    $("#c2").show();
    $("#word").show();
  }
}
function pregunta1()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function paso_valor()
{
  var valor = $("#valor").val();
  valor = parseFloat(valor.replace(/,/g,''));
  if (isNaN(valor))
  {
  	$("#aceptar").hide();
  	$("#valor").val('0.00');
  	$("#valor1").val('0');
  }
  else
  {
    $("#aceptar").show();
  	$("#valor1").val(valor);
  }
}
function paso()
{
  var salida = true, detalle = '';
  var valida = $("#tipo").val();
  if (valida == "1")
  {
    if ($("#actividades").val() == '')
    {
      salida = false;
      detalle += "Debe ingresar las Actividades Realizadas<br><br>";
    }
  }
  if ($("#responsable").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar un Responsable<br><br>";
  }
  if ($("#elaboro").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar la persona que Elaboro<br><br>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
  }
  else
  {
    nuevo();
  }
}
function nuevo()
{
  var clicando = $("#v_click").val();
  if (clicando == "1")
  {
    var detalle = "<center><h3>Botón Continuar ya Presionado</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#v_click").val('1');
    $("#aceptar").hide();
    var actividades = $("#actividades").val();
    var sintesis = $("#sintesis").val();
    var aspectos = $("#aspectos").val();
    var bienes = $("#bienes").val();
    var personal = $("#personal").val();
    var equipo = $("#equipo").val();
    var tipo = $("#tipo").val();
  	$.ajax({
  		type: "POST",
  	 	datatype: "json",
  		url: "infe_grab.php",
  		data:
      {
  	  	n_ordop: $("#mision option:selected").html(),
        mision: $("#mision1 option:selected").html(),
  	    centra: $("#centra").val(),
  	    area: $("#area").val(),
  	    factor: $("#factor").val(),
  	    fechai: $("#fechai").val(),
        fechaf: $("#fechaf").val(),
				fechai_a: $("#fechai_a").val(),
  	    fechaf_a: $("#fechaf_a").val(),
  	    valor: $("#valor").val(),
  	    actividades: actividades,
  	    sintesis: sintesis,
  	    aspectos: aspectos,
        bienes: bienes,
				personal: personal,
  	    equipo: equipo,
  	    responsable: $("#responsable").val(),
  	    elaboro: $("#elaboro").val(),
  	    ano: $("#ano").val(),
  	    ano1: $("#ano1").val(),
  	    usuario: $("#v_usuario").val(),
  	    unidad: $("#v_unidad").val(),
  	    ciudad: $("#v_ciudad").val(),
        alea: $("#alea").val(),
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
  	   	var valida = registros.salida;
  	  	if (valida > 0)
  	   	{
          $("#word").hide();
  	    	$("#aceptar").hide();
          if (tipo == "1")
          {
            $("#aceptar1").show();
          }
  	      $("#plan_conse").val(valida);
  	     	$("#plan_ano").val(registros.ano);
          $("#tipo").prop("disabled",true);
  	    	$("#fechai").prop("disabled",true);
  	    	$("#fechaf").prop("disabled",true);
  	    	$("#actividades").prop("disabled",true);
  	     	$("#sintesis").prop("disabled",true);
        	$("#aspectos").prop("disabled",true);
  	      $("#bienes").prop("disabled",true);
  	     	$("#personal").prop("disabled",true);
  	    	$("#equipo").prop("disabled",true);
  	    	$("#responsable").prop("disabled",true);
  	    	$("#elaboro").prop("disabled",true);
  	     	$("#mision").prop("disabled",true);
        	$("#mision1").prop("disabled",true);
        }
  	    else
  	    {
  	    	detalle = "<center><h3><center>Error durante la grabación</h3></center>";
  	    	$("#dialogo").html(detalle);
  	     	$("#dialogo").dialog("open");
  	     	$("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        	$("#aceptar").show();
  	    }
      }
  	});
  }
}
function trae_mision()
{
  $("#mision").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_misiones1.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var j = 0;
      for (var i in registros) 
      {
        j = j+1;
        var ordop = registros[i].ordop;
        var numero = registros[i].numero;
        numero = numero.trim();
        if (numero == "")
        {
          numero = "«";
        }
        salida+="<option value='"+ordop+"'>"+numero+" "+ordop+"</option>";
      }
      if (j == "0")
      {
        salida+="<option value='0'>NO HAY DISPONIBLES</option>";
        $("#mision").append(salida);
        $("#mision1").append(salida);
        $("#datos").hide();
        $("#aceptar").hide();
      }
      else
      {
		    $("#mision").append(salida);
        $("#datos").show();
        $("#aceptar").show();
        trae_mision1();
      }      
    }
  });
}
function trae_mision1()
{
  var valor, valor1, valor2;
  valor = $("#mision").val();
  valor1 = $("#mision option:selected").html();
  var var_ocu = valor1.split(' ');
  valor2 = var_ocu[0];
  valor2 = valor2.trim();
  if (valor2 == "«")
  {
    valor2 = "";
  }
  $("#mision1").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_mision3.php",
    data:
    {
    	ordop: valor,
		  ordop1: valor2
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var conse = "";
      var mision = "";
      var internos = "";
      var aprobadas = "";
      var validaciones = "";
      var salida = "";
      for (var i in registros) 
      {
        mision = registros[i].misiones;
        aprobadas = registros[i].aprobadas;
        conse = registros[i].conse;
        internos = registros[i].internos;
        validaciones = registros[i].validaciones;
        var var_ocu = mision.split('|');
        var var_ocu1 = var_ocu.length;
        var var_ocu2 = internos.split(',');
        var var_ocu3 = validaciones.split(',');
        var var_ocu4 = aprobadas.split('|');
        for (var i=0; i<var_ocu1-1; i++)
        {
          var n_mision = var_ocu[i];
          n_mision = n_mision.trim();
          var n_aprobada = var_ocu4[i];
          n_aprobada = n_aprobada.trim();
          var n_elaborada = var_ocu3[i];
          n_elaborada = parseInt(n_elaborada);
          if ((n_elaborada >= 1) || (n_elaborada == undefined))
          {
          }
          else
          {
            if (n_mision == n_aprobada)
            {
              salida += "<option value='"+conse+"'>"+var_ocu[i]+" ¬ "+conse+" ¬ "+var_ocu2[i]+"</option>";
            }
          }
        }
      }
      $("#mision1").append(salida);
      trae_mision2();
    }
  });
}
function trae_mision2()
{
  var valor, valor1;
  valor = $("#mision").val();
  valor1 = $("#mision1").val();
  valor2 = $("#mision1 option:selected").html();
  valor3 = $("#mision option:selected").html();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_mision2.php",
    data:
    {
      valor: valor,
      valor1: valor1,
      valor2: valor2,
      valor3: valor3
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      if (registros.factores == false)
      {
        registros.factores = ""; 
      }
      $("#area").val(registros.area);
      $("#factor").val(registros.factores);
      $("#fechai").val(registros.fecha1);
      $("#fechaf").val(registros.fecha2);
      $("#fechai_a").val('');
      $("#fechaf_a").val('');
      $("#valor").val(registros.valor);
      paso_valor();
      if ((registros.fecha1 == "") && (registros.fecha2 == ""))
      {
      }
      else
      {
        var val_fec1 = $("#fechai").val();
        var val_fec2 = $("#fechaf").val();
        var detalle = "<center><h3><font color='#3333ff'><b>El Lapso de la ORDOP / Misión<br>"+val_fec1+" - "+val_fec2+" es correcto ?</b></font></h3></center><center><h3><font color='#ff0000'><b>Posteriormente no podrán ser modificados</b></font></h3></center>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
        $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#tipo").prop("disabled",false);
        cargar();
      }
    }
  });
}
function fechas()
{
  var fechai = $("#fechai").val();
  var fechaf = $("#fechaf").val();
  $("#fechai_a").val(fechai)
  $("#fechaf_a").val(fechaf)
  $("#fechai").prop("disabled",false);
  $("#fechaf").prop("disabled",false);
}
function link()
{
  var valor, valor1;
  valor = $("#plan_conse").val();
  valor1 = $("#ano1").val();
  $("#plan_conse").val(valor);
  $("#plan_ano").val(valor1);
  formu3.submit();
}
function link1(valor, ano)
{
  var valor;
  var ano;
  $("#plan_conse").val(valor);
  $("#plan_ano").val(ano);
  formu3.submit();
}
function link2(valor, valor1)
{
  var valor, valor1;
  var url = $("#url").val();
  url = url+"cxvisor/Default?valor1=C:\\inetpub\\wwwroot\\gastos\\upload\\ejecutivo\\"+valor1+"\\"+valor+"\\&valor2="+valor+".docx";
  $("#paso_url").val(url);
  formu4.submit();
}
function consultar()
{
  var mes = $("#mes").val();
  var mes1 = mes-1;
  var ano1 = $("#ano").val();
  var ano2 = $("#ano1").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "infe_consu.php",
    data:
    {
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
      $("#tabla3").html('');
      $("#resultados5").html('');
      var sigla = $("#sigla").val();
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      listareg = [];
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
      salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='5%'><b>No.</b></td><td height='35' width='10%'><b>Fecha</b></td><td height='35' width='10%'><b>Unidad</b></td><td height='35' width='10%'><b>Usuario</b></td><td height='35' width='25%'><b>Ordop</b></td><td height='35' width='20%'><b>Misi&oacute;n</b></td><td height='35' width='10%'><center><b>Valor</b></center></td><td height='35' width='5%'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        ordop = value.ordop;
        ordop = ordop.replace(/[‰]+/g, "");
        ordop = ordop.replace(/[]+/g, "");
        var periodo = value.fecha.split('-');
        var periodo1 = periodo[1];
        periodo1 = parseInt(periodo1);
        var ano = periodo[0];
        ano = parseInt(ano);
        var archivo = value.archivo;
        value.unidad = value.unidad.trim();
        var valores = '"'+value.codigo+'","'+sigla+'"';
        salida2 += "<tr><td height='35' width='5%' id='l1_"+index+"'>"+value.conse+"</td>";
        salida2 += "<td height='35' width='10%' id='l2_"+index+"'>"+value.fecha+"</td>";
        salida2 += "<td height='35' width='10%' id='l3_"+index+"'>"+value.unidad+"</td>";
        salida2 += "<td height='35' width='10%' id='l4_"+index+"'>"+value.usuario+"</td>";
        salida2 += "<td height='35' width='25%' id='l5_"+index+"'>"+ordop+"</td>";
        salida2 += "<td height='35' width='20%' id='l6_"+index+"'>"+value.mision+"</td>";
        salida2 += "<td height='35' width='10%' align='right' id='l7_"+index+"'>"+value.valor+"</td>";
        if (((periodo1 == mes) || (periodo1 == mes1)) && ((ano == ano1) || (ano == ano2)))
        {
          if (archivo == "0")
          {
      		  salida2 += "<td height='35' width='5%' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); modif("+value.conse+","+value.ano+","+value.numero+","+value.consecu+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
          }
          else
          {
            salida2 += "<td height='35' width='5%' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); subir1("+valores+")'><img src='dist/img/word1.png' width='24' border='0' title='Modificar'></a></center></td>";
          }
      	}
      	else
      	{
          //if ((value.unidad == "BRIMI1") || (value.unidad == "BACIM1") || (value.unidad == "BACIM2") || (value.unidad == "BACIM3") || (value.unidad == "BACIM4") || (value.unidad == "BACIM5") || (value.unidad == "BACIM6") || (value.unidad == "BACIM7") || (value.unidad == "BACIM8") || (value.unidad == "BACIM9") || (value.unidad == "BACIF1") || (value.unidad == "BACIF2") || (value.unidad == "BACIF3") || (value.unidad == "BACIF4") || (value.unidad == "BACIF5") || (value.unidad == "BACCE")|| (value.unidad == "BRCIM2") || (value.unidad == "BASMI1") || (value.unidad == "BASMI2") || (value.unidad == "BASMI3") || (value.unidad == "BASMI4") || (value.unidad == "BASMI5") || (value.unidad == "BASEC1") || (value.unidad == "BASEC2") || (value.unidad == "BASEC3") || (value.unidad == "BASEC4") || (value.unidad == "BASEC5") || (value.unidad == "BACSI") || (value.unidad == "BAGOP"))
          //{
          //  salida2 += "<td height='35' width='5%' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); modif("+value.conse+","+value.ano+","+value.numero+","+value.consecu+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
          //}
          //else
          //{
            salida2 += "<td height='35' width='5%' id='l8_"+index+"'><center><img src='imagenes/blanco.png' border='0'></td>";
          //}
      	}
        if (archivo == "0")
        {
          salida2 += "<td height='35' width='5%' id='l9_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); link1("+value.conse+","+value.ano+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td>";
        }
        else
        {
          salida2 += "<td height='35' width='5%' id='l9_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); link2("+valores+")'><img src='dist/img/word.png' width='24' border='0' title='Visualizar'></a></center></td>"; 
        }
        listareg.push(index);
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados5").append(salida2);
    }
  });
}
function modif(valor, valor1, valor2, valor3)
{
  $("#soportes").accordion({active: 0});
  var valor, valor1, valor2, valor3;
  $("#paso").val(valor);
  $("#paso1").val(valor2);
  $("#paso2").val(valor3);
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "infe_consu1.php",
    data:
    {
      conse: valor,
      ano: valor1,
      numero: valor2,
      consecu: valor3
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
      $("#c1").show();
      $("#c2").show();
      var registros = JSON.parse(data);
      $.each(registros.rows, function (index, value)
      {
      	$("#area").val(value.sitio);
      	$("#factor").val(value.factor);
      	$("#fechai").val(value.fechai);
      	$("#fechaf").val(value.fechaf);
      	$("#valor").val(value.valor);
      	var actividades = value.actividades;
      	$("#actividades").val(actividades);
      	var sintesis = value.sintesis;
      	$("#sintesis").val(sintesis);
      	var aspectos = value.aspectos;
      	$("#aspectos").val(aspectos);
      	var bienes = value.bienes;
      	$("#bienes").val(bienes);
      	var personal = value.personal;
      	$("#personal").val(personal);
      	var equipo = value.equipo;
      	$("#equipo").val(equipo);
      	var responsable = value.responsable;
      	$("#responsable").val(responsable);
        var elaboro = value.elaboro;
        $("#elaboro").val(elaboro);
      	$("#l_mision").hide();
      	$("#l_mision1").hide();
      	$("#mision").hide();
      	$("#mision1").hide();
      });
      $("#aceptar").hide();
      $("#aceptar2").show();
    }
  });
}
function actualiza()
{
  $("#aceptar2").hide();
  var actividades = $("#actividades").val();
  var sintesis = $("#sintesis").val();
  var aspectos = $("#aspectos").val();
  var bienes = $("#bienes").val();
  var personal = $("#personal").val();
  var equipo = $("#equipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "infe_grab1.php",
    data:
    {
      actividades: actividades,
      sintesis: sintesis,
      aspectos: aspectos,
      bienes: bienes,
      personal: personal,
      equipo: equipo,
      responsable: $("#responsable").val(),
      elaboro: $("#elaboro").val(),
      paso: $("#paso").val(),
      paso1: $("#paso1").val(),
      paso2: $("#paso2").val()
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
      if (valida > 0)
      {
        $("#word").hide();
        $("#aceptar2").hide();
        $("#aceptar1").show();
        $("#plan_conse").val(valida);
        $("#plan_ano").val(registros.ano);
        $("#tipo").prop("disabled",true);
        $("#actividades").prop("disabled",true);
        $("#sintesis").prop("disabled",true);
        $("#aspectos").prop("disabled",true);
        $("#bienes").prop("disabled",true);
        $("#personal").prop("disabled",true);
        $("#equipo").prop("disabled",true);
        $("#responsable").prop("disabled",true);
        $("#mision").prop("disabled",true);
        $("#mision1").prop("disabled",true);
      }
      else
      {
        detalle = "<center><h3><center>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar").show();
      }
    }
  });
}
function subir()
{
  var alea = $("#alea").val();
  var sigla = $("#sigla").val();
  var url = "<a href='./subir6.php?alea="+alea+"&sigla="+sigla+"' name='lnk1' id='lnk1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnk1").click();
}
function subir1(valor, valor1)
{
  var alea = valor;
  var sigla = valor1;
  var url = "<a href='./subir6.php?alea="+alea+"&sigla="+sigla+"' name='lnk1' id='lnk1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnk1").click();
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
function alerta(valor)
{
  alertify.error(valor);
}
</script>
</body>
</html>
<?php
}
?>