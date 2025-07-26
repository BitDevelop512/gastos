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
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  ?>
  <script type="text/javascript" src="alertas/lib/alertify.js"></script>
  <link rel="stylesheet" href="alertas/themes/alertify.core.css"/>
  <link rel="stylesheet" href="alertas/themes/alertify.default.css"/>
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
<!-- Soportes -->
<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Soportes Avanzados</h3>
	</div>
	<div class="box-body">
    <form name="formu" method="post">
  		<div class="row">
  			<div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
  				<label><font face="Verdana" size="2">Tipo de Soporte</font></label>
  				<select name="tp_soporte" id="tp_soporte" class="form-control select2" onchange="verifica();" tabindex="1">
						<option value="1">PLANILLA GASTOS BASICOS</option>
						<option value="2">SOLICITUD DE PARTIDAS</option>
						<option value="3">REGRESAR ESTADO DE SOLICITUDES</option>
  				</select>
  			</div>
  			<div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
  		    <label><font face="Verdana" size="2">Unidad</font></label>
  				<select name="tp_unidad" id="tp_unidad" class="form-control select2" tabindex="2"></select>
  			</div>
      	<div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
         	<label><font face="Verdana" size="2">Numero</font></label>
         	<input type="text" name="tp_numero" id="tp_numero" class="form-control numero"  tabindex="3" autocomplete="off">
       	</div>
       	<div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
        		<label><font face="Verdana" size="2">Año</font></label>
        		<select name="tp_ano" id="tp_ano" class="form-control select2" tabindex="4"></select>
     		</div>
  	    <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
  	 	  	<br>
  	      <button type="button" name="boton1" id="boton1" class="btn btn-block btn-primary" tabindex="5">
  	        <font face="Verdana" size="2">Consultar</font>
  	      </button>
       	</div>
  		</div>
  		<br>
      <div class="row">
        <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
          <div id="load">
            <center>
              <img src="dist/img/cargando1.gif" alt="Cargando..." />
            </center>
          </div>
          <div id="resultados"></div>
        </div>
      </div>
    </form>
	</div>
</div>
<!-- Fin Soportes -->
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
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
<script src="js/jquery.maskMoney.min.js" type="text/javascript"></script>
<style>
.cursor1
{
  cursor: pointer;
}
.margen
{
  padding: 5px;
}
</style>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#boton1").click(consultar);
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
  trae_ano();
  trae_unidades();
  $("#boton1").mousedown(function(event) {
    switch (event.which)
    {
      case 3:
        $("#tp_ano").prop("disabled",false);
        break;
      default:
        break;
    }
  });
});
function trae_ano()
{
  $("#tp_ano").html('');
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
      $("#tp_ano").append(salida);
      $("#tp_ano").prop("disabled",true);
    }
  });
}
function trae_unidades()
{
	$("#tp_unidad").html('');
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
      $("#tp_unidad").append(salida);
		  $("#tp_unidad").select2({
				tags: false,
				allowClear: false,
				closeOnSelect: true
			});
    }
  });
}
function verifica()
{
  var tipo = $("#tp_soporte").val();
  if (tipo == "3")
  {
  	trae_unidades();
  	$("#tp_unidad").prop("disabled",true);
  }
  else
  {
  	$("#tp_unidad").prop("disabled",false);
  } 
}
function consultar()
{
  var tipo = $("#tp_soporte").val();
  var unidad = $("#tp_unidad").val();
  var numero = $("#tp_numero").val();
  var ano = $("#tp_ano").val();
  $("#resultados").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_sql6.php",
    data:
    {
      tipo: tipo,
      unidad: unidad,
      numero: numero,
      ano: ano
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
      if (tipo == "1")
      {
        var ciudad = registros.ciudad;
        var planillas = registros.planillas;
        var adicional = registros.adicional;
        var responsable = registros.responsable;
        var elaboro = registros.elaboro;
        var salida = "";
        if (planillas>0)
        {
         	salida += "<table width='100%' align='center' border='0' id='a-table1'>";
          salida += "<tr><td height='35' width='10%'><center><b>C&eacute;dula</b></center></td><td height='35' width='10%'><center><b>C&oacute;digo</b></center></td><td height='35' width='30%'><center><b>Ciudad</b></center></td><td height='35' width='8%'><center><b>F.S. Per.</b></center></td><td height='35' width='8%'><center><b>F.S. no Per.</b></center></td><td height='35' width='8%'><center><b>En Sede</b></center></td><td height='35' width='8%'><center><b>Consignaci&oacute;n</b></center></td><td height='35' width='13%'><center><b>Valor</b></center></td><td height='35' width='5%'>&nbsp;</td></tr>";
          $.each(registros.rows, function (index, value)
          {
          	salida += "<tr>";
    				salida += "<td height='45' width='10%' class='margen'><input type='hidden' name='con_"+index+"' id='con_"+index+"' value='"+value.conse+"' class='form-control'><input type='text' name='ced_"+index+"' id='ced_"+index+"' value='"+value.cedula+"' class='form-control'></td>";
    				salida += "<td height='45' width='10%' class='margen'><input type='text' name='nom_"+index+"' id='nom_"+index+"' class='form-control' value='"+value.nombre+"'></td>";
    				salida += "<td height='45' width='30%' class='margen'><input type='text' name='ciu_"+index+"' id='ciu_"+index+"' class='form-control' value='"+value.ciudad+"'></td>";
    				salida += "<td height='45' width='8%' class='margen'><input type='text' name='v1_"+index+"' id='v1_"+index+"' class='form-control numero' value='"+value.v1+"' onkeypress='return check(event);' maxlength='2'></td>";
    				salida += "<td height='45' width='8%' class='margen'><input type='text' name='v2_"+index+"' id='v2_"+index+"' class='form-control numero' value='"+value.v2+"' onkeypress='return check(event);' maxlength='2'></td>";
    				salida += "<td height='45' width='8%' class='margen'><input type='text' name='v3_"+index+"' id='v3_"+index+"' class='form-control numero' value='"+value.v3+"' onkeypress='return check(event);' maxlength='2'></td>";
            salida += "<td height='45' width='8%' class='margen'><select name='v4_"+index+"' id='v4_"+index+"' class='form-control select2'><option value='S'>SI</option><option value='N'>NO</option><option value='T'>Transferencia</option><option value='G'>Giro</option></select><input type='hidden' name='v41_"+index+"' id='v41_"+index+"' class='form-control' value='"+value.v4+"' readonly='readonly'></td>";
    				salida += "<td height='45' width='13%' class='margen'><input type='text' name='val_"+index+"' id='val_"+index+"' class='form-control numero' value='"+value.valor+"' onkeyup='paso_valor("+index+"); suma();'><input type='hidden' name='val1_"+index+"' id='val1_"+index+"' class='form-control numero' value='"+value.valor1+"'></td>";
    				salida += "<td height='45' width='5%' class='margen'><center><img src='dist/img/grabar1.png' width='20' border='0' title='Actualizar Registro' class='cursor1' name='gra_"+index+"' id='gra_"+index+"' onclick='actu("+index+");'></center></td>";
    				salida += "</tr>";
          });
          salida += "<tr>";
          salida += "<td height='45' colspan='7'>&nbsp;</td>";
          salida += "<td height='45' width='13%' class='margen'><input type='text' name='total' id='total' class='form-control numero' value='0.00' readonly='readonly'><input type='hidden' name='total1' id='total1' class='form-control numero' value='0' readonly='readonly'></td>";
          salida += "</tr>";
          salida += "<tr><td height='45' colspan='2'><center><b>Misi&oacute;n Adicional</b></center></td><td height='45' colspan='1'><center><b>Responsable</b></center></td><td height='45' colspan='3'><center><b>Elabor&oacute;</b></center></td></tr>";
          salida += "<tr><td height='45' colspan='2' class='margen'><input type='text' name='adicional' id='adicional' class='form-control' value='"+adicional+"' onblur='val_caracteres(\'adicional\');'></td><td height='45' colspan='1' class='margen'><input type='text' name='responsable' id='responsable' class='form-control' value='"+responsable+"' onblur='val_caracteres(\'responsable\');'></td><td height='45' colspan='3' class='margen'><input type='text' name='elaboro' id='elaboro' class='form-control' value='"+elaboro+"' onblur='val_caracteres(\'elaboro\');'></td><td height='45' colspan='1' class='margen'><center><img src='dist/img/grabar1.png' width='20' border='0' title='Actualizar Registro' class='cursor1' name='graba1' id='graba1' onclick='actu0();'></center></tr>";
          salida += "</tr>";
          salida += "</table>";
          $("#resultados").append(salida);
    			for (k=0;k<=planillas-1;k++)
    			{
    				$("#val_"+k).maskMoney();
            var v_paso = $("#v41_"+k).val();
            $("#v4_"+k).val(v_paso);
    			}
          suma();
        }
        else
        {
          var detalle = "Sin Resultados Encontrados";
          alerta(detalle);
        }
      }
      if (tipo == "2")
      {
        var total = registros.total;
        var salida = "";
        if (total>0)
        {
          salida += "<table width='100%' align='center' border='1' id='a-table1'>";
          $.each(registros.rows, function (index, value)
          {
            var tipo = value.tipo;
            tipo = tipo.trim();
            var variables = '\"'+index+'\",\"'+value.conse+'\"';
            salida += "<tr>";
            salida += "<td height='45' width='10%' class='margen'><input type='text' name='con_"+index+"' id='con_"+index+"' value='"+value.conse+"' class='form-control numero' readonly='readonly'></td>";
            salida += "<td height='45' width='5%' class='margen'><input type='text' name='int_"+index+"' id='int_"+index+"' class='form-control numero' value='"+value.interno+"' readonly='readonly'></td>";
            salida += "<td height='45' width='5%' class='margen'><input type='text' name='gas_"+index+"' id='gas_"+index+"' class='form-control numero' value='"+value.gasto+"' readonly='readonly'></td>";
            salida += "<td height='45' width='5%' class='margen'><input type='text' name='tip_"+index+"' id='tip_"+index+"' class='form-control fecha' value='"+tipo+"' readonly='readonly'></td>";
            salida += "<td height='45' width='10%' class='margen'><input type='text' name='val_"+index+"' id='val_"+index+"' class='form-control numero' value='"+value.valor+"' readonly='readonly'></td>";
            if (tipo == "")
            {
              salida += "<td height='45' width='5%' class='margen'>&nbsp;</td>";
              salida += "<td height='45' width='5%' class='margen'>&nbsp;</td>";
              salida += "<td height='45' width='5%' class='margen'>&nbsp;</td>";
            }
            else
            {
              salida += "<td height='45' width='55%' class='margen'><textarea name='bie_"+index+"' id='bie_"+index+"' class='form-control' rows='3'></textarea></td>";
              salida += "<td height='45' width='5%' class='margen'><center><img src='dist/img/ojo.png' width='25' border='0' title='Ver Registro' class='cursor1' name='ver_"+index+"' id='ver_"+index+"' onclick='ver1("+variables+");'></center></td>";
              salida += "<td height='45' width='5%' class='margen'><center><img src='dist/img/grabar1.png' width='20' border='0' title='Actualizar Registro' class='cursor1' name='gra_"+index+"' id='gra_"+index+"' onclick='actu1("+index+");'></center></td>";
            }
            salida += "</tr>";
          });
          salida += "</table>";
          $("#resultados").append(salida);
        }
        else
        {
          var detalle = "Sin Resultados Encontrados";
          alerta(detalle);
        }
      }
      if (tipo == "3")
      {
        var total = registros.total;
        var total1 = total-1;
        var salida = "";
        if (total>0)
        {
          salida += "<table width='100%' align='center' border='1' id='a-table1'>";
          $.each(registros.rows, function (index, value)
          {
          	var conse = value.conse;
            var usuario = value.usuario;
            var unidad = value.unidad;
            var estado = value.estado;
            var usuario1 = value.usuario1;
            var unidad1 = value.unidad1;
            var variables = '\"'+index+'\",\"'+usuario+'\",\"'+unidad+'\",\"'+estado+'\",\"'+usuario1+'\",\"'+unidad1+'\",\"'+conse+'\"';
            salida += "<tr>";
            salida += "<td height='45' width='15%' class='margen'><input type='text' name='con_"+index+"' id='con_"+index+"' value='"+value.conse+"' class='form-control numero' readonly='readonly'></td>";
            salida += "<td height='45' width='15%' class='margen'><input type='text' name='usu_"+index+"' id='usu_"+index+"' class='form-control' value='"+value.usuario+"' readonly='readonly'></td>";
            salida += "<td height='45' width='10%' class='margen'><input type='text' name='uni_"+index+"' id='uni_"+index+"' class='form-control numero' value='"+value.unidad+"' readonly='readonly'></td>";
            salida += "<td height='45' width='10%' class='margen'><input type='text' name='nuni_"+index+"' id='nuni_"+index+"' class='form-control' value='"+value.n_unidad+"' readonly='readonly'></td>";
            salida += "<td height='45' width='10%' class='margen'><input type='text' name='est_"+index+"' id='est_"+index+"' class='form-control fecha' value='"+value.estado+"' readonly='readonly'></td>";
            salida += "<td height='45' width='15%' class='margen'><input type='text' name='usu1_"+index+"' id='usu1_"+index+"' class='form-control' value='"+value.usuario1+"' readonly='readonly'></td>";
            salida += "<td height='45' width='10%' class='margen'><input type='text' name='uni1_"+index+"' id='uni1_"+index+"' class='form-control numero' value='"+value.unidad1+"' readonly='readonly'></td>";
            salida += "<td height='45' width='10%' class='margen'><input type='text' name='nuni1_"+index+"' id='nuni1_"+index+"' class='form-control' value='"+value.n_unidad1+"' readonly='readonly'></td>";
            if (total1 == index)
            {
              salida += "<td height='45' width='5%' class='margen'><center><img src='dist/img/regresar.png' width='25' border='0' title='Devolver Estado' class='cursor1' name='gra_"+index+"' id='gra_"+index+"' onclick='actu2("+variables+");'></center></td>";
            }
            else
            {
							salida += "<td height='45' width='5%' class='margen'>&nbsp;</td>";
            }
            salida += "</tr>";
          });
          salida += "</table>";
          $("#resultados").append(salida);
        }
        else
        {
          var detalle = "Sin Resultados Encontrados";
          alerta(detalle);
        }
      }
    }
  });
}
function actu(valor)
{
	var valor;
  var tipo = "1";
	var conse = $("#con_"+valor).val();
	var cedula = $("#ced_"+valor).val();
	var nombre = $("#nom_"+valor).val();
	var ciudad = $("#ciu_"+valor).val();
	var v1 = $("#v1_"+valor).val();
	var v2 = $("#v2_"+valor).val();
	var v3 = $("#v3_"+valor).val();
  var v4 = $("#v4_"+valor).val();
	var valor1 = $("#val_"+valor).val();
	var valor2 = $("#val1_"+valor).val();
  var total = $("#total").val();
  var total1 = $("#total1").val();
  var unidad = $("#tp_unidad").val();
  var numero = $("#tp_numero").val();
  var ano = $("#tp_ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "sop_grab.php",
    data:
    {
      tipo: tipo,
      conse: conse,
      cedula: cedula,
      nombre: nombre,
      ciudad: ciudad,
      v1: v1,
      v2: v2,
      v3: v3,
      v4: v4,
      valor1: valor1,
      valor2: valor2,
      total: total,
      total1: total1,
      unidad: unidad,
      numero: numero,
      ano: ano
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        $("#gra_"+valor).hide();
        $("#con_"+valor).prop("disabled", true);
        $("#ced_"+valor).prop("disabled", true);
        $("#nom_"+valor).prop("disabled", true);
        $("#ciu_"+valor).prop("disabled", true);
        $("#v1_"+valor).prop("disabled", true);
        $("#v2_"+valor).prop("disabled", true);
        $("#v3_"+valor).prop("disabled", true);
        $("#v4_"+valor).prop("disabled", true);
        $("#val_"+valor).prop("disabled", true);
        $("#val1_"+valor).prop("disabled", true);
      }
      else
      {
        var detalle = "Error durante la actualización";
        alerta(detalle);
      }
    }
  });
}
function actu0()
{
  var tipo = "2";
  var adicional = $("#adicional").val();
  var responsable = $("#responsable").val();
  var elaboro = $("#elaboro").val();
  var unidad = $("#tp_unidad").val();
  var numero = $("#tp_numero").val();
  var ano = $("#tp_ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "sop_grab.php",
    data:
    {
      tipo: tipo,
      adicional: adicional,
      responsable: responsable,
      elaboro: elaboro,
      unidad: unidad,
      numero: numero,
      ano: ano
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        $("#graba1").hide();
        $("#adicional").prop("disabled", true);
        $("#responsable").prop("disabled", true);
        $("#elaboro").prop("disabled", true);
      }
      else
      {
        var detalle = "Error durante la actualización";
        alerta(detalle);
      }
    }
  });
}
function ver1(valor, valor1)
{
  var valor, valor1;
  var tipo = "A";
  var unidad = $("#tp_unidad").val();
  var numero = $("#tp_numero").val();
  var ano = $("#tp_ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "con_sql6.php",
    data:
    {
      tipo: tipo,
      unidad: unidad,
      numero: numero,
      ano: ano,
      interno: valor1
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
      var bienes = registros.bienes;
      $("#bie_"+valor).val(bienes);
    }
  });
}
function actu1(valor)
{
  var valor;
  var conse = $("#con_"+valor).val();
  var gasto = $("#gas_"+valor).val();
  var datos = $("#bie_"+valor).val();
  var unidad = $("#tp_unidad").val();
  var numero = $("#tp_numero").val();
  var ano = $("#tp_ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "sop_grab1.php",
    data:
    {
      conse: conse,
      gasto: gasto,
      datos: datos,
      unidad: unidad,
      numero: numero,
      ano: ano
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        $("#ver_"+valor).hide();
        $("#gra_"+valor).hide();
        $("#bie_"+valor).prop("disabled", true);
      }
      else
      {
        var detalle = "Error durante la actualización";
        alerta(detalle);
      }
    }
  });
}
function actu2(valor, valor1, valor2, valor3, valor4, valor5, valor6)
{
	var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7;
	var estado = "";
	if (valor == "0")
	{
		estado = "";
	}
	else
	{
		valor7 = valor-1;
		estado = $("#est_"+valor7).val();	
	}
	var actual = valor3;
  var tipo = "3";
  var unidad = $("#tp_unidad").val();
  var numero = $("#tp_numero").val();
  var ano = $("#tp_ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "sop_grab.php",
    data:
    {
      tipo: tipo,
      conse: valor6,
      usuario: valor1,
      usuario1: valor4,
      estado: estado,
      unidad: unidad,
      numero: numero,
      ano: ano
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
      	$("#gra_"+valor).hide();
      }
      else
      {
        var detalle = "Error durante la actualización";
        alerta(detalle);
      }
    }
  });






	//alert(actual+" - "+estado+" : "+valor6);
	//var variables = '\"'+index+'\",\"'+usuario+'\",\"'+unidad+'\",\"'+estado+'\",\"'+usuario1+'\",\"'+unidad1+'\",\"'+conse+'\"';


}
function paso_valor(valor)
{
  var valor1 = $("#val_"+valor).val();
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#val1_"+valor).val(valor1);
}
function suma()
{
  var total = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('val1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      valor = parseFloat(valor);
      total = total+valor;
    }
  }
  var valor1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total").val(valor1);
  $("#total1").val(total);
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
  if ((tecla == 0) || (tecla == 8) || (tecla == 13))
  {
    return true;
  }
  patron = /[0-9]/;
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
<?php
include('menu2.php');
?>
</body>
</html>
<?php
  }
}
?>