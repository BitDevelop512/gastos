<?php
/* 633.php
   FO-JEMPP-CEDE2-633 - Informe de Autorización Gastos Reservados.
   (pág 119 - "Directiva Permanente No. 00095 de 2017.PDF")

	01/07/2023 - SE HACE CONTROL DEL CAMBIO DE LA SIGLA DE LA UNIDAD. Jorge Clavijo
	05/06/2024 - Se hace cambio a las firmas se ponen con multicell.  Jorge Clavijo
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

			//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
			$consulta_ia = "select * from cx_inf_aut where conse = '".$_GET['informe']."' and ano='".$_GET['ano']."' and periodo='".$_GET['periodo']."' and unidad1 = '".$_GET['unidad']."'";
			$cur_ia = odbc_exec($conexion,$consulta_ia);
			$sigla_ia = substr(trim(odbc_result($cur_ia,3)),4);
			$unidad = trim(odbc_result($cur_ia,4));
			$fecha_ia = str_replace("/", "-", substr(trim(odbc_result($cur_ia,2)),0,10));	

			$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$_GET['unidad']."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = trim(odbc_result($cur1,1));
			$sigla1 = trim(odbc_result($cur1,3));
			$nom1 = trim(odbc_result($cur1,4));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
			
			if ($sigla1 <> "") if ($fecha_ia >= $fecha_os) $sigla = $sigla1;

			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			if (strlen($sigla) <= 6) $this->RotatedText(55,200,$sigla,35);
			else $this->RotatedText(22,230,$sigla,35);

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
			$this->Cell(55,5,'INFORME DE',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-633',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'AUTORIZACIÓN',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'1',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(55,5,'GASTOS RESERVADOS',0,0,'C');			
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

		function Footer()
		{
  			$fecha1 = date("d/m/Y H:i:s a");
  			$this->SetY(-10);
  			$this->SetFont('Arial','',7);
  			$this->Cell(190,4,'SIGAR - '.$fecha1,0,1,'');
  			$this->Ln(-4);
  			$this->SetFont('Arial','B',8);
  			$this->SetTextColor(255,150,150);
  			$this->Cell(190,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar = 'SIGAR';
  			$this->Code39(182,285,$cod_bar,.5,5);
		}//Footer
	}//PDF extends PDF_Rotate

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
	$sustituye_sig = array ('01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",140);
	$total_gastos =  0;
	$num_informe = $_GET['informe'];

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=279.00125) $pdf->addpage(); 
	}//control_salto_pag

	$consulta0 = "select * from cx_org_sub where sigla = '".$sig_usuario."'";
	$cur0 = odbc_exec($conexion,$consulta0);
	$ciudad0 = trim(odbc_result($cur0,5));
	
	$consulta = "select * from cx_org_sub where subdependencia = '".$_GET['unidad']."'";
	$cur = odbc_exec($conexion,$consulta);
	$unidad = odbc_result($cur,1);
	$sigla = odbc_result($cur,4);
	$unic = odbc_result($cur,8);

	//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
	$sigla1 = trim(odbc_result($cur,41));
	$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur,43)),0,10));	
	
	$consulta1 = "select * from cx_inf_aut where conse = '".$_GET['informe']."' and ano='".$_GET['ano']."' and periodo='".$_GET['periodo']."' and unidad1 = '".$_GET['unidad']."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$fechacomp = $fecha_ia = substr(odbc_result($cur1,2),0,10);
	$unidad1 = odbc_result($cur1,7);
	$f_plazo = odbc_result($cur1,11);
	$directiva = odbc_result($cur1,12);
	$otro = odbc_result($cur1,13);

	if ($sigla1 <> "") if ($fecha_ia >= $fecha_os) $sigla = $sigla1;

	if ($unidad == 2 or $unidad == 3)
	{
		$consulta_pc = "select * from cx_pla_con where unidad = '".$_GET['unidad']."' and ano='".$_GET['ano']."' and periodo='".$_GET['periodo']."'";
		$cur_pc = odbc_exec($conexion,$consulta_pc);
		$plan_cen = odbc_result($cur_pc,1);
		$fecha_pc = substr(odbc_result($cur_pc,2),0,10);
	}
	else
	{
		$consulta_pi = "select * from cx_pla_inv where unidad = '".$_GET['unidad']."' and ano='".$_GET['ano']."' and periodo='".$_GET['periodo']."' and tipo = '1'";
		$cur_pi = odbc_exec($conexion,$consulta_pi);
		$plan_cen = odbc_result($cur_pi,1);
		$fecha_pc = substr(odbc_result($cur_pi,2),0,10);
	}   //if

	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual-3,192,22,0,'');
	$pdf->Ln(-1);	
	$pdf->Cell(34,5,'Unidad Centralizadora',0,0,'');
	$pdf->Cell(90,5,$sig_usuario,B,0,'');
	$pdf->Cell(66,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(25,5,'Lugar y Fecha,',0,0,'');
	$pdf->Cell(126,5,$ciudad0."   -   ".$fechacomp,B,0,'L');
	$pdf->Cell(8,5,'No.',0,0,'');
	$pdf->Cell(30,5,$_GET['informe'],B,1,'C');
	$pdf->Cell(72,5,'Presupuesto de gastos reservados autorizado mes de:',0,0,'');
	$pdf->Cell(117,5,$n_meses[$_GET['periodo']-1],B,0,'L');
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',8);		
	$pdf->RoundedRect(9,$actual+19,192,5,0,'DF');
	$pdf->Cell(190,5,'RECURSOS AUTORIZADOS UNIDADES, DEPENDENCIAS O SECCIONES ORGANICAS:',0,0,'C');
	$pdf->SetFont('Arial','',8);
	
	$pdf->Ln(7);	
	$pdf->Cell(60,5,'1. Unidad/Área de inteligencia/ci apoyada:',0,0,'');
	$pdf->Cell(130,5,$sigla,B,1,'');
	$pdf->Cell(60,5,'1.1 Referencia plan de inversión/solicitud  No. ',0,0,'');
	$pdf->Cell(85,5,$plan_cen,B,0,'');
	$pdf->Cell(15,5,'FECHA',0,0,'');	
	$pdf->Cell(30,5,$fecha_pc,B,1,'C');	
	$pdf->Cell(10,5,'',0,1,'R'); 

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->Cell(14,5,'ÍTEM',0,0,'C');
	$pdf->Cell(130,5,'CONCEPTOS DEL GASTO AUTORIZADOS',L,0,'C');
	$pdf->Cell(47,5,'V/R AUTORIZADO',L,1,'C');	

	$actual=$pdf->GetY();
	$pdf->Cell(14,5,'1.2',0,0,'C');
	$pdf->Cell(177,5,'GASTOS EN ACTIVIDADES DE INTELIGENCIA Y CONTRAINTELIGENCIA',L,1,'');
	
	$consulta2 = "select * from cx_inf_dis where conse1 = '".$_GET['informe']."' and unidad ='".$unidad1."' and ano='".$_GET['ano']."' order by tipo";
	$cur2 = odbc_exec($conexion,$consulta2);
	$nrow = odbc_num_rows($cur);
	$sval_gastos = 0;
	$sval_pagos = 0;	
	$bol = 0;
	$item = 0;
	$i = 0;
	while($i<$row=odbc_fetch_array($cur2))
	{
		$actual=$pdf->GetY();
		if (odbc_result($cur2,6) == 1)
		{
			$consulta_cmp = "select * from cx_org_cmp where conse = '".odbc_result($cur2,7)."'";
			$cur_cmp = odbc_exec($conexion,$consulta_cmp);
			$item++;
			$pdf->RoundedRect(9,$actual,192,5,0,''); 
			$pdf->Cell(14,5,'1.2.'.$item,0,0,'C');
			$pdf->Cell(130,5,"Misión: ".trim(odbc_result($cur2,4))." - ".trim(odbc_result($cur_cmp,3)),L,0,'L');
			$val = substr(str_replace(',','',trim(odbc_result($cur2,5))),0);
			$sval_gastos = $sval_gastos + $val;
			$pdf->Cell(47,5,wims_currency($val),L,1,'R');
		}
		else
		{
			if ($bol == 0)
			{
				$pdf->Cell(144,5,'TOTAL GASTOS EN ACTIVIDADES DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'R');	
				$pdf->RoundedRect(154,$actual,47,5,0,'');   
				$pdf->Cell(47,5,wims_currency($sval_gastos),0,1,'R');   
				$pdf->Cell(10,5,'',0,1,'R');  
				
				$actual=$pdf->GetY();
				$pdf->RoundedRect(9,$actual,192,5,0,'');			
				$pdf->Cell(14,5,'1.3',0,0,'C');
				$pdf->Cell(154,5,'PAGO INFORMACIONES',L,1,'');					
				$bol = 1;
				$item = 0;
			}   //if
			$item++;
			$val = substr(str_replace(',','',trim(odbc_result($cur2,5))),0);
			$sval_pagos = $sval_pagos + $val;
			$actual=$pdf->GetY();
			$pdf->RoundedRect(9,$actual,192,5,0,''); 
			$pdf->Cell(14,5,'1.3.'.$item,0,0,'C');			
			$pdf->Cell(130,5,odbc_result($cur2,4),L,0,'');
			$pdf->Cell(47,5,wims_currency($val),L,1,'R');
		}   //if
		$u++;
		control_salto_pag($pdf->GetY());
	}   //while
		
	if (odbc_result($cur2,6) == 1)
	{
		$pdf->Cell(144,5,'TOTAL GASTOS EN ACTIVIDADES DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'R');	
		$pdf->RoundedRect(154,$actual,47,5,0,'');  
		$pdf->Cell(47,5,wims_currency($sval_gastos),1,1,'R');    
		$pdf->Cell(10,5,'',0,1,'R');  
		
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'');			
		$pdf->Cell(14,5,'1.3',0,0,'C');
		$pdf->Cell(154,5,'PAGO INFORMACIONES',L,1,'');					
		$bol = 1;
		$item = 0;
	}  //if

	$pdf->Cell(144,5,'TOTAL PAGOS DE INFORMACIONES',0,0,'R');	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(154,$actual,47,5,0,'');  
	$pdf->Cell(47,5,wims_currency($sval_pagos),0,1,'R'); 
	$pdf->Cell(10,5,'',0,1,'R');   

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,145,5,0,'DF');	
	$pdf->Cell(14,5,'1.4',0,0,'C');
	$vlr2 = trim($sval_gastos+$sval_pagos);
	$actual=$pdf->GetY();
	$pdf->Cell(130,5,'TOTAL RECURSOS AUTORIZADOS UNIDAD/ÁREA INT/Cl',L,0,'');	
	$pdf->Cell(47,5,wims_currency($vlr2),1,1,'R');   		
	$pdf->Cell(10,5,'',0,1,'R');   
	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,147,5,0,'');  
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(144,5,'TOTAL RECURSOS GASTOS RESERVADOS AUTORIZADOS',0,0,'L');
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(154,$actual,47,5,0,'DF');  
	$pdf->Cell(47,5,wims_currency($sval_gastos+$sval_pagos),0,1,'R');
	$pdf->Cell(10,10,'',0,1,'R');   
	$pdf->SetFont('Arial','',8);

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->Cell(190,5,'INSTRUCCIONES GENERALES',0,1,'');

	$texto = "1. Los recursos deberán ser ejecutados con apego al marco legal y reglamentario de los gastos reservados y de conformidad con los conceptos del gasto autorizados.";
	$texto1 = "2. Los soportes que justifican pagos y gastos, deberán ser rendidos en forma consolidada a la Unidad Ejecutora con plazo: ".$f_plazo.", cumpliendo los requisitos y términos determinados en la normatividad de gastos reservados (Directiva Permanente No. ".trim($directiva)." de 2022)";
    $texto2 = "3. INSTRUCCIONES ADICIONALES: ".$otro;
	$pdf->Multicell(191,5,$texto,0,'J');
	$pdf->Multicell(191,5,$texto1,0,'J');
	$pdf->Multicell(191,5,$texto2,0,'J');
	$pdf->Cell(190,5,str_repeat("_",122),0,1,'C');

    if (substr($sig_usuario,0,2) == 'BR')
    {
		$elaboro = 31;
		$reviso = 7;
		$jem = 8;
		$cdo = 9;
	} 
	else
	{
		$elaboro = 10;
		$reviso = 11;
		$jem = 12;
		$cdo = 13;
	}   //if
	
	$consulta_osub = "select * from cx_org_sub where subdependencia = '".$uni_usuario."'";
	$cur_osub = odbc_exec($conexion,$consulta_osub);
	$n_firma1 = trim(odbc_result($cur_osub,13));
	$c_firma1 = trim(odbc_result($cur_osub,28));
	$n_firma2 = trim(odbc_result($cur_osub,14));
	$c_firma2 = trim(odbc_result($cur_osub,29));
	$n_firma3 = trim(odbc_result($cur_osub,15));
	$c_firma3 = trim(odbc_result($cur_osub,30));
	$n_firma4 = trim(odbc_result($cur_osub,16));
	$c_firma4 = trim(odbc_result($cur_osub,31));
	if ($n_firma4 == "") $n_firma4 = utf8_decode($nom_usuario);

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->Ln(20);
	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','',7);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);
	$pdf->Multicell(3,4,"",0,'C');
	$pdf->SetXY($x+3,$y);
	$pdf->Multicell(87,4,$n_firma2."\n".$c_firma2,T,'C');
	$pdf->SetXY($x+90,$y);
	$pdf->Multicell(5,4,"",0,'C');
	$pdf->SetXY($x+95,$y);		
	$pdf->Multicell(87,4,$n_firma3."\n".$c_firma3,T,'C');
	$pdf->Ln(5);
	$pdf->Cell(190,5,$linea,0,1,'C');
	
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Multicell(190,3,$texto,0,'J');
	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');	
	$pdf->Cell(14,5,'Elaboró:',0,0,'');
	$pdf->Cell(87,5,$n_firma4,0,0,'L');
	$pdf->Cell(14,5,'Revisó:',0,0,'');
	$pdf->Cell(75,5,$n_firma1,0,1,'L');

	$nom_pdf = "pdf/Autorizaciones/".$_GET['ano']."/InfAut_".$_GET['unidad']."_".$_GET['informe']."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	//Se crea notificación
	$nom_pdf1 = '<a href="./fpdf/'.$nom_pdf.'" target="_blank"><font color="#0000FF">Informe de Autorizacion</font></a>';
  	if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
  	{
  		$n_admin = "4";
  		$sigla2 = strtr(trim($sigla), $sustituye_sig);
		$usuario0 = "SGR_".trim($sigla2);
  	}
  	else
  	{
  		$n_admin = "6";
  		$sigla2 = strtr(trim($sigla), $sustituye_sig);
		$usuario0 = "SGA_".trim($sigla2);
  	}   //if
	$pre1 = "select usuario from cx_usu_web where unidad=".$_GET['unidad']." and usuario='$usuario0'";
	$sql1 = odbc_exec($conexion,$pre1);
	$usuario1 = trim(odbc_result($sql1,1)); 
	$unidad1 = $_GET['unidad'];
	$sigla = trim($sigla);

	$mes = date('m');
	$mes = intval($mes);
	if (($mes == "1") or ($mes == "3") or ($mes == "5") or ($mes == "7") or ($mes == "8") or ($mes == "10") or ($mes == "12"))
	{
		$dia = "31";
	}
	else
	{
		if ($mes == "2") $dia = "28";
		else $dia = "30";
	}   //if
	
	$mes = str_pad($mes,2,"0",STR_PAD_LEFT);
	$ano = date('Y');
	$fecha1 = $ano."/".$mes."/01";
	$fecha2 = $ano."/".$mes."/".$dia;
	$pregunta = "SELECT COUNT(1) AS total FROM cx_notifica WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND unidad='$uni_usuario' AND usuario1='$usuario1' AND unidad1='$unidad1' AND mensaje LIKE '%".$nom_pdf."%'";
	$sql2 = odbc_exec($conexion,$pregunta);
	$total = odbc_result($sql2,1);
	$total = intval($total);
	if ($total == "0")
	{
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu = odbc_result($cur1,1);
		$mensaje = "SE HA GENERADO EL INFORME DE AUTORIZACION ".$num_informe." DE LA UNIDAD ".$sigla." ".$nom_pdf1;
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad1', '$mensaje', 'P', '1')";
		$sql2 = odbc_exec($conexion, $query2);
	}   //if

	$nom_pdf = "pdf/Autorizaciones/".$_GET['ano']."/InfAut_".$_GET['unidad']."_".$_GET['informe']."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");
	$file=basename(tempnam(getcwd(),'tmp'));

	if ($cargar == "0") $pdf->Output();
	else $pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
