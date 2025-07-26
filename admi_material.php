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
          <h3>Creaci&oacute;n Material Recompensa</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Material</font></label>
                  <input type="hidden" name="conse" id="conse" class="form-control numero" value="0" readonly="readonly" tabindex="0">
                  <textarea name="material" id="material" class="form-control" rows="5" onchange="javascript:this.value=this.value.toUpperCase();" onblur="val_caracteres('material');" maxlength="600" autocomplete="off" tabindex="1"></textarea>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo</font></label>
                  <select name="unidad" id="unidad" class="form-control select2" tabindex="2">
                    <option value="1">UNIDAD</option>
                    <option value="2">KILO</option>
                    <option value="3">METRO</option>
                    <option value="4">GALON</option>
                    <option value="5">LITRO</option>
                    <option value="6">OTRO</option>
                  </select>
                  <br>
                  <label><font face="Verdana" size="2">Directiva Ministerial Permanente</font></label>
                  <?php
                  $menu8_8 = odbc_exec($conexion,"SELECT * FROM cx_ctr_dir ORDER BY codigo DESC");
                  $menu8 = "<select name='directiva1' id='directiva1' class='form-control select2' tabindex='5'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu8_8))
                  {
                    $nombre = trim(utf8_encode($row['nombre']));
                    $menu8 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  $menu8 .= "\n</select>";
                  echo $menu8;
                  ?>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor</font></label>
                  <input type="text" name="valor" id="valor" class="form-control numero" value="0.00" autocomplete="off" tabindex="3">
                  <br>
                  <label><font face="Verdana" size="2">Porcentaje</font></label>
                  <input type="text" name="porcen" id="porcen" class="form-control numero" value="0.00" onkeypress="return check(event);" autocomplete="off" tabindex="6">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Tope M&aacute;ximo</font></label>
                  <input type="text" name="valor1" id="valor1" class="form-control numero" value="0.00" autocomplete="off" tabindex="4">
									<br><br>
                  <center>
                    <input type="button" name="aceptar" id="aceptar" value="Crear">
                    <input type="button" name="actualiza" id="actualiza" value="Actualizar">
                  </center>
                </div>
              </div>
              <hr>
              <br>
              <div class="row">
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><div class="centrado"><font face="Verdana" size="2">Buscar por Descripci&oacute;n:</font></div></label>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <input type="text" name="filtro" id="filtro" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <?php
                  $menu9_9 = odbc_exec($conexion,"SELECT * FROM cx_ctr_dir ORDER BY codigo DESC");
                  $menu9 = "<select name='directiva2' id='directiva2' class='form-control select2' onchange='trae_material1();'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu9_9))
                  {
                    $nombre = trim(utf8_encode($row['nombre']));
                    $menu9 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  $menu9 .= "\n</select>";
                  echo $menu9;
                  ?>
                </div>
              </div>
              <div id="espacio1"></div>
              <div id="tabla3"></div>
              <div id="resultados4"></div>
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
          </div>
          <h3>Creaci&oacute;n Niveles Recompensa y Valores Iniciales de A&ntilde;o</h3>
          <div>
            <div id="load1">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu1" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Año</font></label>
                  <input type="text" name="ano" id="ano" class="form-control numero" onblur="trae_ano1();" maxlength="4" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">&nbsp;</font></label>
                  <select name="ano1" id="ano1" class="form-control select2" onchange="trae_salario();"></select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Salario</font></label>
                  <input type="text" name="valor2" id="valor2" class="form-control numero" value="0.00" onkeyup="paso_val();">
                  <input type="hidden" name="valor3" id="valor3" class="form-control numero" value="0">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Tarifa FSP</font></label>
                  <input type="text" name="valor4" id="valor4" class="form-control numero" value="0.00" onkeyup="paso_val1();">
                  <input type="hidden" name="valor5" id="valor5" class="form-control numero" value="0">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Tarifa FSNP</font></label>
                  <input type="text" name="valor6" id="valor6" class="form-control numero" value="0.00" onkeyup="paso_val2();">
                  <input type="hidden" name="valor7" id="valor7" class="form-control numero" value="0">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Tarifa En Sede</font></label>
                  <input type="text" name="valor8" id="valor8" class="form-control numero" value="0.00" onkeyup="paso_val3();">
                  <input type="hidden" name="valor9" id="valor9" class="form-control numero" value="0">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <input type="button" name="aceptar1" id="aceptar1" value="Crear">
                  <input type="button" name="actualiza1" id="actualiza1" value="Actualizar">
                </div>
              </div>
              <br>
              <hr>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Directiva Ministerial Permanente</font></label>
                  <input type="text" name="directiva3" id="directiva3" class="form-control" value="" onblur="val_direc();" maxlength="150" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">&nbsp;</font></label>
                  <?php
                  $menu6_6 = odbc_exec($conexion,"SELECT * FROM cx_ctr_dir ORDER BY codigo DESC");
                  $menu6 = "<select name='directiva4' id='directiva4' class='form-control select2' onchange='trae_directiva();'>";
                  $i = 1;
                  $menu6 .= "\n<option value='0'>- SELECCIONAR -</option>";
                  while($i<$row=odbc_fetch_array($menu6_6))
                  {
                    $nombre = trim(utf8_encode($row['nombre']));
                    $menu6 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  $menu6 .= "\n</select>";
                  echo $menu6;
                  ?>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Aplica Tipo</font></label>
                  <select name="tipod" id="tipod" class="form-control select2" onchange="trae_tipo();">
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Niveles GAO</font></label>
                  <input type="hidden" name="valor0d" id="valor0d" class="form-control numero" value="0" readonly="readonly">
                  <input type="text" name="valor1d" id="valor1d" class="form-control numero" value="0">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Niveles GDO</font></label>
                  <input type="text" name="valor2d" id="valor2d" class="form-control numero" value="0">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <input type="button" name="aceptar3" id="aceptar3" value="Crear">
                  <input type="button" name="actualiza3" id="actualiza3" value="Actualizar">
                </div>
              </div>
              <br>
              <hr>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Directiva Ministerial Permanente</font></label>
                  <?php
                  $menu7_7 = odbc_exec($conexion,"SELECT * FROM cx_ctr_dir ORDER BY codigo DESC");
                  $menu7 = "<select name='directiva' id='directiva' class='form-control select2' onchange='campos();'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu7_7))
                  {
                    $nombre = trim(utf8_encode($row['nombre']));
                    $menu7 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  $menu7 .= "\n</select>";
                  echo $menu7;
                  ?>
                  <input type="hidden" name="niveles" id="niveles" class="form-control numero" value="0" readonly="readonly">
                  <input type="hidden" name="contador" id="contador" class="form-control numero" value="1" readonly="readonly">
                  <input type="hidden" name="contador1" id="contador1" class="form-control numero" value="0" readonly="readonly">
                </div>
                <div id="tipo1">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Tipo</font></label>
                    <select name="tipo" id="tipo" class="form-control select2" onchange="campos();">
                      <option value="1">GAO - GAOML</option>
                      <option value="2">GDO</option>
                    </select>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <div id="add_form">
                    <table align="left" width="30%" border="0">
                      <tr>
                        <td height="35" width="25%"><center><b>Nivel</b></center></td>
                        <td height="35" width="35%"><center><b>A partir de</b></center></td>
                        <td height="35" width="35%"><center><b>Hasta</b></center></td>
                        <td height="35" width="5%"><center>&nbsp;</center></td>
                      </tr>
                    </table>
                  </div>
                  <br>
                  <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0"></a>
                  <br><br>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <table align="left" width="30%" border="0">
                    <tr>
                      <td>
                        <center>
                          <input type="button" name="actualiza2" id="actualiza2" value="Actualizar">
                        </center>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </form>
            <div id="dialogo2"></div>
            <div id="dialogo3"></div>
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
  $("#load1").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 220,
    width: 410,
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
        nuevo1();
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
        nuevo2();
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
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta1);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").hide();
  $("#actualiza1").button();
  $("#actualiza1").click(actualiza1);
  $("#actualiza1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza1").hide();
  $("#actualiza2").button();
  $("#actualiza2").click(actualiza2);
  $("#actualiza2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").button();
  $("#aceptar3").click(pregunta2);
  $("#aceptar3").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  //$("#aceptar3").hide();
  $("#actualiza3").button();
  $("#actualiza3").click(actualiza3);
  $("#actualiza3").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualiza3").hide();
  $("#valor").maskMoney();
  $("#valor1").maskMoney();
  $("#valor2").maskMoney();
  $("#valor4").maskMoney();
  $("#valor6").maskMoney();
  $("#valor8").maskMoney();
  $("#valor1d").focus(function(){
    this.select();
  });
  $("#valor2d").focus(function(){
    this.select();
  });
  trae_ano();
  trae_directiva();
  trae_material();
  $("#filtro").keyup(trae_material1);
  $("#material").focus();
  var MaxInputs       = 999;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      FieldCount++;
      var contador = $("#contador").val();
      $("#add_form table").append('<tr><td width="25%" class="espacio2"><select name="niv_'+z+'" id="niv_'+z+'" class="form-control select2"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option></select></td><td width="35%" class="espacio2"><input type="text" name="min_'+z+'" id="min_'+z+'" value="0" class="form-control numero" onkeypress="return check(event);"></td><td width="35%" class="espacio2"><input type="text" name="max_'+z+'" id="max_'+z+'" value="0" class="form-control numero" onkeypress="return check(event);"></td><td width="5%"><div id="men_'+z+'"><a href="#" class="removeclass" name="del_'+z+'" id="del_'+z+'"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      x_1++;
      $("#niv_"+z).val(contador);
      contador ++;
      $("#contador").val(contador);
      $("#contador1").val(z);
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    if(x_1 > 1)
    {
      $(this).closest('tr').remove();
    }
    return false;
  });
  $("#add_field").hide();
  $("#tipo1").hide();
  campos();
});
function trae_ano()
{
  $("#ano1").html('');
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
      $("#ano1").append(salida);
      trae_salario();
      $("#actualiza1").show();
    }
  });
}
function trae_ano1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_ano1.php",
    data:
    {
      ano: $("#ano").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "0")
      {
        $("#ano1").prop("disabled", true);
        $("#valor2").prop("disabled", false);
        $("#valor4").prop("disabled", false);
        $("#valor6").prop("disabled", false);
        $("#valor8").prop("disabled", false);
        $("#valor2").focus();
        $("#aceptar1").show();
        $("#actualiza1").hide();
      }
      else
      {
        var detalle = "<br><h2><center>Año Ya Registrado</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
        $("#ano1").prop("disabled", true);
        $("#valor2").prop("disabled", true);
        $("#valor4").prop("disabled", true);
        $("#valor6").prop("disabled", true);
        $("#valor8").prop("disabled", true);
        $("#aceptar1").hide();
        $("#actualiza1").hide();
      }
    }
  });
}
function trae_salario()
{
  $("#valor2").val('0.00');
  $("#valor4").val('0.00');
  $("#valor6").val('0.00');
  $("#valor8").val('0.00');
  paso_val();
  paso_val1();
  paso_val2();
  paso_val3();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_salario.php",
    data:
    {
      ano: $("#ano1").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salario = registros.salario;
      if (salario == "0")
      {
        salario = "0.00";
      }
      salario = salario.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#valor2").val(salario);
      paso_val();
      var tarifa1 = registros.tarifa1;
      if (tarifa1 == "0")
      {
        tarifa1 = "0.00";
      }
      tarifa1 = tarifa1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#valor4").val(tarifa1);
      paso_val1();
      var tarifa2 = registros.tarifa2;
      if (tarifa2 == "0")
      {
        tarifa2 = "0.00";
      }
      tarifa2 = tarifa2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#valor6").val(tarifa2);
      paso_val2();
      var tarifa3 = registros.tarifa3;
      if (tarifa3 == "0")
      {
        tarifa3 = "0.00";
      }
      tarifa3 = tarifa3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#valor8").val(tarifa3);
      paso_val3();
    }
  });
}
function trae_directiva()
{
  var directiva = $("#directiva4").val();
  if (directiva == "0")
  {
    $("#tipod").val('0');
    $("#valor0d").val('0');
    $("#valor1d").val('0');
    $("#valor2d").val('0');
    $("#tipod").prop("disabled",true);
    $("#valor1d").prop("disabled",true);
    $("#valor2d").prop("disabled",true);
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_directiva.php",
      data:
      {
        directiva: directiva
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        var conse = registros.conse;
        var nombre = registros.nombre;
        var tipo = registros.tipo;
        var valor1 = registros.valor1;
        var valor2 = registros.valor2;
        $("#directiva3").val(nombre);
        $("#tipod").val(tipo);
        $("#valor0d").val(conse);
        $("#valor1d").val(valor1);
        $("#valor2d").val(valor2);
        $("#aceptar3").hide();
        $("#actualiza3").show();
        $("#tipod").prop("disabled",false);
        $("#valor1d").prop("disabled",false);
        $("#valor2d").prop("disabled",false);
      }
    });
  }
}
function trae_tipo()
{
  var conse = $("#valor0d").val();
  var tipo = $("#tipod").val();
  if (tipo == "0")
  {
    $("#valor1d").val('0');
    $("#valor2d").val('0');
  }
  if (conse == "0")
  {
    $("#valor1d").prop("disabled",false);
    $("#valor2d").prop("disabled",false);
  }
}
function trae_material()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_mate.php",
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
      $("#tabla3").html('');
      $("#resultados4").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='65%' height='35'><font size='2'><b>Material</b></font></td><td width='15%' height='35'><center><font size='2'><b>Valor</b></font></center></td><td width='15%' height='35'><center><font size='2'><b>Tope M&aacute;ximo</b></font></center></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.unidad+'\",\"'+value.valor+'\",\"'+value.valor1+'\",\"'+value.porcen+'\",\"'+value.directiva+'\"';
        salida2 += "<tr><td width='65%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='15%' align='right' height='35'>"+value.valor+"</td>";
        salida2 += "<td width='15%' align='right' height='35'>"+value.valor1+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu("+paso+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados4").append(salida2);
    }
  });
}
function trae_material1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_mate1.php",
    data:
    {
      nombre: $("#filtro").val(),
      directiva: $("#directiva2").val()
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
      $("#tabla3").html('');
      $("#resultados4").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<br><table width='100%' align='center' border='0'><tr><td width='65%' height='35'><font size='2'><b>Material</b></font></td><td width='15%' height='35'><center><font size='2'><b>Valor</b></font></center></td><td width='15%' height='35'><center><font size='2'><b>Tope M&aacute;ximo</b></font></center></td><td width='5%' height='35'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.codigo+'\",\"'+value.nombre+'\",\"'+value.unidad+'\",\"'+value.valor+'\",\"'+value.valor1+'\",\"'+value.porcen+'\",\"'+value.directiva+'\"';
        salida2 += "<tr><td width='65%' height='35'>"+value.nombre+"</td>";
        salida2 += "<td width='15%' align='right' height='35'>"+value.valor+"</td>";
        salida2 += "<td width='15%' align='right' height='35'>"+value.valor1+"</td>";
        salida2 += "<td width='5%' height='35'><center><a href='#' onclick='actu("+paso+")'><img src='imagenes/editar.png' width='20' height='20' border='0' title='Modificar'></a></center></td></tr>";
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados4").append(salida2);
    }
  });
}
function campos()
{
  $("#contador").val('1');
  var directiva = $("#directiva").val();
  var tipo = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_directiva.php",
    data:
    {
      directiva: directiva
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var conse = registros.conse;
      var nombre = registros.nombre;
      var tipo1 = registros.tipo;
      var valor1 = registros.valor1;
      var valor2 = registros.valor2;
      var v_niveles = 0;
      if (tipo == "1")
      {
        v_niveles = valor1;
      }
      else
      {
        v_niveles = valor2;
      }
      if (tipo1 == "0")
      {
        $("#tipo1").hide();
      }
      else
      {
        $("#tipo1").show();
      }
      $("#niveles").val(v_niveles);
      for (var i=0; i<999; i++)
      {
        $("#del_"+i).click();
      }
      for (var i=0; i<v_niveles; i++)
      {
        $("#add_field").click();
      }
      cargar(v_niveles);
    }
  });
}
function cargar(valor)
{
  var valor;
  var valor1 = valor-1;
  var directiva = $("#directiva").val();
  var tipo = $("#tipo").val();
  var contador = $("#contador1").val();
  contador = contador-valor1;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_nivel.php",
    data:
    {
      directiva: directiva,
      tipo: tipo
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
      var registros = JSON.parse(data);
      var datos = registros.datos;
      var var_ocu = datos.split('#');
      var var_ocu1 = var_ocu.length;      
      var paso = "";
      j = contador;
      k = 1;
      for (var i=0; i<valor; i++)
      {
        if (datos == "")
        {
          var v1 = k;
          var v2 = 0;
          var v3 = 0;
        }
        else
        {
          paso = var_ocu[i];
          paso = paso.trim();
          var var_ocu2 = paso.split('|');
          var v1 = var_ocu2[0];
          var v2 = var_ocu2[1];
          var v3 = var_ocu2[2];
        }
        v1 = parseInt(v1);
        $("#niv_"+j).val(v1);
        $("#min_"+j).val(v2);
        $("#max_"+j).val(v3);
        j++;
        k++;
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
function pregunta1()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo2").html(detalle);
  $("#dialogo2").dialog("open");
  $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta2()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo3").html(detalle);
  $("#dialogo3").dialog("open");
  $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function paso_val()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('valor2').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#valor3").val(valor1);
}
function paso_val1()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('valor4').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#valor5").val(valor1);
}
function paso_val2()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('valor6').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#valor7").val(valor1);
}
function paso_val3()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('valor8').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#valor9").val(valor1);
}
function validacionData()
{
  var salida = true, detalle = '';
  var valor = $("#material").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Descripción del Material</h3></center>";
  }
  if ($("#valor").val() == '0.00')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Valor del Material</h3></center>";
  }
  var porcen = $("#porcen").val();
  porcen = porcen.trim();
  porcen = parseFloat(porcen);
  if (porcen > 100)
  {
    salida = false;
    detalle += "<center><h3>Porcentaje supera el 100%</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
  }
  else
  {
    nuevo();
  }
}
function val_direc()
{
  var conse = $("#valor0d").val();
  var valor = $("#directiva3").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
  }
  else
  {
    if (conse == "0")
    {
      $("#tipod").prop("disabled",false);
    }
  }
}
function nuevo()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "mate_grab.php",
    data:
    {
      material: $("#material").val(),
      unidad: $("#unidad").val(),
      valor: $("#valor").val(),
      valor1: $("#valor1").val(),
      porcen: $("#porcen").val(),
      directiva: $("#directiva1").val()
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
        $("#material").val('');
        $("#unidad").val('1');
        $("#valor").val('0.00');
        $("#valor1").val('0.00');
        $("#porcen").val('0.00');
        $("#directiva1").val('1');
        trae_material();
        $("#material").focus();
      }
      else
      {
        detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
      }
    }
  });
}
function actu(valor, valor1, valor2, valor3, valor4, valor5, valor6)
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6;
  var text = String.fromCharCode(13);
  var var_ocu = valor1.split('<br>');
  var var_ocu1 = var_ocu.length;
  for (var i=0; i<var_ocu1; i++)
  {
    valor1 = valor1.replace("<br>", text);
  }
  $("#conse").val(valor);
  $("#material").val(valor1);
  $("#unidad").val(valor2);
  $("#valor").val(valor3);
  $("#valor1").val(valor4);
  $("#porcen").val(valor5);
  $("#directiva1").val(valor6);
  $("#aceptar").hide();
  $("#actualiza").show();
}
function actualiza()
{
  var salida = true, detalle = '';
  var porcen = $("#porcen").val();
  porcen = porcen.trim();
  porcen = parseFloat(porcen);
  if (porcen > 100)
  {
    salida = false;
    detalle += "<center><h3>Porcentaje supera el 100%</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "mate_actu.php",
      data:
      {
        conse: $("#conse").val(),
        material: $("#material").val(),
        unidad: $("#unidad").val(),
        valor: $("#valor").val(),
        valor1: $("#valor1").val(),
        porcen: $("#porcen").val(),
        directiva: $("#directiva1").val()
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
          $("#material").val('');
          $("#unidad").val('1');
          $("#valor").val('0.00');
          $("#valor1").val('0.00');
          $("#porcen").val('0.00');
          $("#directiva1").val('1');
          trae_material();
          $("#material").focus();
          $("#aceptar").show();
          $("#actualiza").hide();
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
        }
      }
    });
  }
}
function nuevo1()
{
  var tipo = "0";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "salario_grab.php",
    data:
    {
      ano: $("#ano").val(),
      salario: $("#valor3").val(),
      tarifa1: $("#valor5").val(),
      tarifa2: $("#valor7").val(),
      tarifa3: $("#valor9").val(),
      tipo: tipo
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
      if (salida == "1")
      {
        $("#ano1").prop("disabled",true);
        $("#ano").prop("disabled",true);
        $("#valor2").prop("disabled",true);
        $("#valor4").prop("disabled",true);
        $("#valor6").prop("disabled",true);
        $("#valor8").prop("disabled",true);
        $("#aceptar1").hide();
        $("#actualiza1").hide();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
      }
    }
  });
}
function actualiza1()
{
  var salida = true, detalle = '';
  var ano = $("#ano1").val();
  var salario = $("#valor3").val();
  salario = parseFloat(salario);
  if (salario == "0")
  {
    salida = false;
    detalle += "<center><h3>Salario No Válido</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
  }
  else
  {
    var tipo = "1";
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "salario_grab.php",
      data:
      {
        ano: $("#ano1").val(),
        salario: $("#valor3").val(),
        tarifa1: $("#valor5").val(),
        tarifa2: $("#valor7").val(),
        tarifa3: $("#valor9").val(),
        tipo: tipo
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
        if (salida == "1")
        {
          $("#ano1").prop("disabled",true);
          $("#valor2").prop("disabled",true);
          $("#valor4").prop("disabled",true);
          $("#valor6").prop("disabled",true);
          $("#valor8").prop("disabled",true);
          $("#aceptar1").hide();
          $("#actualiza1").hide();
        }
        else
        {
          var detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
        }
      }
    });
  }
}
function actualiza2()
{
  var directiva = $("#directiva").val();
  var niveles = $("#niveles").val();
  var tipo = $("#tipo").val();
  var contador = $("#contador1").val();
  contador = contador-niveles;
  var j = contador+1;
  var datos = "";
  for (var i=0; i<niveles; i++)
  {
    var v1 = $("#niv_"+j).val();
    var v2 = $("#min_"+j).val();
    var v3 = $("#max_"+j).val();
    datos += v1+"|"+v2+"|"+v3+"|#";
    j++;
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "niv_grab.php",
    data:
    {
      directiva: directiva,
      niveles: niveles,
      tipo: tipo,
      datos: datos
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
      if (salida == "1")
      {
        j = 1;
        for (var i=0; i<niveles; i++)
        {
          $("#niv_"+j).prop("disabled",true);
          $("#min_"+j).prop("disabled",true);
          $("#max_"+j).prop("disabled",true);
          $("#men_"+j).hide();
          j++;
        }
        $("#actualiza2").hide();
        $("#tipo").prop("disabled",true);
        $("#directiva").prop("disabled",true);
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
      }
    }
  });
}
function nuevo2()
{
  var tipo = "0";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "directiva_grab.php",
    data:
    {
      conse: $("#valor0d").val(),
      tipod: $("#tipod").val(),
      nombre: $("#directiva3").val(),
      valor1: $("#valor1d").val(),
      valor2: $("#valor2d").val(),
      tipo: tipo
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
      if (salida == "1")
      {
        $("#directiva3").prop("disabled",true);
        $("#directiva4").prop("disabled",true);
        $("#tipod").prop("disabled",true);
        $("#valor1d").prop("disabled",true);
        $("#valor2d").prop("disabled",true);
        $("#aceptar3").hide();
        $("#actualiza3").hide();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
      }
    }
  });
}
function actualiza3()
{
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "directiva_grab.php",
    data:
    {
      conse: $("#valor0d").val(),
      tipod: $("#tipod").val(),
      nombre: $("#directiva3").val(),
      valor1: $("#valor1d").val(),
      valor2: $("#valor2d").val(),
      tipo: tipo
    },
    beforeSend: function ()
    {
      $("#load1").show();
    },
    error: function ()
    {
      $("#load1").hide();
    },
    success: function (data)
    {
      $("#load1").hide();
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        $("#directiva3").prop("disabled", true);
        $("#directiva4").prop("disabled", true);
        $("#tipod").prop("disabled", true);
        $("#valor1d").prop("disabled", true);
        $("#valor2d").prop("disabled", true);
        $("#aceptar3").hide();
        $("#actualiza3").hide();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest(".ui-dialog").find(".ui-dialog-titlebar-close").hide();
      }
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
// 05/12/2024 - Ajuste grabacion valores planilla
// 21/03/2028 - Ajuste inclusion nueva directiva
// 11/04/2025 - Ajuste inclusion directiva desde tabla ordenada por ultima
// 11/04/2025 - Ajuste grabacion y actualizacion informacion directivas
// 21/04/2025 - Ajuste cargue configuracion niveles
?>