<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
    $consulta = $_POST['consulta'];
    $marca = $_POST['marca'];
    if ($marca == "999")
    {
    }
    else
    {
        $marcas = stringArray($marca);
    }
    $linea = $_POST['linea'];
    if ($linea == "999")
    {
    }
    else
    {
        $lineas = stringArray($linea);
    }
    $modelo = $_POST['modelo'];
    if ($modelo == "999")
    {
    }
    else
    {
        $modelos = stringArray($modelo);
    }
    $color = $_POST['color'];
    if ($color == "999")
    {
    }
    else
    {
        $colores = stringArray($color);
    }
    $unidad = $_POST['unidad'];
    $unidades = stringArray1($unidad);
    $longitud = explode(",",$unidades);
    $centra = $_POST['centra'];
    $sigla = $_POST['sigla'];
    $valores = "";
    $valores1 = "";
    $valores2 = "";
    $valores3 = "";
    if (($centra == "999") and ($sigla == "TODAS"))
    {
        $datos1 = "";
        $datos2 = "";
        $datos3 = "";
        $datos4 = "";
        $datos5 = "";
        for ($j=0; $j<count($longitud); $j++)
        {
            $data[$j] = "";
            $valores[$j] = "";
            $valor = $longitud[$j];           
            $pregunta0 = "SELECT unidad, sigla FROM cx_org_sub WHERE subdependencia='$valor'";
            $sql0 = odbc_exec($conexion, $pregunta0);
            $unidad1 = odbc_result($sql0,1);
            $sigla1 = trim(odbc_result($sql0,2));
            if (($unidad1 == "2") or ($unidad1 == "3"))
            {
                $pregunta = "SELECT dependencia FROM cx_org_sub WHERE unidad='$unidad1' AND sigla='$sigla1'";
                $sql = odbc_exec($conexion, $pregunta);
                $dependencia = odbc_result($sql,1);
                $query = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$unidad1' AND dependencia='$dependencia' ORDER BY sigla";
            }
            else
            {
                $query = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$unidad1' ORDER BY sigla";
            }
            $cur = odbc_exec($conexion, $query);
            $k = 0;
            $unidades1 = "";
            while($k<$row=odbc_fetch_array($cur))
            {
                $v1 = odbc_result($cur,1);
                $unidades1 .= "'".$v1."',";
            }
            $unidades1 = substr($unidades1, 0, -1);
            $pregunta = "SELECT unidad, tipo, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_pla_tra.unidad) AS n_unidad, CASE WHEN tipo='1' THEN 'MOTOCICLETA' WHEN tipo='2' THEN 'AUTOMOVIL' WHEN tipo='3' THEN 'CAMIONETA' WHEN tipo='4' THEN 'VANS' WHEN tipo='5' THEN 'CAMPERO' WHEN tipo='6' THEN 'MICROBUS' WHEN tipo='7' THEN 'CAMION' ELSE '' END AS tipo1, COUNT(1) AS total FROM cx_pla_tra WHERE unidad IN ($unidades1)";
            if ($marca == "999")
            {
            }
            else
            {
                $pregunta .= " AND marca IN ($marcas)";
            }
            if ($linea == "999")
            {
            }
            else
            {
                $pregunta .= " AND linea IN ($lineas)";
            }
            if ($modelo == "999")
            {
            }
            else
            {
                $pregunta .= " AND modelo IN ($modelos)";
            }
            if ($color == "999")
            {
            }
            else
            {
                $pregunta .= " AND color IN ($colores)";
            }
            $pregunta .= " GROUP BY unidad, tipo ORDER BY unidad";
            $cur = odbc_exec($conexion, $pregunta);
            $tot_cur = odbc_num_rows($cur);
            if ($tot_cur > 0)
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
                    $valores .= $v1."|".$v2."|".$sigla1."|".$v4."|".$v5."|#";
                    $data[$j] .= '["'.$v3." ".$v4.'", '.$v5.'], ';
                }
                $data[$j] = substr($data[$j], 0, -2);
                $data[$j] = "{ name: '".$sigla1."', id: '".$sigla1."', data: [ ".$data[$j]. " ] }, ";
                $valores1 .= $sigla1."|".$subtotal."|#";
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
    }
    else
    {
        for ($j=0; $j<count($longitud); $j++)
        {
            $data[$j] = "";
            $valores[$j] = "";
            $valor = $longitud[$j];
            $pregunta = "SELECT unidad, tipo, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_pla_tra.unidad) AS n_unidad, CASE WHEN tipo='1' THEN 'MOTOCICLETA' WHEN tipo='2' THEN 'AUTOMOVIL' WHEN tipo='3' THEN 'CAMIONETA' WHEN tipo='4' THEN 'VANS' WHEN tipo='5' THEN 'CAMPERO' WHEN tipo='6' THEN 'MICROBUS' WHEN tipo='7' THEN 'CAMION' ELSE '' END AS tipo1, COUNT(1) AS total FROM cx_pla_tra WHERE unidad='$valor'";
            if ($marca == "999")
            {
            }
            else
            {
                $pregunta .= " AND marca IN ($marcas)";
            }
            if ($linea == "999")
            {
            }
            else
            {
                $pregunta .= " AND linea IN ($lineas)";
            }
            if ($modelo == "999")
            {
            }
            else
            {
                $pregunta .= " AND modelo IN ($modelos)";
            }
            if ($color == "999")
            {
            }
            else
            {
                $pregunta .= " AND color IN ($colores)";
            }
            $pregunta .= " GROUP BY unidad, tipo ORDER BY unidad";
            $cur = odbc_exec($conexion, $pregunta);
            $tot_cur = odbc_num_rows($cur);
            if ($tot_cur > 0)
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
                    $data[$j] .= '["'.$v4.'", '.$v5.'], ';
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
    }
    echo json_encode($salida);
}
// 29/11/2023 - Estadistica de Transporte
?>