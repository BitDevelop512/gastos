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
  $valor = $_GET["valor"];
  $valor1 = $_GET["valor1"];
  $valor2 = $_GET["valor2"];
  $pagina = "ver_pqr1.php?alea=".$valor2;
  $pdf = "ver_bonos.php?valor=".$valor."&valor1=".$valor1;
?>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<frameset rows="*" cols="180,*" frameborder="no" border="0" framespacing="0">
  <frame src="<?php echo $pagina; ?>" name="P1" scrolling="yes">
  <frame src="<?php echo $pdf; ?>" name="P2" scrolling="yes">
</frameset>
<noframes>
  <body>
  </body>
</noframes>
</html>
<?php
}
?>