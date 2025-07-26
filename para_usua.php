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
  $query = "SELECT nombre, ciudad, cedula, cargo, admin, unidad, email, conse, telefono FROM cx_usu_web WHERE usuario='$usu_usuario'";
  $cur1 = odbc_exec($conexion, $query);
  $n_usuario = utf8_encode(odbc_result($cur1,1));
  $n_usuario = trim($n_usuario);
  $n_ciudad = utf8_encode(trim(odbc_result($cur1,2)));
  $n_cedula = trim(odbc_result($cur1,3));
  $n_cargo = utf8_encode(odbc_result($cur1,4));
  $n_cargo = trim($n_cargo);
  $n_admin = odbc_result($cur1,5);
  $n_unidad = odbc_result($cur1,6);
  $n_correo = trim(odbc_result($cur1,7));
  $n_interno = odbc_result($cur1,8);
  $n_telefono = odbc_result($cur1,9);
  $query1 = "SELECT unic, banco, cuenta, cheque, firma1, firma2, firma3, cargo1, cargo2, cargo3, nit FROM cx_org_sub WHERE subdependencia='$n_unidad'";
  $cur2 = odbc_exec($conexion, $query1);
  $n_unic = odbc_result($cur2,1);
  $n_banco = odbc_result($cur2,2);
  $n_cuenta = trim(odbc_result($cur2,3));
  $n_cheque = trim(odbc_result($cur2,4));
  list($n_cheque1, $n_cheque2, $n_cheque3) = explode("|", $n_cheque);
  $n_firma1 = utf8_encode(odbc_result($cur2,5));
  $n_firma1 = trim($n_firma1);
  $n_firma2 = utf8_encode(odbc_result($cur2,6));
  $n_firma2 = trim($n_firma2);
  $n_firma3 = utf8_encode(odbc_result($cur2,7));
  $n_firma3 = trim($n_firma3);
  $n_cargo1 = utf8_encode(odbc_result($cur2,8));
  $n_cargo1 = trim($n_cargo1);
  $n_cargo2 = utf8_encode(odbc_result($cur2,9));
  $n_cargo2 = trim($n_cargo2);
  $n_cargo3 = utf8_encode(odbc_result($cur2,10));
  $n_cargo3 = trim($n_cargo3);
  $n_nit = trim(odbc_result($cur2,11));
  $usu_firm = encrypt1($usu_usuario, $llave);
  $usu_firm = trim($usu_firm);
  $con_firm = encrypt1($n_interno, $llave);
  $con_firm = trim($con_firm);
  $nom_firm = encrypt1($n_usuario, $llave);
  $nom_firm = trim($nom_firm);
  $query2 = "SELECT url FROM cx_ctr_par";
  $cur2 = odbc_exec($conexion, $query2);
  $url = trim(odbc_result($cur2,1));
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
  <script src="js5/jquery.min.js"></script>
  <script src="js5/jquery-qrcode-0.14.0.js"></script>
  <script src="js5/scripts.js"></script>
</head>
<body>
<?php
include('titulo.php');
?>
<div>
  <div id="soportes">
    <h3>Parametros de Usuario</h3>
    <div>
      <div id="load">
        <center>
          <img src="imagenes/cargando1.gif" alt="Cargando...">
        </center>
      </div>
      <form name="formu" method="post">
        <div class="row">
          <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
            <label><font face="Verdana" size="2">Grado y Nombre Completo Usuario</font></label>
          </div>
          <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
            <label><font face="Verdana" size="2">C&eacute;dula o N&uacute;mero de Indentificaci&oacute;n</font></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
            <input type="hidden" name="admin" id="admin" class="form-control" value="<?php echo $n_admin; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="centra" id="centra" class="form-control" value="<?php echo $n_unic; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="banco1" id="banco1" class="form-control" value="<?php echo $n_banco; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="unidad" id="unidad" class="form-control" value="<?php echo $n_unidad; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="var1" id="var1" class="form-control" value="<?php echo $con_firm; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="var2" id="var2" class="form-control" value="<?php echo $usu_firm; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="var3" id="var3" class="form-control" value="<?php echo $nom_firm; ?>" readonly="readonly" tabindex="0">
            <input type="hidden" name="var4" id="var4" class="form-control" value="<?php echo $url; ?>" readonly="readonly" tabindex="0">
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $n_usuario; ?>" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="1" autocomplete="off">
          </div>
          <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
            <input type="text" name="cedula" id="cedula" class="form-control" value="<?php echo $n_cedula; ?>" maxlength="15" tabindex="2" autocomplete="off">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
            <label><font face="Verdana" size="2">Cargo Usuario</font></label>
          </div>
          <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
            <label><font face="Verdana" size="2">Ciudad</font></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
            <input type="text" name="cargo" id="cargo" class="form-control" value='<?php echo $n_cargo; ?>' onblur="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="3" autocomplete="off">
          </div>
          <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
            <input type="text" name="ciudad" id="ciudad" class="form-control" value="<?php echo $n_ciudad; ?>" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" tabindex="4" autocomplete="off">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
            <label><font face="Verdana" size="2">Correo Electr&oacute;nico Institucional</font></label>
            <input type="text" name="email" id="email" class="form-control" value="<?php echo $n_correo; ?>" onblur="correo();" maxlength="60" tabindex="5" autocomplete="off">
          </div>
          <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
            <label><font face="Verdana" size="2">Tel&eacute;fono Contacto</font></label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-phone"></i>
              </div>
              <input type="text" name="telefono" id="telefono" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?php echo $n_telefono; ?>" tabindex="6" autocomplete="off">
            </div>
          </div>
        </div>
        <br>
        <div id="ucentra">
          <div class="row">
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Nit</font></label>
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Banco</font></label>
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">N&uacute;mero de Cuenta Bancaria</font></label>
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Cheque Inicial</font></label>
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Cheque Final</font></label>
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Cheque Actual</font></label>
            </div>
          </div>
          <div class="row">
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <input type="text" name="nit" id="nit" class="form-control" value="<?php echo $n_nit; ?>" maxlength="13" tabindex="6" autocomplete="off">
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <select name="banco" id="banco" class="form-control select2" tabindex="7">
                <option value="1">BBVA</option>
                <option value="2">AV VILLAS</option>
                <option value="3">DAVIVIENDA</option>
                <option value="4">BANCOLOMBIA</option>
                <option value="5">BANCO DE BOGOTA</option>
                <option value="6">POPULAR</option>
              </select>
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <input type="text" name="cuenta" id="cuenta" class="form-control" value="<?php echo $n_cuenta; ?>" maxlength="20" tabindex="8" autocomplete="off">
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <input type="text" name="cheque" id="cheque" class="form-control" value="<?php echo $n_cheque1; ?>" tabindex="9" autocomplete="off">
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <input type="text" name="cheque1" id="cheque1" class="form-control" value="<?php echo $n_cheque2; ?>" tabindex="10" autocomplete="off">
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <input type="text" name="cheque2" id="cheque2" class="form-control" value="<?php echo $n_cheque3; ?>" tabindex="11" autocomplete="off">
            </div>
          </div>
	      </div>
        <div id="firmas">
          <hr>
          <div class="row">
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              &nbsp;
            </div>
            <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
              <label><font face="Verdana" size="2">Ejecutor</font></label>
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              &nbsp;
            </div>
            <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
              <label><font face="Verdana" size="2">Vo. Bo.</font></label>
            </div>
          </div>
          <div class="row">
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Grado - Nombre:</font></label>
            </div>
            <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
              <input type="text" name="firma1" id="firma1" class="form-control" value="<?php echo $n_firma1; ?>" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="12" autocomplete="off">
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Grado - Nombre:</font></label>
            </div>
            <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
              <input type="text" name="firma2" id="firma2" class="form-control" value="<?php echo $n_firma2; ?>" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="14" autocomplete="off">
            </div>
          </div>
          <div class="espacio1"></div>
          <div class="row">
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Cargo:</font></label>
            </div>
            <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
              <input type="text" name="cargo1" id="cargo1" class="form-control" value="<?php echo $n_cargo1; ?>" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="150" tabindex="13" autocomplete="off">
            </div>
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Cargo:</font></label>
            </div>
            <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
              <input type="text" name="cargo2" id="cargo2" class="form-control" value="<?php echo $n_cargo2; ?>" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="150" tabindex="15" autocomplete="off">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              &nbsp;
            </div>
            <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
              <label><font face="Verdana" size="2">Ordenador</font></label>
            </div>
          </div>
          <div class="row">
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Grado - Nombre:</font></label>
            </div>
            <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
              <input type="text" name="firma3" id="firma3" class="form-control" value="<?php echo $n_firma3; ?>" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="16" autocomplete="off">
            </div>
          </div>
          <div class="espacio1"></div>
          <div class="row">
            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
              <label><font face="Verdana" size="2">Cargo:</font></label>
            </div>
            <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
              <input type="text" name="cargo3" id="cargo3" class="form-control" value="<?php echo $n_cargo3; ?>" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="150" tabindex="17" autocomplete="off">
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
            <label><font face="Verdana" size="2">Firma</font></label>
            <input type="hidden" name="text" id="text" class="form-control" value="<?php echo $url; ?>gastos/gastos.php?v1=<?php echo $con_firm; ?>&v2=<?php echo $usu_firm; ?>&v3=<?php echo $nom_firm; ?>" readonly="readonly" tabindex="1" />
            <div id="container"></div>
            <input type="hidden" id="render" value="div">
            <input type="hidden" id="size" value="250">
            <input type="hidden" id="fill" value="#333333">
            <input type="hidden" id="background" value="#ffffff">
            <input type="hidden" id="minversion" value="6">
            <input type="hidden" id="eclevel" value="H">
            <input type="hidden" id="quiet" value="1">
            <input type="hidden" id="radius" value="50">
            <div id="descargar"></div>
            <input type="hidden" name="imagen" id="imagen" class="form-control" value="" readonly="readonly">
          </div>
          <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
            <label><font face="Verdana" size="2">Firma Registrada</font></label>
            <div id="firma"></div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"></div>
          <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
            <center>
              <input type="button" name="firmar" id="firmar" value="Firmar" tabindex="18">
              <br><br>
              <input type="button" name="aceptar" id="aceptar" value="Continuar" tabindex="19">
            </center>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="dialogo"></div>
<div id="dialogo1"></div>
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="js7/html2canvas.js" type="text/javascript"></script>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 270,
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
  $("#aceptar").button();
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").click(pregunta1);
  $("#firmar").button();
  $("#firmar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#firmar").click(firmar);
  $("[data-mask]").inputmask();
  var banco = $("#banco1").val();
  $("#banco").val(banco);
  $("#nombre").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#cargo").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#ciudad").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#firma1").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#firma2").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#firma3").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#cargo1").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#cargo2").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#cargo3").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#telefono").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#telefono").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  valida();
  trae_firma();
});
function valida()
{
  var valida = $("#admin").val();
  var valida1 = $("#centra").val();
  var valida2 = $("#unidad").val();
  if (((valida == "10") || (valida == "31")) && (valida1 == "1"))
  {
    $("#ucentra").show();
    $("#firmas").show();
  }
  else
  {
    if ((valida == "15") && (valida2 == "1"))
    {
      $("#ucentra").show();
      $("#firmas").show();
    }
    else
    {
      $("#ucentra").hide();
      $("#firmas").hide();
    }
  }
  $("#nombre").focus();
}
function correo()
{
  var salida = true;
  var detalle = '';
  var valor = $("#email").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    $("#email").focus();
    $("#email").addClass("ui-state-error");
    $("#aceptar").show();
  }
  else
  {
    $("#email").removeClass("ui-state-error");
    var str = $("#email").val();
    str = str.trim();
    var at = "@";
    var dot = ".";
    var lat = str.indexOf(at);
    var lstr = str.length;
    var ldot = str.indexOf(dot);
    if (str.indexOf(at) == -1)
    {
      salida = false;
    }
    if (str.indexOf(at) == -1 || str.indexOf(at) == 0 || str.indexOf(at) == lstr)
    {
      salida = false;
    }
    if (str.indexOf(dot) == -1 || str.indexOf(dot) == 0 || str.indexOf(dot) == lstr)
    {
      salida = false;
    }
    if (str.indexOf(at,(lat+1)) != -1)
    {
      salida = false;
    }
    if (str.substring(lat-1,lat) == dot || str.substring(lat+1,lat+2) == dot)
    {
      salida = false;
    }
    if (str.indexOf(dot,(lat+2)) == -1)
    {
      salida = false;
    }
    if (str.indexOf(" ") != -1)
    {
      salida = false;
    }
    if (salida == false)
    {
      detalle += "<center><h3>Debe ingresar un correo electr&oacute;nico v&aacute;lido</h3></center>";
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      $("#aceptar").hide();
    }
    else
    {
      $("#aceptar").show();
    }
  }
}
function pregunta1()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function graba()
{
  var salida = true, detalle = '';
  if ($("#nombre").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Nombre Completo del Usuario</h3></center>";
  }
  if ($("#ciudad").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Ciudad</h3></center>";
  }
  if ($("#cedula").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el N&uacute;mero de Identificaci&oacute;n</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    graba1();
  }
}
function graba1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "para_actu.php",
    data:
    {
      admin: $("#admin").val(),
      centra: $("#centra").val(),
      nombre: $("#nombre").val(),
      cedula: $("#cedula").val(),
      cargo: $("#cargo").val(),
      ciudad: $("#ciudad").val(),
      email: $("#email").val(),
      nit: $("#nit").val(),
      banco: $("#banco").val(),
      cuenta: $("#cuenta").val(),
      cheque: $("#cheque").val(),
      cheque1: $("#cheque1").val(),
      cheque2: $("#cheque2").val(),
      firma1: $("#firma1").val(),
      firma2: $("#firma2").val(),
      firma3: $("#firma3").val(),
      cargo1: $("#cargo1").val(),
      cargo2: $("#cargo2").val(),
      cargo3: $("#cargo3").val(),
      telefono: $("#telefono").val()
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
        redirecciona();
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function trae_firma()
{
  $("#firma").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_firma.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var total = registros.total;
      var firma = registros.firma;
      firma = firma.trim();
      if (firma == "")
      {
        var detalle = "Firma No Registrada";
        alerta(detalle);
      }
      else
      {
        for (var i=0; i<150; i++)
        {
          firma = firma.replace(/»/g, '"');
          firma = firma.replace(/º/g, "<");
          firma = firma.replace(/«/g, ">");
        }
        firma = firma.substring(14);
        firma = "<br><center>"+firma+"</center>";
        $("#firma").append(firma);
      }
    }
  });
}
function firmar()
{
  var var1 = $("#var1").val();
  var var2 = $("#var2").val();
  var var3 = $("#var3").val();
  var var4 = $("#var4").val();
  var ruta = var4+"gastos/gastos.php?v1="+var1+"&v2="+var2+"&v3="+var3;
  window.open(ruta, "_blank");
}
function redirecciona()
{
  location.href = "para_usua.php";
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
// 04/04/2024 - Ajuste pegado sobre campo firmas
// 20/09/2024 - Ajuste para url sigar
// 13/12/2024 - Ajuste amplitud caracteres cargos log
// 05/03/2025 - Ajuste comillas sencillas cargo
?>