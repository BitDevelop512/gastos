<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
	$tipo = $_POST['tipo'];
	$unidades = $_POST['unidades'];
	$mes = $_POST['periodo'];
	if ($mes == "1")
	{
		$mes1 = "12";
		$ano1 = date('Y')-1;
	}
	else
	{
		$mes1 = intval($mes)-1;
	}
	// Se consulta recompensa de la unidad
	if ($mes == "1")
	{
		$query = "SELECT TOP 1 unidad, sigla, valor, total, conse, n_depen, n_uom, solicitud, registro, ano1 FROM cx_val_aut2 WHERE periodo IN ('$mes1','$mes') AND ((ano='$ano') OR (ano='$ano1')) AND estado='I' AND unidad IN ($unidades) AND pago='0' AND EXISTS (SELECT * FROM cx_act_rec WHERE cx_act_rec.registro=cx_val_aut2.solicitud)";
	}
	else
	{
		$query = "SELECT TOP 1 unidad, sigla, valor, total, conse, n_depen, n_uom, solicitud, registro, ano1 FROM cx_val_aut2 WHERE periodo IN ('$mes1','$mes') AND ano='$ano' AND estado='I' AND unidad IN ($unidades) AND pago='0' AND EXISTS (SELECT * FROM cx_act_rec WHERE cx_act_rec.registro=cx_val_aut2.solicitud)";
	}
	$cur = odbc_exec($conexion, $query);
    $valida = odbc_num_rows($cur);
    if ($valida == "0")
    {
    	$total = "0";
    	$informe = "0";
    	$recurso = "0";
    	$rubro = "0";
    	$concepto = "";
    }
    else
    {
	    $sigla = trim(odbc_result($cur,2));
	    $depen = trim(odbc_result($cur,6));
	    $uom = trim(odbc_result($cur,7));
	    $solicitud = odbc_result($cur,8);
	    $registro = odbc_result($cur,9);
	    $ano1 = odbc_result($cur,10);
		$sustituye = array ( 'V1' => 'V01', 'V2' => 'V02', 'V3' => 'V03', 'V4' => 'V04', 'V5' => 'V05', 'V6' => 'V06', 'V7' => 'V07', 'V8' => 'V08' );
        $uom = strtr(trim($uom), $sustituye);
	    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE sigla='$uom'";
	    $cur1 = odbc_exec($conexion, $query1);
	    $v1 = odbc_result($cur1,1);
	    $query2 = "SELECT subdependencia FROM cx_org_sub WHERE sigla='$depen'";
	    $cur2 = odbc_exec($conexion, $query2);
	    $v2 = odbc_result($cur2,1);
	    $unidades1 = "<option value='".$v2."'>".$depen."</option><option value='".$v1."'>".$uom."</option>";
		$total = trim(odbc_result($cur,4));
		$total = number_format($total,2);
		$total1 = trim(odbc_result($cur,4));
		$total1 = floatval($total1);
		$total2 = $total1.".00";
	    $datos = $depen."|".$total."#";
		$respuesta = array();
		$salida = new stdClass();
	    $i = 1;
	    while ($i < $row = odbc_fetch_array($cur))
	    {
		    $unidad = odbc_result($cur,1);
			$sigla = trim(odbc_result($cur,2));
			$val1 = odbc_result($cur,3);
			$val1 = floatval($val1);
			$val2 = odbc_result($cur,4);
			$val2 = floatval($val2);
			$conse1 = odbc_result($cur,5);
	    }
		// Se consulta informacion del informe de giro
		$pregunta = "SELECT conse, recurso, rubro, concepto, numero FROM cx_inf_gir WHERE ((total='$total1') OR (total='$total2')) AND periodo IN ('$mes1','$mes') AND ano='$ano' AND estado='I' AND unidad1='$uni_usuario' AND concepto='10'";
		$sql = odbc_exec($conexion, $pregunta);
		$valida1 = odbc_num_rows($sql);
		if ($valida1 == "0")
		{
			$informe = "0";
			$recurso = "0";
			$rubro = "0";
			$concepto = "0";
			$interno = "0";
		}
		else
		{
			$informe = odbc_result($sql,1);
			$recurso = odbc_result($sql,2);
			$rubro = odbc_result($sql,3);
			$concepto = odbc_result($sql,4);
			$interno = odbc_result($sql,5);
		}
		// Se valida que se haya realizado acta de pago de recompensa
		$query1 = "SELECT conse, pago FROM cx_act_rec WHERE registro='$solicitud' AND ano1='$ano1' ORDER BY fecha DESC";
    	$cur1 = odbc_exec($conexion, $query1);
    	$valida2 = odbc_num_rows($cur1);
    	if ($valida2 == "0")
    	{
    		$acta = "0";
    		$total = "0.00";
    	}
    	else
    	{
    		$acta = odbc_result($cur1,1);
			$total = trim(odbc_result($cur1,2));
			$datos = $depen."|".$total."#";
    	}
	}
    $salida->total = $total;
    $salida->acta = $acta;
    $salida->informe = $interno;
    $salida->recurso = $recurso;
    $salida->rubro = $rubro;
    $salida->concepto = $concepto;
    $salida->datos = $datos;
    $salida->unidades = $unidades1;
	echo json_encode($salida);
}
?>