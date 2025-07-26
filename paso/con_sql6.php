<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
ini_set('memory_limit', '3072M');
ini_set('max_execution_time', 3600);
if ($_SESSION["autenticado"] = "SI")
{
  if (is_ajax())
  {
    if ($sup_usuario == "1")
    {
      $tipo = $_POST['tipo'];
      $unidad = $_POST['unidad'];
      $numero = $_POST['numero'];
      $ano = $_POST['ano'];
      $ano1 = date('Y');
      $salida = new stdClass();
      // Planilla gastos basicos
      if ($tipo == "1")
      {
        $pregunta = "SELECT conse, ciudad, ordop, total, interno, solicitud, responsable, adicional, elaboro FROM cx_gas_bas WHERE conse='$numero' AND unidad='$unidad' AND ano='$ano'";
        $sql = odbc_exec($conexion, $pregunta);
        $total = odbc_num_rows($sql);
        if ($total>0)
        {
          $conse = odbc_result($sql,1);
          $ciudad = trim(utf8_encode(odbc_result($sql,2)));
          $ordop = trim(utf8_encode(odbc_result($sql,3)));
          $total1 = trim(odbc_result($sql,4));
          $interno = odbc_result($sql,5);
          $solicitud = odbc_result($sql,6);
          $responsable = trim(utf8_encode(odbc_result($sql,7)));
          $adicional = trim(utf8_encode(odbc_result($sql,8)));
          $elaboro = trim(utf8_encode(odbc_result($sql,9)));
          // Discrimidado de planillas
          $pregunta1 = "SELECT conse, cedula, nombre, ciudad, v1, v2, v3, valor, valor1, v4 FROM cx_gas_dis WHERE conse1='$conse' AND interno='$interno' ORDER BY conse";
          $sql1 = odbc_exec($conexion,$pregunta1);
          $i = 0;
          while ($i < $row = odbc_fetch_array($sql1))
          {
            $salida->rows[$i]['conse'] = odbc_result($sql1,1);
            $salida->rows[$i]['cedula'] = trim(utf8_encode(odbc_result($sql1,2)));
            $salida->rows[$i]['nombre'] = trim(utf8_encode(odbc_result($sql1,3)));
            $salida->rows[$i]['ciudad'] = trim(utf8_encode(odbc_result($sql1,4)));
            $salida->rows[$i]['v1'] = odbc_result($sql1,5);
            $salida->rows[$i]['v2'] = odbc_result($sql1,6);
            $salida->rows[$i]['v3'] = odbc_result($sql1,7);
            $salida->rows[$i]['valor'] = trim(odbc_result($sql1,8));
            $salida->rows[$i]['valor1'] = odbc_result($sql1,9);
            $salida->rows[$i]['v4'] = odbc_result($sql1,10);
            $i++;
          }
        }
        $salida->planillas = $i;
        $salida->conse = $conse;
        $salida->ciudad = $ciudad;
        $salida->ordop = $ordop;
        $salida->total = $total1;
        $salida->interno = $interno;
        $salida->solicitud = $solicitud;
        $salida->responsable = $responsable;
        $salida->adicional = $adicional;
        $salida->elaboro = $elaboro;
      }
      // Solicitud de partidas
      if ($tipo == "2")
      {
        $pregunta = "SELECT conse, interno, gasto, valor FROM cx_pla_gad WHERE conse1='$numero' AND unidad='$unidad' AND ano='$ano' ORDER BY conse";
        $sql = odbc_exec($conexion, $pregunta);
        $total = odbc_num_rows($sql);
        if ($total>0)
        {
          $i = 0;
          while ($i < $row = odbc_fetch_array($sql))
          {
            $gasto = odbc_result($sql,3);
            $pregunta1 = "SELECT tipo FROM cx_ctr_pag WHERE codigo='$gasto'";
            $sql1 = odbc_exec($conexion,$pregunta1);
            $tipo = trim(odbc_result($sql1,1));
            $salida->rows[$i]['conse'] = odbc_result($sql,1);
            $salida->rows[$i]['interno'] = odbc_result($sql,2);
            $salida->rows[$i]['gasto'] = $gasto;
            $salida->rows[$i]['tipo'] = $tipo;
            $salida->rows[$i]['valor'] = trim(odbc_result($sql,4));
            $i++;
          }
        }
        $salida->total = $total;
      }
      // Regresar estado de solicitudes
      if ($tipo == "3")
      {
        if ($ano == $ano1)
        {
          $pregunta = "SELECT conse, usuario, unidad, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_pla_est.unidad) AS n_unidad, estado, usuario1, (SELECT unidad FROM cx_usu_web WHERE cx_usu_web.usuario=cx_pla_est.usuario1) AS unidad1 FROM cx_pla_est WHERE solicitud='$numero' AND ano='$ano' ORDER BY fecha";
          $sql = odbc_exec($conexion, $pregunta);
          $total = odbc_num_rows($sql);
          if ($total>0)
          {
            $i = 0;
            while ($i < $row = odbc_fetch_array($sql))
            {
              $unidad1 = odbc_result($sql,7);
              $pregunta1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad1'";
              $sql1 = odbc_exec($conexion, $pregunta1);
              $n_unidad1 = trim(odbc_result($sql1,1));
              $salida->rows[$i]['conse'] = odbc_result($sql,1);
              $salida->rows[$i]['usuario'] = trim(odbc_result($sql,2));
              $salida->rows[$i]['unidad'] = odbc_result($sql,3);
              $salida->rows[$i]['n_unidad'] = odbc_result($sql,4);
              $salida->rows[$i]['estado'] = trim(odbc_result($sql,5));
              $salida->rows[$i]['usuario1'] = trim(odbc_result($sql,6));
              $salida->rows[$i]['unidad1'] = $unidad1;
              $salida->rows[$i]['n_unidad1'] = $n_unidad1;
              $i++;
            }
          }
          else
          {
            $pregunta = "SELECT 0 AS conse, usuario2, unidad, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_pla_inv.unidad) AS n_unidad, estado, usuario3, ISNULL((SELECT unidad FROM cx_usu_web WHERE cx_usu_web.usuario=cx_pla_inv.usuario3),0) AS unidad1 FROM cx_pla_inv WHERE estado!='' AND conse='$numero' AND ano='$ano' AND tipo='2'";
            $sql = odbc_exec($conexion, $pregunta);
            $total = odbc_num_rows($sql);
            if ($total>0)
            {
              $i = 0;
              while ($i < $row = odbc_fetch_array($sql))
              {
                $unidad1 = odbc_result($sql,7);
                $pregunta1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad1'";
                $sql1 = odbc_exec($conexion, $pregunta1);
                $n_unidad1 = trim(odbc_result($sql1,1));
                $salida->rows[$i]['conse'] = odbc_result($sql,1);
                $salida->rows[$i]['usuario'] = trim(odbc_result($sql,2));
                $salida->rows[$i]['unidad'] = odbc_result($sql,3);
                $salida->rows[$i]['n_unidad'] = odbc_result($sql,4);
                $salida->rows[$i]['estado'] = trim(odbc_result($sql,5));
                $salida->rows[$i]['usuario1'] = trim(odbc_result($sql,6));
                $salida->rows[$i]['unidad1'] = $unidad1;
                $salida->rows[$i]['n_unidad1'] = $n_unidad1;
                $i++;
              }
              $salida->total = $total;
            }
            else
            {
              $salida->total = "0";
            }
          }
          $salida->total = $total;
        }
        else
        {
          $salida->total = "0";
        }
      }
      // Consulta datos
      if ($tipo == "A")
      {
        $interno = $_POST['interno'];
        $pregunta = "SELECT bienes FROM cx_pla_gad WHERE conse='$interno' AND conse1='$numero' AND unidad='$unidad' AND ano='$ano'";
        $sql = odbc_exec($conexion, $pregunta);
        $bienes =  trim(utf8_encode(odbc_result($sql,1)));
        $salida->bienes = $bienes;
      }
      echo json_encode($salida);
    }
  }
}
?>