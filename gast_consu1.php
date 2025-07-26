<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $carpeta1 = $ruta_local."\\tmp";
  $v_ano = date('Y');
  $v_ano = trim($v_ano);
  $v_mes = date('m');
  $v_mes = trim($v_mes);
  $v_dia = date('d');
  $v_dia = trim($v_dia);
  $carpeta1 .= "\\".$v_ano.$v_mes.$v_dia;
  if(!file_exists($carpeta1))
  {
    mkdir ($carpeta1);
  }
  $conse = $_POST['conse'];
  $ano = $_POST['ano'];
  $periodo = $_POST['periodo'];
  $unidad = $_POST['unidad'];
  unlink($carpeta1."\\"."log_plani".$conse."_".$ano."_".$periodo."_".$unidad.".txt");
  $pregunta = "SELECT * FROM cx_gas_bas WHERE conse='$conse' AND ano='$ano' AND periodo='$periodo' AND unidad='$unidad'";
  $sql = odbc_exec($conexion,$pregunta);
  $row = odbc_fetch_array($sql);
  $conse = odbc_result($sql,1);
  $fecha = odbc_result($sql,2);
  $usuario = trim(odbc_result($sql,3));
  $unidad = odbc_result($sql,4);
  $ciudad = trim(utf8_encode(odbc_result($sql,5)));
  $ordop = trim(utf8_encode(odbc_result($sql,6)));
  $n_ordop = trim(utf8_encode(odbc_result($sql,7)));
  $mision = trim(utf8_encode(odbc_result($sql,8)));
  $periodo = odbc_result($sql,9);
  $ano = odbc_result($sql,10);
  $total = trim(odbc_result($sql,11));
  $responsable = trim(utf8_encode(odbc_result($sql,12)));
  $tarifa1 = odbc_result($sql,13);
  $tarifa2 = odbc_result($sql,14);
  $tarifa3 = odbc_result($sql,15);
  $interno = odbc_result($sql,16);
  $numero = odbc_result($sql,17);
  $solicitud = odbc_result($sql,18);
  $elaboro = trim(utf8_encode(odbc_result($sql,19)));
  $adicional = trim(utf8_encode(odbc_result($sql,20)));
  $query = "INSERT INTO cx_gas_bas (conse, fecha, usuario, unidad, ciudad, ordop, n_ordop, mision, periodo, ano, total, responsable, tarifa1, tarifa2, tarifa3, interno, numero, solicitud, elaboro, adicional) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$ciudad', '$ordop', '$n_ordop', '$mision', '$periodo', '$ano', '$total', '$responsable', '$tarifa1', '$tarifa2', '$tarifa3', '$interno', '$numero', '$solicitud', '$elaboro', '$adicional')";
  $file = fopen($carpeta1."\\"."log_plani".$conse."_".$ano."_".$periodo."_".$unidad.".txt", "a");
  fwrite($file, $query.PHP_EOL);
  fclose($file);

  $pregunta1 = "SELECT * FROM cx_gas_dis WHERE conse1='$conse' AND interno='$interno'";
  $sql1 = odbc_exec($conexion,$pregunta1);
  $i=1;
  while($i<$row=odbc_fetch_array($sql1))
  {
    $conse0 = odbc_result($sql1,1);
    $conse1 = odbc_result($sql1,2);
    $cedula = trim(utf8_encode(odbc_result($sql1,3)));
    $nombre = trim(utf8_encode(odbc_result($sql1,4)));
    $ciudad = trim(utf8_encode(odbc_result($sql1,5)));
    $v1 = odbc_result($sql1,6);
    $v2 = odbc_result($sql1,7);
    $v3 = odbc_result($sql1,8);
    $valor = trim(odbc_result($sql1,9));
    $valor1 = odbc_result($sql1,10);
    $v4 = odbc_result($sql1,11);
    $interno = odbc_result($sql1,12);
    $query = "INSERT INTO cx_gas_dis (conse, conse1, cedula, nombre, ciudad, v1, v2, v3, valor, valor1, v4, interno) VALUES ('$conse0', '$conse1', '$cedula', '$nombre', '$ciudad', '$v1', '$v2', '$v3', '$valor', '$valor1', '$v4', '$interno')";
    $file = fopen($carpeta1."\\"."log_plani".$conse."_".$ano."_".$periodo."_".$unidad.".txt", "a");
    fwrite($file, $query.PHP_EOL);
    fclose($file);
  }
  $salida = new stdClass();
  $salida->conse = $conse;
  echo json_encode($salida);
}
?>