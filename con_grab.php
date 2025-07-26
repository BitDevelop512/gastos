<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	$cuenta = $_POST['cuenta'];
	$extracto = $_POST['extracto'];
	$debito = $_POST['debito'];
	$credito = $_POST['credito'];
	$cheque = $_POST['cheque'];
	$libros = $_POST['libros'];
	$cheques = $_POST['cheques'];
	$cheques = iconv("UTF-8", "ISO-8859-1", $cheques);
	$debitos = $_POST['debitos'];
	$debitos = iconv("UTF-8", "ISO-8859-1", $debitos);
	$creditos = $_POST['creditos'];
	$creditos = iconv("UTF-8", "ISO-8859-1", $creditos);
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_con_ban");
	$consecu = odbc_result($cur,1);
	// Se graba plan inversion centralizado
	$graba = "INSERT INTO cx_con_ban (conse, usuario, unidad, periodo, ano, saldo, debito, credito, cheques, libros, cheques1, debito1, credito1, cuenta) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$periodo', '$ano', '$extracto', '$debito', '$credito', '$cheque', '$libros', '$cheques', '$debitos', '$creditos', '$cuenta')";
	odbc_exec($conexion, $graba);
	$query1 = "SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_cen WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_concilia.txt", "a");
	fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
	fclose($file);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
?>