<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
	$numero = $_POST['numero'];
	$fuente = $_POST['fuente'];
	$query0 = "SELECT tipo FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano'";
	$cur0 = odbc_exec($conexion, $query0);
	$tipo = odbc_result($cur0,1);
	if ($tipo == "1")
	{
		$query = "SELECT conse, ced_fuen, ano FROM cx_pla_pag WHERE conse='$numero' AND ano='$ano' AND val_fuen_a!='0.00' AND autoriza='1' AND informe!='0' GROUP BY conse, ced_fuen, ano ORDER BY conse";
	}
	else
	{
		$query = "SELECT conse, ced_fuen, ano FROM cx_pla_pag WHERE conse='$numero' AND ano='$ano' AND val_fuen_a!='0.00' GROUP BY conse, ced_fuen, ano ORDER BY conse";
	}
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
		$conse = odbc_result($cur,1);
		$cedula = trim(odbc_result($cur,2));
		$ano1 = trim(odbc_result($cur,3));
		$query1 = "SELECT conse FROM cx_act_inf WHERE unidad='$uni_usuario' AND fuente='$cedula' AND pla_inv='$conse' AND ano='$ano1'";
		$cur1 = odbc_exec($conexion, $query1);
		$total = odbc_num_rows($cur1);
		if ($total == "0")
		{
			$cursor["conse"] = $conse;
			$cursor["cedula"] = $cedula;
			array_push($respuesta, $cursor);
		}
		$i++;
	}
	echo json_encode($respuesta);
}
// 12/04/2024 - Ajuste cargue fuentes con pagos anteriores
?>