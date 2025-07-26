<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$centra = $_POST['centra'];
	$plan = $_POST['fuente'];
  	$fuente = $_POST['fuente1'];
	$numero = trim($_POST['numero']);
	$numero = iconv("UTF-8", "ISO-8859-1", $numero);
	$testigo = $_POST['testigo'];
	$testigo = iconv("UTF-8", "ISO-8859-1", $testigo);
	$valor = $_POST['valor'];
	$utilidad = "";
	$sintesis = $_POST['sintesis'];
	$sintesis = strtr(trim($sintesis), $sustituye);
	$sintesis = iconv("UTF-8", "ISO-8859-1", $sintesis);
	$empleo = $_POST['empleo'];
	$empleo = strtr(trim($empleo), $sustituye);
	$empleo = iconv("UTF-8", "ISO-8859-1", $empleo);
	$observa = $_POST['observa'];
	$observa = strtr(trim($observa), $sustituye);
	$observa = iconv("UTF-8", "ISO-8859-1", $observa);
	$difusion = $_POST['difusion'];
	$uni_dif = $_POST['uni_dif'];
	$num_dif = $_POST['num_dif'];
	$fec_dif = $_POST['fec_dif'];
	$pys = $_POST['pys'];
	$pagos = $_POST['pagos'];
	$ano = $_POST['ano'];
	$elaboro = $_POST['elaboro'];
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$ciudad = $_POST['ciudad'];
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	$firmas = $_POST['firmas'];
	$firmas = encrypt1($firmas, $llave);
	$ciu_usuario = iconv("UTF-8", "ISO-8859-1", $ciu_usuario);
	// Se validan datos en blanco
	if ((trim($usuario) == "") or (trim($ciudad) == ""))
	{
		$conse = 0;
	}
	else
	{
		$cur = odbc_exec($conexion,"SELECT act_inf FROM cx_org_sub WHERE subdependencia='$centra'");
		$consecu = odbc_result($cur,1);
		$consecu = $consecu+1;
		// Se graba acta
		$graba = "INSERT INTO cx_act_inf (conse, usuario, unidad, ciudad, fuente, testigo, valor, utilidad, sintesis, difusion, unidad1, num_dif, fec_dif, pys, ano, firmas, pla_inv, pagos, empleo, observacion, elaboro, numero) VALUES ('$consecu', '$usuario', '$unidad', '$ciudad', '$fuente', '$testigo', '$valor', '$utilidad', '$sintesis', '$difusion', '$uni_dif', '$num_dif', '$fec_dif', '$pys', '$ano', '$firmas', '$plan', '$pagos', '$empleo', '$observa', '$elaboro', '$numero')";
		if (!odbc_exec($conexion, $graba))
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
			// Se valida que se grabe
			$query1 = "SELECT conse FROM cx_act_inf WHERE conse='$consecu' AND ano='$ano'";
			$cur2 = odbc_exec($conexion, $query1);
			$conse = odbc_result($cur2,1);
			// Se graba log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_acta.txt", "a");
			fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
			fclose($file);
		}
	}
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->ano = $ano;
	echo json_encode($salida);
}
?>