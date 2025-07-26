<?php
session_start();
error_reporting(0);
header('Access-Control-Allow-Origin: *');
require('conf.php');
require('funciones.php');
$verifica = time();
$codigo = strtoupper(md5($verifica));
$codigo = substr($codigo,0,5);
$ano = date('Y');
$ano = trim($ano);
$mes = date('m');
$mes = trim($mes);
$dia = date('d');
$dia = trim($dia);
$archivo = "Firmas_".$ano.$mes.$dia."_".$codigo.".txt";
$handler = fopen($archivo,"a");
$sql = odbc_exec($conexion,"SELECT ide_user, fir_user, fim_user, usu_user FROM cx_gas_fir WHERE aut_user='1' ORDER BY ide_user");
$total = odbc_num_rows($sql);
if ($total > 0)
{
  while($i < $row = odbc_fetch_array($sql))
  {
    $conse = odbc_result($sql,1);
    $firma1 = trim($row["fir_user"]);
    $firma2 = trim($row["fim_user"]);
    $usuario = trim(odbc_result($sql,4));
    $query = "UPDATE cx_usu_web SET imagen='$firma1', firma='$firma2' WHERE conse='$conse' AND usuario='$usuario'"."\r\n\r\n";
    fwrite($handler,$query);
  }
}
header("Content-Type: application/force-download");
header("Content-Disposition: attachment;filename=".$archivo);
header("Content-Transfer-Encoding: binary");
include($archivo);
?>