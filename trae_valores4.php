<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $unidad = $_POST['unidad'];
    $periodo = $_POST['periodo'];
    $ano = $_POST['ano'];
    $query = "SELECT * FROM cx_pla_inv WHERE unidad='$unidad' AND periodo='$periodo' AND ano='$ano' AND estado IN ('P', 'F', 'D', 'H') AND tipo='1' ORDER BY conse";
    $sql = odbc_exec($conexion, $query);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    $m = 1;
    $var_cmp = "";
    $var_com = "";
    $var_mis = "";
    $var_val = "";
    $var_des = "";
    $var_cmm = "";
    $var_cof= "";
    $var_ced = "";
    $var_vat = "";
    while ($m < $row = odbc_fetch_array($sql))
    {
        $conse = $row['conse'];
        $compania = $row['compania'];
        $consulta0 = "SELECT nombre FROM cx_org_cmp WHERE conse='$compania'";
        $cur0 = odbc_exec($conexion,$consulta0);
        $n_compa = trim(utf8_encode(odbc_result($cur0,1)));
        $consulta = "SELECT * FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano'";
        $cur = odbc_exec($conexion,$consulta);
        $i = 1;
        while($i<$row=odbc_fetch_array($cur))
        {
            $consecu1 = trim(odbc_result($cur,1));
            $interno = trim(odbc_result($cur,3));
            $mision = trim(odbc_result($cur,5));
            $valor = trim(odbc_result($cur,14));
            $var_cmp .= $n_compa."|";
            $var_com .= $consecu1."|";
            $var_mis .= $mision."|";
            $var_val .= $valor."|";
            $consulta2 = "SELECT conse, conse1, interno, unidad, gasto, otro, valor, ano, bienes, (SELECT nombre FROM cx_ctr_pag WHERE codigo=cx_pla_gad.gasto) AS gasto1, (SELECT tipo FROM cx_ctr_pag WHERE codigo=cx_pla_gad.gasto) AS gasto2 FROM cx_pla_gad WHERE conse1='$conse' AND interno='$interno' AND ano='$ano'";
            $cur2 = odbc_exec($conexion,$consulta2);
            $n = 1;
            while($n<$row=odbc_fetch_array($cur2))
            {
                $consecu3 = trim(odbc_result($cur2,1));
                $gasto = trim(odbc_result($cur2,5));
                $valod = trim(odbc_result($cur2,7));
                $gasto1 = trim(utf8_encode(odbc_result($cur2,10)));
                $gasto2 = trim(odbc_result($cur2,11));
                $var_des .= $consecu3."¬".$gasto."¬".$gasto1."¬".$gasto2."¬".$valod."¬|";
                $n++;
            }
            $i++;
        }
        $consulta1 = "SELECT * FROM cx_pla_pag WHERE conse='$conse' AND ano='$ano'";
        $cur1 = odbc_exec($conexion,$consulta1);
        $k = 1;
        while($k<$row=odbc_fetch_array($cur1))
        {
            $consecu2 = trim(odbc_result($cur1,1));
            $cedula = trim(odbc_result($cur1,4));
            if (strpos($cedula, "K") !== false)
            {
            }
            else
            {
                $cedula = "XXXX".substr($cedula,-4);
            }
            $valor1 = trim(odbc_result($cur1,18));
            $var_cmm .= $n_compa."|";
            $var_cof .= $consecu2."|";
            $var_ced .= $cedula."|";
            $var_vat .= $valor1."|";
            $k++;
        }
        $m++;
    }
    $salida->compas = $var_cmp;
    $salida->conses = $var_com;
    $salida->mision = $var_mis;
    $salida->valorm = $var_val;
    $salida->discri = $var_des;
    $salida->compan = $var_cmm;
    $salida->fuente = $var_cof;
    $salida->cedula = $var_ced;
    $salida->valorc = $var_vat;
    echo json_encode($salida);
}
// 05/07/2024 - Ajuste de modificacion de valores desde el CDO
// 30/01/2025 - Ajuste nombres gastos
?>