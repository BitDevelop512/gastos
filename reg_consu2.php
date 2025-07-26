<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $fechac1 = $_POST['fecha1'];
  $fechac2 = $_POST['fecha2'];
  $unidadc = $_POST['unidad'];
  $ano1 = $_POST['ano'];
  $estado1 = $_POST['estado'];
  $ordop1 = $_POST['ordop'];
  $ordop2 = utf8_decode($ordop1);
  $fragmenta1 = $_POST['fragmenta'];
  $fragmenta2 = utf8_decode($fragmenta1);
  $v_valor = $_POST['valor'];
  $v_valor1 = $_POST['valor1'];
  $v_valor1 = floatval($v_valor1);
  if (($tpc_usuario == "1") or ($uni_usuario == "2"))
  {
    if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
    {
      if (($nun_usuario == "2") or ($nun_usuario == "3"))
      {
        if ($tpu_usuario == "4")
        {
          $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND unic='0' ORDER BY subdependencia";
        }
        else
        {
          $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND unic='0' AND dependencia='$dun_usuario' ORDER BY subdependencia";
        }
      }
      else
      {
        $query1 = "SELECT subdependencia FROM cx_org_sub ORDER BY subdependencia";
      }
    }
    else
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' ORDER BY subdependencia";
    }
    $cur1 = odbc_exec($conexion, $query1);
    $contador = odbc_num_rows($cur1);
    $numero = "";
    while($i<$row=odbc_fetch_array($cur1))
    {
      $numero .= "'".odbc_result($cur1,1)."',";
    }
    $numero = substr($numero,0,-1);
    // Se verifica si es unidad centralizadora especial
    if (strpos($especial, $uni_usuario) !== false)
    {
      if ($numero == "")
      {
      }
      else
      {
        $numero .= ",";
      }
      $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$nun_usuario' ORDER BY unidad";
      $cur = odbc_exec($conexion, $query);
      while($i<$row=odbc_fetch_array($cur))
      {
        $n_unidad = odbc_result($cur,1);
        $n_dependencia = odbc_result($cur,2);
        $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
        $cur1 = odbc_exec($conexion, $query1);
        while($j<$row=odbc_fetch_array($cur1))
        {
          $numero .= "'".odbc_result($cur1,1)."',";
        }
      }
      $numero = substr($numero,0,-1);
    }
  }
  else
  {
    $numero = "";
  }
  $complemento1 = "((usuario1='$usu_usuario') OR (usuario2='$usu_usuario')) AND estado!=''";
  if ($numero == "")
  {
  }
  else
  {
    $complemento1 = "((".$complemento1.") OR (unidad IN ($numero)))";
  }
  $actu = "UPDATE cx_reg_rec SET usuario4='SPR_DIADI' WHERE estado='E'";
  $sql0 = odbc_exec($conexion,$actu);
  $pregunta = "SELECT * FROM cx_reg_rec WHERE 1=1 AND ".$complemento1;
  if (!empty($_POST['fechac1']))
  {
    $pregunta .= " AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fechac1',102) AND (CONVERT(datetime,'$fechac2',102)+1)";
  }
  if ($unidadc == "-")
  {
  }
  else
  {
    $pregunta .= " AND unidad='$unidadc'";
  }
  if ($ano1 == "-")
  {
  }
  else
  {
    $pregunta .= " AND ano='$ano1'";
  }
  if ($estado1 == "-")
  {
  }
  else
  {
    $pregunta .= " AND estado='$estado1'";
  }
  if (!empty($_POST['ordop']))
  {
    $pregunta .= " AND ((ordop='$ordop1') or (ordop='$ordop2'))";
  }
  if (!empty($_POST['fragmenta']))
  {
    $pregunta .= " AND ((fragmenta='$fragmenta1') or (fragmenta='$fragmenta2'))";
  }
  if ($v_valor1 == "0")
  {
  }
  else
  {
    $pregunta .= " AND valor1='$v_valor1'";
  }
  $pregunta .= " ORDER BY fecha DESC";
  $sql = odbc_exec($conexion,$pregunta);
  $total = odbc_num_rows($sql);
  $salida = new stdClass();
  if ($total>0)
  {
    $i = 0;
    while ($i < $row = odbc_fetch_array($sql))
    {
      $unidad = $row['unidad'];
      $estado = trim($row['estado']);
      $fecha = $row['fec_res'];
      $fecha1 = $row['fec_sum'];
      $tipo = $row['tipo'];
      $consecu = $row['conse'];
      $ano = $row['ano'];
      $cedulas = trim($row['cedulas']);
      $cedulas1 = "";
      $num_cedulas = explode("|",$cedulas);
      for ($j=0;$j<count($num_cedulas)-1;++$j)
      {
        $cedula = $num_cedulas[$j];
        $cedula = str_replace(".", "", $cedula);
        $cedula = substr($cedula, -4);
        $cedula = "XXXX".$cedula;
        $cedulas1 .= $cedula." - ";
      }
      $cedulas1 = substr($cedulas1, 0, -3);
      $pregunta1 = "SELECT fec_rec FROM cx_reg_rev WHERE usuario='SPR_DIADI' AND consecu='$consecu' AND ano='$ano'";
      $sql1 = odbc_exec($conexion,$pregunta1);
      $total1 = odbc_num_rows($sql1);
      if ($total1 > 0)
      {
        $actual = odbc_result($sql1,1);
      }
      else
      {
        $actual = date('Y-m-d');
      }
      if ($tipo == "1")
      {
        $fecha = $fecha1;
      }
      $dias = getDiasHabiles($fecha, $actual);
      $dias1 = count($dias)-1;
      switch ($estado)
      {
        case '':
          $n_estado = "EN TRAMITE U.T.";
          break;
        case 'Y':
          $n_estado = "RECHAZADA";
          break;
        case 'A':
          $n_estado = "REVISIÓN BRIGADA";
          break;
        case 'B':
          $n_estado = "REVISIÓN COMANDO";
          break;
        case 'C':
          $n_estado = "REVISIÓN DIVISIÓN";
          break;
        case 'D':
          $n_estado = "EVALUACIÓN CRR";
          break;
        case 'E':
          $n_estado = "REVISIÓN CEDE2";
          break;
        case 'F':
          $n_estado = "EVALUADA CCR";
          break;
        case 'G':
          $n_estado = "PENDIENTE GIRO";
          break;
        case 'H':
          $n_estado = "GIRADA";
          break;
        case 'I':
          $n_estado = "PAGADA";
          break;
        default:
          $n_estado = "";
          break;
      }
      $pregunta1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
      $sql1 = odbc_exec($conexion,$pregunta1);
      $unidad1 = trim(odbc_result($sql1,1));
      $pregunta2 = "SELECT n_dependencia, n_unidad FROM cv_unidades WHERE subdependencia='$unidad'";
      $sql2 = odbc_exec($conexion,$pregunta2);
      $n_dependencia = trim(odbc_result($sql2,1));
      $n_unidad = trim(odbc_result($sql2,2));
      $pregunta3 = "SELECT subdependencia FROM cv_unidades WHERE n_dependencia='$n_dependencia' AND sigla='$n_dependencia'";
      $sql3 = odbc_exec($conexion,$pregunta3);
      $n_dependencia1 = odbc_result($sql3,1);
      $valor = trim($row['valor']);
      if (($valor == ".00") or ($valor == ""))
      {
        $valor = "0.00";
      }
      $salida->rows[$i]['conse'] = $row['conse'];
      $salida->rows[$i]['ano'] = $row['ano'];
      $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
      $salida->rows[$i]['usuario'] = trim($row['usuario']);
      $salida->rows[$i]['n_estado'] = $n_estado;
      $salida->rows[$i]['estado'] = $row['estado'];
      $salida->rows[$i]['unidad'] = $unidad;
      $salida->rows[$i]['unidad1'] = $unidad1;
      $salida->rows[$i]['n_dependencia'] = $n_dependencia;
      $salida->rows[$i]['n_unidad'] = $n_unidad;
      $salida->rows[$i]['n_dependencia1'] = $n_dependencia1;
      $salida->rows[$i]['valor'] = $valor;
      $salida->rows[$i]['ordop'] = trim(utf8_encode($row['ordop']));
      $salida->rows[$i]['fragmenta'] = trim(utf8_encode($row['fragmenta']));
      $salida->rows[$i]['dias'] = $dias1;
      $salida->rows[$i]['usuario1'] = trim($row['usuario1']);
      $salida->rows[$i]['usuario2'] = trim($row['usuario2']);
      $salida->rows[$i]['usuario3'] = trim($row['usuario3']);
      $salida->rows[$i]['usuario4'] = trim($row['usuario4']);
      $salida->rows[$i]['tipo'] = $row['tipo'];
      $salida->rows[$i]['cedulas'] = $cedulas1;
      $i++;
    }
    $salida->salida = "1";
    $salida->total = $total;
  }
  else
  {
    $salida->salida = "0";
    $salida->total = "0";
  }
  echo json_encode($salida);
}
// 09/10/2023 - Se agregan filtros de busqueda por ordop, frgamentaria, valor y exportacion a excel
// 27/11/2024 - Ajuste inclusion cedulas beneficiarios
?>