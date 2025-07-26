<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
require('funciones.php');
if (is_ajax())
{
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$tipo = $_POST['tipo'];
	// Se consulta tipo de admin del usuario
	$pregunta = "SELECT admin, tipo FROM cx_usu_web WHERE usuario='$usuario' AND unidad='$unidad'";
	$sql = odbc_exec($conexion, $pregunta);
	$admin = odbc_result($sql,1);
	$tipo1 = odbc_result($sql,2);
	// Se consulta datos de la unidad
	$pregunta1 = "SELECT unidad, dependencia, tipo FROM cx_org_sub WHERE subdependencia='$unidad'";
	$sql1 = odbc_exec($conexion, $pregunta1);
	$division = odbc_result($sql1,1);
	$brigada = odbc_result($sql1,2);
	$batallon = odbc_result($sql1,3);
  if ($tipo == "1")
  {
  	switch ($division)
  	{
  		case '1':
  		case '2':
  		case '3':
        switch ($admin)
        {
  				case '1':
  					$admin1 = "2";
  					break;
  				case '2':
  					$admin1 = "3";
  					break;
  				default:
  					break;
  			}
  			$pregunta2 = "SELECT usuario, unidad FROM cx_usu_web WHERE unidad='$unidad' AND tipo='$tipo1' AND admin='$admin1'";
  			break;
  		default:
        switch ($admin)
        {
          case '1':
            $admin1 = "3";
            break;
          case '3':
            $admin1 = "4";
            break;
          default:
            break;
        }
        $pregunta2 = "SELECT usuario, unidad FROM cx_usu_web WHERE unidad='$unidad' AND admin='$admin1'";
  			break;
  	}
  }
  // Si se envia desde PQR
  if ($tipo == "3")
  {
    switch ($division)
    {
      case '1':
      case '2':
      case '3':
        switch ($admin)
        {
          case '1':
          case '2':
            $pregunta2 = "SELECT TOP 1 usuario, unidad FROM cx_usu_web WHERE unidad='$unidad' AND admin='4' ORDER BY admin";
            $sql2 = odbc_exec($conexion, $pregunta2);
            $t_sql2 = odbc_num_rows($sql2);
            if ($t_sql2 == "0")
            {
              $pregunta2 = "SELECT TOP 1 usuario, unidad FROM cx_usu_web WHERE unidad='$unidad' AND admin='2' ORDER BY admin";
            }
            break;
          case '3':
          case '4':
            $pregunta2 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$brigada' AND unidad='$division' AND unic='1'";
            $sql2 = odbc_exec($conexion, $pregunta2);
            $subdependencia = odbc_result($sql2,1);
            $pregunta2 = "SELECT TOP 1 usuario, unidad FROM cx_usu_web WHERE unidad='$subdependencia' AND admin='9'";
            break;
          case '6':
          case '7':
          case '8':
          case '9':
          case '10':
          case '11':
          case '12':
          case '13':
          case '14':
          case '20':
          case '27':
          case '29':
          case '30':
          case '31':
            $pregunta2 = "SELECT TOP 1 usuario, unidad FROM cx_usu_web WHERE super='1' AND usuario NOT LIKE 'CX-%' ORDER BY fecha DESC";
            break;
          default:
            $pregunta2 = "SELECT TOP 1 usuario, unidad FROM cx_usu_web WHERE super='1' AND usuario NOT LIKE 'CX-%' ORDER BY fecha DESC";
            break;
        }
        break;
      default:
        if ($admin <= 4)
        {
          $pregunta2 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$brigada' AND unic='2'";
          $sql2 = odbc_exec($conexion, $pregunta2);
          $t_sql2 = odbc_num_rows($sql2);
          if ($t_sql2 == "0")
          {
            $pregunta2 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$brigada' AND unic='1'";
            $sql2 = odbc_exec($conexion, $pregunta2);
          }
          $subdependencia = odbc_result($sql2,1);
          $pregunta2 = "SELECT TOP 1 usuario, unidad FROM cx_usu_web WHERE unidad='$subdependencia' AND admin='13'";
          $sql2 = odbc_exec($conexion, $pregunta2);
          $t_sql2 = odbc_num_rows($sql2);
          if ($t_sql2 == "0")
          {
            $pregunta2 = "SELECT TOP 1 usuario, unidad FROM cx_usu_web WHERE unidad='$subdependencia' AND admin='9'";
          }
        }
        else
        {
          if (($admin >= 6) and ($admin < 10))
          {
            $pregunta2 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$division' and unic='1'";
            $sql2 = odbc_exec($conexion, $pregunta2);
            $subdependencia = odbc_result($sql2,1);
            $pregunta2 = "SELECT TOP 1 usuario, unidad FROM cx_usu_web WHERE unidad='$subdependencia' AND admin='13'";
          }
          else
          {
            $pregunta2 = "SELECT TOP 1 usuario, unidad FROM cx_usu_web WHERE super='1' AND usuario NOT LIKE 'CX-%' ORDER BY fecha DESC";
          }
        }
        break;
    }
  }
  $sql2 = odbc_exec($conexion, $pregunta2);
  $envia = trim(odbc_result($sql2,1));
  $envia1 = odbc_result($sql2,2);
  if ($envia == trim($usu_usuario))
  {
    $pregunta2 = "SELECT TOP 1 usuario, unidad FROM cx_usu_web WHERE super='1' AND usuario NOT LIKE 'CX-%' ORDER BY fecha DESC";
    $sql2 = odbc_exec($conexion, $pregunta2);
    $envia = trim(odbc_result($sql2,1));
    $envia1 = odbc_result($sql2,2);

  }
  // Se envia el usuario y la unidad
  $salida = new stdClass();
  $salida->envia = $envia;
  $salida->envia1 = $envia1;
	echo json_encode($salida);
}
// 18/08/2023 - Consulta para traer el siguiente usuario
// 22/08/2023 - Ajustes a consulta de usuario a enviar
// 05/12/2023 - Ajuste usuario - admin 20 y 29
// 06/12/2023 - Ajuste para que enviar a usuario viaje entre CDO
// 24/01/2024 - Ajuste consulta usuario a enviar pqr por unic = 1
// 04/09/2024 - Ajuste para unidades CI3ME que no hay admin = 4
// 05/09/2024 - Ajuste si el envio es para el mismo usuario
?>