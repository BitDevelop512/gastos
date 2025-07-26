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
	$conse = $_POST['auto_conse'];
	$ano = $_POST['auto_ano'];
	$tipo = $_POST['auto_tipo'];
	$ajuste = $_POST['auto_ajuste'];
	$sigla = $_POST['auto_sigla'];
	// Archivo
	if ($tipo == "1")
	{
 		$archivo = "AutoSolRec_".$sigla."_".$conse."_".$ano.".pdf";
 	}
 	else
 	{
 		$archivo = "AutoRecAut_".$sigla."_".$conse."_".$ano.".pdf";
 	}
	// Rutas
	$carpeta = $ruta_local."\\fpdf\\pdf\\Autorizaciones";
	if(!file_exists($carpeta))
	{
		mkdir ($carpeta);
	}
	$carpeta1 = $url."fpdf/pdf/Autorizaciones";
	$ruta = "fpdf/pdf/Autorizaciones/".$archivo;
	// Permiso descarga
	if (strpos($per_usuario, "Z|01/") !== false)
	{
		$valor4 = "1";
	}
	else
	{
		$valor4 = "0";
	}
	if (file_exists($ruta))
	{
		$pdf = "cxvisor1/Default?valor1=".$carpeta."\\&valor2=".$archivo."&valor3=".$carpeta1."&valor4=".$valor4;
	}
	else
	{
		$pdf = "./fpdf/623.php?conse=".$conse."&ano=".$ano."&tipo=".$tipo."&ajuste=".$ajuste;
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
// 22/02/2024 - Ajuste sigla pdf generado
?>