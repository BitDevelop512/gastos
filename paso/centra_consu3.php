<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $unidades = $_POST['unidades'];
    $unidades1 = $_POST['unidades1'];
    $periodo = $_POST['periodo'];
    $ano = $_POST['ano'];
    $preg = "SELECT * FROM cx_val_aut WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano' AND estado='V'";
    $cur = odbc_exec($conexion, $preg);
    $comando = odbc_num_rows($cur);
    // Se consulta todos los valores autorizados por nidad centralizadora
	$query = "SELECT * FROM cx_val_aut WHERE unidad IN ($unidades) AND periodo='$periodo' AND ano='$ano' AND estado='V' ORDER BY uom, depen, unidad";
	$sql = odbc_exec($conexion, $query);
    $total1 = odbc_num_rows($sql);
    // Se consulta el techo de la unidad centralizadora para validacion
    $query1 = "SELECT techo, sigla, saldo FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
    $cur1 = odbc_exec($conexion, $query1);
    $techo = trim(odbc_result($cur1,1));
    $sigla = trim(odbc_result($cur1,2));
    $saldo = odbc_result($cur1,3);
    // Se valida si ya se ingreso el valor de comando
    if ($comando == "0")
    {
        // Se declara salida de datos
        $salida = new stdClass();
        $salida->rows[0]['unidad'] = $uni_usuario;
        $salida->rows[0]['periodo'] = $periodo;
        $salida->rows[0]['ano'] = $ano;
        $salida->rows[0]['sigla'] = $sigla;
        $salida->rows[0]['gastos'] = "0";
        $salida->rows[0]['pagos'] = "0";
        $salida->rows[0]['total'] = "0";
        $salida->rows[0]['conso'] = "0";
        $salida->rows[0]['conso1'] = "0";
    }
    $i = 1;
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
        if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
        {    
            $query5 = "SELECT conse FROM cx_pla_con WHERE unidad='$unidad' AND periodo='$periodo' AND ano='$ano'";
            $cur5 = odbc_exec($conexion, $query5);
            $conso = trim(odbc_result($cur5,1));
            if ($conso == "")
            {
                $conso = "0";
            }
            $conso1 = "0";
        }
        else
        {
            $query5 = "SELECT conse FROM cx_pla_inv WHERE unidad='$unidad' AND periodo='$periodo' AND ano='$ano'";
            $cur5 = odbc_exec($conexion, $query5);
            $conso = trim(odbc_result($cur5,1));
            $tot_conso = odbc_num_rows($cur5);
            if ($tot_conso > 0)
            {
                $conso1 = "1";
            }
            else
            {
                $conso1 = "0";
            }
        }
        // Se construye salida de datos
        $salida->rows[$i]['unidad'] = $unidad;
        $salida->rows[$i]['periodo'] = $periodo;
        $salida->rows[$i]['ano'] = $ano;
        $salida->rows[$i]['sigla'] = $sigla;
        $salida->rows[$i]['gastos'] = $gastos;
        $salida->rows[$i]['pagos'] = $pagos;
        $salida->rows[$i]['total'] = $total;
        $salida->rows[$i]['conso'] = $conso;
        $salida->rows[$i]['conso1'] = $conso1;
        $i++;
    }
    if ($saldo == ".00")
    {
        $saldo = "0.00";
    }
    if ($comando == "0")
    {
        $salida->total1 = $total1+1;
    }
    else
    {
        $salida->total1 = $total1;   
    }
    $salida->techo = $techo;
    $salida->saldo = $saldo;
    $salida->comando = $comando;
    if (($adm_usuario == "10") or ($adm_usuario == "11") or ($adm_usuario == "12") or ($adm_usuario == "13"))
    {
        $query6 = "SELECT * FROM cx_pla_cen WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
        $cur6 = odbc_exec($conexion, $query6);
        $centra = odbc_num_rows($cur6);
        $sal_gas = trim(odbc_result($cur6,9));
        $sal_pag = trim(odbc_result($cur6,10));
        $sal_rec = trim(odbc_result($cur6,11));
        $jus_gas = trim(utf8_encode(odbc_result($cur6,12)));
        $jus_pag = trim(utf8_encode(odbc_result($cur6,13)));
        $jus_rec = trim(utf8_encode(odbc_result($cur6,14)));
        $revisa = trim(odbc_result($cur6,15));
        $ordena = trim(odbc_result($cur6,16));
        $visto = trim(odbc_result($cur6,17));
        $nota = trim(utf8_encode(odbc_result($cur6,18)));
        $salida->sal_gas = $sal_gas;
        $salida->sal_pag = $sal_pag;
        $salida->sal_rec = $sal_rec;
        $salida->jus_gas = $jus_gas;
        $salida->jus_pag = $jus_pag;
        $salida->jus_rec = $jus_rec;
        $salida->nota = $nota;
        $salida->revisa = $revisa;
        $salida->ordena = $ordena;
        $salida->visto = $visto;
        $salida->centra = $centra;
    }
    echo json_encode($salida);
}
?>