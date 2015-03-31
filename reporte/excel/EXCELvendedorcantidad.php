<?php
/*conexion*/
set_time_limit(3000);
ini_set('memory_limit','512M');
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array(  'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','AA','AB','AC','AD'
		  ,'AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH'
		  ,'BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL'
		  ,'CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP'
		  ,'DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ','EA','EB','EC','ED','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU');
$azcount=array( 8,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,25,15,28,30,15,15,15,15,15,20,15,15,15,15,15,15,15,15,19,40,20,20,20,20,20,20,20,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15);

$cusuari=$_GET['usuario'];
$alumno="";

$cfilial=str_replace(",","','",$_GET['cfilial']);
$cinstit=str_replace(",","','",$_GET['cinstit']);


$fechini=$_GET['fechini'];
$fechfin=$_GET['fechfin'];


$sqlinst="Select dinstit,cinstit
		  from instita 
		  where cinstit in ('".$cinstit."')";
$cn->setQuery($sqlinst);
$institlista=$cn->loadObjectList();

$addtexto="";
$addquery="";
$listado="N°,MEDIO CAPTACION,RESPONSABLE CAPTACION,CANT TOTAL";
$conteo="1";
foreach ($institlista as $r) {
	$listado.=",".strtoupper($r['dinstit']);
	$conteo++;
	# code...
	$addtexto.=",IFNULL(t".$conteo.".cant,'') AS cant".$conteo;
	$addquery.=" LEFT JOIN 
				(
				SELECT 	t.dtipcap AS dtipcap
					,CONCAT(v.dapepat,' ',v.dapemat,', ',v.dnombre) AS detalle_captacion
					,v.codintv AS codigo_vendedor ,COUNT(v.`cvended`) AS cant,v.`cvended`
					FROM personm p
					INNER JOIN ingalum i 	ON (i.cperson  	= p.cperson)
					INNER JOIN tipcapa t 	ON (i.ctipcap  	= t.ctipcap)		
					INNER JOIN conmatp c 	ON (i.cingalu  	= c.cingalu)
					INNER JOIN gracprp g 	ON (c.cgruaca  	= g.cgracpr)
					INNER JOIN vendedm v 	ON (v.cvended	= i.cpromot)
					WHERE g.cfilial IN ('".$cfilial."')  AND g.cinstit IN ('".$cinstit."')
					AND DATE(g.finicio) BETWEEN '".$fechini."' AND '".$fechfin."' 
					AND i.`cpromot`!=''
					AND g.`cinstit`='".$r['cinstit']."'
					GROUP BY i.`cpromot`
					
				) t".$conteo." ON t.cvended=t".$conteo.".cvended ";
}



$sql="	SELECT t.dtipcap,t.detalle_captacion,t.cant as total_cant ".$addtexto."
		FROM
		(
		SELECT 	t.dtipcap AS dtipcap
			,CONCAT(v.dapepat,' ',v.dapemat,', ',v.dnombre) AS detalle_captacion
			,v.codintv AS codigo_vendedor ,COUNT(v.`cvended`) AS cant,v.`cvended`
			FROM personm p
			INNER JOIN ingalum i 	ON (i.cperson  	= p.cperson)
			INNER JOIN tipcapa t 	ON (i.ctipcap  	= t.ctipcap)		
			INNER JOIN conmatp c 	ON (i.cingalu  	= c.cingalu)
			INNER JOIN gracprp g 	ON (c.cgruaca  	= g.cgracpr)
			INNER JOIN vendedm v 	ON (v.cvended	= i.cpromot)
			WHERE g.cfilial IN ('".$cfilial."')  AND g.cinstit IN ('".$cinstit."')
			AND DATE(g.finicio) BETWEEN '".$fechini."' AND '".$fechfin."' 
			AND i.`cpromot`!=''
			GROUP BY i.`cpromot`
			
		) t ".$addquery." 
		ORDER BY t.`dtipcap`, t.detalle_captacion, t.cant 
		";
$cn->setQuery($sql);
$control=$cn->loadObjectList();


/*echo count($control)."-";
echo $sql;*/


$sqlusu = "SELECT Concat(dnomper, ' ', dappape, ' ', dapmape) As nombre	 FROM personm WHERE dlogper='".$cusuari."'";
$cn->setQuery($sqlusu);
$nombre_usuario=$cn->loadObjectList();



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

$objPHPExcel->getActiveSheet()->setCellValue("A1","VENDEDOR DETALLE");
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleAlignmentBold);


$objPHPExcel->getActiveSheet()->setCellValue("A2","FECHA:");
$objPHPExcel->getActiveSheet()->setCellValue("C2",date ( "d / m / y" ));
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(15);
$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleAlignmentRight);

$objPHPExcel->getActiveSheet()->setCellValue("A3","USUARIO:");
$objPHPExcel->getActiveSheet()->setCellValue("C3",$nombre_usuario[0]['nombre']);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(15);
$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($styleAlignmentRight);

$cabecera=explode(",",$listado);

	for($i=0;$i<count($cabecera);$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."5",$cabecera[$i]);
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."5")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}
$objPHPExcel->getActiveSheet()->getStyle('A5:'.$az[($i)].'5')->applyFromArray($styleAlignmentBold);


$pos=1;
$objPHPExcel->getActiveSheet()->getStyle($az[($pos-1)]."5:".$az[($pos+2+($conteo-1))]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92D050');




$valorinicial=5;
$cont=0;

foreach($control As $r){
$cont++;
$valorinicial++;
$paz=0;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$cont);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dtipcap']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['detalle_captacion']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['total_cant']);$paz++;
	for($i=2;$i<=$conteo;$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['cant'.$i]);$paz++;
	}

}
$objPHPExcel->getActiveSheet()->getStyle("A6:".$az[($paz-1)].$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCECFF');
$objPHPExcel->getActiveSheet()->getStyle('A5:'.$az[($paz-1)].$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);

////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('vendedor');
// Set active sheet index to the first sheet, so Excel opens this As the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ControlPago_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>