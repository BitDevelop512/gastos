<?php
session_start();
header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 1);
if ($_SESSION["autenticado"] != "SI")
{
  	header("location:resultado.php");
}
else
{
	$url = $_POST['paso_url'];
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
		<frame src="<?php echo $url; ?>" name="R2" scrolling="no" noresize>
	</frameset>
	<noframes>
	<body>
	</body>
	</noframes>
</html>
<?php
}
?>