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
    <h3>Importar Transportes Excel</h3>
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
            <td width="70%">
              <input type="file" name="archivo" id="archivo">
            </td>
          </tr>
          <tr>
            <td colspan="2">
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
        $a = trim($worksheet->getCell('D'.$row)->getValue());                                 // Unidad
        $b = trim($worksheet->getCell('E'.$row)->getValue());                                 // Compañia
        $b = iconv("UTF-8", "ISO-8859-1", $b);
        $c = trim($worksheet->getCell('F'.$row)->getValue());                                 // Placa
        $c = iconv("UTF-8", "ISO-8859-1", $c);
        echo $b."</font></td>";

        echo "<td width='10%'><font face='Verdana' size='2'>";
        echo $c."</font></td>";

        echo "<td width='15%'><font face='Verdana' size='2'>";
        $d = trim($worksheet->getCell('G'.$row)->getValue());                                 // Aseguradora
        $d = iconv("UTF-8", "ISO-8859-1", $d);
        echo utf8_encode($d);
        echo "</font></td>";

        $e = trim($worksheet->getCell('H'.$row)->getValue());                                 // Fecha vencimiento seguro
        if ($e == "")
        {
        }
        else
        {
          $e = trim($worksheet->getCell('H'.$row)->getValue()+1);
          $e = date($format = "Y/m/d", PHPExcel_Shared_Date::ExcelToPHP($e));
          $e = str_replace("/", "", $e);
          $e = str_replace("-", "", $e);
        }
        $f = trim($worksheet->getCell('I'.$row)->getValue());                                 // Seguro todo riesgo
        if ($f == "NO ACTIVA")
        {
          $f = "0";
        }
        if ($f == "ACTIVA")
        {
          $f = "1";
        }
        if ($f == "VENCIDA")
        {
          $f = "2";
        }
        $g = trim($worksheet->getCell('J'.$row)->getValue());                                 // Aseguradora soat
        $g = iconv("UTF-8", "ISO-8859-1", $g);
        $h = trim($worksheet->getCell('K'.$row)->getValue());                                 // Numero soat
        $h = iconv("UTF-8", "ISO-8859-1", $h);
        $i = trim($worksheet->getCell('L'.$row)->getValue());                                 // Fecha vencimiento soat
        if ($i == "")
        {
        }
        else
        {
          $i = trim($worksheet->getCell('L'.$row)->getValue()+1);
          $i = date($format = "Y/m/d", PHPExcel_Shared_Date::ExcelToPHP($i));
          $i = str_replace("/", "", $i);
          $i = str_replace("-", "", $i);
        }
        $j = trim($worksheet->getCell('M'.$row)->getValue());                                 // Fecha vencimiento rtm
        if ($j == "")
        {
        }
        else
        {
          $j = trim($worksheet->getCell('M'.$row)->getValue()+1);
          $j = date($format = "Y/m/d", PHPExcel_Shared_Date::ExcelToPHP($j));
          $j = str_replace("/", "", $j);
          $j = str_replace("-", "", $j);
        }
        $k = trim($worksheet->getCell('N'.$row)->getValue());                                 // Fecha mantenimiento
        if ($k == "")
        {
        }
        else
        {
          $k = trim($worksheet->getCell('N'.$row)->getValue()+1);
          $k = date($format = "Y/m/d", PHPExcel_Shared_Date::ExcelToPHP($k));
          $k = str_replace("/", "", $k);
          $k = str_replace("-", "", $k);
        }
        $l = trim($worksheet->getCell('O'.$row)->getValue());                                 // Tipo mantenimiento
        $l = iconv("UTF-8", "ISO-8859-1", $l);
        $m = trim($worksheet->getCell('P'.$row)->getValue());                                 // Descripcion mantenimiento
        $m = iconv("UTF-8", "ISO-8859-1", $m);
        $n = trim($worksheet->getCell('Q'.$row)->getValue());                                 // Clase vehiculo
        switch ($n)
        {
          case 'MOTOCICLETA':
            $n1 = "1";
            break;
          case 'AUTOMOVIL':
          case 'AUTOMÓVIL':
            $n1 = "2";
            break;
          case 'CAMIONETA':
            $n1 = "3";
            break;
          case 'VANS':
            $n1 = "4";
            break;
          case 'CAMPERO':
            $n1 = "5";
            break;
          case 'MICROBUS':
            $n1 = "6";
            break;
          case 'CAMION':
          case 'CAMIÓN':
            $n1 = "7";
            break;
          default:
            $n1 = "0";
            break;
        }

        echo "<td width='20%'><font face='Verdana' size='2'>";
        echo $n."</font></td>";

        $o = trim($worksheet->getCell('R'.$row)->getValue());                                 // Marca
        $o = iconv("UTF-8", "ISO-8859-1", $o);

        echo "<td width='20%'><font face='Verdana' size='2'>";
        echo $o."</font></td>";

        $p = trim($worksheet->getCell('S'.$row)->getValue());                                 // Linea
        $p = iconv("UTF-8", "ISO-8859-1", $p);

        echo "<td width='15%'><font face='Verdana' size='2'>";
        echo $p."</font></td>";

        $q = trim($worksheet->getCell('T'.$row)->getValue());                                 // Modelo
        $q = iconv("UTF-8", "ISO-8859-1", $q);

        echo "<td width='10%'><font face='Verdana' size='2'>";
        echo $q."</font></td>";
        echo "</tr>";

        $r = trim($worksheet->getCell('U'.$row)->getValue());                                 // Cilindraje
        $r = iconv("UTF-8", "ISO-8859-1", $r);
        $s = trim($worksheet->getCell('V'.$row)->getValue());                                 // Activo fijo
        $s = iconv("UTF-8", "ISO-8859-1", $s);
        $t = trim($worksheet->getCell('W'.$row)->getValue());                                 // Centro costo
        $t = iconv("UTF-8", "ISO-8859-1", $t);

        $u = trim($worksheet->getCell('X'.$row)->getValue());                                 // Tipo combustible
        switch ($u)
        {
          case 'GASOLINA':
            $u1 = "1";
            break;
          case 'ACPM':
            $u1 = "2";
            break;
          default:
            $u1 = "0";
            break;
        }

        $v = trim($worksheet->getCell('Y'.$row)->getValue());                                 // Color 
        $v = iconv("UTF-8", "ISO-8859-1", $v);
        $w = trim($worksheet->getCell('Z'.$row)->getValue());                                 // Motor
        $w = iconv("UTF-8", "ISO-8859-1", $w);
        $x = trim($worksheet->getCell('AA'.$row)->getValue());                                // Chasis
        $x = iconv("UTF-8", "ISO-8859-1", $x);
        $y = trim($worksheet->getCell('AB'.$row)->getValue());                                // Matricula
        $y = iconv("UTF-8", "ISO-8859-1", $y);

        $z = trim($worksheet->getCell('AC'.$row)->getValue());                                // Estado 
        switch ($z)
        {
          case 'SERVICIO':
            $z1 = "1";
            break;
          default:
            $z1 = "0";
            break;
        }

        $aa = trim($worksheet->getCell('AD'.$row)->getValue());                               // Fecha alta
        if ($aa == "")
        {
        }
        else
        {
          $aa = trim($worksheet->getCell('AD'.$row)->getValue()+1);
          $aa = date($format = "Y/m/d", PHPExcel_Shared_Date::ExcelToPHP($aa));
          $aa = str_replace("/", "", $aa);
          $aa = str_replace("-", "", $aa);
        }

        $ab = trim($worksheet->getCell('AE'.$row)->getValue());                                // Origen 
        $ab = iconv("UTF-8", "ISO-8859-1", $ab);
        $ac = trim($worksheet->getCell('AF'.$row)->getValue());                                // Equipo 
        $ac = iconv("UTF-8", "ISO-8859-1", $ac);
        $ad = trim($worksheet->getCell('AG'.$row)->getValue());                                // Consumo 
        $ad = iconv("UTF-8", "ISO-8859-1", $ad);
        $ae = trim($worksheet->getCell('AH'.$row)->getValue());                                // Kilometraje
        $ae = iconv("UTF-8", "ISO-8859-1", $ae);
        $af = trim($worksheet->getCell('AI'.$row)->getValue());                                // Observaciones
        $af = iconv("UTF-8", "ISO-8859-1", $af);

        if ($row > 1)
        {
          if ($a == "")
          {
          }
          else
          {
            $archivo2 = iconv("UTF-8", "ISO-8859-1", $archivo1);
            $sql1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_tra");
            $consecu = odbc_result($sql1,1);
            $graba = "INSERT INTO cx_pla_tra (conse, fecha, usuario, unidad, compania, placa, ase_nom, fec_seg, rie_seg, ase_soa, num_soa, fec_soa, fec_rtm, fec_man, tip_man, des_man, clase, marca, linea, modelo, cilindraje, activo, costo, tipo, color, motor, chasis, matricula, estado, fec_alt, origen, equipo, consumo, kilometro, observaciones, importa) VALUES ('$consecu', getdate(), '$usu_usuario', '$a', '$b', '$c', '$d', '$e', '$f', '$g', '$h', '$i', '$j', '$k', '$l', '$m', '$n1', '$o', '$p', '$q', '$r', '$s', '$t', '$u1', '$v', '$w', '$x', '$y', '$z1', '$aa', '$ab', '$ac', '$ad', '$ae', '$af', '$archivo2')";
            // Se graba log
            if (!odbc_exec($conexion, $graba))
            {
              $fec_log = date("d/m/Y H:i:s a");
              $file = fopen("log_importa_transpor_err.txt", "a");
              fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
              fclose($file);
            }
            else
            {
              $fec_log = date("d/m/Y H:i:s a");
              $file = fopen("log_importa_transpor_ok.txt", "a");
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
          $( this ).dialog( "close" );
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