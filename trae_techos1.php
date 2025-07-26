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
	$placa = $_POST['placa'];
	$clase = $_POST['clase'];
	$valor1 = "0.00";
	$valor2 = "0";
	// Tipo de empadronamiento del vehculo
	$query = "SELECT empadrona, tipo FROM cx_pla_tra WHERE placa='$placa'";
	$cur = odbc_exec($conexion, $query);
	$empadrona = odbc_result($cur,1);
	$combu = odbc_result($cur,2);
	if ($tipo == "C")
	{
		$combu = $combu;
	}
	else
	{
		$combu = "0";
	}
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
		$v2 = $num_valores[6];
		$v3 = $num_valores[7];
		$v4 = $num_valores[8];
		$v5 = $num_valores[9];
		$v6 = $num_valores[10];
		if ($clase == $v1)
		{
			if ($empadrona == "1")
			{
				if ($combu == $v6)
				{
					$valor1 = $v2;
					$valor2 = $v3;
				}
			}
			else
			{
				if ($combu == $v6)
				{
					$valor1 = $v4;
					$valor2 = $v5;
				}
			}
		}
	}
	$salida = new stdClass();
	$salida->valor1 = $valor1;
	$salida->valor2 = $valor2;
	echo json_encode($salida);
}
// 13/02/2024 - Ajuste consulta techos
// 05/03/2024 - Ajuste techos inclusion tipo de combustible
// 10/01/2025 - Ajuste consulta techos del año
?>