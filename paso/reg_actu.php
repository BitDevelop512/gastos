<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$fecha = $_POST['fecha'];
	$oficio = $_POST['oficio'];
	$registro = $_POST['registro'];
	$fecha1 = $_POST['fecha1'];
	$unidad = $_POST['unidad'];
	$unidad1 = $_POST['unidad1'];
	$brigada = $_POST['brigada'];
	$division = $_POST['division'];
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$fecha2 = $_POST['fecha2'];
	$ordop1 = $_POST['ordop1'];
	$ordop1 = encrypt1($ordop1, $llave);
	$ordop = $_POST['ordop'];
	$ordop = encrypt1($ordop, $llave);
	$orden = $_POST['orden'];
	$orden = encrypt1($orden, $llave);
	$departamento = $_POST['departamento'];
	$municipio = $_POST['municipio'];
	$sitio = $_POST['sitio'];
	$sitio = encrypt1($sitio, $llave);
	$factor = $_POST['factor'];
	$estructura = $_POST['estructura'];
	$tipos = $_POST['tipos'];
	list($tipo1, $tipo2, $tipo3, $tipo4) = explode("|", $tipos);
	$resultado = $_POST['resultado'];
	$resultado = encrypt1($resultado, $llave);
	$cedulas = $_POST['cedulas'];
	$cedulas = encrypt1($cedulas, $llave);
	$nombres = $_POST['nombres'];
	$nombres = encrypt1($nombres, $llave);
	$porcentajes = $_POST['porcentajes'];
	$porcentajes1 = $_POST['porcentajes1'];
	$directiva = $_POST['directiva'];
	$lista = $_POST['lista'];
	$fecha7 = $_POST['fecha7'];
	$fecha8 = $_POST['fecha8'];
	$previo = $_POST['previo'];
	$pago = $_POST['pago'];
	$fecha9 = $_POST['fecha9'];
	$valor_p = $_POST['valor_p'];
	$valor_p1 = $_POST['valor_p1'];
	$fecha10 = $_POST['fecha10'];
	$query = "UPDATE cx_reg_rec SET usuario='$usu_usuario', fec_ofi='$fecha', num_ofi='$oficio', num_reg='$registro', fec_reg='$fecha1', uni_tac='$unidad', batallon='$unidad1', brigada='$brigada', division='$division', val_sol='$valor', val_sol1='$valor1', fec_res='$fecha2', n_ordop='$ordop1', ordop='$ordop', orden='$orden', departamento='$departamento', municipio='$municipio', sitio='$sitio', factor='$factor', estructura='$estructura', tipo1='$tipo1', tipo2='$tipo2', tipo3='$tipo3', tipo4='$tipo4', concepto='$resultado', ced_fuen='$cedulas', nom_fuen='$nombres', por_fuen='$porcentajes', pot_fuen='$porcentajes1', directiva='$directiva', lista='$lista', fec_ord='$fecha7', fec_fra='$fecha8', pag_prev='$previo', act_prev='$pago', fec_prev='$fecha9', val_prev='$valor_p', val_prev1='$valor_p1', fec_inf='$fecha10' WHERE conse='$conse'";
	$sql = odbc_exec($conexion, $query);
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_reg_rec");
	$consecu = odbc_result($cur1,1);

	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_regi.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);

	$salida = new stdClass();
	$salida->salida = $consecu;
	echo json_encode($salida);
}
?>