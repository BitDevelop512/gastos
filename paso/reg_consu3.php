<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $conse = $_POST['conse'];
  $ano = $_POST['ano'];
  $unidad = $_POST['unidad'];
  $pregunta = "SELECT codigo, directiva, fec_res, fec_hr, fec_ofi, fec_pro, fec_sum, valor, n_ordop, ordop, fec_ord, fragmenta, fec_fra, sintesis, resultado, factor, estructura, observaciones, usuario FROM cx_reg_rec WHERE conse='$conse' AND ano='$ano' AND unidad='$unidad'";
  $sql = odbc_exec($conexion,$pregunta);
  $repositorio = trim(odbc_result($sql,1));
  $directiva = odbc_result($sql,2);
  $fec_res = odbc_result($sql,3);
  $fec_hr = odbc_result($sql,4);
  $fec_ofi = odbc_result($sql,5);
  $fec_pro = odbc_result($sql,6);
  $fec_sum = odbc_result($sql,7);
  $solicitado = trim(odbc_result($sql,8));
  $n_ordop = odbc_result($sql,9);
  $ordop = trim(utf8_encode(odbc_result($sql,10)));
  $fec_ord = odbc_result($sql,11);
  $fragmenta = trim(utf8_encode(odbc_result($sql,12)));
  $fec_fra = odbc_result($sql,13);
  $sintesis = trim(utf8_encode(odbc_result($sql,14)));
  $resultado = trim(utf8_encode(odbc_result($sql,15)));
  $factor = odbc_result($sql,16);
  $pregunta1 = "SELECT nombre FROM cx_ctr_fac WHERE codigo='$factor'";
  $sql1 = odbc_exec($conexion,$pregunta1);
  $n_factor = trim(utf8_encode(odbc_result($sql1,1)));
  $estructura = odbc_result($sql,17);
  $pregunta2 = "SELECT nombre FROM cx_ctr_est WHERE codigo='$estructura'";
  $sql2 = odbc_exec($conexion,$pregunta2);
  $n_estructura = trim(utf8_encode(odbc_result($sql2,1)));
  $observaciones = trim(utf8_encode(odbc_result($sql,18)));
  $usuario = trim(odbc_result($sql,19));
  switch ($directiva)
  {
    case '1':
      $n_directiva = "No. 01 del 17 de Febrero de 2009";
      break;
    case '2':
      $n_directiva = "No. 21 del 5 de Julio de 2011";
      break;
    case '3':
      $n_directiva = "No. 16 del 25 de Mayo de 2012";
      break;
    case '4':
      $n_directiva = "No. 02 del 16 de Enero de 2019";
      break;
    default:
      $n_directiva = "";
      break;
  }
  $pregunta3 = "SELECT fec_rec, resultado, observaciones, conse FROM cx_reg_rev WHERE usuario='$usu_usuario' AND consecu='$conse' AND ano='$ano' ORDER BY fecha DESC";
  $sql3 = odbc_exec($conexion,$pregunta3);
  $total3 = odbc_num_rows($sql3);
  if ($total3 > 0)
  {
    $fec_rec = odbc_result($sql3,1);
    $resultado1 = odbc_result($sql3,2);
    $observaciones1 = trim(utf8_encode(odbc_result($sql3,3)));
    $conse1 = odbc_result($sql3,4);
  }
  else
  {
    $fec_rec = "";
    $resultado1 = "A";
    $observaciones1 = "";
  }
  $pregunta4 = "SELECT resultado FROM cx_reg_rev WHERE consecu='$conse' AND ano='$ano' AND resultado='Y'";
  $sql4 = odbc_exec($conexion,$pregunta4);
  $total4 = odbc_num_rows($sql4);
  // Todas las observaciones
  $pregunta5 = "SELECT fecha, usuario, observaciones FROM cx_reg_rev WHERE consecu='$conse' AND ano='$ano' ORDER BY fecha";
  $sql5 = odbc_exec($conexion,$pregunta5);
  $total5 = odbc_num_rows($sql5);
  $observaciones2 = "";
  if ($total5 > 0)
  {
    $i = 1;
    while($i<$row=odbc_fetch_array($sql5))
    {
      $fec_obs = substr($row['fecha'],0,19);
      $usu_obs = trim($row['usuario']);
      $obs_obs = trim(utf8_encode($row['observaciones']));
      $observaciones2 .= $fec_obs." - ".$usu_obs." - ".$obs_obs."<br>";
      $i++;
    }
  }
  $salida = new stdClass();
  $salida->repositorio = $repositorio;
  $salida->directiva = $directiva;
  $salida->n_directiva = $n_directiva;
  $salida->fec_res = $fec_res;
  $salida->fec_hr = $fec_hr;
  $salida->fec_ofi = $fec_ofi;
  $salida->fec_pro = $fec_pro;
  $salida->fec_sum = $fec_sum;
  $salida->solicitado = $solicitado;
  $salida->n_ordop = $n_ordop;
  $salida->ordop = $ordop;
  $salida->fec_ord = $fec_ord;
  $salida->fragmenta = $fragmenta;
  $salida->fec_fra = $fec_fra;
  $salida->sintesis = $sintesis;
  $salida->resultado = $resultado;
  $salida->factor = $n_factor;
  $salida->estructura = $n_estructura;
  $salida->observaciones = $observaciones;
  $salida->usuario = $usuario;
  $salida->fec_rec = $fec_rec;
  $salida->resultado1 = $resultado1;
  $salida->observaciones1 = $observaciones1;
  $salida->conse1 = $conse1;
  $salida->revision = $total3;
  $salida->reversa = $total4;
  $salida->observaciones2 = $observaciones2;
  echo json_encode($salida);
}
?>