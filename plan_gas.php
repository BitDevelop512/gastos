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
    $mes = 1;
    $ano = $ano+1;
  }
  else
  {
    $mes = $mes+1;
  }
  $ano1 = date('Y');
  $query = "SELECT * FROM cx_ctr_ano WHERE ano='$ano1'";
  $sql = odbc_exec($conexion, $query);
  $tarifa1 = odbc_result($sql,2);
  $tarifa2 = odbc_result($sql,3);
  $tarifa3 = odbc_result($sql,4);
  $tarifa4 = number_format($tarifa1,2);
  $tarifa5 = number_format($tarifa2,2);
  $tarifa6 = number_format($tarifa3,2);
  $tarifa7 = odbc_result($sql,7);
  $tarifa8 = number_format($tarifa7,2);
  // Se consultan planes ya registrados de la unidad
  $consu = "SELECT conse FROM cx_gas_bas WHERE unidad='$uni_usuario'"; 
  $cur = odbc_exec($conexion, $consu);
  $numero = "";
  while($i<$row=odbc_fetch_array($cur))
  {
    $numero .= "'".odbc_result($cur,1)."',";
  }
  $numero = substr($numero,0,-1);
  // Se consulta unidad centralizadora
  $query = "SELECT dependencia, unidad FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur1 = odbc_exec($conexion, $query);
  $n_dependencia = odbc_result($cur1,1);
  $n_unidad = odbc_result($cur1,2);
  if ($n_unidad > 3)
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND unic='1'";
  }
  else
  {
    if (($uni_usuario == "2") or ($uni_usuario == "3") or ($uni_usuario == "4") or ($uni_usuario == "5") or ($uni_usuario == "344") or ($uni_usuario == "345") or ($uni_usuario == "346"))
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND unic='1'";
    }
    else
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' AND unic='1'";
    }
  }
  $cur2 = odbc_exec($conexion, $query1);
  $unic = odbc_result($cur2,1);
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
          <h3>Planilla Gastos B&aacute;sicos</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                	<label><font face="Verdana" size="2">Tarifa Fuera de Sede Pernoctado</font></label>
                </div>
               	<div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Tarifa Fuera de Sede No Pernoctado</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="tarifa1" id="tarifa1" class="form-control numero" value="<?php echo $tarifa4; ?>"><input type="hidden" name="tarifa4" id="tarifa4" class="form-control" value="<?php echo $tarifa1; ?>">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
               	<div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="tarifa2" id="tarifa2" class="form-control numero" value="<?php echo $tarifa5; ?>"><input type="hidden" name="tarifa5" id="tarifa5" class="form-control" value="<?php echo $tarifa2; ?>">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
              </div>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Gasto básico mensual</font></label>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Tarifa en la Sede</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="tarifa7" id="tarifa7" class="form-control numero" value="<?php echo $tarifa8; ?>"><input type="hidden" name="tarifa8" id="tarifa8" class="form-control" value="<?php echo $tarifa7; ?>">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="tarifa3" id="tarifa3" class="form-control numero" value="<?php echo $tarifa6; ?>"><input type="hidden" name="tarifa6" id="tarifa6" class="form-control" value="<?php echo $tarifa3; ?>">
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">ORDOP</font></label>
                  <select name="mision" id="mision" class="form-control select2" tabindex="1"></select>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Misi&oacute;n</font></label>
                  <select name="mision1" id="mision1" class="form-control select2" tabindex="2"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <br>
                  <input type="button" name="aceptar1" id="aceptar1" value="Validar">
                </div>
              </div>
              <br>
              <div id="datos1">
                <div class="row">
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Fecha</font></label>
                    <input type="text" name="fechas" id="fechas" class="form-control fecha" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">D&iacute;as Calculados</font></label>
                    <input type="text" name="dias" id="dias" class="form-control numero" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Valor Aprobado</font></label>
                    <input type="text" name="aprobado" id="aprobado" class="form-control numero" onfocus="blur();" readonly="readonly">
                    <input type="hidden" name="aprobado1" id="aprobado1" class="form-control numero" readonly="readonly">
                  </div>
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Misi&oacute;n Adicional</font></label>
                    <input type="text" name="adicional" id="adicional" class="form-control" maxlength="25" autocomplete="off">
                  </div>
                </div>
                <hr>
              </div>
              <div id="datos">
                <div id="add_form">
                  <table width="100%" align="center" border="0"></table>
                </div>
                <br>
                <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0"></a>
                <br><br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><div class="centrado"><font face="Verdana" size="2">Suman</font></div></label>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="t_sol" id="t_sol"  class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-3 col-xs-3">
                    <label><div class="centrado"><font face="Verdana" size="2">Total Planillas Anteriores</font></div></label>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="t_pla" id="t_pla"  class="form-control numero" value="0.00" readonly="readonly"><input type="hidden" name="t_pla1" id="t_pla1" class="form-control numero" readonly="readonly">
                  </div>
                </div>
                <div class="espacio1"></div>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><div class="centrado"><font face="Verdana" size="2">Responsable</font></div></label>
                  </div>
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <input type="text" name="responsable" id="responsable" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-3 col-xs-3">
                    <label><div class="centrado"><font face="Verdana" size="2">Suma Total de Planillas</font></div></label>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="t_pla2" id="t_pla2" class="form-control numero" value="0.00" readonly="readonly"><input type="hidden" name="t_pla3" id="t_pla3"  class="form-control numero" readonly="readonly">
                  </div>
                </div>
                <div class="espacio1"></div>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><div class="centrado"><font face="Verdana" size="2">Elabor&oacute;</font></div></label>
                  </div>
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" autocomplete="off">
                    <div class="espacio1"></div>
                    <input type="text" name="cargo" id="cargo" class="form-control" value="<?php echo $car_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" autocomplete="off">
                  </div>
                </div>
                <br><br>
                <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly">
                <input type="hidden" name="sigla" id="sigla" class="form-control" value="<?php echo $sig_usuario; ?>" readonly="readonly">
                <input type="hidden" name="n_ordop" id="n_ordop" class="form-control" readonly="readonly">
                <input type="hidden" name="cedulas" id="cedulas" class="form-control" readonly="readonly">
                <input type="hidden" name="nombres" id="nombres" class="form-control" readonly="readonly">
                <input type="hidden" name="ciudades" id="ciudades" class="form-control" readonly="readonly">
                <input type="hidden" name="v1s" id="v1s" class="form-control" readonly="readonly">
                <input type="hidden" name="v2s" id="v2s" class="form-control" readonly="readonly">
                <input type="hidden" name="v3s" id="v3s" class="form-control" readonly="readonly">
                <input type="hidden" name="v4s" id="v4s" class="form-control" readonly="readonly">
                <input type="hidden" name="v5s" id="v5s" class="form-control" readonly="readonly">
                <input type="hidden" name="valores" id="valores" class="form-control" readonly="readonly">
                <input type="hidden" name="valores1" id="valores1" class="form-control" readonly="readonly">
                <input type="hidden" name="centra" id="centra" class="form-control" value="<?php echo $unic; ?>" readonly="readonly">
                <input type="hidden" name="v_ano" id="v_ano" class="form-control" value="<?php echo $ano1; ?>" readonly="readonly">
                <input type="hidden" name="v_periodo" id="v_periodo" class="form-control" readonly="readonly">
                <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly">
                <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly">
                <input type="hidden" name="v_ciudad" id="v_ciudad" class="form-control" value="<?php echo $ciu_usuario; ?>" readonly="readonly">
                <input type="hidden" name="v_click" id="v_click" class="form-control" value="0" readonly="readonly">
                <center>
                  <font face="Verdana" size="2" color="#ff0000"><b>Presione una sola vez el bot&oacute;n Continuar</b></font>
                  <br><br>
                  <input type="button" name="aceptar" id="aceptar" value="Continuar">
                  <input type="button" name="aceptar2" id="aceptar2" value="Visualizar">
                </center>
              </div>
            </form>
          </div>
          <h3>Consultas</h3>
          <div>
            <div id="load1">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
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
              <div id="l_unidad">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Unidad</font></label>
                  <?php
                  $menu1_1 = odbc_exec($conexion,"SELECT subdepen, sigla FROM dbo.cf_sigla(1) ORDER BY sigla");
                  $menu1 = "<select name='unidad1' id='unidad1' class='form-control select2'>";
                  $i = 1;
                  $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
                  while($i<$row=odbc_fetch_array($menu1_1))
                  {
                    $nombre = trim($row['sigla']);
                    $menu1 .= "\n<option value=$row[subdepen]>".$nombre."</option>";
                    $i++;
                  }
                  $menu1 .= "\n</select>";
                  echo $menu1;
                  ?>
                </div>
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
            <form name="formu3" action="ver_gast.php" method="post" target="_blank">
              <input type="hidden" name="plan_conse" id="plan_conse" readonly="readonly">
              <input type="hidden" name="plan_interno" id="plan_interno" readonly="readonly">
              <input type="hidden" name="plan_ano" id="plan_ano" readonly="readonly">
              <input type="hidden" name="plan_unidad" id="plan_unidad" readonly="readonly">
              <input type="hidden" name="plan_sigla" id="plan_sigla" readonly="readonly">
            </form>
          </div>
          <div id="dialogo"></div>
          <div id="dialogo1"></div>
          <div id="dialogo2"></div>
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
  $("#load1").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 260,
    width: 550,
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
    height: 265,
    width: 680,
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
        paso();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
    width: 630,
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
        text: "Aceptar",
        click: function() {
          $(this).dialog("close");
        }
      }
    ]
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  trae_mision();
  $("#tarifa1").prop("disabled",true);
  $("#tarifa2").prop("disabled",true);
  $("#tarifa3").prop("disabled",true);
  $("#tarifa7").prop("disabled",true);
  $("#aceptar1").button();
  $("#aceptar1").click(busca);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").button();
  $("#aceptar").click(pregunta1);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(link);
  $("#aceptar2").hide();
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#datos1").hide();
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
      $("#add_form table").append('<tr><td colspan="1" class="espacio1"><div id="lbl1_'+z+'"><label><font face="Verdana" size="2">C&eacute;dula</font></label></div><input type="text" name="ced_'+z+'" id="ced_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" value="RESTRINGIDO" maxlength="15" autocomplete="off"></td><td>&nbsp;</td><td colspan="9"><div id="lbl2_'+z+'"><label><font face="Verdana" size="2">Grado, Apellido, Nombre o C&oacute;digo Operacional Participante</font></label></div><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td></tr><tr><td colspan="11" class="espacio1"><div id="lbl3_'+z+'"><label><font face="Verdana" size="2">Ciudad</font></label></div><input type="text" name="ciu_'+z+'" id="ciu_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="254" autocomplete="off"></td></tr><tr><td width="20%" class="espacio1"><div id="lbl4_'+z+'"><label><font face="Verdana" size="2">F.S. Pernoctado</font></label></div><input type="text" name="v1_'+z+'" id="v1_'+z+'" class="form-control numero" value="0" onkeypress="return check(event);" onblur="calculo('+z+');"></td><td width="1%">&nbsp;</td><td width="20%"><div id="lbl5_'+z+'"><label><font face="Verdana" size="2">F.S. No Pernoctado</font></label></div><input type="text" name="v2_'+z+'" id="v2_'+z+'" class="form-control numero" value="0" onkeypress="return check(event);" onblur="calculo('+z+');"></td><td width="1%">&nbsp;</td><td width="20%"><div id="lbl6_'+z+'"><label><font face="Verdana" size="2">En Sede</font></label></div><input type="text" name="v3_'+z+'" id="v3_'+z+'" class="form-control numero" value="0" onkeypress="return check(event);" onblur="calculo('+z+');"></td><td width="1%">&nbsp;</td><td width="10%" class="espacio1"><div id="lbl7_'+z+'"><label><font face="Verdana" size="2">Mes</font></label></div><input type="text" name="v5_'+z+'" id="v5_'+z+'" class="form-control numero" value="0" onkeypress="return check(event);" onblur="if (this.value == 1 || this.value == 0) {calculo('+z+');} else {this.value = 0; calculo('+z+');}"></td><td width="1%">&nbsp;</td><td width="20%"><div id="lbl8_'+z+'"><label><font face="Verdana" size="2">Valor</font></label></div><input type="text" name="vag_'+z+'" id="vag_'+z+'" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly"><input type="hidden" name="vat_'+z+'" id="vat_'+z+'" class="form-control numero" value="0"></td><td width="1%">&nbsp;</td><td width="20%"><div id="lbl9_'+z+'"><label><font face="Verdana" size="2">Consignaci&oacute;n</font></label></div><select name="v4_'+z+'" id="v4_'+z+'" class="form-control select2" style="width:300px"><option value="S">SI</option><option value="N">NO</option><option value="T">Transferencia</option><option value="G">Giro</option></select></td><td width="1%">&nbsp;</td><td width="5%"><div id="lbl10_'+z+'"><label><font face="Verdana" size="2">&nbsp;</font></label></div><div id="del_'+z+'"><a href="#" onclick="borra('+z+')"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr><tr><td colspan="11"><hr></td></tr>');
      //var v_ced = [<?php //echo $ayu_lla1; ?>];
      //$("#ced_"+z).autocomplete({source: v_ced});
      //var v_nom = [<?php //echo $ayu_lla2; ?>];
      //$("#nom_"+z).autocomplete({source: v_nom});
      $("#ced_"+z).on("paste", function(e){
        e.preventDefault();
        alerta("Acción No Permitida");
      });
      $("#nom_"+z).on("paste", function(e){
        e.preventDefault();
        alerta("Acción No Permitida");
      });
      x_1++;
      $("#v4_"+z).val('T');
      $("#vag_"+z).maskMoney();
      $("#ced_"+z).focus();
      $("#ciu_"+z).on("paste", function(e){
        e.preventDefault();
        alerta("Acci&oacute;n No Permitida");
      });
      $("html,body").animate({ scrollTop: 9999 }, "slow");
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    if(x_1 > 1)
    {
      $(this).closest('tr').remove();
    }
    return false;
  })
  $("#datos").hide();
  $("#mision").change(trae_mision1);
  var super1 = $("#super").val();
  if (super1 == "1")
  {
    $("#l_unidad").show();
  }
  else
  {
    $("#l_unidad").hide();
  }
  $("#adicional").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#responsable").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#elaboro").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#cargo").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#adicional").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#responsable").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#elaboro").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#cargo").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#unidad1").select2.defaults.set("width", "100%");
  $("#unidad1").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
});
</script>
<script>
function trae_perso(valor)
{
  var valor, valor1;
  valor1 = $("#ced_"+valor).val();
  valor2 = valor1.trim().length;
  if (valor2 > 0)
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_personas2.php",
      data:
      {
        cedula: valor1
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
        var nombre = registros.nombre;
        var total = registros.total;
        $("#nom_"+valor).val(nombre);
        if (total > 0)
        {
          $("#ciu_"+valor).focus();
        }
        else
        {
          $("#nom_"+valor).focus();
        }
      }
    });
  }
}
function pregunta1()
{
  var detalle = "<center><h3><font color='#3333ff'>LA PLANILLA SERA GUARDADA DE FORMA DEFINITIVA</font></h3></center><center><h3><font color='#ff0000'>POSTERIORMENTE NO PODRA SER MODIFICADA</font></center></h3><center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function calculo(valor)
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7, valor8, valor9, valor10, valor11, valor12, valor13, dias;
  dias = $("#dias").val();
  dias = parseInt(dias);
  valor1 = $("#tarifa4").val();
  valor2 = $("#tarifa5").val();
  valor3 = $("#tarifa6").val();
  valor12 = $("#tarifa8").val();
  valor4 = $("#v1_"+valor).val();
  if (valor4 == "")
  {
    $("#v1_"+valor).val('0');
    valor4 = $("#v1_"+valor).val();
  }
  valor4 = parseFloat(valor4);
  valor5 = $("#v2_"+valor).val();
  if (valor5 == "")
  {
    $("#v2_"+valor).val('0');
    valor5 = $("#v2_"+valor).val();
  }
  valor5 = parseFloat(valor5);
  valor6 = $("#v3_"+valor).val();
  if (valor6 == "")
  {
    $("#v3_"+valor).val('0');
    valor6 = $("#v3_"+valor).val();
  }
  valor6 = parseFloat(valor6);
  valor7 = valor1*valor4;
  valor8 = valor2*valor5;
  valor9 = valor3*valor6;
  valor13 = $("#v5_"+valor).val();
  if (valor13 == "")
  {
    $("#v5_"+valor).val('0');
    valor13 = $("#v5_"+valor).val();
  }
  valor13 = parseFloat(valor13);
  if (valor13 > 0)
  {
    valor10 = valor12;
    $("#v1_"+valor).prop("disabled",true);
    $("#v2_"+valor).prop("disabled",true);
    $("#v3_"+valor).prop("disabled",true);
  }
  else if ((valor4 > 0) || (valor5 > 0) || (valor6 > 0))
  {
    valor10 = valor7+valor8+valor9;
    $("#v5_"+valor).prop("disabled",true);
    $("#v1_"+valor).prop("disabled",false);
    $("#v2_"+valor).prop("disabled",false);
    $("#v3_"+valor).prop("disabled",false);
  }else{
    valor10 = "0";
    $("#v5_"+valor).prop("disabled",false);
    $("#v1_"+valor).prop("disabled",false);
    $("#v2_"+valor).prop("disabled",false);
    $("#v3_"+valor).prop("disabled",false);
  }
  valor10 = parseFloat(valor10);
  valor10 = valor10.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#vag_"+valor).val(valor10);
  valor11 = valor4+valor5+valor6;
  if (valor11 > dias)
  {
    detalle = "<center><h3>Total de Dias ("+valor11+") Superior a Total de Dias de Misi&oacute;n ("+dias+")</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#v1_"+valor).val('0');
    $("#v2_"+valor).val('0');
    $("#v3_"+valor).val('0');
    return;
  }
  paso_val(valor);
  suma();
}
function paso_val(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('vag_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vat_"+valor).val(valor1);
}
function paso_val1()
{
  var valor;
  valor = document.getElementById('aprobado').value;
  valor = parseFloat(valor.replace(/,/g,''));
  $("#aprobado1").val(valor);
}
function suma()
{
  var valor;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vat_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      valor2 = parseFloat(valor2);
      valor3 = valor3+valor2;
    }
  }
  var valor4 = $("#t_pla1").val();
  valor4 = parseFloat(valor4);
  valor5 = valor3+valor4;
  $("#t_pla3").val(valor5);
  valor5 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_pla2").val(valor5);
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_sol").val(valor3);
  suma1();
}
function suma1()
{  
  var detalle = "";
  var var1 = $("#aprobado1").val();
  var1 = parseFloat(var1);
  var var2 = $("#t_pla3").val();
  var2 = parseFloat(var2);
  var var3 = var2-var1;
  var var4 = $("#aprobado").val();
  var var5 = $("#t_pla2").val();
  if (var3 > 0)
  {
    detalle = "<center><h3>Valor Total de Planillas "+var5+" superior<br>al Total Aprobado de Misi&oacute;n "+var4+"</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#aceptar").hide();
  }
  else
  {
    if (var3 == "0")
    {
      $("#add_field").hide();
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux=document.formu.elements[i].name;
        if (saux.indexOf('ced_')!=-1)
        {
          document.getElementById(saux).setAttribute("disabled","disabled");
        }
        if (saux.indexOf('nom_')!=-1)
        {
          document.getElementById(saux).setAttribute("disabled","disabled");
        }
        if (saux.indexOf('ciu_')!=-1)
        {
          document.getElementById(saux).setAttribute("disabled","disabled");
        }
        if (saux.indexOf('v1_')!=-1)
        {
          document.getElementById(saux).setAttribute("disabled","disabled");
        }
        if (saux.indexOf('v2_')!=-1)
        {
          document.getElementById(saux).setAttribute("disabled","disabled");
        }
        if (saux.indexOf('v3_')!=-1)
        {
          document.getElementById(saux).setAttribute("disabled","disabled");
        }
        if (saux.indexOf('v5_')!=-1)
        {
          document.getElementById(saux).setAttribute("disabled","disabled");
        }
        if (saux.indexOf('vag_')!=-1)
        {
          document.getElementById(saux).setAttribute("disabled","disabled");
        }
      }
      var comprueba = $("#t_pla1").val();
      if (comprueba == "0")
      {
        $("#responsable").prop("disabled",false);
        $("#aceptar").show();  
      }
    }
    else
    {
      $("#aceptar").show();
    }
  }
}
function borra(valor)
{
  var valor;
  $("#lbl1_"+valor).hide();
  $("#lbl1_"+valor).remove();
  $("#lbl2_"+valor).hide();
  $("#lbl2_"+valor).remove();
  $("#lbl3_"+valor).hide();
  $("#lbl3_"+valor).remove();
  $("#lbl4_"+valor).hide();
  $("#lbl4_"+valor).remove();
  $("#lbl5_"+valor).hide();
  $("#lbl5_"+valor).remove();
  $("#lbl6_"+valor).hide();
  $("#lbl6_"+valor).remove();
  $("#lbl7_"+valor).hide();
  $("#lbl7_"+valor).remove();
  $("#lbl8_"+valor).hide();
  $("#lbl8_"+valor).remove();
  $("#lbl9_"+valor).hide();
  $("#lbl9_"+valor).remove();
  $("#ced_"+valor).val('');
  $("#ced_"+valor).hide();
  $("#ced_"+valor).remove();
  $("#nom_"+valor).val('');
  $("#nom_"+valor).hide();
  $("#nom_"+valor).remove();
  $("#ciu_"+valor).val('');
  $("#ciu_"+valor).hide();
  $("#ciu_"+valor).remove();
  $("#v1_"+valor).val('0');
  $("#v1_"+valor).hide();
  $("#v1_"+valor).remove();
  $("#v2_"+valor).val('0');
  $("#v2_"+valor).hide();
  $("#v2_"+valor).remove();
  $("#v3_"+valor).val('0');
  $("#v3_"+valor).hide();
  $("#v3_"+valor).remove();
  $("#v4_"+valor).val('0');
  $("#v4_"+valor).hide();
  $("#v4_"+valor).remove();
  $("#v5_"+valor).val('0');
  $("#v5_"+valor).hide();
  $("#v5_"+valor).remove();
  $("#vag_"+valor).val('0');
  $("#vag_"+valor).hide();
  $("#vag_"+valor).remove();
  $("#vat_"+valor).val('0');
  $("#vat_"+valor).hide();
  $("#vat_"+valor).remove();
  $("#del_"+valor).hide();
  suma();
}
function paso()
{
  var paso = $("#mision option:selected").html();
  $("#n_ordop").val(paso);
  document.getElementById('cedulas').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('ced_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('cedulas').value=document.getElementById('cedulas').value+valor+"|";
    }
  }
  document.getElementById('nombres').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('nombres').value=document.getElementById('nombres').value+valor+"|";
    }
  }
  document.getElementById('ciudades').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('ciu_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('ciudades').value=document.getElementById('ciudades').value+valor+"|";
    }
  }
  document.getElementById('v1s').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('v1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v1s').value=document.getElementById('v1s').value+valor+"|";
    }
  }
  document.getElementById('v2s').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('v2_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v2s').value=document.getElementById('v2s').value+valor+"|";
    }
  }
  document.getElementById('v3s').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('v3_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v3s').value=document.getElementById('v3s').value+valor+"|";
    }
  }
  document.getElementById('valores').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vag_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('valores').value=document.getElementById('valores').value+valor+"|";
    }
  }
  document.getElementById('valores1').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vat_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('valores1').value=document.getElementById('valores1').value+valor+"|";
    }
  }
  document.getElementById('v4s').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('v4_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v4s').value=document.getElementById('v4s').value+valor+"|";
    }
  }
  document.getElementById('v5s').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('v5_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v5s').value=document.getElementById('v5s').value+valor+"|";
    }
  }
  validacionData();
}
function validacionData()
{
  var salida = true, detalle = '';
  var v_adicional = $("#adicional").val();
  v_adicional = v_adicional.trim().length;
  if (v_adicional == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar Misión Adicional</h3></center>";
  }
  if ($("#t_sol").val() == '0.00')
  {
    salida = false;
    detalle += "<center><h3>Total de Gastos No Valido</h3></center>";
  }
  var v_respon = $("#responsable").val();
  v_respon = v_respon.trim().length;
  if (v_respon == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar un Responsable</h3></center>";
  }
  // Cedulas
  var v_cedulas = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('ced_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_cedulas ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_cedulas > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_cedulas+" C&eacute;dula(s)</h3></center>";
  }
  // Nombres
  var v_nombres = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_nombres ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_nombres > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_nombres+" Nombre(s)</h3></center>";
  }
  // Ciudades
  var v_ciudades = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('ciu_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_ciudades ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_ciudades > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_ciudades+" Ciudad(es)</h3></center>";
  }
  // Dias Planilla
  var v_dias = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('v1_')!=-1)
    {
      v_dias ++;
    }
  }
  var v_dias1 = 0;
  for (i=1;i<=v_dias;i++)
  {
    var v1 = $("#v1_"+i).val();
    v1 = parseInt(v1);
    var v2 = $("#v2_"+i).val();
    v2 = parseInt(v2);
    var v3 = $("#v3_"+i).val();
    v3 = parseInt(v3);
    var v5 = $("#v5_"+i).val();
    v5 = parseInt(v5);
    var total_dias = v1+v2+v3;
    if (total_dias == "0" && v5 == "0")
    {
      v_dias1++;
    }
  }
  if (v_dias1 > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe verificar sumatoria de "+v_dias1+" Día(s) registrados</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    nuevo();
  }
}
function nuevo()
{
  var clicando = $("#v_click").val();
  if (clicando == "1")
  {
    var detalle = "<center><h3>Botón Continuar ya Presionado</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#v_click").val('1');
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "pgas_grab.php",
      data:
      {
        n_ordop: $("#n_ordop").val(),
        mision: $("#mision").val(),
        mision1: $("#mision1").val(),
        mision2: $("#mision1 option:selected").html(),
        adicional: $("#adicional").val(),
        responsable: $("#responsable").val(),
        cedulas: $("#cedulas").val(),
        nombres: $("#nombres").val(),
        ciudades: $("#ciudades").val(),
        v1s: $("#v1s").val(),
        v2s: $("#v2s").val(),
        v3s: $("#v3s").val(),
        valores: $("#valores").val(),
        valores1: $("#valores1").val(),
        v4s: $("#v4s").val(),
        v5s: $("#v5s").val(),
        t_sol: $("#t_sol").val(),
        tarifa1: $("#tarifa4").val(),
        tarifa2: $("#tarifa5").val(),
        tarifa3: $("#tarifa6").val(),
        tarifa4: $("#tarifa8").val(),
        centra: $("#centra").val(),
        periodo: $("#v_periodo").val(),
        elaboro: $("#elaboro").val(),
        cargo: $("#cargo").val(),
        usuario: $("#v_usuario").val(),
        unidad: $("#v_unidad").val(),
        ciudad: $("#v_ciudad").val()
      },
      beforeSend: function ()
      {
        $("#load").show();
      },
      error: function (data)
      {
        $("#load").hide();
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      },
      success: function (data)
      {
        $("#load").hide();
        var registros = JSON.parse(data.replace(/[\uFEFF\xA0]/g, ""));
        var valida = registros.salida;
        var valida1 = registros.salida1;
        var valida2 = registros.salida2;
        if (valida2 == "1")
        {
          var detalle = "<center><h3>Planilla Ya Grabada, por favor verifique en Consultas</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          var v_unidad = $("#v_unidad").val();
          if (valida > 0)
          {
            $("#aceptar").hide();
            $("#aceptar2").show();
            $("#plan_conse").val(valida);
            $("#plan_interno").val(valida1);
            $("#plan_unidad").val(v_unidad);
            $("#adicional").prop("disabled",true);
            $("#responsable").prop("disabled",true);
            $("#elaboro").prop("disabled",true);
            $("#cargo").prop("disabled",true);
            for (i=0;i<document.formu.elements.length;i++)
            {
              saux=document.formu.elements[i].name;
              if (saux.indexOf('ced_')!=-1)
              {
                document.getElementById(saux).setAttribute("disabled","disabled");
              }
              if (saux.indexOf('nom_')!=-1)
              {
                document.getElementById(saux).setAttribute("disabled","disabled");
              }
              if (saux.indexOf('ciu_')!=-1)
              {
                document.getElementById(saux).setAttribute("disabled","disabled");
              }
              if (saux.indexOf('v1_')!=-1)
              {
                document.getElementById(saux).setAttribute("disabled","disabled");
              }
              if (saux.indexOf('v2_')!=-1)
              {
                document.getElementById(saux).setAttribute("disabled","disabled");
              }
              if (saux.indexOf('v3_')!=-1)
              {
                document.getElementById(saux).setAttribute("disabled","disabled");
              }
              if (saux.indexOf('vag_')!=-1)
              {
                document.getElementById(saux).setAttribute("disabled","disabled");
              }
              if (saux.indexOf('v4_')!=-1)
              {
                document.getElementById(saux).setAttribute("disabled","disabled");
              }
              if (saux.indexOf('v5_')!=-1)
              {
                document.getElementById(saux).setAttribute("disabled","disabled");
              }
            }
            for (j=1;j<=30;j++)
            {
              $("#del_"+j).hide();
            }
            $("#add_field").hide();
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
      }
    });
  }
}
function trae_mision()
{
  $("#mision").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_misiones.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var j = 0;
      for (var i in registros) 
      {
        j = j+1;
        var ordop = registros[i].ordop;
        var numero = registros[i].numero;
        numero = numero.trim();
        if (numero == "")
        {
          numero = "«";
        }
        salida += "<option value='"+ordop+"'>"+numero+" "+ordop+"</option>";
      }
      if (j == "0")
      {
        salida += "<option value='0'>NO HAY DISPONIBLES</option>";
        $("#mision").append(salida);
        $("#mision1").append(salida);
        $("#aceptar1").hide();
      }
      else
      {
        $("#mision").append(salida);
        $("#aceptar1").show();
        trae_mision1();
      }
    }
  });
}
function trae_mision1()
{
  var valor, valor1, valor2;
  valor = $("#mision").val();
  valor1 = $("#mision option:selected").html();
  var var_ocu = valor1.split(' ');
  valor2 = var_ocu[0];
  valor2 = valor2.trim();
  if (valor2 == "«")
  {
    valor2 = "";
  }
  $("#mision1").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_mision1.php",
    data:
    {
      ordop: valor,
      ordop1: valor2
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var conse = "";
      var mision = "";
      var internos = "";
      var salida = "";
      for (var i in registros) 
      {
        mision = registros[i].misiones;
        conse = registros[i].conse;
        internos = registros[i].internos;
        if (internos == false)
        {
        }
        else
        {
          var var_ocu = mision.split('|');
          var var_ocu1 = var_ocu.length;
          var var_ocu2 = internos.split(',');
          for (var i=0; i<var_ocu1-1; i++)
          {
            if ((var_ocu[i] == "") && (var_ocu2[i] == undefined))
            {
            }
            else
            {
  	          salida += "<option value='"+conse+"'>"+var_ocu[i]+" ¬ "+conse+" ¬ "+var_ocu2[i]+"</option>";
            }
          }
        }
      }
      $("#mision1").append(salida);
      if (salida == "")
      {
        $("#mision1").prop("disabled",true);
        $("#aceptar1").hide();
      }
      else
      {
        $("#mision1").prop("disabled",false);
        $("#aceptar1").show();
      }
    }
  });
}
function busca()
{
  var valor, valor1;
  valor = $("#mision").val();
  valor1 = $("#mision1").val();
  valor2 = $("#mision1 option:selected").html();
  valor3 = $("#mision option:selected").html();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_mision.php",
    data:
    {
      valor: valor,
      valor1: valor1,
      valor2: valor2,
      valor3: valor3
    },
    success: function (data)
    {
      $("#mision").prop("disabled",true);
      $("#mision1").prop("disabled",true);
      $("#aceptar1").hide();
      var registros = JSON.parse(data);
      var salida = registros.salida;
      var dias = registros.dias;
      var aprobado = registros.aprobado;
      var total = registros.total;
      $("#aprobado").val(aprobado);
      var periodo = registros.periodo;
      $("#v_periodo").val(periodo);
      paso_val1();
      var valida1 = $("#aprobado1").val();
      var suma = 0;
      var var_ocu = total.split('#');
      var var_ocu1 = var_ocu.length;
      var paso1;
      for (var i=0; i<var_ocu1; i++)
      {
        paso1 = var_ocu[i];
        paso1 = parseFloat(paso1.replace(/,/g,''));
        suma = suma+paso1;
      }
      suma = parseInt(suma);
      if (suma > valida1)
      {
        suma = 0;
      }
      $("#t_pla1").val(suma);
      suma = suma.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#t_pla").val(suma);
      $("#dias").val(salida);
      $("#fechas").val(dias);
      $("#datos").show();
      $("#datos1").show();
      $("#add_field").click();
      if (aprobado == suma)
      {
        var detalle = "Total planillas anteriores igual a valor aprobado, no se puede continuar";
        alerta(detalle);
        $("#aceptar").hide();
        $("#adicional").prop("disabled",true);
        $("#responsable").prop("disabled",true);
        $("#elaboro").prop("disabled",true);
        $("#cargo").prop("disabled",true);
        $("#ced_0").prop("disabled",true);
        $("#nom_0").prop("disabled",true);
        $("#ciu_0").prop("disabled",true);
        $("#v1_0").prop("disabled",true);
        $("#v2_0").prop("disabled",true);
        $("#v3_0").prop("disabled",true);
        $("#v4_0").prop("disabled",true);
        $("#add_field").hide();
      }
      else
      {
        $("#aceptar").show();
        $("#adicional").prop("disabled",false);
        $("#responsable").prop("disabled",false);
        $("#elaboro").prop("disabled",false);
        $("#cargo").prop("disabled",false);
        $("#ced_0").prop("disabled",false);
        $("#nom_0").prop("disabled",false);
        $("#ciu_0").prop("disabled",false);
        $("#v1_0").prop("disabled",false);
        $("#v2_0").prop("disabled",false);
        $("#v3_0").prop("disabled",false);
        $("#v4_0").prop("disabled",false);
        $("#add_field").show();
        var detalle = "<h3><center>Debe registrar el número de planilla adicional si aplica, de lo contrario debe digitar N/A</center></h3>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
        $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
      calculo(1);
    }
  });
}
function link()
{
  var valor = $("#plan_conse").val();
  var valor1 = $("#plan_interno").val();
  var valor2 = $("#v_ano").val();
  var valor3 = $("#v_unidad").val();
  var valor4 = $("#sigla").val();
  $("#plan_conse").val(valor);
  $("#plan_interno").val(valor1);
  $("#plan_ano").val(valor2);
  $("#plan_unidad").val(valor3);
  $("#plan_sigla").val(valor4);
  formu3.submit();
}
function link1(valor, valor1, valor2, valor3, valor4)
{
  var valor, valor1, valor2, valor3, valor4;
  $("#plan_conse").val(valor);
  $("#plan_interno").val(valor1);
  $("#plan_ano").val(valor2);
  $("#plan_unidad").val(valor3);
  $("#plan_sigla").val(valor4);
  formu3.submit();
}
function del_pdf(conse, ano, sigla, index)
{
  var conse, ano, index, archivo;
  archivo = "PlanGas_"+sigla+"_"+conse+"_"+ano+".pdf";
  var ruta = "Planillas\\"+ano+"\\"+archivo;
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
function des_gas(conse, ano, periodo, unidad)
{
  var conse, ano, periodo, unidad;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "gast_consu1.php",
    data:
    {
      conse: conse,
      ano: ano,
      periodo: periodo,
      unidad: unidad
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
      detalle = "Descarga Finalizada";
      alerta1(detalle);
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
      url: "gast_consu.php",
      data:
      {
        fecha1: $("#fecha1").val(),
        fecha2: $("#fecha2").val(),
        unidad: $("#unidad1").val()
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
        $("#tabla3").html('');
        $("#resultados5").html('');
        var registros = JSON.parse(data);
        var valida, valida1;
        var salida1 = "";
        var salida2 = "";
        listareg = [];
        valida = registros.salida;
        valida1 = registros.total;
        salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
        salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='5%'><b>No.</b></td><td height='35' width='8%'><b>Fecha</b></td><td height='35' width='8%'><b>Unidad</b></td><td height='35' width='8%'><b>Usuario</b></td><td height='35' width='28%'><b>Ordop</b></td><td height='35' width='17%'><b>Misi&oacute;n</b></td><td height='35' width='10%'><b>Total</b></td><td height='35' width='4%'>&nbsp;</td><td height='35' width='4%'>&nbsp;</td><td height='35' width='4%'>&nbsp;</td><td height='35' width='4%'>&nbsp;</td></tr></table>";
        salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
        $.each(registros.rows, function (index, value)
        {
          var datos1 = '\"'+value.conse+'\",\"'+value.ano+'\",\"'+value.unidad+'\",\"'+index+'\"';
          var datos2 = '\"'+value.conse+'\",\"'+value.interno+'\",\"'+value.ano+'\",\"'+value.unidad1+'\",\"'+value.unidad+'\"';
          var servidor = value.servidor;
          salida2 += "<tr><td width='5%' height='35' id='l1_"+index+"'>"+value.conse+"</td>";
          salida2 += "<td width='8%' height='35' id='l2_"+index+"'>"+value.fecha+"</td>";
          salida2 += "<td width='8%' height='35' id='l3_"+index+"'>"+value.unidad+"</td>";
          salida2 += "<td width='8%' height='35' id='l4_"+index+"'>"+value.usuario+"</td>";
          salida2 += "<td width='28%' height='35' id='l5_"+index+"'>"+value.ordop+"</td>";
          salida2 += "<td width='17%' height='35' id='l6_"+index+"'>"+value.mision+"</td>";
          salida2 += "<td width='10%' height='35' id='l7_"+index+"' align='right'>"+value.total+"</td>";
          salida2 += "<td width='4%' height='35' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); link1("+datos2+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td>";
          // Contingencia
          if (servidor == "C")
          {
            salida2 += "<td width='4%' height='35' id='l9_"+index+"'><center><img src='dist/img/server.png' width='25' height='25' border='0' title='Contingencia'></center></td>";
          }
          else
          {
            salida2 += "<td width='4%' height='35' id='l9_"+index+"'>&nbsp;</td>";
          }
          if (super1 == "1")
          {
            salida2 += "<td width='4%' height='35' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); des_gas("+value.conse+","+value.ano+","+value.periodo+","+value.unidad1+");'><img src='dist/img/download.png' width='32' height='32' border='0' title='Descargar'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='4%' height='35' id='l10_"+index+"'>&nbsp;</td>";
          }
          // Eliminar PDF Final
          if (super1 == "1")
          {
            salida2 += "<td width='4%' height='35' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); del_pdf("+datos1+");'><img src='dist/img/delete.png' name='pdf_"+index+"' id='pdf_"+index+"' width='29' height='29' border='0' title='Eliminar PDF'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='4%' height='35' id='l11_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
          }
          salida2 += "</tr>";
          listareg.push(index);
        });
        salida2 += "</table>";
        $("#tabla3").append(salida1);
        $("#resultados5").append(salida2);
      }
    });
  }
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
function check1(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9-]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
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
// 26/01/2024 - Eliminacion de archivos pdf guardados
// 06/02/2024 - Envio de unidad
// 22/02/2024 - Ajuste envio sigla generacion pdf
// 04/03/2024 - Inclusion filtro de uinidad para super usuario
// 23/05/2024 - Validacion misiones disponibles
// 05/08/2024 - Ajuste inclusion cargo eloboro
// 22/11/2024 - Ajuste identificador contingencia
// 19/03/2025 - Ajuste DINCI unidad centralizadora
// 22/04/2025 - Ajuste buscador campo unidad
?>