<?php
/* 605.php
   FO-JEMPP-CEDE2- - Anexo 26.
   Directiva 112/2019 "Compromiso Anticorrupción" Anexo Acta y compromiso

   01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub. Jorge Clavijo
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

			//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
			$consulta_act = "select * from cx_act_rec where conse = '".$_GET['conse']."' and registro = '".$_GET['registro']."' and ano = '".$_GET['ano']."' and ano1 = '".$_GET['ano1']."'";
			$cur_act = odbc_exec($conexion,$consulta_act);
			$fecha_act = substr(odbc_result($cur_act,2),0,10);
			$unidad = trim(odbc_result($cur_act,4));

			//$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$uni_usuario."'";
			$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$unidad."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = trim(odbc_result($cur1,1));
			$sigla1 = trim(odbc_result($cur1,3));
			$nom1 = trim(odbc_result($cur1,4));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
			if ($sigla1 <> "") if ($fecha_act >= $fecha_os) $sigla = $sigla1;
			
			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			if (strlen($sigla) <= 6) $this->RotatedText(55,200,$sigla,35);
			else $this->RotatedText(25,230,$sigla,35);

			$this->SetFont('Arial','B',11);
			$this->SetTextColor(255,150,150);
			$this->Cell(190,5,'SECRETO',0,1,'C');
			$this->Ln(2);

			$this->Image('sigar.png',10,17,17);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(0,0,0);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(89,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(85,5,'',0,1,'C');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(89,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->SetFont('Arial','B',14);		
			$this->Cell(85,5,'',0,1,'C');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(89,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->SetFont('Arial','B',13);			
			$this->Cell(85,5,'COMPROMISO ANTICORRUPCIÓN',0,1,'C');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(89,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->SetFont('Arial','B',14);	
			$this->Cell(85,5,'',0,1,'C');
			

			$this->SetFont('Arial','B',8);
			$this->Cell(17,3,'',0,0,'C',0);
			$this->Cell(89,3,'',0,0,'');
			$this->Cell(85,3,'',0,1,'');

			$this->RoundedRect(9,15,107,26,0,'');
			$this->RoundedRect(116,15,85,26,0,'');
			$this->RoundedRect(9,15,192,268,0,'');
			$this->Ln(4);
		}//Header()

		function RotatedText($x,$y,$txt,$angle)
		{
    		$this->Rotate($angle,$x,$y);
    		$this->Text($x,$y,$txt);
			$this->Rotate(0);
		}//RotatedText()

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
		}//RoundedRect()

		function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
		{
  			$h = $this->h;
  			$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
  			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
		}//_Arc()

		function Footer()
		{
  			$fecha1=date("d/m/Y H:i:s a");
  			$fecha1="";
  			$this->SetY(-10);
  			$this->SetFont('Arial','',7);
  			$this->Cell(190,4,'SIGAR - Página: '.$this->PageNo().' de {nb}',0,1,'');
  			//$this->Cell(190,4,'SIGAR - '.$fecha1,0,1,'');
  			$this->Ln(-4);
  			$this->SetFont('Arial','B',11);
  			$this->SetTextColor(255,150,150);
  			$this->Cell(190,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR';
  			$this->Code39(182,285,$cod_bar,.5,5);
		}//Footer()
	}//class PDF extends PDF_Rotate


	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');
	require ('conversor.php');

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');

	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",122);

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1;
		if ($actual1>=272.00125) $pdf->addpage();
	} //control_salto_pag

	$consulta_act = "select * from cx_act_rec where conse = '".$_GET['conse']."' and registro = '".$_GET['registro']."' and ano = '".$_GET['ano']."' and ano1 = '".$_GET['ano1']."'";
	$cur_act = odbc_exec($conexion,$consulta_act);
	$fecha_act = substr(odbc_result($cur_act,2),0,10);
	$unidad = trim(odbc_result($cur_act,4));

	$consulta0 = "select * from cx_org_sub where subdependencia = '".$unidad."'";
	$cur0 = odbc_exec($conexion,$consulta0);
	$sigla = trim(odbc_result($cur0,4));
	$n_unidad = trim(odbc_result($cur0,4))." - ".trim(odbc_result($cur0,6)); 
	$ciudad_uni = trim(odbc_result($cur0,5));
	$sigla1 = trim(odbc_result($cur1,41));
	$nom1 = trim(odbc_result($cur1,42));
	$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,43)),0,10));
	if ($sigla1 <> "") if ($fecha_act >= $fecha_os) $sigla = $sigla1;	

	$pdf->SetFillColor(204);
	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','B',9);
	$pdf->Ln(-2);
	$pdf->Cell(185,5,$n_unidad,0,1,'C');
	$pdf->Ln(-3);
	$pdf->SetFont('Arial','',8);	
	$pdf->Cell(190,3,$linea,0,1,'C');	
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(191,4,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Ln(-3);
	
	$consulta = "select * from cx_act_rec where conse = '".$_GET['conse']."' and registro = '".$_GET['registro']."' and ano = '".$_GET['ano']."' and ano1 = '".$_GET['ano1']."'";
	$cur = odbc_exec($conexion,$consulta);
	$fecha = substr(odbc_result($cur,2),0,10);
	$bene = trim(odbc_result($cur,12));
	$n_bene = explode("#",$bene);
	for ($i=0;$i<count($n_bene);$i++)
	{
		$ln_bene = substr($n_bene[$i],-1);
		if ($ln_bene == "|") $ln_bene = substr($n_bene[$i],0,-1);
		else $ln_bene = $n_bene[$i];
		$dn_benes = explode("|",$ln_bene);
		$n_benes[$i] = $dn_benes[1];
		$id_benes[$i] = $dn_benes[0];
	}   //for

	$xid_bene = trim(odbc_result($cur,18));
	$eid_bene = explode("#",$xid_bene);
	for ($i=0;$i<count($eid_bene);$i++)
	{
		$lx_bene = substr($eid_bene[$i],-1);
		if ($lx_bene == "|") $lx_bene = substr($eid_bene[$i],0,-1);
		else $lx_bene = $eid_bene[$i];
		$dx_benes = explode("|",$lx_bene);
		$x_benes[$i] = $dx_benes[0];
	}   //for

	$registro = trim(odbc_result($cur,7));
	$ano1 = trim(odbc_result($cur,8));
	$otro_val = trim(odbc_result($cur,20));
	if ($otro_val != 0) $pago = "$".trim(odbc_result($cur,19));
	else $pago = "$".trim(odbc_result($cur,10));
	
	$consulta1 = "select * from cx_reg_rec where conse = '".$registro."' and ano = '".$ano1."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$n_ordop = trim(odbc_result($cur1,24));
	$ordop = trim(odbc_result($cur1,25));
	$ciudad_firma = trim(odbc_result($cur1,5));
	if ($ordop == "") $om = trim(odbc_result($cur1,27));
	else $om = $n_ordop." - ".$ordop;
	
	$ciufec_fir = $ciudad_uni." a los ".substr($fecha,8,2)." días del mes de ".$n_meses[substr($fecha,5,2) -1]." de ".substr($fecha,0,4);
	$elaboro = trim(odbc_result($cur,16));
	$reviso = trim(odbc_result($cur,17));

	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','',8);	
	$pdf->Cell(190,3,$linea,0,1,'C');
	$pdf->SetFont('Arial','',9);	
	$texto = "El(la) señor(a) ".$n_benes[0].", identificado(a) con la cédula de ciudadanía No. ".$id_benes[0]." de ".$x_benes[0]." quien obra en calidad de beneficiario de recompensa ";
	$texto = $texto."del Ministerio de la Defensa Nacional, quien en adelante se llamará EL BENEFICIARIO DEL PAGO DE LA RECOMPENSA, suscribe el presente compromiso unilateral ";
	$texto = $texto."anticorrupción, que se regirá por las siguientes cláusulas:";
	$pdf->Multicell(190,5,$texto,0,'J');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(190,3,$linea,0,1,'C');
	
	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(190,5,"CLAUSULA PRIMERA: COMPROMISOS ASUMIDOS.",0,1,'L');
	$pdf->SetFont('Arial','',9);
	$texto1 = "El beneficiario del pago de la recompensa, mediante la suscripción del presente documento asume los siguientes compromisos:\n\n";
	$texto1 = $texto1."1. El Ejército Nacional autorizó el pago de la recompensa correspondiente a la operación militar ".$om." por un valor de ".$pago."\n\n";
	$texto1 = $texto1."2. Informar de manera inmediata, si alguna persona le solicitare dádivas, dinero o prebendas, toda vez que el pago de información y recompensas es una ";
	$texto1 = $texto1."actividad propia de la Inteligencia, es por ello que no ofrecerá ni pagará suma alguna, ni ninguna otra prebenda a los Servidores Públicos que tengan ";
	$texto1 = $texto1."relación con el desarrollo de la ACTIVIDAD DE INTELIGENCIA o la OPERACIÓN MILITAR que generó el resultado operacional objeto de la recompensa, ni a los ";
	$texto1 = $texto1."RESPONSABLES DE GESTIONAR O ADELANTAR TRAMITES PARA EL PAGO DE LA RECOMPENSA.\n\n";
	$texto1 = $texto1."3. Se compromete a no permitir que nadie haga la correspondiente reclamación en su nombre, salvo que por razones de seguridad o fuerza mayor así lo determine, ";
	$texto1 = $texto1."en todo caso, habrá de otorgar poder con presentación personal y autenticación ante notario o autoridad competente.";
	$pdf->Multicell(190,5,$texto1,0,'J');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(190,3,$linea,0,1,'C');

	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(190,5,"CLÁUSULA SEGUNDA: PAGOS REALIZADOS.",0,1,'L');
	$pdf->SetFont('Arial','',9);
	$texto2 = "1. Previo, durante o después del pago, el beneficiario de la recompensa, no está obligado a efectuar ningún pago o entregar porcentaje alguno de la recompensa a ningún ";
	$texto2 = $texto2."servidor público o a nombre de alguna Unidad Militar, ni será objeto de deducciones por retenciones al monto total aprobado de la recompensa, como tampoco será ";
	$texto2 = $texto2."necesario que su actuación se desarrolle por medio de abogado.\n\n";
	$texto2 = $texto2."2. El valor total de la recompensa le será cancelado mediante transferencia, a cuenta corriente o de ahorros, directamente por la Unidad Centralizadora, y solo está obligado ";
	$texto2 = $texto2."a suscribir el Acta del pago de la Recompensa como documento soporte de cancelación, salvo las excepciones que se reconozcan en razones a su seguridad personal o razone de fuerza mayor.\n\n";
	$texto2 = $texto2."3. El beneficiario del pago de la recompensa en constancia a lo anterior y como manifestación de la aceptación de los compromisos unilaterales incorporados en el presente ";
	$texto2 = $texto2."documento firma el mismo en la ciudad de ".$ciufec_fir;
	$pdf->Multicell(190,5,$texto2,0,'J');

	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(190,5,"ACEPTADO",0,1,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->RoundedRect(9,$actual,160,22,0,'');
	$pdf->RoundedRect(169,$actual,32,22,0,'');
	$pdf->Ln(8);	
	$pdf->Cell(160,5,$n_benes[0],0,1,'L');
	$pdf->Cell(160,5,"C.C. No. ".$id_benes[0]." DE ".$x_benes[0],0,0,'L');
	$pdf->Cell(32,5,"HUELLA",0,1,'C');
	
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->SetFont('Arial','',7);
	$pdf->Multicell(190,3,$texto,0,'J');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(190,3,$linea,0,1,'C');
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(96,4,'Elaboró:    '.$elaboro,0,0,'');
	$pdf->Cell(96,4,'Revisó:    '.$reviso,0,1,'');
	$pdf->Ln(-2);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(190,3,$linea,0,1,'C');

	$nom_pdf="../fpdf/pdf/Actas/ActaAntCor_".$sigla."_".$_GET['conse']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");
	$file=basename(tempnam(getcwd(),'tmp'));

	if ($cargar == "0") $pdf->Output();
	else $pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";		
}
?>
