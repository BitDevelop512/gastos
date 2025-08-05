<?php
session_start();
error_reporting(0);
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('conf.php');
  include('funciones.php');
  include('permisos.php');

	$conse = $_POST['rec_conse'];
	$ano = $_POST['rec_ano'];
	$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
	$fpdf = "";
	
	$cons_dir= "SELECT TOP 1 directiva FROM cx_reg_rec WHERE conse='$conse' AND ano = '$ano' ";
	$cur_dir = odbc_exec($conexion,$cons_dir);
	$directiva = odbc_result($cur_dir,1);
	if ($directiva == "6") 
	{
		$pdf = "./fpdf/603_1.php?conse=" . urlencode($conse) . "&ano=" . urlencode($ano) . "&tipo=" . urlencode($tipo);
	} else 
	{
		$pdf = "./fpdf/603.php?conse=" . urlencode($conse) . "&ano=" . urlencode($ano);
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