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
    $query1 = "SELECT unidad, sigla, depen, n_depen, valor, total, uom, n_uom, conse FROM cx_val_aut2 WHERE periodo='$periodo' AND ano='$ano' AND ((estado='V' AND solicitud='0') OR (estado='' AND registro='0' AND pago='0')) AND inf_giro='0' ORDER BY unidad";
    $sql1 = odbc_exec($conexion, $query1);
    $total1 = odbc_num_rows($sql1);
    // Se declara salida de datos
    $salida = new stdClass();
    if ($total1 == "0")
    {
        $salida->giro = $total1;
        $salida->valor = "0";
        $salida->total = "0";
    }
    else
    {
        $paso_f = "";
        $i=1;
        while ($i < $row = odbc_fetch_array($sql1))
        {
            $valor = $row['valor'];
            if ($valor == ".00")
            {
                $valor = "0.00";
            }
            $valor = floatval($valor);
            $total = $row['total'];
            if ($total == ".00")
            {
                $total = "0.00";
            }
            $total = floatval($total);
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['unidad'] = $row['unidad'];
            $var_uni = $row['unidad'];
            $salida->rows[$i]['sigla'] = trim($row['sigla']);
            $salida->rows[$i]['depen'] = $row['depen'];
            $salida->rows[$i]['n_depen'] = trim($row['n_depen']);
            $salida->rows[$i]['t_valor'] = $valor;
            $salida->rows[$i]['t_total'] = $total;
            $salida->rows[$i]['uom'] = $row['uom'];
            $salida->rows[$i]['n_uom'] = trim($row['n_uom']);
            $paso0 = $row['uom'];
            $paso0 = intval($paso0);
            if ($paso > 3)
            {
                $paso_f .= $row['uom']."|".trim($row['n_uom'])."|".$valor."|0|".$total."#";
            }
            else
            {
                $paso_f .= $row['depen']."|".trim($row['n_depen'])."|".$valor."|0|".$total."#";
            }
            $i++;
        }
        $valor = odbc_result($sql1,5);
        if ($valor == ".00")
        {
            $valor = "0.00";
        }
        $total = odbc_result($sql1,6);
        if ($total == ".00")
        {
            $total = "0.00";
        }
        $salida->giro = $total1;
        $salida->valor = $valor;
        $salida->total = $total;
        $salida->centra = $total1;
        $salida->centraliza = $paso_f;
    }
    echo json_encode($salida);
}
?>