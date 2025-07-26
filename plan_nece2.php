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
  $fecha = date("d/m/Y H:i:s a");
  $datos = " - ".$fecha." ".$nom_usuario;
  $periodo = $_GET['periodo'];
  $periodo1 = nombre_mes($periodo);
  $ano = $_GET['ano'];
?>
<html lang="es">
<head>
<?php
include('encabezado.php');
?>
<style>
A:link      { text-decoration: none }
A:visited   { text-decoration: none }
A:active    { text-decoration: none }
A:hover     { text-decoration: none }
</style>
</head>
<body>
<div id="load">
  <center>
    <img src="imagenes/cargando1.gif" alt="Cargando..." />
  </center>
</div>
<div id="res_unic">
  <center>
    <input type="hidden" name="periodo" id="periodo" class="c2" value="<?php echo $periodo; ?>" readonly="readonly">
    <input type="hidden" name="periodo1" id="periodo1" class="c2" value="<?php echo $periodo1; ?>" readonly="readonly">
    <input type="hidden" name="ano" id="ano" class="c2" value="<?php echo $ano; ?>" readonly="readonly">
    <input type="hidden" name="admin" id="admin" class="c2" value="<?php echo $adm_usuario; ?>" readonly="readonly">
    <input type="hidden" name="total" id="total" class="c2" readonly="readonly">
    <input type="hidden" name="total1" id="total1" value="0" class="c2" readonly="readonly">
    <input type="hidden" name="datos" id="datos" value="<?php echo $datos; ?>" class="c2" readonly="readonly">
    <input type="button" name="aceptar" id="aceptar" value="Ver Plan de Necesidades">
  </center>
  <br>
  <?php
  if ($adm_usuario == "14")
  {
  ?>
    <table align="center" width="70%" border="1">
      <tr>
        <td width="25%" height="24" bgcolor="#ccc">
          <center>
            <b>Unidad</b>
          </center>
        </td>
        <td width="10%" height="24" bgcolor="#ccc">
          <center>
            <b>Validar</b>
          </center>
        </td>
        <td width="10%" height="24" bgcolor="#ccc">
          <center>
            <b>No Validar</b>
          </center>
        </td>
        <td width="45%" height="24" bgcolor="#ccc">
          <center>
            <b>Nota</b>
          </center>
        </td>
        <td width="10%" height="24" bgcolor="#ccc">
          <center>
            &nbsp;
          </center>
        </td>
      </tr>
      <?php
      $pregunta1 = "SELECT * FROM cx_inf_pla WHERE periodo='$periodo' AND ano='$ano' AND revisa='0'";
      $sql1 = odbc_exec($conexion, $pregunta1);
      $total1 = odbc_num_rows($sql1);
      echo "<script>$('#total1').val(".$total1.");</script>";
      $pregunta = "SELECT * FROM cx_inf_pla WHERE periodo='$periodo' AND ano='$ano' ORDER BY unidad";
      $sql = odbc_exec($conexion, $pregunta);
      $total = odbc_num_rows($sql);
      echo "<script>$('#total').val(".$total.");</script>";
      while($i<$row=odbc_fetch_array($sql))
      {
        $conse = $row["conse"];
        $nombre = $row["nombre"];
        $revisa = $row["revisa"];
        $rechaza = $row["rechaza"];
        $nota = trim(utf8_encode($row["nota"]));
        list($v1, $v2, $v3, $v4) = explode("_", $nombre);
        $nombre1 = '"'.$v2.'"';
        echo "<tr>";
        echo '<td><center><a href="#" onclick="pdf('."'".$nombre."'".')"><font color="#0033FF"><b>'.$v2.'</b></font></a></center></td>';
        if (($revisa == "0") and ($rechaza == "0"))
        {
          echo '<td><center><div id="ima_'.$conse.'"><a href="#" onclick="aprueba('.$conse.')"><img src="imagenes/aceptar.png" border="0" title="Validar" width="24" height="24"></a></center></div></td><td><center><div id="ima1_'.$conse.'"><a href="#" onclick="rechaza('.$conse.')"><img src="imagenes/cancelar.png" border="0" title="Rechazar" width="24" height="24"></a></center></div></td>';
        }
        else
        {
          echo '<td><center>&nbsp;</center></td><td><center>&nbsp;</center></td>';
        }
        echo "<td height='24'><div id='not_".$conse."' align='justify'>".$nota."</div></td>";
        echo "<td height='24'><center><a href='#' name='lnk_".$conse."' id='lnk_".$conse."' onclick='subir(".$nombre1.");'><img src='imagenes/clip.png' border='0' title='Anexar Plan Firmado'></a></center></td></tr>";
      }
      ?>
    </table>
  <?php
  }
  ?>
  <br>
  <center>
    <input type="button" name="aceptar1" id="aceptar1" value="Aprobar Plan">
  </center>
</div>
<div id="vinculo"></div>
<form name="formu1" action="ver_pdfs.php" method="post" target="_blank">
  <input type="hidden" name="nombre" id="nombre" readonly="readonly">
</form>
<form name="formu3" action="ver_nece.php" method="post" target="_blank">
  <input type="hidden" name="plan_mes" id="plan_mes" readonly="readonly">
  <input type="hidden" name="plan_ano" id="plan_ano" readonly="readonly">
</form>
<div id="dialogo"></div>
<div id="dialogo1">
  <form name="formu2">
    <table border="0">
      <tr>
        <td height="20" valign="bottom">
          Motivo Rechazo&nbsp;<input type="hidden" name="num_plan" id="num_plan" class="c10" readonly="readonly">
        </td>
      </tr>
      <tr>
        <td>
          <textarea name="mot_plan" id="mot_plan" rows="4" class="c6" maxlength="250"></textarea>
          <br><br>
          <div id="men_rec"><center>Debe Ingresar un Motivo de Rechazo</center></div>
        </td>
      </tr>
    </table>
  </form>
</div>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
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
    width: 510,
    modal: false,
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
    height: 250,
    width: 390,
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
        rechaza1();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(link);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(envio1);
  var valida = $("#admin").val();
  if ((valida == "10") || (valida == "14") || (valida == "15"))
  {
    $("#aceptar1").hide();
  }
  else
  {
    $("#aceptar1").show();
    comprueba();
  }
});
function link()
{
  var periodo = $("#periodo").val();
  var ano = $("#ano").val();
  $("#plan_mes").val(periodo);
  $("#plan_ano").val(ano);
  formu3.submit();
}
function pdf(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_centra1.php",
    data:
    {
      nombre: valor
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var archivo = registros.archivo;
      if (archivo == "1")
      {
        $("#nombre").val(valor);
        formu1.submit();
      }
      else
      {
        var detalle = "<center><h3>"+valor+" no Encontrado</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function aprueba(valor)
{
  var valor;
  var valida = $("#total1").val();
  valida = parseInt(valida);
  var periodo = $("#periodo").val();
  var ano = $("#ano").val();
  var valida1;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "actu_nece.php",
    data:
    {
      conse: valor,
      periodo: periodo,
      ano: ano
    },
    success: function (data)
    {
      $("#ima_"+valor).hide();
      $("#ima1_"+valor).hide();
      valida1 = valida-1;
      $("#total1").val(valida1);
      validar();
    }
  });
}
function rechaza(valor)
{
  var valor;
  $("#num_plan").val(valor);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function rechaza1()
{
  var salida = true, detalle = '';
  if ($("#mot_plan").val() == '')
  {
    salida = false;
  }
  if (salida == false)
  {
    $("#men_rec").addClass("ui-state-error");
    $("#men_rec").show();
  }
  else
  {
    $("#dialogo1").dialog("close");
    var valor = $("#num_plan").val();
    var nota = $("#mot_plan").val();
    var datos = $("#datos").val();
    nota = nota+datos;
    var valida = $("#total1").val();
    valida = parseInt(valida);
    var periodo = $("#periodo").val();
    var ano = $("#ano").val();
    var valida1;
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "actu_nece1.php",
      data:
      {
        conse: valor,
        nota: nota,
        periodo: periodo,
        ano: ano
      },
      success: function (data)
      {
        $("#ima_"+valor).hide();
        $("#ima1_"+valor).hide();
        valida1 = valida-1;
        $("#total1").val(valida1);
        validar();
        $("#not_"+valor).html('');
        $("#not_"+valor).append(nota);
      }
    });
  }
}
function validar()
{
  var valida = $("#total1").val();
  if (valida == "0")
  {
    $("#aceptar").show();
    envio();
  }
  else
  {
    $("#aceptar").hide();
  }
}
function envio()
{
  var admin = $("#admin").val();
  if (admin == "14")
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "noti_grab4.php",
      data:
      {
        periodo: $("#periodo").val(),
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
        var salida = registros.salida;
      }
    });
  }
}
function envio1()
{
  var admin = $("#admin").val();
  var admin1 = "";
  switch (admin)
  {
    case '16':
      admin1 = "DIR_DIADI";
      break;
    case '17':
      admin1 = "JEF_CEDE2";
      break;
    case '18':
      admin1 = "STE_DIADI";
      break;
    default:
      admin1 = "";
      break;
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "noti_grab4.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#ano").val()
    },
    success: function (data)
    {
      var detalle = "<center><h3>Aprobaci&oacute;n Registrada Correctamente y Enviada a: "+admin1+"</h3></center>";
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      $("#aceptar1").hide();
    }
  });
}
function comprueba()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "comp_nece.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#ano").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        $("#aceptar1").hide();
      }
      else
      {
        $("#aceptar1").show();
      }
    }
  });
}
function subir(valor)
{
  var valor;
  var periodo = $("#periodo1").val();
  var ano = $("#ano").val();
  var url = "<a href='./subir8.php?unidad="+valor+"&periodo="+periodo+"&ano="+ano+"' name='link1' id='link1' class='pantalla-modal'>Link</a>";
  $("#vinculo").hide();
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#link1").click();
}
</script>
</body>
</html>
<?php
}
?>