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
	$interno = $_POST['plan_interno'];
	$ano = $_POST['plan_ano'];
	// Rutas configuradas
	$pregunta = "SELECT ruta, url, formatos FROM cx_ctr_par";
	$sql = odbc_exec($conexion, $pregunta);
	$ruta_local = trim(odbc_result($sql,1));
	$url = trim(odbc_result($sql,2));
	$formatos = trim(odbc_result($sql,3));
	$formatos = str_replace("/", "-", $formatos);
	// Ruta de archivos PDF
	$carpeta = $ruta_local."\\fpdf\\pdf\\Planillas";
	if(!file_exists($carpeta))
	{
		mkdir ($carpeta);
	}
	$carpeta1 = $carpeta."\\".$ano;
	if(!file_exists($carpeta1))
	{
		mkdir ($carpeta1);
	}
	$carpeta2 = $url."fpdf/pdf/Planillas/".$ano;
	// Archivo
	$archivo = "PlanGas_".trim($sig_usuario)."_".$conse."_".$ano.".pdf";
	$ruta = "fpdf/pdf/Planillas/".$ano."/".$archivo;
	// Se valida fecha de formato
	$query = "SELECT fecha FROM cx_gas_bas WHERE conse='$conse' AND interno='$interno' AND ano='$ano'";
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
	// Permiso de Descarga
	//if (strpos($per_usuario, "Z|01/") !== false)
	//{
	//	$valor4 = "1";
	//}
	//else
	//{
	//	$valor4 = "0";
	//}
	$valor4 = "1";
	if (file_exists($ruta))
	{
		$pdf = "cxvisor1/Default?valor1=".$carpeta1."\\&valor2=".$archivo."&valor3=".$carpeta2."&valor4=".$valor4;
	}
	else
	{
		$pdf = "./".$fpdf."/639.php?conse=".$conse."&interno=".$interno."&ano=".$ano;
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
// 29/01/2024 - Retiro permiso de descarga pdf
?>