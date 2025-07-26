<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
if ($_SESSION["autenticado"] != "SI")
{
  	header("location:resultado.php");
}
else
{
	$conse = $_POST['plan_conse'];
	$ano = $_POST['plan_ano'];
	$unidad = $_POST['plan_unidad'];
	$sigla = $_POST['plan_sigla'];
	// Rutas configuradas
	$pregunta = "SELECT ruta, url, formatos FROM cx_ctr_par";
	$sql = odbc_exec($conexion, $pregunta);
	$ruta_local = trim(odbc_result($sql,1));
	$url = trim(odbc_result($sql,2));
	$formatos = trim(odbc_result($sql,3));
	$formatos = str_replace("/", "-", $formatos);
	// Archivo
	$archivo = "ActaPagInf_".$sigla."_".$conse."_".$ano.".pdf";
	// Se valida fecha de formato
	$query = "SELECT fecha FROM cx_act_inf WHERE conse='$conse' AND ano='$ano' AND unidad='$unidad'";
	$cur = odbc_exec($conexion, $query);
	$fecha = substr(odbc_result($cur,1),0,10);
	if ($fecha >= $formatos)
	{
		$fpdf = "fpdf";
	}
	else
	{
		$fpdf = "fpdf1";
	}
	// Rutas
	$carpeta = $ruta_local."\\fpdf\\pdf\\Actas";
	if(!file_exists($carpeta))
	{
		mkdir ($carpeta);
	}
	$carpeta1 = $url."fpdf/pdf/Actas";
	$ruta = "fpdf/pdf/Actas/".$archivo;
	// Permiso de Descarga
	$valor4 = "1";
	if (file_exists($ruta))
	{
		$pdf = "cxvisor1/Default?valor1=".$carpeta."\\&valor2=".$archivo."&valor3=".$carpeta1."&valor4=".$valor4;
	}
	else
	{
		$pdf = "./".$fpdf."/621.php?conse=".$conse."&ano=".$ano."&unidad=".$unidad."&ajuste=0&hoja=0&tipo=1";
	}
?>
<html lang="es">
	<head>
		<title>:: SIGAR :: Sistema Integrado de Gastos Reservados ::</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta http-equiv="Expires" content="0">
		<link rel="shortcut icon" href="imagenes/cx.ico">
		<link rel="icon" href="imagenes/cx.ico" type="image/ico">
	</head>
	<frameset rows="1,*" cols="*" frameborder="NO" border="0" framespacing="0">
		<frame src="resultado1.php" name="R1">
		<frame src="<?php echo $pdf; ?>" name="R2">
	</frameset>
	<noframes>
	<body>
	</body>
	</noframes>
</html>
<?php
}
// 11/04/2024 - Ajuste y retiro permiso de descarga
?>