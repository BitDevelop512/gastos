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
  $fecha = date('Y/m/d');
  $ano = date('Y');
  $mes = date('m');
  $query = "SELECT unidad, dependencia, tipo FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $query);
  $n_unidad = odbc_result($cur,1);
  $n_dependencia = odbc_result($cur,2);
  $n_tipo = odbc_result($cur,3);
  if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
  {
    if (($nun_usuario == "2") or ($nun_usuario == "3"))
    {
      $pregunta = "SELECT dependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND unic='1'";
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
  // Se consultan registros disponibles para actas
  if (strpos($comite, $uni_usuario) !== false)
  {
    $estado1 = "C";
    $usuario1 = "SPR_DIADI";
  }
  else
  {
    $estado1 = "D";
    $usuario1 = $usu_usuario;
  }
  $consu = "SELECT conse, ano FROM cx_reg_rec WHERE usuario3 IN ('$usuario1','$usu_usuario') AND estado IN ('C','D') AND unidad IN ($numero) AND NOT EXISTS(SELECT * FROM cx_act_reg WHERE cx_act_reg.registro=cx_reg_rec.conse AND cx_act_reg.ano1=cx_reg_rec.ano) ORDER BY conse";
  $cur = odbc_exec($conexion, $consu);
  $total = odbc_num_rows($cur);
  if ($total > 0)
  {
    $numero = "";
    while($i<$row=odbc_fetch_array($cur))
    {
      $numero .= odbc_result($cur,1)." - ".odbc_result($cur,2).",";
    }
  }
  else
  {
    $numero = $total;
  }
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
  <link rel="stylesheet" id="theme" href="js8/selectric.css">
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
          <h3>Acta Comit&eacute; Regional Recompensas</h3>
          <div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Registro</font></label>
                  <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="usu" id="usu" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="sigla" id="sigla" class="form-control" value="<?php echo $sig_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="numero" id="numero" class="form-control" value="<?php echo $numero; ?>" readonly="readonly">
                  <input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly">
                  <input type="hidden" name="mes" id="mes" class="form-control" value="<?php echo $mes; ?>" readonly="readonly">
                  <input type="hidden" name="firmas" id="firmas" class="form-control" value="" readonly="readonly">
                  <input type="hidden" name="neutralizados" id="neutralizados" class="form-control" value="" readonly="readonly">
                  <input type="hidden" name="material" id="material" class="form-control" value="" readonly="readonly">
                  <input type="hidden" name="actu" id="actu" class="form-control" value="0" readonly="readonly">
                  <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_ciudad" id="v_ciudad" class="form-control" value="<?php echo $ciu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_click" id="v_click" class="form-control" value="0" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_material" id="v_material" class="form-control" value="" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_niveles" id="v_niveles" class="form-control" value="" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_paso1" id="v_paso1" class="form-control" value="" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_paso2" id="v_paso2" class="form-control" value="" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_paso3" id="v_paso3" class="form-control" value="" readonly="readonly" tabindex="0">
                  <input type="hidden" name="alea" id="alea" class="form-control" value="" readonly="readonly">
                  <select name="solicitud" id="solicitud" class="form-control select2" tabindex="1"></select>
                  <div id="vinculo"></div>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Valor Solicitado</font></label>
                  <input type="text" name="valor" id="valor" class="form-control numero" value="0.00" readonly="readonly" tabindex="2">
                  <input type="hidden" name="valor1" id="valor1" class="form-control numero" value="0" readonly="readonly" tabindex="3">
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Directiva Ministerial Permanente</font></label>
                  <select name="directiva" id="directiva" class="form-control select2" tabindex="4">
                    <option value="1">No. 01 del 17 de Febrero de 2009</option>
                    <option value="2">No. 21 del 5 de Julio de 2011</option>
                    <option value="3">No. 16 del 25 de Mayo de 2012</option>
                    <option value="4">No. 02 del 16 de Enero de 2019</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Salario</font></label>
                  <input type="text" name="salario" id="salario" class="form-control numero" value="0.00" readonly="readonly" tabindex="5">
                  <input type="hidden" name="salario1" id="salario1" class="form-control numero" value="0" readonly="readonly" tabindex="6">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">No. Acta</font></label>
                  <input type="text" name="numero1" id="numero1" class="form-control numero" value="0" maxlength="25" tabindex="7" autocomplete="off">
                </div>
              </div>
              <br>
              <div id="datos">
                <div class="row">
                  <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                    <label><font face="Verdana" size="2">Intervienen</font></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table width="100%" align="center" border="0">
                      <tr>
                        <td width="45%">
                          <b>Grado y Nombre Completo</b>
                        </td>
                         <td width="45%">
                          <b>Cargo</b>
                        </td>
                        <td width="10%">
                          &nbsp;
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div id="add_form">
                      <table width="100%" align="center" border="0">
                        <tr>
                          <td colspan="2"></td>
                        </tr>
                      </table>
                    </div>
                    <div class="espacio1"></div>
                    <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0" tabindex="9"></a>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">No. Acta Manual</font></label>
                    <input type="text" name="acta" id="acta" class="form-control numero" onkeypress="return check1(event);" value="" maxlength="30" tabindex="10" autocomplete="off">
                  </div>
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Constancia Unid. / Dep. Manej&oacute; Fuente</font></label>
                    <input type="text" name="constancia" id="constancia" onkeypress="return check1(event);" class="form-control numero" value="" maxlength="30" tabindex="11" autocomplete="off">
                  </div>
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Folio(s) Acta(s) Pago Previo</font></label>
                    <input type="text" name="folio" id="folio" onkeypress="return check2(event);" class="form-control numero" value="0" maxlength="30" tabindex="12" autocomplete="off">
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <table width="100%" align="center" border="0">
                      <tr>
                        <td width="50%">
                          <div id="lista"></div>
                        </td>
                        <td width="50%">
                          <div id="anexo"></div>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label><font face="Verdana" size="2">Sintesis de la Informaci&oacute;n</font></label>
                    <textarea name="sintesis" id="sintesis" class="form-control" rows="5" onblur="val_caracteres('sintesis');" tabindex="13"></textarea>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-10 col-sm-10 col-md-10 col-xs-10">
                    <label><font face="Verdana" size="2">Valoraci&oacute;n Informaci&oacute;n Suministrada</font></label>
                    <textarea name="informacion" id="informacion" class="form-control" rows="5" onblur="val_caracteres('informacion');" tabindex="14"></textarea>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Valoraci&oacute;n</font></label>
                    <input type="text" name="total7" id="total7"  class="form-control numero" value="0.00" onkeyup="paso_valor4(); suma2();" tabindex="15">
                    <input type="hidden" name="total8" id="total8" class="form-control numero" value="0" readonly="readonly" tabindex="16">
                  </div>
                </div>
                <br>
                <div id="l_neutraliza">
                  <div class="row">
                    <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                      <label><font face="Verdana" size="2">Neutralizados</font></label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                      <div id="add_form1">
                        <table width="100%" align="center" border="0">
                          <tr>
                            <td colspan="6"></td>
                          </tr>
                        </table>
                      </div>
                      <div class="espacio1"></div>
                      <a href="#" name="add_field1" id="add_field1"><img src="imagenes/boton1.jpg" border="0" tabindex="17"></a>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6"></div>
                    <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                      <label><div class="centrado"><font face="Verdana" size="2">Total Neutralizados</font></div></label>
                    </div>
                    <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                      <input type="text" name="total1" id="total1"  class="form-control numero" value="0.00" readonly="readonly" tabindex="18">
                      <input type="hidden" name="total2" id="total2" class="form-control numero" value="0" readonly="readonly" tabindex="19">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                      <label><font face="Verdana" size="2">Sustentaci&oacute;n de la Valoraci&oacute;n Neutralizados</font></label>
                      <textarea name="valoracion" id="valoracion" class="form-control" rows="5" onblur="val_caracteres('valoracion');" tabindex="20"></textarea>
                    </div>
                  </div>
                  <hr>
                </div>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label><font face="Verdana" size="2">Material</font></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div id="add_form2">
                      <table width="100%" align="center" border="0">
                        <tr>
                          <td colspan="6"></td>
                        </tr>
                      </table>
                    </div>
                    <div class="espacio1"></div>
                    <a href="#" name="add_field2" id="add_field2"><img src="imagenes/boton1.jpg" border="0" tabindex="21"></a>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <center><label><div class="centrado"><font face="Verdana" size="2">CANT. x V/R DIRECTIVA</font></div></label></center>
                    <input type="text" name="cal_mat" id="cal_mat"  class="form-control numero" value="0.00" readonly="readonly" tabindex="22">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <center><label><div class="centrado"><font face="Verdana" size="2">V/R M&Aacute;XIMO</font></div></label></center>
                    <input type="text" name="cal_mat1" id="cal_mat1"  class="form-control numero" value="0.00" readonly="readonly" tabindex="23">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <center><label><div class="centrado"><font face="Verdana" size="2">DIFERENCIA</font></div></label></center>
                    <input type="text" name="cal_mat2" id="cal_mat2"  class="form-control numero" value="0.00" readonly="readonly" tabindex="24">
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <center><label><div class="centrado"><font face="Verdana" size="2">%</font></div></label></center>
                    <input type="text" name="cal_mat3" id="cal_mat3"  class="form-control numero" value="0.00" readonly="readonly" tabindex="25">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6"></div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><div class="centrado"><font face="Verdana" size="2">Total Material</font></div></label>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="total3" id="total3"  class="form-control numero" value="0.00" readonly="readonly" tabindex="26"><input type="hidden" name="total4" id="total4" class="form-control numero" value="0" readonly="readonly" tabindex="27">
                  </div>
                </div>
                <hr>
                <hr>
                <div class="row">
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6"></div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><div class="centrado"><font face="Verdana" size="2">Total Acta</font></div></label>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <input type="text" name="total5" id="total5"  class="form-control numero" value="0.00" readonly="readonly" tabindex="28"><input type="hidden" name="total6" id="total6" class="form-control numero" value="0" readonly="readonly" tabindex="29">
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label><font face="Verdana" size="2">Impacto del Resultado</font></label>
                    <textarea name="impacto" id="impacto" class="form-control" rows="5" onblur="val_caracteres('impacto');" tabindex="30"></textarea>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label><font face="Verdana" size="2">Concepto de Evaluaci&oacute;n del Comit&eacute; Regional</font></label>
                    <textarea name="concepto" id="concepto" class="form-control" rows="5" onblur="val_caracteres('concepto');" tabindex="31"></textarea>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                    <label><font face="Verdana" size="2">Recomendaciones</font></label>
                    <textarea name="recomendaciones" id="recomendaciones" class="form-control" rows="5" onblur="val_caracteres('recomendaciones');" tabindex="32"></textarea>
                  </div>
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                    <label><font face="Verdana" size="2">Observaciones</font></label>
                    <textarea name="observaciones" id="observaciones" class="form-control" rows="5" onblur="val_caracteres('observaciones');" tabindex="33"></textarea>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                    <label><font face="Verdana" size="2">Elabor&oacute;</font></label>
                    <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="34" autocomplete="off">
                    <div class="espacio1"></div>
                    <input type="text" name="cargo" id="cargo" class="form-control" value="<?php echo $car_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="35" autocomplete="off">
                  </div>
                  <div class="col col-lg-6 col-sm-6 col-md-6 col-xs-6">
                    <label><font face="Verdana" size="2">Revis&oacute;</font></label>
                    <input type="text" name="reviso" id="reviso" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="36" autocomplete="off">
                    <div class="espacio1"></div>
                    <input type="text" name="cargo1" id="cargo1" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="37" autocomplete="off">
                  </div>
                </div>
                <br>
                <center>
                  <input type="button" name="aceptar" id="aceptar" value="Continuar" tabindex="36">
                  <input type="button" name="aceptar2" id="aceptar2" value="Actualizar" tabindex="37">
                  &nbsp;&nbsp;&nbsp;
                  <input type="button" name="aceptar1" id="aceptar1" value="Visualizar" tabindex="38">
                  &nbsp;&nbsp;&nbsp;
                  <input type="button" name="aceptar3" id="aceptar3" value="Cargar Acta Firmada" tabindex="39">
                </center>
              </div>
            </form>
          </div>
          <h3>Consultas</h3>
          <div>
            <div id="load">
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
            <br>
            <center>
              <label for="ajuste">Ajuste de Lineas Firma:</label>
              <input name="ajuste" id="ajuste" class="numero" onkeypress="return check(event);" value="0">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="checkbox" name="chk_hoja" id="chk_hoja" value="0">
              <label><font face="Verdana" size="2">Incluir Hoja en Blanco</font></label>
            </center>
            <form name="formu1" action="ver_regional.php" method="post" target="_blank">
              <input type="hidden" name="acta_conse" id="acta_conse" readonly="readonly">
              <input type="hidden" name="acta_ano" id="acta_ano" readonly="readonly">
              <input type="hidden" name="acta_ajuste" id="acta_ajuste" readonly="readonly">
              <input type="hidden" name="acta_hoja" id="acta_hoja" readonly="readonly">
              <input type="hidden" name="acta_sigla" id="acta_sigla" readonly="readonly">
            </form>
          </div>
          <div id="dialogo"></div>
          <div id="dialogo1"></div>
          <div id="dialogo2"></div>
          <div id="dialogo3"></div>
        </div>
      </div>
    </div>
  </section>
</div>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
<script src="js8/jquery.selectric.js"></script>
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
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 210,
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
        validacionData();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 355,
    width: 560,
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
    height: 200,
    width: 520,
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
        enviar();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#solicitud").change(trae_datos);
  $("#aceptar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(link);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(pregunta);
  $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").button();
  $("#aceptar3").click(pregunta1);
  $("#aceptar3").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").hide();
  $("#aceptar1").hide();
  $("#aceptar2").hide();
  $("#aceptar3").hide();
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#numero").focus();
  var MaxInputs       = 99;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      var y = z-1;
      FieldCount++;
      if (z == "1")
      {
        $("#add_form table").append('<tr><td width="45%" class="espacio1"><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="45%" class="espacio2"><input type="text" name="car_'+z+'" id="car_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>');
      }
      else
      {
        $("#add_form table").append('<tr><td width="45%" class="espacio1"><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="45%" class="espacio2"><input type="text" name="car_'+z+'" id="car_'+z+'" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="10%"><div id="men_'+z+'"><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      }
      x_1++;
      if (z == "1")
      {
      }
      else
      {
        $("#men_"+y).hide();
      }
      $("#nom_"+z).focus();
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
  $("#add_field").click();
  // Neutralizados
  var InputsWrapper1   = $("#add_form1 table tr");
  var AddButton1       = $("#add_field1");
  var x_2              = InputsWrapper1.length;
  var FieldCount1      = 1;
  $(AddButton1).click(function (e) {
    var paso = $("#v_paso1").val();
    var a = x_2;
    FieldCount1++;
    if (a == "1")
    {
      $("#add_form1 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>NIVEL</b></center></div><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><center><b>IDENTIDAD</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>CARGO<br>DELINCUENCIAL</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>MONTOS DIRECTIVA<br>(HASTA)</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>VALORACI&Oacute;N</b></center></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>&nbsp;</div></td></tr>');
      $("#add_form1 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><select name="niv_'+a+'" id="niv_'+a+'" class="form-control select2" onchange="calculo('+a+')"></select></div><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><input type="text" name="ide_'+a+'" id="ide_'+a+'" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="250" autocomplete="off"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="org_'+a+'" id="org_'+a+'" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="250" autocomplete="off"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="mon_'+a+'" id="mon_'+a+'" class="form-control numero" value="0.00" readonly="readonly"><input type="hidden" name="mos_'+a+'" id="mos_'+a+'" class="form-control numero" value="0" readonly="readonly"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="val_'+a+'" id="val_'+a+'" class="form-control numero" value="0.00" onkeyup="paso_valor1('+a+'); calculo1('+a+')" autocomplete="off"><input type="hidden" name="vap_'+a+'" id="vap_'+a+'" class="form-control numero" value="0" readonly="readonly"></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><div id="mes_'+a+'"><a href="#" class="removeclass1"><img src="imagenes/boton2.jpg" border="0"></a></div></div></div></td></tr>');
    }
    else
    {
      $("#add_form1 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><select name="niv_'+a+'" id="niv_'+a+'" class="form-control select2" onchange="calculo('+a+')"></select></div><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><input type="text" name="ide_'+a+'" id="ide_'+a+'" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="250" autocomplete="off"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="org_'+a+'" id="org_'+a+'" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="250" autocomplete="off"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="mon_'+a+'" id="mon_'+a+'" class="form-control numero" value="0.00" readonly="readonly"><input type="hidden" name="mos_'+a+'" id="mos_'+a+'" class="form-control numero" value="0" readonly="readonly"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="val_'+a+'" id="val_'+a+'" class="form-control numero" value="0.00" onkeyup="paso_valor1('+a+'); calculo1('+a+')" autocomplete="off"><input type="hidden" name="vap_'+a+'" id="vap_'+a+'" class="form-control numero" value="0" readonly="readonly"></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><div id="mes_'+a+'"><a href="#" class="removeclass1"><img src="imagenes/boton2.jpg" border="0"></a></div></div></div></td></tr>');
    }
    $("#niv_"+a).append(paso);
    $("#val_"+a).maskMoney();
    $("#niv_"+a).focus();
    x_2++;
    return false;
  });
  $("body").on("click",".removeclass1", function(e) {
    $(this).closest('tr').remove();
    return false;
  });
  // Material
  var InputsWrapper2   = $("#add_form2 table tr");
  var AddButton2       = $("#add_field2");
  var x_3              = InputsWrapper2.length;
  var FieldCount2      = 1;
  $(AddButton2).click(function (e) {
    var paso = $("#v_paso2").val();
    var b = x_3;
    FieldCount2++;
    if (b == "1")
    {
      $("#add_form2 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4"><center><b>ELEMENTOS<br>INCAUTADOS</b></center></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><center><b>CANT.</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>V/R SEG&Uacute;N<br>DIRECTIVA<br>(HASTA)</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>ESTADO</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>V/R TOTAL<br>APROBADO</b></center></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">&nbsp;</div></div></td></tr>');
      $("#add_form2 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4"><select name="ele_'+b+'" id="ele_'+b+'" class="form-control cx1" onchange="calculo2('+b+')"></select></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><input type="text" name="can_'+b+'" id="can_'+b+'" class="form-control numero" value="0" onkeypress="return check(event);" onkeyup="calculo5('+b+')" onblur="calculo4('+b+')" maxlength="10" autocomplete="off"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="moe_'+b+'" id="moe_'+b+'" class="form-control numero" value="0.00" readonly="readonly"><input type="hidden" name="mod_'+b+'" id="mod_'+b+'" class="form-control numero" value="0" readonly="readonly"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><select name="est_'+b+'" id="est_'+b+'" class="form-control select2"><option value="N">NUEVO</option><option value="B">BUENO</option><option value="D">DAÑADO</option><option value="N/A">N/A</option></select></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="val1_'+b+'" id="val1_'+b+'" class="form-control numero" value="0.00" onkeyup="paso_valor2('+b+'); calculo3('+b+')" autocomplete="off"><input type="hidden" name="vap1_'+b+'" id="vap1_'+b+'" class="form-control numero" value="0" readonly="readonly"><input type="hidden" name="max_'+b+'" id="max_'+b+'" class="form-control numero" value="0" readonly="readonly"><input type="hidden" name="por_'+b+'" id="por_'+b+'" class="form-control numero" value="0" readonly="readonly"></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><div id="mex_'+b+'"><a href="#" class="removeclass1"><img src="imagenes/boton2.jpg" border="0"></a></div></div></div></td></tr>');
    }
    else
    {
      $("#add_form2 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4"><select name="ele_'+b+'" id="ele_'+b+'" class="form-control cx1" onchange="calculo2('+b+')"></select></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><input type="text" name="can_'+b+'" id="can_'+b+'" class="form-control numero" value="0" onkeypress="return check(event);" onkeyup="calculo5('+b+')" onblur="calculo4('+b+')" maxlength="10" autocomplete="off"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="moe_'+b+'" id="moe_'+b+'" class="form-control numero" value="0.00" readonly="readonly"><input type="hidden" name="mod_'+b+'" id="mod_'+b+'" class="form-control numero" value="0" readonly="readonly"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><select name="est_'+b+'" id="est_'+b+'" class="form-control select2"><option value="N">NUEVO</option><option value="B">BUENO</option><option value="D">DAÑADO</option><option value="N/A">N/A</option></select></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="val1_'+b+'" id="val1_'+b+'" class="form-control numero" value="0.00" onkeyup="paso_valor2('+b+'); calculo3('+b+')" autocomplete="off"><input type="hidden" name="vap1_'+b+'" id="vap1_'+b+'" class="form-control numero" value="0" readonly="readonly"><input type="hidden" name="max_'+b+'" id="max_'+b+'" class="form-control numero" value="0" readonly="readonly"><input type="hidden" name="por_'+b+'" id="por_'+b+'" class="form-control numero" value="0" readonly="readonly"></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><div id="mex_'+b+'"><a href="#" class="removeclass1"><img src="imagenes/boton2.jpg" border="0"></a></div></div></div></td></tr>');
    }
    $("#ele_"+b).append(paso);
    $(".cx1").selectric();
    $("#val1_"+b).maskMoney();
    $("#can_"+b).focus(function(){
      this.select();
    });
    $("#ele_"+b).focus();
    x_3++;
    return false;
  });
  $("body").on("click",".removeclass1", function(e) {
    $(this).closest('tr').remove();
    return false;
  });
  $("#directiva").prop("disabled",true);
  $("#numero1").prop("disabled",true);
  $("#total7").maskMoney();
  $("#ajuste").spinner({ min: 0 });
  $("#ajuste").width(50);
  trae_registros();
});
function trae_registros()
{
  $("#solicitud").html('');
  var planes = $("#numero").val();
  if (planes == "0")
  {
    $("#solicitud").prop("disabled",true);
    $("#nom_1").prop("disabled",true);
    $("#car_1").prop("disabled",true);
    $("#add_field").hide();
    $("#add_field1").hide();
    $("#add_field2").hide();
  }
  else
  {
    var var_ocu = planes.split(',');
    var var_ocu1 = var_ocu.length;
    var salida = "";
    var paso = "";
    var j = 0;
    for (var i=0; i<var_ocu1-1; i++)
    {
      j = j+1;
      paso = var_ocu[i];
      salida += "<option value='"+paso+"'>"+paso+"</option>";
    }
    $("#solicitud").append(salida);
    $("#solicitud").prop("disabled",false);
    $("#nom_1").prop("disabled",false);
    $("#car_1").prop("disabled",false);
    $("#add_field").show();
    $("#add_field1").show();
    $("#add_field2").show();
    trae_datos();
  }
}
function trae_datos()
{
  limpia();
  var registro = $("#solicitud").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_registro.php",
    data:
    {
      registro: registro
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var valor = registros.valor;
      var valor1 = registros.valor1;
      var sintesis = registros.sintesis;
      var directiva = registros.directiva;
      var usuario = registros.usuario;
      var tipo = registros.tipo;
      if (tipo == "1")
      {
        $("#l_neutraliza").hide();
      }
      else
      {
        $("#l_neutraliza").show();
      }
      var material = registros.material;
      var niveles = registros.niveles;
      var var_ocu = niveles.split('#');
      var var_ocu1 = var_ocu.length;
      var paso = "";
      var salida1 = "<option value='0,0,0'>- SELECCIONAR -</option>";
      for (var i=0; i<var_ocu1-1; i++)
      {
        paso = var_ocu[i];
        var var_ocu2 = paso.split('|');
        var v1 = var_ocu2[0];
        var v2 = var_ocu2[1];
        var v3 = var_ocu2[2];
        var v4 = var_ocu2[3];
        var v5 = v1+','+v2+','+v3;
        if (directiva == "4")
        {
          if (v4 == "1")
          {
            var v6 = "GAO - GAOML";
          }
          else
          {
            var v6 = "GDO";
          }
          v6 = " "+v6;
        }
        else
        {
          var v6 = "";
        }
        salida1 += "<option value='"+v5+"'>Nivel "+v1+" - Desde "  +v2+" Hasta "+v3+" "+v6+"</option>";
      }
      $("#v_paso1").val(salida1);
      var var_oca = material.split('#');
      var var_oca1 = var_oca.length;
      var paso1 = "";
      var salida2 = "<option value='0,0,0,0'>- SELECCIONAR -</option>";
      for (var i=0; i<var_oca1-1; i++)
      {
        paso1 = var_oca[i];
        var var_oca2 = paso1.split('|');
        var v1 = var_oca2[0];
        var v2 = var_oca2[1];
        v2 = v2.trim();
        var v3 = var_oca2[2];
        var v4 = var_oca2[3];
        var v5 = var_oca2[4];
        var v6 = var_oca2[5];
        var v7 = v1+','+v4+','+v5+','+v6;
        var v8 = v2.substring(0,115);
        salida2 += "<option value='"+v7+"'>"+v8+"</option>";
      }
      $("#v_paso2").val(salida2);
      $("#v_paso3").val(usuario);
      $("#valor").val(valor);
      $("#valor1").val(valor1);
      $("#sintesis").val(sintesis);
      $("#directiva").val(directiva);
      $("#v_material").val(material);
      $("#v_niveles").val(niveles);
      var salario = registros.salario;
      salario = parseFloat(salario);
      var salario1 = salario.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#salario").val(salario1);
      $("#salario1").val(salario);
      $("#aceptar").show();
      $("#lista").html('');
      var var_ocu = registro.split('-');
      var valor2 = var_ocu[0];
      valor2 = valor2.trim();
      var valor3 = var_ocu[1];
      valor3 = valor3.trim();
      var n_directiva = $("#directiva option:selected").html();
      var datos = valor2+","+valor3+",'"+registros.codigo+"'";
      var datos1 = valor2+","+valor3+","+directiva+",'"+n_directiva+"'";
      var salida3 = "<br><a href='#' name='lnk1' id='lnk1' onclick=\"link4("+datos1+");\"><img src='imagenes/lista.png' width='30' border='0' title='Ver Lista de Verificaci&oacute;n'></a>";
      $("#lista").append(salida3);
      $("#anexo").html('');
      var salida4 = "<br><a href='#' name='lnk3' id='lnk3' onclick=\"link5("+datos+");\"><img src='imagenes/anexa.png'  width='30' border='0' title='Anexar Oficio'></a>";
      $("#anexo").append(salida4);
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
function limpia()
{
  $("#numero1").val('0');
  $("#sintesis").val('');
  $("#valor").val('0.00');
  $("#valor1").val('0');
  $("#concepto").val('');
  $("#recomendaciones").val('');
  $("#observaciones").val('');
}
function calculo(valor)
{
  var valor;
  var valor1 = $("#niv_"+valor).val();
  if (valor1 == "0,0,0")
  {
    var detalle = "<center><h3>Debe seleccionar un nivel</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var var_ocu = valor1.split(',');
    var v1 = var_ocu[0];
    var v2 = var_ocu[1];
    var v3 = var_ocu[2];
    var salario = $("#salario1").val();
    var monto = salario*v3;
    monto = parseFloat(monto);
    var monto1 = monto.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $("#mon_"+valor).val(monto1);
    $("#mos_"+valor).val(monto);
    $("#val_"+valor).val('0.00');
    paso_valor1(valor);
    calculo1(valor);
  }
}
function calculo1(valor)
{
  var valor;
  var valor1 = $("#mos_"+valor).val();
  valor1 = parseFloat(valor1);
  var valor2 = $("#vap_"+valor).val();
  var valor3 = valor2-valor1;
  if (valor3 > 0)
  {
    var valor4 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    var detalle = "<center><h3>Valoración no permitida, superior a "+valor4+"</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    var actualiza = $("#actu").val();
    if (actualiza == "0")
    {
      $("#aceptar").hide();
    }
    else
    {
      $("#aceptar2").hide();
    }
  }
  suma();
  suma2();
}
function calculo2(valor)
{
  var valor;
  var valor1 = $("#ele_"+valor).val();
  if (valor1 == "0,0,0,0")
  {
    var detalle = "<center><h3>Debe seleccionar un elemento</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $("#cal_mat1").val('0.00');
    $("#cal_mat2").val('0.00');
    $("#cal_mat3").val('0.00');
    var var_ocu = valor1.split(',');
    var v1 = var_ocu[0];
    var v2 = var_ocu[1];
    v2 = parseFloat(v2);
    var v3 = var_ocu[2];
    v3 = parseFloat(v3);
    if (v3 == "0")
    {
      v3 = $("#valor1").val();
      v3 = parseFloat(v3);
    }
    var v4 = var_ocu[3];
    v4 = parseFloat(v4);
    var salario = $("#salario1").val();
    var monto = v2;
    var monto1 = monto.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $("#moe_"+valor).val(monto1);
    $("#mod_"+valor).val(monto);
    $("#max_"+valor).val(v3);
    $("#por_"+valor).val(v4);
    var maximo = v3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $("#cal_mat1").val(maximo);
    $("#cal_mat3").val(v4);
  }
}
function calculo3(valor)
{
  calculo2(valor);
  var valor0 = $("#can_"+valor).val();
  valor0 = parseInt(valor0);
  var valor1 = $("#mod_"+valor).val();
  valor1 = valor0*valor1;
  var valor2 = $("#vap1_"+valor).val();
  var valor3 = valor2-valor1;
  if (valor3 > 0)
  {
    var valor4 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    var detalle = "<font face='Verdana' size='3'>Valor Aprobado no permitido, superior a "+valor4+"</font>";
    alerta(detalle);
    $("#val1_"+valor).val('0.00');
    paso_valor2(valor);
    calculo3(valor);
    var actualiza = $("#actu").val();
    if (actualiza == "0")
    {
      $("#aceptar").hide();
    }
    else
    {
      $("#aceptar2").hide();
    }
  }
  var valor5 = $("#max_"+valor).val();
  valor5 = parseInt(valor5);
  var valor6 = valor2-valor5;
  var valor7 = valor6.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  var valor8 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#cal_mat2").val(valor7);
  if (valor6 > 0)
  {
    var detalle = "<font face='Verdana' size='3'>Valor Aprobado no permitido, superior a "+valor8+"</font>";
    alerta(detalle);
    $("#val1_"+valor).val(valor8);
    $("#vap1_"+valor).val(valor5);
    var actualiza = $("#actu").val();
    if (actualiza == "0")
    {
      $("#aceptar").hide();
    }
    else
    {
      $("#aceptar2").hide();
    }
  }
  suma1();
  suma2();
}
function calculo4(valor)
{
  var valor;
  var valor1 = $("#can_"+valor).val();
  if (valor1 == "0")
  {
    $("#val1_"+valor).val('0.00');
    calculo3(valor);
  }
}
function calculo5(valor)
{
  var valor;
  var valor0 = $("#can_"+valor).val(); 
  valor0 = parseInt(valor0);
  var valor1 = $("#mod_"+valor).val();
  valor1 = valor0*valor1;
  var valor2 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#cal_mat").val(valor2);
  var actualiza = $("#actu").val();
  if (valor1 == "0")
  {
    if (actualiza == "0")
    {
      $("#aceptar").hide();
    }
    else
    {
      $("#aceptar2").hide();
    }
  }
  else
  {
    if (actualiza == "0")
    {
      $("#aceptar").show();
    }
    else
    {
      $("#aceptar2").show();
    }
  }
}
function suma()
{
  var valor = 0;
  var valor1 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vap_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      valor1 = valor1+valor;
    }
  }
  $("#total2").val(valor1);
  var valor2 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total1").val(valor2);
}
function suma1()
{
  var valor = 0;
  var valor1 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vap1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      valor1 = valor1+valor;
    }
  }
  $("#total4").val(valor1);
  var valor2 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total3").val(valor2);
}
function suma2()
{ 
  var actualiza = $("#actu").val();
  var numero1 = $("#numero1").val();
  var valor0 = $("#total8").val();
  valor0 = parseFloat(valor0);
  var valor1 = $("#total2").val();
  valor1 = parseFloat(valor1);
  var valor2 = $("#total4").val(); 
  valor2 = parseFloat(valor2);
  var valor3 = valor0+valor1+valor2;
  $("#total6").val(valor3);
  var valor4 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total5").val(valor4);
  var valor4 = $("#valor1").val();
  var valor5 = valor3-valor4; 
  if (valor5 > 0)
  {
    var detalle = "<center><h3>Valor Acta Superior al Solicitado</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#aceptar").hide();
    $("#aceptar2").hide();
  }
  else
  {
    if (actualiza == "0")
    {
      $("#aceptar").show();
      $("#aceptar2").hide();
    }
    else
    {
      $("#aceptar").hide();
      $("#aceptar2").show(); 
    }
  }
  if (valor3 == "0")
  {
    $("#aceptar").hide();
    $("#aceptar2").hide();
  }
}
function paso_valor()
{
  var valor;
  valor = $("#valor").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#valor1").val(valor);
}
function paso_valor1(valor)
{
  var valor, valor1;
  valor1 = document.getElementById('val_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vap_"+valor).val(valor1);
}
function paso_valor2(valor)
{
  var valor, valor1;
  valor1 = document.getElementById('val1_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vap1_"+valor).val(valor1);
}
function paso_valor3(valor, valor1)
{
  var valor, valor1, valor2;
  var valor2 = document.getElementById(valor).value;
  valor2 = parseFloat(valor2.replace(/,/g,''));
  $("#"+valor1).val(valor2);
}
function paso_valor4()
{
  var valor = $("#total7").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#total8").val(valor);
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
  var detalle = "<center><h3><font color='#ff0000'>El Acta no podrá ser modificada.</font><br>Esta seguro de continuar ?";
  $("#dialogo3").html(detalle);
  $("#dialogo3").dialog("open");
  $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function validacionData()
{
  var salida = true, detalle = '';
  document.getElementById('firmas').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu.elements[i].name;
    if (saux1.indexOf('car_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
      valor2 = valor+"»"+valor1;
      document.getElementById('firmas').value = document.getElementById('firmas').value+valor2+"|";
    }
  }
  document.getElementById('neutralizados').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('niv_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu.elements[i].name;
    if (saux1.indexOf('ide_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux7 = document.formu.elements[i].name;
    if (saux7.indexOf('org_')!=-1)
    {
      valor7 = document.getElementById(saux7).value;
    }
    saux2 = document.formu.elements[i].name;
    if (saux2.indexOf('mon_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
    }
    saux3 = document.formu.elements[i].name;
    if (saux3.indexOf('mos_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
    }
    saux4 = document.formu.elements[i].name;
    if (saux4.indexOf('val_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
    }
    saux5 = document.formu.elements[i].name;
    if (saux5.indexOf('vap_')!=-1)
    {
      valor5 = document.getElementById(saux5).value;
      valor6 = valor+"»"+valor1+"»"+valor2+"»"+valor3+"»"+valor4+"»"+valor5+"»"+valor7;
      document.getElementById('neutralizados').value = document.getElementById('neutralizados').value+valor6+"|";
    }
  }
  document.getElementById('material').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('ele_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux1 = document.formu.elements[i].name;
    if (saux1.indexOf('can_')!=-1)
    {
      valor1 = document.getElementById(saux1).value;
    }
    saux2 = document.formu.elements[i].name;
    if (saux2.indexOf('moe_')!=-1)
    {
      valor2 = document.getElementById(saux2).value;
    }
    saux3 = document.formu.elements[i].name;
    if (saux3.indexOf('mod_')!=-1)
    {
      valor3 = document.getElementById(saux3).value;
    }
    saux4 = document.formu.elements[i].name;
    if (saux4.indexOf('est_')!=-1)
    {
      valor4 = document.getElementById(saux4).value;
    }
    saux5 = document.formu.elements[i].name;
    if (saux5.indexOf('val1_')!=-1)
    {
      valor5 = document.getElementById(saux5).value;
    }
    saux6 = document.formu.elements[i].name;
    if (saux6.indexOf('vap1_')!=-1)
    {
      valor6 = document.getElementById(saux6).value;
      valor7 = valor+"»"+valor1+"»"+valor2+"»"+valor3+"»"+valor4+"»"+valor5+"»"+valor6;
      document.getElementById('material').value = document.getElementById('material').value+valor7+"|";
    }
  }
  var v_nombres = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_nombres ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_nombres > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_nombres+" Nombre(s)</h3></center>";
  }
  var v_cargos = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('car_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_cargos ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_cargos > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_cargos+" Cargo(s)</h3></center>";
  }
  var v_niveles = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('niv_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (valor == "0,0,0")
      {
        v_niveles ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_niveles > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar "+v_niveles+" Nivel(es)</h3></center>";
  }
  var v_identidades = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('ide_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_identidades ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_identidades > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_identidades+" Identidad(es)</h3></center>";
  }
  var v_organiza = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('org_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_organiza ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_organiza > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_organiza+" Cargo(s) Organizacional(es)</h3></center>";
  }
  var v_valoracion = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vap_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (valor == "0")
      {
        v_valoracion ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_valoracion > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_valoracion+" Valoracion(es)</h3></center>";
  }
  var v_elementos = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('ele_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (valor == "0,0,0,0")
      {
        v_elementos ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_elementos > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar "+v_elementos+" Elemento(s)</h3></center>";
  }
  var v_cantidades = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('can_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (valor == "0")
      {
        v_cantidades ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_cantidades > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_cantidades+" Cantidad(es)</h3></center>";
  }
  var v_aprobados = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('vap1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (valor == "0")
      {
        v_aprobados ++;
        $("#"+saux).prop("disabled",false);
      }
    }
  }
  if (v_aprobados > 0)
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar "+v_aprobados+" Valor(es) Aprobado(s)</h3></center>";
  }
  var valor7 = $("#constancia").val();
  valor7_1 = valor7.trim();
  valor7 = valor7.trim().length;
  if ((valor7_1 == "") || (valor7_1 == "0") || (valor7 == "0"))
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Constancia</center></h3>";
    $("#constancia").addClass("ui-state-error");
  }
  else
  {
    $("#constancia").removeClass("ui-state-error");
  }
  var valor = $("#sintesis").val();
  valor = valor.trim().length;
  if (valor == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la Sintesis de la Informaci&oacute;n</h3></center>";
    $("#sintesis").addClass("ui-state-error");
  }
  else
  {
    $("#sintesis").removeClass("ui-state-error");
  }
  var t_neutra = $("#total2").val();
  t_neutra = parseFloat(t_neutra);
  if (t_neutra > 0)
  {
    var valor5 = $("#valoracion").val();
    valor5 = valor5.trim().length;
    if (valor5 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar la Valoraci&oacute;n de Neutralizados</h3></center>";
      $("#valoracion").addClass("ui-state-error");
    }
    else
    {
      $("#valoracion").removeClass("ui-state-error");
    }
  }
  var valor9 = $("#impacto").val();
  valor9 = valor9.trim().length;
  if (valor9 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Impacto</h3></center>";
    $("#impacto").addClass("ui-state-error");
  }
  else
  {
    $("#impacto").removeClass("ui-state-error");
  }
  var valor1 = $("#concepto").val();
  valor1 = valor1.trim().length;
  if (valor1 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Concepto de Evaluaci&oacute;n</h3></center>";
    $("#concepto").addClass("ui-state-error");
  }
  else
  {
    $("#concepto").removeClass("ui-state-error");
  }
  var valor2 = $("#recomendaciones").val();
  valor2 = valor2.trim().length;
  if (valor2 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar las Recomendaciones</h3></center>";
    $("#recomendaciones").addClass("ui-state-error");
  }
  else
  {
    $("#recomendaciones").removeClass("ui-state-error");
  }
  var valor3 = $("#observaciones").val();
  valor3 = valor3.trim().length;
  if (valor3 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar las Observaciones</h3></center>";
    $("#observaciones").addClass("ui-state-error");
  }
  else
  {
    $("#observaciones").removeClass("ui-state-error");
  }
  var valor4 = $("#elaboro").val();
  valor4 = valor4.trim().length;
  if (valor4 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la persona que Elaboro el Acta</h3></center>";
    $("#elaboro").addClass("ui-state-error");
  }
  else
  {
    $("#elaboro").removeClass("ui-state-error");
  }
  var valor8 = $("#reviso").val();
  valor8 = valor8.trim().length;
  if (valor8 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar la persona que Revisó el Acta</h3></center>";
    $("#reviso").addClass("ui-state-error");
  }
  else
  {
    $("#reviso").removeClass("ui-state-error");
  }
  var total = $("#total6").val();
  if (total == "0")
  {
    salida = false;
    detalle += "<center><h3>Valor del Acta No Permitido</h3></center>";
  }
  var total1 = $("#valor1").val();
  total = parseFloat(total);
  total1 = parseFloat(total1);
  if (total > total1)
  {
    salida = false;
    detalle += "<center><h3>Valor del Acta superior al Solicitado</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo2").html(detalle);
    $("#dialogo2").dialog("open");
    $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    var actualiza = $("#actu").val();
    if (actualiza == "0")
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
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "actr_grab.php",
      data:
      {
        tipo: valor,
        conse: $("#numero1").val(),
        registro: $("#solicitud").val(),
        valor: $("#valor").val(),
        directiva: $("#directiva").val(),
        salario: $("#salario").val(),
        firmas: $("#firmas").val(),
        acta: $("#acta").val(),
        constancia:  $("#constancia").val(),
        folio: $("#folio").val(),
        sintesis: $("#sintesis").val(),
        informacion: $("#informacion").val(),
        neutralizados: $("#neutralizados").val(), 
        material: $("#material").val(),
        totali: $("#total7").val(),
        totaln: $("#total1").val(),
        totalm: $("#total3").val(),
        totala: $("#total5").val(),
        impacto: $("#impacto").val(),
        concepto: $("#concepto").val(),
        valoracion:  $("#valoracion").val(),
        recomendaciones: $("#recomendaciones").val(),
        observaciones: $("#observaciones").val(),
        elaboro: $("#elaboro").val(),
        cargo: $("#cargo").val(),
        reviso: $("#reviso").val(),
        cargo1: $("#cargo1").val(),
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
        var valida = registros.salida;
        if (valida > 0)
        {
          $("#aceptar").hide();
          $("#aceptar2").hide();
          $("#aceptar1").show();
          $("#aceptar3").show();
          $("#numero1").val(valida);
          $("#acta_conse").val(valida);
          $("#acta_ano").val(registros.salida1);
          $("#solicitud").prop("disabled",true);
          $("#acta").prop("disabled",true);
          $("#constancia").prop("disabled",true);
          $("#folio").prop("disabled",true);
          $("#sintesis").prop("disabled",true);
          $("#informacion").prop("disabled",true);
          $("#total7").prop("disabled",true);
          $("#valoracion").prop("disabled",true);
          $("#impacto").prop("disabled",true);
          $("#concepto").prop("disabled",true);
          $("#recomendaciones").prop("disabled",true);
          $("#observaciones").prop("disabled",true);
          $("#elaboro").prop("disabled",true);
          $("#cargo").prop("disabled",true);
          $("#reviso").prop("disabled",true);
          $("#cargo1").prop("disabled",true);
          for (i=0;i<document.formu.elements.length;i++)
          {
            saux = document.formu.elements[i].name;
            if (saux.indexOf('nom_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('car_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('niv_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('ide_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('org_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('mon_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('mos_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('val_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('vap_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('ele_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('can_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('moe_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('mod_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('est_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('val1_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
            saux = document.formu.elements[i].name;
            if (saux.indexOf('vap1_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
          $("#add_field").hide();
          $("#add_field1").hide();
          $("#add_field2").hide();
          for (k=1;k<=20;k++)
          {
            $("#men_"+k).hide();
            $("#mes_"+k).hide();
            $("#mex_"+k).hide();
          }
          $("#actu").val('0');
        }
        else
        {
          detalle = "<center><h3>Error durante la grabación</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#aceptar").show();
          $("#v_click").val('0');
        }
      }
    });
  }
}
function consultar()
{
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
      url: "actr_consu.php",
      data:
      {
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
        salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='9%'><b>Acta</b></td><td height='35' width='8%'><b>Fecha</b></td><td height='35' width='8%'><b>Unidad</b></td><td height='35' width='10%'><b>Registro</b></td><td height='35' width='10%'><b>A&ntilde;o</b></td><td height='35' width='15%'><b>ORDOP</b></td><td height='35' width='10%'><center><b>Solicitado</b></center></td><td height='35' width='10%'><center><b>Valor Acta</b></center></td><td width='5%' height='35'>&nbsp;</td><td width='5%' height='35'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td><td height='35' width='5%'>&nbsp;</td></tr></table>";
        salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
        $.each(registros.rows, function (index, value)
        {
          var estado = value.estado;
          var codigo = value.codigo;
          codigo = codigo.trim();
          codigo = '\"'+codigo+'\"';
          var datos1 = '\"'+value.conse+'\",\"'+value.ano+'\",\"'+value.unidad+'\",\"'+index+'\"';
          salida2 += "<tr><td width='9%' height='35' id='l1_"+index+"'>"+value.conse+"</td>";
          salida2 += "<td width='8%' height='35' id='l2_"+index+"'>"+value.fecha+"</td>";
          salida2 += "<td width='8%' height='35' id='l3_"+index+"'>"+value.unidad+"</td>";
          salida2 += "<td width='10%' height='35' id='l4_"+index+"'>"+value.registro+"</td>";
          salida2 += "<td width='10%' height='35' id='l5_"+index+"'>"+value.ano1+"</td>";
          salida2 += "<td width='15%' height='35' id='l6_"+index+"'>"+value.ordop+"</td>";
          salida2 += "<td width='10%' height='35' id='l7_"+index+"' align='right'>"+value.valor+"</td>";
          salida2 += "<td width='10%' height='35' id='l8_"+index+"' align='right' >"+value.totala+"</td>";
          if (estado == "")
          {
            salida2 += "<td width='5%' height='35' id='l9_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",12); modif("+value.conse+","+value.ano+","+value.registro+","+value.ano1+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='5%' height='35' id='l9_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
          }
          salida2 += "<td width='5%' height='35' id='l10_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",12); link1("+datos1+")'><img src='imagenes/pdf.png' border='0' title='Visualizar Acta'></a></center></td>";
          if ((estado == "E") || (estado == "F"))
          {
            salida2 += "<td width='5%' height='35' id='l11_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",12); link2("+value.conse+","+value.ano+","+codigo+")'><img src='imagenes/pdf.png' border='0' title='Visualizar Acta Firmada'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='5%' height='35' id='l11_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
          }
          // Eliminar PDF Final
          if (super1 == "1")
          {
            salida2 += "<td width='5%' height='35' id='l12_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",12); del_pdf("+datos1+");'><img src='dist/img/delete.png' name='pdf_"+index+"' id='pdf_"+index+"' width='29' height='29' border='0' title='Eliminar PDF'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='5%' height='35' id='l12_"+index+"'><center><img src='imagenes/blanco.png' border='0'></center></td>";
          }
          salida2 += "</tr>";
          listareg.push(index);
        });
        salida2 += "</table>";
        $("#tabla3").append(salida1);
        $("#resultados5").append(salida2);
      }
    });
  }
}
function modif(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3;
  $("#solicitud").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "actr_consu1.php",
    data:
    {
      conse: valor,
      ano: valor1,
      registro: valor2,
      ano1: valor3
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
      $("#soportes").accordion({active: 0});
      var registros = JSON.parse(data);
      var registro = registros.registro;
      var ano1 = registros.ano1;
      var valores = registro+" - "+ano1;
      var salida = "";
      salida += "<option value='"+valores+"'>"+valores+"</option>";
      $("#solicitud").append(salida);
      $("#solicitud").prop("disabled",true);
      var material = registros.material;
      var niveles = registros.niveles;
      var var_ocu = niveles.split('#');
      var var_ocu1 = var_ocu.length;
      var paso = "";
      var salida1 = "<option value='0,0,0'>- SELECCIONAR -</option>";
      for (var i=0; i<var_ocu1-1; i++)
      {
        paso = var_ocu[i];
        var var_ocu2 = paso.split('|');
        var v1 = var_ocu2[0];
        var v2 = var_ocu2[1];
        var v3 = var_ocu2[2];
        var v4 = var_ocu2[3];
        var v5 = v1+','+v2+','+v3;
        if (directiva == "4")
        {
          if (v4 == "1")
          {
            var v6 = "GAO - GAOML";
          }
          else
          {
            var v6 = "GDO";
          }
          v6 = " "+v6;
        }
        else
        {
          var v6 = "";
        }
        salida1 += "<option value='"+v5+"'>Nivel "+v1+" - Desde "  +v2+" Hasta "+v3+" "+v6+"</option>";
      }
      $("#v_paso1").val(salida1);
      var var_oca = material.split('#');
      var var_oca1 = var_oca.length;
      var paso1 = "";
      var salida2 = "<option value='0,0,0,0'>- SELECCIONAR -</option>";
      for (var i=0; i<var_oca1-1; i++)
      {
        paso1 = var_oca[i];
        var var_oca2 = paso1.split('|');
        var v1 = var_oca2[0];
        var v2 = var_oca2[1];
        v2 = v2.trim();
        var v3 = var_oca2[2];
        var v4 = var_oca2[3];
        var v5 = var_oca2[4];
        var v6 = var_oca2[5];
        var v7 = v1+','+v4+','+v5+','+v6;
        var v8 = v2.substring(0,115);
        salida2 += "<option value='"+v7+"'>"+v8+"</option>";
      }
      $("#v_paso2").val(salida2);
      $("#v_paso3").val(registros.usuario);
      var con_firmas = 0;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('nom_')!=-1)
        {
          con_firmas ++;
        }
      }
      var con_neutralizados = 0;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('niv_')!=-1)
        {
          con_neutralizados ++;
        }
      }
      var con_material = 0;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('ele_')!=-1)
        {
          con_material ++;
        }
      }
      // Firmas
      var firmas = registros.firmas;
      var var_ocu = firmas.split('|');
      var var_ocu1 = var_ocu.length;
      var var_ocu2 = var_ocu1-2;
      var z = 0;
      for (var i=0; i<var_ocu1-1; i++)
      {      
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("»");
        z = z+1;
        var nom = var_2[0];
        nom = nom.trim();
        var car = var_2[1];
        car = car.trim();
        $("#nom_"+z).val(nom);
        $("#car_"+z).val(car);
        if (con_firmas > var_ocu2)
        {
        }
        else
        {
          if (i < var_ocu2)
          {
            $("#add_field").click();
          }
        }
      }
      $("#nom_1").prop("disabled",false);
      $("#car_1").prop("disabled",false);
      $("#add_field").show();
      $("#add_field1").show();
      $("#add_field2").show();
      // Neutralizados
      var neutralizados = registros.neutralizados;
      var var_ocu = neutralizados.split('|');
      var var_ocu1 = var_ocu.length;
      var var_ocu2 = var_ocu1-1;
      var z = 0;
      for (var i=0; i<var_ocu1-1; i++)
      {
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("»");
        if (con_neutralizados >= var_ocu2)
        {
        }
        else
        {
          if (i < var_ocu2)
          {
            $("#add_field1").click();
          }
        }
        z = z+1;
        var niv = var_2[0];
        var ide = var_2[1];
        ide = ide.trim();
        var mon = var_2[2];
        var mos = var_2[3];
        var val = var_2[4];
        var vap = var_2[5];
        var org = var_2[6];
        if ((org == undefined) || (org == null))
        {
        	org = "";
        }
        $("#niv_"+z).val(niv);
        $("#ide_"+z).val(ide);
        $("#org_"+z).val(org);
        $("#mon_"+z).val(mon);
        $("#mos_"+z).val(mos);
        $("#val_"+z).val(val);
        $("#vap_"+z).val(vap);
      }
      // Material
      var material1 = registros.material1;
      var var_ocu = material1.split('|');
      var var_ocu1 = var_ocu.length;
      var var_ocu2 = var_ocu1-1;
      var z = 0;
      for (var i=0; i<var_ocu1-1; i++)
      {
        var var_1 = var_ocu[i];
        var var_2 = var_1.split("»");
        if (con_material >= var_ocu2)
        {
        }
        else
        {
          if (i < var_ocu2)
          {
            $("#add_field2").click();
          }
        }
        z = z+1;
        var ele = var_2[0];
        var can = var_2[1];
        var moe = var_2[2];
        var mod = var_2[3];
        var est = var_2[4];
        var val1 = var_2[5];
        var vap1 = var_2[6];
        $("#ele_"+z).val(ele);
        $("#can_"+z).val(can);
        $("#moe_"+z).val(moe);
        $("#mod_"+z).val(mod);
        $("#est_"+z).val(est);
        $("#val1_"+z).val(val1);
        $("#vap1_"+z).val(vap1);
      }
      $("#alea").val(registros.codigo);
      $("#directiva").val(registros.directiva);
      $("#numero1").val(registros.conse);
      $("#acta").val(registros.acta);
      $("#constancia").val(registros.constancia);
      $("#folio").val(registros.folio);
      $("#sintesis").val(registros.sintesis);
      $("#concepto").val(registros.concepto);
      $("#valoracion").val(registros.valoracion);
      $("#recomendaciones").val(registros.recomendaciones);
      $("#observaciones").val(registros.observaciones);
      $("#elaboro").val(registros.elaboro);
      $("#cargo").val(registros.cargo);
      $("#reviso").val(registros.reviso);
      $("#cargo1").val(registros.cargo1);
      $("#impacto").val(registros.impacto);
      $("#informacion").val(registros.informacion);
      var totaln = registros.totaln;
      $("#total1").val(totaln);
      paso_valor3('total1','total2');
      var totalm = registros.totalm;
      $("#total3").val(totalm);
      paso_valor3('total3','total4');
      var totala = registros.totala;
      $("#total5").val(totala);
      paso_valor3('total5','total6');
      var totali = registros.totali;
      $("#total7").val(totali);
      paso_valor3('total7','total8');
      var valor = registros.valor;
      $("#valor").val(valor);
      paso_valor3('valor','valor1');
      var salario = registros.salario;
      salario = parseFloat(salario);
      var salario1 = salario.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#salario").val(salario1);
      $("#salario1").val(salario);
      $("#actu").val('1');
      $("#aceptar").hide();
      $("#aceptar2").show();
      $("#add_field2").click();
      $("#sintesis").focus();
      $("#lista").html('');
      var n_directiva = $("#directiva option:selected").html();
      var datos = registro+","+ano1+",'"+registros.codigo+"'";
      var datos1 = registro+","+ano1+","+registros.directiva+",'"+n_directiva+"'";
      var salida3 = "<br><a href='#' name='lnk1' id='lnk1' onclick=\"link4("+datos1+");\"><img src='imagenes/lista.png' width='30' border='0' title='Ver Lista de Verificaci&oacute;n'></a>";
      $("#lista").append(salida3);
      $("#anexo").html('');
      var salida4 = "<br><a href='#' name='lnk3' id='lnk3' onclick=\"link5("+datos+");\"><img src='imagenes/anexa.png'  width='30' border='0' title='Anexar Oficio'></a>";
      $("#anexo").append(salida4);
    }
  });
}
function del_pdf(conse, ano, sigla, index)
{
  var conse, ano, index, archivo;
  archivo = "ActaComReg_"+sigla+"_"+conse+"_"+ano+".pdf";
  var ruta = "Actas\\"+archivo;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "borrar2.php",
    data:
    {
      ruta: ruta
    },
    success: function (data)
    {
      $("#pdf_"+index).hide();
      alerta("Archivo PDF eliminado correctamente");
      alerta(archivo);
    }
  });
}
function enviar()
{
  var usuario = $("#v_paso3").val();
  var numero = $("#numero1").val();
  var ano = $("#acta_ano").val();
  var registro = $("#solicitud").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "actr_grab1.php",
    data:
    {
      usuario: usuario,
      numero: numero,
      ano: ano,
      registro: registro
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
      if (salida == "1")
      { 
        $("#aceptar").hide();
        $("#aceptar2").hide();
        $("#aceptar3").hide();
        subir();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo6").html(detalle);
        $("#dialogo6").dialog("open");
        $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar4").show();
      }
    }
  });  
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
  patron = /[0-9,]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function link()
{
  formu1.submit();
}
function link1(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3;
  var ajuste = $("#ajuste").val();
  var hoja = "0";
  if ($("#chk_hoja").is(':checked'))
  {
    hoja = "1";
  }
  $("#acta_conse").val(valor);
  $("#acta_ano").val(valor1);
  $("#acta_ajuste").val(ajuste);
  $("#acta_hoja").val(hoja);
  $("#acta_sigla").val(valor2);
  formu1.submit();
}
function link2(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $("#alea").val(valor2);
  subir();
}
function link4(valor, valor1, valor2, valor3)
{
  var valor, valor1, valor2, valor3;
  var url = "<a href='./lista.php?conse="+valor+"&ano="+valor1+"&directiva="+valor2+"&directiva1="+valor3+"' name='lnk2' id='lnk2' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnk2").click();
}
function link5(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  var url = "<a href='./subir4.php?conse="+valor+"&ano="+valor1+"&alea="+valor2+"' name='lnk4' id='lnk4' class='pantalla-modal'></a>";
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#lnk4").click();
}
function subir()
{
  var alea = $("#alea").val();
  var url = "<a href='./subir10.php?alea="+alea+"' name='link3' id='link3' class='pantalla-modal'>Link</a>";
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
function alerta(valor)
{
  alertify.error(valor);
}
</script>
</body>
</html>
<?php
}
// 26/01/2024 - Eliminacion de archivos pdf guardados
// 09/02/2024 - Retiro de estado OPTIMO por NUEVO y adicion N/A en  material
// 16/02/2024 - Inclusion campo cargo en la organizacion delincuencial
// 26/02/2024 - Ajuste envio sigla generacion pdf
// 01/08/2024 - Ajuste inclusion cargo reviso
// 28/10/2024 - Ajuste bloqueo valor por valor maximo
?>