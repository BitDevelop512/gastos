<?php
/* 629.php
   FO-JEMPP-CEDE2-629 - Informe de Gastos ORDOP/MISIÓN.
   (pág 178 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
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
			$ano = date('Y');

			$consulta = "select * from cx_rel_gas where conse = '".$_GET['conse']."' and unidad = '".$uni_usuario."' and ano = '".$ano."'";
			$cur = odbc_exec($conexion,$consulta);
			$consulta_unidad = "select sigla from cx_org_sub where subdependencia = '".odbc_result($cur,4)."'";
			$cur_unidad = odbc_exec($conexion,$consulta_unidad);
			$sigla = odbc_result($cur_unidad,1);

			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			$this->RotatedText(55,200,$sigla,35);

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
			$this->Cell(55,5,'INFORME DE GASTOS',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-629',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'GASTOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'0',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(55,5,'ORDOP/MISIÓN',0,0,'C');
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
  			$fecha1 = "";
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
	require('../numerotoletras2.php');

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');

	$sustituye = array ( 'Ã¡' => 'á', 'Ãº' => 'ú', 'Ã“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'Ã­' => 'í' );
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",122);
	$total_gastos =  0;

	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->Ln(-1);
	$ano = $_GET['ano'];
	$consecu = $_GET['conse'];
	
	$consulta = "select * from cx_rel_gas where conse='$consecu' and usuario='$usu_usuario' and ano='$ano'";
	$cur = odbc_exec($conexion,$consulta);
	$conse = trim(odbc_result($cur,1));
	$fecha = substr(odbc_result($cur,2),0,10);
	$unidad = trim(odbc_result($cur,4));
	$ciudad = trim(odbc_result($cur,5));
	$comprobante = odbc_result($cur,6);
	$ordop = trim(odbc_result($cur,7));
	$nordop = trim(odbc_result($cur,8));
	$mision = trim(odbc_result($cur,9));
	$valor = trim(odbc_result($cur,12));
	$responsable = trim(odbc_result($cur,15));
	$cosecutivo = trim(odbc_result($cur,18));
	$comandante = trim(odbc_result($cur,19));
	$elabora = trim(odbc_result($cur,20));
	$reintegro = substr(str_replace(',','',trim(odbc_result($cur,21))),0);
	$comprobantes = substr(trim(odbc_result($cur,23)),1);

	$consulta_unidad = "select * from cx_org_sub where subdependencia = '".$unidad."'";
	$cur_unidad = odbc_exec($conexion,$consulta_unidad);
	$nreg_cur_unidad = odbc_num_rows($cur_unidad);
	$unidad = odbc_result($cur_unidad,4);

	$pdf->Cell(35,5,'1. UNIDAD',0,0,'');
	$pdf->Cell(76,5,$unidad,B,0,'L');
	$pdf->Cell(76,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(35,5,'2. LUGAR y FECHA',0,0,'');
	$pdf->Cell(152,5,$ciudad.'  -  '.$fecha,B,1,'L');
	$pdf->Cell(35,5,'3. COMPROBANTE No.',0,0,'');
	$pdf->Cell(70,5,$comprobantes,B,0,'C');
	$pdf->Cell(30,5,'  4. VALOR',0,0,'L');
	$pdf->Cell(52,5,'$'.$valor,0,1,'C');
	$pdf->Cell(35,5,'5. ORDOP.',0,0,'');
	$actual=$pdf->GetY();
	$pdf->Cell(70,5,$nordop.' - '.$ordop,B,0,'L');
	$pdf->Cell(17,5,'  6. MISIÓN',0,0,'L');
	$pdf->Multicell(64,4,$mision,TB,'L');

	$actual=$pdf->GetY();
	$pdf->Ln(5);
	$pdf->RoundedRect(9,$actual+5,192,5,0,'DF');
	$pdf->Cell(10,5,'ITEM',0,0,'C');
	$pdf->Cell(136,5,'CONCEPTOS DEL GASTO',1,0,'C');
	$pdf->Cell(45,5,'VALOR',1,1,'C');
	$pdf->RoundedRect(9,$actual+5,11,5,0,'');
	$pdf->Cell(10,5,'7',0,0,'C');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(181,5,'GASTOS CON SOPORTES',1,1,'L');
	$pdf->SetFont('Arial','',8);

	$total = 0;
	$consulta1 = "select * from cx_rel_dis where conse1 = '".$conse."' and tipo = 'S' and consecu = '".$cosecutivo."' and ano= '$ano'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$actual=$pdf->GetY();
	$lin = 0;
	$f = 0;
	$niv = 0;
	while($f<$nreg_cur_pag=odbc_fetch_array($cur1))
	{
		$pdf->RoundedRect(9,$actual+$lin,11,5,0,'');
		$niv++;
		$pdf->Cell(10,5,"7.".$niv,0,0,'C');

		$consulta_pag = "select nombre from cx_ctr_pag where codigo = '".odbc_result($cur1,3)."'";
		$cur_pag = odbc_exec($conexion,$consulta_pag);
		$pdf->Cell(136,5,odbc_result($cur_pag,1),1,0,'L');
		if (odbc_result($cur1,3) == 1)
		{
			$vlr = trim(odbc_result($cur1,5));	
			$gastos = $vlr - $reintegro;
		}
		else
		{
			$gastos = odbc_result($cur1,5);
		}  //if
		
		$pdf->Cell(45,5,'$'.number_format($gastos,2),1,1,'R');
		$lin = $lin + 5;
		$total = $total + $gastos;
		$f++;
	}  //while
	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'R');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(146,5,'SUMAN GASTOS CON SOPORTES',0,0,'R');
	$pdf->Cell(45,5,'$'.number_format($total,2),1,1,'R');
	$pdf->SetFont('Arial','',8);
	$total_gastos = $total_gastos + $total;

	$pdf->RoundedRect(9,$actual+5,11,10,0,'C');
	$pdf->Cell(10,5,'8',0,0,'C');
	$pdf->RoundedRect(20,$actual+5,181,10,0,'C');
	$texto = "\nGASTOS SIN FACTURA COMERCIAL. De conformidad con lo dispuesto el Articulo 616-2 del Estatuto Tributario. Casos en los cuales nos se requiere la expedición de facturas. Literal c Los responsables del régimen simplificado.";
	$pdf->Multicell(178,3,$texto,0,'J');
	$pdf->Ln(1);

	$consulta1 = "select * from cx_rel_dis where conse1 = '".odbc_result($cur,1)."' and tipo = 'N' and consecu = '".$cosecutivo."' and ano='$ano'";
	$cur1 = odbc_exec($conexion,$consulta1);

	$actual=$pdf->GetY();
	$total = 0;
	$lin = 0;
	$f = 0;
	$niv = 0;
	while($f<$nreg_cur_pag=odbc_fetch_array($cur1))
	{
		$pdf->RoundedRect(9,$actual+$lin,11,5,0,'');
		$niv++;
		$pdf->Cell(10,5,"8.".$niv,0,0,'C');

		$consulta_pag = "select nombre from cx_ctr_pag where codigo = '".odbc_result($cur1,3)."'";
		$cur_pag = odbc_exec($conexion,$consulta_pag);
			
		$pdf->Cell(136,5,odbc_result($cur_pag,1),1,0,'L');
		$pdf->Cell(45,5,'$'.number_format(odbc_result($cur1,5),2),1,1,'R');
		$total = $total + odbc_result($cur1,5);
		$lin = $lin + 5;
		$f++;
	}  //while
		
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'R');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(146,5,'SUMAN GASTOS SIN FACTURA',0,0,'R');
	$pdf->Cell(45,5,'$'.number_format($total,2),1,1,'R');
	$pdf->SetFont('Arial','',8);
	$total_gastos = $total_gastos + $total;

	$pdf->RoundedRect(9,$actual+5,192,5,0,'R');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(146,5,'TOTAL GASTOS DE LA ORDOP MISIÓN',0,0,'L');
	$pdf->Cell(45,5,'$'.number_format($total_gastos,2),1,1,'R');
	$pdf->SetFont('Arial','',8);

	$pdf->RoundedRect(9,$actual+10,192,10,0,'R');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(20,10,'9. ANEXOS: ',0,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(136,10,'Se anexan los documentos relacionados en el ítem 7 GASTOS CON SOPORTE.',0,1,'L');
	$u_sigla = substr($usu_usuario,4);
	
	if ($comandante == "")
	{ 
		$consulta_usu = "select * from cx_usu_web where usuario = 'CDO_".$u_sigla."'";
		$cur_usu = odbc_exec($conexion,$consulta_usu);
		$n_comandante = trim(odbc_result($cur_usu,4));
		$c_comandante = 'Comandante Unidad';
	}
	else
	{
		$comandante1 = explode("»",$comandante);
		$n_comandante = substr($comandante1[0],0,-1);
		$c_comandante = $comandante1[1];
	}  //if

	$actual = $pdf->GetY();
	$pdf->RoundedRect(9,$actual,96,30,0,'');
	$pdf->RoundedRect(105,$actual,96,30,0,'');
	
	$pdf->Ln(13);
	$pdf->Cell(95,5,'_____________________________________________',0,0,'C');
	$pdf->Cell(95,5,'_____________________________________________',0,1,'C');	
	$pdf->Cell(95,5,$responsable,0,0,'C');
	$pdf->Cell(95,5,$n_comandante,0,1,'C');
	$pdf->Cell(95,5,'RESPONSABLE DE LA ORDOP o MISIÓN',0,0,'C');
	$pdf->Cell(95,5,$c_comandante,0,1,'C');
	$pdf->SetFont('Arial','',8);	
	
	$pdf->Ln(3);
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Multicell(190,3,$texto,0,'J');
	$pdf->Cell(190,4,$linea,0,1,'C');
	if ($elabora == "") $elaboro = strtr(trim($_SESSION["nom_usuario"]), $sustituye);
	else $elaboro = strtr(trim($elabora), $sustituye); 
	$pdf->Cell(60,4,'Elaboró:    '.$elaboro,0,1,'');
	$pdf->Cell(190,3,$linea,0,1,'C');


	ob_end_clean();
	$nom_pdf="pdf/InfAuto_".trim($sigla1)."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
