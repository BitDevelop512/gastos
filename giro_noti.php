<?php
session_start();
error_reporting(0);
require('conf.php');
include('funciones.php');
include('permisos.php');
$periodo = $_POST["periodo"];
$ano = $_POST["ano"];
$concepto = $_POST["concepto"];
$unidad = $_POST["unidad"];
$conse = $_POST["conse"];
$informe = $_POST["informe"];
// Se crea notificacion
$valores = "»".$ano."»,»".$periodo."»,»".$concepto."»,»".$unidad."»,»".$informe."»,»".$conse."»";
$valores = iconv("UTF-8", "ISO-8859-1", $valores);
$visualiza = '<button type="button" name="informe" id="informe" class="btn btn-block btn-primary btn-mensaje1" onclick="link4('.$valores.');"><font face="Verdana" size="3">Visualizar Informe de Giro Firmado</font></button>';
$mensaje = "<br>SE HA CARGADO EN LA PLATAFORMA SIGAR EL INFORME DE GIRO FIRMADO POR CONCEPTO DE PRESUPUESTO ".$concepto." PARA EL MES DE ".$periodo." DE ".$ano.".<br><br>".$visualiza."<br>";
$unidad = trim($unidad);
switch ($unidad)
{
	case 'DIV01':
		$unidad1 = "DIV1";
		$usuario = "SGA_".$unidad1;
		break;
	case 'DIV02':
		$unidad1 = "DIV2";
		$usuario = "SGA_".$unidad1;
		break;
	case 'DIV03':
		$unidad1 = "DIV3";
		$usuario = "SGA_".$unidad1;
		break;
	case 'DIV04':
		$unidad1 = "DIV4";
		$usuario = "SGA_".$unidad1;
		break;
	case 'DIV05':
		$unidad1 = "DIV5";
		$usuario = "SGA_".$unidad1;
		break;
	case 'DIV06':
		$unidad1 = "DIV6";
		$usuario = "SGA_".$unidad1;
		break;
	case 'DIV07':
		$unidad1 = "DIV7";
		$usuario = "SGA_".$unidad1;
		break;
	case 'DIV08':
		$unidad1 = "DIV8";
		$usuario = "SGA_".$unidad1;
		break;
	case 'DAVAA':
		$unidad1 = $unidad;
		$usuario = "SGA_".$unidad1;
		break;
   default:
		$unidad1 = $unidad;
		$usuario = "SGR_".$unidad1;
		break;
}
// Se valida si existe el usuario o cambiar SGA por SGR
$con_usua = "SELECT usuario, unidad FROM cx_usu_web WHERE usuario='$usuario'";
$sql_c = odbc_exec($conexion, $con_usua);
$t_usua = odbc_num_rows($sql_c);
if ($t_usua > 0)
{
	$usuario = $usuario;
}
else
{
	$usuario = "SGR_".$unidad;
	$con_usua = "SELECT usuario, unidad FROM cx_usu_web WHERE usuario='$usuario'";
	$sql_c = odbc_exec($conexion, $con_usua);
}
$unidad = odbc_result($sql_c,2);
$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_notifica)";
$graba = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ($query_c, '$usu_usuario', '$uni_usuario', '$usuario', '$unidad', '$mensaje', 'P', '1')";
if (!odbc_exec($conexion, $graba))
{
	$confirma = "0";
}
else
{
	$confirma = "1";
}
$salida = new stdClass();
$salida->salida = $confirma;
echo json_encode($salida);
// 04/02/2025 - Ajuste informes de giro firmados
?>