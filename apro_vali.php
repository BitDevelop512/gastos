<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
// Si no es peticion ajax no se ejecuta
if (is_ajax())
{
    $ano = $_POST['ano'];
    $recurso = $_POST['recurso'];
    $query = "SELECT * FROM cx_apropia WHERE ano='$ano' AND recurso='$recurso'";
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