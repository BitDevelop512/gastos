<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
    $tipo = $_POST['tipo'];
    if ($tipo == "0")
    {
        $pregunta = "SELECT * FROM cx_ctr_rep ORDER BY nombre";
    }
    else
    {
        $nombre = $_POST['nombre'];
        $nombre1 = utf8_decode($nombre);
        $pregunta = "SELECT * FROM cx_ctr_rep WHERE nombre LIKE '%$nombre1%' ORDER BY nombre";
    }
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $tipo1 = $row["tipo"];
            switch ($tipo1)
            {
                case '1':
                    $n_tipo = "AUTOM&Oacute;VILES";
                    break;
                case '2':
                    $n_tipo = "MOTOCICLETAS";
                    break;
                default:
                    $n_tipo = "";
                    break;
            }
            $salida->rows[$i]['codigo'] = $row['codigo'];
            $salida->rows[$i]['nombre'] = trim(utf8_encode($row["nombre"]));
            $salida->rows[$i]['medida'] = $row["medida"];
            $salida->rows[$i]['estado'] = trim($row["estado"]);
            $salida->rows[$i]['tipo'] = $row["tipo"];
            $salida->rows[$i]['tipo1'] = $n_tipo;
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