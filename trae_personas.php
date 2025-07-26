<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $unidad = trim($_POST['unidad']);
    $unidad1 = trim($_POST['unidad1']);
    $unidades = "'".$unidad."','".$unidad1."'";
    $query = "SELECT * FROM cx_usu_web WHERE unidad IN ($unidades) AND conse!='$con_usuario' ORDER BY unidad,conse";
    $sql = odbc_exec($conexion, $query);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    $m = 1;
    $var_con = "";
    $var_usu = "";
    $var_nom = "";
    $var_sig = "";
    while ($m < $row = odbc_fetch_array($sql))
    {
        $conse = $row['conse'];
        $usuario = trim($row['usuario']);
        $nombre = trim(utf8_encode($row['nombre']));
        $unidad2 = $row['unidad'];
        $query1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad2'";
        $sql1 = odbc_exec($conexion, $query1);
        $sigla = trim(utf8_encode(odbc_result($sql1,1)));
        $var_con .= $conse."|";
        $var_usu .= $usuario."|";
        $var_nom .= $nombre."|";
        $var_sig .= $sigla."|";
        $m++;
    }
    $salida->conses = $var_con;
    $salida->usuarios = $var_usu;
    $salida->nombres = $var_nom;
    $salida->siglas = $var_sig;
    echo json_encode($salida);
}
?>