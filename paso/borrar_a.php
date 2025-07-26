<?php
session_start();
error_reporting(1);
//require_once __DIR__ . '/../borrar1.php';
//if (PHP_SAPI == 'cgi-fcgi')
//{
    $evento = $argv[1];
//}
//else
//{
//    $evento = $_POST['evento'];
//}
$objTipiCal = new Borrar($evento);

class Borrar
{
    public function __construct($evento)
    {
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
        return $fec_log;
    }
}

//if (PHP_SAPI != 'cgi-fcgi')
//{
    //echo json_encode($objTipiCal->getResponse());
//}

$respuesta = json_encode($objTipiCal->getResponse());
$file = fopen("jmm1.txt", "a");
fwrite($file, $respuesta." # ".PHP_EOL);
fclose($file);

?>