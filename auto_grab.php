<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$actual = date('Y-m-d');
	$ano = date('Y');
	$mes = date('m');
	$mes = intval($mes);
	$conses = $_POST['conses'];
	$conses1 = stringArray($conses);
	$conses2 = encrypt1($conses1, $llave);
	$paso0 = $_POST['paso0'];
	$paso1 = $_POST['paso1'];
	$paso2 = $_POST['paso2'];
	$paso3 = $_POST['paso3'];
	$paso4 = $_POST['paso4'];
	$paso5 = $_POST['paso5'];
	$paso6 = $_POST['paso6'];
	$paso7 = $_POST['paso7'];
	$firma1 = $_POST['firma1'];
	$firma1 = iconv("UTF-8", "ISO-8859-1", $firma1);
	$firma2 = $_POST['firma2'];
	$firma2 = iconv("UTF-8", "ISO-8859-1", $firma2);
	$firma3 = $_POST['firma3'];
	$firma3 = iconv("UTF-8", "ISO-8859-1", $firma3);
	$cargo1 = $_POST['cargo1'];
	$cargo1 = iconv("UTF-8", "ISO-8859-1", $cargo1);
	$cargo2 = $_POST['cargo2'];
	$cargo2 = iconv("UTF-8", "ISO-8859-1", $cargo2);
	$cargo3 = $_POST['cargo3'];
	$cargo3 = iconv("UTF-8", "ISO-8859-1", $cargo3);
	$firmas = $firma1."»".$cargo1."|".$firma2."»".$cargo2."|".$firma3."»".$cargo3;
	$firmas = encrypt1($firmas, $llave);
	$elaboro = $_POST['elaboro'];
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$cargo4 = $_POST['cargo4'];
	$cargo4 = iconv("UTF-8", "ISO-8859-1", $cargo4);
	$asunto = $_POST['asunto'];
	$asunto = strtr(trim($asunto), $sustituye);
	$asunto = iconv("UTF-8", "ISO-8859-1", $asunto);
	$sustenta = $_POST['sustenta'];
	$sustenta = strtr(trim($sustenta), $sustituye);
	$sustenta = iconv("UTF-8", "ISO-8859-1", $sustenta);
	$observa = $_POST['observa'];
	$observa = strtr(trim($observa), $sustituye);
	$observa = iconv("UTF-8", "ISO-8859-1", $observa);
	// Se extraen las datos por separado para grabar
	$num_paso0 = explode("|",$paso0);
	for ($i=0;$i<count($num_paso0);++$i)
	{
		$g[$i] = $num_paso0[$i];
	}
	$num_paso1 = explode("|",$paso1);
	for ($i=0;$i<count($num_paso1);++$i)
	{
		$a[$i] = $num_paso1[$i];
	}
	$num_paso2 = explode("|",$paso2);
	for ($i=0;$i<count($num_paso2);++$i)
	{
		$b[$i] = $num_paso2[$i];
	}
	$num_paso3 = explode("|",$paso3);
	for ($i=0;$i<count($num_paso3);++$i)
	{
		$c[$i] = $num_paso3[$i];
	}
	$num_paso4 = explode("|",$paso4);
	for ($i=0;$i<count($num_paso4);++$i)
	{
		$d[$i] = $num_paso4[$i];
	}
	$num_paso5 = explode("|",$paso5);
	for ($i=0;$i<count($num_paso5);++$i)
	{
		$e[$i] = $num_paso5[$i];
	}
	$num_paso6 = explode("|",$paso6);
	for ($i=0;$i<count($num_paso6);++$i)
	{
		$f[$i] = $num_paso6[$i];
	}
	$num_paso7 = explode("|",$paso7);
	for ($i=0;$i<count($num_paso7);++$i)
	{
		$h[$i] = $num_paso7[$i];
	}
	// Se crea consecutivo en tabla de solicitudes autorizadas
	$sql = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_sol_aut WHERE ano='$ano'");
	$consecu = odbc_result($sql,1);
	$sql1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_rec_aut WHERE ano='$ano'");
	$consecu1 = odbc_result($sql1,1);
	if ($consecu1 > $consecu)
	{
		$consecu = $consecu1;
	}
	$graba = "INSERT INTO cx_sol_aut (conse, usuario, unidad, planes, ano, firmas, asunto, sustentacion, observaciones, elaboro, cargo) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$conses2', '$ano', '$firmas', '$asunto', '$sustenta', '$observa', '$elaboro', '$cargo4')";
	if (!odbc_exec($conexion, $graba))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
		for ($i=0;$i<(count($num_paso6)-1);++$i)
		{
			$sql = odbc_exec($conexion,"SELECT unidad FROM cx_pla_inv WHERE conse='$f[$i]' AND periodo='$d[$i]' AND ano='$e[$i]'");
			$uni_plan = odbc_result($sql,1);
			$sql1 = odbc_exec($conexion,"SELECT sigla, dependencia, unidad, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$uni_plan'");
			$sig_plan = trim(odbc_result($sql1,1));
			// Validacion cambio de sigla
			$p3_1 = trim(odbc_result($sql1,4));
			$p3_2 = trim(odbc_result($sql1,5));
			if ($p3_2 == "")
			{
			}
			else
			{
				$p3_2 = str_replace("/", "-", $p3_2);
				if ($actual >= $p3_2)
				{
					$sig_plan = $p3_1;
				}
			}
			$dep_plan = trim(odbc_result($sql1,2));
			$uom_plan = trim(odbc_result($sql1,3));
			// Se consulta nombre deependencia y unidad 
			$sql2 = odbc_exec($conexion,"SELECT nombre FROM cx_org_dep WHERE dependencia='$dep_plan'");
			$n_dep_plan = trim(odbc_result($sql2,1));
			$sql3 = odbc_exec($conexion,"SELECT nombre FROM cx_org_uni WHERE unidad='$uom_plan'");
			$n_uom_plan = trim(odbc_result($sql3,1));
			// Se consulta maximo
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_val_aut1");
			$consecu1 = odbc_result($cur,1);
			// Se graba discriminado de gastos
			$graba = "INSERT INTO cx_val_aut1 (conse, usuario, unidad, periodo, ano, sigla, gastos, pagos, total, depen, n_depen, uom, n_uom, estado, aprueba, solicitud, autoriza) VALUES ('$consecu1', '$usu_usuario', '$uni_plan', '$mes', '$e[$i]', '$sig_plan', '$a[$i]', '$b[$i]', '$c[$i]', '$dep_plan', '$n_dep_plan', '$uom_plan', '$n_uom_plan', 'V', '$usu_usuario', '$f[$i]', '$consecu')";
			$cur = odbc_exec($conexion, $graba);
		}
  	}
	// Se acutalizan los planes del consolidado
	$graba1 = "UPDATE cx_pla_inv SET aprueba='1' WHERE conse IN ($conses1) AND tipo='2' AND ano='$ano'";
	$sql = odbc_exec($conexion, $graba1);
	// Se actualiza valores en cx_pla_pag
	for ($i=0;$i<(count($num_paso7)-1);++$i)
	{
		$num_datos = explode("&",$h[$i]);
		$v_plan = $num_datos[0];
		$v_unidad = $num_datos[1];
		$v_datos = trim($num_datos[2]);
		$num_pagos = explode("«",$v_datos);
		for ($j=0;$j<count($num_pagos)-1;++$j)
		{
			$v_datos1 = $num_pagos[$j];
			$num_pagos1 = explode("#",$v_datos1);
			$x_1 = $num_pagos1[0];
			$x_2 = $num_pagos1[1];
			$x_3 = $num_pagos1[2];
			$consu = "SELECT val_fuen_a FROM cx_pla_pag WHERE conse='$f[$i]' AND conse1='$x_1' AND ced_fuen='$x_2' AND ano='$ano'";
			$sql4 = odbc_exec($conexion, $consu);
			$val_fuen_a = trim(odbc_result($sql4,1));
			$actu = "UPDATE cx_pla_pag SET val_fuen_a='$x_3', val_fuen_c='$val_fuen_a' WHERE conse='$f[$i]' AND conse1='$x_1' AND ced_fuen='$x_2' AND ano='$ano'";
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_autoriza_veri.txt", "a");
			fwrite($file, $fec_log." # ".$consu." # ".$actu." # ".PHP_EOL);
			fclose($file);
			$sql5 = odbc_exec($conexion, $actu);
  	}
  }
	// Log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_autoriza.txt", "a");
	fwrite($file, $fec_log." # ".$graba." # ".$graba1." # ".PHP_EOL);
	fclose($file);
	$salida->salida = $confirma;
	$salida->conse = $consecu;
	echo json_encode($salida);
}
// 25/07/2024 - Ajuste inclusion cargo elaboro
?>