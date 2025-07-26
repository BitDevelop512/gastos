<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$usuario = $_POST['usuario'];
	$numero = $_POST['numero'];
	$ano = $_POST['ano'];
	$query = "SELECT estado FROM cx_reg_rec WHERE conse='$numero' AND ano='$ano' AND tipo='$tipo'";
	$sql = odbc_exec($conexion, $query);
	$estado = trim(odbc_result($sql,1));
	if (($estado == "") or ($estado == "Y"))
	{
		$estado1 = "A";
	}
	else
	{
		if ($estado == "A")
		{
			$estado1 = "B";
		}
		else
		{
			$estado1 = "C";	
		}
	}
	$actu = "UPDATE cx_reg_rec SET estado='$estado1', usuario1='$usuario' WHERE conse='$numero' AND ano='$ano' AND tipo='$tipo'";
	if (!odbc_exec($conexion, $actu))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	// Se graba notificacion
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
	$consecu = odbc_result($cur,1);
	$query1 = "SELECT usuario, unidad FROM cx_usu_web WHERE usuario='$usuario'"; 
	$cur1 = odbc_exec($conexion, $query1);
	$usuario1 = odbc_result($cur1,1);
	$unidad1 = odbc_result($cur1,2);
	if ($tipo == "0")
	{
		$mensaje = "<br>SE SOLICITA REVISION DEL REGISTRO DE RECOMPENSA ".$numero." / ".$ano.".<br><br>";
	}
	else
	{
		$mensaje = "<br>SE SOLICITA REVISION DEL REGISTRO DE PAGO DE INFORMACIÓN ".$numero." / ".$ano.".<br><br>";
	}
	$mensaje = iconv("UTF-8", "ISO-8859-1", $mensaje);
	$query1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad1', '$mensaje', 'S', '1')";
	$sql1 = odbc_exec($conexion, $query1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_recomp1.txt", "a");
	fwrite($file, $fec_log." # ".$actu." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	$salida->salida1 = $estado1;
	echo json_encode($salida);
}
?>