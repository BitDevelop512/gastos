<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$clasificacion = $_POST['clasificacion'];
	$bien = $_POST['bien'];
	$bien1 = trim($_POST['bien1']);
	$bien1 = iconv("UTF-8", "ISO-8859-1", $bien1);
	$codigo = $_POST['codigo'];
	$descripcion = trim($_POST['descripcion']);
	$descripcion = iconv("UTF-8", "ISO-8859-1", $descripcion);
	$fecha = $_POST['fecha'];
	$marca = $_POST['marca'];
	$color = $_POST['color'];
	$modelo = $_POST['modelo'];
	$serial = $_POST['serial'];
	$soatn = $_POST['soatn'];
	$soata = $_POST['soata'];
	$soat1 = $_POST['soat1'];
	$soat2 = $_POST['soat2'];
	$seguc = $_POST['seguc'];
	$valos = $_POST['valos'];
	$valot = $_POST['valot'];
	$segua = $_POST['segua'];
	$segu1 = $_POST['segu1'];
	$segu2 = $_POST['segu2'];
	$unidades = $_POST['unidades'];
	$funcionario = trim($_POST['funcionario']);
	$funcionario = iconv("UTF-8", "ISO-8859-1", $funcionario);
	$ordop = trim($_POST['ordop']);
	$ordop = iconv("UTF-8", "ISO-8859-1", $ordop);
	$mision  = trim($_POST['mision']);
	$mision = iconv("UTF-8", "ISO-8859-1", $mision);
	$estado = $_POST['estado'];
	$actualiza = "UPDATE cx_pla_bie SET clase='$bien', nombre='$bien1', descripcion='$descripcion', fec_com='$fecha', marca='$marca', color='$color', modelo='$modelo', serial='$serial', soa_num='$soatn', soa_ase='$soata', soa_fe1='$soat1', soa_fe2='$soat2', seg_cla='$seguc', seg_val='$valot', seg_num='$segun', seg_ase='$segua', seg_fe1='$segu1', seg_fe2='$segu2', unidad='$unidades', funcionario='$funcionario', ordop='$ordop', mision='$mision', estado='$estado' WHERE conse='$conse' AND codigo='$codigo'";
	if (!odbc_exec($conexion, $actualiza))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_plan_bie1.txt", "a");
	fwrite($file, $fec_log." # ".$actualiza." # ".PHP_EOL);
	fclose($file);
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>