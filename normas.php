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
  include('funciones.php');
  include('permisos.php');
  $tipo = $_GET['tipo'];
  $query = "SELECT * FROM cx_ctr_nor WHERE tipo='$tipo' ORDER BY conse DESC";
  $cur = odbc_exec($conexion, $query);
?>
<html lang="es">
<head>
<?php
include('encabezado.php');
?>
<style>
A:link      { text-decoration: none }
A:visited   { text-decoration: none }
A:active    { text-decoration: none }
A:hover     { text-decoration: none }
</style>
<script type="text/javascript" src="alertas/lib/alertify.js"></script>
<link rel="stylesheet" href="alertas/themes/alertify.core.css"/>
<link rel="stylesheet" href="alertas/themes/alertify.default.css"/>
</head>
<body>
<?php
include('titulo.php');
?>
<div>
  <div id="soportes">
    <h3>Normatividad</h3>
    <div>
      <div id="load">
        <center>
          <img src="imagenes/cargando1.gif" alt="Cargando..." />
        </center>
      </div>
      <?php
      echo "<table width='95%' align='center' border='0'>";
      while($i<$row=odbc_fetch_array($cur))
      {
        $interno = odbc_result($cur,1);
        $nombre = trim(utf8_encode(odbc_result($cur,2)));
        $nombre1 = trim(utf8_encode(odbc_result($cur,3)));
        $descarga = odbc_result($cur,5);
        $nombre2 = '"'.$nombre1.'","'.$descarga.'"';
        list($nombre3, $extension) = explode(".", $nombre1);
        if ($extension == "mp4")
        {
          echo "<tr><td width='5%'><center><img src='imagenes/mp4.png'></center></td><td width='95%'><a href='#' onclick='cargar1(".$nombre2."); return false;'>".$nombre."</a></td></tr>";
        }
        else
        {
          echo "<tr><td width='5%'><center><img src='imagenes/pdf.png'></center></td><td width='95%'><a href='#' onclick='cargar(".$nombre2."); return false;'>".$nombre."</a></td></tr>";
        }
      }
      echo "</table>";
      ?>
      <div id="vinculo"></div>
      <input type="hidden" name="ancho" id="ancho" class="form-control" readonly="readonly">
      <input type="hidden" name="alto" id="alto" class="form-control" readonly="readonly">
    </div>
  </div>
</div>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#soportes").accordion({
    heightStyle: "content"
  });
  var ancho = screen.width;
  var alto = screen.height;
  $("#ancho").val(ancho);
  $("#alto").val(alto);
});
function cargar(valor, valor1)
{
  var valor, valor1;
  if (valor1 == "0")
  {
    alerta("Sin Permiso de Descarga");
  }
  else
  {
    alerta1("Con Permiso de Descarga");
  }
  var ancho = $("#ancho").val();
  if (ancho > 1366)
  {
    var url = "<a href='./ver_norma.php?valor="+valor+"&descarga="+valor1+"' name='lnk1' id='lnk1' class='pantalla-modal'></a>";
    $("#vinculo").html('');
    $("#vinculo").append(url);
    $(".pantalla-modal").magnificPopup({
      type: 'iframe',
      preloader: false,
      modal: false
    });
    $("#lnk1").click();
  }
  else
  {
    var url = "<a href='./ver_norma.php?valor="+valor+"&descarga="+valor1+"' target='_blank'><img src='dist/img/blanco.png' name='lnk1' id='lnk1' width='5' height='5' border='0'></a>";
    $("#vinculo").html('');
    $("#vinculo").append(url);
    $("#lnk1").click();
  }
}
function cargar1(valor)
{
  var valor;
  var url = "<a href='./normatividad/video.php?valor="+valor+"' name='lnk1' id='lnk1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnk1").click();
}
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
// 13/01/2025 - Ajuste descarga de archivo pdf
?>