<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
// Si no es peticion ajax no se ejecuta
if (is_ajax())
{
    $numero = $_POST['numero'];
    $cdp = $_POST['cdp'];
    $query = "SELECT * FROM cx_crp WHERE numero='$numero' AND conse1='$cdp'";
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