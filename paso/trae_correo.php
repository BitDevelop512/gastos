<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
require('funciones.php');
if (is_ajax())
{
  $usuario = $_POST['usuario'];
  $query = "SELECT email FROM cx_usu_web WHERE usuario='$usuario'";
  $sql = odbc_exec($conexion, $query);
  $email = trim(odbc_result($sql,1));
  $salida = new stdClass();
  $salida->email = $email;
  echo json_encode($salida);
}
?>