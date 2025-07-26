<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$vigencia = $_POST['vigencia'];
	$recurso = $_POST['recurso'];
	$query = "SELECT * FROM cx_crp WHERE EXISTS(SELECT * FROM cx_cdp WHERE conse=cx_crp.conse1 AND cx_cdp.vigencia='$vigencia' AND cx_cdp.recurso='$recurso') ORDER BY conse1, numero";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	$salida1 = "<table width='100%' align='center' border='1'><tr><td width='5%' height='35' bgcolor='#ddebf7'><center><b>CDP</b></center></td><td width='5%' height='35' bgcolor='#ddebf7'><center><b>CRP</b></center></td><td width='8%' height='35' bgcolor='#ddebf7'><center><b>Fecha</b></center></td><td width='7%' height='35' bgcolor='#ddebf7'><center><b>Recurso</b></td><td width='14%' height='35' bgcolor='#ddebf7'><center><b>Valor</b></center></td><td width='14%' height='35' bgcolor='#ddebf7'><center><b>Adiciones</b></center></td><td width='14%' height='35' bgcolor='#ddebf7'><center><b>Reducciones</b></center></td><td width='14%' height='35' bgcolor='#ddebf7'><center><b>Valor Disponible</b></center></td><td width='14%' height='35' bgcolor='#ddebf7'><center><b>Saldo CRP</b></center></td><td width='5%' height='35' bgcolor='#ddebf7'><center>&nbsp</center></td></tr>";
	$valores = "";
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$conse = odbc_result($cur,1);
		$conse1 = odbc_result($cur,2);
		$numero = odbc_result($cur,4);
		$fecha = odbc_result($cur,5);
		$recurso = odbc_result($cur,7);
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
		$valor = odbc_result($cur,9);
		$valor1_1 = str_replace(',','',$valor);
		$valor1_1 = trim($valor1_1);
		$valor1_1 = floatval($valor1_1);
		$destino = trim(utf8_encode(odbc_result($cur,11)));
		$query3 = "SELECT * FROM cx_cdp WHERE conse='$conse1'";
		$cur3 = odbc_exec($conexion, $query3);
		$cdp = odbc_result($cur3,3);
		$query1 = "SELECT * FROM cv_crp_disc2 WHERE conse='$conse'";
		$cur1 = odbc_exec($conexion, $query1);
		$adiciones = odbc_result($cur1,6);
		if ($adiciones == ".00")
		{
			$adiciones = "0.00";
		}
		$reducciones = odbc_result($cur1,7);
		if ($reducciones == ".00")
		{
			$reducciones = "0.00";
		}
		$saldo = odbc_result($cur1,8);
		$valor1_2 = str_replace(',','',$saldo);
		$valor1_2 = trim($valor1_2);
		$valor1_2 = floatval($valor1_2);
		$query4 = "SELECT saldo FROM cx_crp WHERE conse='$conse'";
		$cur4 = odbc_exec($conexion, $query4);
		$saldo1 = odbc_result($cur4,1);
		$valor1_3 = str_replace(',','',$saldo1);
		$valor1_3 = trim($valor1_3);
		$valor1_3 = floatval($valor1_3);
		//$salida1 .= "<tr><td height='35'><center>".$cdp."</center></td><td height='35'><center>".$numero."</center></td><td height='35'><center>".$fecha."</center></td><td height='35'><center>".$recurso1."</center></td><td height='35' align='right'>".$valor."</td><td height='35' align='right'>".number_format($adiciones,2)."</td><td height='35' align='right'>".number_format($reducciones,2)."</td><td height='35' align='right'>".number_format($saldo,2)."</td><td height='35' align='right'>".number_format($saldo1,2)."</td><td height='35'><center><a href='#' onclick=\"subir1(".$conse.");\"><img src='imagenes/clip.png' border='0' title='Anexos'></a></center></td></tr>";

		$salida1 .= "<tr><td height='35'><center>".$cdp."</center></td><td height='35'><center>".$numero."</center></td><td height='35'><center>".$fecha."</center></td><td height='35'><center>".$recurso1."</center></td><td height='35' align='right'>".$valor."</td><td height='35' align='right'>0.00</td><td height='35' align='right'>0.00</td><td height='35' align='right'>".$valor."</td><td height='35' align='right'>".number_format($saldo1,2)."</td><td height='35'><center><a href='#' onclick=\"subir1(".$conse.");\"><img src='imagenes/clip.png' border='0' title='Anexos'></a></center></td></tr>";

		$query2 = "SELECT * FROM cx_crp_dis WHERE conse1='$conse'";
		$cur2 = odbc_exec($conexion, $query2);
		$j = 0;
		while($j<$row=odbc_fetch_array($cur2))
		{
			$var1 = odbc_result($cur2,4);
			$var2 = odbc_result($cur2,6);
			$var3 = odbc_result($cur2,8);
			if ($var2 == "A")
			{
				$salida1 .= "<tr><td height='35'><center>".$cdp."</center></td><td height='35'><center>".$numero."</center></td><td height='35'><center>".$var3."</center></td><td height='35'><center>".$recurso1."</center></td><td height='35' align='right'>".$valor."</td><td height='35' align='right'>".$var1."</td><td height='35' align='right'>0.00</td><td height='35'>&nbsp;</td><td height='35' align='right'>0.00</td></tr>";
			}
			else
			{
				$salida1 .= "<tr><td height='35'><center>".$cdp."</center></td><td height='35'><center>".$numero."</center></td><td height='35'><center>".$var3."</center></td><td height='35'><center>".$recurso1."</center></td><td height='35' align='right'>".$valor."</td><td height='35' align='right'>0.00</td><td height='35' align='right'>".$var1."</td><td height='35' align='right'>".number_format($saldo,2)."</td><td height='35' align='right'>0.00</td></tr>";
			}
			$j++;
		}
		if ($giros > 0)
		{
			$salida1 .= "<tr><td height='35'><center>&nbsp;</center></td><td height='35'><center>&nbsp;</center></td><td height='35'><center>".$f_giros."</center></td><td height='35'>&nbsp;</td><td height='35'>&nbsp</td><td height='35' align='right'>".number_format($giros,2)."</td><td height='35'>&nbsp;</td><td height='35'><center>&nbsp;</center></td></tr>";
		}
		$valores .= $cdp."|".$numero."|".$fecha."|".$valor1_1."|".$adiciones."|".$reducciones."|".$valor1_2."|".$valor1_3."|".$destino."|#";
		$i++;
	}
	$salida1 .= "</table>";
	$salida = new stdClass();
	$salida->salida = $salida1;
	$salida->valores = $valores;
	echo json_encode($salida);
}
// 12/03/2024 - Ajuste presentacion movimientos
?>