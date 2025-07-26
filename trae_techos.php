<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
	$tipo = $_POST['tipo'];
	$clase = $_POST['clase'];
	$placa = $_POST['placa'];
	$valid = explode(",", $placa);
	$combu = $valid[1];
	if ($tipo == "C")
	{
		$combu = $combu;
	}
	else
	{
		$combu = "0";
	}
	$valor1 = "0.00";
	$valor2 = "0";
	// Techo de vehiculos
	$query1 = "SELECT datos FROM cx_tra_ted WHERE unidad='$nun_usuario' AND dependencia='$dun_usuario' AND tipo='$tipo' AND estado='' AND ano='$ano'";
	$cur1 = odbc_exec($conexion, $query1);
	$total = odbc_num_rows($cur1);
	if ($total == "0")
	{
		$query1 = "SELECT datos FROM cx_tra_ted WHERE unidad='$nun_usuario' AND tipo='$tipo' AND estado='' AND ano='$ano'";
		$cur1 = odbc_exec($conexion, $query1);
	}
	$row1 = odbc_fetch_array($cur1);
	$datos = trim(utf8_encode($row1['datos']));
	$num_datos = explode("|",$datos);
	for ($j=0;$j<count($num_datos)-1;++$j)
	{
		$paso = $num_datos[$j];
		$num_valores = explode("»",$paso);
		$v1 = $num_valores[0];
		$v2 = $num_valores[1];
		$v3 = $num_valores[2];
		$v4 = $num_valores[10];
		if ($clase == $v1)
		{
			if ($combu == $v4)
			{	
				$valor1 = $v2;
				$valor2 = $v3;
			}
		}
	}
	$salida = new stdClass();
	$salida->valor1 = $valor1;
	$salida->valor2 = $valor2;
	echo json_encode($salida);
}
// 13/02/2024 - Ajuste consulta techos
// 01/03/2024 - Ajuste techos inclusion tipo de combustible
// 10/01/2025 - Ajuste consulta techos del año
?>