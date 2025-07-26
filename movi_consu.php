<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $tipo = $_POST['tipo'];
  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];
  $codigo = $_POST['codigo'];
  $salida = new stdClass();
  if (($tipo == "1") or ($tipo == "4"))
  {
    if ($tipo == "1")
    {
      if ($tpc_usuario == "1")
      {
        $pregunta = "SELECT * FROM cv_pla_bie WHERE num_dependencia='$dun_usuario'";
      }
      else
      {
        $v1 = explode("_", $usu_usuario);
        $v2 = $v1[0];
        $v3 = $v1[1];
        if ($v2 == "SGR")
        {
          $pregunta = "SELECT * FROM cv_pla_bie WHERE unidad='$uni_usuario'";
        }
        else
        {
          $pregunta = "SELECT * FROM cv_pla_bie WHERE unidad='$uni_usuario' AND compania='$v3'";
        }         
      }
    }
    if ($tipo == "4")
    {
      $pregunta = "SELECT * FROM cv_pla_bie WHERE num_dependencia='$dun_usuario'";
    }
    if (!empty($_POST['fecha1']))
    {
      $pregunta .= " AND CONVERT(datetime,fec_com,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND convert(datetime,'$fecha2',102)";
    }
    $pregunta .= " ORDER BY codigo";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    if ($total > 0)
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
        $salida->rows[$i]['unidad1'] = trim($row['unidad1']);
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
        $salida->rows[$i]['unidad'] = $row['unidad'];
        $salida->rows[$i]['unidad1'] = trim(utf8_encode($row['unidad1']));
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
        $salida->rows[$i]['acto2'] = trim($row['acto2']);
        $salida->rows[$i]['fechat'] = $row['fechat'];
        $salida->rows[$i]['observa2'] = trim(utf8_encode($row['observa2']));
        $pregunta2 = "SELECT acto, fechac, observaciones FROM cx_bie_mov WHERE codigos LIKE '$codigo1%' AND tipo='6'";
        $sql2 = odbc_exec($conexion,$pregunta2);
        $revistas = "";
        $j = 0;
        while($j < $row=odbc_fetch_array($sql2))
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
  }
  if ($tipo == "3")
  {
    $pregunta = "SELECT * FROM cx_bie_mov WHERE 1=1";
    if (($uni_usuario == "1") or ($uni_usuario == "2"))
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
    if (!empty($_POST['codigo']))
    {
      $pregunta .= " AND codigos LIKE '%$codigo%'";
    }
    $pregunta .= " ORDER BY fecha DESC";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    if ($total > 0)
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
            $tipo = "ASIGNACIÓN";
            break;
          case '2':
            $tipo = "SALIDA DE BIENES";
            break; 
          case '3':
            $tipo = "ELEMENTOS DE CONSUMO";
            break;
          case '4':
            $tipo = "TRASPASO";
            break;
          case '5':
            $tipo = "ASIGNACIÓN USUARIO FINAL";
            break;
          case '6':
            $tipo = "REVISTA CONFRONTACIÓN DE CARGOS";
            break;
          default:
            $tipo = "";
            break;
        }
        $n_tipo1 = $row['tipo1'];
        if ($n_tipo1 == "1")
        {
          $tipo1 = "ALTA DEL BIEN";
        }
        else
        {
          if ($n_tipo1 == "2")
          {
            $tipo1 = "SINIESTRO";
          }
          else
          {
            $tipo1 = "N/A";
          }
        }
        $tipo1 = utf8_encode($tipo1);
        $salida->rows[$i]['codigos'] = $row['codigos'];
        $salida->rows[$i]['ano'] = $row['ano'];
        $salida->rows[$i]['tipo'] = $tipo;
        $salida->rows[$i]['tipo1'] = $tipo1;
        $salida->rows[$i]['tipo2'] = $row['tipo'];
        $salida->rows[$i]['tipo3'] = $row['tipo1'];
        $unidad1 = $row['unidad1'];
        $pregunta1 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad1'";
        $sql1 = odbc_exec($conexion,$pregunta1);
        $n_unidad = trim(odbc_result($sql1,1));
        if ($unidad1 == "0")
        {
          $salida->rows[$i]['n_unidad'] = "";
        }
        else
        {
          $salida->rows[$i]['n_unidad'] = $n_unidad;
        }
        if (($n_tipo == "1") || ($n_tipo == "2") || ($n_tipo == "3") || ($n_tipo == "4") || ($n_tipo == "5") || ($n_tipo == "6"))
        {
          if ($n_tipo == "4")
          {
            $alea = trim($row['informe']);
          }
          else
          {
            $alea = trim($row['dato1']);
          }
          switch ($n_tipo)
          {
            case '1':
              $ruta = "upload/movimientos/asignacion/".$alea."/";
              break;
            case '2':
              $ruta = "upload/movimientos/salida/".$alea."/";
              break;
            case '3':
              $ruta = "upload/movimientos/consumo/".$alea."/";
              break;
            case '4':
              $ruta = "upload/movimientos/traspaso/".$alea."/";
              break;
            case '5':
              $ruta = "upload/movimientos/usuario/".$alea."/";
              break;
            case '6':
              $ruta = "upload/movimientos/revista/".$alea."/";
              break;
            default:
              break;
          }
          $contador = count(glob("{$ruta}/*.*"));
        }
        else
        {
          $alea = "";
          $contador = 0;
        }
        $salida->rows[$i]['alea'] = $alea;
        $salida->rows[$i]['archivo'] = $contador;
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
  }
  echo json_encode($salida);
}
// 25/09/2024 - Ajuste identacion lineas
// 17/01/2025 - Ajuste label tipo de movimiento
// 06/02/2025 - Ajsute consulta actas
?>