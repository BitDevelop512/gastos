<?php
	session_start();
	error_reporting(0);
	include "../conf.php";
	include "../permisos.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CHAT Gastos</title>
		<meta charset="UTF-8">
		<link href="estilos_Chat.css?1.0.2" rel="stylesheet" type="text/css">
	
		<script type="text/javascript">
			function ajax(){
				var req = new XMLHttpRequest();
				req.onreadystatechange = function(){
					if (req.readyState == 4 && req.status == 200) {
						document.getElementById('chat').innerHTML = req.responseText;
					}
				}
				req.open('GET', 'msg_chat.php', true);
				req.send();
			}
			setInterval(function(){ajax();}, 1000); //Refresca la pagina cada segundo...
		</script>        
	</head>
	<body onload="ajax();">
		<div id="contenedor">
			<h2><em>Chat Usuarios SIGAR</em></h2>
			<?php
			    echo "<h3>$usu_usuario</h3>";
			?>				
			<div id="caja-chat">
				<div id="chat"></div>
			</div>

			<form method="POST" action="chat_sigar.php">
				<textarea name="mensaje" placeholder="Ingrese el mensaje"></textarea>
				<input type="submit" name="enviar" value="Enviar">
			</form>

			<?php
				if (isset($_POST['enviar'])) 
				{
					$usuario = $usu_usuario;
					$mensaje = $_POST['mensaje'];
					$fecha = date('Y-m-d H:i:s');
					$l_usuario = strlen($usuario);
					$l_mensaje = strlen($mensaje);
				
					if ($l_mensaje == 0)
					{
						$msg = "Error: Debe llenar el campo mensaje.";
						print $msg;						
					}
					else
					{
						$consulta = "insert into cx_chat_msg (usuario, mensaje, fecha) values ('$usuario', '$mensaje','$fecha')";
						$cur = odbc_exec($conexion, $consulta);
					}
					$msg = "";
					$usuario = "";
					$mensaje = "";
					$fecha = "";
				}
			?>
		</div>
	</body>
</html>
