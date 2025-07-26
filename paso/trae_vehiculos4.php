<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$placa = $_POST['placa'];
	$query = "SELECT clase, marca, linea, modelo FROM cx_pla_tra WHERE placa='$placa'";
	$cur = odbc_exec($conexion, $query);
	$tipo = "1";
	$clase = odbc_result($cur,1);
	$pregunta5 = "SELECT nombre FROM cx_ctr_veh WHERE codigo='$clase'";
	$sql5 = odbc_exec($conexion, $pregunta5);
	$clase1 = trim(utf8_encode(odbc_result($sql5,1)));
	if ($clase == "1")
	{
		$tipo = "2";
	}
	$marca = trim(odbc_result($cur,2));
	$linea = trim(odbc_result($cur,3));
	$var_linea = explode(" ",$linea);
	$linea1 = $var_linea[0];
	$modelo = trim(odbc_result($cur,4));
	$salida = new stdClass();
	$salida->tipo = $clase;
	$salida->clase = $clase1;
	$salida->marca = $marca;
	$salida->linea = $linea;
	$salida->modelo = $modelo;
	// Trae mantenimientos por clase de vehiculo, marca y modelo
	if ($clase == "1")
	{
		$query1 = "SELECT codigo, nombre, marca, linea, modelo, valor, iva, total, medida, (SELECT SUBSTRING(nombre, 0, 50)) AS nombre1 FROM cx_ctr_man WHERE tipo='$tipo' AND marca='$marca' AND estado='' ORDER BY nombre1";
	}
	else
	{
		$query1 = "SELECT codigo, nombre, marca, linea, modelo, valor, iva, total, medida, (SELECT SUBSTRING(nombre, 0, 50)) AS nombre1 FROM cx_ctr_man WHERE tipo='$tipo' AND marca='$marca' AND linea LIKE '$linea1%' AND estado='' ORDER BY nombre1";
	}
	$cur1 = odbc_exec($conexion, $query1);
	$t_cur1 = odbc_num_rows($cur1);
	if ($t_cur1 > 0)
	{
		$i = 0;
		$datos = "";
		while($i<$row=odbc_fetch_array($cur1))
		{
			$codigo = odbc_result($cur1,1);
			$nombre = trim(utf8_encode($row['nombre']));
			$marca = trim(odbc_result($cur1,3));
			$linea = trim(odbc_result($cur1,4));
			$modelo = trim(odbc_result($cur1,5));
			$valor = odbc_result($cur1,6);
			$iva = odbc_result($cur1,7);
			$total = odbc_result($cur1,8);
			$medida = odbc_result($cur1,9);
			switch ($medida)
			{
				case '1':
					$medida1 = "UNIDAD";
					break;
				case '2':
					$medida1 = "JUEGO";
					break;
				case '3':
					$medida1 = "COPAS";
					break;
				default:
					$medida1 = "0";
					break;
			}
			$datos .= $codigo."|".$nombre."|".$marca."|".$linea."|".$modelo."|".$valor."|".$iva."|".$total."|".$medida1."|#";
			$i++;
		}
	}
	$salida->datos = $datos;
	echo json_encode($salida);
}
// 18/12/2023 - Inclusion medida en mantenimientos
// 08/02/2024 - Retiro consulta por modelo
// 23/02/2024 - Ajuste por creacion de tabla de configuracion de vehiculos
?>