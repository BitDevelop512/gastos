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
include('encabezado.php');
include('encabezado1.php');
?>
</head>
<body>
<?php
include('titulo.php');
?>
<div>
  <div id="soportes">
    <h3>Creaci&oacute;n Roles de Usuarios</h3>
    <div>
      <form name="formu" method="post">
        <table align="center" width="95%" border="0">
            <tr>
              <td width="50%" valign="top">
                <table align="center" width="100%" border="0">
                  <tr>
                    <td height="20" valign="bottom">
                      <b>Nombre del Rol</b>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="hidden" name="conse" id="conse" class="c2" value="0" readonly="readonly">
                      <input type="text" name="nombre" id="nombre" class="c6" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                    </td>
                  </tr>
                  <tr>
                    <td height="20" valign="bottom">
                      <br>
                      <b>Lista de Permisos del Rol</b>
                      <hr>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <b>Modulo Planeaci&oacute;n</b>
                      <?php
                      $query = "SELECT * FROM cx_ctr_mod WHERE modulo='A' ORDER BY conse";
                      $cur = odbc_exec($conexion, $query);
                      $i=0;
                      while($i<$row=odbc_fetch_array($cur))
                      {
                        $conse = odbc_result($cur,1);
                        $modulo = odbc_result($cur,2);
                        $numero = odbc_result($cur,3);
                        $valor = $modulo."|".$numero."/";
                        $nombre = trim(utf8_encode(odbc_result($cur,4)));
                        echo "<span><input type='checkbox' name='op_".$conse."' id='op_".$conse."' value='".$valor."'><label for='op_".$conse."'>".$nombre."</label></span>";
                        $i++;
                      }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <b>Modulo Ejecuci&oacute;n</b>
                      <?php
                      $query1 = "SELECT * FROM cx_ctr_mod WHERE modulo='B' ORDER BY conse";  
                      $cur1 = odbc_exec($conexion, $query1);
                      $i=0;
                      while($i<$row=odbc_fetch_array($cur1))
                      {
                        $conse = odbc_result($cur1,1);
                        $modulo = odbc_result($cur1,2);
                        $numero = odbc_result($cur1,3);
                        $valor = $modulo."|".$numero."/";
                        $nombre = trim(utf8_encode(odbc_result($cur1,4)));
                        echo "<span><input type='checkbox' name='op_".$conse."' id='op_".$conse."' value='".$valor."'><label for='op_".$conse."'>".$nombre."</label></span>";
                        $i++;
                      }
                      ?>
                      <input type="hidden" name="permisos" id="permisos" class="c6" readonly="readonly">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <br>
                      <center>
                        <input type="button" name="aceptar" id="aceptar" value="Grabar">
                        <input type="button" name="actualizar" id="actualizar" value="Actualizar">
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" name="cancelar" id="cancelar" value="Cancelar">
                      </center>
                    </td>
                  </tr>
                </table>
              </td>
              <td width="50%" valign="top">
                <center>
                  Lista de Roles Configurados
                </center>
                <br>
                <div id="res_roles"></div>
              </td>
            </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<div id="dialogo"></div>
<div id="load">
  <center>
    <img src="imagenes/cargando.gif" alt="Cargando..." />
  </center>
</div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "Cx Computers",
    height: 250,
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
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(graba);
  $("#actualizar").button();
  $("#actualizar").hide();
  $("#actualizar").click(actualiza);
  $("#cancelar").button();
  $("#cancelar").hide();
  $("#cancelar").click(recarga);
  consulta();
});
function paso()
{
  document.getElementById('permisos').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux = document.formu.elements[i].name;
    if (saux.indexOf('op_')!=-1)
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
function graba()
{
  paso();
  var salida = true, detalle = '';
  if ($("#nombre").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar un Nombre de Rol<br><br>";
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
function actualiza()
{
  paso();
  var salida = true, detalle = '';
  if ($("#nombre").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar un Nombre de Rol<br><br>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
  }
  else
  {
    nuevo1();
  }
}
function nuevo()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "rol_grab.php",
    data:
    {
      nombre: $("#nombre").val(),
      permisos: $("#permisos").val()
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
        $("#nombre").prop("disabled",true);
        for (i=0;i<document.formu.elements.length;i++)
        {
          saux=document.formu.elements[i].name;
          if (saux.indexOf('op_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        consulta();
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#aceptar").show();
      }
    }
  });
}
function nuevo1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "rol_actu.php",
    data:
    {
      conse: $("#conse").val(),
      nombre: $("#nombre").val(),
      permisos: $("#permisos").val()
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
        $("#actualizar").hide();
        $("#nombre").prop("disabled",true);
        for (i=0;i<document.formu.elements.length;i++)
        {
          saux=document.formu.elements[i].name;
          if (saux.indexOf('op_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        consulta();
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#actualizar").show();
      }
    }
  });
}
function consulta()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "rol_consu.php",
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
      $("#res_roles").html('');
      var registros = data;
      $("#res_roles").append(registros);
    }
  });
}
function modif(valor)
{
  $("#aceptar").hide();
  $("#actualizar").show();
  $("#cancelar").show();
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "rol_consu1.php",
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
      var registros = JSON.parse(data);
      $("#conse").val(registros.conse);
      $("#nombre").val(registros.nombre);
      $("#nombre").prop("disabled",false);
      var modulos = registros.modulos;
      var var_ocu = modulos.split(",");
      var var_ocu1 = var_ocu.length;
      for (i=0;i<document.formu.elements.length;i++)
      {
        saux = document.formu.elements[i].name;
        if (saux.indexOf('op_')!=-1)
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
        $("#op_"+nombre).click();
      }
    }
  });
}
function recarga()
{
  location.href = "admi_roles.php";
}
</script>
</body>
</html>
<?php
}
?>