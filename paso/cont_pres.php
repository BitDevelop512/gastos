<!doctype html>
<?php
session_start();
error_reporting(0);
$_SESSION["chat"] = "NO";
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('conf.php');
  include('permisos.php');
  $vigencia = date('Y');
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
        <div id="tabs">
          <ul>
            <li><a href="#tabs-1">Apropiaci&oacute;n Inicial</a></li>
              <li><a href="#tabs-2">CDP</a></li>
              <li><a href="#tabs-3">CRP</a></li>
          </ul>
          <div id="tabs-1">
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Vigencia</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="hidden" name="vige" id="vige" class="form-control" value="<?php echo $vigencia; ?>" readonly="readonly">
                  <select name="ano" id="ano" class="form-control select2"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Tipo</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <select name="tipo" id="tipo" class="form-control select2">
                    <option value="A">ADICION</option>
                    <option value="R">REDUCCION</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Total Apropiaci&oacute;n</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="total" id="total" class="form-control numero" value="0.00" readonly="readonly">
                  <input type="hidden" name="total1" id="total1" class="form-control" value="0" readonly="readonly">
                </div>
                <div id="vinculo"></div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Valor Apropiaci&oacute;n Inicial</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="valor" id="valor" class="form-control numero" value="0.00" onkeyup="paso_val();" autocomplete="off">
                  <input type="hidden" name="valor1" id="valor1" class="form-control" value="0">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Valor</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="valor2" id="valor2" class="form-control numero" value="0.00" onkeyup="paso_val1();" autocomplete="off">
                  <input type="hidden" name="valor3" id="valor3" class="form-control" value="0">
                  <select name="ano1" id="ano1" class="form-control select2"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Saldo Apropiaci&oacute;n</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="total2" id="total2" class="form-control numero" value="0.00" readonly="readonly">
                  <input type="hidden" name="total3" id="total3" class="form-control" value="0" readonly="readonly">
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Fecha</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="fecha0" id="fecha0" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Fecha</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Recurso</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <select name="recurso0" id="recurso0" class="form-control select2" onchange="trae_saldo_vigencia();">
                    <option value="1">10 CSF</option>
                    <option value="2">50 SSF</option>
                    <option value="3">16 SSF</option>
                    <option value="4">OTROS</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Recurso</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <select name="recurso2" id="recurso2" class="form-control select2">
                    <option value="1">10 CSF</option>
                    <option value="2">50 SSF</option>
                    <option value="3">16 SSF</option>
                    <option value="4">OTROS</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Rubro</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <select name="rubro0" id="rubro0" class="form-control select2">
                    <option value="3">A-02-02-04</option>
                    <option value="1">204-20-1</option>
                    <option value="2">204-20-2</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><div class="centrado"><font face="Verdana" size="2">Rubro</font></div></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <select name="rubro2" id="rubro2" class="form-control select2">
                    <option value="3">A-02-02-04</option>
                    <option value="1">204-20-1</option>
                    <option value="2">204-20-2</option>
                  </select>
                </div>
              </div>
              <div class="espacio1"></div>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><div style='padding-left: 7px;'><font face="Verdana" size="2">Destinaci&oacute;n</font></div></label>
                  <input type="text" name="destinacion0" id="destinacion0" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <center>
                    <input type="button" name="aceptar" id="aceptar" value="Registrar">
                  </center>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <center>
                    <input type="button" name="aceptar1" id="aceptar1" value="Grabar">
                  </center>
                </div>
              </div>
            </form>
            <br>
            <div id="res_apro"></div>
            <div id="dialogo"></div>
            <div id="dialogo1"></div>
            <div id="dialogo2"></div>
          </div>
<!--
CDP
-->
          <div id="tabs-2">
            <form name="formu1" method="post">
              <div class="row">
                <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Apropiaci&oacute;n Vigente</font></label>
                  <input type="text" name="val_apr" id="val_apr" class="form-control numero" value="0.00" readonly="readonly">
                  <input type="hidden" name="var_apr" id="var_apr" class="form-control numero" readonly="readonly">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Disponible Recurso</font></label>
                  <input type="text" name="dis_rec" id="dis_rec" class="form-control numero" value="0.00" readonly="readonly">
                  <input type="hidden" name="dis_rec1" id="dis_rec1" class="form-control numero" readonly="readonly">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Vigencia</font></label>
                  <select name="ano2" id="ano2" class="form-control select2" tabindex="1"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">N&uacute;mero</font></label>
                  <input type="text" name="numero" id="numero" class="form-control numero" value="0" onblur="valida_cdp();" autocomplete="off" tabindex="2">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha" id="fecha" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" autocomplete="off" tabindex="3">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Origen</font></label>
                  <select name="origen" id="origen" class="form-control select2" tabindex="4">
                    <option value="1">MDN</option>
                    <option value="2">DTN</option>
                    <option value="3">Ejercito</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Recurso</font></label>
                  <select name="recurso" id="recurso" class="form-control select2" onchange="trae_saldo_recurso1();" tabindex="5">
                    <option value="1">10 CSF</option>
                    <option value="2">50 SSF</option>
                    <option value="3">16 SSF</option>
                    <option value="4">OTROS</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Rubro</font></label>
                  <select name="rubro" id="rubro" class="form-control select2" tabindex="6">
                    <option value="3">A-02-02-04</option>
                    <option value="1">204-20-1</option>
                    <option value="2">204-20-2</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Concepto</font></label>
                  <select name="concepto" id="concepto" class="form-control select2" tabindex="7">
                    <option value="3">GASTOS RESERVADOS</option>
                    <option value="1">GASTOS RESERVADOS BIENES</option>
                    <option value="2">GASTOS RESERVADOS SERVICIOS</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor</font></label>
                  <input type="text" name="val_cdp" id="val_cdp" class="form-control numero" value="0.00" onkeyup="paso_val2();" onchange="valida_rec();" tabindex="8">
                  <input type="hidden" name="var_cdp" id="var_cdp" class="form-control numero" value="0" tabindex="9" readonly="readonly">
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Destinaci&oacute;n</font></label>
                  <input type="text" name="destinacion" id="destinacion" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" tabindex="10">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <center>
                    <input type="button" name="nuevo" id="nuevo" value="Nuevo" tabindex="11">
                    <input type="button" name="aceptar2" id="aceptar2" value="Grabar" tabindex="12">
                    &nbsp;&nbsp;&nbsp;
                    <input type="button" name="cancelar" id="cancelar" value="Cancelar" tabindex="13">
                  </center>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Tipo</font></label>
                  <select name="tipo2" id="tipo2" class="form-control select2">
                    <option value="A">ADICION</option>
                    <option value="R">REDUCCION</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha4" id="fecha4" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor</font></label>
                  <input type="text" name="valor6" id="valor6" class="form-control numero" value="0.00" onkeyup="paso_val5();" autocomplete="off">
                  <input type="hidden" name="valor7" id="valor7" class="form-control numero" value="0">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">CDP</font></label>
                  <select name="cdp2" id="cdp2" class="form-control select2" onchange="trae_saldo_cdp2();"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Saldo CDP</font></label>
                  <input type="text" name="valor8" id="valor8" class="form-control numero" value="0.00" readonly="readonly">
                  <input type="hidden" name="valor9" id="valor9" class="form-control numero" value="0" readonly="readonly">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <center>
                    <input type="button" name="aceptar5" id="aceptar5" value="Grabar">
                  </center>
                </div>
              </div>
            </form>
            <form name="formu_excel" id="formu_excel" action="cdps_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
            </form>
            <br>
            <hr>
            <br>
            <div class="row">
	            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
	            	<label><font face="Verdana" size="2">Filtro:</font></label>
		           	<select name="filtro1" id="filtro1" class="form-control select2" onchange="consulta1();"></select>
		          </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
								<label><font face="Verdana" size="2">Recurso</font></label>
                <select name="filtro3" id="filtro3" class="form-control select2" onchange="consulta1();">
                  <option value="1">10 CSF</option>
                  <option value="2">50 SSF</option>
                  <option value="3">16 SSF</option>
                  <option value="4">OTROS</option>
                </select>
              </div>
              <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7"></div>
              <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
								<br>
                <a href="#" onclick="excel(); return false;">
                  <img src="dist/img/excel.png" name='lnk1' id='lnk1' title="Exportar CDP a Excel - SAP">
                </a>
              </div>
						</div>
            <br>
            <br>
            <div id="res_cdps"></div>
            <div id="dialogo3"></div>
          </div>
<!--
CRP
-->
          <div id="tabs-3">
            <form name="formu2" method="post">
              <div class="row">
                <div class="col col-lg-10 col-sm-10 col-md-10 col-xs-10"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Saldo por Comprometer</font></label>
                  <input type="text" name="val_cdp1" id="val_cdp1" class="form-control numero" value="0.00" readonly="readonly">
                  <input type="hidden" name="var_cdp1" id="var_cdp1" class="form-control numero" readonly="readonly">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">CDP</font></label>
                  <select name="cdp1" id="cdp1" class="form-control select2" tabindex="1"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">N&uacute;mero</font></label>
                  <input type="text" name="numero1" id="numero1" class="form-control numero" value="0" onblur="valida_crp();" autocomplete="off" tabindex="2">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" autocomplete="off" tabindex="3">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Origen</font></label>
                  <select name="origen1" id="origen1" class="form-control select2" tabindex="4">
                    <option value="1">MDN</option>
                    <option value="2">DTN</option>
                    <option value="3">Ejercito</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Recurso</font></label>
                    <select name="recurso1" id="recurso1" class="form-control select2" tabindex="5">
                      <option value="1">10 CSF</option>
                      <option value="2">50 SSF</option>
                      <option value="3">16 SSF</option>
                      <option value="4">OTROS</option>
                    </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Rubro</font></label>
                    <select name="rubro1" id="rubro1" class="form-control select2" tabindex="6">
                      <option value="3">A-02-02-04</option>
                      <option value="1">204-20-1</option>
                      <option value="2">204-20-2</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor</font></label>
                  <input type="text" name="val_crp" id="val_crp" class="form-control numero" value="0.00" onkeyup="paso_val3();" onchange="compara1();" tabindex="7">
                  <input type="hidden" name="var_crp" id="var_crp" class="form-control numero" value="0" tabindex="8" readonly="readonly">
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Destinaci&oacute;n</font></label>
                  <input type="text" name="destinacion1" id="destinacion1" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" tabindex="9">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <center>
                    <input type="button" name="nuevo1" id="nuevo1" value="Nuevo" tabindex="10">
                    <input type="button" name="aceptar3" id="aceptar3" value="Grabar" tabindex="11">
                    &nbsp;&nbsp;&nbsp;
                    <input type="button" name="cancelar1" id="cancelar1" value="Cancelar" tabindex="12">
                  </center>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Tipo</font></label>
                  <select name="tipo1" id="tipo1" class="form-control select2">
                    <option value="A">ADICION</option>
                    <option value="R">REDUCCION</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha3" id="fecha3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor</font></label>
                  <input type="text" name="valor4" id="valor4" class="form-control numero" value="0.00" onkeyup="paso_val4();" autocomplete="off">
                  <input type="hidden" name="valor5" id="valor5" class="form-control numero" value="0">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">CRP</font></label>
                  <select name="crp1" id="crp1" class="form-control select2" onchange="trae_saldo_crp2();"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Saldo CRP</font></label>
                  <input type="text" name="valor10" id="valor10" class="form-control numero" value="0.00" readonly="readonly">
                  <input type="hidden" name="valor11" id="valor11" class="form-control numero" value="0" readonly="readonly">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <center>
                    <input type="button" name="aceptar4" id="aceptar4" value="Grabar">
                  </center>
                </div>
              </div>
            </form>
            <form name="formu_excel1" id="formu_excel1" action="crps_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel1" id="paso_excel1" class="form-control" readonly="readonly">
            </form>
            <br>
            <hr>
            <br>
            <div class="row">
	            <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
	            	<label><font face="Verdana" size="2">Filtro:</font></label>
	            	<select name="filtro2" id="filtro2" class="form-control select2" onchange="consulta2();"></select>
		          </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
								<label><font face="Verdana" size="2">Recurso</font></label>
                <select name="filtro4" id="filtro4" class="form-control select2" onchange="consulta2();">
                  <option value="1">10 CSF</option>
                  <option value="2">50 SSF</option>
                  <option value="3">16 SSF</option>
                  <option value="4">OTROS</option>
                </select>
              </div>
              <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7"></div>
              <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
								<br>
                <a href="#" onclick="excel1(); return false;">
                  <img src="dist/img/excel.png" name='lnk2' id='lnk2' title="Exportar CRP a Excel - SAP">
                </a>
              </div>
						</div>
            <br>
            <br>
            <div id="res_crps"></div>
            <div id="dialogo4"></div>
            <div id="dialogo5"></div>
            <div id="dialogo6"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="js/jquery.quicksearch.js?1.0.0" type="text/javascript"></script>
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
    height: 270,
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
        valida();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo2").dialog({
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
        graba1();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo3").dialog({
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
        graba2();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo4").dialog({
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
        graba3();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo5").dialog({
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
        graba4();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo6").dialog({
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
        graba5();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#fecha0").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
  });
  $("#fecha").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
  });
  $("#fecha1").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
  });
  $("#fecha2").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
  });
  $("#fecha3").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
  });
  $("#fecha4").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
  });
  trae_vigencias();
  trae_cdps();
  trae_crps();
  $("#tabs").tabs();
  $("#ano").prop("disabled",true);
  $("#concepto").prop("disabled",true);
  $("#valor").maskMoney();
  $("#valor2").maskMoney();
  $("#val_cdp").maskMoney();
  $("#val_crp").maskMoney();
  $("#valor4").maskMoney();
  $("#valor6").maskMoney();
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta1);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(pregunta2);
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#nuevo").button();
  $("#nuevo").click(nuevo);
  $("#nuevo").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#cancelar").button();
  $("#cancelar").click(cancela);
  $("#cancelar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").button();
  $("#aceptar3").click(pregunta3);
  $("#aceptar3").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#nuevo1").button();
  $("#nuevo1").click(nuevo1);
  $("#nuevo1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#cancelar1").button();
  $("#cancelar1").click(cancela1);
  $("#cancelar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar4").button();
  $("#aceptar4").click(pregunta4);
  $("#aceptar4").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar5").button();
  $("#aceptar5").click(pregunta5);
  $("#aceptar5").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  consulta();
  apaga1();
  apaga2();
  $("#aceptar2").hide();
  $("#cancelar").hide();
  $("#ano2").change(busca);
  $("#aceptar3").hide();
  $("#cancelar1").hide();
  $("#cdp1").change(busca1);
  $("#ano1").hide();
  $("#rubro").change(val_rubro);
  trae_ano();
  var vigencia = $("#vige").val();
  $("#ano").val(vigencia);
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
      $("#filtro1").append(salida);
      $("#filtro2").append(salida);
      consulta1();
      consulta2();
      trae_saldo_vigencia();
      trae_saldo_cdp2();
      trae_saldo_crp2();
    }
  });
}
function paso_val()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('valor').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#valor1").val(valor1);
}
function paso_val1()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('valor2').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#valor3").val(valor1);
}
function paso_val2()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('val_cdp').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#var_cdp").val(valor1);
}
function paso_val3()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('val_crp').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#var_crp").val(valor1);
}
function paso_val4()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('valor4').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#valor5").val(valor1);
}
function paso_val5()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('valor6').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#valor7").val(valor1);
}
function val_rubro()
{
  var valida;
  valida = $("#rubro").val();
  $("#concepto").val(valida);
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta1()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo2").html(detalle);
  $("#dialogo2").dialog("open");
  $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta2()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo3").html(detalle);
  $("#dialogo3").dialog("open");
  $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta3()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo4").html(detalle);
  $("#dialogo4").dialog("open");
  $("#dialogo4").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta4()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo5").html(detalle);
  $("#dialogo5").dialog("open");
  $("#dialogo5").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta5()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo6").html(detalle);
  $("#dialogo6").dialog("open");
  $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function valida()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "apro_vali.php",
    data:
    {
      ano: $("#ano").val(),
      recurso: $("#recurso0").val()
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
      if (valida == "0")
      {
        graba();
      }
      else
      {
        var detalle = "<center><h3>Apropiaci&oacute;n ya registrada para la Vigencia</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function graba()
{
  var salida = true, detalle = '';
  if ($("#valor").val() == '0.00')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar un Valor Inicial</h3></center>";
  }
  var val_valor = $("#valor").val();
  val_valor = val_valor.trim();
  var var_ocu = val_valor.split('.');
  var var_ocu1 = var_ocu.length;
  if (var_ocu1 > 2)
  {
    salida = false;
    detalle += "<center><h3>Debe revisar el Valor Inicial</h3></center>";
  }
  if ($("#fecha0").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar la Fecha</h3></center>";
  }
  if ($("#destinacion0").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Destinación</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "apro_grab.php",
      data:
      {
        valor: $("#valor").val(),
        valor1: $("#valor1").val(),
        ano: $("#ano").val(),
        fecha: $("#fecha0").val(),
        rubro: $("#rubro0").val(),
        recurso: $("#recurso0").val(),
        rubro1: $("#rubro0 option:selected").html(),
        recurso1: $("#recurso0 option:selected").html(),
        destinacion: $("#destinacion0").val()
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
        var valida, valida1, detalle;
        valida = registros.salida;
        if (valida > 0)
        {
          $("#aceptar").hide();
          $("#valor").prop("disabled",true);
          $("#ano").prop("disabled",true);
          $("#fecha0").prop("disabled",true);
          $("#rubro0").prop("disabled",true);
          $("#recurso0").prop("disabled",true);
          $("#destinacion0").prop("disabled",true);
          trae_vigencias();
          consulta();
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#aceptar").show();
        }
      }
    });
  }
}
function graba1()
{
  var salida = true, detalle = '';
  if (($("#valor2").val() == '0.00') || ($("#valor2").val() == ''))
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Valor de Adición / Reducción</h3></center>";
  }
  var val_valor = $("#valor2").val();
  val_valor = val_valor.trim();
  var var_ocu = val_valor.split('.');
  var var_ocu1 = var_ocu.length;
  if (var_ocu1 > 2)
  {
    salida = false;
    detalle += "<center><h3>Debe revisar el Valor de Adición / Reducción</h3></center>";
  }
  if ($("#fecha2").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar la Fecha</h3></center>";
  }
  var valida = $("#tipo").val();
  if (valida == "R")
  {
    var v_valor = $("#valor3").val();
    v_valor = parseFloat(v_valor);
    var v_saldo = $("#total3").val();
    v_saldo = parseFloat(v_saldo);
    if (v_valor > v_saldo)
    {
      salida = false;
      detalle += "<center><h3>Valor de Reducción No Permitido</h3></center>";
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
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "apro_actu.php",
      data:
      {
        tipo: $("#tipo").val(),
        valor: $("#valor2").val(),
        valor1: $("#valor3").val(),
        ano: $("#ano1").val(),
        fecha: $("#fecha2").val(),
        rubro: $("#rubro2").val(),
        recurso: $("#recurso2").val(),
        rubro1: $("#rubro2 option:selected").html(),
        recurso1: $("#recurso2 option:selected").html()
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
        var valida, valida1, detalle;
        valida = registros.salida;
        if (valida > 0)
        {
          $("#aceptar1").hide();
          $("#tipo").prop("disabled",true);
          $("#valor2").prop("disabled",true);
          $("#ano1").prop("disabled",true);
          consulta();
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#aceptar1").show();
        }
      }
    });
  }
}
function graba2()
{
  var salida = true, detalle = '';
  if ($("#numero").val() == '0')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Número de CDP</h3></center>";
  }
  if ($("#fecha").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Fecha del CDP</h3></center>";
  }
  if ($("#val_cdp").val() == '0.00')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Valor de CDP</h3></center>";
  }
  var val_valor = $("#val_cdp").val();
  val_valor = val_valor.trim();
  var var_ocu = val_valor.split('.');
  var var_ocu1 = var_ocu.length;
  if (var_ocu1 > 2)
  {
    salida = false;
    detalle += "<center><h3>Debe revisar el Valor de CDP</h3></center>";
  }
  if ($("#destinacion").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Destinación del CDP</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "cdp_grab.php",
      data:
      {
        vigencia: $("#ano2").val(),
        numero: $("#numero").val(),
        fecha: $("#fecha").val(),
        origen: $("#origen").val(),
        recurso: $("#recurso").val(),
        rubro: $("#rubro").val(),
        concepto: $("#concepto").val(),
        valor: $("#val_cdp").val(),
        valor1: $("#var_cdp").val(),
        destinacion: $("#destinacion").val()
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
        var valida, valida1, detalle;
        valida = registros.salida;
        if (valida > 0)
        {
          $("#aceptar2").hide();
          $("#cancelar").hide();
          $("#nuevo").show();
          trae_cdps();
          apaga1();
          consulta1();
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#aceptar2").show();
        }
      }
    });
  }
}
function graba3()
{
  var salida = true, detalle = '';
  if ($("#numero1").val() == '0')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Número de CRP</h3></center>";
  }
  if ($("#fecha1").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Fecha del CRP</h3></center>";
  }
  if ($("#val_crp").val() == '0.00')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Valor de CRP</h3></center>";
  }
  var val_valor = $("#val_crp").val();
  val_valor = val_valor.trim();
  var var_ocu = val_valor.split('.');
  var var_ocu1 = var_ocu.length;
  if (var_ocu1 > 2)
  {
    salida = false;
    detalle += "<center><h3>Debe revisar el Valor de CRP</h3></center>";
  }
  if ($("#destinacion1").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Destinación del CRP</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "crp_grab.php",
      data:
      {
        cdp: $("#cdp1").val(),
        numero: $("#numero1").val(),
        fecha: $("#fecha1").val(),
        origen: $("#origen1").val(),
        recurso: $("#recurso1").val(),
        rubro: $("#rubro1").val(),
        valor: $("#val_crp").val(),
        valor1: $("#var_crp").val(),
        destinacion: $("#destinacion1").val()
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
        var valida, valida1, detalle;
        valida = registros.salida;
        if (valida > 0)
        {
          $("#aceptar3").hide();
          $("#cancelar1").hide();
          $("#nuevo1").show();
          trae_crps();
          apaga2();
          consulta2();
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#aceptar3").show();
        }
      }
    });
  }
}
function graba4()
{
  var salida = true, detalle = '';
  if ($("#valor4").val() == '0.00')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Valor de Adición / Reducción</h3></center>";
  }
  var val_valor = $("#valor4").val();
  val_valor = val_valor.trim();
  var var_ocu = val_valor.split('.');
  var var_ocu1 = var_ocu.length;
  if (var_ocu1 > 2)
  {
    salida = false;
    detalle += "<center><h3>Debe revisar el Valor de Adición / Reducción</h3></center>";
  }
  if ($("#fecha3").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar la Fecha</h3></center>";
  }
  var valida = $("#tipo1").val();
  if (valida == "R")
  {
    var v_valor = $("#valor5").val();
    v_valor = parseFloat(v_valor);
    var v_saldo = $("#valor11").val();
    v_saldo = parseFloat(v_saldo);
    if (v_valor > v_saldo)
    {
      salida = false;
      detalle += "<center><h3>Valor de Reducción No Permitido</h3></center>";
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
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "crp_actu.php",
      data:
      {
        tipo: $("#tipo1").val(),
        valor: $("#valor4").val(),
        valor1: $("#valor5").val(),
        crp: $("#crp1").val(),
        fecha: $("#fecha3").val()
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
        var valida, valida1, detalle;
        valida = registros.salida;
        if (valida > 0)
        {
          $("#aceptar4").hide();
          $("#tipo1").prop("disabled",true);
          $("#valor4").prop("disabled",true);
          $("#crp1").prop("disabled",true);
          $("#fecha3").prop("disabled",true);
          consulta2();
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#aceptar4").show();
        }
      }
    });
  }
}
function graba5()
{
  var salida = true, detalle = '';
  if ($("#valor6").val() == '0.00')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Valor de Adición / Reducción</h3></center>";
  }
  var val_valor = $("#valor6").val();
  val_valor = val_valor.trim();
  var var_ocu = val_valor.split('.');
  var var_ocu1 = var_ocu.length;
  if (var_ocu1 > 2)
  {
    salida = false;
    detalle += "<center><h3>Debe revisar el Valor de Adición / Reducción</h3></center>";
  }
  if ($("#fecha4").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar la Fecha</h3></center>";
  }
  var valida = $("#tipo2").val();
  if (valida == "R")
  {
    var v_valor = $("#valor7").val();
    v_valor = parseFloat(v_valor);
    var v_saldo = $("#valor9").val();
    v_saldo = parseFloat(v_saldo);
    if (v_valor > v_saldo)
    {
      salida = false;
      detalle += "<center><h3>Valor de Reducción No Permitido</h3></center>";
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
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "cdp_actu.php",
      data:
      {
        tipo: $("#tipo2").val(),
        valor: $("#valor6").val(),
        valor1: $("#valor7").val(),
        cdp: $("#cdp2").val(),
        fecha: $("#fecha4").val()
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
        var valida, valida1, detalle;
        valida = registros.salida;
        if (valida > 0)
        {
          $("#aceptar5").hide();
          $("#tipo2").prop("disabled",true);
          $("#valor6").prop("disabled",true);
          $("#cdp2").prop("disabled",true);
          $("#fecha4").prop("disabled",true);
          consulta1();
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#aceptar5").show();
        }
      }
    });
  }
}
function busca()
{
  valida = $("#ano2").val();
  valida1 = $("#recurso option:selected").html();
  var valida2 = $("#recurso").val();
  trae_saldo(valida, valida2);
  trae_saldo_recurso(valida1);
}
function busca1()
{
  valida = $("#cdp1").val();
  trae_saldo1(valida);
}
function consulta()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "apro_consu.php",
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
      $("#res_apro").html('');
      var registros = data;
      $("#res_apro").append(registros);
    }
  });
}
function consulta1()
{
  var filtro = $("#filtro1").val();
  var filtro1 = $("#filtro3").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "cdps_consu.php",
    data:
    {
      vigencia: filtro,
      recurso: filtro1
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
      $("#res_cdps").html('');
      var registros = JSON.parse(data);
      var tabla = registros.salida;
      var valores = registros.valores;
      $("#res_cdps").append(tabla);
      $("#paso_excel").val(valores);
    }
  });
}
function consulta2()
{
  var filtro = $("#filtro2").val();
  var filtro1 = $("#filtro4").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "crps_consu.php",
    data:
    {
      vigencia: filtro,
      recurso: filtro1
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
      $("#res_crps").html('');
      var registros = JSON.parse(data);
      var tabla = registros.salida;
      var valores = registros.valores;
      $("#res_crps").append(tabla);
      $("#paso_excel1").val(valores);
    }
  });
}
function subir(valor)
{
  var valor;
  var url = "<a href='./subir.php?tipo=1&conse="+valor+"' name='link1' id='link1' class='pantalla-modal'>Link</a>";
  $("#vinculo").hide();
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#link1").click();
}
function subir1(valor)
{
  var valor;
  var url = "<a href='./subir.php?tipo=2&conse="+valor+"' name='link1' id='link1' class='pantalla-modal'>Link</a>";
  $("#vinculo").hide();
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#link1").click();
}
function trae_vigencias()
{
  $("#ano1").html('');
  $("#ano2").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_vige.php",
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
      $("#ano1").append(salida);
      $("#ano2").append(salida);
      var vigencia = $("#vige").val();
      $("#ano1").val(vigencia);
    }
  });
}
function apaga1()
{
  $("#ano2").prop("disabled",true);
  $("#numero").prop("disabled",true);
  $("#fecha").prop("disabled",true);
  $("#origen").prop("disabled",true);
  $("#recurso").prop("disabled",true);
  $("#rubro").prop("disabled",true);
  $("#concepto").prop("disabled",true);
  $("#val_cdp").prop("disabled",true);
  $("#destinacion").prop("disabled",true);
}
function apaga2()
{
  $("#cdp1").prop("disabled",true);
  $("#numero1").prop("disabled",true);
  $("#fecha1").prop("disabled",true);
  $("#origen1").prop("disabled",true);
  $("#recurso1").prop("disabled",true);
  $("#rubro1").prop("disabled",true);
  $("#val_crp").prop("disabled",true);
  $("#destinacion1").prop("disabled",true);
}
function prende1()
{
  $("#numero").prop("disabled",false);
  $("#fecha").prop("disabled",false);
  $("#origen").prop("disabled",false);
  $("#recurso").prop("disabled",false);
  $("#rubro").prop("disabled",false);
  $("#val_cdp").prop("disabled",false);
  $("#destinacion").prop("disabled",false);
}
function prende2()
{
  $("#cdp1").prop("disabled",false);
  $("#numero1").prop("disabled",false);
  $("#fecha1").prop("disabled",false);
  $("#origen1").prop("disabled",false);
  $("#recurso1").prop("disabled",false);
  $("#rubro1").prop("disabled",false);
  $("#val_crp").prop("disabled",false);
  $("#destinacion1").prop("disabled",false);
}
function valida_cdp()
{
  var valida, valida1;
  valida = $("#numero").val();
  valida1 = $("#ano2").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_numero.php",
    data:
    {
      numero: valida,
      vigencia: valida1
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var valida = registros.salida;
      if (valida == "1")
      {
        var detalle = "<center><h3>Número de CDP ya Registrado</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar2").hide();
      }
      else
      {
        $("#aceptar2").show();
      }
    }
  });   
}
function valida_crp()
{
  var valida, valida1;
  valida = $("#numero1").val();
  valida1 = $("#cdp1").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_numero1.php",
    data:
    {
      numero: valida,
      cdp: valida1
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var valida = registros.salida;
      if (valida == "1")
      {
      	var detalle = "<center><h3>Número de CRP ya Registrado</h3></center>";
      	$("#dialogo").html(detalle);
      	$("#dialogo").dialog("open");
   	  	$("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      	$("#aceptar3").hide();
      }
      else
      {
        $("#aceptar3").show();
      }
    }
  });   
}
function nuevo()
{
  ceros();
  prende1();
  $("#nuevo").hide();
  $("#cancelar").show();
  $("#aceptar2").show();
  $("#ano2").focus();
  var valida = $("#ano2").val();
  var valida1 = $("#recurso option:selected").html();
  var valida2 = $("#recurso").val();
  trae_saldo(valida, valida2);
  trae_saldo_recurso(valida1);
}
function nuevo1()
{
  ceros1();
  prende2();
  $("#nuevo1").hide();
  $("#cancelar1").show();
  $("#aceptar3").show();
  $("#cdp1").focus();
  var valida = $("#cdp1").val();
  trae_saldo1(valida);
}
function cancela()
{
  ceros();
  paso_val2();
  apaga1();
  trae_vigencias();
  $("#nuevo").show();
  $("#cancelar").hide();
  $("#aceptar2").hide();
}
function cancela1()
{
  ceros1();
  paso_val3();
  apaga2();
  trae_cdps();
  $("#nuevo1").show();
  $("#cancelar1").hide();
  $("#aceptar3").hide();
}
function ceros()
{
  $("#numero").val('0');
  $("#fecha").val('');
  $("#origen").val('1');
  $("#recurso").val('1');
  $("#rubro").val('3');
  $("#concepto").val('3');
  $("#val_cdp").val('0.00');
  $("#var_cdp").val('0');
  $("#destinacion").val('');
}
function ceros1()
{
  $("#numero1").val('0');
  $("#fecha1").val('');
  $("#origen1").val('1');
  $("#recurso1").val('1');
  $("#rubro1").val('3');
  $("#val_crp").val('0.00');
  $("#var_crp").val('0');
  $("#destinacion1").val('');
}
function trae_cdps()
{
  $("#cdp1").html('');
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
      $("#cdp1").append(salida);
      $("#cdp2").append(salida);
    }
  }); 
}
function trae_crps()
{
  $("#crp1").html('');
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
      $("#crp1").append(salida);
    }
  });
}
function trae_saldo(valor, valor1)
{
  $("#val_apr").val('0.00');
  $("#var_apr").val('0');
  var valor, valor1;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_saldo.php",
    data:
    {
      vigencia: valor,
      recurso: valor1
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var salida1 = 0;
      salida = registros.salida;
      salida1 = parseFloat(salida);
      salida1 = salida1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#var_apr").val(salida);
      $("#val_apr").val(salida1);
    }
  });
}
function trae_saldo1(valor)
{
  $("#val_cdp1").val('0.00');
  $("#var_cdp1").val('0');
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_saldo1.php",
    data:
    {
      conse: valor,
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var salida1 = 0;
      salida = registros.salida;
      salida1 = parseFloat(salida);
      salida1 = salida1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      var origen, recurso, rubro;
      origen = registros.origen;
      recurso = registros.recurso;
      rubro = registros.rubro;
      $("#var_cdp1").val(salida);
      $("#val_cdp1").val(salida1);
      $("#origen1").val(origen);
      $("#recurso1").val(recurso);
      $("#rubro1").val(rubro);
    }
  });
}
function trae_saldo_recurso(valor)
{
  $("#dis_rec").val('0.00');
  $("#dis_rec1").val('0');
  var valor;
  var valor1 = $("#recurso").val();
  var valor2 = $("#ano2").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_saldo2.php",
    data:
    {
      recurso: valor,
      recurso1: valor1,
      ano: valor2
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.saldo;
      var salida1 = parseFloat(salida);
      salida1 = salida1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#dis_rec").val(salida1);
      $("#dis_rec1").val(salida);
    }
  });
}
function trae_saldo_recurso1()
{
  var valor = $("#recurso option:selected").html();
  var valor1 = $("#recurso").val();
  var valor2 = $("#ano2").val();
  $("#dis_rec").val('0.00');
  $("#dis_rec1").val('0');
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_saldo2.php",
    data:
    {
      recurso: valor,
      recurso1: valor1,
      ano: valor2
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.saldo;
      var salida1 = parseFloat(salida);
      salida1 = salida1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#dis_rec").val(salida1);
      $("#dis_rec1").val(salida);
    }
  });
  trae_saldo(valor2, valor1);
}
function trae_saldo_vigencia()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_saldo3.php",
    data:
    {
      ano: $("#ano").val(),
      recurso: $("#recurso0").val()
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
      var saldo = registros.saldo;
      var saldo1 = saldo.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#total").val(saldo1);
      $("#total1").val(saldo);
      var disponible = registros.disponible;
      var disponible1 = disponible.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#total2").val(disponible1);
      $("#total3").val(disponible);
      if (disponible == "0")
      {
        $("#tipo>option[value='R']").attr("disabled","disabled");
      }
      else
      {
        $("#tipo>option[value='R']").removeAttr("disabled");
      }
    }
  });
}
function trae_saldo_cdp2()
{
  var valor = $("#cdp2 option:selected").html();
  var valor1 = $("#cdp2").val();
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_saldo4.php",
    data:
    {
      tipo: tipo,
      valor: valor,
      valor1: valor1
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      salida = parseFloat(salida);
      var salida1 = salida.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#valor8").val(salida1);
      $("#valor9").val(salida);
    }
  });
}
function trae_saldo_crp2()
{
  var valor = $("#crp1 option:selected").html();
  var valor1 = $("#crp1").val();
  var tipo = "2";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_saldo4.php",
    data:
    {
      tipo: tipo,
      valor: valor,
      valor1: valor1
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      salida = parseFloat(salida);
      var salida1 = salida.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#valor10").val(salida1);
      $("#valor11").val(salida);
    }
  });
}
function valida_rec()
{
  var valor1 = $("#var_cdp").val();
  var valor2 = $("#dis_rec1").val();
  var valor3 = (valor1-valor2);
  if (valor3 > 0)
  {
    var detalle = "<center><h3>Valor Superior al Disponible del Recurso</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#val_cdp").val('0.00');
    paso_val2();
    $("#aceptar2").hide();
  }
  else
  {
    compara();
  }
}
function compara()
{
  var valor1 = $("#var_cdp").val();
  var valor2 = $("#var_apr").val();
  var valor3 = (valor1-valor2);
  if (valor3 > 0)
  {
    var detalle = "<center><h3>Valor Superior al Disponible</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#val_cdp").val('0.00');
    paso_val2();
    $("#aceptar2").hide();
  }
  else
  {
    $("#aceptar2").show();
  }
}
function compara1()
{
  var valor1 = $("#var_crp").val();
  var valor2 = $("#var_cdp1").val();
  var valor3 = (valor1-valor2);
  if (valor3 > 0)
  {
    var detalle = "<center><h3>Valor Superior al Disponible</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#val_cdp").val('0.00');
    paso_val2();
    $("#aceptar3").hide();
  }
  else
  {
    $("#aceptar3").show();
  }
}
function excel()
{
  formu_excel.submit();
}
function excel1()
{
  formu_excel1.submit();
}
</script>
</body>
</html>
<?php
}
?>