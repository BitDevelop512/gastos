<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$tipo1 = $_POST['tipo'];
	$ano = date('Y');
	$query = "SELECT * FROM cx_tra_ted WHERE estado='' ORDER BY tipo, unidad, dependencia DESC";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	if ($total > 0)
	{
		$salida = "<b>Buscar:</b>&nbsp;&nbsp;&nbsp;<input type='text' name='buscar' id='buscar' placeholder='Buscar...' autocomplete='off' style='border-style: dotted;' /><br><br>";
		$salida .= "<table width='100%' align='center' border='1'><tr><td width='5%' height='35' bgcolor='#ddebf7'><center><b>Unidad</b></center></td><td width='12%' height='35' bgcolor='#ddebf7'><center><b>Tipo<br>Veh&iacute;culo</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Asignaci&oacute;n<br>Mensual</b></center></td><td width='3%' height='35' bgcolor='#ddebf7'><center><b>Cant.</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Asignaci&oacute;n<br>Anual</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Valor<br>Ejecutado</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Valor x<br>Ejecutar</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Recurso<br>Adicional<br>CEDE2</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Total Valor<br>Ejecutado<br>R.A.</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Recurso<br>Adicional<br>CEDE4</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Total Valor<br>Ejecutado<br>R.A.</b></center></td></tr>";
		$salida .= "<table width='100%' id='t_contratos' align='center' border='1'>";
		$total1 = 0;
		$total2 = 0;
		$total3 = 0;
		$total4 = 0;
		$total5 = 0;
		$i = 0;
		while($i<$row=odbc_fetch_array($cur))
		{
			$conse = odbc_result($cur,1);
			$fecha = substr(odbc_result($cur,2),0,10);
			$usuario = trim(odbc_result($cur,3));
			$sigla = trim(odbc_result($cur,8));
			$tipo = trim(odbc_result($cur,9));
			switch ($tipo)
			{
				case 'C':
					$n_tipo = "COMBUSTIBLE";
					$n_color = "#cccccc";
					$n_gastos = "'36','42'";
					$f_color = "#000";
					break;
				case 'M':
					$n_tipo = "MANTENIMIENTO Y REPUESTOS";
					$n_color = "#0073b7";
					$f_color = "#fff";
					break;
				case 'L':
					$n_tipo = "LLANTAS";
					$n_color = "#00c0ef";
					$f_color = "#fff";
					break;
				case 'T':
					$n_tipo = "RTM";
					$n_color = "#00718C";
					$f_color = "#fff";
					break;
				default:
					$n_tipo = "";
					$n_color = "#6633FF";
					$f_color = "#fff";
					break;
			}
			$query1 = "SELECT conse, ano, unidad, (SELECT n_dependencia FROM cv_unidades WHERE subdependencia=cx_tra_tev.unidad) AS sigla FROM cx_tra_tev WHERE ano='$ano' AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.consecu=cx_tra_tev.conse AND cx_rel_dis.ano=cx_tra_tev.ano AND cx_rel_dis.gasto IN ($n_gastos))";
			$cur1 = odbc_exec($conexion, $query1);
			$k = 0;
			while($k<$row1=odbc_fetch_array($cur1))
			{
				$x1 = odbc_result($cur1,1);
				$x2 = odbc_result($cur1,2);
				$x3 = odbc_result($cur1,3);
				$x4 = trim(odbc_result($cur1,4));
				if ($sigla == $x4)
				{
					$query2 = "SELECT datos FROM cx_rel_dis where consecu='$x1' and ano='$x2' and gasto IN (".$n_gastos.")";
					$cur2 = odbc_exec($conexion, $query2);
					$row2 = odbc_fetch_array($cur2);
					$x5 = trim(utf8_encode($row2['datos']));
					$num_datos = explode("|",$x5);
					for ($l=0;$l<count($num_datos)-1;++$l)
					{
						$paso = $num_datos[$l];
						$paso1 = explode("»",$paso);
						for ($m=0;$m<count($paso1)-1;++$m)
						{
							$clase = $paso1[0];
							$placa = $paso1[1];
							$valor = $paso1[3];
							$valor = floatval($valor);
						}
						switch ($clase)
						{
							case 'MOTOCICLETA':
								$total1 = $total1+$valor;
								break;
							case 'AUTOMOVIL':
								$total2 = $total2+$valor;
								break;
							case 'CAMIONETA':
								$total3 = $total3+$valor;
								break;
							default:
								break;
						}
					}
				}
				$k++;
			}
			$salida .= "<tr><td width='5%' height='35' bgcolor='".$n_color."'><center><b>".$sigla."</b></center></td><td colspan='9' height='35' bgcolor='".$n_color."'><font color='".$f_color."'><center><b>CONCEPTO DE ".$n_tipo."</b></center></font></td>";;
			if ($tipo1 == "0")
			{
				$salida .= "<td width='10%' height='35' bgcolor='".$n_color."'><center><a href='#' onclick=\"modif(".$conse.");\"><img src='imagenes/ver.png' border='0' title='Ver Información'></a></center></td></tr>";
			}
			else
			{
				$salida .= "<td width='10%' height='35' bgcolor='".$n_color."'>&nbsp;</td></tr>";
			}
			$datos = trim(utf8_encode($row['datos']));
			$num_datos = explode("|",$datos);
			for ($j=0;$j<count($num_datos)-1;++$j)
			{
				$paso = $num_datos[$j];
				$num_valores = explode("»",$paso);
				$v1 = $num_valores[0];
				$v2 = $num_valores[1];
				$v3 = $num_valores[2];
				$v4 = $num_valores[3];
				$v5 = $num_valores[4];
				$v6 = $num_valores[5];
				$v6 = floatval($v6);
				$v7 = $num_valores[6];
				if ($v7 == "")
				{
					$v7 = "0.00";
				}
				$v8 = $num_valores[7];
				$v9 = $num_valores[8];
				if ($v9 == "")
				{
					$v9 = "0.00";
				}
				$v10 = $num_valores[9];
				$v11 = $num_valores[10];
				$pregunta5 = "SELECT nombre FROM cx_ctr_veh WHERE codigo='$v1'";
				$sql5 = odbc_exec($conexion, $pregunta5);
				$w1 = trim(utf8_encode(odbc_result($sql5,1)));
				switch ($w1)
				{
					case 'MOTOCICLETA':
						$ejecutado = $total1;
						break;
					case 'AUTOMÓVIL':
						$ejecutado = $total2;
						break;
					case 'CAMIONETA':
						$ejecutado = $total3;
						break;
					default:
						$ejecutado = "0";
						break;
				}
				if ($tipo == "C")
				{
					$pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$v11'";
					$sql6 = odbc_exec($conexion, $pregunta6);
					$w2 = trim(utf8_encode(odbc_result($sql6,1)));
					$w3 = $w1." - ".$w2;
				}
				else
				{
					$w2 = "";
					$w3 = $w1;
				}
				$ejecutar = $v6-$ejecutado;
				$ejecutar = number_format($ejecutar, 2);
				$ejecutado = number_format($ejecutado, 2);
				$salida .= "<tr><td colspan='1' height='35'>&nbsp;</td><td width='12%' height='35'>".$w3."</td><td width='10%' height='35' align='right'>".$v2."&nbsp;</td><td width='3%' height='35'><center>".$v4."</center></td><td width='10%' height='35' align='right'>".$v5."&nbsp;</td><td width='10%' height='35' align='right'>".$ejecutado."&nbsp;</td><td width='10%' height='35' align='right'>".$ejecutar."&nbsp;</td><td width='10%' height='35' align='right'>".$v7."&nbsp;</td><td width='10%' height='35' align='right'>&nbsp;</td><td width='10%' height='35' align='right'>".$v9."&nbsp;</td><td width='10%' height='35' align='right'>&nbsp;</td></tr>";
			}
			$i++;
		}
		$salida .= "</table>";
		$salida .= "<script>$('input#buscar').quicksearch('table#t_contratos tbody tr');</script>";
	}
	echo $salida;
}
// 07/02/2024 - Consulta techos transportes
// 12/02/2024 - Ajuste consulta de techos
// 15/02/2024 - Ajuste modificacion techos
// 23/02/2024 - Ajuste por creacion de tabla de configuracion de vehiculos
// 05/03/2024 - Ajuste techos inclusion tipo de combustible
// 21/03/2024 - Ajuste color tablas
?>