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
  unlink($carpeta1."\\"."log_rela".$conse."_".$ano."_".$periodo."_".$unidad.".txt");
  $pregunta = "SELECT * FROM cx_rel_gas WHERE conse='$conse' AND ano='$ano' AND periodo='$periodo' AND unidad='$unidad'";
  $sql = odbc_exec($conexion,$pregunta);
  $row = odbc_fetch_array($sql);
  $conse = odbc_result($sql,1);
  $fecha = odbc_result($sql,2);
  $usuario = trim(odbc_result($sql,3));
  $unidad = odbc_result($sql,4);
  $ciudad = trim(utf8_encode(odbc_result($sql,5)));
  $comprobante = trim(odbc_result($sql,6));
  $ordop = trim(utf8_encode(odbc_result($sql,7)));
  $n_ordop = trim(utf8_encode(odbc_result($sql,8)));
  $mision = trim(utf8_encode(odbc_result($sql,9)));
  $periodo = odbc_result($sql,10);
  $ano = odbc_result($sql,11);
  $total = trim(odbc_result($sql,12));
  $csoporte = trim(odbc_result($sql,13));
  $ssoporte = trim(odbc_result($sql,14));
  $responsable = trim(utf8_encode(odbc_result($sql,15)));
  $tipo = odbc_result($sql,16);
  $numero = odbc_result($sql,17);
  $consecu = odbc_result($sql,18);
  $comandante = trim(utf8_encode(odbc_result($sql,19)));
  $elaboro = trim(utf8_encode(odbc_result($sql,20)));
  $reintegro = trim(odbc_result($sql,21));
  $contador = odbc_result($sql,22);
  $comprobantes = trim(odbc_result($sql,23));
  $numeros = trim(odbc_result($sql,24));
  $consecus = trim(odbc_result($sql,25));
  $reviso = trim(utf8_encode(odbc_result($sql,26)));
  $reviso1 = trim(utf8_encode(odbc_result($sql,27)));
  $query = "INSERT INTO cx_rel_gas (conse, fecha, usuario, unidad, ciudad, comprobante, ordop, n_ordop, mision, periodo, ano, total, csoporte, ssoporte, responsable, tipo, numero, consecu, comandante, elaboro, reintegro, contador, comprobantes, numeros, consecus, reviso, reviso1) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$ciudad', '$comprobante', '$ordop', '$n_ordop', '$mision', '$periodo', '$ano', '$total', '$csoporte', '$ssoporte', '$responsable', '$tipo', '$numero', '$consecu', '$comandante', '$elaboro', '$reintegro', '$contador', '$comprobantes', '$numeros', '$consecus', '$reviso', '$reviso1')";
  $file = fopen($carpeta1."\\"."log_rela".$conse."_".$ano."_".$periodo."_".$unidad.".txt", "a");
  fwrite($file, $query.PHP_EOL);
  fclose($file);

  $pregunta1 = "SELECT * FROM cx_rel_dis WHERE conse1='$conse' AND ano='$ano' AND consecu='$consecu'";
  $sql1 = odbc_exec($conexion,$pregunta1);
  $i=1;
  while($i<$row=odbc_fetch_array($sql1))
  {
    $conse0 = odbc_result($sql1,1);
    $conse1 = odbc_result($sql1,2);
    $gasto = odbc_result($sql1,3);
    $valor = trim(odbc_result($sql1,4));
    $valor1 = trim(odbc_result($sql1,5));
    $tipo = trim(odbc_result($sql1,6));
    $consecu = odbc_result($sql1,7);
    $tipo1 = odbc_result($sql1,8);
    $ano = odbc_result($sql1,9);
    $datos = trim(utf8_encode($row["datos"]));
    $query = "INSERT INTO cx_rel_dis (conse, conse1, gasto, valor, valor1, tipo, consecu, tipo1, ano, datos) VALUES ('$conse0', '$conse1', '$gasto', '$valor', '$valor1', '$tipo', '$consecu', '$tipo1', '$ano', '$datos')";
    $file = fopen($carpeta1."\\"."log_rela".$conse."_".$ano."_".$periodo."_".$unidad.".txt", "a");
    fwrite($file, $query.PHP_EOL);
    fclose($file);
  }
  $salida = new stdClass();
  $salida->conse = $conse;
  echo json_encode($salida);
}
?>