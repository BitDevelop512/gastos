<!doctype html>
<?php
session_start();
error_reporting(0);
if ($_SESSION["autenticado"] != "SI")
{
    header("location:resultado.php");
}
else
{
    if ($_SESSION["cam_usuario"] == "1")
    {
        header("location:cambio.php?tipo=$tipo&mensaje=0");
    }
    else
    {
?>
<html lang="es">
    <head>
    </head>
    <frameset rows="*" cols="272,*" frameborder="no" border="0" framespacing="0">
        <frame src="menu.php" name="izquierda">
        <frame src="principal1.php" name="derecha" scrolling="yes">
    </frameset>
    <noframes>
        <body>
        </body>
    </noframes>
</html>
<?php
    }
}
?>