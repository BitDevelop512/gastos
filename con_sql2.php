<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if ($_SESSION["autenticado"] = "SI")
{
  if (is_ajax())
  {
    if ($sup_usuario == "1")
    {
      $soporte = $_POST['soporte'];
      $tabla = $_POST['tabla'];
      $tipo = $_POST['tipo'];
      $tipo1 = $_POST['tipo1'];
      $unidad = $_POST['unidad'];
      $numero = $_POST['numero'];
      $ano = $_POST['ano'];
      $texto = trim($_POST['texto']);
      if ($soporte == "1")
      {
        // Relación de Gastos
        if ($tabla == "1")
        {
          $sql = odbc_exec($conexion,"SELECT conse, usuario, unidad, periodo, ano, consecu FROM cx_rel_gas WHERE ciudad='' ORDER BY conse");
          $total = odbc_num_rows($sql);
          if ($total > 0)
          {
            while($i < $row = odbc_fetch_array($sql))
            {
              $conse = odbc_result($sql,1);
              $usuario = trim(odbc_result($sql,2));
              $unidad = odbc_result($sql,3);
              $periodo = odbc_result($sql,4);
              $ano = odbc_result($sql,5);
              $consecu = odbc_result($sql,6);
              $sql1 = odbc_exec($conexion,"SELECT ciudad FROM cx_usu_web WHERE usuario='$usuario'");
              $ciudad = trim(utf8_encode(odbc_result($sql1,1)));
              $ciudad = strtr(trim($ciudad), $sustituye);
              $ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
              $graba = "UPDATE cx_rel_gas SET ciudad='$ciudad' WHERE conse='$conse' AND usuario='$usuario' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano' AND consecu='$consecu' AND ciudad=''";
              odbc_exec($conexion, $graba);
              // Se graba log
              $fec_log = date("d/m/Y H:i:s a");
              $file = fopen("log_sop_ciu.txt", "a");
              fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
              fclose($file);
            }
          }
        }
        // Informe Ejecutivo
        if ($tabla == "2")
        {
          $sql = odbc_exec($conexion,"SELECT conse, usuario, unidad, ano, numero, consecu FROM cx_inf_eje WHERE ciudad='' ORDER BY conse");
          $total = odbc_num_rows($sql);
          if ($total > 0)
          {
            while($i < $row = odbc_fetch_array($sql))
            {
              $conse = odbc_result($sql,1);
              $usuario = trim(odbc_result($sql,2));
              $unidad = odbc_result($sql,3);
              $ano = odbc_result($sql,4);
              $numero = odbc_result($sql,5);
              $consecu = odbc_result($sql,6);
              $sql1 = odbc_exec($conexion,"SELECT ciudad FROM cx_usu_web WHERE usuario='$usuario'");
              $ciudad = trim(utf8_encode(odbc_result($sql1,1)));
              $ciudad = strtr(trim($ciudad), $sustituye);
              $ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
              $graba = "UPDATE cx_inf_eje SET ciudad='$ciudad' WHERE conse='$conse' AND usuario='$usuario' AND unidad='$unidad' AND ano='$ano' AND numero='$numero' AND consecu='$consecu' AND ciudad=''";
              odbc_exec($conexion, $graba);
              // Se graba log
              $fec_log = date("d/m/Y H:i:s a");
              $file = fopen("log_sop_ciu.txt", "a");
              fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
              fclose($file);
            }
          }
        }
      }
      if (($soporte == "2") or ($soporte == "3"))
      {
        if ($tipo == "1")
        {
          $tabla = "cx_com_ing";
          $campo1 = "ingreso";
        }
        if ($tipo == "2")
        {
          $tabla = "cx_com_egr";
          $campo1 = "egreso";
        }
        if ($tipo == "3")
        {
          $tabla = "cx_act_inf";
          $campo1 = "conse";
        }
        if ($tipo == "4")
        {
          $tabla = "cx_sol_aut";
          $campo1 = "conse";
        }
        if ($tipo == "5")
        {
          $tabla = "cx_rec_aut";
          $campo1 = "conse";
        }
        if ($tipo == "6")
        {
          $tabla = "cx_act_reg";
          $campo1 = "conse";
        }
        if ($tipo == "7")
        {
          $tabla = "cx_act_cen";
          $campo1 = "conse";
        }
        if ($tipo == "8")
        {
          $tabla = "cx_act_rec";
          $campo1 = "conse";
        }
        if ($tipo1 == "1")
        {
          $campo = "datos";
        }
        else
        {
          $campo = "firmas";
        }
        if ($soporte == "2")
        {
          $pregunta = "SELECT ".$campo." FROM ".$tabla." WHERE unidad='$unidad' AND ".$campo1."='$numero' AND ano='$ano'";
          $sql = odbc_exec($conexion, $pregunta);
          $datos = trim(odbc_result($sql,1));
          $datos1 = decrypt1($datos, $llave);
          $datos1 = trim(utf8_encode($datos1));
        }
        else
        {
          $datos = $texto;
          if ($tipo1 == "2")
          {
            $datos = iconv("UTF-8", "ISO-8859-1", $datos);
          }
          $datos1 = encrypt1($datos, $llave);
          $pregunta = "UPDATE ".$tabla." SET ".$campo."='".$datos1."' WHERE unidad='$unidad' AND ".$campo1."='$numero' AND ano='$ano'";
          if (!odbc_exec($conexion, $pregunta))
          {
            $confirma = "0";
          }
          else
          {
            $confirma = "1";
          }
        }
        // Se graba log
        $fec_log = date("d/m/Y H:i:s a");
        $file = fopen("log_sop_act.txt", "a");
        fwrite($file, $fec_log." # ".$pregunta." # ".PHP_EOL);
        fwrite($file, $fec_log." # ".$datos." # ".PHP_EOL);
        fwrite($file, $fec_log." # ".$datos1." # ".PHP_EOL);
        fwrite($file, $fec_log." ".PHP_EOL);
        fclose($file);
      }
      if ($soporte == "1")
      {
        $salida->salida = "1";
      }
      else
      {
        if ($soporte == "2")
        {
          $salida->salida = $datos1;
        }
        else
        {
          $salida->salida = $confirma;
        }
      }
      echo json_encode($salida);
    }
  }
}
?>