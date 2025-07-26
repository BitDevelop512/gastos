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
  $mes1 = intval($mes)-1;
  $mes2 = intval($mes)-2;
  $tipo = $_POST['tipo'];
  $tipo1 = $_POST['tipo1'];
  $tipo2 = $_POST['tipo2'];
  $unidad = $_POST['unidad'];
  $placa = trim($_POST['placa']);
  $unidades = $_POST['numero'];
  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];
  $adiciona = $_POST['adiciona'];
  if ($adiciona == "1")
  {
    if ($mes == "12")
    {
    }
    else
    {
      $mes = intval($mes)-1;
    }
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
    $v3 = explode("_", $log_usuario);
    $v4 = $v3[1];
    $complemento = "(compania='$v2' OR compania='$v4' OR compania='$compa')";
  }
  // Combustible
  if ($tipo1 == "1")
  {
    $codigo = "36";
  }
  else
  {
    $codigo = "42";
  }
  switch ($tipo)
  {
    case '1':
      if (($sup_usuario == "1") or ($sup_usuario == "2"))
      {
        $pregunta = "SELECT conse, compania, placa, clase, costo, unidad FROM cx_pla_tra WHERE estado='1'";
        if ($unidad == "-")
        {
        }
        else
        {
          $pregunta .= " AND unidad='$unidad'";
        }
        if ($placa == "")
        {
        }
        else
        {
          $pregunta .= " AND placa='$placa'";
        }
        $pregunta .= " ORDER BY placa";
      }
      else
      {
        $pregunta = "SELECT conse, compania, placa, clase, costo, unidad FROM cx_pla_tra WHERE unidad IN ($unidades) AND $complemento AND estado='1' ORDER BY placa";
      }
      break;
    case '2':
      if ($sup_usuario == "6")
      {
        $pregunta1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND dependencia='$dun_usuario' AND unic='1'";
        $sql1 = odbc_exec($conexion,$pregunta1);
        $uni_com = odbc_result($sql1,1);
        $pregunta = "SELECT conse, compania, placa, clase, costo, unidad FROM cx_pla_tra WHERE unidad IN ('$uni_com','$uni_usuario') AND empadrona!='3' AND estado='1' ORDER BY placa";
      }
      else
      {
        if ($sup_usuario == "5")
        {
          $pregunta = "SELECT conse, compania, placa, clase, costo, unidad FROM cx_pla_tra WHERE unidad IN ($unidades) AND empadrona!='3' AND estado='1' ORDER BY placa";
        }
        else
        {
          if ($sup_usuario == "4")
          {
            $pregunta = "SELECT conse, compania, placa, clase, costo, unidad FROM cx_pla_tra WHERE unidad='$uni_usuario' AND empadrona!='3' AND estado='1' ORDER BY placa";
          }
          else
          {
            $pregunta = "SELECT conse, compania, placa, clase, costo, unidad FROM cx_pla_tra WHERE unidad IN ($unidades) AND $complemento AND empadrona!='3' AND estado='1' ORDER BY placa";
          }
        }
      }
      break;
    default:
      $pregunta = "";
      break;
  }
  $sql = odbc_exec($conexion, $pregunta);
  $total = odbc_num_rows($sql);
  $salida = new stdClass();
  if ($total>0)
  {
    switch ($tipo)
    {
      case '1':
      case '2':
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
          // Consulta nombre mision para combustible
          if ($tipo == "2")
          {
            if ($tipo2 == "2")
            {
              $pregunta2 = "SELECT conse, ano FROM cx_pla_inv WHERE unidad='$unidad' AND ((CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)) OR periodo IN ('$mes','$mes1','$mes2')) AND EXISTS (SELECT * FROM cx_pla_gad WHERE cx_pla_gad.conse1=cx_pla_inv.conse AND cx_pla_gad.ano=cx_pla_inv.ano AND cx_pla_gad.gasto='$codigo') ORDER BY fecha DESC";
            }
            else
            {
              $pregunta2 = "SELECT conse, ano FROM cx_pla_inv WHERE unidad='$unidad' AND ((CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)) OR periodo IN ('$mes','$mes1','$mes2')) AND EXISTS (SELECT * FROM cx_pla_gad WHERE cx_pla_gad.conse1=cx_pla_inv.conse AND cx_pla_gad.ano=cx_pla_inv.ano AND cx_pla_gad.gasto='$codigo') ORDER BY fecha DESC";
            }
            $sql2 = odbc_exec($conexion,$pregunta2);
            $total2 = odbc_num_rows($sql2);
            if ($total2>0)
            {
              $j = 0;
              while ($j < $row = odbc_fetch_array($sql2))
              {
                $conse1 = odbc_result($sql2,1);
                $ano1 = odbc_result($sql2,2);
                $pregunta3 = "SELECT conse FROM cx_pla_gad WHERE conse1='$conse1' AND ano='$ano' AND bienes LIKE '%$placa%'";
                $sql3 = odbc_exec($conexion,$pregunta3);
                $total3 = odbc_num_rows($sql3);
                if ($total3>0)
                {
                  $pregunta4 = "SELECT mision FROM cx_pla_gas WHERE conse1='$conse1' AND ano='$ano'";
                  $sql4 = odbc_exec($conexion,$pregunta4);
                  $mision = trim(utf8_encode(odbc_result($sql4,1)));
                }
                else
                {
                  $conse1 = "";
                  $mision = "";
                }
                $j++;
              }
            }
            else
            {
              $conse1 = "";
              $mision = "";
            }
            $salida->rows[$i]['plan'] = $conse1;
            $salida->rows[$i]['mision'] = $mision;
          }
          else
          {
            $salida->rows[$i]['plan'] = "";
            $salida->rows[$i]['mision'] = "";
          }
          $i++;
        }
        break;
      default:
        break;
    }
  }
  if ($tipo == "2")
  {
    $conses = "";
    $pregunta0 = "SELECT codigo FROM cx_ctr_pag WHERE tipo='C' AND codigo='$codigo'";
    $sql0 = odbc_exec($conexion,$pregunta0);
    $v_combustible = "";
    $i = 0;
    while ($i < $row = odbc_fetch_array($sql0))
    {
      $v_combustible .= odbc_result($sql0,1).",";
    }
    $v_combustible = substr($v_combustible,0,-1);
    // Solicitudes de combustible
    if ($tipo2 == "2")
    {
      $pregunta1 = "SELECT conse FROM cx_pla_inv WHERE periodo IN ('$mes','$mes1','$mes2') AND ano='$ano' AND ((usuario='$usu_usuario') OR (usuario='$log_usuario')) AND (estado!='' AND estado!='X') ORDER BY conse";
    }
    else
    {
      $pregunta1 = "SELECT conse FROM cx_pla_inv WHERE periodo IN ('$mes','$mes1','$mes2') AND ano='$ano' AND ((usuario='$usu_usuario') OR (usuario='$log_usuario')) AND (estado!='' AND estado!='X') ORDER BY conse";
    }
    // Si es adminitrador de transportes batallon
    if ($sup_usuario == "5")
    {
      $pregunta1 = str_replace("usuario='$usu_usuario'", "unidad='$uni_usuario'", $pregunta1);
    }
    $sql1 = odbc_exec($conexion,$pregunta1);
    $total1 = odbc_num_rows($sql1);
    if ($total1>0)
    {
      $i = 0;
      while ($i < $row = odbc_fetch_array($sql1))
      {
        $conses .= odbc_result($sql1,1).",";
      }
      $conses = substr($conses,0,-1);
      $pregunta2 = "SELECT valor FROM cx_pla_gad WHERE conse1 IN ($conses) AND ano='$ano' AND gasto IN ($v_combustible) ORDER BY conse1";
      $sql2 = odbc_exec($conexion,$pregunta2);
      $j = 0;
      $combustible = 0;
      while ($j < $row = odbc_fetch_array($sql2))
      {
        $v_valor = trim(odbc_result($sql2,1));
        $v_valor1 = str_replace(',','',$v_valor);
        $v_valor1 = trim($v_valor1);
        $v_valor1 = floatval($v_valor1);
        $combustible = $combustible+$v_valor1;
      }
    }
    else
    {
      $conses = 0;
      $combustible = 0;
    }
    $salida->solicitudes = $conses;
    $salida->combustible = $combustible;
  }
  $salida->total = $total;
  echo json_encode($salida);
}
// 07/08/2023 - Ajuste consecutivo de solicitudes para NaN
// 08/08/2023 - Ajuste consulta combustible login usuario
// 23/02/2024 - Ajuste por creacion de tabla de configuracion de vehiculos
// 07/03/2024 - Ajuste consulta de placas para usuarios administradores de transportes
// 18/03/2024 - Ajuste placas es estado activo
// 19/03/2024 - Ajuste usuario administrador transportes comando
// 05/12/2024 - Ajuste para diciembre en adicion de registros
// 28/04/2025 - Ajuste consulta cambio de usuario
?>