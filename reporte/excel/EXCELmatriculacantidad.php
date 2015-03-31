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
$azcount=array( 8,15,10,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8
	,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8
	,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8
	,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8
	,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8
	,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8);

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

$cantidadinst=count($institlista);

$addtexto="";
$addquery="";
$listado="N°,FILIAL,CANT TOTAL";
$listadog=",,";
$conteo="1";
$fechinicial=$fechini;
while($fechinicial<=$fechfin){	
	foreach ($institlista as $r) {
		$listadog.=",".$fechinicial;
		$listado.=",".strtoupper($r['dinstit']);
		$conteo++;
		# code...
		$addtexto.=",IFNULL(t".$conteo.".cant,'') AS cant".$conteo;
		$addquery.=" LEFT JOIN 
					(
					SELECT  f.cfilial,COUNT(g.cfilial) AS cant 
					FROM ingalum i 
					INNER JOIN conmatp c 	ON (i.cingalu  	= c.cingalu) 
					INNER JOIN gracprp g 	ON (c.cgruaca  	= g.cgracpr) 
					INNER JOIN filialm f 	ON (f.cfilial = g.cfilial) 
					WHERE g.cfilial IN ('".$cfilial."')  
					AND g.`cinstit`='".$r['cinstit']."' 
					AND c.`fmatric`='".$fechinicial."' 
					AND i.cestado='1' 					
					GROUP BY g.cfilial					
					) t".$conteo." ON t.cfilial=t".$conteo.".cfilial ";
	}
	$listadog.=",".$fechinicial;
	$listado.=","."Total";
	$conteo++;
	# code...
	$addtexto.=",IFNULL(t".$conteo.".cant,'') AS cant".$conteo;
	$addquery.=" LEFT JOIN 
				(
				SELECT  f.cfilial,COUNT(g.cfilial) AS cant 
				FROM ingalum i 
				INNER JOIN conmatp c 	ON (i.cingalu  	= c.cingalu) 
				INNER JOIN gracprp g 	ON (c.cgruaca  	= g.cgracpr) 
				INNER JOIN filialm f 	ON (f.cfilial = g.cfilial) 
				WHERE g.cfilial IN ('".$cfilial."')  
				AND g.`cinstit` IN ('".$cinstit."') 
				AND c.`fmatric`='".$fechinicial."' 
				AND i.cestado='1' 					
				GROUP BY g.cfilial					
				) t".$conteo." ON t.cfilial=t".$conteo.".cfilial ";
$fechinicial=date("Y-m-d",strtotime("+1 day",strtotime(date($fechinicial))));
}


$sql="	SELECT t.dfilial,t.cant as total_cant ".$addtexto."
		FROM
		(
		SELECT  f.dfilial,f.cfilial,COUNT(g.cfilial) AS cant
		FROM ingalum i 
		INNER JOIN conmatp c 	ON (i.cingalu  	= c.cingalu)
		INNER JOIN gracprp g 	ON (c.cgruaca  	= g.cgracpr)
		INNER JOIN filialm f 	ON (f.cfilial = g.cfilial)
		WHERE g.cfilial IN ('".$cfilial."')  
		AND g.cinstit IN ('".$cinstit."')
		AND DATE(g.finicio) BETWEEN '".$fechini."' AND '".$fechfin."' 		
		AND i.cestado='1'
		GROUP BY g.cfilial			
		) t ".$addquery." 
		ORDER BY t.dfilial, t.cant 
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

$objPHPExcel->getActiveSheet()->setCellValue("A1","MATRICULA");
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
$cabecerag=explode(",",$listadog);
$validacabecerag='';
$addcolor=array();

	for($i=0;$i<count($cabecera);$i++){		
		if($cabecerag[$i]!=$validacabecerag and $cabecerag[$i]!=''){
		$validacabecerag=$cabecerag[$i];
		$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."5",$cabecerag[$i]);
		$objPHPExcel->getActiveSheet()->mergeCells($az[$i].'5:'.$az[($i+$cantidadinst)].'5');
		array_push($addcolor, $az[($i+$cantidadinst)]."6");
		}	
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."6",$cabecera[$i]);
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."6")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}
$objPHPExcel->getActiveSheet()->getStyle('D5:'.$az[($i)].'5')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('D5:'.$az[($i-1)].'5')->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('D5:'.$az[($i-1)].'5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8EA9DB');
$objPHPExcel->getActiveSheet()->getStyle('A6:'.$az[($i)].'6')->applyFromArray($styleAlignmentBold);


$pos=1;
$objPHPExcel->getActiveSheet()->getStyle($az[($pos-1)]."6:".$az[($pos+1+($conteo-1))]."6")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92D050');
for($j=0;$j<count($addcolor);$j++){
	$objPHPExcel->getActiveSheet()->getStyle($addcolor[$j])->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8EA9DB');	
}



$valorinicial=6;
$cont=0;

foreach($control As $r){
$cont++;
$valorinicial++;
$paz=0;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$cont);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dfilial']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['total_cant']);$paz++;
	for($i=2;$i<=$conteo;$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['cant'.$i]);$paz++;
	}

}
//$objPHPExcel->getActiveSheet()->getStyle("A7:".$az[($paz-1)].$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCECFF');
$objPHPExcel->getActiveSheet()->getStyle('A6:'.$az[($paz-1)].$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);

////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Matricula');
// Set active sheet index to the first sheet, so Excel opens this As the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Contador_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>