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
  $alea = $_GET["alea"];
  $sigla = trim($_GET["sigla"]);
  $ruta_local1 = $ruta_local."\\upload\\ejecutivo";
  $carpeta1 = $ruta_local1;
  if(!file_exists($carpeta1))
  {
    mkdir ($carpeta1);
  }
  $carpeta2 = $carpeta1."\\".$sigla;
  if(!file_exists($carpeta2))
  {
    mkdir ($carpeta2);
  }
  $carpeta3 = $carpeta2."\\".$alea;
  if(!file_exists($carpeta3))
  {
    mkdir ($carpeta3);
  }
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
<br>
<div id="tabla">
  <table width="95%" align="center" border="1">
    <tr>
      <td colspan="2" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Informe Ejecutivo <?php echo $sigla; ?></font></b></center></td>
    </tr>
    <tr>
      <td width="100%">
        <table width="100%" border="0" align="center">
          <?php
          $dir = opendir ($carpeta3);
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
                $ruta = "./upload/ejecutivo/".$sigla."/".$alea."/".$file;
                echo "<tr>";
                echo "<td width='90%'>";
                echo "<input type='hidden' name='gra_".$i."' id='gra_".$i."' class='form-control' value='".$ruta."' readonly='readonly'>";
                echo "<input type='hidden' name='arc_".$i."' id='arc_".$i."' class='form-control' value='".$file."' readonly='readonly'>";
                echo "<center><a href='#' onclick='cargar($i)'>";
                echo "<font size='2' face='Verdana' color='000066'><b>".$file."</b></font></a></center>";
                echo "</td>";
                echo "<td width='10%'><div id='img_".$i."'><a href='#' onclick='borrar($i)'><img src='dist/img/borrar.png' border='0' title='Eliminar'></a></div></td>";
                echo "</tr>";
              }
            }
            $i++;
          }
          ?>
        </table>
      </td>
    </tr>
  </table>
</div>
<input type="hidden" name="carpeta" id="carpeta" class="form-control" value="<?php echo $carpeta3; ?>" readonly="readonly">
<input type="hidden" name="url" id="url" class="form-control" value="<?php echo $url; ?>" readonly="readonly">
<input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly">
<input type="hidden" name="sigla" id="sigla" class="form-control" value="<?php echo $sigla; ?>" readonly="readonly">
<input type="hidden" name="ruta" id="ruta" class="form-control" value="<?php echo $ruta_local; ?>" readonly="readonly">
<form name="formu" action="ver_info.php" method="post" target="_blank">
    <input type="hidden" name="paso_url" id="paso_url" class="form-control" readonly="readonly">
</form>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function() {
  $("#multipleupload").uploadFile({
    url: "upload6.php?alea=<?php echo $alea; ?>&sigla=<?php echo $sigla; ?>",
    multiple: false,
    dragDrop: true,
    fileName: "myfile",
    dragDropStr: "<span><b>Arrastrar Archivos</b></span>",
    uploadStr: "Cargar Archivos",
    abortStr: "Cancelar",
    sequential: true,
    sequentialCount: 1,
    acceptFiles: ".docx",
    maxFileCount: 1,
    returnType: "json",
    onError: function(files,status,errMsg,pd)
    {
      var detalle = errMsg;
      alerta1(detalle);
    },
    onSuccess:function(files,data,xhr,pd)
    {
      var detalle = "Archivo Correctamente Cargado";
      alerta(detalle);
    }
  });
});
function cargar(valor)
{
  var valor;
  var archivo = $("#arc_"+valor).val();
  var alea = $("#alea").val();
  var sigla = $("#sigla").val();
  var ruta = $("#ruta").val();
  var url = $("#url").val();
  url = url+"cxvisor/Default?valor1="+ruta+"\\upload\\ejecutivo\\"+sigla+"\\"+alea+"\\&valor2="+archivo;
  $("#paso_url").val(url);
  formu.submit();
}
function borrar(valor)
{
  var valor;
  $("#img_"+valor).hide();
  var carpeta = $("#carpeta").val();
  var archivo = $("#arc_"+valor).val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "borrar.php",
    data:
    {
      carpeta: carpeta,
      archivo: archivo
    },
    success: function (data)
    {
      $("#tabla").html('');
    }
  });
}
function alerta1(valor)
{
  alertify.error(valor);
}
function alerta(valor)
{
  alertify.success(valor);
}
</script>
</body>
</html>
<?php
}
?>