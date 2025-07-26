<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$ano = $_POST['ano'];
	$tipo = $_POST['tipo'];
	$valor = $_POST['valor'];
	$valor1 = str_replace(',','',$valor);
	$valor1 = floatval($valor1);
	$query = "UPDATE cx_reg_rec SET valor='$valor', valor1='$valor1' WHERE conse='$conse' AND ano='$ano' AND tipo='$tipo'";
	if (!odbc_exec($conexion, $query))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_recompensa_valor.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
// 04/01/2023 - Ajuste modificacion valor en 0
?>