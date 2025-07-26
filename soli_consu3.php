<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $tipo = $_POST['tipo'];
  $conse = $_POST['conse'];
  $unidad = $_POST['unidad'];
  $sigla = $_POST['sigla'];
  $ano = $_POST['ano'];
  switch ($tipo)
  {
    case '1':
      $contador = 0;
      $archivos = "";     
      $carpeta = $ruta_local."\\archivos\\server\\php\\anexos\\".$ano."\\".$conse;
      if(!file_exists($carpeta))
      {
        mkdir ($carpeta);
      }
      $dir = opendir ($carpeta);
      $j = 1;
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
            $archivos .= $file."|";
            $contador ++;
          }
        }
      }
      break;
    case '2':
      $pregunta = "SELECT *, 0 AS tipo FROM cx_gas_bas WHERE unidad='$unidad' AND ano='$ano' AND solicitud='$conse'";
      break;
    case '3':
      $pregunta = "SELECT *, 0 AS interno FROM cx_rel_gas WHERE unidad='$unidad' AND ano='$ano' AND consecu='$conse'";
      break;
    case '4':
      $pregunta = "SELECT *, 0 AS interno, egreso AS conse FROM cx_com_egr WHERE autoriza='2' AND ano='$ano' AND num_auto='$conse'";
      break;
    default:
      break;
  }
  if ($tipo == "1")
  {
    $salida->salida = $archivos;
    $salida->total = $contador;
  }
  else
  {
    $pregunta .= " ORDER BY fecha DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
      $i = 0;
      while ($i < $row = odbc_fetch_array($sql))
      {
        if ($tipo == "4")
        {
          $valor = $row['total'];
          $valor = floatval($valor);
          $valor = number_format($valor,2);
        }
        else
        {
          $valor = trim($row['total']);
        }
        $salida->rows[$i]['conse'] = $row['conse'];
        $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
        $salida->rows[$i]['total'] = $valor;
        $salida->rows[$i]['interno'] = $row['interno'];
        $salida->rows[$i]['periodo'] = $row['periodo'];
        $salida->rows[$i]['tipo'] = $row['tipo'];
        $salida->rows[$i]['unidad'] = $row['unidad'];
        $i++;
      }
      $salida->salida = "1";
      $salida->total = $total;
    }
    else
    {
      $salida->salida = "0";
      $salida->total = "0";
    }
  }
  echo json_encode($salida);
}
// 28/08/2024 - Ajuste inclusion tree
?>