<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $conse = $_POST['conse'];
    $acta = $_POST['acta'];
    $ano = $_POST['ano'];
    $pregunta = "SELECT conse, ano, acta, lugar, fec_act, centraliza, periodo, planes, fec_ini, fec_ter, responsable, documentos, aspectos, observaciones, recomendaciones, reconocimientos, actividades, funcionarios, elaboro, reviso, presentan FROM cx_act_ver WHERE conse='$conse' AND acta='$acta' AND ano='$ano'";
    $sql = odbc_exec($conexion,$pregunta);
    $conse = odbc_result($sql,1);
    $ano = odbc_result($sql,2);
    $acta = trim(odbc_result($sql,3));
    $lugar = trim(utf8_encode(odbc_result($sql,4)));
    $fecha = substr(odbc_result($sql,5),0,10);
    $centraliza = trim(utf8_encode(odbc_result($sql,6)));
    $periodo = trim(utf8_encode(odbc_result($sql,7)));
    $planes = trim(utf8_encode(odbc_result($sql,8)));
    $fecha1 = substr(odbc_result($sql,9),0,10);
    $fecha2 = substr(odbc_result($sql,10),0,10);
    $firmas = trim(utf8_encode(odbc_result($sql,11)));
    $documentos = trim(utf8_encode(odbc_result($sql,12)));
    $aspectos = trim(utf8_encode(odbc_result($sql,13)));
    $observaciones = trim(utf8_encode(odbc_result($sql,14)));
    $recomendaciones = trim(utf8_encode(odbc_result($sql,15)));
    $reconocimientos = trim(utf8_encode(odbc_result($sql,16)));
    $actividades = trim(utf8_encode(odbc_result($sql,17)));
    $firmas1 = trim(utf8_encode(odbc_result($sql,18)));
    $elaboro = trim(utf8_encode(odbc_result($sql,19)));
    $reviso = trim(utf8_encode(odbc_result($sql,20)));
    $firmas2 = trim(utf8_encode(odbc_result($sql,21)));
    $salida = new stdClass();
    $salida->conse = $conse;
    $salida->ano = $ano;
    $salida->acta = $acta;
    $salida->lugar = $lugar;
    $salida->fecha = $fecha;
    $salida->centraliza = $centraliza;
    $salida->periodo = $periodo;
    $salida->planes = $planes;
    $salida->fecha1 = $fecha1;
    $salida->fecha2 = $fecha2;
    $salida->firmas = $firmas;
    $salida->documentos = $documentos;
    $salida->aspectos = $aspectos;
    $salida->observaciones = $observaciones;
    $salida->recomendaciones = $recomendaciones;
    $salida->reconocimientos = $reconocimientos;
    $salida->actividades = $actividades;
    $salida->firmas1 = $firmas1;
    $salida->elaboro = $elaboro;
    $salida->reviso = $reviso;
    $salida->firmas2 = $firmas2;
    echo json_encode($salida);
}
?>