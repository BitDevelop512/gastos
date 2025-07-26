<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
require('funciones.php');
if (is_ajax())
{
	$consulta = $_POST['consulta'];
	$consulta = str_replace("estado1, ", "estado1, estado, ", $consulta);
	$mes = $_POST['mes'];
	$ano = $_POST['ano'];
	$pregunta = "SELECT * FROM cx_pla_con WHERE unidad='$uni_usuario' AND periodo='$mes' AND ano='$ano'";
    $sql = odbc_exec($conexion, $pregunta);
    $total = odbc_num_rows($sql);
    $sql1 = odbc_exec($conexion, $consulta);
   	$total1 = odbc_num_rows($sql1);
	$i = 0;
    $estados = "";
    while ($i < $row = odbc_fetch_array($sql1))
    {
    	$estados .= $row['estado']."#";
        $i++;
    }
    $salida->total = $total;
    $salida->total1 = $total1;
    $salida->salida = $estados;
    echo json_encode($salida);
}
?>