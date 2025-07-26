<?php
session_start();
error_reporting(0);
require('conf.php');
$usuario = $_REQUEST['usuario'];
$query = "SELECT firma, firma1, firma2, firma3 FROM cx_usu_web WHERE usuario='$usuario'";
$cur = odbc_exec($conexion, $query);
$firma = odbc_result($cur,1);
$firma = substr($firma, 14);
$firma1 = odbc_result($cur,2);
$firma2 = odbc_result($cur,3);
$firma3 = odbc_result($cur,4);
$firmas = $firma.$firma1.$firma2.$firma3;
$salida->salida = $firmas;
echo json_encode($salida);
?>