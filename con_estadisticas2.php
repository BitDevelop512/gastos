<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
    $consulta = $_POST['consulta'];
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $unidad = $_POST['unidad'];
    $fechas = explode("/",$fecha1);
    $periodo = $fechas[1];
    $periodo = intval($periodo);
    $ano = $fechas[0];
    $ano = intval($ano);
    $unidades = stringArray1($unidad);
    $longitud = explode(",",$unidades);
    $valores = "";
    $valores1 = "";
    $valores2 = "";
    $valores3 = "";
    $valores4 = "";
    for ($j=0; $j<count($longitud); $j++)
    {
        $valor = $longitud[$j];
        $pregunta = "SELECT total, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_rel_gas.unidad) AS n_unidad FROM cx_rel_gas WHERE unidad='$valor' AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1) AND periodo='$periodo' AND ano='$ano' ORDER BY conse";
        $cur = odbc_exec($conexion, $pregunta);
        $total = odbc_num_rows($cur);
        $total = intval($total);
        if ($total > 0)
        {
            $k = 0;
            $subtotal = 0;
            $conses = "";
            while($k<$row=odbc_fetch_array($cur))
            {
                $v1 = trim(odbc_result($cur,1));
                $v2 = trim(odbc_result($cur,2));
                $v3 = str_replace(',','',$v1);
                $v3 = substr($v3,0,-3);
                $v3 = floatval($v3);
                $subtotal = $subtotal+$v3;
                $k++;
            }
            $valores .= '"'.$v2.'", ';
            $valores1 .= $subtotal.", ";
        }
        else
        {
            $subtotal = 0;
            $pregunta5 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$valor'";
            $cur5 = odbc_exec($conexion, $pregunta5);
            $v3 = trim(odbc_result($cur5,1));
            $valores .= '"'.$v3.'", ';
            $valores1 .= $subtotal.", ";
        }
        // Se consulta plan consolidado para obtener consecutivos




//select * from cx_inf_aut where unidad1=33 and periodo=8 and ano=2021
//select * from cx_pla_inv where tipo=2 and unidad=33 and ano=2021 and periodo=8 and estado in ('W','G')
//select * from cx_pla_gas where conse1=6798 and ano=2021
//select * from cx_act_inf where ano=2021 and unidad=33 and fecha between convert(datetime,'2021/08/01',102) and convert(datetime,'2021/08/31',102)



    //$fec_log = date("d/m/Y H:i:s a");
    //$file = fopen("log_jm2021.txt", "a");
    //fwrite($file, $fec_log." # ".$v1." # ".$v2." # ".$v3." # ".$subtotal." # ".PHP_EOL);
    //fclose($file);



        $pregunta1 = "SELECT planes FROM cx_pla_con WHERE unidad='$valor' AND periodo='$periodo' AND ano='$ano'";
        $cur1 = odbc_exec($conexion, $pregunta1);
        $total1 = odbc_num_rows($cur1);
        $total1 = intval($total1);
        if ($total1 > 0)
        {
            $planes = odbc_result($cur1,1);
            $planes = decrypt1($planes, $llave);
        }
        else
        {
            $planes = "";
        }
        // Se consulta misiones
        $pregunta2 = "SELECT COUNT(1) AS registrados FROM cx_pla_gas WHERE conse1 IN ($planes) AND ano='$ano'";
        $cur2 = odbc_exec($conexion, $pregunta2);

        $total2 = odbc_num_rows($cur2);
        $total2 = intval($total2);
        if ($total2 > 0)
        {
            $registrados = odbc_result($cur2,1);
            $valores2 .= $registrados.", ";
        }
        else
        {
            $valores2 .= "0, ";   
        }
        // Se consulta pago de informaciones
        $pregunta3 = "SELECT COUNT(1) AS informantes FROM cx_pla_pag WHERE conse IN ($planes) AND ano='$ano'";
        $cur3 = odbc_exec($conexion, $pregunta3);
        $informantes = odbc_result($cur3,1);
        $valores3 .= $informantes.", ";
        // Se consultan solicitud de recursos
        $pregunta4 = "SELECT COUNT(1) AS solicitudes FROM cx_pla_inv WHERE unidad='$valor' AND tipo='2' AND estado IN ('G', 'W') AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1) AND periodo='$periodo' AND ano='$ano'";
        $cur4 = odbc_exec($conexion, $pregunta4);
        $solicitudes = odbc_result($cur4,1);
        $valores4 .= $solicitudes.", ";
    }
    $valores = substr($valores, 0, -2);
    $valores1 = substr($valores1, 0, -2);
    $valores2 = substr($valores2, 0, -2);
    $valores3 = substr($valores3, 0, -2);
    $valores4 = substr($valores4, 0, -2);
    $salida->datos = $valores;
    $salida->datos1 = $valores1;
    $salida->datos2 = $valores2;
    $salida->datos3 = $valores3;
    $salida->datos4 = $valores4;
    echo json_encode($salida);
}
?>