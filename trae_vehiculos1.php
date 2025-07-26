<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$actual = date("Y-m-d H:i:s");
	$pregunta = "SELECT sigla FROM cx_org_cmp WHERE conse='$tip_usuario'";
	$sql = odbc_exec($conexion, $pregunta);
	$compa = trim(odbc_result($sql,1));
	$valida = strpos($usu_usuario, "_");
	$valida = intval($valida);
	if ($valida == "0")
	{
		$complemento = "1=1";
	}
	else
	{
		$v1 = explode("_", $usu_usuario);
		$v2 = $v1[1];
    	$v3 = explode("_", $log_usuario);
    	$v4 = $v3[1];
		$complemento = "(compania='$v2' OR compania='$v4' OR compania='$compa')";
	}
	$clase = $_POST['clase'];
	$query = "SELECT placa, clase, tipo, empadrona FROM cx_pla_tra WHERE unidad='$uni_usuario' AND clase='$clase' AND empadrona!='3' AND $complemento AND estado='1' ORDER BY placa";
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
	    $cursor["placa"] = odbc_result($cur,1);
	    $cursor["clase"] = odbc_result($cur,2);
	    $cursor["tipo"] = odbc_result($cur,3);
	    $v_placa = odbc_result($cur,1);
	    $v_empadrona = odbc_result($cur,4);
	    if ($v_empadrona == "2")
	    {
			$query1 = "SELECT TOP 1 fecha, autoriza FROM cx_tra_aut WHERE placa='$v_placa' ORDER BY autoriza DESC";
			$cur1 = odbc_exec($conexion, $query1);
			$total1 = odbc_num_rows($cur1);
		    if ($total1>0)
		    {
		    	$fecha = odbc_result($cur1,1);
				$autoriza = odbc_result($cur1,2);
				$fecha1 = strtotime($fecha);
				$fecha2 = strtotime($autoriza);
				$fecha3 = strtotime($actual);
				if (($fecha3 >= $fecha1) && ($fecha3 <= $fecha2))
				{
					array_push($respuesta, $cursor);
				}
				else
				{
					$cursor["placa"] = odbc_result($cur,1)." (SIN AUTORIZAR)";
					array_push($respuesta, $cursor);
				}
		    }
		    else
		    {
				$cursor["placa"] = odbc_result($cur,1)." (SIN AUTORIZAR)";
				array_push($respuesta, $cursor);
		    }
	    }
	    else
	    {
	    	array_push($respuesta, $cursor);
	    }
		$i++;
	}
	echo json_encode($respuesta);
}
// 18/10/2023 - Ajuste de consulta de vehiculos solo activos
?>