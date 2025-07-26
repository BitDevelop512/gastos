<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$vigencia = $_POST['vigencia'];
	$recurso = $_POST['recurso'];
	$query = "SELECT * FROM cv_cdp4 WHERE EXISTS(SELECT * FROM cx_cdp WHERE conse=cv_cdp4.conse AND cx_cdp.vigencia='$vigencia' AND cx_cdp.recurso='$recurso') ORDER BY recurso, conse, numero";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	$salida1 = "<table width='100%' align='center' border='1'><tr><td width='5%' height='35' bgcolor='#ddebf7'><center><b>Vigencia</b></center></td><td width='8%' height='35' bgcolor='#ddebf7'><center><b>Fecha</b></center></td><td width='7%' height='35' bgcolor='#ddebf7'><center><b>Recurso</b></td><td width='5%' height='35' bgcolor='#ddebf7'><center><b>N&uacute;mero</b></center></td><td width='20%' height='35' bgcolor='#ddebf7'><center><b>Destino</b></center></td><td width='15%' height='35' bgcolor='#ddebf7'><center><b>Valor</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Adiciones</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Reducciones</b></center></td><td width='15%' height='35' bgcolor='#ddebf7'><center><b>Saldo x Comprometer</b></center></td><td width='5%' height='35' bgcolor='#ddebf7'><center>&nbsp</center></td></tr>";
	$valores = "";
	$i = 0;
	$valida = 0;
	$valida1 = 0;
	$valor2 = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$conse = odbc_result($cur,1);
		$numero = odbc_result($cur,2);
		$query1 = "SELECT vigencia, fecha1, recurso, destino FROM cx_cdp WHERE conse='$conse'";
		$cur1 = odbc_exec($conexion, $query1);
		$vigencia = odbc_result($cur1,1);
		$fecha = odbc_result($cur1,2);
		$recurso = odbc_result($cur1,3);
		switch ($recurso)
		{
			case '1':
				$recurso1 = "10 CSF";
				break;
			case '2':
				$recurso1 = "50 SSF";
				break;
			case '3':
				$recurso1 = "16 SSF";
				break;
			case '4':
				$recurso1 = "OTROS";
				break;
			default:
				$recurso1 = "";
				break;
		}
		$destino = trim(utf8_encode(odbc_result($cur1,4)));
		// Se consultan adiciones o reducciones
		$query3 = "SELECT * FROM cv_cdp_disc2 WHERE conse='$conse'";
		$cur3 = odbc_exec($conexion, $query3);
		$valor1 = trim(odbc_result($cur3,2));
		$valor1_1 = str_replace(',','',$valor1);
		$valor1_1 = trim($valor1_1);
		$valor1_1 = floatval($valor1_1);
		$numero = trim(odbc_result($cur3,4));
		$adiciones = odbc_result($cur3,5);
		if ($adiciones == ".00")
		{
			$adiciones = "0.00";
		}
		$reducciones = odbc_result($cur3,6);
		if ($reducciones == ".00")
		{
			$reducciones = "0.00";
		}
		// Se consulta saldo por comprometer
		$query4 = "SELECT disponible FROM cv_crp2 WHERE numero='$numero'";
		$cur4 = odbc_exec($conexion, $query4);
	  	$v_disponible = 0;
	  	while($j<$row=odbc_fetch_array($cur4))
	  	{
	    	$v_valor = odbc_result($cur4,1);
	    	$v_valor1 = floatval($v_valor);
	    	$v_disponible = $v_disponible+$v_valor1;
	  	}
	  	$saldo = $v_disponible;
	  	$saldo = ($saldo+$adiciones)-$reducciones;
		$comprometer = number_format($saldo,2);
		$valor1_2 = str_replace(',','',$comprometer);
		$valor1_2 = trim($valor1_2);
		$valor1_2 = floatval($valor1_2);
		$salida1 .= "<tr><td height='35'><center>".$vigencia."</center></td><td height='35'><center>".$fecha."</center></td><td height='35'><center>".$recurso1."</center></td><td height='35'><center>".$numero."</center></td><td height='35'>".$destino."</td><td height='35' align='right'>".$valor1."</td><td height='35' align='right'>".number_format($adiciones,2)."</td><td height='35' align='right'>".number_format($reducciones,2)."</td><td height='35' align='right'>".$comprometer."</td><td height='35'><center><a href='#' onclick=\"subir(".$conse.");\"><img src='imagenes/clip.png' border='0' title='Anexos'></a></center></td></tr>";
		$valores .= $vigencia."|".$fecha."|".$recurso1."|".$numero."|".$destino."|".$valor1_1."|".$adiciones."|".$reducciones."|".$valor1_2."|#";
		$i++;
	}
	$salida1 .= "</table>";
	$salida = new stdClass();
	$salida->salida = $salida1;
	$salida->valores = $valores;
	echo json_encode($salida);
}
?>