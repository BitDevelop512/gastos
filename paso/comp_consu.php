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
  $mes = date('m');
  $mes = intval($mes);
  $ano = date('Y');
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
<body style="overflow-x:hidden; overflow-y:hidden;">
<?php
include('titulo.php');
?>
<div>
  <section class="content-header">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="soportes">
          <h3>Consulta de Comprobantes</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo de Consulta</font></label>
                  <select name="tipo_c" id="tipo_c" class="form-control select2" tabindex="1">
                    <option value="1">COMPROBANTES INGRESO</option>
                    <option value="2">COMPROBANTES EGRESO</option>
                    <option value="3">DETALLADO COMPROBANTES EXCEL - SAP</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">&nbsp;</font></label>
                  <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                  <input type="hidden" name="paso1" id="paso1" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="paso2" id="paso2" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="paso3" id="paso3" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="paso4" id="paso4" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_mes" id="v_mes" class="form-control" value="<?php echo $mes; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_ano" id="v_ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="n_unidad" id="n_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly" tabindex="0">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Cuenta Bancaria</font></label>
                  <select name="cuenta" id="cuenta" class="form-control select2"></select>
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
            </form>
            <form name="formu1" action="ver_comp.php" method="post" target="_blank">
              <input type="hidden" name="comp_tipo" id="comp_tipo" readonly="readonly">
              <input type="hidden" name="comp_conse" id="comp_conse" readonly="readonly">
              <input type="hidden" name="comp_ano" id="comp_ano" readonly="readonly">
              <input type="hidden" name="comp_uni" id="comp_uni" readonly="readonly">
            </form>
            <form name="formu_excel" id="formu_excel" action="comprobantes_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
            </form>
          </div>
          <div id="dialogo"></div>
          <div id="dialogo1"></div>
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
  $("#load").hide();
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
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 230,
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
    buttons: {
      "Aceptar": function() {
        $(this).dialog("close");
        anul();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  trae_cuentas();
});
function trae_cuentas()
{
  $("#cuenta").html('');
  var unidad = $("#n_unidad").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cuentas1.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      if (unidad == "1")
      {
        salida += "<option value='0|0|0'>TODAS LAS CUENTAS</option>";
      }
      for (var i in registros) 
      {
          var codigo = registros[i].codigo;
          var nombre = registros[i].nombre;
          var cuenta = registros[i].cuenta;
          var saldo = registros[i].saldo;
          var saldo1 = registros[i].saldo1;
          var descripcion = nombre+" - "+cuenta;
          var valores = codigo+"|"+saldo+"|"+saldo1;
          salida += "<option value='"+valores+"'>"+descripcion+"</option>";
      }
      $("#cuenta").append(salida);
    }
  });
}
function pregunta()
{
  var comp = $("#paso1").val();
  var tipo = $("#paso2").val();
  var tipo1;
  if (tipo == "1")
  {
    tipo1 = "Ingreso";
  }
  else
  {
    tipo1 = "Egreso";
  }
  var detalle = "<center><h3>Esta seguro de anular el Comprobante de "+tipo1+" No. "+comp+" ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function consultar()
{
  var tipo = $("#tipo_c").val();
  var v_mes = $("#v_mes").val();
  var v_ano = $("#v_ano").val();
  v_mes = v_mes.trim();
  v_ano = v_ano.trim();
  var cuenta = $("#cuenta").val();
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  var salida = true, detalle = '';
  var super1 = $("#super").val();
  if (super1 == "1")
  {
    var fecha1 = $("#fecha1").val();
    if (fecha1 == "")
    {
      salida = false;
      detalle += "<center><h3>Debe seleccionar una fecha inicial</h3></center>";
    }
    var fecha2 = $("#fecha2").val();
    if (fecha2 == "")
    {
      salida = false;
      detalle += "<center><h3>Debe seleccionar una fecha final</h3></center>";
    }
  }
  if (tipo == "3")
  {
    if ($("#fecha1").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe seleccionar una fecha inicial</h3></center>";
    }
    else
    {
      var v_fecha1 = $("#fecha1").val();
      var v_fechas = v_fecha1.split('/');
      var v_dia1 = v_fechas[2];
      if (v_dia1 == "01")
      {
      }
      else
      {
        salida = false;
        detalle += "<center><h3>Fecha inicial no válida</h3></center>";
      }
    }
    if ($("#fecha2").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe seleccionar una fecha final</h3></center>";
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
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "comp_consu1.php",
      data:
      {
        tipo: $("#tipo_c").val(),
        fecha1: $("#fecha1").val(),
        fecha2: $("#fecha2").val(),
        cuenta: cuenta1
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
        var registros = JSON.parse(data);
        var valida,valida1;
        var salida1 = "";
        var salida2 = "";
        listareg = [];
        valida = registros.salida;
        valida1 = registros.total;
        if ((tipo == "1") || (tipo == "2"))
        {
          salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
          salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='10%'><b>No.</b></td><td height='35' width='10%'><b>Fecha</b></td><td height='35' width='10%'><b>Unidad</b></td><td height='35' width='10%'><b>Usuario</b></td><td height='35' width='10%'><b>Tipo</b></td><td height='35' width='15%'><center><b>Valor</b></center></td><td height='35' width='2%'><center>&nbsp;</center></td><td height='35' width='13%'><center><b>Cuenta</b></center></td><td height='35' width='10%'><center><b>Estado</b></center></td><td height='35' width='5%'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td></tr></table>";
          salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
          $.each(registros.rows, function (index, value)
          {
            var n_estado = "";
            if (value.estado == "A")
            {
              n_estado = "ANULADO";
            }
            if (tipo == "1")
            {
              salida2 += "<tr><td width='10%' height='35' id='l1_"+index+"'>"+value.ingreso+"</td>";
              salida2 += "<td width='10%' height='35' id='l2_"+index+"'>"+value.fecha+"</td>";
              salida2 += "<td width='10%' height='35' id='l3_"+index+"'>"+value.unidad+"</td>";
              salida2 += "<td width='10%' height='35' id='l4_"+index+"'>"+value.usuario+"</td>";
              salida2 += "<td width='10%' height='35' id='l5_"+index+"'>"+value.tipo+"</td>";
              salida2 += "<td width='15%' height='35' align='right' id='l6_"+index+"'>"+value.valor+"</td>";
              salida2 += "<td width='2%' height='35' id='l7_"+index+"'>&nbsp;</td>";
              salida2 += "<td width='13%' height='35' id='l8_"+index+"'>"+value.cuenta+"</td>";
              salida2 += "<td width='10%' height='35' align='right' id='l9_"+index+"'>"+n_estado+"</td>";
              if (value.estado == "A")
              {
                salida2 += "<td width='5%' height='35' id='l10_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
              }
              else
              {
                if ((value.periodo == v_mes) && (value.ano == v_ano))
                {
                  salida2 += "<td width='5%' height='35' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); paso("+value.ingreso+","+value.tipo2+","+value.ano+","+value.unidad+"); pregunta();'><img src='imagenes/anular.png' border='0' title='Anular Comprobante'></a></center></td>";
                }
                else
                {
                  salida2 += "<td width='5%' height='35' id='l10_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
                }
              }
              salida2 += "<td width='5%' height='35' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); link("+value.ingreso+","+value.tipo2+","+value.ano+","+value.unidad1+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td></tr>";
              listareg.push(index);
            }
            else
            {
              salida2 += "<tr><td width='10%' height='35' id='l1_"+index+"'>"+value.egreso+"</td>";
              salida2 += "<td width='10%' height='35' id='l2_"+index+"'>"+value.fecha+"</td>";
              salida2 += "<td width='10%' height='35' id='l3_"+index+"'>"+value.unidad+"</td>";
              salida2 += "<td width='10%' height='35' id='l4_"+index+"'>"+value.usuario+"</td>";
              salida2 += "<td width='10%' height='35' id='l5_"+index+"'>"+value.tipo+"</td>";
              salida2 += "<td width='15%' height='35' align='right' id='l6_"+index+"'>"+value.valor+"</td>";
              salida2 += "<td width='2%' height='35' id='l7_"+index+"'>&nbsp;</td>";
              salida2 += "<td width='13%' height='35' id='l8_"+index+"'>"+value.cuenta+"</td>";
              salida2 += "<td width='10%' height='35' id='l9_"+index+"'>"+n_estado+"</td>";
              if (value.estado == "A")
              {
                salida2 += "<td width='5%' height='35' id='l10_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
              }
              else
              {
                if ((value.periodo == v_mes) && (value.ano == v_ano))
                {
                  salida2 += "<td width='5%' height='35' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); paso("+value.egreso+","+value.tipo2+","+value.ano+","+value.unidad1+"); pregunta();'><img src='imagenes/anular.png' border='0' title='Anular Comprobante'></a></center></td>";
                }
                else
                {
                  salida2 += "<td width='5%' height='35' id='l10_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
                }
              }
              salida2 += "<td width='5%' height='35' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); link("+value.egreso+","+value.tipo2+","+value.ano+","+value.unidad1+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td></tr>";
              listareg.push(index);
            }
          });
          salida2 += "</table>";
          $("#tabla3").append(salida1);
          $("#resultados5").append(salida2);
        }
        if (tipo == "3")
        {
          $("#paso_excel").val(registros.valores);
          excel();
        }
      }
    });
  }
}
function paso(valor, tipo, ano, unidad)
{
  var valor, tipo, ano, unidad;
  $("#paso1").val(valor);
  $("#paso2").val(tipo);
  $("#paso3").val(ano);
  $("#paso4").val(unidad);
}
function anul()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "comp_anul.php",
    data:
    {
      interno: $("#paso1").val(),
      tipo: $("#paso2").val(),
      ano: $("#paso3").val(),
      unidad: $("#paso4").val(),
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
      if (valida == "A")
      {
        $("#consultar").click();
      }
    }
  });
}
function link(valor, tipo, ano, unidad)
{
  var valor, tipo, ano, unidad;
  $("#comp_tipo").val(tipo);
  $("#comp_conse").val(valor);
  $("#comp_ano").val(ano);
  $("#comp_uni").val(unidad);
  formu1.submit();
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
</script>
</body>
</html>
<?php
}
?>