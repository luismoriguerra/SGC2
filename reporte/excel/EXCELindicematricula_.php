<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(5,20,12.5,9.5,25,11,7,11,35,13,17,17,12,11,10,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$cfilial=str_replace(",","','",$_GET['cfilial']);
$csemaca=$_GET['csemaca'];
$cinstit=$_GET['cinstit'];

$sql="	SELECT  f.dfilial,ins.dinstit,t.dturno,c.dcarrer,g.csemaca,g.cinicio,g.finicio,g.ffin,concat( 
				(select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
				from diasm d 
				where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0), 
				' de ',h.hinici,' - ',h.hfin) as horario,GROUP_CONCAT(distinct(g.cgracpr)) as id,
					(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
					) as total,cu.dtitulo as dcurric,nmetmat,
					(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					inner join (select r2.cingalu,r2.cgruaca
											from recacap r2	
											inner join concepp co2 on (co2.cconcep=r2.cconcep)
											inner join conmatp conm2 on (conm2.cingalu=r2.cingalu and conm2.cgruaca=r2.cgruaca)
											where (r2.ccuota='' or r2.ccuota=1)
											and r2.testfin='P'
											and co2.cctaing like '701.03%'
											and (IF(substring(conm2.dproeco,1,3)='Pro',(co2.mtoprom/2),co2.nprecio/2))>=r2.nmonrec
											GROUP BY r2.cgruaca,r2.cingalu
											) rec on (rec.cingalu=co.cingalu and rec.cgruaca=co.cgruaca)
					WHERE (FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(g.cgracpr SEPARATOR ','))  >  0)					
					) as mayor,
					(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					inner join (select r2.cingalu,r2.cgruaca
											from recacap r2	
											inner join concepp co2 on (co2.cconcep=r2.cconcep)
											inner join conmatp conm2 on (conm2.cingalu=r2.cingalu and conm2.cgruaca=r2.cgruaca)
											where (r2.ccuota='' or r2.ccuota=1)
											and r2.testfin='P'
											and co2.cctaing like '701.03%'
											and (IF(substring(conm2.dproeco,1,3)='Pro',(co2.mtoprom/2),co2.nprecio/2))<r2.nmonrec
											GROUP BY r2.cgruaca,r2.cingalu
											) rec on (rec.cingalu=co.cingalu and rec.cgruaca=co.cgruaca)
					WHERE (FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(g.cgracpr SEPARATOR ','))  >  0)					
					) as menor
				FROM gracprp g 
				INNER JOIN curricm cu on (cu.ccurric=g.ccurric)
				INNER JOIN filialm f on (f.cfilial=g.cfilial)
				INNER JOIN instita ins on (ins.cinstit=g.cinstit)
				INNER JOIN turnoa t on (g.cturno=t.cturno) 
				INNER JOIN horam h on (h.chora=g.chora) 
				INNER JOIN carrerm c on (c.ccarrer=g.ccarrer) 
				WHERE g.csemaca='".$csemaca."'
				AND g.cinstit='".$cinstit."'
				AND g.cfilial in ('".$cfilial."')
				AND g.cesgrpr in ('3','4')
				GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio
				order by total desc,mayor desc,menor desc,c.dcarrer,g.cinicio,g.finicio";
$cn->setQuery($sql);
$rpt=$cn->loadObjectList();
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


$objPHPExcel->getActiveSheet()->setCellValue("A2","ÍNDICE DE MATRICULACIÓN");
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($styleAlignmentBold);

$cabecera=array('N°','ODE','INSTITUCION','TURNO','CARRERA','CICLO ACADEMICO','INICIO','FECHA INICIO','HORARIO','META A MATRICULAR','INSC. SIN POSIB DE MATRIC (PAG<50% PENS)','INSC. CON POSIB DE MATRIC (PAG>=50% PENS)','MATRICULA PAG=100%','VACANTES','INDICE DE MATRIC');

	for($i=0;$i<count($cabecera);$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."3",$cabecera[$i]);
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."3")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}
$objPHPExcel->getActiveSheet()->getStyle('A3:'.$az[($i-1)].'3')->applyFromArray($styleAlignmentBold);


$objPHPExcel->getActiveSheet()->getStyle("A3:".$az[($i-1)]."3")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFA6D2F7');

$valorinicial=3;
$cont=0;
$total=0;
$pago="";

foreach($rpt as $r){	
$cont++;
$valorinicial++;
$objPHPExcel->getActiveSheet()->setCellValue("A".$valorinicial,$cont);
$objPHPExcel->getActiveSheet()->setCellValue("B".$valorinicial,$r['dfilial']);
$objPHPExcel->getActiveSheet()->setCellValue("C".$valorinicial,$r['dinstit']);
$objPHPExcel->getActiveSheet()->setCellValue("D".$valorinicial,$r['dturno']);
$objPHPExcel->getActiveSheet()->setCellValue("E".$valorinicial,$r['dcarrer']);
$objPHPExcel->getActiveSheet()->setCellValue("F".$valorinicial,$r['csemaca']);
$objPHPExcel->getActiveSheet()->setCellValue("G".$valorinicial,$r['cinicio']);
$objPHPExcel->getActiveSheet()->setCellValue("H".$valorinicial,$r['finicio']);
$objPHPExcel->getActiveSheet()->setCellValue("I".$valorinicial,$r['horario']);
$objPHPExcel->getActiveSheet()->setCellValue("J".$valorinicial,$r['nmetmat']);
$objPHPExcel->getActiveSheet()->setCellValue("K".$valorinicial,$r['menor']);
$objPHPExcel->getActiveSheet()->setCellValue("L".$valorinicial,$r['mayor']);
$totalmatriculados=$r["total"]-($r['mayor']+$r["menor"]);
$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial,$totalmatriculados);
$vacantes=$r['nmetmat']-$totalmatriculados-($r["mayor"]/2);
$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial,$vacantes);
$indice=round(1-($vacantes/$r['nmetmat']),2);
$objPHPExcel->getActiveSheet()->setCellValue("O".$valorinicial,$indice);
}
$objPHPExcel->getActiveSheet()->getStyle('A3:O'.$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('O3:O'.$valorinicial)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Indice_Matricula');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Indice_Matricula_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>