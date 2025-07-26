<?php
session_start();
error_reporting(1);

class Borrar {


    public function __construct($evento, $file)
    {
        $this->setConexion($conexion);
        $this->setProceso($proceso);
        $this->setFile($file);
        $this->selectFuncional($evento);
    }

    private function selectFuncional($evento)
    {
        switch ($evento)
        {
            case "SI":
                $this->creatxt();
                break;
        }
    }

	private function creatxt()
    {
		$this->creaLogArchivo(" 3. Cx Computers \r\n");
	}

    private function creaLogArchivo($info)
    {
		$fec_log = date("d/m/Y H:i:s a");
		$fec_log .= $info;
		$file = fopen("jmm.txt", "a");
		fwrite($file, $fec_log." # ".PHP_EOL);
		fclose($file);
    }

    private function setFile($file)
    {
        $this->file = $file;
    }

    private function getFile()
    {
        return $this->file;
    }

    private function setProceso($proceso)
    {
        $this->proceso = $proceso;
    }
}


//cgi-fcgi

//$sapi_type = php_sapi_name();


//if (PHP_SAPI == 'cli')
//{
//    $tipo = $argv[1];
//}
//else
//{
//    $tipo = $_POST['tipo'];
//}

//$fec_log = date("d/m/Y H:i:s a");
//$file = fopen("jmm.txt", "a");
////fwrite($file, $fec_log." # ".$sapi_type." # ".$tipo." # ".PHP_EOL);
//fwrite($file, $fec_log." # ".PHP_EOL);
//fclose($file);

//$objBorra = new Borra($tipo, isset($_FILES) ? $_FILES : '');

//if (PHP_SAPI != 'cli')
//{
//    echo json_encode($objTipiCal->getResponse());
//}

//class Borra
//{
    //private $tipo;

//    $ruta_local = "C:\\inetpub\\wwwroot\\Gastos\\fpdf";
//    $dir = opendir ("./fpdf/");
//    while (false !== ($archivo = readdir($dir)))
//    {
//        if (strpos($archivo, '.tmp',1))
//        {
//            if ($tipo == "1")
//            {
//                $fec_log = date("d/m/Y H:i:s a");
//                $file = fopen($ruta_local."\\"."archivos.txt", "a");
//                fwrite($file, $fec_log." # ".$archivo." # ".PHP_EOL);
//                fclose($file);
//            }
//            $file1 = $ruta_local."\\".$archivo;
//            unlink($file1);
//        }
//    }


//}
?>