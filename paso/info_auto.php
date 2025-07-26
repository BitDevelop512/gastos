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
  $fecha = date('Y/m/d');
  $ano = date('Y');
  $mes = date('m');
  $mes = intval($mes);
  if ($mes == "12")
  {
    $mes1 = 1;
    $ano1 = $ano+1;
  }
  else
  {
    $mes1 = $mes+1;
    $ano1 = $ano;
  }
  $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $query);
  $n_unidad = odbc_result($cur,1);
  $n_dependencia = odbc_result($cur,2);
  if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' AND unic='0' ORDER BY subdependencia";
  }
  else
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' ORDER BY subdependencia"; 
  }
  $cur1 = odbc_exec($conexion, $query1);
  $numero = "";
  while($i<$row=odbc_fetch_array($cur1))
  {
    $numero.="'".odbc_result($cur1,1)."',";
  }
  $numero = substr($numero,0,-1);
  // Se verifica si es unidad centralizadora especial
  if (strpos($especial, $uni_usuario) !== false)
  {
    $numero .= ",";
    $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$nun_usuario' ORDER BY unidad";
    $cur = odbc_exec($conexion, $query);
    while($i<$row=odbc_fetch_array($cur))
    {
      $n_unidad = odbc_result($cur,1);
      $n_dependencia = odbc_result($cur,2);
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
      $cur1 = odbc_exec($conexion, $query1);
      while($j<$row=odbc_fetch_array($cur1))
      {
        $numero .= "'".odbc_result($cur1,1)."',";
      }
    }
    $numero = substr($numero,0,-1);
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
          <h3>Informe de Autorizaci&oacute;n</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Periodo</font></label>
                  <input type="hidden" name="unidades" id="unidades" class="form-control" value="<?php echo $numero; ?>" readonly="readonly">
                  <select name="periodo" id="periodo" class="form-control select2" tabindex="1">
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
                  <select name="ano" id="ano" class="form-control select2" tabindex="2"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Unidad</font></label>
                  <select name="unidades1" id="unidades1" class="form-control select2" tabindex="3"></select>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <br>
                  <input type="hidden" name="datos1" id="datos1" class="form-control" readonly="readonly">
                  <input type="hidden" name="datos2" id="datos2" class="form-control" readonly="readonly">
                  <input type="hidden" name="datos3" id="datos3" class="form-control" readonly="readonly">
                  <input type="hidden" name="datos4" id="datos4" class="form-control" readonly="readonly">
                  <input type="hidden" name="datos5" id="datos5" class="form-control" readonly="readonly">
                  <input type="hidden" name="datos6" id="datos6" class="form-control" readonly="readonly">
                  <input type="hidden" name="datos7" id="datos7" class="form-control" readonly="readonly">
                  <input type="hidden" name="datos8" id="datos8" class="form-control" value="0" readonly="readonly">
                  <input type="hidden" name="datos9" id="datos9" class="form-control" value="0" readonly="readonly">
                  <input type="hidden" name="mes1" id="mes1" class="form-control" value="<?php echo $mes1; ?>" readonly="readonly">
                  <input type="hidden" name="ano1" id="ano1" class="form-control" value="<?php echo $ano1; ?>" readonly="readonly">
                  <input type="hidden" name="informe" id="informe" class="form-control" value="0" readonly="readonly">
                  <input type="button" name="aceptar" id="aceptar" value="Continuar">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <div id="datos"></div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Plazo:</font></label>
                  <input type="text" name="plazo" id="plazo" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Directiva:</font></label>
                  <input type="text" name="directiva" id="directiva" class="form-control numero" value="00000212" maxlength="6">
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4"></div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4"></div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                	<select name="tipo" id="tipo" class="form-control select2">
                    <option value="1">GENERAR INFORME AUTORIZACIÓN</option>
                    <option value="2">CANCELAR MISIONES/INFORMANTES</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
                  <center>
                    <label id="lbl1"><font face="Verdana" size="2">Instrucci&oacute;n Adicional:</font></label>
                    <label id="lbl2"><font face="Verdana" size="2">Observaciones:</font></label>
                  </center>
                  <textarea name="instruccion" id="instruccion" class="form-control"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"></div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <center>
                    <input type="button" name="aceptar1" id="aceptar1" value="Generar">
                  </center>
                  <center>
                    <input type="button" name="aceptar2" id="aceptar2" value="Visualizar">
                  </center>
                </div>
              </div>
            </form>
            <form name="formu1" action="ver_auto.php" method="post" target="_blank">
              <input type="hidden" name="auto_inf" id="auto_inf" class="form-control" readonly="readonly">
              <input type="hidden" name="auto_uni" id="auto_uni" class="form-control" readonly="readonly">
              <input type="hidden" name="auto_per" id="auto_per" class="form-control" readonly="readonly">
              <input type="hidden" name="auto_ano" id="auto_ano" class="form-control" readonly="readonly">
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
            <div id="dialogo2"></div>
          </div>
          <h3>Consultas</h3>
          <div>
            <div class="row">
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Fecha</font></label>
                <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">&nbsp;</font></label>
                <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                <label><font face="Verdana" size="2">Tipo</font></label>
                <select name="tipo1" id="tipo1" class="form-control select2">
                  <option value="1">INFORMES AUTORIZADOS</option>
                  <option value="2">MISIONES/INFORMANTES CANCELADAS</option>
                </select>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Unidad</font></label>
                <select name="unidades2" id="unidades2" class="form-control select2"></select>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <br>
                <input type="button" name="consultar" id="consultar" value="Consultar">
              </div>
            </div>
            <br>
            <div id="tabla3"></div>
            <div id="resultados5"></div>
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
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
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
        graba();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 210,
    width: 510,
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
  trae_unidades();
  $("#lbl2").hide();
  $("#tipo").change(trae_label);
  var fec_periodo = $("#mes1").val();
  var fec_periodo1 = fec_periodo.length;
  if (fec_periodo1 == "1")
  {
    var fec_periodo = "0"+fec_periodo;
  }
  var fec_ano = $("#ano1").val();
  var fec_primero = fec_ano+"/"+fec_periodo+"/01";
  $("#plazo").datepicker({
    dateFormat: "yy/mm/dd",
    minDate: fec_primero,
    changeYear: true,
    changeMonth: true
  });
  $("#aceptar").button();
  $("#aceptar").click(consulta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta);
  $("#aceptar1").hide();
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(link);
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").hide();
  $("#consultar").button();
  $("#consultar").css({ width: '120px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#consultar").click(consultar);
  $("#datos").hide();
  trae_ano();
  $("#periodo").val('<?php echo $mes; ?>');
  $("#ano").val('<?php echo $ano; ?>');
});
</script>
<script>
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
function trae_unidades()
{
  $("#unidades1").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unidades.php",
    data:
    {
      unidades: $("#unidades").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var salida1 = "";
      salida1 += "<option value='999'>- SELECCIONAR -</option>";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
        salida1 += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#unidades1").append(salida);
      $("#unidades2").append(salida1);
    }
  });
}
function consulta()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "auto_consu1.php",
    data:
    {
      unidades: $("#unidades1").val(),
      periodo: $("#periodo").val(),
      ano: $("#ano").val()
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
      var conse = registros.conse;
      var valida = registros.salida;
      var valida1 = registros.salida1;
      valida1 = parseFloat(valida1);
      if (valida1 > 0)
      {
        consulta1();
        $("#aceptar2").hide();
        $("#plazo").prop("disabled",false);
        $("#directiva").prop("disabled",false);
        $("#instruccion").prop("disabled",false);
      }
      else
      {
        if (valida1 == "0")
        {
          var detalle = "<h2><center>No se encontraron registros<br>para generar el informe</center></h2>";
        }
        else
        {
          var detalle = "<h2><center>Informe de Autorizaci&oacute;n<br>ya generado</center></h2>";
        }
        $("#plazo").prop("disabled",true);
        $("#directiva").prop("disabled",true);
        $("#instruccion").prop("disabled",true);
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
      }
    }
  });
}
function consulta1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "auto_consu.php",
    data:
    {
      unidades: $("#unidades1").val(),
      periodo: $("#periodo").val(),
      ano: $("#ano").val()
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
      $("#datos").html('');
      $("#aceptar").hide();
      $("#periodo").prop("disabled",true);
      $("#ano").prop("disabled",true);
      $("#unidades1").prop("disabled",true);
      $("#datos").show();
      var registros = JSON.parse(data);
      var misiones = registros.mision;
      var valores1 = registros.valorm;
      var v1 = misiones.split('|');
      var v2 = misiones.split('|').length;
      var v2 = v2-1;
      var v3 = valores1.split('|');
      var cedulas = registros.cedula;
      var valores2 = registros.valorc;
      var v4 = cedulas.split('|');
      var v5 = cedulas.split('|').length;
      var v5 = v5-1;
      var v6 = valores2.split('|');
      var compas = registros.compas;
      var v7 = compas.split('|');
      var v8 = compas.split('|').length;
      var v8 = v8-1;
      var ncompa = registros.ncompa;
      var v9 = ncompa.split('|');
      var valores3 = registros.valorx;
      var valores4 = registros.valory;
      var v10 = valores3.split('|');
      var v11 = valores4.split('|');
      var ide = registros.ide;
      var ido = registros.ido;
      var v12 = ide.split('|');
      var v13 = ido.split('|');
      var ida = registros.ida;
      var idi = registros.idi;
      var v14 = ida.split('|');
      var v15 = idi.split('|');
      var y = 1;
      var salida = "";
      salida += "<br><table width='100%' align='center' border='0'><tr><td width='50%' valign='top'><table width='90%' align='center' border='1'><tr><td width='5%' height='35' bgcolor='#cccccc'><center><input type='checkbox' name='chk1' id='chk1' onclick='todos_marca();'></center></td><td width='55%' height='35' bgcolor='#cccccc'><center><b>Misi&oacute;n</b></center></td><td width='40%' height='35' bgcolor='#cccccc'><center><b>Valor</b></center></td></tr>";
      for (k=0;k<v2;k++)
      {
        valor0 = v1[k];
        valor1 = v3[k];
        valor4 = v7[k];
        valor5 = v9[k];
        valor6 = v10[k];
        valor8 = v12[k];
        valor9 = v13[k];
        salida += '<tr><td><center>';
        if (valor1 == "0.00")
        {
          salida += '<input type="checkbox" name="sel_[]" id="chc_'+y+'" value="'+y+','+valor8+','+valor9+'" onclick="trae_marca();">';
        }
        else
        {
          salida += '<input type="checkbox" name="sel_[]" id="chk_'+y+'" value="'+y+','+valor8+','+valor9+'" onclick="trae_marca();">';
        }
        salida += '</center></td><td><input type="hidden" name="cmp_'+y+'" id="cmp_'+y+'" class="form-control" value="'+valor4+'" onfocus="blur();" readonly="readonly"><input type="text" name="mis_'+y+'" id="mis_'+y+'" class="form-control" value="'+valor0+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><br>&nbsp;'+valor5+'</td><td align="right"><input type="text" name="val_'+y+'" id="val_'+y+'" class="form-control numero" value="'+valor1+'" onkeyup="paso_val('+y+');suma()" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="val1_'+y+'" id="val1_'+y+'" class="form-control" value="0"><input type="hidden" name="pas1_'+y+'" id="pas1_'+y+'" class="form-control" value="0"></td></tr>';
        y++;
      }
      salida += '<tr><td height="35" bgcolor="#cccccc"></td><td height="35" bgcolor="#cccccc"><b>Total:</b></td><td align="right" height="35"><input type="text" name="total1" id="total1" class="c7" value="0" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"></td></tr>';
      salida += '<tr><td height="35" bgcolor="#cccccc"></td><td height="35" bgcolor="#cccccc"><b>Total Autorizados:</b></td><td align="right" height="35"><input type="text" name="s_total1" id="s_total1" class="c7" value="0" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"></td></tr>';
      // Informantes
      salida += "</table></td><td width='50%' valign='top'><table width='90%' align='center' border='1'><tr><td width='5%' height='35' bgcolor='#cccccc'><center><input type='checkbox' name='chk2' id='chk2' onclick='todos_marca1();'></center></td><td width='55%' height='35' bgcolor='#cccccc'><center><b>Informante</b></center></td><td width='40%' height='35' bgcolor='#cccccc'><center><b>Valor</b></center></td></tr>";
      var y = 1;
      for (k=0;k<v5;k++)
      {
        valor2 = v4[k];
        valor3 = v6[k];
        valor7 = v11[k];
        valor10 = v14[k];
        valor11 = v15[k];
        salida += '<tr><td><center>';
        if (valor3 == "0.00")
        {
          salida += '<input type="checkbox" name="sec_[]" id="chc_'+y+'" value="'+y+','+valor10+','+valor11+'" onclick="trae_marca1(); trae_cero();">';
        }
        else
        {
          salida += '<input type="checkbox" name="sec_[]" id="chc_'+y+'" value="'+y+','+valor10+','+valor11+'" onclick="trae_marca1();">';
        }
        salida += '</center></td><td height="35"><input type="text" name="ced_'+y+'" id="ced_'+y+'" class="c4" value="'+valor2+'" onfocus="blur();" readonly="readonly" style="border-style: none;"></td><td align="right" height="35"><input type="text" name="vat_'+y+'" id="vat_'+y+'" class="c7" value="'+valor3+'" onkeyup="paso_val1('+y+');suma()" onfocus="blur();" readonly="readonly" style="border-style: none;"><input type="hidden" name="vat1_'+y+'" id="vat1_'+y+'" value="0"><input type="hidden" name="pas2_'+y+'" id="pas2_'+y+'" value="0"></td></tr>';
        y++;
      }
      salida += '<tr><td height="35" bgcolor="#cccccc"></td><td height="35" bgcolor="#cccccc"><b>Total:</b></td><td align="right" height="35"><input type="text" name="total2" id="total2" class="c7" value="0" onfocus="blur();" readonly="readonly" style="border-style: none;"></td></tr>';
      salida += '<tr><td height="35" bgcolor="#cccccc"></td><td height="35" bgcolor="#cccccc"><b>Total Autorizados:</b></td><td align="right" height="35"><input type="text" name="s_total2" id="s_total2" class="c7" value="0" onfocus="blur();" readonly="readonly" style="border-style: none;"></td></tr>';
      // Suma Total
      salida += '</table></td></tr><tr><td colspan="2"><br><center><b>Total:</b>&nbsp;&nbsp;&nbsp;<input type="text" name="total3" id="total3" class="c7" value="0" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"></center></td></tr>';
      // Suma Autorizados
      salida += '<tr><td colspan="2"><br><center><b>Total Autorizados:</b>&nbsp;&nbsp;&nbsp;<input type="text" name="total4" id="total4" class="c7" value="0" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"></center></td></tr></table>';
      $("#datos").append(salida);
      for (w=1;w<=v2;w++)
      {
        $("#val_"+w).maskMoney();
        paso_val(w);
      }
      for (w=1;w<=v5;w++)
      {
        $("#vat_"+w).maskMoney();
        paso_val1(w);
      }
      $("#aceptar1").show();
      suma();
    }
  });
}
function trae_label()
{
  var valida = $("#tipo").val();
  if (valida == "1")
  {
    $("#lbl1").show();
    $("#lbl2").hide();
  }
  else
  {
    $("#lbl1").hide();
    $("#lbl2").show();
  }
}
function trae_marca()
{
  $("#datos6").val('');
  var suma = 0;
  var valores = "";
  var seleccionadosarray = [];
  $("input[name='sel_[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        var paso = $(this).val();
        var var_ocu = paso.split(',');
        var paso1 = var_ocu[0];
        var paso2 = var_ocu[1];
        var paso3 = var_ocu[2];
        var paso4 = $("#val1_"+paso1).val();
        paso4 = parseFloat(paso4);
        $("#pas1_"+paso1).val('1');
        seleccionadosarray.push(paso);
        suma = suma+paso4;
        valores += paso2+"|"+paso3+"|#";
      }
      else
      {
        var paso = $(this).val();
        var var_ocu = paso.split(',');
        var paso1 = var_ocu[0];
        $("#pas1_"+paso1).val('0');
      }
    }
  );
  suma = suma.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#s_total1").val(suma);
  $("#datos6").val(valores);
  var valida = seleccionadosarray.length;
  contador = parseFloat(valida);
  $("#datos8").val(contador);
  suma_total();
}
function trae_cero()
{
  $("#tipo").val('2');
  $("#tipo").prop("disabled",true);
}
function trae_marca1()
{
  $("#datos7").val('');
  var suma = 0;
  var valores = "";
  var seleccionadosarray = [];
  $("input[name='sec_[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        var paso = $(this).val();
        var var_ocu = paso.split(',');
        var paso1 = var_ocu[0];
        var paso2 = var_ocu[1];
        var paso3 = var_ocu[2];
        var paso4 = $("#vat1_"+paso1).val();
        paso4 = parseFloat(paso4);
        $("#pas2_"+paso1).val('1');
        seleccionadosarray.push(paso);
        suma = suma+paso4;
        valores += paso2+"|"+paso3+"|#";
      }
      else
      {
        var paso = $(this).val();
        var var_ocu = paso.split(',');
        var paso1 = var_ocu[0];
        $("#pas2_"+paso1).val('0');
      }
    }
  );
  suma = suma.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#s_total2").val(suma);
  $("#datos7").val(valores);
  var valida = seleccionadosarray.length;
  contador = parseFloat(valida);
  $("#datos9").val(contador);
  suma_total();
}
function todos_marca()
{
  var todos = 0;
  if ($("#chk1").is(':checked'))
  {
    todos = 1;
  }
  if (todos == "1")
  {
    $("input[name='sel_[]']").each(
      function ()
      {
        if ($(this).is(":checked"))
        {
        }
        else
        {
          $(this).click(); 
        }
      }
    );
  }
  else
  {
    $("input[name='sel_[]']").each(
      function ()
      {
        if ($(this).is(":checked"))
        {
          $(this).click(); 
        }
      }
    ); 
  }
}
function todos_marca1()
{
  var todos = 0;
  if ($("#chk2").is(':checked'))
  {
    todos = 1;
  }
  if (todos == "1")
  {
    $("input[name='sec_[]']").each(
      function ()
      {
        if ($(this).is(":checked"))
        {
        }
        else
        {
          $(this).click(); 
        }
      }
    );
  }
  else
  {
    $("input[name='sec_[]']").each(
      function ()
      {
        if ($(this).is(":checked"))
        {
          $(this).click(); 
        }
      }
    ); 
  }
}
function suma_total()
{
  var1 = $("#s_total1").val();
  var1 = parseFloat(var1.replace(/,/g,''));
  var1 = parseFloat(var1);
  var2 = $("#s_total2").val();
  var2 = parseFloat(var2.replace(/,/g,''));
  var2 = parseFloat(var2);
  var3 = var1+var2;
  var3 = var3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total4").val(var3);
}
function paso_val(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('val_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#val1_"+valor).val(valor1);
}
function paso_val1(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('vat_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vat1_"+valor).val(valor1);
}
function paso_val2()
{
  var valor;
  var valor1;
  var valor2;
  valor2 = 0;
  valor = document.getElementById('total1').value;
  valor = parseFloat(valor.replace(/,/g,''));
  valor1 = document.getElementById('total2').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  valor2 = valor+valor1;
  valor2 = parseFloat(valor2);
  valor2 = valor2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total3").val(valor2);
}
// Suma de valores
function suma()
{
  var valor1;
  var valor2;
  var valor3;
  var valor4;
  // Suma de valores de misiones
  valor1 = 0;
  valor2 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('val1_')!=-1)
    {
      valor1 = document.getElementById(saux).value;
      valor1 = parseFloat(valor1);
      valor2 = valor2+valor1;
    }
  }
  valor2 = valor2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total1").val(valor2);
  // Suma de valores de informantes
  valor3 = 0;
  valor4 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vat1_')!=-1)
    {
      valor3 = document.getElementById(saux).value;
      valor3 = parseFloat(valor3);
      valor4 = valor4+valor3;
    }
  }
  valor4 = valor4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total2").val(valor4);
  paso_val2();
}
function pregunta()
{
  var detalle = "Esta seguro de continuar ?";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
}
function graba()
{
  var valida = 0;
  var valida1 = $("#datos8").val();
  valida1 = parseFloat(valida1);
  var valida2 = $("#datos9").val();
  valida2 = parseFloat(valida2);
  valida = valida1+valida2;
  var tipo = $("#tipo").val();
  $("#instruccion").removeClass("ui-state-error");
  if (valida == "0")
  {
    var detalle = "<h2><center>Debe seleccionar m&iacute;nimo<br>una Misi&oacute;n o Informante</center></h2>";
    $("#dialogo2").html(detalle);
    $("#dialogo2").dialog("open");
  }
  else
  {
    if (tipo == "1")
    {
      var val_fecha = $("#plazo").val();
      if (val_fecha == "")
      {
        var detalle = "<h2><center>Debe seleccionar Fecha de Plazo</center></h2>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
      }
      else
      {
        graba1();
      }
    }
    else
    {
      var valor = $("#instruccion").val();
      valor = valor.trim().length;
      if (valor == "0")
      {
        var detalle = "<h2><center>Debe ingresar las Observaciones</center></h2>";
        $("#instruccion").addClass("ui-state-error");
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
      }
      else
      {
        $("#instruccion").removeClass("ui-state-error");
        graba1();
      }
    }
  }
}
function graba1()
{
  document.getElementById('datos1').value = "";
  document.getElementById('datos2').value = "";
  document.getElementById('datos3').value = "";
  document.getElementById('datos4').value = "";
  document.getElementById('datos5').value = "";
  for (j=0;j<document.formu.elements.length;j++)
  {
    saux1 = document.formu.elements[j].id;
    if (saux1.indexOf('pas1_')!=-1)
    {
      valor0 = document.getElementById(saux1).value;
      if (valor0 == "1")
      {
        var var_ocu = saux1.split('_');
        var veri = var_ocu[1];
        var valor = $("#mis_"+veri).val();
        document.getElementById('datos1').value = document.getElementById('datos1').value+valor+"|";
        var valor1 = $("#val_"+veri).val();
        document.getElementById('datos2').value = document.getElementById('datos2').value+valor1+"|";
        var valor2 = $("#cmp_"+veri).val();
        document.getElementById('datos5').value = document.getElementById('datos5').value+valor2+"|";
      }
    }
  }
  for (j=0;j<document.formu.elements.length;j++)
  {
    saux1 = document.formu.elements[j].id;
    if (saux1.indexOf('pas2_')!=-1)
    {
      valor0 = document.getElementById(saux1).value;
      if (valor0 == "1")
      {
        var var_ocu = saux1.split('_');
        var veri = var_ocu[1];
        var valor = $("#ced_"+veri).val();
        document.getElementById('datos3').value = document.getElementById('datos3').value+valor+"|";
        var valor1 = $("#vat_"+veri).val();
        document.getElementById('datos4').value = document.getElementById('datos4').value+valor1+"|";

      }
    }
  }
  var tipo = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "inf_grab1.php",
    data:
    {
      tipo: tipo,
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
      unidad1: $("#unidades1").val(),
      gastos: $("#s_total1").val(),
      pagos: $("#s_total2").val(),
      total: $("#total4").val(),
      datos1: $("#datos1").val(),
      datos2: $("#datos2").val(),
      datos3: $("#datos3").val(),
      datos4: $("#datos4").val(),
      datos5: $("#datos5").val(),
      datos6: $("#datos6").val(),
      datos7: $("#datos7").val(),
      plazo: $("#plazo").val(),
      directiva: $("#directiva").val(),
      instruccion: $("#instruccion").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var valida;
      valida = registros.salida;
      if (valida > 0)
      {
        $("#aceptar").hide();
        $("#aceptar1").hide();
        if (tipo == "1")
        {
          $("#aceptar2").show();
        }
        $("#informe").val(valida);
        for (i=0;i<document.formu.elements.length;i++)
        {
          saux = document.formu.elements[i].name;
          if (saux.indexOf('val_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        for (i=0;i<document.formu.elements.length;i++)
        {
          saux = document.formu.elements[i].name;
          if (saux.indexOf('vat_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        for (i=0;i<document.formu.elements.length;i++)
        {
          saux = document.formu.elements[i].id;
          if (saux.indexOf('chk_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        for (i=0;i<document.formu.elements.length;i++)
        {
          saux = document.formu.elements[i].id;
          if (saux.indexOf('chc_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        $("#chk1").prop("disabled",true);
        $("#chk2").prop("disabled",true);
        $("#tipo").prop("disabled",true);
        $("#plazo").prop("disabled",true);
        $("#directiva").prop("disabled",true);
        $("#instruccion").prop("disabled",true);
        if (tipo == "1")
        {
          link1();
        }
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#aceptar1").show();
      }
    }
  });
}
function consultar()
{
  var tipo = $("#tipo1").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "info_consu.php",
    data:
    {
      tipo: tipo,
      fecha1: $("#fecha1").val(),
      fecha2: $("#fecha2").val(),
      unidad: $("#unidades2").val()
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
      var valida,valida1,valida2;
      var salida1 = "";
      var salida2 = "";
      listareg = [];
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
      salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='10%'><b>No.</b></td><td height='35' width='15%'><b>Fecha</b></td><td height='35' width='10%'><b>Unidad</b></td><td height='35' width='10%'><b>Usuario</b></td><td height='35' width='15%' align='right'><b>Gastos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td height='35' width='15%' align='right'><b>Pagos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td height='35' width='15%' align='right'><b>Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td><td height='35' width='10%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        valida2 = value.conse+","+value.unidad1+","+value.periodo+","+value.ano;
        salida2 += "<tr><td height='35' width='10%' id='l1_"+index+"'>"+value.conse+"</td>";
        salida2 += "<td height='35' width='15%' id='l2_"+index+"'>"+value.fecha+"</td>";
        salida2 += "<td height='35' width='10%' id='l3_"+index+"'>"+value.unidad+"</td>";
        salida2 += "<td height='35' width='10%' id='l4_"+index+"'>"+value.usuario+"</td>";
        salida2 += "<td height='35' width='15%' align='right' id='l5_"+index+"'>"+value.gastos+"</td>";
        salida2 += "<td height='35' width='15%' align='right' id='l6_"+index+"'>"+value.pagos+"</td>";
        salida2 += "<td height='35' width='15%' align='right' id='l7_"+index+"'>"+value.total+"</td>";
        if (tipo == "1")
        {
          salida2 += "<td height='35' width='10%' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",8); link("+valida2+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td>";
        }
        else
        {
          salida2 += "<td height='35' width='10%' id='l8_"+index+"'>&nbsp;</td>"; 
        }
        listareg.push(index);
      });
      salida2 += "</table>";
      $("#tabla3").append(salida1);
      $("#resultados5").append(salida2);
    }
  });
}
function link(valor, valor1, valor2, valor3)
{
  $("#auto_inf").val(valor);
  $("#auto_uni").val(valor1);
  $("#auto_per").val(valor2);
  $("#auto_ano").val(valor3);
  formu1.submit();
}
function link1()
{
  var informe, unidad, periodo, ano, link;
  informe = $("#informe").val();
  unidad = $("#unidades1").val();
  periodo = $("#periodo").val();
  ano = $("#ano").val();
  $("#auto_inf").val(informe);
  $("#auto_uni").val(unidad);
  $("#auto_per").val(periodo);
  $("#auto_ano").val(ano);
  formu1.submit();
}
</script>
</body>
</html>
<?php
}
?>