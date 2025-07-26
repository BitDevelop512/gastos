<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $tipo = $_POST['tipo'];
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $cuenta = $_POST['cuenta'];
    if ($cuenta == "0")
    {
        $complemento = "cuenta!=0";
    }
    else
    {
        $complemento = "cuenta='$cuenta'";
    }
    switch ($tipo)
    {
        case '1':
            if ($sup_usuario == "1")
            {
                $pregunta = "SELECT * FROM cx_com_ing WHERE $complemento";
            }
            else
            {
                $pregunta = "SELECT * FROM cx_com_ing WHERE $complemento AND unidad='$uni_usuario'";
            }
            break;
        case '2':
            if ($sup_usuario == "1")
            {
                $pregunta = "SELECT * FROM cx_com_egr WHERE $complemento";
            }
            else
            {
                $pregunta = "SELECT * FROM cx_com_egr WHERE $complemento AND unidad='$uni_usuario'";
            }
            break;
        case '3':
            $pregunta = "SELECT * FROM cv_lib_ban WHERE $complemento AND unidad='$uni_usuario'";
            break;
        default:
            $pregunta = "";
            break;
    }
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
    }
    if ($tipo == "3")
    {
        $pregunta .= " ORDER BY fecha, comprobante, tipo1";
    }
    else
    {
        $pregunta .= " ORDER BY fecha DESC";
    }
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    // Arreglos
    $n_soportes = array('INFORME DE GIRO CEDE2', 'CONSIGNACION', 'NOTA CREDITO', 'ABONO EN CUENTA','ORDEN DE PAGO SIIF');
    // Consulta por tipo
    if ($tipo == "3")
    {
        if ($total>0)
        {
            $fechas = explode("/",$fecha1);
            $periodo = $fechas[1];
            $periodo = intval($periodo);
            $ano = $fechas[0];
            $ano = intval($ano);
            if ($periodo == "1")
            {
                $periodo = "12";
                $ano = $ano-1;
            }
            else
            {
                $periodo = $periodo-1;
            }
            $valores = "";
            if ($cuenta == "1")
            {            
                $pregunta1 = "SELECT saldo FROM cx_sal_uni WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
            }
            else
            {
                $pregunta1 = "SELECT saldo FROM cx_sal_cue WHERE conse='$cuenta' AND periodo='$periodo' AND ano='$ano'";
            }
            $sql1 = odbc_exec($conexion,$pregunta1);
            $total1 = odbc_num_rows($sql1);
            if ($total1 > 0)
            {
                $saldo = trim(odbc_result($sql1,1));    
            }
            else
            {
                $saldo = "0";
            }
            $saldo = floatval($saldo);
            $saldo_ant = $saldo;
            $v_ingreso = 0;
            $v_egreso = 0;
            $t_ingreso = 0;
            $t_egreso = 0;
            $t_saldo = 0;
            $i = 0;
            $valores .= "||||||SALDO ANTERIOR|||".$saldo_ant."|||||||#";
            while ($i < $row = odbc_fetch_array($sql))
            {
                $comprobante = $row['comprobante'];
                $fecha = substr($row['fecha'],0,10);
                $unidad = $row['unidad'];
                $periodo = $row['periodo'];
                $ano = $row['ano'];
                $tipo1 = $row['tipo1'];
                $concepto = trim(utf8_encode($row['concepto1']));
                if ($tipo1 == "1")
                {
                    $n_tipo = "INGRESO";
                    $pregunta2 = "SELECT soporte, num_sopo, valor, recurso, origen, periodo, unidad1, cuenta FROM cx_com_ing WHERE ingreso='$comprobante' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano'";
                    $sql2 = odbc_exec($conexion,$pregunta2);
                    $soporte = $n_soportes[odbc_result($sql2,1)-1];
                    $numero = trim(odbc_result($sql2,2));
                    $soporte1 = $soporte." - ".$numero;
                    $soporte1 = trim($soporte1);
                    $v_valor = trim(odbc_result($sql2,3));
                    $v_valor1 = str_replace(',','',$v_valor);
                    $v_valor1 = trim($v_valor1);
                    $v_ingreso = floatval($v_valor1);
                    $recurso = odbc_result($sql2,4);
                    switch ($recurso)
                    {
                        case '1':
                            $n_recurso = "10 CSF";
                            break;
                        case '2':
                            $n_recurso = "50 SSF";
                            break;
                        case '3':
                            $n_recurso = "16 SSF";
                            break;
                        default:
                            $n_recurso = "OTROS";
                            break;
                    }
                    $origen = trim(utf8_encode(odbc_result($sql2,5)));
                    $periodo1 = odbc_result($sql2,6);
                    $unidad1 = odbc_result($sql2,7);
                    $cuenta = odbc_result($sql2,8);
                    $pregunta4 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad1'";
                    $sql4 = odbc_exec($conexion,$pregunta4);
                    $unidad2 = trim(odbc_result($sql4,1));
                    $pregunta3 = "SELECT * FROM cx_org_sub WHERE subdependencia='$unidad'";
                    $sql3 = odbc_exec($conexion,$pregunta3);
                    $c_unidad = trim(odbc_result($sql3,1));
                    $c_depen = trim(odbc_result($sql3,2));
                    $c_subdepen = trim(odbc_result($sql3,3));
                    $c_sigla = trim(odbc_result($sql3,4));
                    $c_unic = trim(odbc_result($sql3,8));
                    $c_tipo = trim(odbc_result($sql3,7));
                    $v_unidad = $c_sigla;
                    $pregunta4 = "SELECT nombre FROM cx_org_dep WHERE dependencia='$c_depen'";
                    $sql4 = odbc_exec($conexion,$pregunta4);
                    $n_depen = trim(odbc_result($sql4,1));
                    $pregunta5 = "SELECT nombre FROM cx_org_uni WHERE unidad='$c_unidad'";
                    $sql5 = odbc_exec($conexion,$pregunta5);
                    $n_unidad = trim(odbc_result($sql5,1));
                    if (($cuenta == "0") or ($cuenta == "1"))
                    {
                        $pregunta9 = "SELECT cuenta FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
                    }
                    else
                    {
                        $pregunta9 = "SELECT cuenta FROM cx_ctr_cue WHERE conse='$cuenta'";
                    }
                    $sql9 = odbc_exec($conexion,$pregunta9);
                    $n_cuenta = trim(odbc_result($sql9,1));
                    if ($n_depen == $v_unidad)
                    {
                        $v_unidad1 = "";
                    }
                    else
                    {
                        $v_unidad1 = $v_unidad;  
                    }
                    if ($c_unic == "1")
                    {
                        if ($c_unidad > 3)
                        {
                            $n_depen = "";
                            $v_unidad1 = "";
                        }
                        else
                        {
                            if (($c_depen == "4") or ($c_depen == "5"))
                            {
                                $v_unidad1 = "";
                            }
                            else
                            {
                                $n_depen = "";
                                $v_unidad1 = "";
                            }
                        }
                    }
                    $v_egreso = 0;
                    $t_ingreso = $t_ingreso+$v_ingreso;
                    $v_saldo = ($saldo+$v_ingreso)-$v_egreso;
                    $saldo = $v_saldo;
                    $valores .= $n_unidad."|".$n_depen."|".$v_unidad1."|".$v_unidad."|".$fecha."|".$comprobante."|".$n_tipo."|".$v_ingreso."|".$v_egreso."|".$v_saldo."|".$concepto."|".$soporte1."|".$n_recurso."|".$origen."|".$periodo1."|".$unidad2."|".$n_cuenta."|#";
                }
                else
                {
                    $n_tipo = "EGRESO";
                    $pregunta2 = "SELECT tp_gas, soporte, num_sopo, datos, concepto, recurso, periodo, unidad1, cuenta FROM cx_com_egr WHERE egreso='$comprobante' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano'";
                    $sql2 = odbc_exec($conexion,$pregunta2);
                    $tp_gas = odbc_result($sql2,1);
                    $soporte = odbc_result($sql2,2);
                    $num_sopo = odbc_result($sql2,3);
                    $datos = odbc_result($sql2,4);
                    $datos = trim(decrypt1($datos, $llave));
                    $concepto1 = odbc_result($sql2,5);
                    if ($concepto1 == "10")
                    {
                        $nom_concepto = "PRESUPUESTO RECOMPENSAS";
                        switch ($tp_gas)
                        {
                            case '1':
                                $nom_concepto = "GASTOS EN ACTIVIDADES";
                                break;
                            case '2':
                                $nom_concepto = "PAGO DE INFORMACIÓN";
                                break;
                            case '3':
                                $nom_concepto = "PAGO DE RECOMPENSAS";
                                break;
                            default:
                                $nom_concepto = "PRESUPUESTO RECOMPENSAS";
                                break;
                        }
                    }
                    else
                    {
                        if ($concepto1 == "9")
                        {
                            switch ($tp_gas)
                            {
                                case '1':
                                    $nom_concepto = "GASTOS EN ACTIVIDADES";
                                    break;
                                case '2':
                                    $nom_concepto = "PAGO DE INFORMACIÓN";
                                    break;
                                default:
                                    $nom_concepto = "PRESUPUESTO ADICIONAL";
                                    break;
                            }
                        }
                        else
                        {
                            if ($concepto1 == "18")
                            {
                                $nom_concepto = "DEVOLUCIONES A CEDE2";
                            }
                            else
                            {
                                if (($tp_gas == "8") or ($tp_gas == "99"))
                                {
                                    $nom_concepto = "PRESUPUESTO MENSUAL";
                                }
                                else
                                {
                                    if ($concepto1 == "6")
                                    {
                                        $nom_concepto = "PAGO DE IMPUESTOS";
                                    }
                                    else
                                    {
                                        switch ($tp_gas)
                                        {
                                            case '1':
                                                $nom_concepto = "GASTOS EN ACTIVIDADES";
                                                break;
                                            case '2':
                                                $nom_concepto = "PAGO DE INFORMACIÓN";
                                                break;
                                            case '3':
                                                $nom_concepto = "PAGO DE RECOMPENSAS";
                                                break;
                                            default:
                                                $nom_concepto = "";
                                                break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $recurso = odbc_result($sql2,6);
                    $periodo1 = odbc_result($sql2,7);
                    $unidad1 = odbc_result($sql2,8);
                    $cuenta = odbc_result($sql2,9);
                    $pregunta8 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad1'";
                    $sql8 = odbc_exec($conexion,$pregunta8);
                    $unidad2 = trim(odbc_result($sql8,1));
                    $origen = "";
                    switch ($recurso)
                    {
                        case '1':
                            $n_recurso = "10 CSF";
                            break;
                        case '2':
                            $n_recurso = "50 SSF";
                            break;
                        case '3':
                            $n_recurso = "16 SSF";
                            break;
                        default:
                            $n_recurso = "OTROS";
                            break;
                    }
                    $v_datos = explode("#",$datos);
                    $contador = count($v_datos)-1;
                    $v_ingreso = 0;
                    for ($h=0; $h<$contador; $h++)
                    {
                        $v_datos1 = explode("|",$v_datos[$h]);
                        $v_unidad = trim($v_datos1[0]);
                        $pregunta3 = "SELECT * FROM cx_org_sub WHERE sigla='$v_unidad'";
                        $sql3 = odbc_exec($conexion,$pregunta3);
                        $c_unidad = trim(odbc_result($sql3,1));
                        $c_depen = trim(odbc_result($sql3,2));
                        $c_subdepen = trim(odbc_result($sql3,3));
                        $c_sigla = trim(odbc_result($sql3,4));
                        $c_tipo = trim(odbc_result($sql3,7));
                        $c_unic = trim(odbc_result($sql3,8));
                        $pregunta4 = "SELECT nombre FROM cx_org_dep WHERE dependencia='$c_depen'";
                        $sql4 = odbc_exec($conexion,$pregunta4);
                        $n_depen = trim(odbc_result($sql4,1));
                        $pregunta5 = "SELECT nombre FROM cx_org_uni WHERE unidad='$c_unidad'";
                        $sql5 = odbc_exec($conexion,$pregunta5);
                        $n_unidad = trim(odbc_result($sql5,1));
                        if ($n_depen == $v_unidad)
                        {
                            $v_unidad1 = "";
                        }
                        else
                        {
                            $v_unidad1 = $v_unidad;
                        }
                        if ($c_unic == "1")
                        {
                            if ($c_unidad > 3)
                            {
                                $n_depen = "";
                                $v_unidad1 = "";
                            }
                            else
                            {
                                if (($c_depen == "4") or ($c_depen == "5"))
                                {
                                    $v_unidad1 = "";
                                }
                                else
                                {
                                    $n_depen = "";
                                    $v_unidad1 = "";
                                }
                            }
                        }
                        $pregunta6 = "SELECT conse FROM cx_inf_aut WHERE unidad='$c_subdepen' AND periodo='$periodo' AND ano='$ano'";
                        $sql6 = odbc_exec($conexion,$pregunta6);
                        $autoriza = trim(odbc_result($sql6,1));
                        $pregunta7 = "SELECT nombre FROM cx_ctr_sop WHERE conse='$soporte'";
                        $sql7 = odbc_exec($conexion,$pregunta7);
                        $soporte1 = trim(odbc_result($sql7,1));
                        if ($soporte == '12')
                        {
                            $aut = "";
                            $soporte1 .= " - ".$autoriza;
                        }
                        else
                        {
                            $soporte1 .= " - ".$num_sopo;
                        }
                        $soporte1 = trim(utf8_encode($soporte1));
                        if (($cuenta == "0") or ($cuenta == "1"))
                        {
                            $pregunta10 = "SELECT cuenta FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
                        }
                        else
                        {
                            $pregunta10 = "SELECT cuenta FROM cx_ctr_cue WHERE conse='$cuenta'";
                        }
                        $sql10 = odbc_exec($conexion,$pregunta10);
                        $n_cuenta = trim(odbc_result($sql10,1));
                        $v_valor = trim($v_datos1[1]);
                        $v_valor1 = str_replace(',','',$v_valor);
                        $v_valor1 = trim($v_valor1);
                        $v_egreso = floatval($v_valor1);
                        $v_saldo = ($saldo+$v_ingreso)-$v_egreso;
                        $saldo = $v_saldo;
                        $t_egreso = $t_egreso+$v_egreso;
                        $valores .= $n_unidad."|".$n_depen."|".$v_unidad1."|".$v_unidad."|".$fecha."|".$comprobante."|".$n_tipo."|".$v_ingreso."|".$v_egreso."|".$v_saldo."|".$nom_concepto."|".$soporte1."|".$n_recurso."|".$origen."|".$periodo1."|".$unidad2."|".$n_cuenta."|#";
                    }
                    $v_egreso = 0; 
                }
            }
            $t_total = ($saldo_ant+$t_ingreso)-$t_egreso;
            $valores .= "||||||TOTALES|".$t_ingreso."|".$t_egreso."|".$t_total."|||||||#";
            $salida->salida = "1";
            $salida->total = $total;
            $salida->valores = $valores;
        }
        else
        {
            $salida->salida = "0";
            $salida->total = "0";
            $salida->valores = "";
        }
    }
    else
    {
        if ($total>0)
        {
            $i = 0;
            while ($i < $row = odbc_fetch_array($sql))
            {
                $unidad = $row['unidad'];
                $concepto = $row['concepto'];
                $query1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
                $cur1 = odbc_exec($conexion, $query1);
                $n_uni = odbc_result($cur1,1);
                $tipo1 = $row['tipo'];
                if ($tipo == "1")
                {
    	            if ($tipo1 == "1")
    	            {
    	                $n_tipo = "INGRESO";
    	            }
    	            else
    	            {
    	                $n_tipo = "INGRESO DE RETENCIONES";
    	            }
    	        }
    	        else
    	        {
                	if ($tipo1 == "1")
    	            {
    	                $n_tipo = "EGRESO";
    	            }
    	            else
    	            {
    	                $n_tipo = "EGRESO DE RETENCIONES";
    	            }
    	        }
                $periodo = $row['periodo'];
                $ano = $row['ano'];
                if ($tipo == "1")
                {
                    $salida->rows[$i]['ingreso'] = $row['ingreso'];
                    $salida->rows[$i]['tipo2'] = "1";
                }
                else
                {
                    $salida->rows[$i]['egreso'] = $row['egreso'];
                    $salida->rows[$i]['tipo2'] = "2";
                }
                $cuenta = $row['cuenta'];
                switch ($cuenta)
                {
                    case '1':
                        $n_cuenta = "GASTOS";
                        break;
                    case '2':
                        $n_cuenta = "FONDO INTERNO";
                        break;
                    case '3':
                        $n_cuenta = "DTN";
                        break;
                    case '4':
                        $n_cuenta = "CUN";
                        break;
                    default:
                        $n_cuenta = "DESCONOCIDA";
                        break;
                }
                $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
                $salida->rows[$i]['usuario'] = trim($row['usuario']);
                $salida->rows[$i]['unidad'] = $n_uni;
                $salida->rows[$i]['unidad1'] = $row['unidad'];
                $salida->rows[$i]['tipo'] = $n_tipo;
                $salida->rows[$i]['tipo1'] = $tipo1;
                $salida->rows[$i]['estado'] = $row['estado'];
                $salida->rows[$i]['periodo'] = $periodo;
                $salida->rows[$i]['ano'] = $ano;
                $valor = $row['valor'];
                $valor = number_format($valor, 2);
                $salida->rows[$i]['valor'] = $valor;
                $salida->rows[$i]['cuenta'] = $n_cuenta;
                $i++;
            }
        	$salida->salida = "1";
          	$salida->total = $total;
            $salida->valores = "";
        }
        else
        {
        	$salida->salida = "0";
          	$salida->total = "0";
            $salida->valores = "";
        }
    }
    echo json_encode($salida);
}
?>