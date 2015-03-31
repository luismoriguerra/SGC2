<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(5,20,12.5,9.5,30,11,7,35,17,17,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$cfilial=str_replace(",","','",$_GET['cfilial']);
$csemaca=$_GET['csemaca'];
$cinstit=$_GET['cinstit'];

$sql="	SELECT
			 f.dfilial
			,ins.dinstit
			,t.dturno
			,c.dcarrer
			,g.csemaca
			,g.cinicio
			,DATE_FORMAT(sem.finimat, '%Y-%m-%d') As inicamp
			,g.finicio
			,g.nmetmat
			,g.ffin
			,DateDiff(g.finicio,sem.finimat)+7 As ndiacamp
			,sum(ifnull(solo_ins.cant,0))	As	npagins
			,sum(ifnull(mat_ins.cant,0))	As	npginmt
			,DateDiff(CURDATE(),sem.finimat) As ndiaeje
			,concat( 
				(Select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
				 From diasm d 
				 Where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0), 
				 ' de ',h.hinici,' - ',h.hfin) as horario,GROUP_CONCAT(distinct(g.cgracpr)) as id
			,(Select count(*)
			  From gracprp g2
				Inner join conmatp co on (co.cgruaca=g2.cgracpr)
			  Where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
			  ) as total
			,cu.dtitulo as dcurric
			,nmetmat
			,(select count(*)
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
		INNER JOIN semacan sem On (sem.csemaca = g.csemaca And sem.cfilial = g.cfilial And sem.cinstit = g.cinstit AND sem.cinicio=g.cinicio AND sem.cmodali=g.cmodali)
		LEFT  JOIN (
					Select cont.cgruaca As cgruaca,count(cont.cingalu) As cant
					From (	Select distinct cgruaca, cingalu
							From recacap rec
							where cconcep IN (	Select cconcep	From concepp	Where cctaing like '701.01%')
							  And cestpag = 'P'
							) cont
					Group by cont.cgruaca
				) solo_ins
			ON solo_ins.cgruaca = g.cgracpr
		LEFT  JOIN (
					Select cont.cgruaca,count(cont.cingalu) As cant
					From (	Select cgruaca, cingalu
							From recacap
							where cconcep IN (	Select cconcep	From concepp	Where cctaing like '701.01%')
							  And cestpag = 'C'
							  And Concat(cgruaca,cingalu) NOT IN (Select Concat(cgruaca, cingalu)
																From recacap
																where cconcep IN (	Select cconcep	From concepp	Where cctaing like '701.01%')	
																And cestpag = 'P')
							  And Concat(cgruaca,cingalu) NOT IN (Select Concat(cgruaca, cingalu)
																From recacap
																where cconcep IN (	Select cconcep	From concepp	Where cctaing like '701.03%')
																And cestpag = 'C')
						) cont
					Group by cont.cgruaca
				) mat_ins
			ON mat_ins.cgruaca = g.cgracpr
		WHERE g.csemaca='".$csemaca."'
		AND g.cinstit='".$cinstit."'
		AND g.cfilial in ('".$cfilial."')
		AND g.cesgrpr in ('3','4')
		GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio 
		having max(g.trgrupo)='R' 
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
$objPHPExcel->getActiveSheet()->mergeCells('A2:AA2');
$objPHPExcel->getActiveSheet()->getStyle('A2:AA2')->applyFromArray($styleAlignmentBold);

$cabecera=array('N°','ODE','INSTITUCION','TURNO','CARRERA','CICLO ACADEMICO','INICIO','HORARIO','INICIO DE CAMPAÑA','FECHA INICIO DE CLASES','META','DIAS DE CAMPAÑA','MATRICULAS PROGRAMADAS POR DIA','CON SOLO PAGO DE INSCRIPCION','CON PAGO DE INSCRIPCIÓN MAS PAGO DE MATRICULA','CON PAGOS ANTERIORES MAS EL PAGO DE PENSION ( < AL 50% )','CON PAGOS ANTERIORES MAS EL PAGO DE PENSION ( > = AL 50% )','MATRICULADOS (PAGANTES Y NO PAGANTES)','MATRICULAS FALTANTES PARA LLEGAR A LA META','TOTAL DIAS','DIAS EJECUTADOS','DIAS FALTANTES','A LA FECHA','PARA LOS DIAS FALTANTES','DE ESFUERZO ADICIONAL','EN LOS DIAS FALTANTES ','AL FINAL DE LA CAMPAÑA','FALTA PARA LOGRAR LA META');

	for($i=0;$i<count($cabecera);$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."5",$cabecera[$i]);
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."5")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}
$objPHPExcel->getActiveSheet()->getStyle('A4:'.$az[($i-1)].'5')->applyFromArray($styleAlignmentBold);


/*$objPHPExcel->getActiveSheet()->getStyle("A5:".$az[($i-1)]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFA6D2F7');*/

/*$objPHPExcel->getActiveSheet()->setCellValue("A1",$sql);*/

$objPHPExcel->getActiveSheet()->setCellValue("A4","DATOS DE LOS GRUPOS QUE SE OFERTAN");
$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
$objPHPExcel->getActiveSheet()->setCellValue("I4","PROGRAMACION DE MARKETING");
$objPHPExcel->getActiveSheet()->mergeCells('I4:M4');
$objPHPExcel->getActiveSheet()->setCellValue("N4","RESULTADO DE MATRICULAS A LA FECHA");
$objPHPExcel->getActiveSheet()->mergeCells('N4:S4');
$objPHPExcel->getActiveSheet()->setCellValue("T4","CAMPAÑA (EN DIAS) ");
$objPHPExcel->getActiveSheet()->mergeCells('T4:V4');
$objPHPExcel->getActiveSheet()->setCellValue("W4","INDICE DE MATRICULA X DIA");
$objPHPExcel->getActiveSheet()->mergeCells('W4:Y4');
$objPHPExcel->getActiveSheet()->setCellValue("Z4","PROYECCION DE MATRICULAS A LOGRAR");
$objPHPExcel->getActiveSheet()->mergeCells('Z4:AB4');

	$objPHPExcel->getActiveSheet()->getStyle("A4:H4")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle("I4:M4")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle("N4:S4")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle("T4:V4")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle("W4:Y4")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle("Z4:AB4")->getAlignment()->setWrapText(true);
	
$objPHPExcel->getActiveSheet()->getStyle("A4:H5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');
$objPHPExcel->getActiveSheet()->getStyle("I4:M5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFF2DCDB');
$objPHPExcel->getActiveSheet()->getStyle("N4:S5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFDE9D9');
$objPHPExcel->getActiveSheet()->getStyle("T4:V5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE4DFEC');
$objPHPExcel->getActiveSheet()->getStyle("W4:Y5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDAEEF3');
$objPHPExcel->getActiveSheet()->getStyle("Z4:AB5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');

	

$valorinicial=5;
$cont=0;
$total=0;
$pago="";

foreach($rpt as $r){	
$cont++;
$valorinicial++;
$objPHPExcel->getActiveSheet()->setCellValue("A".$valorinicial, $cont);
$objPHPExcel->getActiveSheet()->setCellValue("B".$valorinicial, $r['dfilial']);
$objPHPExcel->getActiveSheet()->setCellValue("C".$valorinicial, $r['dinstit']);
$objPHPExcel->getActiveSheet()->setCellValue("D".$valorinicial, $r['dturno']);
$objPHPExcel->getActiveSheet()->setCellValue("E".$valorinicial, $r['dcarrer']);
$objPHPExcel->getActiveSheet()->setCellValue("F".$valorinicial, $r['csemaca']);
$objPHPExcel->getActiveSheet()->setCellValue("G".$valorinicial, $r['cinicio']);
$objPHPExcel->getActiveSheet()->setCellValue("H".$valorinicial, $r['horario']);
$objPHPExcel->getActiveSheet()->setCellValue("I".$valorinicial, $r['inicamp']);
$objPHPExcel->getActiveSheet()->setCellValue("J".$valorinicial, $r['finicio']);
$objPHPExcel->getActiveSheet()->setCellValue("K".$valorinicial, $r['nmetmat']);
$objPHPExcel->getActiveSheet()->setCellValue("L".$valorinicial, $r['ndiacamp']);
$mat_prog_xdia = round(($r['nmetmat']/$r['ndiacamp']),2);
$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial, $mat_prog_xdia);
$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial, $r['npagins']);
$objPHPExcel->getActiveSheet()->setCellValue("O".$valorinicial, $r['npginmt']);
$objPHPExcel->getActiveSheet()->setCellValue("P".$valorinicial, $r['menor']);
$objPHPExcel->getActiveSheet()->setCellValue("Q".$valorinicial, $r['mayor']);
$objPHPExcel->getActiveSheet()->setCellValue("R".$valorinicial, $r['total']);
$mat_falt_meta = $r['nmetmat'] - $r['total'];
$objPHPExcel->getActiveSheet()->setCellValue("S".$valorinicial, $mat_falt_meta);
$objPHPExcel->getActiveSheet()->setCellValue("T".$valorinicial, $r['ndiacamp']);
	if($r['ndiacamp'] < $r['ndiaeje'])	{	$dia_ejec = $r['ndiacamp'];	}
	else								{	$dia_ejec = $r['ndiaeje'];	}
$objPHPExcel->getActiveSheet()->setCellValue("U".$valorinicial, $dia_ejec);
$dias_falt = $r['ndiacamp'] - $dia_ejec;
$objPHPExcel->getActiveSheet()->setCellValue("V".$valorinicial, $dias_falt);
$ind_xdia_act = round(($r['total']/$dia_ejec),2);
$objPHPExcel->getActiveSheet()->setCellValue("W".$valorinicial, $ind_xdia_act);
	/*if($dias_falt == '0')	{	$ind_xdia_falt = $mat_falt_meta;							}
	else					{	$ind_xdia_falt = round(($mat_falt_meta/$dias_falt),2);	}*/
	$ind_xdia_falt=$dias_falt*$ind_xdia_act;
$objPHPExcel->getActiveSheet()->setCellValue("X".$valorinicial, $ind_xdia_falt);
$esf_adic = $ind_xdia_falt - $ind_xdia_act;
$objPHPExcel->getActiveSheet()->setCellValue("Y".$valorinicial, $esf_adic);
//$proy_dia_fal = round($dias_falt * $ind_xdia_act,0);
$proy_dia_fal=$ind_xdia_falt;
$objPHPExcel->getActiveSheet()->setCellValue("Z".$valorinicial, $proy_dia_fal);
$proy_fin_cam = $r['total'] + $proy_dia_fal;
$objPHPExcel->getActiveSheet()->setCellValue("AA".$valorinicial,$proy_fin_cam);
$falt_para_meta=$r['nmetmat']-$proy_fin_cam;
$objPHPExcel->getActiveSheet()->setCellValue("AB".$valorinicial,$proy_fin_cam);
/*$totalmatriculados=$r["total"]-($r['mayor']+$r["menor"]);
$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial,$totalmatriculados);
$vacantes=$r['nmetmat']-$totalmatriculados-($r["mayor"]/2);
$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial,$vacantes);
$indice=round(1-($vacantes/$r['nmetmat']),2);
$objPHPExcel->getActiveSheet()->setCellValue("O".$valorinicial,$indice);*/
}
$objPHPExcel->getActiveSheet()->getStyle('A4:AB'.$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
//$objPHPExcel->getActiveSheet()->getStyle('AA4:AA'.$valorinicial)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
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