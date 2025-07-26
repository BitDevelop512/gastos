<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $conse = $_POST['conse'];
  $ano = $_POST['ano'];
  $tipo = $_POST['tipo'];
  $tipo1 = trim($_POST['tipo1']);
  $tipo2 = strtolower($tipo1);
  if ($tipo == "1")
  {
    $tipo3 = "EL ".$tipo1;
  }
  else
  {
    $tipo3 = "LA ".$tipo1;
  }
  // Sec consultan las especiales
  $query0 = "SELECT unidad FROM cx_org_sub WHERE especial!='0' ORDER BY unidad";
  $sql0 = odbc_exec($conexion, $query0);
  $numero = "";
  while($i<$row=odbc_fetch_array($sql0))
  {
    $numero .= "'".odbc_result($sql0,1)."',";
  }
  $numero = substr($numero,0,-1);
  $query = "SELECT * FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $sql = odbc_exec($conexion,$query);
  $unidad = odbc_result($sql,1);
  $dependencia = odbc_result($sql,2);
  if ($adm_usuario == "1")
  {
    $valor1 = $conse.",1,".$ano;
    $valor2 = $conse.",2,".$ano;
    $valor3 = $conse.",".$tipo.",".$ano;
    $visualiza = '<button type="button" name="link" id="link" class="btn btn-block btn-primary btn-mensaje1" onclick="link1('.$valor3.');"><font face="Verdana" size="3">Visualizar '.$tipo2.'</font></button>';
    if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
    {
      $nadmin = "2";
      $aprueba = '<button type="button" name="aprueba" id="aprueba" class="btn btn-block btn-primary btn-mensaje" onclick="mensaje1('.$valor1.');"><font face="Verdana" size="3">Aprobar</font></button>';
      $rechaza = '<button type="button" name="rechaza" id="rechaza" class="btn btn-block btn-primary btn-mensaje" onclick="mensaje1('.$valor2.');"><font face="Verdana" size="3">Rechazar</font></button>';
      $query1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND tipo='$tip_usuario' AND admin='$nadmin'";
    }
    else
    {
      $nadmin = "3";
      $aprueba = '';
      $rechaza = '';
      $query1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='$nadmin'";
    }
    $sql1 = odbc_exec($conexion,$query1);
    $usuario1 = trim(odbc_result($sql1,1));
    $unidad1 = $uni_usuario;
  }
  if ($adm_usuario == "3")
  {
    if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
    {
      $nadmin = "27";
    }
    else
    {
      $nadmin = "5";   
    }
    $query1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='$nadmin'";
  	$sql1 = odbc_exec($conexion,$query1);
  	$usuario1 = trim(odbc_result($sql1,1));
    $unidad1 = $uni_usuario;
  }
  if ($adm_usuario == "4")
  {
    $query1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='6'";
    $sql1 = odbc_exec($conexion,$query1);
    $usuario1 = trim(odbc_result($sql1,1));
    $unidad1 = $uni_usuario;
  }
  if ($adm_usuario == "6")
  {
    if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
    {
      $query1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='7'";
    }
    else
    {
      $query1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='6'";
    }
    $sql1 = odbc_exec($conexion,$query1);
    $usuario1 = trim(odbc_result($sql1,1));
    $unidad1 = $uni_usuario;
  }
  if ($adm_usuario == "7")
  {
    $query1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='8'";
    $sql1 = odbc_exec($conexion,$query1);
    $usuario1 = trim(odbc_result($sql1,1));
    $unidad1 = $uni_usuario;
  }
  if ($adm_usuario == "10")
  {
    $valida = "0";
    $valida = strpos($numero, $nun_usuario);
    if ($valida == "0")
    {
      $query1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='11'";
    }
    else
    {
      $query1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='10'";      
    }
    $sql1 = odbc_exec($conexion,$query1);
    $usuario1 = trim(odbc_result($sql1,1));
    $unidad1 = $uni_usuario;
  }
  // Se consulta el comandante
  $query4 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='4'";
  $sql4 = odbc_exec($conexion,$query4);
  $total4 = odbc_num_rows($sql4);
  if ($total4 > 0)
  {
    $usuario2 = trim(odbc_result($sql4,1));
  }
  else
  {
    if (($adm_usuario == "6") or ($adm_usuario == "10"))
    {
      $v1 = explode("_", $usu_usuario);
      $v2 = $v1[1];
      $usuario2 = "CDO_".$v2;
    }
  }
  // Se cambia el estado de la solicitud a pendiente
	$graba2 = "UPDATE cx_pla_inv SET estado='P', usuario1='$usuario2', usuario2='$usuario1', usuario3='$usuario1' WHERE conse='$conse' AND ano='$ano' AND unidad='$uni_usuario'";
	$sql3 = odbc_exec($conexion, $graba2);
	// Se crea notificacion
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
	$consecu = odbc_result($cur1,1);
	$mensaje = "<br>".$tipo3." ".$conse." DE ".$ano." HA SIDO GENERADO(A) POR EL USUARIO ".$usu_usuario.". SE SOLICITA REVISION DEL MISMO.<br>";
  if ($adm_usuario == "1")
  {
    if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
    {   
      $mensaje .= '<table width="100%"><tr><td width="44%">'.$visualiza.'</td><td width="2%">&nbsp;</td><td width="25%">'.$aprueba.'</td><td width="2%">&nbsp;</td><td width="25%">'.$rechaza.'</td><td width="2%">&nbsp;</td></tr></table></br>';
    }
    else
    {
      $mensaje .= '<br><br><table width="100%"><tr><td width="44%">'.$visualiza.'</td><td width="56%">&nbsp;</td></tr></table></br>';
    }
  }
  $mensaje = iconv("UTF-8", "ISO-8859-1", $mensaje);
	$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad1', '$mensaje', 'S', '1')";
	$sql2 = odbc_exec($conexion, $query2);
  $notifica = $usuario1;
	// Se verifica la grabacion de la notificacion
	$query3 = "SELECT conse FROM cx_notifica WHERE conse='$consecu'";
	$cur3 = odbc_exec($conexion, $query3);
	$conse1 = odbc_result($cur3,1);
  // Se graba segunda notificación al usuario que crea el plan / solicitud
  $cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
  $consecu1 = odbc_result($cur2,1);
  $mensaje1 = "<br>".$tipo3." ".$conse." DE ".$ano." HA SIDO ENVIADO(A) AL USUARIO ".$notifica."<br><br>";
  $query5 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usu_usuario', '$uni_usuario', '$mensaje1', 'S', '1')";
  $sql5 = odbc_exec($conexion, $query5);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_noti.txt", "a");
	fwrite($file, $fec_log." # ".$query2." # ".PHP_EOL);
  fwrite($file, $fec_log." # ".$query5." # ".PHP_EOL);
  fwrite($file, $fec_log." # ".PHP_EOL);
	fclose($file);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse1;
  $salida->notifica = $notifica;
	echo json_encode($salida);
}
// 21/03/2024 - Ajuste CDO Brigadas
?>