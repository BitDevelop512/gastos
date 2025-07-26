<?php
date_default_timezone_set("America/Bogota");
$llave = "sigar";
$servidor = "10.23.246.115";
$base = "gastos";
$usuario = "Cx1";
$clave = "Cx*2024";
//$conexion = odbc_connect("Driver={SQL Server Native Client 11.0};Server=$servidor;Database=$base;",$usuario,$clave);
$conexion = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$servidor;Database=$base;",$usuario,$clave);
$sustituye = array ( "'" => '"', "“" => '"', "”" => '"', 'Â€' => '"', 'Â€' => '"', "Ã¡" => "Á", "Ã©" => 'É', "Ã­" => "Í", "Ã³" => "Ó", "Â°" => "o", "Ãº" => "Ú", "Ã‘" => "Ñ", "Ã±" => "Ñ", "’" => "´", "–" => "-", "Ã“" => "Ó", "Ã‰" => "É", "Ãš" => "Ú");
$sustituye1 = array ( 'Ã‘' => 'Ñ', 'Ã‰' => 'É', 'Ã' => 'Í', '' => '', '' => '', ''  => '', '' => '', '' => '' );
$url = "http://10.23.246.115/gastos/";
$url1 = "http://10.23.246.115/gastos/";
$ruta_local = "C:\\inetpub\\wwwroot\\gastos";
$especial = "87,116,212,300";
$comite = "273,280,290,294";
$cargar = "1";
?>
