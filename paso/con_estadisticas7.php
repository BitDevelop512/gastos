<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
    $consulta = $_POST['consulta'];
    $clase = $_POST['clase'];
    if ($clase == "0")
    {
        $clase1 = "tipo>0";
    }
    else
    {
        $clase1 = "tipo=".$clase;
    }
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $unidad = $_POST['unidad'];
    $unidades = stringArray1($unidad);
    $longitud = explode(",",$unidades);
    $valores = "";
    $valores1 = "";
    $valores2 = "";
    for ($j=0; $j<count($longitud); $j++)
    {
        $data[$j] = "";
        $valores[$j] = "";
        $valor = $longitud[$j];
        $pregunta = "SELECT unidad, tipo, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_pla_tra.unidad) AS n_unidad, CASE WHEN tipo = '1' THEN 'MOTOCICLETA' WHEN tipo = '2' THEN 'AUTOMOVIL' WHEN tipo = '3' THEN 'CAMIONETA' WHEN tipo = '4' THEN 'VANS' ELSE '' END AS tipo1, count(1) AS total FROM cx_pla_tra WHERE unidad='$valor' AND $clase1 AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1) GROUP BY unidad, tipo ORDER BY unidad";
        $cur = odbc_exec($conexion, $pregunta);
        $total = odbc_num_rows($cur);
        $total = intval($total);
        if ($total > 0)
        {
            $k = 0;
            $subtotal = 0;
            while($k<$row=odbc_fetch_array($cur))
            {
                $v1 = odbc_result($cur,1);
                $v2 = odbc_result($cur,2);
                $v3 = trim(odbc_result($cur,3));
                $v4 = trim(utf8_encode(odbc_result($cur,4)));
                $v5 = odbc_result($cur,5);
                $v5 = intval($v5);
                $subtotal = $subtotal+$v5;
                $k++;
                $valores .= $v1."|".$v2."|".$v3."|".$v4."|".$v5."|#";
                $data[$j] .= '["'.$v3.' '.$v4.'", '.$v5.'], ';
            }
            $data[$j] = substr($data[$j], 0, -2);
            $data[$j] = "{ name: '".$v3."', id: '".$v3."', data: [ ".$data[$j]. " ] }, ";
            $valores1 .= $v3."|".$subtotal."|#";
        }
    }
    for ($j=0; $j<count($longitud); $j++)
    {
        $valores2 .= $data[$j];
    }
    $valores2 = substr($valores2, 0, -2);
    $salida->datos = $valores;
    $salida->datos1 = $valores1;
    $salida->datos2 = $valores2;
    echo json_encode($salida);
}
?>
