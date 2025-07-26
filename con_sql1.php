<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
ini_set('memory_limit', '10240M');
ini_set('max_execution_time', 3600);
$sustituye = array ( "[\n]" => "", "[\r]" => "", "[\n\r]" => "", "[\t]" => "", "[\0]" => "", "[\x0B]" => "" );
if ($_SESSION["autenticado"] = "SI")
{
  if (is_ajax())
  {
    if ($sup_usuario == "1")
    {
      $ruta_local1 = $ruta_local."\\tmp";
      $ano = date('Y');
      $ano = trim($ano);
      $mes = date('m');
      $mes = trim($mes);
      $dia = date('d');
      $dia = trim($dia);
      $carpeta1 = $ruta_local1."\\".$ano.$mes.$dia;
      if(!file_exists($carpeta1))
      {
          mkdir ($carpeta1);
      }
      unlink($carpeta1."\\"."log_cx_gastos.txt");
      $sql = odbc_exec($conexion,"SELECT * from cx_pla_inv ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        while($i < $row = odbc_fetch_array($sql))
        {
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
          $query = "INSERT INTO cx_pla_inv (conse, fecha, usuario, unidad, estado, lugar, factor, estructura, periodo, oficiales, suboficiales, auxiliares, soldados, ordop, n_ordop, misiones, n_misiones, gastos, pagos, tipo, actual, ano, oms, compania, aprueba, revisa, tipo1, usuario1, usuario2, usuario3, usuario4, usuario5, usuario6, autoriza, uni_anu, fec_anu, usuario7, usuario8, usuario9, usuario10, usuario11, usuario12, usuario13, recursos) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$estado', '$lugar', '$factor', '$estructura', '$periodo', '$oficiales', '$suboficiales', '$auxiliares', '$soldados', '$ordop', '$n_ordop', '$misiones', '$n_misiones', '$hastos', '$pagos', '$tipo', '$actual', '$ano', '$oms', '$compania', '$aprueba', '$revisa', '$tipo1', '$usuario1', '$usuario2', '$usuario3', '$usuario4', '$usuario5', '$usuario6', '$autoriza', '$uni_anu', '$fec_anu', '$usuario7', '$usuario8', '$usuario9', '$usuario10', '$usuario11', '$usuario12', '$usuario13', '$recursos')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_pla_pag
      $sql = odbc_exec($conexion,"SELECT * from cx_pla_pag ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA PLANES PAGOS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $conse1 = odbc_result($sql,2);
          $unidad = odbc_result($sql,3);
          $ced_fuen = trim(odbc_result($sql,4));
          $nom_fuen = trim(odbc_result($sql,5));
          $fac_fuen = trim(odbc_result($sql,6));
          $est_fuen = trim(odbc_result($sql,7));
          $fec_inf = trim(odbc_result($sql,8));
          $sin_fuen = trim($row["sin_fuen"]);
          $sin_fuen = strtr(trim($sin_fuen), $sustituye);
          //$sin_fuen = preg_replace("[\n|\r|\n\r|\t|\0|\x0B]", "", $sin_fuen);
          $dif_fuen = odbc_result($sql,10);
          $din_fuen = trim(odbc_result($sql,11));
          $fec_dif = trim(odbc_result($sql,12));
          $res_fuen = odbc_result($sql,13);
          $rad_fuen = odbc_result($sql,14);
          $fec_rad = trim(odbc_result($sql,15));
          $uti_fuen = trim($row["uti_fuen"]);
          $val_fuen = trim(odbc_result($sql,17));
          $val_fuen_a = trim(odbc_result($sql,18));
          $uni_fuen = odbc_result($sql,19);
          $ano = odbc_result($sql,20);
          $val_fuen_c = trim(odbc_result($sql,21));
          $query = "INSERT INTO cx_pla_pag (conse, conse1, unidad, ced_fuen, nom_fuen, fac_fuen, est_fuen, fec_inf, sin_fuen, dif_fuen, din_fuen, fec_dif, res_fuen, rad_fuen, fec_rad, uti_fuen, val_fuen, val_fuen_a, uni_fuen, ano, valor_c) VALUES ('$conse', '$conse1', '$unidad', '$ced_fuen', '$nom_fuen', '$fac_fuen', '$est_fuen', '$fec_inf', '$sin_fuen', '$dif_fuen', '$din_fuen', '$fec_dif', '$res_fuen', '$rad_fuen', '$fec_rad', '$uti_fuen', '$val_fuen', '$val_fuen_a', '$uni_fuen', '$ano', '$valor_c')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_pla_gas
      $sql = odbc_exec($conexion,"SELECT * from cx_pla_gas ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA PLANES GASTOS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $conse1 = odbc_result($sql,2);
          $interno = odbc_result($sql,3);
          $unidad = odbc_result($sql,4);
          $mision = trim(odbc_result($sql,5));
          $area = trim(odbc_result($sql,6));
          $fechai = trim(odbc_result($sql,7));
          $fechaf = trim(odbc_result($sql,8));
          $oficiales = odbc_result($sql,9);
          $suboficiales = odbc_result($sql,10);
          $auxiliares = odbc_result($sql,11);
          $soldados = odbc_result($sql,12);
          $valor = trim(odbc_result($sql,13));
          $valor_a = trim(odbc_result($sql,14));
          $actividades = odbc_result($sql,15);
          $factor = trim(odbc_result($sql,16));
          $estructura = trim(odbc_result($sql,17));
          $ano = odbc_result($sql,18);
          $valor_c = trim(odbc_result($sql,19));
          $query = "INSERT INTO cx_pla_gas (conse, conse1, interno, unidad, mision, area, fechai, fechaf, oficiales, suboficiales, auxiliares, soldados, valor, valor_a, actividades, factor, estructura, ano, valor_c) VALUES ('$conse', '$conse1', '$interno', '$unidad', '$mision', '$area', '$fechai', '$fechaf', '$oficiales', '$suboficiales', '$auxiliares', '$soldados', '$valor', '$valor_a', '$actividades', '$factor', '$estructura', '$ano', '$valor_c')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_pla_gad
      $sql = odbc_exec($conexion,"SELECT * from cx_pla_gad ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA PLANES GASTOS DISCRIMINADOS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $conse1 = odbc_result($sql,2);
          $interno = odbc_result($sql,3);
          $unidad = odbc_result($sql,4);
          $gasto = trim(odbc_result($sql,5));
          $otro = trim(odbc_result($sql,6));
          $valor = trim(odbc_result($sql,7));
          $ano = odbc_result($sql,8);
          $query = "INSERT INTO cx_pla_gad (conse, conse1, interno, unidad, gasto, otro, valor, ano) VALUES ('$conse', '$conse1', '$interno', '$unidad', '$gasto', '$otro', '$valor', '$ano')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_pla_inf
      $sql = odbc_exec($conexion,"SELECT * from cx_pla_inf ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA PLANES INFORMANTES".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = odbc_result($sql,2);
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $cedula = trim(odbc_result($sql,5));
          $nombre = trim(odbc_result($sql,6));
          $query = "INSERT INTO cx_pla_inf (conse, fecha, usuario, unidad, cedula, nombre) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$cedula', '$nombre')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_pla_con
      $sql = odbc_exec($conexion,"SELECT * from cx_pla_con ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA PLANES CONSOLIDADOS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = odbc_result($sql,2);
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $estado = trim(odbc_result($sql,5));
          $periodo = odbc_result($sql,6);
          $ano = odbc_result($sql,7);
          $planes = trim(odbc_result($sql,8));
          $query = "INSERT INTO cx_pla_con (conse, fecha, usuario, unidad, estado, periodo, ano, planes) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$estado', '$periodo', '$ano', '$planes')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_pla_cen
      $sql = odbc_exec($conexion,"SELECT * from cx_pla_cen ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA PLANES CENTRALIZADOS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = odbc_result($sql,2);
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $estado = trim(odbc_result($sql,5));
          $periodo = odbc_result($sql,6);
          $ano = odbc_result($sql,7);
          $saldo = trim(odbc_result($sql,8));
          $gastos = trim(odbc_result($sql,9));
          $pagos = trim(odbc_result($sql,10));
          $recompensas = trim(odbc_result($sql,11));
          $gastos1 = trim(odbc_result($sql,12));
          $pagos1 = trim(odbc_result($sql,13));
          $recompensas1 = trim(odbc_result($sql,14));
          $revisa = odbc_result($sql,15);
          $ordena = odbc_result($sql,16);
          $visto = odbc_result($sql,17);
          $nota = trim(odbc_result($sql,18));
          $query = "INSERT INTO cx_pla_cen (conse, fecha, usuario, unidad, estado, periodo, ano, saldo, gastos, pagos, recompensas, gastos1, pagos1, recompensas1, revisa, ordena, visto, nota) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$estado', '$periodo', '$ano', '$saldo', '$gastos', '$pagos', '$recompensas', '$gastos1', '$pagos1', '$recompensas1', '$revisa', '$ordena', '$visto', '$nota')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_notifica
      $sql = odbc_exec($conexion,"SELECT * from cx_notifica ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA NOTIFICACIONES".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = odbc_result($sql,2);
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $usuario1 = trim(odbc_result($sql,5));
          $unidad1 = odbc_result($sql,6);
          $mensaje = trim($row["mensaje"]);
          $tipo = odbc_result($sql,8);
          $visto = odbc_result($sql,9);
          $query = "INSERT INTO cx_notifica (conse, fecha, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$usuario1', '$unidad1', '$mensaje', '$tipo', '$visto')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_val_aut
      $sql = odbc_exec($conexion,"SELECT * from cx_val_aut ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA VALORES AUTORIZADOS PLANES".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = odbc_result($sql,2);
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $periodo = odbc_result($sql,5);
          $ano = odbc_result($sql,6);
          $sigla = trim(odbc_result($sql,7));
          $gastos = odbc_result($sql,8);
          $pagos = odbc_result($sql,9);
          $total = odbc_result($sql,10);
          $aprueba = trim(odbc_result($sql,11));
          $fecha_a = odbc_result($sql,12);
          $estado = trim(odbc_result($sql,13));
          $depen = trim(odbc_result($sql,14));
          $n_depen = trim(odbc_result($sql,15));
          $uom = trim(odbc_result($sql,16));
          $n_uom = trim(odbc_result($sql,17));
          $inf_giro = odbc_result($sql,18);
          $gastose = odbc_result($sql,19);
          $pagose = odbc_result($sql,20);
          $query = "INSERT INTO cx_val_aut (conse, fecha, usuario, unidad, periodo, ano, sigla, gastos, pagos, total, aprueba, fecha_a, estado, depen, n_depen, uom, n_uom, inf_giro, gastose, pagose) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$periodo', '$ano', '$sigla', '$gastos', '$pagos', '$total', '$aprueba', '$fecha_a', '$estado', '$depen', '$n_depen', '$uom', '$n_uom', '$inf_giro', '$gastose', '$pagose')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_val_aut1
      $sql = odbc_exec($conexion,"SELECT * from cx_val_aut1 ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA VALORES AUTORIZADOS SOLICITUDES".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = odbc_result($sql,2);
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $periodo = odbc_result($sql,5);
          $ano = odbc_result($sql,6);
          $sigla = trim(odbc_result($sql,7));
          $gastos = odbc_result($sql,8);
          $pagos = odbc_result($sql,9);
          $total = odbc_result($sql,10);
          $aprueba = trim(odbc_result($sql,11));
          $fecha_a = odbc_result($sql,12);
          $estado = trim(odbc_result($sql,13));
          $depen = trim(odbc_result($sql,14));
          $n_depen = trim(odbc_result($sql,15));
          $uom = trim(odbc_result($sql,16));
          $n_uom = trim(odbc_result($sql,17));
          $inf_giro = odbc_result($sql,18);
          $gastose = odbc_result($sql,19);
          $pagose = odbc_result($sql,20);
          $solicitud = odbc_result($sql,21);
          $query = "INSERT INTO cx_val_aut1 (conse, fecha, usuario, unidad, periodo, ano, sigla, gastos, pagos, total, aprueba, fecha_a, estado, depen, n_depen, uom, n_uom, inf_giro, gastose, pagose, solicitud) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$periodo', '$ano', '$sigla', '$gastos', '$pagos', '$total', '$aprueba', '$fecha_a', '$estado', '$depen', '$n_depen', '$uom', '$n_uom', '$inf_giro', '$gastose', '$pagose', '$solicitud')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_val_gir
      $sql = odbc_exec($conexion,"SELECT * from cx_val_gir ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA VALORES GIRADOS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = odbc_result($sql,2);
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $periodo = odbc_result($sql,5);
          $ano = odbc_result($sql,6);
          $sigla = trim(odbc_result($sql,7));
          $gastos = odbc_result($sql,8);
          $pagos = odbc_result($sql,9);
          $total = odbc_result($sql,10);
          $concepto = trim(odbc_result($sql,11));
          $estado = trim(odbc_result($sql,12));
          $query = "INSERT INTO cx_val_gir (conse, fecha, usuario, unidad, periodo, ano, sigla, gastos, pagos, total, concepto, estado) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$periodo', '$ano', '$sigla', '$gastos', '$pagos', '$total', '$concepto', '$estado')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_sol_aut
      $sql = odbc_exec($conexion,"SELECT * from cx_sol_aut ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA AUTORIZACION SOLICITUD DE RECURSOS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = odbc_result($sql,2);
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $estado = trim(odbc_result($sql,5));
          $planes = trim(odbc_result($sql,6));
          $ano = odbc_result($sql,7);
          $firmas = trim($row["firmas"]);
          $asunto = trim($row["asunto"]);
          $sustenta = trim($row["sustentacion"]);
          $observaciones = trim($row["observaciones"]);
          $query = "INSERT INTO cx_sol_aut (conse, fecha, usuario, unidad, estado, planes, ano, firmas, asunto, sustentacion, observaciones) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$estado', '$planes', '$ano', '$firmas', '$asunto', '$sustenta', '$observaciones')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_org_uni - Tabla unidades
      $sql = odbc_exec($conexion,"SELECT * from cx_org_uni ORDER BY unidad");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA UNIDADES".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $unidad = odbc_result($sql,1);
          $nombre = trim(odbc_result($sql,2));
          $query = "INSERT INTO cx_org_uni (unidad, nombre) VALUES ('$unidad', '$nombre')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_org_dep - Tabla dependencias
      $sql = odbc_exec($conexion,"SELECT * from cx_org_dep ORDER BY dependencia");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA DEPENDENCIAS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $unidad = odbc_result($sql,1);
          $dependencia = odbc_result($sql,2);
          $nombre = trim(odbc_result($sql,3));
          $query = "INSERT INTO cx_org_dep (unidad, dependencia, nombre) VALUES ('$unidad', '$dependencia', '$nombre')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_org_sub - Tabla subdependencias
      $sql = odbc_exec($conexion,"SELECT * from cx_org_sub ORDER BY subdependencia");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA SUBDEPENDENCIAS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $unidad = odbc_result($sql,1);
          $dependencia = odbc_result($sql,2);
          $subdependencia = odbc_result($sql,3);
          $sigla = trim(odbc_result($sql,4));
          $ciudad = trim(odbc_result($sql,5));
          $nombre = trim(odbc_result($sql,6));
          $tipo = odbc_result($sql,7);
          $unic = odbc_result($sql,8);
          $techo = trim(odbc_result($sql,9));
          $banco = odbc_result($sql,10);
          $cuenta = trim(odbc_result($sql,11));
          $cheque = trim(odbc_result($sql,12));
          $firma1 = trim(odbc_result($sql,13));
          $firma2 = trim(odbc_result($sql,14));
          $firma3 = trim(odbc_result($sql,15));
          $firma4 = trim(odbc_result($sql,16));
          $usuario = trim(odbc_result($sql,17));
          $saldo = odbc_result($sql,18);
          if ($saldo == ".00")
          {
            $saldo = "0.00";
          }
          $s_10_1 = odbc_result($sql,19);
          if ($s_10_1 == ".00")
          {
            $s_10_1 = "0.00";
          }
          $s_10_2 = odbc_result($sql,20);
          if ($s_10_2 == ".00")
          {
            $s_10_2 = "0.00";
          }
          $s_50_1 = odbc_result($sql,21);
          if ($s_50_1 == ".00")
          {
            $s_50_1 = "0.00";
          }
          $s_50_2 = odbc_result($sql,22);
          if ($s_50_2 == ".00")
          {
            $s_50_2 = "0.00";
          }
          $s_16_1 = odbc_result($sql,23);
          if ($s_16_1 == ".00")
          {
            $s_16_1 = "0.00";
          }
          $s_16_2 = odbc_result($sql,24);
          if ($s_16_2 == ".00")
          {
            $s_16_2 = "0.00";
          }
          $s_99_1 = odbc_result($sql,25);
          if ($s_99_1 == ".00")
          {
            $s_99_1 = "0.00";
          }
          $s_99_2 = odbc_result($sql,26);
          if ($s_99_2 == ".00")
          {
            $s_99_2 = "0.00";
          }
          $nit = trim(odbc_result($sql,27));
          $cargo1 = trim(odbc_result($sql,28));
          $cargo2 = trim(odbc_result($sql,29));
          $cargo3 = trim(odbc_result($sql,30));
          $cargo4 = trim(odbc_result($sql,31));
          $act_inf = odbc_result($sql,32);
          $act_rec = odbc_result($sql,33);
          $inf_eje = odbc_result($sql,34);
          $pla_gas = odbc_result($sql,35);
          $rel_gas = odbc_result($sql,36);
          $mis_tra = odbc_result($sql,37);
          $com_ing = odbc_result($sql,38);
          $com_egr = odbc_result($sql,39);
          $query = "INSERT INTO cx_org_sub (unidad, dependencia, subdependencia, sigla, ciudad, nombre, tipo, unic, techo, banco, cuenta, cheque, firma1, firma2, firma3, firma4, usuario, saldo, s_10_1, s_10_2, s_50_1, s_50_2, s_16_1, s_16_2, s_99_1, s_99_2, nit, cargo1, cargo2, cargo3, cargo4, act_inf, act_rec, inf_eje, pla_gas, rel_gas, mis_tra, com_ing, com_egr) VALUES ('$unidad', '$dependencia', '$subdependencia', '$sigla', '$ciudad', '$nombre', '$tipo', '$unic', '$techo', '$banco', '$cuenta', '$cheque', '$firma1', '$firma2', '$firma3', '$firma4', '$usuario', '$saldo', '$s_10_1', '$s_10_2', '$s_50_1', '$s_50_2', '$s_16_1', '$s_16_2', '$s_99_1', '$s_99_2', '$nit', '$cargo1', '$cargo2', '$cargo3', '$cargo4', '$act_inf', '$act_rec', '$inf_eje', '$pla_gas', '$rel_gas', '$mis_tra', '$com_ing', '$com_egr')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_org_cmp - Tabla compañias
      $sql = odbc_exec($conexion,"SELECT * from cx_org_cmp ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA COMPANIAS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $tipo = odbc_result($sql,2);
          $nombre = trim(odbc_result($sql,3));
          $sigla = trim(odbc_result($sql,4));
          $query = "INSERT INTO cx_org_cmp (conse, tipo, nombre, sigla) VALUES ('$conse', '$tipo', '$nombre', '$sigla')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_ctr_est - Tabla estructuras
      $sql = odbc_exec($conexion,"SELECT * from cx_ctr_est ORDER BY codigo");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA ESTRUCTURAS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $codigo = odbc_result($sql,1);
          $conse = odbc_result($sql,2);
          $nombre = trim(odbc_result($sql,3));
          $query = "INSERT INTO cx_ctr_est (codigo, conse, nombre) VALUES ('$codigo', '$conse', '$nombre')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_ctr_sop - Tabla soportes
      $sql = odbc_exec($conexion,"SELECT * from cx_ctr_sop ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA SOPORTES".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $nombre = trim(odbc_result($sql,2));
          $query = "INSERT INTO cx_ctr_sop (conse, nombre) VALUES ('$conse', '$nombre')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_ctr_fac - Tabla factores
      $sql = odbc_exec($conexion,"SELECT * from cx_ctr_fac ORDER BY codigo");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA FACTORES".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $codigo = odbc_result($sql,1);
          $nombre = trim(odbc_result($sql,2));
          $descrip = trim($row["descrip"]);
          $query = "INSERT INTO cx_ctr_fac (codigo, nombre, descrip) VALUES ('$codigo', '$nombre', '$descrip')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_apropia - Tabla apropiaciones
      $sql = odbc_exec($conexion,"SELECT * from cx_apropia ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA APROPIACION".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = trim(odbc_result($sql,2));
          $valor = trim(odbc_result($sql,3));
          $valor1 = trim(odbc_result($sql,4));
          $ano = odbc_result($sql,5);
          $usuario = trim(odbc_result($sql,6));
          $saldo = trim(odbc_result($sql,7));
          $fecha1 = trim(odbc_result($sql,8));
          $destino = trim(odbc_result($sql,9));
          $recurso = odbc_result($sql,10);
          $rubro = odbc_result($sql,11);
          $recurso1 = trim(odbc_result($sql,12));
          $rubro1 = trim(odbc_result($sql,13));
          $query = "INSERT INTO cx_apropia (conse, fecha, valor, valor1, ano, usuario, saldo, fecha1, destino, recurso, rubro, recurso1, rubro1) VALUES ('$conse', '$fecha', '$valor', '$valor1', '$ano', '$usuario', '$saldo', '$fecha1', '$destino', '$recurso', '$rubro', '$recurso1', '$rubro1')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_cdp - Tabla cdp
      $sql = odbc_exec($conexion,"SELECT * from cx_cdp ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA CDP".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = trim(odbc_result($sql,2));
          $numero = trim(odbc_result($sql,3));
          $fecha1 = trim(odbc_result($sql,4));
          $origen = odbc_result($sql,5);
          $recurso = odbc_result($sql,6);
          $rubro = odbc_result($sql,7);
          $concepto = odbc_result($sql,8);
          $valor = trim(odbc_result($sql,9));
          $valor1 = trim(odbc_result($sql,10));
          $destino = trim(odbc_result($sql,11));
          $vigencia = odbc_result($sql,12);
          $usuario = trim(odbc_result($sql,13));
          $saldo = trim(odbc_result($sql,14));
          $query = "INSERT INTO cx_cdp (conse, fecha, numero, fecha1, origen, recurso, rubro, concepto, valor, valor1, destino, vigencia, usuario, saldo) VALUES ('$conse', '$fecha', '$numero', '$fecha1', '$origen', '$recurso', '$rubro', '$concepto', '$valor', '$valor1', '$destino', '$vigencia', '$usuario', '$saldo')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_crp - Tabla crp
      $sql = odbc_exec($conexion,"SELECT * from cx_crp ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA CRP".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $conse1 = odbc_result($sql,2);
          $fecha = trim(odbc_result($sql,3));
          $numero = trim(odbc_result($sql,4));
          $fecha1 = trim(odbc_result($sql,5));
          $origen = odbc_result($sql,6);
          $recurso = odbc_result($sql,7);
          $rubro = odbc_result($sql,8);
          $valor = trim(odbc_result($sql,9));
          $valor1 = trim(odbc_result($sql,10));
          $destino = trim(odbc_result($sql,11));
          $usuario = trim(odbc_result($sql,12));
          $saldo = trim(odbc_result($sql,13));
          $query = "INSERT INTO cx_crp (conse, conse1, fecha, numero, fecha1, origen, recurso, rubro, valor, valor1, destino, usuario, saldo) VALUES ('$conse', '$conse1', '$fecha', '$numero', '$fecha1', '$origen', '$recurso', '$rubro', '$valor', '$valor1', '$destino', '$usuario', '$saldo')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_crp_dis - Tabla crp disponible
      $sql = odbc_exec($conexion,"SELECT * from cx_crp_dis ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA CRP DISPONIBLE".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $conse1 = odbc_result($sql,2);
          $fecha = trim(odbc_result($sql,3));
          $valor = trim(odbc_result($sql,4));
          $valor1 = trim(odbc_result($sql,5));
          $tipo = trim(odbc_result($sql,6));
          $usuario = trim(odbc_result($sql,7));
          $fecha1 = trim(odbc_result($sql,8));
          $query = "INSERT INTO cx_crp_dis (conse, conse1, fecha, valor, valor1, tipo, usuario, fecha1) VALUES ('$conse', '$conse1', '$fecha', '$valor', '$valor1', '$tipo', '$usuario', '$fecha1')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_apro_dis - Tabla apropiacion disponible
      $sql = odbc_exec($conexion,"SELECT * from cx_apro_dis ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA APROPIACION DISPONIBLE".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $conse1 = odbc_result($sql,2);
          $fecha = trim(odbc_result($sql,3));
          $valor = trim(odbc_result($sql,4));
          $valor1 = trim(odbc_result($sql,5));
          $tipo = trim(odbc_result($sql,6));
          $usuario = trim(odbc_result($sql,7));
          $fecha1 = trim(odbc_result($sql,8));
          $recurso = odbc_result($sql,9);
          $rubro = odbc_result($sql,10);
          $recurso1 = trim(odbc_result($sql,11));
          $rubro1 = trim(odbc_result($sql,12));
          $query = "INSERT INTO cx_apro_dis (conse, conse1, fecha, valor, valor1, tipo, usuario, fecha1, recurso, rubro, recurso1, rubro1) VALUES ('$conse', '$conse1', '$fecha', '$valor', '$valor1', '$tipo', '$usuario', '$fecha1', '$recurso', '$rubro', '$recurso1', '$rubro1')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_inf_aut - Tabla informes de autorizacion
      $sql = odbc_exec($conexion,"SELECT * from cx_inf_aut ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA INFOMRES DE AUTORIZACION".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = odbc_result($sql,2);
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $periodo = odbc_result($sql,5);
          $ano = odbc_result($sql,6);
          $unidad1 = odbc_result($sql,7);
          $gastos = trim(odbc_result($sql,8));
          $pagos = trim(odbc_result($sql,9));
          $total = trim(odbc_result($sql,10));
          $plazo = trim(odbc_result($sql,11));
          $directiva = trim(odbc_result($sql,12));
          $otro = trim($row["otro"]);
          $query = "INSERT INTO cx_inf_aut (conse, fecha, usuario, unidad, periodo, ano, unidad1, gastos, pagos, total, plazo, directiva, otro) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$periodo', '$ano', '$unidad1', '$gastos', '$pagos', '$total', '$plazo', '$directiva', '$otro')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_inf_dis - Tabla informes de autorizacion discriminado
      $sql = odbc_exec($conexion,"SELECT * from cx_inf_dis ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA INFOMRES DE AUTORIZACION DISCRIMINADO".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $conse1 = odbc_result($sql,2);
          $unidad = odbc_result($sql,3);
          $dato = trim(odbc_result($sql,4));
          $valor = trim(odbc_result($sql,5));
          $tipo = odbc_result($sql,6);
          $compa = odbc_result($sql,7);
          $query = "INSERT INTO cx_inf_dis (conse, conse1, unidad, dato, valor, tipo, compa) VALUES ('$conse', '$conse1', '$unidad', '$dato', '$valor', '$tipo', '$compa')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_gas_bas - Tabla gastos basicos
      $sql = odbc_exec($conexion,"SELECT * from cx_gas_bas ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA PLANILLA GASTOS BASICOS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = trim(odbc_result($sql,2));
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $ciudad = trim(odbc_result($sql,5));
          $ordop = trim(odbc_result($sql,6));
          $n_ordop = trim(odbc_result($sql,7));
          $mision = trim(odbc_result($sql,8));
          $periodo = odbc_result($sql,9);
          $ano = odbc_result($sql,10);
          $total = trim(odbc_result($sql,11));
          $responsable = trim(odbc_result($sql,12));
          $tarifa1 = trim(odbc_result($sql,13));
          $tarifa2 = trim(odbc_result($sql,14));
          $tarifa3 = trim(odbc_result($sql,15));
          $interno = odbc_result($sql,16);
          $numero = odbc_result($sql,17);
          $query = "INSERT INTO cx_gas_bas (conse, fecha, usuario, unidad, ciudad, ordop, n_ordop, mision, periodo, ano, total, responsable, tarifa1, tarifa2, tarifa3, interno, numero) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$ciudad', '$ordop', '$n_ordop', '$mision', '$periodo', '$ano', '$total', '$responsable', '$tarifa1', '$tarifa2', '$tarifa3', '$interno', '$numero')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_gas_dis - Tabla gastos basicos discriminado
      $sql = odbc_exec($conexion,"SELECT * from cx_gas_dis ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA PLANILLA GASTOS BASICOS DISCRIMINADO".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $conse1 = odbc_result($sql,2);
          $cedula = trim(odbc_result($sql,3));
          $nombre = trim(odbc_result($sql,4));
          $ciudad = trim(odbc_result($sql,5));
          $v1 = odbc_result($sql,6);
          $v2 = odbc_result($sql,7);
          $v3 = odbc_result($sql,8);
          $valor = trim(odbc_result($sql,9));
          $valor1 = trim(odbc_result($sql,10));
          $v4 = odbc_result($sql,11);
          $interno = odbc_result($sql,12);
          $numero = odbc_result($sql,13);
          $query = "INSERT INTO cx_gas_dis (conse, conse1, cedula, nombre, ciudad, v1, v2, v3, valor, valor1, v4, interno, numero) VALUES ('$conse', '$conse1', '$cedula', '$nombre', '$ciudad', '$v1', '$v2', '$v3', '$valor', '$valor1', '$v4', '$interno', '$numero')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_rel_gas - Tabla relacion gastos
      $sql = odbc_exec($conexion,"SELECT * from cx_rel_gas ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA RELACION GASTOS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = trim(odbc_result($sql,2));
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $ciudad = trim(odbc_result($sql,5));
          $comprobante = odbc_result($sql,6);
          $ordop = trim(odbc_result($sql,7));
          $n_ordop = trim(odbc_result($sql,8));
          $mision = trim(odbc_result($sql,9));
          $periodo = odbc_result($sql,10);
          $ano = odbc_result($sql,11);
          $total = trim(odbc_result($sql,12));
          $csoporte = trim(odbc_result($sql,13));
          $ssoporte = trim(odbc_result($sql,14));
          $responsable = trim(odbc_result($sql,15));
          $tipo = trim(odbc_result($sql,16));
          $numero = trim(odbc_result($sql,17));
          $consecu = trim(odbc_result($sql,18));
          $query = "INSERT INTO cx_rel_gas (conse, fecha, usuario, unidad, ciudad, comprobante, ordop, n_ordop, mision, periodo, ano, total, csoporte, ssoporte, responsable, tipo, numero, consecu) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$ciudad', '$comprobante', '$ordop', '$n_ordop', '$mision', '$periodo', '$ano', '$total', '$csoporte', '$ssoporte', '$responsable', '$tipo', '$numero', '$consecu')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_rel_dis - Tabla relacion gastos discriminado
      $sql = odbc_exec($conexion,"SELECT * from cx_rel_dis ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA RELACION GASTOS DISCRIMINADO".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $conse1 = odbc_result($sql,2);
          $gasto = odbc_result($sql,3);
          $valor = trim(odbc_result($sql,4));
          $valor1 = trim(odbc_result($sql,5));
          $tipo = odbc_result($sql,6);
          $consecu = odbc_result($sql,7);
          $query = "INSERT INTO cx_rel_dis (conse, conse1, gasto, valor, valor1, tipo, consecu) VALUES ('$conse', '$conse1', '$gasto', '$valor', '$valor1', '$tipo', '$consecu')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_inf_eje - Tabla informe ejecucion
      $sql = odbc_exec($conexion,"SELECT * from cx_inf_eje ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA INFORME EJECUCION".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = trim(odbc_result($sql,2));
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $ciudad = trim(odbc_result($sql,5));
          $ordop = trim(odbc_result($sql,6));
          $n_ordop = trim(odbc_result($sql,7));
          $mision = trim(odbc_result($sql,8));
          $valor = trim(odbc_result($sql,9));
          $sitio = trim(odbc_result($sql,10));
          $fechai = trim(odbc_result($sql,11));
          $fechaf = trim(odbc_result($sql,12));
          $factor = trim(odbc_result($sql,13));
          $actividades = trim($row["actividades"]);
          $sintesis = trim($row["sintesiss"]);
          $aspectos = trim($row["aspectos"]);
          $bienes = trim($row["bienes"]);
          $personal = trim($row["personal"]);
          $equipo = trim($row["equipo"]);
          $responsable = trim(odbc_result($sql,20));
          $ano = odbc_result($sql,21);
          $numero = trim(odbc_result($sql,22));
          $consecu = trim(odbc_result($sql,23));
          $query = "INSERT INTO cx_inf_eje (conse, fecha, usuario, unidad, ciudad, ordop, n_ordop, mision, valor, sitio, fechai, fechaf, factor, actividades, sintesis, aspectos, bienes, personal, equipo, responsable, ano, numero, consecu) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$ciudad', '$ordop', '$n_ordop', '$mision', '$valor', '$sitio', '$fechai', '$fechaf', '$factor', '$actividades', '$sintesis', '$aspectos', '$bienes', '$personal', '$equipo', '$responsable', '$ano', '$numero', '$consecu')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_sal_uni - Tabla saldos de unidades
      $sql = odbc_exec($conexion,"SELECT * from cx_sal_uni ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA SALDOS DE UNIDADES".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = trim(odbc_result($sql,2));
          $unidad = odbc_result($sql,3);
          $periodo = odbc_result($sql,4);
          $ano = odbc_result($sql,5);
          $saldo = trim(odbc_result($sql,6));
          $query = "INSERT INTO cx_sal_uni (conse, fecha, unidad, periodo, ano, saldo) VALUES ('$conse', '$fecha', '$unidad', '$periodo', '$ano', '$saldo')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_com_egr - Tabla comprobantes de egreso
      $sql = odbc_exec($conexion,"SELECT * from cx_com_egr ORDER BY egreso, ano");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA COMPROBANTES DE EGRESO".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $egreso = odbc_result($sql,1);
          $fecha = trim(odbc_result($sql,2));
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $periodo = odbc_result($sql,5);
          $ano = odbc_result($sql,6);
          $tipo = odbc_result($sql,7);
          $estado = trim(odbc_result($sql,8));
          $valor = trim(odbc_result($sql,9));
          $subtotal = trim(odbc_result($sql,10));
          $iva = trim(odbc_result($sql,11));
          if ($iva == ".00")
          {
            $iva = "0.00";
          }
          $total = trim(odbc_result($sql,12));
          $retefuente = trim(odbc_result($sql,13));
          if ($retefuente == ".00")
          {
            $retefuente = "0.00";
          }
          $reteica = trim(odbc_result($sql,14));
          if ($reteica == ".00")
          {
            $reteica = "0.00";
          }
          $reteiva = trim(odbc_result($sql,15));
          if ($reteiva == ".00")
          {
            $reteiva = "0.00";
          }
          $neto = trim(odbc_result($sql,16));
          $p_iva = trim(odbc_result($sql,17));
          if ($p_iva == ".00")
          {
            $p_iva = "0.00";
          }
          $p_ret = trim(odbc_result($sql,18));
          if ($p_ret == ".00")
          {
            $p_ret = "0.00";
          }
          $p_ica = trim(odbc_result($sql,19));
          if ($p_ica == ".00")
          {
            $p_ica = "0.00";
          }
          $p_riva = trim(odbc_result($sql,20));
          if ($p_riva == ".00")
          {
            $p_riva = "0.00";
          }
          $concepto = odbc_result($sql,21);
          $tp_gas = odbc_result($sql,22);
          $recurso = odbc_result($sql,23);
          $rubro = odbc_result($sql,24);
          $autoriza = odbc_result($sql,25);
          $num_auto = odbc_result($sql,26);
          $soporte = odbc_result($sql,27);
          $num_sopo = trim(odbc_result($sql,28));
          $pago = odbc_result($sql,29);
          $det_pago = trim(odbc_result($sql,30));
          $datos = trim($row["datos"]);
          $firmas = trim($row["firmas"]);
          $usua_anu = trim(odbc_result($sql,33));
          $fec_anu = trim(odbc_result($sql,34));
          $ciudad = trim(odbc_result($sql,35));
          $unidad1 = odbc_result($sql,36);
          $concepto1 = odbc_result($sql,37);
          $descripcion = trim(odbc_result($sql,38));
          $cdp = odbc_result($sql,39);
          $crp = odbc_result($sql,40);
          $query = "INSERT INTO cx_com_egr (egreso, fecha, usuario, unidad, periodo, ano, tipo, estado, valor, subtotal, iva, total, retefuente, reteica, reteiva, neto, p_iva, p_ret, p_ica, p_riva, concepto, tp_gas, recurso, rubro, autoriza, num_auto, soporte, num_sopo, pago, det_pago, datos, firmas, usua_anu, fec_anu, ciudad, unidad1, concepto1, descripcio, cdp, crp) VALUES ('$egreso', '$fecha', '$usuario', '$unidad', '$periodo', '$ano', '$tipo', '$estado', '$valor', '$subtotal', '$iva', '$total', '$retefuente', '$reteica', '$reteiva', '$neto', '$p_iva', '$p_ret', '$p_ica', '$p_riva', '$concepto', '$tp_gas', '$recurso', '$rubro', '$autoriza', '$num_auto', '$soporte', '$num_sopo', '$pago', '$det_pago', '$datos', '$firmas', '$usua_anu', '$fec_anu', '$ciudad', '$unidad1', '$concepto1', '$descripcion', '$cdp', '$crp')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_com_ing - Tabla comprobantes de ingreso
      $sql = odbc_exec($conexion,"SELECT * from cx_com_ing ORDER BY ingreso, ano");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA COMPROBANTES DE INGRESO".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $ingreso = odbc_result($sql,1);
          $fecha = trim(odbc_result($sql,2));
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $periodo = odbc_result($sql,5);
          $ano = odbc_result($sql,6);
          $tipo = odbc_result($sql,7);
          $estado = trim(odbc_result($sql,8));
          $valor = trim(odbc_result($sql,9));
          $concepto = odbc_result($sql,10);
          $recurso = odbc_result($sql,11);
          $rubro = odbc_result($sql,12);
          $soporte = odbc_result($sql,13);
          $num_sopo = trim(odbc_result($sql,14));
          $fec_sopo = trim(odbc_result($sql,15));
          $transferencia = odbc_result($sql,16);
          $firmas = trim($row["firmas"]);
          $usua_anu = trim(odbc_result($sql,18));
          $fec_anu = trim(odbc_result($sql,19));
          $ciudad = trim(odbc_result($sql,20));
          $origen = trim(odbc_result($sql,21));
          $query = "INSERT INTO cx_com_ing (ingreso, fecha, usuario, unidad, periodo, ano, tipo, estado, valor, concepto, recurso, rubro, soporte, num_sopo, fec_sopo, transferencia, firmas, usua_anu, fec_anu, ciudad, origen) VALUES ('$ingreso', '$fecha', '$usuario', '$unidad', '$periodo', '$ano', '$tipo', '$estado', '$valor', '$concepto', '$recurso', '$rubro', '$soporte', '$num_sopo', '$fec_sopo', '$transferencia', '$firmas', '$usua_anu', '$fec_anu', '$ciudad', '$origen')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_inf_gir - Tabla Informes de Giro
      $sql = odbc_exec($conexion,"SELECT * from cx_inf_gir ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA INFORMES DE GIRO".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = trim(odbc_result($sql,2));
          $usuario = trim(odbc_result($sql,3));
          $unidad = odbc_result($sql,4);
          $periodo = odbc_result($sql,5);
          $ano = odbc_result($sql,6);
          $unidad1 = odbc_result($sql,7);
          $n_unidad = trim(odbc_result($sql,8));
          $gastos = trim(odbc_result($sql,9));
          if ($gastos == ".00")
          {
            $gastos = "0.00";
          }
          $pagos = trim(odbc_result($sql,10));
          if ($pagos == ".00")
          {
            $pagos = "0.00";
          }
          $total = trim(odbc_result($sql,11));
          if ($total == ".00")
          {
            $total = "0.00";
          }
          $crp = odbc_result($sql,12);
          $cdp = odbc_result($sql,13);
          $recurso = odbc_result($sql,14);
          $rubro = odbc_result($sql,15);
          $concepto = odbc_result($sql,16);
          $cash = trim(odbc_result($sql,17));
          $estado = trim(odbc_result($sql,18));
          $firma = odbc_result($sql,19);
          $query = "INSERT INTO cx_inf_gir (conse, fecha, usuario, unidad, periodo, ano, unidad1, n_unidad, gastos, pagos, total, crp, cdp, recurso, rubro, concepto, cash, estado, firma) VALUES ('$conse', '$fecha', '$usuario', '$unidad', '$periodo', '$ano', '$unidad1', '$n_unidad', '$gastos', '$pagos', '$total', '$crp', '$cdp', '$recurso', '$rubro', '$concepto', '$cash', '$estado', '$firma')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      // Cx_usu_web - Tabla usuarios
      $sql = odbc_exec($conexion,"SELECT * from cx_usu_web ORDER BY conse");
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
        fwrite($file, "-- TABLA USUARIOS".PHP_EOL);
        fclose($file);
        while($i < $row = odbc_fetch_array($sql))
        {
          $conse = odbc_result($sql,1);
          $fecha = odbc_result($sql,2);
          $usuario = trim(odbc_result($sql,3));
          $nombre = trim(odbc_result($sql,4));
          //$clave = "827ccb0eea8a706c4c34a16891f84e7b";  // 12345
          //$clave = "49359485538f10ff4c4907c9f36013fc";  // Cx2019*
          //$clave = "7fddc0dc509b60d31edc7dcc898144c6";  // Cx2021*
          $clave = "d185df5dae4a6d03510c77258845fa6d";    // Cx2021*+
          $permisos = trim($row["permisos"]);
          $conexion = odbc_result($sql,7);
          $estado = odbc_result($sql,8);
          $cambio = odbc_result($sql,9);
          $tipo = odbc_result($sql,10);
          $unidad = odbc_result($sql,11);
          $email = trim(odbc_result($sql,12));
          $admin = odbc_result($sql,13);
          $usu_crea = trim(odbc_result($sql,14));
          $firma = trim(odbc_result($sql,15));
          $ciudad = trim(odbc_result($sql,16));
          $cedula = trim(odbc_result($sql,17));
          $cargo = trim(odbc_result($sql,18));
          $activo = odbc_result($sql,19);
          $query = "INSERT INTO cx_usu_web (conse, fecha, usuario, nombre, clave, permisos, conexion, estado, cambio, tipo, unidad, email, admin, usu_crea, firma, ciudad, cedula, cargo, activo) VALUES ('$conse', '$fecha', '$usuario', '$nombre', '$clave', '$permisos', '$conexion', '$estado', '$cambio', '$tipo', '$unidad', '$email', '$admin', '$usu_crea', '$firma', '$ciudad', '$cedula', '$cargo', '$activo')";
          $file = fopen($carpeta1."\\"."log_cx_gastos.txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
        }
      }
      $salida->salida = "1";
      echo json_encode($salida);
    }
  }
}
?>