<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ordop = $_POST['ordop'];
	$ano = $_POST['ano'];
	$compa = $_POST['compa'];
	$ordop = encrypt1($ordop, $llave);
	$query = "SELECT misiones FROM cx_pla_inv WHERE n_ordop='$ordop' AND unidad='$uni_usuario' AND ano='$ano'";	
	$cur = odbc_exec($conexion, $query);
    $total = odbc_num_rows($cur);
    if ($total>0)
    {
		$misiones = odbc_result($cur,1);
		$misiones1 = decrypt1($misiones, $llave);
		$salida->misiones = $misiones1;
	}
	else
	{
		$salida->misiones = "";
	}
	echo json_encode($salida);
}
?>