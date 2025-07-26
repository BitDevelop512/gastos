<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $periodo = $_POST['periodo'];
    $ano = $_POST['ano'];
    // Se consultan valores para generar informe de giro
	$query = "SELECT sum(gastos) as gastos, sum(pagos) as pagos, sum(total) as total FROM cx_val_aut1 WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0'";
	$sql = odbc_exec($conexion, $query);
    // Total Unidades
    $query1 = "SELECT unidad, sigla, depen, n_depen, gastos, pagos, total, conse, uom FROM cx_val_aut1 WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' ORDER BY unidad";
    $sql1 = odbc_exec($conexion, $query1);
    $total1 = odbc_num_rows($sql1);
    // Se declara salida de datos
    $salida = new stdClass();
    if ($total1 == "0")
    {
        $salida->giro = $total1;
        $salida->gastos = "0";
        $salida->pagos = "0";
        $salida->total = "0";
    }
    else
    {
        $i=1;
        while ($i < $row = odbc_fetch_array($sql1))
        {
            $gasto = $row['gastos'];
            if ($gasto == ".00")
            {
                $gasto = "0.00";
            }
            $pago = $row['pagos'];
            if ($pago == ".00")
            {
                $pago = "0.00";
            }
            $total = $row['total'];
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['unidad'] = $row['unidad'];
            $var_uni = $row['unidad'];
            $salida->rows[$i]['sigla'] = trim($row['sigla']);
            $salida->rows[$i]['depen'] = $row['depen'];
            $salida->rows[$i]['n_depen'] = trim($row['n_depen']);
            $salida->rows[$i]['t_gastos'] = $gasto;
            $salida->rows[$i]['t_pagos'] = $pago;
            $salida->rows[$i]['t_total'] = $total;
            $salida->rows[$i]['uom'] = $row['uom'];
            $i++;
        }
        // Total Unidades Centralizadores Especializada
        $query2 = "SELECT count(1) as contador, depen, n_depen, sum(gastos) as gastos, sum(pagos) as pagos, sum(total) as total FROM cx_val_aut1 WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND uom<=3  GROUP BY depen, n_depen ORDER BY depen";
        $sql2 = odbc_exec($conexion, $query2);
        $total2 = odbc_num_rows($sql2);
        $j=1;
        $k=1;
        $paso_f = "";
        while ($j < $row = odbc_fetch_array($sql2))
        {
            $paso1 = $row['depen'];
            $paso2 = trim($row['n_depen']);
            $paso3 = $row['gastos'];
            if ($paso3 == ".00")
            {
                $paso3 = "0.00";
            }
            $paso4 = $row['pagos'];
            if ($paso4 == ".00")
            {
                $paso4 = "0.00";
            }
            $paso5 = $row['total'];
            if ($paso5 == ".00")
            {
                $paso5 = "0.00";
            }
            // Se consultan unidades de la dependencia
            $pregunta2 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$paso1' AND unic='1' ORDER BY subdependencia";
            $cur2 = odbc_exec($conexion, $pregunta2);
            $numero = "";
            while($i<$row=odbc_fetch_array($cur2))
            {
                $numero .= "'".odbc_result($cur2,1)."',";
            }
            $numero = substr($numero,0,-1);
            $paso3 = floatval($paso3);
            $paso4 = floatval($paso4);
            $paso5 = floatval($paso5);
            $paso_f .= $paso1."|".$paso2."|".$paso3."|".$paso4."|".$paso5."#";
            $j++;
        }
        // Total Unidades Centralizadoras Abiertas
        $query3 = "SELECT count(1) as contador, uom, n_uom, sum(gastos) as gastos, sum(pagos) as pagos, sum(total) as total FROM cx_val_aut1 WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND uom>3  GROUP BY uom, n_uom ORDER BY uom";
        $sql3 = odbc_exec($conexion, $query3);
        $total3 = odbc_num_rows($sql3);
        $j=1;
        $k=1;
        $paso_f1 = "";
        while ($j < $row = odbc_fetch_array($sql3))
        {
            $paso1 = $row['uom'];
            $paso2 = trim($row['n_uom']);
            $paso3 = $row['gastos'];
            if ($paso3 == ".00")
            {
                $paso3 = "0.00";
            }
            $paso4 = $row['pagos'];
            if ($paso4 == ".00")
            {
                $paso4 = "0.00";
            }
            $paso5 = $row['total'];
            if ($paso5 == ".00")
            {
                $paso5 = "0.00";
            }
            // Se consultan unidades de la dependencia
            $pregunta2 = "SELECT subdependencia, dependencia, especial FROM cx_org_sub WHERE unidad='$paso1' AND unic='1' ORDER BY subdependencia";
            $cur2 = odbc_exec($conexion, $pregunta2);
            $numero = "";
            while($i<$row=odbc_fetch_array($cur2))
            {
                $numero .= "'".odbc_result($cur2,1)."',";
                $numero1 = odbc_result($cur2,2);
                $especial = odbc_result($cur2,3);
                if ($especial == "0")
                {
                }
                else
                {
                    $pregunta3 = "SELECT sigla FROM cx_org_sub WHERE unidad='$especial' AND unic='1'";
                    $cur3 = odbc_exec($conexion, $pregunta3);
                    $paso2 = trim(odbc_result($cur3,1));
                }
            }
            $numero = substr($numero,0,-1);
            $paso3 = floatval($paso3);
            $paso4 = floatval($paso4);
            $paso5 = floatval($paso5);
            $paso_f1 .= $numero1."|".$paso2."|".$paso3."|".$paso4."|".$paso5."#";
            $j++;
        }
        $gastos = odbc_result($sql,1);
        if ($gastos == ".00")
        {
            $gastos = "0.00";
        }
        $pagos = odbc_result($sql,2);
        if ($pagos == ".00")
        {
            $pagos = "0.00";
        }
        $total = odbc_result($sql,3);
        if ($total == ".00")
        {
            $total = "0.00";
        }
        $salida->giro = $total1;
        $salida->gastos = $gastos;
        $salida->pagos = $pagos;
        $salida->total = $total;
        $salida->centra = $total2+$total3;
        $salida->centraliza = $paso_f.$paso_f1;
    }
    echo json_encode($salida);
}
?>