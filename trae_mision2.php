<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
	$periodo = date('m');
	$periodo = intval($periodo);
	$periodo1 = intval($periodo)-1;
	$periodo2 = intval($periodo)-1;
	$ordop = trim($_POST['ordop']);
	$ordop2 = $ordop;
	$ordop = encrypt1($ordop, $llave);
	$ordop = trim($ordop);
	$ordop1 = trim($_POST['ordop1']);
	$ordop3 = $ordop1;
	$ordop1 = encrypt1($ordop1, $llave);
	$ordop1 = trim($ordop1);
	$conse = $_POST['conse'];
	$query = "SELECT conse, misiones, estado, n_misiones, tipo FROM cx_pla_inv WHERE ((usuario='$usu_usuario') OR (usuario='$log_usuario')) AND unidad='$uni_usuario' AND ordop='$ordop' AND n_ordop='$ordop1' AND estado IN ('D','F','G','H','W') AND ano='$ano' ORDER BY conse";
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$internos = "";
		$cursor = array();
		$estado = $row["estado"];
		$querys = "";
		$validaciones = "";
		$misiones3 = "";
		$conse = $row["conse"];
		$misiones = $row["misiones"];
		$misiones = trim(decrypt1($misiones, $llave));
		$misiones1 = explode("|", $misiones);
		for ($m=0;$m<count($misiones1)-1;++$m)
		{
			$misiones2 = trim($misiones1[$m]);
			$n_misiones = $row["n_misiones"];
			$ordop4 = utf8_decode($ordop2);
			$tipo = $row["tipo"];
			if ($tipo == "1")
			{
				$query0 = "SELECT conse, mision, interno FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano' AND unidad='$uni_usuario' AND mision='$misiones2' AND autoriza!='2' ORDER BY conse";
			}
			else
			{
				$query0 = "SELECT conse, mision, interno FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano' AND unidad='$uni_usuario' AND mision='$misiones2' AND autoriza!='2' ORDER BY conse";
			}
			$cur0 = odbc_exec($conexion, $query0);
			$total0 = odbc_num_rows($cur0);
			if ($total0 > 0)
			{
				if ($total0 == "1")
				{
		    	$v_interno = odbc_result($cur0,3);
					$internos .= $v_interno.",";
					$misiones3 .=  $misiones2."|"; 
					$querys .= "SELECT conse FROM cx_rel_gas WHERE unidad='$uni_usuario' AND ordop='$ordop4' AND n_ordop='$ordop3' AND numero='$v_interno' AND (consecu='$conse' OR consecus LIKE ('%$conse%')) AND ano='$ano'"."#";
				}
				else
				{
					$n = 0;
					while($n<$row=odbc_fetch_array($cur0))
					{
		    		$v_interno = odbc_result($cur0,3);
						$internos .= $v_interno.",";
						$misiones3 .=  $misiones2."|"; 
						$querys .= "SELECT conse FROM cx_rel_gas WHERE unidad='$uni_usuario' AND ordop='$ordop4' AND n_ordop='$ordop3' AND numero='$v_interno' AND (consecu='$conse' OR consecus LIKE ('%$conse%')) AND ano='$ano'"."#";
						$n++;
					}
				}
			}
			else
			{
				$internos .= "0,";
				$misiones3 .=  "|";
				$querys .= "SELECT conse FROM cx_rel_gas WHERE 1=2"."#";
			}
		}
		$internos = substr($internos,0,-1);
		$querys = substr($querys,0,-1);
		$n_querys = explode("#", $querys);
		for ($k=0; $k<count($n_querys); ++$k)
		{
			$query1 = $n_querys[$k];
			$cur1 = odbc_exec($conexion, $query1);
			$total = odbc_num_rows($cur1);
			$validaciones .= $total.",";
		}
		$validaciones = substr($validaciones,0,-1);
		$cursor["conse"] = $conse;
		$cursor["misiones"] = $misiones;
		$cursor["aprobadas"] = $misiones3;
		$cursor["internos"] = $internos;
		$cursor["validaciones"] = $validaciones;
		array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
// 06/05/2024 - Ajuste contingencia
// 05/08/2024 - Ajuste retiro contingencia
// 16/10/2024 - Ajuste consulta misiones nombre repetido
// 06/11/2024 - Ajuste no consultar misiones canceladas
// 28/04/2025 - Ajuste consulta cambio de usuario
?>