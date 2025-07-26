<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $unidades = $_POST['unidades'];
    $periodo = $_POST['periodo'];
    $ano = $_POST['ano'];
    // Ajuste de valores en 0 y blancos
    $query0 = "UPDATE cx_pla_gas SET valor='0.00' WHERE valor='NaN'";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_gas SET valor_a='0.00' WHERE valor_a='NaN'";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_pag SET val_fuen_a='0.00' WHERE val_fuen_a=''";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_pag SET val_fuen_a='0.00' WHERE val_fuen_a='0'";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_pag SET val_fuen='0.00' WHERE val_fuen=''";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_pag SET val_fuen='0.00' WHERE val_fuen='0'";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_pag SET val_fuen_c='0.00' WHERE val_fuen_c=''";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_gas SET valor='0.00' WHERE valor='0'";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_gas SET valor_a='0.00' WHERE valor_a='0'";
    $sql0 = odbc_exec($conexion, $query0);
    $query0 = "UPDATE cx_pla_gas SET valor_a='0.00' WHERE valor_a=''";
    $sql0 = odbc_exec($conexion, $query0);
    // se verifica que se haga el paso en orden en plan centralizado
    if (($adm_usuario == "7") or ($adm_usuario == "8"))
    {
        $query0 = "SELECT revisa, ordena, visto FROM cx_pla_cen WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
        $cur0 = odbc_exec($conexion, $query0);
        $v_revisa = odbc_result($cur0,1);
        $v_ordena = odbc_result($cur0,2);
        $v_visto = odbc_result($cur0,3);
    }
    else
    {
        $v_revisa = "0";
        $v_ordena = "0";
        $v_visto = "0";
    }
    // Se consultan valores
    if (($adm_usuario == "6") or ($adm_usuario == "7") or ($adm_usuario == "25"))
    {
        if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
        {
            $query = "SELECT * FROM cv_inv_cent3 WHERE unidad IN ($unidades) AND periodo='$periodo' AND ano='$ano' AND estado='B' AND tipo='1' ORDER BY dependencia,unidad";
        }
        else
        {
            if ($adm_usuario == "4")
            {
                $query = "SELECT * FROM cv_inv_cent3 WHERE unidad IN ($unidades) AND periodo='$periodo' AND ano='$ano' AND estado='B' AND tipo='1' ORDER BY dependencia,unidad";
            }
            else
            {
                $query = "SELECT * FROM cv_inv_cent3 WHERE unidad IN ($unidades) AND periodo='$periodo' AND ano='$ano' AND estado='F' AND tipo='1' ORDER BY dependencia,unidad";
            }
        }
    	$sql = odbc_exec($conexion, $query);
        $total1 = odbc_num_rows($sql);
        // Se consulta el techo de la unidad centralizadora para validacion
        $query1 = "SELECT techo, sigla, dependencia, unidad, saldo FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
        $cur1 = odbc_exec($conexion, $query1);
        $techo = trim(odbc_result($cur1,1));
        $sigla = trim(odbc_result($cur1,2));
        $depen = odbc_result($cur1,3);
        $uom = odbc_result($cur1,4);
        $saldo = odbc_result($cur1,5);
        // Se consulta dependencia
        $query3 = "SELECT nombre FROM cx_org_dep WHERE dependencia='$depen'";
        $cur3 = odbc_exec($conexion, $query3);
        $n_depen = trim(odbc_result($cur3,1));
        // Se consulta unidad
        $query4 = "SELECT nombre FROM cx_org_uni WHERE unidad='$uom'";
        $cur4 = odbc_exec($conexion, $query4);
        $n_uom = trim(odbc_result($cur4,1));
        // Planes para actualizar estado
        $query2 = "SELECT conse FROM cv_inv_cent2 WHERE unidad IN ($unidades) AND periodo='$periodo' AND ano='$ano' AND estado='B' ORDER BY conse";
        $cur2 = odbc_exec($conexion, $query2);
        $planes = "";
        while($i<$row=odbc_fetch_array($cur2))
        {
            $planes .= "'".odbc_result($cur2,1)."',";
        }
        $planes = substr($planes,0,-1);
        // Se declara salida de datos
        $salida = new stdClass();
        $salida->rows[0]['unidad'] = $uni_usuario;
        $salida->rows[0]['periodo'] = $periodo;
        $salida->rows[0]['ano'] = $ano;
        $salida->rows[0]['sigla'] = $sigla;
        $salida->rows[0]['depen'] = $depen;
        $salida->rows[0]['n_depen'] = $n_depen;
        $salida->rows[0]['uom'] = $uom;
        $salida->rows[0]['n_uom'] = $n_uom;
        $salida->rows[0]['gastos'] = "0";
        $salida->rows[0]['pagos'] = "0";
        $salida->rows[0]['total'] = "0";
        $salida->rows[0]['conso'] = "0";
        $i=1;
        while($i<$row=odbc_fetch_array($sql))
        {
    		$unidad = odbc_result($sql,1);
    		$periodo = odbc_result($sql,2);
    		$ano = odbc_result($sql,3);
    		$sigla = odbc_result($sql,4);
            $depen = odbc_result($sql,5);
            $n_depen = odbc_result($sql,6);
            $uom = odbc_result($sql,7);
            $n_uom = odbc_result($sql,8);
    		$gastos = odbc_result($sql,11);
    		$pagos = odbc_result($sql,12);
    		$total = odbc_result($sql,14);
            // Se consulta plan consolidado
            $query5 = "SELECT conse, planes FROM cx_pla_con WHERE unidad='$unidad' AND periodo='$periodo' AND ano='$ano'";
            $cur5 = odbc_exec($conexion, $query5);
            $total5 = odbc_num_rows($cur5);
            if ($total5 > 0)
            {
                $conso = trim(odbc_result($cur5,1));
                $plan = trim(odbc_result($cur5,2));
                $plan = trim(decrypt1($plan, $llave));
                $plan = str_replace("'", "»", $plan);
                $plan = str_replace(",", "|", $plan);
            }
            else
            {
                $conso = "0";
                $plan = "";
            }
            $salida->rows[$i]['unidad'] = $unidad;
            $salida->rows[$i]['periodo'] = $periodo;
            $salida->rows[$i]['ano'] = $ano;
            $salida->rows[$i]['sigla'] = $sigla;
            $salida->rows[$i]['depen'] = $depen;
            $salida->rows[$i]['n_depen'] = $n_depen;
            $salida->rows[$i]['uom'] = $uom;
            $salida->rows[$i]['n_uom'] = $n_uom;
            $salida->rows[$i]['gastos'] = $gastos;
            $salida->rows[$i]['pagos'] = $pagos;
            $salida->rows[$i]['total'] = $total;
            $salida->rows[$i]['conso'] = $conso;
            $salida->rows[$i]['plan'] = $plan;
            $i++;
        }
        if ($saldo == ".00")
        {
            $saldo = "0.00";
        }
        $salida->total1 = $total1+1;
        $salida->techo = $techo;
        $salida->saldo = $saldo;
        $salida->planes = $planes;
    }
    if ($adm_usuario == "8")
    {
        $query = "SELECT * FROM cx_val_aut WHERE unidad IN ($unidades) AND periodo='$periodo' AND ano='$ano' AND estado!='V'";
        $sql = odbc_exec($conexion, $query);
        $total1 = odbc_num_rows($sql);
        // Se consulta el techo de la unidad centralizadora para validacion
        $query1 = "SELECT techo, sigla, dependencia, unidad, saldo FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
        $cur1 = odbc_exec($conexion, $query1);
        $techo = trim(odbc_result($cur1,1));
        $sigla = trim(odbc_result($cur1,2));
        $depen = odbc_result($cur1,3);
        $uom = odbc_result($cur1,4);
        $saldo = odbc_result($cur1,5);
        // Planes para actualizar estado
        $query2 = "SELECT conse FROM cv_inv_cent2 WHERE unidad IN ($unidades) AND periodo='$periodo' AND ano='$ano' AND estado='C' ORDER BY conse";
        $cur2 = odbc_exec($conexion, $query2);
        $planes = "";
        while($i<$row=odbc_fetch_array($cur2))
        {
            $planes .= "'".odbc_result($cur2,1)."',";
        }
        $planes = substr($planes,0,-1);
        // Se declara salida de datos
        $salida = new stdClass();
        $i=1;
        while($i<$row=odbc_fetch_array($sql))
        {
            $unidad = odbc_result($sql,4);
            $periodo = odbc_result($sql,5);
            $ano = odbc_result($sql,6);
            $sigla = odbc_result($sql,7);
            $gastos = odbc_result($sql,8);
            $pagos = odbc_result($sql,9);
            $total = odbc_result($sql,10);
            if ($gastos == ".00")
            {
                $gastos = "0.00";
            }
            if ($pagos == ".00")
            {
                $pagos = "0.00";
            }
            // Se consulta plan consolidado
            $query5 = "SELECT conse, planes FROM cx_pla_con WHERE unidad='$unidad' AND periodo='$periodo' AND ano='$ano'";
            $cur5 = odbc_exec($conexion, $query5);
            $conso = trim(odbc_result($cur5,1));
            $plan = trim(odbc_result($cur5,2));
            $plan = trim(decrypt1($plan, $llave));
            $plan = str_replace("'", "»", $plan);
            $plan = str_replace(",", "|", $plan);
            if ($conso == "")
            {
                $conso = "0";
                $plan = "";
            }
            $salida->rows[$i]['unidad'] = $unidad;
            $salida->rows[$i]['periodo'] = $periodo;
            $salida->rows[$i]['ano'] = $ano;
            $salida->rows[$i]['sigla'] = $sigla;
            $salida->rows[$i]['gastos'] = $gastos;
            $salida->rows[$i]['pagos'] = $pagos;
            $salida->rows[$i]['total'] = $total;
            $salida->rows[$i]['conso'] = $conso;
            $salida->rows[$i]['plan'] = $plan;
            $i++;
        }
        if ($saldo == ".00")
        {
            $saldo = "0.00";
        }
        $salida->total1 = $total1;
        $salida->techo = $techo;
        $salida->saldo = $saldo;
        $salida->planes = $planes;
    }
    if (($adm_usuario == "6") or ($adm_usuario == "7") or ($adm_usuario == "8"))
    {
        $query6 = "SELECT * FROM cx_pla_cen WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
        $cur6 = odbc_exec($conexion, $query6);
        $sal_gas = trim(odbc_result($cur6,9));
        $sal_pag = trim(odbc_result($cur6,10));
        $sal_rec = trim(odbc_result($cur6,11));
        $jus_gas = trim(utf8_encode(odbc_result($cur6,12)));
        $jus_pag = trim(utf8_encode(odbc_result($cur6,13)));
        $jus_rec = trim(utf8_encode(odbc_result($cur6,14)));
        $nota = trim(utf8_encode(odbc_result($cur6,18)));
        $salida->sal_gas = $sal_gas;
        $salida->sal_pag = $sal_pag;
        $salida->sal_rec = $sal_rec;
        $salida->jus_gas = $jus_gas;
        $salida->jus_pag = $jus_pag;
        $salida->jus_rec = $jus_rec;
        $salida->nota = $nota;
    }
    $salida->v_revisa = $v_revisa;
    $salida->v_ordena = $v_ordena;
    $salida->v_visto = $v_visto;
    echo json_encode($salida);
}
?>