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
  $ano = date('Y');
  $mes = date('m');
  $mes = intval($mes);
  // Nombre unidad usuario
  $query = "SELECT nombre FROM cv_unidades WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $query);
  $nombre = trim(utf8_encode(odbc_result($cur,1)));
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
<body style="overflow-x:hidden; overflow-y:hidden;">
<?php
include('titulo.php');
?>
<div>
  <section class="content-header">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="soportes">
          <h3>Reportes Transportes</h3>
          <div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Reporte</font></label>
                  <select name="tipo" id="tipo" class="form-control select2" onchange="trae_unidades(); trae_movi(); trae_tipo();" tabindex="1">
                    <option value="1">ANEXO T</option>
                    <option value="2">COMBUSTIBLE</option>
                    <option value="3">MANTENIMIENTO Y REPUESTOS</option>
                    <option value="5">LLANTAS</option>
                    <option value="4">RTM</option>
                    <option value="6">GESTI&Oacute;N PRESUPUESTO</option>
                    <!--
                    <option value="8">SOLICITUD DE COMBUSTIBLE</option>
                    -->
                  </select>
                </div>
                <div id="tipo1">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Periodo Inicial</font></label>
                    <select name="periodo1" id="periodo1" class="form-control select2" onchange="val_periodo(); trae_movi();" tabindex="2">
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
                    <select name="periodo2" id="periodo2" class="form-control select2" onchange="trae_movi();" tabindex="3">
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
                    <select name="ano" id="ano" class="form-control select2" onchange="trae_movi();" tabindex="4"></select>
                  </div>
                </div>
                <div id="tipo2">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha</font></label>
                    <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">&nbsp;</font></label>
                    <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Placa</font></label>
                  <select name="placa" id="placa" class="form-control select2"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Empadronamiento</font></label>
                  <select name="empadrona" id="empadrona" class="form-control select2" onchange="trae_movi();">
                    <option value='F'>CEDE2</option>
                    <option value='G'>CEDE4</option>
                    <option value='B'>CONTRATO</option>
                    <?php
                    if ($sup_usuario == "0")
                    {
                    }
                    else
                    {
                    ?>
                      <option value="M">MIXTO</option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <div id="tipo3">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Tipo Combustible</font></label>
                    <select name="combustible" id="combustible" class="form-control select2">
                      <option value="0">- SELECCIONAR -</option>
                      <option value="1">GASOLINA</option>
                      <option value="2">ACPM / DIESEL</option>
                    </select>
                  </div>
                </div>
                <div id="tipo4">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Unidad</font></label>
                    <select name="unidad" id="unidad" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas unidades"></select>
                  </div>
                </div>
                <div id="lbl2">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <label><font face="Verdana" size="2">Batall&oacute;n</font></label>
                    <br>
                    <input type="checkbox" name="agrupar" id="agrupar" class="chk1" value="0">
                  </div>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <center>
                    <input type="button" name="aceptar" id="aceptar" value="Consultar">
                  </center>
                </div>
              </div>
            </form>
            <form name="formu_excel" id="formu_excel" target="_blank" method="post">
              <input type="hidden" name="unidad_excel" id="unidad_excel" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly">
              <input type="hidden" name="dias_excel" id="dias_excel" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="galones_excel" id="galones_excel" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="tanqueo_excel" id="tanqueo_excel" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="promedio_excel" id="promedio_excel" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="combustible_excel" id="combustible_excel" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="mes_excel" id="mes_excel" class="form-control" value="" readonly="readonly">
              <input type="hidden" name="ano_excel" id="ano_excel" class="form-control" value="" readonly="readonly">
              <input type="hidden" name="ciu_excel" id="ciu_excel" class="form-control" value="<?php echo $ciu_usuario; ?>" readonly="readonly">
              <input type="hidden" name="uni_excel" id="uni_excel" class="form-control" value="<?php echo $nombre; ?>" readonly="readonly">
              <input type="hidden" name="veh_excel" id="veh_excel" class="form-control" value="" readonly="readonly">
              <input type="hidden" name="paso_excel_g1" id="paso_excel_g1" class="form-control" readonly="readonly">
              <input type="hidden" name="paso_excel_g2" id="paso_excel_g2" class="form-control" readonly="readonly">
              <input type="hidden" name="paso_excel_g3" id="paso_excel_g3" class="form-control" readonly="readonly">
              <input type="hidden" name="fecha1_excel" id="fecha1_excel" class="form-control" readonly="readonly">
              <input type="hidden" name="fecha2_excel" id="fecha2_excel" class="form-control" readonly="readonly">
            </form>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <input type="hidden" name="admin" id="admin" class="form-control" value="<?php echo $adm_usuario; ?>" readonly="readonly">
            <input type="hidden" name="compa" id="compa" class="form-control" value="<?php echo $tip_usuario; ?>" readonly="readonly">
            <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly">
            <input type="hidden" name="sigla" id="sigla" class="form-control" value="<?php echo $sig_usuario; ?>" readonly="readonly">
          </div>
        </div>
        <div id="dialogo"></div>
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
.chk1
{
  zoom: 1.5;
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
  $("#load").hide();
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
  $("#dialogo").dialog({
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
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(consultar);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  trae_ano();
  trae_movi();
  trae_unidades();
  $("#periodo1").val('<?php echo $mes; ?>');
  $("#periodo2").val('<?php echo $mes; ?>');
  $("#ano").val('<?php echo $ano; ?>');
  var admin = $("#admin").val();
  if (admin == "3")
  {
    $("#lbl2").show();
    $("#agrupar").prop("checked",true);
    $("#agrupar").prop("disabled",false);
  }
  else
  {
    $("#lbl2").hide();
    $("#agrupar").prop("checked",false);
    $("#agrupar").prop("disabled",true);
  }
  $("#placa").select2({
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
function trae_movi()
{
  var tipo = $("#tipo").val();
  var periodo1 = $("#periodo1").val();
  var periodo2 = $("#periodo2").val();
  var ano = $("#ano").val();
  var empadrona = $("#empadrona").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_movi.php",
    data:
    {
      tipo: tipo,
      periodo1: periodo1,
      periodo2: periodo2,
      ano: ano,
      empadrona: empadrona
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
      $("#placa").html('');
      var registros = JSON.parse(data);
      var placas = registros.placas;
      var placas1 = registros.placas1;
      if (placas == null)
      {
      }
      else
      {
        $("#placa").append(placas1);
      }
    }
  });
}
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
function trae_unidades()
{
  $("#unidad").html('');
  var tipo = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unid.php",
    data:
    {
      tipo: tipo
    },    
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var salida1 = "";
      var salida2 = "";
      if (tipo == "6")
      {
      }
      else
      {
        salida += "<option value='-'>- SELECCIONAR -</option>";
      }
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
        salida1 += codigo+",";
      }
      if (tipo == "6")
      {
        salida1 = salida1.substring(0,salida1.length-1);
        salida2 = "<option value='"+salida1+"'>- TODAS -</option>";
        salida2 += salida;
        salida = salida2;
      }
      $("#unidad").append(salida);
      trae_tipo();
    }
  });
}
function trae_tipo()
{
  var tipo = $("#tipo").val();
  var super1 = $("#super").val();
  if (tipo == "8")
  {
    $("#tipo1").hide();
    $("#tipo2").show();
    $("#tipo3").hide();
    $("#tipo4").show();
  }
  else
  {
    $("#tipo1").show();
    $("#tipo2").hide();
    $("#tipo3").show();
    if ((super1 == "1") || (super1 == "2"))
    {
      $("#tipo4").show();
    }
    else
    {
      if (tipo == "6")
      {
        $("#unidad").val("[]").trigger("change");
        var unidad = $("#unidad_excel").val();
        var paso = "["+unidad+"]";
        var final = '$("#unidad").val('+paso+').trigger("change");';
        eval(final);
        $("#tipo4").show();
        $("#unidad").prop("disabled",true);
      }
      else
      {
        $("#tipo4").hide();
      }
    }
    if (tipo == "1")
    {
      $("#empadrona>option[value='M']").removeAttr("disabled");
    }
    else
    {
      $("#empadrona>option[value='M']").attr("disabled","disabled");
    }
  }
}
function val_periodo()
{
  var periodo = $("#periodo1").val();
  $("#periodo2").val(periodo);
}
function consultar()
{
  $("#aceptar").hide();
  var salida = true;
  var tipo = $("#tipo").val();
  var periodo = $("#periodo1").val();
  periodo = parseInt(periodo);
  var periodo1 = $("#periodo1 option:selected").html();
  var periodo2 = $("#periodo2").val();
  periodo2 = parseInt(periodo2);
  var periodo3 = $("#periodo2 option:selected").html();
  var ano = $("#ano").val();
  var placa = $("#placa").select2('val');
  if (placa == null)
  {
    placa = "";
  }
  var empadrona = $("#empadrona").val();
  var combustible = $("#combustible").val();
  var agrupar = "0";
  if ($("#agrupar").is(":checked"))
  {
    agrupar = "1";
  }
  var fecha1 = $("#fecha1").val();
  var fecha2 = $("#fecha2").val();
  var unidad = $("#unidad").select2('val');
  if (unidad == null)
  {
    unidad = "999";
  }
  var super1 = $("#super").val();
  //if (tipo == "8")
  //{
  //  var url = "tran_consu3.php";
  //}
  //else
  //{
  var url = "tran_consu2.php";
  //}
  if ((tipo == "3") || (tipo == "4") || (tipo == "5"))
  {
    if (((placa == "")  || (placa == "-")) && (unidad == "999"))
    {
      salida = false;
      alerta("Debe seleccionar una placa o una unidad");
    }
  }
  else
  {
    if (tipo == "6")
    {
      if (unidad == "999")
      {
        salida = false;
        alerta("Debe seleccionar una unidad");
      }
    }
  }
  if (tipo == "1")
  {
	  if (periodo == periodo2)
		{
		}
		else
		{
			salida = false;
			alerta("Periodo final no válido");
		}
  }
  else
  {
	  if (periodo2 < periodo)
		{
			salida = false;
			alerta("Periodo final no válido");
		}
  }
  if (salida == false)
  {
    $("#aceptar").show();
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: url,
      data:
      {
        tipo: tipo,
        periodo1: periodo,
        periodo2: periodo2,
        ano: ano,
        placa: placa,
        empadrona: empadrona,
        combustible: combustible,
        agrupar: agrupar,
        fecha1: fecha1,
        fecha2: fecha2,
        unidad: unidad,
        super: super1
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
        $("#aceptar").show();
        var registros = JSON.parse(data);
        var contador = registros.contador;
				if (tipo == "1")
				{
					$("#dias_excel").val(registros.dias);
					$("#galones_excel").val(registros.galones);
					$("#tanqueo_excel").val(registros.tanqueo);
					$("#promedio_excel").val(registros.promedio);
					$("#combustible_excel").val(combustible);
					$("#mes_excel").val(periodo1);
					$("#ano_excel").val(ano);
					$("#paso_excel_g1").val(registros.ngasolina);
					$("#paso_excel_g2").val(registros.gasolina);
        }
				if (tipo == "2")
				{
					$("#dias_excel").val(empadrona);
					$("#combustible_excel").val(combustible);
					$("#mes_excel").val(periodo1);
					$("#ano_excel").val(ano);
					$("#paso_excel_g1").val(registros.ngasolina);
					$("#paso_excel_g2").val(registros.gasolina);
				}
				if ((tipo == "3") || (tipo == "4") || (tipo == "5"))
				{
					var sigla = $("#sig_usuario").val();
					$("#dias_excel").val(empadrona);
					$("#galones_excel").val(registros.rtm);
					$("#tanqueo_excel").val(registros.activo);
					$("#promedio_excel").val(registros.sigla);
					$("#uni_excel").val(registros.nombre);
					$("#combustible_excel").val(combustible);
					$("#mes_excel").val(periodo1);
					$("#ano_excel").val(ano);
					$("#veh_excel").val(registros.descripcion);
					$("#paso_excel_g1").val(registros.ngasolina);
					$("#paso_excel_g2").val(registros.gasolina);
				}
				if (tipo == "6")
				{
					$("#paso_excel_g2").val(registros.gasolina);
				}
				if (tipo == "8")
				{
					//var datos = registros.datos;
					//$("#paso_excel_g3").val(datos);
					//$("#fecha1_excel").val(fecha1);
					//$("#fecha2_excel").val(fecha2);       
				}
				if (contador == "0")
				{
					var detalle = "<center><h3>Sin Información para Generar Reporte</h3></center>";
					$("#dialogo").html(detalle);
					$("#dialogo").dialog("open");
					$("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
				}
				else
				{
					excel();
					alerta1("Reporte generado exitosamente...");
				}
			}
		});
	}
}
function excel()
{
  var tipo = $("#tipo").val();
  switch (tipo)
  {
    case '1':
      formu_excel.action = "trans_anexot_x.php";
      break;
    case '2':
      formu_excel.action = "trans_combus_x.php";
      break;
    case '3':
      formu_excel.action = "trans_mante_x.php";
      break;
    case '4':
      formu_excel.action = "trans_rtm_x.php";
      break;
    case '5':
      formu_excel.action = "trans_llantas_x.php";
      break;
    case '6':
      formu_excel.action = "trans_gestion_x.php";
      break;
    //case '8':
    //  formu_excel.action = "trans_consumo_x.php";
    //  break;
    default:
      formu_excel.action = "";
      break;
  }
  formu_excel.submit();
}
function check3(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9a-zA-Z]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
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
// 08/08/2023 - Ajuste nueva consulta de combustible registrado de transportes por rango de fecha - tipo=8
// 25/10/2023 - ajuste inclusion filtro por placa
// 20/11/2023 - Ajuste mantenimiento excel
// 27/11/2023 - Ajuste RTM excel
// 11/01/2023 - Ajuste excel contratos
// 16/01/2024 - Ajuste periodo inicial y final en consulta
// 19/02/2024 - Ajuste para individualizar consulta por empadronamiento
// 05/09/2024 - Ajuste placas manuales
// 12/06/2024 - Ajuste anexot para administrador con filtro de unidad
// 14/08/2024 - Ajuste anexot inclusion empadronamiento mixto
// 24/08/2024 - Ajuste descreicion vehiculos
// 05/12/2024 - Ajuste consulta administrador totales del dia en anexo t
// 18/02/2025 - Ajuste nuevo reporte - Gestion Presupuesto
?>