<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$periodo1 = $_POST['periodo1'];
	$periodo2 = $_POST['periodo2'];
	$ano = $_POST['ano'];
	$empadrona = $_POST['empadrona'];
	switch ($tipo)
	{
		case '3':
			$gastos = "'38', '44'";
			$tabla = "cx_tra_man";
			break;
		case '4':
			$gastos = "'39', '45'";
			$tabla = "cx_tra_lla";
			break;		
		case '5':
			$gastos = "'40', '46'";
			$tabla = "cx_tra_rtm";
			break;
		default:
			break;
	}
	if (($tipo == "1") or ($tipo == "2"))
	{
		$pregunta = "SELECT placa FROM cx_pla_tra WHERE 1=1";
		if (($uni_usuario == "1") or ($uni_usuario == "2"))
		{
		}
		else
		{
			$pregunta .= " AND unidad='$uni_usuario'";
		}
		if (($empadrona == "F") or ($empadrona == "G"))
		{
			if ($empadrona == "F")
 			{
				$pregunta .= " AND empadrona='1'";
			}
			else
 			{
				$pregunta .= " AND empadrona='2'";
			}
		}
		else
		{
			$pregunta .= " AND empadrona='3'";
		}
		$pregunta .= " ORDER BY placa";
		$sql = odbc_exec($conexion,$pregunta);
		$total = odbc_num_rows($sql);
		$salida = new stdClass();
		if ($total>0)
		{
			$i = 0;
			$placas = array();
			$placas1 = "<option value=''>- SELECCIONAR -</option>";
			while ($i < $row = odbc_fetch_array($sql))
			{
				$placa = odbc_result($sql,1);
				if (in_array($placa, $placas, TRUE))
				{
				}
				else
				{
					array_push($placas, $placa);
					$placas1 .= "<option value='".$placa."'>".$placa."</option>";
				}
			}
		}
	}
	else
	{
		if (($empadrona == "F") or ($empadrona == "G"))
		{
			if ($empadrona == "F")
 			{
				$empadrona1 = "1";
			}
			else
 			{
				$empadrona1 = "2";
			}
		}
		else
		{
			$empadrona1 = "3";
		}
		if (($empadrona == "F") or ($empadrona == "G"))
		{
			$pregunta = "SELECT conse, consecu, ano FROM cx_rel_gas WHERE periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.conse1=cx_rel_gas.conse AND cx_rel_dis.ano=cx_rel_gas.ano AND cx_rel_dis.consecu=cx_rel_gas.consecu AND cx_rel_dis.gasto IN (".$gastos."))";
			if (($uni_usuario == "1") or ($uni_usuario == "2"))
			{
			}
			else
			{
				$pregunta .= " AND cx_rel_gas.unidad='$uni_usuario'";
			}
			$sql = odbc_exec($conexion,$pregunta);
			$total = odbc_num_rows($sql);
			$salida = new stdClass();
			if ($total>0)
			{
				$i = 0;
				$placas = array();
				$placas1 = "";
				while ($i < $row = odbc_fetch_array($sql))
				{
					$conse = odbc_result($sql,1);
					$consecu = odbc_result($sql,2);
					$ano = odbc_result($sql,3);
					$pregunta1 = "SELECT datos FROM cx_rel_dis WHERE conse1='$conse' AND consecu='$consecu' AND ano='$ano' AND gasto IN (".$gastos.")";
					$sql1 = odbc_exec($conexion, $pregunta1);
					$l = 0;
					while ($l < $row = odbc_fetch_array($sql1))
					{
						$datos = trim(utf8_encode($row['datos']));
						$num_datos = explode("|", $datos);
						for ($m=0;$m<count($num_datos)-1;++$m)
						{
							$paso = $num_datos[$m];
							$num_paso = explode("»", $paso);
							$paso1 = $num_paso[1];
							$pregunta2 = "SELECT empadrona FROM cx_pla_tra WHERE placa='$paso1'";
							$sql2 = odbc_exec($conexion, $pregunta2);
							$empadrona2 = odbc_result($sql2,1);
							if ($empadrona1 == $empadrona2)
							{
								if (in_array($paso1, $placas, TRUE))
			  					{
			  					}
			  					else
			  					{
									array_push($placas, $paso1);
									$placas1 .= "<option value='".$paso1."'>".$paso1."</option>";
								}
							}
						}				
					}
					$l++;
				}
			}
		}
		else
		{
			$mes = str_pad($periodo1,2,"0",STR_PAD_LEFT);
			switch ($periodo1)
			{
				case '1':
				case '3':
				case '5':
				case '7':
				case '8':
				case '10':
				case '12':
					$dia = "31";
					break;
				case '2':
					if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
					{
						$dia = "29";
					}
					else
					{
						$dia = "28";
					}
					break;
				case '4':
				case '6':
				case '9':
				case '11':
					$dia = "30";
					break;
				default:
					$dia = "31";
					break;
			}
			$fecha1 = $ano."/".$mes."/01";
			// Segundo periodo
			$mes2 = str_pad($periodo2,2,"0",STR_PAD_LEFT);
			switch ($periodo2)
			{
				case '1':
				case '3':
				case '5':
				case '7':
				case '8':
				case '10':
				case '12':
					$dia2 = "31";
					break;
				case '2':
					if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
					{
						$dia2 = "29";
					}
					else
					{
						$dia2 = "28";
					}
	      			break;
				case '4':
				case '6':
				case '9':
				case '11':
					$dia2 = "30";
					break;
				default:
					$dia2 = "31";
					break;
			}
			$fecha2 = $ano."/".$mes2."/".$dia2;
			$pregunta = "SELECT placa FROM ".$tabla." WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
			if (($uni_usuario == "1") or ($uni_usuario == "2"))
			{
			}
			else
			{
				$pregunta .= " AND unidad='$uni_usuario'";
			}
			$sql = odbc_exec($conexion,$pregunta);
			$total = odbc_num_rows($sql);
			$salida = new stdClass();
			if ($total>0)
			{
				$i = 0;
				$placas = array();
				$placas1 = "";
				while ($i < $row = odbc_fetch_array($sql))
				{
					$placa = odbc_result($sql,1);
					if (in_array($placa, $placas, TRUE))
					{
					}
					else
					{
						array_push($placas, $placa);
						$placas1 .= "<option value='".$placa."'>".$placa."</option>";
					}
				}
			}
		}
	}
	$salida->placas = $placas;
	$salida->placas1 = $placas1;
	echo json_encode($salida);
}
// 19/02/2024 - Ajuste para individualizar consulta por empadronamiento
?>