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
  include('permisos.php');
  require('funciones.php');
  $conse = $_GET["conse"];
  $ano = $_GET["ano"];
  $directiva = $_GET["directiva"];
  $directiva1 = $_GET["directiva1"];
  $pregunta = "SELECT directiva, lista, fec_res, fec_sum FROM cx_reg_rec WHERE conse='$conse' AND ano='$ano'";
  $sql = odbc_exec($conexion, $pregunta);
  while($i<$row=odbc_fetch_array($sql))
  {
    $directiva2 = odbc_result($sql,1);
    $lista = trim($row["lista"]);
    $fec_res = odbc_result($sql,3);
    $fec_sum = odbc_result($sql,4);
  }
  $valida = "0";
  if ($directiva == $directiva2)
  {
    $valida = "1";
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
<link href="jquery/jquery1/jquery-ui.css" rel="stylesheet">
<script src="jquery/jquery1/jquery.js"></script>
<script src="jquery/jquery1/jquery-ui.js"></script>
<br>
<div id="tabla">
  <div id="load">
    <center>
      <img src="dist/img/cargando1.gif" alt="Cargando..." />
    </center>
  </div>
  <table width="95%" align="center" border="1">
    <tr>
      <td colspan="2" height="35" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Lista de Verificaci&oacute;n Directiva <?php echo $directiva1; ?></font></b></center></td>
      <input type="hidden" name="numero" id="numero" class="form-control" value="<?php echo $conse; ?>" readonly="readonly">
      <input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly">
      <input type="hidden" name="directiva" id="directiva" class="form-control" value="<?php echo $directiva; ?>" readonly="readonly">
      <input type="hidden" name="lista" id="lista" class="form-control" value="" readonly="readonly">
      <input type="hidden" name="listas" id="listas" class="form-control" value="<?php echo $lista; ?>" readonly="readonly">
      <input type="hidden" name="fec_res" id="fec_res" class="form-control" value="<?php echo $fec_res; ?>" readonly="readonly">
      <input type="hidden" name="fec_sum" id="fec_sum" class="form-control" value="<?php echo $fec_sum; ?>" readonly="readonly">
    </tr>
    <tr>
      <td>
        <div id="lista1">
          <table width="100%" align="center" border="1">
            <tr>
              <td width="60%">
                &nbsp;
              </td>
              <td width="5%">
                <center>
                  <b>SI</b>
                </center>
              </td>
              <td width="5%">
                <center>
                  <b>NO</b>
                </center>
              </td>
              <td width="10%">
                <center>
                  <b>No. Doc</b>
                </center>
              </td>
              <td width="10%">
                <center>
                  <b>Fecha</b>
                </center>
              </td>
              <td width="5%">
                <center>
                  <b>Folio<br>Inicial</b>
                </center>
              </td>
              <td width="5%">
                <center>
                  <b>Folio<br>Final</b>
                </center>
              </td>
          </tr>
          <tr>
                            <td>
                                LA SOLICITUD DEBE SEGUIR EL CONDUCTO REGULAR CON EL RESPECTIVO APOYO BAT. BR. DIV.
                            </td>
                            <td>
                                <center>
                                    <input type="radio" name="l1_1_1" id="l1_1_1" value="1" onclick="val_lista1()">
                                </center>
                            </td>
                            <td>
                                <center>
                                    <input type="radio" name="l1_1_1" id="l1_1_1" value="1" onclick="val_lista1()" checked>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <input type="text" name="l1_1_2" id="l1_1_2" class="form-control numero" value="0">
                                </center>
                            </td>
                            <td>
                                <center>
                                    <input type="text" name="l1_1_3" id="l1_1_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                </center>
                            </td>
                            <td>
                                <center>
                                    <input type="text" name="l1_1_4" id="l1_1_4" class="form-control numero" value="0">
                                </center>
                            </td>
                            <td>
                                <center>
                                    <input type="text" name="l1_1_5" id="l1_1_5" class="form-control numero" value="0">
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                DOCUMENTO OFICIAL CON EL CUAL LA RESPECTIVA UNIDAD INFORMA AL MANDO SUPERIOR LOS RESULTADOS OBTENIDOS
                            </td>
                            <td>
                                <center>
                                    <input type="radio" name="l1_2_1" id="l1_2_1" value="1" onclick="val_lista1()">
                                </center>
                            </td>
                            <td>
                                <center>
                                    <input type="radio" name="l1_2_1" id="l1_2_1" value="1" onclick="val_lista1()" checked>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <input type="text" name="l1_2_2" id="l1_2_2" class="form-control numero" value="0">
                                </center>
                            </td>
                            <td>
                                <center>
                                    <input type="text" name="l1_2_3" id="l1_2_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                </center>
                            </td>
                            <td>
                                <center>
                                    <input type="text" name="l1_2_4" id="l1_2_4" class="form-control numero" value="0">
                                </center>
                            </td>
                            <td>
                                <center>
                                    <input type="text" name="l1_2_5" id="l1_2_5" class="form-control numero" value="0">
                                </center>
                            </td>
                        </tr>
                            <tr>
                                <td>
                                    CERTIFICACION INFORMANTE NO PERTENECE A REINSERCION EXPEDIDO POR EL COMANDANTE DE LA UNIDAD
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_3_1" id="l1_3_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_3_1" id="l1_3_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_3_2" id="l1_3_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_3_3" id="l1_3_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_3_4" id="l1_3_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_3_5" id="l1_3_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    DOCUMENTO OFICIAL QUE ORDENE LA OPERACION DE LA UNIDAD TACTICA Y/O OPERATIVA
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_4_1" id="l1_4_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_4_1" id="l1_4_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_4_2" id="l1_4_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_4_3" id="l1_4_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_4_4" id="l1_4_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_4_5" id="l1_4_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    INFORME DE PATRULLA O RESULTADOS
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_5_1" id="l1_5_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_5_1" id="l1_5_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_5_2" id="l1_5_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_5_3" id="l1_5_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_5_4" id="l1_5_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_5_5" id="l1_5_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    CERTIFICACION POR PARTE DEL JEFE DE LA SECCION DE INT.
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_6_1" id="l1_6_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_6_1" id="l1_6_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_6_2" id="l1_6_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_6_3" id="l1_6_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_6_4" id="l1_6_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_6_5" id="l1_6_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" height="35" bgcolor="#ccc">
                                    <b>Capturas</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    DOCUMENTO DEJANDO A DISPOSICION AUTORIDAD JUD. CAPTURADO
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_7_1" id="l1_7_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_7_1" id="l1_7_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_7_2" id="l1_7_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_7_3" id="l1_7_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_7_4" id="l1_7_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_7_5" id="l1_7_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ORGANIGRAMA SIMPLIFICADO CON LA UBICACION DE LA ESTRUCTURA
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_8_1" id="l1_8_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_8_1" id="l1_8_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_8_2" id="l1_8_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_8_3" id="l1_8_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_8_4" id="l1_8_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_8_5" id="l1_8_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    FOTOGRAFIAS DEL TERRORISTA CAPTURADO O FUGADO
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_9_1" id="l1_9_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_9_1" id="l1_9_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_9_2" id="l1_9_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                            <input type="text" name="l1_9_3" id="l1_9_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_9_4" id="l1_9_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_9_5" id="l1_9_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ANTECEDENTES PENALES Y/O ANOTACIONES DEL TERRORISTA
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_10_1" id="l1_10_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_10_1" id="l1_10_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_10_2" id="l1_10_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_10_3" id="l1_10_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_10_4" id="l1_10_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_10_5" id="l1_10_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    TARJETA DECADACTILAR DEL CAPTURADO O FUGADO
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_11_1" id="l1_11_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_11_1" id="l1_11_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_11_2" id="l1_11_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_11_3" id="l1_11_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_11_4" id="l1_11_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_11_5" id="l1_11_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ENTREVISTA DEL CAPTURADO O FUGADO
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_12_1" id="l1_12_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_12_1" id="l1_12_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_12_2" id="l1_12_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_12_3" id="l1_12_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_12_4" id="l1_12_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_12_5" id="l1_12_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" height="35" bgcolor="#ccc">
                                    <b>Abatidos</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ACTA DE LEVANTAMIENTO
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_13_1" id="l1_13_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_13_1" id="l1_13_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_13_2" id="l1_13_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_13_3" id="l1_13_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_13_4" id="l1_13_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_13_5" id="l1_13_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ORGANIGRAMA SIMPLIFICADO CON LA UBICACION DE LA ESTRUCTURA
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_14_1" id="l1_14_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_14_1" id="l1_14_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_14_2" id="l1_14_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_14_3" id="l1_14_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_14_4" id="l1_14_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_14_5" id="l1_14_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    FOTOGRAFIAS DEL TERRORISTA CAPTURADO O FUGADO
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_15_1" id="l1_15_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_15_1" id="l1_15_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_15_2" id="l1_15_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_15_3" id="l1_15_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_15_4" id="l1_15_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_15_5" id="l1_15_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ANTECEDENTES PENALES Y/O ANOTACIONES DEL TERRORISTA
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_16_1" id="l1_16_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_16_1" id="l1_16_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_16_2" id="l1_16_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_16_3" id="l1_16_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_16_4" id="l1_16_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_16_5" id="l1_16_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    TARJETA DE NECRODACTILIA
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_17_1" id="l1_17_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_17_1" id="l1_17_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_17_2" id="l1_17_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_17_3" id="l1_17_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_17_4" id="l1_17_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_17_5" id="l1_17_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" height="35" bgcolor="#ccc">
                                    <b>Material</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ACTA O DOCUMENTO INTERNO DE LA INCAUTACION DE MATERIAL
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_18_1" id="l1_18_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_18_1" id="l1_18_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_18_2" id="l1_18_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_18_3" id="l1_18_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_18_4" id="l1_18_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_18_5" id="l1_18_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    FOTOGRAFIAS DEL MATERIAL INCAUTADO
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_19_1" id="l1_19_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_19_1" id="l1_19_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_19_2" id="l1_19_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_19_3" id="l1_19_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_19_4" id="l1_19_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_19_5" id="l1_19_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ANALISIS PRELIMINAR MATERIAL INCAUTADO
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_20_1" id="l1_20_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_20_1" id="l1_20_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_20_2" id="l1_20_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_20_3" id="l1_20_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_20_4" id="l1_20_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_20_5" id="l1_20_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" height="35" bgcolor="#ccc">
                                    <b>Documentos</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ACTA O DOCUMENTO INTERNO DE LA INCAUTACION DE MATERIAL
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_21_1" id="l1_21_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_21_1" id="l1_21_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_21_2" id="l1_21_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_21_3" id="l1_21_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_21_4" id="l1_21_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_21_5" id="l1_21_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ANALISIS DE DOCUMENTOS INCAUTADOS - PERTENENCIA
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_22_1" id="l1_22_1" value="1" onclick="val_lista1()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l1_22_1" id="l1_22_1" value="1" onclick="val_lista1()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_22_2" id="l1_22_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_22_3" id="l1_22_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_22_4" id="l1_22_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l1_22_5" id="l1_22_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                        </table>
        </div>
        <div id="lista2">
          <table width="100%" align="center" border="1">
            <tr>
              <td width="58%">
                &nbsp;
              </td>
              <td width="5%">
                <center>
                  <b>SI</b>
                </center>
              </td>
              <td width="5%">
                <center>
                  <b>NO</b>
                </center>
              </td>
              <td width="12%">
                <center>
                  <b>No. Doc</b>
                </center>
              </td>
              <td width="10%">
                <center>
                  <b>Fecha</b>
                </center>
              </td>
              <td width="5%">
                <center>
                  <b>Folio<br>Inicial</b>
                </center>
              </td>
              <td width="5%">
                <center>
                  <b>Folio<br>Final</b>
                </center>
              </td>
            </tr>
            <tr>
              <td>
                <div align="justify">LA SOLICITUD DEBE SEGUIR EL CONDUCTO REGULAR CON EL RESPECTIVO APOYO BATALLÓN (OFICIO REMISORIO EXP. BR).</div>
              </td>
              <td>
                <center>
                  <input type="radio" name="l2_1_1" id="l2_1_1" value="1" onclick="val_lista2()">
                </center>
              </td>
              <td>
                <center>
                  <input type="radio" name="l2_1_1" id="l2_1_1" value="1" onclick="val_lista2()" checked>
                </center>
              </td>
              <td>
                <center>
                  <input type="text" name="l2_1_2" id="l2_1_2" class="form-control numero" value="0">
                </center>
              </td>
              <td>
                <center>
                  <input type="text" name="l2_1_3" id="l2_1_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </center>
              </td>
              <td>
                <center>
                  <input type="text" name="l2_1_4" id="l2_1_4" class="form-control numero" value="0">
                </center>
              </td>
              <td>
                <center>
                  <input type="text" name="l2_1_5" id="l2_1_5" class="form-control numero" value="0">
                </center>
              </td>
            </tr>
            <tr>
              <td>
                <div align="justify">LA SOLICITUD DEBE SEGUIR EL CONDUCTO REGULAR CON EL RESPECTIVO APOYO BRIGADA (OFICIO REMISORIO EXP. DIV)</div>
              </td>
              <td>
                <center>
                  <input type="radio" name="l2_2_1" id="l2_2_1" value="1" onclick="val_lista2()">
                </center>
              </td>
              <td>
                <center>
                  <input type="radio" name="l2_2_1" id="l2_2_1" value="1" onclick="val_lista2()" checked>
                </center>
              </td>
            <td>
              <center>
                <input type="text" name="l2_2_2" id="l2_2_2" class="form-control numero" value="0">
              </center>
            </td>
            <td>
              <center>
                <input type="text" name="l2_2_3" id="l2_2_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </center>
            </td>
            <td>
              <center>
                <input type="text" name="l2_2_4" id="l2_2_4" class="form-control numero" value="0">
              </center>
            </td>
            <td>
              <center>
                <input type="text" name="l2_2_5" id="l2_2_5" class="form-control numero" value="0">
              </center>
            </td>
          </tr>
          <tr>
            <td>
              <div align="justify">LA SOLICITUD DEBE SEGUIR EL CONDUCTO REGULAR CON EL RESPECTIVO APOYO DIVISIÓN (OFICIO REMISORIO EXP. CEDE2).</div>
            </td>
            <td>
              <center>
                <input type="radio" name="l2_3_1" id="l2_3_1" value="1" onclick="val_lista2()">
              </center>
            </td>
            <td>
              <center>
                <input type="radio" name="l2_3_1" id="l2_3_1" value="1" onclick="val_lista2()" checked>
              </center>
            </td>
            <td>
              <center>
                <input type="text" name="l2_3_2" id="l2_3_2" class="form-control numero" value="0">
              </center>
            </td>
            <td>
              <center>
                <input type="text" name="l2_3_3" id="l2_3_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </center>
            </td>
            <td>
              <center>
                <input type="text" name="l2_3_4" id="l2_3_4" class="form-control numero" value="0">
              </center>
            </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_3_5" id="l2_3_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">INFORME DE CONTACTO CON LA FUENTE (INICIAL O PRELIMINAR DE LA INFORMACIÓN SUMINISTRADA POR LA FUENTE).</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_4_1" id="l2_4_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_4_1" id="l2_4_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_4_2" id="l2_4_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_4_3" id="l2_4_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_4_4" id="l2_4_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_4_5" id="l2_4_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">INFORME DE INTELIGENCIA DONDE SE INCLUYE LA INFORMACIÓN ENTREGADA POR LA FUENTE DEBIDAMENTE EVALUADA.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_5_1" id="l2_5_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_5_1" id="l2_5_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_5_2" id="l2_5_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_5_3" id="l2_5_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_5_4" id="l2_5_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_5_5" id="l2_5_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">DOCUMENTO OFICIAL CON EL CUAL LA RESPECTIVA UNIDAD INFORMA AL MANDO SUPERIOR LOS RESULTADOS OBTENIDOS (RADIOGRAMA AL COE POR PARTE DE LA DIV).</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_6_1" id="l2_6_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_6_1" id="l2_6_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_6_2" id="l2_6_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_6_3" id="l2_6_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_6_4" id="l2_6_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_6_5" id="l2_6_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">CERTIFICACIÓN EXPEDIDA POR EL COMANDANTE DE LA UNIDAD DONDE SE INDIQUE QUE NO SE TRAMITARÁ PAGO ALGUNO ANTE EL GAHD, OTRA FUERZA NI PONAL COMO TAMPOCO A TRAVÉS DE LA ALCALDÍA O GOBERNACIÓN CON RECURSOS DE LEY 418 DE 1997.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_7_1" id="l2_7_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_7_1" id="l2_7_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_7_2" id="l2_7_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_7_3" id="l2_7_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_7_4" id="l2_7_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_7_5" id="l2_7_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">CERTIFICACIÓN INFORMANTE NO PERTENECE AL PROGRAMA DE REINSERCIÓN EXPEDIDO POR EL GAHD.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_8_1" id="l2_8_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_8_1" id="l2_8_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_8_2" id="l2_8_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_8_3" id="l2_8_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_8_4" id="l2_8_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_8_5" id="l2_8_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">DOCUMENTO OFICIAL QUE ORDENE LA OPERACIÓN DE LA UNIDAD TÁCTICA Y/O OPERATIVA (ORDOP ó OFRAG).</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_9_1" id="l2_9_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_9_1" id="l2_9_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_9_2" id="l2_9_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_9_3" id="l2_9_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_9_4" id="l2_9_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_9_5" id="l2_9_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">ANEXO DE INTELIGENCIA.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_10_1" id="l2_10_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_10_1" id="l2_10_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_10_2" id="l2_10_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_10_3" id="l2_10_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_10_4" id="l2_10_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_10_5" id="l2_10_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">INFORME RESULTADOS OBTENIDOS EN DESARROLLO DE LA OPERACIÓN FIRMADO, DONDE REFERENCIA QUE FUE PRODUCTO INFORMACIÓN APORTADA POR FUENTE HUMANA.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_11_1" id="l2_11_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_11_1" id="l2_11_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_11_2" id="l2_11_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_11_3" id="l2_11_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_11_4" id="l2_11_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_11_5" id="l2_11_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">COPIA INFORME PRIMER RESPONDIENTE O INFORME EJECUTIVO DEJANDO A DISPOSICIÓN DE AUTORIDAD LOS ELEMENTOS INCAUTADOS Y/O INMOVILIZADOS Y/O PERSONAL NEUTRALIZADO.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_12_1" id="l2_12_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_12_1" id="l2_12_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_12_2" id="l2_12_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_12_3" id="l2_12_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_12_4" id="l2_12_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_12_5" id="l2_12_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">ACTA DE ACUERDOS PREVIOS CON LA FUENTE SIN DETERMINAR CIFRAS PARA EL PAGO.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_13_1" id="l2_13_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_13_1" id="l2_13_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_13_2" id="l2_13_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_13_3" id="l2_13_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_13_4" id="l2_13_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_13_5" id="l2_13_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" height="35" bgcolor="#ccc">
                                    <b>Neutralizaciones (Capturas o Desmovilizaciones)</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  <div align="justify">ACTA O DOCUMENTO INTERNO PUESTA A DISPOSICIÓN DE AUTORIDAD COMPETENTE.</div>
                                </td>
                                <td>
                                    <center>
                                      <input type="radio" name="l2_14_1" id="l2_14_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="radio" name="l2_14_1" id="l2_14_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_14_2" id="l2_14_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_14_3" id="l2_14_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_14_4" id="l2_14_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_14_5" id="l2_14_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">DEBE ADJUNTAR UN ORGANIGRAMA SIMPLIFICADO CON LA UBICACIÓN EN LA ESTRUCTURA DELINCUENCIAL DEL SUJETO O SUJETOS NEUTRALIZADOS CON INFORMACIÓN DE INTELIGENCIA Y/O CONTRAINTELIGENCIA.</div>
                                </td>
                                <td>
                                    <center>
                                      <input type="radio" name="l2_15_1" id="l2_15_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="radio" name="l2_15_1" id="l2_15_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_15_2" id="l2_15_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_15_3" id="l2_15_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_15_4" id="l2_15_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_15_5" id="l2_15_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">FOTOGRAFÍAS DEL TERRORISTA CAPTURADO.</div>
                                </td>
                                <td>
                                    <center>
                                      <input type="radio" name="l2_16_1" id="l2_16_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="radio" name="l2_16_1" id="l2_16_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_16_2" id="l2_16_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_16_3" id="l2_16_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_16_4" id="l2_16_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_16_5" id="l2_16_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  <div align="justify">PRONTUARIO O PERFIL DELICTIVO O ANTECEDENTES DELICTIVO DEL SUJETO O SUJETOS REPORTADOS.</div>
                                </td>
                                <td>
                                    <center>
                                      <input type="radio" name="l2_17_1" id="l2_17_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="radio" name="l2_17_1" id="l2_17_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_17_2" id="l2_17_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_17_3" id="l2_17_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_17_4" id="l2_17_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_17_5" id="l2_17_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  <div align="justify">TARJETA DECADACTILAR DEL NEUTRALIZADO.</div>
                                </td>
                                <td>
                                    <center>
                                      <input type="radio" name="l2_18_1" id="l2_18_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="radio" name="l2_18_1" id="l2_18_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_18_2" id="l2_18_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_18_3" id="l2_18_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_18_4" id="l2_18_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_18_5" id="l2_18_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  <div align="justify">CERTIFICADO DE CODA DE LA ACEPTACIÓN POR PARTE DEL GAHD (PARA DESMOVILIZADOS).</div>
                                </td>
                                <td>
                                    <center>
                                      <input type="radio" name="l2_19_1" id="l2_19_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="radio" name="l2_19_1" id="l2_19_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_19_2" id="l2_19_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_19_3" id="l2_19_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_19_4" id="l2_19_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                      <input type="text" name="l2_19_5" id="l2_19_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" height="35" bgcolor="#ccc">
                                  <b>Muerte en Desarrollo de Operaci&oacute;n Militar</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">ACTA DE INSPECCIÓN AL CADÁVER.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_20_1" id="l2_20_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_20_1" id="l2_20_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_20_2" id="l2_20_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_20_3" id="l2_20_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_20_4" id="l2_20_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_20_5" id="l2_20_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">DEBE ADJUNTARSE UN ORGANIGRAMA SIMPLIFICADO CON LA UBICACIÓN EN LA ESTRUCTURA DELINCUENCIAL DEL SUJETO O SUJETOS NEUTRALIZADOS CON INFORMACIÓN DE INTELIGENCIA Y/O CONTRAINTELIGENCIA.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_21_1" id="l2_21_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_21_1" id="l2_21_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_21_2" id="l2_21_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_21_3" id="l2_21_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_21_4" id="l2_21_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_21_5" id="l2_21_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">FOTOGRAFÍAS DEL TERRORISTA NEUTRALIZADOS.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_22_1" id="l2_22_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_22_1" id="l2_22_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_22_2" id="l2_22_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_22_3" id="l2_22_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_22_4" id="l2_22_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_22_5" id="l2_22_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">PRONTUARIO DELICTIVO.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_23_1" id="l2_23_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_23_1" id="l2_23_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_23_2" id="l2_23_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_23_3" id="l2_23_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_23_4" id="l2_23_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_23_5" id="l2_23_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">TARJETA NECRODACTILAR.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_24_1" id="l2_24_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_24_1" id="l2_24_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_24_2" id="l2_24_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_24_3" id="l2_24_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_24_4" id="l2_24_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_24_5" id="l2_24_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" height="35" bgcolor="#ccc">
                                    <b>Material</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">ACTA O DOCUMENTO INTERNO DE LA INCAUTACION DE MATERIAL.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_25_1" id="l2_25_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_25_1" id="l2_25_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_25_2" id="l2_25_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_25_3" id="l2_25_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_25_4" id="l2_25_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_25_5" id="l2_25_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <div align="justify">FOTOGRAFIAS DEL MATERIAL INCAUTADO.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_26_1" id="l2_26_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_26_1" id="l2_26_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_26_2" id="l2_26_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_26_3" id="l2_26_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_26_4" id="l2_26_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_26_5" id="l2_26_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div align="justify">ANALISIS PRELIMINAR MATERIAL INCAUTADO.</div>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_27_1" id="l2_27_1" value="1" onclick="val_lista2()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l2_27_1" id="l2_27_1" value="1" onclick="val_lista2()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_27_2" id="l2_27_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_27_3" id="l2_27_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_27_4" id="l2_27_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l2_27_5" id="l2_27_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                        </table>
        </div>
        <div id="lista3">
                        <table width="100%" align="center" border="1">
                            <tr>
                                <td width="60%">
                                    &nbsp;
                                </td>
                                <td width="5%">
                                    <center>
                                        <b>SI</b>
                                    </center>
                                </td>
                                <td width="5%">
                                    <center>
                                        <b>NO</b>
                                    </center>
                                </td>
                                <td width="10%">
                                    <center>
                                        <b>No. Doc</b>
                                    </center>
                                </td>
                                <td width="10%">
                                    <center>
                                        <b>Fecha</b>
                                    </center>
                                </td>
                                <td width="5%">
                                    <center>
                                        <b>Folio<br>Inicial</b>
                                    </center>
                                </td>
                                <td width="5%">
                                    <center>
                                        <b>Folio<br>Final</b>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    1. Copia informe de contacto con la fuente - PROIC.
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_1_1" id="l3_1_1" value="1" onclick="val_lista3()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_1_1" id="l3_1_1" value="1" onclick="val_lista3()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_1_2" id="l3_1_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_1_3" id="l3_1_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_1_4" id="l3_1_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_1_5" id="l3_1_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    2. Copia anexo de inteligencia a la ORDOP.
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_2_1" id="l3_2_1" value="1" onclick="val_lista3()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_2_1" id="l3_2_1" value="1" onclick="val_lista3()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_2_2" id="l3_2_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_2_3" id="l3_2_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_2_4" id="l3_2_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_2_5" id="l3_2_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    3. Copia informe de inteligencia y contrainteligencia, informe preliminar de inteligencia o informe de inteligencia preventivo.
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_3_1" id="l3_3_1" value="1" onclick="val_lista3()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_3_1" id="l3_3_1" value="1" onclick="val_lista3()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_3_2" id="l3_3_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_3_3" id="l3_3_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_3_4" id="l3_3_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_3_5" id="l3_3_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    4. Copia orden de operaci&oacute;n militar emitida por la unidad operativa y/o t&aacute;ctica.
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_4_1" id="l3_4_1" value="1" onclick="val_lista3()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_4_1" id="l3_4_1" value="1" onclick="val_lista3()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_4_2" id="l3_4_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_4_3" id="l3_4_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_4_4" id="l3_4_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_4_5" id="l3_4_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    5. Copia orden fragmentaria emitida por la unidad operativa y/o t&aacute;ctica (Cuando aplique).
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_5_1" id="l3_5_1" value="1" onclick="val_lista3()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_5_1" id="l3_5_1" value="1" onclick="val_lista3()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_5_2" id="l3_5_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_5_3" id="l3_5_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_5_4" id="l3_5_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_5_5" id="l3_5_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    6. Copia del informe de patrullaje emitido por el responsable de la ORDOP militar.
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_6_1" id="l3_6_1" value="1" onclick="val_lista3()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_6_1" id="l3_6_1" value="1" onclick="val_lista3()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_6_2" id="l3_6_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_6_3" id="l3_6_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_6_4" id="l3_6_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_6_5" id="l3_6_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    7. Copia radiograma de reporte al COE. del resultado operacional emitido por parte del comando de la Divisi&oacute;n.
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_7_1" id="l3_7_1" value="1" onclick="val_lista3()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_7_1" id="l3_7_1" value="1" onclick="val_lista3()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_7_2" id="l3_7_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_7_3" id="l3_7_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_7_4" id="l3_7_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_7_5" id="l3_7_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    8. Documento emitido por el Comandante de la Unidad solicitante, donde certifica que NO dar&aacute; tramite de pago de la recompensa a trav&eacute;s del GAHD, otra Fuerza ni PONAL como tampoco a trav&eacute;s de la alcald&iacute;a o gobernaci&oacute;n con recursos de ley 418 de 1997.
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_8_1" id="l3_8_1" value="1" onclick="val_lista3()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_8_1" id="l3_8_1" value="1" onclick="val_lista3()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_8_2" id="l3_8_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_8_3" id="l3_8_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_8_4" id="l3_8_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_8_5" id="l3_8_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    9. Certificaci&oacute;n informante no pertenece al programa de reinserci&oacute;n expedido por el GAHD.
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_9_1" id="l3_9_1" value="1" onclick="val_lista3()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_9_1" id="l3_9_1" value="1" onclick="val_lista3()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_9_2" id="l3_9_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_9_3" id="l3_9_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_9_4" id="l3_9_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_9_5" id="l3_9_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    10. Acta de acuerdos con la fuente.
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_10_1" id="l3_10_1" value="1" onclick="val_lista3()">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="radio" name="l3_10_1" id="l3_10_1" value="1" onclick="val_lista3()" checked>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_10_2" id="l3_10_2" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_10_3" id="l3_10_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_10_4" id="l3_10_4" class="form-control numero" value="0">
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <input type="text" name="l3_10_5" id="l3_10_5" class="form-control numero" value="0">
                                    </center>
                                </td>
                            </tr>
                            <?php
                            if ($tpu_usuario == "7")
                            {
                            ?>
                                <tr>
                                    <td>
                                        11. Oficios de apoyo al tramite de recompensas emitido por el Comando Brigada y Divisi&oacute;n.
                                    </td>
                                    <td>
                                        <center>
                                            <input type="radio" name="l3_11_1" id="l3_11_1" value="1" onclick="val_lista3()">
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <input type="radio" name="l3_11_1" id="l3_11_1" value="1" onclick="val_lista3()" checked>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <input type="text" name="l3_11_2" id="l3_11_2" class="form-control numero" value="0">
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <input type="text" name="l3_11_3" id="l3_11_3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <input type="text" name="l3_11_4" id="l3_11_4" class="form-control numero" value="0">
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <input type="text" name="l3_11_5" id="l3_11_5" class="form-control numero" value="0">
                                        </center>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="7" height="40">
                                    <br>
                                    <b>Tipo de Resultado</b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <div id="tipo_l3">
                                        <input type="checkbox" name="tipo1_l3" id="tipo1_l3" onclick="vali1()"><label for="tipo1_l3">Cristalizadero - Laboratorio - Material</label>
                                        <input type="checkbox" name="tipo2_l3" id="tipo2_l3" onclick="vali2()"><label for="tipo2_l3">Capturas</label>
                                        <input type="checkbox" name="tipo3_l3" id="tipo3_l3" onclick="vali3()"><label for="tipo3_l3">M.D.O.M</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" height="15" valign="bottom">
                                    &nbsp;
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    <br>
    <center>
        <input type="button" name="actualizar" id="actualizar" value="Actualizar">
    </center>
    <br>
</div>
<style>
.ui-widget
{
  font-size: 13px;
}
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
$(document).ready(function() {
  $("#load").hide();
  var fec_res = $("#fec_res").val();
  var fec_sum = $("#fec_sum").val();
  // Lista1
  for (i=1; i<=22; i++)
  {
    $("#l1_"+i+"_2").prop("disabled",true);
    $("#l1_"+i+"_3").prop("disabled",true);
    $("#l1_"+i+"_4").prop("disabled",true);
    $("#l1_"+i+"_5").prop("disabled",true);
    //if ((i == "4") || (i == "5") || (i == "9") || (i == "10"))
    //{
      $("#l1_"+i+"_3").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: fec_sum,
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
    //}
    //else
    //{
    //  $("#l1_"+i+"_3").datepicker({
    //    dateFormat: "yy/mm/dd",
    //    minDate: fec_res,
    //    maxDate: 0,
    //    changeYear: true,
    //    changeMonth: true
    //  });
    //}
  }
  // Lista2
  for (i=1; i<=27; i++)
  {
    $("#l2_"+i+"_2").prop("disabled",true);
    $("#l2_"+i+"_3").prop("disabled",true);
    $("#l2_"+i+"_4").prop("disabled",true);
    $("#l2_"+i+"_5").prop("disabled",true);
    if ((i == "4") || (i == "5") || (i == "9") || (i == "10"))
    {
		  $("#l2_"+i+"_3").datepicker({
				dateFormat: "yy/mm/dd",
				minDate: fec_sum,
				maxDate: 0,
				changeYear: true,
				changeMonth: true
			});
		}
		else
		{
			$("#l2_"+i+"_3").datepicker({
				dateFormat: "yy/mm/dd",
				minDate: fec_res,
				maxDate: 0,
				changeYear: true,
				changeMonth: true
			});
    }
  }
  $("#lista1").hide();
  $("#lista2").hide();
  $("#lista3").hide();
  $("#actualizar").button();
  $("#actualizar").click(actualizar);
  $("#actualizar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  valida_direc();
});
function valida_direc()
{
  var directiva = $("#directiva").val();
  switch (directiva)
  {
    case '1':
      $("#lista1").show();
      $("#lista2").hide();
      $("#lista3").hide();
      break;
    case '2':
    case '3':
    case '4':
      $("#lista1").hide();
      $("#lista2").show();
      $("#lista3").hide();
      break;
    default:
      $("#lista1").hide();
      $("#lista2").hide();
      $("#lista3").hide();
      break;
  }
  trae_lista();
}
function trae_lista()
{
  var directiva = $("#directiva").val();
  var campos = 0;
  var var_lista = 0;
	var lista = $("#listas").val(); 
	var var_ocu = lista.split('|');
	var var_ocu1 = var_ocu.length;
	if (var_ocu1 > 2)
	{
		var a = 0;
    var b = 1;
		var c = 2;
		var d = 3;
		var e = 4;
    if (directiva == "1")
    {
      var_lista = 1;
      campos = 22;
    }
    else
    {
      var_lista = 2;
      campos = 27;
    }
    for (i=1; i<=campos; i++)
	  {
      var paso0 = var_ocu[a];
      var paso1 = var_ocu[b];
      var paso2 = var_ocu[c];
      var paso3 = var_ocu[d];
      var paso4 = var_ocu[e];
      if (paso0 == "1")
      {
        $("#l"+var_lista+"_"+i+"_1").prop("checked", true);
      }
      $("#l"+var_lista+"_"+i+"_2").val(paso1);
      $("#l"+var_lista+"_"+i+"_3").val(paso2);
      $("#l"+var_lista+"_"+i+"_4").val(paso3);
      $("#l"+var_lista+"_"+i+"_5").val(paso4);
			a = a+5;
			b = b+5;
			c = c+5;
			d = d+5;
			e = e+5;
    }
	}
}
function val_lista1()
{
  for (i=1; i<=22; i++)
  {
    if (document.getElementById('l1_'+i+'_1').checked)
    {
      document.getElementById('l1_'+i+'_2').removeAttribute("disabled");
      document.getElementById('l1_'+i+'_3').removeAttribute("disabled");
      document.getElementById('l1_'+i+'_4').removeAttribute("disabled");
      document.getElementById('l1_'+i+'_5').removeAttribute("disabled");
    }
    else
    {
      $("#l1_"+i+"_2").val("0");
      $("#l1_"+i+"_3").val("");
      $("#l1_"+i+"_4").val("0");
      $("#l1_"+i+"_5").val("0");
      $("#l1_"+i+"_2").prop("disabled",true);
      $("#l1_"+i+"_3").prop("disabled",true);
      $("#l1_"+i+"_4").prop("disabled",true);
      $("#l1_"+i+"_5").prop("disabled",true);
    }
  }
}
function val_lista2()
{
  for (i=1; i<=27; i++)
  {
    if (document.getElementById('l2_'+i+'_1').checked)
    {
      document.getElementById('l2_'+i+'_2').removeAttribute("disabled");
      document.getElementById('l2_'+i+'_3').removeAttribute("disabled");
      document.getElementById('l2_'+i+'_4').removeAttribute("disabled");
      document.getElementById('l2_'+i+'_5').removeAttribute("disabled");
    }
    else
    {
      $("#l2_"+i+"_2").val("0");
      $("#l2_"+i+"_3").val("");
      $("#l2_"+i+"_4").val("0");
      $("#l2_"+i+"_5").val("0");
      $("#l2_"+i+"_2").prop("disabled",true);
      $("#l2_"+i+"_3").prop("disabled",true);
      $("#l2_"+i+"_4").prop("disabled",true);
      $("#l2_"+i+"_5").prop("disabled",true);
    }
  }
  /*
  if (document.getElementById('l2_2_1').checked)
  {
    document.getElementById('l2_2_2').removeAttribute("disabled");
    document.getElementById('l2_2_3').removeAttribute("disabled");
    document.getElementById('l2_2_4').removeAttribute("disabled");
    document.getElementById('l2_2_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_2_2").val("0");
    $("#l2_2_3").val("");
    $("#l2_2_4").val("0");
    $("#l2_2_5").val("0");
    $("#l2_2_2").prop("disabled",true);
    $("#l2_2_3").prop("disabled",true);
    $("#l2_2_4").prop("disabled",true);
    $("#l2_2_5").prop("disabled",true);
  }
  if (document.getElementById('l2_3_1').checked)
  {
    document.getElementById('l2_3_2').removeAttribute("disabled");
    document.getElementById('l2_3_3').removeAttribute("disabled");
    document.getElementById('l2_3_4').removeAttribute("disabled");
    document.getElementById('l2_3_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_3_2").val("0");
    $("#l2_3_3").val("");
    $("#l2_3_4").val("0");
    $("#l2_3_5").val("0");
    $("#l2_3_2").prop("disabled",true);
    $("#l2_3_3").prop("disabled",true);
    $("#l2_3_4").prop("disabled",true);
    $("#l2_3_5").prop("disabled",true);
  }
  if (document.getElementById('l2_4_1').checked)
  {
    document.getElementById('l2_4_2').removeAttribute("disabled");
    document.getElementById('l2_4_3').removeAttribute("disabled");
    document.getElementById('l2_4_4').removeAttribute("disabled");
    document.getElementById('l2_4_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_4_2").val("0");
    $("#l2_4_3").val("");
    $("#l2_4_4").val("0");
    $("#l2_4_5").val("0");
    $("#l2_4_2").prop("disabled",true);
    $("#l2_4_3").prop("disabled",true);
    $("#l2_4_4").prop("disabled",true);
    $("#l2_4_5").prop("disabled",true);
  }
  if (document.getElementById('l2_5_1').checked)
  {
    document.getElementById('l2_5_2').removeAttribute("disabled");
    document.getElementById('l2_5_3').removeAttribute("disabled");
    document.getElementById('l2_5_4').removeAttribute("disabled");
    document.getElementById('l2_5_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_5_2").val("0");
    $("#l2_5_3").val("");
    $("#l2_5_4").val("0");
    $("#l2_5_5").val("0");
    $("#l2_5_2").prop("disabled",true);
    $("#l2_5_3").prop("disabled",true);
    $("#l2_5_4").prop("disabled",true);
    $("#l2_5_5").prop("disabled",true);
  }
  if (document.getElementById('l2_6_1').checked)
  {
    document.getElementById('l2_6_2').removeAttribute("disabled");
    document.getElementById('l2_6_3').removeAttribute("disabled");
    document.getElementById('l2_6_4').removeAttribute("disabled");
    document.getElementById('l2_6_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_6_2").val("0");
    $("#l2_6_3").val("");
    $("#l2_6_4").val("0");
    $("#l2_6_5").val("0");
    $("#l2_6_2").prop("disabled",true);
    $("#l2_6_3").prop("disabled",true);
    $("#l2_6_4").prop("disabled",true);
    $("#l2_6_5").prop("disabled",true);
  }
  if (document.getElementById('l2_7_1').checked)
  {
    document.getElementById('l2_7_2').removeAttribute("disabled");
    document.getElementById('l2_7_3').removeAttribute("disabled");
    document.getElementById('l2_7_4').removeAttribute("disabled");
    document.getElementById('l2_7_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_7_2").val("0");
    $("#l2_7_3").val("");
    $("#l2_7_4").val("0");
    $("#l2_7_5").val("0");
    $("#l2_7_2").prop("disabled",true);
    $("#l2_7_3").prop("disabled",true);
    $("#l2_7_4").prop("disabled",true);
    $("#l2_7_5").prop("disabled",true);
  }
  if (document.getElementById('l2_8_1').checked)
  {
    document.getElementById('l2_8_2').removeAttribute("disabled");
    document.getElementById('l2_8_3').removeAttribute("disabled");
    document.getElementById('l2_8_4').removeAttribute("disabled");
    document.getElementById('l2_8_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_8_2").val("0");
    $("#l2_8_3").val("");
    $("#l2_8_4").val("0");
    $("#l2_8_5").val("0");
    $("#l2_8_2").prop("disabled",true);
    $("#l2_8_3").prop("disabled",true);
    $("#l2_8_4").prop("disabled",true);
    $("#l2_8_5").prop("disabled",true);
  }
  if (document.getElementById('l2_9_1').checked)
  {
    document.getElementById('l2_9_2').removeAttribute("disabled");
    document.getElementById('l2_9_3').removeAttribute("disabled");
    document.getElementById('l2_9_4').removeAttribute("disabled");
    document.getElementById('l2_9_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_9_2").val("0");
    $("#l2_9_3").val("");
    $("#l2_9_4").val("0");
    $("#l2_9_5").val("0");
    $("#l2_9_2").prop("disabled",true);
    $("#l2_9_3").prop("disabled",true);
    $("#l2_9_4").prop("disabled",true);
    $("#l2_9_5").prop("disabled",true);
  }
  if (document.getElementById('l2_10_1').checked)
  {
    document.getElementById('l2_10_2').removeAttribute("disabled");
    document.getElementById('l2_10_3').removeAttribute("disabled");
    document.getElementById('l2_10_4').removeAttribute("disabled");
    document.getElementById('l2_10_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_10_2").val("0");
    $("#l2_10_3").val("");
    $("#l2_10_4").val("0");
    $("#l2_10_5").val("0");
    $("#l2_10_2").prop("disabled",true);
    $("#l2_10_3").prop("disabled",true);
    $("#l2_10_4").prop("disabled",true);
    $("#l2_10_5").prop("disabled",true);
  }
  if (document.getElementById('l2_11_1').checked)
  {
    document.getElementById('l2_11_2').removeAttribute("disabled");
    document.getElementById('l2_11_3').removeAttribute("disabled");
    document.getElementById('l2_11_4').removeAttribute("disabled");
    document.getElementById('l2_11_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_11_2").val("0");
    $("#l2_11_3").val("");
    $("#l2_11_4").val("0");
    $("#l2_11_5").val("0");
    $("#l2_11_2").prop("disabled",true);
    $("#l2_11_3").prop("disabled",true);
    $("#l2_11_4").prop("disabled",true);
    $("#l2_11_5").prop("disabled",true);
  }
  if (document.getElementById('l2_12_1').checked)
  {
    document.getElementById('l2_12_2').removeAttribute("disabled");
    document.getElementById('l2_12_3').removeAttribute("disabled");
    document.getElementById('l2_12_4').removeAttribute("disabled");
    document.getElementById('l2_12_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_12_2").val("0");
    $("#l2_12_3").val("");
    $("#l2_12_4").val("0");
    $("#l2_12_5").val("0");
    $("#l2_12_2").prop("disabled",true);
    $("#l2_12_3").prop("disabled",true);
    $("#l2_12_4").prop("disabled",true);
    $("#l2_12_5").prop("disabled",true);
  }
  if (document.getElementById('l2_13_1').checked)
  {
    document.getElementById('l2_13_2').removeAttribute("disabled");
    document.getElementById('l2_13_3').removeAttribute("disabled");
    document.getElementById('l2_13_4').removeAttribute("disabled");
    document.getElementById('l2_13_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_13_2").val("0");
    $("#l2_13_3").val("");
    $("#l2_13_4").val("0");
    $("#l2_13_5").val("0");
    $("#l2_13_2").prop("disabled",true);
    $("#l2_13_3").prop("disabled",true);
    $("#l2_13_4").prop("disabled",true);
    $("#l2_13_5").prop("disabled",true);
  }
  if (document.getElementById('l2_14_1').checked)
  {
    document.getElementById('l2_14_2').removeAttribute("disabled");
    document.getElementById('l2_14_3').removeAttribute("disabled");
    document.getElementById('l2_14_4').removeAttribute("disabled");
    document.getElementById('l2_14_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_14_2").val("0");
    $("#l2_14_3").val("");
    $("#l2_14_4").val("0");
    $("#l2_14_5").val("0");
    $("#l2_14_2").prop("disabled",true);
    $("#l2_14_3").prop("disabled",true);
    $("#l2_14_4").prop("disabled",true);
    $("#l2_14_5").prop("disabled",true);
  }
  if (document.getElementById('l2_15_1').checked)
  {
    document.getElementById('l2_15_2').removeAttribute("disabled");
    document.getElementById('l2_15_3').removeAttribute("disabled");
    document.getElementById('l2_15_4').removeAttribute("disabled");
    document.getElementById('l2_15_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_15_2").val("0");
    $("#l2_15_3").val("");
    $("#l2_15_4").val("0");
    $("#l2_15_5").val("0");
    $("#l2_15_2").prop("disabled",true);
    $("#l2_15_3").prop("disabled",true);
    $("#l2_15_4").prop("disabled",true);
    $("#l2_15_5").prop("disabled",true);
  }
  if (document.getElementById('l2_16_1').checked)
  {
    document.getElementById('l2_16_2').removeAttribute("disabled");
    document.getElementById('l2_16_3').removeAttribute("disabled");
    document.getElementById('l2_16_4').removeAttribute("disabled");
    document.getElementById('l2_16_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_16_2").val("0");
    $("#l2_16_3").val("");
    $("#l2_16_4").val("0");
    $("#l2_16_5").val("0");
    $("#l2_16_2").prop("disabled",true);
    $("#l2_16_3").prop("disabled",true);
    $("#l2_16_4").prop("disabled",true);
    $("#l2_16_5").prop("disabled",true);
  }
  if (document.getElementById('l2_17_1').checked)
  {
    document.getElementById('l2_17_2').removeAttribute("disabled");
    document.getElementById('l2_17_3').removeAttribute("disabled");
    document.getElementById('l2_17_4').removeAttribute("disabled");
    document.getElementById('l2_17_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_17_2").val("0");
    $("#l2_17_3").val("");
    $("#l2_17_4").val("0");
    $("#l2_17_5").val("0");
    $("#l2_17_2").prop("disabled",true);
    $("#l2_17_3").prop("disabled",true);
    $("#l2_17_4").prop("disabled",true);
    $("#l2_17_5").prop("disabled",true);
  }
  if (document.getElementById('l2_18_1').checked)
  {
    document.getElementById('l2_18_2').removeAttribute("disabled");
    document.getElementById('l2_18_3').removeAttribute("disabled");
    document.getElementById('l2_18_4').removeAttribute("disabled");
    document.getElementById('l2_18_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_18_2").val("0");
    $("#l2_18_3").val("");
    $("#l2_18_2").prop("disabled",true);
    $("#l2_18_3").prop("disabled",true);
    $("#l2_18_4").prop("disabled",true);
    $("#l2_18_5").prop("disabled",true);
  }
  if (document.getElementById('l2_19_1').checked)
  {
    document.getElementById('l2_19_2').removeAttribute("disabled");
    document.getElementById('l2_19_3').removeAttribute("disabled");
    document.getElementById('l2_19_4').removeAttribute("disabled");
    document.getElementById('l2_19_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_19_2").val("0");
    $("#l2_19_3").val("");
    $("#l2_19_4").val("0");
    $("#l2_19_5").val("0");
    $("#l2_19_2").prop("disabled",true);
    $("#l2_19_3").prop("disabled",true);
    $("#l2_19_4").prop("disabled",true);
    $("#l2_19_5").prop("disabled",true);
  }
  if (document.getElementById('l2_20_1').checked)
  {
    document.getElementById('l2_20_2').removeAttribute("disabled");
    document.getElementById('l2_20_3').removeAttribute("disabled");
    document.getElementById('l2_20_4').removeAttribute("disabled");
    document.getElementById('l2_20_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_20_2").val("0");
    $("#l2_20_3").val("");
    $("#l2_20_4").val("0");
    $("#l2_20_5").val("0");
    $("#l2_20_2").prop("disabled",true);
    $("#l2_20_3").prop("disabled",true);
    $("#l2_20_4").prop("disabled",true);
    $("#l2_20_5").prop("disabled",true);
  }
  if (document.getElementById('l2_21_1').checked)
  {
    document.getElementById('l2_21_2').removeAttribute("disabled");
    document.getElementById('l2_21_3').removeAttribute("disabled");
    document.getElementById('l2_21_4').removeAttribute("disabled");
    document.getElementById('l2_21_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_21_2").val("0");
    $("#l2_21_3").val("");
    $("#l2_21_4").val("0");
    $("#l2_21_5").val("0");
    $("#l2_21_2").prop("disabled",true);
    $("#l2_21_3").prop("disabled",true);
    $("#l2_21_4").prop("disabled",true);
    $("#l2_21_5").prop("disabled",true);
  }
  if (document.getElementById('l2_22_1').checked)
  {
    document.getElementById('l2_22_2').removeAttribute("disabled");
    document.getElementById('l2_22_3').removeAttribute("disabled");
    document.getElementById('l2_22_4').removeAttribute("disabled");
    document.getElementById('l2_22_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_22_2").val("0");
    $("#l2_22_3").val("");
    $("#l2_22_4").val("0");
    $("#l2_22_5").val("0");
    $("#l2_22_2").prop("disabled",true);
    $("#l2_22_3").prop("disabled",true);
    $("#l2_22_4").prop("disabled",true);
    $("#l2_22_5").prop("disabled",true);
  }
  if (document.getElementById('l2_23_1').checked)
  {
    document.getElementById('l2_23_2').removeAttribute("disabled");
    document.getElementById('l2_23_3').removeAttribute("disabled");
    document.getElementById('l2_23_4').removeAttribute("disabled");
    document.getElementById('l2_23_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_23_2").val("0");
    $("#l2_23_3").val("");
    $("#l2_23_4").val("0");
    $("#l2_23_5").val("0");
    $("#l2_23_2").prop("disabled",true);
    $("#l2_23_3").prop("disabled",true);
    $("#l2_23_4").prop("disabled",true);
    $("#l2_23_5").prop("disabled",true);
  }
  if (document.getElementById('l2_24_1').checked)
  {
    document.getElementById('l2_24_2').removeAttribute("disabled");
    document.getElementById('l2_24_3').removeAttribute("disabled");
    document.getElementById('l2_24_4').removeAttribute("disabled");
    document.getElementById('l2_24_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_24_2").val("0");
    $("#l2_24_3").val("");
    $("#l2_24_4").val("0");
    $("#l2_24_5").val("0");
    $("#l2_24_2").prop("disabled",true);
    $("#l2_24_3").prop("disabled",true);
    $("#l2_24_4").prop("disabled",true);
    $("#l2_24_5").prop("disabled",true);
  }
  if (document.getElementById('l2_25_1').checked)
  {
    document.getElementById('l2_25_2').removeAttribute("disabled");
    document.getElementById('l2_25_3').removeAttribute("disabled");
    document.getElementById('l2_25_4').removeAttribute("disabled");
    document.getElementById('l2_25_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_25_2").val("0");
    $("#l2_25_3").val("");
    $("#l2_25_4").val("0");
    $("#l2_25_5").val("0");
    $("#l2_25_2").prop("disabled",true);
    $("#l2_25_3").prop("disabled",true);
    $("#l2_25_4").prop("disabled",true);
    $("#l2_25_5").prop("disabled",true);
  }
  if (document.getElementById('l2_26_1').checked)
  {
    document.getElementById('l2_26_2').removeAttribute("disabled");
    document.getElementById('l2_26_3').removeAttribute("disabled");
    document.getElementById('l2_26_4').removeAttribute("disabled");
    document.getElementById('l2_26_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_26_2").val("0");
    $("#l2_26_3").val("");
    $("#l2_26_4").val("0");
    $("#l2_26_5").val("0");
    $("#l2_26_2").prop("disabled",true);
    $("#l2_26_3").prop("disabled",true);
    $("#l2_26_4").prop("disabled",true);
    $("#l2_26_5").prop("disabled",true);
  }
  if (document.getElementById('l2_27_1').checked)
  {
    document.getElementById('l2_27_2').removeAttribute("disabled");
    document.getElementById('l2_27_3').removeAttribute("disabled");
    document.getElementById('l2_27_4').removeAttribute("disabled");
    document.getElementById('l2_27_5').removeAttribute("disabled");
  }
  else
  {
    $("#l2_27_2").val("0");
    $("#l2_27_3").val("");
    $("#l2_27_4").val("0");
    $("#l2_27_5").val("0");
    $("#l2_27_2").prop("disabled",true);
    $("#l2_27_3").prop("disabled",true);
    $("#l2_27_4").prop("disabled",true);
    $("#l2_27_5").prop("disabled",true);
  }
  */
}
function actualizar()
{
  var directiva = $("#directiva").val();
  if (directiva == "1")
  {
    if ($("#l1_1_1").is(":checked"))
    {
      valor1 = "1";
    }
    else
    {
      valor1 = "0";
    }
    var valor2 = $("#l1_1_2").val();
    var valor3 = $("#l1_1_3").val();
    var valor4 = $("#l1_1_4").val();
    var valor5 = $("#l1_1_5").val();
    // 2
    if ($("#l1_2_1").is(":checked"))
    {
      valor6 = "1";
    }
    else
    {
      valor6 = "0";
    }
    var valor7 = $("#l1_2_2").val();
    var valor8 = $("#l1_2_3").val();
    var valor9 = $("#l1_2_4").val();
    var valor10 = $("#l1_2_5").val();
    // 3
    if ($("#l1_3_1").is(":checked"))
    {
      valor11 = "1";
    }
    else
    {
      valor11 = "0";
    }
    var valor12 = $("#l1_3_2").val();
    var valor13 = $("#l1_3_3").val();
    var valor14 = $("#l1_3_4").val();
    var valor15 = $("#l1_3_5").val();
    // 4
    if ($("#l1_4_1").is(":checked"))
    {
      valor16 = "1";
    }
    else
    {
      valor16 = "0";
    }
    var valor17 = $("#l1_4_2").val();
    var valor18 = $("#l1_4_3").val();
    var valor19 = $("#l1_4_4").val();
    var valor20 = $("#l1_4_5").val();
    // 5
    if ($("#l1_5_1").is(":checked"))
    {
      valor21 = "1";
    }
    else
    {
      valor21 = "0";
    }
    var valor22 = $("#l1_5_2").val();
    var valor23 = $("#l1_5_3").val();
    var valor24 = $("#l1_5_4").val();
    var valor25 = $("#l1_5_5").val();
    // 6 
    if ($("#l1_6_1").is(":checked"))
    {
      valor26 = "1";
    }
    else
    {
      valor26 = "0";
    }
    var valor27 = $("#l1_6_2").val();
    var valor28 = $("#l1_6_3").val();
    var valor29 = $("#l1_6_4").val();
    var valor30 = $("#l1_6_5").val();
    // 7
    if ($("#l1_7_1").is(":checked"))
    {
      valor31 = "1";
    }
    else
    {
      valor31 = "0";
    }
    var valor32 = $("#l1_7_2").val();
    var valor33 = $("#l1_7_3").val();
    var valor34 = $("#l1_7_4").val();
    var valor35 = $("#l1_7_5").val();
    // 8
    if ($("#l1_8_1").is(":checked"))
    {
      valor36 = "1";
    }
    else
    {
      valor36 = "0";
    }
    var valor37 = $("#l1_8_2").val();
    var valor38 = $("#l1_8_3").val();
    var valor39 = $("#l1_8_4").val();
    var valor40 = $("#l1_8_5").val();
    // 9
    if ($("#l1_9_1").is(":checked"))
    {
      valor41 = "1";
    }
    else
    {
      valor41 = "0";
    }
    var valor42 = $("#l1_9_2").val();
    var valor43 = $("#l1_9_3").val();
    var valor44 = $("#l1_9_4").val();
    var valor45 = $("#l1_9_5").val();
    //  10
    if ($("#l1_10_1").is(":checked"))
    {
      valor46 = "1";
    }
    else
    {
      valor46 = "0";
    }
    var valor47 = $("#l1_10_2").val();
    var valor48 = $("#l1_10_3").val();
    var valor49 = $("#l1_10_4").val();
    var valor50 = $("#l1_10_5").val();
    // 11
    if ($("#l1_11_1").is(":checked"))
    {
      valor51 = "1";
    }
    else
    {
      valor51 = "0";
    }
    var valor52 = $("#l1_11_2").val();
    var valor53 = $("#l1_11_3").val();
    var valor54 = $("#l1_11_4").val();
    var valor55 = $("#l1_11_5").val();
    // 12
    if ($("#l1_12_1").is(":checked"))
    {
      valor56 = "1";
    }
    else
    {
      valor56 = "0";
    }
    var valor57 = $("#l1_12_2").val();
    var valor58 = $("#l1_12_3").val();
    var valor59 = $("#l1_12_4").val();
    var valor60 = $("#l1_12_5").val();
    //  13
    if ($("#l1_13_1").is(":checked"))
    {
      valor61 = "1";
    }
    else
    {
      valor61 = "0";
    }
    var valor62 = $("#l1_13_2").val();
    var valor63 = $("#l1_13_3").val();
    var valor64 = $("#l1_13_4").val();
    var valor65 = $("#l1_13_5").val();
    // 14
    if ($("#l1_14_1").is(":checked"))
    {
      valor66 = "1";
    }
    else
    {
      valor66 = "0";
    }
    var valor67 = $("#l1_14_2").val();
    var valor68 = $("#l1_14_3").val();
    var valor69 = $("#l1_14_4").val();
    var valor70 = $("#l1_14_5").val();
    // 15
    if ($("#l1_15_1").is(":checked"))
    {
      valor71 = "1";
    }
    else
    {
      valor71 = "0";
    }
    var valor72 = $("#l1_15_2").val();
    var valor73 = $("#l1_15_3").val();
    var valor74 = $("#l1_15_4").val();
    var valor75 = $("#l1_15_5").val();
    // 16
    if ($("#l1_16_1").is(":checked"))
    {
      valor76 = "1";
    }
    else
    {
      valor76 = "0";
    }
    var valor77 = $("#l1_16_2").val();
    var valor78 = $("#l1_16_3").val();
    var valor79 = $("#l1_16_4").val();
    var valor80 = $("#l1_16_5").val();
    // 17
    if ($("#l1_17_1").is(":checked"))
    {
      valor81 = "1";
    }
    else
    {
      valor81 = "0";
    }
    var valor82 = $("#l1_17_2").val();
    var valor83 = $("#l1_17_3").val();
    var valor84 = $("#l1_17_4").val();
    var valor85 = $("#l1_17_5").val();
    // 18
    if ($("#l1_18_1").is(":checked"))
    {
      valor86 = "1";
    }
    else
    {
      valor86 = "0";
    }
    var valor87 = $("#l1_18_2").val();
    var valor88 = $("#l1_18_3").val();
    var valor89 = $("#l1_18_4").val();
    var valor90 = $("#l1_18_5").val();
    // 19
    if ($("#l1_19_1").is(":checked"))
    {
      valor91 = "1";
    }
    else
    {
      valor91 = "0";
    }
    var valor92 = $("#l1_19_2").val();
    var valor93 = $("#l1_19_3").val();
    var valor94 = $("#l1_19_4").val();
    var valor95 = $("#l1_19_5").val();
    // 20
    if ($("#l1_20_1").is(":checked"))
    {
      valor96 = "1";
    }
    else
    {
      valor96 = "0";
    }
    var valor97 = $("#l1_20_2").val();
    var valor98 = $("#l1_20_3").val();
    var valor99 = $("#l1_20_4").val();
    var valor100 = $("#l1_20_5").val();
    // 21
    if ($("#l1_21_1").is(":checked"))
    {
      valor101 = "1";
    }
    else
    {
      valor101 = "0";
    }
    var valor102 = $("#l1_21_2").val();
    var valor103 = $("#l1_21_3").val();
    var valor104 = $("#l1_21_4").val();
    var valor105 = $("#l1_21_5").val();
    //  22
    if ($("#l1_22_1").is(":checked"))
    {
      valor106 = "1";
    }
    else
    {
      valor106 = "0";
    }
    var valor107 = $("#l1_22_2").val();
    var valor108 = $("#l1_22_3").val();
    var valor109 = $("#l1_22_4").val();
    var valor110 = $("#l1_22_5").val();
    var lis_final = valor1+"|"+valor2+"|"+valor3+"|"+valor4+"|"+valor5+"|"+valor6+"|"+valor7+"|"+valor8+"|"+valor9+"|"+valor10+"|"+valor11+"|"+valor12+"|"+valor13+"|"+valor14+"|"+valor15+"|"+valor16+"|"+valor17+"|"+valor18+"|"+valor19+"|"+valor20+"|"+valor21+"|"+valor22+"|"+valor23+"|"+valor24+"|"+valor25+"|"+valor26+"|"+valor27+"|"+valor28+"|"+valor29+"|"+valor30+"|"+valor31+"|"+valor32+"|"+valor33+"|"+valor34+"|"+valor35+"|"+valor36+"|"+valor37+"|"+valor38+"|"+valor39+"|"+valor40+"|"+valor41+"|"+valor42+"|"+valor43+"|"+valor44+"|"+valor45+"|"+valor46+"|"+valor47+"|"+valor48+"|"+valor49+"|"+valor50+"|"+valor51+"|"+valor52+"|"+valor53+"|"+valor54+"|"+valor55+"|"+valor56+"|"+valor57+"|"+valor58+"|"+valor59+"|"+valor60+"|"+valor61+"|"+valor62+"|"+valor63+"|"+valor64+"|"+valor65+"|"+valor66+"|"+valor67+"|"+valor68+"|"+valor69+"|"+valor70+"|"+valor71+"|"+valor72+"|"+valor73+"|"+valor74+"|"+valor75+"|"+valor76+"|"+valor77+"|"+valor78+"|"+valor79+"|"+valor80+"|"+valor81+"|"+valor82+"|"+valor83+"|"+valor84+"|"+valor85+"|"+valor86+"|"+valor87+"|"+valor88+"|"+valor89+"|"+valor90+"|"+valor91+"|"+valor92+"|"+valor93+"|"+valor94+"|"+valor95+"|"+valor96+"|"+valor97+"|"+valor98+"|"+valor99+"|"+valor100+"|"+valor101+"|"+valor102+"|"+valor103+"|"+valor104+"|"+valor105+"|"+valor106+"|"+valor107+"|"+valor108+"|"+valor109+"|"+valor110+"|";
  }
  else
  {
    if ($("#l2_1_1").is(":checked"))
    {
      valor1 = "1";
    }
    else
    {
      valor1 = "0";
    }
    var valor2 = $("#l2_1_2").val();
    var valor3 = $("#l2_1_3").val();
    var valor4 = $("#l2_1_4").val();
    var valor5 = $("#l2_1_5").val();
    // 2
    if ($("#l2_2_1").is(":checked"))
    {
      valor6 = "1";
    }
    else
    {
      valor6 = "0";
    }
    var valor7 = $("#l2_2_2").val();
    var valor8 = $("#l2_2_3").val();
    var valor9 = $("#l2_2_4").val();
    var valor10 = $("#l2_2_5").val();
    // 3
    if ($("#l2_3_1").is(":checked"))
    {
      valor11 = "1";
    }
    else
    {
      valor11 = "0";
    }
    var valor12 = $("#l2_3_2").val();
    var valor13 = $("#l2_3_3").val();
    var valor14 = $("#l2_3_4").val();
    var valor15 = $("#l2_3_5").val();
    // 4
    if ($("#l2_4_1").is(":checked"))
    {
      valor16 = "1";
    }
    else
    {
      valor16 = "0";
    }
    var valor17 = $("#l2_4_2").val();
    var valor18 = $("#l2_4_3").val();
    var valor19 = $("#l2_4_4").val();
    var valor20 = $("#l2_4_5").val();
    // 5
    if ($("#l2_5_1").is(":checked"))
    {
      valor21 = "1";
    }
    else
    {
      valor21 = "0";
    }
    var valor22 = $("#l2_5_2").val();
    var valor23 = $("#l2_5_3").val();
    var valor24 = $("#l2_5_4").val();
    var valor25 = $("#l2_5_5").val();
    // 6 
    if ($("#l2_6_1").is(":checked"))
    {
      valor26 = "1";
    }
    else
    {
      valor26 = "0";
    }
    var valor27 = $("#l2_6_2").val();
    var valor28 = $("#l2_6_3").val();
    var valor29 = $("#l2_6_4").val();
    var valor30 = $("#l2_6_5").val();
    // 7
    if ($("#l2_7_1").is(":checked"))
    {
      valor31 = "1";
    }
    else
    {
      valor31 = "0";
    }
    var valor32 = $("#l2_7_2").val();
    var valor33 = $("#l2_7_3").val();
    var valor34 = $("#l2_7_4").val();
    var valor35 = $("#l2_7_5").val();
    // 8
    if ($("#l2_8_1").is(":checked"))
    {
      valor36 = "1";
    }
    else
    {
      valor36 = "0";
    }
    var valor37 = $("#l2_8_2").val();
    var valor38 = $("#l2_8_3").val();
    var valor39 = $("#l2_8_4").val();
    var valor40 = $("#l2_8_5").val();
    // 9
    if ($("#l2_9_1").is(":checked"))
    {
      valor41 = "1";
    }
    else
    {
      valor41 = "0";
    }
    var valor42 = $("#l2_9_2").val();
    var valor43 = $("#l2_9_3").val();
    var valor44 = $("#l2_9_4").val();
    var valor45 = $("#l2_9_5").val();
    //  10
    if ($("#l2_10_1").is(":checked"))
    {
      valor46 = "1";
    }
    else
    {
      valor46 = "0";
    }
    var valor47 = $("#l2_10_2").val();
    var valor48 = $("#l2_10_3").val();
    var valor49 = $("#l2_10_4").val();
    var valor50 = $("#l2_10_5").val();
    // 11
    if ($("#l2_11_1").is(":checked"))
    {
      valor51 = "1";
    }
    else
    {
      valor51 = "0";
    }
    var valor52 = $("#l2_11_2").val();
    var valor53 = $("#l2_11_3").val();
    var valor54 = $("#l2_11_4").val();
    var valor55 = $("#l2_11_5").val();
    // 12
    if ($("#l2_12_1").is(":checked"))
    {
      valor56 = "1";
    }
    else
    {
      valor56 = "0";
    }
    var valor57 = $("#l2_12_2").val();
    var valor58 = $("#l2_12_3").val();
    var valor59 = $("#l2_12_4").val();
    var valor60 = $("#l2_12_5").val();
    //  13
    if ($("#l2_13_1").is(":checked"))
    {
      valor61 = "1";
    }
    else
    {
      valor61 = "0";
    }
    var valor62 = $("#l2_13_2").val();
    var valor63 = $("#l2_13_3").val();
    var valor64 = $("#l2_13_4").val();
    var valor65 = $("#l2_13_5").val();
    // 14
    if ($("#l2_14_1").is(":checked"))
    {
      valor66 = "1";
    }
    else
    {
      valor66 = "0";
    }
    var valor67 = $("#l2_14_2").val();
    var valor68 = $("#l2_14_3").val();
    var valor69 = $("#l2_14_4").val();
    var valor70 = $("#l2_14_5").val();
    // 15
    if ($("#l2_15_1").is(":checked"))
    {
      valor71 = "1";
    }
    else
    {
      valor71 = "0";
    }
    var valor72 = $("#l2_15_2").val();
    var valor73 = $("#l2_15_3").val();
    var valor74 = $("#l2_15_4").val();
    var valor75 = $("#l2_15_5").val();
    // 16
    if ($("#l2_16_1").is(":checked"))
    {
      valor76 = "1";
    }
    else
    {
      valor76 = "0";
    }
    var valor77 = $("#l2_16_2").val();
    var valor78 = $("#l2_16_3").val();
    var valor79 = $("#l2_16_4").val();
    var valor80 = $("#l2_16_5").val();
    // 17
    if ($("#l2_17_1").is(":checked"))
    {
      valor81 = "1";
    }
    else
    {
      valor81 = "0";
    }
    var valor82 = $("#l2_17_2").val();
    var valor83 = $("#l2_17_3").val();
    var valor84 = $("#l2_17_4").val();
    var valor85 = $("#l2_17_5").val();
    // 18
    if ($("#l2_18_1").is(":checked"))
    {
      valor86 = "1";
    }
    else
    {
      valor86 = "0";
    }
    var valor87 = $("#l2_18_2").val();
    var valor88 = $("#l2_18_3").val();
    var valor89 = $("#l2_18_4").val();
    var valor90 = $("#l2_18_5").val();
    // 19
    if ($("#l2_19_1").is(":checked"))
    {
      valor91 = "1";
    }
    else
    {
      valor91 = "0";
    }
    var valor92 = $("#l2_19_2").val();
    var valor93 = $("#l2_19_3").val();
    var valor94 = $("#l2_19_4").val();
    var valor95 = $("#l2_19_5").val();
    // 20
    if ($("#l2_20_1").is(":checked"))
    {
      valor96 = "1";
    }
    else
    {
      valor96 = "0";
    }
    var valor97 = $("#l2_20_2").val();
    var valor98 = $("#l2_20_3").val();
    var valor99 = $("#l2_20_4").val();
    var valor100 = $("#l2_20_5").val();
    // 21
    if ($("#l2_21_1").is(":checked"))
    {
      valor101 = "1";
    }
    else
    {
      valor101 = "0";
    }
    var valor102 = $("#l2_21_2").val();
    var valor103 = $("#l2_21_3").val();
    var valor104 = $("#l2_21_4").val();
    var valor105 = $("#l2_21_5").val();
    //  22
    if ($("#l2_22_1").is(":checked"))
    {
      valor106 = "1";
    }
    else
    {
      valor106 = "0";
    }
    var valor107 = $("#l2_22_2").val();
    var valor108 = $("#l2_22_3").val();
    var valor109 = $("#l2_22_4").val();
    var valor110 = $("#l2_22_5").val();
    // 23
    if ($("#l2_23_1").is(":checked"))
    {
      valor111 = "1";
    }
    else
    {
      valor111 = "0";
    }
    var valor112 = $("#l2_23_2").val();
    var valor113 = $("#l2_23_3").val();
    var valor114 = $("#l2_23_4").val();
    var valor115 = $("#l2_23_5").val();
    // 24
    if ($("#l2_24_1").is(":checked"))
    {
      valor116 = "1";
    }
    else
    {
      valor116="0";
    }
    var valor117 = $("#l2_24_2").val();
    var valor118 = $("#l2_24_3").val();
    var valor119 = $("#l2_24_4").val();
    var valor120 = $("#l2_24_5").val();
    // 25
    if ($("#l2_25_1").is(":checked"))
    {
      valor121 = "1";
    }
    else
    {
      valor121 = "0";
    }
    var valor122 = $("#l2_25_2").val();
    var valor123 = $("#l2_25_3").val();
    var valor124 = $("#l2_25_4").val();
    var valor125 = $("#l2_25_5").val();
    // 26
    if ($("#l2_26_1").is(":checked"))
    {
      valor126 = "1";
    }
    else
    {
      valor126 = "0";
    }
    var valor127 = $("#l2_26_2").val();
    var valor128 = $("#l2_26_3").val();
    var valor129 = $("#l2_26_4").val();
    var valor130 = $("#l2_26_5").val();
    // 27
    if ($("#l2_27_1").is(":checked"))
    {
      valor131 = "1";
    }
    else
    {
      valor131 = "0";
    }
    var valor132 = $("#l2_27_2").val();
    var valor133 = $("#l2_27_3").val();
    var valor134 = $("#l2_27_4").val();
    var valor135 = $("#l2_27_5").val();
    var lis_final = valor1+"|"+valor2+"|"+valor3+"|"+valor4+"|"+valor5+"|"+valor6+"|"+valor7+"|"+valor8+"|"+valor9+"|"+valor10+"|"+valor11+"|"+valor12+"|"+valor13+"|"+valor14+"|"+valor15+"|"+valor16+"|"+valor17+"|"+valor18+"|"+valor19+"|"+valor20+"|"+valor21+"|"+valor22+"|"+valor23+"|"+valor24+"|"+valor25+"|"+valor26+"|"+valor27+"|"+valor28+"|"+valor29+"|"+valor30+"|"+valor31+"|"+valor32+"|"+valor33+"|"+valor34+"|"+valor35+"|"+valor36+"|"+valor37+"|"+valor38+"|"+valor39+"|"+valor40+"|"+valor41+"|"+valor42+"|"+valor43+"|"+valor44+"|"+valor45+"|"+valor46+"|"+valor47+"|"+valor48+"|"+valor49+"|"+valor50+"|"+valor51+"|"+valor52+"|"+valor53+"|"+valor54+"|"+valor55+"|"+valor56+"|"+valor57+"|"+valor58+"|"+valor59+"|"+valor60+"|"+valor61+"|"+valor62+"|"+valor63+"|"+valor64+"|"+valor65+"|"+valor66+"|"+valor67+"|"+valor68+"|"+valor69+"|"+valor70+"|"+valor71+"|"+valor72+"|"+valor73+"|"+valor74+"|"+valor75+"|"+valor76+"|"+valor77+"|"+valor78+"|"+valor79+"|"+valor80+"|"+valor81+"|"+valor82+"|"+valor83+"|"+valor84+"|"+valor85+"|"+valor86+"|"+valor87+"|"+valor88+"|"+valor89+"|"+valor90+"|"+valor91+"|"+valor92+"|"+valor93+"|"+valor94+"|"+valor95+"|"+valor96+"|"+valor97+"|"+valor98+"|"+valor99+"|"+valor100+"|"+valor101+"|"+valor102+"|"+valor103+"|"+valor104+"|"+valor105+"|"+valor106+"|"+valor107+"|"+valor108+"|"+valor109+"|"+valor110+"|"+valor111+"|"+valor112+"|"+valor113+"|"+valor114+"|"+valor115+"|"+valor116+"|"+valor117+"|"+valor118+"|"+valor119+"|"+valor120+"|"+valor121+"|"+valor122+"|"+valor123+"|"+valor124+"|"+valor125+"|"+valor126+"|"+valor127+"|"+valor128+"|"+valor129+"|"+valor130+"|"+valor131+"|"+valor132+"|"+valor133+"|"+valor134+"|"+valor135+"|";
  }
  $("#lista").val(lis_final);
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_grab3.php",
    data:
    {
      conse: $("#numero").val(),
      ano: $("#ano").val(),
      lista: $("#lista").val(),
      directiva: $("#directiva").val()
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
        $("#actualizar").hide();
        if (directiva == "1")
        {
          for (i=1; i<=22; i++)
          {
            $("input:radio[name='l1_"+i+"_1']").hide();
            $("#l1_"+i+"_2").prop("disabled",true);
            $("#l1_"+i+"_3").prop("disabled",true);
            $("#l1_"+i+"_4").prop("disabled",true);
            $("#l1_"+i+"_5").prop("disabled",true);
          }
        }
        if (directiva == "2")
        {
          for (i=1; i<=27; i++)
          {
            $("input:radio[name='l2_"+i+"_1']").hide();
            $("#l2_"+i+"_2").prop("disabled",true);
            $("#l2_"+i+"_3").prop("disabled",true);
            $("#l2_"+i+"_4").prop("disabled",true);
            $("#l2_"+i+"_5").prop("disabled",true);
          }
        }
      }
    }
  });
}
</script>
</body>
</html>
<?php
}
?>