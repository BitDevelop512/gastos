<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $tipo = $_POST['tipo'];
  $unidades = $_POST['numeros'];
  $unidad = $_POST['unidad'];
  switch ($tipo)
  {
    case '1':
      $pregunta = "SELECT conse, codigo, descripcion, valor, unidad1, compania, ordop1, mision1, nom_respon, doc_respon, fec_respon, serial FROM cv_pla_bie WHERE unidad='$uni_usuario' AND responsable='0' AND responsable1='0' ORDER BY codigo";
      break;
    case '2':
      $pregunta = "SELECT conse, codigo, descripcion, valor, unidad1, compania, ordop1, mision1, nom_respon, doc_respon, fec_respon, serial FROM cv_pla_bie WHERE responsable!='0' AND devolutivo='1' AND unidad!='888' AND unidad!='999' ORDER BY codigo";
      break;
    case '3':
      $pregunta = "SELECT conse, codigo, descripcion, valor, unidad1, compania, ordop1, mision1, nom_respon, doc_respon, fec_respon, serial FROM cv_pla_bie WHERE unidad='$uni_usuario' AND responsable!='0' AND devolutivo='2' ORDER BY codigo";
      break;
    case '4':
      $pregunta = "SELECT conse, codigo, descripcion, valor, unidad1, compania, ordop1, mision1, nom_respon, doc_respon, fec_respon, serial FROM cv_pla_bie WHERE unidad IN ($unidades) AND responsable!='0' AND devolutivo='1' ORDER BY codigo";
      break;
    case '5':
      $pregunta = "SELECT conse, codigo, descripcion, valor, unidad1, compania, ordop1, mision1, nom_respon, doc_respon, fec_respon, serial FROM cv_pla_bie WHERE unidad='$uni_usuario' AND responsable!='0' AND responsable1='0' ORDER BY codigo";
      break;
    case '6':
      if ($unidad == "999")
      {
        $unidades1 = $unidades;
      }
      else
      {
        $unidades1 = $unidad;
      }
      $pregunta = "SELECT conse, codigo, descripcion, valor, unidad1, compania, ordop1, mision1, nom_respon, doc_respon, fec_respon, serial FROM cv_pla_bie WHERE unidad IN ($unidades1) AND responsable!='0' AND devolutivo='1' ORDER BY codigo";
      break;
    default:
      $pregunta = "";
      break;
  }
  $sql = odbc_exec($conexion,$pregunta);
  $total = odbc_num_rows($sql);
  $salida = new stdClass();
  if ($total>0)
  {
    switch ($tipo)
    {
      case '1':
      case '2':
      case '3':
      case '4':
      case '5':
      case '6':
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
          $salida->rows[$i]['conse'] = $row['conse'];
          $salida->rows[$i]['codigo'] = trim($row['codigo']);
          $salida->rows[$i]['descripcion'] = trim(utf8_encode($row['descripcion']));
          $salida->rows[$i]['valor'] = trim($row['valor']);
          $salida->rows[$i]['valor1'] = $row['valor1'];
          $salida->rows[$i]['unidad'] = trim($row['unidad1']);
          $salida->rows[$i]['compania'] = trim(utf8_encode($row['compania']));
          $salida->rows[$i]['ordop'] = trim(utf8_encode($row['ordop1']));
          $salida->rows[$i]['mision'] = trim(utf8_encode($row['mision1']));
          $salida->rows[$i]['responsable'] = trim(utf8_encode($row['nom_respon']));
          $salida->rows[$i]['documento'] = trim(utf8_encode($row['doc_respon']));
          $salida->rows[$i]['fecha'] = trim($row['fec_respon']);
          $salida->rows[$i]['serial'] = trim(utf8_encode($row['serial']));
          $i++;
        }
        break;
      default:
        break;
    }
  }
  $salida->total = $total;
  echo json_encode($salida);
}
?>