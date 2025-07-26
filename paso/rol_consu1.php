<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $conse = $_POST['conse'];
    $pregunta = "select nombre, permisos from cx_ctr_rol where conse='$conse'";
    $sql = odbc_exec($conexion,$pregunta);
    $nombre = trim(odbc_result($sql,1));
    $permisos = trim(odbc_result($sql,2));
    // Se parte la cadena de permisos grabados
	$num_permisos=explode("/",$permisos);
	for ($k=0;$k<(count($num_permisos)-1);++$k)
	{
		$j=$k+1;
		$v[$k]=$num_permisos[$k];
		list($letra, $numero) = explode("|", $v[$k]);
    	$pregunta1 = "select * from cx_ctr_mod where modulo='$letra' and numero='$numero'";
    	$sql1 = odbc_exec($conexion,$pregunta1);
    	$interno = odbc_result($sql1,1);
    	$modulos .= $interno.",";
	}
	$modulos = substr($modulos,0,-1);
    $salida = new stdClass();
    $salida->conse = $conse;
    $salida->nombre = $nombre;
    $salida->modulos = $modulos;
    echo json_encode($salida);
}
?>