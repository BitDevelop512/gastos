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
    $pregunta = "SELECT * FROM cx_pla_gas WHERE conse1='$conse' AND unidad='$uni_usuario' AND ano='$ano' ORDER BY conse, interno";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    $i=1;
    while($i<$row=odbc_fetch_array($sql))
    {
        $mision = trim(utf8_encode(odbc_result($sql,5)));
        $area = trim(utf8_encode(odbc_result($sql,6)));
        $fecha1 = trim(odbc_result($sql,7));
        $fecha2 = trim(odbc_result($sql,8));
        $oficiales = trim(odbc_result($sql,9));
        $suboficiales = trim(odbc_result($sql,10));
        $auxiliares = trim(odbc_result($sql,11));
        $soldados = trim(odbc_result($sql,12));
        $valor = trim(odbc_result($sql,13));
        $valora = trim(odbc_result($sql,14));
        $actividades = odbc_result($sql,15);
        $factor = odbc_result($sql,16);
        $estructura = odbc_result($sql,17);
        $pregunta1 = "SELECT * FROM cx_pla_gad WHERE conse1='$conse' AND interno='$i' AND unidad='$uni_usuario' AND ano='$ano'";
        $sql1 = odbc_exec($conexion,$pregunta1);
        $total1 = odbc_num_rows($sql1);
        $salida1 = new stdClass();
        $j=1;
        while($j<$row=odbc_fetch_array($sql1))
        {
            $v_gasto = trim(odbc_result($sql1,5));
            $v_otro = trim(odbc_result($sql1,6));
            $v_valor = trim(odbc_result($sql1,7));
            $v_bienes = trim($row['bienes']);
            $v_bienes = str_replace('|','»',$v_bienes);
            $v_bienes = utf8_encode($v_bienes);
            $v_vari[$i] .= $v_gasto."|".$v_otro."|".$v_valor."|".$v_bienes."«";
            $j++;
        }
        $v_paso =  $v_vari[$i];
        $salida->rows[$i]['mision'] = $mision;
        $salida->rows[$i]['area'] = $area;
        $salida->rows[$i]['fecha1'] = $fecha1;
        $salida->rows[$i]['fecha2'] = $fecha2;
        $salida->rows[$i]['oficiales'] = $oficiales;
        $salida->rows[$i]['suboficiales'] = $suboficiales;
        $salida->rows[$i]['auxiliares'] = $auxiliares;
        $salida->rows[$i]['soldados'] = $soldados;
        $salida->rows[$i]['valor'] = $valor;
        $salida->rows[$i]['valora'] = $valora;
        $salida->rows[$i]['valores'] = $v_paso;
        $salida->rows[$i]['actividades'] = $actividades;
        $salida->rows[$i]['factor'] = $factor;
        $salida->rows[$i]['estructura'] = $estructura;
        $i++;
    }
    $salida->total = $total;
    echo json_encode($salida);
}
?>