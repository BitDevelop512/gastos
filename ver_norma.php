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
  $archivo = $_GET['valor'];
  $descarga = $_GET['descarga'];
?>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="jquery1/jquery.min.js"></script>
</head>
<body  bgcolor="#ffffff" style="overflow-x:hidden; overflow-y:hidden;">
<input type="hidden" name="ruta" id="ruta" class="form-control" value="<?php echo $ruta_local; ?>" readonly="readonly">
<input type="hidden" name="url" id="url" class="form-control" value="<?php echo $url; ?>" readonly="readonly">
<input type="hidden" name="archivo" id="archivo" class="form-control" value="<?php echo $archivo; ?>" readonly="readonly">
<input type="hidden" name="descarga" id="descarga" class="form-control" value="<?php echo $descarga; ?>" readonly="readonly">
<form name="formu" action="ver_info.php" method="post">
  <input type="hidden" name="paso_url" id="paso_url" class="form-control" readonly="readonly">
</form>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function() {
  var ruta = $("#ruta").val();
  ruta = ruta.trim();
  var archivo = $("#archivo").val();
  var descarga = $("#descarga").val();
	var url = $("#url").val();
  var carpeta = url+"normatividad";
	url = url+"cxvisor1/Default?valor1="+ruta+"\\normatividad\\&valor2="+archivo+"&valor3="+carpeta+"&valor4="+descarga;
	$("#paso_url").val(url);
	formu.submit();
});
</script>
</body>
</html>
<?php
}
// 13/01/2025 - Ajuste descarga de archivo pdf
?>