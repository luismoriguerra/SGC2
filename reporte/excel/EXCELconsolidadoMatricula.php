<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(5,20,12.5,50,6,6,6,6,18,12,12,4,11,4,4,4,4,4,11,11,11,6,11,10,10,10,10,10,10,10,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$cfilial=str_replace(",","','",$_GET['cfilial']);
$fechafin = $_GET['fmatric'];
$fechainicio = date("Y-m-01" , strtotime($fechafin));
$ayer = date("Y-m-d" , strtotime("-1 day",strtotime($fechafin)));
$anteayer = date("Y-m-d" , strtotime("-2 day",strtotime($fechafin)));
$cinstit=str_replace(",","','",$_GET['cinstit']);

$diaspromedio=explode("-",$_GET['fmatric']);

$sql="	SELECT f.dfilial,i.dinstit,f.cfilial,i.cinstit,g.ft,g.it,count(g.it) c0,count(g.i1) c1,count(g.i2) c2
		FROM filialm f
		INNER JOIN instita i
		LEFT JOIN
		(
			SELECT g.cfilial ft,g.cinstit it,c.fmatric,g2.cfilial f1,g2.cinstit i1,g3.cfilial f2,g3.cinstit i2
			FROM conmatp c
			INNER JOIN recacap r 
				ON (c.cingalu=r.cingalu AND c.cgruaca=r.cgruaca 
						AND r.ccuota='1' AND r.testfin!='F' 
						AND (r.testfin IN ('P','C') 
									OR (r.testfin='S' AND r.tdocpag!='')
								)
						)
			INNER JOIN concepp co 
				ON (co.cconcep=r.cconcep AND co.cctaing LIKE '701.03%')
			INNER JOIN gracprp g ON g.cgracpr=c.cgruaca
			LEFT JOIN conmatp c2 ON (c2.cconmat=c.cconmat AND c2.fmatric='$ayer')
			LEFT JOIN gracprp g2 ON g2.cgracpr=c2.cgruaca
			LEFT JOIN conmatp c3 ON (c3.cconmat=c.cconmat AND c3.fmatric='$anteayer')
			LEFT JOIN gracprp g3 ON g3.cgracpr=c3.cgruaca
			WHERE c.fmatric BETWEEN '$fechainicio' and '$fechafin'
			GROUP BY c.cconmat
			HAVING MIN(r.tdocpag)!=''
		) g ON (f.cfilial=g.ft AND i.cinstit=g.it)
		WHERE f.cfilial IN ('$cfilial')
		AND i.cinstit IN ('$cinstit')
		GROUP BY f.cfilial,i.cinstit
		ORDER BY f.dfilial,i.dinstit";
$cn->setQuery($sql);
$rpt=$cn->loadObjectList();

$sql2="SELECT concat(dnomper,' ',dappape,' ',dapmape) as nombre
		FROM personm
		WHERE dlogper='".$_GET['usuario']."'";
$cn->setQuery($sql2);
$rpt2=$cn->loadObjectList();

$sql3="SELECT dinstit
		FROM instita
		WHERE cinstit IN ('$cinstit')
		ORDER BY dinstit";
$cn->setQuery($sql3);
$rpt3=$cn->loadObjectList();
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
$styleBold= array(
	'font'    => array(
		'bold'      => true
	)
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

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
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

//$objPHPExcel->getActiveSheet()->setCellValue("A1",$sql);
$objPHPExcel->getActiveSheet()->setCellValue("A2","CONSOLIDADO MATRÍCULA");
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);


$cabecera=array('N°','ODE');
$cantidadaz=1;
for($i=1;$i<=4;$i++){
	$cantidadaz++;
	$azcount[$cantidadaz]=5.5;
	array_push($cabecera, 'TOTALES');
	foreach($rpt3 as $r){
		$cantidadaz++;
		$azcount[$cantidadaz]=5.5;
		array_push($cabecera, $r['dinstit']);
	}
}


	for($i=0;$i<count($cabecera);$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."6",$cabecera[$i]);	
		if($i>=2){
			$objPHPExcel->getActiveSheet()->getStyle($az[$i]."6")->getAlignment()->setTextRotation(90);
		}
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."6")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}

$objPHPExcel->getActiveSheet()->mergeCells('A2:'.$az[($i-1)].'2');
$objPHPExcel->getActiveSheet()->getStyle('A2:'.$az[($i-1)].'2')->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->getRowDimension("5")->setRowHeight(46.5); // altura
$objPHPExcel->getActiveSheet()->getStyle('A5:'.$az[($i-1)].'6')->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
$objPHPExcel->getActiveSheet()->setCellValue("B3","USUARIO:");
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("D3",$rpt2[0]['nombre']);

$objPHPExcel->getActiveSheet()->mergeCells('B4:C4');
$objPHPExcel->getActiveSheet()->setCellValue("B4","FECHA IMPRESIÓN");
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("D4",date("Y-m-d"));

//$objPHPExcel->getActiveSheet()->mergeCells('L4');
$objPHPExcel->getActiveSheet()->setCellValue("B5","FECHA MATRÍCULA ".$fechafin);
$objPHPExcel->getActiveSheet()->getStyle("B5")->getAlignment()->setWrapText(true);
//$objPHPExcel->getActiveSheet()->getStyle('L4')->applyFromArray($styleAlignmentRight);
//$objPHPExcel->getActiveSheet()->setCellValue("M4",$fechafin);


$objPHPExcel->getActiveSheet()->setCellValue("C5", 'PROMEDIO');
$objPHPExcel->getActiveSheet()->mergeCells('C5:'.$az[(2+count($rpt3)*1+1-1)]."5");
$objPHPExcel->getActiveSheet()->setCellValue($az[(2+count($rpt3)*1+1)]."5", 'CONSOLIDADO');
$objPHPExcel->getActiveSheet()->mergeCells($az[(2+count($rpt3)*1+1)]."5:".$az[(2+count($rpt3)*2+2-1)]."5");
$objPHPExcel->getActiveSheet()->setCellValue($az[(2+count($rpt3)*2+2)]."5", $ayer);
$objPHPExcel->getActiveSheet()->mergeCells($az[(2+count($rpt3)*2+2)]."5:".$az[(2+count($rpt3)*3+3-1)]."5");
$objPHPExcel->getActiveSheet()->setCellValue($az[(2+count($rpt3)*3+3)]."5", $anteayer);
$objPHPExcel->getActiveSheet()->mergeCells($az[(2+count($rpt3)*3+3)]."5:".$az[(2+count($rpt3)*4+4-1)]."5");
	
$objPHPExcel->getActiveSheet()->getStyle("B5:".$az[($i-1)]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');
$objPHPExcel->getActiveSheet()->getStyle("A6:".$az[($i-1)]."6")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');

$valorinicial=6;
$cont=0;
$countrpt3=0;
$posicionaz=2;
foreach($rpt as $r){	
	$countrpt3++;
	if( $countrpt3==1 ){

		$cont++;
		$valorinicial++;		
		$objPHPExcel->getActiveSheet()->setCellValue("A".$valorinicial, $cont);
		$objPHPExcel->getActiveSheet()->setCellValue("B".$valorinicial, $r['dfilial']);
		$objPHPExcel->getActiveSheet()->setCellValue("C".$valorinicial, '=SUM(D'.$valorinicial.':'.$az[(2+count($rpt3)*1+1-1)].$valorinicial.")");
		
		$objPHPExcel->getActiveSheet()->setCellValue($az[(2+count($rpt3)*1+1)].$valorinicial, "=SUM(".$az[(2+count($rpt3)*1+1+1)].$valorinicial.":".$az[(2+count($rpt3)*2+2-1)].$valorinicial.")");
		$objPHPExcel->getActiveSheet()->setCellValue($az[(2+count($rpt3)*2+2)].$valorinicial, '=SUM('.$az[(2+count($rpt3)*2+2+1)].$valorinicial.":".$az[(2+count($rpt3)*3+3-1)].$valorinicial.")");
		$objPHPExcel->getActiveSheet()->setCellValue($az[(2+count($rpt3)*3+3)].$valorinicial, '=SUM('.$az[(2+count($rpt3)*3+3+1)].$valorinicial.":".$az[(2+count($rpt3)*4+4-1)].$valorinicial.")");
		for($i=1;$i<=count($rpt3);$i++){
			$objPHPExcel->getActiveSheet()->setCellValue( $az[(2+$i)].$valorinicial, '='.$az[(2+$i+count($rpt3)+1)].$valorinicial.'/'.($diaspromedio[2]-1) );
		}

	}

	$posicionaz=2+count($rpt3)+$countrpt3;
	
	$posicionaz++;
		if($r['c0']*1>0){
			$objPHPExcel->getActiveSheet()->getStyle($az[$posicionaz].$valorinicial)->applyFromArray($styleBold);
		}
	$objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $r['c0']); $posicionaz+=count($rpt3);
	
	$posicionaz++;
		if($r['c1']*1>0){
			$objPHPExcel->getActiveSheet()->getStyle($az[$posicionaz].$valorinicial)->applyFromArray($styleBold);
		}
	$objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $r['c1']); $posicionaz+=count($rpt3);
	
	$posicionaz++;
		if($r['c1']*1>0){
			$objPHPExcel->getActiveSheet()->getStyle($az[$posicionaz].$valorinicial)->applyFromArray($styleBold);
		}
	$objPHPExcel->getActiveSheet()->setCellValue($az[$posicionaz].$valorinicial, $r['c2']); $posicionaz++;

	if( $countrpt3==count($rpt3) ){
		$countrpt3=0;
	}
}

//$objPHPExcel->getActiveSheet()->getStyle("C6:"."C".$valorinicial)->applyFromArray($styleBold);
//$objPHPExcel->getActiveSheet()->getStyle($az[(2+count($rpt3)*1+1)]."6:".$az[(2+count($rpt3)*1+1)].$valorinicial)->applyFromArray($styleBold);
///negrita a los numeros
$objPHPExcel->getActiveSheet()->getStyle("C6:".$az[(2+count($rpt3)*2+2-1)].$valorinicial)->applyFromArray($styleBold);
$objPHPExcel->getActiveSheet()->getStyle($az[(2+count($rpt3)*2+2)]."6:".$az[(2+count($rpt3)*2+2)].$valorinicial)->applyFromArray($styleBold);
$objPHPExcel->getActiveSheet()->getStyle($az[(2+count($rpt3)*3+3)]."6:".$az[(2+count($rpt3)*3+3)].$valorinicial)->applyFromArray($styleBold);

$objPHPExcel->getActiveSheet()->getStyle('B5:'.$az[$cantidadaz]."5")->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('A6:'.$az[$cantidadaz].$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
$valorinicial++;

$cantidadaz=1;
	for($i=1;$i<=4;$i++){
		$cantidadaz++;
		$objPHPExcel->getActiveSheet()->setCellValue($az[$cantidadaz].$valorinicial, "=SUM(".$az[$cantidadaz]."7:".$az[$cantidadaz].($valorinicial-1).")");
		for($j=0;$j<count($rpt3);$j++){
			$cantidadaz++;
			$objPHPExcel->getActiveSheet()->setCellValue($az[$cantidadaz].$valorinicial, "=SUM(".$az[$cantidadaz]."7:".$az[$cantidadaz].($valorinicial-1).")");			
		}
	}
$objPHPExcel->getActiveSheet()->getStyle('C'.$valorinicial.":".$az[$cantidadaz].$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('C'.$valorinicial.":".$az[$cantidadaz].$valorinicial)->applyFromArray($styleBold);

////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Consolidado_Matricula');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Consolidado_Matricula_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
