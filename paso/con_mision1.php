<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
// Si no es peticion ajax no se ejecuta
if (is_ajax())
{
  $ano = $_POST['ano'];
  $ordop = trim($_POST['valor']);
  $conse = trim($_POST['valor1']);
  $num_conses = explode("|", $conse);
  $num_conses1 = count($num_conses);
  $conse = str_replace("|", ",", $conse);
  $conse = substr($conse,0,-1);
  $consecus = explode(",", $conse);
  $mision = trim($_POST['valor2']);
  $num_misiones = explode("|", $mision);
  $num_misiones1 = count($num_misiones);
  $num_misiones2 = $num_misiones1-1;
  for ($i=0; $i<$num_misiones1-1; ++$i)
  {
    $paso = $num_misiones[$i];
    $num_valores = explode("¬", $paso);
    $num_valores1 = count($num_valores);
    if ($num_valores1 == "3")
    {
      $var3 .= "'".trim($num_valores[0])."',";
      $var4 .= trim($num_valores[1]).",";
      $var5 .= trim($num_valores[2]).",";
      $var6 .= "mision LIKE '".trim($num_valores[0])."' OR ";
    }
    else
    {
      $var3 .= "'".trim($num_valores[0])."-".trim($num_valores[1])."',";
      $var4 .= trim($num_valores[2]).",";
      $var5 .= trim($num_valores[3]).",";
      $var6 .= "mision LIKE '".trim($num_valores[0])."-".trim($num_valores[1])."' OR ";
    }
  }
  $var3 = substr($var3,0,-1);
  $var4 = substr($var4,0,-1);
  $var5 = substr($var5,0,-1);
  $var6 = "(".substr($var6,0,-4).")";
  $var7 = str_replace("LIKE '", "LIKE '%", $var6);
  $n_ordop = trim($_POST['valor3']);
  list($var1, $var2) = explode(" ", $n_ordop);
  $var1 = trim($var1);
  if ($var1 == "«")
  {
    $var1 = "";
  }
  $var1 = str_replace("«", "", $var1);
  $centra = $_POST['valor4'];
  // Se consulta el tipo, si es plan o solicitud
  $consulta = "SELECT tipo, periodo FROM cx_pla_inv WHERE conse IN ($conse) AND unidad='$uni_usuario' AND ano='$ano'";
  $sql0 = odbc_exec($conexion,$consulta);
  while($i<$row=odbc_fetch_array($sql0))
  {
    $tipo .= odbc_result($sql0,1).",";
    $i++;
  }
  $tipo = substr($tipo,0,-1);
  $periodo = odbc_result($sql0,2);
  // Se consulta los datos de la mision
  if ($num_misiones1 == "2")
  {
    $pre_mis = "mision LIKE (".$var3.")";
  }
  else
  {
    $pre_mis .= $var6;
  }
  $pre_mis = utf8_decode($pre_mis);
  $query = "SELECT conse1, interno, valor_a, fechai, fechaf FROM cx_pla_gas WHERE ".$pre_mis." AND conse1 IN ($conse) AND interno IN ($var5) AND unidad='$uni_usuario' AND ano='$ano'";
  $sql = odbc_exec($conexion,$query);
  $contador = odbc_num_rows($sql);
  if ($contador == "0")
  {
    $query = "SELECT conse1, interno, valor_a, fechai, fechaf FROM cx_pla_gas WHERE conse1='$conse' AND interno='$var5' AND unidad='$uni_usuario' AND ano='$ano'";
    $sql = odbc_exec($conexion,$query);
  }
  $i = 0;
  while($i<$row=odbc_fetch_array($sql))
  {
    if ($i == "0")
    {
      $lapso_ini = trim(odbc_result($sql,4));
    }
    $conse1 .= odbc_result($sql,1).",";
    $interno .= odbc_result($sql,2).",";
    $v_valor = trim(odbc_result($sql,3));
    $v_valor1 = str_replace(',','',$v_valor);
    $v_valor1 = trim($v_valor1);
    $v_valor1 = floatval($v_valor1);
    $v_total = $v_total+$v_valor1;
    $lapso = " - ".trim(odbc_result($sql,5));
    $lapso1 = odbc_result($sql,4);
    $lapso1 = substr($lapso1,5,2); 
    $lapso1 = intval($lapso1);
    $lapso2 = trim(odbc_result($sql,5));
    $i++;
  }
  $lapso = $lapso_ini.$lapso;
  $total = $v_total;
  $total = number_format($total, 2);
  $tot_mis = $total;
  $conse1 = substr($conse1,0,-1);
  $interno = substr($interno,0,-1);
  // Se traen todos los gastos de planillas gastos basicos
  $pregunta1 = "SELECT * FROM cx_pla_gad WHERE conse1 IN ($conse1) AND interno IN ($interno) AND unidad='$uni_usuario' AND ano='$ano' AND gasto='1' ORDER BY conse";
  $sql1 = odbc_exec($conexion,$pregunta1);
  $total1 = odbc_num_rows($sql1);
  $v_paso = "";
  if ($total1 > 0)
  {
    $j = 1;
    $v_gasto = "1";
    $v_total = 0;
    while($j<$row=odbc_fetch_array($sql1))
    {
      $v_valor = trim(odbc_result($sql1,7));
      $v_valor1 = str_replace(',','',$v_valor);
      $v_valor1 = substr($v_valor1,0,-3);
      $v_valor1 = intval($v_valor1);
      $v_total = $v_total+$v_valor1;
      $j++;
    }
    $v_paso .= $v_gasto."|".$v_total."|«";
  }
  // Se traen todos los gastos excepto planillas gastos basicos
  $pregunta1 = "SELECT * FROM cx_pla_gad WHERE conse1 IN ($conse1) AND interno IN ($interno) AND unidad='$uni_usuario' AND ano='$ano' AND gasto!='1' ORDER BY conse";
  $sql1 = odbc_exec($conexion, $pregunta1);
  $total1 = odbc_num_rows($sql1);
  $contador1 = 0;
  $contador2 = 0;
  $j = 1;
  $bie = "";
  $nom = "";
  while($j<$row=odbc_fetch_array($sql1))
  {
    $v_conse = trim(odbc_result($sql1,2));
    $v_interno = trim(odbc_result($sql1,3));
    // Se consulta mision especifica
    $pregunta8 = "SELECT mision FROM cx_pla_gas WHERE conse1='$v_conse' AND interno='$v_interno' AND ano='$ano'";
    $sql8 = odbc_exec($conexion, $pregunta8);
    $v_mision = trim(utf8_encode(odbc_result($sql8,1)));
    $v_gasto = trim(odbc_result($sql1,5));
    $v_valor = trim(odbc_result($sql1,7));
    // Se consulta si el tipo es de bienes
    $pregunta7 = "SELECT tipo FROM cx_ctr_pag WHERE codigo='$v_gasto'";
    $sql7 = odbc_exec($conexion, $pregunta7);
    $v_tipo = trim(odbc_result($sql7,1));
    if ($v_tipo == "B")
    {
      $contador1 ++;
      $v_bienes = trim($row['bienes']);
      $num_bienes = explode("#", $v_bienes);
      $num_bienes1 = count($num_bienes);
      if ($num_bienes1 > 0)
      {
        $num_bienes2 = $num_bienes[0];
        $num_bienes3 = explode("&", $num_bienes2);
        $num_bienes4 = count($num_bienes3)-1;
        $num_bienes5 = $num_bienes[2];
        $num_bienes6 = $num_bienes[3];
        $num_bienes7 = $num_bienes[4];
        for ($k=0; $k<$num_bienes4; ++$k)
        {
          $a[$k] = trim($num_bienes3[$k]);
          if ($contador1 == "1")
          {
            $bie .= $a[$k]."&";
          }
          else
          {
            $bie = $a[$k]."&";
          }
          $preg = "SELECT nombre FROM cx_ctr_bie WHERE codigo='$a[$k]'";
          $cur = odbc_exec($conexion, $preg);
          $des = trim(odbc_result($cur,1));
          if ($des == "")
          {
            $des = "NO IDENTIFICADO";
          }
          if ($contador1 == "1")
          {
            $nom .= $des."&";
          }
          else
          {
            $nom = $des."&";
          }
        }
        $v_bien = trim($bie)."#".trim($nom)."#".trim($num_bienes5)."#".trim($num_bienes6)."#".trim($num_bienes7)."#".trim($v_conse)."#".trim($v_mision);
        $v_bien = utf8_encode($v_bien);
        if ($v_bien == "####")
        {
          $v_bien = "";
        }
      }
      else
      {
        $v_bien = "";
      }
    }
    else
    {
      switch ($v_tipo)
      {
        case 'C':
        case 'G':
        case 'M':
        case 'T':
        case 'L':
          $contador2 ++;
          $v_bienes = trim($row['bienes']);
          $v_bien = $v_bienes;         
          $v_bien = utf8_encode($v_bien);
          break;       
        default:
          $v_bien = "";
          break;
      }
    }
    $v_paso .= $v_gasto."|".$v_valor."|".$v_bien."«";
    $j++;
  }
  // Si es plan de inversion se consulta el valor de la mision aprobado
  $num_tipos = explode(",", $tipo);
  $num_tipos1 = count($num_tipos);
  if ($num_tipos1 == "1")
  {
    $paso_tipo = $num_tipos[0];
    if ($paso_tipo == "1")
    {
      // Se consulta el informe de autorizacion
      $pregunta7 = "SELECT informe FROM cx_pla_gas WHERE unidad='$uni_usuario' AND conse1='$var4' AND interno='$var5' AND ano='$ano'";
      $sql7 = odbc_exec($conexion,$pregunta7);
      $num_inf7 = odbc_result($sql7,1);
      // Se consulta el informe de autorizacion de la unidad centralizadora
      $pregunta2 = "SELECT conse, unidad, egreso FROM cx_inf_aut WHERE unidad1='$uni_usuario' AND periodo='$periodo' AND ano='$ano' AND conse='$num_inf7'";
      $sql2 = odbc_exec($conexion,$pregunta2);
      $aut_num = odbc_result($sql2,1);
      $aut_uni = odbc_result($sql2,2);
      $com_egr = odbc_result($sql2,3);
      if ($com_egr == false)
      {
        $com_egr = "0";
      }
    }
    else
    {
      $pregunta5 = "SELECT egreso FROM cx_com_egr WHERE periodo='$periodo' AND ano='$ano' AND num_auto LIKE ('%$conse%') AND estado=''";
      $sql5 = odbc_exec($conexion,$pregunta5);
      $com_egr = odbc_result($sql5,1);
      if ($com_egr == false)
      {
        $com_egr = "0";
      }
    }
    $com_egr1 = $com_egr;
  }
  else
  {
    for ($k=0; $k<$num_bienes4; ++$k)
    {
      $paso_tipo = $num_tipos[$k];
      if ($paso_tipo == "1")
      {
        // Se consulta el informe de autorizacion
        $pregunta7 = "SELECT informe FROM cx_pla_gas WHERE unidad='$uni_usuario' AND conse1='$var4' AND interno='$var5' AND ano='$ano'";
        $sql7 = odbc_exec($conexion,$pregunta7);
        $num_inf7 = odbc_result($sql7,1);
        // Se consulta el informe de autorizacion de la unidad centralizadora
        $pregunta2 = "SELECT conse, unidad, egreso FROM cx_inf_aut WHERE unidad1='$uni_usuario' AND periodo='$periodo' AND ano='$ano' AND conse='$num_inf7'";
        $sql2 = odbc_exec($conexion,$pregunta2);
        $aut_num = odbc_result($sql2,1);
        $aut_uni = odbc_result($sql2,2);
        $com_egr = odbc_result($sql2,3);
        if ($com_egr == false)
        {
          $com_egr = "0";
        }
      }
      else
      {
        $v_consecu = $consecus[$k];
        $pregunta5 = "SELECT egreso FROM cx_com_egr WHERE periodo='$periodo' AND ano='$ano' AND num_auto LIKE ('$v_consecu') AND estado=''";
        $sql5 = odbc_exec($conexion,$pregunta5);
        $com_egr = odbc_result($sql5,1);
        $com_egr1 .= $com_egr.",";
        if ($com_egr == false)
        {
          $com_egr = "0";
        }
      }
    }
    if ($com_egr == "")
    {
      $com_egr1 = "";
      $num_egresos = explode(",", $conse);
      $num_egresos1 = count($num_egresos);
      for ($i=0; $i<$num_egresos1; ++$i)
      {
        $egr = $num_egresos[$i];
        $pregunta5 = "SELECT egreso FROM cx_com_egr WHERE periodo='$periodo' AND ano='$ano' AND num_auto LIKE ('%$egr%') AND estado=''";
        $sql5 = odbc_exec($conexion,$pregunta5);
        $tot5 = odbc_num_rows($sql5);
        if ($tot5 == "0")
        {
          $pregunta7 = "SELECT informe FROM cx_pla_gas WHERE unidad='$uni_usuario' AND conse1='$egr' AND ano='$ano'";
          $sql7 = odbc_exec($conexion,$pregunta7);
          $num_inf7 = odbc_result($sql7,1);
          $pregunta5 = "SELECT egreso FROM cx_com_egr WHERE periodo='$periodo' AND ano='$ano' AND num_auto LIKE ('%$num_inf7%') AND estado=''";
          $sql5 = odbc_exec($conexion,$pregunta5);
        }
        $com_egr = odbc_result($sql5,1);
        $com_egr1 .= $com_egr.",";
      }
      $com_egr1 = substr($com_egr1,0,-1);
    }
    else
    {
      $com_egr1 = substr($com_egr1,0,-1);
    }
  }
  // Se consulta el valor total de las planillas de gastos
  // Ajuste consulta de Ñ
  $ordop = utf8_decode($ordop);
  $var3 = utf8_decode($var3);
  $periodo1 = intval($periodo)-1;
  $pregunta3 = "SELECT total, responsable FROM cx_gas_bas WHERE ordop='$ordop' AND n_ordop='$var1' AND ".$pre_mis." AND numero IN ($var5) AND unidad='$uni_usuario' AND periodo IN ('$periodo','$periodo1') AND ano='$ano' AND usuario='$usu_usuario' AND solicitud IN ($var4)";
  $sql3 = odbc_exec($conexion,$pregunta3);
  $contador3 = odbc_num_rows($sql3);
  $tot_gas = 0;
  while($i<$row=odbc_fetch_array($sql3))
  {
    $v_gas = trim(odbc_result($sql3,1));
    $v_gas1 = str_replace(',','',$v_gas);
    $v_gas1 = substr($v_gas1,0,-3);
    $v_gas1 = intval($v_gas1);
    $tot_gas = $tot_gas+$v_gas1;
    $v_resp = trim(utf8_encode(odbc_result($sql3,2)));
  }
  // Se consulta consumo registrado
  $mes = str_pad($periodo,2,"0",STR_PAD_LEFT);
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
  // Kilometraje - partida mensual
  // Con soporte
  $pregunta4 = "SELECT total, soporte FROM cv_tra_mov WHERE usuario='$usu_usuario' AND unidad='$uni_usuario' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND CONVERT(datetime,'$lapso2',102) AND tipo='1' AND solicitud IN ($conse) AND ano='$ano' AND $var7 AND soporte='1'";
  $sql4 = odbc_exec($conexion,$pregunta4);
  $tot_com1 = 0;
  while($i<$row=odbc_fetch_array($sql4))
  {
    $v_total = odbc_result($sql4,1);
    $v_total = floatval($v_total);
    $tot_com1 = $tot_com1+$v_total;
  }
  // Sin soporte
  $pregunta6 = "SELECT total, soporte FROM cv_tra_mov WHERE usuario='$usu_usuario' AND unidad='$uni_usuario' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND CONVERT(datetime,'$lapso2',102) AND tipo='1' AND solicitud IN ($conse) AND ano='$ano' AND $var7 AND soporte='0'";
  $sql6 = odbc_exec($conexion,$pregunta6);
  $tot_com3 = 0;
  while($i<$row=odbc_fetch_array($sql6))
  {
    $v_total = odbc_result($sql6,1);
    $v_total = floatval($v_total);
    $tot_com3 = $tot_com3+$v_total;
  }
  // Kilometraje - adicional
  // Con soporte
  $pregunta5 = "SELECT total, soporte FROM cv_tra_mov WHERE usuario='$usu_usuario' AND unidad='$uni_usuario' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND CONVERT(datetime,'$lapso2',102) AND tipo='2' AND solicitud IN ($conse) AND ano='$ano' AND $var7 AND soporte='1'";
  $sql5 = odbc_exec($conexion,$pregunta5);
  $tot_com2 = 0;
  while($i<$row=odbc_fetch_array($sql5))
  {
    $v_total = odbc_result($sql5,1);
    $v_total = floatval($v_total);
    $tot_com2 = $tot_com2+$v_total;
  }
  // Sin soporte
  $pregunta9 = "SELECT total, soporte FROM cv_tra_mov WHERE usuario='$usu_usuario' AND unidad='$uni_usuario' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND CONVERT(datetime,'$lapso2',102) AND tipo='2' AND solicitud IN ($conse) AND ano='$ano' AND $var7 AND soporte='0'";
  $sql9 = odbc_exec($conexion,$pregunta9);
  $tot_com4 = 0;
  while($i<$row=odbc_fetch_array($sql9))
  {
    $v_total = odbc_result($sql9,1);
    $v_total = floatval($v_total);
    $tot_com4 = $tot_com4+$v_total;
  }
  $salida = new stdClass();
  $salida->salida = $v_paso;
  $salida->valor = $tot_mis;
  $salida->total = $tot_gas;
  $salida->combustible1 = $tot_com1;
  $salida->combustible2 = $tot_com2;
  $salida->combustible3 = $tot_com3;
  $salida->combustible4 = $tot_com4;
  $salida->egreso = $com_egr;
  $salida->egresos = $com_egr1;
  $salida->responsable = $v_resp;
  $salida->lapso = $lapso;
  $salida->lapso1 = $lapso1;
  echo json_encode($salida);
}
?>