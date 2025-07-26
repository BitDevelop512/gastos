<!doctype html>
<?php
session_start();
error_reporting(0);
require('permisos.php');
if ($_SESSION["autenticado"] != "SI")
{
}
else
{
  if ($sup_usuario == "1")
  {
?>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>:: Administrador SIGAR :: Sistema Integrado de Gastos Reservados ::</title>
  <meta http-equiv="content-type" content="text/html">
  <meta http-equiv="Expires" content="0">
  <link rel="shortcut icon" href="dist/img/cx.ico">
  <link rel="icon" href="dist/img/cx.ico" type="image/ico">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>
<frameset rows="*,20" frameborder="no" border="0" framespacing="0">
  <frame src="principal2.php" name="principal" scrolling="yes" noresize>
  <frame src="creditos1.php" name="creditos" scrolling="no" noresize>
</frameset>
<noframes>
  <body>
  </body>
</noframes>
</html>
<?php
  }
}
?>