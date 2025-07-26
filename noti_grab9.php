<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  	$verifica = time();
  	$alea = strtoupper(md5($verifica));
  	$alea = substr($alea,0,5);
	$conse = $_POST['conse'];
	$ano = date('Y');
	$usuario1 = $_POST['notifica'];
	// Se registra notificacion
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
	$consecu = odbc_result($cur,1);
	$query = "SELECT unidad FROM cx_usu_web WHERE usuario='$usuario1'";
	$cur1 = odbc_exec($conexion, $query);
	$unidad1 = odbc_result($cur1,1);
	$mensaje = "LA UNIDAD CUENTA CON RECURSOS PARA LA SOLICITUD NUMERO ".$conse." DE ".$ano;
	// Se graba notificacion
	$query1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad1', '$mensaje', 'S', '1')";
	$sql1 = odbc_exec($conexion, $query1);
    // Se actualiza campo de recursos indicando que si se cuenta con disponibilidad
	$actu = "UPDATE cx_pla_inv SET recursos='1' WHERE conse='$conse' AND ano='$ano'";
	$sql2 = odbc_exec($conexion, $actu);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = "S";
	echo json_encode($salida);
}
?>