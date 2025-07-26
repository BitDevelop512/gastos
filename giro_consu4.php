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
    $uom = $_POST['uom'];
    $dep = $_POST['dep'];
    // Total Unidades Centralizadores Especializada
    $query2 = "SELECT count(1) as contador, depen, n_depen, sum(gastos) as gastos, sum(pagos) as pagos, sum(total) as total FROM cx_val_aut WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND aprueba1>0 AND uom<=3 AND uom IN ($uom) AND n_depen IN ($dep) GROUP BY depen, n_depen ORDER BY depen";
    $sql2 = odbc_exec($conexion, $query2);
    $total2 = odbc_num_rows($sql2);
    $j = 1;
    $k = 1;
    $total1 = 0;
    $paso_f = "";
    while ($j < $row = odbc_fetch_array($sql2))
    {
        $paso0 = $row['contador'];
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
        $paso0 = floatval($paso0);
        $paso3 = floatval($paso3);
        $paso3 = $paso3-$paso_valor;
        $paso4 = floatval($paso4);
        $paso5 = floatval($paso5);
        $paso5 = $paso5-$paso_valor;
        $paso_f .= $paso1."|".$paso2."|".$paso3."|".$paso4."|".$paso5."#";
        $total1 = $total1+$paso0;
        $j++;
    }
    // Total Unidades Centralizadoras Abiertas
    $query3 = "SELECT count(1) as contador, uom, n_uom, sum(gastos) as gastos, sum(pagos) as pagos, sum(total) as total FROM cx_val_aut WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND aprueba1>0 AND uom>3 AND uom IN ($uom) GROUP BY uom, n_uom ORDER BY uom";
    $sql3 = odbc_exec($conexion, $query3);
    $total3 = odbc_num_rows($sql3);
    $j = 1;
    $k = 1;
    $paso_f1 = "";
    while ($j < $row = odbc_fetch_array($sql3))
    {
        $paso0 = $row['contador'];
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
        $pregunta2 = "SELECT subdependencia, dependencia FROM cx_org_sub WHERE unidad='$paso1' AND unic='1' ORDER BY subdependencia";
        $cur2 = odbc_exec($conexion, $pregunta2);
        $numero = "";
        while($i<$row=odbc_fetch_array($cur2))
        {
            $numero .= "'".odbc_result($cur2,1)."',";
            $numero1 = odbc_result($cur2,2);
        }
        $numero = substr($numero,0,-1);
        $paso0 = floatval($paso0);
        $paso3 = floatval($paso3);
        $paso3 = $paso3-$paso_valor;
        $paso4 = floatval($paso4);
        $paso5 = floatval($paso5);
        $paso5 = $paso5-$paso_valor;
        $paso_f1 .= $numero1."|".$paso2."|".$paso3."|".$paso4."|".$paso5."#";
        $total1 = $total1+$paso0;
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
    $salida->centra = $total2+$total3;
    $salida->centraliza = $paso_f.$paso_f1;
    echo json_encode($salida);
}
?>