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
      $pregunta = "checkpoint checkpoint alter database gastos set recovery simple Dbcc shrinkfile (gastos_log, 0, truncateonly) alter database gastos set recovery full";
      if (!odbc_exec($conexion, $pregunta))
      {
        $confirma = "0";
      }
      else
      {
        $confirma = "1";
      }
      $salida->salida = $confirma;
      echo json_encode($salida);
    }
  }
}
?>