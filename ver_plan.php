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
	$tipo = $_POST['plan_tipo'];
	$ajuste = $_POST['plan_ajust'];
	// Rutas configuradas
 	$pregunta = "SELECT ruta, url, formatos FROM cx_ctr_par";
 	$sql = odbc_exec($conexion, $pregunta);
 	$ruta_local = trim(odbc_result($sql,1));
 	$url = trim(odbc_result($sql,2));
	$formatos = trim(odbc_result($sql,3));
 	$formatos = str_replace("/", "-", $formatos);
	// Ruta de anexos
 	$ruta_local0 = $ruta_local."\\archivos\\server\\php\\anexos\\".trim($ano)."\\";
 	if(!file_exists($ruta_local0))
 	{
		mkdir ($ruta_local0);
	}
	// Ruta de archivos PDF
 	$ruta_local1 = $ruta_local."\\fpdf\\pdf";
 	$repositorio = $ruta_local1."\\".$ano;
 	if(!file_exists($repositorio))
 	{
		mkdir ($repositorio);
	}
	$interno = str_pad($conse,5,"0",STR_PAD_LEFT);
	// Archivo
 	$archivo = $interno."_".$ano.".pdf";
	// Se valida fecha de formato
	$query = "SELECT fecha FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano' AND tipo='$tipo'";
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
	$carpeta = $ruta_local."\\fpdf\\pdf\\".$ano;
	$carpeta1 = $url."fpdf/pdf/".$ano;
	$ruta = "fpdf/pdf/".$ano."/".$archivo;
	// Solicitud de Recurso
	if ($tipo == "2")
	{
		$valor4 = "1";
	}
	else
	{
		if (strpos($per_usuario, "Z|01/") !== false)
		{
			$valor4 = "1";
		}
		else
		{
			$valor4 = "0";
		}
	}
	$valor4 = "1";
	if (file_exists($ruta))
	{
		$pdf = "cxvisor1/Default?valor1=".$carpeta."\\&valor2=".$archivo."&valor3=".$carpeta1."&valor4=".$valor4;
	}
	else
	{
		if ($tipo == "1")
		{
			$pdf = "./".$fpdf."/638.php?conse=".$conse."&ano=".$ano."&ajuste=".$ajuste;
		}
		else
		{
			$pdf = "./".$fpdf."/641.php?conse=".$conse."&ano=".$ano."&ajuste=".$ajuste;
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
// 02/04/2024 - Ajuste creacion automatica carpeta ano
// 25/06/2024 - Retiro permiso de descarga pdf
?>
