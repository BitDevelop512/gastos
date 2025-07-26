<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $conse = $_POST['conse'];
    $ano = $_POST['ano'];
    $numero = $_POST['numero'];
    $consecu = $_POST['consecu'];
    $pregunta = "SELECT * FROM cx_inf_eje WHERE unidad='$uni_usuario' AND usuario='$usu_usuario' AND conse='$conse' AND ano='$ano' AND numero='$numero' AND consecu='$consecu'";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    $i = 1;
    while($i<$row=odbc_fetch_array($sql))
    {
        $valor = trim(odbc_result($sql,9));
        $sitio = trim(utf8_encode(odbc_result($sql,10)));
        $fechai = trim(odbc_result($sql,11));
        $fechaf = trim(odbc_result($sql,12));
        $factor = trim(utf8_encode(odbc_result($sql,13)));
        $actividades = trim($row["actividades"]);
        $actividades = utf8_encode($actividades);
        $sintesis = trim($row["sintesis"]);
        $sintesis = utf8_encode($sintesis);
        $aspectos = trim($row["aspectos"]);
        $aspectos = utf8_encode($aspectos);
        $bienes = trim($row["bienes"]);
        $bienes = utf8_encode($bienes);
        $personal = trim($row["personal"]);
        $personal = utf8_encode($personal);
        $equipo = trim($row["equipo"]);
        $equipo = utf8_encode($equipo);
        $responsable = trim($row["responsable"]);
        $responsable = utf8_encode($responsable);
        $elaboro = trim($row["elaboro"]);
        $elaboro = utf8_encode($elaboro);
        $salida->rows[$i]['valor'] = $valor;
        $salida->rows[$i]['sitio'] = $sitio;
        $salida->rows[$i]['fechai'] = $fechai;
        $salida->rows[$i]['fechaf'] = $fechaf;
        $salida->rows[$i]['factor'] = $factor;
        $salida->rows[$i]['actividades'] = $actividades;
        $salida->rows[$i]['sintesis'] = $sintesis;
        $salida->rows[$i]['aspectos'] = $aspectos;
        $salida->rows[$i]['bienes'] = $bienes;
        $salida->rows[$i]['personal'] = $personal;
        $salida->rows[$i]['equipo'] = $equipo;
        $salida->rows[$i]['responsable'] = $responsable;
        $salida->rows[$i]['elaboro'] = $elaboro;
        $i++;
    }
    echo json_encode($salida);
}
?>