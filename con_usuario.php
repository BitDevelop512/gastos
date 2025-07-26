<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
$conex = $_POST['conexion'];
$usuario = trim($_POST['usuario']);
$clave = trim($_POST['clave']);
$password = md5($clave);
$salida = new stdClass();
// Si no es peticion ajax no se ejecuta
if (is_ajax())
{
  // Si la conexion es LDAP 
  if ($conex == "1")
  {
  }
  // Si la conexion es Base de Datos
  else
  {
    $ip = trim($_SERVER["REMOTE_ADDR"]);
    $agente = trim($_SERVER["HTTP_USER_AGENT"]);
    $navegador = getBrowser($agente);
    $query = "SELECT * FROM cx_usu_web WHERE usuario='$usuario'";
    $sql = odbc_exec($conexion,$query);
    $total = odbc_num_rows($sql);
    // Si el usuario existe en la base de datos
    if ($total>0)
    {
      $con_usuario = odbc_result($sql,1);
      $usu_usuario = trim(odbc_result($sql,3));
      $nom_usuario = trim(utf8_encode(odbc_result($sql,4)));
      $cla_usuario = odbc_result($sql,5);
      $per_usuario = odbc_result($sql,6);
      $cnx_usuario = odbc_result($sql,7);
      $est_usuario = odbc_result($sql,8);
      $cam_usuario = odbc_result($sql,9);
      $tip_usuario = odbc_result($sql,10);
      $uni_usuario = odbc_result($sql,11);
      $ema_usuario = odbc_result($sql,12);
      $adm_usuario = odbc_result($sql,13);
      $ciu_usuario = trim(utf8_encode(odbc_result($sql,16)));
      $ced_usuario = trim(odbc_result($sql,17));
      $car_usuario = trim(utf8_encode(odbc_result($sql,18)));
      $act_usuario = odbc_result($sql,19);
      $ipe_usuario = trim(odbc_result($sql,21));
      $nav_usuario = trim(odbc_result($sql,22));
      $val_usuario = substr(odbc_result($sql,23),0,10);
      $sup_usuario = odbc_result($sql,24);
      $log_usuario = trim(odbc_result($sql,25));
      // Validación cambio de clave cada 30 dias
      $actual = date('Y-m-d');
      $f1 = strtotime($actual)-strtotime($val_usuario);
      $f2 = intval($f1/60/60/24);
      // Se consulta dias parametrizados cambio de clave
      $query0 = "SELECT dias FROM cx_ctr_par";
      $sql0 = odbc_exec($conexion,$query0);
      $var_0 = odbc_result($sql0,1);
      if ($f2 > $var_0)
      {
        $cam_usuario = "1";
      }
      // Se consultan datos de la unidad asignada al usuario para carga de permisos
      $query1 = "SELECT * FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
      $sql1 = odbc_exec($conexion,$query1);
      $var_1 = odbc_result($sql1,1);
      $var_2 = odbc_result($sql1,2);
      $sig_usuario = trim(odbc_result($sql1,4));
      $bat_usuario = trim(utf8_encode(odbc_result($sql1,6)));
      $tpu_usuario = odbc_result($sql1,7);
      $tpc_usuario = odbc_result($sql1,8);
      // Nueva sigla
      $sig_usuario1 = trim(odbc_result($sql1,41));
      $bat_usuario1 = trim(utf8_encode(odbc_result($sql1,42)));
      $fec_usuario = trim(odbc_result($sql1,43));
      if ($fec_usuario == "")
      {
      }
      else
      {
        $fec_usuario = str_replace("/", "-", $fec_usuario);
        if ($actual >= $fec_usuario)
        {
          $sig_usuario = $sig_usuario1;
          $bat_usuario = $bat_usuario1;
        }
      }
      $nun_usuario = $var_1;
      $dun_usuario = $var_2;
      // Se consulta la brigada
      $query2 = "SELECT nombre FROM cx_org_dep WHERE dependencia='$var_2'";
      $sql2 = odbc_exec($conexion,$query2);
      $bri_usuario = trim(odbc_result($sql2,1));
      // Se consulta la division
      $query3 = "SELECT nombre FROM cx_org_uni WHERE unidad='$var_1'";
      $sql3 = odbc_exec($conexion,$query3);
      $div_usuario = trim(odbc_result($sql3,1));
      // Se consulta la compañia
      $query4 = "SELECT nombre FROM cx_org_cmp WHERE conse='$tip_usuario'";
      $sql4 = odbc_exec($conexion,$query4);
      $cmp_usuario = trim(utf8_encode(odbc_result($sql4,1)));
      if ($tip_usuario == "0")
      {
        $cmp_usuario = "COMPAÑIA NO SELECCIONADA";
      }
      // Si la conexion es base de datos
      if ($cnx_usuario == "2")
      {
        // Si la clave es igual
        if (trim($cla_usuario) == trim($password))
        {
          // Si el estado del usuario es activo en la base
          if ($est_usuario == "1")
          {
            // Si el estado del usuario es logueado o es superusuario
            if (($act_usuario == "0") or ($sup_usuario == "1"))
            {             
              $salida->salida = "1";
              $salida->conse = $con_usuario;
              $salida->usuario = $usu_usuario;
              $salida->nombre = $nom_usuario;
              $salida->clave = $cla_usuario;
              $salida->permisos = $per_usuario;
              $salida->cnx = $cnx_usuario;
              $salida->estado = $est_usuario;
              $salida->cambio = $cam_usuario;
              $salida->tipo = $tip_usuario;
              $salida->unidad = $uni_usuario;
              $salida->email = $ema_usuario;
              $salida->admin = $adm_usuario;
              $salida->sigla = $sig_usuario;
              $salida->ciudad = $ciu_usuario;
              $salida->cedula = $ced_usuario;
              $salida->cargo = $car_usuario;
              $salida->batallon = $bat_usuario;
              $salida->brigada = $bri_usuario;
              $salida->division = $div_usuario;
              $salida->tipou = $tpu_usuario;
              $salida->tipoc = $tpc_usuario;
              $salida->compania = $cmp_usuario;
              $salida->nunidad = $nun_usuario;
              $salida->dunidad = $dun_usuario;
              $salida->super = $sup_usuario;
              $salida->login = $log_usuario;
              // Se registra ingreso al portal
              $query_c = "(SELECT isnull(max(ide_acti),0)+1 FROM cx_por_act)";
              $graba = "INSERT INTO cx_por_act (ide_acti, usu_acti, est_acti, ipe_acti, nav_acti) VALUES ($query_c, '$usu_usuario', 'I', '$ip', '$navegador')";
              odbc_exec($conexion, $graba);
              // Se actualiza actividad del usuario
              $actu = "UPDATE cx_usu_web SET activo='1', ip='$ip', navegador='$navegador' WHERE conse='$con_usuario' AND usuario='$usu_usuario'";
              odbc_exec($conexion, $actu);
            }
            else
            {
              // Si ingresa de la misma ip que registro
              if (($act_usuario == "1") and ($ipe_usuario == $ip) and ($nav_usuario == $navegador))
              {
                $salida->salida = "1";
                $salida->conse = $con_usuario;
                $salida->usuario = $usu_usuario;
                $salida->nombre = $nom_usuario;
                $salida->clave = $cla_usuario;
                $salida->permisos = $per_usuario;
                $salida->cnx = $cnx_usuario;
                $salida->estado = $est_usuario;
                $salida->cambio = $cam_usuario;
                $salida->tipo = $tip_usuario;
                $salida->unidad = $uni_usuario;
                $salida->email = $ema_usuario;
                $salida->admin = $adm_usuario;
                $salida->sigla = $sig_usuario;
                $salida->ciudad = $ciu_usuario;
                $salida->cedula = $ced_usuario;
                $salida->cargo = $car_usuario;
                $salida->batallon = $bat_usuario;
                $salida->brigada = $bri_usuario;
                $salida->division = $div_usuario;
                $salida->tipou = $tpu_usuario;
                $salida->tipoc = $tpc_usuario;
                $salida->compania = $cmp_usuario;
                $salida->nunidad = $nun_usuario;
                $salida->dunidad = $dun_usuario;
                $salida->super = $sup_usuario;
                $salida->login = $log_usuario;
              }
              else
              {
                $salida->salida = "0";
                $salida->conse = "0";
                $salida->usuario = "";
                $salida->nombre = "";
                $salida->clave = "";
                $salida->permisos = "";
                $salida->cnx = "0";
                $salida->estado = "0";
                $salida->cambio = "0";
                $salida->tipo = "0";
                $salida->unidad = "0";
                $salida->email = "";
                $salida->admin = "0";
                $salida->sigla = "";
                $salida->ciudad = "";
                $salida->cedula = "";
                $salida->cargo = "";
                $salida->batallon = "";
                $salida->brigada = "";
                $salida->division = "";
                $salida->tipou = "0";
                $salida->tipoc = "0";
                $salida->compania = "";
                $salida->nunidad = "0";
                $salida->dunidad = "0";
                $salida->super = "0";
                $salida->login = "";
                $salida->mensaje = "Usted ya inicio sesión en otro equipo o en otro navegador";
              }
            }
          }
          else
          {
            $salida->salida = "0";
            $salida->conse = "0";
            $salida->usuario = "";
            $salida->nombre = "";
            $salida->clave = "";
            $salida->permisos = "";
            $salida->cnx = "0";
            $salida->estado = "0";
            $salida->cambio = "0";
            $salida->tipo = "0";
            $salida->unidad = "0";
            $salida->email = "";
            $salida->admin = "0";
            $salida->sigla = "";
            $salida->ciudad = "";
            $salida->cedula = "";
            $salida->cargo = "";
            $salida->batallon = "";
            $salida->brigada = "";
            $salida->division = "";
            $salida->tipou = "0";
            $salida->tipoc = "0";
            $salida->compania = "";
            $salida->nunidad = "0";
            $salida->dunidad = "0";
            $salida->super = "0";
            $salida->login = "";
            $salida->mensaje = "Usuario inactivo o suspendido";
          }
        }
        else
        {
          $salida->salida = "0";
          $salida->conse = "0";
          $salida->usuario = "";
          $salida->nombre = "";
          $salida->clave = "";
          $salida->permisos = "";
          $salida->cnx = "0";
          $salida->estado = "0";
          $salida->cambio = "0";
          $salida->tipo = "0";
          $salida->unidad = "0";
          $salida->email = "";
          $salida->admin = "0";
          $salida->sigla = "";
          $salida->ciudad = "";
          $salida->cedula = "";
          $salida->cargo = "";
          $salida->batallon = "";
          $salida->brigada = "";
          $salida->division = "";
          $salida->tipou = "0";
          $salida->tipoc = "0";
          $salida->compania = "";
          $salida->nunidad = "0";
          $salida->dunidad = "0";
          $salida->super = "0";
          $salida->login = "";
          $salida->mensaje = "Clave no concuerda";
        }
      }
      else
      {
        $salida->salida = "0";
        $salida->conse = "0";
        $salida->usuario = "";
        $salida->nombre = "";
        $salida->clave = "";
        $salida->permisos = "";
        $salida->cnx = "0";
        $salida->estado = "0";
        $salida->cambio = "0";
        $salida->tipo = "0";
        $salida->unidad = "0";
        $salida->email = "";
        $salida->admin = "0";
        $salida->sigla = "";
        $salida->ciudad = "";
        $salida->cedula = "";
        $salida->cargo = "";
        $salida->batallon = "";
        $salida->brigada = "";
        $salida->division = "";
        $salida->tipou = "0";
        $salida->tipoc = "0";
        $salida->compania = "";
        $salida->nunidad = "0";
        $salida->dunidad = "0";
        $salida->super = "0";
        $salida->login = "";
        $salida->mensaje = "Tipo de conexión o valido";        
      }
    }
    else
    {
    	$salida->salida = "0";
      $salida->conse = "0";
      $salida->usuario = "";
      $salida->nombre = "";
      $salida->clave = "";
      $salida->permisos = "";
      $salida->cnx = "0";
      $salida->estado = "0";
      $salida->cambio = "0";
      $salida->tipo = "0";
      $salida->unidad = "0";
      $salida->email = "";
      $salida->admin = "0";
      $salida->sigla = "";
      $salida->ciudad = "";
      $salida->cedula = "";
      $salida->cargo = "";
      $salida->batallon = "";
      $salida->brigada = "";
      $salida->division = "";
      $salida->tipou = "0";
      $salida->tipoc = "0";
      $salida->compania = "";
      $salida->nunidad = "0";
      $salida->dunidad = "0";
      $salida->super = "0";
      $salida->login = "";
      $salida->mensaje = "Usuario no encontrado";
    }
  }
  echo json_encode($salida);
  echo exec($ruta_local."\\cxagente\\cx_borrar.exe C:\\inetpub\\wwwroot\\gastos\\fpdf\\,".$ruta_local."\\cxagente\\cx_borrar,*.tmp");
}
// 04/08/2023 - Ajuste de cambio de sigla validando la fecha actual
// 18/08/2023 - Ajuste grabacion ip y navegador en tabla cx_por_act
// 23/08/2023 - Ajuste en respuesta de mensajes
?>