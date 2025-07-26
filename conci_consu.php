<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $periodo = $_POST['periodo'];
  $periodo1 = intval($periodo)+1;
  $periodo1 = str_pad($periodo1,2,"0",STR_PAD_LEFT);
  $ano = $_POST['ano'];
  $cuenta = $_POST['cuenta'];
  $unidad = $_POST['unidad'];
  $sigla = $_POST['sigla'];
  $query = "SELECT saldo, debito, credito, cheques, libros FROM cx_con_ban WHERE unidad='$unidad' AND periodo='$periodo' AND ano='$ano' AND cuenta='$cuenta'";
  $cur = odbc_exec($conexion, $query);
  $total = odbc_num_rows($cur);
  if ($total > 0)
  {
    $extracto = odbc_result($cur,1);
    $debito = odbc_result($cur,2);
    $credito = odbc_result($cur,3);
    $cheques = odbc_result($cur,4);
    $libros = odbc_result($cur,5);
  }
  else
  {
    $extracto = "0.00";
    $debito = "0.00";
    $credito = "0.00";
    $cheques = "0.00";
    $libros = "0.00";
  }
  if ($cuenta == "1")
  {
    $query1 = "SELECT saldo FROM cx_sal_uni WHERE unidad='$unidad' AND periodo='$periodo' AND ano='$ano'";
    $cur1 = odbc_exec($conexion, $query1);
    $total1 = odbc_num_rows($cur1);
  }
  else
  {
    $query1 = "SELECT saldo FROM cx_sal_cue WHERE conse='$cuenta' AND periodo='$periodo' AND ano='$ano'";
    $cur1 = odbc_exec($conexion, $query1);
    $total1 = odbc_num_rows($cur1);
  }
  if ($total1 > 0)
  {
    $saldo = odbc_result($cur1,1);
  }
  else
  {
    $saldo = "0.00";
  }
  if ($saldo == ".00")
  {
    $saldo = "0.00";
  }
  $salida->salida = $total;
  $salida->saldo = $saldo;
  $salida->extracto = $extracto;
  $salida->debito = $debito;
  $salida->credito = $credito;
  $salida->cheques = $cheques;
  $salida->libros = $libros;
  echo json_encode($salida);
}
// 06/12/2024 - Ajuste envio unidad desde administrador
?>