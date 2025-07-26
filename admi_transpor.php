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
  include('funciones.php');
  include('permisos.php');
  $mes = date('m');
  $mes = intval($mes);
  $ano = date('Y');
  $query = "SELECT unidad, dependencia, tipo FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $query);
  $n_unidad = odbc_result($cur,1);
  $n_dependencia = odbc_result($cur,2);
  $n_tipo = odbc_result($cur,3);
  if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
  {
    if (($nun_usuario == "2") or ($nun_usuario == "3"))
    {
      if ($n_dependencia == "2")
      {
        $pregunta = "SELECT dependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND unic='1'";
      }
      else
      {
        $pregunta = "SELECT dependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' AND unic='1'";
      }
      $sql = odbc_exec($conexion, $pregunta);
      $con = odbc_num_rows($sql);
      $paso = "";
      while($i<$row=odbc_fetch_array($sql))
      {
        $paso .= "'".odbc_result($sql,1)."',";
      }
      $paso = substr($paso, 0, -1);
      $dependencia = odbc_result($sql,1);
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia IN ($paso) ORDER BY subdependencia";
    }
    else
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unic='1' ORDER BY subdependencia";
    }
  }
  else
  {
    if ($n_tipo == "7")
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND dependencia='$n_dependencia' ORDER BY subdependencia";
    }
    else
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' ORDER BY subdependencia";
    }
  }
  $cur1 = odbc_exec($conexion, $query1);
  $numero = "";
  while($i<$row=odbc_fetch_array($cur1))
  {
    $numero .= "'".odbc_result($cur1,1)."',";
  }
  $numero = substr($numero,0,-1);
  $numero = trim($numero);
  // Se verifica si es unidad centralizadora especial
  if (strpos($especial, $uni_usuario) !== false)
  {
    $numero .= ",";
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
    $numero .= "'".$uni_usuario."'";
  }
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
          <h3>Administraci&oacute;n de Transportes</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Batall&oacute;n</font></label>
                  <input type="hidden" name="v_unidades" id="v_unidades" class="form-control" value="<?php echo $numero; ?>" readonly="readonly">
                  <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly">
                  <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly">
                  <input type="hidden" name="v_super" id="v_super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly">
                  <input type="hidden" name="interno" id="interno" class="form-control numero" value="0" tabindex="1">
                  <select name="batallon" id="batallon" class="form-control select2" onchange="busca();" tabindex="2"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Brigada</font></label>
                  <select name="brigada" id="brigada" class="form-control select2" tabindex="3"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Divisi&oacute;n</font></label>
                  <select name="division" id="division" class="form-control select2" tabindex="4"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Compa&ntilde;&iacute;a</font></label>
                  <input type="text" name="compania" id="compania" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="60" tabindex="5" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Placa</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/placa.png" name="img1" id="img1" height="20" border="0" title="Modificar Placa" class="mas" onclick="actu1();"><img src="dist/img/grabar.png" name="img2" id="img2" width="20" border="0" title="Actualizar Placa" class="mas" onclick="actu2();"></label>
                  <input type="text" name="placa" id="placa" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check3(event);" onblur="trae_placa();" maxlength="6" tabindex="6" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Clase de Veh&iacute;culo</font></label>
                  <select name="clase" id="clase" class="form-control select2" tabindex="7"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Nombre Aseguradora</font></label>
                  <input type="text" name="aseguradora" id="aseguradora" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="60" tabindex="9" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha T. Riesgo</font></label>
                  <input type="text" name="fecha" id="fecha" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="10">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Seguro T. Riesgo</font></label>
                  <select name="riesgo" id="riesgo" class="form-control select2" tabindex="11">
                    <option value="0">NO ACTIVA</option>
                    <option value="1">ACTIVA</option>
                    <option value="2">VENCIDA</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Aseguradora SOAT</font></label>
                  <input type="text" name="aseguradora1" id="aseguradora1" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="60" tabindex="12" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">N&uacute;mero SOAT</font></label>
                  <input type="text" name="soat" id="soat" class="form-control" value="" onkeypress="return check(event);" maxlength="25" tabindex="13" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha SOAT</font></label>
                  <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="14">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Vencim. SOAT</font></label>
                  <input type="text" name="fecha7" id="fecha7" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="15">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha R.T.M</font></label>
                  <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="16">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Vencim. R.T.M</font></label>
                  <input type="text" name="fecha8" id="fecha8" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="17">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha Mantenim.</font></label>
                  <input type="text" name="fecha3" id="fecha3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="18">
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">No. Inventario</font></label>
                  <input type="text" name="inventa" id="inventa" class="form-control" value="" onkeypress="return check(event);" maxlength="25" tabindex="19" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo Mantenimiento</font></label>
                  <input type="text" name="mantenimiento" id="mantenimiento" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="50" tabindex="20" autocomplete="off">
                </div>
                <div class="col col-lg-9 col-sm-9 col-md-9 col-xs-9">
                  <label><font face="Verdana" size="2">Descripci&oacute;n Mantenimiento</font></label>
                  <textarea name="mantenimiento1" id="mantenimiento1" class="form-control" rows="3" onblur="val_caracteres('mantenimiento1');" tabindex="21"></textarea>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Marca</font></label>
                  <input type="text" name="marca" id="marca" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="50" tabindex="22" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Linea</font></label>
                  <input type="text" name="linea" id="linea" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="50" tabindex="23" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Modelo</font></label>
                  <input type="text" name="modelo" id="modelo" class="form-control" value="" onkeypress="return check(event);" maxlength="10" tabindex="24" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Cilindraje</font></label>
                  <input type="text" name="cilindraje" id="cilindraje" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="10" tabindex="25" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Activo Fijo</font></label>
                  <input type="text" name="activo" id="activo" class="form-control" value="" onkeypress="return check(event);" maxlength="25" tabindex="26" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Centro de Costo</font></label>
                  <input type="text" name="costo" id="costo" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="25" tabindex="27" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo Combustible</font></label>
                  <select name="combustible" id="combustible" class="form-control select2" tabindex="28"></select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Color</font></label>
                  <input type="text" name="color" id="color" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check3(event);" maxlength="50" tabindex="29" autocomplete="off">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">N&uacute;mero Motor</font></label>
                  <input type="text" name="motor" id="motor" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check4(event);" maxlength="50" tabindex="30" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">N&uacute;mero Chasis</font></label>
                  <input type="text" name="chasis" id="chasis" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check4(event);" maxlength="50" tabindex="31" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Matr&iacute;cula</font></label>
                  <input type="text" name="matricula" id="matricula" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="50" tabindex="32" autocomplete="off">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Estado</font></label>
                  <select name="estado" id="estado" class="form-control select2" tabindex="33">
                    <option value="1">SERVICIO</option>
                    <option value="2">FUERA DE SERVICIO</option>
                    <option value="3">MANTENIMIENTO</option>
                    <option value="4">INVESTIGACI&Oacute;N ADMINISTRATIVA</option>
                    <option value="5">HURTO</option>
                    <option value="6">SINIESTRO</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha Alta</font></label>
                  <input type="text" name="fecha4" id="fecha4" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="34">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Or&iacute;gen Recurso</font></label>
                  <input type="text" name="origen" id="origen" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check2(event);" maxlength="50" tabindex="35" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">N&uacute;mero Equipo</font></label>
                  <input type="text" name="equipo" id="equipo" class="form-control" value="" onkeypress="return check(event);" maxlength="25" tabindex="36" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Med. Consumo</font></label>
                  <input type="text" name="consumo" id="consumo" class="form-control numero" value="" onkeypress="return check(event);" maxlength="25" tabindex="37" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Med. Kilometraje</font></label>
                  <input type="text" name="kilometraje" id="kilometraje" class="form-control numero" value="" onkeypress="return check(event);" maxlength="25" tabindex="38" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Empadronamiento</font></label>
                  <select name="empadrona" id="empadrona" class="form-control select2" tabindex="39">
                    <option value="1">CEDE2</option>
                    <option value="2">CEDE4</option>
                    <option value="3">CONTRATO</option>
                    <option value="4">MIXTO</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
                  <label><font face="Verdana" size="2">Observaciones</font></label>
                  <textarea name="observaciones" id="observaciones" class="form-control" rows="5" onblur="val_caracteres('observaciones');" tabindex="40"></textarea>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Autoriza</font></label>
                  <select name="autoriza" id="autoriza" class="form-control select2" onchange="verifica();" tabindex="41">
                    <option value="2">NO</option>
                    <option value="1">SI</option>
                  </select>
                  <br>
                  <input type="button" name="aceptar2" id="aceptar2" value="Autorizar">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Reinicio Od&oacute;metro</font></label>
                  <select name="odometro" id="odometro" class="form-control select2" tabindex="42">
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                  </select>
                </div>
              </div>
              <br>
                <center>
                  <input type="button" name="aceptar" id="aceptar" value="Registrar">
                  <input type="button" name="aceptar1" id="aceptar1" value="Actualizar">
                </center>
            </form>
            <form name="formu_excel" id="formu_excel" action="trans_parque_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
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
                <input type="text" name="fecha5" id="fecha5" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">&nbsp;</font></label>
                <input type="text" name="fecha6" id="fecha6" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                <label><font face="Verdana" size="2">Tipo Fecha</font></label>
                <select name="tipo" id="tipo" class="form-control select2">
                  <option value="-">- SELECCIONAR -</option>
                  <option value="1">FECHA SEGURO</option>
                  <option value="2">FECHA SOAT</option>
                  <option value="6">VENCIMIENTO SOAT</option>
                  <option value="3">FECHA R.T.M</option>
                  <option value="7">VENCIMIENTO R.T.M</option>
                  <option value="4">FECHA MANTENIMIENTO</option>
                  <option value="5">ALTA VEH&Iacute;CULO</option>
                </select>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Unidad</font></label>
                <select name="unidad" id="unidad" class="form-control select2"></select>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <br>
                <center>
                  <input type="button" name="consultar" id="consultar" value="Consultar">
                </center>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Placa</font></label>
                <input type="text" name="placa1" id="placa1" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check3(event);" maxlength="6" autocomplete="off">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Clase de Veh&iacute;culo</font></label>
                <select name="clase1" id="clase1" class="form-control select2"></select>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Empadronamiento</font></label>
                <select name="empadrona1" id="empadrona1" class="form-control select2">
                  <option value="-">- TODOS -</option>
                  <option value="1">CEDE2</option>
                  <option value="2">CEDE4</option>
                  <option value="3">CONTRATO</option>
                  <option value="4">MIXTO</option>
                </select>
              </div>
              <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                <label><font face="Verdana" size="2">Estado</font></label>
                <select name="estado1" id="estado1" class="form-control select2">
                  <option value="-">- TODOS -</option>
                  <option value="1">SERVICIO</option>
                  <option value="2">FUERA DE SERVICIO</option>
                  <option value="3">MANTENIMIENTO</option>
                  <option value="4">INVESTIGACI&Oacute;N ADMINISTRATIVA</option>
                  <option value="5">HURTO</option>
                  <option value="6">SINIESTRO</option>
                </select>
              </div>
              <div id="lbl_focis">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">FOCIS</font></label>
                  <select name="focis" id="focis" class="form-control select2"></select>
                </div>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
            </div>
            <br>
            <div id="tabla7"></div>
            <div id="resultados5"></div>
          </div>
          <div id="dialogo"></div>
          <div id="dialogo1"></div>
          <div id="dialogo2"></div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="js/jquery.quicksearch.js?1.0.0" type="text/javascript"></script>
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
  $("#fecha").datepicker({
    dateFormat: "yy/mm/dd",
    changeYear: true,
    changeMonth: true
  });
  $("#fecha1").datepicker({
    dateFormat: "yy/mm/dd",
    changeYear: true,
    changeMonth: true
  });
  $("#fecha2").datepicker({
    dateFormat: "yy/mm/dd",
    changeYear: true,
    changeMonth: true
  });
  $("#fecha3").datepicker({
    dateFormat: "yy/mm/dd",
    changeYear: true,
    changeMonth: true
  });
  $("#fecha4").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#fecha5").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fecha6").prop("disabled", false);
      $("#fecha6").datepicker("destroy");
      $("#fecha6").val('');
      $("#fecha6").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha5").val(),
        changeYear: true,
        changeMonth: true
      });
    },
  });
  $("#fecha7").datepicker({
    dateFormat: "yy/mm/dd",
    changeYear: true,
    changeMonth: true
  });
  $("#fecha8").datepicker({
    dateFormat: "yy/mm/dd",
    changeYear: true,
    changeMonth: true
  });
  $("#load").hide();
  $("#load1").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 265,
    width: 610,
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
        validacion();
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
        $(this).dialog("close");
        autorizacion();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#batallon").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  trae_ano();
  trae_unidades();
  trae_brigadas();
  trae_divisiones();
  trae_vehiculos();
  $("#valor").maskMoney();
  $("#interno").prop("disabled",true);
  $("#brigada").prop("disabled",true);
  $("#division").prop("disabled",true);
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").hide();
  $("#aceptar2").button();
  $("#aceptar2").click(pregunta1);
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").hide();
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#img1").hide();
  $("#img2").hide();
  $("#add_field").hide();
  $("#autoriza").prop("disabled",true);
  $("#odometro").prop("disabled",true);
  var v_super = $("#v_super").val();  
  if (v_super == "0")
  {
    $("#lbl_focis").hide();
  }
  else
  {
    $("#lbl_focis").show();
  }
  $("#unidad").select2.defaults.set("width", "100%");
  $("#unidad").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
});
function trae_ano()
{
  $("#focis").html('');
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
        if (ano >= 2024)
        {
          salida += "<option value='"+ano+"'>"+ano+"</option>";
        }
      }
      $("#focis").append(salida);
    }
  });
}
function trae_unidades()
{
  $("#batallon").html('');
  $("#unidad").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unid.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      salida += "<option value='0'>- SELECCIONAR -</option>";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#batallon").append(salida);
      $("#unidad").append(salida);
      trae_administra();
    }
  });
}
function trae_brigadas()
{
  $("#brigada").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_brig.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
          var dependencia = registros[i].dependencia;
          var nombre = registros[i].nombre;
          salida += "<option value='"+dependencia+"'>"+nombre+"</option>";
      }
      $("#brigada").append(salida);
    }
  });
}
function trae_divisiones()
{
  $("#division").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_divi.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
          var unidad = registros[i].unidad;
          var nombre = registros[i].nombre;
          salida += "<option value='"+unidad+"'>"+nombre+"</option>";
      }
      $("#division").append(salida);
    }
  });
}
function trae_administra()
{
  var v_super = $("#v_super").val();
  if ((v_super == "4") || (v_super == "5") || (v_super == "6"))
  {
    var v_unidad = $("#v_unidad").val();
    var batallon = "['"+v_unidad+"']";
    var batallon1 = '$("#batallon").val('+batallon+').trigger("change");';
    eval(batallon1);
    $("#batallon").prop("disabled",true);
    $("#unidad").val(v_unidad);
    $("#unidad").prop("disabled",true);
  }
}
function trae_vehiculos()
{
  $("#clase").html('');
  $("#clase1").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_vehi.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var salida1 = "<option value='-'>- TODOS -</option>";
      var j = 0;
      for (var i in registros) 
      {
        j = j+1;
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
        salida1 += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#clase").append(salida);
      $("#clase1").append(salida1);
      trae_combustible();
    }
  });
}
function trae_combustible()
{
  $("#combustible").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_combus.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var j = 0;
      for (var i in registros) 
      {
        j = j+1;
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#combustible").append(salida);
    }
  });
}
function trae_placa()
{
  var placa = $("#placa").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_placa.php",
    data:
    {
      placa: placa
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var total = registros.total;
      if (total>0)
      {
        var detalle = "<center><h3>Placa "+placa+" ya Registrada</h3></center>";
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
  });
}
function busca()
{
  var batallon = $("#batallon").val();
  if (batallon == "0")
  {
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_brig1.php",
      data:
      {
        unidad: batallon
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        $("#brigada").val(registros.brigada);
        $("#division").val(registros.division);
      }
    });
  }
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
  var placa = $("#placa").val();
  var detalle = "<center><h3>Esta seguro de autorizar la Placa "+placa+" ?</h3></center>";
  $("#dialogo2").html(detalle);
  $("#dialogo2").dialog("open");
  $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function verifica()
{
  var autoriza = $("#autoriza").val();
  if (autoriza == "1")
  {
    $("#aceptar2").show();
  }
  else
  {
    $("#aceptar2").hide();
  }
}
function autorizacion()
{
  var placa = $("#placa").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_grab5.php",
    data:
    {
      placa: placa
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        $("#aceptar").hide();
        $("#aceptar1").hide();
        $("#aceptar2").hide();
        $("#autoriza").prop("disabled",true);
      }
    }
  });
}
function validacion()
{
  var salida = true, detalle = '';
  var valor = $("#batallon").val();
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar el campo Batallón</h3></center>";
  }

  var valor1 = $("#compania").val();
  valor1 = valor1.trim().length;
  if (valor1 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Compañía del Vehículo</h3></center>";
    $("#compania").addClass("ui-state-error");
  }
  else
  {
    $("#compania").removeClass("ui-state-error");
  }
  var valor2 = $("#placa").val();
  valor2 = valor2.trim().length;
  if (valor2 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Placa del Vehículo</h3></center>";
    $("#placa").addClass("ui-state-error");
  }
  else
  {
    $("#placa").removeClass("ui-state-error");
  }
  var valor3 = $("#aseguradora").val();
  valor3 = valor3.trim().length;
  if (valor3 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Nombre de la Aseguradora</h3></center>";
    $("#aseguradora").addClass("ui-state-error");
  }
  else
  {
    $("#aseguradora").removeClass("ui-state-error");
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var valida = $("#interno").val();
    if (valida == "0")
    {
      nuevo(1);
    }
    else
    {
      nuevo(2);
    }
  }
}
function nuevo(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_grab.php",
    data:
    {
      tipo: valor,
      conse: $("#interno").val(),
      batallon: $("#batallon").val(),
      brigada: $("#brigada").val(),
      division: $("#division").val(),
      compania: $("#compania").val(),
      placa: $("#placa").val(),
      clase: $("#clase").val(),
      aseguradora: $("#aseguradora").val(),
      fecha: $("#fecha").val(),
      riesgo: $("#riesgo").val(),
      aseguradora1: $("#aseguradora1").val(),
      soat: $("#soat").val(),
      fecha1: $("#fecha1").val(),
      fecha2: $("#fecha2").val(),
      fecha3: $("#fecha3").val(),
      mantenimiento: $("#mantenimiento").val(),
      mantenimiento1: $("#mantenimiento1").val(),
      marca: $("#marca").val(),
      linea: $("#linea").val(),
      modelo: $("#modelo").val(),
      cilindraje: $("#cilindraje").val(),
      activo: $("#activo").val(),
      costo: $("#costo").val(),
      combustible: $("#combustible").val(),
      color: $("#color").val(),
      motor: $("#motor").val(),
      chasis: $("#chasis").val(),
      matricula: $("#matricula").val(),
      estado: $("#estado").val(),
      fecha4: $("#fecha4").val(),
      origen: $("#origen").val(),
      equipo: $("#equipo").val(),
      consumo: $("#consumo").val(),
      kilometraje: $("#kilometraje").val(),
      empadrona: $("#empadrona").val(),
      odometro: $("#odometro").val(),
      observaciones: $("#observaciones").val(),
      usuario: $("#v_usuario").val(),
      unidad: $("#v_unidad").val(),
			fecha7: $("#fecha7").val(),
      fecha8: $("#fecha8").val(),
			inventa: $("#inventa").val()
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
      var salida = registros.salida;
      var consecu = registros.consecu;
      if (salida == "1")
      {
        $("#aceptar").hide();
        $("#aceptar1").hide();
        $("#interno").val(consecu);
        $("#batallon").prop("disabled",true);
        $("#compania").prop("disabled",true);
        $("#placa").prop("disabled",true);
        $("#clase").prop("disabled",true);
        $("#aseguradora").prop("disabled",true);
        $("#fecha").prop("disabled",true);
        $("#riesgo").prop("disabled",true);
        $("#aseguradora1").prop("disabled",true);
        $("#soat").prop("disabled",true);
        $("#fecha1").prop("disabled",true);
        $("#fecha2").prop("disabled",true);
        $("#fecha3").prop("disabled",true);
        $("#mantenimiento").prop("disabled",true);
        $("#mantenimiento1").prop("disabled",true);
        $("#marca").prop("disabled",true);
        $("#linea").prop("disabled",true);
        $("#modelo").prop("disabled",true);
        $("#cilindraje").prop("disabled",true);
        $("#activo").prop("disabled",true);
        $("#costo").prop("disabled",true);
        $("#combustible").prop("disabled",true);
        $("#color").prop("disabled",true);
        $("#motor").prop("disabled",true);
        $("#chasis").prop("disabled",true);
        $("#matricula").prop("disabled",true);
        $("#estado").prop("disabled",true);
        $("#fecha4").prop("disabled",true);
        $("#origen").prop("disabled",true);
        $("#equipo").prop("disabled",true);
        $("#consumo").prop("disabled",true);
        $("#kilometraje").prop("disabled",true);
        $("#empadrona").prop("disabled",true);
        $("#odometro").prop("disabled",true);
        $("#observaciones").prop("disabled",true);
        $("#fecha7").prop("disabled",true);
        $("#fecha8").prop("disabled",true);
        $("#inventa").prop("disabled",true);
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        if (valor == "1")
        {
          $("#aceptar").show();
        }
        else
        {
          $("#aceptar1").show();
        }
      }
    }
  });
}
function consultar()
{
  var v_unidad = $("#v_unidad").val();
  var v_super = $("#v_super").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_consu.php",
    data:
    {
      tipo: $("#tipo").val(),
      fecha1: $("#fecha5").val(),
      fecha2: $("#fecha6").val(),
      placa: $("#placa1").val(),
      unidad: $("#unidad").val(),
      unidades: $("#v_unidades").val(),
      clase: $("#clase1").val(),
      empadrona: $("#empadrona1").val(),
      estado: $("#estado1").val(),
      focis: $("#focis").val()
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
      $("#tabla7").html('');
      $("#resultados5").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      listareg = [];
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table><br>";
			salida1 += "<div class='row'><div class='col col-lg-3 col-sm-3 col-md-3 col-xs-3'><input type='text' name='buscar' id='buscar' placeholder='Buscar...' class='form-control' autocomplete='off' /></div><div class='col col-lg-8 col-sm-8 col-md-8 col-xs-8'></div>";
			salida1 += "<div class='col col-lg-1 col-sm-1 col-md-1 col-xs-1'><center><a href='#' id='excel' onclick='excel(); return false;'><img src='dist/img/excel.png' title='Descargar Transportes a Excel - SAP'></a></center></div></div>";
			salida1 += "<br>";
      salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='5%'><b>No.</b></td><td height='35' width='8%'><b>Fecha</b></td><td height='35' width='9%'><b>Unidad</b></td><td height='35' width='8%'><b>Compa&ntilde;&iacute;a</b></td><td height='35' width='8%'><b>Placa</b></td><td height='35' width='9%'><b>Clase</b></td><td height='35' width='10%'><b>Marca</b></td><td height='35' width='8%'><b>Modelo</b></td><td height='35' width='15%'><b>Activo Fijo</b></td><td height='35' width='10%'><b>Empadronamiento</b></td><td height='35' width='5%'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
      var v_var1 = "";
      $.each(registros.rows, function (index, value)
      {
        var estado = value.estado1;
        salida2 += "<tr><td height='35' width='5%' id='l1_"+index+"'>"+value.conse+"</td>";
        salida2 += "<td height='35' width='8%' id='l2_"+index+"'>"+value.fecha+"</td>";
        salida2 += "<td height='35' width='9%' id='l3_"+index+"'>"+value.unidad+"</td>";
        salida2 += "<td height='35' width='8%' id='l4_"+index+"'>"+value.compania+"</td>";
        salida2 += "<td height='35' width='8%' id='l5_"+index+"'>"+value.placa+"</td>";
        salida2 += "<td height='35' width='9%' id='l6_"+index+"'>"+value.clase+"</td>";
        salida2 += "<td height='35' width='10%' id='l7_"+index+"'>"+value.marca+"</td>";
        salida2 += "<td height='35' width='8%' id='l8_"+index+"'>"+value.modelo+"</td>";
        salida2 += "<td height='35' width='15%' id='l9_"+index+"'>"+value.activo+"</td>";
        salida2 += "<td height='35' width='10%' id='l10_"+index+"'>"+value.empadrona+"</td>";
        if ((estado == "1") && ((v_super == "1") || (v_super == "2")))
        {
          salida2 += "<td height='35' width='5%' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",12); actu("+value.conse+","+value.batallon+",1)'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
        }
        else
        {
          if ((estado == "1") && ((v_super == "4") || (v_super == "5") || (v_super == "6")))
          {
            salida2 += "<td height='35' width='5%' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",12); actu("+value.conse+","+value.batallon+",2)'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
          }
          else
          {
            salida2 += "<td height='35' width='5%' id='l11_"+index+"'><center>&nbsp;</center></td>";
          }
        }
        salida2 += "<td height='35' width='5%' id='l12_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",12); actu("+value.conse+","+value.batallon+",0)'><img src='imagenes/ver.png' border='0' title='Ver Informaci&oacute;n'></a></center></td>";
				v_var1 += value.conse+"|"+value.fecha+"|"+value.unidad+"|"+value.batallon+"|"+value.compania+"|"+value.placa+"|"+value.clase+"|"+value.marca+"|"+value.linea+"|"+value.modelo+"|"+value.activo+"|"+value.estado+"|"+value.empadrona+"|"+value.ase_nom+"|"+value.fec_seg+"|"+value.rie_seg+"|"+value.ase_soa+"|"+value.num_soa+"|"+value.fec_soa+"|"+value.fec_rtm+"|"+value.fec_man+"|"+value.tip_man+"|"+value.des_man+"|"+value.cilindraje+"|"+value.costo+"|"+value.color+"|"+value.motor+"|"+value.chasis+"|"+value.matricula+"|"+value.fec_alt+"|"+value.origen+"|"+value.equipo+"|"+value.consumo+"|"+value.kilometro+"|"+value.observaciones+"|"+value.combustible+"|"+value.odometro+"|"+value.autoriza+"|"+value.inventario+"|"+value.fec_sof+"|"+value.fec_rtf+"|#";
        listareg.push(index);
      });
      salida2 += "</table>";
      $("#paso_excel").val(v_var1);
      $("#tabla7").append(salida1);
      $("#resultados5").append(salida2);
			$("#buscar").quicksearch("table tbody tr");
    }
  });
}
function actu(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $("#interno").val(valor);
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_consu1.php",
    data:
    {
      conse: $("#interno").val(),
      batallon: valor1
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
      $("#aceptar").hide();
      $("#aceptar1").show();
      $("#aceptar2").hide();
      $("#soportes").accordion({active: 0});
      var registros = JSON.parse(data);
      var batallon = registros.batallon;
      batallon = "['"+batallon+"']";
      var batallon1 = '$("#batallon").val('+batallon+').trigger("change");';
      eval(batallon1);
      $("#batallon").prop("disabled",true);
      busca();
      $("#compania").val(registros.compania);
      $("#placa").val(registros.placa);
      $("#placa").prop("disabled",true);
      $("#clase").val(registros.clase);
      $("#aseguradora").val(registros.aseguradora);
      $("#fecha").val('');
      if (registros.fecha == "1900-01-01")
      {
      }
      else
      { 
        var fecha = registros.fecha.replace(/[-]+/g, '/');
        $("#fecha").val(fecha);
      }
      $("#riesgo").val(registros.riesgo);
      $("#aseguradora1").val(registros.aseguradora1);
      $("#soat").val(registros.soat);
      $("#fecha1").val('');
      if (registros.fecha1 == "1900-01-01")
      {
      }
      else
      {
        var fecha1 = registros.fecha1.replace(/[-]+/g, '/');
        $("#fecha1").val(fecha1);
      }
      $("#fecha2").val('');
      if (registros.fecha2 == "1900-01-01")
      {
      }
      else
      { 
        var fecha2 = registros.fecha2.replace(/[-]+/g, '/');
        $("#fecha2").val(fecha2);
      }
      $("#fecha3").val('');
      if (registros.fecha3 == "1900-01-01")
      {
      }
      else
      {
        var fecha3 = registros.fecha3.replace(/[-]+/g, '/');
        $("#fecha3").val(fecha3);
      }
      $("#mantenimiento").val(registros.mantenimiento);
      $("#mantenimiento1").val(registros.mantenimiento1);
      $("#marca").val(registros.marca);
      $("#linea").val(registros.linea);
      $("#modelo").val(registros.modelo);
      $("#cilindraje").val(registros.cilindraje);
      $("#activo").val(registros.activo);
      $("#costo").val(registros.costo);
      $("#combustible").val(registros.tipo);
      $("#color").val(registros.color);
      $("#motor").val(registros.motor);
      $("#chasis").val(registros.chasis);
      $("#matricula").val(registros.matricula);
      $("#estado").val(registros.estado);
      $("#fecha4").val('');
      if (registros.fecha4 == "1900-01-01")
      {
      }
      else
      {
        var fecha4 = registros.fecha4.replace(/[-]+/g, '/');
        $("#fecha4").val(fecha4);
      }
      $("#origen").val(registros.origen);
      $("#equipo").val(registros.equipo);
      $("#consumo").val(registros.consumo);
      $("#kilometraje").val(registros.kilometro);
      $("#empadrona").val(registros.empadrona);
      $("#odometro").val(registros.odometro);
      $("#observaciones").val(registros.observaciones);
      $("#inventa").val(registros.inventa);
      $("#fecha7").val('');
      if (registros.fecha7 == "1900-01-01")
      {
      }
      else
      { 
        var fecha7 = registros.fecha7.replace(/[-]+/g, '/');
        $("#fecha7").val(fecha7);
      }
      $("#fecha8").val('');
      if (registros.fecha8 == "1900-01-01")
      {
      }
      else
      { 
        var fecha8 = registros.fecha8.replace(/[-]+/g, '/');
        $("#fecha8").val(fecha8);
      }
      if (valor2 == "0")
      {
        $("#compania").prop("disabled",true);
        $("#clase").prop("disabled",true);
        $("#aseguradora").prop("disabled",true);
        $("#fecha").prop("disabled",true);
        $("#riesgo").prop("disabled",true);
        $("#aseguradora1").prop("disabled",true);
        $("#soat").prop("disabled",true);
        $("#fecha1").prop("disabled",true);
        $("#fecha2").prop("disabled",true);
        $("#fecha3").prop("disabled",true);
        $("#mantenimiento").prop("disabled",true);
        $("#mantenimiento1").prop("disabled",true);
        $("#marca").prop("disabled",true);
        $("#linea").prop("disabled",true);
        $("#modelo").prop("disabled",true);
        $("#cilindraje").prop("disabled",true);
        $("#activo").prop("disabled",true);
        $("#costo").prop("disabled",true);
        $("#combustible").prop("disabled",true);
        $("#color").prop("disabled",true);
        $("#motor").prop("disabled",true);
        $("#chasis").prop("disabled",true);
        $("#matricula").prop("disabled",true);
        $("#estado").prop("disabled",true);
        $("#fecha4").prop("disabled",true);
        $("#origen").prop("disabled",true);
        $("#equipo").prop("disabled",true);
        $("#consumo").prop("disabled",true);
        $("#kilometraje").prop("disabled",true);
        $("#empadrona").prop("disabled",true);
        $("#odometro").prop("disabled",true);
        $("#observaciones").prop("disabled",true);
				$("#inventa").prop("disabled",true);
        $("#fecha7").prop("disabled",true);
        $("#fecha8").prop("disabled",true);
        $("#aceptar1").hide();
        $("#img1").hide();
      }
      else
      {
        if (valor2 == "2")
        {
          $("#compania").prop("disabled",true);
        }
        else
        {
          $("#compania").prop("disabled",false);
        }
        if (valor2 == "2")
        {
          $("#clase").prop("disabled",true);
        }
        else
        {
          $("#clase").prop("disabled",false);
        }
        $("#aseguradora").prop("disabled",false);
        $("#fecha").prop("disabled",false);
        $("#riesgo").prop("disabled",false);
        $("#aseguradora1").prop("disabled",false);
        $("#soat").prop("disabled",false);
        $("#fecha1").prop("disabled",false);
        $("#fecha2").prop("disabled",false);
        $("#fecha3").prop("disabled",false);
        if (valor2 == "2")
        {
          $("#mantenimiento").prop("disabled",true);
          $("#mantenimiento1").prop("disabled",true);
          $("#marca").prop("disabled",true);
          $("#linea").prop("disabled",true);
          $("#modelo").prop("disabled",true);
          $("#cilindraje").prop("disabled",true);
          $("#combustible").prop("disabled",true);
          $("#color").prop("disabled",true);
          $("#matricula").prop("disabled",true);
          $("#estado").prop("disabled",true);
          $("#fecha4").prop("disabled",true);
          $("#origen").prop("disabled",true);
          $("#equipo").prop("disabled",true);
          $("#empadrona").prop("disabled",true);
          $("#observaciones").prop("disabled",true);
        }
        else
        {
          $("#mantenimiento").prop("disabled",false);
          $("#mantenimiento1").prop("disabled",false);
          $("#marca").prop("disabled",false);
          $("#linea").prop("disabled",false);
          $("#modelo").prop("disabled",false);
          $("#cilindraje").prop("disabled",false);
          $("#combustible").prop("disabled",false);
          $("#color").prop("disabled",false);
          $("#matricula").prop("disabled",false);
          $("#estado").prop("disabled",false);
          $("#fecha4").prop("disabled",false);
          $("#origen").prop("disabled",false);
          $("#equipo").prop("disabled",false);
          $("#empadrona").prop("disabled",false);
          $("#observaciones").prop("disabled",false);
          $("#inventa").prop("disabled",false);
          $("#fecha7").prop("disabled",false);
          $("#fecha8").prop("disabled",false);
        }
        $("#activo").prop("disabled",false);
        $("#costo").prop("disabled",false);
        $("#motor").prop("disabled",false);
        $("#chasis").prop("disabled",false);
        $("#consumo").prop("disabled",true);
        $("#kilometraje").prop("disabled",true);
        $("#aceptar1").show();
        var v_super = $("#v_super").val();
        var v_usuario = $("#v_usuario").val();
        if ((v_super == "1") || (v_super == "2"))
        {
          $("#img1").show();
          $("#batallon").prop("disabled",false);
        }
        else
        {
          $("#img1").hide();
          $("#batallon").prop("disabled",true);
        }
        $("#autoriza").val('2');
        if (registros.empadrona == "2")
        {
          $("#autoriza").prop("disabled",false);
        }
        else
        {
          $("#autoriza").prop("disabled",true);
        }
        if ((registros.clase == "1") || (registros.clase == "2"))
        {
          if (valor2 == "2")
          {
            $("#odometro").prop("disabled",true);
          }
          else
          {
            $("#odometro").prop("disabled",false);
          }
        }
        else
        {
          if (valor2 == "2")
          {
            $("#odometro").prop("disabled",true);
          }
          else
          {
            $("#odometro").prop("disabled",false);
          }
        }
        if (registros.autoriza == "1")
        {
          $("#autoriza").val('1');
          $("#autoriza").prop("disabled",true);
        }
        else
        {
          $("#autoriza").val('2');
        }
      }
    }
  });
}
function actu1()
{
  $("#img1").hide();
  $("#img2").show();
  $("#placa").prop("disabled",false);
  $("#placa").focus();
  $("#aceptar").hide();
  $("#aceptar1").hide();
}
function actu2()
{
  var interno = $("#interno").val();
  var placa = $("#placa").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_grab4.php",
    data:
    {
      interno: interno,
      placa: placa
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        $("#img2").hide();
        $("#placa").prop("disabled",true);
        $("#aceptar").hide();
        $("#aceptar1").hide();
      }
    }
  });
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
function check2(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]/;
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
  patron = /[0-9a-zA-Z]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function check4(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9a-zA-Z-*]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function excel()
{
  formu_excel.submit();
}
function excel1()
{
  formu_excel1.submit();
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
// 03/01/2024 - Inclusion 3 campos (vencimiento soat, rtm e inventario)
// 09/02/2024 - Ajuste para habilitar reinicio de odometro para automoviles
// 15/02/2024 - Ajuste modificacion techos
// 01/03/2024 - Ajuste techos inclusion tipo de combustible
// 07/05/2024 - Ajuste carge combo buscador
// 08/05/2024 - Ajuste independizar modulo de techos del administrador
// 17/07/2024 - Ajuste consulta filtro estado
// 31/01/2025 - Ajuste inclusion año focis
// 17/02/2025 - Ajuste focis permiso administrador
// 22/04/2025 - Ajuste buscador campo unidad
?>