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
  $centra = $_POST['centra'];
  $sigla = $_POST['sigla'];
  $valores = "";
  if ($centra <= 3)
  {
    $pregunta0 = "SELECT dependencia FROM cx_org_sub WHERE sigla='$sigla'";
    $cur0 = odbc_exec($conexion, $pregunta0);
    $dependencia = odbc_result($cur0,1);
    $pregunta = "SELECT centra, n_centra, actividad, n_actividad, sum(valor) AS total FROM cv_ind_ges WHERE dependencia='$dependencia' AND periodo BETWEEN ('$periodo1') AND ('$periodo2') AND ano='$ano' GROUP BY centra, n_centra, actividad, n_actividad ORDER BY actividad";
  }
  else
  {
    $pregunta = "SELECT centra, n_centra, actividad, n_actividad, sum(valor) AS total FROM cv_ind_ges WHERE centra='$centra' AND periodo BETWEEN ('$periodo1') AND ('$periodo2') AND ano='$ano' GROUP BY centra, n_centra, actividad, n_actividad ORDER BY actividad";
  }
  $cur = odbc_exec($conexion, $pregunta);
  $total = odbc_num_rows($cur);
  $total = intval($total);
  $suma = 0;
  if ($total > 0)
  {
    $k = 0;
    while($k<$row=odbc_fetch_array($cur))
    {
      $v1 = odbc_result($cur,1);
      $v2 = trim(odbc_result($cur,2));
      $v3 = odbc_result($cur,3);
      $v4 = trim(utf8_encode(odbc_result($cur,4)));
      $v5 = odbc_result($cur,5);
      $v6 = number_format($v5,2);
      $suma = $suma+$v5;
      $pregunta1 = "SELECT factor FROM cv_ind_ges WHERE centra='$centra' AND periodo BETWEEN ('$periodo1') AND ('$periodo2') AND ano='$ano' AND actividad='$v3' GROUP BY factor";
      $cur1 = odbc_exec($conexion, $pregunta1);
      $v7 = [];
      $j = 0;
      while($j<$row=odbc_fetch_array($cur1))
      {
        $v8 = trim(odbc_result($cur1,1));
        $pregunta2 = "SELECT nombre FROM cx_ctr_fac WHERE codigo IN ($v8)";
        $cur2 = odbc_exec($conexion, $pregunta2);
        $i = 0;
        while($i<$row=odbc_fetch_array($cur2))
        {
          $v9 = trim(utf8_encode(odbc_result($cur2,1)));
          if (in_array($v9, $v7))
          {         
          }
          else
          {
            array_push($v7, $v9);
          }
        }
      }
      $v10 = stringArray1($v7);
      $valores .= $v1."|".$v2."|".$v3."|".$v4."|".$v5."|".$v6."|".$v10."|#";
    }
  }
  $suma1 = number_format($suma,2);
  $salida->suma = $suma;
  $salida->suma1 = $suma1;
  $salida->datos = $valores;
  echo json_encode($salida);
}
?>