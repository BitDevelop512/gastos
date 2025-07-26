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
  $ano = date('Y');
  // Marcas Transportes
  $query_m = "SELECT DISTINCT marca FROM cx_pla_tra";
  $sql_m = odbc_exec($conexion, $query_m);
  $marcas = "<option value=''>- TODAS -</option>";
  $i=1;
  while($i<$row=odbc_fetch_array($sql_m))
  {
    $marca = trim(utf8_encode(odbc_result($sql_m,1)));
    $marcas .= "<option value=$marca>".$marca."</option>";
    $i++;
  }
  // Lineas Transportes
  $query_l = "SELECT DISTINCT linea FROM cx_pla_tra";
  $sql_l = odbc_exec($conexion, $query_l);
  $lineas = "<option value=''>- TODAS -</option>";
  $i=1;
  while($i<$row=odbc_fetch_array($sql_l))
  {
    $linea = trim(utf8_encode(odbc_result($sql_l,1)));
    $lineas .= "<option value=$linea>".$linea."</option>";
    $i++;
  }
  // Modelos Transportes
  $query_o = "SELECT DISTINCT modelo FROM cx_pla_tra";
  $sql_o = odbc_exec($conexion, $query_o);
  $modelos = "<option value=''>- TODOS -</option>";
  $i=1;
  while($i<$row=odbc_fetch_array($sql_o))
  {
    $modelo = trim(utf8_encode(odbc_result($sql_o,1)));
    $modelos .= "<option value=$modelo>".$modelo."</option>";
    $i++;
  }
  // Colores Transportes
  $query_r = "SELECT DISTINCT color FROM cx_pla_tra";
  $sql_r = odbc_exec($conexion, $query_r);
  $colores = "<option value=''>- TODOS -</option>";
  $i=1;
  while($i<$row=odbc_fetch_array($sql_r))
  {
    $color = trim(utf8_encode(odbc_result($sql_r,1)));
    $colores .= "<option value=$color>".$color."</option>";
    $i++;
  }
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
          <h3>Seguimiento GGRR</h3>
          <div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Estad&iacute;stica:</font></label>
                  <select name="consulta" id="consulta" class="form-control select2" tabindex="1">
                    <option value="1">EJECUCI&Oacute;N DE PRESUPUESTO</option>
                    <option value="2">SEGUIMIENTO DE PROCEDIMIENTO</option>
                    <option value="3">ESTAD&Iacute;STICA DE TRANSPORTE</option>
                  </select>
                </div>
                <div id="lbl1">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Recurso</font></label>
                    <select name="recursos" id="recursos" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas recursos" tabindex="2">
                      <option value="1">GASTOS EN ACTIVIDADES</option>
                      <option value="2">PAGOS DE INFORMACIÓN</option>
                      <option value="3">PAGOS DE RECOMPENSAS</option>
                      <option value="4">GASTOS DE PROTECCIÓN</option>
                      <option value="5">GASTOS DE COBERTURA</option>
                    </select>
                  </div>
                </div>
                <div id="lbl2">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Concepto</font></label>
                  <select name="pagos" id="pagos" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas conceptos" tabindex="3"></select>
                  </div>
                </div>
                <div id="lbl3">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Periodo</font></label>
                    <input type="text" name="fecha1" id="fecha1" placeholder="yy/mm/dd" class="form-control fecha" readonly="readonly" tabindex="4">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">&nbsp;</font></label>
                    <input type="text" name="fecha2" id="fecha2" placeholder="yy/mm/dd" class="form-control fecha" readonly="readonly" tabindex="5">
                  </div>
                </div>
                <div id="lbl4">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Periodo Inicial</font></label>
                    <select name="periodo1" id="periodo1" class="form-control select2" onchange="val_periodo();" tabindex="6">
                      <option value="1">ENERO</option>
                      <option value="2">FEBRERO</option>
                      <option value="3">MARZO</option>
                      <option value="4">ABRIL</option>
                      <option value="5">MAYO</option>
                      <option value="6">JUNIO</option>
                      <option value="7">JULIO</option>
                      <option value="8">AGOSTO</option>
                      <option value="9">SEPTIEMBRE</option>
                      <option value="10">OCTUBRE</option>
                      <option value="11">NOVIEMBRE</option>
                      <option value="12">DICIEMBRE</option>
                    </select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Periodo Final</font></label>
                    <select name="periodo2" id="periodo2" class="form-control select2" tabindex="7">
                      <option value="1">ENERO</option>
                      <option value="2">FEBRERO</option>
                      <option value="3">MARZO</option>
                      <option value="4">ABRIL</option>
                      <option value="5">MAYO</option>
                      <option value="6">JUNIO</option>
                      <option value="7">JULIO</option>
                      <option value="8">AGOSTO</option>
                      <option value="9">SEPTIEMBRE</option>
                      <option value="10">OCTUBRE</option>
                      <option value="11">NOVIEMBRE</option>
                      <option value="12">DICIEMBRE</option>
                    </select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">A&ntilde;o</font></label>
                    <select name="ano" id="ano" class="form-control select2" tabindex="8"></select>
                  </div>
                </div>
              </div>
              <div id="lbl5">
                <br>
                <div class="row">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Marca</font></label>
                    <select name="marca" id="marca" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas marcas" tabindex="9"></select>
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Linea</font></label>
                    <select name="linea" id="linea" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas lineas" tabindex="10"></select>
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Modelo</font></label>
                    <select name="modelo" id="modelo" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas modelos" tabindex="11"></select>
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Color</font></label>
                    <select name="color" id="color" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas colores" tabindex="12"></select>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Unidad Centralizadora</font></label>
                  <?php
                  $menu1_1 = odbc_exec($conexion,"SELECT unidad, sigla FROM cx_org_sub WHERE unic='1' AND subdependencia!='301' ORDER BY sigla");
                  $menu1 = "<select name='centra' id='centra' class='form-control select2' onchange='busca();' tabindex='14'>";
                  $i = 1;
                  $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
                  while($i<$row=odbc_fetch_array($menu1_1))
                  {
                    $nombre = trim($row['sigla']);
                    $menu1 .= "\n<option value=$row[unidad]>".$nombre."</option>";
                    $i++;
                  }
                  $menu1 .= "\n<option value='999'>TODAS</option>";
                  $menu1 .= "\n</select>";
                  echo $menu1;
                  ?>
                </div>
                <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7">
                  <label><font face="Verdana" size="2">Unidades:</font></label>
                  <select name="unidad" id="unidad" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas unidades" tabindex="15"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <input type="button" name="aceptar" id="aceptar" value="Consultar" tabindex="16">
                </div>
              </div>
            </form>
            <div id="dialogo"></div>
          </div>
          <h3>Resultados</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu1" method="post">
              <div class="row">
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <div id="res_grafica"></div>
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <div id="res_grafica1"></div>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <div id="res_grafica2"></div>
                </div>
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <div id="res_grafica3"></div>
                </div>
              </div>
              <div id="resultados9"></div>
              <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
              <input type="hidden" name="paso" id="paso" class="form-control" readonly="readonly">
              <input type="hidden" name="paso1" id="paso1" class="form-control" readonly="readonly">
              <input type="hidden" name="paso2" id="paso2" class="form-control" readonly="readonly">
              <input type="hidden" name="marcas" id="marcas" class="form-control" value="<?php echo $marcas; ?>" readonly="readonly">
              <input type="hidden" name="lineas" id="lineas" class="form-control" value="<?php echo $lineas; ?>" readonly="readonly">
              <input type="hidden" name="modelos" id="modelos" class="form-control" value="<?php echo $modelos; ?>" readonly="readonly">
              <input type="hidden" name="colores" id="colores" class="form-control" value="<?php echo $colores; ?>" readonly="readonly">
              <div id="link"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
<script src="bower_components/jquery-knob/js/jquery.knob.js"></script>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
<script src="js4/highcharts.js"></script>
<script src="js4/modules/data.js"></script>
<script src="js4/modules/drilldown.js?1.0.0"></script>
<script src="js4/modules/highcharts-3d.js"></script>
<script src="js4/modules/exporting.js?1.0.0"></script>
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
  $.datepicker.setDefaults($.datepicker.regional['es']);
  $("#fecha1").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fecha2").prop("disabled",false);
      $("#fecha2").datepicker("destroy");
      $("#fecha2").val('');
      $("#fecha2").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha1").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
    },
  });
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 270,
    width: 520,
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
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(consultar);
  $("#aceptar").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#marca").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#linea").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#modelo").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#color").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#centra").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#unidad").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#pagos").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#recursos").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#consulta").focus();
  $("#consulta").change(valida);
  trae_transpor();
  trae_pagos();
  trae_ano();
  valida();
  $("#ano").val('<?php echo $ano; ?>');
  $(".knob").knob({
    draw: function () {
      if (this.$.data('skin') == 'tron') {
        var a = this.angle(this.cv)       // Angle
          , sa = this.startAngle          // Previous start angle
          , sat = this.startAngle         // Start angle
          , ea                            // Previous end angle
          , eat = sat + a                 // End angle
          , r = true;
        this.g.lineWidth = this.lineWidth;
        this.o.cursor
        && (sat = eat - 0.3)
        && (eat = eat + 0.3);
        if (this.o.displayPrevious)
        {
          ea = this.startAngle + this.angle(this.value);
          this.o.cursor
          && (sa = ea - 0.3)
          && (ea = ea + 0.3);
          this.g.beginPath();
          this.g.strokeStyle = this.previousColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
          this.g.stroke();
        }
        this.g.beginPath();
        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
        this.g.stroke();
        this.g.lineWidth = 2;
        this.g.beginPath();
        this.g.strokeStyle = this.o.fgColor;
        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
        this.g.stroke();
        return false;
      }
    }
  });
});
function trae_transpor()
{
  $("#marca").html('');
  var marcas = $("#marcas").val();
  $("#marca").append(marcas);
  $("#linea").html('');
  var lineas = $("#lineas").val();
  $("#linea").append(lineas);
  $("#modelo").html('');
  var modelos = $("#modelos").val();
  $("#modelo").append(modelos);
  $("#color").html('');
  var colores = $("#colores").val();
  $("#color").append(colores);
}
function trae_ano()
{
  $("#ano").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_ano.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var j = 0;
      for (var i in registros) 
      {
        j = j+1;
        var ano = registros[i].ano;
        salida += "<option value='"+ano+"'>"+ano+"</option>";
      }
      $("#ano").append(salida);
    }
  });
}
function val_periodo()
{
  var periodo = $("#periodo1").val();
  $("#periodo2").val(periodo);
}
function trae_unidades(valor)
{
  var valor;
  $("#unidad").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unid1.php",
    data:
    {
      valor: valor
    },    
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
      $("#unidad").append(salida);
      busca();
    }
  });
}
function trae_pagos()
{
  $("#pagos").html('');
  var tipo = "0";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_pago.php",
    data:
    {
      tipo: tipo
    },
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
      $("#pagos").append(salida);
    }
  });
}
function valida()
{
  var consulta = $("#consulta").val();
  if (consulta == "1")
  {
    $("#lbl1").hide();
    $("#lbl2").hide();
    $("#lbl3").hide();
    $("#lbl4").show();
    $("#lbl5").hide();
  }
  else
  {
    if (consulta == "2")
    {
      $("#lbl1").hide();
      $("#lbl2").hide();
      $("#lbl3").hide();
      $("#lbl4").show();
      $("#lbl5").hide();
    }
    else
    {
      $("#lbl1").hide();
      $("#lbl2").hide();
      $("#lbl3").hide();
      $("#lbl4").hide();
      $("#lbl5").show();
    }
  }
  trae_unidades(0);
  $("#centra").prop("disabled", false);
  $("#unidad").prop("disabled", false);
}
function busca()
{
  var centra = $("#centra").val();
  var sigla = $("#centra option:selected").html();
  var consulta = $("#consulta").val();
  if (centra == "-")
  { 
  }
  else
  {
    if (centra == "999")
    {
      $.ajax({
        type: "POST",
        datatype: "json",
        url: "trae_centraliza.php",
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
          $("#unidad").val('');
          var registros = JSON.parse(data);
          var datos = registros.salida;
          var var_ocu = datos.split('|');
          var var_ocu1 = var_ocu.length;
          var paso = "";
          for (var i=0; i<var_ocu1-1; i++)
          {
            paso += "'"+var_ocu[i]+"',";
          }
          paso = paso.substr(0, paso.length-1);
          paso = "["+paso+"]";
          var final = '$("#unidad").val('+paso+').trigger("change");';
          eval(final);
        }
      });
    }
    else
    {
      $.ajax({
        type: "POST",
        datatype: "json",
        url: "trae_unidad1.php",
        data:
        {
          consulta: consulta,
          centra: centra,
          sigla: sigla
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
          $("#unidad").val('');
          var registros = JSON.parse(data);
          var datos = registros.salida;
          var var_ocu = datos.split('|');
          var var_ocu1 = var_ocu.length;
          var paso = "";
          for (var i=0; i<var_ocu1-1; i++)
          {
            paso += "'"+var_ocu[i]+"',";
          }
          paso = paso.substr(0, paso.length-1);
          paso = "["+paso+"]";
          var final = '$("#unidad").val('+paso+').trigger("change");';
          eval(final);
        }
      });
    }
  }
}
function consultar()
{
  var salida = true;
  var detalle = '';
  var fecha1 = $("#fecha1").val();
  var fecha2 = $("#fecha2").val();
  var periodo1 = $("#periodo1").val();
  periodo1 = parseInt(periodo1);
  var periodo2 = $("#periodo2").val();
  periodo2 = parseInt(periodo2);
  var periodo3 = $("#periodo1 option:selected").html();
  var periodo4 = $("#periodo2 option:selected").html();
  var ano = $("#ano").val();
  var pagos = $("#pagos").select2('val');
  var recursos = $("#recursos").select2('val');
  var marca = $("#marca").select2('val');
  if (marca == null)
  {
    marca = 999;
  }
  var linea = $("#linea").select2('val');
  if (linea == null)
  {
    linea = 999;
  }
  var modelo = $("#modelo").select2('val');
  if (modelo == null)
  {
    modelo = 999;
  }
  var color = $("#color").select2('val');
  if (color == null)
  {
    color = 999;
  }
  var unidad = $("#unidad").select2('val');
  var centra = $("#centra").val();
  var sigla = $("#centra option:selected").html();
  var consulta = $("#consulta").val();
  if ((consulta == "1") || (consulta == "2"))
  {
    if (periodo2 < periodo1)
    {
      salida = false;
      detalle += "<center><h3>Periodo final no válido</h3></center>";
    }
  }
  if (unidad == null)
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar mínimo una unidad</h3></center>";
  }
  else
  {
    var n_unidad = unidad.length;
    if (n_unidad > 40)
    {
      salida = false;
      detalle += "<center><h3>Debe seleccionar máximo 40 unidades</h3></center>";
    }
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#soportes").accordion({active: 1});
    $("#res_grafica").html('');
    $("#res_grafica1").html('');
    $("#res_grafica2").html('');
    $("#res_grafica3").html('');
    $("#resultados9").html('');
    var consulta = $("#consulta").val();
    if (consulta == "1")
    {
      var url = "con_seguimiento.php";
      //formu_excel.action = "esta_estados_x.php";
    }
    if (consulta == "2")
    {
      var url = "con_seguimiento1.php";
      //formu_excel.action = "esta_estados_x.php";
    }
    if (consulta == "3")
    {
      var url = "con_seguimiento2.php";
      //formu_excel.action = "esta_estados_x.php";
    }
    $("#grafica").hide();
    $.ajax({
      type: "POST",
      datatype: "json",
      url: url,
      data:
      {
        consulta: $("#consulta").val(),
        pago: pagos,
        recurso: recursos,
        fecha1: $("#fecha1").val(),
        fecha2: $("#fecha2").val(),
        periodo1: $("#periodo1").val(),
        periodo2: $("#periodo2").val(),
        ano: $("#ano").val(),
        marca: marca,
        linea: linea,
        modelo: modelo,
        color: color,
        unidad: unidad,
        centra: centra,
        sigla: sigla
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
        if (consulta == "1")
        {
          if (centra != "999")
          {
            var total1 = registros.total1;
            var total2 = registros.total2;
            var total3 = registros.total3;
            var total4 = registros.total4;
            var total5 = parseInt(total1);
            total5 = formatNumber(total5);
            var salida = "";
            salida += "<div id='grafica1' style='width: 100%; height: 600px; margin: 0 auto'></div>";
            $("#res_grafica").append(salida);
            var grafica1 = '$("#grafica1").highcharts({ chart: { type: "column" }, title: { text: "Presupuesto Planeado vs Ejecutado entre '+periodo3+' y '+periodo4+'" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, accessibility: { announceNewData: { enabled: true } }, xAxis: { type: "category" }, yAxis: { title: { text: "Total" } }, legend: { enabled: false }, credits: { enabled: false }, plotOptions: { series: { cursor: "pointer" }, column: { pointPadding: 0.2, borderWidth: 0, dataLabels: { enabled: true, formatter: function() { return "$ "+ Highcharts.numberFormat(this.y, 0); } } } }, tooltip: { headerFormat: "<span style=\'font-size:11px\'>{series.name}</span><br>", pointFormat: "<span style=\'color:{point.color}\'>{point.name}</span>: $ {point.y}<br/>" }, series: [ { name: "'+sigla+'", colorByPoint: true, data: [ { name: "Suma de Valor Planes / Solicitudes", y: '+total1+' }, { name: "Suma de Total Informe de Gastos", y: '+total2+' } ] } ] });';
            eval(grafica1);
            // Segunda grafica
            var salida1 = "";
            salida1 += "<div id='grafica2' style='width: 100%; height: 600px; margin: 0 auto'></div>";
            $("#res_grafica1").append(salida1);
            var grafica2 = '$("#grafica2").highcharts({ chart: { type: "pie" }, title: { text: "Porcentaje de Presupuesto Ejecutado entre '+periodo3+' y '+periodo4+'" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, accessibility: { announceNewData: { enabled: true }, point: { valueSuffix: "%" } }, credits: { enabled: false }, plotOptions: { pie: { allowPointSelect: true, innerSize: 200, cursor: \'pointer\', depth: 35, dataLabels: { enabled: true, format: \'{point.name}: {point.y:.2f}%\' }, showInLegend: true } }, tooltip: { headerFormat: "<span style=\'font-size:11px\'>{series.name}</span><br>", pointFormat: "<span style=\'color:{point.color}\'>{point.name}</span>: {point.y} de $ '+total5+'<br/>" }, series: [ { name: "'+sigla+'", colorByPoint: true, data: [ { name: "Suma de Soportado", y: '+total3+' }, { name: "Suma de Faltante", y: '+total4+' } ]  } ] });';
            eval(grafica2);
          }
          else
          {
            var datos1 = registros.datos1;
            var datos2 = registros.datos2;
            var datos3 = registros.datos3;
            var datos4 = registros.datos4;
            var datos5 = registros.datos5;
            var salida = "";
            salida += "<div id='grafica1' style='width: 100%; height: 600px; margin: 0 auto'></div>";
            $("#res_grafica2").append(salida);
            var grafica1 = '$("#grafica1").highcharts({ chart: { type: "column" }, title: { text: "Presupuesto Planeado vs Ejecutado entre '+periodo3+' y '+periodo4+'" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, xAxis: { categories: [ '+datos1+' ], crosshair: true }, yAxis: { min: 0, title: { text: "Totales" } }, tooltip: { headerFormat: "<span style=\'font-size:11px\'>{point.key}</span><table>", pointFormat: "<tr><td style=\'color: {series.color}; padding: 0\'>{series.name}: </td><td style=\'padding: 0\'>&nbsp;&nbsp;<b>$ {point.y}</b></td></tr>", footerFormat: "</table>", shared: true, useHTML: true }, credits: { enabled: false }, plotOptions: { series: { cursor: "pointer", point: { events: { click: function() { envio(this.category,this.series.name); } } } }, column: { pointPadding: 0.2, borderWidth: 0, dataLabels: { enabled: true, formatter: function() { return "$ "+ Highcharts.numberFormat(this.y, 0); } } } }, colors: [\'#7CB5EC\', \'#434348\'], series: [ { name: "Suma de Valor Planes / Solicitudes", data: [ '+datos2+' ] }, { name:  "Suma de Total Informe de Gastos", data: [ '+datos3+' ] } ] } );';
            eval(grafica1);
            // Segunda grafica
            var salida1 = "";
            var var_ocu = datos1.split(',');
            var var_ocu1 = var_ocu.length;
            var var_ocu2 = datos4.split(',');
            var var_ocu3 = datos5.split(',');
            for (var i=0; i<var_ocu1; i++)
            {
              var var1 = var_ocu[i];
              var var2 = var_ocu2[i];
              var var3 = var_ocu3[i];
              var1 = var1.replace(/[']+/g, "");
              salida1 += "<div class='col-xs-3 col-md-3 text-center'><input type='text' class='knob' readonly value='"+var2+"' data-skin='tron' data-thickness='0.2' data-width='120' data-height='120' data-fgColor='#f56954' data-readonly='true'><div class='knob-label'><b>"+var1+"</b><br>Soportado: "+var2+"<br>Faltante: "+var3+"<br><br></div></div>";
            }
            $("#resultados9").append(salida1);
            $(".knob").knob();
          }
        }
        if (consulta == "2")
        {
          var titulo = "Seguimiento de Procedimiento entre "+periodo3+" y "+periodo4;
          var salida = "";
          salida += "<div class='col col-lg-2 col-sm-2 col-md-2 col-xs-2'>&nbsp;</div><div class='col col-lg-8 col-sm-8 col-md-8 col-xs-8'><center><h3>"+titulo+"</h3></center></div><br><br>";
          salida += "<table width='50%' align='center' border='1'><tr>";
          salida += "<td width='30%' height='35' bgcolor='#2E90BD'><center><b>Unidad</b></center></td>";
          salida += "<td width='15%' height='35' bgcolor='#2E90BD'><center><b>Total Misiones</b></center></td>";
          salida += "<td width='15%' height='35' bgcolor='#2E90BD'><center><b>En Ejecución</b></center></td>";
          salida += "<td width='15%' height='35' bgcolor='#2E90BD'><center><b>Finalizadas</b></center></td>";
          salida += "<td width='15%' height='35' bgcolor='#2E90BD'><center><b>Sin Informe Gastos</b></center></td>";
          salida += "<td width='10%' height='35' bgcolor='#2E90BD'><center><b>Alerta</b></center></td>";
          salida += "</tr></table>";
          salida += "<table width='50%' align='center' border='1' id='a-table1'>";
          var datos = registros.datos;
          var var_ocu = datos.split('#');
          var var_ocu1 = var_ocu.length;
          var total1 = 0;
          var total2 = 0;
          var total3 = 0;
          var total4 = 0;
          for (var i=0; i<var_ocu1-1; i++)
          {
            var var1 = var_ocu[i];
            var var_ocu2 = var1.split("|");
            var var_ocu3 = var_ocu2.length;
            for (var j=0; j<var_ocu3-1; j++)
            {
              var var1 = var_ocu2[0];
              var var2 = var_ocu2[1];
              var2 = parseInt(var2);
              var var3 = var_ocu2[2];
              var3 = parseInt(var3);
              var var4 = var_ocu2[3];
              var4 = parseInt(var4);
              var var5 = var_ocu2[4];
              var5 = parseInt(var5);
              if (var5 == "0")
              {
                if (var3 > 0)
                {
                  var color = "amarillo";
                }
                else
                {
                  var color = "verde";
                }                 
              }
              else
              {
                if (var3 > 0)
                {
                  var color = "amarillo";
                }
                else
                {
                  var color = "rojo";
                }
              }                
            }
            total1 = total1+var2;
            total2 = total2+var3;
            total3 = total3+var4;
            total4 = total4+var5;
            salida += "<tr>";
            salida += "<td width='30%' height='35'>"+var1+"</td>";
            salida += "<td width='15%' height='35'><center>"+var2+"</center></td>";
            salida += "<td width='15%' height='35'><center>"+var3+"</center></td>";
            salida += "<td width='15%' height='35'><center>"+var4+"</center></td>";
            salida += "<td width='15%' height='35'><center>"+var5+"</center></td>";
            salida += "<td width='10%' height='35'><center><img src='dist/img/"+color+".png ' height='25' border='0'></center></td>";
            salida += "</tr>";
          }
          salida += "<tr><td width='30%' height='35'><b>TOTAL:</b></td><td width='15%' height='35'><center><b>"+total1+"</b></center></td><td width='15%' height='35'><center><b>"+total2+"</b></center></td><td width='15%' height='35'><center><b>"+total3+"</b></center></td><td width='15%' height='35'><center><b>"+total4+"</b></center></td><td width='10%' height='35'>&nbsp;</td></tr>";
          salida += "</table>";
          $("#resultados9").append(salida);
        }
        if (consulta == "3")
        {
          var datos = registros.datos;
          var var_ocu = datos.split('#');
          var var_ocu1 = var_ocu.length;
          var salida = "";
          var series = "";
          var series1 = "";
          var paso = "";
          var sum_total = 0;
          for (var i=0; i<var_ocu1-1; i++)
          {
            paso = var_ocu[i];
            var var_ocu2 = paso.split('|');
            var var_ocu3 = var_ocu2.length;
            for (var j=0; j<var_ocu3-1; j++)
            {
              var v1 = var_ocu2[0];           // Unidad
              var v2 = var_ocu2[1];           // Tipo
              var v3 = var_ocu2[2];           // Sigla
              var v4 = var_ocu2[3];           // Clase
              var v5 = var_ocu2[4];           // Total
              v5 = parseInt(v5);
            }
            sum_total = sum_total+v5;
          }
          var datos1 = registros.datos1;
          var var_ocu = datos1.split('#');
          var var_ocu1 = var_ocu.length;
          var paso = "";
          var sum_total1 = 0;
          for (var i=0; i<var_ocu1-1; i++)
          {
            paso = var_ocu[i];
            var var_ocu2 = paso.split('|');
            var var_ocu3 = var_ocu2.length;
            for (var j=0; j<var_ocu3-1; j++)
            {
              var v1 = var_ocu2[0];           // Sigla
              var v2 = var_ocu2[1];           // Tipo
              v2 = parseInt(v2);
            }
            sum_total1 = sum_total1+v2;
            series1 += '{ name: "'+v1+'", y: '+v2+', drilldown: "'+v1+'" }, ';
          }
          series1 = series1.substr(0, series1.length-2);
          var datos2 = registros.datos2;
          $("#paso").val(series1);
          $("#paso1").val(datos2);
          $("#paso2").val(sum_total1);
          var series = '{ name: "Estadística de Transporte", colorByPoint: true, data: [ '+series1+' ] }';
          salida += "<div id='grafica1' style='width: 100%; height: 600px; margin: 0 auto'></div>";
          $("#res_grafica").append(salida);
          var grafica1 = '$("#grafica1").highcharts({ chart: { type: "pie" }, title: { text: "Estadística de Transporte" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, accessibility: { announceNewData: { enabled: true }, point: { valueSuffix: "%" } }, ';
          grafica1 += 'credits: { enabled: false }, plotOptions: { series: { dataLabels: { enabled: true, format: "{point.name}: {point.y}" }, showInLegend: true } }, tooltip: { headerFormat: "<span style=\'font-size:11px\'>{series.name}</span><br>", pointFormat: "<span style=\'color:{point.color}\'>{point.name}</span>: {point.y} de '+sum_total1+'<br/>" }, series: [ '+series+' ], drilldown: { series: [ '+datos2+' ] } });';
          eval(grafica1);
          // Segunda grafica
          var valores = series1;
          var valores1 = datos2;
          var valores2 = sum_total1;
          var series = '{ name: "Estadística de Transporte", colorByPoint: true, data: [ '+valores+' ] }';
          var salida = "";
          salida += "<div id='grafica2' style='width: 100%; height: 600px; margin: 0 auto'></div>";
          $("#res_grafica1").append(salida);
          var grafica2 = '$("#grafica2").highcharts({ chart: { type: "column" }, title: { text: "Estadística de Transporte" }, subtitle: { text: "SIGAR :: Sistema Integrado de Gastos Reservados :: CX COMPUTERS" }, accessibility: { announceNewData: { enabled: true } }, xAxis: { type: "category" }, yAxis: { title: { text: "Total Vehículos" } }, legend: { enabled: false }, credits: { enabled: false }, plotOptions: { series: { borderWidth: 0, dataLabels: { enabled: true, format: "{point.y}" } } }, tooltip: { headerFormat: "<span style=\'font-size:11px\'>{series.name}</span><br>", pointFormat: "<span style=\'color:{point.color}\'>{point.name}</span>: {point.y} de '+valores2+'<br/>" }, series: [ '+series+' ], drilldown: { series: [ ' + valores1 + ' ] } });';
          eval(grafica2);
        }
      }
    });
  }
}
function formatNumber(valor)
{
  valor = String(valor).replace(/\D/g, "");
  return valor === '' ? valor : Number(valor).toLocaleString();
}
function excel()
{
  formu_excel.submit();
}
</script>
</body>
</html>
<?php
}
?>