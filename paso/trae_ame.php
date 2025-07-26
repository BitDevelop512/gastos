<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$menu2_2 = odbc_exec($conexion, "SELECT * FROM cx_ctr_fac WHERE estado='' ORDER BY codigo");
	while ($i < $row = odbc_fetch_array($menu2_2))
	{
	    $n_nombre = trim(utf8_encode($row['nombre']));
	    $menu->rows[$i]['codigo'] = $row['codigo'];
	    $menu->rows[$i]['nombre'] = $n_nombre;
	    $i++;
	}
	echo json_encode($menu);
}
?>