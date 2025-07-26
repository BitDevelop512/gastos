<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    // Se consulta todas las solicitudes
    $valores = "";
    $pregunta = "SELECT * FROM cv_sol_aut WHERE 1=1";
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
    }
    $pregunta .= " ORDER BY fecha DESC";
    $sql3 = odbc_exec($conexion,$pregunta);
    $total3 = odbc_num_rows($sql3);
    $x = 1;
    while ($x < $row = odbc_fetch_array($sql3))
    {
        $conse = $row['conse'];
        $ano = $row['ano'];
        $fecha = substr($row['fecha'],0,10);
        $unidad = $row['unidad'];
        $n_unidad = trim($row['n_unidad']);
        $n_dependencia = trim($row['n_dependencia']);
        $n_subdependencia = trim($row['n_subdependencia']);
        $concepto = trim(utf8_encode($row['concepto']));
        $tipo1 = $row['tipo1'];
        $estado = trim($row['estado']);
        switch ($estado)
        {
            case 'L':
                $n_estado = "PENDIENTE";
                break;
            case 'W':
            case 'G':
                $n_estado = "GIRADO";
                break;
            case 'Y':
                $n_estado = "RECHAZADO";
                break;
            default:
                $n_estado = "";
                break;
        }
        $recursos = $row['recursos'];
        if ($recursos == "0")
        {
            $recursos1 = "SIN RECURSOS";
        }
        else
        {
            $recursos1 = "CON RECURSOS";
        }     
        // Estado
        if ($estado == "Y")
        {
            $query8 = "SELECT motivo, usuario, fecha FROM cx_pla_rev WHERE conse='$conse' AND ano='$ano' AND usuario='SPG_DIADI'";
            $sql8 = odbc_exec($conexion, $query8);
            $total8 = odbc_num_rows($sql8);
            $motivo = trim(utf8_encode(odbc_result($sql8,1)));
            $usu_anu = trim(odbc_result($sql8,2));
            $fec_anu = trim(odbc_result($sql8,3));
            $fec_anu = substr($fec_anu,0,10);
            $observacion = $motivo."|".$usu_anu."|".$fec_anu."|".$recursos1;
        }
        else
        {
            $observacion = "|||".$recursos1;
        }
        // Se consulta OMS
        $query9 = "SELECT oms, factor, estructura FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano'";
        $sql9 = odbc_exec($conexion, $query9);
        $oms = odbc_result($sql9,1);
        $factor = odbc_result($sql9,2);
        $estructura = odbc_result($sql9,3);
        $query10 = "SELECT nombre FROM cx_ctr_oms WHERE codigo='$oms'";
        $sql10 = odbc_exec($conexion, $query10);
        $n_oms = trim(utf8_encode(odbc_result($sql10,1)));
        // Se consulta autorizacion cede2
        $query11 = "SELECT autoriza, inf_giro FROM cx_val_aut1 WHERE solicitud='$conse' AND ano='$ano'";
        $sql11 = odbc_exec($conexion, $query11);
        $n_autoriza = odbc_result($sql11,1);
        $n_giro = odbc_result($sql11,2);
        // Se consulta el crp del informe de giro
        $query12 = "SELECT crp FROM cx_inf_gir WHERE conse='$n_giro'";
        $sql12 = odbc_exec($conexion, $query12);
        $n_crp = odbc_result($sql12,1);
        // Se consulta el numero del crp
        $query13 = "SELECT numero FROM cx_crp WHERE conse='$n_crp'";
        $sql13 = odbc_exec($conexion, $query13);
        $n_numero = odbc_result($sql13,1);
        // Se consulta fecha de autorizacion
        $query14 = "SELECT fecha FROM cx_sol_aut WHERE conse='$n_autoriza' AND ano='$ano'";
        $sql14 = odbc_exec($conexion, $query14);
        $f_autoriza = substr(odbc_result($sql14,1),0,10);
        // Se consulta factor
        $query15 = "SELECT nombre FROM cx_ctr_fac WHERE codigo='$factor'";
        $sql15 = odbc_exec($conexion, $query15);
        // Se consulta estructura
        $query16 = "SELECT nombre FROM cx_ctr_est WHERE codigo='$estructura'";
        $sql16 = odbc_exec($conexion, $query16);
        // Datos complemento
        $otros = $n_oms."|".$n_autoriza."|".$f_autoriza."|".$n_numero."|#";
        if ($tipo1 == "1")
        {
            $query7 = "SELECT mision, valor, valor_a FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano' ORDER BY interno";
            $sql7 = odbc_exec($conexion, $query7);
            $y = 1;
            $fuente = "";
            $n_factor = trim(utf8_encode(odbc_result($sql15,1)));
            $fecha1 = "";
            $n_difusion = "";
            $n_resultado = "";
            $operacion = "";
            $n_estructura = trim(utf8_encode(odbc_result($sql16,1)));
            $radiograma = "N/A";
            $fec_radio = "N/A";
            while ($y < $row = odbc_fetch_array($sql7))
            {            
                $ordop = trim(utf8_encode(odbc_result($sql7,1)));
                $valor = $row['valor'];
                $v_valor = str_replace(',','',$valor);
                $v_valor = trim($v_valor);
                $v_valor = floatval($v_valor);
                $valor1 = $row['valor_a'];
                $v_valor1 = str_replace(',','',$valor1);
                $v_valor1 = trim($v_valor1);
                $v_valor1 = floatval($v_valor1);
                if (($estado == "Y") and ($total8 == "0"))
                {
                }
                else
                {
                    $valores .= $fecha."|".$conse."|".$n_unidad."|".$n_dependencia."|".$n_subdependencia."|".$concepto."|".$ordop."|".$fuente."|".$n_factor."|".$fecha1."|".$n_difusion."|".$n_resultado."|".$operacion."|".$v_valor."|".$v_valor1."|".$n_estado."|".$n_estructura."|".$radiograma."|".$fec_radio."|".$observacion."|".$otros;
                }
            }
        }
        else
        {
            $query4 = "SELECT ced_fuen, fac_fuen, fec_inf, dif_fuen, res_fuen, val_fuen, val_fuen_a, est_fuen, rad_fuen, fec_rad FROM cx_pla_pag WHERE conse='$conse' AND ano='$ano' ORDER BY conse1";
            $sql4 = odbc_exec($conexion, $query4);
            $z = 1;
            $ordop = "";
            $operacion = "";
            while ($z < $row = odbc_fetch_array($sql4))
            {
                $fuente = trim($row['ced_fuen']);
                if (strpos($fuente, "K") !== false)
                {
                }
                else
                {
                    $fuente = "XXXX".substr($fuente,-4);
                }
                $factor = $row['fac_fuen'];
                $query5 = "SELECT nombre FROM cx_ctr_fac WHERE codigo='$factor'";
                $sql5 = odbc_exec($conexion, $query5);
                $n_factor = trim(utf8_encode(odbc_result($sql5,1)));
                $fecha1 = $row['fec_inf'];
                $difusion = $row['dif_fuen'];
                $query6 = "SELECT nombre FROM cx_ctr_dif WHERE codigo='$difusion'";
                $sql6 = odbc_exec($conexion, $query6);
                $n_difusion = trim(utf8_encode(odbc_result($sql6,1)));
                $resultado = $row['res_fuen'];
                if ($resultado == "1")
                {
                    $n_resultado = "SI";
                }
                else
                {
                    $n_resultado = "NO";
                }
                $valor = $row['val_fuen'];
                $v_valor = str_replace(',','',$valor);
                $v_valor = trim($v_valor);
                $v_valor = floatval($v_valor);
                $valor1 = $row['val_fuen_a'];
                $v_valor1 = str_replace(',','',$valor1);
                $v_valor1 = trim($v_valor1);
                $v_valor1 = floatval($v_valor1);
                $estructura = $row['est_fuen'];
                $query8 = "SELECT nombre FROM cx_ctr_est WHERE codigo='$estructura'";
                $sql8 = odbc_exec($conexion, $query8);
                $n_estructura = trim(utf8_encode(odbc_result($sql8,1)));
                $radiograma = $row['rad_fuen'];
                $fec_radio = $row['fec_rad'];
                if (($estado == "Y") and ($total8 == "0"))
                {
                }
                else
                {
                    $valores .= $fecha."|".$conse."|".$n_unidad."|".$n_dependencia."|".$n_subdependencia."|".$concepto."|".$ordop."|".$fuente."|".$n_factor."|".$fecha1."|".$n_difusion."|".$n_resultado."|".$operacion."|".$v_valor."|".$v_valor1."|".$n_estado."|".$n_estructura."|".$radiograma."|".$fec_radio."|".$observacion."|".$otros;
                }
            }
        }
    }
    $salida = new stdClass();
    $salida->valores = $valores;
    echo json_encode($salida);
}
// 30/08/2024 - Ajuste consulta de fecha Acta CEDE por año
?>