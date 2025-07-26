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
    if ($sup_usuario == "1")
    {
        $pregunta = "SELECT * FROM cx_rel_gas WHERE tipo='$tipo'";
    }
    else
    {
        $pregunta = "SELECT * FROM cx_rel_gas WHERE unidad='$uni_usuario' AND tipo='$tipo' AND ((usuario='$usu_usuario') OR (usuario='$log_usuario'))";
    }
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1)";
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
            $unidad = $row['unidad'];
            $query1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
            $cur1 = odbc_exec($conexion, $query1);
            $n_uni = odbc_result($cur1,1);
            $ordop = trim($row['n_ordop'])." ".$row['ordop'];
            $ordop =  utf8_encode($ordop);
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
            $salida->rows[$i]['tipo'] = $n_tipo;
            $salida->rows[$i]['ordop'] = $ordop;
            $salida->rows[$i]['mision'] = $mision;
            $salida->rows[$i]['periodo'] = $periodo;
            $salida->rows[$i]['ano'] = $ano;
            $salida->rows[$i]['consecu'] = $row['consecu'];
            $salida->rows[$i]['total'] = trim($row['total']);
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