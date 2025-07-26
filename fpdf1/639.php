<?php
/* 639.php
   FO-JEMPP-CEDE2-639 - Planilla de Gastos Básicos.
   (pág 187 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
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
			$this->Cell(116,5,'PLANILLA GASTOS BASICOS',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-639',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(116,5,'',0,0,'C');
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
  			$fecha1="";
  			$this->SetY(-10);
  			$this->SetFont('Arial','',7);
  			$this->Cell(190,4,'SIGAR - '.$fecha1,0,1,'');
  			$this->Ln(-4);
  			$this->SetFont('Arial','B',8);
  			$this->SetTextColor(255,150,150);
  			$this->Cell(278,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR'."-".$_GET['conse']."/".$_GET['ano'];
   			//$this->Code39(268,200,$cod_bar,.5,5);
   			$this->Code39(248,200,$cod_bar,.5,5);
		}//function Footer()
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');
	require('../numerotoletras2.php');
	
	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=180.00125) 
		{
			$pdf->addpage();
		}
	} //control_salto_pag

	$pdf=new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',7);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(204);
	
	$sustituye = array ( 'Ã¡' => 'á', 'Ãº' => 'ú', 'Ã“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'Ã­' => 'í' );
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",203);   
	
	$consulta_unidad = "select * FROM cx_org_sub where subdependencia = '".$uni_usuario."'";
	$cur_unidad = odbc_exec($conexion,$consulta_unidad);
    $sigla = trim(odbc_result($cur_unidad,4));

	$consulta = "select * from cx_gas_bas where unidad = '".$uni_usuario."' and conse = '".$_GET['conse']."' and ano = '".$_GET['ano']."' and interno = '".$_GET['interno']."'";
	$cur = odbc_exec($conexion,$consulta);
	$ciudad = trim(odbc_result($cur,5));
	$fecha = substr(odbc_result($cur,2),0,10); 
	$ordop = trim(odbc_result($cur,7))." - ".strtr(trim(odbc_result($cur,6)), $sustituye);	
	$mision = trim(odbc_result($cur,8));
	$tarifa1 = odbc_result($cur,13);
	$tarifa2 = odbc_result($cur,14);
	$tarifa3 = odbc_result($cur,15);
	$interno = odbc_result($cur,16);
	$elabora = trim(odbc_result($cur,19));
	if ($elabora == "") $elabora = $_SESSION["nom_usuario"];
	
	$actual=$pdf->GetY();
	$pdf->Cell(276,5,'DE USO EXCLUSIVO',0,1,'R');			
	$pdf->Cell(36,5,'Unidad/Dependencia/Sección',0,0,'');	
	$pdf->Cell(67,5,$sigla,B,1,'L');	
	$pdf->Cell(23,5,'Lugar y Fecha',0,0,'');
	$pdf->Cell(80,5,$ciudad.'  -  '.$fecha,B,0,'L');
	$pdf->Cell(15,5,'',0,0,'L');
	$pdf->Cell(15,5,'ORDOP No.',0,0,'L');
	$pdf->Cell(65,5,$ordop,1,0,'C');
	$pdf->Cell(3,5,'',0,0,'L');
	$pdf->Cell(20,5,'MISIÓN No.',0,0,'C');
	$pdf->Cell(56,5,$mision,1,1,'C');	

 	$pdf->Ln(4); 	
	$pdf->Cell(120,5,'',0,0,'');
	$pdf->Cell(108,5,'TARIFA FUERA DE LA SEDE (F.S) PERNOCTADO',1,0,'');
	$pdf->Cell(50,5,'$'.number_format($tarifa1,2),1,1,'R');
	$pdf->Cell(120,5,'',0,0,'');
	$pdf->Cell(108,5,'TARIFA FUERA DE LA SEDE (F.S) NO PERNOCTADO',1,0,'');	
	$pdf->Cell(50,5,'$'.number_format($tarifa2,2),1,1,'R');	
	$pdf->Cell(120,5,'',0,0,'');
	$pdf->Cell(108,5,'TARIFA EN LA SEDE',1,0,'');
	$pdf->Cell(50,5,'$'.number_format($tarifa3,2),1,1,'R');
	
 	$pdf->Ln(3); 	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,279,10,0,'');
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(6,5,'',0,0,'C');
	$pdf->Cell(21,10,'',1,0,'C');
	$pdf->Cell(55,10,'GRADO, APELLIDO Y NOMBRES O',1,0,'C');
	$pdf->Cell(98,10,'',1,0,'C');
	$pdf->Cell(50,5,'CANTIDAD DIAS ASIGNADOS',1,0,'C');
	$pdf->Cell(20,10,'',1,0,'C');
	$pdf->Cell(28,5,'FIRMA/HUELLA',0,1,'C');
	
	$pdf->Cell(6,5,'No.',0,0,'C');
	$pdf->Cell(21,5,'CEDULA',0,0,'C');
	$pdf->Cell(55,5,'CODIGO OPERACIONAL DEL PARTICIPANTE',0,0,'C');
	$pdf->Cell(98,5,'CIUDAD',0,0,'C');
	$pdf->Cell(18,5,'FS. Pernoctado',1,0,'C');
	$pdf->Cell(21,5,'FS. no Pernoctado',1,0,'C');
	$pdf->Cell(11,5,'En sede',1,0,'C');
	$pdf->Cell(20,5,'VALOR',0,0,'C');
	$pdf->Cell(28,5,'CONSIGNACIÓN/GIRO',0,1,'C');
	$pdf->SetFont('Arial','',7);

	$consulta1 = "select * from cx_gas_dis where interno = '".$interno."' order by conse";
	$cur1 = odbc_exec($conexion,$consulta1); 
	$nreg_cur1 = odbc_num_rows($cur1);
	$fir_res = trim(odbc_result($cur,12));

	//Busca imagen de la firma
	$consulta_fr = "select firma, usuario FROM cx_usu_web WHERE nombre='$fir_res'";
	$cur_fr = odbc_exec($conexion, $consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)
	{
		$f_aprobo = trim(odbc_result($cur_fr,1));
		$usuario_fr = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_aprobo);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$usuario_fr.'.png';
		$success = file_put_contents($file, $data);
		$tamaño = getimagesize($file);
		if ($tamaño[0] <> 317) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';

	$actual=$pdf->GetY();	
	$x = $pdf->Getx();
	$y = $pdf->Gety();			
	$lin = 0;
	$val_total = 0;
	$f = 0;
	while($f<$nreg_cur1=odbc_fetch_array($cur1))
	{
		$participante = trim(odbc_result($cur1,4));
		$ciudad_o = trim(odbc_result($cur1,5));
		$l_participante = strlen($participante);
		$l_ciudad_o = strlen($ciudad_o);
		$l_max = max($l_participante, $l_ciudad_o);

		if ($l_max <= 65)
		{
			if ($l_ciudad_o <= 65) $alto = 5;
			else 		
			{
				$alto = ($l_ciudad_o / 20) * 2;  
				$alto = round($alto, 0, PHP_ROUND_HALF_UP);
			}   //if
		}
		else
		{
			if ($l_participante <= 34) $alto = 5;
			else
			{
				$alto = ($l_participante / 5) * 2;  
				$alto = round($alto, 0, PHP_ROUND_HALF_UP);
			}   //if
		}   //if 

		$alto = $alto + 2;
		$pdf->RoundedRect(9,$y,7,$alto,0,'');
		$pdf->Multicell(6,$alto,$f+1,0,'C');
		$pdf->SetXY($x+6,$y);
		$pdf->Multicell(21,$alto,trim(odbc_result($cur1,3)),1,'L');
		$pdf->RoundedRect(37,$y,55,$alto,0,'');
		$pdf->SetXY($x+27,$y);
		$pdf->Multicell(55,3.5,$participante,0,'L');
		$pdf->RoundedRect(92,$y,98,$alto,0,'');
		$pdf->SetXY($x+82,$y);
		$pdf->Multicell(98,3.5,$ciudad_o,0,'L');
		$pdf->SetXY($x+180,$y);
		$pdf->Multicell(18,$alto,trim(odbc_result($cur1,6)),1,'C');
		$pdf->SetXY($x+198,$y);
		$pdf->Multicell(21,$alto,trim(odbc_result($cur1,7)),1,'C');
		$pdf->SetXY($x+219,$y);
		$pdf->Multicell(11,$alto,trim(odbc_result($cur1,8)),1,'C');
		$pdf->SetXY($x+230,$y);
		$pdf->Multicell(20,$alto,'$'.trim(odbc_result($cur1,9)),1,'R');	

		$congir = trim(odbc_result($cur1,11));
		if ($congir == 'S') $firhue = "Anexo Consignación"; 
		else if ($congir == 'N') $firhue = " "; 
		else if ($congir == 'G') $firhue = "Giro"; 
		else if ($congir == 'T') $firhue = "Transferencia"; 
		else $firhue = "Transferencia";
		$pdf->SetXY($x+250,$y);
		$pdf->Multicell(28,$alto,$firhue,1,'C');

		$val_total = $val_total + odbc_result($cur1,10);
		$f++;
		control_salto_pag($pdf->GetY());
		$y = $pdf->Gety();    
	}   //while

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY(); 
	$pdf->SetFont('Arial','B',7);	
	$pdf->RoundedRect(9,$actual,231,6,0,'R');
	$pdf->Cell(230,6,'SUMAN',0,0,'R');
	$pdf->RoundedRect(240,$actual,20,6,0,'R');	
	$pdf->Cell(20,6,wims_currency($val_total),0,0,'R');
	$pdf->RoundedRect(260,$actual,28,6,0,'R');	
	$pdf->Cell(28,6,'',0,1,'C');	
	$pdf->SetFont('Arial','',7);
	$actual=$pdf->GetY();
	
	control_salto_pag($pdf->GetY());
	$pdf->Ln(22);
	$actual=$pdf->GetY();
	//$pdf->Image($file,132,$actual-20,30,26);
	$pdf->Ln(4);
	$pdf->Cell(278,5,'_____________________________________________',0,1,'C');	
	$pdf->Cell(278,5,$fir_res,0,1,'C');
	$pdf->Cell(278,5,'       RESPONSABLE DE LA MISIÓN       ',0,1,'C');

	$actual=$pdf->GetY();
	control_salto_pag($pdf->GetY());	
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Ln(8);
	$pdf->Cell(278,3,$linea,0,1,'C');	
	$pdf->Multicell(278,3,$texto,0,'J');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,279,5,0,'');
	$pdf->Cell(15,5,'Elaboró:    '.$elabora,0,0,'');

	$nom_pdf="../fpdf/pdf/Planillas/".$_GET['ano']."/PlanGas_".trim($sigla)."_".$_GET['conse']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");
	$file=basename(tempnam(getcwd(),'tmp'));

	$pdf->Output();	
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
