<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$query = "SELECT * FROM cx_ctr_rol ORDER BY conse";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	$salida = "<table width='80%' align='center' border='1'><tr><td width='90%'><center><b>Nombre</b></center></td><td width='10%'><center>&nbsp</center></td></tr>";
	$i=0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$conse = odbc_result($cur,1);
		$nombre = utf8_encode(odbc_result($cur,3));
		$salida .= "<tr><td>".$nombre."</td><td><center><a href='#' onclick='modif(".$conse.")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td></tr>";
		$i++;
	}
	$salida.="</table>";
	echo $salida;
}
?>