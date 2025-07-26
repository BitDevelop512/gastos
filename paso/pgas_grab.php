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
	$mision = $_POST['mision'];
	$mision = iconv("UTF-8", "ISO-8859-1", $mision);
	$mision1 = $_POST['mision1'];
	$mision2 = $_POST['mision2'];
	$num_valores = explode("¬", $mision2);
	$num_valores1 = count($num_valores);
	if ($num_valores1 == "3")
	{
		list($var3, $var4, $var5) = explode("¬", $mision2);
		$var3 = trim($var3);
	}
	else
	{
		list($var6, $var3, $var4, $var5) = explode("¬", $mision2);
		$var3 = trim($var6)."-".trim($var3);
	}
	$var3 = iconv("UTF-8", "ISO-8859-1", $var3);
	$var4 = trim($var4);
	$var5 = trim($var5);
	$adicional = $_POST['adicional'];
	$responsable = $_POST['responsable'];
	$responsable = iconv("UTF-8", "ISO-8859-1", $responsable);
	$responsable = strtr(trim($responsable), $sustituye);
	$cedulas = $_POST['cedulas'];
	$nombres = $_POST['nombres'];
	$ciudades = $_POST['ciudades'];
	$v1s = $_POST['v1s'];
	$v2s = $_POST['v2s'];
	$v3s = $_POST['v3s'];
	$valores = $_POST['valores'];
	$valores1 = $_POST['valores1'];
	$v4s = $_POST['v4s'];
	$total = $_POST['t_sol'];
	$tarifa1 = $_POST['tarifa1'];
	$tarifa2 = $_POST['tarifa2'];
	$tarifa3 = $_POST['tarifa3'];
	$centra = $_POST['centra'];
	$periodo = $_POST['periodo'];
	$elaboro = $_POST['elaboro'];
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$ciudad = $_POST['ciudad'];
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	// Se extraen las datos por separado para grabar
	$num_cedulas = explode("|",$cedulas);
	for ($i=0;$i<count($num_cedulas);++$i)
	{
		$a[$i] = trim($num_cedulas[$i]);
		$a[$i] = strtr(trim($a[$i]), $sustituye);
	}
	$num_nombres = explode("|",$nombres);
	for ($i=0;$i<count($num_nombres);++$i)
	{
		$b[$i] = trim($num_nombres[$i]);
		$b[$i] = iconv("UTF-8", "ISO-8859-1", $b[$i]);
		$b[$i] = strtr(trim($b[$i]), $sustituye);
	}
	$num_ciudades = explode("|",$ciudades);
	for ($i=0;$i<count($num_ciudades);++$i)
	{
		$c[$i] = trim($num_ciudades[$i]);
		$c[$i] = iconv("UTF-8", "ISO-8859-1", $c[$i]);
		$c[$i] = strtr(trim($c[$i]), $sustituye);
	}
	$num_v1s = explode("|",$v1s);
	for ($i=0;$i<count($num_v1s);++$i)
	{
		$d[$i] = trim($num_v1s[$i]);
	}
	$num_v2s = explode("|",$v2s);
	for ($i=0;$i<count($num_v2s);++$i)
	{
		$e[$i] = trim($num_v2s[$i]);
	}
	$num_v3s = explode("|",$v3s);
	for ($i=0;$i<count($num_v3s);++$i)
	{
		$f[$i] = trim($num_v3s[$i]);
	}
	$num_valores = explode("|",$valores);
	for ($i=0;$i<count($num_valores);++$i)
	{
		$g[$i] = trim($num_valores[$i]);
	}
	$num_valores1 = explode("|",$valores1);
	for ($i=0;$i<count($num_valores1);++$i)
	{
		$h[$i] = trim($num_valores1[$i]);
	}
	$num_v4s = explode("|",$v4s);
	for ($i=0;$i<count($num_v4s);++$i)
	{
		$k[$i] = trim($num_v4s[$i]);
	}
	// Se validan datos en blanco
	$error = 0;
	if ((trim($usuario) == "") or (trim($ciudad) == ""))
	{
		$conse2 = 0;
		$interno = 0;
	}
	else
	{
		$query = "SELECT pla_gas FROM cx_org_sub WHERE subdependencia='$centra'";
		$cur = odbc_exec($conexion, $query);
		$consecu = odbc_result($cur,1);
		$consecu = $consecu+1;
		// Se trae maximo interno de la tabla
		$cur2 = odbc_exec($conexion,"SELECT isnull(max(interno),0)+1 AS interno FROM cx_gas_bas");
		$interno = odbc_result($cur2,1);
		// Se verifica para no grabar doble planilla
		$consu = "SELECT TOP 1 fecha FROM cx_gas_bas WHERE usuario='$usuario' AND unidad='$unidad' AND periodo='$periodo' AND ano='$ano' ORDER BY fecha DESC";
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
			$file = fopen("log_plan_gas_doble.txt", "a");
			fwrite($file, $fec_log." # ".$v_fecha1." # ".$v_fecha2." # ".$consu." # ".PHP_EOL);
			fclose($file);
		}
		else
		{
			// Se graba encabezado de planilla
			$graba = "INSERT INTO cx_gas_bas (conse, usuario, unidad, ciudad, ordop, n_ordop, mision, periodo, ano, total, responsable, tarifa1, tarifa2, tarifa3, interno, numero, solicitud, elaboro, adicional) VALUES ('$consecu', '$usuario', '$unidad', '$ciudad', '$mision', '$var1', '$var3', '$periodo', '$ano', '$total', '$responsable', '$tarifa1', '$tarifa2', '$tarifa3', '$interno', '$var5', '$var4', '$elaboro', '$adicional')";
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
				$cur1 = odbc_exec($conexion,"UPDATE cx_org_sub SET pla_gas='$consecu' WHERE subdependencia='$centra'");
				for ($i=0;$i<(count($num_cedulas)-1);++$i)
				{
					if ($a[$i] == "")
					{
					}
					else
					{
						$z=$i+1;
						// Se graba discriminado de planilla de gastos
						$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse1 FROM cx_gas_dis");
						$conse1 = odbc_result($cur2,1);
						$graba1 = "INSERT INTO cx_gas_dis (conse, conse1, cedula, nombre, ciudad, v1, v2, v3, valor, valor1, v4, interno) VALUES ('$conse1', '$consecu', '$a[$i]', '$b[$i]', '$c[$i]', '$d[$i]', '$e[$i]', '$f[$i]', '$g[$i]', '$h[$i]', '$k[$i]', '$interno')";
						odbc_exec($conexion, $graba1);
						// Se graba log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_plan_dis.txt", "a");
						fwrite($file, $fec_log." # ".$graba1." # ".PHP_EOL);
						fclose($file);
					}
				}
				// Se valida que se grabe campo actual
				$query1 = "SELECT conse FROM cx_gas_bas WHERE conse='$consecu' AND ano='$ano'";
				$cur = odbc_exec($conexion, $query1);
				$conse2 = odbc_result($cur,1);
				// Se graba log
				$fec_log = date("d/m/Y H:i:s a");
				$file = fopen("log_plan_gas.txt", "a");
				fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
				fclose($file);
			}
		}
	}
	$salida = new stdClass();
	$salida->salida = $conse2;
	$salida->salida1 = $interno;
	$salida->salida2 = $error;
	echo json_encode($salida);
}
// 27/09/2023 - Validacion doble grabacion
?>