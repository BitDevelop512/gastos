<!doctype html>
<?php
session_start();
error_reporting(0);
$_SESSION["chat"] = "SI";
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('conf.php');
  include('funciones.php');
  include('permisos.php');
  $sustituye = array ( 'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ñ' => '&Ntilde;' );
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
    <h3>Importar Usuarios Excel</h3>
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
    require_once dirname(__FILE__) . '/classes/PHPExcel.php';
    $tmpfname = "excel/".$archivo1;
    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
    $excelObj = $excelReader->load($tmpfname);
    $worksheet = $excelObj->getSheet(0);
    $lastRow = $worksheet->getHighestRow();
    $clave = '827ccb0eea8a706c4c34a16891f84e7b';
    echo "<br><center><font face='Verdana' size='2'><b>Archivo Cargado: </b>".$archivo."<br><br><b>Registros: </b>".$lastRow."</b></center><br>";
    echo "<table align='center' width='70%' border='1'>";
    for ($row = 1; $row <= $lastRow; $row++)
    {
      echo "<tr>";
      echo "<td width='35%'><font face='Verdana' size='2'>";
      $a = trim($worksheet->getCell('D'.$row)->getValue());
      echo $a."</font>&nbsp;&nbsp;&nbsp;</td>";
      echo "<td width='65%'><font face='Verdana' size='2'>";
      $b = trim($worksheet->getCell('C'.$row)->getValue());
      $b = strtr(trim($b), $sustituye);
      //$b = htmlentities($b, ENT_QUOTES, "UTF-8");
      echo $b;
      echo "</font></td>";
      echo "</tr>";
      if ($row > 1)
      {
        if ($a == "")
        {
        }
        else
        {
          $sql = odbc_exec($conexion,"SELECT count(1) as contador FROM cx_usu_web WHERE usuario='$a'");
          $contador = odbc_result($sql,1);
          if ($contador == '0')
          {
            $sql1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_usu_web");
            $conse = odbc_result($sql1,1);
            $query = "INSERT INTO cx_usu_web (conse, usuario, nombre, clave, conexion, estado, cambio, usu_crea, cargo) VALUES ('$conse', '$a', '$b', '$clave', '2', '1', '1', '$usu_usuario', '$b')";
            if (!odbc_exec($conexion, $query))
            {
              $fec_log = date("d/m/Y H:i:s a");
              $file = fopen("log_admin1.txt", "a");
              fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
              fclose($file);
            }
            //odbc_exec($conexion, $query);
            // Se graba log
            $fec_log = date("d/m/Y H:i:s a");
            $file = fopen("log_admin.txt", "a");
            fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
            fclose($file);
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