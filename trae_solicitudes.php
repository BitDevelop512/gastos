<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $ano = date('Y');
  $query = "SELECT *, ISNULL((SELECT nombre FROM cx_ctr_rec WHERE codigo=cx_pla_inv.recurso),'N/A') AS nrecurso FROM cx_pla_inv WHERE estado='L' AND tipo='2' AND aprueba='0' AND ano='$ano' ORDER BY conse";
  $sql = odbc_exec($conexion, $query);
  $total1 = odbc_num_rows($sql);
  $salida = new stdClass();
  $m = 1;
  $var_con = "";
  $var_fec = "";
  $var_per = "";
  $var_ano = "";
  $var_sig = "";
  $var_uni = "";
  $var_val = "";
  $var_tot = "";
  $var_var = "";
  $var_rec = "";
  while ($m < $row = odbc_fetch_array($sql))
  {
    $conse = $row['conse'];
    $fecha = $row['fecha'];
    $fecha = substr($fecha,0,19);
    $periodo = $row['periodo'];
    $ano = $row['ano'];
    $unidad = $row['unidad'];
    $nrecurso = $row['nrecurso'];
    $query0 = "SELECT conse1, ced_fuen, val_fuen_a FROM cx_pla_pag WHERE conse='$conse' AND unidad='$unidad' AND ano='$ano' ORDER BY conse1";
    $sql0 = odbc_exec($conexion, $query0);
    $total2 = odbc_num_rows($sql0);
    if ($total2 > 0)
    {
      $n = 0;
      $paso = "";
      while ($n < $row = odbc_fetch_array($sql0))
      {
        $var_1 = odbc_result($sql0,1);
        $var_2 = trim(odbc_result($sql0,2));
        $var_3 = trim(odbc_result($sql0,3));
        $paso .= $var_1."#".$var_2."#".$var_3."#«";
        $n++;
      }
    }
    $query1 = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unidad'";
    $sql1 = odbc_exec($conexion, $query1);
    $sigla = trim(odbc_result($sql1,1));
    $sigla1 = trim(odbc_result($sql1,2));
    $query2 = "SELECT gastos_a, pagos_a, total_a FROM cv_inv_cent2 WHERE conse='$conse' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano'";
    $sql2 = odbc_exec($conexion, $query2);
    $gastos = odbc_result($sql2,1);
    $pagos = odbc_result($sql2,2);
    $total = odbc_result($sql2,3);
    $var_con .= $conse."|";
    $var_fec .= $fecha."|";
    $var_per .= $periodo."|";
    $var_ano .= $ano."|";
    $var_sig .= $sigla."|";
    $var_uni .= $unidad."|";
    $var_val .= $gastos.",".$pagos.",".$total."|";
    $var_tot .= $total2."|";
    $var_var .= $paso."|";
    $var_rec .= $nrecurso."|";
    $m++;
  }
  $salida = new stdClass();
  $salida->conses = $var_con;
  $salida->fechas = $var_fec;
  $salida->periodos = $var_per;
  $salida->anos = $var_ano;
  $salida->siglas = $var_sig;
  $salida->unidades = $var_uni;
  $salida->valores = $var_val;
  $salida->total = $total1;
  $salida->totales = $var_tot;
  $salida->pagos = $var_var;
  $salida->recursos = $var_rec;
  echo json_encode($salida);
}
// 24/02/2025 - Ajuste inclusion campo recurso adicional
?>