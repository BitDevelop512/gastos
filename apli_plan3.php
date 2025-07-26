<?php
session_start();
error_reporting(0);
if ($_SESSION["autenticado"] != "SI")
{
	header("location:resultado.php");
}
else
{
	require('conf.php');
	include('permisos.php');
	require('funciones.php');
	$sigue = "1";
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
	// Se consulta unidad - dependencia
	$consu = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
 	$cur = odbc_exec($conexion, $consu);
	$unidad = odbc_result($cur,1);
 	$depen = odbc_result($cur,2);
	// Se consulta unidades por dependencia
	$query0 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$unidad' AND unic='2' ORDER BY dependencia, subdependencia";
	$sql0 = odbc_exec($conexion, $query0);
	$numero = "";
	while($i<$row=odbc_fetch_array($sql0))
	{
		$numero .= "'".odbc_result($sql0,1)."',";
	}
	$numero = substr($numero,0,-1);
	$numero = trim($numero);
	if ($numero == "")
	{
	}
	else
	{
		$numero = $numero.",'$uni_usuario'";
	}
	// Se consulta plan del PDM
	$query0 = "SELECT conse FROM cx_pla_inv WHERE unidad='$uni_usuario' AND periodo='$mes' AND ano='$ano' AND tipo='1'";
	$sql0 = odbc_exec($conexion, $query0);
	$total0 = odbc_num_rows($sql0);
	$total0 = intval($total0);
	if ($total0 > 0)
	{
		$plan = odbc_result($sql0,1);
	}
	// Se consulta numero de consolidados
	if ($adm_usuario == "11")
	{
		$estado = "B";
	}
	else
	{
		if ($adm_usuario == "13")
		{
			$estado = "I";
		}
		else
		{
			$estado = "J";
		}
	}
	if ($numero == "")
	{
		$conses = "0";
		$numero1 = "'".$plan."'";
		$pdf = "./fpdf/638_3.php?conse=".$conses."&numero=".$numero1."&ano=".$ano;
	}
	else
	{
		$query1 = "SELECT conse, usuario, unidad, planes FROM cx_pla_con WHERE unidad IN ($numero) AND estado='$estado' AND periodo='$mes' AND ano='$ano'";
		$sql1 = odbc_exec($conexion, $query1);
		$total1 = odbc_num_rows($sql1);
		$total1 = intval($total1);
		if ($total1 > 0)
		{
			$conses = "";
			$numero1 = "";
			while($i<$row=odbc_fetch_array($sql1))
			{
				$conses .= odbc_result($sql1,1).",";
				$planes = odbc_result($sql1,4);
				$numero1 .= decrypt1($planes, $llave).",";
			}
			$conses = substr($conses,0,-1);
			$numero1 = substr($numero1,0,-1);
			$pdf = "./fpdf/638_3.php?conse=".$conses."&numero=".$numero1."&ano=".$ano;
		}
		else
		{
			$pdf = "nota_con.php";
			$sigue = "0";
		}
		// Si hay plan del PDM
		if ($total0 > 0)
		{
			$numero1 .= ",'".$plan."'";
			$pdf = "./fpdf/638_3.php?conse=".$conses."&numero=".$numero1."&ano=".$ano;
		}
		// Se consultan los numeros de consolidados pendientes o rechazados
		$query2 = "SELECT conse, usuario, unidad, planes FROM cx_pla_con WHERE unidad IN ($numero) AND estado!='J' AND periodo='$mes' AND ano='$ano'";
		$sql2 = odbc_exec($conexion, $query2);
		$total2 = odbc_num_rows($sql2);
		$total2 = intval($total2);
		if ($total2 > 0)
		{
			$numero2 = "";
			while($i<$row=odbc_fetch_array($sql2))
			{
				$numero2 .= odbc_result($sql2,1).",";
			}
			$numero2 = substr($numero2,0,-1);
		}
	}
?>
<html lang="es">
	<frameset rows="88,*" cols="*" frameborder="NO" border="0" framespacing="0">
		<frame src="resultado.php" name="R1">
			<frameset rows="*" cols="730,*" frameborder="NO" border="0" framespacing="0">
		  	<frame src="<?php echo $pdf; ?>" name="R2" scrolling="yes" noresize>
		  	<?php
				if ($sigue == "0")
				{
				?>
					<frame src="resultado1.php" name="R3">
				<?php
				}
				else
				{
			  ?>
			  	<frame src="apli_plan4.php?conses=<?php echo $conses; ?>&numeros=<?php echo $numero1; ?>&periodo=<?php echo $mes; ?>&ano=<?php echo $ano; ?>&rechazados=<?php echo $numero2; ?>" name="R3">
			  <?php
			 	}
	  		?>
			</frameset>
		</frameset>
	<noframes>
	<body>
	</body>
	</noframes>
</html>
<?php
}
?>