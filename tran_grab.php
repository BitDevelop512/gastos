<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$conse = $_POST['conse'];
	$batallon = $_POST['batallon'];
	$brigada = $_POST['brigada'];
	$division = $_POST['division'];
	$compania = $_POST['compania'];
	$compania = strtr(trim($compania), $sustituye);
	$compania = iconv("UTF-8", "ISO-8859-1", $compania);
	$placa = trim($_POST['placa']);
	$clase = $_POST['clase'];
	$aseguradora = $_POST['aseguradora'];
	$aseguradora = strtr(trim($aseguradora), $sustituye);
	$aseguradora = iconv("UTF-8", "ISO-8859-1", $aseguradora);
	$fecha = $_POST['fecha'];
	$fecha = str_replace("/", "", $fecha);
	$fecha = str_replace("-", "", $fecha);
	$riesgo = $_POST['riesgo'];
	$aseguradora1 = $_POST['aseguradora1'];
	$aseguradora1 = strtr(trim($aseguradora1), $sustituye);
	$aseguradora1 = iconv("UTF-8", "ISO-8859-1", $aseguradora1);
	$soat = trim($_POST['soat']);
	$fecha1 = $_POST['fecha1'];
	$fecha1 = str_replace("/", "", $fecha1);
	$fecha1 = str_replace("-", "", $fecha1);
	$fecha2 = $_POST['fecha2'];
	$fecha2 = str_replace("/", "", $fecha2);
	$fecha2 = str_replace("-", "", $fecha2);
	$fecha3 = $_POST['fecha3'];
	$fecha3 = str_replace("/", "", $fecha3);
	$fecha3 = str_replace("-", "", $fecha3);
	$mantenimiento = $_POST['mantenimiento'];
	$mantenimiento = strtr(trim($mantenimiento), $sustituye);
	$mantenimiento = iconv("UTF-8", "ISO-8859-1", $mantenimiento);
	$mantenimiento1 = $_POST['mantenimiento1'];
	$mantenimiento1 = strtr(trim($mantenimiento1), $sustituye);
	$mantenimiento1 = iconv("UTF-8", "ISO-8859-1", $mantenimiento1);
	$marca = $_POST['marca'];
	$marca = strtr(trim($marca), $sustituye);
	$marca = iconv("UTF-8", "ISO-8859-1", $marca);
	$linea = $_POST['linea'];
	$linea = strtr(trim($linea), $sustituye);
	$linea = iconv("UTF-8", "ISO-8859-1", $linea);
	$modelo = $_POST['modelo'];
	$modelo = strtr(trim($modelo), $sustituye);
	$modelo = iconv("UTF-8", "ISO-8859-1", $modelo);
	$cilindraje = $_POST['cilindraje'];
	$cilindraje = strtr(trim($cilindraje), $sustituye);
	$cilindraje = iconv("UTF-8", "ISO-8859-1", $cilindraje);
	$activo = $_POST['activo'];
	$activo = strtr(trim($activo), $sustituye);
	$activo = iconv("UTF-8", "ISO-8859-1", $activo);
	$costo = $_POST['costo'];
	$costo = strtr(trim($costo), $sustituye);
	$costo = iconv("UTF-8", "ISO-8859-1", $costo);
	$combustible = $_POST['combustible'];
	$color = $_POST['color'];
	$color = strtr(trim($color), $sustituye);
	$color = iconv("UTF-8", "ISO-8859-1", $color);
	$motor = $_POST['motor'];
	$motor = strtr(trim($motor), $sustituye);
	$motor = iconv("UTF-8", "ISO-8859-1", $motor);
	$chasis = $_POST['chasis'];
	$chasis = strtr(trim($chasis), $sustituye);
	$chasis = iconv("UTF-8", "ISO-8859-1", $chasis);
	$matricula = $_POST['matricula'];
	$matricula = strtr(trim($matricula), $sustituye);
	$matricula = iconv("UTF-8", "ISO-8859-1", $matricula);
	$estado = $_POST['estado'];
	$fecha4 = $_POST['fecha4'];
	$fecha4 = str_replace("/", "", $fecha4);
	$fecha4 = str_replace("-", "", $fecha4);
	$origen = $_POST['origen'];
	$origen = strtr(trim($origen), $sustituye);
	$origen = iconv("UTF-8", "ISO-8859-1", $origen);
	$equipo = $_POST['equipo'];
	$equipo = strtr(trim($equipo), $sustituye);
	$equipo = iconv("UTF-8", "ISO-8859-1", $equipo);
	$consumo = $_POST['consumo'];
	$kilometraje = $_POST['kilometraje'];
	$empadrona = $_POST['empadrona'];
	$odometro = $_POST['odometro'];
	$observaciones = $_POST['observaciones'];
	$observaciones = strtr(trim($observaciones), $sustituye);
	$observaciones = iconv("UTF-8", "ISO-8859-1", $observaciones);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$fecha7 = $_POST['fecha7'];
	$fecha7 = str_replace("/", "", $fecha7);
	$fecha7 = str_replace("-", "", $fecha7);
	$fecha8 = $_POST['fecha8'];
	$fecha8 = str_replace("/", "", $fecha8);
	$fecha8 = str_replace("-", "", $fecha8);
	$inventa = trim($_POST['inventa']);
	if ($tipo == "1")
	{
		// Se consulta el maximo de registros por año
		$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_tra");
		$consecu = odbc_result($cur,1);
		$query = "INSERT INTO cx_pla_tra (conse, usuario, unidad, compania, placa, ase_nom, fec_seg, rie_seg, ase_soa, num_soa, fec_soa, fec_rtm, fec_man, tip_man, des_man, clase, marca, linea, modelo, cilindraje, activo, costo, tipo, color, motor, chasis, matricula, estado, fec_alt, origen, equipo, consumo, kilometro, observaciones, empadrona, odometro, inventario, fec_sof, fec_rtf) VALUES ('$consecu', '$usuario', '$batallon', '$compania', '$placa', '$aseguradora', '$fecha', '$riesgo', '$aseguradora1', '$soat', '$fecha1', '$fecha2', '$fecha3', '$mantenimiento', '$mantenimiento1', '$clase', '$marca', '$linea', '$modelo', '$cilindraje', '$activo', '$costo', '$combustible', '$color', '$motor', '$chasis', '$matricula', '$estado', '$fecha4', '$origen', '$equipo', '$consumo', '$kilometraje', '$observaciones', '$empadrona', '$odometro', '$inventa', '$fecha7', '$fecha8')";
	}
	else
	{
		$consecu = $conse;
		$query = "UPDATE cx_pla_tra SET compania='$compania', placa='$placa', ase_nom='$aseguradora', fec_seg='$fecha', rie_seg='$riesgo', ase_soa='$aseguradora1', num_soa='$soat', fec_soa='$fecha1', fec_rtm='$fecha2', fec_man='$fecha3', tip_man='$mantenimiento', des_man='$mantenimiento1', clase='$clase', marca='$marca', linea='$linea', modelo='$modelo', cilindraje='$cilindraje', activo='$activo', costo='$costo', tipo='$combustible', color='$color', motor='$motor', chasis='$chasis', matricula='$matricula', estado='$estado', fec_alt='$fecha4', origen='$origen', equipo='$equipo', consumo='$consumo', kilometro='$kilometraje', observaciones='$observaciones', empadrona='$empadrona', odometro='$odometro', inventario='$inventa', fec_sof='$fecha7', fec_rtf='$fecha8' WHERE conse='$conse'";
	}
	if (!odbc_exec($conexion, $query))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	// Super usuario o admin transportes
    if (($sup_usuario == "1") or ($sup_usuario == "2"))
    {
		$query1 = "UPDATE cx_pla_tra SET unidad='$batallon', compania='$compania' WHERE conse='$conse'";
		odbc_exec($conexion, $query1);
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_transportes_super.txt", "a");
		fwrite($file, $fec_log." # ".$query1." # ".$placa." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
    }
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_transportes.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	$salida->consecu = $consecu;
	echo json_encode($salida);
}
// 03/01/2024 - Inclusion 3 campos (vencimiento soat, rtm e inventario)
// 02/10/2024 - Ajuste inclusion placa en log de cambio de unidad
?>