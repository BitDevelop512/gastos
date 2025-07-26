<!doctype html>
<?php
session_start();
error_reporting(0);
ini_set("precision", "20");
$_SESSION["chat"] = "NO";
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('conf.php');
  include('funciones.php');
  include('permisos.php');
  $ano = date('Y');
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
</head>
<body>
<?php
include('titulo.php');
?>
<div>
  <div id="soportes">
    <h3>Importar Mantenimientos Excel</h3>
    <div>
      <div id="load">
        <center>
          <img src="imagenes/cargando1.gif" alt="Cargando..." />
        </center>
      </div>
      <form name="formulario" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" runat="server">
        <table align="center" width="50%" border="0">
          <tr>
            <td width="30%">
              <div id="lbl_archivo">
                <b>Archivo Adjunto</b>
              </div>
            </td>
            <td colspan="2">
              <input type="file" name="archivo" id="archivo">
            </td>
          </tr>
          <tr>
            <td width="30%">
              &nbsp;
            </td>
            <td width="40%">
              &nbsp;
            </td>
            <td width="30%">
              &nbsp;
            </td>
          </tr>
          <tr>
            <td width="30%">
              <div id="lbl_archivo1">
                <b>Tipo de Mantenimiento</b>
              </div>
            </td>
            <td width="40%">
              <select name="tipo" id="tipo" class="form-control select2">
                <option value="1">AUTOM&Oacute;VILES</option>
                <option value="2">MOTOCICLETAS</option>
              </select>
            </td>
            <td width="30%">
              &nbsp;
            </td>
          </tr>
          <tr>
            <td colspan="3">
              <center>
                <br>
                <input type="submit" name="cargar" id="cargar" value="Validar y Cargar">
              </center>
            </td>
          </tr>
        </table>
<?php
if(isset($_POST['cargar']))
{
  $verifica = time();
  $codigo = strtoupper(md5($verifica));
  $codigo = substr($codigo,0,5);
  $archivo = $_FILES['archivo']['name'];
  list($nombre, $extension) = explode(".", $archivo);
  $archivo1 = $nombre.$codigo.".".$extension;
  if (move_uploaded_file($_FILES['archivo']['tmp_name'],"excel/" . $archivo1))
  {
    require_once dirname(__FILE__) . '/clases/PHPExcel.php';
    $tmpfname = "excel/".$archivo1;
    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
    $excelObj = $excelReader->load($tmpfname);
    $worksheet = $excelObj->getSheet(0);
    $lastRow = $worksheet->getHighestRow();
    echo "<br><center><font face='Verdana' size='2'><b>Archivo Cargado: </b>".$archivo."<br><br><b>Registros: </b>".$lastRow."</b></center><br>";
    echo "<table align='center' width='95%' border='1'>";
    for ($row = 1; $row <= $lastRow; $row++)
    {
      if ($row == "1")
      {
      }
      else
      {
        echo "<tr>";
        echo "<td width='10%'><font face='Verdana' size='2'>";
        $a = trim($worksheet->getCell('B'.$row)->getValue());                                 // Marca Vehiculo
        $a = iconv("UTF-8", "ISO-8859-1", $a);
        echo utf8_encode($a)."</font></td>";

        echo "<td width='10%'><font face='Verdana' size='2'>";
        $b = trim($worksheet->getCell('C'.$row)->getValue());                                 // Linea Vehiculo
        $b = iconv("UTF-8", "ISO-8859-1", $b);
        echo utf8_encode($b)."</font></td>";

        echo "<td width='10%'><font face='Verdana' size='2'>";
        $c = trim($worksheet->getCell('D'.$row)->getValue());                                 // Modelo Vehiculo
        $c = iconv("UTF-8", "ISO-8859-1", $c);
        echo utf8_encode($c)."</font></td>";

        echo "<td width='30%'><font face='Verdana' size='2'>";
        $d = trim($worksheet->getCell('E'.$row)->getValue());                                 // Servicio
        $d = iconv("UTF-8", "ISO-8859-1", $d);
        echo utf8_encode($d)."</font></td>";

        $h = trim($worksheet->getCell('L'.$row)->getValue());                                 // Unidad de Medida
        switch ($h)
        {
          case 'UNIDAD':
            $h1 = "1";
            break;
          case 'JUEGO':
            $h1 = "2";
            break;
          case 'COPAS':
            $h1 = "3";
            break;
          default:
            $h1 = "0";
            break;
        }

        echo "<td width='10%'><font face='Verdana' size='2'>";
        echo $h."</font></td>";

        $tipo = $_POST['tipo'];

        echo "<td width='10%' align='right'><font face='Verdana' size='2'>";
        $e = trim($worksheet->getCell('N'.$row)->getValue());                                 // Valor Unitario
        echo $e."</font></td>";

        echo "<td width='10%' align='right'><font face='Verdana' size='2'>";
        $e = floatval($e);
        $f = $e*(0.19);                                                                       // Iva
        echo number_format($f, 2)."</font></td>";

        echo "<td width='10%' align='right'><font face='Verdana' size='2'>";
        $g = $e+$f;                                                                           // Valor Total
        echo number_format($g, 2)."</font></td>";

        if ($row > 1)
        {
          if ($a == "")
          {
          }
          else
          {
            $archivo2 = iconv("UTF-8", "ISO-8859-1", $archivo1);
            $sql1 = odbc_exec($conexion,"SELECT isnull(max(codigo),0)+1 AS conse FROM cx_ctr_man");
            $consecu = odbc_result($sql1,1);
            $graba = "INSERT INTO cx_ctr_man (codigo, nombre, medida, marca, linea, modelo, valor, iva, total, usuario, tipo, importa) VALUES ('$consecu', '$d', '$h1', '$a', '$b', '$c', '$e', '$f', '$g', '$usu_usuario', '$tipo', '$archivo2')";
            // Se graba log
            if (!odbc_exec($conexion, $graba))
            {
              $fec_log = date("d/m/Y H:i:s a");
              $file = fopen("log_importa_manteni_err.txt", "a");
              fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
              fclose($file);
            }
            else
            {
              $fec_log = date("d/m/Y H:i:s a");
              $file = fopen("log_importa_manteni_ok.txt", "a");
              fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
              fclose($file);
            }
          }
        }
      }
    }
    echo "</table>";  
  }
}
?>
      </form>
      <div id="dialogo"></div>
    </div>
  </div>
</div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 220,
    width: 440,
    modal: true,
    show:
    {
      effect: "blind",
      duration: 1000
    },
    hide:
    {
      effect: "explode",
      duration: 1000
    },
    buttons: [
      {
        text: "Ok",
        click: function() {
          $(this).dialog("close");
        }
      }
    ]
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#cargar").button();
  $("#cargar").click(validar);
  $("#cargar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
});
function validar()
{
  $("#load").show();
  var salida = true, detalle = '';
  var archivo = $("#archivo").val();
  var extension = archivo.split('.');
  var val_ext = extension[1];
  if ($("#archivo").val() == "")
  {
    salida = false;
    detalle += "<center><h3>Debe seleccionar un archivo</h3></center>";
  }
  if (val_ext != "xlsx")
  {
    salida = false;
    detalle += "<center><h3>Archivo No Valido</h3></center>";
  }
  if (salida == false)
  {
    $("#load").hide();
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
  }
  $("#cargar").hide();
  return salida;
}
</script>
</body>
</html>
<?php
}
?>