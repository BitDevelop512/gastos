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
  $pregunta = "SELECT alea, concepto, estado, conse, ano, usuario, unidad, solucion, contacto, telefono FROM cx_pqr_reg WHERE conse='$conse' AND ano='$ano' AND unidad='$unidad'";
  $sql = odbc_exec($conexion,$pregunta);
  $repositorio = trim(odbc_result($sql,1));
  $concepto = trim(utf8_encode(odbc_result($sql,2)));
  $estado = trim(odbc_result($sql,3));
  $conse = odbc_result($sql,4);
  $ano = odbc_result($sql,5);
  $usuario = trim(odbc_result($sql,6));
  $unidad = odbc_result($sql,7);
  $solucion = trim(utf8_encode(odbc_result($sql,8)));
  $contacto = trim(utf8_encode(odbc_result($sql,9)));
  $telefono = trim(odbc_result($sql,10));
  $salida = new stdClass();
  $salida->repositorio = $repositorio;
  $salida->concepto = $concepto;
  $salida->estado = $estado;
  $salida->conse = $conse;
  $salida->ano = $ano;
  $salida->usuario = $usuario;
  $salida->unidad = $unidad;
  $salida->solucion = $solucion;
  $salida->contacto = $contacto;
  $salida->telefono = $telefono;
  echo json_encode($salida);
}
?>