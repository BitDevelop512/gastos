<!doctype html>
<?php
session_start();
error_reporting(0);
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('conf.php');
  include('funciones.php');
	include('permisos.php');
  $actual = date('Y-m-d');
  $periodo = $_GET['periodo'];
  $ano = $_GET['ano'];
  // Se consulta Oficial GR de Brigada
  $consu1 = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur1 = odbc_exec($conexion, $consu1);
  $unidad = odbc_result($cur1,1);
  $depen = odbc_result($cur1,2);
  if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
  {
    $consu2 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$depen' AND unic='1'";
  }
  else
  {
    $consu2 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$depen' AND unic='2'";
  }  
  $cur2 = odbc_exec($conexion, $consu2);
  $depen1 = odbc_result($cur2,1);
  if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
  {
    if ($adm_usuario == "27")
    {
      $consu3 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='4'";
    }
    else
    {
      $consu3 = "SELECT usuario FROM cx_usu_web WHERE unidad='$depen1' AND admin='6'";
    }
  }
  else
  {
    if ($adm_usuario == "6")
    {
      $consu3 = "SELECT usuario FROM cx_usu_web WHERE unidad='$depen1' AND admin='7'";
    }
    else
    {
      if ($adm_usuario == "7")
      {
        $consu3 = "SELECT usuario FROM cx_usu_web WHERE unidad='$depen1' AND admin='9'";
      }
      else
      {
        $query3 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND unic='1'";
        $cur3 = odbc_exec($conexion, $query3);
        $depen1 = odbc_result($cur3,1);
        // Se consulta usuario division
        $consu3 = "SELECT usuario FROM cx_usu_web WHERE unidad='$depen1' AND admin='10'";
      }
    }
  }
  $cur3 = odbc_exec($conexion, $consu3);
  $gr = trim(odbc_result($cur3,1));
  //echo "Datos: ".$gr." - ".$depen1." - ".$adm_usuario." - ".$depen;
  // Se consultan los planes
  if ($adm_usuario == "6")
  {
    if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
    {
      $query1 = "SELECT conse FROM cx_pla_inv WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano' AND tipo='1'";
    }
    else
    {
      $query0 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$depen' ORDER BY dependencia, subdependencia";
      $cur0 = odbc_exec($conexion, $query0);
      $numero = "";
      while($i<$row=odbc_fetch_array($cur0))
      {
        $numero .= "'".odbc_result($cur0,1)."',";
      }
      $numero = substr($numero,0,-1);
      $query1 = "SELECT conse FROM cx_pla_inv WHERE unidad IN ($numero) AND periodo='$periodo' AND ano='$ano' AND tipo='1' ORDER BY unidad";
    }
  }
  else
  {
    if (($adm_usuario == "7") or ($adm_usuario == "9"))
    {
      if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
      {
        $query1 = "SELECT conse FROM cx_pla_inv WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano' AND tipo='1'";
      }
      else
      {
        $query0 = "SELECT planes FROM cx_pla_con WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
        $cur0 = odbc_exec($conexion,$query0);
        $planes = odbc_result($cur0,1);
        $planes1 = trim(decrypt1($planes, $llave));
        $query1 = "SELECT conse FROM cx_pla_inv WHERE conse IN ($planes1) AND periodo='$periodo' AND ano='$ano' AND tipo='1'";
      }
    }
    else
    {
      $query1 = "SELECT conse FROM cx_pla_inv WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano' AND tipo='1'";
    }
  }
  $sql1 = odbc_exec($conexion,$query1);
  $tot_plan = odbc_num_rows($sql1);
  $j = 1;
  $conses = "";
  while($j<$row=odbc_fetch_array($sql1))
  {
    $conses .= "'".odbc_result($sql1,1)."',";
  }
  $conses = substr($conses,0,-1);
  // Se consultan planes consolidados del mes y el año de la unidad
  $query3 = "SELECT conse FROM cx_pla_con WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
  $sql3 = odbc_exec($conexion,$query3);
  $tot_con = odbc_num_rows($sql3);
?>
<html lang="es">
<head>
<?php
  include('encabezado.php');
  include('encabezado2.php');
  include('encabezado4.php');
?>
  <script type="text/javascript" src="alertas/lib/alertify.js"></script>
  <link rel="stylesheet" href="alertas/themes/alertify.core.css"/>
  <link rel="stylesheet" href="alertas/themes/alertify.default.css"/>
</head>
<body style="overflow-x:hidden; overflow-y:auto;">
<div>
  <br>
  <center>
    <font face="Verdana" size="3">
      <b>Revisi&oacute;n Plan / Solicitud Consolidado</b>
    </font>
  </center>
  <br>
  <div id="load">
    <center>
      <img src="dist/img/cargando1.gif" alt="Cargando..." />
    </center>
  </div>
  <form name="formu" method="post">
    <table align="center" width="95%" border="0">
      <tr>
        <td>
          <div class="row">
            <div class="col col-lg-2 col-sm-2 col-md-4 col-xs-4">
              <label><font face="Verdana" size="2">Estado:</font></label>
            </div>
            <div class="col col-lg-3 col-sm-3 col-md-6 col-xs-6">
              <input type="hidden" name="conses" id="conses" class="form-control" value="<?php echo $conses; ?>" readonly="readonly">
              <input type="hidden" name="unidad" id="unidad" class="form-control" value="<?php echo $uni_usuario ?>" readonly="readonly">
              <input type="hidden" name="gr" id="gr" class="form-control" value="<?php echo $gr; ?>" readonly="readonly">
              <input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly">
              <input type="hidden" name="depen1" id="depen1" class="form-control" value="<?php echo $depen1; ?>" readonly="readonly">
              <input type="hidden" name="tot_con" id="tot_con" class="form-control" value="<?php echo $tot_con; ?>" readonly="readonly">
              <input type="hidden" name="tot_plan" id="tot_plan" class="form-control" value="<?php echo $tot_plan; ?>" readonly="readonly">
              <input type="hidden" name="admin" id="admin" class="form-control" value="<?php echo $adm_usuario; ?>" readonly="readonly">
              <select name="estado" id="estado" class="form-control select2">
                <option value="B">APROBADO</option>
                <option value="Y">RECHAZADO</option>
              </select>
            </div>
          </div>
        </td>
      </tr>
    </table>
    <br>
    <table align="center" width="95%" border="0">
      <tr>
        <td>
          <div id="div0">
            <?php
            if ($adm_usuario == "6")
            {
              $query2 = "SELECT conse, compania, unidad FROM cx_pla_inv WHERE conse IN ($conses) AND ano='$ano' AND estado NOT IN ('','X','Y') ORDER BY unidad";
            }
            else
            {
              $query2 = "SELECT conse, compania, unidad FROM cx_pla_inv WHERE conse IN ($conses) AND ano='$ano' AND estado NOT IN ('','X','Y') ORDER BY compania";
            }
            $sql2 = odbc_exec($conexion,$query2);
            $j = 1;
            while($j<$row=odbc_fetch_array($sql2))
            {
              $conse = odbc_result($sql2,1);
              $compa = odbc_result($sql2,2);
              $unid = odbc_result($sql2,3);
              $consu_compa = "SELECT nombre FROM cx_org_cmp WHERE conse='$compa'";
              $cur_compa = odbc_exec($conexion,$consu_compa);
              $n_compania = trim(utf8_encode(odbc_result($cur_compa,1)));
              $consu_unid = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unid'";
              $cur_unid = odbc_exec($conexion,$consu_unid);
              $n_unid = trim(odbc_result($cur_unid,1));
              $m_unid = trim(odbc_result($cur_unid,2));
              $f_unid = trim(odbc_result($cur_unid,3));
              if ($f_unid == "")
              {
              }
              else
              {
                $f_unid = str_replace("/", "-", $f_unid);
                if ($actual >= $f_unid)
                {
                  $n_unid = $m_unid;
                }
              }
              echo "<div class='row'><div class='col col-lg-12 col-sm-12 col-md-12 col-xs-12'><label><font face='Verdana' size='2'>".$n_unid." - ".$n_compania."</font></label></div></div><br>";
              // Gastos
              $consulta = "SELECT * FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano'";
              $cur = odbc_exec($conexion,$consulta);
              $i = 1;
              while($i<$row=odbc_fetch_array($cur))
              {
                $con_mis = odbc_result($cur,1);
                $mision = trim(odbc_result($cur,5));
                $valora1 = trim(odbc_result($cur,13));
                $var1 = "Misión: ".$mision;
                echo "<div class='row'><div class='col col-lg-2 col-sm-2 col-md-4 col-xs-4'><label><font face='Verdana' size='2'>Misión:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><font face='Verdana' size='2'>".utf8_encode($mision)."</font></div></div><br><div class='row'><div class='col col-lg-2 col-sm-2 col-md-4 col-xs-4'><label><font face='Verdana' size='2'>Valor:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><font face='Verdana' size='2'>".$valora1."</font><input type='hidden' name='caa_".$j."_".$i."' id='caa_".$j."_".$i."' class='c7' value='".$con_mis."' readonly='readonly'><input type='hidden' name='vaa_".$j."_".$i."' id='vaa_".$j."_".$i."' class='c7' value='".$valora1."' readonly='readonly'></div></div><br>";
                $i++;
              }
              // Bienes - Combustibles - Grasas
              $consulta2 = "SELECT bienes, gasto FROM cx_pla_gad WHERE conse1='$conse' AND ano='$ano'";
              $cur2 = odbc_exec($conexion,$consulta2);
              $l = 1;
              $det_bienes = "";
              while($l<$row=odbc_fetch_array($cur2))
              {
                $val_bie = trim($row['bienes']);
                $num_bie = trim(odbc_result($cur2,2));
                $consulta3 = "SELECT tipo FROM cx_ctr_pag WHERE codigo='$num_bie'";
                $cur3 = odbc_exec($conexion,$consulta3);
                $let_bie = trim(odbc_result($cur3,1));
                switch ($let_bie)
                {
                  case 'B':
                    $nom_bie = "Bienes";
                    break;
                  case 'C':
                    $nom_bie = "Combustibles";
                    break;
                  case 'G':
                    $nom_bie = "Grasas y Lubricantes";
                    break;
                  case 'M':
                    $nom_bie = "Mantenimiento y Repuestos";
                    break;
                  case 'T':
                    $nom_bie = "RTM";
                    break;
                  case 'L':
                    $nom_bie = "Llantas";
                    break;
                  default:
                    $nom_bie = "";
                    break;
                }
                if ($val_bie == "")
                {
                }
                else
                {
                  if ($let_bie == "B")
                  {
                    $val_bie = utf8_encode($val_bie);
                    $val_bie1 = explode("#", $val_bie);
                    $val_bie2 = $val_bie1[1];
                    $val_bie3 = strtoupper($val_bie1[3]);
                    $val_bie4 = explode("&", $val_bie3);
                    $val_bie5 = explode("&", $val_bie2);
                    $val_bie6 = strtoupper($val_bie1[4]);
                    $val_bie7 = explode("&", $val_bie6);
                    for ($k=0;$k<count($val_bie4)-1;++$k)
                    {
                      $det_bienes .= $val_bie4[$k]. " - ".$val_bie5[$k]. " - ".$val_bie7[$k]."<br>";
                    }
                  }
                  else
                  {
                    $det_bienes = "";
                    switch ($let_bie)
                    {
                      case 'C':
                        $val_bie = utf8_encode($val_bie);
                        $val_bie1 = explode("#", $val_bie);
                        $val_bie2 = explode("&", $val_bie1[0]);
                        $val_bie3 = explode("&", $val_bie1[1]);
                        $val_bie4 = explode("&", $val_bie1[2]);
                        $val_bie5 = explode("&", $val_bie1[3]);
                        $val_bie6 = explode("&", $val_bie1[4]);
                        for ($k=0;$k<count($val_bie4)-1;++$k)
                        {
                          $det_bienes .= $val_bie2[$k]. " - ".$val_bie3[$k]. " - ".$val_bie6[$k]." - $ ".$val_bie4[$k]."<br>";
                        }
                        break;
                      case 'G':
                        $val_bie = utf8_encode($val_bie);
                        $val_bie1 = explode("#", $val_bie);
                        $val_bie2 = explode("&", $val_bie1[0]);
                        $val_bie3 = explode("&", $val_bie1[1]);
                        $val_bie4 = explode("&", $val_bie1[2]);
                        $val_bie5 = explode("&", $val_bie1[3]);
                        $val_bie6 = explode("&", $val_bie1[4]);
                        $val_bie7 = explode("&", $val_bie1[5]);
                        $val_bie8 = explode("&", $val_bie1[6]);
                        $val_bie9 = explode("&", $val_bie1[7]);
                        $val_bie10 = explode("&", $val_bie1[8]);
                        $val_bie11 = explode("&", $val_bie1[9]);
                        $val_bie12 = explode("&", $val_bie1[10]);
                        $val_bie13 = explode("&", $val_bie1[11]);
                        $val_bie14 = explode("&", $val_bie1[12]);
                        for ($k=0;$k<count($val_bie4)-1;++$k)
                        {
                          $val_rep = floatval($val_bie8[$k])+floatval($val_bie13[$k]);
                          $val_rep = number_format($val_rep, 2);
                          $det_bienes .= $val_bie2[$k]. " - ".$val_bie3[$k]. " - ".$val_bie14[$k]." - $ ".$val_rep."<br>";
                        }
                        break;
                      case 'M':
                        $val_bie = utf8_encode($val_bie);
                        $val_bie1 = explode("#", $val_bie);
                        $val_bie2 = explode("&", $val_bie1[0]);
                        $val_bie3 = explode("&", $val_bie1[1]);
                        $val_bie4 = explode("&", $val_bie1[2]);
                        $val_bie5 = explode("&", $val_bie1[3]);
                        $val_bie6 = explode("&", $val_bie1[4]);
                        $val_bie7 = explode("&", $val_bie1[5]);
                        $val_bie8 = explode("&", $val_bie1[6]);
                        $val_bie9 = explode("&", $val_bie1[7]);
                        $val_bie10 = explode("&", $val_bie1[8]);
                        $val_bie11 = explode("&", $val_bie1[9]);
                        $val_bie12 = explode("&", $val_bie1[10]);
                        $val_bie13 = explode("&", $val_bie1[11]);
                        $val_bie14 = explode("&", $val_bie1[12]);
                        $val_bie15 = explode("&", $val_bie1[13]);
                        $val_bie16 = explode("&", $val_bie1[14]);
                        for ($k=0;$k<count($val_bie4)-1;++$k)
                        {
                          $consulta4 = "SELECT nombre FROM cx_ctr_rep WHERE codigo='$val_bie10[$k]'";
                          $cur4 = odbc_exec($conexion,$consulta4);
                          $nom_rep = trim(utf8_encode(odbc_result($cur4,1)));
                          $val_rep = floatval($val_bie8[$k])+floatval($val_bie15[$k]);
                          $val_rep = number_format($val_rep, 2);
                          $det_bienes .= $val_bie2[$k]. " - ".$val_bie3[$k]. " - ".$nom_rep." - $ ".$val_rep."<br>";
                        }
                        break;
                      case 'T':
                        $val_bie = utf8_encode($val_bie);
                        $val_bie1 = explode("#", $val_bie);
                        $val_bie2 = explode("&", $val_bie1[0]);
                        $val_bie3 = explode("&", $val_bie1[1]);
                        $val_bie4 = explode("&", $val_bie1[2]);
                        $val_bie5 = explode("&", $val_bie1[3]);
                        $val_bie6 = explode("&", $val_bie1[4]);
                        $val_bie7 = explode("&", $val_bie1[5]);
                        $val_bie8 = explode("&", $val_bie1[6]);
                        $val_bie9 = explode("&", $val_bie1[7]);
                        for ($k=0;$k<count($val_bie4)-1;++$k)
                        {
                          $val_rep = floatval($val_bie7[$k]);
                          $val_rep = number_format($val_rep, 2);
                          $det_bienes .= $val_bie2[$k]. " - ".$val_bie3[$k]. " - ".strtoupper($val_bie9[$k])." - $ ".$val_rep."<br>";
                        }
                        break;
                      case 'L':
                        $val_bie = utf8_encode($val_bie);
                        $val_bie1 = explode("#", $val_bie);
                        $val_bie2 = explode("&", $val_bie1[0]);
                        $val_bie3 = explode("&", $val_bie1[1]);
                        $val_bie4 = explode("&", $val_bie1[2]);
                        $val_bie5 = explode("&", $val_bie1[3]);
                        $val_bie6 = explode("&", $val_bie1[4]);
                        $val_bie7 = explode("&", $val_bie1[5]);
                        $val_bie8 = explode("&", $val_bie1[6]);
                        $val_bie9 = explode("&", $val_bie1[7]);
                        $val_bie10 = explode("&", $val_bie1[8]);
                        $val_bie11 = explode("&", $val_bie1[9]);
                        $val_bie12 = explode("&", $val_bie1[10]);
                        $val_bie13 = explode("&", $val_bie1[11]);
                        $val_bie14 = explode("&", $val_bie1[12]);
                        $val_bie15 = explode("&", $val_bie1[13]);
                        $val_bie16 = explode("&", $val_bie1[14]);
                        for ($k=0;$k<count($val_bie4)-1;++$k)
                        {
                          $val_rep = floatval($val_bie8[$k]);
                          $val_rep = number_format($val_rep, 2);
                          $det_bienes .= $val_bie2[$k]. " - ".$val_bie3[$k]. " - ".$val_bie11[$k]." - ".$val_bie10[$k]." - $ ".$val_rep."<br>";
                        }
                        break;
                      default:
                        $det_bienes = "";
                        break;
                    }
                  }
                  echo "<div class='row'><div class='col col-lg-2 col-sm-2 col-md-4 col-xs-4'><label><font face='Verdana' size='2'>".$nom_bie.":</font></label></div><div class='col col-lg-8 col-sm-8 col-md-8 col-xs-8'><font face='Verdana' size='2'>".$det_bienes."</font></div></div><br>";
                }
                $l++;
              }
              echo "<br>";
              $consulta1 = "SELECT * FROM cx_pla_pag WHERE conse='$conse' AND ano='$ano' ORDER BY conse1";
              $cur1 = odbc_exec($conexion,$consulta1);
              $k = 1;
              while($k<$row=odbc_fetch_array($cur1))
              {
                $cedula = trim(odbc_result($cur1,4));
                if (strpos($cedula, "K") !== false)
                {
                }
                else
                {
                  $cedula = "XXXX".substr($cedula,-4);
                }
                $con_fue = odbc_result($cur1,1);
                $valora2 = trim(odbc_result($cur1,17));
                $var2 = "Fuente: ".$cedula;
                echo "<font face='Verdana' size='2'>".$var2."<br>Valor:&nbsp;&nbsp;&nbsp;$valora2</font><input type='hidden' name='cab_".$j."_".$k."' id='cab_".$j."_".$k."' class='c7' value='".$con_fue."' readonly='readonly'><input type='hidden' name='vab_".$j."_".$k."' id='vab_".$j."_".$k."' class='c7' value='".$valora2."' readonly='readonly'><input type='hidden' name='xab_".$j."_".$k."' id='xab_".$j."_".$k."' class='c7' value='".$k."' readonly='readonly'><br><br>";
                $k++;
              }
              $j++;
              echo "<hr>";
            }
            echo "<center><font face='Verdana' size='2'>Se enviar&aacute; notificaci&oacute;n a: ".$gr."</font></center><br>";
            ?>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div id="div1">
            <?php
            if ($adm_usuario == "6")
            {
              $query2 = "SELECT conse, compania, unidad FROM cx_pla_inv WHERE conse IN ($conses) AND ano='$ano' AND estado NOT IN ('','X','Y') ORDER BY conse";
            }
            else
            {
              $query2 = "SELECT conse, compania, unidad FROM cx_pla_inv WHERE conse IN ($conses) AND ano='$ano' AND estado NOT IN ('','X','Y') ORDER BY compania"; 
            }
            $sql2 = odbc_exec($conexion,$query2);
            $j = 1;
            while($j<$row=odbc_fetch_array($sql2))
            {
              $conse = odbc_result($sql2,1);
              $compa = odbc_result($sql2,2);
              $unid = odbc_result($sql2,3);
              $consu_compa = "SELECT nombre FROM cx_org_cmp WHERE conse='$compa'";
              $cur_compa = odbc_exec($conexion,$consu_compa);
              $n_compania = trim(utf8_encode(odbc_result($cur_compa,1)));
              $consu_unid = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unid'";
              $cur_unid = odbc_exec($conexion,$consu_unid);
              $n_unid = trim(utf8_encode(odbc_result($cur_unid,1)));
              echo "<div class='row'><div class='col col-lg-12 col-sm-12 col-md-12 col-xs-12'><label><font face='Verdana' size='2'>".$n_unid." - ".$n_compania."</font></label></div></div><br>";
              $consulta = "SELECT * FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano'";
              $cur = odbc_exec($conexion,$consulta);
              $i = 1;
              while($i<$row=odbc_fetch_array($cur))
              {
                $con_mis = odbc_result($cur,1);
                $mision = trim(odbc_result($cur,5));
                $valorm1 = trim(odbc_result($cur,13));
                $valorm = trim(odbc_result($cur,13));
                $valorm = str_replace(',','',$valorm);
                $valorm = intval($valorm);
                $var1 = "Misión: ".$mision;
                echo "<div class='row'><div class='col col-lg-2 col-sm-2 col-md-4 col-xs-4'><label><font face='Verdana' size='2'>Misión:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><font face='Verdana' size='2'>".utf8_encode($mision)."</font></div></div><br><div class='row'><div class='col col-lg-2 col-sm-2 col-md-4 col-xs-4'><label><font face='Verdana' size='2'>Valor:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><input type='hidden' name='cam_".$j."_".$i."' id='cam_".$j."_".$i."' class='form-control numero' value='".$con_mis."'><input type='text' name='vam_".$j."_".$i."' id='vam_".$j."_".$i."' class='form-control numero' value='".$valorm1."' onkeyup='paso_val(".$j.",".$i.")' onchange='paso_com(".$j.",".$i.")'><input type='hidden' name='vap_".$j."_".$i."' id='vap_".$j."_".$i."' class='form-control numero' value='".$valorm."' readonly='readonly'><input type='hidden' name='vas_".$j."_".$i."' id='vas_".$j."_".$i."' value='0' readonly='readonly'></div></div><br><script>$('#vam_".$j."_".$i."').maskMoney();</script>";
                $i++;
              }
              $consulta1 = "SELECT * FROM cx_pla_pag WHERE conse='$conse' AND ano='$ano'";
              $cur1 = odbc_exec($conexion,$consulta1);
              $k = 1;
              while($k<$row=odbc_fetch_array($cur1))
              {
                $cedula = trim(odbc_result($cur1,4));
                if (strpos($cedula, "K") !== false)
                {
                }
                else
                {
                  $cedula = "XXXX".substr($cedula,-4);
                }
                $con_fue = odbc_result($cur1,1);
                $valorn1 = trim(odbc_result($cur1,17));
                $valorn = trim(odbc_result($cur1,17));
                $valorn = str_replace(',','',$valorn);
                $valorn = intval($valorn);
                $var2 = "Fuente: ".$cedula;
                 echo "<font face='Verdana' size='2'>".$var2."<br>Valor:&nbsp;&nbsp;&nbsp;</font><input type='hidden' name='caf_".$j."_".$k."' id='caf_".$j."_".$k."' class='c7' value='".$con_fue."'><input type='text' name='vaf_".$j."_".$k."' id='vaf_".$j."_".$k."' class='c7' value='".$valorn1."' onkeyup='paso_val1(".$j.",".$k.")' onchange='paso_com1(".$j.",".$k.")'><input type='hidden' name='vaq_".$j."_".$k."' id='vaq_".$j."_".$k."' class='c7' value='".$valorn."' readonly='readonly'><input type='hidden' name='vat_".$j."_".$k."' id='vat_".$j."_".$k."' class='c7' value='0' readonly='readonly'><input type='hidden' name='xaf_".$j."_".$k."' id='xaf_".$j."_".$k."' class='c7' value='".$k."' readonly='readonly'><br><br><script>$('#vaf_".$j."_".$k."').maskMoney();</script>";
                $k++;
              }
              $j++;
              echo "<hr>";
            }
            ?>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div id="div3">
            <div class="row">
              <div class="col col-lg-2 col-sm-2 col-md-4 col-xs-4">
                <label><font face="Verdana" size="2">Observaciones<br>y/o Criterios de<br>Autorizaci&oacute;n</font></label>
              </div>
              <div class="col col-lg-6 col-sm-6 col-md-8 col-xs-8">
                <textarea name="motivo" id="motivo" class="form-control" rows="5" onblur="val_caracteres('motivo');"></textarea>
              </div>
            </div>
            <br>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <center>
            <input type="hidden" name="v_val1" id="v_val1" readonly="readonly">
            <input type="hidden" name="v_val2" id="v_val2" readonly="readonly">
            <input type="hidden" name="v_val3" id="v_val3" readonly="readonly">
            <input type="hidden" name="v_val4" id="v_val4" readonly="readonly">
            <input type="hidden" name="v_val5" id="v_val5" readonly="readonly">
            <br>
            <input type="button" name="aceptar" id="aceptar" value="Aceptar">
          </center>
        </td>
      </tr>
      <tr>
        <td>
          <br>
          <center>
            <input type="button" name="aceptar1" id="aceptar1" value="Regresar">
          </center>
        </td>
      </tr>
    </table>
  </form>
</div>
<div id="dialogo"></div>
<div id="dialogo1"></div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 210,
    width: 300,
    closeOnEscape: false,
    resizable: false,
    draggable: false,
    show:
    {
      effect: "blind",
      duration: 1000
    },
    hide:
    {
      effect: "explode",
      duration: 1000
    },
    buttons: [
      {
        text: "Ok",
        click: function() {
          $(this).dialog("close");
        }
      }
    ]
  });
  $("#dialogo1").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 210,
    width: 300,
    modal: true,
    closeOnEscape: false,
    resizable: false,
    draggable: false,
    show:
    {
      effect: "blind",
      duration: 1000
    },
    hide:
    {
      effect: "explode",
      duration: 1000
    },
    buttons: {
      "Aceptar": function() {
        $(this).dialog("close");
        prende();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#estado").change(valida_div);
  $("#aceptar").button();
  $("#aceptar1").button();
  $("#aceptar").click(valida);
  $("#aceptar1").click(volver);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#div1").hide();
  $("#div3").hide();
  $("#motivo").css('width',230);
  $("#motivo").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  valida_totales();
});
function valida_totales()
{
  var valida;
  valida = $("#tot_plan").val();
  valida = parseInt(valida);
  if (valida == "0")
  {
    window.open("nota_con.php", "R2");
    window.open("resultado1.php", "R3");
  }
  else
  {
    valida_consoli();
  }
}
function valida_consoli()
{
  var valida, detalle, admin;
  valida = $("#tot_con").val();
  valida = parseInt(valida);
  admin = $("#admin").val();
  if ((admin == "4") || (admin == "6"))
  {
    if (valida > 0)
    {
      $("#aceptar").hide();
      detalle = "<br><br><center>Consolidado del Mes ya generado</center>";
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
    }
    else
    {
      $("#aceptar").show();
      valida_estados();
    }
  }
}
function valida_estados()
{
  var valida;
  valida = $("#conses").val();
  ano = $("#ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "vali_estado.php",
    data:
    {
      conses: valida,
      ano: ano
    },
    beforeSend: function ()
    {
      $("#load").show();
    },
    error: function ()
    {
      $("#load").hide();
    },
    success: function (data)
    {
      $("#load").hide();
      var registros = JSON.parse(data);
      var valida = registros.salida;
      valida = parseInt(valida);
      if (valida > 1)
      {
        $("#aceptar").hide();
        $("#estado").prop("disabled",true);
        var detalle;
        detalle = "<br><br><center>Se encontraron Planes / Solicitudes sin aprobar, no se puede continuar</center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
      }
      else
      {
        valida_planes();
      }
    }
  });
}
function valida_planes()
{
	var valida;
	valida = $("#conses").val();
  ano = $("#ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "vali_plan.php",
    data:
    {
      conses: valida,
      ano: ano
    },
    beforeSend: function ()
    {
      $("#load").show();
    },
    error: function ()
    {
      $("#load").hide();
    },
    success: function (data)
    {
      $("#load").hide();
      var registros = JSON.parse(data);
      var valida;
      valida = registros.salida;
      if ((valida == "1") || (valida == "2"))
      {
		  	$("#aceptar").hide();
			  $("#estado").prop("disabled",true);
			  var detalle;
        if (valida == "1")
        {
          detalle = "<br><br><center>Se encontraron Planes / Solicitudes rechazadas, no se puede continuar</center>";
        }
        else
        {
          detalle = "<br><br><center>Se encontraron Planes / Solicitudes sin revisar o aprobar, no se puede continuar</center>";
        }
    		$("#dialogo1").html(detalle);
    		$("#dialogo1").dialog("open");
        $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
      }
      else
      {
	   	 $("#aceptar").show();
			 $("#estado").prop("disabled",false);
      }
    }
  });
}
function valida_div()
{
  var valida;
  valida = $("#estado").val();
  if ((valida == "A") || (valida == "B"))
  {
    $("#div0").show();
    $("#div1").hide();
    $("#div3").hide();
  }
  else
  {
    $("#div0").hide();
    $("#div1").show();
    $("#div3").show();    
  }
}
function paso_val(valor, valor1)
{
  var valor, valor1, valor2;
  valor2 = document.getElementById('vam_'+valor+'_'+valor1).value;
  valor2 = parseFloat(valor2.replace(/,/g,''));
  $("#vas_"+valor+"_"+valor1).val(valor2);
}
function paso_val1(valor, valor1)
{
  var valor, valor1, valor2;
  valor2 = document.getElementById('vaf_'+valor+'_'+valor1).value;
  valor2 = parseFloat(valor2.replace(/,/g,''));
  $("#vat_"+valor+"_"+valor1).val(valor2);
}
function paso_com(valor, valor0)
{
  var valor, valor0;
  var valor1 = $("#vas_"+valor+"_"+valor0).val();
  var valor2 = $("#vap_"+valor+"_"+valor0).val();
  var valor3 = (valor1-valor2);
  if (valor3 > 0)
  {
    var detalle = "Valor Superior al Solicitado";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
    $("#vam_"+valor+"_"+valor0).val('0.00');
    paso_val(valor+","+valor0);
  }  
}
function paso_com1(valor, valor0)
{
  var valor, valor0;
  var valor1 = $("#vat_"+valor+"_"+valor0).val();
  var valor2 = $("#vaq_"+valor+"_"+valor0).val();
  var valor3 = (valor1-valor2);
  if (valor3 > 0)
  {
    var detalle = "Valor Superior al Solicitado";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
    $("#vaf_"+valor+"_"+valor0).val('0.00');
    paso_val1(valor+","+valor0);
  }  
}
function valida()
{
  var valida;
  valida = $("#estado").val();
  if (valida == "Y")
  {
    document.getElementById('v_val1').value="";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vam_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val1').value=document.getElementById('v_val1').value+valor+"|";
      }
    }
    document.getElementById('v_val2').value="";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vaf_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val2').value=document.getElementById('v_val2').value+valor+"|";
      }
    }
    document.getElementById('v_val3').value="";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('cam_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val3').value=document.getElementById('v_val3').value+valor+"|";
      }
    }
    document.getElementById('v_val4').value="";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('caf_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val4').value=document.getElementById('v_val4').value+valor+"|";
      }
    }
    document.getElementById('v_val5').value="";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('xaf_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val5').value=document.getElementById('v_val5').value+valor+"|";
      }
    }
  }
  if ((valida == "A") || (valida == "B"))
  {
    document.getElementById('v_val1').value="";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vaa_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val1').value=document.getElementById('v_val1').value+valor+"|";
      }
    }
    document.getElementById('v_val2').value="";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vab_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val2').value=document.getElementById('v_val2').value+valor+"|";
      }
    }
    document.getElementById('v_val3').value="";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('caa_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val3').value=document.getElementById('v_val3').value+valor+"|";
      }
    }
    document.getElementById('v_val4').value="";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('cab_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val4').value=document.getElementById('v_val4').value+valor+"|";
      }
    }
    document.getElementById('v_val5').value="";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('xab_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val5').value=document.getElementById('v_val5').value+valor+"|";
      }
    }
  }
  graba();
}
function graba()
{
  var salida = true, detalle = '';
  valida = $("#estado").val();
  if (valida == "Y")
  {
    var suma1 = 0;
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux=document.formu.elements[i].name;
      if (saux.indexOf('vam_')!=-1)
      {
        valor = document.getElementById(saux).value;
        if (valor == "0.00")
        {
          suma1 ++;
        }
      }
    }
    if (suma1 > 0)
    {
      salida = false;
      detalle += "Debe ingresar "+suma1+" Valor(es) de Misión<br><br>";      
    }
    var suma2 = 0;
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux=document.formu.elements[i].name;
      if (saux.indexOf('vaf_')!=-1)
      {
        valor = document.getElementById(saux).value;
        if (valor == "0.00")
        {
          suma2 ++;
        }
      }
    }
    if (suma2 > 0)
    {
      salida = false;
      detalle += "Debe ingresar "+suma2+" Valor(es) de Fuente<br><br>";      
    }
    if ($("#motivo").val() == '')
    {
      salida = false;
      detalle += "Debe ingresar una Observación<br><br>";
    }
  }
  var oficial = $("#gr").val();  
  oficial = oficial.trim();
  if (oficial == '')
  {
    salida = false;
    detalle += "<center><h3>Usuario a Notificar No Encontrado<br>Favor Revisar Parametrización</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
  }
  else
  {
    var oficial = $("#gr").val();
    var depen1 = $("#depen1").val();
    var conses = $("#conses").val();
    var unidad = $("#unidad").val();
    var estado = $("#estado").val();
    var ano = $("#ano").val();
    var valores1 = $("#v_val1").val();
    var valores2 = $("#v_val2").val();
    var valores3 = $("#v_val3").val();
    var valores4 = $("#v_val4").val();
    var valores5 = $("#v_val5").val();
    var motivo = $("#motivo").val();
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "apli_actu2.php",
      data:
      {
        oficial: oficial,
        depen1: depen1,
        conses: conses,
        unidad: unidad,
        estado: estado,
        ano: ano,
        valores1: valores1,
        valores2: valores2,
        valores3: valores3,
        valores4: valores4,
        valores5: valores5,
        motivo: motivo
      },
      beforeSend: function ()
      {
        $("#load").show();
      },
      error: function ()
      {
        $("#load").hide();
      },
      success: function (data)
      {
        $("#load").hide();
        var registros = JSON.parse(data);
        var valida, notifica;
        valida = registros.salida;
        notifica = registros.notifica;
        if ((valida == "A") || (valida == "B") || (valida == "F") || (valida == "H") || (valida == "R") || (valida == "Y"))
        {
          $("#aceptar").hide();
          $("#estado").prop("disabled",true);
          $("#motivo").prop("disabled",true);
  	      for (i=0;i<document.formu.elements.length;i++)
       	  {
            saux = document.formu.elements[i].name;
          	if (saux.indexOf('vam_')!=-1)
        		{
          		document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
  	      for (i=0;i<document.formu.elements.length;i++)
        	{
          	saux = document.formu.elements[i].name;
          	if (saux.indexOf('vaf_')!=-1)
        		{
          		document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
          detalle = "<center><h3>Notificaci&oacute;n Enviada a: "+notifica+"</center></h3>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#aceptar").show();
        }
      }
    });
  }
}
function val_caracteres(valor)
{
  var valor;
  var detalle = $("#"+valor).val();
  detalle = detalle.replace(/[•]+/g, "*");
  detalle = detalle.replace(/[●]+/g, "*");
  detalle = detalle.replace(/[é́]+/g, "é");
  detalle = detalle.replace(/[]+/g, "*");
  detalle = detalle.replace(/[]+/g, "*");
  detalle = detalle.replace(/[]+/g, "*");
  detalle = detalle.replace(/[ ]+/g, " ");
  detalle = detalle.replace(/[ ]+/g, '');
  detalle = detalle.replace(/[‐]+/g, '-');
  detalle = detalle.replace(/[–]+/g, "-");
  detalle = detalle.replace(/[—]+/g, '-');
  detalle = detalle.replace(/[…]+/g, "..."); 
  detalle = detalle.replace(/[“”]+/g, '"');
  detalle = detalle.replace(/[‘]+/g, '´');
  detalle = detalle.replace(/[’]+/g, '´');
  detalle = detalle.replace(/[′]+/g, '´');
  detalle = detalle.replace(/[']+/g, '´');
  detalle = detalle.replace(/[™]+/g, '');
  $("#"+valor).val(detalle);
}
function prende()
{
  $("#aceptar").show();
}
function volver()
{
  parent.location.href = "revi_plan.php";
}
function alerta(valor)
{
  alertify.error(valor);
}
function alerta1(valor)
{
  alertify.success(valor);
}
</script>
</body>
</html>
<?php
}
// 10/08/2023 - Ajuste de cambio de sigla validando la fecha actual
?>