<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(5,15,30,22,20,20,20,20,20,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$finicio=$_GET['finicio'];
$ffin=$_GET['ffin'];
$cfilial="";
$dfilial=$_GET['dfilial'];


		if($_GET['cfilial']!='000' && $array['cfilial']!=""){
			$cfilial=" AND b.cfilial='".$_GET['cfilial']."' ";
		}

		$nrobol='';
		if($_GET['nrobol']!='000' && $_GET['nrobol']!=''){
			$nrobol=" AND (b.dnumbol='".$_GET['nrobol']."' OR b.cboleta like '%".$_GET['nrobol']."%') ";
		}

		$serbol='';
		if($_GET['serbol']!='000' && $_GET['serbol']!=''){
			$serbol=" AND (b.dserbol='".$_GET['serbol']."' OR b.cboleta like '%".$_GET['serbol']."%') ";
		}

		$sql="	SELECT f.`dfilial`,CONCAT_WS(' ',p.`dnomper`,p.`dappape`,p.`dapmape`) AS nombre,b.`cboleta`,b.`fechaan`,
				CONCAT(b.`dserbol`,'-',b.`dnumbol`) AS cboletanu,b.`fechanu`,b.`fusuari`
				FROM bitbolm b
				INNER JOIN filialm f ON (b.`cfilial`=f.`cfilial`)
				INNER JOIN personm p ON (b.`cperson`=p.`cperson`)
				where date(b.fusuari) between '".$finicio."' and '".$ffin."' ".
				$cfilial.$where.$serbol.$nrobol.
				" ORDER BY nombre,b.fusuari"; 	

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


$objPHPExcel->getActiveSheet()->setCellValue("A2","BITACORA DE BOLETA ");
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($styleAlignmentBold);

$cabecera=array('N°','FILIAL','PERSONA MODIFICO','FECHA MODIFICO','BOLETA ANTERIOR','FECHA ANTERIOR','BOLETA NUEVA','FECHA NUEVA');

	for($i=0;$i<count($cabecera);$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."3",$cabecera[$i]);
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."3")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}
$objPHPExcel->getActiveSheet()->getStyle('A3:'.$az[($i-1)].'3')->applyFromArray($styleAlignmentBold);


$objPHPExcel->getActiveSheet()->getStyle("A3:".$az[($i-1)]."3")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');



//$objPHPExcel->getActiveSheet()->getStyle('A2:'.$az[($i-1)].'2')->applyFromArray($styleColor);

$valorinicial=3;
$cont=0;
$total=0;
$pago="";
//$objPHPExcel->getActiveSheet()->getStyle("A".$valorinicial.":O".$valorinicial)->getFont()->getColor()->setARGB("FFF0F0F0");  es para texto
foreach($control as $r){
$cont++;
$valorinicial++;
$objPHPExcel->getActiveSheet()->setCellValue("A".$valorinicial,$cont);
$objPHPExcel->getActiveSheet()->setCellValue("B".$valorinicial,$r['dfilial']);
$objPHPExcel->getActiveSheet()->setCellValue("C".$valorinicial,$r['nombre']);
$objPHPExcel->getActiveSheet()->setCellValue("D".$valorinicial,$r['fusuari']);
$objPHPExcel->getActiveSheet()->setCellValue("E".$valorinicial,$r['cboleta']);
$objPHPExcel->getActiveSheet()->setCellValue("F".$valorinicial,$r['fechaan']);
$objPHPExcel->getActiveSheet()->setCellValue("G".$valorinicial,$r['cboletanu']);
$objPHPExcel->getActiveSheet()->setCellValue("H".$valorinicial,$r['fechanu']);
}

$objPHPExcel->getActiveSheet()->getStyle('A2:H'.$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Bitacora_Boleta');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Bitacora_Boleta_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>