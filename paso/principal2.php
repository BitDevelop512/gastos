<!doctype html>
<?php
session_start();
error_reporting(0);
include('permisos.php');
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  if ($sup_usuario == "1")
  {
    require('conf.php');
    require('permisos.php');
    $consu = "SELECT table_name FROM information_schema.tables WHERE table_name LIKE 'cx_%' ORDER bY table_name";
    $cur = odbc_exec($conexion, $consu);
    $total = odbc_num_rows($cur);
    if ($total > 0)
    {
      $tablas = "<option value='-'>- SELECCIONAR -</option>";
      while($i<$row=odbc_fetch_array($cur))
      {
        $nombre = trim(odbc_result($cur,1));
        $tablas .= "<option value='".$nombre."'>".$nombre."</option>";
      }
    }
    $consu1 = "SELECT * FROM cx_ctr_par";
    $cur1 = odbc_exec($conexion, $consu1);
    $p_inactividad = odbc_result($cur1,1);
    $p_usuario = trim(odbc_result($cur1,2));
    $p_clave = trim(odbc_result($cur1,3));
    $p_servidor = trim(odbc_result($cur1,4));
    $p_puerto = odbc_result($cur1,5);
    $p_dias = odbc_result($cur1,6);
    $p_ruta = trim(odbc_result($cur1,7));
    $p_url = trim(odbc_result($cur1,8));
    $p_combus = odbc_result($cur1,9);
    $p_bonos = odbc_result($cur1,10);
    $p_formatos = odbc_result($cur1,11);
    $p_autoriza = odbc_result($cur1,12);
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  ?>
</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini" style="overflow-x:hidden; overflow-y:auto;">
<div class="wrapper">
  <?php
  include('header.php');
  ?>
  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <?php
        include('menu1.php');
        ?>
      </ul>
    </section>
  </aside>
  <div class="content-wrapper">
    <div class="box-body">
<!-- Pestañas -->
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Comandos SQL</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col col-lg-10 col-sm-10 col-md-10 col-xs-10">
        <label><font face="Verdana" size="2">Instrucci&oacute;n</font></label>
        <textarea name="texto1" id="texto1" class="form-control" rows="4"></textarea>
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <label><font face="Verdana" size="2">&nbsp;</font></label>
        <button type="button" name="boton1" id="boton1" class="btn btn-block btn-primary">
          <font face="Verdana" size="2">Ejecutar</font>
        </button>
      </div>
    </div>
  </div>
</div>
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Resultado</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="load1">
          <center>
            <img src="dist/img/cargando1.gif" alt="Cargando..." />
          </center>
        </div>
        <div id="resultados"></div>
      </div>
    </div>
  </div>
</div>
<div class="box box-danger">
  <div class="box-header with-border">
    <h3 class="box-title">Backup Base de Datos</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <input type="hidden" name="tablas" id="tablas" class="form-control" value="<?php echo $tablas; ?>" readonly="readonly">
        <select name="tabla1" id="tabla1" class="form-control select2"></select>
      </div>
      <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
        <input type="text" name="top" id="top" class="form-control numero" value="5000" autocomplete="off" onkeypress="return check(event);" maxlength="5">
      </div>
      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
        <input type="text" name="where" id="where" class="form-control" value="" autocomplete="off" maxlength="200">
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <button type="button" name="boton7" id="boton7" class="btn btn-block btn-primary">
          <font face="Verdana" size="2">Generar Backup Tabla</font>
        </button>
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <button type="button" name="boton2" id="boton2" class="btn btn-block btn-primary">
          <font face="Verdana" size="2">Generar Backup Base</font>
        </button>
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <button type="button" name="boton4" id="boton4" class="btn btn-block btn-primary">
          <font face="Verdana" size="2">Exportar Firmas</font>
        </button>
      </div>
    </div>
  </div>
</div>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Par&aacute;metros Configurables</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
        <label><font face="Verdana" size="2">Tiempo Inactividad (Minutos)</font></label>
      </div>
      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
        <label><font face="Verdana" size="2">Cambio Clave (D&iacute;as)</font></label>
      </div>
      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
        <label><font face="Verdana" size="2">Día Final Registro Combustible</font></label>
      </div>
      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
        <label><font face="Verdana" size="2">Día Final Registro Combustible Bonos</font></label>
      </div>
    </div>
    <div class="row">
      <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
        <input type="text" name="inactividad" id="inactividad" class="form-control numero" value="<?php echo $p_inactividad; ?>" autocomplete="off" onkeypress="return check(event);" maxlength="3">
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
      <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
        <input type="text" name="dias" id="dias" class="form-control numero" value="<?php echo $p_dias; ?>" autocomplete="off" onkeypress="return check(event);" maxlength="3">
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
      <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
        <input type="text" name="combustible" id="combustible" class="form-control numero" value="<?php echo $p_combus; ?>" autocomplete="off" onkeypress="return check(event);" maxlength="2">
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
      <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
        <input type="text" name="bonos" id="bonos" class="form-control numero" value="<?php echo $p_bonos; ?>" autocomplete="off" onkeypress="return check(event);" maxlength="3">
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
        <label><font face="Verdana" size="2">Usuario Correo</font></label>
        <input type="text" name="ucorreo" id="ucorreo" class="form-control" value="<?php echo $p_usuario; ?>" autocomplete="off" maxlength="40">
      </div>
      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
        <label><font face="Verdana" size="2">Contrase&ntilde;a Correo</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="dist/img/ojo.png" name="ojo1" id="ojo1" width="20" border="0" title="Ver" class="cursor1" onclick="cambia('ccorreo');"><img src="dist/img/ojo_slash.png" name="ojo2" id="ojo2" width="20" border="0" title="Ocultar" class="cursor1" onclick="cambia('ccorreo');"></label>
        <input type="password" name="ccorreo" id="ccorreo" class="form-control" value="<?php echo $p_clave; ?>" autocomplete="off" maxlength="40">
      </div>
      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
        <label><font face="Verdana" size="2">Servidor Correo</font></label>
        <input type="text" name="scorreo" id="scorreo" class="form-control" value="<?php echo $p_servidor; ?>" autocomplete="off" maxlength="40">
      </div>
      <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
        <label><font face="Verdana" size="2">Puerto</font></label>
        <input type="text" name="pcorreo" id="pcorreo" class="form-control numero" value="<?php echo $p_puerto; ?>" autocomplete="off" onkeypress="return check(event);" maxlength="3">
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <label><font face="Verdana" size="2">D&iacute;as Autorizaciones</font></label>
        <input type="text" name="autoriza" id="autoriza" class="form-control numero" value="<?php echo $p_autoriza; ?>" autocomplete="off" onkeypress="return check(event);" maxlength="3">
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
        <label><font face="Verdana" size="2">Ruta Local</font></label>
        <input type="text" name="v_ruta" id="v_ruta" class="form-control" value="<?php echo $p_ruta; ?>" autocomplete="off" maxlength="120">
      </div>
      <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
        <label><font face="Verdana" size="2">URL</font></label>
        <input type="text" name="v_url" id="v_url" class="form-control" value="<?php echo $p_url; ?>" autocomplete="off" maxlength="120">
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <label><font face="Verdana" size="2">Cambio Formatos</font></label>
        <input type="text" name="formatos" id="formatos" class="form-control fecha" value="<?php echo $p_formatos; ?>" placeholder="yy/mm/dd" readonly="readonly" maxlength="120">
      </div>
      <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <br>
        <button type="button" name="boton8" id="boton8" class="btn btn-block btn-primary">
          <font face="Verdana" size="2">Actualizar</font>
        </button>
      </div>
    </div>
  </div>
</div>
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Soporte</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <select name="tabla" id="tabla" class="form-control select2"> 
          <option value="1">RELACION DE GASTOS</option>
          <option value="2">INFORME EJECUTIVO</option>
        </select>
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <button type="button" name="boton3" id="boton3" onclick="soporte(1);" class="btn btn-block btn-primary">
          <font face="Verdana" size="2">Actualizar Ciudades</font>
        </button>
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2"></div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <button type="button" name="boton9" id="boton9" class="btn btn-block btn-primary">
          <font face="Verdana" size="2">Limpiar Log</font>
        </button>
      </div>
    </div>
  </div>
</div>
<div class="box box-danger">
  <div class="box-header with-border">
    <h3 class="box-title">Actualizaciones</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <label><font face="Verdana" size="2">Tipo de Ajuste</font></label>
        <select name="tipo" id="tipo" class="form-control select2"> 
          <option value="1">INGRESO</option>
          <option value="2">EGRESO</option>
          <option value="3">ACTA PAGO DE INFORMACION</option>
          <option value="4">AUTORIZACION RECURSOS</option>
          <option value="5">AUTORIZACION RECOMPENSAS</option>
          <!--
          <option value="6">ACTA COMITE REGIONAL</option>
          <option value="7">ACTA COMITE CENTRAL</option>
          <option value="8">ACTA PAGO RECOMPENSA</option>
          -->
        </select>
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <label><font face="Verdana" size="2">Unidad</font></label>
        <?php
        $menu1_1 = odbc_exec($conexion,"SELECT subdependencia, sigla FROM cx_org_sub ORDER BY sigla");
        $menu1 = "<select name='unidad' id='unidad' class='form-control select2'>";
        $i = 1;
        $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
        while($i<$row=odbc_fetch_array($menu1_1))
        {
          $nombre = trim($row['sigla']);
          $menu1 .= "\n<option value=$row[subdependencia]>".$nombre."</option>";
          $i++;
        }
        $menu1 .= "\n</select>";
        echo $menu1;
        ?>
      </div>      
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <label><font face="Verdana" size="2">Numero</font></label>
        <input type="text" name="numero" id="numero" class="form-control numero" autocomplete="off">
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <label><font face="Verdana" size="2">Año</font></label>
        <select name="ano" id="ano" class="form-control select2"></select>
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <label><font face="Verdana" size="2">Campo</font></label>
        <select name="tipo1" id="tipo1" class="form-control select2"> 
          <option value="1">UNIDADES</option>
          <option value="2">FIRMAS</option>
        </select>
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <br>
        <button type="button" name="boton5" id="boton5" onclick="soporte(2);" class="btn btn-block btn-primary">
          <font face="Verdana" size="2">Consultar</font>
        </button>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col col-lg-10 col-sm-10 col-md-10 col-xs-10">
        <textarea name="texto2" id="texto2" class="form-control" rows="4"></textarea>
      </div>
      <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        <button type="button" name="boton6" id="boton6" onclick="soporte(3);" class="btn btn-block btn-primary">
          <font face="Verdana" size="2">Actualizar</font>
        </button>
      </div>
    </div>
  </div>
</div>
<div id="dialogo"></div>
<!-- Fin pestañas -->
    </div>
  </div>
  <aside class="control-sidebar control-sidebar-dark">
    <div class="tab-content">
      <div class="tab-pane" id="control-sidebar-home-tab">
      </div>
    </div>
  </aside>
  <div class="control-sidebar-bg"></div>
</div>
<?php
include('encabezado3.php');
?>
<style>
.cursor1
{
  cursor: pointer;
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
  $("#formatos").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true
  });
  $("#load1").hide();
  $("#load2").hide();
  $("#boton1").click(consulta);
  $("#boton2").click(backup);
  $("#boton4").click(firmas);
  $("#boton7").click(backup1);
  $("#boton8").click(parametros);
  $("#boton9").click(log);
  $("#texto1").focus();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 210,
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
  $("#barra_a").click();
  $("#ojo2").hide();
  trae_ano();
  trae_tablas();
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
    }
  });
}
function trae_tablas()
{
  $("#tabla1").html('');
  var tablas = $("#tablas").val();
  $("#tabla1").append(tablas);
}
function cambia(valor)
{
  var valor;
  var tipo = $("#" + valor).attr("type");
  if (tipo == "password")
  {
    $("#" + valor).attr("type", "text");
    $("#ojo1").hide();
    $("#ojo2").show();
  }
  else
  {
    $("#" + valor).attr("type", "password");
    $("#ojo1").show();
    $("#ojo2").hide();
  }
}
function consulta()
{
  var valor = $("#texto1").val();
  $("#resultados").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_sql.php",
    data:
    {
      valor: valor
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
      var salida1 = "";
      for (var i in registros) 
      {
        var var1 = registros[i].var1;
        var var2 = registros[i].var2;
        var var3 = registros[i].var3;
        var var4 = registros[i].var4;
        var var5 = registros[i].var5;
        var var6 = registros[i].var6;
        var var7 = registros[i].var7;
        var var8 = registros[i].var8;
        var var9 = registros[i].var9;
        salida1 += var1+"|"+var2+"|"+var3+"|"+var4+"|"+var5+"|"+var6+"|"+var7+"|"+var8+"|"+var9+"|#";
      }
      var salida = "";
      salida += "<table width='100%' border='0' id='a-table1'><tr><td height='35' width='10%'><b>No.</b></td><td height='35' width='10%'><b>Var1</b></td><td height='35' width='10%'><b>Var2</b></td><td height='35' width='10%'><b>Var3</b></td><td height='35' width='10%'><b>Var4</b></td><td height='35' width='10%'><b>Var5</b></td><td height='35' width='10%'><b>Var6</b></td><td height='35' width='10%'><b>Var7</b></td><td height='35' width='10%'><b>Var8</b></td><td height='35' width='10%'><b>Var9</b></td></tr>";
      var var_ocu = salida1.split('#');
      var var_ocu1 = var_ocu.length;
      var paso = "";
      var x;
      for (var i=0; i<var_ocu1-1; i++)
      {
        paso = var_ocu[i];
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
          x = i+1;
        }
        salida += "<tr><td height='35'>"+x+"</td><td height='35'>"+v1+"</td><td height='35'>"+v2+"</td><td height='35'>"+v3+"</td><td height='35'>"+v4+"</td><td height='35'>"+v5+"</td><td height='35'>"+v6+"</td><td height='35'>"+v7+"</td><td height='35'>"+v8+"</td><td height='35'>"+v9+"</td></tr>";
      }
      salida += '</table>';
      $("#resultados").append(salida);
    }
  });
}
function backup()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_sql1.php",
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
      var salida = registros.salida;
      if (salida == "1")
      {
        var detalle = "<center><h3>Backup Generado</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#boton2").hide();
      }
    }
  });
}
function backup1()
{
  var tabla = $("#tabla1").val();
  if (tabla == "-")
  {
    var detalle = "<center><h3>Tabla No Seleccionada</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "con_sql3.php",
      data:
      {
        tabla: $("#tabla1").val(),
        top: $("#top").val(),
        where: $("#where").val()
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
        var salida = registros.salida;
        if (salida == "1")
        {
          var detalle = "<center><h3>Backup "+tabla+" Generado</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
      }
    });
  }
}
function parametros()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_sql4.php",
    data:
    {
      inactividad: $("#inactividad").val(),
      dias: $("#dias").val(),
      usuario: $("#ucorreo").val(),
      clave: $("#ccorreo").val(),
      servidor: $("#scorreo").val(),
      puerto: $("#pcorreo").val(),
      ruta: $("#v_ruta").val(),
      url: $("#v_url").val(),
      combustible: $("#combustible").val(),
      bonos: $("#bonos").val(),
      formatos: $("#formatos").val(),
      autoriza: $("#autoriza").val()
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
      var salida = registros.salida;
      if (salida == "1")
      {
        var detalle = "<center><h3>Parámetros Actualizados</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#inactividad").prop("disabled",true);
        $("#dias").prop("disabled",true);
        $("#ucorreo").prop("disabled",true);
        $("#ccorreo").prop("disabled",true);
        $("#scorreo").prop("disabled",true);
        $("#pcorreo").prop("disabled",true);
        $("#v_ruta").prop("disabled",true);
        $("#v_url").prop("disabled",true);
        $("#combustible").prop("disabled",true);
        $("#bonos").prop("disabled",true);
        $("#formatos").prop("disabled",true);
        $("#autoriza").prop("disabled",true);
        $("#boton8").hide();
      }
    }
  });
}
function soporte(valor)
{
  var valor;
  var tabla = $("#tabla").val();
  var tipo = $("#tipo").val();
  var tipo1 = $("#tipo1").val();
  var unidad = $("#unidad").val();
  var numero = $("#numero").val();
  var ano = $("#ano").val();
  var texto = $("#texto2").val();
  if (((tipo == "1") && (tipo1 == "1")) || ((tipo == "3") && (tipo1 == "1")))
  {
    var detalle = "<center><h3>Campo No Válido</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();    
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "con_sql2.php",
      data:
      {
        soporte: valor,
        tabla: tabla,
        tipo: tipo,
        tipo1: tipo1,
        unidad: unidad,
        numero: numero,
        ano: ano,
        texto: texto
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
        var salida = registros.salida;
        if ((valor == "1") || (valor == "3"))
        {
          if (salida == "1")
          {
            detalle = "<center><h3>Actualización Realizada</h3></center>";
            $("#dialogo").html(detalle);
            $("#dialogo").dialog("open");
            $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
            $("#boton2").hide();
          }
          if (valor == "3")
          {
            $("#tipo").prop("disabled",true);
            $("#tipo1").prop("disabled",true);
            $("#unidad").prop("disabled",true);
            $("#numero").prop("disabled",true);
            $("#ano").prop("disabled",true);
            $("#texto2").prop("disabled",true);
            $("#boton5").hide();
            $("#boton6").hide();
          }
        }
        else
        {
          $("#texto2").val(salida);
        }
      }
    });
  }
}
function log()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_sql5.php",
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
      var salida = registros.salida;
      if (salida == "1")
      {
        var detalle = "<center><h3>Registro de Transaciones Actualizado</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#boton9").hide();
      }
    }
  });
}
function check(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if ((tecla == 0) || (tecla == 8) || (tecla == 13))
  {
    return true;
  }
  patron = /[0-9]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function firmas()
{
  var url = window.location.href;
  var v1 = url.split('/');
  var v2 = v1[2];
  if (v2 == "192.168.1.107:8086")
  {
    var url1 = "http://192.168.1.108:8085/gastos/";
  }
  else
  {
    var url1 = "https://soporte.cxcomputers.com/gastos/";
  }
  url1 += "con_firmas.php";
  var ventana = window.open(url1,'');
}
</script>
<?php
include('menu2.php');
?>
</body>
</html>
<?php
  }
}
// 10/08/2023 - Ampliacion a 3 digitos dias finales de registro
?>