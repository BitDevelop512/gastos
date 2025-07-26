<?php
session_start();
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 450);
date_default_timezone_set("America/Bogota");
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
		}//function Header

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
 		}//function Footer()
	}//class PDF extends PDF_Rotate

	$pdf=new PDF('P','mm',array(52,220));		//Tamaño página
	$pdf->SetMargins(0.3, 0.3 , 0.3); 			//márgenes izquierda, arriba y derecha: 
	
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',6);
	$pdf->SetTitle(':: BILLAR :: Sistema Integrado ::');
	$pdf->SetAuthor('FMR');
	
	$linea = str_repeat("_",52);
	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',6);
	$pdf->Ln(2);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(0.3,$actual,52,5,0,'DF');
	$pdf->Cell(5,5,'ID',0,0,'C');
	$pdf->Cell(15,5,'PRODUCTO',1,0,'C');
	$pdf->Cell(15,5,'CANTIDAD',1,0,'C');
	$pdf->Cell(17,5,'VALOR',1,1,'C');


	$a = 0;
	while($a<50)
	{
		$actual=$pdf->GetY();
		$pdf->RoundedRect(0.3,$actual,192,5,0,'D');
		$pdf->Cell(5,5,$a,0,0,'C');
		$pdf->Cell(15,5,$producto,1,0,'C');
		$pdf->Cell(15,5,$qty,1,0,'C');
		$pdf->Cell(17,5,$valor,1,1,'C');
		$a++;
	}

	$pdf->Output();	
//	$file=basename(tempnam(getcwd(),'tmp'));
//	$pdf->Output($file);
//	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
