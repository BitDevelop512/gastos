<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  	$verifica = time();
  	$alea = strtoupper(md5($verifica));
  	$alea = substr($alea,0,5);
	$conse = $_POST['conse'];
	$ano = $_POST['ano'];
	$usuario1 = "STE_DIADI";
	// Se registra notificacion
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
	$consecu = odbc_result($cur,1);
	$query = "SELECT unidad FROM cx_usu_web WHERE usuario='$usuario1'";
	$cur1 = odbc_exec($conexion, $query);
	$unidad1 = odbc_result($cur1,1);
	$mensaje = "<br>SE REQUIERE LA ASIGNACION DE RECURSOS PARA LA SOLICITUD CON EL NUMERO ".$conse." DE ".$ano;
	$valor = $alea.$conse;
	$valor1 = encrypt1($valor, $llave);
	$valor2 = encrypt1($ano, $llave);
	$nom_pdf = "»ver_soli.php?val=".$valor1."&val1=".$valor2."»";
	$nom_pdf1 = '<br><br><button type="button" name="solicita" id="solicita" class="btn btn-block btn-primary" onclick="mensaje2('.$nom_pdf.');"><font face="Verdana" size="3">Visualizar Solicitud</font></button><br>';
	$mensaje .= $nom_pdf1;
	$mensaje = iconv("UTF-8", "ISO-8859-1", $mensaje);
	// Se graba notificacion
	$query1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad1', '$mensaje', 'S', '1')";
	$sql1 = odbc_exec($conexion, $query1);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = "S";
	echo json_encode($salida);
}
?>