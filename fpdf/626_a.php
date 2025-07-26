<?php
/* 626.php
   FO-JEMPP-CEDE2-626 Conciliación Bancaría.
   (pág 204 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	Ejecuto: Division: OB2, Comando CAIMI o CACIM: OC8, Brigada inteligencia: OB4,
	Ordenador: JEM y nombre de la unidad
	comandante: CDO
	Elaboro: Suboficial de Gastos Reservados: SGR,	
"<br>"
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

			$consulta1 = "select sigla,nombre from cx_org_sub where subdependencia='".$_SESSION["uni_usuario"]."'";
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
			$this->Cell(55,5,'CONCILIACIÓN ',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-626',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'BANCARIA',0,0,'C');
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
	$n_diasmes = array(31,28,31,30,31,30,31,31,30,31,30,31);
	$bancos = array('','BBVA', 'AV VILLAS', 'DAVIVIENDA', 'BANCOLOMBIA', 'BANCO DE BOGOTA', 'POPULAR');
	$linea = str_repeat("_",122);
	$ano = $_GET['ano'];

	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln(-1);

	$consulta_unidad = "select sigla,nombre,ciudad,banco,cuenta from cx_org_sub where subdependencia='".$_SESSION["uni_usuario"]."'";
	$cur_unidad = odbc_exec($conexion,$consulta_unidad);
	$sigla = odbc_result($cur_unidad,1);
	$rsocial = odbc_result($cur_unidad,2);
	$rsocial_n = strtr(trim($rsocial), $sustituye);
	$ciudad = odbc_result($cur_unidad,3);
	$banco = odbc_result($cur_unidad,4);
	$banco_n = strtr(trim($bancos[$banco]), $sustituye);
	$cuenta = odbc_result($cur_unidad,5); 
	
	if ($_GET['cuenta'] == '1')
	{
		$consulta = "select * from cx_con_ban where unidad = '".$_SESSION["uni_usuario"]."' and periodo = '".$_GET['periodo']."' and ano = '".$ano."' and cuenta = '".$_GET['cuenta']."'";
		$cur = odbc_exec($conexion,$consulta);
		$fecha = odbc_result($cur,2);
		$fecha_n = substr($fecha,8,2)."/".substr($fecha,5,2)."/".substr($fecha,0,4);
		$saldo_ban = odbc_result($cur,7);
		$ndebito = odbc_result($cur,8);
		$totsal_ndb = $saldo_ban + $ndebito;
		$ncredito = odbc_result($cur,9);
		$cheques = odbc_result($cur,10);
		$saldolib = odbc_result($cur,11);
		$totndb_chsal = $ncredito + $cheques + $saldolib;
		$rel_cheques = trim(odbc_result($cur,12));
		$rel_debito = trim(odbc_result($cur,13));
		$rel_credito = trim(odbc_result($cur,14));					
		$nom_cta = 'GASTOS';
	}
	else 
	{
		$consulta_ctrc = "select * from cx_ctr_cue where conse ='".$_GET['cuenta']."'";
		$cur_ctrc = odbc_exec($conexion,$consulta_ctrc);
		$nom_cta = trim(odbc_result($cur_ctrc,5));
		$cuenta = trim(odbc_result($cur_ctrc,6));

		$consulta_cta = "select * from cx_sal_cue where conse ='".$_GET['cuenta']."'";
		$cur_cta = odbc_exec($conexion,$consulta_cta);
		if (odbc_num_rows($cur_cta) != 0) $saldolib =  trim(odbc_result($cur_cta,2));
		else $pdf->Cell(20,5,$nom_cta.'',0,1,'C');
	}   //if

	$pdf->Cell(33,5,'Unidad Centralizadora',0,0,'L');
	$pdf->Cell(100,5,$sigla,B,0,'L');
	$pdf->Cell(58,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(13,5,'Ciudad:',0,0,'');
	$pdf->Cell(120,5,$ciudad,B,0,'L');
	$pdf->Cell(12,5,'Fecha:',0,0,'L');
	$pdf->Cell(45,5,$fecha_n,B,1,'C');
	$pdf->Cell(13,5,'Banco:',0,0,'');
	$pdf->Cell(115,5,$banco_n,B,0,'L');
	$pdf->Cell(17,5,'  Corriente No',0,0,'C');
	$pdf->Cell(45,5,$nom_cta.' - '.$cuenta,B,1,'C');	
	$pdf->Cell(37,5,'Razón social de la cuenta',0,0,'L');
	$pdf->Cell(154,5,$rsocial_n,B,1,'L');
	
	$per = $_GET['periodo'];
	if (strlen($per) == 1) $per = '0'.$per;
	$bisiesto = !($bano % 4) && ($bano % 100 || !($bano % 400));
	if ($per == 2)
	{
		if ($bisiesto == 1) $fecha_n1 = $n_diasmes[$per-1]."/".$_GET['periodo']."/".$ano;
		else $fecha_n1 = "29/".$per."/".$ano;
	}
	else $fecha_n1 = $n_diasmes[$per-1]."/".$per."/".$ano;

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual+2,192,5,0,'DF');
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(192,5,'ANÁLISIS DE LOS SALDOS',0,1,'C');
	$pdf->SetFont('Arial','',8);	
	$pdf->Ln(1);			
	$pdf->Cell(105,5,'SALDO EN EXTRACTO BANCARIO A FECHA: ',0,0,'L');
	$pdf->RoundedRect(116,$actual+8,20,5,0,'DF');
	$pdf->Cell(20,5,'  ('.$fecha_n1.')  ',0,0,'L');
	$pdf->Cell(7,5,'',0,0,'L');
	$pdf->Cell(59,5,'$'.number_format($saldo_ban,2),1,1,'R');
	$pdf->Cell(105,5,'NOTAS DEBITO NO REGISTRADA AUXILIAR BANCOS ',0,0,'L');
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(59,5,'$'.number_format($ndebito,2),1,1,'R');
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(132,5,'TOTAL ',0,0,'R');
	$pdf->Cell(59,5,'$'.number_format($totsal_ndb,2),1,1,'R');
	$pdf->SetFont('Arial','',8);	
	$pdf->Cell(105,5,'NOTAS CREDITO NO REGISTRADA AUXILIAR BANCOS ',0,0,'L');
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(59,5,'$'.number_format($ncredito,2),1,1,'R');
	$pdf->Cell(105,5,'CHEQUES PENDIENTES DE COBRO',0,0,'L');
	$pdf->Cell(27,5,'',0,0,'L');
	$pdf->Cell(59,5,'$'.number_format($cheques,2),1,1,'R');
	$pdf->Cell(105,5,'SALDO SEGUN LIBROS A FECHA: ',0,0,'L');
	$pdf->RoundedRect(116,$actual+33,20,5,0,'DF');
	$pdf->Cell(20,5,'  ('.$fecha_n1.')  ',0,0,'L');
	$pdf->Cell(7,5,'',0,0,'L');
	$pdf->Cell(59,5,'$'.number_format($saldolib,2),1,1,'R');
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(132,5,'TOTAL ',B,0,'R');
	$pdf->Cell(59,5,'$'.number_format($totndb_chsal,2),1,1,'R');
	$pdf->SetFont('Arial','',8);	

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual+2,192,5,0,'DF');
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',8);		
	$pdf->Cell(192,5,'RELACIÓN CHEQUES Y/O PAQUETES PENDIENTES DE COBRO',0,1,'C');
	$pdf->SetFont('Arial','',8);	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,10,0,'');
	$pdf->Cell(40,5,'CHEQUES',0,0,'C');
	$pdf->Cell(105,10,'BENEFICIARIO',1,0,'C');
	$pdf->Cell(46,10,'VALOR',1,0,'C');		
	$pdf->Cell(5,5,'',0,1,'C');
	$pdf->Cell(23,5,'FECHA',1,0,'C');		
	$pdf->Cell(17,5,'No.',1,1,'C');	
	$pdf->RoundedRect(9,$actual+10,192,5,0,'');
	$r_cheques = explode("#",$rel_cheques);
	for ($i=0;$i<=count($r_cheques)-1;++$i)
	{
		if ($i == 0) $fe_chq = explode("|",$r_cheques[$i]);
		if ($i == 1) $num_chq = explode("|",$r_cheques[$i]);
		if ($i == 2) $nota_chq = explode("|",$r_cheques[$i]);
		if ($i == 3) $val_chq = explode("|",$r_cheques[$i]);
	}   //for
	
	$val = 0;
	$s_val = 0;	
	for ($i=0;$i<=count($fe_chq)-1;++$i)
	{
		if ($fe_chq[$i] <> "")
		{
			$pdf->RoundedRect(9,$actual,192,10,0,'');
			$pdf->Cell(23,5,$fe_chq[$i],1,0,'C');		
			$pdf->Cell(17,5,$num_chq[$i],1,0,'C');		
			$pdf->Cell(105,5,$nota_chq[$i],1,0,'L');
			$val = str_replace(',','',$val_chq[$i]);
			$pdf->Cell(46,5,'$'.number_format($val,2),1,0,'R');	
			$s_val = $s_val + $val;
			$pdf->Cell(5,5,'',0,1,'C');
		}   //if
	}   //for

	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','B',8);
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(145,5,'TOTAL CHEQUES PENDIENTES DE COBRO',0,0,'l');
	$pdf->Cell(46,5,'$'.number_format($s_val,2),1,1,'R');
	$pdf->SetFont('Arial','',8);

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual+2,192,5,0,'DF');
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(192,5,'NOTAS DEBITO NO REGISTRADAS EN AUXILIAR DE BANCOS',0,1,'C');
	$pdf->SetFont('Arial','',8);		
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(23,5,'FECHA',0,0,'C');
	$pdf->Cell(17,5,'NUMERO',1,0,'C');
	$pdf->Cell(105,5,'DESCRIPCIÓN',1,0,'C');	
	$pdf->Cell(46,5,'VALOR',1,1,'C');		

	$r_debito = explode("#",$rel_debito);
	for ($i=0;$i<=count($r_debito)-1;++$i)
	{
		if ($i == 0)
		{
			$fe_deb = substr($r_debito[$i],0,-1);
			$fe_deb = explode("|",$r_debito[$i]);
		}   //if
		if ($i == 1)
		{
			$num_deb = substr($r_debito[$i],0,-1);
			$num_deb = explode("|",$r_debito[$i]);
		}   //if
		if ($i == 2)
		{
			$nota_deb = substr($r_debito[$i],0,-1);
			$nota_deb = explode("|",$r_debito[$i]);
		}   //if
		if ($i == 3)
		{
			$val_deb = substr($r_debito[$i],0,-1);
			$val_deb = explode("|",$r_debito[$i]);
		}   //if
	}   //for
	$val = 0;
	$s_val = 0;
	for ($i=0;$i<=count($fe_deb)-1;++$i)
	{
		if ($fe_deb[$i] <> "")
		{
			$pdf->RoundedRect(9,$actual,192,10,0,'');
			$pdf->Cell(23,5,$fe_deb[$i],0,0,'C');		
			$pdf->Cell(17,5,$num_deb[$i],1,0,'C');		
			$pdf->Cell(105,5,$nota_deb[$i],1,0,'L');
			$val = str_replace(',','',$val_deb[$i]);
			$pdf->Cell(46,5,'$'.number_format($val,2),1,1,'R');	
			$s_val = $s_val + $val;
		}   //if
	}   //for
	
	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','B',8);
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(145,5,'TOTAL NOTAS DEBITO NO REGISTRADAS EN LIBROS',0,0,'l');
	$pdf->Cell(46,5,'$'.number_format($s_val,2),1,1,'R');
	$pdf->SetFont('Arial','',8);	

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual+2,192,5,0,'DF');
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(192,5,'NOTAS CREDITO NO REGISTRADAS EN AUXILIAR DE BANCOS',0,1,'C');
	$pdf->SetFont('Arial','',8);		
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(23,5,'FECHA',0,0,'C');
	$pdf->Cell(17,5,'NUMERO',1,0,'C');
	$pdf->Cell(105,5,'DESCRIPCIÓN',1,0,'L');	
	$pdf->Cell(46,5,'VALOR',1,1,'C');

	$r_credito = explode("#",$rel_credito);
	for ($i=0;$i<=count($r_credito)-1;++$i)
	{
		if ($i == 0)
		{
			$fe_cre = substr($r_credito[$i],0,-1);
			$fe_cre = explode("|",$r_credito[$i]);
		}   //if
		if ($i == 1)
		{
			$num_cre = substr($r_credito[$i],0,-1);
			$num_cre = explode("|",$r_credito[$i]);
		}   //if
		if ($i == 2)
		{
			$nota_cre = substr($r_credito[$i],0,-1);
			$nota_cre = explode("|",$r_credito[$i]);
		}   //if
		if ($i == 3)
		{
			$val_cre = substr($r_credito[$i],0,-1);
			$val_cre = explode("|",$r_credito[$i]);
		}   //if
	}   //for
	$val = 0;
	$s_val = 0;
	for ($i=0;$i<=count($fe_cre)-1;++$i)
	{
		if ($fe_cre[$i] <> "")
		{
			$pdf->RoundedRect(9,$actual,192,10,0,'');
			$pdf->Cell(23,5,$fe_cre[$i],0,0,'C');		
			$pdf->Cell(17,5,$num_cre[$i],1,0,'C');		
			$pdf->Cell(105,5,$nota_cre[$i],1,0,'L');
			$val = str_replace(',','',$val_cre[$i]);
			$pdf->Cell(46,5,'$'.number_format($val,2),1,1,'R');	
			$s_val = $s_val + $val;
		}   //if
	}   //for	

	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','B',8);
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(145,5,'TOTAL NOTAS CREDITO',0,0,'l');
	$pdf->Cell(46,5,'$'.number_format($s_val,2),1,1,'R');
	$pdf->SetFont('Arial','',8);			

	$consulta_org = "select * from cx_org_sub where unic = 1 and subdependencia = '".$uni_usuario."'";
	$cur_org = odbc_exec($conexion,$consulta_org);
	$eje_nombre = trim(odbc_result($cur_org,13));
	$eje_cargo = trim(odbc_result($cur_org,28));
	$jem_nombre = trim(odbc_result($cur_org,14));
	$jem_cargo = trim(odbc_result($cur_org,29));	
	$cdo_nombre = trim(odbc_result($cur_org,15));
	$cdo_cargo = trim(odbc_result($cur_org,30));			

	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,96,46,0,'D');	
	$pdf->RoundedRect(105,$actual,96,46,0,'D');	
	$pdf->Cell(192,20,'',0,1,'C');
	
	//Busca imagen de la firma oficial de administracion
	//$eje_nombre = "JAIME ALBERTO MORALES (CX)";  
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$eje_nombre."'";
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
		$tamano = getimagesize($file);
		if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	if ($tamaño[0] == 0) $w = 30;
	else $w =  ($tamaño[0]*30)/317;
	$pdf->Cell(95,5,$pdf->Image($file,15,$actual-20,$w,30),0,0,'C');		

	//Busca imagen de la firma Jefe de estado mayor
	//$jem_nombre = "JAIME ALBERTO MORALES (CX)";  
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$jem_nombre."'";
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
		$tamano = getimagesize($file);
		if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	if ($tamaño[0] == 0) $w = 30;
	else $w =  ($tamaño[0]*30)/317;
	$pdf->Cell(95,5,$pdf->Image($file,122,$actual-20,$w,30),0,1,'C');		

	$pdf->Ln(2);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(95,5,'_____________________________________________',0,0,'C');
	$pdf->Cell(95,5,'_____________________________________________',0,1,'C');	
	$pdf->Cell(96,5,$eje_nombre,0,0,'C');
	$pdf->Cell(96,5,$jem_nombre,0,1,'C');
	$pdf->Cell(96,5,$eje_cargo,0,0,'C');
	$pdf->Cell(96,5,$jem_cargo,0,1,'C');	
	$pdf->Cell(192,20,'',0,1,'C');
	$pdf->Ln(3);

	//Busca imagen de la firma Jefe del comandante
	//$cdo_nombre = "JAIME ALBERTO MORALES (CX)";  
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$cdo_nombre."'";
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
		$tamano = getimagesize($file);
		if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	if ($tamaño[0] == 0) $w = 30;
	else $w =  ($tamaño[0]*30)/317;
	$pdf->Cell(95,5,$pdf->Image($file,57,$actual-20,$w,30),0,1,'C');	

	$pdf->Ln(2);
	$pdf->Cell(192,5,'_____________________________________________',0,1,'C');
	$pdf->Cell(192,5,$cdo_nombre,0,1,'C');
	$pdf->Cell(192,5,$cdo_cargo,0,1,'C');
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,5,0,'D');	
	$pdf->Cell(15,5,'Elaboró:    '.strtr($nom_usuario, $sustituye),0,1,'L');

	// Grabación de PDF
	ob_end_clean();
	$carpeta = $ruta_local."\\fpdf\\pdf\\Conciliaciones\\";
	if(!file_exists($carpeta))
	{
		mkdir ($carpeta);
	}
	$carpeta1 = $carpeta.$_GET['ano'];
	if(!file_exists($carpeta1))
	{
		mkdir ($carpeta1);
	}
	$nom_pdf = "pdf/Conciliaciones/".$_GET['ano']."/Concilia_".$uni_usuario."_".$_GET['periodo']."_".$_GET['ano']."_".$_GET['cuenta'].".pdf";
	$pdf->Output($nom_pdf,"F");
	// Fin grabación PDF

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";
}
?>

