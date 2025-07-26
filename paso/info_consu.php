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
    if ($tipo == "1")
    {
        $tabla = "cx_inf_aut";
    }
    else
    {
        $tabla = "cx_can_aut";
    }
    $pregunta = "SELECT * FROM ".$tabla." WHERE unidad='$uni_usuario' AND usuario='$usu_usuario'";
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND CONVERT(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
    }
    if ($unidad == "999")
    {
    }
    else
    {
        $pregunta .= " AND unidad1='$unidad'";
    }
    $pregunta .= " ORDER BY fecha DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $unidad = $row['unidad1'];
            if ($unidad == "999")
            {
            }
            else
            {
                $query1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
                $cur1 = odbc_exec($conexion, $query1);
                $n_uni = odbc_result($cur1,1);
                $periodo = $row['periodo'];
                $ano = $row['ano'];
                $salida->rows[$i]['conse'] = $row['conse'];
                $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
                $salida->rows[$i]['usuario'] = trim($row['usuario']);
                $salida->rows[$i]['unidad'] = $n_uni;
                $salida->rows[$i]['unidad1'] = $row['unidad1'];
                $salida->rows[$i]['gastos'] = trim($row['gastos']);
                $salida->rows[$i]['pagos'] = trim($row['pagos']);
                $salida->rows[$i]['total'] = trim($row['total']);
                $salida->rows[$i]['periodo'] = $row['periodo'];
                $salida->rows[$i]['ano'] = $row['ano'];
                $i++;
            }
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