<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];
  $tipou = $_POST['tipou'];
  $unidad = $_POST['unidad'];
  $placa = $_POST['placa'];
  $salida = new stdClass();
  $pregunta = "SELECT * FROM cx_tra_mom WHERE 1=1";
  if (($uni_usuario == "0") or ($uni_usuario == "1") or ($uni_usuario == "2"))
  {
  }
  else
  {
    $pregunta .= " AND unidad='$uni_usuario'";
  }
  if (!empty($_POST['fecha1']))
  {
    $pregunta .= " AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1)";
  }
  if ($tipou == "-")
  {
  }
  else
  {
    if ($unidad == "-")
    {
    }
    else
    {
      if ($tipou == "1")
      {
        $pregunta .= " AND unidad='$unidad'";
      }
      else
      {
        $pregunta .= " AND unidad1='$unidad'";
      }
    }
  }
  if (!empty($_POST['placa']))
  {
    $pregunta .= " AND placa='$placa'";
  }
  $pregunta .= " ORDER BY fecha DESC";
  $sql = odbc_exec($conexion,$pregunta);
  $total = odbc_num_rows($sql);
  if ($total>0)
  {
    $i = 0;
    while ($i < $row = odbc_fetch_array($sql))
    {
      $salida->rows[$i]['conse'] = $row['conse'];
      $salida->rows[$i]['fecha'] = substr($row["fecha"],0,10);
      $n_tipo = $row['tipo'];
      switch ($n_tipo)
      {
        case '1':
          $tipo = "TRASPASO";
          break;
        default:
          $tipo = "";
          break;
      }
      $tipo = utf8_encode($tipo);
      $conse = $row['conse'];
      $pregunta0 = "SELECT tipo FROM cx_pla_tra WHERE conse='$conse'";
      $sql0 = odbc_exec($conexion,$pregunta0);
      $n_clase = odbc_result($sql0,1);
      switch ($n_clase)
      {
        case '1':
          $clase = "MOTOCICLETA";
          break;
        case '2':
          $clase = "AUTOMÓVIL";
          break;
        case '3':
          $clase = "CAMIONETA";
          break;
        case '4':
          $clase = "VANS";
          break;
        case '5':
          $clase = "CAMPERO";
          break;
        case '6':
          $clase = "MICROBUS";
          break;
        case '7':
          $clase = "CAMIÓN";
          break;
        default:
          $clase = "";
        break;
      }
      $clase = utf8_encode($clase);
      $salida->rows[$i]['conse'] = $conse;
      $salida->rows[$i]['clase'] = $clase;
      $salida->rows[$i]['placa'] = $row['placa'];
      $salida->rows[$i]['ano'] = $row['ano'];
      $salida->rows[$i]['tipo'] = $tipo;
      $salida->rows[$i]['tipo1'] = $row['tipo'];
      $unidad = $row['unidad'];
      $unidad1 = $row['unidad1'];
      $pregunta1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
      $sql1 = odbc_exec($conexion,$pregunta1);
      $n_unidad = trim(odbc_result($sql1,1));
      $pregunta2 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad1'";
      $sql2 = odbc_exec($conexion,$pregunta2);
      $n_unidad1 = trim(odbc_result($sql2,1));
      $salida->rows[$i]['n_unidad'] = $n_unidad;
      $salida->rows[$i]['n_unidad1'] = $n_unidad1;
      $alea = trim($row['alea']);
      $ruta = "upload/movimientos1/traspaso/".$alea."/";
      $contador = count(glob("{$ruta}/*.*"));
      $salida->rows[$i]['alea'] = $alea;
      $salida->rows[$i]['archivo'] = $contador;
      $salida->rows[$i]['acto'] = $row['acto'];
      $salida->rows[$i]['observaciones'] = trim(utf8_encode($row['observaciones']));
      $salida->rows[$i]['elaboro'] = trim(utf8_encode($row['elaboro']));
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
// 19/10/2023 - Ajuste nuevos campos de busqueda e inclusion de elaboro para exportar a excel
// 06/02/2025 - Ajuste consulta jemic - unidad = 0
?>