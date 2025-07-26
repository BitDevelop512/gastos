<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
require('funciones.php');
if (is_ajax())
{
    $placa = trim($_POST["placa"]);
    $fecha = trim($_POST["fecha"]);
    $alea = trim($_POST["alea"]);
    $ruta = "upload/contratol/".$placa."/".$fecha."/".$alea."/";
    $contador = count(glob("{$ruta}/*.*"));
    $salida = new stdClass();
    $salida->salida = $contador;
    echo json_encode($salida);
}
?>