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
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$valor2 = $_POST['valor2'];
	$paso = $_POST['valor3'];
	$ano = $_POST['valor4'];
	// Se registra notificacion
	$query = "SELECT unidad FROM cx_usu_web WHERE usuario='$valor'";
	$cur1 = odbc_exec($conexion, $query);
	$unidad1 = odbc_result($cur1,1);
	// Se consulta el director de la unidad que solicita
	// Departamento - Direccion - Unidad Especial - Fuerza de Despliegue Fudat
    if (($paso == "1") or ($paso == "2")  or ($paso == "3") or ($paso == "6")  or (($paso == "9") and ($uni_usuario == "6")))
    {
		$query0 = "SELECT usuario FROM cx_usu_web WHERE ((usuario LIKE '%DIR_%') OR (usuario LIKE '%CDO_%')) AND unidad='$uni_usuario'";
	}
	// Brigada 7
    if ($paso == "7")
    {
        $v1 = explode("_", $usu_usuario);
        $v2 = $v1[1];
        $v3 = "CDO_".$v2;
		$query0 = "SELECT usuario FROM cx_usu_web WHERE usuario LIKE '%$v3%'";
	}
	// Centro Inteligencia 5
    if ($paso == "5")
    {
		$valida1 = explode("_", $usu_usuario);
		$valida2 = trim($valida1[1]);
        $pregunta1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
        $cur1 = odbc_exec($conexion, $pregunta1);
        $v1 = trim(odbc_result($cur1,1));
        $v2 = $v1."_".$valida2;
		$query0 = "SELECT usuario FROM cx_usu_web WHERE usuario LIKE '%$v2%'";
	}
	// Comando 4 - Batallon 8 - Fuerza 9
    if (($paso == "4") or ($paso == "8") or ($paso == "9"))
    {
        $pregunta1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
        $cur1 = odbc_exec($conexion, $pregunta1);
        $v1 = trim(odbc_result($cur1,1));
        $v2 = "CDO_".$v1;
		$query0 = "SELECT usuario FROM cx_usu_web WHERE usuario LIKE '%$v2%'";
	}
	$cur0 = odbc_exec($conexion, $query0);
	$usuario1 = odbc_result($cur0,1);
	$mensaje = "<br>SE SOLICITA REVISION DE LA SOLICITUD DE RECURSOS CON EL NUMERO ".$valor2." DE ".$ano.". LA SOLICITUD FUE ENVIADA POR: ".$usu_usuario;
	$valor3 = $alea.$valor2;
	$valor4 = encrypt1($valor3, $llave);
	$valor5 = encrypt1($ano, $llave);
	$nom_pdf = "»ver_soli.php?val=".$valor4."&val1=".$valor5."»";
	$mensaje .= '<br><br><button type="button" name="solicita" id="solicita" class="btn btn-block btn-primary btn-mensaje" onclick="mensaje2('.$nom_pdf.');"><font face="Verdana" size="3">Visualizar Solicitud</font></button><br>';
	$mensaje = iconv("UTF-8", "ISO-8859-1", $mensaje);
	// Se graba notificacion
    $query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_notifica)";
	$query1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ($query_c, '$usu_usuario', '$uni_usuario', '$valor', '$unidad1', '$mensaje', 'S', '1')";
	$sql1 = odbc_exec($conexion, $query1);
	// Se graba mensaje para usuario que envia
	$mensaje1 = "<br>SE HA INICIADO TRAMITE SOLICITUD DE RECURSOS CON EL NUMERO ".$valor2." DE ".$ano.". NOTIFICACIÓN ENVIADA A: ".$valor."<br><br>";
	$mensaje1 = iconv("UTF-8", "ISO-8859-1", $mensaje1);
	$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ($query_c, '$usu_usuario', '$uni_usuario', '$usu_usuario', '$uni_usuario', '$mensaje1', 'S', '1')";
	$sql2 = odbc_exec($conexion, $query2);

	$v1 = explode("_", $usu_usuario);
	$v2 = $v1[0];
	if (($v2 == "RIN") or ($v2 == "SAT"))
	{
		$usuario1 = $valor;
	}
	$graba = "UPDATE cx_pla_inv SET estado='P', usuario1='$usuario1', usuario2='$valor' WHERE conse='$valor2' AND ano='$ano' AND unidad!='999'";
	$sql2 = odbc_exec($conexion, $graba);
	// Se verifica estado de grabacion
	$query2 = "SELECT estado FROM cx_pla_inv WHERE conse='$valor2' AND ano='$ano'";
	$cur2 = odbc_exec($conexion, $query2);
	$estado = odbc_result($cur2,1);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $estado;
	echo json_encode($salida);
}
?>