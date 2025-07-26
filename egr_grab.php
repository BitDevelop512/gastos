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
	$mes = $_POST['periodo'];
	$concepto = $_POST['concepto'];
	$tp_gasto = $_POST['tp_gasto'];
	$recurso = $_POST['recurso'];
	$rubro = $_POST['rubro'];
	$autoriza = $_POST['autoriza'];
	$num_gir = $_POST['num_gir'];
	$num_aut = $_POST['num_aut'];
	$num_autorizaciones = explode(",",$num_aut);
	$num_aut = iconv("UTF-8", "ISO-8859-1", $num_aut);
	$dat_aut = $_POST['dat_aut'];
	$soporte = $_POST['soporte'];
	$num_sop = $_POST['num_sop'];
	$num_sop = iconv("UTF-8", "ISO-8859-1", $num_sop);
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$unidad1 = $_POST['unidad1'];
	$pago = $_POST['pago'];
	$cash = $_POST['cash'];
	$chequera = $_POST['chequera'];
	$cuenta = $_POST['cuenta'];
	$num_cuenta = explode("|", $cuenta);
	$cuenta1 = trim($num_cuenta[0]);
	if (($cuenta1 == "0") or ($cuenta1 == ""))
	{
		$cuenta1 = "1";
	}
	$datos = $_POST['datos'];
	$datos = encrypt1($datos, $llave);
	$firma1 = $_POST['firma1'];
	$firma1 = iconv("UTF-8", "ISO-8859-1", $firma1);
	$firma2 = $_POST['firma2'];
	$firma2 = iconv("UTF-8", "ISO-8859-1", $firma2);
	$firma3 = $_POST['firma3'];
	$firma3 = iconv("UTF-8", "ISO-8859-1", $firma3);
	$firma4 = $_POST['firma4'];
	$firma4 = iconv("UTF-8", "ISO-8859-1", $firma4);
	$cargo1 = $_POST['cargo1'];
	$cargo1 = iconv("UTF-8", "ISO-8859-1", $cargo1);
	$cargo2 = $_POST['cargo2'];
	$cargo2 = iconv("UTF-8", "ISO-8859-1", $cargo2);
	$cargo3 = $_POST['cargo3'];
	$cargo3 = iconv("UTF-8", "ISO-8859-1", $cargo3);
	$cargo4 = $_POST['cargo4'];
	$cargo4 = iconv("UTF-8", "ISO-8859-1", $cargo4);
	$reviso = $_POST['reviso'];
	$reviso = iconv("UTF-8", "ISO-8859-1", $reviso);
	$firmas = $firma1."»".$cargo1."|".$firma2."»".$cargo2."|".$firma3."»".$cargo3."|".$firma4."»".$cargo4."|".$reviso;
	$firmas = encrypt1($firmas, $llave);
	$unidades = $_POST['unidades'];
	$descrip = $_POST['descrip'];
	$descrip = iconv("UTF-8", "ISO-8859-1", $descrip);
	$ciu_usuario = iconv("UTF-8", "ISO-8859-1", $ciu_usuario);
	if (($concepto == "98") or ($concepto == "99"))
	{
		$concepto1 = $concepto;
		$concepto = "8";
	}
	else
	{
		$concepto1 = "0";
		$concepto = $concepto;
	}
	if ($uni_usuario == "1")
	{
		$crp = $_POST['crp'];
		$cdp = $_POST['cdp'];
		$cantidad = $_POST['cantidad'];
		$crps = trim($_POST['crps']);
		$crps1 = $crp."|".$crps;
		$saldo = $_POST['saldo'];
		$saldos = trim($_POST['saldos']);
		$saldos1 = $saldo."|".$saldos;
		$num_crps = explode("|",$crps);
		for ($i=0;$i<count($num_crps);++$i)
		{
			$y[$i] = trim($num_crps[$i]);
		}
		$num_saldos = explode("|",$saldos);
		for ($i=0;$i<count($num_saldos);++$i)
		{
			$z[$i] = trim($num_saldos[$i]);
		}
	}
	else
	{
		$crp = "0";
		$cdp = "0";
		$crps1 = "";
		$saldos1 = "";
	}
	if ($concepto1 == "99")
	{
		$crp = $_POST['crp1'];
		$cdp = $_POST['cdp1'];
	}
	if ($concepto1 == "98")
	{
		$unidad1 = $_POST['unidad1'];
	}
	else
	{
		$unidad1 = "0";
	}
	$valida = $_POST['valida'];
	$siglas = $_POST['siglas'];
	$siglas = substr($siglas,0,-1);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$ciudad = $_POST['ciudad'];
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	$uni_usuario = $unidad;
	$error = 0;
	// Se consulta el numero de egreso a asignar
	$pregunta = "SELECT com_egr FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
	if (!odbc_exec($conexion, $pregunta))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
		$cur = odbc_exec($conexion, $pregunta);
	}
	if ($confirma == "0")
	{
		$conse = "0";
	}
	else
	{
		// Se verifica para no grabar doble egreso
		$consu = "SELECT TOP 1 fecha FROM cx_com_egr WHERE usuario='$usuario' AND unidad='$unidad' AND periodo='$mes' AND ano='$ano' AND tipo='$tipo' AND total='$valor1' AND concepto='$concepto' AND tp_gas='$tp_gasto' ORDER BY fecha DESC";
		$sql = odbc_exec($conexion, $consu);
		$v_fecha1 = odbc_result($sql,1);
		$v_fecha1 = substr($v_fecha1,0,15);
		$v_fecha2 = date("Y-m-d H:i");
		$v_fecha2 = substr($v_fecha2,0,-1);
		if ($v_fecha1 == $v_fecha2)
		{
			$conse2 = 0;
			$interno = 0;
			$error = "1";
			// Se graba log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_egreso_doble.txt", "a");
			fwrite($file, $fec_log." # ".$v_fecha1." # ".$v_fecha2." # ".$consu." # ".PHP_EOL);
			fclose($file);
		}
		else
		{
			$consecu = odbc_result($cur,1);
			$consecu = $consecu+1;
			// Se actualiza egreso de unidad centralizadora
			$cur0 = odbc_exec($conexion,"UPDATE cx_org_sub SET com_egr='$consecu' WHERE subdependencia='$uni_usuario'");
			// Se graba comprobante
			$query = "INSERT INTO cx_com_egr (egreso, usuario, unidad, periodo, ano, tipo, valor, subtotal, total, neto, concepto, tp_gas, recurso, rubro, autoriza, num_auto, soporte, num_sopo, pago, det_pago, datos, firmas, ciudad, unidad1, concepto1, descripcio, cdp, crp, giro, cuenta, crps, saldos, giros) VALUES ('$consecu', '$usuario', '$unidad', '$mes', '$ano', '$tipo', '$valor1', '$valor1', '$valor1', '$valor1', '$concepto', '$tp_gasto', '$recurso', '$rubro', '$autoriza', '$num_aut', '$soporte', '$num_sop', '$pago', '$cash', '$datos', '$firmas', '$ciudad', '$unidad1', '$concepto1', '$descrip', '$cdp', '$crp', '$num_gir', '$cuenta1', '$crps1', '$saldos1', '')";
			$sql = odbc_exec($conexion, $query);
			$query1 = "SELECT egreso FROM cx_com_egr WHERE egreso='$consecu' AND ano='$ano'";
			$cur1 = odbc_exec($conexion, $query1);
			$conse = odbc_result($cur1,1);
			// Si es presupuesto mensual
			if ($concepto == "8")
			{
				if (($concepto1 == "98") or ($concepto1 == "99"))
				{
				}
				else
				{
					$v_finaliza = "0";
					// Se consulta el valor ya girado en egresos anteriores
					if ($tp_gasto == "1")
					{
						// Se actualiza el egreso en el informe de autorizacion
						$query11 = "UPDATE cx_inf_aut SET egreso='$conse', gastose='1' WHERE conse IN ($num_aut) AND periodo='$mes' AND ano='$ano'";
						$cur11 = odbc_exec($conexion, $query11);
						// Se valida tabla val_aut
						$num_datos = explode("#",$dat_aut);
						for ($i=0;$i<count($num_datos);++$i)
						{
							$a[$i] = trim($num_datos[$i]);
							$num_valores = explode("|",$a[$i]);
							for ($m=0;$m<(count($num_valores)-1);++$m)
							{
								$v1 = trim($num_valores[0]);		// Interno
								$v2 = trim($num_valores[1]);		// Unidad
								$v3 = trim($num_valores[2]);		// Valor
								$v3 = intval($v3);
							}
							$query12 = "SELECT gastos, gastos1 FROM cx_val_aut WHERE conse='$v1' AND unidad='$v2'";
							$cur12 = odbc_exec($conexion, $query12);
							$v_gastos = odbc_result($cur12,1);
							$v_gastos = intval($v_gastos);
							$v_gastos1 = odbc_result($cur12,2);
							$v_gastos1 = intval($v_gastos1);
							$v_gastos1 = $v_gastos1+$v3;
							$v_gastos2 = $v_gastos-$v_gastos1;
							$query13 = "UPDATE cx_val_aut SET gastos1='$v_gastos1' WHERE conse='$v1' AND unidad='$v2'";
							$cur13 = odbc_exec($conexion, $query13);
							if ($v_gastos2 == "0")
							{
								$query2 = "UPDATE cx_val_aut SET gastose='1' WHERE periodo='$mes' AND ano='$ano' AND estado='I' AND conse='$v1' AND unidad='$v2'";
								$cur2 = odbc_exec($conexion, $query2);
							}
						}
						// Se actualiza el egreso en el informe de autorizacion sino tiene pagos
						$query14 = "SELECT pagos FROM cx_inf_aut WHERE conse IN ($num_aut) AND periodo='$mes' AND ano='$ano' AND egreso='$conse' AND gastose='1'";
						$cur14 = odbc_exec($conexion, $query14);
						$val_pagos = trim(odbc_result($cur14,1));
						if (($val_pagos == "0") or ($val_pagos == "0.00"))
						{
							$query15 = "UPDATE cx_inf_aut SET pagose='1' WHERE conse IN ($num_aut) AND periodo='$mes' AND ano='$ano' AND egreso='$conse' AND gastose='1' AND pagos='0'";
							$cur15 = odbc_exec($conexion, $query15);
						}
					}
					else
					{
						// Se actualiza el egreso en el informe de autorizacion
						$query11 = "UPDATE cx_inf_aut SET egreso1='$conse', pagose='1' WHERE conse IN ($num_aut) AND periodo='$mes' AND ano='$ano'";
						$cur11 = odbc_exec($conexion, $query11);
						// Se valida tabla val_aut
						$num_datos = explode("#",$dat_aut);
						for ($i=0;$i<count($num_datos);++$i)
						{
							$a[$i] = trim($num_datos[$i]);
							$num_valores = explode("|",$a[$i]);
							for ($m=0;$m<(count($num_valores)-1);++$m)
							{
								$v1 = trim($num_valores[0]);		// Interno
								$v2 = trim($num_valores[1]);		// Unidad
								$v3 = trim($num_valores[2]);		// Valor
								$v3 = intval($v3);
							}
							$query12 = "SELECT pagos, pagos1 FROM cx_val_aut WHERE conse='$v1' AND unidad='$v2'";
							$cur12 = odbc_exec($conexion, $query12);
							$v_pagos = odbc_result($cur12,1);
							$v_pagos = intval($v_pagos);
							$v_pagos1 = odbc_result($cur12,2);
							$v_pagos1 = intval($v_pagos1);
							$v_pagos1 = $v_pagos1+$v3;
							$v_pagos2 = $v_pagos-$v_pagos1;
							$query13 = "UPDATE cx_val_aut SET pagos1='$v_pagos1' WHERE conse='$v1' AND unidad='$v2'";
							$cur13 = odbc_exec($conexion, $query13);
							if ($v_pagos2 == "0")
							{
								$query2 = "UPDATE cx_val_aut SET pagose='1' WHERE periodo='$mes' AND ano='$ano' AND estado='I' AND conse='$v1' AND unidad='$v2'";
								$cur2 = odbc_exec($conexion, $query2);
							}
						}
						// Se actualiza el egreso en el informe de autorizacion sino tiene gastos
						$query14 = "SELECT gastos FROM cx_inf_aut WHERE conse IN ($num_aut) AND periodo='$mes' AND ano='$ano' AND egreso1='$conse' AND pagose='1'";
						$cur14 = odbc_exec($conexion, $query14);
						$val_gastos = trim(odbc_result($cur14,1));
						if (($val_gastos == "0") or ($val_gastos == "0.00"))
						{
							$query15 = "UPDATE cx_inf_aut SET gastose='1' WHERE conse IN ($num_aut) AND periodo='$mes' AND ano='$ano' AND egreso1='$conse' AND pagose='1' AND gastos='0'";
							$cur15 = odbc_exec($conexion, $query15);
						}
					}
					// Se graba log
				    $fec_log = date("d/m/Y H:i:s a");
				    $file = fopen("log_egre_inf.txt", "a");
				    fwrite($file, $fec_log." # ".$query11." # ".PHP_EOL);
				    fwrite($file, $fec_log." # ".$query15." # ".PHP_EOL);
				    fwrite($file, $fec_log."  ".PHP_EOL);
				    fclose($file);
				}
			}
			// Si es recurso adicional
			if ($concepto == "9")
			{
				// Se cambia estado en la tabla de autorizaciones cx_val_aut
				if ($tp_gasto == "1")
				{
					$query3 = "UPDATE cx_val_aut1 SET gastose='1' WHERE ano='$ano' AND estado IN ('I','V','G') AND solicitud IN ($num_aut)";
				}
				else
				{
					$query3 = "UPDATE cx_val_aut1 SET pagose='1' WHERE ano='$ano' AND estado IN ('I','V','G') AND solicitud IN ($num_aut)";
				}
				$cur3 = odbc_exec($conexion, $query3);
			}
			// Si es recompensa
			if ($concepto == "10")
			{
				$query3 = "UPDATE cx_val_aut2 SET pago='1' WHERE total='$valor1' AND ano='$ano' AND estado='I' AND inf_giro='$num_aut'";
				$cur3 = odbc_exec($conexion, $query3);
				// Si son mas de 1 beneficiario en el pago de la recompensa
				$query16 = "SELECT SUM(total) AS total FROM cx_com_egr WHERE concepto='10' AND unidad='$unidad' AND estado='' AND giro='$num_aut' AND ano='$ano'";
				$cur16 = odbc_exec($conexion, $query16);
				$valor2 = odbc_result($cur16,1);
				if ($valor2 > $valor1)
				{
					$query17 = "SELECT conse FROM cx_inf_gir WHERE numero='$num_aut' AND ano='$ano'";
					$cur17 = odbc_exec($conexion, $query17);
					$valor3 = odbc_result($cur17,1);
					$query3 = "UPDATE cx_val_aut2 SET pago='1' WHERE total='$valor2' AND ano='$ano' AND estado='I' AND inf_giro='$valor3'";
					$cur3 = odbc_exec($conexion, $query3);
				}
			}
			// Se consultan saldos de la unidad
			if ($recurso == "1")
			{
				if ($rubro == "3")
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
				if ($rubro == "3")
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
				if ($rubro == "3")
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
				if ($rubro == "3")
				{
					$campo = "s_99_1";
				}
				else
				{
					$campo = "s_99_2";
				}
			}
			// Si es fondo interno - cuenta dtn o fondo interno
			if (($concepto == "14") and (($cuenta1 == "2") or ($cuenta1 == "3")))
			{
				if ($cuenta1 == "2")
				{
					$final = "4";
				}
				if ($cuenta1 == "3")
				{
					$final = "1";
				}
				$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_cue_mov)";
				$query11 = "INSERT INTO cx_cue_mov (conse, usuario, unidad, periodo, ano, egreso, inicial, final, valor, valor1) VALUES ($query_c, '$usuario', '$unidad', '$mes', '$ano', '$consecu', '$cuenta1', '$final', '$valor', '$valor1')";
				$sql11 = odbc_exec($conexion, $query11);
				// Se graba log
				$fec_log = date("d/m/Y H:i:s a");
				$file = fopen("log_cuen_mov.txt", "a");
				fwrite($file, $fec_log." # ".$query11." # ".PHP_EOL);
				fclose($file);
				// Se ingresa valor y suma saldo de la cuenta final
				if ($final == "1")
				{
					$query2 = "SELECT saldo, $campo, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
					$cur2 = odbc_exec($conexion, $query2);
					$saldo = odbc_result($cur2,1);
					$saldo1 = odbc_result($cur2,2);
					$saldo2 = $saldo+$valor1;
					$saldo3 = $saldo1+$valor1;
					$depen = odbc_result($cur2,3);
					// Se actualizan saldos de unidad
					$query3 = "UPDATE cx_org_sub SET saldo='$saldo2', $campo='$saldo3' WHERE subdependencia='$uni_usuario'";
					$cur3 = odbc_exec($conexion, $query3);
				}
				else
				{
					if ($final == "4")
					{
						$query2 = "SELECT saldo FROM cx_ctr_cue WHERE conse='$final' AND unidad='1'";
						$cur2 = odbc_exec($conexion, $query2);
						$saldo = odbc_result($cur2,1);
						$saldo1 = $saldo+$valor1;
						// Se actualizan saldos
						$query3 = "UPDATE cx_ctr_cue SET saldo='$saldo1', movimiento=getdate() WHERE conse='$final' AND unidad='1'";
						$cur3 = odbc_exec($conexion, $query3);
					}
				}
			}
			if ($cuenta1 == "1")
			{
				$query3 = "SELECT saldo, $campo, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
				$cur3 = odbc_exec($conexion, $query3);
				$saldo = odbc_result($cur3,1);
				$saldo1 = odbc_result($cur3,2);
				$saldo2 = $saldo-$valor1;
				$saldo3 = $saldo1-$valor1;
				$depen = odbc_result($cur2,3);
				// Se actualizan saldos de unidad
				$query4 = "UPDATE cx_org_sub SET saldo='$saldo2', $campo='$saldo3' WHERE subdependencia='$uni_usuario'";
				$cur4 = odbc_exec($conexion, $query4);
			}
			else
			{
				if (($uni_usuario == "1") or ($uni_usuario == "2"))
				{
					$query3 = "SELECT saldo FROM cx_ctr_cue WHERE conse='$cuenta1' AND unidad='1'";
					$cur3 = odbc_exec($conexion, $query3);
					$saldo = odbc_result($cur3,1);
					$saldo1 = $saldo-$valor1;
					// Se actualizan saldos
					$query4 = "UPDATE cx_ctr_cue SET saldo='$saldo1', movimiento=getdate() WHERE conse='$cuenta1' AND unidad='1'";
					$cur4 = odbc_exec($conexion, $query4);
				}
			}
			if ($pago == "2")
			{
				$query5 = "UPDATE cx_org_sub SET cheque='$chequera' WHERE subdependencia='$uni_usuario'";
				$cur5 = odbc_exec($conexion, $query5);
			}
			// Se actualiza estado en solicitud de recursos
			if ($concepto == "9")
			{
				$query6 = "UPDATE cx_pla_inv SET estado='G' WHERE conse IN ($num_aut) AND tipo='2' AND ano='$ano'";
				$cur6 = odbc_exec($conexion, $query6);
			}
			// Se actualiza estado en solicitud de recursos para gastos en actividades de inteligencia y contrainteligencia
			if ($concepto == "3")
			{
				$query6 = "UPDATE cx_pla_inv SET estado='G', aprueba='1' WHERE conse='$num_aut' AND tipo='2' AND ano='$ano'";
				$cur6 = odbc_exec($conexion, $query6);
			}
			// Se actualiza aprueba si es comprobante egreso pdm
			$conse = intval($conse);
			if ($conse > 0)
			{
				if ($concepto1 == "99")
				{
					if ($valida == "1")
					{
						$query7 = "UPDATE cx_pla_inv SET aprueba='1', estado='W' WHERE conse='$num_aut' AND tipo='2' AND ano='$ano'";
						$cur7 = odbc_exec($conexion, $query7);
					}
					else
					{
						for ($i=0;$i<count($num_autorizaciones);++$i)
						{
							$query7 = "UPDATE cx_pla_inv SET aprueba='1' WHERE conse='$num_autorizaciones[$i]' AND tipo='2' AND ano='$ano'";
							$cur7 = odbc_exec($conexion, $query7);
						}
					}
				}
			}
			if ($uni_usuario == "1")
			{
				if (($concepto == "14") and (($cuenta1 == "2") or ($cuenta1 == "3")))
				{
				}
				else
				{
					// Se actualiza el saldo del crp
					$query8 = "SELECT saldo FROM cx_crp WHERE conse='$crp'";
					$cur8 = odbc_exec($conexion, $query8);
					$saldo = odbc_result($cur8,1);
					$saldo1 = $saldo-$valor1;
					// Se actualizan saldos de crp
					$query9 = "UPDATE cx_crp SET saldo='$saldo1' WHERE conse='$crp'";
					$cur9 = odbc_exec($conexion, $query9);
					// Varios CRP
					if ($concepto1 == "99")
					{
						if ($cantidad > 0)
						{
							for ($i=0;$i<(count($num_crps)-1);++$i)
							{
								$query10 = "SELECT saldo FROM cx_crp WHERE conse='$y[$i]'";
								$cur10 = odbc_exec($conexion, $query10);
								$saldo = odbc_result($cur10,1);
								$saldo1 = $saldo-$z[$i];
								// Se actualizan saldos de crp
								$query11 = "UPDATE cx_crp SET saldo='$saldo1' WHERE conse='$y[$i]'";
								$cur11 = odbc_exec($conexion, $query11);
							}
						}
					}
				}
			}
			// Se actualizan firmas
			$query10 = "UPDATE cx_org_sub SET firma1='$firma1', firma2='$firma2', firma3='$firma3', cargo1='$cargo1', cargo2='$cargo2', cargo3='$cargo3' WHERE subdependencia='$uni_usuario'";
			$sql10 = odbc_exec($conexion, $query10);
			// Se graba log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_comp_egre.txt", "a");
			fwrite($file, $fec_log." # ".$query." # ".$query10." # ".PHP_EOL);
			fclose($file);
		}
	}
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->salida1 = $error;
	echo json_encode($salida);
}
// 18/08/2023 - Ajuste y verificación no grabar doble egreso
// 27/09/2023 - Validacion doble grabacion
// 16/07/2024 - Ajuste para cuando la cuenta llega en 0 se cambia por 1
// 22/07/2024 - Ajuste para cuando la cuenta llega con valor nulo
?>