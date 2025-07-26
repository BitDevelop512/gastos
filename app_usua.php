<?php
session_start();
error_reporting(0);
require('conf.php');
$query = "SELECT conse, usuario, cargo FROM cx_usu_web WHERE cargo!='' ORDER BY cargo";
$cur = odbc_exec($conexion, $query);
$respuesta=array();
$i=0;
while($i<$row=odbc_fetch_array($cur))
{
	$cursor=array();
    $cursor["conse"] = odbc_result($cur,1);
	$cursor["usuario"] = trim(odbc_result($cur,2));
	$cursor["cargo"] = trim(utf8_encode(odbc_result($cur,3)));
	array_push($respuesta, $cursor);
	$i++;
}
echo json_encode($respuesta);
?>