<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$ano = $_POST['ano'];
	$carpeta = $_POST['carpeta'];
	$unidad1 = trim($_POST['unidad1']);
	$unidad2 = trim($_POST['unidad2']);
	$unidad3 = $_POST['unidad3'];
	$fecha = $_POST['fecha'];
	$resultado = trim($_POST['resultado']);
	$usuario = trim($_POST['usuario']);
	$observaciones = trim($_POST['observaciones']);
	$observaciones = iconv("UTF-8", "ISO-8859-1", $observaciones);
	$oficio = $_POST['oficio'];
	$fec_ofi = $_POST['fec_ofi'];
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_reg_rev");
	$consecu = odbc_result($cur,1);
	$query = "INSERT INTO cx_reg_rev (conse, usuario, unidad, fec_rec, resultado, observaciones, consecu, ano, unidad1, unidad2, usuario1, oficio, fec_ofi) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$fecha', '$resultado', '$observaciones', '$conse', '$ano', '$unidad1', '$unidad2', '$usuario', '$oficio', '$fec_ofi')";
	$sql = odbc_exec($conexion, $query);
	$query1 = "SELECT conse FROM cx_reg_rev WHERE conse='$consecu'";
	$cur1 = odbc_exec($conexion, $query1);
	$consecu1 = odbc_result($cur1,1);
	$query2 = "SELECT estado FROM cx_reg_rec WHERE conse='$conse' AND ano='$ano' AND codigo='$carpeta'";
	$cur2 = odbc_exec($conexion, $query2);
	$estado1 = odbc_result($cur2,1);
	// Se valida si es unidad especial para saltar estado
	$query3 = "SELECT unidad FROM cx_usu_web WHERE usuario='$usuario'";
	$cur3 = odbc_exec($conexion, $query3);
	$unidad4 = odbc_result($cur3,1);
	$query4 = "SELECT especial FROM cx_org_sub WHERE subdependencia='$unidad4'";
	$cur4 = odbc_exec($conexion, $query4);
	$especial = odbc_result($cur4,1);
	if ($resultado == "A")
	{
		switch ($estado1)
		{
			case 'A':
				if ($especial != "0")
				{
					$estado2 = "B";
					$query3 = "UPDATE cx_reg_rec SET estado='$estado2', usuario2='$usuario' WHERE conse='$conse' AND ano='$ano' AND codigo='$carpeta'";
				}
				else
				{
					$estado2 = "C";
					$query3 = "UPDATE cx_reg_rec SET estado='$estado2', usuario3='$usuario' WHERE conse='$conse' AND ano='$ano' AND codigo='$carpeta'";
				}
				break;
			case 'B':
				$estado2 = "C";
				$query3 = "UPDATE cx_reg_rec SET estado='$estado2', usuario3='$usuario' WHERE conse='$conse' AND ano='$ano' AND codigo='$carpeta'";
				break;
			case 'C':
				$estado2 = "D";
				$query3 = "UPDATE cx_reg_rec SET estado='$estado2', usuario4='SPR_DIADI' WHERE conse='$conse' AND ano='$ano' AND codigo='$carpeta'";
				break;
			case 'D':
				$estado2 = "E";
				$query3 = "UPDATE cx_reg_rec SET estado='$estado2', usuario5='$usuario' WHERE conse='$conse' AND ano='$ano' AND codigo='$carpeta'";
				break;
			case 'E':
				$estado2 = "E";
				$query3 = "UPDATE cx_reg_rec SET estado='$estado2', usuario4='$usuario' WHERE conse='$conse' AND ano='$ano' AND codigo='$carpeta'";
				break;
			default:
				$estado2 = "";
				$query3 = "UPDATE cx_reg_rec SET estado='$estado2' WHERE conse='$conse' AND ano='$ano' AND codigo='$carpeta'";
				break;
		}
	}
	else
	{
		$estado2 = $resultado;
		$query3 = "UPDATE cx_reg_rec SET estado='$estado2', usuario1='', usuario2='', usuario3='', usuario4='', usuario5='' WHERE conse='$conse' AND ano='$ano' AND codigo='$carpeta'";
	}
	$cur3 = odbc_exec($conexion, $query3);
	// Se crea notificacion
	$cur4 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
	$consecu2 = odbc_result($cur4,1);
	if ($resultado == "A")
	{
		$mensaje = "<br>SE SOLICITA REVISION DEL REGISTRO DE RECOMPENSA ".$conse." / ".$ano.".<br><br>";
	}
	else
	{
		$mensaje = "<br>SE RECHAZO EL REGISTRO DE RECOMPENSA ".$conse." / ".$ano.". OBSERVACIONES: ".$observaciones."<br><br>";
	}
	$query4 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu2', '$usu_usuario', '$uni_usuario', '$usuario', '$unidad3', '$mensaje', 'S', '1')";
	$cur4 = odbc_exec($conexion, $query4);
	// Se modifica estado acta regional si existe
	$query5 = "SELECT estado FROM cx_act_reg WHERE registro='$conse' AND ano1='$ano'";
	$cur5 = odbc_exec($conexion, $query5);
	$total5 = odbc_num_rows($cur5);
	if ($total5 > 0)
	{
		$estado3 = odbc_result($cur5,1);
		if (($estado3 == "D") or ($estado3 == "E"))
		{
			$query6 = "UPDATE cx_act_reg SET estado='' WHERE registro='$conse' AND ano1='$ano'";
			$cur6 = odbc_exec($conexion, $query6);
		}
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_recomp_revi.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
	fwrite($file, $fec_log." # ".$query3." # ".$usu_usuario." # ".PHP_EOL);
	fwrite($file, " ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $consecu;
	$salida->estado = $estado2;
	echo json_encode($salida);
}
?>