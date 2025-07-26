<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
	$admin = $_POST['admin'];
	$centra = $_POST['centra'];
	$nombre = trim($_POST['nombre']);
	$nombre = iconv("UTF-8", "ISO-8859-1", $nombre);
	$cedula = trim($_POST['cedula']);
	$cargo = $_POST['cargo'];
	$cargo = str_replace("'", '"', $cargo);
	$cargo = iconv("UTF-8", "ISO-8859-1", $cargo);
	$ciudad = trim($_POST['ciudad']);
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	$email = trim($_POST['email']);
	$nit = $_POST['nit'];
	$banco = $_POST['banco'];
	$cuenta = $_POST['cuenta'];
	$cheque = $_POST['cheque'];
	$cheque1 = $_POST['cheque1'];
	$cheque2 = $_POST['cheque2'];
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
	$telefono = $_POST['telefono'];
	$cheque = $cheque."|".$cheque1."|".$cheque2;
	// Se actualiza parametrizacion de usuario
	$query = "UPDATE cx_usu_web SET nombre='$nombre', cedula='$cedula', cargo='$cargo', ciudad='$ciudad', email='$email', telefono='$telefono' WHERE conse='$con_usuario' AND usuario='$usu_usuario'";
	$sql = odbc_exec($conexion, $query);
	$_SESSION["nom_usuario"] = $nombre;
	$_SESSION["ciu_usuario"] = $ciudad;
	// Se actualiza la parametrizacion
	if ($centra == "1")
	{
		$query1 = "UPDATE cx_org_sub SET nit='$nit', banco='$banco', cuenta='$cuenta', cheque='$cheque', firma1='$firma1', firma2='$firma2', firma3='$firma3', cargo1='$cargo1', cargo2='$cargo2', cargo3='$cargo3', usuario='$usu_usuario' WHERE subdependencia='$uni_usuario'";
		$sql1 = odbc_exec($conexion, $query1);
	}
	// Se refresca sesion de ciudad
	$query2 = "SELECT ciudad FROM cx_usu_web WHERE usuario='$usu_usuario'";
	$sql2 = odbc_exec($conexion, $query2);
	$ciudad = trim(utf8_encode(odbc_result($sql2,1)));
	$_SESSION["ciu_usuario"] = $ciudad;
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_regi.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
	if ($centra == "1")
	{
		fwrite($file, $fec_log." # ".$query1." # ".$usu_usuario." # ".PHP_EOL);
	}
	fwrite($file, $fec_log.PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = "1";
	echo json_encode($salida);
}
// 04/04/2024 - Ajuste bloqueo pegado sobre campo firmas
// 13/12/2024 - Ajuste amplitud caracteres cargos log
// 05/03/2025 - Ajuste comillas sencillas cargo
?>