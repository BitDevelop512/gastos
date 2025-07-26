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
	$centra = $_POST['centra'];
	$conse = $_POST['conse'];
	$registro = $_POST['registro'];
	$num_registro = explode("-",$registro);
	$registro1 = trim($num_registro[0]);
	$ano1 = trim($num_registro[1]);
    $tipo1 = trim($num_registro[2]);
	$valor = $_POST['valor'];
	$total = $_POST['total'];
	$pago = $_POST['pago'];
	$otro = $_POST['otro'];
	$firmas = $_POST['firmas'];
	$firmas = strtr(trim($firmas), $sustituye);
	$firmas = iconv("UTF-8", "ISO-8859-1", $firmas);
	$fuentes = $_POST['fuentes'];
	$fuentes = stringArray1($fuentes);
	$fuentes = iconv("UTF-8", "ISO-8859-1", $fuentes);
	$expedidas = $_POST['expedidas'];
	$expedidas = strtr(trim($expedidas), $sustituye);
	$expedidas = iconv("UTF-8", "ISO-8859-1", $expedidas);
	$sintesis = $_POST['sintesis'];
	$sintesis = strtr(trim($sintesis), $sustituye);
	$sintesis = iconv("UTF-8", "ISO-8859-1", $sintesis);
	$utilidad = $_POST['utilidad'];
	$utilidad = strtr(trim($utilidad), $sustituye);
	$utilidad = iconv("UTF-8", "ISO-8859-1", $utilidad);
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
			$cur = odbc_exec($conexion,"SELECT act_inf FROM cx_org_sub WHERE subdependencia='$centra'");
			$consecu = odbc_result($cur,1);
			$consecu = $consecu+1;
			$query = "INSERT INTO cx_act_rec (conse, usuario, unidad, estado, ano, registro, ano1, valor, pago, firmas, cedulas, sintesis, utilidad, observaciones, elaboro, reviso, expedidas, otro, cambio) VALUES ('$consecu', '$usuario', '$unidad', '', '$ano', '$registro1', '$ano1', '$valor', '$total', '$firmas', '$fuentes', '$sintesis', '$utilidad', '$observaciones', '$elaboro', '$reviso', '$expedidas', '$pago', '$otro')";
			if (!odbc_exec($conexion, $query))
			{
		    	$confirma = "0";
		    	$conse = "0";
			}
			else
			{
				$confirma = "1";
			}
			if ($confirma == "1")
			{
				// Se actualiza acta de unidad centralizadora
				$cur1 = odbc_exec($conexion,"UPDATE cx_org_sub SET act_inf='$consecu' WHERE subdependencia='$centra'");
				$query1 = "SELECT conse FROM cx_act_rec WHERE conse='$consecu' AND ano='$ano'";
				$cur1 = odbc_exec($conexion, $query1);
				$conse = odbc_result($cur1,1);
			}
		}
		else
		{
			$query = "UPDATE cx_act_rec SET firmas='$firmas', sintesis='$sintesis', utilidad='$utilidad', observaciones='$observaciones', elaboro='$elaboro', reviso='$reviso', expedidas='$expedidas' WHERE conse='$conse' AND registro='$registro1' AND ano1='$ano1'";
			$sql = odbc_exec($conexion, $query);
			$query1 = "SELECT ano FROM cx_act_rec WHERE conse='$conse' AND registro='$registro1' AND ano1='$ano1'";
			$cur1 = odbc_exec($conexion, $query1);
			$ano = odbc_result($cur1,1);
		}
		// Se consulta cantidad de beneficiarios en el registro de recompensa
		$query0 = "SELECT cedulas FROM cx_reg_rec WHERE conse='$registro1' AND ano='$ano1'";
		$sql0 = odbc_exec($conexion, $query0);
		$num_cedulas = trim(odbc_result($sql0,1));
		$can_cedulas = explode("|", $num_cedulas);
		$cat_cedulas = count($can_cedulas)-1;
		// Se consulta cantidad de actas de pago registradas para el registro de recompensa
		$query1 = "SELECT conse FROM cx_act_rec WHERE registro='$registro1' AND ano1='$ano1'";
		$sql1 = odbc_exec($conexion, $query1);
		$num_actas = odbc_num_rows($sql1);
		if ($cat_cedulas == $num_actas)
		{
			// Se actualiza registro de recompensa
			$query2 = "UPDATE cx_reg_rec SET estado='I' WHERE conse='$registro1' AND ano='$ano1' AND estado!=''";
			$cur2 = odbc_exec($conexion, $query2);
		}
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_recompensas.txt", "a");
		fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
		fclose($file);
    	if ($tipo1 == "1")
    	{
			$actu = "UPDATE cx_rec_man SET acta='1' WHERE conse='$registro1' AND ano='$ano1' AND acta='0'";
			$sql = odbc_exec($conexion, $actu);
			// Se graba log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_recompensas_manual.txt", "a");
			fwrite($file, $fec_log." # ".$actu." # ".PHP_EOL);
			fclose($file);
    	}
	}
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->salida1 = $ano;
	$salida->salida2 = $registro1;
	$salida->salida3 = $ano1;
	echo json_encode($salida);
}
?>