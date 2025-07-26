<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $v1 = $_POST['v1'];
  $v2 = $_POST['v2'];
  $v3 = $_POST['v3'];
  $v4 = $_POST['v4'];
  $v5 = "";
  switch ($v4)
  {
    case 'C':
      $pregunta = "SELECT alea FROM cx_tra_moc WHERE conse='$v1' AND fecha='$v2' AND placa='$v3'";
      $v5 = "bonos";
      break;
    case 'M':
      $pregunta = "SELECT alea FROM cx_tra_man WHERE conse='$v1' AND fecha='$v2' AND placa='$v3'";
      $v5 = "contratom";
      break;
    case 'L':
      $pregunta = "SELECT alea FROM cx_tra_lla WHERE conse='$v1' AND fecha='$v2' AND placa='$v3'";
      $v5 = "contratol";
      break;
    case 'T':
      $pregunta = "SELECT alea FROM cx_tra_rtm WHERE conse='$v1' AND fecha='$v2' AND placa='$v3'";
      $v5 = "contrator";
      break;
    default:
      break;
  }
  $sql = odbc_exec($conexion,$pregunta);
  $total = odbc_num_rows($sql);
  $salida = new stdClass();
  if ($total>0)
  {
    $alea = odbc_result($sql,1);
    $ruta_local1 = $ruta_local."\\upload";
    $carpeta0 = $ruta_local1;
    if(!file_exists($carpeta0))
    {
      mkdir ($carpeta0);
    }
    $carpeta1 = $carpeta0."\\".$v5;
    if(!file_exists($carpeta1))
    {
      mkdir ($carpeta1);
    }
    $carpeta2 = $carpeta1."\\".$v3;
    if(!file_exists($carpeta2))
    {
      mkdir ($carpeta2);
    }
    $carpeta3 = $carpeta2."\\".$v2;
    if(!file_exists($carpeta3))
    {
      mkdir ($carpeta3);
    }
    $carpeta4 = $carpeta3."\\".$alea;
    if(!file_exists($carpeta4))
    {
      mkdir ($carpeta4);
    }
    switch ($v4)
    {
      case 'C':
        $carpeta = $ruta_local."\\upload\\bonos\\".$v3."\\".$v2."\\".$alea;
        break;
      case 'M':
        $carpeta = $ruta_local."\\upload\\contratom\\".$v3."\\".$v2."\\".$alea;
        break;
      case 'L':
        $carpeta = $ruta_local."\\upload\\contratol\\".$v3."\\".$v2."\\".$alea;
        break;
      case 'T':
        $carpeta = $ruta_local."\\upload\\contrator\\".$v3."\\".$v2."\\".$alea;
        break;
      default:
        break;
    }
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
    $salida->salida = $alea;
    $salida->archivo = $primero;
  }
  else
  {
    $salida->salida = "0";
    $salida->archivo = "";
  }
  echo json_encode($salida);
}
?>