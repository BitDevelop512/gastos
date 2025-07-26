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
	$conse = $_POST['giro_con'];
	$periodo = $_POST['giro_per'];
  	$ano = $_POST['giro_ano'];
	$archivo = "InfGiro_".$conse."_".$periodo."_".$ano.".pdf";
	$carpeta = $ruta_local."\\fpdf\\pdf\\Informes\\".$ano;
	$carpeta1 = $url."fpdf/pdf/Informes/".$ano;
	$ruta = "fpdf/pdf/Informes/".$ano."/".$archivo;
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
		$pdf = "./fpdf/630.php?informe=".$conse."&periodo=".$periodo."&ano=".$ano;
	}
	//echo $pdf;
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
