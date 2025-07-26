<!doctype html>
<?php
session_start();
error_reporting(0);
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('conf.php');
  include('permisos.php');
  $admin1 = "<option value='0'>- SELECCIONAR -</option>
    <option value='1'>REGIMEN INTERNO COMPA&Ntilde;&Iacute;A</option>
    <option value='2'>COMANDANTE DE COMPA&Ntilde;&Iacute;A</option>
    <option value='3'>SUBOFICAL GASTOS RESERVADOS BATALLON</option>
    <option value='4'>COMANDANTE DE BATALLON</option>
    <option value='26'>SUBOFICIAL SEGURIDAD MILITAR</option>
    <option value='27'>OFICIAL DE OPERACIONES BATALLON</option>
    <option value='6'>SUBOFICIAL PLANEACION BRIGADA</option>
    <option value='25'>SUBOFICIAL PLANEACION COMANDO</option>
    <option value='19'>OFICIAL DE FINANCIERA Y PRESUPUESTO C8</option>
    <option value='7'>OFICIAL DE ADMINISTRACI&Oacute;N Y LOG&Iacute;STICA B4</option>
    <option value='30'>AREA DE OPERACIONES</option>
    <option value='29'>AREA DE INTELIGENCIA</option>
    <option value='31'>SUBOFICIAL GASTOS RESERVADOS BRIGADA</option>
    <option value='8'>JEM DE BRIGADA</option>
    <option value='9'>COMANDANTE DE BRIGADA</option>
    <option value='10'>SUBOFICIAL GASTOS RESERVADOS DE COMANDO</option>
    <option value='11'>OFICIAL DE ADMINISTRACI&Oacute;N Y LOG&Iacute;STICA C4</option>
    <option value='12'>JEM DE COMANDO</option>
    <option value='13'>COMANDANTE DE COMANDO</option>
    <option value='14'>SUBOFICIAL PLANEACION PARTIDAS ESPECIALES</option>
    <option value='15'>SUBOFICIAL PLANEACION GR (TESORERO)</option>
    <option value='16'>OFICIAL DE PLANEACION Y DIRECCIONAMIENTO PRESUPUESTAL ADMINISTRATIVO</option>
    <option value='17'>DIRECTOR ADMINISTRATIVO DE INTELIGENCIA Y CONTRAINTELIGENCIA</option>
    <option value='18'>JEFE DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA</option>
    <option value='20'>SUBOFICIAL DE ANALISIS DE RECOMPENSAS</option>
    <option value='21'>DIRECTOR DIRECCION</option>
    <option value='22'>ASISTENTE DIRECCION</option>
    <option value='23'>AYUDANTE DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA</option>
    <option value='24'>ASISTENTE AYUDANTIA</option>
    <option value='32'>ALMACENISTA DIADI</option>
    <option value='33'>SUBOFICIAL EVALUACION Y SEGUIMIENTO</option>";
    //<option value='28'>LIBRE</option>
    //<option value='32'>OFICIAL CI3MO</option>
    //<option value='33'>OFICIAL CI3ME</option>
    //<option value='34'>OFICIAL CI2MC</option>
    //<option value='36'>OFICIAL EVALUACION Y SEGUIMIENTO COMANDO</option>

  $admin2 = "<option value='0'>- SELECCIONAR -</option>
    <option value='1'>SUBOFICIAL GESTION ADMINISTRATIVA S-2</option>
    <option value='3'>OFICIAL INTELIGENCIA BATALLON</option>
    <option value='4'>COMANDANTE DE BATALLON</option>
    <option value='6'>SUBOFICIAL GESTION ADMINISTRATIVA B-2</option>
    <option value='7'>OFICIAL INTELIGENCIA BRIGADA</option>
    <option value='9'>COMANDANTE DE BRIGADA</option>
    <option value='10'>SUBOFICIAL GESTION ADMINISTRATIVA D-2, F-2, C-2</option>
    <option value='11'>OFICIAL INTELIGENCIA DIVISION</option>
    <option value='12'>JEM DE DIVISION</option>
    <option value='13'>COMANDANTE DE DIVISION</option>
    <option value='14'>SUBOFICIAL PLANEACION PARTIDAS ESPECIALES</option>
    <option value='15'>SUBOFICIAL PLANEACION GR (TESORERO)</option>
    <option value='16'>OFICIAL DE PLANEACIÓN Y DIRECCIONAMIENTO PRESUPUESTAL ADMINISTRATIVO</option>
    <option value='17'>DIRECTOR ADMINISTRATIVO DE INTELIGENCIA Y CONTRAINTELIGENCIA</option>
    <option value='18'>JEFE DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA</option>
    <option value='20'>SUBOFICIAL DE ANALISIS DE RECOMPENSAS</option>
    <option value='21'>DIRECTOR DIRECCION</option>
    <option value='22'>ASISTENTE DIRECCION</option>
    <option value='23'>AYUDANTE DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA</option>
    <option value='24'>ASISTENTE AYUDANTIA</option>
    <option value='33'>SUBOFICIAL EVALUACION Y SEGUIMIENTO</option>";
    //<option value='5'>LIBRE</option>
?>
<html lang="es">
<head>
<?php
include('encabezado.php');
?>
</head>
<body>
<?php
include('titulo.php');
?>
<div>
  <div id="soportes">
    <h3>Parametros Iniciales</h3>
    <div>
      <div id="load">
        <center>
          <img src="imagenes/cargando1.gif" alt="Cargando..." />
        </center>
      </div>
      <form name="formu" method="post">
        <center>
          <div class="ui-state-error ui-corner-all" style="padding: 0 .7em; width: 700px;">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>NOTA: Los nombres de Brigadas y Divisiones se encuentran parametrizadas sin espacios<br>y con el numero cero en los casos que aplique, ejemplo BR01, DIV01.</p>
          </div>
        </center>
        <br>
        <table align="center" width="90%" border="0">
          <tr>
            <td width="33%" height="20" valign="bottom">
              <center>
                <b>Unidad</b>
              </center>
            </td>
            <td width="33%" height="20" valign="bottom">
              <center>
                <b>Brigada</b>
              </center>
            </td>
            <td width="34%" height="20" valign="bottom">
              <center>
                <b>Divisi&oacute;n</b>
              </center>
            </td>
          </tr>
          <tr>
            <td>
              <center>
                <input type="text" name="filtro" id="filtro" class="c3" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="20" autocomplete="off"  tabindex="1">
                <?php
                $menu2_2 = odbc_exec($conexion,"SELECT subdependencia,sigla FROM cx_org_sub ORDER BY sigla");
                $menu2 = "<select name='unidad' id='unidad' class='lista_sencilla2' tabindex='2'>";
                $i = 1;
                while($i<$row=odbc_fetch_array($menu2_2))
                {
                  $nombre = trim($row['sigla']);
                  $menu2 .= "\n<option value=$row[subdependencia]>".$nombre."</option>";
                  $i++;
                }
                $menu2 .= "\n</select>";
                echo $menu2;
                ?>
              </center>
            </td>
            <td valign="bottom">
              <center>
                <?php
                $menu3_3 = odbc_exec($conexion,"SELECT dependencia, nombre FROM cx_org_dep ORDER BY nombre");
                $menu3 = "<select name='brigada' id='brigada' class='lista_sencilla2' tabindex='3'>";
                $i = 1;
                while($i<$row=odbc_fetch_array($menu3_3))
                {
                  $nombre = trim($row['nombre']);
                  $menu3 .= "\n<option value=$row[dependencia]>".$nombre."</option>";
                  $i++;
                }
                $menu3 .= "\n</select>";
                echo $menu3;
                ?>
              </center>
            </td>
            <td valign="bottom">
              <center>
                <?php
                $menu4_4 = odbc_exec($conexion,"SELECT unidad, nombre FROM cx_org_uni ORDER BY nombre");
                $menu4 = "<select name='division' id='division' class='lista_sencilla2' tabindex='4'>";
                $i = 1;
                while($i<$row=odbc_fetch_array($menu4_4))
                {
                  $nombre = trim($row['nombre']);
                  $menu4 .= "\n<option value=$row[unidad]>".$nombre."</option>";
                  $i++;
                }
                $menu4 .= "\n</select>";
                echo $menu4;
                ?>
              </center>
            </td>
          </tr>
          <tr>
            <td colspan="2" height="20" valign="bottom">
              <center>
                <b>Unidad</b>
              </center>
            </td>
            <td height="20" valign="bottom">
              <center>
                <b>Ciudad</b>
              </center>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <center>
                <input type="hidden" name="admin1" id="admin1" class="c3" value="<?php echo $admin1; ?>" readonly="readonly">
                <input type="hidden" name="admin2" id="admin2" class="c3" value="<?php echo $admin2; ?>" readonly="readonly">
                <input type="hidden" name="sigla" id="sigla" class="c3" readonly="readonly">
                <input type="hidden" name="uni_cen" id="uni_cen" class="c2" value="0" readonly="readonly">
                <input type="hidden" name="tip_uni" id="tip_uni" class="c2" value="0" readonly="readonly">
                <input type="hidden" name="permisos" id="permisos" class="c3" value="A|01/" readonly="readonly">
                <input type="text" name="n_batallon" id="n_batallon" class="c15" readonly="readonly" tabindex="5">
              </center>
            </td>
            <td>
              <center>
                <input type="text" name="ciudad" id="ciudad" class="c3" value="<?php echo $ciu_usuario; ?>" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="6">
              </center>
            </td>
          </tr>
          <tr>
            <td colspan="2" height="20" valign="bottom">
              <center>
                <b>Compa&ntilde;ia</b>
              </center>
            </td>
            <td height="20" valign="bottom">
              <center>
                <b>Tipo de Usuario</b>
              </center>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <center>
                <select name='compania' id='compania' class='lista_sencilla9' tabindex='7'>
                  <option value='0'>- SELECCIONAR -</option>
                </select>
              </center>
            </td>
            <td>
              <center>
                <select name="admin" id="admin" class="lista_sencilla10"  tabindex="8"></select>
              </center>
            </td>
          </tr>
          <tr>
            <td colspan="2" height="20" valign="bottom">
              <center>
                <b>Grado y Nombre Completo Usuario</b>
              </center>
            </td>
            <td height="20" valign="bottom">
              <center>
                <b>C&eacute;dula o N&uacute;mero de Indentificaci&oacute;n</b>
              </center>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <center>
                <input type="text" name="nombre" id="nombre" class="c15" maxlength="100" value="<?php echo $nom_usuario; ?>" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="9" autocomplete="off">
              </center>
            </td>
            <td>
              <center>
                <input type="text" name="cedula" id="cedula" class="c7" maxlength="15" value="<?php echo $ced_usuario; ?>" tabindex="10" autocomplete="off">
              </center>
            </td>
          </tr>
        </table>
        <div id="centra">
          <br>
        	<hr>
	        <table align="center" width="90%" border="0">
	          <tr>
              <td width="23%" height="20" valign="bottom">
                <center>
                  <b>Nit</b>
                </center>
              </td>
              <td width="22%" height="20" valign="bottom">
                <center>
                  <b>Banco</b>
                </center>
              </td>
              <td width="25%" height="20" valign="bottom">
                <center>
                  <b>N&uacute;mero de Cuenta Bancaria</b>
                </center>
              </td>
              <td width="30%" height="20" valign="bottom">
                <center>
                  <b>Chequera: Cheque Inicial - Final - Actual</b>
                </center>
              </td>
            </tr>
            <tr>
              <td>
                <center>
                  <input type="text" name="nit" id="nit" class="c3" maxlength="13" tabindex="11" autocomplete="off">
                </center>
              </td>
              <td>
                <center>
                  <select name="banco" id="banco" class="lista_sencilla2" tabindex="12">
                    <option value="1">BBVA</option>
                    <option value="2">AV VILLAS</option>
                    <option value="3">DAVIVIENDA</option>
                    <option value="4">BANCOLOMBIA</option>
                    <option value="5">BANCO DE BOGOTA</option>
                    <option value="6">POPULAR</option>
                  </select>
                </center>
              </td>
              <td>
                <center>
                  <input type="text" name="cuenta" id="cuenta" class="c3" maxlength="20" tabindex="13">
                </center>
              </td>
              <td>
                <center>
                  <input type="text" name="cheque" id="cheque" class="c22" tabindex="14" autocomplete="off">
                  &nbsp;&nbsp;&nbsp;
                  <input type="text" name="cheque1" id="cheque1" class="c22" tabindex="15" autocomplete="off">
                  &nbsp;&nbsp;&nbsp;
                  <input type="text" name="cheque2" id="cheque2" class="c22" tabindex="16" autocomplete="off">
                </center>
              </td>
            </tr>
	        </table>
          <br>
        	<hr>
          <table align="center" width="90%" border="0">
            <tr>
              <td width="25%" height="20" valign="bottom">
                <center>
                  <b>Saldo en Bancos</b>
                </center>
              </td>
              <td width="25%" height="20" valign="bottom">
                <center>
                  <b>Gastos en Actividades</b>
                </center>
              </td>
              <td width="25%" height="20" valign="bottom">
                <center>
                  <b>Informaciones</b>
                </center>
              </td>
              <td width="25%" height="20" valign="bottom">
                <center>
                  <b>Recompensas</b>
                </center>
              </td>
            </tr>
            <tr>
              <td>
                <center>
                  <input type="text" name="saldo" id="saldo" class="c7" value="0.00" onfocus="blur();" readonly="readonly" tabindex="17">
                </center>
              </td>
              <td>
                <center>
                  <input type="text" name="gastos" id="gastos" class="c7" value="0.00" onkeyup="suma();" onblur="suma();" tabindex="18" autocomplete="off">
                </center>
              </td>
              <td>
                <center>
                  <input type="text" name="pagos" id="pagos" class="c7" value="0.00" onkeyup="suma();" onblur="suma();" tabindex="19" autocomplete="off">
                </center>
              </td>
              <td>
                <center>
                  <input type="text" name="recompensas" id="recompensas" class="c7" value="0.00" onkeyup="suma();" onblur="suma();" tabindex="20" autocomplete="off">
                </center>
              </td>
            </tr>
          </table>
          <br>
          <hr>
          <div id="rel_unid"></div>
          <input type="hidden" name="num_unis" id="num_unis" readonly="readonly">
          <input type="hidden" name="sig_unis" id="sig_unis" readonly="readonly">
          <input type="hidden" name="inf_unis" id="inf_unis" readonly="readonly">
          <input type="hidden" name="pag_unis" id="pag_unis" readonly="readonly">
          <input type="hidden" name="rec_unis" id="rec_unis" readonly="readonly">
          <br>
          <hr>
          <table align="center" width="90%" border="0">
          	<tr>
            	<td width="25%" height="20" valign="bottom">
              	<center>
                	<b>Ultimo Comprobante Egreso</b>
              	</center>
              </td>
            	<td width="25%" height="20" valign="bottom">
                <center>
                  <b>Ultimo Comprobante Ingreso</b>
                </center>
              </td>
              <td width="25%" height="20" valign="bottom">
                <center>
                  <b>Ultima Misi&oacute;n de Trabajo</b>
                </center>
              </td>
              <td width="25%" height="20" valign="bottom">
                <center>
                  <b>Ultima Acta de Pago</b>
                </center>
              </td>
            </tr>
            <tr>
              <td>
                <center>
                  <input type="text" name="egreso1" id="egreso1" class="c7" value="0" tabindex="24" autocomplete="off">
                </center>
              </td>
              <td>
                <center>
                  <input type="text" name="ingreso1" id="ingreso1" class="c7" value="0" tabindex="25" autocomplete="off">
                </center>
              </td>
              <td>
                <center>
                  <input type="text" name="mision1" id="mision1" class="c7" value="0" tabindex="26" autocomplete="off">
                </center>
              </td>
              <td>
                <center>
                  <input type="text" name="acta1" id="acta1" class="c7" value="0" tabindex="27" autocomplete="off">
                </center>
              </td>
            </tr>
          </table>
        </div>
        <div id="firmas">
          <br>
          <hr>
          <table align="center" width="90%" border="0">
            <tr>
              <td width="50%" height="20" valign="bottom">
                <center>
                  <b>Ejecutor</b>
                </center>
              </td>
              <td width="50%" height="20" valign="bottom">
                <center>
                  <b>Jefe de Estado Mayor</b>
                </center>
              </td>
            </tr>
            <tr>
              <td>
                <table align="center" width="90%" border="0">
                  <tr>
                    <td>
                      <b>Grado - Nombre:</b>
                    </td>
                    <td>
                      <input type="text" name="firma1" id="firma1" class="c17" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="28" autocomplete="off">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <b>Cargo:</b>
                    </td>
                    <td>
                      <input type="text" name="cargo1" id="cargo1" class="c17" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="29" autocomplete="off">
                    </td>
                  </tr>
                </table>
              </td>
              <td>
                <table align="center" width="90%" border="0">
                  <tr>
                    <td>
                      <b>Grado - Nombre:</b>
                    </td>
                    <td>
                      <input type="text" name="firma2" id="firma2" class="c17" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="30" autocomplete="off">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <b>Cargo:</b>
                    </td>
                    <td>
                      <input type="text" name="cargo2" id="cargo2" class="c17" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="31" autocomplete="off">
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td width="50%" height="20" valign="bottom">
                <center>
                  <b>Comandante</b>
                </center>
              </td>
              <td width="50%" height="20" valign="bottom">
                &nbsp;
              </td>
            </tr>
              <td>
                <table align="center" width="90%" border="0">
                  <tr>
                    <td>
                      <b>Grado - Nombre:</b>
                    </td>
                    <td>
                      <input type="text" name="firma3" id="firma3" class="c17" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="32" autocomplete="off">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <b>Cargo:</b>
                    </td>
                    <td>
                      <input type="text" name="cargo3" id="cargo3" class="c17" onblur="javascript:this.value=this.value.toUpperCase();" tabindex="33" autocomplete="off">
                    </td>
                  </tr>
                </table>
              </td>
              <td>
                &nbsp;
              </td>
            </tr>
          </table>
        </div>
        <table align="center" width="90%" border="0">
          <tr>
            <td>
              <center>
                <br>
                <input type="button" name="aceptar1" id="aceptar1" value="Continuar">
              </center>
            </td>
          </tr>
        </table>
      </form>
      <div id="dialogo"></div>
      <div id="dialogo1"></div>
      <div id="dialogo2"></div>
      <div id="dialogo3"></div>
    </div>
  </div>
</div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 270,
    width: 350,
    modal: true,
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
    height: 150,
    width: 300,
    modal: true,
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
  $("#filtro").focus();
  $('#filtro').keyup(function () {
    var valthis = $(this).val().toLowerCase();
    var num = 0;
    $('select#unidad>option').each(function () {
      var text = $(this).text().toLowerCase();
      if(text.indexOf(valthis) !== -1)  
      {
        $(this).show(); $(this).prop('selected',true);
      }
      else
      {
        $(this).hide();
      }
    });
    trae_brigada();
  });
  $("#unidad").change(trae_brigada);
  $("#brigada").prop("disabled",true);
  $("#division").prop("disabled",true);
  $("#n_batallon").prop("disabled",true);
  $("#aceptar1").button();
  $("#aceptar1").click(pregunta1);
  $("#limpiar").button();
  $("#centra").hide();
  $("#firmas").hide();
  $("#admin").change(datos);
  $("#gastos").maskMoney();
  $("#pagos").maskMoney();
  $("#recompensas").maskMoney();
});
function datos()
{
  var valida = $("#admin").val();
  var valida1 = $("#uni_cen").val();
  var valida2 = $("#division").val();
  valida2 = parseInt(valida2);
  if (((valida == "10") || (valida == "15") || (valida == "31"))  && (valida1 == "1"))
  {
    $("#centra").show();
    $("#firmas").show();
  }
  else
  {
    $("#centra").hide();
    $("#firmas").hide();
  }
  var permisos = "";
  if (valida2 > 3)
  {
    switch (valida)
    {
      case '1':
        permisos = "A|01/C|01/C|02/C|03/C|05/D|04/E|01/";
        break;
      case '3':
      case '4':
        permisos = "A|02/";
        break;
      case '5':
        permisos = "E|02/E|03/";
        break;
      case '6':
        permisos = "A|01/A|02/C|01/C|02/C|03/C|05/D|04/E|01/E|02/";
        break;
      case '25':
        permisos = "A|01/A|02/A|03/";
        break;
      case '7':
      case '9':
        permisos = "A|02/";
        break;
      case '10':
        permisos = "A|01/A|02/A|03/B|02/B|03/B|04/B|05/C|01/C|02/C|03/C|05/C|06/D|01/D|02/D|03/D|04/D|05/";
        break;
      case '11':
      case '12':
      case '13':
        permisos = "A|02/A|03/B|02/";
        break;
      case '14':
      case '16':
      case '17':
      case '18':
        permisos = "A|02/A|04/";
        break;
      case '15':
        permisos = "B|01/B|03/B|04/B|05/";
        break;
      case '20':
        permisos = "E|01/E|02/";
        break;
      case '21':
        permisos = "A|02/";
        break;
      case '22':
        permisos = "A|01/C|02/C|03/C|05/";
        break;
      case '23':
        permisos = "A|02/";
        break;
      case '24':
        permisos = "A|01/C|02/C|03/C|05/";
        break;
      default:
        permisos = "";
        break;
    }
  }
  else
  {
    switch (valida)
    {
      case '1':
        permisos = "A|01/C|01/C|02/C|03/C|04/C|05/D|04/";
        break;
      case '2':
        permisos = "A|02/";
        break;
      case '3':
        permisos = "A|01/A|02/C|01/C|02/C|03/C|04/C|05/D|04/E|01/";
        break;
      case '4':
        permisos = "A|02/";
        break;
      case '6':
        permisos = "A|01/A|02/A|03/C|02/C|03/C|05/";
        //A|01/B|02/B|03/B|04/B|05/C|01/C|02/C|03/C|04/C|05/C|06/D|01/D|02/D|03/D|04/D|05/";
        break;
      case '7':
        permisos = "A|02/A|03/B|02/";
        break;
      case '8':
        permisos = "A|02/A|03/B|02/";
        break;
      case '9':
        permisos = "A|02/A|03/B|02/";
        break;
      case '10':
        permisos = "A|03/B|03/B|04/B|05/";
        break;
      case '11':
      case '12':
      case '13':
        permisos = "A|02/A|03/B|02/";
        break;
      case '14':
      case '16':
      case '17':
      case '18':
        permisos = "A|02/A|04/";
        break;
      case '15':
        permisos = "B|01/B|03/B|04/B|05/";
        break;
      case '20':
        permisos = "E|01/E|02/";
        break;
      case '21':
        permisos = "A|02/";
        break;
      case '22':
        permisos = "A|01/C|02/C|03/C|05/";
        break;
      case '23':
        permisos = "A|02/";
        break;
      case '24':
        permisos = "A|01/C|02/C|03/C|05/";
        break;
      case '25':
        permisos = "A|01/A|02/A|03/C|02/C|03/C|05/";
        break;
      case '26':
        permisos = "A|02/";
        break;
      case '27':
        permisos = "A|01/C|01/C|02/C|03/C|05/";
        break;
      case '28':
        permisos = "E|01/E|02/";
        break;
      case '29':
      case '30':
        permisos = "A|01/C|02/C|03/C|04/C|05/";
        break;
      case '19':
      case '31':
        permisos = "A|01/A|02/A|03/B|02/B|03/B|04/B|05/C|01/C|02/C|03/C|05/C|06/D|01/D|02/D|03/D|04/D|05/";
        break;
      default:
        permisos = "";
        break;
    }
  }
  $("#permisos").val(permisos);
}
function trae_brigada()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_brig1.php",
    data:
    {
      unidad: $("#unidad").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      $("#brigada").val(registros.brigada);
      $("#division").val(registros.division);
      if (registros.centralizadora == "1")
      {
      	$("#uni_cen").val('1');
      }
      else
      {
		    $("#uni_cen").val('0');
      }
      $("#tip_uni").val(registros.tipouni);
    }
  });
  var paso = $("#unidad").val();
  actu(paso);
}
function svg1()
{
  var data = $('#signature').jSignature("getData", "svg");
  $('#firma').val(data.join(','));
}
function pregunta1()
{
  var detalle="Esta seguro de continuar ?";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
}
function actu(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_bata.php",
    data:
    {
    	subdependencia: valor
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      $("#n_batallon").val(registros.nombre);
      $("#sigla").val(registros.sigla);
      if (registros.banco  == "0")
      { 
      }
      else
      {
        $("#banco").val(registros.banco);
      }
      $("#cuenta").val(registros.cuenta);
      $("#cheque").val(registros.cheque);
      $("#cheque1").val(registros.cheque1);
      $("#cheque2").val(registros.cheque2);
      $("#nit").val(registros.nit);
      $("#firma1").val(registros.firma1);
      $("#firma2").val(registros.firma2);
      $("#firma3").val(registros.firma3);
      $("#cargo1").val(registros.cargo1);
      $("#cargo2").val(registros.cargo2);
      $("#cargo3").val(registros.cargo3);
      $("#cargo4").val(registros.cargo4);
      trae_cmp(registros.unidad);
    }
  });
}
function trae_cmp(valor)
{
  var valor;
  $("#compania").html('');
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cmp.php",
    data:
    {
      tipo: valor
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida+="<option value='"+codigo+"'>"+nombre+"</option>";
      }
      salida+="<option value='999'>N/A</option>";
      $("#compania").append(salida);
    }
  });
  trae_admin(valor);
}
function trae_admin(valor)
{
  var valor;
  var paso_admin1 = $("#admin1").val();
  var paso_admin2 = $("#admin2").val();
  var valida = $("#tip_uni").val();
  var valida1 = $("#division").val();
  var valida2 = $("#unidad").val();
  $("#admin").html('');
  switch (valor)
  {
    case '1':
    case '2':
    case '3':
      $("#admin").append(paso_admin1);
      break;
    default:
      $("#admin").append(paso_admin2);
      break;
  }
  switch (valida)
  {
    case '4':
      $("#admin option[value=1]").remove();
      $("#admin option[value=2]").remove();
      $("#admin option[value=3]").remove();
      $("#admin option[value=4]").remove();
      $("#admin option[value=6]").remove();
      $("#admin option[value=7]").remove();
      $("#admin option[value=8]").remove();
      $("#admin option[value=9]").remove();
      $("#admin option[value=14]").remove();
      $("#admin option[value=15]").remove();
      $("#admin option[value=16]").remove();
      $("#admin option[value=17]").remove();
      $("#admin option[value=18]").remove();
      //$("#admin option[value=19]").remove();
      $("#admin option[value=20]").remove();
      $("#admin option[value=21]").remove();
      $("#admin option[value=22]").remove();
      $("#admin option[value=23]").remove();
      $("#admin option[value=24]").remove();
      $("#admin option[value=26]").remove();
      $("#admin option[value=27]").remove();
      //$("#admin option[value=28]").remove();
      //$("#admin option[value=29]").remove();
      //$("#admin option[value=30]").remove();
      $("#admin option[value=31]").remove();
      break;
    case '6':
      $("#admin option[value=1]").remove();
    	$("#admin option[value=2]").remove();
    	$("#admin option[value=3]").remove();
    	$("#admin option[value=4]").remove();
      $("#admin option[value=6]").remove();
    	$("#admin option[value=7]").remove();
    	$("#admin option[value=8]").remove();
    	$("#admin option[value=9]").remove();
      $("#admin option[value=14]").remove();
    	$("#admin option[value=15]").remove();
    	$("#admin option[value=16]").remove();
      $("#admin option[value=17]").remove();
    	$("#admin option[value=18]").remove();
    	$("#admin option[value=19]").remove();
    	$("#admin option[value=20]").remove();
      $("#admin option[value=21]").remove();
    	$("#admin option[value=22]").remove();
    	$("#admin option[value=23]").remove();
    	$("#admin option[value=24]").remove();
      $("#admin option[value=25]").remove();
      $("#admin option[value=26]").remove();
      $("#admin option[value=27]").remove();
      $("#admin option[value=28]").remove();
      $("#admin option[value=29]").remove();
      $("#admin option[value=30]").remove();
      $("#admin option[value=31]").remove();
      break;
    case '7':
      $("#admin option[value=1]").remove();
    	$("#admin option[value=2]").remove();
    	$("#admin option[value=3]").remove();
    	$("#admin option[value=4]").remove();
      $("#admin option[value=5]").remove();
    	$("#admin option[value=10]").remove();
    	$("#admin option[value=11]").remove();
    	$("#admin option[value=12]").remove();
      $("#admin option[value=13]").remove();
    	$("#admin option[value=14]").remove();
    	$("#admin option[value=15]").remove();
    	$("#admin option[value=16]").remove();
      $("#admin option[value=17]").remove();
    	$("#admin option[value=18]").remove();
    	$("#admin option[value=19]").remove();
    	$("#admin option[value=20]").remove();
      $("#admin option[value=21]").remove();
    	$("#admin option[value=22]").remove();
    	$("#admin option[value=23]").remove();
    	$("#admin option[value=24]").remove();
      $("#admin option[value=26]").remove();
      $("#admin option[value=27]").remove();
    	break;
    case '8':
      $("#admin option[value=5]").remove();
    	$("#admin option[value=6]").remove();
    	$("#admin option[value=7]").remove();
      $("#admin option[value=8]").remove();
    	$("#admin option[value=9]").remove();
    	$("#admin option[value=10]").remove();
      $("#admin option[value=11]").remove();
    	$("#admin option[value=12]").remove();
    	$("#admin option[value=13]").remove();
    	$("#admin option[value=14]").remove();
      $("#admin option[value=15]").remove();
    	$("#admin option[value=16]").remove();
    	$("#admin option[value=17]").remove();
    	$("#admin option[value=18]").remove();
      $("#admin option[value=19]").remove();
    	//$("#admin option[value=20]").remove();
    	$("#admin option[value=21]").remove();
    	$("#admin option[value=22]").remove();
      $("#admin option[value=23]").remove();
    	$("#admin option[value=24]").remove();
    	$("#admin option[value=25]").remove();
      $("#admin option[value=28]").remove();
      //$("#admin option[value=29]").remove();
      $("#admin option[value=30]").remove();
      $("#admin option[value=31]").remove();
      break;
    default:
      break;
    }
    // Si es brimi1 - brimi2 - brcim1 y brcim2 deja el tipo de usuario 25, se agrega caimi y cacim
    if ((valida2 == "18") || (valida2 == "28") || (valida2 == "40") || (valida2 == "56")  || (valida2 == "8")  || (valida2 == "39"))
    {
    }
    else
    {
    	$("#admin option[value=25]").remove();
    }
  	trae_unidades(valor);
}
function trae_unidades(valor)
{
  var valor;
  var centra = $("#uni_cen").val();
  var brigada = $("#brigada").val();
  var unidad = $("#unidad").val();
  if (centra == "1")
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_uni.php",
      data:
      {
        division: valor,
        brigada: brigada,
        unidad: unidad
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        $("#rel_unid").html('');
        var salida = "";
        salida += '<table align="center" width="70%" border="0">';
        salida += '<tr><td width="25%"><center><b>Unidad</b></center></td><td width="25%"><center><b>Pago Informaci&oacute;n</b></center></td><td width="25%"><center><b>Pago de Recompensas</b></center></td><td width="25%"><center><b>Gastos en Actividades</b></center></td></tr>';
        var y = 1;
        for (var i in registros) 
        {
          var unidad = registros[i].unidad;
          var sigla = registros[i].sigla;
          salida += '<tr><td><input type="text" name="unid_'+y+'" id="unid_'+y+'" class="c10" value="'+unidad+'" readonly="readonly"><input type="text" name="sig_'+y+'" id="sig_'+y+'" class="c5" value='+sigla+' readonly="readonly"></td><td><center><input type="text" name="pinf_'+y+'" id="pinf_'+y+'" class="c7" value="0.00" autocomplete="off"></center></td><td><center><input type="text" name="prec_'+y+'" id="prec_'+y+'" class="c7" value="0.00" autocomplete="off"></center></td><td><center><input type="text" name="gact_'+y+'" id="gact_'+y+'" class="c7" value="0.00" autocomplete="off"></center></td></tr>';
            y++;
        }
        $("#rel_unid").append(salida);
        for(i=1;i<=y;i++)
        {
          $("#pinf_"+i).maskMoney();
          $("#prec_"+i).maskMoney();
          $("#gact_"+i).maskMoney();
        }
      }
    });
  }
}
function graba()
{
  var salida = true, detalle = '';
  if ($("#ciudad").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar la Ciudad<br><br>";
  }
  if (($("#admin").val() == null) || ($("#admin").val() == '') || ($("#admin").val() == '0'))
  {
    salida = false;
    detalle += "Debe seleccionar un Tipo de Usuario<br><br>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
  }
  else
  {
    paso1();
  }
}
function paso1()
{
  document.getElementById('num_unis').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('unid_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('num_unis').value=document.getElementById('num_unis').value+valor+"|";
    }
  }
  document.getElementById('sig_unis').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('sig_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('sig_unis').value=document.getElementById('sig_unis').value+valor+"|";
    }
  }
  document.getElementById('inf_unis').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('pinf_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('inf_unis').value=document.getElementById('inf_unis').value+valor+"|";
    }
  }
  document.getElementById('pag_unis').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('prec_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('pag_unis').value=document.getElementById('pag_unis').value+valor+"|";
    }
  }
  document.getElementById('rec_unis').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('gact_')!=-1)
    {
      valor = document.getElementById(saux).value;
      document.getElementById('rec_unis').value=document.getElementById('rec_unis').value+valor+"|";
    }
  }
  graba1();
}
function graba1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "comp_actu.php",
    data:
    {
      unidad: $("#unidad").val(),
      compania: $("#compania").val(),
      admin: $("#admin").val(),
      permisos: $("#permisos").val(),
      nombre: $("#nombre").val(),
      cedula: $("#cedula").val(),
      firma: $("#firma").val(),
      ciudad: $("#ciudad").val(),
      sigla: $("#sigla").val(),
      nit: $("#nit").val(),
      banco: $("#banco").val(),
      cuenta: $("#cuenta").val(),
      cheque: $("#cheque").val(),
      cheque1: $("#cheque1").val(),
      cheque2: $("#cheque2").val(),
      saldo: $("#saldo").val(),
      gastos: $("#gastos").val(),
      pagos: $("#pagos").val(),
      recompensas: $("#recompensas").val(),
      egreso1: $("#egreso1").val(),
      ingreso1: $("#ingreso1").val(),
      mision1: $("#mision1").val(),
      acta1: $("#acta1").val(),
      firma1: $("#firma1").val(),
      firma2: $("#firma2").val(),
      firma3: $("#firma3").val(),
      cargo1: $("#cargo1").val(),
      cargo2: $("#cargo2").val(),
      cargo3: $("#cargo3").val(),
      tipou: $("#tip_uni").val(),
      tipoc: $("#uni_cen").val(),
      num_unis: $("#num_unis").val(),
      sig_unis: $("#sig_unis").val(),
      inf_unis: $("#inf_unis").val(),
      pag_unis: $("#pag_unis").val(),
      rec_unis: $("#rec_unis").val()
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
        redirecciona();
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
function suma()
{
	var valor, valor1, valor2, valor3, valor4;
	valor = document.getElementById('gastos').value;
  if (valor == "")
  {
    valor = "0";
    $("#gastos").val('0.00');
  }
  valor = parseFloat(valor.replace(/,/g,''));
  valor = parseInt(valor);
	valor1 = document.getElementById('pagos').value;
  if (valor1 == "")
  {
    valor1 = "0";
    $("#pagos").val('0.00');
  }
	valor1 = parseFloat(valor1.replace(/,/g,''));
  valor1 = parseInt(valor1);
	valor2 = document.getElementById('recompensas').value;
  if (valor2 == "")
  {
    valor2 = "0";
    $("#recompensas").val('0.00');
  }
	valor2 = parseFloat(valor2.replace(/,/g,''));
	valor2 = parseInt(valor2);
  valor3 = valor+valor1+valor2;
	valor4 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	$("#saldo").val(valor4);
}
function redirecciona()
{
  location.href = "principal.php";
}
</script>
</body>
</html>
<?php
}
?>