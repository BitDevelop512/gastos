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
  $f_ord = $ano."/01/01";
  $verifica = time();
  $alea = strtoupper(md5($verifica));
  $alea = substr($alea,0,5);
  $pregunta = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $pregunta);
  $n_unidad = odbc_result($cur,1);
  $n_dependencia = odbc_result($cur,2);
  if ($nun_usuario > 3)
  {
    $tipo = "2";
  }
  else
  {
    $tipo = "1";
  }
  $pregunta1 = "SELECT subdependencia, sigla FROM cx_org_sub WHERE unidad='$nun_usuario' AND dependencia='$dun_usuario' AND unic='$tipo'";
  $cur1 = odbc_exec($conexion, $pregunta1);
  $total = odbc_num_rows($cur1);
  $total = intval($total);
  if ($total > 0)
  {
  }
  else
  {
    $pregunta1 = "SELECT subdependencia, sigla FROM cx_org_sub WHERE unidad='$nun_usuario' AND dependencia='$dun_usuario' AND unic='1'";
    $cur1 = odbc_exec($conexion, $pregunta1);
  }
  $n_unidad1 = odbc_result($cur1,1);
  $n_sigla1 = trim(odbc_result($cur1,2));
  switch ($n_sigla1)
  {
    case 'DIV01':
      $n_sigla1 = "DIV1";
      break;
    case 'DIV02':
      $n_sigla1 = "DIV2";
      break;
    case 'DIV03':
      $n_sigla1 = "DIV3";
      break;
    case 'DIV04':
      $n_sigla1 = "DIV4";
      break;
    case 'DIV05':
      $n_sigla1 = "DIV5";
      break;
    case 'DIV06':
      $n_sigla1 = "DIV6";
      break;
    case 'DIV07':
      $n_sigla1 = "DIV7";
      break;
    case 'DIV08':
      $n_sigla1 = "DIV8";
      break;
    case 'BR01':
      $n_sigla1 = "BR1";
      break;
    case 'BR02':
      $n_sigla1 = "BR2";
      break;
    case 'BR03':
      $n_sigla1 = "BR3";
      break;
    case 'BR04':
      $n_sigla1 = "BR4";
      break;
    case 'BR05':
      $n_sigla1 = "BR5";
      break;
    case 'BR06':
      $n_sigla1 = "BR6";
      break;
    case 'BR07':
      $n_sigla1 = "BR7";
      break;
    case 'BR08':
      $n_sigla1 = "BR8";
      break;
    case 'BR09':
      $n_sigla1 = "BR9";
      break;
    default:
      $n_sigla1 = $n_sigla1;
      break;
  }
  if ($nun_usuario > 3)
  {
    $v1 = explode("_", $usu_usuario);
    $v2 = trim($v1[0]);
    $v3 = trim($v1[1]);
    switch ($v2)
    {
    case 'SGA':
      $usu_envio = "SGA_".$n_sigla1;
      break;
    case 'OS2':
      $usu_envio = "CDO_".$v3;
      break;
    default:
      $usu_envio = "";
      break;
    }
  }
  else
  {
    $usu_envio = "SAR_".$n_sigla1;
  }
  // Salario minino
  $query2 = "SELECT salario FROM cx_ctr_ano WHERE ano='$ano'";
  $sql2 = odbc_exec($conexion,$query2);
  $salario = odbc_result($sql2,1);
  $salario = floatval($salario);
  //echo $nun_usuario." - ".$dun_usuario." - ".$usu_envio;
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
          <h3>Registro Pago Informaci&oacute;n</h3>
          <div>
            <div id="load">
              <center>
                <img src="dist/img/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">N&uacute;mero</font></label>
                  <input type="text" name="numero" id="numero" class="form-control numero" value="0" readonly="readonly" tabindex="1">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fuente</font></label>
                  <input type="text" name="cedula" id="cedula" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="20" autocomplete="off" placeholder="Cédula" tabindex="2">
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Nombre Completo</font></label>
                  <input type="text" name="nombre" id="nombre" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" tabindex="3">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Salario M&iacute;nimo</font></label>
                  <input type="text" name="salario" id="salario" class="form-control numero" value="0.00" readonly="readonly" tabindex="4">
                  <input type="hidden" name="salario1" id="salario1" class="form-control numero" value="<?php echo $salario; ?>" tabindex="5">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor Solicitado</font></label>
                  <input type="text" name="valor" id="valor" class="form-control numero" value="0.00" onkeyup="paso_val();" onblur=" val_salario();" tabindex="6">
                  <input type="hidden" name="valor1" id="valor1" class="form-control numero" value="0" tabindex="7">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Factor de Amenaza</font></label>
                  <?php
                  $menu7_7 = odbc_exec($conexion,"SELECT * FROM cx_ctr_fac ORDER BY codigo");
                  $menu7 = "<select name='factor' id='factor' class='form-control select2' tabindex='8'>";
                  $i = 1;
                  $menu7 .= "\n<option value='- SELECCIONAR -'>- SELECCIONAR -</option>";
                  while($i<$row=odbc_fetch_array($menu7_7))
                  {
                    $nombre = utf8_encode($row['nombre']);
                    $menu7 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  $menu7 .= "\n</select>";
                  echo $menu7;
                  ?>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Estructura</font></label>
                  <select name="estructura" id="estructura" class="form-control select2" tabindex="9">
                    <option value="0">- SELECCIONAR -</option>
                  </select>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Blancos de Alta Retribuci&oacute;n</font></label>
                  <select name="oms" id="oms" class="form-control select2" multiple="multiple" style="width: 100%;" data-placeholder="&nbsp;Seleccione uno o varios (HPT)" tabindex="10">
                    <option value="999">N/A</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha Sumin. Inf.</font></label>
                  <input type="text" name="fecha" id="fecha" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="11">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">S&iacute;ntesis de la Informaci&oacute;n</font></label>
                  <textarea name="sintesis" id="sintesis" class="form-control" rows="3" onblur="val_caracteres('sintesis');" tabindex="12"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Recolecci&oacute;n</font></label>
                  <select name="recoleccion" id="recoleccion" class="form-control select2" tabindex="13"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">N&uacute;mero</font></label>
                  <input type="text" name="numero1" id="numero1" class="form-control numero" value="" autocomplete="off" maxlength="25" tabindex="14">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="15">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Oficio Remisorio</font></label>
                  <input type="text" name="oficio" id="oficio" class="form-control numero" value="0" onkeypress="return check1(event);" maxlength="25" tabindex="16" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha de Oficio</font></label>
                  <input type="text" name="fec_ofi" id="fec_ofi" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="17">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Difusi&oacute;n</font></label>
                  <select name="difusion" id="difusion" class="form-control select2" tabindex="18"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">N&uacute;mero</font></label>
                  <input type="text" name="numero2" id="numero2" class="form-control numero" value="" autocomplete="off" maxlength="25" tabindex="19">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="20">
                </div>
								<div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">D&iacute;as H&aacute;biles</font></label>
                  <input type="text" name="dia_tra" id="dia_tra" class="form-control numero" value="0" readonly="readonly" tabindex="21">
                  <input type="hidden" name="dia_res" id="dia_res" class="form-control numero" value="90" readonly="readonly" tabindex="22">
                  <input type="hidden" name="dia_ofi" id="dia_ofi" class="form-control numero" value="45" readonly="readonly" tabindex="23">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Condujo al Resultado</font></label>
                  <select name="resultado1" id="resultado1" class="form-control select2" onchange="verifica()" tabindex="24">
                    <option value="2">NO</option>
                    <option value="1">SI</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Unid. Efectu&oacute; Operaci&oacute;n</font></label>
                  <select name="unidad" id="unidad" class="form-control" disabled="disabled" tabindex="25">
                    <option value="0">- SELECCIONAR -</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Radiograma No.</font></label>
                  <input type="text" name="radiograma" id="radiograma" class="form-control numero" value="0" autocomplete="off" disabled="disabled" tabindex="26">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha3" id="fecha3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" disabled="disabled" tabindex="27">
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Directiva Ministerial Permanente</font></label>
                  <select name="directiva" id="directiva" class="form-control select2" tabindex="28">
                    <option value="1">No. 01 del 17 de Febrero de 2009</option>
                    <option value="2">No. 21 del 5 de Julio de 2011</option>
                    <option value="3">No. 16 del 25 de Mayo de 2012</option>
                    <option value="4">No. 02 del 16 de Enero de 2019</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">No. ORDOP</font></label>
                  <input type="text" name="ordop1" id="ordop1" class="form-control numero" onkeypress="return check2(event);" maxlength="20" disabled="disabled" tabindex="29" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Nombre ORDOP</font></label>
                  <input type="text" name="ordop" id="ordop" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" disabled="disabled" tabindex="30" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha ORDOP</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/fecha.png" width="20" border="0" title="Limpiar Fecha ORDOP" class="mas" onclick="limpiar('fec_ord');"></label>
                  <input type="text" name="fec_ord" id="fec_ord" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" disabled="disabled" tabindex="31">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Orden Fragmentaria</font></label>
                  <input type="text" name="fragmentaria" id="fragmentaria" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" disabled="disabled" tabindex="32" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha OFRAG</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/fecha.png" width="20" border="0" title="Limpiar Fecha OFRAG" class="mas" onclick="limpiar('fec_fra');"></label>
                  <input type="text" name="fec_fra" id="fec_fra" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" disabled="disabled" tabindex="33">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Sitio / Sector / Lugar</font></label>
                  <input type="text" name="sitio" id="sitio" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="34" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Municipio</font></label>
                  <input type="text" name="filtro" id="filtro" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="20" autocomplete="off"  tabindex="35">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">&nbsp;</font></label>
                  <?php
                  $menu6_6 = odbc_exec($conexion,"SELECT * FROM cx_ctr_ciu ORDER BY nombre");
                  $menu6 = "<select name='municipio' id='municipio' class='form-control select2' tabindex='36'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu6_6))
                  {
                    $nombre = trim(utf8_encode($row['nombre']));
                    $codigo = $row['codigo'];
                    $menu6 .= "\n<option value='$codigo'>".$nombre."</option>";
                    $i++;
                  }
                  $menu6 .= "\n</select>";
                  echo $menu6;
                  ?>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Departamento</font></label>
                  <?php
                  $menu5_5 = odbc_exec($conexion,"SELECT * FROM cx_ctr_dep ORDER BY nombre");
                  $menu5 = "<select name='departamento' id='departamento' class='form-control select2' tabindex='37'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu5_5))
                  {
                    $nombre = trim(utf8_encode($row['nombre']));
                    $menu5 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  $menu5 .= "\n</select>";
                  echo $menu5;
                  ?>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                	<font face="Verdana" size="2">Expediente Completo .zip o .rar</font>
									<br><br>
									<a href="#" name="lnk2" id="lnk2" onclick="subir();"><img src="imagenes/clip.png" border="0" title="Anexar Expediente Comprimido"></a>
								</div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Utilidad y Empleo de la Informaci&oacute;n</font></label>
                  <textarea name="resultado" id="resultado" class="form-control" rows="3" onblur="val_caracteres('resultado');" tabindex="38"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Observaciones</font></label>
                  <textarea name="observaciones" id="observaciones" class="form-control" rows="3" onblur="val_caracteres('observaciones');" tabindex="39"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <center>
                    <input type="button" name="aceptar" id="aceptar" value="Continuar">
                    <input type="button" name="aceptar1" id="aceptar1" value="Actualizar">
                    &nbsp;&nbsp;&nbsp;
                    <input type="button" name="aceptar2" id="aceptar2" value="Solicitar Revisión">
                  </center>
                </div>
              </div>
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
            <div id="dialogo2"></div>
            <div id="dialogo3"></div>
            <div id="dialogo4"></div>
            <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="v_ciudad" id="v_ciudad" class="form-control" value="<?php echo $ciu_usuario; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="v_envio" id="v_envio" class="form-control" value="<?php echo $usu_envio; ?>" readonly="readonly">
            <input type="hidden" name="v_ano" id="v_ano" class="form-control" value="0" readonly="readonly" tabindex="0">
            <input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly">
            <input type="hidden" name="paso1" id="paso1" class="form-control" readonly="readonly">
            <input type="hidden" name="fec_ord1" id="fec_ord1" class="form-control" value="<?php echo $f_ord; ?>"readonly="readonly">
            <div id="link"></div>
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
                <input type="text" name="fecha4" id="fecha4" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">&nbsp;</font></label>
                <input type="text" name="fecha5" id="fecha5" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
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
    minDate: "-70d",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
    	val_resultado();
      $("#fecha1").prop("disabled", false);
      $("#fecha1").datepicker("destroy");
      $("#fecha1").val('');
      $("#fecha1").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha").val(),
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
            changeMonth: true,
            onSelect: function () {
              $("#fecha3").datepicker("destroy");
              $("#fecha3").val('');
              $("#fecha3").datepicker({
                dateFormat: "yy/mm/dd",
                minDate: $("#fecha2").val(),
                maxDate: 0,
                changeYear: true,
                changeMonth: true
              });
            },
          });
        },
      });
      $("#fec_ofi").prop("disabled", false);
      $("#fec_ofi").datepicker("destroy");
      $("#fec_ofi").val('');
      $("#fec_ofi").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
      $("#fec_ord").datepicker("destroy");
      $("#fec_ord").val('');
      $("#fec_ord").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fec_ord1").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
      $("#fec_fra").datepicker("destroy");
      $("#fec_fra").val('');
      $("#fec_fra").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
    },
  });
  $("#fecha4").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fecha5").prop("disabled", false);
      $("#fecha5").datepicker("destroy");
      $("#fecha5").val('');
      $("#fecha5").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha4").val(),
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
    height: 360,
    width: 650,
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
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
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
  $("#dialogo3").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
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
  $("#dialogo4").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 400,
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
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#oms").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true,
    width: "resolve"
  });
  $("#valor").maskMoney();
  $("#aceptar").button();
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").click(pregunta);
  $("#aceptar1").button();
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").click(pregunta);
  $("#aceptar1").hide();
  $("#aceptar2").button();
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").click(pregunta1);
  $("#aceptar2").hide();
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#filtro").keyup(function () {
    var valthis = $(this).val().toLowerCase();
    var num = 0;
    $("select#municipio>option").each(function () {
      var text = $(this).text().toLowerCase();
      if(text.indexOf(valthis) !== -1)  
      {
        $(this).show(); $(this).prop("selected",true);
      }
      else
      {
        $(this).hide();
      }
    });
    trae_depto();
  });
  $("#cedula").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#cedula").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#directiva").val('4');
  trae_difu();
  trae_difu1();
  trae_salario();
  trae_unidades();
  $("#salario").prop("disabled",true);
  $("#factor").change(trae_estructura);
});
// Cargue salario mínimo
function trae_salario()
{
  var salario = $("#salario1").val();
  salario = parseFloat(salario);
  var salario1 = salario.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#salario").val(salario1);
}
// Validacion salarios minimos
function val_salario()
{
  var valor = $("#valor1").val();
  var valor1 = $("#salario1").val();
  valor1 = parseFloat(valor1);
  var valor2 = valor1*10;
  if (valor < valor2)
  {
    $("#aceptar").hide();
    alerta("Valor No Permitido, inferior a 10 SMMLV");
  }
  else
  {
    $("#aceptar").show();
  }
}
// Trae dias transcurridos
function val_resultado()
{
  var fecha = $("#fecha").val();
  var fecha1 = $("#fec_ofi").val();
  var dias = $("#dia_res").val();
  var dias1 = $("#dia_ofi").val();
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "val_fecha.php",
    data:
    {
      fecha: fecha,
      fecha1: fecha1,
      dias: dias,
      tipo: tipo
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      var transcurridos = registros.dias;
      transcurridos = parseInt(transcurridos);
      $("#dia_tra").val(transcurridos);
      if (salida >= 0)
      {
      }
      else
      {
        $("#aceptar").hide();
        var detalle = "<center><h3>Plazo m&aacute;ximo "+dias+" d&iacute;as h&aacute;biles vencido seg&uacute;n Directiva Dic. 02 de 16-02-2019</h3></center>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
        $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
// Trae estrcuturas segun factor seleccionado
function trae_estructura()
{
  $("#estructura").html('');
  var factor = $("#factor").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_estr.php",
    data:
    {
      factor: factor
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
      salida += "<option value='999'>N/A</option>";
      $("#estructura").append(salida);
      trae_oms();
    }
  });
}
function trae_estructura1(valor)
{
  $("#estructura").html('');
  var valor;
  var factor = $("#factor").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_estr1.php",
    data:
    {
      factor: factor,
      estructura: valor
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
      $("#estructura").append(salida);
    }
  });
}
// Trae oms segun factor seleccionado
function trae_oms()
{
  var factor = $("#factor").val();
  $("#oms").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_oms1.php",
    data:
    {
      factor: factor
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
      salida += "<option value='999'>N/A</option>";
      $("#oms").append(salida);
    }
  });
}
// Trae oms segun factor seleccionado
function trae_oms1(valor)
{
  var valor;
  var factor = $("#factor").val();
  $("#oms").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_oms1.php",
    data:
    {
      factor: factor
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
      salida += "<option value='999'>N/A</option>";
      $("#oms").append(salida);
      var var_ocu2 = valor.split(',');
      var var_ocu3 = var_ocu2.length;
      var paso = "";
      for (var i=0; i<var_ocu3; i++)
      {
        paso += "'"+var_ocu2[i]+"',";
      }
      paso = paso.substr(0, paso.length-1);
      paso = "["+paso+"]";
      var final = '$("#oms").val('+paso+').trigger("change");';
      eval(final);
    }
  });
}
// Trae departamento segun municipio seleccionado
function trae_depto()
{
  var valida;
  valida = $("#municipio").val();
  $("#departamento").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_dpto.php",
    data:
    {
      municipio: $("#municipio").val()
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
      $("#departamento").append(salida);
    }
  });
}
// Trae listado recolección de informacion
function trae_difu()
{
  $("#difusion").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_difu.php",
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
      $("#difusion").append(salida);
    }
  });
}
// Trae listado difusion de informacion
function trae_difu1()
{
  $("#recoleccion").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_difu1.php",
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
      $("#recoleccion").append(salida);
    }
  });
}
function trae_unidades()
{
  $("#unidad").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unid.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "<option value='0'>- SELECCIONAR -</option>";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#unidad").append(salida);
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
function pregunta1()
{
  var usuario = $("#v_envio").val();
  var detalle = "<center><h3>El Registro será enviado a <font color='#3333ff'>"+usuario+"</font><br>Esta seguro de continuar ?</h3></center>";
  $("#dialogo3").html(detalle);
  $("#dialogo3").dialog("open");
  $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function paso_val()
{
  var valor = $("#valor").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valor1").val(valor);
}
// Valida si el resultado es SI para datos radiograma
function verifica()
{
  var valor;
  if ($("#resultado1").val() == "1")
  {
  	$("#unidad").prop("disabled",false);
    $("#radiograma").prop("disabled",false);
    $("#fecha3").prop("disabled",false);
  	$("#ordop").prop("disabled",false);
  	$("#ordop1").prop("disabled",false);
  	$("#fec_ord").prop("disabled",false);
  	$("#fragmentaria").prop("disabled",false);
  	$("#fec_fra").prop("disabled",false);
  }
  else
  {
  	$("#unidad").prop("disabled",true);
    $("#radiograma").prop("disabled",true);
    $("#fecha3").prop("disabled",true);
  	$("#ordop").prop("disabled",true);
  	$("#ordop1").prop("disabled",true);
  	$("#fec_ord").prop("disabled",true);
  	$("#fragmentaria").prop("disabled",true);
  	$("#fec_fra").prop("disabled",true);
    $("#radiograma").val('0');
    $("#fecha3").val('');
  	$("#ordop").val('');
  	$("#ordop1").val('');
  	$("#fec_ord").val('');
  	$("#fragmentaria").val('');
  	$("#fec_fra").val('');
  }
}
function valida_inf()
{
  var valor;
  var str = 'k';
  var txt = $("#cedula").val();
  txt = txt.toLowerCase();
  if (txt.indexOf(str) > -1)
  {
    $("#nombre").val('');
    $("#nombre").prop("disabled",true);
  }
  else
  {
    $("#nombre").prop("disabled",false);
  }
}
function validacion()
{
  var salida = true, detalle = '';
  var v_cedula = $("#cedula").val();
  v_cedula = v_cedula.trim().length;
  if (v_cedula == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Fuente</h3></center>";
  }
  if (($("#valor").val() == '0.00') || ($("#valor").val() == ''))
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Valor Solicitado</h3></center>";
  }
  if ($("#factor").val() == '- SELECCIONAR -')
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar un Factor de Amenaza</h3></center>";
  }
  if ($("#estructura").val() == '0')
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar un Estructura</h3></center>";
  }
  var v_oms = $("#oms").select2('val');
  if (v_oms === null)
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar un Blanco de Alta Retribución</h3></center>";
  }
  if ($("#fecha").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar una Fecha de Suministro de Información</h3></center>";
  }
  var v_sintesis = $("#sintesis").val();
  v_sintesis = v_sintesis.trim().length;
  if (v_sintesis == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar una Sintesis</h3></center>";
  }
  var v_oficio = $("#oficio").val();
  v_oficio1 = v_oficio.trim().length;
  if ((v_oficio == "0") || (v_oficio1 == "0"))
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar Oficio Remisorio</h3></center>";
  }
  //if ($("#fec_ofi").val() == '')
  //{
  //  salida = false;
  //  detalle += "<center><h3>Debe ingresar una Fecha de Oficio Remisorio</h3></center>";
  //}
  if ($("#resultado1").val() == "1")
  {
	  if ($("#unidad").val() == '0')
	  {
	    salida = false;
	    detalle += "<center><h3>Debe seleccionar Unidad Efectuó Operación</h3></center>";
	  }
	}
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var valida1 = $("#numero").val();
    if (valida1 == "0")
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
  var oms = $("#oms").select2('val');
  var sintesis = $("#sintesis").val();
  var resultado = $("#resultado").val();
  var observaciones = $("#observaciones").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_grab7.php",
    data:
    {
      tipo: valor,
      conse: $("#numero").val(),
      cedula: $("#cedula").val(),
      nombre: $("#nombre").val(),
      factor: $("#factor").val(),
      estructura: $("#estructura").val(),
      oms: oms,
      valor: $("#valor").val(),
      valor1: $("#valor1").val(),
      fec_sum: $("#fecha").val(),
      sintesis: sintesis,
      dias: $("#dia_tra").val(),
      oficio: $("#oficio").val(),
      fec_ofi: $("#fec_ofi").val(),
      recoleccion: $("#recoleccion").val(),
      numero1: $("#numero1").val(),
      fecha1: $("#fecha1").val(),
      difusion: $("#difusion").val(),
      numero2: $("#numero2").val(),
      fecha2: $("#fecha2").val(),
      uni_efe: $("#unidad").val(),
      resultado1: $("#resultado1").val(),
      radiograma: $("#radiograma").val(),
      fecha3: $("#fecha3").val(),
      directiva: $("#directiva").val(),
      ordop1: $("#ordop1").val(),
      ordop: $("#ordop").val(),
      fec_ord: $("#fec_ord").val(),
      fragmentaria: $("#fragmentaria").val(),
      fec_fra: $("#fec_fra").val(),
      sitio: $("#sitio").val(),
      municipio: $("#municipio").val(),
      departamento: $("#departamento").val(),
      resultado: resultado,
      observaciones: observaciones,
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
      var valida = registros.salida;
      var valida1 = registros.salida1;
      if (valida > 0)
      {       
        $("#aceptar").hide();
        $("#aceptar1").hide();
        $("#aceptar2").show();
        $("#numero").val(valida);
        $("#v_ano").val(valida1);
        apaga();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
        $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar").show();
      }
    }
  });
}
function apaga()
{
  $("#cedula").prop("disabled",true);
  $("#nombre").prop("disabled",true);
  $("#valor").prop("disabled",true);
  $("#factor").prop("disabled",true);
  $("#estructura").prop("disabled",true);
  $("#oms").prop("disabled",true);
  $("#fecha").prop("disabled",true);
  $("#sintesis").prop("disabled",true);
  $("#recoleccion").prop("disabled",true);
  $("#numero1").prop("disabled",true);
  $("#fecha1").prop("disabled",true);
  $("#difusion").prop("disabled",true);
  $("#numero2").prop("disabled",true);
  $("#fecha2").prop("disabled",true);
  $("#oficio").prop("disabled",true);
  $("#unidad").prop("disabled",true);
  $("#resultado1").prop("disabled",true);
  $("#radiograma").prop("disabled",true);
  $("#fecha3").prop("disabled",true);
  $("#directiva").prop("disabled",true);
  $("#ordop1").prop("disabled",true);
  $("#ordop").prop("disabled",true);
  $("#fec_ord").prop("disabled",true);
  $("#fragmentaria").prop("disabled",true);
  $("#fec_fra").prop("disabled",true);
  $("#sitio").prop("disabled",true);
  $("#filtro").prop("disabled",true);
  $("#municipio").prop("disabled",true);
  $("#departamento").prop("disabled",true);
  $("#resultado").prop("disabled",true);
  $("#observaciones").prop("disabled",true);
}
function consultar()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_consu5.php",
    data:
    {
      fecha1: $("#fecha4").val(),
      fecha2: $("#fecha5").val()
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
      var valida, valida1, valida2;
      var salida1 = "";
      var salida2 = "";
      listaplanes = [];
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
      salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='8%'><b>No.</b></td><td height='35' width='10%'><b>Fec. Registro</b></td><td height='35' width='10%'><b>Fec. Suministro</b></td><td height='35' width='10%'><b>Usuario</b></td><td height='35' width='15%'><b>Efectu&oacute; Operaci&oacute;n</b></td><td height='35' width='10%'><b>ORDOP</b></td><td height='35' width='10%'><b>Fragmentaria</b></td><td height='35' width='12%'><b>Estado</b></td><td height='35' width='10%'><b>Valor</b></td><td height='35' width='5%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        valida2 = value.conse+","+value.ano+","+index;
        if (value.condujo == "2")
        {
          var n_unidad = "";
        }
        else
        {
          var n_unidad = value.unidad1;
        }
        salida2 += "<tr><td height='35' width='8%'>"+value.conse+"<input type='hidden' class='form-control' name='dat_"+index+"' id='dat_"+index+"' value='"+value.observaciones+"' readonly='readonly'></td>";
        salida2 += "<td height='35' width='10%'>"+value.fecha+"</td>";
        salida2 += "<td height='35' width='10%'>"+value.fecha1+"</td>";
        salida2 += "<td height='35' width='10%'>"+value.usuario+"</td>";
        salida2 += "<td height='35' width='15%'>"+n_unidad+"</td>";
        salida2 += "<td height='35' width='10%'>"+value.ordop+"</td>";
        salida2 += "<td height='35' width='10%'>"+value.fragmenta+"</td>";
        salida2 += "<td height='35' width='12%'>"+value.estado1+"</td>";
        salida2 += "<td height='35' width='10%' align='right'>"+value.valor+"</td>";
        if ((value.estado == "") || (value.estado == "Y"))
        {
          salida2 += "<td height='35' width='5%'><center><a href='#' onclick='modif("+valida2+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
        }
        else
        {
          salida2 += "<td height='35' width='5%' ><center><img src='imagenes/blanco.png' border='0'></center></td></tr>";
        }
        listaplanes.push(value.interno);
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados5").append(salida2);
    }
  });
}
function modif(valor, valor1, valor2)
{
  $("#soportes").accordion({active: 0});
  var valor, valor1;
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_consu1.php",
    data:
    {
      tipo: tipo,
      conse: valor,
      ano: valor1
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
      var registros = JSON.parse(data);
      $("#numero").val(registros.conse);
      $("#v_ano").val(registros.ano);
      var cedulas = registros.cedulas;
      var var_ocu = cedulas.split('|');
      var cedula = var_ocu[0];
      $("#cedula").val(cedula);
      var nombres = registros.nombres;
      var var_ocu1 = nombres.split('|');
      var nombre = var_ocu1[0];
      $("#nombre").val(nombre);
      $("#factor").val(registros.factor);
      var v_estructura = registros.estructura;
      trae_estructura1(v_estructura);
      var v_oms = registros.oms;
      trae_oms1(v_oms);
      $("#sintesis").val(registros.sintesis);
      $("#oficio").val(registros.oficio);
      $("#fec_ofi").val(registros.fec_ofi);
      $("#dia_tra").val(registros.dias);
      $("#valor").val(registros.valor);
      $("#valor1").val(registros.valor1);
      $("#fecha").val(registros.fec_sum);
      $("#recoleccion").val(registros.recoleccion);
      $("#numero1").val(registros.num_reco);
      $("#fecha1").val(registros.fec_reco);
      $("#difusion").val(registros.difusion);
      $("#numero2").val(registros.num_difu);
      $("#fecha2").val(registros.fec_difu);
      $("#unidad").val(registros.unidad1);
      $("#resultado1").val(registros.condujo);
      $("#radiograma").val(registros.radiograma);
      $("#fecha3").val(registros.fec_radi);
      $("#ordop1").val(registros.n_ordop);
      $("#ordop").val(registros.ordop);
      $("#fec_ord").val(registros.fec_ord);
      $("#fragmentaria").val(registros.fragmentaria);
      $("#fec_fra").val(registros.fec_fra);
      $("#sitio").val(registros.sitio);
      $("#filtro").val('');
      $("#municipio").val(registros.municipio);
      $("#departamento").val(registros.departamento);
      $("#resultado").val(registros.resultado);
      $("#observaciones").val(registros.observaciones);
      $("#alea").val(registros.codigo);
      $("#aceptar").hide();
      $("#aceptar1").show();
      $("#aceptar2").show();
      val_resultado();
      if (registros.estado == "Y")
      {
        var observa = $("#dat_"+valor2).val();
        var detalle = "<center><h3>Registro Rechazado</h3></center><br>";
        detalle += observa;
        $("#dialogo4").html(detalle);
        $("#dialogo4").dialog("open");
        $("#dialogo4").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function enviar()
{
  var usuario = $("#v_envio").val();
  var numero = $("#numero").val();
  var ano = $("#v_ano").val();
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_grab1.php",
    data:
    {
      usuario: usuario,
      numero: numero,
      ano: ano,
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
      var registros = JSON.parse(data);
      var salida = registros.salida;
      var salida1 = registros.salida1;
      if (salida == "1")
      { 
        $("#aceptar").hide();
        $("#aceptar1").hide();
        $("#aceptar2").hide();
        apaga();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
        $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar2").show();
      }
    }
  });  
}
function limpiar(valor)
{
  var valor;
  $("#"+valor).val('');
}
function subir()
{
  var alea = $("#alea").val();
  var url = "<a href='./subir3.php?alea="+alea+"' name='link3' id='link3' class='pantalla-modal'>Link</a>";
  $("#link").hide();
  $("#link").html('');
  $("#link").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#link3").click();
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
function check5(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9kK-]/;
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
  detalle = detalle.replace(/[″]+/g, '"');
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
?>