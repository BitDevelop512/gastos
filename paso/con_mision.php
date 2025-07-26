<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
// Si no es peticion ajax no se ejecuta
if (is_ajax())
{
  $ano = date('Y');
  $ordop = trim($_POST['valor']);
  $conse = trim($_POST['valor1']);
  $mision = trim($_POST['valor2']);
  $num_valores = explode("¬", $mision);
  $num_valores1 = count($num_valores);
  if ($num_valores1 == "3")
  {
    list($mision1, $mision2, $mision3) = explode("¬", $mision);
    $mision1 = trim($mision1);
  }
  else
  {
    list($mision0, $mision1, $mision2, $mision3) = explode("¬", $mision);
    $mision1 = trim($mision0)."-".trim($mision1);
  }
  $mision2 = trim($mision2);
  $mision3 = trim($mision3);
  $mision4 = trim($_POST['valor3']);
  list($mision5, $mision6) = explode(" ", $mision4);
  // Se consulta compañia del usuario
  $query0 = "SELECT tipo FROM cx_usu_web WHERE usuario='$usu_usuario'";
  $cur0 = odbc_exec($conexion, $query0);
  $compania = odbc_result($cur0,1);
  // Se consulta fechas de la mision
  $query = "SELECT fechai, fechaf, interno, valor_a FROM cx_pla_gas WHERE mision='$mision1' AND conse1='$conse' AND interno='$mision3' AND unidad='$uni_usuario' AND ano='$ano'";
  $sql = odbc_exec($conexion,$query);
  $total = odbc_num_rows($sql);
  if ($total == "0")
  {
    $query = "SELECT fechai, fechaf, interno, valor_a FROM cx_pla_gas WHERE conse1='$conse' AND interno='$mision3' AND unidad='$uni_usuario' AND ano='$ano'";
    $sql = odbc_exec($conexion,$query);
    $total = odbc_num_rows($sql);
  }
  $fecha1 = odbc_result($sql,1);
  $fecha2 = odbc_result($sql,2);
  $interno = odbc_result($sql,3);
  $valor1 = odbc_result($sql,4);
  $f1 = strtotime($fecha2)-strtotime($fecha1);
  $f2 = intval($f1/60/60/24);
  $f2 = $f2+1;
  $dias = trim($fecha1)." - ".trim($fecha2);
  // Se obtiene el mes de la fecha inical de la mision
  list($v_dia, $v_mes, $v_ano) = explode("/", $fecha1);
  $periodo = $v_mes;
  $periodo = intval($periodo);
  // Se consulta el valor de los gastos basicos
  $query0 = "SELECT valor FROM cx_pla_gad WHERE conse1='$conse' AND interno='$interno' AND gasto='1' AND unidad='$uni_usuario' AND ano='$ano'";
  $sql0 = odbc_exec($conexion,$query0);
  while($j<$row=odbc_fetch_array($sql0))
  {
    $v_valor = trim(odbc_result($sql0,1));
    $v_valor1 = str_replace(',','',$v_valor);
    $v_valor1 = substr($v_valor1,0,-3);
    $v_valor1 = intval($v_valor1);
    $v_total = $v_total+$v_valor1;
    $j++;
  }
  $v_total = number_format($v_total,2);
  $valor = $v_total;
  // Se consulta el valor de todas las planillas
  $mision5 = trim($mision5);
  $mision5 = str_replace("«", "", $mision5);
  if ($mision5 == "«")
  {
    $mision5 = "";
  }
  // Ajuste consulta de Ñ
  $ordop = utf8_decode($ordop);
  $mision1 = utf8_decode($mision1);
  $periodo1 = intval($periodo)+1;
  $query1 = "SELECT total FROM cx_gas_bas WHERE ordop='$ordop' AND n_ordop='$mision5' AND mision='$mision1' AND numero='$interno' AND unidad='$uni_usuario' AND periodo IN ('$periodo','$periodo1') AND ano='$ano' AND usuario='$usu_usuario' AND solicitud='$mision2'";
  $sql1 = odbc_exec($conexion,$query1);
  $contador1 = odbc_num_rows($sql1);
  if ($contador1 == "0")
  {
    $mision_n = substr($mision1,0,3);
    $mision_m = substr($mision1,-3);
    $query1 = "SELECT total FROM cx_gas_bas WHERE ordop='$ordop' AND n_ordop='$mision5' AND mision LIKE '%$mision_m' AND numero='$interno' AND unidad='$uni_usuario' AND periodo='$periodo' AND usuario='$usu_usuario' AND ano='$ano' AND solicitud='$mision2'";
    $sql1 = odbc_exec($conexion,$query1);
    $contador1 = odbc_num_rows($sql1);
  	if ($contador1 == "0")
  	{
		$ordop_n = explode('"',$ordop);
		$ordop_n = $ordop_n[0];
		$ordop_n = explode('Ñ',$ordop_n);
		$ordop_n = $ordop_n[0];
  		$query1 = "SELECT total FROM cx_gas_bas WHERE ordop LIKE '$ordop_n%' AND n_ordop='$mision5' AND mision='$mision1' AND numero='$interno' AND unidad='$uni_usuario' AND periodo='$periodo' AND usuario='$usu_usuario' AND ano='$ano' AND solicitud='$mision2'";
    	$sql1 = odbc_exec($conexion,$query1);
    	$contador1 = odbc_num_rows($sql1);
    }
  }
  if ($contador1 > 0)
  {
    $total = "";
    while($i<$row=odbc_fetch_array($sql1))
    {
      $total .= trim(odbc_result($sql1,1))."#";
    }
    $total = substr($total,0,-1);
  }
  else
  {
    $total = "0";
  }
  $salida->salida = $f2;
  $salida->dias = $dias;
  $salida->aprobado = $valor;
  $salida->total = $total;
  $salida->periodo = $periodo;
  echo json_encode($salida);
}
?>