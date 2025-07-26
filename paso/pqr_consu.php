<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $ano1 = $_POST['ano'];
    $estado1 = $_POST['estado'];
    $batallon = $_POST['batallon'];
    $asignados = $_POST['asignados'];
    $pregunta = "SELECT * FROM cx_pqr_reg WHERE 1=1";
    if ($sup_usuario == "1")
    {
        if ($batallon == "0")
        {
        }
        else
        {
            $pregunta .= " AND unidad='$batallon'";
        }
    }
    else
    {
        $pregunta .= " AND ((usuario='$usu_usuario' AND unidad='$uni_usuario') OR (responde='$usu_usuario') OR (asigna='$usu_usuario'))";
    }
    if ($ano1 == "-")
    {
    }
    else
    {
        $pregunta .= " AND ano='$ano1'";
    }
    if ($estado1 == "-")
    {
    }
    else
    {
        $pregunta .= " AND estado='$estado1'";
    }
    if ($asignados == "-")
    {
    }
    else
    {
        if ($sup_usuario == "1")
        {
            if (($asignados == "ADM_SIGAR") or ($asignados == "ING_SIGAR"))
            {
                $pregunta .= " AND ((asigna='ADM_SIGAR') or (asigna='ING_SIGAR'))";
            }
            else
            {
                $pregunta .= " AND asigna='$asignados'";
            }
        }
        else
        {
            $pregunta .= " AND asigna='$asignados'";
        }
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
            $tipo = $row['tipo'];
            switch ($tipo)
            {
                case '1':
                    $n_tipo = "SOLICITUD";
                    break;
                case '2':
                    $n_tipo = "SOPORTE";
                    break;
                case '3':
                    $n_tipo = "OTRO";
                    break;
                default:
                    $n_tipo = "";
                    break;
            }
            $modulo = $row['modulo'];
            switch ($modulo)
            {
                case 'A':
                    $n_modulo = "PLANEACI&Oacute;N";
                    break;
                case 'B':
                    $n_modulo = "EJECUCI&Oacute;N";
                    break;
                case 'C':
                    $n_modulo = "SOPORTES DE EJECUCI&Oacute;N";
                    break;
                case 'D':
                    $n_modulo = "LIBROS AUXILIARES";
                    break;
                case 'E':
                    $n_modulo = "RECOMPENSAS";
                    break;
                case 'F':
                    $n_modulo = "PRESUPUESTO";
                    break;
                case 'G':
                    $n_modulo = "ADMINISTRADOR";
                    break;
                case 'H':
                    $n_modulo = "BIENES";
                    break;
                case 'I':
                    $n_modulo = "ESTAD&Iacute;STICAS";
                    break;
                case 'J':
                    $n_modulo = "TRANSPORTES";
                    break;
                default:
                    $n_modulo = "";
                    break;
            }
            $estado = trim($row['estado']);
            switch ($estado)
            {
                case '':
                    $n_estado = "ENVIADA";
                    break;
                case 'A':
                    $n_estado = "EN TRAMITE";
                    break;
                case 'B':
                    $n_estado = "CERRADA";
                    break;
                case 'C':
                    $n_estado = "PENDIENTE CONFIRMACI&Oacute;N";
                    break;
                case 'D':
                    $n_estado = "ASIGNADA A USUARIO";
                    break;
                case 'Y':
                    $n_estado = "RECHAZADA";
                    break;
                default:
                    $n_estado = "";
                    break;
            }
            if (($estado == "B") or ($estado == "Y"))
            {
                $cadena = trim(utf8_encode($row['solucion']));
                $cadena1 = substr($cadena, -23);
                $cadena2 = substr($cadena1, 0, 19);
                $cadena3 = explode(" ", $cadena2);
                $var_fec = $cadena3[0];
                $var_hor = $cadena3[1];
                $cadena4 = explode("/", $var_fec);
                $var_dia = $cadena4[0];
                $var_mes = $cadena4[1];
                $var_ano = $cadena4[2];
                $var_cie = $var_ano."-".$var_mes."-".$var_dia." ".$var_hor;
                $solucion = $var_cie;
                $fechai = substr($row["fecha"],0,19);
                $var_dif = restarfechas($fechai, $var_cie);
                $solucion = $var_dif;
            }
            else
            {
                $var_cie = "";
                $solucion = "";
            }
            $submodulo = $row['submodulo'];
            $asigna = trim($row['asigna']);
            if (($asigna == "ING_SIGAR") or ($asigna == "ADM_SIGAR"))
            {
                $asigna = "CEDE2";
            }
            $pregunta1 = "SELECT nombre FROM cx_ctr_mod WHERE conse='$submodulo' AND modulo='$modulo'";
            $sql1 = odbc_exec($conexion,$pregunta1);
            $n_submodulo = trim(utf8_encode(odbc_result($sql1,1)));
            $unidad = $row['unidad'];
            // Se valida cambio de sigla
            $valida = substr($row["fecha"],0,19);
            $pregunta2 = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unidad'";
            $sql2 = odbc_exec($conexion,$pregunta2);
            $n_unidad = trim(odbc_result($sql2,1));
            $m_unidad = trim(odbc_result($sql2,2));
            $f_unidad = trim(odbc_result($sql2,3));
            if ($f_unidad == "")
            {
            }
            else
            {
                $f_unidad = str_replace("/", "-", $f_unidad);
                if ($valida >= $f_unidad)
                {
                    $n_unidad = $m_unidad;
                }
            }
            // Se valida paso entre usuarios
            $conse = $row['conse'];
            $ano = $row['ano'];
            $pregunta3 = "SELECT COUNT(1) AS total FROM cx_pqr_usu WHERE solicitud='$conse' AND ano='$ano'";
            $sql3 = odbc_exec($conexion,$pregunta3);
            $contador = odbc_result($sql3,1);
            $salida->rows[$i]['conse'] = $conse;
            $salida->rows[$i]['fecha'] = substr($row["fecha"],0,19);
            $salida->rows[$i]['usuario'] = $row['usuario'];
            $salida->rows[$i]['ano'] = $ano;
            $salida->rows[$i]['estado'] = $row['estado'];
            $salida->rows[$i]['n_estado'] = $n_estado;
            $salida->rows[$i]['unidad'] = $unidad;
            $salida->rows[$i]['n_unidad'] = $n_unidad;
            $salida->rows[$i]['n_tipo'] = $n_tipo;
            $salida->rows[$i]['modulo'] = $row['modulo'];
            $salida->rows[$i]['n_modulo'] = $n_modulo;
            $salida->rows[$i]['submodulo'] = $row['submodulo'];
            $salida->rows[$i]['n_submodulo'] = $n_submodulo;
            $salida->rows[$i]['fechaf'] = $var_cie;
            $salida->rows[$i]['solucion'] = $solucion;
            $salida->rows[$i]['asigna'] = $asigna;
            $salida->rows[$i]['contador'] = $contador;
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
// 05/12/2023 - Ajuste consulta usuarios asigandos
// 24/01/2024 - Ajuste de cambio de sigla validando la fecha actual
?>