<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
// Si no es peticion ajax no se ejecuta
if (is_ajax())
{
  $usuario = trim($_POST['usuario']);
  $query = "UPDATE cx_usu_web SET activo='0' WHERE usuario='$usuario'";
  if (!odbc_exec($conexion, $query))
  {
    $confirma = "0";
  }
  else
  {
    $confirma = "1";
  }
  $salida = new stdClass();
  $salida->salida = $confirma;
  echo json_encode($salida);
}
// 09/11/2023 - Activacion usuario
?>