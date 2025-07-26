<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
ini_set('memory_limit', '10240M');
ini_set('max_execution_time', 3600);
if ($_SESSION["autenticado"] = "SI")
{
  if (is_ajax())
  {
    if ($sup_usuario == "1")
    {
      $inactividad = $_POST['inactividad'];
      $dias = $_POST['dias'];
      $usuario = trim($_POST['usuario']);
      $clave = trim($_POST['clave']);
      $servidor = trim($_POST['servidor']);
      $puerto = $_POST['puerto'];
      $ruta = $_POST['ruta'];
      $url = $_POST['url'];
      $combustible = $_POST['combustible'];
      $bonos = $_POST['bonos'];
      $formatos = $_POST['formatos'];
      $autoriza = $_POST['autoriza'];
      $pregunta = "UPDATE cx_ctr_par SET inactividad='$inactividad', usuario='$usuario', clave='$clave', servidor='$servidor', puerto='$puerto', dias='$dias', ruta='$ruta', url='$url', combustible='$combustible', bonos='$bonos', formatos='$formatos', autoriza='$autoriza'";
      if (!odbc_exec($conexion, $pregunta))
      {
        $confirma = "0";
      }
      else
      {
        $confirma = "1";
      }
      $salida->salida = $confirma;
      echo json_encode($salida);
    }
  }
}
?>