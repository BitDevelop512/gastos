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
	// Trae llantas por clase de vehiculo y marca
	$query1 = "SELECT codigo, descripcion, valor, iva, total, (SELECT SUBSTRING(descripcion, 0, 50)) AS descripcion1 FROM cx_ctr_rtm WHERE tipo='$tipo' AND estado='' ORDER BY descripcion1";
	$cur1 = odbc_exec($conexion, $query1);
	$t_cur1 = odbc_num_rows($cur1);
	if ($t_cur1 > 0)
	{
		$i = 0;
		$datos = "";
		while($i<$row=odbc_fetch_array($cur1))
		{
			$codigo = odbc_result($cur1,1);
			$descripcion = trim(utf8_encode($row['descripcion']));
			$valor = odbc_result($cur1,3);
			$iva = odbc_result($cur1,4);
			$total = odbc_result($cur1,5);
			$datos .= $codigo."|".$descripcion."|".$valor."|".$iva."|".$total."|#";
			$i++;
		}
	}
	$salida->datos = $datos;
	echo json_encode($salida);
}
// 20/12/2023 - RTM x contratos
// 23/02/2024 - Ajuste por creacion de tabla de configuracion de vehiculos
?>