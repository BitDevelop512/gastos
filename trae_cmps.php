<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$unidad = $_POST['unidad'];
	$query = "SELECT DISTINCT compania FROM cx_pla_tra WHERE unidad='$unidad' ORDER BY compania";
  $sql = odbc_exec($conexion, $query);
	$total = odbc_num_rows($sql);
  $compas = "";
	if ($total>0)
	{
	  while($i<$row=odbc_fetch_array($sql))
	  {
	    $compas .= trim(odbc_result($sql,1))."#";
	    $i++;
	  }
	  $compas = substr($compas,0,-1);
	}
	$salida->salida = $compas;
  echo json_encode($salida);
}
// 09/08/2024 - Ajuste consulta compañias de unidad seleccionada
?>