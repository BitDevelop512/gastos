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
  $mes = intval($mes);
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
          <h3>Conciliaci&oacute;n Bancaria</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Periodo</font></label>
                  <select name="periodo" id="periodo" class="form-control select2" tabindex="1">
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
                  <select name="ano" id="ano" class="form-control select2" tabindex="2"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Cuenta Bancaria</font></label>
                  <select name="cuenta" id="cuenta" class="form-control select2" tabindex="3"></select>
                </div>
                <div id="lbl1">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Unidad</font></label>
                    <?php
                    $menu1_1 = odbc_exec($conexion,"SELECT subdependencia, sigla FROM cx_org_sub WHERE unic='1' AND subdependencia!='301' ORDER BY sigla");
                    $menu1 = "<select name='unidad1' id='unidad1' class='form-control select2'>";
                    $i = 1;
                    $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
                    while($i<$row=odbc_fetch_array($menu1_1))
                    {
                      $nombre = trim($row['sigla']);
                      $menu1 .= "\n<option value=$row[subdependencia]>".$nombre."</option>";
                      $i++;
                    }
                    $menu1 .= "\n</select>";
                    echo $menu1;
                    ?>
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <br>
                    <a href="#" onclick="borrar(); return false;">
                      <img src="dist/img/delete.png" name="eliminar" id="eliminar" width="35" height="35" border="0" title="Eliminar PDF">
                    </a>
                    <input type="hidden" name="archivo" id="archivo" class="form-control" value="" readonly="readonly">
                  </div>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                    <input type="button" name="aceptar" id="aceptar" value="Consultar" tabindex="4">
                </div>
              </div>
            </form>
            <br>
            <div id="res_conc"></div>
            <form name="formu2" method="post">
              <div id="t_debito">
                <div id="add_form">
                  <table width="65%" align="center" border="1">
                    <tr>
                      <td bgcolor="#999999" height="35" width="20%"><center><b>Fecha</b></center></td>
                      <td bgcolor="#999999" height="35" width="20%"><center><b>No.</b></center></td>
                      <td bgcolor="#999999" height="35" width="30%"><center><b>Nota Debito</b></center></td>
                      <td bgcolor="#999999" height="35" width="20%"><center><b>Valor</b></center></td>
                      <td bgcolor="#999999" height="35" width="10%">&nbsp;</td>
                    </tr>
                  </table>
                </div>
              </div>
              <br>
              <div id="t_debito1">
                <table width="65%" align="center" border="0">
                  <tr>
                    <td>
                      <center><a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0"></a></center>
                    </td>
                  </tr>
                </table>
                <table width="65%" align="center" border="0">
                  <tr>
                    <td height="35" width="20%">&nbsp;</td>
                    <td height="35" width="20%">&nbsp;</td>
                    <td height="35" width="30%" align="right" class="espacio2"><b>Suman:</b></td>
                    <td height="35" width="20%" class="espacio2"><input type="text" name="t_deb" id="t_deb" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly"><input type="hidden" name="t_deb1" id="t_deb1" class="form-control numero" value="0" readonly="readonly"></td>
                    <td height="35" width="10%">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </form>
            <br>
            <form name="formu3" method="post">
              <div id="t_credito">
                <div id="add_form1">
                  <table width="65%" align="center" border="1">
                    <tr>
                      <td bgcolor="#cccccc" height="35" width="20%"><center><b>Fecha</b></center></td>
                      <td bgcolor="#cccccc" height="35" width="20%"><center><b>No.</b></center></td>
                      <td bgcolor="#cccccc" height="35" width="30%"><center><b>Nota Credito</b></center></td>
                      <td bgcolor="#cccccc" height="35" width="20%"><center><b>Valor</b></center></td>
                      <td bgcolor="#cccccc" height="35" width="10%">&nbsp;</td>
                    </tr>
                  </table>
                </div>
              </div>
              <br>
              <div id="t_credito1">
                <table width="65%" align="center" border="0">
                  <tr>
                    <td>
                      <center><a href="#" name="add_field1" id="add_field1"><img src="imagenes/boton1.jpg" border="0"></a></center>
                    </td>
                  </tr>
                </table>
                <table width="65%" align="center" border="0">
                  <tr>
                    <td height="35" width="20%">&nbsp;</td>
                    <td height="35" width="20%">&nbsp;</td>
                    <td height="35" width="30%" align="right" class="espacio2"><b>Suman:</b></td>
                    <td height="35" width="20%" class="espacio2"><input type="text" name="t_cre" id="t_cre" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly"><input type="hidden" name="t_cre1" id="t_cre1" class="form-control numero" value="0" readonly="readonly"></td>
                    <td height="35" width="10%">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </form>
            <br>
            <form name="formu4" method="post">
              <div id="t_cheques">
                <div id="add_form2">
                  <table width="65%" align="center" border="1">
                    <tr>
                      <td bgcolor="#ada3a3" height="35" width="20%"><center><b>Fecha</b></center></td>
                      <td bgcolor="#ada3a3" height="35" width="20%"><center><b>No.</b></center></td>
                      <td bgcolor="#ada3a3" height="35" width="30%"><center><b>Beneficiario</b></center></td>
                      <td bgcolor="#ada3a3" height="35" width="20%"><center><b>Valor</b></center></td>
                      <td bgcolor="#ada3a3" height="35" width="10%">&nbsp;</td>
                    </tr>
                  </table>
                </div>
              </div>
              <br>
              <div id="t_cheques1">
                <table width="65%" align="center" border="0">
                  <tr>
                    <td>
                      <center><a href="#" name="add_field2" id="add_field2"><img src="imagenes/boton1.jpg" border="0"></a></center>
                    </td>
                  </tr>
                </table>
                <table width="65%" align="center" border="0">
                  <tr>
                    <td height="35" width="20%">&nbsp;</td>
                    <td height="35" width="20%">&nbsp;</td>
                    <td height="35" width="30%" align="right" class="espacio2"><b>Suman:</b></td>
                    <td height="35" width="20%" class="espacio2"><input type="text" name="t_che" id="t_che" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly"><input type="hidden" name="t_che1" id="t_che1" class="form-control numero" value="0" readonly="readonly"></td>
                    <td height="35" width="10%">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </form>
            <form name="formu5" action="ver_concilia.php" method="post" target="_blank">
              <input type="hidden" name="giro_uni" id="giro_uni" value="<?php echo $uni_usuario; ?>" readonly="readonly">
              <input type="hidden" name="giro_per" id="giro_per" readonly="readonly">
              <input type="hidden" name="giro_ano" id="giro_ano" readonly="readonly">
              <input type="hidden" name="giro_cue" id="giro_cue" readonly="readonly">
              <input type="hidden" name="giro_sig" id="giro_sig" readonly="readonly">
            </form>
            <div id="res_conc1"></div>
          </div>
        </div>
      </div>
      <div id="valores">
        <input type="hidden" name="v_paso" id="v_paso" class="form-control" readonly="readonly">
        <input type="hidden" name="v_paso1" id="v_paso1" class="form-control" readonly="readonly">
        <input type="hidden" name="v_paso2" id="v_paso2" class="form-control" readonly="readonly">
        <input type="hidden" name="v_paso3" id="v_paso3" class="form-control" readonly="readonly">
        <input type="hidden" name="v_paso4" id="v_paso4" class="form-control" readonly="readonly">
        <input type="hidden" name="v_paso5" id="v_paso5" class="form-control" readonly="readonly">
        <input type="hidden" name="v_paso6" id="v_paso6" class="form-control" readonly="readonly">
        <input type="hidden" name="v_paso7" id="v_paso7" class="form-control" readonly="readonly">
        <input type="hidden" name="v_paso8" id="v_paso8" class="form-control" readonly="readonly">
        <input type="hidden" name="v_paso9" id="v_paso9" class="form-control" readonly="readonly">
        <input type="hidden" name="v_paso10" id="v_paso10" class="form-control" readonly="readonly">
        <input type="hidden" name="v_paso11" id="v_paso11" class="form-control" readonly="readonly">
        <input type="hidden" name="v_deb" id="v_deb" class="form-control" readonly="readonly">
        <input type="hidden" name="v_cre" id="v_cre" class="form-control" readonly="readonly">
        <input type="hidden" name="v_che" id="v_che" class="form-control" readonly="readonly">
        <input type="hidden" name="v_super" id="v_super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly">
        <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly">
        <input type="hidden" name="v_sigla" id="v_sigla" class="form-control" value="<?php echo $sig_usuario; ?>" readonly="readonly">
      </div>
      <div id="dialogo"></div>
      <div id="dialogo1"></div>
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
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 220,
    width: 440,
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
        $( this ).dialog( "close" );
        validacionData();
      },
      Cancelar: function() {
        $( this ).dialog( "close" );
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(consulta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
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
        $("#add_form table").append('<tr><td height="35" class="espacio2"><input type="text" name="fec_'+z+'" id="fec_'+z+'" class="form-control fecha" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly"></td><td height="35" class="espacio2"><input type="text" name="num_'+z+'" id="num_'+z+'" class="form-control numero" value="0"></td><td height="35" class="espacio2"><input type="text" name="not_'+z+'" id="not_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" autocomplete="off"></td><td height="35" class="espacio2"><input type="text" name="vag_'+z+'" id="vag_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_val7('+z+');"><input type="hidden" name="vat_'+z+'" id="vat_'+z+'" class="form-control numero" value="0"></td><td width="10%">&nbsp;</td></tr>');
      }
      else
      {
        $("#add_form table").append('<tr><td height="35" class="espacio2"><input type="text" name="fec_'+z+'" id="fec_'+z+'" class="form-control fecha" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly"></td><td height="35" class="espacio2"><input type="text" name="num_'+z+'" id="num_'+z+'" class="form-control numero" value="0"></td><td height="35" class="espacio2"><input type="text" name="not_'+z+'" id="not_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" autocomplete="off"></td><td height="35" class="espacio2"><input type="text" name="vag_'+z+'" id="vag_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_val7('+z+');"><input type="hidden" name="vat_'+z+'" id="vat_'+z+'" class="form-control numero" value="0"></td><td width="10%"><div id="del_'+z+'"><a href="#" onclick="borra('+z+')"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      }
      $("#fec_"+z).datepicker({
        dateFormat: "yy/mm/dd",
        maxDate: 0,
        changeYear: true,
        changeMonth: true,
        onSelect: function () {
          $("#num_"+z).focus();
        }
      });
      x_1++;
      $("#vag_"+z).maskMoney();
      $('html,body').animate({ scrollTop: 9999 }, 'slow');
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
  var InputsWrapper1   = $("#add_form1 table tr");
  var AddButton1       = $("#add_field1");
  var y_1              = InputsWrapper1.length;
  var FieldCount1      = 1;
  $(AddButton1).click(function (e) {
    if(y_1 <= MaxInputs)
    {
      var w = y_1;
      FieldCount1++;
      if (w == "1")
      {
        $("#add_form1 table").append('<tr><td height="35" class="espacio2"><input type="text" class="form-control fecha" name="fec1_'+w+'" id="fec1_'+w+'" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly"></td><td height="35" class="espacio2"><input type="text" name="num1_'+w+'" id="num1_'+w+'" class="form-control numero" value="0"></td><td height="35" class="espacio2"><input type="text" name="not1_'+w+'" id="not1_'+w+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" autocomplete="off"></td><td height="35" class="espacio2"><input type="text" name="vag1_'+w+'" id="vag1_'+w+'" class="form-control numero" value="0.00" onkeyup="paso_val9('+w+');"><input type="hidden" name="vat1_'+w+'" id="vat1_'+w+'" class="form-control numero" value="0"></td><td width="10%">&nbsp;</td></tr>');
      }
      else
      {
        $("#add_form1 table").append('<tr><td height="35" class="espacio2"><input type="text" class="form-control fecha" name="fec1_'+w+'" id="fec1_'+w+'" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly"></td><td height="35" class="espacio2"><input type="text" name="num1_'+w+'" id="num1_'+w+'" class="form-control numero" value="0"></td><td height="35" class="espacio2"><input type="text" name="not1_'+w+'" id="not1_'+w+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" autocomplete="off"></td><td height="35" class="espacio2"><input type="text" name="vag1_'+w+'" id="vag1_'+w+'" class="form-control numero" value="0.00" onkeyup="paso_val9('+w+');"><input type="hidden" name="vat1_'+w+'" id="vat1_'+w+'" class="form-control numero" value="0"></td><td width="10%"><div id="del1_'+w+'"><a href="#" onclick="borra1('+w+')"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      }
      $("#fec1_"+w).datepicker({
        dateFormat: "yy/mm/dd",
        maxDate: 0,
        changeYear: true,
        changeMonth: true,
        onSelect: function () {
          $("#num1_"+w).focus();
        }
      });
      y_1++;
      $("#vag1_"+w).maskMoney();
      $('html,body').animate({ scrollTop: 9999 }, 'slow');
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    if(y_1 > 1)
    {
      $(this).closest('tr').remove();
    }
    return false;
  });
  var InputsWrapper2   = $("#add_form2 table tr");
  var AddButton2       = $("#add_field2");
  var z_1              = InputsWrapper2.length;
  var FieldCount2      = 1;
  $(AddButton2).click(function (e) {
    if(z_1 <= MaxInputs)
    {
      var v = z_1;
      FieldCount2++;
      if (v == "1")
      {
        $("#add_form2 table").append('<tr><td height="35" class="espacio2"><input type="text" class="form-control fecha" name="fec2_'+v+'" id="fec2_'+v+'" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly"></td><td height="35" class="espacio2"><input type="text" name="num2_'+v+'" id="num2_'+v+'" class="form-control numero" value="0"></td><td height="35" class="espacio2"><input type="text" name="not2_'+v+'" id="not2_'+v+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" autocomplete="off"></td><td height="35" class="espacio2"><input type="text" name="vag2_'+v+'" id="vag2_'+v+'" class="form-control numero" value="0.00" onkeyup="paso_val11('+v+');"><input type="hidden" name="vat2_'+v+'" id="vat2_'+v+'" class="form-control numero" value="0"></td><td width="10%">&nbsp;</td></tr>');
      }
      else
      {
        $("#add_form2 table").append('<tr><td height="35" class="espacio2"><input type="text" class="form-control fecha" name="fec2_'+v+'" id="fec2_'+v+'" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly"></td><td height="35" class="espacio2"><input type="text" name="num2_'+v+'" id="num2_'+v+'" class="form-control numero" value="0"></td><td height="35" class="espacio2"><input type="text" name="not2_'+v+'" id="not2_'+v+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" autocomplete="off"></td><td height="35" class="espacio2"><input type="text" name="vag2_'+v+'" id="vag2_'+v+'" class="form-control numero" value="0.00" onkeyup="paso_val11('+v+');"><input type="hidden" name="vat2_'+v+'" id="vat2_'+v+'" class="form-control numero" value="0"></td><td width="10%"><div id="del2_'+v+'"><a href="#" onclick="borra2('+v+')"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      }
      $("#fec2_"+v).datepicker({
        dateFormat: "yy/mm/dd",
        maxDate: 0,
        changeYear: true,
        changeMonth: true,
        onSelect: function () {
          $("#num2_"+v).focus();
        }
      });
      z_1++;
      $("#vag2_"+v).maskMoney();
      $('html,body').animate({ scrollTop: 9999 }, 'slow');
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    if(y_1 > 1)
    {
      $(this).closest('tr').remove();
    }
    return false;
  });
  $("#t_debito").hide();
  $("#t_debito1").hide();
  $("#t_credito").hide();
  $("#t_credito1").hide();
  $("#t_cheques").hide();
  $("#t_cheques1").hide();
  var v_super = $("#v_super").val();
  if (v_super == "1")
  {
    $("#lbl1").show();
  }
  else
  {
    $("#lbl1").hide();
  }
  $("#eliminar").hide();
  trae_ano();
  trae_cuentas()
  $("#periodo").val('<?php echo $mes; ?>');
  $("#ano").val('<?php echo $ano; ?>');
  $("#unidad1").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
});
</script>
<script>
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
function trae_cuentas()
{
  $("#cuenta").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cuentas1.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
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
function consulta()
{
  var periodo = $("#periodo").val();
  var ano = $("#ano").val();
  var cuenta = $("#cuenta").val();
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  var v_super = $("#v_super").val();
  if (v_super == "1")
  {
    var unidad = $("#unidad1").val();
    var sigla = $("#unidad1 option:selected").html();
  }
  else
  {
    var unidad = $("#v_unidad").val();
    var sigla = $("#v_sigla").val();
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "conci_consu.php",
    data:
    {
      periodo: periodo,
      ano: ano,
      cuenta: cuenta1,
      unidad: unidad,
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
      $("#res_conc").html('');
      $("#res_conc1").html('');
      var registros = JSON.parse(data);
      var total = registros.salida;
      var saldo = registros.saldo;
      saldo = parseFloat(saldo);
      saldo = saldo.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      var extracto = registros.extracto;
      extracto = parseFloat(extracto);
      extracto = extracto.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      var debito = registros.debito;
      debito = parseFloat(debito);
      debito = debito.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      var credito = registros.credito;
      credito = parseFloat(credito);
      credito = credito.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      var cheques = registros.cheques;
      cheques = parseFloat(cheques);
      cheques = cheques.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      var salida = "";
      var salida1 = "";
      salida += "<form name='formu1' method='post'>";
      salida += "<table width='100%' align='center' border='1'><tr><td colspan='5' height='35' bgcolor='#cccccc'><center><b>AN&Aacute;LISIS DE LOS SALDOS</b></center></td></tr>";
      salida += '<tr><td height="35" width="30%" class="espacio2">SALDO EN EXTRACTO BANCARIO A FECHA</td><td height="35" width="19%" class="espacio2"><input type="text" name="extracto" id="extracto" class="form-control numero" value="0.00" onkeyup="paso_val(); suma();" onblur="suma();" autocomplete="off" tabindex="4"><input type="hidden" name="extracto1" id="extracto1" class="form-control numero" value="0" readonly="readonly" tabindex="5"></td><td width="1%">&nbsp;</td>';
      salida += '<td height="35" width="30%" class="espacio2">NOTAS CREDITO NO REGISTRADAS AUXILIAR BANCOS</td><td height="35" width="30%" class="espacio2"><input type="text" name="credito" id="credito" class="form-control numero" value="0.00" onkeyup="paso_val3(); suma1();" onblur="suma1();" autocomplete="off" tabindex="10"><input type="hidden" name="credito1" id="credito1" class="form-control numero" value="0" readonly="readonly" tabindex="11"></td></tr>';

      salida += '<tr><td height="35" width="30%" class="espacio2">NOTAS DEBITO NO REGISTRADAS AUXILIAR BANCOS</td><td height="35" width="19%" class="espacio2"><input type="text" name="debito" id="debito" class="form-control numero" value="0.00" onkeyup="paso_val1(); suma();" onblur="suma();" autocomplete="off" tabindex="6"><input type="hidden" name="debito1" id="debito1" class="form-control numero" value="0" readonly="readonly" tabindex="7"></td><td width="1%">&nbsp;</td>';
      salida += '<td height="35" width="30%" class="espacio2">CHEQUES PENDIENTES DE COBRO</td><td height="35" width="30%" class="espacio2"><input type="text" name="cheques" id="cheques" class="form-control numero" value="0.00" onkeyup="paso_val2(); suma1();" onblur="suma1();" autocomplete="off" tabindex="12"><input type="hidden" name="cheques1" id="cheques1" class="form-control numero" value="0" readonly="readonly" tabindex="13"></td></tr>';

      salida += '<tr><td height="35" width="30%" class="espacio2"><b>TOTAL</b></td><td height="35" width="19%" class="espacio2"><input type="text" name="total1" id="total1" class="form-control numero" value="0.00" readonly="readonly" style="border-style: none; background: transparent; color: #000;" tabindex="8" onfocus="blur();" readonly="readonly"><input type="hidden" name="total2" id="total2" class="form-control numero" value="0" readonly="readonly" tabindex="9" onfocus="blur();" readonly="readonly"></td><td width="1%">&nbsp;</td>';
      salida += '<td height="35" width="30%" class="espacio2">SALDO SEGUN LIBROS A FECHA</td><td height="35" width="30%" class="espacio2"><input type="text" name="libros" id="libros" class="form-control numero" value="0.00" readonly="readonly" style="border-style: none; background: transparent; color: #000;" tabindex="14" onfocus="blur();" readonly="readonly"><input type="hidden" name="libros1" id="libros1" class="c7" value="0" readonly="readonly" tabindex="15" onfocus="blur();" readonly="readonly"></td></tr>';

      salida += '<tr><td height="35" colspan="2" class="espacio2">&nbsp;</td><td width="1%">&nbsp;</td>';
      salida += '<td height="35" width="30%" class="espacio2"><b>TOTAL</b></td><td height="35" width="30%" class="espacio2"><input type="text" name="total3" id="total3" class="form-control numero" value="0.00" readonly="readonly" style="border-style: none; background: transparent; color: #000;" tabindex="16" onfocus="blur();" readonly="readonly"><input type="hidden" name="total4" id="total4" class="form-control numero" value="0" readonly="readonly" tabindex="17" onfocus="blur();" readonly="readonly"></td></tr>';
      salida += '</table>';
      salida1 += '<br><center><input type="button" name="aceptar1" id="aceptar1" value="Continuar"><input type="button" name="aceptar2" id="aceptar2" value="Visualizar"></center>';
      $("#res_conc").append(salida);
      $("#res_conc1").append(salida1);
      $("#libros").val(saldo);
      $("#extracto").maskMoney();
      $("#debito").maskMoney();
      $("#credito").maskMoney();
      $("#cheques").maskMoney();
      $("#aceptar1").button();
      $("#aceptar1").click(pregunta);
      $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      $("#aceptar2").button();
      $("#aceptar2").click(link);
      $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      $("#aceptar2").hide();
      paso_val6();
      suma1();
      $("#periodo").prop("disabled",true);
      $("#ano").prop("disabled",true);
      $("#cuenta").prop("disabled",true);
      $("#unidad1").prop("disabled",true);
      $("#aceptar").hide();
      if (total == "0")
      {
        $("#extracto").focus();
        $("#aceptar2").hide();
      }
      else
      {
        $("#extracto").val(extracto);
        $("#debito").val(debito);
        $("#credito").val(credito);
        $("#cheques").val(cheques);
        paso_val13();
        $("#aceptar1").hide();
        $("#aceptar2").show();
        $("#t_debito").hide();
        $("#t_debito1").hide();
        $("#t_credito").hide();
        $("#t_credito1").hide();
        $("#t_cheques").hide();
        $("#t_cheques1").hide();
        $("#extracto").prop("disabled",true);
        $("#debito").prop("disabled",true);
        $("#credito").prop("disabled",true);
        $("#cheques").prop("disabled",true);
        var archivo = "Concilia_"+unidad+"_"+periodo+"_"+ano+"_"+cuenta1+".pdf";
        $("#archivo").val(archivo);
        var v_super = $("#v_super").val();
        if (v_super == "1")
        {
          $("#eliminar").show();
        }
      }
    }
  });
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function paso_val()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('extracto').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#extracto1").val(valor1);
}
function paso_val1()
{
  var valor;
  var valor1;
  var valor2;
  valor1 = document.getElementById('debito').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  valor2 = parseFloat(valor1);
  $("#debito1").val(valor1);
  if (valor2 > 0)
  {
    $("#t_debito").show();
    $("#t_debito1").show();
  }
  else
  {
    $("#t_debito").hide();
    $("#t_debito1").hide();
  }
}
function paso_val2()
{
  var valor;
  var valor1;
  var valor2;
  valor1 = document.getElementById('cheques').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  valor2 = parseFloat(valor1);
  $("#cheques1").val(valor1);
  if (valor2 > 0)
  {
    $("#t_cheques").show();
    $("#t_cheques1").show();
  }
  else
  {
    $("#t_cheques").hide();
    $("#t_cheques1").hide();
  }
}
function paso_val3()
{
  var valor;
  var valor1;
  var valor2;
  valor1 = document.getElementById('credito').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  valor2 = parseFloat(valor1);
  $("#credito1").val(valor1);
  if (valor2 > 0)
  {
    $("#t_credito").show();
    $("#t_credito1").show();
  }
  else
  {
    $("#t_credito").hide();
    $("#t_credito1").hide();
  }
}
function paso_val4()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('cheques').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#cheques1").val(valor1);
}
function paso_val5()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('total3').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#total4").val(valor1);
}
function paso_val6()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('libros').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#libros1").val(valor1);
}
function paso_val7(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('vag_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vat_"+valor).val(valor1);
  suma2();
}
function paso_val8()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('t_deb').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#t_deb1").val(valor1);
}
function paso_val9(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('vag1_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vat1_"+valor).val(valor1);
  suma3();
}
function paso_val10()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('t_cre').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#t_cre1").val(valor1);
}
function paso_val11(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('vag2_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vat2_"+valor).val(valor1);
  suma4();
}
function paso_val12()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('t_che').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#t_che1").val(valor1);
}
function paso_val13()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('extracto').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#extracto1").val(valor1);
  var valor;
  var valor1;
  valor1 = document.getElementById('debito').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#debito1").val(valor1);
  var valor;
  var valor1;
  valor1 = document.getElementById('credito').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#credito1").val(valor1);
  var valor;
  var valor1;
  valor1 = document.getElementById('cheques').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#cheques1").val(valor1);
  suma();
  suma1();
}
function paso_val14()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('total1').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#total2").val(valor1);
}
function suma()
{
  var valor, valor1, valor2;
  valor = document.getElementById('extracto1').value;
  valor = parseFloat(valor);
  valor1 = document.getElementById('debito1').value;
  valor1 = parseFloat(valor1);
  valor2 = valor+valor1;
  valor2 = valor2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total1").val(valor2);
  paso_val14();
  paso_val2();
  totaliza();
}
function suma1()
{
  var valor, valor1, valor2, valor3;
  valor = document.getElementById('credito1').value;
  valor = parseFloat(valor);
  valor1 = document.getElementById('cheques1').value;
  valor1 = parseFloat(valor1);
  valor2 = document.getElementById('libros1').value;
  valor2 = parseFloat(valor2);
  valor3 = valor+valor1+valor2;
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total3").val(valor3);
  paso_val5();
  totaliza();
}
function suma2()
{
  var detalle = "";
  var valor;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux = document.formu2.elements[i].name;
    if (saux.indexOf('vat_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      valor2 = parseFloat(valor2);
      valor3 = valor3+valor2;
    }
  }
  var valor4 = $("#debito1").val();
  var valor5 = valor4-valor3;
  var valor6 = $("#debito").val();
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_deb").val(valor3);
  paso_val8();
  if (valor5 < 0)
  {
    detalle = "<center><h3>Valor Total de Notas Debito "+valor3+" superior al Valor Notas Debito No Registradas "+valor6+"</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#aceptar1").hide();
  }
  else
  {
    if (valor5 == "0")
    {
      $("#aceptar1").show();   
    }
    else
    {
      $("#aceptar1").hide();
    }
  }
}
function suma3()
{
  var detalle = "";
  var valor;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  for (i=0;i<document.formu3.elements.length;i++)
  {
    saux = document.formu3.elements[i].name;
    if (saux.indexOf('vat1_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      valor2 = parseFloat(valor2);
      valor3 = valor3+valor2;
    }
  }
  var valor4 = $("#credito1").val();
  var valor5 = valor4-valor3;
  var valor6 = $("#credito").val();
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_cre").val(valor3);
  paso_val10();
  if (valor5 < 0)
  {
    detalle = "<center><h3>Valor Total de Notas Credito "+valor3+" superior al Valor Notas Credito No Registradas "+valor6+"</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#aceptar1").hide();
  }
  else
  {
    if (valor5 == "0")
    {
      $("#aceptar1").show();
    }
    else
    {
      $("#aceptar1").hide();
    }
  }
}
function suma4()
{
  var detalle = "";
  var valor;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  for (i=0;i<document.formu4.elements.length;i++)
  {
    saux = document.formu4.elements[i].name;
    if (saux.indexOf('vat2_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      valor2 = parseFloat(valor2);
      valor3 = valor3+valor2;
    }
  }
  var valor4 = $("#cheques1").val();
  var valor5 = valor4-valor3;
  var valor6 = $("#cheques").val();
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_che").val(valor3);
  paso_val12();
  if (valor5 < 0)
  {
    detalle = "<center><h3>Valor Total de Cheques Pendientes "+valor3+" superior al Valor Cheques Pendientes "+valor6+"</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#aceptar1").hide();
  }
  else
  {
    if (valor5 == "0")
    {
      $("#aceptar1").show();
    }
    else
    {
      $("#aceptar1").hide();
    }
  }
}
function totaliza()
{
  var valor, valor1, valor2;
  valor = document.getElementById('total2').value;
  valor = parseFloat(valor);
  valor1 = document.getElementById('total4').value;
  valor1 = parseFloat(valor1);
  valor2 = valor-valor1;
  valor2 = parseFloat(valor2);
  if (valor2 == "0")
  {
    $("#aceptar1").show();
  }
  else
  {
    $("#aceptar1").hide();
  }
  var valor3 = $("#t_deb").val();
  valor3 = parseFloat(valor3.replace(/,/g,''));
  var valor4 = $("#debito1").val();
  valor4 = parseFloat(valor4);
  var valor5 = valor4-valor3;
  if (valor5 > 0)
  {
    $("#aceptar1").hide();
  }
  var valor6 = $("#t_cre").val();
  valor6 = parseFloat(valor6.replace(/,/g,''));
  var valor7 = $("#credito1").val();
  valor7 = parseFloat(valor7);
  var valor8 = valor6-valor7;
  if (valor8 > 0)
  {
    $("#aceptar1").hide();
  }
  var valor9 = $("#t_che").val();
  valor9 = parseFloat(valor9.replace(/,/g,''));
  var valor10 = $("#cheques1").val();
  valor10 = parseFloat(valor10);
  var valor11 = valor9-valor10;
  if (valor11 > 0)
  {
    $("#aceptar1").hide();
  }
}
function borra(valor)
{
  var valor;
  $("#fec_"+valor).val('');
  $("#fec_"+valor).hide();
  $("#num_"+valor).val('0');
  $("#num_"+valor).hide();
  $("#not_"+valor).val('');
  $("#not_"+valor).hide();
  $("#vag_"+valor).val('0');
  $("#vag_"+valor).hide();
  $("#vat_"+valor).val('0');
  $("#vat_"+valor).hide();
  $("#del_"+valor).hide();
  suma2();
}
function borra1(valor)
{
  var valor;
  $("#fec1_"+valor).val('');
  $("#fec1_"+valor).hide();
  $("#num1_"+valor).val('0');
  $("#num1_"+valor).hide();
  $("#not1_"+valor).val('');
  $("#not1_"+valor).hide();
  $("#vag1_"+valor).val('0');
  $("#vag1_"+valor).hide();
  $("#vat1_"+valor).val('0');
  $("#vat1_"+valor).hide();
  $("#del1_"+valor).hide();
  suma3();
}
function borra2(valor)
{
  var valor;
  $("#fec2_"+valor).val('');
  $("#fec2_"+valor).hide();
  $("#num2_"+valor).val('0');
  $("#num2_"+valor).hide();
  $("#not2_"+valor).val('');
  $("#not2_"+valor).hide();
  $("#vag2_"+valor).val('0');
  $("#vag2_"+valor).hide();
  $("#vat2_"+valor).val('0');
  $("#vat2_"+valor).hide();
  $("#del2_"+valor).hide();
  suma4();
}
function validacionData()
{
  var salida = true, detalle = '';
  var valor = $("#debito1").val();
  var valor1 = $("#credito1").val();
  var valor2 = $("#cheques1").val();
  var valor3 = $("#t_deb1").val();
  var valor4 = $("#t_cre1").val();
  var valor5 = $("#t_che1").val();
  var valor6 = $("#total2").val();
  var valor7 = $("#total4").val();
  if ((valor == "0") && (valor3 == "0"))
  {
  }
  else
  {
  	if (valor == valor3)
  	{
  	}
  	else
  	{
  	  salida = false;
  	  detalle += "<center><h3>Valor Notas Debito No Concuerda</h3></center>";      
  	}
  }
  if (valor4 == undefined)
  {
  	valor4 = 0;
  }
  if ((valor1 == "0") && (valor4 == "0"))
  {
  }
  else
  {
  	if (valor1 == valor4)
  	{
  	}
  	else
  	{
  	  salida = false;
  	  detalle += "<center><h3>Valor Notas Credito No Concuerda</h3></center>";      
  	}
  }
  if (valor5 == undefined)
  {
  	valor5 = 0;
  }
  if ((valor2 == "0") && (valor5 == "0"))
  {
  }
  else
  {
  	if (valor2 == valor5)
  	{
  	}
  	else
  	{
  	  salida = false;
  	  detalle += "<center><h3>Valor Cheques Pendientes No Concuerda</h3></center>";      
  	}
  }
  if (valor6 == valor7)
  {
  }
  else
  {
    salida = false;
    detalle += "<center><h3>Valor Totales No Concuerdan</h3></center>";      
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    graba();
  }
}
function graba()
{
  $("#v_deb").val('');
  $("#v_paso").val('');
  $("#v_paso1").val('');
  $("#v_paso2").val('');
  $("#v_paso3").val('');
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux = document.formu2.elements[i].name;
    if (saux.indexOf('fec_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_paso').value = document.getElementById('v_paso').value+valor+"|";
    }
    if (saux.indexOf('num_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_paso1').value = document.getElementById('v_paso1').value+valor+"|";
    }
    if (saux.indexOf('not_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_paso2').value = document.getElementById('v_paso2').value+valor+"|";
    }
    if (saux.indexOf('vag_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_paso3').value = document.getElementById('v_paso3').value+valor+"|";
    }
  }
  // Credito
  for (i=0;i<document.formu3.elements.length;i++)
  {
    saux = document.formu3.elements[i].name;
    if (saux.indexOf('fec1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_paso4').value = document.getElementById('v_paso4').value+valor+"|";
    }
    if (saux.indexOf('num1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_paso5').value = document.getElementById('v_paso5').value+valor+"|";
    }
    if (saux.indexOf('not1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_paso6').value = document.getElementById('v_paso6').value+valor+"|";
    }
    if (saux.indexOf('vag1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_paso7').value = document.getElementById('v_paso7').value+valor+"|";
    }
  }
  // Cheques
  for (i=0;i<document.formu4.elements.length;i++)
  {
    saux = document.formu4.elements[i].name;
    if (saux.indexOf('fec2_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_paso8').value = document.getElementById('v_paso8').value+valor+"|";
    }
    if (saux.indexOf('num2_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_paso9').value = document.getElementById('v_paso9').value+valor+"|";
    }
    if (saux.indexOf('not2_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_paso10').value = document.getElementById('v_paso10').value+valor+"|";
    }
    if (saux.indexOf('vag2_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_paso11').value = document.getElementById('v_paso11').value+valor+"|";
    }
  }
  var v_datos1 = $("#v_paso").val()+"#"+$("#v_paso1").val()+"#"+$("#v_paso2").val()+"#"+$("#v_paso3").val();
  $("#v_deb").val(v_datos1);
  var v_datos2 = $("#v_paso4").val()+"#"+$("#v_paso5").val()+"#"+$("#v_paso6").val()+"#"+$("#v_paso7").val();
  $("#v_cre").val(v_datos2);
  var v_datos3 = $("#v_paso8").val()+"#"+$("#v_paso9").val()+"#"+$("#v_paso10").val()+"#"+$("#v_paso11").val();
  $("#v_che").val(v_datos3);
  graba1();
}
function graba1()
{
  var cuenta = $("#cuenta").val();
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_grab.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
      cuenta: cuenta1,
      extracto: $("#extracto1").val(),
      debito: $("#debito1").val(),
      credito: $("#credito1").val(),
      cheque: $("#cheques1").val(),
      libros: $("#libros1").val(),
      cheques: $("#v_che").val(),
      debitos: $("#v_deb").val(),
      creditos: $("#v_cre").val()
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
        $("#aceptar1").hide();
        $("#aceptar2").show();
        $("#aceptar2").click();
        $("#extracto").prop("disabled",true);
        $("#debito").prop("disabled",true);
        $("#credito").prop("disabled",true);
        $("#cheques").prop("disabled",true);
        for (i=0;i<document.formu2.elements.length;i++)
        {
          saux = document.formu2.elements[i].name;
          if (saux.indexOf('fec_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('num_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('not_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('vag_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        for (i=0;i<document.formu3.elements.length;i++)
        {
          saux = document.formu3.elements[i].name;
          if (saux.indexOf('fec1_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('num1_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('not1_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('vag1_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        for (i=0;i<document.formu4.elements.length;i++)
        {
          saux = document.formu4.elements[i].name;
          if (saux.indexOf('fec2_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('num2_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('not2_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('vag2_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        $("#add_field").hide();
        $("#add_field1").hide();
        $("#add_field2").hide();
        for (j=1;j<=30;j++)
        {
          $("#del_"+j).hide();
          $("#del1_"+j).hide();
          $("#del2_"+j).hide();
        }
      }
      else
      {
        detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar1").show();
        $("#aceptar2").hide();
      }
    }
  });
}
function link()
{
  var periodo = $("#periodo").val();
  var ano = $("#ano").val();
  var cuenta = $("#cuenta").val();
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  var v_super = $("#v_super").val();
  if (v_super == "1")
  {
    var unidad = $("#unidad1").val();
    var sigla = $("#unidad1 option:selected").html();
  }
  else
  {
    var unidad = $("#v_unidad").val();
    var sigla = $("#v_sigla").val();
  }
  $("#giro_uni").val(unidad);
  $("#giro_per").val(periodo);
  $("#giro_ano").val(ano);
  $("#giro_cue").val(cuenta1);
  $("#giro_sig").val(sigla);
  formu5.submit();
}
function borrar()
{
  var archivo = $("#archivo").val();
  var ano = $("#ano").val();
  var ruta = "Conciliaciones/"+ano+"/"+archivo;
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
      $("#eliminar").hide();
      alerta("Archivo PDF eliminado correctamente");
      alerta(archivo);
    }
  });
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
// 06/12/2024 - Ajuste inclusion borrar pdf
// 05/05/2025 - Ajuste buscador campo unidad
?>