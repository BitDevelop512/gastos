<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
    $tipo = $_POST['tipo'];
    $mes = $_POST['periodo'];
    $mes1 = intval($mes);
    $mes1 = $mes1-1;
    // Se consultan todas las unidades que estan en la centralizadora
    $query0 = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario' AND unic='1'";
    $cur0 = odbc_exec($conexion, $query0);
    $n_unidad = odbc_result($cur0,1);
    $n_unidad = intval($n_unidad);
    $n_dependencia = odbc_result($cur0,2);
    $n_dependencia = intval($n_dependencia);
    if ($n_unidad > 3)
    {
        $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
    }
    else
    {
        $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' ORDER BY dependencia, subdependencia";        
    }
    $cur1 = odbc_exec($conexion, $query1);
    $numero = "";
    while($i<$row=odbc_fetch_array($cur1))
    {
        $numero .= "'".odbc_result($cur1,1)."',";
    }
    $numero = substr($numero,0,-1);
	// Se consulta informacion de solicitud de recursos aprobadas
	//$query = "SELECT TOP 1 cx_pla_inv.conse, cx_pla_inv.actual, cx_pla_inv.unidad FROM cx_pla_inv, cx_val_aut1 WHERE cx_pla_inv.conse=cx_val_aut1.solicitud AND cx_pla_inv.ano='$ano' AND cx_pla_inv.tipo='2' AND cx_pla_inv.actual='$tipo' AND cx_pla_inv.estado='L' AND cx_pla_inv.aprueba='1' AND cx_pla_inv.unidad IN ($numero) ORDER BY NEWID()";

    // Cambio para traer varias solicitudes de recursos
    $query = "SELECT cx_pla_inv.conse, cx_pla_inv.actual, cx_pla_inv.unidad FROM cx_pla_inv, cx_val_aut1 WHERE cx_pla_inv.conse=cx_val_aut1.solicitud AND cx_pla_inv.ano='$ano' AND cx_pla_inv.tipo='2' AND cx_pla_inv.actual='$tipo' AND cx_pla_inv.estado='L' AND cx_pla_inv.aprueba='1' AND cx_pla_inv.unidad IN ($numero) ORDER BY unidad, conse";
    $cur = odbc_exec($conexion, $query);
    $valida = odbc_num_rows($cur);
    $datos = "";
    if ($valida == "0")
    {
    }
    else
    {
        while($i<$row=odbc_fetch_array($cur))
        {
            $interno = odbc_result($cur,1);
            $actual = odbc_result($cur,2);
            $unidad = odbc_result($cur,3);
            if ($actual == "1")
            {
                $query1 = "SELECT gastos FROM cx_val_aut1 WHERE solicitud='$interno' AND ano='$ano'";
            }
            else
            {
                $query1 = "SELECT pagos FROM cx_val_aut1 WHERE solicitud='$interno' AND ano='$ano'";
            }
            $cur1 = odbc_exec($conexion, $query1);
            $total = trim(odbc_result($cur1,1));
            $total = number_format($total,2);
            // Se consulta sigla unidad que genero la solicitud
            $valida = date('Y-m-d');
            $query2 = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unidad'";
            $cur2 = odbc_exec($conexion, $query2);
            $sigla = trim(odbc_result($cur2,1));
            $sigla1 = trim(odbc_result($cur2,2));
            $f_unidad = trim(odbc_result($cur2,3));
            if ($f_unidad == "")
            {
            }
            else
            {
                $f_unidad = str_replace("/", "-", $f_unidad);
                if ($valida >= $f_unidad)
                {
                    $sigla = $sigla1;
                }
            }
            // Se consultan las misiones
            if ($actual == "1")
            {
                $query3 = "SELECT mision FROM cx_pla_gas WHERE conse1='$interno' AND ano='$ano'";
                $cur3 = odbc_exec($conexion, $query3);
                $misiones = "";
                while($i<$row=odbc_fetch_array($cur3))
                {
                    $misiones .= trim(odbc_result($cur3,1)).",";
                }
                $misiones = substr($misiones,0,-1);
                $misiones = utf8_encode($misiones);
            }
            else
            {
                $misiones = "";
            }
            // Se consulta Informe de Giro
            $query4 = "SELECT inf_giro FROM cx_val_aut1 WHERE sigla='$sigla' AND solicitud='$interno' AND ano='$ano'";
            $cur4 = odbc_exec($conexion, $query4);
            $giro = odbc_result($cur4,1);
            // Se consulta Recurso y Rubro
            $query5 = "SELECT recurso, rubro FROM cx_inf_gir WHERE conse='$giro' AND unidad1='$uni_usuario' AND ano='$ano'";
            $cur5 = odbc_exec($conexion, $query5);
            $recurso = odbc_result($cur5,1);
            $rubro = odbc_result($cur5,2);
            if ($giro == "0")
            {
            }
            else
            {
                $datos .= $sigla."|".$total."|".$interno."|".$misiones."|".$giro."|".$recurso."|".$rubro."#";
            }
        }
    }
	$respuesta = array();
	$salida = new stdClass();
    $salida->datos = $datos;
    $salida->valida1 = $valida;
	echo json_encode($salida);
}
// 26/04/2024 - Ajuste validacion cambio de sigla
?>