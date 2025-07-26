<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	$query = "UPDATE cx_inf_pla SET revisa='1', aprueba='$con_usuario', rechaza='0' WHERE conse='$conse'";
	$cur = odbc_exec($conexion, $query);
	// Se consulta unidad que se aprobo plan de necesidades
	$query1 = "SELECT unidad FROM cx_inf_pla WHERE conse='$conse' AND periodo='$periodo' AND ano='$ano'";
	$cur1 = odbc_exec($conexion, $query1);
	$unidad = odbc_result($cur1,1);
	// Se consulta uom de unidad que se le aprueba plan de necesidades
	$query2 = "SELECT uom FROM cx_val_aut WHERE unidad='$unidad' AND periodo='$periodo' AND ano='$ano' AND estado='V'";
	$cur2 = odbc_exec($conexion, $query2);
	$uom = odbc_result($cur2,1);
	// Se actualiza cx_val_aut campo aprueba1 para todos los de la misma unidad
	$query3 = "UPDATE cx_val_aut SET aprueba1='$con_usuario' WHERE uom='$uom' AND periodo='$periodo' AND ano='$ano' AND estado='V'";
	$cur3 = odbc_exec($conexion, $query3);
	// Se elimina registrto validado anteriormente de la unidad
	$query5 = "DELETE FROM cx_inf_uni WHERE unidad='$uom' AND periodo='$periodo' AND ano='$ano'";
	$cur5 = odbc_exec($conexion, $query5);
	// Se graba registro de que se aprobo el plan de la unidad
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_inf_uni");
	$consecu = odbc_result($cur,1);
	$query4 = "INSERT INTO cx_inf_uni (conse, usuario, unidad, periodo, ano, aprueba) VALUES ('$consecu', '$usu_usuario', '$uom', '$periodo', '$ano', '$con_usuario')";
	$cur4 = odbc_exec($conexion, $query4);
}
?>