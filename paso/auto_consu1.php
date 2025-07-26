<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $unidades = $_POST['unidades'];
    $periodo = $_POST['periodo'];
    $ano = $_POST['ano'];
    // Se consulta si ya hay generado informes de autorizacion
	$query = "SELECT conse FROM cx_inf_aut WHERE unidad1='$unidades' AND periodo='$periodo' AND ano='$ano'";
	$sql = odbc_exec($conexion, $query);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $informe = odbc_result($sql,1);
        $salida->conse = $informe;
    }
    else
    {
        $salida->conse = "0";
    }
    // Se consulta si hay misiones o informantes por autorizar
    $query1 = "SELECT * FROM cx_pla_inv WHERE periodo='$periodo' AND ano='$ano' AND tipo='1' AND estado IN ('D','F','H') AND unidad IN ($unidades) ORDER BY conse";
    $sql1 = odbc_exec($conexion, $query1);
    $total1 = 0;
    while ($m < $row = odbc_fetch_array($sql1))
    {
        $conse = $row['conse'];
        $consulta = "SELECT * FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano' AND autoriza='0'";
        $cur = odbc_exec($conexion,$consulta);
        $total2 = odbc_num_rows($cur);
        $consulta1 = "SELECT * FROM cx_pla_pag WHERE conse='$conse' AND ano='$ano' AND autoriza='0'";
        $cur1 = odbc_exec($conexion,$consulta1);
        $total3 = odbc_num_rows($cur1);
        $total1 = $total1+$total2+$total3;
    }
    $salida->salida = $total;
    $salida->salida1 = $total1;
    echo json_encode($salida);
}
?>