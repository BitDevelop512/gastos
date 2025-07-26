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
    $pregunta = "SELECT * FROM cx_reg_rec WHERE unidad='$uni_usuario' AND ((usuario='$usu_usuario') OR (usuario='SPR_DIADI'))";
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
    }
    $pregunta .= " AND tipo='0' ORDER BY fecha DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $unidad1 = $row['uni_man'];
            $unidad2 = $row['uni_efe'];
            $ordop = $row['ordop'];
            $fragmenta = $row['fragmenta'];
            $query1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad1'";
            $cur1 = odbc_exec($conexion, $query1);
            $n_uni1 = odbc_result($cur1,1);
            if ($unidad2 == "999")
            {
                $n_uni2 = "OTRA";
            }
            else
            {
                $query2 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad2'";
                $cur2 = odbc_exec($conexion, $query2);
                $n_uni2 = odbc_result($cur2,1);
            }
            $fecha1 = trim($row["fec_res"]);
            $fecha1 = str_replace("/", "-", $fecha1);
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
            $salida->rows[$i]['fecha1'] = $fecha1;
            $salida->rows[$i]['usuario'] = trim($row['usuario']);
            $salida->rows[$i]['unidad1'] = $n_uni1;
            $salida->rows[$i]['unidad2'] = $n_uni2;
            $salida->rows[$i]['ordop'] = utf8_encode($ordop);
            $salida->rows[$i]['fragmenta'] = utf8_encode($fragmenta);
            $salida->rows[$i]['ano'] = $row['ano'];
            $estado = trim($row['estado']);
            $salida->rows[$i]['estado'] = $estado;
            switch ($estado)
            {
                case '':
                    $n_estado = "EN TRAMITE U.T.";
                    break;
                case 'Y':
                    $n_estado = "RECHAZADA";
                    break;
                case 'A':
                    $n_estado = "REVISION U.O.M";
                    break;
                case 'B':
                    $n_estado = "EN EVALUACION CRR";
                    break;
                case 'C':
                    $n_estado = "EVALUADA CRR";
                    break;
                case 'D':
                    $n_estado = "EN EVALUACION CCE";
                    break;
                case 'E':
                    $n_estado = "EVALUADA CCE";
                    break;
                case 'F':
                    $n_estado = "PENDIENTE ASIGNACION RECURSO";
                    break;
                case 'G':
                    $n_estado = "PENDIENTE PAGO";
                    break;
                case 'H':
                    $n_estado = "PAGADA";
                    break;
                case 'I':
                    $n_estado = "EN ACREEDORES VARIOS CEDE2";
                    break;
                case 'J':
                    $n_estado = "EN ACREEDORES VARIOS DTN";
                    break;
                default:
                    $n_estado = "";
                    break;
            }
            $salida->rows[$i]['estado1'] = $n_estado;
            $salida->rows[$i]['tipo1'] = $row['tipo1'];
            $i++;
        }
        $salida->salida = "1";
        $salida->total = $total;
    }
    else
    {
        $salida->salida = "0";
        $salida->total = "0";
    }
    echo json_encode($salida);
}
?>