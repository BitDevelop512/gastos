<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];
  $unidad = $_POST['unidad'];
  $unidades = stringArray1($unidad);
  $longitud = explode(",",$unidades);
  $fechaini = str_replace("/", "-", $fecha1);
  $fechafin = str_replace("/", "-", $fecha2);
  $fechaini = strtotime($fechaini);
  $fechafin = strtotime($fechafin);
  $fechas = "";
  $valores = "";
  $valores1 = "";
  $valores2 = "";
  for ($j=0; $j<count($longitud); $j++)
  {
    $data[$j] = "";
    $valores[$j] = "";
    $valor = $longitud[$j];
    for ($i=$fechaini; $i<=$fechafin; $i+=86400)
    {
      $fecha3 = date("d-m-Y", $i);
      $fecha4 = explode("-", $fecha3);
      $dia1 = $fecha4[0];
      $mes1 = $fecha4[1];
      $ano1 = $fecha4[2];
      $fecha5 = $ano1.$mes1.$dia1;
      $pregunta = "SELECT fec_regi, uni_nomb, tot_regi FROM cv_por_usu WHERE uni_acti='$valor' AND fec_regi='$fecha5'";
      $cur = odbc_exec($conexion, $pregunta);
      $total = odbc_num_rows($cur);
      $total = intval($total);
      if ($total > 0)
      {
        $v1 = odbc_result($cur,1);
        $v2 = trim(odbc_result($cur,2));
        $v3 = odbc_result($cur,3);
        $v3 = intval($v3);
      }
      else
      {
        $pregunta1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$valor'";
        $cur1 = odbc_exec($conexion, $pregunta1);
        $v1 = $fecha5;
        $v2 = trim(odbc_result($cur1,1));
        $v3 = 0;
      }
      $data[$j] .= $v3.", ";
    }
    $data[$j] = substr($data[$j], 0, -2);
    $data[$j] = "{ name: '".$v2."', data: [".$data[$j]. "] }, ";
  }
  $datos = "";
  for ($j=0; $j<count($longitud); $j++)
  {
    $datos .= $data[$j];
  }
  for ($i=$fechaini; $i<=$fechafin; $i+=86400)
  {
    $fecha = date("d-m-Y", $i);
    $fechas .= "'".$fecha."', ";
  }
  $datos = substr($datos, 0, -2);
  $fechas = substr($fechas, 0, -2);
  $salida->datos = $datos;
  $salida->fechas = $fechas;
  echo json_encode($salida);
}
?>