<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $query = "SELECT * FROM cx_act_cen WHERE estado='F' ORDER BY fecha DESC";
    $sql = odbc_exec($conexion, $query);
    $total1 = odbc_num_rows($sql);
    $salida = new stdClass();
    $m = 1;
    $var_con = "";
    $var_fec = "";
    $var_ano = "";
    $var_reg = "";
    $var_ano1 = "";
    $var_val = "";
    $var_tot = "";
    $var_ant = "";
    $var_sig = "";
    $var_uni = "";
    $var_ord = "";
    $var_fra = "";
    while ($m < $row = odbc_fetch_array($sql))
    {
        $conse = $row['conse'];
        $fecha = $row['fecha'];
        $fecha = substr($fecha,0,10);
        $ano = $row['ano'];
        $registro = $row['registro'];
        $ano1 = $row['ano1'];
        $valor = trim($row['valor']);
        $total = trim($row['totala']);
        $query0 = "SELECT unidad, valores1, n_ordop, ordop, fragmenta FROM cx_reg_rec WHERE conse='$registro' AND ano='$ano1'";
        $sql0 = odbc_exec($conexion, $query0);
        $unidad1 = odbc_result($sql0,1);
        $valores1 = trim(odbc_result($sql0,2));
        $n_ordop = trim(odbc_result($sql0,3));
        $ordop = trim(utf8_encode(odbc_result($sql0,4)));
        $ordop = $n_ordop." ".$ordop;
        $fragmenta = trim(utf8_encode(odbc_result($sql0,5)));
        $anticipo = 0;
        $num_valores1 = explode("|",$valores1);
        for ($i=0;$i<count($num_valores1);++$i)
        {
          $paso = $num_valores1[$i];
          $paso =  floatval($paso);
          $anticipo = $anticipo+$paso;
        }
        $query1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad1'";
        $sql1 = odbc_exec($conexion, $query1);
        $sigla = trim(odbc_result($sql1,1));
        $var_con .= $conse."|";
        $var_fec .= $fecha."|";
        $var_ano .= $ano."|";
        $var_reg .= $registro."|";
        $var_ano1 .= $ano1."|";
        $var_val .= $valor."|";
        $var_tot .= $total."|";
        $var_ant .= $anticipo."|";
        $var_sig .= $sigla."|";
        $var_uni .= $unidad1."|";
        $var_ord .= $ordop."|";
        $var_fra .= $fragmenta."|";
        $m++;
    }
    $salida = new stdClass();
    $salida->conses = $var_con;
    $salida->fechas = $var_fec;
    $salida->anos = $var_ano;
    $salida->registros = $var_reg;
    $salida->anos1 = $var_ano1;
    $salida->valores = $var_val;
    $salida->totales = $var_tot;
    $salida->anticipos = $var_ant;
    $salida->siglas = $var_sig;
    $salida->unidades = $var_uni;
    $salida->ordop = $var_ord;
    $salida->fragmenta = $var_fra;
    $salida->total = $total1;
    echo json_encode($salida);
}
?>