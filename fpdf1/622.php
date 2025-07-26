<?php
/* 622.php
   FO-JEMPP-CEDE2-622 - ACTA PAGO DE RECOMPENSAS.
   (pág 191 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
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
			$consulta = "select * from cx_inf_eje where conse = '".$_GET['conse']."'";
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
			$this->Cell(70,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(55,5,'',0,0,'C');
			$this->Cell(8,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(55,5,'ACTA PAGO DE',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-622',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'RECOMPENSAS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'4',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(55,5,'',0,0,'C');			
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2018-07-10',0,1,'');

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
	$buscar = array(chr(13).chr(10), chr(13), chr(10), "\r\n", "\n", "\r", "\n\r");
	$reemplazar = array("", "", "", "", "", "" , "");
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",122);

	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual-3,192,22,0,'');
	$pdf->Ln(-1);

	$consulta = "select * from cx_inf_eje where conse = '".$_GET['conse']."' and usuario = '".$usu_usuario."'";
	$cur = odbc_exec($conexion,$consulta);
	$fecha = substr(odbc_result($cur,2),0,10); 
	$unidad = odbc_result($cur,4);
	$ciudad = trim(odbc_result($cur,5));
	$n_ordop = trim(odbc_result($cur,6));
	$ordop = trim(odbc_result($cur,7));
	$mision = trim(odbc_result($cur,8));
	$recursos = trim(odbc_result($cur,9));
	$sitio = trim(odbc_result($cur,10));
    $fecha1 = str_replace('/','-',trim(odbc_result($cur,11)));
    $fecha2 = str_replace('/','-',trim(odbc_result($cur,12)));
    $fecha1_1 = date_create($fecha1);
    $fecha2_2 = date_create($fecha2);  
    $diff = date_diff($fecha1_1,$fecha2_2);
    $lapso = str_replace('days','días',$diff->format("%a days")) + 1;
	$factor = odbc_result($cur,13);
	$actividades = strtr(trim(odbc_result($cur,14)), $sustituye);	
	$actividades1 = str_replace($buscar, $reemplazar, $actividades);	
	
	$sintesis = strtr(trim(odbc_result($cur,15)), $sustituye);
	$sintesis1 = str_replace($buscar, $reemplazar, $sintesis);	
	$aspectos = strtr(trim(odbc_result($cur,16)), $sustituye);
	$aspectos1 = str_replace($buscar, $reemplazar, $aspectos);
	$bienes = strtr(trim(odbc_result($cur,17)), $sustituye);
	$bienes1 = str_replace($buscar, $reemplazar, $bienes);
	$personal = strtr(trim(odbc_result($cur,18)), $sustituye);
	$personal1 = str_replace($buscar, $reemplazar, $personal);	
	$equipo = strtr(trim(odbc_result($cur,19)), $sustituye);
	$equipo1 = str_replace($buscar, $reemplazar, $equipo);
	$responsable = strtr(trim(odbc_result($cur,20)), $sustituye);
	
	$consulta_unidad = "select * FROM cx_org_sub where subdependencia = '".$unidad."'";
	$cur_unidad = odbc_exec($conexion,$consulta_unidad);
	$sigla_unidad = odbc_result($cur_unidad,4);	

	$pdf->Cell(190,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->RoundedRect(9,$actual+4,40,5,0,'');
	$pdf->Cell(39,5,'NOMBRE UNIDAD:',0,0,'');
	$pdf->Cell(152,5,$sigla_unidad,1,1,'L');
	$pdf->RoundedRect(9,$actual+9,40,5,0,'');
	$pdf->Cell(39,5,'LUGAR Y FECHA:',0,0,'');
	$pdf->Cell(50,5,$ciudad,1,0,'L');
	$pdf->Cell(20,5,'FECHA',1,0,'L');
	$pdf->Cell(30,5,$fecha,1,0,'L'); 
	$pdf->Cell(25,5,'RADICADO',1,0,'L');
	$pdf->Cell(27,5,$radicado,1,1,'L'); 
	$pdf->RoundedRect(9,$actual+14,40,5,0,'');
	$pdf->Cell(39,5,'ORDOP',0,0,'');
	$pdf->Cell(70,5,$n_ordop." - ".$ordop,1,0,'L');
	$pdf->Cell(30,5,'MISIÓN',1,0,'L');
	$pdf->Cell(52,5,$mision,1,1,'C');
	$pdf->RoundedRect(9,$actual+19,40,5,0,'');
	$pdf->Cell(39,5,'Sitio de desarrollo',0,0,'L');
	$pdf->Cell(152,5,$sitio,1,1,'L');
	$pdf->RoundedRect(9,$actual+24,40,5,0,'');
	$pdf->Cell(39,5,'Factor de amenaza',0,0,'L');
	$pdf->Cell(152,5,$factor,1,1,'L');
	$pdf->RoundedRect(9,$actual+29,40,5,0,'');
	$pdf->Cell(39,5,'Lapso de la ORDOP/misión',0,0,'L');
	$pdf->Cell(152,5,$lapso,1,1,'L');
	$pdf->RoundedRect(9,$actual+34,40,5,0,'');
	$pdf->Cell(39,5,'Recursos asignados',0,0,'L');
	$pdf->Cell(152,5,"$".$recursos,1,1,'L');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');	
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(190,5,'1. ACTIVIDADES DE INTELIGENCIA Y CONTRAINTELIGENCIA REALIZADAS:',0,1,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Multicell(191,4,$actividades1,0,'L');	
	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');	
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(190,5,'2. SÍNTESIS DE LA PRODUCCIÓN:',0,1,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Multicell(191,5,$sintesis1,0,'L');	
	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');	
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(190,5,'3. ASPECTOS ADMINISTRATIVOS. (DETALLES DE GASTOS SIN SOPORTES):',0,1,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Multicell(191,5,$aspectos1."\n",0,'L');		

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');	
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(190,5,'4. BIENES ADQUIRIDOS EN DESARROLLO DE LA ORDOP O MISIÓN',0,1,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Multicell(191,5,$bienes1."\n",0,'L');	
	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');	
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(190,5,'5. PERSONAL PARTICIPANTE:',0,1,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Multicell(191,5,$personal1."\n",0,'L');	
	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');	
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(190,5,'6.	EQUIPO ESPECIALIZADO Y AUTOMOTOR EMPLEADO:',0,1,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Multicell(191,5,$equipo1."\n",0,'L');	

	$pdf->Cell(190,4,$linea,0,1,'C');
	$actual = $pdf->GetY();
	$pdf->Ln(18);
	$pdf->Cell(64,5,'',0,0,'C');	
	$pdf->Cell(65,5,$responsable,0,1,'C');
	$pdf->Cell(64,5,'',0,0,'C');
	$pdf->Cell(65,5,'Responsable de la ORDOP/Misión',T,1,'C');
	$pdf->Cell(190,4,$linea,0,1,'C');	

	$actual = $pdf->GetY();
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Multicell(190,3,$texto,0,'J');
	$pdf->Cell(190,4,$linea,0,1,'C');
	$pdf->Cell(60,4,'Elaboró:    '.$_SESSION["nom_usuario"],0,1,'');
	$pdf->Cell(190,3,$linea,0,1,'C');
	
	$nom_pdf="../fpdf/pdf/InfAuto_".trim($sigla1)."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
//	$pdf->Output($file);
//	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
