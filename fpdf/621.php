<?php
/* 621.php
   FO-JEMPP-CEDE2-621 - Acta Pago Fuentes.
   (pág 166 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub. Jorge Clavijo
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

			//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
			if ($_GET['tipo'] == '1') $consulta_act = "select * from cx_act_inf where conse = '".$_GET['conse']."' and unidad = '".$_GET['unidad']."' and ano = '".$_GET['ano']."'";
			else $consulta_act = "select * from cx_act_rec where conse = '".$_GET['conse']."' and registro = '".$_GET['registro']."' and ano = '".$_GET['ano']."' and ano1 = '".$_GET['ano1']."'";
			$cur_act = odbc_exec($conexion,$consulta_act);
			$fecha_act = substr(odbc_result($cur_act,2),0,10);
			$unidad = trim(odbc_result($cur_act,4));

			$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$unidad."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = trim(odbc_result($cur1,1));
			$sigla1 = trim(odbc_result($cur1,3));
			$nom1 = trim(odbc_result($cur1,4));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
			if ($sigla1 <> "") if ($fecha_act >= $fecha_os) $sigla = $sigla1;
			
			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			if (strlen($sigla) <= 6) $this->RotatedText(55,200,$sigla,35);
			else $this->RotatedText(25,230,$sigla,35);

			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,150,150);
			$this->Cell(190,5,'SECRETO',0,1,'C');
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
			$this->Cell(55,5,'ACTA PAGO',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-621',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'FUENTE HUMANA',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'4',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(55,5,'',0,0,'C');			
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2021-10-11',0,1,'');

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

			//Control insertar página en blanco
			if ($_GET['hoja'] == 1)
			{
				if ($this->page == 2)
				{
					$this->SetFont('Arial','',40);
					$pagb = "";
					for ($h=1;$h<=3;$h++) $pagb = $pagb."\n\n\n\n\n\n\n\n\n\n\n\n\nHOJA EN BLANCO";
					$pagb = $pagb."\n\n\n\n\n\n\n\n";
					$this->Multicell(191,5,$pagb,0,'C');
					$this->SetFont('Arial','',8);
					$this->AddPage();
				}   //if
			}   //if
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
		}//RoundedRect

		function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
		{
  			$h = $this->h;
  			$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
  			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
		}//_Arc

		function Footer()
		{
  			$fecha1=date("d/m/Y H:i:s a");
  			$fecha1="";
  			$this->SetY(-10);
  			$this->SetFont('Arial','',7);
  			$this->Cell(190,4,'SIGAR - '.$_GET['conse']." - ".$fecha1.odbc_result($cur1,1),0,1,'');
  			$this->Ln(-4);
  			$this->SetFont('Arial','B',8);
  			$this->SetTextColor(255,150,150);
  			$this->Cell(190,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR';
  			$this->Code39(182,285,$cod_bar,.5,5);
		}//Footer()
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');
	require ('conversor.php');

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",122);
	$lin1 = str_repeat("_",30);
	$total_gastos =  0;

	$hoja = $_GET['hoja'];
	
	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=259.00125) $pdf->addpage();
	} //control_salto_pag

	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->Ln(-1);	
	$pdf->Cell(185,5,'DE SOLO CONOCIMIENTO',0,0,'R');
	$pdf->SetFont('Arial','UB',5);	
	$pdf->Cell(3,5,'1',0,1,'L');
	$pdf->SetFont('Arial','',8);

	if ($_GET['tipo'] == '1') $consulta_act = "select * from cx_act_inf where conse = '".$_GET['conse']."' and unidad = '".$_GET['unidad']."' and ano = '".$_GET['ano']."'";
	else $consulta_act = "select * from cx_act_rec where conse = '".$_GET['conse']."' and registro = '".$_GET['registro']."' and ano = '".$_GET['ano']."' and ano1 = '".$_GET['ano1']."'";
	$cur_act = odbc_exec($conexion,$consulta_act);
	$fecha_act = substr(odbc_result($cur_act,2),0,10);
	$unidad = trim(odbc_result($cur_act,4));

	//$consulta = "select * from cx_org_sub where subdependencia = '".$_SESSION["uni_usuario"]."'";
	$consulta = "select * from cx_org_sub where subdependencia = '".$unidad."'";
	$cur = odbc_exec($conexion,$consulta);
	$sigla = trim(odbc_result($cur,4));
	$ciudad_uni = trim(odbc_result($cur,5));
	$sigla1 = trim(odbc_result($cur,41));
	$nom_unidad = trim(odbc_result($cur,42));
	if ($sigla1 <> "") $sigla = $sigla1;

	if ($_GET['tipo'] == '1')
	{
		$pag_inf = 'Cuadrado.png';
		$pag_rec = 'CuadradoX.png';
		$consulta1 = "select * from cx_act_inf where conse = '".$_GET['conse']."' and unidad = '".$_GET['unidad']."' and ano = '".$_GET['ano']."'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$fecha = substr(odbc_result($cur1,2),0,10);
		$ciudad = trim(odbc_result($cur1,5));
		$fuente = trim(odbc_result($cur1,6));
		if (substr($fuente,0,1) != "K") $fuente = "XXXX".substr($fuente,-4);
		$valor = str_replace(',','',trim(odbc_result($cur1,8)));
		$util = trim(odbc_result($cur1,9));
		$sintesis = trim(odbc_result($cur1,10));
		$oficio_n = trim(odbc_result($cur1,13));
		$fe_oficio = trim(odbc_result($cur1,14));
		$pla_inv = trim(odbc_result($cur1,18));	
		$elabora = trim(odbc_result($cur1,22));
		if ($elabora == "") $elabora = $_SESSION["nom_usuario"];
		$num = trim(odbc_result($cur1,23));
		if ($num == "") $num = odbc_result($cur1,1);

		$consulta2 = "select nom_fuen from cx_pla_pag where ced_fuen = '".$fuente."'";
		$cur2 = odbc_exec($conexion,$consulta2);
		$beneficiario = trim(odbc_result($cur2,1));
		
		$testigo = trim(odbc_result($cur1,7));
		$firmas = trim(decrypt1(odbc_result($cur1,17), $llave));
		$l_firmas = substr($firmas,-1);
		if ($l_firmas == "|") $firmas = substr($firmas,0,-1);
		$num_firmas = explode("|",$firmas);
		for ($i=0;$i<count($num_firmas);++$i)
		{
			$fir[$i] = $num_firmas[$i];
		}
		$inter[0]["nom"] = $fuente;
		$inter[0]["cargo"] = "BENEFICIARIO DEL PAGO";
		$inter[1]["nom"] = $testigo;
		$inter[1]["cargo"] = "TESTIGO DEL PAGO";
		$nreg = count($num_firmas)+2;
		$i = $i-1;
		for ($a=2;$a<$nreg;++$a)
		{
			$fir1 = explode("»",$fir[$i]);
			if (strlen($fir1[0]) != 0)
			{
				$fnom = substr(strtr($fir1[0], $sustituye),0,-1);    
				$inter[$a]["nom"] = utf8_decode($fnom);
				$inter[$a]["cargo"] = utf8_decode(strtr($fir1[1], $sustituye));
			}  //if
			$i--;
		}  //for

		$texto_int = "\n";
		for ($i=$nreg-1;$i>=0;--$i) $texto_int = $texto_int.$inter[$i]["nom"]."\n".$inter[$i]["cargo"]."\n\n";
		$valor = trim(odbc_result($cur1,8));
		$val1 = str_replace(',','',$valor);
		$empleo1 = strtr(trim(odbc_result($cur1,20)), $sustituye);
		
		$observacion1 = trim(odbc_result($cur1,21));
		if (strlen($observacion1) == 0) 
		{
			if (odbc_result($cur1,15) == 'P') $texto_obs = "Con la realización de este pago, la unidad quedó a Paz y Salvo con la fuente\n\n";
			else $texto_obs = "";
		}
		else $texto_obs = $observacion1;
	}
	else
	{
		$pag_inf = 'CuadradoX.png';
		$pag_rec = 'Cuadrado.png';
		$consulta1 = "select * from cx_act_rec where conse = '".$_GET['conse']."' and registro = '".$_GET['registro']."' and ano = '".$_GET['ano']."' and ano1 = '".$_GET['ano1']."'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$fecha = substr(odbc_result($cur1,2),0,10);
		$num = odbc_result($cur1,1);
		$ciudad = $ciudad_uni;
		$firmas = trim(odbc_result($cur1,11));
		$l_firmas = substr($firmas,-1);
		if ($l_firmas == "|") $firmas = substr($firmas,0,-1);
		$num_firmas = explode("|",$firmas);
		for ($i=0;$i<count($num_firmas);++$i) $fir[$i] = $num_firmas[$i];

		$fuente = trim(odbc_result($cur1,12));
		$fuente12 = explode("|",$fuente);
		$fuente = "XXXX".substr($fuente12[0],-4);

		$inter[0]["nom"] = $fuente;
		$inter[0]["cargo"] = "BENEFICIARIO DEL PAGO";
		$nreg = count($num_firmas)+2;
		$i = $i-1;
		for ($a=1;$a<$nreg;++$a)
		{
			$fir1 = explode("»",$fir[$i]);
			if (strlen($fir1[0]) !=0)
			{
				$fnom = strtr($fir1[0], $sustituye); 
				if (substr($fnom,-1) != "?") $inter[$a]["nom"] = $fnom;
				$inter[$a]["nom"] = $fnom;
				if (mb_detect_encoding($fir1[1]) == 'UTF-8')
				{
					$inter[$a]["cargo"] = utf8_encode($fir1[1]);
					$inter[$a]["cargo"] = utf8_decode(strtr($fir1[1], $sustituye));
					if (mb_detect_encoding($inter[$a]["cargo"]) == 'ASCII')
					{
						$inter[$a]["cargo"] = str_replace("??", "ÑÍ", $inter[$a]["cargo"]);
						$inter[$a]["cargo"] = str_replace("?", "Ó", $inter[$a]["cargo"]);
					}   //if
				}
				else $inter[$a]["cargo"] = utf8_encode($fir1[1]);
			}  //if
			$i--;
		}  //for

		$texto_int = "\n";
		for ($i=count($inter)-1;$i>=0;--$i) $texto_int = $texto_int.$inter[$i]["nom"]."\n".$inter[$i]["cargo"]."\n\n";	
		$otro_val = trim(odbc_result($cur1,20));
		if ($otro_val != 0) $valor = trim(odbc_result($cur1,19));
		else $valor = trim(odbc_result($cur1,10));
		$val1 = str_replace(',','',$valor);
		$sintesis = trim(odbc_result($cur1,13));
		$util = trim(odbc_result($cur1,14));
		$texto_obs = trim(odbc_result($cur1,15));
		$elabora = trim(odbc_result($cur1,16)); 
	}   //if

	$pdf->RoundedRect(9,$actual+4,192,5,0,'');
	$pdf->Cell(39,5,'Pago de informaciones',0,0,'');
	$pdf->Cell(10,5,$pdf->Image($pag_inf,130,49,-200),0,0,'R');
	$pdf->Cell(25,5,'',0,0,'');
	$pdf->Cell(39,5,'Pago de recompensas',1,0,'');
	$pdf->Cell(10,5,$pdf->Image($pag_rec,55,49,-200),0,0,'C');

	$pdf->Cell(25,5,'',0,1,'');	
	$pdf->RoundedRect(9,$actual+4,40,5,0,'');
	$pdf->Cell(39,5,'Nombre Unidad',0,0,'');
	$pdf->Cell(100,5,$sigla,1,0,'L');   //$nom_unidad
	$pdf->RoundedRect(9,$actual+9,40,5,0,'');
	$pdf->Cell(28,5,'1. Radicado No.',0,0,'');
	$pdf->Cell(24,5,$num,1,1,'L');
	$pdf->RoundedRect(9,$actual+14,40,5,0,'');
	$pdf->Cell(39,5,'2. Lugar',0,0,'');
	$pdf->Cell(100,5,$ciudad,1,0,'L'); 
	$pdf->Cell(28,5,'3. Fecha',1,0,'');
	$pdf->Cell(24,5,$fecha,1,1,'L'); 

	$nreg = count($num_firmas)+1;
	$lin = ($nreg + 2) * 3 * 2.60;
	$actual=$pdf->GetY();
	$pdf->Cell(39,3,'4. Intervienen.',0,0,'L');
	$pdf->Multicell(152,3,$texto_int,1,'L');
	
	$actual=$pdf->GetY();
	$pdf->Ln(2);
	$pdf->RoundedRect(9,$actual,40,15,0,'');
	$pdf->Cell(39,5,'5. Asunto.',0,0,'L');

	$val1 = intval(substr($val1,0,-3));
	if ($_GET['tipo'] == '1') $texto_a = "Trata del pago de información por un valor de ".convertir($val1)." (".'$'.$valor.") al(a la) señor(a) identificado(a) con No. ".$fuente." quien se registra como fuente.";
	else $texto_a = "Trata del pago de una recompensa por un valor de ".convertir($val1)." (".'$'.$valor.") al(a la) señor(a) identificado(a) con No. ".$fuente." quien se registra como fuente.";
	$pdf->RoundedRect(49,$actual,152,15,0,'');
	$pdf->SetFont('Arial','',9);
	$pdf->Multicell(152,4,$texto_a,0,'J');
	$pdf->SetFont('Arial','',8);

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');	
	$pdf->Cell(191,5,'6. Síntesis información suministrada.',0,1,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Multicell(190,5,$sintesis,0,'J');
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->Cell(190,3,$linea,0,1,'C');
		 
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');	
	$pdf->Cell(191,5,'7. Utilidad y empleo de la información.',0,1,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Multicell(190,5,$util,0,'J');
	$pdf->SetFont('Arial','',8);

	if ($_GET['tipo'] == '1')
	{
		$actual=$pdf->GetY();
		$texto_empleo = "La información fue difundida mediante oficio No. ".$oficio_n." al CI3MO el día ".$fe_oficio;
		$pdf->SetFont('Arial','',9);
		if (strlen($empleo1) == 0) $pdf->Multicell(190,5,$texto_empleo,0,'J');
		else $pdf->Multicell(190,5,$empleo1,0,'J');
		$pdf->SetFont('Arial','',8);
	}   //if	
	
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');	
	$pdf->Cell(191,5,'8. Valor del pago autorizado por el Ordenador delegado o comité central de la Fuerza:',0,1,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Multicell(190,5,'$'.$valor,0,'R');
	$pdf->SetFont('Arial','',9);
	$actual=$pdf->GetY();

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');	
	$pdf->Cell(191,5,'9. Observaciones.',0,1,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Multicell(190,5,$texto_obs,0,'J');
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->Cell(190,3,$linea,0,1,'C');
	 
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');	
	$pdf->Cell(191,5,'10. Cierre.',0,1,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(190,5,'No siendo otro el objeto de la presente, se da por terminada y en constancia firman los que intervinieron en este pago:',0,'L');
	$pdf->SetFont('Arial','',8);	
	if ($actual < 236.00125) $pdf->Ln(20);
	else $pdf->Ln(10);
	control_salto_pag($pdf->GetY());

	//Firmas
	$actual=$pdf->GetY();	
	$pdf->Multicell(190,5,"\n\n\n",0,'');

	if (count($inter) % 2 == 0) 
	{
		for ($i=0;$i<count($inter);$i=$i+2)
		{
			control_salto_pag($pdf->GetY());
			$pdf->Ln(20);	
			$pdf->Cell(15,4,'',0,0,'C');
			$pdf->Cell(72,4,substr($inter[$i]["nom"],0),T,0,'C'); 
			$pdf->Cell(16,4,'',0,0,'C');		
			$pdf->Cell(72,4,substr($inter[$i+1]["nom"],0),T,1,'C');
			$pdf->Cell(15,4,'',0,0,'C');
			$pdf->Cell(72,4,$inter[$i]["cargo"],0,0,'C');
			$pdf->Cell(16,4,'',0,0,'C');		
			$pdf->Cell(72,4,$inter[$i+1]["cargo"],0,1,'C');
			$n = (count($inter)/2);
			if ($i == $n)
			{
				$pdf->Ln(20);
				$pdf->Cell(190,0,'',0,1,'C');
			}
			else $pdf->Cell(190,13,'',0,1,'C');
		}   //for
	}
	else
	{
		for ($i=0;$i<count($inter)-1;$i=$i+2)
		{
			control_salto_pag($pdf->GetY());
			$pdf->Ln(20);
			$pdf->Cell(15,4,'',0,0,'C');
			$pdf->Cell(72,4,substr($inter[$i]["nom"],0),T,0,'C');  
			$pdf->Cell(16,4,'',0,0,'C');		
			$pdf->Cell(72,4,substr($inter[$i+1]["nom"],0),T,1,'C');
			$pdf->Cell(15,4,'',0,0,'C');
			$pdf->Cell(72,4,$inter[$i]["cargo"],0,0,'C');
			$pdf->Cell(16,4,'',0,0,'C');		
			$pdf->Cell(72,4,$inter[$i+1]["cargo"],0,1,'C');
			$pdf->Cell(190,13,' ',0,1,'C');	
		}   //for

		control_salto_pag($pdf->GetY());		
		$pdf->Ln(20);
		$pdf->Cell(55,4,'',0,0,'C');
		$pdf->Cell(72,4,substr($inter[$i]["nom"],0),T,1,'C');
		$pdf->Cell(55,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["cargo"],0,1,'C');
	}   //if

	$pdf->Ln(5);
	$pdf->Cell(190,3,$linea,0,1,'C');
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva ";
	$texto=$texto."legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la ";
	$texto=$texto."Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y ";
	$texto=$texto."restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente ";
	$texto=$texto."documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien ";
	$texto=$texto."al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando ";
	$texto=$texto."de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la ";
	$texto=$texto."autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de ";
	$texto=$texto."entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá ";
	$texto=$texto."revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ";
	$texto=$texto."ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien ";
	$texto=$texto."emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";				
	
	$pdf->Ln(1);	
	$pdf->SetFont('Arial','',7);
	$pdf->Multicell(190,3,$texto,0,'J');
	$pdf->SetFont('Arial','',8);	
	$pdf->Cell(190,4,$linea,0,1,'C');
	$pdf->Cell(60,4,'Elaboró:    '.$elabora,0,1,''); 
	$pdf->Cell(190,3,$linea,0,1,'C');
	
	$notaalpie = "1.- Literal a) Artículo 13 Decreto 857 de 2015 De uso exclusivo. a) De solo conocimiento. Es aquel producto de inteligencia y contrainteligencia que tiene un receptor autorizado por ley, solo para conocimiento directo y, únicamente, como referencia o criterio orientador para tomar decisiones dentro de su órbita funcional. El receptor autorizado recibe el producto bajo las más estrictas medidas de seguridad, reserva legal y protocolos adecuados. El receptor autorizado no podrá difundir la información contenida en el producto de inteligencia y contrainteligencia.";
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();	
	$pdf->Ln(1);
	$pdf->Cell(190,3,'_________________________',0,1,'L');	
	$pdf->SetFont('Arial','',7);
	$pdf->Multicell(190,3,$notaalpie,0,'J');
	$pdf->SetFont('Arial','',8);		

	if ($_GET['tipo'] == '1') $nom_pdf="../fpdf/pdf/Actas/ActaPagFue_".$sigla."_".$_GET['conse']."_".$_GET['ano'].".pdf";
	else $nom_pdf="../fpdf/pdf/Actas/ActaPagInf_".$sigla."_".$_GET['conse']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");
	$file=basename(tempnam(getcwd(),'tmp'));

	if ($cargar == "0") $pdf->Output();
	else $pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";		
}
?>

