<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(5,17,17,17,12,20,12,12,30,15,17,18,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$paterno=trim($_GET['paterno']);
$materno=trim($_GET['materno']);
$nombre=trim($_GET['nombre']);
$dni=trim($_GET['dni']);
$where="";
if($paterno!=''){
$where.=" AND paterno like '%".$paterno."%'";
}
if($materno!=''){
$where.=" AND materno like '%".$materno."%'";
}
if($nombre!=''){
$where.=" AND nombre like '%".$nombre."%'";
}
if($dni!=''){
$where.=" AND dni like '%".$dni."%'";
}

 $sql="Select *
	  from registro 
	  WHERE 1=1 ".$where."
	  order by paterno,materno,nombre";
	  
$cn->setQuery($sql);
$control=$cn->loadObjectList();
/*
echo count($control)."-";
echo $sql;
*/
date_default_timezone_set('America/Lima');


require_once 'includes/Classes/PHPExcel.php';

$styleThinBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
$styleThinBlackBorderAllborders = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
$styleAlignmentBold= array(
	'font'    => array(
		'bold'      => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	),
);
$styleAlignment= array(
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	),
);
$styleAlignmentRight= array(
	'font'    => array(
		'bold'      => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	),
);
$styleColor = array(
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,		
		'startcolor' => array(
			'argb' => 'FFA0A0A0',
			),
		'endcolor' => array(
			'argb' => 'FFFFFFFF',
			)
	),
);

function color(){
	$color=array(0,1,2,3,4,5,6,7,8,9,"A","B","C","D","E","F");
	$dcolor="";
	for($i=0;$i<6;$i++){
	$dcolor.=$color[rand(0,15)];
	}
	$num='FA'.$dcolor;
	
	$styleColorFunction = array(
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,		
		'startcolor' => array(
			'argb' => $num,
			),
		'endcolor' => array(
			'argb' => 'FFFFFFFF',
			)
		),
	);
return $styleColorFunction;
}

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Jorge Salcedo")
							 ->setLastModifiedBy("Jorge Salcedo")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

$objPHPExcel->getDefaultStyle()->getFont()->setName('Bookman Old Style');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
/*
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('PHPExcel');
$objDrawing->setDescription('PHPExcel');
$objDrawing->setPath('includes/images/logohdec.jpg');
$objDrawing->setHeight(40);
$objDrawing->setCoordinates('A2');
$objDrawing->setOffsetX(10);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
*/


$objPHPExcel->getActiveSheet()->setCellValue("A2","LISTADO DE ALUMNOS REGISTRADOS");
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleAlignmentBold);

$cabecera=array('N°','PATERNO','MATERNO','NOMBRE','DNI','EMAIL','TELEFONO','CELULAR','CARRERA');

	for($i=0;$i<count($cabecera);$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."3",$cabecera[$i]);
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."3")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}
$objPHPExcel->getActiveSheet()->getStyle('A3:'.$az[($i-1)].'3')->applyFromArray($styleAlignmentBold);


$objPHPExcel->getActiveSheet()->getStyle("A3:".$az[($i-1)]."3")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');



//$objPHPExcel->getActiveSheet()->getStyle('A2:'.$az[($i-1)].'2')->applyFromArray($styleColor);

$valorinicial=3;
//$objPHPExcel->getActiveSheet()->getStyle("A".$valorinicial.":O".$valorinicial)->getFont()->getColor()->setARGB("FFF0F0F0");  es para texto
foreach($control as $r){	
$cont++;
$valorinicial++;
$objPHPExcel->getActiveSheet()->setCellValue("A".$valorinicial,$cont);
$objPHPExcel->getActiveSheet()->setCellValue("B".$valorinicial,$r['paterno']);
$objPHPExcel->getActiveSheet()->setCellValue("C".$valorinicial,$r['materno']);
$objPHPExcel->getActiveSheet()->setCellValue("D".$valorinicial,$r['nombre']);
$objPHPExcel->getActiveSheet()->setCellValue("E".$valorinicial,$r['dni']);
$objPHPExcel->getActiveSheet()->setCellValue("F".$valorinicial,$r['email']);
$objPHPExcel->getActiveSheet()->setCellValue("G".$valorinicial,$r['tel']);
$objPHPExcel->getActiveSheet()->setCellValue("H".$valorinicial,$r['cel']);
$objPHPExcel->getActiveSheet()->setCellValue("I".$valorinicial,$r['carrera']);
}
$objPHPExcel->getActiveSheet()->getStyle('A2:I'.$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Lista_Alumnos');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Lista_Alumnos_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>