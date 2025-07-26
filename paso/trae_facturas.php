<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
require('funciones.php');
if (is_ajax())
{
    $facturas = $_POST['facturas'];
    $num_facturas = explode("|",$facturas);
    $tot_facturas = 0;
    for ($i=0;$i<count($num_facturas)-1;++$i)
    {
        $carpeta = $num_facturas[$i];
        $ruta = "upload/bienes/".$sig_usuario."/".$carpeta."/";
        $contador = count(glob("{$ruta}/*.*"));
        if ($contador == "0")
        {
            $tot_facturas ++;
        }
    }
    $salida->salida = $tot_facturas;
    echo json_encode($salida);
}
?>