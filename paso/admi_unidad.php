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
          <h3>Creaci&oacute;n Unidades</h3>
          <div>
            <div id="load">
              <center>
                <img src="dist/img/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Divisiones</font></label>
                  <select name="divisiones" id="divisiones" class="form-control select2" onchange="nom_div();"></select>
                  <div class="espacio1"></div>
                  <input type="text" name="division" id="division" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off">
                  <div class="espacio1"></div>
                  <center>
                    <input type="button" name="aceptar1" id="aceptar1" value="Crear" onclick="paso_valor(1); pregunta1();">
                    &nbsp;&nbsp;&nbsp;
                    <input type="button" name="actualizar1" id="actualizar1" value="Actualizar" onclick="paso_valor(2); pregunta1();">
                  </center>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Brigadas</font></label>
                  <select name="brigadas" id="brigadas" class="form-control select2" onchange="nom_bri();"></select>
                  <div class="espacio1"></div>
                  <input type="text" name="brigada" id="brigada" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off">
                  <div class="espacio1"></div>
                  <center>
                    <input type="button" name="aceptar2" id="aceptar2" value="Crear" onclick="paso_valor1(1); pregunta2();">
                    &nbsp;&nbsp;&nbsp;
                    <input type="button" name="actualizar2" id="actualizar2" value="Actualizar" onclick="paso_valor1(2); pregunta2();">
                  </center>
                </div>
              </div>
              <br><br>
              <center>
                <label><font face="Verdana" size="2">Unidad</font></label>
              </center>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Sigla</font></label>
                  <input type="hidden" name="conse" id="conse" class="form-control numero" value="0" readonly="readonly">
                  <input type="text" name="batallon" id="batallon" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off">
                </div>
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Nombre:</font></label>
                  <input type="text" name="n_batallon" id="n_batallon" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Ciudad</font></label>
                  <?php
                  $query1 = "SELECT nombre FROM cx_ctr_ciu";
                  $sql1 = odbc_exec($conexion, $query1);
                  $j = 1;
                  while($j<$row=odbc_fetch_array($sql1))
                  {
                    $ayu_lla .= '"'.trim(odbc_result($sql1,1)).'",';
                    $j++;
                  }
                  $ayu_lla = substr($ayu_lla,0,-1);
                  $ayu_lla = utf8_encode($ayu_lla);
                  $usuario = "<input type='text' name='ciudad' id='ciudad' class='form-control' onchange='javascript:this.value=this.value.toUpperCase();'>";
                  $usuario .= "<script>$(function(){var v_ciudad = [$ayu_lla];$('#ciudad').autocomplete({source: v_ciudad});});</script>";
                  echo $usuario;
                  ?>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <div id="lbl1"><label><font face="Verdana" size="2">Techo</font></label></div>
                  <input type="text" name="techo" id="techo" class="form-control numero" value="0.00" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo</font></label>
                  <?php
                  $menu1_1 = odbc_exec($conexion,"SELECT * FROM cx_ctr_tip ORDER BY nombre");
                  $menu1 = "<select name='tipo' id='tipo' class='form-control select2'>";
                  $i = 1;
                  $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
                  while($i<$row=odbc_fetch_array($menu1_1))
                  {
                    $nombre = utf8_encode($row['nombre']);
                    $menu1 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  $menu1 .= "\n</select>";
                  echo $menu1;
                  ?>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo Unidad:</font></label>
                  <select name="tipo1" id="tipo1" class="form-control select2" onchange="especial1();">
                    <option value="0">NO APLICA</option>
                    <option value="1">CENTRALIZADORA</option>
                    <option value="2">CONSOLIDADORA</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <div id="lbl2"><label><font face="Verdana" size="2">Especial:</font></label></div>
                  <select name="especial" id="especial" class="form-control select2" onchange="especial2();">
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                  </select>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Superior</font></label>
                  <select name="especiales" id="especiales" class="form-control select2"></select>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Cambia Sigla</font></label>
                  <select name="cambio" id="cambio" class="form-control select2" onchange="cambia();">
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Sigla</font></label>
                  <input type="text" name="batallon1" id="batallon1" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off">
                </div>
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Nombre:</font></label>
                  <input type="text" name="n_batallon1" id="n_batallon1" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha Cambio</font></label>
                  <input type="text" name="fecha" id="fecha" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </div>
              </div>
              <br>
              <center>
                  <input type="button" name="aceptar3" id="aceptar3" value="Crear"><input type="button" name="actualiza" id="actualiza" value="Actualizar">
              </center>
              <hr>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><div class="centrado"><font face="Verdana" size="2">Buscar Unidad por Sigla:</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="filtro" id="filtro" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off">
                </div>
              </div>
              <div id="espacio1"></div>
              <div id="tabla4"></div>
              <div id="resultados2"></div>
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
            <div id="dialogo2"></div>
            <div id="dialogo3"></div>
            <input type="hidden" name="paso" id="paso" class="form-control" value="0" readonly="readonly">
            <input type="hidden" name="paso1" id="paso1" class="form-control" value="0" readonly="readonly">
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<style>
.ui-widget-header
{
  color: #000000;
  font-weight: bold;
}
</style>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 7,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };
  $("#fecha").datepicker({
    dateFormat: "yy/mm/dd",
    minDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 310,
    width: 350,
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
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualizar1").button();
  $("#actualizar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualizar2").button();
  $("#actualizar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").button();
  $("#aceptar3").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").click(pregunta3);
  $("#actualiza").button();
  $("#actualiza").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza").click(actualiza);  
  $("#actualiza").hide();
  $("#techo").maskMoney();
  trae_div();
  trae_bri();
  trae_bat();
  trae_esp();
  $("#filtro").keyup(trae_bat1);
  $("#especial").prop("disabled",true);
  $("#especiales").prop("disabled",true);
  $("#cambio").prop("disabled",true);
  $("#batallon1").prop("disabled",true);
  $("#n_batallon1").prop("disabled",true);
  $("#fecha").prop("disabled",true);
});
function cambia()
{
  var valor = $("#cambio").val();
  if (valor == "0")
  {
    $("#batallon1").prop("disabled",true);
    $("#n_batallon1").prop("disabled",true);
    $("#fecha").prop("disabled",true);
    $("#batallon1").val('');
    $("#n_batallon1").val('');
    $("#fecha").val('');
  }
  else
  {
    $("#batallon1").prop("disabled",false);
    $("#n_batallon1").prop("disabled",false);
    $("#fecha").prop("disabled",false);
  }
}
function paso_valor(valor)
{
  var valor;
  $("#paso").val(valor);
}
function paso_valor1(valor)
{
  var valor;
  $("#paso1").val(valor);
}
function pregunta1()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta2()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo2").html(detalle);
  $("#dialogo2").dialog("open");
  $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta3()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo3").html(detalle);
  $("#dialogo3").dialog("open");
  $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function graba1()
{
  var salida = true, detalle = '';
  if ($("#division").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar un Nombre de División</h3></center>";
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
      url: "divi_grab.php",
      data:
      {
        tipo: $("#paso").val(),
        conse: $("#divisiones").val(),
        division: $("#division").val()
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
          $("#division").val('');
          trae_div();
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
      }
    });
  }
}
function graba2()
{
  var salida = true, detalle = '';
  if ($("#divisiones").val() == '0')
  {
    salida = false;
    detalle += "<center><h3>No hay Divisiones Creadas</h3></center>";
  }
  if ($("#brigada").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar un Nombre de Brigada</h3></center>";
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
      url: "brig_grab.php",
      data:
      {
        tipo: $("#paso1").val(),
        conse: $("#brigadas").val(),
        divisiones: $("#divisiones").val(),
        brigada: $("#brigada").val()
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
          $("#brigada").val('');
          trae_bri();
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
      }
    });
  }
}
function graba3()
{
  var salida = true, detalle = '';
  if ($("#divisiones").val() == '0')
  {
    salida = false;
    detalle += "<center><h3>No hay Divisiones Creadas</h3></center>";
  }
  if ($("#brigadas").val() == '0')
  {
    salida = false;
    detalle += "<center><h3>No hay Brigadas Creadas</h3></center>";
  }
  if ($("#batallon").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar una Sigla de Unidad</h3></center>";
  }
  if ($("#tipo").val() == '-')
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar un Tipo de Unidad</h3></center>";
  }
  if ($("#n_batallon").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar un Nombre de Unidad</h3></center>";
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
      url: "bata_grab.php",
      data:
      {
        divisiones: $("#divisiones").val(),
        brigadas: $("#brigadas").val(),
        batallon: $("#batallon").val(),
        ciudad: $("#ciudad").val(),
        tipo: $("#tipo").val(),
        techo: $("#techo").val(),
        batallon1: $("#n_batallon").val(),
        tipo1: $("#tipo1").val(),
        especial: $("#especiales").val()
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
          $("#batallon").val('');
          $("#ciudad").val('');
          $("#tipo").val('-');
          $("#techo").val('0.00');
          $("#n_batallon").val('');
          trae_bat();
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
      }
    });
  }
}
function trae_div()
{
  $("#divisiones").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_divi.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var valida;
      for (var i in registros) 
      {
        var unidad = registros[i].unidad;
        var nombre = registros[i].nombre;
        salida += "<option value='"+unidad+"'>"+nombre+"</option>";
      }
      $("#divisiones").append(salida);
      nom_div();
    }
  });
}
function trae_bri()
{
  $("#brigadas").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_brig.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var valida;
      for (var i in registros) 
      {
        var dependencia = registros[i].dependencia;
        var nombre = registros[i].nombre;
        salida+="<option value='"+dependencia+"'>"+nombre+"</option>";
      }
      $("#brigadas").append(salida);
      nom_bri();
    }
  });
}
function trae_bat()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_bata.php",
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
      $("#resultados2").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='10%' height='35'><b>Sigla</b></td><td width='40%' height='35'><b>Unidad</b></font></td><td width='10%' height='35'><b>Nueva Sigla</b></td><td width='30%' height='35'><b>Unidad</b></font></td><td width='5%' height='35'><b>Fecha</b></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        salida2 += "<tr><td width='10%' height='35'>"+value.sigla+"</td>";
        salida2 += "<td width='40%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='10%' height='35'>"+value.sigla1+"</td>";
        salida2 += "<td width='30%' height='35'>"+value.nombre1+"</td>";
        salida2 += "<td width='5%' height='35'>"+value.fecha+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu("+value.subdependencia+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla4").append(salida1);
      $("#resultados2").append(salida2);
    }
  });
}
function trae_bat1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_bata1.php",
    data:
    {
      sigla: $("#filtro").val()
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
      $("#tabla4").html('');
      $("#resultados2").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='10%' height='35'><b>Sigla</b></td><td width='40%' height='35'><b>Unidad</b></font></td><td width='10%' height='35'><b>Nueva Sigla</b></td><td width='30%' height='35'><b>Unidad</b></font></td><td width='5%' height='35'><b>Fecha</b></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        salida2 += "<tr><td width='10%' height='35'>"+value.sigla+"</td>";
        salida2 += "<td width='40%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='10%' height='35'>"+value.sigla1+"</td>";
        salida2 += "<td width='30%' height='35'>"+value.nombre1+"</td>";
        salida2 += "<td width='5%' height='35'>"+value.fecha+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu("+value.subdependencia+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla4").append(salida1);
      $("#resultados2").append(salida2);
    }
  });
}
function trae_esp()
{
  $("#especiales").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_divi.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var valida;
      salida += "<option value='0'>NO APLICA</option>";
      for (var i in registros) 
      {
        var unidad = registros[i].unidad;
        var nombre = registros[i].nombre;
        salida += "<option value='"+unidad+"'>"+nombre+"</option>";
      }
      $("#especiales").append(salida);
    }
  });
}
function nom_div()
{
  var n_division = $("#divisiones option:selected").html();
  n_division = n_division.trim();
  $("#division").val(n_division);
}
function nom_bri()
{
  var n_brigada = $("#brigadas option:selected").html();
  n_brigada = n_brigada.trim();
  $("#brigada").val(n_brigada);
}

function actu(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_bata.php",
    data:
    {
      subdependencia: valor
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      $("#conse").val(registros.subdependencia);
      $("#divisiones").val(registros.unidad);
      $("#brigadas").val(registros.dependencia);
      $("#batallon").val(registros.sigla);
      $("#ciudad").val(registros.ciudad);
      $("#n_batallon").val(registros.nombre);
      $("#tipo").val(registros.tipo);
      $("#tipo1").val(registros.unic);
      var techo = registros.techo;
      techo = techo.trim();
      var especial = registros.especial;
      $("#especiales").val(especial);
      var sigla1 = registros.sigla1;
      $("#batallon1").val(sigla1);
      $("#n_batallon1").val(registros.nombre1);
      $("#fecha").val(registros.fecha);
      var valida = registros.unic;
      if (valida == "1")
      {
        $("#lbl1").show();
        $("#techo").show();
        $("#techo").prop("disabled",false);
        $("#techo").val(techo);
        if (especial == "0")
        {
          $("#especial").prop("disabled",true);
          $("#especiales").prop("disabled",true);
        }
        else
        {
          $("#especial").val('1');
          $("#especial").prop("disabled",false);
          $("#especiales").prop("disabled",false);
        }
      }
      else
      {
        $("#lbl1").hide();
        $("#techo").hide();
        $("#techo").prop("disabled",true);
      }
      $("#division").hide();
      $("#brigada").hide();
      $("#aceptar1").hide();
      $("#aceptar2").hide();
      $("#aceptar3").hide();
      $("#actualizar1").hide();
      $("#actualizar2").hide();
      $("#actualiza").show();
      $("#cambio").prop("disabled",false);
      if (sigla1 == "")
      {
        $("#cambio").val('0').change();
      }
      else
      {
        $("#cambio").val('1').change();
      }
    }
  });
}
function actualiza()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "bata_actu.php",
    data:
    {
      conse: $("#conse").val(),
      divisiones: $("#divisiones").val(),
      brigadas: $("#brigadas").val(),
      batallon: $("#batallon").val(),
      ciudad: $("#ciudad").val(),
      tipo: $("#tipo").val(),
      techo: $("#techo").val(),
      batallon1: $("#n_batallon").val(),
      tipo1: $("#tipo1").val(),
      especial: $("#especiales").val(),
      batallon2: $("#batallon1").val(),
      batallon3: $("#n_batallon1").val(),
      fecha: $("#fecha").val()
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
        $("#actualiza").hide();
        $("#batallon").val('');
        $("#ciudad").val('');
        $("#tipo").val('-');
        $("#techo").val('0.00');
        $("#n_batallon").val('');
        $("#batallon1").val('');
        $("#n_batallon1").val('');
        $("#fecha").val('');
        trae_bat();
      }
      else
      {
        detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function especial1()
{
  var valor = $("#tipo1").val();
  if (valor == "1")
  {
    $("#especial").prop("disabled",false);
  }
  else
  {
    $("#especial").val('0');
    $("#especial").prop("disabled",true);
  }
}

function especial2()
{
  var valor = $("#especial").val();
  if (valor == "1")
  {
    $("#especiales").prop("disabled",false);
  }
  else
  {
    $("#especiales").val('0');
    $("#especiales").prop("disabled",true);
  }
}
</script>
</body>
</html>
<?php
}
// 01/08/2023 - Se valida fecha de cambio de sigla para fecha actual o superior a del dia
?>