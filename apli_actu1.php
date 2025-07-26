<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$mes = date('m');
if ($mes == "12")
{
  $mes = 1;
}
else
{
  $mes = $mes+1;
}
if (is_ajax())
{
	$actual = date('Y-m-d');
  $verifica = time();
  $alea = strtoupper(md5($verifica));
 	$alea = substr($alea,0,5);
	$conse = $_POST['conse'];
	$ano = $_POST['ano'];
	$unidad = $_POST['unidad'];
	$estado = $_POST['estado'];
	if ($estado == "F")
	{
		$estado = "C";
	}
	$valores1 = $_POST['valores1'];
	$valores2 = $_POST['valores2'];
	$valores3 = $_POST['valores3'];
	$valores4 = $_POST['valores4'];
	$motivo = trim($_POST['motivo']);
	$motivo = iconv("UTF-8", "ISO-8859-1", $motivo);
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$valor2 = $_POST['valor2'];
	$tipo = $_POST['tipo'];
	$responsable = trim($_POST['responsable']);
	$responsable = iconv("UTF-8", "ISO-8859-1", $responsable);
	$responsable0 = "»RESPONSABLE MISIÓN»";
	$responsable0 = iconv("UTF-8", "ISO-8859-1", $responsable0);
	if ($estado == "Y")
	{
		$responsable1 = "";
	}
	else
	{
		$responsable1 = $responsable.$responsable0;
	}
	$especial = $_POST['especial'];
	$firma = trim($_POST['firma']);
	$num_valores1 = explode("|",$valores1);
	for ($i=0;$i<count($num_valores1);++$i)
	{
		$a[$i] = trim($num_valores1[$i]);
	}
	$num_valores2 = explode("|",$valores2);
	for ($i=0;$i<count($num_valores2);++$i)
	{
		$b[$i] = trim($num_valores2[$i]);
	}
	$num_valores3 = explode("|",$valores3);
	for ($i=0;$i<count($num_valores3);++$i)
	{
		$c[$i] = trim($num_valores3[$i]);
	}
	$num_valores4 = explode("|",$valores4);
	for ($i=0;$i<count($num_valores4);++$i)
	{
		$d[$i] = trim($num_valores4[$i]);
	}
	// Se actualizan los valores aprobados o rechazados
	for ($i=0;$i<(count($num_valores1)-1);++$i)
	{
		$j=$i+1;
		// Se actualiza el valor aprobado o rechazados por mision
		$graba = "UPDATE cx_pla_gas SET valor_a='$a[$i]' WHERE conse1='$conse' AND interno='$j' AND ano='$ano'";
		odbc_exec($conexion, $graba);
	}
	for ($i=0;$i<(count($num_valores2)-1);++$i)
	{
		$k=$i+1;
		// Se actualiza el valor aprobado o rechazados por fuente
		$graba1 = "UPDATE cx_pla_pag SET val_fuen_a='$b[$i]' WHERE conse='$conse' AND conse1='$k' AND ano='$ano'";
		odbc_exec($conexion, $graba1);
	}
	// Se consulta datos para firmas
	$con = odbc_exec($conexion,"SELECT nombre, cargo, cedula FROM cx_usu_web WHERE usuario='$usu_usuario'");
	$v_nom = trim(utf8_encode(odbc_result($con,1)));
	$v_car = trim(utf8_encode(odbc_result($con,2)));
	$v_ced = trim(utf8_encode(odbc_result($con,3)));
	$v_fir = $v_nom."»".$v_car."»".$v_ced."»";
	$v_fir = iconv("UTF-8", "ISO-8859-1", $v_fir);
	$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_pla_fir)";
	// Se actualiza estado en la tabla cx_plan_inv y quien aprobo o rechazo
	if ($tipo == "2")
	{
		$preg = "SELECT estado, unidad, compania, recursos, usuario, especial FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano'";
		$sql = odbc_exec($conexion, $preg);
		$estado2 = trim(odbc_result($sql,1));
		$v_unidad = odbc_result($sql,2);
		$v_compa = odbc_result($sql,3);
		$v_compa = intval($v_compa);
		$v_recurso = odbc_result($sql,4);
		$v_usuario = trim(odbc_result($sql,5));
		$v_usuario1 = explode("_", $v_usuario);
		$v_usuario2 = $v_usuario1[0];
		$v_especial = odbc_result($sql,6);
		// Se consulta si la solicitud es de una unidad especial
		$preg3 = "SELECT especial FROM cx_org_sub WHERE unidad='$nun_usuario' AND unic='1'";
		$sql3 = odbc_exec($conexion, $preg3);
		$v_especial1 = odbc_result($sql3,1);
		if ($v_especial1 == "0")
		{
		}
		else
		{
			$v_especial1 = "1";
		}
		// Seguimiento de estados de la solicitud
  	$query_c0 = "(SELECT isnull(max(conse),0)+1 FROM cx_pla_est)";
  	$preg0 = "INSERT INTO cx_pla_est (conse, solicitud, ano, usuario, unidad, estado, usuario1) VALUES ($query_c0, '$conse', '$ano', '$usu_usuario', '$uni_usuario', '$estado2', '$valor')";
  	$sql0 = odbc_exec($conexion, $preg0);
  	//
		$preg1 = "SELECT tipo, unidad FROM cx_org_sub WHERE subdependencia='$v_unidad'";
		$sql1 = odbc_exec($conexion, $preg1);
		$v_unidad1 = odbc_result($sql1,1);
		$v_unidad2 = odbc_result($sql1,2);
		// Se pregunta por tipo de usuario
		$preg2 = "SELECT admin FROM cx_usu_web WHERE usuario='$valor'";
		$sql2 = odbc_exec($conexion, $preg2);
		$valor5 = odbc_result($sql2,1);
		$valor5 = intval($valor5);
		// Se se rechaza la solicitud
		if ($estado == "Y")
		{
			$graba2 = "UPDATE cx_pla_inv SET usuario2='', usuario3='', usuario4='', usuario5='', usuario6='', usuario7='', usuario8='', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', firma2='', firma3='', firma4='', firma5='', firma6='', firma7='', estado='$estado', recursos='0' WHERE conse='$conse' AND ano='$ano'";
		}
		else
		{
			// Si es Fudat o Coeej // Brigada o Batallon o Fuerza de Tarea
			if (($v_unidad == "6") or ($v_unidad == "7") or ($v_unidad1 == "7") or ($v_unidad1 == "8") or ($v_unidad1 == "9"))
			{
				if ($estado2 == "P")
				{
					$estado1 = "Q";
					if ($responsable == "")
					{
						$responsable1 = "";
					}
					$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario3='$valor', firma3='$v_fir', firma4='$responsable1', especial='$v_especial1' WHERE conse='$conse' AND ano='$ano'";
				}
				else
				{
					if ($v_unidad2 > 3)
					{
						if ($estado2 == "Q")
						{
							$estado1 = "R";
							$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario4='$valor' WHERE conse='$conse' AND ano='$ano'";
						}
						else
						{
							if ($estado2 == "R")
							{
								$estado1 = "S";
								$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario5='$valor' WHERE conse='$conse' AND ano='$ano'";
							}
							else
							{
								if ($estado2 == "S")
								{
									$estado1 = "A";
									$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario6='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
								}
								else
								{
									$estado1 = $estado;
									if ($estado2 == "C")
									{
										if ($valor5 == "10")
										{
											$estado3 = "W";
										}
										else
										{
											$estado3 = "M";
										}
										$graba2 = "UPDATE cx_pla_inv SET estado='$estado3', usuario10='$valor' WHERE conse='$conse' AND ano='$ano'";
									}
									else
									{
										if ($estado2 == "M")
										{
											$graba2 = "UPDATE cx_pla_inv SET estado='O', usuario12='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
										}
										else
										{
											if ($estado2 == "O")
											{
												if ($valor == "SPG_DIADI")
												{
													$graba2 = "UPDATE cx_pla_inv SET estado='L', usuario13='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
												}
												else
												{
													if ($v_especial == "1")
													{
														$valida1 = explode("_", $valor);
														$valida2 = trim($valida1[0]);
														if ($valida2 == "SGA")
														{
															$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario13='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
														}
														else
														{
															$graba2 = "UPDATE cx_pla_inv SET estado='T', usuario13='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
														}
													}
													else
													{
														$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario13='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
													}
												}
											}
											else
											{
												if ($v_especial == "1")
												{
													if ($estado2 == "T")
													{
														$graba2 = "UPDATE cx_pla_inv SET estado='U', usuario14='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
													}
													else
													{
														if ($estado2 == "U")
														{
															$graba2 = "UPDATE cx_pla_inv SET estado='V', usuario15='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
														}
														else
														{
															if ($estado2 == "V") 
															{
																if ($v_recurso == "1")
																{
																	$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario16='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																}
																else
																{
																	$graba2 = "UPDATE cx_pla_inv SET estado='L', usuario16='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																}
															}
															else
															{
																if ($estado2 == "B")
																{
																	$graba2 = "UPDATE cx_pla_inv SET estado='C', usuario8='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																}
																else
																{
																	$graba2 = "UPDATE cx_pla_inv SET estado='B', usuario7='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																}
															}
														}
													}
												}
												else
												{
													if ($estado1 == "B")
													{
														$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario7='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
													}
													else
													{
														$valida1 = explode("_", $valor);
														$valida2 = trim($valida1[0]);
														if ($estado1 == "C")
														{
															$valida3 = "0";
															if (strpos($comite, $uni_usuario) !== false)
															{
																$valida3 = "1";
															}
															if (($valor == "SPG_DIADI") and ($valida3 == "1"))
															{
																$graba2 = "UPDATE cx_pla_inv SET estado='L', usuario8='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
															}
															else
															{
																if (($valida2 == "SGA") and ($estado2 == "B"))
																{
																	$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario8='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																}
																else
																{
																	$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario8='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																}
															}
														}
														else
														{
															$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario4='$valor' WHERE conse='$conse' AND ano='$ano'";
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
					else
					{
						$estado1 = $estado;
						if ($estado1 == "B")
						{
							if ($estado2 == "A")
							{
								$graba2 = "UPDATE cx_pla_inv SET estado='B', usuario5='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
							}
							else
							{
								if ($estado2 == "J")
								{
									if (($valor == "JEM_CAIMI") or ($valor == "JEM_CACIM"))
									{
										$graba2 = "UPDATE cx_pla_inv SET estado='K', usuario8='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
									}
									else
									{
										if ($valor == "SPG_DIADI")
										{
											$graba2 = "UPDATE cx_pla_inv SET estado='L', usuario8='$valor' WHERE conse='$conse' AND ano='$ano'";
										}
										else
										{
											$graba2 = "UPDATE cx_pla_inv SET estado='K', usuario8='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
										}
									}
								}
								else
								{
									if ($estado2 == "K")
									{
										if (($valor == "CDO_CAIMI") or ($valor == "CDO_CACIM"))
										{
											$graba2 = "UPDATE cx_pla_inv SET estado='T', usuario9='$valor' WHERE conse='$conse' AND ano='$ano'";
										}
										else
										{
											if ($valor == "SPG_DIADI")
											{
												$graba2 = "UPDATE cx_pla_inv SET estado='L', usuario9='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
											}
											else
											{
												$graba2 = "UPDATE cx_pla_inv SET estado='I', usuario9='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
											}
										}
									}
									else
									{
										if ($estado2 == "I")
										{
											$valida1 = explode("_", $valor);
											$valida2 = trim($valida1[0]);
											if ($valida2 == "CDO")
											{
												if ($valor == "SPG_DIADI")
												{
													$graba2 = "UPDATE cx_pla_inv SET estado='L', usuario10='$valor' WHERE conse='$conse' AND ano='$ano'";
												}
												else
												{
													$graba2 = "UPDATE cx_pla_inv SET estado='T', usuario10='$valor' WHERE conse='$conse' AND ano='$ano'";
												}
											}
											else
											{
												$graba2 = "UPDATE cx_pla_inv SET estado='M', usuario10='$valor' WHERE conse='$conse' AND ano='$ano'";
											}
										}
										else
										{
											if ($estado2 == "M")
											{
												$graba2 = "UPDATE cx_pla_inv SET estado='N', usuario11='$valor' WHERE conse='$conse' AND ano='$ano'";
											}
											else
											{
												if ($estado2 == "N")
												{
													$graba2 = "UPDATE cx_pla_inv SET estado='O', usuario12='$valor' WHERE conse='$conse' AND ano='$ano'";
												}
												else
												{
													if ($estado2 == "O")
													{
														$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario13='$valor' WHERE conse='$conse' AND ano='$ano'";
													}
													else
													{
														if ($v_recurso == "1")
														{
															if (($v_usuario2 == "RIN") or ($v_usuario2 == "SAT"))
															{
																if ($estado2 == "D")
																{
																	$graba2 = "UPDATE cx_pla_inv SET estado='E', usuario8='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																}
																else
																{
																	if ($estado2 == "E")
																	{
																		$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario9='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																	}
																	else
																	{
																		$graba2 = "UPDATE cx_pla_inv SET estado='D', usuario7='$valor' WHERE conse='$conse' AND ano='$ano'";
																	}
																}
															}
															else
															{
																$valida1 = explode("_", $valor);
																$valida2 = trim($valida1[0]);
																if ($valida2 == "JEM")
																{
																	$graba2 = "UPDATE cx_pla_inv SET estado='D', usuario7='$valor' WHERE conse='$conse' AND ano='$ano'";
																}
																else
																{
																	if ($valida2 == "CDO")
																	{
																		$graba2 = "UPDATE cx_pla_inv SET estado='E', usuario8='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																	}
																	else
																	{
																		$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario9='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																	}
																}
															}
														}
														else
														{
															if ($valor == "SPG_DIADI")
															{
																$graba2 = "UPDATE cx_pla_inv SET estado='L', usuario11='$valor' WHERE conse='$conse' AND ano='$ano'";
															}
															else
															{
																if (($valor == "JEM_CAIMI") or ($valor == "JEM_CACIM"))
																{
																	$graba2 = "UPDATE cx_pla_inv SET estado='K', usuario7='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																}
																else
																{
																	if ($valor == "STE_DIADI")
																	{
																		if (($estado2 == "C") and ($usu_usuario == "JEF_CEDE2"))
																		{
																			$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario7='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																		}
																		else
																		{
																			$graba2 = "UPDATE cx_pla_inv SET estado='J', usuario7='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																		}
																	}
																	else
																	{
																		$graba2 = "UPDATE cx_pla_inv SET estado='J', usuario7='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
						else
						{
							if ($estado1 == "C")
							{
								if ($valor == "SPG_DIADI")
								{
									$graba2 = "UPDATE cx_pla_inv SET estado='L', usuario13='$valor' WHERE conse='$conse' AND ano='$ano'";
								}
								else
								{
									$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario6='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
								}
							}
							else
							{
								$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario4='$valor' WHERE conse='$conse' AND ano='$ano'";
							}
						}
					}
				}
			}
			else
			{
				$valida1 = explode("_", $valor);
				$valida2 = trim($valida1[0]);
				if ($valida2 == "CDO")
				{
					if ($v_especial1 == "1")
					{
						if ($adm_usuario == "11")
						{
							$graba2 = "UPDATE cx_pla_inv SET estado='A', usuario6='$valor', firma3='$v_fir', firma4='$responsable1', firma6='$v_fir', especial='$v_especial1' WHERE conse='$conse' AND ano='$ano'";
						}
						else
						{
							if ($adm_usuario == "12")
							{
								$graba2 = "UPDATE cx_pla_inv SET estado='O', usuario12='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
							}
						}
					}
					else
					{
						if ($v_especial == "1")
						{
							$graba2 = "UPDATE cx_pla_inv SET estado='O', usuario12='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
						}
						else
						{
							if ($adm_usuario == "12")
							{
								$graba2 = "UPDATE cx_pla_inv SET estado='J', usuario7='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
							}
							else
							{
								$graba2 = "UPDATE cx_pla_inv SET estado='J', usuario7='$valor', firma3='$v_fir', firma4='$responsable1', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
							}
						}
					}
				}
				else
				{
					if ($valida2 == "SGR")
					{
						if ($adm_usuario == "21")
						{
							$graba2 = "UPDATE cx_pla_inv SET estado='Q', usuario3='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
						}
						else
						{
							$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario8='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
						}
					}
					else
					{
						$estado1 = $estado;
						if ($estado1 == "B")
						{
					   	if ($valor == "SPG_DIADI")
							{
								$graba2 = "UPDATE cx_pla_inv SET estado='L', usuario8='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
							}
							else
							{
								if ($valor == "STE_DIADI")
								{
									if ($estado2 == "D")
									{
										$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario8='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
									}
									else
									{
										$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario7='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
									}
								}
								else
								{
									if ($valor5 == "10")
									{
										if ($v_especial == "1")
										{
											$graba2 = "UPDATE cx_pla_inv SET estado='B', usuario7='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
										}
										else
										{
											$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario10='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
										}
									}
									else
									{
										if ($valor == "JEF_CEDE2")
										{
											if ($adm_usuario == "17")
											{
												$graba2 = "UPDATE cx_pla_inv SET estado='D', usuario7='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
											}
											else
											{
												$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario5='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
											}
										}
										else
										{
											if ($v_especial == "1")
											{
												$graba2 = "UPDATE cx_pla_inv SET estado='M', usuario10='$valor' WHERE conse='$conse' AND ano='$ano'";
											}
											else
											{
												$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario5='$valor' WHERE conse='$conse' AND ano='$ano'";
											}
										}
									}
								}
							}
						}
						else
						{
							if ($estado1 == "C")
							{
								if ($valor == "STE_DIADI")
								{
									$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario6='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
								}
								else
								{
									if ($v_especial == "1")
									{
										if ($adm_usuario == "13")
										{
											if ($valor == "SPG_DIADI")
											{
												$graba2 = "UPDATE cx_pla_inv SET estado='L', usuario13='$valor' WHERE conse='$conse' AND ano='$ano'";
											}
											else
											{
												$graba2 = "UPDATE cx_pla_inv SET estado='W', usuario13='$valor', firma7='$v_fir' WHERE conse='$conse' AND ano='$ano'";
											}
										}
										else
										{
											$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario8='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
										}
									}
									else
									{
										$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario6='$valor', firma6='$v_fir' WHERE conse='$conse' AND ano='$ano'";
									}
								}
							}
							else
							{
								if ($responsable == "")
								{
									$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario4='$valor', firma3='$v_fir' WHERE conse='$conse' AND ano='$ano'";
								}
								else
								{
									$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', usuario4='$valor', firma3='$v_fir', firma4='$responsable1' WHERE conse='$conse' AND ano='$ano'";
								}
							}
						}
					}
				}
			}
		}
		// Se graba usuarios favoritos
		$preg_fav = "SELECT conse, favoritos FROM cx_usu_fav WHERE usuario='$usu_usuario'";
		$sql_fav = odbc_exec($conexion, $preg_fav);
		$con_fav = odbc_num_rows($sql_fav);
  	if ($con_fav == "0")
  	{
  		$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_usu_fav)";
  		$preg_fav1 = "INSERT INTO cx_usu_fav (conse, usuario, favoritos) VALUES ($query_c, '$usu_usuario','$valor')";
  		$sql_fav1 = odbc_exec($conexion, $preg_fav1);
  	}
  	else
  	{
			$preg_fav1 = "SELECT conse, favoritos FROM cx_usu_fav WHERE favoritos LIKE '%$valor%'";
			$sql_fav1 = odbc_exec($conexion, $preg_fav1);
			$con_fav1 = odbc_num_rows($sql_fav1);
  		if ($con_fav1 == "0")
  		{
	  		$conse_fav = odbc_result($sql_fav, 1);
				$favoritos = trim(odbc_result($sql_fav, 2));
				$num_favoritos = explode(",",$favoritos);
				if (count($num_favoritos < 5))
				{
					$favoritos .= ",".$valor;
	  			$preg_fav2 = "UPDATE cx_usu_fav SET favoritos='$favoritos' WHERE conse='$conse_fav' AND usuario='$usu_usuario'";
	  			$sql_fav2 = odbc_exec($conexion, $preg_fav2);
	  		}
			}
  	}
	}
	else
	{
		if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
		{
			$estado1 = $estado;
		}
		else
		{
			if ($adm_usuario == "6")
			{
				if ($estado == "Y")
				{
					$estado1 = $estado;
				}
				else
				{
					$estado1 = "E";
				}
			}
			else
			{
				if ($estado == "Y")
				{
					$estado1 = $estado;
				}
				else
				{
					if ($adm_usuario == "3")
					{
						$estado1 = "E";
					}
					else
					{
						$estado1 = "F";
					}
				}
			}
		}
		if ($estado == "Y")
		{
			$graba3 = "UPDATE cx_pla_pag SET val_fuen_a='0.00', val_fuen_c='0.00' WHERE conse='$conse' AND ano='$ano'";
			odbc_exec($conexion, $graba3);
			$graba4 = "UPDATE cx_pla_gas SET valor_a='0.00', valor_c='0.00' WHERE conse1='$conse' AND ano='$ano'";
			odbc_exec($conexion, $graba4);
		}
		if ($adm_usuario == "3")
		{
			$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', revisa='$con_usuario', firma3='$v_fir' WHERE conse='$conse' AND ano='$ano'";
		}
		else
		{
			$graba2 = "UPDATE cx_pla_inv SET estado='$estado1', aprueba='$con_usuario', firma4='$v_fir' WHERE conse='$conse' AND ano='$ano'";	
		}
	}
	$sql1 = odbc_exec($conexion, $graba2);
	//
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_est_soli.txt", "a");
	fwrite($file, $fec_log." # ".$graba2." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	// Se verifica el estado de grabacion
	$query1 = "SELECT estado, usuario FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano'";
	$cur = odbc_exec($conexion, $query1);
	$conse1 = odbc_result($cur,1);
	$usuario1 = trim(odbc_result($cur,2));
	$usuario2 = $usuario1;
	// Se crea notificacion
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
	$consecu = odbc_result($cur1,1);
	// Tipo de mensaje
	if ($tipo == "1")
	{
		$titulo = "<br>EL PLAN DE INVERSION ".$conse." DE ".$ano;
	}
	else
	{
		$titulo = "<br>LA SOLICITUD DE RECURSOS ".$conse." DE ".$ano;
	}
	if ($estado == "Y")
	{
		$mensaje = $titulo." HA SIDO RECHAZADO(A) POR: ".$motivo." POR EL USUARIO ".$usu_usuario.".<br><br>";
	}
	else
	{
		$mensaje = $titulo." HA SIDO APROBADO(A) POR EL USUARIO ".$usu_usuario.".<br><br>";
	}
	$query = "INSERT INTO cx_pla_rev (conse, usuario, unidad, estado, motivo, ano) VALUES ('$conse', '$usu_usuario', '$uni_usuario', '$estado', '$motivo', '$ano')";
	$sql = odbc_exec($conexion, $query);
	// Se graba notificacion
	if ($tipo == "2")
	{
		if ($estado == "C")
		{
			$mensaje = $titulo." HA SIDO VERIFICADA POR: ".$usu_usuario.". SE SOLICITA DAR VISTO BUENO DE LA ORDENACION.";
			$valor3 = $alea.$conse;
			$valor4 = encrypt1($valor3, $llave);
			$valor5 = encrypt1($ano, $llave);
			$nom_pdf = "»ver_soli.php?val=".$valor4."&val1=".$valor5."»";
			$nom_pdf1 = '<br><br><button type="button" name="solicita" id="solicita" class="btn btn-block btn-primary btn-mensaje" onclick="mensaje2('.$nom_pdf.');"><font face="Verdana" size="3">Visualizar Solicitud</font></button><br>';
			$mensaje .= $nom_pdf1;
			$mensaje = iconv("UTF-8", "ISO-8859-1", $mensaje);
		}
		else
		{
			if ($estado == "Y")
			{
				$mensaje = $titulo." HA SIDO RECHAZADA POR: ".strtoupper($motivo)." POR EL USUARIO ".$usu_usuario.".";
				$valor = $v_usuario;
			}
			else
			{
				if (($estado == "Q") or ($estado == "R") or ($estado == "S"))
				{
					$mensaje = $titulo." HA SIDO APROBADO(A) POR EL USUARIO ".$usu_usuario.".";
				}
				else
				{
					$mensaje = $titulo." HA SIDO REVISADO(A) POR EL USUARIO ".$usu_usuario.".";
					if ($estado == "B")
					{
						if ($estado2 == "E")
						{
						}
						else
						{
							$mensaje .= " SE SOLICITA DAR VISTO BUENO DE LA ORDENACION.";
						}
					}
					if ($estado2 == "E")
					{
						$mensaje .= " SE SOLICITA PROCEDER A REALIZAR EL COMPROBANTE DE EGRESO.";
					}
				}
			}
			$valor3 = $alea.$conse;
			$valor4 = encrypt1($valor3, $llave);
			$valor5 = encrypt1($ano, $llave);
			$nom_pdf = "»ver_soli.php?val=".$valor4."&val1=".$valor5."»";
			$nom_pdf1 = '<br><br><button type="button" name="solicita" id="solicita" class="btn btn-block btn-primary btn-mensaje" onclick="mensaje2('.$nom_pdf.');"><font face="Verdana" size="3">Visualizar Solicitud</font></button><br>';
			$mensaje .= $nom_pdf1;
			$mensaje = iconv("UTF-8", "ISO-8859-1", $mensaje);
		}
		if ($valor == "")
		{
			$valor = $usuario1;
		}
		$pregunta = "SELECT unidad FROM cx_usu_web WHERE usuario='$valor'";
		$cur1 = odbc_exec($conexion, $pregunta);
		$unidad1 = odbc_result($cur1,1);
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$valor', '$unidad1', '$mensaje', '$estado', '1')";
		$sql2 = odbc_exec($conexion, $query2);
		$usuario1 = $valor;
		// Segunda notificacion
    	$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_notifica)";
		$mensaje1 = $titulo." FUE ENVIADA A: ".$valor."<br><br>";
		$query_m = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ($query_c, '$usu_usuario', '$uni_usuario', '$usu_usuario', '$uni_usuario', '$mensaje1', 'S', '1')";
		odbc_exec($conexion, $query_m);
	}
	else
	{
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad', '$mensaje', '$estado', '1')";
		$sql2 = odbc_exec($conexion, $query2);
		if (($adm_usuario == "3") or ($adm_usuario == "6"))
		{
			if ($estado == "A")
			{
				if ($adm_usuario == "3")
				{
					if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
					{
						$n_admin = "27";
					}
					else
					{
						$n_admin = "4";
					}
				}
				if ($adm_usuario == "6")
				{
					$n_admin = "7";
				}
		   	$query3 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='$n_admin'";
		   	$sql3 = odbc_exec($conexion,$query3);
		   	$usuario1 = trim(odbc_result($sql3,1));
		   	$unidad1 = $uni_usuario;
		   	$mensaje1 = $titulo." HA SIDO APROBADO(A) POR EL USUARIO ".$usu_usuario.".<br><br>";
				$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
				$consecu1 = odbc_result($cur2,1);
				$query4 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad1', '$mensaje1', '$estado', '1')";
				$sql4 = odbc_exec($conexion,$query4);
				if ($adm_usuario == "3")
				{
					$query5 = "UPDATE cx_pla_inv SET usuario3='$usuario1' WHERE conse='$conse' AND ano='$ano'";
					$sql5 = odbc_exec($conexion,$query5);
				}
				// Se graba segunda notificación al usuario que aprueba el plan / solicitud
				$cur3 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
				$consecu2 = odbc_result($cur3,1);
				$mensaje2 = $titulo." HA SIDO ENVIADO(A) AL USUARIO ".$usuario1.".<br><br>";
				$query6 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu2', '$usu_usuario', '$uni_usuario', '$usu_usuario', '$uni_usuario', '$mensaje2', 'S', '1')";
				$sql6 = odbc_exec($conexion,$query6);
			}
		}
		if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
		{
		}
		else
		{
			if ($adm_usuario == "4")
			{
				$consu1 = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
				$cur1 = odbc_exec($conexion, $consu1);
				$unidad = odbc_result($cur1,1);
				$depen = odbc_result($cur1,2);
				if (($nun_usuario == "13") or ($nun_usuario == "14") or ($nun_usuario == "15") or ($nun_usuario == "16"))
				{
					$consu2 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$depen' AND unic='1'";
					$cur2 = odbc_exec($conexion, $consu2);
					$unidad1 = odbc_result($cur2,1);
					$n_admin = "10";
					// Se graba en la tabla cx_val_aut
					$pre0 = "SELECT conse, unidad, usuario FROM cx_pla_inv WHERE conse='$conse' AND periodo='$mes' AND ano='$ano' AND estado='F' AND tipo='1'";
					$con0 = odbc_exec($conexion,$pre0);
		    	$p0 = trim(odbc_result($con0,3));
		    	$p1 = odbc_result($con0,1);
		   		$p2 = odbc_result($con0,2);
					$pre1 = "SELECT sigla, dependencia, unidad, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$p2'";
					$con1 = odbc_exec($conexion,$pre1);
					$p3 = trim(odbc_result($con1,1));
					// Validacion cambio de sigla
					$p3_1 = trim(odbc_result($con1,4));
					$p3_2 = trim(odbc_result($con1,5));
					if ($p3_2 == "")
					{
					}
					else
					{
						$p3_2 = str_replace("/", "-", $p3_2);
						if ($actual >= $p3_2)
						{
							$p3 = $p3_1;
						}
					}
					$pre2 = "SELECT valor_a FROM cx_pla_gas WHERE conse1='$p1' AND ano='$ano'";
					$con2 = odbc_exec($conexion,$pre2);
					$p4 = trim(odbc_result($con2,1));
				  $p4 = str_replace(',','',$p4);
					$p4 = floatval($p4);
					$pre3 = "SELECT val_fuen_a FROM cx_pla_pag WHERE conse='$p1' AND ano='$ano'";
					$con3 = odbc_exec($conexion,$pre3);
					$p9 = 0;
		   		while($k<$row=odbc_fetch_array($con3))
		   		{
						$p5 = trim(odbc_result($con3,1));
					  $p5 = str_replace(',','',$p5);
					  $p5 = floatval($p5);
					 	$p9 = $p9+$p5;
					}
					$p6 = $p4+$p9;
				  $p7 = trim(odbc_result($con1,2));
					$p8 = trim(odbc_result($con1,3));
					$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_val_aut");
					$consecu1 = odbc_result($cur,1);
					// Se graba discriminado de gastos
					$graba = "INSERT INTO cx_val_aut (conse, usuario, unidad, periodo, ano, sigla, gastos, pagos, total, depen, uom, estado, aprueba) VALUES ('$consecu1', '$p0', '$p2', '$mes', '$ano', '$p3', '$p4', '$p9', '$p6', '$p7', '$p8', 'V', '$usu_usuario')";
					$cur9 = odbc_exec($conexion, $graba);
				}
				else
				{
					$consu2 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$depen' AND unic='2'";
					$cur2 = odbc_exec($conexion, $consu2);
					$unidad1 = odbc_result($cur2,1);
					$n_admin = "6";
				}
				$query3 = "SELECT usuario FROM cx_usu_web WHERE unidad='$unidad1' AND admin='$n_admin'";
			  $sql3 = odbc_exec($conexion,$query3);
			  $usuario1 = trim(odbc_result($sql3,1));
				$mensaje1 = $titulo." HA SIDO APROBADO(A) POR EL USUARIO ".$usu_usuario.". SE SOLICITA REVISION DEL MISMO.";
				$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
				$consecu1 = odbc_result($cur2,1);
				// Se graba notificacion
				if ($estado == "Y")
				{
				}
				else
				{
					$query4 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad1', '$mensaje1', '$estado', '1')";
					$sql4 = odbc_exec($conexion,$query4);
				}
			}
		}
		if ($adm_usuario == "7")
		{
			if ($estado == "D")
			{
		  	$query5 = "SELECT dependencia, unidad FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
		    $cur5 = odbc_exec($conexion, $query5);
		    $depen = odbc_result($cur5,1);
		    $uom = odbc_result($cur5,2);
		    // Se consulta dependencia
		  	$query6 = "SELECT nombre FROM cx_org_dep WHERE dependencia='$depen'";
		    $cur6 = odbc_exec($conexion, $query6);
		    $n_depen = trim(odbc_result($cur6,1));
		    // Se consulta unidad
		    $query7 = "SELECT nombre FROM cx_org_uni WHERE unidad='$uom'";
		    $cur7 = odbc_exec($conexion, $query7);
		    $n_uom = trim(odbc_result($cur7,1));
		    // Se consulta unidad del plan
		    $query8 = "SELECT unidad FROM cx_pla_inv WHERE conse='$conse'";
		    $cur8 = odbc_exec($conexion, $query8);
		    $n_unidad1 = odbc_result($cur8,1);
		    // Se consulta valores
		    $query9 = "SELECT gastos_a, pagos_a, total_a, sigla FROM cv_inv_cent3 WHERE unidad='$n_unidad1' AND periodo='$mes' AND ano='$ano'";
		    $cur9 = odbc_exec($conexion, $query9);
		    $gastos = odbc_result($cur9,1);
		    $pagos = odbc_result($cur9,2);
		    $total = odbc_result($cur9,3);
		    $sigla = trim(odbc_result($cur9,4));
		    // Validacion cambio de sigla
		    $query10 = "SELECT sigla1, fecha FROM cx_org_sub WHERE sigla='$sigla'";
		    $cur10 = odbc_exec($conexion, $query10);
				$p3_1 = trim(odbc_result($cur10,1));
				$p3_2 = trim(odbc_result($cur10,2));
				if ($p3_2 == "")
				{
				}
				else
				{
					$p3_2 = str_replace("/", "-", $p3_2);
					if ($actual >= $p3_2)
					{
						$sigla = $p3_1;
					}
				}
		    // Se graba en la tabla cx_val_aut
				$sql10 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_val_aut");
				$consecu2 = odbc_result($sql10,1);
				$graba = "INSERT INTO cx_val_aut (conse, usuario, unidad, periodo, ano, sigla, gastos, pagos, total, depen, n_depen, uom, n_uom) VALUES ('$consecu2', '$usu_usuario', '$n_unidad1', '$mes', '$ano', '$sigla', '$gastos', '$pagos', '$total', '$depen', '$n_depen', '$uom', '$n_uom')";
				$sql11 = odbc_exec($conexion,$graba);
				$n_admin = "9";
		  	$query3 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='$n_admin'";
		    $sql3 = odbc_exec($conexion,$query3);
		   	$usuario1 = trim(odbc_result($sql3,1));
		   	$unidad1 = $uni_usuario;
				$visto1 = '<input type="button" name="visto_'.$conse.'" id="visto_'.$conse.'" value="Visto Bueno" onclick="visto1('.$conse.');">';
				$link1 = '<a href="./fpdf/638.php?conse='.$conse.'"><img src="imagenes/pdf.png" border="0" title="Visualizar"></a>';
		    $mensaje1 = "<br>SE HA APROBADO EL PLAN / SOLICITUD CON EL NUMERO ".$conse."&nbsp;&nbsp;&nbsp;".$link1."<br><br>";
		   	$mensaje1 .= "<br>SE SOLICITA VISTO BUENO DE LA ORDENACION &nbsp;&nbsp;&nbsp;".$visto1."<br><br>";
				$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
				$consecu1 = odbc_result($cur2,1);
				$query4 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad1', '$mensaje1', '$estado', '1')";
				$sql4 = odbc_exec($conexion,$query4);
			}
		}
	}
	if ($estado == "Y")
	{
    $notifica = $usuario2;
	}
	else
	{
    $notifica = $usuario1;
	}
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse1;
	$salida->notifica = $notifica;
	$salida->tipou = $v_unidad1;
	echo json_encode($salida);
}
// 10/08/2023 - Ajuste de cambio de sigla validando la fecha actual
// 05/04/2024 - Ajuste responsable misión
// 22/04/2024 - Ajuste envio usuarios automatico en solicitudes de recursos
// 24/05/2024 - Ajuste CACIM sin recursos unidad solicitante
// 30/09/2024 - Ajuste retiro limpiar usuario1 en rechazo
// 07/11/2024 - Ajuste rechazo no eliminar firma1
// 24/01/2025 - Ajuste firma responsable
// 28/02/2025 - Ajuste DINCI
?>