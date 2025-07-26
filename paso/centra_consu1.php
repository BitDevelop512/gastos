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
    // se verifica que se haga el paso en orden en plan centralizado
    if ($adm_usuario == "9")
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
	$query = "SELECT * FROM cx_val_aut WHERE unidad IN ($unidades) AND periodo='$periodo' AND ano='$ano' AND estado!='V'";
	$sql = odbc_exec($conexion, $query);
    $total1 = odbc_num_rows($sql);
    // Se consulta el techo de la unidad centralizadora para validacion
    $query1 = "SELECT techo FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
    $cur1 = odbc_exec($conexion, $query1);
    $techo = trim(odbc_result($cur1,1));
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
        $salida->rows[$i]['unidad'] = $unidad;
        $salida->rows[$i]['periodo'] = $periodo;
        $salida->rows[$i]['ano'] = $ano;
        $salida->rows[$i]['sigla'] = $sigla;
        $salida->rows[$i]['gastos'] = $gastos;
        $salida->rows[$i]['pagos'] = $pagos;
        $salida->rows[$i]['total'] = $total;
        $i++;
    }
    $salida->total1 = $total1;
    $salida->techo = $techo;
    $salida->v_revisa = $v_revisa;
    $salida->v_ordena = $v_ordena;
    $salida->v_visto = $v_visto;
    echo json_encode($salida);
}
?>