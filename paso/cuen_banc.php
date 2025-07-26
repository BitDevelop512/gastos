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
  include('permisos.php');
  $query = "SELECT cuenta FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $query);
  $cuenta = trim(odbc_result($cur,1));
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
</head>
<body style="overflow-x:hidden; overflow-y:auto;">
<?php
include('titulo.php');
?>
<div>
  <section class="content-header">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="soportes">
          <h3>Cuentas Bancarias</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Cuenta</font></label>
                  <input type="hidden" name="conse" id="conse" class="form-control numero" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="cuenta1" id="cuenta1" class="form-control" value="<?php echo $cuenta; ?>" readonly="readonly" tabindex="0">
                  <input type="text" name="cuenta" id="cuenta" class="form-control" onkeypress="return check(event);" maxlength="15" onblur="compara();" tabindex="1" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Nombre</font></label>
                  <input type="text" name="nombre" id="nombre" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onblur="val_caracteres('nombre');" maxlength="25" tabindex="2" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Banco</font></label>
                  <select name="banco" id="banco" class="form-control select2" tabindex="3">
                    <option value="1">BBVA</option>
                    <option value="2">AV VILLAS</option>
                    <option value="3">DAVIVIENDA</option>
                    <option value="4">BANCOLOMBIA</option>
                    <option value="5">BANCO DE BOGOTA</option>
                    <option value="6">POPULAR</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Saldo</font></label>
                  <input type="text" name="saldo" id="saldo" class="form-control numero" value="0.00" onkeyup="paso_val();" tabindex="4">
                  <input type="hidden" name="saldo1" id="saldo1" class="form-control numero" value="0" readonly="readonly" tabindex="5">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <br>
                  <input type="button" name="aceptar" id="aceptar" value="Crear" tabindex="6">
                  <input type="button" name="actualiza" id="actualiza" value="Actualizar" tabindex="7">
                  &nbsp;&nbsp;&nbsp;
                  <input type="button" name="cancelar" id="cancelar" value="Cancelar" tabindex="8">
                </div>
              </div>
              <br>
              <div class="espacio2"></div>
              <div id="tabla4"></div>
              <div id="resultados4"></div>
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
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
    height: 310,
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
    height: 170,
    width: 450,
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
        validacionData();
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
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza").button();
  $("#actualiza").click(actualiza);
  $("#actualiza").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza").hide();
  $("#cancelar").button();
  $("#cancelar").click(cancelar);
  $("#cancelar").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#cancelar").hide();
  $("#saldo").maskMoney();
  $("#cuenta").focus();
  trae_cuentas();
});
function compara()
{
  var cuenta = $("#cuenta").val();
  cuenta = cuenta.trim();
  var cuenta1 = $("#cuenta1").val();
  cuenta1 = cuenta1.trim();
  if (cuenta1 == "")
  {
    $("#aceptar").hide();
  }
  else
  {
    if (cuenta == cuenta1)
    {
      var detalle = "<h3><center>Cuenta Ya Registrada</center></h3>";
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      $("#aceptar").hide();
    }
    else
    {
      var interno = $("#conse").val();
      if (interno > 0)
      {
      }
      else
      {
        $("#aceptar").show();
      }
    }
  }
}
function compara1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cuentas2.php",
    data:
    {
      cuenta: $("#cuenta").val()
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
      var valida, detalle;
      valida = registros.salida;
      if (valida > 0)
      {

      }
      else
      {

      }
    }
  });  
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function paso_val()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('saldo').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#saldo1").val(valor1);
}
function validacionData()
{
  var salida = true, detalle = '';
  var valor = $("#cuenta").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar Cuenta Bancaria</h3></center>";
  }
  var valor1 = $("#nombre").val();
  valor1 = valor1.trim().length;
  if (valor1 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar Nombre Cuenta Bancaria</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    nuevo();
  }
}
function nuevo()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "cuen_grab.php",
    data:
    {
      cuenta: $("#cuenta").val(),
      nombre: $("#nombre").val(),
      banco: $("#banco").val(),
      saldo: $("#saldo").val(),
      saldo1: $("#saldo1").val()
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
      var valida, detalle;
      valida = registros.salida;
      if (valida > 0)
      {
        $("#conse").val('0');
        $("#cuenta").val('');
        $("#nombre").val('');
        $("#banco").val('1');
        $("#saldo").val('0.00');
        $("#saldo1").val('0.00');
        trae_cuentas();
        $("#cuenta").focus();
      }
      else
      {
        detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
      }
    }
  });
}
function actu(valor, valor1, valor2, valor3, valor4, valor5)
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6;
  valor6 = parseFloat(valor3);
  valor6 = valor6.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#conse").val(valor);
  $("#cuenta").val(valor1);
  $("#nombre").val(valor2);
  $("#banco").val(valor5);
  $("#saldo").val(valor6);
  $("#saldo1").val(valor3);
  $("#aceptar").hide();
  $("#actualiza").show();
  $("#cancelar").show();
  $("#saldo").prop("disabled", true);
}
function actualiza()
{
  var salida = true, detalle = '';
  var valor = $("#cuenta").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar Cuenta Bancaria</h3></center>";
  }
  var valor1 = $("#nombre").val();
  valor1 = valor1.trim().length;
  if (valor1 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar Nombre Cuenta Bancaria</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "cuen_actu.php",
      data:
      {
        conse: $("#conse").val(),
        cuenta: $("#cuenta").val(),
        nombre: $("#nombre").val(),
        banco: $("#banco").val(),
        saldo: $("#saldo").val(),
        saldo1: $("#saldo1").val()
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
        var valida, detalle;
        valida = registros.salida;
        if (valida > 0)
        {
          $("#conse").val('0');
          $("#cuenta").val('');
          $("#nombre").val('');
          $("#banco").val('1');
          $("#saldo").val('0.00');
          $("#saldo1").val('0.00');
          trae_cuentas();
          $("#cuenta").focus();
          $("#aceptar").show();
          $("#actualiza").hide();
          $("#cancelar").hide();
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
        }
      }
    });
  }
}
function cancelar()
{
  location.href = "cuen_banc.php";
}
function trae_cuentas()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cuentas.php",
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
      $("#tabla4").html('');
      $("#resultados4").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='35%' height='35'><font size='2'><b>Cuenta</b></font></td><td width='30%' height='35'><font size='2'><b>Nombre</b></font></td><td width='30%' height='35'><center><font size='2'><b>Saldo</b></font></center></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.conse+'\",\"'+value.cuenta+'\",\"'+value.nombre+'\",\"'+value.saldo+'\",\"'+value.saldo1+'\",\"'+value.banco+'\"';
        salida2 += "<tr><td width='35%' height='35'>"+value.cuenta+"</td>";
        salida2 += "<td width='30%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='30%' align='right' height='35'>"+value.saldo1+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu("+paso+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td><tr>";
      });
      salida2 += "</table>";
      $("#tabla4").append(salida1);
      $("#resultados4").append(salida2);
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
  detalle = detalle.replace(/[™]+/g, '');
  $("#"+valor).val(detalle);
}
function check(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if ((tecla == 0) || (tecla == 8) || (tecla == 13))
  {
    return true;
  }
  patron = /[0-9]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
</script>
</body>
</html>
<?php
}
?>