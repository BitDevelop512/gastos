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
  $conse = $_GET["conse"];
?>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="jquery1/uploadfile.css" rel="stylesheet">
<script src="jquery1/jquery.min.js"></script>
<?php
if ($cargar == "0")
{
?>
  <script src="jquery1/jquery.uploadfile.min.js"></script>
<?php
}
else
{
?>
  <script src="jquery1/jquery.uploadfile.min1.js"></script>
<?php
}
?>
<script type="text/javascript" src="alertas/lib/alertify.js"></script>
<link rel="stylesheet" href="alertas/themes/alertify.core.css"/>
<link rel="stylesheet" href="alertas/themes/alertify.default.css"/>
</head>
<body bgcolor="#ffffff">
<div id="multipleupload">Cargar</div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function() {
  $("#multipleupload").uploadFile({
    url: "upload28.php?conse=<?php echo $conse; ?>",
    multiple: false,
    dragDrop: true,
    fileName: "myfile",
    dragDropStr: "<span><b>Arrastrar Archivos</b></span>",
    uploadStr: "Cargar Archivos",
    abortStr: "Cancelar",
    sequential: true,
    sequentialCount: 1,
    acceptFiles: ".pdf",
    maxFileCount: 1,
    returnType: "json",
    onError: function(files,status,errMsg,pd)
    {
      var detalle = errMsg;
      alerta1(detalle);
    },
    onSelect: function(files)
    {
      var archivo = files[0].name;
      var var_ocu = archivo.split('.');
      var extension = var_ocu[1];
      if ((extension == "pdf") || (extension == "PDF"))
      {
      }
      else
      {
        alerta("Archivo '"+archivo+"' no válido para cargue");
        return false;
      }
    },
    onSuccess:function(files,data,xhr,pd)
    {
      var detalle = "Archivo Correctamente Cargado";
      alerta2(detalle);
    }
  });
});
function alerta(valor)
{
  alertify.error(valor);
}
function alerta1(valor)
{
  alertify.success(valor);
}
function alerta2(valor)
{
  alertify.log(valor);
}
</script>
</body>
</html>
<?php
}
?>