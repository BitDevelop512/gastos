<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $ano = date('Y');
  $mes = date('m');
  $mes = intval($mes);
  $tipo = $_POST['tipo'];
  $tipo1 = $_POST['tipo1'];
  $clase = $_POST['clase'];
  $placa = trim($_POST['placa']);
  $unidades = $_POST['numero'];
  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];
  $adiciona = $_POST['adiciona'];
  if ($adiciona == "1")
  {
    $mes = intval($mes)-1;
  }
  $pregunta = "SELECT sigla FROM cx_org_cmp WHERE conse='$tip_usuario'";
  $sql = odbc_exec($conexion, $pregunta);
  $compa = trim(odbc_result($sql,1));
  $valida = strpos($usu_usuario, "_");
  $valida = intval($valida);
  if ($valida == "0")
  {
    $complemento = "1=1";
  }
  else
  {
    $v1 = explode("_", $usu_usuario);
    $v2 = $v1[1];
    $complemento = "(compania='$v2' OR compania='$compa')";
  }


  if ($sup_usuario == "6")
  {
    $pregunta1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND dependencia='$dun_usuario' AND unic='1'";
    $sql1 = odbc_exec($conexion,$pregunta1);
    $uni_com = odbc_result($sql1,1);
    $pregunta = "SELECT conse, compania, placa, clase, costo, unidad FROM cx_pla_tra WHERE unidad IN ('$uni_com','$uni_usuario') AND empadrona IN ('3','4') AND estado='1'";
  }
  else
  {
    $pregunta = "SELECT conse, compania, placa, clase, costo, unidad FROM cx_pla_tra WHERE unidad IN ($unidades) AND $complemento AND empadrona IN ('3','4') AND estado='1'";
  }
  if ($clase == "-")
  {
  }
  else
  {
    $pregunta .= " AND clase='$clase'";
  }
  if ($placa == "")
  {
  }
  else
  {
    $pregunta .= " AND placa='$placa'";
  }
  $pregunta .= " ORDER BY placa";
  $sql = odbc_exec($conexion,$pregunta);
  $total = odbc_num_rows($sql);
  $salida = new stdClass();
  if ($total>0)
  {
    $i = 0;
    while ($i < $row = odbc_fetch_array($sql))
    {
      $placa = trim($row['placa']);
      $clase = $row['clase'];
      $unidad = $row['unidad'];
      $salida->rows[$i]['conse'] = $row['conse'];
      $salida->rows[$i]['compania'] = trim(utf8_encode($row['compania']));
      $salida->rows[$i]['placa'] = $placa;
      $pregunta5 = "SELECT nombre FROM cx_ctr_veh WHERE codigo='$clase'";
      $sql5 = odbc_exec($conexion, $pregunta5);
      $n_clase = trim(utf8_encode(odbc_result($sql5,1)));
      $salida->rows[$i]['clase'] = $n_clase;
      $salida->rows[$i]['costo'] = $row['costo'];
      $i++;
    }
  }
  if (($tipo == "C") or ($tipo == "M") or ($tipo == "L") or ($tipo == "T"))
  {
    // Unidad centralizadora
    $query = "SELECT n_unidad, n_dependencia, sigla FROM cv_unidades WHERE subdependencia='$uni_usuario' AND dependencia='$dun_usuario' AND unidad='$nun_usuario'";
    $cur = odbc_exec($conexion, $query);
    $n_unidad = trim(utf8_encode(odbc_result($cur,1)));
    $n_dependencia = trim(utf8_encode(odbc_result($cur,2)));
    $n_sigla = trim(odbc_result($cur,3));
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE sigla='$n_unidad' AND unic='1'";
    $cur1 = odbc_exec($conexion, $query1);
    $centraliza = odbc_result($cur1,1);
    // Datos contrato combustible
    $pregunta1 = "SELECT datos FROM cx_con_pro WHERE conse='$tipo1'";
    $sql1 = odbc_exec($conexion,$pregunta1);
    $total1 = odbc_num_rows($sql1);
    $combustible = 0;
    if ($total1>0)
    {
      $datos = trim(utf8_encode(odbc_result($sql1,1)));
      $num_datos = explode("|",$datos);
      for ($j=0;$j<count($num_datos)-1;++$j)
      {
        $paso = $num_datos[$j];
        $num_valores = explode("»",$paso);
        $v1 = $num_valores[0];
        $v2 = $num_valores[1];
        $v3 = $num_valores[2];
        if ($v1 == $uni_usuario)
        {
          $combustible = floatval($v3);
        }
      }
    }
    $salida->combustible = $combustible;
  }
  $salida->total = $total;
  echo json_encode($salida);
}
// 23/02/2024 - Ajuste por creacion de tabla de configuracion de vehiculos
// 18/03/2024 - Ajuste placas es estado activo
?>