<!doctype html>
<?php
session_start();
error_reporting(0);
ini_set("precision", "15");
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
    <h3>Importar Bines Excel</h3>
    <div>
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
  echo '<script>$("#cargar").hide();$("#archivo").hide();$("#lbl_archivo").hide();</script>';
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
        echo "<td width='20%'><font face='Verdana' size='2'>";
        $a = trim($worksheet->getCell('B'.$row)->getValue());
        $b = trim($worksheet->getCell('C'.$row)->getValue());
        $pregunta = "SELECT nombre FROM cx_ctr_bie WHERE codigo='$b'";
        $sql = odbc_exec($conexion,$pregunta);
        $c = trim(odbc_result($sql,1));
        echo utf8_encode($c)."</font></td>";
        echo "<td width='70%'><font face='Verdana' size='2'>";
        $d = trim($worksheet->getCell('D'.$row)->getValue());
        $d = strtr(trim($d), $sustituye);
        $d = iconv("UTF-8", "ISO-8859-1", $d);                                                // Descripcion
        echo utf8_encode($d);
        echo "</font></td>";
        $e = trim($worksheet->getCell('E'.$row)->getValue());                                 // Unidad
        $f = trim($worksheet->getCell('F'.$row)->getValue());                                 // Marca
        $f = iconv("UTF-8", "ISO-8859-1", $f);
        $g = trim($worksheet->getCell('G'.$row)->getValue());                                 // Color
        $g = iconv("UTF-8", "ISO-8859-1", $g);
        $h = trim($worksheet->getCell('H'.$row)->getValue());                                 // Modelo
        $h = iconv("UTF-8", "ISO-8859-1", $h);
        $i = trim($worksheet->getCell('I'.$row)->getValue());                                 // Serial
        $i = iconv("UTF-8", "ISO-8859-1", $i);
        $j = trim($worksheet->getCell('J'.$row)->getValue());                                 // Valor
        $j = floatval($j);
        $j1 = number_format($j, 2);
        echo "<td width='10%' align='right'><font face='Verdana' size='2'>";
        echo $j1;
        echo "</font></td>";
        echo "</tr>";
        $k = trim($worksheet->getCell('K'.$row)->getValue());                                 // Fecha Compra
        if ($k == "")
        {
        }
        else
        {
          $k = trim($worksheet->getCell('K'.$row)->getValue()+1);
          $k = date($format = "Y/m/d", PHPExcel_Shared_Date::ExcelToPHP($k));          
        }
        $l = trim($worksheet->getCell('L'.$row)->getValue());                                 // Num Soat
        $m = trim($worksheet->getCell('M'.$row)->getValue());                                 // Aseguradora
        $n = trim($worksheet->getCell('N'.$row)->getValue());                                 // Fecha Inicial Soat
        if (($n == "N/A") or ($n == "OMITIDO") or ($n == "NO APLICA"))
        {
        }
        else
        {
          $n = trim($worksheet->getCell('N'.$row)->getValue()+1);
          $n = date($format = "Y/m/d", PHPExcel_Shared_Date::ExcelToPHP($n));
        }
        $o = trim($worksheet->getCell('O'.$row)->getValue());                                 // Fecha Final Soat
        if (($o == "N/A") or ($o == "OMITIDO") or ($o == "NO APLICA"))
        {
        }
        else
        {
          $o = trim($worksheet->getCell('O'.$row)->getValue()+1);
          $o = date($format = "Y/m/d", PHPExcel_Shared_Date::ExcelToPHP($o));
        }
        $p = trim($worksheet->getCell('P'.$row)->getValue());                                 // Clase Seguro
        $p = iconv("UTF-8", "ISO-8859-1", $p);
        $q = trim($worksheet->getCell('Q'.$row)->getValue());                                 // Valor Seguro
        if (($q == "N/A") or ($q == "OMITIDO") or ($q == "NO APLICA"))
        {
          $q = "0.00";
        }
        $r = trim($worksheet->getCell('R'.$row)->getValue());                                 // Numero Seguro
        $s = trim($worksheet->getCell('S'.$row)->getValue());                                 // Aseguradora
        $t = trim($worksheet->getCell('T'.$row)->getValue());                                 // Fecha Inicial Seguro
        if (($t == "N/A") or ($t == "OMITIDO") or ($t == "NO APLICA"))
        {
        }
        else
        {
          $t = trim($worksheet->getCell('T'.$row)->getValue()+1);
          $t = date($format = "Y/m/d", PHPExcel_Shared_Date::ExcelToPHP($t));
        }
        $u = trim($worksheet->getCell('U'.$row)->getValue());                                 // Fecha Final Seguro
        if (($u == "N/A") or ($u == "OMITIDO") or ($u == "NO APLICA"))
        {
        }
        else
        {
          $u = trim($worksheet->getCell('U'.$row)->getValue()+1);
          $u = date($format = "Y/m/d", PHPExcel_Shared_Date::ExcelToPHP($u));
        }
        $v = trim($worksheet->getCell('V'.$row)->getValue());                                 // Funcionario
        $v = iconv("UTF-8", "ISO-8859-1", $v);
        $w = trim($worksheet->getCell('W'.$row)->getValue());                                 // Ordop
        $w = iconv("UTF-8", "ISO-8859-1", $w);
        $x = trim($worksheet->getCell('X'.$row)->getValue());                                 // Mision
        $x = iconv("UTF-8", "ISO-8859-1", $x);
        $y = trim($worksheet->getCell('Y'.$row)->getValue());                                 // Ordop
        $y = iconv("UTF-8", "ISO-8859-1", $y);
        $z = trim($worksheet->getCell('Z'.$row)->getValue());                                 // Mision
        $z = iconv("UTF-8", "ISO-8859-1", $z);
        $aa = trim($worksheet->getCell('AA'.$row)->getValue());                               // Plan
        $ab = trim($worksheet->getCell('AB'.$row)->getValue());                               // Relacion
        $ac = trim($worksheet->getCell('AC'.$row)->getValue());                               // Compañia
        $ac = iconv("UTF-8", "ISO-8859-1", $ac);
        $ad = trim($worksheet->getCell('AD'.$row)->getValue());                               // Estado
        $ae = trim($worksheet->getCell('AE'.$row)->getValue());                               // Egreso
        // Movimientos
        $af = trim($worksheet->getCell('AF'.$row)->getValue());                               // Responsable
        $af = iconv("UTF-8", "ISO-8859-1", $af);
        $ag = trim($worksheet->getCell('AG'.$row)->getValue());                               // Documento
        $ag = iconv("UTF-8", "ISO-8859-1", $ag);
        $ah = trim($worksheet->getCell('AH'.$row)->getValue()+1);                             // Fecha
        $ah = date($format = "Y/m/d", PHPExcel_Shared_Date::ExcelToPHP($ah));
        $nom_usuario = iconv("UTF-8", "ISO-8859-1", $nom_usuario);
        if ($row > 1)
        {
          if ($a == "")
          {
          }
          else
          {
            $sql1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_bie");
            $consecu = odbc_result($sql1,1);
            $codigo = str_pad($consecu,7,"0",STR_PAD_LEFT);
            $codigo = "A-GR-CA".$codigo;
            $graba = "INSERT INTO cx_pla_bie (conse, fecha, usuario, codigo, clase, nombre, descripcion, fec_com, valor, valor1, marca, color, modelo, serial, soa_num, soa_ase, soa_fe1, soa_fe2, seg_cla, seg_val, seg_num, seg_ase, seg_fe1, seg_fe2, unidad, funcionario, ordop, mision, numero, relacion, compania, estado, egreso, ordop1, mision1, responsable, unidad_a, responsable1, importa) VALUES ('$consecu', getdate(), '$usu_usuario', '$codigo', '$a', '$c', '$d', '$k', '$j1', '$j', '$f', '$g', '$h', '$i', '$l', '$m', '$n', '$o', '$p', '$q', '$r', '$s', '$t', '$u', '$e', '$v', '$w', '$x', '$aa', '$ab', '$ac', '$ad', '$ae', '$y', '$z', '0', '0', '0', '$archivo1')";
            // Se graba log
            if (!odbc_exec($conexion, $graba))
            {
              $fec_log = date("d/m/Y H:i:s a");
              $file = fopen("log_importa_bienes_err.txt", "a");
              fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
              fclose($file);
            }
            else
            {
              $fec_log = date("d/m/Y H:i:s a");
              $file = fopen("log_importa_bienes_ok.txt", "a");
              fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
              fclose($file);
              // Se graba movimiento de asiganación
              $sql2 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_bie_mov WHERE tipo='1' AND ano='$ano'");
              $consecu1 = odbc_result($sql2,1);
              $graba1 = "INSERT INTO cx_bie_mov (conse, tipo, tipo1, codigos, responsable, documento, fechad, ano, usuario, unidad, elaboro) VALUES ('$consecu1', '1', '0', '$codigo', '$af', '$ag', '$ah', '$ano', '$usu_usuario', '$e', '$nom_usuario')";
              $sql3 = odbc_exec($conexion, $graba1);
              // Log
              $fec_log = date("d/m/Y H:i:s a");
              $file = fopen("log_movi_bienes.txt", "a");
              fwrite($file, $fec_log." # ".$graba1." # ".PHP_EOL);
              fclose($file);
              // Actualiza
              $graba2 = "UPDATE cx_pla_bie SET responsable='$consecu1' WHERE codigo='$codigo' AND responsable='0' AND responsable1='0'";
              $sql4 = odbc_exec($conexion, $graba2);
              // Log
              $fec_log = date("d/m/Y H:i:s a");
              $file = fopen("log_movi_bienes1.txt", "a");
              fwrite($file, $fec_log." # ".$graba2." # ".PHP_EOL);
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
    </div>
  </div>
</div>
<div id="dialogo"></div>
<div id="dialogo1"></div>
<div id="load">
  <center>
    <img src="imagenes/cargando1.gif" alt="Cargando..." />
  </center>
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
  $("#dialogo1").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 150,
    width: 300,
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
    buttons: {
      "Aceptar": function() {
        $( this ).dialog( "close" );
        graba();
      },
      Cancelar: function() {
        $( this ).dialog( "close" );
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 300,
    width: 720,
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
    buttons: {
      "Aceptar": function() {
        aprueba();
      },
      Cancelar: function() {
        $( this ).dialog( "close" );
      }
    }
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