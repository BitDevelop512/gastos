<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$query = "SELECT * FROM cx_usu_web ORDER BY nombre";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	$salida = "<table width='100%' align='center' border='1' id='a-table1'><tr><td height='35' width='35%'><center><b>Nombre</b></center></td><td height='35' width='20%'><center><b>Usuario</b></center></td><td height='35' width='10%'><center>&nbsp</center></td><td height='35' width='10%'><center>&nbsp</center></td><td height='35' width='10%'><center>&nbsp</center></td><td height='35' width='10%'><center>&nbsp</center></td><td height='35' width='5%'><center>&nbsp</center></td></tr>";
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$conse = odbc_result($cur,1);
		$usuario = trim(odbc_result($cur,3));
		$nombre = trim(utf8_encode(odbc_result($cur,4)));
		$conexion1 = odbc_result($cur,7);
		$reini = '"'.$conse.'","'.$usuario.'"';
		if ($conexion1 == "2")
		{
			$salida .= "<tr><td height='35'>".$nombre."</td><td height='35'>".$usuario."</td><td height='35'><center><a href='#' onclick='modif(".$conse.")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td><td height='35'><center><a href='#' onclick='clave(".$reini.")'><img src='imagenes/clave.png' border='0' title='Restablecer Password' width='24' height='24'></a></center></td><td height='35'><center><a href='#' onclick='reinicio(".$reini.")'><img src='imagenes/reiniciar.png' border='0' title='Reiniciar Parametrizaci&oacute;n' width='24' height='24'></a></center></td><td height='35'><center><a href='#' onclick='esta(".$reini.")'><img src='imagenes/estado.png' border='0' title='Cambio de Estado' width='24' height='24'></a></center></td><td height='35'><center><input type='text' name='op_".$conse."_x' id='op_".$conse."_x' class='form-control fecha' size='1' maxlength='1' onclick='marca(".$conse.")' readonly='readonly'></center></td></tr>";
		}
		else
		{
			$salida .= "<tr><td height='35'>".$nombre."</td><td height='35'>".$usuario."</td><td><center><a href='#' onclick='modif(".$conse.")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td><td height='35'><center>&nbsp;</center></td><td height='35'><center><a href='#' onclick='reinicio(".$reini.")'><img src='imagenes/reiniciar.png' border='0' title='Reiniciar Parametrizaci&oacute;n' width='24' height='24'></a></center></td><td height='35'><center>&nbsp;</center></td></tr>";
		}
		$i++;
	}
	$salida .= "</table>";
	echo $salida;
}
?>