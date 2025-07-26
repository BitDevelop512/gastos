<?php
/* 625.php
   FO-JEMPP-CEDE2-625 - Comprobante de ingresos.
   (pág 152 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
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
			$this->Cell(55,5,'COMPROBANTE DE',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-625',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'INGRESOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'4',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(125,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
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
  			$fecha1="";
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
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	
	$sustituye = array ('Ã¡' => 'á', 'Ãº' => 'ú','Ã“' => 'Ó','ÃƒÂƒÃ‚ÂƒÃƒÂ‚Ã‚ÂƒÃƒÂƒÃ‚Â‚ÃƒÂ‚Ã‚Â“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'ÃƒÂƒÃ‚ÂƒÃƒÂ‚Ã‚ÂƒÃƒÂƒÃ‚Â‚ÃƒÂ‚Ã‚Â' => 'Í', 'Ã­' => 'í', 'Ã' => 'Á');
	$n_bancos = array ('BBVA', 'AV VILLAS', 'DAVIVIENDA', 'BANCOLOMBIA', 'BANCO DE BOGOTA','POPULAR');
	$n_recursos = array('10 CSF', '50 SSF', '16 SSF', 'OTROS');
	$n_rubros = array('204-20-1', '204-20-2', 'A-02-02-04');
	$n_soportes = array('INFORME DE GIRO CEDE2', 'CONSIGNACION', 'NOTA CREDITO', 'ABONO EN CUENTA','ORDEN DE PAGO SIIF');
	$n_transacciones = array('TRANSFERENCIA', 'CONSIGNACION', 'NOTA CREDITO','ABONO EN CUENTA');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$autoriza_pag = array('INFORME DE AUTORIZACION','SOLICITUD RECURSOS','PLAN DE NECESIDADES','PLAN DE INVERSIÓN','ACTO ADM AUTORIZACIÓN RECURSO CEDE2','ACTO ADMINISTRATIVO DE RECURSOS ADICIONALES','CONTRATO','SOLICITUD TRASPASO CUENTA','RADIOGRAMA CEDE2','RECIBO OFICIAL DE PAGO IMPUESTOS NACIONALES');
	$linea = str_repeat("_",122);
	$ingreso = $_GET['ingreso'];
	$ano = $_GET['ano'];

	$consulta = "select * from cx_com_ing where ingreso='$ingreso' and ano='$ano' and unidad='$uni_usuario'";
	$cur = odbc_exec($conexion,$consulta);
	$fechacomp = substr(odbc_result($cur,2),0,10);
	$usuario = trim(odbc_result($cur,3));
	$unidad_centralizadora = odbc_result($cur,4);
	$mes = odbc_result($cur,5);
	$val = trim(odbc_result($cur,9));
	$valor = "$ ".number_format(trim(odbc_result($cur,9)),2);
	$concepto = odbc_result($cur,10);
	$transferencia = odbc_result($cur,16);
	$gasto =  odbc_result($cur,25);
	
	if ($unidad_centralizadora  != 1)
	{
		$n_cdp = "N/A";
		$fecha_cdp = "N/A";
		$n_crp = "N/A";
		$fecha_crp = "N/A";
	}
	else
	{
		if ($usu_usuario == 'STE_DIADI')
		{
			if ($concepto == 99 and $transferencia == 4) $concepto = 19;
			elseif ($concepto == 99) $concepto = 9;
			$cdp = trim(odbc_result($cur,22));
			$crp = trim(odbc_result($cur,23));
		}
		
		$consulta_cdp = "select numero, fecha1 from cx_cdp where conse = '".$cdp."'";
		$cur_cdp = odbc_exec($conexion,$consulta_cdp);
		$n_cdp = odbc_result($cur_cdp,1);
		$fecha_cdp = odbc_result($cur_cdp,2);

		$consulta_crp = "select numero, fecha1 from cx_crp where conse = '".$crp."'";
		$cur_crp = odbc_exec($conexion,$consulta_crp);
		$n_crp = odbc_result($cur_crp,1);
		$fecha_crp = odbc_result($cur_crp,2);
	}   //if

	$recurso = odbc_result($cur,11);	
	$recurso1 = $n_recursos[$recurso-1];
	$rubro = $n_rubros[odbc_result($cur,12)-1];
	$soporte = $n_soportes[odbc_result($cur,13)-1];	
	$num_sopo = odbc_result($cur,14);
	$fecha_sopo = odbc_result($cur,15);
	$transferencia = $n_transacciones[odbc_result($cur,16)-1];	
	$t =odbc_result($cur,16);
	$ciudad = strtr(trim(odbc_result($cur,20)), $sustituye);
	$origen = trim(odbc_result($cur,21));

	$firmas = trim(decrypt1(odbc_result($cur,17), $llave));
	$num_firmas = explode("|",$firmas);
	for ($i=0;$i<count($num_firmas);++$i)
	{
		$fir[$i] = $num_firmas[$i];
	}
	$ejecuto = explode("»",$fir[0]);
	$autorizo = explode("»",$fir[1]);
	$vobo = explode("»",$fir[2]);
	$elaboro = explode("»",$fir[3]);
	$ejecuto[0] = substr($ejecuto[0], 0, strlen($ejecuto[0])-1);
	$autorizo[0]= substr($autorizo[0], 0, strlen($autorizo[0])-1);
	$vobo[0] = substr($vobo[0], 0, strlen($vobo[0])-1);
	$elaboro[0] = substr($elaboro[0], 0, strlen($elaboro[0])-1);
	
	$consulta1="select * from Cx_org_sub where subdependencia = '".$unidad_centralizadora."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$n_unidadcen = odbc_result($cur1,6);
	$sigla = odbc_result($cur1,4);
	$ciudad1 = odbc_result($cur1,5);
	$banco = $n_bancos[odbc_result($cur1,10)-1];
	$cuenta = odbc_result($cur1,11);

	$consulta2="select * from cx_ctr_gas where codigo = '".$concepto."'";
	$cur2 = odbc_exec($conexion,$consulta2);
	$nom_concepto = odbc_result($cur2,2);

	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual-3,192,22,0,'');
	$pdf->Ln(-1);
	$pdf->Cell(40,5,'UNIDAD CENTRALIZADORA',0,0,'');
	$pdf->Cell(90,5,rtrim($n_unidadcen),B,0,'');
	$pdf->Cell(60,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(15,5,'LUGAR',0,0,'');
	$pdf->Cell(80,5,$ciudad,B,0,'');
	$pdf->Cell(15,5,'FECHA',0,0,'');	
	$pdf->Cell(30,5,$fechacomp,B,0,'C');
	$pdf->Cell(20,5,'INGRESO NR',0,0,'');
	$pdf->Cell(30,5,$_GET['ingreso'],B,1,'C');
	$pdf->Cell(15,5,'BANCO',0,0,'');
	$pdf->Cell(100,5,$banco,B,0,'');
	$pdf->Cell(20,5,'CUENTA No.',0,0,'');
	$pdf->Cell(55,5,$cuenta,B,1,'');

	$pdf->Ln(5);	
	$pdf->RoundedRect(9,$actual+19,192,5,0,'DF');
	$pdf->Cell(190,5,'DESCRIPCIÓN',0,0,'C');
	
	$pdf->Ln(7);	
	$pdf->RoundedRect(9,$actual+24,192,34,0,'');
	$pdf->Cell(32,5,'ART. PRESUPUESTAL',0,0,'');
	$pdf->Cell(65,5,$rubro,B,0,'');
	$pdf->Cell(22,5,'RECURSO',0,0,'');
	$pdf->Cell(70,5,$recurso1,B,1,'');
	$pdf->Cell(15,5,'CDP',0,0,'');
	$pdf->Cell(38,5,$n_cdp,B,0,'C');
	$pdf->Cell(15,5,'FECHA',0,0,'');	
	$pdf->Cell(30,5,$fecha_cdp,B,0,'C');
	$pdf->Cell(12,5,'CRP',0,0,'');	
	$pdf->Cell(32,5,$n_crp,B,0,'C'); 
	$pdf->Cell(15,5,'FECHA',0,0,'');	
	$pdf->Cell(30,5,$fecha_crp,B,1,'C');
	$pdf->Cell(20,5,'CONCEPTO',0,0,'');
	$pdf->Cell(70,5,$nom_concepto,B,0,'');
	$pdf->Cell(10,5,'MES',0,0,'');
	$pdf->Cell(20,5,$n_meses[$mes-1],B,0,'C');
	$pdf->Cell(13,5,'ORIGEN',0,0,'');
	$pdf->Cell(55,5,$origen,B,1,'');	
	$pdf->Cell(20,5,'SOPORTE',0,0,'');
	$pdf->Cell(80,5,$soporte,B,0,'');
	$pdf->Cell(10,5,'No.',0,0,'');
	$pdf->Cell(30,5,$num_sopo,B,0,'C');
	$pdf->Cell(15,5,'FECHA',0,0,'');	
	$pdf->Cell(30,5,$fecha_sopo,B,1,'C');
	$pdf->Cell(42,5,'TRANSACCION BANCARIA:',0,0,'');
	$pdf->Cell(63,5,$transferencia,B,0,'');
	$pdf->Cell(25,5,'TOTAL',0,0,'');
	$pdf->Cell(58,5,$valor,B,1,'R');
	$pdf->Cell(10,5,'SON:',0,0,'');
	$valor_letras = num2letras($val);
	$pdf->Cell(120,5,$valor_letras,B,1,'');
		
	$pdf->Ln(2);
	$pdf->RoundedRect(9,$actual+58,192,5,0,'DF');
	$pdf->Cell(190,5,'IMPUTACIÓN CONTABLE',0,0,'C');
	$pdf->Ln(5);	
	$pdf->RoundedRect(9,$actual+63,48,5,0,'');
	$pdf->Cell(47,5,'CODIGO',0,0,'C');
	$pdf->RoundedRect(57,$actual+63,48,5,0,'');
	$pdf->Cell(48,5,'CUENTA',0,0,'C');
	$pdf->RoundedRect(105,$actual+63,48,5,0,'');
	$pdf->Cell(48,5,'DEBE',0,0,'C');
	$pdf->RoundedRect(153,$actual+63,48,5,0,'');
	$pdf->Cell(48,5,'HABER',0,1,'C');
	
	$cta_DTN = '111005001';
	$banco1 = 'BANCOS';
	$cta_func = '2490550010';
	$banco2 = 'OTROS AVANCES Y ANTICIPOS';
	
	if ($usu_usuario == 'STE_DIADI')
	{
		if ($concepto == 9)  //9: presupuesto adicional
		{
			$cta_DTN = '111005004';
			$banco1 = 'BANCOS DTN';			
			
			if ($recurso == 3)
			{
				$cta_func = '190801002';
				$banco2 = 'CUN';
			}
			else
			{
				$cta_func = '470508002';
				$banco2 = 'FUNCIONAMIENTO';
			}
			if ($recurso == 1)
			{
				$cta_func = '470508002';
				$banco2 = 'FUNCIONAMIENTO';
			}
			else
			{
				$cta_func = '190801002';
				$banco2 = 'CUN';
			}
		}
	}

	$pdf->Cell(48,5,$cta_DTN,0,0,'C');		
	$pdf->Cell(48,5,$banco1,0,0,'C');
	$pdf->Cell(46,5,$valor,0,1,'R');
	$pdf->Cell(48,5,$cta_func,0,0,'C');		
	$pdf->Cell(48,5,$banco2,0,0,'C');       
	$pdf->Cell(46,5,'',0,0,'R');
	$pdf->Cell(46,5,$valor,0,1,'R');	
	
	$pdf->RoundedRect(9,$actual+68,48,5,0,'');
	$pdf->RoundedRect(57,$actual+68,48,5,0,'');
	$pdf->RoundedRect(105,$actual+68,48,5,0,'');
	$pdf->RoundedRect(153,$actual+68,48,5,0,'');

	$pdf->RoundedRect(9,$actual+73,48,5,0,'');
	$pdf->RoundedRect(57,$actual+73,48,5,0,'');
	$pdf->RoundedRect(105,$actual+73,48,5,0,'');
	$pdf->RoundedRect(153,$actual+73,48,5,0,'');

	$pdf->RoundedRect(9,$actual+78,96,5,0,'');
	$pdf->Ln(1);
	$pdf->Cell(96,5,'SUMAS  IGUALES',0,0,'C');
	$pdf->RoundedRect(105,$actual+78,48,5,0,'');
	$pdf->RoundedRect(153,$actual+78,48,5,0,'');
	$pdf->Cell(46,5,$valor,0,0,'R');
	$pdf->Cell(46,5,$valor,0,1,'R');

	$actual = $pdf->GetY()+5;
	$pdf->RoundedRect(9,$actual,96,45,0,'');
	$pdf->Ln(26);
	$pdf->RoundedRect(105,$actual,96,45,0,'');
	$pdf->SetFont('Arial','',6.7);
	
	$n_ejecuto = strtr(trim($ejecuto[0]), $sustituye);
	$c_ejecuto = strtr(trim($ejecuto[1]), $sustituye);
	$n_autorizo = strtr(trim($autorizo[0]), $sustituye);
	$c_autorizo = strtr(trim($autorizo[1]), $sustituye);
	$n_vobo = strtr(trim($vobo[0]), $sustituye);
	$c_vobo = strtr(trim($vobo[1]), $sustituye);

	//Busca imagen de la firma Ejecutó
	//$n_ejecuto = "JAIME ALBERTO MORALES (CX)";
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_ejecuto."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_ejecuto = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_ejecuto);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamaño = getimagesize($file);
		if ($tamaño[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	$w =  ($tamaño[1]*30)/317;
	//$pdf->Cell(95,5,$pdf->Image($file,45,$actual-20,$w,26),0,0,'C');   //46
	
	//Busca imagen de la firma Autorizo
	//$n_autorizo = "JAIME ALBERTO MORALES (CX)";
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_autorizo."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_autorizo = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_autorizo);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamaño = getimagesize($file);
		if ($tamaño[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	$w =  ($tamaño[0]*30)/317;
	//$pdf->Cell(95,5,$pdf->Image($file,140,$actual-20,$w,26),0,0,'C');    //140
	
	$pdf->Ln(6);
	$pdf->Cell(95,5,'_____________________________________________',0,0,'C');
	$pdf->Cell(95,5,'_____________________________________________',0,1,'C');	
	$pdf->Cell(95,5,$n_ejecuto,0,0,'C');
	$pdf->Cell(95,5,$n_autorizo,0,1,'C');
	$pdf->Cell(95,5,$c_ejecuto,0,0,'C');
	$pdf->Cell(95,5,$c_autorizo,0,1,'C');
	
	$actual = $pdf->GetY()+3;
	$pdf->RoundedRect(9,$actual,192,45,0,'');
	$pdf->Ln(28);	
	$pdf->SetFont('Arial','',6.7);
	
	//Busca imagen de la firma VoBo
	//$n_vobo = "JAIME ALBERTO MORALES (CX)";
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_vobo."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_vobo = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_vobo);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamaño = getimagesize($file);
		if ($tamaño[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';

	$actual = $pdf->GetY();
	$w =  ($tamaño[0]*30)/317;
	//$pdf->Cell(95,5,$pdf->Image($file,95,$actual-20,$w,26),0,1,'C');	
	$pdf->Cell(190,5,'_____________________________________________',0,1,'C');
	$pdf->Cell(190,5,$n_vobo,0,1,'C');
	$pdf->Cell(190,5,$c_vobo,0,1,'C');
	$pdf->SetFont('Arial','',8);

	$actual=$pdf->GetY();
	$pdf->Ln(6);
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Multicell(190,3,$texto,0,'J');

	$pdf->Cell(190,4,$linea,0,1,'C');
	$pdf->Cell(50,3,'Elaboró:   '.strtr($elaboro[0], $sustituye),0,1,'');
	$pdf->Cell(190,2,$linea,0,1,'C');

	$nom_pdf="../fpdf/pdf/Comprobantes/".$_GET['ano']."/CompIng_".trim($sig_usuario)."_".$_GET['ingreso']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();	
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
