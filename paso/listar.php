<!doctype html>
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
    include('permisos.php');
    require('funciones.php');
    $conse = $_GET["conse"];
    $ano = $_GET["ano"];
    $alea = $_GET["alea"];
    $ruta_local = $ruta_local."\\upload\\recompensas";
    $carpeta = $ruta_local."\\".$alea;
    if(!file_exists($carpeta))
    {
        mkdir ($carpeta);
    }
    $carpeta1 = $carpeta."\\expediente";
    if(!file_exists($carpeta1))
    {
        mkdir ($carpeta1);
    }
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
</head>
<body style="overflow-x:hidden; overflow-y:hidden;">
<link href="jquery/jquery1/jquery-ui.css" rel="stylesheet">
<script src="jquery/jquery1/jquery.js"></script>
<script src="jquery/jquery1/jquery-ui.js"></script>
<br>
<div id="tabla">
    <div id="load">
        <center>
            <img src="dist/img/cargando1.gif" alt="Cargando..." />
        </center>
    </div>
    <table width="95%" align="center" border="1">
        <tr>
            <td colspan="2" height="35" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Expediente</font></b></center></td>
            <input type="hidden" name="conse" id="conse" class="form-control" value="<?php echo $conse; ?>" readonly="readonly">
            <input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly">
            <input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly">
            <input type="hidden" name="carpeta" id="carpeta" class="form-control" value="<?php echo $carpeta1; ?>" readonly="readonly">
        </tr>
        <td width="100%">
            <?php
            $dir = opendir ($carpeta1);
            $i = 1;
            while (false !== ($file = readdir($dir)))
            {
                if (($file=='.') or ($file=='..'))
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
        </td>
    </table>
    <br>
</div>
<style>
.ui-widget
{
    font-size: 13px;
}
.ui-widget-header
{
	color: #000000;
	font-weight: bold;
}
</style>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function() {
    $("#load").hide();
});
</script>
</body>
</html>
<?php
}
?>