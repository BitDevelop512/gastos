<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $tipo = $_POST['tipo'];
    switch ($tipo)
    {
        case '-':
            $campo = "fecha";
            break;
        case '1':
            $campo = "fec_seg";
            break;
        case '2':
            $campo = "fec_soa";
            break;
        case '3':
            $campo = "fec_rtm";
            break;
        case '4':
            $campo = "fec_man";
            break;
        case '5':
            $campo = "fec_alt";
            break;
        case '6':
            $campo = "fec_sof";
            break;
        case '7':
            $campo = "fec_rtf";
            break;
        default:
            $campo = "fecha";
            break;
    }
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $placa = $_POST['placa'];
    $unidad = $_POST['unidad'];
    $unidades = $_POST['unidades'];
    $clase = $_POST['clase'];
    $empadrona = $_POST['empadrona'];
    $pregunta = "SELECT * FROM cx_pla_tra WHERE 1=1";
    if (!empty($_POST['fecha1']))
    {
        $pregunta .= " AND convert(datetime,$campo,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1)";
    }
    if (!empty($_POST['placa']))
    {
        $pregunta .= " AND placa='$placa'";
    }
    if (($uni_usuario == "1") or ($uni_usuario == "2"))
    {
    }
    else
    {
        if ($sup_usuario == "6")
        {
        }
        else
        {
            $pregunta .= " AND unidad in ($unidades)";
        }
    }
    if ($unidad == "0")
    {
    }
    else
    {
        if ($sup_usuario == "6")
        {
            $pregunta1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND dependencia='$dun_usuario' AND unic='1'";
            $sql1 = odbc_exec($conexion,$pregunta1);
            $uni_com = odbc_result($sql1,1);
            $pregunta .= " AND unidad IN ('$uni_com','$unidad')";
        }
        else
        {
            $pregunta .= " AND unidad='$unidad'";
        }
    }
    if ($clase == "-")
    {
    }
    else
    {
        $pregunta .= " AND clase='$clase'";
    }
    if ($empadrona == "-")
    {
    }
    else
    {
        $pregunta .= " AND empadrona='$empadrona'";
    }
    $pregunta .= " ORDER BY $campo DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    $actual = date('Y-m-d');
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $unidad = $row['unidad'];
            $query1 = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unidad'";
            $cur1 = odbc_exec($conexion, $query1);
            $n_uni = trim(odbc_result($cur1,1));
            $m_uni = trim(odbc_result($cur1,2));
            $f_uni = trim(odbc_result($cur1,3));
            if ($f_uni == "")
            {
            }
            else
            {
                $f_uni = str_replace("/", "-", $f_uni);
                if ($actual >= $f_uni)
                {
                    $n_uni = $m_uni;
                }
            }
            $clase = $row['clase'];

            $pregunta5 = "SELECT nombre FROM cx_ctr_veh WHERE codigo='$clase'";
            $sql5 = odbc_exec($conexion, $pregunta5);
            $n_clase = trim(utf8_encode(odbc_result($sql5,1)));
            $campo1 = substr($row[$campo],0,10);
            $empadrona1 = $row['empadrona'];
            switch ($empadrona1)
            {
                case '1':
                    $n_empadrona = "CEDE2";
                    break;
                case '2':
                    $n_empadrona = "CEDE4";
                    break;
                case '3':
                    $n_empadrona = "CONTRATO";
                    break;
                case '4':
                    $n_empadrona = "MIXTO";
                    break;
                default:
                    $n_empadrona = "";
                    break;
            }
            $estado1 = $row['estado'];
            switch ($estado1)
            {
                case '1':
                    $n_estado = "SERVICIO";
                    break;
                case '2':
                    $n_estado = "FUERA DE SERVICIO";
                    break;
                case '3':
                    $n_estado = "MANTENIMIENTO";
                    break;
                case '4':
                    $n_estado = "INVESTIGACIÓN ADMINISTRATIVA";
                    break;
                case '5':
                    $n_estado = "HURTO";
                    break;
                case '6':
                    $n_estado = "SINIESTRO";
                    break;
                default:
                    $n_estado = "";
                    break;
            }
            $riesgo1 = $row['rie_seg'];
            switch ($riesgo1)
            {
                case '0':
                    $n_riesgo = "NO ACTIVA";
                    break;
                case '1':
                    $n_riesgo = "ACTIVA";
                    break;
                case '2':
                    $n_riesgo = "VENCIDA";
                    break;
                default:
                    $n_riesgo = "";
                    break;
            }
            $combustible1 = $row['tipo'];
            switch ($combustible1)
            {
                case '1':
                    $n_combustible = "GASOLINA";
                    break;
                case '2':
                    $n_combustible = "ACPM";
                    break;
                case '3':
                    $n_combustible = "DIESEL";
                    break;
                default:
                    $n_combustible = "";
                    break;
            }
            $odometro1 = $row['odometro'];
            switch ($odometro1)
            {
                case '0':
                    $n_odometro = "NO";
                    break;
                case '1':
                    $n_odometro = "SI";
                    break;
                default:
                    $n_odometro = "";
                    break;
            }
            $salida->rows[$i]['conse'] = $row['conse'];
            $salida->rows[$i]['fecha'] = $campo1;
            $salida->rows[$i]['unidad'] = $n_uni;
            $salida->rows[$i]['batallon'] = $unidad;
            $salida->rows[$i]['compania'] = trim($row['compania']);
            $salida->rows[$i]['placa'] = trim($row['placa']);
            $salida->rows[$i]['clase'] = $n_clase;
            $salida->rows[$i]['marca'] = trim($row['marca']);
            $salida->rows[$i]['linea'] = trim($row['linea']);
            $salida->rows[$i]['modelo'] = trim($row['modelo']);
            $salida->rows[$i]['activo'] = trim($row['activo']);
            $salida->rows[$i]['estado'] = $n_estado;
            $salida->rows[$i]['estado1'] = $estado1;
            $salida->rows[$i]['empadrona'] = $n_empadrona;
            $salida->rows[$i]['ase_nom'] = trim(utf8_encode($row['ase_nom']));
            $salida->rows[$i]['fec_seg'] = substr($row['fec_seg'],0,10);
            $salida->rows[$i]['rie_seg'] = $n_riesgo;
            $salida->rows[$i]['ase_soa'] = trim(utf8_encode($row['ase_soa']));
            $salida->rows[$i]['num_soa'] = trim($row['num_soa']);
            $salida->rows[$i]['fec_soa'] = substr($row['fec_soa'],0,10);
            $salida->rows[$i]['fec_rtm'] = substr($row['fec_rtm'],0,10);
            $salida->rows[$i]['fec_man'] = substr($row['fec_man'],0,10);
            $salida->rows[$i]['tip_man'] = trim(utf8_encode($row['tip_man']));
            $salida->rows[$i]['des_man'] = trim(utf8_encode($row['des_man']));
            $salida->rows[$i]['cilindraje'] = $row['cilindraje'];
            $salida->rows[$i]['activo'] = trim(utf8_encode($row['activo']));
            $salida->rows[$i]['costo'] = trim(utf8_encode($row['costo']));
            $salida->rows[$i]['combustible'] = $n_combustible;
            $salida->rows[$i]['color'] = trim(utf8_encode($row['color']));
            $salida->rows[$i]['motor'] = trim(utf8_encode($row['motor']));
            $salida->rows[$i]['chasis'] = trim(utf8_encode($row['chasis']));
            $salida->rows[$i]['matricula'] = trim(utf8_encode($row['matricula']));
            $salida->rows[$i]['fec_alt'] = substr($row['fec_alt'],0,10);
            $salida->rows[$i]['origen'] = trim(utf8_encode($row['origen']));
            $salida->rows[$i]['equipo'] = trim(utf8_encode($row['equipo']));
            $salida->rows[$i]['consumo'] = $row['consumo'];
            $salida->rows[$i]['kilometro'] = $row['kilometro'];
            $salida->rows[$i]['observaciones'] = trim(utf8_encode($row['observaciones']));
            $salida->rows[$i]['odometro'] = $n_odometro;
            $salida->rows[$i]['autoriza'] = trim(utf8_encode($row['autoriza']));
            $salida->rows[$i]['inventario'] = trim(utf8_encode($row['inventario']));
            $salida->rows[$i]['fec_sof'] = substr($row['fec_sof'],0,10);
            $salida->rows[$i]['fec_rtf'] = substr($row['fec_rtf'],0,10);
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
// 08/08/2023 - Ajuste consulta por empadronamiento
// 06/10/2023 - Ajuste salida de datos completos a excel
// 23/02/2024 - Ajuste por creacion de tabla de configuracion de vehiculos
?>