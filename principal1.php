<!doctype html>
<?php
session_start();
error_reporting(0);
require('conf.php');
include('permisos.php');
$fecha = date('Y/m/d');
$dia = date('d');
$ano = date('Y');
$mes = date('m');
if ($mes == "12")
{
	$mes = 1;
    $ano = $ano+1;
}
else
{
	$mes = $mes+1;
}
// Mensajes sin mirar
$query1 = "SELECT COUNT(1) AS contador FROM cx_notifica WHERE usuario1='$usu_usuario' AND visto='1'";
$cur1 = odbc_exec($conexion, $query1);
$contador1 = odbc_result($cur1,1);
// Mensajes total
$query2 = "SELECT COUNT(1) AS contador FROM cx_notifica WHERE usuario1='$usu_usuario'";
$cur2 = odbc_exec($conexion, $query2);
$contador2 = odbc_result($cur2,1);
$porcentaje = (($contador1*100)/$contador2);
$porcentaje = round($porcentaje, 2);
// Ingresos ultimo mes
$fecha1 = date('Y-m-d');
$fecha2 = strtotime('-30 day', strtotime($fecha1));
$fecha2 = date('Y-m-d', $fecha2);
$query3 = "SELECT ISNULL(SUM(contador),0) AS contador FROM cv_por_log WHERE usuario='$usu_usuario' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha2',102) AND CONVERT(datetime,'$fecha1',102)";
$cur3 = odbc_exec($conexion, $query3);
$contador3 = odbc_result($cur3,1);
// PQR registrados
$query4 = "SELECT COUNT(1) AS contador FROM cx_pqr_reg WHERE usuario='$usu_usuario'";
$cur4 = odbc_exec($conexion, $query4);
$contador4 = odbc_result($cur4,1);
// PQR cerrados
$query5 = "SELECT COUNT(1) AS contador FROM cx_pqr_reg WHERE usuario='$usu_usuario' AND estado='B'";
$cur5 = odbc_exec($conexion, $query5);
$contador5 = odbc_result($cur5,1);
// PQR en tramite
$query6 = "SELECT COUNT(1) AS contador FROM cx_pqr_reg WHERE usuario='$usu_usuario' AND estado IN ('','A','C')";
$cur6 = odbc_exec($conexion, $query6);
$contador6 = odbc_result($cur6,1);
// PQR rechazados
$query7 = "SELECT COUNT(1) AS contador FROM cx_pqr_reg WHERE usuario='$usu_usuario' AND estado='Y'";
$cur7 = odbc_exec($conexion, $query7);
$contador7 = odbc_result($cur7,1);
// PQR asignados
$query9 = "SELECT COUNT(1) AS contador FROM cx_pqr_reg WHERE asigna='$usu_usuario' AND estado='D'";
$cur9 = odbc_exec($conexion, $query9);
$contador9 = odbc_result($cur9,1);
// Grafica
$fechaini = str_replace("/", "-", $fecha2);
$fechafin = str_replace("/", "-", $fecha1);
$fechaini = strtotime($fechaini);
$fechafin = strtotime($fechafin);
$fechas = "";
$ingresos = "";
for ($i=$fechaini; $i<=$fechafin; $i+=86400)
{
	$fecha3 = date("Y-m-d", $i);
	$fecha4 = explode("-",$fecha3);
	$fecha4 = $fecha4[0]."/".$fecha4[1]."/".$fecha4[2];
	$query8 = "SELECT ISNULL(SUM(contador),0) AS contador FROM cv_por_log WHERE usuario='$usu_usuario' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha4',102) AND CONVERT(datetime,'$fecha4',102)";
	$cur8 = odbc_exec($conexion, $query8);
	$contador8 = odbc_result($cur8,1);
	$fechas .= "'".$fecha4."', ";
	$ingresos .= $contador8.", ";
}
$fechas = substr($fechas, 0, -2);
$ingresos = substr($ingresos, 0, -2);
?>
<html lang="es">
<head>
	<?php
 	include('encabezado2.php');
 	include('encabezado4.php');
 	?>
	<style>
	body
	{
	    background: #f4f7f9;
	}
	</style>
	<script type="text/javascript" src="alertas/lib/alertify.js"></script>
	<link rel="stylesheet" href="alertas/themes/alertify.core.css"/>
	<link rel="stylesheet" href="alertas/themes/alertify.default.css"/>
</head>
<body>
<?php
include('titulo.php');
?>
<script>
function alerta()
{
	alertify.error("A fecha <?php echo $fecha; ?> no se ha recibido su Plan de Inversión para el próximo mes.");
}
</script>
<?php
// Si es usuario regimen interno
if (($adm_usuario == "1") or ($adm_usuario == "3"))
{
	// Si el dia es mas de 25 y no se ha enviado el plan del mes siguiente
	if ($dia > 25)
	{
	    $query = "SELECT count(1) as contador FROM cx_pla_inv WHERE tipo='1' AND periodo='$mes' AND ano='$ano' AND usuario='$usu_usuario' AND unidad='$uni_usuario'";
	    $cur = odbc_exec($conexion, $query);
	    $contador = odbc_result($cur,1);
	    if ($contador == "0")
	    {
	    	echo "<script>alerta();</script>";
	    }
	}
}
?>
<div>
   	<section class="content">
     	<div class="row">
     		<div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
     		<div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
	        	<div class="info-box bg-red">
	            	<span class="info-box-icon"><i class="fa fa-envelope-o"></i></span>
		            <div class="info-box-content">
		            	<span class="info-box-text">Mensajes</span>
	              		<span class="info-box-number"><?php echo $contador1; ?> / <?php echo $contador2; ?></span>
			            <div class="progress">
	                		<div class="progress-bar" style="width: <?php echo $porcentaje; ?>%"></div>
	              		</div>
	                	<span class="progress-description"><?php echo $porcentaje; ?> % de mensajes sin leer</span>
	                	<input type="hidden" name="usuario" id="usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly">
	                	<input type="hidden" name="fecha1" id="fecha1" class="form-control" value="<?php echo $fecha1; ?>" readonly="readonly">
	                	<input type="hidden" name="fecha2" id="fecha2" class="form-control" value="<?php echo $fecha2; ?>" readonly="readonly">
	                	<input type="hidden" name="fechas" id="fechas" class="form-control" value="<?php echo $fechas; ?>" readonly="readonly">
	                	<input type="hidden" name="ingresos" id="ingresos" class="form-control" value="<?php echo $ingresos; ?>" readonly="readonly">
	            	</div>
	          	</div>
	        </div>
     		<div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
	        	<div class="info-box bg-green">
	            	<span class="info-box-icon"><i class="fa fa-desktop"></i></span>
		            <div class="info-box-content">
		            	<span class="info-box-text">Ingresos &Uacute;ltimo Mes</span>
	              		<span class="info-box-number"><?php echo $contador3; ?></span>
			            <div class="progress">
	                		<div class="progress-bar" style="width: 100%"></div>
	              		</div>
	                	<span class="progress-description">Entre <?php echo $fecha2; ?> / <?php echo $fecha1; ?></span>
	            	</div>
	          	</div>
	        </div>
		</div>
		<br>
		<div id="res_grafica"></div>
		<br>
		<div class="row">
			<table width="100%" align="center" border="0">
				<tr>
					<td width="20%">
						<div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
							<div class="small-box bg-aqua">
								<div class="inner">
									<h3><?php echo $contador4; ?></h3>
									<p>Soportes Registrados</p>
								</div>
								<div class="icon">
									<i class="fa fa-edit"></i>
								</div>
							</div>
						</div>
					</td>
					<td width="20%">
						<div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
			          		<div class="small-box bg-green">
			            		<div class="inner">
			              			<h3><?php echo $contador5; ?></h3>
						            <p>Soportes Cerrados</p>
			            		</div>
			            		<div class="icon">
			              			<i class="fa fa-thumbs-o-up"></i>
			            		</div>
			          		</div>
				        </div>
					</td>
					<td width="20%">
						<div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
			          		<div class="small-box bg-yellow">
			            		<div class="inner">
			              			<h3><?php echo $contador6; ?></h3>
						            <p>Soportes En Tr&aacute;mite</p>
			            		</div>
			            		<div class="icon">
			              			<i class="fa fa-hourglass-2"></i>
			            		</div>
			          		</div>
				        </div>
					</td>
					<td width="20%">
						<div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
			          		<div class="small-box bg-red">
			            		<div class="inner">
			              			<h3><?php echo $contador7; ?></h3>
						            <p>Soportes Rechazados</p>
			            		</div>
			            		<div class="icon">
			              			<i class="fa fa-thumbs-o-down"></i>
			            		</div>
			          		</div>
				        </div>
					</td>
					<td width="20%">
						<div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
			          		<div class="small-box bg-purple">
			            		<div class="inner">
			              			<h3><?php echo $contador9; ?></h3>
						            <p>Soportes Asignados</p>
			            		</div>
			            		<div class="icon">
			              			<i class="fa fa-user-plus"></i>
			            		</div>
			          		</div>
				        </div>
					</td>
				</tr>
			</table>
	    </div>
    </section>
</div>
<script src="js/inactividad.js?1.0.0"></script>
<script src="js4/highcharts.js"></script>
<script src="js4/modules/data.js"></script>
<script src="js4/modules/drilldown.js?1.0.0"></script>
<script src="js4/modules/highcharts-3d.js"></script>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
	grafica();
});
function grafica()
{
	$("#res_grafica").html('');
	var usuario = $("#usuario").val();
	var fecha1 = $("#fecha1").val();
	var fecha2 = $("#fecha2").val();
    var datos = $("#fechas").val();
    var datos1 = $("#ingresos").val();
	var titulo = "Ingresos entre "+fecha2+" / "+fecha1;
	var salida = "";
	salida += "<div id='grafica1' style='width: 100%; height: 400px; margin: 0 auto'></div>";
	$("#res_grafica").append(salida);
	var grafica1 = '$("#grafica1").highcharts({ chart: { type: "line" }, title: { text: "'+titulo+'" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados" }, xAxis: { categories: [ '+datos+'] }, yAxis: { title: { text: "Ingresos Diarios" } }, credits: { enabled: false }, plotOptions: { line: { dataLabels: { enabled: true }, enableMouseTracking: false } }, series: [{ name: "'+usuario+'", data: [ '+datos1+' ] }] })';
	eval(grafica1);
}
</script>
</body>
</html>