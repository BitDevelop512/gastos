<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if ($_SESSION["autenticado"] = "SI")
{
  if (is_ajax())
  {
    if ($sup_usuario == "1")
    {
      $tipo = $_POST['tipo'];
      $texto = trim($_POST['texto']);
      if ($tipo == "1")
      {
        $datos = encrypt1($texto, $llave);
      }
      else
      {
        $datos = decrypt1($texto, $llave);
        $datos = trim(utf8_encode($datos));
      }
      $datos = iconv("UTF-8", "ISO-8859-1", $datos);
      $salida->salida = $datos;
      echo json_encode($salida);
    }
  }
}
?>