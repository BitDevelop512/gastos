<?php
header('Content-Type: application/json');
session_start();
include('conf.php');
include('revi_plan_class.php');
$obj = new ConsultaClass($conexion, $_POST);
echo json_encode($obj->salida);
?>