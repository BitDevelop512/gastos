<?php
/* 628.php
   FO-JEMPP-CEDE2-628 - Informe Control de Erogaciones Causadas en ORDOP o Misiones de Trabajo de Inteligencia y Contrainteligencia.
   (pág 255 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
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
			$consulta1= "select sigla,nombre from cx_org_sub where subdependencia='".$_SESSION["uni_usuario"]."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = odbc_result($cur1,1);
			$sig_usuario = $sigla;

			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			$this->RotatedText(95,175,$sig_usuario,35);

			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,150,150);
			$this->Cell(278,5,'SECRETO',0,1,'C');
			$this->Ln(2);

			$this->Image('sigar.png',10,17,17);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(0,0,0);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(116,5,'',0,0,'C');
			$this->Cell(12,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(116,5,'INFORME CONTROL DE EROGACIONES CAUSADAS EN ORDOP O MISIONES DE',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-628',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(116,5,'TRABAJO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'0',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(116,5,'',0,0,'C');			
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2017-05-16',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,3,'',0,0,'C',0);
			$this->Cell(125,3,'',0,0,'');
			$this->Cell(26,3,'',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,3,'',0,1,'');

			$this->RoundedRect(9,15,105,26,0,'');
			$this->RoundedRect(114,15,116,26,0,'');
			$this->RoundedRect(230,15,58,26,0,'');
			$this->RoundedRect(9,15,279,183,0,'');

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
  			$this->Cell(278,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR';
   			$this->Code39(268,200,$cod_bar,.5,5);
		}//function Footer()
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');
	require('../numerotoletras2.php');

	$pdf=new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',6);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(204);
	
	$sustituye = array ( 'Ã¡' => 'á', 'Ãº' => 'ú', 'Ã“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'Ã­' => 'í' );
	$n_bancos = array ('BBVA', 'AV VILLAS', 'DAVIVIENDA', 'BANCOLOMBIA', 'BANCO DE BOGOTA','POPULAR');
	$n_recursos = array('10 CSF', '50 SSF', '16 SSF', 'OTROS');
	$n_rubros = array('204-20-1', '204-20-2');
	$n_soportes = array('INFORME DE GIRO CEDE2', 'CONSIGNACION', 'NOTA CREDITO', 'ABONO EN CUENTA');
	$n_transacciones = array('TRANSFERENCIA', 'CONSIGNACION', 'NOTA CREDITO');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');

	$actual=$pdf->GetY();
	$pdf->Cell(276,5,'DE UJSO EXCLUSIVO',0,1,'R');			
	$pdf->Cell(60,5,'UNIDAD CENTRALIZADORA GASTOS RESERVADOS',0,0,'');	
	$pdf->Cell(46,5,'',B,1,'L');	
	$pdf->Cell(60,5,'PERIODO DEL INFORME',0,1,'');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,60,9,0,'DF');
	$pdf->RoundedRect(69,$actual,198,9,0,'DF');
	$pdf->RoundedRect(267,$actual,21,9,0,'DF');
	$pdf->Cell(59,9,'EROGACIONES',0,0,'C');
	$pdf->Cell(198,3,'ORDOP O MISIONES DE TRABAJO INTELIGENCIA Y CONTRAINTELIGENCIA DESARROLLADAS',0,0,'C');
	$pdf->Cell(21,3,'TOTAL',0,1,'C');
	$pdf->Cell(59,3,'',0,0,'C');
	$pdf->Cell(46,3,'ORDOP No.',T,0,'L');
	$pdf->Cell(53,3,'Compañía:',T,0,'L');
	$pdf->Cell(46,3,'ORDOP No.',T,0,'L');
	$pdf->Cell(53,3,'Compañía:',T,0,'L');
	$pdf->Cell(21,3,'EROGACIÓN',0,1,'C');
	$pdf->Cell(59,3,'',0,0,'C');	
	$pdf->Cell(22,3,'Misión No.',1,0,'C');
	$pdf->Cell(22,3,'Misión No.',1,0,'C');
	$pdf->Cell(22,3,'Misión No.',1,0,'C');
	$pdf->Cell(22,3,'TOTAL ORDOP',1,0,'C');
	$pdf->Cell(22,3,'Misión No.',1,0,'C');
	$pdf->Cell(22,3,'Misión No.',1,0,'C');
	$pdf->Cell(22,3,'Misión No.',1,0,'C');
	$pdf->Cell(22,3,'Misión No.',1,0,'C');
	$pdf->Cell(22,3,'TOTAL ORDOP',1,1,'C');
	$erogaciones = array('Gastos básicos diarios de participantes.','Manutención de fuentes.','Transporte.','Combustible.','Peajes','Adquisición de bienes.','Serv. profesionales o tecnicos en apoyo act de int/ci','Otros erogaciones');
	$lin = 9;
	for ($f=0;$f<9;$f++)
	{
		if ($f < 8)
		{
			$pdf->RoundedRect(9,$actual+$lin,60,3,0,'');
			$pdf->Cell(59,3,$erogaciones[$f],0,0,'');			
		}
		else
		{
			$pdf->RoundedRect(9,$actual+$lin,279,3,0,'DF');
			$pdf->Cell(59,3,'TOTAL ORDOP/MISIÓN',0,0,'R');
		}
		for ($c=1;$c<10;$c++)
		{
			$pdf->Cell(22,3,'$0.00',1,0,'R');
		}
		$pdf->Cell(21,3,'$0.00',1,1,'R');
		$lin = $lin + 3;
	}
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,140,33,0,'');
	$pdf->RoundedRect(149,$actual,139,33,0,'');	
	$pdf->Ln(26);
	$pdf->Cell(40,5,'',0,0,'');		
	$pdf->Cell(60,5,'EJECUTÓ',T,0,'C');	
	$pdf->Cell(40,5,'',0,0,'');		
	$pdf->Cell(40,5,'',0,0,'');		
	$pdf->Cell(60,5,'ORDENADOR GASTOS',T,1,'C');	

	$pdf->RoundedRect(9,$actual+33,279,23,0,'');
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Ln(3);
	$pdf->Multicell(278,3,$texto,0,'J');
	$pdf->Ln(1);
	$pdf->RoundedRect(9,$actual+56,279,4,0,'');	
	$pdf->Cell(15,5,'Elaboró:',0,0,'');
	$pdf->Cell(30,5,$_SESSION["nom_usuario"],0,0,'L');

	//$nom_pdf="../fpdf/pdf/InfGiro_".$_GET['informe']."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	//$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
 	//$pdf->Output();
	$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
