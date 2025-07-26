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
  $pago = $_POST['pago'];
  $pagos = stringArray1($pago);
  if ($pagos == "0")
  {
    $pagos = "";
    $query = "SELECT * FROM cx_ctr_pag WHERE tipo!='R' ORDER BY codigo";
    $sql = odbc_exec($conexion, $query);
    $i=0;
    while($i<$row=odbc_fetch_array($sql))
    {
      $pagos .= odbc_result($sql,1).", ";
      $i++;
    }
    $pagos = substr($pagos, 0, -2);
  }
  $longitud1 = explode(",",$pagos);
  $valores = "";
  $valores1 = "";
  $valores2 = "";
  $valores3 = "";
  for ($j=0; $j<count($longitud); $j++)
  {
    $valor = $longitud[$j];
    $pregunta = "SELECT conse, consecu, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_rel_gas.unidad) AS n_unidad FROM cx_rel_gas WHERE unidad='$valor' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' ORDER BY conse";
    $cur = odbc_exec($conexion, $pregunta);
    $total = odbc_num_rows($cur);
    $total = intval($total);
    if ($total > 0)
    {
      $k = 0;
      $conses = "";
      $consecus = "";
      while($k<$row=odbc_fetch_array($cur))
      {
        $v1 = odbc_result($cur,1);
        $v2 = odbc_result($cur,2);
        $v3 = trim(odbc_result($cur,3));
        $conses .= $v1.",";
        $consecus .= $v2.",";
        $k++;
      }
      $conses = substr($conses, 0, -1);
      $consecus = substr($consecus, 0, -1);
      for ($l=0; $l<count($longitud1); $l++)
      {
        $valor1 = trim($longitud1[$l]);
        $pregunta1 = "SELECT gasto, SUM(valor1) AS valor, (SELECT nombre FROM cx_ctr_pag WHERE cx_ctr_pag.codigo=cx_rel_dis.gasto) AS n_gasto FROM cx_rel_dis WHERE conse1 IN ($conses) AND consecu IN ($consecus) AND gasto='$valor1' GROUP BY gasto";
        $cur1 = odbc_exec($conexion, $pregunta1);
        $total1 = odbc_num_rows($cur1);
        $total1 = intval($total1);
        if ($total1 > 0)
        {
          $m = 0;
          while($m<$row=odbc_fetch_array($cur1))
          {
            $v4 = odbc_result($cur1,2);
            $v5 = number_format($v4, 2);
            $v6 = trim(utf8_encode(odbc_result($cur1,3)));
            $v6 = str_replace(",", "", $v6);
            $m++;
          }
        }
        else
        {
          $pregunta1 = "SELECT ".$valor." AS gasto, 0 AS valor, nombre AS n_gasto FROM cx_ctr_pag WHERE codigo='$valor1'";
          $cur1 = odbc_exec($conexion, $pregunta1);
          $v4 = odbc_result($cur1,2);
          $v5 = number_format($v4, 2);
          $v6 = trim(utf8_encode(odbc_result($cur1,3)));
          $v6 = str_replace(",", "", $v6);
        }
        $valores1 .= $v4.", ";
        $valores2 .= $v5.", ";
        $valores3 .= $v6.", ";
      }
      $valores .= '"'.$v3.'", ';
      $valores1 = substr($valores1, 0, -2);
      $valores1 = $valores1."#";
      $valores2 = substr($valores2, 0, -2);
      $valores2 = $valores2."#";
      $valores3 = substr($valores3, 0, -2);
      $valores3 = $valores3."#";
    }
  }
  $valores = substr($valores, 0, -2);
  $valores1 = substr($valores1, 0, -1);
  $valores2 = substr($valores2, 0, -1);
  $valores3 = substr($valores3, 0, -1);
  $longitud2 = explode("#",$valores1);
  for ($n=0; $n<count($longitud2); $n++)
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
        case '5':
          $var5 .= $longitud3[$p].", ";
          $col5 = "F15C80";
          break;
        case '6':
          $var6 .= $longitud3[$p].", ";
          $col6 = "E4D354";
          break;
        case '7':
          $var7 .= $longitud3[$p].", ";
          $col7 = "2B908F";
          break;
        case '8':
          $var8 .= $longitud3[$p].", ";
          $col8 = "F45B5B";
          break;
        case '9':
          $var9 .= $longitud3[$p].", ";
          $col9 = "30F7E8";
          break;
        case '10':
          $var10 .= $longitud3[$p].", ";
          $col10 = "4572A7";
          break;
        case '11':
          $var11 .= $longitud3[$p].", ";
          $col11 = "AA4643";
          break;
        case '12':
          $var12 .= $longitud3[$p].", ";
          $col12 = "89A54E";
          break;
        case '13':
          $var13 .= $longitud3[$p].", ";
          $col13 = "FF9933";
          break;
        case '14':
          $var14 .= $longitud3[$p].", ";
          $col14 = "7CB5EC";
          break;
        case '15':
          $var15 .= $longitud3[$p].", ";
          $col15 = "434348";
          break;
        case '16':
          $var16 .= $longitud3[$p].", ";
          $col16 = "90ED7D";
          break;
        case '17':
          $var17 .= $longitud3[$p].", ";
          $col17 = "F7A35C";
          break;
        case '18':
          $var18 .= $longitud3[$p].", ";
          $col18 = "8085E9";
          break;
        case '19':
          $var19 .= $longitud3[$p].", ";
          $col19 = "F15C80";
          break;
        case '20':
          $var20 .= $longitud3[$p].", ";
          $col20 = "E4D354";
          break;
        case '21':
          $var21 .= $longitud3[$p].", ";
          $col21 = "2B908F";
          break;
        case '22':
          $var22 .= $longitud3[$p].", ";
          $col22 = "F45B5B";
          break;
        case '23':
          $var23 .= $longitud3[$p].", ";
          $col23 = "30F7E8";
          break;
        case '24':
          $var24 .= $longitud3[$p].", ";
          $col24 = "4572A7";
          break;
        case '25':
          $var25 .= $longitud3[$p].", ";
          $col25 = "AA4643";
          break;
        case '26':
          $var26 .= $longitud3[$p].", ";
          $col26 = "89A54E";
          break;
        case '27':
          $var27 .= $longitud3[$p].", ";
          $col27 = "FF9933";
          break;
        case '28':
          $var28 .= $longitud3[$p].", ";
          $col28 = "7CB5EC";
          break;
        case '29':
          $var29 .= $longitud3[$p].", ";
          $col29 = "434348";
          break;
        case '30':
          $var30 .= $longitud3[$p].", ";
          $col30 = "90ED7D";
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
  $var5 = substr($var5, 0, -2);
  $var6 = substr($var6, 0, -2);
  $var7 = substr($var7, 0, -2);
  $var8 = substr($var8, 0, -2);
  $var9 = substr($var9, 0, -2);
  $var10 = substr($var10, 0, -2);
  $variables = $var0."#".$var1."#".$var2."#".$var3."#".$var4."#".$var5."#".$var6."#".$var7."#".$var8."#".$var9."#".$var10."#".$var11."#".$var12."#".$var13."#".$var14."#".$var15."#".$var16."#".$var17."#".$var18."#".$var19."#".$var20."#".$var21."#".$var22."#".$var23."#".$var24."#".$var25."#";
  $variables1 = $col0."#".$col1."#".$col2."#".$col3."#".$col4."#".$col5."#".$col6."#".$col7."#".$col8."#".$col9."#".$col10."#".$col11."#".$col12."#".$col13."#".$col14."#".$col15."#".$col16."#".$col17."#".$col18."#".$col19."#".$col20."#".$col21."#".$col22."#".$col23."#".$col24."#".$col25."#".$col26."#".$col27."#".$col28."#".$col29."#".$col30."#";
  $salida->datos = $valores;
  $salida->datos1 = $valores1;
  $salida->datos2 = $valores2;
  $salida->datos3 = $valores3;
  $salida->datos4 = $variables;
  $salida->datos5 = $variables1;
  echo json_encode($salida);
}
?>