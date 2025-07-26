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
    $pregunta = "SELECT * FROM cx_inf_eje WHERE unidad='$uni_usuario' AND ((usuario='$usu_usuario') OR (usuario='$log_usuario'))";
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
            $ordop = trim($row['n_ordop'])." ".trim($row['ordop']);
            $ordop = utf8_encode($ordop);
            $mision = trim($row['mision']);
            $mision = utf8_encode($mision);
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
            $salida->rows[$i]['usuario'] = trim($row['usuario']);
            $salida->rows[$i]['unidad'] = $n_uni;
            $salida->rows[$i]['ordop'] = $ordop;
            $salida->rows[$i]['mision'] = $mision;
            $salida->rows[$i]['valor'] = trim($row['valor']);
            $salida->rows[$i]['ano'] = $row['ano'];
            $salida->rows[$i]['numero'] = $row['numero'];
            $salida->rows[$i]['consecu'] = $row['consecu'];
            $salida->rows[$i]['archivo'] = $row['archivo'];
            $salida->rows[$i]['codigo'] = $row['codigo'];
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