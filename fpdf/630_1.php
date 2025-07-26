<?php
/* 630.php
   FO-JEMPP-CEDE2-630_1 - Informe de Giros Gastos Reservados.
   (pág 114 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	16/07/2019  - Este formato no se va ha utilizar - Consuelo Mertínez.

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
			$this->Cell(55,5,'INFORME DE GIRO',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-630',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'GASTOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'1',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(55,5,'RESERVADOS',0,0,'C');			
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
	$pdf->SetFillColor(204);
	
	$sustituye = array ( 'Ã¡' => 'á', 'Ãº' => 'ú','Ã“' => 'Ó','ÃƒÂƒÃ‚ÂƒÃƒÂ‚Ã‚ÂƒÃƒÂƒÃ‚Â‚ÃƒÂ‚Ã‚Â“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'ÃƒÂƒÃ‚ÂƒÃƒÂ‚Ã‚ÂƒÃƒÂƒÃ‚Â‚ÃƒÂ‚Ã‚Â' => 'Í', 'Ã­' => 'í', 'Ã'  => 'Á');
	$n_bancos = array ('BBVA', 'AV VILLAS', 'DAVIVIENDA', 'BANCOLOMBIA', 'BANCO DE BOGOTA','POPULAR');
	$n_recursos = array('10 CSF', '50 SSF', '16 SSF', 'OTROS');
	$n_rubros = array('204-20-1', '204-20-2', 'A-02-02-04');
	$n_soportes = array('ACTA PAGO DE INFORMACION','ACTA PAGO DE RECOMPENSA','ORDOP','MISION DE TRABAJO DE INTELIGENCIA O CONTRAINT.','FACTURA','CONTRATO','REF. PLAN NECESIDADES','REF. PLAN INVERSION');
	//$n_soportes = array('INFORME DE GIRO CEDE2', 'CONSIGNACION', 'NOTA CREDITO', 'ABONO EN CUENTA');   //('ACTA PAGO DE INFORMACION','ACTA PAGO DE RECOMPENSA','ORDOP','MISION DE TRABAJO DE INTELIGENCIA O CONTRAINT.','FACTURA','CONTRATO','REF. PLAN NECESIDADES','REF. PLAN INVERSION');
	$n_transacciones = array('TRANSFERENCIA', 'CONSIGNACION', 'NOTA CREDITO');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$autoriza_pag = array('INFORME DE AUTORIZACION','SOLICITUD RECURSOS','ACTO ADM AUTORIZACION RECURSOS CEDE2','ACTO ADM AUTORIZACION RECURSOS ADICIONALES','CONTRATO');
	$linea = str_repeat("_",122);

	$sustituye = array ( 'Ã¡' => 'á', 'Ãº' => 'ú', 'Ã“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'Ã­' => 'í' );
	$n_bancos = array ('BBVA', 'AV VILLAS', 'DAVIVIENDA', 'BANCOLOMBIA', 'BANCO DE BOGOTA','POPULAR');
	$n_recursos = array('10 CSF', '50 SSF', '16 SSF', 'OTROS');
	$n_rubros = array('204-20-1', '204-20-2');
	$n_soportes = array('INFORME DE GIRO CEDE2', 'CONSIGNACION', 'NOTA CREDITO', 'ABONO EN CUENTA');
	$n_transacciones = array('TRANSFERENCIA', 'CONSIGNACION', 'NOTA CREDITO');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",122);
	
	$consulta="select * from cx_inf_gir where conse = '".$_GET['informe']."'";
	$cur = odbc_exec($conexion,$consulta);
	$informe = odbc_result($cur,1);
	$fecha = substr(odbc_result($cur,2),0,10);
	$recurso = $n_recursos[odbc_result($cur,13)-1];	
	$mes = $n_meses[odbc_result($cur,5)-1];	
	$num_unidades = odbc_result($cur,7);
	$plan_solicitud = "";
	
	$consulta3="select * from cx_ctr_gas where codigo = '".odbc_result($cur,16)."'";
	$cur3 = odbc_exec($conexion,$consulta3);
	$concepto = trim(odbc_result($cur3,2));
	
	$consulta4="select * from Cx_org_sub where subdependencia = '".odbc_result($cur,7)."'";	
	$cur4 = odbc_exec($conexion,$consulta4);
	$ciudad = $_SESSION["ciu_usuario"];
	$ndependencia = odbc_result($cur4,2);
	$nom_unidad = odbc_result($cur4,4);
	$ciudadyfecha = $ciudad."   -   ".date("Y-m-d");

	$consulta5 = "select subdependencia from Cx_org_sub where dependencia = '".$ndependencia."'";	
	$cur5 = odbc_exec($conexion,$consulta5);
    $numero = "";
    while($i<$row=odbc_fetch_array($cur5))
    {
		$numero.="'".odbc_result($cur5,1)."',";
    }  //while
    $numero = substr($numero,0,-1);

	$pdf->Ln(-2);	
	$pdf->Cell(190,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(30,5,'LUGAR Y FECHA',0,0,'');
	$pdf->Cell(95,5,$ciudadyfecha,B,0,'');
	$pdf->Cell(20,5,'NUMERO',0,0,'');
	$pdf->Cell(45,5,$_GET['informe'],B,1,'C');
	$pdf->Cell(35,5,'CONCEPTO DEL GIRO',0,0,'');
	$pdf->Cell(155,5,$concepto,B,1,'');
	$pdf->Cell(45,5,'UNIDAD CENTRALIZADORA',0,0,'');
	$pdf->Cell(75,5,$nom_unidad,B,0,'');
	$pdf->Cell(20,5,'RECURSO',0,0,'');
	$pdf->Cell(50,5,$recurso,B,1,'');
	$pdf->Cell(45,5,'REF PLAN/SOLICITUD No.',0,0,'');
	$pdf->Cell(65,5,'',B,0,'');
	$pdf->Cell(30,5,'PARA EL MES DE ',0,0,'');
	$pdf->Cell(50,5,$mes,B,1,'');
	$actual=$pdf->GetY();
	$pdf->Ln(3);	
	$pdf->Cell(57,5,'',0,0,'');
	$pdf->RoundedRect(67,$actual+3,134,5,0,'DF');	
	$pdf->Cell(134,5,'CONCEPTOS DEL GASTO AUTORIZADOS',1,1,'C');
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,24,8,0,'DF');		
	$pdf->Cell(24,4,'ÍTEM',0,0,'C');
	$pdf->RoundedRect(33,$actual,34,8,0,'DF');		
	$pdf->Cell(34,4,'UNIDAD',0,0,'C');
	$pdf->RoundedRect(67,$actual,67,8,0,'DF');		
	$pdf->Cell(67,4,'GASTOS EN ACTIVIDADES DE',0,0,'C');
	$pdf->RoundedRect(134,$actual,67,8,0,'DF');		
	$pdf->Cell(67,4,'PAGO DE INFORMACIONES',0,1,'C');
	$pdf->Cell(24,4,'',0,0,'C');
	$pdf->Cell(34,4,'',0,0,'C');
	$pdf->Cell(67,4,'INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'C');
	$pdf->Cell(67,4,'',0,1,'C');

	$consulta1 = "select * from cx_val_gir where unidad in ($numero)";
	$cur1 = odbc_exec($conexion,$consulta1);
	$subt_gastos = 0;
	$subt_pagos = 0;
	$i=1;

	while($i<$row=odbc_fetch_array($cur1))
	{
		$pdf->Cell(23,5,$i,B,0,'C');
		$pdf->Cell(34,5,trim(odbc_result($cur1,7)),1,0,'C');
		$pdf->Cell(67,5,'$'.number_format(trim(odbc_result($cur1,8)),2),1,0,'R');
		$pdf->Cell(67,5,'$'.number_format(trim(odbc_result($cur1,9)),2),1,1,'R');
		$subt_gastos = $subt_gastos + odbc_result($cur1,8);
		$subt_pagos = $subt_pagos + odbc_result($cur1,9);
		$i++;
	}  //while
	
	$total_girado = $subt_gastos + $subt_pagos;
	$pdf->Cell(57,5,'SUBTOTAL',B,0,'L');
	$pdf->Cell(67,5,'$'.number_format(trim($subt_gastos),2),1,0,'R');
	$pdf->Cell(67,5,'$'.number_format(trim($subt_pagos),2),1,1,'R');
	$pdf->Cell(124,5,'TOTAL GIRADO',0,0,'L');
	$pdf->Cell(67,5,'$'.number_format(trim($total_girado),2),1,1,'R');
	
	$pdf->Ln(5);
	$pdf->Cell(67,5,'DETALLES DE LA RECOMPENSA AUTORIZADA:',B,0,'L');
	$actual=$pdf->GetY();
	$pdf->Ln(8);
	$pdf->RoundedRect(9,$actual+8,68,5,0,'DF');
	$pdf->Cell(67,5,'UNIDAD GENERÓ EL RESULTADO OP',0,0,'C');
	$pdf->RoundedRect(77,$actual+8,50,10,0,'DF');
	$pdf->Cell(50,5,'ORDOP',0,0,'C');
	$pdf->RoundedRect(127,$actual+8,50,10,0,'DF');
	$pdf->Cell(50,5,'ORDOP',0,0,'C');	
	$pdf->RoundedRect(177,$actual+8,24,10,0,'DF');
	$pdf->Cell(24,5,'FECHA',0,1,'C');
	$pdf->RoundedRect(9,$actual+13,20,5,0,'DF');
	$pdf->Cell(20,5,'U.O.M',0,0,'C');
	$pdf->RoundedRect(29,$actual+13,25,5,0,'DF');
	$pdf->Cell(25,5,'BRIGADA',0,0,'C');
	$pdf->RoundedRect(54,$actual+13,23,5,0,'DF');
	$pdf->Cell(23,5,'BATALLÓN',0,0,'C');
	$pdf->Cell(50,5,'',0,0,'C');
	$pdf->Cell(50,5,'Fragmentaria',0,1,'C');
	
//	$i=1;
//	while($i<$row=odbc_fetch_array($cur1))
//	{
		$pdf->Cell(19,5,'',B,0,'C');
		$pdf->Cell(25,5,'',1,0,'C');
		$pdf->Cell(23,5,'',1,0,'R');
		$pdf->Cell(50,5,'',1,0,'R');
		$pdf->Cell(50,5,'',1,0,'R');
		$pdf->Cell(24,5,'',1,1,'R');
//	}

	$pdf->Cell(19,5,'',B,0,'C');
	$pdf->Cell(25,5,'',1,0,'C');
	$pdf->Cell(23,5,'',1,0,'R');
	$pdf->Cell(50,5,'',1,0,'R');
	$pdf->Cell(50,5,'',1,0,'R');
	$pdf->Cell(24,5,'',1,1,'R');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');		
	$pdf->Cell(191,5,'VALORACIÓN NEUTRALIZADOS:',0,1,'L');
	$pdf->RoundedRect(9,$actual+5,20,5,0,'');
	$pdf->Cell(20,5,'NIVEL',0,0,'C');
	$pdf->RoundedRect(29,$actual+5,124,5,0,'');
	$pdf->Cell(124,5,'IDENTIDAD',0,0,'C');	
	$pdf->RoundedRect(153,$actual+5,48,5,0,'');
	$pdf->Cell(48,5,'VALOR APROBADO',0,1,'C');

//	$i=1;
//	while($i<$row=odbc_fetch_array($cur1))
//	{
	$pdf->RoundedRect(9,$actual+10,20,5,0,'');
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->RoundedRect(29,$actual+10,124,5,0,'');
	$pdf->Cell(124,5,'',0,0,'C');	
	$pdf->RoundedRect(153,$actual+10,48,5,0,'');
	$pdf->Cell(48,5,'$0.00',0,1,'R');	
//	}

	$pdf->RoundedRect(9,$actual+15,20,5,0,'');
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->RoundedRect(29,$actual+15,124,5,0,'');
	$pdf->Cell(124,5,'',0,0,'C');	
	$pdf->RoundedRect(153,$actual+15,48,5,0,'');
	$pdf->Cell(48,5,'$0.00',0,1,'R');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');		
	$pdf->Cell(191,5,'VALORACIÓN MATERIAL/ELEMENTOS',0,1,'L');
	$pdf->RoundedRect(9,$actual+5,101,5,0,'DF');
	$pdf->Cell(101,5,'ELEMENTOS INCAUTADOS',0,0,'C');
	$pdf->RoundedRect(110,$actual+5,18,5,0,'DF');
	$pdf->Cell(18,5,'CANT',0,0,'C');
	$pdf->RoundedRect(128,$actual+5,25,5,0,'DF');
	$pdf->Cell(25,5,'UND MEDIDA',0,0,'C');	
	$pdf->RoundedRect(153,$actual+5,48,5,0,'DF');
	$pdf->Cell(48,5,'VALOR APROBADO',0,1,'C');
	
//	$i=1;
//	while($i<$row=odbc_fetch_array($cur1))
//	{
	$pdf->RoundedRect(9,$actual+10,101,5,0,'');	
	$pdf->Cell(101,5,'',0,0,'L');
	$pdf->RoundedRect(110,$actual+10,18,5,0,'');
	$pdf->Cell(18,5,'',0,0,'C');
	$pdf->RoundedRect(128,$actual+10,25,5,0,'');
	$pdf->Cell(25,5,'',0,0,'C');	
	$pdf->RoundedRect(153,$actual+10,48,5,0,'');
	$pdf->Cell(48,5,'$0.00',0,1,'R');
//	}

	$pdf->RoundedRect(9,$actual+15,101,5,0,'');	
	$pdf->Cell(101,5,'',0,0,'L');
	$pdf->RoundedRect(110,$actual+15,18,5,0,'');
	$pdf->Cell(18,5,'',0,0,'C');
	$pdf->RoundedRect(128,$actual+15,25,5,0,'');
	$pdf->Cell(25,5,'',0,0,'C');	
	$pdf->RoundedRect(153,$actual+15,48,5,0,'');
	$pdf->Cell(48,5,'$0.00',0,1,'R');
	
	$actual=$pdf->GetY();
	$pdf->Ln(3);	
	$pdf->RoundedRect(9,$actual+3,144,5,0,'');		
	$pdf->Cell(144,5,'TOTAL AUTORIZADO RECOMPENSA',0,0,'L');	
	$pdf->RoundedRect(153,$actual+3,48,5,0,'');
	$pdf->Cell(48,5,'$0.00',0,1,'R');

	$pdf->Ln(3);
	$pdf->RoundedRect(9,$actual+3,192,60,0,'');
	$texto="1. Los recursos deberán ser ejecutado con apego al marco legal y reglamentario de los gastos reservados.\n2. La ejecución de recursos debe ser realizadas de acuerdo los planes de inversión o solicitudes de recursos autorizados.\n3. El pago a beneficiarios de recompensas o pago de informaciones debe ser realizado de forma inmediata.\n4. Los pagos de recompensas deben ser por la Unidad ejecutora de gastos reservados.\n5. Los pagos de informaciones deben ser realizados por la Unidad, Dependencia o Sección que manejó la fuente y solicitó el recurso.\n6. La cuenta de gastos reservados deberá ser rendida al CEDE2, con plazo último día hábil de cada mes";
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(191,5,'INSTRUCCIONES GENERALES',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Ln(3);	
	$pdf->Multicell(190,3,$texto,0,'');
	$pdf->Ln(12);
	$pdf->Cell(191,4,'______________________________________________________',0,1,'C');
	$pdf->Cell(191,4,'Jefe Departamento de Inteligencia y Contrainteligencia',0,1,'C');
	$pdf->Cell(191,4,'',0,1,'C');

	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Ln(6);
	$pdf->Multicell(191,3,$texto,0,'J');
	$pdf->Cell(190,4,$linea,0,1,'C');	
	$pdf->Cell(15,4,'Elaboró:',0,0,'');
	$pdf->Cell(30,3,strtr(trim($_SESSION["nom_usuario"]), $sustituye),0,1,'L');
	$pdf->Cell(190,4,$linea,0,1,'C');
	
	ob_end_clean();
	$nom_pdf="pdf/InfGiro_".$_GET['informe']."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
