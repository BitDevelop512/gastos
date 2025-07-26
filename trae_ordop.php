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
	$query = "SELECT conse, compania FROM cx_pla_inv WHERE n_ordop='$ordop' AND unidad='$uni_usuario' AND ano='$ano'";	
	$cur = odbc_exec($conexion, $query);
    $total = odbc_num_rows($cur);
    if ($total>0)
    {
		$conse = odbc_result($cur,1);
		$compa = odbc_result($cur,2);
		if ($tip_usuario == $compa)
		{
			$salida->salida = "0";
			$salida->plan = "0";
		}
		else
		{
			$salida->salida = "1";
			$salida->plan = $conse;
		}

	}
	else
	{
		$salida->salida = "0";
		$salida->plan = "0";
	}
	echo json_encode($salida);
}
?>