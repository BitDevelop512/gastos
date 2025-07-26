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
	$oficial = trim($_POST['oficial']);
	$conses = $_POST['conses'];
	$consos = $_POST['consos'];
	$unidad = $_POST['unidad'];
	$estado = $_POST['estado'];
	$ano = $_POST['ano'];
	$valores1 = $_POST['valores1'];
	$valores2 = $_POST['valores2'];
	$valores3 = $_POST['valores3'];
	$valores4 = $_POST['valores4'];
	$valores5 = $_POST['valores5'];
	$valores6 = $_POST['valores6'];
	$valores7 = $_POST['valores7'];
	$valores8 = $_POST['valores8'];
	$valores9 = $_POST['valores9'];
	$motivo = $_POST['motivo'];
	$motivo = iconv("UTF-8", "ISO-8859-1", $motivo);
	$conses1 = encrypt1($conses, $llave);
	$consos1 = encrypt1($consos, $llave);
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
	$num_valores6 = explode("|",$valores6);
	for ($i=0;$i<count($num_valores6);++$i)
	{
		$f[$i] = trim($num_valores6[$i]);
	}
	$num_valores7 = explode("|",$valores7);
	for ($i=0;$i<count($num_valores7);++$i)
	{
		$g[$i] = trim($num_valores7[$i]);
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
		// Se actualizan los valores aprobados o rechazados
		for ($i=0;$i<(count($num_valores1)-1);++$i)
		{
			$var1 = trim($a[$i]);
			$var2 = trim($f[$i]);
			$var3 = trim($c[$i]);
			if ($var1 == "0.00")
			{
				$pregunta = "SELECT conse, usuario FROM cx_pla_con WHERE unidad='$var2' AND estado='J' AND periodo='$mes' AND ano='$ano'";
				$sql = odbc_exec($conexion,$pregunta);
				$total = odbc_num_rows($sql);
				if ($total > 0)
				{
					$var_conse = odbc_result($sql,1);
					$var_usuario = trim(odbc_result($sql,2));
				}
				else
				{
					$pregunta0 = "SELECT conse, usuario FROM cx_pla_inv WHERE unidad='$var2' AND periodo='$mes' AND ano='$ano' AND tipo='1' AND estado IN ('P', 'H')";
					$sql0 = odbc_exec($conexion,$pregunta0);
					$var_plan = "'".odbc_result($sql0,1)."'";
					$var_plan1 = encrypt1($var_plan, $llave);
					$var_plan2 = odbc_result($sql0,1);
					$var_usuario = trim(odbc_result($sql0,2));
					$pregunta = "SELECT conse, usuario, unidad FROM cx_pla_con WHERE estado='J' AND periodo='$mes' AND ano='$ano' AND planes LIKE '%$var_plan1%'";
					$sql = odbc_exec($conexion,$pregunta);
					$total = odbc_num_rows($sql);
					if ($total > 0)
					{
						$var_conse = odbc_result($sql,1);
						$var_usuario = trim(odbc_result($sql,2));
						$var2 = odbc_result($sql,3);
					}
					else
					{
						$graba = "UPDATE cx_pla_inv SET estado='Y' WHERE conse='$var_plan2' AND unidad='$var2' AND periodo='$mes' AND ano='$ano' AND tipo='1' AND estado IN ('P', 'H')";
						$sql = odbc_exec($conexion, $graba);
					}
				}
				// Se crea notificacion
				$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
				$consecu = odbc_result($cur,1);
				$mensaje = "SU PLAN CONSOLIDADO CON EL NUMERO ".$var_conse." DEL PERIODO ".$mes." / ".$ano." HA SIDO RECHAZADO(A) POR: ".$motivo;
				// Se graba la notificacion
				$pregunta1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$var_usuario', '$var2', '$mensaje', '$estado', '1')";
				$sql1 = odbc_exec($conexion, $pregunta1);
				// Se actualiza el valor plan consolidado rechazados
				$graba = "UPDATE cx_pla_con SET estado='X', unidad='999', firma4='$v_fir' WHERE unidad='$var2' AND estado='J' AND periodo='$mes' AND ano='$ano'";
				$sql = odbc_exec($conexion, $graba);
				$oficial = $var_usuario;
			}
		}
	}
	if ($estado == "B")
	{
		if (($adm_usuario == "11") or ($adm_usuario == "13"))
		{
			if ($adm_usuario == "11")
			{
				// Se cambia estado del plan de inversion
				$graba1 = "UPDATE cx_pla_inv SET usuario5='$oficial', firma3='$v_fir' WHERE unidad='$uni_usuario' AND periodo='$mes' AND ano='$ano' AND tipo='1' AND estado='H'";
				$cur10 = odbc_exec($conexion, $graba1);
				$query = "UPDATE cx_pla_con SET estado='I', firma2='$v_fir' WHERE unidad='$uni_usuario' AND estado='B' AND periodo='$mes' AND ano='$ano'";
			}
			else
			{
				// Se cambia estado del plan de inversion
				$graba1 = "UPDATE cx_pla_inv SET usuario6='$oficial', firma5='$v_fir' WHERE unidad='$uni_usuario' AND periodo='$mes' AND ano='$ano' AND tipo='1' AND estado='H'";
				$cur10 = odbc_exec($conexion, $graba1);
				$query = "UPDATE cx_pla_con SET estado='J', firma3='$v_fir' WHERE unidad='$uni_usuario' AND estado='I' AND periodo='$mes' AND ano='$ano'";
			}
			$cur = odbc_exec($conexion, $query);
			$pregunta = "SELECT conse FROM cx_pla_con WHERE unidad='$uni_usuario' AND estado IN ('I','J') AND periodo='$mes' AND ano='$ano'";
			$sql = odbc_exec($conexion, $pregunta);
			$consecu = odbc_result($sql,1);
			if ($adm_usuario == "13")
			{
				$v_espe = "";
				$pre1 = "SELECT especial FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
				$cur1 = odbc_exec($conexion, $pre1);
				$p0 = odbc_result($cur1,1);
				$pre2 = "SELECT unidad FROM cx_org_sub WHERE especial='$p0'";
				$cur2 = odbc_exec($conexion, $pre2);
			    $i = 1;
			    while($i<$row=odbc_fetch_array($cur2))
			    {
			    	$v_espe .= odbc_result($cur2,1).",";
			    	$i++;
				}
				$v_espe = substr($v_espe,0,-1);
				$graba = "UPDATE cx_val_aut SET estado='V' WHERE uom IN ($v_espe) AND periodo='$mes' AND ano='$ano' AND estado='C'";
				$cur3 = odbc_exec($conexion, $graba);

			}
		}
		else
		{
			// Se crea consecutivo en tabla de planes para consolidar
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_con WHERE ano='$ano'");
			$consecu = odbc_result($cur,1);
			$pregunta = "INSERT INTO cx_pla_con (conse, usuario, unidad, estado, periodo, ano, planes, firma1, consolidado) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$estado', '$mes', '$ano', '$conses1', '$v_fir', '$consos1')";
			$sql = odbc_exec($conexion, $pregunta);
			// Se graba los valores faltantes en la tabla cx_val_aut que estan en estado = P
			$num_valores8 = explode("|",$valores8);
			for ($i=0;$i<count($num_valores8)-1;++$i)
			{
				$paso = $num_valores8[$i];
				$num_paso = explode("»",$paso);
				$p0 = $num_paso[0];
				$p1 = trim($num_paso[1]);
				$p1 = str_replace(',','',$p1);
				$p1 = trim($p1);
				$p1 = floatval($p1);
				$p2 = $num_paso[2];
				$pre1 = "SELECT sigla, dependencia, unidad, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$p2'";
				$cur1 = odbc_exec($conexion, $pre1);
				$p3 = trim(odbc_result($cur1,1));
				// Validacion cambio de sigla
				$p3_1 = trim(odbc_result($cur1,4));
				$p3_2 = trim(odbc_result($cur1,5));
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
				$p4 = odbc_result($cur1,2);
				$p5 = odbc_result($cur1,3);
				// Se borra anteriores
				$borra = "DELETE FROM cx_val_aut WHERE unidad='$p2' AND periodo='$mes' AND ano='$ano' AND sigla='$p3'";
				odbc_exec($conexion, $borra);
				$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_val_aut");
				$conse2 = odbc_result($cur2,1);
				$graba = "INSERT INTO cx_val_aut (conse, usuario, unidad, periodo, ano, sigla, gastos, pagos, total, depen, uom, estado, aprueba) VALUES ('$conse2', '$usu_usuario', '$p2', '$mes', '$ano', '$p3', '$p1', '0', '$p1', '$p4', '$p5', 'C', '$usu_usuario')";
				$cur9 = odbc_exec($conexion, $graba);
				// Se cambia estado del plan de inversion
				$graba1 = "UPDATE cx_pla_inv SET estado='H', usuario4='$oficial' WHERE unidad='$p2' AND periodo='$mes' AND ano='$ano' AND tipo='1' AND estado='P'";
				$cur10 = odbc_exec($conexion, $graba1);
			}
			$num_valores9 = explode("|",$valores9);
			for ($i=0;$i<count($num_valores9)-1;++$i)
			{
				$paso = $num_valores9[$i];
				$num_paso = explode("»",$paso);
				$p0 = $num_paso[0];
				$p1 = trim($num_paso[1]);
				$p1 = str_replace(',','',$p1);
				$p1 = trim($p1);
				$p1 = floatval($p1);
				$p2 = $num_paso[2];
				$pre1 = "SELECT sigla, dependencia, unidad FROM cx_org_sub WHERE subdependencia='$p2'";
				$cur1 = odbc_exec($conexion, $pre1);
				$p3 = trim(odbc_result($cur1,1));
				$p4 = odbc_result($cur1,2);
				$p5 = odbc_result($cur1,3);
				// Se borra anteriores
				$borra = "DELETE FROM cx_val_aut WHERE unidad='$p2' AND periodo='$mes' AND ano='$ano' AND sigla='$p3'";
				odbc_exec($conexion, $borra);
				$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_val_aut");
				$conse2 = odbc_result($cur2,1);
				$cur4 = odbc_exec($conexion,"SELECT * FROM cx_val_aut WHERE unidad='$p2' AND sigla='$p3' AND periodo='$mes' AND ano='$ano'");
				$contador = odbc_num_rows($cur4);
				if ($contador == "0")
				{
					$graba = "INSERT INTO cx_val_aut (conse, usuario, unidad, periodo, ano, sigla, gastos, pagos, total, depen, uom, estado, aprueba) VALUES ('$conse2', '$usu_usuario', '$p2', '$mes', '$ano', '$p3', '0', '$p1', '$p1', '$p4', '$p5', 'C', '$usu_usuario')";
					$cur9 = odbc_exec($conexion, $graba);
				}
				else
				{
					$p6 = odbc_result($cur4,1);
					$p7 = odbc_result($cur4,8);
					$p7 = floatval($p7);
					$p8 = $p7+$p1;
					$graba = "UPDATE cx_val_aut SET pagos='$p1', total='$p8' WHERE conse='$p6' AND unidad='$p2' AND sigla='$p3' AND periodo='$mes' AND ano='$ano'";
					$cur9 = odbc_exec($conexion, $graba);
				}
			}
		}
		// Se crea notificacion
		$cur2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu2 = odbc_result($cur2,1);
        $nom_pdf = "638_3.php?conse=".$consecu."&ano=".$ano;
        $nom_pdf1 = '<a href="./fpdf/'.$nom_pdf.'" target="_blank"><font color="#0000FF">Visualizar Plan</font></a>';
		if ($adm_usuario == "10")
		{
			$mensaje = "SE HA GENERADO EL PLAN CONSOLIDADO NUMERO ".$consecu." DEL PERIODO ".$mes." / ".$ano."&nbsp;&nbsp;&nbsp;".$nom_pdf1;
		}
		else
		{        
			$mensaje = "SE HA REVISADO EL PLAN CONSOLIDADO NUMERO ".$consecu." DEL PERIODO ".$mes." / ".$ano."&nbsp;&nbsp;&nbsp;".$nom_pdf1;
		}
		$cur3 = odbc_exec($conexion,"SELECT unidad FROM cx_usu_web WHERE usuario='$oficial'");
		$uni_usuario1 = odbc_result($cur3,1);

		$pregunta1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu2', '$usu_usuario', '$uni_usuario', '$oficial', '$uni_usuario1', '$mensaje', '$estado', '1')";
		$sql1 = odbc_exec($conexion, $pregunta1);
	}
    $notifica = $oficial;
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $estado;
    $salida->notifica = $notifica;
	echo json_encode($salida);
}
?>