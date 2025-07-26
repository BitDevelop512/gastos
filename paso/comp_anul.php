<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$interno = $_POST['interno'];
	$tipo = $_POST['tipo'];
	$ano = $_POST['ano'];
	$unidad = $_POST['unidad'];
	// Se consulta el interno para saber el valor
	if ($tipo == "1")
	{
		$cur1 = odbc_exec($conexion,"SELECT valor, recurso, rubro, periodo, ano, soporte, num_sopo, concepto, cuenta FROM cx_com_ing WHERE ingreso='$interno' AND unidad='$unidad' AND ano='$ano'");
	}
	else
	{
		$cur1 = odbc_exec($conexion,"SELECT valor, recurso, rubro, periodo, ano, soporte, num_sopo, concepto, cuenta, tp_gas, autoriza, concepto1, num_auto, crp, giro, crps, saldos, giros FROM cx_com_egr WHERE egreso='$interno' AND unidad='$unidad' AND ano='$ano'");
	}
	$valor = odbc_result($cur1,1);
	$valor = floatval($valor);
	$recurso = odbc_result($cur1,2);
	$rubro = odbc_result($cur1,3);
	$periodo = odbc_result($cur1,4);
	$ano = odbc_result($cur1,5);
	$soporte = odbc_result($cur1,6);
	$num_sopo = odbc_result($cur1,7);
	$concepto = odbc_result($cur1,8);
	$cuenta = odbc_result($cur1,9);
	// Solo si es egreso
	if ($tipo == "2")
	{
		$tp_gas = odbc_result($cur1,10);
		$autoriza = odbc_result($cur1,11);
		$concepto1 = odbc_result($cur1,12);
		$num_auto = trim(odbc_result($cur1,13));
		$num_autorizaciones = explode(",",$num_auto);
		$crp = odbc_result($cur1,14);
		$giro = odbc_result($cur1,15);
		$crps = trim(odbc_result($cur1,16));
		$saldos = trim(odbc_result($cur1,17));
		$giros = trim(odbc_result($cur1,18));
	}
	// Se actualiza el estado del comprobante
	if ($tipo == "1")
	{
		$query = "UPDATE cx_com_ing  SET estado='A', usua_anu='$usu_usuario', fec_anu=getdate() WHERE ingreso='$interno' AND unidad='$unidad' AND ano='$ano'";
		// Se activa el informe de giro otra vez
		$query2 = "UPDATE cx_inf_gir  SET estado='' WHERE conse='$num_sopo' AND unidad1='$unidad' AND periodo='$periodo' AND ano='$ano' AND estado='I'";
		$sql2 = odbc_exec($conexion, $query2);
	}
	else
	{
		$query = "UPDATE cx_com_egr  SET estado='A', usua_anu='$usu_usuario', fec_anu=getdate() WHERE egreso='$interno' AND unidad='$unidad' AND ano='$ano'";
		// Se devuelve saldo del crp
		if ($unidad == "1")
		{
			if (($concepto == "14") and (($cuenta == "2") or ($cuenta == "3")))
			{
			}
			else
			{
				// Se actualiza el saldo del crp
				$num_crps = explode("|",$crps);
				$num_saldos = explode("|",$saldos);
				for ($i=0;$i<count($num_crps)-1;++$i)
				{
					$val_crp = $num_crps[$i];
					$val_saldo = $num_saldos[$i];
					$val_saldo = floatval($val_saldo);
					// consulta de saldo del crp
					$query8 = "SELECT saldo FROM cx_crp WHERE conse='$val_crp'";
					$cur8 = odbc_exec($conexion, $query8);
					$saldo = odbc_result($cur8,1);
					$saldo1 = $saldo+$val_saldo;
					// Se actualizan saldos de crp
					$query9 = "UPDATE cx_crp SET saldo='$saldo1' WHERE conse='$val_crp'";
					$cur9 = odbc_exec($conexion, $query9);
				}
			}
		}
		// Se actualiza informe de autorizacion
		for ($i=0; $i<count($num_autorizaciones); ++$i)
		{
			$paso = $num_autorizaciones[$i];
			$query3 = "SELECT gastose, unidad1, gastos FROM cx_inf_aut WHERE conse='$paso' AND egreso='$interno' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano'";
			$sql3 = odbc_exec($conexion, $query3);
			$tot3 = odbc_num_rows($sql3);
		    if ($tot3 > 0)
		    {
		    	$unidad1 = odbc_result($sql3,2);
		    	$valor1 = trim(odbc_result($sql3,3));
    			$valor1 = str_replace(',','',$valor1);
    			$valor1 = substr($valor1,0,-3);
    			$valor1 = floatval($valor1);
				// Se limpia campo de pagos
				$query6 = "SELECT pagos FROM cx_inf_aut WHERE egreso='$interno' AND conse='$paso' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano' AND pagose='1'";
				$sql6 = odbc_exec($conexion, $query6);
				$val_pagos = trim(odbc_result($sql6,1));
				if (($val_pagos == "0") or ($val_pagos == "0.00"))
				{
					$query7 = "UPDATE cx_inf_aut SET pagose='0' WHERE conse='$paso' AND periodo='$periodo' AND ano='$ano' AND egreso='$interno' AND pagose='1'";
					$cur7 = odbc_exec($conexion, $query7);
				}
				$query2 = "UPDATE cx_inf_aut SET gastose='0', egreso='0' WHERE egreso='$interno' AND conse='$paso' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano' AND gastose='1'";
				$sql2 = odbc_exec($conexion, $query2);
				// Se reversa valor en cx_val_aut
				if ($concepto == "8")
				{
					$query4 = "SELECT conse, gastos1 FROM cx_val_aut WHERE unidad='$unidad1' AND periodo='$periodo' AND ano='$ano'";
					$sql4 = odbc_exec($conexion, $query4);
					$conse4 = odbc_result($sql4,1);
					$gastos1 = odbc_result($sql4,2);
					$gastos1 = floatval($gastos1);
					$gastos1 = $gastos1-$valor1;
					$query5 = "UPDATE cx_val_aut SET gastose='0', gastos1='$gastos1' WHERE conse='$conse4' AND unidad='$unidad1' AND periodo='$periodo' AND ano='$ano'";
					$sql5 = odbc_exec($conexion, $query5);
				}
		    }
		    else
		    {
				$query3 = "SELECT pagose, unidad1, pagos FROM cx_inf_aut WHERE conse='$paso' AND egreso1='$interno' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano'";
				$sql3 = odbc_exec($conexion, $query3);
		    	$unidad1 = odbc_result($sql3,2);
		    	$valor1 = trim(odbc_result($sql3,3));
    			$valor1 = str_replace(',','',$valor1);
    			$valor1 = substr($valor1,0,-3);
    			$valor1 = floatval($valor1);
				// Se limpia campo de gastos
				$query6 = "SELECT gastos FROM cx_inf_aut WHERE egreso1='$interno' AND conse='$paso' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano' AND gastose='1'";
				$sql6 = odbc_exec($conexion, $query6);
				$val_gastos = trim(odbc_result($sql6,1));
				if (($val_gastos == "0") or ($val_gastos == "0.00"))
				{
					$query7 = "UPDATE cx_inf_aut SET gastose='0' WHERE conse='$paso' AND periodo='$periodo' AND ano='$ano' AND egreso1='$interno' AND gastose='1'";
					$cur7 = odbc_exec($conexion, $query7);
				}
				$query2 = "UPDATE cx_inf_aut SET pagose='0', egreso1='0' WHERE egreso1='$interno' AND conse='$paso' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano' AND pagose='1'";
				$sql2 = odbc_exec($conexion, $query2);
				// Se reversa valor en cx_val_aut
				if ($concepto == "8")
				{
					$query4 = "SELECT conse, pagos1 FROM cx_val_aut WHERE unidad='$unidad1' AND periodo='$periodo' AND ano='$ano'";
					$sql4 = odbc_exec($conexion, $query4);
					$conse4 = odbc_result($sql4,1);
					$pagos1 = odbc_result($sql4,2);
					$pagos1 = floatval($pagos1);
					$pagos1 = $pagos1-$valor1;
					$query5 = "UPDATE cx_val_aut SET pagose='0', pagos1='$pagos1' WHERE conse='$conse4' AND unidad='$unidad1' AND periodo='$periodo' AND ano='$ano'";
					$sql5 = odbc_exec($conexion, $query5);
				}
		    }
		}
	}
	$sql = odbc_exec($conexion, $query);
	// Si es comprobante de egreso de presupuesto basico mensual pdm
	if ($tipo == "2")
	{
		if ($concepto == "8")
		{
			if ($concepto1 == "99")
			{
				for ($i=0; $i<count($num_autorizaciones); ++$i)
				{
					$query = "UPDATE cx_pla_inv SET aprueba='0' WHERE conse='$num_autorizaciones[$i]' AND estado='W' AND periodo='$periodo' AND ano='$ano' AND aprueba='1'";
					$sql = odbc_exec($conexion, $query);
				}
			}
		}
		if ($concepto == "9")
		{
			$query = "UPDATE cx_pla_inv SET estado='L' WHERE conse IN ($num_auto) AND estado='G' AND ano='$ano' AND aprueba='1'";
			$sql = odbc_exec($conexion, $query);
		}
	}
	// Se verifica el estado de anulacion
	if ($tipo == "1")
	{
		$query1 = "SELECT estado FROM cx_com_ing WHERE ingreso='$interno' AND unidad='$unidad' AND ano='$ano'";
	}
	else
	{
		$query1 = "SELECT estado FROM cx_com_egr WHERE egreso='$interno' AND unidad='$unidad' AND ano='$ano'";
	}
	$cur1 = odbc_exec($conexion, $query1);
	$estado = odbc_result($cur1,1);
	// Se consultan saldos de la unidad
	if ($recurso == "1")
	{
		if ($rubro == "1")
		{
			$campo = "s_10_1";
		}
		else
		{
			$campo = "s_10_2";
		}
	}
	if ($recurso == "2")
	{
		if ($rubro == "1")
		{
			$campo = "s_50_1";
		}
		else
		{
			$campo = "s_50_2";
		}
	}
	if ($recurso == "3")
	{
		if ($rubro == "1")
		{
			$campo = "s_16_1";
		}
		else
		{
			$campo = "s_16_2";
		}
	}
	if ($recurso == "4")
	{
		if ($rubro == "1")
		{
			$campo = "s_99_1";
		}
		else
		{
			$campo = "s_99_2";
		}
	}
	// Si es comprobante de egreso de fondo interno - cuenta dtn o fondo interno
	if ($tipo == "2")
	{
		if (($concepto == "14") and (($cuenta == "2") or ($cuenta == "3")))
		{
			if ($cuenta == "2")
			{
				$final = "4";
			}
			if ($cuenta == "3")
			{
				$final = "1";
			}
			$query10 = "UPDATE cx_cue_mov SET estado='A' WHERE egreso='$interno' AND unidad='$unidad' AND ano='$ano' AND inicial='$cuenta' AND final='$final' AND estado=''";
			$sql10 = odbc_exec($conexion, $query10);
			// Se graba log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_cuen_mov.txt", "a");
			fwrite($file, $fec_log." # ".$query10." # ".PHP_EOL);
			fclose($file);
			// Se ingresa valor y resta saldo de la cuenta final
			if ($final == "1")
			{
				$query2 = "SELECT saldo, $campo, dependencia FROM cx_org_sub WHERE subdependencia='$unidad'";
				$cur2 = odbc_exec($conexion, $query2);
				$saldo = odbc_result($cur2,1);
				$saldo1 = odbc_result($cur2,2);
				$saldo2 = $saldo-$valor;
				$saldo3 = $saldo1-$valor;
				$depen = odbc_result($cur2,3);
				// Se actualizan saldos de unidad
				$query3 = "UPDATE cx_org_sub SET saldo='$saldo2', $campo='$saldo3' WHERE subdependencia='$unidad'";
				$cur3 = odbc_exec($conexion, $query3);
			}
			else
			{
				if ($final == "4")
				{
					$query2 = "SELECT saldo FROM cx_ctr_cue WHERE conse='$final' AND unidad='1'";
					$cur2 = odbc_exec($conexion, $query2);
					$saldo = odbc_result($cur2,1);
					$saldo1 = $saldo-$valor;
					// Se actualizan saldos
					$query3 = "UPDATE cx_ctr_cue SET saldo='$saldo1', movimiento=getdate() WHERE conse='$final' AND unidad='1'";
					$cur3 = odbc_exec($conexion, $query3);
				}
			}
		}
	}
	// Se actualiza saldo de la cuenta bancaria
	if ($cuenta == "1")
	{
		$query2 = "SELECT saldo, $campo, dependencia FROM cx_org_sub WHERE subdependencia='$unidad'";
		$cur2 = odbc_exec($conexion, $query2);
		$saldo = odbc_result($cur2,1);
		$saldo1 = odbc_result($cur2,2);
		$depen = odbc_result($cur2,3);
		if ($tipo == "1")
		{
			$saldo2 = $saldo-$valor;
			$saldo3 = $saldo1-$valor;
		}
		else
		{
			$saldo2 = $saldo+$valor;
			$saldo3 = $saldo1+$valor;
		}
		// Se actualizan saldos de unidad
		$query3 = "UPDATE cx_org_sub SET saldo='$saldo2', $campo='$saldo3' WHERE subdependencia='$unidad'";
		$cur3 = odbc_exec($conexion, $query3);
	}
	else
	{
		if (($unidad == "1") or ($unidad == "2"))
		{
			$query2 = "SELECT saldo FROM cx_ctr_cue WHERE conse='$cuenta' AND unidad='1'";
			$cur2 = odbc_exec($conexion, $query2);
			$saldo = odbc_result($cur2,1);
			if ($tipo == "1")
			{
				$saldo1 = $saldo-$valor;
			}
			else
			{
				$saldo1 = $saldo+$valor;
			}
			// Se actualizan saldos
			$query3 = "UPDATE cx_ctr_cue SET saldo='$saldo1', movimiento=getdate() WHERE conse='$cuenta' AND unidad='1'";
			$cur3 = odbc_exec($conexion, $query3);
		}
	}
	if ($tipo == "1")
	{
		// Si es unidad centralizadora
		if ($tpc_usuario == "1")
		{
			// Se actualiza el estado en la tabla valores de giros
			$query4 = "UPDATE cx_val_gir SET estado='' WHERE unidad='$depen' AND total='$valor' AND concepto='$concepto' AND periodo='$periodo' AND ano='$ano' AND inf_giro='$num_sopo'";
			$cur4 = odbc_exec($conexion, $query4);
			// Se actualiza el estado en la tabla valores autorizados
			$query5 = "UPDATE cx_val_aut SET estado='G' WHERE depen='$depen' AND estado='I' AND periodo='$periodo' AND ano='$ano' AND inf_giro='$num_sopo'";
			$cur5 = odbc_exec($conexion, $query5);
		}
	}
	else
	{
		// Si es unidad centralizadora
		if ($tpc_usuario == "1")
		{
			// Se es presupesto basico
			if (($concepto1 == "8") and ($concepto1 == "0"))
			{
				// Se actualiza el estado en la tabla valores autorizados
				if ($tp_gas == "1")
				{
					$query4 = "UPDATE cx_val_aut SET gastose='0' WHERE depen='$depen' AND estado='I' AND periodo='$periodo' AND ano='$ano' AND gastose='1'";
				}
				else
				{
					$query4 = "UPDATE cx_val_aut SET pagose='0' WHERE depen='$depen' AND estado='I' AND periodo='$periodo' AND ano='$ano' AND pagose='1'";
				}
				$cur4 = odbc_exec($conexion, $query4);
			}
		}
	}
	// Presupuesto Adicional
	if (($tipo == "2") and ($concepto == "9"))
	{
		$query4 = "UPDATE cx_val_aut1 SET estado='V', inf_giro='0' WHERE periodo='$periodo' AND ano='$ano' AND estado='G' AND (inf_giro='$giro' OR inf_giro IN ($giros))";
		$cur4 = odbc_exec($conexion, $query4);
	}
	// Recompensas
	if (($tipo == "2") and ($concepto == "10"))
	{
		$query4 = "UPDATE cx_val_aut2 SET pago='0' WHERE ano='$ano' AND estado='I' AND pago='1' AND (inf_giro='$giro' OR inf_giro IN ($giros))";
		$cur4 = odbc_exec($conexion, $query4);
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_comp.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fwrite($file, $fec_log." # ".$query3." # ".PHP_EOL);
	fwrite($file, $fec_log." # ".$query4." # ".PHP_EOL);
	fwrite($file, $fec_log."".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $estado;
	echo json_encode($salida);
}
?>