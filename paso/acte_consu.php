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
    if ($sup_usuario == "1")
    {
        $pregunta = "SELECT * FROM cx_act_rec WHERE 1=1";
    }
    else
    {
        $pregunta = "SELECT * FROM cx_act_rec WHERE unidad='$uni_usuario' AND ((usuario='$usu_usuario') OR (usuario='$log_usuario'))";
    }
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND convert(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
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
            $n_uni = trim(odbc_result($cur1,1));
            $cedulas = $row['cedulas'];
            $num_cedulas = explode(",",$cedulas);
            $con_cedulas = count($num_cedulas);
            $fuentes = "";
            for ($j=0;$j<$con_cedulas;++$j)
            {
                $paso = trim($num_cedulas[$j]);
                $num_fuentes = explode("|",$paso);
                $num_fuentes1 = trim($num_fuentes[0]);
                $num_fuentes1 = "XXXX".substr($num_fuentes1,-4);
                $fuentes .= $num_fuentes1."  -  ";
            }
            $fuentes = substr($fuentes,0,-5);
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
            $salida->rows[$i]['unidad'] = $n_uni;
            $salida->rows[$i]['usuario'] = trim($row['usuario']);
            $salida->rows[$i]['estado'] = $row['estado'];
            $salida->rows[$i]['ano'] = $row['ano'];
            $salida->rows[$i]['registro'] = $row['registro'];
            $salida->rows[$i]['ano1'] = $row['ano1'];
            $salida->rows[$i]['pago'] = trim($row['pago']);
            $salida->rows[$i]['cedulas'] = $fuentes;
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