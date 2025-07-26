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
    $tipo = trim($num_registro[2]);
    if ($tipo == "0")
    {
        $pregunta = "SELECT conse, firmas, sintesis, concepto, observaciones, elaboro, neutralizados, totaln, material, totalm, totali, totala, valor, directiva, registro, ano1, acta, constancia, folio, valoracion FROM cx_act_cen WHERE registro='$conse' AND ano1='$ano'";
        $sql = odbc_exec($conexion,$pregunta);
        $total = odbc_num_rows($sql);
        $conse1 = odbc_result($sql,1);
        $firmas = trim(utf8_encode(odbc_result($sql,2)));
        $sintesis = trim(utf8_encode(odbc_result($sql,3)));
        $concepto = trim(utf8_encode(odbc_result($sql,4)));
        $observaciones = trim(utf8_encode(odbc_result($sql,5)));
        $elaboro = trim(utf8_encode(odbc_result($sql,6)));
        $neutralizados = trim(utf8_encode(odbc_result($sql,7)));
        $totaln = trim(odbc_result($sql,8));
        $material1 = trim(odbc_result($sql,9));
        $totalm = trim(odbc_result($sql,10));
        $totali = trim(odbc_result($sql,11));
        $totala = trim(odbc_result($sql,12));
        $valor = trim(odbc_result($sql,13));
        $directiva = odbc_result($sql,14);
        $registro = odbc_result($sql,15);
        $ano1 = odbc_result($sql,16);
        $acta = trim(odbc_result($sql,17));
        $constancia = odbc_result($sql,18);
        $folio = trim(odbc_result($sql,19));
        $valoracion = trim(utf8_encode(odbc_result($sql,20)));
        $pregunta1 = "SELECT cedulas, nombres, porcentajes, porcentajes1, actas, fechas, valores, valores1 FROM cx_reg_rec WHERE conse='$conse' AND ano='$ano'";
        $sql1 = odbc_exec($conexion,$pregunta1);
        $cedulas = trim(odbc_result($sql1,1));
        $nombres = trim(utf8_encode(odbc_result($sql1,2)));
        $porcentajes = trim(odbc_result($sql1,3));
        $porcentajes1 = trim(odbc_result($sql1,4));
        $actas = trim(odbc_result($sql1,5));
        $fechas = trim(odbc_result($sql1,6));
        $valores = trim(odbc_result($sql1,7));
        $valores1 = trim(odbc_result($sql1,8));
        $pregunta2 = "SELECT cedulas FROM cx_act_rec WHERE registro='$conse' AND ano1='$ano'";
        $sql2 = odbc_exec($conexion,$pregunta2);
        $fuentes = "";
        $i = 1;
        while ($i < $row = odbc_fetch_array($sql2))
        {
            $fuentes .= trim(utf8_encode($row["cedulas"])).",";
        }
        $num_fuentes = explode(",",$fuentes);
        $cedulas1 = "";
        for ($i=0; $i<count($num_fuentes)-1; ++$i)
        {
            $cedulas2 = trim($num_fuentes[$i]);
            $num_cedulas2 = explode("|",$cedulas2);
            $cedulas1 .= trim($num_cedulas2[0])."#";
        }
        $salida = new stdClass();
        $salida->total = $total;
        $salida->conse = $conse1;
        $salida->firmas = $firmas;
        $salida->sintesis = $sintesis;
        $salida->concepto = $concepto;
        $salida->observaciones = $observaciones;
        $salida->elaboro = $elaboro;
        $salida->neutralizados = $neutralizados;
        $salida->totaln = $totaln;
        $salida->material1 = $material1;
        $salida->totalm = $totalm;
        $salida->totali = $totali;
        $salida->totala = $totala;
        $salida->valor = $valor;
        $salida->directiva = $directiva;
        $salida->registro = $registro;
        $salida->ano1 = $ano1;
        $salida->acta = $acta;
        $salida->constancia = $constancia;
        $salida->folio = $folio;
        $salida->valoracion = $valoracion;
        $salida->cedulas = $cedulas;
        $salida->nombres = $nombres;
        $salida->porcentajes = $porcentajes;
        $salida->porcentajes1 = $porcentajes1;
        $salida->actas = $actas;
        $salida->fechas = $fechas;
        $salida->valores = $valores;
        $salida->valores1 = $valores1;
        $salida->fuentes = $cedulas1;
    }
    else
    {
        $pregunta = "SELECT cedulas, nombres, porcentajes, porcentajes1, actas, fechas, valores, valores1, valor FROM cx_rec_man WHERE conse='$conse' AND ano='$ano'";
        $sql = odbc_exec($conexion,$pregunta);
        $cedulas = trim(odbc_result($sql,1));
        $nombres = trim(utf8_encode(odbc_result($sql,2)));
        $porcentajes = trim(odbc_result($sql,3));
        $porcentajes1 = trim(odbc_result($sql,4));
        $actas = trim(odbc_result($sql,5));
        $fechas = trim(odbc_result($sql,6));
        $valores = trim(odbc_result($sql,7));
        $valores1 = trim(odbc_result($sql,8));
        $valor = odbc_result($sql,9);
        $salida = new stdClass();
        $salida->registro = $registro;
        $salida->ano1 = $ano;
        $salida->totala = $valor;
        $salida->cedulas = $cedulas;
        $salida->nombres = $nombres;
        $salida->porcentajes = $porcentajes;
        $salida->porcentajes1 = $porcentajes1;
        $salida->actas = $actas;
        $salida->fechas = $fechas;
        $salida->valores = $valores;
        $salida->valores1 = $valores1;
    }
    $salida->tipo = $tipo;
    echo json_encode($salida);
}
?>