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
	$conse = $_POST['auto_conse1'];
	$ano = $_POST['auto_ano1'];
	$tipo = $_POST['auto_tipo1'];
	$ajuste = $_POST['auto_ajuste1'];
	$sigla = $_POST['auto_sigla1'];
	// Rutas configuradas
	$pregunta = "SELECT ruta, url, formatos FROM cx_ctr_par";
	$sql = odbc_exec($conexion, $pregunta);
	$ruta_local = trim(odbc_result($sql,1));
	$url = trim(odbc_result($sql,2));
	$formatos = trim(odbc_result($sql,3));
	$formatos = "2024-01-23";
	// Ruta de archivos PDF
	$carpeta = $ruta_local."\\fpdf\\pdf\\Actas";
	if(!file_exists($carpeta))
	{
		mkdir ($carpeta);
	}
	// Archivo
 	$archivo = "ActaEvaCom_".$sigla."_".$conse."_".$ano.".pdf";
 	$carpeta1 = $url."fpdf/pdf/Actas";
 	$ruta = "fpdf/pdf/Actas/".$archivo;
	// Se valida fecha de formato
	$query = "SELECT fecha FROM cx_sol_aut WHERE conse='$conse' AND ano='$ano'";
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
		$fecha1 = "2025-02-27";
    if ($fecha >= $fecha1)
    {
    	$pdf = "./".$fpdf."/sg_isa_1834.php?conse=".$conse."&ano=".$ano."&tipo=".$tipo."&ajuste=".$ajuste;
    }
    else
    {
			$pdf = "./".$fpdf."/600.php?conse=".$conse."&ano=".$ano."&tipo=".$tipo."&ajuste=".$ajuste;
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
// 22/02/2024 - Ajuste sigla pdf generado
// 25/02/2025 - Ajuste cmabio de formato
?>