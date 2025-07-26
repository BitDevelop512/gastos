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
	include('permisos.php');
	$conse = $_GET['conse'];
  $ano = $_GET['ano'];
  $query = "SELECT unidad, periodo, ano, tipo, estado, usuario, recursos, actual, especial FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano' AND unidad!='999' ORDER BY conse, ano";
  $sql = odbc_exec($conexion,$query);
	$total = odbc_num_rows($sql);
  $n_unidad = odbc_result($sql,1);
	$periodo = odbc_result($sql,2);
  $ano = odbc_result($sql,3);
	$tipo = odbc_result($sql,4);
  $estado1 = odbc_result($sql,5);
	$usu_crea = trim(odbc_result($sql,6));
  $recursos = odbc_result($sql,7);
  $actual = odbc_result($sql,8);
  $especial = odbc_result($sql,9);
	if ($tipo == "1")
  {
   	if ($adm_usuario == "3")
   	{
   		$query1 = "SELECT conse, usuario1 FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano'";
   		$sql1 = odbc_exec($conexion,$query1);
   		$val_usuario = trim(odbc_result($sql1,2));
   		if ($val_usuario == "")
   		{
     		$val1_usuario = "0";
   		}
   		else
   		{
     		$val1_usuario = "1";
   		}
  	}
  }
	if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
	{
	}
	else
	{
		$val1_usuario = "1";
	}
  if ($especial == "1")
  {
    $query2 = "SELECT especial FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
    $sql2 = odbc_exec($conexion,$query2);
    $especial1 = odbc_result($sql2,1);
  }
  else
  {
    $especial1 = "0";
  }
  $query3 = "SELECT firma FROM cx_usu_web WHERE usuario='$usu_usuario'";
  $sql3 = odbc_exec($conexion,$query3);
  $firma = trim(odbc_result($sql3,1));
  if ($firma == "")
  {
    $firma1 = 0;
  }
  else
  {
    $firma1 = 1;
  }
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
      <b>Revisi&oacute;n Plan / Solicitud</b>
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
              <input type="hidden" name="conse" id="conse" class="form-control" value="<?php echo $conse; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="unidad" id="unidad" class="form-control" value="<?php echo $n_unidad; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="tipo" id="tipo" class="form-control" value="<?php echo $tipo; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="admin" id="admin" class="form-control" value="<?php echo $adm_usuario; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="nunidad" id="nunidad" class="form-control" value="<?php echo $nun_usuario; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="actual" id="actual" class="form-control" value="<?php echo $actual; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="usu_crea" id="usu_crea" class="form-control" value="<?php echo $usu_crea; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="t_unidad" id="t_unidad" class="form-control" value="<?php echo $tpu_usuario; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="t_unidad1" id="t_unidad1" class="form-control" value="<?php echo $tpc_usuario; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="t_persona" id="t_persona" class="form-control" value="" readonly="readonly" tabindex="0">
              <input type="hidden" name="recursos" id="recursos" class="form-control" value="<?php echo $recursos; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="especial" id="especial" class="form-control" value="<?php echo $especial; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="especial1" id="especial1" class="form-control" value="<?php echo $especial1; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $val1_usuario; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="v_usuario1" id="v_usuario1" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="v_estado" id="v_estado" class="form-control" value="<?php echo $estado1; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="v_especial" id="v_especial" class="form-control" value="0" readonly="readonly" tabindex="0">
              <input type="hidden" name="v_firma" id="v_firma" class="form-control" value="<?php echo $firma; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="v_firma1" id="v_firma1" class="form-control" value="<?php echo $firma1; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="correo" id="correo" class="form-control" value="<?php echo $ema_usuario; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="servidor" id="servidor" class="form-control" value="" readonly="readonly" tabindex="0">
              <select name="estado" id="estado" class="form-control select2">
                <?php
                if ($tipo == "2")
                {
                  if (($estado1 == "P") or ($estado1 == "Q"))
                  {
                ?>
                    <option value="A">APROBADO</option>
                <?php
                  }
                  else
                  {
                    if (($estado1 == "B") or ($estado1 == "O") or ($estado1 == "R") or ($estado1 == "S"))
                    {
                      if ($adm_usuario == "10")
                      {
                        if (($especial == "1") and ($especial1 == "0"))
                        { 
                ?>
                          <option value="F">APROBADO</option>
                <?php
                        }
                        else
                        {
                          if (($especial == "0") and ($especial1 == "0"))
                          { 
                ?>
                            <option value="F">APROBADO</option>
                <?php
                          }
                          else
                          {
                ?>
                            <option value="C">APROBADO</option>
                <?php
                          }
                        }
                      }
                      else
                      {
                ?>
                      <option value="C">APROBADO</option>
                <?php
                      }
                    }
                    else
                    {
                ?>
                      <option value="B">APROBADO</option>
                <?php
                    }
                  } 
                }
                else
                {
                  if ($adm_usuario == "7")
                  {
                ?>
                    <option value="D">APROBADO</option>
                <?php
                  }
                  else
                  {
                ?>
                    <option value="A">APROBADO</option>
                <?php
                  }
                }
                ?>
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
            // Gastos
            $consulta = "SELECT * FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano' ORDER BY interno";
            $cur = odbc_exec($conexion,$consulta);
            $i = 1;
            while($i<$row=odbc_fetch_array($cur))
            {
              $con_mis = odbc_result($cur,1);
              $int_mis = odbc_result($cur,3);
              $mision = trim(odbc_result($cur,5));
              $valora1 = trim(odbc_result($cur,14));
              if (trim($valora1 == "0.00"))
              {
                $valora1 = trim(odbc_result($cur,13));
              }
              $var1 = "Misión: ".$mision;
              $var2 = trim(odbc_result($cur,7))." - ".trim(odbc_result($cur,8));
              echo "<div class='row'><div class='col col-lg-2 col-sm-2 col-md-4 col-xs-4'><label><font face='Verdana' size='2'>Misión:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><font face='Verdana' size='2'>".utf8_encode($mision)."</font></div></div><br><div class='row'><div class='col col-lg-2 col-sm-2 col-md-4 col-xs-4'><label><font face='Verdana' size='2'>Valor:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><font face='Verdana' size='2'>".$valora1."</font><input type='hidden' name='caa_".$i."' id='caa_".$i."' class='c7' value='".$con_mis."' readonly='readonly'><input type='hidden' name='vaa_".$i."' id='vaa_".$i."' class='c7' value='".$valora1."' readonly='readonly'></div></div><br><div class='row'><div class='col col-lg-2 col-sm-2 col-md-4 col-xs-4'><label><font face='Verdana' size='2'>Lapso Misión:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><font face='Verdana' size='2'>".$var2."</font></div></div><br>";
              // Bienes - Combustibles - Grasas - RTM - Llantas
              $consulta2 = "SELECT bienes, gasto FROM cx_pla_gad WHERE conse1='$conse' AND ano='$ano' AND interno='$int_mis'";
              $cur2 = odbc_exec($conexion,$consulta2);
              $j = 1;
              $det_bienes = "";
              while($j<$row=odbc_fetch_array($cur2))
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
                        $val_bie17 = explode("&", $val_bie1[15]);
                        $val_bie18 = explode("&", $val_bie1[16]);
                        for ($k=0;$k<count($val_bie4)-1;++$k)
                        {
                          $consulta4 = "SELECT nombre FROM cx_ctr_rep WHERE codigo='$val_bie10[$k]'";
                          $cur4 = odbc_exec($conexion,$consulta4);
                          $nom_rep = trim(utf8_encode(odbc_result($cur4,1)));
                          $val_rep = floatval($val_bie8[$k])+floatval($val_bie15[$k]);
                          $val_rep = number_format($val_rep, 2);
                          $det_bienes .= $val_bie2[$k]. " - ".$val_bie3[$k]. " - ".$nom_rep." - $ ".$val_rep."<br>";
                        }
                        $v_iva = number_format($val_bie18[0], 2);
                        $det_bienes .= "IVA - $ ".$v_iva."<br>";
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
                          $det_bienes .= $val_bie2[$k]. " - ".$val_bie3[$k]. " - ".$val_bie9[$k]." - $ ".$val_rep."<br>";
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
                $j++;
              }
              echo "<hr>";
              $i++;
            }
            // Pagos
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
              if ($adm_usuario >= 9)
              {
                if ($adm_usuario == "27") // or ($adm_usuario == "23"))
                {
                  $valora2 = trim(odbc_result($cur1,17));
                }
                else
                {
                  $valora2 = trim(odbc_result($cur1,18));
                }
              }
              else
              {
                $valora2 = trim(odbc_result($cur1,17));
              }
              $var2 = "Fuente: ".$cedula;
              echo "<div class='row'><div class='col col-lg-12 col-sm-12 col-md-12 col-xs-12'><font face='Verdana' size='2'>Fuente:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><font face='Verdana' size='2'>".$cedula."</font></div></div><br><div class='row'><div class='col col-lg-2 col-sm-2 col-md-2 col-xs-2'><label><font face='Verdana' size='2'>Valor:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><font face='Verdana' size='2'>".$valora2."</font><input type='hidden' name='cab_".$k."' id='cab_".$k."' class='c7' value='".$con_fue."' readonly='readonly'><input type='hidden' name='vab_".$k."' id='vab_".$k."' class='c7' value='".$valora2."' readonly='readonly'></div></div><br>";
              $k++;
            }
            ?>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div id="div1">
            <?php
            $consulta = "SELECT * FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano' ORDER BY interno";
            $cur = odbc_exec($conexion,$consulta);
            $i = 1;
            while($i<$row=odbc_fetch_array($cur))
            {
              $con_mis = odbc_result($cur,1);
              $mision = trim(odbc_result($cur,5));
              $valorm1 = trim(odbc_result($cur,14));
              if (trim($valorm1 == "0.00"))
              {
                $valorm1 = trim(odbc_result($cur,13));
              }
              $valorm = $valorm1;
              $valorm = str_replace(',','',$valorm);
              $valorm = intval($valorm);
              $var1 = "Misión: ".$mision;
              $var2 = trim(odbc_result($cur,7))." - ".trim(odbc_result($cur,8));
              echo "<div class='row'><div class='col col-lg-2 col-sm-2 col-md-4 col-xs-4'><label><font face='Verdana' size='2'>Misión:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><font face='Verdana' size='2'>".utf8_encode($mision)."</font></div></div><br><div class='row'><div class='col col-lg-2 col-sm-2 col-md-4 col-xs-4'><label><font face='Verdana' size='2'>Valor:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><input type='hidden' name='cam_".$i."' id='cam_".$i."' class='form-control numero' value='".$con_mis."'><input type='text' name='vam_".$i."' id='vam_".$i."' class='form-control numero' value='".$valorm1."' onkeyup='paso_val(".$i.")' onchange='paso_com(".$i.")'><input type='hidden' name='vap_".$i."' id='vap_".$i."' class='form-control numero' value='".$valorm."' readonly='readonly'><input type='hidden' name='vas_".$i."' id='vas_".$i."' class='form-control numero' value='0' readonly='readonly'></div></div><br><div class='row'><div class='col col-lg-2 col-sm-2 col-md-4 col-xs-4'><label><font face='Verdana' size='2'>Lapso Misión:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><font face='Verdana' size='2'>".$var2."</font></div></div><br><script>$('#vam_".$i."').maskMoney();</script>";
              // Bienes - Combustibles - Grasas - RTM - Llantas
              $consulta2 = "SELECT bienes, gasto FROM cx_pla_gad WHERE conse1='$conse' AND ano='$ano' AND interno='$int_mis'";
              $cur2 = odbc_exec($conexion,$consulta2);
              $j = 1;
              $det_bienes = "";
              while($j<$row=odbc_fetch_array($cur2))
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
                          $det_bienes .= $val_bie2[$k]. " - ".$val_bie3[$k]. " - ".$val_bie9[$k]." - $ ".$val_rep."<br>";
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
                $j++;
              }
              $i++;
            }
            ?>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div id="div2">
            <?php
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
              if ($adm_usuario >= 9)
              {
                $valorn1 = trim(odbc_result($cur1,18));
                $valorn = trim(odbc_result($cur1,18));
              }
              else
              {
                $valorn1 = trim(odbc_result($cur1,17));
                $valorn = trim(odbc_result($cur1,17));
              }
              $valorn = str_replace(',','',$valorn);
              $valorn = intval($valorn);
              $var2 = "Fuente: ".$cedula;
              echo "<div class='row'><div class='col col-lg-12 col-sm-12 col-md-12 col-xs-12'><font face='Verdana' size='2'>Fuente:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><font face='Verdana' size='2'>".$cedula."</font></div></div><br><div class='row'><div class='col col-lg-2 col-sm-2 col-md-2 col-xs-2'><label><font face='Verdana' size='2'>Valor:</font></label></div><div class='col col-lg-3 col-sm-3 col-md-6 col-xs-6'><input type='hidden' name='caf_".$k."' id='caf_".$k."' class='form-control numero' value='".$con_fue."'><input type='text' name='vaf_".$k."' id='vaf_".$k."' class='form-control numero' value='".$valorn1."' onkeyup='paso_val1(".$k.")' onchange='paso_com1(".$k.")'><input type='hidden' name='vaq_".$k."' id='vaq_".$k."' class='form-control numero' value='".$valorn."' readonly='readonly'><input type='hidden' name='vat_".$k."' id='vat_".$k."' class='form-control numero' value='0' readonly='readonly'></div></div><br><script>$('#vaf_".$k."').maskMoney();</script>";
              $k++;
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
          <div id="div4">
            <div id="resultados"></div>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <center>
            <input type="hidden" name="v_val1" id="v_val1" class="form-control numero" readonly="readonly">
            <input type="hidden" name="v_val2" id="v_val2" class="form-control numero" readonly="readonly">
            <input type="hidden" name="v_val3" id="v_val3" class="form-control numero" readonly="readonly">
            <input type="hidden" name="v_val4" id="v_val4" class="form-control numero" readonly="readonly">
            <input type="hidden" name="v_val5" id="v_val5" class="form-control numero" readonly="readonly">
            <br>
            <input type="button" name="aceptar" id="aceptar" value="Aceptar">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="anexos" id="anexos" value="Ver Anexos">
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
      <tr>
        <td>
          <div id="div5">
            <br>
            <label><font face="Verdana" size="2">Firma Solicitante / Responsable Misi&oacute;n:</font></label>
            <input type="text" name="responsable" id="responsable" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
          </div>
        </td>
      </tr>
    </table>
  </form>
</div>
<div id="dialogo"></div>
<div id="dialogo1"></div>
<div id="dialogo2">
  <form name="formu6">
    <table width="98%" align="center" border="0">
      <tr>
        <td>
          <div class="row">
            <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"></div>
            <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
              <center>
                <input type="text" name="lbl_firma" id="lbl_firma"  class="form-control fecha" value="FIRMA REGISTRADA" readonly="readonly">
              </center>
            </div>
            <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"></div>
          </div>
          <div class="row">
            <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"></div>
            <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
              <div id="firma"></div>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="row">
            <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
              <br>
              <center>
                <input type="button" name="aceptar2" id="aceptar2" onclick="firmar(1);" value="Confirmar">
                &nbsp;&nbsp;&nbsp;
                <input type="button" name="aceptar3" id="aceptar3" onclick="firmar(2);" value="Rechazar">
              </center>
            </div>
          </div>
        </td>
      </tr>
    </table>
  </form>
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
    height: 230,
    width: 350,
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
  $("#dialogo1").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 230,
    width: 400,
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
      "Si": function() {
        $(this).dialog("close");
        envio2();
      },
      "No": function() {
        $(this).dialog("close");
        envio1();
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 400,
    width: 600,
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
    }
  });
  $("#estado").change(valida_div);
  $("#aceptar").button();
  $("#aceptar").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").button();
  $("#aceptar3").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#anexos").button();
  $("#anexos").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").click(valida);
  $("#aceptar1").click(volver);
  $("#anexos").click(ver_anexo);
  $("#div1").hide();
  $("#div2").hide();
  $("#div3").hide();
  $("#div4").hide();
  $("#div5").hide();
  var val_tip = $("#tipo").val();
  if (val_tip == "2")
  {
    $("#div4").show();
    trae_personas();
  }
  if (val_tip == "1")
  {
    valida_boton();
  }
  var val_est = $("#v_estado").val();
  var val_usu = $("#v_usuario1").val();
  if ((val_tip == "2") && (val_est == "P"))
  {
    $("#div5").show();
  }
  else
  {
    $("#div5").hide();
  }
  valida_div();
  var val_fir = $("#v_firma1").val();
  if (val_fir == "1")
  {
    trae_firma();
  }
  $("#motivo").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  var servidor = location.host;
  $("#servidor").val(servidor);
});
function ver_anexo()
{
  var valor, valor1;
  valor = $("#conse").val();
  valor1 = $("#ano").val();
  var url = "./archivos/index1.php?ano="+valor1+"&conse="+valor;
  var ventana = window.open(url,'','height=480,width=800');
}
function valida_boton()
{
  var valida;
  valida = $("#v_usuario").val();
  if (valida == "1")
  {
    $("#aceptar").show();
  }
  else
  {
    $("#aceptar").hide();
  }  
}
function valida_div()
{
  var valida = $("#estado").val();
  var valida1 = $("#v_estado").val();
  var val_tip = $("#tipo").val();
  var admin = $("#admin").val(); 
  var nunidad = $("#nunidad").val();
  var actual = $("#actual").val();
  var opd = $("#v_usuario1").val();
  opd = opd.trim();
  if ((valida == "A") || (valida == "B") || (valida == "C") || (valida == "D"))
  {   
    if ((opd == "OPD_DIADI") && (valida == "B"))
    {
      $("#div0").hide();
      $("#div1").show();
      $("#div2").show();
      $("#div3").show();
    }
    else
    {
      $("#div0").show();
      $("#div1").hide();
      $("#div2").hide();
      $("#div3").hide();
      if (val_tip == "2")
      {
        if ((nunidad >= 3) && (admin == "8"))
        {
          $("#div0").hide();
          if (actual == "1")
          {
            $("#div1").show();
            $("#v_especial").val('1');
          }
          else
          {
            $("#div2").show();
            $("#v_especial").val('1');
          }
          $("#div3").show();
        }
        else
        {
          if (((valida1 == "A") || (valida1 == "C") || (valida1 == "D") || (valida1 == "I") || (valida1 == "J") || (valida1 == "K")) && ((admin == "8") || (admin == "12")))
          {
            $("#div0").hide();
            if (actual == "2")
            {
              $("#div1").hide();
              $("#div2").show();
            }
            else
            {
              $("#div1").show();
              $("#div2").hide();
            }
            if ((nunidad >= 4) && (nunidad <= 17))
            {
              $("#div3").hide();
            }
            else
            {
              $("#div3").show(); 
            }
          }
          else
          {
            $("#div0").show();
            $("#div1").hide();
            $("#div2").hide();
          }
        }
        $("#div4").show();
      }      
    }
  }
  else
  {
    $("#div0").hide();
    $("#div1").show();
    $("#div2").show();
    $("#div3").show(); 
    if (val_tip == "2")
    {
      if (valida == "F")
      {
        $("#div3").show();
        $("#div4").show();
      }
      else
      {
        $("#div4").hide();
      }
    }
  }
  var val_est = $("#v_estado").val();
  if ((val_tip == "2") && (val_est == "P"))
  {
    $("#div5").show();
  }
  else
  {
    $("#div5").hide();
  }
}
function paso_val(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('vam_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vas_"+valor).val(valor1);
}
function paso_val1(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('vaf_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vat_"+valor).val(valor1);
}
function paso_com(valor)
{
  var valor;
  var valor1 = $("#vas_"+valor).val();
  var valor2 = $("#vap_"+valor).val();
  var valor3 = (valor1-valor2);
  if (valor3 > 0)
  {
    var detalle = "<br><center>Valor Superior al Solicitado</center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
    $("#vam_"+valor).val('0.00');
    paso_val(valor);
  }  
}
function paso_com1(valor)
{
  var valor;
  var valor1 = $("#vat_"+valor).val();
  var valor2 = $("#vaq_"+valor).val();
  var valor3 = (valor1-valor2);
  if (valor3 > 0)
  {
    var detalle = "<br><center>Valor Superior al Solicitado</center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
    $("#vaf_"+valor).val('0.00');
    paso_val1(valor);
  }  
}
function valida()
{
  var especial = $("#v_especial").val();
  var valida = $("#estado").val();
  var valida1 = $("#v_estado").val();
  var admin = $("#admin").val(); 
  var opd = $("#v_usuario1").val();
  var salida = true;
  opd = opd.trim(); 
  if ((valida == "A") || (valida == "B") || (valida == "C") || (valida == "D"))
  {
    if ((opd == "OPD_DIADI") && (valida == "B"))
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
    }
    else
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
    }
    document.getElementById('v_val2').value="";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vab_')!=-1)
      {
        valor = document.getElementById(saux).value;
        if (valor == "0.00")
        {
          salida = false;
        }
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
  }
  if (((valida == "Y") || (valida == "F") || (especial == "1") || (valida1 == "A") || (valida1 == "B") || (valida1 == "C") || (valida1 == "D") || (valida1 == "I") || (valida1 == "J")) && ((admin == "8") || (admin == "10") || (admin == "12")))
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
  }
  if (salida == false)
  {
    var detalle = "<h3><center>Valor Aprobado<br>No Permitido</center></h3>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
  }
  else
  {
    // Se retira funcion verificar();
    graba();
  }
}
function verificar()
{
  var valida = $("#v_firma1").val();
  if (valida == "1")
  {
    $("#dialogo2").dialog("open");
    $("#dialogo2").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
  }
  else
  {
    graba();
  }
}
function graba()
{
  var salida = true, detalle = '';
  var detalle1;
  var admin = $("#admin").val();
  var valida = $("#estado").val();
  var valida1 = $("#v_estado").val();
  if ((valida == "Y") || (valida == "F"))
  {
    var suma1 = 0;
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vam_')!=-1)
      {
        valor = document.getElementById(saux).value;
        if ((valor == "0.00") || (valor == ""))
        {
          if (valida == "F")
          {
            suma1 ++;
          }
        }
      }
    }    
    if (suma1 > 0)
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar "+suma1+" Valor(es) de Misión</h3></center>";
    }
    var suma2 = 0;
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('vaf_')!=-1)
      {
        valor = document.getElementById(saux).value;
        if ((valor == "0.00") || (valor == ""))
        {
          if (valida == "F")
          {
            suma2 ++;
          }
        }
      }
    }
    if (suma2 > 0)
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar "+suma2+" Valor(es) de Fuente</h3></center>";      
    }
    if (valida == "F")
    {
    }
    else
    {
      var v_motivo = $("#motivo").val();
      v_motivo = v_motivo.trim().length;
      if (v_motivo == "0")
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar una Observación</h3></center>";
      }
    }
  }
  if ((admin == "12") && (valida == "B"))
  {
    if ((valida1 == "A") || (valida1 == "C") || (valida1 == "M") || (valida1 == "U"))
    {
    }
    else
    {
      var v_motivo = $("#motivo").val();
      v_motivo = v_motivo.trim().length;
      if (v_motivo == "0")
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar una Observación</h3></center>";
      }
    }
  }
  var seleccionadosarray = [];
  $("input[name='seleccionados[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        seleccionadosarray.push($(this).val());
      }
    }
  );
  var num_sel = seleccionadosarray.length;
  if ($("#tipo").val() == '2')
  {
    if (valida == "Y")
    {
    }
    else
    {
      if (num_sel == "0")
      {
        salida = false;
        detalle += "<center><h3>Debe seleccionar un Usuario</h3></center>";
      }
    }
    if (valida == "Y")
    {
    }
    else
    {
      if ($("#v_estado").val() == 'P')
      {
        var val_res = $("#responsable").val().trim().length;
        if (val_res == '0')
        {
          salida = false;
          detalle += "<center><h3>Debe ingresar el Responsable</h3></center>";
        }
      }
    }
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
  }
  else
  {
    var especial1 = $("#especial").val();
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "apli_actu1.php",
      data:
      {
        conse: $("#conse").val(),
        ano: $("#ano").val(),
        unidad: $("#unidad").val(),
        estado: $("#estado").val(),
        valores1: $("#v_val1").val(),
        valores2: $("#v_val2").val(),
        valores3: $("#v_val3").val(),
        valores4: $("#v_val4").val(),
        motivo: $("#motivo").val(),
        valor: $("#usu1").val(),
        valor1: $("#nom1").val(),
        valor2: $("#conse").val(),
        tipo: $("#tipo").val(),
        responsable: $("#responsable").val(),
        especial: $("#v_especial").val(),
        firma: $("#v_firma").val()
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
        var notifica = registros.notifica;
        var tipou = registros.tipou;
        if ((valida == "A") || (valida == "B") || (valida == "C") || (valida == "D") || (valida == "E") || (valida == "F") || (valida == "I") || (valida == "J") || (valida == "K") || (valida == "L") || (valida == "M") || (valida == "N") || (valida == "O") || (valida == "R") || (valida == "S") || (valida == "T") || (valida == "U") || (valida == "V") || (valida == "Q") || (valida == "W") || (valida == "Y"))
        {
          $("#aceptar").hide();
          $("#estado").prop("disabled",true);
          $("#motivo").prop("disabled",true);
          $("#responsable").prop("disabled",true);
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
          $("#div4").hide();
          $("#div5").hide();
          if ($("#tipo").val() == '2')
          {
            recarga();
            if ((($("#admin").val() == "6") || ($("#admin").val() == "10") || ($("#admin").val() == "25")) && ($("#t_unidad1").val() == "1")  && ((valida == "Q") || (valida == "S") || (valida == "A") || (valida == "B") || (valida == "C")))
            {
              if (especial1 == "0")
              {
                detalle1 = "<center><h3>Cuenta con Recursos<br>Disponibles en Bancos<br>para apoyar la Solicitud ?</h3></center>";
                $("#dialogo1").html(detalle1);
                $("#dialogo1").dialog("open");
                $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
              }
              else
              {
                if ((((tipou == "4") || (tipou == "9")) && (valida == "C")) && (especial1 == "1"))
                {
                  detalle1 = "<center><h3>Cuenta con Recursos<br>Disponibles en Bancos<br>para apoyar la Solicitud ?</h3></center>";
                  $("#dialogo1").html(detalle1);
                  $("#dialogo1").dialog("open");
                  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
                }
              }
            }
            else
            {
              if (((tipou == "8") && (valida == "T")) && (especial1 == "1"))
              {
                detalle1 = "<center><h3>Cuenta con Recursos<br>Disponibles en Bancos<br>para apoyar la Solicitud ?</h3></center>";
                $("#dialogo1").html(detalle1);
                $("#dialogo1").dialog("open");
                $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
              }
            }
          }
          detalle = "<center><h3>Notificaci&oacute;n Enviada a: "+notifica+"</h3></center>";
          $("#t_persona").val(notifica);
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
        correo(notifica);
      }
    });
  }
}
function correo(valor)
{
  var valor;
  var copia = $("#correo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_correo.php",
    data:
    {
      usuario: valor
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var email = registros.email;
      correo1(valor, email, copia);
    }
  });
}
function correo1(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  var estado = $("#estado").val();
  if (estado == "Y")
  {
    var tipo = "3";
  }
  else
  {
    var tipo = "4";
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "correo.php",
    data:
    {
      tipo: tipo,
      usuario: $("#v_usuario1").val(),
      email: valor1,
      copia: valor2,
      servidor: $("#servidor").val(),
      valor1: $("#tipo").val(),
      valor2: $("#conse").val(),
      valor3: $("#ano").val(),
      valor4: valor,
      valor5: $("#motivo").val()
    },
    success: function (data) {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        alerta1("E-mail enviado correctamente");
      }
      else
      {
        alerta("Error durante el envio e-mail");
      }
    }
  });
}
function recarga()
{
  var conse = $("#conse").val();
  var ano = $("#ano").val();
  var url = "./fpdf/641.php?conse="+conse+"&ano="+ano+"&ajuste=0";
  parent.R2.location.href = url;
}
function volver()
{
  parent.location.href = "revi_plav.php";
}
function trae_personas()
{
  var paso = $("#t_unidad").val();
  var paso2 = $("#usu_crea").val();
  var paso3 = $("#recursos").val();
  var conse = $("#conse").val();
  var ano = $("#ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_personas1.php",
    data:
    {
      paso: paso,
      paso2: paso2,
      paso3: paso3,
      conse: conse,
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
      $("#val_modi").html('');
      var registros = JSON.parse(data);
      var lis_usua = [];
      var salida = "";
      salida += "<table width='95%' align='center' border='0'>";
      salida += "<tr><td width='45%' height='25'><b>Usuario</b></td><td width='45%' height='25'><b>Unidad</b></td><td width='10%' height='25'>&nbsp;</td></tr>";
      var var_con = registros.conses.split('|');
      var var_usu = registros.usuarios.split('|');
      var var_nom = registros.nombres.split('|');
      var var_sig = registros.siglas.split('|');
      var var_con1 = var_con.length;
      var var_fav = registros.favoritos;
      for (var j=0; j<var_con1-1; j++)
      {
        var var1 = var_con[j];
        var var2 = var_usu[j];
        var var3 = var_nom[j];
        var var4 = var_sig[j];
        var paso = "\'"+var2+"\'";
        var paso1 = "\'"+var3+"\'";
        if (jQuery.inArray(var2, lis_usua) != -1)
        {
        }
        else
        {
          lis_usua.push(var2);
          salida += '<tr><td width="45%">'+var2+'</td><td width="45%">'+var4+'</td><td width="10%"><input type="checkbox" name="seleccionados[]" id="chk_'+j+'" value='+var2+' onclick="trae_marca('+paso+','+paso1+','+j+');"></td></tr>';
        }
      }
      salida += '</table>';
        salida += '<input type="hidden" name="usu1" id="usu1" readonly="readonly"><input type="hidden" name="nom1" id="nom1" readonly="readonly">';
      $("#resultados").append(salida);
      if (var_fav > 0)
      {
        $("#chk_0").click();
      }
    }
  });
}
function trae_marca(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $("#usu1").val(valor);
  $("#nom1").val(valor1);
  $("input[name='seleccionados[]']").each(
    function ()
    {
      $(this).prop('checked', false);
    }
  );
  $("#chk_"+valor2).prop('checked', true);
}
function envio1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "noti_grab8.php",
    data:
    {
      conse: $("#conse").val(),
      ano: $("#ano").val()
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
      if (valida == "S")
      {
        var detalle;
        detalle = "<center><h3>Informaci&oacute;n de Tr&aacute;mite Notificaci&oacute;n Enviada a: STE_DIADI - CEDE2</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
      }
    }
  });
}
function envio2()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "noti_grab9.php",
    data:
    {
      conse: $("#conse").val(),
      notifica: $("#t_persona").val()
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
    }
  });
}
function trae_firma()
{
  $("#firma").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_firma.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var total = registros.total;
      total = parseInt(total);
      if (total > 0)
      {
        var firma = registros.firma;
        for (var i=0; i<150; i++)
        {
          firma = firma.replace(/»/g, '"');
          firma = firma.replace(/º/g, "<");
          firma = firma.replace(/«/g, ">");
        }
        firma = firma.substring(14);
        firma = "<br><center>"+firma+"</center>";
        $("#firma").append(firma);
      }
    }
  });
}
function firmar(valor)
{
  var valor;
  if (valor == "1")
  {
  }
  else
  {
    $("#v_firma").val('');
  }
  graba();
  $("#dialogo2").dialog("close");
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
// 14/09/2023 - Ajsute inclusion de iva total
?>