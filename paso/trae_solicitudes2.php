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
    // Se consulta todas los registros de recompensas
    $valores = "";
    $pregunta = "SELECT * FROM cx_reg_rec WHERE 1=1";
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
    }
    $pregunta .= " ORDER BY fecha DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $x = 1;
    while ($x < $row = odbc_fetch_array($sql))
    {
        $conse = $row['conse'];
        $fecha = substr($row['fecha'],0,10);
        $unidad = $row['unidad'];
        $pregunta1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
        $sql1 = odbc_exec($conexion, $pregunta1);
        $n_unidad = trim(odbc_result($sql1,1));
        $ciudad = trim(utf8_encode($row['ciudad']));
        // Unidad Maneja Fuente
        $uni_man = $row['uni_man'];
        $pregunta2 = "SELECT sigla, n_dependencia, n_unidad FROM cv_unidades WHERE subdependencia='$uni_man'";
        $sql2 = odbc_exec($conexion, $pregunta2);
        $n_sigla1 = trim(odbc_result($sql2,1));
        $n_dependencia1 = trim(odbc_result($sql2,2));
        $n_unidad1 = trim(odbc_result($sql2,3));
        $cedulas = trim($row['cedulas']);
        $nombres = trim($row['nombres']);
        $num_cedulas = explode("|",$cedulas);
        $num_nombres = explode("|",$nombres);
        $identidades = "";
        for ($i=0;$i<count($num_cedulas)-1;++$i)
        {
            $v1 = trim($num_cedulas[$i]);
            $v2 = trim(utf8_encode($num_nombres[$i]));
            $identidades .= $v1." - ".$v2." ¬ ";
        }
        // Unidad Efectuo Operacion
        $uni_efe = $row['uni_efe'];
        $pregunta3 = "SELECT sigla, n_dependencia, n_unidad FROM cv_unidades WHERE subdependencia='$uni_efe'";
        $sql3 = odbc_exec($conexion, $pregunta3);
        $n_sigla2 = trim(odbc_result($sql3,1));
        $n_dependencia2 = trim(odbc_result($sql3,2));
        $n_unidad2 = trim(odbc_result($sql3,3));
        // Amenaza
        $factor = $row['factor'];
        $pregunta4 = "SELECT nombre FROM cx_ctr_fac WHERE codigo='$factor'";
        $sql4 = odbc_exec($conexion, $pregunta4);
        $n_amenaza = trim(utf8_encode(odbc_result($sql4,1)));
        // Estructura
        $estructura = $row['estructura'];
        $pregunta5 = "SELECT nombre FROM cx_ctr_est WHERE codigo='$estructura'";
        $sql5 = odbc_exec($conexion, $pregunta5);
        $n_estructura = trim(utf8_encode(odbc_result($sql5,1)));
        // Calculo Dias Transcurridos
        $fec_val = $row['fec_res'];
        $ano = $row['ano'];
        $pregunta6 = "SELECT conse, fec_rec, observaciones FROM cx_reg_rev WHERE usuario='SPR_DIADI' AND consecu='$conse' AND ano='$ano' AND resultado='A'";
        $sql6 = odbc_exec($conexion,$pregunta6);
        $total6 = odbc_num_rows($sql6);
        if ($total6 > 0)
        {
            $num_rew = odbc_result($sql6,1);
            $fec_rew = odbc_result($sql6,2);
            $obs_rew = trim(utf8_encode(odbc_result($sql6,3)));
        }
        else
        {
            $num_rew = "";
            $fec_rew = date('Y-m-d');
            $obs_rew = "";
        }
        $pregunta7 = "SELECT observaciones FROM cx_reg_rev WHERE usuario!='SPR_DIADI' AND consecu='$conse' AND ano='$ano' AND resultado='A'";
        $sql7 = odbc_exec($conexion,$pregunta7);
        $total7 = odbc_num_rows($sql7);
        if ($total7 > 0)
        {
            $obs_rev = trim(utf8_encode(odbc_result($sql7,1)));
        }
        else
        {
            $obs_rev = "";
        }
        $num_rev = "";
        $fec_rev = "";
        $obs_rev = $obs_rev." ".$obs_rew;
        $dias = getDiasHabiles($fec_val, $fec_rew);
        $dias1 = count($dias);
        // Fin Calculo
        $estado = trim($row['estado']);
        switch ($estado)
        {
            case '':
                $n_estado = "EN TRAMITE U.T.";
                break;
            case 'Y':
                $n_estado = "RECHAZADA";
                break;
            case 'A':
                $n_estado = "REVISIÓN BRIGADA";
                break;
            case 'B':
                $n_estado = "REVISIÓN COMANDO";
                break;
            case 'C':
                $n_estado = "REVISIÓN DIVISIÓN";
                break;
            case 'D':
                $n_estado = "EVALUACIÓN CRR";
                break;
            case 'E':
                $n_estado = "REVISIÓN CEDE2";
                break;
            case 'F':
                $n_estado = "EVALUADA CCR";
                break;
            case 'G':
                $n_estado = "PENDIENTE GIRO";
                break;
            case 'H':
                $n_estado = "GIRADA";
                break;
            case 'I':
                $n_estado = "PAGADA";
                break;
            case 'X':
                $n_estado = "ANULADO";
                break;
            default:
                $n_estado = "";
            break;
        }
        $fec_res = $row['fec_res'];
        $hr = trim($row['hr']);
        $fec_hr = $row['fec_hr'];
        $dias = $dias1;
        $oficio = trim($row['oficio']);
        $fec_ofi = $row['fec_ofi'];
        $prorroga = trim($row['prorroga']);
        $fec_pro = $row['fec_pro'];
        // Otros
        $sintesis = trim(utf8_encode($row['sintesis']));
        $valor = trim($row['valor']);
        $valor1 = $row['valor1'];
        $fec_sum = $row['fec_sum'];
        $n_ordop = trim($row['n_ordop']);
        $ordop = trim(utf8_encode($row['ordop']));
        $fec_ord = $row['fec_ord'];
        $fragmenta = trim(utf8_encode($row['fragmenta']));
        $fec_fra = $row['fec_fra'];
        $sitio = trim(utf8_encode($row['sitio']));
        $municipio = $row['municipio'];
        $pregunta8 = "SELECT nombre FROM cx_ctr_ciu WHERE codigo='$municipio'";
        $sql8 = odbc_exec($conexion, $pregunta8);
        $n_municipio = trim(utf8_encode(odbc_result($sql8,1)));
        $departamento = $row['departamento'];
         $pregunta9 = "SELECT nombre FROM cx_ctr_dep WHERE codigo='$departamento'";
        $sql9 = odbc_exec($conexion, $pregunta9);
        $n_departamento = trim(utf8_encode(odbc_result($sql9,1)));
        $resultado = trim(utf8_encode($row['resultado']));
        $resultado = str_replace("#", "N.", $resultado);
        $observaciones = trim(utf8_encode($row['observaciones']));
        $tip_res = "";
        $lista = trim($row['lista']);
        $n_lista = explode("|",$lista);
        $apoyo = $n_lista[6];
        $fec_apo = $n_lista[7];
        $num_uom = $n_lista[11];
        $fec_uom = $n_lista[12];
        // Acta Comite Regional
        $pregunta10 = "SELECT conse, fecha, totala, acta FROM cx_act_reg WHERE registro='$conse' AND ano1='$ano'";
        $sql10 = odbc_exec($conexion, $pregunta10);
        $total10 = odbc_num_rows($sql10);
        if ($total10 > 0)
        {
            $act_reg = odbc_result($sql10,1);
            $fec_reg = substr(odbc_result($sql10,2),0,10);
            $val_reg = trim(odbc_result($sql10,3));
            $val_reg = str_replace(',','',$val_reg);
            $val_reg = substr($val_reg,0,-3);
            $val_reg = floatval($val_reg);
            $man_reg = trim(odbc_result($sql10,4));
            if ($man_reg == "")
            {
            }
            else
            {
                $act_reg = $man_reg;
            }
        }
        else
        {
            $act_reg = "";
            $fec_reg = "";
            $val_reg = "";
        }
        // Acta Comite Central
        $pregunta11 = "SELECT conse, fecha, totala, acta FROM cx_act_cen WHERE registro='$conse' AND ano1='$ano'";
        $sql11 = odbc_exec($conexion, $pregunta11);
        $total11 = odbc_num_rows($sql11);
        if ($total11 > 0)
        {
            $act_cen = odbc_result($sql11,1);
            $fec_cen = substr(odbc_result($sql11,2),0,10);
            $val_cen = trim(odbc_result($sql11,3));
            $val_cen = str_replace(',','',$val_cen);
            $val_cen = substr($val_cen,0,-3);
            $val_cen = floatval($val_cen);
            $man_cen = trim(odbc_result($sql11,4));
            if ($man_cen == "")
            {
            }
            else
            {
                $act_cen = $man_cen;
            }
        }
        else
        {
            $act_cen = "";
            $fec_cen = "";
            $val_cen = "";
        }
        // Informe de Giro
        $pregunta12 = "SELECT inf_giro FROM cx_val_aut2 WHERE solicitud='$conse' AND ano1='$ano'";
        $sql12 = odbc_exec($conexion, $pregunta12);
        $total12 = odbc_num_rows($sql12);
        if ($total12 > 0)
        {
            $inf_giro = odbc_result($sql12,1);
        }
        else
        {
            $inf_giro = "0";
        }
        // Comprobante de Egreso
        if ($estado == "I")
        {
            $pregunta13 = "SELECT egreso, fecha FROM cx_com_egr WHERE concepto='10' AND giro='$inf_giro'";
            $sql13 = odbc_exec($conexion, $pregunta13);
            $total13 = odbc_num_rows($sql13);
            if ($total13 > 0)
            {
                $com_egr = odbc_result($sql13,1);
                $fec_egr = substr(odbc_result($sql13,2),0,10);
            }
            else
            {
                $com_egr = "";
                $fec_egr = "";
            }
        }
        else
        {
            $com_egr = "";
            $fec_egr = "";
        }
        // Acta de Pago Recompensa
        $pregunta14 = "SELECT conse, fecha FROM cx_act_rec WHERE registro='$conse' AND ano1='$ano'";
        $sql14 = odbc_exec($conexion, $pregunta14);
        $total14 = odbc_num_rows($sql14);
        if ($total14 > 0)
        {
            $act_pag = odbc_result($sql14,1);
            $fec_pag = substr(odbc_result($sql14,2),0,10);
        }
        else
        {
            $act_pag = "";
            $fec_pag = "";
        }
        $obs_pag = "";
        $ofi_rex = "";
        $num_rex = "";
        $fec_rex = "";
        $fed_rex = "";
        $seg_rex = "";
        $num_pro = "";
        $num_reg = "";
        $fec_reg = "";
        $valores .= $conse."|".$n_sigla1."|".$hr."|".$fec_hr."|".$identidades."|".$n_unidad2."|".$n_dependencia2."|".$n_sigla2."|".$fec_res."|".$ordop."|".$fragmenta."|".$sitio."|".$n_municipio."|".$n_departamento."|".$n_amenaza."|".$n_estructura."|".$tip_res."|".$resultado."|".$oficio."|".$fec_ofi."|".$valor1."|".$apoyo."|".$fec_apo."|".$act_reg."|".$fec_reg."|".$val_reg."|".$num_uom."|".$fec_uom."|".$fec_rew."|".$ofi_rex."|".$num_rex."|".$fec_rex."|".$fed_rex."|".$obs_rev."|".$num_rev."|".$fec_rev."|".$num_pro."|".$prorroga."|".$fec_pro."|".$num_reg."|".$fec_reg."|".$fec_reg."|".$act_cen."|".$fec_cen."|".$val_cen."|".$fec_egr."|".$act_pag."|".$fec_pag."|".$obs_pag."|".$dias1."|".$n_estado."|R|#";
    }
    // Registro manual de recompensas
    $pregunta = "SELECT * FROM cx_rec_man WHERE 1=1";
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
    }
    $pregunta .= " ORDER BY fecha DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $x = 1;
    while ($x < $row = odbc_fetch_array($sql))
    {
        $conse = $row['conse'];
        $fecha = substr($row['fecha'],0,10);
        $unidad = $row['unidad'];
        $pregunta1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
        $sql1 = odbc_exec($conexion, $pregunta1);
        $n_unidad = trim(odbc_result($sql1,1));
        $n_sigla1 = $n_unidad;
        $ano = $row['ano'];
        $valor1 = "";

        $resultado = trim(utf8_encode($row['resumen']));
        $hr = "";
        $fec_hr = "";
        $identidades = "";
        $n_unidad2 = "";
        $n_dependencia2 = "";
        $n_sigla2 = "";
        $fec_res = "";
        $pregunta2 = "SELECT ordop, inf_giro FROM cx_val_aut2 WHERE registro='$conse' AND ano='$ano'";
        $sql2 = odbc_exec($conexion, $pregunta2);
        $ordop = trim(utf8_encode(odbc_result($sql2,1)));
        $inf_giro = odbc_result($sql2,2);
        $fragmenta = "";
        $sitio = "";
        $n_municipio = "";
        $n_departamento = "";
        $n_amenaza = "";
        $n_estructura = "";
        $tip_res = "";
        $oficio = "";
        $fec_fra = "";
        $fec_ofi = "";
        $apoyo = "";
        $fec_apo = "";
        $act_reg = "";
        $fec_reg = "";
        $val_reg = "";
        $num_rev = "";
        $fec_rev = "";
        $fec_reg = "";
        $ofi_rex = "";
        $num_rex = "";
        $fec_rex = "";
        $fed_rex = "";
        $obs_rev = "";
        $num_rev = "";
        $fec_rev = "";
        $num_pro = "";
        $prorroga = "";
        $fec_pro = "";
        $num_reg = "";
        $fec_reg = "";
        $act_cen = $row['num_acta'];
        $fec_cen = substr($row['fec_acta'],0,10);
        $val_cen = $row['valor'];
        // Comprobante de Egreso
        $pregunta13 = "SELECT egreso, fecha FROM cx_com_egr WHERE concepto='10' AND giro='$inf_giro'";
        $sql13 = odbc_exec($conexion, $pregunta13);
        $total13 = odbc_num_rows($sql13);
        if ($total13 > 0)
        {
            $com_egr = odbc_result($sql13,1);
            $fec_egr = substr(odbc_result($sql13,2),0,10);
        }
        else
        {
            $com_egr = "";
            $fec_egr = "";
        }
        // Acta de Pago Recompensa
        $pregunta14 = "SELECT conse, fecha FROM cx_act_rec WHERE registro='$conse' AND ano1='$ano'";
        $sql14 = odbc_exec($conexion, $pregunta14);
        $total14 = odbc_num_rows($sql14);
        if ($total14 > 0)
        {
            $act_pag = odbc_result($sql14,1);
            $fec_pag = substr(odbc_result($sql14,2),0,10);
        }
        else
        {
            $act_pag = "";
            $fec_pag = "";
        }
        $obs_pag = "";
        $valores .= $conse."|".$n_sigla1."|".$hr."|".$fec_hr."|".$identidades."|".$n_unidad2."|".$n_dependencia2."|".$n_sigla2."|".$fec_res."|".$ordop."|".$fragmenta."|".$sitio."|".$n_municipio."|".$n_departamento."|".$n_amenaza."|".$n_estructura."|".$tip_res."|".$resultado."|".$oficio."|".$fec_ofi."|".$valor1."|".$apoyo."|".$fec_apo."|".$act_reg."|".$fec_reg."|".$val_reg."|".$num_rev."|".$fec_rev."|".$fec_reg."|".$ofi_rex."|".$num_rex."|".$fec_rex."|".$fed_rex."|".$obs_rev."|".$num_rev."|".$fec_rev."|".$num_pro."|".$prorroga."|".$fec_pro."|".$num_reg."|".$fec_reg."|".$fec_reg."|".$act_cen."|".$fec_cen."|".$val_cen."|".$fec_egr."|".$act_pag."|".$fec_pag."|".$obs_pag."|0|".$n_estado."|M|#";
    }
    $salida = new stdClass();
    $salida->valores = $valores;
    echo json_encode($salida);
}
?>