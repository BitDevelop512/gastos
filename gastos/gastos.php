<!doctype html>
<?php
session_start();
error_reporting(0);
require('../conf.php');
require('funciones.php');
$v1 = $_GET['v1'];
$v2 = $_GET['v2'];
$v3 = $_GET['v3'];
$valida2 = strpos($v2, " ");
$valida2 = intval($valida2);
if ($valida2 == "0")
{
}
else
{
    $num_valores2 = explode(" ",$v2);
    $v2 = trim($num_valores2[0])."+".trim($num_valores2[1]);
}
$valida3 = strpos($v3, " ");
$valida3 = intval($valida3);
if ($valida3 == "0")
{
}
else
{
    $num_valores3 = explode(" ",$v3);
    $v3 = trim($num_valores3[0])."+".trim($num_valores3[1]);
}
$conse = decrypt1($v1, $llave);
$usuario = decrypt1($v2, $llave);
$nombre = decrypt1($v3, $llave);
$cur = odbc_exec($conexion, "SELECT * FROM cx_usu_web WHERE conse='$conse'");
$total = odbc_num_rows($cur);
?>
<html lang="es">
<head>
<title>:: SIGAR :: Sistema Integrado de Gastos Reservados ::</title>
<meta charset="utf-8">
<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
<link rel="shortcut icon" href="img/cx.ico">
<link rel="icon" href="img/cx.ico" type="image/ico">
<link rel="stylesheet" href="themes/cxmovil.css" />
<link rel="stylesheet" href="themes/cxmovil.min.css" />
<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
<link rel="stylesheet" href="themes/jquery.mobile.structure-1.4.5.min.css" />
<script src="themes/jquery-1.11.1.min.js"></script>
<script src="themes/jquery.mobile-1.4.5.min.js"></script>
<style>
body
{
    margin-top: 0px;
    margin-bottom: 0px; 
    margin-left: 10px; 
    margin-right: 10px;
}
.div
{
    margin-top: 0px;
    margin-bottom: 0px; 
    margin-left: 20px;
    margin-right: 20px;
}
#titulo
{
	background: #1789EA;
	height: 50px;
	width: 100%;
	left: 0px;
	top: 0px;
	position: fixed;
    z-index: 999;
}
.imagen1
{
	margin-top: 10px;
    margin-left: 20px;
    margin-bottom: 5px;
	position: fixed;
    z-index: 999;
}
.imagen2
{
	margin-top: 5px;
    margin-left: 60px;
    margin-bottom: 5px;
	position: fixed;
    z-index: 999;
}
.imagen3
{
	margin-top: 5px;
    margin-left: 100px;
    margin-bottom: 5px;
	position: fixed;
    z-index: 999;
}
.imagen4
{
	margin-top: 5px;
    margin-bottom: 5px;
    margin-left: 10px;
	position: fixed;
    z-index: 999;
}
.espacio
{
  padding-top: 5px;
  padding-bottom: 5px;
}
nav
{
	float: right;
}
nav ul
{
    margin: 0;
    padding: 0;
    padding-right: 70px;
}
#main-content
{
	margin: 10px;
} 
#main-content header
{
    padding-top: 50px;
    padding-left: 10px;
    padding-right: 10px;
}
</style>
<script type="text/javascript" src="alertas/lib/alertify.js"></script>
<link rel="stylesheet" href="alertas/themes/alertify.core.css"/>
<link rel="stylesheet" href="alertas/themes/alertify.default.css"/>
</head>
<body>
<div id="titulo">	
    <img src="img/cx1.png" class="imagen1" width="35">
</div>
<br><br><br>
<div id="load">
    <center>
        <img src="img/cargando.gif" alt="Cargando..." />
    </center>
</div>
<div id="campos" class="div">
    <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>" readonly="readonly">
    <input type="hidden" name="interno" id="interno" value="<?php echo $conse; ?>" readonly="readonly">
    <input type="hidden" name="total" id="total" value="<?php echo $total; ?>" readonly="readonly">
    <input type="hidden" name="url" id="url" value="<?php echo $url; ?>" readonly="readonly">
    <input type="hidden" name="ancho" id="ancho" readonly="readonly">
    <input type="hidden" name="alto" id="alto" readonly="readonly">
    <input type="hidden" name="firma" id="firma" readonly="readonly">
    <input type="hidden" name="firma1" id="firma1" readonly="readonly">
    <input type="hidden" name="firma2" id="firma2" readonly="readonly">
    <div class="espacio"></div>
    <center>
        <label>Firma Usuario</label>
        <label><?php echo $nombre; ?></label>
    </center>
    <center>
        <div class="espacio"></div>
        <div id="signature"></div>
        <div id="espacio"></div>
        <label for="acepta"><font size="2">Acepta el uso de su firma digital</font></label>
        <input type="checkbox" name="acepta" id="acepta" value="1" data-theme="f">
        <div id="espacio"></div>
        <table width="100%" align="center" border="0">
            <tr>
                <td width="45%">
                    <button type="button" onclick="$('#signature').jSignature('clear'); $('#signature').jSignature('enable'); limpia_firma();" id="limpiar">
                        <img src="img/limpiar.png" height="30" width="30" align="absmiddle">&nbsp;&nbsp;&nbsp;Limpiar
                    </button>
                </td>
                <td width="10%">&nbsp;</td>
                <td width="45%">
                    <button type="button" onclick="valida();" id="grabar">
                        <img src="img/check.png" height="30" width="30" align="absmiddle">&nbsp;&nbsp;&nbsp;Finalizar
                    </button>
                </td>
            </tr>
        </table>
    </center>
</div>
<div id="espacio"></div>
<div id="campos1">
    <br>
    <center>
        <label>Firma Usuario</label>
        <label><?php echo $nombre; ?></label>
    </center>
    <br>
    <table border="0" align="center">
        <tr>
            <td bgcolor="#ffffff">
                <div id="f1"></div>
                <div id="f2"></div>
            </td>
        </tr>
        <tr>
			<td>
				<br>
				<button type="button" onclick="borra();" id="borrar">
					<img src="img/firma.png" height="30" width="30" align="absmiddle">&nbsp;&nbsp;&nbsp;Reemplazar Firma
				</button>
			</td>
        </tr>
    </table>
</div>
<script>
$(document).ready(function () {
    $("#load").hide();
    $("#campos1").hide();
    var ancho = $(window).width();
    var alto = $(window).height();
    ancho = parseInt(ancho);
    ancho = ancho-95;
    $("#ancho").val(ancho);
    $("#alto").val(alto);
    $("#signature").jSignature({color:"#000", lineWidth:3, width: 270, height: 270, "background-color":"#ccc"});
    sigue();
    limpia_firma();
    consulta();
});
function url()
{
    var url = location.search.replace("?", "");
    var arrUrl = url.split("&");
    var urlObj = {};   
    for(var i=0; i<arrUrl.length; i++)
    {
        var x = arrUrl[i].split("=");
        urlObj[x[0]]=x[1]
    }
    return urlObj;
}
function sigue()
{
    $("#f1").html('');
    $("#f2").html('');
    $('#signature').jSignature('clear');
    $('#signature').jSignature('enable');
}
function limpia_firma()
{
    $("#firma").val('');
    $("#firma1").val('');
}
function consulta()
{
    $("#f1").html('');
    $("#f2").html('');
    var usuario = $("#usuario").val();
    var interno = $("#interno").val();
    $.get("app_trae.php",
    {
    	"usuario":usuario,
    	"interno":interno
    },
    function(datos)
    {
        var registros = jQuery.parseJSON(datos);
        total = registros.total;
        firma = registros.firma;
        firma = firma.trim();
        if (firma == "")
        {
            $("#f2").append("<center>Firma no encontrada.</center>");
        }
        else
        {
            firma = firma.substring(14);
            $("#campos").hide();
            $("#campos1").show();
            $("#f1").append(firma);
            $("#f2").append("<br><center>Firma ya registrada</center>");
        }
    });
}
function valida()
{
	var blanco = $('#signature').jSignature("getData", "native").length;
	blanco = parseInt(blanco);
	if (blanco == "0")
	{
        var detalle = "Firma No Detectada."
        alerta(detalle);
	}
	else
	{
		svg1();
		base64();
		graba();
	}
}
function svg1()
{
    var data = $('#signature').jSignature("getData", "svg");
    $('#firma').val(data.join(','));
}
function base64()
{
    var data = $('#signature').jSignature("getData");
    $('#firma1').val(data);
}
function graba()
{
    var salida = true;
    var detalle = '';
    if ($("#acepta").is(':checked'))
    {
    }
    else
    {
        salida = false;
        detalle += "Debe aceptar el uso de su firma digital.";
    }
    if (salida == false)
    {
    	alerta(detalle);
    }
    if (salida == true)
    { 
        graba1();
    }
}
function graba1()
{
    $("#load").show();
    var usuario = $("#usuario").val();
    var interno = $("#interno").val();
    var firma = $("#firma").val();
    var firma1 = $("#firma1").val();
    firma = firma.trim();
    firma1 = firma1.trim();
    $.post("app_graba.php",
    {
        usuario: usuario,
        interno: interno,
        firma: firma,
        firma1: firma1
    },
    function(data, status)
    {
        $("#load").hide();
        if (status == "success")
        {
            $("#grabar").hide();
            $("#limpiar").hide();
            var detalle = "Firma registrada correctamente."
            alerta1(detalle);
            $("#acepta").prop("disabled",true);
            $('#signature').jSignature("disable");
        }
    });
}
function borra()
{
    var usuario = $("#usuario").val();
    usuario = usuario.trim();
    var interno = $("#interno").val();
    $.get("app_borra.php",
    {
    	"usuario":usuario,
    	"interno":interno
    },
    function(datos)
    {
        var registros = jQuery.parseJSON(datos);
        location.reload();
    });
}
function alerta(valor)
{
  alertify.error(valor);
}
function alerta1(valor)
{
  alertify.success(valor);
}
</script>
<script type="text/javascript" src="js1/jSignature.js.php"></script>
<script type="text/javascript" src="js1/jSignature.CompressorBase30.js.php"></script>
<script type="text/javascript" src="js1/jSignature.CompressorSVG.js.php"></script>
</body>
</html>