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
    list($var3, $var4, $var5) = explode("¬", $mision);
    $var3 = trim($var3);
  }
  else
  {
    if ($num_valores1 == "4")
    {
      list($var2, $var3, $var4, $var5) = explode("¬", $mision);
      $var3 = trim($var2)."-".trim($var3);
    }
    else
    {
      list($var2, $var3, $var4, $var5) = explode("¬", $mision);
      $var3 = trim($var2)."-".trim($var3);
    }
  }
  $var5 = trim($var5);
  $n_ordop = trim($_POST['valor3']);
  list($var1, $var2) = explode(" ", $n_ordop);
  $var1 = trim($var1);
  $query = "SELECT area, fechai, fechaf, valor_a FROM cx_pla_gas WHERE mision='$var3' AND conse1='$conse' AND interno='$var5' AND unidad='$uni_usuario' AND ano='$ano'";
  $sql = odbc_exec($conexion,$query);
  $contador1 = odbc_num_rows($sql);
  if ($contador1 == "0")
  {
    $query = "SELECT area, fechai, fechaf, valor_a FROM cx_pla_gas WHERE conse1='$conse' AND interno='$var5' AND unidad='$uni_usuario' AND ano='$ano'";
    $sql = odbc_exec($conexion,$query);
    $contador1 = odbc_num_rows($sql);
  }
  $area = trim(utf8_encode(odbc_result($sql,1)));
  $fecha1 = trim(odbc_result($sql,2));
  $fecha2 = trim(odbc_result($sql,3));
  $valor = trim(odbc_result($sql,4));
  $var6 = utf8_decode($var3);
  $query1 = "SELECT factor FROM cx_pla_gas WHERE conse1='$conse' AND unidad='$uni_usuario' AND ano='$ano' AND mision='$var6' AND interno='$var5'";
  $sql1 = odbc_exec($conexion,$query1);
  $factor = odbc_result($sql1,1);
  $query2 = "SELECT nombre FROM cx_ctr_fac WHERE codigo IN ($factor)";
  $sql2 = odbc_exec($conexion,$query2);
  $factores = "";
  while($i<$row=odbc_fetch_array($sql2))
  {
    $factores .= utf8_encode(trim(odbc_result($sql2,1))).",";
  }
  $factores = substr($factores,0,-1);
  $salida->area = $area;
  $salida->fecha1 = $fecha1;
  $salida->fecha2 = $fecha2;
  $salida->valor = $valor;
  $salida->factores = $factores;
  echo json_encode($salida);
}
?>