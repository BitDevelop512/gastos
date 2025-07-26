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
  // Se consultan planes ya registrados de la unidad
  $consu = "SELECT conse FROM cx_pla_inv WHERE usuario='$usu_usuario' AND unidad='$uni_usuario' AND estado IN ('D', 'F','G', 'H', 'W') AND ano='$ano' AND ((tipo='1' AND tipo1='99') OR tipo1='2') ORDER BY conse";
  $cur = odbc_exec($conexion, $consu);
  $numero = "";
  while($i<$row=odbc_fetch_array($cur))
  {
    $numero .= odbc_result($cur,1).",";
  }
  $query = "SELECT unidad, dependencia, unic FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur1 = odbc_exec($conexion, $query);
  $n_unidad = odbc_result($cur1,1);
  $n_unidad = intval($n_unidad);
  $n_dependencia = odbc_result($cur1,2);
  $n_centraliza = odbc_result($cur1,3);
  if ($n_unidad > 3)
  {
    $query1 = "SELECT subdependencia, firma1, firma2, firma3, cargo1, cargo2, cargo3 FROM cx_org_sub WHERE unidad='$n_unidad' AND unic='1'";
  }
  else
  {
    $query1 = "SELECT subdependencia, firma1, firma2, firma3, cargo1, cargo2, cargo3 FROM cx_org_sub WHERE dependencia='$n_dependencia' AND unic='1'";
  }
  $cur2 = odbc_exec($conexion, $query1);
  $unic = odbc_result($cur2,1);
  $firma1 = trim(utf8_encode(odbc_result($cur2,2)));
  $firma2 = trim(utf8_encode(odbc_result($cur2,3)));
  $firma3 = trim(utf8_encode(odbc_result($cur2,4)));
  $cargo1 = trim(utf8_encode(odbc_result($cur2,5)));
  $cargo2 = trim(utf8_encode(odbc_result($cur2,6)));
  $cargo3 = trim(utf8_encode(odbc_result($cur2,7)));
  // Se consulta unidades
  if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
  {
    $query2 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' AND unic='0' ORDER BY subdependencia";
  }
  else
  {
    $query2 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND unic!='1' ORDER BY subdependencia"; 
  }
  $cur2 = odbc_exec($conexion, $query2);
  $numero1 = "";
  while($i<$row=odbc_fetch_array($cur2))
  {
    $numero1 .= "'".odbc_result($cur2,1)."',";
  }
  $numero1 = substr($numero1,0,-1);
  $numero1 = trim($numero1);
  // Se verifica si es unidad centralizadora especial
  if (strpos($especial, $uni_usuario) !== false)
  {
    if ($numero1 == "")
    {
    }
    else
    {
      $numero1 .= ",";
    }
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
        $numero1 .= "'".odbc_result($cur1,1)."',";
      }
    }
    $numero1 = substr($numero1,0,-1);
    $numero1 = $numero1.",'".$uni_usuario."'";
  }
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
  <script type="text/javascript" src="alertas/lib/alertify.js"></script>
  <link rel="stylesheet" href="alertas/themes/alertify.core.css"/>
  <link rel="stylesheet" href="alertas/themes/alertify.default.css"/>
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
          <h3>Acta Pago de Informaci&oacute;n</h3>
          <div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Plan / Solicitud</font></label>
                  <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="unidades" id="unidades" class="form-control" value="<?php echo $numero1; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="usu" id="usu" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="numero" id="numero" class="form-control" value="<?php echo $numero; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="centra" id="centra" class="form-control" value="<?php echo $unic; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="centraliza" id="centraliza" class="form-control" value="<?php echo $n_centraliza; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="mes" id="mes" class="form-control" value="<?php echo $mes; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="firmas" id="firmas" class="form-control" value="" readonly="readonly" tabindex="0">
                  <input type="hidden" name="actu" id="actu" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_ciudad" id="v_ciudad" class="form-control" value="<?php echo $ciu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_click" id="v_click" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <select name="solicitud" id="solicitud" class="form-control select2" tabindex="1"></select>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Fuente</font></label>
                  <select name="fuente" id="fuente" class="form-control select2" tabindex="2"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">No. Acta</font></label>
                  <input type="text" name="numero1" id="numero1" class="form-control" value="" maxlength="25" tabindex="3" autocomplete="off">
                </div>
              </div>
              <br>
              <div id="datos">
                <div class="row">
                  <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                    <label><font face="Verdana" size="2">Intervienen</font></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table width="100%" align="center" border="0">
                      <tr>
                        <td width="45%">
                          <b>Grado y Nombre Completo</b>
                        </td>
                         <td width="45%">
                          <b>Cargo</b>
                        </td>
                        <td width="10%">
                          &nbsp;
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div id="add_form">
                      <table width="100%" align="center" border="0">
                        <tr>
                          <td colspan="2"></td>
                        </tr>
                      </table>
                    </div>
                    <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0" tabindex="4"></a>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                    <label><font face="Verdana" size="2">Testigo</font></label>
                    <input type="text" name="testigo" id="testigo" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="5" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Valor Aprobado</font></label>
                    <input type="text" name="valor" id="valor" class="form-control numero" value="0.00" readonly="readonly" tabindex="6">
                    <input type="hidden" name="valor1" id="valor1" class="form-control numero" value="0" tabindex="7">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label><font face="Verdana" size="2">Sintesis de la Informaci&oacute;n</font></label>
                    <textarea name="sintesis" id="sintesis" class="form-control" rows="5" onblur="val_caracteres('sintesis');" tabindex="8"></textarea>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                    <label><font face="Verdana" size="2">Utilidad y Empleo de la Informaci&oacute;n</font></label>
                    <textarea name="empleo" id="empleo" class="form-control" rows="5" onblur="val_caracteres('empleo');" tabindex="9"></textarea>
                  </div>
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                    <label><font face="Verdana" size="2">Observaciones</font></label>
                    <textarea name="observa" id="observa" class="form-control" rows="5" onblur="val_caracteres('observa');" tabindex="10"></textarea>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Difusi&oacute;n de la Informaci&oacute;n</font></label>
                    <select name="difusion" id="difusion" class="form-control select2" tabindex="11"></select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Unidad</font></label>
                    <select name="uni_dif" id="uni_dif" class="form-control select2" tabindex="12"></select>
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">N&uacute;mero</font></label>
                    <input type="text" name="num_dif" id="num_dif" class="form-control numero" value="" tabindex="13" autocomplete="off">
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Fecha</font></label>
                    <input type="text" name="fec_dif" id="fec_dif" class="form-control fecha" value="" tabindex="14" autocomplete="off">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Paz y Salvo</font></label>
                    <select name="pys" id="pys" class="form-control select2" tabindex="15"><option value="S">SI</option><option value="N">NO</option></select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">No. Pagos</font></label>
                    <input type="text" name="num_pag" id="num_pag" class="form-control numero" value="0" tabindex="16" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                    <label><font face="Verdana" size="2">Elaboro</font></label>
                    <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="17" autocomplete="off">
                  </div>
                </div>
                <br>
                <center>
                  <input type="button" name="aceptar" id="aceptar" value="Continuar">
                  <input type="button" name="aceptar2" id="aceptar2" value="Actualizar">
                  <input type="button" name="aceptar1" id="aceptar1" value="Visualizar">
                </center>
              </div>
            </form>
          </div>
          <h3>Consultas</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <div class="row">
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Fecha</font></label>
                <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">&nbsp;</font></label>
                <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                <label><font face="Verdana" size="2">Tipo de Consulta</font></label>
                <select name="tipo_c" id="tipo_c" class="form-control select2" onchange="valida();">
                  <option value="1">CONSULTA DE ACTAS</option>
                  <option value="2">RELACION DE PAGOS</option>
                </select>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Unidad</font></label>
                <select name="unidades1" id="unidades1" class="form-control select2"></select>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <br>
                <center>
                  <input type="button" name="consultar" id="consultar" value="Consultar">
                </center>
              </div>
            </div>
            <br>
            <div id="tabla3"></div>
            <div id="resultados5"></div>
            <form name="formu3" action="ver_acta.php" method="post" target="_blank">
              <input type="hidden" name="plan_conse" id="plan_conse" readonly="readonly">
              <input type="hidden" name="plan_ano" id="plan_ano" readonly="readonly">
              <input type="hidden" name="plan_uni" id="plan_uni" readonly="readonly">
            </form>
            <form name="formu_excel" id="formu_excel" action="informacion_x.php" target="_blank" method="post">
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
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 230,
    width: 450,
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
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  trae_unidades();
  trae_unidades1();
  trae_difu();
  trae_planes();
  trae_fuente();
  trae_datos();
  $("#solicitud").change(trae_fuente);
  $("#fuente").change(trae_datos);
  $("#aceptar").button();
  $("#aceptar").click(pregunta1);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(link);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(pregunta1);
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").hide();
  $("#aceptar1").hide();
  $("#aceptar2").hide();
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#numero1").focus();
  var MaxInputs       = 99;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      var y = z-1;
      FieldCount++;
      if (z == "1")
      {
        $("#add_form table").append('<tr><td width="45%" class="espacio1"><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="45%" class="espacio2"><input type="text" name="car_'+z+'" id="car_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>');
      }
      else
      {
        $("#add_form table").append('<tr><td width="45%" class="espacio1"><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="45%" class="espacio2"><input type="text" name="car_'+z+'" id="car_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="10%"><div id="men_'+z+'"><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      }
      x_1++;
      if (z == "1")
      {
      }
      else
      {
        $('html,body').animate({ scrollTop: 9999 }, 'slow');
        $("#men_"+y).hide();
      }
      $("#nom_"+z).focus();
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
  $("#add_field").click();
});
function trae_unidades()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unid.php",
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
      $("#uni_dif").append(salida);
    }
  });
}
function trae_unidades1()
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
      salida += "<option value='999'>- TODAS -</option>";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#unidades1").append(salida);
      trae_unidades2();
    }
  });
}
function trae_unidades2()
{
  var tipo = $("#tipo_c").val();
  var unidad = $("#v_unidad").val();
  var centraliza = $("#centraliza").val();
  if (centraliza == "0")
  {
    $("#unidades1").val(unidad);
    $("#unidades1").prop("disabled",true);
  }
  else
  {
    if (tipo == "1")
    {
      $("#unidades1").prop("disabled",true);
    }
    else
    {
      $("#unidades1").prop("disabled",false);
    }
  }
}
function trae_difu()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_difu.php",
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
      $("#difusion").append(salida);
    }
  });
}
function trae_planes()
{
  $("#solicitud").html('');
  var planes = $("#numero").val();
  var var_ocu = planes.split(',');
  var var_ocu1 = var_ocu.length;
  var salida = "";
  var paso = "";
  var j = 0;
  for (var i=0; i<var_ocu1-1; i++)
  {
    j = j+1;
    paso = var_ocu[i];
    salida += "<option value='"+paso+"'>"+paso+"</option>";
  }
  $("#solicitud").append(salida);
}
function trae_fuente()
{
  $("#fuente").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_fuente1.php",
    data:
    {
      numero: $("#solicitud").val(),
      fuente: $("#fuente option:selected").html()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "<option value='-''>- SELECCIONAR -</option>";
      var j = 0;
      for (var i in registros) 
      {
        j = j+1;
        var conse = registros[i].conse;
        var cedula = registros[i].cedula;
        salida += "<option value='"+conse+"'>"+cedula+"</option>";
      }
      if (j == "0")
      {
        salida += "<option value='0'>NO HAY ACTAS DE PAGO PENDIENTES</option>";
        $("#aceptar").hide();
        $("#numero1").prop("disabled",true);
        $("#nom_1").prop("disabled",true);
        $("#car_1").prop("disabled",true);
      }
      else
      {
        $("#aceptar").show();
        $("#numero1").prop("disabled",false);
        $("#nom_1").prop("disabled",false);
        $("#car_1").prop("disabled",false);
      }
      $("#fuente").append(salida);
    }
  });
}
function trae_datos()
{
  limpia();
  var var1 = $("#fuente").val();
  var var2 = $("#fuente option:selected").html();
  if (var1 == null)
  {
  }
  else
  {
    if (var1 == "-")
    {
      $("#aceptar").hide();
    }
    else
    {
      $.ajax({
        type: "POST",
        datatype: "json",
        url: "trae_fuente2.php",
        data:
        {
          conse: var1,
          fuente: var2
        },
        success: function (data)
        {
          var registros = JSON.parse(data);
          if (registros.utilidad == false)
          {
            $("#aceptar").hide();
          }
          else
          {
            $("#empleo").val(registros.utilidad);
            $("#aceptar").show();
          }
          if (registros.sintesis == false)
          {
          }
          else
          {
            $("#sintesis").val(registros.sintesis);
          }
          $("#valor").val(registros.valor);
          if (registros.difusion == false)
          {
          }
          else
          {
            $("#difusion").val(registros.difusion);
          }
          if (registros.numeros == false)
          {
          }
          else
          {
            $("#num_dif").val(registros.numeros);
          }
          if (registros.fechas == false)
          {
          }
          else
          {
            $("#fec_dif").val(registros.fechas);
          }
          if (registros.unidad == false)
          {
          }
          else
          {
            $("#uni_dif").val(registros.unidad);
          }
          $("#num_pag").val(registros.total);
          paso_valor();
        }
      });
    }
  }
}
function valida()
{
  var tipo = $("#tipo_c").val();
  var unidad = $("#v_unidad").val();
  var centraliza = $("#centraliza").val();
  if (centraliza == "0")
  {
    $("#unidades1").val(unidad);
    $("#unidades1").prop("disabled",true);
  }
  else
  {
    if (tipo == "1")
    {
      $("#unidades1").val('999');
      $("#unidades1").prop("disabled",true);
    }
    else
    {
      $("#unidades1").prop("disabled",false);
    }
  }
}
function limpia()
{
  $("#sintesis").val('');
  $("#empleo").val('');
  $("#observa").val('');
  $("#testigo").val('');
  $("#valor").val('0.00');
  $("#difusion").val('1');
  $("#num_dif").val('');
  $("#fec_dif").val('');
  $("#uni_dif").val('1');
  $("#pys").val('S');
}
function pregunta1()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function paso_valor()
{
  var valor;
  valor = $("#valor").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valor1").val(valor);
}
function validacionData()
{
  var salida = true, detalle = '';
  document.getElementById('firmas').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu.elements[i].name;
    if (saux1.indexOf('car_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
      valor2 = valor+"»"+valor1;
      document.getElementById('firmas').value = document.getElementById('firmas').value+valor2+"|";
    }
  }
  if ($("#fuente").val() == '-')
  {
    salida = false;
    detalle += "<center><h2>Fuente No Válida</h2></center>";
  }
  if ($("#testigo").val() == '')
  {
    salida = false;
    detalle += "<center><h2>Debe ingresar un Testigo</h2></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var actualiza = $("#actu").val();
    if (actualiza == "0")
    {
      nuevo();
    }
    else
    {
      actualizar();
    }
  }
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
function nuevo()
{
  var clicando = $("#v_click").val();
  if (clicando == "1")
  {
    var detalle = "<br><h2><center>Botón Continuar ya Presionado</center></h2>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
  }
  else
  {
    $("#v_click").val('1');
    var sintesis = $("#sintesis").val();
    var empleo = $("#empleo").val();
    var observa = $("#observa").val();
    var firmas = $("#firmas").val();
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "acti_grab.php",
      data:
      {
        firmas: firmas,
        centra: $("#centra").val(),
        fuente: $("#fuente").val(),
        fuente1: $("#fuente option:selected").html(),
        numero: $("#numero1").val(),
        testigo: $("#testigo").val(),
        valor: $("#valor").val(),
        sintesis: sintesis,
        empleo: empleo,
        observa: observa,
        difusion: $("#difusion").val(),
        uni_dif: $("#uni_dif").val(),
        num_dif: $("#num_dif").val(),
        fec_dif: $("#fec_dif").val(),
        pys: $("#pys").val(),
        pagos: $("#num_pag").val(),
        ano: $("#ano").val(),
        elaboro: $("#elaboro").val(),
        usuario: $("#v_usuario").val(),
        unidad: $("#v_unidad").val(),
        ciudad: $("#v_ciudad").val()
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
        var valida;
        valida = registros.salida;
        if (valida > 0)
        {
          $("#aceptar").hide();
          $("#aceptar1").show();
          $("#plan_conse").val(valida);
          $("#plan_ano").val(registros.ano);
          $("#testigo").prop("disabled",true);
          $("#numero1").prop("disabled",true);
          $("#fuente").prop("disabled",true);
          $("#valor").prop("disabled",true);
          $("#sintesis").prop("disabled",true);
          $("#difusion").prop("disabled",true);
          $("#empleo").prop("disabled",true);
          $("#observa").prop("disabled",true);
          $("#uni_dif").prop("disabled",true);
          $("#num_dif").prop("disabled",true);
          $("#fec_dif").prop("disabled",true);
          $("#pys").prop("disabled",true);
          $("#elaboro").prop("disabled",true);
          for (i=0;i<document.formu.elements.length;i++)
          {
            saux = document.formu.elements[i].name;
            if (saux.indexOf('nom_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('car_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
          $("#add_field").hide();
          for (k=1;k<=10;k++)
          {
            $("#men_"+k).hide();
          }
          $("#actu").val('0');
        }
        else
        {
          detalle = "<br><h2><center>Error durante la grabación</center></h2>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#aceptar").show();
          $("#v_click").val('0');
        }
      }
    });
  }
}
function link()
{
  var valor;
  valor = $("#plan_conse").val();
  $("#plan_conse").val(valor);
  formu3.submit();
}
function link1(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $("#plan_conse").val(valor);
  $("#plan_ano").val(valor1);
  $("#plan_uni").val(valor2);
  formu3.submit();
}
function consultar()
{
  var tipo = $("#tipo_c").val();
  var unidades = $("#unidades").val();
  var unidades1 = $("#unidades1").val();
  var usu = $("#usu").val();
  var v_ano = $("#ano").val();
  var v_mes = $("#mes").val();
  v_mes = parseInt(v_mes);
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
      url: "acti_consu.php",
      data:
      {
        tipo: tipo,
        unidades: unidades,
        unidades1: unidades1,
        fecha1: $("#fecha1").val(),
        fecha2: $("#fecha2").val()
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
        var valida,valida1;
        var salida1 = "";
        var salida2 = "";
        listareg = [];
        valida = registros.salida;
        valida1 = registros.total;
        if (tipo == "1")
        {
          salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
          salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='5%'><b>No.</b></td><td height='35' width='20%'><b>Acta</b></td><td height='35' width='8%'><b>Fecha</b></td><td height='35' width='8%'><b>Unidad</b></td><td height='35' width='8%'><b>Usuario</b></td><td height='35' width='16%'><b>Fuente</b></td><td height='35' width='10%'><center><b>Valor</b></center></td><td height='35' width='10%'><center><b>Plan</b></center></td><td width='5%' height='35'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td></tr></table>";
          salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
          $.each(registros.rows, function (index, value)
          {
            var datos1 = '\"'+value.conse+'\",\"'+value.ano+'\",\"'+value.unidad+'\",\"'+index+'\"';
            var ced_fuente = value.fuente;
            var val_fuente = ced_fuente.indexOf("K") > -1
            if (val_fuente == false)
            {
              var ced_fuente = value.fuente;
              var ced_fuente1 = ced_fuente.substr(ced_fuente.length-4);
              ced_fuente1 = "XXXX"+ced_fuente1;
            }
            else
            {
              var ced_fuente1 = value.fuente;
            }
            salida2 += "<tr><td width='5%' height='35' id='l1_"+index+"'>"+value.conse+"</td>";
            salida2 += "<td width='20%' height='35' id='l2_"+index+"'>"+value.numero+"</td>";
            salida2 += "<td width='8%' height='35' id='l3_"+index+"'>"+value.fecha+"</td>";
            salida2 += "<td width='8%' height='35' id='l4_"+index+"'>"+value.unidad+"</td>";
            salida2 += "<td width='8%' height='35' id='l5_"+index+"'>"+value.usuario+"</td>";
            salida2 += "<td width='16%' height='35' id='l6_"+index+"'>"+ced_fuente1+"</td>";
            salida2 += "<td width='10%' height='35' id='l7_"+index+"' align='right'>"+value.valor+"</td>";
            salida2 += "<td width='10%' height='35' id='l8_"+index+"' align='right'>"+value.plan+"</td>";
            v_mes1 = value.fecha.split('-');
            v_mes1 = v_mes1[1];
            v_mes1 = parseInt(v_mes1);
            if (v_ano == value.ano)
            {
              if (v_mes == v_mes1)
              {
              	if (usu == value.usuario)
                {
                	salida2 += "<td width='5%' height='35' id='l9_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); modif("+value.conse+","+value.unidad1+","+value.ano+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
                }
                else
                {
                	salida2 += "<td width='5%' height='35' id='l9_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
                }
              }
              else
              {
                salida2 += "<td width='5%' height='35' id='l9_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
              }
            }
            else
            {
            	salida2 += "<td width='5%' height='35' id='l9_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
            }
            salida2 += "<td width='5%' height='35' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); link1("+value.conse+","+value.ano+","+value.unidad1+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td>";
            // Eliminar PDF Final
            if (super1 == "1")
            {
              salida2 += "<td width='5%' height='35' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); del_pdf("+datos1+");'><img src='dist/img/delete.png' name='pdf_"+index+"' id='pdf_"+index+"' width='29' height='29' border='0' title='Eliminar PDF'></a></center></td>";
            }
            else
            {
              salida2 += "<td width='5%' height='35' id='l11_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
            }
            salida2 += "</tr>";
            listareg.push(index);
          });
          salida2 += "</table>";
          $("#tabla3").append(salida1);
          $("#resultados5").append(salida2);
        }
        if (tipo == "2")
        {
          $("#paso_excel").val(registros.valores);
          excel();
        }
      }
    });
  }
}
function modif(valor, valor1, valor2)
{
  $("#soportes").accordion({active: 0});
  $("#solicitud").html('');
  $("#fuente").html('');
  var valor, valor1, valor2;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "acti_consu1.php",
    data:
    {
      conse: valor,
      unidad: valor1,
      ano: valor2
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
      var plan = registros.plan;
      var firmas = registros.firmas;
      var salida = "";
      salida += "<option value='"+conse+"'>"+plan+"</option>";
      $("#solicitud").append(salida);
      $("#solicitud").prop("disabled",true);
      var fuente = registros.fuente;
      var salida1 = "";
      salida1 += "<option value='"+plan+"'>"+fuente+"</option>";
      $("#fuente").append(salida1);
      $("#fuente").prop("disabled",true);
      var con_firmas = 0;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('nom_')!=-1)
        {
          con_firmas ++;
        }
      }
      // Firmas
      var firmas = registros.firmas;
      var var_ocu = firmas.split('|');
      var var_ocu1 = var_ocu.length;
      var var_ocu2 = var_ocu1-2;
      var z = 0;
      for (var i=0; i<var_ocu1-1; i++)
      {      
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("»");
        z = z+1;
        var nom = var_2[0];
        nom = nom.trim();
        var car = var_2[1];
        car = car.trim();
        $("#nom_"+z).val(nom);
        $("#car_"+z).val(car);
        if (con_firmas > var_ocu2)
        {
        }
        else
        {
          if (i < var_ocu2)
          {
            $("#add_field").click();
          }
        }
      }
      $("#nom_1").prop("disabled",false);
      $("#car_1").prop("disabled",false);
      $("#add_field").show();
      var numero = registros.numero;
      $("#numero1").val(numero);
      $("#numero1").prop("disabled",false);
      $("#testigo").val(registros.testigo);
      $("#valor").val(registros.valor);
      $("#sintesis").val(registros.sintesis);
      $("#empleo").val(registros.empleo);
      $("#observa").val(registros.observacion);
      if (registros.difusion != "0")
      {
        $("#difusion").val(registros.difusion);
      }
      $("#uni_dif").val(registros.unidad1);
      $("#num_dif").val(registros.num_dif);
      $("#fec_dif").val(registros.fec_dif);
      $("#pys").val(registros.pys);
      $("#num_pag").val(registros.pagos);
      $("#actu").val('1');
      $("#aceptar").hide();
      $("#aceptar2").show();
      $("#numero1").focus();
    }
  });
}
function del_pdf(conse, ano, sigla, index)
{
  var conse, ano, index, archivo;
  archivo = "ActaPagFue_"+sigla+"_"+conse+"_"+ano+".pdf";
  var ruta = "Actas\\"+archivo;
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
function actualizar()
{
  var sintesis = $("#sintesis").val();
  var empleo = $("#empleo").val();
  var observa = $("#observa").val();
  var firmas = $("#firmas").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "acti_actu.php",
    data:
    {
      firmas: firmas,
      plan: $("#solicitud").val(),
      fuente: $("#fuente").val(),
      fuente1: $("#fuente option:selected").html(),
      numero: $("#numero1").val(),
      testigo: $("#testigo").val(),
      sintesis: sintesis,
      empleo: empleo,
      observa: observa,
      difusion: $("#difusion").val(),
      uni_dif: $("#uni_dif").val(),
      num_dif: $("#num_dif").val(),
      fec_dif: $("#fec_dif").val(),
      pys: $("#pys").val(),
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
      var valida;
      valida = registros.salida;
      if (valida > 0)
      {
        $("#aceptar").hide();
        $("#aceptar2").hide();
        $("#aceptar1").show();
        $("#plan_conse").val(valida);
        $("#plan_ano").val(registros.ano);
        $("#solicitud").prop("disabled",true);
        $("#numero1").prop("disabled",true);
        $("#testigo").prop("disabled",true);
        $("#numero1").prop("disabled",true);
        $("#fuente").prop("disabled",true);
        $("#valor").prop("disabled",true);
        $("#sintesis").prop("disabled",true);
        $("#difusion").prop("disabled",true);
        $("#empleo").prop("disabled",true);
        $("#observa").prop("disabled",true);
        $("#uni_dif").prop("disabled",true);
        $("#num_dif").prop("disabled",true);
        $("#fec_dif").prop("disabled",true);
        $("#pys").prop("disabled",true);
        for (i=0;i<document.formu.elements.length;i++)
        {
          saux=document.formu.elements[i].name;
          if (saux.indexOf('nom_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          saux=document.formu.elements[i].name;
          if (saux.indexOf('car_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        $("#add_field").hide();
        for (k=1;k<=10;k++)
        {
          $("#men_"+k).hide();
        }
        $("#actu").val('0');
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#aceptar").show();
      }
    }
  });
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
// 30/01/2024 - Eliminacion de archivos pdf guardados
?>