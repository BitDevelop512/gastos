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
  $fecha = date('Y/m/d');
  $pregunta = "SELECT unidad, dependencia, unic, especial FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $pregunta);
  $n_unidad = odbc_result($cur,1);
  $n_dependencia = odbc_result($cur,2);
  $n_unic = odbc_result($cur,3);
  $n_especial = odbc_result($cur,4);
  if ($n_especial == "0")
  {
    $pregunta1 = "SELECT subdependencia, unidad FROM cx_org_sub WHERE unidad='$n_unidad' AND unic='1'";
  }
  else
  {
    $pregunta1 = "SELECT subdependencia, unidad FROM cx_org_sub WHERE unidad='$n_especial' AND unic='1'";
  }
  $cur1 = odbc_exec($conexion, $pregunta1);
  $n_unidad1 = odbc_result($cur1,1);
  $n_unidad2 = odbc_result($cur1,2);
  $pregunta2 = "SELECT nombre FROM cx_org_uni WHERE unidad='$n_unidad2'";
  $cur2 = odbc_exec($conexion, $pregunta2);
  $n_sigla1 = trim(odbc_result($cur2,1));
  if ($n_especial == "0")
  {
    if (($nun_usuario > 3) and ($n_unic == "1"))
    {
      $n_sigla1 = "CEDE2";
    }
  }
  switch ($sig_usuario)
  {
    case 'DIV01':
      $sig_usuario = "DIV1";
      break;
    case 'DIV02':
      $sig_usuario = "DIV2";
      break;
    case 'DIV03':
      $sig_usuario = "DIV3";
      break;
    case 'DIV04':
      $sig_usuario = "DIV4";
      break;
    case 'DIV05':
      $sig_usuario = "DIV5";
      break;
    case 'DIV06':
      $sig_usuario = "DIV6";
      break;
    case 'DIV07':
      $sig_usuario = "DIV7";
      break;
    case 'DIV08':
      $sig_usuario = "DIV8";
      break;
    case 'BR01':
      $sig_usuario = "BR1";
      break;
    case 'BR02':
      $sig_usuario = "BR2";
      break;
    case 'BR03':
      $sig_usuario = "BR3";
      break;
    case 'BR04':
      $sig_usuario = "BR4";
      break;
    case 'BR05':
      $sig_usuario = "BR5";
      break;
    case 'BR06':
      $sig_usuario = "BR6";
      break;
    case 'BR07':
      $sig_usuario = "BR7";
      break;
    case 'BR08':
      $sig_usuario = "BR8";
      break;
    case 'BR09':
      $sig_usuario = "BR9";
      break;
    default:
      $sig_usuario = $sig_usuario;
      break;
  }
  // Usuario enviar
  switch ($n_sigla1)
  {
    case 'DIV1':
      $n_sigla2 = "DIV01";
      break;
    case 'DIV2':
      $n_sigla2 = "DIV02";
      break;
    case 'DIV3':
      $n_sigla2 = "DIV03";
      break;
    case 'DIV4':
      $n_sigla2 = "DIV04";
      break;
    case 'DIV5':
      $n_sigla2 = "DIV05";
      break;
    case 'DIV6':
      $n_sigla2 = "DIV06";
      break;
    case 'DIV7':
      $n_sigla2 = "DIV07";
      break;
    case 'DIV8':
      $n_sigla2 = "DIV08";
      break;
    default:
      $n_sigla2 = $n_sigla1;
      break;
  }
  $pregunta3 = "SELECT subdependencia FROM cx_org_sub WHERE sigla='$n_sigla2'";
  $cur3 = odbc_exec($conexion, $pregunta3);
  $n_sigla3 = odbc_result($cur3,1);
  $pregunta4 = "SELECT usuario FROM cx_usu_web WHERE unidad='$n_sigla3' AND permisos LIKE '%E|02%'";
  $cur4 = odbc_exec($conexion, $pregunta4);
  $n_usuario2 = trim(odbc_result($cur4,1));
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
<body>
<?php
include('titulo.php');
?>
<div>
  <div id="soportes">
    <h3>Revisi&oacute;n Expediente Recompensa</h3>
    <div>
      <div id="load1">
        <center>
          <img src="imagenes/cargando1.gif" alt="Cargando..." />
        </center>
      </div>
      <div class="row">
        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
          <label><font face="Verdana" size="2">Fecha</font></label>
          <input type="text" name="fechac1" id="fechac1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
        </div>
        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
          <label><font face="Verdana" size="2">&nbsp;</font></label>
          <input type="text" name="fechac2" id="fechac2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
        </div>
        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
          <label><font face="Verdana" size="2">Unidad</font></label>
          <select name="unidadc" id="unidadc" class="form-control select2" onchange="trae_registros();"></select>
        </div>
				<div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
					<label><font face="Verdana" size="2">A&ntilde;o</font></label>
					<select name="ano1" id="ano1" class="form-control select2" onchange="trae_registros();"></select>
				</div>
        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
          <label><font face="Verdana" size="2">Estado</font></label>
          <select name="estado1" id="estado1" class="form-control select2" onchange="trae_registros();">
            <option value="-">- SELECCIONAR-</option>
            <option value="">EN TRAMITE U.T.</option>
            <option value="Y">RECHAZADA</option>
            <option value="A">REVISI&Oacute;N BRIGADA</option>        
            <option value="B">REVISI&Oacute;N COMANDO</option>
            <option value="C">REVISI&Oacute;N DIVISI&Oacute;N</option>
            <option value="D">EVALUACI&Oacute;N CRR</option>
            <option value="E">REVISI&Oacute;N CEDE2</option>
            <option value="F">EVALUADA CCR</option>
            <option value="G">PENDIENTE GIRO</option>
            <option value="H">GIRADA</option>
            <option value="I">PAGADA</option>
          </select>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
          <label><font face="Verdana" size="2">ORDOP</font></label>
          <input type="text" name="v_ordop" id="v_ordop" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onblur="trae_registros();" maxlength="30" autocomplete="off">
        </div>
        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
          <label><font face="Verdana" size="2">Fragmentaria</font></label>
          <input type="text" name="v_fragmenta" id="v_fragmenta" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onblur="trae_registros();" maxlength="30" autocomplete="off">
        </div>
        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
          <label><font face="Verdana" size="2">Valor</font></label>
            <input type="text" name="v_valor" id="v_valor" class="form-control numero" value="0.00" onkeyup="paso_val();" onblur="trae_registros();">
            <input type="hidden" name="v_valor1" id="v_valor1" class="form-control numero" value="0">
        </div>
      </div>
      <br>
	    <div id="tabla7"></div>
      <div id="resultados5"></div>
    </div>
    <h3>Resultados</h3>
    <div>
      <div id="load">
        <center>
          <img src="imagenes/cargando1.gif" alt="Cargando..." />
        </center>
      </div>
      <form name="formu" method="post">
        <div class="row">
          <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
            <label><font face="Verdana" size="2">Unidad Revisa Expediente</font></label>
            <input type="hidden" name="n_unidad" id="n_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="n_unidad1" id="n_unidad1" class="form-control" value="<?php echo $n_unidad1; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="n_unidad2" id="n_unidad2" class="form-control" value="<?php echo $n_unidad; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="n_usuario" id="n_usuario" class="form-control" value="" readonly="readonly" tabindex="0">
            <input type="hidden" name="n_usuario1" id="n_usuario1" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="n_usuario2" id="n_usuario2" class="form-control" value="<?php echo $n_usuario2; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="n_especial" id="n_especial" class="form-control" value="<?php echo $n_especial; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="n_comite" id="n_comite" class="form-control" value="<?php echo $comite; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="t_unidad" id="t_unidad" class="form-control" value="<?php echo $tpu_usuario; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="n_pago" id="n_pago" class="form-control" value="0" readonly="readonly" tabindex="0">
            <input type="hidden" name="conse" id="conse" class="form-control" value="0" readonly="readonly" tabindex="0">
            <input type="hidden" name="ano" id="ano" class="form-control" value="0" readonly="readonly" tabindex="0">
            <input type="hidden" name="carpeta" id="carpeta" class="form-control" value="0" readonly="readonly" tabindex="0">
            <input type="text" name="n_brigada" id="n_brigada" class="form-control" value="<?php echo $sig_usuario; ?>" readonly="readonly" tabindex="1">
          </div>
          <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
            <label><font face="Verdana" size="2">Unidad Superior</font></label>
            <input type="text" name="n_brigada1" id="n_brigada1" class="form-control" value="<?php echo $n_sigla1; ?>" readonly="readonly" tabindex="2">
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">F. Recepci&oacute;n Exp.</font></label>
            <input type="text" name="fecha" id="fecha" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="3">
          </div>
          <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
            <label><font face="Verdana" size="2">Expediente</font></label>
            <div id="link"></div>
            <div id="vinculo"></div>
          </div>
          <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
            <label><font face="Verdana" size="2">Lista</font></label>
            <div id="lista"></div>
          </div>
          <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
            <label><font face="Verdana" size="2">Oficio</font></label>
            <div id="anexo"></div>
          </div>
          <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
            <label><font face="Verdana" size="2">Archivos</font></label>
            <div id="todos"></div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Fecha Resultado</font></label>
            <input type="text" name="fec_res" id="fec_res" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="4">
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Fecha HR Inicio</font></label>
            <input type="text" name="fec_hr" id="fec_hr" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="5">
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Fecha de Oficio</font></label>
            <input type="text" name="fec_ofi" id="fec_ofi" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="6">
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Fecha Pr&oacute;rroga</font></label>
            <input type="text" name="fec_pro" id="fec_pro" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="7">
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Fecha Sumin. Inf.</font></label>
            <input type="text" name="fec_sum" id="fec_sum" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="8">
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Valor Solicitado</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/valor.png" name="img3" id="img3" width="20" border="0" title="Modificar Valor" class="mas" onclick="actu3();"><img src="dist/img/grabar.png" name="img4" id="img4" width="20" border="0" title="Actualizar Valor" class="mas" onclick="actu4();"></label>
            <input type="text" name="solicitado" id="solicitado" class="form-control numero" tabindex="9">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">No. ORDOP</font></label>
            <input type="text" name="ordop1" id="ordop1" class="form-control numero" readonly="readonly" tabindex="10">
          </div>
          <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
            <label><font face="Verdana" size="2">Nombre ORDOP</font></label>
            <input type="text" name="ordop" id="ordop" class="form-control" readonly="readonly" tabindex="11">
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Fecha ORDOP</font></label>
            <input type="text" name="fec_ord" id="fec_ord" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="12">
          </div>
          <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
            <label><font face="Verdana" size="2">Orden Fragmentaria</font></label>
            <input type="text" name="fragmentaria" id="fragmentaria" class="form-control" readonly="readonly" tabindex="13">
          </div>
          <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
            <label><font face="Verdana" size="2">Fecha OFRAG</font></label>
            <input type="text" name="fec_fra" id="fec_fra" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="14">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
            <label><font face="Verdana" size="2">Factor de Amenaza</font></label>
            <input type="text" name="factor" id="factor" class="form-control" readonly="readonly" tabindex="15">
          </div>
          <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
            <label><font face="Verdana" size="2">Estructura</font></label>
            <input type="text" name="estructura" id="estructura" class="form-control" readonly="readonly" tabindex="16">
          </div>
          <div id="lbl1">
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Oficio Remisorio</font></label>
              <input type="text" name="oficio1" id="oficio1" class="form-control numero" value="0" onkeypress="return check1(event);" maxlength="25" tabindex="17" autocomplete="off">
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Fecha de Oficio</font></label>
              <input type="text" name="fec_ofi1" id="fec_ofi1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="18">
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
            <label><font face="Verdana" size="2">Sintesis de la Informaci&oacute;n</font></label>
            <textarea name="sintesis" id="sintesis" class="form-control" rows="4" readonly="readonly" tabindex="19"></textarea>
          </div>
          <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
            <label><font face="Verdana" size="2">Concepto: Resumen Resultado Operacional / Utilidad / Empleo</font></label>
            <textarea name="resumen" id="resumen" class="form-control" rows="4" readonly="readonly" tabindex="20"></textarea>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
            <label><font face="Verdana" size="2">Observaciones Unidad Solicitante</font></label>
            <textarea name="observaciones1" id="observaciones1" class="form-control" rows="4" readonly="readonly" tabindex="21"></textarea>
          </div>
          <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
            <label><font face="Verdana" size="2">Historial de Observaciones</font></label>
            <textarea name="observaciones2" id="observaciones2" class="form-control" rows="4" readonly="readonly" tabindex="21"></textarea>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
            <div id="lbl_resul">
              <label><font face="Verdana" size="2">Resultado de la Revisi&oacute;n</font></label>
            </div>
            <input type="hidden" name="estado" id="estado" class="form-control" readonly="readonly" tabindex="23">
            <select name="resultado" id="resultado" class="form-control select2">
              <option value="A">APROBADO</option>
              <option value="Y">RECHAZADO</option>
            </select>
            <br>
            <div id="mostrar">
              <label><font face="Verdana" size="2">Usuario a Enviar</font></label>
              <input type="text" name="envia" id="envia" class="form-control" readonly="readonly">
            </div>
          </div>
          <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
            <label><font face="Verdana" size="2">Observaciones</font></label>
            <textarea name="observaciones" id="observaciones" class="form-control" rows="5" onblur="val_caracteres('observaciones');"></textarea>
            <input type="hidden" name="conse1" id="conse1" class="form-control" value="0" readonly="readonly">
          </div>
          <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
            <br>
            <img src="dist/img/editar.png" name="img1" id="img1" width="30" border="0" title="Modificar Observaciones" class="mas" onclick="actu1();"><img src="dist/img/grabar1.png" name="img2" id="img2" width="30" border="0" title="Actualizar Observaciones" class="mas" onclick="actu2();">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <center>
              <input type="button" name="aceptar" id="aceptar" value="Continuar">
            </center>
          </div>
        </div>
      </form>
			<form name="formu1" action="ver_lista.php" method="post" target="_blank">
				<input type="hidden" name="rec_conse" id="rec_conse" readonly="readonly">
				<input type="hidden" name="rec_ano" id="rec_ano" readonly="readonly">
			</form>
      <form name="formu_excel" id="formu_excel" action="reco_verif_x.php" target="_blank" method="post">
        <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
      </form>
    </div>
  </div>
</div>
<div id="dialogo"></div>
<div id="dialogo1"></div>
<div id="dialogo2"></div>
<div id="dialogo3"></div>
<script src="js/jquery.quicksearch.js?1.0.0" type="text/javascript"></script>
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
    changeMonth: true,
    onSelect: function () {
      $("#fecha").removeClass("ui-state-error");
      $("#resultado").prop("disabled",false);
      $("#resultado").val('A');
      trae_usuario();
      $("#observaciones").val('');
      $("#observaciones").prop("disabled",false);
      $("#aceptar").show();
      var n_pago = $("#n_pago").val();
      if (n_pago == "0")
      {
        $("#lbl1").hide();
      }
      else
      {
        var t_unidad = $("#t_unidad").val();
        if (t_unidad == "7")
        {
          $("#lbl1").show();
          $("#fec_ofi1").prop("disabled", false);
          $("#fec_ofi1").datepicker("destroy");
          $("#fec_ofi1").val('');
          $("#fec_ofi1").datepicker({
            dateFormat: "yy/mm/dd",
            minDate: $("#fec_ofi").val(),
            maxDate: 0,
            changeYear: true,
            changeMonth: true
          });
        }
      }
    },
  });
  $("#fechac1").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fechac2").prop("disabled", false);
      $("#fechac2").datepicker("destroy");
      $("#fechac2").val('');
      $("#fechac2").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fechac1").val(),
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
    height: 220,
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
    height: 170,
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
        otra();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo3").dialog({
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
  $("#fecha").prop("disabled",true);
  $("#resultado").prop("disabled",true);
  $("#resultado").change(trae_usuario);
  $("#solicitado").prop("disabled",true);
  $("#observaciones").prop("disabled",true);
  $("#v_valor").maskMoney();
  $("#solicitado").maskMoney();
  $("#aceptar").button();
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").click(pregunta);
  $("#aceptar").hide();
  $("#img1").hide();
  $("#img2").hide();
  $("#img3").hide();
  $("#img4").hide();
  $("#lbl1").hide();
  $("#unidadc").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  trae_unidades();
});
function trae_unidades()
{
  $("#unidadc").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unid.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      salida += "<option value='-'>- SELECCIONAR -</option>";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#unidadc").append(salida);
      trae_ano();
    }
  });
}
function trae_ano()
{
  $("#ano1").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_ano.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "<option value='-'>- SELECCIONAR -</option>";
      var j = 0;
      for (var i in registros) 
      {
        j = j+1;
        var ano = registros[i].ano;
        salida += "<option value='"+ano+"'>"+ano+"</option>";
      }
      $("#ano1").append(salida);
      trae_registros();
    }
  });
}
function trae_usuario()
{
  var unidad = $("#n_unidad2").val();
  var resultado = $("#resultado").val();
  var brigada = $("#n_brigada1").val();
  var usuario2 = $("#n_usuario2").val();
  var estado = $("#estado").val();
  if (resultado == "Y")
  {
    var usuario = $("#n_usuario").val();
    $("#envia").val(usuario);
		if ((estado == "A") || (estado == "B") || (estado == "C"))
		{
			$("#mostrar").show();
		}
		else
		{
			$("#mostrar").hide();
		}
  }
  else
  {
    if (brigada == "CEDE2")
    {
      var usuario1 = "SPR_DIADI";
    }
    else
    {
      if (unidad > 3)
      {
        var usuario1 = usuario2;
      }
      else
      {
        var usuario1 = "SAR_"+brigada;
      }
    }
    $("#envia").val(usuario1);
		if ((estado == "A") || (estado == "B"))
		{
			$("#mostrar").show();
		}
		else
		{
			$("#mostrar").hide();
		}
  }
}
function trae_registros()
{
  var usuario = $("#n_usuario1").val();
  var comite = $("#n_comite").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_consu2.php",
    data:
    {
      fecha1: $("#fechac1").val(),
      fecha2: $("#fechac2").val(),
      unidad: $("#unidadc").val(),
      ano: $("#ano1").val(),
      estado: $("#estado1").val(),
      ordop: $("#v_ordop").val(),
      fragmenta: $("#v_fragmenta").val(),
      valor: $("#v_valor").val(),
      valor1: $("#v_valor1").val()
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
      $("#tabla7").html('');
      $("#resultados5").html('');
      var registros = JSON.parse(data);
      var valida, valida1, valida2, valida3, valida4;
      var salida1 = "";
      var salida2 = "";
      listareg = [];
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table><br>";
      salida1 += "<div class='row'><div class='col col-lg-3 col-sm-3 col-md-3 col-xs-3'><input type='text' name='buscar' id='buscar' placeholder='Buscar...' class='form-control' autocomplete='off' /></div><div class='col col-lg-8 col-sm-8 col-md-8 col-xs-8'></div>";
      salida1 += "<div class='col col-lg-1 col-sm-1 col-md-1 col-xs-1'><center><a href='#' id='excel' onclick='excel(); return false;'><img src='dist/img/excel.png' title='Descargar Resultados a Excel - SAP'></a></center></div></div>";
      salida1 += "<br>";
      salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='5%'><b>No.</b></td><td height='35' width='8%'><b>Fecha</b></td><td height='35' width='8%'><b>Unidad</b></td><td height='35' width='8%'><b>Brigada</b></td><td height='35' width='10%'><b>Valor</b></td><td height='35' width='6%'><center><b>H&aacute;biles</b></center></td><td height='35' width='10%'><b>ORDOP</b></td><td height='35' width='13%'><b>Fragmentaria</b></td><td height='35' width='15%'><b>Estado</b></td><td height='35' width='4%'><center><b>Ver</b></center></td><td height='35' width='4%'><center><b>Info</b></center></td><td height='35' width='5%'><center><b>Tipo</b></center></td><td height='35' width='4%'><center><b>Lista</b></center></td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      var v_var1 = "";
      $.each(registros.rows, function (index, value)
      {
        valida2 = value.conse+','+value.ano+','+value.unidad+',\"'+value.estado+'\",'+value.tipo;
      	valida3 = value.conse+','+value.ano;
        if (value.tipo == "0")
        {
          valida4 = "RECO";
        }
        else
        {
          valida4 = "PAGO";
        }
        salida2 += "<tr><td height='35' width='5%' id='l1_"+index+"'>"+value.conse+"</td>";
        salida2 += "<td height='35' width='8%' id='l2_"+index+"'>"+value.fecha+"</td>";
        salida2 += "<td height='35' width='8%' id='l3_"+index+"'>"+value.unidad1+"</td>";
        salida2 += "<td height='35' width='8%' id='l4_"+index+"'>"+value.n_dependencia+"</td>";
        salida2 += "<td height='35' width='10%' align='right' id='l5_"+index+"'>"+value.valor+"</td>";
        salida2 += "<td height='35' width='6%' align='center' id='l6_"+index+"'>"+value.dias+"</td>";
        salida2 += "<td height='35' width='10%' id='l7_"+index+"'>"+value.ordop+"</td>";
        salida2 += "<td height='35' width='13%' id='l8_"+index+"'>"+value.fragmenta+"</td>";
        salida2 += "<td height='35' width='15%' id='l9_"+index+"'>"+value.n_estado+"</td>";
        if (((value.estado == "A") && (value.usuario1 == usuario)) || ((value.estado == "B") && (value.usuario2 == usuario)) || ((value.estado == "C") && (value.usuario3 == usuario)) || ((value.estado == "E") && (value.usuario4 == usuario) || ((value.estado == "E") && (value.usuario3 == "SPR_DIADI"))))
        {
          if (value.estado == "C")
          {
            var comite1 = value.n_dependencia1+",";
            var val_comite = comite.indexOf(comite1) > -1;
            if (val_comite == true)
            {
              salida2 += "<td height='35' width='4%' id='l10_"+index+"'>&nbsp;</td>";
            }
            else
            {
              salida2 += "<td height='35' width='4%' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",13); veri("+valida2+",1)'><img src='imagenes/ver.png' border='0' title='Ver Informaci&oacute;n'></a></center></td>";
            }
          }
          else
          {
            salida2 += "<td height='35' width='4%' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",13); veri("+valida2+",1)'><img src='imagenes/ver.png' border='0' title='Ver Informaci&oacute;n'></a></center></td>";
          }
        }
        else
        {          
          salida2 += "<td height='35' width='4%' id='l10_"+index+"'>&nbsp;</td>";
        }
        salida2 += "<td height='35' width='4%' align='right' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",13); veri("+valida2+",0)'><img src='imagenes/ver.png' border='0' title='Consultar Informaci&oacute;n'></a></center></td>";
        salida2 += "<td height='35' width='5%' align='right' id='l12_"+index+"'>"+valida4+"</td>";
        if (value.tipo == "0")
        {
          salida2 += "<td height='35' width='4%' id='l13_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",13); lista("+valida3+")'><img src='imagenes/pdf.png' border='0' title='Visualizar Lista de Verificaci&oacute;n'></a></center></td></tr>";
        }
        else
        {
          salida2 += "<td height='35' width='4%' id='l13_"+index+"'>&nbsp;</td></tr>";
        }
        v_var1 += value.conse+"|"+value.fecha+"|"+value.unidad1+"|"+value.n_dependencia+"|"+value.valor+"|"+value.dias+"|"+value.ordop+"|"+value.fragmenta+"|"+value.n_estado+"|"+valida4+"|#";
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
function paso_val()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('v_valor').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#v_valor1").val(valor1);
}
function veri(valor, valor1, valor2, valor3, valor4, valor5)
{
  var valor, valor1, valor2, valor3, valor4, valor5;
  var usu_diadi = $("#n_usuario1").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_consu3.php",
    data:
    {
      conse: valor,
      ano: valor1,
      unidad: valor2,
      estado: valor3
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
      $("#soportes").accordion({active: 1});
      var registros = JSON.parse(data);
      var repositorio = registros.repositorio;
      var directiva = registros.directiva;
      var n_directiva = registros.n_directiva;
      var observaciones2 = registros.observaciones2;
      var text = String.fromCharCode(13);
      var var_ocu = observaciones2.split('<br>');
      var var_ocu1 = var_ocu.length;
      for (var i=0; i<var_ocu1; i++)
      {
        observaciones2 = observaciones2.replace("<br>", text);
      }
      $("#conse").val(valor);
      $("#ano").val(valor1);
      $("#carpeta").val(registros.repositorio);
      $("#fec_res").val(registros.fec_res);
      $("#fec_hr").val(registros.fec_hr);
      $("#fec_ofi").val(registros.fec_ofi);
      $("#fec_pro").val(registros.fec_pro);
      $("#fec_sum").val(registros.fec_sum);
      $("#solicitado").val(registros.solicitado);
      $("#ordop1").val(registros.n_ordop);
      $("#ordop").val(registros.ordop);
      $("#fec_ord").val(registros.fec_ord);
      $("#fragmentaria").val(registros.fragmenta);
      $("#fec_fra").val(registros.fec_fra);
      $("#factor").val(registros.factor);
      $("#estructura").val(registros.estructura);
      $("#sintesis").val(registros.sintesis);
      $("#resumen").val(registros.resultado);
      $("#observaciones1").val(registros.observaciones);
      $("#n_usuario").val(registros.usuario);
      $("#estado").val(valor3);
      $("#fecha").val(registros.fec_rec);
      $("#observaciones").val(registros.observaciones1);
      $("#conse1").val(registros.conse1);
      $("#resultado").val(registros.resultado1);
      $("#observaciones2").val(observaciones2);
      $("#fecha").prop("disabled", false);
      $("#link").html('');
      $("#lista").html('');
      $("#anexo").html('');
      $("#todos").html('');
      var datos = valor+","+valor1+",'"+repositorio+"'";     
      var datos1 = valor+","+valor1+","+directiva+",'"+n_directiva+"'";
      var salida = "<a href='#' name='lnk1' id='lnk1' onclick=\"link("+datos+");\"><img src='imagenes/zip.png' width='30' border='0' title='Descargar Expediente Comprimido'></a>";
      if (valor4 == "0")
      {
        $("#link").append(salida);
      }
      else
      {
	      if (((valor3 == "A") || (valor3 == "C")) && (valor4 == "1"))
	      {
	      	$("#link").append(salida);
	      }
	    }
      var salida1 = "<a href='#' name='lnk3' id='lnk3' onclick=\"link1("+datos1+");\"><img src='imagenes/lista.png' width='30' border='0' title='Ver Lista de Verificaci&oacute;n'></a>";
      if (valor4 == "0")
      {
        $("#lista").append(salida1);
      }
      var salida2 = "<a href='#' name='lnk5' id='lnk5' onclick=\"link2("+datos+");\"><img src='imagenes/anexa.png'  width='30' border='0' title='Anexar Oficio'></a>";
      if (valor4 == "0")
      {
        $("#anexo").append(salida2);
      }
      else
      {
	      if (((valor3 == "A") || (valor3 == "C")) && (valor4 == "1"))
	      {
	        $("#anexo").append(salida2);
	      }
      }
      if (usu_diadi == "SPR_DIADI")
      {
        var salida3 = "<a href='#' name='lnk7' id='lnk7' onclick=\"link3("+datos+");\"><img src='imagenes/archivos.png'  width='30' border='0' title='Ver Archivos'></a>";
        $("#todos").append(salida3);
      }
      $("#n_pago").val(valor4);
      trae_usuario();
      var fecha = registros.fec_rec;
      fecha = fecha.trim();
      if (valor5 == "0")
      {
        $("#fecha").prop("disabled", true);
      }
      else
      {
        if (fecha == "")
        {
        	if (valor3 == "F")
        	{
        		$("#fecha").prop("disabled", true);
        	}
        	else
        	{
  	        $("#fecha").addClass("ui-state-error");
  	        var detalle = "Debe ingresar la Fecha Recepción de la Solicitud";
  	        alerta(detalle);
          }
        }
        else
        {
          $("#fecha").removeClass("ui-state-error");
        }
      }
      var estado = registros.resultado1;
      var revision = registros.revision;
      var reversa = registros.reversa;
      var activacion = revision-reversa;
      if (valor5 == "0")
      {
        $("#img1").hide(); 
      }
      else
      {
        if ((estado == "A") && (activacion > 0))
        {
          $("#fecha").prop("disabled", true);
          $("#img1").show(); 
        }
      }
			if ((valor3 == "A") || (valor3 == "B"))
			{
				$("#mostrar").show();
			}
			else
			{
				$("#mostrar").hide();
			}
			if ((valor3 == "B") && (fecha != ""))
			{
				$("#fecha").val('');
				$("#observaciones").val('');
				$("#fecha").prop("disabled", false);
				$("#fecha").addClass("ui-state-error");
				var detalle = "Debe ingresar la Fecha Recepción de la Solicitud";
				alerta(detalle);
			}
      else
      {
        if ((valor3 == "E") && (fecha != ""))
        {
          var detalle = "<center><h3>Desea Registrar una Nueva Revisión ?</h3></center>";
          $("#dialogo2").html(detalle);
          $("#dialogo2").dialog("open");
          $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
      }
      var cero = $("#solicitado").val();
			if ((valor3 == "C") && (cero == "0.00"))
			{
				$("#img3").show();
			}
			else
			{
				$("#img3").hide();
			}
      if (valor5 == "0")
      {
        $("#lbl_resul").hide();
        $("#resultado").hide(); 
      }
      else
      {
        $("#lbl_resul").show();
        $("#resultado").show();
      }
    }
  });
}
function otra()
{
  $("#img1").hide();
  $("#fecha").val('');
  $("#observaciones").val('');
  $("#fecha").prop("disabled", false);
  $("#fecha").addClass("ui-state-error");
  var detalle = "Debe ingresar la Fecha Recepción de la Solicitud";
  alerta(detalle);
}
function link(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  var url = "<a href='./listar.php?conse="+valor+"&ano="+valor1+"&alea="+valor2+"' name='lnk2' id='lnk2' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnk2").click();
}
function link1(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3;
  var url = "<a href='./lista.php?conse="+valor+"&ano="+valor1+"&directiva="+valor2+"&directiva1="+valor3+"' name='lnk4' id='lnk4' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnk4").click();
}
function link2(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  var url = "<a href='./subir4.php?conse="+valor+"&ano="+valor1+"&alea="+valor2+"' name='lnk6' id='lnk6' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnk6").click();
}
function link3(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  var url = "<a href='./ver_expediente.php?alea="+valor2+"' name='lnk8' id='lnk8' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnk8").click();
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
  var salida = true, detalle = "";
  var resultado = $("#resultado").val();
  var valida = $("#n_pago").val();
  var valida1 = $("#t_unidad").val();
  var estado = $("#estado").val();
  if (valida == "1")
  {
    var oficio = $("#oficio1").val();
    oficio = oficio.trim().length;
    if (oficio == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar el Oficio Remisorio</h3></center>";
      $("#oficio1").addClass("ui-state-error");
    }
    else
    {
      $("#oficio1").removeClass("ui-state-error");
    }
    if (valida1 == "7")
    {
      var oficio1 = $("#fec_ofi1").val();
      if (oficio1 == "")
      {
		if (resultado == "Y")
		{
			$("#fec_ofi1").removeClass("ui-state-error");
		}
		else
		{
      salida = false;
      detalle += "<center><h3>Debe ingresar la Fecha del Oficio Remisorio</h3></center>";
      $("#fec_ofi1").addClass("ui-state-error");
		}
      }
      else
      {
        $("#fec_ofi1").removeClass("ui-state-error");
      }
    }
  }
  var cero = $("#solicitado").val();
  if ((estado == "C") && (cero == "0.00"))
  {
    salida = false;
    detalle += "<center><h3>Valor Solicitado No Permitido</h3></center>";
  }
  var valor = $("#observaciones").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar las Observaciones de la Revisi&oacute;n</h3></center>";
    $("#observaciones").addClass("ui-state-error");
  }
  else
  {
    $("#observaciones").removeClass("ui-state-error");
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    if (resultado == "A")
    {
      if (valida == "0")
      {
        val_lista();
      }
      else
      {
        nuevo();
      }
    }
    else
    {
      nuevo();
    }
  }
}
function val_lista()
{
  var conse = $("#conse").val();
  var ano = $("#ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_consu4.php",
    data:
    {
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
      var lista = registros.lista;
      var var_ocu = lista.split('|');
      var var1 = var_ocu[5]
      var var2 = var_ocu[6]
      var var3 = var_ocu[7]
      var var4 = var_ocu[8]
      var var5 = var_ocu[9]
      if (var1 == "1")
      {
        nuevo();
      }
      else
      {
        var detalle = "<center><h3>Lista de Verificaci&oacute;n Incompleta</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function lista(valor, valor1)
{
  var valor, valor1;
  $("#rec_conse").val(valor);
  $("#rec_ano").val(valor1);
  formu1.submit();
}
function nuevo()
{
  var observaciones = $("#observaciones").val();
  var resultado = $("#resultado").val();
  var notifica = $("#envia").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_grab4.php",
    data:
    {
      conse: $("#conse").val(),
      ano: $("#ano").val(),
      carpeta: $("#carpeta").val(),
      unidad1: $("#n_brigada").val(),
      unidad2: $("#n_brigada1").val(),
      unidad3: $("#n_unidad1").val(),
      fecha: $("#fecha").val(),
      resultado: resultado,
      usuario: $("#envia").val(),
      observaciones: observaciones,
      oficio: $("#oficio1").val(),
      fec_ofi: $("#fec_ofi1").val()
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
      var estado = registros.estado;
      if (valida > 0)
      {
        $("#aceptar").hide();
        trae_registros();
        $("#lnk1").hide();
        $("#lnk3").hide();
        $("#lnk5").hide();
        $("#resultado").prop("disabled",true);
        $("#observaciones").prop("disabled",true);
        $("#oficio1").prop("disabled",true);
        $("#fec_ofi1").prop("disabled",true);
        var detalle = "<center><h3>Notificaci&oacute;n Enviada a: "+notifica+"</h3></center>";
				$("#dialogo3").html(detalle);
				$("#dialogo3").dialog("open");
				$("#dialogo3").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();


      }
      if (estado == "D")
      {
        var detalle = "<center><h3>El Acta de Comité Regional ha sido habilitada para su elaboración.</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function actu1()
{
  $("#img1").hide();
  $("#img2").show();
  $("#observaciones").prop("disabled",false);
  $("#observaciones").focus();
}
function actu2()
{
  var conse = $("#conse1").val();
  var observaciones = $("#observaciones").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_grab5.php",
    data:
    {
      conse: conse,
      observaciones: observaciones
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        $("#img2").hide();
        $("#observaciones").prop("disabled",true);
      }
    }
  });
}
function actu3()
{
  $("#img3").hide();
  $("#img4").show();
  $("#solicitado").prop("disabled",false);
  $("#solicitado").focus();
}
function actu4()
{
  var conse = $("#conse").val();
  var ano = $("#ano").val();
  var tipo = $("#n_pago").val();
  var valor = $("#solicitado").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_grab8.php",
    data:
    {
      conse: conse,
      ano: ano,
      tipo: tipo,
      valor: valor
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
			  $("#img4").hide();
			  $("#solicitado").prop("disabled",true);
				var detalle = "Valor Solicitado Actualizado";
				alerta(detalle);
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
function alerta(valor)
{
  alertify.error(valor);
}
</script>
</body>
</html>
<?php
}
// 04/01/2023 - Agregar dos campos de filtros en la consulta
// 09/10/2023 - Se agrega exportacion a excel
// 04/01/2023 - Ajuste modificacion valor en 0
// 22/02/2024 - Validacion en division para valor superior a 0
?>