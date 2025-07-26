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
          <h3>Autorizaci&oacute;n Recurso Adicional</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
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
                  <label><font face="Verdana" size="2">Asunto</font></label>
                  <textarea name="asunto" id="asunto" class="form-control" rows="4" onblur="val_caracteres('asunto');" tabindex="7"></textarea>
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Sustentaci&oacute;n</font></label>
                  <textarea name="sustenta" id="sustenta" class="form-control" rows="4" onblur="val_caracteres('sustenta');" tabindex="8"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Observaciones</font></label>
                  <textarea name="observa" id="observa" class="form-control" rows="4" onblur="val_caracteres('observa');" tabindex="9"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Elaboro</font></label>
                  <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="10" autocomplete="off">
									<div class="espacio1"></div>
                  <input type="text" name="cargo4" id="cargo4" class="form-control" value="<?php echo $car_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="11" autocomplete="off">
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
              <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly">
              <input type="hidden" name="sigla" id="sigla" class="form-control" value="<?php echo $sig_usuario; ?>" readonly="readonly">
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
            </form>
            <form name="formu3" action="ver_autoriza.php" method="post" target="_blank">
              <input type="hidden" name="auto_conse" id="auto_conse" readonly="readonly">
              <input type="hidden" name="auto_ano" id="auto_ano" readonly="readonly">
              <input type="hidden" name="auto_tipo" id="auto_tipo" readonly="readonly">
              <input type="hidden" name="auto_ajuste" id="auto_ajuste" readonly="readonly">
              <input type="hidden" name="auto_sigla" id="auto_sigla" readonly="readonly">
            </form>
            <form name="formu4" action="ver_autoriza1.php" method="post" target="_blank">
              <input type="hidden" name="auto_conse1" id="auto_conse1" readonly="readonly">
              <input type="hidden" name="auto_ano1" id="auto_ano1" readonly="readonly">
              <input type="hidden" name="auto_tipo1" id="auto_tipo1" readonly="readonly">
              <input type="hidden" name="auto_ajuste1" id="auto_ajuste1" readonly="readonly">
              <input type="hidden" name="auto_sigla1" id="auto_sigla1" readonly="readonly">
            </form>
            <form name="formu_excel" id="formu_excel" action="autoriza_x.php" target="_blank" method="post">
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
            <form name="formu1">
              <table width="98%" align="center" border="0">
                <tr>
                  <td height="20" valign="bottom">
                    <div class="row">
                      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        Motivo Rechazo Solicitud de Resursos:&nbsp;&nbsp;&nbsp;<input type="text" name="dat_plan" id="dat_plan" class="c5" onfocus="blur();" readonly="readonly" style="border-style: none;"><input type="hidden" name="num_plan" id="num_plan" class="c10" onfocus="blur();" readonly="readonly" style="border-style: none;"><input type="hidden" name="ano_plan" id="ano_plan" class="c10" onfocus="blur();" readonly="readonly" style="border-style: none;">
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
          <div id="dialogo4">
            <form name="formu2">
              <div id="val_modi1"></div>
            </form>
          </div>
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
  $("#load").hide();
  $("#load1").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 270,
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
  $("#dialogo4").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 300,
    width: 720,
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
        aprueba();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
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
    url: "trae_solicitudes.php",
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
      salida += "<table width='100%' align='center' border='1'>";
      salida += "<tr><td width='3%' height='25'>&nbsp;</td><td width='7%' height='25'><center><b>Solicitud</b></center></td><td width='15%' height='25'><center><b>Fecha</b></center></td><td width='8%' height='25'><center><b>Unidad</b></center></td><td width='9%' height='25'><center><b>Periodo / Año</center></b></td><td width='10%' height='25'><center><b>Recurso</center></b></td><td width='13%' height='25'><center><b>Gastos</b></center></td><td width='13%' height='25'><center><b>Pagos</b></center></td><td width='13%' height='25'><center><b>Total</b></center></td><td width='3%' height='25'>&nbsp;</td><td width='3%' height='25'>&nbsp;</td><td width='3%' height='25'>&nbsp;</td></tr>";
      var var_con = registros.conses.split('|');      
      var var_fec = registros.fechas.split('|');
      var var_per = registros.periodos.split('|');
      var var_ano = registros.anos.split('|');
      var var_val = registros.valores.split('|');
      var var_sig = registros.siglas.split('|');
      var var_uni = registros.unidades.split('|');
      var var_tot = registros.totales.split('|');
      var var_var = registros.pagos.split('|');
      var var_rec = registros.recursos.split('|');
      var var_con1 = var_con.length;
      for (var j=0; j<var_con1-1; j++)
      {
        var var1 = var_con[j];
        var var2 = var_fec[j];
        var var3 = var_per[j];
        var var4 = var_ano[j];
        var var5 = var_sig[j];
        var var6 = var_val[j];
        var var7 = var6.split(',');
        var var8 = var7[0];
        var var9 = parseFloat(var8);
        var9 = var9.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        var var10 = var7[1];
        var var11 = parseInt(var10);
        var11 = var11.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        var var12 = var7[2];
        var var13 = parseFloat(var12);
        var13 = var13.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        var var14 = var_uni[j];
        var paso = "\'"+var1+"\'";
        var paso1 = "\'"+var3+"\'";
        var paso2 = "\'"+var4+"\'";
        var paso3 = var1+","+j;
        var var15 = var_tot[j];
        var15 = parseFloat(var15);
        var var16 = var_var[j];
        var paso4 = "\'"+var16+"\'";
        var paso5 = "\'"+var11+"\'";
        var var17 = var1+"&"+var14+"&"+var16;
        var var18 = var_rec[j];
        salida += '<tr><td width="3%" height="35"><input type="checkbox" name="seleccionados[]" id="chk_'+j+'" value="'+paso3+'" onclick="trae_marca('+j+','+var1+');"></td><td width="7%" height="35"><center>'+var1+'</center></td><td width="15%" height="35">'+var2+'</td><td width="8%" height="35"><center>'+var5+'</center></td><td width="9%" height="35"><center>'+var3+' - '+var4+'<input type="hidden" name="per_'+j+'" id="per_'+j+'" class="c7" value="'+var3+'"><input type="hidden" name="ano_'+j+'" id="ano_'+j+'" class="c7" value="'+var4+'"><input type="hidden" name="uni_'+j+'" id="uni_'+j+'" class="c7" value="'+var14+'"></center></td>';
        salida += '<td width="10%" height="35"><center>'+var18+'</center></td>';
        salida += '<td align="right" width="13%" height="35"><input type="text" name="va1_'+j+'" id="va1_'+j+'" class="c7" value="'+var9+'" onkeyup="paso_val1('+j+'); totaliza('+j+');" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vb1_'+j+'" id="vb1_'+j+'" class="c7" value="'+var8+'"><input type="hidden" name="vo1_'+j+'" id="vo1_'+j+'" class="c7" value="'+var9+'"></td><td align="right" width="13%" height="35">';
        if (var15 > 1)
        {
          salida += '<a href="#" name="gra_'+j+'" id="gra_'+j+'" onclick="modif('+var1+','+var14+','+paso4+','+paso5+','+j+')"><img src="imagenes/editar.png" title="Modificar Valores" width="20" height="20" border="0" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;';
        }
        salida += '<input type="hidden" name="vp_'+j+'" id="vp_'+j+'" class="c7" value="'+var17+'" style="border-style: none; background: transparent; color: #000;"><input type="text" name="va2_'+j+'" id="va2_'+j+'" class="c7" value="'+var11+'" onkeyup="paso_val2('+j+'); totaliza('+j+');" onblur="modif1('+j+');" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vb2_'+j+'" id="vb2_'+j+'" class="c7" value="'+var10+'"><input type="hidden" name="vo2_'+j+'" id="vo2_'+j+'" class="c7" value="'+var11+'"></td><td align="right" width="13%" height="35"><input type="text" name="va3_'+j+'" id="va3_'+j+'" class="c7" value="'+var13+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vb3_'+j+'" id="vb3_'+j+'" class="c7" value="'+var12+'"></td><td width="3%" height="35"><center><a href="#" onclick="link('+paso+','+paso1+','+paso2+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Solicitud"></a></center></td><td width="3%" height="35"><center><a href="#" onclick="ver_anex('+var1+','+var4+')"><img src="imagenes/clip.png" border="0" title="Ver Anexos"></a></center></td><td width="3%" height="35"><center><a href="#" onclick="rechazar('+var1+','+var4+')"><img src="imagenes/anular.png" border="0" title="Rechazar"></a></center></td></tr>';
      }
      salida += '</table>';
      if (total > 0)
      {
        salida += '<br><center><input type="button" name="aceptar" id="aceptar" value="Continuar"><input type="button" name="aceptar2" id="aceptar2" value="Ver Acta">&nbsp;&nbsp;&nbsp;<input type="button" name="aceptar1" id="aceptar1" value="Ver Autorización"></center>';
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
      $("#aceptar2").button();
      $("#aceptar2").click(link2);
      $("#aceptar2").hide();
      $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
    }
  });
}
function modif(valor, valor1, valor2, valor3, valor4)
{
  var valor, valor1, valor2, valor3, valor4;
  var salida = "";
  $("#val_modi1").html('');
  salida += "<table width='90%' align='center' border='0'>";
  var var_ocu = valor2.split('«');
  var var_ocu1 = var_ocu.length;
  var z = 0;
  for (var i=0; i<var_ocu1-1; i++)
  {
    var var_1 = var_ocu[i];
    var var_2 = var_1.split("#");
    z = z+1;
    var con = var_2[0];
    var ced = var_2[1];
    ced = ced.trim();
    var ced1 = ced.substr(ced.length-4);
    ced1 = "XXXX"+ced1;
    var val = var_2[2];
    val = val.trim()
    salida += '<tr><td>Fuente: '+ced1+'</td><td align="right">'+val+'</td><td align="right"><input type="hidden" name="i_'+i+'" id="i_'+i+'" class="c10" value="'+z+'"><input type="hidden" name="c_'+i+'" id="c_'+i+'" class="c10" value="'+ced+'"><input type="hidden" name="p_'+i+'" id="p_'+i+'" class="c10" value="'+val+'"><input type="text" name="v_'+i+'" id="v_'+i+'" class="c7" value="'+val+'" onkeyup="suma('+var_ocu1+');" autocomplete="off"></td></tr>';
  }
  salida += '<tr><td colspan="2">&nbsp;</td><td align="right"><input type="text" name="v_tota" id="v_tota" class="c7" value="'+valor3+'" onfocus="blur();" readonly="readonly"></td></tr>';
  salida += '</table>';
  salida += '<input type="hidden" name="val_paso" id="val_paso" class="c7" value="'+valor4+'">';
  salida += '<input type="hidden" name="val_paso1" id="val_paso1" class="c7" value="'+z+'">';
  salida += '<input type="hidden" name="val_paso2" id="val_paso2" class="c7" value="'+valor+'">';
  salida += '<input type="hidden" name="val_paso3" id="val_paso3" class="c7" value="'+valor1+'">';
  $("#val_modi1").append(salida);
  for (var j=0; j<var_ocu1-1; j++)
  {
    $("#v_"+j).maskMoney();
  }
  $("#dialogo4").dialog("open");
}
function modif1(valor)
{
  var paso_final= "";
  var valor, valor1;
  valor1 = $("#vp_"+valor).val();
  var var_ocu = valor1.split('&');
  var paso1 = var_ocu[0];
  var paso2 = var_ocu[1];
  var paso3 = var_ocu[2];
  var var_ocu1 = paso3.split('#');
  var paso4 = var_ocu1[0];
  var paso5 = var_ocu1[1];
  var paso6 = var_ocu1[2];
  var paso7 = $("#va2_"+valor).val();
  paso_final = paso1+"&"+paso2+"&"+paso4+"#"+paso5+"#"+paso7+"#«";
  $("#vp_"+valor).val(paso_final);
}
function suma(valor)
{
  var valor;
  valor = valor-1;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  for (i=0; i<valor; i++)
  {
    valor1 = $("#v_"+i).val();
    valor1 = parseFloat(valor1.replace(/,/g,''));
    valor2 = parseFloat(valor1);
    valor3 = valor3+valor2;
  if (isNaN(valor3))
  {
      valor3 = "0.00";
      valor3 = parseFloat(valor3);
      $("#v_"+i).val('0.00');
    }
  }
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#v_tota").val(valor3);
}
function aprueba()
{
  var var1, var2, var3, var4, var5, var6, var7, var8, var9, var10, var11, var12, var13, var14, var15;
  var1 = $("#val_paso").val();
  var2 = $("#val_paso1").val();
  var3 = $("#v_tota").val();
  var4 = "";
  var5 = $("#val_paso2").val();
  var6 = $("#val_paso3").val();
  var j = 0;
  var valor, valor, valor2;
  for (i=0;i<var2;i++)
  {
    j = j+1;
    var v1 = $("#i_"+i).val();
    var v2 = $("#c_"+i).val();
    var v3 = $("#v_"+i).val();
    var4 += v1+"#"+v2+"#"+v3+"#«";

  }
  var4 = var5+"&"+var6+"&"+var4;
  $("#vp_"+var1).val(var4);
  $("#gra_"+var1).hide();
  $("#va2_"+var1).val(var3);
  paso_val2(var1);
  totaliza(var1);
  $("#va2_"+var1).prop("disabled",true);
  $("#dialogo4").dialog("close");
}
function trae_marca(valor, valor1)
{
  var valor, valor1, valor2, valor3;
  if ($("#chk_"+valor).is(":checked"))
  {
    $("#va1_"+valor).prop("disabled",false);
    $("#va2_"+valor).prop("disabled",false);
    $("#va1_"+valor).css("background-color","#FFFF00");
    $("#va2_"+valor).css("background-color","#FFFF00");
    $("#va3_"+valor).css("background-color","#FFFF00");
    $("#gra_"+valor).show();
  }
  else
  {
    $("#va1_"+valor).prop("disabled",true);
    $("#va2_"+valor).prop("disabled",true);
    $("#va1_"+valor).css("background-color","#F8F8F8");
    $("#va2_"+valor).css("background-color","#F8F8F8");
    $("#va3_"+valor).css("background-color","#F8F8F8");
    $("#gra_"+valor).hide();
    valor2 = $("#vo1_"+valor).val();
    $("#va1_"+valor).val(valor2);
    paso_val1(valor);
    valor3 = $("#vo2_"+valor).val();
    $("#va2_"+valor).val(valor3);
    paso_val2(valor);
    totaliza(valor);
  }
}
function paso_val1(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('va1_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vb1_"+valor).val(valor1);
}
function paso_val2(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('va2_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vb2_"+valor).val(valor1);
}
function paso_val3(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('va3_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vb3_"+valor).val(valor1);
}
function totaliza(valor)
{
  var valor;
  var valor1;
  var valor2;
  var valor3;
  var valor4;
  valor3 = 0;
  valor4 = 0;
  valor1 = document.getElementById('vb1_'+valor).value;
  valor1 = parseInt(valor1);
  valor2 = document.getElementById('vb2_'+valor).value;
  valor2 = parseInt(valor2);
  valor3 = valor1+valor2;
  valor4 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#va3_"+valor).val(valor4);
  paso_val3(valor);
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
        valor0 = $("#uni_"+paso2).val();
        valor1 = $("#vb1_"+paso2).val();
        valor2 = $("#vb2_"+paso2).val();
        valor3 = $("#vb3_"+paso2).val();
        valor4 = $("#per_"+paso2).val();
        valor5 = $("#ano_"+paso2).val();
        valor6 = $("#vp_"+paso2).val();
        document.getElementById('v_paso0').value = document.getElementById('v_paso0').value+valor0+"|";
        document.getElementById('v_paso1').value = document.getElementById('v_paso1').value+valor1+"|";
        document.getElementById('v_paso2').value = document.getElementById('v_paso2').value+valor2+"|";
        document.getElementById('v_paso3').value = document.getElementById('v_paso3').value+valor3+"|";
        document.getElementById('v_paso4').value = document.getElementById('v_paso4').value+valor4+"|";
        document.getElementById('v_paso5').value = document.getElementById('v_paso5').value+valor5+"|";
        document.getElementById('v_paso6').value = document.getElementById('v_paso6').value+paso1+"|";
        document.getElementById('v_paso7').value = document.getElementById('v_paso7').value+valor6+"|";
      }
    }
  );
  var valida = seleccionadosarray.length;
  if (valida == "0")
  {
    detalle = "<center><h3>Debe seleccionar una Solicitud</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#aceptar").show();
  }
  else
  {
    var salida = true, detalle = '';
    var valor0 = $("#asunto").val();
    valor0 = valor0.trim().length;
    if (valor0 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar un Asunto</h3></center>";
      $("#asunto").addClass("ui-state-error");
    }
    else
    {
      $("#asunto").removeClass("ui-state-error");
    }
    var valor1 = $("#sustenta").val();
    valor1 = valor1.trim().length;
    if (valor1 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar una Sustentación</h3></center>";
      $("#sustenta").addClass("ui-state-error");
    }
    else
    {
      $("#sustenta").removeClass("ui-state-error");
    }
    var valor2 = $("#elaboro").val();
    valor2 = valor2.trim().length;
    if (valor2 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar el campo Elaboro</h3></center>";
      $("#elaboro").addClass("ui-state-error");
    }
    else
    {
      $("#elaboro").removeClass("ui-state-error");
    }
    var valor3 = $("#cargo4").val();
    valor3 = valor3.trim().length;
    if (valor3 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar el cargo Elaboro</h3></center>";
      $("#cargo4").addClass("ui-state-error");
    }
    else
    {
      $("#cargo4").removeClass("ui-state-error");
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
        url: "auto_grab.php",
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
          firma1: $("#firma1").val(),
          cargo1: $("#cargo1").val(),
          firma2: $("#firma2").val(),
          cargo2: $("#cargo2").val(),
          firma3: $("#firma3").val(),
          cargo3: $("#cargo3").val(),
          elaboro: $("#elaboro").val(),
          cargo4: $("#cargo4").val(),
          asunto: $("#asunto").val(),
          sustenta: $("#sustenta").val(),
          observa: $("#observa").val()
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
            $("#cargo4").prop("disabled",true);
            $("#asunto").prop("disabled",true);
            $("#sustenta").prop("disabled",true);
            $("#observa").prop("disabled",true);
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
      url: "noti_grab10.php",
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
          var detalle  = "<center><h3>Rechazo de Solicitud de Recursos<br>"+numero+" / "+ano+" registrado correctamente</h3></center>"; 
          $("#dialogo3").html(detalle);
          $("#dialogo3").dialog("open");
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
function link(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  var url = "./fpdf/641.php?conse="+valor+"&ano="+valor2;
  window.open(url, '_blank');
}
function link1()
{
  var valor = $("#paso").val();
  var valor1 = $("#ano").val();
  var valor2 = $("#sigla").val();
  $("#auto_conse").val(valor);
  $("#auto_ano").val(valor1);
  $("#auto_tipo").val('1');
  $("#auto_ajuste").val('0');
  $("#auto_sigla").val(valor2);
  formu3.submit();
}
function link2()
{
  var valor = $("#paso").val();
  var valor1 = $("#ano").val();
  var url1 = "./fpdf/600.php?conse="+valor+"&ano="+valor1;
  window.open(url1, '_blank');
}
function link3(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3;
  var ajuste = $("#ajuste").val();
  $("#auto_conse").val(valor);
  $("#auto_ano").val(valor1);
  $("#auto_tipo").val('1');
  $("#auto_ajuste").val(ajuste);
  $("#auto_sigla").val(valor2);
  formu3.submit();
}
function link4(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3;
  var ajuste = $("#ajuste").val();
  $("#auto_conse1").val(valor);
  $("#auto_ano1").val(valor1);
  $("#auto_tipo1").val('1');
  $("#auto_ajuste1").val(ajuste);
  $("#auto_sigla1").val(valor2);
  formu4.submit();
}
function ver_anex(valor, valor1)
{
  var valor, valor1;
  var url = "./archivos/index1.php?ano="+valor1+"&conse="+valor;
  var ventana = window.open(url,'','height=480,width=800');
  if (window.focus) 
  {
    ventana.focus();
  }
  return false;
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
      url: "soli_consu.php",
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
        salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='5%'><b>No.</b></td><td height='35' width='8%'><b>Fecha</b></td><td height='35' width='8%'><b>Unidad</b></td><td height='35' width='8%'><b>Usuario</b></td><td height='35' width='38%'><b>Solicitudes</b></td><td height='35' width='8%'><b>Año</b></td><td height='35' width='10%'><center><b>Acta</b></center></td><td height='35' width='10%'><center><b>Autorización</b></center></td><td height='35' width='5%'>&nbsp;</td></tr></table>";
        salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
        $.each(registros.rows, function (index, value)
        {
          var datos1 = '\"'+value.conse+'\",\"'+value.ano+'\",\"'+value.unidad+'\",\"'+index+'\"';
          salida2 += "<tr><td width='5%' height='35' id='l1_"+index+"'>"+value.conse+"</td>";
          salida2 += "<td width='8%' height='35' id='l2_"+index+"'>"+value.fecha+"</td>";
          salida2 += "<td width='8%' height='35' id='l3_"+index+"'>"+value.unidad+"</td>";
          salida2 += "<td width='8%' height='35' id='l4_"+index+"'>"+value.usuario+"</td>";
          salida2 += "<td width='38%' height='35' id='l5_"+index+"'>"+value.planes+"</td>";
          salida2 += "<td width='8%' height='35' id='l6_"+index+"'>"+value.ano+"</td>";
          salida2 += "<td width='10%' height='35' id='l7_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); link4("+datos1+");'><img src='imagenes/pdf.png' border='0' title='Ver Acta'></a></center></td>";
          salida2 += "<td width='10%' height='35' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); link3("+datos1+");'><img src='imagenes/pdf.png' border='0' title='Ver Autorización'></a></center></td>";
          // Eliminar PDF Final
          if (super1 == "1")
          {
            salida2 += "<td width='5%' height='35' id='l9_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); del_pdf("+datos1+");'><img src='dist/img/delete.png' name='pdf_"+index+"' id='pdf_"+index+"' width='29' height='29' border='0' title='Eliminar PDF'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='5%' height='35' id='l9_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
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
  archivo = "ActaEvaCom_"+sigla+"_"+conse+"_"+ano+".pdf";
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
function limpiar()
{
  $("#campos").show();
  $("#tabla3").html('');
  $("#resultados5").html(''); 
}
function excel()
{
  var fecha1 = $("#fecha3").val();
  var fecha2 = $("#fecha4").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_solicitudes1.php",
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
function excel1()
{
  formu_excel.submit();
}
function recarga()
{
  location.href = "auto_recur.php";
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
// 26/01/2024 - Ajuste eliminacion de archivos pdf guardados
// 22/02/2024 - Ajuste envio sigla generacion pdf
// 25/07/2024 - Ajuste centavos en solicitudes sin recursos
// 25/07/2024 - Ajuste inclusion cargo elaboro
// 24/02/2025 - Ajuste inclusion campo recurso adicional
?>