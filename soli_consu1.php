<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $sustituye = array ( "'" => "" );
    $pregunta = "SELECT * FROM cx_rec_aut WHERE 1=1";
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1)";
    }
    $pregunta .= " ORDER BY fecha DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $unidad = $row['unidad'];
            $actas = trim(decrypt1($row['actas'], $llave));
            $actas = strtr(trim($actas), $sustituye);
            $actas = str_replace(",", ", ", $actas);
            $query1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
            $cur1 = odbc_exec($conexion, $query1);
            $n_uni = trim(odbc_result($cur1,1));
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
            $salida->rows[$i]['usuario'] = $row['usuario'];
            $salida->rows[$i]['unidad'] = $n_uni;
            $salida->rows[$i]['actas'] = $actas;
            $salida->rows[$i]['ano'] = $row['ano'];
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
// 26/01/2024 - Ajuste sigla espacios en blanco
?>