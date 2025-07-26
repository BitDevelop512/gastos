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
      while($i<$row=odbc_fetch_array($cur1))
      {
        $numero .= "'".odbc_result($cur1,1)."',";
      }
      $numero = substr($numero,0,-1);
    }
    if ($n_unidad > 3)
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
      $cur1 = odbc_exec($conexion, $query1);
      $numero = "";
      while($i<$row=odbc_fetch_array($cur1))
      {
        $numero .= "'".odbc_result($cur1,1)."',";
      }
      $numero = substr($numero,0,-1);
    }
  }
  else
  {
    $numero = $uni_usuario;
  }
  // Calculo de periodo del mes actual
  $ano = date('Y');
  $mes = date('m');
  $mes = intval($mes);
  $mes1 = str_pad($mes,2,"0",STR_PAD_LEFT);
  switch ($mes)
  {
    case '1':
    case '3':
    case '5':
    case '7':
    case '8':
    case '10':
    case '12':
      $dia1 = "31";
      break;
    case '2':
      if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
      {
        $dia1 = "29";
      }
      else
      {
        $dia1 = "28";
      }
      break;
    case '4':
    case '6':
    case '9':
    case '11':
      $dia1 = "30";
      break;
    default:
      $dia1 = "31";
      break;
  }
  $fecha1 = $ano."/".$mes1."/01";
  $fecha2 = $ano."/".$mes1."/".$dia1;
  // Validación registro despues del cierre
  $consu1 = "SELECT bonos FROM cx_ctr_par";
  $cur1 = odbc_exec($conexion, $consu1);
  $var_combus = odbc_result($cur1,1);
  $adiciona = "0";
  $dia2 = date('d');
  $dia2 = intval($dia2);
  if ($dia2 <= $var_combus)
  {
    $actual = date('d-m-Y');
    $pasada = strtotime('-'.$var_combus.' day', strtotime($actual));
    $pasada = date('d-m-Y', $pasada);
    $fec_pasada = explode("-",$pasada);
    $fecha1 = $fec_pasada[2]."/".$fec_pasada[1]."/".$fec_pasada[0];
    $adiciona = "1";
  }
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
  <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
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
          <h3>Movimiento Transportes Contratos</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">Objeto del Contrato</font></label>
                  <select name="tipo" id="tipo" class="form-control select2" onchange="trae_contratos();" tabindex="1">
                    <option value="C">COMBUSTIBLE</option>
                    <option value="M">MANTENIMIENTO Y REPUESTOS</option>
                    <option value="L">LLANTAS</option>
                    <option value="T">RTM</option>
                  </select>
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-4 col-xs-4">
                  <label><font face="Verdana" size="2">No. del Contrato</font></label>
                  <select name="tipo1" id="tipo1" class="form-control select2" tabindex="2"></select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Clase de Veh&iacute;culo</font></label>
                  <select name="clase" id="clase" class="form-control select2" tabindex="3"></select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Placa</font></label>
                  <input type="text" name="placa1" id="placa1" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check3(event);" maxlength="6" tabindex="4" autocomplete="off">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha" id="fecha" class="form-control fecha" value="<?php echo $fecha; ?>" readonly="readonly" tabindex="5">
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <center>
                    <input type="button" name="aceptar" id="aceptar" value="Validar" tabindex="6">
                  </center>
                </div>
              </div>
              <br>
              <div id="datos"></div>
              <br>
              <br>
              <div class="row">
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Elaboro</font></label>
                  <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="10" autocomplete="off">
                </div>
                <div id="datos2">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Valor Asignado</font></label>
                    <input type="text" name="total1" id="total1" class="form-control numero" value="0.00" readonly="readonly">
                    <input type="hidden" name="total2" id="total2" class="form-control numero" value="0" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Valor Ejecutado</font></label>
                    <input type="text" name="total3" id="total3" class="form-control numero" value="0.00" readonly="readonly">
                    <input type="hidden" name="total4" id="total4" class="form-control numero" value="0" readonly="readonly">                    
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Valor x Ejecutar</font></label>
                    <input type="text" name="total5" id="total5" class="form-control numero" value="0.00" readonly="readonly">
                    <input type="hidden" name="total6" id="total6" class="form-control numero" value="0" readonly="readonly">                    
                  </div>
                </div>
              </div>
              <br>
              <div id="datos1">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
                  <div id="calendario"></div>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
              </div>
              <input type="hidden" name="v_paso1" id="v_paso1" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso2" id="v_paso2" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso3" id="v_paso3" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso4" id="v_paso4" value="<?php echo $numero; ?>" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso5" id="v_paso5" value="<?php echo $uni_usuario; ?>" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso6" id="v_paso6" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso7" id="v_paso7" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso8" id="v_paso8" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso9" id="v_paso9" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso10" id="v_paso10" class="form-control" readonly="readonly">
              <input type="hidden" name="v_paso11" id="v_paso11" class="form-control" readonly="readonly">
              <input type="hidden" name="v_fecha1" id="v_fecha1" class="form-control" value="<?php echo $fecha1; ?>" readonly="readonly">
              <input type="hidden" name="v_fecha2" id="v_fecha2" class="form-control" value="<?php echo $fecha2; ?>" readonly="readonly">
              <input type="hidden" name="v_super" id="v_super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly">
              <input type="hidden" name="adiciona" id="adiciona" class="form-control" value="<?php echo $adiciona; ?>" readonly="readonly">
            </form>
            <div id="dialogo">
              <form name="formu2">
                <table width="98%" align="center" border="0">
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Placa</font></label></center>
                          <input type="text" name="v_placa" id="v_placa" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Fecha</font></label></center>
                          <input type="text" name="v_fecha" id="v_fecha" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Contrato</font></label></center>
                          <select name="v_contrato" id="v_contrato" class="form-control select2"></select>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><hr></td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <label><font face="Verdana" size="2">Kilometraje</font></label>
                          <input type="text" name="v_kilometraje" id="v_kilometraje" class="form-control numero" value="0" onkeypress="return check(event);" onblur="valida_kilometro();" maxlength="10" autocomplete="off">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <label><font face="Verdana" size="2">Cant. Galones</font></label>
                          <input type="text" name="v_consumo" id="v_consumo" class="form-control numero" value="0.00" onkeypress="return check1(event);" onblur="valida_consumo();" maxlength="10" autocomplete="off">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <label><font face="Verdana" size="2">Cant. Bonos</font></label>
                          <input type="text" name="v_bonos" id="v_bonos" class="form-control numero" value="0.00" onkeypress="return check1(event);" maxlength="3" autocomplete="off">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <label><font face="Verdana" size="2">Valor Entregado</font></label>
                          <input type="text" name="v_precio" id="v_precio" class="form-control numero" value="0.00" onkeyup="paso_valor(); suma();">
                          <input type="hidden" name="v_precio1" id="v_precio1" class="form-control numero" value="0" readonly="readonly">
                          <input type="hidden" name="v_kilometros" id="v_kilometros" class="form-control numero" value="0" readonly="readonly">
                          <input type="hidden" name="v_alea" id="v_alea" class="form-control numero" value="" readonly="readonly">
                          <input type="hidden" name="v_odometro" id="v_odometro" class="form-control numero" value="0" readonly="readonly">
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                        <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
                          <center>
                            <input type="checkbox" name="eliminar" id="eliminar" value="0" onclick="borrar();">&nbsp;&nbsp;&nbsp;<label><font face="Verdana" size="2">Eliminar Datos del D&iacute;a</font></label>
                          </center>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center>
                            <input type="button" name="aceptar1" id="aceptar1" value="Continuar">
                          </center>
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center>
                            <input type="button" name="aceptar2" id="aceptar2" value="Cancelar">
                          </center>
                        </div>
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                          <div align="right">
                            <div id="link"></div>
                            <div id="vinculo"></div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
            <div id="dialogo1"></div>
            <div id="dialogo2"></div>
            <div id="dialogo3"></div>
            <!-- Mantenimientos -->
            <div id="dialogo4">
              <form name="formu3">
                <table width="98%" align="center" border="0">
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Placa</font></label></center>
                          <input type="text" name="m_placa" id="m_placa" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Fecha</font></label></center>
                          <input type="text" name="m_fecha" id="m_fecha" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Contrato</font></label></center>
                          <select name="m_contrato" id="m_contrato" class="form-control select2"></select>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Clase</font></label></center>
                          <input type="hidden" name="m_tipo" id="m_tipo" class="form-control fecha" onfocus="blur();" readonly="readonly">
                          <input type="text" name="m_clase" id="m_clase" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Marca</font></label></center>
                          <input type="text" name="m_marca" id="m_marca" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Linea</font></label></center>
                          <input type="text" name="m_linea" id="m_linea" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Modelo</font></label></center>
                          <input type="text" name="m_modelo" id="m_modelo" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><hr></td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                          <div id="add_form1">
                            <table width="100%" align="center" border="0">
                              <tr>
                                <td colspan="1"></td>
                              </tr>
                            </table>
                          </div>
                          <div class="espacio1"></div>
                          <a href="#" name="add_field1" id="add_field1"><img src="imagenes/boton1.jpg" border="0"></a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><hr></td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"></div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <label><font face="Verdana" size="2">Kilometraje</font></label>
                          <input type="text" name="m_kilometraje" id="m_kilometraje" class="form-control numero" value="0" onkeypress="return check(event);" onblur="valida_kilometro1();" maxlength="10" autocomplete="off">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <label><font face="Verdana" size="2">Valor Total</font></label>
                          <input type="text" name="m_precio" id="m_precio" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly">
                          <input type="hidden" name="m_precio1" id="m_precio1" class="form-control numero" value="0" readonly="readonly">
                          <input type="hidden" name="m_kilometros" id="m_kilometros" class="form-control numero" value="0" readonly="readonly">
                          <input type="hidden" name="m_alea" id="m_alea" class="form-control numero" value="" readonly="readonly">
                          <input type="hidden" name="m_registro" id="m_registro" class="form-control numero" value="0" readonly="readonly">
                          <input type="hidden" name="m_conta" id="m_conta" class="form-control numero" value="0" readonly="readonly">
                          <input type="hidden" name="m_actu" id="m_actu" class="form-control numero" value="0" readonly="readonly">
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                        <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
                          <center>
                            <input type="checkbox" name="eliminar1" id="eliminar1" value="0" onclick="borrar1();">&nbsp;&nbsp;&nbsp;<label><font face="Verdana" size="2">Eliminar Datos del D&iacute;a</font></label>
                          </center>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center>
                            <input type="button" name="aceptar3" id="aceptar3" value="Continuar">
                          </center>
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center>
                            <input type="button" name="aceptar4" id="aceptar4" value="Cancelar">
                          </center>
                        </div>
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                          <div align="right">
                            <div id="link2"></div>
                            <div id="vinculo1"></div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
            <div id="dialogo5"></div>
            <div id="dialogo6"></div>
            <!-- Llantas -->
            <div id="dialogo7">
              <form name="formu4">
                <table width="98%" align="center" border="0">
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Placa</font></label></center>
                          <input type="text" name="l_placa" id="l_placa" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Fecha</font></label></center>
                          <input type="text" name="l_fecha" id="l_fecha" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Contrato</font></label></center>
                          <select name="l_contrato" id="l_contrato" class="form-control select2"></select>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Clase</font></label></center>
                          <input type="hidden" name="l_tipo" id="l_tipo" class="form-control fecha" onfocus="blur();" readonly="readonly">
                          <input type="text" name="l_clase" id="l_clase" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Marca</font></label></center>
                          <input type="text" name="l_marca" id="l_marca" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Linea</font></label></center>
                          <input type="text" name="l_linea" id="l_linea" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Modelo</font></label></center>
                          <input type="text" name="l_modelo" id="l_modelo" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><hr></td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                          <div id="add_form2">
                            <table width="100%" align="center" border="0">
                              <tr>
                                <td colspan="1"></td>
                              </tr>
                            </table>
                          </div>
                          <div class="espacio1"></div>
                          <a href="#" name="add_field2" id="add_field2"><img src="imagenes/boton1.jpg" border="0"></a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><hr></td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"></div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <label><font face="Verdana" size="2">Kilometraje</font></label>
                          <input type="text" name="l_kilometraje" id="l_kilometraje" class="form-control numero" value="0" onkeypress="return check(event);" onblur="valida_kilometro2();" maxlength="10" autocomplete="off">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <label><font face="Verdana" size="2">Valor Total</font></label>
                          <input type="text" name="l_precio" id="l_precio" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly">
                          <input type="hidden" name="l_precio1" id="l_precio1" class="form-control numero" value="0" readonly="readonly">
                          <input type="hidden" name="l_kilometros" id="l_kilometros" class="form-control numero" value="0" readonly="readonly">
                          <input type="hidden" name="l_alea" id="l_alea" class="form-control numero" value="" readonly="readonly">
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                        <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
                          <center>
                            <input type="checkbox" name="eliminar2" id="eliminar2" value="0" onclick="borrar2();">&nbsp;&nbsp;&nbsp;<label><font face="Verdana" size="2">Eliminar Datos del D&iacute;a</font></label>
                          </center>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center>
                            <input type="button" name="aceptar5" id="aceptar5" value="Continuar">
                          </center>
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center>
                            <input type="button" name="aceptar6" id="aceptar6" value="Cancelar">
                          </center>
                        </div>
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                          <div align="right">
                            <div id="link4"></div>
                            <div id="vinculo2"></div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
            <div id="dialogo8"></div>
            <div id="dialogo9"></div>
            <!-- RTM -->
            <div id="dialogo10">
              <form name="formu5">
                <table width="98%" align="center" border="0">
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Placa</font></label></center>
                          <input type="text" name="r_placa" id="r_placa" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Fecha</font></label></center>
                          <input type="text" name="r_fecha" id="r_fecha" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Contrato</font></label></center>
                          <select name="r_contrato" id="r_contrato" class="form-control select2"></select>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Clase</font></label></center>
                          <input type="hidden" name="r_tipo" id="r_tipo" class="form-control fecha" onfocus="blur();" readonly="readonly">
                          <input type="text" name="r_clase" id="r_clase" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Marca</font></label></center>
                          <input type="text" name="r_marca" id="r_marca" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Linea</font></label></center>
                          <input type="text" name="r_linea" id="r_linea" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Modelo</font></label></center>
                          <input type="text" name="r_modelo" id="r_modelo" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><hr></td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
                          <div id="add_form3">
                            <table width="100%" align="center" border="0">
                              <tr>
                                <td colspan="1"></td>
                              </tr>
                            </table>
                          </div>
                          <div class="espacio1"></div>
                          <a href="#" name="add_field3" id="add_field3"><img src="imagenes/boton1.jpg" border="0"></a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><hr></td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"></div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <label><font face="Verdana" size="2">Kilometraje</font></label>
                          <input type="text" name="r_kilometraje" id="r_kilometraje" class="form-control numero" value="0" onkeypress="return check(event);" onblur="valida_kilometro3();" maxlength="10" autocomplete="off">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <label><font face="Verdana" size="2">Valor Total</font></label>
                          <input type="text" name="r_precio" id="r_precio" class="form-control numero" value="0.00" onfocus="blur();" readonly="readonly">
                          <input type="hidden" name="r_precio1" id="r_precio1" class="form-control numero" value="0" readonly="readonly">
                          <input type="hidden" name="r_kilometros" id="r_kilometros" class="form-control numero" value="0" readonly="readonly">
                          <input type="hidden" name="r_alea" id="r_alea" class="form-control numero" value="" readonly="readonly">
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                        <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
                          <center>
                            <input type="checkbox" name="eliminar3" id="eliminar3" value="0" onclick="borrar3();">&nbsp;&nbsp;&nbsp;<label><font face="Verdana" size="2">Eliminar Datos del D&iacute;a</font></label>
                          </center>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center>
                            <input type="button" name="aceptar7" id="aceptar7" value="Continuar">
                          </center>
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center>
                            <input type="button" name="aceptar8" id="aceptar8" value="Cancelar">
                          </center>
                        </div>
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                          <div align="right">
                            <div id="link5"></div>
                            <div id="vinculo3"></div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
            <div id="dialogo11"></div>
            <div id="dialogo12"></div>
            <div id="dialogo13"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="bower_components/moment/moment.js"></script>
<script src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
<style>
.ui-widget-header
{
  color: #000000;
  font-weight: bold;
}
#calendario
{
  max-width: 1100px;
  margin: 40px auto;
  font-size: 12px;
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
    changeMonth: true,
    onSelect: function () {
      $("#fecha3").prop("disabled", false);
      $("#fecha3").datepicker("destroy");
      $("#fecha3").val('');
      $("#fecha3").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha2").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
    },
  });
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 320,
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
        valida_archivos();
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
    height: 305,
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
    buttons: {
      "Ver Factura Cargada": function() {
        $(this).dialog("close");
        cargar();
      },
      "Reemplazar Factura Cargada": function() {
        $(this).dialog("close");
        reemplazar();
      },
      "Cerrar": function() {
        $(this).dialog("close");
      }
    }
  });
  // Mantenimientos
  $("#dialogo4").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 580,
    width: 1050,
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
  $("#dialogo5").dialog({
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
        valida_archivos1();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  // Mantenimientos - Facturas
  $("#dialogo6").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 250,
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
    buttons: {
      //"Ver Factura Cargada": function() {
      //  $(this).dialog("close");
      //  cargar1();
      //},
      //"Reemplazar Factura Cargada": function() {
      //  $(this).dialog("close");
      //  reemplazar1();
      //},
      "Modificar Información": function() {
        $(this).dialog("close");
        consultarm();
      },
      "Cerrar": function() {
        $(this).dialog("close");
      }
    }
  });
  // Llantas
  $("#dialogo7").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 550,
    width: 1050,
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
  $("#dialogo8").dialog({
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
        valida_archivos2();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  // Llantas - Facturas
  $("#dialogo9").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 250,
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
    buttons: {
      //"Ver Factura Cargada": function() {
      //  $(this).dialog("close");
      //  cargar2();
      //},
      //"Reemplazar Factura Cargada": function() {
      //  $(this).dialog("close");
      //  reemplazar2();
      //},
      "Cerrar": function() {
        $(this).dialog("close");
      }
    }
  });
  // RTM
  $("#dialogo10").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 550,
    width: 1050,
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
  $("#dialogo11").dialog({
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
        valida_archivos3();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  // RTM - Facturas
  $("#dialogo12").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 250,
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
    buttons: {
      //"Ver Factura Cargada": function() {
      //  $(this).dialog("close");
      //  cargar3();
      //},
      //"Reemplazar Factura Cargada": function() {
      //  $(this).dialog("close");
      //  reemplazar3();
      //},
      "Cerrar": function() {
        $(this).dialog("close");
      }
    }
  });
  // Reinicio Odometro
  $("#dialogo13").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 170,
    width: 785,
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
      "Confirmar": function() {
        $(this).dialog("close");
        $("#aceptar1").show();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(consultar);
  $("#aceptar").css({ width: '135px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta);
  $("#aceptar1").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(cerrar);
  $("#aceptar2").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").button();
  $("#aceptar3").click(pregunta1);
  $("#aceptar3").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar4").button();
  $("#aceptar4").click(cerrar1);
  $("#aceptar4").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar5").button();
  $("#aceptar5").click(pregunta2);
  $("#aceptar5").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar6").button();
  $("#aceptar6").click(cerrar2);
  $("#aceptar6").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar7").button();
  $("#aceptar7").click(pregunta3);
  $("#aceptar7").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar8").button();
  $("#aceptar8").click(cerrar3);
  $("#aceptar8").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#datos1").hide();
  $("#datos2").hide();
  $("#v_precio").maskMoney();
  $("#v_kilometraje").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#v_kilometraje").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#v_consumo").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#v_consumo").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#v_bonos").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#v_bonos").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#v_kilometraje").focus(function(){
    this.select();
  });
  $("#v_consumo").focus(function(){
    this.select();
  });
  // Mantenimientos
  $("#m_kilometraje").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#m_kilometraje").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#m_kilometraje").focus(function(){
    this.select();
  });
  // Llantas
  $("#l_kilometraje").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#l_kilometraje").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#l_kilometraje").focus(function(){
    this.select();
  });
  // RTM
  $("#r_kilometraje").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#r_kilometraje").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#r_kilometraje").focus(function(){
    this.select();
  });
  $("#total1").prop("disabled",true);
  $("#total3").prop("disabled",true);
  $("#total5").prop("disabled",true);
  // Mantenimientos
  var InputsWrapper1   = $("#add_form1 table tr");
  var AddButton1       = $("#add_field1");
  var x_2              = InputsWrapper1.length;
  var FieldCount1      = 1;
  $(AddButton1).click(function (e) {
    var paso1 = $("#v_paso6").val();
    var a = x_2;
    var val1 = "'man_"+a+"'";
    FieldCount1++;
    if (a == "1")
    {
      $("#add_form1 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4"><center><b>MANTENIMIENTO</b></center></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><center><b>CANT.</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>VALOR</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>I.V.A.</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>TOTAL</b></center></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">&nbsp;</div></div></td></tr>');
    }
    $("#add_form1 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4"><select name="man_'+a+'" id="man_'+a+'" class="form-control select2" onchange="cargam('+a+')"></select></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><input type="text" name="cam_'+a+'" id="cam_'+a+'" class="form-control numero" value="0" onkeypress="return check(event);" onblur="cargan('+a+'); suma_man();"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="val_'+a+'" id="val_'+a+'" class="form-control numero" value="0.00" onkeyup="valiman('+a+');" onblur="valiman('+a+');"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="iva_'+a+'" id="iva_'+a+'" class="form-control numero" value="0.00" readonly="readonly"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="tot_'+a+'" id="tot_'+a+'" class="form-control numero" value="0.00" readonly="readonly"></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><div id="mes_'+a+'"><a href="#" class="removeclass1"><img src="imagenes/boton2.jpg" name="dem_'+a+'" id="dem_'+a+'" border="0"></a></div></div></div></td></tr>');
    $("#man_"+a).append(paso1);
    $("#man_"+a).select2({
      tags: false,
      allowClear: false,
      closeOnSelect: true,
      dropdownParent: $("#add_field1")
    });
    $("#cam_"+a).focus(function(){
      this.select();
    });
    $("#val_"+a).maskMoney();
    $("#tot_"+a).maskMoney();
    $("#iva_"+a).prop("disabled",true);
    $("#tot_"+a).prop("disabled",true);
    $("#man_"+a).focus();
    $("#m_conta").val(a);
    x_2++;
    return false;
  });
  $("body").on("click",".removeclass1", function(e) {
    $(this).closest("tr").remove();
    suma_man();
    return false;
  });
  // Llantas
  var InputsWrapper2   = $("#add_form2 table tr");
  var AddButton2       = $("#add_field2");
  var x_3              = InputsWrapper2.length;
  var FieldCount2      = 1;
  $(AddButton2).click(function (e) {
    var paso2 = $("#v_paso8").val();
    var b = x_3;
    var val2 = "'lla_"+b+"'";
    FieldCount2++;
    if (b == "1")
    {
      $("#add_form2 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><center><b>LLANTAS</b></center></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><center><b>MARCA</b></center></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><center><b>CANT.</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>VALOR</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>I.V.A.</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>TOTAL</b></center></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">&nbsp;</div></div></td></tr>');
    }
    $("#add_form2 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><select name="lla_'+b+'" id="lla_'+b+'" class="form-control select2" onchange="cargal('+b+')"></select></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><input type="text" name="mal_'+b+'" id="mal_'+b+'" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50"></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><input type="text" name="cal_'+b+'" id="cal_'+b+'" class="form-control numero" value="0" onkeypress="return check(event);" onblur="cargap('+b+'); suma_lla();"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="lal_'+b+'" id="lal_'+b+'" class="form-control numero" value="0.00" onkeyup="valilla('+b+');" onblur="valilla('+b+');"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="ivl_'+b+'" id="ivl_'+b+'" class="form-control numero" value="0.00" readonly="readonly"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="tol_'+b+'" id="tol_'+b+'" class="form-control numero" value="0.00" readonly="readonly"></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><div id="mel_'+b+'"><a href="#" class="removeclass2"><img src="imagenes/boton2.jpg" name="del_'+b+'" id="del_'+b+'" border="0"></a></div></div></div></td></tr>');
    $("#lla_"+b).append(paso2);
    $("#lla_"+b).select2({
      tags: false,
      allowClear: false,
      closeOnSelect: true,
      dropdownParent: $("#dialogo7")
    });
    $("#cal_"+b).focus(function(){
      this.select();
    });
    $("#lal_"+b).maskMoney();
    $("#tol_"+b).maskMoney();
    $("#ivl_"+b).prop("disabled",true);
    $("#tol_"+b).prop("disabled",true);
    $("#lla_"+b).focus();
    x_3++;
    return false;
  });
  $("body").on("click",".removeclass2", function(e) {
    $(this).closest("tr").remove();
    suma_lla();
    return false;
  });
  // RTM
  var InputsWrapper3   = $("#add_form3 table tr");
  var AddButton3       = $("#add_field3");
  var x_4              = InputsWrapper3.length;
  var FieldCount3      = 1;
  $(AddButton3).click(function (e) {
    var paso3 = $("#v_paso10").val();
    var c = x_4;
    var val3 = "'rtm_"+c+"'";
    FieldCount3++;
    if (c == "1")
    {
      $("#add_form3 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><center><b>RTM</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>CDA</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>VALOR</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>I.V.A.</b></center></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><center><b>TOTAL</b></center></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">&nbsp;</div></div></td></tr>');
    }
    $("#add_form3 table").append('<tr><td class="espacio1"><div class="row"><div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"><select name="rtm_'+c+'" id="rtm_'+c+'" class="form-control select2" onchange="cargat('+c+');"></select></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="cda_'+c+'" id="cda_'+c+'" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"><input type="hidden" name="cat_'+c+'" id="cat_'+c+'" class="form-control numero" value="1" readonly="readonly"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="lat_'+c+'" id="lat_'+c+'" class="form-control numero" value="0.00" onkeyup="paso_rtm('+c+');"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="ivt_'+c+'" id="ivt_'+c+'" class="form-control numero" value="0.00" onkeyup="paso_rtm('+c+');"></div><div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"><input type="text" name="tor_'+c+'" id="tor_'+c+'" class="form-control numero" value="0.00" readonly="readonly"><input type="hidden" name="ter_'+c+'" id="ter_'+c+'" class="form-control numero" value="0.00" readonly="readonly"></div><div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1"><div id="mer_'+c+'"><a href="#" class="removeclass3"><img src="imagenes/boton2.jpg" name="der_'+c+'" id="der_'+c+'" border="0"></a></div></div></div></td></tr>');
    $("#rtm_"+c).append(paso3);
    $("#rtm_"+c).select2({
      tags: false,
      allowClear: false,
      closeOnSelect: true,
      dropdownParent: $("#dialogo10")
    });
    $("#lat_"+c).maskMoney();
    $("#ivt_"+c).maskMoney();
    $("#tor_"+c).maskMoney();
    //$("#lat_"+c).prop("disabled",true);
    //$("#ivt_"+c).prop("disabled",true);
    $("#tor_"+c).prop("disabled",true);
    $("#rtm_"+c).focus();
    x_4++;
    return false;
  });
  $("body").on("click",".removeclass3", function(e) {
    $(this).closest("tr").remove();
    suma_rtm();
    return false;
  });
  trae_unidades();
  trae_calendario();
  trae_vehiculos();
  trae_contratos();
});
function trae_unidades()
{
  $("#unidad1").html('');
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
      $("#unidad1").append(salida);
    }
  });
}
function trae_calendario()
{
  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();
  $("#calendario").fullCalendar({
    header: { 
      left: "prev,next today",
      center: "title",
      right : ""
    },
    buttonText: { today: "Hoy", month: "Mes", week: "Semana", day: "Dia" },
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    events: [],
    editable: false,
    droppable: false,
    selectable: true,
    select: function(start, end, jsEvent, view) {
      var fecha = moment(start).format('YYYY-MM-DD');
      var fecha1 = fecha.replace(/[-]+/g, "/");
      var v_tipo = $("#tipo").val();
      if (v_tipo == "C")
      {
        $("#v_fecha").val(fecha);
        var inicio = $("#v_fecha1").val();
        var fin = $("#v_fecha2").val();
        var solicita = $("#total2").val();
        solicita = parseFloat(solicita);
        if (solicita == "0")
        {
          var detalle = "<center><h3>Valor Solicitado No Válido</h3></center>";
          $("#dialogo2").html(detalle);
          $("#dialogo2").dialog("open");
          $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          if (valida_fecha(inicio, fin, fecha1))
          {
            var hora = new Date();
            var time = hora.getHours()+""+hora.getMinutes()+""+hora.getSeconds();
            var contrato = $("#tipo1").val();
            $("#v_kilometraje").val('0');
            $("#v_consumo").val('0.00');
            $("#v_bonos").val('0');
            $("#v_precio").val('0.00');
            $("#v_precio1").val('0');
            $("#v_alea").val(time);
            $("#v_contrato").val(contrato);
            $("#v_contrato").prop("disabled",true);
            $("#v_kilometraje").prop("disabled",false);
            $("#v_consumo").prop("disabled",false);
            $("#v_bonos").prop("disabled",false);
            $("#v_precio").prop("disabled",false);
            $("#eliminar").prop("checked",false);
            var boton = "<a href='#' name='lnk1' id='lnk1' onclick='subir();'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
            $("#link").html('');
            $("#link").append(boton);
            $("#dialogo").dialog("open");
            $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
          else
          {
            var detalle = "<center><h3>Fecha: "+fecha+" No Permitida</h3></center>";
            $("#dialogo2").html(detalle);
            $("#dialogo2").dialog("open");
            $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
        }
      }
      // Mantenimientos
      if (v_tipo == "M")
      {
        $("#m_fecha").val(fecha);
        var inicio = $("#v_fecha1").val();
        var fin = $("#v_fecha2").val();
        var solicita = $("#total2").val();
        solicita = parseFloat(solicita);
        if (solicita == "0")
        {
          var detalle = "<center><h3>Valor Solicitado No Válido</h3></center>";
          $("#dialogo2").html(detalle);
          $("#dialogo2").dialog("open");
          $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          if (valida_fecha(inicio, fin, fecha1))
          {
            var hora = new Date();
            var time = hora.getHours()+""+hora.getMinutes()+""+hora.getSeconds();
            var contrato = $("#tipo1").val();
            $("#m_kilometraje").val('0');
            $("#m_precio").val('0.00');
            $("#m_precio1").val('0');
            $("#m_alea").val(time);
            $("#m_contrato").val(contrato);
            $("#m_contrato").prop("disabled",true);
            $("#m_kilometraje").prop("disabled",false);
            $("#m_precio").prop("disabled",false);
            $("#eliminar1").prop("checked",false);
            //var boton = "<a href='#' name='lnk3' id='lnk3' onclick='subir1();'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
            var boton = "";
            $("#link2").html('');
            $("#link2").append(boton);
            $("#dialogo4").dialog("open");
            $("#dialogo4").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
          else
          {
            var detalle = "<center><h3>Fecha: "+fecha+" No Permitida</h3></center>";
            $("#dialogo2").html(detalle);
            $("#dialogo2").dialog("open");
            $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
        }
      }
      // Llantas
      if (v_tipo == "L")
      {
        $("#l_fecha").val(fecha);
        var inicio = $("#v_fecha1").val();
        var fin = $("#v_fecha2").val();
        var solicita = $("#total2").val();
        solicita = parseFloat(solicita);
        if (solicita == "0")
        {
          var detalle = "<center><h3>Valor Solicitado No Válido</h3></center>";
          $("#dialogo2").html(detalle);
          $("#dialogo2").dialog("open");
          $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          if (valida_fecha(inicio, fin, fecha1))
          {
            var hora = new Date();
            var time = hora.getHours()+""+hora.getMinutes()+""+hora.getSeconds();
            var contrato = $("#tipo1").val();           
            $("#l_kilometraje").val('0');
            $("#l_precio").val('0.00');
            $("#l_precio1").val('0');
            $("#l_alea").val(time);
            $("#l_contrato").val(contrato);          
            $("#l_contrato").prop("disabled",true);
            $("#l_kilometraje").prop("disabled",false);
            $("#l_precio").prop("disabled",false);
            $("#eliminar2").prop("checked",false);
            //var boton = "<a href='#' name='lnk4' id='lnk4' onclick='subir2();'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
            var boton = "";
            $("#link4").html('');
            $("#link4").append(boton);
            $("#dialogo7").dialog("open");
            $("#dialogo7").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
          else
          {
            var detalle = "<center><h3>Fecha: "+fecha+" No Permitida</h3></center>";
            $("#dialogo2").html(detalle);
            $("#dialogo2").dialog("open");
            $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
        }
      }
      // RTM
      if (v_tipo == "T")
      {
        $("#r_fecha").val(fecha);
        var inicio = $("#v_fecha1").val();
        var fin = $("#v_fecha2").val();
        var solicita = $("#total2").val();
        solicita = parseFloat(solicita);
        if (solicita == "0")
        {
          var detalle = "<center><h3>Valor Solicitado No Válido</h3></center>";
          $("#dialogo2").html(detalle);
          $("#dialogo2").dialog("open");
          $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          if (valida_fecha(inicio, fin, fecha1))
          {
            var hora = new Date();
            var time = hora.getHours()+""+hora.getMinutes()+""+hora.getSeconds();
            var contrato = $("#tipo1").val();           
            $("#r_kilometraje").val('0');
            $("#r_precio").val('0.00');
            $("#r_precio1").val('0');
            $("#r_alea").val(time);
            $("#r_contrato").val(contrato);          
            $("#r_contrato").prop("disabled",true);
            $("#r_kilometraje").prop("disabled",false);
            $("#r_precio").prop("disabled",false);
            $("#eliminar3").prop("checked",false);
            //var boton = "<a href='#' name='lnk5' id='lnk5' onclick='subir3();'><img src='dist/img/factura.png' width='30' height='30' border='0' title='Anexar Facturas'></a>";
            var boton = "";
            $("#link5").html('');
            $("#link5").append(boton);
            $("#dialogo10").dialog("open");
            $("#dialogo10").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
          else
          {
            var detalle = "<center><h3>Fecha: "+fecha+" No Permitida</h3></center>";
            $("#dialogo2").html(detalle);
            $("#dialogo2").dialog("open");
            $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
        }
      }
    },
    viewRender: function (view, element) {
      var inicio = view.start;
      var final = view.end;
      var tipo = $("#tipo").val();
      if (tipo == "C")
      {
        trae_eventos();
      }
      if (tipo == "M")
      {
        trae_eventos1();
      }
      if (tipo == "L")
      {
        trae_eventos2();
      }
      if (tipo == "T")
      {
        trae_eventos3();
      }
    },
    eventClick: function(event) {
      var id = event.id;
      var title = event.title;
      var var_ocu = title.split('\n');
      var var_ocu1 = var_ocu.length;
      for (var i=0; i<var_ocu1; i++)
      {
        title = title.replace("\n", "<br>");
      }
      var start = event.start;
      start = moment(start).format();
      $("#v_paso1").val(id);
      $("#v_paso2").val(start);
      var detalle = "<center><h3>"+title+"<br>Fecha: "+start+"</h3></center>";
      var tipo = $("#tipo").val();
      if (tipo == "C")
      {
        $("#dialogo3").html(detalle);
        $("#dialogo3").dialog("open");
        $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
      if (tipo == "M")
      {
        $("#dialogo6").html(detalle);
        $("#dialogo6").dialog("open");
        $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
      if (tipo == "L")
      {
        $("#dialogo9").html(detalle);
        $("#dialogo9").dialog("open");
        $("#dialogo9").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
      if (tipo == "T")
      {
        $("#dialogo12").html(detalle);
        $("#dialogo12").dialog("open");
        $("#dialogo12").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function trae_vehiculos()
{
  $("#clase").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_vehi.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "<option value='-'>- TODOS -</option>";
      var j = 0;
      for (var i in registros) 
      {
        j = j+1;
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#clase").append(salida);
    }
  });
}
function trae_eventos()
{
  $("#calendario").fullCalendar("removeEvents");
  var placa = $("#v_placa").val();
  placa = placa.trim();
  var fecha1 = $("#v_fecha1").val();
  var fecha2 = $("#v_fecha2").val();
  if (placa == "")
  {
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "tran_contra1.php",
      data:
      {
        placa: placa,
        fecha1: fecha1,
        fecha2: fecha2
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
        var salida = "";
        var total = registros.total;
        total = parseInt(total);
        var kilometros = registros.kilometros;
        $("#v_kilometros").val(kilometros);
        $("#v_odometro").val(registros.odometro);
        if (total > 0)
        {
          $.each(registros.rows, function (index, value)
          {
            var v1 = value.conse;
            var v2 = value.fecha;
            var v3 = value.consumo;
            var v4 = parseFloat(v3);
            var v5 = value.kilometraje;
            var v6 = parseFloat(v5);
            var v7 = formatNumber(v6);
            var v8 = value.valor;
            var v9 = value.contrato;
            var v10 = value.bonos;
            var informacion = "Cant. Galones: "+v4+"\nKilometraje: "+v7+"\nCant. Bonos: "+v10+"\nTotal: "+v8+"\nContrato: "+v9;
            var color = ["#0073b7", "#00c0ef", "#00718C", "#6633FF", "#CC3333", "#FF9966"];
            var rand = color[Math.floor(Math.random() * color.length)];
            var dato1 = {
              'id': +v1,
              'title': informacion,
              'start': v2,
              'allDay': true,
              'backgroundColor': rand,
              'borderColor': rand
            };
            $("#calendario").fullCalendar("renderEvent", dato1);
          });
        }
        calculo();
        $("#calendario").fullCalendar("render");
      }
    });
  }
}
// Mantenimientos
function trae_eventos1()
{
  $("#calendario").fullCalendar("removeEvents");
  var placa = $("#m_placa").val();
  placa = placa.trim();
  var fecha1 = $("#v_fecha1").val();
  var fecha2 = $("#v_fecha2").val();
  if (placa == "")
  {
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "tran_contram1.php",
      data:
      {
        placa: placa,
        fecha1: fecha1,
        fecha2: fecha2
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
        var salida = "";
        var total = registros.total;
        total = parseInt(total);
        var kilometros = registros.kilometros;
        $("#m_kilometros").val(kilometros);
        if (total > 0)
        {
          $.each(registros.rows, function (index, value)
          {
            var v1 = value.conse;
            var v2 = value.fecha;
            var v3 = value.kilometraje;
            var v4 = parseFloat(v3);
            var v5 = formatNumber(v4);
            var v6 = value.total;
            var v7 = value.contrato;
            var informacion = "Kilometraje: "+v5+"\nTotal: "+v6+"\nContrato: "+v7;
            var color = ["#0073b7", "#00c0ef", "#00718C", "#6633FF", "#CC3333", "#FF9966"];
            var rand = color[Math.floor(Math.random() * color.length)];
            var dato1 = {
              'id': +v1,
              'title': informacion,
              'start': v2,
              'allDay': true,
              'backgroundColor': rand,
              'borderColor': rand
            };
            $("#calendario").fullCalendar("renderEvent", dato1);
          });
        }
        calculo();
        $("#calendario").fullCalendar("render");
      }
    });
  }
}
// Llantas
function trae_eventos2()
{
  $("#calendario").fullCalendar("removeEvents");
  var placa = $("#l_placa").val();
  placa = placa.trim();
  var fecha1 = $("#v_fecha1").val();
  var fecha2 = $("#v_fecha2").val();
  if (placa == "")
  {
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "tran_contram2.php",
      data:
      {
        placa: placa,
        fecha1: fecha1,
        fecha2: fecha2
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
        var salida = "";
        var total = registros.total;
        total = parseInt(total);
        var kilometros = registros.kilometros;
        $("#l_kilometros").val(kilometros);
        if (total > 0)
        {
          $.each(registros.rows, function (index, value)
          {
            var v1 = value.conse;
            var v2 = value.fecha;
            var v3 = value.kilometraje;
            var v4 = parseFloat(v3);
            var v5 = formatNumber(v4);
            var v6 = value.total;
            var v7 = value.contrato;
            var informacion = "Kilometraje: "+v5+"\nTotal: "+v6+"\nContrato: "+v7;
            var color = ["#0073b7", "#00c0ef", "#00718C", "#6633FF", "#CC3333", "#FF9966"];
            var rand = color[Math.floor(Math.random() * color.length)];
            var dato1 = {
              'id': +v1,
              'title': informacion,
              'start': v2,
              'allDay': true,
              'backgroundColor': rand,
              'borderColor': rand
            };
            $("#calendario").fullCalendar("renderEvent", dato1);
          });
        }
        calculo();
        $("#calendario").fullCalendar("render");
      }
    });
  }
}
// RTM
function trae_eventos3()
{
  $("#calendario").fullCalendar("removeEvents");
  var placa = $("#r_placa").val();
  placa = placa.trim();
  var fecha1 = $("#v_fecha1").val();
  var fecha2 = $("#v_fecha2").val();
  if (placa == "")
  {
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "tran_contram3.php",
      data:
      {
        placa: placa,
        fecha1: fecha1,
        fecha2: fecha2
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
        var salida = "";
        var total = registros.total;
        total = parseInt(total);
        var kilometros = registros.kilometros;
        $("#r_kilometros").val(kilometros);
        if (total > 0)
        {
          $.each(registros.rows, function (index, value)
          {
            var v1 = value.conse;
            var v2 = value.fecha;
            var v3 = value.kilometraje;
            var v4 = parseFloat(v3);
            var v5 = formatNumber(v4);
            var v6 = value.total;
            var v7 = value.contrato;
            var informacion = "Kilometraje: "+v5+"\nTotal: "+v6+"\nContrato: "+v7;
            var color = ["#0073b7", "#00c0ef", "#00718C", "#6633FF", "#CC3333", "#FF9966"];
            var rand = color[Math.floor(Math.random() * color.length)];
            var dato1 = {
              'id': +v1,
              'title': informacion,
              'start': v2,
              'allDay': true,
              'backgroundColor': rand,
              'borderColor': rand
            };
            $("#calendario").fullCalendar("renderEvent", dato1);
          });
        }
        calculo();
        $("#calendario").fullCalendar("render");
      }
    });
  }
}
function trae_contratos()
{
  $("#tipo1").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_contrato.php",
    data:
    {
      tipo: $("#tipo").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
        var conse = registros[i].conse;
        var numero = registros[i].numero;
        salida += "<option value='"+conse+"'>"+numero+"</option>";
      }
      $("#tipo1").append(salida);
      var v_tipo = $("#tipo").val();
      if (v_tipo == "C")
      {
        $("#v_contrato").append(salida);
      }
      if (v_tipo == "M")
      {
        $("#m_contrato").append(salida);
      }
      if (v_tipo == "L")
      {
        $("#l_contrato").append(salida);
      }
      if (v_tipo == "T")
      {
        $("#r_contrato").append(salida);
      }
    }
  });
}
function paso_valor()
{
  var valor;
  valor = $("#v_precio").val();
  valor = parseFloat(valor.replace(/,/g,''));
  $("#v_precio1").val(valor);
}
function suma()
{
  var solicita = $("#total2").val();
  solicita = parseFloat(solicita);
  var relacionado = $("#total4").val();
  relacionado = parseFloat(relacionado);
  var precio = $("#v_precio1").val();
  precio = parseFloat(precio);
  var total1 = relacionado+precio;
  var total2 = solicita-total1;
  if (total2 < 0)
  {
    var total3 = total2*(-1);
    alerta("Valor Superior: "+total3);
    $("#aceptar1").hide();
  }
}
function valida_fecha(from, to, check)
{
  var fDate,lDate,cDate;
  fDate = Date.parse(from);
  lDate = Date.parse(to);
  cDate = Date.parse(check);
  if((cDate <= lDate && cDate >= fDate))
  {
    return true;
  }
  return false;
}
function valida_kilometro()
{
	var valor1 = $("#v_kilometraje").val();
	valor1 = parseFloat(valor1);
	var valor2 = $("#v_kilometros").val();
	valor2 = parseFloat(valor2);
  var odometro = $("#v_odometro").val();
	if (valor1 < valor2)
	{
    if (odometro == "1")
    {
      var valor3 = formatNumber(valor2);
      var detalle = "<center><h3>Esta seguro de reiniciar el valor del odómetro de "+valor3+" a "+valor1+" ?</h3></center>";
      $("#dialogo13").html(detalle);
      $("#dialogo13").dialog("open");
      $("#dialogo13").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      $("#aceptar1").hide();
    }
    else
    {
      alerta("Valor Kilometraje Inferior a: "+valor2);
      $("#aceptar1").hide();
    }
	}
	else
	{
		formatNumber1("v_kilometraje");
		$("#aceptar1").show();
	}
  suma();
}
function valida_kilometro1()
{
  var valor1 = $("#m_kilometraje").val();
  valor1 = parseFloat(valor1);
  var valor2 = $("#m_kilometros").val();
  valor2 = parseFloat(valor2);
  if (valor1 < valor2)
  {
    //alerta("Valor Kilometroje Inferior a: "+valor2);
    //$("#aceptar3").hide();
  }
  else
  {
    formatNumber1("m_kilometraje");
    $("#aceptar3").show();
  }
}
function valida_kilometro2()
{
  var valor1 = $("#l_kilometraje").val();
  valor1 = parseFloat(valor1);
  var valor2 = $("#l_kilometros").val();
  valor2 = parseFloat(valor2);
  if (valor1 < valor2)
  {
    //alerta("Valor Kilometroje Inferior a: "+valor2);
    //$("#aceptar5").hide();
  }
  else
  {
    formatNumber1("m_kilometraje");
    $("#aceptar5").show();
  }
}
function valida_kilometro3()
{
  var valor1 = $("#r_kilometraje").val();
  valor1 = parseFloat(valor1);
  var valor2 = $("#r_kilometros").val();
  valor2 = parseFloat(valor2);
  if (valor1 < valor2)
  {
    //alerta("Valor Kilometroje Inferior a: "+valor2);
    //$("#aceptar7").hide();
  }
  else
  {
    formatNumber1("r_kilometraje");
    $("#aceptar7").show();
  }
}
function valida_consumo()
{
  var valor = $("#v_consumo").val();
  var var_ocu = valor.split('.');
  var var_tam = var_ocu.length;
  if (var_tam == "1")
  {
  }
  else
  {
    var var_ocu0 = var_ocu[0];
    var var_ocu1 = var_ocu[1];
    var var_ocu2 = var_ocu1.charAt(0);
    var var_ocu3 = var_ocu1.charAt(1);
    var valor = var_ocu0+"."+var_ocu2+var_ocu3; 
    valor = parseFloat(valor);
    $("#v_consumo").val(valor);
  }
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de registrar el movimiento ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta1()
{
  var detalle = "<center><h3>Esta seguro de registrar el movimiento ?</h3></center>";
  $("#dialogo5").html(detalle);
  $("#dialogo5").dialog("open");
  $("#dialogo5").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta2()
{
  var detalle = "<center><h3>Esta seguro de registrar el movimiento ?</h3></center>";
  $("#dialogo8").html(detalle);
  $("#dialogo8").dialog("open");
  $("#dialogo8").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function pregunta3()
{
  var detalle = "<center><h3>Esta seguro de registrar el movimiento ?</h3></center>";
  $("#dialogo11").html(detalle);
  $("#dialogo11").dialog("open");
  $("#dialogo11").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function consultar()
{
  var tipo = $("#tipo").val();
  var tipo1 = $("#tipo1").val();
  var clase = $("#clase").val();
  var placa = $("#placa1").val();
  var numero = $("#v_paso4").val();
  var fecha1 = $("#v_fecha1").val();
  var fecha2 = $("#v_fecha2").val();
  var centraliza = $("#paso6").val();
  var adiciona = $("#adiciona").val();
  if (tipo1 === null)
  {
    var detalle = "<center><h3>No se encontraron Contrato(s) para este Tipo de Movimiento</h3></center>";
    $("#dialogo2").html(detalle);
    $("#dialogo2").dialog("open");
    $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "tran_contra.php",
      data:
      {
        tipo: tipo,
        tipo1: tipo1,
        clase: clase,
        placa: placa,
        numero: numero,
        fecha1: fecha1,
        fecha2: fecha2,
        adiciona: adiciona
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
          salida += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Veh&iacute;culos Encontrados: ( "+total+" )</b></td></tr></table>";
          salida += "<table width='100%' align='center' border='0'><tr><td width='5%' height='35'>&nbsp;</td><td width='15%' height='35'><b>Placa</b></td><td width='15%' height='35'><b>Clase</b></td><td width='15%' height='35'><b>Unidad</b></td><td width='20%' height='35'><b>Centro Costo</b></td><td width='20%' height='35'><b>&nbsp;</b></td>";
          salida += "</tr></table>";
          salida += "<table width='100%' align='center' border='1' id='a-table1'>";
          $.each(registros.rows, function (index, value)
          {
            if ((tipo == "C") || (tipo == "M") || (tipo == "L") || (tipo == "T"))
            {
              var var1 = index;
              var var2 = value.conse;
              var var3 = value.compania;
              var var4 = value.placa;
              var var5 = value.clase;
              var var6 = '\"'+var1+'\",\"'+var2+'\",\"'+var3+'\",\"'+var4+'\",\"'+var5+'\"';
              salida += "<tr><td width='5%' height='35' id='l1_"+var1+"'><center><input type='checkbox' name='seleccionados[]' id='chk_"+var1+"' value='"+var6+"' onclick='trae_marca1("+var6+");'></center></td>";
              salida += "<td width='15%' height='35' id='l2_"+var1+"'>"+value.placa+"</td>";
              salida += "<td width='15%' height='35' id='l3_"+var1+"'>"+value.clase+"</td>";
              salida += "<td width='15%' height='35' id='l4_"+var1+"'>"+value.compania+"</td>";
              salida += "<td width='20%' height='35' id='l5_"+var1+"'>"+value.costo+"</td>";
              salida += "<td width='20%' height='35' id='l7_"+var1+"'>&nbsp;</td>";
            }
          });
          salida += "</table>";
          $("#datos").append(salida);
          $("#tipo").prop("disabled",true);
          $("#tipo1").prop("disabled",true);
          $("#clase").prop("disabled",true);
          $("#placa1").prop("disabled",true);
          $("#unidades1").prop("disabled",true);
          $("#aceptar").hide();
          if ((tipo == "C") || (tipo == "M") || (tipo == "L") || (tipo == "T"))
          {
            $("#datos2").show();
            var combustible = registros.combustible;
            combustible = parseFloat(combustible);
            var combustible1 = combustible.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            $("#total1").val(combustible1);
            $("#total2").val(combustible);
          }
          else
          {
            $("#datos2").hide();
          }
        }
        else
        {
          var detalle = "<center><h3>No se encontraron Vehículo(s) para este Tipo de Movimiento</h3></center>";
          $("#dialogo2").html(detalle);
          $("#dialogo2").dialog("open");
          $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
      }
    });
  }
}
function trae_marca1(valor, valor1, valor2, valor3, valor4)
{
  var valor, valor1, valor2, valor3, valor4, valor5;
  valor5 = par_impar(valor);
  $("#v_placa").val(valor3);
  $("#m_placa").val(valor3);
  $("#l_placa").val(valor3);
  $("#r_placa").val(valor3);
  $("input[name='seleccionados[]']").each(
    function ()
    {
      $(this).prop("checked", false);
      var nombre = $(this).attr("id");
      var var_ocu = nombre.split('_');
      var numero = var_ocu[1];
      var valor6 = par_impar(numero);
      if (valor6 == "1")
      {
        $("#l1_"+numero).css("background-color","#FFFFFF");
        $("#l2_"+numero).css("background-color","#FFFFFF");
      }
      else
      {
        $("#l1_"+numero).css("background-color","#CECECE");
        $("#l2_"+numero).css("background-color","#CECECE");
      }
    }
  );
  $("#chk_"+valor).prop("checked", true);
  if ($("#chk_"+valor).is(":checked"))
  {
    $("#l1_"+valor).css("background-color","#FFFF00");
    $("#l2_"+valor).css("background-color","#FFFF00");
  }
  else
  {
    if (valor5 == "1")
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
  if (tipo == "C")
  {
    contador();
  }
  else
  {
    if (tipo == "M")
    {
      trae_datos();
    }
    else
    {
      if (tipo == "L")
      {
        trae_datos1();
      }
      else
      {
	      if (tipo == "T")
	      {
	        trae_datos2();
	      }
      }
    }
  }
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
        var paso3 = var_ocu[2];
        var paso4 = var_ocu[3];
        var paso5 = var_ocu[4];
        seleccionadosarray.push(paso1);
      }
    }
  );
  var valida = seleccionadosarray.length;
  if (valida == "0")
  {
    detalle = "<center><h3>Debe seleccionar mínimo un Vehículo</h3></center>";
    $("#dialogo2").html(detalle);
    $("#dialogo2").dialog("open");
    $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#datos1").hide();
  }
  else
  {
    var tipo = $("#tipo").val();
    if ((tipo == "C") || (tipo == "M") || (tipo == "L") || (tipo == "T"))
    {
      if (tipo == "C")
      {
        trae_eventos();
      }
      if (tipo == "M")
      {
        trae_eventos1();
      }
      if (tipo == "L")
      {
        trae_eventos2();
      }
      if (tipo == "T")
      {
        trae_eventos3();
      }
      $("#datos1").show();
    }
    else
    {
      $("#datos1").hide();
    }
  }
}
// Mantenimientos
function trae_datos()
{
  var placa = $("#m_placa").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_vehiculos4.php",
    data:
    {
      placa: placa
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
      var tipo = registros.tipo;
      var clase = registros.clase;
      var marca = registros.marca;
      var linea = registros.linea;
      var modelo = registros.modelo;
      var datos = registros.datos;
      if (datos == null)
      {
        alerta("Repuestos no encontrados para vehículo marca "+marca+" linea "+linea);
      }
      var var_ocu = datos.split('#');
      var var_ocu1 = var_ocu.length;
      var salida = "<option value='0,0,0,0'>- SELECCIONAR -</option>";
      for (var i=0; i<var_ocu1-1; i++)
      {
        var paso = var_ocu[i];
        var var_ocu2 = paso.split('|');
        var var_ocu3 = var_ocu2.length;
        for (var j=0; j<var_ocu3-1; j++)
        {
          var v1 = var_ocu2[0];
          var v2 = var_ocu2[1];
          var v3 = var_ocu2[2];
          var v4 = var_ocu2[3];
          var v5 = var_ocu2[4];
          var v6 = var_ocu2[5];
          var v7 = var_ocu2[6];
          var v8 = var_ocu2[7];
          var v9 = var_ocu2[8];
          var v10 = v1+","+v6+","+v7+","+v8;
          var v11 = parseFloat(v8);
          v11 = v11.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
        salida += "<option value='"+v10+"' title='"+v11+"'>"+v2+" - "+v9+"</option>";
      }
      $("#v_paso6").val(salida);
      $("#m_tipo").val(tipo);
      $("#m_clase").val(clase);
      $("#m_marca").val(marca);
      $("#m_linea").val(linea);
      $("#m_modelo").val(modelo);
      contador();
    }
  });
}
// Llantas
function trae_datos1()
{
  var placa = $("#l_placa").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_vehiculos5.php",
    data:
    {
      placa: placa
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
      var tipo = registros.tipo;
      var clase = registros.clase;
      var marca = registros.marca;
      var linea = registros.linea;
      var modelo = registros.modelo;
      var datos = registros.datos;
      var var_ocu = datos.split('#');
      var var_ocu1 = var_ocu.length;
      var salida = "<option value='0,0,0,0'>- SELECCIONAR -</option>";
      for (var i=0; i<var_ocu1-1; i++)
      {
        var paso = var_ocu[i];
        var var_ocu2 = paso.split('|');
        var var_ocu3 = var_ocu2.length;
        for (var j=0; j<var_ocu3-1; j++)
        {
          var v1 = var_ocu2[0];
          var v2 = var_ocu2[1];
          var v3 = var_ocu2[2];
          var v4 = var_ocu2[3];
          var v5 = var_ocu2[4];
          var v6 = var_ocu2[5];
          var v7 = v1+","+v4+","+v5+","+v6;
          var v8 = parseFloat(v6);
          v8 = v8.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
        salida += "<option value='"+v7+"' title='"+v8+"'>"+v3+"</option>";
      }
      $("#v_paso8").val(salida);
      $("#l_tipo").val(tipo);
      $("#l_clase").val(clase);
      $("#l_marca").val(marca);
      $("#l_linea").val(linea);
      $("#l_modelo").val(modelo);
      contador();
    }
  });
}
// RTM
function trae_datos2()
{
  var placa = $("#r_placa").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_vehiculos6.php",
    data:
    {
      placa: placa
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
      var tipo = registros.tipo;
      var clase = registros.clase;
      var marca = registros.marca;
      var linea = registros.linea;
      var modelo = registros.modelo;
      var datos = registros.datos;
      var var_ocu = datos.split('#');
      var var_ocu1 = var_ocu.length;
      var salida = "<option value='0,0,0,0'>- SELECCIONAR -</option>";
      for (var i=0; i<var_ocu1-1; i++)
      {
        var paso = var_ocu[i];
        var var_ocu2 = paso.split('|');
        var var_ocu3 = var_ocu2.length;
        for (var j=0; j<var_ocu3-1; j++)
        {
          var v1 = var_ocu2[0];
          var v2 = var_ocu2[1];
          var v3 = var_ocu2[2];
          var v4 = var_ocu2[3];
          var v5 = var_ocu2[4];
          var v6 = v1+","+v3+","+v4+","+v5;
        }
        salida += "<option value='"+v6+"'>"+v2+"</option>";
      }
      $("#v_paso10").val(salida);
      $("#r_tipo").val(tipo);
      $("#r_clase").val(clase);
      $("#r_marca").val(marca);
      $("#r_linea").val(linea);
      $("#r_modelo").val(modelo);
      contador();
    }
  });
}
function cargam(valor)
{
  var valor, valor1;
  valor1 = $("#man_"+valor).val();
  var var_ocu = valor1.split(',');
  var v1 = var_ocu[0];
  var v2 = var_ocu[1];
  v2 = parseFloat(v2);
  v2 = v2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  var v3 = var_ocu[2];
  v3 = parseFloat(v3);
  v3 = v3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  var v4 = var_ocu[3];
  v4 = parseFloat(v4);
  v4 = v4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#cam_"+valor).val('0');
  $("#val_"+valor).val(v2);
  $("#iva_"+valor).val(v3);
  $("#tot_"+valor).val(v4);
  cargan(valor);
  suma_man();
}
function cargan(valor)
{
  var valor, valor1, valor2, valor3, valor4, valor5;
  valor1 = $("#cam_"+valor).val();
  valor2 = $("#man_"+valor).val();
  var var_ocu = valor2.split(',');
  var v1 = var_ocu[0];
  var v2 = var_ocu[1];
  var v3 = var_ocu[2];
  var v4 = var_ocu[3];
  v2 = parseFloat(v2);
  v3 = parseFloat(v3);
  valor3 = valor1*v3;
  valor4 = valor3;
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#iva_"+valor).val(valor3);
  valor5 = (valor1*v2)+valor4;
  valor5 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#tot_"+valor).val(valor5);
  suma_man();
}
function valiman(valor)
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7;
  valor1 = $("#cam_"+valor).val();
  valor1 = parseFloat(valor1);
  valor2 = $("#val_"+valor).val();
  valor3 = parseFloat(valor2.replace(/,/g,''));
  if (valor1 > 0)
  {
    valor4 = ((valor3*valor1)*(0.19));
    valor4 = parseFloat(valor4);
    valor5 = ((valor3*valor1)*(1.19));
    valor5 = parseFloat(valor5);
    valor6 = valor4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    valor7 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $("#iva_"+valor).val(valor6);
    $("#tot_"+valor).val(valor7);
  }
  suma_man();
}
function cargal(valor)
{
  var valor, valor1;
  valor1 = $("#lla_"+valor).val();
  var var_ocu = valor1.split(',');
  var v1 = var_ocu[0];
  var v2 = var_ocu[1];
  v2 = parseFloat(v2);
  v2 = v2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  var v3 = var_ocu[2];
  v3 = parseFloat(v3);
  v3 = v3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  var v4 = var_ocu[3];
  v4 = parseFloat(v4);
  v4 = v4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#cal_"+valor).val('0');
  $("#lal_"+valor).val(v2);
  $("#ivl_"+valor).val(v3);
  $("#tol_"+valor).val(v4);
  cargap(valor);
  suma_lla();
}
function valilla(valor)
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7;
  valor1 = $("#cal_"+valor).val();
  valor1 = parseFloat(valor1);
  valor2 = $("#lal_"+valor).val();
  valor3 = parseFloat(valor2.replace(/,/g,''));
  if (valor1 > 0)
  {
    valor4 = ((valor3*valor1)*(0.19));
    valor4 = parseFloat(valor4);
    valor5 = ((valor3*valor1)*(1.19));
    valor5 = parseFloat(valor5);
    valor6 = valor4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    valor7 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $("#ivl_"+valor).val(valor6);
    $("#tol_"+valor).val(valor7);
  }
  suma_lla();
}
function cargap(valor)
{
  var valor, valor1, valor2, valor3, valor4, valor5;
  valor1 = $("#cal_"+valor).val();
  valor2 = $("#lla_"+valor).val();
  var var_ocu = valor2.split(',');
  var v1 = var_ocu[0];
  var v2 = var_ocu[1];
  var v3 = var_ocu[2];
  var v4 = var_ocu[3];
  v2 = parseFloat(v2);
  v3 = parseFloat(v3);
  valor3 = valor1*v3;
  valor4 = valor3;
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#ivl_"+valor).val(valor3);
  valor5 = (valor1*v2)+valor4;
  valor5 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#tol_"+valor).val(valor5);
  suma_lla();
}
function cargat(valor)
{
  var valor, valor1;
  valor1 = $("#rtm_"+valor).val();
  var var_ocu = valor1.split(',');
  var v1 = var_ocu[0];
  var v2 = var_ocu[1];
  v2 = parseFloat(v2);
  v2 = v2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  var v3 = var_ocu[2];
  v3 = parseFloat(v3);
  v3 = v3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  var v4 = var_ocu[3];
  v4 = parseFloat(v4);
  v4 = v4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#cat_"+valor).val('1');
  $("#lat_"+valor).val(v2);
  $("#ivt_"+valor).val(v3);
  $("#tor_"+valor).val(v4);
  $("#ter_"+valor).val(v4);
  suma_rtm();
}
function paso_rtm(valor)
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7;
  valor1 = document.getElementById('lat_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  valor2 = document.getElementById('ivt_'+valor).value;
  valor2 = parseFloat(valor2.replace(/,/g,''));
  valor3 = valor1+valor2;
  valor4 = parseFloat(valor3);
  valor4 = valor4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#tor_"+valor).val(valor4);
  suma_rtm();
  valor5 = document.getElementById('ter_'+valor).value;
  valor5 = parseFloat(valor5.replace(/,/g,''));
  valor6 = document.getElementById('ter_'+valor).value;
  valor7 = valor5-valor3;
  if (valor7 < 0)
  {
    alerta("Valor Superior a Techo: "+valor6);
    $("#aceptar7").hide();
  }
  else
  {
    $("#aceptar7").show();
  }
}
function suma_man()
{
  var valor = 0;
  var valor1 = 0;
  for (i=0;i<document.formu3.elements.length;i++)
  {
    saux = document.formu3.elements[i].name;
    if (saux.indexOf('tot_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor.replace(/,/g,''));
      valor1 = valor1+valor;
    }
  }
  var valor2 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#m_precio").val(valor2);
  $("#m_precio1").val(valor1);
  // Validacion valor x ejecutar
  var actu = $("#m_actu").val();
  if (actu == "1")
  {
    var solicita = $("#total2").val();
    solicita = parseFloat(solicita);
    var relacionado = $("#total4").val();
    relacionado = parseFloat(relacionado);
    var precio = $("#m_precio1").val();
    precio = parseFloat(precio);
    var total1 = relacionado-precio;
    if (total1 < 0)
    {
      total1 = total1*(-1);
    }
    total1 = relacionado+total1;
    var total2 = solicita-total1;
    if (total2 < 0)
    {
      var total3 = total2*(-1);
      //alerta("Valor Superior: "+total3);
      $("#aceptar3").hide();
    }
    else
    {
      $("#aceptar3").show();
    }
  }
  else
  {
	  var solicita = $("#total2").val();
	  solicita = parseFloat(solicita);
	  var relacionado = $("#total4").val();
	  relacionado = parseFloat(relacionado);
	  var precio = $("#m_precio1").val();
	  precio = parseFloat(precio);
	  var total1 = relacionado+precio;
	  var total2 = solicita-total1;
	  if (total2 < 0)
	  {
	    var total3 = total2*(-1);
	    alerta("Valor Superior: "+total3);
	    $("#aceptar3").hide();
	  }
	  else
	  {
	    $("#aceptar3").show();
	  }
	}
}
function suma_lla()
{
  var valor = 0;
  var valor1 = 0;
  for (i=0;i<document.formu4.elements.length;i++)
  {
    saux = document.formu4.elements[i].name;
    if (saux.indexOf('tol_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor.replace(/,/g,''));
      valor1 = valor1+valor;
    }
  }
  var valor2 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#l_precio").val(valor2);
  $("#l_precio1").val(valor1);
  // Validacion valor x ejecutar
  var solicita = $("#total2").val();
  solicita = parseFloat(solicita);
  var relacionado = $("#total4").val();
  relacionado = parseFloat(relacionado);
  var precio = $("#l_precio1").val();
  precio = parseFloat(precio);
  var total1 = relacionado+precio;
  var total2 = solicita-total1;
  if (total2 < 0)
  {
    var total3 = total2*(-1);
    alerta("Valor Superior: "+total3);
    $("#aceptar5").hide();
  }
  else
  {
    $("#aceptar5").show();
  }
}
function suma_rtm()
{
  var valor = 0;
  var valor1 = 0;
  for (i=0;i<document.formu5.elements.length;i++)
  {
    saux = document.formu5.elements[i].name;
    if (saux.indexOf('tor_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor.replace(/,/g,''));
      valor1 = valor1+valor;
    }
  }
  var valor2 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#r_precio").val(valor2);
  $("#r_precio1").val(valor1);
  // Validacion valor x ejecutar
  var solicita = $("#total2").val();
  solicita = parseFloat(solicita);
  var relacionado = $("#total4").val();
  relacionado = parseFloat(relacionado);
  var precio = $("#r_precio1").val();
  precio = parseFloat(precio);
  var total1 = relacionado+precio;
  var total2 = solicita-total1;
  if (total2 < 0)
  {
    var total3 = total2*(-1);
    alerta("Valor Superior: "+total3);
    $("#aceptar7").hide();
  }
  else
  {
    $("#aceptar7").show();
  }
}
function valida_archivos()
{
  var placa = $("#v_placa").val();
  var fecha = $("#v_fecha").val();
  fecha = fecha.replace("-", "");
  fecha = fecha.replace("-", "");
  var alea = $("#v_alea").val();
  var borrar = "0";
  if ($("#eliminar").is(":checked"))
  {
    borrar = "1";
  }
  if (borrar == "1")
  {
    nuevo();
  }
  else
  {
    var salida = true;
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_archivos2.php",
      data:
      {
        placa: placa,
        fecha: fecha,
        alea: alea
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
          var detalle = "<center><h3>Debe Anexar Factura</h3></center>";
          $("#dialogo2").html(detalle);
          $("#dialogo2").dialog("open");
          $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          var precio = $("#v_precio").val();
          if ((precio == "") || (precio == "0") || (precio == "0.0") || (precio == "0.00"))
          {
            salida = false;
            var detalle = "Valor Entregado No Válido";
            alerta(detalle);
          }
          var bonos = $("#v_bonos").val();
          if ((bonos == "") || (bonos == "0") || (bonos == "0.0") || (bonos == "0.00"))
          {
            salida = false;
            var detalle = "Cantidad de Bonos No Válido";
            alerta(detalle);
          }
          var consumo = $("#v_consumo").val();
          if ((consumo == "") || (consumo == "0") || (consumo == "0.0") || (consumo == "0.00"))
          {
            salida = false;
            var detalle = "Cantidad de Galones No Válido";
            alerta(detalle);
          }
          var kilometraje = $("#v_kilometraje").val();
          if ((kilometraje == "") || (kilometraje == "0") || (kilometraje == "0.0"))
          {
            salida = false;
            var detalle = "Kilometraje No Válido";
            alerta(detalle);
          }
          if (salida == false)
          {
          }
          else
          {
            nuevo();
          }
        }
      }
    });
  }
}
function valida_archivos1()
{
  var salida = true;
  var kilometraje = $("#m_kilometraje").val();
  kilometraje = parseFloat(kilometraje);
  if ((kilometraje == "0") || (kilometraje == "0.00"))
  {
    if ($("#eliminar1").is(":checked"))
    {
    }
    else
    {
      //salida = false;
      //alerta("Kilometraje No Válido...");
    }
  }
  var v_cam = 0;
  for (i=0;i<document.formu3.elements.length;i++)
  {
    saux = document.formu3.elements[i].name;
    if (saux.indexOf('cam_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      valor1 = document.getElementById(saux).value;
      if ((valor == "0") || (valor1 == "0"))
      {
        v_cam ++;
      }
    }
  }
  if (v_cam > 0)
  {
    salida = false;
    alerta("Debe ingresar "+v_cam+" cantidad(es)...");
  }
  if (salida == false)
  {
  }
  else
  {
    var placa = $("#m_placa").val();
    var fecha = $("#m_fecha").val();
    fecha = fecha.replace("-", "");
    fecha = fecha.replace("-", "");
    var alea = $("#m_alea").val();
    var borrar = "0";
    if ($("#eliminar1").is(":checked"))
    {
      borrar = "1";
    }
    if (borrar == "1")
    {
      nuevo1();
    }
    else
    {
      nuevo1();
      /*
      $.ajax({
        type: "POST",
        datatype: "json",
        url: "trae_archivos3.php",
        data:
        {
          placa: placa,
          fecha: fecha,
          alea: alea
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
            var detalle = "<center><h3>Debe Anexar Factura</h3></center>";
            $("#dialogo2").html(detalle);
            $("#dialogo2").dialog("open");
            $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
          else
          {
            nuevo1();
          }
        }
      });
      */
    }
  }
}
function valida_archivos2()
{
  var salida = true;
  var kilometraje = $("#l_kilometraje").val();
  kilometraje = parseFloat(kilometraje);
  if ((kilometraje == "0") || (kilometraje == "0.00"))
  {
    if ($("#eliminar2").is(":checked"))
    {
    }
    else
    {
      //salida = false;
      //alerta("Kilometraje No Válido...");
    }
  }
  var v_cal = 0;
  for (i=0;i<document.formu4.elements.length;i++)
  {
    saux = document.formu4.elements[i].name;
    if (saux.indexOf('cal_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      valor1 = document.getElementById(saux).value;
      if ((valor == "0") || (valor1 == "0"))
      {
        v_cal ++;
      }
    }
  }
  if (v_cal > 0)
  {
    salida = false;
    alerta("Debe ingresar "+v_cal+" cantidad(es)...");
  }
  var v_mal = 0;
  for (i=0;i<document.formu4.elements.length;i++)
  {
    saux = document.formu4.elements[i].name;
    if (saux.indexOf('mal_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_mal ++;
      }
    }
  }
  if (v_mal > 0)
  {
    salida = false;
    alerta("Debe ingresar "+v_mal+" marca(s)...");
  }
  if (salida == false)
  {
  }
  else
  {
    var placa = $("#l_placa").val();
    var fecha = $("#l_fecha").val();
    fecha = fecha.replace("-", "");
    fecha = fecha.replace("-", "");
    var alea = $("#l_alea").val();
    var borrar = "0";
    if ($("#eliminar2").is(":checked"))
    {
      borrar = "1";
    }
    if (borrar == "1")
    {
      nuevo2();
    }
    else
    {
      nuevo2();
      /*
      $.ajax({
        type: "POST",
        datatype: "json",
        url: "trae_archivos4.php",
        data:
        {
          placa: placa,
          fecha: fecha,
          alea: alea
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
            var detalle = "<center><h3>Debe Anexar Factura</h3></center>";
            $("#dialogo2").html(detalle);
            $("#dialogo2").dialog("open");
            $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
          else
          {
            nuevo2();
          }
        }
      });
      */
    }
  }
}
function valida_archivos3()
{
  var salida = true;
  var kilometraje = $("#r_kilometraje").val();
  kilometraje = parseFloat(kilometraje);
  if ((kilometraje == "0") || (kilometraje == "0.00"))
  {
    if ($("#eliminar3").is(":checked"))
    {
    }
    else
    {
      //salida = false;
      //alerta("Kilometraje No Válido...");
    }
  }
	var v_cda = 0;
	for (i=0;i<document.formu5.elements.length;i++)
	{
		saux = document.formu5.elements[i].name;
		if (saux.indexOf('cda_')!=-1)
		{
			valor = document.getElementById(saux).value.trim().length;
			if (valor == "0")
			{
				v_cda ++;
			}
		}
	}
	if (v_cda > 0)
	{
		salida = false;
		alerta("Debe ingresar "+v_cda+" CDA...");
	}
  if (salida == false)
  {
  }
  else
  {
    var placa = $("#r_placa").val();
    var fecha = $("#r_fecha").val();
    fecha = fecha.replace("-", "");
    fecha = fecha.replace("-", "");
    var alea = $("#r_alea").val();
    var borrar = "0";
    if ($("#eliminar3").is(":checked"))
    {
      borrar = "1";
    }
    if (borrar == "1")
    {
      nuevo3();
    }
    else
    {
      nuevo3();
      /*
      $.ajax({
        type: "POST",
        datatype: "json",
        url: "trae_archivos5.php",
        data:
        {
          placa: placa,
          fecha: fecha,
          alea: alea
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
            var detalle = "<center><h3>Debe Anexar Factura</h3></center>";
            $("#dialogo2").html(detalle);
            $("#dialogo2").dialog("open");
            $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
          else
          {
            nuevo3();
          }
        }
      });
      */
    }
  }
}
function nuevo()
{
  var tipo = $("#tipo").val();
  var tipo1 = $("#tipo1").val();
  var placa = $("#v_placa").val();
  var fecha = $("#v_fecha").val();
  var contrato = $("#v_contrato").val();
  var contrato1 = $("#v_contrato option:selected").html();
  var kilometraje = $("#v_kilometraje").val();
  var kilometraje1 = formatNumber(kilometraje);
  var consumo = $("#v_consumo").val();
  var bonos = $("#v_bonos").val();
  var precio = $("#v_precio").val();
  var precio1 = $("#v_precio1").val();
  var alea = $("#v_alea").val();
  var elaboro = $("#elaboro").val();
  var borrar = "0";
  if ($("#eliminar").is(":checked"))
  {
    borrar = "1";
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_grab6.php",
    data:
    {
      tipo: tipo,
      tipo1: tipo1,
      placa: placa,
      fecha: fecha,
      contrato: contrato,
      contrato1: contrato1,
      kilometraje: kilometraje,
      consumo: consumo,
      bonos: bonos,
      precio: precio,
      precio1: precio1,
      alea: alea,
      elaboro: elaboro,
      borrar: borrar
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
      var conse = registros.conse;
      var id = registros.id;
      if (salida == "1")
      {
        $("#aceptar").hide();
        $("#v_kilometraje").prop("disabled",true);
        $("#v_consumo").prop("disabled",true);
        $("#v_bonos").prop("disabled",true);
        $("#dialogo").dialog("close");
        if (id == "0")
        {
        }
        else
        {
          if (borrar == "1")
          {
          	trae_eventos();
            //$("#calendario").fullCalendar("removeEvents", id);
          }
        }
        var informacion = "Cant. Galones: "+consumo+"\nKilometraje: "+kilometraje1+"\nCant. Bonos: "+bonos+"\nTotal: "+precio+"\nContrato: "+contrato1;
        var color = ["#0073b7", "#00c0ef", "#00718C", "#6633FF", "#CC3333", "#FF9966"];
        var rand = color[Math.floor(Math.random() * color.length)];
        var dato1 = {
          'id': +conse,
          'title': informacion,
          'start': fecha,
          'allDay': true,
          'backgroundColor': rand,
          'borderColor': rand
        };
        if (borrar == "0")
        {
          $("#calendario").fullCalendar("renderEvent", dato1);
        }
        calculo();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
        $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function nuevo1()
{
  var tipo = $("#tipo").val();
  var tipo1 = $("#tipo1").val();
  var placa = $("#m_placa").val();
  var fecha = $("#m_fecha").val();
  var contrato = $("#m_contrato").val();
  var contrato1 = $("#m_contrato option:selected").html();
  var kilometraje = $("#m_kilometraje").val();
  var kilometraje1 = formatNumber(kilometraje);
  var precio = $("#m_precio").val();
  var precio1 = $("#m_precio1").val();
  var alea = $("#m_alea").val();
  var interno = $("#m_registro").val();
  var elaboro = $("#elaboro").val();
  var borrar = "0";
  if ($("#eliminar1").is(":checked"))
  {
    borrar = "1";
  }
  document.getElementById('v_paso7').value="";
  for (i=0;i<document.formu3.elements.length;i++)
  {
    saux = document.formu3.elements[i].name;
    if (saux.indexOf('man_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux0 = document.formu3.elements[i].name;
    if (saux0.indexOf('cam_')!=-1)
    {
      valor0 = document.getElementById(saux).value;
    }
    saux1 = document.formu3.elements[i].name;
    if (saux1.indexOf('val_')!=-1)
    {
      valor1 = document.getElementById(saux).value;
    }
    saux2 = document.formu3.elements[i].name;
    if (saux2.indexOf('iva_')!=-1)
    {
      valor2 = document.getElementById(saux1).value;
    }
    saux3 = document.formu3.elements[i].name;
    if (saux3.indexOf('tot_')!=-1)
    {
      valor3 = document.getElementById(saux1).value;
      valor4 = valor+"»"+valor0+"»"+valor1+"»"+valor2+"»"+valor3;
      document.getElementById('v_paso7').value = document.getElementById('v_paso7').value+valor4+"|";
    }
  }
  var valores = $("#v_paso7").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_grab7.php",
    data:
    {
      tipo: tipo,
      tipo1: tipo1,
      placa: placa,
      fecha: fecha,
      contrato: contrato,
      contrato1: contrato1,
      kilometraje: kilometraje,
      precio: precio,
      precio1: precio1,
      alea: alea,
      interno: interno,
      elaboro: elaboro,
      borrar: borrar,
      valores: valores
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
      var conse = registros.conse;
      var id = registros.id;
      if (salida == "1")
      {
        $("#aceptar").hide();
        $("#m_kilometraje").prop("disabled",true);
        var kilometraje2 = kilometraje1.replace(/[.]+/g, "");
        kilometraje2 = parseFloat(kilometraje2);
        $("#m_kilometros").val(kilometraje2);
        //if (id == "0")
        //{
        //}
        //else
        //{
        //  if (borrar == "1")
        //  {
        //  	trae_eventos1();
        //    $("#calendario").fullCalendar("removeEvents", id);
        //  }
        //}
        //var informacion = "Kilometraje: "+kilometraje1+"\nTotal: "+precio+"\nContrato: "+contrato1;
        //var color = ["#0073b7", "#00c0ef", "#00718C", "#6633FF", "#CC3333", "#FF9966"];
        //var rand = color[Math.floor(Math.random() * color.length)];
        //var dato1 = {
        //  'id': +conse,
        //  'title': informacion,
        //  'start': fecha,
        //  'allDay': true,
        //  'backgroundColor': rand,
        //  'borderColor': rand
        //};
        //if (borrar == "0")
        //{
        //  $("#calendario").fullCalendar("renderEvent", dato1);
        //}
        trae_eventos1();
        for (j=1;j<=50;j++)
        {
          if ($("#dem_"+j).length)
          {
            $("#dem_"+j).click();
          }
        }
        $("#m_actu").val('0')
        $("#dialogo4").dialog("close");
        calculo();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
        $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function nuevo2()
{
  var tipo = $("#tipo").val();
  var tipo1 = $("#tipo1").val();
  var placa = $("#l_placa").val();
  var fecha = $("#l_fecha").val();
  var contrato = $("#l_contrato").val();
  var contrato1 = $("#l_contrato option:selected").html();
  var kilometraje = $("#l_kilometraje").val();
  var kilometraje1 = formatNumber(kilometraje);
  var precio = $("#l_precio").val();
  var precio1 = $("#l_precio1").val();
  var alea = $("#l_alea").val();
  var elaboro = $("#elaboro").val();
  var borrar = "0";
  if ($("#eliminar2").is(":checked"))
  {
    borrar = "1";
  }
  document.getElementById('v_paso9').value="";
  for (i=0;i<document.formu4.elements.length;i++)
  {
    saux = document.formu4.elements[i].name;
    if (saux.indexOf('lla_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux0 = document.formu4.elements[i].name;
    if (saux0.indexOf('mal_')!=-1)
    {
      valor0 = document.getElementById(saux).value;
    }
    saux1 = document.formu4.elements[i].name;
    if (saux1.indexOf('cal_')!=-1)
    {
      valor1 = document.getElementById(saux).value;
    }
    saux2 = document.formu4.elements[i].name;
    if (saux2.indexOf('lal_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
    }
    saux3 = document.formu4.elements[i].name;
    if (saux3.indexOf('ivl_')!=-1)
    {
      valor3 = document.getElementById(saux1).value;
    }
    saux4 = document.formu4.elements[i].name;
    if (saux4.indexOf('tol_')!=-1)
    {
      valor4 = document.getElementById(saux1).value;
      valor5 = valor+"»"+valor0+"»"+valor1+"»"+valor2+"»"+valor3+"»"+valor4;
      document.getElementById('v_paso9').value = document.getElementById('v_paso9').value+valor5+"|";
    }
  }
  var valores = $("#v_paso9").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_grab8.php",
    data:
    {
      tipo: tipo,
      tipo1: tipo1,
      placa: placa,
      fecha: fecha,
      contrato: contrato,
      contrato1: contrato1,
      kilometraje: kilometraje,
      precio: precio,
      precio1: precio1,
      alea: alea,
      elaboro: elaboro,
      borrar: borrar,
      valores: valores
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
      var conse = registros.conse;
      var id = registros.id;
      if (salida == "1")
      {
        $("#aceptar").hide();
        $("#l_kilometraje").prop("disabled",true);
        var kilometraje2 = kilometraje1.replace(/[.]+/g, "");
        kilometraje2 = parseFloat(kilometraje2);
        $("#l_kilometros").val(kilometraje2);
        if (id == "0")
        {
        }
        else
        {
          if (borrar == "1")
          {
          	trae_eventos2();
            //$("#calendario").fullCalendar("removeEvents", id);
          }
        }
        var informacion = "Kilometraje: "+kilometraje1+"\nTotal: "+precio+"\nContrato: "+contrato1;
        var color = ["#0073b7", "#00c0ef", "#00718C", "#6633FF", "#CC3333", "#FF9966"];
        var rand = color[Math.floor(Math.random() * color.length)];
        var dato1 = {
          'id': +conse,
          'title': informacion,
          'start': fecha,
          'allDay': true,
          'backgroundColor': rand,
          'borderColor': rand
        };
        if (borrar == "0")
        {
          $("#calendario").fullCalendar("renderEvent", dato1);
        }
        for (j=1;j<=50;j++)
        {
          if ($("#del_"+j).length)
          {
            $("#del_"+j).click();
          }
        }
        $("#dialogo7").dialog("close");
        calculo();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
        $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function nuevo3()
{
  var tipo = $("#tipo").val();
  var tipo1 = $("#tipo1").val();
  var placa = $("#r_placa").val();
  var fecha = $("#r_fecha").val();
  var contrato = $("#r_contrato").val();
  var contrato1 = $("#r_contrato option:selected").html();
  var kilometraje = $("#r_kilometraje").val();
  var kilometraje1 = formatNumber(kilometraje);
  var precio = $("#r_precio").val();
  var precio1 = $("#r_precio1").val();
  var alea = $("#r_alea").val();
  var elaboro = $("#elaboro").val();
  var borrar = "0";
  if ($("#eliminar3").is(":checked"))
  {
    borrar = "1";
  }
  document.getElementById('v_paso11').value="";
  for (i=0;i<document.formu5.elements.length;i++)
  {
    saux = document.formu5.elements[i].name;
    if (saux.indexOf('rtm_')!=-1)
    {
      valor = document.getElementById(saux).value;
    }
    saux0 = document.formu5.elements[i].name;
    if (saux0.indexOf('cda_')!=-1)
    {
      valor0 = document.getElementById(saux).value;
    }
    saux1 = document.formu5.elements[i].name;
    if (saux1.indexOf('cat_')!=-1)
    {
      valor1 = document.getElementById(saux).value;
    }
    saux2 = document.formu5.elements[i].name;
    if (saux2.indexOf('lat_')!=-1)
    {
      valor2 = document.getElementById(saux).value;
    }
    saux3 = document.formu5.elements[i].name;
    if (saux3.indexOf('ivt_')!=-1)
    {
      valor3 = document.getElementById(saux1).value;
    }
    saux4 = document.formu5.elements[i].name;
    if (saux4.indexOf('tor_')!=-1)
    {
      valor4 = document.getElementById(saux1).value;
      valor5 = valor+"»"+valor0+"»"+valor1+"»"+valor2+"»"+valor3+"»"+valor4;
      document.getElementById('v_paso11').value = document.getElementById('v_paso11').value+valor5+"|";
    }
  }
  var valores = $("#v_paso11").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_grab9.php",
    data:
    {
      tipo: tipo,
      tipo1: tipo1,
      placa: placa,
      fecha: fecha,
      contrato: contrato,
      contrato1: contrato1,
      kilometraje: kilometraje,
      precio: precio,
      precio1: precio1,
      alea: alea,
      elaboro: elaboro,
      borrar: borrar,
      valores: valores
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
      var conse = registros.conse;
      var id = registros.id;
      if (salida == "1")
      {
        $("#aceptar").hide();
        $("#r_kilometraje").prop("disabled",true);
        var kilometraje2 = kilometraje1.replace(/[.]+/g, "");
        kilometraje2 = parseFloat(kilometraje2);
        $("#r_kilometros").val(kilometraje2);
        if (id == "0")
        {
        }
        else
        {
          if (borrar == "1")
          {
          	trae_eventos3();
            //$("#calendario").fullCalendar("removeEvents", id);
          }
        }
        var informacion = "Kilometraje: "+kilometraje1+"\nTotal: "+precio+"\nContrato: "+contrato1;
        var color = ["#0073b7", "#00c0ef", "#00718C", "#6633FF", "#CC3333", "#FF9966"];
        var rand = color[Math.floor(Math.random() * color.length)];
        var dato1 = {
          'id': +conse,
          'title': informacion,
          'start': fecha,
          'allDay': true,
          'backgroundColor': rand,
          'borderColor': rand
        };
        if (borrar == "0")
        {
          $("#calendario").fullCalendar("renderEvent", dato1);
        }
        for (j=1;j<=50;j++)
        {
          if ($("#der_"+j).length)
          {
            $("#der_"+j).click();
          }
        }
        $("#dialogo10").dialog("close");
        calculo();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
        $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function calculo()
{
  var fecha1 = $("#v_fecha1").val();
  var fecha2 = $("#v_fecha2").val();
  var asignado = $("#total2").val();
  var tipo = $("#tipo").val();
  var contrato = $("#tipo1").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_contra2.php",
    data:
    {
      fecha1: fecha1,
      fecha2: fecha2,
      asignado: asignado,
      tipo: tipo,
      contrato: contrato
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
      var total = registros.salida;
      total = parseFloat(total);
      var disponible = registros.disponible;
      disponible = parseFloat(disponible);
      var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      var disponible1 = disponible.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      $("#total3").val(total1);
      $("#total4").val(total);
      $("#total5").val(disponible1);
      $("#total6").val(disponible);
    }
  });
}
function borrar()
{
  if ($("#eliminar").is(":checked"))
  {
    $("#v_kilometraje").prop("disabled",true);
    $("#v_consumo").prop("disabled",true);
    $("#v_bonos").prop("disabled",true);
    $("#v_precio").prop("disabled",true);
    $("#v_kilometraje").val('0');
    $("#v_consumo").val('0.00');
    $("#v_bonos").val('0');
    $("#v_precio").val('0.00');
    $("#v_precio1").val('0');
    $("#aceptar1").show();
  }
  else
  {
    $("#v_kilometraje").prop("disabled",false);
    $("#v_consumo").prop("disabled",false);
    $("#v_bonos").prop("disabled",false);
    $("#v_precio").prop("disabled",false);
  }
}
function borrar1()
{
  if ($("#eliminar1").is(":checked"))
  {
    $("#m_kilometraje").prop("disabled",true);
    $("#m_precio").prop("disabled",true);
    $("#m_kilometraje").val('0');
    $("#m_precio").val('0.00');
    $("#m_precio1").val('0');
    $("#aceptar3").show();
  }
  else
  {
    $("#m_kilometraje").prop("disabled",false);
    $("#m_precio").prop("disabled",false);
  }
}
function borrar2()
{
  if ($("#eliminar2").is(":checked"))
  {
    $("#l_kilometraje").prop("disabled",true);
    $("#l_precio").prop("disabled",true);
    $("#l_kilometraje").val('0');
    $("#l_precio").val('0.00');
    $("#l_precio1").val('0');
    $("#aceptar5").show();
  }
  else
  {
    $("#l_kilometraje").prop("disabled",false);
    $("#l_precio").prop("disabled",false);
  }
}
function borrar3()
{
  if ($("#eliminar3").is(":checked"))
  {
    $("#r_kilometraje").prop("disabled",true);
    $("#r_precio").prop("disabled",true);
    $("#r_kilometraje").val('0');
    $("#r_precio").val('0.00');
    $("#r_precio1").val('0');
    $("#aceptar7").show();
  }
  else
  {
    $("#r_kilometraje").prop("disabled",false);
    $("#r_precio").prop("disabled",false);
  }
}
function cerrar()
{
  $("#dialogo").dialog("close");
}
function cerrar1()
{
  limpiarm();
  $("#dialogo4").dialog("close");
}
function cerrar2()
{
  $("#dialogo7").dialog("close");
}
function cerrar3()
{
  $("#dialogo10").dialog("close");
}
function subir()
{
  var placa = $("#v_placa").val();
  var fecha = $("#v_fecha").val();
  fecha = fecha.replace("-", "");
  fecha = fecha.replace("-", "");
  var alea = $("#v_alea").val();
  var url = "<a href='./subir21.php?placa="+placa+"&fecha="+fecha+"&alea="+alea+"' name='link1' id='link1' class='pantalla-modal'>Link</a>";
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
function subir1()
{
  var placa = $("#m_placa").val();
  var fecha = $("#m_fecha").val();
  fecha = fecha.replace("-", "");
  fecha = fecha.replace("-", "");
  var alea = $("#m_alea").val();
  var url = "<a href='./subir23.php?placa="+placa+"&fecha="+fecha+"&alea="+alea+"' name='link3' id='link3' class='pantalla-modal'>Link</a>";
  $("#vinculo1").hide();
  $("#vinculo1").html('');
  $("#vinculo1").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#link3").click();
}
function subir2()
{
  var placa = $("#l_placa").val();
  var fecha = $("#l_fecha").val();
  fecha = fecha.replace("-", "");
  fecha = fecha.replace("-", "");
  var alea = $("#l_alea").val();
  var url = "<a href='./subir24.php?placa="+placa+"&fecha="+fecha+"&alea="+alea+"' name='link5' id='link5' class='pantalla-modal'>Link</a>";
  $("#vinculo2").hide();
  $("#vinculo2").html('');
  $("#vinculo2").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#link5").click();
}
function subir3()
{
  var placa = $("#r_placa").val();
  var fecha = $("#r_fecha").val();
  fecha = fecha.replace("-", "");
  fecha = fecha.replace("-", "");
  var alea = $("#r_alea").val();
  var url = "<a href='./subir25.php?placa="+placa+"&fecha="+fecha+"&alea="+alea+"' name='link7' id='link7' class='pantalla-modal'>Link</a>";
  $("#vinculo3").hide();
  $("#vinculo3").html('');
  $("#vinculo3").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#link7").click();
}
function cargar()
{
  var v1 = $("#v_paso1").val();
  var v2 = $("#v_paso2").val();
  v2 = v2.replace("-", "");
  v2 = v2.replace("-", "");
  var v3 = $("#v_placa").val();
  var v4 = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_contra3.php",
    data:
    {
      v1: v1,
      v2: v2,
      v3: v3,
      v4: v4
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var alea = registros.salida;
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
        var ruta = "\\upload\\bonos\\"+v3+"\\"+v2+"\\"+alea+"\\";
        var url = "<a href='./ver_bonos.php?valor="+ruta+"&valor1="+archivo+"' name='lnk2' id='lnk2' class='pantalla-modal'></a>";
        $("#vinculo").html('');
        $("#vinculo").append(url);
        $(".pantalla-modal").magnificPopup({
          type: 'iframe',
          preloader: false,
          modal: false
        });
        $("#lnk2").click();
      }
    }
  }); 
}
function cargar1()
{
  var v1 = $("#v_paso1").val();
  var v2 = $("#v_paso2").val();
  v2 = v2.replace("-", "");
  v2 = v2.replace("-", "");
  var v3 = $("#m_placa").val();
  var v4 = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_contra3.php",
    data:
    {
      v1: v1,
      v2: v2,
      v3: v3,
      v4: v4
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var alea = registros.salida;
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
        var ruta = "\\upload\\contratom\\"+v3+"\\"+v2+"\\"+alea+"\\";
        var url = "<a href='./ver_bonos.php?valor="+ruta+"&valor1="+archivo+"' name='lnk2' id='lnk2' class='pantalla-modal'></a>";
        $("#vinculo").html('');
        $("#vinculo").append(url);
        $(".pantalla-modal").magnificPopup({
          type: 'iframe',
          preloader: false,
          modal: false
        });
        $("#lnk2").click();
      }
    }
  }); 
}
function cargar2()
{
  var v1 = $("#v_paso1").val();
  var v2 = $("#v_paso2").val();
  v2 = v2.replace("-", "");
  v2 = v2.replace("-", "");
  var v3 = $("#l_placa").val();
  var v4 = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_contra3.php",
    data:
    {
      v1: v1,
      v2: v2,
      v3: v3,
      v4: v4
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var alea = registros.salida;
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
        var ruta = "\\upload\\contratol\\"+v3+"\\"+v2+"\\"+alea+"\\";
        var url = "<a href='./ver_bonos.php?valor="+ruta+"&valor1="+archivo+"' name='lnk2' id='lnk2' class='pantalla-modal'></a>";
        $("#vinculo").html('');
        $("#vinculo").append(url);
        $(".pantalla-modal").magnificPopup({
          type: 'iframe',
          preloader: false,
          modal: false
        });
        $("#lnk2").click();
      }
    }
  }); 
}
function cargar3()
{
  var v1 = $("#v_paso1").val();
  var v2 = $("#v_paso2").val();
  v2 = v2.replace("-", "");
  v2 = v2.replace("-", "");
  var v3 = $("#r_placa").val();
  var v4 = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_contra3.php",
    data:
    {
      v1: v1,
      v2: v2,
      v3: v3,
      v4: v4
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var alea = registros.salida;
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
        var ruta = "\\upload\\contrator\\"+v3+"\\"+v2+"\\"+alea+"\\";
        var url = "<a href='./ver_bonos.php?valor="+ruta+"&valor1="+archivo+"' name='lnk2' id='lnk2' class='pantalla-modal'></a>";
        $("#vinculo").html('');
        $("#vinculo").append(url);
        $(".pantalla-modal").magnificPopup({
          type: 'iframe',
          preloader: false,
          modal: false
        });
        $("#lnk2").click();
      }
    }
  }); 
}
function reemplazar()
{
  var v1 = $("#v_paso1").val();
  var v2 = $("#v_paso2").val();
  v2 = v2.replace("-", "");
  v2 = v2.replace("-", "");
  var v3 = $("#v_placa").val();
  var v4 = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_contra3.php",
    data:
    {
      v1: v1,
      v2: v2,
      v3: v3,
      v4: v4
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var alea = registros.salida;
      var url = "<a href='./subir21.php?placa="+v3+"&fecha="+v2+"&alea="+alea+"' name='link1' id='link1' class='pantalla-modal'>Link</a>";
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
  }); 
}
function reemplazar1()
{
  var v1 = $("#v_paso1").val();
  var v2 = $("#v_paso2").val();
  v2 = v2.replace("-", "");
  v2 = v2.replace("-", "");
  var v3 = $("#m_placa").val();
  var v4 = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_contra3.php",
    data:
    {
      v1: v1,
      v2: v2,
      v3: v3,
      v4: v4
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var alea = registros.salida;
      var url = "<a href='./subir23.php?placa="+v3+"&fecha="+v2+"&alea="+alea+"' name='link1' id='link1' class='pantalla-modal'>Link</a>";
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
  });
}
function reemplazar2()
{
  var v1 = $("#v_paso1").val();
  var v2 = $("#v_paso2").val();
  v2 = v2.replace("-", "");
  v2 = v2.replace("-", "");
  var v3 = $("#l_placa").val();
  var v4 = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_contra3.php",
    data:
    {
      v1: v1,
      v2: v2,
      v3: v3,
      v4: v4
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var alea = registros.salida;
      var url = "<a href='./subir24.php?placa="+v3+"&fecha="+v2+"&alea="+alea+"' name='link5' id='link5' class='pantalla-modal'>Link</a>";
      $("#vinculo2").hide();
      $("#vinculo2").html('');
      $("#vinculo2").append(url);
      $(".pantalla-modal").magnificPopup({
        type: 'iframe',
        preloader: false,
        modal: false
      });
      $("#link5").click();
    }
  }); 
}
function reemplazar3()
{
  var v1 = $("#v_paso1").val();
  var v2 = $("#v_paso2").val();
  v2 = v2.replace("-", "");
  v2 = v2.replace("-", "");
  var v3 = $("#r_placa").val();
  var v4 = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_contra3.php",
    data:
    {
      v1: v1,
      v2: v2,
      v3: v3,
      v4: v4
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var alea = registros.salida;
      var url = "<a href='./subir25.php?placa="+v3+"&fecha="+v2+"&alea="+alea+"' name='link5' id='link5' class='pantalla-modal'>Link</a>";
      $("#vinculo2").hide();
      $("#vinculo2").html('');
      $("#vinculo2").append(url);
      $(".pantalla-modal").magnificPopup({
        type: 'iframe',
        preloader: false,
        modal: false
      });
      $("#link5").click();
    }
  }); 
}
function consultarm()
{
  var v1 = $("#v_paso1").val();
  var v2 = $("#v_paso2").val();
  v2 = v2.replace("-", "");
  v2 = v2.replace("-", "");
  var v3 = $("#m_placa").val();
  var v4 = $("#tipo").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_contra4.php",
    data:
    {
      v1: v1,
      v2: v2,
      v3: v3,
      v4: v4
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var kilometraje = registros.kilometraje;
      var valores = registros.valores;
      var total = registros.total;
      var total1 = registros.total1;
      var contrato = registros.contrato;
      var contrato1 = registros.contrato1;
      var alea = registros.alea;
      var interno = registros.interno;
      var v5 = $("#v_paso2").val();
      $("#m_fecha").val(v5);
      $("#m_contrato").val(contrato);
      $("#m_kilometraje").val(kilometraje);
      $("#m_precio").val(total);
      $("#m_precio1").val(total1);
      $("#m_alea").val(alea);
      $("#m_registro").val(interno);
      $("#m_actu").val('1');
      $("#m_contrato").prop("disabled",true);
      $("#dialogo4").dialog("open");
      $("#dialogo4").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      for (j=1;j<=50;j++)
      {
        if ($("#dem_"+j).length)
        {
          $("#dem_"+j).click();
        }
      }
      var var_ocu = valores.split('|');
      var var_ocu1 = var_ocu.length;
      var var_ocu4 = var_ocu1-1;
      var k = $("#m_conta").val();
      k = parseInt(k);
      k = k+1;
      for (var i=0; i<var_ocu4; i++)
      {
        var paso = var_ocu[i];
        var var_ocu2 = paso.split('»');
        var var_ocu3 = var_ocu2.length;
        $("#add_field1").click();
        for (var j=0; j<var_ocu3-1; j++)
        {
          var v1 = var_ocu2[0];
          var v2 = var_ocu2[1];
          var v3 = var_ocu2[2];
          var v4 = var_ocu2[3];
          var v5 = var_ocu2[4];
          $("#man_"+k).val(v1).trigger("change");
          $("#cam_"+k).val(v2);
          $("#val_"+k).val(v3);
          $("#iva_"+k).val(v4);
          $("#tot_"+k).val(v5);
          cargan(k);
          suma_man();
        }
        k++;
      }
    }
  });
}
function limpiarm()
{
  for (j=1;j<=50;j++)
  {
    if ($("#dem_"+j).length)
    {
      $("#dem_"+j).click();
    }
  }
  $("#m_actu").val('0');
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
  patron = /[0-9.]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function formatNumber(valor)
{
  valor = String(valor).replace(/\D/g, "");
  return valor === '' ? valor : Number(valor).toLocaleString();
}
function formatNumber1(valor)
{
  var valor;
  var valor1 = $("#"+valor).val();
  var valor2 = String(valor1).replace(/\D/g, "");
  var valor3 = Number(valor2).toLocaleString();
  $("#"+valor).val(valor3);
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
// 02/08/2023 - Ajuste validacion kilometraje - galones - bonos para no arrastar valores
// 10/08/2023 - Ajuste a 3 digitos dias finales de registro
// 17/08/2023 - Ajuste para registro movimiento de mantenimientos
// 20/09/2023 - Calculo de suma de mantenimientos
// 26/09/2023 - Grabacion de calentario mantenimientos
// 12/12/2023 - Grabacion de calentario llantas
// 18/12/2023 - Inclusion cantidad en mantenimientos
// 20/12/2023 - Grabacion de calendario rtm
// 21/12/2023 - Validacion marcas, cda, borrado
// 28/12/2023 - Ajuste en tamaño pantalla auxiliar de mantenimientos
// 28/12/2023 - Ajuste grabacion kilometraje en tabla vehiculos
// 03/01/2024 - Ajuste modificación grabacion de mantenimientos
// 10/01/2024 - Ajuste registro de movimientos vigencias anteriores
// 19/03/2024 - Ajuste filtro clase de vehiculo
// 22/08/2024 - Ajuste kilometraje, galones, bonos y valor no permitir en 0
// 15/11/2024 - Ajuste validacion saldo desde kilometraje
?>