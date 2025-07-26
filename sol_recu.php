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
  $fecha = date('Y/m/d');
  $ano = date('Y');
  $mes = date('m');
  $mes = intval($mes);
  $verifica = time();
  $alea = strtoupper(md5($verifica));
  $alea = substr($alea,0,10);
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
<body style="overflow-x:hidden; overflow-y:hidden;">
<?php
include('titulo.php');
?>
<div>
  <section class="content-header">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="soportes">
          <!--
          <h3>Solicitud de Recursos</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <br>
                  <input type="button" name="aceptar" id="aceptar" value="Continuar" tabindex="3">
                </div>
              </div>
            </form>
          </div>
          -->
          <h3>Carpeta Unica</h3>
          <div>
            <div id="load1">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <div class="row">
              <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                <label><font face="Verdana" size="2">Tipo de Consulta</font></label>
                <select name="tipo" id="tipo" class="form-control select2">
                  <option value="3">TODOS</option>
                  <option value="1">PLAN DE INVERSION</option>
                  <option value="2">SOLICITUD DE RECURSOS</option>
                </select>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Fecha</font></label>
                <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">&nbsp;</font></label>
                <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <br>
                <center>
                  <input type="button" name="consultar" id="consultar" value="Consultar">
                </center>
              </div>
            </div>
            <br>
            <div id="tabla10"></div>
            <div id="resultados5"></div>
            <form name="formu1" method="post" target="_blank">
              <input type="hidden" name="plan_conse" id="plan_conse" readonly="readonly">
              <input type="hidden" name="plan_ano" id="plan_ano" readonly="readonly">
              <input type="hidden" name="plan_tipo" id="plan_tipo" readonly="readonly">
              <input type="hidden" name="plan_ajust" id="plan_ajust" readonly="readonly">
              <input type="hidden" name="plan_interno" id="plan_interno" readonly="readonly">
              <input type="hidden" name="plan_unidad" id="plan_unidad" readonly="readonly">
              <input type="hidden" name="plan_sigla" id="plan_sigla" readonly="readonly">
              <input type="hidden" name="plan_periodo" id="plan_periodo" readonly="readonly">
              <input type="hidden" name="comp_tipo" id="comp_tipo" readonly="readonly">
              <input type="hidden" name="comp_conse" id="comp_conse" readonly="readonly">
              <input type="hidden" name="comp_ano" id="comp_ano" readonly="readonly">
              <input type="hidden" name="comp_uni" id="comp_uni" readonly="readonly">
            </form>
            <form name="formu2" action="ver_info.php" method="post" target="_blank">
              <input type="hidden" name="paso_url" id="paso_url" class="form-control" readonly="readonly">
            </form>
            <br>
          </div>
        </div>
      </div>
      <div id="dialogo"></div>
      <div id="dialogo1"></div>
      <input type="hidden" name="url" id="url" class="form-control" value="<?php echo $url; ?>" readonly="readonly">
      <input type="hidden" name="ruta" id="ruta" class="form-control" value="<?php echo $ruta_local; ?>" readonly="readonly">
      <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly">
      <input type="hidden" name="carpeta" id="carpeta" class="form-control fecha" value="<?php echo $alea; ?>" readonly="readonly">
    </div>
  </section>
</div>
<script src="js/jquery.quicksearch.js?1.0.0" type="text/javascript"></script>
<script src="version2/js/file-explore.js"></script> 
<script src="version2/js/flstBubble-min.js"></script>
<link rel="stylesheet" href="version2/css/blue-theme.css">
<link rel="stylesheet" href="version2/fontawesome/css/all.css">
<style>
.ui-widget-header
{
  color: #000000;
  font-weight: bold;
}
.container
{
  margin-top: 5px;
  margin-bottom: 5px;
  margin-left: 0px;
  max-width: 450px;
}
.file-list, .file-list ul
{
  list-style-type: none;
  font-size: 1em;
  line-height: 1.8em;
  margin-left: 20px;
  padding-left: 18px;
  border-left: 1px dotted #aaa;
}
.file-list li
{
  position: relative;
  padding-left: 25px;
}
.file-list li a
{
  text-decoration: none;
  color: #444;  
}
.file-list li a:before
{
  display: block;
  content: " ";
  width: 10px;
  height: 1px;
  position: absolute;
  border-bottom: 1px dotted #aaa;
  top: .6em;
  left: -14px;
}
.file-list li:before
{
  list-style-type: none;
  font-family: FontAwesome;
  display: block;
  content: '\f0f6';
  position: absolute;
  top: 0px;
  left: 0px;
  width: 20px;
  height: 20px;
  font-size: 1.3em;
  color: #555;
}
.file-list .folder-root
{
  list-style-type: none;
}
.file-list .folder-root a
{
  text-decoration: none;
}
.file-list .folder-root:before
{
  color: #FFD04E;
  content: "\f07b";
}
.file-list .folder-root.open:before
{
  content: "\f07c";
}
li.folder-root ul
{
  transition: all .3s ease-in-out;
  overflow: hidden;
}
li.folder-root.closed>ul
{
  opacity: 0;
  max-height: 0px;
}
li.folder-root.open>ul
{
  opacity: 1;
  display: block;
  max-height: 1000px;
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
      $("#fecha2").prop("disabled", false);
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
  $("#load1").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
    width: 380,
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
  //$(".file-tree").filetree();
  $("#carpeta").flstBubble({ id:'newId', duration:100 });

  //$("#fecha1, #fecha2").flstBubble({ id:'newId', duration:100 });

  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });


  //$("#aceptar").button();
  //$("#aceptar").click(tabla);
  //$("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  //trae_ano();
  //$("#periodo").val('<?php //echo $mes; ?>');
  //$("#ano").val('<?php //echo $ano; ?>');

  $("#consultar").mousedown(function(event) {
    switch (event.which)
    {
      case 3:
        envia_codigo();
        break;
      default:
        break;
    }
  });

});
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
function consultar()
{
  var super1 = $("#super").val();
  var salida = true;
  if (super1 == "1")
  {
    var fecha2 = $("#fecha2").val();
    if (fecha2 == "")
    {
      salida = false;
      alerta("Debe seleccionar fecha final");
    }
    var fecha1 = $("#fecha1").val();
    if (fecha1 == "")
    {
      salida = false;
      alerta("Debe seleccionar fecha inicial");
    }
  }
  if (salida == false)
  {
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "soli_consu2.php",
      data:
      {
        tipo: $("#tipo").val(),
        fecha1: $("#fecha1").val(),
        fecha2: $("#fecha2").val()
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
        $("#tabla10").html('');
        $("#resultados5").html('');
        var registros = JSON.parse(data);
        var total = registros.total;
        var salida1 = "";
        var salida2 = "";
        listareg = [];
        salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+total+" )</b></td></tr></table><br>";
        salida1 += "<div class='row'><div class='col col-lg-3 col-sm-3 col-md-3 col-xs-3'><input type='text' name='buscar' id='buscar' placeholder='Buscar...' class='form-control' autocomplete='off' /></div><div class='col col-lg-8 col-sm-8 col-md-8 col-xs-8'></div></div>";
        salida1 += "<br>";
        $.each(registros.rows, function (index, value)
        {
          if (index == "0")
          {
            salida2 += "<table width='100%' align='center' border='0'><tr><td height='35' width='10%'><b>No.</b></td><td height='35' width='10%'><b>Fecha</b></td><td height='35' width='10%'><b>Usuario</b></td><td height='35' width='10%'><b>Unidad</b></td><td height='35' width='10%'><b>Tipo</b></td><td height='35' width='3%'><b>&nbsp;</b></td><td height='35' width='47%'><b>&nbsp;</b></td></td></tr></table>";
            salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
          }
          var datos = '\"'+value.conse+'\",\"'+value.unidad+'\",\"'+value.sigla+'\",\"'+value.ano+'\",\"'+index+'\"';
          var datos1 = '\"1\",'+datos;
          var datos2 = '\"2\",'+datos;
          var datos3 = '\"3\",'+datos;
          var datos4 = '\"4\",'+datos;
          // Carpeta
          var carpeta = "<div class='container'>";
          carpeta += "<ul class='file-tree'>";
          carpeta += "<li>";
          carpeta += "<a href='#'>"+value.conse+"</a>";
          carpeta += "<ul>";
          carpeta += "<li><a href='#' onclick='highlightText2("+index+",5); traer("+datos1+"); return false;'>Anexos</a><ul><div id='an_"+index+"'></div></ul></li>";
          carpeta += "<li><a href='#' onclick='highlightText2("+index+",5); traer("+datos2+"); return false;'>Planilla de Gastos</a><ul><div id='pl_"+index+"'></div></ul></li>";
          carpeta += "<li><a href='#' onclick='highlightText2("+index+",5); traer("+datos3+"); return false;'>Informe de Gastos</a><ul><div id='in_"+index+"'></div></ul></li>";
          carpeta += "<li><a href='#' onclick='highlightText2("+index+",5); traer("+datos4+"); return false;'>Comprobante de Egreso</a><ul><div id='eg_"+index+"'></div></ul></li>";
          carpeta += "</ul>";
          carpeta += "</li>";
          carpeta += "</ul>";
          carpeta += "</div>";
          // Fin Carpeta
          salida2 += "<tr>";
          salida2 += "<td width='10%' height='35' id='l1_"+index+"'>"+value.conse+"</td>";
          salida2 += "<td width='10%' height='35' id='l2_"+index+"'>"+value.fecha+"</td>";
          salida2 += "<td width='10%' height='35' id='l3_"+index+"'>"+value.usuario+"</td>";
          salida2 += "<td width='10%' height='35' id='l4_"+index+"'>"+value.sigla+"</td>";
          salida2 += "<td width='10%' height='35' id='l5_"+index+"'>"+value.tipo+"</td>";
          salida2 += "<td width='3%' height='35' id='l6_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",5); link("+value.conse+","+value.ano+","+value.tipo1+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td>";
          salida2 += "<td width='57%' height='35' id='l7_"+index+"'>"+carpeta+"</td>";
          salida2 += "</tr>";
          listareg.push(index);
        });
        salida2 += "</table>";
        $("#tabla10").append(salida1);
        $("#resultados5").append(salida2);
        $(".file-tree").filetree();
        $("#buscar").quicksearch("table tbody tr");
      }
    });
  }
}
function link(valor, ano, tipo)
{
  var valor;
  var ano;
  var tipo;
  var ajuste = 0;
  $("#plan_conse").val(valor);
  $("#plan_ano").val(ano);
  $("#plan_tipo").val(tipo);
  $("#plan_ajust").val(ajuste);
  formu1.action = "ver_plan.php";
  formu1.submit();
}
function traer(tipo, conse, unidad, sigla, ano, index)
{
  var tipo, conse, unidad, sigla, ano, index;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "soli_consu3.php",
    data:
    {
      tipo: tipo,
      conse: conse,
      unidad: unidad,
      sigla: sigla,
      ano: ano
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
      var total = registros.total;
      var salida1 = "";
      if (tipo == "1")
      {
        var salida = registros.salida;
        if (total > 0)
        {
          var var_ocu = salida.split('|');
          var var_ocu1 = var_ocu.length;
          for (var i=0; i<var_ocu1-1; i++)
          {
            var datos = '\"'+conse+'\",\"'+ano+'\",\"'+var_ocu[i]+'\"';
            salida1 += "<li><a href='#' onclick='traer1("+datos+"); return false;'>"+var_ocu[i]+"</a></li>";
          }
        }
        else
        {
          alerta("Sin Anexos Cargados");
        }
      }
      else
      {
        //var nom = "";
        if (total > 0)
        {
          /*
          if (tipo == "2")
          {
            nom = "pl1";
          }
          if (tipo == "3")
          {
            nom = "in1";
          }
          */
          //<ul><div id='"+nom+"_"+index+"'></div></ul>
          $.each(registros.rows, function (index, value)
          {
            var datos = '\"'+tipo+'\",\"'+value.conse+'\",\"'+value.interno+'\",\"'+unidad+'\",\"'+sigla+'\",\"'+ano+'\",\"'+value.tipo+'\",\"'+value.periodo+'\",\"'+value.unidad+'\"';
            salida1 += "<li><a href='#' onclick='traer2("+datos+"); return false;'>"+value.conse+" - "+value.fecha+" - "+value.total+"</a></li>";
          });
        }
        else
        {
          if (tipo == "2")
          {
            var tipo1 = "Sin Planillas Elaboradas";
          }
          if (tipo == "3")
          {
            var tipo1 = "Sin Informes Elaborados";
          }
          if (tipo == "4")
          {
            var tipo1 = "Sin Comprobantes de Egreso Elaborado";
          }
          alerta(tipo1);
        }
      }
      if (tipo == "1")
      {
        $("#an_"+index).html('');
        $("#an_"+index).append(salida1);
      }
      if (tipo == "2")
      {
        $("#pl_"+index).html('');
        $("#pl_"+index).append(salida1);
      }
      if (tipo == "3")
      {
        $("#in_"+index).html('');
        $("#in_"+index).append(salida1);
      }
      if (tipo == "4")
      {
        $("#eg_"+index).html('');
        $("#eg_"+index).append(salida1);
      }
    }
  });
}
function traer1(conse, ano, archivo)
{
  var conse, ano, archivo;
  var ruta = $("#ruta").val();
  var url = $("#url").val();
  var carpeta = url+"archivos/server/php/anexos/"+ano+"/"+conse;
  var descarga = "1";
  var url1 = "cxvisor1/Default?valor1="+ruta+"\\archivos\\server\\php\\anexos\\"+ano+"\\"+conse+"\\&valor2="+archivo+"&valor3="+carpeta+"&valor4="+descarga;
  $("#paso_url").val(url1);
  formu2.submit();
}
function traer2(tipo, conse, interno, unidad, sigla, ano, tipo1, periodo, unidad1)
{
  var tipo, conse, interno, unidad, sigla, ano;
  if (tipo == "2")
  {
    $("#plan_conse").val(conse);
    $("#plan_interno").val(interno);
    $("#plan_ano").val(ano);
    $("#plan_unidad").val(unidad);
    $("#plan_sigla").val(sigla);
    formu1.action = "ver_gast.php";
  }
  if (tipo == "3")
  {
    $("#plan_conse").val(conse);
    $("#plan_tipo").val(tipo1);
    $("#plan_ano").val(ano);
    $("#plan_periodo").val(periodo);
    $("#plan_unidad").val(unidad);
    $("#plan_sigla").val(sigla);
    formu1.action = "ver_rela.php";
  }

  if (tipo == "4")
  {
    $("#comp_tipo").val('2');
    $("#comp_conse").val(conse);
    $("#comp_ano").val(ano);
    $("#comp_uni").val(unidad1);
    formu1.action = "ver_comp.php";
  }
  formu1.submit();
}
function envia_codigo()
{
  var alea = $("#carpeta").val();
  var ruta = "https://www.cxcomputers.com/sms.php";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: ruta,
    data:
    {
      alea: alea
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var confirma = registros.salida;
      alerta2(alea);
      alerta1(confirma);
    }
  }); 
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
// 27/08/2024 - Ajuste consulta solicitudes carpeta tooltip - tree
?>