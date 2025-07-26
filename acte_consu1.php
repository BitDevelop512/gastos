<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $conse = $_POST['conse'];
    $ano = $_POST['ano'];
    $registro = $_POST['registro'];
    $ano1 = $_POST['ano1'];
    $pregunta = "SELECT conse, firmas, cedulas, sintesis, utilidad, observaciones, elaboro, valor, pago, registro, ano1, reviso, expedidas, otro, cambio FROM cx_act_rec WHERE conse='$conse' AND ano='$ano' AND registro='$registro' AND ano1='$ano1'";
    $sql = odbc_exec($conexion,$pregunta);
    $conse = odbc_result($sql,1);
    $firmas = trim(utf8_encode(odbc_result($sql,2)));
    $cedulas = trim(utf8_encode(odbc_result($sql,3)));
    $sintesis = trim(utf8_encode(odbc_result($sql,4)));
    $utilidad = trim(utf8_encode(odbc_result($sql,5)));
    $observaciones = trim(utf8_encode(odbc_result($sql,6)));
    $elaboro = trim(utf8_encode(odbc_result($sql,7)));
    $valor = trim(odbc_result($sql,8));
    $pago = trim(odbc_result($sql,9));
    $registro = odbc_result($sql,10);
    $ano1 = odbc_result($sql,11);
    $reviso = trim(utf8_encode(odbc_result($sql,12)));
    $expedidas = trim(utf8_encode(odbc_result($sql,13)));
    $otro = trim(odbc_result($sql,14));
    $cambio = odbc_result($sql,15);
    $salida = new stdClass();
    $salida->conse = $conse;
    $salida->firmas = $firmas;
    $salida->cedulas = $cedulas;
    $salida->sintesis = $sintesis;
    $salida->utilidad = $utilidad;
    $salida->observaciones = $observaciones;
    $salida->elaboro = $elaboro;
    $salida->valor = $valor;
    $salida->pago = $pago;
    $salida->registro = $registro;
    $salida->ano1 = $ano1;
    $salida->reviso = $reviso;
    $salida->expedidas = $expedidas;
    $salida->otro = $otro;
    $salida->cambio = $cambio;
    echo json_encode($salida);
}
?>