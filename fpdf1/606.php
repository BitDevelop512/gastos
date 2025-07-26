<?php
/* 606.php    Acta Informe de Verificación.
   (pág 240 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
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
	//require('morepagestable.php');
	
	class PDF extends PDF_Rotate
	{
		function Header()
		{
			require('../conf.php');
			$consulta1= "select sigla,nombre from cx_org_sub where subdependencia='".$_SESSION["uni_usuario"]."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = odbc_result($cur1,1);
			$sig_usuario = $sigla;

			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			$this->RotatedText(55,200,$sig_usuario,35);

			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,150,150);
			$this->Cell(190,5,'SECRETO',0,1,'C');
			$this->Ln(2);

			$this->Image('sigar.png',10,17,17);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(0,0,0);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(125,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(8,5,'',0,0,'');
			$this->Cell(22,5,'',0,1,''); 	

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(55,5,'',0,0,'C');
			$this->Cell(12,5,'',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'',0,0,'C');
			$this->Cell(12,5,'',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(78,5,'',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(25,5,'Página: '.$this->PageNo().'/{nb}',0,1,'R'); 	

			$this->SetFont('Arial','B',8);
			$this->Cell(17,3,'',0,0,'C',0);
			$this->Cell(125,3,'',0,0,'');
			$this->Cell(26,3,'',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,3,'',0,1,'');

			$this->RoundedRect(9,15,192,27,'0','');
			$this->RoundedRect(9,15,192,268,0,'');
			$this->Ln(4);
		}

		function RotatedText($x,$y,$txt,$angle)
		{
    		$this->Rotate($angle,$x,$y);
    		$this->Text($x,$y,$txt);
			$this->Rotate(0);
		}

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
		}//function RoundedRect($x,$y,$w,$h,$r,$style='')

		function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
		{
  			$h = $this->h;
  			$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
  			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
		}//function _Arc($x1, $y1, $x2, $y2, $x3, $y3)

		function morepagestable($datas, $lineheight=4)
		{
			$l = $this->lMargin + 5.00125;
			$startheight = $h = $this->GetY();
			$startpage = $currpage = $maxpage = $this->page;
			$pag_act = $this->page;
			$fullwidth = 0;
			foreach($this->tablewidths AS $width) $fullwidth += $width;
			foreach($datas AS $row => $data)
			{
				$this->page = $currpage;
				$this->Line($l,$h,$fullwidth+$l,$h);
				foreach($data AS $col => $txt)
				{
					$this->page = $currpage;
					$act = $this->GetY();
					$this->SetXY($l,$h);
					$this->SetFont('Arial','',8);		
					$this->MultiCell($this->tablewidths[$col],$lineheight,$txt);
					$l += $this->tablewidths[$col];
					
					if(!isset($tmpheight[$row.'-'.$this->page])) $tmpheight[$row.'-'.$this->page] = 0;
					if($tmpheight[$row.'-'.$this->page] < $this->GetY()) $tmpheight[$row.'-'.$this->page] = $this->GetY();
					if($this->page > $maxpage) $maxpage = $this->page;
				}   //for
				$h = $tmpheight[$row.'-'.$maxpage];
				$l = $this->lMargin + 5.00125;
				$currpage = $maxpage;
			}   //for
			$this->page = $maxpage;
			$this->Line($l,$h,$fullwidth+$l,$h);
		
			for($i = $startpage; $i <= $maxpage; $i++)
			{
				$this->page = $i;
				$l = $this->lMargin + 5.00125;
				$t  = ($i == $startpage) ? $startheight : 44.00125;
				$lh = ($i == $maxpage)   ? $h : $this->h-$this->bMargin;
				$this->Line($l,$t,$l,$lh);
				foreach($this->tablewidths AS $width) {
					$l += $width;
					$this->Line($l,$t,$l,$lh);
				}   //for
			}   //for
			$this->page = $maxpage;
		}//morepagestable

		function Footer()
		{
  			$fecha1=date("d/m/Y H:i:s a");
  			$this->SetY(-10);
  			$this->SetFont('Arial','',7);
  			$this->Cell(190,4,'SIGAR - '.$fecha1,0,1,'');
  			$this->Ln(-4);
  			$this->SetFont('Arial','B',8);
  			$this->SetTextColor(255,150,150);
  			$this->Cell(190,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR';
  			$this->Code39(182,285,$cod_bar,.5,5);
		}//function Footer()
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFont('Arial','',8);
	$buscar = array(chr(13).chr(10), chr(13), chr(10), "\r\n", "\n", "\r", "\n\r");
	$sustituye = array ('Ã¡' => 'á', 'Ãº' => 'ú','Ã“' => 'Ó','ÃƒÂƒÃ‚ÂƒÃƒÂ‚Ã‚ÂƒÃƒÂƒÃ‚Â‚ÃƒÂ‚Ã‚Â“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'ÃƒÂƒÃ‚ÂƒÃƒÂ‚Ã‚ÂƒÃƒÂƒÃ‚Â‚ÃƒÂ‚Ã‚Â' => 'Í', 'Ã­' => 'í', 'Ã' => 'Á');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",122);

	$acta = $_GET['acta'];
	$conse = $_GET['conse'];
	$ano = $_GET['ano'];
	if (!empty($_GET['ajuste'])) $ajuste = $_GET['ajuste'];
	else $ajuste = "0";	
	$hoja = $_GET['hoja'];

/*Para incluir página en blanco.
	if ($pdf->PageNo() == 1 and $hoja == 1)
	{
		$pdf->addpage();
		$pdf->SetFont('Arial','',40);
		$pagb = "\n\n\n\n\n\n\n\n\nHOJA EN BLANCO\n\n\n\n\n\n\n\n\n\n\n\n\nHOJA EN BLANCO\n\n\n\n\n\n\n\n\n\n\n\n\nHOJA EN BLANCO\n\n\n\n\n\n\n\n\n\n\n";
		$pdf->Multicell(191,5,$pagb,0,'C');
		$pdf->SetFont('Arial','',8);		
		$pdf->addpage();
	}   //if
*/ 

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=247.00125) $pdf->addpage();  //265.00125
	} //control_salto_pag

	$consulta = "select * from cx_act_ver where conse = '".$conse."' and ano = '".$ano."'";
	$cur = odbc_exec($conexion,$consulta);
	$row = odbc_fetch_array($cur);
	$fecha = substr(odbc_result($cur,2),0,10);
	$acta = trim(odbc_result($cur,7));
	$lugar = trim(odbc_result($cur,8));
	$fir = $row['firmas'];
	$asunto = trim($row['asunto']);
	$fe_ini = substr(odbc_result($cur,12),0,10);
	$fe_fin = substr(odbc_result($cur,13),0,10);
	$ciudad = trim(odbc_result($cur,14));
	$resp_area_proc	= trim($row['responsable']);
	$docs = trim($row['documentos']);
	$asptec	 = trim($row['aspectos']);
	$observaciones = trim($row['observaciones']);
	$actividades = trim($row['actividades']);
	$recomendaciones = trim($row['recomendaciones']);
	$aprueba = trim($row['aprobo']);
	$elaboro = trim($row['elaboro']);
	$reviso = trim($row['reviso']);

	$pdf->Cell(191,5,'DE USO EXCLUSIVO',0,1,'R');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(9,5,'',0,0,'');
	$pdf->Cell(110,5,'ACTA NR.',0,0,'R');
	$pdf->Cell(72,5,$acta,1,1,'C');
	$pdf->RoundedRect(9,$actual+5,192,5,0,'');
	$pdf->Cell(39,5,'LUGAR Y FECHA:',0,0,'');
	$pdf->Cell(152,5,$lugar.' - '.$fecha,1,1,'L');
	$actual=$pdf->GetY();

	$texto1_int = "";
	$num_fir = explode("|",$fir);
	for ($i=0;$i<count($num_fir)-1;++$i) $fir1[$i] = $num_fir[$i];
	for ($i=0;$i<count($fir1);$i++)
	{
		$fir2 = explode("»",$fir1[$i]);
		$inter[$i]["nom"] = $fir2[0]; 
		$inter[$i]["cargo"] = $fir2[1];
		$texto1_int = $texto1_int.$inter[$i]["nom"]."\n";
		$texto1_int = $texto1_int.$inter[$i]["cargo"]."\n\n";	
	}   //for
	$aa = ($i*8)+($i*4);
	$pdf->RoundedRect(9,$actual,192,$aa,0,'');
	$pdf->Cell(39,5,'INTERVIENEN:',0,0,'');
	$pdf->Multicell(152,4,$texto1_int,1,'L');

	$actual=$pdf->GetY();
	$l_asunto = strlen($asunto);
    if ($l_asunto <= 110) $aa = 5;
    else $aa = ceil($l_asunto/110)*5;
	$pdf->RoundedRect(9,$actual,192,$aa,0,'');
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->Multicell(39,5,'A S U N T O:',0,'L');
	$pdf->RoundedRect(49,$actual,152,$aa,0,'');	
	$pdf->SetXY($x+39,$y);		
	$pdf->Multicell(152,4,strtoupper($asunto),0,'J');

	$actual=$pdf->GetY();
	$pdf->Cell(192,10,'AL EFECTO SE PROCEDE CON LOS SIGUIENTES RESULTADOS',0,1,'L');	
	control_salto_pag($pdf->GetY());

	$pdf->SetFillColor(192);
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(190,5,'1. INFORMACIÓN BÁSICA',0,1,'L');
	$pdf->Ln(2);
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->RoundedRect(15,$y,180,5,0,'DF');
	$pdf->SetXY($x+5,$y);
	$pdf->Cell(50,5,'FECHA DE INICIO',1,0,'C');	
	$pdf->SetXY($x+55,$y);
	$pdf->Cell(50,5,'FECHA DE TÉRMINO',1,0,'C');
	$pdf->SetXY($x+105,$y);	
	$pdf->Cell(80,5,'CIUDAD',1,1,'C');
	$pdf->SetFont('Arial','',8);	
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->SetXY($x+5,$y);
	$pdf->Cell(50,5,$fe_ini,1,0,'C');	
	$pdf->SetXY($x+55,$y);
	$pdf->Cell(50,5,$fe_fin,1,0,'C');
	$pdf->SetXY($x+105,$y);	
	$pdf->Cell(80,5,$ciudad,1,1,'C');
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->SetFont('Arial','B',8);	
	$pdf->RoundedRect(15,$y,180,5,0,'DF');
	$pdf->SetXY($x+5,$y);
	$pdf->Cell(180,5,'RESPONSABLE DEL ÁREA Y/O PROCESO',1,1,'C');
	$pdf->SetFont('Arial','',8);
	$y = $pdf->Gety();
	$pdf->SetXY($x+5,$y);	
	$pdf->multicell(180,4,$resp_area_proc,1,'J');						
	$pdf->Cell(190,3,$linea,0,1,'C');	
	
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(190,5,'2. DOCUMENTOS REVISADOS',0,1,'L');
	$pdf->SetFont('Arial','',8);	
	$pdf->Ln(2);
	$pdf->Multicell(190,4,$docs,0,'J');
	$pdf->Cell(190,3,$linea,0,1,'C');
	
	control_salto_pag($pdf->GetY());
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(190,5,'3. ASPECTOS POSITIVOS',0,1,'L');	
	$pdf->SetFont('Arial','',8);
	$pdf->Ln(2);
	$pdf->Multicell(190,4,$asptec,0,'J');
	$pdf->Cell(190,3,$linea,0,1,'C');

	control_salto_pag($pdf->GetY());
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(190,5,'4. OBSERVACIONES',0,1,'L');	
	$pdf->SetFont('Arial','',8);	
	$pdf->Ln(4);
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->RoundedRect(15,$y,180,5,0,'DF');
	$pdf->SetXY($x+5,$y);
	$pdf->Cell(8,5,'No.',1,0,'C');	
	$pdf->SetXY($x+13,$y);
	$pdf->Cell(172,5,'DESCRIPCIÓN DE LA OBSERVACIÓN',1,1,'C');
	
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->RoundedRect(15,$y,180,5,0,'DF');
	$pdf->SetXY($x+5,$y);	
	$pdf->Cell(8,5,'',1,0,'C');
	$pdf->SetXY($x+13,$y);	
	$pdf->Cell(16,5,'UNIDAD',1,0,'C');
	$pdf->SetXY($x+29,$y);	
	$pdf->Cell(98,5,'NOMBRE DOCUMENTO',1,0,'C');
	$pdf->SetXY($x+127,$y);	
	$pdf->Cell(18,5,'FECHA',1,0,'C');
	$pdf->SetXY($x+145,$y);	
	$pdf->Cell(40,5,'TIPO DOCUMENTO',1,1,'C');

	if ($observaciones == "")
	{
		$x = $pdf->Getx();
		$y = $pdf->Gety();
		$pdf->SetXY($x+5,$y);
		$pdf->Cell(10,5,'',1,0,'C');	
		$pdf->SetXY($x+25,$y);
		$pdf->Cell(8,5,'',1,0,'C');
		$pdf->Cell(16,5,'',1,0,'L');
		$pdf->Cell(98,5,'',1,0,'C');
		$pdf->Cell(40,5,'',1,1,'L');		
	}
	else
	{	
		$pdf->tablewidths = array(8, 16, 98, 18, 40);
		$obser = explode("|",$observaciones);
		foreach ($obser as $row => $dat)
		{
			$observa = explode("»",$dat);
			$consulta_cu = "select * from cv_unidades where subdependencia = '".$observa[1]."'";
			$cur_cu = odbc_exec($conexion,$consulta_cu);
			$n_unidad = trim(odbc_result($cur_cu,6));
		
			$consulta_ts = "select * from cx_ctr_doc where codigo = '".$observa[4]."'";
			$cur_ts = odbc_exec($conexion,$consulta_ts);
			$t_soporte = trim(odbc_result($cur_ts,2));
			$data[] = array($observa[0], $n_unidad, $observa[2], trim($observa[3]), $t_soporte);
		}   //for
		$pdf->morepagestable($data);			
	}   //if
	$pdf->Cell(190,3,$linea,0,1,'C');

	control_salto_pag($pdf->GetY());
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(190,5,'5. OTRAS ACTIVIDADES',0,1,'L');
	$pdf->SetFont('Arial','',8);	
	$pdf->Ln(2);
	$pdf->Multicell(190,4,$actividades,0,'J');
	$pdf->Cell(190,3,$linea,0,1,'C');
	
	control_salto_pag($pdf->GetY());
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(190,5,'6. RECOMENDACIONES',0,1,'L');	
	$pdf->SetFont('Arial','',8);	
	$pdf->Ln(2);
	$pdf->Multicell(190,4,$recomendaciones,0,'J');
	$pdf->Cell(190,3,$linea,0,1,'C');

	control_salto_pag($pdf->GetY());
	$pdf->SetFont('Arial','B',8);		
	$pdf->Cell(190,5,'Anexo 1: Compromisos de mejora unidad verificada.',0,1,'L');
	$pdf->SetFont('Arial','',8);		
	$pdf->Cell(190,3,$linea,0,1,'C');
	
	control_salto_pag($pdf->GetY());
	$pdf->Cell(190,5,'No siendo otro el motivo de la presente acta, se da por terminada y en constancia firman los que en ella intervienen',0,1,'L');

	if ($ajuste > 0) $pdf->Ln($ajuste);
	$pdf->Ln(20);
	$nf = count($inter) % 2;
	if ($nf == 0) $nfir = count($inter)-1;
	else $nfir = count($inter)-1;
	$pdf->Ln(11);

	for ($i=$nfir;$i>0;$i=$i-2)
	{
		$pdf->Cell(15,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["nom"],T,0,'C'); 
		$pdf->Cell(16,4,'',0,0,'C');		
		$pdf->Cell(72,4,$inter[$i-1]["nom"],T,1,'C');
		$pdf->Cell(15,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["cargo"],0,0,'C');
		$pdf->Cell(16,4,'',0,0,'C');		
		$pdf->Cell(72,4,$inter[$i-1]["cargo"],0,1,'C');
		control_salto_pag($pdf->GetY());		
		$pdf->Ln(22);		
	}   //for
	
	if ($nf <> 0)
	{
		$i = 0;	
		$pdf->Cell(55,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["nom"],T,1,'C');
		$pdf->Cell(55,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["cargo"],0,1,'C');
	}   //if	

	control_salto_pag($pdf->GetY());
	$pdf->Ln(9);
	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','',7);
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->RoundedRect(9,$actual,192,33,0,'');	
	$pdf->Multicell(190,3,$texto,0,'J');

	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Ln(1);
	$pdf->Cell(96,3,'Elaboró:    '.strtr($elaboro, $sustituye),0,0,'');
	$pdf->Cell(96,3,'Revisó:    '.strtr($reviso, $sustituye),0,1,'');

	$nom_pdf="../fpdf/pdf/Actas/ActaInfVer_".trim($sig_usuario)."_".$_GET['acta']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
