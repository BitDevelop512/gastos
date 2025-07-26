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
  include('permisos.php');
  $query = "SELECT unidad,dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $query);
  $n_unidad = odbc_result($cur,1);
  $n_dependencia = odbc_result($cur,2);
  if (($n_unidad == "2") or ($n_unidad == "3"))
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' ORDER BY subdependencia";
  }
  else
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY subdependencia";
  }
  $cur1 = odbc_exec($conexion, $query1);
  $numero = "";
  while($i<$row=odbc_fetch_array($cur1))
  {
    $numero .= "'".odbc_result($cur1,1)."',";
  }
  $numero = substr($numero,0,-1);
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
          <h3>Administraci&oacute;n de Bienes</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">C&oacute;digo:</font></label>
                  <input type="text" name="filtro" id="filtro" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onblur="trae_bienes1();" maxlength="50" autocomplete="off" tabindex="1">
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Descripci&oacute;n:</font></label>
                  <input type="text" name="filtro1" id="filtro1" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onblur="trae_bienes1();" maxlength="50" autocomplete="off" tabindex="2">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Clasificaci&oacute;n:</font></label>
                  <select name="filtro3" id="filtro3" class="form-control select2" tabindex="3" onchange="trae_bienes1();"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Unidad:</font></label>
                  <select name="filtro2" id="filtro2" class="form-control select2" tabindex="4" onchange="trae_bienes1();"></select>
                </div>
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                  <label><font face="Verdana" size="2">Consulta</font></label>
                  <br>
                  <input type="checkbox" name="historico" id="historico" value="0" onclick="trae_historico();" title="Control Administrativo">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Marca:</font></label>
                  <input type="text" name="filtro4" id="filtro4" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onblur="trae_bienes1();" maxlength="50" autocomplete="off" tabindex="5">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Color:</font></label>
                  <input type="text" name="filtro5" id="filtro5" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onblur="trae_bienes1();" maxlength="50" autocomplete="off" tabindex="6">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Modelo:</font></label>
                  <input type="text" name="filtro6" id="filtro6" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onblur="trae_bienes1();" maxlength="50" autocomplete="off" tabindex="7">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Serial:</font></label>
                  <input type="text" name="filtro7" id="filtro7" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onblur="trae_bienes1();" maxlength="50" autocomplete="off" tabindex="8">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor mayor:</font></label>
                  <input type="text" name="filtro8" id="filtro8" class="form-control numero" value="0.00" onkeyup="paso_val();" autocomplete="off" tabindex="9">
                  <input type="hidden" name="filtro8_1" id="filtro8_1" class="form-control numero" value="0" autocomplete="off" tabindex="10">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor menor:</font></label>
                  <input type="text" name="filtro9" id="filtro9" class="form-control numero" value="0.00" onkeyup="paso_val1();" onblur="trae_bienes1();" autocomplete="off" tabindex="11">
                  <input type="hidden" name="filtro9_1" id="filtro9_1" class="form-control numero" value="0" autocomplete="off" tabindex="12">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha Compra</font></label>
                  <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">&nbsp;</font></label>
                  <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </div>
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                  <br>
                  <a href="#" onclick="excel(); return false;">
                    <img src="dist/img/excel1.png" name='lnk4' id='lnk4' title="Exportar Bienes a Excel - SAP">
                  </a>
                  <a href="#" onclick="excel1(); return false;">
                    <img src="dist/img/excel.png" name='lnk5' id='lnk5' title="Descargar Bienes a Excel - SAP">
                  </a>
                </div>
              </div>
              <hr>
              <div id="tabla9"></div>
              <br>
              <div id="resultados12"></div>
              <input type="hidden" name="n_unidad" id="n_unidad" class="form-control" value="<?php echo $n_unidad; ?>" readonly="readonly">
              <input type="hidden" name="n_dependencia" id="n_dependencia" class="form-control" value="<?php echo $n_dependencia; ?>" readonly="readonly">
              <input type="hidden" name="numero" id="numero" class="form-control" value="<?php echo $numero; ?>" readonly="readonly">
              <input type="hidden" name="paso" id="paso" class="form-control" readonly="readonly">
              <input type="hidden" name="paso1" id="paso1" class="form-control" readonly="readonly">
              <input type="hidden" name="v_super" id="v_super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly">
              <div id="vinculo"></div>
            </form>
            <form name="formu_excel" id="formu_excel" action="bienes_x.php" target="_blank" method="post">
		          <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
            </form>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
            <div id="dialogo2"></div>
            <div id="dialogo3">
              <form name="formu2">
                <table width="98%" align="center" border="0">
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                          <div id="mensaje"></div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4"></div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Cantidad</font></label></center>
                          <input type="text" name="cantidad" id="cantidad" class="form-control numero" onkeypress="return check(event);" value="1" maxlength="2">
                          <input type="hidden" name="placa" id="placa" class="form-control numero" value="" readonly="readonly">
                        </div>
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
          <h3>Actualizaci&oacute;n de Bienes</h3>
          <div>
            <form name="formu1" method="post">
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Clasificaci&oacute;n:</font></label>
                  <select name="clasificacion" id="clasificacion" class="form-control select2" onchange="car_bienes()"></select>
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Tipo de Bien:</font></label>
                  <select name="bien" id="bien" class="form-control select2"></select>
                </div>
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                  <br>
                  <a href="#" name="lnk2" id="lnk2" onclick="subir();"><img src="imagenes/clip.png" border="0" title="Anexar Factura"></a>
                </div>
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                  <input type="hidden" name="alea" id="alea" class="form-control" readonly="readonly" tabindex="13">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">C&oacute;digo:</font></label>
				          <input type="hidden" name="conse" id="conse" class="form-control" readonly="readonly" tabindex="14">
                  <input type="text" name="codigo" id="codigo" class="form-control" readonly="readonly" tabindex="15">
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Descripci&oacute;n:</font></label>
                  <textarea name="descripcion" id="descripcion" class="form-control" rows="4" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="16"></textarea>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor:</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/valor.png" name="img1" id="img1" width="20" border="0" title="Modificar Valor" class="mas" onclick="actu1();"><img src="dist/img/grabar.png" name="img2" id="img2" width="20" border="0" title="Actualizar Valor" class="mas" onclick="actu2();"></label>
				          <input type="text" name="valor" id="valor" class="form-control numero" onkeyup="paso_val4();" tabindex="17">
				          <input type="hidden" name="valor1" id="valor1" class="form-control numero" value="0" readonly="readonly" tabindex="18">
				        </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha:</font></label>
				          <input type="text" name="fecha" id="fecha" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="19">
				        </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Marca:</font></label>
                  <input type="text" name="marca" id="marca" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off" tabindex="20">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Color:</font></label>
                  <input type="text" name="color" id="color" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off" tabindex="21">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Modelo:</font></label>
                  <input type="text" name="modelo" id="modelo" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off" tabindex="22">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Serial:</font></label>
                  <input type="text" name="serial" id="serial" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off" tabindex="23">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">No. SOAT:</font></label>
                  <input type="text" name="soatn" id="soatn" class="form-control numero" autocomplete="off" tabindex="24">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Aseguradora:</font></label>
                  <input type="text" name="soata" id="soata" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off" tabindex="25">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Vigencia SOAT desde:</font></label>
                  <input type="text" name="soat1" id="soat1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="26">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Vigencia SOAT hasta:</font></label>
                  <input type="text" name="soat2" id="soat2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" autocomplete="off" tabindex="27">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Clase Seguro:</font></label>
                  <input type="text" name="seguc" id="seguc" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off" tabindex="28">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor Seguro:</font></label>
				          <input type="text" name="valos" id="valos" class="form-control numero" value="0.00" onkeyup="paso_val2(); valida2();" tabindex="29">
				          <input type="hidden" name="valot" id="valot" class="form-control numero" value="0" readonly="readonly" tabindex="30">
				      </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">No. Seguro:</font></label>
                  <input type="text" name="segun" id="segun" class="form-control numero" autocomplete="off" tabindex="31">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Aseguradora:</font></label>
                  <input type="text" name="segua" id="segua" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off" tabindex="32">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Vigencia Seguro desde:</font></label>
                  <input type="text" name="segu1" id="segu1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="33">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Vigencia Seguro hasta:</font></label>
                  <input type="text" name="segu2" id="segu2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" autocomplete="off" tabindex="34">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Unidad:</font></label>
				          <select name="unidades" id="unidades" class="form-control select2"></select>
				        </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Compa&ntilde;ia:</font></label>
                  <input type="text" name="compania" id="compania" class="form-control" autocomplete="off" tabindex="36">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Funcionario:</font></label>
                  <input type="text" name="funcionario" id="funcionario" class="form-control" maxlength="100" autocomplete="off" tabindex="37">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">ORDOP:</font></label>
                  <input type="text" name="ordop" id="ordop" class="form-control" autocomplete="off" tabindex="38">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Misi&oacute;n:</font></label>
                  <input type="text" name="mision" id="mision" class="form-control" autocomplete="off" tabindex="39">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Estado:</font></label>
                  <input type="text" name="estado" id="estado" class="form-control" autocomplete="off" tabindex="40">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">&nbsp;</font></label>
                  <select name="estado1" id="estado1" class="form-control select2" tabindex="41">
                    <option value="0">SIN ESTADO</option>
                    <option value="1">BUENO</option>
                    <option value="2">REGULAR</option>
                    <option value="3">DAÑADO</option>
                    <option value="4">CONSUMIDO</option>
                    <option value="9">PERDIDO</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Plan / Solicitud:</font></label>
                  <input type="text" name="plan" id="plan" class="form-control numero" autocomplete="off" tabindex="42">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Egreso:</font></label>
                  <input type="text" name="egreso" id="egreso" class="form-control numero" autocomplete="off" tabindex="43">
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Responsable:</font></label>
                  <input type="text" name="responsable" id="responsable" class="form-control" maxlength="100" autocomplete="off" tabindex="44">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Documento:</font></label>
                  <input type="text" name="documento" id="documento" class="form-control" autocomplete="off" tabindex="45">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha:</font></label>
                  <input type="text" name="fecha_docu" id="fecha_docu" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" autocomplete="off" tabindex="46">
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <label><font face="Verdana" size="2">Historial de Revistas</font></label>
                  <textarea name="revistas" id="revistas" class="form-control" rows="4" readonly="readonly"></textarea>
                </div>
              </div>
              <br>
              <center>
                <input type="button" name="aceptar" id="aceptar" value="Actualizar" tabindex="48">
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
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
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 230,
    width: 350,
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
        validacionData();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo2").dialog({
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
    buttons: [
      {
        text: "Ok",
        click: function() {
          $(this).dialog("close");
        }
      }
    ]
  });
  $("#dialogo3").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 250,
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
    buttons: {
      "Aceptar": function() {
        $(this).dialog("close");
        duplicar1();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
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
      $("#lnk4").show();
      $("#lnk5").hide();
    },
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").hide();
  $("#valor").maskMoney();
  trae_clasificaciones();
  trae_clasificaciones1();
  trae_clasificaciones2();
  trae_unidades();
  //trae_bienes(1);
  $("#conse").prop("disabled",true);
  $("#clasificacion").prop("disabled",true);
  $("#bien").prop("disabled",true);
  $("#codigo").prop("disabled",true);
  $("#descripcion").prop("disabled",true);
  $("#valor").prop("disabled",true);
  $("#fecha").prop("disabled",true);
  $("#marca").prop("disabled",true);
  $("#color").prop("disabled",true);
  $("#modelo").prop("disabled",true);
  $("#serial").prop("disabled",true);
  $("#soatn").prop("disabled",true);
  $("#soata").prop("disabled",true);
  $("#soat1").prop("disabled",true);
  $("#soat2").prop("disabled",true);
  $("#seguc").prop("disabled",true);
  $("#valos").prop("disabled",true);
  $("#segun").prop("disabled",true);
  $("#segua").prop("disabled",true);
  $("#segu1").prop("disabled",true);
  $("#segu2").prop("disabled",true);
  $("#unidades").prop("disabled",true);
  $("#funcionario").prop("disabled",true);
  $("#ordop").prop("disabled",true);
  $("#mision").prop("disabled",true);
  $("#estado").prop("disabled",true);
  $("#fecha").datepicker({
    dateFormat: "yy/mm/dd",
    changeYear: true,
    changeMonth: true
  });
  $("#soat1").datepicker({
    dateFormat: "yy/mm/dd",
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#soat2").prop("disabled",false);
      $("#soat2").datepicker("destroy");
      $("#soat2").val('');
      $("#soat2").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#soat1").val(),
        changeYear: true,
        changeMonth: true
      });
    },
  });
  $("#segu1").datepicker({
    dateFormat: "yy/mm/dd",
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#segu2").prop("disabled",false);
      $("#segu2").datepicker("destroy");
      $("#segu2").val('');
      $("#segu2").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#segu1").val(),
        changeYear: true,
        changeMonth: true
      });
    },
  });
  $("#valos").maskMoney();
  $("#filtro8").maskMoney();
  $("#filtro9").maskMoney();
  $("#img1").hide();
  $("#img2").hide();
  $("#lnk5").hide();
  $("#cantidad").focus(function(){
    this.select();
  });
  $("#cantidad").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#cantidad").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#valor").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#valor").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#filtro2").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
});
// Trae clasificaciones
function trae_clasificaciones()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_clasi.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      salida += "<option value='999'>- SELECCIONAR -</option>";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#paso").val(salida);
      $("#filtro3").append(salida);
    }
  });
}
function trae_clasificaciones1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_clasi.php",
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
      $("#clasificacion").append(salida);
    }
  });
}
function trae_clasificaciones2()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_bienes.php",
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
      $("#bien").append(salida);
    }
  });
}
// Trae los bienes filtrados
function car_bienes()
{
  var valor = $("#clasificacion").val();
  $("#bien").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_bienes2.php",
    data:
    {
      clase: valor
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
      $("#bien").append(salida);
    }
  });
}
// Trae unidades
function trae_unidades()
{
  $("#filtro1").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unid.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var salida1 = "";
      salida += "<option value='999'>- SELECCIONAR -</option>";
      for (var i in registros) 
      {
          var codigo = registros[i].codigo;
          var nombre = registros[i].nombre;
          salida += "<option value='"+codigo+"'>"+nombre+"</option>";
          salida1 += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#paso1").val(salida);
      $("#filtro2").append(salida);
      $("#unidades").append(salida1);
    }
  });
}
// Trae historico
function trae_historico()
{
  $("#filtro").val('');
  $("#filtro1").val('');
  $("#filtro2").val('999');
  $("#filtro3").val('0');
  $("#filtro4").val('');
  $("#filtro5").val('');
  $("#filtro6").val('');
  $("#filtro7").val('');
  if ($("#historico").is(":checked"))
  {
    trae_bienes(2);
  }
  else
  {
    trae_bienes(1);
  }
}
// Trae bienes
function trae_bienes(valor)
{
  var valor;
  var tipo = "0";
  var v_super = $("#v_super").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_bien2.php",
    data:
    {
      valor: valor,
      tipo: tipo,
      n_unidad: $("#n_unidad").val(),
      dependencia: $("#n_dependencia").val(),
      numero: $("#numero").val(),
      fecha1: $("#fecha1").val(),
      fecha2: $("#fecha2").val(),
      super: v_super
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
      $("#tabla9").html('');
      $("#resultados12").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      listareg = [];
      var v_var1 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='11%'><b>C&oacute;digo</b></td><td width='36%'><b>Descripci&oacute;n</b></td><td width='16%'><b>Clase</b></td><td width='8%'><b>Unidad</b></td><td width='10%'><b>Marca</b></td><td width='10%'><center><b>Valor</b></center></td><td width='3%'>&nbsp;</td><td width='3%'>&nbsp;</td><td width='3%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.conse+'\",\"'+value.codigo+'\"';
        var paso1 = '\"'+value.alea+'\",\"'+value.unidad1+'\",\"'+value.codigo+'\"';
        salida2 += "<tr><td height='35' width='11%' id='l1_"+index+"'>"+value.codigo+"</td>";
        salida2 += "<td height='35' width='36%' id='l2_"+index+"'>"+value.descripcion+"</td>";
        salida2 += "<td height='35' width='16%' id='l3_"+index+"'>"+value.n_clase+"</td>";
        salida2 += "<td height='35' width='8%' id='l4_"+index+"'>"+value.unidad1+"</td>";
        salida2 += "<td height='35' width='10%' id='l5_"+index+"'>"+value.marca+"</td>";
        salida2 += "<td height='35' width='10%' id='l6_"+index+"' align='right'>"+value.valor+"</td>";
        if ($("#historico").is(":checked"))
        {
          salida2 += "<td height='35' width='3%' id='l7_"+index+"'>&nbsp;</td>";
          salida2 += "<td height='35' width='3%' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); factura("+paso1+")'><img src='imagenes/pdf.png' width='24' height='24' border='0' title='Factura'></a></center></td>";
        }
        else
        {
          salida2 += "<td height='35' width='3%' id='l7_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); actu("+paso+");'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
          if (value.alea == "")
          {
            salida2 += "<td height='35' width='3%' id='l8_"+index+"'><center><img src='imagenes/blanco.png' width='24' height='24' border='0'></center></td>";
          }
          else
          {
            salida2 += "<td height='35' width='3%' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); factura("+paso1+")'><img src='imagenes/pdf.png' width='24' height='24' border='0' title='Factura'></a></center></td>";
          }
        }
        // Duplicar bien
        if (v_super != "0")
        {
          salida2 += "<td height='35' width='3%' id='l9_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); duplicar("+paso+")'><img src='imagenes/duplicar.png' width='24' height='24' border='0' title='Duplicar Bien'></a></center></td>";
        }
        else
        {
          salida2 += "<td height='35' width='3%' id='l9_"+index+"'>&nbsp;</td>";

        }
        salida2 += "</tr>";
        v_var1 += value.codigo+"|"+value.n_clase+"|"+value.nombre+"|"+value.descripcion+"|"+value.unidad1+"|"+value.marca+"|"+value.color+"|"+value.modelo+"|"+value.serial+"|"+value.valor1+"|"+value.fec_com+"|"+value.soa_num+"|"+value.soa_ase+"|"+value.soa_fe1+"|"+value.soa_fe2+"|"+value.seg_cla+"|"+value.seg_val+"|"+value.seg_num+"|"+value.seg_ase+"|"+value.seg_fe1+"|"+value.seg_fe2+"|"+value.funcionario+"|"+value.ordop+"|"+value.mision+"|"+value.ordop1+"|"+value.mision1+"|"+value.numero+"|"+value.relacion+"|"+value.compania+"|"+value.estado1+"|"+value.egreso+"|"+value.unidad+"|"+value.unidad1+"|"+value.devolutivo+"|"+value.nom_respon+"|"+value.doc_respon+"|"+value.fec_respon+"|"+value.sap+"|"+value.alta+"|"+value.fechaa+"|"+value.almacen+"|"+value.fechas+"|"+value.siniestro+"|"+value.informe+"|"+value.fechai+"|"+value.acto+"|"+value.fechac+"|"+value.observa+"|"+value.acto1+"|"+value.fechac1+"|"+value.informe1+"|"+value.fechai1+"|"+value.observa1+"|"+value.nom_usua+"|"+value.doc_usua+"|"+value.fec_usua+"|"+value.fec_rela+"|"+value.acto2+"|"+value.fechat+"|"+value.observa2+"|"+value.revistas+"|"+value.usu_regi+"|"+value.fec_regi+"|#";
        listareg.push(index);
      });
      salida2 += "</table>";
      $("#paso_excel").val(v_var1);
      $("#tabla9").append(salida1);
      $("#resultados12").append(salida2);
      valida1 = parseInt(valida1);
      if (valida1 == "0")
      {
        $("#lnk4").show();
        $("#lnk5").hide();
      }
      else
      {
        $("#lnk4").hide();
        $("#lnk5").show();
      }
    }
  });
}
function trae_bienes1()
{
  if ($("#historico").is(":checked"))
  {
    var valor = "2";
  }
  else
  {
    var valor = "1";
  }
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_bien2.php",
    data:
    {
      valor: valor,
      tipo: tipo,
      n_unidad: $("#n_unidad").val(),
      dependencia: $("#n_dependencia").val(),
      numero: $("#numero").val(),
      codigo: $("#filtro").val(),
      descripcion: $("#filtro1").val(),
      unidad: $("#filtro2").val(),
      clase: $("#filtro3").val(),
      marca: $("#filtro4").val(),
      color: $("#filtro5").val(),
      modelo: $("#filtro6").val(),
      serial: $("#filtro7").val(),
      valor1: $("#filtro8_1").val(),
      valor2: $("#filtro9_1").val(),
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
      $("#tabla9").html('');
      $("#resultados12").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      listareg = [];
      var v_var1 = "";
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='11%'><b>C&oacute;digo</b></td><td width='36%'><b>Descripci&oacute;n</b></td><td width='16%'><b>Clase</b></td><td width='8%'><b>Unidad</b></td><td width='10%'><b>Marca</b></td><td width='10%'><center><b>Valor</b></center></td><td width='3%'>&nbsp;</td><td width='3%'>&nbsp;</td><td width='3%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      $.each(registros.rows, function (index, value)
      {
        var paso = '\"'+value.conse+'\",\"'+value.codigo+'\"';
        var paso1 = '\"'+value.alea+'\",\"'+value.unidad1+'\",\"'+value.codigo+'\"';
        salida2 += "<tr><td height='35' width='11%' id='l1_"+index+"'>"+value.codigo+"</td>";
        salida2 += "<td height='35' width='36%' id='l2_"+index+"'>"+value.descripcion+"</td>";
        salida2 += "<td height='35' width='16%' id='l3_"+index+"'>"+value.n_clase+"</td>";
        salida2 += "<td height='35' width='8%' id='l4_"+index+"'>"+value.unidad1+"</td>";
        salida2 += "<td height='35' width='10%' id='l5_"+index+"'>"+value.marca+"</td>";
        salida2 += "<td height='35' width='10%' id='l6_"+index+"' align='right'>"+value.valor+"</td>";
        if ($("#historico").is(":checked"))
        {
          salida2 += "<td height='35' width='3%' id='l7_"+index+"'>&nbsp;</td>";
          salida2 += "<td height='35' width='3%' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); factura("+paso1+")'><img src='imagenes/pdf.png' width='24' height='24' border='0' title='Factura'></a></center></td>";
        }
        else
        {
          salida2 += "<td height='35' width='3%' id='l7_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); actu("+paso+");'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
          if (value.alea == "")
          {
            salida2 += "<td height='35' width='3%' id='l8_"+index+"'><center><img src='imagenes/blanco.png' width='24' height='24' border='0'></center></td>";
          }
          else
          {
            salida2 += "<td height='35' width='3%' id='l8_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); factura("+paso1+")'><img src='imagenes/pdf.png' width='24' height='24' border='0' title='Factura'></a></center></td>";
          }
        }
        // Duplicar bien
        if (v_super != "0")
        {
          salida2 += "<td height='35' width='3%' id='l9_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); duplicar("+paso+")'><img src='imagenes/duplicar.png' width='24' height='24' border='0' title='Duplicar Bien'></a></center></td>";
        }
        else
        {
          salida2 += "<td height='35' width='3%' id='l9_"+index+"'>&nbsp;</td>";

        }
        salida2 += "</tr>";
        v_var1 += value.codigo+"|"+value.n_clase+"|"+value.nombre+"|"+value.descripcion+"|"+value.unidad1+"|"+value.marca+"|"+value.color+"|"+value.modelo+"|"+value.serial+"|"+value.valor1+"|"+value.fec_com+"|"+value.soa_num+"|"+value.soa_ase+"|"+value.soa_fe1+"|"+value.soa_fe2+"|"+value.seg_cla+"|"+value.seg_val+"|"+value.seg_num+"|"+value.seg_ase+"|"+value.seg_fe1+"|"+value.seg_fe2+"|"+value.funcionario+"|"+value.ordop+"|"+value.mision+"|"+value.ordop1+"|"+value.mision1+"|"+value.numero+"|"+value.relacion+"|"+value.compania+"|"+value.estado1+"|"+value.egreso+"|"+value.unidad+"|"+value.unidad1+"|"+value.devolutivo+"|"+value.nom_respon+"|"+value.doc_respon+"|"+value.fec_respon+"|"+value.sap+"|"+value.alta+"|"+value.fechaa+"|"+value.almacen+"|"+value.fechas+"|"+value.siniestro+"|"+value.informe+"|"+value.fechai+"|"+value.acto+"|"+value.fechac+"|"+value.observa+"|"+value.acto1+"|"+value.fechac1+"|"+value.informe1+"|"+value.fechai1+"|"+value.observa1+"|"+value.nom_usua+"|"+value.doc_usua+"|"+value.fec_usua+"|"+value.fec_rela+"|"+value.acto2+"|"+value.fechat+"|"+value.observa2+"|"+value.revistas+"|"+value.usu_regi+"|"+value.fec_regi+"|#";
        listareg.push(index);
      });
      salida2 += "</table>";
      $("#paso_excel").val(v_var1);
      $("#tabla9").append(salida1);
      $("#resultados12").append(salida2);
      valida1 = parseInt(valida1);
      if (valida1 == "0")
      {
        $("#lnk4").show();
      	$("#lnk5").hide();
      }
      else
      {
        $("#lnk4").hide();
      	$("#lnk5").show();
      }
    }
  });
}
function paso_val()
{
  var valor;
  valor = $("#filtro8").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#filtro8_1").val(valor);
}
function paso_val1()
{
  var valor = $("#filtro9").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#filtro9_1").val(valor);
  trae_bienes1();
}
function paso_val2()
{
  var valor = $("#valos").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valot").val(valor);
}
function paso_val3()
{
  var valor = $("#valot").val();
  valor = parseFloat(valor);
  valor = valor.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#valos").val(valor);
}
function paso_val4()
{
  var valor = $("#valor").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valor1").val(valor);
}
function valida2()
{
  var valor = $("#valor").val();
  var valor1 = parseFloat(valor.replace(/,/g,''));
  var valor2 = $("#valot").val();
  var valor3 = valor1-valor2;
  if (valor3 < 0)
  {
    $("#valos").val('0.00');
    paso_val2(valor);
  }
}
function actu(valor, valor1)
{
  var valor, valor1;
  $("#conse").val(valor);
  $("#codigo").val(valor1);
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "bien_consu.php",
    data:
    {
      conse: $("#conse").val(),
      codigo: $("#codigo").val()
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
      $("#soportes").accordion({active: 1});
      $("#clasificacion").val(registros.clase1);
      $("#clasificacion").prop("disabled",false);
      $("#bien").val(registros.clase);
      $("#bien").prop("disabled",false);
      $("#descripcion").val(registros.descripcion);
      $("#descripcion").prop("disabled",false);
      $("#valor").val(registros.valor);
      $("#fecha").val('');
      if (registros.fec_com == "1900-01-01")
      {
      }
  	  else
  	  {	
      	$("#fecha").val(registros.fec_com);
      }
      $("#fecha").prop("disabled",false);
      $("#marca").val(registros.marca);
      $("#marca").prop("disabled",false);
      $("#color").val(registros.color);
      $("#color").prop("disabled",false);
      $("#modelo").val(registros.modelo);
      $("#modelo").prop("disabled",false);
      $("#serial").val(registros.serial);
      $("#serial").prop("disabled",false);
      $("#soatn").val(registros.soatn);
      $("#soatn").prop("disabled",false);
      $("#soata").val(registros.soata);
      $("#soata").prop("disabled",false);
      $("#soat1").val('');
      if (registros.soat1 == "1900-01-01")
      {
      }
  	  else
  	  {	
      	$("#soat1").val(registros.soat1);
      }
      $("#soat1").prop("disabled",false);
      $("#soat2").val('');
      if (registros.soat2 == "1900-01-01")
      {
      }
  	  else
  	  {	
      	$("#soat2").val(registros.soat2);
      }
      $("#soat2").prop("disabled",false);
      $("#seguc").val(registros.seguc);
      $("#valot").val(registros.seguv);
      paso_val3();
      $("#seguc").prop("disabled",false);
      $("#valos").prop("disabled",false);
      $("#segun").val(registros.segun);
      $("#segun").prop("disabled",false);
      $("#segua").val(registros.segua);
      $("#segua").prop("disabled",false);
      $("#segu1").val('');
      if (registros.segu1 == "1900-01-01")
      {
      }
  	  else
  	  {	
      	$("#segu1").val(registros.segu1);
      }
      $("#segu1").prop("disabled",false);
      $("#segu2").val('');
      if (registros.segu2 == "1900-01-01")
      {
      }
  	  else
  	  {	
      	$("#segu2").val(registros.segu2);
      }
      $("#segu2").prop("disabled",false);
      $("#unidades").val(registros.unidad);
      $("#unidades").prop("disabled",true);
      $("#funcionario").val(registros.funcionario);
      $("#funcionario").prop("disabled",false);
      $("#ordop").val(registros.ordop);
      $("#ordop").prop("disabled",true);
      $("#mision").val(registros.mision);
      $("#mision").prop("disabled",true);
      $("#compania").val(registros.compania);
      $("#compania").prop("disabled",true);
      $("#estado").val(registros.estado);
      $("#estado").prop("disabled",true);
      $("#estado1").val(registros.n_estado);
      $("#estado1").prop("disabled",false);
      $("#plan").val(registros.plan);
      $("#plan").prop("disabled",true);
      $("#egreso").val(registros.egreso);
      $("#egreso").prop("disabled",true);
      $("#responsable").val(registros.responsable);
      $("#responsable").prop("disabled",true);
      $("#documento").val(registros.documento);
      $("#documento").prop("disabled",true);
      $("#fecha_docu").val(registros.fecha_docu);
      $("#fecha_docu").prop("disabled",true);
      $("#alea").val(registros.repositorio);
      $("#alea").prop("disabled",true);
      $("#revistas").val('');
      var revista = registros.revistas;
      var text = String.fromCharCode(13);
      var var_ocu = revista.split('<br>');
      var var_ocu1 = var_ocu.length;
      for (var i=0; i<var_ocu1; i++)
      {
        revista = revista.replace("<br>", text);
      }
      $("#revistas").val(revista);
      $("#descripcion").focus();
      $("#aceptar").show();
      $("#img1").show();
    }
  });
}
function actu1()
{
	$("#img1").hide();
	$("#img2").show();
	$("#valor").prop("disabled",false);
	$("#valor").focus();
  $("#aceptar").hide();
}
function actu2()
{
	var conse = $("#conse").val();
	var codigo = $("#codigo").val();
	var valor = $("#valor").val();
	var valor1 = $("#valor1").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "bien_grab3.php",
    data:
    {
      conse: conse,
      codigo: codigo,
      valor: valor,
      valor1: valor1
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
      	$("#img2").hide();
      	$("#valor").prop("disabled",true);
      }
    }
  });
}
function factura(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "bien_consu1.php",
    data:
    {
      alea: valor,
      unidad: valor1
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var archivo = registros.archivo;
      if (archivo === null)
      {
        var detalle = "<center><h3>Factura No Encontrada o No Cargada</h3></center>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
        $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
      else
      {
        var url = "<a href='./ver_factura.php?alea="+valor+"&sigla="+valor1+"&codigo="+valor2+"' name='lnk1' id='lnk1' class='pantalla-modal'></a>";
        $("#vinculo").html('');
        $("#vinculo").append(url);
        $(".pantalla-modal").magnificPopup({
          type: 'iframe',
          preloader: false,
          modal: false
        });
        $("#lnk1").click();
      }
    }
  });
}
function duplicar(valor, valor1)
{
  var valor, valor1;
  $("#placa").val(valor1);
  $("#mensaje").html('');
  var detalle = "<center><h3>Esta seguro de duplicar el bien "+valor1+" ?</h3></center>";
  $("#mensaje").html(detalle);
  $("#dialogo3").dialog("open");
  $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function duplicar1()
{
  var cantidad = $("#cantidad").val();
  var placa = $("#placa").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "bien_grab4.php",
    data:
    {
      placa: placa,
      cantidad: cantidad
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var confirma = registros.confirma;
      if (confirma == "1")
      {
        alerta2("El código "+placa+" ha sido duplicado correctamente "+cantidad+" veces");
        $("#cantidad").val('0');
      }
      else
      {
        alerta("Error durante la grabación");
      }
    }
  });
}
function subir()
{
  var alea = $("#alea").val();
  var sigla = $("#unidades option:selected").html();
  sigla = sigla.trim();
  var url = "<a href='./subir7.php?alea="+alea+"&sigla="+sigla+"' name='lnk3' id='lnk3' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnk3").click();
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function validacionData()
{
  var salida = true, detalle = '';
  if ($("#descripcion").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar la Descripci&oacute;n del Bien<br><br>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
  }
  else
  {
    nuevo();
  }
}
function nuevo()
{
  var descripcion = $("#descripcion").val();
  descripcion = descripcion.replace(/[•]+/g, "*");
  descripcion = descripcion.replace(/[é́]+/g, "é");
  descripcion = descripcion.replace(/[]+/g, "*");
  descripcion = descripcion.replace(/[ ]+/g, " ");
  descripcion = descripcion.replace(/[–]+/g, "-");
  descripcion = descripcion.replace(/[—]/g, '-');
  descripcion = descripcion.replace(/[…]+/g, "..."); 
  descripcion = descripcion.replace(/[“”]/g, '"');
  descripcion = descripcion.replace(/[‘]/g, '"');
  descripcion = descripcion.replace(/[’]/g, '"');
  $("#descripcion").val()
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "bien_grab1.php",
    data:
    {
      conse: $("#conse").val(),
      clasificacion: $("#clasificacion").val(),
      bien: $("#bien").val(),
      bien1: $("#bien option:selected").html(),
      codigo: $("#codigo").val(),
      descripcion: descripcion,
      fecha: $("#fecha").val(),
      marca: $("#marca").val(),
      color: $("#color").val(),
      modelo: $("#modelo").val(),
      serial: $("#serial").val(),
      soatn: $("#soatn").val(),
      soata: $("#soata").val(),
      soat1: $("#soat1").val(),
      soat2: $("#soat2").val(),
      seguc: $("#seguc").val(),
      valos: $("#valos").val(),
      valot: $("#valot").val(),
      segun: $("#segun").val(),
      segua: $("#segua").val(),
      segu1: $("#segu1").val(),
      segu2: $("#segu2").val(),
      unidades: $("#unidades").val(),
      funcionario: $("#funcionario").val(),
      ordop: $("#ordop").val(),
      mision: $("#mision").val(),
      estado: $("#estado1").val()
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
        $("#clasificacion").prop("disabled",true);
        $("#bien").prop("disabled",true);
    		$("#descripcion").prop("disabled",true);
    		$("#fecha").prop("disabled",true);
    		$("#marca").prop("disabled",true);
    		$("#color").prop("disabled",true);
    		$("#modelo").prop("disabled",true);
    		$("#serial").prop("disabled",true);
    		$("#soatn").prop("disabled",true);
    		$("#soata").prop("disabled",true);
    		$("#soat1").prop("disabled",true);
    		$("#soat2").prop("disabled",true);
    		$("#seguc").prop("disabled",true);
    		$("#valos").prop("disabled",true);
    		$("#segun").prop("disabled",true);
    		$("#segua").prop("disabled",true);
    		$("#segu1").prop("disabled",true);
    		$("#segu2").prop("disabled",true);
    		$("#unidades").prop("disabled",true);
    		$("#funcionario").prop("disabled",true);
    		$("#ordop").prop("disabled",true);
    		$("#mision").prop("disabled",true);
        $("#estado1").prop("disabled",true);
    		$("#aceptar").hide();
        trae_bienes(1);
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
      }
    }
  });
}
function excel()
{
  var fecha1 = $("#fecha1").val();
  var fecha2 = $("#fecha2").val();
  if (fecha1 == "")
  {
    $("#lnk4").hide();
    $("#lnk5").show();
    $("#lnk5").click();
  }
  else
  {
    if ($("#historico").is(":checked"))
    {
      trae_bienes(2);
    }
    else
    {
      trae_bienes(1);
    }
    $("#lnk4").hide();
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
function excel1()
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
// 08/02/2024 - Ajuste ventana confirmacion de actualizacion
// 26/06/2024 - Ajuste presentación consulta de bienes 
// 06/08/2024 - Ajuste bloqueo pegado en campo valor
// 25/09/2024 - Ajuste busqueda de filtros cambio de keuyp por onblur
// 02/10/2024 - Ajuste doble consulta al inicio
// 28/11/2024 - Ajuste duplicar bienes
// 05/02/2025 - Ajuste retiro consulta inicial
// 10/02/2025 - Ajuste inclusion campo usuario y fecha registro de movimiento
// 22/04/2025 - Ajuste buscador campo unidad
?>