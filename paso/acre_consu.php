<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $tipo = $_POST['tipo'];
    switch ($tipo) {
        case '-':
            $campo = "fecha";
            break;
        case '1':
            $campo = "fec_act";
            break;
        case '2':
            $campo = "fec_res";
            break;
        case '3':
            $campo = "fec_con";
            break;
        default:
            $campo = "fecha";
            break;
    }
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $unidades = $_POST['unidades'];
    $pregunta = "SELECT * FROM cx_reg_acr WHERE 1=1";
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND convert(datetime,'$campo',102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1)";
    }
    if (($uni_usuario == "1") or ($uni_usuario == "2"))
    {
    }
    else
    {
        $pregunta .= " AND batallon in ($unidades)";

    }
    $pregunta .= " ORDER BY $campo DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $unidad = $row['batallon'];
            $query1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
            $cur1 = odbc_exec($conexion, $query1);
            $n_uni = odbc_result($cur1,1);
            $campo1 = substr($row[$campo],0,10);
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['fecha'] = $campo1;
            $salida->rows[$i]['unidad'] = $n_uni;
            $salida->rows[$i]['batallon'] = $unidad;
            $salida->rows[$i]['nombre'] = trim(utf8_encode($row['nombre']));
            $salida->rows[$i]['cedula'] = trim($row['cedula']);
            $salida->rows[$i]['numero'] = trim($row['num_act']);
            $salida->rows[$i]['ordop'] = trim(utf8_encode($row['ordop']));
            $salida->rows[$i]['ofrag'] = trim(utf8_encode($row['ofrag']));
            $salida->rows[$i]['valor'] = trim($row['valor']);
            $salida->rows[$i]['estado'] = trim($row['estado']);
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