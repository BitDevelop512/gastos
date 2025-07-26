<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $periodo = $_POST['periodo'];
    $ano = $_POST['ano'];
    $concepto = $_POST['concepto'];
    $orden = $_POST['orden'];
    $query = "SELECT conse, n_unidad, numero FROM cx_inf_gir WHERE periodo='$periodo' AND ano='$ano' AND concepto='$concepto'";
    if ($orden == "1")
    {
        $query .= " ORDER BY conse";
    }
    else
    {
        $query .= " ORDER BY n_unidad";
    }
    $sql = odbc_exec($conexion, $query);
    $total = odbc_num_rows($sql);
    // Se declara salida de datos
    $salida = new stdClass();
    $i=1;
    while ($i < $row = odbc_fetch_array($sql))
    {
        $salida->rows[$i]['conse'] = $row['conse'];
        $salida->rows[$i]['n_unidad'] = trim($row['n_unidad']);
        $salida->rows[$i]['numero'] = $row['numero'];
        $i++;
    }
    echo json_encode($salida);
}
?>