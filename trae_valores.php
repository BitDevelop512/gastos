<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
	$concepto = $_POST['concepto'];
	$mes = $_POST['periodo'];
	$mes = intval($mes);
	if ($concepto == "9")
	{
		$mes1 = str_pad($mes,2,"0",STR_PAD_LEFT);
		switch ($mes)
		{
			case '1':
			case '3':
			case '5':
			case '7':
			case '8':
			case '10':
			case '12':
				$dia1 = "31";
				break;
			case '2':
				if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
				{
					$dia1 = "29";
				}
				else
				{
					$dia1 = "28";
				}
				break;
			case '4':
			case '6':
			case '9':
			case '11':
				$dia1 = "30";
				break;
			default:
				$dia1 = "31";
				break;
		}
		$fecha1 = "01/".$mes1."/".$ano;
		$fecha2 = $dia1."/".$mes1."/".$ano;
		$query = "SELECT total, conse, fecha, crp, cdp, recurso, rubro, numero FROM cx_inf_gir WHERE unidad1='$uni_usuario' AND fecha BETWEEN convert(datetime,'$fecha1',103) and (convert(datetime,'$fecha2',103)+1) AND ano='$ano' AND concepto='$concepto' AND estado='' ORDER BY conse";
	}
	else
	{
		if ($concepto == "10")
		{
			$top = "TOP 1";
		}
		else
		{
			$top = "";
		}
		$query = "SELECT $top total, conse, fecha, crp, cdp, recurso, rubro, numero FROM cx_inf_gir WHERE unidad1='$uni_usuario' AND periodo='$mes' AND ano='$ano' AND concepto='$concepto' AND estado='' ORDER BY conse";
	}
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	$respuesta=array();
	if ($total > 0)
	{
		$i=0;
		while($i<$row=odbc_fetch_array($cur))
		{
			$cursor = array();
	        $total = odbc_result($cur,1);
	        $total1 = number_format($total,2);
		    $cursor["codigo"] = $total;
		    $cursor["nombre"] = $total1;
			$num_giro = odbc_result($cur,2);
			$fec_giro = odbc_result($cur,3);
			$fec_giro = substr($fec_giro,0,10);
			$crp_giro = odbc_result($cur,4);
			$cdp_giro = odbc_result($cur,5);
			$rec_giro = odbc_result($cur,6);
			$rub_giro = odbc_result($cur,7);
			$con_giro = odbc_result($cur,8);
		    $cursor["giro"] = $con_giro;
		    $cursor["giro1"] = $num_giro;
		    $cursor["fec_giro"] = $fec_giro;
		    $cursor["crp_giro"] = $crp_giro;
		    $cursor["cdp_giro"] = $cdp_giro;
		    $cursor["rec_giro"] = $rec_giro;
		    $cursor["rub_giro"] = $rub_giro;
		    array_push($respuesta, $cursor);
			$i++;
		}
	}
	else
	{
		$cursor = array();
		$cursor["codigo"] = "0";
		$cursor["nombre"] = "0.00";
		$cursor["giro"] = "0";
		array_push($respuesta, $cursor);
	}
	echo json_encode($respuesta);
}
?>