<!doctype html>
<?php
session_start();
error_reporting(0);
$_SESSION["chat"] = "NO";
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
          <h3>Control ACCAM (An&aacute;lisis de las Capacidades Cr&iacute;ticas de la Amenaza)</h3>
          <div>
            <div id="load">
              <center>
                <img src="dist/img/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Factor de Amenaza</font></label>
                  <select name="factores" id="factores" class="form-control select2" onchange="estado_fac(); trae_est(); trae_oma();"></select>
                  <div class="espacio1"></div>
                  <input type="text" name="factor" id="factor" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="150" autocomplete="off">
                  <div class="espacio1"></div>
                  <center>
                    <input type="button" name="aceptar1" id="aceptar1" value="Crear" onclick="paso_valor1(1); pregunta1();">
                    &nbsp;&nbsp;&nbsp;
                    <input type="button" name="actualizar1" id="actualizar1" value="Desactivar" onclick="paso_valor1(2); pregunta1();">
                    <input type="button" name="cambiar1" id="cambiar1" value="Activar" onclick="paso_valor1(3); pregunta1();">
                  </center>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Estructura</font></label>
                  <select name="estructuras" id="estructuras" class="form-control select2" onchange="estado_est();"></select>
                  <div class="espacio1"></div>
                  <input type="text" name="estructura" id="estructura" class="form-control" maxlength="150" autocomplete="off">
                  <div class="espacio1"></div>
                  <center>
                    <input type="button" name="aceptar2" id="aceptar2" value="Crear" onclick="paso_valor2(1); pregunta2();">
                    &nbsp;&nbsp;&nbsp;
                    <input type="button" name="actualizar2" id="actualizar2" value="Desactivar" onclick="paso_valor2(2); pregunta2();">
                    <input type="button" name="cambiar2" id="cambiar2" value="Activar" onclick="paso_valor2(3); pregunta2();">
                  </center>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Blancos de Alta Retribuci&oacute;n</font></label>
                  <select name="omaves" id="omaves" class="form-control select2" onchange="estado_oma();"></select>
                  <div class="espacio1"></div>
                  <input type="text" name="omave" id="omave" class="form-control" maxlength="150" autocomplete="off">
                  <div class="espacio1"></div>
                  <center>
                    <input type="button" name="aceptar3" id="aceptar3" value="Crear" onclick="paso_valor3(1); pregunta3();">
                    &nbsp;&nbsp;&nbsp;
                    <input type="button" name="actualizar3" id="actualizar3" value="Desactivar" onclick="paso_valor3(2); pregunta3();">
                    <input type="button" name="cambiar3" id="cambiar3" value="Activar" onclick="paso_valor3(3); pregunta3();">
                  </center>
                </div>
              </div>
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
            <div id="dialogo2"></div>
            <div id="dialogo3"></div>
            <input type="hidden" name="paso1" id="paso1" class="form-control" value="0" readonly="readonly">
            <input type="hidden" name="paso2" id="paso2" class="form-control" value="0" readonly="readonly">
            <input type="hidden" name="paso3" id="paso3" class="form-control" value="0" readonly="readonly">
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
    height: 150,
    width: 400,
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
    height: 150,
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
    buttons: {
      "Aceptar": function() {
        $(this).dialog("close");
        graba1();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 150,
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
    buttons: {
      "Aceptar": function() {
        $(this).dialog("close");
        graba2();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo3").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 150,
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
    buttons: {
      "Aceptar": function() {
        $(this).dialog("close");
        graba3();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar1").button();
  $("#aceptar1").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualizar1").button();
  $("#actualizar1").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#cambiar1").button();
  $("#cambiar1").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualizar1").hide();
  $("#cambiar1").hide();
  $("#aceptar2").button();
  $("#aceptar2").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualizar2").button();
  $("#actualizar2").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#cambiar2").button();
  $("#cambiar2").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualizar2").hide();
  $("#cambiar2").hide();
  $("#aceptar3").button();
  $("#aceptar3").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualizar3").button();
  $("#actualizar3").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#cambiar3").button();
  $("#cambiar3").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualizar3").hide();
  $("#cambiar3").hide();
  trae_fac();
});
function trae_fac()
{
  $("#factores").html('');
  var tipo = 0;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_factores.php",
    data:
    {
      tipo: tipo
    },    
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var valida;
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#factores").append(salida);
      estado_fac();
      trae_est();
      trae_oma();
    }
  });
}
function estado_fac()
{
  var tipo = 1;
  var factor = $("#factores").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_factores.php",
    data:
    {
      tipo: tipo,
      factor: factor
    },    
    success: function (data)
    {
      var registros = JSON.parse(data);
      var estado = registros.estado;
      if (estado == "X")
      {
        $("#cambiar1").show();
        $("#actualizar1").hide();
      }
      else
      {
        $("#cambiar1").hide();
        $("#actualizar1").show();
      }
    }
  });
}
function trae_est()
{
  $("#estructuras").html('');
  var tipo = 0;
  var factor = $("#factores").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_estructuras.php",
    data:
    {
      tipo: tipo,
      factor: factor
    },    
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var valida;
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#estructuras").append(salida);
      estado_est();
    }
  });
}
function estado_est()
{
  var tipo = 1;
  var factor = $("#factores").val();
  var estructura = $("#estructuras").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_estructuras.php",
    data:
    {
      tipo: tipo,
      factor: factor,
      estructura: estructura
    },    
    success: function (data)
    {
      var registros = JSON.parse(data);
      var estado = registros.estado;
      if (estado == "X")
      {
        $("#cambiar2").show();
        $("#actualizar2").hide();
      }
      else
      {
        $("#cambiar2").hide();
        $("#actualizar2").show();
      }
    }
  });
}
function trae_oma()
{
  $("#omaves").html('');
  var tipo = 0;
  var factor = $("#factores").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_omaves.php",
    data:
    {
      tipo: tipo,
      factor: factor
    },    
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var valida;
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#omaves").append(salida);
      estado_oma();
    }
  });
}
function estado_oma()
{
  var tipo = 1;
  var factor = $("#factores").val();
  var omave = $("#omaves").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_omaves.php",
    data:
    {
      tipo: tipo,
      factor: factor,
      omave: omave
    },    
    success: function (data)
    {
      var registros = JSON.parse(data);
      var estado = registros.estado;
      if (estado == "X")
      {
        $("#cambiar3").show();
        $("#actualizar3").hide();
      }
      else
      {
        $("#cambiar3").hide();
        $("#actualizar3").show();
      }
    }
  });
}
function paso_valor1(valor)
{
  var valor;
  $("#paso1").val(valor);
}
function paso_valor2(valor)
{
  var valor;
  $("#paso2").val(valor);
}
function paso_valor3(valor)
{
  var valor;
  $("#paso3").val(valor);
}
function pregunta1()
{
  var detalle = "Esta seguro de continuar ?";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
}
function pregunta2()
{
  var detalle = "Esta seguro de continuar ?";
  $("#dialogo2").html(detalle);
  $("#dialogo2").dialog("open");
}
function pregunta3()
{
  var detalle = "Esta seguro de continuar ?";
  $("#dialogo3").html(detalle);
  $("#dialogo3").dialog("open");
}
function graba1()
{
  var salida = true, detalle = "";
  var valida = $("#paso1").val();
  if (valida == "1")
  {
    var valor = $("#factor").val();
    valor = valor.trim().length;
    if (valor == "0")
    {
      salida = false;
      detalle += "Debe ingresar el Nombre del Factor de Amenaza<br>";
    }
    if (salida == false)
    {
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
    }
    else
    {
      graba1_1();
    }
  }
  else
  {
    graba1_1();
  }
}
function graba1_1()
{
  var tipo = $("#paso1").val();
  var conse = $("#factores").val();
  var nombre = $("#factor").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "factor_grab.php",
    data:
    {
      tipo: tipo,
      conse: conse,
      nombre: nombre
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
      if (valida == "1")
      {
        $("#factor").val('');
        trae_fac();
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
function graba2()
{
  var salida = true, detalle = "";
  var valida = $("#paso2").val();
  if (valida == "1")
  {
    var valor = $("#estructura").val();
    valor = valor.trim().length;
    if (valor == "0")
    {
      salida = false;
      detalle += "Debe ingresar el Nombre de la Estructura<br>";
    }
    if (salida == false)
    {
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
    }
    else
    {
      graba2_2();
    }
  }
  else
  {
    graba2_2();
  }
}
function graba2_2()
{
  var tipo = $("#paso2").val();
  var factor = $("#factores").val();
  var conse = $("#estructuras").val();
  var nombre = $("#estructura").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "estructura_grab.php",
    data:
    {
      tipo: tipo,
      factor: factor,
      conse: conse,
      nombre: nombre
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
      if (valida == "1")
      {
        $("#estructura").val('');
        trae_est();
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
function graba3()
{
  var salida = true, detalle = "";
  var valida = $("#paso3").val();
  if (valida == "1")
  {
    var valor = $("#omave").val();
    valor = valor.trim().length;
    if (valor == "0")
    {
      salida = false;
      detalle += "Debe ingresar el Nombre del OMAVE - OMINA - OMIRE<br>";
    }
    if (salida == false)
    {
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
    }
    else
    {
      graba3_3();
    }
  }
  else
  {
    graba3_3();
  }
}
function graba3_3()
{
  var tipo = $("#paso3").val();
  var factor = $("#factores").val();
  var conse = $("#omaves").val();
  var nombre = $("#omave").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "omave_grab.php",
    data:
    {
      tipo: tipo,
      factor: factor,
      conse: conse,
      nombre: nombre
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
      if (valida == "1")
      {
        $("#omave").val('');
        trae_oma();
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
// 02/04/2024 - Ajuste nombre blancos de alta retribución
?>