<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
	$actu = "UPDATE cx_pla_inv SET n_ordop='' WHERE n_ordop='kg=='";
	$sql = odbc_exec($conexion, $actu);
	$query = "SELECT ordop, n_ordop FROM cx_pla_inv WHERE usuario='$usu_usuario' AND unidad='$uni_usuario' AND estado NOT IN ('','Y','X') AND ano='$ano' GROUP BY ordop, n_ordop";
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
		$ordop = trim(utf8_encode(odbc_result($cur,1)));
		$ordop = trim(decrypt1($ordop, $llave));
		$ordop = strtr($ordop, $sustituye1);
		$n_ordop = trim(utf8_encode(odbc_result($cur,2)));
		$n_ordop = trim(decrypt1($n_ordop, $llave));
		if ($ordop == "")
		{
		}
		else
		{
	        $valida1 = strpos($ordop, "Á");
	        $valida1 = intval($valida1);
	        if ($valida1 == "0")
	        {
	    		$valida1 = strpos($ordop, "É");
	    		$valida1 = intval($valida1);
	    		if ($valida1 == "0")
	    		{
	    			$valida1 = strpos($ordop, "Í");
	    			$valida1 = intval($valida1);
	    			if ($valida1 == "0")
	    			{
	                    $valida1 = strpos($ordop, "Ó");
	                    $valida1 = intval($valida1);
	                    if ($valida1 == "0")
	                    {
	                        $valida1 = strpos($ordop, "Ú");
	                        $valida1 = intval($valida1);
	                        if ($valida1 == "0")
	                        {
						        $valida1 = strpos($ordop, "Ñ");
						        $valida1 = intval($valida1);
						        if ($valida1 == "0")
						        {
						        	$ordop = utf8_encode($ordop);
						        }
	                        }
	                    }
	    		    }
	    		}
	        }
		    $cursor["ordop"] = $ordop;
		   	$cursor["numero"] = $n_ordop;
		   	array_push($respuesta, $cursor);
		}
		$i++;
	}
	echo json_encode($respuesta);
}
?>