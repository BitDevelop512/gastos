<!doctype html>
<?php
session_start();
error_reporting(0);
$_SESSION["chat"] = "NO";
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
  if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$dun_usuario' AND unic='0' ORDER BY subdependencia";
  }
  else
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND unic!='1' ORDER BY subdependencia"; 
  }
  $cur1 = odbc_exec($conexion, $query1);
  $numero = "";
  while($i<$row=odbc_fetch_array($cur1))
  {
    $numero .= "'".odbc_result($cur1,1)."',";
  }
  $numero = substr($numero,0,-1);
  $numero = trim($numero);
	$consu = "SELECT conse, ano, cedulas, unidad FROM cx_reg_rec WHERE estado='H' AND unidad IN ($numero) ORDER BY conse";
  $cur = odbc_exec($conexion, $consu);
  $total = odbc_num_rows($cur);
  if ($total > 0)
  {
    $numero1 = "- SELECCIONAR -,";
    while($i<$row=odbc_fetch_array($cur))
    {
      $v1 = odbc_result($cur,1);
      $v2 = odbc_result($cur,2);
      $v3 = trim($row["cedulas"]);
      $v4 = explode("|",$v3);
      $v5 = count($v4)-1;
      $v6 = odbc_result($cur,4);
      $consu1 = "SELECT cedulas FROM cx_act_rec WHERE registro='$v1' AND ano1='$v2' AND estado='' AND unidad='$v6' ORDER BY conse";
      $cur1 = odbc_exec($conexion, $consu1);
      $total1 = odbc_num_rows($cur1);
      $total2 = 0;
      if ($total1 > 0)
      {
        while($j<$row=odbc_fetch_array($cur1))
        {
          $p1 = trim(utf8_encode($row["cedulas"]));
          $num_p1 = explode(",",$p1);
          $con_p1 = count($num_p1);
          $total2 = $total2+$con_p1;
        }
      }
      if ($total2 >= $v5)
      {
      }
      else
      {
        $consu2 = "SELECT conse FROM cx_val_aut2 WHERE solicitud='$v1' AND ano1='$v2' AND estado='I'";
        $cur2 = odbc_exec($conexion, $consu2);
        $total3 = odbc_num_rows($cur2);
        if ($total3 > 0)
        {
          $numero1 .= odbc_result($cur,1)." - ".odbc_result($cur,2)." - 0,";
        }
      }
    }
  }
  else
  {
    $numero1 = $total;
  }
  $consu1 = "SELECT conse, ano, cedulas FROM cx_rec_man WHERE informantes>0 AND acta=0 AND unidad IN ($numero) ORDER BY conse";
  $cur1 = odbc_exec($conexion, $consu1);
  $total1 = odbc_num_rows($cur1);
  if ($total1 > 0)
  {
    while($i<$row=odbc_fetch_array($cur1))
    {
      $numero1 .= odbc_result($cur1,1)." - ".odbc_result($cur1,2)." - 1,";
    }
  }
  $query = "SELECT unidad, dependencia, unic FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur1 = odbc_exec($conexion, $query);
  $n_unidad = odbc_result($cur1,1);
  $n_unidad = intval($n_unidad);
  $n_dependencia = odbc_result($cur1,2);
  $n_centraliza = odbc_result($cur1,3);
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
          <h3>Acta Pago de Recompensas</h3>
          <div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Registro</font></label>
                  <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="numero" id="numero" class="form-control" value="<?php echo $numero1; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="centra" id="centra" class="form-control" value="<?php echo $unic; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="mes" id="mes" class="form-control" value="<?php echo $mes; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="firmas" id="firmas" class="form-control" value="" readonly="readonly" tabindex="0">
                  <input type="hidden" name="expedidas" id="expedidas" class="form-control" value="" readonly="readonly" tabindex="0">
                  <input type="hidden" name="actu" id="actu" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_ciudad" id="v_ciudad" class="form-control" value="<?php echo $ciu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_click" id="v_click" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <select name="solicitud" id="solicitud" class="form-control select2" tabindex="1"></select>
                  <div id="vinculo"></div>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor Acta Comit&eacute;</font></label>
                  <input type="text" name="valor" id="valor" class="form-control numero" value="0.00" readonly="readonly" tabindex="2">
                  <input type="hidden" name="valor1" id="valor1" class="form-control numero" value="0" readonly="readonly" tabindex="3">
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Fuentes</font></label>
                  <select name="fuentes" id="fuentes" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione una o mas fuentes" tabindex="4" onchange="val_fuentes();"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor Acta Pago</font></label>
                  <input type="text" name="pago" id="pago" class="form-control numero" value="0.00" readonly="readonly" tabindex="5">
                  <input type="hidden" name="pago1" id="pago1" class="form-control numero" value="0" readonly="readonly" tabindex="6">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">No. Acta</font></label>
                  <input type="text" name="numero1" id="numero1" class="form-control numero" value="0" readonly="readonly" tabindex="7">
                </div>
              </div>
              <br>
              <div id="datos">
                <div class="row">
                  <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                    <label><font face="Verdana" size="2">Fuentes</font></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
                    <table width="100%" align="center" border="0">
                      <tr>
                        <td width="50%">
                          <b>Identificaci&oacute;n y Nombre Completo</b>
                        </td>
                         <td width="40%">
                          <b>Expedida</b>
                        </td>
                        <td width="10%">
                          &nbsp;
                        </td>
                      </tr>
                    </table>
                    <div id="expediciones"></div>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <!--<label><font face="Verdana" size="2">Aprobaci&oacute;n Otros Entes</font></label>-->
                    <input type="text" name="pago2" id="pago2" class="form-control numero" value="0.00" onkeyup="paso_val();" tabindex="8">
                    <input type="hidden" name="pago3" id="pago3" class="form-control numero" value="0" readonly="readonly" tabindex="9">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <!--<label><font face="Verdana" size="2">Activar</font></label>-->
                    <select name="tp_pago" id="tp_pago" class="form-control select2" onchange="cambio();" tabindex="10"> 
                      <option value="0">NO</option>
                      <option value="1">SI</option>
                    </select>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                    <label><font face="Verdana" size="2">Intervienen</font></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table width="100%" align="center" border="0">
                      <tr>
                        <td width="45%">
                          <b>Grado y Nombre Completo</b>
                        </td>
                         <td width="45%">
                          <b>Cargo</b>
                        </td>
                        <td width="10%">
                          &nbsp;
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div id="add_form">
                      <table width="100%" align="center" border="0">
                        <tr>
                          <td colspan="2"></td>
                        </tr>
                      </table>
                    </div>
                    <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0" tabindex="12"></a>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label><font face="Verdana" size="2">Sintesis Informaci&oacute;n Suministrada</font></label>
                    <textarea name="sintesis" id="sintesis" class="form-control" rows="5" onblur="val_caracteres('sintesis');" tabindex="13"></textarea>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label><font face="Verdana" size="2">Utilidad y Empleo de la Informaci&oacute;n</font></label>
                    <textarea name="utilidad" id="utilidad" class="form-control" rows="5" onblur="val_caracteres('utilidad');" tabindex="14"></textarea>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label><font face="Verdana" size="2">Observaciones</font></label>
                    <textarea name="observaciones" id="observaciones" class="form-control" rows="5" onblur="val_caracteres('observaciones');" tabindex="15"></textarea>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                    <label><font face="Verdana" size="2">Elabor&oacute;</font></label>
                    <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="16" autocomplete="off">
                  </div>
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                    <label><font face="Verdana" size="2">Revis&oacute;</font></label>
                    <input type="text" name="reviso" id="reviso" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="17" autocomplete="off">
                  </div>
                </div>
                <br>
                <center>
                  <input type="button" name="aceptar" id="aceptar" value="Continuar" tabindex="18">
                  <input type="button" name="aceptar2" id="aceptar2" value="Actualizar" tabindex="19">
                  &nbsp;&nbsp;&nbsp;
                  <input type="button" name="aceptar1" id="aceptar1" value="Visualizar" tabindex="20">
                </center>
              </div>
            </form>
          </div>
          <h3>Consultas</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
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
            <br>
            <div id="l_ajuste">
              <center>
                <label for="ajuste">Ajuste de Lineas Firma:</label>
                <input name="ajuste" id="ajuste" class="numero" onkeypress="return check(event);" value="0">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="chk_hoja" id="chk_hoja" value="0">
                <label><font face="Verdana" size="2">Incluir Hoja en Blanco</font></label>
              </center>
            </div>
            <form name="formu1" action="ver_recompensa.php" method="post" target="_blank">
              <input type="hidden" name="acta_conse" id="acta_conse" readonly="readonly">
              <input type="hidden" name="acta_ano" id="acta_ano" readonly="readonly">
              <input type="hidden" name="acta_registro" id="acta_registro" readonly="readonly">
              <input type="hidden" name="acta_ano1" id="acta_ano1" readonly="readonly">
              <input type="hidden" name="acta_ajuste" id="acta_ajuste" readonly="readonly">
              <input type="hidden" name="acta_hoja" id="acta_hoja" readonly="readonly">
              <input type="hidden" name="acta_informe" id="acta_informe" readonly="readonly">
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
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
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
    height: 210,
    width: 510,
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
    height: 355,
    width: 560,
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
  $("#solicitud").change(trae_datos);
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(link);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(pregunta);
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").hide();
  $("#aceptar1").hide();
  $("#aceptar2").hide();
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  var MaxInputs       = 99;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      var y = z-1;
      FieldCount++;
      if (z == "1")
      {
        $("#add_form table").append('<tr><td width="45%" class="espacio1"><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="45%" class="espacio2"><input type="text" name="car_'+z+'" id="car_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>');
      }
      else
      {
        $("#add_form table").append('<tr><td width="45%" class="espacio1"><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="45%" class="espacio2"><input type="text" name="car_'+z+'" id="car_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="10%"><div id="men_'+z+'"><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      }
      x_1++;
      if (z == "1")
      {
      }
      else
      {
        $("html,body").animate({ scrollTop: 1 }, "slow");
        $("#men_"+y).hide();
      }
      $("#nom_"+z).focus();
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
  $("#add_field").click();
  $("#pago2").maskMoney();
  $("#pago2").prop("disabled",true);
  $("#pago2").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#tp_pago").prop("disabled",true);
  $("#ajuste").spinner({ min: 0 });
  $("#ajuste").width(50);
  $("#fuentes").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  trae_registros();
  $("#pago2").hide();
  $("#pago3").hide();
  $("#tp_pago").hide();
});
function trae_registros()
{
  $("#solicitud").html('');
  var planes = $("#numero").val();
  if (planes == "0")
  {
    $("#solicitud").prop("disabled",true);
    $("#nom_1").prop("disabled",true);
    $("#car_1").prop("disabled",true);
    $("#add_field").hide();
  }
  else
  {
    var var_ocu = planes.split(',');
    var var_ocu1 = var_ocu.length;
    var salida = "";
    var paso = "";
    var j = 0;
    for (var i=0; i<var_ocu1-1; i++)
    {
      j = j+1;
      paso = var_ocu[i];
      salida += "<option value='"+paso+"'>"+paso+"</option>";
    }
    $("#solicitud").append(salida);
    $("#solicitud").prop("disabled",false);
    $("#nom_1").prop("disabled",false);
    $("#car_1").prop("disabled",false);
    $("#add_field").show();
    trae_datos();
  }
}
function trae_datos()
{
  limpia();
  var registro = $("#solicitud").val();
  if (registro == "- SELECCIONAR -")
  {
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_registro2.php",
      data:
      {
        registro: registro
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        var registro = registros.registro;
        var ano1 = registros.ano1;
        var valores = registro+" - "+ano1;
        var tipo = registros.tipo;
        if (tipo == "0")
        {
          var total = registros.total;
          if (total == "0")
          {
            var detalle = "<center><h3>Acta Comité Central No Elaborada</h3></center>";
            $("#dialogo").html(detalle);
            $("#dialogo").dialog("open");
            $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
          else
          {
            var salida = "";
            salida += "<option value='"+valores+"'>"+valores+"</option>";
            $("#solicitud").append(salida);
            $("#solicitud").prop("disabled",true);
            var totala = registros.totala;
            $("#valor").val(totala);
            paso_valor();
            var cedulas = registros.cedulas;
            var nombres = registros.nombres;
            var porcentajes = registros.porcentajes1;
            var valores = registros.valores1;
            var fuentes = registros.fuentes;
            if ((fuentes === undefined) || (fuentes === null) || (fuentes === false))
            {
              fuentes = "";
            }
            var var_ocu = cedulas.split('|');
            var var_ocu1 = var_ocu.length;
            var var_ocu2 = nombres.split('|');
            var var_ocu3 = porcentajes.split('|');
            var var_ocu4 = valores.split('|');
            var salida1 = "";
            for (var i=0; i<var_ocu1-1; i++)
            {
              var v1 = var_ocu[i];
              v1 = v1.trim();
              var ced_fuente = v1.substr(v1.length-4);
              ced_fuente = "XXXX"+ced_fuente;
              var v2 = var_ocu2[i];
              var v3 = var_ocu3[i];
              var v4 = var_ocu4[i];
              var v5 = v1+'|'+v2+'|'+v3+'|'+v4;
              var v6 = fuentes.indexOf(v1) > -1;
              if (v6 == false)
              {
                salida1 += "<option value='"+v5+"'>"+ced_fuente+" - "+v2+"</option>";
              }
            }
            var sintesis = registros.sintesis;
            $("#sintesis").val(sintesis);
          }
        }
        else
        {
          var salida = "";
          salida += "<option value='"+valores+"'>"+valores+"</option>";
          $("#solicitud").append(salida);
          $("#solicitud").prop("disabled",true);
          var totala = registros.totala;
          totala = parseFloat(totala);
          totala = totala.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          $("#valor").val(totala);
          paso_valor();
          var cedulas = registros.cedulas;
          var nombres = registros.nombres;
          var porcentajes = registros.porcentajes1;
          var valores = registros.valores1;
          var fuentes = registros.fuentes;
          if ((fuentes === undefined) || (fuentes === null) || (fuentes === false))
          {
            fuentes = "";
          }
          var var_ocu = cedulas.split('|');
          var var_ocu1 = var_ocu.length;
          var var_ocu2 = nombres.split('|');
          var var_ocu3 = porcentajes.split('|');
          var var_ocu4 = valores.split('|');
          var salida1 = "";
          for (var i=0; i<var_ocu1-1; i++)
          {
            var v1 = var_ocu[i];
            v1 = v1.trim();
            var ced_fuente = v1.substr(v1.length-4);
            ced_fuente = "XXXX"+ced_fuente;
            var v2 = var_ocu2[i];
            var v3 = var_ocu3[i];
            var v4 = var_ocu4[i];
            var v5 = v1+'|'+v2+'|'+v3+'|'+v4;
            var v6 = fuentes.indexOf(v1) > -1;
            if (v6 == false)
            {
              salida1 += "<option value='"+v5+"'>"+ced_fuente+" - "+v2+"</option>";
            }
          }
        }
        $("#fuentes").html('');
        $("#fuentes").append(salida1);
        $("#add_field").show();
      }
    });
  }
}
function val_fuentes()
{ 
  var acta = $("#valor1").val();
  acta = parseFloat(acta);
  var fuentes = $("#fuentes").select2('val');
  if ((fuentes === undefined) || (fuentes === null))
  {
    var total = 0;
    $("#pago1").val(total);
    paso_total();
    $("#aceptar").hide();
  }
  else
  {
    var fuentes1 = fuentes.toString();
    var var_ocu = fuentes1.split(',');
    var var_ocu1 = var_ocu.length;
    var total = 0;
    var salida = "<table width='100%' align='center' border='0'>";
    for (var i=0; i<var_ocu1; i++)
    {
      var paso = var_ocu[i];
      var var_ocu2 = paso.split('|');
      var cedula = var_ocu2[0];
      cedula = cedula.trim();
      var ced_fuente = cedula.substr(cedula.length-4);
      ced_fuente = "XXXX"+ced_fuente;
      var nombre = var_ocu2[1];
      salida += '<tr><td width="50%" class="espacio1">'+ced_fuente+' - '+nombre+'</td><td width="40%" class="espacio1"><input type="text" name="exp_'+i+'" id="exp_'+i+'" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="10%" class="espacio1">&nbsp;</td></tr>';
      var porcen = var_ocu2[2];
      porcen = parseFloat(porcen);
      var valor = var_ocu2[3];
      valor = parseFloat(valor);
      var pago = (acta*porcen)/100;
      pago = pago-valor;
      var total = total+pago;
      if (total > 0)
      {
        $("#aceptar").show();
      }
      else
      {
        $("#aceptar").hide();
      }
    }
    $("#pago1").val(total);
    $("#expediciones").html('');
    $("#expediciones").append(salida);
    $("#tp_pago").prop("disabled",false);
    paso_total();
  }
}
function cambio()
{
  var valida = $("#tp_pago").val();
  if (valida == "1")
  {
    $("#pago2").prop("disabled",false);
    $("#pago2").focus();
  }
  else
  {
    $("#pago2").val('0.00');
    $("#pago2").prop("disabled",true);
  }
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
function limpia()
{
  $("#numero1").val('0');
  $("#valor").val('0.00');
  $("#valor1").val('0');
  $("#pago").val('0.00');
  $("#pago1").val('0');
  $("#sintesis").val('');
  $("#utilidad").val('');
  $("#observaciones").val('');
}
function paso_total()
{
  var valor = $("#pago1").val();
  var valor1 = parseFloat(valor);
  valor1 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#pago").val(valor1);
}
function paso_valor()
{
  var valor;
  valor = $("#valor").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valor1").val(valor);
}
function paso_valor1()
{
  var valor;
  valor = $("#pago").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#pago1").val(valor);
}
function paso_val()
{
  var valor = $("#pago2").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#pago3").val(valor);
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function validacionData()
{
  var salida = true, detalle = '';
  document.getElementById('firmas').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu.elements[i].name;
    if (saux1.indexOf('car_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
      valor2 = valor+"»"+valor1;
      document.getElementById('firmas').value = document.getElementById('firmas').value+valor2+"|";
    }
  }
  document.getElementById('expedidas').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('exp_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('expedidas').value = document.getElementById('expedidas').value+valor+"|";
    }
  }
  var v_expedidas = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('exp_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_expedidas ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_expedidas > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_expedidas+" Expedición(es)</h3></center>";
  }
  var v_nombres = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_nombres ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_nombres > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_nombres+" Nombre(s)</h3></center>";
  }
  var v_cargos = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('car_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_cargos ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_cargos > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_cargos+" Cargo(s)</h3></center>";
  }
  var valor = $("#sintesis").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Sintesis de la Información</h3></center>";
    $("#sintesis").addClass("ui-state-error");
  }
  else
  {
    $("#sintesis").removeClass("ui-state-error");
  }
  var valor1 = $("#utilidad").val();
  valor1 = valor1.trim().length;
  if (valor1 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Utilidad de la Información</h3></center>";
    $("#utilidad").addClass("ui-state-error");
  }
  else
  {
    $("#utilidad").removeClass("ui-state-error");
  }
  var valor2 = $("#observaciones").val();
  valor2 = valor2.trim().length;
  if (valor2 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar las Observaciones</h3></center>";
    $("#observaciones").addClass("ui-state-error");
  }
  else
  {
    $("#observaciones").removeClass("ui-state-error");
  }
  var valor3 = $("#elaboro").val();
  valor3 = valor3.trim().length;
  if (valor3 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la persona que Elaboro el Acta</h3></center>";
    $("#elaboro").addClass("ui-state-error");
  }
  else
  {
    $("#elaboro").removeClass("ui-state-error");
  }
  var valor4 = $("#reviso").val();
  valor4 = valor4.trim().length;
  if (valor4 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la persona que Revisó el Acta</h3></center>";
    $("#reviso").addClass("ui-state-error");
  }
  else
  {
    $("#reviso").removeClass("ui-state-error");
  }
  var total = $("#pago1").val();
  if (total == "0")
  {
    salida = false;
    detalle += "<center><h3>Valor del Acta No Permitido</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo2").html(detalle);
    $("#dialogo2").dialog("open");
    $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var actualiza = $("#actu").val();
    if (actualiza == "0")
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
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "acte_grab.php",
      data:
      {
        tipo: valor,
        centra: $("#centra").val(),
        conse: $("#numero1").val(),
        registro: $("#solicitud").val(),
        valor: $("#valor").val(),
        total: $("#pago").val(),
        pago: $("#pago2").val(),
        otro: $("#tp_pago").val(),
        firmas: $("#firmas").val(),
        fuentes: $("#fuentes").select2('val'),
        expedidas: $("#expedidas").val(),
        acta: $("#acta").val(),
        sintesis: $("#sintesis").val(),
        utilidad: $("#utilidad").val(),
        observaciones: $("#observaciones").val(),
        elaboro: $("#elaboro").val(),
        reviso: $("#reviso").val(),
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
        var valida = registros.salida;
        if (valida > 0)
        {
          $("#aceptar").hide();
          $("#aceptar2").hide();
          $("#aceptar1").show();
          $("#acta_conse").val(valida);
          $("#acta_ano").val(registros.salida1);
          $("#acta_registro").val(registros.salida2);
          $("#acta_ano1").val(registros.salida3);
          $("#acta_ajuste").val('0');
          $("#acta_hoja").val('0');
          $("#acta_informe").val('1');
          $("#pago2").prop("disabled",true);
          $("#tp_pago").prop("disabled",true);
          $("#solicitud").prop("disabled",true);
          $("#fuentes").prop("disabled",true);
          $("#sintesis").prop("disabled",true);
          $("#utilidad").prop("disabled",true);
          $("#observaciones").prop("disabled",true);
          $("#elaboro").prop("disabled",true);
          $("#reviso").prop("disabled",true);
          for (i=0;i<document.formu.elements.length;i++)
          {
            saux = document.formu.elements[i].name;
            if (saux.indexOf('exp_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('nom_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('car_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
          $("#add_field").hide();
          for (k=1;k<=20;k++)
          {
            $("#men_"+k).hide();
          }
          $("#actu").val('0');
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#aceptar").show();
          $("#v_click").val('0');
        }
      }
    });
  }
}
function consultar()
{
  var mes = $("#mes").val();
  var mes1 = mes-1;
  var ano1 = $("#ano").val();
  var super1 = $("#super").val();
  var salida = true;
  if (super1 == "1")
  {
    var fecha2 = $("#fecha2").val();
    if (fecha2 == "")
    {
      salida = false;
      alerta("Debe seleccionar fecha final");
    }
    var fecha1 = $("#fecha1").val();
    if (fecha1 == "")
    {
      salida = false;
      alerta("Debe seleccionar fecha inicial");
    }
  }
  if (salida == false)
  {
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "acte_consu.php",
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
        var registros = JSON.parse(data);
        var valida,valida1;
        var salida1 = "";
        var salida2 = "";
        listareg = [];
        valida = registros.salida;
        valida1 = registros.total;
        salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
        salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='5%'><b>No.</b></td><td height='35' width='8%'><b>Fecha</b></td><td height='35' width='8%'><b>Unidad</b></td><td height='35' width='8%'><b>Usuario</b></td><td height='35' width='12%'><b>Registro - A&ntilde;o</b></td><td height='35' width='29%'><b>Fuentes</b></center></td><td height='35' width='10%'><b>Valor Acta</b></td><td height='35' width='5%'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td></tr></table>";
        salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
        $.each(registros.rows, function (index, value)
        {
          var datos1 = '\"'+value.conse+'\",\"'+value.ano+'\",\"'+value.unidad+'\",\"'+index+'\"';
          var periodo = value.fecha.split('-');
          var periodo1 = periodo[1];
          periodo1 = parseInt(periodo1);
          var ano = periodo[0];
          ano = parseInt(ano);
          salida2 += "<tr><td width='5%' height='35' id='l1_"+index+"'>"+value.conse+"</td>";
          salida2 += "<td width='8%' height='35' id='l2_"+index+"'>"+value.fecha+"</td>";
          salida2 += "<td width='8%' height='35' id='l3_"+index+"'>"+value.unidad+"</td>";
          salida2 += "<td width='8%' height='35' id='l4_"+index+"'>"+value.usuario+"</td>";
          salida2 += "<td width='12%' height='35' id='l5_"+index+"'>"+value.registro+" - "+value.ano1+"</td>";
          salida2 += "<td width='29%' height='35' id='l6_"+index+"'>"+value.cedulas+"</td>";
          salida2 += "<td width='10%' height='35' align='right' id='l7_"+index+"'>"+value.pago+"</td>";
          if ((periodo1 == mes) && (ano == ano1))
          {
            salida2 += "<td width='5%' height='35' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); modif("+value.conse+","+value.ano+","+value.registro+","+value.ano1+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='5%' height='35' id='l8_"+index+"'><center><img src='imagenes/blanco.png' border='0'></td>";
          }
          salida2 += "<td width='5%' height='35' id='l9_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); link1("+value.conse+","+value.ano+","+value.registro+","+value.ano1+",1)'><img src='imagenes/pdf.png' border='0' title='Visualizar Acta de Pago'></a></center></td>";
          salida2 += "<td width='5%' height='35' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); link1("+value.conse+","+value.ano+","+value.registro+","+value.ano1+",2)'><img src='imagenes/pdf.png' border='0' title='Visualizar Acta de Acuerdos'></a></center></td>";
          // Eliminar PDF Final
          if (super1 == "1")
          {
            salida2 += "<td width='5%' height='35' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); del_pdf("+datos1+");'><img src='dist/img/delete.png' name='pdf_"+index+"' id='pdf_"+index+"' width='29' height='29' border='0' title='Eliminar PDF'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='5%' height='35' id='l11_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
          }
          salida2 += "</tr>";
          listareg.push(index);
        });
        salida2 += "</table>";
        $("#tabla3").append(salida1);
        $("#resultados5").append(salida2);
      }
    });
  }
}
function modif(valor, valor1, valor2, valor3)
{
  $("#soportes").accordion({active: 0});
  $("#solicitud").html('');
  var valor, valor1, valor2, valor3;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "acte_consu1.php",
    data:
    {
      conse: valor,
      ano: valor1,
      registro: valor2,
      ano1: valor3
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
      var registro = registros.registro;
      var ano1 = registros.ano1;
      var valores = registro+" - "+ano1;
      var salida = "";
      salida += "<option value='"+valores+"'>"+valores+"</option>";
      $("#solicitud").append(salida);
      $("#solicitud").prop("disabled",true);
      var con_firmas = 0;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('nom_')!=-1)
        {
          con_firmas ++;
        }
      }
      // Firmas
      var firmas = registros.firmas;
      var var_ocu = firmas.split('|');
      var var_ocu1 = var_ocu.length;
      var var_ocu2 = var_ocu1-2;
      var z = 0;
      for (var i=0; i<var_ocu1-1; i++)
      {      
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("»");
        z = z+1;
        var nom = var_2[0];
        nom = nom.trim();
        var car = var_2[1];
        car = car.trim();
        $("#nom_"+z).val(nom);
        $("#car_"+z).val(car);
        if (con_firmas > var_ocu2)
        {
        }
        else
        {
          if (i < var_ocu2)
          {
            $("#add_field").click();
          }
        }
      }
      $("#nom_1").prop("disabled",false);
      $("#car_1").prop("disabled",false);
      $("#add_field").show();
      // Fuentes
      var salida1 = "";
      var salida2 = "<table width='100%' align='center' border='0'>";
      var cedulas = registros.cedulas;
      var var_ocu = cedulas.split(',');
      var var_ocu1 = var_ocu.length;
      var expedidas = registros.expedidas;
      var var_ocu3 = expedidas.split('|');
      for (var i=0; i<var_ocu1; i++)
      {
        var var_1 = var_ocu[i];
        var var_ocu2 = var_1.split('|');
        var var_2 = var_ocu2[0];
        var_2 = var_2.trim();
        var ced_fuente = var_2.substr(var_2.length-4);
        ced_fuente = "XXXX"+ced_fuente;
        var var_3 = var_ocu2[1];
        var var_4 = var_ocu2[2];
        var var_5 = var_ocu2[3];
        var var_6 = var_2+'|'+var_3+'|'+var_4+'|'+var_5;
        var var_7 = var_ocu3[i];
        salida1 += "<option value='"+var_6+"' selected>"+ced_fuente+" - "+var_3+"</option>";
        salida2 += '<tr><td width="50%" class="espacio1">'+ced_fuente+' - '+var_3+'</td><td width="40%" class="espacio1"><input type="text" name="exp_'+i+'" id="exp_'+i+'" class="form-control" value="'+var_7+'" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="10%" class="espacio1">&nbsp;</td></tr>';
      }
      $("#fuentes").append(salida1);
      $("#fuentes").prop("disabled",true);
      $("#expediciones").html('');
      $("#expediciones").append(salida2);
      $("#numero1").val(registros.conse);
      $("#pago2").val(registros.otro);
      $("#tp_pago").val(registros.cambio);
      $("#sintesis").val(registros.sintesis);
      $("#utilidad").val(registros.utilidad);
      $("#observaciones").val(registros.observaciones);
      $("#elaboro").val(registros.elaboro);
      $("#reviso").val(registros.reviso);
      var valor = registros.valor;
      $("#valor").val(valor);
      paso_valor();
      var pago = registros.pago;
      $("#pago").val(pago);
      paso_valor1();
      $("#actu").val('1');
      $("#aceptar").hide();
      $("#aceptar2").show();
      $("#sintesis").focus();
    }
  });
}
function del_pdf(conse, ano, sigla, index)
{
  var conse, ano, index, archivo;
  archivo = "ActaPagFue_"+sigla+"_"+conse+"_"+ano+".pdf";
  var ruta = "Actas\\"+archivo;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "borrar2.php",
    data:
    {
      ruta: ruta
    },
    success: function (data)
    {
      $("#pdf_"+index).hide();
      alerta("Archivo PDF eliminado correctamente");
      alerta(archivo);
    }
  });
}
function check(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function link()
{
  formu1.submit();
}
function link1(valor, valor1, valor2, valor3, valor4)
{
  var valor, valor1, valor2, valor3, valor4;
  var ajuste = $("#ajuste").val();
  var hoja = "0";
  if ($("#chk_hoja").is(':checked'))
  {
    hoja = "1";
  }
  $("#acta_conse").val(valor);
  $("#acta_ano").val(valor1);
  $("#acta_registro").val(valor2);
  $("#acta_ano1").val(valor3);
  $("#acta_ajuste").val(ajuste);
  $("#acta_hoja").val(hoja);
  $("#acta_informe").val(valor4);
  formu1.submit();
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
// 30/01/2024 - Eliminacion de archivos pdf guardados
?>