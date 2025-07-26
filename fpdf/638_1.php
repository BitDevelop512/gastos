<?php
/* 638_1.php
   FO-JEMPP-CEDE2-638-1 Plan de Inversión Gastos Reservados. (consolidado)
   (pág 72 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	01/01/2023 - Se hace cambio entre SECRETO/ULTRASECRETO según el Nivel. Consuelo Martínez
	01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub. Jorge Clavijo
	03/05/2023 - Se vuelve a activar que se muestren los bienes adquiridosa solicitud de Jorge Clavijo.
	27/05/2024 - Se revisa y ajusta la presencia del caracter "Á" en las firmas, ahora puede no venir incluido. Jorge Clavijo
*/

session_start();
error_reporting(0);
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
	define('FPDF_FONTPATH','font/');
	require('rotar.php');

	class PDF extends PDF_Rotate
	{
		function Header()
		{
			require('../conf.php');
			require('../permisos.php');

			//01/01/2023 - Se hace cambio entre SECRETO/ULTRASECRETO según el Nivel.
			//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
			$consulta = "select * from cv_unidades where subdependencia='$uni_usuario'";
			$cur = odbc_exec($conexion,$consulta);
			$sigla = trim(odbc_result($cur1,4));
				
			$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$uni_usuario."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = trim(odbc_result($cur1,1));
			$sigla1 = trim(odbc_result($cur1,3));
			$nom1 = trim(odbc_result($cur1,4));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
			if ($sigla1 <> "") if ($fecha_pi >= $fecha_os) $sigla = $sigla1;

			$consulta2 = "select * from cx_pla_inv where unidad = '".$uni_usuario."' and ano='".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
			$cur2 = odbc_exec($conexion,$consulta2);
			$nivel = trim(odbc_result($cur2,56));
			if ($nivel == 1 or $nivel == "") $msg = "SECRETO";
			else $msg = "ULTRASECRETO";

			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			$this->RotatedText(55,200,$sigla,35);

			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,150,150);
			$this->Cell(190,5,$msg,0,1,'C');
			$this->Ln(2);

			$this->Image('sigar.png',10,17,17);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(0,0,0);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(125,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(8,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(55,5,'PLAN DE INVERSIÓN',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-638',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'GASTOS RESERVADOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'0',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(125,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2017-05-16',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,3,'',0,0,'C',0);
			$this->Cell(125,3,'CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(26,3,'',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,3,'',0,1,'');

			$this->RoundedRect(9,15,91,26,0,'');
			$this->RoundedRect(100,15,50,26,0,'');
			$this->RoundedRect(150,15,51,26,0,'');
			$this->RoundedRect(9,15,192,268,0,'');

			$this->Ln(4);
		}//Header

		function RotatedText($x,$y,$txt,$angle)
		{
    		$this->Rotate($angle,$x,$y);
    		$this->Text($x,$y,$txt);
			$this->Rotate(0);
		}//RotatedText
		
		function RoundedRect($x,$y,$w,$h,$r,$style='')
		{
			$k = $this->k;
  			$hp = $this->h;
  			if($style=='F')
  			$op='f';
  			elseif($style=='FD' or $style=='DF')
    			$op='B';
  			else
				$op='S';
			$MyArc = 4/3 * (sqrt(2) - 1);
  			$this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));
  			$xc = $x+$w-$r ;
  			$yc = $y+$r;
  			$this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));
  			$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
  			$xc = $x+$w-$r ;
  			$yc = $y+$h-$r;
  			$this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
  			$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
  			$xc = $x+$r ;
  			$yc = $y+$h-$r;
  			$this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
  			$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
  			$xc = $x+$r ;
  			$yc = $y+$r;
  			$this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
  			$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
  			$this->_out($op);
		}//RoundedRec

		function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
		{
  			$h = $this->h;
  			$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
  			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
		}//Arc

		function Footer()
		{
			require('../conf.php');
			$conse = $_GET['conse'];
			$ano = $_GET['ano'];
			
			$consulta2 = "select * from cx_pla_inv where unidad = '".$uni_usuario."' and ano='".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
			$cur2 = odbc_exec($conexion,$consulta2);
			$nivel = trim(odbc_result($cur2,56));
			if ($nivel == 1 or $nivel == "") $msg = "SECRETO";
			else $msg = "ULTRASECRETO";
		
  			$fecha1=date("d/m/Y H:i:s a");
  			$this->SetY(-10);
  			$this->SetFont('Arial','',7);
  			$this->Cell(190,4,'SIGAR1 - '.$fecha1,0,1,'');
  			$this->Ln(-4);
  			$this->SetFont('Arial','B',8);
  			$this->SetTextColor(255,150,150);
   			$this->Cell(190,5,$msg,0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR';
  			$this->Code39(182,285,$cod_bar,.5,5);
		}//Footer
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');

	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');	
	$sum_totalG = 0;
    $ano = $_GET['ano'];
    $periodo = $_GET['periodo'];
    $periodo1 = $periodo-1;
	if (!empty($_GET['contador'])) $contador = $_GET['contador'];
	else $contador = "0";
	$linea = str_repeat("_",122);

	$consulta0 = "select * from cx_org_sub where subdependencia='$uni_usuario'";
	$cur0 = odbc_exec($conexion,$consulta0);
	$unic = trim(odbc_result($cur0,8));
	$var_uni = trim(odbc_result($cur0,4));
	$lugar_uni  = trim(odbc_result($cur0,5));
	
	//Control para el cambio de sigla
	$sigla1 = trim(odbc_result($cur0,41));
	$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur0,43)),0,10));	
	
	if ($adm_usuario == "6")
	{
		$query = "select dependencia from cx_org_sub where subdependencia='".$uni_usuario."'";
		$cur1 = odbc_exec($conexion,$query);
		$n_depen = odbc_result($cur1,1);

		$query1 = "select subdependencia from cx_org_sub where dependencia='$n_depen' order by dependencia, subdependencia";
      	$cur1 = odbc_exec($conexion, $query1);
		$numero = "";

      	while($i<$row=odbc_fetch_array($cur1))
		{
		    $numero.="'".odbc_result($cur1,1)."',";
		}   //while
		$numero = substr($numero,0,-1);
		$consulta = "select * from cx_pla_inv where unidad in ($numero) and periodo='".$periodo."' and ano='".$ano."' and tipo='1' and estado not in ('','X','Y') order by conse";
	}
	else
	{
		if ($unic == 2 or $unic == 3) $consulta = "select * from cx_pla_inv where unidad='".$uni_usuario."' and periodo='".$periodo."' and ano='".$ano."' and tipo='1' and estado not in ('','X','Y') order by conse";
		else $consulta = "select * from cx_pla_inv where unidad='".$uni_usuario."' and periodo='".$periodo."' and ano='".$ano."' and tipo='1' and estado = 'A' order by conse";
	}   //if
	$cur = odbc_exec($conexion,$consulta);
	$fecha = substr(odbc_result($cur,2),0,10);
	$n_periodo = $n_meses[odbc_result($cur,9)-1];
	
	//Control para el cambio de sigla
	$fecha_pi = str_replace("/", "-", substr($fecha,0,10));
	if ($sigla1 <> "") if ($fecha_pi >= $fecha_os) $var_uni = $sigla1;	

	$actual=$pdf->GetY();
	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',8);	
	$pdf->RoundedRect(9,$actual-3,192,20,0,'');
	$pdf->Ln(-2);	
	$pdf->Cell(50,5,'Unidad/Dependencia /Sección Int/Ci',0,0,'');
	$pdf->Cell(50,5,$var_uni,0,0,'');
	$pdf->Cell(91,5,'DE USO EXCLUSIVO',0,1,'R');			
	$pdf->Cell(25,5,'Lugar y Fecha',0,0,'');
	$pdf->Cell(105,5,$lugar_uni.'   '.$fecha,0,0,'');
	$pdf->Cell(20,5,'No.',0,0,'');
	$pdf->Cell(40,5,'',0,1,''); 
	$pdf->Cell(50,5,'Periodo de empleo de los recursos',0,0,'');
	$pdf->Cell(140,5,$n_periodo,0,1,'');

	$cur = odbc_exec($conexion,$consulta);
	$u = 1;
	while($u<$row=odbc_fetch_array($cur))
	{
 		$consecu = odbc_result($cur,1);
		$fecha = substr(odbc_result($cur,2),0,10);
		$usuario = trim(odbc_result($cur,3));
		$subdependencia = trim(odbc_result($cur,4));		
		$lugar = trim(odbc_result($cur,6));
		$lugar = trim(decrypt1($lugar, $llave));
		$factor = odbc_result($cur,7);

		$factor = explode(",",odbc_result($cur,7));
		$fact_sel = "";
		for ($i=0;$i<count($factor);++$i)
		{
			$fact_sel = $fact_sel."'".trim($factor[$i])."',";
		}   //for
		$fact_sel = substr($fact_sel,'0',-1);
		
		$consulta1 = "select nombre from cx_ctr_fac where codigo in (".$fact_sel.") order by codigo";
		$cur1 = odbc_exec($conexion,$consulta1);
		$n_factor = "";
		$a = 0;
		while($a<$row=odbc_fetch_array($cur1))
		{
			$n_factor = $n_factor.trim(odbc_result($cur1,1)).", ";
			$a++;
		}   //while
		$n_factor = substr($n_factor,'0',-1);
  
		$inc = $i;
		$estructura = explode(",",odbc_result($cur,8));
		$estruc_sel = "";
		for ($i=0;$i<count($estructura);++$i)
		{
			$estruc_sel = $estruc_sel."'".trim($estructura[$i])."',";
		}   //for
		
		if ($inc < $i) $inc = $i;
		$estruc_sel = substr($estruc_sel,'0',-1);
		
		$consulta2 = "select nombre from cx_ctr_est where codigo in (".$estruc_sel.") order by codigo";
		$cur2 = odbc_exec($conexion,$consulta2);
		$n_estructura1 = "";
		$a = 0;
		while($a<$row=odbc_fetch_array($cur2))
		{
			$n_estructura1 = $n_estructura1.trim(odbc_result($cur2,1)).", ";
			$a++;
		}   //while
		$n_estructura1 = substr($n_estructura1,'0',-1);

		$n_periodo = $n_meses[odbc_result($cur,9)-1];
		if ($periodo < 12) $n_periodo = $n_periodo." - ".$n_meses[odbc_result($cur,9)];
		
		$oficiales = odbc_result($cur,10);
		$suboficiales = odbc_result($cur,11);
		$auxiliares = odbc_result($cur,12);
		$soldados = odbc_result($cur,13);

		$ordop = odbc_result($cur,14);
		$ordop = trim(decrypt1($ordop, $llave));
		$n_ordop = odbc_result($cur,15);
		$n_ordop = trim(decrypt1($n_ordop, $llave));
		$ordop = $n_ordop." - ".$ordop;
		$misiones = odbc_result($cur,16);
		$misiones = trim(decrypt1($misiones, $llave));
		$misiones = str_replace('|',' - ',$misiones);
		$misiones = substr($misiones,0,-2);
		$n_misiones = odbc_result($cur,17);

		$oms = odbc_result($cur,23);
		$consulta10 = "select nombre from cx_ctr_oms where codigo in (".$oms.")";
		$cur10 = odbc_exec($conexion,$consulta10);
		$n_oms = "";
		$a = 0;
		while($a<$row=odbc_fetch_array($cur10))
		{
			$n_oms = $n_oms.trim(odbc_result($cur10,1))." - ";
			$a++;
		}   //while
		$n_oms = substr($n_oms,'0',-2);

		$compania = odbc_result($cur,24);
		$consulta11 = "select nombre from cx_org_cmp where conse='$compania'";
		$cur11 = odbc_exec($conexion,$consulta11);
		$n_compania = trim(odbc_result($cur11,1));
		$unidad = trim(odbc_result($cur,4));

		$consulta12 = "select * from cx_org_sub where subdependencia='$unidad'";
		$cur12 = odbc_exec($conexion,$consulta12);
		$var_1 = odbc_result($cur12,1);  
		$var_2 = odbc_result($cur12,2);  
		$var_uni = trim(odbc_result($cur12,4));
		$lugar_uni  = trim(odbc_result($cur12,5));
		$consulta16 = "select nombre from cx_usu_web where usuario='$usuario'";
		$cur16 = odbc_exec($conexion,$consulta16);
		$unidad = trim(odbc_result($cur,4)); 
		 
		$consulta1 = "select sigla,nombre, sigla1, fecha from cx_org_sub where subdependencia='$unidad'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$sigla = odbc_result($cur1,1);  
		$nombre = odbc_result($cur1,2); 
		$nombre = strtr(trim($nombre), $sustituye);
		$nombre = substr($nombre,0,40).".";
		$sig_usuario = $sigla;
		$bat_usuario = $nombre;
		
		//Control para el cambio de sigla
		$sigla1 = trim(odbc_result($cur1,3));
		$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,4)),0,10));
		if ($sigla1 <> "") if ($fecha_pi >= $fecha_os) $var_uni = $sigla1;	

		$actual=$pdf->GetY();
		if ($actual>=259.00125) $pdf->addpage();
		
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(50,5,'ESPECIFICACIÓN DE NECESIDADES GASTOS RESERVADOS',0,1,'');
		$pdf->Ln(1);
		$pdf->SetFont('Arial','',8);
		$pdf->RoundedRect(9,$actual+5,192,29,0,'');		
		$pdf->Cell(60,5,'1. UNIDAD, DEPENDENCIA O SECCIÓN',0,0,'');
		$pdf->Cell(75,5,$n_compania." - ".$var_uni,0,0,'');
		$pdf->Cell(55,5,'1.1 ORGANIZACIÓN '.$oficiales." - ".$suboficiales."- ".$soldados." - ".$auxiliares,0,1,'');
		$pdf->Cell(18,5,'1.2 ORDOP',0,0,'');
		$pdf->Cell(70,5,utf8_decode($ordop),0,1,'');
		$pdf->Cell(50,5,'1.3 MISIÓN DE TRABAJO DE INT/CI',0,0,'');
		$pdf->Cell(85,5,utf8_decode($misiones).' ('.$n_misiones.') ',0,1,'');
		$pdf->Cell(50,5,'1.4 Blanco de alta retribución',0,0,'');
		$pdf->Cell(85,5,$n_oms,0,1,'');
		$pdf->Cell(190,5,'1.5 GASTOS EN ACTIVIDADES DE INTELIGENCIA O CONTRAINTELIGENCIA',0,1,'');

		$pdf->Ln(2);
		$actual=$pdf->GetY();		
		$pdf->RoundedRect(9,$actual+1,12,7,0,'');
		$pdf->RoundedRect(21,$actual+1,127,7,0,'');
		$pdf->RoundedRect(148,$actual+1,53,7,0,'');			
		$pdf->Ln(2);
		$pdf->Cell(10,5,'ÍTEM',0,0,'C');
		$pdf->Cell(125,5,'CONCEPTO',0,0,'C');
		$pdf->Cell(55,5,'V/R SOLICITADO',0,1,'C');		
		$pdf->Ln(2);

		$consulta3 = "select * from cx_pla_gas where unidad='".$unidad."' and conse1='".$consecu."' and ano='$ano' order by conse, interno";
		$cur3 = odbc_exec($conexion,$consulta3);
		$valort = 0;
		$i = 1;
		while($i<$row=odbc_fetch_array($cur3))
		{
			$conce = trim(odbc_result($cur3,2));
			$mision1 = trim(odbc_result($cur3,5)); 

			$consulta_fac = "select nombre from cx_ctr_fac where codigo in (".trim(odbc_result($cur3,16)).") order by codigo";  
			$cur_fac = odbc_exec($conexion,$consulta_fac);
			$factor1 = "";
			$a = 0;
			while($a<$row=odbc_fetch_array($cur_fac))
			{
				$factor1 = $factor1.trim(odbc_result($cur_fac,1))." - ";
				$a++;
			}   //while
			$factor1 = substr($factor1,'0',-2);

			$consulta_est = "select nombre from cx_ctr_est where codigo in (".trim(odbc_result($cur3,17)).")";  
			$cur_est = odbc_exec($conexion,$consulta_est);
			$estructura1 = "";
			$a = 0;
			while($a<$row=odbc_fetch_array($cur_est))
			{
				$estructura1 = $estructura1.trim(odbc_result($cur_est,1))." - ";
				$a++;
			}   //while
			$estructura1 = substr($estructura1,'0',-2);

			$area1 = trim(odbc_result($cur3,6));  
			$area1 = strtr(trim($area1), $sustituye);
			$fecha1 = str_replace('/','-',trim(odbc_result($cur3,7)));
			$fecha2 = str_replace('/','-',trim(odbc_result($cur3,8)));
			$fecha1_1 = date_create($fecha1);
			$fecha2_2 = date_create($fecha2);
			$diff = date_diff($fecha1_1,$fecha2_2);
			$lapso = str_replace('days','días',$diff->format("%a days")) + 1; 			
			$oficiales1 = trim(odbc_result($cur3,9));  
			$suboficiales1 = trim(odbc_result($cur3,10));  
			$auxiliares1 = trim(odbc_result($cur3,11)); 
			$soldados1 = trim(odbc_result($cur3,12));  
			$actividades1 = trim(odbc_result($cur3,15));  
			$valorm = "$ ".trim(odbc_result($cur3,13)); 
			$valorp = str_replace(',','',trim(odbc_result($cur3,13)));
			$valort = $valort + $valorp;  

            $consulta16 = "select nombre from cx_ctr_act where codigo='$actividades1'";
            $cur16 = odbc_exec($conexion,$consulta16);
            $n_actividades1 = trim(odbc_result($cur16,1));

			$linea = str_repeat("_",122);
			$linea1 = str_repeat("_",20);

			$var1 = "Misión: ".$mision1;
			$var2 = "Área General: ".$area1;
			$var3 = "Lapso: ".$lapso;
			$var4 = "Organización: ".$oficiales1." - ".$suboficiales1." - ".$soldados1." - ".$auxiliares1;
			$var5 = "Conceptos del Gastos Solicitados";
			$var6 = "Factor de Amenaza: ".$n_factor."   Estructura: ".$n_estructura."   Blanco de alta retribución: ".$n_oms;
			$var7 = "Actividades: ".$n_actividades1;			
			$var8 = "Factor: ".$factor1;
			$var9 = "Estructura: ".$estructura1;
  
			$pdf->Ln(-1);
			$actual=$pdf->GetY();
			$pdf->Cell(11,5,$i,0,0,'C');
			$pdf->Multicell(127,5,$var1,LR,'');

			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$var8,LR,'');

			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');  
			$pdf->Multicell(127,5,$var9,LR,'');

			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$var7,LR,'');
  
			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$var2,LR,'');

			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$var3,LR,'');

			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$var4,LR,'');

			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$var5,LR,'');

			$consulta4 = "select * from cx_pla_gad where conse1='".$conce."' and interno='$i' and ano='$ano'";
			$cur4 = odbc_exec($conexion,$consulta4);
			$j=1;
			while($j<$row=odbc_fetch_array($cur4))
			{
				$gasto1 = trim(odbc_result($cur4,5)); 
				if ($gasto1 == "99") $n_gasto1 = $otro1;
				else
				{
					$consulta5 = "select nombre from cx_ctr_pag where codigo='$gasto1'";
					$cur5 = odbc_exec($conexion,$consulta5);
					$n_gasto1 = trim(odbc_result($cur5,1)); 
				}   //if

				$otro1 = trim(odbc_result($cur4,6));  
				$otro1 = strtr(trim($otro1), $sustituye);
				$valor1 = "$ ".trim(odbc_result($cur4,7)); 
				
				if ($gasto1 != 18) $t_bienes = "";
				else
				{
					$bienes = explode("#",$row[bienes]);
					for ($ai=0;$ai<=count($bienes)-1;++$ai)
					{
						if ($ai == 0) $codigo = explode("&",$bienes[$ai]);
						if ($ai == 1) $valor_t = explode("&",$bienes[$ai]);
						if ($ai == 2) $valor_n = explode("&",$bienes[$ai]);
						if ($ai == 3) $ttipo = explode("&",$bienes[$ai]);
						if ($ai == 4) $desc = explode("&",$bienes[$ai]);
					}   //for
					$t_bienes = "";
					for ($ei=0;$ei<count($codigo)-1;++$ei)
					{
						$consulta_bie = "select * from cx_ctr_bie where codigo='".$codigo[$ei]."'";
						$cur_bie = odbc_exec($conexion,$consulta_bie);
						$t_bienes = $t_bienes.trim(odbc_result($cur_bie,3));
						$t_bienes = $t_bienes." - ".wims_currency($valor_n[$ei]);
						$t_bienes = $t_bienes.$ttipo[$ei];
						$t_bienes = $t_bienes." - ".$desc[$ei];						
						if ($ei < count($codigo)-1) $t_bienes = $t_bienes."\n";
					}   //for
				}   //if
				$t_bienes = substr($t_bienes,1,-1);
				
				$actual=$pdf->GetY();
				$pdf->Line(21,$actual,21,$actual+5);
				$pdf->Line(148,$actual,148,$actual+5);
				$pdf->Cell(12,5,'',0,0,'');
				$pdf->Cell(123,5,$j.". ".$n_gasto1,0,0,'');
				$pdf->Cell(54,5,$valor1,0,1,'R');

				//Se vuelve a activar que se muestren los bienes adquiridos el día 03/05/2023 a solicitud de Jorge Clavijo.
				if ($t_bienes != "")
				{
					$pdf->Cell(11,5,'',0,0,'');
					$pdf->Multicell(127,5,$t_bienes,LR,1,'');
				}   //if

				$j++;
			}   //while

			$pdf->Ln(-3);
			$actual=$pdf->GetY();
			$pdf->Line(21,$actual,21,$actual+5);
			$pdf->Line(148,$actual,148,$actual+5);
			$pdf->Cell(12,5,'',0,0,'');
			$pdf->Cell(123,5,'',0,0,'');
			$pdf->Cell(55,5,$linea1,0,1,'R');
	
			$actual=$pdf->GetY();
			$pdf->Line(21,$actual,21,$actual+5);
			$pdf->Line(148,$actual,148,$actual+5);
			$pdf->Cell(12,5,'',0,0,'');
			$pdf->Cell(123,5,'Suman:',0,0,'R');
			$pdf->Cell(55,5,$valorm,0,1,'R');

			$pdf->Ln(-3);
			$pdf->Cell(190,5,$linea,0,1,'C');
			$i++; 
		}   //while
		
		$valort1 = number_format($valort,2);
		$pdf->Cell(135,5,'Total gastos en actividades de  inteligencia o contrainteligencia',0,0,'');
		$pdf->Cell(55,5,'$ '.$valort1,0,1,'R');
		
		$actual=$pdf->GetY();
		if ($actual>=259.00125) $pdf->addpage();		

		$pdf->Ln(2);
		$pdf->Cell(190,5,'1.5 PAGO INFORMACIONES',0,1,'');
		$pdf->Ln(2);
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,12,7,0,'');	
		$pdf->RoundedRect(21,$actual,127,7,0,'');
		$pdf->RoundedRect(148,$actual,53,7,0,'');

		$pdf->Ln(1);
		$pdf->Cell(10,5,'ÍTEM',0,0,'C');
		$pdf->Cell(125,5,'CONCEPTO',0,0,'C');
		$pdf->Cell(55,5,'V/R SOLICITADO',0,1,'C');

		$consulta6 = "select * from cx_pla_pag where conse='".$consecu."' and ano='$ano'";
		$cur6 = odbc_exec($conexion,$consulta6);
		$valorf = 0;
		$k = 1;
		while($k<$row=odbc_fetch_array($cur6))
		{
			$ced_fuen=trim(odbc_result($cur6,4));  
			if (strpos($ced_fuen, "K") !== false) $nada = "";
			else $ced_fuen = "XXXX".substr($ced_fuen,-4);
			
			$nom_fuen = trim(odbc_result($cur6,5));  
			$fac_fuen = trim(odbc_result($cur6,6));  
			$consulta7 = "select nombre from cx_ctr_fac where codigo='$fac_fuen'";
			$cur7 = odbc_exec($conexion,$consulta7);
			$n_factor = trim(odbc_result($cur7,1));  

			$est_fuen = trim(odbc_result($cur6,7));  
			$consulta8 = "select nombre from cx_ctr_est where codigo='$est_fuen'";
			$cur8 = odbc_exec($conexion,$consulta8);
			$n_estructura = trim(odbc_result($cur8,1));  

			$fes_fuen = trim(odbc_result($cur6,8));  
			$sin_fuen = trim(odbc_result($cur6,9));  
			$sin_fuen = strtr(trim($sin_fuen), $sustituye);

			$dif_fuen = trim(odbc_result($cur6,10));  
			$consulta9 = "select nombre from cx_ctr_dif where codigo='$dif_fuen'";
			$cur9 = odbc_exec($conexion,$consulta9);
			$n_difusion = trim(odbc_result($cur9,1)); 

			$din_fuen = trim(odbc_result($cur6,11));  
			$fed_fuen = trim(odbc_result($cur6,12));  
			$res_fuen = trim(odbc_result($cur6,13));  
			$rad_fuen = trim(odbc_result($cur6,14));  
			$fer_fuen = trim(odbc_result($cur6,15));  
			$uti_fuen = trim(odbc_result($cur6,16));  
			$uti_fuen = strtr(trim($uti_fuen), $sustituye);
			$rec_fuen = trim(odbc_result($cur6,24));
			$consulta9 = "select nombre from cx_ctr_dif where codigo='$rec_fuen'";
			$cur9 = odbc_exec($conexion,$consulta9);
			$n_recoleccion = trim(odbc_result($cur9,1));
			$ren_fuen = trim(odbc_result($cur6,25));
			$fec_rec = trim(odbc_result($cur6,26));
			$ord_fuen = trim(odbc_result($cur6,27));
			$bat_fuen = trim(odbc_result($cur6,28));
			$fec_ret = trim(odbc_result($cur6,29));

			$valorz = "$ ".trim(odbc_result($cur6,17));  
			$valorn = str_replace(',','',trim(odbc_result($cur6,17)));
			$valorn = substr($valorn,0,-3);
			$valorf = $valorf+$valorn;

			$uni_fuen = trim(odbc_result($cur6,19));  
			$consulta11 = "select sigla, sigla1, fecha from cx_org_sub where subdependencia='$uni_fuen'";
			$cur11 = odbc_exec($conexion,$consulta11);
			$n_unidad = trim(odbc_result($cur11,1));
			$sigla1 = trim(odbc_result($cur11,2));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur11,3)),0,10));

			//Control para el cambio de sigla
			if ($sigla1 <> "") if ($fecha_pi >= $fecha_os) $n_unidad = $sigla1;	

			$vap1 = "Fuente: ".$ced_fuen;
			$vap2 = "Factor de Amenaza: ".$n_factor."   Estructura: ".$n_estructura;
			$vap3 = "Fecha Suministro Información: ".$fes_fuen;
			$vap4 = "Síntesis de la Información: ".$sin_fuen;
			$vap5 = "Difusión: ".$n_difusion."   Unidad / Dependencia: ".$n_unidad."   Nº ".$din_fuen."   Fecha: ".$fed_fuen;

			if ($res_fuen == "2") $vap6 = "Condujo Resultado: NO";
			else $vap6 = "Condujo Resultado: SI   Reporte Radiograma: ".$rad_fuen."   Fecha: ".$fer_fuen." Ordop: ".$ord_fuen." Batallón: ".$bat_fuen." Fecha resultado: ".$fec_ret;
			$vap7 = "Utilidad y Empleo de la Información: ".$uti_fuen;
			$vap8 =	"Recolección: ".$n_recoleccion."   Nº ".$ren_fuen."   Fecha: ".$fec_rec;

			$pdf->Ln(1);
			$actual=$pdf->GetY();
			$pdf->Cell(11,5,$k,0,0,'C');
			$pdf->Multicell(127,5,$vap1,LR,'');

			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$vap2,LR,'');
	
			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$vap3,LR,'');

			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$vap4,LR,'J');

			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$vap8,LR,'');

			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$vap5,LR,'J');

			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$vap6,LR,'');

			$actual=$pdf->GetY();
			$pdf->Cell(11,5,'',0,0,'');
			$pdf->Multicell(127,5,$vap7,LR,'J');

			$actual=$pdf->GetY();
			$pdf->Line(21,$actual,21,$actual+5);
			$pdf->Line(148,$actual,148,$actual+5);
			$pdf->Cell(12,5,'',0,0,'');
			$pdf->Cell(123,5,'Valor Solicitado:',0,0,'R');
			$pdf->Cell(55,5,$valorz,0,1,'R');

			$pdf->Ln(-3);
			$pdf->Cell(190,5,$linea,0,1,'C');
			$k++;
		}   //while

		$valort2 = number_format($valorf,2);
		$pdf->Ln(+1);		
		$pdf->Cell(135,5,'Total pago de informaciones',0,0,'');
		$pdf->Cell(55,5,'$ '.$valort2,0,1,'R');

		$sum_total = $valort + $valorf;
		$sum_total1 = number_format($sum_total,2);
		$sum_totalG = $sum_totalG + $sum_total;

		$pdf->Ln(-3);
		$pdf->Cell(190,5,$linea,0,1,'C');
		$pdf->Cell(135,5,'1.6 Total recursos gastos reservados requeridos',0,0,'');
		$pdf->Cell(55,5,'$ '.$sum_total1,0,1,'R');
		$pdf->Ln(-3);
		$pdf->Cell(190,5,$linea,0,1,'C');
		
		$actual=$pdf->GetY();
		if ($actual>=259.00125) $pdf->addpage();
		
		$pdf->Cell(135,5,'TOTAL RECURSOS GASTOS RESERVADOS REQUERIDOS',0,0,'');
		$pdf->Cell(55,5,'$ '.$sum_total1,0,1,'R');
		$pdf->Ln(-3);
		$pdf->Cell(190,5,$linea,0,1,'C');

		$sum_total = 0;
		$pdf->Ln(10);
		
		$actual=$pdf->GetY();
		if ($actual>=259.00125) $pdf->addpage();
		
		$frm1 = trim(odbc_result($cur,45));
		$frm2 = trim(odbc_result($cur,46));
		$frm3 = trim(odbc_result($cur,47));
		$frm4 = trim(odbc_result($cur,48));
		$frm5 = trim(odbc_result($cur,49));
		$u++;  
	}   //while

	$sum_totalGen = number_format($sum_totalG,2);
	$pdf->Cell(135,5,'TOTAL GENERAL GASTOS RESERVADOS REQUERIDOS',0,0,'');
	$pdf->Cell(55,5,'$ '.$sum_totalGen,0,1,'R');
	$pdf->Ln(-3);
	$pdf->Cell(190,5,$linea,0,1,'C');

	if ($subdependencia >= 1 and $subdependencia <= 3)
	{
		$elaboro = explode("»",$frm1);
		if (utf8_decode(substr($elaboro[0],-1)) == "?") $n_elaboro = substr($elaboro[0],0,-1);
		else $n_elaboro = $elaboro[0];
		//$n_elaboro = substr($elaboro[0],0,-1);
		$reviso = explode("»",$frm2);
		if (utf8_decode(substr($reviso[0],-1)) == "?") $n_reviso = substr($reviso[0],0,-1);
		else $n_reviso = $reviso[0];
		//$n_reviso = substr($reviso[0],0,-1);
		$aprobo =  explode("»",$frm5);
		if (utf8_decode(substr($aprobo[0],-1)) == "?") $n_aprobo = substr($aprobo[0],0,-1);
		else $n_aprobo = $aprobo[0];
		//$n_aprobo = substr($aprobo[0],0,-1);
		if (utf8_decode(substr($aprobo[1],-1)) == "?") $c_aprobo = substr($aprobo[1],0,-1);
		else $c_aprobo = $aprobo[1];
		//$c_aprobo = substr($aprobo[1],0,-1);	
	}
	elseif ($subdependencia >= 4)
	{
		if ($subdependencia >= 18 and $subdependencia <= 69)
		{
			$elaboro = explode("»",$frm3);
			if (utf8_decode(substr($elaboro[0],-1)) == "?") $n_elaboro = substr($elaboro[0],0,-1);
			else $n_elaboro = $elaboro[0];
			//$n_elaboro = substr($elaboro[0],0,-1);
			$reviso = explode("»",$frm4);
			if (utf8_decode(substr($reviso[0],-1)) == "?") $n_reviso = substr($reviso[0],0,-1);
			else $n_reviso = $reviso[0];			
			//$n_reviso = substr($reviso[0],0,-1);
			$aprobo =  explode("»",$frm5);
			if (utf8_decode(substr($aprobo[0],-1)) == "?") $n_aprobo = substr($aprobo[0],0,-1);
			else $n_aprobo = $aprobo[0];			
			//$n_aprobo = substr($aprobo[0],0,-1);
			if (utf8_decode(substr($aprobo[1],-1)) == "?") $c_aprobo = substr($aprobo[1],0,-1);
			else $c_aprobo = $aprobo[1];			
			//$c_aprobo = substr($aprobo[1],0,-1);			
		}
		else
		{
			$elaboro = explode("»",$frm1);
			if (utf8_decode(substr($elaboro[0],-1)) == "?") $n_elaboro = substr($elaboro[0],0,-1);
			else $n_elaboro = $elaboro[0];
			//$n_elaboro = substr($elaboro[0],0,-1);
			$reviso = explode("»",$frm2);
			if (utf8_decode(substr($reviso[0],-1)) == "?") $n_reviso = substr($reviso[0],0,-1);
			else $n_reviso = $reviso[0];	
			//$n_reviso = substr($reviso[0],0,-1);
			$aprobo =  explode("»",$frm3);
			if (utf8_decode(substr($aprobo[0],-1)) == "?") $n_aprobo = substr($aprobo[0],0,-1);
			else $n_aprobo = $aprobo[0];			
			$aprobo =  explode("»",$frm4);
			if (utf8_decode(substr($aprobo[0],-1)) == "?") $n_aprobo = substr($aprobo[0],0,-1);
			else $n_aprobo = $aprobo[0];
			//$n_aprobo = substr($aprobo[0],0,-1);
			if (utf8_decode(substr($aprobo[1],-1)) == "?") $c_aprobo = substr($aprobo[1],0,-1);
			else $c_aprobo = $aprobo[1];			
			//$c_aprobo = substr($aprobo[1],0,-1);
		}   //if
	}   //if

	//Busca imagen de la firma
	$consulta_fr = "select firma from cx_usu_web where usuario='$usu_usuario'";
	$cur_fr = odbc_exec($conexion, $consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)
	{
		$f_aprobo = trim(odbc_result($cur_fr,1));
		$data = str_replace('data:image/png;base64,', '', $f_aprobo);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$usu_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamaño = getimagesize($file);
		//if ($tamaño[0] <> 317) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';	

	$pdf->Ln(22);
	$actual=$pdf->GetY();
	//$pdf->Image($file,95,$actual-20,30,26);
	$pdf->Cell(190,5,'_____________________________________________',0,1,'C');
	$pdf->Cell(190,5,$n_aprobo,0,1,'C');
	$pdf->Cell(190,5, $c_aprobo,0,1,'C');
	$pdf->Ln(1);
	$actual=$pdf->GetY();
	$pdf->Cell(191,5,$linea,0,1,'C');
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Multicell(190,3,$texto,0,'J');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');		
	$pdf->Cell(15,5,'Elaboró',0,0,'');
	$pdf->Cell(85,5,$n_elaboro,0,0,'');
	$pdf->Cell(15,5,'Revisó:',0,0,'');
	$pdf->Cell(74,5,$n_reviso,0,1,'');

	$nom_pdf="pdf/PlanInvGRCon_".trim($sig_usuario)."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");
	$file=basename(tempnam(getcwd(),'tmp'));

	if ($cargar == "0") $pdf->Output();
	else $pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
