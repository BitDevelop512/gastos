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
	$valor = $_POST['valor'];
	// Se consulta datos para firmas
	$preg = "SELECT nombre, cargo, cedula FROM cx_usu_web WHERE usuario='$usu_usuario'";
	$con = odbc_exec($conexion, $preg);
	$v_nom = trim(odbc_result($con,1));
	$v_car = trim(odbc_result($con,2));
	$v_ced = trim(odbc_result($con,3));
	$v_fir = $v_nom."»".$v_car."»".$v_ced."»";
	// Se consulta estado y tipo para verificar boton de mensaje
  	$preg0 = "SELECT tipo, estado, revisa, usuario FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano'";
  	$sql0 = odbc_exec($conexion,$preg0);
  	$tipo = odbc_result($sql0,1);
  	$estado = trim(odbc_result($sql0,2));
  	$revisa = odbc_result($sql0,3);
  	$usuario = trim(odbc_result($sql0,4));
	$salida = new stdClass();
  	if (($estado == "P") and ($revisa == "0"))
  	{
		if ($valor == "1")
		{
			// Se actualiza el usuario que reviso el plan / solicitud
			$cur0 = "UPDATE cx_pla_inv SET revisa='$con_usuario', usuario1='$usu_usuario', firma2='$v_fir' WHERE conse='$conse' AND ano='$ano' AND estado='P'";
			$sql0 = odbc_exec($conexion,$cur0);
			// Mensaje
		  	if ($tipo == "1")
		  	{
		  		$mensaje = "<br>EL PLAN DE INVERSION ".$conse." DE ".$ano;
		  	}
		  	else
		  	{
		  		$mensaje = "<br>LA SOLICITUD DE RECURSOS ".$conse." DE ".$ano;
		  	}
			$mensaje1 = $mensaje.' HA SIDO APROBADA POR EL USUARIO '.$usu_usuario.'. SE SOLICITA REVISION DEL MISMO.<br><br><button type="button" name="revisa" id="revisa" class="btn btn-block btn-primary" onclick="link2();"><font face="Verdana" size="3">Revisar Plan</font></button><br>';
			// Se notifica al S4
			$query1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='3'";
			$sql1 = odbc_exec($conexion,$query1);
			$usuario1 = trim(odbc_result($sql1,1));
			// Se crea notificacion al siguiente usuario
			$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
			$consecu = odbc_result($cur1,1);
			$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$usuario1', '$uni_usuario', '$mensaje1', 'S', '1')";
			$sql2 = odbc_exec($conexion, $query2);
			// Se graba segunda notificación al usuario que aprueba el plan / solicitud
			$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
			$consecu1 = odbc_result($cur2,1);
			$mensaje2 = $mensaje." HA SIDO ENVIADO(A) AL USUARIO ".$usuario1."<br><br>";
			$query3 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usu_usuario', '$uni_usuario', '$mensaje2', 'S', '1')";
			$sql3 = odbc_exec($conexion, $query3);
			// Se graba tercera notificación al usuario que crea el plan / solicitud
			$cur3 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
			$consecu2 = odbc_result($cur3,1);
			$mensaje3 = $mensaje." HA SIDO APROBADO(A) POR EL USUARIO ".$usu_usuario."<br><br>";
			$query4 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu2', '$usu_usuario', '$uni_usuario', '$usuario', '$uni_usuario', '$mensaje3', 'S', '1')";
			$sql4 = odbc_exec($conexion, $query4);
			// Se graba log
		    $fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_noti.txt", "a");
		    fwrite($file, $fec_log." # ".$query2." # ".PHP_EOL);
			fwrite($file, $fec_log." # ".$query3." # ".PHP_EOL);
			fwrite($file, $fec_log." # ".$query4." # ".PHP_EOL);
			fwrite($file, $fec_log." # ".PHP_EOL);
		    fclose($file);
		    $salida->confirma = "1";
		    $salida->notifica = $usuario1;
		}
		else
		{
			$salida->confirma = "2";
		}
	}
	else
	{
	    $salida->confirma = "0";
	}
	echo json_encode($salida);
}
?>