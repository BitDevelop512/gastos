<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$factor = stringArray($_POST['factor']);
	$query = "SELECT nombre, descrip FROM cx_ctr_fac WHERE codigo IN ($factor) ORDER BY codigo";
	$cur = odbc_exec($conexion, $query);
    $i=1;
    $descrip = "";
    while($i<$row=odbc_fetch_array($cur))
    {
        $descrip .= trim(utf8_encode($row["nombre"])).": ".trim(utf8_encode($row["descrip"]))."<hr>";
    }
	$salida->descrip = $descrip;
	echo json_encode($salida);
}
?>