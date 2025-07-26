<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $tipo = $_POST['tipo'];
  $periodo = $_POST['periodo'];
  $ano = $_POST['ano'];
  $mes = str_pad($periodo,2,"0",STR_PAD_LEFT);
  $empadrona = $_POST['empadrona'];
  if ($empadrona == "F")
  {
    $tabla = "cv_tra_mov";
    $complemento1 = "empadrona IN ('1', '2')";
  }
  else
  {
    $tabla = "cv_tra_moc";
    $complemento1 = "empadrona='3'";
  }
  $combustible = $_POST['combustible'];
  if ($combustible == "1")
  {
    $combustible1 = "tipo='1'";
    $combustible2 = "combustible='1'";
  }
  else
  {
    $combustible1 = "tipo IN ('2', '3')";
    $combustible2 = "combustible IN ('2', '3')";
  }
  $agrupar = $_POST['agrupar'];
  switch ($periodo)
  {
    case '1':
    case '3':
    case '5':
    case '7':
    case '8':
    case '10':
    case '12':
      $dia = "31";
      break;
    case '2':
      if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
      {
        $dia = "29";
      }
      else
      {
        $dia = "28";
      }
      break;
    case '4':
    case '6':
    case '9':
    case '11':
      $dia = "30";
      break;
    default:
      $dia = "31";
      break;
  }
  $fecha1 = $ano."/".$mes."/01";
  $fecha2 = $ano."/".$mes."/".$dia;
  // Anexo T
  if ($tipo == "1")
  {
    $pregunta = "SELECT sigla FROM cx_org_cmp WHERE conse='$tip_usuario'";
    $sql = odbc_exec($conexion, $pregunta);
    $compa = trim(odbc_result($sql,1));
    $gasolina = "";
    $salida = new stdClass();
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
    if (($sup_usuario == "1") or ($sup_usuario == "2"))
    {
      $query = "SELECT placa, tipo, costo, clase FROM cx_pla_tra WHERE $combustible1 AND $complemento AND $complemento1 ORDER BY placa";
    }
    else
    {
      $query = "SELECT placa, tipo, costo, clase FROM cx_pla_tra WHERE unidad='$uni_usuario' AND $combustible1 AND $complemento AND $complemento1 ORDER BY placa";
    }
    if ($agrupar == "1")
    {
      $query = "SELECT placa, tipo, costo, clase, compania FROM cx_pla_tra WHERE unidad='$uni_usuario' AND $combustible1 AND $complemento1 ORDER BY compania, placa";
    }
    $cur = odbc_exec($conexion, $query);
    $ngasolina = odbc_num_rows($cur);
    $i = 0;
    $valores1 = "";
    $valores2 = 0;
    $valores3 = 0;
    $valores4 = 0;
    $valores5 = "";
    $valores6 = 0;
    if ($ngasolina == "0")
    {
    }
    else
    {
      while($i<$row=odbc_fetch_array($cur))
      {
        $placa = odbc_result($cur,1);
        $tipoc = odbc_result($cur,2);
        $costo = odbc_result($cur,3);
        $clase = odbc_result($cur,4);
        $fechaini = str_replace("/", "-", $fecha1);
        $fechafin = str_replace("/", "-", $fecha2);
        $fechaini = strtotime($fechaini);
        $fechafin = strtotime($fechafin);
        $ingresos = "";
        for ($i=$fechaini; $i<=$fechafin; $i+=86400)
        {
          $fecha3 = date("Y-m-d", $i);
          $fecha4 = explode("-",$fecha3);
          $dia1 = $fecha4[2];
          $fecha4 = $fecha4[0].$fecha4[1].$fecha4[2];
          // Suma total del dia de gasolina y facturas por placa
          $pregunta = "SELECT ISNULL(SUM(consumo),0) AS consumo FROM ".$tabla." WHERE fecha='$fecha4' AND unidad='$uni_usuario' AND placa='$placa' AND $combustible2 AND $complemento1";
          $sql = odbc_exec($conexion,$pregunta);
          $total = odbc_num_rows($sql);
          if ($total>0)
          {
            $consumo = odbc_result($sql,1);
            $consumo = floatval($consumo);
            $valores1 .= $consumo."|";
            $valores2 = $valores2+$consumo;
          }
          else
          {
            $valores1 .= "0|";
            $valores2 = $valores2+0;
          }
          // Suma total del dia de gasolina y facturas de todas las placas del tipo de combustible
          $pregunta1 = "SELECT ISNULL(SUM(consumo),0) AS consumo, ISNULL(SUM(total),0) AS total FROM ".$tabla." WHERE fecha='$fecha4' AND unidad='$uni_usuario' AND $combustible2 AND $complemento1 AND EXISTS (SELECT * FROM cx_pla_tra WHERE cx_pla_tra.placa=".$tabla.".placa AND $complemento)";
          if ($agrupar == "1")
          {
            $pregunta1 = "SELECT ISNULL(SUM(consumo),0) AS consumo, ISNULL(SUM(total),0) AS total FROM ".$tabla." WHERE fecha='$fecha4' AND unidad='$uni_usuario' AND $combustible2 AND $complemento1 AND EXISTS (SELECT * FROM cx_pla_tra WHERE cx_pla_tra.placa=".$tabla.".placa)";
          }
          $sql1 = odbc_exec($conexion,$pregunta1);
          $consumo1 = odbc_result($sql1,1);
          $consumo1 = floatval($consumo1);
          $valores5 .= $consumo1."|";
          $factura = odbc_result($sql1,2);
          $factura = floatval($factura);
          $valores3 = $valores3+$factura;
          $valores4 = $valores4+$consumo1;
          // Minimo y maximo de kilometraje por placa
          if ($dia1 == "01")
          {
            $pregunta2 = "SELECT ISNULL(MIN(kilometraje),0) AS minimo, ISNULL(MAX(kilometraje),0) AS maximo FROM ".$tabla." WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND unidad='$uni_usuario' AND placa='$placa' AND $combustible2 AND $complemento1";
            $sql2 = odbc_exec($conexion,$pregunta2);
            $minimo = odbc_result($sql2,1);
            $minimo = floatval($minimo);
            $maximo = odbc_result($sql2,2);
            $maximo = floatval($maximo);
            $recorridos = $maximo-$minimo;
            $valores6 = $valores6+$recorridos;
          }
        }
        switch ($dia)
        {
          case '28':
            $valores1 .= "||";
            $valores5 .= "||";
            break;
          case '29':
            $valores1 .= "|";
            $valores5 .= "|";
            break;
          case '30':
            $valores1 .= "";
            $valores5 .= "";
            break;
          case '31':
            $valores1 = substr($valores1,0,-1);
            $valores5 = substr($valores5,0,-1);
            break;
          default:
            break;
        }
        $gasolina .= $placa."|".$costo."|".$valores1."|".$valores2."|".$recorridos."|#";
        $i++;
        $total1 = $valores5;
        $total2 = $valores4;
        $total3 = $valores3;
        $total4 = $valores6;
        if ($total2 == "0")
        {
        }
        else
        {
          $total5 = $total3/$total2;
          $total5 = floatval($total5);            
        }
        $valores1 = "";
        $valores2 = 0;
        $valores3 = 0;
        $valores4 = 0;
        $valores5 = "";
      }
      $gasolina .= "TOTAL DIARIO||".$total1."|".$total2."|".$total4."|#";
    }
    $salida->galones = $total2;
    $salida->tanqueo = $total3;
    $salida->promedio = $total5;
    $salida->gasolina = $gasolina;
    $salida->ngasolina = $ngasolina;
    // Otros datos
    $contador = $ngasolina;
    $salida->dias = $dia;
    $salida->contador = $contador;
  }
  echo json_encode($salida);
}
?>