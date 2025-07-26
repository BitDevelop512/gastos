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
  $mes = date('m');
  $mes = intval($mes);
  $mes1 = intval($mes)+1;
  if ($mes1 == "13")
  {
    $mes1 = 1;
  }
  $ano = date('Y');
  $dateObj = DateTime::createFromFormat('!m', $mes);
  $monthName = $dateObj->format('F');
  $dateObj1 = DateTime::createFromFormat('!m', $mes1);
  $monthName1 = $dateObj1->format('F');
  $mes_act = nombre_mes($mes);
  $mes_sig = nombre_mes($mes1);
  $tipo = "1"; 
  $query = "SELECT firma1, firma2, firma3, firma4, cargo1, cargo2, cargo3, cargo4, saldo FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $query);
  $firma1 = trim(utf8_encode(odbc_result($cur,1)));
  $firma2 = trim(utf8_encode(odbc_result($cur,2)));
  $firma3 = trim(utf8_encode(odbc_result($cur,3)));
  $firma4 = trim(utf8_encode(odbc_result($cur,4)));
  $cargo1 = trim(utf8_encode(odbc_result($cur,5)));
  $cargo2 = trim(utf8_encode(odbc_result($cur,6)));
  $cargo3 = trim(utf8_encode(odbc_result($cur,7)));
  $cargo4 = trim(utf8_encode(odbc_result($cur,8)));
  $saldo = odbc_result($cur,9);
  $saldo1 = number_format($saldo,2);
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
          <h3>Comprobantes de Ingreso</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Nº Ingreso</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Mes</font></label>
                </div>
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Cuenta Bancaria</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Saldo</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
	              <input type="hidden" name="tipo" id="tipo" class="form-control" value="<?php echo $tipo; ?>" readonly="readonly" tabindex="0">
	              <input type="hidden" name="subdependencia" id="subdependencia" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
	              <input type="hidden" name="unidad2" id="unidad2" class="form-control" value="<?php echo $nun_usuario; ?>" readonly="readonly" tabindex="0">
                <input type="hidden" name="n_ano" id="n_ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly" tabindex="0">
                <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                <input type="hidden" name="v_ciudad" id="v_ciudad" class="form-control" value="<?php echo $ciu_usuario; ?>" readonly="readonly" tabindex="0">
                <input type="hidden" name="v_giros" id="v_giros" class="form-control" value="" readonly="readonly" tabindex="0">
                <input type="hidden" name="v_giros1" id="v_giros1" class="form-control" value="" readonly="readonly" tabindex="0">
                <input type="hidden" name="v_fechas" id="v_fechas" class="form-control" value="" readonly="readonly" tabindex="0">
                <input type="text" name="numero" id="numero" class="form-control numero" value="0" onblur="consulta();" tabindex="1">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              		<input type="text" name="fecha" id="fecha" class="form-control fecha" value="<?php echo $fecha; ?>" readonly="readonly" tabindex="2">
              	</div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
	            	  <select name="periodo" id="periodo" class="form-control select2" tabindex="3" onchange="trae_valores();">
	                	<option value="<?php echo $mes; ?>"><?php echo $mes_act; ?></option>
	                	<option value="<?php echo $mes1; ?>"><?php echo $mes_sig; ?></option>
                  </select>
                </div>
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <select name="cuenta" id="cuenta" class="form-control select2" tabindex="4" onchange="trae_saldos(); trae_crps(); trae_valores();"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="saldo" id="saldo" class="form-control numero" value="<?php echo $saldo1; ?>" readonly="readonly" tabindex="5">
                  <input type="hidden" name="saldo1" id="saldo1" class="form-control numero" value="<?php echo $saldo; ?>" readonly="readonly" tabindex="6">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7">
                  <label><font face="Verdana" size="2">Origen</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7">
                  <input type="text" name="origen" id="origen" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" tabindex="7" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Concepto</font></label>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Valor</font></label>
                </div>
                <div id="u_unidad2">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Unidad</font></label>
                  </div>
                </div>
                <div id="u_unidad3">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Concepto del Gasto</font></label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <?php
                  $menu2_2 = odbc_exec($conexion,"SELECT * FROM cx_ctr_gas WHERE tipo='1' ORDER BY orden");
                  $menu2 = "<select name='concepto' id='concepto' class='form-control select2' tabindex='8'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu2_2))
                  {
                    $nombre = utf8_encode($row['nombre']);
                    $menu2 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  $menu2 .= "\n</select>";
                  echo $menu2;
                  ?>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <select name="valor" id="valor" class="form-control select2" tabindex="9" onchange="trae_giro();"></select>
                  <input type="text" name="valor1" id="valor1" class="form-control numero" value="0.00" onkeyup="paso_val();" tabindex="10">
                  <input type="hidden" name="valor2" id="valor2" class="form-control numero" value="0" tabindex="11">
                </div>
                <div id="u_unidad1">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <select name="unidad1" id="unidad1" class="form-control select2" tabindex="13"></select>
                  </div>
                </div>
                <div id="u_unidad4">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <select name="tp_gasto" id="tp_gasto" class="form-control select2" tabindex="14">
                      <option value="1">GASTOS EN ACTIVIDADES</option>
                      <option value="2">PAGO DE INFORMACIONES</option>
                      <option value="3">PAGO DE RECOMPENSAS</option>
                      <?php 
                      if ($uni_usuario == "1")
                      {
                      ?>
                        <option value="0">DEVOLUCIONES A CEDE2</option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">CRP</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">CDP</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Recurso</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Rubro</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <select name="crp" id="crp" class="form-control select2" tabindex="15"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <select name="cdp" id="cdp" class="form-control select2" tabindex="16"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <select name="recurso" id="recurso" class="form-control select2" tabindex="17">
                    <option value="1">10 CSF</option>
                    <option value="2">50 SSF</option>
                    <option value="3">16 SSF</option>
                    <option value="4">OTROS</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <select name="rubro" id="rubro" class="form-control select2" tabindex="18">
                    <option value="3">A-02-02-04</option>
                    <option value="1">204-20-1</option>
                    <option value="2">204-20-2</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Soporte</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">N&uacute;mero</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Transacci&oacute;n Bancaria</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <select name="soporte" id="soporte" class="form-control select2" tabindex="19">
                    <option value="1">INFORME DE GIRO CEDE2</option>
                    <option value="2">CONSIGNACI&Oacute;N</option>
                    <option value="3">HR. AUTORIZACIÓN DEVOLUCI&Oacute;N CEDE2</option>
                    <option value="4">ABONO EN CUENTA</option>
                    <option value="5">ORDEN DE PAGO SIIF</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="num_sop" id="num_sop" class="form-control numero" value="0" tabindex="20">
                  <input type="hidden" name="int_sop" id="int_sop" class="form-control numero" value="0" tabindex="21">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="fec_sop" id="fec_sop" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="22">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                 <select name="transaccion" id="transaccion" class="form-control select2" tabindex="23">
                    <option value="1">TRANSFERENCIA</option>
                    <option value="2">CONSIGNACIÓN</option>
                    <option value="3">NOTA CREDITO</option>
                    <option value="4">ABONO EN CUENTA</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Ejecutor GGRR</font></label>
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">JEM</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <input type="text" name="firma1" id="firma1" class="form-control" value="<?php echo $firma1; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="24" autocomplete="off">
                  <div class="espacio1"></div>
                  <input type="text" name="cargo1" id="cargo1" class="form-control" value="<?php echo $cargo1; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="25" autocomplete="off">
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <input type="text" name="firma2" id="firma2" class="form-control" value="<?php echo $firma2; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="26" autocomplete="off">
                  <div class="espacio1"></div>
                  <input type="text" name="cargo2" id="cargo2" class="form-control" value="<?php echo $cargo2; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="27" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Comandante</font></label>
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Elabor&oacute;</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <input type="text" name="firma3" id="firma3" class="form-control" value="<?php echo $firma3; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="28" autocomplete="off">
                  <div class="espacio1"></div>
                  <input type="text" name="cargo3" id="cargo3" class="form-control" value="<?php echo $cargo3; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="29" autocomplete="off">
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <input type="text" name="firma4" id="firma4" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="30" autocomplete="off">
                  <div class="espacio1"></div>
                  <input type="text" name="cargo4" id="cargo4" class="form-control" value="<?php echo $car_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="31" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"></div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <center>
                    <input type="button" name="aceptar" id="aceptar" value="Continuar" tabindex="32">
                    <input type="button" name="aceptar1" id="aceptar1" value="Visualizar" tabindex="33">
                    <input type="button" name="aceptar2" id="aceptar2" value="Actualizar" tabindex="34">
                  </center>
                </div>
              </div>
            </form>
            <form name="formu1" action="ver_comp.php" method="post" target="_blank">
              <input type="hidden" name="comp_tipo" id="comp_tipo" class="form-control" readonly="readonly">
              <input type="hidden" name="comp_conse" id="comp_conse" class="form-control" readonly="readonly">
              <input type="hidden" name="comp_ano" id="comp_ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly">
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
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
  $("#fec_sop").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 220,
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
        graba();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#concepto").change(trae_valores);
  $("#valor1").maskMoney();
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(link);
  $("#aceptar1").hide();
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").hide();
  $("#aceptar2").click(actualizar);
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#u_unidad1").hide();
  $("#u_unidad2").hide();
  $("#u_unidad3").hide();
  $("#u_unidad4").hide();
  trae_crp();
  trae_cdp();
  $("#numero").prop("disabled",true);
  $("#fecha").prop("disabled",true);
  $("#cdp").prop("disabled",true);
  $("#crp").prop("disabled",true);
  $("#recurso").prop("disabled",true);
  $("#rubro").prop("disabled",true);
  $("#unidad1").prop("disabled",true);
  $("#tp_gasto").prop("disabled",true);
  trae_valores();
  $("#crp").change(busca);
  trae_unidades();
  $("#periodo").focus();
  $("#periodo").mousedown(function(event) {
    switch (event.which)
    {
      case 3:
        $("#numero").prop("disabled",false);
        break;
      default:
        break;
    }
  });
  $("#valor1").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  trae_cuentas();
});
function trae_crp()
{
  $("#crp").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_crps.php",
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
      $("#crp").append(salida);
      busca();
    }
  });
}
function trae_crp1()
{
  $("#crp").html('');
  var salida = "<option value='0'>- NO APLICA -</option>";
  $("#crp").append(salida);
}
function trae_crps()
{
  $("#crp").html('');
  var cuenta = $("#cuenta").val();
  if ((cuenta === undefined) || (cuenta === null))
  {
    cuenta = "1|";
  }
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_crps2.php",
    data:
    {
      cuenta: cuenta1
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
      $("#crp").append(salida);
      busca();
    }
  });
}
function trae_cdp()
{
  $("#cdp").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cdps1.php",
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
      $("#cdp").append(salida);
    }
  });
}
function trae_cdp1()
{
  $("#cdp").html('');
  var salida = "<option value='0'>- NO APLICA -</option>";
  $("#cdp").append(salida);
}
function trae_unidades()
{
  var unidad = $("#unidad2").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unidad.php",
    data:
    {
      unidad: unidad
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var salida1 = "";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#unidad1").append(salida);
    }
  });
}
function trae_cuentas()
{
  $("#cuenta").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cuentas1.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
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
function trae_saldos()
{
  var valores = $("#cuenta").val();
  var var_ocu = valores.split('|');
  var saldo = var_ocu[1];
  var saldo1 = var_ocu[2];
  $("#saldo").val(saldo1);
  $("#saldo1").val(saldo);
}
function busca()
{
  var cuenta = $("#cuenta").val();
  if ((cuenta === undefined) || (cuenta === null))
  {
    cuenta = "1|";
  }
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  var crp = $("#crp").val();
  var crp1 = $("#crp option:selected").html();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cdps2.php",
    data:
    {
      crp: crp,
      crp1: crp1
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var recurso = registros.recurso;
      var rubro = registros.rubro;
      var conse = registros.conse;
      var cdp = registros.cdp;
      $("#cdp").val(conse);
      if ((cuenta1 == "1") || (cuenta1 == "3"))
      {
        $("#recurso").val(recurso);
        $("#rubro").val(rubro);
      }
      else
      {
        $("#recurso").val('3');
        $("#rubro").val('3');
      }
    }
  });
}
function paso_val()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('valor1').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#valor2").val(valor1);
}
function trae_valores()
{
  var cuenta = $("#cuenta").val();
  if ((cuenta === undefined) || (cuenta === null))
  {
    cuenta = "1|";
  }
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  var valida = $("#concepto").val();
  var subdepen = $("#subdependencia").val();
  $("#crp").prop("disabled",true);
  if ((valida == "8") || (valida == "9") || (valida == "10"))
  {
    trae_cdp();
    trae_crps();
    // Validacion cuenta DTN
    if (cuenta1 == "3")
    {
      $("#valor").hide();
      $("#valor").val('0');
      $("#valor1").show();
      $("#crp").prop("disabled",false);
    }
    else
    {
      $("#valor").show();
      $("#valor1").hide();
      $("#valor").html('');
    }
    $("#num_sop").val('0');
    $("#fec_sop").val('');
    if (cuenta1 == "3")
    {
    }
    else
    {
      $.ajax({
        type: "POST",
        datatype: "json",
        url: "trae_valores.php",
        data:
        {
          concepto: $("#concepto").val(),
          periodo: $("#periodo").val()
        },
        success: function (data)
        {
          var registros = JSON.parse(data);
          var salida = "";
          var salida1 = "";
          var salida2 = "";
          var salida3 = "";
          for (var i in registros) 
          {
            var codigo = registros[i].codigo;
            codigo = codigo.trim();
            var nombre = registros[i].nombre;
            nombre = nombre.trim();
            salida += "<option value='"+codigo+"'>"+nombre+"</option>";
            var num_giro = registros[i].giro;
            salida1 += num_giro+",";
            var fec_giro = registros[i].fec_giro;
            salida2 += fec_giro+",";
            var int_giro = registros[i].giro1;
            salida3 += int_giro+",";
            if (num_giro > 0)
            {
              var crp_giro = registros[i].crp_giro;
              var cdp_giro = registros[i].cdp_giro;
              var rec_giro = registros[i].rec_giro;
              var rub_giro = registros[i].rub_giro;
              $("#num_sop").val(num_giro);
              $("#int_sop").val(int_giro);
              $("#fec_sop").val(fec_giro);
              $("#crp").val(crp_giro);
              $("#cdp").val(cdp_giro);
              $("#recurso").val(rec_giro);
              $("#rubro").val(rub_giro);
              $("#num_sop").prop("disabled",true);
              $("#int_sop").prop("disabled",true);
              $("#fec_sop").prop("disabled",true);
              $("#soporte").prop("disabled",true);
              $("#transaccion").prop("disabled",true);
              $("#aceptar").show();             
            }
            else
            {
              $("#num_sop").prop("disabled",false);
              $("#fec_sop").prop("disabled",false);
              $("#soporte").prop("disabled",false);
              $("#transaccion").prop("disabled",false);
              $("#aceptar").hide();
            }
          }
          $("#valor").append(salida);
          $("#v_giros").val(salida1);
          $("#v_fechas").val(salida2);
          $("#v_giros1").val(salida3);
          if (num_giro > 0)
          {
            var v_1 = $("#v_giros").val();
            var v_2 = $("#v_fechas").val();
            var v_3 = $("#v_giros1").val();
            var var_ocg = v_1.split(',');
            var var_ocf = v_2.split(',');
            var var_oci = v_3.split(',');
            $("#num_sop").val(var_ocg[0]);
            $("#fec_sop").val(var_ocf[0]);
            $("#int_sop").val(var_oci[0]);
          }
        }
      });
    }
    if (cuenta1 == "3")
    {
      $("#aceptar").show(); 
    }
    $("#u_unidad1").hide();
    $("#u_unidad2").hide();
    $("#u_unidad3").hide();
    $("#u_unidad4").hide();
    $("#unidad1").prop("disabled",true);
    $("#tp_gasto").prop("disabled",true);
  }
  else
  {
    $("#valor").hide();
    $("#valor").val('0');
    $("#num_sop").val('0');
    $("#int_sop").val('0');
    $("#fec_sop").val('');
    $("#valor1").show();
    if (valida == "20")
    {
      trae_crp1();
      trae_cdp1();
    }
    else
    {
      if ((valida == "22") || (valida == "23"))
      {
      }
      else
      {
        trae_cdp();
        trae_crps();
      }
    }   
    $("#soporte").prop("disabled",false);
    $("#num_sop").prop("disabled",false);
    $("#fec_sop").prop("disabled",false);
    if (subdepen == "1")
    {
      $("#crp").prop("disabled",false);
      $("#cdp").prop("disabled",true);
    }
    else
    {
      if ((valida == "1") || (valida == "11") || (valida == "12") || (valida == "16"))
      {
        if (subdepen == "1")
        {
          $("#crp").prop("disabled",false);
          $("#cdp").prop("disabled",true);
        }
        else
        {
          $("#crp").prop("disabled",true);
          $("#cdp").prop("disabled",true);          
        }
      }
      else
      {
        $("#crp").prop("disabled",true);
        $("#cdp").prop("disabled",true);
      }
    }
    $("#recurso").prop("disabled",true);
    $("#rubro").prop("disabled",true);
    $("#transaccion").prop("disabled",false);
    $("#aceptar").show();
    if ((valida == "1") || (valida == "11") || (valida == "16") || (valida == "25"))
    {
      $("#u_unidad1").show();
      $("#u_unidad2").show();
      $("#u_unidad3").show();
      $("#u_unidad4").show();
      $("#unidad1").prop("disabled",false);
      $("#tp_gasto").prop("disabled",false);
    }
    else
    {
      $("#u_unidad1").hide();
      $("#u_unidad2").hide();
      $("#u_unidad3").hide();
      if (valida == "20")
      {
        $("#crp").prop("disabled",true);
        trae_crp1();
        trae_cdp1();
        $("#u_unidad4").show();
        $("#tp_gasto").prop("disabled",false);
      }
      else
      {
        $("#u_unidad4").hide();
        $("#tp_gasto").prop("disabled",true);
        if ((valida == "22") || (valida == "23"))
        {
          $("#crp").prop("disabled",true);
          trae_crp1();
          trae_cdp1();
        }
      }
      $("#unidad1").prop("disabled",true);
    }
  }
}
function trae_giro()
{
  var index = $("#valor")[0].selectedIndex;
  var v_1 = $("#v_giros").val();
  var v_2 = $("#v_fechas").val();
  var v_3 = $("#v_giros1").val();
  var var_ocg = v_1.split(',');
  var var_ocf = v_2.split(',');
  var var_oci = v_3.split(',');
  $("#num_sop").val(var_ocg[index]);
  $("#fec_sop").val(var_ocf[index]);
  $("#int_sop").val(var_oci[index]);
}

function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function graba()
{
  var cuenta = $("#cuenta").val();
  if ((cuenta === undefined) || (cuenta === null))
  {
    cuenta = "1|";
  }
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  var valida = $("#concepto").val();
  var salida = true, detalle = '';
  if ((valida == "8") || (valida == "9") || (valida == "10"))
  {
    if (cuenta1 == "3")
    {
      if (($("#valor1").val() == '0.00') || ($("#valor1").val() == ''))
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar el Valor del Ingreso</h3></center>";
      }
    }
    else
    {
      if (valida == "8")
      {
        if ($("#valor").val() == '0')
        {
          salida = false;
          detalle += "<center><h3>Valor del Ingreso No Permitido</h3></center>";
        }
      }
    }
  }
  else
  {
    if (($("#valor1").val() == '0.00') || ($("#valor1").val() == ''))
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar el Valor del Ingreso</h3></center>";
    }
  }
  if ($("#fec_sop").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar Fecha de Soporte</h3></center>";
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
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "ing_grab.php",
    data:
    {
      tipo: $("#tipo").val(),
      origen: $("#origen").val(),
      concepto: $("#concepto").val(),
      periodo: $("#periodo").val(),
      valor: $("#valor").val(),
      valor1: $("#valor1").val(),
      valor2: $("#valor2").val(),
      soporte: $("#soporte").val(),
      cdp: $("#cdp").val(),
      crp: $("#crp").val(),
      recurso: $("#recurso").val(),
      rubro: $("#rubro").val(),
      cuenta: $("#cuenta").val(),
      numero: $("#num_sop").val(),
      interno: $("#int_sop").val(),
      fecha: $("#fec_sop").val(),
      transaccion: $("#transaccion").val(),
      unidad1: $("#unidad1").val(),
      tp_gasto: $("#tp_gasto").val(),
      firma1: $("#firma1").val(),
      firma2: $("#firma2").val(),
      firma3: $("#firma3").val(),
      firma4: $("#firma4").val(),
      cargo1: $("#cargo1").val(),
      cargo2: $("#cargo2").val(),
      cargo3: $("#cargo3").val(),
      cargo4: $("#cargo4").val(),
      usuario: $("#v_usuario").val(),
      unidad: $("#v_unidad").val(),
      ciudad: $("#v_ciudad").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var valida;
      valida = registros.salida;
      if (valida > 0)
      {
        $("#numero").val(valida);
        $("#aceptar").hide();
        $("#aceptar1").show();
        $("#aceptar1").click();
        $("#periodo").prop("disabled",true);
        $("#origen").prop("disabled",true);
        $("#concepto").prop("disabled",true);
        $("#cdp").prop("disabled",true);
        $("#crp").prop("disabled",true);
        $("#recurso").prop("disabled",true);
        $("#rubro").prop("disabled",true);
        $("#cuenta").prop("disabled",true);
        $("#valor").prop("disabled",true);
        $("#valor1").prop("disabled",true);
        $("#soporte").prop("disabled",true);
        $("#tp_gasto").prop("disabled",true);
        $("#num_sop").prop("disabled",true);
        $("#fec_sop").prop("disabled",true);
        $("#transaccion").prop("disabled",true);
        $("#unidad1").prop("disabled",true);
        $("#firma1").prop("disabled",true);
        $("#firma2").prop("disabled",true);
        $("#firma3").prop("disabled",true);
        $("#firma4").prop("disabled",true);
        $("#cargo1").prop("disabled",true);
        $("#cargo2").prop("disabled",true);
        $("#cargo3").prop("disabled",true);
        $("#cargo4").prop("disabled",true);
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
function link()
{
  var ingreso;
  ingreso = $("#numero").val();
  $("#comp_tipo").val('1');
  $("#comp_conse").val(ingreso);
  formu1.submit();
}
function consulta()
{
  var numero = $("#numero").val();
  var ano = $("#n_ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "ing_consu.php",
    data:
    {
      numero: numero,
      ano: ano
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var valida = registros.salida;
      if (valida > 0)
      {
        $("#firma1").val('');
        $("#firma2").val('');
        $("#firma3").val('');
        $("#firma4").val('');
        $("#cargo1").val('');
        $("#cargo2").val('');
        $("#cargo3").val('');
        $("#cargo4").val('');
        $("#numero").prop("disabled",true);
        var periodo = registros.periodo;
        periodo = parseInt(periodo);
        switch (periodo)
        {
          case 1:
            var periodo1 = "<option value='1'>ENERO</option>";
            break;
          case 2:
            var periodo1 = "<option value='2'>FEBRERO</option>";
            break;
          case 3:
            var periodo1 = "<option value='3'>MARZO</option>";
            break;
          case 4:
            var periodo1 = "<option value='4'>ABRIL</option>";
            break;
          case 5:
            var periodo1 = "<option value='5'>MAYO</option>";
            break;
          case 6:
            var periodo1 = "<option value='6'>JUNIO</option>";
            break;
          case 7:
            var periodo1 = "<option value='7'>JULIO</option>";
            break;
          case 8:
            var periodo1 = "<option value='8'>AGOSTO</option>";
            break;
          case 9:
            var periodo1 = "<option value='9'>SEPTIEMBRE</option>";
            break;
          case 10:
            var periodo1 = "<option value='10'>OCTUBRE</option>";
            break;
          case 11:
            var periodo1 = "<option value='11'>NOVIEMBRE</option>";
            break;
          case 12:
            var periodo1 = "<option value='12'>DICIEMBRE</option>";
            break;
          default:
            break;
        }
        $("#periodo").html('');
        $("#periodo").append(periodo1);
        $("#periodo").prop("disabled",true);
        $("#fecha").val(registros.fecha);
        $("#concepto").val(registros.concepto);
        $("#concepto").prop("disabled",true);
        $("#tp_gasto").val(registros.gasto);
        $("#tp_gasto").prop("disabled",true);
        $("#recurso").val(registros.recurso);
        $("#recurso").prop("disabled",true);
        $("#rubro").val(registros.rubro);
        $("#rubro").prop("disabled",true);
        $("#soporte").val(registros.soporte);
        $("#soporte").prop("disabled",true);
        $("#num_sop").val(registros.num_sopo);
        $("#num_sop").prop("disabled",true);
        $("#fec_sop").val(registros.fec_sopo);
        $("#fec_sop").prop("disabled",true);
        $("#transaccion").val(registros.transferencia);
        $("#transaccion").prop("disabled",true);
        $("#origen").val(registros.origen);
        $("#origen").prop("disabled",true);
        var firmas1 = registros.firmas.split('|');
        var var_ocu1 = firmas1.length;
        var y = 1;
        for (var i=0; i<var_ocu1; i++)
        {
          var paso = firmas1[i];
          var firma = paso.split('»');
          var fir = firma[0];
          fir = fir.substr(0,fir.length-1);
          var car = firma[1];
          $("#firma"+y).val(fir);
          $("#cargo"+y).val(car);
          y++;
        }
        $("#valor").hide();
        $("#valor1").show();
        var valor = registros.valor;
        valor = parseFloat(valor);
        valor = valor.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        $("#valor1").val(valor);
        $("#valor1").prop("disabled",true);
        paso_val();
        if (registros.estado == "")
        {
          $("#aceptar2").show();
        }
        else
        {
          var detalle = "<br><h2><center>Ingreso Anulado</center></h2>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#firma1").prop("disabled",true);
          $("#firma2").prop("disabled",true);
          $("#firma3").prop("disabled",true);
          $("#firma4").prop("disabled",true);
          $("#cargo1").prop("disabled",true);
          $("#cargo2").prop("disabled",true);
          $("#cargo3").prop("disabled",true);
          $("#cargo4").prop("disabled",true);
        }
      }
      else
      {
        var detalle = "<br><h2><center>Ingreso No Encontrado</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
      }
    }
  });
}
function actualizar()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "ing_actu.php",
    data:
    {
      numero: $("#numero").val(),
      ano: $("#n_ano").val(),
      concepto: $("#concepto").val(),
      firma1: $("#firma1").val(),
      firma2: $("#firma2").val(),
      firma3: $("#firma3").val(),
      firma4: $("#firma4").val(),
      cargo1: $("#cargo1").val(),
      cargo2: $("#cargo2").val(),
      cargo3: $("#cargo3").val(),
      cargo4: $("#cargo4").val()
    },
    success: function (data)
    {
      $("#aceptar2").hide();
      $("#firma1").prop("disabled",true);
      $("#firma2").prop("disabled",true);
      $("#firma3").prop("disabled",true);
      $("#firma4").prop("disabled",true);
      $("#cargo1").prop("disabled",true);
      $("#cargo2").prop("disabled",true);
      $("#cargo3").prop("disabled",true);
      $("#cargo4").prop("disabled",true);
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
</script>
</body>
</html>
<?php
}
?>