<!doctype html>
<?php
session_start();
error_reporting(0);
$_SESSION["chat"] = "SI";
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('conf.php');
  include('funciones.php');
  include('permisos.php');
  $tipo = $_GET['tipo'];
  if ($tipo == "1")
  {
    $n_tipo = "Nuevos";
    $query = "SELECT TOP 500 * FROM cx_notifica WHERE usuario1='$usu_usuario' AND visto='$tipo' ORDER BY fecha DESC";
    $cur = odbc_exec($conexion, $query);
    $sql = "UPDATE cx_notifica SET visto='0' WHERE usuario1='$usu_usuario' AND visto='1'";
    $cur1 = odbc_exec($conexion,$sql);
  }
  else
  {
    $n_tipo = "Todos";
    $query = "SELECT TOP 500 * FROM cx_notifica WHERE usuario1='$usu_usuario' ORDER BY fecha DESC";
    $cur = odbc_exec($conexion, $query);
  }
  $contador = odbc_num_rows($cur);
?>
<html lang="es">
<head>
<?php
  include('encabezado2.php');
  include('encabezado4.php');
?>
</head>
<body>
<?php
include('titulo.php');
?>
<div>
  <section class="content-header">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="soportes">
          <h3>Mensajes ( <?php echo $n_tipo; ?> )</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <?php
            echo "<table width='100%' align='center' border='0' id='a-table1'>";
            echo "<tr><td height='35' width='5%'>&nbsp</td><td height='35' width='18%'><center><b>Fecha</b></center></td><td height='35' width='15%'><center><b>Reporta</b></center></td><td height='35' width='62%'><center><b>Mensaje</b></center></td></tr>";
            while($i<$row=odbc_fetch_array($cur))
            {
              $interno = odbc_result($cur,1);
              $fecha = substr(odbc_result($cur,2),0,19);
              $usuario = trim(odbc_result($cur,3));
              $unidad = trim(odbc_result($cur,4));
              $consulta = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$unidad'";
              $cur1 = odbc_exec($conexion,$consulta);
              $n_unidad = odbc_result($cur1,1);
              $mensaje = trim(utf8_encode($row["mensaje"]));
              $mensaje = str_replace("»", "'", $mensaje);
              $tipo = trim(odbc_result($cur,8));
              switch ($tipo)
              {
                case 'A':
                case 'B':
                case 'C':
                case 'D':
                case 'H':
                  $imagen = "aceptar.png";
                  break;
                case 'R':
                case 'Y':
                  $imagen = "cancelar.png";
                  break;
                case 'S':
                  $imagen = "solicitar.png";
                  break;
                case 'P':
                  $imagen = "archivo.png";
                  break;
                case 'V':
                  $imagen = "valor.png";
                  break;
                case 'W':
                  $imagen = "placa.png";
                  break;
                default:
                  $imagen = "";
                  break;
              }
              echo "<tr><td><center><img src='imagenes/".$imagen."'></center></td><td><center>".$fecha."</center></td><td><center>".$usuario."</center></td><td>".$mensaje."</td></tr>";
            }
            echo "</table>";
            ?>
            <div id="dialogo"></div>
            <div id="dialogo1">
              <form name="formu2">
                <table width="98%" align="center" border="0">
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                          <label><font face="Verdana" size="2">Motivo Rechazo</font></label>
                          <input type="hidden" name="num_plan" id="num_plan" class="form-control" readonly="readonly">
                          <input type="hidden" name="ano_plan" id="ano_plan" class="form-control" readonly="readonly">
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                          <input type="text" name="mot_plan" id="mot_plan" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onblur="val_caracteres('mot_plan');"  maxlength="50" autocomplete="off">
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                          <div id="men_rec"><center>Debe Ingresar un Motivo de Rechazo</center></div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
            <form name="formu3" action="ver_plan.php" method="post" target="_blank">
              <input type="hidden" name="plan_conse" id="plan_conse" readonly="readonly">
              <input type="hidden" name="plan_ano" id="plan_ano" readonly="readonly">
              <input type="hidden" name="plan_tipo" id="plan_tipo" readonly="readonly">
              <input type="hidden" name="plan_ajust" id="plan_ajust" readonly="readonly">
            </form>
            <form name="formu4" action="ver_giro.php" method="post" target="_blank">
              <input type="hidden" name="giro_con" id="giro_con" readonly="readonly">
              <input type="hidden" name="giro_per" id="giro_per" readonly="readonly">
              <input type="hidden" name="giro_ano" id="giro_ano" readonly="readonly">
            </form>
            <input type="hidden" name="url" id="url" value="<?php echo $url; ?>" readonly="readonly">
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<style>
.btn-mensaje
{
  width: 200px;
  padding-top: 8px;
  padding-bottom: 8px;
}
.btn-mensaje1
{
  width: 350px;
  padding-top: 8px;
  padding-bottom: 8px;
}
</style>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 170,
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
    width: 500,
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
        rechazo();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#plancen").button();
  $("#men_rec").hide();
});
function link1(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $("#plan_conse").val(valor);
  $("#plan_tipo").val(valor1);
  $("#plan_ano").val(valor2);
  $("#plan_ajust").val('0');
  formu3.submit();
}
function link2()
{
  location.href = "revi_plav.php";
}
function link3(valor, valor1, valor2)
{
  var valor, periodo, ano, link;
  $("#giro_con").val(valor);
  $("#giro_per").val(valor1);
  $("#giro_ano").val(valor2);
  formu4.submit();
}
function mensaje1(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  if (valor1 == "2")
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "noti_grab1.php",
      data:
      {
        conse: valor,
        ano: valor2,
        valor: valor1
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        var confirma = registros.confirma;
        if (confirma == "2")
        {
          $("#num_plan").val(valor);
          $("#ano_plan").val(valor2);
          $("#dialogo1").dialog("open");
          $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          var detalle = "<h3><center>Aprobaci&oacute;n Ya Registrada</center></h3>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#aprueba").hide();
          $("#rechaza").hide();
        }
      }
    });
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "noti_grab1.php",
      data:
      {
        conse: valor,
        ano: valor2,
        valor: valor1
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        var confirma = registros.confirma;
        if (confirma == "1")
        {
          var notifica = registros.notifica;
          var detalle = "<h3><center>Notificaci&oacute;n Enviada a: "+notifica+"</center></h3>";
        }
        else
        {
          var detalle = "<h3><center>Aprobaci&oacute;n Ya Registrada</center></h3>";
        }
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aprueba").hide();
        $("#rechaza").hide();
      }
    });
  }
}
function mensaje2(valor)
{
  var valor;
  window.open(valor, "_blank");
}
function rechazo()
{
  var salida = true, detalle = '';
  var valor = $("#mot_plan").val();
  valor = valor.trim().length;
  if (valor == "0")
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
    var conse = $("#num_plan").val();
    var ano = $("#ano_plan").val();
    var motivo = $("#mot_plan").val();
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "noti_grab2.php",
      data:
      {
        conse: conse,
        ano: ano,
        motivo: motivo
      },
      success: function (data)
      {
        var detalle;
        detalle = "<h3><center>Rechazo Registrado del Plan / Solicitud "+conse+" de "+ano+"</center></h3>"; 
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aprueba").hide();
        $("#rechaza").hide();
      }
    });
  }
}
function verpdf(valor, valor1, valor2)
{
  var valor;
  var url1 = $("#url").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_link.php",
    data:
    {
      unidad: valor,
      periodo: valor1,
      ano: valor2
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
      var url = "./pdfjs/web/viewer.html?file="+url1+"fpdf/pdf/"+salida;
      window.open(url, '_blank');
    }
  });
}
function visto1(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "noti_grab3.php",
    data:
    {
      conse: valor
    },
    success: function (data)
    {
      var detalle;
      detalle = "<h3><center>Visto Bueno de Plan / Solicitud "+valor+" registrado correctamente</center></h3>"; 
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      $("#visto_"+valor).hide();
    }
  });
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
</script>
</body>
</html>
<?php
}
?>