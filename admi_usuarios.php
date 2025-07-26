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
?>
<html lang="es">
<head>
  <?php
  include('encabezado1.php');
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
          <h3>Control de Usuarios</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
						<form name="formu" method="post">
							<div class="row">
								<div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <table width="65%" border="0">
                    <tr>
                      <td width="90%">
      									<label><font face="Verdana" size="2">Usuario</font></label>
      									<input type="hidden" name="conse" id="conse" class="form-control" value="0" readonly="readonly">
      									<input type="text" name="usuario" id="usuario" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" onblur="valida();" maxlength="15" autocomplete="off" tabindex="1">
                      </td>
                      <td width="5%">&nbsp;</td>
                      <td width="5%">
                        <center>
                          <br>
                          <img src="dist/img/editar.png" name="img1" id="img1" width="30" border="0" title="Modificar" class="mas" onclick="actualiza1();"><img src="dist/img/grabar1.png" name="img2" id="img2" width="30" border="0" title="Actualizar" class="mas" onclick="actualiza2();">
                        </center>
                      </td>
                    </tr>
                  </table>
									<div class="espacio"></div>
									<div id="datos">
										<label><font face="Verdana" size="2">Nombre Completo</font></label>
										<input type="text" name="nombre" id="nombre" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="50" autocomplete="off"  tabindex="2">
										<br>
										<label><font face="Verdana" size="2">Tipo de Permisos</font></label>
										<select name="tipo" id="tipo" class="form-control select2" tabindex="3">
											<option value="0">- SELECCIONAR -</option>
											<option value="1">PERMISOS</option>
											<option value="2">ROLES</option>
										</select>
                    <br>
                    <label><font face="Verdana" size="2">Clase de Usuario</font></label>
                    <select name="clase" id="clase" class="form-control select2" tabindex="4">
                      <option value="0">USUARIO EST&Aacute;NDAR</option>
                      <option value="2">ADMINISTRADOR TRANSPORTES CEDE2</option>
                      <option value="4">ADMINISTRADOR TRANSPORTES BRIGADA</option>
                      <option value="5">ADMINISTRADOR TRANSPORTES BATALLÓN</option>
                      <option value="6">ADMINISTRADOR TRANSPORTES COMANDO</option>
                      <option value="3">OTROS ADMINISTRADORES</option>
                      <option value="1">SUPER USUARIO</option>
                    </select>
										<input type="hidden" name="permisos" id="permisos" class="form-control" readonly="readonly" tabindex="5">
                    <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly" tabindex="0">
                    <input type="hidden" name="login" id="login" class="form-control" value="" readonly="readonly" tabindex="0">
									</div>
									<div class="espacio"></div>
									<div id="datos1" class="datos_permisos">
										<label><font face="Verdana" size="2">Permisos</font></label>
										<?php
										$query = "SELECT * FROM cx_ctr_mod ORDER BY modulo, conse";  
										$cur = odbc_exec($conexion, $query);
										$i = 0;
										while($i<$row=odbc_fetch_array($cur))
										{
											$conse = odbc_result($cur,1);
											$modulo = odbc_result($cur,2);
											$numero = odbc_result($cur,3);
											$valor = $modulo."|".$numero."/";
											$nombre = trim(utf8_encode(odbc_result($cur,4)));
											echo "<span><input type='checkbox' name='opt_".$conse."' id='opt_".$conse."' value='".$valor."'><label for='opt_".$conse."'>".$nombre."</label></span>";
											$i++;
										}
										?>
									</div>
									<div id="datos2">
										<label><font face="Verdana" size="2">Permisos</font></label>
										<?php
										$menu2_2 = odbc_exec($conexion,"SELECT nombre,permisos FROM cx_ctr_rol ORDER BY conse");
										$menu2 = "<select name='roles' id='roles' class='form-control select2' tabindex='6'>";
										$i = 1;
										$menu2 .= "\n<option value=''>- SELECCIONAR -</option>";
										while($i<$row=odbc_fetch_array($menu2_2))
										{
											$nombre = $row['nombre'];
											$menu2 .= "\n<option value=$row[permisos]>".$nombre."</option>";
											$i++;
										}
										$menu2 .= "\n</select>";
										echo $menu2;
										?>
									</div>
									<div class="espacio"></div>
									<center>
										<input type="button" name="aceptar" id="aceptar" value="Grabar" tabindex="7">
										<input type="button" name="actualizar" id="actualizar" value="Actualizar" tabindex="8">
										&nbsp;&nbsp;&nbsp;
										<input type="button" name="cancelar" id="cancelar" value="Cancelar" tabindex="9">
									</center>
								</div>
								<div class="col col-lg-8 col-sm-8 col-md-8 col-xs-8">
									<label><font face="Verdana" size="2">Lista de Usuarios</font></label>
									<br>
									<label><font face="Verdana" size="2">Buscar Usuario:</font></label>
									<table width="100%" border="0">
										<tr>
											<td width="30%">
												<input type="text" name="filtro" id="filtro" class="form-control" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="30" autocomplete="off">
											</td>
											<td width="60%">
												&nbsp;
											</td>
										</tr>
									</table>
									<input type="hidden" name="conse1" id="conse1" class="form-control" value="0" readonly="readonly">
									<div class="espacio"></div>
									<div id="res_usua"></div>
									<div class="espacio"></div>
									<div id="lbl_rol">
										<center>
											<label><font face="Verdana" size="2">Rol:</font></label>
											<table align="center" width="35%" border="0">
												<tr>
													<td>
				                    <?php
				                    $menu3_3 = odbc_exec($conexion,"SELECT conse,nombre FROM cx_ctr_rol ORDER BY conse");
				                    $menu3 = "<select name='roles1' id='roles1' class='form-control select2'>";
				                    $i=1;
				                    while($i<$row=odbc_fetch_array($menu3_3))
				                    {
				                      $nombre = $row['nombre'];
				                      $menu3 .= "\n<option value=$row[conse]>".$nombre."</option>";
				                      $i++;
				                    }
				                    $menu3 .= "\n</select>";
				                    echo $menu3;
				                    ?>
													</td>
												</tr>
											</table>
										</center>
									</div>
									<div class="espacio"></div>
									<center>
										<input type="button" name="aceptar1" id="aceptar1" value="Actualizar Rol">
										<input type="hidden" name="conses" id="conses" class="form-control" readonly="readonly">
									</center>
								</div>
							</div>
						</form>
						<div id="dialogo"></div>
						<div id="dialogo1"></div>
						<div id="dialogo2"></div>
						<div id="dialogo3"></div>
            <div id="dialogo4"></div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<style>
.datos_permisos
{
  height: 400px;
  overflow: auto;
  font-family: 'Verdana';
  font-size: 12px;
}
</style>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 170,
    width: 570,
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
    height: 200,
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
    buttons: {
      "Aceptar": function() {
        $(this).dialog("close");
        reinicio1();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
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
    buttons: {
      "Aceptar": function() {
        $(this).dialog("close");
        clave1();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo3").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
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
    buttons: {
      "Aceptar": function() {
        $(this).dialog("close");
        esta1();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo4").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 200,
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
        actualiza3();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#tipo").change(activa);
  $("#datos").hide();
  $("#datos1").hide();
  $("#datos2").hide();
  $("#roles").change(per_rol);
  $("#aceptar").button();
  $("#aceptar").click(nuevo);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").hide();
  $("#aceptar1").button();
  $("#aceptar1").click(revisa);
  $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").hide();
  $("#actualizar").button();
  $("#actualizar").click(actualiza);
  $("#actualizar").css({ width: '125px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#actualizar").hide();
  $("#cancelar").button();
  $("#cancelar").click(recarga);
  $("#cancelar").css({ width: '125px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#cancelar").hide();
  $("#lbl_rol").hide();
  consulta();
  $("#usuario").focus();
  $('#filtro').blur(consulta1);
  $("#img1").hide();
  $("#img2").hide();
});
function activa()
{
  $("#permisos").val('');
  $("#roles").val('');
  var valida;
  valida = $("#tipo").val();
  switch (valida)
  {
    case '0':
      $("#datos1").hide();
      $("#datos2").hide();
      break;
    case '1':
      $("#datos1").show();
      $("#datos2").hide();
      break;
    case '2':
      $("#datos1").hide();
      $("#datos2").show();
      break;
    default:
      $("#datos1").hide();
      $("#datos2").hide();
      break;
  }
}
function paso()
{
  document.getElementById('permisos').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('opt_')!=-1)
    {
      valor = document.getElementById(saux).checked;
      valor1 = document.getElementById(saux).value;
      if (valor == true)
      {
        valor2 = valor1;
      }
      else
      {
        valor2 = "";
      }
      document.getElementById('permisos').value=document.getElementById('permisos').value+valor2;
    }
  }
}
function per_rol()
{
  var rol;
  $("#permisos").val('');
  rol = $("#roles").val();
  $("#permisos").val(rol);
}
function valida()
{
  var usuario = $("#usuario").val();
  var valor = usuario.trim().length;
  var conse = $("#conse").val();
  if (valor == "0")
  {
  }
  else
  {
    if (conse == "0")
    {
      $.ajax({
        type: "POST",
        datatype: "json",
        url: "con_usuario1.php",
        data:
        {
          usuario: usuario
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
            detalle = "<center><h3>Usuario ya Registrado en la Base de Datos</h3></center>";
            $("#dialogo").html(detalle);
            $("#dialogo").dialog("open");
            $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
            $("#datos").hide();
            $("#aceptar").hide();
          }
          else
          {
            $("#datos").show();
            $("#aceptar").show();
            $("#tipo").val('1');
            $("#nombre").focus();
            activa();
          }
        }
      });
    }
  }
}
function nuevo()
{
  var valida;
  valida = $("#tipo").val();
  if (valida == "1")
  {
    paso();
  }
  var salida = true, detalle = '';
  if ($("#usuario").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar un Nombre de Usuario</h3></center>";
  }
  if ($("#nombre").val() == '')
  {
    salida = false;
    detalle += "<center><h3>Debe ingresar el Nombre Completo del Usuario</h3></center>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "usu_grab.php",
      data:
      {
        usuario: $("#usuario").val(),
        nombre: $("#nombre").val(),
        permisos: $("#permisos").val(),
        clase: $("#clase").val()
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
          $("#aceptar").hide();
          $("#usuario").prop("disabled",true);
          $("#nombre").prop("disabled",true);
          $("#tipo").prop("disabled",true);
          $("#clase").prop("disabled",true);
          for (i=0;i<document.formu.elements.length;i++)
          {
            saux = document.formu.elements[i].name;
            if (saux.indexOf('opt_')!=-1)
            {
              document.getElementById(saux).setAttribute("disabled","disabled");
            }
          }
          consulta();
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
    });
  }
}
function consulta()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "usu_consu.php",
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
      $("#res_usua").html('');
      var registros = data;
      $("#res_usua").append(registros);
    }
  });
}
function consulta1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "usu_consu2.php",
    data:
    {
      usuario: $("#filtro").val()
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
      $("#res_usua").html('');
      var registros = data;
      $("#res_usua").append(registros);
    }
  });
}
function modif(valor)
{
  $("#aceptar").hide();
  $("#actualizar").show();
  $("#cancelar").show();
  var v_super = $("#super").val();
  if (v_super == "1")
  {
    $("#img1").show();
    $("#img2").hide();
  }
  else
  {
    $("#img1").hide();
    $("#img2").hide();
  }
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "usu_consu1.php",
    data:
    {
      conse: valor
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
      $("#datos").show();
      var registros = JSON.parse(data);
      $("#conse").val(registros.conse);
      $("#usuario").val(registros.usuario);
      $("#usuario").prop("disabled",true);
      $("#login").val(registros.usuario);
      $("#nombre").val(registros.nombre);
      $("#nombre").prop("disabled",false);
      $("#tipo").val('1').change();
      $("#tipo").prop("disabled",true);
      $("#clase").val(registros.super);
      var modulos = registros.modulos;
      var var_ocu = modulos.split(",");
      var var_ocu1 = var_ocu.length;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('opt_')!=-1)
        {
          $("#"+saux).prop("disabled",false);
          valor = document.getElementById(saux).checked;
          if (valor == true)
          {
            document.getElementById(saux).click();
          }
        }
      }
      for(var i=0; i<var_ocu1; i++)
      {
        var nombre = var_ocu[i];
        $("#opt_"+nombre).click();
      }
    }
  });
}
function actualiza()
{
  paso();
  var usuario = $("#usuario").val();
  var permisos = $("#permisos").val();
  var clase = $("#clase").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "usu_permisos.php",
    data:
    {
      usuario: usuario,
      permisos: permisos,
      clase: clase
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
      if (valida == "1")
      {
        $("#conse1").val("0");
        detalle = "<center><h3>Permisos Actualizados</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#nombre").prop("disabled",true);
        $("#clase").prop("disabled",true);
        $("#actualizar").hide();
        $("#cancelar").hide();
        $("#roles1").hide();
        $("#lbl_rol").hide();
        $("#aceptar1").hide();
        for (i=0;i<document.formu.elements.length;i++)
        {
          saux = document.formu.elements[i].name;
          if (saux.indexOf('op_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
      }
      else
      {
        detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function actualiza1()
{
  $("#img1").hide();
  $("#img2").show();
  $("#aceptar").hide();
  $("#actualizar").hide();
  $("#nombre").prop("disabled",true);
  $("#clase").prop("disabled",true);
  $("#usuario").prop("disabled",false);
  $("#usuario").focus();
}
function actualiza2()
{
  var usuario = $("#usuario").val();
  var login = $("#login").val();
  var detalle = "<center><h3>Esta seguro de actualizar el usuario <font color='#3333ff'>"+login+"</font> por <font color='#ff0000'>"+usuario+"</font> ?</h3></center>";
  $("#dialogo4").html(detalle);
  $("#dialogo4").dialog("open");
  $("#dialogo4").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function actualiza3()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "usu_actu.php",
    data:
    {
      conse: $("#conse").val(),
      usuario: $("#usuario").val(),
      login: $("#login").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        $("#img2").hide();
        $("#usuario").prop("disabled",true);
      }
    }
  });
}
function esta(valor,valor1)
{
  var valor, valor1;
  var detalle = "<center><h3>Esta seguro de cambiar el estado del usuario "+valor1+" ?</h3></center>";
  $("#conse1").val(valor);
  $("#dialogo3").html(detalle);
  $("#dialogo3").dialog("open");
  $("#dialogo3").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function esta1(valor)
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "usu_estado.php",
    data:
    {
      conse: $("#conse1").val()
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
      if (valida == "1")
      {
        $("#conse1").val("0");
        detalle = "<center><h3>Cambio de Estado Correcto</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
      else
      {
        detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function clave(valor,valor1)
{
  var valor, valor1;
  var detalle = "<center><h3>Esta seguro de reiniciar la clave del usuario "+valor1+" ?</h3></center>";
  $("#conse1").val(valor);
  $("#dialogo2").html(detalle);
  $("#dialogo2").dialog("open");
  $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function clave1(valor)
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "usu_clave.php",
    data:
    {
      conse: $("#conse1").val()
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
      if (valida == "1")
      {
        $("#conse1").val("0");
        detalle = "<center><h3>Reinicio de Clave Correcto</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
      else
      {
        detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function reinicio(valor,valor1)
{
  var valor, valor1;
  var detalle = "<center><h3>Esta seguro de reiniciar la parametrización del usuario "+valor1+" ?</h3></center>";
  $("#conse1").val(valor);
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
function reinicio1(valor)
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "usu_reini.php",
    data:
    {
      conse: $("#conse1").val()
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
      if (valida == "0")
      {
        $("#conse1").val("0");
        detalle = "<center><h3>Reinicio de Parametrización Correcto</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
      else
      {
        detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function marca(valor)
{
  var valor1 = $("#op_"+valor+"_x").val();
  if (valor1 == "X")
  {
    $("#op_"+valor+"_x").val('');
  }
  else
  {
    $("#op_"+valor+"_x").val('X');    
  }
}
function marca1()
{
  var valor1 = $("#opt").val();
  if (valor1 == "X")
  {
    $("#opt").val('');
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('op_')!=-1)
      {
        document.getElementById(saux).value="";
      }
    }
  }
  else
  {
    $("#opt").val('X');
    for (i=0;i<document.formu.elements.length;i++)
    {
      saux = document.formu.elements[i].name;
      if (saux.indexOf('op_')!=-1)
      {
        document.getElementById(saux).value="X";
      }
    }
  }
}
function revisa()
{
  document.getElementById('conses').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('op_')!=-1)
    {
      valor = document.getElementById(saux).value;
      if (valor == "X")
      {
        document.getElementById('conses').value=document.getElementById('conses').value+saux+",";  
      }
    }
  }
  actu_rol();
}
function actu_rol()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "usu_roles.php",
    data:
    {
      conses: $("#conses").val(),
      rol: $("#roles1").val()
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
      detalle = "<center><h3>Rol Asigando Correctamente</h3></center>";
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
  });
}
function recarga()
{
  location.href = "admi_usuarios.php";
}
</script>
</body>
</html>
<?php
}
// 23/08/2023 - Ajuste en el titulo de la pantalla
// 21/02/2024 - Ajuste grabacion permisos y clase de superusuario
// 06/03/2024 - Ajuste usuarios administradores de transportes
?>