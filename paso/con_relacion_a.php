<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
// Si no es peticion ajax no se ejecuta
if (is_ajax())
{
  $ano = $_POST['ano'];
  $ordop = trim($_POST['valor']);
  $conse = trim($_POST['valor1']);
  $mision = trim($_POST['valor2']);
  $num_valores = explode("-", $mision);
  $num_valores1 = count($num_valores);
  if ($num_valores == "3")
  {
    list($var3, $var4, $var5) = explode("-", $mision);
    $var3 = trim($var3);
  }
  else
  {
    list($var2, $var3, $var4, $var5) = explode("-", $mision);
    $var3 = trim($var2)."-".trim($var3);
  }
  $n_ordop = trim($_POST['valor3']);
  list($var1, $var2) = explode(" ", $n_ordop);
  $var1 = trim($var1);
  $query = "SELECT conse, tipo FROM cx_rel_gas WHERE mision='$var3' AND ordop='$ordop' AND n_ordop='$var1' AND numero='$var5' AND unidad='$uni_usuario' AND usuario='$usu_usuario' AND ano='$ano'";

//    $fec_log = date("d/m/Y H:i:s a");
//    $file = fopen("log_jm2021.txt", "a");
//    fwrite($file, $fec_log." # ".$query." #### ".PHP_EOL);
//    fclose($file);

  $sql = odbc_exec($conexion,$query);
  $total = odbc_num_rows($sql);
  if ($total>0)
  {
    $conse =  odbc_result($sql,1);
    $tipo =  odbc_result($sql,2);
    $salida->salida = $conse;
    $salida->tipo = $tipo;
  }
  else
  {
    $salida->salida = "0";
    $salida->tipo = "0";
  }
  echo json_encode($salida);
}
?>