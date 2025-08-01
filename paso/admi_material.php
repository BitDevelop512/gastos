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
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
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
                  <select name="directiva1" id="directiva1" class="form-control select2" tabindex="5">
                    <option value="1">No. 01 del 17 de Febrero de 2009</option>
                    <option value="2">No. 21 del 5 de Julio de 2011</option>
                    <option value="3">No. 16 del 25 de Mayo de 2012</option>
                    <option value="4">No. 02 del 16 de Enero de 2019</option>
                  </select>
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
                  <select name="directiva2" id="directiva2" class="form-control select2" onchange="trae_material1();">
                    <option value="1">No. 01 del 17 de Febrero de 2009</option>
                    <option value="2">No. 21 del 5 de Julio de 2011</option>
                    <option value="3">No. 16 del 25 de Mayo de 2012</option>
                    <option value="4">No. 02 del 16 de Enero de 2019</option>
                  </select>
                </div>
              </div>
              <div id="espacio1"></div>
              <div id="tabla3"></div>
              <div id="resultados4"></div>
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
          </div>
          <h3>Creaci&oacute;n Niveles Recompensa</h3>
          <div>
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
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Salario</font></label>
                  <input type="text" name="valor2" id="valor2" class="form-control numero" value="0.00" onkeyup="paso_val();">
                  <input type="hidden" name="valor3" id="valor3" class="form-control numero" value="0">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <input type="button" name="aceptar1" id="aceptar1" value="Crear">
                  <input type="button" name="actualiza1" id="actualiza1" value="Actualizar">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Directiva Ministerial Permanente</font></label>
                  <select name="directiva" id="directiva" class="form-control select2" onchange="campos();">
                    <option value="1">No. 01 del 17 de Febrero de 2009</option>
                    <option value="2">No. 21 del 5 de Julio de 2011</option>
                    <option value="3">No. 16 del 25 de Mayo de 2012</option>
                    <option value="4">No. 02 del 16 de Enero de 2019</option>
                  </select>
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
  $("#valor").maskMoney();
  $("#valor1").maskMoney();
  $("#valor2").maskMoney();
  trae_ano();
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
        $("#valor2").focus();
        $("#aceptar1").show();
        $("#actualiza1").hide();
      }
      else
      {
        var detalle = "<br><h2><center>Año Ya Registrado</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#ano1").prop("disabled", true);
        $("#valor2").prop("disabled", true);
        $("#aceptar1").hide();
        $("#actualiza1").hide();
      }
    }
  });
}
function trae_salario()
{
  $("#valor2").val('0.00');
  paso_val();
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
    }
  });
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
  var niveles = 0;
  switch (directiva)
  {
    case '1':
      niveles = 5;
      break;
    case '2':
      niveles = 6;
      break;
    case '3':
      niveles = 7;
      break;
    case '4':
      if (tipo == "1")
      {
        niveles = 6;
      }
      else
      {
        niveles = 4;
      }
      break;
    default:
      niveles = 0;
      break;
  }
  $("#niveles").val(niveles);
  if (directiva == "4")
  {
    $("#tipo1").show();
  }
  else
  {
    $("#tipo1").hide();
  }
  for (var i=0; i<999; i++)
  {
    $("#del_"+i).click();
  }
  for (var i=0; i<niveles; i++)
  {
    $("#add_field").click();
  }
  cargar(niveles);
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
function paso_val()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('valor2').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#valor3").val(valor1);
}
function validacionData()
{
  var salida = true, detalle = '';
  var valor = $("#material").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Descripci&oacute;n del Material</h3></center>";
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
        $("#ano1").prop("disabled", true);
        $("#ano").prop("disabled", true);
        $("#valor2").prop("disabled", true);
        $("#aceptar1").hide();
        $("#actualiza1").hide();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
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
          $("#ano1").prop("disabled", true);
          $("#valor2").prop("disabled", true);
          $("#aceptar1").hide();
          $("#actualiza1").hide();
        }
        else
        {
          var detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
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
          $("#niv_"+j).prop("disabled", true);
          $("#min_"+j).prop("disabled", true);
          $("#max_"+j).prop("disabled", true);
          $("#men_"+j).hide();
          j++;
        }
        $("#actualiza2").hide();
        $("#tipo").prop("disabled", true);
        $("#directiva").prop("disabled", true);
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
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
?>