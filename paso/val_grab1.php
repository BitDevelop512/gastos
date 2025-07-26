<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	// Si es C4
	if ($adm_usuario == "10")
	{
		$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_cen");
		$consecu = odbc_result($cur,1);
		// Se graba plan inversion centralizado
		$graba = "INSERT INTO cx_pla_cen (conse, usuario, unidad, periodo, ano, revisa) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$periodo', '$ano', '$con_usuario')";
		odbc_exec($conexion, $graba);
		$query1 = "SELECT conse FROM cx_pla_cen WHERE conse='$consecu'";
		$cur = odbc_exec($conexion, $query1);
		$conse = odbc_result($cur,1);
		// Se crea notificacion
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur1,1);
		// Se consulta JEM Comando
	    $query2 = "select usuario from cx_usu_web where unidad='$uni_usuario' and admin='11'";
	   	$cur2 = odbc_exec($conexion,$query2);
	   	$usuario1 = odbc_result($cur2,1);
		$mensaje = "SE HA REVISADO PLAN DE NECESIDADES UNIDAD CENTRALIZADORA, SE SOLICITA APROBACION.";		
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario1', '$uni_usuario', '$mensaje', 'S', '1')";
		$sql2 = odbc_exec($conexion, $query2);
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_auto.txt", "a");
		fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
		fclose($file);
	}
	// Si es JEM Comando
	if ($adm_usuario == "11")
	{
		$graba = "UPDATE cx_pla_cen SET ordena='$con_usuario' WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
		odbc_exec($conexion, $graba);
		$conse = "1";
		// Se crea notificacion
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur1,1);
		// Se consulta JEM Comando
	    $query2 = "select usuario from cx_usu_web where unidad='$uni_usuario' and admin='12'";
	   	$cur2 = odbc_exec($conexion,$query2);
	   	$usuario1 = odbc_result($cur2,1);
		$mensaje = "SE HA ORDENADO PLAN DE NECESIDADES UNIDAD CENTRALIZADORA, SE SOLICITA VISTO BUENO.";		
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario1', '$uni_usuario', '$mensaje', 'S', '1')";
		$sql2 = odbc_exec($conexion, $query2);
	}
	// Si es Com,andante Comando
	if ($adm_usuario == "12")
	{
		$graba = "UPDATE cx_pla_cen SET visto='$con_usuario' WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
		odbc_exec($conexion, $graba);
		$conse = "1";
	}
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
?>