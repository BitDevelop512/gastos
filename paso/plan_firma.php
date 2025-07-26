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
  $firma = $_POST['firma'];
  if ($firma == "1")
  {
    $query = "SELECT firma FROM cx_usu_web WHERE conse='$con_usuario' AND usuario='$usu_usuario'";
    $sql = odbc_exec($conexion,$query);
    $firma1 = trim(odbc_result($sql,1));
  }
  else
  {
    $firma1 = "";
  }
  $sql1 = odbc_exec($conexion,"DELETE FROM cx_pla_fir WHERE solicitud='$conse' AND ano='$ano' AND unidad='$uni_usuario' AND estado='P'");
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_fir");
	$consecu = odbc_result($cur,1);
	$query1 = "INSERT INTO cx_pla_fir (conse, solicitud, ano, unidad, estado, firma) VALUES ('$consecu', '$conse', '$ano', '$uni_usuario', 'P', '$firma1')";
  if (!odbc_exec($conexion, $query1))
  {
    $confirma = "0";
  }
  else
  {
    $confirma = "1";
  }
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_firmar.txt", "a");
	fwrite($file, $fec_log." # ".$query1." # ".PHP_EOL);
	fclose($file);
	// Se envia verificacion de grabacion
  $salida = new stdClass();
  $salida->salida = $confirma;
  echo json_encode($salida);
}
?>