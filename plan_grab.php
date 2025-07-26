<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$plan = $_POST['plan'];
	$usuario = $_POST['usuario'];
	$compa = $_POST['compa'];
	$unidad = $_POST['unidad'];
	$lugar = $_POST['lugar'];
	$lugar = strtr(trim($lugar), $sustituye);
	$lugar = iconv("UTF-8", "ISO-8859-1", $lugar);
	$lugar = strtoupper($lugar);
	$lugar = encrypt1($lugar, $llave);
	if (trim($lugar) == "")
	{
		$lugar = $_SESSION["ciu_usuario"];
		$lugar = strtr(trim($lugar), $sustituye);
		$lugar = iconv("UTF-8", "ISO-8859-1", $lugar);
		$lugar = encrypt1($lugar, $llave);
	}
	$factor = stringArray1($_POST['factor']);
	$factor1 = stringArray($_POST['factor']);
	$estructura = stringArray1($_POST['estructura']);
	$estructura1 = stringArray($_POST['estructura']);
	$oms = $_POST['oms'];
	$oms = stringArray1($oms);
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	$oficiales = $_POST['oficiales'];
	$suboficiales = $_POST['suboficiales'];
	$auxiliares = $_POST['auxiliares'];
	$soldados = $_POST['soldados'];
	$ordop = trim($_POST['ordop']);
	$ordop = iconv("UTF-8", "ISO-8859-1", $ordop);
	$ordop = strtoupper($ordop);
	$ordop = trim(utf8_encode($ordop));
	$ordop = encrypt1($ordop, $llave);
	$n_ordop = trim($_POST['ordop1']);
	$n_ordop = iconv("UTF-8", "ISO-8859-1", $n_ordop);
	$n_ordop = strtoupper($n_ordop);
	$n_ordop = trim(utf8_encode($n_ordop));
	$n_ordop = encrypt1($n_ordop, $llave);
	$misiones = trim($_POST['misiones']);
	$misiones = encrypt1($misiones, $llave);
	$contador = $_POST['contador'];
	$tipo1 = $_POST['tipo1'];
	$tipo2 = $_POST['tipo2'];
	if ($plan == "2")
	{
		$tipo3 = $tipo2;
	}
	else
	{
		if ($tipo1 == "1")
		{
			$tipo3 = "99";
		}
		else
		{
			$tipo3 = $tipo2;
		}
	}
	$nivel = $_POST['nivel'];
	$recurso = $_POST['recurso'];
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_inv WHERE ano='$ano'");
	$consecu = odbc_result($cur1,1);
	if ((trim($usu_usuario) == "") or (trim($lugar) == ""))
	{
		$conse = 0;
	}
	else
	{
		$pre = "SELECT nombre, cargo, cedula FROM cx_usu_web WHERE usuario='$usu_usuario'";
		$con = odbc_exec($conexion, $pre);
		$v_nom = trim(utf8_encode(odbc_result($con,1)));
		$v_car = trim(utf8_encode(odbc_result($con,2)));
		$v_ced = trim(utf8_encode(odbc_result($con,3)));
		$v_fir = $v_nom."»".$v_car."»".$v_ced."»";
		$v_fir = iconv("UTF-8", "ISO-8859-1", $v_fir);
		// Se graba registro
		$query = "INSERT INTO cx_pla_inv (conse, usuario, unidad, lugar, factor, estructura, periodo, oficiales, suboficiales, auxiliares, soldados, n_ordop, ordop, misiones, n_misiones, tipo, actual, ano, oms, compania, tipo1, firma1, nivel, recurso) VALUES ('$consecu', '$usuario', '$unidad', '$lugar', '$factor', '$estructura', '$periodo', '$oficiales', '$suboficiales', '$auxiliares', '$soldados', '$n_ordop', '$ordop', '$misiones', '$contador', '$plan', '0', '$ano', '$oms', '$compa', '$tipo3', '$v_fir', '$nivel', '$recurso')";
		$sql = odbc_exec($conexion, $query);
		$query1 = "SELECT conse FROM cx_pla_inv WHERE conse='$consecu' AND ano='$ano'";
		$cur = odbc_exec($conexion, $query1);
		$conse = odbc_result($cur,1);
		$query2 = "SELECT nombre, codigo FROM cx_ctr_fac WHERE codigo IN ($factor1) ORDER BY codigo";
		$sql2 = odbc_exec($conexion, $query2);
		$nom_fact = "";
		$nom_fact1 = "";
		while($i<$row=odbc_fetch_array($sql2))
		{
			$nom_fact .= utf8_encode(trim(odbc_result($sql2,1))).", ";
			$nom_fact1 .= "<option value='".odbc_result($sql2,2)."'>".utf8_encode(trim(odbc_result($sql2,1)))."</option>";
		}
		$nom_fact = substr($nom_fact, 0, -2);
		$query3 = "SELECT nombre, codigo FROM cx_ctr_est WHERE codigo IN ($estructura1) ORDER BY codigo";
		$sql3 = odbc_exec($conexion, $query3);
		$nom_estr = "";
		$nom_estr1 = "";
		while($i<$row=odbc_fetch_array($sql3))
		{
			$nom_estr .= utf8_encode(trim(odbc_result($sql3,1))).", ";
			$nom_estr1 .= "<option value='".odbc_result($sql3,2)."'>".utf8_encode(trim(odbc_result($sql3,1)))."</option>";
		}
		$nom_estr = substr($nom_estr, 0, -2);
		if ($plan == "2")
		{
			$ruta_local1 = $ruta_local."\\archivos\\server\\php\\anexos\\".trim($ano)."\\";
			$carpeta1 = $ruta_local1."\\".$conse;
			if(!file_exists($carpeta1))
			{
				mkdir ($carpeta1);
			}
		}
	}
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_plan.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->factores = $nom_fact;
	$salida->factores1 = $nom_fact1;
	$salida->estructuras = $nom_estr;
	$salida->estructuras1 = $nom_estr1;
	echo json_encode($salida);
}
// 22/04/2024 - Ajuste firma1 caracteres especiales
// 24/02/2025 - Ajuste inclusion campo recurso adicional
?>