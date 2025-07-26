<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
    $busca = $_POST['busca'];
    $nombre = trim(utf8_decode($_POST['nombre']));
    $clase = trim(utf8_decode($_POST['clase']));
    $tipo = $_POST['tipo'];
    if ($busca == "1")
    {
        $pregunta = "SELECT * FROM cx_ctr_bie WHERE nombre LIKE '%$nombre%' ORDER BY nombre";
    }
    if ($busca == "2")
    {
        $codigos = "";
        $pregunta0 = "SELECT TOP 1 * FROM cx_ctr_cla WHERE nombre LIKE '%$clase%'";
        $sql0 = odbc_exec($conexion,$pregunta0);
        $clase1 = odbc_result($sql0,1);
        $pregunta1 = "SELECT * FROM cx_ctr_bie WHERE clase='$clase1'";
        $sql1 = odbc_exec($conexion,$pregunta1);
        $j = 0;
        while ($j < $row = odbc_fetch_array($sql1))
        {
            $cod = $row['codigo'];
            $codigos .= $cod.",";
            $j++;
        }
        $codigos = substr($codigos, 0, -1);
        $pregunta = "SELECT * FROM cx_ctr_bie WHERE codigo IN ($codigos) ORDER BY nombre";
    }
    if ($busca == "3")
    {
        $pregunta = "SELECT * FROM cx_ctr_bie WHERE tipo='$tipo' ORDER BY nombre";
    }
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