<?php
session_start();
error_reporting(0);
$imagen = $_POST['imagen'];
$cedula = $_POST['cedula'];
$data = base64_decode($imagen);
$file = './tmp/'.$cedula.'.png';
$success = file_put_contents($file, $data);
?>