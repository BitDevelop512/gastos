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
  $placa1 = $placa;
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
    if ($empadrona == "M")
    {
      $tabla = "cv_tra_mov";
      $complemento1 = "empadrona>'0'";
    }
    else
    {
      $tabla = "cv_tra_moc";
      $complemento1 = "empadrona='3'";
    }
  }
  $combustible = $_POST['combustible'];
  if ($combustible == "0")
  {
		$combustible1 = "tipo IN ('1', '2', '3')";
		$combustible2 = "combustible IN ('1', '2', '3')";
  }
  else
  {
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
	}
  if ($tipo == "2")
  {
    if ($empadrona == "F")
    {
      $complemento1 = "empadrona>'0'";
    }
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
    if ($tipo == "6")
    {
      $unidades = stringArray1($unidad);
    }
  }
  else
  {
    if ($unidad == "999")
    {
    }
    else
    {
      $unidades = stringArray1($unidad);
      if ($unidades == "1")
      {
        $unidades = "'1', '2'";
      }
      else
      {
        if ($unidades == "2")
        {
          $unidades = "'2'";
        }
      }
    }
  }
  // Gestion
  if ($tipo == "6")
  {
    $gasolina = "";
    $salida = new stdClass();
    $pregunta = "SELECT unidad, dependencia FROM cv_unidades WHERE subdependencia IN ($unidades)";
    $sql = odbc_exec($conexion, $pregunta);
    $i = 0;
    while($i < $row = odbc_fetch_array($sql))
    {
      $v_unidad = odbc_result($sql,1);
      $v_dependencia = odbc_result($sql,2);
      if ($v_unidad > 3)
      {
        $pregunta1 = "SELECT subdependencia FROM cv_unidades WHERE unidad='$v_unidad' ORDER BY subdependencia";
      }
      else
      {
        $pregunta1 = "SELECT subdependencia FROM cv_unidades WHERE unidad='$v_unidad' AND dependencia='$v_dependencia' ORDER BY subdependencia";
      }
      $sql1 = odbc_exec($conexion, $pregunta1);
      $j = 0;
      $v_unidades = "";
      while($j < $row1 = odbc_fetch_array($sql1))
      {
        $v_subdependencia = odbc_result($sql1,1);
        $v_unidades .= $v_subdependencia.",";
        $j++;
      }
      $v_unidades = substr($v_unidades,0,-1);
      $pregunta2 = "SELECT n_unidad, n_dependencia, subdependencia, sigla, sigla1, fecha FROM cv_unidades WHERE subdependencia IN ($v_unidades) ORDER BY subdependencia";
      $sql2 = odbc_exec($conexion, $pregunta2);
      $k = 0;
      while($k < $row2 = odbc_fetch_array($sql2))
      {
        $v_centralizadora = trim(odbc_result($sql2,1));
        $v_brigada = trim(odbc_result($sql2,2));
        $v_subdependencia = odbc_result($sql2,3);
        $v_sigla = trim(odbc_result($sql2,4));
        $pregunta3 = "SELECT compania, placa FROM cx_pla_tra WHERE unidad='$v_subdependencia' AND estado='1'";
        $sql3 = odbc_exec($conexion, $pregunta3);
        $l = 0;
        while($l < $row3 = odbc_fetch_array($sql3))
        {
          $v_compania = trim(odbc_result($sql3,1));
          $v_placa = trim(odbc_result($sql3,2));
          if (($empadrona == "F") or ($empadrona == "G"))
          {
            $pregunta4 = "SELECT SUM(total) AS total, SUM(consumo) AS consumo, ISNULL(MIN(kilometraje),0) AS minimo, ISNULL(MAX(kilometraje),0) AS maximo FROM cx_tra_mov WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND CONVERT(datetime,'$fecha2',102) AND placa='$v_placa'";
          }
          else
          {
            $pregunta4 = "SELECT SUM(total) AS total, SUM(consumo) AS consumo, ISNULL(MIN(kilometraje),0) AS minimo, ISNULL(MAX(kilometraje),0) AS maximo FROM cx_tra_moc WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND CONVERT(datetime,'$fecha2',102) AND placa='$v_placa'";
          }
          $sql4 = odbc_exec($conexion, $pregunta4);
          $v_total = odbc_result($sql4,1);
          $v_total = floatval($v_total);
          $v_consumo = odbc_result($sql4,2);
          $v_consumo = floatval($v_consumo);
          $v_minimo = odbc_result($sql4,3);
          $v_minimo = floatval($v_minimo);
          $v_maximo = odbc_result($sql4,4);
          $v_maximo = floatval($v_maximo);
          $v_recorrido = $v_maximo-$v_minimo;
          $v_recorrido = floatval($v_recorrido);
          // Empadronamiento
          if (($empadrona == "F") or ($empadrona == "G"))
          {
            // Mantenimientos
            $pregunta5 = "SELECT conse, consecu, ano FROM cx_rel_gas WHERE periodo BETWEEN '$periodo' AND '$periodo2' AND ano='$ano' AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.conse1=cx_rel_gas.conse AND cx_rel_dis.ano=cx_rel_gas.ano AND cx_rel_dis.consecu=cx_rel_gas.consecu AND cx_rel_dis.gasto IN ('38', '44') AND cx_rel_dis.datos LIKE '%$v_placa%') ORDER BY fecha DESC";
            $sql5 = odbc_exec($conexion, $pregunta5);
            $total5 = odbc_num_rows($sql5);
            $v_mante = 0;
            $v_iva = 0;
            if ($total5 > 0)
            {
              $m = 0;
              while ($m < $row4 = odbc_fetch_array($sql5))
              {
                $conse = odbc_result($sql5,1);
                $consecu = odbc_result($sql5,2);
                $ano = odbc_result($sql5,3);
                // Iva
                $pregunta7 = "SELECT bienes FROM cx_pla_gad WHERE conse1='$consecu' AND ano='$ano' AND gasto IN ('38', '44')  AND bienes LIKE '%$v_placa%'";
                $sql7 = odbc_exec($conexion, $pregunta7);
                $row7 = odbc_fetch_array($sql7);
                $bienes = trim(utf8_encode($row7["bienes"]));
                $var_ocu = explode("#",$bienes);
                $v_iva = $var_ocu[16];
                $v_iva = floatval($v_iva);
                $pregunta6 = "SELECT datos FROM cx_rel_dis WHERE conse1='$conse' AND consecu='$consecu' AND ano='$ano' AND gasto IN ('38', '44') AND datos LIKE '%$v_placa%'";
                $sql6 = odbc_exec($conexion, $pregunta6);
                $n = 0;
                while ($n < $row5 = odbc_fetch_array($sql6))
                {
                  $datos = trim(utf8_encode($row5['datos']));
                  $datoz = "";
                  $num_datos = explode("|", $datos);
                  for ($z=0;$z<count($num_datos)-1;++$z)
                  {
                    $datox = $num_datos[$z];
                    $num_datox = explode("»", $datox);
                    $datoy = $num_datox[1];
                    $datow = trim($num_datox[13]);
                    $datow = floatval($datow);
                    if ($datoy == $v_placa)
                    {
                      $v_mante = $v_mante+$datow;
                    }                  
                  }
                  $v_mante = $v_mante+$v_iva;
                  $n++;
                }
                $m++;                
              }
            }
            // RTM
            $pregunta5 = "SELECT conse, consecu, ano FROM cx_rel_gas WHERE periodo BETWEEN '$periodo' AND '$periodo2' AND ano='$ano' AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.conse1=cx_rel_gas.conse AND cx_rel_dis.ano=cx_rel_gas.ano AND cx_rel_dis.consecu=cx_rel_gas.consecu AND cx_rel_dis.gasto IN ('39', '45') AND cx_rel_dis.datos LIKE '%$v_placa%') ORDER BY fecha DESC";
            $sql5 = odbc_exec($conexion, $pregunta5);
            $total5 = odbc_num_rows($sql5);
            $v_rtm = 0;
            if ($total5 > 0)
            {
              $m = 0;
              while ($m < $row4 = odbc_fetch_array($sql5))
              {
                $conse = odbc_result($sql5,1);
                $consecu = odbc_result($sql5,2);
                $ano = odbc_result($sql5,3);
                $pregunta6 = "SELECT valor1, datos FROM cx_rel_dis WHERE conse1='$conse' AND consecu='$consecu' AND ano='$ano' AND gasto IN ('39', '45') AND datos LIKE '%$v_placa%'";
                $sql6 = odbc_exec($conexion, $pregunta6);
                $n = 0;
                while ($n < $row5 = odbc_fetch_array($sql6))
                {
                  $valor = trim(odbc_result($sql6,1));
                  $valor = floatval($valor);
                  $v_rtm = $v_rtm+$valor;
                  $n++;
                }
                $m++;                
              }
            }
            // Llantas
            $pregunta5 = "SELECT conse, consecu, ano FROM cx_rel_gas WHERE periodo BETWEEN '$periodo' AND '$periodo2' AND ano='$ano' AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.conse1=cx_rel_gas.conse AND cx_rel_dis.ano=cx_rel_gas.ano AND cx_rel_dis.consecu=cx_rel_gas.consecu AND cx_rel_dis.gasto IN ('40', '46') AND cx_rel_dis.datos LIKE '%$v_placa%') ORDER BY fecha DESC";
            $sql5 = odbc_exec($conexion, $pregunta5);
            $total5 = odbc_num_rows($sql5);
            $v_llantas = 0;
            if ($total5 > 0)
            {
              $m = 0;
              while ($m < $row4 = odbc_fetch_array($sql5))
              {
                $conse = odbc_result($sql5,1);
                $consecu = odbc_result($sql5,2);
                $ano = odbc_result($sql5,3);
                $pregunta6 = "SELECT valor1, datos FROM cx_rel_dis WHERE conse1='$conse' AND consecu='$consecu' AND ano='$ano' AND gasto IN ('40', '46') AND datos LIKE '%$v_placa%'";
                $sql6 = odbc_exec($conexion, $pregunta6);
                $n = 0;
                while ($l < $row5 = odbc_fetch_array($sql6))
                {
                  $valor = trim(odbc_result($sql6,1));
                  $valor = floatval($valor);
                  $v_llantas = $v_llantas+$valor;
                  $n++;
                }
                $m++;
              }
            }
          }
          else
          {
            // Mantenimientos - RTM - Llantas
            $pregunta5 = "SELECT SUM(total1) AS mante, (SELECT SUM(total1) FROM cx_tra_rtm WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND placa='$v_placa') AS rtm, (SELECT SUM(total1) FROM cx_tra_lla WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND placa='$v_placa') AS llantas FROM cx_tra_man WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND placa='$v_placa'";
            $sql5 = odbc_exec($conexion, $pregunta5);
            $v_mante = odbc_result($sql5,1);
            $v_mante = floatval($v_mante);
            $v_rtm = odbc_result($sql5,2);
            $v_rtm = floatval($v_rtm);
            $v_llantas = odbc_result($sql5,3);
            $v_llantas = floatval($v_llantas);
          }
          if (($v_total == "0") AND ($v_consumo == "0") AND ($v_minimo == "0") AND ($v_maximo == "0") AND ($v_recorrido == "0") AND ($v_mante == "0") AND ($v_rtm == "0") AND ($v_llantas == "0"))
          {
          }
          else
          {
            $gasolina .= $v_centralizadora."^".$v_brigada."^".$v_subdependencia."^".$v_sigla."^".$v_compania."^".$v_placa."^".$v_total."^".$v_consumo."^".$v_minimo."^".$v_maximo."^".$v_recorrido."^".$v_mante."^".$v_rtm."^".$v_llantas."^#";
          }
          $l++;
        }
        $k++;
      }
      $i++;
    }
    $salida->gasolina = $gasolina;
  }
  else
  {
    // Anexo T - Combustible - Mantenimiento - RTM - Llantas
    if (($tipo == "1") or ($tipo == "2") or ($tipo == "3") or ($tipo == "4") or ($tipo == "5"))
    {
      // Placas con movimiento de traspaso
      $placa2 = "";
      $pregunta0 = "SELECT placa FROM cx_tra_mom WHERE unidad='$uni_usuario' OR unidad1='$uni_usuario'";
      $sql = odbc_exec($conexion, $pregunta0);
      while($i<$row=odbc_fetch_array($sql))
      {
        $v_placa = odbc_result($sql,1);
        $placa2 .= "'".$v_placa."', ";
        $i++;
      }
      $placa2 = substr($placa2,0,-2);
      // Placas con movimiento de contratos traspasados
      $placa3 = "";
      if (($uni_usuario == "1") or ($uni_usuario == "2"))
      {
      	$unidades1 = $unidades;
      }
      else
      {
      	$unidades1 = $uni_usuario;
      }
      $pregunta0 = "SELECT placa FROM cx_tra_rtm WHERE unidad IN ($unidades1)";
      $sql = odbc_exec($conexion, $pregunta0);
      while($i<$row=odbc_fetch_array($sql))
      {
        $v_placa = odbc_result($sql,1);
        $placa3 .= "'".$v_placa."', ";
        $i++;
      }
      $placa3 = substr($placa3,0,-2);
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
        if ($tpc_usuario == "1")
        {
          $complemento = "1=1";
        }
      }
      $query = "SELECT placa, tipo, costo, clase, (SELECT nombre FROM cx_ctr_veh WHERE codigo=cx_pla_tra.clase) AS clase1, marca, linea, modelo, activo, (SELECT nombre FROM cx_ctr_com WHERE codigo=cx_pla_tra.tipo) AS tipo1, unidad, fec_rtf, (SELECT sigla FROM cv_unidades WHERE subdependencia=cx_pla_tra.unidad) AS sigla, (SELECT nombre FROM cv_unidades WHERE subdependencia=cx_pla_tra.unidad) AS nombre FROM cx_pla_tra WHERE $combustible1 AND $complemento AND $complemento1";
      if (($sup_usuario == "1") or ($sup_usuario == "2"))
      {
      }
      else
      {
        $v_unidades = "";
        $query1 = "SELECT unidad, dependencia, unic FROM cv_unidades WHERE subdependencia='$uni_usuario'";
        $cur1 = odbc_exec($conexion, $query1);
        $v_unidad = odbc_result($cur1,1);
        $v_dependencia= odbc_result($cur1,2);
        $v_unic = odbc_result($cur1,3);
        if ($v_unic == "1")
        {
          $query2 = "SELECT subdependencia FROM cv_unidades WHERE unidad='$v_unidad' AND dependencia='$v_dependencia' ORDER BY subdependencia";
          $cur2 = odbc_exec($conexion, $query2);
          $i = 0;
          while ($i < $row = odbc_fetch_array($cur2))
          {
            $v_unidades .= odbc_result($cur2,1).",";
            $i++;
          }
          $v_unidades = substr($v_unidades,0,-1);
          $query .= " AND unidad IN ($v_unidades)";
        }
        else
        {
          $query .= " AND unidad='$uni_usuario'";
        }
      }
      if (($placa == "") or ($placa == "-"))
      {
      }
      else
      {
        if (($tipo == "3") or ($tipo == "4") or ($tipo == "5"))
        {
          $query = "SELECT placa, tipo, costo, clase, (SELECT nombre FROM cx_ctr_veh WHERE codigo=cx_pla_tra.clase) AS clase1, marca, linea, modelo, activo, (SELECT nombre FROM cx_ctr_com WHERE codigo=cx_pla_tra.tipo) AS tipo1, unidad, fec_rtf, (SELECT sigla FROM cv_unidades WHERE subdependencia=cx_pla_tra.unidad) AS sigla, (SELECT nombre FROM cv_unidades WHERE subdependencia=cx_pla_tra.unidad) AS nombre FROM cx_pla_tra WHERE placa='$placa'";
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
          if (($tipo == "3") or ($tipo == "4") or ($tipo == "5"))
          {
            if (($sup_usuario == "1") or ($sup_usuario == "2"))
            {
              $query0 = "SELECT unidad, dependencia, tipo, unic FROM cx_org_sub WHERE subdependencia in ($unidades) AND estado!='X'";
              $cur0 = odbc_exec($conexion, $query0);
              $n_unidad = odbc_result($cur0,1);
              $n_dependencia = odbc_result($cur0,2);
              $n_tipo = odbc_result($cur0,3);
              $n_unic = odbc_result($cur0,4);
              if ($n_unic == "0")
              {
                $numero = $unidades;
              }
              else
              {
                if (($n_unidad == "1") or ($n_unidad == "2") or ($n_unidad == "3"))
                {
                  if (($n_unidad == "2") or ($n_unidad == "3"))
                  {
                    $pregunta0 = "SELECT dependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND estado!='X'";
                    $sql0 = odbc_exec($conexion, $pregunta0);
                    $dependencia = odbc_result($sql0,1);
                    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' AND estado!='X' ORDER BY subdependencia";
                  }
                  else
                  {
                    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' AND tipo='2' AND unic='0' AND estado!='X' ORDER BY subdependencia";
                  }
                }
                else
                {
                  if ($n_tipo == "7")
                  {
                    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' AND estado!='X' ORDER BY subdependencia";
                  }
                  else
                  {
                    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND estado!='X' ORDER BY subdependencia";
                  }
                }
                $cur1 = odbc_exec($conexion, $query1);
                $numero = "";
                while($i<$row=odbc_fetch_array($cur1))
                {
                  $numero .= "'".odbc_result($cur1,1)."',";
                }
                $numero = substr($numero,0,-1);
                // Se verifica si es unidad centralizadora especial
                if (strpos($especial, $unidad) !== false)
                {
                  $numero .= ",";
                  $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$n_unidad' AND estado!='X' ORDER BY unidad";
                  $cur = odbc_exec($conexion, $query);
                  while($i<$row=odbc_fetch_array($cur))
                  {
                    $n_unidad = odbc_result($cur,1);
                    $n_dependencia = odbc_result($cur,2);
                    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND estado!='X' ORDER BY dependencia, subdependencia";
                    $cur1 = odbc_exec($conexion, $query1);
                    while($j<$row=odbc_fetch_array($cur1))
                    {
                      $numero .= "'".odbc_result($cur1,1)."',";
                    }
                  }
                  $numero .= $uni_usuario;
                }
              }
              $query .= " AND unidad in ($numero)";
            }
            else
            {
              $query .= " AND unidad IN ($unidades)";
            }
          }
          else
          {
            if ($tipo == "2")
            {
            }
            else
            {
              $query .= " AND EXISTS(SELECT * FROM $tabla WHERE $tabla.placa=cx_pla_tra.placa AND $tabla.unidad IN ($unidades))";
            }
          }
        }
      }
      if ($placa2 == "")
      {
      }
      else
      {
        $query .= " OR placa IN ($placa2)";
      }
      // Combustible
      if ($tipo == "2")
      {
        if ($empadrona == "B")
        {
          $query .= " OR EXISTS(SELECT * FROM cx_tra_moc WHERE cx_tra_moc.placa=cx_pla_tra.placa ";
          if (($placa == "") or ($placa == "-"))
          {
            $query .= ")";
          }
          else
          {
            $query .= "AND placa='$placa')";
          }
        }
        if ($unidad == "999")
        {
        }
        else
        {
          $v_unidades = "";
          $pregunta = "SELECT unidad, dependencia, subdependencia, unic FROM cv_unidades WHERE subdependencia IN ($unidades)";
          $sql = odbc_exec($conexion, $pregunta);
          $i = 0;
          while($i<$row=odbc_fetch_array($sql))
          {
            $v_unidad = odbc_result($sql,1);
            $v_dependencia = odbc_result($sql,2);
            $v_subdependencia = odbc_result($sql,3);
            $v_unic = odbc_result($sql,4);
            if ($v_unic == "1")
            {
              if ($v_unidad > 3)
              {
                $pregunta1 = "SELECT subdependencia FROM cv_unidades WHERE unidad='$v_unidad' ORDER BY subdependencia";
              }
              else
              {
                $pregunta1 = "SELECT subdependencia FROM cv_unidades WHERE unidad='$v_unidad' AND dependencia='$v_dependencia' ORDER BY subdependencia";
              }
              $sql1 = odbc_exec($conexion, $pregunta1);
              $j = 0;
              while($j<$row=odbc_fetch_array($sql1))
              {
                $v_subdependencia = odbc_result($sql1,1);
                $v_unidades .= $v_subdependencia.",";
                $j++;
              }
            }
            else
            {
              $v_unidades .= $v_subdependencia.",";
            }
          }
          $v_unidades = substr($v_unidades,0,-1);
          $query .= " AND unidad IN ($v_unidades)";
        }
      }
      // RTM
      if ($tipo == "4")
      {
  	    if ($placa3 == "")
  	    {
  	    }
  	    else
  	    {
  	      $query .= " OR placa IN ($placa3)";
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
        $query .= " ORDER BY compania, placa";
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
                //$pregunta .= " AND unidad IN ($unidades)";
              }
              $sql = odbc_exec($conexion,$pregunta);
              $total = odbc_num_rows($sql);
              if ($total>0)
              {
                $consumo = odbc_result($sql,1);
                $consumo = floatval($consumo);
                if ($empadrona == "M")
                {
                  $preguntax = str_replace("cv_tra_mov", "cv_tra_moc", $pregunta);
                  $sqlx = odbc_exec($conexion,$preguntax);
                  $consumox = odbc_result($sqlx,1);
                  $consumox = floatval($consumox);
                  $consumo = $consumo+$consumox;
                }
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
              if ($unidad == "999")
              {
              }
              else
              {
                if ($uni_usuario == "1")
                {
                	if ($super == "0")
                	{
                  	$pregunta1 .= " AND unidad IN ('1', '2')";
                	}
                	else
                	{
                		$pregunta1 .= " AND unidad IN ($unidades)";
                  }
                }
                else
                {
                  $pregunta1 .= " AND unidad IN ($unidades)";
                }
              }
              if ($agrupar == "1")
              {
                $pregunta1 = "SELECT ISNULL(SUM(consumo),0) AS consumo, ISNULL(SUM(total),0) AS total FROM ".$tabla." WHERE fecha='$fecha4' AND unidad='$uni_usuario' AND $combustible2 AND $complemento1 AND EXISTS (SELECT * FROM cx_pla_tra WHERE cx_pla_tra.placa=".$tabla.".placa)";
                if ($uni_usuario == "1")
                {
                  $pregunta1 = str_replace("AND unidad='$uni_usuario' ", "", $pregunta1);
                }
              }
              if ($placa1 == "")
              {
              }
              else
              {
                $pregunta1 .= " AND placa='$placa'";
              }
              $sql1 = odbc_exec($conexion,$pregunta1);
              $consumo1 = odbc_result($sql1,1);
              $consumo1 = floatval($consumo1);
              if ($empadrona == "M")
              {
                $preguntay = str_replace("cv_tra_mov", "cv_tra_moc", $pregunta1);
                $sqly = odbc_exec($conexion,$preguntay);
                $consumoy = odbc_result($sqly,1);
                $consumoy = floatval($consumoy);
                $consumo1 = $consumo1+$consumoy;
              }
              $valores5 .= $consumo1."|";
              $factura = odbc_result($sql1,2);
              $factura = floatval($factura);
              if ($empadrona == "M")
              {
                $facturay = odbc_result($sqly,2);
                $facturay = floatval($facturay);
                $factura = $factura+$facturay;
              }
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
                // Consulta kilometros recorridos mixto
                if ($empadrona == "M")
                {
                  $preguntaz = str_replace("cv_tra_mov", "cv_tra_moc", $pregunta2);
                  $sqlz = odbc_exec($conexion,$preguntaz);
                  $minimoz = odbc_result($sqlz,1);
                  $minimoz = floatval($minimoz);
                  $maximoz = odbc_result($sqlz,2);
                  $maximoz = floatval($maximoz);
                  $recorridosz = $maximoz-$minimoz;
                  $recorridosy = $maximoz-$maximo;
                  $recorridos = $recorridosz+$recorridosy;
                }
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
            $placa = trim(odbc_result($cur,1));
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
                $pregunta = "SELECT fecha, consumo, kilometraje, valor, solicitud, mision, tipo, soporte FROM ".$tabla." WHERE fecha='$fecha4' AND unidad='$uni_usuario' AND placa='$placa' AND $combustible2 AND $complemento1";
                if (($uni_usuario == "1") or ($tpc_usuario == "1"))
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
                    $valor = floatval($valor);
                    $bonos = 0;
                    $solicitud = odbc_result($sql,5);
                    $mision = trim(utf8_encode(odbc_result($sql,6)));
                    $partida = odbc_result($sql,7);
                    $soporte = odbc_result($sql,8);
                    $gasolina .= $placa."|".$costo."|".$consumo."|".$fecha."|".$kilometraje."|".$valor."|".$bonos."|".$solicitud."|".$mision."|".$partida."|".$soporte."|#";
                  }
                }
              }
              else
              {
                $pregunta = "SELECT fecha, consumo, kilometraje, valor, bonos, unidad, (SELECT numero FROM cx_con_pro WHERE conse=cv_tra_moc.contrato) AS contrato FROM ".$tabla." WHERE fecha='$fecha4' AND unidad='$uni_usuario' AND placa='$placa' AND $combustible2";
                if (($uni_usuario == "1") or ($tpc_usuario == "1"))
                {
                  $pregunta = str_replace("AND unidad='$uni_usuario' ", "", $pregunta);
                }
                if ($unidades == "")
                {
                  
                }
                else
                {
                  $pregunta .= " AND unidad IN ($unidades)";
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
                    $valor = floatval($valor);
                    $bonos = odbc_result($sql,5);
                    $unidad1 = odbc_result($sql,6);
                    $contrato = utf8_decode(odbc_result($sql,7));
                    $pregunta1 = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unidad1'";
                    $sql1 = odbc_exec($conexion,$pregunta1);
                    $sigla = trim(odbc_result($sql1,1));
                    $sigla1 = trim(odbc_result($sql1,2));
                    $fechas = trim(odbc_result($sql1,3));
                    if ($fechas == "")
                    {
                    }
                    else
                    {
                      $fechas = str_replace("/", "", $fechas);
                      if ($fecha >= $fechas)
                      {
                        $sigla = $sigla1;
                      }
                    }
                    $gasolina .= $placa."|".$costo."|".$consumo."|".$fecha."|".$kilometraje."|".$valor."|".$bonos."|".$sigla."|".$contrato."|#";
                  }
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
            $n_clase = trim(utf8_encode(odbc_result($cur,5)));
            $marca = trim(odbc_result($cur,6));
            $linea = trim(odbc_result($cur,7));
            $modelo = trim(odbc_result($cur,8));
            $activo = trim(odbc_result($cur,9))." ";
            $n_tipo = odbc_result($cur,10);
            $unidan = odbc_result($cur,11);
            $rtm = substr(odbc_result($cur,12),0,10);
            if ($rtm == "1900-01-01")
            {
              $rtm = "";
            }
            $sigla = trim(odbc_result($cur,13));
            $nombre = trim(utf8_encode(odbc_result($cur,14)));
            $descripcion = $n_clase." ".$marca." ".$linea." MODELO ".$modelo." ".$n_tipo;
            $descripcion = utf8_encode($descripcion);
            if ($i == "0")
            {
              $sigla1 = $sigla;
              $nombre1 = $nombre;
            }
            // Mantenimiento
            if ($tipo == "3")
            {
              if (($empadrona == "F") or ($empadrona == "G"))
              {
                $pregunta = "SELECT conse, unidad, consecu, ano, usuario, fecha, periodo FROM cx_rel_gas WHERE periodo BETWEEN '$periodo' AND '$periodo2' AND ano='$ano' AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.conse1=cx_rel_gas.conse AND cx_rel_dis.ano=cx_rel_gas.ano AND cx_rel_dis.consecu=cx_rel_gas.consecu AND cx_rel_dis.gasto IN ('38', '44') AND cx_rel_dis.datos LIKE '%$placa%') ORDER BY fecha DESC";
                $sql = odbc_exec($conexion, $pregunta);
                $total = odbc_num_rows($sql);
                $valores = "";
                $salida = new stdClass();
                if ($total>0)
                {
                  $j = 0;
                  while ($j < $row = odbc_fetch_array($sql))
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
                    $pregunta4 = "SELECT bienes FROM cx_pla_gad WHERE conse1='$consecu' AND ano='$ano' AND gasto IN ('38', '44')  AND bienes LIKE '%$placa%'";
                    $sql4 = odbc_exec($conexion, $pregunta4);
                    $row4 = odbc_fetch_array($sql4);
                    $bienes = trim(utf8_encode($row4["bienes"]));
                    $var_ocu = explode("#",$bienes);
                    $iva = $var_ocu[16];
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
                        //$dator = trim($num_datox[14]);
                        //$var_ocur = explode("-",$dator);
                        //$con_ocur = count($var_ocur);
                        //if ($con_ocu > 1)
                        //{
                        //  $datot = $var_ocur[0];
                        //}
                        //else
                        //{
                        //	$datot = $dator;
                        //}
                        if ($datoy == $placa)
                        {
                          $datoz .= $datox."|";
                        }                  
                      }
                      $gasto1 = odbc_result($sql1,3);
                      //if (($datow == "0") or ($datow == "0.0") or ($datow == ""))
                      //{
                      //}
                      //else
                      //{
                        $gasolina .= $placa."^".$clase."^".$datoz."^".$gasto1."^".$descripcion."^".$activo."^".$sigla."^".$nombre."^".$rtm."^".$iva."^#";
                      //}
                    }
                    $l++;
                  }
                  $j++;
                }
              }
              else
              {
                $pregunta = "SELECT valores, fecha FROM cx_tra_man WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND placa='$placa'";
                $sql = odbc_exec($conexion, $pregunta);
                $tot_man = odbc_num_rows($sql);
                if ($tot_man > 0)
                {
                  $j = 0;
                  while ($j < $row = odbc_fetch_array($sql))
                  {
                    $datos = trim(utf8_encode($row["valores"]));
                    $n_fecha = substr(odbc_result($sql,2),0,10);
                    $num_datos = explode("|",$datos);
                    $datos1 = "";
                    for ($k=0;$k<count($num_datos)-1;++$k)
                    {
                      $var_datos = $num_datos[$k];
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
                    $iva = "0";
                    $gasolina .= $placa."^".$clase."^".$datos1."^".$gasto1."^".$descripcion."^".$activo."^".$sigla."^".$nombre."^".$rtm."^".$iva."^#";
                    $j++;
                  }
                }
              }
              $salida->gasolina = $gasolina;
              $salida->ngasolina = $ngasolina;
            }
            // RTM
            if ($tipo == "4")
            {
              if (($empadrona == "F") or ($empadrona == "G"))
              {
                $pregunta = "SELECT conse, unidad, consecu, ano, usuario, fecha, periodo FROM cx_rel_gas WHERE periodo BETWEEN '$periodo' AND '$periodo2' AND ano='$ano' AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.conse1=cx_rel_gas.conse AND cx_rel_dis.ano=cx_rel_gas.ano AND cx_rel_dis.consecu=cx_rel_gas.consecu AND cx_rel_dis.gasto IN ('39', '45') AND cx_rel_dis.datos LIKE '%$placa%') ORDER BY fecha DESC";
                $sql = odbc_exec($conexion, $pregunta);
                $total = odbc_num_rows($sql);
                $valores = "";
                $salida = new stdClass();
                if ($total>0)
                {
                  $j = 0;
                  while ($j < $row = odbc_fetch_array($sql))
                  {
                    $conse = odbc_result($sql,1);
                    $unidad1 = odbc_result($sql,2);
                    $consecu = odbc_result($sql,3);
                    $ano = odbc_result($sql,4);
                    $usuario = odbc_result($sql,5);
                    $fecha = odbc_result($sql,6);
                    $fecha = substr($fecha,0,10);
                    $periodoi = odbc_result($sql,7);
                    $mes = str_pad($periodoi,2,"0",STR_PAD_LEFT);
                    $iva = "0";
                    $pregunta1 = "SELECT valor, datos, gasto FROM cx_rel_dis WHERE conse1='$conse' AND consecu='$consecu' AND ano='$ano' AND gasto IN ('39', '45') AND datos LIKE '%$placa%'";
                    $sql1 = odbc_exec($conexion, $pregunta1);
                    $l = 0;
                    while ($l < $row = odbc_fetch_array($sql1))
                    {
                      $valor = trim(odbc_result($sql1,1));
                      $datos = trim(utf8_encode($row['datos']));
                      $gasto1 = odbc_result($sql1,3);
                      $gasolina .= $placa."^".$clase."^".$datos."^".$gasto1."^".$descripcion."^".$activo."^".$sigla."^".$nombre."^".$rtm."^".$iva."^#";
                    }
                    $l++;
                  }
                  $j++;
                }
              }
              else
              {
                $pregunta = "SELECT valores, fecha FROM cx_tra_rtm WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND placa='$placa'";
                $sql = odbc_exec($conexion, $pregunta);
                $tot_rtm = odbc_num_rows($sql);
                $j = 0;
                while ($j < $row = odbc_fetch_array($sql))
                {
                  $datos = trim(utf8_encode($row["valores"]));
                  $n_fecha = substr(odbc_result($sql,2),0,10);
                  $num_datos = explode("|",$datos);
                  $datos1 = "";
                  for ($k=0;$k<count($num_datos)-1;++$k)
                  {
                    $var_datos = $num_datos[$k];
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
                  $iva = "0";
                  if ($tot_rtm == "0")
                  {
                  }
                  else
                  {
                  	$gasolina .= $placa."^".$clase."^".$datos1."^".$gasto1."^".$descripcion."^".$activo."^".$sigla."^".$nombre."^".$rtm."^".$iva."^#";
                  }
                  $j++;
                }
              }
              $salida->gasolina = $gasolina;
              $salida->ngasolina = $ngasolina;
            }
            // Llantas
            if ($tipo == "5")
            {
              if (($empadrona == "F") or ($empadrona == "G"))
              {
                $pregunta = "SELECT conse, unidad, consecu, ano, usuario, fecha, periodo FROM cx_rel_gas WHERE periodo BETWEEN '$periodo' AND '$periodo2' AND ano='$ano' AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.conse1=cx_rel_gas.conse AND cx_rel_dis.ano=cx_rel_gas.ano AND cx_rel_dis.consecu=cx_rel_gas.consecu AND cx_rel_dis.gasto IN ('40', '46') AND cx_rel_dis.datos LIKE '%$placa%') ORDER BY fecha DESC";
                $sql = odbc_exec($conexion, $pregunta);
                $total = odbc_num_rows($sql);
                $valores = "";
                $salida = new stdClass();
                if ($total>0)
                {
                  $j = 0;
                  while ($j < $row = odbc_fetch_array($sql))
                  {
                    $conse = odbc_result($sql,1);
                    $unidad1 = odbc_result($sql,2);
                    $consecu = odbc_result($sql,3);
                    $ano = odbc_result($sql,4);
                    $usuario = odbc_result($sql,5);
                    $fecha = odbc_result($sql,6);
                    $fecha = substr($fecha,0,10);
                    $periodoi = odbc_result($sql,7);
                    $mes = str_pad($periodoi,2,"0",STR_PAD_LEFT);
                    $iva = "0";
                    $pregunta1 = "SELECT valor, datos, gasto FROM cx_rel_dis WHERE conse1='$conse' AND consecu='$consecu' AND ano='$ano' AND gasto IN ('40', '46') AND datos LIKE '%$placa%'";
                    $sql1 = odbc_exec($conexion, $pregunta1);
                    $l = 0;
                    while ($l < $row = odbc_fetch_array($sql1))
                    {
                      $valor = trim(odbc_result($sql1,1));
                      $datos = trim(utf8_encode($row['datos']));
                      $gasto1 = odbc_result($sql1,3);
                      $gasolina .= $placa."^".$clase."^".$datos."^".$gasto1."^".$descripcion."^".$activo."^".$sigla."^".$nombre."^".$rtm."^".$iva."^#";
                    }
                    $l++;
                  }
                  $j++;
                }
              }
              else
              {
                $pregunta = "SELECT valores, fecha FROM cx_tra_lla WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND placa='$placa'";
                $sql = odbc_exec($conexion, $pregunta);
                $tot_lla = odbc_num_rows($sql);
                $j = 0;
                while ($j < $row = odbc_fetch_array($sql))
                {
                  $datos = trim(utf8_encode($row["valores"]));
                  $n_fecha = substr(odbc_result($sql,2),0,10);
                  $num_datos = explode("|",$datos);
                  $datos1 = "";
                  for ($k=0;$k<count($num_datos)-1;++$k)
                  {
                    $var_datos = $num_datos[$k];
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
                  $iva = "0";
                  if ($tot_lla == "0")
                  {
                  }
                  else
                  {
                  	$gasolina .= $placa."^".$clase."^".$datos1."^".$gasto1."^".$descripcion."^".$activo."^".$sigla."^".$nombre."^".$rtm."^".$iva."^#";
                  }
                  $j++;
                }
              }
              $salida->gasolina = $gasolina;
              $salida->ngasolina = $ngasolina;
            }
            $i++;
          }
        }
        $salida->sigla = $sigla1;
        $salida->nombre = $nombre1;
      }
    }
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
// 11/02/2024 - Inclusion nuevos campos reporte excel
// 03/05/2024 - Inclusion ajuste registro varios consumo mismo dia
// 05/09/2024 - Ajuste placas manuales
// 06/06/2024 - Ajuste consulta por unidad y placa independiente
// 07/06/2024 - Ajuste envio datos excel
// 12/06/2024 - Ajuste anexot para administrador con filtro de unidad
// 20/06/2024 - Ajuste placas sin movimiento en excel
// 23/07/2024 - Ajuste inclusion de unidades que dependen de centralizadora
// 24/07/2024 - Ajuste nombre y sigla de unidad de placas a exportar a excel
// 14/08/2024 - Ajuste anexot inclusion empadronamiento mixto
// 03/09/2024 - Ajuste calculo total por dia para CEDE2
// 11/09/2024 - Ajuste anexot inclusion movimientos contratos
// 14/09/2024 - Ajuste anexot kilometros recorridos totales mixto
// 24/08/2024 - Ajuste descreicion vehiculos
// 31/10/2024 - Ajuste consulta empadronamiento administrador
// 20/12/2024 - Ajuste clase de vehiculo mantenimiento
// 07/01/2025 - Ajuste inclusion unidad en excel contratos
// 16/01/2025 - Ajuste filtro unidad en consulta contratos
// 03/02/2025 - Ajuste inclusion campo contrato excel
// 05/02/2025 - Ajuste consulta combustible contratos por cambio de empadronamiento
// 18/02/2025 - Ajuste nuevo reporte - gestion presupuesto
// 27/02/2025 - Ajuste consulta nuevo reporte x empadronamiento
?>