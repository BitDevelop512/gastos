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
  $ruta_local1 = $ruta_local."\\upload\\recompensas";
  $carpeta1 = $ruta_local1."\\".$alea;
  if(!file_exists($carpeta1))
  {
    mkdir ($carpeta1);
  }
  $carpeta2 = $carpeta1."\\oficios";
  if(!file_exists($carpeta2))
  {
    mkdir ($carpeta2);
  }
  $carpeta3 = $carpeta1."\\expediente";
  if(!file_exists($carpeta3))
  {
    mkdir ($carpeta3);
  }
  $carpeta4 = $carpeta1."\\regional";
  if(!file_exists($carpeta4))
  {
    mkdir ($carpeta4);
  }
  $carpeta5 = $carpeta1."\\central";
  if(!file_exists($carpeta5))
  {
    mkdir ($carpeta5);
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
      <td colspan="2" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Expediente</font></b></center></td>
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
                $ruta = "./upload/recompensas/".$alea."/expediente/".$file;
                echo "<tr>";
                echo "<td height='35' width='100%'>";
                echo "<center><a href='$ruta'>";
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
    </tr>
  </table>
  <br>
  <table width="95%" align="center" border="1">
    <tr>
      <td colspan="2" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Oficios</font></b></center></td>
    </tr>
    <tr>
      <td width="35%">
        <table width="100%" border="0" align="center">
          <?php
          $dir = opendir ($carpeta2);
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
                $ruta = "./upload/recompensas/".$alea."/oficios/".$file;
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
  <br>
  <table width="95%" align="center" border="1">
    <tr>
      <td colspan="2" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Acta Comit&eacute; Regional</font></b></center></td>
    </tr>
    <tr>
      <td width="100%">
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
                $ruta = "./upload/recompensas/".$alea."/regional/".$file;
                echo "<tr>";
                echo "<td height='35' width='100%'>";
                echo "<center><a href='$ruta'>";
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
    </tr>
  </table>
  <br>
  <table width="95%" align="center" border="1">
    <tr>
      <td colspan="2" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Acta Comit&eacute; Central</font></b></center></td>
    </tr>
    <tr>
      <td width="100%">
        <table width="100%" border="0" align="center">
          <?php
          $dir = opendir ($carpeta5);
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
                $ruta = "./upload/recompensas/".$alea."/central/".$file;
                echo "<tr>";
                echo "<td height='35' width='100%'>";
                echo "<center><a href='$ruta'>";
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
    </tr>
  </table>
</div>
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
    $("#imagen").append(image);
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