<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $alea = trim($_POST['alea']);
  $unidad = trim($_POST['unidad']);
  $ruta_local1 = $ruta_local."\\upload\\bienes\\".$unidad;
  $carpeta = $ruta_local1;
  if(!file_exists($carpeta))
  {
    mkdir ($carpeta);
  }
  $carpeta1 = $ruta_local1."\\".$alea;
  if(!file_exists($carpeta1))
  {
    mkdir ($carpeta1);
  }
  $dir = opendir ($carpeta1);
  $i = 1;
  while (false !== ($file = readdir($dir)))
  {
    if (($file == '.') or ($file == '..'))
    {
    }
    else
    {
      $num_archivo = explode(".", $file);
      $extension = count($num_archivo);
      $extension = intval($extension);
      if ($extension == "1")
      {
      }
      else
      {
        $primero = $file;
      }
    }
    $i++;
  }
  $salida->archivo = $primero;
}
echo json_encode($salida);
?>