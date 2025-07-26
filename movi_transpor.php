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
  $consu1 = "SELECT combustible FROM cx_ctr_par";
  $cur1 = odbc_exec($conexion, $consu1);
  $var_combus = odbc_result($cur1,1);
  $adiciona = "0";
  $dia2 = date('d');
  $dia2 = intval($dia2);
  if ($dia2 <= $var_combus)
  {
    if ($var_combus > 30)
    {
      $var_dias = ($var_combus/30);
    }
    else
    {
      $var_dias = "1";
    }
    $var_dias = intval($var_dias);
    $mes2 = intval($mes1)-$var_dias;
    if ($mes2 <= 0)
    {
      $mes2 = "1";
    }
    $mes2 = str_pad($mes2,2,"0",STR_PAD_LEFT);
    $fecha1 = $ano."/".$mes2."/01";
    $adiciona = "1";
  }
  // Se consultan planes o solicitudes
  $periodo = date('m');
  $periodo = intval($periodo);
  $periodo1 = intval($periodo)-1;
  $periodo2 = intval($periodo)-2;
  $periodo3 = intval($periodo)-3;
  $query2 = "SELECT conse, misiones, estado, n_misiones, tipo FROM cx_pla_inv WHERE ((usuario='$usu_usuario') OR (usuario='$log_usuario')) AND unidad='$uni_usuario' AND estado IN ('D','F','G','H','W') AND periodo IN ('$periodo','$periodo1','$periodo2','$periodo3') AND ano='$ano' ORDER BY conse";
  if ($sup_usuario == "5")
  {
    $query2 = str_replace("usuario='$usu_usuario'", "unidad='$uni_usuario'", $query2);
  }
  $cur2 = odbc_exec($conexion, $query2);
  $listado = "<option value='-'>- SELECCIONAR -</option>";
  $i = 0;
  while($i<$row=odbc_fetch_array($cur2))
  {
    $internos = "";
    $cursor = array();
    $estado = $row["estado"];
    $querys = "";
    $validaciones = "";
    $misiones3 = "";
    $conse = $row["conse"];
    $misiones = $row["misiones"];
    $misiones = trim(decrypt1($misiones, $llave));
    $misiones1 = explode("|", $misiones);
    $solicitud = $row["tipo"];
    // Se consulta si tiene combustible
    $query4 = "SELECT gasto FROM cx_pla_gad WHERE conse1='$conse' AND ano='$ano'";
    $sql4 = odbc_exec($conexion, $query4);
    $j = 0;
    $valida = "0";
    while($j<$row=odbc_fetch_array($sql4))
    {
      $v_gasto = odbc_result($sql4,1);
      if (($v_gasto == "36") or ($v_gasto == "42"))
      {
        $valida = "1";
      }
    }
    // Si se encuentra solicitud de combustible
    if ($valida == "1")
    {
      for ($m=0;$m<count($misiones1)-1;++$m)
      {
        $misiones2 = trim($misiones1[$m]);
        if ($solicitud == "2")
        {
	        $listado .= "<option value=".$conse.">".$conse." ¬ ".$misiones2."</option>";        	
        }
        else
        {
	        $query3 = "SELECT mision FROM cx_rel_gas WHERE consecu='$conse' AND usuario='$usu_usuario' AND unidad='$uni_usuario' AND periodo IN ('$periodo','$periodo1','$periodo2','$periodo3') AND ano='$ano' AND mision='$misiones2'";
          $cur3 = odbc_exec($conexion, $query3);
          $tot3 = odbc_num_rows($cur3);
	        if ($tot3 == "0")
	        {
            $listado .= "<option value=".$conse.">".$conse." ¬ ".$misiones2."</option>";
	        }
	      }
      }
    }
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
          <h3>Movimiento de Veh&iacute;culos</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo de Movimiento</font></label>
                  <select name="tipo" id="tipo" class="form-control select2" onchange="verifica();" tabindex="1">
                    <option value="2">KILOMETRAJE / CONSUMO COMBUSTIBLE</option>
                    <?php
                    if (($sup_usuario == "0"))
                    {
                    }
                    else
                    {
                    ?>
                      <option value="1">TRASPASO</option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <div id="l_salida">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Tipo</font></label>
                    <select name="tipo1" id="tipo1" class="form-control select2" tabindex="2">
                      <option value="1">PARTIDA MENSUAL DE COMBUSTIBLE</option>
                      <option value="2">SUMINISTRO DE COMBUSTIBLE ADICIONAL</option>
                    </select>
                  </div>
                </div>
                <div id="l_salida1">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Unidad</font></label>
                    <select name="unidad2" id="unidad2" class="form-control select2" tabindex="3"></select>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Placa</font></label>
                    <input type="text" name="placa" id="placa" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check3(event);" maxlength="6" tabindex="4" autocomplete="off">
                  </div>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Fecha</font></label>
                  <input type="text" name="fecha" id="fecha" class="form-control fecha" value="<?php echo $fecha; ?>" onfocus="blur();" readonly="readonly" tabindex="4">
                </div>
                <div id="l_salida2">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Periodo</font></label>
                    <select name="tipo2" id="tipo2" class="form-control select2" tabindex="4">
                      <option value="1">MES ACTUAL</option>
                      <option value="2">MES ANTERIOR</option>
                    </select>
                  </div>
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
              <div id="datos3">
                <br>
                <div class="row">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">N&uacute;mero Doc. Soporte</font></label>
                    <input type="text" name="numero1" id="numero1" class="form-control" maxlength="25" tabindex="6" autocomplete="off">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha Doc. Soporte</font></label>
                    <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly" tabindex="7">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Unidad</font></label>
                    <select name="unidad1" id="unidad1" class="form-control" onchange="trae_compa();" tabindex="8"><option value="0">- SELECCIONAR -</option></select>
                  </div>
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Compa&ntilde;&iacute;a</font></label>
                    <input type="text" name="compania1" id="compania1" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="9" autocomplete="off">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col col-lg-9 col-sm-9 col-md-9 col-xs-9">
                    <label><font face="Verdana" size="2">Observaciones</font></label>
                    <textarea name="observaciones1" id="observaciones1" class="form-control" rows="3" onblur="val_caracteres('observaciones2');" tabindex="10"></textarea>
                  </div>
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <br>
                    <a href="#" name="lnk1" id="lnk1" onclick="subir();"><img src="imagenes/clip.png" border="0" title="Anexar Acta"></a>
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <br>
                    <input type="button" name="aceptar3" id="aceptar3" value="Continuar" tabindex="11">
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <label><font face="Verdana" size="2">Elaboro</font></label>
                  <input type="text" name="elaboro" id="elaboro" class="form-control" value="<?php echo $nom_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="120" tabindex="12" autocomplete="off">
                </div>
                <div id="datos2">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3"></div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Total Solicitado</font></label>
                    <input type="text" name="total1" id="total1" class="form-control numero" value="0.00" readonly="readonly">
                    <input type="hidden" name="total2" id="total2" class="form-control numero" value="0" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Total Relacionado</font></label>
                    <input type="text" name="total3" id="total3" class="form-control numero" value="0.00" readonly="readonly">
                    <input type="hidden" name="total4" id="total4" class="form-control numero" value="0" readonly="readonly">                    
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
              <input type="hidden" name="v_fecha1" id="v_fecha1" class="form-control" value="<?php echo $fecha1; ?>" readonly="readonly">
              <input type="hidden" name="v_fecha2" id="v_fecha2" class="form-control" value="<?php echo $fecha2; ?>" readonly="readonly">
              <input type="hidden" name="v_fecha3" id="v_fecha3" class="form-control" value="" readonly="readonly">
              <input type="hidden" name="v_usuario" id="v_usuario" value="<?php echo $usu_usuario; ?>" readonly="readonly">
              <input type="hidden" name="v_unidad" id="v_unidad" value="<?php echo $uni_usuario; ?>" readonly="readonly">
              <input type="hidden" name="v_super" id="v_super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly">
              <input type="hidden" name="alea" id="alea" class="form-control" value="<?php echo $alea; ?>" readonly="readonly">
              <input type="hidden" name="adiciona" id="adiciona" class="form-control" value="<?php echo $adiciona; ?>" readonly="readonly">
              <input type="hidden" name="contador" id="contador" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="contador1" id="contador1" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="disponible" id="disponible" class="form-control" value="0" readonly="readonly">
              <input type="hidden" name="solicitudes" id="solicitudes" class="form-control" value="" readonly="readonly">
              <div id="link"></div>
            </form>
            <form name="formu_excel" id="formu_excel" action="trans_movi_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
            </form>
            <div id="dialogo">
              <form name="formu2">
                <table width="98%" align="center" border="0">
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                          <center><label><font face="Verdana" size="2">Placa</font></label></center>
                          <input type="text" name="v_placa" id="v_placa" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                          <center><label><font face="Verdana" size="2">Fecha</font></label></center>
                          <input type="text" name="v_fecha" id="v_fecha" class="form-control fecha" onfocus="blur();" readonly="readonly">
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <center><label><font face="Verdana" size="2">Plan / Solicitud - Misi&oacute;n</font></label></center>
                          <select name="v_plan" id="v_plan" class="form-control select2" onchange="valida_informe();">
                            <?php
                            echo $listado;
                            ?>
                          </select>
                        </div>
                        <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                        	<center><label><font face="Verdana" size="2">Tipo de Soporte</font></label></center>
                        	<select name="v_soporte" id="v_soporte" class="form-control select2">
                        		<option value="-">- SELECCIONAR -</option>
                        		<option value="1">CON SOPORTE</option>
                        		<option value="0">SIN SOPORTE</option>
                        	</select>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><hr></td>
                  </td>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <label><font face="Verdana" size="2">Kilometraje</font></label>
                          <input type="text" name="v_kilometraje" id="v_kilometraje" class="form-control numero" value="0" onkeypress="return check(event);" onblur="valida_kilometro();" maxlength="10" autocomplete="off">
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <label><font face="Verdana" size="2">Cant. Galones</font></label>
                          <input type="text" name="v_consumo" id="v_consumo" class="form-control numero" value="0.00" onkeypress="return check1(event);" onblur="valida_consumo();" maxlength="10" autocomplete="off">
                        </div>
                        <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                          <label><font face="Verdana" size="2">Total Factura</font></label>
                          <input type="text" name="v_precio" id="v_precio" class="form-control numero" value="0.00" onkeyup="paso_valor(); suma();">
                          <input type="hidden" name="v_precio1" id="v_precio1" class="form-control numero" value="0" readonly="readonly">
                          <input type="hidden" name="v_kilometros" id="v_kilometros" class="form-control numero" value="0" readonly="readonly">
                          <input type="hidden" name="v_odometro" id="v_odometro" class="form-control numero" value="0" readonly="readonly">
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                        <div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
                          <center>
                            <div id="lbl1">
                              <input type="checkbox" name="eliminar" id="eliminar" value="0" onclick="borrar();">&nbsp;&nbsp;&nbsp;<label><font face="Verdana" size="2">Eliminar Datos del D&iacute;a</font></label>
                            </div>
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
                        <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
                      </div>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
            <div id="dialogo1"></div>
            <div id="dialogo2"></div>
            <div id="dialogo3"></div>
            <div id="dialogo4"></div>
            <div id="dialogo5"></div>
            <div id="dialogo6"></div>
          </div>
          <h3>Consulta de Movimiento de Veh&iacute;culos</h3>
          <div>
            <div id="load1">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <div class="row">
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Fecha</font></label>
                <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">&nbsp;</font></label>
                <input type="text" name="fecha3" id="fecha3" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Tipo Unidad</font></label>
                <select name="tipou" id="tipou" class="form-control select2">
                  <option value="-">- SELECCIONAR -</option>
                  <option value="1">ORIGEN</option>
                  <option value="2">DESTINO</option>
                </select>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Unidad</font></label>
                <select name="unidad3" id="unidad3" class="form-control select2"></select>
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <label><font face="Verdana" size="2">Placa</font></label>
                <input type="text" name="placa1" id="placa1" class="form-control" value="" onchange="javascript:this.value=this.value.toUpperCase();" onkeypress="return check3(event);" maxlength="6" autocomplete="off">
              </div>
              <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                <br>
                <input type="button" name="consultar" id="consultar" value="Consultar">
              </div>
            </div>
            <br>
            <div id="tabla7"></div>
            <div id="resultados5"></div>
            <form name="formu1" action="ver_movi1.php" method="post" target="_blank">
              <input type="hidden" name="movi_conse" id="movi_conse" readonly="readonly">
              <input type="hidden" name="movi_tipo" id="movi_tipo" readonly="readonly">
              <input type="hidden" name="movi_placa" id="movi_placa" readonly="readonly">
              <input type="hidden" name="movi_ano" id="movi_ano" readonly="readonly">
              <input type="hidden" name="movi_unidad" id="movi_unidad" readonly="readonly">
              <input type="hidden" name="movi_alea" id="movi_alea" readonly="readonly">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="bower_components/moment/moment.js"></script>
<script src="bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="js/jquery.quicksearch.js?1.0.0" type="text/javascript"></script>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
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
    width: 850,
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
        nuevo();
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
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo4").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 310,
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
  $("#dialogo5").dialog({
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
    buttons: [
      {
        text: "Ok",
        click: function() {
          $(this).dialog("close");
        }
      }
    ]
  });
  $("#dialogo6").dialog({
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
  $("#aceptar").css({ width: '140px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta);
  $("#aceptar1").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar2").button();
  $("#aceptar2").click(cerrar);
  $("#aceptar2").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar3").button();
  $("#aceptar3").click(pregunta1);
  $("#aceptar3").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#consultar").button();
  $("#consultar").click(consultar1);
  $("#consultar").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#datos1").hide();
  $("#datos2").hide();
  $("#datos3").hide();
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
  $("#v_precio").on("paste", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#v_precio").on("dragstart", function(e){
    e.preventDefault();
    alerta("Acción No Permitida");
  });
  $("#v_kilometraje").focus(function(){
    this.select();
  });
  $("#v_consumo").focus(function(){
    this.select();
  });
  trae_unidades();
  trae_calendario();
  $("#l_salida1").hide();
  var v_adiciona = $("#adiciona").val();
  if (v_adiciona == "0")
  {
    $("#tipo2>option[value='2']").attr("disabled","disabled");
  }
  else
  {
    $("#tipo2>option[value='2']").removeAttr("disabled");
  }
  $("#unidad3").select2.defaults.set("width", "100%");
  $("#unidad3").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
});
function trae_unidades()
{
  $("#unidad1").html('');
  $("#unidad2").html('');
  $("#unidad3").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unid.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var salida1 = "<option value='-'>- SELECCIONAR -</option>";;
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
        salida1 += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#unidad1").append(salida);
      $("#unidad2").append(salida1);
      $("#unidad3").append(salida1);
    }
  });
}
function trae_compa()
{
  var unidad = $("#unidad1").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cmps.php",
    data:
    {
      unidad: unidad
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      var lista = [];
      var var_ocu = salida.split('#');
      var var_ocu1 = var_ocu.length;
      for (var i=0; i<var_ocu1-1; i++)
      {
        lista.push(var_ocu[i]);
      }
      $("#compania1").autocomplete({source: lista, minLength:0}).on("focus", function() { $(this).keydown(); });
    }
  });
}
function verifica()
{
  var tipo = $("#tipo").val();
  if (tipo == "1")
  {
    $("#l_salida").hide();
    $("#l_salida1").show();
    $("#l_salida2").hide();
  }
  else
  {
    $("#l_salida").show();
    $("#l_salida1").hide();
    $("#l_salida2").show();
  } 
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
      $("#v_fecha").val(fecha);
      $("#v_fecha3").val(fecha1);
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
        valida_informe();
      }
    },
    viewRender: function (view, element) {
      var inicio = view.start;
      var final = view.end;
      trae_eventos();
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
      var detalle = "<center><h3>"+title+"<br>Fecha: "+start+"</h3></center>";
      $("#dialogo5").html(detalle);
      $("#dialogo5").dialog("open");
      $("#dialogo5").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
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
      url: "tran_movi1.php",
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
            var v9 = value.solicitud;
            var v10 = value.mision;
            var informacion = "Cant. Galones: "+v4+"\nKilometraje: "+v7+"\nTotal Factura: "+v8+"\nPlan / Solicitud: "+v9+"\nMisión: "+v10;
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
    total3 = parseFloat(total3);
    total3 = total3.toFixed(2);
    alerta("Valor Superior: "+total3);
    $("#aceptar1").hide();
  }
}
function valida_informe()
{
  var fecha = $("#v_fecha3").val();
  var placa = $("#v_placa").val();
  placa = placa.trim();
  var plan = $("#v_plan").val();
  var tipo = $("#tipo1").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_informe.php",
    data:
    {
      fecha: fecha,
      placa: placa,
      plan: plan,
      tipo: tipo
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var contador = registros.contador;
      $("#contador").val(contador);
			var contador1 = registros.contador1;
      $("#contador1").val(contador1);
      var disponible = registros.disponible;
      disponible = parseFloat(disponible);
      $("#disponible").val(disponible);
      if (disponible<0)
      {
        //alerta("Plan / Solicitud sin recursos disponibles");
        //$("#aceptar1").hide();
      }
      else
      {
        //$("#aceptar1").show();
      }
      valida_fecha()
    }
  });
}
function valida_fecha()
{
  var contador = $("#contador").val();
  var contador1 = $("#contador1").val();
  var fecha = $("#v_fecha").val();
  var from = $("#v_fecha1").val();
  var to = $("#v_fecha2").val();
  var check = $("#v_fecha3").val();
  var fDate = Date.parse(from);
  var lDate = Date.parse(to);
  var cDate = Date.parse(check);
  if ((cDate <= lDate && cDate >= fDate))
  {
    $("#v_kilometraje").val('0');
    $("#v_consumo").val('0.00');
    $("#v_precio").val('0.00');
    $("#v_precio1").val('0');
    $("#v_plan").prop("disabled",false);
    $("#v_kilometraje").prop("disabled",false);
    $("#v_consumo").prop("disabled",false);
    $("#v_precio").prop("disabled",false);
    $("#eliminar").prop("checked",false);
    // Si tiene una sola mision el plan / solicitud y ya tiene realizada una relacion
    if ((contador == "1") && (contador1 == "1"))
    {
      $("#lbl1").hide();
    }
    else
    {
      $("#lbl1").show();  
    }
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
function valida_kilometro()
{
	var valor1 = $("#v_kilometraje").val();
 	valor1 = valor1.replace(/[.]+/g, "");
	valor1 = parseFloat(valor1);
	var valor2 = $("#v_kilometros").val();
 	valor2 = valor2.replace(/[.]+/g, "");
	valor2 = parseFloat(valor2);
  alerta2(valor2);
  var odometro = $("#v_odometro").val();
	if (valor1 < valor2)
	{
    if (odometro == "1")
    {
      var valor3 = formatNumber(valor2);
      var detalle = "<center><h3>Esta seguro de reiniciar el valor del odómetro de "+valor3+" a "+valor1+" ?</h3></center>";
      $("#dialogo6").html(detalle);
      $("#dialogo6").dialog("open");
      $("#dialogo6").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      $("#aceptar1").hide();
    }
    else
    {
  		alerta("Valor Kilometroje Inferior a: "+valor2);
  		$("#aceptar1").hide();
    }
	}
	else
	{
		formatNumber1('v_kilometraje');
		$("#aceptar1").show();
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
  $("#dialogo3").html(detalle);
  $("#dialogo3").dialog("open");
  $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function validacion()
{
  var salida = true, detalle = '';
  var tipo = $("#tipo").val();
  if (tipo == "1")
  {
    var valor = $("#numero1").val();
    valor = valor.trim().length;
    if (valor == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar el Número del Acto Administrativo</h3></center>";
    }
    var valor1 = $("#fecha1").val();
    valor1 = valor1.trim().length;
    if (valor1 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar la Fecha del Acto Administrativo</h3></center>";
    }
    var valor2 = $("#unidad1").val();
    if (valor2 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe seleccionar la Unidad a Traspasar el Bien</h3></center>";
    }
    var valor3 = $("#compania1").val();
    valor3 = valor3.trim().length;
    if (valor3 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar la Compañía a Traspasar el Bien</h3></center>";
    }
    var valor4 = $("#observaciones1").val();
    valor4 = valor4.trim().length;
    if (valor4 == "0")
    {
      salida = false;
      detalle += "<center><h3>Debe ingresar las Observaciones</h3></center>";
    }
  }
  var valor5 = $("#elaboro").val();
  valor5 = valor5.trim().length;
  if (valor5 == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar Persona que Elaboro el Movimiento</h3></center>";
  }
  var tranarray = [];
  $("input[name='seleccionados[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        tranarray.push($(this).val());
      }
    }
  );
  var num_tran = tranarray.length;
  if (num_tran == "0")
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar mínimo un Vehículo</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo4").html(detalle);
    $("#dialogo4").dialog("open");
    $("#dialogo4").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
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
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_archivos1.php",
    data:
    {
      alea: alea,
      tipo: tipo
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
}
function consultar()
{
  var tipo = $("#tipo").val();
  var tipo1 = $("#tipo1").val();
  var tipo2 = $("#tipo2").val();
  var unidad = $("#unidad2").val();
  var placa = $("#placa").val();
  var numero = $("#v_paso4").val();
  var fecha1 = $("#v_fecha1").val();
  var fecha2 = $("#v_fecha2").val();
  var adiciona = $("#adiciona").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_movi.php",
    data:
    {
      tipo: tipo,
      tipo1: tipo1,
      tipo2: tipo2,
      unidad: unidad,
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
        salida += "<table width='100%' align='center' border='0'><tr><td width='5%' height='35'>&nbsp;</td><td width='15%' height='35'><b>Placa</b></td><td width='15%' height='35'><b>Clase</b></td><td width='15%' height='35'><b>Unidad</b></td><td width='20%' height='35'><b>Centro Costo</b></td><td width='10%' height='35'><b>Plan / Solicitud</b></td><td width='20%' height='35'><b>Misi&oacute;n</b></td>";
        salida += "</tr></table>";
        salida += "<table width='100%' align='center' border='1' id='a-table1'>";
        $.each(registros.rows, function (index, value)
        {
          if ((tipo == "1") || (tipo == "2"))
          {
            var var1 = index;
            var var2 = value.conse;
            var var3 = value.compania;
            var var4 = value.placa;
            var var5 = value.clase;
            var var6 = '\"'+var1+'\",\"'+var2+'\",\"'+var3+'\",\"'+var4+'\",\"'+var5+'\"';
            if (tipo == "1")
            {
              salida += "<tr><td width='5%' height='35' id='l1_"+var1+"'><center><input type='checkbox' name='seleccionados[]' id='chk_"+var1+"' value='"+var6+"' onclick='trae_marca("+var6+");'></center></td>";
            }
            else
            {
              salida += "<tr><td width='5%' height='35' id='l1_"+var1+"'><center><input type='checkbox' name='seleccionados[]' id='chk_"+var1+"' value='"+var6+"' onclick='trae_marca1("+var6+");'></center></td>";
            }
            salida += "<td width='15%' height='35' id='l2_"+var1+"'>"+value.placa+"</td>";
            salida += "<td width='15%' height='35' id='l3_"+var1+"'>"+value.clase+"</td>";
            salida += "<td width='15%' height='35' id='l4_"+var1+"'>"+value.compania+"</td>";
            salida += "<td width='20%' height='35' id='l5_"+var1+"'>"+value.costo+"</td>";
            salida += "<td width='10%' height='35' id='l6_"+var1+"'>"+value.plan+"</td>";
            salida += "<td width='20%' height='35' id='l7_"+var1+"'>"+value.mision+"</td>";
          }
        });
        salida += "</table>";
        $("#datos").append(salida);
        $("#tipo").prop("disabled",true);
        $("#tipo1").prop("disabled",true);
        $("#tipo2").prop("disabled",true);
        $("#unidad2").prop("disabled",true);
        $("#placa").prop("disabled",true);
        $("#unidades1").prop("disabled",true);
        $("#aceptar").hide();
        if (tipo == "2")
        {
          $("#datos2").show();
          var solicitudes = registros.solicitudes;
          $("#solicitudes").val(solicitudes);
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
function consultar1()
{
  var super1 = $("#v_super").val();
  var salida = true;
  if (super1 == "1")
  {
    var fecha2 = $("#fecha3").val();
    if (fecha2 == "")
    {
      salida = false;
      alerta("Debe seleccionar fecha final");
    }
    var fecha1 = $("#fecha2").val();
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
      url: "movi_consu1.php",
      data:
      {
        fecha1: $("#fecha2").val(),
        fecha2: $("#fecha3").val(),
        tipou: $("#tipou").val(),
        unidad: $("#unidad3").val(),
        placa: $("#placa1").val()
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
        var valida, valida1, valida2;
        var salida1 = "";
        var salida2 = "";
        var salida3 = "";
        var v_var1 = "";
        listareg = [];
        valida = registros.salida;
        valida1 = registros.total;
        salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table><br>";
        salida1 += "<div class='row'><div class='col col-lg-3 col-sm-3 col-md-3 col-xs-3'><input type='text' name='buscar' id='buscar' placeholder='Buscar...' class='form-control' autocomplete='off'></div><div class='col col-lg-8 col-sm-8 col-md-8 col-xs-8'></div>";
        salida1 += "<div class='col col-lg-1 col-sm-1 col-md-1 col-xs-1'><center><a href='#' id='excel' onclick='excel(); return false;'><img src='dist/img/excel.png' title='Descargar Resultados a Excel - SAP'></a></center></div></div>";
        salida1 += "<br>";
        salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='10%'><b>Clase</b></td><td height='35' width='10%'><b>Placa</b></td><td height='35' width='12%'><b>Tipo de Movimiento</b></td><td height='35' width='10%'><b>Fecha</b></td><td height='35' width='18%'><b>Acto Administrativo</b></td><td height='35' width='15%'><b>Unidad Origen</b></td><td height='35' width='15%'><b>Unidad Destino</b></td><td height='35' width='5%'><b>Año</b></td><td height='35' width='5%'>&nbsp;</td></tr></table>";
        salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
        $.each(registros.rows, function (index, value)
        {
          valida2 = '\"'+value.conse+'\",\"'+value.tipo1+'\",\"'+value.placa+'\",\"'+value.ano+'\",\"'+value.n_unidad+'\",\"'+value.alea+'\"';
          salida2 += "<tr>";
          salida2 += "<td height='35' width='10%' id='l1_"+index+"'>"+value.clase+"</td>";
          salida2 += "<td height='35' width='10%' id='l2_"+index+"'>"+value.placa+"</td>";
          salida2 += "<td height='35' width='12%' id='l3_"+index+"'>"+value.tipo+"</td>";
          salida2 += "<td height='35' width='10%' id='l4_"+index+"'>"+value.fecha+"</td>";
          salida2 += "<td height='35' width='18%' id='l5_"+index+"'>"+value.acto+"</td>";
          salida2 += "<td height='35' width='15%' id='l6_"+index+"'>"+value.n_unidad+"</td>";
          salida2 += "<td height='35' width='15%' id='l7_"+index+"'>"+value.n_unidad1+"</td>";
          salida2 += "<td height='35' width='5%' id='l8_"+index+"'>"+value.ano+"</td>";
          if (value.archivo > 0)
          {
            salida2 += "<td height='35' width='5%' id='l9_"+index+"'><center><a href='#' onclick='javascript:highlightText2("+index+",9); ver("+valida2+");'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td></td>";
          }
          else
          {
            salida2 += "<td height='35' width='5%' id='l9_"+index+"'>&nbsp;</td></td>";
          }
          salida2 += "</tr>";
          v_var1 += value.clase+"|"+value.placa+"|"+value.tipo+"|"+value.fecha+"|"+value.acto+"|"+value.n_unidad+"|"+value.n_unidad1+"|"+value.ano+"|"+value.observaciones+"|"+value.elaboro+"|#";
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
  $("#numero1").val('');
  $("#fecha1").val('');
  $("#compania1").val('');
  $("#observaciones1").val('');
  contador();
}
function trae_marca1(valor, valor1, valor2, valor3, valor4)
{
  var valor, valor1, valor2, valor3, valor4, valor5;
  valor5 = par_impar(valor);
  $("#v_placa").val(valor3);
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
    if (tipo == "2")
    {
      trae_eventos();
      $("#datos1").show();
      $("#datos3").hide();
    }
    else
    {
      $("#datos1").hide();
      $("#datos3").show();
      trae_compa();
    }
  }
}
function nuevo()
{
  var salida = true;
  var tipo = $("#tipo").val();
  var tipo1 = $("#tipo1").val();
  var placa = $("#v_placa").val();
  var fecha = $("#v_fecha").val();
  var plan = $("#v_plan").val();
  var mision = $("#v_plan option:selected").html();
  var var_ocu = mision.split('¬');
  var var_tam = var_ocu.length;
  if (var_tam == "1")
  {
  }
  else
  {
    var mision1 = var_ocu[1];
    mision1 = mision1.trim();
  }
  var soporte = $("#v_soporte").val();
  var kilometraje = $("#v_kilometraje").val();
  var kilometraje1 = formatNumber(kilometraje);
  var consumo = $("#v_consumo").val();
  var precio = $("#v_precio").val();
  var precio1 = $("#v_precio1").val();
  var odometro = $("#v_odometro").val();
  var usuario = $("#v_usuario").val();
  var unidad = $("#v_unidad").val();
  var elaboro = $("#elaboro").val();
  var disponible = $("#disponible").val();
  var borrar = "0";
  if ($("#eliminar").is(":checked"))
  {
    if (plan == "-")
    {
      salida = false;
      var detalle = "Debe seleccionar un Plan / Solicitud";
      alerta(detalle);
    }
  }
  else
  {
    if (plan == "-")
    {
      salida = false;
      var detalle = "Debe seleccionar un Plan / Solicitud";
      alerta(detalle);
    }
    if (soporte == "-")
    {
      salida = false;
  		var detalle = "Debe seleccionar un Tipo de Soporte";
      alerta(detalle);
    }
    if ((kilometraje == "") || (kilometraje == "0") || (kilometraje == "0.0"))
    {
      salida = false;
      var detalle = "Kilometraje No Válido";
      alerta(detalle);
    }
    if ((consumo == "") || (consumo == "0") || (consumo == "0.0") || (consumo == "0.00"))
    {
      salida = false;
      var detalle = "Cantidad de Galones No Válido";
      alerta(detalle);
    }
    if ((precio == "") || (precio == "0") || (precio == "0.0") || (precio == "0.00"))
    {
      salida = false;
      var detalle = "Total Factura No Válido";
      alerta(detalle);
    }
    disponible = parseFloat(disponible);
    precio1 = parseFloat(precio1);
    var diferencia = disponible-precio1;
    if (diferencia<0)
    {
      //salida = false;
      //var detalle = "Total No Permitido para el Plan / Solicitud";
      //alerta(detalle);
    }
  }
  if (salida == false)
  {
  }
  else
  {
    if ($("#eliminar").is(":checked"))
    {
      borrar = "1";
    }
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "tran_grab1.php",
      data:
      {
      	tipo: tipo,
        tipo1: tipo1,
      	placa: placa,
      	fecha: fecha,
      	plan: plan,
      	mision: mision,
        soporte: soporte,
      	kilometraje: kilometraje,
        consumo: consumo,
      	precio: precio,
        precio1: precio1,
        odometro: odometro,
      	usuario: usuario,
        unidad: unidad,
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
          $("#v_plan").prop("disabled",true);
          $("#v_kilometraje").prop("disabled",true);
          $("#v_consumo").prop("disabled",true);
          $("#v_kilometros").val(kilometraje);
          $("#v_odometro").val('0');
          $("#dialogo").dialog("close");
          if (id == "0")
          {
          }
          else
          {
            if (borrar == "1")
            {
              if (salida == "1")
              {
                $("#calendario").fullCalendar("removeEvents", id);
              }
            }
          }
          var informacion = "Cant. Galones: "+consumo+"\nKilometraje: "+kilometraje1+"\nTotal Factura: "+precio+"\nPlan / Solicitud: "+plan+"\nMisión: "+mision1;
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
}
function nuevo1()
{
  var tipo = $("#tipo").val();
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
          var paso4 = var_ocu[3];
          var paso5 = var_ocu[4];
          seleccionadosarray.push(paso2);
          document.getElementById('v_paso1').value = document.getElementById('v_paso1').value+paso2+"|";
          document.getElementById('v_paso2').value = document.getElementById('v_paso2').value+paso4+"|";
        }
      }
    );
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_grab2.php",
    data:
    {
      tipo: tipo,
      conses: seleccionadosarray,
      acto: $("#numero1").val(),
      fecha: $("#fecha1").val(),
      unidad: $("#unidad1").val(),
      compania: $("#compania1").val(),
      observaciones: $("#observaciones1").val(),
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
          $("#aceptar3").hide();
          $("#numero1").prop("disabled",true);
          $("#fecha1").prop("disabled",true);
          $("#unidad1").prop("disabled",true);
          $("#compania1").prop("disabled",true);
          $("#observaciones1").prop("disabled",true);
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
function calculo()
{
  var fecha1 = $("#v_fecha1").val();
  var fecha2 = $("#v_fecha2").val();
  var tipo = $("#tipo1").val();
  var solicitudes = $("#solicitudes").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "tran_movi2.php",
    data:
    {
      fecha1: fecha1,
      fecha2: fecha2,
      tipo: tipo,
      solicitudes: solicitudes
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
      var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");     
      $("#total3").val(total1);
      $("#total4").val(total);
    }
  });
}
function borrar()
{
  if ($("#eliminar").is(":checked"))
  {
    $("#v_kilometraje").prop("disabled",true);
    $("#v_consumo").prop("disabled",true);
    $("#v_precio").prop("disabled",true);
    $("#v_kilometraje").val('0');
    $("#v_consumo").val('0.00');
    $("#v_precio").val('0.00');
    $("#v_precio1").val('0');
    $("#aceptar1").show();
  }
  else
  {
    $("#v_kilometraje").prop("disabled",false);
    $("#v_consumo").prop("disabled",false);
    $("#v_precio").prop("disabled",false);
  }
}
function cerrar()
{
  $("#dialogo").dialog("close");
}
function ver(valor, valor1, valor2, valor3, valor4, valor5)
{
  var valor, valor1, valor2, valor3, valor4, valor5;
  $("#movi_conse").val(valor);
  $("#movi_tipo").val(valor1);
  $("#movi_placa").val(valor2);
  $("#movi_ano").val(valor3);
  $("#movi_unidad").val(valor4);
  $("#movi_alea").val(valor5);
  formu1.submit();
}
function subir()
{
  var tipo = $("#tipo").val();
  var sigla = $("#unidad1 option:selected").html();
  var alea = $("#alea").val();
  var url = "<a href='./subir15.php?alea="+alea+"&sigla="+sigla+"&tipo="+tipo+"' name='link1' id='link1' class='pantalla-modal'>Link</a>";
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
// 02/08/2023 - Ajuste validacion kilometraje - galones - valor para no arrastar valores
// 08/08/2023 - Ajuste consulta combustible login usuario
// 10/08/2023 - Ajuste a 3 digitos dias finales de registro
// 28/12/2023 - Ajuste grabacion kilimetraje en tabla vehiculos
// 07/03/2024 - Ajuste consulta de placas para usuarios administradores de transportes
// 07/05/2024 - Ajuste validacion borrado de datos del dia
// 14/05/2024 - Ajuste consulta de planes y misiones sin relacion de gastos
// 05/12/2024 - Ajuste calculo 2 decimales valor superior
// 09/04/2025 - Ajuste consulta ultimo kilometraje registrado
// 22/04/2025 - Ajuste buscador campo unidad
// 29/04/2025 - Ajuste consulta cambio de usuario
?>