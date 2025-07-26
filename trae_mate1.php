<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
    $nombre = $_POST['nombre'];
    $nombre1 = utf8_decode($nombre);
    $directiva = $_POST['directiva'];
    $pregunta = "SELECT *, (SELECT SUBSTRING(nombre, 0, 25)) AS nombre1 FROM cx_ctr_mat WHERE nombre LIKE '%$nombre1%' AND directiva='$directiva' ORDER BY nombre1";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $nombre = trim(utf8_encode($row["nombre"]));
            $nombre = preg_replace("/\r?\n|\r/","<br>",$nombre);
            $salida->rows[$i]['codigo'] = $row['codigo'];
            $salida->rows[$i]['nombre'] = $nombre;
            $salida->rows[$i]['unidad'] = $row["unidad"];
            $salida->rows[$i]['valor'] = trim($row['valor']);
            $salida->rows[$i]['valor1'] = trim($row['valor1']);
            $salida->rows[$i]['porcen'] = trim($row['porcen']);
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