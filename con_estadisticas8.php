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
  $valores = "";
  $pregunta = "SELECT sigla, SUM(gastos) AS gastos, SUM(pagos) AS pagos, SUM(total) AS total, unidad FROM cx_val_aut WHERE unidad IN ($unidades) AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' GROUP BY sigla, unidad";
  $cur = odbc_exec($conexion, $pregunta);
  $total = odbc_num_rows($cur);
  $total = intval($total);
  if ($total > 0)
  {
    $k = 0;
    while($k<$row=odbc_fetch_array($cur))
    {
      $v1 = trim(odbc_result($cur,1));
      $v2 = odbc_result($cur,2);
      if ($v2 == ".00")
      {
        $v2 = "0.00";
      }
      $v3 = odbc_result($cur,3);
      if ($v3 == ".00")
      {
        $v3 = "0.00";
      }
      $v4 = odbc_result($cur,4);
      if ($v4 == ".00")
      {
        $v4 = "0.00";
      }
      $v5 = odbc_result($cur,5);
      $pregunta1 = "SELECT conse, fecha, periodo FROM cx_pla_cen WHERE unidad='$v5' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' ORDER BY periodo";
      $cur1 = odbc_exec($conexion, $pregunta1);
      $tot1 = odbc_num_rows($cur1);
      if ($tot1 == "0")
      {
        $v9 = "";
        $v0 = "";
      }
      else
      {
        $m = 0;
        $v9 = "";
        $v0 = "<table width='100%' align='center' border='0'>";
        while($m<$row1=odbc_fetch_array($cur1))
        {
          $v6 = odbc_result($cur1,1);
          $v7 = substr(odbc_result($cur1,2),0,10);
          $v8 = odbc_result($cur1,3);
          $v9 .= $v8."-".$v6."-".$v7."-»";
          $v0 .= "<tr><td width='30%' height='20'><center>".$v8."</center></td><td width='30%' height='20'><center>".$v6."</center></td><td width='40%' height='20'><center>".$v7."</center></td></tr>";
        }
        $v0 .= "</table>";
      }
      $valores .= $v1."|".$v2."|".$v3."|".$v4."|".$v9."|".$v0."|#";
    }
  }
  $salida->total = $total;
  $salida->datos = $valores;
  echo json_encode($salida);
}
// 11/11/2023 - Estadistica de Planes Centralizados - Exportacion a excel
// 08/08/2024 - Ajuste por colunma con datos del plan centralizado
?>