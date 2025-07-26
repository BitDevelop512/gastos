<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$valor2 = $_POST['valor2'];
	// Se registra notificacion
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
	$consecu = odbc_result($cur,1);
	$query = "SELECT unidad FROM cx_usu_web WHERE usuario='$valor'"; 
	$cur1 = odbc_exec($conexion, $query);
	$unidad1 = odbc_result($cur1,1);
	$mensaje = "SE HA INGRESADO UN REGISTRO DE RECOMPENSA CON EL INTERNO ".$valor2.". SE SOLICITA REVISION DEL MISMO.";
	$query1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$valor', '$unidad1', '$mensaje', 'S', '1')";
	$sql1 = odbc_exec($conexion, $query1);
    // Se cambia el estado del registro a pendiente
	$graba = "UPDATE cx_reg_rec SET estado='P', usuario1='$valor', fec_sol=getdate() WHERE conse='$valor2'";
	$sql2 = odbc_exec($conexion, $graba);
	// Se verifica estado de grabacion
	$query2 = "SELECT estado FROM cx_reg_rec WHERE conse='$valor2'";
	$cur2 = odbc_exec($conexion, $query2);
	$estado = odbc_result($cur2,1);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $estado;
	echo json_encode($salida);
}
?>