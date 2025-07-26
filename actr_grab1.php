<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$usuario = $_POST['usuario'];
	$numero = $_POST['numero'];
	$ano = $_POST['ano'];
	$registro = $_POST['registro'];
	$num_registro = explode("-",$registro);
	$conse = trim($num_registro[0]);
	$ano1 = trim($num_registro[1]);
	$actu = "UPDATE cx_reg_rec SET estado='E' WHERE conse='$conse' AND ano='$ano1'";
	if (!odbc_exec($conexion, $actu))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
		$actu1 = "UPDATE cx_act_reg SET estado='E' WHERE conse='$numero' AND ano='$ano'";
		$sql1 = odbc_exec($conexion, $actu1);
	}
	// Se graba notificacion
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
	$consecu = odbc_result($cur,1);
	$query1 = "SELECT usuario, unidad FROM cx_usu_web WHERE usuario='$usuario'"; 
	$cur1 = odbc_exec($conexion, $query1);
	$usuario1 = odbc_result($cur1,1);
	$unidad1 = odbc_result($cur1,2);
	$mensaje = "SE ELABORO EL ACTA DE COMITE REGIONAL DE RECOMPENSAS ".$numero." / ".$ano.".";
	$query1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad1', '$mensaje', 'S', '1')";
	$sql1 = odbc_exec($conexion, $query1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_regional1.txt", "a");
	fwrite($file, $fec_log." # ".$actu." # ".PHP_EOL);
	fwrite($file, $fec_log." # ".$actu1." # ".PHP_EOL);
	fwrite($file, $fec_log." ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>