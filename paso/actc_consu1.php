<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $conse = $_POST['conse'];
    $ano = $_POST['ano'];
    $registro = $_POST['registro'];
    $ano1 = $_POST['ano1'];
    $pregunta = "SELECT conse, firmas, sintesis, concepto, informacion, observaciones, elaboro, neutralizados, totaln, material, totalm, totala, valor, directiva, registro, ano1, acta, constancia, folio, valoracion, totali, reviso, fec_act, impacto, aprobacion FROM cx_act_cen WHERE conse='$conse' AND ano='$ano' AND registro='$registro' AND ano1='$ano1'";
    $sql = odbc_exec($conexion,$pregunta);
    $conse = odbc_result($sql,1);
    $firmas = trim(utf8_encode(odbc_result($sql,2)));
    $sintesis = trim(utf8_encode(odbc_result($sql,3)));
    $concepto = trim(utf8_encode(odbc_result($sql,4)));
    $informacion = trim(utf8_encode(odbc_result($sql,5)));
    $observaciones = trim(utf8_encode(odbc_result($sql,6)));
    $elaboro = trim(utf8_encode(odbc_result($sql,7)));
    $neutralizados = trim(utf8_encode(odbc_result($sql,8)));
    $totaln = trim(odbc_result($sql,9));
    if (($totaln == "") or ($totaln == "NaN"))
    {
        $totaln = "0.00";
    }
    $material1 = trim(odbc_result($sql,10));
    $totalm = trim(odbc_result($sql,11));
    if (($totalm == "") or ($totalm == "NaN"))
    {
        $totalm = "0.00";
    }
    $totala = trim(odbc_result($sql,12));
    if (($totala == "") or ($totala == "NaN"))
    {
        $totala = "0.00";
    }
    $valor = trim(odbc_result($sql,13));
    $directiva = odbc_result($sql,14);
    $registro = odbc_result($sql,15);
    $ano1 = odbc_result($sql,16);
    $acta = trim(odbc_result($sql,17));
    $constancia = trim(odbc_result($sql,18));
    $folio = trim(odbc_result($sql,19));
    $valoracion = trim(utf8_encode(odbc_result($sql,20)));
    $totali =  trim(odbc_result($sql,21));
    if (($totali == "") or ($totali == "NaN"))
    {
        $totali = "0.00";
    }
    $reviso = trim(utf8_encode(odbc_result($sql,22)));
    $fec_act = trim(odbc_result($sql,23));
    $impacto = trim(utf8_encode(odbc_result($sql,24)));
    $aprobacion = trim(utf8_encode(odbc_result($sql,25)));
    $pregunta1 = "SELECT salario FROM cx_ctr_ano WHERE ano='$ano1'";
    $sql1 = odbc_exec($conexion,$pregunta1);
    $salario = odbc_result($sql1,1);
    $pregunta2 = "SELECT usuario3, usuario4, codigo FROM cx_reg_rec WHERE conse='$registro' AND ano='$ano1'";
    $sql2 = odbc_exec($conexion,$pregunta2);
    $usuario = trim(odbc_result($sql2,1));
    $usuario1 = trim(odbc_result($sql2,2));
    $codigo = trim(odbc_result($sql2,3));
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
    $salida->conse = $conse;
    $salida->firmas = $firmas;
    $salida->sintesis = $sintesis;
    $salida->concepto = $concepto;
    $salida->informacion = $informacion;
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
    $salida->totali = $totali;
    $salida->reviso = $reviso;
    $salida->impacto = $impacto;
    $salida->aprobacion = $aprobacion;
    $salida->fec_act = $fec_act;
    $salida->salario = $salario;
    $salida->usuario = $usuario;
    $salida->usuario1 = $usuario1;
    $salida->codigo = $codigo;
    $salida->material = $material;
    $salida->niveles = $niveles;
    echo json_encode($salida);
}
?>