<?php
$alea = $_GET["alea"];
$output_dir = "upload/recompensas/".$alea."/expediente/";
if(isset($_FILES["myfile"]))
{
	$ret = array();
	$error = $_FILES["myfile"]["error"];
	$uploadfile = basename($_FILES['myfile']['name']);
	if(!is_array($_FILES["myfile"]["name"]))
	{
 	 	$fileName = $_FILES["myfile"]["name"];
 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
    	$ret[] = $fileName;
	}
	else
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName = $_FILES["myfile"]["name"][$i];
		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
	  	$ret[] = $fileName;
	  }
	}
    echo json_encode($ret);
}
?>