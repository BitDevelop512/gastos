<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $conse = $_POST['conse'];
    $batallon = $_POST['batallon'];
    $pregunta = "SELECT * FROM cx_reg_acr WHERE conse='$conse' AND batallon='$batallon'";
    $sql = odbc_exec($conexion,$pregunta);
    $conse = odbc_result($sql,1);
    $batallon = odbc_result($sql,6);
    $brigada = odbc_result($sql,7);
    $division = odbc_result($sql,8);
    $nombre = trim(utf8_encode(odbc_result($sql,9)));
    $cedula = trim(odbc_result($sql,10));
    $concepto = odbc_result($sql,11);
    $acto = odbc_result($sql,12);
    $numero = trim(odbc_result($sql,13));
    $fec_act = substr(odbc_result($sql,14),0,10);
    $solicitud = odbc_result($sql,15);
    $ano = odbc_result($sql,16);
    $ordop = trim(utf8_encode(odbc_result($sql,17)));
    $ofrag = trim(utf8_encode(odbc_result($sql,18)));
    $fec_res = substr(odbc_result($sql,19),0,10);
    $unidad = trim(utf8_encode(odbc_result($sql,20)));
    $valor = trim(odbc_result($sql,21));
    $valor1 = odbc_result($sql,22);
    $fec_con = substr(odbc_result($sql,23),0,10);
    $motivo = trim(utf8_encode(odbc_result($sql,24)));
    $salida = new stdClass();
    $salida->conse = $conse;
    $salida->batallon = $batallon;
    $salida->brigada = $brigada;
    $salida->division = $division;
    $salida->nombre = $nombre;
    $salida->cedula = $cedula;
    $salida->concepto = $concepto;
    $salida->acto = $acto;
    $salida->numero = $numero;
    $salida->fec_act = $fec_act;
    $salida->solicitud = $solicitud;
    $salida->ano = $ano;
    $salida->ordop = $ordop;
    $salida->ofrag = $ofrag;
    $salida->fec_res = $fec_res;
    $salida->unidad = $unidad;
    $salida->valor = $valor;
    $salida->valor1 = $valor1;
    $salida->fec_con = $fec_con;
    $salida->motivo = $motivo;
    echo json_encode($salida);
}
?>