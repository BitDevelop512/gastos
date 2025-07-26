<?php
session_start();
error_reporting(0);
require('conf.php');
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  $v1 = $_GET["v1"];
  $v2 = $_GET["v2"];
  $v3 = $_GET["v3"];
?>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<frameset rows="*" cols="500,*" frameborder="no" border="0" framespacing="0">
  <frame src="ver_cargas1.php?v1=<?php echo $v1; ?>&v2=<?php echo $v2; ?>&v3=<?php echo $v3; ?>" name="P1" scrolling="yes">
  <frame src="resultado1.php" name="P2" scrolling="yes">
</frameset>
<noframes>
  <body>
  </body>
</noframes>
</html>
<?php
}
?>