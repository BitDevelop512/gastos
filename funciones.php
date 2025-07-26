<?php
function is_ajax()
{
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
function stringArray($array)
{
  $arr_var1 = array();
  $str_cadena = "";
  if (!empty($array))
  {
    $arr_var1 = $array;
    foreach ($arr_var1 as $var1)
    {
      $str_cadena.= "'".$var1."',";
    }
    $str_cadena = substr($str_cadena, 0, -1);
    $salida = $str_cadena;
  }
  else
  {
    $salida = $str_cadena;
  }
  return str_replace(";", " ", $salida);
}
function stringArray1($array)
{
  $arr_var1 = array();
  $str_cadena = "";
  if (!empty($array))
  {
    $arr_var1 = $array;
    foreach ($arr_var1 as $var1)
    {
      $str_cadena.= $var1.",";
    }
    $str_cadena = substr($str_cadena, 0, -1);
    $salida = $str_cadena;
  }
  else
  {
    $salida = $str_cadena;
  }
  return str_replace(";", " ", $salida);
}
function Decrypt($s)
{
  global $rijnKey, $rijnIV;
  $rijnKey = "\x8\x16\x10\x1\x14\x5\x9\x12\x3\x15\x2\x6\x4\x13\x7\x11";
  $rijnIV = "\x2\x8\x15\x4\x11\x9\x5\x13\x1\x10\x7\x16\x3\x12\x6\x14";
  if ($s == "")
  {
    return $s;
  }
  try
  {
    $s = str_replace("Cx#x", "+", $s);
    $s = base64_decode($s);
    $s = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $rijnKey, $s, MCRYPT_MODE_CBC, $rijnIV);
  }
  catch(Exception $e)
  {
  }
  return $s;
}
function Encrypt($s)
{
  global $rijnKey, $rijnIV;
  $rijnKey = "\x8\x16\x10\x1\x14\x5\x9\x12\x3\x15\x2\x6\x4\x13\x7\x11";
  $rijnIV = "\x2\x8\x15\x4\x11\x9\x5\x13\x1\x10\x7\x16\x3\x12\x6\x14";
  $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
  $pad = $block - (strlen($s) % $block);
  $s .= str_repeat(chr($pad), $pad);
  $s = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $rijnKey, $s, MCRYPT_MODE_CBC, $rijnIV);
  $s = base64_encode($s);
  $s = str_replace("+", "Cx#x", $s);
  return $s;
}
function encrypt1($string, $key)
{
  $result = '';
  for($i=0; $i<strlen($string); $i++)
  {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)+ord($keychar));
    $result.=$char;
  }
  return base64_encode($result);
}
function decrypt1($string, $key)
{
  $result = '';
  $string = base64_decode($string);
  for($i=0; $i<strlen($string); $i++)
  {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result.=$char;
  }
  return $result;
}
function wims_currency($number)
{ 
  if ($number < 0)
  {
    $print_number = "($ " . str_replace('-', '', number_format ($number, 2, ".", ",")) . ")"; 
  }
  else
  { 
    $print_number = "$ " .  number_format ($number, 2, ".", ",") ; 
  } 
  return $print_number; 
}
function convertir_a_numero($str)
{
  $legalChars = "%[^0-9\\-\\. ]%";
  $str = preg_replace($legalChars,"",$str);
  return $str;
}
function Salto_pagina()
{
	$actual = $pdf->GetY()+5;
	if ($actual>=259.00125) $pdf->addpage();
}
function days_in_month($month, $year) 
{ 
  // Calcula el número de días del mes 
  // $month: número del mes (enteros del 1 al 2)
  // $year: año nu,mérico (any entero) 
  return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
}
function nombre_mes($mes)
{
  switch ($mes)
  {
    case '1':
      $n_mes = "ENERO";
      break;
    case '2':
      $n_mes = "FEBRERO";
      break;
    case '3':
      $n_mes = "MARZO";
      break;
    case '4':
      $n_mes = "ABRIL";
      break;
    case '5':
      $n_mes = "MAYO";
      break;
    case '6':
      $n_mes = "JUNIO";
      break;
    case '7':
      $n_mes = "JULIO";
      break;
    case '8':
      $n_mes = "AGOSTO";
      break;
    case '9':
      $n_mes = "SEPTIEMBRE";
      break;
    case '10':
      $n_mes = "OCTUBRE";
      break;
    case '11':
      $n_mes = "NOVIEMBRE";
      break;
    case '12':
      $n_mes = "DICIEMBRE";
      break;
    default:
      $n_mes = "";
      break;
  }
  return $n_mes; 
}
function getBrowser($user_agent)
{
  if(strpos($user_agent, "MSIE") !== FALSE)
    return "IE8";
  elseif(strpos($user_agent, "Trident") !== FALSE)
    return "IE11";
  elseif(strpos($user_agent, "Firefox") !== FALSE)
    return "Firefox";
  elseif(strpos($user_agent, "Chrome") !== FALSE)
    return "Chrome";
  elseif(strpos($user_agent, "Opera Mini") !== FALSE)
    return "Opera";
  elseif(strpos($user_agent, "Opera") !== FALSE)
    return "Opera";
  elseif(strpos($user_agent, "Safari") !== FALSE)
    return "Safari";
  else
    return 'N/A';
}
function getDiasHabiles($fechainicio, $fechafin)
{
  $fechainicio = strtotime($fechainicio);
  $fechafin = strtotime($fechafin);
  $diainc = 24*60*60;
  $diasferiados = array('2021-01-01', '2021-01-11', '2021-03-22', '2021-04-01', '2021-04-02', '2021-05-01', '2021-05-17', '2021-06-07', '2021-06-14', '2021-07-05', '2021-07-20', '2021-08-07', '2021-08-16', '2021-10-18', '2021-11-01', '2021-11-15', '2021-12-08', '2021-12-25', '2022-01-01', '2022-01-10', '2022-03-21', '2022-04-14', '2022-04-15', '2022-05-01', '2022-05-30', '2022-06-20', '2022-06-27', '2022-07-04', '2022-07-20', '2022-08-07', '2022-08-15', '2022-10-17', '2022-11-07', '2022-11-14', '2022-12-08', '2022-12-25', '2023-01-01', '2023-01-09', '2023-03-20', '2023-04-06', '2023-04-07', '2023-05-01', '2023-05-22', '2023-06-12', '2023-06-19', '2023-07-03', '2023-07-20', '2023-08-07', '2023-08-21', '2023-10-16', '2023-11-06', '2023-11-13', '2023-12-08', '2023-12-25', '2024-01-01', '2024-01-08', '2024-03-25', '2024-03-28', '2024-03-29', '2024-05-01', '2024-05-13', '2024-06-03', '2024-06-10', '2024-07-01', '2024-07-20', '2024-08-07', '2024-08-19', '2024-10-14', '2024-11-04', '2024-11-11', '2024-12-08', '2024-12-25', '2025-01-01', '2025-01-06', '2025-03-24', '2025-04-17', '2025-04-18', '2025-05-01', '2025-06-02', '2025-06-23', '2025-06-30', '2025-07-20', '2025-08-07', '2025-08-18', '2025-10-13', '2025-11-03', '2025-11-17', '2025-12-08', '2025-12-25', '2026-01-01', '2026-01-12', '2026-03-23', '2026-04-02', '2026-04-03', '2026-05-01', '2026-05-18', '2026-06-08', '2026-06-15', '2026-06-29', '2026-07-20', '2026-08-07', '2026-08-17', '2026-10-12', '2026-11-02', '2026-11-16', '2026-12-08', '2026-12-25');
  $diashabiles = array();
  for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc)
  {
    if (!in_array(date('N', $midia), array(6,7)))
    {
      if (!in_array(date('Y-m-d', $midia), $diasferiados))
      {
        array_push($diashabiles, date('Y-m-d', $midia));
      }
    }
  }
  return $diashabiles;
}
function restarfechas($fecha1, $fecha2)
{
  $horaini = $fecha1;
  $horafin = $fecha2;
  $f1 = strtotime($horafin)-strtotime($horaini);
  $f2 = intval($f1/60/60/24);
  $horai = substr($horaini,11,2);
  $mini = substr($horaini,14,2);
  $segi = substr($horaini,17,2);
  $horaf = substr($horafin,11,2);
  $minf = substr($horafin,14,2);
  $segf = substr($horafin,17,2);
  $ini = ((($horai*60)*60)+($mini*60)+$segi);
  $fin = ((($horaf*60)*60)+($minf*60)+$segf);
  $dif = $fin-$ini;
  $difh = floor($dif/3600);
  $difm = floor(($dif-($difh*3600))/60);
  $difs = $dif-($difm*60)-($difh*3600);
  $resta = $f2." d&iacute;a(s) y ".date("H:i:s",mktime($difh,$difm,$difs));
  return $resta;
}
?>
