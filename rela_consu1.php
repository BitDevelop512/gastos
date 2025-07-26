<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $gasto = $_POST['gasto'];
  $placa = $_POST['placa'];
  $alea = $_POST['alea'];
  $unidad = $_POST['unidad'];
  switch ($gasto)
  {
    case '36':
    case '42':
      $gasto1 = "combustible";
      break;
    case '38':
    case '44':
      $gasto1 = "mantenimiento";
      break;
    case '39':
    case '45':
      $gasto1 = "rtm";
      break;
    case '40':
    case '46':
      $gasto1 = "llantas";
      break;
    default:
      $gasto1 = "";
      break;
  }
  $ruta_local1 = $ruta_local."\\upload\\".$gasto1;
  $carpeta1 = $ruta_local1;
  if(!file_exists($carpeta1))
  {
    mkdir ($carpeta1);
  }
  $carpeta2 = $carpeta1."\\".$placa;
  if(!file_exists($carpeta2))
  {
    mkdir ($carpeta2);
  }
  $carpeta3 = $carpeta2."\\".$unidad;
  if(!file_exists($carpeta3))
  {
    mkdir ($carpeta3);
  }
  $carpeta4 = $carpeta3."\\".$alea;
  if(!file_exists($carpeta4))
  {
    mkdir ($carpeta4);
  }
  $carpeta = $ruta_local."\\upload\\".$gasto1."\\".$placa."\\".$unidad."\\".$alea;
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
  $salida->carpeta = $gasto1;
  $salida->archivo = $primero;
  echo json_encode($salida);
}
// 03/10/2024 - Ajuste partidas adicionales
?>