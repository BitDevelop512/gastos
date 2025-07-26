<?php
session_start();
$unidad = $_POST['unidad_excel'];
$empadrona = $_POST['dias_excel'];
$activo = $_POST['tanqueo_excel'];
$sigla = $_POST['promedio_excel'];
$combustible = $_POST['combustible_excel'];
if ($combustible == "1")
{
	$tp_combus = "GASOLINA";
}
else
{
	$tp_combus = "ACPM / DIESEL";
}
$mes = $_POST['mes_excel'];
$ano = $_POST['ano_excel'];
$ciudad = $_POST['ciu_excel'];
$nombre = $_POST['uni_excel'];
$descripcion = $_POST['veh_excel'];
$gpaso = $_POST['paso_excel_g1'];
$paso = $_POST['paso_excel_g2'];
$paso1 = explode("#",$paso);
require_once dirname(__FILE__) . './clases/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->
getProperties()
	->setCreator("Cx Computers")
	->setLastModifiedBy("Cx Computers")
	->setTitle("Planilla Llantas")
	->setSubject("Consulta Web");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:H2');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:F3');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D4:E4');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:B5');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C5:H5');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:H7');
$objPHPExcel->getActiveSheet()->getStyle('A1:H7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B3:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B4:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A6:A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B6:B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C6:C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H6:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A7:A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('H3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFont()->setBold(true);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($BStyle);
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
	->setCellValue('A1', 'FORMATO ADQUISICIÓN LLANTAS VEHICULO '.$sigla)
	->setCellValue('A2', $nombre.' '.$sigla)
	->setCellValue('A3', 'PLACA')
	->setCellValue('A4', 'No Inventario')
	->setCellValue('G3', 'Fecha Adquisición')
	->setCellValue('C4', 'Almacén Adquisición')
	->setCellValue('F4', 'No Factura')
	->setCellValue('A5', 'DESCRIPCION VEHICULO')
	->setCellValue('C5', '')
	->setCellValue('A6', 'ITEM')
	->setCellValue('B6', 'DESCRIPCION DE LA NECESIDAD')
	->setCellValue('C6', 'MARCA')
	->setCellValue('D6', 'REFERENCIA')
	->setCellValue('E6', 'CANTIDAD')
	->setCellValue('F6', 'VALOR UNITARIO')
	->setCellValue('G6', 'IVA 19%')
	->setCellValue('H6', 'VALOR TOTAL')
	->setCellValue('A7', 'SUMINISTROS');
$j = 8;
$z = 1;
$total1 = 0;
$total2 = 0;
$total3 = 0;
$total4 = 0;
for ($i=0;$i<count($paso1)-1;++$i)
{
	$variables = $paso1[$i];
	if ($i == "0")
	{
		$objPHPExcel->setActiveSheetIndex($i)->setTitle("Planilla Llantas");
	}
	else
	{
		$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($i)->setTitle("Planilla Llantas ".$i);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A1:H1');
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A2:H2');
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('C3:F3');
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('D4:E4');
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A5:B5');
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('C5:H5');
		$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A7:H7');
		$objPHPExcel->getActiveSheet()->getStyle('A1:H7')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A3:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B3:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B4:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A6:A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B6:B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C6:C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H6:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A7:A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('H3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFill()->getStartColor()->setARGB('CCCCCC');
		$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFill()->getStartColor()->setARGB('CCCCCC');
		$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFont()->setBold(true);
		$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($BStyle);
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
			->setCellValue('A1', 'FORMATO ADQUISICIÓN LLANTAS VEHICULO '.$sigla)
			->setCellValue('A2', $nombre.' '.$sigla)
			->setCellValue('A3', 'PLACA')
			->setCellValue('A4', 'No Inventario')
			->setCellValue('G3', 'Fecha Adquisición')
			->setCellValue('C4', 'Almacén Adquisición')
			->setCellValue('F4', 'No Factura')
			->setCellValue('A5', 'DESCRIPCION VEHICULO')
			->setCellValue('C5', '')
			->setCellValue('A6', 'ITEM')
			->setCellValue('B6', 'DESCRIPCION DE LA NECESIDAD')
			->setCellValue('C6', 'MARCA')
			->setCellValue('D6', 'REFERENCIA')
			->setCellValue('E6', 'CANTIDAD')
			->setCellValue('F6', 'VALOR UNITARIO')
			->setCellValue('G6', 'IVA 19%')
			->setCellValue('H6', 'VALOR TOTAL')
			->setCellValue('A7', 'SUMINISTROS');
	}
	$variables = $paso1[$i];
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
		if (($v8 == "") or ($v8 == "0"))
		{
			$v8 = 1;
		}
		$v9 = $paso4[3];
		$v10 = $paso4[4];
		$v11 = $paso4[5];
		$v12 = $paso4[6];
		$v13 = $paso4[7];
		$v14 = $paso4[8];
		if ($empadrona == "F")
		{
			$v14_1 = explode("-",$v14);
			$v14_2 = $v14_1[0];
			$v14_3 = $v14_1[1];
			$v14_4 = $v14_1[2];
		}
		else
		{
			$v14_1 = explode("-",$v14);
			$v14_2 = $v14_1[1];
			$v14_3 = $v14_1[0];
			$v14_4 = "N/A";
		}
		$v15 = $paso4[9];
		$v16 = $paso4[10];
		$v17 = $paso4[11];
		$v18 = $paso4[12];
		if ($empadrona == "F")
		{

			if (($v8 == "1") and ($v13 == $v11))
			{
				$v19 = 0;
			}
			else
			{
				$v20 = ($v8*$v11);
				if ($v20 == $v13)
				{
					$v19 = 0;
				}
				else
				{
					$v19 = $v11*(0.19);
				}
			}
		}
		else
		{
			$v19 = $v13-($v11*$v8);
		}
		if ($v1 == $v7)
		{
			$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
			$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':A'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$j.':C'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
				->setCellValue('D4', $v14_4)
				->setCellValue('H3', $v17)
				->setCellValue('G4', $v18)
				->setCellValue('A'.$j, $z)
				->setCellValue('B'.$j, 'ADQUISICIÓN LLANTAS')
				->setCellValue('C'.$j, $v14_3)
				->setCellValue('D'.$j, $v14_2)
				->setCellValue('E'.$j, $v8)
				->setCellValue('F'.$j, $v11)
				->setCellValue('G'.$j, $v19)
				->setCellValue('H'.$j, $v13);
			$total1 = $total1+($v8*$v11);
			$total2 = $total2+$v13;
			$total3 = $total3+$v19;
			$z++;
			$j++;
		}
	}
	$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A'.$j.':G'.$j);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex($i)
		->setCellValue('A'.$j, 'SUBTOTAL')
		->setCellValue('H'.$j, $total1);
	$j++;

	$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A'.$j.':G'.$j);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex($i)
		->setCellValue('A'.$j, 'IVA 19%')
		->setCellValue('H'.$j, $total3);
	$j++;

	$objPHPExcel->setActiveSheetIndex($i)->mergeCells('A'.$j.':G'.$j);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':H'.$j)->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex($i)
		->setCellValue('A'.$j, 'TOTAL')
		->setCellValue('H'.$j, $total2);
	$j++;
	$j = 8;
	$z = 1;
	$total1 = 0;
	$total2 = 0;
	$total3 = 0;
	$total4 = 0;
}
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Llantas.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
// 07/12/2023 - Descripción del vehículo
// 11/01/2023 - Ajuste excel contratos
// 07/06/2024 - Ajuste varios hojas
?>