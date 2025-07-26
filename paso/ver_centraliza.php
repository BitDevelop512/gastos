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
	$periodo = $_POST['centra_per'];
	$ano = $_POST['centra_ano'];
	$unidades = $_POST['centra_uni'];
	// Rutas configuradas
	$pregunta = "SELECT ruta, url, formatos FROM cx_ctr_par";
	$sql = odbc_exec($conexion, $pregunta);
 	$ruta_local = trim(odbc_result($sql,1));
	$url = trim(odbc_result($sql,2));
	$formatos = trim(odbc_result($sql,3));
	$formatos = str_replace("/", "-", $formatos);
	// Archivo
	$archivo = "PlanInvCen_".trim($sig_usuario)."_".$periodo."_".$ano.".pdf";
	// Se valida fecha de formato
	$query = "SELECT fecha FROM cx_pla_cen WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
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
	$carpeta = $ruta_local."\\fpdf\\pdf";
	$carpeta1 = $url."fpdf/pdf";
	$ruta = "fpdf/pdf/".$archivo;
	// Permiso de Descarga
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
		$pdf = "./".$fpdf."/637.php?unidades=".$unidades."&periodo=".$periodo."&ano=".$ano;
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
