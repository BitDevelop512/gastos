<?php
session_start();
ini_set("display_errors", 1);
date_default_timezone_set("America/Bogota");

$fecha = date("d/m/Y");
$hora = date("H:i");

require_once 'Twilio/Twilio/autoload.php';
use Twilio\Rest\Client;

$verifica = time();
$alea = strtoupper(md5($verifica));
$alea = substr($alea,0,5);

$mensaje = "SIGAR - Su codigo de verificacion es: ".$alea." - Fecha: ".$fecha." - Hora: ".$hora;
$mensaje = iconv("UTF-8", "ISO-8859-1", $mensaje);

echo $mensaje."<br>";


$sid    = "AC281186f122d146bb54eab7373fb8a9a4";
$token  = "bfdce370b21909985f224c363117a623";
$twilio = new Client($sid, $token);


$message = $twilio->messages
	->create("+573504809550", // to
  	array(
			"from" => "+19282278603",
			"body" => $mensaje
		)
	);

print($message->sid);
?>