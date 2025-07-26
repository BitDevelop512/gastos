<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $tipo = $_POST['tipo'];
    $unidades = $_POST['unidades'];
    $unidades1 = $_POST['unidades1'];
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    if ($tipo == "1")
    {
        if ($sup_usuario == "1")
        {
            $pregunta = "SELECT * FROM cx_act_inf WHERE 1=1";
            if ($unidades1 == "999")
            {
            }
            else
            {
                $pregunta .= " AND unidad='$unidades1'";
            }
        }
        else
        {
            $pregunta = "SELECT * FROM cx_act_inf WHERE unidad='$uni_usuario' AND ((usuario='$usu_usuario') OR (usuario='$log_usuario'))";
        }
        if (!empty($_POST['fecha1']))
        {
            $pregunta .= " AND convert(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
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
                $query1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
                $cur1 = odbc_exec($conexion, $query1);
                $n_uni = trim(odbc_result($cur1,1));
                $ano = $row['ano'];
                $salida->rows[$i]['conse'] = $row['conse'];
                $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
                $salida->rows[$i]['usuario'] = trim($row['usuario']);
                $salida->rows[$i]['unidad'] = $n_uni;
                $salida->rows[$i]['fuente'] = trim(utf8_encode($row['fuente']));
                $salida->rows[$i]['valor'] = trim($row['valor']);
                $salida->rows[$i]['ano'] = $ano;
                $salida->rows[$i]['plan'] = $row['pla_inv'];
                $salida->rows[$i]['unidad1'] = $row['unidad'];
                $salida->rows[$i]['numero'] = trim(utf8_encode($row['numero']));
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
    }
    else
    {
        $pregunta = "SELECT * FROM cx_act_inf WHERE 1=1";
        if ($unidades1 == "999")
        {
            $pregunta .= " AND unidad IN ($unidades)";
        }
        else
        {
            $pregunta .= " AND unidad='$unidades1'";
        }
        if (!empty($_POST['fecha1']))
        {
            $pregunta .= " AND convert(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
        }
        $pregunta .= " ORDER BY fecha DESC";
        $sql = odbc_exec($conexion,$pregunta);
        $total = odbc_num_rows($sql);
        $salida = new stdClass();
        if ($total>0)
        {
            $i = 0;
            $valores = "";
            while ($i < $row = odbc_fetch_array($sql))
            {
                $conse = $row['conse'];
                $fecha = substr($row["fecha"],0,10);
                $unidad = $row['unidad'];
                $pregunta1 = "SELECT sigla, unidad, dependencia FROM cx_org_sub WHERE subdependencia='$unidad'";
                $sql1 = odbc_exec($conexion,$pregunta1);
                $sigla = trim(odbc_result($sql1,1));
                $n_unidad = odbc_result($sql1,2);
  				$n_unidad = intval($n_unidad);
  				$n_dependencia = odbc_result($sql1,3);
				if ($n_unidad > 3)
				{
					$pregunta2 = "SELECT sigla FROM cx_org_sub WHERE unidad='$n_unidad' AND unic='1'";
				}
				else
				{
					$pregunta2 = "SELECT sigla FROM cx_org_sub WHERE dependencia='$n_dependencia' AND unic='1'";
				}
				$sql2 = odbc_exec($conexion, $pregunta2);
				$centralizadora = trim(odbc_result($sql2,1));
                $pagos = $row['pagos'];
                $fuente = trim($row['fuente']);
                if (substr($fuente,0,1) != "K")
                {
                    $fuente = "XXXX".substr($fuente,-4);
                }
                $valor = trim($row['valor']);
                $v_valor = str_replace(',','',$valor);
                $v_valor = floatval($v_valor);
                $plan = $row['pla_inv'];
                $numero = trim($row['numero']);
                $valores .= $conse."|".$fecha."|".$unidad."|".$sigla."|".$pagos."|".$fuente."|".$valor."|".$v_valor."|".$plan."|".$numero."|".$centralizadora."|#";
            }
            $salida->salida = "1";
            $salida->total = $total;
            $salida->valores = $valores;
        }
        else
        {
            $salida->salida = "0";
            $salida->total = "0";
            $salida->valores = "";
        }
    }
    echo json_encode($salida);
}
// 16/05/2024 - Ajuste consulta desde super usuario
// 29/07/2024 - Ajuste consulta todas las unidades desde super usuario
// 05/12/2024 - Ajuste identificador contingencia
// 19/03/2025 - Ajuste campo testigo caracteres especiales
?>