<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $conse = $_POST['conse'];
    $pregunta = "SELECT * FROM cx_usu_web WHERE conse='$conse'";
    $sql = odbc_exec($conexion,$pregunta);
    $usuario = trim(odbc_result($sql,3));
    $nombre = trim(utf8_encode(odbc_result($sql,4)));
    $permisos = trim(odbc_result($sql,6));
    $unidad = odbc_result($sql,11);
    $super = odbc_result($sql,24);
    // Se parte la cadena de permisos grabados
	$num_permisos = explode("/",$permisos);
	for ($k=0;$k<(count($num_permisos)-1);++$k)
	{
		$j = $k+1;
		$v[$k] = $num_permisos[$k];
		list($letra, $numero) = explode("|", $v[$k]);
    	$pregunta1 = "SELECT * FROM cx_ctr_mod WHERE modulo='$letra' AND numero='$numero'";
    	$sql1 = odbc_exec($conexion,$pregunta1);
    	$interno = odbc_result($sql1,1);
    	$modulos .= $interno.",";
	}
	$modulos = substr($modulos,0,-1);
    $salida = new stdClass();
    $salida->conse = $conse;
    $salida->usuario = $usuario;
    $salida->nombre = $nombre;
    $salida->unidad = $unidad;
    $salida->super = $super;
    $salida->modulos = $modulos;
    echo json_encode($salida);
}
?>