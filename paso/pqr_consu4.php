<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $conse = $_POST['conse'];
  $ano = $_POST['ano'];
  $unidad = $_POST['unidad'];
  $pregunta = "SELECT fecha, usuario, usuario1 FROM cx_pqr_usu WHERE solicitud='$conse' AND ano='$ano' ORDER BY fecha";
  $sql = odbc_exec($conexion,$pregunta);
  $total = odbc_num_rows($sql);
  $salida = new stdClass();
  $valores = "";
  if ($total>0)
  {
    $i = 0;
    while ($i < $row = odbc_fetch_array($sql))
    {
      $envia = $row['usuario'];
      $recibe = $row['usuario1'];
      if ($i == "0")
      {
        $fecha = substr($row['fecha'],0,19);
        $fecha1 = $fecha;
        $tiempo = "";
      }
      else
      {
        if ($i > 1)
        {
          $fecha1 = $fecha;
        }
        $fecha = substr($row['fecha'],0,19);
        $horaini = $fecha1;
        $horafin = $fecha;
        $f1 = strtotime($horafin)-strtotime($horaini);
        $f2 = intval($f1/60/60/24);
        $horai = substr($horaini,11,2);
        $mini = substr($horaini,14,2);
        $segi = substr($horaini,17,2);
        $horaf = substr($horafin,11,2);
        $minf = substr($horafin,14,2);
        $segf = substr($horafin,17,2);
        $ini = ((($horai*60)*60)+($mini*60)+$segi);
        $fin = ((($horaf*60)*60)+($minf*60)+$segf);
        $dif = $fin-$ini;
        $difh = floor($dif/3600);
        $difm = floor(($dif-($difh*3600))/60);
        $difs = $dif-($difm*60)-($difh*3600);
        //$tiempo = $fecha1." - ".$fecha;
        $tiempo = $f2." d&iacute;a(s) y ".date("H:i:s",mktime($difh,$difm,$difs));
      }
      $valores .= $fecha."|".$envia."|".$recibe."|".$tiempo."|#";
      $i++;
    }
  }
  $salida->valores = $valores;
  echo json_encode($salida);
}
?>