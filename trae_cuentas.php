<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
    $pregunta = "SELECT * FROM cx_ctr_cue ORDER BY conse";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $saldo1 = $row['saldo'];
            $saldo1 = floatval($saldo1);
            $saldo1 = number_format($saldo1, 2);
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['cuenta'] = trim($row['cuenta']);
            $salida->rows[$i]['nombre'] = trim(utf8_encode($row["nombre"]));
            $salida->rows[$i]['banco'] = $row['banco'];
            $salida->rows[$i]['saldo'] = $row['saldo'];
            $salida->rows[$i]['saldo1'] = $saldo1;
            $i++;
        }
    	$salida->salida = "1";
      	$salida->total = $total;
    }
    else
    {
    	$salida->salida = "0";
      	$salida->total = "0";
    }
    echo json_encode($salida);
}
?>