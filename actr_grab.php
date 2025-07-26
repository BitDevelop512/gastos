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
	$conse = $_POST['conse'];
	$registro = $_POST['registro'];
	$num_registro = explode("-",$registro);
	$registro1 = trim($num_registro[0]);
	$ano1 = trim($num_registro[1]);
	$valor = $_POST['valor'];
	$directiva = $_POST['directiva'];
	$salario = $_POST['salario'];
	$firmas = $_POST['firmas'];
	$firmas = strtr(trim($firmas), $sustituye);
	$firmas = iconv("UTF-8", "ISO-8859-1", $firmas);
	$acta = trim($_POST['acta']);
	$constancia = $_POST['constancia'];
	$folio = $_POST['folio'];
	$sintesis = $_POST['sintesis'];
	$sintesis = strtr(trim($sintesis), $sustituye);
	$sintesis = iconv("UTF-8", "ISO-8859-1", $sintesis);
	$informacion = $_POST['informacion'];
	$informacion = strtr(trim($informacion), $sustituye);
	$informacion = iconv("UTF-8", "ISO-8859-1", $informacion);
	$neutralizados = $_POST['neutralizados'];
	$neutralizados = strtr(trim($neutralizados), $sustituye);
	$neutralizados = iconv("UTF-8", "ISO-8859-1", $neutralizados);
	$material = $_POST['material'];
	$totali = $_POST['totali'];
	$totaln = $_POST['totaln'];
	$totalm = $_POST['totalm'];
	$totala = $_POST['totala'];
	$impacto = $_POST['impacto'];
	$impacto = strtr(trim($impacto), $sustituye);
	$impacto = iconv("UTF-8", "ISO-8859-1", $impacto);
	$concepto = $_POST['concepto'];
	$concepto = strtr(trim($concepto), $sustituye);
	$concepto = iconv("UTF-8", "ISO-8859-1", $concepto);
	$valoracion = $_POST['valoracion'];
	$valoracion = strtr(trim($valoracion), $sustituye);
	$valoracion = iconv("UTF-8", "ISO-8859-1", $valoracion);
	$recomendaciones = $_POST['recomendaciones'];
	$recomendaciones = strtr(trim($recomendaciones), $sustituye);
	$recomendaciones = iconv("UTF-8", "ISO-8859-1", $recomendaciones);
	$observaciones = $_POST['observaciones'];
	$observaciones = strtr(trim($observaciones), $sustituye);
	$observaciones = iconv("UTF-8", "ISO-8859-1", $observaciones);
	$elaboro = trim($_POST['elaboro']);
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$reviso = trim($_POST['reviso']);
	$reviso = iconv("UTF-8", "ISO-8859-1", $reviso);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$ciudad = $_POST['ciudad'];
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	// Se validan datos en blanco
	if (trim($usuario) == "")
	{
		$conse = 0;
	}
	else
	{
		if ($tipo == "1")
		{
			// Se consulta el maximo de registros por año
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_act_reg WHERE ano='$ano'");
			$consecu = odbc_result($cur,1);
			$query = "INSERT INTO cx_act_reg (conse, usuario, unidad, estado, ano, registro, ano1, valor, directiva, firmas, sintesis, neutralizados, totaln, material, totalm, totala, concepto, recomendaciones, observaciones, elaboro, acta, constancia, folio, valoracion, reviso, salario, impacto, informacion, totali) VALUES ('$consecu', '$usuario', '$unidad', '', '$ano', '$registro1', '$ano1', '$valor', '$directiva', '$firmas', '$sintesis', '$neutralizados', '$totaln', '$material', '$totalm', '$totala', '$concepto', '$recomendaciones', '$observaciones', '$elaboro', '$acta', '$constancia', '$folio', '$valoracion', '$reviso', '$salario', '$impacto', '$informacion', '$totali')";
			$sql = odbc_exec($conexion, $query);
			$query1 = "SELECT conse FROM cx_act_reg WHERE conse='$consecu' AND ano='$ano'";
			$cur1 = odbc_exec($conexion, $query1);
			$conse = odbc_result($cur1,1);
		}
		else
		{
			$query = "UPDATE cx_act_reg SET firmas='$firmas', sintesis='$sintesis', neutralizados='$neutralizados', totaln='$totaln', material='$material', totalm='$totalm', totala='$totala', concepto='$concepto', recomendaciones='$recomendaciones', observaciones='$observaciones', elaboro='$elaboro', acta='$acta', constancia='$constancia', folio='$folio', valoracion='$valoracion', reviso='$reviso', impacto='$impacto', informacion='$informacion', totali='$totali' WHERE conse='$conse' AND registro='$registro1' AND ano1='$ano1'";
			$sql = odbc_exec($conexion, $query);
			$query1 = "SELECT ano FROM cx_act_reg WHERE conse='$conse' AND registro='$registro1' AND ano1='$ano1'";
			$cur1 = odbc_exec($conexion, $query1);
			$ano = odbc_result($cur1,1);
		}
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_regional.txt", "a");
		fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
		fclose($file);
	}
	// Ajuste de valores en 0 y blancos
	$query0 = "UPDATE cx_act_reg SET totali='0.00' WHERE totali='NaN'";
	$sql0 = odbc_exec($conexion, $query0);
	$query0 = "UPDATE cx_act_reg SET totaln='0.00' WHERE totaln='NaN'";
	$sql0 = odbc_exec($conexion, $query0);
	$query0 = "UPDATE cx_act_reg SET totalm='0.00' WHERE totalm='NaN'";
	$sql0 = odbc_exec($conexion, $query0);
	$query0 = "UPDATE cx_act_reg SET totala='0.00' WHERE totala='NaN'";
	$sql0 = odbc_exec($conexion, $query0);
	$query0 = "UPDATE cx_act_reg SET totali='0.00' WHERE totali=''";
	$sql0 = odbc_exec($conexion, $query0);
	$query0 = "UPDATE cx_act_reg SET totaln='0.00' WHERE totaln=''";
	$sql0 = odbc_exec($conexion, $query0);
	$query0 = "UPDATE cx_act_reg SET totalm='0.00' WHERE totalm=''";
	$sql0 = odbc_exec($conexion, $query0);
	$query0 = "UPDATE cx_act_reg SET totala='0.00' WHERE totala=''";
	$sql0 = odbc_exec($conexion, $query0);
	// Salida
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->salida1 = $ano;
	echo json_encode($salida);
}
?>