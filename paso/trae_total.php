<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
require('funciones.php');
if (is_ajax())
{
    $periodo = $_POST['periodo'];
    $ano = $_POST['ano'];
    $pregunta = "SELECT tipo FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
    $sql = odbc_exec($conexion,$pregunta);
    $tipo = odbc_result($sql,1);
    // Si es batallon
    if ($tipo == "8")
    {
    	$pregunta0 = "SELECT tipo FROM cx_usu_web WHERE usuario='$usu_usuario'";
    	$sql0 = odbc_exec($conexion,$pregunta0);
    	$tipo1 = odbc_result($sql0,1);
    	$pregunta1 = "SELECT conse FROM cx_pla_inv WHERE unidad='$uni_usuario' AND compania='$tipo1' AND periodo='$periodo' AND ano='$ano' AND tipo='1' AND estado NOT IN ('X')";
    }
    else
    {
    	$pregunta1 = "SELECT conse FROM cx_pla_inv WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano' AND tipo='1' AND estado NOT IN ('X')";    	
    }
    $sql1 = odbc_exec($conexion,$pregunta1);
    $total = odbc_num_rows($sql1);
    $salida->total = $total;
    echo json_encode($salida);
}
?>