<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$nom_usuario = iconv("UTF-8", "ISO-8859-1", $nom_usuario);
$car_usuario = iconv("UTF-8", "ISO-8859-1", $car_usuario);
if (is_ajax())
{
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	$planes = $_POST['planes'];
	$unidades = $_POST['unidades'];
	$periodos = $_POST['periodos'];
	$anos = $_POST['anos'];
	$siglas = $_POST['siglas'];
	$depen = $_POST['depen'];
	$ndepen = $_POST['ndepen'];
	$uom = $_POST['uom'];
	$nuom = $_POST['nuom'];
	$gastos = $_POST['gastos'];
	$pagos = $_POST['pagos'];
	$totales = $_POST['totales'];
	$saldo = $_POST['saldo'];
	$gastos1 = $_POST['gastos1'];
	if ($gastos1 == "")
	{
		$gastos1 = "0.00";
	}
	$gastos2 = $_POST['gastos2'];
	$gastos2 = strtr(trim($gastos2), $sustituye);
	$gastos2 = iconv("UTF-8", "ISO-8859-1", $gastos2);
	$gastos2 = strtoupper($gastos2);
	$pagos1 = $_POST['pagos1'];
	if ($pagos1 == "")
	{
		$pagos1 = "0.00";
	}
	$pagos2 = $_POST['pagos2'];
	$$pagos2 = strtr(trim($$pagos2), $sustituye);
	$pagos2 = iconv("UTF-8", "ISO-8859-1", $pagos2);
	$pagos2 = strtoupper($pagos2);
	$recompensas1 = $_POST['recompensas1'];
	if ($recompensas1 == "")
	{
		$recompensas1 = "0.00";
	}
	$recompensas2 = $_POST['recompensas2'];
	$recompensas2 = strtr(trim($recompensas2), $sustituye);
	$recompensas2 = iconv("UTF-8", "ISO-8859-1", $recompensas2);
	$recompensas2 = strtoupper($recompensas2);
	$pasog = $_POST['pasog'];
	$pasop = $_POST['pasop'];
	$unidades3 = $_POST['unidades3'];
	$siglas3 = $_POST['siglas3'];
	$gastos3 = $_POST['gastos3'];
	$pagos3 = $_POST['pagos3'];
	$totales3 = $_POST['totales3'];
	$nota = $_POST['nota'];
	$nota = strtr(trim($nota), $sustituye);
	$nota = iconv("UTF-8", "ISO-8859-1", $nota);
	$nota = strtoupper($nota);
	// Se extraen las datos por separado para grabar
	$num_unidades=explode("|",$unidades);
	for ($i=0;$i<count($num_unidades);++$i)
	{
		$a[$i]=trim($num_unidades[$i]);
	}
	$num_periodos=explode("|",$periodos);
	for ($i=0;$i<count($num_periodos);++$i)
	{
		$b[$i]=trim($num_periodos[$i]);
	}
	$num_anos=explode("|",$anos);
	for ($i=0;$i<count($num_anos);++$i)
	{
		$c[$i]=trim($num_anos[$i]);
	}
	$num_siglas=explode("|",$siglas);
	for ($i=0;$i<count($num_siglas);++$i)
	{
		$d[$i]=trim($num_siglas[$i]);
	}
	$num_gastos=explode("|",$gastos);
	for ($i=0;$i<count($num_gastos);++$i)
	{
		$e[$i]=trim($num_gastos[$i]);
	}
	$num_pagos=explode("|",$pagos);
	for ($i=0;$i<count($num_pagos);++$i)
	{
		$f[$i]=trim($num_pagos[$i]);
	}
	$num_totales=explode("|",$totales);
	for ($i=0;$i<count($num_totales);++$i)
	{
		$g[$i]=trim($num_totales[$i]);
	}
	$num_depen=explode("|",$depen);
	for ($i=0;$i<count($num_depen);++$i)
	{
		$h[$i]=trim($num_depen[$i]);
	}
	$num_ndepen=explode("|",$ndepen);
	for ($i=0;$i<count($num_ndepen);++$i)
	{
		$j[$i]=trim($num_ndepen[$i]);
	}
	$num_uom=explode("|",$uom);
	for ($i=0;$i<count($num_uom);++$i)
	{
		$k[$i]=trim($num_uom[$i]);
	}
	$num_nuom=explode("|",$nuom);
	for ($i=0;$i<count($num_nuom);++$i)
	{
		$l[$i]=trim($num_nuom[$i]);
	}

	$num_unidades3=explode("|",$unidades3);
	for ($i=0;$i<count($num_unidades3);++$i)
	{
		$m[$i]=trim($num_unidades3[$i]);
	}
	$num_siglas3=explode("|",$siglas3);
	for ($i=0;$i<count($num_siglas3);++$i)
	{
		$n[$i]=trim($num_siglas3[$i]);
	}
	$num_gastos3=explode("|",$gastos3);
	for ($i=0;$i<count($num_gastos3);++$i)
	{
		$o[$i]=trim($num_gastos3[$i]);
	}
	$num_pagos3=explode("|",$pagos3);
	for ($i=0;$i<count($num_pagos3);++$i)
	{
		$p[$i]=trim($num_pagos3[$i]);
	}
	$num_totales3=explode("|",$totales3);
	for ($i=0;$i<count($num_totales3);++$i)
	{
		$q[$i]=trim($num_totales3[$i]);
	}
	// Si es GR
	if ($adm_usuario == "6")
	{
		$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_cen WHERE ano='$ano'");
		$consecu = odbc_result($cur,1);
		// Se graba plan inversion centralizado
		$graba = "INSERT INTO cx_pla_cen (conse, usuario, unidad, periodo, ano, saldo, gastos, pagos, recompensas, gastos1, pagos1, recompensas1, elaboro, cargo) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$periodo', '$ano', '$saldo', '$gastos1', '$pagos1', '$recompensas1', '$gastos2', '$pagos2', '$recompensas2', '$nom_usuario', '$car_usuario')";
		odbc_exec($conexion, $graba);
		$query1 = "SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_cen WHERE ano='$ano'";
		$cur = odbc_exec($conexion, $query1);
		$conse = odbc_result($cur,1);
		// Se crea notificacion
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur1,1);
		// Se consulta CMD Brigada
		$query2 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='7'";
		$cur2 = odbc_exec($conexion,$query2);
		$usuario1 = odbc_result($cur2,1);
		$mensaje = "<br>SE HA REGISTRADO SALDO EN BANCOS DEL CONSOLIDADO PLAN DE NECESIDADES UNIDAD CENTRALIZADORA, SE SOLICITA APROBACIÓN.<br><br>";
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario1', '$uni_usuario', '$mensaje', 'S', '1')";
		$sql2 = odbc_exec($conexion, $query2);
		$notifica = $usuario1;
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_auto.txt", "a");
		fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
		fclose($file);
	}
	// Si es B4 o JEM
	if (($adm_usuario == "7") or ($adm_usuario == "8"))
	{
		if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
		{
			if ($adm_usuario == "7")
			{
				$val_est = "C";
				$graba1 = "UPDATE cx_pla_cen SET revisa='$con_usuario', firma1='$nom_usuario', cargo1='$car_usuario' WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
			}
			else
			{
				$val_est = "D";
				$graba1 = "UPDATE cx_pla_cen SET ordena='$con_usuario', firma2='$nom_usuario', cargo2='$car_usuario' WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
			}
		}
		else
		{
			$val_est = "D";
			$graba1 = "UPDATE cx_pla_cen SET ordena='$con_usuario', firma2='$nom_usuario', cargo2='$car_usuario' WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
		}
		odbc_exec($conexion, $graba1);
		// Se actualiza nota en plan centralizado
		if ($adm_usuario == "7")
		{
			$actu = "UPDATE cx_pla_cen SET nota='$nota' WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
			odbc_exec($conexion, $actu);
		}
		// Se cambia estado de los planes/solicitudes ya autorizados por la unidad centralizadora
		$query = "UPDATE cx_pla_inv SET estado='$val_est' WHERE conse IN ($planes) AND ano='$ano'";
		$sql = odbc_exec($conexion, $query);
		// Se recorre por unidades
		for ($i=0;$i<(count($num_unidades)-1);++$i)
		{
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_val_aut");
			$consecu = odbc_result($cur,1);
			// Se graba discriminado de gastos
			if ($adm_usuario == "7")
			{
				$graba = "INSERT INTO cx_val_aut (conse, usuario, unidad, periodo, ano, sigla, gastos, pagos, total, depen, n_depen, uom, n_uom) VALUES ('$consecu', '$usu_usuario', '$a[$i]', '$b[$i]', '$c[$i]', '$d[$i]', '$e[$i]', '$f[$i]', '$g[$i]', '$h[$i]', '$j[$i]', '$k[$i]', '$l[$i]')";
			}
			else
			{
				$graba = "UPDATE cx_val_aut SET usuario='$usu_usuario', gastos='$e[$i]', pagos='$f[$i]', total='$g[$i]' WHERE unidad='$a[$i]' AND periodo='$b[$i]' AND ano='$c[$i]' AND sigla='$d[$i]'";	
			}
			odbc_exec($conexion, $graba);
		}
		$query1 = "SELECT isnull(max(conse),0) AS conse FROM cx_val_aut";
		$cur = odbc_exec($conexion, $query1);
		$conse = odbc_result($cur,1);
		// Se graban nuevos valores autorizados
		$num_total_aut = explode("»",$pasog);
		$num_total_aut1 = count($num_total_aut)-1;
		for ($m=0;$m<$num_total_aut1;++$m)
		{
			$pasog1 = trim($num_total_aut[$m]);
			$num_pasog = explode("#",$pasog1);
			$uni = $num_pasog[0];
			$tip = $num_pasog[1];
			$con = $num_pasog[2];
			$con = substr($con, 0, -1);
			$val = $num_pasog[3];
			$num_con = explode("|",$con);
			for ($i=0;$i<count($num_con);++$i)
			{
				$x[$i]=trim($num_con[$i]);
			}
			$num_val = explode("|",$val);
			for ($i=0;$i<count($num_val);++$i)
			{
				$y[$i]=trim($num_val[$i]);
			}
			for ($i=0;$i<count($num_con);++$i)
			{
				$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pag_aut");
				$consecu = odbc_result($cur,1);
				// Se graba discriminado de pagos autorizados
				if ($adm_usuario == "8")
				{
					$borra = "DELETE FROM cx_pag_aut WHERE periodo='$periodo' AND ano='$ano' AND unidad1='$uni' AND tipo='$tip' AND tipou='7'";
					odbc_exec($conexion, $borra);
				}
				$graba = "INSERT INTO cx_pag_aut (conse, usuario, unidad, periodo, ano, unidad1, tipo, interno, valor, tipou) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$periodo', '$ano', '$uni', '$tip', '$x[$i]', '$y[$i]', '$adm_usuario')";
				odbc_exec($conexion, $graba);
			}
		}
		$num_total_aut = explode("»",$pasop);
		for ($m=0;$m<count($num_total_aut)-1;++$m)
		{
			$pasop1 = trim($num_total_aut[$m]);
			$num_pasop = explode("#",$pasop1);
			$uni = $num_pasop[0];
			$tip = $num_pasop[1];
			$con = $num_pasop[2];
			$con = substr($con, 0, -1);
			$val = $num_pasop[3];
			$num_con = explode("|",$con);
			for ($i=0;$i<count($num_con);++$i)
			{
				$x[$i]=trim($num_con[$i]);
			}
			$num_val = explode("|",$val);
			for ($i=0;$i<count($num_val);++$i)
			{
				$y[$i]=trim($num_val[$i]);
			}
			for ($i=0;$i<count($num_con);++$i)
			{
				$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pag_aut");
				$consecu = odbc_result($cur,1);
				// Se graba discriminado de pagos autorizados
				if ($adm_usuario == "8")
				{
					$borra = "DELETE FROM cx_pag_aut WHERE periodo='$periodo' AND ano='$ano' AND unidad1='$uni' AND tipo='$tip' AND tipou='7'";
					odbc_exec($conexion, $borra);
				}
				$graba = "INSERT INTO cx_pag_aut (conse, usuario, unidad, periodo, ano, unidad1, tipo, interno, valor, tipou) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$periodo', '$ano', '$uni', '$tip', '$x[$i]', '$y[$i]', '$adm_usuario')";
				odbc_exec($conexion, $graba);
			}
		}
		// Se crea notificacion
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur1,1);
		// Se consulta superior
		if ($adm_usuario == "7")
		{
			if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
	        {
				$query2 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='8'";
			}
			else
			{
				$query2 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='9'";
			}
			$mensaje = "<br>SE HA CONSOLIDADO PLAN DE NECESIDADES UNIDAD CENTRALIZADORA, SE SOLICITA APROBACIÓN.<br><br>";
		}
		else
		{
			$query2 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='9'";
			$mensaje = "<br>SE HA CONSOLIDADO PLAN DE NECESIDADES UNIDAD CENTRALIZADORA, SE SOLICITA VISTO BUENO DE LA ORDENACION.<br><br>";
		}	    
		$cur2 = odbc_exec($conexion,$query2);
		$usuario1 = odbc_result($cur2,1);
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario1', '$uni_usuario', '$mensaje', 'S', '1')";
		$sql2 = odbc_exec($conexion, $query2);
		$notifica = $usuario1;
	}
	// Si es C4 Comando
	if (($adm_usuario == "10") or ($adm_usuario == "25"))
	{
		$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_cen WHERE ano='$ano'");
		$consecu = odbc_result($cur,1);
		// Se graba plan inversion centralizado
		$graba = "INSERT INTO cx_pla_cen (conse, usuario, unidad, periodo, ano, saldo, gastos, pagos, recompensas, gastos1, pagos1, recompensas1, elaboro, cargo) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$periodo', '$ano', '$saldo', '$gastos1', '$pagos1', '$recompensas1', '$gastos2', '$pagos2', '$recompensas2', '$nom_usuario', '$car_usuario')";
		odbc_exec($conexion, $graba);
		$query1 = "SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_cen WHERE ano='$ano'";
		$cur = odbc_exec($conexion, $query1);
		$conse = odbc_result($cur,1);
		// Se crea notificacion
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur1,1);
		// Se consulta CMD Brigada
		if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
		{
			$v_usu = substr($usu_usuario, 0, 3);
			if (($v_usu == "SPG") and ($tpc_usuario == "1"))
			{
				$n_admin = "11";
			}
			else
			{
				$n_admin = "7";
			}
		}
		else
		{
			$n_admin = "11";
		}
		$query2 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='$n_admin'";
		$cur2 = odbc_exec($conexion,$query2);
		$usuario1 = odbc_result($cur2,1);
		$mensaje = "<br>SE HA REGISTRADO SALDO EN BANCOS DEL CONSOLIDADO PLAN DE NECESIDADES UNIDAD CENTRALIZADORA, SE SOLICITA APROBACIÓN.<br><br>";		
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario1', '$uni_usuario', '$mensaje', 'S', '1')";
		$sql2 = odbc_exec($conexion, $query2);
		$notifica = $usuario1;
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_auto.txt", "a");
		fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
		fclose($file);
	}
	// Si es Comando
	if (($adm_usuario == "11") or ($adm_usuario == "12"))
	{
		if ($adm_usuario == "11")
		{
			$graba1 = "UPDATE cx_pla_cen SET revisa='$con_usuario', firma1='$nom_usuario', cargo1='$car_usuario' WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
		}
		else
		{
			$graba1 = "UPDATE cx_pla_cen SET ordena='$con_usuario', firma2='$nom_usuario', cargo2='$car_usuario' WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
		}
		odbc_exec($conexion, $graba1);
		$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_val_aut");
		$consecu = odbc_result($cur,1);
		// Se consulta unidad superior
	    $preg1 = "SELECT unidad,dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
	    $cur1 = odbc_exec($conexion, $preg1);
	    $n_unidad = odbc_result($cur1,1);
	    $n_dependencia = odbc_result($cur1,2);
	    // Se consultan nombres
	    $preg2 = "SELECT nombre FROM cx_org_dep WHERE dependencia='$n_dependencia'";
	    $cur2 = odbc_exec($conexion, $preg2);
	    $n_depen = trim(odbc_result($cur2,1));
	    $preg3 = "SELECT nombre FROM cx_org_uni WHERE unidad='$n_unidad'";
	    $cur3 = odbc_exec($conexion, $preg3);
	    $n_uni = trim(odbc_result($cur3,1));
		// Se graba discriminado de gastos
		if ($adm_usuario == "11")
		{
			$graba = "INSERT INTO cx_val_aut (conse, usuario, unidad, periodo, ano, sigla, gastos, pagos, total, estado, depen, n_depen, uom, n_uom) VALUES ('$consecu', '$usu_usuario', '$unidades', '$periodos', '$anos', '$siglas', '$gastos', '$pagos', '$totales', 'V', '$n_dependencia', '$n_depen', '$n_unidad', '$n_uni')";
		}
		else
		{
			$graba = "UPDATE cx_val_aut SET usuario='$usu_usuario', gastos='$gastos', pagos='$pagos', total='$totales' WHERE unidad='$unidades' AND periodo='$periodo' AND ano='$ano' AND sigla='$siglas'";
		}
		odbc_exec($conexion, $graba);
		// Se actualiza nota en plan centralizado 
		if ($adm_usuario == "11")
		{
			$actu = "UPDATE cx_pla_cen SET nota='$nota' WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
			odbc_exec($conexion, $actu);
		}
		// Se consulta conse de valores autorizados
		$query1 = "SELECT isnull(max(conse),0) AS conse FROM cx_val_aut";
		$cur = odbc_exec($conexion, $query1);
		$conse = odbc_result($cur,1);
		// Se crea notificacion
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur1,1);
		// Se consulta superior
		if ($adm_usuario == "11")
		{
			$query2 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='12'";
			$mensaje = "<br>SE HA CONSOLIDADO PLAN DE NECESIDADES UNIDAD CENTRALIZADORA, SE SOLICITA APROBACIÓN.<br><br>";
		}
		else
		{
			$query2 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='13'";
			$mensaje = "<br>SE HA CONSOLIDADO PLAN DE NECESIDADES UNIDAD CENTRALIZADORA, SE SOLICITA VISTO BUENO DE LA ORDENACIÓN.<br><br>";
		}	    
		$cur2 = odbc_exec($conexion,$query2);
		$usuario1 = odbc_result($cur2,1);
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario1', '$uni_usuario', '$mensaje', 'S', '1')";
		$sql2 = odbc_exec($conexion, $query2);
		$notifica = $usuario1;
	}
	// Si es Comandante de Comando
	if ($adm_usuario == "13")
	{
		$graba1 = "UPDATE cx_pla_cen SET visto='$con_usuario', firma3='$nom_usuario', cargo3='$car_usuario', nota='$nota' WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
		odbc_exec($conexion, $graba1);
		$conse = "1";
		// Se crea notificacion al tesorero
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur1,1);
		// Link
		$valorpdf = $unidades.",".$periodo.",".$ano;
		$pdf = '<input type="button" name="plancen" id="plancen" value="Ver Plan Centralizado" onclick="verpdf('.$valorpdf.');">';
		$mensaje = "<br>SE HA CONSOLIDADO PLAN DE NECESIDADES UNIDAD CENTRALIZADORA: ".trim($siglas);
		$mensaje .= "<br><br>".$pdf."<br><br>";
		// DIADI - CEDE2
		$query2 = "SELECT usuario, unidad FROM cx_usu_web WHERE usuario='SPG_DIADI'";
		$cur2 = odbc_exec($conexion,$query2);
		$usuario1 = trim(odbc_result($cur2,1));
		$n_unidad1 = trim(odbc_result($cur2,2));
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario1', '$n_unidad1', '$mensaje', 'S', '1')";
		$sql2 = odbc_exec($conexion, $query2);
		// Se envia notificacion al SGA de la Division
		if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
		{
		}
		else
		{
			$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
			$consecu1 = odbc_result($cur1,1);
			$v_p1 = explode("_", $usu_usuario);
			$v_p2 = "SGA_".$v_p1[1];
			$query2 = "SELECT usuario, unidad FROM cx_usu_web WHERE usuario='$v_p2'";
			$cur2 = odbc_exec($conexion,$query2);
			$usuario2 = trim(odbc_result($cur2,1));
			$n_unidad2 = trim(odbc_result($cur2,2));
			$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario2', '$n_unidad2', '$mensaje', 'S', '1')";
			$sql2 = odbc_exec($conexion, $query2);
		}
		// Se graba informe de plan centralizados de comando
		$cur3 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_inf_pla WHERE ano='$ano'");
		$consecu3 = odbc_result($cur3,1);
		$nombre = "PlanInvCen_".trim($siglas)."_".$periodo."_".$ano.".pdf";
		$graba2 = "INSERT INTO cx_inf_pla (conse, usuario, unidad, periodo, ano, nombre) VALUES ('$consecu3', '$usu_usuario', '$unidades', '$periodo', '$ano', '$nombre')";
		odbc_exec($conexion, $graba2);
		$notifica = $usuario1;
	}
	// Se graban valores autorizados especificos en unidades abiertas
	if (($adm_usuario == "11") or ($adm_usuario == "13"))
	{
		if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
		{
		}
		else
		{
			// Se recorre por unidades
			for ($i=0;$i<(count($num_unidades3)-1);++$i)
			{
				// Se graba discriminado de gastos
				$graba = "UPDATE cx_val_aut SET usuario='$usu_usuario', gastos='$o[$i]', pagos='$p[$i]', total='$q[$i]' WHERE unidad='$m[$i]' AND periodo='$periodo' AND ano='$ano' AND sigla='$n[$i]' AND estado='V'";
				odbc_exec($conexion, $graba);
			}
			// Se grabar nuevos valores autorizados
			$num_total_aut = explode("»",$pasog);
			$num_total_aut1 = count($num_total_aut)-1;
			for ($m=0;$m<$num_total_aut1;++$m)
			{
				$pasog1 = trim($num_total_aut[$m]);
				$num_pasog = explode("#",$pasog1);
				$uni = $num_pasog[0];
				$tip = $num_pasog[1];
				$con = $num_pasog[2];
				$con = substr($con, 0, -1);
				$val = $num_pasog[3];
				$num_con = explode("|",$con);
				for ($i=0;$i<count($num_con);++$i)
				{
					$x[$i]=trim($num_con[$i]);
				}
				$num_val = explode("|",$val);
				for ($i=0;$i<count($num_val);++$i)
				{
					$y[$i]=trim($num_val[$i]);
				}
				for ($i=0;$i<count($num_con);++$i)
				{
					$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pag_aut");
					$consecu = odbc_result($cur,1);
					// Se graba discriminado de pagos autorizados
					if ($adm_usuario == "13")
					{
						$borra = "DELETE FROM cx_pag_aut WHERE periodo='$periodo' AND ano='$ano' AND unidad1='$uni' AND tipo='$tip' AND tipou='11'";
						odbc_exec($conexion, $borra);
					}
					$graba = "INSERT INTO cx_pag_aut (conse, usuario, unidad, periodo, ano, unidad1, tipo, interno, valor, tipou) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$periodo', '$ano', '$uni', '$tip', '$x[$i]', '$y[$i]', '$adm_usuario')";
					odbc_exec($conexion, $graba);
				}
			}
			$num_total_aut = explode("»",$pasop);
			for ($m=0;$m<count($num_total_aut)-1;++$m)
			{
				$pasop1 = trim($num_total_aut[$m]);
				$num_pasop = explode("#",$pasop1);
				$uni = $num_pasop[0];
				$tip = $num_pasop[1];
				$con = $num_pasop[2];
				$con = substr($con, 0, -1);
				$val = $num_pasop[3];
				$num_con = explode("|",$con);
				for ($i=0;$i<count($num_con);++$i)
				{
					$x[$i]=trim($num_con[$i]);
				}
				$num_val = explode("|",$val);
				for ($i=0;$i<count($num_val);++$i)
				{
					$y[$i]=trim($num_val[$i]);
				}
				for ($i=0;$i<count($num_con);++$i)
				{
					$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pag_aut");
					$consecu = odbc_result($cur,1);
					// Se graba discriminado de pagos autorizados
					if ($adm_usuario == "13")
					{
						$borra = "DELETE FROM cx_pag_aut WHERE periodo='$periodo' AND ano='$ano' AND unidad1='$uni' AND tipo='$tip' AND tipou='11'";
						odbc_exec($conexion, $borra);
					}
					$graba = "INSERT INTO cx_pag_aut (conse, usuario, unidad, periodo, ano, unidad1, tipo, interno, valor, tipou) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$periodo', '$ano', '$uni', '$tip', '$x[$i]', '$y[$i]', '$adm_usuario')";
					odbc_exec($conexion, $graba);
				}
			}
		}
	}
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->notifica = $notifica;
	echo json_encode($salida);
}
// 25/07/2024 - Ajuste firmas y cargos
?>