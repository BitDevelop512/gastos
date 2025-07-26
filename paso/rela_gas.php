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
  $verifica = time();
  $alea = strtoupper(md5($verifica));
  $alea = substr($alea,0,5);
  $fecha = date('Y/m/d');
  $ano = date('Y');
  $mes = date('m');
  $mes1 = $mes;
  $mes1 = intval($mes1);
  $mes2 = $mes-1;
  $mes2 = intval($mes2);
  $tipo = $_GET['tipo'];
  if ($tipo == "1")
  {
    $tit_pan = "Informe de Gastos";
  }
  else
  {
    $tit_pan = "Relaci&oacute;n de Gastos";
  }
  $n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
  $n_periodo = $n_meses[$mes1-1];
  $n_periodo1 = $n_meses[$mes2-1];
  $periodos = "<option value='$mes2'>$n_periodo1</option><option value='$mes1'>$n_periodo</option>";
  // Se consulta unidad centralizadora
  $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur1 = odbc_exec($conexion, $query);
  $n_unidad = odbc_result($cur1,1);
  $n_unidad = intval($n_unidad);
  $n_dependencia = odbc_result($cur1,2);
  if ($n_unidad > 3)
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND unic='1'";
  }
  else
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' AND unic='1'";
  }
  $cur2 = odbc_exec($conexion, $query1);
  $unic = odbc_result($cur2,1);
  $query2 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $sql2 = odbc_exec($conexion, $query2);
  $sigla = trim(odbc_result($sql2,1));
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
          <h3><?php echo $tit_pan; ?></h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">ORDOP</font></label>
                  <select name="mision" id="mision" class="form-control select2" tabindex="1"></select>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Misi&oacute;n</font></label>
                  <div id="etiquetas"></div>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <br>
                  <input type="button" name="aceptar1" id="aceptar1" value="Validar">
                </div>
              </div>
              <br>
              <div id="datos">
                <div class="row">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Valor Total Aprobado Misi&oacute;n</font></label>
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Comprobante</font></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="valor" id="valor" class="form-control numero" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="compro" id="compro" class="form-control numero" value="0">
                    <input type="text" name="compro1" id="compro1" class="form-control numero" value="0">
                    <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly" tabindex="0">
                    <input type="hidden" name="valor1" id="valor1" class="form-control" onfocus="blur();" readonly="readonly" tabindex="0">
                    <input type="hidden" name="valor2" id="valor2" class="form-control" onfocus="blur();" readonly="readonly" tabindex="0">
                    <input type="hidden" name="valor3" id="valor3" class="form-control" onfocus="blur();" readonly="readonly" tabindex="0">
                    <input type="hidden" name="centra" id="centra" class="form-control" value="<?php echo $unic; ?>" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso_gasto" id="paso_gasto" class="form-control" value="0" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso0" id="paso0" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso1" id="paso1" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso2" id="paso2" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso3" id="paso3" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso4" id="paso4" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso5" id="paso5" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso6" id="paso6" class="form-control" readonly="readonly" tabindex="0">    <!-- Facturas Bienes -->
                    <input type="hidden" name="paso7" id="paso7" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso8" id="paso8" class="form-control" readonly="readonly" tabindex="0">
                    <input type="hidden" name="paso9" id="paso9" class="form-control" readonly="readonly" tabindex="0">    <!-- Factura Combustible -->
                    <input type="hidden" name="paso10" id="paso10" class="form-control" readonly="readonly" tabindex="0">  <!-- Factura Grasas -->
                    <input type="hidden" name="paso11" id="paso11" class="form-control" readonly="readonly" tabindex="0">  <!-- Factura Manteminiento -->
                    <input type="hidden" name="paso12" id="paso12" class="form-control" readonly="readonly" tabindex="0">  <!-- Factura RTM -->
                    <input type="hidden" name="paso13" id="paso13" class="form-control" readonly="readonly" tabindex="0">  <!-- Factura Llantas -->
                    <input type="hidden" name="paso14" id="paso14" class="form-control" readonly="readonly" tabindex="0">  <!-- Repuestos -->
                    <input type="hidden" name="paso15" id="paso15" class="form-control" readonly="readonly" tabindex="0">  <!-- Factura RTM Adicional -->
                    <input type="hidden" name="paso16" id="paso16" class="form-control" readonly="readonly" tabindex="0">  <!-- Factura Combustible Ad -->
                    <input type="hidden" name="paso17" id="paso17" class="form-control" readonly="readonly" tabindex="0">  <!-- Factura Llantas Ad -->
                    <input type="hidden" name="paso18" id="paso18" class="form-control" readonly="readonly" tabindex="0">  <!-- Factura Mantemini Add -->
                    <input type="hidden" name="paso19" id="paso19" class="form-control" readonly="readonly" tabindex="0">  <!-- IVA Manteminiento -->
                    <input type="hidden" name="paso20" id="paso20" class="form-control" readonly="readonly" tabindex="0">  <!-- IVA Manteminiento Adicional -->
                    <input type="hidden" name="c_rtm" id="c_rtm" class="form-control" readonly="readonly" tabindex="0">    <!-- Contador RTM -->
                    <input type="hidden" name="n_rtm" id="n_rtm" class="form-control" readonly="readonly" tabindex="0">    <!-- Interno RTM -->
                    <input type="hidden" name="c_rtn" id="c_rtn" class="form-control" readonly="readonly" tabindex="0">    <!-- Contador RTM Ad -->
                    <input type="hidden" name="n_rtn" id="n_rtn" class="form-control" readonly="readonly" tabindex="0">    <!-- Interno RTM Ad -->
                    <input type="hidden" name="c_man" id="c_man" class="form-control" readonly="readonly" tabindex="0">    <!-- Contador Mantenimientos -->
                    <input type="hidden" name="n_man" id="n_man" class="form-control" readonly="readonly" tabindex="0">    <!-- Interno Mantenimientos -->
                    <input type="hidden" name="c_mam" id="c_mam" class="form-control" readonly="readonly" tabindex="0">    <!-- Contador Manteni Ad -->
                    <input type="hidden" name="n_mam" id="n_mam" class="form-control" readonly="readonly" tabindex="0">    <!-- Interno Manteni Ad -->
                    <input type="hidden" name="c_com" id="c_com" class="form-control" readonly="readonly" tabindex="0">    <!-- Contador Combustible -->
                    <input type="hidden" name="n_com" id="n_com" class="form-control" readonly="readonly" tabindex="0">    <!-- Interno Combustible -->
                    <input type="hidden" name="c_con" id="c_con" class="form-control" readonly="readonly" tabindex="0">    <!-- Contador Combust. Ad. -->
                    <input type="hidden" name="n_con" id="n_con" class="form-control" readonly="readonly" tabindex="0">    <!-- Interno Combust. Ad. -->
                    <input type="hidden" name="c_lla" id="c_lla" class="form-control" readonly="readonly" tabindex="0">    <!-- Contador Llantas -->
                    <input type="hidden" name="n_lla" id="n_lla" class="form-control" readonly="readonly" tabindex="0">    <!-- Interno Llantas -->
										<input type="hidden" name="v_pla" id="v_pla" class="form-control" readonly="readonly" tabindex="0">		 <!-- Gasolina placas con sop -->
										<input type="hidden" name="v_pla1" id="v_pla1" class="form-control" readonly="readonly" tabindex="0">	 <!-- Gasolina placas sin sop -->
										<input type="hidden" name="v_pla2" id="v_pla2" class="form-control" readonly="readonly" tabindex="0">	 <!-- Gasolina placas ad con sop-->
										<input type="hidden" name="v_pla3" id="v_pla3" class="form-control" readonly="readonly" tabindex="0">	 <!-- Gasolina placas ad sin sop -->
                    <input type="hidden" name="c_gas" id="c_gas" class="form-control" value="0" readonly="readonly" tabindex="0">                 <!-- Contador Gastos -->
                    <input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly" tabindex="0">
                    <input type="hidden" name="sigla" id="sigla" class="form-control" value="<?php echo $sigla; ?>" readonly="readonly" tabindex="0">
                  </div>
                </div>
                <br>
                <div id="add_form">
                  <table width="100%" align="center" border="0">
                    <tr>
                      <td width="45%" height="35"><center><b>Concepto</b></center></td>
                      <td width="20%" height="35"><center><b>Valor</b></center></td>
                      <td width="20%" height="35"><center><b>Tipo</b></center></td>
                      <td width="5%">&nbsp;</td>
                      <td width="5%">&nbsp;</td>
                      <td width="5%">&nbsp;</td>
                    </tr>
                  </table>
                </div>
                <div id="add_form2">
                  <table align="center" width="100%" border="0">
                    <tr>
                      <td width="45%">&nbsp;</td>
                      <td width="20%">&nbsp;</td>
                      <td width="20%">&nbsp;</td>
                      <td width="5%">&nbsp;</td>
                      <td width="5%">&nbsp;</td>
                      <td width="5%">&nbsp;</td>
                    </tr>
                  </table>
                </div>
                <br>
                <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0"></a>&nbsp;
                <a href="#" name="add_field2" id="add_field2"><img src="imagenes/boton0.jpg" border="0"></a>
                <br><br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Gastos con Soportes</font></label>
                    <input type="text" name="t_sol1" id="t_sol1" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Gastos sin Facturas</font></label>
                    <input type="text" name="t_sol2" id="t_sol2" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Total Gastos</font></label>
                    <input type="text" name="t_sol" id="t_sol" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Total Reintegros</font></label>
                    <input type="text" name="t_sol3" id="t_sol3" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly">
                  </div>
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Lapso de la Misi&oacute;n</font></label>
                    <input type="text" name="lapso" id="lapso" class="form-control fecha" value="" onfocus="blur();" readonly="readonly">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7">
                    <label><font face="Verdana" size="2">Responsable</font></label>
                    <input type="text" name="responsable" id="responsable" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Periodo</font></label>
                    <select name="periodo" id="periodo" class="form-control select2"><?php echo $periodos; ?></select>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Nombre Comandante Unidad</font></label>
                    <input type="text" name="comandante" id="comandante" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="99" autocomplete="off">
                  </div>
                  <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                    <label><font face="Verdana" size="2">Cargo Comandante Unidad</font></label>
                    <input type="text" name="comandante1" id="comandante1" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Elabor&oacute;</font></label>
                    <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" autocomplete="off">
                  </div>
                  <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                    <label><font face="Verdana" size="2">Revis&oacute;</font></label>
                    <input type="text" name="reviso" id="reviso" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" autocomplete="off">
                  </div>
                </div>
                <br><br>
                <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo; ?>" readonly="readonly">
                <input type="hidden" name="n_ano" id="n_ano" value="<?php echo $ano; ?>" readonly="readonly">
                <input type="hidden" name="n_ordop" id="n_ordop" readonly="readonly">
                <input type="hidden" name="conceptos" id="conceptos" readonly="readonly">
                <input type="hidden" name="valores" id="valores" readonly="readonly">
                <input type="hidden" name="valores1" id="valores1" readonly="readonly">
                <input type="hidden" name="tipoc" id="tipoc" readonly="readonly">
                <input type="hidden" name="conceptos1" id="conceptos1" readonly="readonly">
                <input type="hidden" name="valores2" id="valores2" readonly="readonly">
                <input type="hidden" name="valores3" id="valores3" readonly="readonly">
                <input type="hidden" name="tipoc1" id="tipoc1" readonly="readonly">
                <input type="hidden" name="v_usuario" id="v_usuario" value="<?php echo $usu_usuario; ?>" readonly="readonly">
                <input type="hidden" name="v_unidad" id="v_unidad" value="<?php echo $uni_usuario; ?>" readonly="readonly">
                <input type="hidden" name="v_ciudad" id="v_ciudad" value="<?php echo $ciu_usuario; ?>" readonly="readonly">
                <input type="hidden" name="v_click" id="v_click" class="form-control" value="0" readonly="readonly" tabindex="0">
                <center>
                  <font face="Verdana" size="2" color="#ff0000"><b>Presione una sola vez el bot&oacute;n Continuar</b></font>
                  <br><br>
                  <input type="button" name="aceptar" id="aceptar" value="Continuar">
                  <input type="button" name="aceptar2" id="aceptar2" value="Visualizar">
                </center>
              </div>
              <div id="vinculo"></div>
            </form>
          </div>
          <h3>Consultas</h3>
          <div>
            <div id="load1">
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
          </div>
          <div id="dialogo"></div>
          <div id="dialogo1"></div>
          <div id="dialogo2">
            <form name="formu1">
              <div id="add_form1">
                <table align="center" width="100%" border="0"></table>
              </div>
              <a href="#" name="add_field1" id="add_field1" onclick="agrega();"><img src="imagenes/boton1.jpg" border="0"></a>
              <input type="hidden" name="paso_bienes" id="paso_bienes" class="form-control" readonly="readonly">
              <center>
                <input type="button" name="aceptar3" id="aceptar3" value="Continuar">
              </center>
            </form>
            <form name="formu3" action="ver_rela.php" method="post" target="_blank">
              <input type="hidden" name="plan_conse" id="plan_conse" readonly="readonly">
              <input type="hidden" name="plan_tipo" id="plan_tipo" readonly="readonly">
              <input type="hidden" name="plan_ano" id="plan_ano" readonly="readonly">
            </form>
          </div>
          <!-- Modificar -->
          <div id="dialogo3">
            <form name="formu2">
              <table width="98%" align="center" border="0">
                <tr>
                  <td>
                    <div class="row">
                      <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                        <label><font face="Verdana" size="2">Responsable</font></label>
                        <input type="text" name="c_responsable" id="c_responsable" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                        <label><font face="Verdana" size="2">Nombre Comandante</font></label>
                        <input type="text" name="c_nombre" id="c_nombre" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="99" autocomplete="off">
                      </div>
                      <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                        <label><font face="Verdana" size="2">Cargo Comandante</font></label>
                        <input type="text" name="c_cargo" id="c_cargo" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                        <label><font face="Verdana" size="2">Elabor&oacute;</font></label>
                        <input type="text" name="c_elaboro" id="c_elaboro" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" autocomplete="off">
                      </div>
                      <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                        <label><font face="Verdana" size="2">Revis&oacute;</font></label>
                        <input type="text" name="c_reviso" id="c_reviso" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" autocomplete="off">
                      </div>
                    </div>
                    <input type="hidden" name="c_index" id="c_index" class="form-control" value="0" readonly="readonly">
                    <input type="hidden" name="c_valor" id="c_valor" class="form-control" value="0" readonly="readonly">
                    <input type="hidden" name="c_ano" id="c_ano" class="form-control" value="0" readonly="readonly">
                    <br>
                    <center>
                      <input type="button" name="aceptar9" id="aceptar9" value="Actualizar">
                    </center>
                  </td>
                </tr>
              </table>
            </form>
          </div>
          <!-- Combustible -->
          <div id="dialogo4">
            <form name="formu4">
              <div id="add_form4">
                <table align="center" width="100%" border="0"></table>
              </div>
              <a href="#" name="add_field4" id="add_field4" onclick="agrega4();"><img src="imagenes/boton1.jpg" border="0"></a>
              <input type="hidden" name="paso_combus" id="paso_combus" class="form-control" readonly="readonly">
              <input type="hidden" name="paso_combus1" id="paso_combus1" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_combus2" id="paso_combus2" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_combus3" id="paso_combus3" class="form-control" value="0" readonly="readonly">
              <center>
                <input type="button" name="aceptar4" id="aceptar4" value="Continuar">
              </center>
            </form>
          </div>
          <!-- Combustible Adiocional -->
          <div id="dialogo41">
            <form name="formu41">
              <div id="add_form41">
                <table align="center" width="100%" border="0"></table>
              </div>
              <a href="#" name="add_field41" id="add_field41" onclick="agrega41();"><img src="imagenes/boton1.jpg" border="0"></a>
              <input type="hidden" name="paso_conbus" id="paso_conbus" class="form-control" readonly="readonly">
              <input type="hidden" name="paso_conbus1" id="paso_conbus1" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_conbus2" id="paso_conbus2" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_conbus3" id="paso_conbus3" class="form-control" value="0" readonly="readonly">
              <center>
                <input type="button" name="aceptar41" id="aceptar41" value="Continuar">
              </center>
            </form>
          </div>
          <div id="dialogo5">
            <form name="formu5">
              <div id="add_form5">
                <table align="center" width="100%" border="0"></table>
              </div>
              <a href="#" name="add_field5" id="add_field5" onclick="agrega5();"><img src="imagenes/boton1.jpg" border="0"></a>
              <input type="hidden" name="paso_grasas" id="paso_grasas" class="form-control" readonly="readonly">
              <input type="hidden" name="paso_grasas1" id="paso_grasas1" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_grasas2" id="paso_grasas2" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_grasas3" id="paso_grasas3" class="form-control" value="0" readonly="readonly">
              <center>
                <input type="button" name="aceptar5" id="aceptar5" value="Continuar">
              </center>
            </form>
          </div>
          <div id="dialogo6">
            <form name="formu6">
              <div id="add_form6">
                <table align="center" width="100%" border="0"></table>
              </div>
              <a href="#" name="add_field6" id="add_field6" onclick="agrega6();"><img src="imagenes/boton1.jpg" border="0"></a>
              <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
                <input type="hidden" name="paso_manteni" id="paso_manteni" class="form-control" readonly="readonly">
                <input type="hidden" name="paso_manteni1" id="paso_manteni1" class="form-control" value="0" readonly="readonly">
                <input type="hidden" name="paso_manteni2" id="paso_manteni2" class="form-control" value="0" readonly="readonly">
                <input type="hidden" name="paso_manteni3" id="paso_manteni3" class="form-control" value="0" readonly="readonly">
                <center>
                  <input type="button" name="aceptar6" id="aceptar6" value="Continuar">
                </center>
              </div>
              <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                <label><div class="centrado"><font face="Verdana" size="2">I.V.A.</font></div></label>
              </div>
              <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                <input type="text" name="iva_man" id="iva_man" class="form-control numero" value="0.00" readonly="readonly">
              </div>
            </form>
          </div>
          <!-- Mantenimiento Adicional -->
          <div id="dialogo61">
            <form name="formu61">
              <div id="add_form61">
                <table align="center" width="100%" border="0"></table>
              </div>
              <a href="#" name="add_field61" id="add_field61" onclick="agrega61();"><img src="imagenes/boton1.jpg" border="0"></a>
              <input type="hidden" name="paso_mamteni" id="paso_mamteni" class="form-control" readonly="readonly">
              <input type="hidden" name="paso_mamteni1" id="paso_mamteni1" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_mamteni2" id="paso_mamteni2" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_mamteni3" id="paso_mamteni3" class="form-control" value="0" readonly="readonly">
              <center>
                <input type="button" name="aceptar61" id="aceptar61" value="Continuar">
              </center>
            </form>
          </div>
          <!-- RTM -->
          <div id="dialogo7">
            <form name="formu7">
              <div id="add_form7">
                <table align="center" width="100%" border="0"></table>
              </div>
              <a href="#" name="add_field7" id="add_field7" onclick="agrega7();"><img src="imagenes/boton1.jpg" border="0"></a>
              <input type="hidden" name="paso_tecnico" id="paso_tecnico" class="form-control" readonly="readonly">
              <input type="hidden" name="paso_tecnico1" id="paso_tecnico1" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_tecnico2" id="paso_tecnico2" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_tecnico3" id="paso_tecnico3" class="form-control" value="0" readonly="readonly">
              <center>
                <input type="button" name="aceptar7" id="aceptar7" value="Continuar">
              </center>
            </form>
          </div>
          <!-- RTM Adicional -->
          <div id="dialogo71">
            <form name="formu71">
              <div id="add_form71">
                <table align="center" width="100%" border="0"></table>
              </div>
              <a href="#" name="add_field71" id="add_field71" onclick="agrega71();"><img src="imagenes/boton1.jpg" border="0"></a>
              <input type="hidden" name="paso_tecnido" id="paso_tecnido" class="form-control" readonly="readonly">
              <input type="hidden" name="paso_tecnido1" id="paso_tecnido1" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_tecnido2" id="paso_tecnido2" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_tecnido3" id="paso_tecnido3" class="form-control" value="0" readonly="readonly">
              <center>
                <input type="button" name="aceptar71" id="aceptar71" value="Continuar">
              </center>
            </form>
          </div>
          <div id="dialogo8">
            <form name="formu8">
              <div id="add_form8">
                <table align="center" width="100%" border="0"></table>
              </div>
              <a href="#" name="add_field8" id="add_field8" onclick="agrega8();"><img src="imagenes/boton1.jpg" border="0"></a>
              <input type="hidden" name="paso_llantas" id="paso_llantas" class="form-control" readonly="readonly">
              <input type="hidden" name="paso_llantas1" id="paso_llantas1" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_llantas2" id="paso_llantas2" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_llantas3" id="paso_llantas3" class="form-control" value="0" readonly="readonly">
              <center>
                <input type="button" name="aceptar8" id="aceptar8" value="Continuar">
              </center>
            </form>
          </div>
          <!-- Llantas Adicional -->
          <div id="dialogo81">
            <form name="formu81">
              <div id="add_form81">
                <table align="center" width="100%" border="0"></table>
              </div>
              <a href="#" name="add_field81" id="add_field81" onclick="agrega81();"><img src="imagenes/boton1.jpg" border="0"></a>
              <input type="hidden" name="paso_llamtas" id="paso_llamtas" class="form-control" readonly="readonly">
              <input type="hidden" name="paso_llamtas1" id="paso_llamtas1" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_llamtas2" id="paso_llamtas2" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="paso_llamtas3" id="paso_llamtas3" class="form-control" value="0" readonly="readonly">
              <center>
                <input type="button" name="aceptar81" id="aceptar81" value="Continuar">
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
<script src="js/inactividad.js?1.0.0"></script>
<style>
.ui-widget-header
{
  color: #000000;
  font-weight: bold;
}
.chk1
{
  zoom: 0.8;
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
  $("#load1").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 260,
    width: 620,
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
    height: 265,
    width: 620,
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
    height: 600,
    width: 800,
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
  // Modificar
  $("#dialogo3").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 320,
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
    }
  });
  // Dialogo Combustibles
  $("#dialogo4").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 600,
    width: 900,
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
  $("#dialogo41").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 600,
    width: 900,
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
  // Dialogo Grasas
  $("#dialogo5").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 600,
    width: 900,
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
  // Dialogo Mantenimiento
  $("#dialogo6").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 600,
    width: 900,
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
  $("#dialogo61").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 600,
    width: 900,
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
  // Dialogo RTM
  $("#dialogo7").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 600,
    width: 900,
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
  $("#dialogo71").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 600,
    width: 900,
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
  // Dialogo Llantas
  $("#dialogo8").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 600,
    width: 900,
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
  $("#dialogo81").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 600,
    width: 900,
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
  trae_mision();
  trae_pagos();
  trae_pagos1();
  trae_unidades();
  trae_repuestos();
  $("#aceptar").button();
  $("#aceptar").click(pregunta1);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(busca);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(link);
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").hide();
  $("#aceptar3").button();
  $("#aceptar3").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").click(valida_bienes);
  $("#aceptar4").button();
  $("#aceptar4").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar4").click(valida_combus);
  $("#aceptar41").button();
  $("#aceptar41").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar41").click(valida_combus1);
  $("#aceptar5").button();
  $("#aceptar5").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar5").click(valida_grasas);
  $("#aceptar6").button();
  $("#aceptar6").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar6").click(valida_manteni);
  $("#aceptar61").button();
  $("#aceptar61").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar61").click(valida_manteni1);
  $("#aceptar7").button();
  $("#aceptar7").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar7").click(valida_tecnico);
  $("#aceptar71").button();
  $("#aceptar71").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar71").click(valida_tecnico1);
  $("#aceptar8").button();
  $("#aceptar8").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar8").click(valida_llantas);
  $("#aceptar81").button();
  $("#aceptar81").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar81").click(valida_llantas1);
  $("#aceptar9").button();
  $("#aceptar9").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar9").click(actualizar);
  $("#valor").prop("disabled",true);
  $("#compro").prop("disabled",true);
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  var MaxInputs       = 99;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    var paso0 = $("#paso0").val();
    var paso1 = $("#paso1").val();
    var paso2 = $("#paso_gasto").val();
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      FieldCount++;
      $("#add_form table").append('<tr><div class="row"><td><div class="espacio1"></div></td></div></tr><tr><div class="row"><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><select name="gas_'+z+'" id="gas_'+z+'" class="form-control select2"></select></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><input type="text" name="vag_'+z+'" id="vag_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_val('+z+'); suma();" onblur="veri('+z+');"><input type="hidden" name="vat_'+z+'" id="vat_'+z+'" class="form-control" value="0"></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><select name="tip_'+z+'" id="tip_'+z+'" class="form-control select2" onchange="suma();"><option value="S">CON SOPORTE</option><option value="N">SIN FACTURA</option></select></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><div id="del_'+z+'"><a href="#" onclick="borra('+z+')"><img src="imagenes/boton2.jpg" border="0"></a></div></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><div id="bot_'+z+'"></div></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><input type="hidden" name="vfa_'+z+'" id="vfa_'+z+'" class="form-control fecha" value="0" readonly="readonly"></div></td></div></tr>');
      x_1++;
      if (paso2 == "1")
      {
        $("#gas_"+z).append(paso0);
      }
      else
      {
        $("#gas_"+z).append(paso1); 
      }
      $("#vag_"+z).maskMoney();
      $("#gas_"+z).focus();
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
  var InputsWrapper   = $("#add_form2 table tr");
  var AddButton       = $("#add_field2");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    var paso1;
    paso1 = $("#paso4").val();
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      FieldCount++;
      $("#add_form2 table").append('<tr><div class="row"><td><div class="espacio1"></div></td></div></tr><tr><div class="row"><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><select name="gas1_'+z+'" id="gas1_'+z+'" class="form-control select2"></select></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><input type="text" name="vag1_'+z+'" id="vag1_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_val3('+z+'); suma3();"><input type="hidden" name="vat1_'+z+'" id="vat1_'+z+'" class="form-control" value="0"></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><select name="tip1_'+z+'" id="tip1_'+z+'" class="form-control select2" onchange="suma3();"><option value="S">CON SOPORTE</option><option value="N">SIN FACTURA</option></select></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><div id="del1_'+z+'"><a href="#" onclick="borra1('+z+')"><img src="imagenes/boton2.jpg" border="0"></a></div></div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">&nbsp;</div></td><td><div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12"><input type="hidden" name="vfa1_'+z+'" id="vfa1_'+z+'" class="form-control fecha" value="0" readonly="readonly"></div></td></div></tr>');
      x_1++;
      $("#gas1_"+z).append(paso1);
      $("#vag1_"+z).maskMoney();
      $("#gas1_"+z).focus();
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
  $("#datos").hide();
  $("#add_field1").hide();
  $("#add_field4").hide();
  $("#add_field41").hide();
  $("#add_field5").hide();
  $("#add_field6").hide();
  $("#add_field7").hide();
  $("#add_field71").hide();
  $("#add_field8").hide();
  $("#add_field81").hide();
  $("#mision").change(trae_mision1);
});
function trae_mision()
{
  $("#mision").html('');
  $("#etiquetas").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_mision.php",
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
        $("#etiquetas").html('');
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
  $("#etiquetas").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_mision2.php",
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
      var aprobadas = "";
      var validaciones = "";
      var salida = "";
      var salida1 = "";
      var salida2 = "";
      var compara;
      for (var i in registros) 
      {
        mision = registros[i].misiones;
        aprobadas = registros[i].aprobadas;
        conse = registros[i].conse;
        internos = registros[i].internos;
        validaciones = registros[i].validaciones;
        var var_ocu = mision.split('|');
        var var_ocu1 = var_ocu.length;
        var var_ocu2 = internos.split(',');
        var var_ocu3 = validaciones.split(',');
        var var_ocu4 = aprobadas.split('|');
        for (var i=0; i<var_ocu1-1; i++)
        {
          var n_mision = var_ocu[i];
          n_mision = n_mision.trim();
          var n_aprobada = var_ocu4[i];
          n_aprobada = n_aprobada.trim();
          var n_elaborada = var_ocu3[i];
          n_elaborada = parseInt(n_elaborada);
          if ((n_elaborada >= 1) || (n_elaborada == undefined))
          {
          }
          else
          {
            if (n_mision == n_aprobada)
            {
              salida += "<option value='"+conse+"'>"+var_ocu[i]+" ¬ "+conse+" ¬ "+var_ocu2[i]+"</option>";
              salida1 += var_ocu[i]+" ¬ "+conse+" ¬ "+var_ocu2[i]+"#";
            }
          }
        }
      }
      var var_ocu4 = salida1.split('#');
      var var_ocu5 = var_ocu4.length;
      salida2 += "<table width='100%' border='1'>";
      for (var j=0; j<var_ocu5-1; j++)
      {
        salida2 += "<tr><td width='90%'><input type='text' name='txt_"+j+"' id='txt_"+j+"' class='form-control' value='"+var_ocu4[j]+"' readonly='readonly' style='border-style: none; background: transparent; color: #000;'></td><td width='10%'><center><input type='checkbox' name='chk_"+j+"' id='chk_"+j+"' value="+j+"></center></td></tr>";
      }
      salida2 += "</table>";
      $("#etiquetas").append(salida2);
      if (var_ocu5 == "1")
      {
        $("#aceptar1").hide();
      }
      else
      {
        $("#aceptar1").show();
      }
    }
  });
}
function busca()
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7;
  valor = $("#mision").val();
  valor4 = "";
  valor6 = "";
  $("#paso7").val('');
  $("#paso8").val('');
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('chk_')!=-1)
    {
      if ($("#"+saux).is(":checked"))
      {
        var var1 = $("#"+saux).val();
        valor2 = $("#txt_"+var1).val();
        var var_ocu = valor2.split('¬');
        var var_ocu1 = var_ocu.length;
        if (var_ocu1 == "3")
        {
          valor1 = var_ocu[1];
        }
        else
        {
          if (var_ocu1 == "4")
          {
            valor1 = var_ocu[2];
          }
        }
        valor1 = valor1.trim();
        valor4 += valor2+"|";
        valor6 += valor1+"|";
      }
    }
  }
  valor3 = $("#mision option:selected").html();
  ano = $("#n_ano").val();
  $("#paso7").val(valor4);
  $("#paso8").val(valor6);
  valor5 = $("#paso7").val();
  if (valor5 == "")
  {
    var detalle = "<center><h3>Debe seleccionar m&iacute;nimo una Misi&oacute;n</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('chk_')!=-1)
      {
        document.getElementById(saux).setAttribute("disabled","disabled");
      }
    }
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "con_relacion.php",
      data:
      {
        valor: valor,
        valor1: valor6,
        valor2: valor4,
        valor3: valor3,
        ano: ano
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        var salida = registros.salida;
        var tipo = registros.tipo;
        if (salida == "1")
        {
          var detalle = "<center><h3>Informe / Relaci&oacute;n ya Registrada</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          traer();
        }
      }
    });
  }
}
function traer()
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6;
  valor = $("#mision").val();
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('chk_')!=-1)
    {
      if ($("#"+saux).is(":checked"))
      {
        var var1 = $("#"+saux).val();
        valor2 = $("#txt_"+var1).val();
        var var_ocu = valor2.split('¬');
        var var_ocu1 = var_ocu.length;
        if (var_ocu1 == "3")
        {
          valor1 = var_ocu[1];
        }
        else
        {
          if (var_ocu1 == "4")
          {
            valor1 = var_ocu[2];
          }
        }
      }
    }
  }
  valor1 = valor1.trim();
  valor3 = $("#mision option:selected").html();
  valor4 = $("#centra").val();
  ano = $("#n_ano").val();
  valor5 = $("#paso8").val();
  valor6 = $("#paso7").val();
  var valida = 0;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_mision1.php",
    data:
    {
      valor: valor,
      valor1: valor5,
      valor2: valor6,
      valor3: valor3,
      valor4: valor4,
      ano: ano
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      $("#compro").val(registros.egreso);
      $("#compro1").val(registros.egresos);
      $("#compro").prop("disabled",true);
      $("#compro1").prop("disabled",true);
      $("#compro").hide();
      var total = parseFloat(registros.total);
      total = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      if (registros.valor == "")
      {
        $("#valor").val("0.00");
      }
      else
      {
        $("#valor").val(registros.valor);
      }
      paso_valor();
      var responsable = registros.responsable;
      $("#responsable").val(responsable);
      var lapso = registros.lapso;
      $("#lapso").val(lapso);
      var lapso1 = registros.lapso1;
      $("#periodo").val(lapso1);
      // Combustible partida mensual
      // Con soporte
      var combustible = parseFloat(registros.combustible1);
      var combustible1 = combustible.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      // Sin soporte
      var combustible4 = parseFloat(registros.combustible3);
      var combustible5 = combustible4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      // Combustible adicional
      // Con soporte
      var combustible2 = parseFloat(registros.combustible2);
      var combustible3 = combustible2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      // Sin soporte
      var combustible6 = parseFloat(registros.combustible4);
      var combustible7 = combustible6.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#datos").show();
      $("#mision").prop("disabled",true);
      $("#aceptar1").hide();
      // Combustible
      var lista = [];
      var contador = 0;
      // Combustible Adicional
      var lista1 = [];
      var contador1 = 0;
      // RTM
      var lista2 = [];
      var contador2 = 0;
      // RTM Adicional
      var lista3 = [];
      var contador3 = 0;
      // Mantenimiento
      var lista4 = [];
      var contador4 = 0;
      // Mantenimiento Adicional
      var lista5 = [];
      var contador5 = 0;
      // Llantas
      var lista6 = [];
      var contador6 = 0;
      var var_ocu = salida.split('«');
      var var_ocu1 = var_ocu.length;
      var z = 0;
      var y = 0;
      var w = 0;
      // Contadores
      var tot_com = 0;
      var tot_con = 0;
      var tot_man = 0;
      var tot_mam = 0;
      var tot_rtm = 0;
      var tot_rtn = 0;
      var tot_lla = 0;
      // Contador Total de Gastos
      var tot_gas = $("#c_gas").val();
      for (var i=0; i<var_ocu1-1; i++)
      {
        var var_0 = $("#paso5").val();
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("|");
        z = z+1;
        var p1 = var_2[0];
        if (p1 == "36")
        {
          contador++;
          if (jQuery.inArray(p1, lista) != -1)
          {
            w++;
          }
          else
          {
            lista.push(p1);
            $("#add_field").click();
            tot_gas++;
            $("#c_gas").val(tot_gas);
          }
        }
        else
        {
          if (p1 == "42")
          {
            contador1++;
            if (jQuery.inArray(p1, lista1) != -1)
            {
              w++;
            }
            else
            {
              lista1.push(p1);
              $("#add_field").click();
              tot_gas++;
              $("#c_gas").val(tot_gas);
            }
          }
          else
          {
            if (p1 == "39")
            {
              contador2++;
              if (jQuery.inArray(p1, lista2) != -1)
              {
                w++;
              }
              else
              {
                lista2.push(p1);
                $("#add_field").click();
                tot_gas++;
                $("#c_gas").val(tot_gas);
              }
            }
            else
            {
              if (p1 == "45")
              {
                contador3++;
                if (jQuery.inArray(p1, lista3) != -1)
                {
                  w++;
                }
                else
                {
                  lista3.push(p1);
                  $("#add_field").click();
                  tot_gas++;
                  $("#c_gas").val(tot_gas);
                }
              }
              else
              {
                if (p1 == "38")
                {
                  contador4++;
                  if (jQuery.inArray(p1, lista4) != -1)
                  {
                    w++;
                  }
                  else
                  {
                    lista4.push(p1);
                    $("#add_field").click();
                    tot_gas++;
                    $("#c_gas").val(tot_gas);
                  }
                }
                else
                {
                  if (p1 == "44")
                  {
                    contador5++;
                    if (jQuery.inArray(p1, lista5) != -1)
                    {
                      w++;
                    }
                    else
                    {
                      lista5.push(p1);
                      $("#add_field").click();
                      tot_gas++;
                      $("#c_gas").val(tot_gas);
                    }
                  }
                  else
                  {
                    if (p1 == "40")
                    {
                      contador6++;
                      if (jQuery.inArray(p1, lista6) != -1)
                      {
                        w++;
                      }
                      else
                      {
                        lista6.push(p1);
                        $("#add_field").click();
                        tot_gas++;
                        $("#c_gas").val(tot_gas);
                      }
                    }
                    else
                    {
                      if (contador1 > 1)
                      {
                        z = z-(contador1-1);
                      }
                      $("#add_field").click();
                      tot_gas++;
                      $("#c_gas").val(tot_gas);
                    }
                  }
                }
              }
            }
          }
        }
        var p2 = var_2[1];
        var p3 = var_2[2];
        var p4 = p3.length;
        var boton = "";       
        if (p4 > 0)
        {
          $("#paso3").val(i);
          var_0 += i+",";
          $("#paso5").val(var_0);
          if ((p1 == "18") || (p1 == "36") || (p1 == "42"))
          {
            $("#vag_"+z).prop("disabled",true);
          }
          if (p1 == "18")
          {
          	y = 0;
            $("#tip_"+z).prop("disabled",true);
            var var_3 = p3.split("#");
            var var_4 = var_3[0];
            var var_5 = var_4.split("&");
            var var_6 = var_5.length-1;
            var var_7 = var_3[1];
            var var_8 = var_7.split("&");
            var var_9 = var_3[2];
            var var_10 = var_9.split("&");
            var var_11 = var_3[3];
            var var_12 = var_11.split("&");
            var var_13 = var_3[5];
            var var_14 = var_3[6];
            for (var j=0; j<var_6; j++)
            {
              agrega();
              var x1 = var_5[j];
              var x2 = var_8[j];
              var x3 = var_10[j];
              v3 = x3.trim();
              x3 = parseFloat(x3);
              x3 = x3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
              var x4 = var_12[j];
              var x5 = $("#mision option:selected").html();
              var x5_1 = x5.indexOf("«")>-1;
              if (x5_1 == false)
              {
              }
              else
              {
                x5 = x5.split("«");
                x5 = x5[1];
              }
              x5 = x5.trim();
              var x6 = var_13;
              var x7 = var_14;
              $("#cla_"+y).val(x1);
              $("#nom_"+y).val(x2);
              $("#val_"+y).val(x3);
              paso_val2(y);
              $("#des_"+y).val(x4);
              $("#ord_"+y).val(x5);
              $("#mis_"+y).val(x7);
              $("#pla_"+y).val(x6);
              var x10 = $("#vam_"+y).val();
              var x11 = $("#valor").val();
              var x12 = parseFloat(x11.replace(/,/g,''));
              $("#van_"+y).val(x12);
              y++;
              y = y+10;
            }
          }
          // Combustible
          var con_com = 0;
          if (p1 == "36")
          {
            y = tot_com;
            var var_3 = p3.split("#");
            var var_4 = var_3[0];
            var var_5 = var_4.split("&");
            var var_6 = var_3[1];
            var var_7 = var_6.split("&");
            var var_8 = var_3[2];
            var var_9 = var_8.split("&");
            var var_10 = var_3[3];
            var var_11 = var_10.split("&");
            var var_12 = var_3[4];
            var var_13 = var_12.split("&");
            var var_14 = var_5.length-1;
            for (var j=0; j<var_14; j++)
            {
              agrega4();
              var x1 = var_5[j];
              var x2 = var_7[j];
              var x3 = var_9[j];
              var x4 = var_11[j];
              var x5 = var_13[j];
              if (contador > 1)
              {
                y = $("#c_com").val();
                y = parseInt(y);
              }
              $("#com1_"+y).val(x1);
              $("#com2_"+y).val(x2);
              $("#com3_"+y).val(x3);
              $("#com4_"+y).val(x4);
              $("#com5_"+y).val(x5);
              y++;
              y = y+2;
              $("#c_com").val(y);
            }
            tot_com = tot_com+con_com;
            suma4();
            if (contador == "1")
            {
              $("#n_com").val(z);
            }
          }
          // Combustible adicional
          var con_con = 0;
          if (p1 == "42")
          {
            y = tot_con;
            var var_3 = p3.split("#");
            var var_4 = var_3[0];
            var var_5 = var_4.split("&");
            var var_6 = var_3[1];
            var var_7 = var_6.split("&");
            var var_8 = var_3[2];
            var var_9 = var_8.split("&");
            var var_10 = var_3[3];
            var var_11 = var_10.split("&");
            var var_12 = var_3[4];
            var var_13 = var_12.split("&");
            var var_14 = var_5.length-1;
            for (var j=0; j<var_14; j++)
            {
              agrega41();
              con_con ++;
              var x1 = var_5[j];
              var x2 = var_7[j];
              var x3 = var_9[j];
              var x4 = var_11[j];
              var x5 = var_13[j];
              if (contador1 > 1)
              {
                y = $("#c_con").val();
                y = parseInt(y);
              }
              $("#con1_"+y).val(x1);
              $("#con2_"+y).val(x2);
              $("#con3_"+y).val(x3);
              $("#con4_"+y).val(x4);
              $("#con5_"+y).val(x5);
              y++;
              y = y+2;
              $("#c_con").val(y);
            }
            tot_con = tot_con+con_con;
            suma41();
            if (contador1 == "1")
            {
              $("#n_con").val(z);
            }
          }
          // 
          if (p1 == "37")
          {
            y = 0;
            var var_3 = p3.split("#");
            var var_4 = var_3[0];
            var var_5 = var_4.split("&");
            var var_6 = var_3[1];
            var var_7 = var_6.split("&");
            var var_8 = var_3[2];
            var var_9 = var_8.split("&");
            var var_10 = var_3[5];
            var var_11 = var_10.split("&");
            var var_12 = var_3[6];
            var var_13 = var_12.split("&");
            var var_14 = var_3[7];
            var var_15 = var_14.split("&");
            var var_16 = var_3[10];
            var var_17 = var_16.split("&");
            var var_18 = var_3[11];
            var var_19 = var_18.split("&");
            var var_20 = var_3[12];
            var var_21 = var_20.split("&");
            var var_22 = var_3[3];
            var var_23 = var_22.split("&");
            var var_24 = var_3[4];
            var var_25 = var_24.split("&");
            var var_26 = var_3[8];
            var var_27 = var_26.split("&");
            var var_28 = var_3[9];
            var var_29 = var_28.split("&");
            var var_30 = var_5.length-1;
            for (var j=0; j<var_30; j++)
            {
              agrega5();
              var x1 = var_5[j];
              var x2 = var_7[j];
              var x3 = var_9[j];
              var x4 = var_11[j];
              var x5 = var_13[j];
              var x6 = var_15[j];
              var x7 = var_17[j];
              var x8 = var_19[j];
              var x9 = var_21[j];
              var x10 = parseFloat(x5)+parseFloat(x8);
              var x11 = x10.toFixed(2);
              x11 = parseFloat(x11);
              var x12 = x11.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
              var x13 = var_23[j];
              var x14 = var_25[j];
              var x15 = var_27[j];
              var x16 = var_29[j];
              $("#gra1_"+y).val(x1);
              $("#gra2_"+y).val(x2);
              $("#gra3_"+y).val(x3);
              $("#gra4_"+y).val(x4);
              $("#gra5_"+y).val(x5);
              $("#gra6_"+y).val(x9);
              $("#gra7_"+y).val(x6);
              $("#gra8_"+y).val(x7);
              $("#gra9_"+y).val(x8);
              $("#gra10_"+y).val(x12);
              $("#gra11_"+y).val(x11);
              $("#gra12_"+y).val(x13);
              $("#gra13_"+y).val(x14);
              $("#gra14_"+y).val(x15);
              $("#gra15_"+y).val(x16);
              y++;
              y = y+4;
            }
            suma5_1();
          }
          // Mantenimiento y Repuestos
          var con_man = 0;
          if (p1 == "38")
          {
            y = tot_man;
            var var_3 = p3.split("#");
            var var_4 = var_3[0];
            var var_5 = var_4.split("&");
            var var_6 = var_3[1];
            var var_7 = var_6.split("&");
            var var_8 = var_3[2];
            var var_9 = var_8.split("&");
            var var_10 = var_3[5];
            var var_11 = var_10.split("&");
            var var_12 = var_3[6];
            var var_13 = var_12.split("&");
            var var_14 = var_3[7];
            var var_15 = var_14.split("&");
            var var_16 = var_3[8];
            var var_17 = var_16.split("&");
            var var_18 = var_3[9];
            var var_19 = var_18.split("&");
            var var_20 = var_3[12];
            var var_21 = var_20.split("&");
            var var_22 = var_3[13];
            var var_23 = var_22.split("&");
            var var_24 = var_3[14];
            var var_25 = var_24.split("&");
            var var_26 = var_3[3];
            var var_27 = var_26.split("&");
            var var_28 = var_3[4];
            var var_29 = var_28.split("&");
            var var_30 = var_3[10];
            var var_31 = var_30.split("&");
            var var_32 = var_3[11];
            var var_33 = var_32.split("&");
            var var_im = var_3[16];
            if (var_im == null)
            {
              var_im = "0";
            }
            var_im = parseFloat(var_im);
            // Iva Mantenimiento
            $("#paso19").val(var_im);
            var var_34 = var_5.length-1;
            for (var j=0; j<var_34; j++)
            {
              agrega6();
              con_man ++;
              var x1 = var_5[j];
              var x2 = var_7[j];
              var x3 = var_9[j];
              x3 = parseInt(x3);
              var x4 = var_11[j];
              var x5 = var_13[j];
              var x6 = var_15[j];
              var x7 = var_19[j];
              var x8 = var_21[j];
              var x9 = var_23[j];
              var x10 = parseFloat(x5)+parseFloat(x9);
              var x11 = x10.toFixed(2);
              x11 = parseFloat(x11);
              var x12 = x11.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
              var x13 = var_17[j];
              if (x13 == "")
              {
                x13 = 0;
              }
              var x15 = var_27[j];
              var x16 = var_29[j];
              var x17 = var_31[j];
              var x18 = var_33[j];
              if (contador4 > 1)
              {
                y = $("#c_man").val();
                y = parseInt(y);
              }
              $("#man1_"+y).val(x1);
              $("#man2_"+y).val(x2);
              $("#man3_"+y).val(x3);
              $("#man4_"+y).val(x4);
              $("#man5_"+y).val(x5);
              $("#man6_"+y).val(x7);
              $("#man7_"+y).val(x6);
              $("#man8_"+y).val(x8);
              $("#man9_"+y).val(x9);
              $("#man10_"+y).val(x12);
              $("#man11_"+y).val(x11);
              $("#man12_"+y).val(x15);
              $("#man13_"+y).val(x16);
              $("#man14_"+y).val(x17);
              $("#man15_"+y).val(x18);
              $("#man18_"+y).val(x13);
              var x14 = $('#man18_'+y+' option:selected').html();
              if (x14 === undefined)
              {
                x14 = "OTRO";
              }
              else
              {
                x14 = x14.trim()+" - "+x7;
              }
              $("#man6_"+y).val(x14);
              y++;
              y = y+4;
              $("#c_man").val(y);
            }
            tot_man = tot_man+con_man;
            suma6_1();
            if (contador4 == "1")
            {
              $("#n_man").val(z);
            }
          }
          // Mantenimiento y Repuestos Adicional
          var con_mam = 0;
          if (p1 == "44")
          {
            y = tot_mam;
            var var_3 = p3.split("#");
            var var_4 = var_3[0];
            var var_5 = var_4.split("&");
            var var_6 = var_3[1];
            var var_7 = var_6.split("&");
            var var_8 = var_3[2];
            var var_9 = var_8.split("&");
            var var_10 = var_3[5];
            var var_11 = var_10.split("&");
            var var_12 = var_3[6];
            var var_13 = var_12.split("&");
            var var_14 = var_3[7];
            var var_15 = var_14.split("&");
            var var_16 = var_3[8];
            var var_17 = var_16.split("&");
            var var_18 = var_3[9];
            var var_19 = var_18.split("&");
            var var_20 = var_3[12];
            var var_21 = var_20.split("&");
            var var_22 = var_3[13];
            var var_23 = var_22.split("&");
            var var_24 = var_3[14];
            var var_25 = var_24.split("&");
            var var_26 = var_3[3];
            var var_27 = var_26.split("&");
            var var_28 = var_3[4];
            var var_29 = var_28.split("&");
            var var_30 = var_3[10];
            var var_31 = var_30.split("&");
            var var_32 = var_3[11];
            var var_33 = var_32.split("&");
            var var_in = var_3[16];
            if (var_in == null)
            {
              var_in = "0";
            }
            var_in = parseFloat(var_in);
            // Iva Mantenimiento
            $("#paso20").val(var_in);
            var var_34 = var_5.length-1;
            for (var j=0; j<var_34; j++)
            {
              agrega61();
              con_mam ++;
              var x1 = var_5[j];
              var x2 = var_7[j];
              var x3 = var_9[j];
              x3 = parseInt(x3);
              var x4 = var_11[j];
              var x5 = var_13[j];
              var x6 = var_15[j];
              var x7 = var_19[j];
              var x8 = var_21[j];
              var x9 = var_23[j];
              var x10 = parseFloat(x5)+parseFloat(x9);
              var x11 = x10.toFixed(2);
              x11 = parseFloat(x11);
              var x12 = x11.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
              var x13 = var_17[j];
              if (x13 == "")
              {
                x13 = 0;
              }
              var x15 = var_27[j];
              var x16 = var_29[j];
              var x17 = var_31[j];
              var x18 = var_33[j];
              if (contador5 > 1)
              {
                y = $("#c_mam").val();
                y = parseInt(y);
              }
              $("#mam1_"+y).val(x1);
              $("#mam2_"+y).val(x2);
              $("#mam3_"+y).val(x3);
              $("#mam4_"+y).val(x4);
              $("#mam5_"+y).val(x5);
              $("#mam6_"+y).val(x7);
              $("#mam7_"+y).val(x6);
              $("#mam8_"+y).val(x8);
              $("#mam9_"+y).val(x9);
              $("#mam10_"+y).val(x12);
              $("#mam11_"+y).val(x11);
              $("#mam12_"+y).val(x15);
              $("#mam13_"+y).val(x16);
              $("#mam14_"+y).val(x17);
              $("#mam15_"+y).val(x18);
              $("#mam18_"+y).val(x13);
              var x14 = $('#mam18_'+y+' option:selected').html();
              if (x14 === undefined)
              {
                x14 = "OTRO";
              }
              else
              {
                x14 = x14.trim()+" - "+x7;
              }
              $("#mam6_"+y).val(x14);
              y++;
              y = y+4;
              $("#c_mam").val(y);
            }
            tot_mam = tot_mam+con_mam;
            suma61_1();
            if (contador5 == "1")
            {
              $("#n_mam").val(z);
            }
          }
          // Llantas
          var con_lla = 0;
          if (p1 == "40")
          {
            y = tot_lla;
            var var_3 = p3.split("#");
            var var_4 = var_3[0];
            var var_5 = var_4.split("&");
            var var_6 = var_3[1];
            var var_7 = var_6.split("&");
            var var_8 = var_3[2];
            var var_9 = var_8.split("&");
            var var_10 = var_3[5];
            var var_11 = var_10.split("&");
            var var_12 = var_3[6];
            var var_13 = var_12.split("&");
            var var_14 = var_3[7];
            var var_15 = var_14.split("&");
            var var_16 = var_3[8];
            var var_17 = var_16.split("&");
            var var_18 = var_3[9];
            var var_19 = var_18.split("&");
            var var_20 = var_3[10];
            var var_21 = var_20.split("&");
            var var_22 = var_3[11];
            var var_23 = var_22.split("&");
            var var_24 = var_3[12];
            var var_25 = var_24.split("&");
            var var_26 = var_3[3];
            var var_27 = var_26.split("&");
            var var_28 = var_3[4];
            var var_29 = var_28.split("&");
            var var_30 = var_5.length-1;
            for (var j=0; j<var_30; j++)
            {
              agrega8();
              con_lla ++;
              var x1 = var_5[j];
              var x2 = var_7[j];
              var x3 = var_9[j];
              var x4 = var_11[j];
              var x5 = var_13[j];
              var x6 = var_15[j];
              var x7 = var_17[j];
              var x8 = var_19[j];
              var x9 = var_21[j];
              var x10 = var_23[j];
              var x11 = var_25[j];
              var x12 = var_27[j];
              var x13 = var_29[j];
              if (contador6 > 1)
              {
                y = $("#c_lla").val();
                y = parseInt(y);
              }
              $("#lla1_"+y).val(x1);
              $("#lla2_"+y).val(x2);
              $("#lla3_"+y).val(x3);
              $("#lla4_"+y).val(x4);
              $("#lla5_"+y).val(x5);
              $("#lla6_"+y).val(x7+" - "+x8+" - "+x9);
              $("#lla7_"+y).val(x6);
              $("#lla8_"+y).val(x10);
              $("#lla9_"+y).val(x11);
              $("#lla10_"+y).val(x12);
              $("#lla11_"+y).val(x13);
              y++;
              y = y+4;
              $("#c_lla").val(y);
            }
            tot_lla = tot_lla+con_lla;
            suma8_1();
            if (contador6 == "1")
            {
              $("#n_lla").val(z);
            }
          }
          // Llantas Adicional
          if (p1 == "46")
          {
            y = 0;
            var var_3 = p3.split("#");
            var var_4 = var_3[0];
            var var_5 = var_4.split("&");
            var var_6 = var_3[1];
            var var_7 = var_6.split("&");
            var var_8 = var_3[2];
            var var_9 = var_8.split("&");
            var var_10 = var_3[5];
            var var_11 = var_10.split("&");
            var var_12 = var_3[6];
            var var_13 = var_12.split("&");
            var var_14 = var_3[7];
            var var_15 = var_14.split("&");
            var var_16 = var_3[8];
            var var_17 = var_16.split("&");
            var var_18 = var_3[9];
            var var_19 = var_18.split("&");
            var var_20 = var_3[10];
            var var_21 = var_20.split("&");
            var var_22 = var_3[11];
            var var_23 = var_22.split("&");
            var var_24 = var_3[12];
            var var_25 = var_24.split("&");
            var var_26 = var_3[3];
            var var_27 = var_26.split("&");
            var var_28 = var_3[4];
            var var_29 = var_28.split("&");
            var var_30 = var_5.length-1;
            for (var j=0; j<var_30; j++)
            {
              agrega81();
              var x1 = var_5[j];
              var x2 = var_7[j];
              var x3 = var_9[j];
              var x4 = var_11[j];
              var x5 = var_13[j];
              var x6 = var_15[j];
              var x7 = var_17[j];
              var x8 = var_19[j];
              var x9 = var_21[j];
              var x10 = var_23[j];
              var x11 = var_25[j];
              var x12 = var_27[j];
              var x13 = var_29[j];
              $("#lln1_"+y).val(x1);
              $("#lln2_"+y).val(x2);
              $("#lln3_"+y).val(x3);
              $("#lln4_"+y).val(x4);
              $("#lln5_"+y).val(x5);
              $("#lln6_"+y).val(x7+" - "+x8+" - "+x9);
              $("#lln7_"+y).val(x6);
              $("#lln8_"+y).val(x10);
              $("#lln9_"+y).val(x11);
              $("#lln10_"+y).val(x12);
              $("#lln11_"+y).val(x13);
              y++;
              y = y+4;
            }
            suma81_1();
          }
          // RTM
          var con_rtm = 0;
          if (p1 == "39")
          {
            y = tot_rtm;
            var var_3 = p3.split("#");
            var var_4 = var_3[0];
            var var_5 = var_4.split("&");
            var var_6 = var_3[1];
            var var_7 = var_6.split("&");
            var var_8 = var_3[4];
            var var_9 = var_8.split("&");
            var var_10 = var_3[5];
            var var_11 = var_10.split("&");
            var var_12 = var_3[6];
            var var_13 = var_12.split("&");
            var var_14 = var_3[7];
            var var_15 = var_14.split("&");
            var var_16 = var_3[2];
            var var_17 = var_16.split("&");
            var var_18 = var_3[3];
            var var_19 = var_18.split("&");
            var var_20 = var_5.length-1;
            for (var j=0; j<var_20; j++)
            {
              agrega7();
              con_rtm ++;
              var x1 = var_5[j];
              var x2 = var_7[j];
              var x3 = var_9[j];
              var x4 = var_11[j];
              var x5 = var_13[j];
              var x6 = var_15[j];
              var x7 = var_17[j];
              var x8 = var_19[j];
              if (contador2 > 1)
              {
                y = $("#c_rtm").val();
                y = parseInt(y);
              }
              $("#tec1_"+y).val(x1);
              $("#tec2_"+y).val(x2);
              $("#tec3_"+y).val(x5);
              $("#tec4_"+y).val(x3);
              $("#tec5_"+y).val(x4);
              $("#tec6_"+y).val(x6);
              $("#tec7_"+y).val(x7);
              $("#tec8_"+y).val(x8);
              y++;
              y = y+3;
              $("#c_rtm").val(y);
            }
            tot_rtm = tot_rtm+con_rtm;
            suma7_1();
            if (contador2 == "1")
            {
              $("#n_rtm").val(z);
            }
          }
          // RTM Adicional
          var con_rtn = 0;
          if (p1 == "45")
          {
            y = tot_rtn;
            var var_3 = p3.split("#");
            var var_4 = var_3[0];
            var var_5 = var_4.split("&");
            var var_6 = var_3[1];
            var var_7 = var_6.split("&");
            var var_8 = var_3[4];
            var var_9 = var_8.split("&");
            var var_10 = var_3[5];
            var var_11 = var_10.split("&");
            var var_12 = var_3[6];
            var var_13 = var_12.split("&");
            var var_14 = var_3[7];
            var var_15 = var_14.split("&");
            var var_16 = var_3[2];
            var var_17 = var_16.split("&");
            var var_18 = var_3[3];
            var var_19 = var_18.split("&");
            var var_20 = var_5.length-1;
            for (var j=0; j<var_20; j++)
            {
              agrega71();
              con_rtn ++;
              var x1 = var_5[j];
              var x2 = var_7[j];
              var x3 = var_9[j];
              var x4 = var_11[j];
              var x5 = var_13[j];
              var x6 = var_15[j];
              var x7 = var_17[j];
              var x8 = var_19[j];
              if (contador3 > 1)
              {
                y = $("#c_rtn").val();
                y = parseInt(y);
              }
              $("#ted1_"+y).val(x1);
              $("#ted2_"+y).val(x2);
              $("#ted3_"+y).val(x5);
              $("#ted4_"+y).val(x3);
              $("#ted5_"+y).val(x4);
              $("#ted6_"+y).val(x6);
              $("#ted7_"+y).val(x7);
              $("#ted8_"+y).val(x8);
              y++;
              y = y+3;
              $("#c_rtn").val(y);
            }
            tot_rtn = tot_rtn+con_rtn;
            suma71_1();
            if (contador3 == "1")
            {
              $("#n_rtn").val(z);
            }
          }
          var z1 = $("#c_gas").val();
          switch (p1)
          {
            case '18':
              $("#dialogo2").dialog("open");
              $("#dialogo2").closest('.ui-dialog').find(".ui-dialog-titlebar-close").hide();
              break;
            case '36':
              var boton = "<a href='#' onclick='activa(4,"+z1+")'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
              $("#vfa_"+z).val('1');
              break;
            case '37':
              var boton = "<a href='#' onclick='activa(5,"+z1+")'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
              $("#vfa_"+z).val('1');
              break;
            case '38':
              var boton = "<a href='#' onclick='activa(6,"+z1+")'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
              $("#vfa_"+z).val('1');
              break;
            case '39':
              var boton = "<a href='#' onclick='activa(7,"+z1+")'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
              $("#vfa_"+z).val('1');
              break;
            case '40':
              var boton = "<a href='#' onclick='activa(8,"+z1+")'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
              $("#vfa_"+z).val('1');
              break;
            case '42':
              var boton = "<a href='#' onclick='activa(41,"+z1+")'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
              $("#vfa_"+z).val('1');
              break;
            case '44':
              var boton = "<a href='#' onclick='activa(61,"+z1+")'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
              $("#vfa_"+z).val('1');
              break;
            case '45':
              var boton = "<a href='#' onclick='activa(71,"+z1+")'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
              $("#vfa_"+z).val('1');
              break;
            case '46':
              var boton = "<a href='#' onclick='activa(81,"+z1+")'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
              $("#vfa_"+z).val('1');
              break;
            default:
              var boton = "";
              break;
          }
        }
        if (i == (var_ocu1-2))
        {
          if (z > w)
          {
            z = z-w;
          }
        }
        $("#gas_"+z).val(p1);
        // Se actualiza valor registrado de consumo
        if (p1 == "36")
        {
          p2 = combustible1;
        }
        if (p1 == "42")
        {
          p2 = combustible3;
        }
        $("#vag_"+z).val(p2);
        $("#del_"+z).hide();
        $("#gas_"+z).prop("disabled",true);
        $("#bot_"+z).html('');
        $("#bot_"+z).append(boton);
        // Valor registrado por placa de combustible
        $("#v_pla").val(registros.placas);
        $("#v_pla1").val(registros.placas1);
        $("#v_pla2").val(registros.placas2);
        $("#v_pla3").val(registros.placas3);
        // Validación registro combustible en calendario
        if (p1 == "36")
        {
          if (combustible == "0")
          {
            alerta("Movimiento de Partida Mensual de Combustible No Registrada");
            $("#bot_"+z).hide();
          }
        }
        if (p1 == "42")
        {
          if (combustible2 == "0")
          {
            alerta("Movimiento de Suministro de Combustible Adicional No Registrado");
            $("#bot_"+z).hide();
          }
        }
        if (p1 == "1")
        {
          $("#vag_"+z).val(total);
          $("#vag_"+z).prop("disabled",true);
          $("#tip_"+z).prop("disabled",true);
        }
        else
        {
          switch (p1)
          {
            case '2':
            case '5':
            case '6':
            case '7':
            case '8':
            case '10':
            case '18':
              $("#tip_"+z).val('S');
              break;
            case '3':
            case '4':
            case '9':
            case '11':
            case '12':
            case '17':
              $("#tip_"+z).val('N');
              break;
            case '13':
            case '14':
            case '15':
            case '16':
              $("#tip_"+z).val('N');
              break;
            case '36':
            case '37':
            case '38':
            case '39':
            case '40':
            case '42':
            case '44':
            case '45':
            case '46':
              $("#vag_"+z).prop("disabled",true);
              $("#tip_"+z).val('S');
              $("#tip_"+z).prop("disabled",true);
              break;
            default:
              $("#tip_"+z).val('N');
              break;
          }
        }
        // Suma RTM
        if (p1 == "39")
        {
          var t_tecnico = $("#paso_tecnico1").val();
          if (t_tecnico == "0")
          {
            $("#paso_tecnico1").val(z);
          }
          var valida = $("#paso_tecnico1").val();
          var valor = $("#paso_tecnico2").val();
          var valor1 = $("#paso_tecnico3").val();
          $("#vag_"+valida).val(valor);
          $("#vat_"+valida).val(valor1);
        }
        // Suma RTM Adicional
        if (p1 == "45")
        {
          var t_tecnico = $("#paso_tecnido1").val();
          if (t_tecnico == "0")
          {
            $("#paso_tecnido1").val(z);
          }
          var valida = $("#paso_tecnido1").val();
          var valor = $("#paso_tecnido2").val();
          var valor1 = $("#paso_tecnido3").val();
          $("#vag_"+valida).val(valor);
          $("#vat_"+valida).val(valor1);
        }
        // Suma Mantenimientos
        if (p1 == "38")
        {
          var t_manteni = $("#paso_manteni1").val();
          if (t_manteni == "0")
          {
            $("#paso_manteni1").val(z);
          }
          var valida = $("#paso_manteni1").val();
          var valor = $("#paso_manteni2").val();
          var valor1 = $("#paso_manteni3").val();
          $("#vag_"+valida).val(valor);
          $("#vat_"+valida).val(valor1);
        }
        // Suma Mantenimientos Adicional
        if (p1 == "44")
        {
          var t_manteni = $("#paso_mamteni1").val();
          if (t_manteni == "0")
          {
            $("#paso_mamteni1").val(z);
          }
          var valida = $("#paso_mamteni1").val();
          var valor = $("#paso_mamteni2").val();
          var valor1 = $("#paso_mamteni3").val();
          $("#vag_"+valida).val(valor);
          $("#vat_"+valida).val(valor1);
        }
        // Suma Llantas
        if (p1 == "40")
        {
          var t_llantas = $("#paso_llantas1").val();
          if (t_llantas == "0")
          {
            $("#paso_llantas1").val(z);
          }
          var valida = $("#paso_llantas1").val();
          var valor = $("#paso_llantas2").val();
          var valor1 = $("#paso_llantas3").val();
          $("#vag_"+valida).val(valor);
          $("#vat_"+valida).val(valor1);
        }
        paso_val(z);
        suma();
      }
      if (contador4 > 1)
      {
        suma6_1();
        var n_man = $("#n_man").val();
        var valor = $("#paso_manteni2").val();
        var valor1 = $("#paso_manteni3").val();
        $("#vag_"+n_man).val(valor);
        $("#vat_"+n_man).val(valor1);
      }
      var contadorz = 0;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('gas_')!=-1)
        {
          contadorz ++;
        }
      }
      if (z > contadorz)
      {
        z = z-(contadorz-1);
      }
      if (combustible4 > 0)
      {
        z++;
        $("#add_field").click();
        $("#gas_"+z).val('36');
        $("#vag_"+z).val(combustible5);
        paso_val(z);
        suma();
        $("#gas_"+z).prop("disabled",true);
        $("#vag_"+z).prop("disabled",true);
        $("#tip_"+z).val('N');
        $("#tip_"+z).prop("disabled",true);
        $("#del_"+z).hide();
      }
      if (combustible6 > 0)
      {
        z++;
        $("#add_field").click();
        $("#gas_"+z).val('42');
        $("#vag_"+z).val(combustible7);
        paso_val(z);
        suma();
        $("#gas_"+z).prop("disabled",true);
        $("#vag_"+z).prop("disabled",true);
        $("#tip_"+z).val('N');
        $("#tip_"+z).prop("disabled",true);
        $("#del_"+z).hide();
      }
      $("#paso_gasto").val('1');
      paso_val(1);
      suma();
      var vali_valor = $("#valor1").val();
      if (vali_valor == "NaN")
      {
        $("#aceptar").hide();
        var detalle = "<center><h3>No se encontro el Valor Aprobado de la Misión. El Informe de Autorizaci&oacute;n no ha sido generado</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#valor").val('0.00');
      }
      else
      {
        $("#aceptar").show(); 
      }
    }
  });
}
function trae_pagos()
{
  var tipo = "2";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_pago.php",
    data:
    {
      tipo: tipo
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
        if ((codigo == "1") || (codigo == "18") || (codigo == "36") || (codigo == "37") || (codigo == "38") || (codigo == "39") || (codigo == "40") || (codigo == "42") || (codigo == "43") || (codigo == "44") || (codigo == "45") || (codigo == "46"))
        {
        }
        else
        {
          salida1 += "<option value='"+codigo+"'>"+nombre+"</option>";
        }
      }
      $("#paso0").val(salida1);
      $("#paso1").val(salida);
    }
  });
}
function trae_pagos1()
{
  var tipo = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_pago.php",
    data:
    {
      tipo: tipo
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
      $("#paso4").val(salida);
    }
  });
}
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
      $("#paso2").val(salida);
    }
  });
}
// Trae listado de repuestos
function trae_repuestos()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_repuesto.php",
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
      $("#paso14").val(salida);
    }
  });
}
function pregunta1()
{
  var con_fac = $("#t_sol1").val();
  var sin_fac = $("#t_sol2").val();
  var detalle = "<center><h3><font color='#3333ff'>TOTAL GASTOS CON SOPORTES: "+con_fac+"</font></h3></center><center><h3><font color='#ff0000'>TOTAL GASTOS SIN FACTURAS: "+sin_fac+"</font></center></h3><center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function activa(valor, valor1)
{
  var valor, valor1;
  $("#dialogo"+valor).dialog("open");
  if (valor == "4")
  {
    $("#paso_combus1").val(valor1);
    var valor2 = $("#tip_"+valor1).val();
    if (valor2 == "S")
    {
		  for (i=0;i<document.formu4.elements.length;i++)
		  {
		  	$("#com3_"+i).val('0.00');
		  	$("#com4_"+i).val('0');
		  }
    	var valor3 = $("#v_pla").val();
      var var_ocu = valor3.split('#');
      var var_ocu1 = var_ocu.length;
      for (var i=0; i<var_ocu1-1; i++)
      {
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("|");
        var p1 = var_2[0];
        var p2 = var_2[1];
        var p3 = var_2[2];
      	var p4 = parseFloat(p1);
      	p4 = p4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			  for (j=0;j<document.formu4.elements.length;j++)
			  {
			    saux = document.formu4.elements[j].name;
			    if (saux.indexOf('com2_')!=-1)
			    {
			      valor = document.getElementById(saux).value;
			      valor1 = saux.split('_');
			      valor2 = valor1[1];
			      if (valor == p3)
			      {
			      	$("#com3_"+valor2).val(p4);
			      	$("#com4_"+valor2).val(p1);
			      }
			    }
				}
      }
    }
    else
    {
			for (i=0;i<document.formu4.elements.length;i++)
		  {
		  	$("#com3_"+i).val('0.00');
		  	$("#com4_"+i).val('0');
		  }
    	var valor3 = $("#v_pla1").val();
      var var_ocu = valor3.split('#');
      var var_ocu1 = var_ocu.length;
      for (var i=0; i<var_ocu1-1; i++)
      {
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("|");
        var p1 = var_2[0];
        var p2 = var_2[1];
        var p3 = var_2[2];
        var p4 = parseFloat(p1);
        p4 = p4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        for (j=0;j<document.formu4.elements.length;j++)
        {
          saux = document.formu4.elements[j].name;
          if (saux.indexOf('com2_')!=-1)
          {
            valor = document.getElementById(saux).value;
            valor1 = saux.split('_');
            valor2 = valor1[1];
            if (valor == p3)
            {
              $("#com3_"+valor2).val(p4);
              $("#com4_"+valor2).val(p1);
            }
          }
        }
      }
    }
  }
  if (valor == "41")
  {
    $("#paso_conbus1").val(valor1);
    var valor2 = $("#tip_"+valor1).val();
    if (valor2 == "S")
    {
      for (i=0;i<document.formu41.elements.length;i++)
      {
        $("#con3_"+i).val('0.00');
        $("#con4_"+i).val('0');
      }
      var valor3 = $("#v_pla2").val();
      var var_ocu = valor3.split('#');
      var var_ocu1 = var_ocu.length;
      for (var i=0; i<var_ocu1-1; i++)
      {
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("|");
        var p1 = var_2[0];
        var p2 = var_2[1];
        var p3 = var_2[2];
        var p4 = parseFloat(p1);
        p4 = p4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        for (j=0;j<document.formu41.elements.length;j++)
        {
          saux = document.formu41.elements[j].name;
          if (saux.indexOf('con2_')!=-1)
          {
            valor = document.getElementById(saux).value;
            valor1 = saux.split('_');
            valor2 = valor1[1];
            if (valor == p3)
            {
              $("#con3_"+valor2).val(p4);
              $("#con4_"+valor2).val(p1);
            }
          }
        }
      }
    }
    else
    {
      for (i=0;i<document.formu41.elements.length;i++)
      {
        $("#con3_"+i).val('0.00');
        $("#con4_"+i).val('0');
      }
      var valor3 = $("#v_pla3").val();
      var var_ocu = valor3.split('#');
      var var_ocu1 = var_ocu.length;
      for (var i=0; i<var_ocu1-1; i++)
      {
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("|");
        var p1 = var_2[0];
        var p2 = var_2[1];
        var p3 = var_2[2];
        var p4 = parseFloat(p1);
        p4 = p4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        for (j=0;j<document.formu41.elements.length;j++)
        {
          saux = document.formu41.elements[j].name;
          if (saux.indexOf('con2_')!=-1)
          {
            valor = document.getElementById(saux).value;
            valor1 = saux.split('_');
            valor2 = valor1[1];
            if (valor == p3)
            {
              $("#con3_"+valor2).val(p4);
              $("#con4_"+valor2).val(p1);
            }
          }
        }
      }
    }
  }
  if (valor == "5")
  {
    $("#paso_grasas1").val(valor1);
  }
  if (valor == "6")
  {
    $("#paso_manteni1").val(valor1);
  }
  if (valor == "61")
  {
    $("#paso_mamteni1").val(valor1);
  }
  if (valor == "7")
  {
    $("#paso_tecnico1").val(valor1);
  }
  if (valor == "71")
  {
    $("#paso_tecnido1").val(valor1);
  }
  if (valor == "8")
  {
    $("#paso_llantas1").val(valor1);
  }
  if (valor == "81")
  {
    $("#paso_llamtas1").val(valor1);
  }
}
function paso_valor()
{
  var valor;
  valor = $("#valor").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valor1").val(valor);
}
function paso_val(valor)
{
  var valor, valor1;
  if ($("#vag_"+valor).length)
  {
    valor1 = document.getElementById('vag_'+valor).value;
    valor1 = parseFloat(valor1.replace(/,/g,''));
    $("#vat_"+valor).val(valor1);
  }
}
function paso_val1(valor)
{
  var valor;
  var valor1 = document.getElementById('sev_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#set_"+valor).val(valor1);
}
function paso_val2(valor)
{
  var valor;
  var valor1 = document.getElementById('val_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vam_"+valor).val(valor1);
}
function paso_val3(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('vag1_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vat1_"+valor).val(valor1);
}
function paso_val4(valor)
{
  var valor, valor1, valor2, valor3; 
  valor1 = valor.split('_');
  valor2 = $("#val_"+valor1[1]).val();
  valor3 = parseFloat(valor2.replace(/,/g,''));
  $("#vam_"+valor1[1]).val(valor3);
}
function valida1(valor)
{
  var valor;
  var valor1 = document.getElementById('val_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  var valor2 = document.getElementById('set_'+valor).value;
  var valor3 = valor1-valor2;
  if (valor3 < 0)
  {
    $("#sev_"+valor).val('0.00');
    paso_val1(valor);
  }
}
function valida2(valor)
{
  var valor;
  var valor1 = document.getElementById('val_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  var valor2 = document.getElementById('van_'+valor).value;
  var valor3 = valor1-valor2;
  if (valor3 > 0)
  {
    var valor4 = parseFloat(valor2)
    valor4 = valor4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $("#val_"+valor).val(valor4);
    paso_val2(valor);
  }
  var valor5 = $("#paso5").val();
  var var_ocu = valor5.split(',');
  var var_ocu1 = var_ocu.length;
  var valor6 = var_ocu[0];
  valor6 = parseInt(valor6);
  valor6 = valor6+1;
  calculo(valor6);
  suma();
}
function calculo(valor)
{
  var valor, valor1, valor2, valor3;
  var suma = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('val_')!=-1)
    {
      paso_val4(saux);
      valor1 = saux.split('_');
      valor2 = $("#vam_"+valor1[1]).val();
      valor2 = parseFloat(valor2);
      suma = suma+valor2;
    }
  }
  valor3 = suma.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#vag_"+valor).val(valor3);
  $("#vat_"+valor).val(suma);
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
  valor4 = parseFloat(valor3).toFixed(2);
  $("#valor2").val(valor4);
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_sol").val(valor3);
  suma1();
  suma2();
}
function suma1()
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
      saux1 = saux.substr(4);
      saux2 = $("#tip_"+saux1).val();
      if (saux2 == "S")
      {
        valor2 = document.getElementById(saux).value;
        valor2 = parseFloat(valor2);
        valor3 = valor3+valor2;
      }
    }
  }
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_sol1").val(valor3);
}
function suma2()
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
      saux1 = saux.substr(4);
      saux2 = $("#tip_"+saux1).val();
      if (saux2 == "N")
      {
        valor2 = document.getElementById(saux).value;
        valor2 = parseFloat(valor2);
        valor3 = valor3+valor2;
      }
    }
  }
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_sol2").val(valor3);
}
function suma3()
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
    if (saux.indexOf('vat1_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      valor2 = parseFloat(valor2);
      valor3 = valor3+valor2;
    }
  }
  $("#valor3").val(valor3);
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_sol3").val(valor3);
}
function veri(valor)
{
  var valor, valor1, z;
  z = valor;
  valor1 = $("#gas_"+valor).val();
  switch (valor1)
  {
    case '1':
    case '2':
    case '5':
    case '6':
    case '7':
    case '8':
    case '10':
    case '18':
      $("#tip_"+z).val('S');
      break;
    case '3':
    case '4':
    case '9':
    case '11':
    case '12':
    case '17':
      $("#tip_"+z).val('N');
      break;
    case '13':
    case '14':
    case '15':
    case '16':
      $("#tip_"+z).val('N');
      break;
    default:
      $("#tip_"+z).val('N');
      break;
  }      
  suma();
}
function borra(valor)
{
  var valor;
  $("#gas_"+valor).val('0');
  $("#gas_"+valor).hide();
  $("#vag_"+valor).val('0');
  $("#vag_"+valor).hide();
  $("#vat_"+valor).val('0');
  $("#vat_"+valor).hide();
  $("#tip_"+valor).val('');
  $("#tip_"+valor).hide();
  $("#vfa_"+valor).val('');
  $("#vfa_"+valor).hide();
  $("#del_"+valor).hide();
  suma();
}
function borra1(valor)
{
  var valor;
  $("#gas1_"+valor).val('0');
  $("#gas1_"+valor).hide();
  $("#vag1_"+valor).val('0');
  $("#vag1_"+valor).hide();
  $("#vat1_"+valor).val('0');
  $("#vat1_"+valor).hide();
  $("#tip1_"+valor).val('');
  $("#tip1_"+valor).hide();
  $("#vfa1_"+valor).val('');
  $("#vfa1_"+valor).hide();
  $("#del1_"+valor).hide();
  suma3();
}
function paso()
{
  var paso = $("#mision option:selected").html();
  $("#n_ordop").val(paso);
  document.getElementById('conceptos').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('gas_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('conceptos').value=document.getElementById('conceptos').value+valor+"|";
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
  document.getElementById('tipoc').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('tip_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('tipoc').value=document.getElementById('tipoc').value+valor+"|";
    }
  }
  // Reintegros
  document.getElementById('conceptos1').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('gas1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('conceptos1').value=document.getElementById('conceptos1').value+valor+"|";
    }
  }
  document.getElementById('valores2').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vag1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('valores2').value=document.getElementById('valores2').value+valor+"|";
    }
  }
  document.getElementById('valores3').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vat1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('valores3').value=document.getElementById('valores3').value+valor+"|";
    }
  }
  document.getElementById('tipoc1').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('tip1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('tipoc1').value=document.getElementById('tipoc1').value+valor+"|";
    }
  }
  validacionData();
}
function validacionData()
{
  var salida = true, detalle = '';
  var comprueba1 = $("#v_usuario").val().trim().length;
  if (comprueba1 == '0')
  {
    salida = false;
    detalle += "<center><h3>Usuario No Valido</h3></center>";
  }
  var comprueba2 = $("#v_unidad").val().trim().length;
  var comprueba3 = $("#v_unidad").val();
  if ((comprueba2 == '0') || (comprueba3 == '0'))
  {
    salida = false;
    detalle += "<center><h3>Unidad No Valida</h3></center>";
  }
  var comprueba4 = $("#v_ciudad").val().trim().length;
  if (comprueba4 == '0')
  {
    salida = false;
    detalle += "<center><h3>Ciudad No Valida</h3></center>";
  }
  if ($("#t_sol").val() == '0.00')
  {
    salida = false;
    detalle += "<center><h3>Total de Gastos No Valido</h3></center>";
  }
  // Se validan valor mision y total de gastos
  var valida = $("#valor1").val();
  valida = parseFloat(valida);
  var valida1 = $("#valor2").val();
  valida1 = parseFloat(valida1);
  if (valida1 > valida)
  {
    salida = false;
    detalle += "<center><h3>Total Gastos superior al Valor Aprobado de la Misión</h3></center>";
  }
  if (valida > valida1)
  {
    salida = false;
    detalle += "<center><h3>Valor Aprobado de la Misión superior a Total Gastos</h3></center>";
  }
  var v_responsable = $("#responsable").val();
  v_responsable = v_responsable.trim().length;
  if (v_responsable == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar un Responsable</h3></center>";
    $("#responsable").addClass("ui-state-error");
  }
  else
  {
    $("#responsable").removeClass("ui-state-error");
  }
  var v_comandante = $("#comandante").val();
  v_comandante = v_comandante.trim().length;
  if (v_comandante == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Nombre del Comandante</h3></center>";
    $("#comandante").addClass("ui-state-error");
  }
  else
  {
    $("#comandante").removeClass("ui-state-error");
  }
  var v_comandante1 = $("#comandante1").val();
  v_comandante1 = v_comandante1.trim().length;
  if (v_comandante1 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Cargo del Comandante</h3></center>";
    $("#comandante1").addClass("ui-state-error");
  }
  else
  {
    $("#comandante1").removeClass("ui-state-error");
  }
  var v_elaboro = $("#elaboro").val();
  v_elaboro = v_elaboro.trim().length;
  if (v_elaboro == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Persona que Elaboró</h3></center>";
    $("#elaboro").addClass("ui-state-error");
  }
  else
  {
    $("#elaboro").removeClass("ui-state-error");
  }
  var v_reviso = $("#reviso").val();
  v_reviso = v_reviso.trim().length;
  if (v_reviso == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Persona que Revisó</h3></center>";
    $("#reviso").addClass("ui-state-error");
  }
  else
  {
    $("#reviso").removeClass("ui-state-error");
  }
  var facturas = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vfa_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (valor == "1")
      {
        facturas++;
      }
    }
  }
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('tip_')!=-1)
    {
      valorn = document.getElementById(saux).value;
      if (valorn == "N")
      {
        facturas--;
      }
    }
  }
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('gas_')!=-1)
    {
      valorg = document.getElementById(saux).value;
      if (valorg == "21")
      {
        facturas--;
      }
    }
  }
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vat_')!=-1)
    {
      valort = document.getElementById(saux).value;
      if (valort == "0")
      {
        facturas--;
      }
    }
  }
  if (facturas > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+facturas+" Factura(s) de Conceptos</h3></center>"; 
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
    var mision1 = $("#paso8").val();
    var mision2 = $("#paso7").val();
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "rgas_grab.php",
      data:
      {
        n_ordop: $("#n_ordop").val(), 
        mision: $("#mision").val(),
        mision1: mision1,
        mision2: mision2,
        responsable: $("#responsable").val(),
        comandante: $("#comandante").val(),
        comandante1: $("#comandante1").val(),
        tipo: $("#tipo").val(),
        comprobante: $("#compro").val(),
        comprobante1: $("#compro1").val(),
        conceptos: $("#conceptos").val(),
        valores: $("#valores").val(),
        valores1: $("#valores1").val(),
        tipoc: $("#tipoc").val(),
        conceptos1: $("#conceptos1").val(),
        valores2: $("#valores2").val(),
        valores3: $("#valores3").val(),
        tipoc1: $("#tipoc1").val(),
        t_sol: $("#t_sol").val(),
        t_sol1: $("#t_sol1").val(),
        t_sol2: $("#t_sol2").val(),
        t_sol3: $("#t_sol3").val(),
        centra: $("#centra").val(),
        periodo: $("#periodo").val(),
        bienes: $("#paso_bienes").val(),
        combustible: $("#paso_combus").val(),
        combustiblea: $("#paso_conbus").val(),
        grasas: $("#paso_grasas").val(),
        mantenimiento: $("#paso_manteni").val(),
        mantenimientoa: $("#paso_mamteni").val(),
        tecnico: $("#paso_tecnico").val(),
        tecnicoa: $("#paso_tecnido").val(),
        llantas: $("#paso_llantas").val(),
        llantasa: $("#paso_llamtas").val(),
        facturas: $("#paso6").val(),
        elaboro: $("#elaboro").val(),
        reviso: $("#reviso").val(),
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
        valida1 = registros.salida1;
        if (valida > 0)
        {
          $("#aceptar").hide();
          $("#aceptar2").show();
          $("#plan_conse").val(valida);
          $("#plan_ano").val(valida1);
          $("#compro").prop("disabled",true);
          $("#responsable").prop("disabled",true);
          $("#comandante").prop("disabled",true);
          $("#comandante1").prop("disabled",true);
          $("#periodo").prop("disabled",true);
          $("#elaboro").prop("disabled",true);
          $("#reviso").prop("disabled",true);
          for (i=0;i<document.formu.elements.length;i++)
          {
            saux = document.formu.elements[i].name;
            if (saux.indexOf('gas_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            if (saux.indexOf('vag_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            if (saux.indexOf('tip_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
          for (j=1;j<=40;j++)
          {
            if ($("#del_"+j).length)
            {
              $("#del_"+j).hide();
            }
          }
          $("#add_field").hide();
          $("#add_field2").hide();
        }
        else
        {
          $("#v_click").val('0');
          detalle = "<center><h3>Error durante la grabación</center></h2>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#aceptar").show();
        }
      }
    });
  }
}
function link()
{
  var valor, valor1, valor2;
  valor = $("#plan_conse").val();
  valor1 = $("#tipo").val();
  valor2 = $("#n_ano").val();
  $("#plan_conse").val(valor);
  $("#plan_tipo").val(valor1);
  $("#plan_ano").val(valor2);
  formu3.submit();
}
function link1(valor, tipo, ano)
{
  var valor;
  var tipo;
  var ano;
  $("#plan_conse").val(valor);
  $("#plan_tipo").val(tipo);
  $("#plan_ano").val(ano);
  formu3.submit();
}
function link2(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  var url = "<a href='./ver_cargas.php?v1="+valor+"&v2="+valor1+"&v3="+valor2+"' name='lnk1' id='lnk1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnk1").click();
}
function modif(valor, tipo, ano, index)
{
  var valor, tipo, ano, index;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "rela_consu2.php",
    data:
    {
      valor: valor,
      tipo: tipo,
      ano: ano
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var responsable = registros.responsable;
      var comandante = registros.comandante;
      var var_ocu = comandante.split('»');
      var nombre = var_ocu[0];
      var cargo = var_ocu[1];
      var elaboro = registros.elaboro;
      var reviso = registros.reviso;
      $("#c_responsable").val(responsable);
      $("#c_nombre").val(nombre);
      $("#c_cargo").val(cargo);
      $("#c_elaboro").val(elaboro);
      $("#c_reviso").val(reviso);
      $("#c_index").val(index);
      $("#c_valor").val(valor);
      $("#c_ano").val(ano);
      $("#dialogo3").dialog("open");
    }
  });
}
function actualizar()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "rgas_actu.php",
    data:
    {
      conse: $("#c_valor").val(),
      ano: $("#c_ano").val(),
      responsable: $("#c_responsable").val(),
      nombre: $("#c_nombre").val(),
      cargo: $("#c_cargo").val(),
      elaboro: $("#c_elaboro").val(),
      reviso: $("#c_reviso").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      var index = $("#c_index").val();
      if (salida == "1")
      {
        $("#act_"+index).hide();
        $("#dialogo3").dialog("close");
      }
    }
  });
}
function consultar()
{
  var tipo1 = $("#tipo").val();
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
      url: "rela_consu.php",
      data:
      {
        tipo: $("#tipo").val(),
        fecha1: $("#fecha1").val(),
        fecha2: $("#fecha2").val()
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
        var valida,valida1;
        var salida1 = "";
        var salida2 = "";
        listareg = [];
        valida = registros.salida;
        valida1 = registros.total;
        salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
        salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='5%'><b>No.</b></td><td height='35' width='8%'><b>Fecha</b></td><td height='35' width='10%'><b>Unidad</b></td><td height='35' width='10%'><b>Usuario</b></td><td height='35' width='20%'><b>Ordop</b></td><td height='35' width='20%'><b>Misi&oacute;n</b></td><td height='35' width='10%'><b>Total</b></td><td height='35' width='3%'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td></tr></table>";
        salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
        $.each(registros.rows, function (index, value)
        {
          var datos = '\"'+value.conse+'\",\"'+value.consecu+'\",\"'+value.ano+'\"';
          salida2 += "<tr><td height='35' width='5%' id='l1_"+index+"'>"+value.conse+"</td>";
          salida2 += "<td height='35' width='8%' id='l2_"+index+"'>"+value.fecha+"</td>";
          salida2 += "<td height='35' width='10%' id='l3_"+index+"'>"+value.unidad+"</td>";
          salida2 += "<td height='35' width='10%' id='l4_"+index+"'>"+value.usuario+"</td>";
          salida2 += "<td height='35' width='20%' id='l5_"+index+"'>"+value.ordop+"</td>";
          salida2 += "<td height='35' width='20%' id='l6_"+index+"'>"+value.mision+"</td>";
          salida2 += "<td height='35' width='10%' align='right' id='l7_"+index+"'>"+value.total+"</td>";
          salida2 += "<td height='35' width='1%' id='l8_"+index+"'>&nbsp;</td>";
          salida2 += "<td height='35' width='5%' id='l9_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); link1("+value.conse+","+tipo1+","+value.ano+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td>";
          salida2 += "<td height='35' width='5%' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); link2("+datos+")'><img src='dist/img/factura.png' width='25' height='25' border='0' title='Facturas'></a></center></td>";
          if (super1 == "1")
          {
            salida2 += "<td height='35' width='5%' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",11); modif("+value.conse+","+tipo1+","+value.ano+","+index+")'><img src='dist/img/editar.png' name='act_"+index+"' id='act_"+index+"' width='27' height='27' border='0' title='Modificar'></a></center></td>";
          }
          else
          {
            salida2 += "<td height='35' width='5%' id='l11_"+index+"'>&nbsp;</td>";
          }
          listareg.push(index);
        });
        salida2 += "</table>";
        $("#tabla3").append(salida1);
        $("#resultados5").append(salida2);
      }
    });
  }
}
function agrega()
{
  var InputsWrapper = $("#add_form1 table tr");
  var x = InputsWrapper.length;
  var FieldCount = 1;
  if(x <= 999)
  {
    var y = x;
    var paso1 = $("#paso2").val();
    var paso2 = $("#v_unidad").val();
    var alea = $("#alea").val();
    FieldCount++;
    $("#add_form1 table").append('<tr><td colspan="5" class="espacio1"><center><font face="Verdana" size="3"><b>Datos del Bien</b></font></center></td></tr><td colspan="3" class="espacio1"><label><font face="Verdana" size="2">Nombre del Bien</font></label><input type="hidden" name="cla_'+y+'" id="cla_'+y+'" class="form-control numero" readonly="readonly"><input type="text" name="nom_'+y+'" id="nom_'+y+'" class="form-control" maxlength="50" readonly="readonly"></td><td width="1%">&nbsp;</td><td align="right"><label><font face="Verdana" size="2">Factura Bien</font></label><br><a href="#" name="lnk_'+y+'" id="lnk_'+y+'" onclick="cargar('+y+');"><img src="imagenes/clip.png" border="0" title="Anexar Factura"></a><input type="hidden" name="ale_'+y+'" id="ale_'+y+'" class="form-control numero" value="'+alea+'_'+y+'" readonly="readonly"><input type="hidden" name="car_'+y+'" id="car_'+y+'" class="form-control numero" value="0" readonly="readonly"></td></tr><tr><td colspan="5" class="espacio1"><label><font face="Verdana" size="2">Descripci&oacute;n</font></label><textarea name="des_'+y+'" id="des_'+y+'" class="form-control" rows="3" onblur="val_caracteres('+y+'); javascript:this.value=this.value.toUpperCase();"></textarea></td></tr><tr><td width="32%" class="espacio1"><label><font face="Verdana" size="2">Fecha de Compra</font></label><input type="text" name="fec_'+y+'" id="fec_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Valor</font></label><input type="text" name="val_'+y+'" id="val_'+y+'" class="form-control numero" onkeyup="paso_val2('+y+'); valida2('+y+')"><input type="hidden" name="vam_'+y+'" id="vam_'+y+'" class="form-control numero" value="0"><input type="hidden" name="van_'+y+'" id="van_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="34%"><label><font face="Verdana" size="2">Marca</font></label><input type="text" name="mar_'+y+'" id="mar_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td></tr><tr><td width="32%" class="espacio1"><label><font face="Verdana" size="2">Color</font></label><input type="text" name="col_'+y+'" id="col_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Modelo</font></label><input type="text" name="mod_'+y+'" id="mod_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="34%"><label><font face="Verdana" size="2">Serial</font></label><input type="text" name="ser_'+y+'" id="ser_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td></tr><tr><td width="32%" class="espacio1"><label><font face="Verdana" size="2">No. SOAT</font></label><input type="text" name="son_'+y+'" id="son_'+y+'" class="form-control" maxlength="25" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Aseguradora</font></label><input type="text" name="soa_'+y+'" id="soa_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="34%"><label><font face="Verdana" size="2">Vigencia</font></label><input type="text" name="so1_'+y+'" id="so1_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"><div class="espacio1"></div><input type="text" name="so2_'+y+'" id="so2_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td></tr><tr><td width="32%" class="espacio1"><label><font face="Verdana" size="2">Clase de Seguro</font></label><input type="text" name="sec_'+y+'" id="sec_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Valor Seguro</font></label><input type="text" name="sev_'+y+'" id="sev_'+y+'" class="form-control numero" value="0.00" onkeyup="paso_val1('+y+'); valida1('+y+');"><input type="hidden" name="set_'+y+'" id="set_'+y+'" class="form-control numero" value="0"></td></tr><tr><td width="32%" class="espacio1"><label><font face="Verdana" size="2">No. Seguro</font></label><input type="text" name="sen_'+y+'" id="sen_'+y+'" class="form-control" maxlength="25" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Aseguradora</font></label><input type="text" name="sea_'+y+'" id="sea_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="34%"><label><font face="Verdana" size="2">Vigencia</font></label><input type="text" name="se1_'+y+'" id="se1_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"><div class="espacio1"></div><input type="text" name="se2_'+y+'" id="se2_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td></tr><tr><td colspan="1" class="espacio1"><label><font face="Verdana" size="2">Ubicaci&oacute;n del Bien</font></label><select name="ubi_'+y+'" id="ubi_'+y+'" class="form-control select2" readonly="readonly"></select></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Funcionario realiz&oacute; la compra</font></label><input type="text" name="fun_'+y+'" id="fun_'+y+'" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="34%"><label><font face="Verdana" size="2">Estado del Bien</font></label><select name="est_'+y+'" id="est_'+y+'" class="form-control select2"><option value="1">BUENO</option><option value="2">REGULAR</option><option value="3">DAÑADO</option><option value="4">CONSUMIDO</option><option value="9">PERDIDO</option></select></td></tr><tr><td colspan="1" class="espacio1"><label><font face="Verdana" size="2">ORDOP</font></label><input type="text" name="ord_'+y+'" id="ord_'+y+'" class="form-control" maxlength="50" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="32%"><label><font face="Verdana" size="2">Misi&oacute;n</font></label><input type="text" name="mis_'+y+'" id="mis_'+y+'" class="form-control" maxlength="50" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="34%"><label><font face="Verdana" size="2">Plan / Solicitud</font></label><input type="text" name="pla_'+y+'" id="pla_'+y+'" class="form-control" readonly="readonly"></tr><tr><td colspan="5"><hr></td></tr>');
    x++;
    $("#fec_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      maxDate: 0,
      changeYear: true,
      changeMonth: true
    });
    $("#so1_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      changeYear: true,
      changeMonth: true,
      onSelect: function () {
        $("#so2_"+y).prop("disabled",false);
        $("#so2_"+y).datepicker("destroy");
        $("#so2_"+y).val('');
        $("#so2_"+y).datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#so1_"+y).val(),
          changeYear: true,
          changeMonth: true
        });
      },
    });
    $("#se1_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      changeYear: true,
      changeMonth: true,
      onSelect: function () {
        $("#se2_"+y).prop("disabled",false);
        $("#se2_"+y).datepicker("destroy");
        $("#se2_"+y).val('');
        $("#se2_"+y).datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#se1_"+y).val(),
          changeYear: true,
          changeMonth: true
        });
      },
    });
    $("#val_"+y).maskMoney();
    $("#sev_"+y).maskMoney();
    $("#ubi_"+y).append(paso1);
    $("#ubi_"+y).val(paso2);
    $("#nom_"+y).focus();
  }
}
// Combustible
function agrega4()
{
  var InputsWrapper = $("#add_form4 table tr");
  var x = InputsWrapper.length;
  var FieldCount = 1;
  if(x <= 999)
  {
    var y = x;
    var alea = $("#alea").val();
    FieldCount++;
    $("#add_form4 table").append('<tr><td colspan="9" class="espacio1"><center><font face="Verdana" size="3"><b>Datos de Combustible</b></font></center></td></tr><td width="15%" class="espacio1"><label><font face="Verdana" size="2">Clase</font></label><input type="text" name="com1_'+y+'" id="com1_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="12%" class="espacio1"><label><font face="Verdana" size="2">Placa</font></label><input type="text" name="com2_'+y+'" id="com2_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor</font></label><input type="text" name="com3_'+y+'" id="com3_'+y+'" class="form-control numero" onkeyup="paso_valc('+y+'); suma4();"><input type="hidden" name="com4_'+y+'" id="com4_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="40%"><label><font face="Verdana" size="2">Detalles</font></label><input type="text" name="com5_'+y+'" id="com5_'+y+'" class="form-control" readonly="readonly"><input type="hidden" name="alec_'+y+'" id="alec_'+y+'" class="form-control numero" value="'+alea+'_'+y+'" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="9%" align="right"><label><font face="Verdana" size="2">Factura</font></label><br><a href="#" name="lnkc_'+y+'" id="lnkc_'+y+'" onclick="cargac('+y+');"><img src="imagenes/clip.png" border="0" title="Anexar Factura"></a></td></tr><tr><td colspan="9"><hr></td></tr>');
    //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/valor.png" name="img1" id="img1" width="20" border="0" title="Modificar Valor" class="mas" onclick="actu4('+y+');">
    x++;
    $("#com3_"+y).maskMoney();
    $("#com1_"+y).prop("disabled",true);
    $("#com2_"+y).prop("disabled",true);
    $("#com3_"+y).prop("disabled",true);
    $("#com4_"+y).prop("disabled",true);
    $("#com5_"+y).prop("disabled",true);
  }
}
// Combustible Adicional
function agrega41()
{
  var InputsWrapper = $("#add_form41 table tr");
  var x = InputsWrapper.length;
  var FieldCount = 1;
  if(x <= 999)
  {
    var y = x;
    var alea = $("#alea").val();
    FieldCount++;
    $("#add_form41 table").append('<tr><td colspan="9" class="espacio1"><center><font face="Verdana" size="3"><b>Datos de Combustible</b></font></center></td></tr><td width="15%" class="espacio1"><label><font face="Verdana" size="2">Clase</font></label><input type="text" name="con1_'+y+'" id="con1_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="12%" class="espacio1"><label><font face="Verdana" size="2">Placa</font></label><input type="text" name="con2_'+y+'" id="con2_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor</font></label><input type="text" name="con3_'+y+'" id="con3_'+y+'" class="form-control numero" onkeyup="paso_valc1('+y+'); suma41();"><input type="hidden" name="con4_'+y+'" id="con4_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="40%"><label><font face="Verdana" size="2">Detalles</font></label><input type="text" name="con5_'+y+'" id="con5_'+y+'" class="form-control" readonly="readonly"><input type="hidden" name="alecn_'+y+'" id="alecn_'+y+'" class="form-control numero" value="'+alea+'_'+y+'" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="9%" align="right"><label><font face="Verdana" size="2">Factura</font></label><br><a href="#" name="lnkcn_'+y+'" id="lnkcn_'+y+'" onclick="cargacn('+y+');"><img src="imagenes/clip.png" border="0" title="Anexar Factura"></a></td></tr><tr><td colspan="9"><hr></td></tr>');
    //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/valor.png" name="img1" id="img1" width="20" border="0" title="Modificar Valor" class="mas" onclick="actu41('+y+');">
    x++;
    $("#con3_"+y).maskMoney();
    $("#con1_"+y).prop("disabled",true);
    $("#con2_"+y).prop("disabled",true);
    $("#con3_"+y).prop("disabled",true);
    $("#con4_"+y).prop("disabled",true);
    $("#con5_"+y).prop("disabled",true);
  }
}
function agrega5()
{
  var InputsWrapper = $("#add_form5 table tr");
  var x = InputsWrapper.length;
  var FieldCount = 1;
  if(x <= 999)
  {
    var y = x;
    var alea = $("#alea").val();
    FieldCount++;
    $("#add_form5 table").append('<tr><td colspan="11" class="espacio1"><center><font face="Verdana" size="3"><b>Datos de Grasas y Lubricantes</b></font></center></td></tr><td width="15%" class="espacio1"><label><font face="Verdana" size="2">Clase</font></label><input type="text" name="gra1_'+y+'" id="gra1_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="12%" class="espacio1"><label><font face="Verdana" size="2">Placa</font></label><input type="text" name="gra2_'+y+'" id="gra2_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="7%"><label><font face="Verdana" size="2">Cant.</font></label><input type="text" name="gra3_'+y+'" id="gra3_'+y+'" class="form-control numero" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Unitario</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/valor.png" name="img5" id="img5" width="20" border="0" title="Modificar Valor" class="mas" onclick="actu5('+y+');"></label><input type="text" name="gra12_'+y+'" id="gra12_'+y+'" class="form-control numero" onkeyup="paso_val5('+y+'); suma5('+y+');"><input type="hidden" name="gra13_'+y+'" id="gra13_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Total</font></label><input type="text" name="gra4_'+y+'" id="gra4_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="gra5_'+y+'" id="gra5_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%" align="right"><label><font face="Verdana" size="2">Factura</font></label><br><a href="#" name="lnkg_'+y+'" id="lnkg_'+y+'" onclick="cargag('+y+');"><img src="imagenes/clip.png" border="0" title="Anexar Factura"></a></td></tr><tr><td colspan="4" class="espacio1">&nbsp;</td><td><label><font face="Verdana" size="2">I.V.A</font></label><input type="text" name="gra7_'+y+'" id="gra7_'+y+'" class="form-control numero" onkeypress="return check(event);" onkeyup="suma5('+y+');" maxlength="2" autocomplete="off"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Mano de Obra</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chk5_'+y+'" id="chk5_'+y+'" value="1" onclick="suma5('+y+');"></label><input type="text" name="gra14_'+y+'" id="gra14_'+y+'" class="form-control numero" onkeyup="paso_val5_1('+y+'); suma5('+y+');"><input type="hidden" name="gra15_'+y+'" id="gra15_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Mano de Obra Total</font></label><input type="text" name="gra8_'+y+'" id="gra8_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="gra9_'+y+'" id="gra9_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Total</font></label><input type="text" name="gra10_'+y+'" id="gra10_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="gra11_'+y+'" id="gra11_'+y+'" class="form-control numero" value="0" readonly="readonly"></td></tr><tr><td colspan="7" class="espacio1"><label><font face="Verdana" size="2">Detalles</font></label><input type="text" name="gra6_'+y+'" id="gra6_'+y+'" class="form-control" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Fecha Factura</font></label><input type="text" name="gra16_'+y+'" id="gra16_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Nro. Factura</font></label><input type="text" name="gra17_'+y+'" id="gra17_'+y+'" class="form-control numero" onkeypress="return check1(event);" maxlength="25" autocomplete="off"><input type="hidden" name="aleg_'+y+'" id="aleg_'+y+'" class="form-control numero" value="'+alea+'_'+y+'" readonly="readonly"></td></tr><tr><td colspan="11"><hr></td></tr>');
    x++;
    $("#gra4_"+y).maskMoney();
    $("#gra8_"+y).maskMoney();
    $("#gra10_"+y).maskMoney();
    $("#gra12_"+y).maskMoney();
    $("#gra14_"+y).maskMoney();
    $("#gra1_"+y).prop("disabled",true);
    $("#gra2_"+y).prop("disabled",true);
    $("#gra3_"+y).prop("disabled",true);
    $("#gra4_"+y).prop("disabled",true);
    $("#gra5_"+y).prop("disabled",true);
    $("#gra6_"+y).prop("disabled",true);
    $("#gra7_"+y).prop("disabled",true);
    $("#gra8_"+y).prop("disabled",true);
    $("#gra9_"+y).prop("disabled",true);
    $("#gra10_"+y).prop("disabled",true);
    $("#gra11_"+y).prop("disabled",true);
    $("#gra12_"+y).prop("disabled",true);
    $("#gra13_"+y).prop("disabled",true);
    $("#gra14_"+y).prop("disabled",true);
    $("#gra15_"+y).prop("disabled",true);
    $("#gra16_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      maxDate: 0,
      changeYear: true,
      changeMonth: true,
    });
    $("#chk5_"+y).prop("checked",true);
    $("#chk5_"+y).prop("disabled",true);
  }
}
// Mantenimientos
function agrega6()
{
  var InputsWrapper = $("#add_form6 table tr");
  var x = InputsWrapper.length;
  var FieldCount = 1;
  if(x <= 999)
  {
    var y = x;
    var alea = $("#alea").val();
    var pasom = $("#paso14").val();
    FieldCount++;
    $("#add_form6 table").append('<tr><td colspan="11" class="espacio1"><center><font face="Verdana" size="3"><b>Datos de Mantenimiento y Repuestos</b></font></center></td></tr><td width="15%" class="espacio1"><label><font face="Verdana" size="2">Clase</font></label><input type="text" name="man1_'+y+'" id="man1_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="12%" class="espacio1"><label><font face="Verdana" size="2">Placa</font></label><input type="text" name="man2_'+y+'" id="man2_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="8%"><label><font face="Verdana" size="2">Cant.</font></label><input type="text" name="man3_'+y+'" id="man3_'+y+'" class="form-control numero" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Unitario</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/valor.png" name="img6" id="img6" width="20" border="0" title="Modificar Valor" class="mas" onclick="actu6('+y+');"></label><input type="text" name="man12_'+y+'" id="man12_'+y+'" class="form-control numero" onkeyup="paso_val6('+y+'); suma6('+y+');"><input type="hidden" name="man13_'+y+'" id="man13_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Total</font></label><input type="text" name="man4_'+y+'" id="man4_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="man5_'+y+'" id="man5_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%" align="right"><label><font face="Verdana" size="2">Factura</font></label><br><a href="#" name="lnkm_'+y+'" id="lnkm_'+y+'" onclick="cargam('+y+');"><img src="imagenes/clip.png" border="0" title="Anexar Factura"></a></td></tr><tr><td colspan="4" class="espacio1">&nbsp;</td><td><label><font face="Verdana" size="2">I.V.A</font></label><input type="text" name="man7_'+y+'" id="man7_'+y+'" class="form-control numero" onkeypress="return check(event);" onkeyup="suma6('+y+');" maxlength="2" autocomplete="off"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Mano de Obra</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chk6_'+y+'" id="chk6_'+y+'" value="1" onclick="suma6('+y+');" class="chk1"></label><input type="text" name="man14_'+y+'" id="man14_'+y+'" class="form-control numero" onkeyup="paso_val6_1('+y+'); suma6('+y+');"><input type="hidden" name="man15_'+y+'" id="man15_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Mano de Obra Total</font></label><input type="text" name="man8_'+y+'" id="man8_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="man9_'+y+'" id="man9_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Total</font></label><input type="text" name="man10_'+y+'" id="man10_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="man11_'+y+'" id="man11_'+y+'" class="form-control numero" value="0" readonly="readonly"></td></tr><tr><td colspan="5" class="espacio1"><label><font face="Verdana" size="2">Detalles</font></label><input type="text" name="man6_'+y+'" id="man6_'+y+'" class="form-control" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Kilometraje</font></label><input type="text" name="man19_'+y+'" id="man19_'+y+'" class="form-control numero" value="0" onkeypress="return check(event);" onblur="valida_kilometro('+y+');" maxlength="10"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Fecha Factura</font></label><input type="text" name="man16_'+y+'" id="man16_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Nro. Factura</font></label><input type="text" name="man17_'+y+'" id="man17_'+y+'" class="form-control numero" onkeypress="return check1(event);" maxlength="25" autocomplete="off"><select name="man18_'+y+'" id="man18_'+y+'" class="form-control select2"></select><input type="hidden" name="alem_'+y+'" id="alem_'+y+'" class="form-control numero" value="'+alea+'_'+y+'" readonly="readonly"></td></tr><tr><td colspan="11"><hr></td></tr>');
    
    x++;
    $("#man4_"+y).maskMoney();
    $("#man8_"+y).maskMoney();
    $("#man10_"+y).maskMoney();
    $("#man12_"+y).maskMoney();
    $("#man14_"+y).maskMoney();
    $("#man18_"+y).append(pasom);
    $("#man1_"+y).prop("disabled",true);
    $("#man2_"+y).prop("disabled",true);
    $("#man3_"+y).prop("disabled",true);
    $("#man4_"+y).prop("disabled",true);
    $("#man5_"+y).prop("disabled",true);
    $("#man6_"+y).prop("disabled",true);
    $("#man7_"+y).prop("disabled",true);
    $("#man8_"+y).prop("disabled",true);
    $("#man9_"+y).prop("disabled",true);
    $("#man10_"+y).prop("disabled",true);
    $("#man11_"+y).prop("disabled",true);
    $("#man12_"+y).prop("disabled",true);
    $("#man13_"+y).prop("disabled",true);
    $("#man14_"+y).prop("disabled",true);
    $("#man15_"+y).prop("disabled",true);
    $("#man16_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      maxDate: 0,
      changeYear: true,
      changeMonth: true,
    });
    $("#man18_"+y).hide();
    $("#man19_"+y).focus(function(){
      this.select();
    });
    $("#man19_"+y).on("paste", function(e){
      e.preventDefault();
      alerta("Acción No Permitida");
    });
    $("#chk6_"+y).prop("checked",true);
    $("#chk6_"+y).prop("disabled",true);
  }
}
// Mantenimientos Adicional
function agrega61()
{
  var InputsWrapper = $("#add_form61 table tr");
  var x = InputsWrapper.length;
  var FieldCount = 1;
  if(x <= 999)
  {
    var y = x;
    var alea = $("#alea").val();
    var pasom = $("#paso14").val();
    FieldCount++;
    $("#add_form61 table").append('<tr><td colspan="11" class="espacio1"><center><font face="Verdana" size="3"><b>Datos de Mantenimiento y Repuestos</b></font></center></td></tr><td width="15%" class="espacio1"><label><font face="Verdana" size="2">Clase</font></label><input type="text" name="mam1_'+y+'" id="mam1_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="12%" class="espacio1"><label><font face="Verdana" size="2">Placa</font></label><input type="text" name="mam2_'+y+'" id="mam2_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="8%"><label><font face="Verdana" size="2">Cant.</font></label><input type="text" name="mam3_'+y+'" id="mam3_'+y+'" class="form-control numero" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Unitario</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/valor.png" name="img61" id="img61" width="20" border="0" title="Modificar Valor" class="mas" onclick="actu61('+y+');"></label><input type="text" name="mam12_'+y+'" id="mam12_'+y+'" class="form-control numero" onkeyup="paso_val61('+y+'); suma61('+y+');"><input type="hidden" name="mam13_'+y+'" id="mam13_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Total</font></label><input type="text" name="mam4_'+y+'" id="mam4_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="mam5_'+y+'" id="mam5_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%" align="right"><label><font face="Verdana" size="2">Factura</font></label><br><a href="#" name="lnkma_'+y+'" id="lnkma_'+y+'" onclick="cargama('+y+');"><img src="imagenes/clip.png" border="0" title="Anexar Factura"></a></td></tr><tr><td colspan="4" class="espacio1">&nbsp;</td><td><label><font face="Verdana" size="2">I.V.A</font></label><input type="text" name="mam7_'+y+'" id="mam7_'+y+'" class="form-control numero" onkeypress="return check(event);" onkeyup="suma61('+y+');" maxlength="2" autocomplete="off"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Mano de Obra</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chk61_'+y+'" id="chk61_'+y+'" value="1" onclick="suma61('+y+');" class="chk1"></label><input type="text" name="mam14_'+y+'" id="mam14_'+y+'" class="form-control numero" onkeyup="paso_val61_1('+y+'); suma61('+y+');"><input type="hidden" name="mam15_'+y+'" id="mam15_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Mano de Obra Total</font></label><input type="text" name="mam8_'+y+'" id="mam8_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="mam9_'+y+'" id="mam9_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Total</font></label><input type="text" name="mam10_'+y+'" id="mam10_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="mam11_'+y+'" id="mam11_'+y+'" class="form-control numero" value="0" readonly="readonly"></td></tr><tr><td colspan="5" class="espacio1"><label><font face="Verdana" size="2">Detalles</font></label><input type="text" name="mam6_'+y+'" id="mam6_'+y+'" class="form-control" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Kilometraje</font></label><input type="text" name="mam19_'+y+'" id="mam19_'+y+'" class="form-control numero" value="0" onkeypress="return check(event);" onblur="valida_kilometro0('+y+');" maxlength="10"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Fecha Factura</font></label><input type="text" name="mam16_'+y+'" id="mam16_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Nro. Factura</font></label><input type="text" name="mam17_'+y+'" id="mam17_'+y+'" class="form-control numero" onkeypress="return check1(event);" maxlength="25" autocomplete="off"><select name="mam18_'+y+'" id="mam18_'+y+'" class="form-control select2"></select><input type="hidden" name="alema_'+y+'" id="alema_'+y+'" class="form-control numero" value="'+alea+'_'+y+'" readonly="readonly"></td></tr><tr><td colspan="11"><hr></td></tr>');
    x++;
    $("#mam4_"+y).maskMoney();
    $("#mam8_"+y).maskMoney();
    $("#mam10_"+y).maskMoney();
    $("#mam12_"+y).maskMoney();
    $("#mam14_"+y).maskMoney();
    $("#mam18_"+y).append(pasom);
    $("#mam1_"+y).prop("disabled",true);
    $("#mam2_"+y).prop("disabled",true);
    $("#mam3_"+y).prop("disabled",true);
    $("#mam4_"+y).prop("disabled",true);
    $("#mam5_"+y).prop("disabled",true);
    $("#mam6_"+y).prop("disabled",true);
    $("#mam7_"+y).prop("disabled",true);
    $("#mam8_"+y).prop("disabled",true);
    $("#mam9_"+y).prop("disabled",true);
    $("#mam10_"+y).prop("disabled",true);
    $("#mam11_"+y).prop("disabled",true);
    $("#mam12_"+y).prop("disabled",true);
    $("#mam13_"+y).prop("disabled",true);
    $("#mam14_"+y).prop("disabled",true);
    $("#mam15_"+y).prop("disabled",true);
    $("#mam16_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      maxDate: 0,
      changeYear: true,
      changeMonth: true,
    });
    $("#mam18_"+y).hide();
    $("#mam19_"+y).focus(function(){
      this.select();
    });
    $("#chk61_"+y).prop("checked",true);
    $("#chk61_"+y).prop("disabled",true);
  }
}
// RTM
function agrega7()
{
  var InputsWrapper = $("#add_form7 table tr");
  var x = InputsWrapper.length;
  var FieldCount = 1;
  if(x <= 999)
  {
    var y = x;
    var alea = $("#alea").val();
    FieldCount++;
    $("#add_form7 table").append('<tr><td colspan="11" class="espacio1"><center><font face="Verdana" size="3"><b>Datos de RTM</b></font></center></td></tr><td width="15%" class="espacio1"><label><font face="Verdana" size="2">Clase</font></label><input type="text" name="tec1_'+y+'" id="tec1_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="12" class="espacio1"><label><font face="Verdana" size="2">Placa</font></label><input type="text" name="tec2_'+y+'" id="tec2_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="8%"><label><font face="Verdana" size="2">I.V.A</font></label><input type="text" name="tec3_'+y+'" id="tec3_'+y+'" class="form-control numero" onkeypress="return check(event);" onkeyup="suma7('+y+');" maxlength="2" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Unitario</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/valor.png" name="img1" id="img1" width="20" border="0" title="Modificar Valor" class="mas" onclick="actu7('+y+');"></label><input type="text" name="tec7_'+y+'" id="tec7_'+y+'" class="form-control numero" onkeyup="paso_val7('+y+'); suma7('+y+');"><input type="hidden" name="tec8_'+y+'" id="tec8_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Total</font></label><input type="text" name="tec4_'+y+'" id="tec4_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="tec5_'+y+'" id="tec5_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%" align="right"><label><font face="Verdana" size="2">Factura</font></label><br><a href="#" name="lnkt_'+y+'" id="lnkt_'+y+'" onclick="cargat('+y+');"><img src="imagenes/clip.png" border="0" title="Anexar Factura"></a></td></tr><tr><td colspan="5" class="espacio1"><label><font face="Verdana" size="2">Detalles</font></label><input type="text" name="tec6_'+y+'" id="tec6_'+y+'" class="form-control" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Kilometraje</font></label><input type="text" name="tec11_'+y+'" id="tec11_'+y+'" class="form-control numero" value="0" onkeypress="return check(event);" onblur="valida_kilometro1('+y+');" maxlength="10"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Fecha Factura</font></label><input type="text" name="tec9_'+y+'" id="tec9_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Nro. Factura</font></label><input type="text" name="tec10_'+y+'" id="tec10_'+y+'" class="form-control numero" onkeypress="return check1(event);" maxlength="25" autocomplete="off"><input type="hidden" name="alet_'+y+'" id="alet_'+y+'" class="form-control numero" value="'+alea+'_'+y+'" readonly="readonly"></tr><tr><td colspan="11"><hr></td></tr>');
    x++;
    $("#tec4_"+y).maskMoney();
    $("#tec7_"+y).maskMoney();
    $("#tec1_"+y).prop("disabled",true);
    $("#tec2_"+y).prop("disabled",true);
    $("#tec3_"+y).prop("disabled",true);
    $("#tec4_"+y).prop("disabled",true);
    $("#tec5_"+y).prop("disabled",true);
    $("#tec6_"+y).prop("disabled",true);
    $("#tec7_"+y).prop("disabled",true);
    $("#tec8_"+y).prop("disabled",true);
    $("#tec9_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      maxDate: 0,
      changeYear: true,
      changeMonth: true,
    });
    $("#tec11_"+y).focus(function(){
      this.select();
    });
  }
}
// RTM Adicional
function agrega71()
{
  var InputsWrapper = $("#add_form71 table tr");
  var x = InputsWrapper.length;
  var FieldCount = 1;
  if(x <= 999)
  {
    var y = x;
    var alea = $("#alea").val();
    FieldCount++;
    $("#add_form71 table").append('<tr><td colspan="11" class="espacio1"><center><font face="Verdana" size="3"><b>Datos de RTM</b></font></center></td></tr><td width="15%" class="espacio1"><label><font face="Verdana" size="2">Clase</font></label><input type="text" name="ted1_'+y+'" id="ted1_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="12" class="espacio1"><label><font face="Verdana" size="2">Placa</font></label><input type="text" name="ted2_'+y+'" id="ted2_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="8%"><label><font face="Verdana" size="2">I.V.A</font></label><input type="text" name="ted3_'+y+'" id="ted3_'+y+'" class="form-control numero" onkeypress="return check(event);" onkeyup="suma71('+y+');" maxlength="2" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Unitario</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/valor.png" name="img1" id="img1" width="20" border="0" title="Modificar Valor" class="mas" onclick="actu71('+y+');"></label><input type="text" name="ted7_'+y+'" id="ted7_'+y+'" class="form-control numero" onkeyup="paso_val71('+y+'); suma71('+y+');"><input type="hidden" name="ted8_'+y+'" id="ted8_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Total</font></label><input type="text" name="ted4_'+y+'" id="ted4_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="ted5_'+y+'" id="ted5_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%" align="right"><label><font face="Verdana" size="2">Factura</font></label><br><a href="#" name="lnktd_'+y+'" id="lnktd_'+y+'" onclick="cargatd('+y+');"><img src="imagenes/clip.png" border="0" title="Anexar Factura"></a></td></tr><tr><td colspan="5" class="espacio1"><label><font face="Verdana" size="2">Detalles</font></label><input type="text" name="ted6_'+y+'" id="ted6_'+y+'" class="form-control" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Kilometraje</font></label><input type="text" name="ted11_'+y+'" id="ted11_'+y+'" class="form-control numero" value="0" onkeypress="return check(event);" onblur="valida_kilometro11('+y+');" maxlength="10"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Fecha Factura</font></label><input type="text" name="ted9_'+y+'" id="ted9_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Nro. Factura</font></label><input type="text" name="ted10_'+y+'" id="ted10_'+y+'" class="form-control numero" onkeypress="return check1(event);" maxlength="25" autocomplete="off"><input type="hidden" name="aletd_'+y+'" id="aletd_'+y+'" class="form-control numero" value="'+alea+'_'+y+'" readonly="readonly"></tr><tr><td colspan="11"><hr></td></tr>');
    x++;
    $("#ted4_"+y).maskMoney();
    $("#ted7_"+y).maskMoney();
    $("#ted1_"+y).prop("disabled",true);
    $("#ted2_"+y).prop("disabled",true);
    $("#ted3_"+y).prop("disabled",true);
    $("#ted4_"+y).prop("disabled",true);
    $("#ted5_"+y).prop("disabled",true);
    $("#ted6_"+y).prop("disabled",true);
    $("#ted7_"+y).prop("disabled",true);
    $("#ted8_"+y).prop("disabled",true);
    $("#ted9_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      maxDate: 0,
      changeYear: true,
      changeMonth: true,
    });
    $("#ted11_"+y).focus(function(){
      this.select();
    });
  }
}
// Llantas
function agrega8()
{
  var InputsWrapper = $("#add_form8 table tr");
  var x = InputsWrapper.length;
  var FieldCount = 1;
  if(x <= 999)
  {
    var y = x;
    var alea = $("#alea").val();
    FieldCount++;
    $("#add_form8 table").append('<tr><td colspan="13" class="espacio1"><center><font face="Verdana" size="3"><b>Datos de Llantas</b></font></center></td></tr><td width="15%" class="espacio1"><label><font face="Verdana" size="2">Clase</font></label><input type="text" name="lla1_'+y+'" id="lla1_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="12%" class="espacio1"><label><font face="Verdana" size="2">Placa</font></label><input type="text" name="lla2_'+y+'" id="lla2_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="8%"><label><font face="Verdana" size="2">Cant.</font></label><input type="text" name="lla3_'+y+'" id="lla3_'+y+'" class="form-control numero"></td><td width="1%">&nbsp;</td><td width="8%"><label><font face="Verdana" size="2">I.V.A</font></label><input type="text" name="lla7_'+y+'" id="lla7_'+y+'" class="form-control numero" onkeypress="return check(event);" onkeyup="suma8('+y+');" maxlength="2" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Unitario</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/valor.png" name="img1" id="img1" width="20" border="0" title="Modificar Valor" class="mas" onclick="actu8('+y+');"></label><input type="text" name="lla10_'+y+'" id="lla10_'+y+'" class="form-control numero" onkeyup="paso_val8('+y+'); suma8('+y+');"><input type="hidden" name="lla11_'+y+'" id="lla11_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Total</font></label><input type="text" name="lla4_'+y+'" id="lla4_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="lla5_'+y+'" id="lla5_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="1%" align="right"><label><font face="Verdana" size="2">Factura</font></label><br><a href="#" name="lnkl_'+y+'" id="lnkl_'+y+'" onclick="cargal('+y+');"><img src="imagenes/clip.png" border="0" title="Anexar Factura"></a></td></tr><tr><td colspan="7" class="espacio1"><label><font face="Verdana" size="2">Referencia - Marca - Almac&eacute;n</font></label><input type="text" name="lla6_'+y+'" id="lla6_'+y+'" class="form-control" readonly="readonly"></td><td>&nbsp;</td><td colspan="5"><label><font face="Verdana" size="2">Descripci&oacute;n</font></label><input type="text" name="lla8_'+y+'" id="lla8_'+y+'" class="form-control" readonly="readonly"></td></tr><tr><td colspan="3" class="espacio1"><label><font face="Verdana" size="2">Observaciones</font></label><input type="text" name="lla9_'+y+'" id="lla9_'+y+'" class="form-control" readonly="readonly"><td>&nbsp;</td><td colspan="3"><label><font face="Verdana" size="2">Kilometraje</font></label><input type="text" name="lla14_'+y+'" id="lla14_'+y+'" class="form-control numero" value="0" onkeypress="return check(event);" onblur="valida_kilometro2('+y+');" maxlength="10"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Fecha Factura</font></label><input type="text" name="lla12_'+y+'" id="lla12_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td>&nbsp;</td><td colspan="3"><label><font face="Verdana" size="2">Nro. Factura</font></label><input type="text" name="lla13_'+y+'" id="lla13_'+y+'" class="form-control numero" onkeypress="return check1(event);" maxlength="25" autocomplete="off"><input type="hidden" name="alel_'+y+'" id="alel_'+y+'" class="form-control numero" value="'+alea+'_'+y+'" readonly="readonly"></td></tr><tr><td colspan="13"><hr></td></tr>');
    x++;
    $("#lla4_"+y).maskMoney();
    $("#lla10_"+y).maskMoney();
    $("#lla1_"+y).prop("disabled",true);
    $("#lla2_"+y).prop("disabled",true);
    $("#lla3_"+y).prop("disabled",true);
    $("#lla4_"+y).prop("disabled",true);
    $("#lla5_"+y).prop("disabled",true);
    $("#lla6_"+y).prop("disabled",true);
    $("#lla7_"+y).prop("disabled",true);
    $("#lla8_"+y).prop("disabled",true);
    $("#lla9_"+y).prop("disabled",true);
    $("#lla10_"+y).prop("disabled",true);
    $("#lla11_"+y).prop("disabled",true);
    $("#lla12_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      maxDate: 0,
      changeYear: true,
      changeMonth: true,
    });
    $("#lla14_"+y).focus(function(){
      this.select();
    });
  }
}
// Llantas Adicional
function agrega81()
{
  var InputsWrapper = $("#add_form81 table tr");
  var x = InputsWrapper.length;
  var FieldCount = 1;
  if(x <= 999)
  {
    var y = x;
    var alea = $("#alea").val();
    FieldCount++;
    $("#add_form81 table").append('<tr><td colspan="13" class="espacio1"><center><font face="Verdana" size="3"><b>Datos de Llantas</b></font></center></td></tr><td width="15%" class="espacio1"><label><font face="Verdana" size="2">Clase</font></label><input type="text" name="lln1_'+y+'" id="lln1_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="12%" class="espacio1"><label><font face="Verdana" size="2">Placa</font></label><input type="text" name="lln2_'+y+'" id="lln2_'+y+'" class="form-control" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="8%"><label><font face="Verdana" size="2">Cant.</font></label><input type="text" name="lln3_'+y+'" id="lln3_'+y+'" class="form-control numero"></td><td width="1%">&nbsp;</td><td width="8%"><label><font face="Verdana" size="2">I.V.A</font></label><input type="text" name="lln7_'+y+'" id="lln7_'+y+'" class="form-control numero" onkeypress="return check(event);" onkeyup="suma81('+y+');" maxlength="2" autocomplete="off"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Unitario</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/valor.png" name="img1" id="img1" width="20" border="0" title="Modificar Valor" class="mas" onclick="actu81('+y+');"></label><input type="text" name="lln10_'+y+'" id="lln10_'+y+'" class="form-control numero" onkeyup="paso_val81('+y+'); suma81('+y+');"><input type="hidden" name="lln11_'+y+'" id="lln11_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="20%"><label><font face="Verdana" size="2">Valor Total</font></label><input type="text" name="lln4_'+y+'" id="lln4_'+y+'" class="form-control numero" readonly="readonly"><input type="hidden" name="lln5_'+y+'" id="lln5_'+y+'" class="form-control numero" value="0" readonly="readonly"></td><td width="1%">&nbsp;</td><td width="1%" align="right"><label><font face="Verdana" size="2">Factura</font></label><br><a href="#" name="lnkll_'+y+'" id="lnkll_'+y+'" onclick="cargall('+y+');"><img src="imagenes/clip.png" border="0" title="Anexar Factura"></a></td></tr><tr><td colspan="7" class="espacio1"><label><font face="Verdana" size="2">Referencia - Marca - Almac&eacute;n</font></label><input type="text" name="lln6_'+y+'" id="lln6_'+y+'" class="form-control" readonly="readonly"></td><td>&nbsp;</td><td colspan="5"><label><font face="Verdana" size="2">Descripci&oacute;n</font></label><input type="text" name="lln8_'+y+'" id="lln8_'+y+'" class="form-control" readonly="readonly"></td></tr><tr><td colspan="3" class="espacio1"><label><font face="Verdana" size="2">Observaciones</font></label><input type="text" name="lln9_'+y+'" id="lln9_'+y+'" class="form-control" readonly="readonly"><td>&nbsp;</td><td colspan="3"><label><font face="Verdana" size="2">Kilometraje</font></label><input type="text" name="lln14_'+y+'" id="lln14_'+y+'" class="form-control numero" value="0" onkeypress="return check(event);" onblur="valida_kilometro21('+y+');" maxlength="10"></td><td>&nbsp;</td><td><label><font face="Verdana" size="2">Fecha Factura</font></label><input type="text" name="lln12_'+y+'" id="lln12_'+y+'" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly"></td><td>&nbsp;</td><td colspan="3"><label><font face="Verdana" size="2">Nro. Factura</font></label><input type="text" name="lln13_'+y+'" id="lln13_'+y+'" class="form-control numero" onkeypress="return check1(event);" maxlength="25" autocomplete="off"><input type="hidden" name="alell_'+y+'" id="alell_'+y+'" class="form-control numero" value="'+alea+'_'+y+'" readonly="readonly"></td></tr><tr><td colspan="13"><hr></td></tr>');
    x++;
    $("#lln4_"+y).maskMoney();
    $("#lln10_"+y).maskMoney();
    $("#lln1_"+y).prop("disabled",true);
    $("#lln2_"+y).prop("disabled",true);
    $("#lln3_"+y).prop("disabled",true);
    $("#lln4_"+y).prop("disabled",true);
    $("#lln5_"+y).prop("disabled",true);
    $("#lln6_"+y).prop("disabled",true);
    $("#lln7_"+y).prop("disabled",true);
    $("#lln8_"+y).prop("disabled",true);
    $("#lln9_"+y).prop("disabled",true);
    $("#lln10_"+y).prop("disabled",true);
    $("#lln11_"+y).prop("disabled",true);
    $("#lln12_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      maxDate: 0,
      changeYear: true,
      changeMonth: true,
    });
    $("#lln14_"+y).focus(function(){
      this.select();
    });
  }
}
// Combustible
function actu4(valor)
{
	//alerta("Función Desactivada");
  var valor;
  $("#com3_"+valor).prop("disabled",false);
  $("#com3_"+valor).focus();
}
function paso_valc(valor)
{
  var valor;
  var valor1 = $("#com3_"+valor).val();
  var valor2 = parseFloat(valor1.replace(/,/g,''));
  $("#com4_"+valor).val(valor2);
}
// Combustible Adicional
function actu41(valor)
{
	//alerta("Función Desactivada");
  var valor;
  $("#con3_"+valor).prop("disabled",false);
  $("#con3_"+valor).focus();
}
function paso_valc1(valor)
{
  var valor;
  var valor1 = $("#con3_"+valor).val();
  var valor2 = parseFloat(valor1.replace(/,/g,''));
  $("#con4_"+valor).val(valor2);
}
function suma4()
{
  var total = 0;
  for (i=0;i<document.formu4.elements.length;i++)
  {
    saux = document.formu4.elements[i].name;
    if (saux.indexOf('com4_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      total = total+valor;
    }
  }
  total = parseFloat(total);
  $("#paso_combus3").val(total);
  var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#paso_combus2").val(total1);
}
function suma41()
{
  var total = 0;
  for (i=0;i<document.formu41.elements.length;i++)
  {
    saux = document.formu41.elements[i].name;
    if (saux.indexOf('con4_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      total = total+valor;
    }
  }
  total = parseFloat(total);
  $("#paso_conbus3").val(total);
  var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#paso_conbus2").val(total1);
}
// Grasas
function actu5(valor)
{
  var valor;
  $("#gra7_"+valor).prop("disabled",false);
  $("#gra12_"+valor).prop("disabled",false);
  $("#gra14_"+valor).prop("disabled",false);
  $("#chk5_"+valor).prop("disabled",false);
  $("#gra12_"+valor).focus();
}
function paso_val5(valor)
{
  var valor;
  var valor1 = $("#gra12_"+valor).val();
  var valor2 = parseFloat(valor1.replace(/,/g,''));
  $("#gra13_"+valor).val(valor2);
}
function paso_val5_1(valor)
{
  var valor;
  var valor1 = $("#gra14_"+valor).val();
  var valor2 = parseFloat(valor1.replace(/,/g,''));
  $("#gra15_"+valor).val(valor2);
}
function suma5(valor)
{
  // Gra3  - Cantidad
  // Gra7  - Iva
  // Gra13 - Valor
  // Gra15 - Mano
  var v_valor = $("#gra13_"+valor).val();
  v_valor = parseFloat(v_valor);
  var v_cantidad = $("#gra3_"+valor).val();
  v_cantidad = parseFloat(v_cantidad);
  var v_iva = $("#gra7_"+valor).val();
  v_iva = parseFloat(v_iva);
  if (v_iva < 10)
  {
    v_iva = v_iva/100;
    v_iva = 1+v_iva;
  }
  else
  {
    v_iva = "1."+v_iva;
  }
  v_iva = parseFloat(v_iva);
  var v_valor1 = (v_valor*v_iva)*v_cantidad;
  var v_valor2 = v_valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor1 = v_valor1.toFixed(2);
  $("#gra4_"+valor).val(v_valor2);
  $("#gra5_"+valor).val(v_valor1);
  var v_mano = $("#gra15_"+valor).val();
  v_mano = parseFloat(v_mano);
  if ($("#chk5_"+valor).is(":checked"))
  {
    var v_valor3 = v_mano*v_iva;
  }
  else
  {
    var v_valor3 = v_mano;
  }
  var v_valor4 = v_valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor3 = v_valor3.toFixed(2);
  $("#gra8_"+valor).val(v_valor4);
  $("#gra9_"+valor).val(v_valor3);
  var v_valor5 = parseFloat(v_valor1)+parseFloat(v_valor3);
  var v_valor6 = v_valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor5 = v_valor5.toFixed(2);
  $("#gra10_"+valor).val(v_valor6);
  $("#gra11_"+valor).val(v_valor5);
  suma5_1();
}
function suma5_1()
{
  var total = 0;
  for (i=0;i<document.formu5.elements.length;i++)
  {
    saux = document.formu5.elements[i].name;
    if (saux.indexOf('gra11_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      total = total+valor;
    }
  }
  total = parseFloat(total);
  $("#paso_grasas3").val(total);
  var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#paso_grasas2").val(total1);
}
// Mantenimiento
function actu6(valor)
{
  var valor;
  $("#man7_"+valor).prop("disabled",false);
  $("#man12_"+valor).prop("disabled",false);
  $("#man14_"+valor).prop("disabled",false);
  $("#chk6_"+valor).prop("disabled",false);
  $("#man12_"+valor).focus();
}
function paso_val6(valor)
{
  var valor;
  var valor1 = $("#man12_"+valor).val();
  var valor2 = parseFloat(valor1.replace(/,/g,''));
  $("#man13_"+valor).val(valor2);
}
function paso_val6_1(valor)
{
  var valor;
  var valor1 = $("#man14_"+valor).val();
  var valor2 = parseFloat(valor1.replace(/,/g,''));
  $("#man15_"+valor).val(valor2);
}
function suma6(valor)
{
  // Man3  - Cantidad
  // Man7  - Iva
  // Man13 - Valor
  // Man15 - Mano
  var v_valor = $("#man13_"+valor).val();
  v_valor = parseFloat(v_valor);
  var v_cantidad = $("#man3_"+valor).val();
  v_cantidad = parseFloat(v_cantidad);
  var v_iva = $("#man7_"+valor).val();
  v_iva = parseFloat(v_iva);
  if (v_iva < 10)
  {
    v_iva = v_iva/100;
    v_iva = 1+v_iva;
  }
  else
  {
    v_iva = "1."+v_iva;
  }
  v_iva = parseFloat(v_iva);
  var v_valor1 = (v_valor*v_iva)*v_cantidad;
  var v_valor2 = v_valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor1 = v_valor1.toFixed(2);
  $("#man4_"+valor).val(v_valor2);
  $("#man5_"+valor).val(v_valor1);
  var v_mano = $("#man15_"+valor).val();
  v_mano = parseFloat(v_mano);
  if ($("#chk6_"+valor).is(":checked"))
  {
    var v_valor3 = v_mano*v_iva;
  }
  else
  {
    var v_valor3 = v_mano;
  }
  var v_valor4 = v_valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor3 = v_valor3.toFixed(2);
  $("#man8_"+valor).val(v_valor4);
  $("#man9_"+valor).val(v_valor3);
  var v_valor5 = parseFloat(v_valor1)+parseFloat(v_valor3);
  var v_valor6 = v_valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor5 = v_valor5.toFixed(2);
  $("#man10_"+valor).val(v_valor6);
  $("#man11_"+valor).val(v_valor5);
  suma6_1();
}
function suma6_1()
{
  var total = 0;
  for (i=0;i<document.formu6.elements.length;i++)
  {
    saux = document.formu6.elements[i].name;
    if (saux.indexOf('man11_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      total = total+valor;
    }
  }
  total = parseFloat(total);
  var iva = $("#paso19").val();
  iva = parseFloat(iva);
  total = total+iva;
  $("#paso_manteni3").val(total);
  var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#paso_manteni2").val(total1);
  var iva1 = iva.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#iva_man").val(iva1); 
}
// Mantenimiento Adicional
function actu61(valor)
{
  var valor;
  $("#mam7_"+valor).prop("disabled",false);
  $("#mam12_"+valor).prop("disabled",false);
  $("#mam14_"+valor).prop("disabled",false);
  $("#chk61_"+valor).prop("disabled",false);
  $("#mam12_"+valor).focus();
}
function paso_val61(valor)
{
  var valor;
  var valor1 = $("#mam12_"+valor).val();
  var valor2 = parseFloat(valor1.replace(/,/g,''));
  $("#mam13_"+valor).val(valor2);
}
function paso_val61_1(valor)
{
  var valor;
  var valor1 = $("#mam14_"+valor).val();
  var valor2 = parseFloat(valor1.replace(/,/g,''));
  $("#mam15_"+valor).val(valor2);
}
function suma61(valor)
{
  // Mam3  - Cantidad
  // Mam7  - Iva
  // Mam13 - Valor
  // Mam15 - Mano
  var v_valor = $("#mam13_"+valor).val();
  v_valor = parseFloat(v_valor);
  var v_cantidad = $("#mam3_"+valor).val();
  v_cantidad = parseFloat(v_cantidad);
  var v_iva = $("#mam7_"+valor).val();
  v_iva = parseFloat(v_iva);
  if (v_iva < 10)
  {
    v_iva = v_iva/100;
    v_iva = 1+v_iva;
  }
  else
  {
    v_iva = "1."+v_iva;
  }
  v_iva = parseFloat(v_iva);
  var v_valor1 = (v_valor*v_iva)*v_cantidad;
  var v_valor2 = v_valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor1 = v_valor1.toFixed(2);
  $("#mam4_"+valor).val(v_valor2);
  $("#mam5_"+valor).val(v_valor1);
  var v_mano = $("#mam15_"+valor).val();
  v_mano = parseFloat(v_mano);
  if ($("#chk61_"+valor).is(":checked"))
  {
    var v_valor3 = v_mano*v_iva;
  }
  else
  {
    var v_valor3 = v_mano;
  }
  var v_valor4 = v_valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor3 = v_valor3.toFixed(2);
  $("#mam8_"+valor).val(v_valor4);
  $("#mam9_"+valor).val(v_valor3);
  var v_valor5 = parseFloat(v_valor1)+parseFloat(v_valor3);
  var v_valor6 = v_valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor5 = v_valor5.toFixed(2);
  $("#mam10_"+valor).val(v_valor6);
  $("#mam11_"+valor).val(v_valor5);
  suma61_1();
}
function suma61_1()
{
  var total = 0;
  for (i=0;i<document.formu61.elements.length;i++)
  {
    saux = document.formu61.elements[i].name;
    if (saux.indexOf('mam11_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      total = total+valor;
    }
  }
  total = parseFloat(total);
  var iva = $("#paso20").val();
  iva = parseFloat(iva);
  total = total+iva;
  $("#paso_mamteni3").val(total);
  var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#paso_mamteni2").val(total1);
}
// RTM
function actu7(valor)
{
  var valor;
  $("#tec3_"+valor).prop("disabled",false);
  $("#tec7_"+valor).prop("disabled",false);
  $("#tec7_"+valor).focus();
}
function actu71(valor)
{
  var valor;
  $("#ted3_"+valor).prop("disabled",false);
  $("#ted7_"+valor).prop("disabled",false);
  $("#ted7_"+valor).focus();
}
function paso_val7(valor)
{
  var valor;
  var valor1 = $("#tec7_"+valor).val();
  var valor2 = parseFloat(valor1.replace(/,/g,''));
  $("#tec8_"+valor).val(valor2);
}
function paso_val71(valor)
{
  var valor;
  var valor1 = $("#ted7_"+valor).val();
  var valor2 = parseFloat(valor1.replace(/,/g,''));
  $("#ted8_"+valor).val(valor2);
}
function suma7(valor)
{
  // Tec3 - Iva
  // Tec8 - Valor
  var v_valor = $("#tec8_"+valor).val();
  v_valor = parseFloat(v_valor);
  var v_iva = $("#tec3_"+valor).val();
  v_iva = parseFloat(v_iva);
  if (v_iva < 10)
  {
    v_iva = v_iva/100;
    v_iva = 1+v_iva;
  }
  else
  {
    v_iva = "1."+v_iva;
  }
  v_iva = parseFloat(v_iva);
  var v_valor1 = v_valor*v_iva;
  var v_valor2 = v_valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor1 = v_valor1.toFixed(2);
  $("#tec4_"+valor).val(v_valor2);
  $("#tec5_"+valor).val(v_valor1);
  suma7_1();
}
function suma7_1()
{
  var total = 0;
  for (i=0;i<document.formu7.elements.length;i++)
  {
    saux = document.formu7.elements[i].name;
    if (saux.indexOf('tec5_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      total = total+valor;
    }
  }
  total = parseFloat(total);
  $("#paso_tecnico3").val(total);
  var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#paso_tecnico2").val(total1);
}
// Adicional
function suma71(valor)
{
  // Ted3 - Iva
  // Ted8 - Valor
  var v_valor = $("#ted8_"+valor).val();
  v_valor = parseFloat(v_valor);
  var v_iva = $("#ted3_"+valor).val();
  v_iva = parseFloat(v_iva);
  if (v_iva < 10)
  {
    v_iva = v_iva/100;
    v_iva = 1+v_iva;
  }
  else
  {
    v_iva = "1."+v_iva;
  }
  v_iva = parseFloat(v_iva);
  var v_valor1 = v_valor*v_iva;
  var v_valor2 = v_valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor1 = v_valor1.toFixed(2);
  $("#ted4_"+valor).val(v_valor2);
  $("#ted5_"+valor).val(v_valor1);
  suma71_1();
}
function suma71_1()
{
  var total = 0;
  for (i=0;i<document.formu71.elements.length;i++)
  {
    saux = document.formu71.elements[i].name;
    if (saux.indexOf('ted5_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      total = total+valor;
    }
  }
  total = parseFloat(total);
  $("#paso_tecnido3").val(total);
  var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#paso_tecnido2").val(total1);
}
// Llantas
function actu8(valor)
{
  var valor;
  $("#lla7_"+valor).prop("disabled",false);
  $("#lla10_"+valor).prop("disabled",false);
  $("#lla10_"+valor).focus();
}
function paso_val8(valor)
{
  var valor;
  var valor1 = $("#lla10_"+valor).val();
  var valor2 = parseFloat(valor1.replace(/,/g,''));
  $("#lla11_"+valor).val(valor2);
}
function suma8(valor)
{
  // Lla3  - Cantidad
  // Lla7  - Iva
  // Lla10 - Valor
  var v_valor = $("#lla11_"+valor).val();
  v_valor = parseFloat(v_valor);
  var v_cantidad = $("#lla3_"+valor).val();
  v_cantidad = parseFloat(v_cantidad);
  var v_iva = $("#lla7_"+valor).val();
  v_iva = parseFloat(v_iva);
  if (v_iva < 10)
  {
    v_iva = v_iva/100;
    v_iva = 1+v_iva;
  }
  else
  {
    v_iva = "1."+v_iva;
  }
  v_iva = parseFloat(v_iva);
  var v_valor1 = (v_valor*v_iva)*v_cantidad;
  var v_valor2 = v_valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor1 = v_valor1.toFixed(2);
  $("#lla4_"+valor).val(v_valor2);
  $("#lla5_"+valor).val(v_valor1);
  suma8_1();
}
function suma8_1()
{
  var total = 0;
  for (i=0;i<document.formu8.elements.length;i++)
  {
    saux = document.formu8.elements[i].name;
    if (saux.indexOf('lla5_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      total = total+valor;
    }
  }
  total = parseFloat(total);
  $("#paso_llantas3").val(total);
  var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#paso_llantas2").val(total1);
}
// Llantas Adicional
function actu81(valor)
{
  var valor;
  $("#lln7_"+valor).prop("disabled",false);
  $("#lln10_"+valor).prop("disabled",false);
  $("#lln10_"+valor).focus();
}
function paso_val81(valor)
{
  var valor;
  var valor1 = $("#lln10_"+valor).val();
  var valor2 = parseFloat(valor1.replace(/,/g,''));
  $("#lln11_"+valor).val(valor2);
}
function suma81(valor)
{
  // Lln3  - Cantidad
  // Lln7  - Iva
  // Lln10 - Valor
  var v_valor = $("#lln11_"+valor).val();
  v_valor = parseFloat(v_valor);
  var v_cantidad = $("#lln3_"+valor).val();
  v_cantidad = parseFloat(v_cantidad);
  var v_iva = $("#lln7_"+valor).val();
  v_iva = parseFloat(v_iva);
  if (v_iva < 10)
  {
    v_iva = v_iva/100;
    v_iva = 1+v_iva;
  }
  else
  {
    v_iva = "1."+v_iva;
  }
  v_iva = parseFloat(v_iva);
  var v_valor1 = (v_valor*v_iva)*v_cantidad;
  var v_valor2 = v_valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  v_valor1 = v_valor1.toFixed(2);
  $("#lln4_"+valor).val(v_valor2);
  $("#lln5_"+valor).val(v_valor1);
  suma81_1();
}
function suma81_1()
{
  var total = 0;
  for (i=0;i<document.formu81.elements.length;i++)
  {
    saux = document.formu81.elements[i].name;
    if (saux.indexOf('lln5_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      total = total+valor;
    }
  }
  total = parseFloat(total);
  $("#paso_llamtas3").val(total);
  var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#paso_llamtas2").val(total1);
}
// kilometraje Mantenimientos
function valida_kilometro(valor)
{
  var valor;
  var valor1 = $("#man19_"+valor).val();
  var valor2 = $("#man2_"+valor).val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_kilometraje.php",
    data:
    {
      placa: valor2,
      kilometraje: valor1
    },
    success: function (data)
    {
      $("#load").hide();
      var registros = JSON.parse(data);
      var valida = registros.salida;
      var kilometraje = registros.kilometraje;
      if (valida == "1")
      {
        formatNumber1(valor);
        $("#aceptar6").show();
      }
      else
      {
        alerta("Valor Kilometroje Inferior a: "+kilometraje);
        $("#aceptar6").hide();
      }
    }
  });
}
function valida_kilometro0(valor)
{
  var valor;
  var valor1 = $("#mam19_"+valor).val();
  var valor2 = $("#mam2_"+valor).val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_kilometraje.php",
    data:
    {
      placa: valor2,
      kilometraje: valor1
    },
    success: function (data)
    {
      $("#load").hide();
      var registros = JSON.parse(data);
      var valida = registros.salida;
      var kilometraje = registros.kilometraje;
      if (valida == "1")
      {
        formatNumber11(valor);
        $("#aceptar61").show();
      }
      else
      {
        alerta("Valor Kilometroje Inferior a: "+kilometraje);
        $("#aceptar61").hide();
      }
    }
  });
}
//Kilometraje RTM
function valida_kilometro1(valor)
{
  var valor;
  var valor1 = $("#tec11_"+valor).val();
  var valor2 = $("#tec2_"+valor).val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_kilometraje.php",
    data:
    {
      placa: valor2,
      kilometraje: valor1
    },
    success: function (data)
    {
      $("#load").hide();
      var registros = JSON.parse(data);
      var valida = registros.salida;
      var kilometraje = registros.kilometraje;
      if (valida == "1")
      {
        formatNumber2(valor);
        $("#aceptar7").show();
      }
      else
      {
        alerta("Valor Kilometroje Inferior a: "+kilometraje);
        $("#aceptar7").hide();
      }
    }
  });
}
function valida_kilometro11(valor)
{
  var valor;
  var valor1 = $("#ted11_"+valor).val();
  var valor2 = $("#ted2_"+valor).val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_kilometraje.php",
    data:
    {
      placa: valor2,
      kilometraje: valor1
    },
    success: function (data)
    {
      $("#load").hide();
      var registros = JSON.parse(data);
      var valida = registros.salida;
      var kilometraje = registros.kilometraje;
      if (valida == "1")
      {
        formatNumber21(valor);
        $("#aceptar71").show();
      }
      else
      {
        alerta("Valor Kilometroje Inferior a: "+kilometraje);
        $("#aceptar71").hide();
      }
    }
  });
}
//Kilometraje Llantas
function valida_kilometro2(valor)
{
  var valor;
  var valor1 = $("#lla14_"+valor).val();
  var valor2 = $("#lla2_"+valor).val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_kilometraje.php",
    data:
    {
      placa: valor2,
      kilometraje: valor1
    },
    success: function (data)
    {
      $("#load").hide();
      var registros = JSON.parse(data);
      var valida = registros.salida;
      var kilometraje = registros.kilometraje;
      if (valida == "1")
      {
        formatNumber3(valor);
        $("#aceptar8").show();
      }
      else
      {
        alerta("Valor Kilometroje Inferior a: "+kilometraje);
        $("#aceptar8").hide();
      }
    }
  });
}
function valida_kilometro21(valor)
{
  var valor;
  var valor1 = $("#lln14_"+valor).val();
  var valor2 = $("#lln2_"+valor).val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_kilometraje.php",
    data:
    {
      placa: valor2,
      kilometraje: valor1
    },
    success: function (data)
    {
      $("#load").hide();
      var registros = JSON.parse(data);
      var valida = registros.salida;
      var kilometraje = registros.kilometraje;
      if (valida == "1")
      {
        formatNumber31(valor);
        $("#aceptar81").show();
      }
      else
      {
        alerta("Valor Kilometroje Inferior a: "+kilometraje);
        $("#aceptar81").hide();
      }
    }
  });
}
function formatNumber1(valor)
{
  var valor;
  var valor1 = $("#man19_"+valor).val();
  var valor2 = String(valor1).replace(/\D/g, "");
  var valor3 = Number(valor2).toLocaleString();
  $("#man19_"+valor).val(valor3);
}
function formatNumber11(valor)
{
  var valor;
  var valor1 = $("#mam19_"+valor).val();
  var valor2 = String(valor1).replace(/\D/g, "");
  var valor3 = Number(valor2).toLocaleString();
  $("#mam19_"+valor).val(valor3);
}
function formatNumber2(valor)
{
  var valor;
  var valor1 = $("#tec11_"+valor).val();
  var valor2 = String(valor1).replace(/\D/g, "");
  var valor3 = Number(valor2).toLocaleString();
  $("#tec11_"+valor).val(valor3);
}
function formatNumber21(valor)
{
  var valor;
  var valor1 = $("#ted11_"+valor).val();
  var valor2 = String(valor1).replace(/\D/g, "");
  var valor3 = Number(valor2).toLocaleString();
  $("#ted11_"+valor).val(valor3);
}
function formatNumber3(valor)
{
  var valor;
  var valor1 = $("#lla14_"+valor).val();
  var valor2 = String(valor1).replace(/\D/g, "");
  var valor3 = Number(valor2).toLocaleString();
  $("#lla14_"+valor).val(valor3);
}
function formatNumber31(valor)
{
  var valor;
  var valor1 = $("#lln14_"+valor).val();
  var valor2 = String(valor1).replace(/\D/g, "");
  var valor3 = Number(valor2).toLocaleString();
  $("#lln14_"+valor).val(valor3);
}
function valida_bienes()
{
  var salida = true;
  var detalle = "";
  var datos = "";
  var datos1 = "";
  var datos2 = "";
  var datos3 = "";
  var datos4 = "";
  var datos5 = "";
  var datos6 = "";
  var datos7 = "";
  var datos8 = "";
  var datos9 = "";
  var datos10 = "";
  var datos11 = "";
  var datos12 = "";
  var datos13 = "";
  var datos14 = "";
  var datos15 = "";
  var datos16 = "";
  var datos17 = "";
  var datos18 = "";
  var datos19 = "";
  var datos20 = "";
  var datos21 = "";
  var datos22 = "";
  var datos23 = "";
  var datos24 = "";
  var datos25 = "";
  var facturas = "";
  $("#paso_bienes").val('');
  var v_descripcion = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('des_')!=-1)
    {
      $("#"+saux).removeClass("ui-state-error");
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_descripcion ++;
        $("#"+saux).prop("disabled",false);
        $("#"+saux).addClass("ui-state-error");
      }
    }
  }
  if (v_descripcion > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_descripcion+" Descripcion(es)</center></h3>";
  }
  var v_fechas = 0;
  var v_funcionarios = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('vam_')!=-1)
    {
      $("#"+saux).removeClass("ui-state-error");
      valor = document.getElementById(saux).value.trim().length;
      valor1 = document.getElementById(saux).value;
      valor1 = parseFloat(valor1);
      if (valor1 > 0)
      {
        var var_ocu = saux.split('_');
        var paso = var_ocu[1];
        var valida1 = $("#fec_"+paso).val();
        valida1 = valida1.trim();
        if (valida1 == "")
        {
          v_fechas ++;
          $("#fec_"+paso).addClass("ui-state-error");
        }
        else
        {
          $("#fec_"+paso).removeClass("ui-state-error");
        }
        var valida2 = $("#fun_"+paso).val();
        valida2 = valida2.trim();
        if (valida2 == "")
        {
          v_funcionarios ++;
          $("#fun_"+paso).addClass("ui-state-error");
        }
        else
        {
          $("#fun_"+paso).removeClass("ui-state-error");
        }
      }
    }
  }
  if (v_fechas > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_fechas+" Fecha(s)</center></h3>";
  }
  if (v_funcionarios > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_funcionarios+" Funcionario(s)</center></h3>";
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('cla_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "")
      {
      }
      else
      {
        datos = datos+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos1 = datos1+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('des_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos2 = datos2+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('fec_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos3 = datos3+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('val_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos4 = datos4+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('mar_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos5 = datos5+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('col_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos6 = datos6+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('mod_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos7 = datos7+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('ser_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos8 = datos8+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('son_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos9 = datos9+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('soa_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos10 = datos10+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('so1_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos11 = datos11+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('so2_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos12 = datos12+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('sec_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos13 = datos13+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('sev_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos14 = datos14+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('set_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos15 = datos15+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('sen_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos16 = datos16+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('sea_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos17 = datos17+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('se1_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos18 = datos18+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('se2_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos19 = datos19+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('ubi_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos20 = datos20+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('fun_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos21 = datos21+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('ord_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos22 = datos22+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('mis_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos23 = datos23+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('pla_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos24 = datos24+valor2+"&";
      }
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('est_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "0")
      {
      }
      else
      {
        datos25 = datos25+valor2+"&";
      }
    }
  }
  var suma_bienes = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('vam_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      valor2 = parseFloat(valor2);
      suma_bienes = suma_bienes+valor2;
    }
  }
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux = document.formu1.elements[i].name;
    if (saux.indexOf('ale_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
      if (valor2 == "")
      {
      }
      else
      {
        v_fac = saux.split('_');
        v_fac1 = v_fac[1];
        valorf = $("#vam_"+v_fac1).val();
        if (valorf == "0")
        {
        }
        else
        {
          facturas = facturas+valor2+"|";
        }
      }
    }
  }
  var suma_bienes1 = parseFloat(suma_bienes)
  suma_bienes1 = suma_bienes1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  var final = datos+"#"+datos1+"#"+datos2+"#"+datos3+"#"+datos4+"#"+datos5+"#"+datos6+"#"+datos7+"#"+datos8+"#"+datos9+"#"+datos10+"#"+datos11+"#"+datos12+"#"+datos13+"#"+datos14+"#"+datos15+"#"+datos16+"#"+datos17+"#"+datos18+"#"+datos19+"#"+datos20+"#"+datos21+"#"+datos22+"#"+datos23+"#"+datos24+"#"+datos25;
  $("#paso_bienes").val(final);
  $("#paso6").val(facturas);
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    valida_facturas();
  }
}
function valida_facturas()
{
  var facturas = $("#paso6").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_facturas.php",
    data:
    {
      facturas: facturas
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
      if (valida > 0)
      {
        var detalle = "<center><h3>Debe cargar "+valida+" Factura(s)</center></h3>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
      else
      {
        $("#dialogo2").dialog("close");
      }
    }
  });
}
function valida_combus()
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7;
  var facturas = "";
  var sigla = $("#sigla").val();
  $("#paso_combus").val('');
  var salida = true;
  for (i=0;i<document.formu4.elements.length;i++)
  {
    saux = document.formu4.elements[i].name;
    if (saux.indexOf('com1_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu4.elements[i].name;
    if (saux1.indexOf('com2_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu4.elements[i].name;
    if (saux2.indexOf('com3_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
      $("#"+saux2).prop("disabled",true);
    }
    saux3 = document.formu4.elements[i].name;
    if (saux3.indexOf('com4_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
    }
    saux4 = document.formu4.elements[i].name;
    if (saux4.indexOf('com5_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
    }
    saux5 = document.formu4.elements[i].name;
    if (saux5.indexOf('alec_')!=-1)
    {
      valor5 = document.getElementById(saux5).value;
      valor6 = valor+"»"+valor1+"»"+valor2+"»"+valor3+"»"+valor4+"»"+valor5+"»"+sigla;
      document.getElementById('paso_combus').value = document.getElementById('paso_combus').value+valor6+"|";
      if (valor3 == "0")
      {
      }
      else
      {
        valor7 = valor1+"»"+sigla+"»"+valor5;
        facturas += valor7+"|";
      }
    }
  }
  if (salida == false)
  {
    var detalle = "<center><h3>Datos No Registrados</center></h3>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#paso9").val(facturas);
    valida_facturas1();
  }
}
function valida_facturas1()
{
  var facturas = $("#paso9").val();
  facturas = facturas.trim();
  if (facturas == "")
  {
    var valida = $("#paso_combus1").val();
    $("#vfa_"+valida).val('0');
    $("#bot_"+valida).html('');
    var valor = $("#paso_combus2").val();
    var valor1 = $("#paso_combus3").val();
    $("#vag_"+valida).val(valor);
    $("#vat_"+valida).val(valor1);
    suma();
    $("#dialogo4").dialog("close");
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_facturas1.php",
      data:
      {
        facturas: facturas
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
        if (valida > 0)
        {
          var detalle = "<center><h3>Debe cargar "+valida+" Factura(s)</center></h3>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          var valida = $("#paso_combus1").val();
          $("#vfa_"+valida).val('0');
          $("#bot_"+valida).html('');
          var valor = $("#paso_combus2").val();
          var valor1 = $("#paso_combus3").val();
          //$("#vag_"+valida).val(valor);
          //$("#vat_"+valida).val(valor1);
          suma();
          $("#dialogo4").dialog("close");
        }
      }
    });
  }
}
function valida_grasas()
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7, valor8, valor9, valor10, valor11, valor12, valor13, valor14, valor15, valor16, valor17, valor18, valor19;
  var facturas = "";
  var sigla = $("#sigla").val();
  $("#paso_grasas").val('');
  var salida = true;
  for (i=0;i<document.formu5.elements.length;i++)
  {
    saux = document.formu5.elements[i].name;
    if (saux.indexOf('gra1_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu5.elements[i].name;
    if (saux1.indexOf('gra2_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu5.elements[i].name;
    if (saux2.indexOf('gra3_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
    }
    saux3 = document.formu5.elements[i].name;
    if (saux3.indexOf('gra4_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
    }
    saux4 = document.formu5.elements[i].name;
    if (saux4.indexOf('gra5_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
    }
    saux5 = document.formu5.elements[i].name;
    if (saux5.indexOf('gra6_')!=-1)
    {
      valor5 = document.getElementById(saux5).value;
    }
    saux6 = document.formu5.elements[i].name;
    if (saux6.indexOf('gra7_')!=-1)
    {
      valor6 = document.getElementById(saux6).value;
    }
    saux7 = document.formu5.elements[i].name;
    if (saux7.indexOf('gra8_')!=-1)
    {
      valor7 = document.getElementById(saux7).value;
    }
    saux8 = document.formu5.elements[i].name;
    if (saux8.indexOf('gra9_')!=-1)
    {
      valor8 = document.getElementById(saux8).value;
    }
    saux9 = document.formu5.elements[i].name;
    if (saux9.indexOf('gra10_')!=-1)
    {
      valor9 = document.getElementById(saux9).value;
    }
    saux10 = document.formu5.elements[i].name;
    if (saux10.indexOf('gra11_')!=-1)
    {
      valor10 = document.getElementById(saux10).value;
    }
    saux11 = document.formu5.elements[i].name;
    if (saux11.indexOf('gra12_')!=-1)
    {
      valor11 = document.getElementById(saux11).value;
    }
    saux12 = document.formu5.elements[i].name;
    if (saux12.indexOf('gra13_')!=-1)
    {
      valor12 = document.getElementById(saux12).value;
    }
    saux13 = document.formu5.elements[i].name;
    if (saux13.indexOf('gra14_')!=-1)
    {
      valor13 = document.getElementById(saux13).value;
    }
    saux14 = document.formu5.elements[i].name;
    if (saux14.indexOf('gra15_')!=-1)
    {
      valor14 = document.getElementById(saux14).value;
    }
    saux15 = document.formu5.elements[i].name;
    if (saux15.indexOf('gra16_')!=-1)
    {
      valor15 = document.getElementById(saux15).value;
      valor15 = valor15.trim();
      if (valor12 == "0")
      {
      }
      else
      {
        if (valor15 == "")
        {
          salida = false;
        }
      }
    }
    saux16 = document.formu5.elements[i].name;
    if (saux16.indexOf('gra17_')!=-1)
    {
      valor16 = document.getElementById(saux16).value;
      valor16 = valor16.trim();
      if (valor12 == "0")
      {
      }
      else
      {
        if (valor16 == "")
        {
          salida = false;
        }
      }
    }
    saux17 = document.formu5.elements[i].name;
    if (saux17.indexOf('aleg_')!=-1)
    {
      valor17 = document.getElementById(saux17).value;
      valor18 = valor+"»"+valor1+"»"+valor2+"»"+valor11+"»"+valor12+"»"+valor3+"»"+valor4+"»"+valor6+"»"+valor13+"»"+valor14+"»"+valor7+"»"+valor8+"»"+valor9+"»"+valor10+"»"+valor5+"»"+valor15+"»"+valor16+"»"+valor17+"»"+sigla;
      document.getElementById('paso_grasas').value = document.getElementById('paso_grasas').value+valor18+"|";
      if (valor12 == "0")
      {
      }
      else
      {
        valor19 = valor1+"»"+sigla+"»"+valor17;
        facturas += valor19+"|";
      }
    }
  }
  if (salida == false)
  {
    var detalle = "<center><h3>Datos No Registrados</center></h3>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#paso10").val(facturas);
    valida_facturas2();
  }
}
function valida_facturas2()
{
  var facturas = $("#paso10").val();
  facturas = facturas.trim();
  if (facturas == "")
  {
    var valida = $("#paso_grasas1").val();
    $("#vfa_"+valida).val('0');
    $("#bot_"+valida).html('');
    var valor = $("#paso_grasas2").val();
    var valor1 = $("#paso_grasas3").val();
    $("#vag_"+valida).val(valor);
    $("#vat_"+valida).val(valor1);
    suma();
    $("#dialogo5").dialog("close");
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_facturas2.php",
      data:
      {
        facturas: facturas
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
        if (valida > 0)
        {
          var detalle = "<center><h3>Debe cargar "+valida+" Factura(s)</center></h3>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          var valida = $("#paso_grasas1").val();
          $("#vfa_"+valida).val('0');
          $("#bot_"+valida).html('');
          var valor = $("#paso_grasas2").val();
          var valor1 = $("#paso_grasas3").val();
          $("#vag_"+valida).val(valor);
          $("#vat_"+valida).val(valor1);
          suma();
          $("#dialogo5").dialog("close");
        }
      }
    });
  }
}
function valida_manteni()
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7, valor8, valor9, valor10, valor11, valor12, valor13, valor14, valor15, valor16, valor17, valor18, valor19, valor20, valor21;
  var facturas = "";
  var sigla = $("#sigla").val();
  $("#paso_manteni").val('');
  var salida = true;
  for (i=0;i<document.formu6.elements.length;i++)
  {
    saux = document.formu6.elements[i].name;
    if (saux.indexOf('man1_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu6.elements[i].name;
    if (saux1.indexOf('man2_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu6.elements[i].name;
    if (saux2.indexOf('man3_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
    }
    saux3 = document.formu6.elements[i].name;
    if (saux3.indexOf('man4_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
    }
    saux4 = document.formu6.elements[i].name;
    if (saux4.indexOf('man5_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
    }
    saux5 = document.formu6.elements[i].name;
    if (saux5.indexOf('man6_')!=-1)
    {
      valor5 = document.getElementById(saux5).value;
    }
    saux6 = document.formu6.elements[i].name;
    if (saux6.indexOf('man7_')!=-1)
    {
      valor6 = document.getElementById(saux6).value;
    }
    saux7 = document.formu6.elements[i].name;
    if (saux7.indexOf('man8_')!=-1)
    {
      valor7 = document.getElementById(saux7).value;
    }
    saux8 = document.formu6.elements[i].name;
    if (saux8.indexOf('man9_')!=-1)
    {
      valor8 = document.getElementById(saux8).value;
    }
    saux9 = document.formu6.elements[i].name;
    if (saux9.indexOf('man10_')!=-1)
    {
      valor9 = document.getElementById(saux9).value;
    }
    saux10 = document.formu6.elements[i].name;
    if (saux10.indexOf('man11_')!=-1)
    {
      valor10 = document.getElementById(saux10).value;
    }
    saux11 = document.formu6.elements[i].name;
    if (saux11.indexOf('man12_')!=-1)
    {
      valor11 = document.getElementById(saux11).value;
    }
    saux12 = document.formu6.elements[i].name;
    if (saux12.indexOf('man13_')!=-1)
    {
      valor12 = document.getElementById(saux12).value;
    }
    saux13 = document.formu6.elements[i].name;
    if (saux13.indexOf('man14_')!=-1)
    {
      valor13 = document.getElementById(saux13).value;
    }
    saux14 = document.formu6.elements[i].name;
    if (saux14.indexOf('man15_')!=-1)
    {
      valor14 = document.getElementById(saux14).value;
    }
    saux15 = document.formu6.elements[i].name;
    if (saux15.indexOf('man16_')!=-1)
    {
      valor15 = document.getElementById(saux15).value;
      valor15 = valor15.trim();
      if (valor12 == "0")
      {
      }
      else
      {
        if (valor15 == "")
        {
          salida = false;
        }
      }
    }
    saux16 = document.formu6.elements[i].name;
    if (saux16.indexOf('man17_')!=-1)
    {
      valor16 = document.getElementById(saux16).value;
      valor16 = valor16.trim();
      if (valor12 == "0")
      {
      }
      else
      {
        if (valor16 == "")
        {
          salida = false;
        }
      }
    }
    saux17 = document.formu6.elements[i].name;
    if (saux17.indexOf('man18_')!=-1)
    {
      valor17 = document.getElementById(saux17).value;
    }
    // kilometraje
    saux21 = document.formu6.elements[i].name;
    if (saux21.indexOf('man19_')!=-1)
    {
      valor21 = document.getElementById(saux21).value;
      valor21 = valor21.trim();
      if (valor12 == "0")
      {
      }
      else
      {
        if ((valor21 == "") || (valor21 == "0"))
        {
          salida = false;
        }
      }
    }
    saux18 = document.formu6.elements[i].name;
    if (saux18.indexOf('alem_')!=-1)
    {
      valor18 = document.getElementById(saux18).value;
      valor19 = valor+"»"+valor1+"»"+valor2+"»"+valor11+"»"+valor12+"»"+valor3+"»"+valor4+"»"+valor6+"»"+valor13+"»"+valor14+"»"+valor7+"»"+valor8+"»"+valor9+"»"+valor10+"»"+valor5+"»"+valor15+"»"+valor16+"»"+valor17+"»"+valor18+"»"+sigla+"»"+valor21;
      document.getElementById('paso_manteni').value = document.getElementById('paso_manteni').value+valor19+"|";
      if (valor12 == "0")
      {
      }
      else
      {
        valor20 = valor1+"»"+sigla+"»"+valor18;
        facturas += valor20+"|";
      }
    }
  }
  if (salida == false)
  {
    var detalle = "<center><h3>Datos No Registrados</center></h3>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#paso11").val(facturas);
    valida_facturas3();
  }
}
function valida_facturas3()
{
  var facturas = $("#paso11").val();
  facturas = facturas.trim();
  if (facturas == "")
  {
    var valida = $("#paso_manteni1").val();
    $("#vfa_"+valida).val('0');
    $("#bot_"+valida).html('');
    var valor = $("#paso_manteni2").val();
    var valor1 = $("#paso_manteni3").val();
    $("#vag_"+valida).val(valor);
    $("#vat_"+valida).val(valor1);
    suma();
    $("#dialogo6").dialog("close");
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_facturas3.php",
      data:
      {
        facturas: facturas
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
        if (valida > 0)
        {
          var detalle = "<center><h3>Debe cargar "+valida+" Factura(s)</center></h3>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          var valida = $("#paso_manteni1").val();
          $("#vfa_"+valida).val('0');
          $("#bot_"+valida).html('');
          var valor = $("#paso_manteni2").val();
          var valor1 = $("#paso_manteni3").val();
          $("#vag_"+valida).val(valor);
          $("#vat_"+valida).val(valor1);
          suma();
          $("#dialogo6").dialog("close");
        }
      }
    });
  }
}
function valida_tecnico()
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7, valor8, valor9, valor10, valor11, valor12, valor13;
  var facturas = "";
  var sigla = $("#sigla").val();
  $("#paso_tecnico").val('');
  var salida = true;
  for (i=0;i<document.formu7.elements.length;i++)
  {
    saux = document.formu7.elements[i].name;
    if (saux.indexOf('tec1_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu7.elements[i].name;
    if (saux1.indexOf('tec2_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu7.elements[i].name;
    if (saux2.indexOf('tec3_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
    }
    saux3 = document.formu7.elements[i].name;
    if (saux3.indexOf('tec4_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
    }
    saux4 = document.formu7.elements[i].name;
    if (saux4.indexOf('tec5_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
    }
    saux5 = document.formu7.elements[i].name;
    if (saux5.indexOf('tec6_')!=-1)
    {
      valor5 = document.getElementById(saux5).value;
    }
    saux6 = document.formu7.elements[i].name;
    if (saux6.indexOf('tec7_')!=-1)
    {
      valor6 = document.getElementById(saux6).value;
      $("#"+saux6).prop("disabled",true);
    }
    saux7 = document.formu7.elements[i].name;
    if (saux7.indexOf('tec8_')!=-1)
    {
      valor7 = document.getElementById(saux7).value;
    }
    saux8 = document.formu7.elements[i].name;
    if (saux8.indexOf('tec9_')!=-1)
    {
      valor8 = document.getElementById(saux8).value;
      valor8 = valor8.trim();
      if (valor7 == "0")
      {
      }
      else
      {
        if (valor8 == "")
        {
          salida = false;
        }
      }
    }
    saux9 = document.formu7.elements[i].name;
    if (saux9.indexOf('tec10_')!=-1)
    {
      valor9 = document.getElementById(saux9).value;
      valor9 = valor9.trim();
      if (valor7 == "0")
      {
      }
      else
      {
        if (valor9 == "")
        {
          salida = false;
        }
      }
    }
    // Kilometraje
    saux13 = document.formu7.elements[i].name;
    if (saux13.indexOf('tec11_')!=-1)
    {
      valor13 = document.getElementById(saux13).value;
      valor13 = valor13.trim();
      if (valor7 == "0")
      {
      }
      else
      {
        if ((valor13 == "") || (valor13 == "0"))
        {
          salida = false;
        }
      }
    }
    saux10 = document.formu7.elements[i].name;
    if (saux10.indexOf('alet_')!=-1)
    {
      valor10 = document.getElementById(saux10).value;
      valor11 = valor+"»"+valor1+"»"+valor2+"»"+valor6+"»"+valor7+"»"+valor3+"»"+valor4+"»"+valor5+"»"+valor8+"»"+valor9+"»"+valor10+"»"+sigla+"»"+valor13;
      document.getElementById('paso_tecnico').value = document.getElementById('paso_tecnico').value+valor11+"|";
      if (valor7 == "0")
      {
      }
      else
      {
        valor12 = valor1+"»"+sigla+"»"+valor10;
        facturas += valor12+"|";
      }
    }
  }
  if (salida == false)
  {
    var detalle = "<center><h3>Datos No Registrados</center></h3>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#paso12").val(facturas);
    valida_facturas4();
  }
}
function valida_facturas4()
{
  var facturas = $("#paso12").val();
  facturas = facturas.trim();
  if (facturas == "")
  {
    var valida = $("#paso_tecnico1").val();
    $("#vfa_"+valida).val('0');
    $("#bot_"+valida).html('');
    var valor = $("#paso_tecnico2").val();
    var valor1 = $("#paso_tecnico3").val();
    $("#vag_"+valida).val(valor);
    $("#vat_"+valida).val(valor1);
    suma();
    $("#dialogo7").dialog("close");
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_facturas4.php",
      data:
      {
        facturas: facturas
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
        if (valida > 0)
        {
          var detalle = "<center><h3>Debe cargar "+valida+" Factura(s)</center></h3>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          var valida = $("#paso_tecnico1").val();
          $("#vfa_"+valida).val('0');
          $("#bot_"+valida).html('');
          var valor = $("#paso_tecnico2").val();
          var valor1 = $("#paso_tecnico3").val();
          $("#vag_"+valida).val(valor);
          $("#vat_"+valida).val(valor1);
          suma();
          $("#dialogo7").dialog("close");
        }
      }
    });
  }
}
function valida_llantas()
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7, valor8, valor9, valor10, valor11, valor12, valor13, valor14, valor15, valor16;
  var facturas = "";
  var sigla = $("#sigla").val();
  $("#paso_llantas").val('');
  var salida = true;
  for (i=0;i<document.formu8.elements.length;i++)
  {
    saux = document.formu8.elements[i].name;
    if (saux.indexOf('lla1_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu8.elements[i].name;
    if (saux1.indexOf('lla2_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu8.elements[i].name;
    if (saux2.indexOf('lla3_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
    }
    saux3 = document.formu8.elements[i].name;
    if (saux3.indexOf('lla4_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
    }
    saux4 = document.formu8.elements[i].name;
    if (saux4.indexOf('lla5_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
    }
    saux5 = document.formu8.elements[i].name;
    if (saux5.indexOf('lla6_')!=-1)
    {
      valor5 = document.getElementById(saux5).value;
    }
    saux6 = document.formu8.elements[i].name;
    if (saux6.indexOf('lla7_')!=-1)
    {
      valor6 = document.getElementById(saux6).value;
    }
    saux7 = document.formu8.elements[i].name;
    if (saux7.indexOf('lla8_')!=-1)
    {
      valor7 = document.getElementById(saux7).value;
    }
    saux8 = document.formu8.elements[i].name;
    if (saux8.indexOf('lla9_')!=-1)
    {
      valor8 = document.getElementById(saux8).value;
    }
    saux9 = document.formu8.elements[i].name;
    if (saux9.indexOf('lla10_')!=-1)
    {
      valor9 = document.getElementById(saux9).value;
    }
    saux10 = document.formu8.elements[i].name;
    if (saux10.indexOf('lla11_')!=-1)
    {
      valor10 = document.getElementById(saux10).value;
    }
    saux11 = document.formu8.elements[i].name;
    if (saux11.indexOf('lla12_')!=-1)
    {
      valor11 = document.getElementById(saux11).value;
      valor11 = valor11.trim();
      if (valor10 == "0")
      {
      }
      else
      {
        if (valor11 == "")
        {
          salida = false;
        }
      }
    }
    saux12 = document.formu8.elements[i].name;
    if (saux12.indexOf('lla13_')!=-1)
    {
      valor12 = document.getElementById(saux12).value;
      valor12 = valor12.trim();
      if (valor10 == "0")
      {
      }
      else
      {
        if (valor12 == "")
        {
          salida = false;
        }
      }
    }
    saux16 = document.formu8.elements[i].name;
    if (saux16.indexOf('lla14_')!=-1)
    {
      valor16 = document.getElementById(saux16).value;
      valor16 = valor16.trim();
      if (valor10 == "0")
      {
      }
      else
      {
        if ((valor16 == "") || (valor16 == "0"))
        {
          salida = false;
        }
      }
    }
    saux13 = document.formu8.elements[i].name;
    if (saux13.indexOf('alel_')!=-1)
    {
      valor13 = document.getElementById(saux13).value;
      valor14 = valor+"»"+valor1+"»"+valor2+"»"+valor6+"»"+valor9+"»"+valor10+"»"+valor3+"»"+valor4+"»"+valor5+"»"+valor7+"»"+valor8+"»"+valor11+"»"+valor12+"»"+valor13+"»"+sigla+"»"+valor16;
      document.getElementById('paso_llantas').value = document.getElementById('paso_llantas').value+valor14+"|";
      if (valor10 == "0")
      {
      }
      else
      {
        valor15 = valor1+"»"+sigla+"»"+valor13;
        facturas += valor15+"|";
      }
    }
  }
  if (salida == false)
  {
    var detalle = "<center><h3>Datos No Registrados</center></h3>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#paso13").val(facturas);
    valida_facturas5();
  }
}
function valida_facturas5()
{
  var facturas = $("#paso13").val();
  facturas = facturas.trim();
  if (facturas == "")
  {
    var valida = $("#paso_llantas1").val();
    $("#vfa_"+valida).val('0');
    $("#bot_"+valida).html('');
    var valor = $("#paso_llantas2").val();
    var valor1 = $("#paso_llantas3").val();
    $("#vag_"+valida).val(valor);
    $("#vat_"+valida).val(valor1);
    suma();
    $("#dialogo8").dialog("close");
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_facturas5.php",
      data:
      {
        facturas: facturas
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
        if (valida > 0)
        {
          var detalle = "<center><h3>Debe cargar "+valida+" Factura(s)</center></h3>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          var valida = $("#paso_llantas1").val();
          $("#vfa_"+valida).val('0');
          $("#bot_"+valida).html('');
          var valor = $("#paso_llantas2").val();
          var valor1 = $("#paso_llantas3").val();
          $("#vag_"+valida).val(valor);
          $("#vat_"+valida).val(valor1);
          suma();
          $("#dialogo8").dialog("close");
        }
      }
    });
  }
}
function valida_combus1()
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7;
  var facturas = "";
  var sigla = $("#sigla").val();
  $("#paso_conbus").val('');
  var salida = true;
  for (i=0;i<document.formu41.elements.length;i++)
  {
    saux = document.formu41.elements[i].name;
    if (saux.indexOf('con1_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu41.elements[i].name;
    if (saux1.indexOf('con2_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu41.elements[i].name;
    if (saux2.indexOf('con3_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
      $("#"+saux2).prop("disabled",true);
    }
    saux3 = document.formu41.elements[i].name;
    if (saux3.indexOf('con4_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
    }
    saux4 = document.formu41.elements[i].name;
    if (saux4.indexOf('con5_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
    }
    saux5 = document.formu41.elements[i].name;
    if (saux5.indexOf('alecn_')!=-1)
    {
      valor5 = document.getElementById(saux5).value;
      valor6 = valor+"»"+valor1+"»"+valor2+"»"+valor3+"»"+valor4+"»"+valor5+"»"+sigla;
      document.getElementById('paso_conbus').value = document.getElementById('paso_conbus').value+valor6+"|";
      if (valor3 == "0")
      {
      }
      else
      {
        valor7 = valor1+"»"+sigla+"»"+valor5;
        facturas += valor7+"|";
      }
    }
  }
  if (salida == false)
  {
    var detalle = "<center><h3>Datos No Registrados</center></h3>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#paso16").val(facturas);
    valida_facturas11();
  }
}
function valida_facturas11()
{
  var facturas = $("#paso16").val();
  facturas = facturas.trim();
  if (facturas == "")
  {
    var valida = $("#paso_conbus1").val();
    $("#vfa_"+valida).val('0');
    $("#bot_"+valida).html('');
    var valor = $("#paso_conbus2").val();
    var valor1 = $("#paso_conbus3").val();
    $("#vag_"+valida).val(valor);
    $("#vat_"+valida).val(valor1);
    suma();
    $("#dialogo41").dialog("close");
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_facturas7.php",
      data:
      {
        facturas: facturas
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
        if (valida > 0)
        {
          var detalle = "<center><h3>Debe cargar "+valida+" Factura(s)</center></h3>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          var valida = $("#paso_conbus1").val();
          $("#vfa_"+valida).val('0');
          $("#bot_"+valida).html('');
          var valor = $("#paso_conbus2").val();
          var valor1 = $("#paso_conbus3").val();
          //$("#vag_"+valida).val(valor);
          //$("#vat_"+valida).val(valor1);
          suma();
          $("#dialogo41").dialog("close");
        }
      }
    });
  }
}
function valida_tecnico1()
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7, valor8, valor9, valor10, valor11, valor12, valor13;
  var facturas = "";
  var sigla = $("#sigla").val();
  $("#paso_tecnido").val('');
  var salida = true;
  for (i=0;i<document.formu71.elements.length;i++)
  {
    saux = document.formu71.elements[i].name;
    if (saux.indexOf('ted1_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu71.elements[i].name;
    if (saux1.indexOf('ted2_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu71.elements[i].name;
    if (saux2.indexOf('ted3_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
    }
    saux3 = document.formu71.elements[i].name;
    if (saux3.indexOf('ted4_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
    }
    saux4 = document.formu71.elements[i].name;
    if (saux4.indexOf('ted5_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
    }
    saux5 = document.formu71.elements[i].name;
    if (saux5.indexOf('ted6_')!=-1)
    {
      valor5 = document.getElementById(saux5).value;
    }
    saux6 = document.formu71.elements[i].name;
    if (saux6.indexOf('ted7_')!=-1)
    {
      valor6 = document.getElementById(saux6).value;
      $("#"+saux6).prop("disabled",true);
    }
    saux7 = document.formu71.elements[i].name;
    if (saux7.indexOf('ted8_')!=-1)
    {
      valor7 = document.getElementById(saux7).value;
    }
    saux8 = document.formu71.elements[i].name;
    if (saux8.indexOf('ted9_')!=-1)
    {
      valor8 = document.getElementById(saux8).value;
      valor8 = valor8.trim();
      if (valor7 == "0")
      {
      }
      else
      {
        if (valor8 == "")
        {
          salida = false;
        }
      }
    }
    saux9 = document.formu71.elements[i].name;
    if (saux9.indexOf('ted10_')!=-1)
    {
      valor9 = document.getElementById(saux9).value;
      valor9 = valor9.trim();
      if (valor7 == "0")
      {
      }
      else
      {
        if (valor9 == "")
        {
          salida = false;
        }
      }
    }
    // Kilometraje
    saux13 = document.formu71.elements[i].name;
    if (saux13.indexOf('ted11_')!=-1)
    {
      valor13 = document.getElementById(saux13).value;
      valor13 = valor13.trim();
      if (valor7 == "0")
      {
      }
      else
      {
        if ((valor13 == "") || (valor13 == "0"))
        {
          salida = false;
        }
      }
    }
    saux10 = document.formu71.elements[i].name;
    if (saux10.indexOf('aletd_')!=-1)
    {
      valor10 = document.getElementById(saux10).value;
      valor11 = valor+"»"+valor1+"»"+valor2+"»"+valor6+"»"+valor7+"»"+valor3+"»"+valor4+"»"+valor5+"»"+valor8+"»"+valor9+"»"+valor10+"»"+sigla+"»"+valor13;
      document.getElementById('paso_tecnido').value = document.getElementById('paso_tecnido').value+valor11+"|";
      if (valor7 == "0")
      {
      }
      else
      {
        valor12 = valor1+"»"+sigla+"»"+valor10;
        facturas += valor12+"|";
      }
    }
  }
  if (salida == false)
  {
    var detalle = "<center><h3>Datos No Registrados</center></h3>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#paso15").val(facturas);
    valida_facturas41();
  }
}
function valida_facturas41()
{
  var facturas = $("#paso15").val();
  facturas = facturas.trim();
  if (facturas == "")
  {
    var valida = $("#paso_tecnido1").val();
    $("#vfa_"+valida).val('0');
    $("#bot_"+valida).html('');
    var valor = $("#paso_tecnido2").val();
    var valor1 = $("#paso_tecnido3").val();
    $("#vag_"+valida).val(valor);
    $("#vat_"+valida).val(valor1);
    suma();
    $("#dialogo71").dialog("close");
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_facturas6.php",
      data:
      {
        facturas: facturas
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
        if (valida > 0)
        {
          var detalle = "<center><h3>Debe cargar "+valida+" Factura(s)</center></h3>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          var valida = $("#paso_tecnido1").val();
          $("#vfa_"+valida).val('0');
          $("#bot_"+valida).html('');
          var valor = $("#paso_tecnido2").val();
          var valor1 = $("#paso_tecnido3").val();
          $("#vag_"+valida).val(valor);
          $("#vat_"+valida).val(valor1);
          suma();
          $("#dialogo71").dialog("close");
        }
      }
    });
  }
}
function valida_llantas1()
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7, valor8, valor9, valor10, valor11, valor12, valor13, valor14, valor15, valor16;
  var facturas = "";
  var sigla = $("#sigla").val();
  $("#paso_llamtas").val('');
  var salida = true;
  for (i=0;i<document.formu81.elements.length;i++)
  {
    saux = document.formu81.elements[i].name;
    if (saux.indexOf('lln1_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu81.elements[i].name;
    if (saux1.indexOf('lln2_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu81.elements[i].name;
    if (saux2.indexOf('lln3_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
    }
    saux3 = document.formu81.elements[i].name;
    if (saux3.indexOf('lln4_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
    }
    saux4 = document.formu81.elements[i].name;
    if (saux4.indexOf('lln5_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
    }
    saux5 = document.formu81.elements[i].name;
    if (saux5.indexOf('lln6_')!=-1)
    {
      valor5 = document.getElementById(saux5).value;
    }
    saux6 = document.formu81.elements[i].name;
    if (saux6.indexOf('lln7_')!=-1)
    {
      valor6 = document.getElementById(saux6).value;
    }
    saux7 = document.formu81.elements[i].name;
    if (saux7.indexOf('lln8_')!=-1)
    {
      valor7 = document.getElementById(saux7).value;
    }
    saux8 = document.formu81.elements[i].name;
    if (saux8.indexOf('lln9_')!=-1)
    {
      valor8 = document.getElementById(saux8).value;
    }
    saux9 = document.formu81.elements[i].name;
    if (saux9.indexOf('lln10_')!=-1)
    {
      valor9 = document.getElementById(saux9).value;
    }
    saux10 = document.formu81.elements[i].name;
    if (saux10.indexOf('lln11_')!=-1)
    {
      valor10 = document.getElementById(saux10).value;
    }
    saux11 = document.formu81.elements[i].name;
    if (saux11.indexOf('lln12_')!=-1)
    {
      valor11 = document.getElementById(saux11).value;
      valor11 = valor11.trim();
      if (valor10 == "0")
      {
      }
      else
      {
        if (valor11 == "")
        {
          salida = false;
        }
      }
    }
    saux12 = document.formu81.elements[i].name;
    if (saux12.indexOf('lln13_')!=-1)
    {
      valor12 = document.getElementById(saux12).value;
      valor12 = valor12.trim();
      if (valor10 == "0")
      {
      }
      else
      {
        if (valor12 == "")
        {
          salida = false;
        }
      }
    }
    saux16 = document.formu81.elements[i].name;
    if (saux16.indexOf('lln14_')!=-1)
    {
      valor16 = document.getElementById(saux16).value;
      valor16 = valor16.trim();
      if (valor10 == "0")
      {
      }
      else
      {
        if ((valor16 == "") || (valor16 == "0"))
        {
          salida = false;
        }
      }
    }
    saux13 = document.formu81.elements[i].name;
    if (saux13.indexOf('alell_')!=-1)
    {
      valor13 = document.getElementById(saux13).value;
      valor14 = valor+"»"+valor1+"»"+valor2+"»"+valor6+"»"+valor9+"»"+valor10+"»"+valor3+"»"+valor4+"»"+valor5+"»"+valor7+"»"+valor8+"»"+valor11+"»"+valor12+"»"+valor13+"»"+sigla+"»"+valor16;
      document.getElementById('paso_llamtas').value = document.getElementById('paso_llamtas').value+valor14+"|";
      if (valor10 == "0")
      {
      }
      else
      {
        valor15 = valor1+"»"+sigla+"»"+valor13;
        facturas += valor15+"|";
      }
    }
  }
  if (salida == false)
  {
    var detalle = "<center><h3>Datos No Registrados</center></h3>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#paso17").val(facturas);
    valida_facturas51();
  }
}
function valida_facturas51()
{
  var facturas = $("#paso17").val();
  facturas = facturas.trim();
  if (facturas == "")
  {
    var valida = $("#paso_llamtas1").val();
    $("#vfa_"+valida).val('0');
    $("#bot_"+valida).html('');
    var valor = $("#paso_llamtas2").val();
    var valor1 = $("#paso_llamtas3").val();
    $("#vag_"+valida).val(valor);
    $("#vat_"+valida).val(valor1);
    suma();
    $("#dialogo81").dialog("close");
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_facturas8.php",
      data:
      {
        facturas: facturas
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
        if (valida > 0)
        {
          var detalle = "<center><h3>Debe cargar "+valida+" Factura(s)</center></h3>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          var valida = $("#paso_llamtas1").val();
          $("#vfa_"+valida).val('0');
          $("#bot_"+valida).html('');
          var valor = $("#paso_llamtas2").val();
          var valor1 = $("#paso_llamtas3").val();
          $("#vag_"+valida).val(valor);
          $("#vat_"+valida).val(valor1);
          suma();
          $("#dialogo81").dialog("close");
        }
      }
    });
  }
}
function valida_manteni1()
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7, valor8, valor9, valor10, valor11, valor12, valor13, valor14, valor15, valor16, valor17, valor18, valor19, valor20, valor21;
  var facturas = "";
  var sigla = $("#sigla").val();
  $("#paso_mamteni").val('');
  var salida = true;
  for (i=0;i<document.formu61.elements.length;i++)
  {
    saux = document.formu61.elements[i].name;
    if (saux.indexOf('mam1_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu61.elements[i].name;
    if (saux1.indexOf('mam2_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu61.elements[i].name;
    if (saux2.indexOf('mam3_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
    }
    saux3 = document.formu61.elements[i].name;
    if (saux3.indexOf('mam4_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
    }
    saux4 = document.formu61.elements[i].name;
    if (saux4.indexOf('mam5_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
    }
    saux5 = document.formu61.elements[i].name;
    if (saux5.indexOf('mam6_')!=-1)
    {
      valor5 = document.getElementById(saux5).value;
    }
    saux6 = document.formu61.elements[i].name;
    if (saux6.indexOf('mam7_')!=-1)
    {
      valor6 = document.getElementById(saux6).value;
    }
    saux7 = document.formu61.elements[i].name;
    if (saux7.indexOf('mam8_')!=-1)
    {
      valor7 = document.getElementById(saux7).value;
    }
    saux8 = document.formu61.elements[i].name;
    if (saux8.indexOf('mam9_')!=-1)
    {
      valor8 = document.getElementById(saux8).value;
    }
    saux9 = document.formu61.elements[i].name;
    if (saux9.indexOf('mam10_')!=-1)
    {
      valor9 = document.getElementById(saux9).value;
    }
    saux10 = document.formu61.elements[i].name;
    if (saux10.indexOf('mam11_')!=-1)
    {
      valor10 = document.getElementById(saux10).value;
    }
    saux11 = document.formu61.elements[i].name;
    if (saux11.indexOf('mam12_')!=-1)
    {
      valor11 = document.getElementById(saux11).value;
    }
    saux12 = document.formu61.elements[i].name;
    if (saux12.indexOf('mam13_')!=-1)
    {
      valor12 = document.getElementById(saux12).value;
    }
    saux13 = document.formu61.elements[i].name;
    if (saux13.indexOf('mam14_')!=-1)
    {
      valor13 = document.getElementById(saux13).value;
    }
    saux14 = document.formu61.elements[i].name;
    if (saux14.indexOf('mam15_')!=-1)
    {
      valor14 = document.getElementById(saux14).value;
    }
    saux15 = document.formu61.elements[i].name;
    if (saux15.indexOf('mam16_')!=-1)
    {
      valor15 = document.getElementById(saux15).value;
      valor15 = valor15.trim();
      if (valor12 == "0")
      {
      }
      else
      {
        if (valor15 == "")
        {
          salida = false;
        }
      }
    }
    saux16 = document.formu61.elements[i].name;
    if (saux16.indexOf('mam17_')!=-1)
    {
      valor16 = document.getElementById(saux16).value;
      valor16 = valor16.trim();
      if (valor12 == "0")
      {
      }
      else
      {
        if (valor16 == "")
        {
          salida = false;
        }
      }
    }
    saux17 = document.formu61.elements[i].name;
    if (saux17.indexOf('mam18_')!=-1)
    {
      valor17 = document.getElementById(saux17).value;
    }
    // kilometraje
    saux21 = document.formu61.elements[i].name;
    if (saux21.indexOf('mam19_')!=-1)
    {
      valor21 = document.getElementById(saux21).value;
      valor21 = valor21.trim();
      if (valor12 == "0")
      {
      }
      else
      {
        if ((valor21 == "") || (valor21 == "0"))
        {
          salida = false;
        }
      }
    }
    saux18 = document.formu61.elements[i].name;
    if (saux18.indexOf('alema_')!=-1)
    {
      valor18 = document.getElementById(saux18).value;
      valor19 = valor+"»"+valor1+"»"+valor2+"»"+valor11+"»"+valor12+"»"+valor3+"»"+valor4+"»"+valor6+"»"+valor13+"»"+valor14+"»"+valor7+"»"+valor8+"»"+valor9+"»"+valor10+"»"+valor5+"»"+valor15+"»"+valor16+"»"+valor17+"»"+valor18+"»"+sigla+"»"+valor21;
      document.getElementById('paso_mamteni').value = document.getElementById('paso_mamteni').value+valor19+"|";
      if (valor12 == "0")
      {
      }
      else
      {
        valor20 = valor1+"»"+sigla+"»"+valor18;
        facturas += valor20+"|";
      }
    }
  }
  if (salida == false)
  {
    var detalle = "<center><h3>Datos No Registrados</center></h3>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#paso18").val(facturas);
    valida_facturas31();
  }
}
function valida_facturas31()
{
  var facturas = $("#paso18").val();
  facturas = facturas.trim();
  if (facturas == "")
  {
    var valida = $("#paso_mamteni1").val();
    $("#vfa_"+valida).val('0');
    $("#bot_"+valida).html('');
    var valor = $("#paso_mamteni2").val();
    var valor1 = $("#paso_mamteni3").val();
    $("#vag_"+valida).val(valor);
    $("#vat_"+valida).val(valor1);
    suma();
    $("#dialogo61").dialog("close");
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_facturas9.php",
      data:
      {
        facturas: facturas
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
        if (valida > 0)
        {
          var detalle = "<center><h3>Debe cargar "+valida+" Factura(s)</center></h3>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          var valida = $("#paso_mamteni1").val();
          $("#vfa_"+valida).val('0');
          $("#bot_"+valida).html('');
          var valor = $("#paso_mamteni2").val();
          var valor1 = $("#paso_mamteni3").val();
          $("#vag_"+valida).val(valor);
          $("#vat_"+valida).val(valor1);
          suma();
          $("#dialogo61").dialog("close");
        }
      }
    });
  }
}
function val_caracteres(valor)
{
  var valor;
  var detalle = $("#des_"+valor).val();
  detalle = detalle.replace(/[#]+/g, "No.");
  detalle = detalle.replace(/[•]+/g, "*");
  detalle = detalle.replace(/[●]+/g, "*");
  detalle = detalle.replace(/[é́]+/g, "é");
  detalle = detalle.replace(/[]+/g, "*");
  detalle = detalle.replace(/[]+/g, "*");
  detalle = detalle.replace(/[]+/g, "*");
  detalle = detalle.replace(/[ ]+/g, " ");
  detalle = detalle.replace(/[ ]+/g, '');
  detalle = detalle.replace(/[–]+/g, "-");
  detalle = detalle.replace(/[—]+/g, '-');
  detalle = detalle.replace(/[…]+/g, "..."); 
  detalle = detalle.replace(/[“”]+/g, '"');
  detalle = detalle.replace(/[‘]+/g, '´');
  detalle = detalle.replace(/[’]+/g, '´');
  detalle = detalle.replace(/[']+/g, '´');
  detalle = detalle.replace(/[′]+/g, '´');
  $("#des_"+valor).val(detalle);
}
function cargar(valor)
{
  var valor;
  var alea = $("#ale_"+valor).val();
  var sigla = $("#sigla").val();
  var url = "<a href='./subir7.php?alea="+alea+"&sigla="+sigla+"' name='lnk1' id='lnk1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnk1").click();
}
function cargac(valor)
{
  var valor;
  var alea = $("#alec_"+valor).val();
  var sigla = $("#sigla").val();
  var placa = $("#com2_"+valor).val();
  var url = "<a href='./subir16.php?alea="+alea+"&sigla="+sigla+"&placa="+placa+"' name='lnkc1' id='lnkc1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnkc1").click();
}
function cargacn(valor)
{
  var valor;
  var alea = $("#alecn_"+valor).val();
  var sigla = $("#sigla").val();
  var placa = $("#con2_"+valor).val();
  var url = "<a href='./subir16.php?alea="+alea+"&sigla="+sigla+"&placa="+placa+"' name='lnkc1' id='lnkc1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnkc1").click();
}
function cargag(valor)
{
  var valor;
  var alea = $("#aleg_"+valor).val();
  var sigla = $("#sigla").val();
  var placa = $("#gra2_"+valor).val();
  var url = "<a href='./subir17.php?alea="+alea+"&sigla="+sigla+"&placa="+placa+"' name='lnkg1' id='lnkg1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnkg1").click();
}
function cargam(valor)
{
  var valor;
  var alea = $("#alem_"+valor).val();
  var sigla = $("#sigla").val();
  var placa = $("#man2_"+valor).val();
  var url = "<a href='./subir18.php?alea="+alea+"&sigla="+sigla+"&placa="+placa+"' name='lnkm1' id='lnkm1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnkm1").click();
}
function cargama(valor)
{
  var valor;
  var alea = $("#alema_"+valor).val();
  var sigla = $("#sigla").val();
  var placa = $("#mam2_"+valor).val();
  var url = "<a href='./subir18.php?alea="+alea+"&sigla="+sigla+"&placa="+placa+"' name='lnkma1' id='lnkma1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnkma1").click();
}
function cargat(valor)
{
  var valor;
  var alea = $("#alet_"+valor).val();
  var sigla = $("#sigla").val();
  var placa = $("#tec2_"+valor).val();
  var url = "<a href='./subir19.php?alea="+alea+"&sigla="+sigla+"&placa="+placa+"' name='lnkt1' id='lnkt1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnkt1").click();
}
function cargatd(valor)
{
  var valor;
  var alea = $("#aletd_"+valor).val();
  var sigla = $("#sigla").val();
  var placa = $("#ted2_"+valor).val();
  var url = "<a href='./subir19.php?alea="+alea+"&sigla="+sigla+"&placa="+placa+"' name='lnkt1' id='lnkt1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnkt1").click();
}
function cargal(valor)
{
  var valor;
  var alea = $("#alel_"+valor).val();
  var sigla = $("#sigla").val();
  var placa = $("#lla2_"+valor).val();
  var url = "<a href='./subir20.php?alea="+alea+"&sigla="+sigla+"&placa="+placa+"' name='lnkl1' id='lnkl1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnkl1").click();
}
function cargall(valor)
{
  var valor;
  var alea = $("#alell_"+valor).val();
  var sigla = $("#sigla").val();
  var placa = $("#lln2_"+valor).val();
  var url = "<a href='./subir20.php?alea="+alea+"&sigla="+sigla+"&placa="+placa+"' name='lnkl1' id='lnkl1' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnkl1").click();
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
</script>
</body>
</html>
<?php
}
// 27/10/2023 - Inclusion kilometraje en relacion de gastos
// 30/11/2023 - Ajuste Llantas
// 01/12/2023 - Ajuste validacion kilometraje y bloqueo pegado
?>