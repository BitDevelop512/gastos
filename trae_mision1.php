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
	$periodo1 = $periodo-1;
	$periodo2 = $periodo+1;
	$ordop = trim($_POST['ordop']);
	$ordop = encrypt1($ordop, $llave);
	$ordop1 = trim($_POST['ordop1']);
	$ordop1 = encrypt1($ordop1, $llave);
	// Se consulta compañia del usuario
	$query0 = "SELECT tipo FROM cx_usu_web WHERE usuario='$usu_usuario'";
	$cur0 = odbc_exec($conexion, $query0);
	$compania = odbc_result($cur0,1);
	// Se consultan misiones de la compañia
	$query = "SELECT conse, misiones, estado, n_misiones, tipo FROM cx_pla_inv WHERE ((usuario='$usu_usuario') OR (usuario='$log_usuario')) AND ordop='$ordop' AND n_ordop='$ordop1' AND estado IN ('D','F','G','H','W') AND compania='$compania' AND periodo IN ('$periodo', '$periodo1', '$periodo2') AND ano='$ano' ORDER BY conse";
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$internos = "";
		$internos1 = "";
		$misiones1 = "";
		$cursor = array();
		$estado = $row["estado"];
		$tipo = $row["tipo"];
		if ($tipo == "1")
		{
			$query1 = "SELECT conse FROM cx_inf_aut WHERE unidad1='$uni_usuario' AND periodo IN ('$periodo','$periodo1') AND ano='$ano'";
			$cur1 = odbc_exec($conexion, $query1);
			$tot_inf = odbc_num_rows($cur1);
			if ($tot_inf == "0")
			{
			}
			else
			{
				$informe = odbc_result($cur1,1);
				$conse = $row["conse"];
				$misiones = $row["misiones"];
				$n_misiones = $row["n_misiones"];
				$misiones = trim(decrypt1($misiones, $llave));
				for ($j=1; $j<=$n_misiones; $j++)
				{
					$internos .= $j.",";
				}
				$internos = substr($internos,0,-1);
				$num_misiones = explode("|",$misiones);
				$num_internos = explode(",",$internos);
				for ($k=0;$k<count($num_misiones)-1;++$k)
				{
					$query2 = "SELECT autoriza FROM cx_pla_gas WHERE conse1='$conse' AND interno='$num_internos[$k]' AND unidad='$uni_usuario' AND ano='$ano' ";
					$cur2 = odbc_exec($conexion, $query2);
					$autoriza = odbc_result($cur2,1);
					if ($autoriza == "1")
					{
						$misiones1 .= $num_misiones[$k]."|";
						$internos1 .= $num_internos[$k].",";
					}
				}
				$internos1 = substr($internos1,0,-1);
				$misiones = $misiones1;
				$internos = $internos1;
				$cursor["conse"] = $conse;
				$cursor["misiones"] = $misiones;
				$cursor["internos"] = $internos;
				array_push($respuesta, $cursor);
			}
		}
		else
		{
			$conse = $row["conse"];
			$misiones = $row["misiones"];
			$n_misiones = $row["n_misiones"];
			$misiones = trim(decrypt1($misiones, $llave));
			for ($j=1; $j<=$n_misiones; $j++)
			{
				$internos .= $j.",";
			}
			$internos = substr($internos,0,-1);
			$cursor["conse"] = $conse;
			$cursor["misiones"] = $misiones;
			$cursor["internos"] = $internos;
			array_push($respuesta, $cursor);
		}
		$i++;
	}
	echo json_encode($respuesta);
}
// 06/05/2024 - Ajuste contingencia
// 23/05/2024 - Ajuste validacion suma de planillas
// 12/02/2025 - Ajuste periodo mes siguiente
// 28/04/2025 - Ajuste consulta cambio de usuario
?>