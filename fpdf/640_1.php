<?php
/* 640_1.php
   FO-JEMPP-CEDE2-640 - Relación de Gastos ORDOP/MISIÓN.
   (pág 182 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	01/07/2023 - SE HACE CONTROL DEL CAMBIO DE LA SIGLA DE LA UNIDAD. Jorge Clavijo
	30/05/2024 - Se ajusta el tamaño de la cajas de la firma porque el nombre del cargo es muy largo. Jorge Clavijo.
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
			global $sigla1;
			$ano = date('Y');

			//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
			$consulta = "select * from cx_rel_gas where conse = '".$_GET['conse']."' and unidad = '".$_GET['unidad']."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
			$cur = odbc_exec($conexion,$consulta);
			$fecha_rg = substr(odbc_result($cur,2),0,10);
			$unidad = trim(odbc_result($cur,4));

			$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$unidad."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = trim(odbc_result($cur1,1));
			$sigla1 = trim(odbc_result($cur1,3));
			$nom1 = trim(odbc_result($cur1,4));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
			if ($sigla1 <> "") if ($fecha_rg >= $fecha_os) $sigla = $sigla1;

			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			if (strlen($sigla) <= 6) $this->RotatedText(55,200,$sigla,35);
			else $this->RotatedText(25,230,$sigla,35);

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
			$this->Cell(55,5,'INFORME O RELACIÓN',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-640',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'DE GASTOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'1',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(55,5,'ORDOP/MISIÓN',0,0,'C');			
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2022-12-12',0,1,'');

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
  			//$fecha1=date("d/m/Y H:i:s a");
  			$this->SetY(-10);
  			$this->SetFont('Arial','',7);
  			//$this->Cell(190,4,'SIGAR1 - Fecha de impresión: '.$fecha1,0,1,'');
  			$this->Cell(190,4,'SIGAR1'.$fecha1,0,1,'');
  			$this->Ln(-4);
  			$this->SetFont('Arial','B',8);
  			$this->SetTextColor(255,150,150);
  			$this->Cell(190,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
   			$cod_bar='SIGAR - '.$_GET['conse'];
  			$this->Code39(164,285,$cod_bar,.5,5);
		}//Footer()
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
	$pdf->RoundedRect(9,$actual-3,192,22,0,'');
	$pdf->Ln(-1);
	
	$consulta = "select * from cx_rel_gas where conse = '".$_GET['conse']."' and unidad = '".$_GET['unidad']."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
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
	$consecu = odbc_result($cur,18);
	$comandante = trim(odbc_result($cur,19));
	$cmte = explode("»",$comandante);
	if (substr($cmte[0],-1) == 'Â') $n_cmte = substr($cmte[0],0,-1);
	else $n_cmte = $cmte[0];
	$c_cmte = $cmte[1];
	$elabora = trim(odbc_result($cur,20));
	$reintegro = substr(str_replace(',','',trim(odbc_result($cur,21))),0);
	//$comprobantes = substr(trim(odbc_result($cur,23)),1);
	if (strlen(odbc_result($cur,23)) > 0) $comprobante = trim(odbc_result($cur,23));
	$reviso = trim(odbc_result($cur,26));

	$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$unidad."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$s_unidad = trim(odbc_result($cur1,1));
	$sigla1 = trim(odbc_result($cur1,3));
	$nom1 = trim(odbc_result($cur1,4));
	$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
	if ($sigla1 <> "") if ($fecha >= $fecha_os) $s_unidad = $sigla1;

	if ($comandante == "")
	{
		$consulta_usuweb = "select * from cx_usu_web where usuario = 'CDO_".$s_unidad."'";
		$cur_usuweb = odbc_exec($conexion,$consulta_usuweb);
		$cmte = trim(odbc_result($cur_usuweb,4)); 
	}   //if

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(190,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->SetFont('Arial','',8);	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,40,5,0,'');
	$pdf->Cell(39,5,'UNIDAD',0,0,'');
	$pdf->Cell(152,5,$s_unidad,1,1,'L');
	$pdf->RoundedRect(9,$actual+5,40,5,0,'');
	$pdf->Cell(39,5,'LUGAR y FECHA',0,0,'');
	$pdf->Cell(152,5,$ciudad.'  -  '.$fecha,1,1,'L');
	$pdf->RoundedRect(9,$actual+10,40,5,0,'');
	$pdf->Cell(39,5,'COMPROBANTE(S) No.',0,0,'');
	$pdf->Cell(50,5,$comprobante,1,0,'C');
	$pdf->Cell(50,5,' VALOR',1,0,'L');
	$pdf->Cell(52,5,'$'.$valor,1,1,'R');
	$pdf->RoundedRect(9,$actual+15,40,5,0,'');
	$pdf->Cell(39,5,'ORDOP IMI / CI No.',0,0,'');
	$pdf->Cell(152,5,$nordop.' - '.$ordop,1,1,'L');
	$pdf->RoundedRect(9,$actual+20,40,5,0,'');
	$pdf->Cell(39,5,'MISIÓN T. IMI / CI',0,0,'L');
	$pdf->Cell(152,5,$mision,1,1,'L');
	$pdf->Ln(2);

	if ($_GET['tipo'] == 1)  //informe de gastos
	{	
		$pdf->Cell(30,5,'',0,0,'L');	
		$pdf->Cell(40,5,'INFORME DE GASTOS',0,0,'L');	
		$pdf->Cell(10,5,'X',1,0,'C');
		$pdf->Cell(20,5,'',0,0,'L');		
		$pdf->Cell(40,5,'  RELACIÓN DE GASTOS',0,0,'L');	
		$pdf->Cell(10,5,'',1,1,'C');
		$pdf->Ln(2);

		$actual=$pdf->GetY();		
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(10,5,'ÍTEM',0,0,'C');
		$pdf->Cell(136,5,'CONCEPTOS DEL GASTO',1,0,'C');
		$pdf->Cell(45,5,'VALOR',1,1,'C');

		$pdf->RoundedRect(9,$actual+5,11,5,0,'');	
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(10,5,'1',0,0,'C');
		$pdf->Cell(181,5,'GASTOS CON SOPORTE(S) O FACTURA(S):',1,1,'L');
		
		$consulta1 = "select * from cx_rel_dis where conse1 = '".$conse."' and tipo = 'S' and consecu='".$consecu."' and ano= '".$_GET['ano']."' ORDER by conse";
		$cur1 = odbc_exec($conexion,$consulta1);
		$actual=$pdf->GetY();
		$total_gs = 0;
		$lin = 0;
		$f = 0;
		$niv = 0;
		while($f<$nreg_cur_pag=odbc_fetch_array($cur1))	
		{
			$pdf->RoundedRect(9,$actual+$lin,11,5,0,'');
			$niv++;
			$pdf->Cell(10,5,"1.".$niv,0,0,'C');
			
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
			$total_gs = $total_gs + $gastos;
			$f++;
		}   //while
	
		$actual=$pdf->GetY();	
		$pdf->RoundedRect(9,$actual,192,5,0,'R');
		$pdf->SetFont('Arial','B',8);	
		$pdf->Cell(146,5,'SUMAN GASTOS CON SOPORTES O FACTURA',0,0,'R');
		$pdf->Cell(45,5,'$'.number_format($total_gs,2),1,1,'R');
		$pdf->SetFont('Arial','',8);
		$total_gastos = $total_gastos + $total_gs;	
		
		$x = $pdf->Getx();
		$y = $pdf->Gety();
		$pdf->RoundedRect(9,$y,11,8,0,'');
		$pdf->Cell(11,8,'2',0,0,'C');
		$texto = "GASTOS SIN FACTURA. De conformidad con lo dispuesto en el Artículo 616-2 del Estatuto Tributario. Casos en los cuales no se requiere la expedición de facturas. Literal C Los responsables del régimen simplificado.";
		$pdf->SetXY($x+10,$y);
		$pdf->Multicell(181,4,$texto,1,'J');
		$pdf->SetFont('Arial','',8);
	
		$consulta1 = "select * from cx_rel_dis where conse1 = '".odbc_result($cur,1)."' and tipo = 'N' and consecu='".$consecu."' and ano= '".$_GET['ano']."' ORDER by conse";
		$cur1 = odbc_exec($conexion,$consulta1);
 
		$actual=$pdf->GetY();
		$total_gsf = 0;
		$lin = 0;
		$f = 0;
		$niv = 0;
		while($f<$nreg_cur_pag=odbc_fetch_array($cur1))	
		{
			$pdf->RoundedRect(9,$actual+$lin,11,5,0,'');
			$niv++;
			$pdf->Cell(10,5,"2.".$niv,0,0,'C');
			
			$consulta_pag = "select nombre from cx_ctr_pag where codigo = '".odbc_result($cur1,3)."'";
			$cur_pag = odbc_exec($conexion,$consulta_pag);		
			$pdf->Cell(136,5,odbc_result($cur_pag,1),1,0,'L'); 
			if (odbc_result($cur1,3) == 1)
			{
				$vlr = trim(odbc_result($cur1,5));	
				$gastos = $vlr - $reintegro;
			}
			else $gastos = odbc_result($cur1,5);

			$pdf->Cell(45,5,'$'.number_format($gastos,2),1,1,'R');
			$lin = $lin + 5;
			$total_gsf = $total_gsf + $gastos;
			$f++;
		}   //while

		$actual=$pdf->GetY();	
		$pdf->RoundedRect(9,$actual,192,5,0,'R');
		$pdf->SetFont('Arial','B',8);	
		$pdf->Cell(146,5,'SUMAN GASTOS SIN FACTURA',0,0,'R');
		$pdf->Cell(45,5,'$'.number_format($total_gsf,2),1,1,'R');
		$pdf->SetFont('Arial','',8);
		$total_gastos = $total_gastos + $total_gsf;	
		
		$x = $pdf->Getx();
		$y = $pdf->Gety();
		$pdf->RoundedRect(9,$y,11,20,0,'C');
		$pdf->Cell(10,5,'3',0,0,'C');
		$pdf->RoundedRect(20,$y,181,20,0,'C');
		$texto = "RELACION DE GASTOS SIN SOPORTES. LEY 1097 ARTÍCULO 6. LEGALIZACIÓN DE GASTOS RESERVADOS. En aquellos casos en que por circunstancias de tiempo, modo y lugar o atendiendo a condiciones de seguridad no sea posible la obtención de todo o parte de los soportes, los gastos podrán ser respaldados para todos los efectos de su legalización, solamente en aquellos casos de infiltración y penetración a grupos al margen de la ley, con una relación detallada de gastos e informes respectivos de resultados, avalada por el responsable del mismo, por el Comandante de la unidad táctica u operativa y/o sus equivalentes.";
		$pdf->Multicell(181,4,$texto,1,'J');
		
		$consulta_rg = "select * from cx_rel_gas where conse = '".$_GET['conse']."' and tipo = '2' and unidad='$uni_usuario' and ano='".$_GET['ano']."'";
		$cur_rg = odbc_exec($conexion,$consulta_rg);
		$cur_nrg = odbc_num_rows($cur_rg);

		$total_gss = 0;
		$f = 0;
		$niv = 0;
		while($f<$cur_nrg=odbc_fetch_array($cur_ngr))	
		{
			$pdf->RoundedRect(9,$actual+$lin,11,5,0,'');
			$niv++;
			$pdf->Cell(10,5,"3.".$niv,0,0,'C');

			$consulta_pag = "select nombre from cx_ctr_pag where codigo = '".odbc_result($cur1,3)."'";
			$cur_pag = odbc_exec($conexion,$consulta_pag);		
			$pdf->Cell(136,5,odbc_result($cur_pag,1),1,0,'L'); 
			$valor_gss = trim(odbc_result($cur_ngr,14));
			$pdf->Cell(45,5,'$'.odbc_result($cur_ngr,14),1,1,'R');
			$lin = $lin + 5;
			$total_gss = $total_gss + odbc_result($cur_ngr,14);
			$f++;
		}   //while

		$actual=$pdf->GetY();	
		$pdf->RoundedRect(9,$actual,192,5,0,'R');
		$pdf->SetFont('Arial','B',8);	
		$pdf->Cell(146,5,'SUMAN GASTOS SIN SOPORTES',0,0,'R');
		$pdf->Cell(45,5,'$'.number_format($total_gss,2),1,1,'R');
		$pdf->SetFont('Arial','',8);
		$total_gastos = $total_gastos + $total_gss;				
	}   //if
	else   //relación de gastos
	{
		$pdf->Cell(30,5,'',0,0,'L');	
		$pdf->Cell(40,5,'INFORME DE GASTOS',0,0,'L');	
		$pdf->Cell(10,5,'',1,0,'C');
		$pdf->Cell(20,5,'',0,0,'L');		
		$pdf->Cell(40,5,'  RELACIÓN DE GASTOS',0,0,'L');	
		$pdf->Cell(10,5,'X',1,1,'C');
		$pdf->Ln(2);

		$actual=$pdf->GetY();		
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(10,5,'ITEM',0,0,'C');
		$pdf->Cell(136,5,'CONCEPTOS DEL GASTO',1,0,'C');
		$pdf->Cell(45,5,'VALOR',1,1,'C');

		$pdf->RoundedRect(9,$actual+5,11,5,0,'');	
		$pdf->Cell(10,5,'1',0,0,'C');
		$pdf->SetFont('Arial','B',8);	
		$pdf->Cell(181,5,'GASTOS CON SOPORTE(S) O FACTURA(S):',1,1,'L');
		$pdf->SetFont('Arial','',8);

		$actual=$pdf->GetY();	
		$pdf->RoundedRect(9,$actual,192,5,0,'R');
		$pdf->SetFont('Arial','B',8);	
		$pdf->Cell(146,5,'SUMAN GASTOS CON SOPORTES O FACTURA',0,0,'R');
		$pdf->Cell(45,5,'$'.number_format($total,2),1,1,'R');
		$pdf->SetFont('Arial','',8);
		$x = $pdf->Getx();
		$y = $pdf->Gety();
		$pdf->RoundedRect(9,$y,11,8,0,'');
		$pdf->Cell(11,8,'2',0,0,'C');
		$texto = "GASTOS SIN FACTURA. De conformidad con lo dispuesto el Articulo 616-2 del Estatuto Tributario. Casos en los cuales no se requiere la expedición de facturas. Literal c Los responsables del régimen simplificado.";
		$pdf->SetXY($x+10,$y);
		$pdf->Multicell(181,4,$texto,1,'J');
		$pdf->SetFont('Arial','',8);

		$actual=$pdf->GetY();	
		$pdf->RoundedRect(9,$actual,192,5,0,'R');
		$pdf->SetFont('Arial','B',8);	
		$pdf->Cell(146,5,'SUMAN GASTOS SIN FACTURA',0,0,'R');
		$pdf->Cell(45,5,'$'.number_format(0,2),1,1,'R');
		$pdf->SetFont('Arial','',8);

		$x = $pdf->Getx();
		$y = $pdf->Gety();
		$pdf->RoundedRect(9,$y,11,20,0,'C');
		$pdf->Cell(10,5,'3',0,0,'C');
		$pdf->RoundedRect(20,$y,181,20,0,'C');

		if ($_GET['tipo'] == 1)
			$texto = "RELACION DE GASTOS SIN SOPORTES. LEY 1097 ARTÍCULO 6. LEGALIZACIÓN DE GASTOS RESERVADOS. En aquellos casos en que por circunstancias de tiempo, modo y lugar o atendiendo a condiciones de seguridad no sea posible la obtención de todo o parte de los soportes, los gastos podrán ser respaldados para todos los efectos de su legalización, solamente en aquellos casos de infiltración y penetración a grupos al margen de la ley, con una relación detallada de gastos e informes respectivos de resultados, avalada por el responsable del mismo, por el Comandante de la unidad táctica u operativa y/o sus equivalentes.";
		else
			$texto = "GASTOS SIN SOPORTES. Artículo 6. Legalización de gastos reservados Ley 1097. En aquellos casos en que por circunstancias de tiempo, modo y lugar o atendiendo a condiciones de seguridad no sea posible la obtención de todo o parte de los soportes, los gastos podran ser respaldados para efectos de su legalización, solamente en aquellos casos de infiltración y penetración a grupos al margen de la ley, con una relación detallada de gastos e informes respectivos de resultados avalada por el responsable del mismo, por el Comandante de la unidad táctica u operativa y/o sus equivalentes.";
		$pdf->Multicell(181,4,$texto,1,'J');

		$consulta1 = "select * from cx_rel_dis where conse1 = '".odbc_result($cur,1)."' and tipo = 'S' and consecu='".$consecu."' and ano= '".$_GET['ano']."'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$cur1_rn = odbc_num_rows($cur1);

		$actual=$pdf->GetY();
		$total = 0;	
		$lin = 0;
		$f = 0;
		$niv = 0;
		while($f<$nreg_cur_pag=odbc_fetch_array($cur1))	
		{
			$pdf->RoundedRect(9,$actual+$lin,11,5,0,'');
			$niv++;
			$pdf->Cell(10,5,"3.".$niv,0,0,'C');
		
			$consulta_pag = "select nombre from cx_ctr_pag where codigo = '".odbc_result($cur1,3)."'";
			$cur_pag = odbc_exec($conexion,$consulta_pag);
					
			$pdf->Cell(136,5,odbc_result($cur_pag,1),1,0,'L');
			$pdf->Cell(45,5,'$'.number_format(odbc_result($cur1,5),2),1,1,'R');
			$total = $total + odbc_result($cur1,5);		
			$lin = $lin + 5;
			$f++;
		}   //while
		$actual=$pdf->GetY();	
		$pdf->RoundedRect(9,$actual,192,5,0,'R');
		$pdf->SetFont('Arial','B',8);	
		$pdf->Cell(146,5,'SUMAN GASTOS SIN SOPORTES',0,0,'R');
		$pdf->Cell(45,5,'$'.number_format($total,2),1,1,'R');
		$pdf->SetFont('Arial','',8);
	}   //if	
	$total_gastos = $total_gastos + $total;

	$pdf->RoundedRect(9,$actual,192,5,0,'R');
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(146,5,'TOTAL GASTOS DE LA ORDOP / MISIÓN(S)',0,0,'R');
	$pdf->Cell(45,5,'$'.number_format($total_gastos,2),1,1,'R');
	$pdf->SetFont('Arial','',8);	

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,10,0,'R');
	$pdf->Cell(192,10,'ANEXOS: Se anexan los soportes y facturas relacionados en el ítem 1.',0,1,'L');

	$actual = $pdf->GetY();
	$pdf->RoundedRect(9,$actual,96,31,0,'');
	$pdf->RoundedRect(105,$actual,96,31,0,'');	
	$res = $responsable."\n".'RESPONSABLE DE LA MISIÓN';
	$cdo = $n_cmte."\n".$c_cmte;
	if (strlen($c_cmte) <= 50) $cdo = $cdo."\n    ";
	$pdf->Ln(15);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x-1,$y);
	$pdf->Multicell(97,5,$res,0,'C');
	$pdf->SetXY($x+96,$y);
	$pdf->Multicell(95,5,$cdo,0,'C');	
	$pdf->SetFont('Arial','',8);

	$pdf->Ln(6);
	$actual = $pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,41,0,'');
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Multicell(190,3,$texto,0,'J');

	$pdf->Ln(2);	
	$actual = $pdf->GetY();
	$pdf->RoundedRect(9,$actual,96,5,0,'');
	$pdf->RoundedRect(105,$actual,96,5,0,'');
	$pdf->Cell(95,5,'Elaboró:    '.strtr($elabora, $sustituye),0,0,'');
	$pdf->Cell(96,5,'Revisó:    '.$reviso,0,1,'');

	$nom_pdf = "../fpdf/pdf/Relaciones/".$_GET['ano']."/RelGas_".$s_unidad."_".$_GET['conse']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));

	if ($cargar == "0") $pdf->Output();
	else $pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
