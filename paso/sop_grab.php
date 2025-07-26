<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$unidad = $_POST['unidad'];
	$numero = $_POST['numero'];
	$ano = $_POST['ano'];
	if ($tipo == "1")
	{
		$conse = $_POST['conse'];
		$cedula = $_POST['cedula'];
		$cedula = iconv("UTF-8", "ISO-8859-1", $cedula);
		$cedula = strtr(trim($cedula), $sustituye);
		$nombre = $_POST['nombre'];
		$nombre = iconv("UTF-8", "ISO-8859-1", $nombre);
		$nombre = strtr(trim($nombre), $sustituye);
		$ciudad = $_POST['ciudad'];
		$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
		$ciudad = strtr(trim($ciudad), $sustituye);
		$v1 = $_POST['v1'];
		$v2 = $_POST['v2'];
		$v3 = $_POST['v3'];
		$v4 = $_POST['v4'];
		$valor1 = $_POST['valor1'];
		$valor2 = $_POST['valor2'];
		$total = $_POST['total'];
		$total1 = $_POST['total1'];
		// Actualización de planilla
		$graba = "UPDATE cx_gas_bas SET total='$total' WHERE conse='$numero' AND unidad='$unidad' AND ano='$ano'";
		if (!odbc_exec($conexion, $graba))
		{
	    	$confirma = "0";
		}
		else
		{
			$confirma = "1";
			$graba1 = "UPDATE cx_gas_dis SET cedula='$cedula', nombre='$nombre', ciudad='$ciudad', v1='$v1', v2='$v2', v3='$v3', v4='$v4', valor='$valor1', valor1='$valor2' WHERE conse='$conse' AND conse1='$numero'";
			odbc_exec($conexion, $graba1);
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_soporte_planillas.txt", "a");
			fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
			fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
			fwrite($file, $fec_log." # ".PHP_EOL);
			fclose($file);
		}
	}
	if ($tipo == "2")
	{
		$adicional = $_POST['adicional'];
		$adicional = iconv("UTF-8", "ISO-8859-1", $adicional);
		$adicional = strtr(trim($adicional), $sustituye);
		$responsable = $_POST['responsable'];
		$responsable = iconv("UTF-8", "ISO-8859-1", $responsable);
		$responsable = strtr(trim($responsable), $sustituye);
		$elaboro = $_POST['elaboro'];
		$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
		$elaboro = strtr(trim($elaboro), $sustituye);
		// Actualización de planilla
		$graba = "UPDATE cx_gas_bas SET adicional='$adicional', responsable='$responsable', elaboro='$elaboro' WHERE conse='$numero' AND unidad='$unidad' AND ano='$ano'";
		if (!odbc_exec($conexion, $graba))
		{
	    	$confirma = "0";
		}
		else
		{
			$confirma = "1";
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_soporte_planillas.txt", "a");
			fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
			fwrite($file, $fec_log." # ".PHP_EOL);
			fclose($file);
		}
	}
	if ($tipo == "3")
	{
		$conse = $_POST['conse'];
		$usuario = $_POST['usuario'];
		$usuario1 = $_POST['usuario1'];
		$estado = $_POST['estado'];
		// Tipo de Unidad
		$query = "SELECT usuario, unidad, (SELECT tipo FROM cv_unidades WHERE cv_unidades.subdependencia=cx_pla_inv.unidad) AS tipo FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2'";
		$cur = odbc_exec($conexion, $query);
		$v_usuario = trim(odbc_result($cur,1));
		$var_ocu = explode("_", $v_usuario);
		$v_usuario = $var_ocu[0];
		$v_batallon = trim(odbc_result($cur,3));
		// Brigada
		if ($v_batallon == "BRIGADA")
		{
			if ($conse == "0")
			{
				// Actualización solicitud
				$graba = "UPDATE cx_pla_inv SET estado='', usuario2='', recursos='0' WHERE conse='$numero' AND ano='$ano' AND tipo='2'";
				if (!odbc_exec($conexion, $graba))
				{
			    	$confirma = "0";
				}
				else
				{
					$confirma = "1";
					// Log
					$fec_log = date("d/m/Y H:i:s a");
					$file = fopen("log_soporte_solicitud.txt", "a");
					fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
					fwrite($file, $fec_log." # ".PHP_EOL);
					fclose($file);
				}
			}
			else
			{
				// Estado Q
		        $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='Q' AND usuario2='$usuario' AND usuario3='$usuario1'";
		        $sql = odbc_exec($conexion, $pregunta);
		        $total = odbc_num_rows($sql);
		        if ($total>0)
		        {
					// Actualización solicitud
					$graba = "UPDATE cx_pla_inv SET estado='P', usuario3='', usuario4='', usuario5='', usuario6='', usuario7='', usuario8='', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='Q'";
					if (!odbc_exec($conexion, $graba))
					{
				    	$confirma = "0";
					}
					else
					{
						$confirma = "1";
						$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='P'";
						odbc_exec($conexion, $graba1);
						// Log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_soporte_solicitud.txt", "a");
						fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
				// Estado A
		        $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='A' AND usuario3='$usuario' AND usuario4='$usuario1'";
		        $sql = odbc_exec($conexion, $pregunta);
		        $total = odbc_num_rows($sql);
		        if ($total>0)
		        {
					// Actualización solicitud
					$graba = "UPDATE cx_pla_inv SET estado='Q', usuario4='', usuario5='', usuario6='', usuario7='', usuario8='', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='A'";
					if (!odbc_exec($conexion, $graba))
					{
				    	$confirma = "0";
					}
					else
					{
						$confirma = "1";
						$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='Q'";
						odbc_exec($conexion, $graba1);
						// Log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_soporte_solicitud.txt", "a");
						fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
				// Estado B
		        $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='B' AND usuario4='$usuario' AND usuario5='$usuario1'";
		        $sql = odbc_exec($conexion, $pregunta);
		        $total = odbc_num_rows($sql);
		        if ($total>0)
		        {
					// Actualización solicitud
					$graba = "UPDATE cx_pla_inv SET estado='A', usuario5='', usuario6='', usuario7='', usuario8='', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='B'";
					if (!odbc_exec($conexion, $graba))
					{
				    	$confirma = "0";
					}
					else
					{
						$confirma = "1";
						$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='A'";
						odbc_exec($conexion, $graba1);
						// Log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_soporte_solicitud.txt", "a");
						fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
				// Estado C
		        $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='C' AND usuario5='$usuario' AND usuario6='$usuario1'";
		        $sql = odbc_exec($conexion, $pregunta);
		        $total = odbc_num_rows($sql);
		        if ($total>0)
		        {
					// Actualización solicitud
					$graba = "UPDATE cx_pla_inv SET estado='B', usuario6='', usuario7='', usuario8='', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='', recursos='0' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='C'";
					if (!odbc_exec($conexion, $graba))
					{
				    	$confirma = "0";
					}
					else
					{
						$confirma = "1";
						$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='B'";
						odbc_exec($conexion, $graba1);
						// Log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_soporte_solicitud.txt", "a");
						fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
				// Estado E - con recursos
		        $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='E' AND usuario6='$usuario' AND usuario8='$usuario1'";
		        $sql = odbc_exec($conexion, $pregunta);
		        $total = odbc_num_rows($sql);
		        if ($total>0)
		        {
					// Actualización solicitud
					$graba = "UPDATE cx_pla_inv SET estado='C', usuario8='', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='E'";
					if (!odbc_exec($conexion, $graba))
					{
				    	$confirma = "0";
					}
					else
					{
						$confirma = "1";
						$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='C'";
						odbc_exec($conexion, $graba1);
						// Log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_soporte_solicitud.txt", "a");
						fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
				// Estado J - sin recursos
		        $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='J' AND usuario6='$usuario' AND usuario7='$usuario1'";
		        $sql = odbc_exec($conexion, $pregunta);
		        $total = odbc_num_rows($sql);
		        if ($total>0)
		        {
					// Actualización solicitud
					$graba = "UPDATE cx_pla_inv SET estado='C', usuario7='', usuario8='', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='J'";
					if (!odbc_exec($conexion, $graba))
					{
				    	$confirma = "0";
					}
					else
					{
						$confirma = "1";
						$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='C'";
						odbc_exec($conexion, $graba1);
						// Log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_soporte_solicitud.txt", "a");
						fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
				// Estado L - sin recursos
		        $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='L' AND usuario7='$usuario' AND usuario8='$usuario1'";
		        $sql = odbc_exec($conexion, $pregunta);
		        $total = odbc_num_rows($sql);
		        if ($total>0)
		        {
					// Actualización solicitud
					$graba = "UPDATE cx_pla_inv SET estado='J', usuario8='', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='L'";
					if (!odbc_exec($conexion, $graba))
					{
				    	$confirma = "0";
					}
					else
					{
						$confirma = "1";
						$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='J'";
						odbc_exec($conexion, $graba1);
						// Log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_soporte_solicitud.txt", "a");
						fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
				// Estado W
		        $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='W' AND usuario8='$usuario' AND usuario9='$usuario1'";
		        $sql = odbc_exec($conexion, $pregunta);
		        $total = odbc_num_rows($sql);
		        if ($total>0)
		        {
					// Actualización solicitud
					$graba = "UPDATE cx_pla_inv SET estado='E', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='W'";
					if (!odbc_exec($conexion, $graba))
					{
				    	$confirma = "0";
					}
					else
					{
						$confirma = "1";
						$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='E'";
						odbc_exec($conexion, $graba1);
						// Log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_soporte_solicitud.txt", "a");
						fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
			}
		}
		// Division
		if ($v_batallon == "DIVISION")
		{
			if ($conse == "0")
			{
				// Actualización solicitud
				$graba = "UPDATE cx_pla_inv SET estado='', usuario2='', recursos='0' WHERE conse='$numero' AND ano='$ano' AND tipo='2'";
				if (!odbc_exec($conexion, $graba))
				{
			    	$confirma = "0";
				}
				else
				{
					$confirma = "1";
					// Log
					$fec_log = date("d/m/Y H:i:s a");
					$file = fopen("log_soporte_solicitud.txt", "a");
					fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
					fwrite($file, $fec_log." # ".PHP_EOL);
					fclose($file);
				}
			}
			else
			{
				// Estado A - con recursos
		        $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='A' AND usuario2='$usuario' AND usuario3='' AND usuario4='$usuario1'";
		        $sql = odbc_exec($conexion, $pregunta);
		        $total = odbc_num_rows($sql);
		        if ($total>0)
		        {
					// Actualización solicitud
					$graba = "UPDATE cx_pla_inv SET estado='P', usuario3='', usuario4='', usuario5='', usuario6='', usuario7='', usuario8='', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='A'";
					if (!odbc_exec($conexion, $graba))
					{
				    	$confirma = "0";
					}
					else
					{
						$confirma = "1";
						$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='P'";
						odbc_exec($conexion, $graba1);
						// Log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_soporte_solicitud.txt", "a");
						fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
				// Estado J - con recursos
		        $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='J' AND usuario4='$usuario' AND usuario5='' AND usuario6='' AND usuario7='$usuario1'";
		        $sql = odbc_exec($conexion, $pregunta);
		        $total = odbc_num_rows($sql);
		        if ($total>0)
		        {
					// Actualización solicitud
					$graba = "UPDATE cx_pla_inv SET estado='A', usuario5='', usuario6='', usuario7='', usuario8='', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='J'";
					if (!odbc_exec($conexion, $graba))
					{
				    	$confirma = "0";
					}
					else
					{
						$confirma = "1";
						$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='A'";
						odbc_exec($conexion, $graba1);
						// Log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_soporte_solicitud.txt", "a");
						fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
				// Estado W - con recursos
		        $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='W' AND usuario7='$usuario' AND usuario8='' AND usuario9='' AND usuario10='$usuario1'";
		        $sql = odbc_exec($conexion, $pregunta);
		        $total = odbc_num_rows($sql);
		        if ($total>0)
		        {
					// Actualización solicitud
					$graba = "UPDATE cx_pla_inv SET estado='J', usuario8='', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='W'";
					if (!odbc_exec($conexion, $graba))
					{
				    	$confirma = "0";
					}
					else
					{
						$confirma = "1";
						$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='J'";
						odbc_exec($conexion, $graba1);
						// Log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_soporte_solicitud.txt", "a");
						fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
				// Estado L - sin recursos
		        $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='L' AND usuario7='$usuario' AND usuario8='$usuario1'";
		        $sql = odbc_exec($conexion, $pregunta);
		        $total = odbc_num_rows($sql);
		        if ($total>0)
		        {
					// Actualización solicitud
					$graba = "UPDATE cx_pla_inv SET estado='J', usuario8='', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='L'";
					if (!odbc_exec($conexion, $graba))
					{
				    	$confirma = "0";
					}
					else
					{
						$confirma = "1";
						$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='J'";
						odbc_exec($conexion, $graba1);
						// Log
						$fec_log = date("d/m/Y H:i:s a");
						$file = fopen("log_soporte_solicitud.txt", "a");
						fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
						fwrite($file, $fec_log." # ".PHP_EOL);
						fclose($file);
					}
				}
			}
		}
		// Batallon
		if ($v_batallon == "BATALLON")
		{
			// Estado O - con recursos
			$pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='O' AND usuario9='' AND usuario10='$usuario' AND usuario11='' AND usuario12='$usuario1' AND usuario13=''";
			$sql = odbc_exec($conexion, $pregunta);
			$total = odbc_num_rows($sql);
			if ($total>0)
			{
				// Actualización solicitud
				$graba = "UPDATE cx_pla_inv SET estado='M', usuario12='', usuario13='', usuario14='', usuario15='', usuario16='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='O'";
				if (!odbc_exec($conexion, $graba))
				{
			    	$confirma = "0";
				}
				else
				{
					$confirma = "1";
					$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='M'";
					odbc_exec($conexion, $graba1);
					// Log
					$fec_log = date("d/m/Y H:i:s a");
					$file = fopen("log_soporte_solicitud.txt", "a");
					fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
					fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
					fwrite($file, $fec_log." # ".PHP_EOL);
					fclose($file);
				}
			}
			// Estado M - con recursos
		    $pregunta = "SELECT * FROM cx_pla_inv WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='M' AND usuario8='$usuario' AND usuario9='' AND usuario10='$usuario1' AND usuario11='' AND usuario12=''";
			$sql = odbc_exec($conexion, $pregunta);
			$total = odbc_num_rows($sql);
			if ($total>0)
			{
				// Actualización solicitud
				$graba = "UPDATE cx_pla_inv SET estado='C', usuario9='', usuario10='', usuario11='', usuario12='', usuario13='' WHERE conse='$numero' AND ano='$ano' AND tipo='2' AND estado='M'";
				if (!odbc_exec($conexion, $graba))
				{
				    $confirma = "0";
				}
				else
				{
					$confirma = "1";
					$graba1 = "DELETE FROM cx_pla_est WHERE conse='$conse' AND solicitud='$numero' AND ano='$ano' AND estado='C'";
					odbc_exec($conexion, $graba1);
					// Log
					$fec_log = date("d/m/Y H:i:s a");
					$file = fopen("log_soporte_solicitud.txt", "a");
					fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
					fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
					fwrite($file, $fec_log." # ".PHP_EOL);
					fclose($file);
				}
			}
		}
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>