<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
    $consulta = $_POST['consulta'];
    $periodo1 = $_POST['periodo1'];
    $periodo2 = $_POST['periodo2'];
    $ano = $_POST['ano'];
    $unidad = $_POST['unidad'];
    $unidades = stringArray1($unidad);
    $longitud = explode(",",$unidades);
    $valores = "";
    $valores1 = "";
    $valores2 = "";
    $valores3 = "";
    $valores4 = "";
    $valores5 = "";
    $valores6 = "";
    // Calculo de rangos de fecha por periodos
    $mes = str_pad($periodo1,2,"0",STR_PAD_LEFT);
    switch ($periodo1)
    {
        case '1':
        case '3':
        case '5':
        case '7':
        case '8':
        case '10':
        case '12':
            $dia = "31";
            break;
        case '2':
            if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
            {
                $dia = "29";
            }
            else
            {
                $dia = "28";
            }
            break;
        case '4':
        case '6':
        case '9':
        case '11':
            $dia = "30";
            break;
        default:
            $dia = "31";
            break;
    }
    $fecha1 = $ano."/".$mes."/01";
    $fecha2 = $ano."/".$mes."/".$dia;
    // Calculo segundo periodo
    $mes1 = str_pad($periodo2,2,"0",STR_PAD_LEFT);
    switch ($periodo2)
    {
        case '1':
        case '3':
        case '5':
        case '7':
        case '8':
        case '10':
        case '12':
            $dia1 = "31";
            break;
        case '2':
            if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
            {
                $dia1 = "29";
            }
            else
            {
                $dia1 = "28";
            }
            break;
        case '4':
        case '6':
        case '9':
        case '11':
            $dia1 = "30";
            break;
        default:
            $dia1 = "31";
            break;
    }
    $fecha3 = $ano."/".$mes1."/01";
    $fecha4 = $ano."/".$mes1."/".$dia1;
    for ($j=0; $j<count($longitud); $j++)
    {
        $valor = $longitud[$j];
        $pregunta = "SELECT unidad FROM cx_org_sub WHERE subdependencia='$valor'";
        $cur = odbc_exec($conexion, $pregunta);
        $v0 = odbc_result($cur,1);
        $v0 = intval($v0);
        if ($v0 < 3)
        {
            $pregunta0 = "SELECT conse, unidad1, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_inf_aut.unidad1) AS n_unidad, (SELECT COUNT(1) FROM cx_inf_dis WHERE conse1=cx_inf_aut.conse AND ano=cx_inf_aut.ano) AS aprobadas FROM cx_inf_aut WHERE unidad1='$valor' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano'";
            $cur0 = odbc_exec($conexion, $pregunta0);
            $total0 = odbc_num_rows($cur0);
            $total0 = intval($total0);
            if ($total0 > 0)
            {
                $k = 0;
                $subtotal = 0;
                $conses = "";
                while($k<$row=odbc_fetch_array($cur0))
                {
                    $v1 = odbc_result($cur0,1);
                    $v2 = odbc_result($cur0,2);
                    $v3 = trim(odbc_result($cur0,3));
                    $v4 = odbc_result($cur0,4);
                    $v5 = intval($v4);
                    $subtotal = $subtotal+$v5;
                    $conses .= $v1.", ";
                    $k++;
                }
                $valores .= '"'.$v3.'", ';
                $conses = substr($conses, 0, -2);
                $valores1 .= $subtotal.", ";
            }
            else
            {
                $subtotal = 0;
                $pregunta5 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$valor'";
                $cur5 = odbc_exec($conexion, $pregunta5);
                $v3 = trim(odbc_result($cur5,1));
                $valores .= '"'.$v3.'", ';
                $valores1 .= $subtotal.", ";
            }
            // Se consulta plan consolidado para obtener consecutivos
            $pregunta1 = "SELECT planes FROM cx_pla_con WHERE unidad='$valor' AND periodo BETWEEN ('$periodo1') AND ('$periodo2') AND ano='$ano'";
            $cur1 = odbc_exec($conexion, $pregunta1);
            $total1 = odbc_num_rows($cur1);
            $total1 = intval($total1);
            $planes = "";
            if ($total1 > 0)
            {
                while($m<$row=odbc_fetch_array($cur1))
                {
                    $plan = odbc_result($cur1,1);
                    $planes .= decrypt1($plan, $llave).",";
                    $m++;
                }
                $planes = substr($planes, 0, -1);
            }
            else
            {
                $planes = "";
            }
            // Se consulta misiones
            $pregunta2 = "SELECT COUNT(1) AS registrados FROM cx_pla_gas WHERE conse1 IN ($planes) AND ano='$ano'";
            $cur2 = odbc_exec($conexion, $pregunta2);
            $total2 = odbc_num_rows($cur2);
            $total2 = intval($total2);
            if ($total2 > 0)
            {
                $registrados = odbc_result($cur2,1);
                $valores2 .= $registrados.", ";
            }
            else
            {
                $valores2 .= "0, ";
            }
            // Suma de valores
            $pregunta7 = "SELECT SUM(total) AS total, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cv_pla_som.unidad) AS n_unidad FROM cv_pla_som WHERE conse IN ($planes) AND ano='$ano' GROUP BY unidad";
            $cur7 = odbc_exec($conexion, $pregunta7);
            $t_cur7 = odbc_num_rows($cur7);
            if ($t_cur7 == "0")
            {
                $suma1 = "0.00";
            }
            else
            {
                $suma1 = odbc_result($cur7,1);
                if (trim($planes) == "")
                {
                    $suma1 = "0.00";
                }
            }
            //
            // Se consulta pago de informaciones
            $pregunta3 = "SELECT COUNT(1) AS informantes FROM cx_pla_pag WHERE conse IN ($planes) AND ano='$ano'";
            $cur3 = odbc_exec($conexion, $pregunta3);
            $total3 = odbc_num_rows($cur3);
            $total3 = intval($total3);
            if ($total3 > 0)
            {
                $informantes = odbc_result($cur3,1);
                $valores3 .= $informantes.", ";
            }
            else
            {
                $valores3 .= "0, ";
            }
            // Suma de valores
            $pregunta8 = "SELECT SUM(total) AS total, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cv_pla_soq.unidad) AS n_unidad FROM cv_pla_soq WHERE conse IN ($planes) AND ano='$ano' GROUP BY unidad";
            $cur8 = odbc_exec($conexion, $pregunta8);
            $t_cur8 = odbc_num_rows($cur8);
            if ($t_cur8 == "0")
            {
                $suma2 = "0.00";
            }
            else
            {
                $suma2 = odbc_result($cur8,1);
                if (trim($planes) == "")
                {
                    $suma2 = "0.00";
                }
            }
            $valores5 .= $v3."|".$suma1."|".$suma2."|";
        }
        else
        {
            // Se consultan planes de inversion
            $pregunta0 = "SELECT conse, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_pla_inv.unidad) AS n_unidad FROM cx_pla_inv WHERE unidad='$valor' AND tipo='1' AND estado NOT IN ('','Y','X') AND periodo BETWEEN ('$periodo1') AND ('$periodo2') AND ano='$ano'";
            $cur0 = odbc_exec($conexion, $pregunta0);
            $total0 = odbc_num_rows($cur0);
            $total0 = intval($total0);
            if ($total0 > 0)
            {
                $planes = "";
                while($m<$row=odbc_fetch_array($cur0))
                {
                    $v1 = odbc_result($cur0,1);
                    $v3 = trim(odbc_result($cur0,2));
                    $planes .= $v1.",";
                    $m++;
                }
                $valores .= '"'.$v3.'", ';
                $planes = substr($planes, 0, -1);
                // Se consulta misiones
                $pregunta2 = "SELECT COUNT(1) AS registrados FROM cx_pla_gas WHERE conse1 IN ($planes) AND ano='$ano'";
                $cur2 = odbc_exec($conexion, $pregunta2);
                $total2 = odbc_num_rows($cur2);
                $total2 = intval($total2);
                if ($total2 > 0)
                {
                    $registrados = odbc_result($cur2,1);
                    $valores2 .= $registrados.", ";
                }
                else
                {
                    $valores2 .= "0, ";
                }
                // Suma de valores
                $pregunta7 = "SELECT SUM(total) AS total, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cv_pla_som.unidad) AS n_unidad FROM cv_pla_som WHERE conse IN ($planes) AND ano='$ano' GROUP BY unidad";
                $cur7 = odbc_exec($conexion, $pregunta7);
                $t_cur7 = odbc_num_rows($cur7);
                if ($t_cur7 == "0")
                {
                    $suma1 = "0.00";
                }
                else
                {
                    $suma1 = odbc_result($cur7,1);
                    if (trim($planes) == "")
                    {
                        $suma1 = "0.00";
                    }
                }
                //
                // Se consulta pago de informaciones
                $pregunta3 = "SELECT COUNT(1) AS informantes FROM cx_pla_pag WHERE conse IN ($planes) AND ano='$ano'";
                $cur3 = odbc_exec($conexion, $pregunta3);
                $total3 = odbc_num_rows($cur3);
                $total3 = intval($total3);
                if ($total3 > 0)
                {
                    $informantes = odbc_result($cur3,1);
                    $valores3 .= $informantes.", ";
                }
                else
                {
                    $valores3 .= "0, ";
                }
                // Total Autorizadas
                // Se consulta misiones autorizadas
                $pregunta5 = "SELECT COUNT(1) AS registrados FROM cx_pla_gas WHERE conse1 IN ($planes) AND ano='$ano' AND autoriza='1'";
                $cur5 = odbc_exec($conexion, $pregunta5);
                $registrados = odbc_result($cur5,1);
                $registrados = intval($registrados);
                // Se consulta pago de informaciones autorizadas
                $pregunta6 = "SELECT COUNT(1) AS informantes FROM cx_pla_pag WHERE conse IN ($planes) AND ano='$ano' AND autoriza='1'";
                $cur6 = odbc_exec($conexion, $pregunta6);
                $informantes = odbc_result($cur6,1);
                $informantes = intval($informantes);
                $subtotal = $registrados+$informantes;
                $valores1 .= $subtotal.", ";
                // Suma de valores
                $pregunta8 = "SELECT SUM(total) AS total, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cv_pla_soq.unidad) AS n_unidad FROM cv_pla_soq WHERE conse IN ($planes) AND ano='$ano' GROUP BY unidad";
                $cur8 = odbc_exec($conexion, $pregunta8);
                $t_cur8 = odbc_num_rows($cur8);
                if ($t_cur8 == "0")
                {
                    $suma2 = "0.00";
                }
                else
                {
                    $suma2 = odbc_result($cur8,1);
                    if (trim($planes) == "")
                    {
                        $suma2 = "0.00";
                    }
                }
                $valores5 .= $v3."|".$suma1."|".$suma2."|";
            }
            else
            {
                $subtotal = 0;
                $pregunta5 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$valor'";
                $cur5 = odbc_exec($conexion, $pregunta5);
                $v3 = trim(odbc_result($cur5,1));
                $valores .= '"'.$v3.'", ';
                $valores1 .= $subtotal.", ";
                $valores2 .= "0, ";
                $valores3 .= "0, ";
                $valores5 .= $v3."|0|0|";
            }
            // Se consulta plan consolidado para obtener consecutivos
            $pregunta1 = "SELECT planes FROM cx_pla_con WHERE unidad='$valor' AND periodo BETWEEN ('$periodo1') AND ('$periodo2') AND ano='$ano'";
            $cur1 = odbc_exec($conexion, $pregunta1);
            $total1 = odbc_num_rows($cur1);
            $total1 = intval($total1);
            $planes = "";
            if ($total1 > 0)
            {
                while($m<$row=odbc_fetch_array($cur1))
                {
                    $plan = odbc_result($cur1,1);
                    $planes .= decrypt1($plan, $llave).",";
                    $m++;
                }
                $planes = substr($planes, 0, -1);
            }
            else
            {
                $planes = "";
            }
        }
        // Se consultan solicitud de recursos
        $pregunta4 = "SELECT COUNT(1) AS solicitudes FROM cx_pla_inv WHERE unidad='$valor' AND tipo='2' AND estado IN ('G', 'W') AND periodo BETWEEN ('$periodo1') AND ('$periodo2') AND ano='$ano'";
        $cur4 = odbc_exec($conexion, $pregunta4);
        $total4 = odbc_num_rows($cur4);
        $total4 = intval($total4);
        if ($total4 > 0)
        {
            $solicitudes = odbc_result($cur4,1);
            $valores4 .= $solicitudes.", ";
        }
        else
        {
            $valores4 .= "0, ";
        }
        // Suma de valores
        $pregunta9 = "SELECT conse FROM cx_pla_inv WHERE unidad='$valor' AND tipo='2' AND estado IN ('G', 'W') AND periodo BETWEEN ('$periodo1') AND ('$periodo2') AND ano='$ano'";
        $cur9 = odbc_exec($conexion, $pregunta9);
        $n = 0;
        $solicitudes = "";
        while($n<$row=odbc_fetch_array($cur9))
        {
            $v1 = odbc_result($cur9,1);
            $solicitudes .= $v1.",";
            $n++;
        }
        $solicitudes = substr($solicitudes, 0, -1);
        $pregunta10 = "SELECT SUM(total) AS total, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cv_pla_som.unidad) AS n_unidad FROM cv_pla_som WHERE conse IN ($solicitudes) AND ano='$ano' GROUP BY unidad";
        $cur10 = odbc_exec($conexion, $pregunta10);
        $t_cur10 = odbc_num_rows($cur10);
        if ($t_cur10 > 0)
        {
            $suma3 = odbc_result($cur10,1);
        }
        else
        {
            $suma3 = "0.00";
        }
        $pregunta11 = "SELECT SUM(total) AS total, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cv_pla_soq.unidad) AS n_unidad FROM cv_pla_soq WHERE conse IN ($solicitudes) AND ano='$ano' GROUP BY unidad";
        $cur11 = odbc_exec($conexion, $pregunt11);
        $t_cur11 = odbc_num_rows($cur11);
        if ($t_cur11 > 0)
        {
            $suma4 = odbc_result($cur11,1);
        }
        else
        {
            $suma4 = "0.00";
        }
        $suma3 = floatval($suma3);
        $suma4 = floatval($suma4);
        $suma5 = $suma3+$suma4;
        $valores5 .= $suma5."|".$suma3."|".$suma4."|";
        // Se consultan recompensas
        $pregunta12 = "SELECT COUNT(1) AS recompensas FROM cx_reg_rec WHERE unidad='$valor' AND estado NOT IN ('','Y') AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha4',102)+1) AND ano='$ano'";
        $cur12 = odbc_exec($conexion, $pregunta12);
        $total12 = odbc_num_rows($cur12);
        $total12 = intval($total12);
        if ($total12 > 0)
        {
            $recompensas = odbc_result($cur12,1);
            $valores6 .= $recompensas.", ";
        }
        else
        {
            $valores6 .= "0, ";
        }
        // Suma de valores
        // Pago de Recompensas
        $pregunta13 = "SELECT SUM(valor1) AS total FROM cx_reg_rec WHERE unidad='$valor' AND estado NOT IN ('','Y') AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha4',102)+1) AND ano='$ano' AND tipo1='0' GROUP BY unidad";
        $cur13 = odbc_exec($conexion, $pregunta13);
        $t_cur13 = odbc_num_rows($cur13);
        if ($t_cur13 == "0")
        {
            $suma6 = "0.00";
        }
        else
        {
            $suma6 = odbc_result($cur13,1);
        }
        // Pago de Informaciones
        $pregunta14 = "SELECT SUM(valor1) AS total FROM cx_reg_rec WHERE unidad='$valor' AND estado NOT IN ('','Y') AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha4',102)+1) AND ano='$ano' AND tipo1='1' GROUP BY unidad";
        $cur14 = odbc_exec($conexion, $pregunta14);
        $t_cur14 = odbc_num_rows($cur14);
        if ($t_cur14 == "0")
        {
            $suma7 = "0.00";
        }
        else
        {
            $suma7 = odbc_result($cur14,1);
        }
        $valores5 .= $suma6."|".$suma7."|#";
    }
    $valores = substr($valores, 0, -2);
    $valores1 = substr($valores1, 0, -2);
    $valores2 = substr($valores2, 0, -2);
    $valores3 = substr($valores3, 0, -2);
    $valores4 = substr($valores4, 0, -2);
    $valores6 = substr($valores6, 0, -2);
    $salida->datos = $valores;
    $salida->datos1 = $valores1;
    $salida->datos2 = $valores2;
    $salida->datos3 = $valores3;
    $salida->datos4 = $valores4;
    $salida->datos5 = $valores5;
    $salida->datos6 = $valores6;
    echo json_encode($salida);
}
?>