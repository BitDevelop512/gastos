<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
    $pregunta = "SELECT * FROM cx_ctr_bie ORDER BY nombre";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $clase = $row['clase'];
            $pregunta1 = "SELECT nombre FROM cx_ctr_cla WHERE codigo='$clase'";
            $sql1 = odbc_exec($conexion,$pregunta1);
            $n_clase =  trim(utf8_encode(odbc_result($sql1,1)));
            $salida->rows[$i]['clase'] = $row['clase'];
            $salida->rows[$i]['clase1'] = $n_clase;
            $salida->rows[$i]['codigo'] = $row['codigo'];
            $salida->rows[$i]['nombre'] = trim(utf8_encode($row["nombre"]));
            $salida->rows[$i]['tipo'] = $row["tipo"];
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