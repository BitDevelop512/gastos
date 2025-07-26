<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
  	$query = "SELECT firma1, firma2, firma3, firma4, cargo1, cargo2, cargo3, cargo4, unidad, dependencia, saldo, cheque FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  	$cur = odbc_exec($conexion, $query);
  	$firma1 = trim(utf8_encode(odbc_result($cur,1)));
  	$firma1 = iconv("UTF-8", "ISO-8859-1", $firma1);
  	$firma2 = trim(utf8_encode(odbc_result($cur,2)));
  	$firma2 = iconv("UTF-8", "ISO-8859-1", $firma2);
  	$firma3 = trim(utf8_encode(odbc_result($cur,3)));
  	$firma3 = iconv("UTF-8", "ISO-8859-1", $firma3);
  	$firma4 = trim(utf8_encode(odbc_result($cur,4)));
  	$firma4 = iconv("UTF-8", "ISO-8859-1", $firma4);
  	$cargo1 = trim(utf8_encode(odbc_result($cur,5)));
  	$cargo1 = iconv("UTF-8", "ISO-8859-1", $cargo1);
  	$cargo2 = trim(utf8_encode(odbc_result($cur,6)));
  	$cargo2 = iconv("UTF-8", "ISO-8859-1", $cargo2);
  	$cargo3 = trim(utf8_encode(odbc_result($cur,7)));
  	$cargo3 = iconv("UTF-8", "ISO-8859-1", $cargo3);
  	$cargo4 = trim(utf8_encode(odbc_result($cur,8)));
  	$cargo4 = iconv("UTF-8", "ISO-8859-1", $cargo4);
	$firma5 = $nom_usuario;
	$firma5 = iconv("UTF-8", "ISO-8859-1", $firma5);
	$cargo5 = $car_usuario;
	$cargo5 = iconv("UTF-8", "ISO-8859-1", $cargo5);
	$firmas = $firma1."»".$cargo1."|".$firma2."»".$cargo2."|".$firma3."»".$cargo3."|".$firma5."»".$cargo5;
	$firmas = encrypt1($firmas, $llave);
	// Valores recibidos
	$periodo = $_POST['periodo'];
	$periodo1 = $n_meses[$periodo-1];
	$mes = $_POST['mes'];
	$ano = $_POST['ano'];
	$unidades = $_POST['unidades'];
	$cuenta = $_POST['cuenta'];
	$num_cuenta = explode("|", $cuenta);
	$cuenta1 = $num_cuenta[0];
	$gastos = $_POST['gastos'];
	$pagos = $_POST['pagos'];
	$total = $_POST['total'];
	$total1 = $_POST['total1'];
	$crp = $_POST['crp'];
	$saldor = $_POST['saldo'];
	$cdp = $_POST['cdp'];
	$recurso = $_POST['recurso'];
	$rubro = $_POST['rubro'];
	$concepto = $_POST['concepto'];
	$concepto1 = $_POST['concepto1'];
	$cash = $_POST['cash'];
	$conses1 = $_POST['conses1'];
	$conses2 = $conses1;
	$conses2 = str_replace("|", ",", $conses2);
	$conses2 = substr($conses2,0,-1);
	$unidades1 = $_POST['unidades1'];
	$siglas1 = $_POST['siglas1'];
	$gastos1 = $_POST['gastos1'];
	$pagos1 = $_POST['pagos1'];
	$totales1 = $_POST['totales1'];
	$cantidad = $_POST['cantidad'];
	$crps = trim($_POST['crps']);
	$crps1 = $crp."|".$crps;
	$saldos = trim($_POST['saldos']);
	$saldos1 = $saldor."|".$saldos;
	$paso1 = $_POST['paso1'];
	$paso2 = $_POST['paso2'];
	$soporte = $_POST['soporte'];
	$firma = $_POST['firma'];
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$ciudad = $_POST['ciudad'];
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	$v_datos1 = "";
	$v_datos2 = "";
	$num_unidades = explode("|",$unidades1);
	for ($i=0;$i<count($num_unidades);++$i)
	{
		$a[$i] = trim($num_unidades[$i]);
	}
	$num_siglas = explode("|",$siglas1);
	for ($i=0;$i<count($num_siglas);++$i)
	{
		$b[$i] = trim($num_siglas[$i]);
	}
	$num_gastos = explode("|",$gastos1);
	for ($i=0;$i<count($num_gastos);++$i)
	{
		$c[$i] = trim($num_gastos[$i]);
	}
	$num_pagos = explode("|",$pagos1);
	for ($i=0;$i<count($num_pagos);++$i)
	{
		$d[$i] = trim($num_pagos[$i]);
	}
	$num_totales = explode("|",$totales1);
	for ($i=0;$i<count($num_totales);++$i)
	{
		$e[$i] = trim($num_totales[$i]);
	}
	$num_conses = explode("|",$conses1);
	for ($i=0;$i<count($num_conses);++$i)
	{
		$f[$i] = trim($num_conses[$i]);
	}
	$num_crps = explode("|",$crps);
	for ($i=0;$i<count($num_crps);++$i)
	{
		$g[$i] = trim($num_crps[$i]);
	}
	$num_saldos = explode("|",$saldos);
	for ($i=0;$i<count($num_saldos);++$i)
	{
		$h[$i] = trim($num_saldos[$i]);
	}
	// Se parte cadena para obtener dependencia y valores
	$sigue = "0";
	$conses = "";
	$consecus = "";
	$paso_dato = "";
	$num_aut3 = "";
	$num_paso2 = explode("#",$paso2);
	for ($k=0;$k<(count($num_paso2)-1);++$k)
	{
		$v[$k] = $num_paso2[$k];
		$num_valores1 = explode("|",$v[$k]);
		$v1 = $num_valores1[0];
		$consu = "SELECT subdependencia, sigla, unidad, especial FROM cx_org_sub WHERE dependencia='$v1' AND unic='1'";
		$cur0 = odbc_exec($conexion, $consu);
		$tot = odbc_num_rows($cur0);
		if (($tot == "0") and ($concepto == "10"))
		{
			$consu = "SELECT subdependencia, sigla, unidad FROM cx_org_sub WHERE dependencia='$v1' AND unic='2'";
			$cur0 = odbc_exec($conexion, $consu);
			$uni = odbc_result($cur0,3);
			$consu = "SELECT subdependencia, sigla, unidad FROM cx_org_sub WHERE unidad='$uni' AND unic='1'";
			$cur0 = odbc_exec($conexion, $consu);
		}
		$uni = odbc_result($cur0,1);
		$n_uni = trim(odbc_result($cur0,2));
		$div = odbc_result($cur0,3);
		$n_esp = odbc_result($cur0,4);
		if ($n_esp == "0")
		{
			$n_uni1 = $n_uni;
		}
		else
		{
			$consu = "SELECT sigla FROM cx_org_sub WHERE unidad='$n_esp' AND unic='1'";
			$cur0 = odbc_exec($conexion, $consu);
			$n_uni1 = trim(odbc_result($cur0,1));
		}
		$v2 = $num_valores1[1];
		$v3 = $num_valores1[2];
		$v4 = $num_valores1[3];
		$v5 = $num_valores1[4];
		$v6 = $v1.$v2.$v3.$v4;
		$v7 = $v2."|".$v5;
		$v8 =  number_format($v5, 2);
		$datos = encrypt1($v7, $llave);
		// Se incluye nuevo
		$paso_dato .= trim($n_uni1)."|".$v8."#";
		// Se consulta el consecutivo del numero informe de giro del año
		$cur7 = odbc_exec($conexion,"SELECT isnull(max(numero),0)+1 AS numero FROM cx_inf_gir WHERE ano='$ano'");
		$numero = odbc_result($cur7,1);
		// Se consulta el consecutivo del informe de giro
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_inf_gir");
		$consecu = odbc_result($cur1,1);
		// Se graba informe de giro por unidad centralizadora
		$graba = "INSERT INTO cx_inf_gir (conse, usuario, unidad, periodo, ano, unidad1, n_unidad, gastos, pagos, total, crp, cdp, recurso, rubro, concepto, cash, firma, firma1, firma2, cuenta, crps, saldos, numero) VALUES ('$consecu', '$usuario', '$unidad', '$periodo', '$ano', '$uni', '$n_uni', '$v3', '$v4', '$v5', '$crp', '$cdp', '$recurso', '$rubro', '$concepto', '$cash', '$firma', '$firma3', '$firma5', '$cuenta1', '$crps1', '$saldos1', '$numero')";
		odbc_exec($conexion, $graba);
		// Se crea notificacion
		$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$notifi = odbc_result($cur2,1);
		$valor1 = $consecu.",".$periodo.",".$ano;
		$visualiza = '<button type="button" name="informe" id="informe" class="btn btn-block btn-primary btn-mensaje1" onclick="link3('.$valor1.');"><font face="Verdana" size="3">Visualizar Informe de Giro</font></button>';
		$mensaje = "<br>SE HA GENERADO EL INFORME DE GIRO POR CONCEPTO DE ".$concepto1." PARA EL MES DE ".$mes." DE ".$ano." CON EL NUMERO ".$numero." POR UN VALOR DE ".number_format($v5,2)."<br><br>".$visualiza."<br>";
		$sustituye = array ('01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9');
  		$n_uni1 = strtr(trim($n_uni), $sustituye);
		$usuario1 = "SGA_".$n_uni1;
		// Se valida si existe el usuario o cambiar SGA por SGR
		$con_usua = "SELECT usuario FROM cx_usu_web WHERE usuario='$usuario1'";
		$sql_c = odbc_exec($conexion, $con_usua);
		$t_usua = odbc_num_rows($sql_c);
		$t_usua = intval($t_usua);
		if ($t_usua > 0)
		{
			$usuario1 = $usuario1;
		}
		else
		{
			$usuario1 = "SGR_".$n_uni1;
		}
		$graba1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$notifi', '$usuario', '$unidad', '$usuario1', '$uni', '$mensaje', 'A', '1')";
		$cur3 = odbc_exec($conexion, $graba1);
		// Se graba segunda notificación al usuario que realiza el informe de giro
		$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur2,1);
		$mensaje1 = "<br>SE HA GENERADO EL INFORME DE GIRO POR CONCEPTO DE ".$concepto1." PARA EL MES DE ".$mes." DE ".$ano." Y FUE ENVIADO AL USUARIO ".$usuario1."<br><br>";
		$query3 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usu_usuario', '$uni_usuario', '$mensaje1', 'S', '1')";
		$sql3 = odbc_exec($conexion, $query3);
		// Se actualiza en la tabla de valores autorizados
		if ($concepto == "8")
		{
			$query2 = "UPDATE cx_val_aut SET estado='G', inf_giro='$consecu' WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND depen='$v1' AND inf_giro='0' AND conse IN ($conses2)";
		}
		else
		{
			if ($concepto == "9")
			{
				$query2 = "UPDATE cx_val_aut1 SET estado='G', inf_giro='$consecu' WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND depen='$v1' AND inf_giro='0' AND conse IN ($conses2)";
				// Se consulta numero de autorizacion de recursos adicionales
				$query7 = "SELECT autoriza FROM cx_val_aut1 WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND depen='$v1' AND inf_giro='0'";
				$sql7 = odbc_exec($conexion, $query7);
				$num_aut2 = odbc_result($sql7,1);
			}
			else
			{
				$query2 = "UPDATE cx_val_aut2 SET estado='G', inf_giro='$consecu' WHERE periodo='$periodo' AND ano='$ano' AND unidad='$a[$k]' AND depen='$v1' AND total='$v5' AND ((estado='V' AND solicitud='0') OR (estado='' AND registro='0' AND pago='0')) AND inf_giro='0' AND conse IN ($conses2)";
				// Se consulta numero de autorizacion de recursos adicionales
				$query7 = "SELECT autoriza FROM cx_val_aut2 WHERE periodo='$periodo' AND ano='$ano' AND unidad='$a[$k]' AND depen='$v1' AND total='$v5' AND ((estado='V' AND solicitud='0') OR (estado='' AND registro='0' AND pago='0')) AND inf_giro='0'";
				$sql7 = odbc_exec($conexion, $query7);
				$num_aut2 = odbc_result($sql7,1);
				$num_aut3 .= $num_aut2.",";
				$sigue = "1";
				// Se actualiza estado en cx_reg_rec
				$query8 = "SELECT solicitud, registro FROM cx_val_aut2 WHERE conse IN ($conses2) AND ano='$ano'";
				$sql8 = odbc_exec($conexion, $query8);
				$registros = "";
				$m = 0;
				while($m<$row=odbc_fetch_array($sql8))
    			{
    				$var_sol = odbc_result($sql8,1);
    				$var_reg = odbc_result($sql8,2);
    				if ($var_reg == "0")
    				{
    					$registros .= $var_sol.",";
    				}
    				else
    				{
    					$registros .= $var_reg.",";
    				}
    			}
    			$registros = substr($registros,0,-1);
				$query9 = "UPDATE cx_reg_rec SET estado='H' WHERE conse IN ($registros) AND estado='G'";
				$sql9 = odbc_exec($conexion, $query9);			
			}	
		}
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_inf_giro.txt", "a");
		fwrite($file, $fec_log." # ".$query2." # ".PHP_EOL);
		fclose($file);
		$sql = odbc_exec($conexion, $query2);
		// Datos para correos electronicos
		$v_datos1 .= $usuario1."|";
		$v_datos2 .= number_format($v5,2)."|";
		// Se actualizan unidades dependientes para especializada
		$consulta = "SELECT uom FROM cx_val_aut WHERE inf_giro='$consecu'";
		$sql4 = odbc_exec($conexion, $consulta);
		$n_uom = odbc_result($sql4,1);
		$n_uom = intval($n_uom);
		$tot_uom = odbc_num_rows($sql4);
		if ($tot_uom == "0")
		{
			$n_uom = $div;
		}
		if ($n_uom > 3)
		{
			if ($concepto == "8")
			{
				$query2 = "UPDATE cx_val_aut SET estado='G', inf_giro='$consecu' WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND uom='$n_uom' AND inf_giro='0' AND conse IN ($conses2)";
			}
			else
			{
				if ($concepto == "9")
				{
					$query2 = "UPDATE cx_val_aut1 SET estado='G', inf_giro='$consecu' WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND uom='$n_uom' AND inf_giro='0' AND conse IN ($conses2)";
				}
				else
				{
					if ($sigue == "0")
					{
						$query2 = "UPDATE cx_val_aut2 SET estado='G', inf_giro='$consecu' WHERE periodo='$periodo' AND ano='$ano' AND uom='$n_uom' AND ((estado='V' AND solicitud='0') OR (estado='' AND registro='0' AND pago='0')) AND inf_giro='0'";
					}
					else
					{
						$query2 = "";
					}
				}
			}
			$sql = odbc_exec($conexion, $query2);
			// Se graba log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_inf_giro.txt", "a");
			fwrite($file, $fec_log." # ".$query2." # ".PHP_EOL);
			fclose($file);
		}
		$conses .= $numero."|".$n_uni."«";
		$consecus .= $consecu.",";
		// Se retira por solicitud de generar un solo comprobante de egreso - 11/07/2019
		// Se consulta discriminados para egreso
		//$paso_dato = "";
		//$query3 = "SELECT * FROM cx_val_aut WHERE inf_giro='$consecu'";
		//$sql3 = odbc_exec($conexion, $query3);
		//while ($i < $row = odbc_fetch_array($sql3))
        //{
        //	$x0 = $row['unidad'];
        //	$x1 = $row['sigla'];
        //	$x2 = $row['gastos'];
        //	$x3 = $row['pagos'];
        //	$x4 = $row['total'];
        //	$x4 = intval($x4);
        //    $query4 = "SELECT gastos FROM cx_pla_cen WHERE unidad='$x0' AND periodo='$periodo' AND ano='$ano'";
        //    $cur4 = odbc_exec($conexion, $query4);
        //    $v_gas = odbc_result($cur4,1);
        //    $v_gas1 = str_replace(',','',$v_gas);
        //    $v_gas1 = substr($v_gas1,0,-3);
        //    $v_gas1 = intval($v_gas1);
        //    $x4 = $x4-$v_gas1;
        //    $x4 = number_format($x4,2);
        //	$paso_dato .= trim($x1)."|".$x4."#";
        //}
		//$datos = encrypt1($paso_dato, $llave);
		// Se graba comprobande de egreso
		//$cur3 = odbc_exec($conexion,"SELECT isnull(max(egreso),0)+1 AS conse FROM cx_com_egr");
		//$consecu1 = odbc_result($cur3,1);
		//$graba3 = "INSERT INTO cx_com_egr (egreso, usuario, unidad, periodo, ano, tipo, valor, subtotal, total, neto, concepto, tp_gas, recurso, rubro, autoriza, num_auto, soporte, num_sopo, pago, det_pago, datos, firmas, ciudad, unidad1) VALUES ('$consecu1', '$usu_usuario', '1', '$periodo', '$ano', '1', '$v5', '$v5', '$v5', '$v5', '8', '99', '$recurso', '$rubro', '1', '$consecu', '8', '$periodo1', '1', '$cash', '$datos', '$firmas', '$ciu_usuario', '$uni')";
		//odbc_exec($conexion, $graba3);
		// Fin cambio un solo comprobante de egreso
		// Se consultan saldos de la unidad centralizadora
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
		if ($cuenta1 == "1")
		{
			$query3 = "SELECT saldo, $campo, dependencia FROM cx_org_sub WHERE subdependencia='$unidad'";
			$cur3 = odbc_exec($conexion, $query3);
			$saldo = odbc_result($cur3,1);
			$saldo1 = odbc_result($cur3,2);
			$saldo2 = $saldo-$v5;
			$saldo3 = $saldo1-$v5;
			$depen = odbc_result($cur3,3);
			// Se actualizan saldos de unidad
			$query4 = "UPDATE cx_org_sub SET saldo='$saldo2', $campo='$saldo3' WHERE subdependencia='$unidad'";
			$cur4 = odbc_exec($conexion, $query4);
		}
		else
		{
			if (($uni_usuario == "1") or ($uni_usuario == "2"))
			{
				$query3 = "SELECT saldo FROM cx_ctr_cue WHERE conse='$cuenta1' AND unidad='1'";
				$cur3 = odbc_exec($conexion, $query3);
				$saldo = odbc_result($cur3,1);
				$saldo1 = $saldo-$v5;
				// Se actualizan saldos
				$query4 = "UPDATE cx_ctr_cue SET saldo='$saldo1', movimiento=getdate() WHERE conse='$cuenta1' AND unidad='1'";
				$cur4 = odbc_exec($conexion, $query4);
			}
		}
	}
	$consecus = substr($consecus,0,-1);
	// Se graba un solo comprobante de egreso por el total - 11/07/2019 - Consuelo
	$datos = encrypt1($paso_dato, $llave);
	$cur3 = odbc_exec($conexion, "SELECT isnull(max(com_egr),0)+1 AS conse FROM cx_org_sub WHERE subdependencia='1'");
	$consecu1 = odbc_result($cur3,1);
	if ($concepto == "10")
	{
		$num_aut1 = $num_aut3;
	}
	else
	{
		if ($concepto == "9")
		{
			$num_aut1 = $num_aut2;
		}
		else
		{
			$num_aut1 = $periodo;
		}
	}
	// Autorizacion
	if ($concepto == "8")
	{
		$autoriza = "3";
	}
	else
	{
		if ($concepto == "9")
		{
			$autoriza = "6";

		}
		else
		{
			$autoriza = "6";
		}
	}
	$graba3 = "INSERT INTO cx_com_egr (egreso, usuario, unidad, periodo, ano, tipo, valor, subtotal, total, neto, concepto, tp_gas, recurso, rubro, autoriza, num_auto, soporte, num_sopo, pago, det_pago, datos, firmas, ciudad, unidad1, cdp, crp, giro, cuenta, crps, saldos, giros) VALUES ('$consecu1', '$usuario', '1', '$periodo', '$ano', '1', '$total1', '$total1', '$total1', '$total1', '$concepto', '99', '$recurso', '$rubro', '$autoriza', '$num_aut1', '$soporte', '$periodo1', '1', '$cash', '$datos', '$firmas', '$ciudad', '1', '$cdp', '$crp', '$consecu', '$cuenta1', '$crps1', '$saldos1', '$consecus')";
	odbc_exec($conexion, $graba3);
	odbc_exec($conexion, "UPDATE cx_org_sub SET com_egr='$consecu1' WHERE subdependencia='1'");
	// Fin cambio un solo comprobante de egreso
	$query1 = "SELECT conse FROM cx_inf_gir WHERE conse='$consecu'";
	$cur2 = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur2,1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_comp_egre.txt", "a");
	fwrite($file, $fec_log." # ".$graba3." # ".PHP_EOL);
	fclose($file);
	// CRP
	if ($cuenta1 == "1")
	{
		// Se actualiza el saldo del crp
		$query5 = "SELECT saldo FROM cx_crp WHERE conse='$crp'";
		$cur5 = odbc_exec($conexion, $query5);
		$saldo = odbc_result($cur5,1);
		$saldo1 = $saldo-$saldor;
		// Se actualizan saldos de crp
		$query6 = "UPDATE cx_crp SET saldo='$saldo1' WHERE conse='$crp'";
		$cur6 = odbc_exec($conexion, $query6);
		// Varios Crp
		if ($cantidad > 0)
		{
			for ($i=0;$i<(count($num_crps)-1);++$i)
			{
				$query5 = "SELECT saldo FROM cx_crp WHERE conse='$g[$i]'";
				$cur5 = odbc_exec($conexion, $query5);
				$saldo = odbc_result($cur5,1);
				$saldo1 = $saldo-$h[$i];
				// Se actualizan saldos de crp
				$query6 = "UPDATE cx_crp SET saldo='$saldo1' WHERE conse='$g[$i]'";
				$cur6 = odbc_exec($conexion, $query6);
			}
		}
	}
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->conses = $conses;
	$salida->datos1 = $v_datos1;
	$salida->datos2 = $v_datos2;
	echo json_encode($salida);
}
?>