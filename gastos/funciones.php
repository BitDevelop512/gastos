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
?>
