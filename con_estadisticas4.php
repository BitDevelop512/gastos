<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
  $periodo1 = $_POST['periodo1'];
  $periodo2 = $_POST['periodo2'];
  $ano = $_POST['ano'];
  $unidad = $_POST['unidad'];
  $unidades = stringArray1($unidad);
  $longitud = explode(",",$unidades);
  $recurso = $_POST['recurso'];
  $recursos = stringArray1($recurso);
  if ($recursos == "0")
  {
    $recursos = "1, 2, 3, 4, 5";
  }
  $longitud1 = explode(",",$recursos);
  $valores = "";
  $valores1 = "";
  $valores2 = "";
  $tot_gastos = "0";
  $tot_informaciones = "0";
  $tot_recompensas = "0";
  $tot_proteccion = "0";
  $tot_cobertura = "0";
  for ($j=0; $j<count($longitud); $j++)
  {
    $valor = $longitud[$j];
    $pregunta0 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$valor'";
    $cur0 = odbc_exec($conexion, $pregunta0);
    $sigla = trim(odbc_result($cur0,1));
    $valores .= '"'.$sigla.'", ';
    for ($l=0; $l<count($longitud1); $l++)
    {
      $valor1 = trim($longitud1[$l]);
      if ($valor1 == "1")
      {
        // Gastos en actividades
        // Egresos
        $pregunta1 = "SELECT ISNULL(SUM(debito), 0) AS debito FROM cv_lib_ban WHERE unidad='$valor' AND tipo1='2' AND tp_gas='1' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano'";
        $cur1 = odbc_exec($conexion, $pregunta1);
        $total1 = odbc_result($cur1,1);
        if ($total1 == ".00")
        {
          $total1 = "0";
        }
        // Ingresos
        $pregunta4 = "SELECT ISNULL(SUM(credito), 0) AS credito FROM cv_lib_ban WHERE unidad='$valor' AND concepto  IN ('11', '16') AND tipo1='1' AND tp_gas='1' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano'";
        $cur4 = odbc_exec($conexion, $pregunta4);
        $total4 = odbc_result($cur4,1);
        if ($total4 == ".00")
        {
          $total4 = "0";
        }
        $tot_gastos = $total1-$total4;
        $valores1 .= "Gastos en Actividades, ";
        $valores2 .= $tot_gastos.", ";
      }
      if ($valor1 == "2")
      {
        // Pago de informaciones
        // Egresos
        $pregunta2 = "SELECT ISNULL(SUM(debito), 0) AS debito FROM cv_lib_ban WHERE unidad='$valor' AND tipo1='2' AND tp_gas='2' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano'";
        $cur2 = odbc_exec($conexion, $pregunta2);
        $total2 = odbc_result($cur2,1);
        if ($total2 == ".00")
        {
          $total2 = "0";
        }
        // Ingresos
        $pregunta5 = "SELECT ISNULL(SUM(credito), 0) AS credito FROM cv_lib_ban WHERE unidad='$valor' AND concepto  IN ('11', '16') AND tipo1='1' AND tp_gas='2' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano'";
        $cur5 = odbc_exec($conexion, $pregunta5);
        $total5 = odbc_result($cur5,1);
        if ($total5 == ".00")
        {
          $total5 = "0";
        }
        $tot_informaciones = $total2-$total5;
        $valores1 .= "Pago de Informaciones, ";
        $valores2 .= $tot_informaciones.", ";
      }
      if ($valor1 == "3")
      {
        // Pago de Pago de recompensas
        // Egresos
        $pregunta3 = "SELECT ISNULL(SUM(debito), 0) AS debito FROM cv_lib_ban WHERE unidad='$valor' AND tipo1='2' AND tp_gas='3' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano'";
        $cur3 = odbc_exec($conexion, $pregunta3);
        $total3 = odbc_result($cur3,1);
        if ($total3 == ".00")
        {
          $total3 = "0";
        }
        // Ingresos
        $pregunta6 = "SELECT ISNULL(SUM(credito), 0) AS credito FROM cv_lib_ban WHERE unidad='$valor' AND concepto  IN ('11', '16') AND tipo1='1' AND tp_gas='13' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano'";
        $cur6 = odbc_exec($conexion, $pregunta6);
        $total6 = odbc_result($cur6,1);
        if ($total6 == ".00")
        {
          $total6 = "0";
        }
        $tot_recompensas = $total3-$total6;
        $valores1 .= "Pago de Recompensas, ";
        $valores2 .= $tot_recompensas.", ";
      }
      // Gastos de Proteccion
      if ($valor1 == "4")
      {
        $tot_proteccion = "0";
        $valores1 .= "Gastos de Proteccion, ";
        $valores2 .= $tot_proteccion.", ";
      }
      // Gastos de Cobertura
      if ($valor1 == "5")
      {
        $tot_cobertura = "0";
        $valores1 .= "Gastos de Cobertura, ";
        $valores2 .= $tot_cobertura.", ";
      }
    }
    $valores1 = substr($valores1, 0, -2);
    $valores1 = $valores1."#";
    $valores2 = substr($valores2, 0, -2);
    $valores2 = $valores2."#";
  }
  $valores1 = substr($valores1, 0, -1);


  $longitud2 = explode("#",$valores2);
  for ($n=0; $n<count($longitud2)-1; $n++)
  {
    $paso = $longitud2[$n];
    $longitud3 = explode(",",$paso);
    for ($p=0; $p<count($longitud3); $p++)
    {
      switch ($p)
      {
        case '0':
          $var0 .= $longitud3[$p].", ";
          $col0 = "7CB5EC";
          break;
        case '1':
          $var1 .= $longitud3[$p].", ";
          $col1 = "434348";
          break;
        case '2':
          $var2 .= $longitud3[$p].", ";
          $col2 = "90ED7D";
          break;
        case '3':
          $var3 .= $longitud3[$p].", ";
          $col3 = "F7A35C";
          break;
        case '4':
          $var4 .= $longitud3[$p].", ";
          $col4 = "8085E9";
          break;
        default:
          $var99 .= ", ";
          $col99 = "CCCCCC";
          break;
      }
    }
  }
  $var0 = substr($var0, 0, -2);
  $var1 = substr($var1, 0, -2);
  $var2 = substr($var2, 0, -2);
  $var3 = substr($var3, 0, -2);
  $var4 = substr($var4, 0, -2);
  $valores3 = $var0."#".$var1."#".$var2."#".$var3."#".$var4;
  $valores4 = $col0."#".$col1."#".$col2."#".$col3."#".$col4;
  $valores = substr($valores, 0, -2);
  $salida->datos = $valores;
  $salida->datos1 = $valores1;
  $salida->datos2 = $valores2;
  $salida->datos3 = $valores3;
  $salida->datos4 = $valores4;
  echo json_encode($salida);
}
?>