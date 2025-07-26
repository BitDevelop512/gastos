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
          <h3>Creaci&oacute;n de Bienes</h3>
          <div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Clasificaci&oacute;n</font></label>
                  <select name="clase" id="clase" class="form-control select2" onchange="busca_cla();" tabindex="1"><option value="0">- SELECCIONAR -</option></select>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Nombre del Bien</font></label>
                  <input type="hidden" name="conse" id="conse" class="form-control numero" value="0" readonly="readonly" tabindex="0">
                  <input type="text" name="nombre" id="nombre" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" tabindex="2">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Tipo</font></label>
                  <select name="tipo" id="tipo" class="form-control select2" onchange="busca_dev();" tabindex="3">
                    <option value="0">- SELECCIONAR -</option>
                    <option value="1">DEVOLUTIVO</option>
                    <option value="2">CONSUMO</option>
                    <option value="3">CAPITALIZAR</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <input type="button" name="aceptar" id="aceptar" value="Crear">
                  <input type="button" name="actualiza" id="actualiza" value="Actualizar">
                </div>
              </div>
              <div class="espacio"></div>
              <hr>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><div class="centrado"><font face="Verdana" size="2">Buscar Bien por Descripci&oacute;n:</font></div></label>
                </div>
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <input type="text" name="filtro" id="filtro" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onkeyup="trae_bienes1(1)" maxlength="50" autocomplete="off">
                  <input type="hidden" name="filtro1" id="filtro1" class="form-control" readonly="readonly">
                  <input type="hidden" name="filtro2" id="filtro2" class="form-control" readonly="readonly">
                </div>
              </div>
              <br>
              <div id="tabla1"></div>
              <div id="resultados6"></div>
              <input type="hidden" name="paso" id="paso" class="form-control" readonly="readonly" tabindex="0">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div id="dialogo"></div>
<div id="dialogo1"></div>
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
    height: 220,
    width: 350,
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
          $( this ).dialog( "close" );
        }
      }
    ]
  });
  $("#dialogo1").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 150,
    width: 300,
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
        $( this ).dialog( "close" );
        validacionData();
      },
      Cancelar: function() {
        $( this ).dialog( "close" );
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza").button();
  $("#actualiza").click(actualiza);
  $("#actualiza").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza").hide();
  $("#valor").maskMoney();
  $("#valor1").maskMoney();
  trae_clasificaciones();
  trae_bienes();
  $("#clase").focus();
});
function busca_cla()
{
  var clase = $("#clase option:selected").html();
  $("#filtro1").val(clase);
  $("#filtro2").val('');
  $("#tipo").val('0');
  trae_bienes1(2);
}
function busca_dev()
{
  var tipo = $("#tipo").val();
  $("#filtro2").val(tipo);
  $("#filtro").val('');
  var valor = $("#nombre").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    $("#clase").val('0');
    trae_bienes1(3);
  }
}
function pregunta()
{
  var detalle = "Esta seguro de continuar ?";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
}
function validacionData()
{
  var salida = true, detalle = '';
  if ($("#clase").val() == '0')
  {
    salida = false;
    detalle += "Debe seleccionar una Clasificaci&oacute;n<br><br>";
  }
  if ($("#nombre").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar la Descripci&oacute;n del Bien<br><br>";
  }
  if ($("#tipo").val() == '0')
  {
    salida = false;
    detalle += "Debe seleccionar un Tipo<br><br>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
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
    url: "bien_grab.php",
    data:
    {
      clase: $("#clase").val(),
      nombre: $("#nombre").val(),
      tipo: $("#tipo").val()
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
        $("#clase").val('1');
        $("#nombre").val('');
        $("#tipo").val('1');
        $("#nombre").focus();
        trae_bienes();
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
      }
    }
  });
}
// Trae clasificaciones
function trae_clasificaciones()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_clasi.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
          var codigo = registros[i].codigo;
          var nombre = registros[i].nombre;
          salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#paso").val(salida);
      $("#clase").append(salida);
    }
  });
}
function trae_bienes()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_bien.php",
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
      $("#tabla1").html('');
      $("#resultados6").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='25%'><font size='2'><b>Clasificaci&oacute;n</b></font></td><td width='40%'><font size='2'><b>Nombre del Bien</b></font></td><td width='25%'><font size='2'><b>Tipo</b></font></td><td width='10%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table'>";
      $.each(registros.rows, function (index, value)
      {
        if (value.tipo == "1")
        {
          var n_tipo = "DEVOLUTIVO";
        }
        else
        {
          if (value.tipo == "2")
          {        
            var n_tipo = "CONSUMO";
          }
          else
          {
            var n_tipo = "CAPITALIZAR";
          }
        }
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.tipo+'\",\"'+value.clase+'\"';
        salida2 += "<tr><td width='25%' height='35'>"+value.clase1+"</td>";
        salida2 += "<td width='40%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='25%' height='35'>"+n_tipo+"</td>";
        salida2 += "<td width='10%' height='35'><center><a href='#' onclick='actu("+paso+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla1").append(salida1);
      $("#resultados6").append(salida2);
    }
  });
}
function trae_bienes1(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_bien1.php",
    data:
    {
      busca: valor,
      nombre: $("#filtro").val(),
      clase: $("#filtro1").val(),
      tipo: $("#filtro2").val()
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
      $("#tabla1").html('');
      $("#resultados6").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='25%'><font size='2'><b>Clasificaci&oacute;n</b></font></td><td width='40%'><font size='2'><b>Nombre del Bien</b></font></td><td width='25%'><font size='2'><b>Tipo</b></font></td><td width='10%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table'>";
      $.each(registros.rows, function (index, value)
      {
        if (value.tipo == "1")
        {
          var n_tipo = "DEVOLUTIVO";
        }
        else
        {
          if (value.tipo == "2")
          {        
            var n_tipo = "CONSUMO";
          }
          else
          {
            var n_tipo = "CAPITALIZAR";
          }
        }
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.tipo+'\",\"'+value.clase+'\"';
        salida2 += "<tr><td width='25%' height='35'>"+value.clase1+"</td>";
        salida2 += "<td width='40%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='25%' height='35'>"+n_tipo+"</td>";
        salida2 += "<td width='10%' height='35'><center><a href='#' onclick='actu("+paso+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla1").append(salida1);
      $("#resultados6").append(salida2);
    }
  });
}
function actu(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3;
  $("#conse").val(valor);
  $("#nombre").val(valor1);
  $("#tipo").val(valor2);
  $("#clase").val(valor3);
  $("#aceptar").hide();
  $("#actualiza").show();
}
function actualiza()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "bien_actu.php",
    data:
    {
      conse: $("#conse").val(),
      clase: $("#clase").val(),
      nombre: $("#nombre").val(),
      tipo: $("#tipo").val()
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
        $("#clase").val('1');
        $("#nombre").val('');
        $("#tipo").val('1');
        $("#clase").focus();
        $("#aceptar").show();
        $("#actualiza").hide();
        trae_bienes();
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
      }
    }
  });
}
</script>
</body>
</html>
<?php
}
?>