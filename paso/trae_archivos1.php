<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
require('funciones.php');
if (is_ajax())
{
    $alea = $_POST['alea'];
    $tipo = $_POST['tipo'];
    switch ($tipo)
    {
        case '1':
            $movi = "traspaso";
            break;
        default:
            $movi = "";
        break;
    }
    $sigla = trim($sig_usuario);
    $ruta = "upload/movimientos1/".$sigla."/".$movi."/".$alea."/";
    $contador = count(glob("{$ruta}/*.*"));
    $salida = new stdClass();
    $salida->salida = $contador;
    echo json_encode($salida);
}
?>