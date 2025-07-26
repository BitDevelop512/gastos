<?php
session_start();
error_reporting(0);
require('conf.php');
include('permisos.php');
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  $alea = $_GET["alea"];
  $carpeta = $ruta_local."\\upload\\pqr\\".$alea;
?>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="jquery1/uploadfile.css" rel="stylesheet">
  <script src="jquery1/jquery.min.js"></script>
  <style>
  A:link      { text-decoration: none }
  A:visited   { text-decoration: none }
  A:active    { text-decoration: none }
  A:hover     { text-decoration: none }
  </style>
</head>
<body bgcolor="#ffffff">
<?php
$dir = opendir ($carpeta);
$i = 1;
while (false !== ($file = readdir($dir)))
{
  if (($file == '.') or ($file == '..'))
  {
  }
  else
  {
    $archivo = '"'.$file.'"';
    $codigo = '"'.$alea.'"';
    echo "<a href='#' onclick='cargar(".$archivo.")'><font size='2' face='Verdana' color='000066'><b>".$file."</b></font></a><br><br>";
    if ($sup_usuario == "1")
    {
      echo "<center><a href='#' onclick='descargar(".$archivo.",".$codigo.");'><img src='dist/img/download.png' width='32' height='32' border='0' title='Descargar'></a>";
    }
    echo "<hr>";
  }
  $i++;
}
?>
<input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly">
<input type="hidden" name="ruta" id="ruta" class="form-control" value="<?php echo $ruta_local; ?>" readonly="readonly">
<div id="vinculo"></div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function() {
});
function cargar(valor)
{
  var valor;
  var ruta = $("#ruta").val();
  ruta = ruta.trim();
  var alea = $("#alea").val();
  var url = "cxvisor1/Default?valor1="+ruta+"\\upload\\pqr\\"+alea+"\\&valor2="+valor+"&valor3=0&valor4=0";
  parent.P2.location.href = url;
}
function descargar(valor, valor1)
{
  var valor, valor1;
  var carpeta = "upload/pqr/"+valor1+"/"+valor;
  var url = "<a href='"+carpeta+"' download='"+valor+"'><img src='dist/img/blanco1.png' name='link1' id='link1'></a>";
  $("#vinculo").hide();
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $("#link1").click();
}
</script>
</body>
</html>
<?php
}
?>