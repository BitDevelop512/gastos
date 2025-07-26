<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $v1 = $_POST['v1'];
  $v2 = $_POST['v2'];
  $v3 = $_POST['v3'];
  $v4 = $_POST['v4'];
  switch ($v4)
  {
    case 'C':
      $pregunta = "SELECT kilometraje, valores, total, total1, contrato, contrato1, alea, conse FROM cx_tra_moc WHERE conse='$v1' AND fecha='$v2' AND placa='$v3'";
      break;
    case 'M':
      $pregunta = "SELECT kilometraje, valores, total, total1, contrato, contrato1, alea, conse FROM cx_tra_man WHERE conse='$v1' AND fecha='$v2' AND placa='$v3'";
      break;
    case 'L':
      $pregunta = "SELECT kilometraje, valores, total, total1, contrato, contrato1, alea, conse FROM cx_tra_lla WHERE conse='$v1' AND fecha='$v2' AND placa='$v3'";
      break;
    case 'T':
      $pregunta = "SELECT kilometraje, valores, total, total1, contrato, contrato1, alea, conse FROM cx_tra_rtm WHERE conse='$v1' AND fecha='$v2' AND placa='$v3'";
      break;
    default:
      break;
  }
  $sql = odbc_exec($conexion,$pregunta);
  $row = odbc_fetch_array($sql);
  $salida = new stdClass();
  $kilometraje = odbc_result($sql,1);
  if ($kilometraje == ".00")
  {
    $kilometraje = "0.00";
  }
  $kilometraje = floatval($kilometraje);
  $valores = trim(utf8_encode($row["valores"]));
  $total = trim(odbc_result($sql,3));
  $total1 = odbc_result($sql,4);
  $contrato = odbc_result($sql,5);
  $contrato1 = trim(odbc_result($sql,6));
  $alea = trim(odbc_result($sql,7));
  $interno = odbc_result($sql,8);
  $salida->kilometraje = $kilometraje;
  $salida->valores = $valores;
  $salida->total = $total;
  $salida->total1 = $total1;
  $salida->contrato = $contrato;
  $salida->contrato1 = $contrato1;
  $salida->alea = $alea;
  $salida->interno = $interno;
  echo json_encode($salida);
}
// 03/01/2024 - Ajuste modificación grabacion de mantenimientos
?>