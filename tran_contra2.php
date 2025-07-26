<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $asignado = $_POST['asignado'];
    $asignado = floatval($asignado);
    $tipo = $_POST['tipo'];
    $contrato = $_POST['contrato'];
    switch ($tipo)
    {
        case 'C':
            $tabla = "cx_tra_moc";
            $campo = "total";
            break;
        case 'M':
            $tabla = "cx_tra_man";
            $campo = "total1";
            break;
        case 'L':
            $tabla = "cx_tra_lla";
            $campo = "total1";
            break;
        case 'T':
            $tabla = "cx_tra_rtm";
            $campo = "total1";
            break;
        default:
            $tabla = "";
            $campo = "";
            break;
    }
    if (($uni_usuario == "1") or ($uni_usuario == "2"))
    {
        $pregunta = "SELECT ISNULL(SUM(".$campo."),0) AS total FROM ".$tabla." WHERE unidad='$uni_usuario' AND contrato='$contrato'";
    }
    else
    {
        $pregunta = "SELECT ISNULL(SUM(".$campo."),0) AS total FROM ".$tabla." WHERE usuario='$usu_usuario' AND unidad='$uni_usuario' AND contrato='$contrato'";
    }
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $suma = odbc_result($sql,1);
    if ($suma == ".00")
    {
        $suma = "0.00";
    }
    $disponible = $asignado-$suma;
    $salida = new stdClass();
   	$salida->salida = $suma;
    $salida->disponible = $disponible;
   	$salida->total = $total;
    echo json_encode($salida);
}
// 08/02/2024 - Ajuste calculo valor ejecutado
?>