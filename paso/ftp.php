<?php



$file = "log_sql.txt";
$remote_file = "log_sql1.txt";

// establecer una conexión básica
$ftp_server = "192.168.1.114";
$conn_id = ftp_connect($ftp_server);

// iniciar sesión con nombre de usuario y contraseña
$ftp_user_name = "ftpuser";
$ftp_user_pass = "Cx12345";

$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// cargar un archivo
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII))
{
	echo "Se ha cargado $file con éxito\n";
}
else
{
	echo "Hubo un problema durante la transferencia de $file\n";
}

// cerrar la conexión ftp
ftp_close($conn_id);
?>