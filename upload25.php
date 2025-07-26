<?php
$alea = $_GET["alea"];
$fecha = $_GET["fecha"];
$placa = $_GET["placa"];
$output_dir = "upload/contrator/".$placa."/".$fecha."/".$alea."/";
if(isset($_FILES["myfile"]))
{
	$ret = array();
	$error = $_FILES["myfile"]["error"];
	if(!is_array($_FILES["myfile"]["name"]))
	{
 	 	$fileName = $_FILES["myfile"]["name"];
 	 	list($nombre, $extension) = explode(".", $fileName);
 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
    	$ret[] = $fileName;
	}
	else
	{
		$fileCount = count($_FILES["myfile"]["name"]);
	  	for($i=0; $i < $fileCount; $i++)
	  	{
	  		$fileName = $_FILES["myfile"]["name"][$i];
 	 		list($nombre, $extension) = explode(".", $fileName);
			move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
	  		$ret[] = $fileName;
	  	}
	}
    echo json_encode($ret);
 }
 ?>