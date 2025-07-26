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
    $centra = trim($_POST['centra']);
    $centra1 = utf8_decode($centra);
    $unidad = $_POST['unidad'];
    $unidad1 = "»".$unidad."»";
    $documento = $_POST['documento'];
    $documento1 = "»".$documento."|";
    if ($sup_usuario == "1")
    {
        $pregunta = "SELECT * FROM cx_act_ver WHERE 1=1";
    }
    else
    {
        $pregunta = "SELECT * FROM cx_act_ver WHERE ((usuario='$usu_usuario') OR (usuario='$log_usuario'))";
    }
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND convert(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
    }
    if ($centra == "-")
    {
    }
    else
    {
        $pregunta .= " AND ((centraliza='$centra') OR (centraliza='$centra1'))";
    }
    if ($unidad == "-")
    {
    }
    else
    {
        $pregunta .= " AND observaciones LIKE '%$unidad1%'";
    }

    if ($documento == "-")
    {
    }
    else
    {
        $pregunta .= " AND observaciones LIKE '%$documento1%'";
    }
    $pregunta .= " ORDER BY fec_act DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $datos = "";
            $observa = trim($row['observaciones']);
            $var_ocu = explode("|",$observa);
            for ($j=0;$j<count($var_ocu);++$j)
            {
                $paso = $var_ocu[$j];
                $var_ocu1 = explode("»",$paso);
                $v_var1 = $var_ocu1[0];
                $v_var2 = trim($var_ocu1[1]);
                $pregunta1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$v_var2'";
                $sql1 = odbc_exec($conexion, $pregunta1);
                $v_var2 = trim(odbc_result($sql1,1));
                $v_var3 = trim($var_ocu1[2]);
                $v_var3 = trim(utf8_encode($v_var3));
                $v_var4 = trim($var_ocu1[3]);
                $v_var5 = trim($var_ocu1[4]);
                $pregunta2 = "SELECT nombre FROM cx_ctr_doc WHERE codigo='$v_var5'";
                $sql2 = odbc_exec($conexion, $pregunta2);
                $v_var5 = trim(odbc_result($sql2,1));
                $v_var5 = utf8_encode($v_var5);
                $datos .= $v_var1."^".$v_var2."^".$v_var3."^".$v_var4."^".$v_var5."^&";
            }
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['ano'] = $row['ano'];
            $salida->rows[$i]['acta'] = trim($row['acta']);
            $salida->rows[$i]['fecha'] = substr($row["fec_act"],0,10);
            $salida->rows[$i]['estado'] = trim($row['estado']);
            $salida->rows[$i]['lugar'] = trim(utf8_encode($row['lugar']));
            $salida->rows[$i]['centraliza'] = trim(utf8_encode($row['centraliza']));
            $salida->rows[$i]['fecha1'] = substr($row["fec_ini"],0,10);
            $salida->rows[$i]['fecha2'] = substr($row["fec_ter"],0,10);
            $salida->rows[$i]['periodo'] = trim(utf8_encode($row['periodo']));
            $salida->rows[$i]['observa'] = $datos;
            $salida->rows[$i]['planes'] = trim(utf8_encode($row['planes']));
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