<?php
session_start();
$unidad = $_POST['unidad_excel'];
$empadrona = $_POST['dias_excel'];
$rtm = $_POST['galones_excel'];
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
	->setTitle("Planilla RTM")
	->setSubject("Consulta Web");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D3:D3');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D4:D4');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:B5');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C5:G5');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:C6');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:G7');
$objPHPExcel->getActiveSheet()->getStyle('A1:G7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B3:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B4:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A6:A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B6:B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A7:A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('F4:F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('G3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A7:G7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A7:G7')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A7:G7')->getFont()->setBold(true);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A3:A3')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('B3:B3')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('C3:F3')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('G3:G3')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A4:A4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('B4:B4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('C4:E4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('F4:F4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('G4:G4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A5:B5')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('C5:G5')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A6:A6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('B6:C6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('D6:D6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('E6:E6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('F6:F6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('G6:G6')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A7:G7')->applyFromArray($BStyle);
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'FORMATO REVISIÓN TÉCNICO MECÁNICA VEHICULO '.$sigla)
	->setCellValue('A2', $nombre.' '.$sigla)
	->setCellValue('A3', 'PLACA')
	->setCellValue('A4', 'No Inventario')
	->setCellValue('D3', 'Fecha Vencimiento')
	->setCellValue('F3', 'Fecha Adquisición')
	->setCellValue('C4', 'Nombre del CDA')
	->setCellValue('E4', 'No Factura')
	->setCellValue('A5', 'DESCRIPCION VEHICULO')
	->setCellValue('C5', '')
	->setCellValue('A6', 'ITEM')
	->setCellValue('B6', 'DESCRIPCION DE LA NECESIDAD')
	->setCellValue('D6', 'CANTIDAD')
	->setCellValue('E6', 'VALOR UNITARIO')
	->setCellValue('F6', 'IVA 19%')
	->setCellValue('G6', 'VALOR TOTAL')
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
	$paso2 = explode("^",$variables);
	$v1 = $paso2[0];
	$v2 = $paso2[1];
	$v3 = $paso2[2];
	$v4 = $paso2[3];
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
		$v15 = $paso4[9];
		$v16 = $paso4[10];
		$v17 = $v12-$v10;
		if ($v1 == $v7)
		{
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$j.':C'.$j);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':A'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$j.':D'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$j.':E'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$j.':F'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->applyFromArray($BStyle);
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B3', $v1)
				->setCellValue('B4', $activo)
				->setCellValue('C5', $descripcion)
				->setCellValue('E3', $rtm)
				->setCellValue('G3', $v14)
				->setCellValue('D4', $v13)
				->setCellValue('F4', $v15)
				->setCellValue('A'.$j, $z)
				->setCellValue('B'.$j, 'ADQUISICIÓN REVISIÓN TÉCNICO MECÁNICA')
				->setCellValue('D'.$j, $v8)
				->setCellValue('E'.$j, $v10)
				->setCellValue('F'.$j, $v17)
				->setCellValue('G'.$j, $v12);
			$total1 = $total1+$v10;
			$total2 = $total2+$v12;
			$total3 = $total3+$v17;
			$z++;
			$j++;
		}
	}
}
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$j.':F'.$j);
$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':F'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->applyFromArray($BStyle);
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$j, 'SUBTOTAL')
	->setCellValue('G'.$j, $total1);
$j++;

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$j.':F'.$j);
$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':F'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->applyFromArray($BStyle);
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$j, 'IVA 19%')
	->setCellValue('G'.$j, $total3);
$j++;

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$j.':F'.$j);
$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':F'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->applyFromArray($BStyle);
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$j, 'TOTAL')
	->setCellValue('G'.$j, $total2);
$j++;

$objPHPExcel->getActiveSheet()->setTitle('Planilla RTM');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="RTM.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
// 27/11/2023 - Excel rtm
// 28/11/2023 - Ajustes excel
// 07/12/2023 - Descripción del vehículo
// 11/01/2023 - Ajuste excel contratos
?>