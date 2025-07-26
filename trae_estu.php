<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$factor = stringArray($_POST['factor']);
	$query = "SELECT * FROM cx_ctr_est WHERE conse IN ($factor) ORDER BY codigo";
	$menu2_2 = odbc_exec($conexion, $query);
	while ($i < $row = odbc_fetch_array($menu2_2))
	{
	    $n_nombre = utf8_encode(trim($row['nombre']));
	    $menu->rows[$i]['codigo'] = $row['codigo'];
	    $menu->rows[$i]['nombre'] = $n_nombre;
	    $i++;
	}
	echo json_encode($menu);
}
?>