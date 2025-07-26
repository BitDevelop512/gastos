<?php



echo "<br>";

//$url = 'http://190.146.23.188:8086/Gastos/firma.php';
//$img = './dll/flower.gif';
//file_put_contents($img, file_get_contents($url));

//$ch = curl_init('http://190.146.23.188:8086/Gastos/firma.php');
//$ch = curl_init('http://190.146.23.188:8085/Soporte/titulo.php');
//$fp = fopen('./dll/flower.jpg', 'wb');
//curl_setopt($ch, CURLOPT_FILE, $fp);
//curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_exec($ch);
//curl_close($ch);
//fclose($fp);

session_start();
error_reporting(0);
require('conf.php');

$gra_fir = "select permisos from cx_usu_web where usuario = 'JSPEREZ'";
//$gra_fir = "update cx_usu_web set permisos = 'G|02/G|03/G|04/' where usuario = 'JSPEREZ'";
$cur = odbc_exec($conexion,$gra_fir);
$per = odbc_result($cur,1);
echo $per;


?>