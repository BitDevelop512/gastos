<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
// Si no es peticion ajax no se ejecuta
if (is_ajax())
{
    $subdependencia = $_POST['subdependencia'];
    $query = "SELECT * FROM cx_org_sub WHERE subdependencia='$subdependencia'";
    $sql = odbc_exec($conexion,$query);
    $unidad = odbc_result($sql,1);
    $dependencia = odbc_result($sql,2);
    $subdependencia = odbc_result($sql,3);
    $sigla = trim(odbc_result($sql,4));
    $ciudad = utf8_encode(trim(odbc_result($sql,5)));
    $nombre = utf8_encode(trim(odbc_result($sql,6)));
    $tipo = odbc_result($sql,7);
    $unic = odbc_result($sql,8);
    $techo = odbc_result($sql,9);
    $banco = odbc_result($sql,10);
    $cuenta = trim(odbc_result($sql,11));
    $cheque = trim(odbc_result($sql,12));
    list($cheque, $cheque1, $cheque2) = explode("|", $cheque);
    $firma1 = utf8_encode(trim(odbc_result($sql,13)));
    $firma2 = utf8_encode(trim(odbc_result($sql,14)));
    $firma3 = utf8_encode(trim(odbc_result($sql,15)));
    $firma4 = utf8_encode(trim(odbc_result($sql,16)));
    $nit = trim(odbc_result($sql,27));
    $cargo1 = utf8_encode(trim(odbc_result($sql,28)));
    $cargo2 = utf8_encode(trim(odbc_result($sql,29)));
    $cargo3 = utf8_encode(trim(odbc_result($sql,30)));
    $cargo4 = utf8_encode(trim(odbc_result($sql,31)));
    $especial = odbc_result($sql,40);
    $sigla1 = trim(odbc_result($sql,41));
    $nombre1 = utf8_encode(trim(odbc_result($sql,42)));
    $fecha = trim(odbc_result($sql,43));
    $salida->salida = "1";
    $salida->unidad = $unidad;
    $salida->dependencia = $dependencia;
    $salida->subdependencia = $subdependencia;
    $salida->sigla = $sigla;
    $salida->ciudad = $ciudad;
    $salida->nombre = $nombre;
    $salida->tipo = $tipo;
    $salida->unic = $unic;
    $salida->techo = $techo;
    $salida->banco = $banco;
    $salida->cuenta = $cuenta;
    $salida->cheque = $cheque;
    $salida->cheque1 = $cheque1;
    $salida->cheque2 = $cheque2;
    $salida->nit = $nit;
    $salida->firma1 = $firma1;
    $salida->firma2 = $firma2;
    $salida->firma3 = $firma3;
    $salida->firma4 = $firma4;
    $salida->cargo1 = $cargo1;
    $salida->cargo2 = $cargo2;
    $salida->cargo3 = $cargo3;
    $salida->cargo4 = $cargo4;
    $salida->especial = $especial;
    $salida->sigla1 = $sigla1;
    $salida->nombre1 = $nombre1;
    $salida->fecha = $fecha;
	echo json_encode($salida);
}
?>