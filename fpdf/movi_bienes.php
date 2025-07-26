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
  $query = "SELECT unidad, dependencia, unic FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $query);
  $n_unidad = odbc_result($cur,1);
  $n_unidad = intval($n_unidad);
  $n_dependencia = odbc_result($cur,2);
  $n_dependencia = intval($n_dependencia);
  $n_unic = odbc_result($cur,3);
  $n_unic = intval($n_unic);
  if ($n_unic == "1")
  {
    if ($n_unidad <= 3)
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' ORDER BY subdependencia";
      $cur1 = odbc_exec($conexion, $query1);
      $numero = "";
      $numero1 = "";
      while($i<$row=odbc_fetch_array($cur1))
      {
        $numero .= "'".odbc_result($cur1,1)."',";
        $numero1 .= odbc_result($cur1,1).",";
      }
      $numero = substr($numero,0,-1);
      $numero1 = substr($numero1,0,-1);
    }
    if ($n_unidad > 3)
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
      $cur1 = odbc_exec($conexion, $query1);
      $numero = "";
      $numero1 = "";
      while($i<$row=odbc_fetch_array($cur1))
      {
        $numero .= "'".odbc_result($cur1,1)."',";
        $numero1 .= odbc_result($cur1,1).",";
      }
      $numero = substr($numero,0,-1);
      $numero1 = substr($numero1,0,-1);
    }
  }
  else
  {
    $numero = $uni_usuario;
    $numero1 = $uni_usuario;
  }
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
        <div id="soportes">
          <h3>Movimiento de Bienes</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo de Movimiento</font></label>
                  <select name="tipo" id="tipo" class="form-control select2" onchange="verifica();" tabindex="1">
                    <option value="1">ASIGNACI&Oacute;N</option>
                    <option value="5">ASIGNACI&Oacute;N USUARIO FINAL</option>
                    <?php
                    if (($uni_usuario == "1") or ($uni_usuario == "2"))
                    {
                    ?>
                      <option value="2">SALIDA DE BIENES</option>
                    <?php
                    }
                    if (($adm_usuario == "1") or ($adm_usuario == "2"))
                    {
                    }
                    else
                    {
                    ?>
                      <option value="3">ELEMENTOS DE CONSUMO</option>
                    <?php
                    }
                    ?>
                    <option value="4">TRASPASO</option>
                    <?php
                    if (($uni_usuario == "1") or ($uni_usuario == "2") or ($n_unic == "1"))
                    {
                    ?>
                      <option value="6">REVISTA CONFRONTACI&Oacute;N DE CARGOS</option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <div id="l_salida"><label><font face="Verdana" size="2">Tipo de Salida</font></label></div>
                  <select name="tipo1" id="tipo1" class="form-control select2" tabindex="2">
                    <option value="1">ALTA DEL BIEN</option>
                    <option value="2">SINIESTRO</option>
                  </select>
                  <div id="l_salida1"><label><font face="Verdana" size="2">Unidad</font></label></div>
                  <select name="unidades1" id="unidades1" class="form-control select2" tabindex="3"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha" id="fecha" class="form-control fecha" value="<?php echo $fecha; ?>" readonly="readonly" tabindex="4">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <center>
                    <input type="button" name="aceptar" id="aceptar" value="Validar" tabindex="5">
                  </center>
                </div>
              </div>
              <br>
              <div id="datos"></div>
              <br>
              <div id="datos1">
                <br>
                <div class="row">
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Responsable Bien (Grado, Nombre y Apellido o C&oacute;digo)</font></label>
                    <input type="text" name="responsable" id="responsable" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="250" tabindex="5" autocomplete="off">
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">No. Acta / Documento Asignaci&oacute;n Bien</font></label>
                    <input type="text" name="documento" id="documento" class="form-control" maxlength="25" tabindex="6" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha Dto. Asig. Bien</font></label>
                    <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="7">
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <br>
                    <a href="#" name="lnk2" id="lnk2" onclick="subir();"><img src="imagenes/clip.png" border="0" title="Anexar Acta"></a>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <br>
                    <input type="button" name="aceptar1" id="aceptar1" value="Continuar" tabindex="8">
                  </div>
                </div>
              </div>
              <div id="datos6">
                <br>
                <div class="row">
                  <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                    <label><font face="Verdana" size="2">Usuario Final del Bien (Grado, Nombre y Apellido o C&oacute;digo)</font></label>
                    <input type="text" name="funcionario" id="funcionario" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="250" tabindex="9" autocomplete="off">
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">No. Acta / Documento Asignaci&oacute;n Bien</font></label>
                    <input type="text" name="documento1" id="documento1" class="form-control" maxlength="25" tabindex="10" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha Dto. Asig. Bien</font></label>
                    <input type="text" name="fecha9" id="fecha9" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="11">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <br>
                    <input type="button" name="aceptar6" id="aceptar6" value="Continuar" tabindex="12">
                  </div>
                </div>
              </div>
              <div id="datos2">
                <br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">N&uacute;mero Acta Alta SAP</font></label>
                    <input type="text" name="numero" id="numero" class="form-control" maxlength="25" tabindex="13" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha Acta Alta SAP</font></label>
                    <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="14">
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Almac&eacute;n a Transferir</font></label>
                    <select name="almacen" id="almacen" class="form-control select2" tabindex="15">
                      <option value="1">BASIM</option>
                      <option value="2">BASCI</option>
                    </select>
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <br>
                    <a href="#" name="lnk5" id="lnk5" onclick="subir();"><img src="imagenes/clip.png" border="0" title="Anexar Acta"></a>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <br>
                    <input type="button" name="aceptar2" id="aceptar2" value="Continuar" tabindex="16">
                  </div>
                </div>
              </div>
              <div id="datos3">
                <br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha Siniestro</font></label>
                    <input type="text" name="fecha3" id="fecha3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="17">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Tipo Siniestro</font></label>
                    <select name="tipo2" id="tipo2" class="form-control select2" tabindex="18">
                      <option value="1">HURTO</option>
                      <option value="2">PERDIDA</option>
                      <option value="3">DAÑO PARCIAL</option>
                      <option value="4">DAÑO TOTAL</option>
                      <option value="5">CASO FORTUITO</option>
                    </select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">N&uacute;mero Informe</font></label>
                    <input type="text" name="numero1" id="numero1" class="form-control" maxlength="25" tabindex="19" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha Informe</font></label>
                    <input type="text" name="fecha4" id="fecha4" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="20">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">N&uacute;mero Acto Adm.</font></label>
                    <input type="text" name="numero2" id="numero2" class="form-control" maxlength="25" tabindex="21" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha Acto Adm.</font></label>
                    <input type="text" name="fecha5" id="fecha5" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="22">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-9 col-sm-9 col-md-9 col-xs-9">
                    <label><font face="Verdana" size="2">Observaciones</font></label>
                    <textarea name="observaciones" id="observaciones" class="form-control" rows="3" onblur="val_caracteres('observaciones');" tabindex="23"></textarea>
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <br>
                    <a href="#" name="lnk6" id="lnk6" onclick="subir();"><img src="imagenes/clip.png" border="0" title="Anexar Acta"></a>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <br>
                    <input type="button" name="aceptar3" id="aceptar3" value="Continuar" tabindex="24">
                  </div>
                </div>
              </div>
              <div id="datos4">
                <br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">N&uacute;mero Acto Adm.</font></label>
                    <input type="text" name="numero3" id="numero3" class="form-control" maxlength="25" tabindex="25" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha Acto Adm.</font></label>
                    <input type="text" name="fecha6" id="fecha6" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="26">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Orden Semanal</font></label>
                    <input type="text" name="numero4" id="numero4" class="form-control" maxlength="25" tabindex="27" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha Orden</font></label>
                    <input type="text" name="fecha7" id="fecha7" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="28">
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <br>
                    <a href="#" name="lnk4" id="lnk4" onclick="subir();"><img src="imagenes/clip.png" border="0" title="Anexar Acta"></a>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-10 col-sm-10 col-md-10 col-xs-10">
                    <label><font face="Verdana" size="2">Observaciones</font></label>
                    <textarea name="observaciones1" id="observaciones1" class="form-control" rows="3" onblur="val_caracteres('observaciones1');" tabindex="29"></textarea>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <br>
                    <input type="button" name="aceptar4" id="aceptar4" value="Continuar" tabindex="30">
                  </div>
                </div>
              </div>
              <div id="datos5">
                <br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">N&uacute;mero Acto Adm.</font></label>
                    <input type="text" name="numero5" id="numero5" class="form-control" maxlength="25" tabindex="31" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha Acto Adm.</font></label>
                    <input type="text" name="fecha8" id="fecha8" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="32">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Unidad</font></label>
                    <select name="unidad" id="unidad" class="form-control" tabindex="33"><option value="0">- SELECCIONAR -</option></select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Compa&ntilde;ia</font></label>
                    <input type="text" name="compania" id="compania" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="20" tabindex="34" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">ORDOP</font></label>
                    <input type="text" name="ordop" id="ordop" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="25" tabindex="35" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Misi&oacute;n</font></label>
                    <input type="text" name="mision" id="mision" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="25" tabindex="36" autocomplete="off">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-9 col-sm-9 col-md-9 col-xs-9">
                    <label><font face="Verdana" size="2">Observaciones</font></label>
                    <textarea name="observaciones2" id="observaciones2" class="form-control" rows="3" onblur="val_caracteres('observaciones2');" tabindex="37"></textarea>
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <br>
                    <a href="#" name="lnk3" id="lnk3" onclick="subir();"><img src="imagenes/clip.png" border="0" title="Anexar Acta"></a>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <br>
                    <input type="button" name="aceptar5" id="aceptar5" value="Continuar" tabindex="38">
                  </div>
                </div>
              </div>
              <div id="datos7">
                <br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">N&uacute;mero Acta</font></label>
                    <input type="text" name="numero6" id="numero6" class="form-control" maxlength="25" tabindex="38" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha Acta</font></label>
                    <input type="text" name="fecha12" id="fecha12" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="39">
                  </div>
                  <div class="col col-lg-7 col-sm-7 col-md-7 col-xs-7"></div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <br>
                    <a href="#" name="lnk1" id="lnk1" onclick="subir();"><img src="imagenes/clip.png" border="0" title="Anexar Acta"></a>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-10 col-sm-10 col-md-10 col-xs-10">
                    <label><font face="Verdana" size="2">Observaciones</font></label>
                    <textarea name="observaciones3" id="observaciones3" class="form-control" rows="3" onblur="val_caracteres('observaciones3');" tabindex="40"></textarea>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <br>
                    <input type="button" name="aceptar7" id="aceptar7" value="Continuar" tabindex="41">
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Elaboro</font></label>
                  <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="42" autocomplete="off">
                </div>
              </div>
              <input type="hidden" name="v_paso1" id="v_paso1" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso2" id="v_paso2" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso3" id="v_paso3" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso4" id="v_paso4" value="<?php echo $numero; ?>" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso5" id="v_paso5" value="<?php echo $uni_usuario; ?>" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso6" id="v_paso6" value="<?php echo $numero1; ?>" class="form-control" readonly="readonly">
              <input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly">
              <div id="link"></div>
            </form>
          </div>
          <h3>Consulta de Movimiento de Bienes</h3>
          <div>
            <div id="load1">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <div class="row">
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Fecha</font></label>
                <input type="text" name="fecha10" id="fecha10" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">&nbsp;</font></label>
                <input type="text" name="fecha11" id="fecha11" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">C&oacute;digo</font></label>
                <input type="text" name="codigo" id="codigo" class="form-control" maxlength="25">
              </div>
              <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                <label><font face="Verdana" size="2">Tipo de Consulta</font></label>
                <select name="tipo3" id="tipo3" class="form-control select2">
                  <option value="1">BIENES EN CONTROL ADMINISTRATIVO</option>
                  <?php
                  if ($n_unic == "1")
                  {
                  ?>
                    <option value="4">REPORTE DE BIENES CENTRALIZADORA</option>
                  <?php
                  }
                  ?>
                  <option value="2">REPORTE DE BIENES</option>
                  <option value="3">MOVIMIENTO DE BIENES</option>
                </select>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <br>
                <input type="button" name="consultar" id="consultar" value="Consultar">
              </div>
            </div>
            <br>
            <div id="tabla3"></div>
            <div id="resultados5"></div>
            <form name="formu1" action="ver_movi.php" method="post" target="_blank">
              <input type="hidden" name="movi_conse" id="movi_conse" readonly="readonly">
              <input type="hidden" name="movi_tipo" id="movi_tipo" readonly="readonly">
              <input type="hidden" name="movi_tipo1" id="movi_tipo1" readonly="readonly">
              <input type="hidden" name="movi_ano" id="movi_ano" readonly="readonly">
              <input type="hidden" name="movi_unidad" id="movi_unidad" readonly="readonly">
              <input type="hidden" name="movi_alea" id="movi_alea" readonly="readonly">
            </form>
            <form name="formu_excel" id="formu_excel" action="bienes_x1.php" target="_blank" method="post">
              <input type="hidden" name="paso" id="paso" class="form-control" readonly="readonly">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div id="dialogo"></div>
<div id="dialogo1"></div>
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
  $("#load1").hide();
  $("#fecha1").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#fecha2").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#fecha3").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fecha4").prop("disabled",false);
      $("#fecha4").datepicker("destroy");
      $("#fecha4").val('');
      $("#fecha4").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha3").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true,
        onSelect: function () {
          $("#fecha5").datepicker("destroy");
          $("#fecha5").val('');
          $("#fecha5").datepicker({
            dateFormat: "yy/mm/dd",
            minDate: $("#fecha4").val(),
            maxDate: 0,
            changeYear: true,
            changeMonth: true,
          });
        },
      });
    },
  });
  $("#fecha6").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fecha7").prop("disabled", false);
      $("#fecha7").datepicker("destroy");
      $("#fecha7").val('');
      $("#fecha7").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha6").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
    },
  });
  $("#fecha8").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#fecha9").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#fecha10").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fecha11").prop("disabled", false);
      $("#fecha11").datepicker("destroy");
      $("#fecha11").val('');
      $("#fecha11").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha10").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
    },
  });
  $("#fecha12").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 330,
    width: 600,
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
        validacion();
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
  $("#aceptar").click(consultar);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta);
  $("#aceptar1").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(pregunta);
  $("#aceptar2").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").button();
  $("#aceptar3").click(pregunta);
  $("#aceptar3").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar4").button();
  $("#aceptar4").click(pregunta);
  $("#aceptar4").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar5").button();
  $("#aceptar5").click(pregunta);
  $("#aceptar5").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar6").button();
  $("#aceptar6").click(pregunta);
  $("#aceptar6").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar7").button();
  $("#aceptar7").click(pregunta);
  $("#aceptar7").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#consultar").button();
  $("#consultar").click(consultar1);
  $("#consultar").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#datos1").hide();
  $("#datos2").hide();
  $("#datos3").hide();
  $("#datos4").hide();
  $("#datos5").hide();
  $("#datos6").hide();
  $("#datos7").hide();
  $("#l_salida").hide();
  $("#tipo1").hide();
  $("#l_salida1").hide();
  $("#unidades1").hide();
  trae_unidades();
  trae_unidades1();
});
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
      $("#unidad").append(salida);
    }
  });
}
function trae_unidades1()
{
  $("#unidades1").html('');
  var unidad = $("#v_paso5").val();
  if ((unidad == "1") || (unidad == "2"))
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_unid.php",
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
        $("#unidades1").append(salida);
      }
    });
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_unidades.php",
      data:
      {
        unidades: $("#v_paso4").val()
      },
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
        $("#unidades1").append(salida);
      }
    });
  }
}
function verifica()
{
  var tipo = $("#tipo").val();
  if (tipo == "1")
  {
    $("#tipo1").hide();
    $("#l_salida").hide();
    $("#unidades1").hide();
    $("#l_salida1").hide();
  }
  else
  {
    if (tipo == "2")
    {
      $("#tipo1").show();
      $("#l_salida").show();
      $("#unidades1").hide();
      $("#l_salida1").hide();
    }
    else
    {
      if (tipo == "6")
      {
        $("#tipo1").hide();
        $("#l_salida").hide();
        $("#unidades1").show();
        $("#l_salida1").show();
      }
      else
      {
        $("#tipo1").hide();
        $("#l_salida").hide();
        $("#unidades1").hide();
        $("#l_salida1").hide();
      }
    }
  } 
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de registrar el movimiento ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function consultar()
{ 
  var tipo = $("#tipo").val();
  var tipo1 = $("#tipo1").val();
  var numeros = $("#v_paso4").val();
  var unidad = $("#unidades1").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "bien_movi.php",
    data:
    {
      tipo: tipo,
      numeros: numeros,
      unidad: unidad
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
      $("#datos").html('');
      var registros = JSON.parse(data);
      var salida = "";
      var total = registros.total;
      total = parseInt(total);
      if (total > 0)
      {
        salida += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Bienes Encontrados: ( "+total+" )</b></td></tr></table>";
        salida += "<table width='100%' align='center' border='0'><tr><td width='5%' height='35'>&nbsp;</td><td width='10%' height='35'><b>C&oacute;digo</b></td><td width='30%' height='35'><b>Descripci&oacute;n</b></td><td width='10%' height='35'><center><b>Valor</b></center></td>";
        if ((tipo == "1") || (tipo == "5"))
        {
          salida += "<td width='15%' height='35'><center><b>Serial</b></center></td>";
        }
        else
        {
          salida += "<td width='15%' height='35'><center><b>Unidad</b></center></td>";
        }
        if ((tipo == "2") && (tipo1 == "1"))
        {
          salida += "<td width='10%' height='35'><center><b>Serial</b></center></td>";
        }
        else
        {
          salida += "<td width='10%' height='35'><center><b>Compa&ntilde;&iacute;a</b></center></td>";
        }
        if ((tipo == "2") && (tipo1 == "1"))
        {
          salida += "<td width='20%' height='35'><center><b>C&oacute;digo SAP</b></center></td>";
        }
        if ((tipo == "1") || (tipo == "5"))
        {
          salida += "<td width='20%' height='35'><center><b>Estado</b></center></td>";
        }
        else
        {
          if ((tipo == "4") || (tipo == "6"))
          {
          }
          else
          {
            if ((tipo == "2") && (tipo1 == "1"))
            {
            }
            else
            {
              salida += "<td width='10%' height='35'><center><b>ORDOP</b></center></td><td width='10%' height='35'><center><b>Misi&oacute;n</b></center></td>";
            }
          }
        }
        salida += "</tr></table>";
        salida += "<table width='100%' align='center' border='0' id='a-table1'>";
        $.each(registros.rows, function (index, value)
        {
          if ((tipo == "1") || (tipo == "2") || (tipo == "3") || (tipo == "4") || (tipo == "5") || (tipo == "6"))
          {
            var var1 = index;
            var var2 = value.conse;
            var var3 = value.codigo;
            var var4 = '\"'+var3+'\"';
            var var5 = var2+","+var3+","+var1;
            salida += "<tr><td width='5%' height='35' id='l1_"+var1+"'><center><input type='checkbox' name='seleccionados[]' id='chk_"+var1+"' value='"+var5+"' onclick='trae_marca("+var1+","+var2+","+var4+");'></center></td>";           
            salida += "<td width='10%' height='35' id='l2_"+var1+"'>"+value.codigo+"</td>";
            salida += "<td width='30%' height='35' id='l3_"+var1+"'>"+value.descripcion+"<input type='hidden' name='res_"+var1+"' id='res_"+var1+"' value='"+value.responsable+"' class='form-control' readonly='readonly'><input type='hidden' name='doc_"+var1+"' id='doc_"+var1+"' value='"+value.documento+"' class='form-control' readonly='readonly'><input type='hidden' name='fec_"+var1+"' id='fec_"+var1+"' value='"+value.fecha+"' class='form-control' readonly='readonly'></td>";
            salida += "<td width='10%' height='35' id='l4_"+var1+"' align='right'>"+value.valor+"</td>";
            if ((tipo == "1") || (tipo == "5"))
            {
              salida += "<td width='15%' height='35' id='l5_"+var1+"'><center>"+value.serial+"</center></td>";
            }
            else
            {
              salida += "<td width='15%' height='35' id='l5_"+var1+"'><center>"+value.unidad+"</center></td>";
            }
            // Asignacion -1
            if ((tipo == "1") || (tipo == "5"))
            {
              salida += "<td width='10%' height='35' id='l6_"+var1+"' class='espacio2'><input type='text' name='com_"+var1+"' id='com_"+var1+"' value='"+value.compania+"' class='form-control' maxlength='25' ";
              if (tipo == "5")
              {
                salida += " onfocus='blur();' readonly='readonly' style='border-style: none; background: transparent; color: #000;'";
              }
              salida += " autocomplete='off'></td>";
            }
            else
            {
              if ((tipo == "2") && (tipo1 == "1"))
              {
                salida += "<td width='10%' height='35' id='l6_"+var1+"'><center>"+value.serial+"</center></td>";
              }
              else
              {
                salida += "<td width='10%' height='35' id='l6_"+var1+"'><center>"+value.compania+"</center></td>";
              }
            }
            // Salida de Bienes - 2 && Alta del Bien - 1
            if ((tipo == "2") && (tipo1 == "1"))
            {
              salida += "<td width='20%' height='35' id='l6_"+var1+"' class='espacio2'><input type='text' name='cod_"+var1+"' id='cod_"+var1+"' class='form-control' maxlength='25' autocomplete='off'></td>";
            }
            // Asignacion -1
            if ((tipo == "1") || (tipo == "5"))
            {
              salida += "<td width='20%' height='35' id='l7_"+var1+"' class='espacio2'><select name='est_"+var1+"' id='est_"+var1+"' class='form-control select2' ";
              if (tipo == "5")
              {
                salida += " disabled>";
              }
              else
              {
                salida += ">";
              }
              salida += "<option value='1'>BUENO</option><option value='2'>REGULAR</option><option value='3'>DAÑADO</option><option value='4'>CONSUMIDO</option></select></td></tr>";
            }
          }
        });
        salida += "</table>";
        $("#datos").append(salida);
        $("#tipo").prop("disabled",true);
        $("#tipo1").prop("disabled",true);
        $("#unidades1").prop("disabled",true);
        $("#aceptar").hide();
      }
      else
      {
        var detalle = "<center><h3>No se encontraron Bienes para este Tipo de Movimiento</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function trae_marca(valor, valor1, valor2)
{
  var valor, valor1, valor2, valor3;
  valor3 = par_impar(valor);
  if ($("#chk_"+valor).is(":checked"))
  {
    $("#l1_"+valor).css("background-color","#FFFF00");
    $("#l2_"+valor).css("background-color","#FFFF00");
  }
  else
  {
    if (valor3 == "1")
    {
      $("#l1_"+valor).css("background-color","#FFFFFF");
      $("#l2_"+valor).css("background-color","#FFFFFF");
    }
    else
    {
      $("#l1_"+valor).css("background-color","#CECECE");
      $("#l2_"+valor).css("background-color","#CECECE");
    }
  }
  var tipo = $("#tipo").val();
  if (tipo == "5")
  {
    var nom_respon = $("#res_"+valor).val();
    var doc_respon = $("#doc_"+valor).val();
    var fec_respon = $("#fec_"+valor).val();
    $("#responsable").val(nom_respon);
    $("#documento").val(doc_respon);
    $("#fecha1").val(fec_respon);    
  }
  else
  {
    $("#res_"+valor).val('');
    $("#doc_"+valor).val('');
    $("#fec_"+valor).val('');
  }
  contador();
}
function contador()
{
  var seleccionadosarray = [];
  $("input[name='seleccionados[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        var paso = $(this).val();
        var var_ocu = paso.split(',');
        var paso1 = var_ocu[0];
        var paso2 = var_ocu[1];
        seleccionadosarray.push(paso1);
      }
    }
  );
  var valida = seleccionadosarray.length;
  if (valida == "0")
  {
    detalle = "<center><h3>Debe seleccionar mínimo un Bien</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#datos1").hide();
    $("#datos2").hide();
    $("#datos3").hide();
    $("#datos4").hide();
    $("#datos5").hide();
    $("#datos6").hide();
  }
  else
  {
    var tipo = $("#tipo").val();
    var tipo1 = $("#tipo1").val();
    if (tipo == "1")
    {
      $("#datos1").show();
      $("#datos2").hide();
      $("#datos3").hide();
      $("#datos4").hide();
      $("#datos5").hide();
      $("#datos6").hide();
      $("#datos7").hide();
    }
    else
    {
      if (tipo == "2")
      {
        $("#datos1").hide();
        if (tipo == "2")
        {
          if (tipo1 == "1")
          {
            $("#datos2").show();
            $("#datos3").hide();
            $("#datos4").hide();
            $("#datos5").hide();
            $("#datos6").hide();
            $("#datos7").hide();
          }
          else
          {
            $("#datos2").hide();
            $("#datos3").show();
            $("#datos4").hide();
            $("#datos5").hide();
            $("#datos6").hide();
            $("#datos7").hide();
          }
        }
      }
      else
      {
        if (tipo == "3")
        {
          $("#datos1").hide();
          $("#datos2").hide();
          $("#datos3").hide();
          $("#datos4").show();
          $("#datos5").hide();
          $("#datos6").hide();
          $("#datos7").hide();
        }
        else
        {
          if (tipo == "4")
          {
            $("#datos1").hide();
            $("#datos2").hide();
            $("#datos3").hide();
            $("#datos4").hide();
            $("#datos5").show();
            $("#datos6").hide();
            $("#datos7").hide();
          }
          else
          {
            if (tipo == "5")
            {
              $("#datos1").show();
              $("#datos2").hide();
              $("#datos3").hide();
              $("#datos4").hide();
              $("#datos5").hide();
              $("#datos6").show();
              $("#datos7").hide();
            }
            else
            {
              if (tipo == "6")
              {
                $("#datos1").hide();
                $("#datos2").hide();
                $("#datos3").hide();
                $("#datos4").hide();
                $("#datos5").hide();
                $("#datos6").hide();
                $("#datos7").show();
                var sigla = $("#unidades1").val();
                if (sigla == "999")
                {
                  $("#lnk1").hide();
                }
              }
              else
              {
                $("#datos1").hide();
                $("#datos2").hide();
                $("#datos3").hide();
                $("#datos4").hide();
                $("#datos5").hide();
                $("#datos6").hide();
                $("#datos7").hide();
              }
            }
          }
        }
      }
    }
    if (tipo == "5")
    {
      $("#responsable").prop("disabled",true);
      $("#documento").prop("disabled",true);
      $("#fecha1").prop("disabled",true);
      $("#aceptar1").hide();
    }
    else
    {
      $("#responsable").prop("disabled",false);
      $("#documento").prop("disabled",false);
      $("#fecha1").prop("disabled",false);
      $("#aceptar1").show();
    }
  }
}
function validacion()
{
  var salida = true, detalle = '';
  var tipo = $("#tipo").val();
  var tipo1 = $("#tipo1").val();
  if (tipo == "1")
  {
    var v_companias = 0;
    var v_companias1 = 0;
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
          var valor = $("#com_"+paso3).val().trim().length;
          if (valor == '0')
          {
            v_companias ++;
          }
          else
          {
            if (valor >= 4)
            {
            }
            else
            {
              v_companias1 ++;
            }
          }
        }
      }
    );
    if (v_companias > 0)
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar "+v_companias+" Compañía(s)</h3></center>";
    }
    if (v_companias1 > 0)
    {
      salida = false;
      detalle += "<center><h3>Debe verificar la Longitud de "+v_companias1+" Compañía(s)</h3></center>";
    }
    var valor = $("#responsable").val();
    valor = valor.trim().length;
    if (valor == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar un Responsable</h3></center>";
    }
    var valor1 = $("#documento").val();
    valor1 = valor1.trim().length;
    if (valor1 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar un Número de Documento</h3></center>";
    }
    var valor2 = $("#fecha1").val();
    valor2 = valor2.trim().length;
    if (valor2 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar la Fecha de Documento</h3></center>";
    }
  }
  if (tipo == "2")
  {
    if (tipo1 == "1")
    {
      var v_codigos = 0;
      var v_codigos1 = 0;
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
            var valor = $("#cod_"+paso3).val().trim().length;
            if (valor == '0')
            {
              v_codigos ++;
            }
            else
            {
              if (valor == '25')
              {
              }
              else
              {
                v_codigos1 ++;
              }
            }
          }
        }
      );
      if (v_codigos > 0)
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar "+v_codigos+" Código(s) SAP</h3></center>";
      }
      if (v_codigos1 > 0)
      {
        salida = false;
        detalle += "<center><h3>Debe verificar la Longitud de "+v_codigos1+" Código(s) SAP</h3></center>";
      }
      var valor = $("#numero").val();
      valor = valor.trim().length;
      if (valor == "0")
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar el Número del Acta de Alta SAP</h3></center>";
      }
      var valor1 = $("#fecha2").val();
      valor1 = valor1.trim().length;
      if (valor1 == "0")
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar la Fecha del Acta de Alta SAP</h3></center>";
      }
    }
    if (tipo1 == "2")
    {
      var valor = $("#fecha3").val();
      valor = valor.trim().length;
      if (valor == "0")
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar la Fecha del Siniestro</h3></center>";
      }
      var valor1 = $("#numero1").val();
      valor1 = valor1.trim().length;
      if (valor1 == "0")
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar el Número del Informe</h3></center>";
      }
      var valor2 = $("#fecha4").val();
      valor2 = valor2.trim().length;
      if (valor2 == "0")
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar la Fecha del Informe</h3></center>";
      }
      var valor3 = $("#numero2").val();
      valor3 = valor3.trim().length;
      if (valor3 == "0")
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar el Número del Acto Administrativo</h3></center>";
      }
      var valor4 = $("#fecha5").val();
      valor4 = valor4.trim().length;
      if (valor4 == "0")
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar la Fecha del Acto Administrativo</h3></center>";
      }
      var valor5 = $("#observaciones").val();
      valor5 = valor5.trim().length;
      if (valor5 == "0")
      {
        salida = false;
        detalle += "<center><h3>Debe ingresar las Observaciones</h3></center>";
      }
    }
  }
  if (tipo == "3")
  {
    var valor = $("#numero3").val();
    valor = valor.trim().length;
    if (valor == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar el Número del Acto Administrativo</h3></center>";
    }
    var valor1 = $("#fecha6").val();
    valor1 = valor1.trim().length;
    if (valor1 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar la Fecha del Acto Administrativo</h3></center>";
    }
    var valor2 = $("#numero4").val();
    valor2 = valor2.trim().length;
    if (valor2 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar la Orden Semanal</h3></center>";
    }
    var valor3 = $("#fecha7").val();
    valor3 = valor3.trim().length;
    if (valor3 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar la Fecha de la Orden Semanal</h3></center>";
    }
    var valor4 = $("#observaciones1").val();
    valor4 = valor4.trim().length;
    if (valor4 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar las Observaciones</h3></center>";
    }
  }
  if (tipo == "4")
  {
    var valor = $("#numero5").val();
    valor = valor.trim().length;
    if (valor == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar el Número del Acto Administrativo</h3></center>";
    }
    var valor1 = $("#fecha8").val();
    valor1 = valor1.trim().length;
    if (valor1 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar la Fecha del Acto Administrativo</h3></center>";
    }
    var valor2 = $("#unidad").val();
    if (valor2 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe seleccionar la Unidad a Traspasar el Bien</h3></center>";
    }
  }
  if (tipo == "5")
  {
    var valor = $("#funcionario").val();
    valor = valor.trim().length;
    if (valor == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar un Usuario Final del Bien</h3></center>";
    }
    var valor1 = $("#documento1").val();
    valor1 = valor1.trim().length;
    if (valor1 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar un Número de Documento</h3></center>";
    }
    var valor2 = $("#fecha9").val();
    valor2 = valor2.trim().length;
    if (valor2 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar la Fecha de Documento</h3></center>";
    }
  }
  if (tipo == "6")
  {
    var valor = $("#numero6").val();
    valor = valor.trim().length;
    if (valor == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar el Número del Acta</h3></center>";
    }
    var valor1 = $("#fecha12").val();
    valor1 = valor1.trim().length;
    if (valor1 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar la Fecha del Acta</h3></center>";
    }
    var valor2 = $("#observaciones3").val();
    valor2 = valor2.trim().length;
    if (valor2 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar las Observaciones</h3></center>";
    }
  }
  var valor = $("#elaboro").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar Persona que Elaboro el Movimiento</h3></center>";
  }
  var bienarray = [];
  $("input[name='seleccionados[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        bienarray.push($(this).val());
      }
    }
  );
  var num_bie = bienarray.length;
  if (num_bie == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar mínimo un Bien</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    valida_archivos();
  }
}
function valida_archivos()
{
  var alea = $("#alea").val();
  var tipo = $("#tipo").val();
  var sigla = $("#unidades1 option:selected").html();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_archivos.php",
    data:
    {
      alea: alea,
      tipo: tipo,
      sigla: sigla
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
        var detalle = "<center><h3>Debe Anexar Acta</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
      else
      {
        nuevo();
      }
    }
  });
}
function nuevo()
{
  var tipo = $("#tipo").val();
  var tipo1 = $("#tipo1").val();
  var seleccionadosarray = [];
  $("#v_paso1").val('');
  $("#v_paso2").val('');
  $("#v_paso3").val('');
  if (tipo == "1")
  {
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
          seleccionadosarray.push(paso2);
          var valor = $("#com_"+paso3).val();
          var valor1 = $("#est_"+paso3).val();
          document.getElementById('v_paso1').value = document.getElementById('v_paso1').value+valor+"|";
          document.getElementById('v_paso2').value = document.getElementById('v_paso2').value+paso2+"|";
          document.getElementById('v_paso3').value = document.getElementById('v_paso3').value+valor1+"|";
        }
      }
    );
  }
  if (tipo == "2")
  {
    if (tipo1 == "1")
    {
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
            seleccionadosarray.push(paso2);
            var valor = $("#cod_"+paso3).val();
            document.getElementById('v_paso1').value = document.getElementById('v_paso1').value+valor+"|";
            document.getElementById('v_paso2').value = document.getElementById('v_paso2').value+paso2+"|";
          }
        }
      );
    }
    if (tipo1 == "2")
    {
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
            seleccionadosarray.push(paso2);
            document.getElementById('v_paso1').value = document.getElementById('v_paso1').value+paso1+"|";
            document.getElementById('v_paso2').value = document.getElementById('v_paso2').value+paso2+"|";
          }
        }
      );
    }
  }
  if ((tipo == "3") || (tipo == "4") || (tipo == "5") || (tipo == "6"))
  {
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
          seleccionadosarray.push(paso2);
          document.getElementById('v_paso1').value = document.getElementById('v_paso1').value+paso1+"|";
          document.getElementById('v_paso2').value = document.getElementById('v_paso2').value+paso2+"|";
        }
      }
    );
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "bien_grab2.php",
    data:
    {
      tipo: tipo,
      tipo1: tipo1,
      unidad1: $("#unidades1").val(),
      conses: seleccionadosarray,
      responsable: $("#responsable").val(),
      documento: $("#documento").val(),
      fecha: $("#fecha1").val(),
      alta: $("#numero").val(),
      fecha1: $("#fecha2").val(),
      almacen: $("#almacen").val(),
      fecha2: $("#fecha3").val(),
      siniestro: $("#tipo2").val(),
      informe: $("#numero1").val(),
      fecha3: $("#fecha4").val(),
      acto: $("#numero2").val(),
      fecha4: $("#fecha5").val(),
      observaciones: $("#observaciones").val(),
      acto1: $("#numero3").val(),
      fecha5: $("#fecha6").val(),
      orden: $("#numero4").val(),
      fecha6: $("#fecha7").val(),
      observaciones1: $("#observaciones1").val(),
      acto2: $("#numero5").val(),
      fecha7: $("#fecha8").val(),
      unidad: $("#unidad").val(),
      compania: $("#compania").val(),
      ordop: $("#ordop").val(),
      mision: $("#mision").val(),
      observaciones2: $("#observaciones2").val(),
      funcionario: $("#funcionario").val(),
      documento1: $("#documento1").val(),
      fecha8: $("#fecha9").val(),
      acta: $("#numero6").val(),
      fecha9: $("#fecha12").val(),
      observaciones3: $("#observaciones3").val(),
      elaboro: $("#elaboro").val(),
      paso1: $("#v_paso1").val(),
      paso2: $("#v_paso2").val(),
      paso3: $("#v_paso3").val(),
      alea: $("#alea").val()
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
      if (valida == "1")
      {
        if (tipo == "1")
        {
          $("#aceptar1").hide();
          $("#responsable").prop("disabled",true);
          $("#documento").prop("disabled",true);
          $("#fecha1").prop("disabled",true);
          $("#lnk2").hide();
          for (i=0;i<document.formu.elements.length;i++)
          {
            saux = document.formu.elements[i].name;
            if (saux.indexOf('com_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            if (saux.indexOf('est_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
        }
        if (tipo == "2")
        {
          if (tipo1 == "1")
          {
            $("#aceptar2").hide();
            $("#numero").prop("disabled",true);
            $("#fecha2").prop("disabled",true);
            $("#almacen").prop("disabled",true);
            for (i=0;i<document.formu.elements.length;i++)
            {
              saux = document.formu.elements[i].name;
              if (saux.indexOf('cod_')!=-1)
              {
                document.getElementById(saux).setAttribute("disabled","disabled");
              }
            }
            $("#lnk5").hide();
          }
          else
          {
            $("#aceptar3").hide();
            $("#fecha3").prop("disabled",true);
            $("#tipo2").prop("disabled",true);
            $("#numero1").prop("disabled",true);
            $("#fecha4").prop("disabled",true);
            $("#numero2").prop("disabled",true);
            $("#fecha5").prop("disabled",true);
            $("#observaciones").prop("disabled",true);
            $("#lnk6").hide();
          }
        }
        if (tipo == "3")
        {
          $("#aceptar4").hide();
          $("#numero3").prop("disabled",true);
          $("#fecha6").prop("disabled",true);
          $("#numero4").prop("disabled",true);
          $("#fecha7").prop("disabled",true);
          $("#observaciones1").prop("disabled",true);
          $("#lnk4").hide();
        }
        if (tipo == "4")
        {
          $("#aceptar5").hide();
          $("#numero5").prop("disabled",true);
          $("#fecha8").prop("disabled",true);
          $("#unidad").prop("disabled",true);
          $("#compania").prop("disabled",true);
          $("#ordop").prop("disabled",true);
          $("#mision").prop("disabled",true);
          $("#observaciones2").prop("disabled",true);
          $("#lnk3").hide();
        }
        if (tipo == "5")
        {
          $("#aceptar6").hide();
          $("#funcionario").prop("disabled",true);
          $("#documento1").prop("disabled",true);
          $("#fecha9").prop("disabled",true);
          $("#lnk2").hide();
        }
        if (tipo == "6")
        {
          $("#aceptar7").hide();
          $("#numero6").prop("disabled",true);
          $("#fecha12").prop("disabled",true);
          $("#observaciones3").prop("disabled",true);
          $("#lnk1").hide();
        }
        $("#elaboro").prop("disabled",true);
        $("input[name='seleccionados[]']").each(
          function ()
          {
            $(this).prop("disabled",true);
          }
        );
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
function consultar1()
{
  var tipo = $("#tipo3").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "movi_consu.php",
    data:
    {
      tipo: tipo,
      fecha1: $("#fecha10").val(),
      fecha2: $("#fecha11").val(),
      codigo: $("#codigo").val()
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
      var valida,valida1,valida2;
      var salida1 = "";
      var salida2 = "";
      var salida3 = "";
      var v_var1 = "";
      listaplanes = [];
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
      if ((tipo == "1") || (tipo == "4"))
      {
        salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='10%'><b>Código</b></td><td height='35' width='30%'><b>Descripci&oacute;n</b></td><td height='35' width='10%'><b>Fecha Compra</b></td><td height='35' width='10%'><b>Compa&ntilde;&iacute;a</b></td><td height='35' width='8%'><b>Unidad</b></td><td height='35' width='14%'><b>Serial</b></td><td height='35' width='10%'><b>Valor</b></td><td height='35' width='8%'><b>Estado</b></td></tr></table>";
      }
      if (tipo == "3")
      {
        salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='10%'><b>No.</b></td><td height='35' width='10%'><b>Fecha</b></td><td height='35' width='20%'><b>Códigos</b></td><td height='35' width='25%'><b>Tipo de Movimiento</b></td><td height='35' width='15%'><b>Tipo de Salida</b></td><td height='35' width='10%'><b>Unidad</b></td><td height='35' width='20%'><b>Año</b></td><td height='35' width='5%'>&nbsp;</td></tr></table>";
      }
      if ((tipo == "1") || (tipo == "3") || (tipo == "4"))
      {
        salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
        $.each(registros.rows, function (index, value)
        {
          if ((tipo == "1") || (tipo == "4"))
          {
            salida2 += "<tr><td height='35' width='10%'>"+value.codigo+"</td>";
            salida2 += "<td height='35' width='30%'>"+value.descripcion+"</td>";
            salida2 += "<td height='35' width='10%'>"+value.fec_com+"</td>";
            salida2 += "<td height='35' width='10%'>"+value.compania+"</td>";
            salida2 += "<td height='35' width='8%'>"+value.unidad1+"</td>";
            salida2 += "<td height='35' width='14%'><center>"+value.serial+"</center></td>";
            salida2 += "<td height='35' width='10%' align='right'>"+value.valor+"</td>";
            salida2 += "<td height='35' width='8%'><center>"+value.estado1+"</center></td></tr>";
            v_var1 += value.codigo+"|"+value.n_clase+"|"+value.nombre+"|"+value.descripcion+"|"+value.unidad1+"|"+value.marca+"|"+value.color+"|"+value.modelo+"|"+value.serial+"|"+value.valor1+"|"+value.fec_com+"|"+value.soa_num+"|"+value.soa_ase+"|"+value.soa_fe1+"|"+value.soa_fe2+"|"+value.seg_cla+"|"+value.seg_val+"|"+value.seg_num+"|"+value.seg_ase+"|"+value.seg_fe1+"|"+value.seg_fe2+"|"+value.funcionario+"|"+value.ordop+"|"+value.mision+"|"+value.ordop1+"|"+value.mision1+"|"+value.numero+"|"+value.relacion+"|"+value.compania+"|"+value.estado1+"|"+value.egreso+"|"+value.unidad+"|"+value.unidad1+"|"+value.devolutivo+"|"+value.nom_respon+"|"+value.doc_respon+"|"+value.fec_respon+"|"+value.sap+"|"+value.alta+"|"+value.fechaa+"|"+value.almacen+"|"+value.fechas+"|"+value.siniestro+"|"+value.informe+"|"+value.fechai+"|"+value.acto+"|"+value.fechac+"|"+value.observa+"|"+value.acto1+"|"+value.fechac1+"|"+value.informe1+"|"+value.fechai1+"|"+value.observa1+"|"+value.nom_usua+"|"+value.doc_usua+"|"+value.fec_usua+"|"+value.fec_rela+"|"+value.acto2+"|"+value.fechat+"|"+value.observa2+"|"+value.revistas+"|#";
          }
          if (tipo == "3")
          {
            valida2 = '\"'+value.conse+'\",\"'+value.tipo2+'\",\"'+value.tipo3+'\",\"'+value.ano+'\",\"'+value.n_unidad+'\",\"'+value.alea+'\"';
            salida2 += "<tr><td height='35' width='10%'>"+value.conse+"</td>";
            salida2 += "<td height='35' width='10%'>"+value.fecha+"</td>";
            salida2 += "<td height='35' width='20%'>"+value.codigos+"</td>";
            salida2 += "<td height='35' width='25%'>"+value.tipo+"</td>";
            salida2 += "<td height='35' width='15%'>"+value.tipo1+"</td>";
            salida2 += "<td height='35' width='10%'>"+value.n_unidad+"</td>";
            salida2 += "<td height='35' width='5%'>"+value.ano+"</td>";
            if (value.archivo > 0)
            {
              salida2 += "<td height='35' width='5%'><center><a href='#' onclick='link1("+valida2+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td></td>";
            }
            else
            {
              salida2 += "<td height='35' width='5%'>&nbsp;</td></td>";
            }
            listaplanes.push(value.interno);
          }
        });
        salida2 += "</table>";
        $("#tabla3").append(salida1);
        $("#paso").val(v_var1);
        $("#resultados5").append(salida2);
        if ((tipo == "1") || (tipo == "4"))
        {
          if (valida1 == "0")
          {
          }
          else
          {
            salida3 += "<br><center><a href='#' id='excel' onclick='excel(); return false;'><img src='dist/img/excel.png' title='Exportar Consulta a Excel - SAP'></a></center><br>";
            $("#resultados5").append(salida3);
          }
        }
      }
      else
      {
        var fecha1 = $("#fecha10").val();
        var fecha2 = $("#fecha11").val();
        var unidades = $("#v_paso6").val();
        var link = "fecha1="+fecha1+"&fecha2="+fecha2+"&v_uni="+unidades;
        var url = "./fpdf/000.php?"+link;
        var salida = "<embed src='"+url+"' width='100%' height='500'>";
        $("#resultados5").append(salida);
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
function link1(valor, valor1, valor2, valor3, valor4, valor5)
{
  var valor, valor1, valor2, valor3, valor4, valor5;
  $("#movi_conse").val(valor);
  $("#movi_tipo").val(valor1);
  $("#movi_tipo1").val(valor2);
  $("#movi_ano").val(valor3);
  $("#movi_unidad").val(valor4);
  $("#movi_alea").val(valor5);
  formu1.submit();
}
function subir()
{
  var tipo = $("#tipo").val();
  var sigla = $("#unidades1 option:selected").html();
  var alea = $("#alea").val();
  var url = "<a href='./subir12.php?alea="+alea+"&sigla="+sigla+"&tipo="+tipo+"' name='link1' id='link1' class='pantalla-modal'>Link</a>";
  $("#link").hide();
  $("#link").html('');
  $("#link").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#link1").click();
}
function par_impar(valor)
{
  if(valor % 2 == 0)
  {
    return "1";
  }
  else
  {
    return "0";
  }
}
function excel()
{
  formu_excel.submit();
}
</script>
</body>
</html>
<?php
}
// 25/09/2024 - Ajuste inclusion de barra de consulta
// 24/10/2024 - Ajuste envio de unidades a centralizadora
?>