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
  $query = "SELECT dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur1 = odbc_exec($conexion, $query);
  $n_dependencia = odbc_result($cur1,1);
  $query1 = "SELECT subdependencia, firma1, firma2, firma3, cargo1, cargo2, cargo3 FROM cx_org_sub WHERE dependencia='$n_dependencia' AND unic='1'";
  $cur2 = odbc_exec($conexion, $query1);
  $unic = odbc_result($cur2,1);
  $firma1 = trim(utf8_encode(odbc_result($cur2,2)));
  $firma2 = trim(utf8_encode(odbc_result($cur2,3)));
  $firma3 = trim(utf8_encode(odbc_result($cur2,4)));
  $cargo1 = trim(utf8_encode(odbc_result($cur2,5)));
  $cargo2 = trim(utf8_encode(odbc_result($cur2,6)));
  $cargo3 = trim(utf8_encode(odbc_result($cur2,7)));
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
          <h3>Autorizaci&oacute;n Recompensas</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Intervienen</font></label>
                </div>
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">&nbsp;</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <input type="text" name="firma1" id="firma1" class="form-control" value="<?php echo $firma1; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="1" autocomplete="off">
                  <div class="espacio1"></div>
                  <input type="text" name="cargo1" id="cargo1" class="form-control" value="<?php echo $cargo1; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="2" autocomplete="off">
                </div>
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <input type="text" name="firma2" id="firma2" class="form-control" value="<?php echo $firma2; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="3" autocomplete="off">
                  <div class="espacio1"></div>
                  <input type="text" name="cargo2" id="cargo2" class="form-control" value="<?php echo $cargo2; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="4" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">&nbsp;</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <input type="text" name="firma3" id="firma3" class="form-control" value="<?php echo $firma3; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="5" autocomplete="off">
                  <div class="espacio1"></div>
                  <input type="text" name="cargo3" id="cargo3" class="form-control" value="<?php echo $cargo3; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="6" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Elaboro</font></label>
                  <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="7" autocomplete="off">
                </div>
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha3" id="fecha3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">&nbsp;</font></label>
                  <input type="text" name="fecha4" id="fecha4" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </div>
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                  <br>
                  <a href="#" onclick="excel(); return false;">
                    <img src="dist/img/excel1.png" name='lnk1' id='lnk1' title="Exportar a Excel - SAP">
                  </a>
                  <a href="#" onclick="excel1(); return false;">
                    <img src="dist/img/excel.png" name='lnk2' id='lnk2' title="Descargar Excel - SAP">
                  </a>
                </div>
              </div>
              <br>
              <div id="val_modi"></div>
              <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="sigla" id="sigla" class="form-control" value="DIADI" readonly="readonly" tabindex="0">
              <input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly">
              <input type="hidden" name="paso" id="paso" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="v_paso0" id="v_paso0" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso1" id="v_paso1" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso2" id="v_paso2" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso3" id="v_paso3" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso4" id="v_paso4" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso5" id="v_paso5" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso6" id="v_paso6" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso7" id="v_paso7" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso8" id="v_paso8" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso9" id="v_paso9" class="form-control" readonly="readonly">
            </form>
            <form name="formu1" action="ver_central.php" method="post" target="_blank">
              <input type="hidden" name="acta_conse" id="acta_conse" readonly="readonly">
              <input type="hidden" name="acta_ano" id="acta_ano" readonly="readonly">
              <input type="hidden" name="acta_ajuste" id="acta_ajuste" readonly="readonly">
              <input type="hidden" name="acta_hoja" id="acta_hoja" readonly="readonly">
            </form>
            <form name="formu3" action="ver_autoriza.php" method="post" target="_blank">
              <input type="hidden" name="auto_conse" id="auto_conse" readonly="readonly">
              <input type="hidden" name="auto_ano" id="auto_ano" readonly="readonly">
              <input type="hidden" name="auto_tipo" id="auto_tipo" readonly="readonly">
              <input type="hidden" name="auto_ajuste" id="auto_ajuste" readonly="readonly">
              <input type="hidden" name="auto_sigla" id="auto_sigla" readonly="readonly">
            </form>
            <form name="formu_excel" id="formu_excel" action="autoriza1_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
            </form>
          </div>
          <h3>Consultas</h3>
          <div>
            <div id="load1">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <div id="campos">
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
            </div>
            <div id="tabla3"></div>
            <div id="resultados5"></div>
            <br>
            <div id="l_ajuste">
              <center>
                <label for="ajuste">Ajuste de Lineas Firma:</label>
                <input name="ajuste" id="ajuste" class="numero" onkeypress="return check(event);" value="0">
              </center>
            </div>
          </div>
          <div id="dialogo"></div>
          <div id="dialogo1"></div>
          <div id="dialogo2">
            <form name="formu2">
              <table width="98%" align="center" border="0">
                <tr>
                  <td height="20" valign="bottom">
                    <div class="row">
                      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        Motivo Rechazo Autorizaci&oacute;n Recompensas:&nbsp;&nbsp;&nbsp;<input type="text" name="dat_plan" id="dat_plan" class="c5" onfocus="blur();" readonly="readonly" style="border-style: none;"><input type="hidden" name="num_plan" id="num_plan" class="c10" onfocus="blur();" readonly="readonly" style="border-style: none;"><input type="hidden" name="ano_plan" id="ano_plan" class="c10" onfocus="blur();" readonly="readonly" style="border-style: none;">
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <textarea name="mot_plan" id="mot_plan" class="form-control" rows="5" onblur="val_caracteres('mot_plan');"></textarea>
                    <br>
                    <div id="men_rec"><center>Debe Ingresar un Motivo de Rechazo</center></div>
                  </td>
                </tr>
              </table>
            </form>
          </div>
          <div id="dialogo3"></div>
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
  $("#load1").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 180,
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
        graba();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 290,
    width: 600,
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
        rechazo();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo3").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
    width: 530,
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
          recarga();
        }
      }
    ]
  });
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
  $("#fecha3").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fecha4").prop("disabled",false);
      $("#fecha4").datepicker("destroy");
      $("#fecha4").val('');
      $("#fecha4").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha3").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
      $("#lnk1").show();
      $("#lnk2").hide();
    },
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#consultar").button();
  $("#consultar").click(consultar1);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#men_rec").hide();
  $("#lnk2").hide();
  $("#l_ajuste").hide();
  $("#ajuste").spinner({ min: 0 });
  $("#ajuste").width(50);
  consultar();
});
function consultar()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_recompensas.php",
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
      $("#val_modi").html('');
      var registros = JSON.parse(data);
      var total = registros.total;
      total = parseInt(total);
      var salida = "";
      salida += "<table width='100%' align='center' border='0'>";
      salida += "<tr><td width='2%' height='25'>&nbsp;</td><td width='5%' height='25'><center><b>N&uacute;mero</b></center></td><td width='10%' height='25'><center><b>Fecha</b></center></td><td width='7%' height='25'><center><b>Unidad</b></center></td><td width='8%' height='25'><center><b>Registro<br>Año</center></b></td><td width='12%' height='25'><center><b>ORDOP<br>OFRAG</center></b></td><td width='12%' height='25'><center><b>Valor Solicitado</b></center></td><td width='12%' height='25'><center><b>Total Acta</b></center></td><td width='12%' height='25'><center><b>Total Anticipos</b></center></td><td width='12%' height='25'><center><b>Total Giro</b></center></td><td width='4%' height='25'>&nbsp;</td><td width='4%' height='25'>&nbsp;</td></tr>";
      var var_con = registros.conses.split('|');      
      var var_fec = registros.fechas.split('|');
      var var_ano = registros.anos.split('|');
      var var_reg = registros.registros.split('|');
      var var_ano1 = registros.anos1.split('|');
      var var_val = registros.valores.split('|');
      var var_tot = registros.totales.split('|');
      var var_ant = registros.anticipos.split('|');
      var var_sig = registros.siglas.split('|');
      var var_uni = registros.unidades.split('|');
      var var_ord = registros.ordop.split('|');
      var var_fra = registros.fragmenta.split('|');
      var var_con1 = var_con.length;
      for (var j=0; j<var_con1-1; j++)
      {
        var var1 = var_con[j];
        var var2 = var_fec[j];
        var var3 = var_ano[j];
        var var4 = var_reg[j];
        var var5 = var_ano1[j];
        var var6 = var_val[j];
        var var7 = var_tot[j];
        var var8 = var_ant[j];
        var var9 = var_sig[j];
        var var10 = parseFloat(var8);
        var10 = var10.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        var var11 = parseFloat(var7.replace(/,/g,''));
        var11 = var11-var8;
        var var12 = parseFloat(var11);
        var12 = var12.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        var var13 = var_uni[j];
        var var14 = var_ord[j];
        var var15 = var_fra[j];
        var paso = "\'"+var1+"\'";
        var paso1 = "\'"+var3+"\'";
        var paso2 = var1+","+j;
        salida += '<tr><td width="2%" height="35"><center><input type="checkbox" name="seleccionados[]" id="chk_'+j+'" value="'+paso2+'" onclick="trae_marca('+j+','+var1+');"></center></td><td width="5%" height="35"><center>'+var1+'</center></td><td width="10%" height="35"><center>'+var2+'</center></td><td width="7%" height="35"><center>'+var9+'</center></td><td width="8%" height="35"><center>'+var4+' - '+var5+'<input type="hidden" name="act_'+j+'" id="act_'+j+'" class="c7" value="'+var1+'"><input type="hidden" name="ano_'+j+'" id="ano_'+j+'" class="c7" value="'+var3+'"><input type="hidden" name="reg_'+j+'" id="reg_'+j+'" class="c7" value="'+var4+'"><input type="hidden" name="ano1_'+j+'" id="ano1_'+j+'" class="c7" value="'+var5+'"><input type="hidden" name="sig_'+j+'" id="sig_'+j+'" class="c7" value="'+var9+'"><input type="hidden" name="uni_'+j+'" id="uni_'+j+'" class="c7" value="'+var13+'"></center></td><td width="12%" height="35">'+var14+'<br>'+var15+'</td>';
        salida += '<td align="right" width="12%" height="35"><input type="text" name="va1_'+j+'" id="va1_'+j+'" class="c7" value="'+var6+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"></td>';
        salida += '<td align="right" width="12%" height="35"><input type="text" name="va2_'+j+'" id="va2_'+j+'" class="c7" value="'+var7+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"></td>';
        salida += '<td align="right" width="12%" height="35"><input type="text" name="va3_'+j+'" id="va3_'+j+'" class="c7" value="'+var10+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"></td>';
        salida += '<td align="right" width="12%" height="35"><input type="text" name="va4_'+j+'" id="va4_'+j+'" class="c7" value="'+var12+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"></td>';
        salida += '<td width="4%" height="35"><center><a href="#" onclick="link('+paso+','+paso1+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Acta"></a></center></td><td width="4%" height="35"><center><a href="#" onclick="rechazar('+paso+','+paso1+')"><img src="imagenes/anular.png" border="0" title="Rechazar"></a></center></td></tr>';
      }
      salida += '</table>';
      if (total > 0)
      {
        salida += '<br><center><input type="button" name="aceptar" id="aceptar" value="Continuar"><input type="button" name="aceptar1" id="aceptar1" value="Ver Autorización"></center>';
      }
      $("#val_modi").append(salida);
      for(i=0;i<=total;i++)
      {
        $("#va1_"+i).prop("disabled",true);
        $("#va2_"+i).prop("disabled",true);
        $("#va1_"+i).maskMoney();
        $("#va2_"+i).maskMoney();
        $("#gra_"+i).hide();
      }
      $("#aceptar").button();
      $("#aceptar").click(pregunta);
      $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      $("#aceptar1").button();
      $("#aceptar1").click(link1);
      $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      $("#aceptar1").hide();
    }
  });
}
function trae_marca(valor, valor1)
{
  var valor, valor1, valor2, valor3;
  if ($("#chk_"+valor).is(":checked"))
  {
    $("#va1_"+valor).css("background-color","#FFFF00");
    $("#va2_"+valor).css("background-color","#FFFF00");
    $("#va3_"+valor).css("background-color","#FFFF00");
    $("#va4_"+valor).css("background-color","#FFFF00");
  }
  else
  {
    $("#va1_"+valor).css("background-color","#F8F8F8");
    $("#va2_"+valor).css("background-color","#F8F8F8");
    $("#va3_"+valor).css("background-color","#F8F8F8");
    $("#va4_"+valor).css("background-color","#F8F8F8");
  }
}
function formatNumber(valor)
{
  valor = String(valor).replace(/\D/g, "");
  return valor === '' ? valor : Number(valor).toLocaleString();
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function graba()
{
  var seleccionadosarray = [];
  $("#v_paso0").val('');
  $("#v_paso1").val('');
  $("#v_paso2").val('');
  $("#v_paso3").val('');
  $("#v_paso4").val('');
  $("#v_paso5").val('');
  $("#v_paso6").val('');
  $("#v_paso7").val('');
  $("#v_paso8").val('');
  $("#v_paso9").val('');
  $("input[name='seleccionados[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        var paso = $(this).val();
        var var_ocu = paso.split(',');
        var paso1 = var_ocu[0];
        var paso2 = var_ocu[1];
        seleccionadosarray.push(paso1);
        valor0 = $("#act_"+paso2).val();
        valor1 = $("#ano_"+paso2).val();
        valor2 = $("#reg_"+paso2).val();
        valor3 = $("#ano1_"+paso2).val();
        valor4 = $("#sig_"+paso2).val();
        valor5 = $("#uni_"+paso2).val();
        valor6 = $("#va1_"+paso2).val();
        valor7 = $("#va2_"+paso2).val();
        valor8 = $("#va3_"+paso2).val();
        valor9 = $("#va4_"+paso2).val();
        document.getElementById('v_paso0').value = document.getElementById('v_paso0').value+valor0+"|";
        document.getElementById('v_paso1').value = document.getElementById('v_paso1').value+valor1+"|";
        document.getElementById('v_paso2').value = document.getElementById('v_paso2').value+valor2+"|";
        document.getElementById('v_paso3').value = document.getElementById('v_paso3').value+valor3+"|";
        document.getElementById('v_paso4').value = document.getElementById('v_paso4').value+valor4+"|";
        document.getElementById('v_paso5').value = document.getElementById('v_paso5').value+valor5+"|";
        document.getElementById('v_paso6').value = document.getElementById('v_paso6').value+valor6+"|";
        document.getElementById('v_paso7').value = document.getElementById('v_paso7').value+valor7+"|";
        document.getElementById('v_paso8').value = document.getElementById('v_paso8').value+valor8+"|";
        document.getElementById('v_paso9').value = document.getElementById('v_paso9').value+valor9+"|";
      }
    }
  );
  var valida = seleccionadosarray.length;
  if (valida == "0")
  {
    detalle = "<center><h3>Debe seleccionar un Acta</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#aceptar").show();
  }
  else
  {
    var salida = true, detalle = '';
    var valor = $("#elaboro").val();
    valor = valor.trim().length;
    if (valor == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar el campo Elaboro</h3></center>";
      $("#elaboro").addClass("ui-state-error");
    }
    else
    {
      $("#elaboro").removeClass("ui-state-error");
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
        url: "auto_grab1.php",
        data:
        {
          conses: seleccionadosarray,
          paso0: $("#v_paso0").val(),
          paso1: $("#v_paso1").val(),
          paso2: $("#v_paso2").val(),
          paso3: $("#v_paso3").val(),
          paso4: $("#v_paso4").val(),
          paso5: $("#v_paso5").val(),
          paso6: $("#v_paso6").val(),
          paso7: $("#v_paso7").val(),
          paso8: $("#v_paso8").val(),
          paso9: $("#v_paso9").val(),
          firma1: $("#firma1").val(),
          cargo1: $("#cargo1").val(),
          firma2: $("#firma2").val(),
          cargo2: $("#cargo2").val(),
          firma3: $("#firma3").val(),
          cargo3: $("#cargo3").val(),
          elaboro: $("#elaboro").val()
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
          var conse = registros.conse;
          if (valida == "1")
          {
            $("#paso").val(conse);
            $("#aceptar").hide();
            $("#aceptar1").show();
            $("#aceptar2").show();
            $("input[name='seleccionados[]']").each(
              function ()
              {
                $(this).prop("disabled",true);
              }
            );
            for (i=0;i<document.formu.elements.length;i++)
            {
              saux = document.formu.elements[i].name;
              if (saux.indexOf('va1_')!=-1)
              {
                document.getElementById(saux).setAttribute("disabled","disabled");
              }
              if (saux.indexOf('va2_')!=-1)
              {
                document.getElementById(saux).setAttribute("disabled","disabled");
              }
            }
            $("#firma1").prop("disabled",true);
            $("#cargo1").prop("disabled",true);
            $("#firma2").prop("disabled",true);
            $("#cargo2").prop("disabled",true);
            $("#firma3").prop("disabled",true);
            $("#cargo3").prop("disabled",true);
            $("#elaboro").prop("disabled",true);
          }
          else
          {
            detalle = "<center><h3>Error durante la grabación</h3></center>";
            $("#dialogo").html(detalle);
            $("#dialogo").dialog("open");
            $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
            $("#aceptar").show();
          }
        }
      });
    }
  }
}
function rechazar(valor, valor1)
{
  var valor, valor1
  $("#num_plan").val(valor);
  $("#ano_plan").val(valor1);
  $("#dat_plan").val(valor+" - "+valor1);
  $("#dialogo2").dialog("open");
  $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  $("#men_rec").hide();
  $("#mot_plan").focus();
}
function rechazo()
{
  var salida = true, detalle = '';
  var valor = $("#mot_plan").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
  }
  if (salida == false)
  {
    $("#men_rec").addClass("ui-state-error");
    $("#men_rec").show();
  }
  else
  {
    $("#dialogo2").dialog("close");
    var numero = $("#num_plan").val();
    var ano = $("#ano_plan").val();
    var motivo = $("#mot_plan").val();
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "noti_grab11.php",
      data:
      {
        conse: numero,
        ano: ano,
        motivo: motivo
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        var salida = registros.salida;
        if (salida == "1")
        { 
          var detalle  = "<center><h3>Rechazo de Autorizaci&oacute;n de Recompensas<br>"+numero+" / "+ano+" registrado correctamente</h3></center>"; 
          $("#dialogo3").html(detalle);
          $("#dialogo3").dialog("open");
          $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#aprueba").hide();
          $("#rechaza").hide();
        }
        else
        {
          var detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
      }
    });
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
function link(valor, valor1)
{
  var valor, valor1;
  var hoja = 0;
  var ajuste = 0;
  $("#acta_conse").val(valor);
  $("#acta_ano").val(valor1);
  $("#acta_ajuste").val(ajuste);
  $("#acta_hoja").val(hoja);
  formu1.submit();
}
function link1()
{
  var valor = $("#paso").val();
  var valor1 = $("#ano").val();
  var valor2 = $("#sigla").val();
  $("#auto_conse").val(valor);
  $("#auto_ano").val(valor1);
  $("#auto_tipo").val('2');
  $("#auto_ajuste").val('0');
  $("#auto_sigla").val(valor2);
  formu3.submit();
}
function link2(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3;
  var ajuste = $("#ajuste").val();
  $("#auto_conse").val(valor);
  $("#auto_ano").val(valor1);
  $("#auto_tipo").val('2');
  $("#auto_ajuste").val(ajuste);
  $("#auto_sigla").val(valor2);
  formu3.submit();
}
function consultar1()
{
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
      url: "soli_consu1.php",
      data:
      {
        fecha1: $("#fecha1").val(),
        fecha2: $("#fecha2").val()
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
        $("#l_ajuste").show();
        $("#campos").hide();
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
        salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='5%'><b>No.</b></td><td height='35' width='8%'><b>Fecha</b></td><td height='35' width='8%'><b>Unidad</b></td><td height='35' width='8%'><b>Usuario</b></td><td height='35' width='40%'><b>&nbsp;</b></td><td height='35' width='13%'><b>&nbsp;</b></td><td height='35' width='13%'><center><b>Autorización</b></center></td><td height='35' width='5%'>&nbsp;</td></tr></table>";
        salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
        $.each(registros.rows, function (index, value)
        {
          var datos1 = '\"'+value.conse+'\",\"'+value.ano+'\",\"'+value.unidad+'\",\"'+index+'\"';
          salida2 += "<tr><td width='5%' height='35' id='l1_"+index+"'>"+value.conse+"</td>";
          salida2 += "<td width='8%' height='35' id='l2_"+index+"'>"+value.fecha+"</td>";
          salida2 += "<td width='8%' height='35' id='l3_"+index+"'>"+value.unidad+"</td>";
          salida2 += "<td width='8%' height='35' id='l4_"+index+"'>"+value.usuario+"</td>";
          salida2 += "<td width='40%' height='35' id='l5_"+index+"'>&nbsp;</td>";
          salida2 += "<td width='13%' height='35' id='l6_"+index+"'>&nbsp;</td>";
          salida2 += "<td width='13%' height='35' id='l7_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",8); link2("+datos1+");'><img src='imagenes/pdf.png' border='0' title='Ver Autorización'></a></center></td>";
          // Eliminar PDF Final
          if (super1 == "1")
          {
            salida2 += "<td width='5%' height='35' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",8); del_pdf("+datos1+");'><img src='dist/img/delete.png' name='pdf_"+index+"' id='pdf_"+index+"' width='29' height='29' border='0' title='Eliminar PDF'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='5%' height='35' id='l8_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
          }
          salida2 += "</tr>";
          listareg.push(index);
        });
        salida2 += "</table>";
        salida2 += "<br>";
        salida2 += "<center><input type='button' name='limpiar' id='limpiar' value='Nueva Consulta'></center>";
        $("#tabla3").append(salida1);
        $("#resultados5").append(salida2);
        $("#limpiar").button();
        $("#limpiar").click(limpiar);
        $("#limpiar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      }
    });
  }
}
function del_pdf(conse, ano, sigla, index)
{
  var conse, ano, index, archivo;
  archivo = "AutoRecAut_"+sigla+"_"+conse+"_"+ano+".pdf";
  var ruta = "Autorizaciones\\"+archivo;
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
function limpiar()
{
  $("#campos").show();
  $("#tabla3").html('');
  $("#resultados5").html(''); 
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
function excel()
{
  var fecha1 = $("#fecha3").val();
  var fecha2 = $("#fecha4").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_solicitudes2.php",
    data:
    {
      fecha1: fecha1,
      fecha2: fecha2
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
      $("#ano").prop("disabled",true);
      var registros = JSON.parse(data);
      $("#paso_excel").val(registros.valores);
      $("#lnk1").hide();
      $("#lnk2").show();
      $("#lnk2").click();
    }
  });
}
function excel1()
{
  formu_excel.submit();
}
function recarga()
{
  location.href = "auto_recom.php";
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
// 29/01/2024 - Eliminacion de archivos pdf guardados
?>