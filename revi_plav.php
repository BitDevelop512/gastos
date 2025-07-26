<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
$mes = date('m');
if ($mes == "12")
{
  $mes = 1;
  $ano = $ano+1;
}
else
{
  $mes = $mes+1;
}
$ano1 = date('Y');
$ano2 = intval($ano1)+1;
$mes1 = date('m');
$mes1 = intval($mes1);
$mes2 = date('m')-1;
if ($mes2 == "0")
{
	$mes2 = $mes1+1;
}
$ruta_local1 = $ruta_local."\\archivos\\server\\php\\anexos";
$carpeta = $ruta_local1."\\".$ano;
if(!file_exists($carpeta))
{
	mkdir ($carpeta);
}
$query0 = "SELECT conse, ano FROM cv_rev_pla WHERE unidad!='999' AND (usuario2='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='P') OR (usuario3='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='Q') OR (usuario4='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado IN ('A','Y','R') AND (usuario5='' OR usuario6='')) OR (usuario5='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado IN ('B','S') AND (usuario6='' OR usuario7='')) OR (usuario6='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado IN ('A','C','Y') AND (usuario7='' OR usuario8='')) OR (usuario7='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado IN ('B','J')) OR (usuario7='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='D' AND (usuario8='' OR usuario9='')) OR (usuario7='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='K' AND usuario8='' AND usuario9='') OR (usuario8='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado IN ('C','K') AND (usuario9='' OR usuario10='')) OR (usuario8='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='E' AND (usuario9='' OR usuario10='')) OR (usuario9='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='T' AND usuario10='') OR (usuario9='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='I' AND usuario10='' AND usuario11='') OR (usuario10='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='M') OR (usuario10='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='T') OR (usuario11='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='N') OR (usuario12='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='O') OR (usuario13='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='T') OR (usuario14='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='U') OR (usuario15='$usu_usuario' AND tipo='2' AND (periodo IN ('$mes1','$mes2')) AND ano='$ano1' AND estado='V') ORDER BY conse";
$sql0 = odbc_exec($conexion, $query0);
$total = odbc_num_rows($sql0);
$total = intval($total);
if ($total == "1")
{
	$conse = odbc_result($sql0,1);
	$conse = intval($conse);
	$ano = odbc_result($sql0,2);
}
else
{
	$numero = "";
	while($i<$row=odbc_fetch_array($sql0))
	{
		$numero .= odbc_result($sql0,1).",";
	}
	$numero = substr($numero,0,-1);
	$conse = $total;
}
if ($total == "1")
{
	header("location:apli_plan.php?conse=$conse&ano=$ano");
}
else
{
	if ($total > 1)
	{
		header("location:apli_planes.php?conse=$numero&ano=$ano1");
	}
	else
	{
		$ano = date('Y');
		switch ($adm_usuario)
		{
			case '3':
				header("location:revi_plan.php");
				break;
			case '6':
				header("location:apli_plan.php");
				break;
			case '7':
			case '9':
				if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
				{
					header("location:revi_plan.php");
					break;
				}
				else
				{
					header("location:apli_plan.php");
					break;
				}
			case '4':
			case '11':
				$query2 = "SELECT especial FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
				$sql2 = odbc_exec($conexion, $query2);
				$especial = odbc_result($sql2,1);
				$especial = intval($especial);
				if ($especial > 0)
				{
					header("location:apli_plan3.php");
				}
				else
				{
					if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
					{
						$query = "SELECT count(*) AS contador FROM cv_rev_pla WHERE unidad='$uni_usuario' AND ((tipo='1' AND periodo='$mes' AND ano='$ano') OR (tipo='2' AND periodo='$mes1' AND ano='$ano1')) AND estado='P'";
						$sql = odbc_exec($conexion, $query);
						$contador = odbc_result($sql,1);				
						if ($contador == "0")
						{
							$query1 = "SELECT count(*) AS contador FROM cx_pla_con WHERE unidad='$uni_usuario' AND periodo='$mes' AND ano='$ano'";
							$sql1 = odbc_exec($conexion, $query1);
							$contador1 = odbc_result($sql1,1);
							if ($contador1 == "1")
							{
								header("location:revi_plan.php");
							}
							else
							{
								if ($adm_usuario == "4")
								{
									$query2 = "SELECT conse FROM cx_pla_inv WHERE unidad='$uni_usuario' AND periodo='$mes' AND ano='$ano' AND tipo='1' AND estado NOT IN ('','X','Y')";
									$sql2 = odbc_exec($conexion, $query2);
									$conse1 = odbc_result($sql2,1);
									$conse1 = intval($conse1);
									if ($conse1 == "0")
									{
										header("location:revi_plan.php");
									}
									else
									{
										header("location:apli_plan.php");
									}
								}
								else
								{
									header("location:apli_plan.php");
								}
							}
						}
						else
						{
							header("location:revi_plan.php");
						}
					}
					else
					{
						$query = "SELECT COUNT(*) AS contador FROM cv_rev_pla WHERE unidad='$uni_usuario' AND ((tipo='1' AND periodo='$mes' AND ano IN ('$ano','$ano2')) OR (tipo='2' AND periodo='$mes1' and ano='$ano1')) AND estado IN ('D','E','F')";
						$sql = odbc_exec($conexion, $query);
						$contador = odbc_result($sql,1);
						if ($contador == "0")
						{
							$query1 = "SELECT COUNT(*) AS contador FROM cx_pla_con WHERE unidad='$uni_usuario' AND periodo='$mes' AND ano='$ano'";
							$sql1 = odbc_exec($conexion, $query1);
							$contador1 = odbc_result($sql1,1);
							if ($contador1 == "1")
							{
								header("location:revi_plan.php");
							}
							else
							{
								header("location:apli_plan.php");
							}
						}
						else
						{
							header("location:revi_plan.php");
						}
					}
				}
				break;
			default:
				if ($adm_usuario == "13")
				{
					$query2 = "SELECT especial FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
					$sql2 = odbc_exec($conexion, $query2);
					$especial = odbc_result($sql2,1);
					$especial = intval($especial);
					if ($especial > 0)
					{
						header("location:apli_plan3.php");
					}
					else
					{
						header("location:revi_plan.php");
					}
				}
				else
				{
					header("location:revi_plan.php");
				}
				break;
		}
	}
}
// 22/05/2024 - Ajuste desde usuario4 y usuario6 para validacion cargue de solicitud
// 24/05/2024 - Ajuste CACIM sin recursos unidad solicitante
// 23/08/2024 - Ajuste validacion temporales pdf
// 30/01/2025 - Ajuste mes anterior y siguiente cuando es enero
?>