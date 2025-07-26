<?php
/* 620.php
   FO-JEMPP-CEDE2-620 ACTA DE PROGRAMACIÓN GASTOS RESERVADOS.
   (pág 65 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

http://192.168.1.107:8086/GASTOS/fpdf/620.php
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
			$this->Cell(55,5,'ACTA DE ',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-620',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'PROGRAMACIÓN',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'0',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(55,5,'GASTOS RESERVADOS',0,0,'C');
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
		}//otatedText

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

	$sustituye = array ( 'Ã¡' => 'á', 'Ãº' => 'ú', 'Ã“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'Ã­' => 'í' );
	$buscar = array(chr(13).chr(10), chr(13), chr(10), "\r\n", "\n", "\r", "\n\r");
	$reemplazar = array("", "", "", "", "", "" , "");
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",122);
	$lugar = "";

	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln(-1);

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=266.00125) $pdf->addpage();
	} //control_salto_pag

/*
	$consulta = "select * from cx_sol_aut where conse ='".$_GET['conse']."' and ano = '".$_GET['ano']."'";
	$cur = odbc_exec($conexion,$consulta);
	$fecha = substr(odbc_result($cur,2),0,10);
	$planes = trim(decrypt1(odbc_result($cur,6), $llave));
*/
	$pdf->Cell(191,5,'DE USO EXCLUSIVO',0,1,'R');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(39,5,'LUGAR:',0,0,'');
	$pdf->Cell(110,5,$lugar,1,0,'L');
	$pdf->Cell(18,5,'ACTA NO.:',0,0,'R');
	$pdf->Cell(24,5,'',0,1,'C');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(39,5,'FECHA:',0,0,'');
	$pdf->Cell(152,5,$fecha,1,0,'L');
	$pdf->Cell(24,5,'',0,1,'C');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(39,5,'INTERVIENEN:',0,0,'');
	$pdf->Cell(152,5,'',1,1,'L');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,10,0,'');
	$pdf->Cell(39,10,'A S U N T O:',0,0,'');
	$pdf->Cell(152,10,'',1,1,'L');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,10,0,'');
	$pdf->Cell(9,10,'1.',0,0,'C');
	$pdf->RoundedRect(9,$actual,192,10,0,'L');
	$pdf->Cell(182,5,'REFERENCIAS',1,1,'L');
	$pdf->Cell(9,5,'',0,0);
	$pdf->Cell(182,5,'',1,1,'L');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,10,0,'');
	$pdf->Cell(9,10,'2.',0,0,'C');
	$pdf->RoundedRect(9,$actual,192,10,0,'L');
	$pdf->Cell(182,5,'PRESUPUESTO GASTOS RESERVADOS PLAN ANUAL DE ADQUISICIONES VIGENCIA_______/',1,1,'L');
	$pdf->Cell(9,5,'',0,0);
	$pdf->Cell(182,5,'',1,1,'L');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,55,0,'');
	$pdf->Cell(9,47,'3.',0,0,'C');
	$pdf->Cell(182,10,'PROGRAMACIÓN MENSUAL DE GASTOS RESERVADOS PARA EL SUBSISTEMA DE INTELIGENCIA Y CONTRAINTELIGENCIA',1,1,'L');

	$actual=$pdf->GetY();
	$pdf->Cell(9,5,'',0,0);
	$pdf->RoundedRect(19,$actual,182,10,0,'DF');
	$pdf->Cell(9,5,'',L,0,'C');
	$pdf->Cell(98,5,'DISCIPLINAS (UNIDADES DE INTELIGENCIA Y CIT),',L,0,'C');
	$pdf->Cell(15,5,'',L,0,'C');
	$pdf->Cell(30,5,'',L,0,'C');
	$pdf->Cell(30,5,'',L,1,'C');
	$pdf->Cell(9,5,'',0,0);
	$pdf->Cell(9,5,'NR',L,0,'C');
	$pdf->Cell(98,5,'DEPENDENCIAS Y SECCIONES DE INTELIGENCIA',L,0,'C');
	$pdf->Cell(15,5,'%',L,0,'C');
	$pdf->Cell(30,5,'V/R MENSUA',L,0,'C');
	$pdf->Cell(30,5,'V/R ANUAL',L,1,'C');

	$actual=$pdf->GetY();
	$pdf->Cell(9,5,'',0,0,'C');
	$pdf->RoundedRect(19,$actual+5,182,5,0,'');
	$pdf->Cell(9,5,'1',1,0,'C');
	$pdf->Cell(98,5,'Capacidad inteligencia (CAIMI, BRIMI1 Y BRIMI2)',1,0,'L');
	$pdf->Cell(15,5,'',1,0,'C');
	$pdf->Cell(30,5,'$0.00',1,0,'R');
	$pdf->Cell(30,5,'$0.00',1,1,'R');

	$pdf->Cell(9,5,'',0,0,'C');
	$pdf->RoundedRect(19,$actual+10,182,5,0,'');
	$pdf->Cell(9,5,'2',1,0,'C');
	$pdf->Cell(98,5,'Capacidad inteligencia (CACIM, BRCIM1 Y BRCIM2)',1,0,'L');
	$pdf->Cell(15,5,'',1,0,'C');
	$pdf->Cell(30,5,'$0.00',1,0,'R');
	$pdf->Cell(30,5,'$0.00',1,1,'R');

	$pdf->Cell(9,5,'',0,0,'C');
	$pdf->RoundedRect(19,$actual+15,182,5,0,'');
	$pdf->Cell(9,5,'3',1,0,'C');
	$pdf->Cell(98,5,'Capacidad inteligencia (G2 Y B2)',1,0,'L');
	$pdf->Cell(15,5,'',1,0,'C');
	$pdf->Cell(30,5,'$0.00',1,0,'R');
	$pdf->Cell(30,5,'$0.00',1,1,'R');

	$pdf->Cell(9,5,'',0,0,'C');
	$pdf->RoundedRect(19,$actual+20,182,5,0,'');
	$pdf->Cell(9,5,'4',1,0,'C');
	$pdf->Cell(98,5,'CEDE2',1,0,'L');
	$pdf->Cell(15,5,'',1,0,'C');
	$pdf->Cell(30,5,'$0.00',1,0,'R');
	$pdf->Cell(30,5,'$0.00',1,1,'R');

	$pdf->Cell(9,5,'',0,0,'C');
	$pdf->RoundedRect(19,$actual+25,182,5,0,'');
	$pdf->Cell(9,5,'5',1,0,'C');
	$pdf->Cell(98,5,'CEDE2 Reserva estratégica.',1,0,'L');
	$pdf->Cell(15,5,'',1,0,'C');
	$pdf->Cell(30,5,'$0.00',1,0,'R');
	$pdf->Cell(30,5,'$0.00',1,1,'R');

	$pdf->Cell(9,5,'',0,0,'C');
	$pdf->RoundedRect(19,$actual+25,182,5,0,'DF');
	$pdf->Cell(107,5,'TOTAL',1,0,'L');
	$pdf->Cell(15,5,'',1,0,'C');
	$pdf->Cell(30,5,'$0.00',1,0,'R');
	$pdf->Cell(30,5,'$0.00',1,1,'R');
	$pdf->Cell(182,5,'',0,1,'R');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,10,0,'');
	$pdf->Cell(9,10,'4.',0,0,'C');
	$pdf->RoundedRect(9,$actual,192,10,0,'L');
	$pdf->Cell(182,5,'PROGRAMACIÓN MENSUAL A UNIDADES, DEPENDENCIAS Y SECCIONES DE INTELIGENCIA Y CONTRAINTELIGENCIA',1,1,'L');
	$pdf->Cell(9,5,'',0,0);
	$pdf->Cell(182,5,'',1,1,'L');

	for ($i=1;$i<=4;$i++)
	{
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,35,0,'');
		$pdf->Cell(9,30,'4.'.$i,0,0,'C');
		$actual=$pdf->GetY();
		$pdf->RoundedRect(19,$actual,182,10,0,'DF');
		$pdf->Cell(42,5,'Sigla Unidad centralizadora y',L,0,'C');
		$pdf->Cell(80,5,'',L,0,'C');
		$pdf->Cell(30,5,'',L,0,'C');
		$pdf->Cell(30,5,'',L,1,'C');
		$pdf->Cell(9,30,'',0,0,'C');
		$pdf->Cell(42,5,'Unidades orgánicas y agregadas',L,0,'C');
		$pdf->Cell(80,5,'CONCEPTO',L,0,'C');
		$pdf->Cell(30,5,'V/R MENSUAL HASTA',L,0,'C');
		$pdf->Cell(30,5,'V/R ANUAL HASTA',L,1,'C');

		$pdf->Cell(9,5,'',0,0);
		$pdf->Cell(42,20,'',1,0,'L');
		$pdf->Cell(80,5,'',1,0,'L');
		$pdf->Cell(30,5,'$0.00',1,0,'R');
		$pdf->Cell(30,5,'$0.00',1,0,'R');
		$pdf->Cell(5,5,'',0,1,'C');

		$pdf->Cell(51,5,'',0,0);
		$pdf->Cell(80,5,'',1,0,'L');
		$pdf->Cell(30,5,'$0.00',1,0,'R');
		$pdf->Cell(30,5,'$0.00',1,0,'R');
		$pdf->Cell(5,5,'',0,1,'C');

		$pdf->Cell(51,5,'',0,0);
		$pdf->Cell(80,5,'',1,0,'L');
		$pdf->Cell(30,5,'$0.00',1,0,'R');
		$pdf->Cell(30,5,'$0.00',1,0,'R');
		$pdf->Cell(5,5,'',0,1,'C');

		$pdf->Cell(51,5,'',0,0);
		$pdf->Cell(80,5,'',1,0,'L');
		$pdf->Cell(30,5,'$0.00',1,0,'R');
		$pdf->Cell(30,5,'$0.00',1,0,'R');
		$pdf->Cell(5,5,'',0,1,'C');

		$pdf->Cell(9,5,'',0,0);
		$pdf->Cell(122,5,'TOTAL',1,0,'L');
		$pdf->Cell(30,5,'$0.00',1,0,'R');
		$pdf->Cell(30,5,'$0.00',1,1,'R');
	}   //for
	$pdf->Cell(182,5,'',0,1,'L');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(9,5,'5.',0,0,'C');
	$pdf->Cell(122,5,'TOTAL RECURSOS ASIGNADOS SICIE',L,0,'L');
	$pdf->Cell(30,5,'$0.00',L,0,'R');
	$pdf->Cell(30,5,'$0.00',L,1,'R');
	$pdf->Cell(182,5,'',0,1,'L');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,10,0,'');
	$pdf->Cell(9,10,'6.',0,0,'C');
	$pdf->RoundedRect(9,$actual,192,10,0,'L');
	$pdf->Cell(182,5,'INSTRUCCIONES ADMINISTRATIVAS EN LA PLANEACIÓN, ORDENACIÓN, EJECUCIÓN, JUSTIFICACIÓN Y CONTROL DE LOS',L,1,'L');
	$pdf->Cell(9,10,'.',0,0,'C');
	$pdf->Cell(182,5,'RECURSOS DE GASTOS RESERVADOS.',L,1,'L');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(9,5,'',0,0);
	$pdf->Cell(182,5,'',L,1,'L');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(9,5,'',0,0);
	$pdf->Cell(182,5,'',L,1,'L');
	$pdf->Cell(182,5,'',0,0,'L');

	//Firmas
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->Ln(2);
	if ($ajuste > 0) $pdf->Ln($ajuste);
	$pdf->Ln(20);

	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Ln(1);
	$pdf->SetFont('Arial','',7);
	$actual = $pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,34,B,'');
	$pdf->Multicell(190,3,$texto,0,'J');
	$pdf->SetFont('Arial','',8);
	$pdf->Ln(1);
	$actual = $pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,B,'');
	$pdf->Cell(95,4,'Elaboró:    '.$n_elaboro,0,0,'');
	$pdf->Cell(95,4,'Revisó:    '.$n_reviso,0,1,'');

	ob_end_clean();
	$nom_pdf="pdf/InfAuto_".trim($sigla1)."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";
}
?>

