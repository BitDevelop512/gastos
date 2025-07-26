<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
  $tipo = $_POST['tipo'];
  if ($tipo == "0")
  {
    $pregunta = "SELECT * FROM cx_ctr_nor ORDER BY nombre";
  }
  else
  {
    $nombre = $_POST['nombre'];
    $nombre1 = utf8_decode($nombre);
    $pregunta = "SELECT * FROM cx_ctr_nor WHERE nombre LIKE '%$nombre1%' ORDER BY nombre";
  }
  $sql = odbc_exec($conexion,$pregunta);
  $total = odbc_num_rows($sql);
  $salida = new stdClass();
  if ($total>0)
  {
    $i = 0;
    while ($i < $row = odbc_fetch_array($sql))
    {
      $tipo = trim($row["tipo"]);
      $descarga = $row['descarga'];
      $salida->rows[$i]['conse'] = $row['conse'];
      $salida->rows[$i]['nombre'] = trim(utf8_encode($row["nombre"]));
      $salida->rows[$i]['nombre1'] = trim(utf8_encode($row["nombre1"]));
      $salida->rows[$i]['descarga'] = $descarga;
      $salida->rows[$i]['tipo'] = $tipo;
      switch ($tipo)
      {
        case '1':
          $tipo1 = "LEYES";
          break;
        case '2':
          $tipo1 = "DECRETOS";
          break;
        case '3':
          $tipo1 = "RESOLUCIONES";
          break;
        case '4':
          $tipo1 = "MANUALES";
          break;
        case '5':
          $tipo1 = "DIRECTIVAS";
          break;
        case '6':
          $tipo1 = "PLANES";
          break;
        case '7':
          $tipo1 = "CIRCULARES";
          break;
        case '8':
          $tipo1 = "BOLETINES INSTRUCTIVOS";
          break;
        case '9':
          $tipo1 = "OTRAS COMUNICACIONES";
          break;
        case '0':
          $tipo1 = "DESACTIVADO";
          break;
        default:
          $tipo1 = "SIN ESPECIFICACIÓN";
          break;
      }
      $salida->rows[$i]['tipo1'] = $tipo1;
      if ($descarga == "1")
      {
        $descarga1 = "SI";
      }
      else
      {
        $descarga1 = "NO";
      }
      $salida->rows[$i]['descarga1'] = $descarga1;
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
  echo json_encode($salida);
}
?>