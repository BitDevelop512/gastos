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
  // Se graba log
  $fec_log = date("d/m/Y H:i:s a");
  $file = fopen("log_para.txt", "a");
  fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
  fclose($file);
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
        switch ($admin)
        {
          case '1':
            $admin2 = "USUARIO DE COMPA&Ntilde;&Iacute;A (Regimen Interno)";
            break;
          case '2':
            $admin2 = "COMANDANTE DE COMPA&Ntilde;&Iacute;A";
            break;
          case '3':
            $admin2 = "USUARIO S-4 DE BATALLON";
            break;
          case '4':
            $admin2 = "COMANDANTE DE BATALLON";
            break;
          case '6':
            $admin2 = "SUBOFICIAL GASTOS RESERVADOS BRIGADA";
            break;
          case '7':
            $admin2 = "OFICIAL DE ADMINISTRACI&Oacute;N Y LOG&Iacute;STICA B4";
            break;
          case '8':
            $admin2 = "JEM DE BRIGADA";
            break;
          case '9':
            $admin2 = "COMANDANTE DE BRIGADA";
            break;
          case '10':
            $admin2 = "SUBOFICIAL GASTOS RESERVADOS DE COMANDO";
            break;
          case '11':
            $admin2 = "OFICIAL DE ADMINISTRACI&Oacute;N Y LOG&Iacute;STICA C4";
            break;
          case '12':
            $admin2 = "JEM DE COMANDO";
            break;
          case '13':
            $admin2 = "COMANDANTE DE COMANDO";
            break;
          case '14':
            $admin2 = "SUBOFICIAL PLANEACION PARTIDAS ESPECIALES";
            break;
          case '15':
            $admin2 = "SUBOFICIAL PLANEACION GR (TESORERO)";
            break;
          case '16':
            $admin2 = "OFICIAL DE PLANEACION Y DIRECCIONAMIENTO PRESUPUESTAL ADMINISTRATIVO";
            break;
          case '17':
            $admin2 = "DIRECTOR ADMINISTRATIVO DE INTELIGENCIA Y CONTRAINTELIGENCIA";
            break;
          case '18':
            $admin2 = "JEFE DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA";
            break;
          case '19':
            $admin2 = "OFICIAL DE FINANCIERA Y PRESUPUESTO C8";
            break;
          case '20':
            $admin2 = "SUBOFICIAL DE ANALISIS DE RECOMPENSAS";
            break;
          case '21':
            $admin2 = "DIRECTOR DIRECCION";
            break;
          case '22':
            $admin2 = "ASISTENTE DIRECCION";
            break;
          case '23':
            $admin2 = "AYUDANTE DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA";
            break;
          case '24':
            $admin2 = "ASISTENTE AYUDANTIA";
            break;
          case '25':
            $admin2 = "SUBOFICIAL PLANEACION";
            break;
          case '26':
            $admin2 = "SUBOFICIAL SEGURIDAD MILITAR";
            break;
          case '27':
            $admin2 = "OFICIAL DE OPERACIONES BATALLON";
            break;
          case '28':
            $admin2 = "SUBOFICIAL ANALISIS RECOMPENSAS";
            break;
          case '29':
            $admin2 = "AREA DE INTELIGENCIA";
            break;
          case '30':
            $admin2 = "AREA DE OPERACIONES";
            break;
          case '31':
            $admin2 = "SUBOFICIAL GASTOS RESERVADOS BRIGADA";
            break;
          case '32':
            $admin2 = "ALMACENISTA DIADI";
            break;
          case '33':
            $admin2 = "SUBOFICIAL EVALUACION Y SEGUIMIENTO";
            break;
          case '34':
            $admin2 = "ADMINISTRADOR TRANSPORTES BRIGADA";
            break;
          case '35':
            $admin2 = "ADMINISTRADOR TRANSPORTES BATALLÓN";
            break;
          case '36':
            $admin2 = "ADMINISTRADOR TRANSPORTES COMANDO";
            break;
          default:
            $admin2 = "&nbsp;";
            break;
        }
        echo "(".$admin.") - ".utf8_encode(trim($admin2));
      }
      else
      {
        switch ($admin)
        {
          case '1':
            $admin2 = "SUBOFICIAL GESTION ADMINISTRATIVA S-2";
            break;
          case '3':
            $admin2 = "OFICIAL INTELIGENCIA BATALLON";
            break;
          case '4':
            $admin2 = "COMANDANTE DE BATALLON";
            break;
          case '5':
            $admin2 = "SUBOFICIAL DE ANALISIS DE RECOMPENSAS";
            break;
          case '6':
            $admin2 = "SUBOFICIAL GESTION ADMINISTRATIVA B-2";
            break;
          case '7':
            $admin2 = "OFICIAL INTELIGENCIA BRIGADA";
            break;
          case '9':
            $admin2 = "COMANDANTE DE BRIGADA";
            break;
          case '10':
            $admin2 = "SUBOFICIAL GESTION ADMINISTRATIVA D-2, F-2, C-2";
            break;
          case '11':
            $admin2 = "OFICIAL INTELIGENCIA DIVISION";
            break;
          case '12':
            $admin2 = "JEM DE DIVISION";
            break;
          case '13':
            $admin2 = "COMANDANTE DE DIVISION";
            break;
          case '14':
            $admin2 = "SUBOFICIAL PLANEACION PARTIDAS ESPECIALES";
            break;
          case '15':
            $admin2 = "SUBOFICIAL PLANEACION GR (TESORERO)";
            break;
          case '16':
            $admin2 = "OFICIAL DE PLANEACIÓN Y DIRECCIONAMIENTO PRESUPUESTAL ADMINISTRATIVO";
            break;
          case '17':
            $admin2 = "DIRECTOR ADMINISTRATIVO DE INTELIGENCIA Y CONTRAINTELIGENCIA";
            break;
          case '18':
            $admin2 = "JEFE DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA";
            break;
          case '20':
            $admin2 = "SUBOFICIAL DE ANALISIS DE RECOMPENSAS";
            break;
          case '21':
            $admin2 = "DIRECTOR DIRECCION";
            break;
          case '22':
            $admin2 = "ASISTENTE DIRECCION";
            break;
          case '23':
            $admin2 = "AYUDANTE DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA";
            break;
          case '24':
            $admin2 = "ASISTENTE AYUDANTIA";
            break;
          case '33':
            $admin2 = "SUBOFICIAL EVALUACION Y SEGUIMIENTO";
            break;
          case '34':
            $admin2 = "ADMINISTRADOR TRANSPORTES BRIGADA";
            break;
          case '35':
            $admin2 = "ADMINISTRADOR TRANSPORTES BATALLÓN";
            break;
          case '36':
            $admin2 = "ADMINISTRADOR TRANSPORTES COMANDO";
            break;
          default:
            $admin2 = "&nbsp;";
            break;
        }
        echo $admin." ".utf8_encode(trim($admin2));
      }
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
?>