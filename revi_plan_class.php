<?php
class ConsultaClass
{
    private $unidad;
    private $compania;
    private $usu;
    private $mes;
    private $ano;
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
        $this->setMes($post['mes']);
        $this->setAno($post['ano']);
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
        foreach ($array as $key => $value) {
            if ($key == 0) {
                $salida.= "'" . trim($value) . "'";
            }
            $salida.=", '" . trim($value) . "'";
        }
        return $salida;
    }

    private function query()
    {
        $unidad = $this->getUnidad();
        $compania = $this->getCompania();
        $usu = $this->getUsu();
        $mes = $this->getMes();
        if (($mes == "1") or ($mes == "12"))
        {
            $mes1 = $mes;
        }
        else
        {
            $mes1 = $mes-1;
        }
        $ano = $this->getAno();
        $admin = $this->getAdmin();
        $nunidad = $this->getNunidad();
        if (($nunidad == "1") or ($nunidad == "2") or ($nunidad == "3"))
        {
            switch ($admin)
            {
                case '3':
                    $query="select * from cv_rev_pla where unidad in ($unidad) and periodo=$mes and ano=$ano and compania!=$compania";
                    break;
                case '4':
                case '11':
                    $query="select * from cv_rev_pla where unidad in ($unidad) and ((tipo='1' and periodo=$mes) or (tipo='2' and periodo=$mes1)) and ano=$ano";
                    break;
                case '7':
                    $query="select * from cv_rev_pla where unidad in ($unidad) and periodo=$mes1 and ano=$ano and tipo=2";
                    break;
                default:
                    break;
            }
        }
        else
        {
            switch ($admin)
            {
                case '3':
                    $query="select * from cv_rev_pla where unidad in ($unidad) and periodo=$mes and ano=$ano and estado='P' and usuario!='$usu'";
                    break;
                case '4':
                    $query="select * from cv_rev_pla where unidad in ($unidad) and periodo=$mes and ano=$ano and estado in ('A','D','E','F')";
                    break;
                case '6':
                case '7':
                case '9':
                    $query="select * from cv_rev_pla where unidad in ($unidad) and periodo=$mes and ano=$ano";
                    break;
                default:
                    break;
            }
        }
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
                switch ($row['estado'])
                {
                    case ' ':
                    case 'A':
                    case 'B':
                    case 'C':
                    case 'D':
                    case 'R':
                        $respuesta->rows[$i]['cell'] = $this->retornaArrayCampos1($row);
                        break;
                    default:
                        $respuesta->rows[$i]['cell'] = $this->retornaArrayCampos($row);
                        break;
                }
                $i++;
            }
        }
        else
        {
            while ($row = odbc_fetch_array($cur))
            {
                $respuesta->rows[$i]['id'] = $row['conse'];
                switch ($row['estado'])
                {
                    case 'P':
                    case 'A':
                    case 'B':
                    case 'D':
                    case 'E':
                        $respuesta->rows[$i]['cell'] = $this->retornaArrayCampos($row);
                        break;
                    default:
                        $respuesta->rows[$i]['cell'] = $this->retornaArrayCampos1($row);
                        break;
                }
                $i++;
            }   
        }
        odbc_free_result($cur);
        return $respuesta;
    }

    private function seleccionaReporte()
    {
        $this->setSalida($this->query());
    }

    private function delimitaQuery($query, $limite2, $start) {
        $consulta_f = "select * from"
                . "     (select top {$limite2} conse, sigla, compania1, fecha, tipo1, usuario, estado, estado1, link, ROW_NUMBER()over "
                . "         (order by {$this->getSidx()} {$this->getSord()} ) as contador "
                . "         from " . str_replace("select * from", "", $query)
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
        return $campos;
    }

    private function camposReporte1()
    {
        $campos = array(
            'conse',
            'sigla',
            'compania1',
            'fecha',
            'tipo1',
            'usuario',
            'estado1',
            ''
        );
        return $campos;
    }

    private function agregaCamposQuery($query)
    {
        $b = strpos($query, "from");
        $a = strripos($query, "select");
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
                foreach ($value as $key2 => $value2) {
                    $campo = $this->camposFecha($value2);
                    if ($n == 0) {
                        $campoEspecial .= "'" . $key2 . "'+" . $campo;
                    } else {
                        $campoEspecial .= "+'" . $key2 . "'+" . $campo;
                    }
                    $n++;
                }
                $cadena.= "," . $campoEspecial;
            }
        }
        return substr_replace($query, " " . $cadena . " ", $a + 6, $b - 6);
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
        switch ($campo)
        {
            case "link":
                $salida = "<center><a href='apli_plan.php?conse={$valor[$campo]}' class='btn btn-info btn-xs'>Aplicar Revisión</a></center>";
                break;
        }
        return $salida;
    }
}
