<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $placa = $_POST['placa'];
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $pregunta = "SELECT * FROM cx_tra_man WHERE placa='$placa' ORDER BY fecha DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $pregunta1 = "SELECT ISNULL(MAX(kilometraje), 0) AS kilometraje FROM cx_tra_man WHERE placa='$placa' AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1)";
        $sql1 = odbc_exec($conexion,$pregunta1);
        $kilometros = odbc_result($sql1,1);
        $kilometros = floatval($kilometros);
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $kilometraje = floatval($row['kilometraje']);
            $total1 = floatval($row['total1']);
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['fecha'] = substr($row['fecha'],0,10);
            $salida->rows[$i]['kilometraje'] = $kilometraje;
            $salida->rows[$i]['total'] = trim($row['total']);
            $salida->rows[$i]['total1'] = $total1;
            $salida->rows[$i]['contrato'] = $row['contrato1'];
            $i++;
        }
    	$salida->salida = "1";
      	$salida->total = $total;
        $salida->kilometros = $kilometros;
    }
    else
    {
        $pregunta1 = "SELECT kilometro FROM cx_pla_tra WHERE placa='$placa'";
        $sql1 = odbc_exec($conexion,$pregunta1);
        $kilometros = odbc_result($sql1,1);
        $kilometros = floatval($kilometros);
        if ($kilometros > 0)
        {
            $salida->salida = "1";
            $salida->total = "1";
            $salida->kilometros = $kilometros;
        }
        else
        {
        	$salida->salida = "0";
          	$salida->total = "0";
            $salida->kilometros = "0";
        }
    }
    echo json_encode($salida);
}
?>