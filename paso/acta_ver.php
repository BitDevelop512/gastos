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
  $ano = date('Y');
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
  <link rel="stylesheet" id="theme" href="js8/selectric.css">
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
          <h3>Informe de Verificaci&oacute;n  GGRR</h3>
          <div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Radicado No.</font></label>
                  <input type="text" name="numero" id="numero" class="form-control numero" value="" onkeypress="return check1(event);" onblur="verifica();" maxlength="30" tabindex="1" autocomplete="off">
                  <input type="hidden" name="conse" id="conse" class="form-control" value="0" readonly="readonly">
                  <input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly">
                  <input type="hidden" name="firmas" id="firmas" class="form-control" value="" readonly="readonly">
                  <input type="hidden" name="firmas1" id="firmas1" class="form-control" value="" readonly="readonly">
                  <input type="hidden" name="firmas2" id="firmas2" class="form-control" value="" readonly="readonly">
                  <input type="hidden" name="observaciones" id="observaciones" class="form-control" value="" readonly="readonly">
                  <input type="hidden" name="actu" id="actu" class="form-control" value="0" readonly="readonly">
                  <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_click" id="v_click" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_paso1" id="v_paso1" class="form-control" value="" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_paso2" id="v_paso2" class="form-control" value="" readonly="readonly" tabindex="0">
                  <input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly">
                  <div id="vinculo"></div>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Lugar</font></label>
                  <input type="text" name="lugar" id="lugar" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="60" tabindex="2" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha" id="fecha" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="3">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Unidad Centralizadora</font></label>
                  <input type="text" name="unidad" id="unidad" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="30" tabindex="4" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">              
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Periodo de Ejecuci&oacute;n</font></label>
                  <input type="text" name="periodo" id="periodo" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" tabindex="5" autocomplete="off">
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Plan de Verificaci&oacute;n No.</font></label>
                  <input type="text" name="plan" id="plan" class="form-control" value="" onkeypress="return check1(event);" maxlength="60" tabindex="6" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha de Inicio</font></label>
                  <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="7">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha de T&eacute;rmino</font></label>
                  <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="8">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Responsable del &Aacute;rea y/o Proceso</font></label>
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
                  <div class="espacio1"></div>
                  <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0" tabindex="9"></a>
                </div>
              </div>
              <br>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Documentos Analizados</font></label>
                  <textarea name="documentos" id="documentos" class="form-control" rows="5" onblur="val_caracteres('documentos');" tabindex="10"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Aspectos Positivos</font></label>
                  <textarea name="aspectos" id="aspectos" class="form-control" rows="5" onblur="val_caracteres('aspectos');" tabindex="11"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Observaciones</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <div id="add_form1">
                    <table width="100%" align="center" border="0">
                      <tr>
                        <td colspan="6"></td>
                      </tr>
                    </table>
                  </div>
                  <div class="espacio1"></div>
                  <a href="#" name="add_field1" id="add_field1"><img src="imagenes/boton1.jpg" border="0" tabindex="12"></a>
                  <input type="hidden" name="contador" id="contador" class="form-control" value="0" tabindex="13" readonly="readonly">
                  <input type="hidden" name="contador1" id="contador1" class="form-control" value="0" tabindex="14" readonly="readonly">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Recomendaciones</font></label>
                  <textarea name="recomendaciones" id="recomendaciones" class="form-control" rows="5" onblur="val_caracteres('recomendaciones');" tabindex="15"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Reconocimientos</font></label>
                  <textarea name="reconocimientos" id="reconocimientos" class="form-control" rows="5" onblur="val_caracteres('reconocimientos');" tabindex="16"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Otras Actividades</font></label>
                  <textarea name="actividades" id="actividades" class="form-control" rows="5" onblur="val_caracteres('actividades');" tabindex="17"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Funcionario(s) designado(s) para la verificaci&oacute;n</font></label>
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
                  <div id="add_form2">
                    <table width="100%" align="center" border="0">
                      <tr>
                        <td colspan="2"></td>
                      </tr>
                    </table>
                  </div>
                  <div class="espacio1"></div>
                  <a href="#" name="add_field2" id="add_field2"><img src="imagenes/boton1.jpg" border="0" tabindex="18"></a>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Funcionario(s) que presentan la verificaci&oacute;n</font></label>
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
                  <div id="add_form3">
                    <table width="100%" align="center" border="0">
                      <tr>
                        <td colspan="2"></td>
                      </tr>
                    </table>
                  </div>
                  <div class="espacio1"></div>
                  <a href="#" name="add_field3" id="add_field3"><img src="imagenes/boton1.jpg" border="0" tabindex="19"></a>
                </div>
              </div>
              <br>
              <br>
              <div class="row">
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Elabor&oacute;</font></label>
                  <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="20" autocomplete="off">
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Revis&oacute;</font></label>
                  <input type="text" name="reviso" id="reviso" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="21" autocomplete="off">
                </div>
              </div>
              <br>
              <center>
                <input type="button" name="aceptar" id="aceptar" value="Continuar" tabindex="22">
                <input type="button" name="aceptar2" id="aceptar2" value="Actualizar" tabindex="23">
                &nbsp;&nbsp;&nbsp;
                <input type="button" name="aceptar1" id="aceptar1" value="Visualizar" tabindex="24">
                &nbsp;&nbsp;&nbsp;
                <input type="button" name="aceptar3" id="aceptar3" value="Cargar Informe Firmado" tabindex="25">
              </center>
            </form>
            <form name="formu_excel" id="formu_excel" action="acta_ver_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
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
                <input type="text" name="fecha3" id="fecha3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">&nbsp;</font></label>
                <input type="text" name="fecha4" id="fecha4" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                <label><font face="Verdana" size="2">Unidad Centralizadora</font></label>
                <?php
                $menu1_1 = odbc_exec($conexion,"SELECT DISTINCT centraliza FROM cx_act_ver WHERE usuario='$usu_usuario' ORDER BY centraliza");
                $menu1 = "<select name='centra' id='centra' class='form-control select2'>";
                $i = 1;
                $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
                while($i<$row=odbc_fetch_array($menu1_1))
                {
                  $nombre = trim(utf8_encode($row['centraliza']));
                  $nombre1 = "'".$nombre."'";
                  $menu1 .= "\n<option value=".$nombre1.">".$nombre."</option>";
                  $i++;
                }
                $menu1 .= "\n</select>";
                echo $menu1;
                ?>
              </div>
              <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                <label><font face="Verdana" size="2">Unidad</font></label>
                <?php
                $menu1_1 = odbc_exec($conexion,"SELECT subdependencia, sigla FROM cx_org_sub ORDER BY sigla");
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
              <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                <label><font face="Verdana" size="2">Tipo de Documento</font></label>
                <?php
                $menu1_1 = odbc_exec($conexion,"SELECT codigo, nombre FROM cx_ctr_doc WHERE estado='' ORDER BY nombre");
                $menu1 = "<select name='documento' id='documento' class='form-control select2'>";
                $i = 1;
                $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
                while($i<$row=odbc_fetch_array($menu1_1))
                {
                  $nombre = trim(utf8_encode($row['nombre']));
                  $menu1 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                  $i++;
                }
                $menu1 .= "\n</select>";
                echo $menu1;
                ?>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <br>
                <center>
                  <input type="button" name="consultar" id="consultar" value="Consultar">
                </center>
              </div>
            </div>
            <br>
            <div id="tabla7"></div>
            <div id="resultados5"></div>
            <br>
            <center>
              <label for="ajuste">Ajuste de Lineas Firma:</label>
              <input name="ajuste" id="ajuste" class="numero" onkeypress="return check(event);" value="0">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="checkbox" name="chk_hoja" id="chk_hoja" value="0">
              <label><font face="Verdana" size="2">Incluir Hoja en Blanco</font></label>
            </center>
            <form name="formu1" action="ver_verificacion.php" method="post" target="_blank">
              <input type="hidden" name="acta_acta" id="acta_acta" readonly="readonly">
              <input type="hidden" name="acta_conse" id="acta_conse" readonly="readonly">
              <input type="hidden" name="acta_ano" id="acta_ano" readonly="readonly">
              <input type="hidden" name="acta_ajuste" id="acta_ajuste" readonly="readonly">
              <input type="hidden" name="acta_hoja" id="acta_hoja" readonly="readonly">
            </form>
          </div>
          <div id="dialogo"></div>
          <div id="dialogo1"></div>
          <div id="dialogo2"></div>
          <div id="dialogo3"></div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="js/jquery.quicksearch.js?1.0.0" type="text/javascript"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
<script src="js8/jquery.selectric.js"></script>
<style>
.ui-widget-header
{
  color: #000000;
  font-weight: bold;
}
.estilo1
{
  display: inline;
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
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 210,
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
  $("#dialogo3").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
    width: 520,
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
        enviar();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(link);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(pregunta);
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").button();
  $("#aceptar3").click(pregunta1);
  $("#aceptar3").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").hide();
  $("#aceptar1").hide();
  $("#aceptar2").hide();
  $("#aceptar3").hide();
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#numero").focus();
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
      $("#add_form table").append('<tr><td width="45%" class="espacio1"><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="45%" class="espacio2"><input type="text" name="car_'+z+'" id="car_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="10%"><div id="men_'+z+'"><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      x_1++;
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
  // Observaciones
  var InputsWrapper1   = $("#add_form1 table tr");
  var AddButton1       = $("#add_field1");
  var x_2              = InputsWrapper1.length;
  var FieldCount1      = 1;
  $(AddButton1).click(function (e) {
    var paso1 = $("#v_paso1").val();
    var paso2 = $("#v_paso2").val();
    var a = x_2;
    var val1 = "'doc_"+a+"'";
    FieldCount1++;
    if (a == "1")
    {
      $("#add_form1 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><center><b>No.</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>UNIDAD</b></center></div><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><center><b>OBSERVACIONES</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>FECHA</b></center></div><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><center><b>TIPO SOPORTE</b></center></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">&nbsp;</div></div></td></tr>');
      $("#add_form1 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><input type="text" name="con_'+a+'" id="con_'+a+'" class="form-control fecha" value="'+a+'" onkeypress="return check(event);"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><select name="uni_'+a+'" id="uni_'+a+'" class="form-control select2"></select></div><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><textarea name="doc_'+a+'" id="doc_'+a+'" class="form-control" rows="1" onblur="val_caracteres('+val1+');"></textarea></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="fec_'+a+'" id="fec_'+a+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></div><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><select name="sop_'+a+'" id="sop_'+a+'" class="form-control select2"></select></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><div id="mes_'+a+'"><a href="#" class="removeclass1"><img src="imagenes/boton2.jpg" border="0"></a></div></div></div></td></tr>');
    }
    else
    {
      $("#add_form1 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><input type="text" name="con_'+a+'" id="con_'+a+'" class="form-control fecha" value="'+a+'" onkeypress="return check(event);"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><select name="uni_'+a+'" id="uni_'+a+'" class="form-control select2"></select></div><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><textarea name="doc_'+a+'" id="doc_'+a+'" class="form-control" rows="1" onblur="val_caracteres('+val1+');"></textarea></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="fec_'+a+'" id="fec_'+a+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></div><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><select name="sop_'+a+'" id="sop_'+a+'" class="form-control select2"></select></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><div id="mes_'+a+'"><a href="#" class="removeclass1"><img src="imagenes/boton2.jpg" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="#" onclick="adiciona('+a+')"><img src="imagenes/boton1.jpg" border="0"></a></div></div></div></td></tr>');
    }
    $("#contador").val(a);
    $("#uni_"+a).append(paso1);
    $("#uni_"+a).select2({
      tags: false,
      allowClear: false,
      closeOnSelect: true
    });
    $("#fec_"+a).datepicker({
      dateFormat: "yy/mm/dd",
      maxDate: 0,
      changeYear: true,
      changeMonth: true
    });
    $("#sop_"+a).append(paso2);
    $("#uni_"+a).focus();
    x_2++;
    return false;
  });
  $("body").on("click",".removeclass1", function(e) {
    $(this).closest('tr').remove();
    reenumera();
    return false;
  });
  // Funcionarios
  var InputsWrapper2   = $("#add_form2 table tr");
  var AddButton2       = $("#add_field2");
  var x_3              = InputsWrapper2.length;
  var FieldCount2      = 1;
  $(AddButton2).click(function (e) {
    if(x_3 <= MaxInputs)
    {
      var b = x_3;
      var w = b-1;
      FieldCount2++;
      $("#add_form2 table").append('<tr><td width="45%" class="espacio1"><input type="text" name="nom1_'+b+'" id="nom1_'+b+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="45%" class="espacio2"><input type="text" name="car1_'+b+'" id="car1_'+b+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="10%"><div id="men1_'+b+'"><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      x_3++;
      $("#nom1_"+b).focus();
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    if(x_3 > 1)
    {
      $(this).closest('tr').remove();
    }
    return false;
  });
  // Otros Funcionarios
  var InputsWrapper3   = $("#add_form3 table tr");
  var AddButton3       = $("#add_field3");
  var x_4              = InputsWrapper3.length;
  var FieldCount3      = 1;
  $(AddButton3).click(function (e) {
    if(x_4 <= MaxInputs)
    {
      var c = x_4;
      var v = c-1;
      FieldCount3++;
      $("#add_form3 table").append('<tr><td width="45%" class="espacio1"><input type="text" name="nom2_'+c+'" id="nom2_'+c+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="45%" class="espacio2"><input type="text" name="car2_'+c+'" id="car2_'+c+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="10%"><div id="men2_'+c+'"><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      x_4++;
      $("#nom2_"+c).focus();
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    if(x_4 > 1)
    {
      $(this).closest('tr').remove();
    }
    return false;
  });
  $("#ajuste").spinner({ min: 0 });
  $("#ajuste").width(50);
  trae_unidades();
  trae_documentos();
});
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
      $("#v_paso1").val(salida);
    }
  });
}
function trae_documentos()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_docu.php",
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
      $("#v_paso2").val(salida);
    }
  });
}
function verifica()
{
  var valor = $("#numero").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    $("#aceptar").hide();
  }
  else
  {
    $("#aceptar").show();
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
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta1()
{
  var detalle = "<center><h3><font color='#ff0000'>El Informe no podr&aacute; ser modificado.</font><br>Esta seguro de continuar ?</h3></center>";
  $("#dialogo3").html(detalle);
  $("#dialogo3").dialog("open");
  $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function validacionData()
{
  var salida = true, detalle = '';
  // Responsables
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
  // Funcionarios
  document.getElementById('firmas1').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('nom1_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu.elements[i].name;
    if (saux1.indexOf('car1_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
      valor2 = valor+"»"+valor1;
      document.getElementById('firmas1').value = document.getElementById('firmas1').value+valor2+"|";
    }
  }
  // Otros Funcionarios
  document.getElementById('firmas2').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('nom2_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu.elements[i].name;
    if (saux1.indexOf('car2_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
      valor2 = valor+"»"+valor1;
      document.getElementById('firmas2').value = document.getElementById('firmas2').value+valor2+"|";
    }
  }
  // Observaciones
  document.getElementById('observaciones').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('con_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu.elements[i].name;
    if (saux1.indexOf('uni_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu.elements[i].name;
    if (saux2.indexOf('doc_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
    }
    saux3 = document.formu.elements[i].name;
    if (saux3.indexOf('fec_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
    }
    saux4 = document.formu.elements[i].name;
    if (saux4.indexOf('sop_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
      valor5 = valor+"»"+valor1+"»"+valor2+"»"+valor3+"»"+valor4;
      document.getElementById('observaciones').value = document.getElementById('observaciones').value+valor5+"|";
    }
  }
  salida = true;
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
    var acta = $("#numero").val();
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "actv_grab.php",
      data:
      {
        tipo: valor,
        acta: acta,
        conse: $("#conse").val(),
        ano: $("#ano").val(),
        lugar: $("#lugar").val(),
        fecha: $("#fecha").val(),
        centraliza: $("#unidad").val(),
        firmas: $("#firmas").val(),
        firmas1: $("#firmas1").val(),
        firmas2: $("#firmas2").val(),
        periodo: $("#periodo").val(),
        plan: $("#plan").val(),
        fecha1: $("#fecha1").val(),
        fecha2: $("#fecha2").val(),
        documentos: $("#documentos").val(),
        aspectos:  $("#aspectos").val(),
        observaciones: $("#observaciones").val(),
        recomendaciones: $("#recomendaciones").val(),
        reconocimientos: $("#reconocimientos").val(),
        actividades: $("#actividades").val(),
        elaboro: $("#elaboro").val(),
        reviso: $("#reviso").val(),
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
        var ano = registros.ano;
        if (salida == "1")
        {
          $("#aceptar").hide();
          $("#aceptar2").hide();
          $("#aceptar1").show();
          $("#aceptar3").show();
          $("#conse").val(consecu);
          $("#acta_acta").val(acta);
          $("#acta_conse").val(consecu);
          $("#acta_ano").val(ano);
          $("#numero").prop("disabled",true);
          $("#lugar").prop("disabled",true);
          $("#fecha").prop("disabled",true);
          $("#unidad").prop("disabled",true);
          $("#periodo").prop("disabled",true);
          $("#plan").prop("disabled",true);
          $("#fecha1").prop("disabled",true);
          $("#fecha2").prop("disabled",true);
          $("#documentos").prop("disabled",true);
          $("#aspectos").prop("disabled",true);
          $("#recomendaciones").prop("disabled",true);
          $("#reconocimientos").prop("disabled",true);
          $("#actividades").prop("disabled",true);
          $("#elaboro").prop("disabled",true);
          $("#reviso").prop("disabled",true);
          for (i=0;i<document.formu.elements.length;i++)
          {
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
            saux = document.formu.elements[i].name;
            if (saux.indexOf('nom1_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('car1_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('nom2_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('car2_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('con_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('uni_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('doc_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('fec_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('sop_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
          $("#add_field").hide();
          $("#add_field1").hide();
          $("#add_field2").hide();
          $("#add_field3").hide();
          for (k=1;k<=70;k++)
          {
            $("#men_"+k).hide();
            $("#men1_"+k).hide();
            $("#men2_"+k).hide();
            $("#mes_"+k).hide();
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
function adiciona(valor)
{
  var valor;
  valor = parseInt(valor);
  valor = valor+1;
  var valor1 = $("#contador").val();
  valor1 = parseInt(valor1);
  valor1 = valor1+1;
  $("#contador").val(valor1);
  var valor2 = $("#contador1").val();
  valor2 = parseInt(valor2);
  valor = valor+valor2;
  valor2 = valor2+1;
  $("#contador1").val(valor2);
  var val1 = "'doc_"+valor1+"'";
  var html = '<tr><td class="espacio1"><div class="row"><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><input type="text" name="con_'+valor1+'" id="con_'+valor1+'" class="form-control fecha" value="'+valor1+'" onkeypress="return check(event);"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><select name="uni_'+valor1+'" id="uni_'+valor1+'" class="form-control select2"></select></div><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><textarea name="doc_'+valor1+'" id="doc_'+valor1+'" class="form-control" rows="1" onblur="val_caracteres('+val1+');"></textarea></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="fec_'+valor1+'" id="fec_'+valor1+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></div><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><select name="sop_'+valor1+'" id="sop_'+valor1+'" class="form-control select2"></select></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><div id="mes_'+valor1+'"><a href="#" class="removeclass1"><img src="imagenes/boton2.jpg" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="#" onclick="adiciona();"><img src="imagenes/boton1.jpg" border="0"></a></div></div></div></td></tr>'
  $('#add_form1 table > tbody > tr:eq('+valor+')').after(html);
  var paso1 = $("#v_paso1").val();
  var paso2 = $("#v_paso2").val();
  $("#uni_"+valor1).append(paso1);
  $("#uni_"+valor1).select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#fec_"+valor1).datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#sop_"+valor1).append(paso2);
  $("#uni_"+valor1).focus();
  reenumera();
}
function reenumera()
{
  var contador = 1;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('con_')!=-1)
    {
      $("#"+saux).val(contador);
      contador ++;
    }
  }
}
function consultar()
{
  var super1 = $("#super").val();
  var salida = true;
  if (super1 == "1")
  {
    var fecha2 = $("#fecha4").val();
    if (fecha2 == "")
    {
      salida = false;
      alerta("Debe seleccionar fecha final");
    }
    var fecha1 = $("#fecha3").val();
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
      url: "actv_consu.php",
      data:
      {
        fecha1: $("#fecha3").val(),
        fecha2: $("#fecha4").val(),
        centra: $("#centra").val(),
        unidad: $("#unidad1").val(),
        documento: $("#documento").val()
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
        $("#tabla7").html('');
        $("#resultados5").html('');
        var registros = JSON.parse(data);
        var valida,valida1;
        var salida1 = "";
        var salida2 = "";
        listareg = [];
        valida = registros.salida;
        valida1 = registros.total;
        salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table><br>";
        salida1 += "<div class='row'><div class='col col-lg-3 col-sm-3 col-md-3 col-xs-3'><input type='text' name='buscar' id='buscar' placeholder='Buscar...' class='form-control' autocomplete='off' /></div><div class='col col-lg-8 col-sm-8 col-md-8 col-xs-8'></div>";
        salida1 += "<div class='col col-lg-1 col-sm-1 col-md-1 col-xs-1'><center><a href='#' id='excel' onclick='excel(); return false;'><img src='dist/img/excel.png' title='Descargar Resultados a Excel - SAP'></a></center></div></div>";
        salida1 += "<br>";
        salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='10%'><b>Informe</b></td><td height='35' width='10%'><b>Fecha</b></td><td height='35' width='13%'><b>Lugar</b></td><td height='35' width='13%'><b>Unidad</b></td><td height='35' width='10%'><b>F. Inicio</b></td><td height='35' width='10%'><b>F. Termino</b></td><td height='35' width='14%'><center><b>Periodo</b></center></td><td width='5%' height='35'>&nbsp;</td><td width='5%' height='35'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td></tr></table>";
        salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
        var v_var1 = "";
        $.each(registros.rows, function (index, value)
        {
          var estado = value.estado;
          var datos = '\"'+value.conse+'\",\"'+value.acta+'\",\"'+value.ano+'\"';
          salida2 += "<tr><td height='35' width='10%' id='l1_"+index+"'>"+value.acta+"</td>";
          salida2 += "<td height='35' width='10%' id='l2_"+index+"'>"+value.fecha+"</td>";
          salida2 += "<td height='35' width='13%' id='l3_"+index+"'>"+value.lugar+"</td>";
          salida2 += "<td height='35' width='13%' id='l4_"+index+"'>"+value.centraliza+"</td>";
          salida2 += "<td height='35' width='10%' id='l5_"+index+"'>"+value.fecha1+"</td>";
          salida2 += "<td height='35' width='10%' id='l6_"+index+"'>"+value.fecha2+"</td>";
          salida2 += "<td height='35' width='14%' id='l7_"+index+"'>"+value.periodo+"</td>";
          if (estado == "")
          {
            salida2 += "<td width='5%' height='35' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",10); modif("+datos+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='5%' height='35' id='l8_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
          }
          salida2 += "<td width='5%' height='35' id='l9_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",10); link1("+datos+")'><img src='imagenes/pdf.png' border='0' title='Visualizar Informe'></a></center></td>";
          if (estado !== "")
          {
            salida2 += "<td width='5%' height='35' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",10); link2("+datos+")'><img src='imagenes/pdf.png' border='0' title='Visualizar Informe Firmado'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='5%' height='35' id='l10_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
          }
          v_var1 += value.acta+"|"+value.fecha+"|"+value.lugar+"|"+value.centraliza+"|"+value.fecha1+"|"+value.fecha2+"|"+value.periodo+"|"+value.observa+"|"+value.planes+"|#";
          listareg.push(index);
        });
        salida2 += "</table>";
        $("#paso_excel").val(v_var1);
        $("#tabla7").append(salida1);
        $("#resultados5").append(salida2);
        $("#buscar").quicksearch("table tbody tr");
      }
    });
  }
}
function modif(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "actv_consu1.php",
    data:
    {
      conse: valor,
      acta: valor1,
      ano: valor2
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
      var con_firmas = 0;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('nom_')!=-1)
        {
          con_firmas ++;
        }
      }
      if (con_firmas == "0")
      {
        $("#add_field").click(); 
      }
      var con_observaciones = 0;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('con_')!=-1)
        {
          con_observaciones ++;
        }
      }
      var con_firmas1 = 0;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('nom1_')!=-1)
        {
          con_firmas1 ++;
        }
      }
      if (con_firmas1 == "0")
      {
        $("#add_field2").click(); 
      }
      var con_firmas2 = 0;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('nom2_')!=-1)
        {
          con_firmas2 ++;
        }
      }
      if (con_firmas2 == "0")
      {
        $("#add_field3").click(); 
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
      // Firmas1
      var firmas1 = registros.firmas1;
      var var_ocu = firmas1.split('|');
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
        $("#nom1_"+z).val(nom);
        $("#car1_"+z).val(car);
        if (con_firmas1 > var_ocu2)
        {
        }
        else
        {
          if (i < var_ocu2)
          {
            $("#add_field2").click();
          }
        }
      }
      // Firmas2
      var firmas2 = registros.firmas2;
      var var_ocu = firmas2.split('|');
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
        $("#nom2_"+z).val(nom);
        $("#car2_"+z).val(car);
        if (con_firmas2 > var_ocu2)
        {
        }
        else
        {
          if (i < var_ocu2)
          {
            $("#add_field3").click();
          }
        }
      }
      $("#add_field").show();
      $("#add_field1").show();
      $("#add_field2").show();
      $("#add_field3").show();
      $("#numero").val(registros.acta);
      $("#conse").val(registros.conse);
      $("#ano").val(registros.ano);
      $("#lugar").val(registros.lugar);
      $("#fecha").val(registros.fecha);
      $("#unidad").val(registros.centraliza);
      $("#periodo").val(registros.periodo);
      $("#plan").val(registros.planes);
      $("#fecha1").val(registros.fecha1);
      $("#fecha2").val(registros.fecha2);
      $("#ciudad").val(registros.ciudad);
      // Observaciones
      var observaciones = registros.observaciones;
      var var_ocu = observaciones.split('|');
      var var_ocu1 = var_ocu.length;
      var var_ocu2 = var_ocu1-1;
      var z = 0;
      for (var i=0; i<var_ocu1-1; i++)
      {
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("»");
        if (con_observaciones >= var_ocu2)
        {
        }
        else
        {
          if (i < var_ocu2)
          {
            $("#add_field1").click();
          }
        }
        z = z+1;
        var con = var_2[0];
        var uni = var_2[1];
        var doc = var_2[2];
        var fec = var_2[3];
        var sop = var_2[4];
        $("#con_"+z).val(con);
        uni = "['"+uni+"']";
        var uni1 = '$("#uni_"+z).val('+uni+').trigger("change");';
        eval(uni1);
        $("#doc_"+z).val(doc);
        $("#fec_"+z).val(fec);
        $("#sop_"+z).val(sop);
      }
      $("#documentos").val(registros.documentos);
      $("#aspectos").val(registros.aspectos);
      $("#recomendaciones").val(registros.recomendaciones);
      $("#reconocimientos").val(registros.reconocimientos);
      $("#actividades").val(registros.actividades);
      $("#elaboro").val(registros.elaboro);
      $("#reviso").val(registros.reviso);
      $("#actu").val('1');
      $("#aceptar").hide();
      $("#aceptar2").show();
      $("#documentos").focus();
    }
  });
}
function enviar()
{
  var acta = $("#numero").val();
  var conse = $("#conse").val();
  var ano = $("#ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "actv_grab1.php",
    data:
    {
      acta: acta,
      conse: conse,
      ano: ano
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
      if (salida == "1")
      {
        $("#aceptar").hide();
        $("#aceptar2").hide();
        $("#aceptar3").hide();
        subir();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo6").html(detalle);
        $("#dialogo6").dialog("open");
        $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar4").show();
      }
    }
  });  
}
function link()
{
  formu1.submit();
}
function link1(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  var ajuste = $("#ajuste").val();
  var hoja = "0";
  if ($("#chk_hoja").is(':checked'))
  {
    hoja = "1";
  }
  $("#acta_acta").val(valor1);
  $("#acta_conse").val(valor);
  $("#acta_ano").val(valor2);
  $("#acta_ajuste").val(ajuste);
  $("#acta_hoja").val(hoja);
  formu1.submit();
}
function link2(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $("#acta_acta").val(valor1);
  $("#acta_conse").val(valor);
  $("#acta_ano").val(valor2);
  subir();
}
function subir()
{
  var numero = $("#acta_acta").val();
  var conse = $("#acta_conse").val();
  var ano = $("#acta_ano").val();
  var acta = numero+"_"+conse+"_"+ano;
  var url = "<a href='./subir13.php?acta="+acta+"' name='link3' id='link3' class='pantalla-modal'>Link</a>";
  $("#vinculo").hide();
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#link3").click();
  $("html,body").animate({ scrollTop: 9999 }, "slow");
}
function excel()
{
  formu_excel.submit();
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
  patron = /[a-zA-ZáéíóúÁÉÍÓÚñÑ ]/;
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
  patron = /[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
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
?>