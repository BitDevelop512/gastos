<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$nota = trim($_POST['nota']);
	$nota = iconv("UTF-8", "ISO-8859-1", $nota);
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	$query = "UPDATE cx_inf_pla SET revisa='0', aprueba='0', rechaza='1', nota='$nota' WHERE conse='$conse'";
	$cur = odbc_exec($conexion, $query);
	// Se consulta unidad que se aprobo plan de necesidades
	$query1 = "SELECT unidad FROM cx_inf_pla WHERE conse='$conse' AND periodo='$periodo' AND ano='$ano'";
	$cur1 = odbc_exec($conexion, $query1);
	$unidad = odbc_result($cur1,1);
	// Se consulta uom de unidad que se le aprueba plan de necesidades
	$query2 = "SELECT uom FROM cx_val_aut WHERE unidad='$unidad' AND periodo='$periodo' AND ano='$ano' AND estado='V'";
	$cur2 = odbc_exec($conexion, $query2);
	$uom = odbc_result($cur2,1);
	// Se actualiza cx_inf_uni campo aprueba3 para que no salga en informe de giro
	$query3 = "UPDATE cx_inf_uni SET aprueba3='0' WHERE unidad='$uom' AND periodo='$periodo' AND ano='$ano'";
	$cur3 = odbc_exec($conexion, $query3);
}
?>