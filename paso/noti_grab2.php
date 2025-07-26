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
	$motivo = $_POST['motivo'];
	$motivo = iconv("UTF-8", "ISO-8859-1", $motivo);
	// Se consulta datos para firmas
	$preg = "SELECT nombre, cargo, cedula FROM cx_usu_web WHERE usuario='$usu_usuario'";
	$con = odbc_exec($conexion, $preg);
	$v_nom = trim(odbc_result($con,1));
	$v_car = trim(odbc_result($con,2));
	$v_ced = trim(odbc_result($con,3));
	$v_fir = $v_nom."»".$v_car."»".$v_ced."»";
	// Se graba la observacion
	$query = "INSERT INTO cx_pla_rev (conse, usuario, unidad, estado, motivo, ano) VALUES ('$conse', '$usu_usuario', '$uni_usuario', 'Y', '$motivo', '$ano')";
	$sql = odbc_exec($conexion, $query);
	// Se consulta estado y tipo para verificar mensaje
  	$preg0 = "SELECT tipo, estado, revisa, usuario FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano'";
  	$sql0 = odbc_exec($conexion,$preg0);
  	$tipo = odbc_result($sql0,1);
  	$estado = trim(odbc_result($sql0,2));
  	$revisa = odbc_result($sql0,3);
  	$usuario = trim(odbc_result($sql0,4));
	// Se crea notificacion
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
	$consecu = odbc_result($cur1,1);
	// Mensaje
	if ($tipo == "1")
	{
		$mensaje = "<br>EL PLAN DE INVERSION ".$conse." DE ".$ano;
	}
	else
	{
		$mensaje = "<br>LA SOLICITUD DE RECURSOS ".$conse." DE ".$ano;
	}
	$mensaje .= " HA SIDO RECHAZADO(A) POR: ".strtoupper($motivo)." POR EL USUARIO ".$usu_usuario.".<br><br>";
	$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$usuario', '$uni_usuario', '$mensaje', 'R', '1')";
	$sql2 = odbc_exec($conexion, $query2);

	// Se graba segunda notificación al usuario que rechaza el plan / solicitud
	$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
	$consecu1 = odbc_result($cur2,1);
	$mensaje1 = $mensaje." Y ENVIADO(A) AL USUARIO ".$usuario."<br><br>";
	$query3 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usu_usuario', '$uni_usuario', '$mensaje1', 'R', '1')";
	$sql3 = odbc_exec($conexion, $query3);
	// Se actualiza estado en la tabla cx_plan_inv y quien aprobo o rechazo
	$query4 = "UPDATE cx_pla_inv SET estado='Y', aprueba='$con_usuario', usuario16='$usu_usuario', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano' AND estado='P'";
	$sql4 = odbc_exec($conexion, $query4);
	// Se graba log
    $fec_log = date("d/m/Y H:i:s a");
    $file = fopen("log_noti.txt", "a");
    fwrite($file, $fec_log." # ".$query2." # ".PHP_EOL);
    fwrite($file, $fec_log." # ".$query3." # ".PHP_EOL);
    fwrite($file, $fec_log." # ".PHP_EOL);
    fclose($file);
}
?>