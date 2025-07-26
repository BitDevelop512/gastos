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
  $ano = date('Y');
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
          <h3>Estad&iacute;sticas Varias</h3>
          <div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Estad&iacute;stica:</font></label>
                  <select name="consulta" id="consulta" class="form-control select2" tabindex="1">
                    <option value="1">ESTADO PLANES / SOLICITUDES</option>
                    <option value="2">PLANES / SOLICITUDES APOYADAS</option>
                    <option value="10">PLANES CENTRALIZADOS</option>
                    <!--<option value="3">LEGALIZACION RECURSO</option>-->
                    <!--<option value="4">PORCENTAJES DE USO</option>-->
                    <option value="5">GASTOS</option>
                    <?php
                    if (($uni_usuario == "1") or ($uni_usuario == "2"))
                    {
                    ?>
                      <option value="6">RECURSOS EJECUTADOS</option>
                      <option value="7">ACTIVIDAD DE USUARIOS</option>
                      <option value="8">INDICADORES</option>
                      <!--<option value="9">PARQUE AUTOMOTOR</option>-->
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <div id="lbl1">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Tipo</font></label>
                    <select name="tipo" id="tipo" class="form-control select2" tabindex="2">
                      <option value="3">TODOS</option>
                      <option value="1">PLAN DE INVERSION</option>
                      <option value="2">SOLICITUD DE RECURSOS</option>
                    </select>
                  </div>
                </div>
                <div id="lbl3">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Concepto</font></label>
                  <select name="pagos" id="pagos" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas conceptos" tabindex="3"></select>
                  </div>
                </div>
                <div id="lbl6">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Recurso</font></label>
                    <select name="recursos" id="recursos" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas recursos" tabindex="4">
                      <option value="0">TODOS</option>
                      <option value="1">GASTOS EN ACTIVIDADES</option>
                      <option value="2">PAGOS DE INFORMACIÓN</option>
                      <option value="3">PAGOS DE RECOMPENSAS</option>
                      <option value="4">GASTOS DE PROTECCIÓN</option>
                      <option value="5">GASTOS DE COBERTURA</option>
                    </select>
                  </div>
                </div>
                <div id="lbl7">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Clase de Veh&iacute;culo</font></label>
                    <select name="clase" id="clase" class="form-control select2" tabindex="5">
                      <option value="0">TODOS</option>
                      <option value="1">MOTOCICLETA</option>
                      <option value="2">AUTOMOVIL</option>
                      <option value="3">CAMIONETA</option>
                      <option value="4">VANS</option>
                    </select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Tipo de Fecha</font></label>
                    <select name="fechat" id="fechat" class="form-control select2" tabindex="6">
                      <option value="1">REGISTRO</option>
                      <option value="2">SOAT</option>
                      <option value="3">RTM</option>
                      <option value="4">MANTENIMIENTO</option>
                    </select>
                  </div>
                </div>
                <div id="lbl4">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Periodo</font></label>
                    <input type="text" name="fecha1" id="fecha1" placeholder="yy/mm/dd" class="form-control fecha" readonly="readonly" tabindex="7">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">&nbsp;</font></label>
                    <input type="text" name="fecha2" id="fecha2" placeholder="yy/mm/dd" class="form-control fecha" readonly="readonly" tabindex="8">
                  </div>
                </div>
                <div id="lbl5">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Periodo Inicial</font></label>
                    <select name="periodo1" id="periodo1" class="form-control select2" onchange="val_periodo();" tabindex="9">
                      <option value="1">ENERO</option>
                      <option value="2">FEBRERO</option>
                      <option value="3">MARZO</option>
                      <option value="4">ABRIL</option>
                      <option value="5">MAYO</option>
                      <option value="6">JUNIO</option>
                      <option value="7">JULIO</option>
                      <option value="8">AGOSTO</option>
                      <option value="9">SEPTIEMBRE</option>
                      <option value="10">OCTUBRE</option>
                      <option value="11">NOVIEMBRE</option>
                      <option value="12">DICIEMBRE</option>
                    </select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Periodo Final</font></label>
                    <select name="periodo2" id="periodo2" class="form-control select2" tabindex="10">
                      <option value="1">ENERO</option>
                      <option value="2">FEBRERO</option>
                      <option value="3">MARZO</option>
                      <option value="4">ABRIL</option>
                      <option value="5">MAYO</option>
                      <option value="6">JUNIO</option>
                      <option value="7">JULIO</option>
                      <option value="8">AGOSTO</option>
                      <option value="9">SEPTIEMBRE</option>
                      <option value="10">OCTUBRE</option>
                      <option value="11">NOVIEMBRE</option>
                      <option value="12">DICIEMBRE</option>
                    </select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">A&ntilde;o</font></label>
                    <select name="ano" id="ano" class="form-control select2" tabindex="11"></select>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Unidad Centralizadora</font></label>
                  <?php
                  $menu1_1 = odbc_exec($conexion,"SELECT unidad, sigla FROM cx_org_sub WHERE unic='1' AND subdependencia!='301' ORDER BY sigla");
                  $menu1 = "<select name='centra' id='centra' class='form-control select2' onchange='busca();' tabindex='17'>";
                  $i = 1;
                  $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
                  while($i<$row=odbc_fetch_array($menu1_1))
                  {
                    $nombre = trim($row['sigla']);
                    $menu1 .= "\n<option value=$row[unidad]>".$nombre."</option>";
                    $i++;
                  }
                  $menu1 .= "\n</select>";
                  echo $menu1;
                  ?>
                </div>
                <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7">
                  <label><font face="Verdana" size="2">Unidades:</font></label>
                  <select name="unidad" id="unidad" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas unidades" tabindex="12"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <input type="button" name="aceptar" id="aceptar" value="Consultar" tabindex="13">
                </div>
              </div>
            </form>
            <div id="dialogo"></div>
          </div>
          <h3>Resultados</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu1" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <div id="lbl2">
                    <label><font face="Verdana" size="2">Tipo de Gr&aacute;fica</font></label>
                  </div>
                  <select name="grafica" id="grafica" class="form-control" onchange="cambia();" tabindex="1">
                    <option value="1">Torta</option>
                    <option value="2">Barras</option>
                  </select>
                </div>
              </div>
              <div id="res_grafica"></div>
              <div id="resultados9"></div>
              <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="paso" id="paso" class="form-control" readonly="readonly">
              <input type="hidden" name="paso1" id="paso1" class="form-control" readonly="readonly">
              <input type="hidden" name="paso2" id="paso2" class="form-control" readonly="readonly">
              <div id="link"></div>
            </form>
            <!--
            <form name="formu_excel" id="formu_excel" action="indicadores_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
              <input type="hidden" name="paso_excel1" id="paso_excel1" class="form-control" readonly="readonly">
            </form>
            -->
            <form name="formu_excel" id="formu_excel" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
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
  $("#fecha1").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fecha2").prop("disabled",false);
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
    height: 270,
    width: 520,
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
  $("#aceptar").click(consultar);
  $("#aceptar").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#centra").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#unidad").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#pagos").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#recursos").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#consulta").focus();
  $("#consulta").change(valida);
  trae_pagos();
  trae_ano();
  valida();
  $("#ano").val('<?php echo $ano; ?>');
});
function trae_ano()
{
  $("#ano").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_ano.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var j = 0;
      for (var i in registros) 
      {
        j = j+1;
        var ano = registros[i].ano;
        salida += "<option value='"+ano+"'>"+ano+"</option>";
      }
      $("#ano").append(salida);
    }
  });
}
function val_periodo()
{
  var periodo = $("#periodo1").val();
  $("#periodo2").val(periodo);
}
function trae_unidades(valor)
{
  var valor;
  $("#unidad").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unid1.php",
    data:
    {
      valor: valor
    },    
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#unidad").append(salida);
      busca();
    }
  });
}
function trae_pagos()
{
  $("#pagos").html('');
  var tipo = "0";
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
      var salida = "<option value='0'>TODOS</option>";
      for (var i in registros)
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#pagos").append(salida);
    }
  });
}
function valida()
{ 
  var consulta = $("#consulta").val();
  if (consulta == "1")
  {
    $("#lbl1").show();
    $("#lbl2").show();
    $("#lbl3").hide();
    $("#lbl4").hide();
    $("#lbl5").show();
    $("#lbl6").hide();
    $("#lbl7").hide();
  }
  else
  {
    if (consulta == "5")
    {
      $("#lbl1").hide();
      $("#lbl2").hide();
      $("#lbl3").show();
      $("#lbl4").hide();
      $("#lbl5").show();
      $("#lbl6").hide();
      $("#lbl7").hide();
    }
    else
    {
      if (consulta == "6")
      {
        $("#lbl1").hide();
        $("#lbl2").hide();
        $("#lbl3").hide();
        $("#lbl4").hide();
        $("#lbl5").show();
        $("#lbl6").show();
        $("#lbl7").hide();
      }
      else
      {
      	if (consulta == "8")
      	{
		      $("#lbl1").hide();
		      $("#lbl2").hide();
		      $("#lbl3").hide();
		      $("#lbl4").hide();
		      $("#lbl5").show();
		      $("#lbl6").hide();
          $("#lbl7").hide();
      	}
      	else
      	{
          if (consulta == "9")
          {
            $("#lbl1").hide();
            $("#lbl2").show();
            $("#lbl3").hide();
            $("#lbl4").show();
            $("#lbl5").hide();
            $("#lbl6").hide();
            $("#lbl7").show();
          }
          else
          {
            if (consulta == "2")
            {
              $("#lbl1").hide();
              $("#lbl2").hide();
              $("#lbl3").hide();
              $("#lbl4").hide();
              $("#lbl5").show();
              $("#lbl6").hide();
              $("#lbl7").hide();
            }
            else
            {
              if (consulta == "10")
              {
                $("#lbl1").hide();
                $("#lbl2").hide();
                $("#lbl3").hide();
                $("#lbl4").hide();
                $("#lbl5").show();
                $("#lbl6").hide();
                $("#lbl7").hide();
              }
              else
              {
      	        $("#lbl1").hide();
      	        $("#lbl2").hide();
      	        $("#lbl3").hide();
      	        $("#lbl4").show();
      	        $("#lbl5").hide();
      	        $("#lbl6").hide();
                $("#lbl7").hide();
              }
            }
          }
	       }
      }
    }
  }
  if (consulta == "6")
  {
    trae_unidades(1);
    $("#centra").prop("disabled", true);
  }
  else
  {
    trae_unidades(0);
    $("#centra").prop("disabled", false);
  	if ((consulta == "8") || (consulta == "10"))
  	{
  		$("#unidad").prop("disabled", true);
  	}
  	else
  	{
  		$("#unidad").prop("disabled", false);
  	}
  }
}
function busca()
{
  var centra = $("#centra").val();
  var sigla = $("#centra option:selected").html();
  var consulta = $("#consulta").val();
  if (centra == "-")
  {
    $("#unidad").val('');
    var paso = "[]";
    var final = '$("#unidad").val('+paso+').trigger("change");';
    eval(final);
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_unidad1.php",
      data:
      {
        consulta: consulta,
        centra: centra,
        sigla: sigla
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
        $("#unidad").val('');
        var registros = JSON.parse(data);
        var datos = registros.salida;
        var var_ocu = datos.split('|');
        var var_ocu1 = var_ocu.length;
        var paso = "";
        for (var i=0; i<var_ocu1-1; i++)
        {
          paso += "'"+var_ocu[i]+"',";
        }
        paso = paso.substr(0, paso.length-1);
        paso = "["+paso+"]";
        var final = '$("#unidad").val('+paso+').trigger("change");';
        eval(final);
      }
    });
  }
}
function consultar()
{
  var salida = true;
  var detalle = '';
  var fecha1 = $("#fecha1").val();
  var fecha2 = $("#fecha2").val();
  var periodo1 = $("#periodo1").val();
  periodo1 = parseInt(periodo1);
  var periodo2 = $("#periodo2").val();
  periodo2 = parseInt(periodo2);
  var periodo3 = $("#periodo1 option:selected").html();
  var periodo4 = $("#periodo2 option:selected").html();
  var ano = $("#ano").val();
  var pagos = $("#pagos").select2('val');
  var recursos = $("#recursos").select2('val');
  var unidad = $("#unidad").select2('val');
  var centra = $("#centra").val();
  var sigla = $("#centra option:selected").html();
  var consulta = $("#consulta").val();
  if ((consulta == "1") || (consulta == "2") || (consulta == "5") || (consulta == "10"))
  {
    if (periodo2 < periodo1)
    {
      salida = false;
      detalle += "<center><h3>Periodo final no válido</h3></center>";
    }
    if (consulta == "5")
    {
      if (pagos == null)
      {
        salida = false;
        detalle += "<center><h3>Debe seleccionar mínimo un concepto</h3></center>";
      }
    }
  }
  else
  {
    if ((consulta == "6") || (consulta == "8"))
    {
      if (periodo2 < periodo1)
      {
        salida = false;
        detalle += "<center><h3>Periodo final no válido</h3></center>";
      }
      if (consulta == "8")
      {
      }
      else
      {
	      if (recursos == null)
	      {
	        salida = false;
	        detalle += "<center><h3>Debe seleccionar mínimo un recurso</h3></center>";
	      }
	     }
    }
    else
    {
      if ($("#fecha1").val() == '')
      {
        salida = false;
        detalle += "<center><h3>Debe seleccionar una fecha inicial</h3></center>";
      }
      if ($("#fecha2").val() == '')
      {
        salida = false;
        detalle += "<center><h3>Debe seleccionar una fecha final</h3></center>";
      }
    }
  }
  if (unidad == null)
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar mínimo una unidad</h3></center>";
  }
  else
  {
    var n_unidad = unidad.length;
    if (n_unidad > 40)
    {
      salida = false;
      detalle += "<center><h3>Debe seleccionar máximo 40 unidades</h3></center>";
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
    $("#soportes").accordion({active: 1});
    $("#res_grafica").html('');
    $("#resultados9").html('');
    var consulta = $("#consulta").val();
    if (consulta == "1")
    {
      var url = "con_estadisticas.php";
      formu_excel.action = "esta_estados_x.php";
    }
    if (consulta == "2")
    {
      var url = "con_estadisticas1.php";
      formu_excel.action = "esta_apoyados_x.php";
    }
    if (consulta == "3")
    {
      var url = "con_estadisticas2.php";
    }
    if (consulta == "5")
    {
      var url = "con_estadisticas3.php";
    }
    if (consulta == "6")
    {
      var url = "con_estadisticas4.php";
    }
    if (consulta == "7")
    {
      var url = "con_estadisticas5.php";
    }
    if (consulta == "8")
    {
      var url = "con_estadisticas6.php";
    }
    if (consulta == "9")
    {
      var url = "con_estadisticas7.php";
    }
    if (consulta == "10")
    {
      var url = "con_estadisticas8.php";
      formu_excel.action = "esta_centralizados_x.php";
    }
    $("#grafica").hide();
    $.ajax({
      type: "POST",
      datatype: "json",
      url: url,
      data:
      {
        consulta: $("#consulta").val(),
        tipo: $("#tipo").val(),
        clase: $("#clase").val(),
        pago: pagos,
        recurso: recursos,
        fecha1: $("#fecha1").val(),
        fecha2: $("#fecha2").val(),
        periodo1: $("#periodo1").val(),
        periodo2: $("#periodo2").val(),
        ano: $("#ano").val(),
        unidad: unidad,
        centra: centra,
        sigla: sigla
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
        if (consulta == "1")
        {
          var datos = registros.datos;
          var var_ocu = datos.split('#');
          var var_ocu1 = var_ocu.length;
          var salida = "";
          var series = "";
          var series1 = "";
          var paso = "";
          var sum_total = 0;
          for (var i=0; i<var_ocu1-1; i++)
          {
            paso = var_ocu[i];
            var var_ocu2 = paso.split('|');
            var var_ocu3 = var_ocu2.length;
            for (var j=0; j<var_ocu3-1; j++)
            {
              var v1 = var_ocu2[0];           // Unidad
              var v2 = var_ocu2[1];           // Tipo
              var v3 = var_ocu2[2];           // Sigla
              var v4 = var_ocu2[3];           // Estado
              var v5 = var_ocu2[4];           // Estado1
              var v6 = var_ocu2[5];           // Total
              v6 = parseInt(v6);
            }
            sum_total = sum_total+v6;
          }
          var datos1 = registros.datos1;
          var var_ocu = datos1.split('#');
          var var_ocu1 = var_ocu.length;
          var paso = "";
          var sum_total1 = 0;
          for (var i=0; i<var_ocu1-1; i++)
          {
            paso = var_ocu[i];
            var var_ocu2 = paso.split('|');
            var var_ocu3 = var_ocu2.length;
            for (var j=0; j<var_ocu3-1; j++)
            {
              var v1 = var_ocu2[0];           // Sigla
              var v2 = var_ocu2[1];           // Tipo
              v2 = parseInt(v2);
            }
            sum_total1 = sum_total1+v2;
            series1 += '{ name: "'+v1+'", y: '+v2+', drilldown: "'+v1+'" }, ';
          }
          series1 = series1.substr(0, series1.length-2);
          var datos2 = registros.datos2;
          $("#paso").val(series1);
          $("#paso1").val(datos2);
          $("#paso2").val(sum_total1);
          var series = '{ name: "Planes / Solicitudes", colorByPoint: true, data: [ '+series1+' ] }';
          salida += "<div id='grafica1' style='width: 100%; height: 600px; margin: 0 auto'></div>";
          $("#res_grafica").append(salida);
          var grafica1 = '$("#grafica1").highcharts({ chart: { type: "pie" }, title: { text: "Estado Planes / Solicitudes entre '+periodo3+' y '+periodo4+'" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, accessibility: { announceNewData: { enabled: true }, point: { valueSuffix: "%" } }, ';
          grafica1 += 'credits: { enabled: false }, plotOptions: { series: { dataLabels: { enabled: true, format: "{point.name}: {point.y}" }, showInLegend: true } }, tooltip: { headerFormat: "<span style=\'font-size:11px\'>{series.name}</span><br>", pointFormat: "<span style=\'color:{point.color}\'>{point.name}</span>: {point.y} de '+sum_total1+'<br/>" }, series: [ '+series+' ], drilldown: { series: [ '+datos2+' ] } });';
          eval(grafica1);
          $("#grafica").show();
          $("#grafica").val('1');
          // Totales
          var titulo = "Valor Planes y Solicitudes Aprobadas entre "+periodo3+" y "+periodo4;
          var salida = "";
          var v_var1 = "";
          salida += "<br><div class='col col-lg-2 col-sm-2 col-md-2 col-xs-2'>&nbsp;</div><div class='col col-lg-8 col-sm-8 col-md-8 col-xs-8'><center><h3>"+titulo+"</h3></center></div><div class='col col-lg-2 col-sm-2 col-md-2 col-xs-2'><center><a href='#' id='excel' onclick='excel(); return false;'><img src='dist/img/excel.png' title='Exportar Estad&iacute;stica a Excel - SAP'></a></center></div><br><br>";
          salida += "<table width='50%' align='center' border='1'><tr>";
          salida += "<td width='60%' height='35' bgcolor='#2E90BD'><center><b>Unidad</b></center></td>";
          salida += "<td width='20%' height='35' bgcolor='#2E90BD'><center><b>Solicitudes</b></center></td>";
          salida += "<td width='20%' height='35' bgcolor='#2E90BD'><center><b>Planes</b></center></td>";
          salida += "</tr></table>";
          salida += "<table width='50%' align='center' border='1' id='a-table1'>";
          var datos3 = registros.datos3;
          var var_ocu = datos3.split('#');
          var var_ocu1 = var_ocu.length;
          var total1 = 0;
          var total2 = 0;
          for (var i=0; i<var_ocu1-1; i++)
          {
            var var1 = var_ocu[i];
            var var_ocu2 = var1.split("|");
            var var_ocu3 = var_ocu2.length;
            for (var j=0; j<var_ocu3-1; j++)
            {
              var var1 = var_ocu2[0];
              var var2 = var_ocu2[1];
              var var3 = var_ocu2[2];
              var var4 = parseInt(var2);
              var var5 = formatNumber(var4);
              var var6 = parseInt(var3);
              var var7 = formatNumber(var6);
            }
            total1 = total1+var4;
            total2 = total2+var6;
            total3 = formatNumber(total1);
            total4 = formatNumber(total2);
            salida += "<tr>";
            salida += "<td width='60%' height='35'>"+var1+"</td>";
            salida += "<td width='20%' height='35' align='right'>"+var5+"&nbsp;</td>";
            salida += "<td width='20%' height='35' align='right'>"+var7+"&nbsp;</td>";
            salida += "</tr>";
            v_var1 += var1+"|"+var4+"|"+var6+"|#";
          }
          v_var1 += "TOTAL|"+total1+"|"+total2+"|#";
          salida += "<tr><td width='60%' height='35'><b>TOTAL:</b></td><td width='20%' height='35' align='right'><b>"+total3+"</b></td><td width='20%' height='35' align='right'><b>"+total4+"</b></td></tr>";
          salida += "</table>";
          $("#paso_excel").val(v_var1);
          $("#resultados9").append(salida);
        }
        if (consulta == "2")
        {
          var datos = registros.datos;
          var datos1 = registros.datos1;
          var datos2 = registros.datos2;
          var datos3 = registros.datos3;
          var datos4 = registros.datos4;
          var datos6 = registros.datos6;
          var salida = "";
          salida += "<div id='grafica1' style='width: 100%; height: 600px; margin: 0 auto'></div>";
          $("#res_grafica").append(salida);
          var grafica1 = '$("#grafica1").highcharts({ chart: { type: "column" }, title: { text: "Planes / Solicitudes Apoyadas entre '+periodo3+' y '+periodo4+'" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, xAxis: { categories: [ '+datos+' ], crosshair: true }, yAxis: { min: 0, title: { text: "Totales" } }, tooltip: { headerFormat: "<span style=\'font-size:11px\'>{point.key}</span><table>", pointFormat: "<tr><td style=\'color:{series.color};padding:0\'>{series.name}: </td><td style=\'padding: 0\'><b>{point.y: .0f}</b></td></tr>", footerFormat: "</table>", shared: true, useHTML: true }, credits: { enabled: false }, plotOptions: { column: { pointPadding: 0.2, borderWidth: 0, dataLabels: { enabled: true } } }, colors: [\'#4572A7\', \'#AA4643\', \'#89A54E\', \'#FF9933\', \'#CC00CC\'], series: [{ name: "Gastos en Actividades", data: [ '+datos2+'] }, { name: "Pago de Informaciones", data: [ '+datos3+'] }, { name: "Total Autorizados", data: [ '+datos1+'] }, { name: "Solicitudes de Recursos", data: [ '+datos4+'] }, { name: "Recompensas", data: [ '+datos6+'] }] });';
          eval(grafica1);
          // Totales
          var titulo = "Valores Planes / Solicitudes / Recompensas Aprobadas entre "+periodo3+' y '+periodo4;
          var salida = "";
          var v_var1 = "";
          salida += "<br><div class='col col-lg-2 col-sm-2 col-md-2 col-xs-2'>&nbsp;</div><div class='col col-lg-8 col-sm-8 col-md-8 col-xs-8'><center><h3>"+titulo+"</h3></center></div><div class='col col-lg-2 col-sm-2 col-md-2 col-xs-2'><center><a href='#' id='excel' onclick='excel(); return false;'><img src='dist/img/excel.png' title='Exportar Estad&iacute;stica a Excel - SAP'></a></center></div><br><br>";
          salida += "<table width='85%' align='center' border='1'>";
          salida += "<tr>";
          salida += "<td width='10%' height='35' bgcolor='#6699FF'><center>&nbsp;</center></td>";
          salida += "<td colspan='2' height='35' bgcolor='#2E90BD'><center><b>Planes</b></center></td>";
          salida += "<td colspan='2' height='35' bgcolor='#6699FF'><center><b>Solicitud de Recursos</b></center></td>";
          salida += "<td colspan='2' height='35' bgcolor='#2E90BD'><center><b>Recompensas</b></center></td>";
          salida += "</tr>";
          salida += "<tr>";
          salida += "<td width='10%' height='35' bgcolor='#6699FF'><center><b>Unidad</b></center></td>";
          salida += "<td width='15%' height='35' bgcolor='#2E90BD'><center><b>Gastos en Actividades</b></center></td>";
          salida += "<td width='15%' height='35' bgcolor='#2E90BD'><center><b>Pago de Informaciones</b></center></td>";
          salida += "<td width='15%' height='35' bgcolor='#6699FF'><center><b>Gastos en Actividades</b></center></td>";
          salida += "<td width='15%' height='35' bgcolor='#6699FF'><center><b>Pago de Informaciones</b></center></td>";
          salida += "<td width='15%' height='35' bgcolor='#2E90BD'><center><b>Pago de Recompensas</b></center></td>";
          salida += "<td width='15%' height='35' bgcolor='#2E90BD'><center><b>Pago de Informaciones</b></center></td>";
          salida += "</tr>";
          salida += "</table>";
          salida += "<table width='85%' align='center' border='1' id='a-table1'>";
          var datos5 = registros.datos5;
          var var_ocu = datos5.split('#');
          var var_ocu1 = var_ocu.length;
          var total1 = 0;
          var total2 = 0;
          var total3 = 0;
          var total7 = 0;
          var total8 = 0;
          var total11 = 0;
          var total12 = 0;
          for (var i=0; i<var_ocu1-1; i++)
          {
            var var1 = var_ocu[i];
            var var_ocu2 = var1.split("|");
            var var_ocu3 = var_ocu2.length;
            for (var j=0; j<var_ocu3-1; j++)
            {
              var var1 = var_ocu2[0];
              var var2 = var_ocu2[1];
              var var3 = var_ocu2[2];
              var var4 = var_ocu2[3];
              var var5 = parseInt(var2);
              var var6 = formatNumber(var5);
              var var7 = parseInt(var3);
              var var8 = formatNumber(var7);
              var var9 = parseInt(var4);
              var var10 = formatNumber(var9);
              var var11 = var_ocu2[4];
              var var12 = var_ocu2[5];
              var var13 = parseInt(var11);
              var var14 = formatNumber(var13);
              var var15 = parseInt(var12);
              var var16 = formatNumber(var15);
              var var17 = var_ocu2[6];
              var var18 = var_ocu2[7];
              var var19 = parseInt(var17);
              var var20 = formatNumber(var19);
              var var21 = parseInt(var18);
              var var22 = formatNumber(var21);
            }
            total1 = total1+var5;
            total2 = total2+var7;
            total3 = total3+var9;
            total4 = formatNumber(total1);
            total5 = formatNumber(total2);
            total6 = formatNumber(total3);
            total7 = total7+var13;
            total8 = total8+var15;
            total9 = formatNumber(total7);
            total10 = formatNumber(total8);
            total11 = total11+var19;
            total12 = total12+var21;
            total13 = formatNumber(total11);
            total14 = formatNumber(total12);
            salida += "<tr>";
            salida += "<td width='10%' height='35'>"+var1+"</td>";
            salida += "<td width='15%' height='35' align='right'>"+var6+"&nbsp;</td>";
            salida += "<td width='15%' height='35' align='right'>"+var8+"&nbsp;</td>";
            salida += "<td width='15%' height='35' align='right'>"+var14+"&nbsp;</td>";
            salida += "<td width='15%' height='35' align='right'>"+var16+"&nbsp;</td>";
            salida += "<td width='15%' height='35' align='right'>"+var20+"&nbsp;</td>";
            salida += "<td width='15%' height='35' align='right'>"+var22+"&nbsp;</td>";
            salida += "</tr>";
            v_var1 += var1+"|"+var5+"|"+var7+"|"+var13+"|"+var15+"|"+var19+"|"+var21+"|#";
          }
          v_var1 += "TOTAL|"+total1+"|"+total2+"|"+total7+"|"+total8+"|"+total11+"|"+total12+"|#";
          salida += "<tr><td width='10%' height='35'><b>TOTAL:</b></td><td width='15%' height='35' align='right'><b>"+total4+"&nbsp;</b></td><td width='15%' height='35' align='right'><b>"+total5+"&nbsp;</b></td><td width='15%' height='35' align='right'><b>"+total9+"&nbsp;</b></td><td width='15%' height='35' align='right'><b>"+total10+"&nbsp;</b></td><td width='15%' height='35' align='right'><b>"+total13+"&nbsp;</b></td><td width='15%' height='35' align='right'><b>"+total14+"&nbsp;</b></td></tr>";
          salida += "</table>";
          $("#paso_excel").val(v_var1);
          $("#resultados9").append(salida);
        }
        // Planes Centralizados
        if (consulta == "10")
        {
          var total = registros.total;
          if (total > 0)
          {
            var titulo = "Planes Centralizados entre "+periodo3+' y '+periodo4;           
            var salida = "";
            var v_var1 = "";
            salida += "<br><div class='col col-lg-2 col-sm-2 col-md-2 col-xs-2'>&nbsp;</div><div class='col col-lg-8 col-sm-8 col-md-8 col-xs-8'><center><h3>"+titulo+"</h3></center></div><div class='col col-lg-2 col-sm-2 col-md-2 col-xs-2'><center><a href='#' id='excel' onclick='excel(); return false;'><img src='dist/img/excel.png' title='Exportar Estad&iacute;stica a Excel - SAP'></a></center></div><br><br>";
            salida += "<table width='70%' align='center' border='1'>";
            salida += "<tr>";
            salida += "<td width='15%' height='35' bgcolor='#2E90BD'><center><b>Unidad</b></center></td>";
            salida += "<td width='25%' height='35' bgcolor='#2E90BD'><table width='100%' align='center' border='0'><tr><td width='30%'><center><b>Periodo</b></center></td><td width='30%'><center><b>Número</b></center></td><td width='40%'><center><b>Fecha</b></center></td></tr></table></td>";
            salida += "<td width='20%' height='35' bgcolor='#2E90BD'><center><b>Gastos en Actividades</b></center></td>";
            salida += "<td width='20%' height='35' bgcolor='#2E90BD'><center><b>Pago de Informaciones</b></center></td>";
            salida += "<td width='20%' height='35' bgcolor='#2E90BD'><center><b>Total</b></center></td>";
            salida += "</tr>";
            salida += "</table>";
            salida += "<table width='70%' align='center' border='1' id='a-table1'>";
            var datos = registros.datos;
            var var_ocu = datos.split('#');
            var var_ocu1 = var_ocu.length;
            var total1 = 0;
            var total2 = 0;
            var total3 = 0;
            for (var i=0; i<var_ocu1-1; i++)
            {
              var var1 = var_ocu[i];
              var var_ocu2 = var1.split("|");
              var var_ocu3 = var_ocu2.length;
              for (var j=0; j<var_ocu3-1; j++)
              {
                var var1 = var_ocu2[0];
                var var2 = var_ocu2[1];
                var var3 = var_ocu2[2];
                var var4 = var_ocu2[3];
                var var5 = parseInt(var2);               
                var var6 = formatNumber(var5);
                var var7 = parseInt(var3);
                var var8 = formatNumber(var7);
                var var9 = parseInt(var4);
                var var10 = formatNumber(var9);
                var var11 = var_ocu2[4];
                var var12 = var_ocu2[5];
              }
              total1 = total1+var5;
              total2 = total2+var7;
              total3 = total3+var9;
              total4 = formatNumber(total1);
              total5 = formatNumber(total2);
              total6 = formatNumber(total3);
              salida += "<tr>";
              salida += "<td width='15%' height='35'>"+var1+"</td>";
              salida += "<td width='25%' height='35'>"+var12+"</td>";
              salida += "<td width='20%' height='35' align='right'>"+var6+"&nbsp;</td>";
              salida += "<td width='20%' height='35' align='right'>"+var8+"&nbsp;</td>";
              salida += "<td width='20%' height='35' align='right'>"+var10+"&nbsp;</td>";
              salida += "</tr>";
              v_var1 += var1+"|"+var5+"|"+var7+"|"+var9+"|"+var11+"|#";
            }
            v_var1 += "TOTAL|"+total1+"|"+total2+"|"+total3+"||#";
            salida += "<tr><td width='15%' height='35'><b>TOTAL:</b></td><td width='25%' height='35'>&nbsp;</td><td width='20%' height='35' align='right'><b>"+total4+"</b></td><td width='20%' height='35' align='right'><b>"+total5+"</b></td><td width='20%' height='35' align='right'><b>"+total6+"</b></td></tr>";
            salida += "</table>";
            $("#paso_excel").val(v_var1);
            $("#resultados9").append(salida);
          }
          else
          {
            var detalle = "<center><h3>No se encontraron resultados</h3></center>";
            $("#dialogo").html(detalle);
            $("#dialogo").dialog("open");
            $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
        }
        if (consulta == "5")
        {
          var datos = registros.datos;
          var datos1 = registros.datos1;
          var datos2 = registros.datos2;
          var datos3 = registros.datos3;
          var datos4 = registros.datos4;
          var datos5 = registros.datos5;
          var datos6 = "";
          var datos7 = "";
          var datos8 = "";
          var datos9 = "";
          var var_ocu = datos3.split('#');
          var var_ocu1 = var_ocu[0].split(',');
          var var_ocu2 = var_ocu1.length;
          var var_ocu3 = datos4.split('#');
          for (var i=0; i<var_ocu2; i++)
          {
            var paso = var_ocu1[i];
            paso = paso.trim();
            datos6 += '"'+paso+'", ';
            var paso1 = var_ocu3[i];
            datos7 += paso1+'# ';
          }
          datos6 = datos6.substring(0, datos6.length - 2);
          datos7 = datos7.substring(0, datos7.length - 2);
          var var_ocu4 = datos6.split(',');
          var var_ocu5 = var_ocu4.length;
          var var_ocu6 = datos7.split('#');
          var var_ocu7 = datos5.split('#');
          for (var i=0; i<var_ocu5; i++)
          {
            datos8 += "\'#"+var_ocu7[i]+"\', ";
            datos9 += '{ name: '+var_ocu4[i]+', data: ['+var_ocu6[i].trim()+'] }, ';
          }
          datos8 = datos8.substring(0, datos8.length - 2);
          datos9 = datos9.substring(0, datos9.length - 2);
          if (periodo3 == periodo4)
          {
            var titulo = "Gastos Solicitados "+periodo3+" de "+ano;
          }
          else
          {
            var titulo = "Gastos Solicitados entre "+periodo3+' y '+periodo4+" de "+ano;
          }
          var salida = "";
          salida += "<div id='grafica1' style='width: 100%; height: 600px; margin: 0 auto'></div>";
          $("#res_grafica").append(salida);
          var grafica1 = '$("#grafica1").highcharts({ chart: { type: "column" }, title: { text: "'+titulo+'" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, xAxis: { categories: [ '+datos+' ], crosshair: true }, yAxis: { min: 0, title: { text: "Totales" } }, tooltip: { headerFormat: "<span style=\'font-size:11px\'>{point.key}</span><table>", pointFormat: "<tr><td style=\'color: {series.color}; padding: 0\'>{series.name}: </td><td style=\'padding: 0\'>&nbsp;&nbsp;<b>$ {point.y}</b></td></tr>", footerFormat: "</table>", shared: true, useHTML: true }, credits: { enabled: false }, plotOptions: { series: { cursor: "pointer", point: { events: { click: function() { envio(this.category,this.series.name); } } } }, column: { pointPadding: 0.2, borderWidth: 0, dataLabels: { enabled: true, formatter: function() { return "$ "+ Highcharts.numberFormat(this.y, 0); } } } }, colors: ['+datos8+'], series: ['+datos9+'] } );';
          eval(grafica1);
        }
        if (consulta == "6")
        {
          var datos = registros.datos;
          var datos1 = registros.datos1;
          var datos2 = registros.datos2;
          var datos3 = registros.datos3;
          var datos4 = registros.datos4;
          var datos6 = "";
          var datos7 = "";
          var datos8 = "";
          var datos9 = "";
          var var_ocu = datos1.split('#');
          var var_ocu1 = var_ocu[0].split(',');
          var var_ocu2 = var_ocu1.length;
          var var_ocu3 = datos3.split('#');
          for (var i=0; i<var_ocu2; i++)
          {
            var paso = var_ocu1[i];
            paso = paso.trim();
            datos6 += '"'+paso+'", ';
            var paso1 = var_ocu3[i];
            datos7 += paso1+'# ';
          }
          datos6 = datos6.substring(0, datos6.length - 2);
          datos7 = datos7.substring(0, datos7.length - 2);
          var var_ocu4 = datos6.split(',');
          var var_ocu5 = var_ocu4.length;
          var var_ocu6 = datos7.split('#');
          var var_ocu7 = datos4.split('#');
          for (var i=0; i<var_ocu5; i++)
          {
            datos8 += "\'#"+var_ocu7[i]+"\', ";
            datos9 += '{ name: '+var_ocu4[i]+', data: ['+var_ocu6[i].trim()+'] }, ';
          }
          datos8 = datos8.substring(0, datos8.length - 2);
          datos9 = datos9.substring(0, datos9.length - 2);
          if (periodo3 == periodo4)
          {
            var titulo = "Recursos Ejecutados "+periodo3+" de "+ano;
          }
          else
          {
            var titulo = "Recursos Ejecutados entre "+periodo3+' y '+periodo4+" de "+ano;
          }         
          var salida = "";
          salida += "<div id='grafica1' style='width: 100%; height: 600px; margin: 0 auto'></div>";
          $("#res_grafica").append(salida);
          var grafica1 = '$("#grafica1").highcharts({ chart: { type: "column" }, title: { text: "'+titulo+'" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, xAxis: { categories: [ '+datos+' ], crosshair: true }, yAxis: { min: 0, title: { text: "Totales" } }, tooltip: { headerFormat: "<span style=\'font-size:11px\'>{point.key}</span><table>", pointFormat: "<tr><td style=\'color: {series.color}; padding: 0\'>{series.name}: </td><td style=\'padding: 0\'>&nbsp;&nbsp;<b>$ {point.y}</b></td></tr>", footerFormat: "</table>", shared: true, useHTML: true }, credits: { enabled: false }, plotOptions: { series: { cursor: "pointer", point: { events: { click: function() { envio1(this.category,this.series.name); } } } }, column: { pointPadding: 0.2, borderWidth: 0, dataLabels: { enabled: true, formatter: function() { return "$ "+ Highcharts.numberFormat(this.y, 0); } } } }, colors: ['+datos8+'], series: ['+datos9+'] } );';
          eval(grafica1);
        }
        if (consulta == "7")
        {
          var datos = registros.datos;
          var fechas = registros.fechas;
          var salida = "";
          var salida1 = "";
          var xAxis = "categories: ["+fechas+"]";
          var series = datos;
          salida += "<br><div id='grafica1' style='width: 100%; height: 550px; margin: 0 auto'></div>";
          $("#res_grafica").append(salida);
          var grafica1 = '$("#grafica1").highcharts({ chart: { type: "line" }, title: { text: "Conexiones Diarias entre '+fecha1+' - '+fecha2+'" }, subtitle: { text: "CX COMPUTERS" }, xAxis: { '+xAxis+' }, yAxis: { title: { text: "Total Logueos" } }, '; 
          grafica1 += 'legend: { layout: "vertical", align: "right", verticalAlign: "top", x: -40, y: 80, floating: true, borderWidth: 1 }, ';
          grafica1 += 'credits: { enabled: false }, plotOptions: { series: { label: { connectorAllowed: false } } }, series: [ '+series+' ], responsive: { rules: [{ condition: { maxWidth: 500 }, chartOptions: { legend: { layout: "horizontal", align: "center", verticalAlign: "bottom" } } }] } });';
          eval(grafica1);
        }
        if (consulta == "8")
        {
          $("#resultados9").html('');
          if (periodo3 == periodo4)
          {
            var titulo = "Indicadores "+sigla+" "+periodo3+" de "+ano;
          }
          else
          {
            var titulo = "Indicadores "+sigla+" entre "+periodo3+' y '+periodo4+" de "+ano;
          }
          var salida = "";
          salida += "<br><div class='col col-lg-10 col-sm-10 col-md-10 col-xs-10'><center><h3>"+titulo+"</h3></center></div><div class='col col-lg-2 col-sm-2 col-md-2 col-xs-2'><center><a href='#' id='excel' onclick='excel(); return false;'><img src='dist/img/excel.png' title='Exportar Estad&iacute;stica a Excel - SAP'></a></center></div><br><br>";
          salida += "<table width='95%' align='center' border='1'><tr>";
          salida += "<td width='10%' height='35' bgcolor='#2E90BD'><center><b>Actividad</b></center></td>";
          salida += "<td width='30%' height='35' bgcolor='#2E90BD'><center><b>Nombre</b></center></td>";
          salida += "<td width='15%' height='35' bgcolor='#2E90BD'><center><b>Valor</b></center></td>";
          salida += "<td width='45%' height='35' bgcolor='#2E90BD'><center><b>Factores</b></center></td>";
          salida += "</tr></table>";
          salida += "<table width='95%' align='center' border='1' id='a-table1'>";
          var suma = registros.suma;
          var suma1 = registros.suma1;
          var datos = registros.datos;
          var var_ocu = datos.split('#');
          var var_ocu1 = var_ocu.length;
          for (var i=0; i<var_ocu1-1; i++)
          {
            var var1 = var_ocu[i];
            var var_ocu2 = var1.split("|");
            var var_ocu3 = var_ocu2.length;
            for (var j=0; j<var_ocu3-1; j++)
            {
              var var2 = var_ocu2[2];
              var var3 = var_ocu2[3];
              var var4 = var_ocu2[5];
              var var5 = var_ocu2[6];
            }
            salida += "<tr>";
            salida += "<td width='10%' height='35'>"+var2+"</td>";
            salida += "<td width='30%' height='35'>"+var3+"</td>";
            salida += "<td width='15%' height='35' align='right'>"+var4+"&nbsp;</td>";
            salida += "<td width='45%' height='35'>"+var5+"</td>";
            salida += "</tr>";
          }
          salida += "<tr><td width='10%' height='35'>&nbsp;</td><td width='30%' height='35'><b>Total:</b></td><td width='15%' height='35' align='right'><b>"+suma1+"</b>&nbsp;</td><td width='45%' height='35'>&nbsp;</td></tr>";
          salida += "</table>";
          $("#paso_excel").val(datos);
          $("#paso_excel1").val(suma);
          $("#resultados9").append(salida);
        }
        if (consulta == "9")
        {
          var datos = registros.datos;
          var var_ocu = datos.split('#');
          var var_ocu1 = var_ocu.length;
          var salida = "";
          var series = "";
          var series1 = "";
          var paso = "";
          var sum_total = 0;
          for (var i=0; i<var_ocu1-1; i++)
          {
            paso = var_ocu[i];
            var var_ocu2 = paso.split('|');
            var var_ocu3 = var_ocu2.length;
            for (var j=0; j<var_ocu3-1; j++)
            {
              var v1 = var_ocu2[0];           // Unidad
              var v2 = var_ocu2[1];           // Tipo
              var v3 = var_ocu2[2];           // Sigla
              var v4 = var_ocu2[3];           // Clase
              var v5 = var_ocu2[4];           // Total
              v5 = parseInt(v5);
            }
            sum_total = sum_total+v5;
          }
          var datos1 = registros.datos1;
          var var_ocu = datos1.split('#');
          var var_ocu1 = var_ocu.length;
          var paso = "";
          var sum_total1 = 0;
          for (var i=0; i<var_ocu1-1; i++)
          {
            paso = var_ocu[i];
            var var_ocu2 = paso.split('|');
            var var_ocu3 = var_ocu2.length;
            for (var j=0; j<var_ocu3-1; j++)
            {
              var v1 = var_ocu2[0];           // Sigla
              var v2 = var_ocu2[1];           // Tipo
              v2 = parseInt(v2);
            }
            sum_total1 = sum_total1+v2;
            series1 += '{ name: "'+v1+'", y: '+v2+', drilldown: "'+v1+'" }, ';
          }
          series1 = series1.substr(0, series1.length-2);
          var datos2 = registros.datos2;
          $("#paso").val(series1);
          $("#paso1").val(datos2);
          $("#paso2").val(sum_total1);
          var series = '{ name: "Parque Automotor", colorByPoint: true, data: [ '+series1+' ] }';
          salida += "<div id='grafica1' style='width: 100%; height: 600px; margin: 0 auto'></div>";
          $("#res_grafica").append(salida);
          var grafica1 = '$("#grafica1").highcharts({ chart: { type: "pie" }, title: { text: "Parque Automotor entre '+fecha1+' y '+fecha2+'" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, accessibility: { announceNewData: { enabled: true }, point: { valueSuffix: "%" } }, ';
          grafica1 += 'credits: { enabled: false }, plotOptions: { series: { dataLabels: { enabled: true, format: "{point.name}: {point.y}" }, showInLegend: true } }, tooltip: { headerFormat: "<span style=\'font-size:11px\'>{series.name}</span><br>", pointFormat: "<span style=\'color:{point.color}\'>{point.name}</span>: {point.y} de '+sum_total1+'<br/>" }, series: [ '+series+' ], drilldown: { series: [ '+datos2+' ] } });';
          eval(grafica1);
          $("#grafica").show();
          $("#grafica").val('1');
        }
      }
    });
  }
}
function envio(valor, valor1)
{
  var valor, valor1;
  var periodo1 = $("#periodo1").val();
  var periodo2 = $("#periodo2").val();
  var periodo3 = $("#periodo1 option:selected").html();
  var periodo4 = $("#periodo2 option:selected").html();
  periodo3 = periodo3.trim();
  periodo4 = periodo4.trim();
  var ano = $("#ano").val();
  ano = ano.trim();
  var url = "<a href='graficas.php?valor="+valor+"&valor1="+valor1+"&periodo1="+periodo1+"&periodo2="+periodo2+"&periodo3="+periodo3+"&periodo4="+periodo4+"&ano="+ano+"' name='link1' id='link1' class='pantalla-modal'>Link</a>";
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
function envio1(valor, valor1)
{
  var valor, valor1;
  var periodo1 = $("#periodo1").val();
  var periodo2 = $("#periodo2").val();
  var periodo3 = $("#periodo1 option:selected").html();
  var periodo4 = $("#periodo2 option:selected").html();
  periodo3 = periodo3.trim();
  periodo4 = periodo4.trim();
  var ano = $("#ano").val();
  ano = ano.trim();  
}
function cambia()
{
  $("#res_grafica").html('');
  var consulta = $("#consulta").val();
  var periodo1 = $("#periodo1 option:selected").html();
  var periodo2 = $("#periodo2 option:selected").html();
  var valores = $("#paso").val();
  var valores1 = $("#paso1").val();
  var valores2 = $("#paso2").val();
  var tipo = $("#grafica").val();
  var salida = "";
  var salida1 = "";
  switch (tipo)
  {
    case '1':
      consultar();
      break;
    case '2':
      if (consulta == "1")
      {
        var v1 = "Planes / Solicitudes";
        var v2 = "Estado Planes / Solicitudes";
      }
      else
      {
        var v1 = "Parque Automotor";
        var v2 = "Parque Automotor";
      }
      var series = '{ name: "'+v1+'", colorByPoint: true, data: [ '+valores+' ] }';
      salida += "<div id='grafica1' style='width: 100%; height: 600px; margin: 0 auto'></div>";
      $("#res_grafica").append(salida);
      var grafica1 = '$("#grafica1").highcharts({ chart: { type: "column" }, title: { text: "'+v2+' entre '+periodo1+' y '+periodo2+'" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, accessibility: { announceNewData: { enabled: true } }, xAxis: { type: "category" }, yAxis: { title: { text: "Total Planes / Solicitudes" } }, legend: { enabled: false }, credits: { enabled: false }, plotOptions: { series: { borderWidth: 0, dataLabels: { enabled: true, format: "{point.y}" } } }, tooltip: { headerFormat: "<span style=\'font-size:11px\'>{series.name}</span><br>", pointFormat: "<span style=\'color:{point.color}\'>{point.name}</span>: {point.y} de '+valores2+'<br/>" }, series: [ '+series+' ], drilldown: { series: [ ' + valores1 + ' ] } });';
      eval(grafica1);
      break;
    default:
      break;
  }
}
function formatNumber(valor)
{
  valor = String(valor).replace(/\D/g, "");
  return valor === '' ? valor : Number(valor).toLocaleString();
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
// 07/11/2023 - Estadistica de Planes / Solciitudes - Exportacion a excel
// 21/05/2024 - Ajuste cambio de centrtalizadora a ninguna
// 08/08/2024 - Ajuste por colunma con datos del plan centralizado
?>