<?php
session_start();
ini_set("display_errors", 1);
date_default_timezone_set("America/Bogota");
require "PHPMailer/PHPMailerAutoload.php";
$email = "jaime.morales@cxcomputers.com";
$email1 = "cmartinezca@imi.mil.co";

$encabezado = "Notificaciones SIGAR";
$mensaje = "Prueba envio de correos SIGAR";
$mensaje = iconv("UTF-8", "ISO-8859-1", $mensaje);

$fecha = date("d/m/Y H:i:s a");
$fecha1 = date("d/m/Y");
$hora = date("H:i");
$registro = date('Y/m/d');
$actual = date('Y');

$salida = new stdClass();

$verde = 'style="background-color: #00c389; border: solid 1px #00c389; padding: 15px 0px 15px 15px;"';
$naranja = 'style="background-color: #ff6600; border: solid 1px #ff6600; padding: 15px 0px 15px 15px;"';
$azul = 'style="background-color: #6633ff; border: solid 1px #6633ff; padding: 15px 0px 15px 15px;"';
$rojo = 'style="background-color: #ff0033; border: solid 1px #ff0033; padding: 15px 0px 15px 15px;"';
$titulo = "Notificaci&oacute;n SIGAR";

$estilo = $naranja;
$ip = "https://sigar.imi.mil.co/";
$link = "<a href='".$ip."'>SIGAR</a>";

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
          <br><br><br>
          <p>
            '.$mensaje.'
          </p>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding: 20px;">
        <div>
          <p>
            Fecha de Envio: <font color="#215a9d">'.$fecha1.'
          </p>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding: 20px;">
        <div>
          <p>
            Hora de Envio: <font color="#215a9d">'.$hora.'</font>
          </p>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding: 15px 15px 25px 20px ;">
        <div>
          <p>
            Link: <font color="#215a9d">'.$link.'</font>
          </p>
        </div>
        <br><br><br>
      </td>
    </tr>
  </table>
  <table align="center" style="background:#fb0206; border: solid 1px red; text-align: center; width:630px; padding: 2px;">
    <tr>
      <td>
        <p style="font-size:12px; color:#ffffff;">
          CX &copy; Copyright '.$actual.'
        </p>
      </td>
    </tr>
  </table>
</body>
</html>
  ';

  function smtpmailer($to, $from, $from_name, $subject, $body, $copia)
  {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = "ssl"; 
    $mail->Host = "mail.imi.mil.co";
    $mail->Port = 25;
    $mail->Username = "sigar@imi.mil.co";
    $mail->Password = "Enero20232023*+";
    $mail->IsHTML(true);
    $mail->From = "sigar@imi.mil.co";
    $mail->FromName = "Sigar";
    $mail->Sender = "sigar@imi.mil.co";
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to);
    $mail->AddAddress($copia);
    $mail->AddAddress("jaime.morales@cxcomputers.com");
    if (!$mail->Send())
    {
      $error = "Error durante el envio del e-mail";
      return $error; 
    }
    else 
    {
      $error = "E-mail enviado correctamente.";  
      return $error;
    }
  }
//$respuesta = smtpmailer($email, 'sigar@imi.mil.co', 'Sigar', $encabezado, $cuerpo, $email1);
//$headers = "MIME-Version: 1.0\r\n";
//$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
//$headers .= "From: SIGAR <sigar@imi.mil.co>\r\n"; 
//$headers .= "Cc: ".$email1."\r\n";
//$headers .= "Bcc: jaime.morales@cxcomputers.com\r\n";
//$respuesta = mail($email,"SIGAR", $cuerpo, $headers);
// Se graba log
$fec_log = date("d/m/Y H:i:s a");
$file = fopen("log_correos.txt", "a");
fwrite($file, $fec_log." # ".$email." # ".$email1." # ".PHP_EOL);
//$salida->mensaje = $respuesta;

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
$headers .= "From: SIGAR <sigar@imi.mil.co>\r\n"; 
$headers .= "Cc: ".$email."\r\n";
$headers .= "Bcc: jaime.morales@cxcomputers.com\r\n";
mail("sigar@imi.mil.co","Formulario Web de Contacto",$cuerpo,$headers);

//echo json_encode($salida);
?>