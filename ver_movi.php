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
	$conse = $_POST['movi_conse'];
	$tipo = $_POST['movi_tipo'];
	$tipo1 = $_POST['movi_tipo1'];
	$ano = $_POST['movi_ano'];
	$unidad = trim($_POST['movi_unidad']);
	$alea = $_POST['movi_alea'];
	switch ($tipo)
	{
    case '1':
			$movi = "asignacion";
			break;
		case '2':
			$movi = "salida";
			break;
		case '3':
			$movi = "consumo";
			break;
		case '4':
			$movi = "traspaso";
			break;
		case '5':
			$movi = "usuario";
			break;
		case '6':
			$movi = "revista";
			break;
		default:
			$movi = "";
			break;
	}
	$carpeta = $ruta_local."\\upload\\movimientos\\".$movi."\\".$alea;
	$dir = opendir ($carpeta);
	$i = 1;
	while (false !== ($file = readdir($dir)))
	{
		if (($file == '.') or ($file == '..'))
		{
		}
		else
		{
			$num_archivo = explode(".", $file);
			$extension = count($num_archivo);
			$extension = intval($extension);
			if ($extension == "1")
			{
			}
			else
			{
				$archivo = $file;
			}
		}
		$i++;
	}
	$url = $url."cxvisor/Default?valor1=".$carpeta."\\&valor2=".$archivo;
?>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="jquery1/jquery.min.js"></script>
</head>
<body  bgcolor="#ffffff" style="overflow-x:hidden; overflow-y:hidden;">
<input type="hidden" name="url" id="url" class="form-control" value="<?php echo $url; ?>" readonly="readonly">
<form name="formu" action="ver_info.php" method="post">
	<input type="hidden" name="paso_url" id="paso_url" class="form-control" readonly="readonly">
</form>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function() {
	var url = $("#url").val();
	$("#paso_url").val(url);
	formu.submit();
});
</script>
</body>
</html>
<?php
}
?>