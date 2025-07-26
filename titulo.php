<?php
session_start();
error_reporting(0);
$chat = $_SESSION["chat"];
include('encabezado.php');
?>
<style>
#icon
{
  height: 30px;
  width: 30px;
  position: relative;
}
#n_noti
{
  padding-top: 0px;
  position: absolute;
  top: -5px;
  right: -5px;
  background-color: #f00;
  width: 20px;
  height: 20px;
  color: #ffffff;
  border-radius: 20px
  -moz-border-radius: 20px;
  -webkit-border-radius: 20px;
  text-align: center;
  border: 0px solid #ffffff;
}
.imagen1
{
  margin-top: 5px;
}
.label-container
{
  position: fixed;
  bottom: 17px;
  right: 93px;
  display: table;
  visibility: hidden;
}
.label-text
{
  font-family: Verdana, Geneva, sans-serif;
  font-size: 12px;
  color: #FFF;
  background: rgba(51,51,51,0.5);
  display: table-cell;
  vertical-align: middle;
  padding: 10px;
  border-radius: 3px;
}
.label-arrow
{
  display: table-cell;
  vertical-align: middle;
  color: #333;
  opacity: 0.5;
}
.float
{
  position: fixed;
  width: 50px;
  height: 50px;
  bottom: 10px;
  right: 35px;
  background-color: #1789EA;
  color: #FFF;
  border-radius: 50px;
  text-align: center;
  box-shadow: 2px 2px 3px #999;
}
a.float + div.label-container
{
  visibility: hidden;
  opacity: 0;
  transition: visibility 0s, opacity 0.5s ease;
}
a.float:hover + div.label-container
{
  visibility: visible;
  opacity: 1;
}
.chat-box
{
  position: fixed;
  right: 15px;
  bottom: 0;
  box-shadow: 0 0 0.1em #000;
  z-index: 99999;
}
.chat-header
{
  cursor: pointer;
  width: 600px;
  height: 35px;
  background: #8bc34a;
  line-height: 33px;
  text-indent: 20px;
  border: 1px solid #777;
  border-bottom: none;
}
.chat-content
{
  width: 600px;
  height: 500px;
  background: #ffffff;
  border: 1px solid #777;
  overflow-y: auto;
  word-wrap: break-word;
}
.box
{
  width: 10px;
  height: 10px;
  background: green;
  float: left;
  position: relative;
  top: 11px;
  left: 10px;
  border: 1px solid #ededed;
}
.hide
{
  display:none;
}
</style>
<?php
if ($chat == "SI")
{
?>
  <a href="#" class="float" name="boton1" id="boton1">
  	<img src="imagenes/chat.png" width="35" class="imagen1">
  </a>
<?php
}
?>
<div class="label-container">
  <div class="label-text">Chat Sigar</div>
</div>
<div class="chat-box">
  <div class="chat-header hide">
    <div class="box"></div><font face="Verdana" size="2">Chat Sigar</font>
  </div>
  <div class="chat-content hide">
    <div name="chat1" id="chat1"></div>
  </div>
</div>
<div id="dialogo_mensajes"></div>
<table align="center" width="95%" border="0">
  <tr>
  	<td>
	    <center>
	      <font face="Verdana" size="2" color="#000000">
	        Bienvenido(a): 
	      </font>
	      <br>
	      <font face="Verdana" size="2" color="#0000FF">
	        <b>
	        	<?php
	        	echo $usu_usuario." - ".$nom_usuario;
	        	echo "<br>";
	        	echo $sig_usuario;
	        	if ($tip_usuario == "999")
	        	{
	        	}
	        	else
	        	{
	        		echo " - ".$cmp_usuario;
	        	}
	        	?>
	        </b>
	      </font>
	    </center>
  	</td>
   	<td width="40">
	    <?php
	    if ($_SESSION["autenticado"] != "SI")
	    {
    		echo "&nbsp;";
	    }
	    else
	    {
	    	echo "<div align='center'><div id='icon'><img src='imagenes/campana.png' width='30'  height='30'><div id='n_noti'>0</div></div></div>";
	    ?>
	    	<script>
        $("#dialogo_mensajes").dialog({
          autoOpen: false,
          title: "SIGAR",
          height: 500,
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
          },
          buttons: {
            "Aceptar": function() {
              $(this).dialog("close");
            }
          }
        });
	    	function notifica()
	    	{
	    		$("#n_noti").html("");
          $.ajax({
            type: "POST",
            datatype: "json",
            url: "trae_notifica.php",
            success: function (data)
            {
              var registros = JSON.parse(data);
              var contador = registros.contador;
              var mensajes = registros.mensajes;
              var salida = "<font face='Verdana' size='2'>"+contador+"</font>";
              $("#n_noti").append(salida);
              if (contador == "0")
              {
                $("#n_noti").hide();
              }
              else
              {
                $("#n_noti").show();
              }
              if (mensajes > 0)
              {
                dialogo();
              }
            }
          });
        }
        function dialogo()
        {
          $.ajax({
            type: "POST",
            datatype: "json",
            url: "trae_mensaje.php",
            success: function (data)
            {
              var registros = JSON.parse(data);
              var mensaje = registros.mensaje;
              $("#dialogo_mensajes").html(mensaje);
              $("#dialogo_mensajes").dialog("open");
              $("#dialogo_mensajes").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
            }
          }); 
        }
        setInterval(notifica, 60000);
        </script>
	    <?php
	    }
	    ?>
  	</td>
   	<td width="40">
	    <?php
	    if ($_SESSION["autenticado"] != "SI")
	    {
    		echo "&nbsp;";
	    }
	    else
	    {
	    	echo "<center><img src='imagenes/usuario_autenticado.png' width='40'  height='40'></center>";
	    }
	    ?>
  	</td>
  	<td width="40">
    <?php
    if ($_SESSION["autenticado"] != "SI")
    {
    	echo "&nbsp;";
    }
    else
    {
    	echo "<center><a href='logout.php'><img src='imagenes/logout.png' title='Cerrar Sesión' border='0'></a></center>";
    }
    ?>
  </td>
  </tr>
</table>
<script>
$("#n_noti").hide();
notifica();
$(".chat-header").on("click",function(e){
	$("#boton1").show();
	$(".chat-header,.chat-content").addClass("hide");
});
$("#boton1").on("click",function(e)
{
	$("#boton1").hide();
	$(".chat-header,.chat-content").removeClass("hide");
	var salida = "<embed src='./chat/chat_sigar.php' width='100%' height='450'/>";
	$("#chat1").html('');
	$("#chat1").append(salida);
});
</script>