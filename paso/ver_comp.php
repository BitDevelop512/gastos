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
	$tipo = $_POST['comp_tipo'];
	$conse = $_POST['comp_conse'];
	$ano = $_POST['comp_ano'];
	$unidad = $_POST['comp_uni'];
 	// Archivo
 	if ($tipo == "1")
 	{
		$archivo = "CompIng_".trim($sig_usuario)."_".$conse."_".$ano.".pdf";
	}
	else
 	{
 		$archivo = "CompEgr_".trim($sig_usuario)."_".$conse."_".$ano.".pdf";
	}
	// Ruta de archivos PDF
	$carpeta = $ruta_local."\\fpdf\\pdf\\Comprobantes";
	if(!file_exists($carpeta))
	{
		mkdir ($carpeta);
	}
	$carpeta1 = $carpeta."\\".$ano;
	if(!file_exists($carpeta1))
	{
		mkdir ($carpeta1);
	}
	$carpeta2 = $url."fpdf/pdf/Comprobantes/".$ano;
	$ruta = "fpdf/pdf/Comprobantes/".$ano."/".$archivo;
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
		$pdf = "cxvisor1/Default?valor1=".$carpeta1."\\&valor2=".$archivo."&valor3=".$carpeta2."&valor4=".$valor4;
	}
	else
	{
		if ($tipo == "1")
		{
			$pdf = "./fpdf/625.php?ingreso=".$conse."&ano=".$ano."&unidad=".$unidad;
		}
		else
		{
			$pdf = "./fpdf/624.php?egreso=".$conse."&ano=".$ano."&unidad=".$unidad;
		}
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
?>
