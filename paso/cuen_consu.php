<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $unidad = $_POST['unidad'];
    $sigla = trim($_POST['sigla']);
    $unidades = $_POST['unidades'];
    $unidades1 = stringArray1($unidades);
    $pregunta = "SELECT * FROM cv_unidades WHERE subdependencia IN ($unidades1) ORDER BY subdependencia";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $siglas = "";
    if ($total>0)
    {
        $i = 0;
        while ($i < $row = odbc_fetch_array($sql))
        {
            $siglas .= trim($row['sigla']).",";
            $i++;
        }
        $siglas = substr($siglas,0,-1);
    }
    $periodo = $_POST['periodo'];
    $periodo1 = trim($_POST['periodo1']);
    $ano = $_POST['ano'];
    $ruta_local1 = $ruta_local."\\upload\\cuenta";
    $carpeta1 = $ruta_local1;
    if(!file_exists($carpeta1))
    {
        mkdir ($carpeta1);
    }
    $carpeta2 = $carpeta1."\\".$ano;
    if(!file_exists($carpeta2))
    {
        mkdir ($carpeta2);
    }
    $carpeta3 = $carpeta2."\\".$periodo1;
    if(!file_exists($carpeta3))
    {
        mkdir ($carpeta3);
    }
    $carpeta4 = $carpeta3."\\".$sigla;
    if(!file_exists($carpeta4))
    {
        mkdir ($carpeta4);
    }
    $ruta = "upload/cuenta/".$ano."/".$periodo1."/";
    $contador = 0;
    $archivos = "";
    $archivos1 = "";
    $archivos2 = "";
   	$carpeta = $ruta_local."\\upload\\cuenta\\".$ano."\\".$periodo1;
	$dir = opendir ($carpeta);
	$i = 1;
	while (false !== ($file = readdir($dir)))
	{
		if (($file == '.') or ($file == '..'))
        {
        }
        else
        {
            if (($unidad == "1") or ($unidad == "2"))
            {
                $carpeta1 = $ruta_local."\\upload\\cuenta\\".$ano."\\".$periodo1."\\".$file;
                $dir1 = opendir ($carpeta1);
                $j = 1;
                while (false !== ($file1 = readdir($dir1)))
                {
                    if (($file1 == '.') or ($file1 == '..'))
                    {
                    }
                    else
                    {
                        $num_archivo = explode(".", $file1);
                        $extension = count($num_archivo);
                        $extension = intval($extension);
                        if ($extension == "1")
                        {
                        }
                        else
                        {
                            $archivos1 .= $file1."|";
                            $archivos2 .= date("Y-m-d H:i:s", filemtime($carpeta1))."|";
                            $contador ++;
                        }
                    }
                }
                $archivos1 .= $file1."#";
                $archivos2 .= $file1."#";
                $archivos .= $file."|";
            }
            else
            {
                if ($sigla == $file)
                {
                    $carpeta1 = $ruta_local."\\upload\\cuenta\\".$ano."\\".$periodo1."\\".$file;
                    $dir1 = opendir ($carpeta1);
                    $j = 1;
                    while (false !== ($file1 = readdir($dir1)))
                    {
                        if (($file1 == '.') or ($file1 == '..'))
                        {
                        }
                        else
                        {
                            $num_archivo = explode(".", $file1);
                            $extension = count($num_archivo);
                            $extension = intval($extension);
                            if ($extension == "1")
                            {
                            }
                            else
                            {
                                $archivos1 .= $file1."|";
                                $archivos2 .= date("Y-m-d H:i:s", filemtime($carpeta1))."|";
                                $contador ++;
                            }
                        }
                    }
                    $archivos1 .= $file1."#";
                    $archivos2 .= $file1."#";
                    $archivos .= $file."|";
                }
            }
		}
	}
    $salida = new stdClass();
    $salida->contador = $contador;
    $salida->archivos = $archivos;
    $salida->archivos1 = $archivos1;
    $salida->archivos2 = $archivos2;
    $salida->siglas = $siglas;
    echo json_encode($salida);
}
// 23/10/2023 - Ajuste consulta por unidad centralizadora
?>