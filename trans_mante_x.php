<?php
session_start();
$empadrona = $_POST['dias_excel'];
$combustible = $_POST['combustible_excel'];
if ($combustible == "1")
{
	$tp_combus = "GASOLINA";
}
else
{
	$tp_combus = "ACPM / DIESEL";
}
$sigla = $_POST['promedio_excel'];
$nombre = $_POST['uni_excel'];
$gpaso = $_POST['paso_excel_g1'];
$paso = $_POST['paso_excel_g2'];
$paso1 = explode("#",$paso);
require_once dirname(__FILE__) . './clases/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->
getProperties()
	->setCreator("Cx Computers")
	->setLastModifiedBy("Cx Computers")
	->setTitle("Planilla Mantenimiento")
	->setSubject("Consulta Web");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:H2');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:F3');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:B5');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C5:H5');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:C6');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:H7');
$objPHPExcel->getActiveSheet()->getStyle('A2:H7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B3:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B4:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C3:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A6:A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B6:B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H6:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A7:A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('G4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFont()->setBold(true);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A3:A3')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('B3:B3')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('C3:F3')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('G3:G3')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('H3:H3')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A4:A4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('B4:B4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('C4:E4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('F4:F4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('G4:G4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('H4:H4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A5:B5')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('C5:H5')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A6:A6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('B6:C6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('H6:H6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->applyFromArray($BStyle);
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', 'MANTENIMIENTO VEHICULO '.$sigla)
	->setCellValue('A3', 'PLACA')
	->setCellValue('A4', 'No Inventario')
	->setCellValue('C3', $nombre.' '.$sigla)
	->setCellValue('G3', 'FECHA')
	->setCellValue('F4', 'No Factura')
	->setCellValue('A5', 'DESCRIPCION VEHICULO')
	->setCellValue('C5', '')
	->setCellValue('A6', 'ITEM')
	->setCellValue('B6', 'DESCRIPCION DE LA NECESIDAD')
	->setCellValue('D6', 'UNIDAD DE MEDIDA')
	->setCellValue('E6', 'CANTIDAD')
	->setCellValue('F6', 'VALOR UNITARIO')
	->setCellValue('G6', 'IVA 19%')
	->setCellValue('H6', 'VALOR TOTAL')
	->setCellValue('A7', 'REPUESTOS');
$j = 8;
$z = 1;
$total1 = 0;
$total2 = 0;
$total3 = 0;
$total4 = 0;
$total5 = 0;
for ($i=0;$i<count($paso1)-1;++$i)
{
	$variables = $paso1[$i];
	if ($i == "0")
	{
		$objPHPExcel->setActiveSheetIndex($i)->setTitle("Planilla Mantenimiento");
	}
	else
	{
		$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($i)->setTitle("Planilla Mantenimiento ".$i);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A2:H2');
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('C3:F3');
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A5:B5');
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('C5:H5');
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('B6:C6');
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A7:H7');
		$objPHPExcel->getActiveSheet()->getStyle('A2:H7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A3:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B4:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C3:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B6:B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('G4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFill()->getStartColor()->setARGB('CCCCCC');
		$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFill()->getStartColor()->setARGB('CCCCCC');
		$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFont()->setBold(true);
		$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
		$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A3:A3')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('B3:B3')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('C3:F3')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('G3:G3')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('H3:H3')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A4:A4')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('B4:B4')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('C4:E4')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('F4:F4')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('G4:G4')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('H4:H4')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A5:B5')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('C5:H5')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A6:A6')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('B6:C6')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H6')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->applyFromArray($BStyle);
		$objPHPExcel->setActiveSheetIndex($i)
			->setCellValue('A2', 'MANTENIMIENTO VEHICULO '.$sigla)
			->setCellValue('A3', 'PLACA')
			->setCellValue('A4', 'No Inventario')
			->setCellValue('C3', $nombre.' '.$sigla)
			->setCellValue('G3', 'FECHA')
			->setCellValue('F4', 'No Factura')
			->setCellValue('A5', 'DESCRIPCION VEHICULO')
			->setCellValue('C5', '')
			->setCellValue('A6', 'ITEM')
			->setCellValue('B6', 'DESCRIPCION DE LA NECESIDAD')
			->setCellValue('D6', 'UNIDAD DE MEDIDA')
			->setCellValue('E6', 'CANTIDAD')
			->setCellValue('F6', 'VALOR UNITARIO')
			->setCellValue('G6', 'IVA 19%')
			->setCellValue('H6', 'VALOR TOTAL')
			->setCellValue('A7', 'REPUESTOS');
	}
	$paso2 = explode("^",$variables);
	$v1 = $paso2[0];
	$v2 = $paso2[1];
	$v3 = $paso2[2];
	$v4 = $paso2[3];
	$v5 = $paso2[4];
	$v6 = $paso2[5];
	$v7 = $paso2[6];
	$v8 = $paso2[7];
	$v9 = $paso2[8];
	$v10 = $paso2[9];
	if ($v10 == "")
	{
		$v10 = 0;
	}
	$descripcion = $v5;
	$activo = $v6;
	$sigla = $v7;
	$nombre = $v8;
	$rtm = $v9;
	$iva = $v10;
	$paso3 = explode("|",$v3);
	for ($k=0;$k<count($paso3)-1;++$k)
	{
		$v5 = $paso3[$k];
		$paso4 = explode("»",$v5);
		$v6 = $paso4[0];
		$v7 = $paso4[1];
		$v8 = $paso4[2];
		$v9 = $paso4[3];
		$v10 = $paso4[4];
		$v11 = $paso4[5];
		$v12 = $paso4[6];
		$v13 = $paso4[7];
		$v14 = $paso4[8];
		$v15 = $paso4[9];
		$v16 = $paso4[10];
		$v17 = $paso4[11];
		$v18 = $paso4[12];
		$v19 = $paso4[13];
		$v20 = $paso4[14];
		$v21 = $paso4[15];
		$v22 = $paso4[16];
		$v23 = $paso4[17];
		$v24 = $paso4[18];
		$v25 = $paso4[19];
		if ($v20 == "OTRO")
		{
			$v26 = $v20;
			$v27 = "";
		}
		else
		{
			$paso5 = explode("-",$v20);
			$v26 = $paso5[0];
			$v27 = $paso5[1];
		}
		if ($empadrona == "F")
		{
			if (($v8 == "1") and ($v10 == $v12))
			{
				$v28 = 0;
			}
			else
			{
				$v29 = ($v8*$v10);
				if ($v29 == $v12)
				{
					$v28 = 0;
				}
				else
				{
					$v28 = $v10*(0.19);
				}
			}
		}
		else
		{
			$v28 = $v15;
		}
		$v28 = round($v28, 2);
		$total1 = $total1+$v12;
		$total3 = $total3+$v28;
		$total5 = $total5+($v8*$v10);
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('B'.$j.':C'.$j);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':A'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$j.':D'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$j.':E'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$j.':F'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$j.':H'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->applyFromArray($BStyle);
		$objPHPExcel->setActiveSheetIndex($i)
			->setCellValue('B3', $v1)
			->setCellValue('B4', $activo)
			->setCellValue('C5', $descripcion)
			->setCellValue('H3', $v21)
			->setCellValue('G4', $v22)
			->setCellValue('A'.$j, $z)
			->setCellValue('B'.$j, $v26)
			->setCellValue('D'.$j, $v27)
			->setCellValue('E'.$j, $v8)
			->setCellValue('F'.$j, $v10)
			->setCellValue('G'.$j, $v28)
			->setCellValue('H'.$j, $v12);
		$z++;
		$j++;
	}
	// Mano de Obra no en contratos
	if ($empadrona == "F")
	{
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->getFill()->getStartColor()->setARGB('CCCCCC');
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->getFont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A'.$j.':H'.$j);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->setActiveSheetIndex($i)
			->setCellValue('A'.$j, 'MANO DE OBRA');
		$j++;
		$z = 1;
		for ($k=0;$k<count($paso3)-1;++$k)
		{
			$v5 = $paso3[$k];
			$paso4 = explode("»",$v5);
			$v6 = $paso4[0];
			$v7 = $paso4[1];
			$v8 = $paso4[2];
			$v9 = $paso4[3];
			$v10 = $paso4[4];
			$v11 = $paso4[5];
			$v12 = $paso4[6];
			$v13 = $paso4[7];
			$v14 = $paso4[8];
			$v15 = $paso4[9];
			$v16 = $paso4[10];
			$v17 = $paso4[11];
			$v18 = $paso4[12];
			$v19 = $paso4[13];
			$v20 = $paso4[14];
			$v21 = $paso4[15];
			$v22 = $paso4[16];
			$v23 = $paso4[17];
			$v24 = $paso4[18];
			$v25 = $paso4[19];
			if ($v20 == "OTRO")
			{
				$v26 = $v26;
				$v27 = "";
			}
			else
			{
				$paso5 = explode("-",$v20);
				$v26 = $paso5[0];
				$v27 = $paso5[1];
			}
			if ($v15 == $v17)
			{
				$v30 = 0;
			}
			else
			{
				$v30 = $v17-$v15;
			}
			$total2 = $total2+$v15;
			$total3 = $total3+$v30;
			if ($total3 == "0")
			{
				$total3 = $iva;
			}
			if ($v15 == "0")
			{
			}
			else
			{
				$objPHPExcel->setActiveSheetIndex($i)->mergeCells('B'.$j.':C'.$j);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':A'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$j.':D'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$j.':E'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$j.':F'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$j.':H'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->applyFromArray($BStyle);
				$objPHPExcel->setActiveSheetIndex($i)
					->setCellValue('A'.$j, $z)
					->setCellValue('B'.$j, $v26)
					->setCellValue('D'.$j, $v27)
					->setCellValue('E'.$j, $v8)
					->setCellValue('F'.$j, $v15)
					->setCellValue('G'.$j, $v30)
					->setCellValue('H'.$j, $v17);
				$z++;
				$j++;
			}
		}
	}
	if ($empadrona == "F")
	{
		$total1 = $total5;
	}
	else
	{
		$total1 = $total5;
	}
	$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A'.$j.':G'.$j);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex($i)
		->setCellValue('A'.$j, 'VALOR TOTAL REPUESTOS')
		->setCellValue('H'.$j, $total1);
	$j++;

	$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A'.$j.':G'.$j);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex($i)
		->setCellValue('A'.$j, 'VALOR TOTAL MANTENIMIENTO')
		->setCellValue('H'.$j, $total2);
	$j++;
	$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A'.$j.':G'.$j);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex($i)
		->setCellValue('A'.$j, 'IVA 19%')
		->setCellValue('H'.$j, $total3);
	$j++;

	$total4 = $total1+$total2+$total3;
	$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A'.$j.':G'.$j);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex($i)
		->setCellValue('A'.$j, 'TOTAL')
		->setCellValue('H'.$j, $total4);
	$j++;
	$j = 8;
	$z = 1;
	$total1 = 0;
	$total2 = 0;
	$total3 = 0;
	$total4 = 0;
	$total5 = 0;
}
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Mantenimiento.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
// 20/11/2023 - Excel mantenimientos
// 28/11/2023 - Ajustes excel
// 07/12/2023 - Descripción del vehículo
// 11/01/2023 - Ajuste excel contratos
// 22/01/2024 - Ajuste excel mantenimientos desde informe gastos
// 26/01/2024 - Ajuste valor total de mantenimiento
// 07/06/2024 - Ajuste varios hojas
// 20/06/2024 - Ajuste mantenimiento OTRO sin unidad
?>