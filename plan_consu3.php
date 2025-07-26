<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $conse = $_POST['plan'];
    $ano = $_POST['ano'];
    $pregunta = "SELECT * FROM cx_pla_pag WHERE conse='$conse' AND unidad='$uni_usuario' AND ano='$ano'";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    $i=1;
    while($i<$row=odbc_fetch_array($sql))
    {
        $cedula = trim(odbc_result($sql,4));
        $nombre = trim(utf8_encode(odbc_result($sql,5)));
        $factor = trim(odbc_result($sql,6));
        $estructura = trim(odbc_result($sql,7));
        $fecha1 = trim(odbc_result($sql,8));
        $sintesis = trim(utf8_encode($row["sin_fuen"]));
        $difusion = odbc_result($sql,10);
        $ndifusion = trim(odbc_result($sql,11));
        $fecha2 = trim(odbc_result($sql,12));
        $resultado = trim(odbc_result($sql,13));
        $radiograma = trim(odbc_result($sql,14));
        $fecha3 = trim(odbc_result($sql,15));
        $utilidad = trim(utf8_encode($row["uti_fuen"]));
        $valorf = trim(odbc_result($sql,17));
        $valora = trim(odbc_result($sql,18));
        $unidad = trim(odbc_result($sql,19));
        $recoleccion = odbc_result($sql,24);
        $nrecoleccion = trim(odbc_result($sql,25));
        $fecha4 = trim(odbc_result($sql,26));
        $ordop = trim(utf8_encode(odbc_result($sql,27)));
        $batallon = trim(utf8_encode(odbc_result($sql,28)));
        $fecha5 = trim(odbc_result($sql,29));
        $salida->rows[$i]['cedula'] = $cedula;
        $salida->rows[$i]['nombre'] = $nombre;
        $salida->rows[$i]['factor'] = $factor;
        $salida->rows[$i]['estructura'] = $estructura;
        $salida->rows[$i]['fecha1'] = $fecha1;
        $salida->rows[$i]['sintesis'] = $sintesis;
        $salida->rows[$i]['recoleccion'] = $recoleccion;
        $salida->rows[$i]['nrecoleccion'] = $nrecoleccion;
        $salida->rows[$i]['fecha4'] = $fecha4;
        $salida->rows[$i]['difusion'] = $difusion;
        $salida->rows[$i]['ndifusion'] = $ndifusion;
        $salida->rows[$i]['fecha2'] = $fecha2;
        $salida->rows[$i]['resultado'] = $resultado;
        $salida->rows[$i]['radiograma'] = $radiograma;
        $salida->rows[$i]['fecha3'] = $fecha3;
        $salida->rows[$i]['ordop'] = $ordop;
        $salida->rows[$i]['batallon'] = $batallon;
        $salida->rows[$i]['fecha5'] = $fecha5;
        $salida->rows[$i]['utilidad'] = $utilidad;
        $salida->rows[$i]['valorf'] = $valorf;
        $salida->rows[$i]['valora'] = $valora;
        $salida->rows[$i]['unidad'] = $unidad;
        $i++;
    }
    $salida->total = $total;
    echo json_encode($salida);
}
?>