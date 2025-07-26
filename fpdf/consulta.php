<?php
session_start();
$f = $_GET['f'];
if(substr($f,0,3)!='tmp' or strpos($f,'/') or strpos($f,'\\'))
die('Nombre incorrecto de fichero');
if(!file_exists($f))
    die('El fichero no existe');
if($HTTP_ENV_VARS['USER_AGENT']=='contype')
{
  Header('Content-Type: application/pdf');
  exit;
}
Header('Content-Type: application/pdf');
Header('Content-Length: '.filesize($f));
readfile($f);
unlink($f);
exit;
?>
