<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
    $pregunta = "SELECT * FROM cx_org_sub ORDER BY sigla";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $salida->rows[$i]['unidad'] = $row['unidad'];
            $salida->rows[$i]['dependencia'] = $row["dependencia"];
            $salida->rows[$i]['subdependencia'] = $row["subdependencia"];
            $salida->rows[$i]['sigla'] = $row['sigla'];
            $salida->rows[$i]['nombre'] = utf8_encode(trim($row['nombre']));
            $salida->rows[$i]['tipo'] = $row['tipo'];
            $salida->rows[$i]['techo'] = $row['techo'];
            $salida->rows[$i]['sigla1'] = $row['sigla1'];
            $salida->rows[$i]['nombre1'] = utf8_encode(trim($row['nombre1']));
            $salida->rows[$i]['fecha'] = $row['fecha'];
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