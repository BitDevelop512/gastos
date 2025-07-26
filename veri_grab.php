<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $periodo = $_POST['periodo'];
  $ano = $_POST['ano'];
  $query = "SELECT count(1) as total FROM cx_pla_cen WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
  $cur = odbc_exec($conexion, $query);
  $conse = odbc_result($cur,1);
  $salida->salida = $conse;
  echo json_encode($salida);
}
?>