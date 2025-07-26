<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $unidades = $_POST['unidades'];
    $periodo = $_POST['periodo'];
    $ano = $_POST['ano'];
	$query = "SELECT * FROM cx_pla_inv WHERE periodo='$periodo' AND ano='$ano' AND estado IN ('D','F','H') AND unidad IN ($unidades) ORDER BY conse";
	$sql = odbc_exec($conexion, $query);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    $m = 1;
    $var_mis = "";
    $var_val = "";
    $var_cmp = "";
    $var_ncm = "";
    $var_ced = "";
    $var_vat = "";
    $var_vac = "";
    $var_vad = "";
    $var_ide = "";
    $var_ido = "";
    $var_ida = "";
    $var_idi = "";
    while ($m < $row = odbc_fetch_array($sql))
    {
        $sustituye = array ( '°' => '' );
        $conse = $row['conse'];
        $compa = $row['compania'];
        // Se consulta nombre de copañia
        $consu = "SELECT nombre FROM cx_org_cmp WHERE conse='$compa'";
        $cud = odbc_exec($conexion,$consu);
        $ncm = trim(utf8_encode(odbc_result($cud,1)));
        // Se consulta discriminado de gastos
        $consulta = "SELECT * FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano' AND autoriza='0' ORDER BY interno";
        $cur = odbc_exec($conexion,$consulta);
        $i = 1;
        while($i<$row=odbc_fetch_array($cur))
        {
            $conse1 = trim(odbc_result($cur,1));
            $unidad = trim(odbc_result($cur,4));
            $mision = trim(odbc_result($cur,5));
            $mision = utf8_encode($mision);
            $valor = trim(odbc_result($cur,14));
            if ($valor == ".00")
            {
                $valor = "0.00";
            }
            $valor_c = trim(odbc_result($cur,19));
            $var_mis .= $mision."|";
            $var_val .= $valor."|";
            $var_cmp .= $compa."|";
            $var_ncm .= $ncm."|";
            $var_vac .= $valor_c."|";
            $var_ide .= $conse."|";
            $var_ido .= $conse1."|";
            $i++;
        }
        $consulta1 = "SELECT * FROM cx_pla_pag WHERE conse='$conse' AND ano='$ano' AND autoriza='0' ORDER BY conse1";
        $cur1 = odbc_exec($conexion,$consulta1);
        $k = 1;
        while($k<$row=odbc_fetch_array($cur1))
        {
            $conse1 = trim(odbc_result($cur1,1));
            $conse2 = trim(odbc_result($cur1,2));
            $unidad = trim(odbc_result($cur1,3));
            $cedula = trim(odbc_result($cur1,4));
            if (strpos($cedula, "K") !== false)
            {
            }
            else
            {
                $cedula = "XXXX".substr($cedula,-4);
            }
            $valor1 = trim(odbc_result($cur1,18));
            if ($valor1 == ".00")
            {
                $valor1 = "0.00";
            }
            $valor2 = trim(odbc_result($cur1,21));
            $var_ced .= $cedula."|";
            $var_vat .= $valor1."|";
            $var_vad .= $valor2."|";
            $var_ida .= $conse."|";
            $var_idi .= $conse2."|";
            $k++;
        }
        $m++;
    }
    $salida->mision = $var_mis;
    $salida->valorm = $var_val;
    $salida->compas = $var_cmp;
    $salida->ncompa = $var_ncm;
    $salida->cedula = $var_ced;
    $salida->valorc = $var_vat;
    $salida->valorx = $var_vac;
    $salida->valory = $var_vad;
    $salida->ide = $var_ide;
    $salida->ido = $var_ido;
    $salida->ida = $var_ida;
    $salida->idi = $var_idi;
    echo json_encode($salida);
}
?>