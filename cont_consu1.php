<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $conse = $_POST['conse'];
    $pregunta = "SELECT conse, numero, fec_con, objeto, valor, valor1, supervisor, proveedor, fec_ini, fec_fin, cdp, crp, datos, alea, nit, tipo FROM cx_con_pro WHERE conse='$conse'";
    $sql = odbc_exec($conexion,$pregunta);
    $conse = odbc_result($sql,1);
    $numero = trim(odbc_result($sql,2));
    $fecha = substr(odbc_result($sql,3),0,10);
    $objeto = trim(utf8_encode(odbc_result($sql,4)));
    $valor = trim(odbc_result($sql,5));
    $valor1 = odbc_result($sql,6);
    $supervisor = trim(utf8_encode(odbc_result($sql,7)));
    $proveedor = trim(utf8_encode(odbc_result($sql,8)));
    $fecha1 = substr(odbc_result($sql,9),0,10);
    $fecha2 = substr(odbc_result($sql,10),0,10);
    $cdp = odbc_result($sql,11);
    $crp = odbc_result($sql,12);
    $datos = trim(utf8_encode(odbc_result($sql,13)));
    $alea = trim(odbc_result($sql,14));
    $nit = trim(odbc_result($sql,15));
    $tipo = trim(odbc_result($sql,16));
    $salida = new stdClass();
    $salida->conse = $conse;
    $salida->numero = $numero;
    $salida->fecha = $fecha;
    $salida->objeto = $objeto;
    $salida->valor = $valor;
    $salida->valor1 = $valor1;
    $salida->supervisor = $supervisor;
    $salida->proveedor = $proveedor;
    $salida->fecha1 = $fecha1;
    $salida->fecha2 = $fecha2;
    $salida->cdp = $cdp;
    $salida->crp = $crp;
    $salida->datos = $datos;
    $salida->alea = $alea;
    $salida->nit = $nit;
    $salida->tipo = $tipo;
    echo json_encode($salida);
}
?>