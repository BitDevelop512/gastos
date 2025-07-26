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
  $mes = date('m');
  $mes = intval($mes);
  $ano = date('Y');
  $minimo = $ano."/01/01";
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
          <h3>Consulta de Comprobantes</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo de Consulta</font></label>
                  <select name="tipo_c" id="tipo_c" class="form-control select2" tabindex="1">
                    <option value="1">COMPROBANTES INGRESO</option>
                    <option value="2">COMPROBANTES EGRESO</option>
                    <option value="3">DETALLADO COMPROBANTES EXCEL - SAP</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">&nbsp;</font></label>
                  <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                  <input type="hidden" name="paso1" id="paso1" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="paso2" id="paso2" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="paso3" id="paso3" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="paso4" id="paso4" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_mes" id="v_mes" class="form-control" value="<?php echo $mes; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_ano" id="v_ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="n_unidad" id="n_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly" tabindex="0">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Cuenta Bancaria</font></label>
                  <select name="cuenta" id="cuenta" class="form-control select2"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <center>
                    <input type="button" name="consultar" id="consultar" value="Consultar">
                  </center>
                </div>
              </div>
              <div id="lbl1">
                <br>
                <div class="row">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Unidad Centralizadora</font></label>
                    <?php
                    $menu1_1 = odbc_exec($conexion,"SELECT unidad, sigla FROM cx_org_sub WHERE unic='1' AND subdependencia!='301' ORDER BY sigla");
                    $menu1 = "<select name='centra' id='centra' class='form-control select2' onchange='busca();'>";
                    $i = 1;
                    $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
                    while($i<$row=odbc_fetch_array($menu1_1))
                    {
                      $nombre = trim($row['sigla']);
                      $menu1 .= "\n<option value=$row[unidad]>".$nombre."</option>";
                      $i++;
                    }
                    $menu1 .= "\n</select>";
                    echo $menu1;
                    ?>
                  </div>
                  <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7">
                    <label><font face="Verdana" size="2">Unidades:</font></label>
                    <select name="unidad" id="unidad" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas unidades"></select>
                  </div>
                </div>
              </div>
              <br>
              <div id="tabla3"></div>
              <div id="resultados5"></div>
            </form>
            <form name="formu1" action="ver_comp.php" method="post" target="_blank">
              <input type="hidden" name="comp_tipo" id="comp_tipo" readonly="readonly">
              <input type="hidden" name="comp_conse" id="comp_conse" readonly="readonly">
              <input type="hidden" name="comp_ano" id="comp_ano" readonly="readonly">
              <input type="hidden" name="comp_uni" id="comp_uni" readonly="readonly">
              <input type="hidden" name="comp_sig" id="comp_sig" readonly="readonly">
            </form>
            <form name="formu_excel" id="formu_excel" action="comprobantes_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
            </form>
          </div>
          <div id="dialogo"></div>
          <div id="dialogo1"></div>
          <!-- Cambiar Fecha -->
          <div id="dialogo2">
            <form name="formu2">
              <table width="98%" align="center" border="0">
                <tr>
                  <td>
                    <div class="row">
                      <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                        <label><font face="Verdana" size="2">Fecha Comprobante</font></label>
                        <input type="text" name="c_fecha" id="c_fecha" class="form-control fecha" placeholder="yy/mm/dd" onfocus="blur();" readonly="readonly">
                      </div>
                      <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                        <label><font face="Verdana" size="2">Hora Comprobante</font></label>
                        <input type="text" name="c_hora" id="c_hora" class="form-control fecha" onfocus="blur();" readonly="readonly">
                      </div>
                      <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                        <label><font face="Verdana" size="2">Nueva Fecha</font></label>
                        <input type="text" name="n_fecha" id="n_fecha" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                        <input type="hidden" name="m_fecha" id="m_fecha" class="form-control" value="<?php echo $minimo; ?>" readonly="readonly">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <center>
                          <input type="button" name="aceptar" id="aceptar" value="Actualizar">
                        </center>
                      </div>
                    </div>
                    <input type="hidden" name="c_valor" id="c_valor" class="form-control" value="0" readonly="readonly">
                    <input type="hidden" name="c_tipo" id="c_tipo" class="form-control" value="0" readonly="readonly">
                    <input type="hidden" name="c_ano" id="c_ano" class="form-control" value="0" readonly="readonly">
                    <input type="hidden" name="c_unidad" id="c_unidad" class="form-control" value="0" readonly="readonly">
                    <input type="hidden" name="c_index" id="c_index" class="form-control" value="0" readonly="readonly">
                  </td>
                </tr>
              </table>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
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
    monthNamesShort: ['Ene','Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
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
  $("#load").hide();
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
  $("#n_fecha").datepicker({
    dateFormat: "yy/mm/dd",
    minDate: $("#m_fecha").val(),
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 230,
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
    width: 700,
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
        anul();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  // Cambiar Fecha
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 170,
    width: 680,
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
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
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
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").button();
  $("#aceptar").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").click(actualizar);
  trae_cuentas();
  trae_unidades(0);
  var super1 = $("#super").val();
  if (super1 == "1")
  {
    $("#lbl1").show();
  }
  else
  {
    $("#lbl1").hide();
  }
});
function trae_cuentas()
{
  $("#cuenta").html('');
  var unidad = $("#n_unidad").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cuentas1.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      if (unidad == "1")
      {
        salida += "<option value='0|0|0'>TODAS LAS CUENTAS</option>";
      }
      for (var i in registros) 
      {
          var codigo = registros[i].codigo;
          var nombre = registros[i].nombre;
          var cuenta = registros[i].cuenta;
          var saldo = registros[i].saldo;
          var saldo1 = registros[i].saldo1;
          var descripcion = nombre+" - "+cuenta;
          var valores = codigo+"|"+saldo+"|"+saldo1;
          salida += "<option value='"+valores+"'>"+descripcion+"</option>";
      }
      $("#cuenta").append(salida);
    }
  });
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
function busca()
{
  var centra = $("#centra").val();
  var sigla = $("#centra option:selected").html();
  var consulta = "1";
  if (centra == "-")
  {
    $("#unidad").val('');
    var paso = "[]";
    var final = '$("#unidad").val('+paso+').trigger("change");';
    eval(final);
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
function pregunta()
{
  var comp = $("#paso1").val();
  var tipo = $("#paso2").val();
  var tipo1;
  if (tipo == "1")
  {
    tipo1 = "Ingreso";
  }
  else
  {
    tipo1 = "Egreso";
  }
  var detalle = "<center><h3>Esta seguro de anular el Comprobante de "+tipo1+" No. "+comp+" ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function consultar()
{
  var tipo = $("#tipo_c").val();
  var v_mes = $("#v_mes").val();
  var v_ano = $("#v_ano").val();
  v_mes = v_mes.trim();
  v_ano = v_ano.trim();
  var cuenta = $("#cuenta").val();
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  var centra = $("#centra").val();
  var unidad = $("#unidad").select2('val');
  var salida = true, detalle = '';
  var super1 = $("#super").val();
  if ((super1 == "1") || (super1 == "3"))
  {
    var fecha1 = $("#fecha1").val();
    if (fecha1 == "")
    {
      salida = false;
      alerta("Debe seleccionar fecha inicial");
    }
    var fecha2 = $("#fecha2").val();
    if (fecha2 == "")
    {
      salida = false;
      alerta("Debe seleccionar fecha final");
    }
  }
  if (tipo == "3")
  {
    if ($("#fecha1").val() == '')
    {
      salida = false;
      alerta("Debe seleccionar fecha inicial");
    }
    else
    {
      var v_fecha1 = $("#fecha1").val();
      var v_fechas = v_fecha1.split('/');
      var v_dia1 = v_fechas[2];
      if (v_dia1 == "01")
      {
      }
      else
      {
        salida = false;
        alerta("Fecha inicial no válida");
      }
    }
    if ($("#fecha2").val() == '')
    {
      salida = false;
      alerta("Debe seleccionar fecha final");
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
      url: "comp_consu1.php",
      data:
      {
        tipo: $("#tipo_c").val(),
        fecha1: $("#fecha1").val(),
        fecha2: $("#fecha2").val(),
        cuenta: cuenta1,
        centra: centra,
        unidad: unidad
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
        $("#resultados5").html('');
        var registros = JSON.parse(data);
        var valida = registros.salida;
        var valida1 = registros.total;
        var salida1 = "";
        var salida2 = "";
        listareg = [];
        if ((tipo == "1") || (tipo == "2"))
        {
          salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
          salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='5%'><b>No.</b></td><td height='35' width='8%'><b>Fecha</b></td><td height='35' width='8%'><b>Unidad</b></td><td height='35' width='8%'><b>Usuario</b></td><td height='35' width='7%'><b>Tipo</b></td><td height='35' width='21%'><b>Concepto</b></td><td height='35' width='9%'><b>Cuenta</b></td><td height='35' width='11%'><center><b>Valor</b></center></td><td height='35' width='8%'><center><b>Estado</b></center></td><td height='35' width='3%'>&nbsp;</td><td height='35' width='3%'>&nbsp;</td><td height='35' width='3%'>&nbsp;</td><td height='35' width='3%'>&nbsp;</td><td height='35' width='3%'>&nbsp;</td></tr></table>";
          salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
          $.each(registros.rows, function (index, value)
          {
            var n_estado = "";
            if (value.estado == "A")
            {
              n_estado = "ANULADO";
            }
            var servidor = value.servidor;
            if (tipo == "1")
            {
              var datos1 = '\"'+value.ingreso+'\",\"'+tipo+'\",\"'+value.ano+'\",\"'+value.unidad+'\",\"'+index+'\"';
              var datos2 = '\"'+value.ingreso+'\",\"'+value.tipo2+'\",\"'+value.ano+'\",\"'+value.unidad1+'\",\"'+value.unidad+'\"';
              var datos3 = '\"'+value.ingreso+'\",\"'+value.tipo2+'\",\"'+value.ano+'\",\"'+value.unidad1+'\",\"'+value.fecha+'\",\"'+value.hora+'\",\"'+index+'\"';
              salida2 += "<tr><td width='5%' height='35' id='l1_"+index+"'>"+value.ingreso+"</td>";
              salida2 += "<td width='8%' height='35' id='l2_"+index+"'>"+value.fecha+"</td>";
              salida2 += "<td width='8%' height='35' id='l3_"+index+"'>"+value.unidad+"</td>";
              salida2 += "<td width='8%' height='35' id='l4_"+index+"'>"+value.usuario+"</td>";
              salida2 += "<td width='7%' height='35' id='l5_"+index+"'>"+value.tipo+"</td>";
              salida2 += "<td width='21%' height='35' id='l6_"+index+"'>"+value.concepto+"</td>";
              salida2 += "<td width='9%' height='35' id='l7_"+index+"'>"+value.cuenta+"</td>";
              salida2 += "<td width='11%' height='35' align='right' id='l8_"+index+"'>"+value.valor+"</td>";
              salida2 += "<td width='8%' height='35' align='right' id='l9_"+index+"'>"+n_estado+"</td>";
              if (value.estado == "A")
              {
                salida2 += "<td width='3%' height='35' id='l10_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
              }
              else
              {
                if ((value.periodo == v_mes) && (value.ano == v_ano))
                {
                  salida2 += "<td width='3%' height='35' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",14); paso("+value.ingreso+","+value.tipo2+","+value.ano+","+value.unidad1+"); pregunta();'><img src='imagenes/anular.png' border='0' title='Anular Comprobante'></a></center></td>";
                }
                else
                {
                  salida2 += "<td width='3%' height='35' id='l10_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
                }
              }
              salida2 += "<td width='3%' height='35' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",14); link("+datos2+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td>";
              // Contingencia
              if (servidor == "C")
              {
                salida2 += "<td width='3%' height='35' id='l12_"+index+"'><center><img src='dist/img/server.png' width='25' height='25' border='0' title='Contingencia'></center></td>";
              }
              else
              {
                salida2 += "<td width='3%' height='35' id='l12_"+index+"'>&nbsp;</td>";
              }
              // Eliminar PDF Final
              if ((super1 == "1") || (super1 == "3"))
              {
                salida2 += "<td width='3%' height='35' id='l13_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",14); del_pdf("+datos1+");'><img src='dist/img/delete.png' name='pdf_"+index+"' id='pdf_"+index+"' width='29' height='29' border='0' title='Eliminar PDF'></a></center></td>";
              }
              else
              {
                salida2 += "<td width='3%' height='35' id='l13_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
              }
              // Cambiar fecha
              if ((super1 == "1") || (super1 == "3"))
              {
                salida2 += "<td width='3%' height='35' id='l14_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",14); modif("+datos3+")'><img src='dist/img/calendario.png' name='img_"+index+"' id='img_"+index+"' width='25' height='25' border='0' title='Modificar Fecha'></a></center></td>";
              }
              else
              {
                salida2 += "<td width='3%' height='35' id='l14_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
              }
              salida2 += "</tr>";
              listareg.push(index);
            }
            else
            {
              var datos1 = '\"'+value.egreso+'\",\"'+tipo+'\",\"'+value.ano+'\",\"'+value.unidad+'\",\"'+index+'\"';
              var datos2 = '\"'+value.egreso+'\",\"'+value.tipo2+'\",\"'+value.ano+'\",\"'+value.unidad1+'\",\"'+value.unidad+'\"';
              salida2 += "<tr><td width='5%' height='35' id='l1_"+index+"'>"+value.egreso+"</td>";
              salida2 += "<td width='8%' height='35' id='l2_"+index+"'>"+value.fecha+"</td>";
              salida2 += "<td width='8%' height='35' id='l3_"+index+"'>"+value.unidad+"</td>";
              salida2 += "<td width='8%' height='35' id='l4_"+index+"'>"+value.usuario+"</td>";
              salida2 += "<td width='7%' height='35' id='l5_"+index+"'>"+value.tipo+"</td>";
              salida2 += "<td width='21%' height='35' id='l6_"+index+"'>"+value.concepto+"</td>";
              salida2 += "<td width='9%' height='35' id='l7_"+index+"'>"+value.cuenta+"</td>";
              salida2 += "<td width='11%' height='35' align='right' id='l8_"+index+"'>"+value.valor+"</td>";
              salida2 += "<td width='8%' height='35' id='l9_"+index+"'>"+n_estado+"</td>";
              if (value.estado == "A")
              {
                salida2 += "<td width='3%' height='35' id='l10_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
              }
              else
              {
                if ((value.periodo == v_mes) && (value.ano == v_ano))
                {
                  salida2 += "<td width='3%' height='35' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",14); paso("+value.egreso+","+value.tipo2+","+value.ano+","+value.unidad1+"); pregunta();'><img src='imagenes/anular.png' border='0' title='Anular Comprobante'></a></center></td>";
                }
                else
                {
                  salida2 += "<td width='3%' height='35' id='l10_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
                }
              }
              salida2 += "<td width='3%' height='35' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",14); link("+datos2+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td>";
              // Contingencia
              if (servidor == "C")
              {
                salida2 += "<td width='3%' height='35' id='l12_"+index+"'><center><img src='dist/img/server.png' width='25' height='25' border='0' title='Contingencia'></center></td>";
              }
              else
              {
                salida2 += "<td width='3%' height='35' id='l12_"+index+"'>&nbsp;</td>";
              }
              // Eliminar PDF Final
              if (super1 == "1")
              {
                salida2 += "<td width='3%' height='35' id='l13_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",14); del_pdf("+datos1+");'><img src='dist/img/delete.png' name='pdf_"+index+"' id='pdf_"+index+"' width='29' height='29' border='0' title='Eliminar PDF'></a></center></td>";
              }
              else
              {
                salida2 += "<td width='3%' height='35' id='l13_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
              }
              salida2 += "<td width='3%' height='35' id='l14_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
              salida2 += "</tr>";
              listareg.push(index);
            }
          });
          salida2 += "</table>";
          $("#tabla3").append(salida1);
          $("#resultados5").append(salida2);
        }
        if (tipo == "3")
        {
          $("#paso_excel").val(registros.valores);
          excel();
        }
      }
    });
  }
}
function paso(valor, tipo, ano, unidad)
{
  var valor, tipo, ano, unidad;
  $("#paso1").val(valor);
  $("#paso2").val(tipo);
  $("#paso3").val(ano);
  $("#paso4").val(unidad);
}
function anul()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "comp_anul.php",
    data:
    {
      interno: $("#paso1").val(),
      tipo: $("#paso2").val(),
      ano: $("#paso3").val(),
      unidad: $("#paso4").val(),
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
      var valida = registros.salida;
      if (valida == "A")
      {
        $("#consultar").click();
      }
    }
  });
}
function link(valor, tipo, ano, unidad, unidad1)
{
  var valor, tipo, ano, unidad, unidad1;
  $("#comp_tipo").val(tipo);
  $("#comp_conse").val(valor);
  $("#comp_ano").val(ano);
  $("#comp_uni").val(unidad);
  $("#comp_sig").val(unidad1);
  formu1.submit();
}
function del_pdf(conse, tipo, ano, sigla, index)
{
  var conse, tipo, ano, sigla, index, archivo;
  if (tipo == "1")
  {
    archivo = "CompIng_"+sigla+"_"+conse+"_"+ano+".pdf";
  }
  else
  {
    archivo = "CompEgr_"+sigla+"_"+conse+"_"+ano+".pdf";
  }
  var ruta = "Comprobantes\\"+ano+"\\"+archivo;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "borrar2.php",
    data:
    {
      ruta: ruta
    },
    success: function (data)
    {
      $("#pdf_"+index).hide();
      alerta("Archivo PDF eliminado correctamente");
      alerta(archivo);
    }
  });
}
function modif(valor, tipo, ano, unidad, fecha, hora, index)
{
  var valor, tipo, ano, unidad, fecha, hora, index;
  $("#c_fecha").val(fecha);
  $("#c_hora").val(hora);
  $("#c_valor").val(valor);
  $("#c_tipo").val(tipo);
  $("#c_ano").val(ano);
  $("#c_unidad").val(unidad);
  $("#c_index").val(index);
  $("#dialogo2").dialog("open");
}
function actualizar()
{
  var valida = $("#n_fecha").val();
  if (valida == "")
  {
    alerta("Debe seleccionar nueva fecha");
  }
  else
  {
    var fecha = $("#c_fecha").val();
    var hora = $("#c_hora").val();
    var fecha1 = $("#n_fecha").val();
    var unidad = $("#c_unidad").val();
    var numero = $("#c_valor").val();
    var ano = $("#c_ano").val();
    var index = $("#c_index").val();
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "sop_grab2.php",
      data:
      {
        fecha: fecha,
        hora: hora,
        fecha1: fecha1,
        unidad: unidad,
        numero: numero,
        ano: ano
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        var salida = registros.salida;
        if (salida == "1")
        {
          var detalle = "Fecha actualizada correctamente";
          alerta1(detalle);
          $("#aceptar").hide();
          $("#img_"+index).hide();
          $("#n_fecha").prop("disabled", true);
          $("#dialogo2").dialog("close");
        }
        else
        {
          var detalle = "Error durante la actualización";
          alerta(detalle);
        }
      }
    });
  }
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
</script>
</body>
</html>
<?php
}
// 08/04/2024 - Ajuste exportacion a excel detallado comprobantes
// 25/04/2024 - Eliminacion de archivos pdf guardados
// 24/05/2024 - Ajuste busqueda por unidad centralizadora
// 16/07/2024 - Ajuste para que el usuario asigando en otros administradores pueden eliminar pdf
// 11/09/2024 - Ajuste anulacion de ingresos por unidad
// 22/11/2024 - Ajuste identificador contingencia
?>