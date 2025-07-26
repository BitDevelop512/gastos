<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
require('funciones.php');
if (is_ajax())
{
  $query = "SELECT imagen FROM cx_usu_web WHERE conse='$con_usuario' AND usuario='$usu_usuario'";
  $sql = odbc_exec($conexion, $query);
  $total = odbc_num_rows($sql);
  $total = intval($total);
  if ($total > 0)
  {
    $firma = trim(odbc_result($sql,1));
    $firma = str_replace('"', '»', $firma);
    $firma = str_replace('<', 'º', $firma);
    $firma = str_replace('>', '«', $firma);
  }
  else
  {
    $firma = "";
  }
  $salida->total = $total;
  $salida->firma = $firma;
  echo json_encode($salida);
}
?>