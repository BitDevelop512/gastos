<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $actual = date('Y-m-d');
  $valor = $_POST['valor'];
  $tipo = $_POST['tipo'];
  $n_unidad = $_POST['n_unidad'];
  $dependencia = $_POST['dependencia'];
  $numero = $_POST['numero'];
  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];
  $super = $_POST['super'];
  if ($tipo == "1")
  {
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $unidad = $_POST['unidad'];
    $clase = $_POST['clase'];
    $marca = $_POST['marca'];
    $color = $_POST['color'];
    $modelo = $_POST['modelo'];
    $serial = $_POST['serial'];
    $valor1 = $_POST['valor1'];
    $valor2 = $_POST['valor2'];
    $valor1 = floatval($valor1);
    $valor2 = floatval($valor2);
  }
  if ($valor == "1")
  {
    $pregunta = "SELECT * FROM cv_pla_bie WHERE unidad!='777' AND unidad!='888' AND unidad!='999'";
  }
  else
  {
    $pregunta = "SELECT * FROM cv_pla_bie WHERE (unidad='777' OR unidad='888' OR unidad='999')";
  }
  if ($tipo == "0")
  {
  }
  else
  {
    if (!empty($_POST['codigo']))
    {
      $pregunta .= " AND codigo LIKE '%$codigo%'";
    }
    if (!empty($_POST['descripcion']))
    {
      $pregunta .= " AND descripcion LIKE '%$descripcion%'";
    }
    if (!empty($_POST['unidad']))
    {
      if ($unidad == "999")
      {
      }
      else
      {
        $pregunta .= " AND unidad='$unidad'";
      }
    }
    if (!empty($_POST['clase']))
    {
      if ($clase == "999")
      {
      }
      else
      {
        $pregunta .= " AND clasi='$clase'";
      }
    }
    if (!empty($_POST['marca']))
    {
      $pregunta .= " AND marca LIKE '%$marca%'";
    }
    if (!empty($_POST['color']))
    {
      $pregunta .= " AND color LIKE '%$color%'";
    }
    if (!empty($_POST['modelo']))
    {
      $pregunta .= " AND modelo LIKE '%$modelo%'";
    }
    if (!empty($_POST['serial']))
    {
      $pregunta .= " AND serial LIKE '%$serial%'";
    }
    if ($valor2 > 0)
    {
      $pregunta .= " AND valor1>=$valor1 and valor1<$valor2";
    }
  }
  if ($super == "0")
  {
    $pregunta .= " AND unidad IN ($numero)";
  }
  if (!empty($_POST['fecha1']))
  {
    $pregunta .= " AND CONVERT(datetime,fec_com,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1)";
  }
  $pregunta .= " ORDER BY codigo";
  $sql = odbc_exec($conexion,$pregunta);
  $total = odbc_num_rows($sql);
  $salida = new stdClass();
  if ($total>0)
  {
    $i = 0;
    while ($i < $row = odbc_fetch_array($sql))
    {
      $codigo1 = trim($row['codigo']);
      $salida->rows[$i]['conse'] = $row['conse'];
      $salida->rows[$i]['codigo'] = $codigo1;
      $salida->rows[$i]['descripcion'] = trim(utf8_encode($row["descripcion"]));
      $salida->rows[$i]['nombre'] = trim(utf8_encode($row["nombre"]));
      $salida->rows[$i]['valor'] = trim($row['valor']);
      $salida->rows[$i]['valor1'] = $row['valor1'];
      $salida->rows[$i]['marca'] = trim(utf8_encode($row["marca"]));
      $salida->rows[$i]['color'] = trim(utf8_encode($row['color']));
      $salida->rows[$i]['modelo'] = trim(utf8_encode($row['modelo']));
      $salida->rows[$i]['serial'] = trim(utf8_encode($row['serial']));
      $clasi = $row['clasi'];
      $pregunta1 = "SELECT nombre FROM cx_ctr_cla WHERE codigo='$clasi'";
      $sql1 = odbc_exec($conexion,$pregunta1);
      $total1 = odbc_num_rows($sql1);
      if ($total1 == "0")
      {
        $n_clase = "NO IDENTIFICADO";
      }
      else
      {
        $n_clase =  trim(utf8_encode(odbc_result($sql1,1)));
      }
      $unidad1 = $row['unidad'];
      $unidad2 = trim(utf8_encode($row['unidad1']));
      // Se consulta cambio de sigla
      $pregunta3 = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unidad1'";
      $sql3 = odbc_exec($conexion,$pregunta3);
      $sigla = trim(odbc_result($sql3,1));
      $sigla1 = trim(odbc_result($sql3,2));
      $fsigla = trim(odbc_result($sql3,3));
      if ($fsigla == "")
      {
      }
      else
      {
        $fsigla = str_replace("/", "-", $fsigla);
        if ($actual >= $fsigla)
        {
          $unidad2 = $sigla1;
        }
      }
      // Fin cambio de sigla
      $salida->rows[$i]['n_clase'] = $n_clase;
      $salida->rows[$i]['fec_com'] = trim($row['fec_com']);
      $salida->rows[$i]['soa_num'] = trim(utf8_encode($row['soa_num']));
      $salida->rows[$i]['soa_ase'] = trim(utf8_encode($row['soa_ase']));
      $salida->rows[$i]['soa_fe1'] = trim($row['soa_fe1']);
      $salida->rows[$i]['soa_fe2'] = trim($row['soa_fe1']);
      $salida->rows[$i]['seg_cla'] = trim(utf8_encode($row['seg_cla']));
      $salida->rows[$i]['seg_val'] = trim($row['seg_val']);
      $salida->rows[$i]['seg_num'] = trim(utf8_encode($row['seg_num']));
      $salida->rows[$i]['seg_ase'] = trim(utf8_encode($row['seg_ase']));
      $salida->rows[$i]['seg_fe1'] = trim($row['seg_fe1']);
      $salida->rows[$i]['seg_fe2'] = trim($row['seg_fe2']);
      $salida->rows[$i]['funcionario'] = trim(utf8_encode($row['funcionario']));
      $salida->rows[$i]['ordop'] = trim(utf8_encode($row['ordop']));
      $salida->rows[$i]['mision'] = trim(utf8_encode($row['mision']));
      $salida->rows[$i]['ordop1'] = trim(utf8_encode($row['ordop1']));
      $salida->rows[$i]['mision1'] = trim(utf8_encode($row['mision1']));
      $salida->rows[$i]['numero'] = $row['numero'];
      $salida->rows[$i]['relacion'] = $row['relacion'];
      $salida->rows[$i]['compania'] = trim(utf8_encode($row['compania']));
      $salida->rows[$i]['estado1'] = trim(utf8_encode($row['estado1']));
      $salida->rows[$i]['egreso'] = $row['egreso'];
      $salida->rows[$i]['unidad'] = $unidad1;
      $salida->rows[$i]['unidad1'] = $unidad2;
      $n_devolitivo = trim($row['devolutivo']);
      if ($n_devolitivo == "1")
      {
        $devolutivo = "ELEMENTO DEVOLUTIVO";
      }
      else
      {
        $devolutivo = "ELEMENTO DE CONSUMO";
      }
      $salida->rows[$i]['devolutivo'] = utf8_encode($devolutivo);
      $salida->rows[$i]['nom_respon'] = trim(utf8_encode($row['nom_respon']));
      $salida->rows[$i]['doc_respon'] = trim(utf8_encode($row['doc_respon']));
      $salida->rows[$i]['fec_respon'] = $row['fec_respon'];
      $salida->rows[$i]['sap'] = trim($row['sap']);
      $salida->rows[$i]['alta'] = trim($row['alta']);
      $salida->rows[$i]['fechaa'] = $row['fechaa'];
      $n_almacen = $row['almacen'];
      if ($n_almacen == "0")
      {
        $almacen = "";
      }
      else
      {
        if ($n_almacen == "1")
        {
          $almacen = "BASIM";
        }
        else
        {
          $almacen = "BASCI";
        }
      }
      $salida->rows[$i]['almacen'] = $almacen;
      $salida->rows[$i]['fechas'] = $row['fechas'];
      $n_siniestro = $row['siniestro'];
      switch ($n_siniestro)
      {
        case '1':
          $siniestro = "HURTO";
          break;
        case '2':
          $siniestro = "PERDIDA";
          break;
        case '3':
          $siniestro = "DAÑO PARCIAL";
          break;
        case '4':
          $siniestro = "DAÑO TOTAL";
          break;
        default:
          $siniestro = "";
          break;
      }
      $salida->rows[$i]['siniestro'] = utf8_encode($siniestro);
      $salida->rows[$i]['informe'] = trim($row['informe']);
      $salida->rows[$i]['fechai'] = $row['fechai'];
      $salida->rows[$i]['acto'] = trim($row['acto']);
      $salida->rows[$i]['fechac'] = $row['fechac'];
      $salida->rows[$i]['observa'] = trim(utf8_encode($row['observa']));
      $salida->rows[$i]['acto1'] = trim($row['acto1']);
      $salida->rows[$i]['fechac1'] = $row['fechac1'];
      $salida->rows[$i]['informe1'] = trim($row['informe1']);
      $salida->rows[$i]['fechai1'] = $row['fechai1'];
      $salida->rows[$i]['observa1'] = trim(utf8_encode($row['observa1']));
      $salida->rows[$i]['nom_usua'] = trim(utf8_encode($row['nom_usua']));
      $salida->rows[$i]['doc_usua'] = trim($row['doc_usua']);
      $salida->rows[$i]['fec_usua'] = trim($row['fec_usua']);
      $salida->rows[$i]['fec_rela'] = substr($row['fec_rela'],0,10);
      $salida->rows[$i]['alea'] = trim($row['alea']);
      $salida->rows[$i]['acto2'] = trim($row['acto2']);
      $salida->rows[$i]['fechat'] = $row['fechat'];
      $salida->rows[$i]['observa2'] = trim(utf8_encode($row['observa2']));
      $salida->rows[$i]['usu_regi'] = trim($row['usu_regi']);
      $salida->rows[$i]['fec_regi'] = substr($row['fec_regi'],0,10);
      $pregunta2 = "SELECT acto, fechac, observaciones FROM cx_bie_mov WHERE codigos LIKE '$codigo1%' AND tipo='6'";
      $sql2 = odbc_exec($conexion,$pregunta2);
      $revistas = "";
      $j = 0;
      while($j<$row=odbc_fetch_array($sql2))
      {
        $num_act = odbc_result($sql2,1);
        $fec_act = odbc_result($sql2,2);
        $obs_act = trim(utf8_encode($row["observaciones"]));
        $revistas .= $fec_act." - ".$num_act." ".$obs_act."<br><br>";
        $j++;
      }
      $salida->rows[$i]['revistas'] = $revistas;
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
// 29/11/2024 - Ajuste consulta historico / administrador
// 05/02/2025 - Ajuste cambio de sigla
// 10/02/2025 - Ajuste inclusion campo usuario y fecha registro de movimiento
?>