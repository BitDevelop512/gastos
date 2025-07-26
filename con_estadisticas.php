<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
    $consulta = $_POST['consulta'];
    $tipo = $_POST['tipo'];
    if ($tipo == "3")
    {
        $tipo1 = "tipo>0";
    }
    else
    {
        $tipo1 = "tipo=".$tipo;
    }
    $periodo1 = $_POST['periodo1'];
    $periodo2 = $_POST['periodo2'];
    $ano = $_POST['ano'];
    $unidad = $_POST['unidad'];
    $unidades = stringArray1($unidad);
    $longitud = explode(",",$unidades);
    $valores = "";
    $valores1 = "";
    $valores2 = "";
    $valores3 = "";
    for ($j=0; $j<count($longitud); $j++)
    {
        $data[$j] = "";
        $valores[$j] = "";
        $valor = $longitud[$j];
        //$pregunta = "SELECT unidad, tipo, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_pla_inv.unidad) AS n_unidad, estado, CASE WHEN estado = '' THEN 'En Tramite' WHEN estado = 'P' THEN 'Pendiente de Revisión' WHEN estado = 'A' THEN 'Aprobado' WHEN estado = 'B' THEN 'Aprobado' WHEN estado = 'C' THEN 'Aprobado' WHEN estado = 'D' THEN 'Aprobado' WHEN estado = 'E' THEN 'Aprobado' WHEN estado = 'F' THEN 'Aprobado' WHEN estado = 'J' THEN 'Aprobado' WHEN estado = 'K' THEN 'Aprobado' WHEN estado = 'L' THEN 'Aprobado' WHEN estado = 'M' THEN 'Aprobado' WHEN estado = 'N' THEN 'Aprobado' WHEN estado = 'O' THEN 'Aprobado' WHEN estado = 'Q' THEN 'Aprobado' WHEN estado = 'H' THEN 'Consolidado' WHEN estado = 'Y' THEN 'Rechazado' WHEN estado = 'X' THEN 'Anulado' WHEN estado = 'W' THEN 'Apoyado' WHEN estado = 'G' THEN 'Girado' ELSE '' END AS estado1, count(1) AS total FROM cx_pla_inv WHERE unidad='$valor' AND $tipo1 AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1) GROUP BY unidad, tipo, estado ORDER BY unidad, estado";
        $pregunta = "SELECT unidad, tipo, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cv_rev_pla.unidad) AS n_unidad, '' AS estado, estado1, count(1) AS total FROM cv_rev_pla WHERE unidad='$valor' AND $tipo1 AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' GROUP BY unidad, tipo, estado1 ORDER BY unidad, estado1";
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
                $v4 = odbc_result($cur,4);
                $v5 = trim(utf8_encode(odbc_result($cur,5)));
                if ($v5 == "Apoyado")
                {
                    $v5 = "Solicitudes Aprobadas";
                }
                if ($v5 == "Aprobado")
                {
                    $v5 = "Planes Aprobados";
                }
                $v6 = odbc_result($cur,6);
                $v6 = intval($v6);
                $subtotal = $subtotal+$v6;
                $k++;
                $valores .= $v1."|".$v2."|".$v3."|".$v4."|".$v5."|".$v6."|#";
                $data[$j] .= '["'.$v5.' '.$v4.'", '.$v6.'], ';
            }
            $data[$j] = substr($data[$j], 0, -2);
            $data[$j] = "{ name: '".$v3."', id: '".$v3."', data: [ ".$data[$j]. " ] }, ";
            $valores1 .= $v3."|".$subtotal."|#";
            // 
            $pregunta1 = "SELECT conse, ano, unidad, estado FROM cx_pla_inv WHERE unidad='$valor' AND $tipo1 AND estado IN ('W','D') AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano'";
            $cur1 = odbc_exec($conexion, $pregunta1);
            $tot_cur1 = odbc_num_rows($cur1);
            if ($tot_cur1 > 0)
            {
                $m = 0;
                $conses1 = "";
                $conses2 = "";
                while($m<$row=odbc_fetch_array($cur1))
                {
                    $x1 = odbc_result($cur1,1);
                    $x2 = odbc_result($cur1,2);
                    $x3 = odbc_result($cur1,3);
                    $x4 = trim(odbc_result($cur1,4));
                    if ($x4 == "W")
                    {
                        $conses1 .= "'".$x1."',";
                    }
                    else
                    {
                        $conses2 .= "'".$x1."',";
                    }
                }
                $conses1 = substr($conses1, 0, -1);
                $conses2 = substr($conses2, 0, -1);
                //
                $pregunta2 = "SELECT SUM(total) AS total, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cv_pla_som.unidad) AS n_unidad FROM cv_pla_som WHERE conse IN ($conses1) AND ano='$x2' AND unidad='$x3' GROUP BY unidad";
                $cur2 = odbc_exec($conexion, $pregunta2);
                $x5 = odbc_result($cur2,1);
                if (trim($conses1) == "")
                {
                    $x5 = "0.00";
                }
                $x6 = trim(odbc_result($cur2,2));
                $pregunta3 = "SELECT SUM(total) AS total, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cv_pla_som.unidad) AS n_unidad FROM cv_pla_som WHERE conse IN ($conses2) AND ano='$x2' AND unidad='$x3' GROUP BY unidad";
                $cur3 = odbc_exec($conexion, $pregunta3);
                $x7 = odbc_result($cur3,1);
                if (trim($conses2) == "")
                {
                    $x7 = "0.00";
                }
                $x8 = trim(odbc_result($cur3,2));
                $valores3 .= $v3."|".$x5."|".$x7."|#";
            }
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
    $salida->datos3 = $valores3;
    echo json_encode($salida);
}
// 07/11/2023 - Estadistica de Planes / Solciitudes - Exportacion a excel
?>