<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
// Si no es peticion ajax no se ejecuta
if (is_ajax())
{
    $conses = $_POST['conses'];
    $ano = $_POST['ano'];
    $pregunta = "SELECT estado FROM cx_pla_inv WHERE conse IN ($conses) AND ano='$ano'";
    $cur = odbc_exec($conexion, $pregunta);
    $salida->salida = "0";
    $i = 1;
    $j = 0;
    while($i<$row=odbc_fetch_array($cur))
    {
        $estado = odbc_result($cur,1);
        if ($estado == "P")
        {
            $j++;
        }
    }
    $salida->salida = $j;
    echo json_encode($salida);
}
?>