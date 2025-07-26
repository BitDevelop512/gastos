<?php
/* 601.php
   FO-JEMPP-CEDE2-601 - Acta Trimestral de Confrontación de Cargos
						Bienes Adquiridos con Gastos Reservados en Control Administrativo
						Unidad Centralizadora.
     
   * Se desarrolla para Control de Bienes
   * Consuelo Martínez - 15/12/2020.
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
			$this->Cell(73,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(189,5,'',0,1,'C');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(73,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(189,5,'ACTA TRIMESTRAL DE CONFRONTACIÓN DE CARGOS',0,1,'C');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(73,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(189,5,'BIENES ADQUIRIDOS CON GASTOS RESERVADOS EN CONTROL ADMINISTRATIVO',0,1,'C');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(73,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(189,5,'UNIDAD CENTRALIZADORA',0,1,'C');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,3,'',0,0,'C',0);
			$this->Cell(73,3,'',0,0,'');
			$this->Cell(189,3,'',0,0,'C');

			$this->RoundedRect(9,15,105,26,0,'');
			$this->RoundedRect(114,15,174,26,0,'');
			$this->RoundedRect(9,15,279,183,0,'');

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
		}//RoundedRect

		function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
		{
  			$h = $this->h;
  			$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
  			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
		}//_Arc

		function morepagestable($datas, $lineheight=3.5)
		{
			$l = $this->lMargin-1;
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
					$this->SetFont('Arial','',5.5);		
					$this->SetXY($l,$h);
					if ($this->tablewidths[$col] == 22) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'J');
					elseif ($this->tablewidths[$col] == 19) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'R');
					elseif ($this->tablewidths[$col] == 21) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'J');
					else $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'C');
					$l += $this->tablewidths[$col];
					
					if(!isset($tmpheight[$row.'-'.$this->page])) $tmpheight[$row.'-'.$this->page] = 0;
					if($tmpheight[$row.'-'.$this->page] < $this->GetY()) $tmpheight[$row.'-'.$this->page] = $this->GetY();
					if($this->page > $maxpage) $maxpage = $this->page;
				}   //for
				$h = $tmpheight[$row.'-'.$maxpage];
				$l = $this->lMargin-1;
				$currpage = $maxpage;
			}   //for
			$this->page = $maxpage;
			$this->Line($l,$h,$fullwidth+$l,$h);
			
			for($i = $startpage; $i <= $maxpage; $i++)
			{
				$this->page = $i;
				$l = $this->lMargin-1;
				$t  = ($i == $startpage) ? $startheight : 44.00125;
				$lh = ($i == $maxpage)   ? $h : $this->h-$this->bMargin;
				$this->Line($l,$t,$l,$lh);
				foreach($this->tablewidths AS $width) {
					$l += $width;
					$this->Line($l,$t,$l,$lh);
				}   //for
			}   //for
			$GLOBALS["actual"] = $h;
			$this->page = $maxpage;
			$this->SetXY($l,$h);			
			$this->MultiCell(10,0.1,"");
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
  			$this->Cell(278,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR';
   			$this->Code39(268,200,$cod_bar,.5,5);
		}//Footer()
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');
	require('../numerotoletras2.php');

	$pdf=new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(204);

	$sustituye_sig = array ('01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9');
	$n_bancos = array ('BBVA', 'AV VILLAS', 'DAVIVIENDA', 'BANCOLOMBIA', 'BANCO DE BOGOTA','POPULAR');
	$n_recursos = array('10 CSF', '50 SSF', '16 SSF', 'OTROS');
	$n_rubros = array('204-20-1', '204-20-2', 'A-02-02-04');
	$n_soportes = array('ACTA PAGO DE INFORMACION','ACTA PAGO DE RECOMPENSA','ORDOP','MISION DE TRABAJO DE INTELIGENCIA O CONTRAINT.','FACTURA','CONTRATO','TRANSACCIONES NET CASH','CHEQUE','FORMULARIO DIAN');
	$n_transacciones = array('TRANSFERENCIA', 'CONSIGNACION', 'NOTA CREDITO');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",178);

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=183.00125) $pdf->addpage();
	} //control_salto_pag


	$batallon = "BATALLON";
	$asunto = "Acta trimestral de confrontación de bienes adquiridos con recursos del rubro presupuestal de gastos reservados (GGRR) que se encuentran en control administrativo del Batallón ".$batallon." y la Brigada de Inteligencia Militar No. 2, por intermedio del Departamento de Inteligencia y Contrainteligencia CEDE2.";
	$luyfe = "Lugar y Fecha";
	$interv = "Grado nombre y apellido\nJefe de Estado Mayor Unidad Centralizadora\n\nGrado nombre y apellido\nOficial B4 Unidad Centralizadora\n\nGrado nombre y apellido\nSuboficial de Gastos Reservados Unidad Centralizadora\n\nGrado nombre y apellido\nComandante Batallón\n\nGrado nombre y apellido\nSuboficial Gastos Reservados Batallón\n\nGrado nombre y apellido\nJefe Propiedad Planta y Equipo Batallón\n\nGrado nombre y apellido\nAlmacán Virtual GGRR CEDE2\n";
	
	$actual=$pdf->GetY();
	$pdf->Cell(276,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->SetFont('Arial',B,8);		
	$pdf->Cell(30,5,'NOMBRE UNIDAD: ',0,0,'L');	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(80,5,$nom_uni_br,0,1,'L');	
	$pdf->Cell(30,5,'ACTA No.: ',0,0,'L');
	$pdf->Cell(100,5,$acta_n.' / MDN-CGFM-COEJC-SECEJ-JEMOP-CEDE2-XXXX-XXXXX-XXXXX',TB,1,'L');	
	$pdf->Cell(30,5,'REG. AL FOLIO No: ',0,0,'L');
	$pdf->Cell(80,5,$rfolio,0,1,'L');
	$pdf->Cell(5,2,'',0,1,'L');	
	$pdf->Cell(30,5,'ASUNTO: ',0,0,'L');
	$pdf->Multicell(246,5,$asunto,0,'L',true);
	$pdf->Cell(5,3,'',0,1,'L');	
	$pdf->Cell(30,5,'LUGAR Y FECHA: ',0,0,'L');	
	$pdf->Cell(100,5,$luyfe,TB,1,'L');
	$pdf->Cell(80,5,'',0,1,'L');
	$pdf->Cell(30,5,'INTERVIENEN: ',0,0,'L');
	$pdf->Multicell(106,4,$interv,0,'L');	
	$pdf->Ln(5);

	control_salto_pag($pdf->GetY()); 	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,279,5,0,'');
	$pdf->SetFont('Arial',B,8);
	$pdf->Cell(30,5,'Al aspecto se procedió así: ',0,1,'L');		
	$pdf->SetFont('Arial','',7);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,279,8,0,'');
	$pdf->Cell(4,8,'No',0,0,'C');
	$pdf->Cell(12,8,'Activo',1,0,'C');
	$pdf->Cell(22,8,'Descripción',1,0,'C');	
	$pdf->Cell(20,4,'Denominación',R,0,'C');
	$pdf->Cell(16,4,'Estado',0,0,'C');	
	$pdf->Cell(12,8,'Cantidad',1,0,'C');
	$pdf->Cell(19,4,'Valor de',0,0,'C');
	$pdf->Cell(30,4,'Ubicación',1,0,'C');
	$pdf->Cell(34,4,'NR y fecha Actas Control',1,0,'C');
	$pdf->Cell(32,4,'ORDOP/MISIÓN',1,0,'C');
	$pdf->Cell(56,4,'Vigencia Pólizas',1,0,'C');
	$pdf->Cell(21,8,'OBS',1,0,'C');
	$pdf->Cell(2,4,'',0,1,'C');	
	$pdf->Cell(38,8,'',0,0,'C');
	$pdf->Cell(20,4,'(línea vehículo)',R,0,'C'); 
	$pdf->Cell(16,4,'de uso',0,0,'C');
	$pdf->Cell(12,8,'',0,0,'C');
	$pdf->Cell(19,4,'adquisición',0,0,'C');	
	$pdf->Cell(15,4,'UF/Área',1,0,'C');
	$pdf->Cell(15,4,'UF/BR/UOM',1,0,'C');
	$pdf->Cell(17,4,'Responsable',1,0,'C');
	$pdf->Cell(17,4,'Usuario final',1,0,'C');
	$pdf->Cell(16,4,'adquirio',1,0,'C');
	$pdf->Cell(16,4,'emplea',1,0,'C');
	$pdf->Cell(14,4,'No SOAT',1,0,'C');	
	$pdf->Cell(14,4,'Vigencia',1,0,'C');	
	$pdf->Cell(14,4,'No Plz RC',1,0,'C');	
	$pdf->Cell(14,4,'Vigencia',1,1,'C');	

	$activo = "Motocicleta";
	$descripcion = "Yamaha 250CC, color negro, Serial 111111 Chasis 222222";
	$denomina = "XTZ250";
	$estado = "Bueno";
	$cantidad = "1";
	$valor = "12277371";
	$ufarea = "CPFH";
	$ufbruom = "BAIMI1";
	$reponsable = "06543 de fecha 02-feb-2020";
	$usufinal = "0234 de fecha 05-feb-2020";
	$adquirido = "ORDOP Némesis MT. 21 Júpiter";
	$usado = "ORDOP Némesis MT. 21 Júpiter";
	$soat = "111111";
	$vigsoat = "23/08/2021";
	$prc = "121212121";
	$vigprc = "23/08/2021";
	$obs = "Óptimas condiciones de funcionamiento y mantenimiento.";
	$suman = 0;
	
	$alto = max(strlen($descripcion), strlen($obs)) / 20;
	$alto = round($alto, 0, PHP_ROUND_HALF_UP) * 4;
	$actual=$pdf->GetY();	
	$x = $pdf->Getx();
	$y = $pdf->Gety();			
	$pdf->SetFont('Arial','',6);	
 	for ($h = 1;$h <= 8;$h++)
	{
		
		$data[] = array($h, $activo, $descripcion, $denomina, $estado, $cantidad, wims_currency($valor), $ufarea, $ufbruom, $reponsable, 
					$usufinal, $adquirido, $usado, $soat, $vigsoat, $prc, $vigprc, $obs);
		$suman = $suman + $valor;
	}   //for
	$actual=$pdf->GetY();
	$pdf->tablewidths = array(5, 12, 22, 20, 16, 12, 19, 15, 15, 17, 17, 16, 16, 14, 14, 14, 14, 21); 
	$pdf->morepagestable($data);
	unset($data);

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,279,5,0,'DF');
	$pdf->Cell(84,5,'SUMAN',0,0,'L');	
	$pdf->Cell(17,5,wims_currency($suman),0,1,'R');	

	control_salto_pag($pdf->GetY()); 
	$actual=$pdf->GetY();	
	$pdf->SetFont('Arial','B',8);
	$pdf->RoundedRect(9,$actual,279,5,0,'');
	$pdf->Cell(279,5,'OBSERVACIONES: ',0,1,'L');
	$pdf->SetFont('Arial','',8);
	for ($f = 1; $f <= 4; $f++)
	{
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,279,5,0,'');		
		$observaciones = $f.". Observación ".$f;
		$pdf->Multicell(270,5,$observaciones,0);	
	}   //for
	$actual=$pdf->GetY();	
	$pdf->Cell(276,5,'No siendo otro el objeto de la presente firman quienes en ella intervinieron: ',0,1,'L');

	control_salto_pag($pdf->GetY()); 
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,279,80,0,'');
	$pdf->Ln(15);
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(78,5,'Grado Nombres y APellidos',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(78,5,'Grado Nombres y APellidos',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');	
	$pdf->Cell(78,5,'Grado Nombres y APellidos',0,1,'C');
	$pdf->Cell(10,5,'',0,0,'C');	
	$pdf->Cell(83,5,'Almacén Virtual GGRR CEDE2',T,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');	
	$pdf->Cell(78,5,'Jefe Propiedad Planta y Equipo Batallón',T,0,'C');	
	$pdf->Cell(10,5,'',0,0,'C');	
	$pdf->Cell(78,5,'Suboficial gastos reservados Batallón',T,1,'C');		
	
	$pdf->Ln(15);
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(78,5,'Grado Nombres y APellidos',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');	
	$pdf->Cell(78,5,'Grado Nombres y APellidos',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');	
	$pdf->Cell(78,5,'Grado Nombres y APellidos',0,1,'C');
	$pdf->Cell(10,5,'',0,0,'C');	
	$pdf->Cell(78,5,'Comandante Batallón',T,0,'C');	
	$pdf->Cell(10,5,'',0,0,'C');	
	$pdf->Cell(78,5,'Suboficial Gastos Reservados Unidad Centralizadora',T,0,'C');	
	$pdf->Cell(10,5,'',0,0,'C');	
	$pdf->Cell(78,5,'Oficial B-4 Unidad centralizadora',T,1,'C');	
		
	$pdf->Ln(15);
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(78,5,'',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');	
	$pdf->Cell(78,5,'Grado Nombres y APellidos',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');	
	$pdf->Cell(78,5,'',0,1,'C');
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(78,5,'',0,0,'C');
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(78,5,'Jefe de Estado Mayor Unidad  Centralizadora ',T,0,'C');		
	$pdf->Cell(10,5,'',0,0,'C');
	$pdf->Cell(78,5,'',0,1,'C');

	control_salto_pag($pdf->GetY()); 	
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Ln(7);
	$pdf->Cell(277,3,$linea,0,1,'C');		
	$pdf->Multicell(278,3,$texto,0,'J');
	$pdf->Cell(277,3,$linea,0,1,'C');	

	$nom_pdf="../fpdf/pdf/Actas/ActaConfCargo_".$nom_uni_br."_".$rfolio."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	//echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
