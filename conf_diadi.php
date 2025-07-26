<?php
require("cx.php");
ini_set("display_errors", 1);
date_default_timezone_set("America/Bogota");
$llave = "sigar";
$servidor = "10.23.246.117";
$base = "gastos";
$usuario = "Cx";
$clave = "teuTmZGjqw==";
$valida = cxlog($clave, $llave);
$driver = "Driver={SQL Server Native Client 11.0};";
$conexion = odbc_connect($driver."Server=$servidor;Database=$base;", $usuario, $valida);
$url = "https://sigar.imi.mil.co/";
$sustituye = array ( "'" => '"', "“" => '"', "”" => '"', 'Â€' => '"', 'Â€' => '"', "Ã¡" => "Á", "Ã©" => 'É', "Ã¬" => "Í", "Ã³" => "Ó", "Ãº" => "Ú", "Ã‘" => "Ñ", "Ã±" => "Ñ", "’" => "´", "–" => "-", "Ã“" => "Ó", "Ã‰" => "É", "Ãš" => "Ú");
$sustituye1 = array ( 'Ã‘' => 'Ñ', 'Ã‰' => 'É', 'Ã' => 'Í', '' => '', '' => '', ''  => '', '' => '', '' => '' );
$ruta_local = "C:\\inetpub\\wwwroot\\Gastos";
$especial = "87,212,300";
$comite = "273,280,290,294";
?>