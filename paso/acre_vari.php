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
  $mes = date('m');
  $mes = intval($mes);
  $ano = date('Y');
  $query = "SELECT unidad, dependencia, tipo FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $query);
  $n_unidad = odbc_result($cur,1);
  $n_dependencia = odbc_result($cur,2);
  $n_tipo = odbc_result($cur,3);
  if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
  {
    if (($nun_usuario == "2") or ($nun_usuario == "3"))
    {
      $pregunta = "SELECT dependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' AND unic='1'";
      $sql = odbc_exec($conexion, $pregunta);
      $con = odbc_num_rows($sql);
      $paso = "";
      while($i<$row=odbc_fetch_array($sql))
      {
        $paso .= "'".odbc_result($sql,1)."',";
      }
      $paso = substr($paso, 0, -1);
      $dependencia = odbc_result($sql,1);
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia IN ($paso) ORDER BY subdependencia";
    }
    else
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unic='1' ORDER BY subdependencia";        
    }
  }
  else
  {
    if ($n_tipo == "7")
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND dependencia='$n_dependencia' ORDER BY subdependencia";
    }
    else
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' ORDER BY subdependencia";
    }
  }
  $cur1 = odbc_exec($conexion, $query1);
  $numero = "";
  while($i<$row=odbc_fetch_array($cur1))
  {
    $numero .= "'".odbc_result($cur1,1)."',";
  }
  $numero = substr($numero,0,-1);
  $numero = trim($numero);
  // Se verifica si es unidad centralizadora especial
  if (strpos($especial, $uni_usuario) !== false)
  {
    $numero .= ",";
    $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$nun_usuario' ORDER BY unidad";
    $cur = odbc_exec($conexion, $query);
    while($i<$row=odbc_fetch_array($cur))
    {
      $n_unidad = odbc_result($cur,1);
      $n_dependencia = odbc_result($cur,2);
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
      $cur1 = odbc_exec($conexion, $query1);
      while($j<$row=odbc_fetch_array($cur1))
      {
        $numero .= "'".odbc_result($cur1,1)."',";
      }
    }
    $numero .= "'".$uni_usuario."'";
  }
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
          <h3>Acreedores Varios</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">No.</font></label>
                  <input type="hidden" name="v_unidades" id="v_unidades" class="form-control" value="<?php echo $numero; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="text" name="interno" id="interno" class="form-control numero" value="0" tabindex="1">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Batall&oacute;n</font></label>
                  <select name="batallon" id="batallon" class="form-control select2" onchange="busca();" tabindex="2"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Brigada</font></label>
                  <select name="brigada" id="brigada" class="form-control select2" tabindex="3"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Divisi&oacute;n</font></label>
                  <select name="division" id="division" class="form-control select2" tabindex="4"></select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Nombre de la Fuente</font></label>
                  <input type="text" name="nombre" id="nombre" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="60" tabindex="5" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">C&eacute;dula de la Fuente</font></label>
                  <input type="text" name="cedula" id="cedula" class="form-control" maxlength="15" onkeypress="return check(event);" tabindex="6" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Concepto del Gasto</font></label>
                  <select name="concepto" id="concepto" class="form-control select2" tabindex="7">
                    <option value="1">PAGO DE INFORMACI&Oacute;N</option>
                    <option value="2">PAGO DE RECOMPENSA</option>
                  </select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Acto Administrativo</font></label>
                  <select name="acto" id="acto" class="form-control select2" tabindex="8">
                    <option value="1">ACTA COMIT&Eacute; CENTRAL</option>
                    <option value="2">AUTORIZACI&Oacute;N DE RECURSOS</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">N&uacute;mero Acto Administrativo</font></label>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Fecha Acto Administrativo</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Plan / Solicitud</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">A&ntilde;o</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <input type="text" name="numero" id="numero" class="form-control numero" value="" onkeypress="return check1(event);" maxlength="30" tabindex="9" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="fecha" id="fecha" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="10">
                </div>
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="plan" id="plan" class="form-control numero" value="0" onkeypress="return check(event);" tabindex="11">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="ano" id="ano" class="form-control numero" value="0" onkeypress="return check(event);" tabindex="12">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">ORDOP / ORDOP IMI</font></label>
                  <input type="text" name="ordop" id="ordop" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="60" tabindex="13" autocomplete="off">
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">OFRAG</font></label>
                  <input type="text" name="ofrag" id="ofrag" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="60" tabindex="14" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha Resultado</font></label>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Unidad Reporta Resultado</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor Constituido</font></label>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Fecha Constituci&oacute;n</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="15">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <input type="text" name="unidad" id="unidad" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="60" tabindex="16" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="valor" id="valor" class="form-control numero" value="0.00" onkeyup="paso_val();" tabindex="17" autocomplete="off">
                  <input type="hidden" name="valor1" id="valor1" class="form-control" value="0" readonly="readonly">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="18">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Motivo de la Constituci&oacute;n</font></label>
                  <textarea name="motivo" id="motivo" class="form-control" rows="5" onblur="val_caracteres('motivo');" tabindex="19"></textarea>
                </div>
              </div>
              <br>
                <center>
                  <input type="button" name="aceptar" id="aceptar" value="Registrar">
                  <input type="button" name="aceptar1" id="aceptar1" value="Actualizar">
                </center>
            </form>
          </div>
          <h3>Consultas</h3>
          <div>
            <div id="load1">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <div class="row">
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Fecha</font></label>
                <input type="text" name="fecha3" id="fecha3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">&nbsp;</font></label>
                <input type="text" name="fecha4" id="fecha4" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                <label><font face="Verdana" size="2">Tipo Fecha</font></label>
                <select name="tipo" id="tipo" class="form-control select2" tabindex="7">
                  <option value="-">- SELECCIONAR -</option>
                  <option value="1">ACTO ADMINISTRATIVO</option>
                  <option value="2">RESULTADO</option>
                  <option value="3">CONSTITUCI&Oacute;N</option>
                </select>
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
        </div>
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
  $("#fecha").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#fecha1").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#fecha2").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#fecha3").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fecha4").prop("disabled", false);
      $("#fecha4").datepicker("destroy");
      $("#fecha4").val('');
      $("#fecha4").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha3").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
    },
  });
  $("#load").hide();
  $("#load1").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 265,
    width: 610,
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
        validacion();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#batallon").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  trae_unidades();
  trae_brigadas();
  trae_divisiones();
  $("#valor").maskMoney();
  $("#interno").prop("disabled",true);
  $("#brigada").prop("disabled",true);
  $("#division").prop("disabled",true);
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").hide();
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  var v_unidad = $("#v_unidad").val();
  if ((v_unidad == "1") || (v_unidad == "2"))
  {
    $("#aceptar").show();
    $("#soportes").accordion({active: 0});
  }
  else
  {
    $("#aceptar").hide();
    $("#soportes").accordion({active: 1});
  }
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
    }
  });
}
function trae_brigadas()
{
  $("#brigada").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_brig.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
          var dependencia = registros[i].dependencia;
          var nombre = registros[i].nombre;
          salida += "<option value='"+dependencia+"'>"+nombre+"</option>";
      }
      $("#brigada").append(salida);
    }
  });
}
function trae_divisiones()
{
  $("#division").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_divi.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
          var unidad = registros[i].unidad;
          var nombre = registros[i].nombre;
          salida += "<option value='"+unidad+"'>"+nombre+"</option>";
      }
      $("#division").append(salida);
    }
  });
}
function busca()
{
  var batallon = $("#batallon").val();
  if (batallon == "0")
  {
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_brig1.php",
      data:
      {
        unidad: batallon
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        $("#brigada").val(registros.brigada);
        $("#division").val(registros.division);
      }
    });
  }
}
function paso_val()
{
  var valor = $("#valor").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valor1").val(valor);
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function validacion()
{
  var salida = true, detalle = '';
  var valor = $("#batallon").val();
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar el campo Batall&oacute;n</h3></center>";
  }
  var valor1 = $("#nombre").val();
  valor1 = valor1.trim().length;
  if (valor1 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Nombre de la Fuente</h3></center>";
    $("#nombre").addClass("ui-state-error");
  }
  else
  {
    $("#nombre").removeClass("ui-state-error");
  }
  var valor2 = $("#cedula").val();
  valor2 = valor2.trim().length;
  if (valor2 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la C&eacute;dula de la Fuente</h3></center>";
    $("#cedula").addClass("ui-state-error");
  }
  else
  {
    $("#cedula").removeClass("ui-state-error");
  }
  var valor3 = $("#numero").val();
  valor3 = valor3.trim().length;
  if (valor3 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el N&uacute;mero del Acto Administrativo</h3></center>";
    $("#numero").addClass("ui-state-error");
  }
  else
  {
    $("#numero").removeClass("ui-state-error");
  }
  var valor4 = $("#fecha").val();
  if (valor4 == "")
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar la Fecha del Acto Administrativo</h3></center>";
    $("#fecha").addClass("ui-state-error");
  }
  else
  {
    $("#fecha").removeClass("ui-state-error");
  }
  var v_concepto = $("#concepto").val();
  if (v_concepto == "1")
  {
    var valor5 = $("#plan").val();
    var valor5_1 = valor5.trim().length;
    if ((valor5 == "0") || (valor5_1 == "0"))
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar el Plan / Solicitud</h3></center>";
      $("#plan").addClass("ui-state-error");
    }
    else
    {
      $("#plan").removeClass("ui-state-error");
    }
  }
  var valor6 = $("#ano").val();
  var valor6_1 = valor6.trim().length;
  if ((valor6 == "0") || (valor6_1 == "0"))
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el A&ntilde;o del Plan / Solicitud</h3></center>";
    $("#ano").addClass("ui-state-error");
  }
  else
  {
    $("#ano").removeClass("ui-state-error");
  }
  var valor7 = $("#ordop").val();
  valor7 = valor7.trim().length;
  if (valor7 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar una ORDOP</h3></center>";
    $("#ordop").addClass("ui-state-error");
  }
  else
  {
    $("#ordop").removeClass("ui-state-error");
  }
  var valor8 = $("#ofrag").val();
  valor8 = valor8.trim().length;
  if (valor8 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar una OFRAG</h3></center>";
    $("#ofrag").addClass("ui-state-error");
  }
  else
  {
    $("#ofrag").removeClass("ui-state-error");
  }
  var valor9 = $("#fecha1").val();
  if (valor9 == "")
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar la Fecha del Resultado</h3></center>";
    $("#fecha1").addClass("ui-state-error");
  }
  else
  {
    $("#fecha1").removeClass("ui-state-error");
  }
  var valor10 = $("#unidad").val();
  valor10 = valor10.trim().length;
  if (valor10 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Unidad Reporta Resultado</h3></center>";
    $("#unidad").addClass("ui-state-error");
  }
  else
  {
    $("#unidad").removeClass("ui-state-error");
  }
  var valor11 = $("#valor1").val();
  if (valor11 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Valor Constituido</h3></center>";
    $("#valor").addClass("ui-state-error");
  }
  else
  {
    $("#valor").removeClass("ui-state-error");
  }
  var valor12 = $("#fecha2").val();
  if (valor12 == "")
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar la Fecha de Constituci&oacute;n</h3></center>";
    $("#fecha2").addClass("ui-state-error");
  }
  else
  {
    $("#fecha2").removeClass("ui-state-error");
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var valida = $("#interno").val();
    if (valida == "0")
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
    url: "reg_grab6.php",
    data:
    {
      tipo: valor,
      conse: $("#interno").val(),
      batallon: $("#batallon").val(),
      brigada: $("#brigada").val(),
      division: $("#division").val(),
      nombre: $("#nombre").val(),
      cedula: $("#cedula").val(),
      concepto: $("#concepto").val(),
      acto: $("#acto").val(),
      numero: $("#numero").val(),
      fecha: $("#fecha").val(),
      plan: $("#plan").val(),
      ano: $("#ano").val(),
      ordop: $("#ordop").val(),
      ofrag: $("#ofrag").val(),
      fecha1: $("#fecha1").val(),
      unidad1: $("#unidad").val(),
      valor: $("#valor").val(),
      valor1: $("#valor1").val(),
      fecha2: $("#fecha2").val(),
      motivo: $("#motivo").val(),
      usuario: $("#v_usuario").val(),
      unidad: $("#v_unidad").val()
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
        $("#aceptar").hide();
        $("#aceptar1").hide();
        $("#interno").val(consecu);
        $("#batallon").prop("disabled",true);
        $("#nombre").prop("disabled",true);
        $("#cedula").prop("disabled",true);
        $("#concepto").prop("disabled",true);
        $("#acto").prop("disabled",true);
        $("#numero").prop("disabled",true);
        $("#fecha").prop("disabled",true);
        $("#plan").prop("disabled",true);
        $("#ano").prop("disabled",true);
        $("#ordop").prop("disabled",true);
        $("#ofrag").prop("disabled",true);
        $("#fecha1").prop("disabled",true);
        $("#unidad").prop("disabled",true);
        $("#valor").prop("disabled",true);
        $("#fecha2").prop("disabled",true);
        $("#motivo").prop("disabled",true);
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        if (valor == "1")
        {
          $("#aceptar").show();
        }
        else
        {
          $("#aceptar1").show();
        }
      }
    }
  });
}
function consultar()
{
  var v_unidad = $("#v_unidad").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "acre_consu.php",
    data:
    {
      tipo: $("#tipo").val(),
      fecha1: $("#fecha3").val(),
      fecha2: $("#fecha4").val(),
      unidades: $("#v_unidades").val()
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
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      listareg = [];
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
      salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='5%'><b>No.</b></td><td height='35' width='7%'><b>Fecha</b></td><td height='35' width='8%'><b>Unidad</b></td><td height='35' width='16%'><b>Nombre</b></td><td height='35' width='10%'><b>C&eacute;dula</b></td><td height='35' width='10%'><b>N&uacute;mero Acto</b></td><td height='35' width='12%'><b>ORDOP</b></td><td height='35' width='12%'><b>OFRAG</b></td><td height='35' width='10%'><b>Valor</b></td><td height='35' width='5%'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var estado = value.estado;
        var ced_fuente = value.cedula;
        var val_fuente = ced_fuente.indexOf("K") > -1
        if (val_fuente == false)
        {
          var ced_fuente = value.cedula;
          var ced_fuente1 = ced_fuente.substr(ced_fuente.length-4);
          ced_fuente1 = "XXXX"+ced_fuente1;
        }
        else
        {
          var ced_fuente1 = value.cedula;
        }
        salida2 += "<tr><td height='35' width='5%' id='l1_"+index+"'>"+value.conse+"</td>";
        salida2 += "<td height='35' width='7%' id='l2_"+index+"'>"+value.fecha+"</td>";
        salida2 += "<td height='35' width='8%' id='l3_"+index+"'>"+value.unidad+"</td>";
        salida2 += "<td height='35' width='16%' id='l4_"+index+"'>"+value.nombre+"</td>";
        salida2 += "<td height='35' width='10%' id='l5_"+index+"'>"+ced_fuente1+"</td>";
        salida2 += "<td height='35' width='10%' id='l6_"+index+"'>"+value.numero+"</td>";
        salida2 += "<td height='35' width='12%' id='l7_"+index+"'>"+value.ordop+"</td>";
        salida2 += "<td height='35' width='12%' id='l8_"+index+"'>"+value.ofrag+"</td>";
        salida2 += "<td height='35' width='10%' id='l9_"+index+"' align='right'>"+value.valor+"</td>";
        if ((estado == "") && ((v_unidad == "1") || (v_unidad == "2")))
        {
          salida2 += "<td height='35' width='5%' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); actu("+value.conse+","+value.batallon+",1)'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
        }
        else
        {
          salida2 += "<td height='35' width='5%' id='l10_"+index+"'><center>&nbsp;</center></td>";
        }
        salida2 += "<td height='35' width='5%' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); actu("+value.conse+","+value.batallon+",0)'><img src='imagenes/ver.png' border='0' title='Ver Informaci&oacute;n'></a></center></td>";
        listareg.push(index);
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados5").append(salida2);
    }
  });
}
function actu(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $("#interno").val(valor);
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "acre_consu1.php",
    data:
    {
      conse: $("#interno").val(),
      batallon: valor1
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
      $("#aceptar").hide();
      $("#aceptar1").show();
      $("#soportes").accordion({active: 0});
      var registros = JSON.parse(data);
      var batallon = registros.batallon;
      batallon = "['"+batallon+"']";
      var batallon1 = '$("#batallon").val('+batallon+').trigger("change");';
      eval(batallon1);
      $("#batallon").val();
      $("#batallon").prop("disabled",true);
      $("#brigada").val(registros.brigada);
      $("#division").val(registros.division);
      $("#nombre").val(registros.nombre);
      $("#cedula").val(registros.cedula);
      $("#concepto").val(registros.concepto);
      $("#acto").val(registros.acto);
      $("#numero").val(registros.numero);
      $("#fecha").val(registros.fec_act);
      $("#plan").val(registros.solicitud);
      $("#ano").val(registros.ano);
      $("#ordop").val(registros.ordop);
      $("#ofrag").val(registros.ofrag);
      $("#fecha1").val(registros.fec_res);
      $("#unidad").val(registros.unidad);
      $("#valor").val(registros.valor);
      $("#valor1").val(registros.valor1);
      $("#fecha2").val(registros.fec_con);
      $("#motivo").val(registros.motivo);
      if (valor2 == "0")
      {
        $("#nombre").prop("disabled",true);
        $("#cedula").prop("disabled",true);
        $("#cedula").prop("disabled",true);
        $("#concepto").prop("disabled",true);
        $("#acto").prop("disabled",true);
        $("#numero").prop("disabled",true);
        $("#fecha").prop("disabled",true);
        $("#plan").prop("disabled",true);
        $("#ano").prop("disabled",true);
        $("#ordop").prop("disabled",true);
        $("#ofrag").prop("disabled",true);
        $("#fecha1").prop("disabled",true);
        $("#unidad").prop("disabled",true);
        $("#valor").prop("disabled",true);
        $("#fecha2").prop("disabled",true);
        $("#motivo").prop("disabled",true);
        $("#aceptar1").hide();
      }
      else
      {
        $("#nombre").prop("disabled",false);
        $("#cedula").prop("disabled",false);
        $("#cedula").prop("disabled",false);
        $("#concepto").prop("disabled",false);
        $("#acto").prop("disabled",false);
        $("#numero").prop("disabled",false);
        $("#fecha").prop("disabled",false);
        $("#plan").prop("disabled",false);
        $("#ano").prop("disabled",false);
        $("#ordop").prop("disabled",false);
        $("#ofrag").prop("disabled",false);
        $("#fecha1").prop("disabled",false);
        $("#unidad").prop("disabled",false);
        $("#valor").prop("disabled",false);
        $("#fecha2").prop("disabled",false);
        $("#motivo").prop("disabled",false);
        $("#aceptar1").show();
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
function check1(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9-]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function check2(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
</script>
</body>
</html>
<?php
}
?>