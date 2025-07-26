<?php
session_start();
error_reporting(0);
ini_set('memory_limit', '15360M');
ini_set('max_execution_time', 3600);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $tipo = $_POST['tipo'];
  $periodo = $_POST['periodo1'];
  $ano = $_POST['ano'];
  $mes = str_pad($periodo,2,"0",STR_PAD_LEFT);
  $placa = trim($_POST['placa']);
  $empadrona = $_POST['empadrona'];
  if (($empadrona == "F") or ($empadrona == "G"))
  {
    $tabla = "cv_tra_mov";
    if ($empadrona == "F")
    {
      $complemento1 = "empadrona='1'";
    }
    else
    {
      $complemento1 = "empadrona='2'";
    }
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
  // Segundo periodo
  $periodo2 = $_POST['periodo2'];
  $mes2 = str_pad($periodo2,2,"0",STR_PAD_LEFT);
  switch ($periodo2)
  {
    case '1':
    case '3':
    case '5':
    case '7':
    case '8':
    case '10':
    case '12':
      $dia2 = "31";
      break;
    case '2':
      if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
      {
        $dia2 = "29";
      }
      else
      {
        $dia2 = "28";
      }
      break;
    case '4':
    case '6':
    case '9':
    case '11':
      $dia2 = "30";
      break;
    default:
      $dia2 = "31";
      break;
  }
  $fecha2 = $ano."/".$mes2."/".$dia2;
  // Siguiente mes segundo periodo
  if ($periodo2 == "12")
  {
    $periodo1 = "1";
    $ano1 = $ano+1;
  }
  else
  {
    $periodo1 = $periodo2+1;
    $ano1 = $ano;
  }
  $mes1 = str_pad($periodo1,2,"0",STR_PAD_LEFT);
  switch ($periodo1)
  {
    case '1':
    case '3':
    case '5':
    case '7':
    case '8':
    case '10':
    case '12':
      $dia1 = "31";
      break;
    case '2':
      if (($ano1 == "2020") or ($ano1 == "2024") or ($ano1 == "2028"))
      {
        $dia1 = "29";
      }
      else
      {
        $dia1 = "28";
      }
      break;
    case '4':
    case '6':
    case '9':
    case '11':
      $dia1 = "30";
      break;
    default:
      $dia1 = "31";
      break;
  }
  $fecha11 = $ano1."/".$mes1."/01";
  $fecha22 = $ano1."/".$mes1."/".$dia1;
  // Fin calculo de fechas
  $unidad = $_POST['unidad'];
  $super = $_POST['super'];
  if ($super == "0")
  {
  }
  else
  {
    if ($unidad == "999")
    {
    }
    else
    {
      $unidades = stringArray1($unidad);
    }
  }
  // Anexo T - Combustible - Mantenimiento - RTM - Llantas
  if (($tipo == "1") or ($tipo == "2") or ($tipo == "3") or ($tipo == "4") or ($tipo == "5"))
  {
    $pregunta = "SELECT sigla FROM cx_org_cmp WHERE conse='$tip_usuario'";
    $sql = odbc_exec($conexion, $pregunta);
    $compa = trim(odbc_result($sql,1));
    $gasolina = "";
    $salida = new stdClass();
    $valida = strpos($usu_usuario, "_");
    $valida = intval($valida);
    if (($valida == "0") or ($sup_usuario != "0"))
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
    if (($sup_usuario == "1") or ($sup_usuario == "2"))
    {
      $query = "SELECT placa, tipo, costo, clase FROM cx_pla_tra WHERE $combustible1 AND $complemento AND $complemento1";
    }
    else
    {
      $query = "SELECT placa, tipo, costo, clase FROM cx_pla_tra WHERE unidad='$uni_usuario' AND $combustible1 AND $complemento AND $complemento1";
    }
    if ($placa == "")
    {
    }
    else
    {
      if (($tipo == "3") or ($tipo == "4") or ($tipo == "5"))
      {
        $query = "SELECT placa, tipo, costo, clase FROM cx_pla_tra WHERE placa='$placa'";
      }
      else
      {
        $query .= " AND placa='$placa'";
      }
    }
    if ($super == "0")
    {
    }
    else
    {
      if ($unidad == "999")
      {
      }
      else
      {
        $query .= " AND unidad IN ($unidades)";
      }
    }
    $query .= " ORDER BY placa";
    // Agrupacion de compañias
    if ($agrupar == "1")
    {
      $query = "SELECT placa, tipo, costo, clase, compania FROM cx_pla_tra WHERE unidad='$uni_usuario' AND $combustible1 AND $complemento1";
      if ($placa == "")
      {
      }
      else
      {
        $query .= " AND placa='$placa'";
      }
      $query .= "  ORDER BY compania, placa";
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
    // Anexo T
    if ($tipo == "1")
    {
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
            if ($uni_usuario == "1")
            {
              $pregunta = str_replace("AND unidad='$uni_usuario' ", "", $pregunta);
            }
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
            if ($uni_usuario == "1")
            {
              $pregunta1 = str_replace("AND unidad='$uni_usuario' ", "", $pregunta1);
            }
            if ($agrupar == "1")
            {
              $pregunta1 = "SELECT ISNULL(SUM(consumo),0) AS consumo, ISNULL(SUM(total),0) AS total FROM ".$tabla." WHERE fecha='$fecha4' AND unidad='$uni_usuario' AND $combustible2 AND $complemento1 AND EXISTS (SELECT * FROM cx_pla_tra WHERE cx_pla_tra.placa=".$tabla.".placa)";
              if ($uni_usuario == "1")
              {
                $pregunta1 = str_replace("AND unidad='$uni_usuario' ", "", $pregunta1);
              }
            }
            if ($placa == "")
            {
            }
            else
            {
              $pregunta1 .= " AND placa='$placa'";
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
              if ($uni_usuario == "1")
              {
                $pregunta2 = str_replace("AND unidad='$uni_usuario' ", "", $pregunta2);
              }
              $sql2 = odbc_exec($conexion,$pregunta2);
              $minimo = odbc_result($sql2,1);
              $minimo = floatval($minimo);
              $maximo = odbc_result($sql2,2);
              $maximo = floatval($maximo);
              // Minimo kilometraje del siguiente mes
              $pregunta3 = "SELECT ISNULL(MIN(kilometraje),0) AS minimo FROM ".$tabla." WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha11',102) AND (CONVERT(datetime,'$fecha22',102)+1) AND unidad='$uni_usuario' AND placa='$placa' AND $combustible2 AND $complemento1";
              if ($uni_usuario == "1")
              {
                $pregunta3 = str_replace("AND unidad='$uni_usuario' ", "", $pregunta3);
              }
              $sql3 = odbc_exec($conexion,$pregunta3);
              $minimo1 = odbc_result($sql3,1);
              $minimo1 = floatval($minimo1);
              if ($minimo1 > $maximo)
              {
                $maximo = $minimo1;
              }
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
            $total5 = "0.00";
            $total5 = floatval($total5);
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
    // Combustible
    if ($tipo == "2")
    {
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
            // Valores grabados por placa y fecha
            if (($empadrona == "F") or ($empadrona == "G"))
            {
              $pregunta = "SELECT fecha, consumo, kilometraje, valor FROM ".$tabla." WHERE fecha='$fecha4' AND unidad='$uni_usuario' AND placa='$placa' AND $combustible2 AND $complemento1";
              if ($uni_usuario == "1")
              {
                $pregunta = str_replace("AND unidad='$uni_usuario' ", "", $pregunta);
              }
              $sql = odbc_exec($conexion,$pregunta);
              $total = odbc_num_rows($sql);
              if ($total>0)
              {
                $j = 0;
                while ($j < $row = odbc_fetch_array($sql))
                {
                  $fecha = substr(odbc_result($sql,1),0,10);
                  $consumo = odbc_result($sql,2);
                  $consumo = floatval($consumo);
                  $kilometraje = odbc_result($sql,3);
                  $valor = trim(odbc_result($sql,4));
                  $valor = str_replace(',','',$valor);
                  $valor = substr($valor,0,-3);
                  $valor = floatval($valor);
                  $bonos = 0;
                  $gasolina .= $placa."|".$costo."|".$consumo."|".$fecha."|".$kilometraje."|".$valor."|".$bonos."|#";
                }
              }
            }
            else
            {
              $pregunta = "SELECT fecha, consumo, kilometraje, valor, bonos FROM ".$tabla." WHERE fecha='$fecha4' AND unidad='$uni_usuario' AND placa='$placa' AND $combustible2 AND $complemento1";
              if ($uni_usuario == "1")
              {
                $pregunta = str_replace("AND unidad='$uni_usuario' ", "", $pregunta);
              }
              $sql = odbc_exec($conexion,$pregunta);
              $total = odbc_num_rows($sql);
              if ($total>0)
              {
                $fecha = substr(odbc_result($sql,1),0,10);
                $consumo = odbc_result($sql,2);
                $consumo = floatval($consumo);
                $kilometraje = odbc_result($sql,3);
                $valor = trim(odbc_result($sql,4));
                $bonos = odbc_result($sql,5);
                $gasolina .= $placa."|".$costo."|".$consumo."|".$fecha."|".$kilometraje."|".$valor."|".$bonos."|#";
              }
            }
          }
          $i++;
        }
      }
      $salida->gasolina = $gasolina;
      $salida->ngasolina = $ngasolina;
    }
    // Descripicion vehiculo
    // Mantenimiento - RTM - Llantas
    if (($tipo == "3") or ($tipo == "4") or ($tipo == "5"))
    {
      $query = "SELECT clase, marca, linea, modelo, activo, tipo, unidad, fec_rtf FROM cx_pla_tra WHERE placa='$placa' AND $complemento1";
      $sql = odbc_exec($conexion, $query);
      $clase = odbc_result($sql,1);
      $marca = trim(odbc_result($sql,2));
      $linea = trim(odbc_result($sql,3));
      $modelo = trim(odbc_result($sql,4));
      $activo = trim(odbc_result($sql,5))." ";
      $tipo1 = odbc_result($sql,6);
      $unidan = odbc_result($sql,7);
      $rtm = substr(odbc_result($sql,8),0,10);
      if ($rtm == "1900-01-01")
      {
        $rtm = "";
      }
      $pregunta5 = "SELECT nombre FROM cx_ctr_veh WHERE codigo='$clase'";
      $sql5 = odbc_exec($conexion, $pregunta5);
      $n_clase = trim(utf8_encode(odbc_result($sql5,1)));
      switch ($tipo1)
      {
        case '1':
          $n_tipo = "GASOLINA";
          break;
        case '2':
          $n_tipo = "ACPM";
          break;
        case '3':
          $n_tipo = "DIESEL";
          break;
        default:
          $n_tipo = "";
          break;
      }
      $descripcion = $n_clase." ".$marca." ".$linea." MODELO ".$modelo." ".$n_tipo;
      // Sigla de placa a consultar
      $query1 = "SELECT sigla FROM cv_unidades WHERE subdependencia='$unidan'";
      $sql1 = odbc_exec($conexion, $query1);
      $sigla = odbc_result($sql1,1);
    }
    // Mantenimiento
    if ($tipo == "3")
    {
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
          if (($empadrona == "F") or ($empadrona == "G"))
          {
            $pregunta = "SELECT conse, unidad, consecu, ano, usuario, fecha, periodo FROM cx_rel_gas WHERE periodo BETWEEN '$periodo' AND '$periodo2' AND ano='$ano' AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.conse1=cx_rel_gas.conse AND cx_rel_dis.ano=cx_rel_gas.ano AND cx_rel_dis.consecu=cx_rel_gas.consecu AND cx_rel_dis.gasto IN ('38', '44') AND cx_rel_dis.datos LIKE '%$placa%')";
            if ($unidad == "999")
            {
            }
            else
            {
              $query .= " AND unidad IN ($unidades)";
            }
            $pregunta .= " ORDER BY fecha DESC";
            $sql = odbc_exec($conexion, $pregunta);
            $total = odbc_num_rows($sql);
            $valores = "";
            $salida = new stdClass();
            if ($total>0)
            {
              $i = 0;
              while ($i < $row = odbc_fetch_array($sql))
              {
                $conse = odbc_result($sql,1);
                $unidad1 = odbc_result($sql,2);
                $consecu = odbc_result($sql,3);
                $ano = odbc_result($sql,4);
                $usuario = odbc_result($sql,5);
                $fecha = odbc_result($sql,6);
                $fecha = substr($fecha,0,10);
                $periodo = odbc_result($sql,7);
                $mes = str_pad($periodo,2,"0",STR_PAD_LEFT);
                $pregunta1 = "SELECT valor, datos, gasto FROM cx_rel_dis WHERE conse1='$conse' AND consecu='$consecu' AND ano='$ano' AND gasto IN ('38', '44') AND datos LIKE '%$placa%'";
                $sql1 = odbc_exec($conexion, $pregunta1);
                $l = 0;
                while ($l < $row = odbc_fetch_array($sql1))
                {
                  $valor = trim(odbc_result($sql1,1));
                  $datos = trim(utf8_encode($row['datos']));
                  $datoz = "";
                  $num_datos = explode("|", $datos);
                  for ($z=0;$z<count($num_datos)-1;++$z)
                  {
                    $datox = $num_datos[$z];
                    $num_datox = explode("»", $datox);
                    $datoy = $num_datox[1];
                    $datow = trim($num_datox[4]);
                    if ($datoy == $placa)
                    {
                      $datoz .= $datox."|";
                    }                  
                  }
                  $gasto1 = odbc_result($sql1,3);
                  if (($datow == "0") or ($datow == "0.0") or ($datow == ""))
                  {
                  }
                  else
                  {
                    $gasolina .= $placa."^".$clase."^".$datoz."^".$gasto1."^#";
                  }
                }
                $l++;
              }
            }
          }
          else
          {
            $pregunta = "SELECT valores, fecha FROM cx_tra_man WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND placa='$placa'";
            $sql = odbc_exec($conexion, $pregunta);
            $row = odbc_fetch_array($sql);
            $datos = trim(utf8_encode($row["valores"]));
            $n_fecha = substr(odbc_result($sql,2),0,10);
            $num_datos = explode("|",$datos);
            $datos1 = "";
            for ($j=0;$j<count($num_datos)-1;++$j)
            {
              $var_datos = $num_datos[$j];
              $paso = explode("»",$var_datos);
              $var1 = $paso[0];
              $var2 = $paso[1];
              $var3 = $paso[2];
              $var3_1 = str_replace(',','',$var3);
              $var3_1 = floatval($var3_1);
              $var4 = $paso[3];
              $var4_1 = str_replace(',','',$var4);
              $var4_1 = floatval($var4_1);
              $var5 = $paso[4];
              $var5_1 = str_replace(',','',$var5);
              $var5_1 = floatval($var5_1);
              $paso1 = explode(",",$var1);
              $var6 = $paso1[0];
              $pregunta1 = "SELECT nombre, medida FROM cx_ctr_man WHERE codigo='$var6'";
              $sql1 = odbc_exec($conexion, $pregunta1);
              $row1 = odbc_fetch_array($sql1);
              $n_mante = trim(utf8_encode($row1["nombre"]));
              $n_unida = odbc_result($sql1,2);
              switch ($n_unida)
              {
                case '1':
                  $m_unida = "UNIDAD";
                  break;
                case '2':
                  $m_unida = "JUEGO";
                  break;
                case '3':
                  $m_unida = "COPAS";
                  break;
                default:
                  $m_unida = "UNIDAD";
                  break;
              }
              $n_mante = $n_mante." - ".$m_unida;
              $datos1 .= $n_clase."»".$placa."»".$var2."»".$var3."»".$var3_1."»".$var5."»".$var5_1."»0»".$var4."»".$var4_1."»0.00»0.00»0.00»0»".$n_mante."»".$n_fecha."»N/A»".$var6."»99999_0»".$sigla."»0|";
            }
            $gasto1 = "38";
            $gasolina .= $placa."^".$clase."^".$datos1."^".$gasto1."^#";
          }
          $i++;
        }
      }
      $salida->gasolina = $gasolina;
      $salida->ngasolina = $ngasolina;
    }
    // RTM
    if ($tipo == "4")
    {
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
          if (($empadrona == "F") or ($empadrona == "G"))
          {
            $pregunta = "SELECT conse, unidad, consecu, ano, usuario, fecha, periodo FROM cx_rel_gas WHERE periodo BETWEEN '$periodo' AND '$periodo2' AND ano='$ano' AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.conse1=cx_rel_gas.conse AND cx_rel_dis.ano=cx_rel_gas.ano AND cx_rel_dis.consecu=cx_rel_gas.consecu AND cx_rel_dis.gasto IN ('39', '45') AND cx_rel_dis.datos LIKE '%$placa%')";
            if ($unidad == "999")
            {
            }
            else
            {
              $query .= " AND unidad IN ($unidades)";
            }
            $pregunta .= " ORDER BY fecha DESC";
            $sql = odbc_exec($conexion, $pregunta);
            $total = odbc_num_rows($sql);
            $valores = "";
            $salida = new stdClass();
            if ($total>0)
            {
              $i = 0;
              while ($i < $row = odbc_fetch_array($sql))
              {
                $conse = odbc_result($sql,1);
                $unidad1 = odbc_result($sql,2);
                $consecu = odbc_result($sql,3);
                $ano = odbc_result($sql,4);
                $usuario = odbc_result($sql,5);
                $fecha = odbc_result($sql,6);
                $fecha = substr($fecha,0,10);
                $periodo = odbc_result($sql,7);
                $mes = str_pad($periodo,2,"0",STR_PAD_LEFT);
                $pregunta1 = "SELECT valor, datos, gasto FROM cx_rel_dis WHERE conse1='$conse' AND consecu='$consecu' AND ano='$ano' AND gasto IN ('39', '45') AND datos LIKE '%$placa%'";
                $sql1 = odbc_exec($conexion, $pregunta1);
                $l = 0;
                while ($l < $row = odbc_fetch_array($sql1))
                {
                  $valor = trim(odbc_result($sql1,1));
                  $datos = trim(utf8_encode($row['datos']));
                  $gasto1 = odbc_result($sql1,3);
                  $gasolina .= $placa."^".$clase."^".$datos."^".$gasto1."^#";
                }
                $l++;
              }
            }
          }
          else
          {
            $pregunta = "SELECT valores, fecha FROM cx_tra_rtm WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND placa='$placa'";
            $sql = odbc_exec($conexion, $pregunta);
            $row = odbc_fetch_array($sql);
            $datos = trim(utf8_encode($row["valores"]));
            $n_fecha = substr(odbc_result($sql,2),0,10);
            $num_datos = explode("|",$datos);
            $datos1 = "";
            for ($j=0;$j<count($num_datos)-1;++$j)
            {
              $var_datos = $num_datos[$j];
              $paso = explode("»",$var_datos);
              $var1 = $paso[0];
              $var2 = $paso[1];
              $var3 = $paso[2];
              $var4 = $paso[3];
              $var4_1 = str_replace(',','',$var4);
              $var4_1 = floatval($var4_1);
              $var5 = $paso[4];
              $var5_1 = str_replace(',','',$var5);
              $var5_1 = floatval($var5_1);
              $var6 = $paso[5];
              $var6_1 = str_replace(',','',$var6);
              $var6_1 = floatval($var6_1);
              $paso1 = explode(",",$var1);
              $var7 = $paso1[0];
              $pregunta1 = "SELECT nombre FROM cx_ctr_rtm WHERE codigo='$var7'";
              $sql1 = odbc_exec($conexion, $pregunta1);
              $row1 = odbc_fetch_array($sql1);
              $n_rtm = trim(utf8_encode($row1["nombre"]));
              $datos1 .= $n_clase."»".$placa."»".$var3."»".$var4."»".$var4_1."»".$var6."»".$var6_1."»".$var2."»".$n_fecha."»N/A»".$var7."»".$sigla."»0|";
            }
            $gasto1 = "39";
            $gasolina .= $placa."^".$clase."^".$datos1."^".$gasto1."^#";
          }
          $i++;
        }
      }
      $salida->gasolina = $gasolina;
      $salida->ngasolina = $ngasolina;
    }
    // Llantas
    if ($tipo == "5")
    {
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
          if (($empadrona == "F") or ($empadrona == "G"))
          {
            $pregunta = "SELECT conse, unidad, consecu, ano, usuario, fecha, periodo FROM cx_rel_gas WHERE periodo BETWEEN '$periodo' AND '$periodo2' AND ano='$ano' AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.conse1=cx_rel_gas.conse AND cx_rel_dis.ano=cx_rel_gas.ano AND cx_rel_dis.consecu=cx_rel_gas.consecu AND cx_rel_dis.gasto IN ('40', '46') AND cx_rel_dis.datos LIKE '%$placa%')";
            if ($unidad == "999")
            {
            }
            else
            {
              $query .= " AND unidad IN ($unidades)";
            }
            $pregunta .= " ORDER BY fecha DESC";
            $sql = odbc_exec($conexion, $pregunta);
            $total = odbc_num_rows($sql);
            $valores = "";
            $salida = new stdClass();
            if ($total>0)
            {
              $i = 0;
              while ($i < $row = odbc_fetch_array($sql))
              {
                $conse = odbc_result($sql,1);
                $unidad1 = odbc_result($sql,2);
                $consecu = odbc_result($sql,3);
                $ano = odbc_result($sql,4);
                $usuario = odbc_result($sql,5);
                $fecha = odbc_result($sql,6);
                $fecha = substr($fecha,0,10);
                $periodo = odbc_result($sql,7);
                $mes = str_pad($periodo,2,"0",STR_PAD_LEFT);
                $pregunta1 = "SELECT valor, datos, gasto FROM cx_rel_dis WHERE conse1='$conse' AND consecu='$consecu' AND ano='$ano' AND gasto IN ('40', '46') AND datos LIKE '%$placa%'";
                $sql1 = odbc_exec($conexion, $pregunta1);
                $l = 0;
                while ($l < $row = odbc_fetch_array($sql1))
                {
                  $valor = trim(odbc_result($sql1,1));
                  $datos = trim(utf8_encode($row['datos']));
                  $gasto1 = odbc_result($sql1,3);
                  $gasolina .= $placa."^".$clase."^".$datos."^".$gasto1."^#";
                }
                $l++;
              }
            }
          }
          else
          {
            $pregunta = "SELECT valores, fecha FROM cx_tra_lla WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND placa='$placa'";
            $sql = odbc_exec($conexion, $pregunta);
            $row = odbc_fetch_array($sql);
            $datos = trim(utf8_encode($row["valores"]));
            $n_fecha = substr(odbc_result($sql,2),0,10);
            $num_datos = explode("|",$datos);
            $datos1 = "";
            for ($j=0;$j<count($num_datos)-1;++$j)
            {

              $var_datos = $num_datos[$j];
              $paso = explode("»",$var_datos);
              $var1 = $paso[0];
              $var2 = $paso[1];
              $var3 = $paso[2];
              $var4 = $paso[3];
              $var4_1 = str_replace(',','',$var4);
              $var4_1 = floatval($var4_1);
              $var5 = $paso[4];
              $var5_1 = str_replace(',','',$var5);
              $var5_1 = floatval($var5_1);
              $var6 = $paso[5];
              $var6_1 = str_replace(',','',$var6);
              $var6_1 = floatval($var6_1);
              $paso1 = explode(",",$var1);
              $var7 = $paso1[0];
              $pregunta1 = "SELECT descripcion FROM cx_ctr_lla WHERE codigo='$var7'";
              $sql1 = odbc_exec($conexion, $pregunta1);
              $row1 = odbc_fetch_array($sql1);
              $n_lla = trim(utf8_encode($row1["descripcion"]));
              $n_lla = str_replace("\r", " ", $n_lla);
              $n_lla = str_replace("\n", " ", $n_lla);
              $var2 = $var2." - ".$n_lla;
              $datos1 .= $n_clase."»".$placa."»".$var3."»0»".$var4."»".$var4_1."»".$var6."»".$var6_1."»".$var2."»»»".$n_fecha."»N/A»".$var7."»".$sigla."»0|";
            }
            $gasto1 = "40";
            $gasolina .= $placa."^".$clase."^".$datos1."^".$gasto1."^#";
          }
          $i++;
        }
      }
      $salida->gasolina = $gasolina;
      $salida->ngasolina = $ngasolina;
    }
    $salida->descripcion = $descripcion;
    $salida->activo = $activo;
    $salida->sigla = $sigla;
    $salida->rtm = $rtm;
  }
  echo json_encode($salida);
}
// 08/08/2023 - Ajuste consulta combustible login usuario
// 25/10/2023 - Consulta de combustible
// 26/10/2023 - Ajuste consulta cede2 para busqueda
// 14/11/2023 - Consulta de mantenimiento
// 07/12/2023 - Inclusión descripción del vehículo
// 11/01/2023 - Ajuste excel contratos
// 16/01/2024 - Ajuste periodo inicial y final en consulta
// 22/01/2024 - Ajuste excel mantenimientos desde informe gastos
// 19/02/2024 - Ajuste para individualizar consulta por empadronamiento
// 23/02/2024 - Ajuste por creacion de tabla de configuracion de vehiculos
?>