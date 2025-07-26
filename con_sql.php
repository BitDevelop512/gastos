<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
ini_set('memory_limit', '3072M');
ini_set('max_execution_time', 3600);
if ($_SESSION["autenticado"] = "SI")
{
  if (is_ajax())
  {
    if ($sup_usuario == "1")
    {
      $query = $_POST['valor'];
      $query = str_replace("top", "TOP", $query);
      $query = str_replace("from", "FROM", $query);
      $query = str_replace("where", "WHERE", $query);
      if (strpos($query, "SELECT") !== false)
      {
        $tipo = "1";
      }
      else
      {
        $tipo = "2";
        $query = iconv("UTF-8", "ISO-8859-1", $query);
      }
      $respuesta = array();
      if ($tipo == "1")
      {
        $verifica = explode("FROM",$query);
        $verifica1 = trim($verifica[0]);
        $verifica2 = trim($verifica[1]);
        $n_campos = trim(substr($verifica1,7,100));
        $t_campos = explode(",",$n_campos);
        $verifica3 = explode(" ",$verifica2);
        $n_tabla = trim($verifica3[0]);
        $verifica4 = trim(substr($query,0,8));
        $verifica5 = trim(substr($query,0,10));
        $sql = odbc_exec($conexion,$query);
        $total = odbc_num_rows($sql);
        if ($total>0)
        {
          if (($verifica4 == "SELECT *") or ($verifica5 == "SELECT TOP"))
          {
            $i=0;
            while($i<$row=odbc_fetch_array($sql))
            {
              $cursor = array();
              $cursor["var1"] = trim(utf8_encode(odbc_result($sql,1)));
              $cursor["var2"] = trim(utf8_encode(odbc_result($sql,2)));
              $cursor["var3"] = trim(utf8_encode(odbc_result($sql,3)));
              $cursor["var4"] = trim(utf8_encode(odbc_result($sql,4)));
              $cursor["var5"] = trim(utf8_encode(odbc_result($sql,5)));
              $cursor["var6"] = trim(utf8_encode(odbc_result($sql,6)));
              $cursor["var7"] = trim(utf8_encode(odbc_result($sql,7)));
              $cursor["var8"] = trim(utf8_encode(odbc_result($sql,8)));
              $cursor["var9"] = trim(utf8_encode(odbc_result($sql,9)));
              array_push($respuesta, $cursor);
              $i++;
            }
          }
          else
          {
            while($i<$row=odbc_fetch_array($sql))
            {
              $cursor = array();
              $k = 1;
              for ($j=0;$j<count($t_campos);++$j)
              {
                $campo = trim($t_campos[$j]);
                $pregunta = "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='$n_tabla' AND column_name='$campo'";
                $sql1 = odbc_exec($conexion,$pregunta);
                $tipo = trim(odbc_result($sql1,2));
                if ($tipo == "text")
                {
                  $valor = trim(utf8_encode($row[$campo]));
                }
                else
                {
                  $valor = trim(utf8_encode(odbc_result($sql,$k)));
                }
                $cursor["var".$k] = $valor;
                $k++;
              }
              array_push($respuesta, $cursor);
              $i++;
            }
          }
        }
      }
      else
      {
        if (!odbc_exec($conexion,$query))
        {
          $confirma = "0";
        }
        else
        {
          $confirma = "1";
        }
        $cursor = array();
        $cursor["var1"] = $confirma;
        $cursor["var2"] = "";
        $cursor["var3"] = "";
        $cursor["var4"] = "";
        $cursor["var5"] = "";
        $cursor["var6"] = "";
        $cursor["var7"] = "";
        $cursor["var8"] = "";
        $cursor["var9"] = "";
        array_push($respuesta, $cursor);
      }
      $valida1 = strpos($usu_usuario, "-");
      $valida1 = intval($valida1);
      if ($valida1 == "0")
      {
        $fec_log = date("d/m/Y H:i:s a");
        $file = fopen("log_sql.txt", "a");
        fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
        fclose($file);
      }
      echo json_encode($respuesta);
    }
  }
}
?>