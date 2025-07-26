<!doctype html>
<?php
session_start();
error_reporting(0);
?>
<html lang="es">
<head>
  <script src="js/cufon-yui.js" type="text/javascript"></script>
  <script src="js/chunkFive_400.font.js" type="text/javascript"></script>
  <script type="text/javascript">
  Cufon.replace("h1",{ textShadow: "1px 1px #fff"});
  Cufon.replace("h2",{ textShadow: "1px 1px #fff"});
  Cufon.replace("h3",{ textShadow: "1px 1px #000"});
  Cufon.replace(".back");
  </script>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="jquery/jquery1/jquery-ui.css" rel="stylesheet" />
  <script src="jquery/jquery1/jquery.js"></script>
  <script src="jquery/jquery1/jquery-ui.js"></script>
  <script type="text/javascript" src="alertas/lib/alertify.js"></script>
  <link rel="stylesheet" href="alertas/themes/alertify.core.css"/>
  <link rel="stylesheet" href="alertas/themes/alertify.default.css"/>
  <style>
  body
  {
    margin-top: 3px;
    margin-left: 30px;
    margin-bottom: 3px;
    font: 75% "Trebuchet MS", sans-serif;
  }
  .form_wrapper
  {
    background: #fff;
    border: 1px solid #ddd;
    margin:0 auto;
    width: 380px;
    font-size: 16px;
    -moz-box-shadow: 1px 1px 7px #ccc;
    -webkit-box-shadow: 1px 1px 7px #ccc;
    box-shadow: 1px 1px 7px #ccc;
  }
  .form_wrapper h3
  {
    padding: 20px 30px 20px 30px;
    background-color: #444;
    color: #fff;
    font-size: 25px;
    border-bottom: 1px solid #ddd;
  }
  .form_wrapper form
  {
    display: none;
    background: #fff;
  }
  .form_wrapper .column
  {
    width: 47%;
    float: left;
  }
  form.active
  {
    display: block;
  }
  form.login
  {
    width: 380px;
  }
  form.register
  {
    width: 550px;
  }
  form.forgot_password
  {
    width: 310px;
  }
  .form_wrapper a
  { 
    text-decoration:none;
    color: #777;
    font-size: 12px;
  }
  .form_wrapper a:hover
  {
    color: #000;
  }
  .form_wrapper label
  {
    display: block;
    padding: 10px 30px 0px 30px;
    margin: 10px 0px 0px 0px;
  }
  .form_wrapper input[type="text"],
  .form_wrapper input[type="password"]
  {
    border: solid 1px #E5E5E5;
    background: #FFFFFF;
    margin: 3px 10px 3px 10px;
    padding: 9px;
    display: block;
    font-size: 16px;
    width: 85%;
    background: -webkit-gradient(linear,left top,left 25,from(#FFFFFF),color-stop(4%, #EEEEEE),to(#FFFFFF));
    background: -moz-linear-gradient(top,#FFFFFF,#EEEEEE 1px,#FFFFFF 25px);
    -moz-box-shadow: 0px 0px 8px #f0f0f0;
    -webkit-box-shadow: 0px 0px 8px #f0f0f0;
    box-shadow: 0px 0px 8px #f0f0f0;
  }
  .form_wrapper input[type="text"]:focus,
  .form_wrapper input[type="password"]:focus
  {
    background:#feffef;
  }
  .form_wrapper .bottom
  {
    background-color: #444;
    border-top: 1px solid #ddd;
    margin-top: 20px;
    clear: both;
    color: #fff;
    text-shadow:1px 1px 1px #000;
  }
  .form_wrapper .bottom a
  {
    display: block;
    clear: both;
    padding: 10px 30px;
    text-align: right;
    color: #ffa800;
    text-shadow: 1px 1px 1px #000;
  }
  .form_wrapper a.forgot
  {
    float: right;
    font-style: italic;
    line-height: 24px;
    color: #fc0c04;
    text-shadow: 1px 1px 1px #fff;
  }
  .form_wrapper a.forgot:hover
  {
    color: #000000;
  }
  .form_wrapper div.remember
  {
    float: left;
    width: 140px;
    margin: 20px 0px 20px 30px;
    font-size: 11px;
  }
  .form_wrapper div.remember input
  {
    float: left;
    margin: 2px 5px 0px 0px;
  }
  .form_wrapper span.error
  {
    visibility: hidden;
    color: red;
    font-size: 11px;
    font-style: italic;
    display: block;
    margin: 4px 30px;
  }
  .form_wrapper input[type="submit"]
  {
    background: #e3e3e3;
    border: 1px solid #ccc;
    color: #333;
    font-family: "Trebuchet MS", "Myriad Pro", sans-serif;
    font-size: 14px;
    font-weight: bold;
    padding: 8px 0 9px;
    text-align: center;
    width: 150px;
    cursor: pointer;
    margin: 15px 20px 10px 10px;
    text-shadow: 0px 1px 0px #fff;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    -moz-box-shadow: 0px 0px 2px #fff inset;
    -webkit-box-shadow: 0px 0px 2px #fff inset;
    box-shadow: 0px 0px 2px #fff inset;
  }
  .form_wrapper input[type="submit"]:hover
  {
    background: #d9d9d9;
    -moz-box-shadow: 0px 0px 2px #eaeaea inset;
    -webkit-box-shadow: 0px 0px 2px #eaeaea inset;
    box-shadow: 0px 0px 2px #eaeaea inset;
    color: #222;
  }
  .div1
  {
    margin-left: 15px;
  }
  .ui-widget
  {
    font-size: 13px;
  }
  .lista_sencilla
  {
    display: block;
    width: 230px;
    height: 35px;
    padding: 0px 12px;
    font-size: 13px;
    line-height: 1.42857143;
    color: #000;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
         -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
  .lista_sencilla:focus
  {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }
  .titulo1
  {
    padding: 50px;
  }
  .titulo2
  {
    padding: 120px;
  }
  </style>
</head>
<body style="overflow-x:hidden; overflow-y:hidden;">
<div id="espacio1" class="titulo1"></div>
<div id="espacio2" class="titulo2"></div>
<div id="form_wrapper" class="form_wrapper">
  <form name="formu" method="post" class="login active">
    <h3>SIGAR IMI</h3>
    <div id="load">
      <br>
      <center>
        <img src="imagenes/cargando1.gif" alt="Cargando..." />
      </center>
    </div>
    <div>
      <br>
      <div id="lbl0">
        <table width="350" align="center" border="0">
          <tr>
            <td width="50" valign="bottom">
              <center>
                <img src="imagenes/usuario.png" name="img1" id="img1" width="30" height="30">
              </center>
            </td>
            <td>
              <input type="text" name="usuario" id="usuario" maxlength="15" placeholder="Digite su usuario" onchange="javascript:this.value=this.value.toUpperCase();" autocomplete="off" required />
            </td>
          </tr>
        </table>
      </div>
      <div id="lbl1">
        <table width="350" align="center" border="0">
          <tr>
            <td width="50" valign="bottom">
              <center>
                <img src="imagenes/clave.png" width="30" height="30">
              </center>
            </td>
            <td>
              <input type="password" name="clave" id="clave" maxlength="10" placeholder="Digite su password" autocomplete="off" required />
              <select name="conexion" id="conexion" class="lista_sencilla">
                <option value="2">BASE DE DATOS</option>
                <option value="1">LDAP</option>
              </select>
            </td>
          </tr>
        </table>
      </div>
      <div id="lbl2">
        <table width="350" align="center" border="0">
          <tr>
            <td width="50" valign="bottom">
              <center>
                <img src="imagenes/correo.png" width="30" height="30">
              </center>
            </td>
            <td>
              <input type="text" name="email1" id="email1" maxlength="60" placeholder="Digite su correo" autocomplete="off" />
            </td>
          </tr>
      </div>
      </table>
    </div>
    <div>
      <center>
        <br>
        <div id="lbl3">
          <input type="checkbox" name="mostrar" id="mostrar" value="1" />
          <font face="Verdana" size="2">Mostrar Contrase&ntilde;a</font>
          &nbsp;&nbsp;&nbsp;
          <input type="checkbox" name="credenciales" id="credenciales" value="1" checked />
          <font face="Verdana" size="2">Guardar Credenciales</font>
          <br><br>
        </div>
        <div id="lbl4">
          <a href="#" onclick="olvido(); return false;"><font face="Verdana" size="2" color="#3333ff"><b>Olvid&oacute; su Contrase&ntilde;a ?</b></font></a>
        </div>
      </center>
    </div>
    <div class="bottom">
      <center>
        <br>
        <button type="button" name="aceptar" name="aceptar" id="aceptar">Aceptar</button>
      </center>
      <br>
      <div class="clear"></div>
    </div>
  </form>
</div>
<center>
  <form action="paso.php" name="formu1" method="post">
    <input type="hidden" name="conse" id="conse" class="form-control" readonly="readonly">
    <input type="hidden" name="login" id="login" class="form-control" readonly="readonly">
    <input type="hidden" name="nombre" id="nombre" class="form-control" readonly="readonly">
    <input type="hidden" name="contrasena" id="contrasena" class="form-control" readonly="readonly">
    <input type="hidden" name="permisos" id="permisos" class="form-control" readonly="readonly">
    <input type="hidden" name="cambio" id="cambio" class="form-control" readonly="readonly">
    <input type="hidden" name="tipo" id="tipo" class="form-control" readonly="readonly">
    <input type="hidden" name="unidad" id="unidad" class="form-control" readonly="readonly">
    <input type="hidden" name="email" id="email" class="form-control" readonly="readonly">
    <input type="hidden" name="admin" id="admin" class="form-control" readonly="readonly">
    <input type="hidden" name="sigla" id="sigla" class="form-control" readonly="readonly">
    <input type="hidden" name="ciudad" id="ciudad" class="form-control" readonly="readonly">
    <input type="hidden" name="cedula" id="cedula" class="form-control" readonly="readonly">
    <input type="hidden" name="cargo" id="cargo" class="form-control" readonly="readonly">
    <input type="hidden" name="batallon" id="batallon" class="form-control" readonly="readonly">
    <input type="hidden" name="brigada" id="brigada" class="form-control" readonly="readonly">
    <input type="hidden" name="division" id="division" class="form-control" readonly="readonly">
    <input type="hidden" name="tipou" id="tipou" class="form-control" readonly="readonly">
    <input type="hidden" name="tipoc" id="tipoc" class="form-control" readonly="readonly">
    <input type="hidden" name="compania" id="compania" class="form-control" readonly="readonly">
    <input type="hidden" name="nunidad" id="nunidad" class="form-control" readonly="readonly">
    <input type="hidden" name="dunidad" id="dunidad" class="form-control" readonly="readonly">
    <input type="hidden" name="super" id="super" class="form-control" readonly="readonly">
    <input type="hidden" name="login1" id="login1" class="form-control" readonly="readonly">
    <input type="hidden" name="ancho" id="ancho" class="form-control" readonly="readonly">
    <input type="hidden" name="alto" id="alto" class="form-control" readonly="readonly">
    <input type="hidden" name="servidor" id="servidor" class="form-control" readonly="readonly">
    <input type="hidden" name="recupera" id="recupera" value="0" class="form-control" readonly="readonly">
  </form>
</center>
<div class="clear"></div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;
});
$(document).ready(function () {
  $("#load").hide();
  $("#aceptar").button();
  $("#aceptar").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar").click(validacion);
  var cre_usu = localStorage.getItem("usuario");
  if ((cre_usu === undefined) || (cre_usu === null))
  {
    cre_usu = "";
  }
  else
  {
    if (cre_usu != "")
    {
      cre_usu = cre_usu.toUpperCase();
    }
  }
  $("#usuario").val(cre_usu);
  $("#conexion").hide();
  $("#conexion").val('2').change();
  $("#conexion").prop("disabled",true);
  $("input:password").keypress(function(event) {
    if (event.keyCode == 13)
    {
      $("#aceptar").click();
      event.preventDefault();
      return false;
    }
  });
  var ancho = screen.width;
  var alto = screen.height;
  $("#ancho").val(ancho);
  $("#alto").val(alto);
  var recupera = $("#recupera").val();
  if (recupera == "0")
  {
    $("#lbl2").hide();
  }
  var servidor = location.host;
  $("#servidor").val(servidor);
  $("#img1").mousedown(function(event) {
    switch (event.which)
    {
      case 3:
        activacion();
        break;
      default:
        break;
    }
  });
  espacios();
});
(function ($) {
  $.toggleShowPassword = function (options) {
    var settings = $.extend({
      field: "#password",
      control: "#toggle_show_password",
    }, options);
    var control = $(settings.control);
    var field = $(settings.field);
    control.bind("click", function () {
    if (control.is(":checked"))
    {
      field.attr("type", "text");
    }
    else
    {
      field.attr("type", "password");
    }
  })
};
}(jQuery));
$.toggleShowPassword({
  field: "#clave",
  control: "#mostrar"
});
function espacios()
{
  var ancho = $("#ancho").val();
  var alto = $("#alto").val();
  if (alto == "1080")
  {
    $("#espacio1").hide();
    $("#espacio2").show();
  }
  else
  {
    if (alto == "768")
    {
      $("#espacio1").show();
      $("#espacio2").hide();
    }
    else
    {
      $("#espacio1").show();
      $("#espacio2").hide();
    }
  }
}
function validacion()
{
  guarda();
  var salida = true;
  var v_usuario = $("#usuario").val();
  v_usuario = v_usuario.trim().length;
  if (v_usuario == "0")
  {
    salida = false;
    var detalle = "<font face='Verdana' size='3'>Nombre de usuario obligatorio</font>";
    alerta(detalle);
  }
  var recupera = $("#recupera").val();
  if (recupera == "0")
  {
    var v_clave = $("#clave").val();
    v_clave = v_clave.trim().length
    if (v_clave == "0")
    {
      salida = false;
      var detalle = "<font face='Verdana' size='3'>Password de usuario obligatorio</font>";
      alerta(detalle);
    }
  }
  else
  {
    var v_email = $("#email1").val();
    v_email = v_email.trim().length
    if (v_email == "0")
    {
      salida = false;
      var detalle = "<font face='Verdana' size='3'>Correo electrónico obligatorio</font>";
      alerta(detalle);
    }
    else
    {
      var str = $("#email1").val();
      str = str.trim();
      var at = "@";
      var dot = ".";
      var lat = str.indexOf(at);
      var lstr = str.length;
      var ldot = str.indexOf(dot);
      if (str.indexOf(at) == -1)
      {
        salida = false;
      }
      if (str.indexOf(at) == -1 || str.indexOf(at) == 0 || str.indexOf(at) == lstr)
      {
        salida = false;
      }
      if (str.indexOf(dot) == -1 || str.indexOf(dot) == 0 || str.indexOf(dot) == lstr)
      {
        salida = false;
      }
      if (str.indexOf(at,(lat+1)) != -1)
      {
        salida = false;
      }
      if (str.substring(lat-1,lat) == dot || str.substring(lat+1,lat+2) == dot)
      {
        salida = false;
      }
      if (str.indexOf(dot,(lat+2)) == -1)
      {
        salida = false;
      }
      if (str.indexOf(" ") != -1)
      {
        salida = false;
      }
      if (salida == false)
      {
        var detalle = "<font face='Verdana' size='3'>Correo electrónico no válido</font>";
        alerta(detalle);
      }
    }
  }
  if (salida == false)
  {
  }
  else
  {
    consulta1();
  }
}
function activacion()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "act_usuario.php",
    data:
    {
      usuario: $("#usuario").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        var detalle = "<font face='Verdana' size='3'>Usuario Actualizado</font>";
        alerta(detalle);
      }
    }
  });
}
function guarda()
{
  var usuario = document.getElementById("usuario").value;
  var credenciales = document.getElementById("credenciales").checked;
  if (credenciales == true)
  {
    localStorage.setItem("usuario",usuario);
  }
  else
  {
    localStorage.setItem("usuario","");
  }
}
function consulta1()
{
  var recupera = $("#recupera").val();
  if (recupera == "0")
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "con_usuario.php",
      data:
      {
        conexion: $("#conexion").val(),
        usuario: $("#usuario").val(),
        clave: $("#clave").val()
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
        var mensaje = registros.mensaje;
        if (valida == "0")
        {
          var detalle1 = "<font face='Verdana' size='3'>"+mensaje+"</font>";
          alerta(detalle1);
        }
        else
        {
          $("#conse").val(registros.conse);
          $("#login").val(registros.usuario);
          $("#nombre").val(registros.nombre);
          $("#contrasena").val(registros.clave);
          $("#permisos").val(registros.permisos);
          $("#cambio").val(registros.cambio);
          $("#tipo").val(registros.tipo);
          $("#unidad").val(registros.unidad);
          $("#email").val(registros.email);
          $("#admin").val(registros.admin);
          $("#sigla").val(registros.sigla);
          $("#ciudad").val(registros.ciudad);
          $("#cedula").val(registros.cedula);
          $("#cargo").val(registros.cargo);
          $("#batallon").val(registros.batallon);
          $("#brigada").val(registros.brigada);
          $("#division").val(registros.division);
          $("#tipou").val(registros.tipou);
          $("#tipoc").val(registros.tipoc);
          $("#compania").val(registros.compania);
          $("#nunidad").val(registros.nunidad);
          $("#dunidad").val(registros.dunidad);
          $("#super").val(registros.super);
          $("#login1").val(registros.login);
          formu1.submit();
        }
      }
    });
  }
  else
  {
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "con_usuario2.php",
      data:
      {
        usuario: $("#usuario").val(),
        email: $("#email1").val()
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
        var valida, detalle1;
        valida = registros.salida;
        if (valida == "0")
        {
          detalle1 = "<h2>Verifique los datos ingresados</h2>";
          alerta(detalle1);
        }
        else
        {
          enviar();
          detalle1 = "<h2>Enviando correo de recuperaci&oacute;n de contrase&ntilde;a</h2>";
          alerta1(detalle1);
        }
      }
    });
  }
}
function olvido()
{
  $("#lbl1").hide();
  $("#lbl2").show();
  $("#lbl3").hide();
  $("#recupera").val('1');
  var link = '<a href="#" onclick="recarga(); return false;"><font face="Verdana" size="2" color="#3333ff"><b>Regresar</b></font></a>';
  $("#lbl4").html('');
  $("#lbl4").append(link);
}
function enviar()
{
  $("#aceptar").hide();
  $("#usuario").prop("disabled", true);
  $("#email1").prop("disabled", true);
  var tipo = "1";
  var copia = "";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "correo.php",
    data:
    {
      tipo: tipo,
      usuario: $("#usuario").val(),
      email: $("#email1").val(),
      copia: copia,
      servidor: $("#servidor").val()
    },
    success: function (data) {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      var nombre = registros.nombre;
      if (salida == "1")
      {
        alerta1("<h2>E-mail enviado correctamente a: " + nombre+"</h2>");
        setTimeout(recarga, 2000);
      }
      else
      {
        alerta("<h2>Error durante el envio e-mail</h2>");
        $("#aceptar").show();
      }
    }
  });
}
function recarga()
{
  location.reload();
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
// 25/08/2023 - Ajuste de mensajes de respuesta de la consulta de usuario
?>
