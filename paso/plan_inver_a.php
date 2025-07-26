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
  $fecha = date('Y/m/d');
  $ano = date('Y');
  $mes = date('m');
  if ($mes == "12")
  {
    $mes = 1;
    $ano = $ano+1;
  }
  else
  {
    $mes = $mes+1;
  }
  $mes1 = date('m');
  $ano1 = date('Y');
?>
<html lang="es">
<head>
<?php
include('encabezado.php');
?>
<style>
.multiselect
{
  width: 48em;
  height: 12em !important;    
  border:solid 1px #c0c0c0;
  overflow:auto;
  font-size: 9px !important
}
.multiselect label
{
  display:block;
}
.multiselect-on
{
  color:#ffffff;
  background-color:#000099;
}
</style>
<script type="text/javascript" src="alertas/lib/alertify.js"></script>
<link rel="stylesheet" href="alertas/themes/alertify.core.css"/>
<link rel="stylesheet" href="alertas/themes/alertify.default.css"/>
<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
</head>
<body>
<?php
include('titulo.php');
?>
<div id="tabs">
<ul>
  <li><a href="#tabs-1">Especificaci&oacute;n de Necesidades</a></li>
  <li><a href="#tabs-2">Gastos en Actividades</a></li>
  <li><a href="#tabs-3">Pago de Informaciones</a></li>
  <li><a href="#tabs-4">Consulta de Planes y Solicitudes</a></li>
</ul>
<div id="tabs-1">
<form name="formu" method="post">
  <table align="center" width="95%" border="0">
    <tr>
      <td width="50%" height="20" valign="bottom">
        Registrar Necesidad en Formato:
      </td>
      <td>
        &nbsp;
      </td>
    </tr>
    <tr>
      <td width="50%" height="20" valign="bottom">
        <input type="hidden" name="usu" id="usu" class="c2" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
        <input type="hidden" name="admin" id="admin" class="c2" value="<?php echo $adm_usuario; ?>" readonly="readonly" tabindex="0">
        <input type="hidden" name="cmp" id="cmp" class="c2" value="<?php echo $tip_usuario; ?>" readonly="readonly" tabindex="0">
        <input type="hidden" name="n_unidad" id="n_unidad" class="c2" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
        <input type="hidden" name="t_unidad" id="t_unidad" class="c2" value="<?php echo $tpu_usuario; ?>" readonly="readonly" tabindex="0">
        <input type="hidden" name="tot_plan" id="tot_plan" class="c2" value="0" readonly="readonly" tabindex="0">
        <select name="tp_plan" id="tp_plan" class="lista_sencilla18" tabindex="1"> 
          <option value="1">PLAN DE INVERSION</option>
          <option value="2">SOLICITUD DE RECURSOS</option>
        </select>
        &nbsp;&nbsp;&nbsp;
        <select name="tp_plan1" id="tp_plan1" class="lista_sencilla19" tabindex="2"> 
          <option value="1">COMPLETO</option>
          <option value="2">ESPECIFICO</option>
        </select>
      </td>
      <td width="50%" height="20" valign="bottom">
        <select name="con_sol" id="con_sol" class="lista_sencilla4" tabindex="3">
          <option value="1">GASTOS EN ACTIVIDADES</option>
          <option value="2">PAGO DE INFORMACIONES</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="50%" height="20" valign="bottom">
        <table width="100%" border="0">
          <tr>
            <td width="30%">
              Fecha
            </td>
            <td width="70%">
              Lugar
            </td>
          </tr>
        </table>
      </td>
      <td width="50%" height="20" valign="bottom">
        <table width="100%" border="0">
          <tr>
            <td width="100%">
              Periodo de Empleo de los Recursos
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td width="50%">
        <table width="100%" border="0">
          <tr>
            <td width="30%">
              <input type="hidden" name="conse" id="conse" class="c2" value="0" readonly="readonly" tabindex="4">
              <input type="hidden" name="plan" id="plan" class="c2" value="0" readonly="readonly" tabindex="5">
              <input type="hidden" name="contador" id="contador" class="c2" value="0" readonly="readonly" tabindex="6">
              <input type="text" name="fecha" id="fecha" class="c1" value="<?php echo $fecha; ?>" readonly="readonly" tabindex="7">
            </td>
            <td width="70%">
              <input type="text" name="lugar" id="lugar" class="c3" value="<?php echo $ciu_usuario; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="8" autocomplete="off" readonly="readonly">
            </td>
          </tr>
        </table>
      </td>
      <td width="50%">
        <table width="100%" border="0">
          <tr>
            <td width="100%">
              <select name="periodo" id="periodo" class="lista_sencilla8" tabindex="9">
                <option value="1">ENERO</option>
                <option value="2">FEBRERO</option>
                <option value="3">MARZO</option>
                <option value="4">ABRIL</option>
                <option value="5">MAYO</option>
                <option value="6">JUNIO</option>
                <option value="7">JULIO</option>
                <option value="8">AGOSTO</option>
                <option value="9">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
              </select>
              &nbsp;
              <input type="text" name="ano" id="ano" class="c13" value="<?php echo $ano; ?>" readonly="readonly" tabindex="10">
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td width="50%" height="20" valign="bottom">
        Factor de Amenaza
      </td>
      <td width="50%" height="20" valign="bottom">
        Estructura
      </td>
    </tr>
    <tr>
      <td width="50%">
        <div class="input-group">
          <input type="text" id="txtFiltro" class="c6" placeholder="Buscar Amenaza">
        </div>
        <div name="factor" id="factor" class="multiselect form-control"></div>
      </td>
      <td width="50%" valign="top">
        <div class="input-group">
          <input type="text" id="txtFiltro1" class="c6" placeholder="Buscar Estructura">
        </div>
        <div name="estructura" id="estructura" class="multiselect form-control"></div>
      </td>
    </tr>
    <tr>
      <td width="50%" height="20" valign="bottom">
        OMAVE - OMINA - OMIRE
      </td>
      <td width="50%" height="20" valign="bottom">
        &nbsp;
      </td>
    </tr>
    <tr>
      <td width="50%" valign="top">
        <select name="oms" id="oms" class="form-control select2" multiple="multiple" style="width: 95%;" data-placeholder="Seleccione uno o varios OMAVE - OMINA - OMIRE" tabindex='11'>
          <option value='999'>N/A</option>
        </select>
      </td>
      <td width="50%">
        <div id="des_fac" align="justify"></div>
      </td>
    </tr>
    <tr>
      <td colspan="2" height="20" valign="bottom">
        <div id="lb_organiza">
          Personal Participante en la ORDOP IMI / Misi&oacute;n IMI
        </div>
      </td>
    </tr>
    <tr>
      <td width="50%">
        <table border="0">
          <tr>
            <td width="40%">
              <div id="lb_oficiales">
                Oficiales:
              </div>
            </td>
            <td width="60%">
              <div id="cm_oficiales">
                <input type="text" name="oficiales" id="oficiales" value="0" class="c2" tabindex="12" autocomplete="off">
              </div>
            </td>
          </tr>
          <tr>
            <td width="40%">
              <div id="lb_auxiliares">
                Auxiliares:&nbsp;&nbsp;&nbsp;
              </div>
            </td>
            <td width="60%">
              <div id="cm_auxiliares">
                <input type="text" name="auxiliares" id="auxiliares" value="0" class="c2" tabindex="13" autocomplete="off">
              </div>
            </td>
          </tr>
        </table>
      </td>
      <td width="50%">
        <table border="0">
          <tr>
            <td width="40%">
              <div id="lb_suboficiales">
                Sub Oficiales:
              </div>
            </td>
            <td width="60%">
              <div id="cm_suboficiales">
                <input type="text" name="suboficiales" id="suboficiales" value="0" class="c2" tabindex="14" autocomplete="off">
              </div>
            </td>
          </tr>
          <tr>
            <td width="40%">
              <div id="lb_soldados">
                Soldados Profesionales:&nbsp;&nbsp;&nbsp;
              </div>
            </td>
            <td width="60%">
              <div id="cm_soldados">
                <input type="text" name="soldados" id="soldados" value="0" class="c2" tabindex="15" autocomplete="off">
              </div>
            </td>
        </table>
      </td>
    </tr>
    <tr>
      <td width="50%" height="20" valign="bottom">
        <div id="lb_ordop">
          ORDOP IMI
        </div>
      </td>
      <td width="50%" height="20" valign="bottom">
        <div id="lb_misiones">
          Misi&oacute;n IMI
        </div>
      </td>
    </tr>
    <tr>
      <td width="50%" valign="top">
        <div id="cm_ordop">
          <input type="text" name="ordop1" id="ordop1" class="c10" onchange="javascript:this.value=this.value.toUpperCase();" onblur="val_ordop();" maxlength="5" tabindex="16" autocomplete="off">     
          <input type="text" name="ordop" id="ordop" class="c3" onchange="javascript:this.value=this.value.toUpperCase();" onblur="val_ordop4();" maxlength="100" tabindex="17" autocomplete="off">
        </div>
      </td>
      <td width="50%">
        <div id="add_form">
          <table width="100%" align="center" border="0">
            <tr>
              <td colspan="2"></td>
            </tr>
          </table>
        </div>
        <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0"></a>
        <br>
        <input type="hidden" name="misiones" id="misiones" readonly="readonly">
        <input type="hidden" name="paso" id="paso" readonly="readonly">
        <input type="hidden" name="paso1" id="paso1" readonly="readonly">
        <input type="hidden" name="paso2" id="paso2" readonly="readonly">
        <input type="hidden" name="paso3" id="paso3" readonly="readonly">
        <input type="hidden" name="paso4" id="paso4" readonly="readonly">
        <input type="hidden" name="paso5" id="paso5" readonly="readonly">
        <input type="hidden" name="paso6" id="paso6" readonly="readonly">
        <input type="hidden" name="paso7" id="paso7" readonly="readonly">
        <input type="hidden" name="paso8" id="paso8" readonly="readonly">
        <input type="hidden" name="paso9" id="paso9" readonly="readonly">
        <input type="hidden" name="paso10" id="paso10" readonly="readonly">
        <input type="hidden" name="paso11" id="paso11" readonly="readonly">
        <input type="hidden" name="paso12" id="paso12" readonly="readonly">
        <?php
        $query_i = "SELECT cedula,nombre FROM cx_pla_inf WHERE unidad='$uni_usuario'";
        $sql_i = odbc_exec($conexion, $query_i);
        $j=1;
        while($j<$row=odbc_fetch_array($sql_i))
        {
          $ayu_lla.='"'.trim(odbc_result($sql_i,1)).'",';
          $j++;
        }
        $ayu_lla=substr($ayu_lla,0,-1);
        ?>
      </td>
    </tr>
  </table>
  <br>
  <div id="botones">
    <center>
      <input type="button" name="aceptar" id="aceptar" value="Continuar">
      &nbsp;
      <input type="button" name="limpiar" id="limpiar" value="Limpiar">
    </center>
  </div>
  <div id="botones5">
    <center>
      <input type="button" name="actualizar" id="actualizar" value="Actualizar">
      &nbsp;&nbsp;&nbsp;
      <input type="button" name="nuevo" id="nuevo" onclick="recarga();" value="Nuevo">
    </center>
  </div>
</form>
<div id="dialogo"></div>
<div id="dialogo1"></div>
<div id="dialogo8"></div>
<div id="dialogo9"></div>
<div id="load">
  <center>
    <img src="imagenes/cargando.gif" alt="Cargando..." />
  </center>
</div>
</div>
<!--
Gastos
-->
<div id="tabs-2">
<div id="campos"></div>
<input type="hidden" name="m_misi" id="m_misi" readonly="readonly">
<input type="hidden" name="m_fact" id="m_fact" readonly="readonly">
<input type="hidden" name="m_estru" id="m_estru" readonly="readonly">
<input type="hidden" name="m_actis" id="m_actis" readonly="readonly">
<input type="hidden" name="m_areas" id="m_areas" readonly="readonly">
<input type="hidden" name="m_feis" id="m_feis" readonly="readonly">
<input type="hidden" name="m_fefs" id="m_fefs" readonly="readonly">
<input type="hidden" name="m_ofs" id="m_ofs" readonly="readonly">
<input type="hidden" name="m_sus" id="m_sus" readonly="readonly">
<input type="hidden" name="m_aus" id="m_aus" readonly="readonly">
<input type="hidden" name="m_sos" id="m_sos" readonly="readonly">
<input type="hidden" name="m_v_gas1" id="m_v_gas1" readonly="readonly">
<input type="hidden" name="m_v_gas2" id="m_v_gas2" readonly="readonly">
<input type="hidden" name="m_v_gas3" id="m_v_gas3" readonly="readonly">
<input type="hidden" name="m_v_gas4" id="m_v_gas4" readonly="readonly">
<div id="botones2">
  <center>
    <input type="button" name="aceptar2" id="aceptar2" value="Continuar">
  </center>
</div>
<div id="botones4">
  <center>
    <input type="button" name="anexos" id="anexos" value="Anexos">
    &nbsp;&nbsp;&nbsp;
    <input type="button" name="aceptar4" id="aceptar4" value="Visualizar">
    &nbsp;&nbsp;&nbsp;
    <input type="button" name="aceptar5" id="aceptar5" value="Solicitar Revisión">
  </center>
</div>
<div id="dialogo4"></div>
<div id="dialogo5"></div>
<div id="load2">
  <center>
    <img src="imagenes/cargando.gif" alt="Cargando..." />
  </center>
</div>
</div>
<!--
Informaciones
-->
<div id="tabs-3">
<form name="formu1" method="post">
  <div id="add_form1">
    <table align="center" width="95%" border="0">
      <tr>
        <td></td>
      </tr>
    </table>
  </div>
  <a href="#" name="add_field1" id="add_field1"><img src="imagenes/boton1.jpg" border="0"></a>
  <br>
  <br>Total Solicitud:&nbsp;&nbsp;&nbsp;<input type="text" name="t_sol" id="t_sol"  class="c7" value="0.00" readonly="readonly">&nbsp;&nbsp;&nbsp;Total Aprobado:&nbsp;&nbsp;&nbsp;<input type="text" name="t_soa" id="t_soa"  class="c7" value="0.00" readonly="readonly">
</form>
<input type="hidden" name="cedulas" id="cedulas" readonly="readonly">
<input type="hidden" name="nombres" id="nombres" readonly="readonly">
<input type="hidden" name="factores" id="factores" readonly="readonly">
<input type="hidden" name="estructuras" id="estructuras" readonly="readonly">
<input type="hidden" name="fechassu" id="fechassu" readonly="readonly">
<input type="hidden" name="sintesis" id="sintesis" readonly="readonly">
<input type="hidden" name="difusiones" id="difusiones" readonly="readonly">
<input type="hidden" name="ndifusiones" id="ndifusiones" readonly="readonly">
<input type="hidden" name="fechasdi" id="fechasdi" readonly="readonly">
<input type="hidden" name="cresulta" id="cresulta" readonly="readonly">
<input type="hidden" name="nradiogramas" id="nradiogramas" readonly="readonly">
<input type="hidden" name="fechasra" id="fechasra" readonly="readonly">
<input type="hidden" name="utilidades" id="utilidades" readonly="readonly">
<input type="hidden" name="valores" id="valores" readonly="readonly">
<input type="hidden" name="unidades" id="unidades" readonly="readonly">
<br>
<div id="botones1">
  <center>
    <input type="button" name="aceptar1" id="aceptar1" value="Continuar">
  </center>
</div>
<div id="botones3">
  <center>
    <input type="button" name="anexos1" id="anexos1" value="Anexos">
    &nbsp;&nbsp;&nbsp;
    <input type="button" name="aceptar3" id="aceptar3" value="Visualizar">
    &nbsp;&nbsp;&nbsp;
    <input type="button" name="aceptar6" id="aceptar6" value="Solicitar Revisión">
  </center>
</div>
<div id="dialogo2"></div>
<div id="dialogo3"></div>
<div id="dialogo6"></div>
<div id="dialogo7">
  <form name="formu4">
    <div id="val_modi"></div>
  </form>
</div>
<div id="load1">
  <center>
    <img src="imagenes/cargando.gif" alt="Cargando..." />
  </center>
</div>
</div>
<!--
Consultas
-->
<div id="tabs-4">
  <div id="content">
    <div id="menu">
      <h3>Menu</h3>
      <table align="center" width="100%" border="0">
      <tr>
        <td height="20" valign="top" width="45%">
          <label><b>Tipo de Consulta</b></label>
        </td>
        <td height="20" valign="top" width="55%">
          <label name="l_consu" id="l_consu"><b>Unidad</b></label>
        </td>
      </tr>
      <tr>
        <td>
            <select name="tipo_c" id="tipo_c" class="lista_sencilla4">
              <option value="3">TODOS</option>
              <option value="1">PLAN DE INVERSION</option>
              <option value="2">SOLICITUD DE RECURSOS</option>
            </select>
        </td>
        <td>
          <input type="text" name="filtro" id="filtro" class="c3" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="20" autocomplete="off">
          <?php
          $menu1_1 = odbc_exec($conexion,"SELECT subdependencia,sigla FROM cx_org_sub ORDER BY sigla");
          $menu1 = "<select name='b_unidad' id='b_unidad' class='lista_sencilla8'>";
          $i = 1;
          $menu1 .= "\n<option value='999'>- TODAS -</option>";
          while($i<$row=odbc_fetch_array($menu1_1))
          {
            $nombre = trim($row['sigla']);
            $menu1 .= "\n<option value=$row[subdependencia]>".$nombre."</option>";
            $i++;
          }
          $menu1 .= "\n</select>";
          echo $menu1;
          ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" height="20" valign="top">
          <label><b>Fecha</b></label>
        </td>
      </tr>
      <tr>
        <td colspan="2">
            <input type="text" name="fecha1" id="fecha1" class="c1" placeholder="yy/mm/dd" readonly="readonly">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="fecha2" id="fecha2" class="c1" placeholder="yy/mm/dd" readonly="readonly">
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <br>
          <center>
            <input type="button" name="consultar" id="consultar" value="Consultar">
          </center>
        </td>
      </tr>
      </table>
    </div>
    <br>
	<div id="load3">
		<center>
	    	<img src="imagenes/cargando.gif" alt="Cargando..." />
		</center>
	</div>
    <div id="tabla"></div>
    <div id="resultados4"></div>
    <br>
    <div id="l_ajuste">
      <center>
        <label for="ajuste">Ajuste de Lineas Firma:</label>
        <input name="ajuste" id="ajuste" value="0">
      </center>
    </div>
    <form name="formu3" action="ver_plan.php" method="post" target="_blank">
      <input type="hidden" name="plan_conse" id="plan_conse" readonly="readonly">
      <input type="hidden" name="plan_ano" id="plan_ano" readonly="readonly">
      <input type="hidden" name="plan_tipo" id="plan_tipo" readonly="readonly">
      <input type="hidden" name="plan_ajust" id="plan_ajust" readonly="readonly">
    </form>
  </div>
</div>
</div>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
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
      monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
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
  $("#load2").hide();
  $("#load3").hide();
  $("#load4").hide();
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
    },
  });
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 340,
    width: 350,
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
          $( this ).dialog( "close" );
        }
      }
    ]
  });
  $("#dialogo1").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 150,
    width: 480,
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
        $( this ).dialog( "close" );
        paso();
      },
      "Cancelar": function() {
        $( this ).dialog( "close" );
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 375,
    width: 400,
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
          $( this ).dialog( "close" );
        }
      }
    ]
  });
  $("#dialogo3").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 150,
    width: 300,
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
        $( this ).dialog( "close" );
        paso1();
      },
      Cancelar: function() {
        $( this ).dialog( "close" );
      }
    }
  });
  $("#dialogo4").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 270,
    width: 350,
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
          $( this ).dialog( "close" );
        }
      }
    ]
  });
  $("#dialogo5").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 150,
    width: 300,
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
        $( this ).dialog( "close" );
        paso2();
      },
      Cancelar: function() {
        $( this ).dialog( "close" );
      }
    }
  });
  $("#dialogo6").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 220,
    width: 440,
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
          $( this ).dialog( "close" );
        }
      }
    ]
  });
  $("#dialogo7").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 400,
    width: 720,
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
      "Enviar": function() {
        enviar();
      },
      Cancelar: function() {
        $( this ).dialog( "close" );
      }
    }
  });
  $("#dialogo8").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 150,
    width: 450,
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
        $( this ).dialog( "close" );
        anul();
      },
      Cancelar: function() {
        $( this ).dialog( "close" );
      }
    }
  });
  $("#dialogo9").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 150,
    width: 270,
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
      "Si": function() {
        $( this ).dialog( "close" );
        envio2();
      },
      "No": function() {
        $( this ).dialog( "close" );
        envio1();
      }
    }
  });
  $("#menu").accordion({
    collapsible: true
  });
  $("#oms").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true,
    width: 'resolve'
  });
  $('#filtro').keyup(function () {
    var valthis = $(this).val().toLowerCase();
    var num = 0;
    $('select#b_unidad>option').each(function () {
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
  });
  trae_difu();
  trae_estruc();
  trae_omss();
  trae_factores();
  trae_pagos();
  trae_unidades();
  trae_actividades();
  trae_amenazas();
  trae_estructuras();

  var MaxInputs       = 99;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      FieldCount++;
      if (z == "1")
      {
        $("#add_form table").append('<tr><td width="55%"><input type="text" name="mis_'+z+'" id="mis_'+z+'" class="c3" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" tabindex="18"></td><td width="45%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>');
      }
      else
      {
        $("#add_form table").append('<tr><td width="55%"><input type="text" name="mis_'+z+'" id="mis_'+z+'" class="c3" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off"></td><td width="45%"><div id="men_'+z+'"><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      }
      x_1++;
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    if(x_1 > 1)
    {
      $(this).closest('tr').remove();
    }
    return false;
  })
  $("#add_field").click();
  // Formulario dinamico de pagos
  var InputsWrapper1   = $("#add_form1 table tr");
  var AddButton1       = $("#add_field1");
  var x_2               = InputsWrapper1.length;
  var FieldCount1      = 1;
  $(AddButton1).click(function (e) {
    var paso1, paso2, paso6;
    paso1 = $("#paso").val();
    paso2 = $("#paso2").val();
    paso3 = $("#paso3").val();
    paso6 = $("#paso4").val();
    var y = x_2;
    FieldCount1++;
    if (y == "1")
    {
      $("#add_form1 table").append('<tr><td>Fuente&nbsp;&nbsp;&nbsp;<input type="text" name="ced_'+y+'" id="ced_'+y+'" class="c5" onchange="javascript:this.value=this.value.toUpperCase(); trae_fuente('+y+')" maxlength="20" autocomplete="off" placeholder="K o Cedula" onkeyup="valida_inf('+y+');">&nbsp;&nbsp;&nbsp;<input type="text" name="nom_'+y+'" id="nom_'+y+'" class="c6" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" placeholder="Nombre Completo"><br><br>Factor de Amenaza&nbsp;&nbsp;&nbsp;<select name="fac_'+y+'" id="fac_'+y+'" class="lista_sencilla5" onchange="estruc('+y+')"></select><br><br>Estructura&nbsp;&nbsp;&nbsp;<select name="est_'+y+'" id="est_'+y+'" class="lista_sencilla5"></select><br><br>Fecha Suministro de la Información&nbsp;&nbsp;&nbsp;<input type="text" class="c1" name="fec_'+y+'" id="fec_'+y+'" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly"><br><br>Síntesis de la Información<br><textarea name="sin_'+y+'" id="sin_'+y+'" onblur="javascript:this.value=this.value.toUpperCase();"></textarea><br><br>Difusión&nbsp;&nbsp;&nbsp;<select name="dif_'+y+'" id="dif_'+y+'" class="lista_sencilla17"></select>&nbsp;&nbsp;&nbsp;Unidad / Dependencia&nbsp;&nbsp;&nbsp;<input type="text" name="fil_'+y+'" id="fil_'+y+'" class="c14" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="20" autocomplete="off">&nbsp;<select name="uni_'+y+'" id="uni_'+y+'" class="lista_sencilla7"><option value="0">- SELECCIONAR -</option></select><br><br>Número&nbsp;&nbsp;&nbsp;<input type="text" name="n_dii_'+y+'" id="n_dii_'+y+'" class="c8" value="0" autocomplete="off" maxlength="25">&nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;<input type="text" class="c1" name="fed_'+y+'" id="fed_'+y+'" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly"><br><br>Condujo Resultado&nbsp;&nbsp;&nbsp;<select name="res_'+y+'" id="res_'+y+'" class="lista_sencilla6" onchange="veri1('+y+')"><option value="2">NO</option><option value="1">SI</option></select>&nbsp;&nbsp;&nbsp;Radiograma No.&nbsp;&nbsp;&nbsp;<input type="text" name="nrad_'+y+'" id="nrad_'+y+'" class="c2" value="0" autocomplete="off" disabled="disabled">&nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;<input type="text" class="c1" name="fer_'+y+'" id="fer_'+y+'" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly" disabled="disabled"><br><br>Utilidad de la Información<br><textarea name="uti_'+y+'" id="uti_'+y+'" onblur="javascript:this.value=this.value.toUpperCase();"></textarea><br><br>Valor Solicitado&nbsp;&nbsp;&nbsp;<input type="text" name="vas_'+y+'" id="vas_'+y+'" class="c7" value="0.00" onkeyup="paso_val1('+y+');suma1()" autocomplete="off"><input type="hidden" name="vap_'+y+'" id="vap_'+y+'" value="0">&nbsp;&nbsp;&nbsp;Valor Aprobado&nbsp;&nbsp;&nbsp;<input type="text" name="vaa_'+y+'" id="vaa_'+y+'" class="c7" value="0.00" readonly="readonly"><hr><br></td></tr>');
    }
    else
    {
      $("#add_form1 table").append('<tr><td>Fuente&nbsp;&nbsp;&nbsp;<input type="text" name="ced_'+y+'" id="ced_'+y+'" class="c5" onchange="javascript:this.value=this.value.toUpperCase(); trae_fuente('+y+')" maxlength="20" autocomplete="off" placeholder="K o Cedula" onkeyup="valida_inf('+y+');">&nbsp;&nbsp;&nbsp;<input type="text" name="nom_'+y+'" id="nom_'+y+'" class="c6" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" placeholder="Nombre Completo"><br><br>Factor de Amenaza&nbsp;&nbsp;&nbsp;<select name="fac_'+y+'" id="fac_'+y+'" class="lista_sencilla5" onchange="estruc('+y+')"><option value="-">- SELECCIONAR -</option></select><br><br>Estructura&nbsp;&nbsp;&nbsp;<select name="est_'+y+'" id="est_'+y+'" class="lista_sencilla5"><option value="-">- SELECCIONAR -</option></select><br><br>Fecha Suministro de la Información&nbsp;&nbsp;&nbsp;<input type="text" class="c1" name="fec_'+y+'" id="fec_'+y+'" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly"><br><br>Síntesis de la Información<br><textarea name="sin_'+y+'" id="sin_'+y+'" onblur="javascript:this.value=this.value.toUpperCase();"></textarea><br><br>Difusión&nbsp;&nbsp;&nbsp;<select name="dif_'+y+'" id="dif_'+y+'" class="lista_sencilla17"></select>&nbsp;&nbsp;&nbsp;Unidad / Dependencia&nbsp;&nbsp;&nbsp;<input type="text" name="fil_'+y+'" id="fil_'+y+'" class="c14" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="20" autocomplete="off">&nbsp;<select name="uni_'+y+'" id="uni_'+y+'" class="lista_sencilla7"><option value="0">- SELECCIONAR -</option></select><br><br>N&uacute;mero&nbsp;&nbsp;&nbsp;<input type="text" name="n_dii_'+y+'" id="n_dii_'+y+'" class="c8" value="0" autocomplete="off" maxlength="25">&nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;<input type="text" class="c1" name="fed_'+y+'" id="fed_'+y+'" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly"><br><br>Condujo Resultado&nbsp;&nbsp;&nbsp;<select name="res_'+y+'" id="res_'+y+'" class="lista_sencilla6" onchange="veri1('+y+')"><option value="2">NO</option><option value="1">SI</option></select>&nbsp;&nbsp;&nbsp;Radiograma No.&nbsp;&nbsp;&nbsp;<input type="text" name="nrad_'+y+'" id="nrad_'+y+'" class="c2" value="0" autocomplete="off" disabled="disabled">&nbsp;&nbsp;&nbsp;Fecha&nbsp;&nbsp;&nbsp;<input type="text" class="c1" name="fer_'+y+'" id="fer_'+y+'" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly" disabled="disabled"><br><br>Utilidad de la Información<br><textarea name="uti_'+y+'" id="uti_'+y+'" onblur="javascript:this.value=this.value.toUpperCase();"></textarea><br><br>Valor Solicitado&nbsp;&nbsp;&nbsp;<input type="text" name="vas_'+y+'" id="vas_'+y+'" class="c7" value="0.00" onkeyup="paso_val1('+y+');suma1()" autocomplete="off"><input type="hidden" name="vap_'+y+'" id="vap_'+y+'" value="0">&nbsp;&nbsp;&nbsp;Valor Aprobado&nbsp;&nbsp;&nbsp;<input type="text" name="vaa_'+y+'" id="vaa_'+y+'" class="c7" value="0.00" readonly="readonly"><div id="mes_'+y+'"><br><a href="#" class="removeclass1"><img src="imagenes/boton3.jpg" border="0"></a></div><hr><br></td></tr>');
    }
    $("#fil_"+y).keyup(function () {
      var valthis = $(this).val().toLowerCase();
      var num = 0;
      $("select#uni_"+y+">option").each(function () {
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
    });
    $("#fac_"+y).append(paso1);
    $("#est_"+y).append(paso3);
    $("#uni_"+y).append(paso6);
    if (y == "1")
    {
      var factoresarray = [];
      $("input[name='factores[]']").each(
        function ()
        {
          if ($(this).is(":checked"))
          {
            factoresarray.push($(this).val());
          }
        }
      );
      var n_factores = factoresarray.length;
      if (n_factores == "1")
      {
        var v_factores = factoresarray;
        v_factores = parseInt(v_factores);
        $("#fac_1").val(v_factores);
      }
      var estructurasarray = [];
      $("input[name='estructuras[]']").each(
        function ()
        {
          if ($(this).is(":checked"))
          {
            estructurasarray.push($(this).val());
          }
        }
      );
      var n_estructuras = estructurasarray.length;
      if (n_estructuras == "1")
      {
        var v_estructuras = estructurasarray;
        v_estructuras = parseInt(v_estructuras);
        $("#est_1").val(v_estructuras);
      }
    }
    $("#sin_"+y).css('width',650);
    $("#fec_"+y).datepicker({
      dateFormat: "yy/mm/dd",
      minDate: "-60d",
      maxDate: 0,
      changeYear: true,
      changeMonth: true,
      onSelect: function () {
        $("#fed_"+y).prop("disabled",false);
        $("#fed_"+y).datepicker("destroy");
        $("#fed_"+y).val('');
        $("#fed_"+y).datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#fec_"+y).val(),
          maxDate: 0,
          changeYear: true,
          changeMonth: true,
          onSelect: function () {
            $("#fer_"+y).datepicker("destroy");
            $("#fer_"+y).val('');
            $("#fer_"+y).datepicker({
              dateFormat: "yy/mm/dd",
              minDate: $("#fed_"+y).val(),
              maxDate: 0,
              changeYear: true,
              changeMonth: true,
            });
          },
        });
      },
    });
    $("#dif_"+y).append(paso2);
    $("#uti_"+y).css('width',650);
    $("#vas_"+y).maskMoney();
    var v_fuen = [<?php echo $ayu_lla; ?>];
    $("#ced_"+y).autocomplete({source: v_fuen});
    x_2++;
    return false;
  });
  $("body").on("click",".removeclass1", function(e) {
    $(this).closest('tr').remove();
    suma1();
    return false;
  });
  // Inicio
  $("#tp_plan").focus();
  $("#tp_plan").change(valida_tipo);
  $("#con_sol").hide();
  $("#con_sol").change(valida_tipo1);
  $("#tp_plan1").change(valida_tipo2);
  $("#tabs").tabs();
  $("#tabs").tabs({
    disabled: [ 1, 2 ]
  });
  $("#aceptar").button();
  $("#aceptar1").button();
  $("#aceptar2").button();
  $("#aceptar3").button();
  $("#aceptar4").button();
  $("#aceptar5").button();
  $("#aceptar6").button();
  $("#consultar").button();
  $("#actualizar").button();
  $("#nuevo").button();
  $("#limpiar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar1").click(pregunta1);
  $("#aceptar2").click(pregunta2);
  $("#aceptar3").click(imprimir);
  $("#aceptar4").click(imprimir);
  $("#aceptar5").click(solicitar);
  $("#aceptar6").click(solicitar);
  $("#limpiar").click(limpiar);
  $("#consultar").click(consultar);
  $("#actualizar").click(actu);
  $("#botones3").hide();
  $("#botones4").hide();
  $("#botones5").hide();
  $("#factor").change(trae_estructura);
  $("#periodo").prop("disabled",true);
  $("#anexos").button();
  $("#anexos").click(anexar);
  $("#anexos1").button();
  $("#anexos1").click(anexar);
  $("#l_ajuste").hide();
  $("#ajuste").spinner({ min: 0 });
  $("#ajuste").width(50);
  $("#periodo").val('<?php echo $mes; ?>');
  $("#mis_1").prop("disabled",true);
  // Si es asistente direccion o ayudantia
  var admin = $("#admin").val();
  if ((admin == "22") || (admin == "24"))
  {
    $("#tp_plan").prop("disabled",true);
    $("#tp_plan").val('2').change();
    $("#con_sol").prop("disabled",true);
  }
  var usu = $("#usu").val();
  if ((usu == 'ADM_SIGAR') || (usu == 'CX-JAIME') || (usu == 'CX-ALFREDO'))
  {
    $("#l_consu").show();
    $("#filtro").show();
    $("#b_unidad").show();
  }
  else
  {
    $("#l_consu").hide();
    $("#filtro").hide();
    $("#b_unidad").hide();
  }
  total_planes();
});
</script>
<script>
function trae_amenazas()
{
  $("#txtFiltro").val('');
  listaoficinas = [];
  $("#factor").empty();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_ame.php",
    beforeSend: function ()
    {
      $("#load").show();
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      $("#load").hide();
      $("#dialogo").html("Se presenta el siguiente incidente al intentar ejectuar esta consulta.<br>Codigo: " + jqXHR.status + "<br>" + textStatus + "<br>" + errorThrown);
      $("#dialogo").dialog("open");
    },
    success: function (data)
    {
      $("#load").hide();
      var registros = JSON.parse(data);
      $('#factor').append('<label><input type="checkbox" name="oficinasAll" id="oficinasAll" value="0"><font size="2">-- SELECCIONAR TODOS --</label>');
      $.each(registros.rows, function (index, value)
      {
        listaoficinas.push({value: value.codigo, label: value.nombre});
        $('#factor').append('<label><input type="checkbox" name="factores[]" value="' + value.codigo + '"><font size="2">' + value.nombre + '</font></label>');
      });
      $("#txtFiltro").autocomplete({
        source: listaoficinas,
        select: function (event, ui) {
          $("input[name='factores[]']").each(
            function ()
            {
              if ($(this).val() == ui.item.value)
              {
                $(this).attr('checked', true);
                $("#txtFiltro").val(ui.item.label);
              }
            }
          );
          return false;
        }
      });
      $('#oficinasAll').click(function () {
        $("input[name='factores[]']").each(
          function ()
          {
            if ($("#oficinasAll").is(':checked'))
            {
              $(this).prop('checked', true);
            }
            else
            {
              $(this).prop('checked', false);
            }
          }
        );
      });
    }
  });
}
function trae_estructuras()
{
  $("#txtFiltro1").val('');
  listaoficinas = [];
  $("#estructura").empty();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_est.php",
    beforeSend: function ()
    {
      $("#load").show();
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      $("#load").hide();
      $("#dialogo").html("Se presenta el siguiente incidente al intentar ejectuar esta consulta.<br>Codigo: " + jqXHR.status + "<br>" + textStatus + "<br>" + errorThrown);
      $("#dialogo").dialog("open");
    },
    success: function (data)
    {
      $("#load").hide();
      var registros = JSON.parse(data);
      $('#estructura').append('<label><input type="checkbox" name="oficinasAll" id="oficinasAll" value="0"><font size="2">-- SELECCIONAR TODOS --</label>');
      $.each(registros.rows, function (index, value)
      {
        listaoficinas.push({value: value.codigo, label: value.nombre});
        $('#estructura').append('<label><input type="checkbox" name="estructuras[]" value="' + value.codigo + '"><font size="2">' + value.nombre + '</font></label>');
      });
      $("#txtFiltro1").autocomplete({
        source: listaoficinas,
        select: function (event, ui) {
          $("input[name='estructuras[]']").each(
            function ()
            {
              if ($(this).val() == ui.item.value)
              {
                $(this).attr('checked', true);
                $("#txtFiltro1").val(ui.item.label);
              }
            }
          );
          return false;
        }
      });
      $('#oficinasAll').click(function () {
        $("input[name='estructuras[]']").each(
          function ()
          {
            if ($("#oficinasAll").is(':checked'))
            {
              $(this).prop('checked', true);
            }
            else
            {
              $(this).prop('checked', false);
            }
          }
        );
      });
    }
  });
}
// Valida numero de ordop
function val_ordop()
{
  var admin = $("#admin").val();
  var conse = $("#conse").val();
  var ordop = $("#ordop1").val();
  var blanco = 0;
  if (ordop == "")
  {
    blanco = 1;
    $("#ordop1").removeClass("ui-state-error");
  }
  else
  {
    ordop1 = $("#ordop1");
    var allFields = $([]).add(ordop1);
    var valid = true;
    ordop1.removeClass("ui-state-error");
    valid = checkRegexp(ordop1, /^([0-9])+$/, "Solo se premite caracteres: 0 - 9");
    if (valid == false)
    {
      $("#aceptar").hide();
      $("#actualizar").hide();
    }
    else
    {
      if (conse > 0)
      {
        $("#actualizar").show();
        $("#aceptar").hide();
      }
      else
      {
        $("#actualizar").hide();
        $("#aceptar").show();
      }
      if (admin == "3")
  	  {
      }
    	else
      {
        val_ordop1();
      }
    }
  }
}
function val_ordop1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_ordop.php",
    data:
    {
      ordop: $("#ordop1").val(),
      ano: $("#ano").val(),
      compa: $("#cmp").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      if (registros.salida == "1")
      {
        $("#ordop1").addClass("ui-state-error");
        var conse = registros.plan;
        var detalle;
        detalle = "ORDOP ya registrada en el Plan / Solicitud "+conse;
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#aceptar").hide();
      }
      else
      {
        $("#ordop1").removeClass("ui-state-error");
        $("#aceptar").show();
      }
    }
  });
}
// Valida nombre de ordop
function val_ordop2()
{
  var conse = $("#conse").val();
  var ordop = $("#ordop").val();
  if (ordop == "")
  {
    $("#aceptar").hide();
    $("#actualizar").hide();
  }
  else
  {
    if (conse > 0)
    {
    	$("#actualizar").show();
      $("#aceptar").hide();
    }
    else
    {
      $("#actualizar").hide();
      $("#aceptar").show();
    }
    val_ordop3();
  }
}
function val_ordop3()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_ordop1.php",
    data:
    {
      ordop: $("#ordop").val(),
      ano: $("#ano").val(),
      compa: $("#cmp").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      if (registros.salida == "1")
      {
        $("#ordop").addClass("ui-state-error");
        var conse = registros.plan;
        var detalle;
        detalle = "ORDOP ya registrada en el Plan / Solicitud "+conse;
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#mis_1").prop("disabled",true);
        $("#aceptar").hide();
      }
      else
      {
        $("#mis_1").prop("disabled",false);
        $("#mis_1").focus();
        $("#ordop").removeClass("ui-state-error");
        $("#aceptar").show();
      }
    }
  });  
}
function val_ordop4()
{
  var detalle = "";
  var valor = $("#ordop").val().trim().length;
  if (valor == '0')
  {
    detalle = "Nombre ORDOP IMI Obligatorio";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#mis_1").prop("disabled",true);
    $("#aceptar").hide();
  }
  else
  {
    $("#mis_1").prop("disabled",false);
    $("#mis_1").focus();
    $("#aceptar").show();
  }
}
function checkRegexp(o, regexp, n)
{
  if (!(regexp.test(o.val())))
  {
    o.addClass("ui-state-error");
    $("#dialogo").html(n);
    $("#dialogo").dialog("open");
    return false;
  }
  else
  {
    return true;
  }
}
function checkRegexp1(o, regexp)
{
  if (!(regexp.test(o.val())))
  {
    o.addClass("ui-state-error");
    return false;
  }
  else
  {
    return true;
  }
}
function val_mis(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_misi.php",
    data:
    {
      ordop: $("#ordop1").val(),
      ano: $("#ano").val(),
      compa: $("#cmp").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var misiones = registros.misiones;
      var var_ocu = misiones.split('|');
      var var_ocu1 = var_ocu.length;
      var paso = "";
      for (var i=0; i<var_ocu1-1; i++)
      {
        paso += var_ocu[i]+"#";
      }
      val_mis1(valor, paso);
    }
  });
}
function val_mis1(valor,valor1)
{
  var valor, valor1, valor2, valor3, conse;
  var lista = [];
  var var_ocu = valor1.split('#');
  var var_ocu1 = var_ocu.length;
  for (var i=0; i<var_ocu1-1; i++)
  {
    lista.push(var_ocu[i]);
  }
  conse = $("#conse").val();
  valor1 = $("#mis_"+valor);
  valor2 = valor1.val();
  valor1.removeClass("ui-state-error");
  var valid = true;
  var resulta = true;
  valid = checkRegexp1(valor1, /^([0-9])+$/);
  if (valid == true)
  {
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux=document.formu.elements[i].name;
      if (saux.indexOf('mis_')!=-1)
      {
        valor3 = document.getElementById(saux).value;
        if (jQuery.inArray(valor3, lista) != -1)
        {
          valor1.addClass("ui-state-error");
          resulta = false;
        }
        else
        {
          valor1.removeClass("ui-state-error");
          lista.push(valor3);
        }
      }
    }
  }
  if (resulta == false)
  {
    if (conse == "0")
    {
      $("#aceptar").hide();
    }
    else
    {
      $("#actualizar").hide();
    }
  }
  else
  {
    if (conse == "0")
    {
      $("#aceptar").show();
    }
    else
    {
      $("#actualizar").show();
    } 
  }
}
function valida_tipo()
{
  var valida;
  valida = $("#tp_plan").val();
  if (valida == "1")
  {
    $("#tp_plan1").show();
    $("#con_sol").hide();
    $("#lb_organiza").show();
    $("#lb_oficiales").show();
    $("#lb_auxiliares").show();
    $("#lb_suboficiales").show();
    $("#lb_soldados").show();
    $("#lb_ordop").show();
    $("#lb_misiones").show();
    $("#cm_oficiales").show();
    $("#cm_auxiliares").show();
    $("#cm_suboficiales").show();
    $("#cm_soldados").show();
    $("#cm_ordop").show();
    $("#add_field").show();
    $("#mis_1").show();
    $("#periodo").val(<?php echo $mes; ?>);
    $("#ano").val(<?php echo $ano; ?>);
  }
  else
  {
    $("#tp_plan1").hide();
    $("#con_sol").show();
    $("#con_sol").val('1');
    $("#periodo").val(<?php echo $mes1; ?>);
    $("#ano").val(<?php echo $ano1; ?>);
  }
  total_planes();
}
</script>
<script>
function valida_tipo1()
{
  	var valida;
  	valida = $("#con_sol").val();
  	if (valida == "1")
  	{
    	enciende1();
  	}
  	else
  	{
    	apaga1();
  	}
}
function valida_tipo2()
{
  var valida;
  valida = $("#tp_plan1").val();
  if (valida == "1")
  {
    $("#con_sol").hide();
  }
  else
  {
    $("#con_sol").show(); 
  }
}
function campos(valor)
{
  $("#campos").html('');
  var valor;
  var salida;
  var paso;
  var paso_act;
  paso_act = $("#paso6").val();
  salida="";
  salida='<form name="formu2" method="post">';
  salida+='<b>ORDOP</b>&nbsp;&nbsp;&nbsp;<input type="text" name="operacion" id="operacion" class="c3" readonly="readonly"><br><br><b>Factor de Amenaza</b>&nbsp;&nbsp;&nbsp;<input type="text" name="factor1" id="factor1" class="c20" readonly="readonly"><br><br><b>Estructura</b>&nbsp;&nbsp;&nbsp;<input type="text" name="estructura1" id="estructura1" class="c20" readonly="readonly"><br><br>';
  for (i=1;i<=valor;i++)
  {
    salida+='<img src="imagenes/lupa_mas.png" border="0" width="20" height="20" id="bot_'+i+'" onclick="return mostrarOcultar('+i+')" align="absmiddle" class="mas">&nbsp;&nbsp;&nbsp;<b>Misión</b>&nbsp;&nbsp;&nbsp;<input type="text" name="misi_'+i+'" id="misi_'+i+'" class="c3" readonly="readonly"><br><div id="t_misi_'+i+'"><br>Factor&nbsp;&nbsp;&nbsp;<select name="facto_'+i+'" id="facto_'+i+'" class="form-control select2" multiple="multiple" style="width: 90%;" data-placeholder="Seleccione uno o varios factores" /><br><br>Estructura&nbsp;&nbsp;&nbsp;<select name="estru_'+i+'" id="estru_'+i+'" class="form-control select2" multiple="multiple" style="width: 85%;" data-placeholder="Seleccione una o varias estructuras" /></select><br><br>Actividades&nbsp;&nbsp;&nbsp;<select name="acti_'+i+'" id="acti_'+i+'" class="lista_sencilla13"></select><br><br>Area General&nbsp;&nbsp;&nbsp;<input type="text" name="area_'+i+'" id="area_'+i+'" class="c6" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="250" autocomplete="off"><br><br>Lapso del&nbsp;&nbsp;&nbsp;<input type="text" class="c1" name="fei_'+i+'" id="fei_'+i+'" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly">&nbsp;&nbsp;&nbsp;al&nbsp;&nbsp;&nbsp;<input type="text" class="c1" name="fef_'+i+'" id="fef_'+i+'" placeholder="yy/mm/dd" autocomplete="off" readonly="readonly"><br><br>Personal Participante en la Misión<br><br>Oficiales:&nbsp;&nbsp;&nbsp;<input type="text" name="of_'+i+'" id="of_'+i+'" class="c2" onkeyup="val_org1('+i+'); val_orgt1('+i+')" value="0" autocomplete="off">&nbsp;&nbsp;&nbsp;Sub Oficiales:&nbsp;&nbsp;&nbsp;<input type="text" name="su_'+i+'" id="su_'+i+'" class="c2" onkeyup="val_org2('+i+'); val_orgt2('+i+')" value="0" autocomplete="off">&nbsp;&nbsp;&nbsp;Auxiliares:&nbsp;&nbsp;&nbsp;<input type="text" name="au_'+i+'" id="au_'+i+'" class="c2" onkeyup="val_org3('+i+'); val_orgt3('+i+')" value="0" autocomplete="off">&nbsp;&nbsp;&nbsp;Soldados Profesionales:&nbsp;&nbsp;&nbsp;<input type="text" name="so_'+i+'" id="so_'+i+'" class="c2" onkeyup="val_org4('+i+'); val_orgt4('+i+')" value="0" autocomplete="off"><br><br>Conceptos del Gasto Solicitados<br><div id="add_form_'+i+'"><table width="80%" border="0"><tr><td colspan="4"></td></tr></table></div><a href="#" name="add_field_'+i+'" id="add_field_'+i+'" onclick="agrega('+i+');"><img src="imagenes/boton1.jpg" border="0"></a><br><br><input type="hidden" name="m_gas_'+i+'" id="m_gas_'+i+'" class="c3" readonly="readonly"><input type="hidden" name="m_otr_'+i+'" id="m_otr_'+i+'" class="c3" readonly="readonly"><input type="hidden" name="m_vag_'+i+'" id="m_vag_'+i+'" class="c3" readonly="readonly"><br>Total Gastos Misión:&nbsp;&nbsp;&nbsp;<input type="text" name="m_sum_'+i+'" id="m_sum_'+i+'"  class="c7" value="0.00" readonly="readonly">&nbsp;&nbsp;&nbsp;Total Gastos Aprobados:&nbsp;&nbsp;&nbsp;<input type="text" name="m_sua_'+i+'" id="m_sua_'+i+'"  class="c7" value="0.00" readonly="readonly"><br><br><hr><br></div><br>';
  }
  salida+='</form>';
  $("#campos").append(salida);
  var op1,op2,op3,fac1,est1,misi1,fac2,est2;
  op1 = $("#ordop").val();
  op2 = $("#ordop1").val();
  op3 = op2+" "+op1;
  $("#operacion").val(op3);
  fac1 = $("#paso7").val();
  $("#factor1").val(fac1);
  est1 = $("#paso8").val();
  $("#estructura1").val(est1);
  fac2 = $("#paso9").val();
  est2 = $("#paso10").val();
  // Nombres misiones
  misi1 = $("#misiones").val();
  var v1 = misi1.split('|');
  var x = 0;
  for (j=1;j<=valor;j++)
  {
    $("#bot_"+j).click();
    paso = v1[x];
    $("#misi_"+j).val(paso);
    x++;
    $("#fei_"+j).datepicker({
      dateFormat: "yy/mm/dd",
      minDate: 0,
      changeYear: true,
      changeMonth: true,
      onSelect: function () {
        var v_1 = $(this).attr("id");
        var v_2 = v_1.split('_');
        var v_3 = v_2[1];
        $("#fef_"+v_3).prop("disabled",false);
        $("#fef_"+v_3).datepicker("destroy");
        $("#fef_"+v_3).val('');
        $("#fef_"+v_3).datepicker({
          dateFormat: "yy/mm/dd",
          minDate: $("#fei_"+v_3).val(),
          changeYear: true,
          changeMonth: true,
        });
      },
    });
    $("#facto_"+j).append(fac2);
    $("#facto_"+j).select2({
      tags: false,
      allowClear: false,
      closeOnSelect: true,
      width: 'resolve'
    });
    $("#estru_"+j).append(est2);
    $("#estru_"+j).select2({
      tags: false,
      allowClear: false,
      closeOnSelect: true,
      width: 'resolve'
    });
    //vali_fac(j);
    $("#acti_"+j).append(paso_act);
  }
  var paso_ofi = $("#oficiales").val();
  var paso_sub = $("#suboficiales").val();
  var paso_aux = $("#auxiliares").val();
  var paso_sol = $("#soldados").val();
  $("#of_1").val(paso_ofi);
  $("#su_1").val(paso_sub);
  $("#au_1").val(paso_aux);
  $("#so_1").val(paso_sol);
}
function vali_fac(valor)
{
  var valor;
  var valor1 = $("#facto_"+valor).val();
  var valor2 = $("#conse").val();
  $("#estru_"+valor).html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_facto.php",
    data:
    {
      factor: valor1,
      conse: valor2
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
      $("#estru_"+valor).append(salida);
    }
  });
}
function mostrarOcultar(id)
{
  var id;
  var nombre = "t_misi_"+id;
  var elemento = document.getElementById(nombre);
  if (!elemento)
  {
    return true;
  }
  if (elemento.style.display == "none")
  {
    elemento.style.display = "block";
    $("#bot_"+id).attr("src","imagenes/lupa_menos.png");
  }
  else
  {
    elemento.style.display = "none";
    $("#bot_"+id).attr("src","imagenes/lupa_mas.png");
  };
  return true;
}
// Validacion de organizacion de mision menor al numero total de necesidad
// Oficiales
function val_org1(valor)
{
  var valor;
  var valida,valida1;
  var detalle;
  valida = $("#oficiales").val();
  valida = parseInt(valida);
  valida1 = $("#of_"+valor).val();
  valida1 = parseInt(valida1);
  if (valida1 > valida)
  {
    detalle = "Número de Oficiales ("+valida1+") no Valido para la Misión, debe ser menor o igual a ("+valida+")";
    $("#dialogo4").html(detalle);
    $("#dialogo4").dialog("open");
    $("#of_"+valor).val('0');
  }
}
// Suboficiales
function val_org2(valor)
{
  var valor;
  var valida,valida1;
  var detalle;
  valida = $("#suboficiales").val();
  valida = parseInt(valida);
  valida1 = $("#su_"+valor).val();
  valida1 = parseInt(valida1);
  if (valida1 > valida)
  {
    detalle = "Número de Sub Oficiales ("+valida1+") no Valido para la Misión, debe ser menor o igual a ("+valida+")";
    $("#dialogo4").html(detalle);
    $("#dialogo4").dialog("open");
    $("#su_"+valor).val('0');
  }
}
// Auxiliares
function val_org3(valor)
{
  var valor;
  var valida,valida1;
  var detalle;
  valida = $("#auxiliares").val();
  valida = parseInt(valida);
  valida1 = $("#au_"+valor).val();
  valida1 = parseInt(valida1);
  if (valida1 > valida)
  {
    detalle = "Número de Auxiliares ("+valida1+") no Valido para la Misión, debe ser menor o igual a ("+valida+")";
    $("#dialogo4").html(detalle);
    $("#dialogo4").dialog("open");
    $("#au_"+valor).val('0');
  }
}
// Soldados
function val_org4(valor)
{
  var valor;
  var valida,valida1;
  var detalle;
  valida = $("#soldados").val();
  valida = parseInt(valida);
  valida1 = $("#so_"+valor).val();
  valida1 = parseInt(valida1);
  if (valida1 > valida)
  {
    detalle = "Número de Soldados Profesionales ("+valida1+") no Valido para la Misión, debe ser menor o igual a ("+valida+")";
    $("#dialogo4").html(detalle);
    $("#dialogo4").dialog("open");
    $("#so_"+valor).val('0');
  }
}
// Total Oficiales
function val_orgt1(valor)
{
  var valor;
  var valida,valida1,valida2,valida3;
  var detalle;
  valida = $("#oficiales").val();
  valida = parseInt(valida);
  valida1 = $("#contador").val();
  valida3 = 0;
  for (i=1;i<=valida1;i++)
  {
    valida2 = $("#of_"+i).val();
    valida2 = parseInt(valida2);
    valida3 = valida3+valida2;
  }
  if (valida3 > valida)
  {
    detalle = "Número Total de Oficiales ("+valida3+") no Valido para la Misión, debe ser menor o igual a ("+valida+")";
    $("#dialogo4").html(detalle);
    $("#dialogo4").dialog("open");
    $("#of_"+valor).val('0');
  }
}
// Total Sub Oficiales
function val_orgt2(valor)
{
  var valor;
  var valida,valida1,valida2,valida3;
  var detalle;
  valida = $("#suboficiales").val();
  valida = parseInt(valida);
  valida1 = $("#contador").val();
  valida3 = 0;
  for (i=1;i<=valida1;i++)
  {
    valida2 = $("#su_"+i).val();
    valida2 = parseInt(valida2);
    valida3 = valida3+valida2;
  }
  if (valida3 > valida)
  {
    detalle = "Número Total de Sub Oficiales ("+valida3+") no Valido para la Misión, debe ser menor o igual a ("+valida+")";
    $("#dialogo4").html(detalle);
    $("#dialogo4").dialog("open");
    $("#su_"+valor).val('0');
  }
}
// Total Auxiliares
function val_orgt3(valor)
{
  var valor;
  var valida,valida1,valida2,valida3;
  var detalle;
  valida = $("#auxiliares").val();
  valida = parseInt(valida);
  valida1 = $("#contador").val();
  valida3 = 0;
  for (i=1;i<=valida1;i++)
  {
    valida2 = $("#au_"+i).val();
    valida2 = parseInt(valida2);
    valida3 = valida3+valida2;
  }
  if (valida3 > valida)
  {
    detalle = "Número Total de Auxiliares ("+valida3+") no Valido para la Misión, debe ser menor o igual a ("+valida+")";
    $("#dialogo4").html(detalle);
    $("#dialogo4").dialog("open");
    $("#au_"+valor).val('0');
  }
}
// Total Soldados
function val_orgt4(valor)
{
  var valor;
  var valida,valida1,valida2,valida3;
  var detalle;
  valida = $("#soldados").val();
  valida = parseInt(valida);
  valida1 = $("#contador").val();
  valida3 = 0;
  for (i=1;i<=valida1;i++)
  {
    valida2 = $("#so_"+i).val();
    valida2 = parseInt(valida2);
    valida3 = valida3+valida2;
  }
  if (valida3 > valida)
  {
    detalle = "Número Total de Soldados ("+valida3+") no Valido para la Misión, debe ser menor o igual a ("+valida+")";
    $("#dialogo4").html(detalle);
    $("#dialogo4").dialog("open");
    $("#so_"+valor).val('0');
  }
}
// Agrega nuevos conceptos del gasto
function agrega(valor)
{
  var valor;
  var paso1;
  var InputsWrapper = $("#add_form_"+valor+" table tr");
  var x = InputsWrapper.length;
  var FieldCount = 1;
  paso1 = $("#paso1").val();
  if(x <= 99)
  {
    var y = x;
    FieldCount++;
    $("#add_form_"+valor+" table").append('<tr><td><select name="gas_'+valor+'_'+y+'" id="gas_'+valor+'_'+y+'" class="lista_sencilla1" onchange="veri('+valor+','+y+')"></select></td><td><input type="hidden" name="otr_'+valor+'_'+y+'" id="otr_'+valor+'_'+y+'" class="c3" onchange="javascript:this.value=this.value.toUpperCase();" disabled="disabled" maxlength="100" autocomplete="off"></td><td><input type="text" name="vag_'+valor+'_'+y+'" id="vag_'+valor+'_'+y+'" class="c7" value="0.00" onkeyup="paso_val('+valor+','+y+');suma('+valor+','+y+');" autocomplete="off"><input type="hidden" name="vat_'+valor+'_'+y+'" id="vat_'+valor+'_'+y+'" value="0"></td><td width="10%"><div id="del_'+valor+'_'+y+'"><a href="#" onclick="borra('+valor+','+y+')"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
    x++;
    $("#gas_"+valor+"_"+y).append(paso1);
    $("#vag_"+valor+"_"+y).maskMoney();
    $("#gas_"+valor+"_"+y).focus();
    $('html,body').animate({ scrollTop: 9999 }, 'slow');
  }
}
// Elimina conceptos del gasto
function borra(valor,valor1)
{
  var valor;
  var valor1;
  $("#gas_"+valor+"_"+valor1).val('0');
  $("#gas_"+valor+"_"+valor1).hide();
  $("#otr_"+valor+"_"+valor1).val('');
  $("#otr_"+valor+"_"+valor1).hide();
  $("#vag_"+valor+"_"+valor1).val('0');
  $("#vag_"+valor+"_"+valor1).hide();
  $("#vat_"+valor+"_"+valor1).val('0');
  $("#del_"+valor+"_"+valor1).hide();
  suma(valor,valor1);
  $('html,body').animate({ scrollTop: 9999 }, 'slow');
}
// Valida si el concepto del gasto es otro para permitir digitar
function veri(valor,valor1)
{
  var valor;
  var valor1;
  if ($("#gas_"+valor+"_"+valor1).val()=="99")
  {
    $("#otr_"+valor+"_"+valor1).prop("disabled",false);
  }
  else
  {
    $("#otr_"+valor+"_"+valor1).prop("disabled",true);
    $("#otr_"+valor+"_"+valor1).val('');
  }
}
// Valida si el resultado es SI para datos radiograma
function veri1(valor)
{
  var valor;
  if ($("#res_"+valor).val()=="1")
  {
    $("#nrad_"+valor).prop("disabled",false);
    $("#fer_"+valor).prop("disabled",false);
  }
  else
  {
    $("#nrad_"+valor).prop("disabled",true);
    $("#fer_"+valor).prop("disabled",true);
    $("#nrad_"+valor).val('0');
    $("#fer_"+valor).val('');
  }
}
// Valida si el resultado es SI para datos radiograma en solicitud
function veri2()
{
  var valor;
  if ($("#res_pag").val()=="1")
  {
    $("#nrad_pag").prop("disabled",false);
    $("#fer_pag").prop("disabled",false);
  }
  else
  {
    $("#nrad_pag").prop("disabled",true);
    $("#fer_pag").prop("disabled",true);
    $("#nrad_pag").val('0');
    $("#fer_pag").val('');
  }
}
// Se valida el numero de
function val_ndii(valor)
{
  var valor;
  ndif1 = $("#n_dii_"+valor);
  var allFields = $([]).add(ndif1);
  var valid = true;
  ndif1.removeClass("ui-state-error");
  valid = checkRegexp(ndif1, /^([0-9])+$/, "Solo se premite caracteres: 0 - 9");
}
// Se convierte el valor capturado en moneda para sumarlo en gastos
function paso_val(valor,valor1)
{
  var valor;
  var valor1;
  var valor2;
  valor2=document.getElementById('vag_'+valor+'_'+valor1).value;
  valor2=parseFloat(valor2.replace(/,/g,''));
  $("#vat_"+valor+"_"+valor1).val(valor2);
}
// Se convierte el valor capturado en moneda para sumarlo en pagos
function paso_val1(valor)
{
  var valor;
  var valor1;
  valor1=document.getElementById('vas_'+valor).value;
  valor1=parseFloat(valor1.replace(/,/g,''));
  $("#vap_"+valor).val(valor1);
}
// Se convierte el valor capturado en moneda en solicitudes
function paso_val2()
{
  var valor;
  valor=document.getElementById('vas_pag').value;
  valor=parseFloat(valor.replace(/,/g,''));
  $("#vap_pag").val(valor);
}
// Suma de valores pasados en paso_val
function suma(valor,valor1)
{
  var valor;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('vat_'+valor+'_')!=-1)
    {
      valor2=document.getElementById(saux).value;
      valor2=parseInt(valor2);
      valor3=valor3+valor2;
    }
  }
  valor3=valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#m_sum_"+valor).val(valor3);
}
// Suma de valores pasados en pago de inf
function suma1()
{
  var valor;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('vap_')!=-1)
    {
      valor2=document.getElementById(saux).value;
      valor2=parseInt(valor2);
      valor3=valor3+valor2;
    }
  }
  valor3=valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_sol").val(valor3);
  // Suma de valores aprobados en rechazo
  valor2 = 0;
  valor3 = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('vaa_')!=-1)
    {
      valor2=document.getElementById(saux).value;
      valor2=parseFloat(valor2.replace(/,/g,''));
      valor3=valor3+valor2;
    }
  }
  valor3=valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#t_soa").val(valor3);
}
// Trae factores de amenaza de tabla
function trae_factores()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_fact.php",
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
      $("#paso").val(salida);
    }
  });
}
// Trae actividades
function trae_actividades()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_acti.php",
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
      $("#paso6").val(salida);
    }
  });
}
function trae_pagos()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_pago.php",
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
      //salida+="<option value='99'>Otro</option>";
      $("#paso1").val(salida);
    }
  });
}
// Trae listado difusion de informacion
function trae_difu()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_difu.php",
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
      $("#paso2").val(salida);
    }
  });
}
// Trae listado estrcuturas
function trae_estruc()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_estruc.php",
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
      $("#paso3").val(salida);
    }
  });
}
// Trae listado oms
function trae_omss()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_omss.php",
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
      $("#paso5").val(salida);
    }
  });
}
// Trae estrcuturas segun factor seleccionado
function trae_estructura()
{
  var factoresarray = [];
  $("input[name='factores[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        factoresarray.push($(this).val());
      }
    }
  );
  $("#txtFiltro1").val('');
  listaoficinas = [];
  $("#estructura").empty();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_estu.php",
    data:
    {
      factor: factoresarray
    },
    beforeSend: function ()
    {
      $("#load").show();
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      $("#load").hide();
      $("#dialogo").html("Se presenta el siguiente incidente al intentar ejectuar esta consulta.<br>Codigo: " + jqXHR.status + "<br>" + textStatus + "<br>" + errorThrown);
      $("#dialogo").dialog("open");
    },
    success: function (data)
    {
      $("#load").hide();
      var registros = JSON.parse(data);
      if (registros == null)
      {
        listaoficinas.push({value: '999', label: 'N/A'});
        $('#estructura').append('<label><input type="checkbox" name="estructuras[]" value="999"><font size="2">N/A</font></label>');
      }
      else
      {
        $('#estructura').append('<label><input type="checkbox" name="oficinasAll1" id="oficinasAll1" value="0"><font size="2">-- SELECCIONAR TODOS --</label>');
        $.each(registros.rows, function (index, value)
        {
          listaoficinas.push({value: value.codigo, label: value.nombre});
          $('#estructura').append('<label><input type="checkbox" name="estructuras[]" value="' + value.codigo + '"><font size="2">' + value.nombre + '</font></label>');
        });
        listaoficinas.push({value: '999', label: 'N/A'});
        $('#estructura').append('<label><input type="checkbox" name="estructuras[]" value="999"><font size="2">N/A</font></label>');
      }
      $("#txtFiltro1").autocomplete({
        source: listaoficinas,
        select: function (event, ui) {
          $("input[name='estructuras[]']").each(
            function ()
            {
              if ($(this).val() == ui.item.value)
              {
                $(this).attr('checked', true);
                $("#txtFiltro1").val(ui.item.label);
              }
            }
          );
          return false;
        }
      });
      $('#oficinasAll1').click(function () {
        $("input[name='estructuras[]']").each(
          function ()
          {
            if ($("#oficinasAll1").is(':checked'))
            {
            $(this).prop('checked', true);
            }
            else
            {
              $(this).prop('checked', false);
            }
          }
        );
      });
      mostrar();
      trae_oms();
    }
  });
}
// Trae oms segun factor seleccionado
function trae_oms()
{
  var factoresarray = [];
  $("input[name='factores[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        factoresarray.push($(this).val());
      }
    }
  );
  $("#oms").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_oms.php",
    data:
    {
      factor: factoresarray
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
      $("#oms").append(salida);
    }
  });
}
// Trae estrcuturas segun factor seleccionado
function estruc(valor)
{
  var valor;
  var valor1;
  valor1=$("#fac_"+valor).val();
  $("#est_"+valor).html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_estr.php",
    data:
    {
      factor: valor1
    },
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
        salida+="<option value='"+codigo+"'>"+nombre+"</option>";
      }
      if (j == "0")
      {
        salida+="<option value='999'>N/A</option>";
      }
      $("#est_"+valor).append(salida);
    }
  });
}
// Trae unidades
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
      var salida1 = "";
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
// Trae fuentes de la unidad
function trae_fuente(valor)
{
  var valor;
  var valor1;
  valor1 = $("#ced_"+valor).val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_fuente.php",
    data:
    {
      cedula: valor1
    },
    beforeSend: function ()
    {
      $("#nom_"+valor).attr("placeholder", "Buscando...");
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      $("#nom_"+valor).val(registros.nombre);
    }
  });
}
// Trae definiciones de amenzas
function mostrar()
{
  var factoresarray = [];
  $("input[name='factores[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        factoresarray.push($(this).val());
      }
    }
  );
  $("#des_fac").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_definicion.php",
    data:
    {
      factor: factoresarray
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      $("#des_fac").append(registros.descrip);
    }
  });
}

function pregunta()
{
  var valida,tipo;
  valida = $("#tp_plan").val();
  if (valida == "1")
  {
    tipo = "Plan de Inversi&oacute;n";
  }
  else
  {
    tipo = "Solicitud de Recursos";
  }
  var detalle = tipo+" es el tipo de necesidad que desea gestionar ?";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
}
function pregunta1()
{
  var detalle="Esta seguro de continuar ?";
  $("#dialogo3").html(detalle);
  $("#dialogo3").dialog("open");
}
function pregunta2()
{
  var detalle="Esta seguro de continuar ?";
  $("#dialogo5").html(detalle);
  $("#dialogo5").dialog("open");
}
function pregunta3()
{
  var comp = $("#paso11").val();
  var tipo = $("#paso12").val();
  var tipo1;
  if (tipo == "1")
  {
    tipo1 = "Plan de Inversión";
  }
  else
  {
    tipo1 = "Solicitud de Recursos";
  }
  var detalle="Esta seguro de anular "+tipo1+" No. "+comp+" ?";
  $("#dialogo8").html(detalle);
  $("#dialogo8").dialog("open");
}
function paso()
{
  var valor;
  valor = $("#tp_plan").val();
  $("#plan").val(valor);
  var contador;
  contador = 0;
  document.getElementById('misiones').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('mis_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('misiones').value=document.getElementById('misiones').value+valor+"|";
      contador++;
    }
    $("#contador").val(contador);
  }
  validacionData();
}
function paso1()
{
  document.getElementById('cedulas').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('ced_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('cedulas').value=document.getElementById('cedulas').value+valor+"|";
    }
  }
  document.getElementById('nombres').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('nombres').value=document.getElementById('nombres').value+valor+"|";
    }
  }
  document.getElementById('factores').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('fac_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('factores').value=document.getElementById('factores').value+valor+"|";
    }
  }
  document.getElementById('estructuras').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('est_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('estructuras').value=document.getElementById('estructuras').value+valor+"|";
    }
  }
  document.getElementById('fechassu').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('fec_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('fechassu').value=document.getElementById('fechassu').value+valor+"|";
    }
  }
  document.getElementById('sintesis').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('sin_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('sintesis').value=document.getElementById('sintesis').value+valor+"|";
    }
  }
  document.getElementById('difusiones').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('dif_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('difusiones').value=document.getElementById('difusiones').value+valor+"|";
    }
  }
  document.getElementById('ndifusiones').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('n_dii_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('ndifusiones').value=document.getElementById('ndifusiones').value+valor+"|";
    }
  }
  document.getElementById('fechasdi').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('fed_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('fechasdi').value=document.getElementById('fechasdi').value+valor+"|";
    }
  }
  document.getElementById('unidades').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('uni_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('unidades').value=document.getElementById('unidades').value+valor+"|";
    }
  }
  document.getElementById('cresulta').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('res_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('cresulta').value=document.getElementById('cresulta').value+valor+"|";
    }
  }
  document.getElementById('nradiogramas').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('nrad_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('nradiogramas').value=document.getElementById('nradiogramas').value+valor+"|";
    }
  }
  document.getElementById('fechasra').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('fer_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('fechasra').value=document.getElementById('fechasra').value+valor+"|";
    }
  }
  document.getElementById('utilidades').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('uti_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('utilidades').value=document.getElementById('utilidades').value+valor+"|";
    }
  }
  document.getElementById('valores').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('vas_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('valores').value=document.getElementById('valores').value+valor+"|";
    }
  }
  validacionData2();
}
function paso2()
{
  document.getElementById('m_misi').value="";
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('misi_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('m_misi').value=document.getElementById('m_misi').value+valor+"|";
    }
  }
  document.getElementById('m_fact').value="";
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('facto_')!=-1)
    {
      valor=$("#"+saux).select2('val');
      if (valor == null)
      {
        valor = "";
      }
      document.getElementById('m_fact').value=document.getElementById('m_fact').value+valor+"|";
    }
  }
  document.getElementById('m_estru').value="";
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('estru_')!=-1)
    {
      valor=$("#"+saux).select2('val');
      if (valor == null)
      {
        valor = "";
      }
      document.getElementById('m_estru').value=document.getElementById('m_estru').value+valor+"|";
    }
  }
  document.getElementById('m_actis').value="";
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('acti_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('m_actis').value=document.getElementById('m_actis').value+valor+"|";
    }
  }
  document.getElementById('m_areas').value="";
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('area_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('m_areas').value=document.getElementById('m_areas').value+valor+"|";
    }
  }
  document.getElementById('m_feis').value="";
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('fei_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('m_feis').value=document.getElementById('m_feis').value+valor+"|";
    }
  }
  document.getElementById('m_fefs').value="";
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('fef_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('m_fefs').value=document.getElementById('m_fefs').value+valor+"|";
    }
  }
  document.getElementById('m_ofs').value="";
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('of_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('m_ofs').value=document.getElementById('m_ofs').value+valor+"|";
    }
  }
  document.getElementById('m_sus').value="";
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('su_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('m_sus').value=document.getElementById('m_sus').value+valor+"|";
    }
  }
  document.getElementById('m_aus').value="";
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('au_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('m_aus').value=document.getElementById('m_aus').value+valor+"|";
    }
  }
  document.getElementById('m_sos').value="";
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('so_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('m_sos').value=document.getElementById('m_sos').value+valor+"|";
    }
  }
  // Se  recorre el formulario para obtener los valores
  var valida;
  valida = $("#contador").val();
  for (j=1;j<=valida;j++)
  {
    document.getElementById('m_gas_'+j).value="";
    for (i=0;i<document.formu2.elements.length;i++)
    {
      saux=document.formu2.elements[i].name;
      if (saux.indexOf('gas_'+j+'_')!=-1)
      {
        valor=document.getElementById(saux).value;
        document.getElementById('m_gas_'+j).value=document.getElementById('m_gas_'+j).value+valor+"|";
      }
    }
    document.getElementById('m_otr_'+j).value="";
    for (i=0;i<document.formu2.elements.length;i++)
    {
      saux=document.formu2.elements[i].name;
      if (saux.indexOf('otr_'+j+'_')!=-1)
      {
        valor=document.getElementById(saux).value;
        document.getElementById('m_otr_'+j).value=document.getElementById('m_otr_'+j).value+valor+"|";
      }
    }
    document.getElementById('m_vag_'+j).value="";
    for (i=0;i<document.formu2.elements.length;i++)
    {
      saux=document.formu2.elements[i].name;
      if (saux.indexOf('vag_'+j+'_')!=-1)
      {
        valor=document.getElementById(saux).value;
        document.getElementById('m_vag_'+j).value=document.getElementById('m_vag_'+j).value+valor+"|";
      }
    }
  }
  for (j=1;j<=valida;j++)
  {
    document.getElementById('m_v_gas1').value="";
    for (i=0;i<document.formu2.elements.length;i++)
    {
      saux=document.formu2.elements[i].name;
      if (saux.indexOf('m_gas_')!=-1)
      {
        valor=document.getElementById(saux).value;
        document.getElementById('m_v_gas1').value=document.getElementById('m_v_gas1').value+valor+"»";
      }
    }
    document.getElementById('m_v_gas2').value="";
    for (i=0;i<document.formu2.elements.length;i++)
    {
      saux=document.formu2.elements[i].name;
      if (saux.indexOf('m_otr_')!=-1)
      {
        valor=document.getElementById(saux).value;
        document.getElementById('m_v_gas2').value=document.getElementById('m_v_gas2').value+valor+"»";
      }
    }
    document.getElementById('m_v_gas3').value="";
    for (i=0;i<document.formu2.elements.length;i++)
    {
      saux=document.formu2.elements[i].name;
      if (saux.indexOf('m_vag_')!=-1)
      {
        valor=document.getElementById(saux).value;
        document.getElementById('m_v_gas3').value=document.getElementById('m_v_gas3').value+valor+"»";
      }
    }
    document.getElementById('m_v_gas4').value="";
    for (i=0;i<document.formu2.elements.length;i++)
    {
      saux=document.formu2.elements[i].name;
      if (saux.indexOf('m_sum_')!=-1)
      {
        valor=document.getElementById(saux).value;
        document.getElementById('m_v_gas4').value=document.getElementById('m_v_gas4').value+valor+"»";
      }
    }
  }
  validacionData1();
}
function validacionData()
{
  var valida, valida1, valida2, valida3;
  valida = $("#tp_plan").val();
  valida1 = $("#con_sol").val();
  valida2 = $("#tp_plan1").val();
  valida3 = $("#tot_plan").val();
  var salida = true, detalle = '';
  if ($("#lugar").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar un Lugar<br><br>";
  }
  var factoresarray = [];
  $("input[name='factores[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        factoresarray.push($(this).val());
      }
    }
  );
  var estructurasarray = [];
  $("input[name='estructuras[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        estructurasarray.push($(this).val());
      }
    }
  );
  var num_fac = factoresarray.length;
  var num_est = estructurasarray.length;
  if (num_fac == "0")
  {
    salida = false;
    detalle += "Debe seleccionar un Factor de Amenaza<br><br>";
  }
  if (num_est == "0")
  {
    salida = false;
    detalle += "Debe seleccionar una Estructura<br><br>";
  }
  if ((valida == '1') && (valida1 == '1'))
  {
    var salida1;
    var campo1 = $("#oficiales");
    campo1.removeClass("ui-state-error");
    salida1 = checkRegexp1(campo1, /^([0-9])+$/);
    if (salida1 == false)
    {
      detalle += "Campo Oficiales Invalido<br><br>";
      $("#oficiales").val('0');
    }
    var campo2 = $("#auxiliares");
    campo2.removeClass("ui-state-error");
    salida1 = checkRegexp1(campo2, /^([0-9])+$/);
    if (salida1 == false)
    {
      detalle += "Campo Auxiliares Invalido<br><br>";
      $("#auxiliares").val('0');
    }
    var campo3 = $("#suboficiales");
    campo3.removeClass("ui-state-error");
    salida1 = checkRegexp1(campo3, /^([0-9])+$/);
    if (salida1 == false)
    {
      detalle += "Campo Sub Oficiales Invalido<br><br>";
      $("#suboficiales").val('0');
    }
    var campo4 = $("#soldados");
    campo4.removeClass("ui-state-error");
    salida1 = checkRegexp1(campo4, /^([0-9])+$/);
    if (salida1 == false)
    {
      detalle += "Campo Soldados Invalido<br><br>";
      $("#soldados").val('0');
    }
    var tot_ofi = $("#oficiales").val();
    var tot_aux = $("#auxiliares").val();
    var tot_sub = $("#suboficiales").val();
    var tot_sol = $("#soldados").val();
    tot_ofi = parseInt(tot_ofi);
    tot_aux = parseInt(tot_aux);
    tot_sub = parseInt(tot_sub);
    tot_sol = parseInt(tot_sol);
    var tot_per = tot_ofi+tot_aux+tot_sub+tot_sol;
    if (tot_per == "0")
    {
      salida = false;
      detalle += "Personal Participante No Válido<br><br>";
    }
    if ($("#ordop").val() == '')
    {
      $("#ordop").addClass("ui-state-error");
      salida = false;
      detalle += "Debe ingresar una ORDOP<br><br>";
    }
    else
    {
      $("#ordop").removeClass("ui-state-error");
    }
    if ($("#mis_1").val() == '')
    {
      $("#mis_1").addClass("ui-state-error");
      salida = false;
      detalle += "Debe ingresar un Nombre de Misión<br><br>";
    }
    else
    {
      $("#mis_1").removeClass("ui-state-error");
    }    
  }
  if ((valida == '1') && (valida2 == '2') && (valida1 == '1'))
  {
    if ($("#ordop").val() == '')
    {
      $("#ordop").addClass("ui-state-error");
      salida = false;
      detalle += "Debe ingresar una ORDOP<br><br>";
    }
    else
    {
      $("#ordop").removeClass("ui-state-error");
    }
    if ($("#mis_1").val() == '')
    {
      $("#mis_1").addClass("ui-state-error");
      salida = false;
      detalle += "Debe ingresar un Nombre de Misión<br><br>";
    }
    else
    {
      $("#mis_1").removeClass("ui-state-error");
    }
    var v_misiones = 0;
    var valor;
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux=document.formu.elements[i].name;
      if (saux.indexOf('mis_')!=-1)
      {
        valor = document.getElementById(saux).value.trim().length;
        if (valor == "0")
        {
          v_misiones ++;
        }
      }
    }
    if (v_misiones > 0)
    {
      salida = false;
      detalle += "Debe ingresar "+v_misiones+" Nombre(s) de Mision(es)<br><br>";
    }
  }
  if ((valida == '2') && (valida1 == '1'))
  {
    var tot_ofi = $("#oficiales").val();
    var tot_aux = $("#auxiliares").val();
    var tot_sub = $("#suboficiales").val();
    var tot_sol = $("#soldados").val();
    tot_ofi = parseInt(tot_ofi);
    tot_aux = parseInt(tot_aux);
    tot_sub = parseInt(tot_sub);
    tot_sol = parseInt(tot_sol);
    var tot_per = tot_ofi+tot_aux+tot_sub+tot_sol;
    if (tot_per == "0")
    {
      salida = false;
      detalle += "Personal Participante No Válido<br><br>";
    }
    if ($("#ordop").val() == '')
    {
      $("#ordop").addClass("ui-state-error");
      salida = false;
      detalle += "Debe ingresar una ORDOP<br><br>";
    }
    else
    {
      $("#ordop").removeClass("ui-state-error");
    }
    if ($("#mis_1").val() == '')
    {
      $("#mis_1").addClass("ui-state-error");
      salida = false;
      detalle += "Debe ingresar un Nombre de Misión<br><br>";
    }
    else
    {
      $("#mis_1").removeClass("ui-state-error");
    }
  }
  if (valida3 == "1")
  {
    salida = false;
    detalle += "Ya existe Plan de Inversión registrado<br><br>";
    $("#aceptar").hide();
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
function validacionData1()
{
  var salida = true, detalle = '';
  var areas = 0;
  var valor, valor1;
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('area_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        areas ++;
      }
    }
  }
  if (areas > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+areas+" Area(s)<br><br>";      
  }
  var feis = 0;
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('fei_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        feis ++;
      }
    }
  }
  if (feis > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+feis+" Fecha(s) Inicial(es)<br><br>";      
  }
  var fefs = 0;
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('fef_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        fefs ++;
      }
    }
  }
  if (fefs > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+fefs+" Fecha(s) Final(es)<br><br>";      
  }
  var sumas = 0;
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux=document.formu2.elements[i].name;
    if (saux.indexOf('m_sum_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (valor == "0.00")
      {
        sumas ++;
      }
    }
  }
  if (sumas > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+sumas+" Total(es) Gastos Mision(es)<br><br>";      
  }
  // Validacion valores aprobados
  var conta = $("#contador").val();
  for (i=1;i<=conta;i++)
  {
  	var var_val1, var_vali2, var_vali3
  	var_vali1 = $("#m_sum_"+i).val();
  	var_vali1 = parseFloat(var_vali1.replace(/,/g,''));
  	var_vali1 = parseInt(var_vali1);
  	var_vali2 = $("#m_sua_"+i).val();
  	var_vali2 = parseFloat(var_vali2.replace(/,/g,''));
  	var_vali2 = parseInt(var_vali2);
  	if (var_vali2 > 0)
  	{
  	  if (var_vali1 > var_vali2)
  	  {
  	  	var_vali3 = $("#misi_"+i).val();
  	    salida = false;
  	    detalle += "Gastos Mision "+var_vali3+" superior al aprobado<br><br>";
  	  }
  	}
  }
  if (salida == false)
  {
    $("#dialogo4").html(detalle);
    $("#dialogo4").dialog("open");
  }
  else
  {
    actualiza1();
  }
}
function validacionData2()
{
  var salida = true, detalle = '';
  var cedulas = 0;
  var valor;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('ced_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        cedulas ++;
      }
    }
  }
  if (cedulas > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+cedulas+" Cedula(s) o K(s)<br><br>";      
  }
  var factores = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('fac_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (valor == "-")
      {
        factores ++;
      }
    }
  }
  if (factores > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+factores+" Factor(es) de Amenaza<br><br>";      
  }
  var fechas1 = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('fec_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        fechas1 ++;
      }
    }
  }
  if (fechas1 > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+fechas1+" Fecha(s) Suministro de la Información<br><br>";      
  }
  var sintesis = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('sin_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        sintesis ++;
      }
    }
  }
  if (sintesis > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+sintesis+" Sintesis de la Información<br><br>";      
  }
  var fechas2 = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('fed_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        fechas2 ++;
      }
    }
  }
  if (fechas2 > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+fechas2+" Fecha(s) de Difusión<br><br>";      
  }
  var unidad = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('uni_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (valor == "0")
      {
        unidad ++;
      }
    }
  }
  if (unidad > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+unidad+" Unidad(es)<br><br>";      
  }
  var utilidad = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('uti_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        utilidad ++;
      }
    }
  }
  if (utilidad > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+utilidad+" Utilidad(es) de la Información<br><br>";      
  }
  var valores = 0;
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('vas_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (valor == "0.00")
      {
        valores ++;
      }
    }
  }
  if (valores > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+valores+" Valor(es) Solicitados<br><br>";
  }
  var var_val1, var_vali2;
  var_vali1 = document.getElementById('t_sol').value;
  var_vali1 = parseFloat(var_vali1.replace(/,/g,''));
  var_vali1 = parseInt(var_vali1);
  var_vali2 = document.getElementById('t_soa').value;
  var_vali2 = parseFloat(var_vali2.replace(/,/g,''));
  var_vali2 = parseInt(var_vali2);
  if (var_vali2 > 0)
  {
    if (var_vali1 > var_vali2)
    {
      salida = false;
      detalle += "Total Solicitud superior al Total Aprobado<br><br>";    
    }
  }
  if (salida == false)
  {
    $("#dialogo2").html(detalle);
    $("#dialogo2").dialog("open");
  }
  else
  {
    actualiza();
  }
}
function valida_inf(valor)
{
  var valor;
  var str = 'k';
  var txt = $("#ced_"+valor).val();
  if (txt.indexOf(str) > -1)
  {
    $("#nom_"+valor).val('');
    $("#nom_"+valor).prop("disabled",true);
  }
  else
  {
    $("#nom_"+valor).prop("disabled",false);
  }
}
function valida_inf1()
{
  var str = 'k';
  var txt = $("#ced_pag").val();
  if (txt.indexOf(str) > -1)
  {
    $("#nom_pag").val('');
    $("#nom_pag").prop("disabled",true);
  }
  else
  {
    $("#nom_pag").prop("disabled",false);
  }
}
function nuevo()
{
  var factoresarray = [];
  $("input[name='factores[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        factoresarray.push($(this).val());
      }
    }
  );
  var estructurasarray = [];
  $("input[name='estructuras[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        estructurasarray.push($(this).val());
      }
    }
  );
  var oms = $("#oms").select2('val');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "plan_grab.php",
    data:
    {
      plan: $("#plan").val(),
      lugar: $("#lugar").val(),
      factor: factoresarray,
      estructura: estructurasarray,
      oms: oms,
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
      oficiales: $("#oficiales").val(),
      suboficiales: $("#suboficiales").val(),
      auxiliares: $("#auxiliares").val(),
      soldados: $("#soldados").val(),
      ordop: $("#ordop").val(),
      ordop1: $("#ordop1").val(),
      misiones: $("#misiones").val(),
      contador: $("#contador").val(),
      tipo1: $("#tp_plan1").val(),
      tipo2: $("#con_sol").val()
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
      $("#conse").val(registros.salida);
      $("#paso7").val(registros.factores);
      $("#paso8").val(registros.estructuras);
      $("#paso9").val(registros.factores1);
      $("#paso10").val(registros.estructuras1);
      var valida, detalle, contador;
      contador = $("#contador").val();
      valida = $("#conse").val();
      if (valida > 0)
      {
        $("#botones").hide();
        $("#tp_plan").prop("disabled",true);
        $("#tp_plan1").prop("disabled",true);
        $("#con_sol").prop("disabled",true);
        $("#lugar").prop("disabled",true);
        $("#txtFiltro").prop("disabled",true);
        $("#txtFiltro1").prop("disabled",true);
        $("#oms").prop("disabled",true);
        $("#periodo").prop("disabled",true);
        $("#oficiales").prop("disabled",true);
        $("#suboficiales").prop("disabled",true);
        $("#auxiliares").prop("disabled",true);
        $("#soldados").prop("disabled",true);
        $("#ordop").prop("disabled",true);
        $("#ordop1").prop("disabled",true);
        $("#mis_1").prop("disabled",true);
        // Apaga todas las opciones
        $("input[name='factores[]']").each(
          function ()
          {
            $(this).prop("disabled",true);
            $("#oficinasAll").prop("disabled",true);
          }
        );
        $("input[name='estructuras[]']").each(
          function ()
          {
            $(this).prop("disabled",true);
            $("#oficinasAll1").prop("disabled",true);
          }
        );
        for (i=0;i<document.formu.elements.length;i++)
        {
          saux=document.formu.elements[i].name;
          if (saux.indexOf('mis_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        for (j=1;j<=contador;j++)
        {
          $("#men_"+j).hide();
        }
        $("#add_field").hide();
        var tp_plan = $("#plan").val();
        var tp_plan1 = $("#plan1").val();
        var valida_sol = $("#con_sol").val();
        if (tp_plan == "1")
        {
          if (tp_plan1 == "1")
          {
            $("#tabs").tabs("enable",1);
            $("#tabs").tabs({
              active: 1
            });
            campos(contador);
          }
          else
          {
            if (valida_sol == "1")
            {
              $("#tabs").tabs("enable",1);
              $("#tabs").tabs({
                active: 1
              });
              campos(contador);
            }
            else
            {
              $("#tabs").tabs("enable",2);
              $("#tabs").tabs({
                active: 2
              });
            }
          }
        }
        else
        {
          if (valida_sol == "1")
          {
            $("#tabs").tabs("enable",1);
            $("#tabs").tabs({
              active: 1
            });
            campos(contador);
          }
          else
          {
            $("#tabs").tabs("enable",2);
            $("#tabs").tabs({
              active: 2
            });
          }
        }
      }
      else
      {
        $("#conse").val("0");
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#botones").show();
      }
    }
  });
}
function actu()
{
  var factoresarray = [];
  $("input[name='factores[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        factoresarray.push($(this).val());
      }
    }
  );
  var estructurasarray = [];
  $("input[name='estructuras[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        estructurasarray.push($(this).val());
      }
    }
  );
  $("#misiones").val('');
  var oms = $("#oms").select2('val');
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('mis_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('misiones').value=document.getElementById('misiones').value+valor+"|";
    }
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "plan_actu2.php",
    data:
    {
      conse: $("#conse").val(),
      plan: $("#plan").val(),
      lugar: $("#lugar").val(),
      factor: factoresarray,
      estructura: estructurasarray,
      oms: oms,
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
      oficiales: $("#oficiales").val(),
      suboficiales: $("#suboficiales").val(),
      auxiliares: $("#auxiliares").val(),
      soldados: $("#soldados").val(),
      ordop: $("#ordop").val(),
      ordop1: $("#ordop1").val(),
      misiones: $("#misiones").val()
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
      if (valida > 0)
      {
        $("#botones5").hide();
        $("#tp_plan").prop("disabled",true);
        $("#tp_plan1").prop("disabled",true);
        $("#con_sol").prop("disabled",true);
        $("#lugar").prop("disabled",true);
        $("#txtFiltro").prop("disabled",true);
        $("#txtFiltro1").prop("disabled",true);
        $("#oms").prop("disabled",true);
        $("#periodo").prop("disabled",true);
        $("#oficiales").prop("disabled",true);
        $("#suboficiales").prop("disabled",true);
        $("#auxiliares").prop("disabled",true);
        $("#soldados").prop("disabled",true);
        $("#ordop").prop("disabled",true);
        $("#ordop1").prop("disabled",true);
        $("#mis_1").prop("disabled",true);
        // Apaga todas las opciones
        $("input[name='factores[]']").each(
          function ()
          {
            $(this).prop("disabled",true);
            $("#oficinasAll").prop("disabled",true);
          }
        );
        $("input[name='estructuras[]']").each(
          function ()
          {
            $(this).prop("disabled",true);
            $("#oficinasAll1").prop("disabled",true);
          }
        );
        for (i=0;i<document.formu.elements.length;i++)
        {
          saux=document.formu.elements[i].name;
          if (saux.indexOf('mis_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        var ope1 = $("#ordop").val();
        var ope2 = $("#ordop1").val();
        var ope3 = ope2+" "+ope1;
        $("#operacion").val(ope3);
        var conta = $("#contador").val();
        for (k=1;k<=conta;k++)
        {
          var v_paso = $("#mis_"+k).val();
          $("#misi_"+k).val(v_paso);
        }  
        $("#factor1").val(registros.factores);
        $("#estructura1").val(registros.estructuras);
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#botones").show();
      }
    }
  });
}
function actualiza()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "plan_actu.php",
    data:
    {
      conse: $("#conse").val(),
      cedulas: $("#cedulas").val(),
      nombres: $("#nombres").val(),
      factores: $("#factores").val(),
      estructuras: $("#estructuras").val(),
      fechas1: $("#fechassu").val(),
      sintesis: $("#sintesis").val(),
      difusiones: $("#difusiones").val(),
      ndifusiones: $("#ndifusiones").val(),
      fechas2: $("#fechasdi").val(),
      unidades: $("#unidades").val(),
      resultados: $("#cresulta").val(),
      radiogramas: $("#nradiogramas").val(),
      fechas3: $("#fechasra").val(),
      utilidades: $("#utilidades").val(),
      valores: $("#valores").val(),
      ano: $("#ano").val()
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
      var registros = JSON.parse(data);
      var valida, detalle;
      valida = registros.salida;
      if (valida == "2")
      {
        $("#botones1").hide();
        $("#botones2").hide();
        $("#botones3").show();
        $("#txtFiltro").prop("disabled",true);
        $("#txtFiltro1").prop("disabled",true);
        $("#oms").prop("disabled",true);
        // Apaga todas las opciones
        $("input[name='factores[]']").each(
          function ()
          {
            $(this).prop("disabled",true);
            $("#oficinasAll").prop("disabled",true);
          }
        );
        $("input[name='estructuras[]']").each(
          function ()
          {
            $(this).prop("disabled",true);
            $("#oficinasAll1").prop("disabled",true);
          }
        );
        for (i=0;i<document.formu1.elements.length;i++)
        {
          saux=document.formu1.elements[i].name;
          if (saux.indexOf('ced_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('nom_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('fac_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('est_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('fec_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('sin_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('dif_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('n_dii_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('fed_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('res_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('nrad_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('fer_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('uti_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('vas_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        $("#add_field1").hide();
        for (k=1;k<=20;k++)
        {
          $("#mes_"+k).hide();
        }
        $("#actualizar").hide();
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo2").html(detalle);
        $("#dialogo2").dialog("open");
        $("#botones1").show();
        $("#botones3").hide();
      }
    }
  });
}
function actualiza1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "plan_actu1.php",
    data:
    {
      conse: $("#conse").val(),
      misiones: $("#m_misi").val(),
      factores: $("#m_fact").val(),
      estructuras: $("#m_estru").val(),
      actividades: $("#m_actis").val(),
      areas: $("#m_areas").val(),
      fechas1: $("#m_feis").val(),
      fechas2: $("#m_fefs").val(),
      oficiales: $("#m_ofs").val(),
      suboficiales: $("#m_sus").val(),
      auxiliares: $("#m_aus").val(),
      soldados: $("#m_sos").val(),
      gastos1: $("#m_v_gas1").val(),
      gastos2: $("#m_v_gas2").val(),
      gastos3: $("#m_v_gas3").val(),
      gastos4: $("#m_v_gas4").val(),
      ano: $("#ano").val()
    },
    beforeSend: function ()
    {
      $("#load2").show();
    },
    error: function ()
    {
      $("#load2").hide();
    },
    success: function (data)
    {
      $("#load2").hide();
      var registros = JSON.parse(data);
      var valida, valida1, valida2, valida3, detalle;
      valida = registros.salida;
      if (valida == "1")
      {
        $("#botones2").hide();
        $("#actualizar").hide();
        valida1 = $("#tp_plan").val();
        valida2 = $("#tp_plan1").val();
        valida3 = $("#con_sol").val();
        if ((valida1 == "1" && valida2 == "2" && valida3 == "1") || (valida1 == "2" && valida3 == "1"))
        {
          $("#botones4").show();
        }
        else
        {
          $("#tabs").tabs("enable",2);
          $("#tabs").tabs({
            active: 2
          });
          $("#botones4").hide();
        }
        $("#txtFiltro").prop("disabled",true);
        $("#txtFiltro1").prop("disabled",true);
        $("#oms").prop("disabled",true);
        // Apaga todas las opciones
        $("input[name='factores[]']").each(
          function ()
          {
            $(this).prop("disabled",true);
            $("#oficinasAll").prop("disabled",true);
          }
        );
        $("input[name='estructuras[]']").each(
          function ()
          {
            $(this).prop("disabled",true);
            $("#oficinasAll1").prop("disabled",true);
          }
        );
        for (i=0;i<document.formu2.elements.length;i++)
        {
          saux=document.formu2.elements[i].name;
          if (saux.indexOf('facto_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('estru_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('area_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('fei_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('fef_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('of_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('su_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('au_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('so_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('gas_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('otr_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('vag_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        var contador;
        contador = $("#contador").val();
        for (j=1;j<=contador;j++)
        {
          $("#add_field_"+j).hide();
          for (k=1;k<=20;k++)
          {
            $("#del_"+j+"_"+k).hide();
          }
        }
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo4").html(detalle);
        $("#dialogo4").dialog("open");
        $("#botones2").show();
      }
    }
  });
}
function imprimir()
{
  var plan = $("#conse").val();
  var valida = $("#tp_plan").val();
  var ano = $("#ano").val();
  var ajuste = "0";
  $("#plan_conse").val(plan);
  $("#plan_ano").val(ano);
  $("#plan_tipo").val(valida);
  $("#plan_ajust").val(ajuste);
  formu3.submit();
}
function link(valor, ano, tipo)
{
  var valor;
  var ano;
  var tipo;
  var ajuste;
  ajuste = $("#ajuste").val();
  $("#plan_conse").val(valor);
  $("#plan_ano").val(ano);
  $("#plan_tipo").val(tipo);
  $("#plan_ajust").val(ajuste);
  formu3.submit();
}
function consultar()
{
  var usu = $("#usu").val();
  var admin = $("#admin").val();
  $("#menu").accordion({active: 1});
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "plan_consu.php",
    data:
    {
      tipo: $("#tipo_c").val(),
      fecha1: $("#fecha1").val(),
      fecha2: $("#fecha2").val(),
      b_unidad: $("#b_unidad").val()
    },
    beforeSend: function ()
    {
      $("#load3").show();
    },
    error: function ()
    {
      $("#load3").hide();
    },
    success: function (data)
    {
      $("#l_ajuste").show();
      $("#load3").hide();
      $("#tabla").html('');
      $("#resultados4").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      listaplanes = [];
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
      salida1 += "<table width='100%' align='center' border='0'><tr><td width='6%'><b>No.</b></td><td width='13%'><b>Fecha</b></td><td width='9%'><b>Periodo</b></td><td width='15%'><b>Unidad</b></td><td width='21%'><b>Tipo</b></td><td width='12%'><b>Usuario</b></td><td width='5%'>&nbsp;</td><td width='5%'>&nbsp;</td><td width='5%'>&nbsp;</td><td width='5%'>&nbsp;</td><td width='4%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='100%' align='center' border='0' id='a-table'>";
      $.each(registros.rows, function (index, value)
      {
        salida2 += "<tr><td width='6%'>"+value.conse+"</td>";
        salida2 += "<td width='13%'>"+value.fecha+"</td>";
        salida2 += "<td width='9%'>"+value.periodo+" - "+value.ano+"</td>";
        salida2 += "<td width='15%'>"+value.unidad+"</td>";
        salida2 += "<td width='21%'>"+value.tipo+"</td>";
        salida2 += "<td width='12%'>"+value.usuario+"</td>";
        if ((value.estado == "P") || (value.estado == "A") || (value.estado == "B") || (value.estado == "C") || (value.estado == "D") || (value.estado == "E") || (value.estado == "F") || (value.estado == "G") || (value.estado == "H") || (value.estado == "J") || (value.estado == "K") || (value.estado == "L") || (value.estado == "M") || (value.estado == "N") || (value.estado == "O") || (value.estado == "P") || (value.estado == "Q") || (value.estado == "R") || (value.estado == "X") || (value.estado == "W"))
        {
          salida2 += "<td width='5%'><center><img src='imagenes/blanco.png' border='0'></center></td>";
        }
        else
        {
          if (usu == value.usuario)
          {
            salida2 += "<td width='5%'><center><a href='#' onclick='modif("+value.conse+","+value.ano+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='5%'><center><img src='imagenes/blanco.png' border='0'></center></td>";
          }
        }
        salida2 += "<td width='5%'><center><a href='#' onclick='link("+value.conse+","+value.ano+","+value.tipo1+")'><img src='imagenes/pdf.png' border='0' title='Visualizar'></a></center></td>";
        if ((value.estado == "P") || (value.estado == "A") || (value.estado == "B") || (value.estado == "C") || (value.estado == "D") || (value.estado == "E") || (value.estado == "F") || (value.estado == "G") || (value.estado == "H") || (value.estado == "J") || (value.estado == "K") || (value.estado == "L") || (value.estado == "M") || (value.estado == "N") || (value.estado == "O") || (value.estado == "P") || (value.estado == "Q") || (value.estado == "R") || (value.estado == "X") || (value.estado == "W"))
        {
          salida2 += "<td width='5%'><center><img src='imagenes/blanco.png' border='0'></center></td>";
        }
        else
        {
          if (usu == value.usuario)
          {
            salida2 += "<td width='5%'><center><a href='#' onclick='paso3("+value.conse+","+value.tipo1+");pregunta3();'><img src='imagenes/anular.png' border='0' title='Anular'></a></center></td>";
          }
          else
          {
            salida2 += "<td width='5%'><center><img src='imagenes/blanco.png' border='0'></center></td>";
          }
        }
        salida2 += "<td width='5%'><center><a href='#' onclick='ver_anex("+value.conse+","+value.ano+");'><img src='imagenes/clip.png' border='0' title='Anexos'></a></center></td>";
  		if ((usu == 'ADM_SIGAR') || (usu == 'CX-JAIME') || (usu == 'CX-ALFREDO'))
  		{
          salida2 += "<td width='4%'><center><a href='#' onclick='des_plan("+value.conse+","+value.ano+");'><img src='imagenes/descargar.png' border='0' title='Descargar'></a></center></td>";
        }
        else
        {
          salida2 += "<td width='4%'><center><img src='imagenes/blanco.png' border='0'></center></td>";
        }
        listaplanes.push(value.conse);
      });
      salida2 += "</table>";
      $("#tabla").append(salida1);
      $("#resultados4").append(salida2);
    }
  });
}
function ver_anex(valor, valor1)
{
  var valor, valor1;
  var url = "./archivos/index1.php?ano="+valor1+"&conse="+valor;
  var ventana = window.open(url,'','height=480,width=800');
  if (window.focus) 
  {
    ventana.focus();
  }
  return false;
}
function anexar()
{
  var plan = $("#conse").val();
  var ano = $("#ano").val();
  var url = "./archivos/index.php?ano="+ano+"&conse="+plan;
  var ventana = window.open(url,'','height=480,width=800');
  if (window.focus) 
  {
    ventana.focus();
  }
  return false;
}
function des_plan(valor, valor1)
{
  var valor, valor1;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "plan_consu4.php",
    data:
    {
      plan: valor,
      ano: valor1
    },
    beforeSend: function ()
    {
      $("#load3").show();
    },
    error: function ()
    {
      $("#load3").hide();
    },
    success: function (data)
    {
      $("#load3").hide();
      var registros = JSON.parse(data);
    }
  });
}
function modif(valor, valor1)
{
  var valor, valor1;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "plan_consu1.php",
    data:
    {
      plan: valor,
      ano: valor1
    },
    beforeSend: function ()
    {
      $("#load3").show();
    },
    error: function ()
    {
      $("#load3").hide();
    },
    success: function (data)
    {
      $("#load3").hide();
      var registros = JSON.parse(data);
      $("#paso7").val(registros.factores);
      $("#paso8").val(registros.estructuras);
      $("#paso9").val(registros.factores1);
      $("#paso10").val(registros.estructuras1);
      $("#tp_plan").val(registros.tipo);
      $("#conse").val(registros.conse);
      $("#plan").val(registros.tipo);
      $("#ano").val(registros.ano);
      $("#contador").val(registros.n_misiones);
      $("#fecha").val(registros.fecha);
      $("#lugar").val(registros.lugar);
      var val_tipo = registros.tipo1;
      if (val_tipo == "99")
      {
        $("#tp_plan1").val('1');
      }
      else
      {
        $("#tp_plan1").val('2');
        $("#con_sol").val(registros.tipo1);
      }
      var factores = registros.factor;
      $("input[name='factores[]']").each(
        function ()
        {
          var val = $(this).val();
          if(factores.indexOf(val) > -1)
          {
            $(this).prop('checked', true);
          }
          else
          {
            $(this).prop('checked', false);
          }
        }
      );
      var estructuras = registros.estructura;
      estructuras = ","+estructuras+",";
      $("input[name='estructuras[]']").each(
        function ()
        {
          var val = $(this).val();
          val = ","+val+",";
          if(estructuras.indexOf(val) > -1)
          {
            $(this).prop('checked', true);
          }
          else
          {
            $(this).prop('checked', false);
          }
        }
      );
      actu_estru();
      var paso5;      
      paso5 = $("#paso5").val();
      $("#oms").html('');
      $("#oms").append(paso5);
      var oms = registros.oms;
      var paso;
      var var_ocu = oms.split(',');
      var var_ocu1 = var_ocu.length;
      for (var i=0; i<var_ocu1; i++)
      {
        paso = var_ocu[i];
        $("#oms option[value='"+paso+"']").prop("selected", true);
      }
      $("#periodo").val(registros.periodo);
      $("#oficiales").val(registros.oficiales);
      $("#suboficiales").val(registros.suboficiales);
      $("#auxiliares").val(registros.auxiliares);
      $("#soldados").val(registros.soldados);
      $("#ordop1").val(registros.n_ordop);
      $("#ordop").val(registros.ordop);
      $("#misiones").val(registros.misiones);
      var nom_misi = registros.misiones;
      var v1 = nom_misi.split('|');
      var con_misi = registros.n_misiones;
      var con_misi1 = con_misi-1;
      if (registros.n_misiones > 1)
      {
        for (k=1;k<=con_misi1;k++)
        {
          w = k+1;
          $("#add_field").click();
          $("#men_"+w).hide();
        }
      }
      var x = parseInt(registros.n_misiones)+1;
      for (k=x;k<=20;k++)
      {
        $("#mis_"+k).hide();
        $("#men_"+k).hide();
      }
      var z = 0;
      for (k=1;k<=con_misi;k++)
      {
        $("#mis_"+k).val(v1[z]);
        z++;
      }
      var valida1 = registros.tipo;
      var valida2 = registros.actual;
      var valida3 = registros.tipo1;
      // Si es solicitud de recursos
      if (valida1 == "2")
      {
        if (valida3 == "1")
        {          
          $("#tabs").tabs("enable",1);
          $("#tabs").tabs("disable",2);
          campos(registros.n_misiones);
          enciende1();
        }
        else
        {
          $("#tabs").tabs("disable",1);
          $("#tabs").tabs("enable",2);
          campos(registros.n_misiones);
          apaga1();
        }
      }
      else
      {
        if (valida3 == "99")
        {
          $("#tabs").tabs("enable",1);
          $("#tabs").tabs("enable",2);  
          campos(registros.n_misiones);
        }
        else
        {
          if (valida3 == "1")
          {
            $("#tabs").tabs("enable",1);
            $("#tabs").tabs("disable",2);
            campos(registros.n_misiones);
            enciende1();
          }
          else
          {
            $("#tabs").tabs("disable",1);
            $("#tabs").tabs("enable",2);
            apaga1();
          }
        }
      }
      $("#tabs").tabs({
        active: 0
      });

      trae_datos1(registros.conse);
      trae_datos2(registros.conse);
      $("#tp_plan").prop("disabled",true);
      $("#tp_plan1").prop("disabled",true);
      $("#tp_plan1").hide();
      $("#add_field").hide();
      $("#botones").hide();
      $("#botones5").show();
    }
  });
}
function actu_estru()
{
  var estructurasarray = [];
  $("input[name='estructuras[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        estructurasarray.push($(this).val());
      }
    }
  );
  listaoficinas = [];
  $("#estructura").empty();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_estuc.php",
    data:
    {
      estructura: estructurasarray
    },
    beforeSend: function ()
    {
      $("#load").show();
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      $("#load").hide();
      $("#dialogo").html("Se presenta el siguiente incidente al intentar ejectuar esta consulta.<br>Codigo: " + jqXHR.status + "<br>" + textStatus + "<br>" + errorThrown);
      $("#dialogo").dialog("open");
    },
    success: function (data)
    {
      $("#load").hide();
      var registros = JSON.parse(data);
      $.each(registros.rows, function (index, value)
      {
        listaoficinas.push({value: value.codigo, label: value.nombre});
        $('#estructura').append('<label><input type="checkbox" name="estructuras[]" value="' + value.codigo + '"><font size="2">' + value.nombre + '</font></label>');
      });
      $("#txtFiltro1").autocomplete({
        source: listaoficinas,
        select: function (event, ui) {
          $("input[name='estructuras[]']").each(
            function ()
            {
              if ($(this).val() == ui.item.value)
              {
                $(this).attr('checked', true);
                $("#txtFiltro1").val(ui.item.label);
              }
            }
          );
          return false;
        }
      });
      $("input[name='estructuras[]']").each(
        function ()
        {
          $(this).prop('checked', true);
        }
      );
    }
  });
}
function trae_datos1(valor)
{
  var valor; 
  fac2 = $("#paso9").val();
  est2 = $("#paso10").val();
  ano = $("#ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "plan_consu2.php",
    data:
    {
      plan: valor,
      ano: ano
    },
    beforeSend: function ()
    {
      $("#load3").show();
    },
    error: function ()
    {
      $("#load3").hide();
    },
    success: function (data)
    {
      $("#load3").hide();
      var registros = JSON.parse(data);
      var valida = registros.total;
      var y = 1;
      $.each(registros.rows, function (index, value)
      {
        $("#misi_"+y).val(value.mision);
        $("#area_"+y).val(value.area);
        $("#fei_"+y).val(value.fecha1);
        $("#fef_"+y).val(value.fecha2);
        $("#of_"+y).val(value.oficiales);
        $("#su_"+y).val(value.suboficiales);
        $("#au_"+y).val(value.auxiliares);
        $("#so_"+y).val(value.soldados);
        $("#m_sum_"+y).val(value.valor);
        $("#m_sua_"+y).val(value.valora);
        $("#acti_"+y).val(value.actividades);
        $("#facto_"+y).html('');
        $("#facto_"+y).append(fac2);
        var var_ocu = value.factor.split(',');
        var var_ocu1 = var_ocu.length;
        for (var m=0; m<var_ocu1; m++)
        {
          paso = var_ocu[m];
          paso = paso.trim();

          $("#facto_"+y+" option[value='"+paso+"']").prop("selected", true);
        }
        $("#estru_"+y).html('');
        $("#estru_"+y).append(est2);
        var var_ocu = value.estructura.split(',');
        var var_ocu1 = var_ocu.length;
        for (var m=0; m<var_ocu1; m++)
        {
          paso = var_ocu[m];
          paso = paso.trim();
          $("#estru_"+y+" option[value='"+paso+"']").prop("selected", true);
        }
      	var var_ocu = value.valores.split('«');
      	var var_ocu1 = var_ocu.length;
      	var z=0;
      	for (var i=0; i<var_ocu1-1; i++)
      	{
      		$("#add_field_"+y).click();
      		var var_1 = var_ocu[i];
      		var var_2 = var_1.split("|");
      		z=z+1;
      		var nom_1 = "gas_"+y+"_"+z;
      		var nom_2 = "otr_"+y+"_"+z;
      		var nom_3 = "vag_"+y+"_"+z;
			    var p_1 = var_2[0];
        	var p_2 = var_2[1];
        	var p_3 = var_2[2];
			    $("#"+nom_1).val(p_1);
			    $("#"+nom_2).val(p_2);
			    $("#"+nom_3).val(p_3);
			    paso_val(y,z);
		    }
        y++;
      });
    }
  });
}
function trae_datos2(valor)
{
  var valor;
  ano = $("#ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "plan_consu3.php",
    data:
    {
      plan: valor,
      ano: ano
    },
    beforeSend: function ()
    {
      $("#load3").show();
    },
    error: function ()
    {
      $("#load3").hide();
    },
    success: function (data)
    {
      $("#load3").hide();
      limpia_pago();
      var conta = 0;
      for (i=0;i<document.formu1.elements.length;i++)
      {
        saux=document.formu1.elements[i].name;
        if (saux.indexOf('ced_')!=-1)
        {
          conta++;
        }
      }
      var registros = JSON.parse(data);
      var valida = registros.total;
      var valida1 = valida-conta;
      if (conta <= valida1)
      {
        for (k=1;k<=valida1;k++)
        {
          $("#add_field1").click(); 
        }
      }
      var y = 1;
      $.each(registros.rows, function (index, value)
      {
        $("#ced_"+y).val(value.cedula); 
        $("#nom_"+y).val(value.nombre);
        $("#fac_"+y).val(value.factor);
        var paso;
        paso = $("#paso3").val();
        $("#est_"+y).append(paso);
        $("#est_"+y).val(value.estructura);
        $("#fec_"+y).val(value.fecha1);
        $("#sin_"+y).val(value.sintesis);
        $("#dif_"+y).val(value.difusion);
        $("#n_dii_"+y).val(value.ndifusion);
        $("#fed_"+y).val(value.fecha2);
        $("#uni_"+y).val(value.unidad);
        $("#res_"+y).val(value.resultado);
        $("#nrad_"+y).val(value.radiograma);
        $("#fer_"+y).val(value.fecha3);
        $("#uti_"+y).val(value.utilidad);
        $("#vas_"+y).val(value.valorf);
        $("#vaa_"+y).val(value.valora);
        paso_val1(y);
        suma1();
        if (value.resultado == "1")
        {
          $("#nrad_"+y).prop("disabled",false);
          $("#fer_"+y).prop("disabled",false);
        }
        else
        {
          $("#nrad_"+y).prop("disabled",true);
          $("#fer_"+y).prop("disabled",true); 
        }
        y++;
      });
    }
  });
}
function limpia_pago()
{
  for (k=1;k<=10;k++)
  {
    $("#ced_"+k).val(''); 
    $("#nom_"+k).val('');
    $("#fac_"+k).val('-');
    $("#est_"+k).val('');
    $("#fec_"+k).val('');
    $("#sin_"+k).val('');
    $("#dif_"+k).val('1');
    $("#n_dii_"+k).val('0');
    $("#fed_"+k).val('');
    $("#res_"+k).val('2');
    $("#nrad_"+k).val('0');
    $("#fer_"+k).val('');
    $("#uti_"+k).val('');
    $("#vas_"+k).val('0.00');
    $("#vap_"+k).val('0');
    suma1();
  }
}
function limpiar()
{
  	location.reload();
}
function recarga()
{
  	location.reload();
}
function enciende1()
{
  	$("#lb_organiza").show();
  	$("#lb_oficiales").show();
  	$("#lb_auxiliares").show();
  	$("#lb_suboficiales").show();
  	$("#lb_soldados").show();
  	$("#lb_ordop").show();
  	$("#lb_misiones").show();
  	$("#cm_oficiales").show();
  	$("#cm_auxiliares").show();
  	$("#cm_suboficiales").show();
  	$("#cm_soldados").show();
  	$("#cm_ordop").show();
  	$("#add_field").show();
  	$("#mis_1").show();
}
function apaga1()
{
    $("#oficiales").val('0');
    $("#auxiliares").val('0');
    $("#suboficiales").val('0');
    $("#soldados").val('0');
    $("#ordop").val('');
    $("#ordop1").val('');
    $("#mis_1").val('');
  	$("#lb_organiza").hide();
  	$("#lb_oficiales").hide();
  	$("#lb_auxiliares").hide();
  	$("#lb_suboficiales").hide();
  	$("#lb_soldados").hide();
  	$("#lb_ordop").hide();
  	$("#lb_misiones").hide();
  	$("#cm_oficiales").hide();
  	$("#cm_auxiliares").hide();
  	$("#cm_suboficiales").hide();
  	$("#cm_soldados").hide();
  	$("#cm_ordop").hide();
  	$("#add_field").hide();
  	$("#mis_1").hide();
}
function solicitar()
{
  var tipo = $("#tp_plan").val();
  if (tipo == "2")
  {
    var interno = $("#conse").val();
    var unidad = $("#n_unidad").val();
    var paso = $("#t_unidad").val();
    var paso1 = "1";
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_personas1.php",
      data:
      {
        interno: interno,
        unidad: unidad,
        paso: paso,
        paso1: paso1
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
        $("#val_modi").html('');
        var registros = JSON.parse(data);
        var salida = "";
        salida += "<table width='95%' align='center' border='0'>";
        salida += "<tr><td width='25%' height='25'><b>Usuario</b></td><td width='55%' height='25'><b>Nombre</b></td><td width='15%' height='25'><b>Unidad</b></td><td width='5%' height='25'>&nbsp;</td></tr>";
        var var_con = registros.conses.split('|');
        var var_usu = registros.usuarios.split('|');
        var var_nom = registros.nombres.split('|');
        var var_sig = registros.siglas.split('|');
        var var_con1 = var_con.length;
        for (var j=0; j<var_con1-1; j++)
        {
          var var1 = var_con[j];
          var var2 = var_usu[j];
          var var3 = var_nom[j];
          var var4 = var_sig[j];
          var paso = "\'"+var2+"\'";
          var paso1 = "\'"+var3+"\'";
          salida += '<tr><td width="25%">'+var2+'</td><td width="55%">'+var3+'</td><td width="15%">'+var4+'</td><td width="5%"><input type="checkbox" name="seleccionados[]" id="chk_'+j+'" value='+var2+' onclick="trae_marca('+paso+','+paso1+','+j+');"></td></tr>';
        }
        salida += '</table>';
        salida += '<input type="hidden" name="interno" id="interno" value="'+interno+'"><input type="hidden" name="usu1" id="usu1" readonly="readonly"><input type="hidden" name="nom1" id="nom1" readonly="readonly">';
        $("#val_modi").append(salida);
        $("#dialogo7").dialog("open");
      }
    });
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "noti_grab.php",
      data:
      {
        conse: $("#conse").val(),
        ano: $("#ano").val() 
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
        var registros = JSON.parse(data);
        var valida, notifica;
        valida = registros.salida;
        if (valida > 0)
        {
          notifica = registros.notifica;
          if ((notifica == null) || (notifica == ""))
          {
            detalle = "<br><h3><center>La Notificaci&oacute;n no pudo ser enviada al usuario.<br><br>Usuario Sin Parametrizar.</center></h3>";
            solicitar1();
          }
          else
          {
            detalle = "<br><h3><center>Notificaci&oacute;n Enviada a: "+notifica+"</center></h3>";
          }
          $("#dialogo6").html(detalle);
          $("#dialogo6").dialog("open");
          $("#aceptar5").hide();
          $("#aceptar6").hide();
        }
        else
        {
          detalle = "<br><h2><center>Error durante la grabación</center></h2>";
          $("#dialogo6").html(detalle);
          $("#dialogo6").dialog("open");
          $("#aceptar5").show();
          $("#aceptar6").show(); 
        }
      }
    });
  }
}
function solicitar1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "noti_habi.php",
    data:
    {
      conse: $("#conse").val()
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
    }
  });
}
function trae_marca(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $("#usu1").val(valor);
  $("#nom1").val(valor1);
  $("input[name='seleccionados[]']").each(
    function ()
    {
      $(this).prop('checked', false);
    }
  );
  $("#chk_"+valor2).prop('checked', true);
}
function enviar()
{
  var seleccionadosarray = [];
  $("input[name='seleccionados[]']").each(
    function ()
    {
      if ($(this).is(":checked"))
      {
        seleccionadosarray.push($(this).val());
      }
    }
  );
  var num_sel = seleccionadosarray.length;
  if (num_sel == "0")
  {
    var detalle = "<br><h3><center>Debe seleccionar un usuario a notificar.</center></h3>";
    $("#dialogo6").html(detalle);
    $("#dialogo6").dialog("open");
  }
  else
  {
    var valor = $("#usu1").val();
    var valor1 = $("#nom1").val();
    var valor2 = $("#conse").val();
    var valor3 = $("#t_unidad").val();
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "noti_grab7.php",
      data:
      {
        valor: valor,
        valor1: valor1,
        valor2: valor2,
        valor3: valor3
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
        var registros = JSON.parse(data);
        var valida;
        valida = registros.salida;
        if ((valida == "P") || (valida == "Q"))
        {
          $("#dialogo7").dialog("close");
          $("#aceptar5").hide();
          $("#aceptar6").hide();
          if (($("#admin").val() == "10") && (valida == "P"))
          {
            var detalle1;
            detalle1 = "Cuenta con Recursos Disponibles en Bancos para apoyar la Solicitud ?";
            $("#dialogo9").html(detalle1);
            $("#dialogo9").dialog("open");
          }
          var detalle;
          detalle = "<br><h3><center>Notificaci&oacute;n Enviada a: "+valor+"</center></h3>";
          $("#dialogo6").html(detalle);
          $("#dialogo6").dialog("open");
        }
      }
    });
  }
}
function paso3(valor,tipo)
{
  var valor;
  var tipo;
  $("#paso11").val(valor);
  $("#paso12").val(tipo);
}
function anul()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "plan_anul.php",
    data:
    {
      interno: $("#paso11").val(),
      ano: $("#ano").val(),
      tipo: $("#paso12").val()
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
      if (valida == "X")
      {
        $("#consultar").click();
      }
    }
  });
}
function envio1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "noti_grab8.php",
    data:
    {
      conse: $("#conse").val()
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
      if (valida == "S")
      {
        var detalle;
        detalle = "<br><h3><center>Notificaci&oacute;n Enviada a: STE_DIADI - CEDE2</center></h3>";
        $("#dialogo6").html(detalle);
        $("#dialogo6").dialog("open");
      }
    }
  });
}
function envio2()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "noti_grab9.php",
    data:
    {
      conse: $("#conse").val(),
      notifica: $("#usu1").val()
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
    }
  });
}
function total_planes()
{
  $("#tot_plan").val('0');
	$("#aceptar").show();
	var tipo = $("#tp_plan").val();
	var periodo = $("#periodo").val();
	var periodo1 = $("#periodo option:selected").html();
	periodo1 = periodo1.trim();
  periodo1 = periodo1.toLowerCase();
	var ano = $("#ano").val();
	if (tipo == "1")
	{
		$.ajax({
		    type: "POST",
		    datatype: "json",
		    url: "trae_total.php",
		    data:
		    {
		    	periodo: periodo,
		    	ano: ano
		    },
		    success: function (data)
		    {
				  var registros = JSON.parse(data);
      		var valida;
      		valida = registros.total;
      		valida = parseInt(valida);
      		if (valida > 0)
      		{
            $("#aceptar").hide();
            $("#tot_plan").val('1');
            var detalle;
			      detalle = "Ya existe Plan de Inversión registrado<br>para el mes de "+periodo1+" de "+ano;
            alerta(detalle);
      		}
      		else
      		{
            $("#tot_plan").val('0');
            $("#aceptar").show();
      		}
		    }
		});
	}
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
?>