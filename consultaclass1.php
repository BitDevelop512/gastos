<?php
class ConsultaClass
{
    private $unidad;
    private $compania;
    private $usu;
    private $unidad1;
    private $cambio;
    private $mes;
    private $ano;
    private $ano1;
    private $admin;
    private $nunidad;
    private $conexion;
    private $page;
    private $rows;
    private $sidx;
    private $sord;
    private $searchField;
    private $searchOper;
    private $searchString;
    public $salida = array();

    public function __construct($conexion, $post) {
        $this->setConexion($conexion);
        $this->setPage($post['page']);
        $this->setRows($post['rows']);
        $this->setSidx($post['sidx']);
        $this->setSord($post['sord']);
        $this->setSearchField(isset($post['searchField']) ? $post['searchField'] : '');
        $this->setSearchOper(isset($post['searchOper']) ? $post['searchOper'] : '');
        $this->setSearchString(isset($post['searchString']) ? $post['searchString'] : '');
        $this->setUnidad($post['unidad']);
        $this->setCompania($post['compania']);
        $this->setUsu($post['usu']);
        $this->setUnidad1($post['unidad1']);
        $this->setCambio($post['cambio']);
        $this->setMes($post['mes']);
        $this->setAno($post['ano']);
        $this->setAno1($post['ano1']);
        $this->setAdmin($post['admin']);
        $this->setNunidad($post['nunidad']);
        $this->seleccionaReporte();
    }

    private function setSearchField($searchField) {
        $this->searchField = $searchField;
    }

    private function getSearchField() {
        return $this->searchField;
    }

    private function setSearchOper($searchOper) {
        $this->searchOper = $searchOper;
    }

    private function getSearchOper() {
        return $this->searchOper;
    }

    private function setSearchString($searchString) {
        $this->searchString = $searchString;
    }

    private function getSearchString() {
        return $this->searchString;
    }

    private function setPage($page) {
        $this->page = $page;
    }

    private function getPage() {
        return $this->page;
    }

    private function setRows($rows) {
        $this->rows = $rows;
    }

    private function getRows() {
        return $this->rows;
    }

    private function setSidx($sidx) {
        $this->sidx = $sidx;
    }

    private function getSidx() {
        return $this->sidx;
    }

    private function setSord($sord) {
        $this->sord = $sord;
    }

    private function getSord() {
        return $this->sord;
    }

    private function setUnidad($unidad) {
        $this->unidad = $unidad;
    }

    private function getUnidad() {
        return $this->unidad;
    }

    private function setCompania($compania) {
        $this->compania = $compania;
    }

    private function getCompania() {
        return $this->compania;
    }

    private function setUsu($usu) {
        $this->usu = $usu;
    }

    private function getUsu() {
        return $this->usu;
    }

    private function setUnidad1($unidad1) {
        $this->unidad1 = $unidad1;
    }

    private function getUnidad1() {
        return $this->unidad1;
    }

    private function setCambio($cambio) {
        $this->cambio = $cambio;
    }

    private function getCambio() {
        return $this->cambio;
    }

    private function setMes($mes) {
        $this->mes = $mes;
    }

    private function getMes() {
        return $this->mes;
    }

    private function setAno($ano) {
        $this->ano = $ano;
    }

    private function getAno() {
        return $this->ano;
    }

    private function setAno1($ano1) {
        $this->ano1 = $ano1;
    }

    private function getAno1() {
        return $this->ano1;
    }

    private function setAdmin($admin) {
        $this->admin = $admin;
    }

    private function getAdmin() {
        return $this->admin;
    }

    private function setNunidad($nunidad) {
        $this->nunidad = $nunidad;
    }

    private function getNunidad() {
        return $this->nunidad;
    }

    private function setSalida($salida) {
        $this->salida = $salida;
    }

    private function getSalida() {
        return $this->salida;
    }

    private function setConexion($conexion) {
        $this->conexion = $conexion;
    }

    private function getConexion() {
        return $this->conexion;
    }

    private function converArrayToString($array) {
        $salida = '';
        foreach ($array as $key => $value)
        {
            if ($key == 0)
            {
                $salida .= "'".trim($value)."'";
            }
            $salida .= ", '".trim($value)."'";
        }
        return $salida;
    }

    private function queryUnidades()
    {
        $unidad = $this->getUnidad();
        $compania = $this->getCompania();
        $usu = $this->getUsu();
        $unidad1 = $this->getUnidad1();
        $ano = $this->getAno();
        $admin = $this->getAdmin();
        $nunidad = $this->getNunidad();
        $v1 = explode("_", $usu);
        $v2 = $v1[1];
        if (strpos($v2, "CP") !== false)
        {
            $unidad = $unidad1;
        }
        if (($nunidad == "1") or ($nunidad == "2") or ($nunidad == "3"))
        {
            switch ($admin)
            {
                case '3':
                    $query = "SELECT * FROM cv_rev_pla WHERE unidad IN ($unidad) AND ano='$ano' AND compania!='$compania'";
                    break;
                case '4':
                    $query = "SELECT * FROM cv_rev_pla WHERE unidad IN ($unidad) AND ((tipo='1' AND usuario4='$usu') OR tipo='2') AND ano='$ano'";
                    break;
                case '27':
                    $query = "SELECT * FROM cv_rev_pla WHERE unidad IN ($unidad) AND ((tipo='1' AND usuario3='$usu' AND usuario4='') OR tipo='2') AND ano='$ano'";
                    break;
                case '6':
                case '11':
                    $query = "SELECT * FROM cv_rev_pla WHERE unidad IN ($unidad) AND ano='$ano'";
                    break;
                case '7':
                    $query = "SELECT * FROM cv_rev_pla WHERE unidad IN ($unidad) AND ano='$ano' AND tipo='2'";
                    break;
                default:
                    $query = "SELECT * FROM cv_rev_pla WHERE unidad IN ($unidad) AND ano='$ano'";
                    break;
            }
        }
        else
        {
            switch ($admin)
            {
                case '3':
                    $query = "SELECT * FROM cv_rev_pla WHERE unidad IN ($unidad) AND ano='$ano' AND estado='P' AND usuario!='$usu'";
                    break;
                case '4':
                    $query = "SELECT * FROM cv_rev_pla WHERE unidad IN ($unidad) AND ano='$ano' AND estado IN ('A','D','E','F')";
                    break;
                case '6':
                case '7':
                case '9':
                case '10':
                    $query = "SELECT * FROM cv_rev_pla WHERE unidad IN ($unidad) AND ano='$ano'";
                    break;
                default:
                    $query = "SELECT * FROM cv_rev_pla WHERE unidad IN ($unidad) AND ano='$ano'";
                    break;
            }
        }
        // Log
        $fec_log = date("d/m/Y H:i:s a");
        $file = fopen("log_revi_plan.txt", "a");
        fwrite($file, $fec_log." # ".$query." # ".$usu." # ".$unidad." # ".PHP_EOL);
        fclose($file);
        return $this->retornaGrilla($query);
    }

    private function retornaGrilla($query_total)
    {
        $consulta = $query_total.= $this->operadorConsulta();
        $query2 = str_replace("*", " count(*) total ", $consulta);
        $cur = odbc_exec($this->getConexion(), $query2);
        $row = odbc_fetch_array($cur);
        $nregistros = $row['total'];
        odbc_free_result($cur);
        if ($nregistros > 0)
        {
            $total_pages = ceil($nregistros / $this->getRows());
        }
        else
        {
            $total_pages = 0;
        }
        if ($this->getPage() > $total_pages)
        {
            $this->setPage($total_pages);
        }
        $start = $this->getRows() * $this->getPage() - $this->getRows();
        $limite2 = $this->getRows() * $this->getPage();
        $salida = $this->procesaSalida($query_total, $this->delimitaQuery($consulta, $limite2, $start), $total_pages, $nregistros);
        return $salida;
    }

    private function procesaSalida($query_total, $query, $total_pages, $nregistros)
    {
        $admin = $this->getAdmin();
        $nunidad = $this->getNunidad();
        $respuesta = new stdClass();
        $respuesta->queryTotal = $this->agregaCamposQuery($query_total);
        $respuesta->query = $query;
        $respuesta->page = $this->getPage();
        $respuesta->total = $total_pages;
        $respuesta->records = $nregistros;
        $i = 0;
        $cur = odbc_exec($this->getConexion(), $query);
        if (($nunidad == "1") or ($nunidad == "2") or ($nunidad == "3"))
        {
            while ($row = odbc_fetch_array($cur))
            {
                $respuesta->rows[$i]['id'] = $row['conse'];
                $estado = trim($row['estado']);
                if (($estado == "") or ($estado == "A") or ($estado == "B") or ($estado == "C") or ($estado == "D") or ($estado == "G") or ($estado == "I") or ($estado == "Q") or ($estado == "R") or ($estado == "L") or ($estado == "M") or ($estado == "N") or ($estado == "O") or ($estado == "Y") or ($estado == "W"))
                {
                    $respuesta->rows[$i]['cell'] = $this->retornaArrayCampos1($row);
                }
                else
                {
                    $respuesta->rows[$i]['cell'] = $this->retornaArrayCampos($row);
                }
                $i++;
            }
        }
        else
        {
            while ($row = odbc_fetch_array($cur))
            {
                $respuesta->rows[$i]['id'] = $row['conse'];
                $estado = $row['estado'];
                if (($estado == "P") or ($estado == "A") or ($estado == "B") or ($estado == "D") or ($estado == "E") or ($estado == "G"))
                {
                    $respuesta->rows[$i]['cell'] = $this->retornaArrayCampos($row);
                }
                else
                {
                    $respuesta->rows[$i]['cell'] = $this->retornaArrayCampos1($row);
                }
                $i++;
            }   
        }
        odbc_free_result($cur);
        return $respuesta;
    }

    private function seleccionaReporte()
    {
        $this->setSalida($this->queryUnidades());
    }

    private function delimitaQuery($query, $limite2, $start)
    {
        $consulta_f = "SELECT * FROM (SELECT TOP {$limite2} conse, sigla, compania1, fecha, tipo1, usuario, estado, estado1, link, nada, sigla1, fechas, ROW_NUMBER() over "
                . "         (ORDER BY {$this->getSidx()} {$this->getSord()} ) AS contador "
                . "         FROM " . str_replace("SELECT * FROM", "", $query)
                . "     ) a WHERE contador > {$start}";
        return $consulta_f;
    }

    private function operadorConsulta() {
        $searchField = $this->getSearchField();
        $searchOper = $this->getSearchOper();
        $searchString = $this->getSearchString();
        switch ($searchOper) {
            case "eq": //igual 
                $query = " and {$searchField} = '{$searchString}' ";
                break;
            case "ne": //no igual a
                $query = " and {$searchField} != '{$searchString}' ";
                break;
            case "bw": //empiece por
                $query = " and {$searchField} like '{$searchString}%' ";
                break;
            case "bn": //no empiece por
                $query = " and {$searchField} not like '{$searchString}%' ";
                break;
            case "ew": //termina por
                $query = " and {$searchField} like '%{$searchString}' ";
                break;
            case "en": //no termina por
                $query = " and {$searchField} not like '%{$searchString}' ";
                break;
            case "cn": //contiene
                $query = " and {$searchField} like '%{$searchString}%' ";
                break;
            case "nc": //no contiene
                $query = " and {$searchField} not like '%{$searchString}%' ";
                break;
            case "nu": //is null
                $query = " and {$searchField} is null ";
                break;
            case "nn": //is not null
                $query = " and {$searchField} is not null ";
                break;
            case "in": //está en
                $query = " and {$searchField} in ({$searchString})";
                break;
            case "ni": //no está en
                $query = " and {$searchField} not in ({$searchString})";
                break;
            default :
                $query = "";
        }
        return $query;
    }

    private function camposReporte()
    {
        $cambio = $this->getCambio();
        if ($cambio == "0")
        {
            $campos = array(
                'conse',
                'sigla',
                'compania1',
                'fecha',
                'tipo1',
                'usuario',
                'estado1',
                'link'
            );
        }
        else
        {
            $campos = array(
                'conse',
                'sigla1',
                'compania1',
                'fecha',
                'tipo1',
                'usuario',
                'estado1',
                'link'
            );
        }
        return $campos;
    }

    private function camposReporte1()
    {
        $cambio = $this->getCambio();
        if ($cambio == "0")
        {
            $campos = array(
                'conse',
                'sigla',
                'compania1',
                'fecha',
                'tipo1',
                'usuario',
                'estado1',
                'nada'
            );
        }
        else
        {
            $campos = array(
                'conse',
                'sigla1',
                'compania1',
                'fecha',
                'tipo1',
                'usuario',
                'estado1',
                'nada'
            );
        }
        return $campos;
    }

    private function agregaCamposQuery($query)
    {
        $b = strpos($query, "FROM");
        $a = strripos($query, "SELECT");
        $cadena = "";
        foreach ($this->camposReporte() as $key => $value) {
            if (!is_array($value))
            {
                $campo = $this->camposFecha($value);
                if ($key == 0)
                {
                    $cadena.= $campo;
                }
                else
                {
                    $cadena.= ", " . $campo;
                }
            }
            else
            {
                $campoEspecial = "";
                $n = 0;
                foreach ($value as $key2 => $value2)
                {
                    $campo = $this->camposFecha($value2);
                    if ($n == 0)
                    {
                        $campoEspecial .= "'" . $key2 . "'+" . $campo;
                    }
                    else
                    {
                        $campoEspecial .= "+'" . $key2 . "'+" . $campo;
                    }
                    $n++;
                }
                $cadena.= "," . $campoEspecial;
            }
        }
        $retorna = substr_replace($query, " " . $cadena . " ", $a + 6, $b - 6);
        return $retorna;
    }

    private function retornaArrayCampos($row)
    {
        $arraySalida = array();
        foreach ($this->camposReporte() as $value)
        {
            if (!is_array($value))
            {
                $arraySalida[] = $this->camposLink($value, $row);
            }
            else
            {
                $campoEspecial = "";
                foreach ($value as $key => $value2)
                {
                    $campoEspecial .= $key . utf8_encode(trim($row[$value2]));
                }
                $arraySalida[] = $campoEspecial;
            }
        }
        return $arraySalida;
    }

    private function retornaArrayCampos1($row)
    {
        $arraySalida = array();
        foreach ($this->camposReporte1() as $value)
        {
            if (!is_array($value))
            {
                $arraySalida[] = $this->camposLink($value, $row);
            }
            else
            {
                $campoEspecial = "";
                foreach ($value as $key => $value2)
                {
                    $campoEspecial .= $key . utf8_encode(trim($row[$value2]));
                }
                $arraySalida[] = $campoEspecial;
            }
        }
        return $arraySalida;
    }

    private function camposFecha($campo)
    {
        $valor = strtolower(substr($campo, 0, 8));
        switch ($valor)
        {
            case "fec_tran":
                $salida = "convert(varchar(10), {$campo}, 101 ) as fec_tran";
                break;
            case "fec_reci":
                $salida = "convert(varchar(10), {$campo}, 101 ) as fec_reci";
                break;
            default :
                $salida = $campo;
        }
        return $salida;
    }
    
    private function camposLink($campo, $valorRegistro, $query = FALSE) {
        $valor = strtolower(substr($campo, 0, 4));
        switch ($valor) {
            case "link":
                $salida = $this->formatoLink($query, $campo, $valorRegistro);
                break;
            default :
                if ($query)
                {
                    $salida = $campo;
                }
                else
                {
                    $salida = utf8_encode(trim($valorRegistro[$campo]));
                }
        }
        return $salida;
    }

    private function formatoLink($query, $campo, $valor)
    {
        $ano = $this->getAno();
        switch ($campo)
        {
            case "link":
                $salida = "<center><a href='apli_plan.php?ano=$ano&conse={$valor[$campo]}' class='btn btn-info btn-xs'>Aplicar Revisión</a></center>";
                break;
        }
        return $salida;
    }
}
// 10/08/2023 - Ajuste de cambio de sigla validando la fecha actual