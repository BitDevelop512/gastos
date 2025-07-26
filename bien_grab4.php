<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$placa = $_POST['placa'];
	$cantidad = $_POST['cantidad'];
	$pregunta = "SELECT fecha, usuario, clase, nombre, unidad, funcionario, ordop, mision, numero, relacion, compania, estado, egreso, ordop1, mision1 FROM cx_pla_bie WHERE codigo='$placa'";
	$sql = odbc_exec($conexion,$pregunta);
	$fecha = substr(odbc_result($sql,1),0,10);
	$fecha = str_replace("-", "", $fecha);
	$usuario = trim(odbc_result($sql,2));
	$clase = odbc_result($sql,3);
	$nombre = trim(utf8_encode(odbc_result($sql,4)));
	$unidad = odbc_result($sql,5);
	$funcionario = trim(utf8_encode(odbc_result($sql,6)));
	$ordop = trim(utf8_encode(odbc_result($sql,7)));
	$mision = trim(utf8_encode(odbc_result($sql,8)));
	$numero = odbc_result($sql,9);
	$relacion = odbc_result($sql,10);
	$compania = trim(utf8_encode(odbc_result($sql,11)));
	$estado = odbc_result($sql,12);
	$egreso = odbc_result($sql,13);
	$ordop1 = trim(utf8_encode(odbc_result($sql,14)));
	$mision1 = trim(utf8_encode(odbc_result($sql,15)));
	for ($i=1;$i<=$cantidad;++$i)
	{
		// Se graba el detallado de gastos
		$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_bie");
		$consecu = odbc_result($cur,1);
		$codigo = str_pad($consecu,7,"0",STR_PAD_LEFT);
		$codigo = "A-GR-CA".$codigo;
  	$verifica = time()+$i;
  	$alea = strtoupper(md5($verifica));
  	$alea = substr($alea,0,8);
		$graba = "INSERT INTO cx_pla_bie (conse, fecha, usuario, codigo, clase, nombre, descripcion, fec_com, valor, valor1, marca, color, modelo, serial, soa_num, soa_ase, soa_fe1, soa_fe2, seg_cla, seg_val, seg_num, seg_ase, seg_fe1, seg_fe2, unidad, funcionario, ordop, mision, numero, relacion, compania, estado, egreso, ordop1, mision1, responsable, unidad_a, responsable1, importa, alea) VALUES ('$consecu', '$fecha', '$usuario', '$codigo', '$clase', '$nombre', '', '', '0.00', '0', '', '', '', '', '', '', '', '', '', '0', '', '', '', '', '$unidad', '$funcionario', '$ordop', '$mision', '$numero', '$relacion', '$compania', '$estado', '$egreso', '$ordop1', '$mision1', '0', '0', '0', '', '$alea')";
	  if (!odbc_exec($conexion, $graba))
	  {
	    $confirma = "0";
	  }
	  else
	  {
	    $confirma = "1";
	  }
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_plan_bie_duplica.txt", "a");
		fwrite($file, $fec_log." # ".$graba." # ".$confirma." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->confirma = $confirma;
	echo json_encode($salida);
}
?>