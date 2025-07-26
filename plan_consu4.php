<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $carpeta1 = $ruta_local."\\tmp";
  $v_ano = date('Y');
  $v_ano = trim($v_ano);
  $v_mes = date('m');
  $v_mes = trim($v_mes);
  $v_dia = date('d');
  $v_dia = trim($v_dia);
  $carpeta1 .= "\\".$v_ano.$v_mes.$v_dia;
  if(!file_exists($carpeta1))
  {
    mkdir ($carpeta1);
  }
  $plan = $_POST['plan'];
  $ano = $_POST['ano'];
  unlink($carpeta1."\\"."log_plan".$plan."_".$ano.".txt");
  $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$plan' AND ano='$ano'";
  $sql = odbc_exec($conexion,$pregunta);
  $row = odbc_fetch_array($sql);
  $conse = odbc_result($sql,1);
  $fecha = odbc_result($sql,2);
  $usuario = trim(odbc_result($sql,3));
  $unidad = odbc_result($sql,4);
  $estado = trim(odbc_result($sql,5));
  $lugar = trim(odbc_result($sql,6));
  $factor = trim(odbc_result($sql,7));
  $estructura = trim(odbc_result($sql,8));
  $periodo = odbc_result($sql,9);
  $oficiales = odbc_result($sql,10);
  $suboficiales = odbc_result($sql,11);
  $auxiliares = odbc_result($sql,12);
  $soldados = odbc_result($sql,13);
  $ordop = trim(odbc_result($sql,14));
  $n_ordop = trim(odbc_result($sql,15));
  $misiones = trim($row["misiones"]);
  $n_misiones = odbc_result($sql,17);
  $gastos = trim($row["gastos"]);
  $pagos = trim($row["pagos"]);
  $tipo = odbc_result($sql,20);
  $actual = odbc_result($sql,21);
  $ano = odbc_result($sql,22);
  $oms = trim(odbc_result($sql,23));
  $compania = odbc_result($sql,24);
  $aprueba = odbc_result($sql,25);
  $revisa = odbc_result($sql,26);
  $tipo1 = odbc_result($sql,27);
  $usuario1 = trim(odbc_result($sql,28));
  $usuario2 = trim(odbc_result($sql,29));
  $usuario3 = trim(odbc_result($sql,30));
  $usuario4 = trim(odbc_result($sql,31));
  $usuario5 = trim(odbc_result($sql,32));
  $usuario6 = trim(odbc_result($sql,33));
  $autoriza = odbc_result($sql,34);
  $uni_anu = odbc_result($sql,35);
  $fec_anu = odbc_result($sql,36);
  $usuario7 = trim(odbc_result($sql,37));
  $usuario8 = trim(odbc_result($sql,38));
  $usuario9 = trim(odbc_result($sql,39));
  $usuario10 = trim(odbc_result($sql,40));
  $usuario11 = trim(odbc_result($sql,41));
  $usuario12 = trim(odbc_result($sql,42));
  $usuario13 = trim(odbc_result($sql,43));
  $recursos = odbc_result($sql,44);
  $firma1 = trim(utf8_encode($row["firma1"]));
  $firma2 = trim(utf8_encode($row["firma2"]));
  $firma3 = trim(utf8_encode($row["firma3"]));
  $firma4 = trim(utf8_encode($row["firma4"]));
  $firma5 = trim(utf8_encode($row["firma5"]));
  $firma6 = trim(utf8_encode($row["firma6"]));
  $firma7 = trim(utf8_encode($row["firma7"]));
  $especial = odbc_result($sql,52);
  $usuario14 = trim(odbc_result($sql,53));
  $usuario15 = trim(odbc_result($sql,54));
  $usuario16 = trim(odbc_result($sql,55));
  $nivel = odbc_result($sql,56);
  $query = "INSERT INTO cx_pla_inv (conse, fecha, usuario, unidad, estado, lugar, factor, estructura, periodo, oficiales, suboficiales, auxiliares, soldados, ordop, n_ordop, misiones, n_misiones, gastos, pagos, tipo, actual, ano, oms, compania, aprueba, revisa, tipo1, usuario1, usuario2, usuario3, usuario4, usuario5, usuario6, autoriza, uni_anu, fec_anu, usuario7, usuario8, usuario9, usuario10, usuario11, usuario12, usuario13, recursos, firma1, firma2, firma3, firma4, firma5, firma6, firma7, especial, usuario14, usuario15, usuario16, nivel) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$estado', '$lugar', '$factor', '$estructura', '$periodo', '$oficiales', '$suboficiales', '$auxiliares', '$soldados', '$ordop', '$n_ordop', '$misiones', '$n_misiones', '$gastos', '$pagos', '$tipo', '$actual', '$ano', '$oms', '$compania', '$aprueba', '$revisa', '$tipo1', '$usuario1', '$usuario2', '$usuario3', '$usuario4', '$usuario5', '$usuario6', '$autoriza', '$uni_anu', '$fec_anu', '$usuario7', '$usuario8', '$usuario9', '$usuario10', '$usuario11', '$usuario12', '$usuario13', '$recursos', '$firma1', '$firma2', '$firma3', '$firma4', '$firma5', '$firma6', '$firma7', '$especial','$usuario14', '$usuario15', '$usuario16', '$nivel')";
  $file = fopen($carpeta1."\\"."log_plan".$plan."_".$ano.".txt", "a");
  fwrite($file, $query.PHP_EOL);
  fclose($file);

  $pregunta1 = "SELECT * FROM cx_pla_gas WHERE conse1='$plan' AND unidad='$unidad' AND ano='$ano'";
  $sql1 = odbc_exec($conexion,$pregunta1);
  $i=1;
  while($i<$row=odbc_fetch_array($sql1))
  {
    $conse = odbc_result($sql1,1);
    $conse1 = odbc_result($sql1,2);
    $interno = odbc_result($sql1,3);
    $unidad = odbc_result($sql1,4);
    $mision = trim(odbc_result($sql1,5));
    $area = trim(odbc_result($sql1,6));
    $fechai = trim(odbc_result($sql1,7));
    $fechaf = trim(odbc_result($sql1,8));
    $oficiales = odbc_result($sql1,9);
    $suboficiales = odbc_result($sql1,10);
    $auxiliares = odbc_result($sql1,11);
    $soldados = odbc_result($sql1,12);
    $valor = trim(odbc_result($sql1,13));
    $valor_a = trim(odbc_result($sql1,14));
    $actividades = odbc_result($sql1,15);
    $factor = trim(odbc_result($sql1,16));
    $estructura = trim(odbc_result($sql1,17));
    $ano = odbc_result($sql1,18);
    $valor_c = trim(odbc_result($sql1,19));
    $autoriza = odbc_result($sql1,20);
    $informe = odbc_result($sql1,21);
    $query = "INSERT INTO cx_pla_gas (conse, conse1, interno, unidad, mision, area, fechai, fechaf, oficiales, suboficiales, auxiliares, soldados, valor, valor_a, actividades, factor, estructura, ano, valor_c, autoriza, informe) VALUES ('$conse', '$conse1', '$interno', '$unidad', '$mision', '$area', '$fechai', '$fechaf', '$oficiales', '$suboficiales', '$auxiliares', '$soldados', '$valor', '$valor_a', '$actividades', '$factor', '$estructura', '$ano', '$valor_c', '$autoriza', '$informe')";
    $file = fopen($carpeta1."\\"."log_plan".$plan."_".$ano.".txt", "a");
    fwrite($file, $query.PHP_EOL);
    fclose($file);

    $pregunta2 = "SELECT * FROM cx_pla_gad WHERE conse1='$plan' AND interno='$interno' AND unidad='$unidad' AND ano='$ano'";
    $sql2 = odbc_exec($conexion,$pregunta2);
    $total1 = odbc_num_rows($sql2);
    $j=1;
    while($j<$row=odbc_fetch_array($sql2))
    {
      $conse2 = odbc_result($sql2,1);
      $conse3 = odbc_result($sql2,2);
      $interno1 = odbc_result($sql2,3);
      $unidad1 = odbc_result($sql2,4);
      $gasto = trim(odbc_result($sql2,5));
      $otro = trim(odbc_result($sql2,6));
      $valor1 = trim(odbc_result($sql2,7));
      $ano1 = odbc_result($sql2,8);
      $bienes = trim($row["bienes"]);
      $query = "INSERT INTO cx_pla_gad (conse, conse1, interno, unidad, gasto, otro, valor, ano, bienes) VALUES ('$conse2', '$conse3', '$interno1', '$unidad1', '$gasto', '$otro', '$valor1', '$ano1', '$bienes')";
      $file = fopen($carpeta1."\\"."log_plan".$plan."_".$ano.".txt", "a");
      fwrite($file, $query.PHP_EOL);
      fclose($file);
    }
  }

  $pregunta3 = "SELECT * FROM cx_pla_pag WHERE conse='$plan' AND unidad='$unidad' AND ano='$ano'";
  $sql3 = odbc_exec($conexion,$pregunta3);
  $i=1;
  while($i<$row=odbc_fetch_array($sql3))
  {
    $conse = odbc_result($sql3,1);
    $conse1 = odbc_result($sql3,2);
    $unidad = odbc_result($sql3,3);
    $ced_fuen = trim(odbc_result($sql3,4));
    $nom_fuen = trim(odbc_result($sql3,5));
    $fac_fuen = trim(odbc_result($sql3,6));
    $est_fuen = trim(odbc_result($sql3,7));
    $fec_inf = trim(odbc_result($sql3,8));
    $sin_fuen = trim($row["sin_fuen"]);
    $sin_fuen = strtr(trim($sin_fuen), $sustituye);
    $dif_fuen = odbc_result($sql3,10);
    $din_fuen = trim(odbc_result($sql3,11));
    $fec_dif = trim(odbc_result($sql3,12));
    $res_fuen = odbc_result($sql3,13);
    $rad_fuen = odbc_result($sql3,14);
    $fec_rad = trim(odbc_result($sql3,15));
    $uti_fuen = trim($row["uti_fuen"]);
    $val_fuen = trim(odbc_result($sql3,17));
    $val_fuen_a = trim(odbc_result($sql3,18));
    $uni_fuen = odbc_result($sql3,19);
    $ano = odbc_result($sql3,20);
    $val_fuen_c = trim(odbc_result($sql3,21));
    $autoriza = odbc_result($sql3,22);
    $informe = odbc_result($sql3,23);
    $rec_fuen = odbc_result($sql3,24);
    $ren_fuen = trim(odbc_result($sql3,25));
    $fec_rec = trim(odbc_result($sql3,26));
    $ord_fuen = trim(odbc_result($sql3,27));
    $bat_fuen = trim(odbc_result($sql3,28));
    $fec_ret = trim(odbc_result($sql3,29));
    $query = "INSERT INTO cx_pla_pag (conse, conse1, unidad, ced_fuen, nom_fuen, fac_fuen, est_fuen, fec_inf, sin_fuen, dif_fuen, din_fuen, fec_dif, res_fuen, rad_fuen, fec_rad, uti_fuen, val_fuen, val_fuen_a, uni_fuen, ano, val_fuen_c, autoriza, informe, rec_fuen, ren_fuen, fec_rec, ord_fuen, bat_fuen, fec_ret) VALUES ('$conse', '$conse1', '$unidad', '$ced_fuen', '$nom_fuen', '$fac_fuen', '$est_fuen', '$fec_inf', '$sin_fuen', '$dif_fuen', '$din_fuen', '$fec_dif', '$res_fuen', '$rad_fuen', '$fec_rad', '$uti_fuen', '$val_fuen', '$val_fuen_a', '$uni_fuen', '$ano', '$val_fuen_c', '$autoriza', '$informe', '$rec_fuen', '$ren_fuen', '$fec_rec', '$ord_fuen', '$bat_fuen', '$fec_ret')";
    $file = fopen($carpeta1."\\"."log_plan".$plan."_".$ano.".txt", "a");
    fwrite($file, $query.PHP_EOL);
    fclose($file);
  }
  $salida = new stdClass();
  $salida->conse = $plan;
  echo json_encode($salida);
}
?>