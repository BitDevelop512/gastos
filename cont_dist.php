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
  $verifica = time();
  $alea = strtoupper(md5($verifica));
  $alea = substr($alea,0,5);
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
          <h3>Contratos</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <table width="100%" align="center" border="0">
                <tr>
                  <td width="64%" valign="top">
                    <div class="row">
                      <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                        <label><font face="Verdana" size="2">No. del Contrato</font></label>
                        <input type="hidden" name="conse" id="conse" class="form-control" value="0" readonly="readonly">
                        <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                        <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                        <input type="hidden" name="v_click" id="v_click" class="form-control" value="0" readonly="readonly" tabindex="0">
                        <input type="hidden" name="v_consu" id="v_consu" class="form-control" value="0" readonly="readonly">
                        <input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly" tabindex="0">
                        <input type="hidden" name="actu" id="actu" class="form-control" value="0" readonly="readonly">
                        <input type="hidden" name="paso" id="paso" class="form-control" value="" readonly="readonly">
                        <input type="hidden" name="paso1" id="paso1" class="form-control" value="" readonly="readonly">
                        <input type="text" name="numero" id="numero" class="form-control" value="" maxlength="30" tabindex="1" autocomplete="off">
                      </div>
                      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label><font face="Verdana" size="2">Fecha</font></label>
                        <input type="text" name="fecha" id="fecha" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="2">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                        <label><font face="Verdana" size="2">Tipo de Contrato</font></label>
                        <select name="tipo" id="tipo" class="form-control select2">
                          <option value="C">COMBUSTIBLE</option>
                          <option value="M">MANTENIMIENTO Y REPUESTOS</option>
                          <option value="L">LLANTAS</option>
                          <option value="T">RTM</option>
                          <option value="1">DOCENTES</option>
                          <option value="2">SALA SIG.</option>
                          <option value="3">LICENCIA ARGUIS</option>
                          <option value="4">IMPRESORAS Y SUMINISTROS</option>
			  <option value="5">ADQUISICIÓN EQUIPOS DE COMPUTO</option> 	
                        </select>
                      </div>
                      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label><font face="Verdana" size="2">Valor</font></label>
                        <input type="text" name="valor" id="valor" class="form-control numero" value="0.00" onkeyup="paso_valor();" tabindex="3">
                        <input type="hidden" name="valor1" id="valor1" class="form-control numero" value="0" readonly="readonly" tabindex="4">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <label><font face="Verdana" size="2">Objeto Contractual</font></label>
                        <textarea name="objeto" id="objeto" class="form-control" rows="5" onblur="val_caracteres('objeto');" tabindex="5"></textarea>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                        <label><font face="Verdana" size="2">Supervisor</font></label>
                        <input type="text" name="supervisor" id="supervisor" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="6" autocomplete="off">
                      </div>
                      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label><font face="Verdana" size="2">NIT del Proveedor</font></label>
                        <input type="text" name="nit" id="nit" class="form-control" value="" onkeypress="return check2(event);" maxlength="13" tabindex="7" autocomplete="off">
                      </div>


                      <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                        <label><font face="Verdana" size="2">Nombre del Proveedor</font></label>
                        <input type="text" name="proveedor" id="proveedor" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="8" autocomplete="off">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label><font face="Verdana" size="2">Plazo Ejecuci&oacute;n</font></label>
                        <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="9">
                      </div>
                      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label><font face="Verdana" size="2">&nbsp;</font></label>
                        <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="10">
                      </div>
                      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label><font face="Verdana" size="2">CRP</font></label>
                        <select name="crp" id="crp" class="form-control select2" tabindex="11"></select>
                      </div>
                      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        <label><font face="Verdana" size="2">CDP</font></label>
                        <select name="cdp" id="cdp" class="form-control select2" tabindex="12"></select>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <center>
                          <input type="button" name="aceptar" id="aceptar" value="Registrar" tabindex="16">
                          <input type="button" name="aceptar1" id="aceptar1" value="Actualizar" tabindex="17">
                        </center>
                      </div>
                    </div>
                  </td>
                  <td width="1%"></td>
                  <td width="35%" valign="top">
                    <div class="row">
                      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <div id="add_form">
                          <table width="100%" align="center" border="0">
                            <tr>
                              <td colspan="3">
                                <center>
                                  <label><font face="Verdana" size="2">Distribuci&oacute;n Valor Contrato</font></label>
                                </center>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="45%">
                                <label><font face="Verdana" size="2">Unidad</font></label>
                              </td>
                              <td width="45%">
                                <label><font face="Verdana" size="2">Valor</font></label>
                              </td>
                              <td width="10%">
                                &nbsp;
                              </td>
                            </tr>
                          </table>
                        </div>
                        <div class="espacio1"></div>
                        <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0" tabindex="13"></a>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <table width="100%" align="center" border="0">
                          <tr>
                            <td width="45%">
                              &nbsp;
                            </td>
                            <td width="45%">
                              <label><font face="Verdana" size="2">Total</font></label>
                              <input type="text" name="total1" id="total1"  class="form-control numero" value="0.00" readonly="readonly" tabindex="14">
                              <input type="hidden" name="total2" id="total2" class="form-control numero" value="0" readonly="readonly" tabindex="15">
                            </td>
                            <td width="10%">
                              &nbsp;
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </form>
            <br>
            <div id="res_contrato"></div>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="js/jquery.quicksearch.js?1.0.0" type="text/javascript"></script>
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
    changeMonth: true,
    onSelect: function () {
      $("#fecha2").prop("disabled", false);
      $("#fecha2").datepicker("destroy");
      $("#fecha2").val('');
      $("#fecha2").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha1").val(),
        changeYear: true,
        changeMonth: true
      });
    },
  });
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 310,
    width: 550,
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
  $("#soportes").accordion({
    heightStyle: "content"
  });
  trae_crp();
  trae_cdp();
  trae_unidades();
  $("#cdp").prop("disabled",true);
  $("#crp").change(busca);
  $("#valor").maskMoney();
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  var MaxInputs       = 99;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    var paso = $("#paso").val();
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      FieldCount++;
      if (z == "1")
      {
        $("#add_form table").append('<tr><td width="45%" class="espacio1"><select name="uni_'+z+'" id="uni_'+z+'" class="form-control"></select></td><td width="45%" class="espacio2"><input type="text" name="val_'+z+'" id="val_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_valor1('+z+'); calculo()" autocomplete="off"><input type="hidden" name="vap_'+z+'" id="vap_'+z+'" class="form-control numero" value="0" readonly="readonly"></td><td width="10%">&nbsp;</td></tr>');
      }
      else
      {
        $("#add_form table").append('<tr><td width="45%" class="espacio1"><select name="uni_'+z+'" id="uni_'+z+'" class="form-control"></select></td><td width="45%" class="espacio2"><input type="text" name="val_'+z+'" id="val_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_valor1('+z+'); calculo()" autocomplete="off"><input type="hidden" name="vap_'+z+'" id="vap_'+z+'" class="form-control numero" value="0" readonly="readonly"></td><td width="10%"><div id="men_'+z+'"><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      }
      $("#uni_"+z).select2({
        tags: false,
        allowClear: false,
        closeOnSelect: true
      });
      $("#uni_"+z).append(paso);
      $("#val_"+z).maskMoney();
      $("#val_"+z).on("paste", function(e){
        e.preventDefault();
        alerta("Acción No Permitida");
      });
      $("#uni_"+z).focus();
      x_1++;
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    if(x_1 > 1)
    {
      $(this).closest('tr').remove();
      calculo()
    }
    return false;
  });
  consulta();
  $("#add_field").hide();
  $("#aceptar").hide();
  $("#aceptar1").hide();
  $("#numero").focus();
});
function trae_crp()
{
  $("#crp").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_crps.php",
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
      $("#crp").append(salida);
      busca();
    }    
  });
}
function trae_cdp()
{
  $("#cdp").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cdps1.php",
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
      $("#cdp").append(salida);
      busca();
    }
  });
}
function busca()
{
  var crp = $("#crp").val();
  var crp1 = $("#crp option:selected").html();
  if ((crp === null) || (crp1 === undefined))
  {
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_cdps2.php",
      data:
      {
        crp: crp,
        crp1: crp1
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        var conse = registros.conse;
        var cdp = registros.cdp;
        $("#cdp").val(conse);
      }
    });
  }
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
      salida += "<option value='0'>- SELECCIONAR -</option>";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#paso").val(salida);
    }
  });
}
function paso_valor()
{
  var valor = $("#valor").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valor1").val(valor);
  valor = parseFloat(valor);
  if (valor == "0")
  {
    $("#add_field").hide();
  }
  else
  {
    $("#add_field").show();
  }
}
function paso_valor1(valor)
{
  var valor, valor1;
  valor1 = document.getElementById('val_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vap_"+valor).val(valor1);
}
function calculo()
{
  var valor = 0;
  var valor1 = 0;
  var actualiza = $("#actu").val();
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vap_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      valor1 = valor1+valor;
    }
  }
  $("#total2").val(valor1);
  var valor2 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total1").val(valor2);
  var valor3 = $("#valor1").val();
  valor3 = parseFloat(valor3);
  valor1 = parseFloat(valor1);
  var valor4 = valor3-valor1;
  var valor5 = valor4.toFixed(2);
  valor5 = parseFloat(valor5);
  if (valor5 == "0")
  {
    if (actualiza == "0")
    {
      $("#aceptar").show();
      $("#aceptar1").hide();
    }
    else
    {
      $("#aceptar").hide();
      $("#aceptar1").show();
    }
  }
  else
  {
    $("#aceptar").hide();
    $("#aceptar1").hide();
  }
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
  var valor = $("#numero").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el No. del Contrato</h3></center>";
    $("#numero").addClass("ui-state-error");
  }
  else
  {
    $("#numero").removeClass("ui-state-error");
  }
  var valor1 = $("#fecha").val();
  if (valor1 == "")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Fecha del Contrato</h3></center>";
    $("#fecha").addClass("ui-state-error");
  }
  else
  {
    $("#fecha").removeClass("ui-state-error");
  }
  var valor2 = $("#valor1").val();
  if (valor2 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Valor del Contrato</h3></center>";
    $("#valor").addClass("ui-state-error");
  }
  else
  {
    $("#valor").removeClass("ui-state-error");
  }
  var valor3 = $("#objeto").val();
  valor3 = valor3.trim().length;
  if (valor3 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Objeto del Contrato</h3></center>";
    $("#objeto").addClass("ui-state-error");
  }
  else
  {
    $("#objeto").removeClass("ui-state-error");
  }
  var valor4 = $("#supervisor").val();
  valor4 = valor4.trim().length;
  if (valor4 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Supervisor del Contrato</h3></center>";
    $("#supervisor").addClass("ui-state-error");
  }
  else
  {
    $("#supervisor").removeClass("ui-state-error");
  }
  var valor8 = $("#nit").val();
  valor8 = valor8.trim().length;
  if (valor8 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el NIT del Proveedor</h3></center>";
    $("#nit").addClass("ui-state-error");
  }
  else
  {
    $("#nit").removeClass("ui-state-error");
  }
  var valor5 = $("#proveedor").val();
  valor5 = valor5.trim().length;
  if (valor5 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Nombre del Proveedor</h3></center>";
    $("#proveedor").addClass("ui-state-error");
  }
  else
  {
    $("#proveedor").removeClass("ui-state-error");
  }
  var valor6 = $("#fecha1").val();
  if (valor6 == "")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Fecha de Inicio</h3></center>";
    $("#fecha1").addClass("ui-state-error");
  }
  else
  {
    $("#fecha1").removeClass("ui-state-error");
  }
  var valor7 = $("#fecha2").val();
  if (valor7 == "")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Fecha de Termino</h3></center>";
    $("#fecha2").addClass("ui-state-error");
  }
  else
  {
    $("#fecha2").removeClass("ui-state-error");
  }
  var contador = 0;
  $("#paso1").val('');
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('uni_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (valor == "0")
      {
        contador++;
      }
    }
    saux1 = document.formu.elements[i].name;
    if (saux1.indexOf('val_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu.elements[i].name;
    if (saux2.indexOf('vap_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
      valor3 = valor+"»"+valor1+"»"+valor2;
      document.getElementById('paso1').value = document.getElementById('paso1').value+valor3+"|";
    }
  }
  if (contador > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar "+contador+" Unidades</h3></center>";    
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
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
      url: "cont_grab.php",
      data:
      {
        tipo: valor,
        conse: $("#conse").val(),
        contrato: $("#numero").val(),
        fecha: $("#fecha").val(),
        tipo1: $("#tipo").val(),
        valor: $("#valor").val(),
        valor1: $("#valor1").val(),
        objeto: $("#objeto").val(),
        supervisor: $("#supervisor").val(),
        nit: $("#nit").val(),
        proveedor: $("#proveedor").val(),
        fecha1: $("#fecha1").val(),
        fecha2: $("#fecha2").val(),
        crp: $("#crp").val(),
        cdp: $("#cdp").val(),
        datos: $("#paso1").val(),
        usuario: $("#v_usuario").val(),
        unidad: $("#v_unidad").val(),
        alea: $("#alea").val()
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
        var ano = registros.ano;
        if (salida == "1")
        {
          $("#aceptar").hide();
          $("#aceptar1").hide();
          $("#conse").val(consecu);
          $("#numero").prop("disabled",true);
          $("#fecha").prop("disabled",true);
          $("#tipo").prop("disabled",true);
          $("#valor").prop("disabled",true);
          $("#objeto").prop("disabled",true);
          $("#supervisor").prop("disabled",true);
          $("#nit").prop("disabled",true);
          $("#proveedor").prop("disabled",true);
          $("#fecha1").prop("disabled",true);
          $("#fecha2").prop("disabled",true);
          $("#crp").prop("disabled",true);
          $("#cdp").prop("disabled",true);
          for (i=0;i<document.formu.elements.length;i++)
          {
            saux = document.formu.elements[i].name;
            if (saux.indexOf('uni_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('val_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
          $("#add_field").hide();
          for (k=1;k<=50;k++)
          {
            $("#men_"+k).hide();
          }
          $("#actu").val('0');
          consulta();
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
function modif(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "cont_consu1.php",
    data:
    {
      conse: valor
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
      $("#soportes").accordion({active: 0});
      var registros = JSON.parse(data);
      $("#conse").val(valor);
      $("#numero").val(registros.numero);
      $("#fecha").val(registros.fecha);
      $("#tipo").val(registros.tipo);
      $("#valor").val(registros.valor);
      $("#valor1").val(registros.valor1);
      $("#objeto").val(registros.objeto);
      $("#supervisor").val(registros.supervisor);
      $("#nit").val(registros.nit);
      $("#proveedor").val(registros.proveedor);
      $("#fecha1").val(registros.fecha1);
      $("#fecha2").val(registros.fecha2);
      $("#crp").val(registros.crp);
      $("#cdp").val(registros.cdp);
      $("#alea").val(registros.alea);
      var con_unidades = 0;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('uni_')!=-1)
        {
          con_unidades ++;
        }
      }
      var datos = registros.datos;
      var var_ocu = datos.split('|');
      var var_ocu1 = var_ocu.length;
      var var_con = var_ocu1-1;
      var paso = "";
      var z = 2;
      for (var i=0; i<var_ocu1-1; i++)
      {
        paso = var_ocu[i];
        var var_ocu2 = paso.split('»');
        if (con_unidades > var_con)
        {
        }
        else
        {
          if (i < var_con)
          {
            $("#add_field").click();
          }
        }
        z = z+1;
        var v1 = var_ocu2[0];
        var v2 = var_ocu2[1];
        var v3 = var_ocu2[2];
        $("#uni_"+z).val(v1);
        $("#val_"+z).val(v2);
        $("#vap_"+z).val(v3);
        calculo();
      }
      $("#v_consu").val('1');
      $("#actu").val('1');
      $("#aceptar").hide();
      $("#aceptar1").show();
      consulta();
    }
  });
}
function consulta()
{
  var tipo = $("#v_consu").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "cont_consu.php",
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
      $("#res_contrato").html('');
      var registros = data;
      $("#res_contrato").append(registros);
    }
  });
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
  patron = /[0-9-.]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
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
function alerta1(valor)
{
  alertify.success(valor);
}
</script>
</body>
</html>
<?php
}
// 12/12/2023 - Ajuste nuevos tipos de contrato
// 19/12/2023 - Cambio de distribucion de colores en contratos
// 28/12/2023 - Ajuste en modificacion de contratos
// 24/05/2024 - Ajuste redondeo modificacion valores en sumatoria
// 16/01/2025 - Ajuste inclusion nuevos tipos de contratos (solo registro, sin control)
?>