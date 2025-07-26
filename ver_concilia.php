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
	$unidad = $_POST['giro_uni'];
	$periodo = $_POST['giro_per'];
  	$ano = $_POST['giro_ano'];
	$cuenta = $_POST['giro_cue'];
	// Ruta de archivos PDF
	$carpeta = $ruta_local."\\fpdf\\pdf\\Conciliaciones";
	if(!file_exists($carpeta))
	{
		mkdir ($carpeta);
	}
	$carpeta1 = $carpeta."\\".$ano;
	if(!file_exists($carpeta1))
	{
		mkdir ($carpeta1);
	}
	$carpeta2 = $url."fpdf/pdf/Conciliaciones/".$ano;
	// Archivo
	$archivo = "Concilia_".$unidad."_".$periodo."_".$ano."_".$cuenta.".pdf";
	$ruta = "fpdf/pdf/Conciliaciones/".$ano."/".$archivo;
	// Permiso de Descarga
	$valor4 = "1";
	if (file_exists($ruta))
	{
		$pdf = "cxvisor1/Default?valor1=".$carpeta1."\\&valor2=".$archivo."&valor3=".$carpeta2."&valor4=".$valor4;
	}
	else
	{
		$pdf = "./fpdf/626.php?periodo=".$periodo."&ano=".$ano."&cuenta=".$cuenta;
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
// 02/04/2024 - Ajuste y retiro permiso de descarga
?>
