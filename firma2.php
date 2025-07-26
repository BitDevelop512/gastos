<!doctype html>
<?php
session_start();
error_reporting(0);
ini_set ("odbc.defaultlrl", "100000");
require('conf.php');



$sql = "select firma as imagen from cx_usu_web where conse='1'";

$cur = odbc_exec($conexion, $sql);

$row = odbc_fetch_array($cur);

//$imagen = odbc_result($cur,1);


//$sql = "SELECT Imagen FROM Acessorios";
//$query = sqlsrv_query($conn, $sql);

//$result->fetchAll(PDO::FETCH_ASSOC);

$imagen = $row['imagen'];

echo $imagen."<br>";


echo "<img src='data:image/jpg;base64,".$imagen."' />";

//echo '<img src="data:image/jpeg;base64,'. $row['imagen'] .'" />';




//$row[1]
//header("Content-type: image/jpeg");
//echo $imagen;

?>

<!--
<img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagen']);?>" />
-->


