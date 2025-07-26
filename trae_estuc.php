<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$estructura = stringArray($_POST['estructura']);
	$query = "SELECT * FROM cx_ctr_est WHERE codigo IN ($estructura) ORDER BY codigo";
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