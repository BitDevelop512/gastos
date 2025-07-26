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
    $unidad = $_POST['unidad'];
    if ($sup_usuario == "1")
    {
        if ($unidad == "-")
        {
            $pregunta = "SELECT * FROM cx_rel_gas WHERE tipo='$tipo'";
        }
        else
        {
            $pregunta = "SELECT * FROM cx_rel_gas WHERE tipo='$tipo' AND unidad='$unidad'";
        }
    }
    else
    {
        if ($sup_usuario == "6")
        {
            $pregunta1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND dependencia='$dun_usuario' AND unic='1'";
            $sql1 = odbc_exec($conexion,$pregunta1);
            $uni_com = odbc_result($sql1,1);
            $pregunta = "SELECT * FROM cx_rel_gas WHERE unidad IN ('$uni_com','$uni_usuario') AND tipo='$tipo'";
        }
        else
        {
            $pregunta = "SELECT * FROM cx_rel_gas WHERE unidad='$uni_usuario' AND tipo='$tipo' AND ((usuario='$usu_usuario') OR (usuario='$log_usuario'))";
        }
    }
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1)";
    }
    $pregunta .= " AND unidad!='999'";
    $pregunta .= " ORDER BY fecha DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $unidad = $row['unidad'];
            // Se valida cambio de sigla
            $valida = substr($row["fecha"],0,10);
            $query1 = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unidad'";
            $cur1 = odbc_exec($conexion, $query1);
            $n_uni = trim(odbc_result($cur1,1));
            $m_uni = trim(odbc_result($cur1,2));
            $f_uni = trim(odbc_result($cur1,3));
            if ($f_uni == "")
            {
            }
            else
            {
                $f_uni = str_replace("/", "-", $f_uni);
                if ($valida >= $f_uni)
                {
                    $n_uni = $m_uni;
                }
            }
            $ordop = trim($row['n_ordop'])." ".trim($row['ordop']);
            $ordop = trim(utf8_encode($ordop));
            $mision = trim(utf8_encode($row['mision']));
            $periodo = $row['periodo'];
            $ano = $row['ano'];
            if ($tipo == "1")
            {
                $n_tipo = "Informe de Gastos";
            }
            else
            {
                $n_tipo = "Relaci&oacute;n de Gastos";
            }
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['fecha'] = substr($row['fecha'],0,10);
            $salida->rows[$i]['usuario'] = trim($row['usuario']);
            $salida->rows[$i]['unidad'] = $n_uni;
            $salida->rows[$i]['unidad1'] = $unidad;
            $salida->rows[$i]['tipo'] = $n_tipo;
            $salida->rows[$i]['ordop'] = $ordop;
            $salida->rows[$i]['mision'] = $mision;
            $salida->rows[$i]['periodo'] = $periodo;
            $salida->rows[$i]['ano'] = $ano;
            $salida->rows[$i]['consecu'] = $row['consecu'];
            $salida->rows[$i]['total'] = trim($row['total']);
            $salida->rows[$i]['servidor'] = trim($row['servidor']);
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
// 22/02/2024 - Ajuste cambio de sigla
// 04/03/2024 - Inclusion filtro de uinidad para super usuario
// 22/11/2024 - Ajuste identificador contingencia
// 09/04/2025 - Ajuste consulta datos relacion desde administrador
?>