<!doctype html>
<?php
session_start();
error_reporting(0);
$conse = $_POST['conse'];
$login = $_POST['login'];
$nombre = $_POST['nombre'];
$contrasena = $_POST['contrasena'];
$permisos = $_POST['permisos'];
$tipo = $_POST['tipo'];
$cambio = $_POST['cambio'];
$unidad = $_POST['unidad'];
$email = $_POST['email'];
$admin = $_POST['admin'];
$sigla = $_POST['sigla'];
$ciudad = $_POST['ciudad'];
$cedula = $_POST['cedula'];
$cargo = $_POST['cargo'];
$batallon = $_POST['batallon'];
$brigada = $_POST['brigada'];
$division = $_POST['division'];
$tipou = $_POST['tipou'];
$tipoc = $_POST['tipoc'];
$compania = $_POST['compania'];
$nunidad = $_POST['nunidad'];
$dunidad = $_POST['dunidad'];
$super = $_POST['super'];
$login1 = $_POST['login1'];
//$num_permiso = explode("||||",$permisos);
//for ($i=0;$i<count($num_permiso);++$i)
//{
//  $per[$i] = $num_permiso[$i];
//}
$valida = intval($conse);
if ($valida > 0)
{
  $_SESSION["con_usuario"] = $conse;
  $_SESSION["usu_usuario"] = $login;
  $_SESSION["nom_usuario"] = $nombre;
  $_SESSION["cla_usuario"] = $contrasena;
  $_SESSION["per_usuario"] = $permisos;
  $_SESSION["tip_usuario"] = $tipo;
  $_SESSION["cam_usuario"] = $cambio;
  $_SESSION["uni_usuario"] = $unidad;
  $_SESSION["ema_usuario"] = $email;
  $_SESSION["adm_usuario"] = $admin;
  $_SESSION["sig_usuario"] = $sigla;
  $_SESSION["ciu_usuario"] = $ciudad;
  $_SESSION["ced_usuario"] = $cedula;
  $_SESSION["car_usuario"] = $cargo;
  $_SESSION["bat_usuario"] = $batallon;
  $_SESSION["bri_usuario"] = $brigada;
  $_SESSION["div_usuario"] = $division;
  $_SESSION["tpu_usuario"] = $tipou;
  $_SESSION["tpc_usuario"] = $tipoc;
  $_SESSION["cmp_usuario"] = $compania;
  $_SESSION["nun_usuario"] = $nunidad;
  $_SESSION["dun_usuario"] = $dunidad;
  $_SESSION["sup_usuario"] = $super;
  $_SESSION["log_usuario"] = $login1;
  $_SESSION["ipe_usuario"] = trim($_SERVER["REMOTE_ADDR"]);
  $_SESSION["nav_usuario"] = trim($_SERVER["HTTP_USER_AGENT"]);
  $_SESSION["autenticado"] = "SI";
  $_SESSION["chat"] = "SI";
  $_SESSION["time"] = time();
  if ($cambio == "1")
  {
    header("location:cambio.php?tipo=$tipo&mensaje=0");
  }
  else
  {
    if (($tipo == "0") or ($admin == "0"))
    {
      header("location:usu_compania.php");
    }
    else
    {
      header("location:principal.php");
    }
  }
}
?>