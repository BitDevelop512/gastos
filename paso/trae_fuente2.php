<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$fuente = $_POST['fuente'];
	$fuente = trim($fuente);
	$sin_fuen = "";
	$uti_fuen = "";
	$query = "SELECT * FROM cx_pla_pag WHERE conse='$conse' AND ced_fuen='$fuente'";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	$v_total = 0;
	$fechas = "";
	$numeros = "";
	$j = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$j++;
		$dif_fuen = trim(odbc_result($cur,10));
		switch ($dif_fuen)
		{
			case '1':
				$nif_fuen = "PROIC";
				break;
			case '2':
				$nif_fuen = "IC";
				break;
			case '3':
				$nif_fuen = "Rad.";
				break;
			case '4':
				$nif_fuen = "IIC";
				break;
		}
		$din_fuen = trim(odbc_result($cur,11));
		$fec_difu = trim(odbc_result($cur,12));
		$sin_fuen .= $j.". ".trim(utf8_encode($row["sin_fuen"]))." - ".$nif_fuen.": ".$din_fuen." - Fecha: ".$fec_difu." \n";
		$uti_fuen .= $j.". ".trim(utf8_encode($row["uti_fuen"]))." \n";
		$fechas .= $fec_difu." - ";
		$numeros .= $din_fuen." - ";
		$val_fuen = trim(odbc_result($cur,18));
	    $v_valor1 = str_replace(',','',$val_fuen);
	    $v_valor1 = substr($v_valor1,0,-3);
	    $v_valor1 = intval($v_valor1);
	    $v_total = $v_total+$v_valor1;
		$uni_fuen = odbc_result($cur,19);
	}
	$v_total = number_format($v_total, 2);
	$fechas = substr($fechas, 0, -3);
	$numeros = substr($numeros, 0, -3);
	$salida->sintesis = $sin_fuen;
	$salida->difusion = $dif_fuen;
	$salida->numeros = $numeros;
	$salida->fechas = $fechas;
	$salida->unidad = $uni_fuen;
	$salida->utilidad = $uti_fuen;
	$salida->valor = $v_total;
	$salida->total = $total;
	echo json_encode($salida);
}
?>