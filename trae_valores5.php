<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ano = $_POST['ano'];
  $tipo = $_POST['tipo'];
  $mes = $_POST['periodo'];
  // Se consultan todas las unidades que estan en la centralizadora
  $query0 = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario' AND unic='1'";
  $cur0 = odbc_exec($conexion, $query0);
  $n_unidad = odbc_result($cur0,1);
  $n_dependencia = odbc_result($cur0,2);
  if (($n_unidad == "1") and ($n_dependencia == "1"))
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE (unidad='$n_unidad' OR dependencia='$n_dependencia') ORDER BY dependencia, subdependencia";
  }
  else
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' ORDER BY dependencia, subdependencia";
  }
  $cur1 = odbc_exec($conexion, $query1);
  $numero = "";
  while($i<$row=odbc_fetch_array($cur1))
  {
    $numero .= "'".odbc_result($cur1,1)."',";
  }
  $numero = substr($numero,0,-1);
  // Se consultan todas las unidades de la centralizadora
  $query2 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
  $cur2 = odbc_exec($conexion, $query2);
  $numero1 = "";
  while($i<$row=odbc_fetch_array($cur2))
  {
    $numero1 .= "'".odbc_result($cur2,1)."',";
  }
  $numero1 = substr($numero1,0,-1);
  $valida1 = "0";
  // Se consulta informacion de solicitud de recursos aprobadas
  if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
  {
    $numeros = $numero;
  }
  else
  {
    $numeros = $numero1;
    $valida1 = "0";
    // Se verifica si es unidad centralizadora especial
    if (strpos($especial, $uni_usuario) !== false)
    {
      $numero1 = "";
      $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$nun_usuario' ORDER BY unidad";   
      $cur = odbc_exec($conexion, $query);
      while($i<$row=odbc_fetch_array($cur))
      {
        $n_unidad = odbc_result($cur,1);
        $n_dependencia = odbc_result($cur,2);
        $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
        $cur1 = odbc_exec($conexion, $query1);
        while($j<$row=odbc_fetch_array($cur1))
        {
          $numero1 .= "'".odbc_result($cur1,1)."',";
        }
      }
      $numero1 = substr($numero1,0,-1);
      $numero1 = trim($numero1);
      if ($numero1 == "")
      {
      }
      else
      {
        $numeros .= ",".$numero1;
      }
    }
  }
  $query = "SELECT conse, actual, unidad, tipo1 FROM cx_pla_inv WHERE periodo='$mes' AND ano='$ano' AND tipo='2' AND tipo1='$tipo' AND estado='W' AND aprueba='0' AND unidad IN ($numeros) ORDER BY conse";
  $cur = odbc_exec($conexion, $query);
  $datos = "";
  while($i<$row=odbc_fetch_array($cur))
  {
    $interno = odbc_result($cur,1);
    $actual = odbc_result($cur,2);
    $unidad = odbc_result($cur,3);
    $tipo1 = odbc_result($cur,4);
    if ($actual == "1")
    {
      $query1 = "SELECT valor_a FROM cx_pla_gas WHERE conse1='$interno' AND ano='$ano'";
    }
    else
    {
      if (($actual == "9") and ($tipo1 == "1"))
      {
        $query1 = "SELECT valor_a FROM cx_pla_gas WHERE conse1='$interno' AND ano='$ano'";
      }
      else
      {
        $query1 = "SELECT val_fuen_a FROM cx_pla_pag WHERE conse='$interno' AND ano='$ano'";
      }
    }
    $cur1 = odbc_exec($conexion, $query1);
    $v_total = 0;
    while($j<$row=odbc_fetch_array($cur1))
    {
      $v_valor = trim(odbc_result($cur1,1));
      $v_valor1 = str_replace(',','',$v_valor);
      $v_valor1 = trim($v_valor1);
      $v_valor1 = floatval($v_valor1);
      $v_total = $v_total+$v_valor1;
      $j++;
    }
    $total = $v_total;
    $total = number_format($total, 2);
    // Se consulta sigla unidad que genero la solicitud
    $hoy = date('Y-m-d');
    $query2 = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unidad'";
    $cur2 = odbc_exec($conexion, $query2);
    $sigla = trim(odbc_result($cur2,1));
    $n_sigla = trim(odbc_result($cur2,2));
    $n_fecha = trim(odbc_result($cur2,3));
    if ($n_fecha == "")
    {
    }
    else
    {
      $n_fecha = str_replace("/", "-", $n_fecha);
      if ($hoy >= $n_fecha)
      {
        $sigla = $n_sigla;
      }
    }
    $datos .= $sigla."|".$total."|".$interno."#";
  }
  $salida = new stdClass();
  $salida->datos = $datos;
  $salida->valida1 = $valida1;
	echo json_encode($salida);
}
// 12/09/2023 - Ajuste cambio de sigla
// 18/11/2024 - Ajuste version 2
// 28/02/2025 - Ajuste DINCI
?>