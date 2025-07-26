<?php
session_start();
error_reporting(0);
require("conf.php");
require("funciones.php");
require("permisos.php");
date_default_timezone_set("America/Bogota");
if (is_ajax())
{
  require "PHPMailer/PHPMailerAutoload.php";
  $fecha = date('d/m/Y');
  $fecha1 = strtoupper(md5($fecha));
  $fecha1 = substr($fecha1,0,10);
  $fecha2 = date("H:i");
  $fecha3 = encrypt1($fecha2, "cx");
  $tipo = $_POST['tipo'];
  $usuario = trim(strtoupper($_POST['usuario']));
  $email = trim($_POST['email']);
  $copia = trim($_POST['copia']);
  $servidor = trim($_POST['servidor']);
  // Se consultan parametros
  $query = "SELECT usuario, clave, servidor, puerto FROM cx_ctr_par";
  $cur = odbc_exec($conexion,$query);
  $v_usuario = trim(utf8_encode(odbc_result($cur,1)));
  $v_clave = trim(utf8_encode(odbc_result($cur,2)));
  $v_servidor = trim(utf8_encode(odbc_result($cur,3)));
  $v_puerto = odbc_result($cur,4);
  // Se consulta nombre de usuario
  $pregunta = "SELECT conse, nombre FROM cx_usu_web WHERE usuario='$usuario'";
  $sql = odbc_exec($conexion,$pregunta);
  $interno = odbc_result($sql,1);
  $nombre = trim(utf8_encode(odbc_result($sql,2)));
  // Colores de estilos
  $naranja = 'style="background-color: #ff6600; border: solid 1px #ff6600; padding: 15px 0px 15px 15px;"';
  $verde = 'style="background-color: #00c389; border: solid 1px #00c389; padding: 15px 0px 15px 15px;"';
  $azul = 'style="background-color: #6633ff; border: solid 1px #6633ff; padding: 15px 0px 15px 15px;"';
  $rojo = 'style="background-color: #ff0033; border: solid 1px #ff0033; padding: 15px 0px 15px 15px;"';
  $violeta = 'style="background-color: #6666ff; border: solid 1px #6666ff; padding: 15px 0px 15px 15px;"';

  switch ($tipo) {
    case '1':
      $titulo = "Recuperaci&oacute;n Contrase&ntilde;a";
      $mensaje = "Se ha recibido una solicitud para la recuperaci&oacute;n de la contrase&ntilde;a del usuario <b>".$usuario."</b> perteneciente a <b>".$nombre."</b><br><br>A partir de este momento cuenta con sesenta (60) minutos para finalizar el proceso de recuperaci&oacute;n de contrase&ntilde;a, una vez finalizado este tiempo el link sera deshabilitado.";
      $estilo = $naranja;
      break;
    case '2':
      $valor1 = $_POST['valor1'];
      $valor2 = $_POST['valor2'];
      $valor3 = $_POST['valor3'];
      $valor4 = $_POST['valor4'];
      if ($valor1 == "1")
      {
        $titulo1 = "El ";
        $titulo = "Plan de Inversión";
      }
      else
      {
        $titulo1 = "La ";
        $titulo = "Solicitud de Recursos";
      }
      $mensaje = $titulo1.$titulo." <b>".$valor2."</b> de <b>".$valor3."</b> ha sido generado(a) por el usuario <b>".$usuario."</b> se solicita al usuario <b>".$valor4."</b> revisi&oacute;n del mismo.";
      $estilo = $verde;
      break;
    case '3':
      $valor1 = $_POST['valor1'];
      $valor2 = $_POST['valor2'];
      $valor3 = $_POST['valor3'];
      $valor4 = $_POST['valor4'];
      $valor5 = $_POST['valor5'];
      if ($valor1 == "1")
      {
        $titulo1 = "El ";
        $titulo = "Plan de Inversión";
      }
      else
      {
        $titulo1 = "La ";
        $titulo = "Solicitud de Recursos";
      }
      $mensaje = $titulo1.$titulo." <b>".$valor2."</b> de <b>".$valor3."</b> ha sido rechazado(a).<br><br>Observaciones y/o criterios de autoritazión: <b>".$valor5."</b> por el usuario <b>".$usuario;
      $estilo = $rojo;
      break;
    case '4':
      $valor1 = $_POST['valor1'];
      $valor2 = $_POST['valor2'];
      $valor3 = $_POST['valor3'];
      $valor4 = $_POST['valor4'];
      $valor5 = $_POST['valor5'];
      if ($valor1 == "1")
      {
        $titulo1 = "El ";
        $titulo = "Plan de Inversión";
      }
      else
      {
        $titulo1 = "La ";
        $titulo = "Solicitud de Recursos";
      }
      $mensaje = $titulo1.$titulo." <b>".$valor2."</b> de <b>".$valor3."</b> ha sido aprobado(a) por el usuario <b>".$usuario."</b> se solicita al usuario <b>".$valor4."</b> revisi&oacute;n del mismo.";
      $estilo = $azul;
      break;
    case '5':
      $valor1 = $_POST['valor1'];
      $valor1 = strtolower($valor1);
      $valor2 = $_POST['valor2'];
      $valor2 = strtolower($valor2);
      $valor3 = $_POST['valor3'];
      $valor4 = $_POST['valor4'];
      $titulo = "Informe de Giro";
      $mensaje = "Se ha generado el ".$titulo." por concepto de <b>".$valor1."</b> para el mes de <b>".$valor2."</b> de <b>".$valor3."</b> por valor de <b>".$valor4."</b> por el usuario <b>".$usuario."</b>";
      $estilo = $violeta;
      break;
    case '6':
      $valor1 = $_POST['valor1'];
      $valor2 = $_POST['valor2'];
      $titulo = "Cuenta Gastos Reservados";
      $mensaje = "La ".$titulo." del mes de <b>".$valor1."</b> de <b>".$valor2."</b> no ha sido cargada a la fecha.";
      $estilo = $rojo;
      break;
    default:
      break;
  }
  $mensaje = iconv("UTF-8", "ISO-8859-1", $mensaje);
  $encabezado = "Notificaciones SIGAR";

  $fecha_hora = date("Y/m/d H:i:s a");
  $fecha = date('Y/m/d');
  $hora = date("H:i");
  $ano = date('Y');
  $salida = new stdClass();

  $valida1 = strpos($servidor, "sigar.imi.mil.co");
  $valida1 = intval($valida1);
  if ($valida1 == "0")
  {
    $servidor = "http://".$servidor."/Gastos";
  }
  else
  {
    $servidor = "https://".$servidor;
  }

  switch ($tipo) {
    case '1':
      $link = "<a href='".$servidor."/recupera.php?v1=".$interno."&v2=".$usuario."&v3=".$fecha1."&v4=".$fecha3."'>Recuperaci&oacute;n Contrase&ntilde;a</a>";
      break;
    case '2':
    case '3':
    case '4':
    case '5':
    case '6':
      $link = "<a href='".$servidor."/'>Sigar IMI</a>";
      break;
    default:
      break;
  }

  $cuerpo = '
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <style>
      table,
      td,
      div,
      h1,
      p {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
      }
    </style>
  </head>
  <body>
    <table align="center" style="width:630px; border-collapse:collapse;background:#ffffff; ">
      <tr>
        <td style="padding: 5px 0px 5px 15px; background:#535353; border: solid 1px #535353; height: 50px; color: white; font-size: 50px; font-weight: bold;">
          <b>SIGAR IMI</b>
        </td>
      </tr>
      <tr>
        <td style="height: 5px; background-color: #215a9d; border: solid 1px #215a9d;">
        </td>
      </tr>
      <tr>
        <td '.$estilo.'>
          <div>
            <p style="color:white; font-size: 15px;">
              Notificaci&oacute;n
            </p>
            <p style="color:white; font-size: 25px; font-weight: bolder;">'.$titulo.'</p>
          </div>
        </td>
      </tr>
      <tr>
        <td style="color:#153643; padding: 20px 15px 15px 15px;">
          <div>
            <br><br>
            <p>
              <font color="#000000">
                '.$mensaje.'
              </font>
            </p>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding: 20px;">
          <div>
            <p>
              Fecha de Envio: <font color="#0000FF">'.$fecha.'
            </p>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding: 20px;">
          <div>
            <p>
              Hora de Envio: <font color="#0000FF">'.$hora.'</font>
            </p>
          </div>
        </td>
      </tr>
      <tr>
        <td style="padding: 15px 15px 25px 20px ;">
          <div>
            <p>
              Link: <font color="#3333FF">'.$link.'</font>
            </p>
          </div>
          <br><br>
        </td>
      </tr>
    </table>
    <table align="center" style="background:#fb0206; border: solid 1px red; text-align: center; width:630px; padding: 2px;">
      <tr>
        <td>
          <p style="font-size:12px; color:#ffffff;">
            CX &copy; Copyright '.$ano.'
          </p>
        </td>
      </tr>
    </table>
  </body>
  </html>
  ';

  function smtpmailer($to, $from, $from_name, $subject, $body, $copia, $v_usuario, $v_clave, $v_servidor, $v_puerto)
  {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = "ssl"; 
    $mail->Host = $v_servidor;
    $mail->Port = $v_puerto;
    $mail->Username = $v_usuario;
    $mail->Password = "Cx12345*+2022";
    //$v_clave
    $mail->IsHTML(true);
    $mail->From = $v_usuario;
    $mail->FromName = $from_name;
    $mail->Sender = $v_usuario;
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to);
    $mail->AddAddress($copia);
    if (!$mail->Send())
    {
      $error = "0";
      return $error; 
    }
    else 
    {
      $error = "1";  
      return $error;
    }
  }
  $respuesta = smtpmailer($email, $v_usuario, 'Sigar IMI', $encabezado, $cuerpo, $copia, $v_usuario, $v_clave, $v_servidor, $v_puerto);
  // Se graba log
  $fec_log = date("d/m/Y H:i:s a");
  $file = fopen("log_correos.txt", "a");
  fwrite($file, $fec_log." # ".$email." # ".$respuesta." # ".PHP_EOL);
  $salida->salida = $respuesta;
  $salida->nombre = $nombre;
  echo json_encode($salida);
}
?>