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
    $query = "SELECT * FROM cx_pla_inv WHERE unidad='$unidad' AND periodo='$periodo' AND ano='$ano' AND estado IN ('C','D') AND tipo='1' ORDER BY conse"; 
    $sql = odbc_exec($conexion, $query);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    $m = 1;
    $var_cmp = "";
    $var_com = "";
    $var_mis = "";
    $var_val = "";
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
        $consulta = "SELECT * FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano' AND unidad='$unidad'";
        $cur = odbc_exec($conexion,$consulta);
        $i = 1;
        while($i<$row=odbc_fetch_array($cur))
        {
            $consecu1 = trim(odbc_result($cur,1));
            $mision = trim(odbc_result($cur,5));
            $valor = trim(odbc_result($cur,14));
            $query = "SELECT valor FROM cx_pag_aut WHERE unidad1='$unidad' AND periodo='$periodo' AND ano='$ano' AND tipo='1' AND interno='$consecu1'";
            $sql1 = odbc_exec($conexion,$query);
            $tot = odbc_num_rows($sql1);
            if ($tot > 0)
            {
                $valor = trim(odbc_result($sql1,1));
            }
            $var_cmp .= $n_compa."|";
            $var_com .= $consecu1."|";
            $var_mis .= $mision."|";
            $var_val .= $valor."|";
            $i++;
        }
        $consulta1 = "SELECT * FROM cx_pla_pag WHERE conse='$conse' AND ano='$ano' AND unidad='$unidad'";
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
            $query = "SELECT valor FROM cx_pag_aut WHERE unidad1='$unidad' AND periodo='$periodo' AND ano='$ano' AND tipo='2' AND interno='$consecu2'";
            $sql1 = odbc_exec($conexion,$query);
            $tot = odbc_num_rows($sql1);
            if ($tot > 0)
            {
                $valor1 = trim(odbc_result($sql1,1));
            }
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
    $salida->compan = $var_cmm;
    $salida->fuente = $var_cof;
    $salida->cedula = $var_ced;
    $salida->valorc = $var_vat;
    echo json_encode($salida);
}
?>