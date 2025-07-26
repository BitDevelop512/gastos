<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
$actual = date("Y/m/d H:i:s");
$pregunta = "SELECT usuario FROM cx_usu_web WHERE activo='1'";
$sql = odbc_exec($conexion, $pregunta);
$contador = 0;
while ($i<$row=odbc_fetch_array($sql))
{
    $usuario = $row['usuario'];
    $pregunta1 = "SELECT fec_acti FROM cx_por_act WHERE usu_acti='$usuario' AND est_acti='I'";
    $sql1 = odbc_exec($conexion, $pregunta1);
    $fecha = odbc_result($sql1,1);
    $horaini = $fecha;
    $horafin = $actual;
    $f1 = strtotime($horafin)-strtotime($horaini);
    $f2 = intval($f1/60/60/24);
    $horai = substr($horaini,11,2);
    $mini = substr($horaini,14,2);
    $segi = substr($horaini,17,2);
    $horaf = substr($horafin,11,2);
    $minf = substr($horafin,14,2);
    $segf = substr($horafin,17,2);
    $ini = ((($horai*60)*60)+($mini*60)+$segi);
    $fin = ((($horaf*60)*60)+($minf*60)+$segf);
    $dif = $fin-$ini;
    $difh = floor($dif/3600);
    $difm = floor(($dif-($difh*3600))/60);
    $difs = $dif-($difm*60)-($difh*3600);
    $difh = intval($difh);
    if (($f2 >= 1) or ($difh >= 2))
    {
        $actu = "UPDATE cx_usu_web SET activo='0' WHERE usuario='$usuario'";
        if (!odbc_exec($conexion, $actu))
        {
            $confirma = "0";
        }
        else
        {
            $confirma = "1";
            $actu1 = "UPDATE cx_por_act SET est_acti='' WHERE usu_acti='$usuario'";
            $sql2 = odbc_exec($conexion, $actu1);
        }
        // Se graba log
        $fec_log = date("d/m/Y H:i:s a");
        $file = fopen("C:\inetpub\wwwroot\Gastos\log_activos.txt", "a");
        fwrite($file, $fec_log." # Usuario Desbloqueado: ".$usuario." # ".$fecha." - ".$actual." # ".$confirma." # ".PHP_EOL);
        fclose($file);
    }
    else
    {
        $contador ++;
    }
    $i++;
}
if ($contador > 0)
{
    // Se graba log
    $fec_log = date("d/m/Y H:i:s a");
    $file = fopen("C:\inetpub\wwwroot\Gastos\log_activos.txt", "a");
    fwrite($file, $fec_log." # Sin Usuarios para Desbloqueo ".$contador." - ".$fecha." # ".PHP_EOL);
    fclose($file);
}
?>