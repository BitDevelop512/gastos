<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$tipo1 = $_POST['tipo'];
	$concepto = $_POST['concepto'];
	$ano = $_POST['ano'];
	$calculo = $_POST['calculo'];
	$query = "SELECT *, (SELECT subdependencia FROM cx_org_sub WHERE cx_org_sub.sigla=cx_tra_ted.sigla) AS n_subdependencia FROM cx_tra_ted WHERE estado=''";
	if ($concepto == "-")
	{
	}
	else
	{
		$query .= " AND tipo='$concepto' ";
	}
	$query .= " AND ano='$ano'";
	$query .= " ORDER BY tipo, unidad, dependencia DESC";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	if ($total > 0)
	{
		$valores = "";
		$salida1 = "<table width='100%' align='center' border='0'><tr><td width='90%' height='35'><b>Buscar:</b>&nbsp;&nbsp;&nbsp;<input type='text' name='buscar' id='buscar' placeholder='Buscar...' autocomplete='off' style='border-style: dotted;' /></td><td width='10%' height='35'><center><a href='#' onclick='excel(); return false;'><img src='dist/img/excel.png' name='lnk1' id='lnk1' title='Exportar Techos a Excel - SAP'></a></center></td></tr></table><br>";
		$salida1 .= "<table width='100%' align='center' border='1'><tr><td width='5%' height='35' bgcolor='#ddebf7'><center><b>Unidad</b></center></td><td width='12%' height='35' bgcolor='#ddebf7'><center><b>Tipo<br>Veh&iacute;culo</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Asignaci&oacute;n<br>Mensual</b></center></td><td width='3%' height='35' bgcolor='#ddebf7'><center><b>Cant.</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Asignaci&oacute;n<br>Anual</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Valor<br>Ejecutado</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Valor x<br>Ejecutar</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Recurso<br>Adicional<br>CEDE2</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Total Valor<br>Ejecutado<br>R.A.</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Recurso<br>Adicional<br>CEDE4</b></center></td><td width='10%' height='35' bgcolor='#ddebf7'><center><b>Total Valor<br>Ejecutado<br>R.A.</b></center></td></tr>";
		$salida1 .= "<table width='100%' id='t_contratos' align='center' border='1'>";
		// Totales
		$total1 = 0;
		$total2 = 0;
		$total3 = 0;
		$total4 = 0;
		$total5 = 0;
		$total6 = 0;
		$total7 = 0;
		$total8 = 0;
		$total9 = 0;
		$total10 = 0;
		$total11 = 0;
		$total12 = 0;
		$total13 = 0;
		$total14 = 0;
		$total15 = 0;
		$total16 = 0;
		$total17 = 0;
		$total18 = 0;
		$total19 = 0;
		$total20 = 0;
		$total21 = 0;
		$total22 = 0;
		$total23 = 0;
		$total24 = 0;
		$total25 = 0;
		$total26 = 0;
		$total27 = 0;
		$total28 = 0;
		$total29 = 0;
		$total30 = 0;
		$total31 = 0;
		$total32 = 0;
		$total33 = 0;
		$total34 = 0;
		$total35 = 0;
		$total36 = 0;
		$total37 = 0;
		$total38 = 0;
		$total39 = 0;
		$total40 = 0;
		$total41 = 0;
		$total42 = 0;
		$total43 = 0;
		$total44 = 0;
		$total45 = 0;
		$total46 = 0;
		$total47 = 0;
		$total48 = 0;
		$subtotal1 = 0;
		$subtotal2 = 0;
		$subtotal3 = 0;
		$subtotal4 = 0;
		$subtotal5 = 0;
		$subtotal6 = 0;
		$subtotal7 = 0;
		$subtotal8 = 0;
		$i = 0;
		while($i<$row=odbc_fetch_array($cur))
		{
			$conse = odbc_result($cur,1);
			$fecha = substr(odbc_result($cur,2),0,10);
			$usuario = trim(odbc_result($cur,3));
			$n_unidad = trim(odbc_result($cur,6));
			$n_dependencia = trim(odbc_result($cur,7));
			$sigla = trim(odbc_result($cur,8));
			$tipo = trim(odbc_result($cur,9));
			switch ($tipo)
			{
				case 'C':
					$n_tipo = "COMBUSTIBLE";
					$n_color = "#cccccc";
					$f_color = "#000";
					$n_gastos = "'36','42'";
					break;
				case 'M':
					$n_tipo = "MANTENIMIENTO Y REPUESTOS";
					$n_color = "#0073b7";
					$f_color = "#fff";
					$n_gastos = "'38','44'";
					break;
				case 'T':
					$n_tipo = "RTM";
					$n_color = "#00718C";
					$f_color = "#fff";
					$n_gastos = "'39','45'";
					break;
				case 'L':
					$n_tipo = "LLANTAS";
					$n_color = "#00c0ef";
					$f_color = "#fff";
					$n_gastos = "'40','46'";
					break;
				default:
					$n_tipo = "";
					$n_color = "#6633FF";
					$f_color = "#fff";
					$n_gastos = "''";
					break;
			}
			$n_subdependencia = odbc_result($cur,11);
			// Unidades que dependen de la centralizadora
			$query0 = "SELECT unidad, dependencia, tipo FROM cx_org_sub WHERE subdependencia='$n_subdependencia'";
			$cur0 = odbc_exec($conexion, $query0);
			$n_unidad = odbc_result($cur0,1);
			$n_dependencia = odbc_result($cur0,2);
			$n_tipo1 = odbc_result($cur0,3);
			if (($n_unidad == "1") or ($n_unidad == "2") or ($n_unidad == "3"))
			{
				if (($n_unidad == "2") or ($n_unidad == "3"))
				{
					$pregunta0 = "SELECT dependencia FROM cx_org_sub WHERE unidad='$n_unidad'";
					$sql0 = odbc_exec($conexion, $pregunta0);
					$dependencia = odbc_result($sql0,1);
					$query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' ORDER BY subdependencia";
				}
				else
				{
					$query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' AND tipo='2' AND unic='0' ORDER BY subdependencia";
				}
			}
			else
			{
				if ($n_tipo1 == "7")
				{
					$query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' ORDER BY subdependencia";
				}
				else
				{
					$query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY subdependencia";
				}
			}
			$cur1 = odbc_exec($conexion, $query1);
			$numero = "";
			while($j<$row1=odbc_fetch_array($cur1))
			{
				$numero .= "'".odbc_result($cur1,1)."',";
			}
			$numero = substr($numero,0,-1);
			// Se verifica si es unidad centralizadora especial
			if (strpos($especial, $n_subdependencia) !== false)
			{
				$numero .= ",";
				$query2 = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$n_unidad' ORDER BY unidad";
				$cur2 = odbc_exec($conexion, $query2);
				while($k<$row2=odbc_fetch_array($cur2))
				{
					$n_unidad = odbc_result($cur2,1);
					$n_dependencia = odbc_result($cur2,2);
					$query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
					$cur1 = odbc_exec($conexion, $query1);
					while($m<$row3=odbc_fetch_array($cur1))
					{
						$numero .= "'".odbc_result($cur1,1)."',";
					}
				}
				$numero = substr($numero,0,-1);
				$numero .= $uni_usuario;
			}
			// Fin que dependen de la centralizadora
			if (($calculo == "1") and ($concepto != "-"))
			{
				//$query1 = "SELECT conse, ano, unidad, (SELECT n_dependencia FROM cv_unidades WHERE subdependencia=cx_tra_tev.unidad) AS sigla FROM cx_tra_tev WHERE ano='$ano' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.consecu=cx_tra_tev.conse AND cx_rel_dis.ano=cx_tra_tev.ano AND cx_rel_dis.gasto IN ($n_gastos)) AND EXISTS (SELECT * FROM cx_rel_gas WHERE cx_rel_gas.consecu=cx_tra_tev.conse AND cx_rel_gas.ano=cx_tra_tev.ano AND cx_rel_gas.unidad=cx_tra_tev.unidad AND cx_rel_gas.unidad IN ($numero))";
				$query1 = "SELECT conse, ano, unidad, (SELECT n_dependencia FROM cv_unidades WHERE subdependencia=cx_pla_inv.unidad) AS sigla FROM cx_pla_inv WHERE ano='$ano' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.consecu=cx_pla_inv.conse AND cx_rel_dis.ano=cx_pla_inv.ano AND cx_rel_dis.gasto IN ($n_gastos)) AND EXISTS (SELECT * FROM cx_rel_gas WHERE cx_rel_gas.consecu=cx_pla_inv.conse AND cx_rel_gas.ano=cx_pla_inv.ano AND cx_rel_gas.unidad=cx_pla_inv.unidad AND cx_rel_gas.unidad IN ($numero))";
				$cur1 = odbc_exec($conexion, $query1);
				$k = 0;
				while($k<$row1=odbc_fetch_array($cur1))
				{
					$x1 = odbc_result($cur1,1);
					$x2 = odbc_result($cur1,2);
					$x3 = odbc_result($cur1,3);
					$x4 = trim(odbc_result($cur1,4));
					//if ($sigla == $x4)
					//{
						$query2 = "SELECT datos, gasto, tipo, (SELECT unidad FROM cx_rel_gas WHERE cx_rel_gas.consecu=cx_rel_dis.consecu AND cx_rel_gas.ano=cx_rel_dis.ano AND cx_rel_gas.conse=cx_rel_dis.conse1) AS unidad FROM cx_rel_dis where consecu='$x1' and ano='$x2' and gasto IN (".$n_gastos.")";
						$cur2 = odbc_exec($conexion, $query2);
						$tot2 = odbc_num_rows($cur2);
						while($n<$row2=odbc_fetch_array($cur2))
						{
							$x5 = trim(utf8_encode($row2['datos']));
							$x6 = odbc_result($cur2,2);
							$x7 = odbc_result($cur2,3);
							$x8 = odbc_result($cur2,4);
							if ($x8 == "999")
							{
							}
							else
							{
								$num_datos = explode("|",$x5);
								if ($tipo == "C")
								{
									$contador = count($num_datos);
									for ($l=0;$l<$contador-1;++$l)
									{
										$valor = 0;
										$paso = $num_datos[$l];
										$paso1 = explode("»",$paso);
										$contador1 = count($paso1);
										for ($m=0;$m<$contador1;++$m)
										{
											$clase = $paso1[0];
											$placa = $paso1[1];
											$valor = $paso1[3];
											$valor = floatval($valor);
											$query3 = "SELECT empadrona, tipo FROM cx_pla_tra where placa='$placa'";
											$cur3 = odbc_exec($conexion, $query3);
											$empadrona = odbc_result($cur3,1);
											$combustible = odbc_result($cur3,2);
											if ($x7 == "N")
											{
												$query4 = "SELECT SUM(total) AS total FROM cx_tra_mov WHERE placa='$placa' AND solicitud='$x1' AND ano='$x2' AND soporte='0'";
												if ($x6 == "36")
												{
													$query4 .= " AND tipo='1'";
												}
												else
												{
													$query4 .= " AND tipo='2'";
												}
												$cur4 = odbc_exec($conexion, $query4);
												$valor = odbc_result($cur4,1);
											}
										}
										if ($clase == "")
										{
										}
										else
										{
											if ($x6 == "36")
											{
												switch ($clase)
												{
													case 'MOTOCICLETA':
														if ($combustible == "1")
														{
															$total1 = $total1+$valor;
														}
														else
														{
															$total2 = $total2+$valor;
														}
														break;
													case 'AUTOMOVIL':
													case 'AUTOMÓVIL':
														if ($combustible == "1")
														{
															$total7 = $total7+$valor;
														}
														else
														{
															$total8 = $total8+$valor;
														}
														break;
													case 'CAMIONETA':
														if ($combustible == "1")
														{
															$total13 = $total13+$valor;
														}
														else
														{
															$total14 = $total14+$valor;
														}
														break;
													case 'VANS':
														if ($combustible == "1")
														{
															$total19 = $total19+$valor;
														}
														else
														{
															$total20 = $total20+$valor;
														}
														break;
													case 'CAMPERO':
														if ($combustible == "1")
														{
															$total25 = $total25+$valor;
														}
														else
														{
															$total26 = $total26+$valor;
														}
														break;
													case 'MICROBUS':
														if ($combustible == "1")
														{
															$total31 = $total31+$valor;
														}
														else
														{
															$total32 = $total32+$valor;
														}
														break;
													case 'CAMION':
													case 'CAMIÓN':
														if ($combustible == "1")
														{
															$total37 = $total37+$valor;
														}
														else
														{
															$total38 = $total38+$valor;
														}
														break;
													case 'MAX 8*8':
														if ($combustible == "1")
														{
															$total43 = $total43+$valor;
														}
														else
														{
															$total44 = $total44+$valor;
														}
														break;
													default:
														break;
												}
											}
											else
											{
												if (($x6 == "42") and (($empadrona == "1") or ($empadrona == "3")))
												{
													switch ($clase)
													{
														case 'MOTOCICLETA':
															if ($combustible == "1")
															{
																$total3 = $total3+$valor;
															}
															else
															{
																$total4 = $total4+$valor;
															}
															break;
														case 'AUTOMOVIL':
														case 'AUTOMÓVIL':
															if ($combustible == "1")
															{
																$total9 = $total9+$valor;
															}
															else
															{
																$total10 = $total10+$valor;
															}
															break;
														case 'CAMIONETA':
															if ($combustible == "1")
															{
																$total15 = $total15+$valor;
															}
															else
															{
																$total16 = $total16+$valor;
															}
															break;
														case 'VANS':
															if ($combustible == "1")
															{
																$total21 = $total21+$valor;
															}
															else
															{
																$total22 = $total22+$valor;
															}
															break;
														case 'CAMPERO':
															if ($combustible == "1")
															{
																$total27 = $total27+$valor;
															}
															else
															{
																$total28 = $total28+$valor;
															}
															break;
														case 'MICROBUS':
															if ($combustible == "1")
															{
																$total33 = $total33+$valor;
															}
															else
															{
																$total34 = $total34+$valor;
															}
															break;
														case 'CAMION':
														case 'CAMIÓN':
															if ($combustible == "1")
															{
																$total39 = $total39+$valor;
															}
															else
															{
																$total40 = $total40+$valor;
															}
															break;
														case 'MAX 8*8':
															if ($combustible == "1")
															{
																$total45 = $total45+$valor;
															}
															else
															{
																$total46 = $total46+$valor;
															}
															break;
														default:
															break;
													}
												}
												else
												{
													switch ($clase)
													{
														case 'MOTOCICLETA':
															if ($combustible == "1")
															{
																$total5 = $total5+$valor;
															}
															else
															{
																$total6 = $total6+$valor;
															}
															break;
														case 'AUTOMOVIL':
														case 'AUTOMÓVIL':
															if ($combustible == "1")
															{
																$total11 = $total11+$valor;
															}
															else
															{
																$total12 = $total12+$valor;
															}
															break;
														case 'CAMIONETA':
															if ($combustible == "1")
															{
																$total17 = $total17+$valor;
															}
															else
															{
																$total18 = $total18+$valor;
															}
															break;
														case 'VANS':
															if ($combustible == "1")
															{
																$total23 = $total23+$valor;
															}
															else
															{
																$total24 = $total24+$valor;
															}
															break;
														case 'CAMPERO':
															if ($combustible == "1")
															{
																$total29 = $total29+$valor;
															}
															else
															{
																$total30 = $total30+$valor;
															}
															break;
														case 'MICROBUS':
															if ($combustible == "1")
															{
																$total35 = $total35+$valor;
															}
															else
															{
																$total36 = $total36+$valor;
															}
															break;
														case 'CAMION':
														case 'CAMIÓN':
															if ($combustible == "1")
															{
																$total41 = $total41+$valor;
															}
															else
															{
																$total42 = $total42+$valor;
															}
															break;
														case 'MAX 8*8':
															if ($combustible == "1")
															{
																$total47 = $total47+$valor;
															}
															else
															{
																$total48 = $total48+$valor;
															}
															break;
														default:
															break;
													}
												}
											}
					    			}
									}
								}
								if (($tipo == "M") or ($tipo == "T") or ($tipo == "L"))
								{
									$contador = count($num_datos);
									for ($l=0;$l<$contador;++$l)
									{
										$valor = 0;
										$paso = $num_datos[$l];
										$paso1 = explode("»",$paso);
										$contador1 = count($paso1);
										for ($m=0;$m<$contador1;++$m)
										{
											$clase = $paso1[0];
											$placa = $paso1[1];
											if ($tipo == "L")
											{
												$valor = $paso1[7];
											}
											else
											{
												if ($tipo == "M")
												{
													$valor = $paso1[13];
												}
												else
												{
														$valor = $paso1[6];
												}
											}
											$valor = floatval($valor);
											$query3 = "SELECT empadrona, tipo FROM cx_pla_tra where placa='$placa'";
											$cur3 = odbc_exec($conexion, $query3);
											$empadrona = odbc_result($cur3,1);
											$combustible = odbc_result($cur3,2);
										}
										if (($clase == "") or ($placa == ""))
										{
										}
										else
										{
											if (($x6 == "38") or ($x6 == "39") or ($x6 == "40"))
											{
												switch ($clase)
												{
													case 'MOTOCICLETA':
														$total1 = $total1+$valor;
														break;
													case 'AUTOMOVIL':
													case 'AUTOMÓVIL':
														$total7 = $total7+$valor;
														break;
													case 'CAMIONETA':
														$total13 = $total13+$valor;
														break;
													case 'VANS':
														$total19 = $total19+$valor;
														break;
													case 'CAMPERO':
														$total25 = $total25+$valor;
														break;
													case 'MICROBUS':
														$total31 = $total31+$valor;
														break;
													case 'CAMION':
													case 'CAMIÓN':
														$total37 = $total37+$valor;
														break;
													case 'MAX 8*8':
														$total43 = $total43+$valor;
														break;
													default:
														break;
												}
											}
											else
											{
												if ((($x6 == "44") or ($x6 == "45") or ($x6 == "46")) and (($empadrona == "1") or ($empadrona == "3")))
												{
													switch ($clase)
													{
														case 'MOTOCICLETA':
															$total3 = $total3+$valor;
															break;
														case 'AUTOMOVIL':
														case 'AUTOMÓVIL':
															$total9 = $total9+$valor;
															break;
														case 'CAMIONETA':
															$total15 = $total15+$valor;
															break;
														case 'VANS':
															$total21 = $total21+$valor;
															break;
														case 'CAMPERO':
															$total27 = $total27+$valor;
															break;
														case 'MICROBUS':
															$total33 = $total33+$valor;
															break;
														case 'CAMION':
														case 'CAMIÓN':
															$total39 = $total39+$valor;
															break;
														case 'MAX 8*8':
															$total45 = $total45+$valor;
															break;
														default:
															break;
													}
												}
												else
												{
													switch ($clase)
													{
														case 'MOTOCICLETA':
															$total5 = $total5+$valor;
															break;
														case 'AUTOMOVIL':
														case 'AUTOMÓVIL':
															$total11 = $total11+$valor;
															break;
														case 'CAMIONETA':
															$total17 = $total17+$valor;
															break;
														case 'VANS':
															$total23 = $total23+$valor;
															break;
														case 'CAMPERO':
															$total29 = $total29+$valor;
															break;
														case 'MICROBUS':
															$total35 = $total35+$valor;
															break;
														case 'CAMION':
														case 'CAMIÓN':
															$total41 = $total41+$valor;
															break;
														case 'MAX 8*8':
															$total47 = $total47+$valor;
															break;
														default:
															break;
													}
												}
											}
					    			}
									}
								}
							}
							$n++;
						}
					//}
					$k++;
				}
			}
			$salida1 .= "<tr><td width='5%' height='35' bgcolor='".$n_color."'><font color='".$f_color."'><center><b>".$sigla."</b></center></font></td><td colspan='9' height='35' bgcolor='".$n_color."'><font color='".$f_color."'><center><b>CONCEPTO DE ".$n_tipo."</b></center></font></td>";;
			if ($tipo1 == "0")
			{
				$salida1 .= "<td width='10%' height='35' bgcolor='".$n_color."'><center><a href='#' onclick=\"modif(".$conse.");\"><img src='imagenes/ver.png' border='0' title='Ver Información'></a></center></td></tr>";
			}
			else
			{
				$salida1 .= "<td width='10%' height='35' bgcolor='".$n_color."'>&nbsp;</td></tr>";
			}
			// Discriminado de techo por centralizadora
			$datos = trim(utf8_encode($row['datos']));
			$num_datos = explode("|",$datos);
			for ($j=0;$j<count($num_datos)-1;++$j)
			{
				$paso = $num_datos[$j];
				$num_valores = explode("»",$paso);
				$v1 = $num_valores[0];
				$v2 = $num_valores[1];
				if ($v2 == "")
				{
					$v2 = "0.00";
				}
				$v3 = $num_valores[2];
				$v4 = $num_valores[3];
				$v5 = $num_valores[4];
				$v5_1 = str_replace(',','',$v5);
				$v5_1 = floatval($v5_1);
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
				// Tipo de vehiculo en techo
				$pregunta5 = "SELECT nombre FROM cx_ctr_veh WHERE codigo='$v1'";
				$sql5 = odbc_exec($conexion, $pregunta5);
				$w1 = trim(utf8_encode(odbc_result($sql5,1)));
				// Tipo de combustible del vehiculo en techo
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
					$v11 = "1";
				}
				switch ($w1)
				{
					case 'MOTOCICLETA':
						if ($v11 == "1")
						{
							$ejecutado1 = $total1;
							$ejecutado2 = $total3;
							$ejecutado3 = $total5;
						}
						else
						{
							$ejecutado1 = $total2;
							$ejecutado2 = $total4;
							$ejecutado3 = $total6;
						}
						break;
					case 'AUTOMOVIL':
					case 'AUTOMÓVIL':
						if ($v11 == "1")
						{
							$ejecutado1 = $total7;
							$ejecutado2 = $total9;
							$ejecutado3 = $total11;
						}
						else
						{
							$ejecutado1 = $total8;
							$ejecutado2 = $total10;
							$ejecutado3 = $total12;
						}
						break;
					case 'CAMIONETA':
						if ($v11 == "1")
						{
							$ejecutado1 = $total13;
							$ejecutado2 = $total15;
							$ejecutado3 = $total17;
						}
						else
						{
							$ejecutado1 = $total14;
							$ejecutado2 = $total16;
							$ejecutado3 = $total18;
						}
						break;
					case 'VANS':
						if ($v11 == "1")
						{
							$ejecutado1 = $total19;
							$ejecutado2 = $total21;
							$ejecutado3 = $total23;
						}
						else
						{
							$ejecutado1 = $total20;
							$ejecutado2 = $total22;
							$ejecutado3 = $total24;
						}
						break;
					case 'CAMPERO':
						if ($v11 == "1")
						{
							$ejecutado1 = $total25;
							$ejecutado2 = $total27;
							$ejecutado3 = $total29;
						}
						else
						{
							$ejecutado1 = $total26;
							$ejecutado2 = $total28;
							$ejecutado3 = $total30;
						}
						break;
					case 'MICROBUS':
						if ($v11 == "1")
						{
							$ejecutado1 = $total31;
							$ejecutado2 = $total33;
							$ejecutado3 = $total35;
						}
						else
						{
							$ejecutado1 = $total32;
							$ejecutado2 = $total34;
							$ejecutado3 = $total36;
						}
						break;
					case 'CAMION':
					case 'CAMIÓN':
						if ($v11 == "1")
						{
							$ejecutado1 = $total37;
							$ejecutado2 = $total39;
							$ejecutado3 = $total41;
						}
						else
						{
							$ejecutado1 = $total38;
							$ejecutado2 = $total40;
							$ejecutado3 = $total42;
						}
						break;
					case 'MAX 8*8':
						if ($v11 == "1")
						{
							$ejecutado1 = $total43;
							$ejecutado2 = $total45;
							$ejecutado3 = $total47;
						}
						else
						{
							$ejecutado1 = $total44;
							$ejecutado2 = $total46;
							$ejecutado3 = $total48;
						}
						break;
					default:
						$ejecutado1 = "0";
						$ejecutado2 = "0";
						$ejecutado3 = "0";
						break;
				}
				$ejecutado4 = $ejecutado1;
				$ejecutado5 = $ejecutado2;
				$ejecutado6 = $ejecutado3;
				$ejecutar = $v6-$ejecutado1;
				$ejecutar1 = $ejecutar;
				$ejecutar = number_format($ejecutar, 2);
				$ejecutado1 = number_format($ejecutado1, 2);
				$ejecutado2 = number_format($ejecutado2, 2);
				$ejecutado3 = number_format($ejecutado3, 2);
				$salida1 .= "<tr><td colspan='1' height='35'><center>".$sigla."</center></td><td width='12%' height='35'>".$w3."</td><td width='10%' height='35' align='right'>".$v2."&nbsp;</td><td width='3%' height='35'><center>".$v4."</center></td><td width='10%' height='35' align='right'>".$v5."&nbsp;</td>";
				$salida1 .= "<td width='10%' height='35' align='right'>".$ejecutado1."&nbsp;</td><td width='10%' height='35' align='right'>".$ejecutar."&nbsp;</td><td width='10%' height='35' align='right'>".$v7."&nbsp;</td><td width='10%' height='35' align='right'>".$ejecutado2."&nbsp;</td><td width='10%' height='35' align='right'>".$v9."&nbsp;</td><td width='10%' height='35' align='right'>".$ejecutado3."&nbsp;</td></tr>";
				$valores .= $sigla."|".$w3."|".$v3."|".$v4."|".$v6."|".$ejecutado4."|".$ejecutar1."|".$v8."|".$ejecutado5."|".$v10."|".$ejecutado6."|".$n_tipo."|#";
				$z2 = str_replace(',','',$v2);
				$z2 = floatval($z2);
				$subtotal1 = $subtotal1+$z2;
				$subtotal11 = number_format($subtotal1, 2);
				$z5 = str_replace(',','',$v5);
				$z5 = floatval($z5);
				$subtotal2 = $subtotal2+$z5;
				$subtotal22 = number_format($subtotal2, 2);
				$subtotal3 = $subtotal3+$ejecutado4;
				$subtotal33 = number_format($subtotal3, 2);
				$subtotal4 = $subtotal4+$ejecutar1;
				$subtotal44 = number_format($subtotal4, 2);
				$z7 = str_replace(',','',$v7);
				$z7 = floatval($z7);
				$subtotal5 = $subtotal5+$z7;
				$subtotal55 = number_format($subtotal5, 2);
				$subtotal6 = $subtotal6+$ejecutado5;
				$subtotal66 = number_format($subtotal6, 2);
				$z9 = str_replace(',','',$v9);
				$z9 = floatval($z9);
				$subtotal7 = $subtotal7+$z9;
				$subtotal77 = number_format($subtotal7, 2);
				$subtotal8 = $subtotal8+$ejecutado6;
				$subtotal88 = number_format($subtotal8, 2);
			}
			$salida1 .= "<tr><td colspan='1' height='35'><center>&nbsp;</center></td><td width='12%' height='35'><center><b>SUBTOTAL</b></center></td><td width='10%' height='35' align='right'>".$subtotal11."&nbsp;</td><td width='3%' height='35'><center>&nbsp;</center></td><td width='10%' height='35' align='right'>".$subtotal22."&nbsp;</td>";
			$salida1 .= "<td width='10%' height='35' align='right'>".$subtotal33."&nbsp;</td><td width='10%' height='35' align='right'>".$subtotal44."&nbsp;</td><td width='10%' height='35' align='right'>".$subtotal55."&nbsp;</td><td width='10%' height='35' align='right'>".$subtotal66."&nbsp;</td><td width='10%' height='35' align='right'>".$subtotal77."&nbsp;</td><td width='10%' height='35' align='right'>".$subtotal88."&nbsp;</td></tr>";
			$valores .= "|SUBTOTAL|".$subtotal1."||".$subtotal2."|".$subtotal3."|".$subtotal4."|".$subtotal5."|".$subtotal6."|".$subtotal7."|".$subtotal8."|".$n_tipo."|#";
			$valores .= "||||||||||||#";
			$total1 = 0;
			$total2 = 0;
			$total3 = 0;
			$total4 = 0;
			$total5 = 0;
			$total6 = 0;
			$total7 = 0;
			$total8 = 0;
			$total9 = 0;
			$total10 = 0;
			$total11 = 0;
			$total12 = 0;
			$total13 = 0;
			$total14 = 0;
			$total15 = 0;
			$total16 = 0;
			$total17 = 0;
			$total18 = 0;
			$total19 = 0;
			$total20 = 0;
			$total21 = 0;
			$total22 = 0;
			$total23 = 0;
			$total24 = 0;
			$total25 = 0;
			$total26 = 0;
			$total27 = 0;
			$total28 = 0;
			$total29 = 0;
			$total30 = 0;
			$total31 = 0;
			$total32 = 0;
			$total33 = 0;
			$total34 = 0;
			$total35 = 0;
			$total36 = 0;
			$total37 = 0;
			$total38 = 0;
			$total39 = 0;
			$total40 = 0;
			$total41 = 0;
			$total42 = 0;
			$total43 = 0;
			$total44 = 0;
			$total45 = 0;
			$total46 = 0;
			$total47 = 0;
			$total48 = 0;
			$subtotal1 = 0;
			$subtotal2 = 0;
			$subtotal3 = 0;
			$subtotal4 = 0;
			$subtotal5 = 0;
			$subtotal6 = 0;
			$subtotal7 = 0;
			$subtotal8 = 0;
			$i++;
		}
		$salida1 .= "</table>";
		$salida1 .= "<script>$('input#buscar').quicksearch('table#t_contratos tbody tr');</script>";
	}
	$salida = new stdClass();
	$salida->salida = $salida1;
	$salida->valores = $valores;
	echo json_encode($salida);
}
// 07/02/2024 - Consulta techos transportes
// 12/02/2024 - Ajuste consulta de techos
// 15/02/2024 - Ajuste modificacion techos
// 23/02/2024 - Ajuste por creacion de tabla de configuracion de vehiculos
// 05/03/2024 - Ajuste techos inclusion tipo de combustible
// 21/03/2024 - Ajuste color tablas
// 02/04/2024 - Exportacion a excel de techos configurados
// 08/05/2024 - Ajuste independizar modulo de techos del administrador
// 15/05/2024 - Ajuste calculos
// 19/07/2024 - Ajuste consulta e inclusion de subtotales
// 29/07/2024 - Ajuste empadronamiento y calculos
// 11/12/2024 - Ajuste inclusion filtro de año
?>