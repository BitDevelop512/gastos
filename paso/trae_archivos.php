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
    $sigla = $_POST['sigla'];
    switch ($tipo)
    {
        case '1':
            $movi = "asignacion";
            break;
        case '2':
            $movi = "salida";
            break;
        case '3':
            $movi = "consumo";
            break;
        case '4':
            $movi = "traspaso";
            break;
        case '5':
            $movi = "usuario";
            break;
        case '6':
            $movi = "revista";
            break;
        default:
            $movi = "";
        break;
    }
    if ($sigla == "- SELECCIONAR -")
    {
        $v1 = explode("_", $usu_usuario);
        $v2 = $v1[1];
        $sigla = trim($v2);
    }
    $ruta = "upload/movimientos/".$sigla."/".$movi."/".$alea."/";
    $contador = count(glob("{$ruta}/*.*"));
    $salida = new stdClass();
    $salida->salida = $contador;
    echo json_encode($salida);
}
?>