<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$nom_usuario1 = iconv("UTF-8", "ISO-8859-1", $nom_usuario);
if (is_ajax())
{
	$retorna = "0";
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	if ($adm_usuario == "14")
	{
		$pregunta = "SELECT * FROM cx_pla_nes WHERE periodo='$periodo' AND ano='$ano'";	
		$cur4 = odbc_exec($conexion, $pregunta);
		$total = odbc_num_rows($cur4);
		if ($total == "0")
		{
			$pregunta1 = "SELECT * FROM cx_val_aut WHERE periodo='$periodo' AND ano='$ano'";	
			$cur6 = odbc_exec($conexion, $pregunta1);
			$total1 = odbc_num_rows($cur6);
			if ($total1 == "0")
			{
			}
			else
			{
				$cur0 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_nes");
				$consecu0 = odbc_result($cur0,1);
				$query0 = "INSERT INTO cx_pla_nes (conse, usuario, unidad, periodo, ano, aprueba, nombre) VALUES ('$consecu0', '$usu_usuario', '$uni_usuario', '$periodo', '$ano', '1', '$nom_usuario1')";
				$sql0 = odbc_exec($conexion, $query0);
				// Log
			    $fec_log = date("d/m/Y H:i:s a");
			    $file = fopen("log_plan_nes.txt", "a");
			    fwrite($file, $fec_log." # ".$query0." # ".PHP_EOL);
			    fclose($file);
				// Notificacion
				$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
				$consecu2 = odbc_result($cur2,1);
			 	$query2 = "SELECT usuario, unidad FROM cx_usu_web WHERE usuario='OPD_DIADI'"; 
			  	$cur3 = odbc_exec($conexion, $query2);
				$usuario2 = odbc_result($cur3,1);
				$unidad2 = odbc_result($cur3,2);
			  	$mensaje1 = "<br>SE HA GENERADO EL PLAN DE NECESIDADES, SE ESPERA VERIFICACION Y APROBACION.<br><br>";
				$query3 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu2', '$usu_usuario', '$uni_usuario', '$usuario2', '$unidad2', '$mensaje1', 'A', '1')";
				$sql2 = odbc_exec($conexion, $query3);
				$retorna = "1";
			}
		}
	}
	if ($adm_usuario == "16")
	{
		// Notificacion
		$pregunta1 = "SELECT * FROM cx_pla_nes WHERE periodo='$periodo' AND ano='$ano' AND aprueba1='0'";
		$cur5 = odbc_exec($conexion, $pregunta1);
		$total1 = odbc_num_rows($cur5);
		if ($total1 == "1")
		{
			$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
			$consecu2 = odbc_result($cur2,1);
		 	$query2 = "SELECT usuario, unidad FROM cx_usu_web WHERE usuario='DIR_DIADI'"; 
		  	$cur3 = odbc_exec($conexion, $query2);
		  	$usuario2 = odbc_result($cur3,1);
		  	$unidad2 = odbc_result($cur3,2);
		  	$mensaje1 = "SE HA GENERADO EL PLAN DE NECESIDADES, SE ESPERA VERIFICACION Y APROBACION.";
			$query3 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu2', '$usu_usuario', '$uni_usuario', '$usuario2', '$unidad2', '$mensaje1', 'A', '1')";
			$sql2 = odbc_exec($conexion, $query3);
			$query4 = "UPDATE cx_pla_nes SET aprueba1='$con_usuario', nombre1='$nom_usuario1' WHERE periodo='$periodo' AND ano='$ano'";
			$cur4 = odbc_exec($conexion, $query4);
		}
		$query5 = "UPDATE cx_inf_uni SET aprueba1='$con_usuario' WHERE periodo='$periodo' AND ano='$ano'";
		$cur5 = odbc_exec($conexion, $query5);
	}
	if ($adm_usuario == "17")
	{
		// Notificacion
		$pregunta1 = "SELECT * FROM cx_pla_nes WHERE periodo='$periodo' AND ano='$ano' AND aprueba2='0'";	
		$cur5 = odbc_exec($conexion, $pregunta1);
		$total1 = odbc_num_rows($cur5);
		if ($total1 == "1")
		{
			$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
			$consecu2 = odbc_result($cur2,1);
		 	$query2 = "SELECT usuario, unidad FROM cx_usu_web WHERE usuario='JEF_CEDE2'"; 
		  	$cur3 = odbc_exec($conexion, $query2);
		  	$usuario2 = odbc_result($cur3,1);
		  	$unidad2 = odbc_result($cur3,2);
		  	$mensaje1 = "SE HA GENERADO EL PLAN DE NECESIDADES, SE ESPERA VERIFICACION Y APROBACION.";
			$query3 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu2', '$usu_usuario', '$uni_usuario', '$usuario2', '$unidad2', '$mensaje1', 'A', '1')";
			$sql2 = odbc_exec($conexion, $query3);
			$query4 = "UPDATE cx_pla_nes SET aprueba2='$con_usuario', nombre2='$nom_usuario1' WHERE periodo='$periodo' AND ano='$ano'";
			$cur4 = odbc_exec($conexion, $query4);
		}
		$query5 = "UPDATE cx_inf_uni SET aprueba2='$con_usuario' WHERE periodo='$periodo' AND ano='$ano'";
		$cur5 = odbc_exec($conexion, $query5);
	}
	if ($adm_usuario == "18")
	{
		// JEF_CEDE2
		$pregunta1 = "SELECT * FROM cx_pla_nes WHERE periodo='$periodo' AND ano='$ano' AND aprueba3='0'";
		$cur5 = odbc_exec($conexion, $pregunta1);
		$total1 = odbc_num_rows($cur5);
		if ($total1 == "1")
		{
			$query4 = "UPDATE cx_pla_nes SET aprueba3='$con_usuario', nombre3='$nom_usuario1' WHERE periodo='$periodo' AND ano='$ano'";
			$cur4 = odbc_exec($conexion, $query4);
		}
		$query5 = "UPDATE cx_inf_uni SET aprueba3='$con_usuario' WHERE periodo='$periodo' AND ano='$ano'";
		$cur5 = odbc_exec($conexion, $query5);
		// Se registra notificacion
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur1,1);
	 	$query = "SELECT usuario, unidad FROM cx_usu_web WHERE usuario='STE_DIADI'"; 
	  	$cur = odbc_exec($conexion, $query);
	  	$usuario1 = odbc_result($cur,1);
	  	$unidad1 = odbc_result($cur,2);
	  	$mensaje = "SE HA APROBADO EL PLAN DE NECESIDADES, SE DEBE PROCEDER A REALIZAR EL INFORME DE GIRO.";
		$query1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad1', '$mensaje', 'A', '1')";
		$sql1 = odbc_exec($conexion, $query1);
	}
	$salida = new stdClass();
	$salida->salida = $retorna;
	echo json_encode($salida);
}
?>