<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $alea = $_POST['alea'];
  $unidad = $_POST['unidad'];
  $ruta_local1 = $ruta_local."\\upload\\bienes";
  $carpeta1 = $ruta_local1;
  if(!file_exists($carpeta1))
  {
    mkdir ($carpeta1);
  }
  $carpeta2 = $carpeta1."\\".$unidad;
  if(!file_exists($carpeta2))
  {
    mkdir ($carpeta2);
  }
  $carpeta3 = $carpeta2."\\".$alea;
  if(!file_exists($carpeta3))
  {
    mkdir ($carpeta3);
  }
  $carpeta = $ruta_local."\\upload\\bienes\\".$unidad."\\".$alea;
  $dir = opendir ($carpeta);
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
  echo json_encode($salida);
}
// 15/08/2024 - Ajuste carga facturas de bienes
?>