<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $fecha = $_POST['fecha'];
  $placa = $_POST['placa'];
  $plan = $_POST['plan'];
  $tipo = $_POST['tipo'];
  if ($tipo == "1")
  {
    $tipo1 = "36";
  }
  else
  {
    $tipo1 = "42";
  }
  $ano1 = date('Y');
  if ($plan == "-")
  {
    $salida->contador = "0";
    $salida->contador1 = "0";
    $salida->disponible = "0";
  }
  else
  {
    $pregunta = "SELECT * FROM cx_tra_mov WHERE placa='$placa' AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha',102) AND convert(datetime,'$fecha',102) AND solicitud='$plan'";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    $contador = 0;
    if ($total>0)
    {
      $i = 0;
      while ($i < $row = odbc_fetch_array($sql))
      {
        $unidad = $row['unidad'];
        $solicitud = $row['solicitud'];
        $ano = $row['ano'];
        $pregunta1 = "SELECT conse FROM cx_rel_gas WHERE unidad='$unidad' AND consecu='$solicitud' AND ano='$ano'";
        $sql1 = odbc_exec($conexion,$pregunta1);
        $total1 = odbc_num_rows($sql1);
        $contador = $contador+$total1;
        $i++;
      }
      $salida->contador = $contador;
    }
    else
    {
      $salida->contador = "0";
    }
    // Contador de Misiones del Plan / Solicitud
    $pregunta0 = "SELECT COUNT(1) AS total FROM cx_pla_gas WHERE conse1='$plan' AND ano='$ano1'";
    $sql0 = odbc_exec($conexion,$pregunta0);
    $contador1 = odbc_result($sql0,1);
    $salida->contador1 = $contador1;
    // Valida sumatoria
    $pregunta1 = "SELECT ISNULL(SUM(total),0) AS total FROM cx_tra_mov WHERE solicitud='$plan' AND ano='$ano1' AND tipo='$tipo'";
    $sql1 = odbc_exec($conexion,$pregunta1);
    $registrado = odbc_result($sql1,1);
    $registrado = floatval($registrado);
    // Valida valor solicitado
    $pregunta2 = "SELECT valor FROM cx_pla_gad WHERE conse1='$plan' AND ano='$ano1' AND gasto='$tipo1' AND bienes LIKE '%".$placa."%'";
    $sql2 = odbc_exec($conexion,$pregunta2);
    $total2 = odbc_num_rows($sql2);
    $solicitado = 0;
    if ($total2>0)
    {
      $i = 0;
      while ($i < $row = odbc_fetch_array($sql2))
      {
        $paso = trim($row['valor']);
        $paso = str_replace(',','',$paso);
        $paso = substr($paso,0,-3);
        $paso = floatval($paso);
        $solicitado = $solicitado+$paso;
        $i++;
      }
    }
    $disponible = $solicitado-$registrado;
    $salida->disponible = $disponible;
  }
  echo json_encode($salida);
}
?>