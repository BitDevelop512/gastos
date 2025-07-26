<!doctype html>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
$usuario = $_GET['usuario'];
$query = "SELECT * FROM cx_usu_web WHERE usuario='$usuario'";
$sql = odbc_exec($conexion,$query);
$total = odbc_num_rows($sql);
// Si el usuario existe en la base de datos
if ($total>0)
{
	$con_usuario = odbc_result($sql,1);
  $usu_usuario = trim(odbc_result($sql,3));
  $nom_usuario = trim(utf8_encode(odbc_result($sql,4)));
  $cla_usuario = odbc_result($sql,5);
  $per_usuario = odbc_result($sql,6);
  $cnx_usuario = odbc_result($sql,7);
  $est_usuario = odbc_result($sql,8);
  $cam_usuario = odbc_result($sql,9);
  $tip_usuario = odbc_result($sql,10);
  $uni_usuario = odbc_result($sql,11);
  $ema_usuario = odbc_result($sql,12);
  $adm_usuario = odbc_result($sql,13);
  $ciu_usuario = trim(utf8_encode(odbc_result($sql,16)));
  $ced_usuario = trim(odbc_result($sql,17));
  $car_usuario = trim(utf8_encode(odbc_result($sql,18)));
  $act_usuario = odbc_result($sql,19);
  $ipe_usuario = trim(odbc_result($sql,21));
  $nav_usuario = trim(odbc_result($sql,22));
  $val_usuario = substr(odbc_result($sql,23),0,10);
  $sup_usuario = odbc_result($sql,24);
  $log_usuario = trim(odbc_result($sql,25));
  $actual = date('Y-m-d');
  // Se consultan datos de la unidad asignada al usuario para carga de permisos
  $query1 = "SELECT * FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $sql1 = odbc_exec($conexion,$query1);
  $var_1 = odbc_result($sql1,1);
  $var_2 = odbc_result($sql1,2);
  $sig_usuario = trim(odbc_result($sql1,4));
  $bat_usuario = trim(utf8_encode(odbc_result($sql1,6)));
  $tpu_usuario = odbc_result($sql1,7);
  $tpc_usuario = odbc_result($sql1,8);
  // Nueva sigla
  $sig_usuario1 = trim(odbc_result($sql1,41));
  $bat_usuario1 = trim(utf8_encode(odbc_result($sql1,42)));
  $fec_usuario = trim(odbc_result($sql1,43));
  if ($fec_usuario == "")
  {
  }
  else
  {
    $fec_usuario = str_replace("/", "-", $fec_usuario);
    if ($actual >= $fec_usuario)
    {
      $sig_usuario = $sig_usuario1;
      $bat_usuario = $bat_usuario1;
    }
  }
  $nun_usuario = $var_1;
  $dun_usuario = $var_2;
  // Se consulta la brigada
  $query2 = "SELECT nombre FROM cx_org_dep WHERE dependencia='$var_2'";
  $sql2 = odbc_exec($conexion,$query2);
  $bri_usuario = trim(odbc_result($sql2,1));
  // Se consulta la division
  $query3 = "SELECT nombre FROM cx_org_uni WHERE unidad='$var_1'";
  $sql3 = odbc_exec($conexion,$query3);
  $div_usuario = trim(odbc_result($sql3,1));
  // Se consulta la compañia
  $query4 = "SELECT nombre FROM cx_org_cmp WHERE conse='$tip_usuario'";
  $sql4 = odbc_exec($conexion,$query4);
  $cmp_usuario = trim(utf8_encode(odbc_result($sql4,1)));
  if ($tip_usuario == "0")
  {
    $cmp_usuario = "COMPAÑIA NO SELECCIONADA";
  }
	$_SESSION["con_usuario"] = $con_usuario;
  $_SESSION["usu_usuario"] = $usu_usuario;
	$_SESSION["nom_usuario"] = $nom_usuario;
 	$_SESSION["per_usuario"] = $per_usuario;
 	$_SESSION["tip_usuario"] = $tip_usuario;
 	$_SESSION["uni_usuario"] = $uni_usuario;
  $_SESSION["ema_usuario"] = $ema_usuario;
 	$_SESSION["adm_usuario"] = $adm_usuario;
 	$_SESSION["sig_usuario"] = $sig_usuario;
 	$_SESSION["ciu_usuario"] = $ciu_usuario;
 	$_SESSION["ced_usuario"] = $ced_usuario;
 	$_SESSION["car_usuario"] = $car_usuario;
 	$_SESSION["bat_usuario"] = $bat_usuario;
 	$_SESSION["bri_usuario"] = $bri_usuario;
 	$_SESSION["div_usuario"] = $div_usuario;
 	$_SESSION["tpu_usuario"] = $tpu_usuario;
 	$_SESSION["tpc_usuario"] = $tpc_usuario;
 	$_SESSION["cmp_usuario"] = $cmp_usuario;
 	$_SESSION["nun_usuario"] = $nun_usuario;
  $_SESSION["dun_usuario"] = $dun_usuario;
  $_SESSION["sup_usuario"] = $sup_usuario;
  $_SESSION["log_usuario"] = $log_usuario;
  $_SESSION["autenticado"] = "SI";
  echo "<script>top.window.location.reload();</script>";
}
// 02/08/2023 - Ajuste para inclusión de campo logueo
// 04/08/2023 - Ajuste de cambio de sigla validando la fecha actual
?>