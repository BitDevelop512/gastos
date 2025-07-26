<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$query = "SELECT * FROM cx_apropia ORDER BY conse";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	$salida = "<b>A&ntilde;o Fiscal:</b>&nbsp;&nbsp;&nbsp;<input type='text' name='buscar' id='buscar' placeholder='Buscar...' autocomplete='off' style='border-style: dotted;' /><br><br>";
	$salida .= "<table width='100%' align='center' border='1'><tr><td width='8%' height='35' bgcolor='#ddebf7'><center><b>Vigencia</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Fecha</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Rubro</b></center></td><td width='8%' height='35' bgcolor='#ddebf7'><center><b>Recurso</b></center></td><td width='16%' height='35' bgcolor='#ddebf7'><center><b>Apr. Inicial</b></center></td><td width='16%' height='35' bgcolor='#ddebf7'><center><b>Apr. Adicionada</b></center></td><td width='16%' height='35' bgcolor='#ddebf7'><center><b>Apr. Reducida</b></center></td><td width='16%' height='35' bgcolor='#ddebf7'><center><b>Apr. Vigente</b></center></td></tr>";
	$salida .= "<table width='100%' id='t_apropia' align='center' border='1'>";
	$i = 0;
	$total1 = 0;
	$total2 = 0;
	$total3 = 0;
	$total4 = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$conse = odbc_result($cur,1);
		$valor = odbc_result($cur,3);
		$valor1 = odbc_result($cur,4);
		$total1 = $total1+$valor1;
		$vigencia = odbc_result($cur,5);
		$fecha = odbc_result($cur,8);
		$recurso1 = odbc_result($cur,10);
		$recurso = odbc_result($cur,12);
		$rubro = odbc_result($cur,13);
		$query1 = "SELECT * FROM cv_apr_disc2 WHERE conse='$conse' AND recurso='$recurso1'";
		$cur1 = odbc_exec($conexion, $query1);
		$adiciones = odbc_result($cur1,5);
		$total2 = $total2+$adiciones;
		$reducciones = odbc_result($cur1,6);
		$total3 = $total3+$reducciones;
		$saldo = odbc_result($cur1,7);
		$total4 = $total4+$saldo;
		$salida .= "<tr><td width='8%' height='35'><center>".$vigencia."</center></td><td width='10%' height='35'><center>".$fecha."</center></td><td width='10%' height='35'><center>".$rubro."</center></td><td width='8%' height='35'><center>".$recurso."</center></td><td width='16%' height='35' align='right'>".$valor."</td><td width='16%' height='35'>&nbsp;</td><td width='16%' height='35'>&nbsp;</td><td width='16%' height='35' align='right'>".$valor."</td></tr>";
		$query2 = "SELECT * FROM cx_apro_dis WHERE conse1='$vigencia' AND recurso='$recurso1' ORDER BY fecha";
		$cur2 = odbc_exec($conexion, $query2);
		$j = 0;
		$var_paso = $valor1;
		while($i<$row=odbc_fetch_array($cur2))
		{
			$var1 = odbc_result($cur2,4);
			$var2 = odbc_result($cur2,5);
			$var3 = odbc_result($cur2,6);
			$fecha1 = odbc_result($cur2,8);
			$recurso1 = odbc_result($cur2,11);
			$rubro1 = odbc_result($cur2,12);
			if ($var3 == "A")
			{
				$var_paso = $var_paso+$var2;
				$var_paso1 = number_format($var_paso,2);
				$salida .= "<tr><td height='35'><center>".$vigencia."</center></td><td height='35'><center>".$fecha1."</center></td><td height='35'><center>".$rubro1."</center></td><td height='35'><center>".$recurso1."</center></td><td height='35'>&nbsp;</td><td height='35' align='right'>".$var1."</td><td height='35'>&nbsp</td><td height='35' align='right'>".$var_paso1."</td></tr>";
			}
			else
			{
				$var_paso = $var_paso-$var2;
				$var_paso1 = number_format($var_paso,2);
				$salida .= "<tr><td height='35'><center>".$vigencia."</center></td><td height='35'><center>".$fecha1."</center><td height='35'><center>".$rubro1."</center></td><td height='35'><center>".$recurso1."</center></td><td height='35'>&nbsp</td><td height='35'>&nbsp</td><td height='35' align='right'>".$var1."</td><td height='35' align='right'>".$var_paso1."</td></tr>";
			}
			$j++;
		}
		$salida .= "<tr><td height='35' bgcolor='#cccccc'><center>".$vigencia."</center></td><td height='35' bgcolor='#cccccc'>&nbsp</td><td height='35' bgcolor='#cccccc'>&nbsp</td><td height='35' bgcolor='#cccccc'>&nbsp</td><td height='35' bgcolor='#cccccc' align='right'>".$valor."</td><td height='35' bgcolor='#cccccc' align='right'>".number_format($adiciones,2)."</td><td height='35' bgcolor='#cccccc' align='right'>".number_format($reducciones,2)."</td><td height='35' bgcolor='#cccccc' align='right'>".number_format($saldo,2)."</td></tr>";
		$salida .= "<tr><td height='35' colspan='8'><center>&nbsp;</center></td></tr>";
		$i++;
	}
	$salida .= "<tr><td height='35' bgcolor='#999999' colspan='2'><center><b>SUMA TOTAL VIGENCIA</b></center></td><td height='35' bgcolor='#999999'>&nbsp</td><td height='35' bgcolor='#999999'>&nbsp</td><td height='35' bgcolor='#999999' align='right'><b>".number_format($total1,2)."</b></td><td height='35' bgcolor='#999999' align='right'><b>".number_format($total2,2)."</b></td><td height='35' bgcolor='#999999' align='right'><b>".number_format($total3,2)."</b></td><td height='35' bgcolor='#999999' align='right'><b>".number_format($total4,2)."</b></td></tr>";
	$salida .= "</table>";
	$salida .= "<script>$('input#buscar').quicksearch('table#t_apropia tbody tr');</script>";
	echo $salida;
}
?>