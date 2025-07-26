<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$cedulas = $_POST['cedulas'];
	$nombres = $_POST['nombres'];
	$factores = $_POST['factores'];
	$estructuras = $_POST['estructuras'];
	$fechas1 = $_POST['fechas1'];
	$sintesis = $_POST['sintesis'];
	$recolecciones = $_POST['recolecciones'];
	$nrecolecciones = $_POST['nrecolecciones'];
	$fechas4 = $_POST['fechas4'];
	$difusiones = $_POST['difusiones'];
	$ndifusiones = $_POST['ndifusiones'];
	$fechas2 = $_POST['fechas2'];
	$unidades = $_POST['unidades'];
	$resultados = $_POST['resultados'];
	$radiogramas = $_POST['radiogramas'];
	$fechas3 = $_POST['fechas3'];
	$ordops = $_POST['ordops'];
	$batallones = $_POST['batallones'];
	$fechas5 = $_POST['fechas5'];
	$utilidades = $_POST['utilidades'];
	$valores = $_POST['valores'];
	$ano = $_POST['ano'];
	$datos = "";
	$query = "UPDATE cx_pla_inv SET pagos='$datos', actual='2', estado='' WHERE conse='$conse' AND ano='$ano' AND unidad!='999'";
	$sql = odbc_exec($conexion, $query);
    // Ajuste de valores en 0 y blancos
    $query0 = "UPDATE cx_pla_pag SET val_fuen='0.00' WHERE val_fuen=''";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_pag SET val_fuen='0.00' WHERE val_fuen='0'";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_pag SET val_fuen_a='0.00' WHERE val_fuen_a=''";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_pag SET val_fuen_a='0.00' WHERE val_fuen_a='0'";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_pag SET val_fuen_c='0.00' WHERE val_fuen_c=''";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_pag SET val_fuen_c='0.00' WHERE val_fuen_c='0'";
    $sql0 = odbc_exec($conexion, $query0);
	// Se extraen las datos por separado para grabar
	$num_cedulas = explode("|",$cedulas);
	for ($i=0;$i<count($num_cedulas);++$i)
	{
		$a[$i] = trim($num_cedulas[$i]);
	}
	$num_nombres = explode("|",$nombres);
	for ($i=0;$i<count($num_nombres);++$i)
	{
		$b[$i] = trim($num_nombres[$i]);
		$b[$i] = strtr(trim($b[$i]),$sustituye);
		$b[$i] = iconv("UTF-8", "ISO-8859-1", $b[$i]);
		$b[$i] = strtoupper($b[$i]);
	}
	$num_factores = explode("|",$factores);
	for ($i=0;$i<count($num_factores);++$i)
	{
		$c[$i] = trim($num_factores[$i]);
	}
	$num_estructuras = explode("|",$estructuras);
	for ($i=0;$i<count($num_estructuras);++$i)
	{
		$d[$i] = trim($num_estructuras[$i]);
	}
	$num_fechas1 = explode("|",$fechas1);
	for ($i=0;$i<count($num_fechas1);++$i)
	{
		$e[$i] = trim($num_fechas1[$i]);
	}
	$num_sintesis = explode("|",$sintesis);
	for ($i=0;$i<count($num_sintesis);++$i)
	{
		$f[$i] = trim($num_sintesis[$i]);
		$f[$i] = strtr(trim($f[$i]), $sustituye);
		$f[$i] = iconv("UTF-8", "ISO-8859-1", $f[$i]);
	}
	$num_recolecciones = explode("|",$recolecciones);
	for ($i=0;$i<count($num_recolecciones);++$i)
	{
		$q[$i] = trim($num_recolecciones[$i]);
	}
	$num_recolecciones1 = explode("|",$nrecolecciones);
	for ($i=0;$i<count($num_recolecciones1);++$i)
	{
		$r[$i] = trim($num_recolecciones1[$i]);
	}
	$num_fechas4 = explode("|",$fechas4);
	for ($i=0;$i<count($num_fechas4);++$i)
	{
		$s[$i] = trim($num_fechas4[$i]);
	}
	$num_difusiones = explode("|",$difusiones);
	for ($i=0;$i<count($num_difusiones);++$i)
	{
		$g[$i] = trim($num_difusiones[$i]);
	}
	$num_ndifusiones = explode("|",$ndifusiones);
	for ($i=0;$i<count($num_ndifusiones);++$i)
	{
		$h[$i] = trim($num_ndifusiones[$i]);
	}
	$num_fechas2 = explode("|",$fechas2);
	for ($i=0;$i<count($num_fechas2);++$i)
	{
		$j[$i] = trim($num_fechas2[$i]);
	}
	$num_resultados = explode("|",$resultados);
	for ($i=0;$i<count($num_resultados);++$i)
	{
		$k[$i] = trim($num_resultados[$i]);
	}
	$num_radiogramas = explode("|",$radiogramas);
	for ($i=0;$i<count($num_radiogramas);++$i)
	{
		$l[$i] = trim($num_radiogramas[$i]);
	}
	$num_fechas3 = explode("|",$fechas3);
	for ($i=0;$i<count($num_fechas3);++$i)
	{
		$m[$i] = trim($num_fechas3[$i]);
	}
	$num_ordops = explode("|",$ordops);
	for ($i=0;$i<count($num_ordops);++$i)
	{
		$t[$i] = trim($num_ordops[$i]);
		$t[$i] = strtr(trim($t[$i]),$sustituye);
		$t[$i] = iconv("UTF-8", "ISO-8859-1", $t[$i]);
	}
	$num_batallones = explode("|",$batallones);
	for ($i=0;$i<count($num_batallones);++$i)
	{
		$u[$i] = trim($num_batallones[$i]);
		$u[$i] = strtr(trim($u[$i]),$sustituye);
		$u[$i] = iconv("UTF-8", "ISO-8859-1", $u[$i]);
	}
	$num_fechas5 = explode("|",$fechas5);
	for ($i=0;$i<count($num_fechas5);++$i)
	{
		$v[$i] = trim($num_fechas5[$i]);
	}
	$num_utilidades = explode("|",$utilidades);
	for ($i=0;$i<count($num_utilidades);++$i)
	{
		$n[$i] = trim($num_utilidades[$i]);
		$n[$i] = strtr(trim($n[$i]),$sustituye);
		$n[$i] = iconv("UTF-8", "ISO-8859-1", $n[$i]);
	}
	$num_valores = explode("|",$valores);
	for ($i=0;$i<count($num_valores);++$i)
	{
		$o[$i] = trim($num_valores[$i]);
	}
	$num_unidades = explode("|",$unidades);
	for ($i=0;$i<count($num_unidades);++$i)
	{
		$p[$i] = trim($num_unidades[$i]);
	}
	$borra = "DELETE FROM cx_pla_pag WHERE conse='$conse' AND ano='$ano'";
	odbc_exec($conexion, $borra);
	for ($i=0;$i<(count($num_cedulas)-1);++$i)
	{
		$z=$i+1;
		if ($tpc_usuario == "1")
		{
			$val_fuen_a = $o[$i];
		}
		else
		{
			$val_fuen_a = "0.00";
		}
		// Se graba discriminado de gastos del plan
		$graba = "INSERT INTO cx_pla_pag (conse, conse1, unidad, ced_fuen, nom_fuen, fac_fuen, est_fuen, fec_inf, sin_fuen, dif_fuen, din_fuen, fec_dif, res_fuen, rad_fuen, fec_rad, uti_fuen, val_fuen, val_fuen_a, uni_fuen, rec_fuen, ren_fuen, fec_rec, ord_fuen, bat_fuen, fec_ret, ano) VALUES ('$conse', '$z', '$unidad', '$a[$i]', '$b[$i]', '$c[$i]', '$d[$i]', '$e[$i]', '$f[$i]', '$g[$i]', '$h[$i]', '$j[$i]', '$k[$i]', '$l[$i]', '$m[$i]', '$n[$i]', '$o[$i]', '$val_fuen_a', '$p[$i]', '$q[$i]', '$r[$i]', '$s[$i]', '$t[$i]', '$u[$i]', '$v[$i]', '$ano')";
		odbc_exec($conexion, $graba);
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_plan_pag.txt", "a");
		fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
		// Se valida que el informante de esa unidad no exista ya en la base de datos
	  	$cur = odbc_exec($conexion,"SELECT count(*) AS total FROM cx_pla_inf WHERE cedula='$a[$i]' AND unidad='$unidad'");
	  	$conse1 = odbc_result($cur,1);
	  	// Se el contador es 0 se graba el informante
	  	if ($conse1 == "0")
	  	{
	  		if ($a[$i] == "")
	  		{
	  		}
	  		else
	  		{
				$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse1 FROM cx_pla_inf");
			  	$conse2 = odbc_result($cur1,1);
			  	$query2 = "INSERT INTO cx_pla_inf (conse, usuario, unidad, cedula, nombre) VALUES ('$conse2', '$usuario', '$unidad', '$a[$i]', '$b[$i]')";
			  	odbc_exec($conexion,$query2);
			}
	  	}
	}
	// Se valida que se grabe campo actual
	$query1 = "SELECT actual, estado FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	$estado = odbc_result($cur,2);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_plan.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->salida1 = $estado;
	echo json_encode($salida);
}
// 10/08/2023 - Ajuste de valores en 0 y blancos en cx_pla_pag
?>