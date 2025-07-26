<?php
header('Content-Type: application/json');
session_start();
include('conf.php');
include('consultaclass1.php');
$obj = new ConsultaClass($conexion, $_POST);
echo json_encode($obj->salida);
?>