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
    if ($tipo == "1")
    {
        $pregunta = "SELECT * FROM cx_pqr_reg WHERE 1=1";
        if ($sup_usuario == "1")
        {
        }
        else
        {
            if (($nun_usuario == "2") or ($nun_usuario == "3"))
            {
                $pregunta .= " AND dependencia='$dun_usuario'";
            }
            else
            {
                $pregunta .= " AND centra='$nun_usuario'";
            }
        }
        if (!empty($_POST['fecha1']))
        {
            $pregunta .= " AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
        }
        $pregunta .= " ORDER BY fecha DESC";
        $sql = odbc_exec($conexion,$pregunta);
        $total = odbc_num_rows($sql);
        $salida = new stdClass();
        if ($total>0)
        {
            $valores = "";
            $i = 0;
            while ($i < $row = odbc_fetch_array($sql))
            {
                $tipo = $row['tipo'];
                switch ($tipo)
                {
                    case '1':
                        $n_tipo = "SOLICITUD";
                        break;
                    case '2':
                        $n_tipo = "SOPORTE";
                        break;
                    case '3':
                        $n_tipo = "OTRO";
                        break;
                    default:
                        $n_tipo = "";
                        break;
                }
                $modulo = trim($row['modulo']);
                switch ($modulo)
                {
                    case 'A':
                        $n_modulo = "PLANEACIÓN";
                        break;
                    case 'B':
                        $n_modulo = "EJECUCIÓN";
                        break;
                    case 'C':
                        $n_modulo = "SOPORTES DE EJECUCIÓN";
                        break;
                    case 'D':
                        $n_modulo = "LIBROS AUXILIARES";
                        break;
                    case 'E':
                        $n_modulo = "RECOMPENSAS";
                        break;
                    case 'F':
                        $n_modulo = "PRESUPUESTO";
                        break;
                    case 'G':
                        $n_modulo = "ADMINISTRADOR";
                        break;
                    case 'H':
                        $n_modulo = "BIENES";
                        break;
                    case 'I':
                        $n_modulo = "ESTADÍSTICAS";
                        break;
                    case 'J':
                        $n_modulo = "TRANSPORTES";
                        break;
                    default:
                        $n_modulo = "";
                        break;
                }
                $estado = trim($row['estado']);
                switch ($estado)
                {
                    case '':
                        $n_estado = "ENVIADA";
                        break;
                    case 'A':
                        $n_estado = "EN TRAMITE";
                        break;
                    case 'B':
                        $n_estado = "CERRADA";
                        break;
                    case 'C':
                        $n_estado = "PENDIENTE CONFIRMACI&Oacute;N";
                        break;
                    case 'D':
                        $n_estado = "ASIGNADA A USUARIO";
                        break;
                    case 'Y':
                        $n_estado = "RECHAZADA";
                        break;
                    default:
                        $n_estado = "";
                        break;
                }
                $submodulo = $row['submodulo'];
                $pregunta1 = "SELECT nombre FROM cx_ctr_mod WHERE conse='$submodulo' AND modulo='$modulo'";
                $sql1 = odbc_exec($conexion,$pregunta1);
                $n_submodulo = trim(utf8_encode(odbc_result($sql1,1)));
                $unidad = $row['unidad'];
                $pregunta2 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
                $sql2 = odbc_exec($conexion,$pregunta2);
                $n_unidad = trim(odbc_result($sql2,1));
                $valores .= $row['conse']."|".substr($row["fecha"],0,10)."|".trim($row['usuario'])."|".$row['ano']."|".$n_estado."|".$n_unidad."|".$n_tipo."|".$n_modulo."|".$n_submodulo."|".trim(utf8_encode($row['concepto']))."|".trim(utf8_encode($row['solucion']))."|#";
                $i++;
            }
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
        $pregunta = "SELECT centra, n_centra FROM cv_pqr_reg WHERE 1=1";
        $complemento = " GROUP BY centra, n_centra";
        $campo = "centra";
        if ($sup_usuario == "1")
        {
        }
        else
        {
            if (($nun_usuario == "2") or ($nun_usuario == "3"))
            {
                $pregunta = "SELECT dependencia, n_dependencia FROM cv_pqr_reg WHERE 1=1";
                $pregunta .= " AND dependencia='$dun_usuario'";
                $complemento = " GROUP BY dependencia, n_dependencia";
                $campo = "dependencia";
            }
            else
            {
                $pregunta .= " AND centra='$nun_usuario'";
            }
        }
        if (!empty($_POST['fecha1']))
        {
            $pregunta .= " AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
        }
        $pregunta .= $complemento;
        $sql = odbc_exec($conexion,$pregunta);
        $total = odbc_num_rows($sql);
        $salida = new stdClass();
        if ($total>0)
        {
            $valores = "";
            $valores1 = "";
            $valores2 = "";
            $valores3 = "";
            $i = 0;
            while ($i < $row = odbc_fetch_array($sql))
            {
                $v1 = odbc_result($sql,1);
                $v2 = trim(odbc_result($sql,2));
                $valores .= '"'.$v2.'", ';
                // Solicitudes
                $pregunta1 = "SELECT COUNT(1) AS solicitudes FROM cv_pqr_reg WHERE tipo='1' AND $campo='$v1'";
                if (!empty($_POST['fecha1']))
                {
                    $pregunta1 .= " AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
                }
                $sql1 = odbc_exec($conexion,$pregunta1);
                $solicitudes = odbc_result($sql1,1);
                // Soportes
                $pregunta2 = "SELECT COUNT(1) AS soportes FROM cv_pqr_reg WHERE tipo='2' AND $campo='$v1'";
                if (!empty($_POST['fecha1']))
                {
                    $pregunta2 .= " AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
                }
                $sql2 = odbc_exec($conexion,$pregunta2);
                $soportes = odbc_result($sql2,1);
                // Otros
                $pregunta3 = "SELECT COUNT(1) AS soportes FROM cv_pqr_reg WHERE tipo='3' AND $campo='$v1'";
                if (!empty($_POST['fecha1']))
                {
                    $pregunta3 .= " AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
                }
                $sql3 = odbc_exec($conexion,$pregunta3);
                $otros = odbc_result($sql3,1);
                $valores1 .= $solicitudes.", ";
                $valores2 .= $soportes.", ";
                $valores3 .= $otros.", ";
            }
            $valores = substr($valores, 0, -2);
            $valores1 = substr($valores1, 0, -2);
            $valores2 = substr($valores2, 0, -2);
            $valores3 = substr($valores3, 0, -2);
        }
        $salida->total = $total;
        $salida->datos = $valores;
        $salida->datos1 = $valores1;
        $salida->datos2 = $valores2;
        $salida->datos3 = $valores3;
    }
    echo json_encode($salida);
}
// 12/03/2024 - Ajuste consulta modulos del software
?>