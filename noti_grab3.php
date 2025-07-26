<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$query1 = "SELECT unidad, periodo, ano FROM cx_pla_inv WHERE conse='$conse'";
	$cur1 = odbc_exec($conexion, $query1);
	$n_unidad1 = odbc_result($cur1,1);
	$n_mes = odbc_result($cur1,2);
	$n_ano = odbc_result($cur1,3);
	// Actualiza el visto bueno
	$actu = "UPDATE cx_val_aut SET estado='V', aprueba='$usu_usuario', fecha_a=getdate() WHERE unidad='$n_unidad1' AND periodo='$n_mes' AND ano='$n_ano'";
	$sql1 = odbc_exec($conexion,$actu);

	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
	$consecu1 = odbc_result($cur1,1);
	// Se consulta centralizadora
	$query3 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND unic='1'"; 
  	$cur3 = odbc_exec($conexion, $query3);
  	$unidad2 = odbc_result($cur3,1);
  	// Se consulta usuario division
 	$query4 = "SELECT usuario FROM cx_usu_web WHERE unidad='$unidad2' AND admin='10'"; 
  	$cur4 = odbc_exec($conexion, $query4);
  	$usuario2 = odbc_result($cur4,1);
  	$mensaje = "SE HA DADO VISTO BUENO POR PARTE DEL COMANDANTE DEL PLAN / SOLICITUD CON EL NUMERO ".$conse;
	$query5 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario2', '$unidad2', '$mensaje', 'A', '1')";
	$sql5 = odbc_exec($conexion, $query5);
}
?>