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
  require('funciones.php');
  $actual = date('Y-m-d');
  $tipo = $_POST['tipo'];
  $unidad = $_POST['unidad'];
  $unidad1 = $_POST['unidad1'];
  if ($tipo == "1")
  {
    $query = "SELECT * FROM cx_usu_web WHERE 1=1";
    if ($unidad == "999")
    {
      $query .= " AND unidad>0 AND admin>0";
    }
    else
    {
      $query .= " AND (unidad='$unidad' OR usuario LIKE '%$unidad1%') AND admin>0";
    }
  }
  else
  {
    $query = "SELECT * FROM cx_usu_web WHERE 1=1";
    if ($unidad == "999")
    {
      $query .= " AND unidad='0' AND admin='0'";
    }
    else
    {
      $query .= " AND usuario LIKE '%$unidad1%' AND (unidad='0' OR admin='0')";
    }
  }
  $query .= " AND usuario NOT LIKE 'CX-%'";
  $query .= " ORDER BY unidad, admin, conse";
  $cur = odbc_exec($conexion,$query);
  $nregistros = odbc_num_rows($cur);
  echo "<center><font face='Verdana' size='2' color='#000000'><b>Total Usuarios Encontrados: ".$nregistros."</b></font></center>";
?>
  <br>
  <table align="center" width="100%" border="1">
    <tr>
      <td width="10%" height="35" bgcolor="#CCCCCC">
        <center><b>Usuario</b></center>
      </td>
      <td width="25%" height="35" bgcolor="#CCCCCC">
        <center><b>C&eacute;dula - Nombre</b></center>
      </td>
      <td width="30%" height="35" bgcolor="#CCCCCC">
        <center><b>Cargo</b></center>
      </td>
      <td width="10%" height="35" bgcolor="#CCCCCC">
        <center><b>Unidad</b></center>
      </td>
      <td width="20%" height="35" bgcolor="#CCCCCC">
        <center><b>Tipo Usuario</b></center>
      </td>
      <td width="5%" height="35" bgcolor="#CCCCCC">
        <center>&nbsp;</center>
      </td>
    </tr>
    <?php
    while($i<$row=odbc_fetch_array($cur))
    {
      $usuario = $row["usuario"];
      $cedula = trim($row["cedula"]);
      $nombre = utf8_encode(trim($row["nombre"]));
      $cargo = utf8_encode(trim($row["cargo"]));
      $unidad = $row["unidad"];
      $admin = $row["admin"];
      $query1 = "SELECT sigla, unidad, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$unidad'";
      $cur1 = odbc_exec($conexion, $query1);
      $unidad1 = trim(odbc_result($cur1,1));
      $unidad2 = odbc_result($cur1,2);
      // Nueva sigla
      $sigla1 = trim(odbc_result($cur1,3));
      $fec_valida = trim(odbc_result($cur1,4));
      if ($fec_valida == "")
      {
      }
      else
      {
        $fec_valida = str_replace("/", "-", $fec_valida);
        if ($actual >= $fec_valida)
        {
          $unidad1 = $sigla1;
        }
      }
      echo "<tr>";
      echo "<td height='35'><font size='2' face='Verdana'>".$usuario."</font></td>";
      echo "<td height='35'><font size='2' face='Verdana'>".$cedula." - ".$nombre."</font></td>";
      echo "<td height='35'><font size='2' face='Verdana'>".$cargo."</font></td>";
      echo "<td height='35'><font size='2' face='Verdana'>".$unidad1."&nbsp;</font></td>";
      echo "<td height='35'><font size='2' face='Verdana'>";
      if (($unidad2 == "1") or ($unidad2 == "2") or ($unidad2 == "3"))
      {
        $n_tipo = "1,3";
      }
      else
      {
        $n_tipo = "2,3";
      }
      $query2 = "SELECT nombre FROM cx_ctr_usu WHERE tipo IN (".$n_tipo.") AND codigo='$admin'";
      $cur2 = odbc_exec($conexion, $query2);
      $admin2 = trim(utf8_encode(odbc_result($cur2,1)));
      echo "(".$admin.") - ".$admin2;
      echo "</font></td>";
      echo "<td height='35'><center><a href='cambio1.php?usuario=$usuario'><img src='imagenes/usuario.png' border='0' width='30' title='Cambiar Usuario'></a></center></td>";
      echo "</tr>";
    }
    ?>
  </table>
  <script>
    $("#load").hide();
  </script>
<?php
}
// 01/08/2023 - Ajuste en consulta para incluir cambio de usuario
// 11/08/2023 - Ajuste de cambio de sigla validando la fecha actual
// 12/03/2024 - Ajuste nuevos usuarios administradores transportes
// 19/03/2024 - Ajuste usuarios cx
// 09/04/2025 - Ajuste tipos de usuario desde tabla cx_ctr_usu
?>