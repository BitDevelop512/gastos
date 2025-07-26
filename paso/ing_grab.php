<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$origen = $_POST['origen'];
	$origen = iconv("UTF-8", "ISO-8859-1", $origen);
	$mes = $_POST['periodo'];
	$concepto = $_POST['concepto'];
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$valor2 = $_POST['valor2'];
	$cuenta = $_POST['cuenta'];
	$num_cuenta = explode("|", $cuenta);
	$cuenta1 = $num_cuenta[0];
	if (($concepto == "8") or ($concepto == "9") or ($concepto == "10"))
	{
		if ($cuenta1 == "3")
		{
			$valor = $valor2;
		}
		else
		{
			$valor = $valor;	
		}
	}
	else
	{
		$valor = $valor2;
	}
	$soporte = $_POST['soporte'];
	$cdp = $_POST['cdp'];
	$crp = $_POST['crp'];
	$recurso = $_POST['recurso'];
	$rubro = $_POST['rubro'];
	$numero = $_POST['numero'];
	$interno = $_POST['interno'];
	$fecha = $_POST['fecha'];
	$transaccion = $_POST['transaccion'];
	$unidad1 = $_POST['unidad1'];
	$tp_gasto = $_POST['tp_gasto'];
	if (($concepto == "1") or ($concepto == "11") or ($concepto == "16") or ($concepto == "25"))
	{
		$unidad1 = $unidad1;
		$tp_gasto = $tp_gasto;
	}
	else
	{
		$unidad1 = 0;
		$tp_gasto = 0;
	}
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
	$firmas = $firma1."»".$cargo1."|".$firma2."»".$cargo2."|".$firma3."»".$cargo3."|".$firma4."»".$cargo4;
	$firmas = encrypt1($firmas, $llave);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$ciudad = $_POST['ciudad'];
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	// Se consulta el numero de ingreso a asignar
	$pregunta = "SELECT com_ing FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
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
		$consecu = odbc_result($cur,1);
		$consecu = $consecu+1;
		// Se actualiza ingreso de unidad centralizadora
		$cur0 = odbc_exec($conexion,"UPDATE cx_org_sub SET com_ing='$consecu' WHERE subdependencia='$uni_usuario'");
		// Se graba comprobante
		$query = "INSERT INTO cx_com_ing (ingreso, usuario, unidad, periodo, ano, tipo, valor, concepto, recurso, rubro, soporte, num_sopo, fec_sopo, transferencia, firmas, ciudad, origen, cdp, crp, unidad1, gasto, cuenta) VALUES ('$consecu', '$usuario', '$unidad', '$mes', '$ano', '$tipo', '$valor', '$concepto', '$recurso', '$rubro', '$soporte', '$numero', '$fecha', '$transaccion', '$firmas', '$ciudad', '$origen', '$cdp', '$crp', '$unidad1', '$tp_gasto', '$cuenta1')";
		$sql = odbc_exec($conexion, $query);
		$query1 = "SELECT ingreso FROM cx_com_ing WHERE ingreso='$consecu'";
		$cur1 = odbc_exec($conexion, $query1);
		$conse = odbc_result($cur1,1);
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
		if ($cuenta1 == "1")
		{
			$query2 = "SELECT saldo, $campo, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
			$cur2 = odbc_exec($conexion, $query2);
			$saldo = odbc_result($cur2,1);
			$saldo1 = odbc_result($cur2,2);
			$saldo2 = $saldo+$valor;
			$saldo3 = $saldo1+$valor;
			$depen = odbc_result($cur2,3);
			// Se actualizan saldos de unidad
			$query3 = "UPDATE cx_org_sub SET saldo='$saldo2', $campo='$saldo3' WHERE subdependencia='$uni_usuario'";
			$cur3 = odbc_exec($conexion, $query3);
		}
		else
		{
			if (($uni_usuario == "1") or ($uni_usuario == "2"))
			{
				$query2 = "SELECT saldo FROM cx_ctr_cue WHERE conse='$cuenta1' AND unidad='1'";
				$cur2 = odbc_exec($conexion, $query2);
				$saldo = odbc_result($cur2,1);
				$saldo1 = $saldo+$valor;
				// Se actualizan saldos
				$query3 = "UPDATE cx_ctr_cue SET saldo='$saldo1', movimiento=getdate() WHERE conse='$cuenta1' AND unidad='1'";
				$cur3 = odbc_exec($conexion, $query3);
			}
		}
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_sal_cue.txt", "a");
		fwrite($file, $fec_log." # ".$query3." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
		// Se actualiza el estado en la tabla de informe de giro
		if ($concepto == "9")
		{
			$query4 = "UPDATE cx_inf_gir SET estado='I' WHERE total='$valor' AND concepto='$concepto' AND ano='$ano' AND conse='$interno'";
		}
		else
		{
			$query4 = "UPDATE cx_inf_gir SET estado='I' WHERE total='$valor' AND concepto='$concepto' AND periodo='$mes' AND ano='$ano' AND conse='$interno'";
		}
		$cur4 = odbc_exec($conexion, $query4);
		// Se actualiza el estado en la tabla valores autorizados
		if ($concepto == "9")
		{
			$query5 = "UPDATE cx_val_aut1 SET estado='I' WHERE estado='G' AND ano='$ano' AND inf_giro='$interno'";
		}
		else
		{
			if ($concepto == "10")
			{
				$query5 = "UPDATE cx_val_aut2 SET estado='I' WHERE estado='G' AND periodo='$mes' AND ano='$ano' AND inf_giro='$interno'";
			}
			else
			{
				$query5 = "UPDATE cx_val_aut SET estado='I' WHERE estado='G' AND periodo='$mes' AND ano='$ano' AND inf_giro='$interno'";
			}
		}
		$cur5 = odbc_exec($conexion, $query5);
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_val_aut_ing.txt", "a");
		fwrite($file, $fec_log." # ".$query5." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
		if ($uni_usuario == "1")
		{
			// Se actualiza el saldo del crp
			$query8 = "SELECT saldo FROM cx_crp WHERE conse='$crp'";
			$cur8 = odbc_exec($conexion, $query8);
			$saldo = odbc_result($cur8,1);
			$saldo1 = $saldo+$valor;
			// Se actualizan saldos de crp
			$query9 = "UPDATE cx_crp SET saldo='$saldo1' WHERE conse='$crp'";
			//$cur9 = odbc_exec($conexion, $query9);
		}
		// Se actualizan firmas
		$query6 = "UPDATE cx_org_sub SET firma1='$firma1', firma2='$firma2', firma3='$firma3', cargo1='$cargo1', cargo2='$cargo2', cargo3='$cargo3' WHERE subdependencia='$uni_usuario'";
		$sql6 = odbc_exec($conexion, $query6);
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_comp.txt", "a");
		fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
?>