<!doctype html>
<?php
session_start();
error_reporting(0);
$_SESSION["chat"] = "NO";
include('permisos.php');
?>
<html>
<head>
	<style>
	body
	{
	    background: #f4f7f9;
	}
	</style>
</head>
<body>
<?php
include('titulo.php');
?>
</body>
</html>