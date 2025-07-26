<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
ini_set('memory_limit', '10240M');
ini_set('max_execution_time', 3600);
if ($_SESSION["autenticado"] = "SI")
{
  if (is_ajax())
  {
    if ($sup_usuario == "1")
    {
      $tabla = $_POST['tabla'];
      $top = $_POST['top'];
      $where = trim($_POST['where']);
      if ($where == "")
      {
        $where = "1=1";
      }
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
      unlink($carpeta1."\\"."log_".$tabla.".txt");
      $pregunta = "SELECT TOP 1 NAME FROM syscolumns WHERE id=object_id('".$tabla."') ORDER BY colorder";
      $cur = odbc_exec($conexion, $pregunta);
      $campo = odbc_result($cur,1);

      $pregunta1 = "SELECT NAME FROM syscolumns WHERE id=object_id('".$tabla."') ORDER BY colorder";
      $cur1 = odbc_exec($conexion, $pregunta1);
      $campos2 = odbc_num_rows($cur1);
      $campos = "";
      $campos1 = "";
      while($i < $row = odbc_fetch_array($cur1))
      {
        $campos .= odbc_result($cur1,1).", ";
        $campos1 .= odbc_result($cur1,1)."|";
      }
      $campos = substr($campos,0,-2);
      $campos1 = substr($campos1,0,-1);
      $campos3 = explode("|",$campos1);
      $pregunta2 = "SELECT TOP ".$top." * FROM ".$tabla." WHERE ".$where." ORDER BY ".$campo." DESC";
      // Se graba log
      $fec_log = date("d/m/Y H:i:s a");
      $file = fopen("log_sql3.txt", "a");
      fwrite($file, $fec_log." # ".$pregunta2." # ".PHP_EOL);
      fclose($file);
      $sql = odbc_exec($conexion, $pregunta2);
      $total = odbc_num_rows($sql);
      if ($total > 0)
      {
        $i = 0;
        $valores = "";
        while($i < $row = odbc_fetch_array($sql))
        {
          $valores = "";
          for ($j=0;$j<count($campos3);++$j)
          {
            $valor = $campos3[$j];
            $valores .= "'".trim(utf8_encode($row[$valor]))."', ";
          }
          $valores = substr($valores,0,-2);
          $query = "INSERT INTO ".$tabla. "(".$campos.") VALUES (".$valores.")";
          $file = fopen($carpeta1."\\"."log_".$tabla.".txt", "a");
          fwrite($file, $query.PHP_EOL);
          fclose($file);
          $i++;
        }
      }
      $salida->salida = "1";
      echo json_encode($salida);
    }
  }
}
?>