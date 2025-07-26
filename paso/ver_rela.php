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
	$tipo = $_POST['plan_tipo'];
	$ano = $_POST['plan_ano'];
	$periodo = $_POST['plan_periodo'];
	// Rutas configuradas
	$pregunta = "SELECT ruta, url, formatos FROM cx_ctr_par";
	$sql = odbc_exec($conexion, $pregunta);
	$ruta_local = trim(odbc_result($sql,1));
	$url = trim(odbc_result($sql,2));
	$formatos = trim(odbc_result($sql,3));
	$formatos = str_replace("/", "-", $formatos);
	// Ruta de archivos PDF
	$carpeta = $ruta_local."\\fpdf\\pdf\\Relaciones";
	if(!file_exists($carpeta))
	{
		mkdir ($carpeta);
	}
	$carpeta1 = $carpeta."\\".$ano;
	if(!file_exists($carpeta1))
	{
		mkdir ($carpeta1);
	}
	$carpeta2 = $url."fpdf/pdf/Relaciones/".$ano;
 	// Archivo
 	if ($tipo == "1")
 	{
 		$archivo = "RelGas_".trim($sig_usuario)."_".$conse."_".$ano.".pdf";
 	}
 	else
 	{
 		$archivo = "InfGas_".trim($sig_usuario)."_".$conse."_".$ano.".pdf";
 	}
	$ruta = "fpdf/pdf/Relaciones/".$ano."/".$archivo;
	// Se valida fecha de formato
	$query = "SELECT fecha FROM cx_rel_gas WHERE conse='$conse' AND ano='$ano' AND tipo='$tipo'";
	$cur = odbc_exec($conexion, $query);
	$fecha = substr(odbc_result($cur,1),0,10);
	if ($fecha >= $formatos)
	{
		$fpdf = "fpdf";
		$pdf = "./".$fpdf."/640_1.php?conse=".$conse."&ano=".$ano."&tipo=".$tipo."&periodo=".$periodo;
	}
	else
	{
		$fpdf = "fpdf1";
		if ($tipo == "1")
		{
			$pdf = "./".$fpdf."/640.php?conse=".$conse."&ano=".$ano."&tipo=".$tipo."&periodo=".$periodo;
		}
		else
		{
			$pdf = "./".$fpdf."/629.php?conse=".$conse."&ano=".$ano."&tipo=".$tipo."&periodo=".$periodo;
		}
	}
	// Permiso de Descarga
	$valor4 = "1";
	if (file_exists($ruta))
	{
		$pdf = "cxvisor1/Default?valor1=".$carpeta1."\\&valor2=".$archivo."&valor3=".$carpeta2."&valor4=".$valor4;
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
