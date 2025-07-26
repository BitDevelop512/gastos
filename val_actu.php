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
	$unidades = $_POST['unidades'];
	$periodos = $_POST['periodos'];
	$anos = $_POST['anos'];
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
	// Se recorre por unidades
	$valida1 = 0;
	for ($i=0;$i<(count($num_unidades)-1);++$i)
	{
		$cur = odbc_exec($conexion,"SELECT aprueba FROM cx_val_aut WHERE unidad='$a[$i]' AND periodo='$b[$i]' AND ano='$c[$i]'");
		$valida = odbc_result($cur,1);
		if (trim($valida) == "")
		{
			// Se graba discriminado de gastos
			$graba = "UPDATE cx_val_aut SET aprueba='$usu_usuario', fecha_a=getdate(), estado='V' WHERE unidad='$a[$i]' AND periodo='$b[$i]' AND ano='$c[$i]'";
			odbc_exec($conexion, $graba);
			$valida1 = $valida1+1;
		}
	}
	$query1 = "SELECT isnull(max(conse),0)+1 AS conse FROM cx_val_aut";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	// Se actualiza firmas en plan de unidad centralizado
	$graba1 = "UPDATE cx_pla_cen SET visto='$con_usuario', firma3='$nom_usuario', cargo3='$car_usuario' WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
	odbc_exec($conexion, $graba1);
	// Se crea notificacion
	if ($valida1 > 0)
	{
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur1,1);
		// Se consulta JEM Brigada
		if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
		{
			$query2 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='8'";
		}
		else
		{
			$query2 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='7'";
		}
		$cur2 = odbc_exec($conexion,$query2);
		$usuario1 = odbc_result($cur2,1);
		$mensaje = "<br>SE HA DADO VISTO BUENO AL CONSOLIDADO PLAN DE NECESIDADES UNIDAD CENTRALIZADORA.<br><br>";
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario1', '$uni_usuario', '$mensaje', 'A', '1')";
		$sql2 = odbc_exec($conexion, $query2);
		// Notificacion Div
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur1,1);
		// Se consulta centralizadora
		$query3 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND unic='1' ORDER BY subdependencia"; 
		$cur3 = odbc_exec($conexion, $query3);
		$unidad2 = odbc_result($cur3,1);
		// Se consulta usuario division
		if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
		{
 			$query4 = "SELECT usuario FROM cx_usu_web WHERE unidad='$unidad2' AND admin='25'";
 		}
 		else
 		{
 			$query4 = "SELECT usuario FROM cx_usu_web WHERE unidad='$unidad2' AND admin='10'"; 	
 		}
		$cur4 = odbc_exec($conexion, $query4);
		$usuario2 = odbc_result($cur4,1);
		$query5 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario2', '$unidad2', '$mensaje', 'A', '1')";
		$sql5 = odbc_exec($conexion, $query5);
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_auto.txt", "a");
	fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
	fclose($file);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->notifica = $usuario2;
	echo json_encode($salida);
}
// 30/07/2024 - Ajuste firmas y cargos
?>