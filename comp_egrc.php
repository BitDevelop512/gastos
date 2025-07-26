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
  $dateObj   = DateTime::createFromFormat('!m', $mes);
  $monthName = $dateObj->format('F');
  $dateObj1   = DateTime::createFromFormat('!m', $mes1);
  $monthName1 = $dateObj1->format('F');
  $mes_act = nombre_mes($mes);
  $mes_sig = nombre_mes($mes1);
  $ano = date('Y');
  $tipo = "1";
  $n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
  $query = "SELECT firma1, firma2, firma3, firma4, cargo1, cargo2, cargo3, cargo4, unidad, dependencia, saldo, cheque FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $query);
  $firma1 = trim(utf8_encode(odbc_result($cur,1)));
  $firma2 = trim(utf8_encode(odbc_result($cur,2)));
  $firma3 = trim(utf8_encode(odbc_result($cur,3)));
  $firma4 = trim(utf8_encode(odbc_result($cur,4)));
  $cargo1 = trim(utf8_encode(odbc_result($cur,5)));
  $cargo2 = trim(utf8_encode(odbc_result($cur,6)));
  $cargo3 = trim(utf8_encode(odbc_result($cur,7)));
  $cargo4 = trim(utf8_encode(odbc_result($cur,8)));
  $n_unidad = odbc_result($cur,9);
  $n_dependencia = odbc_result($cur,10);
  $saldo = odbc_result($cur,11);
  $saldo1 = number_format($saldo,2);
  $cheque = odbc_result($cur,12);
  list($inicial, $final, $actual) = explode("|", $cheque);
  $inicial = trim($inicial);
  $final = trim($final);
  $actual = trim($actual);
  if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' AND unic='0' ORDER BY subdependencia";
  }
  else
  {
    $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND unic!='1' ORDER BY subdependencia"; 
  }
  $cur1 = odbc_exec($conexion, $query1);
  $numero = "";
  while($i<$row=odbc_fetch_array($cur1))
  {
    $numero.="'".odbc_result($cur1,1)."',";
  }
  $numero = substr($numero,0,-1);
  $numero = trim($numero);
  // Se verifica si es unidad centralizadora especial
  if (strpos($especial, $uni_usuario) !== false)
  {
  	if ($numero == "")
  	{
  	}
  	else
  	{
    	$numero .= ",";
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
        $numero .= "'".odbc_result($cur1,1)."',";
      }
    }
    $numero = substr($numero,0,-1);
    $numero = $numero.",'".$uni_usuario."'";
  }
  $conceptos1 = "<option value='1'>GASTOS EN ACTIVIDADES</option><option value='2'>PAGO DE INFORMACIONES</option>";
  $conceptos2 = "<option value='3'>PAGO DE RECOMPENSAS</option>";
  $conceptos3 = "<option value='0'>DEVOLUCIONES A CEDE2</option>";
  $conceptos4 = "<option value='4'>GASTOS DE PROTECCION</option>";
  $conceptos5 = "<option value='5'>GASTOS DE IDENTIDAD DE COBERTURA</option>";
  $conceptos6 = "<option value='1'>GASTOS EN ACTIVIDADES</option>";
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
          <h3>Comprobantes de Egreso Unidad Centralizadora</h3>
        	<div>
    				<div id="load">
    			  	<center>
    			   		<img src="imagenes/cargando1.gif" alt="Cargando...">
    			 		</center>
    				</div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Nº Egreso</font></label>
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
                  <input type="hidden" name="sigla" id="sigla" class="form-control" value="<?php echo $sig_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="siglas" id="siglas" class="form-control" value="" readonly="readonly" tabindex="0">
                  <input type="hidden" name="tipo" id="tipo" class="form-control" value="<?php echo $tipo; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="inicial" id="inicial" class="form-control" value="<?php echo $inicial; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="final" id="final" class="form-control" value="<?php echo $final; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="actual" id="actual" class="form-control" value="<?php echo $actual; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="chequera" id="chequera" class="form-control" readonly="readonly" tabindex="0">
                  <input type="hidden" name="unidades" id="unidades" class="form-control" value="<?php echo $numero; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="n_mes" id="n_mes" class="form-control" value="<?php echo $n_meses[$mes-1]; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="n_ano" id="n_ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="valida1" id="valida1" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="subdependencia" id="subdependencia" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="unidad2" id="unidad2" class="form-control" value="<?php echo $nun_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="dat_aut" id="dat_aut" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_ciudad" id="v_ciudad" class="form-control" value="<?php echo $ciu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="conceptos1" id="conceptos1" class="form-control" value="<?php echo $conceptos1; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="conceptos2" id="conceptos2" class="form-control" value="<?php echo $conceptos2; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="conceptos3" id="conceptos3" class="form-control" value="<?php echo $conceptos3; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="conceptos4" id="conceptos4" class="form-control" value="<?php echo $conceptos4; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="conceptos5" id="conceptos5" class="form-control" value="<?php echo $conceptos5; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="conceptos6" id="conceptos6" class="form-control" value="<?php echo $conceptos6; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_pasoc" id="v_pasoc" class="form-control" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_crp" id="v_crp" class="form-control" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_sal" id="v_sal" class="form-control" readonly="readonly" tabindex="0">
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
                  <select name="cuenta" id="cuenta" class="form-control select2" tabindex="4" onchange="trae_saldos(); trae_crps();"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="saldo" id="saldo" class="form-control numero" value="<?php echo $saldo1; ?>" readonly="readonly" tabindex="5">
                  <input type="hidden" name="saldo1" id="saldo1" class="form-control numero" value="<?php echo $saldo; ?>" readonly="readonly" tabindex="6">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Concepto</font></label>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Concepto del Gasto</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Recurso</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Rubro</font></label>
                </div>
                <div id="sal_crp1">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Saldo CRP</font></label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <?php
                  $menu2_2 = odbc_exec($conexion,"SELECT * FROM cx_ctr_gas WHERE codigo IN ('8', '9', '10', '18') ORDER BY codigo");
                  $menu2 = "<select name='concepto' id='concepto' class='form-control select2' onchange='trae_gastos(); trae_valores();' tabindex='13'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu2_2))
                  {
                    $nombre = utf8_encode($row['nombre']);
                    $menu2 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  if (($uni_usuario == "1") and ($usu_usuario == "STE_DIADI"))
                  {
                    $menu2_4 = odbc_exec($conexion,"SELECT * FROM cx_ctr_gas WHERE codigo IN ('14', '24', '26') ORDER BY codigo");
                    $i = 1;
                    while($i<$row=odbc_fetch_array($menu2_4))
                    {
                      $nombre = utf8_encode($row['nombre']);
                      $menu2 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                      $i++;
                    }
                  }
                  $menu2 .= "\n<option value='99'>PRESUPUESTO BASICO MENSUAL PDM</option>";
                  $menu2 .= "\n<option value='98'>PRESUPUESTO BASICO MENSUAL MANUAL</option>";
                  $menu2_3 = odbc_exec($conexion,"SELECT * FROM cx_ctr_gas WHERE codigo IN ('2', '4', '5', '6', '7') ORDER BY codigo");
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu2_3))
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
                  <select name="tp_gasto" id="tp_gasto" class="form-control select2" tabindex="14"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <select name="recurso" id="recurso" class="form-control select2" tabindex="15">
                    <option value="1">10 CSF</option>
                    <option value="2">50 SSF</option>
                    <option value="3">16 SSF</option>
                    <option value="4">OTROS</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <select name="rubro" id="rubro" class="form-control select2" tabindex="16">
                    <option value="3">A-02-02-04</option>
                    <option value="1">204-20-1</option>
                    <option value="2">204-20-2</option>
                  </select>
                </div>
                <div id="sal_crp">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="saldo2" id="saldo2" class="form-control numero" value="0.00" readonly="readonly" tabindex="17">
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Unidades</font></label>
                  <div id="resultados1"></div>
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <div class="row">
                    <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                      <div id="lblcrp1">
                        <label><font face="Verdana" size="2">CRP</font></label>
                        <select name="crp1" id="crp1" class="form-control select2" tabindex="7"></select>
                      </div>
                    </div>
                    <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                      <div id="lblcrp2">
                        <label><font face="Verdana" size="2">Valor CRP</font></label>
                        <input type="text" name="val_crp" id="val_crp" class="form-control numero" value="0.00" onkeyup="paso_val2();" tabindex="8">
                        <input type="hidden" name="val_crp1" id="val_crp1" class="form-control numero" value="0" readonly="readonly" tabindex="9">
                        <input type="hidden" name="val_crp2" id="val_crp2" class="form-control numero" value="0" readonly="readonly" tabindex="10">
                      </div>
                    </div>
                    <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                      <div id="lblcdp1">
                        <label><font face="Verdana" size="2">CDP</font></label>
                        <select name="cdp1" id="cdp1" class="form-control select2" tabindex="11"></select>
                      </div>
                    </div>
                  </div>
                  <div id="lblcrp3">
                    <div class="espacio4"></div>
                    <div class="row">
                      <div id="add_form">
                        <table width="100%" align="center" border="0"></table>
                      </div>
                    </div>
                    <div class="espacio2"></div>
                    <div class="row">
                      <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                        <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0" tabindex="12"></a>
                      </div>
                    </div>
                    <div class="espacio1"></div>
                    <div class="row">
                      <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4"></div>
                      <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                        <label><font face="Verdana" size="2">Suma Total CRP</font></label>
                        <input type="text" name="tot_crp" id="tot_crp" class="form-control numero" value="0"  readonly="readonly" tabindex="22">
                        <input type="hidden" name="tot_crp1" id="tot_crp1" class="form-control numero" value="0.00" readonly="readonly" tabindex="23">
                      </div>
                      <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                        <label><font face="Verdana" size="2">Diferencia</font></label>
                        <input type="text" name="diferencia" id="diferencia" class="form-control numero" value="0.00" readonly="readonly" tabindex="24">
                        <input type="hidden" name="can_crp" id="can_crp" class="form-control numero" value="0" readonly="readonly" tabindex="0">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Autorizaci&oacute;n</font></label>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">No.</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor Egreso</font></label>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <div id="u_unidad2">
                    <label><font face="Verdana" size="2">Unidad</font></label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <?php
                  $menu2_2 = odbc_exec($conexion,"SELECT * FROM cx_ctr_aut WHERE estado='' ORDER BY codigo");
                  $menu2 = "<select name='autoriza' id='autoriza' class='form-control select2' tabindex='18'>";
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
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <input type="hidden" name="num_gir" id="num_gir" class="form-control numero" value="0" readonly="readonly" tabindex="19">
                  <input type="text" name="num_aut" id="num_aut" class="form-control numero" value="0" tabindex="20">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="valor" id="valor" class="form-control numero" value="0.00" readonly="readonly" tabindex="21">
                  <input type="hidden" name="valor1" id="valor1" class="form-control numero" tabindex="22">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <div id="u_unidad1">
                    <select name="unidad1" id="unidad1" class="form-control select2" onchange="cambia_unidad();" tabindex="23"></select>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Soporte</font></label>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">No.</font></label>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Medio de Pago</font></label>
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <select name="soporte" id="soporte" class="form-control select2" tabindex="24"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <input type="text" name="num_sop" id="num_sop" class="form-control numero" maxlength="250" tabindex="25">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <?php
                  $menu3_3 = odbc_exec($conexion,"SELECT * FROM cx_ctr_med WHERE estado='' ORDER BY codigo");
                  $menu3 = "<select name='pago' id='pago' class='form-control select2' tabindex='26'>";
                  $i = 1;
                  while($i<$row=odbc_fetch_array($menu3_3))
                  {
                    $nombre = utf8_encode($row['nombre']);
                    $menu3 .= "\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                  }
                  $menu3 .= "\n</select>";
                  echo $menu3;
                  ?>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="text" name="cash" id="cash" class="form-control numero" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check(event);" maxlength="30" tabindex="27" autocomplete="off">
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
                  <input type="text" name="firma1" id="firma1" class="form-control" value="<?php echo $firma1; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="28" autocomplete="off">
                  <div class="espacio1"></div>
                  <input type="text" name="cargo1" id="cargo1" class="form-control" value="<?php echo $cargo1; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="29" autocomplete="off">
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <input type="text" name="firma2" id="firma2" class="form-control" value="<?php echo $firma2; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="30" autocomplete="off">
                  <div class="espacio1"></div>
                  <input type="text" name="cargo2" id="cargo2" class="form-control" value="<?php echo $cargo2; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="31" autocomplete="off">
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
                  <input type="text" name="firma3" id="firma3" class="form-control" value="<?php echo $firma3; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="32" autocomplete="off">
                  <div class="espacio1"></div>
                  <input type="text" name="cargo3" id="cargo3" class="form-control" value="<?php echo $cargo3; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="33" autocomplete="off">
                </div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <input type="text" name="firma4" id="firma4" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="34" autocomplete="off">
                  <div class="espacio1"></div>
                  <input type="text" name="cargo4" id="cargo4" class="form-control" value="<?php echo $car_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="35" autocomplete="off">
                  <input type="hidden" name="datos" id="datos" class="form-control" readonly="readonly" tabindex="36">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <label><font face="Verdana" size="2">Revis&oacute;</font></label>
                  <input type="text" name="reviso" id="reviso" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="37" autocomplete="off">
                  <div class="espacio1"></div>
                  <input type="text" name="cargo" id="cargo" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="38" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"></div>
                <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                  <center>
                    <input type="button" name="aceptar" id="aceptar" value="Continuar" tabindex="38">
                    <input type="button" name="aceptar1" id="aceptar1" value="Visualizar" tabindex="39">
                    <input type="button" name="aceptar2" id="aceptar2" value="Actualizar" tabindex="40">
                  </center>
                </div>
              </div>
            </form>
            <form name="formu1" action="ver_comp.php" method="post" target="_blank">
              <input type="hidden" name="comp_tipo" id="comp_tipo" class="form-control" readonly="readonly">
              <input type="hidden" name="comp_conse" id="comp_conse" class="form-control" readonly="readonly">
              <input type="hidden" name="comp_ano" id="comp_ano" class="form-control" readonly="readonly">
              <input type="hidden" name="comp_uni" id="comp_uni" class="form-control" readonly="readonly">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div id="dialogo"></div>
<div id="dialogo1"></div>
<div id="dialogo2">
	<form name="formu2">
		<table width="98%" align="center" border="0">
			<tr>
				<td>
					<div class="row">
						<div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
							<div id="lblcrp">
								<label><font face="Verdana" size="2">CRP</font></label>
							</div>
						</div>
						<div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
							<div id="lblcdp">
								<label><font face="Verdana" size="2">CDP</font></label>
							</div>
						</div>
						<div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
							<label><font face="Verdana" size="2">Valor Egreso</font></label>
						</div>
					</div>
					<div class="row">
						<div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
							<select name="crp" id="crp" class="form-control select2" tabindex="1"></select>
						</div>
						<div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
							<select name="cdp" id="cdp" class="form-control select2" tabindex="2"></select>
						</div>
						<div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
							<input type="text" name="valor2" id="valor2" class="form-control numero" value="0.00" onkeyup="paso_val1();" tabindex="3">
							<input type="hidden" name="valor3" id="valor3" class="form-control numero" value="0" tabindex="4">
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
							<label><font face="Verdana" size="2">Descripci&oacute;n del Egreso</font></label>
						</div>
					</div>
					<div class="row">
						<div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
							<input type="text" name="des_egre" id="des_egre" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" tabindex="4">
							<br>
							<div id="men_egre"></div>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</form>
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
  $("#fec_sop").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
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
    height: 220,
    width: 580,
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
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 310,
    width: 550,
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
        manual1();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#valor2").maskMoney();
  $("#val_crp").maskMoney();
  trae_gastos();
  trae_soportes();
  trae_valores();
  $("#tp_gasto").change(trae_valores);
  $("#recurso").prop("disabled",true);
  $("#rubro").prop("disabled",true);
  $("#aceptar").button();
  $("#aceptar").hide();
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
  $("#pago").change(val_cheque);
  $("#u_unidad1").hide();
  $("#u_unidad2").hide();
  trae_crp();
  trae_cdp();
  trae_unidades();
  $("#numero").prop("disabled",true);
  $("#fecha").prop("disabled",true);
  $("#saldo").prop("disabled",true);
  $("#saldo2").prop("disabled",true);
  $("#cdp").prop("disabled",true);
  $("#crp").prop("disabled",true);
  $("#cdp1").prop("disabled",true);
  $("#crp1").prop("disabled",true);
  $("#val_crp").prop("disabled",true);
  $("#unidad1").prop("disabled",true);
  $("#lblcrp1").hide();
  $("#lblcrp2").hide();
  $("#lblcrp3").hide();
  $("#lblcdp1").hide();
  $("#crp1").hide();
  $("#val_crp").hide();
  $("#cdp1").hide();
  $("#sal_crp").hide();
  $("#sal_crp1").hide();
  var subdepen = $("#subdependencia").val();
  if (subdepen == "1")
  {
    $("#lblcrp").show();
    $("#lblcdp").show();
    $("#crp").show();
    $("#cdp").show();
    $("#crp").prop("disabled",false);
  }
  else
  {
    $("#lblcrp").hide();
    $("#lblcdp").hide();
    $("#crp").hide();
    $("#cdp").hide();
    $("#crp").prop("disabled",false);
  }
  $("#crp").change(busca);
  $("#crp1").change(busca1);
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
  $("#valor2").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  var MaxInputs       = 99;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    var paso = $("#v_pasoc").val();
    $("#periodo").prop("disabled",true);
    $("#cuenta").prop("disabled",true);
    $("#crp1").prop("disabled",true);
    $("#val_crp").prop("disabled",true);
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      FieldCount++;
      $("#add_form table").append('<tr><td><div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4 espacio1"><select name="crp_'+z+'" id="crp_'+z+'" class="form-control select2" value="'+z+'" onchange="trae_crps2('+z+')"></select></div><div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4 espacio1"><input type="text" name="sar_'+z+'" id="sar_'+z+'" class="form-control numero" value="0.00" onkeyup="paso_val3('+z+');"><input type="hidden" name="sar1_'+z+'" id="sar1_'+z+'" class="form-control numero" value="0" readonly="readonly"><input type="hidden" name="sar2_'+z+'" id="sar2_'+z+'" class="form-control numero" value="0" readonly="readonly"></div><div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4 espacio1"><div id="men_'+z+'"><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></div></div></td></tr>');
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
  $("#numero").focus(function(){
    this.select();
  });
  trae_cuentas();
});
function trae_crp()
{
  $("#crp").html('');
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
      $("#crp").append(salida);
      $("#crp1").append(salida);
      busca();
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
      $("#v_pasoc").val(salida);
      $("#crp").append(salida);
      busca();
    }
  });
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
      $("#saldo2").val(saldo_crp);
      valida_crp1(valor);
    }
  });
}
function valida_crp1(valor)
{
  var crp = $("#sar1_"+valor).val();
  crp = parseFloat(crp);
  if (crp <= 0)
  {
    var detalle = "Saldo CRP No Permitido";
    alerta(detalle);
    $("#aceptar").hide();
    $("#sar_"+valor).prop("disabled",true);
  }
  else
  {
    $("#aceptar").show();
    $("#sar_"+valor).prop("disabled",false);
    suma_crp();
  }
}
function suma_crp()
{
  var crp = $("#val_crp1").val();
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
  var giro = $("#valor1").val();
  var diferencia = giro-suma;
  var diferencia1 = diferencia.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#diferencia").val(diferencia1);
  var val_valor = $("#valor").val();
  if (val_valor == "0.00")
  {
    $("#aceptar").hide();
  }
  else
  {
    $("#aceptar").show();
  }
}
function trae_cdp()
{
  $("#cdp").html('');
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
      $("#cdp").append(salida);
      $("#cdp1").append(salida);
      busca();
    }
  });
}
function trae_soportes()
{
  $("#soporte").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_soportes.php",
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
      $("#soporte").append(salida);
    }
  });
}
function trae_unidades()
{
  var unidad = $("#unidad2").val();
  $("#unidad1").html('');
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
  var crp = $("#crp").val();
  var crp1 = $("#crp option:selected").html();
  if ((crp === null) || (crp1 === undefined))
  {
  }
  else
  {
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
        var conse = registros.conse;
        var cdp = registros.cdp;
        $("#cdp").val(conse);
        $("#crp1").val(crp);
        busca1();
      }
    });
  }
}
function busca1()
{
  var crp = $("#crp1").val();
  var crp1 = $("#crp1 option:selected").html();
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
      var conse = registros.conse;
      var cdp = registros.cdp;
      $("#cdp1").val(conse);
      trae_sal_crp();
    }
  });
}
function manual()
{
  $("#resultados1").html('');
  $("#dialogo2").dialog("open");
  $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  var subdepen = $("#subdependencia").val();
  if (subdepen == "1")
  {
    var concepto = $("#concepto").val();
    if (concepto == "14")
    {
      $("#lblcrp").hide();
      $("#lblcdp").hide();
      $("#crp").hide();
      $("#cdp").hide();
    }
    else
    {
      $("#lblcrp").show();
      $("#lblcdp").show();
      $("#crp").show();
      $("#cdp").show();
    }
    $("#sal_crp").show();
    $("#sal_crp1").show();
    trae_sal_crp();
  }
  else
  {
    $("#sal_crp").hide();
    $("#sal_crp1").hide();
  }
}
function manual1()
{
  var salida = true, detalle = '';
  var val_saldo = $("#saldo1").val();
  val_saldo = parseFloat(val_saldo);
  $("#men_egre").html('');
  var val_valor = $("#valor3").val();
  val_valor = parseFloat(val_valor);
  if (val_valor > 0)
  {
    if (val_valor > val_saldo)
    {
      salida = false;
      detalle += "Valor del Egreso Superior al Saldo del Banco.<br>";
    }
  }
  else
  {
    salida = false;
    detalle += "Debe Ingresar el Valor del Egreso.<br>";
  }
  var v_des_egre = $("#des_egre").val();
  v_des_egre = v_des_egre.trim().length;
  if (v_des_egre == "0")
  {
    salida = false;
    detalle += "Debe Ingresar una Descripci&oacute;n.";
  }
  detalle = "<center>"+detalle+"</center>";
  if (salida == false)
  {
    $("#men_egre").addClass("ui-state-error");
    $("#men_egre").append(detalle);
    $("#men_egre").show();
    $("#aceptar").hide();
  }
  else
  {
    $("#dialogo2").dialog("close");
    val_valor1 = parseFloat(val_valor);
    val_valor2 = val_valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $("#valor").val(val_valor2);
    paso_val();
    var sigla = $("#sigla").val();
    var datos = sigla+"|"+val_valor2+"#";
    $("#datos").val(datos);
    var salida = "";
    salida += "<br><table width='100%' border='0' id='a-table1'>";
    salida += '<td width="70%" height="24">'+sigla+'</td>';
    salida += '<td width="30%" height="24" align="right">'+val_valor2+'&nbsp;&nbsp;</td></tr>';
    salida += "</table>";
    $("#resultados1").append(salida);
    $("#aceptar").show();
    var concepto = $("#concepto").val();
    if (concepto == "98")
    {
      $("#u_unidad1").show();
      $("#u_unidad2").show();
      $("#unidad1").prop("disabled",false);
      cambia_unidad();
    }
    else
    {
      $("#u_unidad1").hide();
      $("#u_unidad2").hide();
      $("#unidad1").prop("disabled",true);
    }
  }
}
function val_cheque()
{
  var valida, valida1, valida2, cheque, cheque1, chequera, detalle;
  valida = $("#pago").val();
  cheque = $("#actual").val();
  cheque = parseInt(cheque);
  valida1 = $("#final").val();
  valida1 = parseInt(valida1);
  if (valida == "2")
  {
    $("#cash").prop("disabled",true);
    $("#cash").val(cheque);
    cheque1 = cheque+1;
    chequera = $("#inicial").val();
    chequera1 = $("#final").val();
    chequera = chequera+"|"+chequera1+"|"+cheque1;
    $("#chequera").val(chequera);
    valida2 = valida1-cheque;
    if (valida2 < 5)
    {
      detalle = "Restan "+valida2+" cheque(s), solicitar nueva chequera";
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
  }
  else
  {
    $("#cash").prop("disabled",false);
    $("#cash").val('');
  }
}
function paso_val()
{
  var valor = $("#valor").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valor1").val(valor);
}
function paso_val1()
{
  var valor = $("#valor2").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valor3").val(valor);
}
function paso_val2()
{
  var valor = $("#val_crp").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#val_crp1").val(valor);
  compara_crp();
}
function paso_val3(valor)
{
  var valor;
  var valor1 = $("#sar_"+valor).val()
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#sar1_"+valor).val(valor1);
  compara_crp1(valor);
}
function compara_crp()
{
  var crp = $("#val_crp1").val();
  crp = parseFloat(crp);
  var crp1 = $("#val_crp2").val();
  crp1 = parseFloat(crp1);
  var crp2 = crp1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  if (crp > crp1)
  {
    $("#aceptar").hide();
    var detalle = "Valor CRP superior al Saldo: "+crp2;
    alerta(detalle);
  }
  else
  {
    $("#aceptar").hide();
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
    $("#aceptar").hide();
    var detalle = "Valor CRP superior al Saldo: "+crp2;
    alerta(detalle);
  }
  else
  {
    $("#aceptar").show();
  }
  suma_crp();
}
function trae_sal_crp()
{
  var cuenta = $("#cuenta").val();
  if ((cuenta === undefined) || (cuenta === null))
  {
    cuenta = "1|";
  }
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  if ((cuenta1 == "2") || (cuenta1 == "4"))
  {
  }
  else
  {
    var crp = $("#crp1").val();
    if ((crp === undefined) || (crp === null))
    {
      alerta("Error cargando CRPS, refresco página...");
      location.reload();
    }
    else
    {
      $.ajax({
        type: "POST",
        datatype: "json",
        url: "trae_crps1.php",
        data:
        {
          crp: crp
        },
        success: function (data)
        {
          var registros = JSON.parse(data);
          var saldo_crp  = parseFloat(registros.sal_crp);
          var saldo_crp1 = saldo_crp;
          saldo_crp = saldo_crp.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          $("#saldo2").val(saldo_crp);
          $("#val_crp").val(saldo_crp);
          $("#val_crp2").val(saldo_crp1);
          paso_val2();
          $("#recurso").val(registros.recurso);
          $("#rubro").val(registros.rubro);
        }
      });
    }
  }
}
function trae_gastos()
{
  var concepto = $("#concepto").val();
  var paso_conceptos1 = $("#conceptos1").val();
  var paso_conceptos2 = $("#conceptos2").val();
  var paso_conceptos3 = $("#conceptos3").val();
  var paso_conceptos4 = $("#conceptos4").val();
  var paso_conceptos5 = $("#conceptos5").val();
  var paso_conceptos6 = $("#conceptos6").val();
  $("#tp_gasto").html('');
  if (concepto == "10")
  {
    $("#tp_gasto").append(paso_conceptos2);
  }
  else
  {
    if (concepto == "18")
    {
      $("#tp_gasto").append(paso_conceptos1);
      $("#tp_gasto").append(paso_conceptos2);
      $("#tp_gasto").append(paso_conceptos3);
    }
    else
    {
      if ((concepto == "2") || (concepto == "7") || (concepto == "14") || (concepto == "24") || (concepto == "98"))
      {
        $("#tp_gasto").append(paso_conceptos1);
        $("#tp_gasto").append(paso_conceptos2);
      }
      else
      {
        if (concepto == "4")
        {
          $("#tp_gasto").append(paso_conceptos4);
        }
        else
        {
          if (concepto == "5")
          {
            $("#tp_gasto").append(paso_conceptos5);
          }
          else
          {
            if (concepto == "6")
            {
              $("#tp_gasto").append(paso_conceptos6);
            }
            else
            {
              $("#tp_gasto").append(paso_conceptos1);
            }
          }
        }
      }
    }
  }
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
  trae_cdp();
  trae_crps();
  $("#num_aut").val('');
  $("#num_gir").val('0');
  $("#valor").val('0.00');
  paso_val();
  $("#lblcrp1").hide();
  $("#lblcrp2").hide();
  $("#lblcrp3").hide();
  $("#lblcdp1").hide();
  $("#crp1").hide();
  $("#val_crp").hide();
  $("#cdp1").hide();
  $("#sal_crp").hide();
  $("#sal_crp1").hide();
  $("#u_unidad1").hide();
  $("#u_unidad2").hide();
  $("#autoriza").prop("disabled",false);
  $("#num_aut").prop("disabled",false);
  $("#unidad1").prop("disabled",false);
  var concepto = $("#concepto").val();
  switch (concepto)
  {
    case '3':
      consu_valor4();
      break;
    case '4':
      break;
    case '5':
      break;
    case '8':
      consu_valor();
      break;
    case '99':
      consu_valor1();
      break;
    case '2':
    case '6':
    case '7':
    case '14':
    case '24':
    case '18':
    case '98':
      manual();
      break;
    case '9':
      consu_valor2();
      break;
    case '10':
      consu_valor3();
      break;
    default:
      consu_valor();
      break;
  }
}
function consu_valor()
{
  $("#siglas").val('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_valores1.php",
    data:
    {
      tipo: $("#tp_gasto").val(),
      unidades: $("#unidades").val(),
      periodo: $("#periodo").val()
    },
    success: function (data)
    {
      $("#resultados1").html('');
      var mes = $("#n_mes").val();
      var registros = JSON.parse(data);
      var paso = registros.total;
      paso = parseFloat(paso);
      paso = paso.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#valor").val(paso);
      paso_val();
      var num_gir = registros.informe;
      var num_aut = registros.internos;
      if ((num_gir == false) || (num_gir == null))
      {
        num_gir = 0;
      }
      if ((num_aut == false) || (num_aut == null))
      {
        num_aut = 0;
      }
      var num_con = registros.concepto;
      if (num_con == false)
      {
      }
      else
      {
        $("#concepto").val(num_con);
      }
      var num_rec = registros.recurso;
      if (num_rec == false)
      {
      }
      else
      {
        $("#recurso").val(registros.recurso);
      }
      var num_rub = registros.rubro;
      if (num_rub == false)
      {
      }
      else
      {
        $("#rubro").val(registros.rubro);
      }
      $("#dat_aut").val(registros.conses);
      $("#num_gir").val(num_gir);
      $("#num_aut").val(num_aut);
      $("#autoriza").prop("disabled",true);
      $("#num_aut").prop("disabled",true);
      $("#autoriza").val('1');
      var tipo = $("#tp_gasto").val();
      if (tipo == "1")
      {
        $("#soporte").val('6');
      }
      else
      {
        $("#soporte").val('1');
      }
      $("#num_sop").val(mes);
      var salida = "";
      var siglas = "";
      salida += "<br><table width='100%' border='0' id='a-table1'>";
      var y = 1;
      $.each(registros.rows, function (index, value)
      {
        siglas += "'"+value.sigla+"',";
        salida += '<td width="70%" height="24"><input type="hidden" name="val_'+y+'" id="val_'+y+'" class="c4" value="'+value.sigla+"|"+value.valor+'" readonly="readonly">'+value.sigla+'</td>';
        salida += '<td width="30%" height="24" align="right">'+value.valor+'&nbsp;&nbsp;</td></tr>';
        y++;
      });
      salida += "</table>";
      $("#resultados1").append(salida);
      $("#siglas").val(siglas);
      var val_valor = $("#valor").val();
      if (val_valor == "0.00")
      {
        $("#aceptar").hide();
      }
      else
      {
        $("#aceptar").show();
      }
    }
  });
}
function consu_valor1()
{
  $("#siglas").val('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_valores5.php",
    data:
    {
      tipo: $("#tp_gasto").val(),
      periodo: $("#periodo").val(),
      ano: $("#n_ano").val()
    },
    success: function (data)
    {
      $("#resultados1").html('');
      var registros = JSON.parse(data);
      var valida1 = registros.valida1;
      $("#valida1").val(valida1);
      $("#valor").val('0.00');
      $("#valor").prop("disabled",true);
      paso_val();
      $("#recurso").val('1');
      $("#rubro").val('3');
      $("#autoriza").val('2');
      $("#autoriza").prop("disabled",true);
      $("#num_aut").prop("disabled",true);
      var tipo = $("#tp_gasto").val();
      if (tipo == "1")
      {
        $("#soporte").val('4');
      }
      else
      {
        $("#soporte").val('1');
      }
      var datos = registros.datos;
      $("#datos").val(datos);
      var var_ocu = datos.split('#');
      var var_ocu1 = var_ocu.length;
      var paso = "";
      var datos1 = "";
      var sigla = "";
      var siglas = "";
      var valor1 = "";
      var salida = "";
      salida += "<br><table width='100%' border='0' id='a-table1'>";
      for (var i=0; i<var_ocu1-1; i++)
      {
        paso = var_ocu[i];
        paso = paso.replace(/[ ]+/g, "");
        datos1 = paso.split('|');
        sigla = datos1[0];
        valor1 = datos1[1];
        siglas += "'"+sigla+"',";
        salida += '<tr>';
        salida += '<td width="65%" height="24">'+sigla+'</td>';
        salida += '<td width="30%" height="24" align="right">'+valor1+'&nbsp;&nbsp;</td>';
        salida += '<td width="5%" height="24"><center><input type="checkbox" name="chk_'+i+'" id="chk_'+i+'" value='+paso+' onclick="trae_marca();"></center></td>';
        salida += '</tr>';
      }
      salida += "</table>";
      $("#resultados1").append(salida);
      $("#siglas").val(siglas);
      var val_valor = $("#valor").val();
      if (val_valor == "0.00")
      {
        $("#aceptar").hide();
      }
      else
      {
        $("#aceptar").show();
      }
      var subdepen = $("#subdependencia").val();
      if (subdepen == "1")
      {
        $("#lblcrp1").show();
        $("#lblcrp2").show();
        $("#lblcrp3").show();
        $("#lblcdp1").show();
        $("#crp1").show();
        $("#val_crp").show();
        $("#cdp1").show();
        $("#crp1").prop("disabled",false);
        $("#val_crp").prop("disabled",false);
        $("#sal_crp").show();
        $("#sal_crp1").show();
        trae_sal_crp();
      }
      else
      {
        $("#lblcrp1").hide();
        $("#lblcrp2").hide();
        $("#lblcrp3").hide();
        $("#lblcdp1").hide();
        $("#crp1").hide();
        $("#val_crp").hide();
        $("#cdp1").hide();
        $("#crp1").prop("disabled",true);
        $("#val_crp").prop("disabled",true);
        $("#sal_crp").hide();
        $("#sal_crp1").hide();
      }
    }
  });
}
function consu_valor2()
{
  var tipo = $("#tp_gasto").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_valores6.php",
    data:
    {
      tipo: tipo,
      periodo: $("#periodo").val()
    },
    success: function (data)
    {
      $("#resultados1").html('');
      var registros = JSON.parse(data);
      var valida1 = registros.valida1;
      $("#valida1").val(valida1);
      $("#valor").val('0.00');
      $("#valor").prop("disabled",true);
      paso_val();
      $("#autoriza").val('2');
      $("#autoriza").prop("disabled",true);
      $("#num_aut").prop("disabled",true);
      if (tipo == "1")
      {
      	$("#soporte").val('4');
        $("#soporte").prop("disabled",true);
      	$("#num_sop").val('');
        $("#num_sop").prop("disabled",true);
      }
      else
      {
        $("#soporte").val('1');
        $("#soporte").prop("disabled",true);
        var mes = $("#n_mes").val();
        $("#num_sop").val(mes);
        $("#num_sop").prop("disabled",true);
      }
      var datos = registros.datos;
      $("#datos").val(datos);
      var var_ocu = datos.split('#');
      var var_ocu1 = var_ocu.length;
      var paso = "";
      var datos1 = "";
      var sigla = "";
      var siglas = "";
      var valor1 = "";
      var salida = "";
      salida += "<br><table width='100%' border='0' id='a-table1'>";
      for (var i=0; i<var_ocu1-1; i++)
      {
        paso = var_ocu[i];
        datos1 = paso.split('|');
        sigla = datos1[0];
        valor1 = datos1[1];
        siglas += "'"+sigla+"',";
        salida += '<tr>';
        salida += '<td width="65%" height="24">'+sigla+'</td>';
        salida += '<td width="30%" height="24" align="right">'+valor1+'&nbsp;&nbsp;</td>';
        salida += '<td width="5%" height="24"><center><input type="checkbox" name="chk_'+i+'" id="chk_'+i+'" value='+paso+' onclick="trae_marca1();"></center></td>';
        salida += '</tr>';
      }
      salida += "</table>";
      $("#resultados1").append(salida);
      $("#siglas").val(siglas);
      var val_valor = $("#valor").val();
      if (val_valor == "0.00")
      {
        $("#aceptar").hide();
      }
      else
      {
        $("#aceptar").show();
      }
    }
  });
}
function consu_valor3()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_valores8.php",
    data:
    {
      tipo: $("#tp_gasto").val(),
      unidades: $("#unidades").val(),
      periodo: $("#periodo").val()
    },
    success: function (data)
    {
      $("#resultados1").html('');
      var registros = JSON.parse(data);
      var valor = registros.total;
      $("#valor").val(valor);
      $("#valor").prop("disabled",true);
      paso_val();
      $("#recurso").val(registros.recurso);
      $("#rubro").val(registros.rubro);
   		$("#autoriza").val('1');
      $("#autoriza").prop("disabled",true);
      $("#soporte").val('2');
      $("#soporte").prop("disabled",true);
      $("#num_sop").val(registros.acta);
      $("#num_sop").prop("disabled",true);
      $("#num_gir").val(registros.informe);
      $("#num_aut").val(registros.informe);
      $("#num_aut").prop("disabled",true);
      var datos = registros.datos;
      $("#datos").val(datos);
      var datos1 = datos.split('|');
      var sigla = datos1[0];
      var salida = "";
      salida += "<br><table width='100%' border='0' id='a-table1'>";
      salida += '<td width="70%" height="24">'+sigla+'</td>';
      salida += '<td width="30%" height="24" align="right">'+valor+'&nbsp;&nbsp;</td></tr>';
      salida += "</table>";
      $("#resultados1").append(salida);
      var val_valor = $("#valor").val();
      if (val_valor == "0.00")
      {
        $("#aceptar").hide();
      }
      else
      {
        $("#aceptar").show();
      }
      $("#unidad1").html('');
      $("#unidad1").append(registros.unidades);
      $("#u_unidad1").show();
      $("#u_unidad2").show();
    }
  });
}
function consu_valor4()
{
  $("#siglas").val('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_valores7.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#n_ano").val()
    },
    success: function (data)
    {
      $("#resultados1").html('');
      var registros = JSON.parse(data);
      var valida1 = registros.valida1;
      $("#valida1").val(valida1);
      var valor = registros.total;
      $("#valor").val(valor);
      $("#valor").prop("disabled",true);
      paso_val();
      $("#recurso").val('1');
      $("#rubro").val('3');
      $("#autoriza").val('2');
      $("#autoriza").prop("disabled",true);
      var num_aut = registros.solicitud;
      if (num_aut == false)
      {
        num_aut = 0;
      }
      $("#num_aut").val(num_aut);
      $("#num_aut").prop("disabled",true);
      var datos = registros.datos;
      $("#datos").val(datos);
      var datos1 = datos.split('|');
      var sigla = datos1[0];
      var salida = "";
      var siglas = "";
      siglas += "'"+sigla+"',";
      salida += "<br><table width='100%' border='0' id='a-table1'>";
      salida += '<td width="70%" height="24">'+sigla+'</td>';
      salida += '<td width="30%" height="24" align="right">'+valor+'&nbsp;&nbsp;</td></tr>';
      salida += "</table>";
      $("#resultados1").append(salida);
      $("#siglas").val(siglas);
      var val_valor = $("#valor").val();
      if (val_valor == "0.00")
      {
        $("#aceptar").hide();
      }
      else
      {
        $("#aceptar").show();
      }
      var subdepen = $("#subdependencia").val();
      if (subdepen == "1")
      {
        $("#lblcrp1").show();
        $("#lblcdp1").show();
        $("#crp1").show();
        $("#cdp1").show();
        $("#crp1").prop("disabled",false);
        $("#sal_crp").show();
        $("#sal_crp1").show();
        trae_sal_crp();
      }
      else
      {
        $("#lblcrp1").hide();
        $("#lblcdp1").hide();
        $("#crp1").hide();
        $("#cdp1").hide();
        $("#crp1").prop("disabled",true);
        $("#sal_crp").hide();
        $("#sal_crp1").hide();
      }
    }
  });
}
function trae_marca()
{
  var total = 0;
  var internos = "";
  var valores = "";
  $("#datos").val('');
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('chk_')!=-1)
    {
      if ($("#"+saux).is(":checked"))
      {
        var var1 = $("#"+saux).val();
        var var2 = var1.split('|');
        var var3 = var2[1];
        var var4 = parseFloat(var3.replace(/,/g,''));
        total = total+var4;
        var var5 = var2[2];
        internos += var5+",";
        valores += var1+"#";
      }
    }
  }
  $("#datos").val(valores);
  internos = internos.substring(0, internos.length-1);
  $("#num_aut").val(internos);
  var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#valor").val(total1);
  paso_val();
  var val_valor = $("#valor").val();
  if (val_valor == "0.00")
  {
    $("#aceptar").hide();
  }
  else
  {
    $("#aceptar").show();
  }
}
function trae_marca1()
{
  var tipo = $("#tp_gasto").val();
  var total = 0;
  var internos = "";
  var valores = "";
  var misiones = "";
  $("#datos").val('');
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('chk_')!=-1)
    {
      if ($("#"+saux).is(":checked"))
      {
        var var1 = $("#"+saux).val();
        var var2 = var1.split('|');
        var var3 = var2[1];
        var var4 = parseFloat(var3.replace(/,/g,''));
        total = total+var4;
        var var5 = var2[2];
        internos += var5+",";
        valores += var1+"#";
        var var6 = var2[3];
        misiones += var6+",";
        var giro = var2[4];
        var recurso = var2[5];
        var rubro = var2[6];
      }
    }
  }
  $("#datos").val(valores);
  internos = internos.substring(0, internos.length-1);
  $("#num_aut").val(internos);
  if (tipo == "1")
  {
    misiones = misiones.substring(0, misiones.length-1);
    $("#num_sop").val(misiones);
  }
  else
  {
    var mes = $("#n_mes").val();
    $("#num_sop").val(mes);
  }
  $("#recurso").val(recurso);
  $("#rubro").val(rubro);
  var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#valor").val(total1);
  paso_val();
  var val_valor = $("#valor").val();
  if (val_valor == "0.00")
  {
    $("#aceptar").hide();
  }
  else
  {
    $("#aceptar").show();
  }
}
function trae_informe()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_informe.php",
    data:
    {
      valor: $("#valor").val(),
      concepto: $("#concepto").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var valida = parseInt(registros.informe);
      if (valida > 0)
      {
        $("#soporte").val('1');
        $("#num_sop").val(registros.informe);
        $("#fec_sop").val(registros.fecha);
        $("#recurso").val(registros.recurso);
        $("#rubro").val(registros.rubro);
        $("#soporte").prop("disabled",true);
        $("#num_sop").prop("disabled",true);
        $("#fec_sop").prop("disabled",true);
        $("#recurso").prop("disabled",true);
        $("#rubro").prop("disabled",true);
      }
      else
      {
        $("#soporte").prop("disabled",false);
        $("#num_sop").prop("disabled",false);
        $("#fec_sop").prop("disabled",false);
        $("#recurso").prop("disabled",false);
        $("#rubro").prop("disabled",false);
      }
    }
  });
}
function pregunta()
{
  var cuenta = $("#cuenta option:selected").html();
  var detalle = "<center><h3><font color='#3333ff'>Cuenta seleccionada: "+cuenta+"</font></h3></center><center><h3><font color='#ff0000'>Por favor confirmar</font></h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function graba()
{
  var concepto = $("#concepto").val();
  if (concepto == "8")
  {
    document.getElementById('datos').value="";
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('val_')!=-1)
      {
        if ((saux == "val_crp") || (saux == "val_crp1") || (saux == "val_crp2"))
        {
        }
        else
        {
          valor = document.getElementById(saux).value;
          document.getElementById('datos').value=document.getElementById('datos').value+valor+"#";
        }
      }
    }
  }
  if (concepto == "99")
  {
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
  }
  $("#can_crp").val(num_crp);
  nuevo();
}
function nuevo()
{
  $("#cash").removeClass("ui-state-error");
  $("#valor").removeClass("ui-state-error");
  $("#tot_crp").removeClass("ui-state-error");
  $("#reviso").removeClass("ui-state-error");
  $("#cargo").removeClass("ui-state-error");
  var concepto = $("#concepto").val();
  var unidad = $("#subdependencia").val();
  var valida = $("#pago").val();
  var salida = true, detalle = '';
  if (valida == "1")
  {
    var cash = $("#cash").val().trim().length;
    if (cash == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar el CASH</h3></center>";
      $("#cash").addClass("ui-state-error");
    }
  }
  var val_recurso = $("#recurso").val();
  val_recurso = parseInt(val_recurso);
  if (isNaN(val_recurso))
  {
    salida = false;
    detalle += "<center><h3>Recurso No Válido</h3></center>";
  }
  var val_rubro = $("#rubro").val();
  val_rubro = parseInt(val_rubro);
  if (isNaN(val_rubro))
  {
    salida = false;
    detalle += "<center><h3>Rubro No Válido</h3></center>";
  }  
  var val_saldo = $("#saldo1").val();
  val_saldo = parseFloat(val_saldo);
  var val_valor = $("#valor1").val();
  val_valor = parseFloat(val_valor);
  if (val_valor > 0)
  {
    if (val_valor > val_saldo)
    {
      salida = false;
      detalle += "<center><h3>Valor del Egreso Superior al Saldo del Banco</h3></center>";
    }
  }
  if (unidad == "1")
  {
    var cuenta = $("#cuenta").val();
    var var_ocu = cuenta.split('|');
    var cuenta1 = var_ocu[0];
    if ((concepto == "14") && ((cuenta1 == "2") || (cuenta1 == "3")))
    {
    }
    else
    {
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
      var num_crp = $("#can_crp").val();
      var compara1, compara2, compara3, compara4;
      compara1 = $("#valor1").val();
      compara1 = parseFloat(compara1);
      compara2 = $("#tot_crp1").val();
      compara2 = parseFloat(compara2);
      if (compara1 > compara2)
      {
        salida = false;
        detalle += "<center><h3>Valor del Egreso Superior a Suma Total CRP</h3></center>";
        $("#valor").addClass("ui-state-error");
        $("#tot_crp").addClass("ui-state-error");
      }
      if (num_crp == "0")
      {
      }
      else
      {
        if (concepto == "99")
        {
          if (compara1 != compara2)
          {
            salida = false;
            detalle += "<center><h3>Valor del Egreso debe ser igual a Suma Total CRP</h3></center>";
            $("#valor").addClass("ui-state-error");
            $("#tot_crp").addClass("ui-state-error");
          }
        }
      }
    }
  }
  var reviso = $("#reviso").val().trim().length;
  if (reviso == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la persona que Revisó</h3></center>";
    $("#reviso").addClass("ui-state-error");
  }
  var cargo = $("#cargo").val().trim().length;
  if (cargo == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el cargo de la persona que Revisó</h3></center>";
    $("#cargo").addClass("ui-state-error");
  }
  var datos = $("#datos").val().trim();
  if (datos == "")
  {
    salida = false;
    detalle += "<center><h3>Debe revisar la(s) unidad(es) seleccionada(s)</h3></center>";
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
      $("#crp1").prop("disabled",true);
      $("#val_crp").prop("disabled",true);
      compara3 = $("#valor1").val();
      compara3 = parseFloat(compara3);
      compara4 = compara3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#val_crp").val(compara4);
      $("#val_crp1").val(compara3);
    }
    nuevo1();
  }
}
function nuevo1()
{
  var valida = $("#cuenta").val();
  valida = valida.trim().length;
  if (valida == "0")
  {
    var detalle = "<center><h3>Cuenta Bancaria No Válida</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "egr_grab.php",
      data:
      {
      	tipo: $("#tipo").val(),
      	concepto: $("#concepto").val(),
      	periodo: $("#periodo").val(),
      	tp_gasto: $("#tp_gasto").val(),
       	recurso: $("#recurso").val(),
      	rubro: $("#rubro").val(),
      	autoriza: $("#autoriza").val(),
        num_gir: $("#num_gir").val(),
      	num_aut: $("#num_aut").val(),
      	dat_aut: $("#dat_aut").val(),
      	soporte: $("#soporte").val(),
      	num_sop: $("#num_sop").val(),
        valor: $("#valor").val(),
      	valor1: $("#valor1").val(),
        unidad1: $("#unidad1").val(),
      	pago: $("#pago").val(),
      	cash: $("#cash").val(),
        chequera: $("#chequera").val(),
        cuenta: $("#cuenta").val(),
      	datos: $("#datos").val(),
      	firma1: $("#firma1").val(),
      	firma2: $("#firma2").val(),
        firma3: $("#firma3").val(),
      	firma4: $("#firma4").val(),
      	cargo1: $("#cargo1").val(),
      	cargo2: $("#cargo2").val(),
        cargo3: $("#cargo3").val(),
      	cargo4: $("#cargo4").val(),
        reviso: $("#reviso").val(),
        cargo: $("#cargo").val(),
      	unidades: $("#unidades").val(),
      	descrip: $("#des_egre").val(),
        crp: $("#crp").val(),
      	cdp: $("#cdp").val(),
      	crp1: $("#crp1").val(),
      	cdp1: $("#cdp1").val(),
        saldo: $("#val_crp1").val(),
        cantidad: $("#can_crp").val(),
        crps: $("#v_crp").val(),
        saldos: $("#v_sal").val(),
        valida: $("#valida1").val(),
      	siglas: $("#siglas").val(),
        usuario: $("#v_usuario").val(),
      	unidad: $("#v_unidad").val(),
      	ciudad: $("#v_ciudad").val()
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        var valida = registros.salida;
        var valida1 = registros.salida1;
        if (valida1 == "1")
        {
          var detalle = "<center><h3>Egreso Ya Grabado, por favor verifique en Consultas</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          if (valida > 0)
          {
            $("#numero").val(valida);
            $("#aceptar").hide();
            $("#aceptar1").show();
            $("#aceptar1").click();
            $("#periodo").prop("disabled",true);
            $("#concepto").prop("disabled",true);
            $("#tp_gasto").prop("disabled",true);
            $("#autoriza").prop("disabled",true);
            $("#num_aut").prop("disabled",true);
            $("#soporte").prop("disabled",true);
            $("#num_sop").prop("disabled",true);
            $("#unidad1").prop("disabled",true);
            $("#pago").prop("disabled",true);
            $("#cash").prop("disabled",true);
            $("#cuenta").prop("disabled",true);
            $("#firma1").prop("disabled",true);
            $("#firma2").prop("disabled",true);
            $("#firma3").prop("disabled",true);
            $("#firma4").prop("disabled",true);
            $("#cargo1").prop("disabled",true);
            $("#cargo2").prop("disabled",true);
            $("#cargo3").prop("disabled",true);
            $("#cargo4").prop("disabled",true);
            $("#reviso").prop("disabled",true);
            $("#cargo").prop("disabled",true);
            $("#crp").prop("disabled",true);
            $("#cdp").prop("disabled",true);
            $("#val_crp").prop("disabled",true);
            var concepto = $("#concepto").val();
            if ((concepto == "9") || (concepto == "99"))
            {
              for (i=0;i<document.formu.elements.length;i++)
              {
                saux = document.formu.elements[i].name;
                if (saux.indexOf('chk_')!=-1)
                {
                  $("#"+saux).prop("disabled",true);
                }
              }
              if (concepto == "99")
              {
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
              }
            }
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
      }
    });
  }
}
function cambia_unidad()
{
  var concepto = $("#concepto").val();
  var sigla = $("#unidad1 option:selected").html();
  sigla = sigla.trim();
  var valor = $("#valor").val();
  valor = valor.trim();
  if ((concepto == "98") || (concepto == "10"))
  {
    $("#resultados1").html('');
    var salida = "";
    salida += "<br><table width='100%' border='0' id='a-table1'>";
    salida += '<td width="70%" height="24">'+sigla+'</td>';
    salida += '<td width="30%" height="24" align="right">'+valor+'&nbsp;&nbsp;</td></tr>';
    salida += "</table>";
    $("#resultados1").append(salida);
    var datos = sigla+"|"+valor+"#";
    $("#datos").val(datos);
  }
}
function link()
{
  var egreso = $("#numero").val();
  var ano = $("#n_ano").val();
  var uni = $("#v_unidad").val();
  $("#comp_tipo").val('2');
  $("#comp_conse").val(egreso);
  $("#comp_ano").val(ano);
  $("#comp_uni").val(uni);
  formu1.submit();
}
function checkRegexp(o, regexp, n)
{
  if (!(regexp.test(o.val())))
  {
    $("#dialogo").html(n);
    $("#dialogo").dialog("open");
    return false;
  }
  else
  {
    return true;
  }
}
function consulta()
{
  var numero = $("#numero").val();
  var ano = $("#n_ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "egr_consu.php",
    data:
    {
      numero: numero,
      ano: ano
    },
    success: function (data)
    {
      $("#resultados1").html('');
      var registros = JSON.parse(data);
      var valida = registros.salida;
      if (valida > 0)
      {
        $("#firma1").val('');
        $("#cargo1").val('');
        $("#firma2").val('');
        $("#cargo2").val('');
        $("#firma3").val('');
        $("#cargo3").val('');
        $("#firma4").val('');
        $("#cargo4").val('');
        $("#reviso").val('');
        $("#cargo").val('');
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
				$("#cuenta").prop("disabled",true);
        $("#concepto").val(registros.concepto);
        $("#concepto").prop("disabled",true);
        $("#tp_gasto").val(registros.tp_gas);
        $("#tp_gasto").prop("disabled",true);
        $("#recurso").val(registros.recurso);
        $("#recurso").prop("disabled",true);
        $("#rubro").val(registros.rubro);
        $("#rubro").prop("disabled",true);
        $("#autoriza").val(registros.autoriza);
        $("#autoriza").prop("disabled",true);
        $("#num_aut").val(registros.num_auto);
        $("#num_aut").prop("disabled",true);
        $("#soporte").val(registros.soporte);
        $("#soporte").prop("disabled",true);
        $("#num_sop").val(registros.num_sopo);
        $("#num_sop").prop("disabled",true);
        $("#pago").val(registros.pago);
        $("#pago").prop("disabled",true);
        $("#cash").val(registros.det_pago);
        $("#cash").prop("disabled",true);
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
          if (i == 4)
          {
          	$("#reviso").val(fir);
          	if (car == undefined)
          	{
          	}
          	else
          	{
          		$("#cargo").val(car);
          	}
          }
          y++;
        }
        var salida = "";
        salida += "<br><table width='100%' border='0' id='a-table1'>";
        var datos1 = registros.datos.split('#');
        var var_ocu2 = datos1.length;
        var y = 1;
        for (var i=0; i<var_ocu2-1; i++)
        {
          var paso = datos1[i];
          var sigla = paso.split('|');
          var sig = sigla[0];
          var val = sigla[1];
          salida += '<td width="70%" height="24"><input type="hidden" name="val_'+y+'" id="val_'+y+'" class="c4" value="'+sig+"|"+val+'" readonly="readonly">'+sig+'</td>';
          salida += '<td width="30%" height="24" align="right">'+val+'&nbsp;&nbsp;</td></tr>';
        }
        salida += "</table>";
        $("#resultados1").append(salida);
        var valor1 = registros.valor;
        valor1 = parseFloat(valor1);
        valor1 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        $("#valor").val(valor1);
        if (registros.estado == "")
        {
          $("#aceptar2").show();
        }
        else
        {
          var detalle = "<center><h3>Egreso Anulado</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
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
        detalle = "<center><h3>Egreso No Encontrado</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function actualizar()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "egr_actu.php",
    data:
    {
      numero: $("#numero").val(),
      ano: $("#n_ano").val(),
      concepto: $("#concepto").val(),
      firma1: $("#firma1").val(),
      cargo1: $("#cargo1").val(),
      firma2: $("#firma2").val(),
      cargo2: $("#cargo2").val(),
      firma3: $("#firma3").val(),
      cargo3: $("#cargo3").val(),
      firma4: $("#firma4").val(),
      cargo4: $("#cargo4").val(),
      reviso: $("#reviso").val(),
      cargo: $("#cargo").val()
    },
    success: function (data)
    {
      $("#aceptar2").hide();
      $("#firma1").prop("disabled",true);
      $("#cargo1").prop("disabled",true);
      $("#firma2").prop("disabled",true);
      $("#cargo2").prop("disabled",true);
      $("#firma3").prop("disabled",true);
      $("#cargo3").prop("disabled",true);
      $("#firma4").prop("disabled",true);
      $("#cargo4").prop("disabled",true);
      $("#reviso").prop("disabled",true);
      $("#cargo").prop("disabled",true);
    }
  });
}
function veri_cash()
{
  var cash;
  cash = $("#cash");
  var valid = true;
  valid = checkRegexp(cash, /^([0-9])+$/, "Solo se premite caracteres: 0 - 9");
  if (valid == false)
  {
    $("#cash").val('');
    $("#cash").addClass("ui-state-error");
  }
  else
  {
    $("#cash").removeClass("ui-state-error");
  }
}
function check(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[a-zA-Z0-9-: ]/;
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
// 14/07/2023 - Ajuste en el nombre de unidades con espacio en la sigla para pago de recompensas
// 01/08/2023 - Ajuste y validación de dato encriptado de unidades y valores del egreso
// 18/08/2023 - Ajuste y verificación no grabar doble egreso
// 20/02/2024 - Ajuste amplicacion del campo numero de soporte a 250 caracteres
// 09/04/2024 - Ajuste envio de unidad
// 30/05/2024 - Ajuste recurso y rubro uom
// 22/07/2024 - Ajuste validación cuenta bancaria
// 31/07/2024 - Ajuste inclusion cargo reviso
// 21/04/2025 - Ajuste cuenta CUN
?>