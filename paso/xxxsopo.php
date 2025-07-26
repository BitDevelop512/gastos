<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');

/*
$firmas = "SP. WILSON DE JESUS SANCHEZ SAN MARTINÂ»SUBOF PLANEACIÓN Y DIRECCIONAMIENTO PPTAL ADMINISTRATIVO|CR. DALADIER ARMANDO URBINA PARRAÂ»DIRECTOR ADMINISTRATIVO DE INTELIGENCIA Y C/I|CR. WALTER IVAN BORRE TRONCOSOÂ»JEFE DEPARTAMENTO DE INTELIGENCIA Y C/I CEDE2";

echo $firmas."<hr>";

$num_firmas = explode("|",$firmas);
$contador = count($num_firmas);
for ($i=0; $i<$contador; ++$i)
{
    $paso = $num_firmas[$i];
    $num_firmas1 = explode("»",$paso);
    $v1 = $num_firmas1[0];
    $v2 = $num_firmas1[1];
    echo $v1." - ".$v2."<br><br>";
}
echo "<hr><hr>";

$contador = count($num_firmas);
$j = $contador-1;
for ($i=0; $i<=$contador-1; ++$i)
{
    $paso = $num_firmas[$j];
    $num_firmas1 = explode("»",$paso);
    $v1 = $num_firmas1[0];
    $v2 = $num_firmas1[1];
    echo $v1." - ".$v2."<br><br>";
    $j--;
}
*/


//echo date('Y/m/d H:i:s');

//echo "<hr>";

/*

$i = 1;
$ppp = substr($key, ($i % strlen($key))-1, 1);

echo $ppp;
*/

//$planes = "tLSssK6n75qTl6SjlZeRoqGZl4Q=";
//maugoIiemqKXkZmfkKCRpZqVjpqqo5CTiKuooY4=";
//echo $planes."<hr><hr>";
//$planes1 = decrypt1($planes, $llave);
//echo $planes1;




//$clave = "Cx2022*+";
//$clave = "Diadi2022*";
//$clave = "Cede2022*";
//$clave1 = md5($clave);
//echo $clave1."<hr>";



//    $paso = "jaime.morales@cxcomputers.com";
//    $valida1 = strpos($paso, "@cxcomputers");
//    $valida1 = intval($valida1);
//    echo $valida1."<hr>";


//update cx_usu_web set clave='d185df5dae4a6d03510c77258845fa6d'
//update cx_usu_web set activo=0


/*
$query = "SELECT conse, usuario, unidad, fecha, motivo FROM cx_pla_rev WHERE ano='0' ORDER BY fecha DESC";
$sql = odbc_exec($conexion,$query);
$i = 0;
while ($i < $row = odbc_fetch_array($sql))
{
    $conse = $row['conse'];
    $usuario = trim($row['usuario']);
    $unidad = $row['unidad'];
    $fecha = substr($row["fecha"],0,4);
    $ano = intval($fecha);
    $motivo = $row['motivo'];
    $motivo = iconv("UTF-8", "ISO-8859-1", $motivo);
    $query1 = "UPDATE cx_pla_rev SET ano='$ano', motivo='$motivo' WHERE conse='$conse' AND usuario='$usuario' AND unidad='$unidad' AND ano='0'";
    $sql1 = odbc_exec($conexion,$query1);
    $i++;
}
*/


//$clave = "Sigar2021";
//$clave1 = md5($clave);
//echo $clave1."<hr>";

//$ip = $_SERVER['HTTP_CLIENT_IP'];
//$ip = $_SERVER['REMOTE_ADDR'];
//echo $ip."<hr>";

/*
$query = "SELECT datos FROM cx_com_egr WHERE unidad=1 AND ano=2021 AND egreso=108";
$sql = odbc_exec($conexion,$query);
$planes = odbc_result($sql,1);
echo $planes;
*/


//$planes = "maSbjo2ZpJqOhJmlmZmTmZ+bl5Okmg==";
//$planes = decrypt1($planes, $llave);
//echo $planes."<br>";


//$plan1 = "'12','11'#'2022','2022'";
//$plan1 = encrypt1($plan1, $llave);
//echo $plan1."<hr>";


//$v1 = "2022|2022|2021|";

//$num_v1 = explode("|",$v1);
//$paso10 = "";
//for ($i=0;$i<count($num_v1)-1;++$i)
//{
//  $per[$i] = $num_v1[$i];
//  $paso10 .= "'".$per[$i]."',";
//}
//$paso10 = substr($paso10, 0, -1);
//echo $paso10."<br>";
//echo "<hr>";

//$paso10 = str_replace("|","',",$v1);
//$paso10 = substr($paso10, 0, -1);
//$paso10 = "'".$paso10;

//echo $paso10;

//$query1 = "SELECT COUNT(1) AS registrados FROM cx_pla_gas WHERE conse1 IN ($planes) AND ano=2021";
//echo $query1."<hr>";
//$sql1 = odbc_exec($conexion,$query1);
//$registrados = odbc_result($sql1,1);

//echo $planes." - ".$registrados;

//phpinfo();




//$planes = "maSdmZOZn5CYlaSmkA==";
//$planes1 = decrypt1($planes, $llave);
//echo $planes1."<hr>";



//$plan = "DIV08|8,000,000.00#";
//$plan1 = encrypt1($plan, $llave);
//echo $plan1."<hr>";


//$plan = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
//$plan1 = encrypt1($plan, $llave);
//echo $plan1."<hr>";


/*
$query = "SELECT TOP 100 unidad, ano, numero, consecu, conse FROM cx_inf_eje WHERE ano='2021' ORDER BY fecha DESC";
$sql = odbc_exec($conexion,$query);
$i = 0;
while ($i < $row = odbc_fetch_array($sql))
{
    $unidad = $row['unidad'];
    $ano = $row['ano'];
    $numero = $row['numero'];
    $consecu = $row['consecu'];
    $conse = $row['conse'];
    $query1 = "SELECT factor FROM cx_pla_gas WHERE conse1='$consecu' AND interno='$numero' AND unidad='$unidad' AND ano='$ano'";
    $sql1 = odbc_exec($conexion,$query1);
    $factor = odbc_result($sql1,1);
    $query2 = "SELECT nombre FROM cx_ctr_fac WHERE codigo IN ($factor)";
    $sql2 = odbc_exec($conexion,$query2);
    $j = 0;
    $n_factor = "";
    while ($j < $row = odbc_fetch_array($sql2))
    {
        $n_factor .= utf8_encode(odbc_result($sql2,1)).", ";
        $j++;
    }
    $n_factor = substr($n_factor, 0, -2);
    // Se actualiza factor
    $query3 = "UPDATE cx_inf_eje SET factor='$n_factor' WHERE conse='$conse' AND unidad='$unidad' AND consecu='$consecu' AND numero='$numero' AND ano='$ano' AND factor=''";
    $sql3 = odbc_exec($conexion,$query3);
    $query4 = "SELECT ordop FROM cx_pla_inv WHERE unidad='$unidad' AND conse='$consecu' AND ano='$ano'";
    $sql4 = odbc_exec($conexion,$query4);
    $ordop = odbc_result($sql4,1);
    $n_ordop = decrypt1($ordop, $llave);
    $n_ordop = strtr(trim($n_ordop), $sustituye);
    $n_ordop = iconv("UTF-8", "ISO-8859-1", $n_ordop);
    // Se actualiza ordop
    $query5 = "UPDATE cx_inf_eje SET ordop='$n_ordop' WHERE conse='$conse' AND unidad='$unidad' AND consecu='$consecu' AND numero='$numero' AND ano='$ano'";
    $sql5 = odbc_exec($conexion,$query5);
    $i++;
}
*/





//select * from cx_inf_eje where unidad=60 order by fecha desc
//select * from cx_pla_gas where conse1=5312 and ano=2021 and unidad=60
//select * from cx_pla_inv where conse=5312 and ano=2021 and unidad=60

//$dias = getDiasHabiles('2021-07-12', '2021-07-23');
//var_dump($dias);
//$dias1 = count($dias);
//echo "<hr>";
//.$dias1;



//$date_now = date('Y-m-d');
//$date_past = strtotime('-140 day', strtotime($date_now));
//$date_past = date('Y-m-d', $date_past);
//$date_past = "2021-01-01";

//echo $date_now." - ".$date_past;
//echo "<br><br>";

//$dias = getDiasHabiles($date_past, $date_now);
//var_dump($dias);
//$dias1 = count($dias);
//echo "<hr>";
//.$dias1;


//$alea = "9D50A";
//$conse = "1560";
//$valor3 = $alea.$conse;
//$valor4 = encrypt1($valor3, $llave);
//$nom_pdf = "ver_soli.php?val=".$valor4;
//echo $nom_pdf."<br>";




//$valor5 = "9D50A1560";
//$valor = "vMi3sLA=";
//$valor1 = decrypt1($valor, $llave);
//echo $valor." - ".$valor1."<br>";

//$val = "q7eel6KjqJ+X";
//$valor7 = trim(decrypt1($val, $llave));
//echo $valor7;


//$firmas = 's6yZm5ottri0osC3qrW1t5Ostq7CtDo0opK5vqyvxri8h6nHwKq1osWTq6iqv7yh46Knqp6dHMG5sqqqs7+Jq6aSwrmss7O2sravt8aJqaK7wLKf3bOonp2TLba4tKLAt6q1tbeTq6iqv7yh4w==';
//$firmas = 'tbSytKruq6CTlaeqlZyRoqGZl4S1tKywru6knZOSpqOVl5GioZmXhLTFsrSqo++cmJaeppmZjaOqoZWRoparuaq/vJvjlaSjlZ6YqZ+bnZKgo5mKo8S2srSS7qWioI2rpZ6Tk6mjl5eRlbW7qqq/peWZk6SfnJyanqWZn4+io4yrqsijmuOWpZ+enJGeo5mXj6KjjKuqyKOb45qpn6GXkZ6jmZePoqOMq6rIo5zjmqufnpeRnqOZl4+io4yrqsijneOUqJ+ZmZGeo5mXj6KjjKuqyKOe45mjn5mXkZ6jmZePoqOMq6rIo5/jlqKfmp+RnqOZl4+io4yrqsijoOOZqJ+enZaeo5mXj6KjjKuqyKOh45Wqn6GdmJ6knZiPoqOMq6rIua7jlZ6rmqCNpKOZlZGilq+8pcS0muOSpZ+Zl5Geo5mXj6KjjK22tsWqmd2jppWXkaKfmZeRoKOZiqS3tuWYkZ6jmZeNoqOZlZGilqyssO6km5ORoqOVl5GioZmXhLa0v6ii7qSfk5mlo5WXkaKhmZeE';

//$valor = "tbSytKruq6CTlaeqlZyRoqGZl4S1tKywru6knZOSpqOVl5GioZmXhLTFsrSqo++cmJaeppmZjaOqoZWRopY=";
//$valor = trim(decrypt1($valor, $llave));
//$valor = utf8_encode($firmas1);
//echo $valor;
//echo "<hr>";

//$unidades = 'CAIMI|87,457,500.00#CACIM|14,140,000.00#BRIMI1|315,302,178.00#';
//$unidades1 = trim(encrypt1($unidades, $llave));
//$unidades1 = utf8_encode($unidades1);
//echo $unidades1;





//$ordop = 'BICENTENARIO "HÉROES DE LA LIBERTAD"';
//$ordop1 = iconv("UTF-8", "ISO-8859-1", $ordop);
//$ordop1 = trim(utf8_encode($ordop1));
//$ordop1 = encrypt1($ordop1, $llave);
//echo $ordop1."<hr>";

//$ordop2 = iconv("UTF-8", "ISO-8859-1", $ordop);
//$ordop2 = strtoupper($ordop2);
//$ordop2 = trim(utf8_encode($ordop2));
//$ordop2 = encrypt1($ordop2, $llave);
//echo $ordop2."<hr>";


//$query = "create view cv_cdp_dis
//as
//SELECT valor1 as valor, recurso1 as recurso, 
//(SELECT SUM(valor1) FROM dbo.cx_apro_dis WHERE cx_apropia.recurso1=cx_apro_dis.recurso1 and tipo='A'
//GROUP BY conse1, tipo, recurso1 ) as adicion,
//(SELECT SUM(valor1) FROM dbo.cx_apro_dis WHERE cx_apropia.recurso1=cx_apro_dis.recurso1 and tipo='R'
//GROUP BY conse1, tipo, recurso1 ) as reduccion
//FROM cx_apropia
//union
//select 0 as valor,
//(SELECT recurso1 FROM dbo.cx_apro_dis WHERE cx_apropia.recurso1!=cx_apro_dis.recurso1 GROUP BY recurso1) as recurso,
//ISNULL((SELECT SUM(valor1) FROM dbo.cx_apro_dis WHERE cx_apropia.recurso1!=cx_apro_dis.recurso1 and tipo='A'
//GROUP BY conse1, tipo, recurso1),0) as adicion,
//ISNULL((SELECT SUM(valor1) FROM dbo.cx_apro_dis WHERE cx_apropia.recurso1!=cx_apro_dis.recurso1 and tipo='R'
//GROUP BY conse1, tipo, recurso1),0) as reduccion
//FROM cx_apropia";
//$sql = odbc_exec($conexion,$query);

//$query = "create table cx_pla_rev (conse int default 0, fecha datetime default getdate(), usuario char(15) default '', unidad int default 0, estado char(1) default '', motivo text default '', ano int default 0)";
//$sql = odbc_exec($conexion,$query);

//$query1 = "create table cx_apropia (conse int default 0, fecha datetime default getdate(), valor char(30) default '0.00', valor1 numeric(20,2) default 0, ano int default 0, usuario char(15) default '', saldo numeric(20,2) default 0, fecha1 char(10) default '', destino char(100) default '', recurso int default 0, rubro int default 0, recurso1 char(10) default '', rubro1 char(10) default '')";
//$sql = odbc_exec($conexion,$query1);

//$query2 = "create table cx_apro_dis (conse int default 0, conse1 int default 0, fecha datetime default getdate(), valor char(30) default '0.00', valor1 numeric(20,2) default 0, tipo char(1) default '', usuario char(15) default '', fecha1 char(10) default '', recurso int default 0, rubro int default 0, recurso1 char(10) default '', rubro1 char(10) default '')";
//$sql = odbc_exec($conexion,$query2);

//ALTER TABLE cx_com_egr DROP CONSTRAINT [DF__cx_com_eg__num_a__649028E8]
//alter table cx_com_egr alter column num_auto char(150)


//function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
//    $fechainicio = strtotime($fechainicio);
//    $fechafin = strtotime($fechafin);
//    $diainc = 24*60*60;
//    $diashabiles = array();
//    for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc)
//    {
//        if (!in_array(date('N', $midia), array(6,7)))
//        {
//			if (!in_array(date('Y-m-d', $midia), $diasferiados))
//			{
//				array_push($diashabiles, date('Y-m-d', $midia));
//			}
//		}
//	}
//	return $diashabiles;
//}
//$dias = getDiasHabiles('2021-07-01', '2021-07-31', [ '2021-07-20', '2021-08-07', '2021-08-16', '2021-10-12' ]);
//var_dump($dias);
//$dias1 = count($dias);
//echo "<hr>".$dias1;

/*
        $v_unidad = "BRCIM1";
        $pregunta = "SELECT total, datos FROM cx_com_egr WHERE unidad='1' AND periodo BETWEEN '$periodo1' AND '$periodo2' AND ano='$ano' ORDER BY fecha ASC";
        $cur = odbc_exec($conexion, $pregunta);
        $i = 0;
        $v_total = 0;
        while($i<$row=odbc_fetch_array($cur))
        {

            $datos = $row['datos'];
            $datos1 = decrypt1($datos, $llave);
            $var_ocu = explode("#", $datos1);
            for ($j=0;$j<count($var_ocu)-1;++$j)
            {
                $paso = $var_ocu[$j];

                $var_ocu1 = explode("|", $paso);
                $paso1 = trim($var_ocu1[0]);
                $paso2 = trim($var_ocu1[1]);
                $v_valor1 = str_replace(',','',$paso2);
                $v_valor1 = trim($v_valor1);
                $v_valor1 = floatval($v_valor1);


                if ($paso1 == $v_unidad)
                {
                    echo $paso1." - ".$v_valor1."<br>";

                    $v_total = $v_total+$v_valor1;


                }


            }

            //echo "***************<hr>";
            //echo "<hr";
            //echo $datos1."<br>";

            $i++;
        }

        echo $v_total."<hr>";
*/                    

?>



<!--
<style>.grafico { position: relative; width: 200px; border: 1px solid #B1D632; padding: 2px; } .grafico .barra { display: block; position: relative; background: #B1D632; text-align: center; color: #333; height: 2em; line-height: 2em; } .grafico .barra span { position: absolute; left: 1em; }</style>


    <div class='grafico'><strong class='barra' style='width: 24%;'>24%</strong></div><br>
    <div class='grafico'><strong class='barra' style='width: 57%;'>57%</strong></div>






<script type="application/javascript" src="http://jsonip.appspot.com/?callback=getip"></script>

<script type="text/javascript">
    var ip = location.host;
    //alert(ip);

   function getip(json){
    //  alert(json.ip); // alerts the ip address
    }


</script>
