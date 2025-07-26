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
	$acta = $_POST['acta_acta'];
	$conse = $_POST['acta_conse'];
	$ano = $_POST['acta_ano'];
	$ajuste = $_POST['acta_ajuste'];
	$hoja = $_POST['acta_hoja'];
	// Rutas configuradas
	$pregunta = "SELECT ruta, url, formatos FROM cx_ctr_par";
	$sql = odbc_exec($conexion, $pregunta);
	$ruta_local = trim(odbc_result($sql,1));
	$url = trim(odbc_result($sql,2));
	$formatos = trim(odbc_result($sql,3));
	$formatos = str_replace("/", "-", $formatos);
	// Archivo
	$archivo = "ActaInfVer_".trim($sig_usuario)."_".$acta."_".$ano.".pdf";
	// Rutas
	$carpeta = $ruta_local."\\fpdf\\pdf\\Actas";
	if(!file_exists($carpeta))
	{
		mkdir ($carpeta);
	}
	$carpeta1 = $url."fpdf/pdf/Actas";
	$ruta = "fpdf/pdf/Actas/".$archivo;
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
		$pdf = "./fpdf/1835.php?acta=".$acta."&conse=".$conse."&ano=".$ano."&ajuste=".$ajuste."&hoja=".$hoja;
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