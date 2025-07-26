<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
  	$mes = date('m');
  	$mes = intval($mes);
  	$n_ordop = $_POST['n_ordop'];
  	list($var1, $var2) = explode(" ", $n_ordop);
	$var1 = trim($var1);
	if ($var1 == "«")
	{
		$var1 = "";
	}
	$var1 = str_replace("«", "", $var1);
  	$var1 = iconv("UTF-8", "ISO-8859-1", $var1);
	$mision = $_POST['mision'];
	$mision = iconv("UTF-8", "ISO-8859-1", $mision);
	$mision1 = $_POST['mision1'];
	$mision2 = trim($_POST['mision2']);
	$var_misiones = explode("|", $mision2);
	$var_misiones1 = trim($var_misiones[0]);
	$var_misiones2 = count($var_misiones)-1;
	$var_valores = explode("¬", $var_misiones1);
	$var_valores1 = count($var_valores);
	if ($var_valores1 == "3")
	{
		$var3 = trim($var_valores[0]);
		$var4 = trim($var_valores[1]);
		$var5 = trim($var_valores[2]);
	}
	else
	{
		$var3 = trim($var_valores[0])."-".trim($var_valores[1]);
		$var4 = trim($var_valores[2]);
		$var5 = trim($var_valores[3]);
	}
	$num_misiones = explode("|", $mision2);
	$num_misiones1 = count($num_misiones);
	for ($i=0; $i<$num_misiones1-1; ++$i)
	{
		$paso = $num_misiones[$i];
		$num_valores = explode("¬", $paso);
		$num_valores1 = count($num_valores);
		if ($num_valores1 == "3")
		{
			$var6 .= trim($num_valores[0]).",";
			$var7 .= trim($num_valores[1]).",";
			$var8 .= trim($num_valores[2]).",";
		}
		else
		{
			$var6 .= trim($num_valores[0])."-".trim($num_valores[1]).",";
			$var7 .= trim($num_valores[2]).",";
			$var8 .= trim($num_valores[3]).",";
		}
	}
	$var6 = substr($var6,0,-1);
	$var7 = substr($var7,0,-1);
	$var8 = substr($var8,0,-1);
	$var6 = iconv("UTF-8", "ISO-8859-1", $var6);
	$responsable = trim($_POST['responsable']);
	$responsable = iconv("UTF-8", "ISO-8859-1", $responsable);
	$comandante = trim($_POST['comandante']);
	$comandante1 = trim($_POST['comandante1']);
	$comandante2 = $comandante."»".$comandante1;
	$comandante2 = iconv("UTF-8", "ISO-8859-1", $comandante2);
	$tipo = $_POST['tipo'];
	$comprobante = $_POST['comprobante'];
	$comprobante1 = $_POST['comprobante1'];
	$conceptos = $_POST['conceptos'];
	$valores = $_POST['valores'];
	$valores1 = $_POST['valores1'];
	$tipoc = $_POST['tipoc'];
	$conceptos1 = $_POST['conceptos1'];
	$valores2 = $_POST['valores2'];
	$valores3 = $_POST['valores3'];
	$tipoc1 = $_POST['tipoc1'];
	$total = $_POST['t_sol'];
	$total1 = $_POST['t_sol1'];
	$total2 = $_POST['t_sol2'];
	$total3 = $_POST['t_sol3'];
	$centra = $_POST['centra'];
	$periodo = $_POST['periodo'];
	$bienes = $_POST['bienes'];
	$informacion = $bienes;
	$combustible = $_POST['combustible'];
	$combustible = iconv("UTF-8", "ISO-8859-1", $combustible);
	$combustiblea = $_POST['combustiblea'];
	$combustiblea = iconv("UTF-8", "ISO-8859-1", $combustiblea);
	$grasas = $_POST['grasas'];
	$grasas = iconv("UTF-8", "ISO-8859-1", $grasas);
	$mantenimiento = $_POST['mantenimiento'];
	$mantenimiento = iconv("UTF-8", "ISO-8859-1", $mantenimiento);
	$mantenimientoa = $_POST['mantenimientoa'];
	$mantenimientoa = iconv("UTF-8", "ISO-8859-1", $mantenimientoa);
	$tecnico = $_POST['tecnico'];
	$tecnico = iconv("UTF-8", "ISO-8859-1", $tecnico);
	$tecnicoa = $_POST['tecnicoa'];
	$tecnicoa = iconv("UTF-8", "ISO-8859-1", $tecnicoa);
	$llantas = $_POST['llantas'];
	$llantas = iconv("UTF-8", "ISO-8859-1", $llantas);
	$llantasa = $_POST['llantasa'];
	$llantasa = iconv("UTF-8", "ISO-8859-1", $llantasa);
	$facturas = $_POST['facturas'];
	$elaboro = $_POST['elaboro'];
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$reviso = $_POST['reviso'];
	$reviso = iconv("UTF-8", "ISO-8859-1", $reviso);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$ciudad = $_POST['ciudad'];
	$ciudad = strtr(trim($ciudad), $sustituye);
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	// Se extraen las datos por separado para grabar
	$num_conceptos = explode("|",$conceptos);
	for ($i=0;$i<count($num_conceptos);++$i)
	{
		$a[$i] = trim($num_conceptos[$i]);
	}
	$num_valores = explode("|",$valores);
	for ($i=0;$i<count($num_valores);++$i)
	{
		$b[$i] = trim($num_valores[$i]);
	}
	$num_valores1 = explode("|",$valores1);
	for ($i=0;$i<count($num_valores1);++$i)
	{
		$c[$i] = trim($num_valores1[$i]);
	}
	$num_tipoc = explode("|",$tipoc);
	for ($i=0;$i<count($num_tipoc);++$i)
	{
		$d[$i] = trim($num_tipoc[$i]);
	}
	// Se extraen las datos de reintegros por separado para grabar
	$num_conceptos1 = explode("|",$conceptos1);
	for ($i=0;$i<count($num_conceptos1);++$i)
	{
		$e[$i] = trim($num_conceptos1[$i]);
	}
	$num_valores2 = explode("|",$valores2);
	for ($i=0;$i<count($num_valores2);++$i)
	{
		$f[$i] = trim($num_valores2[$i]);
	}
	$num_valores3 = explode("|",$valores3);
	for ($i=0;$i<count($num_valores3);++$i)
	{
		$g[$i] = trim($num_valores3[$i]);
	}
	$num_tipoc1 = explode("|",$tipoc1);
	for ($i=0;$i<count($num_tipoc1);++$i)
	{
		$h[$i] = trim($num_tipoc1[$i]);
	}
	// Se validan datos en blanco
	if ((trim($usuario) == "") or (trim($ciudad) == ""))
	{
		$conse2 = 0;
	}
	else
	{
		$cur = odbc_exec($conexion,"SELECT rel_gas FROM cx_org_sub WHERE subdependencia='$centra'");
		$consecu = odbc_result($cur,1);
		$consecu = $consecu+1;
		// Se verifica para no grabar doble relacion
		$consu = "SELECT TOP 1 fecha FROM cx_rel_gas WHERE usuario='$usuario' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano' ORDER BY fecha DESC";
		$sql = odbc_exec($conexion, $consu);
		$v_fecha1 = odbc_result($sql,1);
		$v_fecha1 = substr($v_fecha1,0,15);
		$v_fecha2 = date("Y-m-d H:i");
		$v_fecha2 = substr($v_fecha2,0,-1);
		if ($v_fecha1 == $v_fecha2)
		{
			$conse2 = 0;
			$interno = 0;
			$error = "1";
			// Se graba log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_rel_gas_doble.txt", "a");
			fwrite($file, $fec_log." # ".$v_fecha1." # ".$v_fecha2." # ".$consu." # ".PHP_EOL);
			fclose($file);
		}
		else
		{
			// Se graba encabezado de planilla
			$graba = "INSERT INTO cx_rel_gas (conse, usuario, unidad, ciudad, comprobante, ordop, n_ordop, mision, periodo, ano, total, csoporte, ssoporte, responsable, tipo, numero, consecu, comandante, elaboro, reintegro, contador, comprobantes, numeros, consecus, reviso) VALUES ('$consecu', '$usuario', '$unidad', '$ciudad', '$comprobante', '$mision', '$var1', '$var6', '$periodo', '$ano', '$total', '$total1', '$total2', '$responsable', '$tipo', '$var5', '$var4', '$comandante2', '$elaboro', '$total3', '$var_misiones2', '$comprobante1', '$var8', '$var7', '$reviso')";
			if (!odbc_exec($conexion, $graba))
			{
		    	$confirma = "0";
			}
			else
			{
				$confirma = "1";
			}
			if ($confirma == "1")
			{
				// Se actualiza planilla de unidad centralizadora
				$cur1 = odbc_exec($conexion,"UPDATE cx_org_sub SET rel_gas='$consecu' WHERE subdependencia='$centra'");
				for ($i=0;$i<(count($num_conceptos)-1);++$i)
				{
					if ($a[$i] == "0")
					{
					}
					else
					{
						$z=$i+1;
						$v_gasto = $a[$i];
						switch ($v_gasto)
						{
							case '36':
								$datos = $combustible;
								$v_tecnico = utf8_encode($combustible);
								$num_tecnico = explode("|", $v_tecnico);
								$j = 0;
								for ($k=0;$k<(count($num_tecnico)-1);++$k)
								{
									$j = $k+1;
									$v[$k] = $num_tecnico[$k];
									$num_tecnico1 = explode("»", $v[$k]);
									for ($m=0;$m<(count($num_tecnico1)-1);++$m)
									{
										$v_tecnico1 = $num_tecnico1[0];
										$v_tecnico2 = $num_tecnico1[1];
										$v_tecnico3 = $num_tecnico1[2];
										$v_tecnico4 = $num_tecnico1[3];
										$v_tecnico5 = $num_tecnico1[4];
										$v_tecnico6 = $num_tecnico1[5];
										$v_tecnico7 = $num_tecnico1[6];
										$v_tecnico5 = iconv("UTF-8", "ISO-8859-1", $v_tecnico5);
									}
									$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_tra_mor)";
									$gra_tec1 = "INSERT INTO cx_tra_mor (conse, usuario, unidad, tipo, placa, fec_mov, valor, valor1, observaciones, alea, sigla, factura) VALUES ($query_c, '$usuario', '$unidad', '$v_gasto', '$v_tecnico2', getdate(), '$v_tecnico3', '$v_tecnico4', '$v_tecnico5', '$v_tecnico6', '$v_tecnico7', '')";
									odbc_exec($conexion, $gra_tec1);
									// Se graba log
									$fec_log = date("d/m/Y H:i:s a");
									$file = fopen("log_combustible1.txt", "a");
									fwrite($file, $fec_log." # ".$gra_tec1." # ".$usu_usuario." # ".PHP_EOL);
									fclose($file);
								}
								break;
							case '37':
								$datos = $grasas;
								$v_tecnico = utf8_encode($grasas);
								$num_tecnico = explode("|", $v_tecnico);
								$j = 0;
								for ($k=0;$k<(count($num_tecnico)-1);++$k)
								{
									$j = $k+1;
									$v[$k] = $num_tecnico[$k];
									$num_tecnico1 = explode("»", $v[$k]);
									for ($m=0;$m<(count($num_tecnico1)-1);++$m)
									{
										$v_tecnico1 = $num_tecnico1[0];
										$v_tecnico2 = $num_tecnico1[1];
										$v_tecnico3 = $num_tecnico1[2];
										$v_tecnico4 = $num_tecnico1[3];
										$v_tecnico5 = $num_tecnico1[4];
										$v_tecnico6 = $num_tecnico1[5];
										$v_tecnico7 = $num_tecnico1[6];
										$v_tecnico8 = $num_tecnico1[7];
										$v_tecnico9 = $num_tecnico1[8];
										$v_tecnico10 = $num_tecnico1[9];
										$v_tecnico11 = $num_tecnico1[10];
										$v_tecnico12 = $num_tecnico1[11];
										$v_tecnico13 = $num_tecnico1[12];
										$v_tecnico14 = $num_tecnico1[13];
										$v_tecnico15 = $num_tecnico1[14];
										$v_tecnico16 = $num_tecnico1[15];
										$v_tecnico17 = $num_tecnico1[16];
										$v_tecnico18 = $num_tecnico1[17];
										$v_tecnico19 = $num_tecnico1[18];
										$v_tecnico20 = $v_tecnico15."|".$v_tecnico3."|".$v_tecnico5."|".$v_tecnico7."|".$v_tecnico8."|".$v_tecnico10."|".$v_tecnico12;
										$v_tecnico20 = iconv("UTF-8", "ISO-8859-1", $v_tecnico20);
									}
									$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_tra_mor)";
									$gra_tec1 = "INSERT INTO cx_tra_mor (conse, usuario, unidad, tipo, placa, fec_mov, valor, valor1, observaciones, alea, sigla, factura) VALUES ($query_c, '$usuario', '$unidad', '$v_gasto', '$v_tecnico2', '$v_tecnico16', '$v_tecnico13', '$v_tecnico14', '$v_tecnico20', '$v_tecnico18', '$v_tecnico19', '$v_tecnico17')";
									odbc_exec($conexion, $gra_tec1);
									// Se graba log
									$fec_log = date("d/m/Y H:i:s a");
									$file = fopen("log_grasas1.txt", "a");
									fwrite($file, $fec_log." # ".$gra_tec1." # ".$usu_usuario." # ".PHP_EOL);
									fclose($file);
								}
								break;
							case '38':
								$datos = $mantenimiento;
								$v_tecnico = utf8_encode($mantenimiento);
								$num_tecnico = explode("|", $v_tecnico);
								$j = 0;
								for ($k=0;$k<(count($num_tecnico)-1);++$k)
								{
									$j = $k+1;
									$v[$k] = $num_tecnico[$k];
									$num_tecnico1 = explode("»", $v[$k]);
									for ($m=0;$m<(count($num_tecnico1)-1);++$m)
									{
										$v_tecnico1 = $num_tecnico1[0];
										$v_tecnico2 = $num_tecnico1[1];
										$v_tecnico3 = $num_tecnico1[2];
										$v_tecnico4 = $num_tecnico1[3];
										$v_tecnico5 = $num_tecnico1[4];
										$v_tecnico6 = $num_tecnico1[5];
										$v_tecnico7 = $num_tecnico1[6];
										$v_tecnico8 = $num_tecnico1[7];
										$v_tecnico9 = $num_tecnico1[8];
										$v_tecnico10 = $num_tecnico1[9];
										$v_tecnico11 = $num_tecnico1[10];
										$v_tecnico12 = $num_tecnico1[11];
										$v_tecnico13 = $num_tecnico1[12];
										$v_tecnico14 = $num_tecnico1[13];
										$v_tecnico15 = $num_tecnico1[14];
										$v_tecnico16 = $num_tecnico1[15];
										$v_tecnico17 = $num_tecnico1[16];
										$v_tecnico18 = $num_tecnico1[17];
										$v_tecnico19 = $num_tecnico1[18];
										$v_tecnico20 = $num_tecnico1[19];
										$v_tecnico21 = $v_tecnico15."|".$v_tecnico18."|".$v_tecnico3."|".$v_tecnico5."|".$v_tecnico7."|".$v_tecnico8."|".$v_tecnico10."|".$v_tecnico12;
										$v_tecnico21 = iconv("UTF-8", "ISO-8859-1", $v_tecnico21);
									}
									$gra_tec = "UPDATE cx_pla_tra SET fec_man='$v_tecnico16' WHERE placa='$v_tecnico2'";
									odbc_exec($conexion, $gra_tec);
									// Se graba log
									$fec_log = date("d/m/Y H:i:s a");
									$file = fopen("log_mantenimiento.txt", "a");
									fwrite($file, $fec_log." # ".$gra_tec." # ".$usu_usuario." # ".PHP_EOL);
									fclose($file);
									//
									$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_tra_mor)";
									$gra_tec1 = "INSERT INTO cx_tra_mor (conse, usuario, unidad, tipo, placa, fec_mov, valor, valor1, observaciones, alea, sigla, factura) VALUES ($query_c, '$usuario', '$unidad', '$v_gasto', '$v_tecnico2', '$v_tecnico16', '$v_tecnico13', '$v_tecnico14', '$v_tecnico21', '$v_tecnico19', '$v_tecnico20', '$v_tecnico17')";
									odbc_exec($conexion, $gra_tec1);
									// Se graba log
									$fec_log = date("d/m/Y H:i:s a");
									$file = fopen("log_mantenimiento1.txt", "a");
									fwrite($file, $fec_log." # ".$gra_tec1." # ".$usu_usuario." # ".PHP_EOL);
									fclose($file);
								}
								break;
							case '39':
								$datos = $tecnico;
								$v_tecnico = utf8_encode($tecnico);
								$num_tecnico = explode("|", $v_tecnico);
								$j = 0;
								for ($k=0;$k<(count($num_tecnico)-1);++$k)
								{
									$j = $k+1;
									$v[$k] = $num_tecnico[$k];
									$num_tecnico1 = explode("»", $v[$k]);
									for ($m=0;$m<(count($num_tecnico1)-1);++$m)
									{
										$v_tecnico1 = $num_tecnico1[0];
										$v_tecnico2 = $num_tecnico1[1];
										$v_tecnico3 = $num_tecnico1[2];
										$v_tecnico4 = $num_tecnico1[3];
										$v_tecnico5 = $num_tecnico1[4];
										$v_tecnico6 = $num_tecnico1[5];
										$v_tecnico7 = $num_tecnico1[6];
										$v_tecnico8 = $num_tecnico1[7];
										$v_tecnico9 = $num_tecnico1[8];
										$v_tecnico10 = $num_tecnico1[9];
										$v_tecnico11 = $num_tecnico1[10];
										$v_tecnico12 = $num_tecnico1[11];
										$v_tecnico13 = $v_tecnico8."|".$v_tecnico3."|".$v_tecnico5;
										$v_tecnico13 = iconv("UTF-8", "ISO-8859-1", $v_tecnico13);
									}
									$gra_tec = "UPDATE cx_pla_tra SET fec_rtm='$v_tecnico9' WHERE placa='$v_tecnico2'";
									odbc_exec($conexion, $gra_tec);
									// Se graba log
									$fec_log = date("d/m/Y H:i:s a");
									$file = fopen("log_rtm.txt", "a");
									fwrite($file, $fec_log." # ".$gra_tec." # ".$usu_usuario." # ".PHP_EOL);
									fclose($file);
									//
									$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_tra_mor)";
									$gra_tec1 = "INSERT INTO cx_tra_mor (conse, usuario, unidad, tipo, placa, fec_mov, valor, valor1, observaciones, alea, sigla, factura) VALUES ($query_c, '$usuario', '$unidad', '$v_gasto', '$v_tecnico2', '$v_tecnico9', '$v_tecnico6', '$v_tecnico7', '$v_tecnico13', '$v_tecnico11', '$v_tecnico12', '$v_tecnico10')";
									odbc_exec($conexion, $gra_tec1);
									// Se graba log
									$fec_log = date("d/m/Y H:i:s a");
									$file = fopen("log_rtm1.txt", "a");
									fwrite($file, $fec_log." # ".$gra_tec1." # ".$usu_usuario." # ".PHP_EOL);
									fclose($file);
								}
								break;
							case '40':
								$datos = $llantas;
								$v_tecnico = utf8_encode($llantas);
								$num_tecnico = explode("|", $v_tecnico);
								$j = 0;
								for ($k=0;$k<(count($num_tecnico)-1);++$k)
								{
									$j = $k+1;
									$v[$k] = $num_tecnico[$k];
									$num_tecnico1 = explode("»", $v[$k]);
									for ($m=0;$m<(count($num_tecnico1)-1);++$m)
									{
										$v_tecnico1 = $num_tecnico1[0];
										$v_tecnico2 = $num_tecnico1[1];
										$v_tecnico3 = $num_tecnico1[2];
										$v_tecnico4 = $num_tecnico1[3];
										$v_tecnico5 = $num_tecnico1[4];
										$v_tecnico6 = $num_tecnico1[5];
										$v_tecnico7 = $num_tecnico1[6];
										$v_tecnico8 = $num_tecnico1[7];
										$v_tecnico9 = $num_tecnico1[8];
										$v_tecnico10 = $num_tecnico1[9];
										$v_tecnico11 = $num_tecnico1[10];
										$v_tecnico12 = $num_tecnico1[11];
										$v_tecnico13 = $num_tecnico1[12];
										$v_tecnico14 = $num_tecnico1[13];
										$v_tecnico15 = $num_tecnico1[14];
										$v_tecnico16 = $v_tecnico9."|".$v_tecnico10."|".$v_tecnico11."|".$v_tecnico3."|".$v_tecnico4."|".$v_tecnico6;
										$v_tecnico16 = iconv("UTF-8", "ISO-8859-1", $v_tecnico16);
									}
									$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_tra_mor)";
									$gra_tec1 = "INSERT INTO cx_tra_mor (conse, usuario, unidad, tipo, placa, fec_mov, valor, valor1, observaciones, alea, sigla, factura) VALUES ($query_c, '$usuario', '$unidad', '$v_gasto', '$v_tecnico2', '$v_tecnico12', '$v_tecnico7', '$v_tecnico8', '$v_tecnico16', '$v_tecnico14', '$v_tecnico15', '$v_tecnico13')";
									odbc_exec($conexion, $gra_tec1);
									// Se graba log
									$fec_log = date("d/m/Y H:i:s a");
									$file = fopen("log_llantas1.txt", "a");
									fwrite($file, $fec_log." # ".$gra_tec1." # ".$usu_usuario." # ".PHP_EOL);
									fclose($file);
								}
								break;
							case '42':
								$datos = $combustiblea;
								break;
							case '44':
								$datos = $mantenimientoa;
								break;
							case '45':
								$datos = $tecnicoa;
								break;
							case '46':
								$datos = $llantasa;
								break;
							default:
								$datos = "";
								break;
						}
						// Se graba discriminado de planilla de gastos
						$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse1 FROM cx_rel_dis");
						$conse1 = odbc_result($cur2,1);
						$graba1 = "INSERT INTO cx_rel_dis (conse, conse1, gasto, valor, valor1, tipo, consecu, tipo1, ano, datos) VALUES ('$conse1', '$consecu', '$a[$i]', '$b[$i]', '$c[$i]', '$d[$i]', '$var4', '', '$ano', '$datos')";
						odbc_exec($conexion, $graba1);
					}
				}
				// Reintegros
				for ($i=0;$i<(count($num_conceptos1)-1);++$i)
				{
					if ($e[$i] == "0")
					{
					}
					else
					{
						$z=$i+1;
						// Se graba discriminado de planilla de gastos
						$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse1 FROM cx_rel_dis");
						$conse1 = odbc_result($cur2,1);
						$graba1 = "INSERT INTO cx_rel_dis (conse, conse1, gasto, valor, valor1, tipo, consecu, tipo1, ano, datos) VALUES ('$conse1', '$consecu', '$e[$i]', '$f[$i]', '$g[$i]', '$h[$i]', '$var4', 'R', '$ano', '')";
						odbc_exec($conexion, $graba1);
					}
				}
				// Se obtiene compañia
				$valida1 = explode("_", $usuario);
				$valida2 = trim($valida1[1]);
				// Se valida que se grabe campo actual
				$query1 = "SELECT conse FROM cx_rel_gas WHERE conse='$consecu' AND ano='$ano' AND unidad='$uni_usuario'";
				$cur = odbc_exec($conexion, $query1);
				$conse2 = odbc_result($cur,1);
				// Se graba log
				$fec_log = date("d/m/Y H:i:s a");
				$file = fopen("log_rel_gas.txt", "a");
				fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
				fclose($file);
				// Se graban bienes
				$num_facturas = explode("|",$facturas);
				$num_bienes = explode("#",$bienes);
				$num_bienes1 = $num_bienes[0];
				$num_bienes2 = $num_bienes[1];
				$num_bienes3 = $num_bienes[2];
				$num_bienes4 = $num_bienes[3];
				$num_bienes5 = $num_bienes[4];
				$num_bienes6 = $num_bienes[5];
				$num_bienes7 = $num_bienes[6];
				$num_bienes8 = $num_bienes[7];
				$num_bienes9 = $num_bienes[8];
				$num_bienes10 = $num_bienes[9];
				$num_bienes11 = $num_bienes[10];
				$num_bienes12 = $num_bienes[11];
				$num_bienes13 = $num_bienes[12];
				$num_bienes14 = $num_bienes[13];
				$num_bienes15 = $num_bienes[14];
				$num_bienes16 = $num_bienes[15];
				$num_bienes17 = $num_bienes[16];
				$num_bienes18 = $num_bienes[17];
				$num_bienes19 = $num_bienes[18];
				$num_bienes20 = $num_bienes[19];
				$num_bienes21 = $num_bienes[20];
				$num_bienes22 = $num_bienes[21];
				$num_bienes23 = $num_bienes[22];
				$num_bienes24 = $num_bienes[23];
				$num_bienes25 = $num_bienes[24];
				$num_bienes26 = $num_bienes[25];
				$num_bien1 = explode("&",$num_bienes1);
				$num_bien2 = explode("&",$num_bienes2);
				$num_bien3 = explode("&",$num_bienes3);
				$num_bien4 = explode("&",$num_bienes4);
				$num_bien5 = explode("&",$num_bienes5);
				$num_bien6 = explode("&",$num_bienes6);
				$num_bien7 = explode("&",$num_bienes7);
				$num_bien8 = explode("&",$num_bienes8);
				$num_bien9 = explode("&",$num_bienes9);
				$num_bien10 = explode("&",$num_bienes10);
				$num_bien11 = explode("&",$num_bienes11);
				$num_bien12 = explode("&",$num_bienes12);
				$num_bien13 = explode("&",$num_bienes13);
				$num_bien14 = explode("&",$num_bienes14);
				$num_bien15 = explode("&",$num_bienes15);
				$num_bien16 = explode("&",$num_bienes16);
				$num_bien17 = explode("&",$num_bienes17);
				$num_bien18 = explode("&",$num_bienes18);
				$num_bien19 = explode("&",$num_bienes19);
				$num_bien20 = explode("&",$num_bienes20);
				$num_bien21 = explode("&",$num_bienes21);
				$num_bien22 = explode("&",$num_bienes22);
				$num_bien23 = explode("&",$num_bienes23);
				$num_bien24 = explode("&",$num_bienes24);
				$num_bien25 = explode("&",$num_bienes25);
				$num_bien26 = explode("&",$num_bienes26);
				for ($k=0;$k<(count($num_bien1)-1);++$k)
				{
					$v1 = $num_bien1[$k];
					$v2 = $num_bien2[$k];
					$v2 = iconv("UTF-8", "ISO-8859-1", $v2);
					$v3 = $num_bien3[$k];
					$v3 = strtoupper($v3);
					$v3 = iconv("UTF-8", "ISO-8859-1", $v3);
					$v4 = $num_bien4[$k];
					$v5 = $num_bien5[$k];
			        $v5_1 = trim($v5);
			        $v5_2 = str_replace(',','',$v5_1);
			        $v5_2 = substr($v5_2,0,-3);
			        $v5_2 = intval($v5_2);
					$v6 = $num_bien6[$k];
					$v6 = iconv("UTF-8", "ISO-8859-1", $v6);
					$v7 = $num_bien7[$k];
					$v7 = iconv("UTF-8", "ISO-8859-1", $v7);
					$v8 = $num_bien8[$k];
					$v8 = iconv("UTF-8", "ISO-8859-1", $v8);
					$v9 = $num_bien9[$k];
					$v9 = iconv("UTF-8", "ISO-8859-1", $v9);
					$v10 = $num_bien10[$k];
					$v11 = $num_bien11[$k];
					$v11 = iconv("UTF-8", "ISO-8859-1", $v11);
					$v12 = $num_bien12[$k];
					$v13 = $num_bien13[$k];
					$v14 = $num_bien14[$k];
					$v14 = iconv("UTF-8", "ISO-8859-1", $v14);
					$v15 = $num_bien15[$k];
					$v16 = $num_bien16[$k];
					if (($v16 == "") or ($v16 == "NaN"))
					{
						$v16 = "0";
					}
					$v17 = $num_bien17[$k];
					$v18 = $num_bien18[$k];
					$v18 = iconv("UTF-8", "ISO-8859-1", $v18);
					$v19 = $num_bien19[$k];
					$v20 = $num_bien20[$k];
					$v21 = $num_bien21[$k];
					$v22 = $num_bien22[$k];
					$v22 = iconv("UTF-8", "ISO-8859-1", $v22);
					$v23 = $num_bien23[$k];
					$v23 = iconv("UTF-8", "ISO-8859-1", $v23);
					$v24 = $num_bien24[$k];
					$v24 = iconv("UTF-8", "ISO-8859-1", $v24);
					$v25 = $num_bien25[$k];
					$v26 = $num_bien26[$k];
					// Se graba el detallado de gastos
					$cur3 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_bie");
					$consecu3 = odbc_result($cur3,1);
					$codigo3 = str_pad($consecu3,7,"0",STR_PAD_LEFT);
					$codigo3 = "A-GR-CA".$codigo3;
					$alea = $num_facturas[$k];
					if (($v5 == "NaN") or ($v5 == "") or ($v5 == "0.00"))
					{
					}
					else
					{
						$graba3 = "INSERT INTO cx_pla_bie (conse, usuario, codigo, clase, nombre, descripcion, fec_com, valor, valor1, marca, color, modelo, serial, soa_num, soa_ase, soa_fe1, soa_fe2, seg_cla, seg_val, seg_num, seg_ase, seg_fe1, seg_fe2, unidad, funcionario, ordop, mision, numero, relacion, compania, estado, egreso, ordop1, mision1, responsable, unidad_a, responsable1, importa, alea) VALUES ('$consecu3', '$usuario', '$codigo3', '$v1', '$v2', '$v3', '$v4', '$v5', '$v5_2', '$v6', '$v7', '$v8', '$v9', '$v10', '$v11', '$v12', '$v13', '$v14', '$v16', '$v17', '$v18', '$v19', '$v20', '$v21', '$v22', '$v23', '$v24', '$v25', '$consecu', '$valida2', '$v26', '$comprobante', '$v23', '$v24', '0', '0', '0', '', '$alea')";
						odbc_exec($conexion, $graba3);
						// Se graba log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_plan_bie.txt", "a");
						fwrite($file, $fec_log." # ".$graba3." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$informacion." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
			}
		}
	}
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse2;
	$salida->salida1 = $ano;
	echo json_encode($salida);
}
// 27/09/2023 - Validacion doble grabacion
?>