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
    if (($centra == "999") and ($sigla == "TODAS"))
    {
        $actual = date("Y-m-d H:i:s");
        $contador1 = 0;
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
            $pregunta = "SELECT conse, unidad FROM cx_pla_inv WHERE unidad IN ($unidades1) AND estado NOT IN ('','Y') AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' ORDER BY conse";
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
                $unidad1 = odbc_result($cur,2);
                $pregunta0 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad1'";
                $cur0 = odbc_exec($conexion, $pregunta0);
                $n_unidad = trim(odbc_result($cur0,1));
                // Total Misiones
                $contador2 = 0;
                $contador3 = 0;                     // Finalizadas
                $contador4 = 0;                     // Ejecucion
                $contador5 = 0;                     // Diferencia Misiones - Informe Gastos
                $pregunta1 = "SELECT conse1, fechai, fechaf, unidad, interno FROM cx_pla_gas WHERE conse1 IN ($conses) AND ano='$ano' ORDER BY conse1, interno";
                $cur1 = odbc_exec($conexion, $pregunta1);
                $k = 0;
                while($k<$row=odbc_fetch_array($cur1))
                {
                    $w1 = odbc_result($cur1,1);
                    $w2 = trim(odbc_result($cur1,2));
                    $w3 = trim(odbc_result($cur1,3));
                    $w4 = odbc_result($cur1,4);
                    $w5 = odbc_result($cur1,5);
                    $fecha1 = strtotime($w2);
                    $fecha2 = strtotime($w3);
                    $fecha3 = strtotime($actual);
                    if (($fecha3 >= $fecha1) && ($fecha3 <= $fecha2))
                    {
                       $contador3++;
                    }
                    else
                    {
                        $contador4++;
                        // Total misiones
                        $pregunta2 = "SELECT COUNT(1) AS total FROM cx_pla_gas WHERE conse1='$w1' AND ano='$ano' AND unidad='$w4'";
                        $cur2 = odbc_exec($conexion, $pregunta2);
                        $w5 = odbc_result($cur2,1);
                        $w5 = intval($w5);
                        // Total relaciones de gasto
                        $pregunta3 = "SELECT COUNT(1) AS total FROM cx_rel_gas WHERE consecu='$w1' AND ano='$ano' AND unidad='$w4'";
                        $cur3 = odbc_exec($conexion, $pregunta3);
                        $w6 = odbc_result($cur3,1);
                        $w6 = intval($w6);
                        $w7 = $w5-$w6;
                        $contador5 = $contador5+$w7;
                    }
                    $contador1++;
                    $contador2++;   
                }
                $datos .= $n_unidad."|".$contador2."|".$contador3."|".$contador4."|".$contador5."|#";
            }
        }
        $salida->datos = $datos;
    }
    else
    {
        $actual = date("Y-m-d H:i:s");
        $contador1 = 0;
        for ($j=0; $j<count($longitud); $j++)
        {
            $data[$j] = "";
            $valores[$j] = "";
            $valor = $longitud[$j];
            $pregunta = "SELECT conse, unidad FROM cx_pla_inv WHERE unidad='$valor' AND estado NOT IN ('','Y') AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' ORDER BY conse";
            $cur = odbc_exec($conexion, $pregunta);
            $tot_cur = odbc_num_rows($cur);
            if ($tot_cur > 0)
            {
                $k = 0;
                $conses = "";
                while($k<$row=odbc_fetch_array($cur))
                {
                    $x1 = odbc_result($cur,1);
                    $x2 = trim(odbc_result($cur,2));
                    $conses .= "'".$x1."',";
                }
                $conses = substr($conses, 0, -1);
                $unidad1 = odbc_result($cur,2);
                $pregunta0 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad1'";
                $cur0 = odbc_exec($conexion, $pregunta0);
                $n_unidad = trim(odbc_result($cur0,1));
                // Total Misiones
                $contador2 = 0;
                $contador3 = 0;                     // Finalizadas
                $contador4 = 0;                     // Ejecucion
                $contador5 = 0;                     // Diferencia Misiones - Informe Gastos
                $pregunta1 = "SELECT conse1, fechai, fechaf, unidad, interno FROM cx_pla_gas WHERE conse1 IN ($conses) AND ano='$ano' ORDER BY conse1, interno";
                $cur1 = odbc_exec($conexion, $pregunta1);
                $k = 0;
                while($k<$row=odbc_fetch_array($cur1))
                {
                    $w1 = odbc_result($cur1,1);
                    $w2 = trim(odbc_result($cur1,2));
                    $w3 = trim(odbc_result($cur1,3));
                    $w4 = odbc_result($cur1,4);
                    $w5 = odbc_result($cur1,5);
                    $fecha1 = strtotime($w2);
                    $fecha2 = strtotime($w3);
                    $fecha3 = strtotime($actual);
                    if (($fecha3 >= $fecha1) && ($fecha3 <= $fecha2))
                    {
                       $contador3++;
                       $contador5 = 0;
                    }
                    else
                    {
                        $contador4++;
                        // Total misiones
                        $pregunta2 = "SELECT COUNT(1) AS total FROM cx_pla_gas WHERE conse1='$w1' AND ano='$ano' AND unidad='$w4'";
                        $cur2 = odbc_exec($conexion, $pregunta2);
                        $w5 = odbc_result($cur2,1);
                        $w5 = intval($w5);
                        // Total relaciones de gasto
                        $pregunta3 = "SELECT COUNT(1) AS total FROM cx_rel_gas WHERE consecu='$w1' AND ano='$ano' AND unidad='$w4'";
                        $cur3 = odbc_exec($conexion, $pregunta3);
                        $w6 = odbc_result($cur3,1);
                        $w6 = intval($w6);
                        $w7 = $w5-$w6;
                        $contador5 = $contador5+$w7;
                    }
                    $contador1++;
                    $contador2++;   
                }
                $datos .= $n_unidad."|".$contador2."|".$contador3."|".$contador4."|".$contador5."|#";
            }
        }
        $salida->datos = $datos;
    }
    echo json_encode($salida);
}
// 23/11/2023 - Estadistica Ejecucion de presupuestos
// 24/11/2023 - Estadistica Seguimiento de procedimientos
?>