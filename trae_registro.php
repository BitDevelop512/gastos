<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
	$actual = date('Y');
	$registro = trim($_POST['registro']);
	$num_registro = explode("-",$registro);
	$conse = trim($num_registro[0]);
	$ano = trim($num_registro[1]);
	$query = "SELECT valor, valor1, sintesis, directiva, usuario3, codigo, fec_res, ano1, tipo FROM cx_reg_rec WHERE conse='$conse' AND ano='$ano'";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	$valor = trim(odbc_result($cur,1));
	$valor1 = odbc_result($cur,2);
	$sintesis = trim(utf8_encode(odbc_result($cur,3)));
	$directiva = odbc_result($cur,4);
	$usuario = trim(odbc_result($cur,5));
	$codigo = trim(odbc_result($cur,6));
	$fec_res = odbc_result($cur,7);
	$ano1 = odbc_result($cur,8);
	$tipo = odbc_result($cur,9);
	if ($ano1 == "0")
	{
		$fechas = explode("/", $fec_res);
		$ano1 = $fechas[0];
	}
	$query1 = "SELECT *, (SELECT SUBSTRING(nombre, 0, 115)) AS nombre1 FROM cx_ctr_mat WHERE directiva='$directiva' ORDER BY nombre1";
	$cur1 = odbc_exec($conexion, $query1);
	$material = "";
	$i = 1;
	while ($i < $row = odbc_fetch_array($cur1))
	{
 		$v1 = odbc_result($cur1,1);
 		$v2 = utf8_encode($row['nombre']);
 		$v3 = odbc_result($cur1,3);
 		$v4 = trim(odbc_result($cur1,4));
 		$v4 = str_replace(',','',$v4);
 		$v4 = trim($v4);
 		$v4 = floatval($v4);
 		$v5 = trim(odbc_result($cur1,5));
 		$v5 = str_replace(',','',$v5);
 		$v5 = trim($v5);
 		$v5 = floatval($v5);
 		$v6 = trim(odbc_result($cur1,6));
 		$v6 = str_replace(',','',$v6);
 		$v6 = trim($v6);
 		$v6 = floatval($v6);
 		$material .= $v1."|".$v2."|".$v3."|".$v4."|".$v5."|".$v6."|#";
		$i++;
	}
	$query2 = "SELECT * FROM cx_ctr_niv WHERE directiva='$directiva' ORDER BY tipo, nivel";
	$cur2 = odbc_exec($conexion, $query2);
	$niveles = "";
	$i = 1;
	while ($i < $row = odbc_fetch_array($cur2))
 	{
 		$v1 = odbc_result($cur2,1);
 		$v2 = odbc_result($cur2,2);
 		$v3 = odbc_result($cur2,3);
 		$v4 = odbc_result($cur2,5);
 		$niveles .= $v1."|".$v2."|".$v3."|".$v4."|#";
		$i++;
	}
	$query3 = "SELECT salario FROM cx_ctr_ano WHERE ano='$ano1'";
	$cur3 = odbc_exec($conexion, $query3);
	$salario = odbc_result($cur3,1);
	$salida = new stdClass();
	$salida->total = $total;
	$salida->valor = $valor;
	$salida->valor1 = $valor1;
	$salida->sintesis = $sintesis;
	$salida->directiva = $directiva;
	$salida->usuario = $usuario;
	$salida->codigo = $codigo;
	$salida->tipo = $tipo;
	$salida->material = $material;
	$salida->niveles = $niveles;
	$salida->salario = $salario;
	echo json_encode($salida);
}
?>