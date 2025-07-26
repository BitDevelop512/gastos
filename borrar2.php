<?php
session_start();
error_reporting(0);
require('conf.php');
$ruta = $_POST['ruta'];
$carpeta = $ruta_local."\\fpdf\\pdf\\".$ruta;
if (file_exists($carpeta))
{
	unlink($carpeta);
}
?>