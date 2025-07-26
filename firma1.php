<!doctype html>
<?php
session_start();
error_reporting(0);
require('conf.php');
echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';

$postback = (isset($_POST["enviar"])) ? true : false;
if($postback)
{
  error_reporting(E_ALL);




$fileName = $_FILES['foto']['name'];
$tmpName  = $_FILES['foto']['tmp_name'];
$fileSize = $_FILES['foto']['size'];
$fileType = $_FILES['foto']['type'];

$datastring = file_get_contents($tmpName);

//echo $datastring."<hr>";

//echo $datastring."<hr>";

//$data = unpack("H*hex", $datastring);
//$grafica = "0x".$data['hex'];

//$detalle = $fileName."#".$tmpName."#".$fileSize."#".$fileType;

//$handle = @fopen($tmpName, 'rb');
//$content = @fread($handle, $fileSize($tmpName));
//$content = bin2hex($content);

//$path = 'firma.jpg';
//$type = pathinfo($path, PATHINFO_EXTENSION);
//$data = file_get_contents($path);

//$base64 = 'data:image/' . $type . ';base64,' . base64_encode($datastring);

$base64 = base64_encode($datastring);

//$im = file_get_contents($tmpName);
//$imdata = base64_encode($im);
//echo $imdata;
//echo "<hr><hr>";
//echo "<img src='data:image/jpg;base64,".$imdata."' />";


//$gra_fir = "UPDATE cx_usu_web SET firma1='$fileName', firma2='$fileType', firma4=cast($grafica AS varbinary(max)) WHERE conse='1'";
//$gra_fir = "UPDATE cx_usu_web SET firma='$base64', firma1='$fileName', firma2='$fileType' WHERE conse='1'";
$gra_fir = "UPDATE cx_usu_web SET firma='$base64' WHERE conse='731'";
$cur = odbc_exec($conexion,$gra_fir);

    $fec_log = date("d/m/Y H:i:s a");
    $file = fopen("log_firmas.txt", "a");
    fwrite($file, $fec_log." # ".$gra_fir." # ".PHP_EOL);
    fclose($file);



  if (!odbc_exec($conexion,$gra_fir))
  {
    $fec_log = date("d/m/Y H:i:s a");
    $file = fopen("log_firmas.txt", "a");
    fwrite($file, $fec_log." # ".$gra_fir." # ".PHP_EOL);
    fclose($file);
  }

}

//$bus_fir = "SELECT firma3, firma2 FROM cx_usu_web WHERE conse='1'";
//$cur1 = odbc_exec($conexion,$bus_fir);
//$row = odbc_fetch_array($cur1);

//$grafica1 = odbc_result($cur1,1);

//header("Content-type: image/jpeg");
//echo $grafica1;





?>
<HTML>
<HEAD>

</HEAD>
<BODY BGCOLOR="#E6E9EC">
<CENTER>

<TABLE WIDTH="700" ALIGN="CENTER" BORDER="0">
<TR>
  <TD>
  <FONT FACE="Verdana" SIZE="2" COLOR=#000000>
    <FORM NAME="frmimage" ID="frmimage" METHOD="post" ENCTYPE="multipart/form-data" ACTION="<?php echo $_SERVER['PHP_SELF'];?>">
      Imagen: <INPUT TYPE="file" id="foto" name="foto" SIZE="40" NAME="foto" />
      <br><br>
      <INPUT TYPE="submit" NAME="enviar" ID="enviar" VALUE="Adjuntar"/>
    </FORM>
    </CENTER>
  </TD>
</TR>
</TABLE>
</FONT>
</BODY>
</HTML>