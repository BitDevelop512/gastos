<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
// Se graba salida
$graba = "UPDATE cx_por_act SET est_acti='' WHERE usu_acti='$usu_usuario'";
odbc_exec($conexion, $graba);
$graba1 = "UPDATE cx_usu_web SET activo='0', ip='', navegador='' WHERE conse='$con_usuario' AND usuario='$usu_usuario'";
odbc_exec($conexion, $graba1);
session_start();
session_destroy();
error_reporting(0);
$parametros_cookies=session_get_cookie_params();
setcookie(session_name(),0,1,$parametros_cookies["path"]);
?>
<script>
top.location.href="index.php";
</script>