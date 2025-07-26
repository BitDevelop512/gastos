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
          <h3>Registro Manual Recompensas</h3>
          <div>
            <div id="load">
              <center>
                <img src="dist/img/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Unidad Ejecutora</font></label>
                  <?php
                  $menu1_1 = odbc_exec($conexion,"SELECT unidad, sigla FROM cx_org_sub WHERE unic='1' ORDER BY sigla");
                  $menu1 = "<select name='unidad' id='unidad' class='form-control select2' onchange='busca();' tabindex='1'>";
                  $i = 1;
                  $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
                  while($i<$row=odbc_fetch_array($menu1_1))
                  {
                    $nombre = trim($row['sigla']);
                    $menu1 .= "\n<option value=$row[unidad]>".$nombre."</option>";
                    $i++;
                  }
                  $menu1.="\n</select>";
                  echo $menu1;
                  ?>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Batall&oacute;n</font></label>
                  <select name="batallon" id="batallon" class="form-control select2" tabindex="2">
                    <option value="-">- SELECCIONAR -</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Periodo</font></label>
                  <select name="periodo" id="periodo" class="form-control select2" tabindex="3">
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
                  <label><font face="Verdana" size="2">Año</font></label>
                  <select name="ano" id="ano" class="form-control select2" tabindex="4"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Valor</font></label>
                  <input type="text" name="valor" id="valor" class="form-control numero" value="0.00" onkeyup="paso_val();" tabindex="5" autocomplete="off">
                  <input type="hidden" name="valor1" id="valor1" class="form-control numero" value="0" tabindex="6">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Resumen</font></label>
                  <textarea name="resumen" id="resumen" class="form-control" rows="4" tabindex="7"></textarea>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">N&uacute;mero Acta</font></label>
                  <input type="text" name="numero" id="numero" class="form-control numero" value="0" onblur="val_numero('numero');" tabindex="8" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha Acta</font></label>
                  <input type="text" name="fecha" id="fecha" placeholder="dd/mm/yy" class="form-control fecha" readonly="readonly" tabindex="9" />
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">ORDOP</font></label>
                  <input type="text" name="ordop" id="ordop" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="10" autocomplete="off">
                </div>
              </div>

              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <div id="add_form">
                    <table width="100%" align="center" border="0">
                      <tr>
                        <td width="10%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">C&eacute;dula</font></label>
                        </td>
                        <td width="20%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">Nombre Fuente</font></label>
                        </td>
                        <td width="10%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">Pago %</font></label>
                        </td>
                        <td width="8%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">Anexar</font></label>
                        </td>
                        <td width="10%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">Acta Pago Inf.</font></label>
                        </td>
                        <td width="14%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">Fecha Pago Inf.</font></label>
                        </td>
                        <td width="15%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">Valor Pago Inf.</font></label>
                        </td>
                        <td width="8%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">Anexar</font></label>
                        </td>
                        <td width="5%" height="25" valign="bottom">
                          &nbsp;
                        </td>
                      </tr>
                    </table>
                  </div>
                  <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0"></a>
                  <br>
                  <table width="100%" align="center" border="0">
                    <tr>
                      <td width="10%" height="25" valign="bottom" align="center">&nbsp;</td>
                      <td width="20%" height="25" align="right">
                        <label><font face="Verdana" size="2">Suma Porcentajes:&nbsp;&nbsp;&nbsp;</font></label>
                      </td>
                      <td width="10%" height="25" class="espacio2" valign="bottom" align="center">
                        <input type="text" name="porcentaje" id="porcentaje" class="form-control numero" value="0" readonly="readonly">
                      </td>
                      <td width="8%" height="25" valign="bottom" align="center">&nbsp;</td>
                      <td width="24%" height="25" align="right">
                        <label><font face="Verdana" size="2">Suma Total Pagos:&nbsp;&nbsp;&nbsp;</font></label>
                      </td>
                      <td width="15%" height="25" class="espacio2" valign="bottom" align="center">
                        <input type="text" name="pagos" id="pagos" class="form-control numero" value="0" readonly="readonly">
                      </td>
                      <td width="13%" height="25" valign="bottom" align="center">&nbsp;</td>
                    </tr>
                  </table>
                  <input type="hidden" name="cedulas" id="cedulas" class="form-control" readonly="readonly">
                  <input type="hidden" name="nombres" id="nombres" class="form-control" readonly="readonly">
                  <input type="hidden" name="porcentajes" id="porcentajes" class="form-control" readonly="readonly">
                  <input type="hidden" name="porcentajes1" id="porcentajes1" class="form-control" readonly="readonly">
                  <input type="hidden" name="actas" id="actas" class="form-control" readonly="readonly">
                  <input type="hidden" name="fechas" id="fechas" class="form-control" readonly="readonly">
                  <input type="hidden" name="valores" id="valores" class="form-control" readonly="readonly">
                  <input type="hidden" name="valores1" id="valores1" class="form-control" readonly="readonly">
                  <input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <center>
                    <input type="button" name="aceptar" id="aceptar" value="Continuar" tabindex="10">
                  </center>
                </div>
              </div>
            </form>
          </div>
          <div id="dialogo"></div>
          <div id="dialogo1"></div>
          <div id="dialogo2"></div>
          <div id="dialogo6"></div>
          <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
          <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
          <input type="hidden" name="v_ciudad" id="v_ciudad" class="form-control" value="<?php echo $ciu_usuario; ?>" readonly="readonly" tabindex="0">
        </div>
      </div>
    </section>
</div>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
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
  $("#load").hide();
  $("#fecha").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
  });
  $("#boton1").click(recarga);
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 340,
    width: 420,
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
    height: 170,
    width: 450,
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
        valida();
      },
      "Cancelar": function() {
        $( this ).dialog( "close" );
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
    width: 600,
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
  $("#dialogo6").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 180,
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
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#unidad").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#valor").maskMoney();
  $("#aceptar").button();
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").click(pregunta);
  var MaxInputs       = 99;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      FieldCount++;
      if (z == "1")
      {
        $("#add_form table").append('<tr><td width="10%" class="espacio2"><input type="text" name="ced_'+z+'" id="ced_'+z+'" class="form-control" onkeypress="return check3(event);" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="15" autocomplete="off"></td><td width="20%" class="espacio2"><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" autocomplete="off"></td><td width="10%" class="espacio2"><input type="text" name="por_'+z+'" id="por_'+z+'" class="form-control numero" value="0.000" onblur="paso_val1('+z+');" onkeypress="return check(event);"><input type="hidden" name="pot_'+z+'" id="pot_'+z+'" class="form-control numero" value="0"></td><td width="8%" class="espacio2"><center><a href="#" name="lnk_'+z+'" id="lnk_'+z+'" onclick="subir('+z+');"><img src="imagenes/clip.png" border="0" title="Anexar C&eacute;dula"></a></center></td><td width="10%" class="espacio2"><input type="text" name="act_'+z+'" id="act_'+z+'" class="form-control numero" value="0" onkeypress="return check1(event);" onblur="cero('+z+');" maxlength="25" autocomplete="off"></td><td width="14%" class="espacio2"><input type="text" name="fep_'+z+'" id="fep_'+z+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td width="15%" class="espacio2"><input type="text" name="val_'+z+'" id="val_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_val3('+z+');"><input type="hidden" name="vat_'+z+'" id="vat_'+z+'" class="form-control numero" value="0"><input type="hidden" name="vam_'+z+'" id="vam_'+z+'" class="form-control numero" value="0"></td><td width="8%" class="espacio2"><center><a href="#" name="lnk1_'+z+'" id="lnk1_'+z+'" onclick="subir1('+z+');"><img src="imagenes/clip.png" border="0" title="Anexar Acta Pago"></a></center></td><td width="5%" class="espacio2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>');
      }
      else
      {
        $("#add_form table").append('<tr><td width="10%" class="espacio2"><input type="text" name="ced_'+z+'" id="ced_'+z+'" class="form-control" onkeypress="return check3(event);"  onchange="javascript:this.value=this.value.toUpperCase();" maxlength="15" autocomplete="off"></td><td width="20%" class="espacio2"><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" autocomplete="off"></td><td width="10%" class="espacio2"><input type="text" name="por_'+z+'" id="por_'+z+'" class="form-control numero" value="0.000" onblur="paso_val1('+z+');" onkeypress="return check(event);"><input type="hidden" name="pot_'+z+'" id="pot_'+z+'" class="form-control numero" value="0"></td><td width="8%" class="espacio2"><center><a href="#" name="lnk_'+z+'" id="lnk_'+z+'" onclick="subir('+z+');"><img src="imagenes/clip.png" border="0" title="Anexar C&eacute;dula"></a></center></td><td width="10%" class="espacio2"><input type="text" name="act_'+z+'" id="act_'+z+'" class="form-control numero" value="0" onkeypress="return check1(event);" onblur="cero('+z+');" maxlength="25" autocomplete="off"></td><td width="14%" class="espacio2"><input type="text" name="fep_'+z+'" id="fep_'+z+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td width="15%" class="espacio2"><input type="text" name="val_'+z+'" id="val_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_val3('+z+');"><input type="hidden" name="vat_'+z+'" id="vat_'+z+'" class="form-control numero" value="0"><input type="hidden" name="vam_'+z+'" id="vam_'+z+'" class="form-control numero" value="0"></td><td width="8%" class="espacio2"><center><a href="#" name="lnk1_'+z+'" id="lnk1_'+z+'" onclick="subir1('+z+');"><img src="imagenes/clip.png" border="0" title="Anexar Acta Pago"></a></center></td><td width="5%" class="espacio2"><div id="men_'+z+'"><center><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></center></div></td></tr>');
      }
      $("#fep_"+z).datepicker({
        dateFormat: "yy/mm/dd",
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
      $("#val_"+z).maskMoney();
      x_1++;
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    if(x_1 > 1)
    {
      $(this).closest('tr').remove();
      suma();
    }
    return false;
  })
  trae_ano();
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
function busca()
{
  var centra = $("#unidad").val();
  var sigla = $("#unidad option:selected").html();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unidad1.php",
    data:
    {
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
      trae_unidades(paso);
    }
  });
}
function trae_unidades(valor)
{
  var valor;
  $("#batallon").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unidades.php",
    data:
    {
      unidades: valor
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
      $("#batallon").append(salida);
    }
  });
}
function paso_val()
{
  var valor;
  valor = document.getElementById('valor').value;
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valor1").val(valor);
}
function val_numero(valor)
{
  var valor;
  var valor1 = $("#"+valor);
  valor1.removeClass("ui-state-error");
  var valor2 = valor1.val().trim().length;
  if (valor2 == '0')
  {
    $("#"+valor).val('0');
  }
  else
  {
    var allFields = $([]).add(valor1);
    var valid = true;
    valid = checkRegexp(valor1, /^([0-9])+$/, "Solo se premite caracteres: 0 - 9");
  }
}
function checkRegexp(o, regexp, n)
{
  if (!(regexp.test(o.val())))
  {
    o.addClass("ui-state-error");
    $("#dialogo").html(n);
    $("#dialogo").dialog("open");
    return false;
  }
  else
  {
    return true;
  }
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function valida()
{
  var salida = true, detalle = '';
  if ($("#batallon").val() == '-')
  {
    salida = false;
    detalle += "Debe seleccionar un Batallón<br><br>";
  }
  if ($("#valor1").val() == '0')
  {
    salida = false;
    detalle += "Valor de Recompensa No Valido<br><br>";
  }
  if ($("#resumen").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar un Resumen del Registro<br><br>";
  }
  if ($("#numero").val() == '0')
  {
    salida = false;
    detalle += "Debe ingresar un Número de Acta<br><br>";
  }
  if ($("#fecha").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar una Fecha de Acta<br><br>";
  }
  var v_cedulas = 0;
  var valor;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('ced_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_cedulas ++;
      }
    }
  }
  if (v_cedulas > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+v_cedulas+" Número(s) de Cedula(s)<br><br>";
  }
  var v_nombres = 0;
  var valor;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_nombres ++;
      }
    }
  }
  if (v_nombres > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+v_nombres+" Nombre(s) de Fuente(s)<br><br>";
  }
  if ($("#porcentaje").val() == '100.000')
  {
  }
  else
  {
    salida = false;
    detalle += "Suma de Porcentajes de Fuentes No es igual al 100%<br><br>";
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
function nuevo()
{
  var v_cedulas = 0;
  var valor;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('ced_')!=-1)
    {
      v_cedulas ++;
    }
  }
  document.getElementById('cedulas').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('ced_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('cedulas').value = document.getElementById('cedulas').value+valor+"|";
    }
  }
  document.getElementById('nombres').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('nombres').value = document.getElementById('nombres').value+valor+"|";
    }
  }
  document.getElementById('porcentajes').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('por_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('porcentajes').value = document.getElementById('porcentajes').value+valor+"|";
    }
  }
  document.getElementById('porcentajes1').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('pot_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('porcentajes1').value = document.getElementById('porcentajes1').value+valor+"|";
    }
  }
  document.getElementById('actas').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('act_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('actas').value = document.getElementById('actas').value+valor+"|";
    }
  }
  document.getElementById('fechas').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('fep_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('fechas').value = document.getElementById('fechas').value+valor+"|";
    }
  }
  document.getElementById('valores').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('val_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('valores').value = document.getElementById('valores').value+valor+"|";
    }
  }
  document.getElementById('valores1').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vat_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('valores1').value = document.getElementById('valores1').value+valor+"|";
    }
  }
  var resumen = $("#resumen").val();
  resumen = resumen.replace(/[•]+/g, "*");
  resumen = resumen.replace(/[●]+/g, "*");
  resumen = resumen.replace(/[é́]+/g, "é");
  resumen = resumen.replace(/[]+/g, "*");
  resumen = resumen.replace(/[]+/g, "*");
  resumen = resumen.replace(/[]+/g, "*");
  resumen = resumen.replace(/[ ]+/g, " ");
  resumen = resumen.replace(/[ ]+/g, '');
  resumen = resumen.replace(/[–]+/g, "-");
  resumen = resumen.replace(/[—]+/g, '-');
  resumen = resumen.replace(/[…]+/g, "..."); 
  resumen = resumen.replace(/[“”]+/g, '"');
  resumen = resumen.replace(/[‘]+/g, '´');
  resumen = resumen.replace(/[’]+/g, '´');
  resumen = resumen.replace(/[′]+/g, '´');
  resumen = resumen.replace(/[']+/g, '´');
  resumen = resumen.replace(/[™]+/g, '');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_grab2.php",
    data:
    {
      centra: $("#unidad").val(),
      batallon: $("#batallon").val(),
      sigla: $("#batallon option:selected").html(),
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
      valor: $("#valor").val(),
      valor1: $("#valor1").val(),
      resumen: resumen,
      numero: $("#numero").val(),
      fecha: $("#fecha").val(),
      ordop: $("#ordop").val(),
      cedulas: $("#cedulas").val(),
      nombres: $("#nombres").val(),
      porcentajes: $("#porcentajes").val(),
      porcentajes1: $("#porcentajes1").val(),
      actas: $("#actas").val(),
      fechas: $("#fechas").val(),
      valores: $("#valores").val(),
      valores1: $("#valores1").val(),
      informantes: v_cedulas,
      alea: $("#alea").val(),
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
      var valida, valida1;
      valida = registros.salida;
      if (valida > 0)
      {
        $("#aceptar").hide();
        $("#unidad").prop("disabled",true);
        $("#batallon").prop("disabled",true);
        $("#periodo").prop("disabled",true);
        $("#ano").prop("disabled",true);
        $("#valor").prop("disabled",true);
        $("#resumen").prop("disabled",true);
        $("#numero").prop("disabled",true);
        $("#fecha").prop("disabled",true);
        $("#ordop").prop("disabled",true);
        for (i=0;i<document.formu.elements.length;i++)
        {
          saux = document.formu.elements[i].name;
          if (saux.indexOf('ced_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('nom_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('por_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('act_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('fep_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('val_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        for (j=1; j<=10; j++)
        {
          $("#lnk_"+j).hide();
          $("#lnk1_"+j).hide();
          $("#men_"+j).hide();
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
// Pasa valor de pagos a fuentes
function paso_val3(valor)
{
  var valor;
  var valor1;
  var valor2;
  var valor3;
  var valor4;
  var valor5;
  valor1 = document.getElementById('val_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vat_"+valor).val(valor1);
  valor2 = $("#vat_"+valor).val();
  valor3 = $("#vam_"+valor).val();
  valor3 = parseFloat(valor3);
  valor4 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  valor5 = $("#val_"+valor).val();
  if (valor2 > valor3)
  {
    $("#aceptar").hide();
    var detalle = "<br><center>Valor Pago "+valor5+" superior<br>al Valor del Porcentaje Asignado "+valor4+"</center>";
    $("#dialogo6").html(detalle);
    $("#dialogo6").dialog("open");
    $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#aceptar").show();
    suma1();
  }
}
// Suma porcentajes de las fuentes para validar el 100 %
function suma()
{
  var valor;
  var valor1;
  valor = 0;
  valor1 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('pot_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      valor1 = valor1+valor;
    }
  }
  valor1 = valor1.toFixed(3).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#porcentaje").val(valor1);
}
// Suma pagos a fuentes
function suma1()
{
  var valor;
  var valor1;
  var valor2;
  var valor3;
  var valor4;
  valor = 0;
  valor1 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vat_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      valor1 = valor1+valor;
    }
  }
  valor2 = valor1;
  valor1 = valor1.toFixed(3).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#pagos").val(valor1);
  valor3 = $("#valor1").val();
  valor4 = $("#valor").val();
  if (valor2 > valor3)
  {
    $("#aceptar").hide();
    var detalle = "<br><center>Suma Total de Pagos "+valor1+"<br>superior al Valor Solicitado "+valor4+"</center>";
    $("#dialogo6").html(detalle);
    $("#dialogo6").dialog("open");
    $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#aceptar").show();
  }
}
function subir(valor)
{
  var valor;
  var alea = $("#alea").val();
  var cedula = $("#ced_"+valor).val();
  cedula = cedula.trim();
  var valida = 0;
  if (cedula == "")
  {
    valida = 0;
    var detalle = "<center><h3>Cédula de Fuente No Registrada,<br>no se permite adjuntar imagen</h3></center>";
    $("#dialogo2").html(detalle);
    $("#dialogo2").dialog("open");
    $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    valida = 1;
    var url = "<a href='./subir1.php?alea="+alea+"&conse="+valor+"&cedula="+cedula+"&valida="+valida+"' name='link1' id='link1' class='pantalla-modal'>Link</a>";
    $("#link").hide();
    $("#link").html('');
    $("#link").append(url);
    $(".pantalla-modal").magnificPopup({
      type: 'iframe',
      preloader: false,
      modal: false
    });
    $("#link1").click();
    $("#ced_"+valor).prop("disabled",true);
    $("html,body").animate({ scrollTop: 9999 }, "slow");
  }
}
function subir1(valor)
{
  var valor;
  var alea = $("#alea").val();
  var cedula = $("#ced_"+valor).val();
  cedula = cedula.trim();
  var acta = $("#act_"+valor).val();
  acta = acta.trim();
  if ((acta == "0") || (acta == ""))
  {
    valida = 0;
    var detalle = "<center><h3>Acta de Pago Previo No Registrada,<br>no se permite adjuntar imagen</h3></center>";
    $("#dialogo2").html(detalle);
    $("#dialogo2").dialog("open");
    $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    valida = 1;
    var url = "<a href='./subir2.php?alea="+alea+"&conse="+valor+"&cedula="+cedula+"&acta="+acta+"&valida="+valida+"' name='link2' id='link2' class='pantalla-modal'>Link</a>";
    $("#link").hide();
    $("#link").html('');
    $("#link").append(url);
    $(".pantalla-modal").magnificPopup({
      type: 'iframe',
      preloader: false,
      modal: false
    });
    $("#link2").click();
    $("#act_"+valor).prop("disabled",true);
    $("html,body").animate({ scrollTop: 9999 }, "slow");
  }
}
function cero(valor)
{
  var valor;
  var valor1 = $("#act_"+valor);
  var valor2 = valor1.val().trim().length;
  if (valor2 == '0')
  {
    $("#act_"+valor).val('0');
  }
}
// Pasa valor de porcentajes de fuentes
function paso_val1(valor)
{
  var valor;
  var valor1;
  var valor2;
  valor1 = document.getElementById('por_'+valor).value;
  valor2 = $("#valor1").val();
  if ($.isNumeric(valor1))
  {
    var value = parseFloat(valor1).toFixed(3);
    $("#por_"+valor).val(value);
  }
  else
  {
    $("#por_"+valor).val('0.000');
  }
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#pot_"+valor).val(valor1);
  var porcentaje = valor1/100;
  var maximo = valor2*porcentaje;
  $("#vam_"+valor).val(maximo);
  suma();
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
  patron = /[0-9]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function check3(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9kK]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function recarga()
{
  location.reload();
}
</script>
</body>
</html>
<?php
}
?>