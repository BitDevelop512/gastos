<?php
session_start();
error_reporting(0);
require('../conf.php');
$usuario = $_REQUEST['usuario'];
$interno = $_REQUEST['interno'];
$query = "SELECT imagen FROM cx_usu_web WHERE conse='$interno'";
$sql = odbc_exec($conexion, $query);
$total = odbc_num_rows($sql);
if ($total > 0)
{
	$firma = trim(odbc_result($sql,1));
}
else
{
	$firma = "";
}
$salida->total = $total;
$salida->firma = $firma;
echo json_encode($salida);
?>