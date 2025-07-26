<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
  	$mes = date('m');
  	$mes = intval($mes);
	$conses = $_POST['conses'];
	$paso0 = $_POST['paso0'];
	$paso1 = $_POST['paso1'];
	$paso2 = $_POST['paso2'];
	$paso3 = $_POST['paso3'];
	$paso4 = $_POST['paso4'];
	$paso5 = $_POST['paso5'];
	$paso6 = $_POST['paso6'];
	$paso7 = $_POST['paso7'];
	$paso8 = $_POST['paso8'];
	$paso9 = $_POST['paso9'];
	$num_v1 = explode("|",$paso1);
	$paso10 = "";
	for ($i=0;$i<count($num_v1)-1;++$i)
	{
  		$per[$i] = $num_v1[$i];
  		$paso10 .= "'".$per[$i]."',";
	}
	$paso10 = substr($paso10, 0, -1);
	$conses1 = stringArray($conses)."#".$paso10;
	$conses2 = encrypt1($conses1, $llave);
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
	// Se extraen las datos por separado para grabar
	$num_paso0 = explode("|",$paso0);
	for ($i=0;$i<count($num_paso0);++$i)
	{
		$a[$i] = $num_paso0[$i];
	}
	$num_paso1 = explode("|",$paso1);
	for ($i=0;$i<count($num_paso1);++$i)
	{
		$b[$i] = $num_paso1[$i];
	}
	$num_paso2 = explode("|",$paso2);
	for ($i=0;$i<count($num_paso2);++$i)
	{
		$c[$i] = $num_paso2[$i];
	}
	$num_paso3 = explode("|",$paso3);
	for ($i=0;$i<count($num_paso3);++$i)
	{
		$d[$i] = $num_paso3[$i];
	}
	$num_paso4 = explode("|",$paso4);
	for ($i=0;$i<count($num_paso4);++$i)
	{
		$e[$i] = $num_paso4[$i];
	}
	$num_paso5 = explode("|",$paso5);
	for ($i=0;$i<count($num_paso5);++$i)
	{
		$f[$i] = $num_paso5[$i];
	}
	$num_paso6 = explode("|",$paso6);
	for ($i=0;$i<count($num_paso6);++$i)
	{
		$g[$i] = $num_paso6[$i];
	}
	$num_paso7 = explode("|",$paso7);
	for ($i=0;$i<count($num_paso7);++$i)
	{
		$h[$i] = $num_paso7[$i];
	}
	$num_paso8 = explode("|",$paso8);
	for ($i=0;$i<count($num_paso8);++$i)
	{
		$k[$i] = $num_paso8[$i];
	}
	$num_paso9 = explode("|",$paso9);
	for ($i=0;$i<count($num_paso9);++$i)
	{
		$l[$i] = $num_paso9[$i];
	}
	// Se crea consecutivo en tabla de solicitudes autorizadas
	$sql = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_rec_aut WHERE ano='$ano'");
	$consecu = odbc_result($sql,1);
	$sql1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_sol_aut WHERE ano='$ano'");
	$consecu1 = odbc_result($sql1,1);
	if ($consecu1 > $consecu)
	{
		$consecu = $consecu1;
	}
	$graba = "INSERT INTO cx_rec_aut (conse, usuario, unidad, actas, ano, firmas, elaboro) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$conses2', '$ano', '$firmas', '$elaboro')";
	if (!odbc_exec($conexion, $graba))
  	{
  		$confirma = "0";
  	}
  	else
	{
    	$confirma = "1";
		for ($i=0;$i<(count($num_paso0)-1);++$i)
		{
			$sql = odbc_exec($conexion,"SELECT dependencia, unidad FROM cx_org_sub WHERE subdependencia='$f[$i]'");
			$dep_plan = trim(odbc_result($sql,1));
			$uom_plan = trim(odbc_result($sql,2));
			// Se consulta nombre dependencia y unidad 
			$sql1 = odbc_exec($conexion,"SELECT nombre FROM cx_org_dep WHERE dependencia='$dep_plan'");
			$n_dep_plan = trim(odbc_result($sql1,1));
			$sql2 = odbc_exec($conexion,"SELECT nombre FROM cx_org_uni WHERE unidad='$uom_plan'");
			$n_uom_plan = trim(odbc_result($sql2,1));
			// Se consulta maximo
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_val_aut2");
			$consecu1 = odbc_result($cur,1);
            $valor1 = trim($l[$i]);
            $valor1 = str_replace(',','',$valor1);
            $valor1 = substr($valor1, 0,-3);
            $valor1 = floatval($valor1);
            // Se borra registro en cx_val_aut2 previo
			$graba0 = "DELETE FROM cx_val_aut2 WHERE unidad='$f[$i]' AND periodo='$mes' AND ano='$ano' AND solicitud='$c[$i]' AND ano1='$d[$i]'";
			$cur0 = odbc_exec($conexion, $graba0);
			// Se graba discriminado de gastos
			$graba1 = "INSERT INTO cx_val_aut2 (conse, usuario, unidad, periodo, ano, sigla, valor, total, depen, n_depen, uom, n_uom, estado, aprueba, solicitud, registro, pago, ano1, autoriza) VALUES ('$consecu1', '$usu_usuario', '$f[$i]', '$mes', '$ano', '$e[$i]', '$valor1', '$valor1', '$dep_plan', '$n_dep_plan', '$uom_plan', '$n_uom_plan', '', '$usu_usuario', '$c[$i]', '0', '0', '$d[$i]', '$consecu')";
			$cur = odbc_exec($conexion, $graba1);
			$sql3 = odbc_exec($conexion,"UPDATE cx_act_cen SET estado='G' WHERE conse='$a[$i]' AND ano='$b[$i]' AND registro='$c[$i]' AND ano1='$d[$i]'");
			$sql4 = odbc_exec($conexion,"UPDATE cx_reg_rec SET estado='G' WHERE conse='$c[$i]' AND ano='$d[$i]'");		
			// Se graba log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_val_aut2.txt", "a");
			fwrite($file, $fec_log." # ".$graba1." # ".PHP_EOL);
			fclose($file);
		}
  	}
  	// Log
	$fec_log = date("d/m/Y H:i:s a");
  	$file = fopen("log_autoriza1.txt", "a");
	fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
  	fclose($file);
	$salida->salida = $confirma;
  	$salida->conse = $consecu;
	echo json_encode($salida);
}
?>