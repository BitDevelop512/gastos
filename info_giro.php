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
  $pregunta = "SELECT saldo FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion,$pregunta);
  $saldo = odbc_result($cur,1);
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
          <h3>Informe de Giro</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Periodo</font></label>
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
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Concepto</font></label>
                  <?php
                  $menu1_1 = odbc_exec($conexion,"SELECT * FROM cx_ctr_gas WHERE codigo IN ('8','9','10') ORDER BY codigo");
                  $menu1 = "<select name='con_pag' id='con_pag' class='form-control select2' tabindex='3'>";
                  $i=1;
                  while($i<$row=odbc_fetch_array($menu1_1))
                  {
                    $nombre = utf8_encode($row['nombre']);
                    $menu1 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  $menu1 .= "\n</select>";
                  echo $menu1;
                  ?>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <br>
                  <input type="button" name="aceptar" id="aceptar" value="Continuar" tabindex="4">
                </div>
              </div>
              <div class="espacio"></div>
              <div id="datos">
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Total Unidades</font></label>
                    <input type="text" name="giro" id="giro" class="form-control numero" value="0" readonly="readonly" tabindex="5">
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2"><div id="men1_1">Total Gastos</div></font></label>
                    <div id="men1_2">
                      <input type="text" name="gastos" id="gastos" class="form-control numero" value="0.00" readonly="readonly" tabindex="6">
                    </div>
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2"><div id="men2_1">Total Pagos</div></font></label>
                    <div id="men2_2">
                      <input type="text" name="pagos" id="pagos" class="form-control numero" value="0.00" readonly="readonly" tabindex="7">
                    </div>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Cuenta Bancaria</font></label>
                    <select name="cuenta" id="cuenta" class="form-control select2" tabindex="8" onchange="trae_saldos(); trae_crps();"></select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Total Giro</font></label>
                    <input type="text" name="total" id="total" class="form-control numero" value="0.00" readonly="readonly" tabindex="9">
                    <input type="hidden" name="total1" id="total1" class="form-control numero" value="0" readonly="readonly" tabindex="10">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">CRP</font></label>
                    <select name="crp" id="crp" class="form-control select2" tabindex="11"></select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Valor CRP</font></label>
                    <input type="text" name="sal_crp" id="sal_crp" class="form-control numero" value="0.00" onkeyup="paso_val();" tabindex="12">
                    <input type="hidden" name="sal_crp1" id="sal_crp1" class="form-control numero" value="0" readonly="readonly" tabindex="13">
                    <input type="hidden" name="sal_crp2" id="sal_crp2" class="form-control numero" value="0" readonly="readonly" tabindex="14">
                    <div class="espacio3"></div>
                    <label><font face="Verdana" size="2">Fecha CRP</font></label>
                    <input type="text" name="fec_crp" id="fec_crp" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" autocomplete="off" tabindex="15">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">CDP</font></label>
                    <select name="cdp" id="cdp" class="form-control select2" tabindex="16"></select>
                    <div class="espacio3"></div>
                    <label><font face="Verdana" size="2">Fecha CDP</font></label>
                    <input type="text" name="fec_cdp" id="fec_cdp" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" autocomplete="off" tabindex="17">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Recurso</font></label>
                    <select name="recurso" id="recurso" class="form-control select2" tabindex="18">
                      <option value="1">10 CSF</option>
                      <option value="2">50 SSF</option>
                      <option value="3">16 SSF</option>
                    </select>
                    <div class="espacio3"></div>
                    <label><font face="Verdana" size="2">Rubro</font></label>
                    <select name="rubro" id="rubro" class="form-control select2" tabindex="19">
                      <option value="1">204-20-1</option>
                      <option value="2">204-20-2</option>
                      <option value="3">A-02-02-04</option>
                    </select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Saldo Banco</font></label>
                    <input type="text" name="sal_ban" id="sal_ban" class="form-control numero" readonly="readonly" tabindex="20">
                    <input type="hidden" name="sal_ban1" id="sal_ban1" class="form-control numero" value="<?php echo $saldo; ?>" readonly="readonly" tabindex="21">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Suma Total CRP</font></label>
                    <input type="text" name="tot_crp" id="tot_crp" class="form-control numero" value="0"  readonly="readonly" tabindex="22">
                    <input type="hidden" name="tot_crp1" id="tot_crp1" class="form-control numero" value="0.00" readonly="readonly" tabindex="23">
                    <div class="espacio3"></div>
                    <label><font face="Verdana" size="2">Diferencia</font></label>
                    <input type="text" name="diferencia" id="diferencia" class="form-control numero" value="0.00" readonly="readonly" tabindex="24">
                    <input type="hidden" name="can_crp" id="can_crp" class="form-control numero" value="0" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_con" id="v_con" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_uni" id="v_uni" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_sig" id="v_sig" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_gas" id="v_gas" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_pag" id="v_pag" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_tot" id="v_tot" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_crp" id="v_crp" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_sal" id="v_sal" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_paso1" id="v_paso1" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_paso2" id="v_paso2" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_paso3" id="v_paso3" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_paso4" id="v_paso4" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_paso5" id="v_paso5" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                    <input type="hidden" name="v_ciudad" id="v_ciudad" class="form-control" value="<?php echo $ciu_usuario; ?>" readonly="readonly" tabindex="0">
                    <input type="hidden" name="correo" id="correo" class="form-control" value="<?php echo $ema_usuario; ?>" readonly="readonly" tabindex="0">
                    <input type="hidden" name="servidor" id="servidor" class="form-control" value="" readonly="readonly" tabindex="0">
                  </div>
                </div>
                <div class="espacio1"></div>
                <div class="row">
                  <div id="add_form">
                    <table width="100%" align="center" border="0"></table>
                  </div>
                </div>
                <div class="espacio2"></div>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0" tabindex="25"></a>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">CASH - Transferencia</font></label>
                    <input type="text" name="cash" id="cash" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="30" tabindex="26" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Soporte</font></label>
                    <?php
                    $menu2_2 = odbc_exec($conexion,"SELECT * FROM cx_ctr_sop WHERE conse IN ('16', '17') ORDER BY conse");
                    $menu2 = "<select name='soporte' id='soporte' class='form-control select2' tabindex='27'>";
                    $i = 1;
                    while($i<$row=odbc_fetch_array($menu2_2))
                    {
                      $nombre = utf8_encode($row['nombre']);
                      $menu2 .= "\n<option value=$row[conse]>".$nombre."</option>";
                      $i++;
                    }
                    $menu2 .= "\n</select>";
                    echo $menu2;
                    ?>
                  </div>
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Firma</font></label>
                    <select name="firma" id="firma" class="form-control select2" tabindex="28">
                      <option value="1">Jefe Departamento de Inteligencia y Contrainteligencia</option>
                      <option value="2">Director Administrativo de Inteligencia y Contrainteligencia</option>
                    </select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <br>
                    <input type="button" name="aceptar1" id="aceptar1" value="Generar" tabindex="29">
                  </div>
                </div>
              </div>
              <div id="datos1"></div>
            </form>
            <form name="formu1" action="ver_giro.php" method="post" target="_blank">
              <input type="hidden" name="giro_con" id="giro_con" readonly="readonly">
              <input type="hidden" name="giro_per" id="giro_per" readonly="readonly">
              <input type="hidden" name="giro_ano" id="giro_ano" readonly="readonly">
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
          </div>
          <!-- Consultas -->
          <h3>Consultas</h3>
          <div>
            <div id="load1">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu2" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Periodo</font></label>
                  <select name="periodo1" id="periodo1" class="form-control select2" tabindex="1">
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
                  <select name="ano1" id="ano1" class="form-control select2" tabindex="2"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Concepto</font></label>
                  <?php
                  $menu2_2 = odbc_exec($conexion,"SELECT * FROM cx_ctr_gas WHERE codigo IN ('8','9','10') ORDER BY codigo");
                  $menu2 = "<select name='con_pag1' id='con_pag1' class='form-control select2' tabindex='3'>";
                  $i=1;
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
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <br>
                  <input type="button" name="consultar" id="consultar" value="Consultar" tabindex="4">
                </div>
              </div>
              <div class="espacio"></div>
              <div id="datos2"></div>
              <div id="vinculo"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#load1").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 270,
    width: 650,
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
  trae_saldo();
  trae_cdps();
  trae_crps();
  $("#crp").change(trae_crps1);
  $("#giro").prop("disabled",true);
  $("#gastos").prop("disabled",true);
  $("#pagos").prop("disabled",true);
  $("#total").prop("disabled",true);
  $("#total1").prop("disabled",true);
  $("#sal_ban").prop("disabled",true);
  $("#sal_crp").prop("disabled",true);
  $("#cdp").prop("disabled",true);
  $("#fec_crp").prop("disabled",true);
  $("#fec_cdp").prop("disabled",true);
  $("#recurso").prop("disabled",true);
  $("#rubro").prop("disabled",true);
  $("#sal_crp").maskMoney();
  $("#aceptar").button();
  $("#aceptar").click(consulta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta);
  $("#aceptar1").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#datos").hide();
  trae_ano();
  $("#periodo").val('<?php echo $mes; ?>');
  $("#ano").val('<?php echo $ano; ?>');
  $("#ano1").val('<?php echo $ano; ?>');
  var MaxInputs       = 99;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    var paso = $("#v_paso3").val();
    $("#cuenta").prop("disabled",true);
    $("#crp").prop("disabled",true);
    $("#sal_crp").prop("disabled",true);

    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      FieldCount++;
      $("#add_form table").append('<tr><td><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2 espacio1"><select name="crp_'+z+'" id="crp_'+z+'" class="form-control select2" value="'+z+'" onchange="trae_crps2('+z+')"></select></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2 espacio1"><input type="text" name="sar_'+z+'" id="sar_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_val1('+z+');"><input type="hidden" name="sar1_'+z+'" id="sar1_'+z+'" class="form-control numero" value="0" readonly="readonly"><input type="hidden" name="sar2_'+z+'" id="sar2_'+z+'" class="form-control numero" value="0" readonly="readonly"></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1 espacio1"><div id="men_'+z+'"><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></div></div></td></tr>');
      $("#crp_"+z).append(paso);
      $("#sar_"+z).maskMoney();
      trae_crps2(z);
      x_1++;
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    $(this).closest('tr').remove();
    suma_crp();
    return false;
  });
  trae_cuentas();
  var servidor = location.host;
  var url = window.location.href;
  $("#servidor").val(servidor);
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
      $("#ano1").append(salida);
      $("#ano").val('<?php echo $ano; ?>');
    }
  });
}
function trae_saldo()
{
  var saldo = $("#sal_ban1").val();
  saldo = parseFloat(saldo);
  saldo = saldo.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#sal_ban").val(saldo);
}
function trae_cdps()
{
  $("#cdp").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cdps.php",
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
      $("#v_paso3").val(salida);
      $("#crp").append(salida);
      trae_crps1();
    }
  });
}
function trae_crps1()
{
  var cuenta = $("#cuenta").val();
  if ((cuenta === undefined) || (cuenta === null))
  {
    cuenta = "1|";
  }
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  var crp = $("#crp").val();
  if (crp == "-")
  {
    var saldo_crp = "0.00";
    saldo_crp = parseFloat(saldo_crp);
    saldo_crp = saldo_crp.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $("#sal_crp").val(saldo_crp);
    $("#sal_crp1").val(saldo_crp);
    $("#sal_crp2").val(saldo_crp);
    $("#sal_crp").prop("disabled",true);
    $("#add_field").hide();
    if ((cuenta1 == "1") || (cuenta1 == "3"))
    {
    }
    else
    {
      $("#recurso").val('3');
      $("#rubro").val('3');
    }
  }
  else
  {
    $("#sal_crp").prop("disabled",false);
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_crps1.php",
      data:
      {
        crp: $("#crp").val()
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        var saldo_crp;
        saldo_crp = parseFloat(registros.sal_crp);
        saldo_crp = saldo_crp.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        $("#sal_crp").val(saldo_crp);
        $("#sal_crp1").val(registros.sal_crp);
        $("#sal_crp2").val(registros.sal_crp);
        $("#fec_crp").val(registros.fec_crp);
        $("#cdp").val(registros.cdp);
        $("#fec_cdp").val(registros.fec_cdp);
        $("#recurso").val(registros.recurso);
        $("#rubro").val(registros.rubro);
        valida_crp();
      }
    });
  }
}
function trae_crps2(valor)
{
  var valor;
  var valor1 = $("#crp_"+valor).val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_crps1.php",
    data:
    {
      crp: valor1
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var saldo_crp;
      saldo_crp = parseFloat(registros.sal_crp);
      saldo_crp = saldo_crp.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#sar_"+valor).val(saldo_crp);
      $("#sar1_"+valor).val(registros.sal_crp);
      $("#sar2_"+valor).val(registros.sal_crp);
      valida_crp1(valor);
    }
  });
}
function valida_crp()
{
  var crp = $("#sal_crp1").val();
  crp = parseFloat(crp);
  if (crp <= 0)
  {
    var detalle = "Saldo CRP No Permitido";
    alerta(detalle);
    $("#aceptar1").hide();
    $("#add_field").hide();
    $("#sal_crp").prop("disabled",true);
  }
  else
  {
    $("#aceptar1").show();
    $("#add_field").show();
    $("#sal_crp").prop("disabled",false);
    suma_crp();
  }
}
function valida_crp1(valor)
{
  var crp = $("#sar1_"+valor).val();
  crp = parseFloat(crp);
  if (crp <= 0)
  {
    var detalle = "Saldo CRP No Permitido";
    alerta(detalle);
    $("#aceptar1").hide();
    $("#sar_"+valor).prop("disabled",true);
  }
  else
  {
    $("#aceptar1").show();
    $("#sar_"+valor).prop("disabled",false);
    suma_crp();
  }
}
function paso_val()
{
  var valor = $("#sal_crp").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#sal_crp1").val(valor);
  compara_crp();
}
function paso_val1(valor)
{
  var valor;
  var valor1 = $("#sar_"+valor).val()
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#sar1_"+valor).val(valor1);
  compara_crp1(valor);
}
function compara_crp()
{
  var crp = $("#sal_crp1").val();
  crp = parseFloat(crp);
  var crp1 = $("#sal_crp2").val();
  crp1 = parseFloat(crp1);
  var crp2 = crp1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  if (crp > crp1)
  {
    $("#aceptar1").hide();
    var detalle = "Valor CRP superior al Saldo: "+crp2;
    alerta(detalle);
  }
  else
  {
    $("#aceptar1").show();
  }
  suma_crp();
}
function compara_crp1(valor)
{
  var valor;
  var crp = $("#sar1_"+valor).val();
  crp = parseFloat(crp);
  var crp1 = $("#sar2_"+valor).val();
  crp1 = parseFloat(crp1);
  var crp2 = crp1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  if (crp > crp1)
  {
    $("#aceptar1").hide();
    var detalle = "Valor CRP superior al Saldo: "+crp2;
    alerta(detalle);
  }
  else
  {
    $("#aceptar1").show();
  }
  suma_crp();
}
function suma_crp()
{
  var crp = $("#sal_crp1").val();
  crp = parseFloat(crp);
  var valor = 0;
  var suma = 0;
  var contador = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('sar1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      suma = suma+valor;
      contador++;
    }
  }
  suma = suma+crp;
  $("#can_crp").val(contador);
  var total = suma.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#tot_crp").val(total);
  $("#tot_crp1").val(suma);
  var giro = $("#total1").val();
  var diferencia = giro-suma;
  var diferencia1 = diferencia.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#diferencia").val(diferencia1);
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
  $("#sal_ban").val(saldo1);
  $("#sal_ban1").val(saldo);
}
function consulta()
{  
  var tp_consu = $("#con_pag").val();
  if (tp_consu == "8")
  {
    consulta1();
  }
  else
  {
    if (tp_consu == "9")
    {
      consulta2();
    }
    else
    {
      consulta3();
    }
  }
}
function trae_marca(valor, valor1)
{
  var valor, valor1;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('chk_')!=-1)
    {
      var paso = document.getElementById(saux).value;
      var var_ocu = paso.split(',');
      var paso6 = var_ocu[5];
      var paso7 = var_ocu[6];
      paso6 = parseInt(paso6);
      paso7 = parseInt(paso7);
      if ((paso6 == "0") && (paso7 == valor1))
      {
        if ($("#"+saux).is(":checked"))
        {
          $("#"+saux).prop("checked", false);
        }
        else
        {
          $("#"+saux).prop("checked", true);
        }
      }
    }
  }
  trae_suma();
}
function trae_suma()
{
  var gastos = 0;
  var pagos = 0;
  var total = 0;
  var total1 = 0;
  var total2 = 0;
  var total3 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf("chk_")!=-1)
    {
      var paso = $("#"+saux).val();
      var var_ocu = paso.split(',');
      var paso1 = var_ocu[0];
      var paso2 = var_ocu[1];
      var paso3 = var_ocu[2];
      var paso4 = var_ocu[3];
      var paso5 = var_ocu[4];
      var paso6 = var_ocu[5];
      var paso7 = var_ocu[6];
      var paso8 = var_ocu[7];
      var paso9 = var_ocu[8];
      paso3 = parseFloat(paso3);
      paso4 = parseFloat(paso4);
      paso5 = parseFloat(paso5);
      paso6 = parseInt(paso6);
      paso7 = parseInt(paso7);
      paso8 = parseInt(paso8);
      if ($("#"+saux).is(":checked"))
      {
        gastos = gastos+paso3;
        pagos = pagos+paso4;
        total = total+paso5;
      }
    }
  }
  total = parseFloat(total);
  total1 = gastos.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  total2 = pagos.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  total3 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#gastos").val(total1);
  $("#pagos").val(total2);
  $("#total").val(total3);
  $("#total1").val(total);
  if (total == "0")
  {
    $("#giro").val('0');
    $("#aceptar1").hide();
  }
  else
  {
    consulta5();
    $("#aceptar1").show();
  }
}
function trae_suma1()
{
  var gastos = 0;
  var pagos = 0;
  var total = 0;
  var total1 = 0;
  var total2 = 0;
  var total3 = 0;
  var contador = 0;
  var tp_consu = $("#con_pag").val();
  $("input[name='seleccionados[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        var paso = $(this).val();
        var var_ocu = paso.split(',');
				var paso1 = var_ocu[0];
				var paso2 = var_ocu[1];
				var paso3 = var_ocu[2];
				var paso4 = var_ocu[3];
				var paso5 = var_ocu[4];
				var paso6 = var_ocu[5];
				var paso7 = var_ocu[6];
				var paso8 = var_ocu[7];
				var paso9 = var_ocu[8];
				paso4 = parseFloat(paso4);
				paso5 = parseFloat(paso5);
				paso6 = parseFloat(paso6);
        gastos = gastos+paso4;
        pagos = pagos+paso5;
        total = total+paso6;
        contador ++;
      }
    }
  );
  total = parseFloat(total);
  total1 = gastos.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  total2 = pagos.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  total3 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#gastos").val(total1);
  $("#pagos").val(total2);
  $("#total").val(total3);
  $("#total1").val(total);
  if (total == "0")
  {
    $("#giro").val('0');
    $("#aceptar1").hide();
  }
  else
  {
    if (tp_consu == "9")
    {
      consulta6();
    }
    else
    {
      consulta7(); 
    }
    $("#aceptar1").show();
  }
  suma_crp();
}
function todos_marca()
{
  var todos = 0;
  if ($("#chk1").is(":checked"))
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
// Presupuesto Mensual
function consulta1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "giro_consu.php",
    data:
    {
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
      $("#datos1").html('');
      $("#aceptar").hide();
      $("#periodo").prop("disabled",true);
      $("#ano").prop("disabled",true);
      $("#con_pag").prop("disabled",true);
      trae_crps1(); 
      $("#datos").show();
      var registros = JSON.parse(data);
      $("#giro").val(registros.giro);
      $("#v_paso1").val(registros.centra);
      $("#v_paso2").val(registros.centraliza);
      var valor1, valor2, valor3;
      valor1 = parseInt(registros.gastos);
      valor1 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      valor2 = parseInt(registros.pagos);
      valor2 = valor2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      valor3 = parseInt(registros.total);
      valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#gastos").val(valor1);
      $("#pagos").val(valor2);
      $("#total").val(valor3);
      $("#total1").val(registros.total);
      $("#crp").focus();
      var salida = "";
      salida += "<br><table width='70%' align='center' border='1'><tr><td width='5%' height='30' bgcolor='#cccccc'><center>&nbsp;</center></td><td width='20%' height='30' bgcolor='#cccccc'><center><b>Unidad</b></center></td><td width='25%' height='30' bgcolor='#cccccc'><center><b>Gastos</b></center></td><td width='25%' height='30' bgcolor='#cccccc'><center><b>Pagos</b></center></td><td width='25%' height='30' bgcolor='#cccccc'><center><b>Total</b></center></td></tr>";
      //<input type='checkbox' name='chk1' id='chk1' onclick='todos_marca();'>
      var y = 1;
      $.each(registros.rows, function (index, value)
      {
        valor0 = value.unidad;
        valor1 = value.sigla;
        valor1 = valor1.trim();
        valor2 = value.t_gastos;
        valor3 = value.t_pagos;
        valor4 = value.t_total;
        valor5 = parseFloat(valor2);
        valor6 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor7 = parseFloat(valor3);
        valor8 = valor7.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor9 = parseFloat(valor4);
        valor10 = valor9.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor11 = value.conse;
        valor12 = value.centra;
        valor13 = value.centra1;
        valor14 = value.uom;
        valor15 = value.n_depen;
        valor15 = valor15.trim();
        if (valor12 == "1")
        {
          sal_check = '';
          col_chekc = 'bgcolor="#ccc"';
        }
        else
        {
          sal_check = 'disabled="disabled"';
          col_chekc = '';
        }
        salida += '<tr><td height="30" '+col_chekc+'><center><input type="checkbox" name="chk_'+y+'" id="chk_'+y+'" value="'+y+','+valor11+','+valor5+','+valor7+','+valor9+','+valor12+','+valor13+','+valor14+','+valor15+'"'+sal_check+' onclick="trae_marca('+valor12+','+valor13+');"></center></td>';
        salida += '<td '+col_chekc+'><input type="hidden" name="cos_'+y+'" id="cos_'+y+'" class="c10" value="'+valor11+'" readonly="readonly"><input type="hidden" name="uni_'+y+'" id="uni_'+y+'" class="c10" value="'+valor0+'" readonly="readonly"><input type="hidden" name="sig_'+y+'" id="sig_'+y+'" class="c10" value="'+valor1+'" readonly="readonly">'+valor1+'</td><td align="right" '+col_chekc+'><input type="hidden" name="gas_'+y+'" id="gas_'+y+'" class="c10" value="'+value.t_gastos+'" readonly="readonly">'+valor6+'</td><td align="right" '+col_chekc+'><input type="hidden" name="pag_'+y+'" id="pag_'+y+'" class="c10" value="'+value.t_pagos+'" readonly="readonly">'+valor8+'</td><td align="right" '+col_chekc+'><input type="hidden" name="tot_'+y+'" id="tot_'+y+'" class="c10" value="'+value.t_total+'" readonly="readonly">'+valor10+'</td></tr>';
        y++;
      });
      salida += '</table>';
      $("#datos1").append(salida);
      var valida;
      valida = $("#giro").val();
      if (valida == "0")
      {
        $("#aceptar1").hide();
        $("#datos1").html('');
        $("#crp").prop("disabled",true);
        $("#cash").prop("disabled",true);
        consulta4();
      }
      else
      {
        $("#aceptar1").show();
      }
      trae_suma();
    }
  });
}
// Presupuesto Adicional
function consulta2()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "giro_consu1.php",
    data:
    {
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
      $("#datos1").html('');
      $("#aceptar").hide();
      $("#periodo").prop("disabled",true);
      $("#ano").prop("disabled",true);
      $("#con_pag").prop("disabled",true);
      trae_crps1(); 
      $("#datos").show();
      var registros = JSON.parse(data);
      $("#giro").val(registros.giro);
      $("#v_paso1").val(registros.centra);     
      $("#v_paso2").val(registros.centraliza);
      var valor1, valor2, valor3;
      valor1 = parseFloat(registros.gastos);
      valor1 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      valor2 = parseFloat(registros.pagos);
      valor2 = valor2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      valor3 = parseFloat(registros.total);
      valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#gastos").val(valor1);
      $("#pagos").val(valor2);
      $("#total").val(valor3);
      $("#total1").val(registros.total);
      $("#crp").focus();
      var salida = "";
      salida += "<br><table width='70%' align='center' border='1'><tr><td width='3%' height='30' bgcolor='#cccccc'>&nbsp;</td><td width='22%' height='30' bgcolor='#cccccc'><center><b>Unidad</b></center></td><td width='25%' height='30' bgcolor='#cccccc'><center><b>Gastos</b></center></td><td width='25%' height='30' bgcolor='#cccccc'><center><b>Pagos</b></center></td><td width='25%' height='30' bgcolor='#cccccc'><center><b>Total</b></center></td></tr>";
      var y = 1;
      $.each(registros.rows, function (index, value)
      {
        valor0 = value.unidad;
        valor1 = value.sigla;
        valor2 = value.t_gastos;
        valor3 = value.t_pagos;
        valor4 = value.t_total;
        valor5 = parseFloat(valor2);
        valor6 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor7 = parseFloat(valor3);
        valor8 = valor7.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor9 = parseFloat(valor4);
        valor10 = valor9.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor11 = value.conse;
        valor12 = value.depen;
        valor13 = value.uom;
        salida += '<tr><td height="30"><center><input type="checkbox" name="seleccionados[]" id="chk1_'+y+'" value="'+y+','+valor0+','+valor1+','+valor5+','+valor7+','+valor9+','+valor11+','+valor12+','+valor13+'" onclick="trae_suma1();"></center></td><td height="30"><input type="hidden" name="cos_'+y+'" id="cos_'+y+'" class="c10" value="'+valor11+'" readonly="readonly"><input type="hidden" name="uni_'+y+'" id="uni_'+y+'" class="c10" value="'+valor0+'" readonly="readonly"><input type="hidden" name="sig_'+y+'" id="sig_'+y+'" class="c10" value="'+valor1+'" readonly="readonly">'+valor1+'</td><td align="right"><input type="hidden" name="gas_'+y+'" id="gas_'+y+'" class="c10" value="'+value.t_gastos+'" readonly="readonly">'+valor6+'</td><td align="right"><input type="hidden" name="pag_'+y+'" id="pag_'+y+'" class="c10" value="'+value.t_pagos+'" readonly="readonly">'+valor8+'</td><td align="right"><input type="hidden" name="tot_'+y+'" id="tot_'+y+'" class="c10" value="'+value.t_total+'" readonly="readonly">'+valor10+'</td></tr>';
        y++;
      });
      salida += '</table>';
      $("#datos1").append(salida);
      var valida;
      valida = $("#giro").val();
      if (valida == "0")
      {
        $("#aceptar1").hide();
        $("#datos1").html('');
        $("#crp").prop("disabled",true);
        $("#cash").prop("disabled",true);
        consulta4();
      }
      else
      {
        $("#aceptar1").show();
      }
      trae_suma1();
    }
  });
}
// Presupuesto Recompensas
function consulta3()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "giro_consu2.php",
    data:
    {
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
      $("#datos1").html('');
      $("#aceptar").hide();
      $("#periodo").prop("disabled",true);
      $("#ano").prop("disabled",true);
      $("#con_pag").prop("disabled",true);
      trae_crps1(); 
      $("#datos").show();
      var registros = JSON.parse(data);
      $("#men1_1").html('');
      $("#men1_1").append('Total Valor');
      $("#men2_1").hide();
      $("#men2_2").hide();
      $("#giro").val(registros.giro);
      $("#v_paso1").val(registros.centra);
      $("#v_paso2").val(registros.centraliza);
      var valor1, valor2, valor3;
      valor1 = parseFloat(registros.valor);
      valor1 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      valor2 = parseFloat("0");
      valor2 = valor2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      valor3 = parseFloat(registros.total);
      valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#gastos").val(valor1);
      $("#pagos").val(valor2);
      $("#total").val(valor3);
      $("#total1").val(registros.total);
      $("#crp").focus();
      var salida = "";
      salida += "<br><table width='50%' align='center' border='1'><tr><td width='3%' height='30' bgcolor='#cccccc'>&nbsp;</td><td width='22%' height='30' bgcolor='#cccccc'><center><b>Unidad</b></center></td><td width='25%' height='30' bgcolor='#cccccc'><center><b>Valor</b></center></td><td width='25%' height='30' bgcolor='#cccccc'><center><b>Total</b></center></td></tr>";
      var y = 1;
      $.each(registros.rows, function (index, value)
      {
        valor0 = value.unidad;
        valor1 = value.sigla;
        valor2 = value.t_valor;
        valor3 = "0";
        valor4 = value.t_total;
        valor5 = parseFloat(valor2);
        valor6 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor7 = parseFloat(valor3);
        valor8 = valor7.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor9 = parseFloat(valor4);
        valor10 = valor9.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor11 = value.conse;
        valor12 = value.depen;
        valor13 = value.uom;
        salida += '<tr><td height="30"><center><input type="checkbox" name="seleccionados[]" id="chk1_'+y+'" value="'+y+','+valor0+','+valor1+','+valor5+','+valor7+','+valor9+','+valor11+','+valor12+','+valor13+'" onclick="trae_suma1();"></center></td><input type="hidden" name="cos_'+y+'" id="cos_'+y+'" class="c10" value="'+valor11+'" readonly="readonly"><td height="30"><input type="hidden" name="uni_'+y+'" id="uni_'+y+'" class="c10" value="'+valor0+'" readonly="readonly"><input type="hidden" name="sig_'+y+'" id="sig_'+y+'" class="c10" value="'+valor1+'" readonly="readonly">'+valor1+'</td><td align="right"><input type="hidden" name="val_'+y+'" id="val_'+y+'" class="c10" value="'+value.t_valor+'" readonly="readonly">'+valor6+'</td><td align="right"><input type="hidden" name="tot_'+y+'" id="tot_'+y+'" class="c10" value="'+value.t_total+'" readonly="readonly">'+valor10+'</td></tr>';
        y++;
      });
      salida += '</table>';
      $("#datos1").append(salida);
      var valida;
      valida = $("#giro").val();
      if (valida == "0")
      {
        $("#aceptar1").hide();
        $("#datos1").html('');
        $("#crp").prop("disabled",true);
        $("#cash").prop("disabled",true);
        consulta4();
      }
      else
      {
        $("#aceptar1").show();
      }
      trae_suma1();
    }
  });
}
function consulta4()
{
  var orden = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "giro_consu3.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
      concepto: $("#con_pag").val(),
      orden: orden
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
      $("#datos1").html('');
      var registros = JSON.parse(data);
      var salida = "";
      salida += "<br><table width='25%' align='center' border='1'><tr><td bgcolor='#cccccc' height='30'><center><b>Informe de Giro</b></center></td></tr>";
      var y = 1;
      $.each(registros.rows, function (index, value)
      {
        valor0 = value.conse;
        valor1 = value.n_unidad;
        valor2 = value.numero;
        salida += "<tr><td height='30'><center><a href='#' onclick='link2("+valor0+")'>"+valor1+" - "+valor2+"</a></center></td></tr>";
        y++;
      });
      salida += '</table>';
      $("#datos1").append(salida);
      $("#cuenta").prop("disabled",true);
      $("#sal_crp").prop("disabled",true);
      $("#soporte").prop("disabled",true);
      $("#firma").prop("disabled",true);
      $("#aceptar1").hide();
      $("#add_field").hide();
    }
  });
}
// Marcados Presupuesto Basico
function consulta5()
{
  var uom = "";
  var dep = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('chk_')!=-1)
    {
      var paso = $("#"+saux).val();
      var var_ocu = paso.split(',');
      var paso1 = var_ocu[0];
      var paso2 = var_ocu[1];
      var paso3 = var_ocu[2];
      var paso4 = var_ocu[3];
      var paso5 = var_ocu[4];
      var paso6 = var_ocu[5];
      var paso7 = var_ocu[6];
      var paso8 = var_ocu[7];
      var paso9 = var_ocu[8];
      paso3 = parseFloat(paso3);
      paso4 = parseFloat(paso4);
      paso5 = parseFloat(paso5);
      paso6 = parseInt(paso6);
      paso7 = parseInt(paso7);
      paso8 = parseInt(paso8);
      if ($("#"+saux).is(":checked"))
      {
        if (paso6 == "1")
        {
          uom += paso8+",";
          dep += "'"+paso9+"',";
        }
      }
    }
  }
  uom = uom.substr(0, uom.length-1);
  dep = dep.substr(0, dep.length-1);
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "giro_consu4.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
      uom: uom,
      dep: dep
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
      $("#giro").val(registros.giro);
      $("#v_paso1").val(registros.centra);
      $("#v_paso2").val(registros.centraliza);
    }
  });
}
// Marcados Presupuesto Adicional
function consulta6()
{
  var con = "";
  var cos = "";
  var uni = "";
  var dep = "";
  var uom = "";
  $("input[name='seleccionados[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        var paso = $(this).val();
        var var_ocu = paso.split(',');
				var paso1 = var_ocu[0];
				var paso2 = var_ocu[1];
				var paso3 = var_ocu[2];
				var paso4 = var_ocu[3];
				var paso5 = var_ocu[4];
				var paso6 = var_ocu[5];
				var paso7 = var_ocu[6];
				var paso8 = var_ocu[7];
				var paso9 = var_ocu[8];
        con += paso7+",";
        cos += paso7+"|";
        uni += paso2+"|";
        dep += paso8+",";
        uom += paso9+",";
      }
    }
  );
  con = con.substr(0, con.length-1);
  dep = dep.substr(0, dep.length-1);
  uom = uom.substr(0, uom.length-1);
  $("#v_con").val(cos);
  $("#v_uni").val(uni);
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "giro_consu5.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
      con: con,
      dep: dep,
      uom: uom
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
      $("#giro").val(registros.giro);
      $("#v_paso1").val(registros.centra);
      $("#v_paso2").val(registros.centraliza);
    }
  });
}
// Marcados Presupuesto Recompensa
function consulta7()
{
  var con = "";
  var cos = "";
  var uni = "";
  var dep = "";
  var uom = "";
  $("input[name='seleccionados[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        var paso = $(this).val();
        var var_ocu = paso.split(',');
        var paso1 = var_ocu[0];
        var paso2 = var_ocu[1];
        var paso3 = var_ocu[2];
        var paso4 = var_ocu[3];
        var paso5 = var_ocu[4];
        var paso6 = var_ocu[5];
        var paso7 = var_ocu[6];
        var paso8 = var_ocu[7];
        var paso9 = var_ocu[8];
        con += paso7+",";
        cos += paso7+"|";
        uni += paso2+"|";
        dep += paso8+",";
        uom += paso9+",";
      }
    }
  );
  con = con.substr(0, con.length-1);
  dep = dep.substr(0, dep.length-1);
  uom = uom.substr(0, uom.length-1);
  $("#v_con").val(cos);
  $("#v_uni").val(uni);
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "giro_consu6.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
      con: con,
      dep: dep,
      uom: uom
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
      $("#giro").val(registros.giro);
      $("#v_paso1").val(registros.centra);
      $("#v_paso2").val(registros.centraliza);
    }
  });
}
function consultar()
{
  var orden = "2";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "giro_consu3.php",
    data:
    {
      periodo: $("#periodo1").val(),
      ano: $("#ano1").val(),
      concepto: $("#con_pag1").val(),
      orden: orden
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
      $("#datos2").html('');
      var registros = JSON.parse(data);
      var salida = "";
      listareg = [];
      salida += "<br><table width='25%' align='center' border='1'><tr><td bgcolor='#cccccc' height='30' colspan='2'><center><b>Informe de Giro</b></center></td></tr>";
      var y = 1;
      $.each(registros.rows, function (index, value)
      {
        valor0 = value.conse;
        valor1 = value.n_unidad;
        valor2 = value.numero;
        var datos = '\"'+valor0+'\",\"'+valor1+'\",\"'+index+'\"';
        salida += "<tr><td height='30' width='85%' id='l1_"+index+"'><center><a href='#' onclick='link1("+valor0+")'>"+valor1+" - "+valor2+"</a></center></td>";
        salida += "<td height='30' width='15%' id='l2_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",2); subir("+datos+")'><img src='imagenes/pdf.png' border='0' title='Visualizar Informe de Giro Firmado'></a></center></td>";
        salida += "</tr>";
        listareg.push(index);
        y++;
      });
      salida += '</table>';
      $("#datos2").append(salida);
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
function graba()
{
	var tp_consu = $("#con_pag").val();
  if ((tp_consu == "9") || (tp_consu == "10"))
  {
  }
  else
  {
    document.getElementById('v_con').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('cos_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_con').value = document.getElementById('v_con').value+valor+"|";
      }
    }
    document.getElementById('v_uni').value = "";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('uni_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_uni').value = document.getElementById('v_uni').value+valor+"|";
      }
    }
  }
  document.getElementById('v_sig').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('sig_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_sig').value = document.getElementById('v_sig').value+valor+"|";
    }
  }
  document.getElementById('v_gas').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('gas_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_gas').value = document.getElementById('v_gas').value+valor+"|";
    }
  }
  document.getElementById('v_pag').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('pag_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_pag').value = document.getElementById('v_pag').value+valor+"|";
    }
  }
  document.getElementById('v_tot').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('tot_')!=-1)
    {
      if ((saux == "tot_crp") || (saux == "tot_crp1"))
      {
      }
      else
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_tot').value = document.getElementById('v_tot').value+valor+"|";
      }
    }
  }
  var num_crp = 0;
  document.getElementById('v_crp').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('crp_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_crp').value = document.getElementById('v_crp').value+valor+"|";
      num_crp ++;
    }
  }
  document.getElementById('v_sal').value = "";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('sar1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('v_sal').value = document.getElementById('v_sal').value+valor+"|";
    }
  }
  var salida = true, detalle = '';
  if ($("#cash").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el CASH</h3></center>";
  }
  var lista = [];
  var c_crp = $("#crp").val();
  lista.push(c_crp);
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('crp_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (jQuery.inArray(valor, lista) != -1)
      {
        salida = false;
        detalle += "<center><h3>CRP Registrado más de una vez</h3></center>";
      }
      else
      {
        lista.push(valor);
      }
    }
  }
  var cuenta = $("#cuenta").val();
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  var compara1, compara2, compara3, compara4;
  compara1 = $("#total1").val();
  compara1 = parseFloat(compara1);
  compara1 = compara1.toFixed(2);
  compara2 = $("#tot_crp1").val();
  compara2 = parseFloat(compara2);
  compara2 = compara2.toFixed(2);
  compara3 = $("#sal_ban1").val();
  compara3 = parseFloat(compara3);
  if (compara1 == "0")
  {
    salida = false;
    detalle += "<center><h3>Valor Informe de Giro No Válido</h3></center>";    
  }
  if (compara1 > compara3)
  {
    salida = false;
    detalle += "<center><h3>Valor Informe de Giro superior al Saldo del Banco</h3></center>";
  }
  if (cuenta1 == "1")
  {
    if (compara1 > compara2)
    {
      salida = false;
      detalle += "<center><h3>Valor Informe de Giro superior a Suma Total CRP</h3></center>";
    }
    if (num_crp == "0")
    {
    }
    else
    {
      if (compara1 != compara2)
      {
        alerta("Valor Giro: "+compara1);
        alerta("Valor CRP: "+compara2);
        salida = false;
        detalle += "<center><h3>Valor Informe de Giro debe ser igual a Suma Total CRP</h3></center>";
      }
    }
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    if (num_crp == "0")
    {
      $("#sal_crp").prop("disabled",true);
      compara4 = $("#total").val();
      $("#sal_crp").val(compara4);
      paso_val();
    }
    graba1();
  }
}
function graba1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "inf_grab.php",
    data:
    {
      periodo: $("#periodo").val(),
      mes: $("#periodo option:selected").html(),
      ano: $("#ano").val(),
      unidades: $("#giro").val(),
      cuenta: $("#cuenta").val(),
      gastos: $("#gastos").val(),
      pagos: $("#pagos").val(),
      total: $("#total").val(),
      total1: $("#total1").val(),
      crp: $("#crp").val(),
      saldo: $("#sal_crp1").val(),
      cdp: $("#cdp").val(),
      recurso: $("#recurso").val(),
      rubro: $("#rubro").val(),
      concepto: $("#con_pag").val(),
      concepto1: $("#con_pag option:selected").html(),
      cash: $("#cash").val(),
      conses1: $("#v_con").val(),
      unidades1: $("#v_uni").val(),
      siglas1: $("#v_sig").val(),
      gastos1: $("#v_gas").val(),
      pagos1: $("#v_pag").val(),
      totales1: $("#v_tot").val(),
      cantidad: $("#can_crp").val(),
      crps: $("#v_crp").val(),
      saldos: $("#v_sal").val(),
      paso1: $("#v_paso1").val(),
      paso2: $("#v_paso2").val(),
      soporte: $("#soporte").val(),
      firma: $("#firma").val(),
      usuario: $("#v_usuario").val(),
      unidad: $("#v_unidad").val(),
      ciudad: $("#v_ciudad").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var valida = registros.salida;
      var conses = registros.conses;
      var datos1 = registros.datos1;
      var datos2 = registros.datos2;
      $("#v_paso4").val(datos1);
      $("#v_paso5").val(datos2);
      if (valida > 0)
      {
        $("#aceptar1").hide();
        $("#cuenta").prop("disabled",true);
        $("#crp").prop("disabled",true);
        $("#sal_crp").prop("disabled",true);
        $("#con_pag").prop("disabled",true);
        $("#cash").prop("disabled",true);
        $("#soporte").prop("disabled",true);
        $("#firma").prop("disabled",true);
        for (i=0;i<document.formu.elements.length;i++)
        {
          saux = document.formu.elements[i].name;
          if (saux.indexOf('crp_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('sar_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        for (j=0;j<=30;j++)
        {
          $("#men_"+j).hide();
        }
        $("#add_field").hide();
        $("#datos1").html('');
        var var_ocu = conses.split('«');
        var var_ocu1 = var_ocu.length;
        var salida = "";
        salida += "<br><table width='25%' align='center' border='1'><tr><td bgcolor='#cccccc' height='30'><center><b>Informe de Giro</b></center></td></tr>";
        for (var i=0; i<var_ocu1-1; i++)
        {
          var var_1 = var_ocu[i];
          var var_2 = var_1.split("|");
          var p_1 = var_2[0];
          var p_2 = var_2[1];
          salida += "<tr><td height='30'><center><a href='#' onclick='link("+p_1+")'>"+p_2+" - "+p_1+"</a></center></td></tr>";
        }
        salida += '</table>';
        $("#datos1").append(salida);
        envios();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar1").show();
      }
    }
  });
}
function subir(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  var periodo = $("#periodo1 option:selected").html();
  var ano = $("#ano1 option:selected").html();
  var concepto = $("#con_pag1").val();
  var url = "<a href='./subir26.php?periodo="+periodo+"&ano="+ano+"&concepto="+concepto+"&unidad="+valor1+"&conse="+valor+"'  name='link3' id='link3' class='pantalla-modal'>Link</a>";
  $("#vinculo").hide();
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#link3").click();
}
function envios()
{
  var datos1 = $("#v_paso4").val();
  var var_ocu = datos1.split('|');
  var var_ocu1 = var_ocu.length;
  var notifica = "";
  for (var i=0; i<var_ocu1-1; i++)
  {
    notifica = var_ocu[i];
    correo(notifica,i);
  }
}
function correo(valor, valor1)
{
  var valor, valor1;
  var copia = $("#correo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_correo.php",
    data:
    {
      usuario: valor
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var email = registros.email;
      correo1(valor, email, copia, valor1);
    }
  });
}
function correo1(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3;
  var datos1 = $("#v_paso5").val();
  var var_ocu = datos1.split('|');
  var valor4 = var_ocu[valor3];
  var concepto = $("#con_pag option:selected").html();
  var periodo = $("#periodo option:selected").html();
  var tipo = "5";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "correo.php",
    data:
    {
      tipo: tipo,
      usuario: $("#v_usuario").val(),
      email: valor1,
      copia: valor2,
      servidor: $("#servidor").val(),
      valor1: concepto,
      valor2: periodo,
      valor3: $("#ano").val(),
      valor4: valor4
    },
    success: function (data) {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        alerta1("E-mail enviado correctamente");
      }
      else
      {
        alerta("Error durante el envio e-mail");
      }
    }
  });
}
function link(valor)
{
  var valor;
  var periodo = $("#periodo").val();
  var ano = $("#ano").val();
  $("#giro_con").val(valor);
  $("#giro_per").val(periodo);
  $("#giro_ano").val(ano);
  formu1.submit();
}
function link1(valor)
{
  var valor;
  var periodo = $("#periodo1").val();
  var ano = $("#ano1").val();
  $("#giro_con").val(valor);
  $("#giro_per").val(periodo);
  $("#giro_ano").val(ano);
  formu1.submit();
}
function link2(valor)
{
  var valor;
  var periodo = $("#periodo").val();
  var ano = $("#ano").val();
  $("#giro_con").val(valor);
  $("#giro_per").val(periodo);
  $("#giro_ano").val(ano);
  formu1.submit();
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
// 14/09/2023 - Ajuste link de funcion en llamado a combo de periodo en registro y consulta
// 04/04/2024 - Ajuste redondeo a dos decimales valores calculados de crp y total giro
// 31/07/2024 - Ajuste inclusion codigo para cargue de informe firmado
?>