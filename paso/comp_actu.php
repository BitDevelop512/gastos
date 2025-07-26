<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
  	$ano = date('Y');
  	$mes = date('m');
  	$mes = $mes-1;
	$unidad = $_POST['unidad'];
	$compania = $_POST['compania'];
	$admin = $_POST['admin'];
	$permisos = $_POST['permisos'];
	$nombre = trim($_POST['nombre']);
	$nombre = iconv("UTF-8", "ISO-8859-1", $nombre);
	$cedula = trim($_POST['cedula']);
	$ciudad = trim($_POST['ciudad']);
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	$sigla = $_POST['sigla'];
	$nit = $_POST['nit'];
	$banco = $_POST['banco'];
	$cuenta = $_POST['cuenta'];
	$cheque = $_POST['cheque'];
	$cheque1 = $_POST['cheque1'];
	$cheque2 = $_POST['cheque2'];
	$saldo = $_POST['saldo'];
	$gastos = $_POST['gastos'];
	$pagos = $_POST['pagos'];
	$recompensas = $_POST['recompensas'];
	$egreso1 = $_POST['egreso1'];
	$ingreso1 = $_POST['ingreso1'];
	$mision1 = $_POST['mision1'];
	$acta1 = $_POST['acta1'];
	// Conversion saldo
  	$saldo1 = str_replace(',','',$saldo);
  	$saldo1 = substr($saldo1,0,-3);
  	$saldo1 = intval($saldo1);
  	// Conversion gastos
  	$gastos1 = str_replace(',','',$gastos);
  	$gastos1 = substr($gastos1,0,-3);
  	$gastos1 = intval($gastos1);
  	// Conversion pagos
  	$pagos1 = str_replace(',','',$pagos);
  	$pagos1 = substr($pagos1,0,-3);
  	$pagos1 = intval($pagos1);
  	// Conversion recompensas
  	$recompensas1 = str_replace(',','',$recompensas);
  	$recompensas1 = substr($recompensas1,0,-3);
  	$recompensas1 = intval($recompensas1);
  	// Firmas
	$firma1 = $_POST['firma1'];
	$firma1 = iconv("UTF-8", "ISO-8859-1", $firma1);
	$firma2 = $_POST['firma2'];
	$firma2 = iconv("UTF-8", "ISO-8859-1", $firma2);
	$firma3 = $_POST['firma3'];
	$firma3 = iconv("UTF-8", "ISO-8859-1", $firma3);
	$cargo1 = $_POST['cargo1'];
	$cargo1 = iconv("UTF-8", "ISO-8859-1", $cargo1);
	$cargo2 = $_POST['cargo2'];
	$cargo2 = iconv("UTF-8", "ISO-8859-1", $cargo2);
	$cargo3 = $_POST['cargo3'];
	$cargo3 = iconv("UTF-8", "ISO-8859-1", $cargo3);
	$tipou = $_POST['tipou'];
	$tipoc = $_POST['tipoc'];
	$cheque = $cheque."|".$cheque1."|".$cheque2;
	// Saldos unidades
	$num_unis = $_POST['num_unis'];
	$sig_unis = $_POST['sig_unis'];
	$inf_unis = $_POST['inf_unis'];
	$pag_unis = $_POST['pag_unis'];
	$rec_unis = $_POST['rec_unis'];
	// Se extraen las datos por separado para grabar
	$num_unis1=explode("|",$num_unis);
	for ($i=0;$i<count($num_unis1);++$i)
	{
		$a[$i] = trim($num_unis1[$i]);
	}
	$sig_unis1=explode("|",$sig_unis);
	for ($i=0;$i<count($sig_unis1);++$i)
	{
		$b[$i] = trim($sig_unis1[$i]);
	}
	$inf_unis1=explode("|",$inf_unis);
	for ($i=0;$i<count($inf_unis1);++$i)
	{
		$c[$i] = trim($inf_unis1[$i]);
	 	$c[$i] = str_replace(',','',$c[$i]);
	  	$c[$i] = substr($c[$i],0,-3);
	  	$c[$i] = intval($c[$i]);
	}
	$pag_unis1=explode("|",$pag_unis);
	for ($i=0;$i<count($pag_unis1);++$i)
	{
		$d[$i]=trim($pag_unis1[$i]);
	 	$d[$i] = str_replace(',','',$d[$i]);
	  	$d[$i] = substr($d[$i],0,-3);
	  	$d[$i] = intval($d[$i]);
	}
	$rec_unis1=explode("|",$rec_unis);
	for ($i=0;$i<count($rec_unis1);++$i)
	{
		$e[$i]=trim($rec_unis1[$i]);
	 	$e[$i] = str_replace(',','',$e[$i]);
	  	$e[$i] = substr($e[$i],0,-3);
	  	$e[$i] = intval($e[$i]);
	}
	// Se graba en tabla de saldos inicales unidad centralizadora
	//$sql0 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_sal_ini");
	//$conse0 = odbc_result($sql0,1);
	//$grabas = "INSERT INTO cx_sal_ini (conse, unidad, sigla, periodo, ano, saldo, gastos, pagos, recompensas) VALUES ('$conse0', '$unidad', '$sigla', '$mes', '$ano', '$saldo1', '$gastos1', '$pagos1', '$recompensas1')";
	//odbc_exec($conexion, $grabas);
	// Se graba en tabla de saldos inicales unidades
	for ($i=0;$i<(count($num_unis1)-1);++$i)
	{
		$sql0 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_sal_ini");
		$conse0 = odbc_result($sql0,1);
		// Se graba discriminado de saldos iniciales
		$sal_tot = $c[$i]+$d[$i]+$e[$i];
		$grabas = "INSERT INTO cx_sal_ini (conse, unidad, sigla, periodo, ano, saldo, gastos, pagos, recompensas) VALUES ('$conse0', '$a[$i]', '$b[$i]', '$mes', '$ano', '$sal_tot', '$c[$i]', '$d[$i]', '$e[$i]')";
		odbc_exec($conexion, $grabas);
	}
	// Se actualiza parametrizacion de usuario
	$query = "UPDATE cx_usu_web SET nombre='$nombre', permisos='$permisos', tipo='$compania', unidad='$unidad', admin='$admin', ciudad='$ciudad', cedula='$cedula' WHERE conse='$con_usuario'";
	$sql = odbc_exec($conexion, $query);
	$query1 = "SELECT tipo, unidad, admin FROM cx_usu_web WHERE conse='$con_usuario'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	$uni = odbc_result($cur,2);
	$adm = odbc_result($cur,3);
    $query2 = "SELECT nombre FROM cx_org_cmp WHERE conse='$conse'";
    $sql2 = odbc_exec($conexion,$query2);
    $cmp_usuario = trim(utf8_encode(odbc_result($sql2,1)));
    // Se consulta la division
    $query3 = "SELECT unidad FROM cx_org_sub WHERE subdependencia='$unidad'";
    $sql3 = odbc_exec($conexion,$query3);
    $nun_usuario = odbc_result($sql3,1);
	$_SESSION["nom_usuario"] = $nombre;
	$_SESSION["per_usuario"] = $permisos;
	$_SESSION["tip_usuario"] = $conse;
	$_SESSION["uni_usuario"] = $uni;
	$_SESSION["sig_usuario"] = $sigla;
	$_SESSION["adm_usuario"] = $adm;
	$_SESSION["cmp_usuario"] = $cmp_usuario;
	$_SESSION["ciu_usuario"] = $ciudad;
  	$_SESSION["tpu_usuario"] = $tipou;
  	$_SESSION["tpc_usuario"] = $tipoc;
  	$_SESSION["nun_usuario"] = $nun_usuario;
	// Se actualiza la parametrizacion
	if (($admin == "10") or ($admin == "15") or ($admin == "31"))
	{
		$query3 = "UPDATE cx_org_sub SET nit='$nit', banco='$banco', cuenta='$cuenta', cheque='$cheque', firma1='$firma1', firma2='$firma2', firma3='$firma3', cargo1='$cargo1', cargo2='$cargo2', cargo3='$cargo3', usuario='$usu_usuario', saldo='$saldo1', com_egr='$egreso1', com_ing='$ingreso1', mis_tra='$mision1', act_inf='$acta1' WHERE subdependencia='$unidad'";
		$sql3 = odbc_exec($conexion, $query3);
		// Saldos
		$query4 = "SELECT count(1) as contador FROM cx_sal_uni WHERE unidad='$unidad'";
		$sql4 = odbc_exec($conexion, $query4);
		$contador = odbc_result($sql4,1);
		if ($contador == "0")
		{
			$sql5 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_sal_uni");
			$conse = odbc_result($sql5,1);
			$graba = "INSERT INTO cx_sal_uni (conse, unidad, periodo, ano, saldo, gastos, pagos, recompensas) VALUES ('$conse', '$unidad', '$mes', '$ano', '$saldo1', '$gastos1', '$pagos1', '$recompensas1')";
			$sql6 = odbc_exec($conexion, $graba);
		}
	}
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_regi.txt", "a");
	fwrite($file, $fec_log." # ".$query3." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
?>