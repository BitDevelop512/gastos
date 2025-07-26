<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$unidad = $_POST['unidad'];
	$fecha1 = $_POST['fecha1'];
	$fecha2 = $_POST['fecha2'];
	$pregunta = "SELECT conse, fecha, usuario, unidad, periodo, ano, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_pla_inv.unidad) AS n_unidad FROM cx_pla_inv WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND unidad!='999' AND estado!='' AND EXISTS (SELECT * FROM cx_pla_gas WHERE cx_pla_gas.conse1=cx_pla_inv.conse AND cx_pla_gas.unidad=cx_pla_inv.unidad AND cx_pla_gas.ano=cx_pla_inv.ano)";
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
      $fecha = odbc_result($sql,2);
      $fecha = substr($fecha,0,10);
      $usuario = trim(odbc_result($sql,3));		
      $unidad1 = odbc_result($sql,4);
      $periodo = odbc_result($sql,5);
      $ano = odbc_result($sql,6);
      $n_unidad = trim(odbc_result($sql,7));
      $mes = str_pad($periodo,2,"0",STR_PAD_LEFT);
      $pregunta1 = "SELECT interno, mision, valor, valor_a, area, fechai, fechaf FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano' AND unidad='$unidad1'";
      $sql1 = odbc_exec($conexion, $pregunta1);
      $l = 0;
      while ($l < $row1 = odbc_fetch_array($sql1))
      {
        $interno = odbc_result($sql1,1);
        $mision = trim(utf8_encode(odbc_result($sql1,2)));
        $valor = trim(odbc_result($sql1,3));
        $valor = str_replace(',','',$valor);
        $valor = floatval($valor);
        $valor1 = trim(odbc_result($sql1,4));
        $valor1 = str_replace(',','',$valor1);
        $valor1 = floatval($valor1);
        $mision = trim(utf8_encode(odbc_result($sql1,2)));
        $area = trim(utf8_encode(odbc_result($sql1,5)));
        $fechai = trim(odbc_result($sql1,6));
        $fechaf = trim(odbc_result($sql1,7));
        $pregunta2 = "SELECT SUM(valor1) AS valor FROM cx_rel_dis WHERE consecu='$conse' AND ano='$ano' AND EXISTS (SELECT * FROM cx_rel_gas WHERE cx_rel_gas.conse=cx_rel_dis.conse1 AND cx_rel_gas.consecu=cx_rel_dis.consecu AND cx_rel_gas.numero='$interno')";
        $sql2 = odbc_exec($conexion, $pregunta2);
        $tot2 = odbc_num_rows($sql2);
        if ($tot2 == "0")
        {
          $valor2 = "0";
        }
        else
        {
          $valor2 = odbc_result($sql2,1);
        }
        $valores .= $conse."|".$fecha."|".$usuario."|".$unidad1."|".$periodo."|".$ano."|".$n_unidad."|".$mision."|".$interno."|".$valor."|".$valor1."|".$valor2."|".$area."|".$fechai."|".$fechaf."|#";
        $l++;
      }
      $i++;
    }
  }
  $salida->valores = $valores;
  echo json_encode($salida);
}
// 11/04/2024 - Consulta y exportacion a excel
// 22/07/2024 - Ajuste inclusion de unidades que dependen de centralizadora
// 30/07/2024 - Ajuste inclusion columna valor ejecutado
// 27/11/2024 - Ajuste inclusion columna area y lapso de fechas
// 23/04/2025 - Ajuste inclusion planes y solicitudes
?>