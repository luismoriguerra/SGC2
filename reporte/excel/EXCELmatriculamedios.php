<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(20,5,46,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,10,10,10,10,10,10,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$cfilial=str_replace(",","','",$_GET['cfilial']);
$fechas=" DATE(g.finicio) between '".$_GET['fechini']."' and '".$_GET['fechfin']."'";
$fechas2=" DATE(g2.finicio) between '".$_GET['fechini']."' and '".$_GET['fechfin']."'";
$fechas3=" DATE(g3.finicio) between '".$_GET['fechini']."' and '".$_GET['fechfin']."'";
$cinstit=str_replace(",","','",$_GET['cinstit']);

$sql="	select f.dfilial,ia.dinstit,t.dtipcap,count(g.cfilial) cant,o2.cant2,o3.cant3
		from ingalum i
		inner join filialm f on (f.cfilial=i.cfilial)
		inner join instita ia on (ia.cinstit=i.cinstit)
		inner join tipcapa t on (t.ctipcap=i.ctipcap)
		inner join conmatp c on (c.cingalu=i.cingalu)
		inner join gracprp g on (g.cgracpr=c.cgruaca)
		inner join 
		(	select i2.cfilial,count(i2.cfilial) cant2 
			FROM ingalum i2
			INNER JOIN conmatp c2 on (i2.cingalu=c2.cingalu)
			INNER JOIN gracprp g2 on (g2.cgracpr=c2.cgruaca)
			WHERE ".$fechas2."
			AND g2.cciclo='01'			
			AND i2.cinstit in ('".$cinstit."')
			GROUP BY i2.cfilial
		) o2 on (o2.cfilial=i.cfilial)
		inner join 
		(	select i3.cfilial,i3.ctipcap,count(i3.cfilial) cant3 
			FROM ingalum i3
			INNER JOIN conmatp c3 on (i3.cingalu=c3.cingalu)
			INNER JOIN gracprp g3 on (g3.cgracpr=c3.cgruaca)
			WHERE ".$fechas3."
			AND g3.cciclo='01'
			AND i3.cinstit in ('".$cinstit."')
			GROUP BY i3.cfilial,i3.ctipcap
		) o3 on (o3.cfilial=i.cfilial AND o3.ctipcap=i.ctipcap)
		where ".$fechas."
		AND i.cfilial in ('".$cfilial."')
		AND i.cinstit in ('".$cinstit."')
		and g.cciclo='01'
		GROUP BY i.cfilial,i.cinstit,i.ctipcap
		ORDER BY o2.cant2 desc,f.dfilial ,o3.cant3 desc ,t.dtipcap";
$cn->setQuery($sql);
$rpt=$cn->loadObjectList();


$sql2="Select concat(dnomper,' ',dappape,' ',dapmape) as nombre
		FROM personm
		WHERE dlogper='".$_GET['usuario']."'";
$cn->setQuery($sql2);
$rpt2=$cn->loadObjectList();


$sqlinstit="Select group_concat(dinstit separator ',') as dinstit
			FROM instita
			WHERE cinstit in ('".$cinstit."')";
$cn->setQuery($sqlinstit);
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

//$objPHPExcel->getActiveSheet()->setCellValue("A1",$sql);
$objPHPExcel->getActiveSheet()->setCellValue("A2","MATRICULADOS POR MEDIOS");
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleAlignmentBold);

$cabecera=array('ODE','N°','MEDIO DE CAPTACIÓN',$rpt3[0]['dinstit']);


	for($i=0;$i<count($cabecera);$i++){
		$dc=explode(",",$cabecera[$i]);
		if(count($dc)>1){
			for($j=0;$j<count($dc);$j++){
			$objPHPExcel->getActiveSheet()->setCellValue($az[($i+$j)]."6",$dc[$j]);	
			$objPHPExcel->getActiveSheet()->getStyle($az[($i+$j)]."6")->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension($az[($i+$j)])->setWidth(6.25);
			}
		}
		else{
			$j=1;
		$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."6",$cabecera[$i]);	
		$objPHPExcel->getActiveSheet()->getStyle($az[$i]."6")->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
		}
	}
$objPHPExcel->getActiveSheet()->setCellValue($az[($i+$j-1)]."6","TOTAL");	
$objPHPExcel->getActiveSheet()->getStyle($az[($i+$j)]."6")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getColumnDimension($az[($i+$j-1)])->setWidth(8);
	
$objPHPExcel->getActiveSheet()->setCellValue("B4","USUARIO:");
$objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("C4",$rpt2[0]['nombre']);

$objPHPExcel->getActiveSheet()->setCellValue("B5","FECHA IMPRESIÓN");
$objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("C5",date("Y-m-d"));

$objPHPExcel->getActiveSheet()->setCellValue("D4","FECHAS DE INICIO DE GRUPOS");
$objPHPExcel->getActiveSheet()->mergeCells('D4:I4');
$objPHPExcel->getActiveSheet()->getStyle('D4:I4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDDEBF7');
$objPHPExcel->getActiveSheet()->getStyle('D4:I4')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('D4:I4')->applyFromArray($styleThinBlackBorderAllborders);

$objPHPExcel->getActiveSheet()->setCellValue("D5","DEL");
$objPHPExcel->getActiveSheet()->getStyle('D5')->applyFromArray($styleAlignment);
$objPHPExcel->getActiveSheet()->getStyle('D5')->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->setCellValue("E5",$_GET['fechini']);
$objPHPExcel->getActiveSheet()->setCellValue("G5","AL");
$objPHPExcel->getActiveSheet()->getStyle('G5')->applyFromArray($styleAlignment);
$objPHPExcel->getActiveSheet()->getStyle('G5')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->setCellValue("H5",$_GET['fechfin']);


	
$objPHPExcel->getActiveSheet()->getStyle("A6:".$az[($i+$j-1)]."6")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');
$objPHPExcel->getActiveSheet()->getStyle("A6:".$az[($i+$j-1)]."6")->applyFromArray($styleAlignmentBold);

	

$valorinicial=6;
$cont=0;
$total=0;
$pago="";
$fil="";
$tipcap="";
$dins=explode(",",$rpt3[0]['dinstit']);
if(count($rpt)>0){
	foreach($rpt as $r){
	
		if($fil!=$r['dfilial']){
			if($fil!=''){
			$valorinicial++;
			$objPHPExcel->getActiveSheet()->setCellValue($az[2].$valorinicial,"TOTAL");		
				for($j=0;$j<count($dins);$j++){
				$objPHPExcel->getActiveSheet()->setCellValue($az[($j+3)].$valorinicial,"=SUM(".$az[($j+3)].($valorinicial-$cont).":".$az[($j+3)].($valorinicial-1).")");			
				}
				$objPHPExcel->getActiveSheet()->mergeCells($az[0].($valorinicial-$cont).":".$az[0].($valorinicial-1));
				$objPHPExcel->getActiveSheet()->getStyle($az[0].($valorinicial-$cont).":".$az[0].($valorinicial-1))->applyFromArray($styleAlignmentBold);
				
				$objPHPExcel->getActiveSheet()->setCellValue($az[($j+3)].$valorinicial,"=SUM(".$az[($j+3)].($valorinicial-$cont).":".$az[($j+3)].($valorinicial-1).")");
				$objPHPExcel->getActiveSheet()->getStyle($az[2].$valorinicial.":".$az[($j+3)].$valorinicial)->applyFromArray($styleAlignmentRight);
			$objPHPExcel->getActiveSheet()->getStyle($az[0].$valorinicial.":".$az[($j+3)].$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDBDBDB');
			}
		$valorinicial++;		
		$paz=0;
		$cont=0;
		$cont++;
		$fil=$r['dfilial'];
		$tipcap=$r['dtipcap'];	
		
		$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dfilial']);$paz++;
		$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $cont);$paz++;
		$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dtipcap']);$paz++;
		$posicion=explode($r['dinstit'],$rpt3[0]['dinstit']);
		$dp=explode(',',$posicion[0]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[count($dp)+2].$valorinicial, $r['cant']);$paz++;
		$objPHPExcel->getActiveSheet()->setCellValue($az[($i+$j-1)].$valorinicial,"=SUM(D".$valorinicial.":".$az[($i+$j-2)].$valorinicial.")");$paz++;	
		}
		else{	
			$posicion=explode($r['dinstit'],$rpt3[0]['dinstit']);
			$dp=explode(',',$posicion[0]);
			
			if($tipcap!=$r['dtipcap']){
			$tipcap=$r['dtipcap'];
			$cont++;
			$paz=0;	
			$valorinicial++;
			$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dfilial']);$paz++;
			$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $cont);$paz++;
			$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dtipcap']);$paz++;
			$objPHPExcel->getActiveSheet()->setCellValue($az[count($dp)+2].$valorinicial, $r['cant']);$paz++;
			$objPHPExcel->getActiveSheet()->setCellValue($az[($i+$j-1)].$valorinicial,"=SUM(D".$valorinicial.":".$az[($i+$j-2)].$valorinicial.")");$paz++;	
			}
			else{
			$objPHPExcel->getActiveSheet()->setCellValue($az[count($dp)+2].$valorinicial, $r['cant']);$paz++;
			}
		}
	}
			$valorinicial++;	
			$objPHPExcel->getActiveSheet()->setCellValue($az[2].$valorinicial,"TOTAL");
			$objPHPExcel->getActiveSheet()->mergeCells($az[0].($valorinicial-$cont).":".$az[0].($valorinicial-1));
			$objPHPExcel->getActiveSheet()->getStyle($az[0].($valorinicial-$cont).":".$az[0].($valorinicial-1))->applyFromArray($styleAlignmentBold);
			for($j=0;$j<count($dins);$j++){
			$objPHPExcel->getActiveSheet()->setCellValue($az[($j+3)].$valorinicial,"=SUM(".$az[($j+3)].($valorinicial-$cont).":".$az[($j+3)].($valorinicial-1).")");
			}
			$objPHPExcel->getActiveSheet()->setCellValue($az[($j+3)].$valorinicial,"=SUM(".$az[($j+3)].($valorinicial-$cont).":".$az[($j+3)].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->getStyle($az[2].$valorinicial.":".$az[($j+3)].$valorinicial)->applyFromArray($styleAlignmentRight);
			$objPHPExcel->getActiveSheet()->getStyle($az[0].$valorinicial.":".$az[($j+3)].$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDBDBDB');
}
		
$objPHPExcel->getActiveSheet()->getStyle('A6:'.$az[($i+$j-1)].$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
//$objPHPExcel->getActiveSheet()->getStyle('AA4:AA'.$valorinicial)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Matricula_Medios');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Matricula_Medios_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>