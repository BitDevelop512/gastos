<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $actual = date('Y-m-d');
  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];
  $empadrona = $_POST['empadrona'];
  switch ($empadrona)
  {
    case '1':
    case '2':
      $tabla = "cv_tra_mov";
      $tipo = "F";
      break;
    case '3':
      $tabla = "cv_tra_moc";
      $tipo = "C";
      break;
    default:
      $tabla = "";
      break;
  }
  $placa = trim($_POST['placa']);
  $unidad = $_POST['unidad'];
  if ($unidad == "999")
  {
    $query = "SELECT placa, unidad FROM cx_pla_tra WHERE empadrona='$empadrona'";
  }
  else
  {
    $unidades = stringArray1($unidad);
    $query = "SELECT placa, unidad FROM cx_pla_tra WHERE unidad IN ($unidades) AND empadrona='$empadrona'";
  }
  if ($placa == "")
  {
  }
  else
  {
    $query .= " AND placa='$placa'";
  }
  $query .= " ORDER BY unidad, placa";
  $cur = odbc_exec($conexion, $query);
  $contador = odbc_num_rows($cur);
  $i = 0;
  $datos = "";
  while($i<$row=odbc_fetch_array($cur))
  {
    $placa = odbc_result($cur,1);
    $unidad1 = odbc_result($cur,2);
    $pregunta = "SELECT ISNULL(SUM(total),0) AS total FROM ".$tabla." WHERE placa='$placa' AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1)";
    if ($tipo == "F")
    {
      $pregunta .= " AND tipo='1'";
    }
    if ($unidad1 == "1")
    {
    }
    else
    {
      if ($unidad1 == "2")
      {
      }
      else
      {
        $pregunta .= " AND unidad='$unidad1'";
      }
    }
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    if ($total>0)
    {
      $consumo = odbc_result($sql,1);
      $consumo = floatval($consumo);
    }
    else
    {
      $consumo = "0";
    }
    if ($tipo == "F")
    {
      $pregunta1 = "SELECT ISNULL(SUM(total),0) AS total FROM ".$tabla." WHERE placa='$placa' AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1) AND tipo='2'";
      if ($unidad1 == "1")
      {
      }
      else
      {
        if ($unidad1 == "2")
        {
        }
        else
        {
          $pregunta .= " AND unidad='$unidad1'";
        }
      }
      $sql1 = odbc_exec($conexion,$pregunta1);
      $total1 = odbc_num_rows($sql1);
      if ($total1>0)
      {
        $consumo1 = odbc_result($sql1,1);
        $consumo1 = floatval($consumo1);
      }
      else
      {
        $consumo1 = "0";
      }
    }
    else
    {
      $consumo1 = "0";
    }
    $consumo2 = $consumo+$consumo1;
    $query1 = "SELECT * FROM cx_org_sub WHERE subdependencia='$unidad1'";
    $sql2 = odbc_exec($conexion,$query1);
    $sigla = trim(odbc_result($sql2,4));
    $sigla1 = trim(odbc_result($sql2,41));
    $fecha3 = trim(odbc_result($sql2,43));
    if ($fecha3 == "")
    {
    }
    else
    {
      $fecha3 = str_replace("/", "-", $fecha3);
      if ($actual >= $fecha3)
      {
        $sigla = $sigla1;
      }
    }
    $datos .= $sigla."|".$placa."|".$consumo."|".$consumo1."|".$consumo2."|#";
    $i++;
  }
  $salida->datos = $datos;
  $salida->contador = $contador;
  echo json_encode($salida);
}
// 08/08/2023 - Nueva consulta de combustible registrado de transportes por rango de fecha
?>