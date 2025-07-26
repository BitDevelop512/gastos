<?php
session_start();
error_reporting(0);
ini_set('post_max_size','1024M');
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$n_ordop = $_POST['n_ordop'];
	list($var1, $var2) = explode(" ", $n_ordop);
	$var1 = trim($var1);
  	if (($var1 == "«") or ($var1 == "0"))
  	{
  		if ($var1 == "0")
  		{
  		}
  		else
  		{
  			$var1 = "";
  		}
  		$var2 = $n_ordop;
  		$var2 = substr($var2,2);
  	}
	$var2 = "";
	$num_ordop = explode(" ", $n_ordop);
    for ($j=0; $j<count($num_ordop); $j++)
    {
    	$m = $j+1;
        $var2 .= $num_ordop[$m]." ";
    }
	$var2 = trim($var2);
  	$mision = $_POST['mision'];
	$num_valores = explode("¬", $mision);
	$num_valores1 = count($num_valores);
	if ($num_valores1 == "3")
	{
		list($var3, $var4, $var5) = explode("¬", $mision);
		$var3 = trim($var3);
	}
	else
	{
		list($var6, $var3, $var4, $var5) = explode("¬", $mision);
		$var3 = trim($var6)."-".trim($var3);
	}
	$var2 = strtr(trim($var2), $sustituye);
	$var2 = iconv("UTF-8", "ISO-8859-1", $var2);
	$var3 = strtr(trim($var3), $sustituye);
	$var3 = iconv("UTF-8", "ISO-8859-1", $var3);
  	$var4 = trim($var4);
  	$var5 = trim($var5);
	$centra = $_POST['centra'];
	$area = trim($_POST['area']);
	$area = iconv("UTF-8", "ISO-8859-1", $area);
	$factor = trim($_POST['factor']);
	$factor = iconv("UTF-8", "ISO-8859-1", $factor);
	$fechai = $_POST['fechai'];
	$fechaf = $_POST['fechaf'];
	$fechai_a = $_POST['fechai_a'];
	$fechaf_a = $_POST['fechaf_a'];
	$valor = $_POST['valor'];
	$actividades = $_POST['actividades'];
	$actividades = strtr(trim($actividades), $sustituye);
	$actividades = iconv("UTF-8", "ISO-8859-1", $actividades);
	$sintesis = $_POST['sintesis'];
	$sintesis = strtr(trim($sintesis), $sustituye);
	$sintesis = iconv("UTF-8", "ISO-8859-1", $sintesis);
	$aspectos = $_POST['aspectos'];
	$aspectos = strtr(trim($aspectos), $sustituye);
	$aspectos = iconv("UTF-8", "ISO-8859-1", $aspectos);
	$bienes = $_POST['bienes'];
	$bienes = strtr(trim($bienes), $sustituye);
	$bienes = iconv("UTF-8", "ISO-8859-1", $bienes);
	$personal = $_POST['personal'];
	$personal = strtr(trim($personal), $sustituye);
	$personal = iconv("UTF-8", "ISO-8859-1", $personal);
	$equipo = $_POST['equipo'];
	$equipo = iconv("UTF-8", "ISO-8859-1", $equipo);
	$equipo = strtr(trim($equipo), $sustituye);
	$responsable = $_POST['responsable'];
	$responsable = iconv("UTF-8", "ISO-8859-1", $responsable);
	$elaboro = $_POST['elaboro'];
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$ano = $_POST['ano'];
	$ano1 = $_POST['ano1'];
	$periodo = $_POST['periodo'];
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$ciudad = $_POST['ciudad'];
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	$alea = $_POST['alea'];
	$tipo = $_POST['tipo'];
	// Se validan datos en blanco
	if ((trim($usuario) == "") or (trim($ciudad) == ""))
	{
		$conse = 0;
	}
	else
	{
		$preg = "SELECT inf_eje FROM cx_org_sub WHERE subdependencia='$centra'";
		$cur = odbc_exec($conexion, $preg);
		$consecu = odbc_result($cur,1);
		$consecu = $consecu+1;
		// Se actualiza informe de unidad centralizadora
		$actu = "UPDATE cx_org_sub SET inf_eje='$consecu' WHERE subdependencia='$centra'";
		$cur1 = odbc_exec($conexion, $actu);
		// Se graba acta
		if ($tipo == "1")
		{
			$graba = "INSERT INTO cx_inf_eje (conse, usuario, unidad, ciudad, ordop, n_ordop, mision, valor, sitio, fechai, fechaf, factor, actividades, sintesis, aspectos, bienes, personal, equipo, responsable, ano, numero, consecu, fechai_a, fechaf_a, elaboro, archivo, codigo) VALUES ('$consecu', '$usuario', '$unidad', '$ciudad', '$var2', '$var1', '$var3', '$valor', '$area', '$fechai', '$fechaf', '$factor', '$actividades', '$sintesis', '$aspectos', '$bienes', '$personal', '$equipo', '$responsable', '$ano1', '$var5', '$var4', '$fechai_a', '$fechaf_a', '$elaboro', '0', '')";
		}
		else
		{
			$graba = "INSERT INTO cx_inf_eje (conse, usuario, unidad, ciudad, ordop, n_ordop, mision, valor, sitio, fechai, fechaf, factor, responsable, ano, numero, consecu, fechai_a, fechaf_a, elaboro, archivo, codigo) VALUES ('$consecu', '$usuario', '$unidad', '$ciudad', '$var2', '$var1', '$var3', '$valor', '$area', '$fechai', '$fechaf', '$factor', '$responsable', '$ano1', '$var5', '$var4', '$fechai_a', '$fechaf_a', '$elaboro', '1', '$alea')";
		}
		odbc_exec($conexion, $graba);
		// Se valida que se grabe
		$query1 = "SELECT conse FROM cx_inf_eje WHERE conse='$consecu' AND ano='$ano1' AND unidad='$uni_usuario'";
		$cur2 = odbc_exec($conexion, $query1);
		$conse = odbc_result($cur2,1);
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_info.txt", "a");
		fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->ano = $ano1;
	echo json_encode($salida);
}
?>