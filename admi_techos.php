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
  include('funciones.php');
  include('permisos.php');
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
  <script type="text/javascript" src="alertas/lib/alertify.js"></script>
  <link rel="stylesheet" href="alertas/themes/alertify.core.css">
  <link rel="stylesheet" href="alertas/themes/alertify.default.css">
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
          <h3>Administraci&oacute;n de Techos</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu1" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Concepto</font></label>
                  <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly">
                  <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly">
                  <input type="hidden" name="v_super" id="v_super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly">
                  <input type="hidden" name="v_paso1" id="v_paso1" class="form-control" value="" readonly="readonly">
                  <input type="hidden" name="v_paso2" id="v_paso2" class="form-control" value="" readonly="readonly">
                  <select name="concepto" id="concepto" class="form-control select2" onchange="trae_combustible();">
                    <option value="C">COMBUSTIBLE</option>
                    <option value="M">MANTENIMIENTO Y REPUESTOS</option>
                    <option value="L">LLANTAS</option>
                    <option value="T">RTM</option>
                  </select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Unidad</font></label>
                  <?php
                  $menu1_1 = odbc_exec($conexion,"SELECT unidad, dependencia, sigla FROM cx_org_sub WHERE unic='1' AND subdependencia!='301' ORDER BY sigla");
                  $menu1 = "<select name='centra' id='centra' class='form-control select2' onchange='valida();'>";
                  $i = 1;
                  $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
                  while($i<$row=odbc_fetch_array($menu1_1))
                  {
                    $unidad = $row['unidad'];
                    $dependencia = $row['dependencia'];
                    $valores = $unidad.",".$dependencia;
                    $nombre = trim($row['sigla']);
                    $menu1 .= "\n<option value=$valores>".$nombre."</option>";
                    $i++;
                  }
                  $menu1 .= "\n</select>";
                  echo $menu1;
                  ?>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">A&ntilde;o</font></label>
                  <select name="ano" id="ano" class="form-control select2"></select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <div id="add_form">
                    <table width="100%" border="0">
                      <tr>
                        <td width="13%">
                          <center><label><font face="Verdana" size="2">Tipo Veh&iacute;culo</font></label></center>
                        </td>
                        <td width="12%">
                          <center><label><font face="Verdana" size="2">Combustible</font></label></center>
                        </td>
                        <td width="15%">
                          <center><label><font face="Verdana" size="2">Asignaci&oacute;n Mensual</font></label></center>
                        </td>
                        <td width="10%">
                          <center><label><font face="Verdana" size="2">Cantidad</font></label></center>
                        </td>
                        <td width="15%">
                          <center><label><font face="Verdana" size="2">Asignaci&oacute;n Anual</font></label></center>
                        </td>
                        <td width="15%">
                          <center><label><font face="Verdana" size="2">Recurso Adicional CEDE2</font></label></center>
                        </td>
                        <td width="15%">
                          <center><label><font face="Verdana" size="2">Recurso Adicional CEDE4</font></label></center>
                        </td>
                        <td width="5%">
                          &nbsp;
                        </td>
                      </tr>
                    </table>
                  </div>
                  <div class="espacio1"></div>
                  <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0" title="Adicionar Valores"></a>
                  <input type="hidden" name="paso_vehiculos" id="paso_vehiculos" class="form-control" readonly="readonly">
                  <input type="hidden" name="v_consu" id="v_consu" class="form-control" value="0" readonly="readonly">
                </div>
              </div>
            </form>
            <br>
            <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
              <br>
              <center>
                <input type="button" name="aceptar" id="aceptar" value="Registrar">
                <input type="button" name="aceptar1" id="aceptar1" value="Nuevo">
              </center>
            </div>
            <br>
						<hr>
						<div class="row">
							<div class="col col-lg-3 col-sm-3 col-md-4 col-xs-4">
								<label><font face="Verdana" size="2">Filtro Concepto</font></label>
								<select name="concepto1" id="concepto1" class="form-control select2" onchange="techos(1);">
                  <option value="-">- SELECCIONAR -</option>
									<option value="C">COMBUSTIBLE</option>
									<option value="M">MANTENIMIENTO Y REPUESTOS</option>
									<option value="L">LLANTAS</option>
									<option value="T">RTM</option>
								</select>
							</div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">A&ntilde;o</font></label>
                <select name="ano1" id="ano1" class="form-control select2" onchange="techos(1);"></select>
              </div>
						</div>
						<br>
            <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
              <div id="res_techos"></div>
            </div>
            <form name="formu_excel" id="formu_excel" action="techos_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
            </form>
          </div>
          <div id="dialogo"></div>
          <div id="dialogo1"></div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
<script src="js/jquery.quicksearch.js?1.0.0" type="text/javascript"></script>
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
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 265,
    width: 610,
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
        validacion1();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  trae_vehiculos();
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(limpiar);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").hide();
  $("#add_field").hide();
  var MaxInputs       = 99;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      FieldCount++;
      var paso1 = $("#v_paso1").val();
      var paso2 = $("#v_paso2").val();
      $("#add_form table").append('<tr><td width="13%" class="espacio2"><select name="veh_'+z+'" id="veh_'+z+'" class="form-control"></select></td><td width="12%" class="espacio2"><select name="com_'+z+'" id="com_'+z+'" class="form-control" onblur="valida1('+z+')"></select></td><td width="12%" class="espacio2"><input type="text" name="val_'+z+'" id="val_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_valor('+z+'); calculo('+z+')" autocomplete="off"><input type="hidden" name="vap_'+z+'" id="vap_'+z+'" class="form-control numero" value="0" readonly="readonly"></td><td width="10%" class="espacio2"><input type="text" name="can_'+z+'" id="can_'+z+'" class="form-control numero" value="0" onkeypress="return check(event);" onkeyup="calculo('+z+');"></td><td width="12%" class="espacio2"><input type="text" name="vam_'+z+'" id="vam_'+z+'" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly"><input type="hidden" name="van_'+z+'" id="van_'+z+'" class="form-control numero" value="0" readonly="readonly"></td><td width="12%" class="espacio2"><input type="text" name="vaq_'+z+'" id="vaq_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_valor1('+z+');" autocomplete="off"><input type="hidden" name="var_'+z+'" id="var_'+z+'" class="form-control numero" value="0" readonly="readonly"></td><td width="12%" class="espacio2"><input type="text" name="vas_'+z+'" id="vas_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_valor2('+z+');" autocomplete="off"><input type="hidden" name="vat_'+z+'" id="vat_'+z+'" class="form-control numero" value="0" readonly="readonly"></td><td width="5%"><div id="men_'+z+'"><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0" id="del_'+z+'"></a></div></td></tr>');
      $("#veh_"+z).append(paso1);
      $("#com_"+z).append(paso2);
      $("#val_"+z).maskMoney();
      $("#val_"+z).on("paste", function(e){
        e.preventDefault();
        alerta("Acción No Permitida");
      });
      $("#vaq_"+z).maskMoney();
      $("#vaq_"+z).on("paste", function(e){
        e.preventDefault();
        alerta("Acción No Permitida");
      });
      $("#vas_"+z).maskMoney();
      $("#vas_"+z).on("paste", function(e){
        e.preventDefault();
        alerta("Acción No Permitida");
      });
      $("#can_"+z).focus(function(){
        this.select();
      });
      $("#veh_"+z).focus();
      $("#concepto").prop("disabled",true);
      $("#centra").prop("disabled",true);
      x_1++;
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
  trae_ano();
  $("#centra").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
});
function trae_ano()
{
  $("#ano").html('');
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
        if (ano >= 2024)
        {
          salida += "<option value='"+ano+"'>"+ano+"</option>";
        }
      }
      $("#ano").append(salida);
      $("#ano1").append(salida);
      techos(0);
    }
  });
}
function trae_vehiculos()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_vehi.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var j = 0;
      for (var i in registros) 
      {
        j = j+1;
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#v_paso1").val(salida);
      trae_combustible();
    }
  });
}
function trae_combustible()
{
  var concepto = $("#concepto").val();
  if (concepto == "C")
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_combus.php",
      success: function (data)
      {
        var registros = JSON.parse(data);
        var salida = "";
        var j = 0;
        for (var i in registros) 
        {
          j = j+1;
          var codigo = registros[i].codigo;
          var nombre = registros[i].nombre;
          salida += "<option value='"+codigo+"'>"+nombre+"</option>";
        }
        $("#v_paso2").val(salida);
      }
    });
  }
  else
  {
    var salida = "<option value='0'>N/A</option>";
    $("#v_paso2").val(salida);
  }
}
function paso_valor(valor)
{
  var valor, valor1;
  valor1 = document.getElementById('val_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vap_"+valor).val(valor1);
}
function paso_valor1(valor)
{
  var valor, valor1;
  valor1 = document.getElementById('vaq_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#var_"+valor).val(valor1);
}
function paso_valor2(valor)
{
  var valor, valor1;
  valor1 = document.getElementById('vas_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vat_"+valor).val(valor1);
}
function calculo(valor)
{
  var valor, valor1, valor2, valor3;
  var tipo = $("#concepto").val();
  valor1 = $("#vap_"+valor).val();
  valor2 = $("#can_"+valor).val();
  if (tipo == "C")
  {
    valor3 = (valor1*valor2)*12;
  }
  else
  {
    valor3 = valor1*valor2;
  }
  valor4 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#vam_"+valor).val(valor4);
  $("#van_"+valor).val(valor3);
}
function valida()
{
  var centra = $("#centra").val();
  if (centra == "-")
  {
    $("#add_field").hide();
  }
  else
  {
    $("#add_field").show();
  }
}
function valida1(valor)
{
  var valor;
  var salida = true;
  var tipos = [];
  for (i=1;i<50;i++)
  {
    if ($("#veh_"+i).length)
    {
      var vali_tip = $("#veh_"+i).val();
      var vali_com = $("#com_"+i).val();
      vali_tip = vali_tip+"_"+vali_com;
      if (vali_tip == null)
      {
        vali_tip = 0;
      }
      if (vali_tip == "0")
      {
      }
      else
      {
        if (jQuery.inArray(vali_tip, tipos) != -1)
        {
          salida = false;
        }
        else
        {
          tipos.push(vali_tip);
        }
      }
    }
  }
  $("#aceptar").show();
  if (salida == false)
  {
    alerta("Tipo de Vehículo ya incluido");
    $("#aceptar").hide();
  }
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function validacion1()
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7, valor8, valor9, valor10, valor11;
  var v_valor = 0;
  var v_canti = 0;
  var v_cede2 = 0;
  var v_cede4 = 0;
  var salida = true;
  var centra = $("#centra").val();
  $("#paso_vehiculos").val('');
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('veh_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux10 = document.formu1.elements[i].name;
    if (saux10.indexOf('com_')!=-1)
    {
      valor10 = document.getElementById(saux10).value;
    }
    saux1 = document.formu1.elements[i].name;
    if (saux1.indexOf('val_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu1.elements[i].name;
    if (saux2.indexOf('vap_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
    }
    saux3 = document.formu1.elements[i].name;
    if (saux3.indexOf('can_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
      valor3 = valor3.trim();
      if ((valor3 == "") || (valor3 == "0"))
      {
        v_canti ++;
      }
    }
    saux4 = document.formu1.elements[i].name;
    if (saux4.indexOf('vam_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
    }
    saux5 = document.formu1.elements[i].name;
    if (saux5.indexOf('van_')!=-1)
    {
      valor5 = document.getElementById(saux5).value;
    }
    saux6 = document.formu1.elements[i].name;
    if (saux6.indexOf('vaq_')!=-1)
    {
      valor6 = document.getElementById(saux6).value;
    }
    saux7 = document.formu1.elements[i].name;
    if (saux7.indexOf('var_')!=-1)
    {
      valor7 = document.getElementById(saux7).value;
    }
    saux8 = document.formu1.elements[i].name;
    if (saux8.indexOf('vas_')!=-1)
    {
      valor8 = document.getElementById(saux8).value;
    }
    saux9 = document.formu1.elements[i].name;
    if (saux9.indexOf('vat_')!=-1)
    {
      valor9 = document.getElementById(saux9).value;
      valor11 = valor+"»"+valor1+"»"+valor2+"»"+valor3+"»"+valor4+"»"+valor5+"»"+valor6+"»"+valor7+"»"+valor8+"»"+valor9+"»"+valor10+"»|";
      document.getElementById('paso_vehiculos').value = document.getElementById('paso_vehiculos').value+valor11;
    }
  }
  if (v_cede4 > 0)
  {
    salida = false;
    alerta("Debe ingresar "+v_cede4+" adicional(es) CEDE4");
  }
  if (v_cede2 > 0)
  {
    salida = false;
    alerta("Debe ingresar "+v_cede2+" adicional(es) CEDE2");
  }
  if (v_canti > 0)
  {
    salida = false;
    alerta("Debe seleccionar "+v_canti+" cantidad(es)");
  }
  if (v_valor > 0)
  {
    salida = false;
    alerta("Debe ingresar "+v_valor+" asignacion(es)");
  }
  if (centra == "-")
  {
    salida = false;
    alerta("Debe seleccionar una unidad");
  }
  if (salida == false)
  {
  }
  else
  {
    nuevo1();
  }
}
function nuevo1()
{
  var concepto = $("#concepto").val();
  var unidad = $("#centra").val();
  var ano = $("#ano").val();
  var sigla = $("#centra option:selected").html();
  var datos = $("#paso_vehiculos").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_grab3.php",
    data:
    {
      concepto: concepto,
      unidad: unidad,
      ano: ano,
      sigla: sigla,
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
        $("#aceptar").hide();
        $("#add_field").hide();
        $("#aceptar1").show();
        $("#concepto").prop("disabled",true);
        $("#centra").prop("disabled",true);
        for (i=0;i<document.formu1.elements.length;i++)
        {
          saux = document.formu1.elements[i].name;
          if (saux.indexOf('veh_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          saux = document.formu1.elements[i].name;
          if (saux.indexOf('com_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('val_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('can_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('vaq_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('vas_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        for (k=1;k<=20;k++)
        {
          if ($("#men_"+k).length)
          {
            $("#men_"+k).hide();
          }
        }
        techos(1);
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar").show();
      }
    }
  });
}
function limpiar()
{
  $("#aceptar").show();
  $("#aceptar1").hide();
  $("#concepto").prop("disabled",false);
  $("#centra").prop("disabled",false);
  $("#centra").val('-');
  for (k=1;k<=20;k++)
  {
    if ($("#del_"+k).length)
    {
      $("#del_"+k).click();
    }
  }
}
function techos(valor)
{
	var valor;
  var tipo = $("#v_consu").val();
  var concepto = $("#concepto1").val();
  var ano = $("#ano1").val();
  $("#res_techos").html('');
  $("#aceptar").hide();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tech_consu.php",
    data:
    {
      tipo: tipo,
      concepto: concepto,
      ano: ano,
      calculo: valor
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
      $("#res_techos").html('');
      var registros = JSON.parse(data);
      var tabla = registros.salida;
      var valores = registros.valores;
      $("#res_techos").append(tabla);
      $("#paso_excel").val(valores);
      $("#aceptar").show();
    }
  });
}
function modif(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tech_consu1.php",
    data:
    {
      conse: valor
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
      for (k=1;k<=20;k++)
      {
        if ($("#del_"+k).length)
        {
          $("#del_"+k).click();
        }
      }
      $("#concepto").val(registros.tipo);
      trae_combustible();
      var unidad = registros.unidad;
      var dependencia = registros.dependencia;
      var unidad1 = unidad+","+dependencia;
      $("#centra").val(unidad1);
      var datos = registros.datos;
      var var_ocu = datos.split('|');
      var var_ocu1 = var_ocu.length;
      var var_con = var_ocu1-1;
      var paso = "";
      var z = 1;
      for (var i=0; i<var_ocu1-1; i++)
      {
        paso = var_ocu[i];
        var var_ocu2 = paso.split('»');
        $("#add_field").click();
        var v1 = var_ocu2[0];
        var v2 = var_ocu2[1];
        var v3 = var_ocu2[2];
        var v4 = var_ocu2[3];
        var v5 = var_ocu2[4];
        var v6 = var_ocu2[5];
        var v7 = var_ocu2[6];
        var v8 = var_ocu2[7];
        var v9 = var_ocu2[8];
        var v10 = var_ocu2[9];
        var v11 = var_ocu2[10];
        $("#veh_"+z).val(v1);
        $("#val_"+z).val(v2);
        $("#vap_"+z).val(v3);
        $("#can_"+z).val(v4);
        $("#vam_"+z).val(v5);
        $("#van_"+z).val(v6);
        $("#vaq_"+z).val(v7);
        $("#var_"+z).val(v8);
        $("#vas_"+z).val(v9);
        $("#vat_"+z).val(v10);
        $("#com_"+z).val(v11);
        z++;
      }
      $("#add_field").show();
      $("#aceptar").show();
      $("#aceptar1").hide();
      $("#v_consu").val('1');
      techos(1);
    }
  });
}
function check(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function excel()
{
  formu_excel.submit();
}
function alerta(valor)
{
  alertify.error(valor);
}
function alerta1(valor)
{
  alertify.success(valor);
}
function alerta2(valor)
{
  alertify.log(valor);
}
</script>
</body>
</html>
<?php
}
// 08/05/2024 - Ajuste independizar modulo de techos del administrador
// 19/07/2024 - Ajuste calculos por inclusion de unidades que dependen de centralizadora
// 11/12/2024 - Ajuste inclusion filtro de año
// 05/05/2025 - Ajuste buscador campo unidad
?>