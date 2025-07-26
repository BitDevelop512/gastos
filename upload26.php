<?php
$periodo = $_GET["periodo"];
$ano = $_GET["ano"];
$concepto = trim($_GET["concepto"]);
$concepto1 = trim($_GET["concepto1"]);
$unidad = trim($_GET["unidad"]);
$conse = $_GET["conse"];
if (($concepto1 == "9") or ($concepto1 == "10"))
{
	$output_dir = "upload/informe/".$ano."/".$periodo."/".$concepto."/".$unidad."/".$conse."/";
}
else
{
	$output_dir = "upload/informe/".$ano."/".$periodo."/".$concepto."/".$unidad."/";
}
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