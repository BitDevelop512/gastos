<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    if ($sup_usuario == "1")
    {
        $pregunta = "SELECT * FROM cx_act_reg WHERE 1=1";
    }
    else
    {
        $pregunta = "SELECT * FROM cx_act_reg WHERE unidad='$uni_usuario' AND ((usuario='$usu_usuario') OR (usuario='$log_usuario'))";
    }
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND convert(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
    }
    $pregunta .= " AND unidad!='999'";
    $pregunta .= " AND registro!='0'";
    $pregunta .= " ORDER BY fecha DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            // Se valida cambio de sigla
            $valida = substr($row["fecha"],0,10);
            $registro = $row['registro'];
            $ano = $row['ano1'];
            $pregunta1 = "SELECT unidad, ordop, codigo FROM cx_reg_rec WHERE conse='$registro' AND ano='$ano'";
            $sql1 = odbc_exec($conexion,$pregunta1);
            $unidad1 = odbc_result($sql1,1);
            $ordop = trim(utf8_encode(odbc_result($sql1,2)));
            $codigo = trim(odbc_result($sql1,3));
            $pregunta2 = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unidad1'";
            $sql2 = odbc_exec($conexion,$pregunta2);
            $sigla = trim(odbc_result($sql2,1));
            $m_uni = trim(odbc_result($sql2,2));
            $f_uni = trim(odbc_result($sql2,3));
            if ($f_uni == "")
            {
            }
            else
            {
                $f_uni = str_replace("/", "-", $f_uni);
                if ($valida >= $f_uni)
                {
                    $sigla = $m_uni;
                }
            }
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
            $salida->rows[$i]['usuario'] = trim($row['usuario']);
            $salida->rows[$i]['estado'] = trim($row['estado']);
            $salida->rows[$i]['unidad'] = $sigla;
            $salida->rows[$i]['ordop'] = $ordop;
            $salida->rows[$i]['valor'] = trim($row['valor']);
            $salida->rows[$i]['totala'] = trim($row['totala']);
            $salida->rows[$i]['ano'] = $row['ano'];
            $salida->rows[$i]['registro'] = $registro;
            $salida->rows[$i]['ano1'] = $ano;
            $salida->rows[$i]['codigo'] = $codigo;
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
?>