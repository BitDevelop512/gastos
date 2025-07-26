<!doctype html>
<?php
session_start();
error_reporting(0);
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('conf.php');
  include('funciones.php');
  include('permisos.php');
  $conse = $_GET['conse'];
  $ano = $_GET['ano'];
?>
<html lang="es">
<head>
<?php
include('encabezado.php');
?>
<style>
A:link      { text-decoration: none }
A:visited   { text-decoration: none }
A:active    { text-decoration: none }
A:hover     { text-decoration: none }
</style>
</head>
<body>
<?php
include('titulo.php');
?>
<div id="res_unic">
  <br>
  <center>
    <h2>Revisi&oacute;n Solicitudes Pendientes</h2>
  </center>
  <table align="center" width="50%" border="1">
    <tr>
      <td width="70%" height="24">
        <center>
          <b>Unidad</b>
        </center>
      </td>
      <td width="30%" height="24">
        <center>
          <b>Revisi&oacute;n</b>
        </center>
      </td>
    </tr>
    <?php
    $actual = date('Y-m-d');
    $pregunta = "SELECT conse, ano, unidad FROM cx_pla_inv WHERE conse IN ($conse) AND ano='$ano' ORDER BY conse";
    $sql = odbc_exec($conexion, $pregunta);
    $total = odbc_num_rows($sql);
    while($i<$row=odbc_fetch_array($sql))
    {
      $conse = $row["conse"];
      $ano = $row["ano"];
      $unidad = $row["unidad"];
      $pregunta1 = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unidad'";
      $sql1 = odbc_exec($conexion, $pregunta1);
      $n_unidad = trim(odbc_result($sql1,1));
      $m_unidad = trim(odbc_result($sql1,2));
      $f_unidad = trim(odbc_result($sql1,3));
      if ($f_unidad == "")
      {
      }
      else
      {
        $f_unidad = str_replace("/", "-", $f_unidad);
        if ($actual >= $f_unidad)
        {
          $n_unidad = $m_unidad;
        }
      }
      echo '<tr><td height="24"><font color="#0033FF"><b>'.$n_unidad.' - '.$conse.'</b></font></td>';
      echo '<td><center><a href="#" onclick="revisa('.$conse.','.$ano.')"><img src="imagenes/aceptar.png" border="0" title="Aplicar Revisión" width="24" height="24"></a></center></td></tr>';
    }
    ?>
  </table>
</div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
function revisa(valor, valor1)
{
  var valor, valor1, link;
  link = "conse="+valor+"&ano="+valor1;
  var url = "apli_plan.php?"+link;
  window.open(url, 'derecha');
}
</script>
</body>
</html>
<?php
}
// 26/01/2024 - Ajuste de cambio de sigla validando la fecha actual
?>