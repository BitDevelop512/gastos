<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $tipo = $_POST['tipo'];
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $ano = $_POST['ano'];
    $b_unidad = $_POST['b_unidad'];
    if ($sup_usuario == "1")
    {
        if ($b_unidad == "999")
        {
            $pregunta = "SELECT * FROM cx_pla_inv WHERE 1=1";
        }
        else
        {
            $pregunta = "SELECT * FROM cx_pla_inv WHERE unidad='$b_unidad'";
        }
        $pregunta .= " AND ano='$ano'";
    }
    else
    {
        switch ($adm_usuario)
        {
            case '3':
                $pregunta = "SELECT * FROM cx_pla_inv WHERE unidad='$uni_usuario'";
                if ($tipo == "3")
                {
                }
                else
                {
                    $pregunta .= " and tipo='$tipo'";
                }
                break;
            // Revisa todos los de la Brigada
            case '7':
                $query = "SELECT unidad,dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
                $cur = odbc_exec($conexion, $query);
                $n_unidad = odbc_result($cur,1);
                $n_dependencia = odbc_result($cur,2);
                $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' ORDER BY subdependencia";
                $cur1 = odbc_exec($conexion, $query1);
                $numero = "";
                while($i<$row=odbc_fetch_array($cur1))
                {
                    $numero .= "'".odbc_result($cur1,1)."',";
                }
                $numero = substr($numero,0,-1);
                $pregunta = "SELECT * FROM cx_pla_inv WHERE unidad IN ($numero)";
                break;
            default:
                $pregunta = "SELECT * FROM cx_pla_inv WHERE unidad='$uni_usuario' AND compania='$tip_usuario' AND ((usuario='$usu_usuario') OR (usuario='$log_usuario'))";
                break;
        }
    }
    if ($tipo == "3")
    {
    }
    else
    {
        $pregunta .= " AND tipo='$tipo'";
    }
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1)";
    }
    $pregunta .= " ORDER BY fecha DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $unidad = $row['unidad'];
            $unidad_a = $row['uni_anu'];
            if (($unidad == "0") or ($unidad == "999"))
            {
                $query1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad_a'";
                $cur1 = odbc_exec($conexion, $query1);
                $n_uni = trim(odbc_result($cur1,1))." - Anulado";
            }
            else
            {
                $query1 = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unidad'";
                $cur1 = odbc_exec($conexion, $query1);
                $n_uni = trim(odbc_result($cur1,1));
                $n_uni1 = trim(odbc_result($cur1,2));
                $n_fecha = trim(odbc_result($cur1,3));
                if ($n_fecha == "")
                {
                }
                else
                {
                    $n_fecha = str_replace("/", "-", $n_fecha);
                    $p_fecha = substr($row["fecha"],0,10);
                    if ($p_fecha >= $n_fecha)
                    {
                        $n_uni = $n_uni1;
                    }
                }
            }
            $tipo = $row['tipo'];
            $periodo = $row['periodo'];
            $ano = $row['ano'];
            if ($tipo == "1")
            {
                $n_tipo = "Plan de Inversión";
            }
            else
            {
                $n_tipo = "Solicitud de Recursos";
            }
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
            $salida->rows[$i]['usuario'] = trim($row['usuario']);
            $salida->rows[$i]['unidad'] = $n_uni;
            $salida->rows[$i]['tipo'] = $n_tipo;
            $salida->rows[$i]['tipo1'] = $tipo;
            $salida->rows[$i]['estado'] = $row['estado'];
            $salida->rows[$i]['periodo'] = $periodo;
            $salida->rows[$i]['ano'] = $ano;
            $salida->rows[$i]['servidor'] = trim($row['servidor']);
            $i++;
        }
    	$salida->salida = "1";
      	$salida->total = $total;
    }
    else
    {
    	$salida->salida = "0";
      	$salida->total = "0";
    }
    echo json_encode($salida);
}
// 04/08/2023 - Ajuste para cambio de sigla en la consulta de la unidad
// 02/04/2024 - Ajuste consulta ano
// 03/12/2024 - Ajuste identificador contingencia
?>