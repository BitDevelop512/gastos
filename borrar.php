<?php
session_start();
error_reporting(0);
$carpeta = $_POST['carpeta'];
$archivo = $_POST['archivo'];
$archivo = trim($carpeta)."\\".trim($archivo);
if (file_exists($archivo))
{
	unlink($archivo);
}
?>