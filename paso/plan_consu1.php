<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $plan = $_POST['plan'];
    $ano = $_POST['ano'];
    $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$plan' AND ano='$ano'";
    $sql = odbc_exec($conexion,$pregunta);
    $conse = odbc_result($sql,1);
    $fecha = substr(odbc_result($sql,2),0,10);
    $usu_crea = trim(odbc_result($sql,3));
    $lugar = odbc_result($sql,6);
    $lugar = trim(decrypt1($lugar, $llave));
    $lugar = utf8_encode($lugar);
    $factor = trim(odbc_result($sql,7));
    $estructura = trim(odbc_result($sql,8));
    $periodo = odbc_result($sql,9);
    $oficiales = odbc_result($sql,10);
    $suboficiales = odbc_result($sql,11);
    $auxiliares = odbc_result($sql,12);
    $soldados = odbc_result($sql,13);
    $ordop = trim(utf8_encode(odbc_result($sql,14)));
    if ($ordop == "")
    {
    }
    else
    {
        $ordop = trim(decrypt1($ordop, $llave));
        $ordop = strtr($ordop, $sustituye1);
        $valida1 = strpos($ordop, "Á");
        $valida1 = intval($valida1);
        if ($valida1 == "0")
        {
    		$valida1 = strpos($ordop, "É");
    		$valida1 = intval($valida1);
    		if ($valida1 == "0")
    		{
    			$valida1 = strpos($ordop, "Í");
    			$valida1 = intval($valida1);
    			if ($valida1 == "0")
    			{
                    $valida1 = strpos($ordop, "Ó");
                    $valida1 = intval($valida1);
                    if ($valida1 == "0")
                    {
                        $valida1 = strpos($ordop, "Ú");
                        $valida1 = intval($valida1);
                        if ($valida1 == "0")
                        {
                            $valida1 = strpos($ordop, "Ñ");
                            $valida1 = intval($valida1);
                            if ($valida1 == "0")
                            {
                                $ordop = utf8_encode($ordop);
                            }
                        }
                    }
    		    }
    		}
        }
    }
    $n_ordop = trim(utf8_encode(odbc_result($sql,15)));
    if ($n_ordop == "")
    {
    }
    else
    {
        $n_ordop = trim(decrypt1($n_ordop, $llave));
        $n_ordop = strtr($n_ordop, $sustituye1);
    }
    $n_misiones = odbc_result($sql,17);
    $misiones = odbc_result($sql,16);
    $misiones = trim(decrypt1($misiones, $llave));
    $tipo = odbc_result($sql,20);
    $actual = odbc_result($sql,21);
    $ano = odbc_result($sql,22);
    $oms = trim(odbc_result($sql,23));
    $tipo1 = odbc_result($sql,27);
    $nivel = odbc_result($sql,56);
    // Factores
    $query2 = "SELECT nombre, codigo FROM cx_ctr_fac WHERE codigo IN ($factor) ORDER BY codigo";
    $sql2 = odbc_exec($conexion, $query2);
    $nom_fact = "";
    $nom_fact1 = "";
    while($i<$row=odbc_fetch_array($sql2))
    {
        $nom_fact .= trim(utf8_encode(odbc_result($sql2,1))).", ";
        $nom_fact1 .= "<option value='".odbc_result($sql2,2)."'>".trim(utf8_encode(odbc_result($sql2,1)))."</option>";
    }
    $nom_fact = trim(substr($nom_fact, 0, -2));
    // Estructuras
    if ($estructura == "")
    {
        $query3 = "SELECT nombre, codigo FROM cx_ctr_est WHERE codigo='999' ORDER BY codigo";
    }
    else
    {
        $query3 = "SELECT nombre, codigo FROM cx_ctr_est WHERE codigo IN ($estructura) ORDER BY codigo";
    }
    $sql3 = odbc_exec($conexion, $query3);
    $nom_estr = "";
    $nom_estr1 = "";
    while($i<$row=odbc_fetch_array($sql3))
    {
        $nom_estr .= trim(utf8_encode(odbc_result($sql3,1))).", ";
        $nom_estr1 .= "<option value='".odbc_result($sql3,2)."'>".trim(utf8_encode(odbc_result($sql3,1)))."</option>";
    }
    $nom_estr = trim(substr($nom_estr, 0, -2));
    // Si la ciudad llego en blanco
    if ($lugar == "")
    {
        $query4 = "SELECT ciudad FROM cx_usu_web WHERE usuario='$usu_crea'";
        $sql4 = odbc_exec($conexion, $query4);
        $lugar = trim(utf8_encode(odbc_result($sql4,1)));
    }
    $salida = new stdClass();
    $salida->conse = $conse;
    $salida->fecha = $fecha;
    $salida->lugar = $lugar;
    $salida->factor = $factor;
    $salida->estructura = $estructura;
    $salida->periodo = $periodo;
    $salida->oficiales = $oficiales;
    $salida->suboficiales = $suboficiales;
    $salida->auxiliares = $auxiliares;
    $salida->soldados = $soldados;
    $salida->ordop = $ordop;
    $salida->n_ordop = $n_ordop;
    $salida->n_misiones = $n_misiones;
    $salida->misiones = $misiones;
    $salida->tipo = $tipo;
    $salida->actual = $actual;
    $salida->tipo1 = $tipo1;
    $salida->ano = $ano;
    $salida->factores = $nom_fact;
    $salida->factores1 = $nom_fact1;
    $salida->estructuras = $nom_estr;
    $salida->estructuras1 = $nom_estr1;
    $salida->oms = $oms;
    $salida->nivel = $nivel;
    echo json_encode($salida);
}
?>