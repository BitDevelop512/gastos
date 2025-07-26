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
  $num_conses = explode("|", $conse);
  $num_conses1 = count($num_conses);
  $mision = trim($_POST['valor2']);
  $num_misiones = explode("|", $mision);
  $num_misiones1 = count($num_misiones);
  $conse = trim($num_conses[0]);
  $mision = trim($num_misiones[0]);
  $num_valores = explode("¬", $mision);
  $num_valores1 = count($num_valores);
  if ($num_valores1 == "3")
  {
    list($var3, $var4, $var5) = explode("¬", $mision);
    $var3 = trim($var3);
  }
  else
  {
    list($var2, $var3, $var4, $var5) = explode("¬", $mision);
    $var3 = trim($var2)."-".trim($var3);
  }
  $var4 = trim($var4);
  $var5 = trim($var5);
  $n_ordop = trim($_POST['valor3']);
  list($var1, $var2) = explode(" ", $n_ordop);
  $var1 = trim($var1);
  if ($var1 == "«")
  {
    $var1 = "";
  }
  $var1 = str_replace("«", "", $var1);
  $query = "SELECT conse, tipo FROM cx_rel_gas WHERE mision='$var3' AND ordop='$ordop' AND n_ordop='$var1' AND numero='$var5' AND consecu='$var4' AND unidad='$uni_usuario' AND usuario='$usu_usuario' AND ano='$ano'";
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