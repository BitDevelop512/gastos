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
  $conses = $_GET['conses'];
  $numeros = $_GET['numeros'];
  $periodo = $_GET['periodo'];
  $ano = $_GET['ano'];
  $rechazados = $_GET['rechazados'];
  // Se consulta Oficial GR de Brigada
  $consu = "SELECT unidad, dependencia, especial FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $consu);
  $unidad = odbc_result($cur,1);
  $depen = odbc_result($cur,2);
  $espe = odbc_result($cur,3);
  if ($adm_usuario == "10")
  {
    $consu1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='11'";
  }
  else
  {
    if ($adm_usuario == "11")
    {
      $consu1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$uni_usuario' AND admin='13'";
    }
    else
    {
      $query = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$espe' AND unic='1'";
      $sql = odbc_exec($conexion, $query);
      $v_subdependencia = odbc_result($sql,1);
      $consu1 = "SELECT usuario FROM cx_usu_web WHERE unidad='$v_subdependencia' AND admin='10'";
    }
  }
  $cur1 = odbc_exec($conexion, $consu1);
  $gr = trim(odbc_result($cur1,1));
  // Se consulta unidades por dependencia
  $query0 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$unidad' AND unic='2' ORDER BY dependencia, subdependencia";
  $sql0 = odbc_exec($conexion, $query0);
  $numero = "";
  while($i<$row=odbc_fetch_array($sql0))
  {
    $numero .= "'".odbc_result($sql0,1)."',";
  }
  $numero = substr($numero,0,-1);
  $numero = trim($numero);
  if ($numero == "")
  {
  }
  else
  {
    $numero = $numero.",'$uni_usuario'";
  }
  // Se consulta numero de consolidados
  if ($adm_usuario == "11")
  {
    $estado = "B";
  }
  else
  {
    if ($adm_usuario == "13")
    {
      $estado = "I";
    }
    else
    {
      $estado = "J";
    }
  }
  // Se consultan planes consolidados
  if ($numero == "")
  {
  }
  else
  {
    $query1 = "SELECT conse, consolidado, planes FROM cx_pla_con WHERE unidad IN ($numero) AND estado='$estado' AND periodo='$periodo' AND ano='$ano'";   
    $sql1 = odbc_exec($conexion, $query1);
    $numero1 = "";
    $numero2 = "";
    while($i<$row=odbc_fetch_array($sql1))
    {
      $numero1 .= "'".odbc_result($sql1,1)."',";
      $especial = trim(odbc_result($sql1,2));
      $planes = trim(odbc_result($sql1,3));
      $planex = decrypt1($planes, $llave);
      $numero2 .= $planex.",";
    }
    $numero1 = substr($numero1,0,-1);
    $numero2 = substr($numero2,0,-1);
  }
  // Se consulta plan de inversion de la unidad centralizadora
  $query5 = "SELECT conse FROM cx_pla_inv WHERE unidad='$uni_usuario' AND estado IN ('P','H') AND periodo='$periodo' AND ano='$ano'";
  $sql5 = odbc_exec($conexion, $query5);
  if ($conses == "0")
  {
    $numero2 .= "'".odbc_result($sql5,1)."'";
  }
  else
  {
    $numero2 .= ",'".odbc_result($sql5,1)."'";
  }
  // Se consultan planes consolidados del mes y el año de la unidad
  $query3 = "SELECT conse, estado FROM cx_pla_con WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano'";
  $sql3 = odbc_exec($conexion,$query3);
  $tot_con = odbc_num_rows($sql3);
  $est_con = odbc_result($sql3,2);
  // Se consultan planes consolidados de unidades pendientes o rechazados
  if ($rechazados == "")
  {
  }
  else
  {
    $query4 = "SELECT conse, usuario FROM cx_pla_con WHERE conse IN ($rechazados) AND periodo='$periodo' AND ano='$ano'";
    $sql4 = odbc_exec($conexion,$query4);
    $tot_con1 = odbc_num_rows($sql4);
    if ($tot_con1 > 0)
    {
      $pendientes = "<center><font face='Verdana' size='3'><b>Planes Consolidados Pendientes</b></font></center><br><table width='30%' align='center' border='1'><tr><td width='50%' height='25' bgcolor='#ccc'><font face='Verdana' size='2'><center><b>Consolidado</b></center></font></td><td width='50%' height='25' bgcolor='#ccc'><font face='Verdana' size='2'><center><b>Unidad</b></center></font></td></tr>";
      while($i<$row=odbc_fetch_array($sql4))
      {
        $n_uni = trim(odbc_result($sql4,2));
        $n_uni = explode("_", $n_uni);
        $n_uni1 = $n_uni[1];

        $pendientes .= "<tr><td height='25'><font face='Verdana' size='2'>".odbc_result($sql4,1)."</font></td><td height='25'><font face='Verdana' size='2'>".$n_uni1."</font></td></tr>";
      }
      $pendientes .= "</table><br>";
      echo $pendientes;
    }
  }
?>
<html lang="es">
<head>
  <?php
    include('encabezado.php');
  ?>
  <style>
  .text1
  {
    width: 150px;
    text-align: right;
    padding: 5px;
    border: none;
    border-bottom: 2px solid blue;
    background: transparent;
  }
  .espacio
  {
    padding-top: 3px;
    padding-bottom: 3px;
  }
  </style>
</head>
<body>
<div>
  <br>
  <center>
    <font face="Verdana" size="3">
      <b>Revisi&oacute;n Planes Consolidado Especial</b>
    </font>
  </center>
  <br>
  <form name="formu" method="post">
    <table align="center" width="95%" border="0">
      <tr>
        <td width="40%">
          <font face="Verdana" size="2">
            Estado:
          </font>
        </td>
        <td width="60%">
          <input type="hidden" name="conses" id="conses" class="c2" value="<?php echo $numeros; ?>" readonly="readonly">
          <input type="hidden" name="consos" id="consos" class="c2" value="<?php echo $numero1; ?>" readonly="readonly">
          <input type="hidden" name="consus" id="consus" class="c2" value="<?php echo $numero2; ?>" readonly="readonly">
          <input type="hidden" name="unidad" id="unidad" class="c2" value="<?php echo $uni_usuario ?>" readonly="readonly">
          <input type="hidden" name="gr" id="gr" class="c2" value="<?php echo $gr; ?>" readonly="readonly">
          <input type="hidden" name="ano" id="ano" class="c2" value="<?php echo $ano; ?>" readonly="readonly">
          <input type="hidden" name="tot_con" id="tot_con" class="c2" value="<?php echo $tot_con; ?>" readonly="readonly">
          <input type="hidden" name="est_con" id="est_con" class="c2" value="<?php echo $est_con; ?>" readonly="readonly">
          <input type="hidden" name="admin" id="admin" class="c2" value="<?php echo $adm_usuario; ?>" readonly="readonly">
          <select name="estado" id="estado" class="lista_sencilla2">
            <option value="B">APROBADO</option>
            <option value="Y">RECHAZADO</option>
          </select>
        </td>
      </tr>
    </table>
    <br>
    <table align="center" width="95%" border="0">
      <tr>
        <td>
          <div id="div0">
            <?php
            $query2 = "SELECT conse, compania, unidad, (SELECT unidad FROM cv_unidades WHERE cx_pla_inv.unidad=cv_unidades.subdependencia) AS nun_unidad, (SELECT dependencia FROM cv_unidades WHERE cx_pla_inv.unidad=cv_unidades.subdependencia) AS nun_dependencia, estado FROM cx_pla_inv WHERE conse in ($numero2) AND periodo='$periodo' AND ano='$ano' AND tipo='1' AND estado NOT IN ('','X','Y') ORDER BY nun_dependencia, unidad";
            //echo $query2."<br>";

            $sql2 = odbc_exec($conexion,$query2);
            $j = 1;
            while($j<$row=odbc_fetch_array($sql2))
            {
              $conse = odbc_result($sql2,1);
              $compa = odbc_result($sql2,2);
              $unid = odbc_result($sql2,3);
              $estam = odbc_result($sql2,6);
              $consu_compa = "SELECT nombre FROM cx_org_cmp WHERE conse='$compa'";
              $cur_compa = odbc_exec($conexion,$consu_compa);
              $n_compania = trim(utf8_encode(odbc_result($cur_compa,1)));
              $consu_unid = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unid'";
              $cur_unid = odbc_exec($conexion,$consu_unid);
              $n_unid = trim(utf8_encode(odbc_result($cur_unid,1)));
              echo "<font face='Verdana' size='2'>".$n_unid." - ".$n_compania."</font><br>";
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
                echo "<div class='espacio'></div><font face='Verdana' size='2'>".$var1."<br>Valor:&nbsp;&nbsp;&nbsp;$valora1</font><input type='hidden' name='caa_".$j."_".$i."' id='caa_".$j."_".$i."' class='c7' value='".$con_mis."' readonly='readonly'><input type='hidden' name='vaa_".$j."_".$i."' id='vaa_".$j."_".$i."' class='c7' value='".$valora1."' readonly='readonly'><input type='hidden' name='vua_".$j."_".$i."' id='vua_".$j."_".$i."' class='c7' value='".$unid."' readonly='readonly'><input type='hidden' name='esm_".$j."_".$i."' id='esm_".$j."_".$i."' class='c7' value='".$estam."' readonly='readonly'><br><br>";
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
                echo "<font face='Verdana' size='2'>".$var2."<br>Valor:&nbsp;&nbsp;&nbsp;$valora2</font><input type='hidden' name='cab_".$j."_".$k."' id='cab_".$j."_".$k."' class='c7' value='".$con_fue."' readonly='readonly'><input type='hidden' name='vab_".$j."_".$k."' id='vab_".$j."_".$k."' class='c7' value='".$valora2."' readonly='readonly'><input type='hidden' name='xab_".$j."_".$k."' id='xab_".$j."_".$k."' class='c7' value='".$k."' readonly='readonly'><input type='hidden' name='vub_".$j."_".$k."' id='vub_".$j."_".$k."' class='c7' value='".$unid."' readonly='readonly'><input type='hidden' name='eso_".$j."_".$k."' id='eso_".$j."_".$k."' class='c7' value='".$estam."' readonly='readonly'><br><br>";
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
            $query2 = "SELECT conse, compania, unidad, (SELECT unidad FROM cv_unidades WHERE cx_pla_inv.unidad=cv_unidades.subdependencia) AS nun_unidad, (SELECT dependencia FROM cv_unidades WHERE cx_pla_inv.unidad=cv_unidades.subdependencia) AS nun_dependencia, estado FROM cx_pla_inv WHERE conse in ($numeros) AND periodo='$periodo' AND ano='$ano' AND tipo='1' AND estado NOT IN ('','X','Y') ORDER BY nun_dependencia, unidad";
            $sql2 = odbc_exec($conexion,$query2);
            $j = 1;
            while($j<$row=odbc_fetch_array($sql2))
            {
              $conse = odbc_result($sql2,1);
              $compa = odbc_result($sql2,2);
              $unid = odbc_result($sql2,3);
              $estam = odbc_result($sql2,6);
              $consu_compa = "SELECT nombre FROM cx_org_cmp WHERE conse='$compa'";
              $cur_compa = odbc_exec($conexion,$consu_compa);
              $n_compania = trim(utf8_encode(odbc_result($cur_compa,1)));
              $consu_unid = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unid'";
              $cur_unid = odbc_exec($conexion,$consu_unid);
              $n_unid = trim(utf8_encode(odbc_result($cur_unid,1)));
              echo "<font face='Verdana' size='2'>".$n_unid." - ".$n_compania."</font><br>";
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
                echo "<div class='espacio'></div><font face='Verdana' size='2'>".$var1."<div class='espacio'></div>Valor:&nbsp;&nbsp;&nbsp;</font><input type='hidden' name='cam_".$j."_".$i."' id='cam_".$j."_".$i."' class='c7' value='".$con_mis."'><input type='text' name='vam_".$j."_".$i."' id='vam_".$j."_".$i."' class='text1' value='".$valorm1."' onkeyup='paso_val(".$j.",".$i.")' onchange='paso_com(".$j.",".$i.")'><input type='hidden' name='vap_".$j."_".$i."' id='vap_".$j."_".$i."' class='c7' value='".$valorm."' readonly='readonly'><input type='hidden' name='vas_".$j."_".$i."' id='vas_".$j."_".$i."' value='0' readonly='readonly'><input type='hidden' name='vum_".$j."_".$i."' id='vum_".$j."_".$i."' class='c7' value='".$unid."' readonly='readonly'><input type='hidden' name='esn_".$j."_".$i."' id='esn_".$j."_".$i."' class='c7' value='".$estam."' readonly='readonly'><br><br><script>$('#vam_".$j."_".$i."').maskMoney();</script>";
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
                 echo "<font face='Verdana' size='2'>".$var2."<br>Valor:&nbsp;&nbsp;&nbsp;</font><input type='hidden' name='caf_".$j."_".$k."' id='caf_".$j."_".$k."' class='c7' value='".$con_fue."'><input type='text' name='vaf_".$j."_".$k."' id='vaf_".$j."_".$k."' class='text1' value='".$valorn1."' onkeyup='paso_val1(".$j.",".$k.")' onchange='paso_com1(".$j.",".$k.")'><input type='hidden' name='vaq_".$j."_".$k."' id='vaq_".$j."_".$k."' class='c7' value='".$valorn."' readonly='readonly'><input type='hidden' name='vat_".$j."_".$k."' id='vat_".$j."_".$k."' class='c7' value='0' readonly='readonly'><input type='hidden' name='xaf_".$j."_".$k."' id='xaf_".$j."_".$k."' class='c7' value='".$k."' readonly='readonly'><input type='hidden' name='vuf_".$j."_".$k."' id='vuf_".$j."_".$k."' class='c7' value='".$unid."' readonly='readonly'><input type='hidden' name='esp_".$j."_".$k."' id='esp_".$j."_".$k."' class='c7' value='".$estam."' readonly='readonly'><br><br><script>$('#vaf_".$j."_".$k."').maskMoney();</script>";
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
          	<font face="Verdana" size="2">
          		Observaciones
          	</font>
            <center>
              <textarea name="motivo" id="motivo" rows="5"></textarea>
            </center>
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
            <input type="hidden" name="v_val6" id="v_val6" readonly="readonly">
            <input type="hidden" name="v_val7" id="v_val7" readonly="readonly">
            <input type="hidden" name="v_val8" id="v_val8" readonly="readonly">
            <input type="hidden" name="v_val9" id="v_val9" readonly="readonly">
            <br>
            <input type="button" name="aceptar" id="aceptar" value="Aceptar">
          </center>
        </td>
      </tr>
    </table>
  </form>
</div>
<div id="dialogo"></div>
<div id="load">
  <center>
    <img src="imagenes/cargando.gif" alt="Cargando..." />
  </center>
</div>
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
    width: 330,
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
    buttons: [
      {
        text: "Ok",
        click: function() {
          $(this).dialog("close");
        }
      }
    ]
  });
  $("#estado").change(valida_div);
  $("#aceptar").button();
  $("#aceptar").click(valida);
  $("#div1").hide();
  $("#div3").hide();
  $("#motivo").css('width',300);
  valida_consoli();
});
function valida_consoli()
{
  var valida, valida1, detalle, admin;
  valida = $("#tot_con").val();
  valida = parseInt(valida);
  valida1 = $("#est_con").val();
  admin = $("#admin").val();
  if (admin == "10")
  {
    if (valida > 0)
    {
      $("#aceptar").hide();
      detalle = "<center><h3>Consolidado del Mes ya generado</h3></center>";
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
    }
    else
    {
      $("#aceptar").show();
    }
  }
  if (admin == "11")
  {
    if (valida1 == "I")
    {
      $("#aceptar").hide();
      detalle = "<center><h3>Consolidado del Mes ya generado</h3></center>";
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
    }
    else
    {
      if (valida == "0")
      {
        $("#aceptar").hide();
        detalle = "<center><h3>Consolidado del Mes NO generado</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
      }
      else
      {
        $("#aceptar").show();
      }
    }
  }
  if (admin == "13")
  {
    if (valida1 == "J")
    {
      $("#aceptar").hide();
      detalle = "<br><br><center>Consolidado del Mes ya generado</center>";
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
    }
    else
    {
      if (valida == "0")
      {
        $("#aceptar").hide();
        detalle = "<br><br><center>Consolidado del Mes no generado</center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
      }
      else
      {
        $("#aceptar").show();
      }
    }
  }
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
  var valida = $("#estado").val();
  if (valida == "Y")
  {
    document.getElementById('v_val1').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vam_')!=-1)
      {
        valor = document.getElementById(saux).value;
        if (valor == "")
        {
          valor = "0.00";
          $("#"+saux).css('border-bottom', '2px solid red');         
        }
        document.getElementById('v_val1').value = document.getElementById('v_val1').value+valor+"|";
      }
    }
    document.getElementById('v_val2').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vaf_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val2').value = document.getElementById('v_val2').value+valor+"|";
      }
    }
    document.getElementById('v_val3').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('cam_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val3').value = document.getElementById('v_val3').value+valor+"|";
      }
    }
    document.getElementById('v_val4').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('caf_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val4').value = document.getElementById('v_val4').value+valor+"|";
      }
    }
    document.getElementById('v_val5').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('xaf_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val5').value = document.getElementById('v_val5').value+valor+"|";
      }
    }
    document.getElementById('v_val6').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vum_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val6').value = document.getElementById('v_val6').value+valor+"|";
      }
    }
    document.getElementById('v_val7').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vuf_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val7').value = document.getElementById('v_val7').value+valor+"|";
      }
    }
  }
  if ((valida == "A") || (valida == "B"))
  {
    document.getElementById('v_val1').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vaa_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val1').value = document.getElementById('v_val1').value+valor+"|";
      }
    }
    document.getElementById('v_val2').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vab_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val2').value = document.getElementById('v_val2').value+valor+"|";
      }
    }
    document.getElementById('v_val3').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('caa_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val3').value = document.getElementById('v_val3').value+valor+"|";
      }
    }
    document.getElementById('v_val4').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('cab_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val4').value = document.getElementById('v_val4').value+valor+"|";
      }
    }
    document.getElementById('v_val5').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('xab_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val5').value = document.getElementById('v_val5').value+valor+"|";
      }
    }
    document.getElementById('v_val6').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vua_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val6').value = document.getElementById('v_val6').value+valor+"|";
      }
    }
    document.getElementById('v_val7').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vub_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_val7').value = document.getElementById('v_val7').value+valor+"|";
      }
    }
    document.getElementById('v_val8').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('esm_')!=-1)
      {
        valor = document.getElementById(saux).value;
        if (valor == "P")
        {
          saux0 = saux.split('_');
          saux1 = "caa_"+saux0[1]+"_"+saux0[2];
          saux2 = "vaa_"+saux0[1]+"_"+saux0[2];
          saux3 = "vua_"+saux0[1]+"_"+saux0[2];
          valor1 = $("#"+saux1).val();
          valor2 = $("#"+saux2).val();
          valor3 = $("#"+saux3).val();
          valor4 = valor1+"»"+valor2+"»"+valor3;
          document.getElementById('v_val8').value = document.getElementById('v_val8').value+valor4+"|";
        }
      }
    }
    document.getElementById('v_val9').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('eso_')!=-1)
      {
        valor = document.getElementById(saux).value;
        if (valor == "P")
        {
          saux0 = saux.split('_');
          saux1 = "cab_"+saux0[1]+"_"+saux0[2];
          saux2 = "vab_"+saux0[1]+"_"+saux0[2];
          saux3 = "vub_"+saux0[1]+"_"+saux0[2];
          valor1 = $("#"+saux1).val();
          valor2 = $("#"+saux2).val();
          valor3 = $("#"+saux3).val();
          valor4 = valor1+"»"+valor2+"»"+valor3;
          document.getElementById('v_val9').value = document.getElementById('v_val9').value+valor4+"|";
        }
      }
    }
  }
  graba();
}
function graba()
{
  var salida = true, detalle = '';
  valida = $("#estado").val();
  $("#motivo").removeClass("ui-state-error");
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
      $("#motivo").addClass("ui-state-error");
    }
  }
  var oficial = $("#gr").val();  
  oficial = oficial.trim();
  if (oficial == '')
  {
    salida = false;
    detalle += "<br><br><center>Usuario a Notificar No Encontrado</center><br><center>Favor Revisar Parametrización</center>";
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
    var conses = $("#conses").val();
    var consos = $("#consos").val();
    var unidad = $("#unidad").val();
    var estado = $("#estado").val();
    var ano = $("#ano").val();
    var valores1 = $("#v_val1").val();
    var valores2 = $("#v_val2").val();
    var valores3 = $("#v_val3").val();
    var valores4 = $("#v_val4").val();
    var valores5 = $("#v_val5").val();
    var valores6 = $("#v_val6").val();
    var valores7 = $("#v_val7").val();
    var valores8 = $("#v_val8").val();
    var valores9 = $("#v_val9").val();
    var motivo = $("#motivo").val();
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "apli_actu4.php",
      data:
      {
        oficial: oficial,
        conses: conses,
        consos: consos,
        unidad: unidad,
        estado: estado,
        ano: ano,
        valores1: valores1,
        valores2: valores2,
        valores3: valores3,
        valores4: valores4,
        valores5: valores5,
        valores6: valores6,
        valores7: valores7,
        valores8: valores8,
        valores9: valores9,
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
            saux=document.formu.elements[i].name;
          	if (saux.indexOf('vam_')!=-1)
        		{
          		document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
  	      for (i=0;i<document.formu.elements.length;i++)
        	{
          	saux=document.formu.elements[i].name;
          	if (saux.indexOf('vaf_')!=-1)
        		{
          		document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
          detalle = "<br><h3><center>Notificaci&oacute;n Enviada a: "+notifica+"</center></h3>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
        }
        else
        {
          detalle = "<br><center>Error durante la grabación</center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
          $("#aceptar").show();
        }
      }
    });
  }
}
</script>
</body>
</html>
<?php
}
?>