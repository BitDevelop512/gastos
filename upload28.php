<?php
require('conf.php');
$conse = $_GET["conse"];
$output_dir = "normatividad/";
if(isset($_FILES["myfile"]))
{
	$ret = array();
	$error = $_FILES["myfile"]["error"];
	$fileName = $_FILES["myfile"]["name"];
	$query = "UPDATE cx_ctr_nor SET nombre1='$fileName' WHERE conse='$conse'";
	$sql = odbc_exec($conexion, $query);
	list($nombre, $extension) = explode(".", $fileName);
	move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
	echo json_encode($fileName);
}
?>