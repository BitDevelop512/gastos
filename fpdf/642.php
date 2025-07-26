<?php
/* 642.php
   FO-JEMPP-CEDE2-626 Estudio Sucinto de la Necesidad.
   (pág 85 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
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

			$consulta1 = "select sigla,nombre from cx_org_sub where subdependencia='".$_SESSION["uni_usuario"]."'";
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
			$this->Cell(8,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(55,5,'ESTUDIO SUCINTO DE ',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-642',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'LA NECESIDAD',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'3',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(55,5,'',0,0,'C');
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
	$pdf->SetFont('Arial','',12);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	
	$sustituye = array ( 'Ã¡' => 'á', 'Ãº' => 'ú', 'Ã“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'Ã­' => 'í' );
	$buscar = array(chr(13).chr(10), chr(13), chr(10), "\r\n", "\n", "\r", "\n\r");
	$reemplazar = array("", "", "", "", "", "" , "");
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",122);
	$lugar = "";
	
	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln(-1);
/*	
	$consulta = "select * from cx_sol_aut where conse ='".$_GET['conse']."' and ano = '".$_GET['ano']."'";
	$cur = odbc_exec($conexion,$consulta);	
	$fecha = substr(odbc_result($cur,2),0,10);
	$planes = trim(decrypt1(odbc_result($cur,6), $llave));
*/
	$pdf->Cell(33,5,'Unidad Centralizadora',0,0,'L');
	$pdf->Cell(100,5,'',B,0,'L');
	$pdf->Cell(58,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(25,5,'Radicado No.',0,0,'');
	$pdf->Cell(166,5,$radicado,B,1,'L');
	$pdf->Cell(25,5,'Lugar y Fecha:',0,0,'');
	$pdf->Cell(166,5,$lugar." - ".$fecha,B,1,'L');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual+5,192,5,0,'DF');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(20,5,'I',0,0,'C');
	$pdf->Cell(171,5,'INFORMACIÓN GENERAL',1,1,'L');
	$pdf->SetFont('Arial','',8);

	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,15,0,'D');
	$pdf->Cell(20,15,'1',0,0,'C');
	$pdf->Cell(35,15,'DEPENDENCIA DE',1,0,'L');
	$pdf->Cell(136,15,'',1,0,'L');
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,15,'',0,0,'C');
	$pdf->Cell(35,10,'LA NECESIDAD',0,1,'L');
	
	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,15,0,'D');
	$pdf->Cell(20,15,'2',0,0,'C');
	$pdf->Cell(35,15,'GERENTE',1,0,'L');
	$pdf->Cell(136,5,'Nombre:',1,0);
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(55,15,'',0,0,'C');
	$pdf->Cell(136,5,'Cargo:',1,1,'L');
	$pdf->Cell(55,15,'',0,0,'C');
	$pdf->Cell(136,5,'Acto administrativo de nombramiento:',1,1,'L');
	
	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,15,0,'D');
	$pdf->Cell(20,15,'3',0,0,'C');
	$pdf->Cell(35,15,'COMITÉ',1,0,'L');
	$pdf->Cell(136,5,'Nombre:',1,0);
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,15,'',0,0,'C');
	$pdf->Cell(35,10,'ESTRUCTURADOR',0,0,'L');	
	$pdf->Cell(136,5,'Cargo:',1,1,'L');
	$pdf->Cell(55,15,'',0,0,'C');
	$pdf->Cell(136,5,'Acto administrativo de nombramiento:',1,1,'L');	
	
	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,15,0,'D');
	$pdf->Cell(20,15,'4',0,0,'C');
	$pdf->Cell(35,15,'COMITÉ',1,0,'L');
	$pdf->Cell(136,5,'Nombre:',1,0);
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,15,'',0,0,'C');
	$pdf->Cell(35,10,'EVALUADOR',0,0,'L');	
	$pdf->Cell(136,5,'Cargo:',1,1,'L');
	$pdf->Cell(55,15,'',0,0,'C');
	$pdf->Cell(136,5,'Acto administrativo de nombramiento:',1,1,'L');		

	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,15,0,'D');
	$pdf->Cell(20,15,'5',0,0,'C');
	$pdf->Cell(35,15,'SUPERVISOR DEL',1,0,'L');
	$pdf->Cell(136,5,'Nombre:',1,0);
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,15,'',0,0,'C');
	$pdf->Cell(35,10,'CONTRATO',0,0,'L');	
	$pdf->Cell(136,5,'Cargo:',1,1,'L');
	$pdf->Cell(55,15,'',0,0,'C');
	$pdf->Cell(136,5,'Acto administrativo de nombramiento:',1,1,'L');	

	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,10,0,'D');
	$pdf->Cell(20,10,'6',0,0,'C');
	$pdf->Cell(35,10,'CERTIFICADO DE',1,0,'L');
	$pdf->Cell(136,5,'No.',1,0);
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,15,'',0,0,'C');
	$pdf->Cell(35,7,'DISPONIBILIDAD',0,0,'L');	
	$pdf->Cell(136,5,'Fecha expedición:',1,1,'L');

	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(20,5,'II',0,0,'C');
	$pdf->Cell(171,5,'CONTENIDOS DE LOS ESTUDIOS PREVIOS',1,1,'L');
	$pdf->SetFont('Arial','',8);
	
	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,10,0,'D');
	$pdf->Cell(20,10,'1',0,0,'C');
	$pdf->Cell(35,10,'DESCRIPCIÓN DE',1,0,'L');
	$pdf->Cell(136,10,'',1,0,'L');
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,10,'',0,0,'C');
	$pdf->Cell(35,5,'LA NECESIDAD',0,1,'L');	

	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,10,0,'D');
	$pdf->Cell(20,10,'2',0,0,'C');
	$pdf->Cell(35,10,'OBJETO',1,0,'L');
	$pdf->Cell(136,10,'',1,0,'L');
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,10,'',0,0,'C');
	$pdf->Cell(35,5,'CONTRACTUAL',0,1,'L');	

	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,10,0,'D');
	$pdf->Cell(20,10,'3',0,0,'C');
	$pdf->Cell(35,10,'CONDICIÓN',1,0,'L');
	$pdf->Cell(136,10,'',1,0,'L');
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,10,'',0,0,'C');
	$pdf->Cell(35,5,'TÉCNICA',0,1,'L');	

	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,10,0,'D');
	$pdf->Cell(20,10,'4',0,0,'C');
	$pdf->Cell(35,10,'ANÁLISIS DE',1,0,'L');
	$pdf->Cell(136,10,'',1,0,'L');
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,10,'',0,0,'C');
	$pdf->Cell(35,5,'PRECIOS',0,1,'L');
	
	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,21,29,0,'D');
	$pdf->RoundedRect(30,$actual,35,29,0,'D');
	$pdf->RoundedRect(65,$actual,136,29,0,'D');
	$pdf->Cell(20,29,'5',0,0,'C');
	$pdf->Cell(35,5,'CIRCUNSTANCIAS',0,1,'L');
	$pdf->Cell(20,1,'',0,0,'C');
	$pdf->Cell(35,1,'POR LAS CUALES',0,1,'L');	
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(35,5,'SE DEBE',0,1,'L');
	$pdf->Cell(20,1,'',0,0,'C');
	$pdf->Cell(35,1,'ADELANTAR EL',0,1,'L');	
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(35,5,'PROCEDIMIENTO',0,1,'L');	
	$pdf->Cell(20,1,'',0,0,'C');
	$pdf->Cell(35,1,'ESPECIAL DE',0,1,'L');	
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(35,5,'CONTRATACIÓN',0,1,'L');
	$pdf->Cell(20,1,'',0,0,'C');
	$pdf->Cell(35,1,'(LEY 1219 DE',0,1,'L');
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(35,5,'2008)',0,1,'L');

	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,10,0,'D');
	$pdf->Cell(20,10,'6',0,0,'C');
	$pdf->Cell(35,10,'VALOR DEL',1,0,'L');
	$pdf->Cell(136,10,'',1,0,'L');
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,10,'',0,0,'C');
	$pdf->Cell(35,5,'CONTRATO',0,1,'L');	

	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,10,0,'D');
	$pdf->Cell(20,10,'7',0,0,'C');
	$pdf->Cell(35,10,'RIESGO Y FORMA',1,0,'L');
	$pdf->Cell(136,10,'',1,0,'L');
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,10,'',0,0,'C');
	$pdf->Cell(35,5,'DE MITIGARLOS',0,1,'L');	
	
	if ($pdf->GetY()>=259.00125) $pdf->addpage();		
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,10,0,'D');
	$pdf->Cell(20,10,'8',0,0,'C');
	$pdf->Cell(35,10,'GARANTÍAS',1,0,'L');
	$pdf->Cell(136,10,'',1,0,'L');
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,10,'',0,0,'C');
	$pdf->Cell(35,5,'EXIGIDAS',0,1,'L');	

	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,10,0,'D');
	$pdf->Cell(20,10,'9',0,0,'C');
	$pdf->Cell(35,10,'PLAZO',1,0,'L');
	$pdf->Cell(136,10,'',1,0,'L');
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,10,'',0,0,'C');
	$pdf->Cell(35,5,'EJECUCIÓN',0,1,'L');	
		
	if ($pdf->GetY()>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,10,0,'D');
	$pdf->Cell(20,10,'10',0,0,'C');
	$pdf->Cell(35,10,'LUGAR DE',1,0,'L');
	$pdf->Cell(136,10,'',1,0,'L');
	$pdf->Cell(5,5,'',0,1);
	$pdf->Cell(20,10,'',0,0,'C');
	$pdf->Cell(35,5,'EJECUCIÓN',0,1,'L');					

	if ($actual>=259.00125) $pdf->addpage();	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,96,30,0,'D');	
	$pdf->RoundedRect(105,$actual,96,30,0,'D');	
	$pdf->Ln(24);
	$pdf->Cell(96,5,'Comité Estructurador',0,0,'C');
	$pdf->Cell(96,5,'Gerente del Proyecto',0,1,'C');	

	if ($actual>=259.00125) $pdf->addpage();		
	$actual=$pdf->GetY();	
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Ln(2);
	$pdf->Multicell(190,3,$texto,0,'J');
	$pdf->Ln(-3);
	$pdf->Cell(190,5,$linea,0,1,'C');
	$actual=$pdf->GetY();	
	$pdf->Cell(192,5,'[1]Comités estructurador y evaluador. No es necesario el nombramiento de un comité plural',0,1,'L');
			
	ob_end_clean();
	$nom_pdf="pdf/InfAuto_".trim($sigla1)."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	//$pdf->Output();
	$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>

