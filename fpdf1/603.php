<?php
/* 603.php
   FO-JEMPP-CEDE2-603 - Lista de verificación.
   Directiva No. 02 del 16 de Enero de 2019
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

			$this->SetFont('Arial','B',10);
			$this->SetTextColor(0,0,0);
			$this->Cell(279,7,'LISTA DE VERIFICACIÓN DIRECTIVA No 02 DEL 16 DE ENERO DE 2019',0,1,'C');
			$this->Cell(279,7,'EXPEDIENTE DE RECOMPENSAS',0,1,'C');
			$this->SetFont('Arial','',8);
			$this->Cell(279,5,'Página: '.$this->PageNo().'/{nb}',0,1,'R');
			//$this->Cell(279,3,'',0,1,'C');
			$this->SetFont('Arial','',8);

			$this->RoundedRect(9,15,279,20,0,'');
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
	$pdf->SetFont('Arial','',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(204);

	$sustituye_sig = array ('01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9');
	$n_rubros = array('204-20-1', '204-20-2', 'A-02-02-04');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$items = array("DOCUMENTOS DE OBLIGATORIO CUMPLIMIENTO",
				   "LA SOLICITUD DEBE SEGUIR EL CONDUCTO REGULAR CON EL RESPECTIVO APOYO BATALLÓN (OFICIO REMISORIO EXP. BR)",
				   "LA SOLICITUD DEBE SEGUIR EL CONDUCTO REGULAR CON EL RESPECTIVO APOYO BRIGADA (OFICIO REMISORIO EXP. DIV)",
				   "LA SOLICITUD DEBE SEGUIR EL CONDUCTO REGULAR CON EL RESPECTIVO APOYO DIVISIÓN (OFICIO REMISORIO EXP. CEDE2)",
				   "INFORME DE CONTACTO CON LA FUENTE (INICIAL O PRELIMINAR DE LA INFORMACIÓN SUMINISTRADA POR LA FUENTE)",
				   "INFORME DE INTELIGANCIA DONDE SE INCLUYE LA INFORMACIÓN ENTREGADA POR LA FUENTE DEBIDAMENTE EVALUADA",
				   "DOCUMENTO OFICIAL CON EL CUAL LA RESPECTIVA UNIDAD INFORMA AL MANDO SUPERIOR LOS RESULTADOS OBTENIDOS (RADIOGRAMA AL COE POR PARTE DE LA DIV)",
				   "CERTIFICACIÓN EXPEDIDA POR EL COMANDANTE DE LA UNIDAD DONDE SE INDIQUE QUE NO SE TRAMITARÁ PAGO ALGUNO ANTE EL GAHD, OTRA FUERZA NI PONAL COMO TAMPOCO A TRAVÉS DE LA ALCALDÍA O GOBERNACIÓN CON RECURSOS DE LEY 418 DE 1997.",
				   "CERTIFICACIÓN INFORMANTE NO PERTENECE AL PROGRAMA DE REINSERCIÓN EXPEDIDO POR EL GAHD.",
				   "DOCUMENTO OFICIAL QUE ORDENE LA OPERACIÓN DE LA UNIDAD TÁCTICA Y/O OPERATIVA (ORDOP ó OFRAG)",
				   "ANEXO DE INTELIGENCIA",
				   "INFORME RESULTADOS OBTENIDOS EN DESARROLLO DE LA OPERACIÓN FIRMADO, DONDE REFERENCIA QUE FUE PRODUCTO INFORMACIÓN APORTADA POR FUENTE HUMANA.",
				   "COPIA INFORME PRIMER RESPONDIENTE O INFORME EJECUTIVO DEJANDO A DISPOSICIÓN DE AUTORIDAD LOS ELEMENTOS INCAUTADOS Y/O INMOVILIZADOS Y/O PERSONAL NEUTRALIZADO.",
				   "ACTA DE ACUERDOS PREVIOS CON LA FUENTE SIN DETERMINAR CIFRAS PARA EL PAGO.",
				   "Neutralizaciones (Capturas o Desmovilizaciones)",
				   "ACTA O DOCUMENTO INTERNO PUESTA A DISPOSICIÓN DE AUTORIDAD COMPETENTE.",
				   "DEBE ADJUNTAR UN ORGANIGRAMA SIMPLIFICADO CON LA UBICACIÓN EN LA ESTRUCTURA DELICUENCIAL DEL SUJETO O SUJETOS NEUTRALIZADOS CON INFORMACIÓN DE INTELIGANCIA Y/O CONTRAINTELIGENCIA.",
				   "FOTOGRAFÍAS DEL TERRORISTA CAPTURADO.",
				   "PRONTUARIO O PERFIL DELICTIVO O ANTECEDENTES DELICTIVO DEL SUJETO O SUJETOS REPORTADOS.",
				   "TARJETA DECADACTILAR DEL NEUTRALIZADO.",
				   "CERTIFICADO DE CODA DE LA OPERACIÓN POR PARTE DEL GAHD (PARA DESMOVILIZADOS).",
				   "Muerte en Desarrollo de Operación Militar",
				   "ACTA DE INSPECCIÓN CADÁVER.",
				   "DEBE ADJUNTARSE UN ORGANIGRAMA SIMPLIFICADO CON LA UBICACIÓN EN LA ESTRUCTURA DELICUENCIAL DEL SUJETO O SUJETOS NEUTRALIZADOS DE INTELIGENCIA Y/O CONTRAINTELIGENCIA.",
				   "FOTOGRAFÍAS DEL TERRORISTA CAPTURADOS.",
				   "PRONTUARIO DELICTIVO.",
				   "TARJETA NECRODACTILAR.",
				   "Material",
				   "ACTA O DOCUMENTO INTERNO DE LA INCAUTACIÓN DE MATERIAL.",
	               "FOTOGRAFIAS DEL MATERIAL INCAUTADO.",
	               "ANÁLISIS PRELIMINAR MATERIAL INCAUTADO.");
	$linea = str_repeat("_",122);

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=178.00125) $pdf->addpage();
	} //control_salto_pag

	$conse = $_GET["conse"];
	$ano = $_GET["ano"];
	$directiva = $_GET["directiva"];
	$directiva1 = $_GET["directiva1"];
	$consulta = "select * from cx_reg_rec where conse = '".$_GET["conse"]."' and ano = '".$_GET["ano"]."'";
	$cur = odbc_exec($conexion,$consulta);

	$elaboro = trim(odbc_result($cur,3));
	$consulta_uw = "select * from cx_usu_web where usuario = '".$elaboro."'";
	$cur_uw = odbc_exec($conexion,$consulta_uw);
	$n_elaboro = trim(odbc_result($cur_uw,4));
	
	$u_solicita = trim(odbc_result($cur,4));
	$f_resultado = trim(odbc_result($cur,8));
	$vlr_soli = trim(odbc_result($cur,21));
	$n_ordop = trim(odbc_result($cur,24));
	$ordop = trim(odbc_result($cur,25));
	$o_fragmentaria = trim(odbc_result($cur,27));

	$factor = trim(odbc_result($cur,32));
	$consulta_fac = "select * from cx_ctr_fac where codigo = '".$factor."'";
	$cur_fac = odbc_exec($conexion,$consulta_fac);
	$n_factor = trim(odbc_result($cur_fac,2));
		
	$estructura = trim(odbc_result($cur,33));
	$consulta_est = "select * from cx_ctr_est where codigo = '".$estructura."'";
	$cur_est = odbc_exec($conexion,$consulta_est);
	$n_estruc = trim(odbc_result($cur_est,3));

	$lista_vlr = trim(odbc_result($cur,42));
	$vlr_anti = explode("|",$lista_vlr);
	$rg = count($vlr_anti)-1;
	$vlr_anticipo = 0;
	for ($k=0;$k<=$rg;$k++) $vlr_anticipo = $vlr_anticipo + $vlr_anti[$k];

	$lista_rec = trim(odbc_result($cur,47));
	$lista = explode("|",$lista_rec);

	$consulta_os = "select * from cx_org_sub where subdependencia = '".$u_solicita."'";
	$cur_os = odbc_exec($conexion,$consulta_os);
	$u_sigla = trim(odbc_result($cur_os,4));
	
	$consulta_vu = "select * from cv_unidades where subdependencia = '".$u_solicita."'";
	$cur_vu = odbc_exec($conexion,$consulta_vu);
	$unidad_vu = trim(odbc_result($cur_vu,2));
	$dependencia_vu = trim(odbc_result($cur_vu,4));
	$sdependencia_vu = trim(odbc_result($cur_vu,6));
	
	$pdf->SetFont('Arial','B',8);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,279,25,0,'DF');
	//$pdf->Cell(149,5,'UNIDAD SOLICITANTE: '.$u_sigla,0,0,'L');
	$pdf->Cell(150,5,'UNIDAD SOLICITANTE: '.$unidad_vu." / ".$dependencia_vu." / ".$sdependencia_vu,0,0,'L');
	$pdf->Cell(149,5,'CONSECUTIVO: '.$conse,L,1,'L');
	$pdf->Cell(150,5,'ORDOP: '.$ordop.' - '.$n_ordop,0,0,'L');
	$pdf->Cell(149,5,'',L,1,'L');
	$pdf->Cell(150,5,'ORDEN FRAGMENTARIA: '.$o_fragmentaria,0,0,'L');
	$pdf->Cell(149,5,'FECHA RESULTADO: '.$f_resultado,L,1,'L');
	$pdf->Cell(150,5,'FACTOR: '.$n_factor,0,0,'L');
	$pdf->Cell(149,5,'ESTRUCTURA: '.$n_estruc,L,1,'L');
	$pdf->Cell(150,5,'VALOR SOLICITADO: '.'$'.$vlr_soli,0,0,'L');
	$pdf->Cell(149,5,'VALOR ANTICIPO: '.'$'.number_format($vlr_anticipo),L,1,'L');

	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,279,10,0,'');
	$pdf->Cell(140,10,'DOCUMENTOS DE OBLIGATORIO CUMPLIMIENTO',0,0,'C');
	$pdf->Cell(10,10,'SI',1,0,'C');
	$pdf->Cell(10,10,'NO',1,0,'C');
	$pdf->Cell(48,10,'No. Doc',1,0,'C');
	$pdf->Cell(22,10,'Fecha',1,0,'C');
	$pdf->Cell(24,10,'Folio Inicial',1,0,'C');
	$pdf->Cell(24,10,'Folio Final',1,1,'C');

	$pl = 0;
	for ($f=1;$f<=count($items)-1;$f++)
	{	
		$actual=$pdf->GetY();
		$x = $pdf->Getx();
		$y = $pdf->Gety();	
		if ($f == 14)
		{
			$pdf->RoundedRect(9,$actual,279,10,0,'DF');
			$pdf->SetFont('Arial','B',10);
			$pdf->Ln(2);
			$pdf->Cell(279,5,'Neutralizaciones (Capturas o Desmovilizaciones)',0,1,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(3);
		}
		elseif ($f == 21)
		{
			$pdf->RoundedRect(9,$actual,279,10,0,'DF');
			$pdf->SetFont('Arial','B',10);
			$pdf->Ln(2);
			$pdf->Cell(279,5,'Muerte en Desarrollo de Operación Militar',0,1,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(3);		
		}
		elseif ($f == 27)
		{
			$pdf->RoundedRect(9,$actual,279,10,0,'DF');
			$pdf->SetFont('Arial','B',10);
			$pdf->Ln(2);
			$pdf->Cell(279,5,'Material',0,1,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(3);
		}
		else
		{		
			if (strlen($items[$f]) >= 68) $aa = ceil(strlen($items[$f])/68)*5;
			else $aa = 10; 
			$pdf->RoundedRect(9,$y,141,$aa,0,'');
			$pdf->SetFont('Arial','',9);
			$pdf->Multicell(140,4,$items[$f],0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY($x+140,$y);
			$pdf->RoundedRect(150,$y,10,$aa,0,'');

			if ($lista[$pl] == 0)
			{
				$si = "";
				$no = "X";
			}
			else
			{
				$si = "X";
				$no = "";
			}   //if
			$pdf->Multicell(10,$aa,$si,0,'C');
			$pdf->SetXY($x+150,$y);
			$pdf->RoundedRect(160,$y,10,$aa,0,'');
			$pdf->Multicell(10,$aa,$no,0,'C');
			$pdf->SetXY($x+160,$y);
			$pdf->RoundedRect(170,$y,48,$aa,0,'');
			$pl++;
			$pdf->Multicell(48,$aa,$lista[$pl],0,'C');
			$pdf->SetXY($x+208,$y);
			$pdf->RoundedRect(218,$y,22,$aa,0,'');
			$pl++;
			$pdf->Multicell(22,$aa,$lista[$pl],0,'C');
			$pdf->SetXY($x+230,$y);
			$pdf->RoundedRect(240,$y,24,$aa,0,'');
			$pl++;
			$pdf->Multicell(24,$aa,$lista[$pl],0,'C');
			$pdf->SetXY($x+254,$y);
			$pdf->RoundedRect(264,$y,24,$aa,0,'');
			$pl++;
			$pdf->Multicell(24,$aa,$lista[$pl],0,'C');
			$pl++;
		}   //if
		control_salto_pag($pdf->GetY()); 
	}   //for

	$pdf->Ln(4);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,279,5,0,'');
	$pdf->Cell(15,5,'Elaboró:',0,0,'');
	$pdf->Cell(85,5,$n_elaboro,0,0,'');

	$nom_pdf="../fpdf/pdf/ListaVerif_".trim($sig_usuario)."_".$_GET['conse']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	//$pdf->Output();
	$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}  //if
?>
