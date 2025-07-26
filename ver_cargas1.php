<?php
session_start();
error_reporting(0);
require('conf.php');
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  $v1 = $_GET["v1"];
  $v2 = $_GET["v2"];
  $v3 = $_GET["v3"];
?>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="jquery/jquery1/jquery-ui.css" rel="stylesheet">
  <script src="jquery/jquery1/jquery.js"></script>
  <script src="jquery/jquery1/jquery-ui.js"></script>
  <script type="text/javascript" src="alertas/lib/alertify.js"></script>
  <link rel="stylesheet" href="alertas/themes/alertify.core.css">
  <link rel="stylesheet" href="alertas/themes/alertify.default.css">
  <style>
  .ui-widget
  {
    font-size: 13px;
  }
  .fecha
  {
    text-align: center;
  }
  .espacio
  {
    padding-top: 3px;
    padding-bottom: 3px;
  }
  .highlight
  {
    background-Color:yellow;
  }
  .highlight1
  {
    background-Color:transparent;
  }
  </style>
</head>
<body bgcolor="#f4f7f9">
<?php
  $pregunta = "SELECT * FROM cx_rel_dis WHERE conse1='$v1' AND consecu='$v2' AND ano='$v3'";
  $sql = odbc_exec($conexion,$pregunta);
  $total = odbc_num_rows($sql);
  if ($total>0)
  {
    $i = 0;
    while ($i < $row = odbc_fetch_array($sql))
    {
      $gasto = $row['gasto'];
      $valort = trim($row['valor']);
      $datos = utf8_encode($row['datos']);
      $soporte = trim($row['tipo']);
      $reintegro = trim($row['tipo1']);
      if ($soporte == "S")
      {
        $n_soporte = " Con Soporte";
      }
      else
      {
        $n_soporte = " Sin Soporte";
        $datos = "»»".$valort."»»»»|";
      }
      // Bienes
      if ($gasto == "18")
      {
      ?>
        <table width="95%" align="center" border="1">
          <tr>
            <td colspan="3" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Bienes</font></b></center></td>
          </tr>
          <tr>
            <td width="50%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>C&oacute;digo</b></font>
              </center>
            </td>
            <td width="40%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Valor</b></font>
              </center>
            </td>
            <td width="10%" bgcolor="#ccc">
              &nbsp;
            </td>
          </tr>
          <?php
          $pregunta1 = "SELECT conse, valor, codigo, alea, unidad, unidad_a, (SELECT sigla FROM cv_unidades WHERE cv_unidades.subdependencia=cx_pla_bie.unidad) AS sigla, (SELECT sigla FROM cv_unidades WHERE cv_unidades.subdependencia=cx_pla_bie.unidad_a) AS sigla1 FROM cx_pla_bie WHERE relacion='$v1' AND numero='$v2'";
          $sql1 = odbc_exec($conexion,$pregunta1);
          $total1 = odbc_num_rows($sql1);
          if ($total1>0)
          {
            $j = 0;
            while ($j < $row1 = odbc_fetch_array($sql1))
            {
              $conse = $row1['conse'];
              $valor = trim($row1['valor']);
              $codigo = $row1['codigo'];
              $alea = trim($row1['alea']);
              $unidad = $row1['unidad'];
              $unidad1 = $row1['unidad_a'];
              if (($unidad == "777") or ($unidad == "888") or ($unidad == "999"))
              {
                $sigla = trim($row1['sigla1']);
              }
              else
              {
                $sigla = trim($row1['sigla']);
              }
              $datos2 = '"'.$alea.'",'.'"'.$sigla.'"';
              echo "<tr>";
              echo "<td width='50%' id='b_1_".$j."'>";
              echo "<font size='2' face='Verdana' color='#000000'>".$codigo."</font>";
              echo "</td>";
              echo "<td width='40%' id='b_2_".$j."' align='right'>";
              echo "<font size='2' face='Verdana' color='#000000'>".$valor."</font>";
              echo "</td>";
              echo "<td width='10%' id='b_3_".$j."'>";
              echo "<center><a href='#' onclick='highlightTabla(".$j.",3,6); imagen1(".$datos2.")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center>";
              echo "</td>";
              echo "</tr>";
              $j++;
            }
          }
          ?>
        </table>
        <?php
      }
      // Combustible
      if ($gasto == "36")
      {
      ?>
        <table width="95%" align="center" border="1">
          <tr>
            <td colspan="4" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Combustible <?php echo $n_soporte; ?></font></b></center></td>
          </tr>
        <?php
        $num_datos = explode("|",$datos);
        for ($j=0;$j<count($num_datos)-1;++$j)
        {
          $paso = $num_datos[$j];
          $paso1 = explode("»",$paso);
          for ($k=0;$k<count($paso1)-1;++$k)
          {
            $clase = $paso1[0];
            $placa = $paso1[1];
            $valor = $paso1[2];
            if (($valor == "") or ($valor == "0"))
            {
              $valor = "0.00";
            }
            $detalle = $paso1[4];
            $alea = $paso1[5];
            $unidad = $paso1[6];
            $datos1 = '"'.$gasto.'",'.'"'.$placa.'",'.'"'.$alea.'",'.'"'.$unidad.'"';
          }
          if ($soporte == "S")
          {
          ?>
            <tr>
              <td width="30%" bgcolor="#ccc">
                <center>
                  <font size="2" face="Verdana" color="#000000"><b>Clase</b></font>
                </center>
              </td>
              <td width="30%" bgcolor="#ccc">
                <center>
                  <font size="2" face="Verdana" color="#000000"><b>Placa</b></font>
                </center>
              </td>
              <td width="30%" bgcolor="#ccc">
                <center>
                  <font size="2" face="Verdana" color="#000000"><b>Valor</b></font>
                </center>
              </td>
              <td width="10%" bgcolor="#ccc">
              </td>
            </tr>
            <tr>
              <td width="30%" id="c_1_<?php echo $j; ?>">
                <?php
                echo "<font face='Verdana' size='2'>".$clase."</font>";
                ?>
              </td>
              <td width="30%" id="c_2_<?php echo $j; ?>">
                <?php
                echo "<font face='Verdana' size='2'>".$placa."</font>";
                ?>
              </td>
              <td width="30%" align="right" id="c_3_<?php echo $j; ?>">
                <?php
                echo "<font face='Verdana' size='2'>".$valor."</font>";
                ?>
              </td>
              <td width="10%" id="c_4_<?php echo $j; ?>">
                <?php
                echo "<center><a href='#' onclick='highlightTabla(".$j.",4,1); imagen(".$datos1.")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center>";
                ?>
              </td>
            </tr>
            <tr>
              <td colspan="3" bgcolor="#ccc">
                <center>
                  <font size="2" face="Verdana" color="#000000"><b>Detalle</b></font>
                </center>
              </td>
              <td colspan="1" bgcolor="#ccc">
                &nbsp;
              </td>
            </tr>
            <tr>
              <td colspan="3" align="justify">
                <?php
                echo "<font face='Verdana' size='2'>".$detalle."</font>";
                ?>
              </td>
              <td colspan="1">
                <?php
                echo "<center><a href='#' onclick='pregunta();'><img src='imagenes/clip.png' id='co_".$j."' border='0' title='Cargar'></a></center>";
                ?>
              </td>
            </tr>
        <?php
          }
          else
          {
        ?>
            <tr>
              <td width="30%" bgcolor="#ccc">
                &nbsp;
              </td>
              <td width="30%" bgcolor="#ccc">
                &nbsp;
              </td>
              <td width="30%" bgcolor="#ccc">
                <center>
                  <font size="2" face="Verdana" color="#000000"><b>Valor</b></font>
                </center>
              </td>
              <td width="10%" bgcolor="#ccc">
            </tr>
            <tr>
              <td width="30%">
                &nbsp;
              </td>
              <td width="30%">
                &nbsp;
              </td>
              <td width="30%" align="right">
                <?php
                echo "<font face='Verdana' size='2'>".$valort."</font>";
                ?>
              </td>
              <td width="10%">
                &nbsp;
              </td>
            </tr>
        <?php
          }
        }
        ?>
        </table>
        <br>
        <hr>
        <br>
      <?php
      }
      // Combustible Adicional
      if ($gasto == "42")
      {
      ?>
        <table width="95%" align="center" border="1">
          <tr>
            <td colspan="4" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Combustible Adicional <?php echo $n_soporte; ?></font></b></center></td>
          </tr>
          <?php
          $num_datos = explode("|",$datos);
          for ($j=0;$j<count($num_datos)-1;++$j)
          {
            $paso = $num_datos[$j];
            $paso1 = explode("»",$paso);
            for ($k=0;$k<count($paso1)-1;++$k)
            {
              $clase = $paso1[0];
              $placa = $paso1[1];
              $valor = $paso1[2];
              if (($valor == "") or ($valor == "0"))
              {
                $valor = "0.00";
              }
              $detalle = $paso1[4];
              $alea = $paso1[5];
              $unidad = $paso1[6];
              $datos1 = '"'.$gasto.'",'.'"'.$placa.'",'.'"'.$alea.'",'.'"'.$unidad.'"';
            }
          ?>
          <tr>
            <td width="30%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Clase</b></font>
              </center>
            </td>
            <td width="30%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Placa</b></font>
              </center>
            </td>
            <td width="30%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Valor</b></font>
              </center>
            </td>
            <td width="10%" bgcolor="#ccc">
            </td>
          </tr>
          <tr>
            <td width="30%" id="w_1_<?php echo $j; ?>">
              <?php
              echo "<font face='Verdana' size='2'>".$clase."</font>";
              ?>
            </td>
            <td width="30%" id="w_2_<?php echo $j; ?>">
              <?php
              echo "<font face='Verdana' size='2'>".$placa."</font>";
              ?>
            </td>
            <td width="30%" align="right" id="w_3_<?php echo $j; ?>">
              <?php
              echo "<font face='Verdana' size='2'>".$valor."</font>";
              ?>
            </td>
            <td width="10%" id="w_4_<?php echo $j; ?>">
              <?php
              echo "<center><a href='#' onclick='highlightTabla(".$j.",4,5); imagen(".$datos1.")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center>";
              ?>
            </td>
          </tr>
          <tr>
            <td colspan="3" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Detalle</b></font>
              </center>
            </td>
            <td colspan="1" bgcolor="#ccc">
              &nbsp;
            </td>
          </tr>
          <tr>
            <td colspan="3" align="justify">
              <?php
              echo "<font face='Verdana' size='2'>".$detalle."</font>";
              ?>
            </td>
            <td colspan="1">
              <?php
              echo "<center><a href='#' onclick='pregunta();'><img src='imagenes/clip.png' id='ca_".$j."' border='0' title='Cargar'></a></center>";
              ?>
            </td>
          </tr>
        <?php
        }
        ?>
        </table>
        <br>
        <hr>
        <br>
      <?php
      }
      // Repuestos
      if (($gasto == "38") or ($gasto == "44"))
      {
      ?>
        <table width="95%" align="center" border="1">
          <tr>
            <td colspan="4" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Mantenimiento y Repuestos</font></b></center></td>
          </tr>
          <?php
          $num_datos = explode("|",$datos);
          for ($j=0;$j<count($num_datos)-1;++$j)
          {
            $paso = $num_datos[$j];
            $paso1 = explode("»",$paso);
            for ($k=0;$k<count($paso1)-1;++$k)
            {
              $clase = $paso1[0];
              $placa = $paso1[1];
              $valor = $paso1[12];
              if (($valor == "") or ($valor == "0"))
              {
                $valor = "0.00";
              }
              $detalle = $paso1[14];
              $alea = $paso1[18];
              $unidad = $paso1[19];
              $datos1 = '"'.$gasto.'",'.'"'.$placa.'",'.'"'.$alea.'",'.'"'.$unidad.'"';
            }
          ?>
          <tr>
            <td width="30%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Clase</b></font>
              </center>
            </td>
            <td width="30%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Placa</b></font>
              </center>
            </td>
            <td width="30%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Valor</b></font>
              </center>
            </td>
            <td width="10%" bgcolor="#ccc">
            </td>
          </tr>
          <tr>
            <td width="30%" id="m_1_<?php echo $j; ?>">
              <?php
              echo "<font face='Verdana' size='2'>".$clase."</font>";
              ?>
            </td>
            <td width="30%" id="m_2_<?php echo $j; ?>">
              <?php
              echo "<font face='Verdana' size='2'>".$placa."</font>";
              ?>
            </td>
            <td width="30%" align="right" id="m_3_<?php echo $j; ?>">
              <?php
              echo "<font face='Verdana' size='2'>".$valor."</font>";
              ?>
            </td>
            <td width="10%" id="m_4_<?php echo $j; ?>">
              <?php
              echo "<center><a href='#' onclick='javascript:highlightTabla(".$j.",4,2); imagen(".$datos1.")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center>";
              ?>
            </td>
          </tr>
          <tr>
            <td colspan="3" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Detalle</b></font>
              </center>
            </td>
            <td colspan="1" bgcolor="#ccc">
              &nbsp;
            </td>
          </tr>
          <tr>
            <td colspan="3" align="justify">
              <?php
              echo "<font face='Verdana' size='2'>".$detalle."</font>";
              ?>
            </td>
            <td colspan="1">
              <?php
              echo "<center><a href='#' onclick='pregunta();'><img src='imagenes/clip.png' id='ma_".$j."' border='0' title='Cargar'></a></center>";
              ?>
            </td>
          </tr>
        <?php
        }
        ?>
        </table>
        <br>
        <hr>
        <br>
      <?php
      }
      // Rtm
      if (($gasto == "39") or ($gasto == "45"))
      {
      ?>
        <table width="95%" align="center" border="1">
          <tr>
            <td colspan="4" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">RTM</font></b></center></td>
          </tr>
          <?php
          $num_datos = explode("|",$datos);
          for ($j=0;$j<count($num_datos)-1;++$j)
          {
            $paso = $num_datos[$j];
            $paso1 = explode("»",$paso);
            for ($k=0;$k<count($paso1)-1;++$k)
            {
              $clase = $paso1[0];
              $placa = $paso1[1];
              $valor = $paso1[5];
              if (($valor == "") or ($valor == "0"))
              {
                $valor = "0.00";
              }
              $detalle = $paso1[7];
              $alea = $paso1[10];
              $unidad = $paso1[11];
              $datos1 = '"'.$gasto.'",'.'"'.$placa.'",'.'"'.$alea.'",'.'"'.$unidad.'"';
            }
          ?>
          <tr>
            <td width="30%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Clase</b></font>
              </center>
            </td>
            <td width="30%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Placa</b></font>
              </center>
            </td>
            <td width="30%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Valor</b></font>
              </center>
            </td>
            <td width="10%" bgcolor="#ccc">
            </td>
          </tr>
          <tr>
            <td width="30%" id="r_1_<?php echo $j; ?>">
              <?php
              echo "<font face='Verdana' size='2'>".$clase."</font>";
              ?>
            </td>
            <td width="30%" id="r_2_<?php echo $j; ?>">
              <?php
              echo "<font face='Verdana' size='2'>".$placa."</font>";
              ?>
            </td>
            <td width="30%" align="right" id="r_3_<?php echo $j; ?>">
              <?php
              echo "<font face='Verdana' size='2'>".$valor."</font>";
              ?>
            </td>
            <td width="10%" id="r_4_<?php echo $j; ?>">
              <?php
              echo "<center><a href='#' onclick='javascript:highlightTabla(".$j.",4,3); imagen(".$datos1.")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center>";
              ?>
            </td>
          </tr>
          <tr>
            <td colspan="3" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Detalle</b></font>
              </center>
            </td>
            <td colspan="1" bgcolor="#ccc">
              &nbsp;
            </td>
          </tr>
          <tr>
            <td colspan="3" align="justify">
              <?php
              echo "<font face='Verdana' size='2'>".$detalle."</font>";
              ?>
            </td>
            <td colspan="1">
              <?php
              echo "<center><a href='#' onclick='pregunta();'><img src='imagenes/clip.png' id='rt_".$j."' border='0' title='Cargar'></a></center>";
              ?>
            </td>
          </tr>
        <?php
        }
        ?>
        </table>
        <br>
        <hr>
        <br>
      <?php
      }
      // Llantas
      if (($gasto == "40") or ($gasto == "46"))
      {
      ?>
        <table width="95%" align="center" border="1">
          <tr>
            <td colspan="4" bgcolor="#ccc"><center><b><font size="3" face="Verdana" color="#000000">Llantas</font></b></center></td>
          </tr>
          <?php
          $num_datos = explode("|",$datos);
          for ($j=0;$j<count($num_datos)-1;++$j)
          {
            $paso = $num_datos[$j];
            $paso1 = explode("»",$paso);
            for ($k=0;$k<count($paso1)-1;++$k)
            {
              $clase = $paso1[0];
              $placa = $paso1[1];
              $valor = $paso1[6];
              if (($valor == "") or ($valor == "0"))
              {
                $valor = "0.00";
              }
              $detalle = $paso1[8]."<hr>".$paso1[9]."<hr>".$paso1[10];
              $alea = $paso1[13];
              $unidad = $paso1[14];
              $datos1 = '"'.$gasto.'",'.'"'.$placa.'",'.'"'.$alea.'",'.'"'.$unidad.'"';
            }
          ?>
          <tr>
            <td width="30%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Clase</b></font>
              </center>
            </td>
            <td width="30%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Placa</b></font>
              </center>
            </td>
            <td width="30%" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Valor</b></font>
              </center>
            </td>
            <td width="10%" bgcolor="#ccc">
            </td>
          </tr>
          <tr>
            <td width="30%" id="l_1_<?php echo $j; ?>">
              <?php
              echo "<font face='Verdana' size='2'>".$clase."</font>";
              ?>
            </td>
            <td width="30%" id="l_2_<?php echo $j; ?>">
              <?php
              echo "<font face='Verdana' size='2'>".$placa."</font>";
              ?>
            </td>
            <td width="30%" align="right" id="l_3_<?php echo $j; ?>">
              <?php
              echo "<font face='Verdana' size='2'>".$valor."</font>";
              ?>
            </td>
            <td width="10%" id="l_4_<?php echo $j; ?>">
              <?php
              echo "<center><a href='#' onclick='javascript:highlightTabla(".$j.",4,4); imagen(".$datos1.")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center>";
              ?>
            </td>
          </tr>
          <tr>
            <td colspan="3" bgcolor="#ccc">
              <center>
                <font size="2" face="Verdana" color="#000000"><b>Detalle</b></font>
              </center>
            </td>
            <td colspan="1" bgcolor="#ccc">
              &nbsp;
            </td>
          </tr>
          <tr>
            <td colspan="3" align="justify">
              <?php
              echo "<font face='Verdana' size='2'>".$detalle."</font>";
              ?>
            </td>
            <td colspan="1">
              <?php
              echo "<center><a href='#' onclick='pregunta();'><img src='imagenes/clip.png' id='ll_".$j."' border='0' title='Cargar'></a></center>";
              ?>
            </td>
          </tr>
          <?php
          }
          ?>
        </table>
        <br>
        <hr>
        <br>
      <?php
      }
    } 
  }
?>
<div id="dialogo">
  <div class="row">
    <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
      <center>
        <label><font face="Verdana" size="2"><div id="tipo2">C&oacute;digo de Autorizaci&oacute;n</div></font></label>
        <br>
        <input type="password" name="pass1" id="pass1" class="form-control fecha espacio" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="12">
        <input type="hidden" name="pass2" id="pass2" class="form-control fecha" value="<?php echo $acceso; ?>" readonly="readonly">
        <br><br>
        <div id="mensaje"></div>
      </center>
    </div>
  </div>
</div>
<input type="hidden" name="ruta" id="ruta" class="form-control" value="<?php echo $ruta_local; ?>" readonly="readonly">
<input type="hidden" name="v_paso" id="v_paso" class="form-control" value="" readonly="readonly">
<input type="hidden" name="v_paso1" id="v_paso1" class="form-control" value="" readonly="readonly">
<input type="hidden" name="v1" id="v1" class="form-control" value="" readonly="readonly">
<input type="hidden" name="v2" id="v2" class="form-control" value="" readonly="readonly">
<input type="hidden" name="v3" id="v3" class="form-control" value="" readonly="readonly">
<input type="hidden" name="v4" id="v4" class="form-control" value="" readonly="readonly">
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function() {
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
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
        compara();
      },
      Cancelar: function() {
        apaga();
        $(this).dialog("close");
      }
    }
  });
  apaga();
});
function apaga()
{
  for (i=0; i<=200; i++)
  {
    if ($("#co_"+i).length)
    {
      $("#co_"+i).hide();
    }
    if ($("#ca_"+i).length)
    {
      $("#ca_"+i).hide();
    }
    if ($("#ma_"+i).length)
    {
      $("#ma_"+i).hide();
    }
    if ($("#rt_"+i).length)
    {
      $("#rt_"+i).hide();
    }
    if ($("#ll_"+i).length)
    {
      $("#ll_"+i).hide();
    }
  }
}
function compara()
{
  $("#mensaje").html('');
  var pass1, pass2;
  pass1 = $("#pass1").val().trim();
  pass2 = $("#pass2").val().trim();
  if (pass1 != pass2)
  {
    var detalle = "<center>El c&oacute;digo de autorizaci&oacute;n no concuerda</center>";
    $("#mensaje").append(detalle);
    $("#mensaje").show();
  }
  else
  {
    sube();
    $("#pass1").val('');
    $("#dialogo").dialog("close");
  }
}
function sube()
{
  apaga();
  var v1 = $("#v1").val();
  var v2 = $("#v2").val();
  var v3 = $("#v3").val();
  var v4 = $("#v4").val();
  var url = "subir22.php?valor1="+v1+"&valor2="+v2+"&valor3="+v3+"&valor4="+v4;
  parent.P2.location.href = url;
}
function imagen(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3;
  apaga();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "rela_consu1.php",
    data:
    {
      gasto: valor,
      placa: valor1,
      alea: valor2,
      unidad: valor3
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var carpeta = registros.carpeta;
      var archivo = registros.archivo;
      var url = "";
      if (archivo === null)
      {
        var detalle = "Factura No Encontrada o No Cargada";
        alerta1(detalle);
        url = "resultado1.php";
        parent.P2.location.href = url;
        var valida = $("#v_paso").val();
        var valida1 = $("#v_paso1").val();
        if (valida1 == "1")
        {
          var letra = "co";
        }
        if (valida1 == "5")
        {
          var letra = "ca";
        }
        if (valida1 == "2")
        {
          var letra = "ma";
        }
        if (valida1 == "3")
        {
          var letra = "rt";
        }
        if (valida1 == "4")
        {
          var letra = "ll";
        }
        $("#"+letra+"_"+valida).show();
        $("#v1").val(valor);
        $("#v2").val(valor1);
        $("#v3").val(valor2);
        $("#v4").val(valor3);
      }
      else
      {
        var ruta = $("#ruta").val();
        ruta = ruta.trim();
        url = "cxvisor1/Default?valor1="+ruta+"\\upload\\"+carpeta+"\\"+valor1+"\\"+valor3+"\\"+valor2+"\\&valor2="+archivo+"&valor3=0&valor4=0";
        parent.P2.location.href = url;
      }
    }
  });
}
function imagen1(valor, valor1)
{
  var valor, valor1;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "rela_consu4.php",
    data:
    {
      alea: valor,
      unidad: valor1
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var archivo = registros.archivo;
      var url = "";
      if (archivo === null)
      {
        var detalle = "Factura No Encontrada o No Cargada";
        alerta1(detalle);
        url = "resultado1.php";
        parent.P2.location.href = url;
      }
      else
      {
        var ruta = $("#ruta").val();
        ruta = ruta.trim();
        url = "cxvisor1/Default?valor1="+ruta+"\\upload\\bienes\\"+valor1+"\\"+valor+"\\&valor2="+archivo+"&valor3=0&valor4=0";
        parent.P2.location.href = url;
      }
    }
  });
}
function pregunta()
{
  $("#dialogo").dialog("open");
  $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function clave()
{
  alert("Clave");
}
function highlightTabla(id, contador, valor)
{
  var letra = "";
  var letra1 = "";
  var letra2 = "";
  var letra3 = "";
  var letra4 = "";
  var letra5 = "";
  if (valor == "1")
  {
    letra = "c";
    letra1 = "m";
    letra2 = "r";
    letra3 = "l";
    letra4 = "w";
    letra5 = "b";
  }
  if (valor == "2")
  {
    letra = "m";
    letra1 = "c";
    letra2 = "r";
    letra3 = "l";
    letra4 = "w";
    letra5 = "b";
  }
  if (valor == "3")
  {
    letra = "r";
    letra1 = "c";
    letra2 = "m";
    letra3 = "l";
    letra4 = "w";
    letra5 = "b";
  }
  if (valor == "4")
  {
    letra = "l";
    letra1 = "c";
    letra2 = "m";
    letra3 = "r";
    letra4 = "w";
    letra5 = "b";
  }
  if (valor == "5")
  {
    letra = "w";
    letra1 = "c";
    letra2 = "m";
    letra3 = "r";
    letra4 = "l";
    letra5 = "b";
  }
  if (valor == "6")
  {
    letra = "b";
    letra1 = "c";
    letra2 = "m";
    letra3 = "r";
    letra4 = "l";
    letra5 = "w";
  }
  for (i=0; i<=200; i++)
  {
    var id1 = letra+'_1'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    var id1 = letra+'_2'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    var id1 = letra+'_3'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    var id1 = letra+'_4'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    //
    var id1 = letra1+'_1'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    var id1 = letra1+'_2'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    var id1 = letra1+'_3'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    var id1 = letra1+'_4'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    //
    var id1 = letra2+'_1'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    var id1 = letra2+'_2'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    var id1 = letra2+'_3'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    var id1 = letra2+'_4'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    //
    var id1 = letra3+'_1'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    var id1 = letra3+'_2'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    var id1 = letra3+'_3'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
    var id1 = letra3+'_4'+'_'+i;
    if ($("#"+id1).length)
    {
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
  }
  // Ilumina fila tabla
  for (j=1; j<=contador; j++)
  {
    var id1 = letra+'_'+j+'_'+id;
    var textObject = document.getElementById(id1);
    textObject.className = "highlight";
  }
  $("#v_paso").val(id);
  $("#v_paso1").val(valor);
}
function alerta1(valor)
{
  alertify.error(valor);
}
function alerta(valor)
{
  alertify.success(valor);
}
</script>
</body>
</html>
<?php
}
// 24/07/2024 - Ajuste para cargue de informacion sin soporte
// 15/08/2024 - Ajuste carga facturas de bienes
// 18/09/2024 - Ajuste mantenimientos adicional
// 03/10/2024 - Ajuste partidas adicionales
// 28/01/2025 - Ajuste sigla dados de alta en SAP
?>