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
  $periodo = $_GET["periodo"];
  $ano = $_GET["ano"];
  $concepto = $_GET["concepto"];
  switch ($concepto)
  {
    case '8':
      $concepto1 = "MENSUAL";
      break;
    case '9':
      $concepto1 = "ADICIONAL";
      break;
    case '10':
      $concepto1 = "RECOMPENSAS";
      break;
    default:
      $concepto1 = "";
      break;
  }
  $unidad = $_GET["unidad"];
  $conse = $_GET["conse"];
  $ruta_local1 = $ruta_local."\\upload\\informe";
  if(!file_exists($ruta_local1))
  {
    mkdir ($ruta_local1);
  }
  $carpeta1 = $ruta_local1."\\".$ano;
  if(!file_exists($carpeta1))
  {
    mkdir ($carpeta1);
  }
  $carpeta2 = $carpeta1."\\".$periodo;
  if(!file_exists($carpeta2))
  {
    mkdir ($carpeta2);
  }
  $carpeta3 = $carpeta2."\\".$concepto1;
  if(!file_exists($carpeta3))
  {
    mkdir ($carpeta3);
  }
  $carpeta4 = $carpeta3."\\".$unidad;
  if(!file_exists($carpeta4))
  {
    mkdir ($carpeta4);
  }
  if (($concepto == "9") or ($concepto == "10"))
  {
    $carpeta4 = $carpeta4."\\".$conse;
    if(!file_exists($carpeta4))
    {
      mkdir ($carpeta4);
    }
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
      <td colspan="2" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Informe Giro Presupuesto <?php echo $concepto1." ".$unidad." - ".$periodo." - ".$ano; ?></font></b></center></td>
    </tr>
    <tr>
      <td width="30%">
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
                if (($concepto == "9") or ($concepto == "10"))
                {
                  $ruta = "./upload/informe/".$ano."/".$periodo."/".$concepto1."/".$unidad."/".$conse."/".$file;
                }
                else
                {
                  $ruta = "./upload/informe/".$ano."/".$periodo."/".$concepto1."/".$unidad."/".$file;
                }
                echo "<tr>";
                echo "<td width='90%'>";
                echo "<input type='hidden' name='gra_".$i."' id='gra_".$i."' class='form-control' value='".$ruta."' readonly='readonly'>";
                echo "<input type='hidden' name='arc_".$i."' id='arc_".$i."' class='form-control' value='".$file."' readonly='readonly'>";
                echo "<center><a href='#' onclick='cargar($i)'>";
                echo "<font size='2' face='Verdana' color='000066'><b>".$file."</b></font></a></center>";
                echo "</td>";
                echo "<td width='10%'><div id='img_".$i."'><a href='#' onclick='borrar($i)'><img src='dist/img/borrar.png' border='0' title='Eliminar'></a></div></td>";
                echo "<td width='10%'>&nbsp;</td>";
                echo "</tr>";
              }
            }
            $i++;
          }
          ?>
        </table>
      </td>
      <td width="70%">
        <center>
          <div id="imagen" class="margen"></div>
        </center>
      </td>
    </tr>
  </table>
</div>
<input type="hidden" name="carpeta" id="carpeta" class="form-control" value="<?php echo $carpeta4; ?>" readonly="readonly">
<input type="hidden" name="periodo" id="periodo" class="form-control" value="<?php echo $periodo; ?>" readonly="readonly">
<input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly">
<input type="hidden" name="concepto" id="concepto" class="form-control" value="<?php echo $concepto1; ?>" readonly="readonly">
<input type="hidden" name="unidad" id="unidad" class="form-control" value="<?php echo $unidad; ?>" readonly="readonly">
<input type="hidden" name="conse" id="conse" class="form-control" value="<?php echo $conse; ?>" readonly="readonly">
<input type="hidden" name="informe" id="informe" class="form-control" value="" readonly="readonly">
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function() {
  $("#multipleupload").uploadFile({
    url: "upload26.php?periodo=<?php echo $periodo; ?>&ano=<?php echo $ano; ?>&concepto=<?php echo $concepto1; ?>&concepto1=<?php echo $concepto; ?>&unidad=<?php echo $unidad; ?>&conse=<?php echo $conse; ?>",
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
      $("#informe").val(archivo);
      var var_ocu = archivo.split('.');
      var extension = var_ocu[1];
      if ((extension == "pdf") || (extension == "PDF"))
      {
      }
      else
      {
        alerta1("Archivo '"+archivo+"' no válido para cargue");
        return false;
      }
    },
    onSuccess:function(files,data,xhr,pd)
    {
      var detalle = "Archivo Correctamente Cargado";
      alerta(detalle);
      envio();
    }
  });
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
function envio()
{
  var periodo = $("#periodo").val();
  var ano = $("#ano").val();
  var concepto = $("#concepto").val();
  var unidad = $("#unidad").val();
  var conse = $("#conse").val();
  var informe = $("#informe").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "giro_noti.php",
    data:
    {
      periodo: periodo,
      ano: ano,
      concepto: concepto,
      unidad: unidad,
      informe: informe
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        alerta("Notificación Enviada Correctamente");
      }
      else
      {
        alerta1("Error en el Envío de la Notificación");
      }
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
// 06/08/2024 - Ajuste envio notificacion cargue informe
// 03/02/2025 - Ajuste cargue varios por presupuesto
// 04/02/2025 - Ajuste informes de giro firmados
?>