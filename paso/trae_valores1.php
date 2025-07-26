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
	// Se consulta informacion del informe de giro
	$pregunta = "SELECT conse, recurso, rubro, concepto FROM cx_inf_gir WHERE periodo='$mes' AND ano='$ano' AND estado='I' AND unidad1='$uni_usuario' AND concepto='8'";
	$sql = odbc_exec($conexion, $pregunta);
	$informe = odbc_result($sql,1);
	$recurso = odbc_result($sql,2);
	$rubro = odbc_result($sql,3);
	$concepto = odbc_result($sql,4);
	// Tipo de egreso - gastos o pagos
	if ($tipo == "1")
	{
		$query = "SELECT unidad, sigla, gastos, gastos1, conse FROM cx_val_aut WHERE periodo='$mes' AND ano='$ano' AND estado='I' AND unidad IN ($unidades) AND gastose='0'";
	}
	else
	{
		$query = "SELECT unidad, sigla, pagos, pagos1, conse FROM cx_val_aut WHERE periodo='$mes' AND ano='$ano' AND estado='I' AND unidad IN ($unidades) AND pagose='0'";
	}
    $cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$total = 0;
	$conses = "";
	$internos = "";
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
		if ($val1 > $val2)
		{
			if ($tipo == "1")
			{
				$campo = "gastos";
				$campo1 = "gastose";
			}
			else
			{
				$campo = "pagos";
				$campo1 = "pagose";
			}
		    $query1 = "SELECT conse, $campo FROM cx_inf_aut WHERE unidad1='$unidad' AND periodo='$mes' AND ano='$ano' AND $campo1='0' ORDER BY conse DESC";
		    $cur1 = odbc_exec($conexion, $query1);
		    $total1 = odbc_num_rows($cur1);
		    if ($total1 > 0)
		    {
		    	$interno = odbc_result($cur1,1);
			    $valor = trim(odbc_result($cur1,2));
	            $valor = str_replace(',','',$valor);
	            $valor = trim($valor);
	            $valor = floatval($valor);
			    $valor1 = number_format($valor,2);
			    $total = $total+$valor;
		        $salida->rows[$i]['unidad'] = $unidad;
		        $salida->rows[$i]['sigla'] = $sigla;
		        $salida->rows[$i]['valor'] = $valor1;
		        $salida->rows[$i]['interno'] = $interno;
		        $conses .= $conse1."|".$unidad."|".$valor."#";
		        $internos .= $interno.",";

			}
	        $i++;
	    }
    }
    $conses = substr($conses,0,-1);
    $internos = substr($internos,0,-1);
    $salida->total = $total;
    $salida->informe = $informe;
	$salida->conses = $conses;
    $salida->internos = $internos;
    $salida->recurso = $recurso;
    $salida->rubro = $rubro;
    $salida->concepto = $concepto;
	echo json_encode($salida);
}
// 02/08/2023 - Ajuste decimales plan y solicutud de recursos
// 29/08/2023 - Ajuste doble informe de autorizacion del mes
?>