<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $ano = $_POST['ano'];
    $mes = $_POST['periodo'];
    $mes1 = $mes-1;
    // Se consultan todas las unidades que estan en la centralizadora
    $query0 = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario' AND unic='1'";
    $cur0 = odbc_exec($conexion, $query0);
    $n_unidad = odbc_result($cur0,1);
    $n_dependencia = odbc_result($cur0,2);
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' ORDER BY dependencia, subdependencia";
    $cur1 = odbc_exec($conexion, $query1);
    $numero = "";
    $numero1 = "";
    while($i<$row=odbc_fetch_array($cur1))
    {
        $n_uni = odbc_result($cur1,1);
        if (($n_uni == "1") or ($n_uni == "2") or ($n_uni == "3") or ($n_uni == "4") or ($n_uni == "5"))
        {
            $numero .= "'".odbc_result($cur1,1)."',";
        }
        else
        {
            $numero1 .= "'".odbc_result($cur1,1)."',";   
        }
    }
    $numero = substr($numero,0,-1);
    $numero1 = substr($numero1,0,-1);
    // Se consulta informacion de solicitud de recursos aprobadas
    $query = "SELECT TOP 1 conse, actual, unidad FROM cx_pla_inv WHERE periodo IN ('$mes1','$mes') AND ano='$ano' AND tipo='2' AND aprueba='0' AND ((unidad IN ($numero) AND estado='C') or (unidad IN ($numero1) AND estado='J')) ORDER BY NEWID()";
    $cur = odbc_exec($conexion, $query);
    $valida = odbc_num_rows($cur);
    if ($valida == "0")
    {
        $interno = "0";
        $actual = "0";
        $unidad = "0";
        $total = "0.00";
        $datos = "";
    }
    else
    {
        $interno = odbc_result($cur,1);
        $actual = odbc_result($cur,2);
        $unidad = odbc_result($cur,3);
        if ($actual == "1")
        {
            $query1 = "SELECT valor_a FROM cx_pla_gas WHERE conse1='$interno' AND ano='$ano'";
        }
        else
        {
            $query1 = "SELECT val_fuen_a FROM cx_pla_pag WHERE conse='$interno' AND ano='$ano'";
        }
        $cur1 = odbc_exec($conexion, $query1);
        while($j<$row=odbc_fetch_array($cur1))
        {
            $v_valor = trim(odbc_result($cur1,1));
            $v_valor1 = str_replace(',','',$v_valor);
            $v_valor1 = substr($v_valor1,0,-3);
            $v_valor1 = floatval($v_valor1);
            $v_total = $v_total+$v_valor1;
            $j++;
        }
        $total = $v_total;
        $total = number_format($total, 2);
        // Se consulta sigla unidad que genero la solicitug
        $query2 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
        $cur2 = odbc_exec($conexion, $query2);
        $sigla = trim(odbc_result($cur2,1));
        $datos = $sigla."|".$total."#";
    }
    $respuesta = array();
    $salida = new stdClass();
    $i = 1;
    $salida->total = $total;
    $salida->solicitud = $interno;
    $salida->datos = $datos;
    echo json_encode($salida);
}
?>