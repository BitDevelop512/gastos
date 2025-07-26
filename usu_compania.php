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
  include('permisos.php');

  $pregunta1 = "SELECT * FROM cx_ctr_usu WHERE tipo='1' ORDER BY orden";
  $sql1 = odbc_exec($conexion,$pregunta1);
  $admin1 = "<option value='0'>- SELECCIONAR -</option>";
  $i = 0;
  while ($i < $row = odbc_fetch_array($sql1))
  {
    $codigo = odbc_result($sql1,1);
    $nombre = trim(utf8_encode(odbc_result($sql1,2)));
    $admin1 .= "<option value='".$codigo."'>".$nombre."</option>";
    $i++;
  }
  $pregunta2 = "SELECT * FROM cx_ctr_usu WHERE tipo='2' ORDER BY orden";
  $sql2 = odbc_exec($conexion,$pregunta2);
  $admin2 = "<option value='0'>- SELECCIONAR -</option>";
  $i = 0;
  while ($i < $row = odbc_fetch_array($sql2))
  {
    $codigo = odbc_result($sql2,1);
    $nombre = trim(utf8_encode(odbc_result($sql2,2)));
    $admin2 .= "<option value='".$codigo."'>".$nombre."</option>";
    $i++;
  }
  $pregunta3 = "SELECT * FROM cx_ctr_usu WHERE tipo='3' ORDER BY orden";
  $sql3 = odbc_exec($conexion,$pregunta3);
  $admin3 = "";
  $i = 0;
  while ($i < $row = odbc_fetch_array($sql3))
  {
    $codigo = odbc_result($sql3,1);
    $nombre = trim(utf8_encode(odbc_result($sql3,2)));
    $admin3 .= "<option value='".$codigo."'>".$nombre."</option>";
    $i++;
  }
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
</head>
<body>
<?php
include('titulo.php');
?>
<div>
  <section class="content-header">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="soportes">
          <h3>Parametros Iniciales</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <center>
                    <div class="ui-state-error ui-corner-all" style="padding: 1em; width: 750px;">
                      <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em;"></span><b>NOTA: Los nombres de Brigadas y Divisiones se encuentran parametrizadas sin espacios<br>y con el numero cero en los casos que aplique, ejemplo BR01, DIV01.</b></p>
                    </div>
                  </center>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Unidad</font></label>
                  <?php
                  $menu2_2 = odbc_exec($conexion,"SELECT subdepen, sigla FROM dbo.cf_sigla(1) ORDER BY sigla");
                  $menu2 = "<select name='unidad' id='unidad' class='form-control select2' onchange='trae_brigada();' tabindex='1'>";
                  $menu2 .= "\n<option value='0'>- SELECCIONAR -</option>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu2_2))
                  {
                    $nombre = trim($row['sigla']);
                    $menu2 .= "\n<option value=$row[subdepen]>".$nombre."</option>";
                    $i++;
                  }
                  $menu2 .= "\n</select>";
                  echo $menu2;
                  ?>
                </div>
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Brigada</font></label>
                  <?php
                  $menu3_3 = odbc_exec($conexion,"SELECT dependencia, nombre FROM cx_org_dep ORDER BY nombre");
                  $menu3 = "<select name='brigada' id='brigada' class='form-control select2' tabindex='2'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu3_3))
                  {
                    $nombre = trim($row['nombre']);
                    $menu3 .= "\n<option value=$row[dependencia]>".$nombre."</option>";
                    $i++;
                  }
                  $menu3 .= "\n</select>";
                  echo $menu3;
                  ?>
                </div>
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Divisi&oacute;n</font></label>
                  <?php
                  $menu4_4 = odbc_exec($conexion,"SELECT unidad, nombre FROM cx_org_uni ORDER BY nombre");
                  $menu4 = "<select name='division' id='division' class='form-control select2' tabindex='3'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu4_4))
                  {
                    $nombre = trim($row['nombre']);
                    $menu4 .= "\n<option value=$row[unidad]>".$nombre."</option>";
                    $i++;
                  }
                  $menu4 .= "\n</select>";
                  echo $menu4;
                  ?>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Unidad</font></label>
                  <input type="hidden" name="admin1" id="admin1" class="form-control" value="<?php echo $admin1; ?>" readonly="readonly">
                  <input type="hidden" name="admin2" id="admin2" class="form-control" value="<?php echo $admin2; ?>" readonly="readonly">
                  <input type="hidden" name="admin3" id="admin3" class="form-control" value="<?php echo $admin3; ?>" readonly="readonly">
                  <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly">
                  <input type="hidden" name="psuper" id="psuper" class="form-control" value="<?php echo $per_usuario; ?>" readonly="readonly">
                  <input type="hidden" name="sigla" id="sigla" class="form-control" readonly="readonly">
                  <input type="hidden" name="uni_cen" id="uni_cen" class="form-control" value="0" readonly="readonly">
                  <input type="hidden" name="tip_uni" id="tip_uni" class="form-control" value="0" readonly="readonly">
                  <input type="hidden" name="permisos" id="permisos" class="form-control" value="A|01/" readonly="readonly">
                  <input type="text" name="n_batallon" id="n_batallon" class="form-control" readonly="readonly" tabindex="4">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Ciudad</font></label>
                  <input type="text" name="ciudad" id="ciudad" class="form-control" value="<?php echo $ciu_usuario; ?>" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="5">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Compa&ntilde;ia</font></label>
                  <select name="compania" id="compania" class="form-control select2" tabindex="6">
                    <option value="0">- SELECCIONAR -</option>
                  </select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo de Usuario</font></label>
                  <select name="admin" id="admin" class="form-control select2" tabindex="7"></select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Grado y Nombre Completo Usuario</font></label>
                  <input type="text" name="nombre" id="nombre" class="form-control" maxlength="100" value="<?php echo $nom_usuario; ?>" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="8" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">C&eacute;dula o N&uacute;mero de Indentificaci&oacute;n</font></label>
                  <input type="text" name="cedula" id="cedula" class="form-control" maxlength="15" value="<?php echo $ced_usuario; ?>" onkeypress="return check3(event);" tabindex="9" autocomplete="off">
                </div>
              </div>
              <br>
              <div id="centra">
                <hr>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Nit</font></label>
                    <input type="text" name="nit" id="nit" class="form-control" maxlength="13" tabindex="10" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Banco</font></label>
                    <select name="banco" id="banco" class="form-control select2" tabindex="11">
                      <option value="1">BBVA</option>
                      <option value="2">AV VILLAS</option>
                      <option value="3">DAVIVIENDA</option>
                      <option value="4">BANCOLOMBIA</option>
                      <option value="5">BANCO DE BOGOTA</option>
                      <option value="6">POPULAR</option>
                    </select>
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">N&uacute;mero de Cuenta Bancaria</font></label>
                    <input type="text" name="cuenta" id="cuenta" class="form-control" maxlength="20" tabindex="12">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Cheque Inicial</font></label>
                    <input type="text" name="cheque" id="cheque" class="form-control numero" value="0" onkeypress="return check2(event);" tabindex="13" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Cheque Final</font></label>
                    <input type="text" name="cheque1" id="cheque1" class="form-control numero" value="0" onkeypress="return check2(event);" tabindex="14" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Cheque Actual</font></label>
                    <input type="text" name="cheque2" id="cheque2" class="form-control numero" value="0" onkeypress="return check2(event);" tabindex="15" autocomplete="off">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Saldo en Bancos</font></label>
                    <input type="text" name="saldo" id="saldo" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly" tabindex="16">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Gastos en Actividades</font></label>
                    <input type="text" name="gastos" id="gastos" class="form-control numero" value="0.00" onkeyup="suma();" onblur="suma();" tabindex="17" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Informaciones</font></label>
                    <input type="text" name="pagos" id="pagos" class="form-control numero" value="0.00" onkeyup="suma();" onblur="suma();" tabindex="18" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Recompensas</font></label>
                    <input type="text" name="recompensas" id="recompensas" class="form-control numero" value="0.00" onkeyup="suma();" onblur="suma();" tabindex="19" autocomplete="off">
                  </div>
                  <div id="rel_unid"></div>
                  <input type="hidden" name="num_unis" id="num_unis" class="form-control numero" readonly="readonly">
                  <input type="hidden" name="sig_unis" id="sig_unis" class="form-control numero" readonly="readonly">
                  <input type="hidden" name="inf_unis" id="inf_unis" class="form-control numero" readonly="readonly">
                  <input type="hidden" name="pag_unis" id="pag_unis" class="form-control numero" readonly="readonly">
                  <input type="hidden" name="rec_unis" id="rec_unis" class="form-control numero" readonly="readonly">
                </div>
                <hr>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Ultimo Comprobante Egreso</font></label>
                    <input type="text" name="egreso1" id="egreso1" class="form-control numero" value="0" onkeypress="return check2(event);" tabindex="20" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Ultimo Comprobante Ingreso</font></label>
                    <input type="text" name="ingreso1" id="ingreso1" class="form-control numero" value="0" onkeypress="return check2(event);" tabindex="21" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Ultima Misi&oacute;n de Trabajo</font></label>
                    <input type="text" name="mision1" id="mision1" class="form-control numero" value="0" onkeypress="return check2(event);" tabindex="22" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Ultima Acta de Pago</font></label>
                    <input type="text" name="acta1" id="acta1" class="form-control numero" value="0" onkeypress="return check2(event);" tabindex="23" autocomplete="off">
                  </div>
                </div>
              </div>
              <div id="firmas">
                <hr>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Ejecutor</font></label>
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Jefe de Estado Mayor</font></label>
                  </div>
                </div>
                <div class="espacio1"></div>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <label><font face="Verdana" size="2">Grado - Nombre:</font></label>
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <input type="text" name="firma1" id="firma1" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="24" autocomplete="off">
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <label><font face="Verdana" size="2">Grado - Nombre:</font></label>
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <input type="text" name="firma2" id="firma2" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="25" autocomplete="off">
                  </div>
                </div>
                <div class="espacio1"></div>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <label><font face="Verdana" size="2">Cargo:</font></label>
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <input type="text" name="cargo1" id="cargo1" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="26" autocomplete="off">
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <label><font face="Verdana" size="2">Cargo:</font></label>
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <input type="text" name="cargo2" id="cargo2" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="27" autocomplete="off">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Comandante</font></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <label><font face="Verdana" size="2">Grado - Nombre:</font></label>
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <input type="text" name="firma3" id="firma3" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="28" autocomplete="off">
                  </div>
                </div>
                <div class="espacio1"></div>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <label><font face="Verdana" size="2">Cargo:</font></label>
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <input type="text" name="cargo3" id="cargo3" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="29" autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <center>
                    <input type="button" name="aceptar1" id="aceptar1" value="Continuar">
                  </center>
                </div>
              </div>
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
            <div id="dialogo2"></div>
            <div id="dialogo3"></div>
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
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 215,
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
  $("#unidad").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#cheque").focus(function(){
    this.select();
  });
  $("#cheque1").focus(function(){
    this.select();
  });
  $("#cheque2").focus(function(){
    this.select();
  });
  $("#egreso1").focus(function(){
    this.select();
  });
  $("#ingreso1").focus(function(){
    this.select();
  });
  $("#mision1").focus(function(){
    this.select();
  });
  $("#acta1").focus(function(){
    this.select();
  });
  $("#brigada").prop("disabled",true);
  $("#division").prop("disabled",true);
  $("#n_batallon").prop("disabled",true);
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta1);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#centra").hide();
  $("#firmas").hide();
  $("#admin").change(datos);
  $("#gastos").maskMoney();
  $("#pagos").maskMoney();
  $("#recompensas").maskMoney();
});
function datos()
{
  var valida = $("#admin").val();
  var valida1 = $("#uni_cen").val();
  var valida2 = $("#division").val();
  valida2 = parseInt(valida2);
  if (((valida == "10") || (valida == "15") || (valida == "31"))  && (valida1 == "1"))
  {
    $("#centra").show();
    $("#firmas").show();
  }
  else
  {
    $("#centra").hide();
    $("#firmas").hide();
  }
  var permisos = "";
  if (valida2 > 3)
  {
    switch (valida)
    {
      case '1':
        permisos = "A|01/C|01/C|02/C|03/C|05/D|04/E|01/";
        break;
      case '3':
      case '4':
        permisos = "A|02/";
        break;
      case '5':
        permisos = "E|02/E|03/";
        break;
      case '6':
        permisos = "A|01/A|02/C|01/C|02/C|03/C|05/D|04/E|01/E|02/";
        break;
      case '25':
        permisos = "A|01/A|02/A|03/";
        break;
      case '7':
      case '9':
        permisos = "A|02/";
        break;
      case '10':
        permisos = "A|01/A|02/A|03/B|02/B|03/B|04/B|05/C|01/C|02/C|03/C|05/C|06/D|01/D|02/D|03/D|04/D|05/";
        break;
      case '11':
      case '12':
      case '13':
        permisos = "A|02/A|03/B|02/";
        break;
      case '14':
      case '16':
      case '17':
      case '18':
        permisos = "A|02/A|04/";
        break;
      case '15':
        permisos = "B|01/B|03/B|04/B|05/";
        break;
      case '20':
        permisos = "E|01/E|02/";
        break;
      case '21':
        permisos = "A|02/";
        break;
      case '22':
        permisos = "A|01/C|02/C|03/C|05/";
        break;
      case '23':
        permisos = "A|02/";
        break;
      case '24':
        permisos = "A|01/C|02/C|03/C|05/";
        break;
      default:
        permisos = "";
        break;
    }
  }
  else
  {
    switch (valida)
    {
      case '1':
        permisos = "A|01/C|01/C|02/C|03/C|04/C|05/D|04/";
        break;
      case '2':
        permisos = "A|02/";
        break;
      case '3':
        permisos = "A|01/A|02/C|01/C|02/C|03/C|04/C|05/D|04/E|01/";
        break;
      case '4':
        permisos = "A|02/";
        break;
      case '6':
        permisos = "A|01/A|02/A|03/C|02/C|03/C|05/";
        break;
      case '7':
        permisos = "A|02/A|03/B|02/";
        break;
      case '8':
        permisos = "A|02/A|03/B|02/";
        break;
      case '9':
        permisos = "A|02/A|03/B|02/";
        break;
      case '10':
        permisos = "A|03/B|03/B|04/B|05/";
        break;
      case '11':
      case '12':
      case '13':
        permisos = "A|02/A|03/B|02/";
        break;
      case '14':
      case '16':
      case '17':
      case '18':
        permisos = "A|02/A|04/";
        break;
      case '15':
        permisos = "B|01/B|03/B|04/B|05/";
        break;
      case '20':
        permisos = "E|01/E|02/";
        break;
      case '21':
        permisos = "A|02/";
        break;
      case '22':
        permisos = "A|01/C|02/C|03/C|05/";
        break;
      case '23':
        permisos = "A|02/";
        break;
      case '24':
        permisos = "A|01/C|02/C|03/C|05/";
        break;
      case '25':
        permisos = "A|01/A|02/A|03/C|02/C|03/C|05/";
        break;
      case '26':
        permisos = "A|02/";
        break;
      case '27':
        permisos = "A|01/C|01/C|02/C|03/C|05/";
        break;
      case '28':
        permisos = "E|01/E|02/";
        break;
      case '29':
      case '30':
        permisos = "A|01/C|02/C|03/C|04/C|05/";
        break;
      case '19':
      case '31':
        permisos = "A|01/A|02/A|03/B|02/B|03/B|04/B|05/C|01/C|02/C|03/C|05/C|06/D|01/D|02/D|03/D|04/D|05/";
        break;
      default:
        permisos = "";
        break;
    }
  }
  $("#permisos").val(permisos);
}
function trae_brigada()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_brig1.php",
    data:
    {
      unidad: $("#unidad").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      $("#brigada").val(registros.brigada);
      $("#division").val(registros.division);
      if (registros.centralizadora == "1")
      {
      	$("#uni_cen").val('1');
      }
      else
      {
		    $("#uni_cen").val('0');
      }
      $("#tip_uni").val(registros.tipouni);
    }
  });
  var paso = $("#unidad").val();
  actu(paso);
}
function svg1()
{
  var data = $('#signature').jSignature("getData", "svg");
  $('#firma').val(data.join(','));
}
function pregunta1()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function actu(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_bata.php",
    data:
    {
    	subdependencia: valor
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      $("#n_batallon").val(registros.nombre);
      $("#sigla").val(registros.sigla);
      if (registros.banco  == "0")
      { 
      }
      else
      {
        $("#banco").val(registros.banco);
      }
      $("#cuenta").val(registros.cuenta);
      $("#cheque").val(registros.cheque);
      $("#cheque1").val(registros.cheque1);
      $("#cheque2").val(registros.cheque2);
      $("#nit").val(registros.nit);
      $("#firma1").val(registros.firma1);
      $("#firma2").val(registros.firma2);
      $("#firma3").val(registros.firma3);
      $("#cargo1").val(registros.cargo1);
      $("#cargo2").val(registros.cargo2);
      $("#cargo3").val(registros.cargo3);
      $("#cargo4").val(registros.cargo4);
      trae_cmp(registros.unidad);
    }
  });
}
function trae_cmp(valor)
{
  var valor;
  $("#compania").html('');
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cmp.php",
    data:
    {
      tipo: valor
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
      $("#compania").append(salida);
    }
  });
  trae_admin(valor);
}
function trae_admin(valor)
{
  var valor;
  var paso_admin1 = $("#admin1").val();
  var paso_admin2 = $("#admin2").val();
  var paso_admin3 = $("#admin3").val();
  var valida = $("#tip_uni").val();
  var valida1 = $("#division").val();
  var valida2 = $("#unidad").val();
  $("#admin").html('');
  switch (valor)
  {
    case '1':
    case '2':
    case '3':
      $("#admin").append(paso_admin1);
      break;
    default:
      $("#admin").append(paso_admin2);
      break;
  }
  switch (valida)
  {
    case '4':
      $("#admin option[value=1]").remove();
      $("#admin option[value=2]").remove();
      $("#admin option[value=3]").remove();
      $("#admin option[value=4]").remove();
      $("#admin option[value=6]").remove();
      $("#admin option[value=7]").remove();
      $("#admin option[value=8]").remove();
      $("#admin option[value=9]").remove();
      $("#admin option[value=14]").remove();
      $("#admin option[value=15]").remove();
      $("#admin option[value=16]").remove();
      $("#admin option[value=17]").remove();
      $("#admin option[value=18]").remove();
      //$("#admin option[value=19]").remove();
      $("#admin option[value=20]").remove();
      $("#admin option[value=21]").remove();
      $("#admin option[value=22]").remove();
      $("#admin option[value=23]").remove();
      $("#admin option[value=24]").remove();
      $("#admin option[value=26]").remove();
      $("#admin option[value=27]").remove();
      //$("#admin option[value=28]").remove();
      //$("#admin option[value=29]").remove();
      //$("#admin option[value=30]").remove();
      $("#admin option[value=31]").remove();
      break;
    case '6':
      $("#admin option[value=1]").remove();
    	$("#admin option[value=2]").remove();
    	$("#admin option[value=3]").remove();
    	$("#admin option[value=4]").remove();
      $("#admin option[value=6]").remove();
    	$("#admin option[value=7]").remove();
    	$("#admin option[value=8]").remove();
    	$("#admin option[value=9]").remove();
      $("#admin option[value=14]").remove();
    	$("#admin option[value=15]").remove();
    	$("#admin option[value=16]").remove();
      $("#admin option[value=17]").remove();
    	$("#admin option[value=18]").remove();
    	$("#admin option[value=19]").remove();
    	$("#admin option[value=20]").remove();
      $("#admin option[value=21]").remove();
    	$("#admin option[value=22]").remove();
    	$("#admin option[value=23]").remove();
    	$("#admin option[value=24]").remove();
      $("#admin option[value=25]").remove();
      $("#admin option[value=26]").remove();
      $("#admin option[value=27]").remove();
      $("#admin option[value=28]").remove();
      $("#admin option[value=29]").remove();
      $("#admin option[value=30]").remove();
      $("#admin option[value=31]").remove();
      break;
    case '7':
      $("#admin option[value=1]").remove();
    	$("#admin option[value=2]").remove();
    	$("#admin option[value=3]").remove();
    	$("#admin option[value=4]").remove();
      $("#admin option[value=5]").remove();
    	$("#admin option[value=10]").remove();
    	$("#admin option[value=11]").remove();
    	$("#admin option[value=12]").remove();
      $("#admin option[value=13]").remove();
    	$("#admin option[value=14]").remove();
    	$("#admin option[value=15]").remove();
    	$("#admin option[value=16]").remove();
      $("#admin option[value=17]").remove();
    	$("#admin option[value=18]").remove();
    	$("#admin option[value=19]").remove();
    	$("#admin option[value=20]").remove();
      $("#admin option[value=21]").remove();
    	$("#admin option[value=22]").remove();
    	$("#admin option[value=23]").remove();
    	$("#admin option[value=24]").remove();
      $("#admin option[value=26]").remove();
      $("#admin option[value=27]").remove();
    	break;
    case '8':
      $("#admin option[value=5]").remove();
    	$("#admin option[value=6]").remove();
    	$("#admin option[value=7]").remove();
      $("#admin option[value=8]").remove();
    	$("#admin option[value=9]").remove();
    	$("#admin option[value=10]").remove();
      $("#admin option[value=11]").remove();
    	$("#admin option[value=12]").remove();
    	$("#admin option[value=13]").remove();
    	$("#admin option[value=14]").remove();
      $("#admin option[value=15]").remove();
    	$("#admin option[value=16]").remove();
    	$("#admin option[value=17]").remove();
    	$("#admin option[value=18]").remove();
      $("#admin option[value=19]").remove();
    	//$("#admin option[value=20]").remove();
    	$("#admin option[value=21]").remove();
    	$("#admin option[value=22]").remove();
      $("#admin option[value=23]").remove();
    	$("#admin option[value=24]").remove();
    	$("#admin option[value=25]").remove();
      $("#admin option[value=28]").remove();
      //$("#admin option[value=29]").remove();
      $("#admin option[value=30]").remove();
      $("#admin option[value=31]").remove();
      break;
    default:
      break;
    }
    // Si es brimi1 - brimi2 - brcim1 y brcim2 deja el tipo de usuario 25, se agrega caimi y cacim
    if ((valida2 == "18") || (valida2 == "28") || (valida2 == "40") || (valida2 == "56")  || (valida2 == "8")  || (valida2 == "39"))
    {
    }
    else
    {
    	$("#admin option[value=25]").remove();
    }
    // Se validan usuarios administradores de transportes
    var super1 = $("#super").val();
    if ((super1 == "4") || (super1 == "5"))
    {
      var permisos = $("#psuper").val();
      $("#permisos").val(permisos);

      $("#admin").html('');
      $("#admin").append(paso_admin3);
      if (super1 == "4")
      {
        $("#admin option[value=35]").remove();
      }
      if (super1 == "5")
      {
        $("#admin option[value=34]").remove();
      }
      $("#admin").prop("disabled",true);
    }
  	trae_unidades(valor);
}
function trae_unidades(valor)
{
  var valor;
  var centra = $("#uni_cen").val();
  var brigada = $("#brigada").val();
  var unidad = $("#unidad").val();
  if (centra == "1")
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_uni.php",
      data:
      {
        division: valor,
        brigada: brigada,
        unidad: unidad
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        $("#rel_unid").html('');
        var salida = "";
        salida += '<table align="center" width="70%" border="0">';
        salida += '<tr><td width="25%"><center><b>Unidad</b></center></td><td width="25%"><center><b>Pago Informaci&oacute;n</b></center></td><td width="25%"><center><b>Pago de Recompensas</b></center></td><td width="25%"><center><b>Gastos en Actividades</b></center></td></tr>';
        var y = 1;
        for (var i in registros) 
        {
          var unidad = registros[i].unidad;
          var sigla = registros[i].sigla;
          salida += '<tr><td><input type="text" name="unid_'+y+'" id="unid_'+y+'" class="c10" value="'+unidad+'" readonly="readonly"><input type="text" name="sig_'+y+'" id="sig_'+y+'" class="c5" value='+sigla+' readonly="readonly"></td><td><center><input type="text" name="pinf_'+y+'" id="pinf_'+y+'" class="c7" value="0.00" autocomplete="off"></center></td><td><center><input type="text" name="prec_'+y+'" id="prec_'+y+'" class="c7" value="0.00" autocomplete="off"></center></td><td><center><input type="text" name="gact_'+y+'" id="gact_'+y+'" class="c7" value="0.00" autocomplete="off"></center></td></tr>';
            y++;
        }
        $("#rel_unid").append(salida);
        for(i=1;i<=y;i++)
        {
          $("#pinf_"+i).maskMoney();
          $("#prec_"+i).maskMoney();
          $("#gact_"+i).maskMoney();
        }
      }
    });
  }
}
function graba()
{
  var salida = true, detalle = '';
  if ($("#ciudad").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Ciudad</h3></center>";
  }
  if (($("#admin").val() == null) || ($("#admin").val() == '') || ($("#admin").val() == '0'))
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar un Tipo de Usuario</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    paso1();
  }
}
function paso1()
{
  document.getElementById('num_unis').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('unid_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('num_unis').value=document.getElementById('num_unis').value+valor+"|";
    }
  }
  document.getElementById('sig_unis').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('sig_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('sig_unis').value=document.getElementById('sig_unis').value+valor+"|";
    }
  }
  document.getElementById('inf_unis').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('pinf_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('inf_unis').value=document.getElementById('inf_unis').value+valor+"|";
    }
  }
  document.getElementById('pag_unis').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('prec_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('pag_unis').value=document.getElementById('pag_unis').value+valor+"|";
    }
  }
  document.getElementById('rec_unis').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('gact_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('rec_unis').value=document.getElementById('rec_unis').value+valor+"|";
    }
  }
  graba1();
}
function graba1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "comp_actu.php",
    data:
    {
      unidad: $("#unidad").val(),
      compania: $("#compania").val(),
      admin: $("#admin").val(),
      permisos: $("#permisos").val(),
      nombre: $("#nombre").val(),
      cedula: $("#cedula").val(),
      firma: $("#firma").val(),
      ciudad: $("#ciudad").val(),
      sigla: $("#sigla").val(),
      nit: $("#nit").val(),
      banco: $("#banco").val(),
      cuenta: $("#cuenta").val(),
      cheque: $("#cheque").val(),
      cheque1: $("#cheque1").val(),
      cheque2: $("#cheque2").val(),
      saldo: $("#saldo").val(),
      gastos: $("#gastos").val(),
      pagos: $("#pagos").val(),
      recompensas: $("#recompensas").val(),
      egreso1: $("#egreso1").val(),
      ingreso1: $("#ingreso1").val(),
      mision1: $("#mision1").val(),
      acta1: $("#acta1").val(),
      firma1: $("#firma1").val(),
      firma2: $("#firma2").val(),
      firma3: $("#firma3").val(),
      cargo1: $("#cargo1").val(),
      cargo2: $("#cargo2").val(),
      cargo3: $("#cargo3").val(),
      tipou: $("#tip_uni").val(),
      tipoc: $("#uni_cen").val(),
      num_unis: $("#num_unis").val(),
      sig_unis: $("#sig_unis").val(),
      inf_unis: $("#inf_unis").val(),
      pag_unis: $("#pag_unis").val(),
      rec_unis: $("#rec_unis").val()
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
        detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
      }
    }
  });
}
function suma()
{
	var valor, valor1, valor2, valor3, valor4;
	valor = document.getElementById('gastos').value;
  if (valor == "")
  {
    valor = "0";
    $("#gastos").val('0.00');
  }
  valor = parseFloat(valor.replace(/,/g,''));
  valor = parseInt(valor);
	valor1 = document.getElementById('pagos').value;
  if (valor1 == "")
  {
    valor1 = "0";
    $("#pagos").val('0.00');
  }
	valor1 = parseFloat(valor1.replace(/,/g,''));
  valor1 = parseInt(valor1);
	valor2 = document.getElementById('recompensas').value;
  if (valor2 == "")
  {
    valor2 = "0";
    $("#recompensas").val('0.00');
  }
	valor2 = parseFloat(valor2.replace(/,/g,''));
	valor2 = parseInt(valor2);
  valor3 = valor+valor1+valor2;
	valor4 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	$("#saldo").val(valor4);
}
function check2(e)
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
function check3(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9kK]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function redirecciona()
{
  location.href = "principal.php";
}
</script>
</body>
</html>
<?php
}
// 09/04/2025 - Ajuste tipos de usuario desde tabla cx_ctr_usu
?>