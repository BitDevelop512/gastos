<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $sustituye = array ( '01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9' );
    $interno = $_POST['interno'];
    $unidad = $_POST['unidad'];
    $paso = $_POST['paso'];
    $paso1 = $_POST['paso1'];
    $paso2 = $_POST['paso2'];
    if (!empty($_POST['paso3']))
    {
        $paso3 = $_POST['paso3'];
    }
    else
    {
        $paso3 = "0";
    }
    $paso3 = intval($paso3);
    if (!empty($_POST['conse']))
    {
        $conse = $_POST['conse'];
    }
    else
    {
        $conse = "0";
    }
    if (!empty($_POST['ano']))
    {
        $ano = $_POST['ano'];
    }
    else
    {
        $ano = "0";
    }
    // Se valida si la unidad indico que no cuenta con recursos
    $query0 = "SELECT recursos, especial FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano'";
    $sql0 = odbc_exec($conexion, $query0);
    $recursos = odbc_result($sql0,1);
    $especial2 = odbc_result($sql0,2);
    // Departamento - Direccion - Unidad Especial - Fuerza de Despliegue - Fudat o Cecat (6 - 7)
    if (($paso == "1") or ($paso == "2")  or ($paso == "3")  or (($paso == "9") and (($uni_usuario == "6") OR ($uni_usuario == "7"))))
    {
        $v1 = explode("_", $usu_usuario);
        $v2 = $v1[1];
        $v3 = "DIADI";
        $v4 = "CEDE2";
        if ($usu_usuario == "JEF_CEDE2")
        {
            $query = "SELECT * FROM cx_usu_web WHERE usuario='STE_DIADI'";
        }
        else
        {
            if (($adm_usuario == "22") or ($adm_usuario == "24"))
            {
                $query = "SELECT * FROM cx_usu_web WHERE usuario LIKE '%$v2%' AND usuario!='$usu_usuario'";
            }
            else
            {
                $query = "SELECT * FROM cx_usu_web WHERE usuario!='$usu_usuario' AND ((usuario LIKE '%$v2%') OR (usuario LIKE '%$v3%') OR (usuario LIKE '%$v4%'))";
            }
        }
    }
    // Comando o Centro Inteligencia
    if (($paso == "4") or ($paso == "5"))
    {
        $v1 = explode("_", $usu_usuario);
        $v2 = $v1[1];
        $v3 = "SGR_".$v2;
        $v4 = "SPG_DIADI";
        $v5 = $v1[0];
        $v6 = substr($v5, 0, 4);
        if (strpos($usu_usuario, "CDO") !== false)
        {
            $pregunta = "SELECT especial FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
            $sql = odbc_exec($conexion,$pregunta);
            $especial = odbc_result($sql,1);
            if ($especial == "0")
            {
                $query = "SELECT * FROM cx_usu_web WHERE usuario!='$usu_usuario' AND ((usuario LIKE '%$v3%') OR (usuario LIKE '%$v4%'))";
            }
            else
            {
                $pregunta1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$especial' AND unic='1'";
                $sql1 = odbc_exec($conexion, $pregunta1);
                $especial1 = odbc_result($sql1,1);
                $query = "SELECT * FROM cx_usu_web WHERE usuario!='$usu_usuario' AND unidad='$especial1'";
            }
        }
        else
        {
            if (($v6 == "SAEB") or ($v6 == "CI3M"))
            {
                $v7 = strlen($v5);
                if ($v7 == "6")
                {
                    $v8 = substr($v5, 5, 1);
                    $v9 = "CI3MO".$v8;
                    $v6 = $v6."0".$v8;
                    $query = "SELECT * FROM cx_usu_web WHERE ((usuario LIKE '%$v6%') OR (usuario='SAEB_".$v2."') OR (usuario='CI3ME_".$v2."') OR (usuario LIKE '%$v9%')) AND usuario!='$usu_usuario'";
                }
                else
                {
                    $query = "SELECT * FROM cx_usu_web WHERE ((usuario LIKE '%$v6%') OR (usuario='CI3ME_".$v2."')) AND usuario!='$usu_usuario'";
                }
            }
            else
            {
                $query = "SELECT * FROM cx_usu_web WHERE usuario LIKE '%$v2%' AND usuario!='$usu_usuario'";
            }
        }
    }
    // Division
    if ($paso == "6")
    {
        $v1 = explode("_", $usu_usuario);
        $v2 = $v1[1];
        $v3 = "SPG_DIADI";
        $v4 = "SGA_".$v2;
        if ($adm_usuario == "13")
        {
            $query = "SELECT * FROM cx_usu_web WHERE (usuario LIKE '%$v3%') OR (usuario LIKE '%$v4%') AND usuario!='$usu_usuario'";
        }
        else
        {
            $query = "SELECT * FROM cx_usu_web WHERE usuario LIKE '%$v2%' AND usuario!='$usu_usuario'";
        }
    }
    // Brigada
    if ($paso == "7")
    {
        $v1 = explode("_", $usu_usuario);
        $v2 = $v1[1];
        $v3 = "OB4_".$v2;
        $pregunta1 = "SELECT unidad FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
        $cur1 = odbc_exec($conexion, $pregunta1);
        $v4 = odbc_result($cur1,1);
        $pregunta2 = "SELECT nombre FROM cx_org_uni WHERE unidad='$v4'";
        $cur2 = odbc_exec($conexion, $pregunta2);
        $v5 = trim(odbc_result($cur2,1));
        $v6 = "SGR_".$v2;
        $v7 = $v1[0];
        $v7 = $v7."_";
        if (($tpu_usuario == "1") or ($tpu_usuario == "2")  or ($tpu_usuario == "3"))
        {
            $query = "SELECT * FROM cx_usu_web WHERE usuario!='$usu_usuario' AND (usuario LIKE '%$v3%') OR (usuario LIKE '%$paso2%') OR (usuario LIKE '%$v5%')";
        }
        else
        {
            if ($v7 == "CDO_")
            {
                if ($paso3 == "1")
                {
                    $query = "SELECT * FROM cx_usu_web WHERE usuario='$v6' AND usuario!='$usu_usuario'";
                }
                else
                {
                    $query = "SELECT * FROM cx_usu_web WHERE usuario!='$usu_usuario' AND ((usuario LIKE '%$v2') OR (usuario LIKE '%$v5%'))";
                }
            }
            else
            {
                if (($adm_usuario == "6") or ($adm_usuario == "7"))
                {
                    $query = "SELECT * FROM cx_usu_web WHERE usuario!='$usu_usuario' AND usuario LIKE '%$v2'";
                }
                else
                {
                    $query = "SELECT * FROM cx_usu_web WHERE usuario!='$usu_usuario' AND ((usuario LIKE '%$v2%') OR (usuario LIKE '%$v5%'))";
                }
            }
        }
    }
    // Batallon
    if ($paso == "8")
    {
        // Usuario
        $v1 = explode("_", $usu_usuario);
        $v2 = $v1[1];
        $v3 = "CDO_".$v2;
        $v3_1 = $v1[0];
        // Usuario Anterior
        $v4 = explode("_", $log_usuario);
        $v5 = $v4[1];
        $v6 = "CDO_".$v5;
        $v6_1 = $v4[0];
        if ($paso1 == "1")
        {
            if (($tpu_usuario == "1") or ($tpu_usuario == "2")  or ($tpu_usuario == "3"))
            {
                $query = "SELECT * FROM cx_usu_web WHERE ((usuario LIKE '%$v3') OR (usuario LIKE '%$v6')) AND usuario!='$usu_usuario'";
            }
            else
            {
                $query = "SELECT * FROM cx_usu_web WHERE ((usuario LIKE '%$v2') OR (usuario LIKE '%$v5')) AND usuario!='$usu_usuario'";
            }
        }
        else
        {
            $pregunta1 = "SELECT dependencia, sigla, unidad FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
            $cur1 = odbc_exec($conexion, $pregunta1);
            $v3 = odbc_result($cur1,1);
            $v4 = trim(odbc_result($cur1,2));
            $v5 = odbc_result($cur1,3);
            $v5 = intval($v5);
            if ($v5 > 3)
            {
                if (($v5 == "13") or ($v5 == "14") or ($v5 == "15") or ($v5 == "16"))
                {
                    $pregunta2 = "SELECT sigla, subdependencia FROM cx_org_sub WHERE dependencia='$v3' AND unic='1'";
                }
                else
                {
                    $pregunta2 = "SELECT sigla, subdependencia FROM cx_org_sub WHERE dependencia='$v3' AND unic='2'";
                }
            }
            else
            {
                $pregunta2 = "SELECT sigla, subdependencia FROM cx_org_sub WHERE dependencia='$v3' AND unic='1'";
            }
            $cur2 = odbc_exec($conexion, $pregunta2);
            $v6 = trim(odbc_result($cur2,1));
            $v6_1 = odbc_result($cur2,2);
            $sustituye = array ( '01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9' );
            $v7 = strtr(trim($v6), $sustituye);
            if (($tpu_usuario == "1") or ($tpu_usuario == "2")  or ($tpu_usuario == "3"))
            {
                $v8 = "SPP_".$v7;
            }
            else
            {
                $v8 = "_".$v7;   
            }
            $v1 = explode("_", $usu_usuario);
            $v2 = $v1[1];
            if (($v6_1 == "70") or ($v6_1 == "88") or ($v6_1 == "117"))
            {
                $query = "SELECT * FROM cx_usu_web WHERE (usuario LIKE '%$v8') OR (usuario LIKE '%$v2%') AND usuario!='$usu_usuario'";
            }
            else
            {
                if ($v8 == "_FTCTITAN")
                {
                    $v8 = substr($v8, 0, -3);
                }
                if ($v8 == "_")
                {
                    $query = "SELECT * FROM cx_usu_web WHERE (usuario LIKE '%$v2') AND usuario!='$usu_usuario'";
                }
                else
                {
                    $query = "SELECT * FROM cx_usu_web WHERE (usuario LIKE '%$v8%') OR (usuario LIKE '%$v2') AND usuario!='$usu_usuario'";
                }
            }
            if ($v3_1 == "CDO")
            {

                $query .= " OR usuario LIKE '%$v4' ";
            }
            $pregunta3 = "SELECT tipo FROM cx_usu_web WHERE usuario='$usu_usuario'";
            $cur3 = odbc_exec($conexion, $pregunta3);
            $v9 = trim(odbc_result($cur3,1));
            $pregunta4 = "SELECT nombre, tipo FROM cx_org_cmp WHERE conse='$v9'";
            $cur4 = odbc_exec($conexion, $pregunta4);
            $v10 = trim(odbc_result($cur4,1));
            $v10_1 = trim(odbc_result($cur4,2));
	        $v11 = substr($v10, 0, 3);
	        if (($v11 == "COM") or ($v11 == "CIA") or ($v11 == "CÍA"))
	        {
                if ($v10_1 == "1")
                {
    	        	$pregunta5 = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
    	        	$cur5 = odbc_exec($conexion, $pregunta5);
    	        	$v12 = trim(odbc_result($cur5,1));
    	        	$query = "SELECT * FROM cx_usu_web WHERE usuario LIKE '%$v12' AND unidad='$uni_usuario'";
                }
	        }
        }
    }
    // Fuerza
    if ($paso == "9")
    {
        $v1 = explode("_", $usu_usuario);
        $v2 = $v1[1];
        $v3 = "OB4_".$v2;
        $pregunta1 = "SELECT unidad FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
        $cur1 = odbc_exec($conexion, $pregunta1);
        $v4 = odbc_result($cur1,1);
        $pregunta2 = "SELECT nombre FROM cx_org_uni WHERE unidad='$v4'";
        $cur2 = odbc_exec($conexion, $pregunta2);
        $v5 = trim(odbc_result($cur2,1));
        $v6 = "SGR_".$v2;
        $v7 = $v1[0];
        $v7 = $v7."_";
        if (($tpu_usuario == "1") or ($tpu_usuario == "2")  or ($tpu_usuario == "3"))
        {
            $query = "SELECT * FROM cx_usu_web WHERE usuario!='$usu_usuario' AND ((usuario LIKE '%$v3%') OR (usuario LIKE '%$paso2%') OR (usuario LIKE '%$v5%'))";
        }
        else
        {
            if ($v7 == "CDO_")
            {
                if ($paso3 == "1")
                {
                    $query = "SELECT * FROM cx_usu_web WHERE usuario='$v6' AND usuario!='$usu_usuario'";
                }
                else
                {
                    $query = "SELECT * FROM cx_usu_web WHERE usuario!='$usu_usuario' AND ((usuario LIKE '%$v2%') OR (usuario LIKE '%$v5%'))";
                }
            }
            else
            {
                if (($adm_usuario == "6") or ($adm_usuario == "7"))
                {
                    $query = "SELECT * FROM cx_usu_web WHERE usuario!='$usu_usuario' AND usuario LIKE '%$v2'";
                }
                else
                {
                    $query = "SELECT * FROM cx_usu_web WHERE usuario!='$usu_usuario' AND ((usuario LIKE '%$v2%') OR (usuario LIKE '%$v5%'))";
                }
            }
        }
    }
    $var_con = "";
    $var_usu = "";
    $var_nom = "";
    $var_sig = "";
    // Consulta favoritos
    $pregunta6 = "SELECT favoritos FROM cx_usu_fav WHERE usuario='$usu_usuario'";
	$cur6 = odbc_exec($conexion, $pregunta6);
	$favo = odbc_num_rows($cur6);
	$favoritos = "";
	if ($favo > 0)
	{
		$favo1 = trim(odbc_result($cur6,1));
        $num_favoritos = explode(",",$favo1);
        $con_favoritos = count($num_favoritos);
        $paso = "";
        $paso1 = "";
        for ($i=0; $i<$con_favoritos; ++$i)
        {
            $paso .= "'".trim($num_favoritos[$i])."',";
            $paso1 .= " AND usuario!=('".trim($num_favoritos[$i])."')";
        }
        $paso = substr($paso,0,-1);
        $favoritos = $paso;
        if ($especial > 0)
        {
        }
        else
        {
            $query .= $paso1;
        }
        $query_f = "SELECT * FROM cx_usu_web WHERE usuario IN ($favoritos) AND estado='1' ORDER BY conse";
        $cur_f = odbc_exec($conexion, $query_f);
        while ($m < $row = odbc_fetch_array($cur_f))
        {
            $conse = $row['conse'];
            $usuario = trim($row['usuario']);
            $nombre = trim(utf8_encode($row['nombre']));
            $unidad2 = $row['unidad'];
            $v8 = explode("_", $usuario);

            if ($especial > 0)
            {
            }
            else
            {
                $usuario1 = trim($v8[0]);
            }
            $sigla = trim($v8[1]);
            if (((($adm_usuario == "9") and ($nun_usuario < 3)) or ($adm_usuario == "13")) and ($recursos == "0") and (($usuario1 == "SGA") or ($usuario1 == "SGR")))
            {
            }
            else
            {
                $var_con .= $conse."|";
                $var_usu .= $usuario."|";
                $var_nom .= $nombre."|";
                $var_sig .= $sigla."|";
            }
            $m++;
        }
	}
    else
    {
        $con_favoritos = "0";
    }
    $con_favoritos = intval($con_favoritos);
    $query .= " AND estado='1' AND unidad!='0' ORDER BY conse";
    // Si hay mas de 5 favoritos no se realiza la consulta anterior
    if ($con_favoritos > 5)
    {
        $query = "SELECT * FROM cx_usu_web WHERE 1=2";
    }
    // Log busqueda de personas
    $fec_log = date("d/m/Y H:i:s a");
    $file = fopen("log_person.txt", "a");
    fwrite($file, $fec_log." # ".$query." # ".$paso." # ".$pregunta1." # ".$pregunta2." # ".$con_favoritos." # ".$favoritos." # ".PHP_EOL);
    fclose($file);
    $sql = odbc_exec($conexion, $query);
    $total = odbc_num_rows($sql);
    $salida = new stdClass();
    $m = 1;
    while ($m < $row = odbc_fetch_array($sql))
    {
        $conse = $row['conse'];
        $usuario = trim($row['usuario']);
        $nombre = trim(utf8_encode($row['nombre']));
        $unidad2 = $row['unidad'];
        $v8 = explode("_", $usuario);
        $usuario1 = trim($v8[0]);
        $sigla = trim($v8[1]);
        //if ((($adm_usuario == "9") or ($adm_usuario == "13")) and ($recursos == "0") and (($usuario1 == "SGA") or ($usuario1 == "SGR")))
        if (((($adm_usuario == "9") and ($nun_usuario < 3)) or ($adm_usuario == "13")) and ($recursos == "0") and (($usuario1 == "SGA") or ($usuario1 == "SGR")))
        {
        }
        else
        {
            $var_con .= $conse."|";
            $var_usu .= $usuario."|";
            $var_nom .= $nombre."|";
            $var_sig .= $sigla."|";
        }
        $m++;
    }
    $salida->conses = $var_con;
    $salida->usuarios = $var_usu;
    $salida->nombres = $var_nom;
    $salida->siglas = $var_sig;
    $salida->favoritos = $con_favoritos;
    echo json_encode($salida);
}
?>