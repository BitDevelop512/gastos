<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
    $documentacion = $_POST['documentacion'];
    $documentacion1 = utf8_decode($documentacion);
    $directiva = $_POST['directiva'];
    $pregunta = "SELECT *, (SELECT SUBSTRING(documentacion, 0, 25)) AS documentacion1 FROM lista_0012 WHERE UPPER(documentacion) LIKE UPPER('%$documentacion1%') AND directiva='$directiva' ORDER BY es_informacion, orden";
	//var_dump($pregunta);
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $documentacion = trim(utf8_encode($row["documentacion"]));
            $documentacion = preg_replace("/\r?\n|\r/","<br>",$documentacion);
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['documentacion'] = $documentacion;
            $salida->rows[$i]['es_recompensa'] = $row["es_recompensa"];
            $salida->rows[$i]['es_informacion'] = $row["es_informacion"];
            $salida->rows[$i]['orden'] = trim($row['orden']);
            $salida->rows[$i]['directiva'] = $row['directiva'];
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