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
  $valor = trim($_GET["valor"]);
  $valor1 = trim($_GET["valor1"]);
  $valor2 = utf8_decode($valor1);
  $periodo1 = $_GET["periodo1"];
  $periodo2 = $_GET["periodo2"];
  $periodo3 = $_GET["periodo3"];
  $periodo4 = $_GET["periodo4"];
  $ano = $_GET["ano"];
  // Se consulta el numero de la unidad
  $pregunta = "SELECT subdependencia FROM cx_org_sub WHERE sigla='$valor'";
  $cur = odbc_exec($conexion, $pregunta);
  $valor3 = odbc_result($cur,1);
  // Se consulta el codigo del gasto
  $pregunta0 = "SELECT codigo FROM cx_ctr_pag WHERE nombre LIKE '%$valor2%'";
  $cur0 = odbc_exec($conexion, $pregunta0);
  $valor4 = trim(odbc_result($cur0,1));
  // Se consulta consecutivos de relaciones
  $pregunta1 = "SELECT usuario FROM cx_rel_gas WHERE unidad='$valor3' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' GROUP BY usuario";
  $cur1 = odbc_exec($conexion, $pregunta1);
  $total1 = odbc_num_rows($cur1);
  $total1 = intval($total1);
  if ($total1 > 0)
  {
    $n = 0;
    $series = "";
    $series1 = "";
    $series2 = "";
    while($n<$row=odbc_fetch_array($cur1))
    {
      $v1 = trim(odbc_result($cur1,1));
      $v1_1 = explode("_", $v1);
      $v1_2 = $v1_1[1];
      $pregunta2 = "SELECT conse, consecu FROM cx_rel_gas WHERE usuario='$v1' AND unidad='$valor3' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' ORDER BY conse";
      $cur2 = odbc_exec($conexion, $pregunta2);
      $total2 = odbc_num_rows($cur2);
      $total2 = intval($total2);
      $p = 0;
      $conses = "";
      $consecus = "";
      while($p<$row=odbc_fetch_array($cur2))
      {
        $v2 = odbc_result($cur2,1);
        $v3 = odbc_result($cur2,2);
        $conses .= $v2.",";
        $consecus .= $v3.",";
        $p++;
      }
      $conses = substr($conses, 0, -1);
      $consecus = substr($consecus, 0, -1);
      $pregunta3 = "SELECT gasto, SUM(valor1) AS valor, (SELECT nombre FROM cx_ctr_pag WHERE cx_ctr_pag.codigo=cx_rel_dis.gasto) AS n_gasto FROM cx_rel_dis WHERE conse1 IN ($conses) AND consecu IN ($consecus) AND gasto='$valor4' GROUP BY gasto";
      $cur3 = odbc_exec($conexion, $pregunta3);
      $total3 = odbc_num_rows($cur3);
      $total3 = intval($total3);
      if ($total3 > 0)
      {
        $r = 0;
        while($r<$row=odbc_fetch_array($cur3))
        {
          $v10 = odbc_result($cur3,2);
          $v11 = number_format($v10, 2);
          $v12 = trim(utf8_encode(odbc_result($cur3,3)));
          $v12 = str_replace(",", "", $v12);
          $r++;
        }
      }
      else
      {
        $pregunta3 = "SELECT codigo AS gasto, 0 AS valor, nombre AS n_gasto FROM cx_ctr_pag WHERE codigo='$valor4'";
        $cur3 = odbc_exec($conexion, $pregunta3);
        $v10 = odbc_result($cur3,2);
        $v11 = number_format($v10, 2);
        $v12 = trim(utf8_encode(odbc_result($cur2,3)));
        $v12 = str_replace(",", "", $v12);
      }
      $series .= "{ name: '".$v1_2."', y: ".$v10.", drilldown: '".$v1_2."' }, ";
      $pregunta4 = "SELECT valor1, (SELECT mision FROM cx_rel_gas WHERE cx_rel_gas.conse=cx_rel_dis.conse1 AND cx_rel_gas.consecu=cx_rel_dis.consecu) AS mision FROM cx_rel_dis WHERE conse1 IN ($conses) AND consecu IN ($consecus) AND gasto='$valor4' AND valor1>0 ORDER BY mision";
      $cur4 = odbc_exec($conexion, $pregunta4);
      $total4 = odbc_num_rows($cur4);
      $total4 = intval($total4);
      if ($total4 > 0)
      {
        $s = 0;
        $series1 = "";
        while($s<$row=odbc_fetch_array($cur4))
        {
          $v13 = odbc_result($cur4,1);
          $v14 = trim(utf8_encode(odbc_result($cur4,2)));
          $s++;
          $series1 .= "['".$v14."', ".$v13."], ";
        }
      }
      else
      {
        $pregunta4 = "SELECT mision FROM cx_rel_gas WHERE conse IN ($conses) AND consecu IN ($consecus)";
        $cur4 = odbc_exec($conexion, $pregunta4);
        $series1 = "";
        $s = 0;
        while($s<$row=odbc_fetch_array($cur4))
        {
          $v13 = "0";
          $v14 = trim(utf8_encode(odbc_result($cur4,1)));
          $s++;
          $series1 .= "['".$v14."', ".$v13."], ";
        }
      }
      $series1 = substr($series1, 0, -2);
      $series2 .= "{ name: '".$v1_2."', id: '".$v1_2."', data: [".$series1."] }, ";
    }
    $series = substr($series, 0, -2);
    $series2 = substr($series2, 0, -2);
  }
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
</head>
<body style="overflow-x: hidden; overflow-y: hidden;">
<link href="jquery/jquery1/jquery-ui.css" rel="stylesheet">
<script src="jquery/jquery1/jquery.js"></script>
<script src="jquery/jquery1/jquery-ui.js"></script>
<br>
<div id="load">
  <center>
    <img src="imagenes/cargando1.gif" alt="Cargando..." />
  </center>
</div>
<input type="hidden" name="gasto" id="gasto" class="form-control" value="<?php echo $valor1; ?>" readonly="readonly">
<input type="hidden" name="periodo1" id="periodo1" class="form-control" value="<?php echo $periodo3; ?>" readonly="readonly">
<input type="hidden" name="periodo2" id="periodo2" class="form-control" value="<?php echo $periodo4; ?>" readonly="readonly">
<input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly">
<input type="hidden" name="series" id="series" class="form-control" value="<?php echo $series; ?>" readonly="readonly">
<input type="hidden" name="series1" id="series1" class="form-control" value="<?php echo $series2; ?>" readonly="readonly">
<div id="res_grafica"></div>
<script src="js4/highcharts.js"></script>
<script src="js4/modules/data.js"></script>
<script src="js4/modules/drilldown.js?1.0.0"></script>
<script src="js4/modules/highcharts-3d.js"></script>
<script src="js4/modules/exporting.js?1.0.0"></script>
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
    graficar();
});
function graficar()
{
var gasto = $("#gasto").val();
gasto = gasto.trim();
var periodo1 = $("#periodo1").val();
periodo1 = periodo1.trim();
var periodo2 = $("#periodo2").val();
periodo2 = periodo2.trim();
var ano = $("#ano").val();
if (periodo1 == periodo2)
{
  var titulo = gasto+" "+periodo1+" de "+ano;
}
else
{
  var titulo = gasto+" entre "+periodo1+' y '+periodo2+" de "+ano;
}
var series = $("#series").val();
var series1 = $("#series1").val();
var salida = "";
salida += "<br><br><div id='grafica1' style='width: 100%; height: 600px; margin: 0 auto'></div>";
var series = '{ name: "'+gasto+'", colorByPoint: true, data: [ '+series+' ] }';
salida += "<div id='grafica1' style='width: 100%; height: 600px; margin: 0 auto'></div>";
$("#res_grafica").append(salida);
var grafica1 = '$("#grafica1").highcharts({ chart: { type: "column" }, title: { text: "'+titulo+'" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, accessibility: { announceNewData: { enabled: true } }, xAxis: { type: "category" }, yAxis: { title: { text: "Totales" } }, legend: { enabled: false }, credits: { enabled: false }, plotOptions: { series: { borderWidth: 0, dataLabels: { enabled: true, format: "$ {point.y}", formatter: function() { return "$ "+ Highcharts.numberFormat(point.y, 0); } } } }, tooltip: { headerFormat: "<span style=\'font-size:11px\'>{series.name}</span><br>", pointFormat: "<span style=\'color:{point.color}\'>{point.name}</span>: $ {point.y}<br/>" }, series: [ '+series+' ], drilldown: { series: [ ' + series1 + ' ] } });';
eval(grafica1);
}
</script>
</body>
</html>
<?php
}
?>