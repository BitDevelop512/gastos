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
  $pregunta2 = "SELECT subdepen, sigla FROM dbo.cf_sigla(1) WHERE subdepen='$uni_usuario' ORDER BY sigla";
  $cur2 = odbc_exec($conexion, $pregunta2);
  $i = 1;
  $siglas = "";
  while ($i < $row = odbc_fetch_array($cur2))
  {
    $numero = $row['subdepen'];
    $nombre = trim($row['sigla']);
    $siglas .= "<option value=$numero>".$nombre."</option>";
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
  //echo $nun_usuario." - ".$dun_usuario." - ".$usu_envio;
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
<style>
  input[type="checkbox"]
  {
    width: 20px;
    height: 20px;
  }
</style>
<div>
  <section class="content-header">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="soportes">
          <h3>Registro de Recompensas</h3>
          <div>
            <div id="load">
              <center>
                <img src="dist/img/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div id="tipo_reg">
                <input type="checkbox" name="tipo1" id="tipo1" onclick="val_resul()">
                <label for="tipo1">&nbsp;Vigencia Anterior</label></p>
                <div class="espacio1"></div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">N&uacute;mero</font></label>
                  <input type="text" name="numero" id="numero" class="form-control numero" value="0" readonly="readonly" tabindex="1">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha Resultado</font></label>
                  <input type="text" name="fec_res" id="fec_res" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="2">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">HR Inicio Tr&aacute;mite</font></label>
                    <input type="text" name="hr" id="hr" class="form-control numero" value="0" onkeypress="return check1(event);" maxlength="25" tabindex="3">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha HR Inicio</font></label>
                    <input type="text" name="fec_hr" id="fec_hr" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="4">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">D&iacute;as H&aacute;biles</font></label>
                  <input type="text" name="dia_tra" id="dia_tra" class="form-control numero" value="0" readonly="readonly" tabindex="5">
                  <input type="hidden" name="dia_res" id="dia_res" class="form-control numero" value="90" readonly="readonly" tabindex="6">
                  <input type="hidden" name="dia_ofi" id="dia_ofi" class="form-control numero" value="45" readonly="readonly" tabindex="7">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Oficio Remisorio</font></label>
                  <input type="text" name="oficio" id="oficio" class="form-control numero" value="0" onkeypress="return check1(event);" maxlength="25" tabindex="8" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha de Oficio</font></label>
                  <input type="text" name="fec_ofi" id="fec_ofi" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="9">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Solicitud Pr&oacute;rroga</font></label>
                    <input type="text" name="prorroga" id="prorroga" class="form-control numero" value="0" onkeypress="return check1(event);" maxlength="25" tabindex="10">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha Pr&oacute;rroga</font></label>
                    <input type="text" name="fec_pro" id="fec_pro" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="11">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Unid. / Dep. Manej&oacute; Fuente</font></label>
                  <?php
                  $menu1_1 = odbc_exec($conexion,"SELECT subdepen, sigla FROM dbo.cf_sigla(1) ORDER BY sigla");
                  $menu1 = "<select name='unidad' id='unidad' class='form-control select2' tabindex='12'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu1_1))
                  {
                    $nombre = trim($row['sigla']);
                    $menu1 .= "\n<option value=$row[subdepen]>".$nombre."</option>";
                    $i++;
                  }
                  $menu1 .= "\n</select>";
                  echo $menu1;
                  ?>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Unid. Efectu&oacute; Operaci&oacute;n</font></label>
                  <?php
                  $menu2_2 = odbc_exec($conexion,"SELECT subdepen, sigla FROM dbo.cf_sigla(1) ORDER BY sigla");
                  $menu2 = "<select name='unidad1' id='unidad1' class='form-control select2' tabindex='13'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu2_2))
                  {
                    $nombre = trim($row['sigla']);
                    $menu2 .= "\n<option value=$row[subdepen]>".$nombre."</option>";
                    $i++;
                  }
                  $menu2 .= "\n<option value='999'>OTRA</option>";
                  $menu2 .= "\n</select>";
                  echo $menu2;
                  ?>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Brigada</font></label>
                  <?php
                  $menu3_3 = odbc_exec($conexion,"SELECT dependencia, nombre FROM cx_org_dep ORDER BY nombre");
                  $menu3 = "<select name='brigada' id='brigada' class='form-control select2' tabindex='14'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu3_3))
                  {
                    $nombre = trim($row['nombre']);
                    $menu3 .= "\n<option value=$row[dependencia]>".$nombre."</option>";
                    $i++;
                  }
                  $menu3 .= "\n</select>";
                  echo $menu3;
                  ?>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Divisi&oacute;n / Comando</font></label>
                  <?php
                  $menu4_4 = odbc_exec($conexion,"SELECT unidad, nombre FROM cx_org_uni ORDER BY nombre");
                  $menu4 = "<select name='division' id='division' class='form-control select2' tabindex='15'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu4_4))
                  {
                    $nombre = trim($row['nombre']);
                    $menu4 .= "\n<option value=$row[unidad]>".$nombre."</option>";
                    $i++;
                  }
                  $menu4 .= "\n</select>";
                  echo $menu4;
                  ?>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
                  <label><font face="Verdana" size="2">Sintesis de la Informaci&oacute;n</font></label>
                  <textarea name="sintesis" id="sintesis" class="form-control" rows="4" onblur="val_caracteres('sintesis');" tabindex="16"></textarea>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor Solicitado</font></label>
                  <input type="text" name="valor" id="valor" class="form-control numero" value="0.00" onkeyup="paso_val();" tabindex="17">
                  <input type="hidden" name="valor1" id="valor1" class="form-control numero" value="0" tabindex="18">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha Sumin. Inf.</font></label>
                  <input type="text" name="fec_sum" id="fec_sum" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="19">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">No. ORDOP</font></label>
                  <input type="text" name="ordop1" id="ordop1" class="form-control numero" onkeypress="return check2(event);" maxlength="20" tabindex="20" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Nombre ORDOP</font></label>
                  <input type="text" name="ordop" id="ordop" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="21" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha ORDOP</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/fecha.png" width="20" border="0" title="Limpiar Fecha ORDOP" class="mas" onclick="limpiar('fec_ord');"></label>
                  <input type="text" name="fec_ord" id="fec_ord" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="22">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Orden Fragmentaria</font></label>
                  <input type="text" name="fragmentaria" id="fragmentaria" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="23" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha OFRAG</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/fecha.png" width="20" border="0" title="Limpiar Fecha OFRAG" class="mas" onclick="limpiar('fec_fra');"></label>
                  <input type="text" name="fec_fra" id="fec_fra" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="24">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Sitio / Sector / Lugar</font></label>
                  <input type="text" name="sitio" id="sitio" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="25" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Municipio</font></label>
                  <input type="text" name="filtro" id="filtro" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="20" autocomplete="off"  tabindex="26">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">&nbsp;</font></label>
                  <?php
                  $menu6_6 = odbc_exec($conexion,"SELECT * FROM cx_ctr_ciu ORDER BY nombre");
                  $menu6 = "<select name='municipio' id='municipio' class='form-control select2' tabindex='27'>";
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
                  $menu5 = "<select name='departamento' id='departamento' class='form-control select2' tabindex='28'>";
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
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Factor de Amenaza</font></label>
                  <?php
                  $menu7_7 = odbc_exec($conexion,"SELECT * FROM cx_ctr_fac ORDER BY codigo");
                  $menu7 = "<select name='factor' id='factor' class='form-control select2' tabindex='29'>";
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
                  <select name="estructura" id="estructura" class="form-control select2" tabindex="30">
                    <option value="0">- SELECCIONAR -</option>
                  </select>
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Concepto: Resumen del Resultado Operacional</font></label>
                  <textarea name="resultado" id="resultado" class="form-control" rows="4" onblur="val_caracteres('resultado');" tabindex="31"></textarea>
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
                        <td width="9%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">Anexar</font></label>
                        </td>
                        <td width="10%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">&nbsp;</font></label>
                        </td>
                        <td width="12%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">&nbsp;</font></label>
                        </td>
                        <td width="15%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">&nbsp;</font></label>
                        </td>
                        <td width="9%" height="25" valign="bottom" align="center">
                          <label><font face="Verdana" size="2">&nbsp;</font></label>
                        </td>
                        <td width="5%" height="25" valign="bottom">
                          &nbsp;
                        </td>
                        <!--
                        Acta Pago Inf.
                        Fecha Pago Inf.
                        Valor Pago Inf.
                        Anexar
                        -->
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
                        <label><font face="Verdana" size="2">&nbsp;</font></label>
                        <!--
                        Suma Total Pagos:&nbsp;&nbsp;&nbsp;
                        -->
                      </td>
                      <td width="15%" height="25" class="espacio2" valign="bottom" align="center">
                        <input type="hidden" name="pagos" id="pagos" class="form-control numero" value="0" readonly="readonly">
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
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
                  <label><font face="Verdana" size="2">Observaciones Unidad Solicitante</font></label>
                  <textarea name="observaciones" id="observaciones" class="form-control" onblur="val_caracteres('observaciones');" rows="5"></textarea>
                </div>
                <div class="col col-lg-3 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Directiva Ministerial Permanente</font></label>
                  <?php
                  $menu8_8 = odbc_exec($conexion,"SELECT * FROM cx_ctr_dir ORDER BY codigo DESC");
                  $menu8 = "<select name='directiva' id='directiva' class='form-control select2'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu8_8))
                  {
                    $nombre = trim(utf8_encode($row['nombre']));
                    $menu8 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  $menu8 .= "\n</select>";
                  echo $menu8;
                  ?>
                </div>
                <div class="col col-lg-3 col-sm-4 col-md-4 col-xs-4">
                  <br>
                  <label><font face="Verdana" size="2">Estado</font></label>
                  <select name="estado" id="estado" class="form-control select2">
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
              <table width="50%" align="center" border="0">
                <tr>
                  <td width="60%">
                    <div id="expediente">
                      <center>
                        Expediente Completo Comprimido en Formato .zip o .rar
                        <br><br>
                        <a href="#" name="lnk2" id="lnk2" onclick="subir2();"><img src="imagenes/clip.png" border="0" title="Anexar Expediente Comprimido"></a>
                      </center>
                    </div>
                  </td>
                  <td width="40%">
                    <div id="lista">
                      <center>
                        Lista de Verificaci&oacute;n
                        <br><br>
                        <a href="#" name="lnk3" id="lnk3" onclick="verificacion();"><img src="imagenes/lista.png" width="30" border="0" title="Lista de Verificaci&oacute;n"></a>
                      </center>
                    </div>                    
                  </td>
                </tr>
              </table>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <center>
                    <input type="button" name="aceptar" id="aceptar" value="Continuar">
                    <input type="button" name="aceptar1" id="aceptar1" value="Actualizar">
                    &nbsp;&nbsp;&nbsp;
                    <input type="button" name="aceptar4" id="aceptar4" value="Solicitar Revisión">
                  </center>
                </div>
              </div>
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
            <div id="dialogo2"></div>
            <div id="dialogo3"></div>
            <div id="dialogo4"></div>
            <div id="dialogo5">
              <form name="formu2" method="post">
                <table width="95%" align="center" border="0">
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                          <label><font face="Verdana" size="2">Batall&oacute;n</font></label>
                          <select name="batallon" id="batallon" class="form-control select2"></select>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-9 col-sm-9 col-md-9 col-xs-9">
                          <label><font face="Verdana" size="2">Nuevo Batall&oacute;n</font></label>
                          <input type="text" name="n_batallon" id="n_batallon" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                        </div>
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                          <br>
                          <input type="button" name="aceptar3" id="aceptar3" value="OK">
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                          <center>
                            <input type="button" name="aceptar2" id="aceptar2" value="Continuar">
                          </center>
                        </div>
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
            <div id="dialogo6"></div>
            <div id="dialogo7"></div>
            <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly">
            <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly">
            <input type="hidden" name="v_ciudad" id="v_ciudad" class="form-control" value="<?php echo $ciu_usuario; ?>" readonly="readonly">
            <input type="hidden" name="v_super" id="v_super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly">
            <input type="hidden" name="v_siglas" id="v_siglas" class="form-control" value="<?php echo $siglas; ?>" readonly="readonly">
            <input type="hidden" name="v_envio" id="v_envio" class="form-control" value="<?php echo $usu_envio; ?>" readonly="readonly">
            <input type="hidden" name="v_ano" id="v_ano" class="form-control" value="0" readonly="readonly" tabindex="0">
            <input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly">
            <input type="hidden" name="paso1" id="paso1" class="form-control" readonly="readonly">
            <div id="link"></div>
          </div>
          <h3>Consultas</h3>
          <div>
            <div id="load1">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
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
            <form name="formu3" action="ver_lista.php" method="post" target="_blank">
              <input type="hidden" name="rec_conse" id="rec_conse" readonly="readonly">
              <input type="hidden" name="rec_ano" id="rec_ano" readonly="readonly">
            </form>
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
  $("#fec_res").datepicker({
    dateFormat: "yy/mm/dd",
    minDate: "-140d",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      val_resultado();
      $("#fec_hr").prop("disabled", false);
      $("#fec_hr").datepicker("destroy");
      $("#fec_hr").val('');
      $("#fec_hr").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fec_res").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true,
        onSelect: function () {
          $("#oficio").prop("disabled", false);
          $("#fec_ofi").prop("disabled", false);
          $("#oficio").focus();
        },
      });
      $("#fec_ofi").prop("disabled", false);
      $("#fec_ofi").datepicker("destroy");
      $("#fec_ofi").val('');
      $("#fec_ofi").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fec_res").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
      $("#fec_pro").prop("disabled", false);
      $("#fec_pro").datepicker("destroy");
      $("#fec_pro").val('');
      $("#fec_pro").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fec_res").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true,
        onSelect: function () {
          $("#unidad").focus();
        },
      });
      $("#fec_sum").prop("disabled", false);
      $("#fec_sum").datepicker("destroy");
      $("#fec_sum").val('');
      $("#fec_sum").datepicker({
        dateFormat: "yy/mm/dd",
        maxDate: $("#fec_res").val(),
        changeYear: true,
        changeMonth: true,
        onSelect: function () {
          $("#fec_ord").prop("disabled", false);
          $("#fec_ord").datepicker("destroy");
          $("#fec_ord").val('');
          $("#fec_ord").datepicker({
            dateFormat: "yy/mm/dd",
            maxDate: $("#fec_res").val(),
            changeYear: true,
            changeMonth: true
          });
          $("#fec_fra").prop("disabled", false);
          $("#fec_fra").datepicker("destroy");
          $("#fec_fra").val('');
          $("#fec_fra").datepicker({
            dateFormat: "yy/mm/dd",
            minDate: $("#fec_sum").val(),
            maxDate: $("#fec_res").val(),
            changeYear: true,
            changeMonth: true
          });
        },
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
          $(this).dialog("close");
        }
      }
    ]
  });
  $("#dialogo5").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 250,
    width: 400,
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
    }
  });
  $("#dialogo6").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
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
  $("#dialogo7").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 150,
    width: 480,
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
        nuevo(1);
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#numero").prop("disabled",true);
  $("#hr").prop("disabled",true);
  $("#oficio").prop("disabled",true);
  $("#prorroga").prop("disabled",true);
  $("#fec_hr").prop("disabled",true);
  $("#dia_tra").prop("disabled",true);
  $("#fec_ofi").prop("disabled",true);
  $("#fec_pro").prop("disabled",true);
  $("#valor").maskMoney();
  $("#valor_p").maskMoney();
  $("#pago").prop("disabled",true);
  $("#fecha9").prop("disabled",true);
  $("#valor_p").prop("disabled",true);
  $("#brigada").prop("disabled",true);
  $("#division").prop("disabled",true);
  $("#unidad1").change(trae_brigada);
  $("#municipio").change(trae_depto);
  $("#departamento").change(trae_municipio);
  $("#departamento").prop("disabled",true);
  $("#estado").prop("disabled",true);
  $("#factor").change(trae_estructura);
  $("#aceptar").button();
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").click(pregunta);
  $("#aceptar1").button();
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").click(pregunta);
  $("#aceptar1").hide();
  $("#aceptar2").button();
  $("#aceptar2").click(val_otro);
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").button();
  $("#aceptar3").click(gra_otro);
  $("#aceptar3").css({ width: '50px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar4").button();
  $("#aceptar4").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar4").click(validacion2);
  $("#aceptar4").hide();
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#hr").focus().select();
  $("#oficio").focus().select();
  $("#prorroga").focus().select();
  $("#tipo_reg").buttonset();
  var val_usuario = $("#v_usuario").val()
  val_usuario = val_usuario.trim();
  if (val_usuario == "SPR_DIADI")
  {
    $("#tipo_reg").show();
  }
  else
  {
    $("#tipo_reg").hide();
  }
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
  trae_estruc();
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
        $("#add_form table").append('<tr><td width="10%" class="espacio2"><input type="text" name="ced_'+z+'" id="ced_'+z+'" class="form-control" onkeypress="return check3(event);" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="15" autocomplete="off"></td><td width="20%" class="espacio2"><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" autocomplete="off"></td><td width="10%" class="espacio2"><input type="text" name="por_'+z+'" id="por_'+z+'" class="form-control numero" value="0.000" onblur="paso_val1('+z+');" onkeypress="return check(event);" autocomplete="off"><input type="hidden" name="pot_'+z+'" id="pot_'+z+'" class="form-control numero" value="0"></td><td width="9%" class="espacio2"><center><a href="#" name="lnk_'+z+'" id="lnk_'+z+'" onclick="subir('+z+');"><img src="imagenes/clip.png" border="0" title="Anexar C&eacute;dula"></a></center></td><td width="10%" class="espacio2"><input type="hidden" name="act_'+z+'" id="act_'+z+'" class="form-control numero" value="0" onkeypress="return check1(event);" onblur="cero('+z+');" maxlength="25" autocomplete="off"></td><td width="12%" class="espacio2"><input type="hidden" name="fep_'+z+'" id="fep_'+z+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td width="15%" class="espacio2"><input type="hidden" name="val_'+z+'" id="val_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_val3('+z+');"><input type="hidden" name="vat_'+z+'" id="vat_'+z+'" class="form-control numero" value="0"><input type="hidden" name="vam_'+z+'" id="vam_'+z+'" class="form-control numero" value="0"></td><td width="9%" class="espacio2"><center><a href="#" name="lnk1_'+z+'" id="lnk1_'+z+'" onclick="subir1('+z+');"><img src="imagenes/clip.png" border="0" title="Anexar Acta Pago"></a></center></td><td width="5%" class="espacio2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>');
      }
      else
      {
        $("#add_form table").append('<tr><td width="10%" class="espacio2"><input type="text" name="ced_'+z+'" id="ced_'+z+'" class="form-control" onkeypress="return check3(event);"  onchange="javascript:this.value=this.value.toUpperCase();" maxlength="15" autocomplete="off"></td><td width="20%" class="espacio2"><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" autocomplete="off"></td><td width="10%" class="espacio2"><input type="text" name="por_'+z+'" id="por_'+z+'" class="form-control numero" value="0.000" onblur="paso_val1('+z+');" onkeypress="return check(event);" autocomplete="off"><input type="hidden" name="pot_'+z+'" id="pot_'+z+'" class="form-control numero" value="0"></td><td width="9%" class="espacio2"><center><a href="#" name="lnk_'+z+'" id="lnk_'+z+'" onclick="subir('+z+');"><img src="imagenes/clip.png" border="0" title="Anexar C&eacute;dula"></a></center></td><td width="10%" class="espacio2"><input type="hidden" name="act_'+z+'" id="act_'+z+'" class="form-control numero" value="0" onkeypress="return check1(event);" onblur="cero('+z+');" maxlength="25" autocomplete="off"></td><td width="12%" class="espacio2"><input type="hidden" name="fep_'+z+'" id="fep_'+z+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td width="15%" class="espacio2"><input type="hidden" name="val_'+z+'" id="val_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_val3('+z+');"><input type="hidden" name="vat_'+z+'" id="vat_'+z+'" class="form-control numero" value="0"><input type="hidden" name="vam_'+z+'" id="vam_'+z+'" class="form-control numero" value="0"></td><td width="9%" class="espacio2"><center><a href="#" name="lnk1_'+z+'" id="lnk1_'+z+'" onclick="subir1('+z+');"><img src="imagenes/clip.png" border="0" title="Anexar Acta Pago"></a></center></td><td width="5%" class="espacio2"><div id="men_'+z+'"><center><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></center></div></td></tr>');
      }
      $("#ced_"+z).on("paste", function(e){
        e.preventDefault();
        alerta("Acción No Permitida");
      });
      $("#ced_"+z).on("dragstart", function(e){
        e.preventDefault();
        alerta("Acción No Permitida");
      });
      $("#fep_"+z).datepicker({
        dateFormat: "yy/mm/dd",
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
      $("#val_"+z).maskMoney();
      $("#lnk1_"+z).hide();
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
  });
  var super1 = $("#v_super").val();
  if (super1 == "1")
  {
    $("#n_batallon").prop("disabled",false);
    $("#aceptar3").show();
  }
  else
  {
    $("#n_batallon").prop("disabled",true);
    $("#aceptar3").hide();
  }
  $("#add_field").click();
  $("#unidad").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#unidad1").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  trae_batallones();
  carga_unidad();
});
function carga_unidad()
{
  var unidad = $("#v_unidad").val();
  var siglas = $("#v_siglas").val();
  if (unidad > 2)
  {
    $("#unidad").html('');
    $("#unidad").append(siglas);
    $("#unidad").val(unidad);
    $("#unidad").prop("disabled",true);
  }
}
function val_resul()
{
  var activo = 0;
  if ($("#tipo1").is(":checked"))
  {
    activo = 1;
  }
  $("#hr").val('0');
  $("#fec_hr").val('');
  $("#hr").prop("disabled",true);
  $("#fec_hr").prop("disabled",true);
  if (activo == "1")
  {
    $("#fec_res").datepicker("destroy");
    $("#fec_res").val('');
    $("#fec_res").datepicker({
      dateFormat: "yy/mm/dd",
      maxDate: 0,
      changeYear: true,
      changeMonth: true,
      onSelect: function () {
        val_resultado();
        $("#fec_hr").prop("disabled", false);
        $("#fec_hr").datepicker("destroy");
        $("#fec_hr").val('');
        $("#fec_hr").datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#fec_res").val(),
          maxDate: 0,
          changeYear: true,
          changeMonth: true,
          onSelect: function () {
            $("#oficio").prop("disabled", false);
            $("#fec_ofi").prop("disabled", false);
            $("#oficio").focus();
          },
        });
        $("#fec_ofi").prop("disabled", false);
        $("#fec_ofi").datepicker("destroy");
        $("#fec_ofi").val('');
        $("#fec_ofi").datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#fec_res").val(),
          maxDate: 0,
          changeYear: true,
          changeMonth: true
        });
        $("#fec_pro").prop("disabled", false);
        $("#fec_pro").datepicker("destroy");
        $("#fec_pro").val('');
        $("#fec_pro").datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#fec_res").val(),
          maxDate: 0,
          changeYear: true,
          changeMonth: true,
          onSelect: function () {
            $("#unidad").focus();
          },
        });
        $("#fec_sum").prop("disabled", false);
        $("#fec_sum").datepicker("destroy");
        $("#fec_sum").val('');
        $("#fec_sum").datepicker({
          dateFormat: "yy/mm/dd",
          maxDate: $("#fec_res").val(),
          changeYear: true,
          changeMonth: true,
          onSelect: function () {
            $("#fec_ord").prop("disabled", false);
            $("#fec_ord").datepicker("destroy");
            $("#fec_ord").val('');
            $("#fec_ord").datepicker({
              dateFormat: "yy/mm/dd",
              minDate: $("#fec_sum").val(),
              maxDate: 0,
              changeYear: true,
              changeMonth: true
            });
            $("#fec_fra").prop("disabled", false);
            $("#fec_fra").datepicker("destroy");
            $("#fec_fra").val('');
            $("#fec_fra").datepicker({
              dateFormat: "yy/mm/dd",
              minDate: $("#fec_sum").val(),
              maxDate: $("#fec_res").val(),
              changeYear: true,
              changeMonth: true
            });
          },
        });
      },
    });
  }
  else
  {
    $("#fec_res").datepicker("destroy");
    $("#fec_res").val('');
    $("#fec_res").datepicker({
      dateFormat: "yy/mm/dd",
      minDate: "-140d",
      maxDate: 0,
      changeYear: true,
      changeMonth: true,
      onSelect: function () {
        val_resultado();
        $("#fec_hr").prop("disabled", false);
        $("#fec_hr").datepicker("destroy");
        $("#fec_hr").val('');
        $("#fec_hr").datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#fec_res").val(),
          maxDate: 0,
          changeYear: true,
          changeMonth: true,
          onSelect: function () {
            $("#oficio").prop("disabled", false);
            $("#fec_ofi").prop("disabled", false);
            $("#oficio").focus();
          },
        });
        $("#fec_ofi").prop("disabled", false);
        $("#fec_ofi").datepicker("destroy");
        $("#fec_ofi").val('');
        $("#fec_ofi").datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#fec_res").val(),
          maxDate: 0,
          changeYear: true,
          changeMonth: true
        });
        $("#fec_pro").prop("disabled", false);
        $("#fec_pro").datepicker("destroy");
        $("#fec_pro").val('');
        $("#fec_pro").datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#fec_res").val(),
          maxDate: 0,
          changeYear: true,
          changeMonth: true,
          onSelect: function () {
            $("#unidad").focus();
          },
        });
        $("#fec_sum").prop("disabled", false);
        $("#fec_sum").datepicker("destroy");
        $("#fec_sum").val('');
        $("#fec_sum").datepicker({
          dateFormat: "yy/mm/dd",
          maxDate: $("#fec_res").val(),
          changeYear: true,
          changeMonth: true,
          onSelect: function () {
            $("#fec_ord").prop("disabled", false);
            $("#fec_ord").datepicker("destroy");
            $("#fec_ord").val('');
            $("#fec_ord").datepicker({
              dateFormat: "yy/mm/dd",
              minDate: $("#fec_sum").val(),
              maxDate: 0,
              changeYear: true,
              changeMonth: true
            });
            $("#fec_fra").prop("disabled", false);
            $("#fec_fra").datepicker("destroy");
            $("#fec_fra").val('');
            $("#fec_fra").datepicker({
              dateFormat: "yy/mm/dd",
              minDate: $("#fec_sum").val(),
              maxDate: $("#fec_res").val(),
              changeYear: true,
              changeMonth: true
            });
          },
        });
      },
    });
  }
}
function val_resultado()
{
  var fecha = $("#fec_res").val();
  var fecha1 = $("#fec_ofi").val();
  var dias = $("#dia_res").val();
  var dias1 = $("#dia_ofi").val();
  if ($("#tipo1").is(":checked"))
  {
    $("#hr").prop("disabled",false);
    $("#fec_hr").prop("disabled",false);
    $("#hr").focus();
  }
  else
  {
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
          var valida1 = $("#numero").val();
          if (valida1 == "0")
          {
            $("#aceptar").show();
          }
          $("#hr").prop("disabled",false);
          $("#fec_hr").prop("disabled",false);
          $("#hr").focus();
          $("#prorroga").prop("disabled",false);
          //if (transcurridos < dias1)
          //{
          //  $("#prorroga").val('0');
          //  $("#fec_pro").val('');
          //  $("#prorroga").prop("disabled",true);
          //  $("#fec_pro").prop("disabled",true);
          //}
          //else
          //{
          //  $("#prorroga").val('0');
          //  $("#fec_pro").val('');
          //  $("#prorroga").prop("disabled",false);
          //  $("#fec_pro").prop("disabled",false);
          //}
        }
        else
        {
          $("#aceptar").hide();
          $("#hr").prop("disabled",true);
          $("#fec_hr").prop("disabled",true);
          var detalle = "<center><h3>Plazo m&aacute;ximo "+dias+" d&iacute;as h&aacute;biles vencido seg&uacute;n Directiva Dic. 02 de 16-02-2019</h3></center>";
          $("#dialogo6").html(detalle);
          $("#dialogo6").dialog("open");
          $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
      }
    });
  }
}
function val_resultado1()
{
  var fecha = $("#fec_res").val();
  var dias = $("#dia_res").val();
  var dias1 = $("#dia_ofi").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "val_fecha1.php",
    data:
    {
      fecha: fecha
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var transcurridos = registros.dias;
      transcurridos = parseInt(transcurridos);
      $("#dia_tra").val(transcurridos);
      if (transcurridos >= dias1)
      {
        $("#prorroga").prop("disabled",false);
        $("#fec_pro").prop("disabled", false);
        $("#fec_pro").datepicker("destroy");
        $("#fec_pro").datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#fec_res").val(),
          maxDate: 0,
          changeYear: true,
          changeMonth: true
        });
      }
    }
  });
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
function val_otro()
{
  var valida = $("#batallon").val();
  if (valida == "-")
  {
  }
  else
  {
    var batallon = $("#batallon").val();
    var n_batallon = $("#batallon option:selected").html();
    var salida = "<option value='"+batallon+"'>"+n_batallon+"</option>";
    $("#brigada").html('');
    $("#brigada").append(salida);
    $("#division").html('');
    $("#division").append(salida);
    $("#unidad").prop("disabled",true);
    $("#unidad1").prop("disabled",true);
    $("#dialogo5").dialog("close");
  }
}
function gra_otro()
{
  var batallon = $("#n_batallon").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "bata_grab1.php",
    data:
    {
      batallon: batallon
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var valida = registros.salida;
      if (valida == "1")
      {
        $("#n_batallon").prop("disabled",true);
        $("#aceptar3").hide();
        trae_batallones();
      }
    }
  });  
}
function trae_batallones()
{
  $("#batallon").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_bata2.php",
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
      $("#batallon").append(salida);
    }
  }); 
}
function trae_brigada()
{
  var unidad = $("#unidad1").val();
  if (unidad == "999")
  {
    $("#dialogo5").dialog("open");
    $("#dialogo5").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#brigada").val('0');
    $("#division").val('0');
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_brig1.php",
      data:
      {
        unidad: unidad
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
  var valor;
  var valor1;
  valor1 = document.getElementById('valor').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#valor1").val(valor1);
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
// Paso valor pago previo fuente
function paso_val2()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('valor_p').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#valor_p1").val(valor1);
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
    var detalle = "<center><h3>Valor Pago "+valor5+" superior al Valor del Porcentaje Asignado "+valor4+"</h3></center>";
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
    var detalle = "<center><h3>Suma Total de Pagos "+valor1+" superior al Valor Solicitado "+valor4+"</h3></center>";
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
    var detalle = "<center><h3>Cédula de Fuente No Registrada, no se permite adjuntar imagen</h3></center>";
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
function subir2()
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
  $("html,body").animate({ scrollTop: 9999 }, "slow");
}
function verificacion()
{
  var conse = $("#numero").val();
  var ano = $("#v_ano").val();
  var directiva = $("#directiva").val();
  var directiva1 = $("#directiva option:selected").html();
  directiva1 = directiva1.trim();
  if (conse == "0")
  {
    var detalle = "<center><h3>Sin Registro previo, no se permite diligenciar<br>Lista de Verificación</h3></center>";
    $("#dialogo2").html(detalle);
    $("#dialogo2").dialog("open");
    $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var url = "<a href='./lista.php?conse="+conse+"&ano="+ano+"&directiva="+directiva+"&directiva1="+directiva1+"' name='link4' id='link4' class='pantalla-modal'>Link</a>";
    $("#link").hide();
    $("#link").html('');
    $("#link").append(url);
    $(".pantalla-modal").magnificPopup({
      type: 'iframe',
      preloader: false,
      modal: false
    });
    $("#link4").click();
    $("#directiva").prop("disabled",true);
  }
}
// Trae municipio segun departamento seleccionado
function trae_municipio()
{
  $("#municipio").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_muni.php",
    data:
    {
      departamento: $("#departamento").val()
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
      $("#municipio").append(salida);
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
// Trae listado estrcuturas
function trae_estruc()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_estruc.php",
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
      $("#paso1").val(salida);
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
function pregunta()
{
  var activo = 0;
  if ($("#tipo1").is(":checked"))
  {
    activo = 1;
  }
  if (activo == "1")
  {
    validacion();
  }
  else
  {
    var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
    $("#dialogo1").html(detalle);
    $("#dialogo1").dialog("open");
    $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
}
function pregunta1()
{
  var usuario = $("#v_envio").val();
  var detalle = "<center><h3>El Registro será enviado a <font color='#3333ff'>"+usuario+"</font>.<br>Esta seguro de continuar ?</h3></center>";
  $("#dialogo3").html(detalle);
  $("#dialogo3").dialog("open");
  $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function validacion()
{
  var activo = 0;
  if ($("#tipo1").is(":checked"))
  {
    activo = 1;
  }
  if (activo == "1")
  {
    var salida = true, detalle = '';
    if ($("#fec_res").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar una Fecha de Resultado</h3></center>";
    }
    if ($("#fec_sum").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar una Fecha de Suministro de Información</h3></center>";
    }
    var valida1 = $("#numero").val();
    if (valida1 == "0")
    {
    }
    else
    {
    	validacion1();
    }
  }
  else
  {
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
    var salida = true, detalle = '';
    if ($("#fec_res").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar una Fecha de Resultado</h3></center>";
    }
    if ($("#hr").val() == '0')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar un Número de HR Inicio Trámite</h3></center>";
    }
    if ($("#fec_hr").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar una Fecha de HR Inicio Trámite</h3></center>";
    }
    var dia_tra = $("#dia_tra").val();
    dia_tra = parseInt(dia_tra);
    if (dia_tra > 45 )
    {
      if ($("#prorroga").val() == '0')
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar un Número de Prórroga</h3></center>";
      }
      if ($("#fec_pro").val() == '')
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar una Fecha de Prórroga</h3></center>";
      }
    }
    if ($("#sintesis").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar una Sintesis</h3></center>";
    }
    if ($("#fec_sum").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar una Fecha de Suministro de Información</h3></center>";
    }
    if (($("#ordop").val() == '') && ($("#fragmentaria").val() == ''))
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar Nombre ORDOP / OFRAG</h3></center>";
    }
    var val_ordop = $("#ordop").val().trim().length;
    val_ordop = parseInt(val_ordop);
    if (val_ordop > 0)
    {
      if ($("#fec_ord").val() == '')
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar una Fecha de ORDOP</h3></center>";
      }
    }
    var val_ofrag = $("#fragmentaria").val().trim().length;
    val_ofrag = parseInt(val_ofrag);
    if (val_ofrag > 0)
    {
      if ($("#fec_fra").val() == '')
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar una Fecha de OFRAG</h3></center>";
      }
    }
    if ($("#sitio").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar un Sitio / Sector / Lugar</h3></center>";
    }
    if ($("#factor").val() == '- SELECCIONAR -')
    {
      salida = false;
      detalle += "<center><h3>Debe seleccionar un Factor de Amenaza</h3></center>";
    }
    if ($("#resultado").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar Resumen del Resultado Operacional</h3></center>";
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
      detalle += "<center><h3>Debe ingresar "+v_cedulas+" Número(s) de Cedula(s)</h3></center>";
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
      detalle += "<center><h3>Debe ingresar "+v_nombres+" Nombre(s) de Fuente(s)</h3></center>";
    }
    if ($("#porcentaje").val() == '100.000')
    {
    }
    else
    {
      salida = false;
      detalle += "<center><h3>Suma de Porcentajes de Fuentes No es igual al 100%</h3></center>";
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
    if (activo == "1")
    {
      var valida1 = $("#numero").val();
      if (valida1 == "0")
      {
        var n_unidad = $("#unidad option:selected").html();
        n_unidad = n_unidad.trim();
        var detalle = "<center><h3>Esta seguro de asignar un Registro de Recompensa a "+n_unidad+" ?</h3></center>";
        $("#dialogo7").html(detalle);
        $("#dialogo7").dialog("open");
        $("#dialogo7").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
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
}
function validacion1()
{
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
  var salida = true, detalle = '';
  if ($("#fec_res").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar una Fecha de Resultado</h3></center>";
  }
  if ($("#hr").val() == '0')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar un Número de HR Inicio Trámite</h3></center>";
  }
  if ($("#fec_hr").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar una Fecha de HR Inicio Trámite</h3></center>";
  }
  var dia_tra = $("#dia_tra").val();
  dia_tra = parseInt(dia_tra);
  if (dia_tra > 45 )
  {
    if ($("#prorroga").val() == '0')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar un Número de Prórroga</h3></center>";
    }
    if ($("#fec_pro").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar una Fecha de Prórroga</h3></center>";
    }
  }
  if ($("#sintesis").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar una Sintesis</h3></center>";
  }
  if ($("#fec_sum").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar una Fecha de Suministro de Información</h3></center>";
  }
  if (($("#ordop").val() == '') && ($("#fragmentaria").val() == ''))
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar Nombre ORDOP / OFRAG</h3></center>";
  }
  var val_ordop = $("#ordop").val().trim().length;
  val_ordop = parseInt(val_ordop);
  if (val_ordop > 0)
  {
    if ($("#fec_ord").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar una Fecha de ORDOP</h3></center>";
    }
  }
  var val_ofrag = $("#fragmentaria").val().trim().length;
  val_ofrag = parseInt(val_ofrag);
  if (val_ofrag > 0)
  {
    if ($("#fec_fra").val() == '')
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar una Fecha de OFRAG</h3></center>";
    }
  }
  if ($("#sitio").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar un Sitio / Sector / Lugar</h3></center>";
  }
  if ($("#factor").val() == '- SELECCIONAR -')
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar un Factor de Amenaza</h3></center>";
  }
  if ($("#resultado").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar Resumen del Resultado Operacional</h3></center>";
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
    detalle += "<center><h3>Debe ingresar "+v_cedulas+" Número(s) de Cedula(s)</h3></center>";
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
    detalle += "<center><h3>Debe ingresar "+v_nombres+" Nombre(s) de Fuente(s)</h3></center>";
  }
  if ($("#porcentaje").val() == '100.000')
  {
  }
  else
  {
    salida = false;
    detalle += "<center><h3>Suma de Porcentajes de Fuentes supera el 100%</h3></center>";
  }
	if (salida == false)
	{
  	$("#dialogo").html(detalle);
	  $("#dialogo").dialog("open");
  	$("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
	}
	else
  {
		nuevo(2);
  }
}
function validacion2()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_lista.php",
    data:
    {
      conse: $("#numero").val(),
      alea: $("#alea").val(),
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
      var valida = registros.salida;
      if (valida == "")
      {
        var detalle = "<center><h3>Lista de Verificación No Registrada</h3></center>";
        $("#dialogo6").html(detalle);
        $("#dialogo6").dialog("open");
        $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
      else
      {
        pregunta1();
      }
    }
  });
}
function nuevo(valor)
{
  var valor;
  var sintesis = $("#sintesis").val();
  var resultado = $("#resultado").val();
  var observaciones = $("#observaciones").val();
  var activo = 0;
  if ($("#tipo1").is(":checked"))
  {
    activo = 1;
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_grab.php",
    data:
    {
      tipo: valor,
      conse: $("#numero").val(),
      fec_res: $("#fec_res").val(),
      hr: $("#hr").val(),
      fec_hr: $("#fec_hr").val(),
      dias: $("#dia_tra").val(),
      oficio: $("#oficio").val(),
      fec_ofi: $("#fec_ofi").val(),
      prorroga: $("#prorroga").val(),
      fec_pro: $("#fec_pro").val(),
      unidad1: $("#unidad").val(),
      unidad2: $("#unidad1").val(),
      nsigla1: $("#unidad option:selected").html(),
      nsigla2: $("#unidad1 option:selected").html(),
      brigada: $("#brigada").val(),
      division: $("#division").val(),
      sintesis: sintesis,
      valor: $("#valor").val(),
      valor1: $("#valor1").val(),
      fec_sum: $("#fec_sum").val(),
      ordop1: $("#ordop1").val(),
      ordop: $("#ordop").val(),
      fec_ord: $("#fec_ord").val(),
      fragmentaria: $("#fragmentaria").val(),
      fec_fra: $("#fec_fra").val(),
      sitio: $("#sitio").val(),
      municipio: $("#municipio").val(),
      departamento: $("#departamento").val(),
      factor: $("#factor").val(),
      estructura: $("#estructura").val(),
      resultado: resultado,
      cedulas: $("#cedulas").val(),
      nombres: $("#nombres").val(),
      porcentajes: $("#porcentajes").val(),
      porcentajes1: $("#porcentajes1").val(),
      actas: $("#actas").val(),
      fechas: $("#fechas").val(),
      valores: $("#valores").val(),
      valores1: $("#valores1").val(),
      observaciones: observaciones,
      directiva: $("#directiva").val(),
      estado: $("#estado").val(),
      alea: $("#alea").val(),
      tipo1: activo,
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
      var valida2 = registros.salida2;
      if (valida > 0)
      {       
        $("#aceptar").hide();
        $("#aceptar1").hide();
        $("#numero").val(valida);
        $("#v_ano").val(valida1);
        if (valida2 == "")
        {
          var detalle = "<center><h3>Lista de Verificación No Registrada</h3></center>";
          $("#dialogo6").html(detalle);
          $("#dialogo6").dialog("open");
          $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        $("#aceptar4").show();
        apaga();
        apaga1();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo6").html(detalle);
        $("#dialogo6").dialog("open");
        $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
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
function apaga()
{
  $("#tipo1").prop("disabled",true);
  $("#fec_res").prop("disabled",true);
  $("#hr").prop("disabled",true);
  $("#fec_hr").prop("disabled",true);
  $("#oficio").prop("disabled",true);
  $("#fec_ofi").prop("disabled",true);
  $("#prorroga").prop("disabled",true);
  $("#fec_pro").prop("disabled",true);
  $("#unidad").prop("disabled",true);
  $("#unidad1").prop("disabled",true);
  $("#sintesis").prop("disabled",true);
  $("#valor").prop("disabled",true);
  $("#fec_sum").prop("disabled",true);
  $("#ordop1").prop("disabled",true);
  $("#ordop").prop("disabled",true);
  $("#fec_ord").prop("disabled",true);
  $("#fragmentaria").prop("disabled",true);
  $("#fec_fra").prop("disabled",true);
  $("#sitio").prop("disabled",true);
  $("#filtro").prop("disabled",true);
  $("#municipio").prop("disabled",true);
  $("#departamento").prop("disabled",true);
  $("#factor").prop("disabled",true);
  $("#estructura").prop("disabled",true);
  $("#resultado").prop("disabled",true);
  $("#observaciones").prop("disabled",true);
  $("#directiva").prop("disabled",true);
}
function apaga1()
{
  $("#tipo_reg").hide();
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
  $("#lnk2").hide();
}
function limpiar(valor)
{
  var valor;
  $("#"+valor).val('');
}
function consultar()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_consu.php",
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
      salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='8%'><b>No.</b></td><td height='35' width='10%'><b>Fec. Registro</b></td><td height='35' width='10%'><b>Fec. Resultado</b></td><td height='35' width='10%'><b>Usuario</b></td><td height='35' width='10%'><b>Manej&oacute; Fuente</b></td><td height='35' width='10%'><b>Efectu&oacute; Operaci&oacute;n</b></td><td height='35' width='10%'><b>ORDOP</b></td><td height='35' width='10%'><b>Fragmentaria</b></td><td height='35' width='12%'><b>Estado</b></td><td height='35' width='5%'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        valida2 = value.conse+","+value.ano;
        salida2 += "<tr><td height='35' width='8%'>"+value.conse+"</td>";
        salida2 += "<td height='35' width='10%'>"+value.fecha+"</td>";
        salida2 += "<td height='35' width='10%'>"+value.fecha1+"</td>";
        salida2 += "<td height='35' width='10%'>"+value.usuario+"</td>";
        salida2 += "<td height='35' width='10%'>"+value.unidad1+"</td>";
        salida2 += "<td height='35' width='10%'>"+value.unidad2+"</td>";
        salida2 += "<td height='35' width='10%'>"+value.ordop+"</td>";
        salida2 += "<td height='35' width='10%'>"+value.fragmenta+"</td>";
        salida2 += "<td height='35' width='12%'>"+value.estado1+"</td>";
        if ((value.estado == "") || (value.estado == "Y"))
        {
          salida2 += "<td height='35' width='5%'><center><a href='#' onclick='modif("+valida2+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
        }
        else
        {
          salida2 += "<td height='35' width='5%' ><center><img src='imagenes/blanco.png' border='0'></center></td>";
        }
        salida2 += "<td height='35' width='5%'><center><a href='#' onclick='link("+valida2+")'><img src='imagenes/pdf.png' border='0' title='Visualizar Lista de Verificaci&oacute;n'></a></center></td></tr>";
        listaplanes.push(value.interno);
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados5").append(salida2);
    }
  });
}
function modif(valor, valor1)
{
  $("#soportes").accordion({active: 0});
  var valor, valor1;
  var tipo = "0";
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
      $("#fec_res").val(registros.fec_res);
      $("#hr").val(registros.hr);
      $("#fec_hr").val(registros.fec_hr);
      $("#dia_tra").val(registros.dias);
      $("#oficio").val(registros.oficio);
      $("#fec_ofi").val(registros.fec_ofi);
      $("#prorroga").val(registros.prorroga);
      $("#fec_pro").val(registros.fec_pro);
      $("#unidad").val(registros.unidad);
      var unidad1 = registros.unidad1;
      unidad1 = "['"+unidad1+"']";
      var unidad2 = '$("#unidad1").val('+unidad1+').trigger("change");';
      eval(unidad2);
      $("#brigada").val(registros.brigada);
      $("#division").val(registros.division);
      $("#sintesis").val(registros.sintesis);
      $("#valor").val(registros.valor);
      $("#valor1").val(registros.valor1);
      $("#fec_sum").val(registros.fec_sum);
      $("#ordop1").val(registros.n_ordop);
      $("#ordop").val(registros.ordop);
      $("#fec_ord").val(registros.fec_ord);
      $("#fragmentaria").val(registros.fragmentaria);
      $("#fec_fra").val(registros.fec_fra);
      $("#sitio").val(registros.sitio);
      $("#filtro").val('');
      $("#municipio").val(registros.municipio);
      $("#departamento").val(registros.departamento);
      $("#factor").val(registros.factor);
      var v_estructura = registros.estructura;
      trae_estructura1(v_estructura);
      $("#resultado").val(registros.resultado);
      var cedulas = registros.cedulas;
      var var_ocu = cedulas.split('|');
      var var_ocu1 = var_ocu.length;
      var var_ocu2 = var_ocu1-1;
      for (var i=0; i<var_ocu2; i++)
      {
        j = i+1;
        paso = var_ocu[i];
        paso = paso.trim();
        $("#ced_"+j).val(paso);
        if (j < var_ocu2)
        {
          $("#add_field").click();
        }
      }
      var nombres = registros.nombres;
      var var_nom = nombres.split('|');
      var var_nom1 = var_nom.length;
      var var_nom2 = var_nom1-1;
      var porcentajes = registros.porcentajes;
      var var_por = porcentajes.split('|');
      var porcentajes1 = registros.porcentajes1;
      var var_por1 = porcentajes1.split('|');
      var actas = registros.actas;
      var var_act = actas.split('|');
      var fechas = registros.fechas;
      var var_fec = fechas.split('|');
      var valores = registros.valores;
      var var_val = valores.split('|');
      var valores1 = registros.valores1;
      var var_val1 = valores1.split('|');
      for (var i=0; i<var_nom2; i++)
      {
        j = i+1;
        paso = var_nom[i];
        paso = paso.trim();
        paso1 = var_por[i];
        paso1 = paso1.trim();
        paso2 = var_por1[i];
        paso2 = paso2.trim();
        paso3 = var_act[i];
        paso3 = paso3.trim();
        paso4 = var_fec[i];
        paso4 = paso4.trim();
        paso5 = var_val[i];
        paso5 = paso5.trim();
        paso6 = var_val1[i];
        paso6 = paso6.trim();
        $("#nom_"+j).val(paso);
        $("#por_"+j).val(paso1);
        $("#pot_"+j).val(paso2);
        $("#act_"+j).val(paso3);
        $("#fep_"+j).val(paso4);
        $("#val_"+j).val(paso5);
        $("#vat_"+j).val(paso6);
        paso_val1(j);
        suma();
        suma1();
      }
      $("#observaciones").val(registros.observaciones);
      $("#directiva").val(registros.directiva);
      $("#alea").val(registros.codigo);
      $("#aceptar").hide();
      $("#aceptar1").show();
      $("#aceptar4").show();
      if (registros.tipo1 == "1")
      {
        $("#tipo1").prop("checked",true);
        $("#fec_res").datepicker("destroy");
        $("#fec_res").val(registros.fec_res);
        $("#fec_res").datepicker({
          dateFormat: "yy/mm/dd",
          minDate: registros.fec_res,
          maxDate: registros.fec_res,
          changeYear: false,
          changeMonth: false,
          onSelect: function () {
            val_resultado();
            $("#fec_hr").prop("disabled",false);
            $("#fec_hr").datepicker("destroy");
            $("#fec_hr").val('');
            $("#fec_hr").datepicker({
              dateFormat: "yy/mm/dd",
              minDate: $("#fec_res").val(),
              maxDate: 0,
              changeYear: true,
              changeMonth: true,
              onSelect: function () {
                $("#oficio").prop("disabled",false);
                $("#fec_ofi").prop("disabled",false);
                $("#oficio").focus();
              },
            });
            $("#fec_ofi").prop("disabled",false);
            $("#fec_ofi").datepicker("destroy");
            $("#fec_ofi").val('');
            $("#fec_ofi").datepicker({
              dateFormat: "yy/mm/dd",
              minDate: $("#fec_res").val(),
              maxDate: 0,
              changeYear: true,
              changeMonth: true
            });
            $("#fec_pro").prop("disabled",false);
            $("#fec_pro").datepicker("destroy");
            $("#fec_pro").val('');
            $("#fec_pro").datepicker({
              dateFormat: "yy/mm/dd",
              minDate: $("#fec_res").val(),
              maxDate: 0,
              changeYear: true,
              changeMonth: true,
              onSelect: function () {
                $("#unidad").focus();
              },
            });
            $("#fec_sum").prop("disabled",false);
            $("#fec_sum").datepicker("destroy");
            $("#fec_sum").val(registros.fec_sum);
            $("#fec_sum").datepicker({
              dateFormat: "yy/mm/dd",
              minDate: registros.fec_sum,
              maxDate: registros.fec_sum,
              changeYear: false,
              changeMonth: false,
              onSelect: function () {
                $("#fec_ord").prop("disabled",false);
                $("#fec_ord").datepicker("destroy");
                $("#fec_ord").val('');
                $("#fec_ord").datepicker({
                  dateFormat: "yy/mm/dd",
                  minDate: $("#fec_sum").val(),
                  maxDate: 0,
                  changeYear: true,
                  changeMonth: true
                });
                $("#fec_fra").prop("disabled",false);
                $("#fec_fra").datepicker("destroy");
                $("#fec_fra").val('');
                $("#fec_fra").datepicker({
                  dateFormat: "yy/mm/dd",
                  minDate: $("#fec_sum").val(),
                  maxDate: 0,
                  changeYear: true,
                  changeMonth: true
                });
              },
            });
          },
        });
        $("#unidad").prop("disabled",true);
        $("#hr").prop("disabled",false);
        $("#oficio").prop("disabled",false);
      }
      else
      {
        $("#oficio").prop("disabled",false);
        $("#fec_ofi").prop("disabled",false);
        $("#fec_ofi").datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#fec_res").val(),
          maxDate: 0,
          changeYear: true,
          changeMonth: true
        });
        $("#prorroga").prop("disabled",false);
        $("#fec_pro").prop("disabled",false);
      }
      $("#directiva").prop("disabled",false);
      var lista = registros.lista;
      lista = lista.trim();
      if (lista == "")
      {
        $("#aceptar4").hide();
      }
      else
      {
        $("#aceptar4").show();
      }
      val_resultado1();
    }
  });
}
function enviar()
{
  var usuario = $("#v_envio").val();
  var numero = $("#numero").val();
  var ano = $("#v_ano").val();
  var tipo = "0";
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
        $("#aceptar4").hide();
        $("#estado").val(salida1);
        apaga();
        apaga1();
        $("#lnk3").hide();
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
function link(valor, valor1)
{
  var valor, valor1;
  $("#rec_conse").val(valor);
  $("#rec_ano").val(valor1);
  formu3.submit();
}
function check(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9.]/;
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
function alerta(valor)
{
  alertify.error(valor);
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
// 04/10/2023 - Ajuste busqueda sobre combo de unidad efectua
// 22/02/2024 - Ajuste validacion fecha ordop no valide feha minima
// 07/05/2024 - Ajuste carge combo buscador
// 24/01/2025 - Ajuste creacion de otras unidades que no son de ejercito
// 21/03/2028 - Ajuste inclusion nueva directiva
// 11/04/2025 - Ajuste inclusion directiva desde tabla ordenada por ultima
// 05/05/2025 - Ajuste buscador campo unidad
?>