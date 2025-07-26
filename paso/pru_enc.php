<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');

//$valor = "tLS8tKqn75qXjaOlnpORoqOXl5GV";
//$valor = "tLS8tKqn75qajaWlmZOaoqOXl5E=";
//$valor = "tLS8rKSm752Tl6WolZeRoqGZl4Q=";
//$valor = "tLS8tKqk75uTlKaslZeRoqGZl4Q=";
$valor = "tLS8tKqk76KTlqeklZ6RoqGZl4Q=";
$datos = trim(decrypt1($valor, $llave));

echo $datos."<hr>";


$valor1 = "BASMI2|9,551,700.00#";
$datos1 = encrypt1($valor1, $llave);
echo $datos1;



?>