<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
    $consulta = $_POST['consulta'];
    $pago = $_POST['pago'];
    $pagos = stringArray1($pago);
    $recurso = $_POST['recurso'];
    $recursos = stringArray1($recurso);
    $periodo1 = $_POST['periodo1'];
    $periodo2 = $_POST['periodo2'];
    $ano = $_POST['ano'];
    $unidad = $_POST['unidad'];
    $unidades = stringArray1($unidad);
    $longitud = explode(",",$unidades);
    $centra = $_POST['centra'];
    $sigla = $_POST['sigla'];
    $valores = "";
    $valores1 = "";
    $valores2 = "";
    $valores3 = "";
    if (($centra == "999") and ($sigla == "TODAS"))
    {
        $datos1 = "";
        $datos2 = "";
        $datos3 = "";
        $datos4 = "";
        $datos5 = "";
        for ($j=0; $j<count($longitud); $j++)
        {
            $data[$j] = "";
            $valores[$j] = "";
            $valor = $longitud[$j];           
            $pregunta0 = "SELECT unidad, sigla FROM cx_org_sub WHERE subdependencia='$valor'";
            $sql0 = odbc_exec($conexion, $pregunta0);
            $unidad1 = odbc_result($sql0,1);
            $sigla1 = trim(odbc_result($sql0,2));
            if (($unidad1 == "2") or ($unidad1 == "3"))
            {
                $pregunta = "SELECT dependencia FROM cx_org_sub WHERE unidad='$unidad1' AND sigla='$sigla1'";
                $sql = odbc_exec($conexion, $pregunta);
                $dependencia = odbc_result($sql,1);
                $query = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$unidad1' AND dependencia='$dependencia' ORDER BY sigla";
            }
            else
            {
                $query = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$unidad1' ORDER BY sigla";
            }
            $cur = odbc_exec($conexion, $query);
            $k = 0;
            $unidades1 = "";
            while($k<$row=odbc_fetch_array($cur))
            {
                $v1 = odbc_result($cur,1);
                $unidades1 .= "'".$v1."',";
            }
            $unidades1 = substr($unidades1, 0, -1);
            $tot_gas = 0;
            $tot_pag = 0;
            $tot_rel = 0;
            // Consulta de unidades de centralizadora
            $pregunta = "SELECT conse, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_pla_inv.unidad) AS n_unidad FROM cx_pla_inv WHERE unidad IN ($unidades1) AND estado NOT IN ('','Y') AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' ORDER BY conse";
            $cur = odbc_exec($conexion, $pregunta);
            $tot_cur = odbc_num_rows($cur);
            if ($tot_cur > 0)
            {
                $i = 0;
                $conses = "";
                while($i<$row=odbc_fetch_array($cur))
                {
                    $x1 = odbc_result($cur,1);
                    $x2 = trim(odbc_result($cur,2));
                    $conses .= "'".$x1."',";
                }
                $conses = substr($conses, 0, -1);
            }
            // Suma total gastos
            $pregunta1 = "SELECT SUM(total) AS total FROM cv_pla_som WHERE conse IN ($conses) AND ano='$ano'";
            $cur1 = odbc_exec($conexion, $pregunta1);
            $t1 = odbc_result($cur1,1);
            $t1 = floatval($t1);
            if (trim($conses) == "")
            {
                $t1 = "0.00";
            }
            $v1 = trim(odbc_result($cur1,2));
            $tot_gas = $tot_gas+$t1;
            // Suma total pagos
            $pregunta2 = "SELECT SUM(total) AS total FROM cv_pla_soq WHERE conse IN ($conses) AND ano='$ano'";
            $cur2 = odbc_exec($conexion, $pregunta2);
            $t2 = odbc_result($cur2,1);
            $t2 = floatval($t2);
            if (trim($conses) == "")
            {
                $t2 = "0.00";
            }
            $v2 = trim(odbc_result($cur2,2));
            $tot_pag = $tot_pag+$t2;
            $total1 = $tot_gas+$tot_pag;
            $datos1 .= "'".$sigla1."',";
            $datos2 .= $total1.",";
            // Suma de relacion de gastos
            $pregunta3 = "SELECT conse, consecu FROM cx_rel_gas WHERE unidad IN ($unidades1) AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' ORDER BY conse";
            $cur3 = odbc_exec($conexion, $pregunta3);
            $tot_cur3 = odbc_num_rows($cur3);
            if ($tot_cur3 > 0)
            {
                $i = 0;
                while($i<$row=odbc_fetch_array($cur3))
                {
                    $y1 = odbc_result($cur3,1);
                    $y2 = odbc_result($cur3,2);
                    $pregunta4 = "SELECT SUM(valor1) AS total FROM cx_rel_dis WHERE conse1='$y1' AND consecu='$y2' AND ano='$ano'";
                    $cur4 = odbc_exec($conexion, $pregunta4);
                    $t3 = odbc_result($cur4,1);
                    $t3 = floatval($t3);
                    $tot_rel = $tot_rel+$t3;
                }
            }
            $datos3 .= $tot_rel.",";
            $calculo1 = ($tot_rel*100)/$total1;
            $calculo1 = round($calculo1, 2);
            $calculo1 = floatval($calculo1);
            $calculo2 = 100-$calculo1;
            $calculo2 = round($calculo2, 2);
            $datos4 .= $calculo1.",";
            $datos5 .= $calculo2.",";
        }
        $datos1 = substr($datos1, 0, -1);
        $datos2 = substr($datos2, 0, -1);
        $datos3 = substr($datos3, 0, -1);
        $datos4 = substr($datos4, 0, -1);
        $datos5 = substr($datos5, 0, -1);
        $salida->datos1 = $datos1;
        $salida->datos2 = $datos2;
        $salida->datos3 = $datos3;
        $salida->datos4 = $datos4;
        $salida->datos5 = $datos5;
    }
    else
    {
        $tot_gas = 0;
        $tot_pag = 0;
        $tot_rel = 0;
        for ($j=0; $j<count($longitud); $j++)
        {
            $data[$j] = "";
            $valores[$j] = "";
            $valor = $longitud[$j];
            $pregunta = "SELECT conse, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_pla_inv.unidad) AS n_unidad FROM cx_pla_inv WHERE unidad='$valor' AND estado NOT IN ('','Y') AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' ORDER BY conse";
            $cur = odbc_exec($conexion, $pregunta);
            $tot_cur = odbc_num_rows($cur);
            if ($tot_cur > 0)
            {
                $i = 0;
                $conses = "";
                while($i<$row=odbc_fetch_array($cur))
                {
                    $x1 = odbc_result($cur,1);
                    $x2 = trim(odbc_result($cur,2));
                    $conses .= "'".$x1."',";
                }
                $conses = substr($conses, 0, -1);
                // Suma total gastos
                $pregunta1 = "SELECT SUM(total) AS total, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cv_pla_som.unidad) AS n_unidad FROM cv_pla_som WHERE conse IN ($conses) AND ano='$ano' AND unidad='$valor' GROUP BY unidad";
                $cur1 = odbc_exec($conexion, $pregunta1);
                $t1 = odbc_result($cur1,1);
                if (trim($conses) == "")
                {
                    $t1 = "0.00";
                }
                $v1 = trim(odbc_result($cur1,2));
                $tot_gas = $tot_gas+$t1;
                // Suma total pagos
                $pregunta2 = "SELECT SUM(total) AS total, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cv_pla_soq.unidad) AS n_unidad FROM cv_pla_soq WHERE conse IN ($conses) AND ano='$ano' AND unidad='$valor' GROUP BY unidad";
                $cur2 = odbc_exec($conexion, $pregunta2);
                $t2 = odbc_result($cur2,1);
                if (trim($conses) == "")
                {
                    $t2 = "0.00";
                }
                $v2 = trim(odbc_result($cur2,2));
                $tot_pag = $tot_pag+$t2;
            }
            // Suma de relacion de gastos
            $pregunta3 = "SELECT conse, consecu FROM cx_rel_gas WHERE unidad='$valor' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' ORDER BY conse";
            $cur3 = odbc_exec($conexion, $pregunta3);
            $tot_cur3 = odbc_num_rows($cur3);
            if ($tot_cur3 > 0)
            {
                $i = 0;
                $conses1 = "";
                while($i<$row=odbc_fetch_array($cur3))
                {
                    $y1 = odbc_result($cur3,1);
                    $y2 = odbc_result($cur3,2);
                    $pregunta4 = "SELECT SUM(valor1) AS total FROM cx_rel_dis WHERE conse1='$y1' AND consecu='$y2' AND ano='$ano'";
                    $cur4 = odbc_exec($conexion, $pregunta4);
                    $t3 = odbc_result($cur4,1);
                    $t3 = floatval($t3);
                    $tot_rel = $tot_rel+$t3;
                }
            }
        }
        $total1 = $tot_gas+$tot_pag;
        $total2 = $tot_rel;
        $total3 = ($total2*100)/$total1;
        $total3 = round($total3, 2);
        $total3 = floatval($total3);
        $total4 = 100-$total3;
        $total4 = round($total4, 2);
        $salida->total1 = $total1;
        $salida->total2 = $total2;
        $salida->total3 = $total3;
        $salida->total4 = $total4;
    }
    echo json_encode($salida);
}
// 23/11/2023 - Estadistica Ejecucion de Presupuestos
?>