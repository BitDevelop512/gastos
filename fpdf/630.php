$<?php
/* 630.php
   FO-JEMPP-CEDE2-630- Informe de Giros Gastos Reservados.
   (pág 114 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
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
			$sig_usuario = "CEDE2";

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

		function morepagestable($datas, $lineheight=5)
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
					$this->SetFont('Arial','',8);		
					$this->SetXY($l,$h);
					if ($this->tablewidths[$col] == 67) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'R');
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
  			$this->Cell(190,4,'SIGAR - Fecha Impresión: '.$fecha1,0,1,'');
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
	
	$sustituye = array ( 'Á¡' => 'Á', 'Ã¡' => 'á', 'Ãº' => 'ú', 'Ã“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'Ã­' => 'í' );
	$n_bancos = array ('BBVA', 'AV VILLAS', 'DAVIVIENDA', 'BANCOLOMBIA', 'BANCO DE BOGOTA','POPULAR');
	$n_recursos = array('10 CSF', '50 SSF', '16 SSF', 'OTROS');
	$n_rubros = array('204-20-1', '204-20-2', 'A-02-02-04');	

	$n_transacciones = array('TRANSFERENCIA', 'CONSIGNACION', 'NOTA CREDITO');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$autoriza_pag = array('INFORME DE AUTORIZACION','SOLICITUD RECURSOS','PLAN DE NECESIDADES','PLAN NDE INVERSIÓN','INFORME DE AUTORIZACIÓN DE GGRR','AUTORIZACIÓN RECURSOS ADICIONALES GGRR','CONTRATO');   
	$concepto_gas = array('PRESUPUESTO MENSUAL','PRESUPUESTO ADICIONAL','PRESUPUESTO RECOMPENSAS','GASTOS EN ACTIVIDADES DE INTELIGENCIA Y CONTRAINTELIGENCIA','GASTOS DE PROTECIÓN','GASTOS DE IDENTIDAD DE COBERTURA');
	$linea = str_repeat("_",122);

	$consulta = "select * from cx_inf_gir where conse = '".$_GET['informe']."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."'";
	$cur = odbc_exec($conexion,$consulta);
	$informe = odbc_result($cur,1);
	$fecha = substr(odbc_result($cur,2),0,10);
	$recurso = $n_recursos[odbc_result($cur,14)-1];	
	$mes = $n_meses[odbc_result($cur,5)-1];	
	$num_unidades = odbc_result($cur,7);
	$concepto_gir = odbc_result($cur,16);
	$frm1 = trim(odbc_result($cur,20));
	$frm2 = trim(odbc_result($cur,21));
	$interno = odbc_result($cur,25);

	$consulta3="select * from cx_ctr_gas where codigo = '".$concepto_gir."'";
	$cur3 = odbc_exec($conexion,$consulta3);
	$concepto = trim(odbc_result($cur3,2));

	if ($concepto_gir == 8) $tabla = cx_val_aut;
	else if ($concepto_gir == 10) $tabla = cx_val_aut2;
	else if ($concepto_gir == 9) $tabla = cx_val_aut1;
	
	$consulta_aut = "select * from ".$tabla." where inf_giro = '".$_GET['informe']."'";
	$cur_aut = odbc_exec($conexion,$consulta_aut);
	$n_conse = odbc_result($cur_aut,1);
	$registro = odbc_result($cur_aut,22);
	if ($tabla == 'cx_val_aut2')
	{
		$valor_rec = odbc_result($cur_aut,9);
		$autoriza =  odbc_result($cur_aut,25);
	}
	else $valor_rec = odbc_result($cur_aut,10);
	$solicitud =  odbc_result($cur_aut,21);
	$ano1 = odbc_result($cur_aut,24);	
	if ($tabla == 'cx_val_aut1') $autoriza =  odbc_result($cur_aut,22);
	$uni1 =  odbc_result($cur_aut,4);

	if ($concepto_gir == 8) $plan_solicitud = "PLAN DE INVERSIÓN GASTOS RESERVADOS ";
	else if ($concepto_gir == 9) $plan_solicitud = "AUTORIZACIÓN No.  ".$autoriza;    //"SOLICITUD DE RECURSOS "; 
	else if ($concepto_gir == 10)
	{
		$consulta_rman = "select * from cx_rec_man where conse = '".$registro."'"; //$n_conse."'";
		$cur_rman = odbc_exec($conexion,$consulta_rman);
		$concepto_rec = trim(odbc_result($cur_rman,9));
		$n_acta = odbc_result($cur_rman,7);
		$f_acta = substr(odbc_result($cur_rman,8),0,10);	
		$plan_solicitud = $n_acta." - ".$f_acta; 
	}
	
	$consulta2="select usuario, nombre, cargo, ciudad from cx_usu_web where  usuario = 'JEF_CEDE2' OR usuario = 'DIR_DIADI' or usuario = 'STE_DIADI'";
	$cur2 = odbc_exec($conexion,$consulta2);
	$firma1 = trim(odbc_result($cur2,2));
	$cargo1 = trim(odbc_result($cur2,3));
	$ciudad = trim(odbc_result($cur2,4));

	$consulta4="select * from Cx_org_sub where subdependencia = '".odbc_result($cur,7)."'";	
	$cur4 = odbc_exec($conexion,$consulta4);
	$ndependencia = odbc_result($cur4,2);
	$nom_unidad = odbc_result($cur4,4);
	$ciudadyfecha = $ciudad."   -   ".$fecha;

	$consulta5 = "select subdependencia from Cx_org_sub where dependencia = '".$ndependencia."'";	
	$cur5 = odbc_exec($conexion,$consulta5);
    while($i<$row=odbc_fetch_array($cur5))
    {
		$numero.="'".odbc_result($cur5,1)."',";
    }  //while
    $numero = substr($numero,0,-1);

    // Validación numeros anteriores
    if ($interno == "0")
    {
    	$interno = $_GET['informe'];
    }

	$pdf->Ln(-2);	
	$pdf->Cell(190,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(30,5,'LUGAR Y FECHA',0,0,'');
	$pdf->Cell(95,5,$ciudadyfecha,B,0,''); 
	$pdf->Cell(20,5,'NÚMERO',0,0,'');
	$pdf->Cell(45,5,$interno,B,1,'C');
	$pdf->Cell(35,5,'CONCEPTO DEL GIRO',0,0,'');
	$pdf->Cell(155,5,$concepto,B,1,'');
	$pdf->Cell(45,5,'UNIDAD CENTRALIZADORA',0,0,'');
	$pdf->Cell(75,5,$nom_unidad,B,0,'');
	$pdf->Cell(20,5,'RECURSO',0,0,'');
	$pdf->Cell(50,5,$recurso,B,1,'');
	$pdf->Cell(45,5,'REF PLAN / SOLICITUD No.',0,0,'');
	$pdf->Cell(65,5,$plan_solicitud,B,0,'');
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

	if ($concepto_gir == '10') $pdf->Cell(67,4,'PAGO DE RECOMPENSAS',0,1,'C');
	else $pdf->Cell(67,4,'PAGO DE INFORMACIONES',0,1,'C');
	$pdf->Cell(24,4,'',0,0,'C');
	$pdf->Cell(34,4,'',0,0,'C');
	$pdf->Cell(67,4,'INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'C');
	$pdf->Cell(67,4,'',0,1,'C');

	$consulta1 = "select * from ".$tabla." where inf_giro = '".$_GET['informe']."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$subt_gastos = 0;
	$subt_pagos = 0;
	$i=1;
	$pdf->SetFont('Arial','',8);
	while($i<$row=odbc_fetch_array($cur1))
	{
		$val_uni = odbc_result($cur1,4);
		$val_per = odbc_result($cur1,5);
		$val_ano = odbc_result($cur1,6);
		$sigla = trim(odbc_result($cur1,7));
		$gastos_act = trim(odbc_result($cur1,8));
		$pagos_inf = trim(odbc_result($cur1,9));
		if ($concepto_gir == '10')
		{ 
			$ga = "0.00";
			$pi = $pagos_inf;
			$subt_gastos = $subt_gastos + 0;
			$subt_pagos = $subt_pagos + $pagos_inf;
		}
		else
		{
			$ga = $gastos_act;
			$pi = $pagos_inf;
			$subt_gastos = $subt_gastos + $gastos_act;
			$subt_pagos = $subt_pagos + $pagos_inf;
		}
		$data[] = array($i, $sigla, '$'.number_format($ga,2), '$'.number_format($pi,2));
		$i++;
	}  //while
	$actual=$pdf->GetY();
	$pdf->tablewidths = array(24, 34, 67, 67); 
	$pdf->morepagestable($data);
	unset($data);
	
	$pdf->SetFont('Arial','B',8);
	$total_girado = $subt_gastos + $subt_pagos;
	$pdf->Cell(57,5,'SUBTOTAL',B,0,'L');
	$pdf->Cell(67,5,'$'.number_format(trim($subt_gastos),2),1,0,'R');
	$pdf->Cell(67,5,'$'.number_format(trim($subt_pagos),2),1,1,'R');
	$pdf->Cell(124,5,'TOTAL GIRADO',0,0,'L');
	$pdf->Cell(67,5,'$'.number_format(trim($total_girado),2),1,1,'R');
	$pdf->SetFont('Arial','',8);
		
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(67,3,'CONCEPTO DE LA RECOMPENSA AUTORIZADA:',0,1,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(190,3,$linea,0,1,'C');

	$consulta_rr = "select * from cx_reg_rec where conse = '".$solicitud."' and unidad='".$uni1."' and ano = '".$ano1."'";	
	$cur_rr = odbc_exec($conexion,$consulta_rr);
	$n_ordop = trim(odbc_result($cur_rr,24));
	$ordop = trim(odbc_result($cur_rr,25));
	$v_ordop = $n_ordop." - ".$ordop;
	if ($n_ordop == "") $v_ordop = "N/A";
	$fragmenta = trim(odbc_result($cur_rr,27));
	if ($fragmenta == "") $fragmenta = "N/A";
	$unidad_fuente = trim(odbc_result($cur_rr,16));
	$unidad_ope = trim(odbc_result($cur_rr,17));
	$dia_ope = trim(odbc_result($cur_rr,8));
	$fdia_ope = substr($dia_ope,8,2)." de ".$n_meses[substr($dia_ope,5,2) -1]." de ".substr($dia_ope,0,4);
	
	$nr = 0;
	if ($unidad_fuente == $unidad_ope) $lst = $unidad_ope;
	else
	{
		$nr = 1;
		$lst = "'".$unidad_fuente."', '".$unidad_ope."'";
	}   //if
	$consulta_os = "select * from cx_org_sub where subdependencia in (".$lst.")";
	$cur_os = odbc_exec($conexion,$consulta_os);
	if ($nr == 1)
	{
		while ($u<$row=odbc_fetch_array($cur_os))
		{
			if ($u == 0) $n_unidad_fuente = trim(odbc_result($cur_os,4));
			if ($u == 1) $n_unidad_ope = trim(odbc_result($cur_os,4));
			$u++;
		}   //while
	}
	else 
	{
		$n_unidad_ope = trim(odbc_result($cur_os,4));
		$n_unidad_fuente = $n_unidad_ope;
	}   //if	
 
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',9);
	if ($concepto_gir == 10)
	{
		if ($concepto_rec == "")
		{
			$texto_rec = "Pago de recompensas por un valor de $".number_format($valor_rec,2)." de acuerdo a la Autorización de Recursos de Gastos Reservados No. ".$autoriza.", ";
			$texto_rec = $texto_rec." a la fuente que suministro información al ".$n_unidad_fuente.", que coadyuvo al planeamiento y desarrollo de la operación militar ".$v_ordop;
			$texto_rec = $texto_rec.", orden fragmentaria ".$fragmenta." adelantada por tropas del ".$n_unidad_ope.", donde se obtuvo un resultado tangible el día ".$fdia_ope.".";
		}
		else $texto_rec = $concepto_rec;
		$pdf->Multicell(190,3,$texto_rec,0,'J');
		$pdf->SetFont('Arial','',8);	
		$pdf->Cell(190,3,$linea,0,1,'C');
	}
	else $texto_rec = "";

	$pdf->Ln(3);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(191,5,'INSTRUCCIONES GENERALES',0,1,'C');
	if ($concepto_gir == '10') $texto = "1. El pago de la recompensa deberá realizarse con apego al marco legal y determinado para los gastos reservados.\n2. El pago al beneficiario de la recompensa, debe ser realizado de forma inmediata.\n3. El pago de la recompensa, debe ser realizado por la unidad ejecutora de gastos reservados.\n4. La cuenta de gastos reservados deberá ser rendida al CEDE2 con plazo el primer día hábil del siguiente mes.\n5. El pago de la recompensa, deberá realizarse únicamente a la(s) fuente(s) que registra(n) en el expediente de la solicitud.\n6. El pago de la recompensa, deberá cumplir con los requisitos determinados en la directiva permanente No. 000112/2019 y el protocolo de pago de recompensas (Boletín Técnico 022/2019 CEDE2).\n7. Para la ejecución de los recursos de gastos reservados destinados para el pago de recompensas, deberán observar estricto cumplimiento a los principios rectores consagrados en la directiva ministerial permanente No. 02/2019.";
	else $texto = "1. Los recursos deberán ser ejecutado con apego al marco legal y reglamentario de los gastos reservados.\n2. La ejecución de recursos debe ser realizadas de acuerdo los planes de inversión o solicitudes de recursos autorizados.\n3. El pago a beneficiarios de recompensas o pago de informaciones debe ser realizado de forma inmediata.\n4. Los pagos de recompensas deben ser por la Unidad ejecutora de gastos reservados.\n5. Los pagos de informaciones deben ser realizados por la Unidad, Dependencia o Sección que manejó la fuente y solicitó el recurso.\n6. La cuenta de gastos reservados deberá ser rendida al CEDE2, con plazo último día hábil de cada mes.";
	$pdf->SetFont('Arial','',9);
	$pdf->Multicell(190,3,$texto,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(190,3,$linea,0,1,'C');		
	$pdf->Ln(28);

	//Busca imagen de la firma Autorizo
	//$frm1 = "JAIME ALBERTO MORALES (CX)";
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$frm1."'";
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
		$tamano = getimagesize($file);
		//if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	$w =  ($tamaño[0]*30)/317;
	//$pdf->Cell(95,5,$pdf->Image($file,90,$actual-20,$w,30),0,1,'C');

	$pdf->Cell(191,4,'______________________________________________________',0,1,'C');
	$pdf->Cell(191,4,$frm1,0,1,'C');
	$pdf->Cell(191,4,$cargo1,0,1,'C');
	$pdf->Cell(191,4,'',0,1,'C');
	
	$pdf->Cell(190,4,$linea,0,1,'C');
	$texto = "NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Ln(1);
	$pdf->Multicell(191,3,$texto,0,'J');
	$pdf->Cell(190,4,$linea,0,1,'C');
	
	$pdf->Cell(15,4,'Elaboró:',0,0,'');
	$pdf->Cell(30,3,$frm2,0,1,'L');
	$pdf->Cell(190,4,$linea,0,1,'C');

	// Grabación de PDF
	ob_end_clean();
	$carpeta = $ruta_local."\\fpdf\\pdf\\Informes\\";
	if(!file_exists($carpeta))
	{
		mkdir ($carpeta);
	}
	$carpeta1 = $carpeta.$_GET['ano'];
	if(!file_exists($carpeta1))
	{
		mkdir ($carpeta1);
	}
	$nom_pdf = "pdf/Informes/".$_GET['ano']."/InfGiro_".$_GET['informe']."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");
	// Fin grabación PDF

	$file = basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";
}
?>
