<?php
session_start();
error_reporting(0);
require('conf.php');
$ano = $_POST['ano'];
$archivo = $_POST['archivo'];
$carpeta = $ruta_local."\\fpdf\\pdf\\".$ano;
$archivo = trim($carpeta)."\\".trim($archivo);
if (file_exists($archivo))
{
	unlink($archivo);
}
?>