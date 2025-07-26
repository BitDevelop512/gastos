<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $periodo = $_POST['periodo'];
  $ano = $_POST['ano'];
  // Se actualizan campos en blanco en la tabla cx_val_aut
  $query0 = "SELECT conse, depen FROM cx_val_aut WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND n_depen=''";
  $sql0 = odbc_exec($conexion, $query0);
  $total0 = odbc_num_rows($sql0);
  if ($total0 > 0)
  {
    $i = 0;
    while($i<$row=odbc_fetch_array($sql0))
    {
      $interno = odbc_result($sql0,1);
      $depen = odbc_result($sql0,2);
      $pregunta = "SELECT nombre FROM cx_org_dep WHERE dependencia='$depen'";
      $ejecuta = odbc_exec($conexion, $pregunta);
      $nombre = trim(odbc_result($ejecuta,1));
      $pregunta1 = "UPDATE cx_val_aut SET n_depen='$nombre' WHERE conse='$interno'";
      $ejecuta1 = odbc_exec($conexion, $pregunta1);
    }
  }
  $query0 = "SELECT conse, uom FROM cx_val_aut WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND n_uom=''";
  $sql0 = odbc_exec($conexion, $query0);
  $total0 = odbc_num_rows($sql0);
  if ($total0 > 0)
  {
    $i = 0;
    while($i<$row=odbc_fetch_array($sql0))
    {
      $interno = odbc_result($sql0,1);
      $uom = odbc_result($sql0,2);
      $pregunta = "SELECT nombre FROM cx_org_uni WHERE unidad='$uom'";
      $ejecuta = odbc_exec($conexion, $pregunta);
      $nombre = trim(odbc_result($ejecuta,1));
      $pregunta1 = "UPDATE cx_val_aut SET n_uom='$nombre' WHERE conse='$interno'";
      $ejecuta1 = odbc_exec($conexion, $pregunta1);
    }
  }
  // Se actualizan los campos de unidad centralizadora
  $query0 = "SELECT conse, unidad, uom, depen FROM cx_val_aut WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND centra='0' AND centra1='0'";
  $sql0 = odbc_exec($conexion, $query0);
  $total0 = odbc_num_rows($sql0);
  if ($total0 > 0)
  {
    $i = 0;
    while($i<$row=odbc_fetch_array($sql0))
    {
      $interno = odbc_result($sql0,1);
      $unidad = odbc_result($sql0,2);
      $uom = odbc_result($sql0,3);
      $depen = odbc_result($sql0,4);
      $pregunta = "SELECT unic FROM cx_org_sub WHERE subdependencia='$unidad'";
      $ejecuta = odbc_exec($conexion, $pregunta);
      $centra = odbc_result($ejecuta,1);
      if ($centra == "1")
      {
          $pregunta1 = "UPDATE cx_val_aut SET centra='1', centra1='$unidad' WHERE conse='$interno' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND centra='0' AND centra1='0'";
          $ejecuta1 = odbc_exec($conexion, $pregunta1);
      }
      else
      {
        if ($uom <= 3)
        {
          $pregunta = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$uom' AND dependencia='$depen' AND unic='1'";
          $ejecuta = odbc_exec($conexion, $pregunta);
          $centra = odbc_result($ejecuta,1);
        }
        else
        {
          $pregunta = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$uom' AND unic='1'";
          $ejecuta = odbc_exec($conexion, $pregunta);
          $centra = odbc_result($ejecuta,1);
        }
        $pregunta1 = "UPDATE cx_val_aut SET centra='0', centra1='$centra' WHERE conse='$interno' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND centra='0' AND centra1='0'";
        $ejecuta1 = odbc_exec($conexion, $pregunta1);
      }
    }
  }
  // Se actualizan las unidades especiales
  $query0 = "SELECT unidad, dependencia, especial FROM cx_org_sub WHERE especial>0 ORDER BY unidad";
  $sql0 = odbc_exec($conexion, $query0);
  $total0 = odbc_num_rows($sql0);
  if ($total0 > 0)
  {
    $i = 0;
    while($i<$row=odbc_fetch_array($sql0))
    {
      $n_unidad = odbc_result($sql0,1);
      $n_dependencia = odbc_result($sql0,2);
      $n_especial = odbc_result($sql0,3);
      $query1 = "SELECT subdependencia, unidad FROM cx_org_sub WHERE unidad='$n_especial' AND unic='1'";
      $sql1 = odbc_exec($conexion, $query1);
      $n_subdependencia = odbc_result($sql1,1);
      $n_uom = trim(odbc_result($sql1,2));
      $query2 = "SELECT nombre FROM cx_org_uni WHERE unidad='$n_uom'";
      $sql2 = odbc_exec($conexion, $query2);
      $n_sigla = trim(odbc_result($sql2,1));
      $query3 = "UPDATE cx_val_aut SET uom='$n_especial', n_uom='$n_sigla', centra1='$n_subdependencia', aprueba1='$n_unidad' WHERE uom='$n_unidad' AND aprueba1='0' AND periodo='$periodo' AND ano='$ano' AND estado='V'";
      $sql3 = odbc_exec($conexion, $query3);
    }
  }
  // Se actualizan unidades centralizadoras especiales
  $query0 = "SELECT subdependencia FROM cx_org_sub WHERE unic='1' AND especial!=0 ORDER BY subdependencia";
  $sql0 = odbc_exec($conexion, $query0);
  $nocentra = "";
  $i = 0;
  while($i<$row=odbc_fetch_array($sql0))
  {
    $nocentra .= odbc_result($sql0,1).",";
  }
  $nocentra = substr($nocentra,0,-1);
  $query0 = "UPDATE cx_val_aut SET centra='0' WHERE unidad IN ($nocentra) AND periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0'";
  $sql0 = odbc_exec($conexion, $query0);
  // Se actualizan unidades rechazadas
  $query0 = "UPDATE cx_val_aut SET periodo='0' WHERE unidad='999' AND periodo='$periodo' AND ano='$ano' AND inf_giro='0'";
  $sql0 = odbc_exec($conexion, $query0);
  // Se consultan valores para generar informe de giro
	$query = "SELECT sum(gastos) as gastos, sum(pagos) as pagos, sum(total) as total FROM cx_val_aut WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND aprueba1>0 AND EXISTS(SELECT * FROM cx_inf_uni WHERE periodo='$periodo' AND ano='$ano' AND aprueba3>0 AND cx_val_aut.uom=cx_inf_uni.unidad)";
	$sql = odbc_exec($conexion, $query);
  // Total Unidades
  $query1 = "SELECT unidad, sigla, depen, n_depen, gastos, pagos, total, conse, centra, centra1, uom FROM cx_val_aut WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND aprueba1>0 AND EXISTS(SELECT * FROM cx_inf_uni WHERE periodo='$periodo' AND ano='$ano' AND aprueba3>0 AND cx_val_aut.uom=cx_inf_uni.unidad) ORDER BY uom, depen, unidad";
  $sql1 = odbc_exec($conexion, $query1);
  $total1 = odbc_num_rows($sql1);
  // Se declara salida de datos
  $salida = new stdClass();
  if ($total1 == "0")
  {
    $salida->giro = $total1;
    $salida->gastos = "0";
    $salida->pagos = "0";
    $salida->total = "0";
  }
  else
  {
    $total_gas = 0;
    $i = 1;
    while ($i < $row = odbc_fetch_array($sql1))
    {
      $gasto = $row['gastos'];
      if ($gasto == ".00")
      {
        $gasto = "0.00";
      }
      $pago = $row['pagos'];
      if ($pago == ".00")
      {
        $pago = "0.00";
      }
      $total = $row['total'];
      if ($total == ".00")
      {
        $total = "0.00";
      }
      $salida->rows[$i]['conse'] = $row['conse'];
      $salida->rows[$i]['unidad'] = $row['unidad'];
      $salida->rows[$i]['sigla'] = trim($row['sigla']);
      $salida->rows[$i]['depen'] = $row['depen'];
      $salida->rows[$i]['n_depen'] = trim($row['n_depen']);
      $salida->rows[$i]['centra'] = $row['centra'];
      $salida->rows[$i]['centra1'] = $row['centra1'];
      $salida->rows[$i]['uom'] = $row['uom'];
      $salida->rows[$i]['t_gastos'] = $gasto;
      $salida->rows[$i]['t_pagos'] = $pago;
      $salida->rows[$i]['t_total'] = $total;
      $i++;
    }
    // Total Unidades Centralizadores Especializada
    $query2 = "SELECT count(1) as contador, depen, n_depen, sum(gastos) as gastos, sum(pagos) as pagos, sum(total) as total FROM cx_val_aut WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND aprueba1>0 AND uom<=3 GROUP BY depen, n_depen ORDER BY depen";
    $sql2 = odbc_exec($conexion, $query2);
    $total2 = odbc_num_rows($sql2);
    $j = 1;
    $k = 1;
    $paso_f = "";
    while ($j < $row = odbc_fetch_array($sql2))
    {
      $paso1 = $row['depen'];
      $paso2 = trim($row['n_depen']);
      $paso3 = $row['gastos'];
      if ($paso3 == ".00")
      {
        $paso3 = "0.00";
      }
      $paso4 = $row['pagos'];
      if ($paso4 == ".00")
      {
        $paso4 = "0.00";
      }
      $paso5 = $row['total'];
      if ($paso5 == ".00")
      {
        $paso5 = "0.00";
      }
      $paso3 = floatval($paso3);
      $paso3 = $paso3-$paso_valor;
      $paso4 = floatval($paso4);
      $paso5 = floatval($paso5);
      $paso5 = $paso5-$paso_valor;
      $paso_f .= $paso1."|".$paso2."|".$paso3."|".$paso4."|".$paso5."#";
      $j++;
    }
    // Total Unidades Centralizadoras Abiertas
    $query3 = "SELECT count(1) as contador, uom, n_uom, sum(gastos) as gastos, sum(pagos) as pagos, sum(total) as total FROM cx_val_aut WHERE periodo='$periodo' AND ano='$ano' AND estado='V' AND inf_giro='0' AND aprueba1>0 AND uom>3 GROUP BY uom, n_uom ORDER BY uom";
    $sql3 = odbc_exec($conexion, $query3);
    $total3 = odbc_num_rows($sql3);
    $j = 1;
    $k = 1;
    $paso_f1 = "";
    while ($j < $row = odbc_fetch_array($sql3))
    {
      $paso1 = $row['uom'];
      $paso2 = trim($row['n_uom']);
      $paso3 = $row['gastos'];
      if ($paso3 == ".00")
      {
        $paso3 = "0.00";
      }
      $paso4 = $row['pagos'];
      if ($paso4 == ".00")
      {
        $paso4 = "0.00";
      }
      $paso5 = $row['total'];
      if ($paso5 == ".00")
      {
        $paso5 = "0.00";
      }
      // Se consultan unidades de la dependencia
      $pregunta2 = "SELECT subdependencia, dependencia FROM cx_org_sub WHERE unidad='$paso1' AND unic='1' ORDER BY subdependencia";
      $cur2 = odbc_exec($conexion, $pregunta2);
      $numero = "";
      while($i<$row=odbc_fetch_array($cur2))
      {
        $numero.="'".odbc_result($cur2,1)."',";
        $numero1 = odbc_result($cur2,2);
      }
      $numero = substr($numero,0,-1);
      $paso3 = floatval($paso3);
      $paso3 = $paso3-$paso_valor;
      $paso4 = floatval($paso4);
      $paso5 = floatval($paso5);
      $paso5 = $paso5-$paso_valor;
      $paso_f1 .= $numero1."|".$paso2."|".$paso3."|".$paso4."|".$paso5."#";
      $j++;
    }
    $gastos = odbc_result($sql,1);
    if ($gastos == ".00")
    {
      $gastos = "0.00";
    }
    $pagos = odbc_result($sql,2);
    if ($pagos == ".00")
    {
      $pagos = "0.00";
    }
    $total = odbc_result($sql,3);
    if ($total == ".00")
    {
      $total = "0.00";
    }
    $salida->giro = $total1;
    $salida->gastos = ($gastos-$total_gas);
    $salida->pagos = $pagos;
    $salida->total = ($total-$total_gas);
    $salida->centra = $total2+$total3;
    $salida->centraliza = $paso_f.$paso_f1;
  }
  echo json_encode($salida);
}
?>