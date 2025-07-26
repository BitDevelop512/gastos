<!doctype html>
<?php
session_start();
error_reporting(0);
include('permisos.php');
?>
<html lang="es">
<head>
  <title>:: SIGAR :: Sistema Integrado de Gastos Reservados ::</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta http-equiv="Expires" content="0">
  <link rel="shortcut icon" href="imagenes/cx.ico">
  <link rel="icon" href="imagenes/cx.ico" type="image/ico">
</head>
<frameset rows="*,30" frameborder="no" border="0" framespacing="0">
	<?php
    if ($_SESSION["autenticado"] != "SI")
    {
    ?>
  		<frame src="login.php" name="principal" scrolling="yes">
  	<?php
  	}
  	else
  	{
  	?>
  		<frame src="principal.php" name="principal" scrolling="no" noresize>
  	<?php
  	}
  	?>
  <frame src="creditos.php" name="creditos" scrolling="no" noresize>
</frameset>
<noframes>
  <body>
  </body>
</noframes>
</html>