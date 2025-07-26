<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
    $periodo1 = $_POST['periodo1'];
    $periodo2 = $_POST['periodo2'];
    $ano = $_POST['ano'];
    $unidad = $_POST['unidad'];
    $unidades = stringArray1($unidad);
    $valores = "";
    $pregunta = "SELECT sigla, SUM(gastos) AS gastos, SUM(pagos) AS pagos, SUM(total) AS total FROM cx_val_aut WHERE unidad IN ($unidades) AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' GROUP BY sigla, unidad";
    $cur = odbc_exec($conexion, $pregunta);
    $total = odbc_num_rows($cur);
    $total = intval($total);
    if ($total > 0)
    {
        $k = 0;
        while($k<$row=odbc_fetch_array($cur))
        {
            $v1 = trim(odbc_result($cur,1));
            $v2 = odbc_result($cur,2);
            if ($v2 == ".00")
            {
                $v2 = "0.00";
            }
            $v3 = odbc_result($cur,3);
            if ($v3 == ".00")
            {
                $v3 = "0.00";
            }
            $v4 = odbc_result($cur,4);
            if ($v4 == ".00")
            {
                $v4 = "0.00";
            }
            $valores .= $v1."|".$v2."|".$v3."|".$v4."|#";
        }
    }
    $salida->total = $total;
    $salida->datos = $valores;
    echo json_encode($salida);
}
// 11/11/2023 - Estadistica de Planes Centralizados - Exportacion a excel
?>