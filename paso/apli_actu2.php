<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$mes = date('m');
if ($mes == "12")
{
  $mes = 1;
}
else
{
  $mes = $mes+1;
}
if (is_ajax())
{
	$actual = date('Y-m-d');
	$oficial = $_POST['oficial'];
	$depen1 = $_POST['depen1'];
	$conses = $_POST['conses'];
	$unidad = $_POST['unidad'];
	$estado = $_POST['estado'];
	$ano = $_POST['ano'];
	$valores1 = $_POST['valores1'];
	$valores2 = $_POST['valores2'];
	$valores3 = $_POST['valores3'];
	$valores4 = $_POST['valores4'];
	$valores5 = $_POST['valores5'];
	$motivo = $_POST['motivo'];
	$motivo = iconv("UTF-8", "ISO-8859-1", $motivo);
	// Se consulta datos para firmas
	$preg = "SELECT nombre, cargo, cedula FROM cx_usu_web WHERE usuario='$usu_usuario'";
	$con = odbc_exec($conexion, $preg);
	$v_nom = trim(odbc_result($con,1));
	$v_car = trim(odbc_result($con,2));
	$v_ced = trim(odbc_result($con,3));
	$v_fir = $v_nom."»".$v_car."»".$v_ced."»";
	if ($estado == "Y")
	{
	}
	else
	{
		$query0 = "SELECT conse FROM cx_pla_inv WHERE conse IN ($conses) AND ano='$ano' AND tipo='1' AND estado NOT IN ('','Y','X')";
		$sql0 = odbc_exec($conexion,$query0);
		$i = 1;
		$conses = "";
		while($i<$row=odbc_fetch_array($sql0))
		{
	    	$conses .= "'".odbc_result($sql0,1)."',";
		}
		$conses = substr($conses,0,-1);
	}
	$conses1 = encrypt1($conses, $llave);
	$num_valores1 = explode("|",$valores1);
	for ($i=0;$i<count($num_valores1);++$i)
	{
		$a[$i] = trim($num_valores1[$i]);
	}
	$num_valores2 = explode("|",$valores2);
	for ($i=0;$i<count($num_valores2);++$i)
	{
		$b[$i] = trim($num_valores2[$i]);
	}
	$num_valores3 = explode("|",$valores3);
	for ($i=0;$i<count($num_valores3);++$i)
	{
		$c[$i] = trim($num_valores3[$i]);
	}
	$num_valores4 = explode("|",$valores4);
	for ($i=0;$i<count($num_valores4);++$i)
	{
		$d[$i] = trim($num_valores4[$i]);
	}
	$num_valores5 = explode("|",$valores5);
	for ($i=0;$i<count($num_valores5);++$i)
	{
		$e[$i] = trim($num_valores5[$i]);
	}
	// Se actualizan los valores aprobados o rechazados
	for ($i=0;$i<(count($num_valores1)-1);++$i)
	{
		$j = $i+1;
		// Se actualiza el valor aprobado o rechazados por mision
		$graba = "UPDATE cx_pla_gas SET valor_a='$a[$i]' WHERE conse='$c[$i]' AND ano='$ano'";
		odbc_exec($conexion, $graba);
	}
	for ($i=0;$i<(count($num_valores2)-1);++$i)
	{
		$k = $i+1;
		// Se actualiza el valor aprobado o rechazados por fuente
		$graba1 = "UPDATE cx_pla_pag SET val_fuen_a='$b[$i]' WHERE conse='$d[$i]' AND conse1='$e[$i]' AND ano='$ano'";
		odbc_exec($conexion, $graba1);
	}
	// Se consulta datos para firmas
	$con = odbc_exec($conexion,"SELECT nombre, cargo, cedula FROM cx_usu_web WHERE usuario='$usu_usuario'");
	$v_nom = trim(odbc_result($con,1));
	$v_car = trim(odbc_result($con,2));
	$v_ced = trim(odbc_result($con,3));
	$v_fir = $v_nom."»".$v_car."»".$v_ced."»";
	// Se consulta para saber cual plan fue rechazado cuando lo hace el Comandante del Batallon
	if ($estado == "Y")
	{
		$v_planes = "";
		$v_planes1 = array();
		$preg = "SELECT conse1, valor, valor_a FROM cx_pla_gas WHERE conse1 IN ($conses) AND ano='$ano'";
		$cur5 = odbc_exec($conexion, $preg);
	    $i = 1;
	    while($i<$row=odbc_fetch_array($cur5))
	    {
	       	$v_paso1 = odbc_result($cur5,1);
	        $v_paso2 = trim(odbc_result($cur5,2));
	       	$v_paso3 = trim(odbc_result($cur5,3));
	       	if ($v_paso2 == $v_paso3)
	       	{
	      	}
        	else
	        {
	        	// Si el valor aprobado no es igual al solicitado
				if (in_array($v_paso1, $v_planes1, true))
				{
				}
				else
				{
	    			array_push($v_planes1, $v_paso1);
	       			$v_planes .= "'".$v_paso1."',";
				}
        	}
	    }
		$cur6 = odbc_exec($conexion,"SELECT conse, val_fuen, val_fuen_a FROM cx_pla_pag WHERE conse IN ($conses) AND ano='$ano'");
	    $i = 1;
	    while($i<$row=odbc_fetch_array($cur6))
	    {
	       	$v_paso1 = odbc_result($cur6,1);
	        $v_paso2 = trim(odbc_result($cur6,2));
	       	$v_paso3 = trim(odbc_result($cur6,3));
	       	if ($v_paso2 == $v_paso3)
	       	{
	      	}
        	else
	        {
	        	// Si el valor aprobado no es igual al solicitado
				if (in_array($v_paso1, $v_planes1, true))
				{
				}
				else
				{
	    			array_push($v_planes1, $v_paso1);
	       			$v_planes .= "'".$v_paso1."',";
				}
        	}
	    }
	    $v_planes = substr($v_planes,0,-1);
	    if (trim($v_planes) == "")
	    {
	    	$v_planes = $conses;
	    }
		// Se actualiza estado de planes rechazados
		$graba2 = "UPDATE cx_pla_inv SET estado='$estado', autoriza='$con_usuario' WHERE conse IN ($v_planes) AND ano='$ano'";
		$sql1 = odbc_exec($conexion, $graba2);
		// Se consulta los usuarios de los planes rechazados
		$query1 = "SELECT conse, usuario, unidad FROM cx_pla_inv WHERE conse IN ($v_planes) AND ano='$ano'";
		$cur = odbc_exec($conexion, $query1);
        $i = 1;
	    while($i<$row=odbc_fetch_array($cur))
	    {
			$conse2 = odbc_result($cur,1);
			$usuario2 = trim(odbc_result($cur,2));
			$unidad2 = odbc_result($cur,3);
			// Se crea notificacion
			$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
			$consecu = odbc_result($cur1,1);
			$mensaje = "<br>SU PLAN / SOLICITUD CON EL NUMERO ".$conse2." HA SIDO RECHAZADO(A) POR: ".$motivo;
			// Se graba la notificacion
			$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$usuario2', '$unidad2', '$mensaje', '$estado', '1')";
			$sql2 = odbc_exec($conexion, $query2);
			// Se graba la observacion
			$query = "INSERT INTO cx_pla_rev (conse, usuario, unidad, estado, motivo, ano) VALUES ('$conse2', '$usu_usuario', '$uni_usuario', '$estado', '$motivo', '$ano')";
			$sql = odbc_exec($conexion, $query);
		}
		$oficial = $usuario2;
		// Se anula el consolidado de la tabla
		$query3 = "UPDATE cx_pla_con SET estado='X', unidad='999', firma3='$v_fir' WHERE unidad='$uni_usuario' AND estado IN ('H','I','J') AND periodo='$mes' AND ano='$ano'";
		$cur4 = odbc_exec($conexion, $query3);
	}
	if ($estado == "B")
	{
		if (($adm_usuario == "6") or ($adm_usuario == "25"))
		{
			$estado = "H";
		}
		if (($adm_usuario == "7") or ($adm_usuario == "9"))
		{
			if ($adm_usuario == "7")
			{
				$query3 = "UPDATE cx_pla_con SET estado='I', firma2='$v_fir' WHERE unidad='$uni_usuario' AND estado='H' AND periodo='$mes' AND ano='$ano'";
				$cur4 = odbc_exec($conexion, $query3);
				$cur4 = odbc_exec($conexion,"SELECT conse FROM cx_pla_con WHERE unidad='$uni_usuario' AND estado='I' AND periodo='$mes' AND ano='$ano'");
				$consecu = odbc_result($cur4,1);
				// Se acutalizan firmas
				$graba2 = "UPDATE cx_pla_inv SET firma6='$v_fir' WHERE conse IN ($conses) AND ano='$ano'";
				$sql1 = odbc_exec($conexion, $graba2);
			}
			else
			{
				$query3 = "UPDATE cx_pla_con SET estado='J', firma3='$v_fir' WHERE unidad='$uni_usuario' AND estado='I' AND periodo='$mes' AND ano='$ano'";
				$cur4 = odbc_exec($conexion, $query3);
				$cur4 = odbc_exec($conexion,"SELECT conse FROM cx_pla_con WHERE unidad='$uni_usuario' AND estado='J' AND periodo='$mes' AND ano='$ano'");
				$consecu = odbc_result($cur4,1);
				// Se acutalizan firmas
				$graba2 = "UPDATE cx_pla_inv SET firma7='$v_fir' WHERE conse IN ($conses) AND ano='$ano'";
				$sql1 = odbc_exec($conexion, $graba2);
				// Se graba en la tabla cx_val_aut
				$pre0 = "SELECT conse, unidad, usuario FROM cx_pla_inv WHERE conse IN ($conses) AND periodo='$mes' AND ano='$ano' AND estado='H' AND tipo='1' ORDER BY unidad";
				$con0 = odbc_exec($conexion,$pre0);
	    		while($i<$row=odbc_fetch_array($con0))
	    		{
	    			$p0 = trim(odbc_result($con0,3));
	    			$p1 = odbc_result($con0,1);
	    			$p2 = odbc_result($con0,2);
					$pre1 = "SELECT sigla, dependencia, unidad, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$p2'";
					$con1 = odbc_exec($conexion,$pre1);
					$p3 = trim(odbc_result($con1,1));
					// Validacion cambio de sigla
					$p3_1 = trim(odbc_result($con1,4));
					$p3_2 = trim(odbc_result($con1,5));
					if ($p3_2 == "")
					{
					}
					else
					{
						$p3_2 = str_replace("/", "-", $p3_2);
						if ($actual >= $p3_2)
						{
							$p3 = $p3_1;
						}
					}
					// Se suman valores aprobados
					$pre2 = "SELECT valor_a FROM cx_pla_gas WHERE conse1='$p1' AND ano='$ano'";
					$con2 = odbc_exec($conexion,$pre2);
					$p10 = 0;
					$con2_1 = odbc_num_rows($con2);
					if ($con2_1 > 0)
					{
		    			while($k<$row=odbc_fetch_array($con2))
		    			{
							$p4 = trim(odbc_result($con2,1));
						  	$p4 = str_replace(',','',$p4);
						  	$p4 = trim($p4);
						  	$p4 = floatval($p4);
							if ($p4 == "")
							{
								$p4 = "0.00";
							}
						  	$p10 = $p10+$p4;
						}
					}
					else
					{
						$p4 = 0;
					}
					// Se suman valores aprobados
					$pre3 = "SELECT val_fuen_a FROM cx_pla_pag WHERE conse='$p1' AND ano='$ano'";
					$con3 = odbc_exec($conexion,$pre3);
					$p9 = 0;
					$con3_1 = odbc_num_rows($con3);
					if ($con3_1 > 0)
					{
		    			while($k<$row=odbc_fetch_array($con3))
		    			{
							$p5 = trim(odbc_result($con3,1));
						  	$p5 = str_replace(',','',$p5);
						  	$p5 = trim($p5);
						  	$p5 = floatval($p5);
							if ($p5 == "")
							{
								$p5 = "0.00";
							}
						  	$p9 = $p9+$p5;
						}
					}
					else
					{
						$p5 = 0;
					}
				  	$p6 = $p10+$p9;
				  	$p7 = trim(odbc_result($con1,2));
				  	$p8 = trim(odbc_result($con1,3));
				  	// Se borra anteriores
					$borra = "DELETE FROM cx_val_aut WHERE unidad='$p2' AND periodo='$mes' AND ano='$ano' AND sigla='$p3'";
					odbc_exec($conexion, $borra);
					// Se calcula maximo de la tabla
					$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_val_aut");
					$consecu1 = odbc_result($cur,1);
					// Se graba discriminado de gastos
					$pre4 = "SELECT unidad FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
					$con4 = odbc_exec($conexion,$pre4);
					$p11 = odbc_result($con4,1);
					$pre5 = "SELECT especial FROM cx_org_sub WHERE unidad='$p11' AND unic='1'";
					$con5 = odbc_exec($conexion,$pre5);
					$p12 = odbc_result($con5,1);
					if ($p12 == "0")
					{
						$v_estado = "V";
					}
					else
					{
						$v_estado = "C";
					}
					$graba = "INSERT INTO cx_val_aut (conse, usuario, unidad, periodo, ano, sigla, gastos, pagos, total, depen, uom, estado, aprueba) VALUES ('$consecu1', '$p0', '$p2', '$mes', '$ano', '$p3', '$p10', '$p9', '$p6', '$p7', '$p8', '$v_estado', '$usu_usuario')";
					$cur9 = odbc_exec($conexion, $graba);
					// Se graba log
					$fec_log = date("d/m/Y H:i:s a");
					$file = fopen("log_val_aut.txt", "a");
					fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
					fclose($file);
	    		}
			}
		}
		else
		{
			if (($adm_usuario == "4") or ($adm_usuario == "6"))
			{
				// Se crea consecutivo en tabla de planes para consolidar
				$cur3 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_con WHERE ano='$ano'");
				$consecu = odbc_result($cur3,1);
				$query3 = "INSERT INTO cx_pla_con (conse, usuario, unidad, estado, periodo, ano, planes, firma1) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$estado', '$mes', '$ano', '$conses1', '$v_fir')";
				$cur4 = odbc_exec($conexion, $query3);
				// Se acutalizan los planes del consolidado
				$graba2 = "UPDATE cx_pla_inv SET estado='$estado', autoriza='$con_usuario', firma5='$v_fir' WHERE conse IN ($conses)";
				$sql1 = odbc_exec($conexion, $graba2);
			}
			else
			{
				if ($adm_usuario == "27")
				{
					$graba2 = "UPDATE cx_pla_inv SET usuario4='$oficial', firma4='$v_fir' WHERE conse IN ($conses) AND ano='$ano'";
					$sql1 = odbc_exec($conexion, $graba2);
				}
			}
		}
		// Se crea notificacion
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur1,1);
        $nom_pdf = "638_2.php?conse=".$consecu."&ano=".$ano;
        $nom_pdf1 = '<a href="./fpdf/'.$nom_pdf.'" target="_blank"><font color="#0000FF">Visualizar Plan</font></a>';
		if ($adm_usuario == "7")
		{
			$mensaje = "<br>SE HA REVISADO EL PLAN CONSOLIDADO NUMERO ".$consecu." DE ".$ano."&nbsp;&nbsp;&nbsp;".$nom_pdf1;
		}
		else
		{        
			$mensaje = "<br>SE HA GENERADO EL PLAN CONSOLIDADO NUMERO ".$consecu." DE ".$ano."&nbsp;&nbsp;&nbsp;".$nom_pdf1;
		}
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usu_usuario', '$uni_usuario', '$oficial', '$depen1', '$mensaje', '$estado', '1')";
		$sql2 = odbc_exec($conexion, $query2);
	}
    $notifica = $oficial;
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $estado;
    $salida->notifica = $notifica;
	echo json_encode($salida);
}
?>