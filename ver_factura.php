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
    $alea = $_GET["alea"];
    $sigla = trim($_GET["sigla"]);
    $codigo = trim($_GET["codigo"]);
    $ruta_local1 = $ruta_local."\\upload\\bienes";
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
<script src="jquery1/jquery.min.js"></script>
</head>
<body  bgcolor="#ffffff" style="overflow-x:hidden; overflow-y:hidden;">
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
                $primero = $file;
            }
        }
        $i++;
    }
    ?>
<input type="hidden" name="ruta" id="ruta" class="form-control" value="<?php echo $ruta_local; ?>" readonly="readonly">
<input type="hidden" name="url" id="url" class="form-control" value="<?php echo $url; ?>" readonly="readonly">
<input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly">
<input type="hidden" name="sigla" id="sigla" class="form-control" value="<?php echo $sigla; ?>" readonly="readonly">
<input type="hidden" name="primero" id="primero" class="form-control" value="<?php echo $primero; ?>" readonly="readonly">
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
    var alea = $("#alea").val();
    alea = alea.trim();
    var sigla = $("#sigla").val();
    sigla = sigla.trim();
    var primero = $("#primero").val();
    primero = primero.trim();
    if (primero == "")
    {
    }
    else
    {
        var var_ocu = primero.split('.');
        var nombre = var_ocu[0];
        var extension = var_ocu[1];
        var url = $("#url").val();
        url = url+"cxvisor/Default?valor1="+ruta+"\\upload\\bienes\\"+sigla+"\\"+alea+"\\&valor2="+nombre+"."+extension;
        $("#paso_url").val(url);
        formu.submit();
    }
});
</script>
</body>
</html>
<?php
}
?>