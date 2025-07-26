<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
$usuario = trim($_POST['usuario']);
// Si no es peticion ajax no se ejecuta
if (is_ajax())
{
  // Se consulta si el usuario existe en la base de datos
  $query = "SELECT * FROM cx_usu_web WHERE usuario='$usuario'";
  $sql = odbc_exec($conexion,$query);
  $total = odbc_num_rows($sql);
  // Si el usuario existe en la base de datos
  if ($total>0)
  {
    $salida->salida = "1";
  }
  else
  {
    $salida->salida = "0";
  }
  echo json_encode($salida);
}
?>