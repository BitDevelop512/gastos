<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $gasto = $_POST['gasto'];
    $gastos = stringArray1($gasto);
    $unidad = $_POST['unidad'];
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $pregunta = "SELECT conse, unidad, consecu, ano, usuario, fecha, periodo, ordop, mision, numero FROM cx_rel_gas WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.conse1=cx_rel_gas.conse AND cx_rel_dis.ano=cx_rel_gas.ano AND cx_rel_dis.consecu=cx_rel_gas.consecu AND cx_rel_dis.gasto IN ($gastos))";
    if ($unidad == "-")
    {
    }
    else
    {
        if (($sup_usuario == "1") or ($sup_usuario == "2"))
        {
            $query = "SELECT unidad, dependencia, tipo, unic FROM cx_org_sub WHERE subdependencia='$unidad'";
            $cur = odbc_exec($conexion, $query);
            $n_unidad = odbc_result($cur,1);
            $n_dependencia = odbc_result($cur,2);
            $n_tipo = odbc_result($cur,3);
            $n_unic = odbc_result($cur,4);
            if ($n_unic == "0")
            {
                $numero = $unidad;
            }
            else
            {
                if (($n_unidad == "1") or ($n_unidad == "2") or ($n_unidad == "3"))
                {
                    if (($n_unidad == "2") or ($n_unidad == "3"))
                    {
                        $pregunta0 = "SELECT dependencia FROM cx_org_sub WHERE unidad='$n_unidad'";
                        $sql0 = odbc_exec($conexion, $pregunta0);
                        $dependencia = odbc_result($sql0,1);
                        $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' ORDER BY subdependencia";
                    }
                    else
                    {
                        $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' AND tipo='2' AND unic='0' ORDER BY subdependencia";
                    }
                }
                else
                {
                    if ($n_tipo == "7")
                    {
                        $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' ORDER BY subdependencia";
                    }
                    else
                    {
                        $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY subdependencia";
                    }
                }
                $cur1 = odbc_exec($conexion, $query1);
                $numero = "";
                while($i<$row=odbc_fetch_array($cur1))
                {
                    $numero .= "'".odbc_result($cur1,1)."',";
                }
                $numero = substr($numero,0,-1);
                // Se verifica si es unidad centralizadora especial
                if (strpos($especial, $unidad) !== false)
                {
                    $numero .= ",";
                    $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$n_unidad' ORDER BY unidad";
                    $cur = odbc_exec($conexion, $query);
                    while($i<$row=odbc_fetch_array($cur))
                    {
                        $n_unidad = odbc_result($cur,1);
                        $n_dependencia = odbc_result($cur,2);
                        $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
                        $cur1 = odbc_exec($conexion, $query1);
                        while($j<$row=odbc_fetch_array($cur1))
                        {
                            $numero .= "'".odbc_result($cur1,1)."',";
                        }
                    }
                    $numero .= $uni_usuario;
                }
            }
            $pregunta .= " AND unidad in ($numero)";
        }
        else
        {
            $pregunta .= " AND unidad='$unidad'";
        }
    }
    $pregunta .= " ORDER BY fecha DESC";
    $sql = odbc_exec($conexion, $pregunta);
    $total = odbc_num_rows($sql);
    $valores = "";
    $salida = new stdClass();
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $conse = odbc_result($sql,1);
            $unidad1 = odbc_result($sql,2);
            $consecu = odbc_result($sql,3);
            $ano = odbc_result($sql,4);
            $usuario = trim(odbc_result($sql,5));
            $fecha = odbc_result($sql,6);
            $fecha = substr($fecha,0,10);
            $periodo = odbc_result($sql,7);
            $ordop = trim(utf8_encode(odbc_result($sql,8)));
            $ordop = str_replace("#", "", $ordop);
            $ordop = str_replace("|", "", $ordop);
            $mision = trim(utf8_encode(odbc_result($sql,9)));
            $numero = odbc_result($sql,10);
            $mes = str_pad($periodo,2,"0",STR_PAD_LEFT);
            $pregunta1 = "SELECT valor, datos, gasto, tipo FROM cx_rel_dis WHERE conse1='$conse' AND consecu='$consecu' AND ano='$ano' AND gasto IN ($gastos)";
            $sql1 = odbc_exec($conexion, $pregunta1);
            $l = 0;
            while ($l < $row = odbc_fetch_array($sql1))
            {
                $valor = trim(odbc_result($sql1,1));
                $datos = trim(utf8_encode($row['datos']));
                $gasto1 = odbc_result($sql1,3);
                $soporte = trim(odbc_result($sql1,4));
                $num_datos = explode("|",$datos);
                // Combustible
                if (($gasto1 == "36") or ($gasto1 == "42"))
                {
                    $otros = "";
                    for ($j=0;$j<count($num_datos)-1;++$j)
                    {
                        $paso = $num_datos[$j];
                        $paso1 = explode("»",$paso);
                        for ($k=0;$k<count($paso1)-1;++$k)
                        {
                            $clase = $paso1[0];
                            $placa = $paso1[1];
                            $valor = $paso1[2];
                            if (($valor == "") or ($valor == "0"))
                            {
                                $valor = "0,0";
                            }
                            $valor = str_replace(',','',$valor);
                            $valor = floatval($valor);
                            $detalle = $paso1[4];
                            $unidad = $paso1[6];
                            if ($soporte == "N")
                            {
                                $pregunta0 = "SELECT SUM(total) AS total FROM cx_tra_mov WHERE placa='$placa' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND solicitud='$consecu' AND soporte='0'";
                                if ($gasto1 == "36")
                                {
                                    $pregunta0 .= " AND tipo='1'";
                                }
                                else
                                {
                                    $pregunta0 .= " AND tipo='2'";
                                }
                                $sql0 = odbc_exec($conexion, $pregunta0);
                                $valor = odbc_result($sql0,1);
                            }
                        }
                        // Kilometraje
                        $pregunta2 = "SELECT ISNULL(MAX(kilometraje),0) AS kilometraje FROM cx_tra_mov WHERE placa='$placa' AND solicitud='$consecu'";
                        $sql2 = odbc_exec($conexion, $pregunta2);
                        $kilometraje = odbc_result($sql2,1);
                        if ($kilometraje == "0.00")
                        {
                            if ($gasto == "36")
                            {
                                $tipo1 = "1";
                            }
                            else
                            {
                                $tipo1 = "2";   
                            }
                            switch ($periodo)
                            {
                                case '1':
                                case '3':
                                case '5':
                                case '7':
                                case '8':
                                case '10':
                                case '12':
                                    $dia = "31";
                                    break;
                                case '2':
                                    if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
                                    {
                                        $dia = "29";
                                    }
                                    else
                                    {
                                        $dia = "28";
                                    }
                                    break;
                                case '4':
                                case '6':
                                case '9':
                                case '11':
                                    $dia = "30";
                                    break;
                                default:
                                    $dia = "31";
                                    break;
                            }
                            $fecha3 = $ano."/".$mes."/01";
                            $fecha4 = $ano."/".$mes."/".$dia;
                            $pregunta2 = "SELECT ISNULL(MAX(kilometraje),0) AS kilometraje FROM cx_tra_mov WHERE placa='$placa' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha3',102) AND CONVERT(datetime,'$fecha4',102) AND tipo='$tipo1'";
                            $sql2 = odbc_exec($conexion, $pregunta2);
                            $kilometraje = odbc_result($sql2,1);
                            if ($kilometraje == "0.00")
                            {
                                $periodo1 = $periodo+1;
                                $mes1 = str_pad($periodo1,2,"0",STR_PAD_LEFT);
                                switch ($periodo1)
                                {
                                    case '1':
                                    case '3':
                                    case '5':
                                    case '7':
                                    case '8':
                                    case '10':
                                    case '12':
                                        $dia1 = "31";
                                        break;
                                    case '2':
                                        if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
                                        {
                                            $dia1 = "29";
                                        }
                                        else
                                        {
                                            $dia1 = "28";
                                        }
                                        break;
                                    case '4':
                                    case '6':
                                    case '9':
                                    case '11':
                                        $dia1 = "30";
                                        break;
                                    default:
                                        $dia1 = "31";
                                        break;
                                }
                                $fecha5 = $ano."/".$mes1."/01";
                                $fecha6 = $ano."/".$mes1."/".$dia1;
                            }
                        }
                        // Kilometraje recorrido mes y mes anterior
                        if ($periodo == "1")
                        {
                            $kilometraja = 0;
                        }
                        else
                        {
                            $periodoa = $periodo-1;
                            $mesa = str_pad($periodoa,2,"0",STR_PAD_LEFT);
                            switch ($periodoa)
                            {
                                case '1':
                                case '3':
                                case '5':
                                case '7':
                                case '8':
                                case '10':
                                case '12':
                                    $diaa = "31";
                                    break;
                                case '2':
                                    if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
                                    {
                                        $diaa = "29";
                                    }
                                    else
                                    {
                                        $diaa = "28";
                                    }
                                    break;
                                case '4':
                                case '6':
                                case '9':
                                case '11':
                                    $diaa = "30";
                                    break;
                                default:
                                    $diaa = "31";
                                    break;
                            }
                            $fecha7 = $ano."/".$mesa."/01";
                            $fecha8 = $ano."/".$mesa."/".$diaa;
                            $pregunta3 = "SELECT ISNULL(MAX(kilometraje),0) AS kilometraje FROM cx_tra_mov WHERE placa='$placa' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha7',102) AND CONVERT(datetime,'$fecha8',102)";
                            $sql3 = odbc_exec($conexion, $pregunta3);
                            $kilometraja = odbc_result($sql3,1);
                            if ($kilometraja == "0.00")
                            {
                                $periodob = $periodo-2;
                                $mesb = str_pad($periodob,2,"0",STR_PAD_LEFT);
                                switch ($periodob)
                                {
                                    case '1':
                                    case '3':
                                    case '5':
                                    case '7':
                                    case '8':
                                    case '10':
                                    case '12':
                                        $diab = "31";
                                        break;
                                    case '2':
                                        if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
                                        {
                                            $diab = "29";
                                        }
                                        else
                                        {
                                            $diab = "28";
                                        }
                                        break;
                                    case '4':
                                    case '6':
                                    case '9':
                                    case '11':
                                        $diab = "30";
                                        break;
                                    default:
                                        $diab = "31";
                                        break;
                                }
                                $fecha7 = $ano."/".$mesb."/01";
                                $fecha8 = $ano."/".$mesb."/".$diab;
                                $pregunta3 = "SELECT ISNULL(MAX(kilometraje),0) AS kilometraje FROM cx_tra_mov WHERE placa='$placa' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha7',102) AND CONVERT(datetime,'$fecha8',102)";
                                $sql3 = odbc_exec($conexion, $pregunta3);
                                $kilometraja = odbc_result($sql3,1);
                                $kilometraja = $kilometraje-$kilometraja;
                            }
                            else
                            {
                                $kilometraja = $kilometraje-$kilometraja;
                            }
                        }
                        // Nombre del gasto
                        $pregunta4 = "SELECT nombre FROM cx_ctr_pag WHERE codigo='$gasto1'";
                        $sql4 = odbc_exec($conexion, $pregunta4);
                        $gasto2 = trim(utf8_encode(odbc_result($sql4,1)));
                        // Tipo de combustible
                        $pregunta5 = "SELECT tipo FROM cx_pla_tra WHERE placa='$placa'";
                        $sql5 = odbc_exec($conexion, $pregunta5);
                        $tpcombus = odbc_result($sql5,1);
                        // Nombre tipo de combustible
                        $pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$tpcombus'";
                        $sql6 = odbc_exec($conexion, $pregunta6);
                        $tpcombus1 = trim(odbc_result($sql6,1));
                        if ((trim($placa) == "") or ($valor == "0,0") or ($valor == ""))
                        {
                        }
                        else
                        {
                            $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop."|".$mision."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|0|#";
                        }
                    }
                }
                // Mantenimiento
                if (($gasto1 == "38") or ($gasto1 == "44"))
                {
                    $kilometraja = 0;
                    $otros = "";
                    $pregunta2 = "SELECT bienes FROM cx_pla_gad WHERE conse1='$consecu' AND ano='$ano' AND gasto='$gasto'";
                    $sql2 = odbc_exec($conexion, $pregunta2);
                    $t_sql2 = odbc_num_rows($sql2);
                    if ($t_sql2 > 0)
                    {
                        $j = 0;
                        while($j<$row=odbc_fetch_array($sql2))
                        {
                            $val_bie = trim($row['bienes']);
                            $val_bie = utf8_encode($val_bie);
                            $j++;
                        }
                        $arreglo = [];
                        $val_bie1 = explode("#", $val_bie);
                        $val_bie2 = explode("&", $val_bie1[0]);
                        $val_bie3 = explode("&", $val_bie1[1]);
                        $val_bie4 = explode("&", $val_bie1[2]);
                        $val_bie5 = explode("&", $val_bie1[3]);
                        $val_bie6 = explode("&", $val_bie1[4]);
                        $val_bie7 = explode("&", $val_bie1[5]);
                        $val_bie8 = explode("&", $val_bie1[6]);
                        $val_bie9 = explode("&", $val_bie1[7]);
                        $val_bie10 = explode("&", $val_bie1[8]);
                        $val_bie11 = explode("&", $val_bie1[9]);
                        $val_bie12 = explode("&", $val_bie1[10]);
                        $val_bie13 = explode("&", $val_bie1[11]);
                        $val_bie14 = explode("&", $val_bie1[12]);
                        $val_bie15 = explode("&", $val_bie1[13]);
                        $val_bie16 = explode("&", $val_bie1[14]);
                        $val_bie17 = explode("&", $val_bie1[15]);
                        $det_bienes = "";
                        for ($k=0;$k<count($val_bie4)-1;++$k)
                        {
                            $det_bienes = $val_bie17[$k];
                            array_push($arreglo, $det_bienes);
                        }
                    }
                    for ($j=0;$j<count($num_datos)-1;++$j)
                    {
                        $paso = $num_datos[$j];
                        $paso1 = explode("»",$paso);
                        for ($k=0;$k<count($paso1)-1;++$k)
                        {
                            $clase = $paso1[0];
                            $placa = $paso1[1];
                            $cantidad = $paso1[2];
                            $valor = $paso1[12];
                            if (($valor == "") or ($valor == "0"))
                            {
                                $valor = "0,0";
                            }
                            $valor = str_replace(',','',$valor);
                            $valor = floatval($valor);
                            $detalle = $paso1[14];
                            $alea = $paso1[18];
                            $unidad = $paso1[19];
                            $kilometraje = $arreglo[$j];
                        }
                        // Nombre del gasto
                        $pregunta4 = "SELECT nombre FROM cx_ctr_pag WHERE codigo='$gasto1'";
                        $sql4 = odbc_exec($conexion, $pregunta4);
                        $gasto2 = trim(utf8_encode(odbc_result($sql4,1)));
                        // Tipo de combustible
                        $pregunta5 = "SELECT tipo FROM cx_pla_tra WHERE placa='$placa'";
                        $sql5 = odbc_exec($conexion, $pregunta5);
                        $tpcombus = odbc_result($sql5,1);
                        // Nombre tipo de combustible
                        $pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$tpcombus'";
                        $sql6 = odbc_exec($conexion, $pregunta6);
                        $tpcombus1 = trim(odbc_result($sql6,1));
                        if ((trim($placa) == "") or ($valor == "0,0"))
                        {
                        }
                        else
                        {
                            $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop."|".$mision."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|#";
                        }
                    }
                }
                // RTM
                if (($gasto1 == "39") or ($gasto1 == "45"))
                {
                    $kilometraje = "";
                    $kilometraja = 0;
                    $otros = "";
                    for ($j=0;$j<count($num_datos)-1;++$j)
                    {
                        $paso = $num_datos[$j];
                        $paso1 = explode("»",$paso);
                        for ($k=0;$k<count($paso1)-1;++$k)
                        {
                            $clase = $paso1[0];
                            $placa = $paso1[1];
                            $cantidad = "1";
                            $valor = $paso1[5];
                            if (($valor == "") or ($valor == "0"))
                            {
                                $valor = "0,0";
                            }
                            $valor = str_replace(',','',$valor);
                            $valor = floatval($valor);
                            $detalle = $paso1[7];
                            $alea = $paso1[10];
                            $unidad = $paso1[11];
                        }
                        // Nombre del gasto
                        $pregunta4 = "SELECT nombre FROM cx_ctr_pag WHERE codigo='$gasto1'";
                        $sql4 = odbc_exec($conexion, $pregunta4);
                        $gasto2 = trim(utf8_encode(odbc_result($sql4,1)));
                        // Tipo de combustible
                        $pregunta5 = "SELECT tipo FROM cx_pla_tra WHERE placa='$placa'";
                        $sql5 = odbc_exec($conexion, $pregunta5);
                        $tpcombus = odbc_result($sql5,1);
                        // Nombre tipo de combustible
                        $pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$tpcombus'";
                        $sql6 = odbc_exec($conexion, $pregunta6);
                        $tpcombus1 = trim(odbc_result($sql6,1));
                        if ((trim($placa) == "") or ($valor == "0,0"))
                        {
                        }
                        else
                        {
                            $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop."|".$mision."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|#";
                        }
                    }
                }
                // Llantas
                if (($gasto1 == "40") or ($gasto1 == "46"))
                {
                    $kilometraje = "";
                    $kilometraja = 0;
                    $otros = "";
                    $repu = count($num_datos)-1;
                    for ($j=0;$j<count($num_datos)-1;++$j)
                    {
                        $paso = $num_datos[$j];
                        $paso1 = explode("»",$paso);
                        for ($k=0;$k<count($paso1)-1;++$k)
                        {
                            $clase = $paso1[0];
                            $placa = $paso1[1];
                            $cantidad = $paso1[2];
                            $valor = $paso1[6];
                            if (($valor == "") or ($valor == "0"))
                            {
                                $valor = "0,0";
                            }
                            $valor = str_replace(',','',$valor);
                            $valor = floatval($valor);
                            $detalle = $paso1[8]." - ".$paso1[9]." - ".$paso1[10];
                            $alea = $paso1[13];
                            $unidad = $paso1[14];
                        }
                        // Nombre del gasto
                        $pregunta4 = "SELECT nombre FROM cx_ctr_pag WHERE codigo='$gasto1'";
                        $sql4 = odbc_exec($conexion, $pregunta4);
                        $gasto2 = trim(utf8_encode(odbc_result($sql4,1)));
                        // Tipo de combustible
                        $pregunta5 = "SELECT tipo FROM cx_pla_tra WHERE placa='$placa'";
                        $sql5 = odbc_exec($conexion, $pregunta5);
                        $tpcombus = odbc_result($sql5,1);
                        // Nombre tipo de combustible
                        $pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$tpcombus'";
                        $sql6 = odbc_exec($conexion, $pregunta6);
                        $tpcombus1 = trim(odbc_result($sql6,1));
                        if ((trim($placa) == "") or ($valor == "0,0"))
                        {
                        }
                        else
                        {
                            $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop."|".$mision."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|#";
                        }
                    }
                }
                $l++;
            }
            $i++;
        }
        $salida->valores = $valores;
    }
    else
    {
        $salida->valores = "";
    }
    echo json_encode($salida);
}
// 24/10/2023 - Ajuste inlcusion tipo de combustible y nombre del concepto del gasto
// 01/11/2023 - Ajuste de valor por flotante para sumatorias de excel
// 17/01/2024 - Ajuste validacion valor llantas
// 13/02/2024 - Inclusion columna cantidad
// 09/04/2024 - Ajuste nombre desde tabla de combustible
// 22/07/2024 - Ajuste valores sin soporte en relacion de gastos
// 22/07/2024 - Ajuste inclusion de unidades que dependen de centralizadora
// 29/07/2024 - Ajuste valores en 0 o en blanco para no exportar a excel
?>
