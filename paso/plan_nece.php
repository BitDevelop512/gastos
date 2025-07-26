<!doctype html>
<?php
session_start();
error_reporting(0);
$_SESSION["chat"] = "NO";
if ($_SESSION["autenticado"] != "SI")
{
  	header("location:resultado.php");
}
else
{
?>
<html lang="es">
	<frameset rows="205,*" cols="*" frameborder="NO" border="0" framespacing="0">
		<frame src="plan_nece1.php" name="R1">
		<frame src="resultado1.php" name="R2">
	</frameset>
	<noframes>
	<body>
	</body>
	</noframes>
</html>
<?php
}
?>