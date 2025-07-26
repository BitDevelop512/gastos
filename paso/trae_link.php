<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$unidad = $_POST['unidad'];
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	$query = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
    $sql = odbc_exec($conexion,$query);
    $sigla = trim(odbc_result($sql,1));
    $link = "PlanInvCen_".$sigla."_".$periodo."_".$ano.".pdf";
    $salida = new stdClass();
    $salida->salida = $link;
	echo json_encode($salida);
}
?>