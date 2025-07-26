<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
// Si no es peticion ajax no se ejecuta
if (is_ajax())
{
  if (($cargar == "0") or ($cargar == "1"))
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
  }
  else
  {
    $confirma = "2";
  }
  $salida = new stdClass();
  $salida->salida = $confirma;
  echo json_encode($salida);
}
// 09/11/2023 - Ajuste activacion usuario
// 03/03/2025 - Ajuste bloqueo activacion usuario desde sigar.imi.mil.co
// 02/04/2025 - Ajuste activacion usuario desde sigar.imi.mil.co
?>