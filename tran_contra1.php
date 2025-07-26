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
    $pregunta = "SELECT * FROM cx_tra_moc WHERE placa='$placa' ORDER BY fecha DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $pregunta1 = "SELECT TOP 1 kilometraje FROM cx_tra_moc WHERE placa='$placa' AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1) ORDER BY fecha DESC";
        $sql1 = odbc_exec($conexion,$pregunta1);
        $kilometros = odbc_result($sql1,1);
        $kilometros = floatval($kilometros);
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $consumo = floatval($row['consumo']);
            $kilometraje = floatval($row['kilometraje']);
            $valor1 = floatval($row['valor1']);
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['fecha'] = substr($row['fecha'],0,10);
            $salida->rows[$i]['consumo'] = $consumo;
            $salida->rows[$i]['kilometraje'] = $kilometraje;
            $salida->rows[$i]['valor'] = trim($row['valor']);
            $salida->rows[$i]['valor1'] = $valor1;
            $salida->rows[$i]['contrato'] = $row['contrato1'];
            $salida->rows[$i]['bonos'] = $row['bonos'];
            $i++;
        }
    	$salida->salida = "1";
      	$salida->total = $total;
        $salida->kilometros = $kilometros;
    }
    else
    {
    	$salida->salida = "0";
      	$salida->total = "0";
        $salida->kilometros = "0";
    }
    // Odometro
    $pregunta2 = "SELECT odometro FROM cx_pla_tra WHERE placa='$placa'";
    $sql2 = odbc_exec($conexion,$pregunta2);
    $odometro = odbc_result($sql2,1);
    $salida->odometro = $odometro;
    echo json_encode($salida);
}
// 05/06/2024 - Ajuste consulta kilometraje
?>