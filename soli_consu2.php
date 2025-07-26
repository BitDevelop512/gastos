<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $tipo = $_POST['tipo'];
  if ($tipo == "3")
  {
    $complemento = "tipo IN (1,2)";
  }
  else
  {
    $complemento = "tipo='$tipo'";
  }
  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];
  $pregunta = "SELECT *, (SELECT sigla FROM cv_unidades WHERE subdependencia=cx_pla_inv.unidad) AS sigla FROM cx_pla_inv WHERE unidad!='999' AND ".$complemento;
  if (!empty($_POST['fecha1']))
  {
    $pregunta .= " AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1)";
  }
  $pregunta .= " ORDER BY fecha DESC";
  $sql = odbc_exec($conexion,$pregunta);
  $total = odbc_num_rows($sql);
  $salida = new stdClass();
  if ($total>0)
  {
    $i = 0;
    while ($i < $row = odbc_fetch_array($sql))
    {
      $tipo = $row['tipo'];
      if ($tipo == "1")
      {
        $n_tipo = "Plan de Inversión";
      }
      else
      {
        $n_tipo = "Solicitud de Recursos";
      }
      $salida->rows[$i]['conse'] = $row['conse'];
      $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
      $salida->rows[$i]['usuario'] = trim($row['usuario']);
      $salida->rows[$i]['unidad'] = $row['unidad'];
      $salida->rows[$i]['tipo'] = $n_tipo;
      $salida->rows[$i]['tipo1'] = $tipo;
      $salida->rows[$i]['estado'] = trim($row['estado']);
      $salida->rows[$i]['periodo'] = $row['periodo'];
      $salida->rows[$i]['ano'] = $row['ano'];
      $salida->rows[$i]['sigla'] = trim($row['sigla']);
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
// 27/08/2024 - Ajuste inclusion tooltip
?>