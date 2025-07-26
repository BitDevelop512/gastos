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
  $unidad = trim($_GET["unidad"]);
  $periodo = trim($_GET["periodo"]);
  $ano = $_GET["ano"];
  $ruta_local1 = $ruta_local."\\upload\\centralizado";
  $carpeta1 = $ruta_local1;
  if(!file_exists($carpeta1))
  {
    mkdir ($carpeta1);
  }
  $carpeta2 = $carpeta1."\\".$ano;
  if(!file_exists($carpeta2))
  {
    mkdir ($carpeta2);
  }
  $carpeta3 = $carpeta2."\\".$unidad;
  if(!file_exists($carpeta3))
  {
    mkdir ($carpeta3);
  }
  $carpeta4 = $carpeta3."\\".$periodo;
  if(!file_exists($carpeta4))
  {
    mkdir ($carpeta4);
  }
?>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="jquery1/jquery.min.js"></script>
</head>
<body bgcolor="#ffffff">
<div id="tabla">
  <table width="95%" align="center" border="1">
    <tr>
      <td colspan="2" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Plan Centralizado</font></b></center></td>
    </tr>
    <tr>
      <td width="35%">
        <table width="100%" border="0" align="center">
          <?php
          $dir = opendir ($carpeta4);
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
                $ruta = "./upload/centralizado/".$ano."/".$unidad."/".$periodo."/".$file;
                echo "<tr>";
                echo "<td width='100%'>";
                echo "<input type='hidden' name='gra_".$i."' id='gra_".$i."' class='form-control' value='".$ruta."' readonly='readonly'>";
                echo "<input type='hidden' name='arc_".$i."' id='arc_".$i."' class='form-control' value='".$file."' readonly='readonly'>";
                echo "<center><a href='#' onclick='cargar($i)'>";
                echo "<font size='2' face='Verdana' color='000066'><b>".$file."</b></font></a></center>";
                echo "</td>";
                echo "</tr>";
              }
            }
            $i++;
          }
          ?>
        </table>
      </td>
      <td width="65%">
        <center>
          <div id="imagen" class="margen"></div>
        </center>
      </td>
    </tr>
  </table>
</div>
<input type="hidden" name="carpeta" id="carpeta" class="form-control" value="<?php echo $carpeta4; ?>" readonly="readonly">
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function() {
});
function cargar(valor)
{
  var valor;
  var src = $("#gra_"+valor).val();
  var valida = src.indexOf(".pdf") > -1;
  var valida1 = src.indexOf(".PDF") > -1;
  var ancho = screen.width;
  if (ancho > 1000)
  {
    ancho = 700;
  }
  else
  {
    ancho = 450;
  }
  var alto = screen.height;
  if (alto > 1000)
  {
    alto = 620;
  }
  else
  {
    ancho = 450;
  }
  if ((valida == true) || (valida1 == true))
  {
    $("#imagen").html('');
    var image = "<embed src='"+src+"' type='application/pdf' width='"+ancho+"' height='"+alto+"' />";
    window.open(src, "_blank");
  }
  else
  {
    var image = new Image();
    image.src = src;
    //image.onload = function() {
    //    w = this.width;
    //    h = this.height;
    //}
    $("#imagen").html('');
    $("#imagen").append(image);
    $("div#imagen img").css({"width":"300px", "height":"300px"});
  }
}
</script>
</body>
</html>
<?php
}
?>