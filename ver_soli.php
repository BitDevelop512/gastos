<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if ($_SESSION["autenticado"] != "SI")
{
  	header("location:resultado.php");
}
else
{
	$val = $_GET['val'];
	$valida1 = strpos($val, " ");
	$valida1 = intval($valida1);
	if ($valida1 == "0")
	{
	}
	else
	{
		$num_valores = explode(" ",$val);
		$val = trim($num_valores[0])."+".trim($num_valores[1]);
	}
	$valor = trim(decrypt1($val, $llave));
	$conse = substr($valor,5,5);
	$val1 = $_GET['val1'];
	$ano = trim(decrypt1($val1, $llave));
	$ajuste = "0";
	$pdf = "./fpdf/641.php?conse=".$conse."&ano=".$ano."&ajuste=".$ajuste;
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