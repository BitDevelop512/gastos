<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
// Si no es peticion ajax no se ejecuta
if (is_ajax())
{
    $numero = $_POST['numero'];
    $vigencia = $_POST['vigencia'];
    $query = "SELECT * FROM cx_cdp WHERE numero='$numero' AND vigencia='$vigencia'";
    $sql = odbc_exec($conexion,$query);
    $total = odbc_num_rows($sql);
    if ($total>0)
    {
        $salida->salida = "1";
    }
    else
    {
        $salida->salida = "0";
    }
    echo json_encode($salida);
}
?>