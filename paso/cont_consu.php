<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	
	$unidades = "";

	$tipo = $_POST['tipo'];
	$query = "SELECT * FROM cx_con_pro ORDER BY fecha DESC";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	if ($total > 0)
	{
		$salida = "<b>Buscar:</b>&nbsp;&nbsp;&nbsp;<input type='text' name='buscar' id='buscar' placeholder='Buscar...' autocomplete='off' style='border-style: dotted;' /><br><br>";
		$salida .= "<table width='100%' align='center' border='1'><tr><td width='15%' height='35' bgcolor='#ddebf7'><center><b>No. del Contrato</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Fecha</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Inicia</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Termina</b></center></td><td width='15%' height='35' bgcolor='#ddebf7'><center><b>Supervisor</b></center></td><td width='20%' height='35' bgcolor='#ddebf7'><center><b>NIT / Nombre del Proveedor</b></center></td><td width='15%' height='35' bgcolor='#ddebf7'><center><b>Valor</b></center></td><td width='5%' height='35' bgcolor='#ddebf7'>&nbsp;</td></tr>";
		$salida .= "<table width='100%' id='t_contratos' align='center' border='1'>";
		$i = 0;
		$total1 = 0;
		$total2 = 0;
		$total3 = 0;
		while($i<$row=odbc_fetch_array($cur))
		{
			$conse = odbc_result($cur,1);
			$numero = trim(odbc_result($cur,6));
			$fecha = substr(odbc_result($cur,7),0,10);
			$valor = odbc_result($cur,9);
			$valor1 = odbc_result($cur,10);
			$total1 = $total1+$valor1;
			$supervisor = trim(utf8_encode(odbc_result($cur,11)));
			$proveedor = trim(utf8_encode(odbc_result($cur,12)));
			$nit = trim(odbc_result($cur,13));
			$fechai = substr(odbc_result($cur,14),0,10);
			$fechaf = substr(odbc_result($cur,15),0,10);
			$salida .= "<tr><td width='15%' height='35'><center>".$numero."</center></td><td width='10%' height='35'><center>".$fecha."</center></td><td width='10%' height='35'><center>".$fechai."</center></td><td width='10%' height='35'><center>".$fechaf."</center></td><td width='15%' height='35'>".$supervisor."</td><td width='20%' height='35'>".$nit." ".$proveedor."</td><td width='15%' height='35' align='right'>".$valor."&nbsp;</td>";
			if ($tipo == "0")
			{
				$salida .= "<td width='5%' height='35'><center><a href='#' onclick=\"modif(".$conse.");\"><img src='imagenes/ver.png' border='0' title='Ver Información'></a></center></td></tr>";
			}
			else
			{
				$salida .= "<td width='5%' height='35'>&nbsp;</td></tr>";
			}

			$salida .= "<tr><td colspan='3' height='35' bgcolor='#cccccc'>&nbsp;</td><td width='10%' height='35' bgcolor='#cccccc'><center><b>Unidad</b></center></td><td width='15%' height='35' bgcolor='#cccccc'><center><b>Valor Asignado</b></center></td><td width='20%' height='35' bgcolor='#cccccc'><center><b>Valor Ejecutado</b></center></td><td width='15%' height='35' bgcolor='#cccccc'><center><b>Valor x Ejecutar</b></center></td><td width='5%' height='35' bgcolor='#cccccc'>&nbsp;</td></tr>";
			$datos = trim(utf8_encode($row['datos']));
			$num_datos = explode("|",$datos);
			for ($j=0;$j<count($num_datos)-1;++$j)
			{
				$paso = $num_datos[$j];
				$num_valores = explode("»",$paso);
				$v1 = $num_valores[0];
				$v2 = $num_valores[1];
				$v3 = $num_valores[2];
				$query1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$v1'";
				$cur1 = odbc_exec($conexion, $query1);
				$v4 = trim(utf8_encode(odbc_result($cur1,1)));
				// Unidades
				switch ($v1)
				{
					case '1':
						$unidades = "'1', '2', '3', '4', '5', '7'";
						break;
					case '8':
						$unidades = "'8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '341'";
						break;
					case '39':
						$unidades = "'39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '63', '64', '65', '66', '67', '68', '343'";
						break;
					case '18':
						$unidades = "'18', '19', '20', '21', '22', '23', '24', '25', '26', '27'";
						break;
					case '28':
						$unidades = "'28', '29', '30', '31', '32', '33', '34', '35', '36', '37'";
						break;
					default:
						$unidades = "'".$v1."'";
						break;
				}
				// Suma por centralizadora
				$query2 = "SELECT SUM(total) AS total FROM cx_tra_moc WHERE unidad IN ($unidades) AND contrato1='$numero'";
				$cur2 = odbc_exec($conexion, $query2);
				$v5 = odbc_result($cur2,1);
				$v6 = str_replace(',','',$v2);
				$v6 = substr($v6,0,-3);
				$v6 = floatval($v6);
				$v7 = $v6-$v5;
				$total2 = $total2+$v5;
				$total3 = $total3+$v7;
				$salida .= "<tr><td colspan='3' height='35'>&nbsp;</td><td width='10%' height='35'>".$v4."</td><td width='15%' height='35' align='right'>".$v2."&nbsp;</td><td width='20%' height='35' align='right'>".number_format($v5,2)."&nbsp;</td><td width='15%' height='35' align='right'>".number_format($v7,2)."&nbsp;</td><td width='5%' height='35'>&nbsp;</td></tr>";
			}
			$i++;
		}
		$salida .= "<tr><td height='35' bgcolor='#999999' colspan='2'><center><b>SUMA TOTAL CONTRATOS</b></center></td><td colspan='2' bgcolor='#999999'>&nbsp</td><td height='35' bgcolor='#999999' align='right'><b>".number_format($total1,2)."</b>&nbsp;</td><td height='35' bgcolor='#999999' align='right'><b>".number_format($total2,2)."</b>&nbsp;</td><td height='35' bgcolor='#999999' align='right'><b>".number_format($total3,2)."</b>&nbsp;</td><td height='35' bgcolor='#999999'>&nbsp;</td></tr>";
		$salida .= "</table>";
		$salida .= "<script>$('input#buscar').quicksearch('table#t_contratos tbody tr');</script>";
	}
	echo $salida;
}
?>