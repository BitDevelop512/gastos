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
  	$sigue = "1";
	if (!empty($_GET['conse']))
	{
		$conse = $_GET['conse'];
	}
	else
	{
		$conse = "0";
	}
	if (!empty($_GET['ano']))
	{
		$ano = $_GET['ano'];
	}
	else
	{
		$ano = date('Y');
	}
	// Se consulta unidad - dependencia
  	$consu1 = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  	$cur1 = odbc_exec($conexion, $consu1);
  	$unidad = odbc_result($cur1,1);
  	$depen = odbc_result($cur1,2);
  	// Se consulta unidades por dependencia
    $query0 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$depen' ORDER BY dependencia, subdependencia";
    $cur0 = odbc_exec($conexion, $query0);
    $numero = "";
    while($i<$row=odbc_fetch_array($cur0))
    {
      $numero .= "'".odbc_result($cur0,1)."',";
    }
    $numero = substr($numero,0,-1);
	$query = "SELECT tipo, periodo, ano FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano' AND estado NOT IN ('','X','Y') ORDER BY conse, ano";
	$sql = odbc_exec($conexion, $query);
	$planes = odbc_num_rows($sql);
	$tipo = odbc_result($sql,1);
	$periodo = odbc_result($sql,2);
	if ($planes > 0)
	{
		$ano = odbc_result($sql,3);
		$ano = trim($ano);
	}
	if ($tipo == "2")
	{
		$pdf = "./fpdf/641.php?conse=".$conse."&ano=".$ano;
	}
	else
	{
		if (($adm_usuario == "4") or ($adm_usuario == "27"))
	  	{
			if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
			{
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
				$pdf = "./fpdf/638_1.php?periodo=".$mes."&ano=".$ano;
			}
			else
			{
				if ($planes > 0)
				{
			    	$pdf = "./fpdf/638.php?conse=".$conse."&ano=".$ano;
				}
				else
				{
					$pdf = "nota_con.php";
					$sigue = "0";
			    }
			}
	  	}
		else
		{
		  	if ($adm_usuario == "6")
		  	{
				if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
				{
					if (!empty($_GET['conse']))
					{
			    		$pdf = "./fpdf/638.php?conse=".$conse."&ano=".$ano;
			    	}
			    	else
			    	{
			    		$pdf = "nota_con.php";
			    		$sigue = "0";
			    	}
			    }
			   	else
			   	{
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
					$query = "SELECT conse FROM cx_pla_inv WHERE unidad ='$uni_usuario' AND periodo='$mes' AND ano='$ano' AND tipo='1' AND estado NOT IN ('','X','Y')";
					$sql = odbc_exec($conexion, $query);
					$total = odbc_num_rows($sql);
					$total = intval($total);
					if ($total > 0)
					{
						$pdf = "./fpdf/638_1.php?periodo=".$mes."&ano=".$ano."&contador=".$total;
					}
			    	else
			    	{
						$query0 = "SELECT COUNT(1) AS consolida FROM cx_pla_con WHERE unidad='$uni_usuario'";
						$sql0 = odbc_exec($conexion, $query0);
						$total0 = odbc_result($sql0,1);
						$total0 = intval($total0);
						if ($total0 > 0)
						{
							$pdf = "./fpdf/638_1.php?periodo=".$mes."&ano=".$ano."&contador=".$total;
						}
						else
						{
							$query1 = "SELECT conse FROM cx_pla_inv WHERE unidad IN ($numero) AND periodo='$mes' AND ano='$ano' AND tipo='1' AND estado NOT IN ('','X','Y') ORDER BY unidad";
							$sql1 = odbc_exec($conexion, $query1);
							$total1 = odbc_num_rows($sql1);
							$total1 = intval($total1);
							if ($total1 > 0)
							{
								$pdf = "./fpdf/638_1.php?periodo=".$mes."&ano=".$ano."&contador=".$total;
							}
							else
							{
			    				$pdf = "nota_con.php";
			    				$sigue = "0";
			    			}
						}
			    	}
		    	}
			}
			else
		    {
		    	if (($adm_usuario == "7") or ($adm_usuario == "9"))
	  			{
					if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
					{
				   		$pdf = "./fpdf/638.php?conse=".$conse."&ano=".$ano;
				   	}
				   	else
				   	{
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
						if ($adm_usuario == "7")
						{
							$query = "SELECT conse FROM cx_pla_con WHERE unidad='$uni_usuario' AND estado='H' AND periodo='$mes' AND ano='$ano'";
						}
						else
						{
							$query = "SELECT conse FROM cx_pla_con WHERE unidad='$uni_usuario' AND estado='I' AND periodo='$mes' AND ano='$ano'";
						}
						$sql = odbc_exec($conexion, $query);
						$total = odbc_num_rows($sql);
						if ($total>0)
						{
							$conse = odbc_result($sql,1);
							$pdf = "./fpdf/638_2.php?conse=".$conse."&ano=".$ano;
						}
						else
						{
							$pdf = "nota_con.php";
							$sigue = "0";
						}
					}
		  		}
		  		else
		  		{
		  			if (empty($_GET['conse']))
					{
						$pdf = "nota_con.php";
						$sigue = "0";
					}
					else
					{
		    			$pdf = "./fpdf/638.php?conse=".$conse."&ano=".$ano;
					}
			    }
			}
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
				if ($tipo == "2")
				{
		  		?>
		  			<frame src="apli_plan1.php?conse=<?php echo $conse; ?>&ano=<?php echo $ano; ?>" name="R3">
		  		<?php
				}
				else
				{
				    if (($adm_usuario == "4") or ($adm_usuario == "27"))
		  			{
				        if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
				        {
		  			?>
		  					<frame src="apli_plan2.php?periodo=<?php echo $mes; ?>&ano=<?php echo $ano; ?>" name="R3">
		  			<?php
		  				}
		  				else
		  				{
		  			?>
		  					<frame src="apli_plan1.php?conse=<?php echo $conse; ?>&ano=<?php echo $ano; ?>" name="R3">
		  			<?php
		  				}
		  			}
		  			else
		  			{
				  		if (($adm_usuario == "6") or ($adm_usuario == "7") or ($adm_usuario == "9"))
				  		{
							if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
							{
		  			?>
		  						<frame src="apli_plan1.php?conse=<?php echo $conse; ?>&ano=<?php echo $ano; ?>" name="R3">
		  			<?php
		  					}
		  					else
		  					{
								if ($sigue == "1")
								{
		  			?>
									<frame src="apli_plan2.php?periodo=<?php echo $mes; ?>&ano=<?php echo $ano; ?>" name="R3">
		  			<?php
		  						}
		  						else
		  						{
		  			?>
									<frame src="resultado1.php" name="R3">
		  			<?php
		  						}
		  					}
		  				}
		  				else
		  				{
		  			?>
		  					<frame src="apli_plan1.php?conse=<?php echo $conse; ?>&ano=<?php echo $ano; ?>" name="R3">
		  			<?php
		  				}
		  			}
		  		}
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