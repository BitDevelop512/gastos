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
  $fecha = date('Y/m/d');
  $ano = date('Y');
  $mes = date('m');
  $mes1 = $mes;
  $mes1 = intval($mes1);
  $mes2 = $mes-1;
  $mes2 = intval($mes2);
  $tipo = $_GET['tipo'];
  if ($tipo == "1")
  {
    $tit_pan = "Informe de Gastos";
  }
  else
  {
    $tit_pan = "Relaci&oacute;n de Gastos";
  }
  $n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
  $n_periodo = $n_meses[$mes1-1];
  $n_periodo1 = $n_meses[$mes2-1];
  $periodos = "<option value='$mes2'>$n_periodo1</option><option value='$mes1'>$n_periodo</option>";
  // Se consulta unidad centralizadora
  $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur1 = odbc_exec($conexion, $query);
  $n_unidad = odbc_result($cur1,1);
  $n_unidad = intval($n_unidad);
  $n_dependencia = odbc_result($cur1,2);
  if ($n_unidad > 3)
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND unic='1'";
  }
  else
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' AND unic='1'";
  }
  $cur2 = odbc_exec($conexion, $query1);
  $unic = odbc_result($cur2,1);
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
          <h3><?php echo $tit_pan; ?></h3>
          <div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">ORDOP</font></label>
                  <select name="mision" id="mision" class="form-control select2" tabindex="1"></select>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Misi&oacute;n</font></label>
                  <select name="mision1" id="mision1" class="form-control select2" tabindex="2"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <br>
                  <input type="button" name="aceptar1" id="aceptar1" value="Validar">
                </div>
              </div>
              <br>
              <div id="datos">
                <div class="row">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Valor Total Aprobado de la Misi&oacute;n</font></label>
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Comprobante</font></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="valor" id="valor" class="form-control numero" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="compro" id="compro" class="form-control numero" value="0">
                    <input type="hidden" name="valor1" id="valor1" class="form-control" onfocus="blur();" readonly="readonly" tabindex="0">
                    <input type="hidden" name="valor2" id="valor2" class="form-control" onfocus="blur();" readonly="readonly" tabindex="0">
                    <input type="hidden" name="valor3" id="valor3" class="form-control" onfocus="blur();" readonly="readonly" tabindex="0">
                    <input type="hidden" name="centra" id="centra" class="form-control" value="<?php echo $unic; ?>" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso1" id="paso1" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso2" id="paso2" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso3" id="paso3" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso4" id="paso4" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso5" id="paso5" class="form-control" value="" readonly="readonly" tabindex="0">
                  </div>
                </div>
                <br>
                <div id="add_form">
                  <table width="100%" align="center" border="0">
                    <tr>
                      <td width="50%" height="35"><center><b>Concepto</b></center></td>
                      <td width="20%" height="35"><center><b>Valor</b></center></td>
                      <td width="20%" height="35"><center><b>Tipo</b></center></td>
                      <td width="10%">&nbsp;</td>
                    </tr>
                  </table>
                </div>
                <div id="add_form2">
                  <table align="center" width="100%" border="0">
                    <tr>
                      <td width="50%">&nbsp;</td>
                      <td width="20%">&nbsp;</td>
                      <td width="20%">&nbsp;</td>
                      <td width="10%">&nbsp;</td>
                    </tr>
                  </table>
                </div>
                <br>
                <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0"></a>&nbsp;
                <a href="#" name="add_field2" id="add_field2"><img src="imagenes/boton0.jpg" border="0"></a>
                <br><br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Gastos con Soportes</font></label>
                    <input type="text" name="t_sol1" id="t_sol1" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Gastos sin Facturas</font></label>
                    <input type="text" name="t_sol2" id="t_sol2" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Total Gastos</font></label>
                    <input type="text" name="t_sol" id="t_sol" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Total Reintegros</font></label>
                    <input type="text" name="t_sol3" id="t_sol3" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Lapso de la Misi&oacute;n</font></label>
                    <input type="text" name="lapso" id="lapso" class="form-control fecha" value="" onfocus="blur();" readonly="readonly">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7">
                    <label><font face="Verdana" size="2">Responsable</font></label>
                    <input type="text" name="responsable" id="responsable" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Periodo</font></label>
                    <select name="periodo" id="periodo" class="form-control select2"><?php echo $periodos; ?></select>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Nombre Comandante Unidad</font></label>
                    <input type="text" name="comandante" id="comandante" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                  </div>
                  <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                    <label><font face="Verdana" size="2">Cargo Comandante Unidad</font></label>
                    <input type="text" name="comandante1" id="comandante1" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Elaboro</font></label>
                    <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" autocomplete="off">
                  </div>
                </div>
                <br><br>
                <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo; ?>" readonly="readonly">
                <input type="hidden" name="n_ano" id="n_ano" value="<?php echo $ano; ?>" readonly="readonly">
                <input type="hidden" name="n_ordop" id="n_ordop" readonly="readonly">
                <input type="hidden" name="conceptos" id="conceptos" readonly="readonly">
                <input type="hidden" name="valores" id="valores" readonly="readonly">
                <input type="hidden" name="valores1" id="valores1" readonly="readonly">
                <input type="hidden" name="tipoc" id="tipoc" readonly="readonly">
                <input type="hidden" name="conceptos1" id="conceptos1" readonly="readonly">
                <input type="hidden" name="valores2" id="valores2" readonly="readonly">
                <input type="hidden" name="valores3" id="valores3" readonly="readonly">
                <input type="hidden" name="tipoc1" id="tipoc1" readonly="readonly">
                <input type="hidden" name="v_usuario" id="v_usuario" value="<?php echo $usu_usuario; ?>" readonly="readonly">
                <input type="hidden" name="v_unidad" id="v_unidad" value="<?php echo $uni_usuario; ?>" readonly="readonly">
                <input type="hidden" name="v_ciudad" id="v_ciudad" value="<?php echo $ciu_usuario; ?>" readonly="readonly">
                <input type="hidden" name="v_click" id="v_click" class="form-control" value="0" readonly="readonly" tabindex="0">
                <center>
                  <font face="Verdana" size="2" color="#ff0000"><b>Presione una sola vez el bot&oacute;n Continuar</b></font>
                  <br><br>
                  <input type="button" name="aceptar" id="aceptar" value="Continuar">
                  <input type="button" name="aceptar2" id="aceptar2" value="Visualizar">
                </center>
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
          </div>
          <div id="dialogo"></div>
          <div id="dialogo1"></div>
          <div id="dialogo2">
            <form name="formu1">
              <div id="add_form1">
                <table align="center" width="100%" border="0"></table>
              </div>
              <a href="#" name="add_field1" id="add_field1" onclick="agrega();"><img src="imagenes/boton1.jpg" border="0"></a>
              <input type="hidden" name="paso_bienes" id="paso_bienes" class="form-control" readonly="readonly">
              <br>
              <center>
                <input type="button" name="aceptar3" id="aceptar3" value="Continuar">
              </center>
            </form>
          </div>
          <div id="load">
            <center>
              <img src="imagenes/cargando.gif" alt="Cargando..." />
            </center>
          </div>
          <form name="formu3" action="ver_rela.php" method="post" target="_blank">
            <input type="hidden" name="plan_conse" id="plan_conse" readonly="readonly">
            <input type="hidden" name="plan_tipo" id="plan_tipo" readonly="readonly">
            <input type="hidden" name="plan_ano" id="plan_ano" readonly="readonly">
          </form>
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
      monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
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
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 260,
    width: 420,
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
          $( this ).dialog( "close" );
        }
      }
    ]
  });
  $("#dialogo1").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 240,
    width: 400,
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
        $( this ).dialog( "close" );
        paso();
      },
      "Cancelar": function() {
        $( this ).dialog( "close" );
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 600,
    width: 800,
    modal: true,
    closeOnEscape: false,
    show:
    {
      effect: "blind",
      duration: 1000
    },
    hide:
    {
      effect: "explode",
      duration: 1000
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  trae_mision();
  trae_pagos();
  trae_pagos1();
  trae_unidades();
  $("#aceptar1").button();
  $("#aceptar1").click(busca);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").button();
  $("#aceptar").click(pregunta1);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(link);
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").hide();
  $("#aceptar3").button();
  $("#aceptar3").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").click(valida_bienes);
  $("#compro").prop("disabled",true);
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });

  var MaxInputs       = 99;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    var paso1;
    paso1 = $("#paso1").val();
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      FieldCount++;
      $("#add_form table").append('<tr><div class="row"><td><div class="espacio1"></div></td></div></tr><tr><div class="row"><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><select name="gas_'+z+'" id="gas_'+z+'" class="form-control select2"></select></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><input type="text" name="vag_'+z+'" id="vag_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_val('+z+'); suma();" onblur="veri('+z+');"><input type="hidden" name="vat_'+z+'" id="vat_'+z+'" value="0"></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><select name="tip_'+z+'" id="tip_'+z+'" class="form-control select2" onchange="suma();"><option value="S">CON SOPORTE</option><option value="N">SIN FACTURA</option></select></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><div id="del_'+z+'"><a href="#" onclick="borra('+z+')"><img src="imagenes/boton2.jpg" border="0"></a></div></div></td></div></tr>');
      x_1++;
      $("#gas_"+z).append(paso1);
      $("#vag_"+z).maskMoney();
      $("#gas_"+z).focus();
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    if(x_1 > 1)
    {
      $(this).closest('tr').remove();
    }
    return false;
  });

  var InputsWrapper   = $("#add_form2 table tr");
  var AddButton       = $("#add_field2");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    var paso1;
    paso1 = $("#paso4").val();
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      FieldCount++;
      $("#add_form2 table").append('<tr><div class="row"><td><div class="espacio1"></div></td></div></tr><tr><div class="row"><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><select name="gas1_'+z+'" id="gas1_'+z+'" class="form-control select2"></select></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><input type="text" name="vag1_'+z+'" id="vag1_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_val3('+z+');suma3();"><input type="hidden" name="vat1_'+z+'" id="vat1_'+z+'" value="0"></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><select name="tip1_'+z+'" id="tip1_'+z+'" class="form-control select2" onchange="suma3();"><option value="S">CON SOPORTE</option><option value="N">SIN FACTURA</option></select></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><div id="del1_'+z+'"><a href="#" onclick="borra1('+z+')"><img src="imagenes/boton2.jpg" border="0"></a></div></div></td></div></tr>');
      x_1++;
      $("#gas1_"+z).append(paso1);
      $("#vag1_"+z).maskMoney();
      $("#gas1_"+z).focus();
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    if(x_1 > 1)
    {
      $(this).closest('tr').remove();
    }
    return false;
  });

  $("#datos").hide();
  $("#add_field1").hide();
  $("#mision").change(trae_mision1);
});
function trae_pagos()
{
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
      var salida = "";
      for (var i in registros) 
      {
          var codigo = registros[i].codigo;
          var nombre = registros[i].nombre;
          salida+="<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#paso1").val(salida);
    }
  });
}
function trae_pagos1()
{
  var tipo = "1";
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
      var salida = "";
      for (var i in registros) 
      {
          var codigo = registros[i].codigo;
          var nombre = registros[i].nombre;
          salida+="<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#paso4").val(salida);
    }
  });
}
function trae_unidades()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unid.php",
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
      $("#paso2").val(salida);
    }
  });
}
function pregunta1()
{
  var con_fac = $("#t_sol1").val();
  var sin_fac = $("#t_sol2").val();
  var detalle = "<br><center><font face='3' color='#3333ff'><b>TOTAL GASTOS CON SOPORTES: "+con_fac+"</b></font></center><br><center><font face='3' color='#ff0000'><b>TOTAL GASTOS SIN FACTURAS: "+sin_fac+"</b></font></center><br><center>Esta seguro de continuar ?</center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
}
function paso_valor()
{
  var valor;
  valor = $("#valor").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valor1").val(valor);
}
function paso_val(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('vag_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vat_"+valor).val(valor1);
}
function paso_val1(valor)
{
  var valor;
  var valor1 = document.getElementById('sev_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#set_"+valor).val(valor1);
}
function paso_val2(valor)
{
  var valor;
  var valor1 = document.getElementById('val_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vam_"+valor).val(valor1);
}
function paso_val3(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('vag1_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vat1_"+valor).val(valor1);
}
function valida1(valor)
{
  var valor;
  var valor1 = document.getElementById('val_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  var valor2 = document.getElementById('set_'+valor).value;
  var valor3 = valor1-valor2;
  if (valor3 < 0)
  {
    $("#sev_"+valor).val('0.00');
    paso_val1(valor);
  }
}
function valida2(valor)
{
  var valor;
  var valor1 = document.getElementById('val_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  var valor2 = document.getElementById('van_'+valor).value;
  var valor3 = valor1-valor2;
  if (valor3 > 0)
  {
    var valor4 = parseFloat(valor2)
    valor4 = valor4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $("#val_"+valor).val(valor4);
    paso_val2(valor);
  }
  var valor5 = $("#paso5").val();
  var var_ocu = valor5.split(',');
  if (valor == "0")
  {
    var valor6 = valor;
  }
  else
  {
    var valor6 = valor-10;
  }
  var valor7 = var_ocu[valor6];
  valor7 = parseInt(valor7);
  valor7 = valor7+1;
  var valor8 = $("#val_"+valor).val();
  $("#vag_"+valor7).val(valor8);
  paso_val(valor7);
  suma();
}
function suma()
{
  var valor;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('vat_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      valor2 = parseInt(valor2);
      valor3 = valor3+valor2;
    }
  }
  $("#valor2").val(valor3);
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_sol").val(valor3);
  suma1();
  suma2();
}
function suma1()
{
  var valor;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('vat_')!=-1)
    {
      saux1 = saux.substr(4);
      saux2 = $("#tip_"+saux1).val();
      if (saux2 == "S")
      {
        valor2 = document.getElementById(saux).value;
        valor2 = parseInt(valor2);
        valor3 = valor3+valor2;
      }
    }
  }
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_sol1").val(valor3);
}
function suma2()
{
  var valor;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('vat_')!=-1)
    {
      saux1 = saux.substr(4);
      saux2 = $("#tip_"+saux1).val();
      if (saux2 == "N")
      {
        valor2 = document.getElementById(saux).value;
        valor2 = parseInt(valor2);
        valor3 = valor3+valor2;
      }
    }
  }
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_sol2").val(valor3);
}
function suma3()
{
  var valor;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('vat1_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      valor2 = parseInt(valor2);
      valor3 = valor3+valor2;
    }
  }
  $("#valor3").val(valor3);
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_sol3").val(valor3);
}
function veri(valor)
{
  var valor, valor1, z;
  z = valor;
  valor1 = $("#gas_"+valor).val();
  switch (valor1)
  {
    case '1':
    case '2':
    case '5':
    case '6':
    case '7':
    case '8':
    case '10':
    case '18':
      $("#tip_"+z).val('S');
      break;
    case '3':
    case '4':
    case '9':
    case '11':
    case '12':
    case '17':
      $("#tip_"+z).val('N');
      break;
    case '13':
    case '14':
    case '15':
    case '16':
      $("#tip_"+z).val('N');
      break;
    default:
      $("#tip_"+z).val('N');
      break;
  }      
  suma();
}
function borra(valor)
{
  var valor;
  $("#gas_"+valor).val('0');
  $("#gas_"+valor).hide();
  $("#vag_"+valor).val('0');
  $("#vag_"+valor).hide();
  $("#vat_"+valor).val('0');
  $("#vat_"+valor).hide();
  $("#tip_"+valor).val('');
  $("#tip_"+valor).hide();
  $("#del_"+valor).hide();
  suma();
}
function borra1(valor)
{
  var valor;
  $("#gas1_"+valor).val('0');
  $("#gas1_"+valor).hide();
  $("#vag1_"+valor).val('0');
  $("#vag1_"+valor).hide();
  $("#vat1_"+valor).val('0');
  $("#vat1_"+valor).hide();
  $("#tip1_"+valor).val('');
  $("#tip1_"+valor).hide();
  $("#del1_"+valor).hide();
  suma3();
}
function paso()
{
  var paso = $("#mision option:selected").html();
  $("#n_ordop").val(paso);
  document.getElementById('conceptos').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('gas_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('conceptos').value=document.getElementById('conceptos').value+valor+"|";
    }
  }
  document.getElementById('valores').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vag_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('valores').value=document.getElementById('valores').value+valor+"|";
    }
  }
  document.getElementById('valores1').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vat_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('valores1').value=document.getElementById('valores1').value+valor+"|";
    }
  }
  document.getElementById('tipoc').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('tip_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('tipoc').value=document.getElementById('tipoc').value+valor+"|";
    }
  }
  // Reintegros
  document.getElementById('conceptos1').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('gas1_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('conceptos1').value=document.getElementById('conceptos1').value+valor+"|";
    }
  }
  document.getElementById('valores2').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vag1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('valores2').value=document.getElementById('valores2').value+valor+"|";
    }
  }
  document.getElementById('valores3').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vat1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('valores3').value=document.getElementById('valores3').value+valor+"|";
    }
  }
  document.getElementById('tipoc1').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('tip1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('tipoc1').value=document.getElementById('tipoc1').value+valor+"|";
    }
  }
  validacionData();
}
function validacionData()
{
  var salida = true, detalle = '';
  var comprueba1 = $("#v_usuario").val().trim().length;
  if (comprueba1 == '0')
  {
    salida = false;
    detalle += "<center>Usuario No Valido</center><br>";
  }
  var comprueba2 = $("#v_unidad").val().trim().length;
  var comprueba3 = $("#v_unidad").val();
  if ((comprueba2 == '0') || (comprueba3 == '0'))
  {
    salida = false;
    detalle += "<center>Unidad No Valida</center><br>";
  }
  var comprueba4 = $("#v_ciudad").val().trim().length;
  if (comprueba4 == '0')
  {
    salida = false;
    detalle += "<center>Ciudad No Valida</center><br>";
  }
  if ($("#t_sol").val() == '0.00')
  {
    salida = false;
    detalle += "<center>Total de Gastos No Valido</center><br>";
  }
  // Se validan valor mision y total de gastos
  var valida = $("#valor1").val();
  valida = parseInt(valida);
  var valida1 = $("#valor2").val();
  valida1 = parseInt(valida1);
  if (valida1 > valida)
  {
    salida = false;
    detalle += "<center>Total Gastos superior al Valor Aprobado de la Misión</center><br>";
  }
  if (valida > valida1)
  {
    salida = false;
    detalle += "<center>Valor Aprobado de la Misión superior a Total Gastos</center><br>";
  }
  if ($("#responsable").val() == '')
  {
    salida = false;
    detalle += "<center>Debe ingresar un Responsable</center><br>";
  }
  if ($("#comandante").val() == '')
  {
    salida = false;
    detalle += "<center>Debe ingresar el Nombre del Comandante</center><br>";
  }
  if ($("#comandante1").val() == '')
  {
    salida = false;
    detalle += "<center>Debe ingresar el Cargo del Comandante</center><br>";
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
    var detalle = "<br><h2><center>Botón Continuar ya Presionado</center></h2>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
  }
  else
  {
    $("#v_click").val('1');
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "rgas_grab.php",
      data:
      {
        n_ordop: $("#n_ordop").val(), 
        mision: $("#mision").val(),
        mision1: $("#mision1").val(),
        mision2: $("#mision1 option:selected").html(),
        responsable: $("#responsable").val(),
        comandante: $("#comandante").val(),
        comandante1: $("#comandante1").val(),
        tipo: $("#tipo").val(),
        comprobante: $("#compro").val(),
        conceptos: $("#conceptos").val(),
        valores: $("#valores").val(),
        valores1: $("#valores1").val(),
        tipoc: $("#tipoc").val(),
        conceptos1: $("#conceptos1").val(),
        valores2: $("#valores2").val(),
        valores3: $("#valores3").val(),
        tipoc1: $("#tipoc1").val(),
        t_sol: $("#t_sol").val(),
        t_sol1: $("#t_sol1").val(),
        t_sol2: $("#t_sol2").val(),
        t_sol3: $("#t_sol3").val(),
        centra: $("#centra").val(),
        periodo: $("#periodo").val(),
        bienes: $("#paso_bienes").val(),
        elaboro: $("#elaboro").val(),
        usuario: $("#v_usuario").val(),
        unidad: $("#v_unidad").val(),
        ciudad: $("#v_ciudad").val()
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
        var valida;
        valida = registros.salida;
        valida1 = registros.salida1;
        if (valida > 0)
        {
          $("#aceptar").hide();
          $("#aceptar2").show();
          $("#plan_conse").val(valida);
          $("#plan_ano").val(valida1);
          $("#compro").prop("disabled",true);
          $("#responsable").prop("disabled",true);
          $("#comandante").prop("disabled",true);
          $("#comandante1").prop("disabled",true);
          $("#periodo").prop("disabled",true);
          $("#elaboro").prop("disabled",true);
          for (i=0;i<document.formu.elements.length;i++)
          {
            saux=document.formu.elements[i].name;
            if (saux.indexOf('gas_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            if (saux.indexOf('vag_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            if (saux.indexOf('tip_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
          for (j=1;j<=30;j++)
          {
            $("#del_"+j).hide();
          }
          $("#add_field").hide();
        }
        else
        {
          detalle = "<br><h2><center>Error durante la grabación</center></h2>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
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
    url: "trae_mision.php",
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
        $("#aceptar1").hide();
      }
      else
      {
        $("#mision").append(salida);
        $("#aceptar1").show();
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
    url: "trae_mision2.php",
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
        var validaciones = "";
        var salida = "";
        var compara;
        for (var i in registros) 
        {
        	mision = registros[i].misiones;
        	conse = registros[i].conse;
        	internos = registros[i].internos;
        	validaciones = registros[i].validaciones+",";
        	var var_ocu = mision.split('|');
        	var var_ocu1 = var_ocu.length;
        	var var_ocu2 = internos.split(',');
        	var var_ocu3 = validaciones.split(',');
        	for (var i=0; i<var_ocu1-1; i++)
        	{
        		compara = var_ocu3[i];
            	if (compara == "0")
            	{
              		salida+="<option value='"+conse+"'>"+var_ocu[i]+" - "+conse+" - "+var_ocu2[i]+"</option>";
            	}
          	}
        }        
        $("#mision1").append(salida);
      }
    });
}
function busca()
{
  var valor, valor1;
  valor = $("#mision").val();
  valor1 = $("#mision1").val();
  valor2 = $("#mision1 option:selected").html();
  valor3 = $("#mision option:selected").html();
  ano = $("#n_ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_relacion_a.php",
    data:
    {
      valor: valor,
      valor1: valor1,
      valor2: valor2,
      valor3: valor3,
      ano: ano
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      var tipo = registros.tipo;
      if (salida == "1")
      {
        detalle = "Informe / Relaci&oacute;n ya Registrada";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
      }
      else
      {
        traer();
      }
    }
  });
}
function traer()
{
  var valor, valor1;
  valor = $("#mision").val();
  valor1 = $("#mision1").val(); 
  valor2 = $("#mision1 option:selected").html();
  valor3 = $("#mision option:selected").html();
  valor4 = $("#centra").val();
  ano = $("#n_ano").val();
  $("#t_bienes").html('');
  var valida = 0;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_mision1_a.php",
    data:
    {
      valor: valor,
      valor1: valor1,
      valor2: valor2,
      valor3: valor3,
      valor4: valor4,
      ano: ano
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      var total;
      $("#compro").val(registros.egreso);
      if (registros.egreso == "0")
      {
        $("#compro").prop("disabled",false);
      }
      else
      {
        $("#compro").prop("disabled",true);
      }
      total = parseInt(registros.total);
      total = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      if (registros.valor == "")
      {
        $("#valor").val("0.00");
      }
      else
      {
        $("#valor").val(registros.valor);
      }
      paso_valor();
      var responsable = registros.responsable;
      $("#responsable").val(responsable);
      var lapso = registros.lapso;
      $("#lapso").val(lapso);
      var lapso1 = registros.lapso1;
      $("#periodo").val(lapso1);
      $("#datos").show();
      $("#mision").prop("disabled",true);
      $("#mision1").prop("disabled",true);
      $("#aceptar1").hide();
      var var_ocu = salida.split('«');
      var var_ocu1 = var_ocu.length;
      var z = 0;
      var y = 0;
      for (var i=0; i<var_ocu1-1; i++)
      {
        $("#add_field").click();
        var var_0 = $("#paso5").val();
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("|");
        z = z+1;
        var p1 = var_2[0];
        var p2 = var_2[1];
        var p3 = var_2[2];
        var p4 = p3.length;
        if (p4 > 0)
        {
          $("#paso3").val(i);
          var_0 += i+",";
          $("#paso5").val(var_0);
          $("#vag_"+z).prop("disabled",true);
          $("#tip_"+z).prop("disabled",true);
          var var_3 = p3.split("#");
          var var_4 = var_3[0];
          var var_5 = var_4.split("&");
          var var_6 = var_5.length-1;
          var var_7 = var_3[1];
          var var_8 = var_7.split("&");
          var var_9 = var_3[2];
          var var_10 = var_9.split("&");
          var var_11 = var_3[3];
          var var_12 = var_11.split("&");
          for (var j=0; j<var_6; j++)
          {
            agrega();
            var x1 = var_5[j];
            var x2 = var_8[j];
            var x3 = var_10[j];
            v3 = x3.trim();
            x3 = parseFloat(x3);
            x3 = x3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            var x4 = var_12[j];
            var x5 = $("#mision option:selected").html();
            var x5_1 = x5.indexOf("«")>-1
            if (x5_1 == false)
            {
            }
            else
            {
              x5 = x5.split("«");
              x5 = x5[1];
            }
            x5 = x5.trim();
            var x6 = $("#mision1 option:selected").html();
            var x7 = x6.split("-");
            var x8 = x7[0];
            x8 = x8.trim();
            var x9 = x7[1];
            x9 = x9.trim();
            $("#cla_"+y).val(x1);
            $("#nom_"+y).val(x2);
            $("#val_"+y).val(x3);
            paso_val2(y);
            $("#des_"+y).val(x4);
            $("#ord_"+y).val(x5);
            $("#mis_"+y).val(x8);
            $("#pla_"+y).val(x9);
            var x10 = $("#vam_"+y).val();
            var x11 = $("#valor").val();
            var x12 = parseFloat(x11.replace(/,/g,''));
            $("#van_"+y).val(x12);
            y++;
            y = y+10;
          }
          $("#dialogo2").dialog("open");
          $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("html,body").animate({ scrollTop: 1 }, "slow");
        }
        $("#gas_"+z).val(p1);
        $("#vag_"+z).val(p2);
        $("#del_"+z).hide();
        $("#gas_"+z).prop("disabled",true);
        if (p1 == "1")
        {
          $("#vag_"+z).val(total);
          $("#vag_"+z).prop("disabled",true);
          $("#tip_"+z).prop("disabled",true);
        }
        else
        {
          switch (p1)
          {
            case '2':
            case '5':
            case '6':
            case '7':
            case '8':
            case '10':
            case '18':
              $("#tip_"+z).val('S');
              break;
            case '3':
            case '4':
            case '9':
            case '11':
            case '12':
            case '17':
              $("#tip_"+z).val('N');
              break;
            case '13':
            case '14':
            case '15':
            case '16':
              $("#tip_"+z).val('N');
              break;
            default:
              $("#tip_"+z).val('N');
              break;
          }
        }
        paso_val(z);
        suma();
      }
      paso_val(1);
      suma();
      var vali_valor = $("#valor1").val();
      if (vali_valor == "NaN")
      {
        $("#aceptar").hide();
        var detalle = "No se encontro el Valor Aprobado de la Misión<br><br>El Informe de Autorizaci&oacute;n no ha sido generado<br><br>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#valor").val('0.00');
      }
      else
      {
        $("#aceptar").show(); 
      }
    }
  });
}
function link()
{
  var valor, valor1, valor2;
  valor = $("#plan_conse").val();
  valor1 = $("#tipo").val();
  valor2 = $("#n_ano").val();
  $("#plan_conse").val(valor);
  $("#plan_tipo").val(valor1);
  $("#plan_ano").val(valor2);
  formu3.submit();
}
function link1(valor, tipo, ano)
{
  var valor;
  var tipo;
  var ano;
  $("#plan_conse").val(valor);
  $("#plan_tipo").val(tipo);
  $("#plan_ano").val(ano);
  formu3.submit();
}
function consultar()
{
  var tipo1 = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "rela_consu.php",
    data:
    {
      tipo: $("#tipo").val(),
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
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      listaplanes = [];
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
      salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='10%'><b>No.</b></td><td height='35' width='15%'><b>Fecha</b></td><td height='35' width='15%'><b>Unidad</b></td><td height='35' width='15%'><b>Usuario</b></td><td height='35' width='18%'><b>Ordop</b></td><td height='35' width='17%'><b>Misi&oacute;n</b></td><td height='35' width='10%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        salida2 += "<tr><td height='35' width='10%'>"+value.conse+"</td>";
        salida2 += "<td height='35' width='15%'>"+value.fecha+"</td>";
        salida2 += "<td height='35' width='15%'>"+value.unidad+"</td>";
        salida2 += "<td height='35' width='15%'>"+value.usuario+"</td>";
        salida2 += "<td height='35' width='18%'>"+value.ordop+"</td>";
        salida2 += "<td height='35' width='17%'>"+value.mision+"</td>";
        salida2 += "<td height='35' width='10%'><center><a href='#' onclick='link1("+value.conse+","+tipo1+","+value.ano+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td>";
        listaplanes.push(value.conse);
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados5").append(salida2);
    }
  });
}
function agrega()
{
  var InputsWrapper = $("#add_form1 table tr");
  var x = InputsWrapper.length;
  var FieldCount = 1;
  if(x <= 99)
  {
    var y = x;
    var paso1 = $("#paso2").val();
    var paso2 = $("#v_unidad").val();
    FieldCount++;
    $("#add_form1 table").append('<tr><td colspan="5" class="espacio1"><center><font face="Verdana" size="3"><b>Datos del Bien</b></font></center></td></tr><td colspan="5" class="espacio1"><label><font face="Verdana" size="2">Nombre del Bien</font></label><input type="hidden" name="cla_'+y+'" id="cla_'+y+'" class="form-control numero" readonly="readonly"><input type="text" name="nom_'+y+'" id="nom_'+y+'" class="form-control" maxlength="50" readonly="readonly"></td></tr><tr><td colspan="5" class="espacio1"><label><font face="Verdana" size="2">Descripci&oacute;n</font></label><textarea name="des_'+y+'" id="des_'+y+'" class="form-control" rows="3" onblur="val_caracteres('+y+'); javascript:this.value=this.value.toUpperCase();"></textarea></td></tr><tr><td width="32%" class="espacio1"><label><font face="Verdana" size="2">Fecha de Compra</font></label><input type="text" name="fec_'+y+'" id="fec_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Valor</font></label><input type="text" name="val_'+y+'" id="val_'+y+'" class="form-control numero" onkeyup="paso_val2('+y+'); valida2('+y+')"><input type="hidden" name="vam_'+y+'" id="vam_'+y+'" class="form-control numero" value="0"><input type="hidden" name="van_'+y+'" id="van_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="34%"><label><font face="Verdana" size="2">Marca</font></label><input type="text" name="mar_'+y+'" id="mar_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td></tr><tr><td width="32%" class="espacio1"><label><font face="Verdana" size="2">Color</font></label><input type="text" name="col_'+y+'" id="col_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Modelo</font></label><input type="text" name="mod_'+y+'" id="mod_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="34%"><label><font face="Verdana" size="2">Serial</font></label><input type="text" name="ser_'+y+'" id="ser_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td></tr><tr><td width="32%" class="espacio1"><label><font face="Verdana" size="2">No. SOAT</font></label><input type="text" name="son_'+y+'" id="son_'+y+'" class="form-control" maxlength="25" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Aseguradora</font></label><input type="text" name="soa_'+y+'" id="soa_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="34%"><label><font face="Verdana" size="2">Vigencia</font></label><input type="text" name="so1_'+y+'" id="so1_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"><div class="espacio1"></div><input type="text" name="so2_'+y+'" id="so2_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td></tr><tr><td width="32%" class="espacio1"><label><font face="Verdana" size="2">Clase de Seguro</font></label><input type="text" name="sec_'+y+'" id="sec_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Valor Seguro</font></label><input type="text" name="sev_'+y+'" id="sev_'+y+'" class="form-control numero" value="0.00" onkeyup="paso_val1('+y+'); valida1('+y+');"><input type="hidden" name="set_'+y+'" id="set_'+y+'" class="form-control numero" value="0"></td></tr><tr><td width="32%" class="espacio1"><label><font face="Verdana" size="2">No. Seguro</font></label><input type="text" name="sen_'+y+'" id="sen_'+y+'" class="form-control" maxlength="25" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Aseguradora</font></label><input type="text" name="sea_'+y+'" id="sea_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="34%"><label><font face="Verdana" size="2">Vigencia</font></label><input type="text" name="se1_'+y+'" id="se1_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"><div class="espacio1"></div><input type="text" name="se2_'+y+'" id="se2_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td></tr><tr><td colspan="1" class="espacio1"><label><font face="Verdana" size="2">Ubicaci&oacute;n del Bien</font></label><select name="ubi_'+y+'" id="ubi_'+y+'" class="form-control select2" readonly="readonly"></select></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Funcionario realiz&oacute; la compra</font></label><input type="text" name="fun_'+y+'" id="fun_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="34%"><label><font face="Verdana" size="2">Estado del Bien</font></label><select name="est_'+y+'" id="est_'+y+'" class="form-control select2"><option value="1">BUENO</option><option value="2">REGULAR</option><option value="3">DAÑADO</option><option value="4">CONSUMIDO</option><option value="9">PERDIDO</option></select></td></tr><tr><td colspan="1" class="espacio1"><label><font face="Verdana" size="2">ORDOP</font></label><input type="text" name="ord_'+y+'" id="ord_'+y+'" class="form-control" maxlength="50" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Misi&oacute;n</font></label><input type="text" name="mis_'+y+'" id="mis_'+y+'" class="form-control" maxlength="50" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="34%"><label><font face="Verdana" size="2">Plan / Solicitud</font></label><input type="text" name="pla_'+y+'" id="pla_'+y+'" class="form-control" readonly="readonly"></tr><tr><td colspan="5"><hr></td></tr>');
    x++;
    $("#fec_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      maxDate: 0,
      changeYear: true,
      changeMonth: true
    });
    $("#so1_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      changeYear: true,
      changeMonth: true,
      onSelect: function () {
        $("#so2_"+y).prop("disabled",false);
        $("#so2_"+y).datepicker("destroy");
        $("#so2_"+y).val('');
        $("#so2_"+y).datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#so1_"+y).val(),
          changeYear: true,
          changeMonth: true
        });
      },
    });
    $("#se1_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      changeYear: true,
      changeMonth: true,
      onSelect: function () {
        $("#se2_"+y).prop("disabled",false);
        $("#se2_"+y).datepicker("destroy");
        $("#se2_"+y).val('');
        $("#se2_"+y).datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#se1_"+y).val(),
          changeYear: true,
          changeMonth: true
        });
      },
    });
    $("#val_"+y).maskMoney();
    $("#sev_"+y).maskMoney();
    $("#ubi_"+y).append(paso1);
    $("#ubi_"+y).val(paso2);
    $("#nom_"+y).focus();
  }
}
function valida_bienes()
{
  var datos = "";
  var datos1 = "";
  var datos2 = "";
  var datos3 = "";
  var datos4 = "";
  var datos5 = "";
  var datos6 = "";
  var datos7 = "";
  var datos8 = "";
  var datos9 = "";
  var datos10 = "";
  var datos11 = "";
  var datos12 = "";
  var datos13 = "";
  var datos14 = "";
  var datos15 = "";
  var datos16 = "";
  var datos17 = "";
  var datos18 = "";
  var datos19 = "";
  var datos20 = "";
  var datos21 = "";
  var datos22 = "";
  var datos23 = "";
  var datos24 = "";
  var datos25 = "";
  var datos26 = "";
  $("#paso_bienes").val('');
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('cla_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "")
      {
      }
      else
      {
        datos = datos+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos1 = datos1+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('des_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos2 = datos2+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('fec_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos3 = datos3+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('val_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos4 = datos4+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('mar_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos5 = datos5+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('col_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos6 = datos6+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('mod_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos7 = datos7+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('ser_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos8 = datos8+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('son_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos9 = datos9+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('soa_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos10 = datos10+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('so1_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos11 = datos11+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('so2_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos12 = datos12+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('sec_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos13 = datos13+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('sev_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos14 = datos14+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('set_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos15 = datos15+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('sen_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos16 = datos16+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('sea_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos17 = datos17+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('se1_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos18 = datos18+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('se2_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos19 = datos19+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('ubi_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos20 = datos20+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('fun_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos21 = datos21+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('ord_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos22 = datos22+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('mis_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos23 = datos23+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('pla_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos24 = datos24+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('est_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos25 = datos25+valor2+"&";
      }
    }
  }
  var suma_bienes = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('vam_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      valor2 = parseFloat(valor2);
      suma_bienes = suma_bienes+valor2;
    }
  }
  var suma_bienes1 = parseFloat(suma_bienes)
  suma_bienes1 = suma_bienes1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  var final = datos+"#"+datos1+"#"+datos2+"#"+datos3+"#"+datos4+"#"+datos5+"#"+datos6+"#"+datos7+"#"+datos8+"#"+datos9+"#"+datos10+"#"+datos11+"#"+datos12+"#"+datos13+"#"+datos14+"#"+datos15+"#"+datos16+"#"+datos17+"#"+datos18+"#"+datos19+"#"+datos20+"#"+datos21+"#"+datos22+"#"+datos23+"#"+datos24+"#"+datos25;
  $("#paso_bienes").val(final);
  $("#dialogo2").dialog( "close" );
}
function val_caracteres(valor)
{
  var valor;
  var detalle = $("#des_"+valor).val();
  detalle = detalle.replace(/[#]+/g, "No.");
  detalle = detalle.replace(/[•]+/g, "*");
  detalle = detalle.replace(/[●]+/g, "*");
  detalle = detalle.replace(/[é́]+/g, "é");
  detalle = detalle.replace(/[]+/g, "*");
  detalle = detalle.replace(/[]+/g, "*");
  detalle = detalle.replace(/[]+/g, "*");
  detalle = detalle.replace(/[ ]+/g, " ");
  detalle = detalle.replace(/[ ]+/g, '');
  detalle = detalle.replace(/[–]+/g, "-");
  detalle = detalle.replace(/[—]+/g, '-');
  detalle = detalle.replace(/[…]+/g, "..."); 
  detalle = detalle.replace(/[“”]+/g, '"');
  detalle = detalle.replace(/[‘]+/g, '´');
  detalle = detalle.replace(/[’]+/g, '´');
  detalle = detalle.replace(/[′]+/g, '´');
  $("#des_"+valor).val(detalle);
}
</script>
</body>
</html>
<?php
}
?>