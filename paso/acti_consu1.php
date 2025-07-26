<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $conse = $_POST['conse'];
    $unidad = $_POST['unidad'];
    $ano = $_POST['ano'];
    $pregunta = "SELECT conse, pla_inv, firmas, testigo, utilidad, sintesis, empleo, observacion, fuente, valor, difusion, unidad1, num_dif, fec_dif, pys, pagos, numero FROM cx_act_inf WHERE conse='$conse' AND unidad='$unidad' AND ano='$ano'";
    $sql = odbc_exec($conexion,$pregunta);
    $conse = odbc_result($sql,1);
    $plan = odbc_result($sql,2);
    $firmas = trim(odbc_result($sql,3));
    $firmas = decrypt1($firmas, $llave);
    $testigo = trim(odbc_result($sql,4));
    $testigo = utf8_encode($testigo);
    $utilidad = trim(odbc_result($sql,5));
    $utilidad = utf8_encode($utilidad);
    $sintesis = trim(odbc_result($sql,6));
    $sintesis = utf8_encode($sintesis);
    $empleo = trim(odbc_result($sql,7));
    $empleo = utf8_encode($empleo);
    $observacion = trim(odbc_result($sql,8));
    $observacion = utf8_encode($observacion);
    $fuente = trim(odbc_result($sql,9));
    $fuente = utf8_encode($fuente);
    $valor = trim(odbc_result($sql,10));
    $difusion = odbc_result($sql,11);
    $unidad1 = odbc_result($sql,12);
    $num_dif = trim(odbc_result($sql,13));
    $fec_dif = trim(odbc_result($sql,14));
    $pys = trim(odbc_result($sql,15));
    $pagos = odbc_result($sql,16);
    $numero = trim(odbc_result($sql,17));
    $numero = utf8_encode($numero);
    $salida = new stdClass();
    $salida->conse = $conse;
    $salida->plan = $plan;
    $salida->firmas = $firmas;
    $salida->testigo = $testigo;
    $salida->utilidad = $utilidad;
    $salida->sintesis = $sintesis;
    $salida->empleo = $empleo;
    $salida->observacion = $observacion;
    $salida->fuente = $fuente;
    $salida->valor = $valor;
    $salida->difusion = $difusion;
    $salida->unidad1 = $unidad1;
    $salida->num_dif = $num_dif;
    $salida->fec_dif = $fec_dif;
    $salida->pys = $pys;
    $salida->pagos = $pagos;
    $salida->numero = $numero;
    echo json_encode($salida);
}
?>