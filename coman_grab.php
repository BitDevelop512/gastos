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
	if ($mes == "12")
	{
		$ano = $ano+1;
	}
	$valores = trim($_POST['valores']);
	if ($valores == "")
	{
	}
	else
	{
		$num_valores = explode("#",$valores);
		for ($i=0; $i<count($num_valores)-1; $i++)
		{
			$paso = $num_valores[$i];
			$num_valores1 = explode("|",$paso);
			$unidad = $num_valores1[0];
			$tipo = $num_valores1[1];
			$detalle = $num_valores1[2];
			$num_valores2 = explode("€",$detalle);
			$num_valores2_1 = count($num_valores2)-1;
			for ($j=0; $j<$num_valores2_1; $j++)
			{
				$paso1 = $num_valores2[$j];
				$num_valores3 = explode("»",$paso1);
				$num_valores3_1 = count($num_valores3)-1;
				if ($tipo == "2")
				{
					$var1 = trim($num_valores3[0]);
					$var2 = trim($num_valores3[1]);
					$var3 = trim($num_valores3[2]);
					$var4 = trim($num_valores3[3]);
					$query = "SELECT val_fuen_a FROM cx_pla_pag WHERE conse='$var3' AND conse1='$var1' AND unidad='$unidad' AND ano='$ano'";
					$cur = odbc_exec($conexion, $query);
					$var5 = trim(odbc_result($cur,1));
					$query1 = "UPDATE cx_pla_pag SET val_fuen_a='$var4', val_fuen_c='$var5' WHERE conse='$var3' AND conse1='$var1' AND unidad='$unidad' AND ano='$ano'";
					$cur1 = odbc_exec($conexion, $query1);
					// Se graba log
					$fec_log = date("d/m/Y H:i:s a");
					$file = fopen("log_coman2.txt", "a");
					fwrite($file, $fec_log." # ".$query." # ".$query1." # ".$usu_usuario." # ".PHP_EOL);
					fclose($file);
				}
				else
				{
					$var1 = trim($num_valores3[0]);
					$var2 = trim($num_valores3[1]);
					$var3 = trim($num_valores3[2]);
					$var4 = trim($num_valores3[3]);
					$query = "SELECT valor_a, conse1 FROM cx_pla_gas WHERE conse='$var3' AND unidad='$unidad' AND ano='$ano'";
					$cur = odbc_exec($conexion, $query);
					$var5 = trim(odbc_result($cur,1));
					$var6 = odbc_result($cur,2);
					// Discriminado
					$query0 = "SELECT conse FROM cx_pla_gad WHERE conse1='$var6' AND interno='$var1' AND unidad='$unidad' AND ano='$ano'";
					$cur0 = odbc_exec($conexion, $query0);
					// Actualizacion
					$query1 = "UPDATE cx_pla_gas SET valor='$var4', valor_a='$var4', valor_c='$var5' WHERE conse='$var3' AND unidad='$unidad' AND ano='$ano'";
					$cur1 = odbc_exec($conexion, $query1);
					// Se graba log
					$fec_log = date("d/m/Y H:i:s a");
					$file = fopen("log_coman1.txt", "a");
					fwrite($file, $fec_log." # ".$query." # ".$query0." # ".$query1." # ".$usu_usuario." # ".PHP_EOL);
					fclose($file);
				}
			}
			// Se graba log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_coman.txt", "a");
			fwrite($file, $fec_log." # ".$valores." # ".PHP_EOL);
			fclose($file);
		}
	}
	// Ajuste para modificar gasto discriminado
	$valores1 = trim($_POST['valores1']);
	if ($valores1 == "")
	{
	}
	else
	{
		$num_valores = explode("»",$valores1);
		for ($i=0; $i<count($num_valores)-1; $i++)
		{
			$paso = $num_valores[$i];
			$num_valores1 = explode("#",$paso);
			$var1 = $num_valores1[0];
			$var2 = $num_valores1[1];
			$var3 = $num_valores1[2];
			$num_valores2 = explode("|",$var1);
			$num_valores3 = explode("|",$var2);
			$num_valores4 = explode("|",$var3);
			for ($j=0; $j<count($num_valores1); $j++)
			{
				$query3 = "UPDATE cx_pla_gad SET valor='$num_valores2[$j]' WHERE conse='$num_valores3[$j]' AND gasto='$num_valores4[$j]'";
				$cur3 = odbc_exec($conexion, $query3);
				// Se graba log
				$fec_log = date("d/m/Y H:i:s a");
				$file = fopen("log_coman3.txt", "a");
				fwrite($file, $fec_log." # ".$query3." # ".$usu_usuario." # ".PHP_EOL);
				fclose($file);
			}
		}
	}
}
?>