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
  $mision = trim($_POST['valor2']);
  $num_valores = explode("-", $mision);
  $num_valores1 = count($num_valores);
  if ($num_valores1 == "3")
  {
    list($var3, $var4, $var5) = explode("-", $mision);
    $var3 = trim($var3);
  }
  else
  {
    list($var6, $var3, $var4, $var5) = explode("-", $mision);
    $var3 = trim($var6)."-".trim($var3);
  }
  $var4 = trim($var4);
  $var5 = trim($var5);
  $n_ordop = trim($_POST['valor3']);
  list($var1, $var2) = explode(" ", $n_ordop);
  $var1 = trim($var1);
  $centra = $_POST['valor4'];
  // Se consulta el tipo, si es plan o solicitud
  $consulta = "SELECT tipo, periodo FROM cx_pla_inv WHERE conse='$conse' AND unidad='$uni_usuario' AND ano='$ano'";
  $sql0 = odbc_exec($conexion,$consulta);
  $tipo = odbc_result($sql0,1);
  $periodo = odbc_result($sql0,2);
  // Se consulta los datos de la mision
  $query = "SELECT conse1, interno, valor_a, fechai, fechaf FROM cx_pla_gas WHERE mision='$var3' AND conse1='$conse' AND interno='$var5' AND unidad='$uni_usuario' AND ano='$ano'";

    $fec_log = date("d/m/Y H:i:s a");
    $file = fopen("log_jm2021.txt", "a");
    fwrite($file, $fec_log." # ".$query." AN # ".PHP_EOL);
    fclose($file);

  $sql = odbc_exec($conexion,$query);
  $contador = odbc_num_rows($sql);
  if ($contador == "0")
  {
    $query = "SELECT conse1, interno, valor_a, fechai, fechaf FROM cx_pla_gas WHERE conse1='$conse' AND interno='$var5' AND unidad='$uni_usuario' AND ano='$ano'";
    $sql = odbc_exec($conexion,$query);
  }
  $conse1 = odbc_result($sql,1);
  $interno = odbc_result($sql,2);
  $tot_mis = trim(odbc_result($sql,3));
  $lapso = trim(odbc_result($sql,4))." - ".trim(odbc_result($sql,5));
  $lapso1 = odbc_result($sql,4);
  $lapso1 = substr($lapso1,5,2); 
  $lapso1 = intval($lapso1);
  // Se consulta en la tabla de discriminado de gastos
  $salida1 = new stdClass();
  // Se traen todos los gastos de planillas gastos basicos
  $pregunta1 = "SELECT * FROM cx_pla_gad WHERE conse1='$conse1' AND interno='$interno' AND unidad='$uni_usuario' AND ano='$ano' AND gasto='1'";
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
  // Se traen todos los gastos exepto planillas gastos basicos
  $pregunta1 = "SELECT * FROM cx_pla_gad WHERE conse1='$conse1' AND interno='$interno' AND unidad='$uni_usuario' AND ano='$ano' AND gasto!='1'";
  $sql1 = odbc_exec($conexion, $pregunta1);
  $total1 = odbc_num_rows($sql1);
  $j = 1;
  $bie = "";
  $nom = "";
  while($j<$row=odbc_fetch_array($sql1))
  {
    $v_gasto = trim(odbc_result($sql1,5));
    $v_valor = trim(odbc_result($sql1,7));
    // Se consulta si el tipo es de bienes
    $pregunta7 = "SELECT tipo FROM cx_ctr_pag WHERE codigo='$v_gasto'";
    $sql7 = odbc_exec($conexion, $pregunta7);
    $v_tipo = trim(odbc_result($sql7,1));
    if ($v_tipo == "B")
    {
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
          $bie .= $a[$k]."&";
          $preg = "SELECT nombre FROM cx_ctr_bie WHERE codigo='$a[$k]'";
          $cur = odbc_exec($conexion, $preg);
          $des = trim(odbc_result($cur,1));
          if ($des == "")
          {
            $des = "NO IDENTIFICADO";
          }
          $nom .= $des."&";
        }
        $v_bien = trim($bie)."#".trim($nom)."#".trim($num_bienes5)."#".trim($num_bienes6)."#".trim($num_bienes7);
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
      $v_bien = "";
    }
    $v_paso .= $v_gasto."|".$v_valor."|".$v_bien."«";
    $j++;
  }
  // Si es plan de inversion se consulta el valor de la mision aprobado
  if ($tipo == "1")
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
    $pregunta5 = "SELECT egreso FROM cx_com_egr WHERE periodo='$periodo' AND ano='$ano' AND num_auto='$conse' AND estado=''";
    $sql5 = odbc_exec($conexion,$pregunta5);
    $com_egr = odbc_result($sql5,1);
    if ($com_egr == false)
    {
      $com_egr = "0";
    }
  }
  // Se consulta el valor total de las planillas de gastos
  if ($var1 == "«")
  {
    $var1 = "";
  }
  $var1 = str_replace("«", "", $var1);
  // Ajuste consulta de Ñ
  $ordop = utf8_decode($ordop);
  $var3 = utf8_decode($var3);
  $periodo1 = intval($periodo)-1;
  $pregunta3 = "SELECT total, responsable FROM cx_gas_bas WHERE ordop='$ordop' AND n_ordop='$var1' AND mision='$var3' AND numero='$var5' AND unidad='$uni_usuario' AND periodo IN ('$periodo','$periodo1') AND ano='$ano' AND usuario='$usu_usuario' AND solicitud='$var4'";
  $sql3 = odbc_exec($conexion,$pregunta3);
  $contador1 = odbc_num_rows($sql3);
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
  $salida->salida = $v_paso;
  $salida->valor = $tot_mis;
  $salida->total = $tot_gas;
  $salida->egreso = $com_egr;
  $salida->responsable = $v_resp;
  $salida->lapso = $lapso;
  $salida->lapso1 = $lapso1;
  echo json_encode($salida);
}
?>