<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
    $actual = date('Y');
	$registro = trim($_POST['registro']);
	$num_registro = explode("-",$registro);
	$conse = trim($num_registro[0]);
	$ano = trim($num_registro[1]);
    $pregunta = "SELECT conse, firmas, sintesis, concepto, recomendaciones, observaciones, elaboro, neutralizados, totaln, material, totalm, totala, valor, directiva, registro, ano1, acta, constancia, folio, valoracion FROM cx_act_reg WHERE registro='$conse' AND ano1='$ano'";
    $sql = odbc_exec($conexion, $pregunta);
    $total = odbc_num_rows($sql);
    if ($total>0)
    {
        $conse1 = odbc_result($sql,1);
        $firmas = trim(utf8_encode(odbc_result($sql,2)));
        $sintesis = trim(utf8_encode(odbc_result($sql,3)));
        $concepto = trim(utf8_encode(odbc_result($sql,4)));
        $recomendaciones = trim(utf8_encode(odbc_result($sql,5)));
        $observaciones = trim(utf8_encode(odbc_result($sql,6)));
        $elaboro = trim(utf8_encode(odbc_result($sql,7)));
        $neutralizados = trim(utf8_encode(odbc_result($sql,8)));
        $totaln = trim(odbc_result($sql,9));
        $material1 = trim(odbc_result($sql,10));
        $totalm = trim(odbc_result($sql,11));
        $totala = trim(odbc_result($sql,12));
        $valor = trim(odbc_result($sql,13));
        $directiva = odbc_result($sql,14);
        $registro = odbc_result($sql,15);
        $ano1 = odbc_result($sql,16);
        $acta = trim(odbc_result($sql,17));
        $constancia = trim(odbc_result($sql,18));
        $folio = trim(odbc_result($sql,19));
        $valoracion = trim(utf8_encode(odbc_result($sql,20)));
    }
    else
    {
        $pregunta = "SELECT valor, directiva FROM cx_reg_rec WHERE conse='$conse' AND ano='$ano'";
        $sql = odbc_exec($conexion, $pregunta);
        $valor = trim(odbc_result($sql,1));
        $directiva = odbc_result($sql,2);
        $neutralizados = "";
        $totaln = "0.00";
        $material1 = "";
        $totalm = "0.00";
        $totala = "0.00";
        $conse1 = "0";
    }
    $pregunta2 = "SELECT usuario3, usuario4, codigo, fec_res, ano1, tipo FROM cx_reg_rec WHERE conse='$conse' AND ano='$ano'";
    $sql2 = odbc_exec($conexion,$pregunta2);
    $usuario = trim(odbc_result($sql2,1));
    $usuario1 = trim(odbc_result($sql2,2));
    $codigo = trim(odbc_result($sql2,3));
    $fec_res = odbc_result($sql2,4);
    $ano2 = odbc_result($sql2,5);
    if ($ano2 == "0")
    {
        $fechas = explode("/", $fec_res);
        $ano2 = $fechas[0];
        $actualiza = "UPDATE cx_reg_rec SET ano1='$ano2' WHERE conse='$conse' AND ano='$ano' AND ano1='0'";
        odbc_exec($conexion, $actualiza);
    }
    $tipo = odbc_result($sql2,6);
    $pregunta1 = "SELECT salario FROM cx_ctr_ano WHERE ano='$ano2'";
    $sql1 = odbc_exec($conexion, $pregunta1);
    $salario = odbc_result($sql1,1);
    $pregunta3 = "SELECT firma3, cargo3, firma2, cargo2 FROM cx_org_sub WHERE subdependencia='1'";
    $sql3 = odbc_exec($conexion,$pregunta3);
    $firma1 = trim(utf8_encode(odbc_result($sql3,1)));
    $cargo1 = trim(utf8_encode(odbc_result($sql3,2)));
    $firma2 = trim(utf8_encode(odbc_result($sql3,3)));
    $cargo2 = trim(utf8_encode(odbc_result($sql3,4)));
    $firmas = $firma1."»".$cargo1."|".$firma2."»".$cargo2."|";
    $query1 = "SELECT * FROM cx_ctr_mat WHERE directiva='$directiva'";
    $cur1 = odbc_exec($conexion, $query1);
    $material = "";
    $i = 1;
    while ($i < $row = odbc_fetch_array($cur1))
	{
 		$v1 = odbc_result($cur1,1);
 		$v2 = utf8_encode($row['nombre']);
 		$v3 = odbc_result($cur1,3);
 		$v4 = trim(odbc_result($cur1,4));
 		$v4 = str_replace(',','',$v4);
 		$v4 = trim($v4);
 		$v4 = floatval($v4);
 		$v5 = trim(odbc_result($cur1,5));
 		$v5 = str_replace(',','',$v5);
 		$v5 = trim($v5);
 		$v5 = floatval($v5);
 		$v6 = trim(odbc_result($cur1,6));
 		$v6 = str_replace(',','',$v6);
 		$v6 = trim($v6);
 		$v6 = floatval($v6);
 		$material .= $v1."|".$v2."|".$v3."|".$v4."|".$v5."|".$v6."|#";
		$i++;
    }
    $query2 = "SELECT * FROM cx_ctr_niv WHERE directiva='$directiva' ORDER BY tipo, nivel";
    $cur2 = odbc_exec($conexion, $query2);
    $niveles = "";
    $i = 1;
    while ($i < $row = odbc_fetch_array($cur2))
    {
        $v1 = odbc_result($cur2,1);
        $v2 = odbc_result($cur2,2);
        $v3 = odbc_result($cur2,3);
        $v4 = odbc_result($cur2,5);
        $niveles .= $v1."|".$v2."|".$v3."|".$v4."|#";
        $i++;
    }
    $salida = new stdClass();
    $salida->conse = $conse1;
    $salida->firmas = $firmas;
    $salida->sintesis = $sintesis;
    $salida->concepto = $concepto;
    $salida->recomendaciones = $recomendaciones;
    $salida->observaciones = $observaciones;
    $salida->elaboro = $elaboro;
    $salida->neutralizados = $neutralizados;
    $salida->totaln = $totaln;
    $salida->material1 = $material1;
    $salida->totalm = $totalm;
    $salida->totala = $totala;
    $salida->valor = $valor;
    $salida->directiva = $directiva;
    $salida->registro = $registro;
    $salida->ano1 = $ano1;
    $salida->acta = $acta;
    $salida->constancia = $constancia;
    $salida->folio = $folio;
    $salida->valoracion = $valoracion;
    $salida->salario = $salario;
    $salida->usuario = $usuario;
    $salida->usuario1 = $usuario1;
    $salida->codigo = $codigo;
    $salida->tipo = $tipo;
    $salida->material = $material;
    $salida->niveles = $niveles;
    echo json_encode($salida);
}
?>