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
        $valores = $num_facturas[$i];
        $valores1 = explode("»",$valores);
        $placa = $valores1[0];
        $sigla = $valores1[1];
        $carpeta = $valores1[2];
        $ruta = "upload/grasas/".$placa."/".$sigla."/".$carpeta."/";
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