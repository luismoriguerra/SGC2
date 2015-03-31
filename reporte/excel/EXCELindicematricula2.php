<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(5,20,12.5,50,6,6,6,6,18,12,12,4,11,4,4,4,4,4,11,11,11,6,11,10,10,10,10,10,10,10,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$cfilial=str_replace(",","','",$_GET['cfilial']);
$fechas=" DATE(g.finicio) between '".$_GET['fechini']."' and '".$_GET['fechfin']."'";
$fechas2=" DATE(g2.finicio) between '".$_GET['fechini']."' and '".$_GET['fechfin']."'";
$cinstit=str_replace(",","','",$_GET['cinstit']);

$sql="	SELECT
			 f.dfilial
			,ins.dinstit
			-- ,t.dturno
			,c.dcarrer
			,g.csemaca
			,g.cinicio
			,DATE_FORMAT(sem.finimat, '%d/%m/%Y') As inicamp
			,DATE_FORMAT(g.finicio, '%d/%m/%Y') As finicio
			,g.nmetmat
			,g.ffin
			,DateDiff(curdate(),sem.finimat) As ndiacamp
			,sum(ifnull(solo_ins.cant,0))	As	npagins
			,sum(ifnull(mat_ins.cant,0))	As	npginmt
			,IF(DateDiff(curdate(),g.finicio)-7>=0,0,(DateDiff(g.finicio,curdate())+7)) as dias_falta
			,DateDiff(CURDATE(),sem.finimat) As ndiaeje
			,	(Select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
				 From diasm d 
				 Where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0) as frec
			, concat(h.hinici,' - ',h.hfin) as hora,GROUP_CONCAT(distinct(g.cgracpr)) as id
			,(Select count(*)
			  From gracprp g2
				Inner join conmatp co on (co.cgruaca=g2.cgracpr)
			  Where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
			  ) as total
			,(Select count(*)
			  From gracprp g2
				Inner join conmatp co on (co.cgruaca=g2.cgracpr)
				Inner join ingalum ing2 on (ing2.cingalu=co.cingalu)
			  Where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
			  AND ing2.cestado=0
			  ) as retirado
			,o.total2			 		 
			,cu.dtitulo as dcurric
			,nmetmat
			,(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					inner join (select r2.cingalu,r2.cgruaca
											from recacap r2	
											inner join gracprp gr2 on (gr2.cgracpr=r2.cgruaca)
											inner join concepp co2 on (co2.cconcep=r2.cconcep)
											inner join conmatp conm2 on (conm2.cingalu=r2.cingalu and conm2.cgruaca=r2.cgruaca)
											where (r2.ccuota='' or r2.ccuota=1)
											and r2.testfin='P'
											and co2.cctaing like '701.03%'
											AND gr2.cinstit in ('".$cinstit."')
											AND gr2.cfilial in ('".$cfilial."')
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
											inner join gracprp gr2 on (gr2.cgracpr=r2.cgruaca)
											inner join concepp co2 on (co2.cconcep=r2.cconcep)
											inner join conmatp conm2 on (conm2.cingalu=r2.cingalu and conm2.cgruaca=r2.cgruaca)
											where (r2.ccuota='' or r2.ccuota=1)
											and r2.testfin='P'
											and co2.cctaing like '701.03%'
											AND gr2.cinstit in ('".$cinstit."')
											AND gr2.cfilial in ('".$cfilial."')
											and (IF(substring(conm2.dproeco,1,3)='Pro',(co2.mtoprom/2),co2.nprecio/2))<r2.nmonrec
											GROUP BY r2.cgruaca,r2.cingalu
											) rec on (rec.cingalu=co.cingalu and rec.cgruaca=co.cgruaca)
					WHERE (FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(g.cgracpr SEPARATOR ','))  >  0)					
					) as menor,
					(Select count(*)
						From gracprp g2
						Inner join conmatp co on (co.cgruaca=g2.cgracpr)
						Where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
						AND date(co.fmatric)=CURDATE()
					) as f5,
					(Select count(*)
						From gracprp g2
						Inner join conmatp co on (co.cgruaca=g2.cgracpr)
						Where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
						AND date(co.fmatric)=(CURDATE()-interval 1 day)
					) as f4,
					(Select count(*)
						From gracprp g2
						Inner join conmatp co on (co.cgruaca=g2.cgracpr)
						Where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
						AND date(co.fmatric)=(CURDATE()-interval 2 day)
					) as f3,
					(Select count(*)
						From gracprp g2
						Inner join conmatp co on (co.cgruaca=g2.cgracpr)
						Where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
						AND date(co.fmatric)=(CURDATE()-interval 3 day)
					) as f2,
					(Select count(*)
						From gracprp g2
						Inner join conmatp co on (co.cgruaca=g2.cgracpr)
						Where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
						AND date(co.fmatric)=(CURDATE()-interval 4 day)
					) as f1
		FROM gracprp g 
		INNER JOIN curricm cu on (cu.ccurric=g.ccurric)
		INNER JOIN filialm f on (f.cfilial=g.cfilial)
		INNER JOIN instita ins on (ins.cinstit=g.cinstit)
		INNER JOIN turnoa t on (g.cturno=t.cturno) 
		INNER JOIN horam h on (h.chora=g.chora) 
		INNER JOIN carrerm c on (c.ccarrer=g.ccarrer) 
		INNER JOIN semacan sem On (sem.csemaca = g.csemaca And sem.cfilial = g.cfilial And sem.cinstit = g.cinstit AND sem.cinicio=g.cinicio AND sem.cmodali=g.cmodali)
		INNER JOIN 
			(Select g2.cfilial,count(*) as total2
			  From gracprp g2
			  Inner join conmatp co2 on (co2.cgruaca=g2.cgracpr)
			  Where ".$fechas2."
				AND g2.cinstit in ('".$cinstit."')
				AND g2.cfilial in ('".$cfilial."')
				AND g2.cesgrpr in ('3','4')
				GROUP BY g2.cfilial
			) as o on (o.cfilial=g.cfilial)
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
							From recacap rec2
							inner join gracprp gr2 on (gr2.cgracpr=rec2.cgruaca)
							where gr2.cfilial in ('".$cfilial."') and gr2.cinstit in ('".$cinstit."')
								AND  rec2.cconcep IN (	Select cconcep	From concepp	Where cctaing like '701.01%')
							  And rec2.cestpag = 'C'
							  And Concat(rec2.cgruaca,rec2.cingalu) NOT IN (Select Concat(cgruaca, cingalu)
																From recacap
																where cconcep IN (	Select cconcep	From concepp	Where cctaing like '701.01%')	
																and cgruaca=gr2.cgracpr
																And cestpag = 'P')
							  And Concat(rec2.cgruaca,rec2.cingalu) NOT IN (Select Concat(cgruaca, cingalu)
																From recacap
																where cconcep IN (	Select cconcep	From concepp	Where cctaing like '701.03%')
																and cgruaca=gr2.cgracpr
																And cestpag = 'C')
						) cont
					Group by cont.cgruaca
				) mat_ins
			ON mat_ins.cgruaca = g.cgracpr
		WHERE ".$fechas."
		AND g.cinstit in ('".$cinstit."')
		AND g.cfilial in ('".$cfilial."')
		AND g.cesgrpr in ('3','4')		
		GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio
		having max(g.trgrupo)='R' 
		order by o.total2 desc,f.dfilial,ins.dinstit,frec,hora,total desc";
$cn->setQuery($sql);
$rpt=$cn->loadObjectList();


$sql2="Select concat(dnomper,' ',dappape,' ',dapmape) as nombre
		FROM personm
		WHERE dlogper='".$_GET['usuario']."'";
$cn->setQuery($sql2);
$rpt2=$cn->loadObjectList();
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
$objPHPExcel->getActiveSheet()->setCellValue("A2","ÍNDICE DE MATRICULACIÓN PARA GERENCIA");
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells('A2:AA2');
$objPHPExcel->getActiveSheet()->getStyle('A2:AA2')->applyFromArray($styleAlignmentBold);

$cabecera=array('N°','ODE','INSTITUCION','CARRERA','TIPO','N°','CAP. MAX.','CAP. MIN','FREC','HORA','CICLO ACADEMICO','INI','FECHA OFICIAL INICIO','','','','','','TOT ACTIVO A LA FECHA '.date("Y-m-d"),'TOT RETIRO A LA FECHA '.date("Y-m-d"),'TOT MATRIC A LA FECHA '.date("Y-m-d"),'META','INICIO CAMPAÑA','DIAS CAMPAÑA','INDICE POR DIA','DIAS QUE FALTA','MATR. PROG. X DIAS FALT.','PROY. FINAL CAMP.','FALTA PARA LOGRAR LA META');


	for($i=0;$i<count($cabecera);$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."5",$cabecera[$i]);	
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."5")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}
$objPHPExcel->getActiveSheet()->getStyle('A5:'.$az[($i-1)].'5')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->mergeCells('N5:R5');
$objPHPExcel->getActiveSheet()->setCellValue("N5","MATRIC.EN LOS ULT CINCO DIAS");

$objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
$objPHPExcel->getActiveSheet()->setCellValue("B3","USUARIO:");
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("D3",$rpt2[0]['nombre']);

$objPHPExcel->getActiveSheet()->mergeCells('B4:C4');
$objPHPExcel->getActiveSheet()->setCellValue("B4","FECHA IMPRESIÓN");
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("D4",date("Y-m-d"));

$objPHPExcel->getActiveSheet()->setCellValue("I4","GRUPOS PROGRAMADOS DEL:");
$objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("J4",$_GET['fechini']);
$objPHPExcel->getActiveSheet()->setCellValue("K4","AL");
$objPHPExcel->getActiveSheet()->getStyle('K4')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("L4",$_GET['fechfin']);

/*$objPHPExcel->getActiveSheet()->getStyle("A5:".$az[($i-1)]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFA6D2F7');*/

/*$objPHPExcel->getActiveSheet()->setCellValue("A1",$sql);*/

/*$objPHPExcel->getActiveSheet()->setCellValue("A4","DATOS DE LOS GRUPOS QUE SE OFERTAN");
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
$objPHPExcel->getActiveSheet()->mergeCells('Z4:AA4');

	$objPHPExcel->getActiveSheet()->getStyle("A4:H4")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle("I4:M4")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle("N4:S4")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle("T4:V4")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle("W4:Y4")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle("Z4:AA4")->getAlignment()->setWrapText(true);*/
	
$objPHPExcel->getActiveSheet()->getStyle("A5:AC5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');
/*$objPHPExcel->getActiveSheet()->getStyle("I4:M5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFF2DCDB');
$objPHPExcel->getActiveSheet()->getStyle("N4:S5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFDE9D9');
$objPHPExcel->getActiveSheet()->getStyle("T4:V5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE4DFEC');
$objPHPExcel->getActiveSheet()->getStyle("W4:Y5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDAEEF3');
$objPHPExcel->getActiveSheet()->getStyle("Z4:AA5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');*/

	

$valorinicial=5;
$cont=0;
$total=0;
$pago="";
$fil="";
$cins="";
$frec="";
$hora="";
foreach($rpt as $r){	
	if($fil!=$r['dfilial'] or $cins!=$r['dinstit'] or $frec!=$r['frec'] or $hora!=$r['hora']){
		if($fil!=''){
		$valorinicial++;
		$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial,"TOTALES");
		$objPHPExcel->getActiveSheet()->getStyle('M'.$valorinicial.":"."AC".$valorinicial)->applyFromArray($styleAlignmentRight);
		$objPHPExcel->getActiveSheet()->getStyle("A".$valorinicial.":"."AC".$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD8E4BC');
	$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial,"=SUM(N".($valorinicial-$cont).":N".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("O".$valorinicial,"=SUM(O".($valorinicial-$cont).":O".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("P".$valorinicial,"=SUM(P".($valorinicial-$cont).":P".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("Q".$valorinicial,"=SUM(Q".($valorinicial-$cont).":Q".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("R".$valorinicial,"=SUM(R".($valorinicial-$cont).":R".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("S".$valorinicial,"=SUM(S".($valorinicial-$cont).":S".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("T".$valorinicial,"=SUM(T".($valorinicial-$cont).":T".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("U".$valorinicial,"=SUM(U".($valorinicial-$cont).":U".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("V".$valorinicial,"=SUM(V".($valorinicial-$cont).":V".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("Y".$valorinicial,"=SUM(Y".($valorinicial-$cont).":Y".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("AB".$valorinicial,"=SUM(AB".($valorinicial-$cont).":AB".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("AC".$valorinicial,"=SUM(AC".($valorinicial-$cont).":AC".($valorinicial-1).")");
		}
	$fil=$r['dfilial'];
	$cins=$r['dinstit'];
	$frec=$r['frec'];
	$hora=$r['hora'];
	$cont=0;
	}
$cont++;
$valorinicial++;
$paz=0;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $cont);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dfilial']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dinstit']);$paz++;
//$objPHPExcel->getActiveSheet()->setCellValue("D".$valorinicial, $r['dturno']);
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dcarrer']);$paz++;

$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, '');$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, '');$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, '');$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, '');$paz++;


$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['frec']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['hora']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['csemaca']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['cinicio']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['finicio']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['f1']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['f2']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['f3']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['f4']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['f5']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, ($r['total']-$r['retirado']));$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['retirado']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['total']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['nmetmat']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['inicamp']);$paz++;
if($r['ndiacamp']<0){
	$r['ndiacamp']=0;
}
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['ndiacamp']);$paz++;

/*$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['npagins']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['npginmt']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['menor']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['mayor']);$paz++;
*/
//$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['ndiacamp']);$paz++;
	if($r['ndiacamp'] < $r['ndiaeje'])	{	$dia_ejec = $r['ndiacamp'];	}
	else								{	$dia_ejec = $r['ndiaeje'];	}
//$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $dia_ejec);$paz++;
//$ind_xdia_act = round(($r['total']/$dia_ejec),2);
$ind_xdia_act = 0;
if($r['ndiacamp']>0){
$ind_xdia_act = round(($r['total']/$r['ndiacamp']),2);
}

$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $ind_xdia_act);$paz++;
//$dias_falt = $r['ndiacamp'] - $dia_ejec + 7;
$dias_falt=$r['dias_falta'];
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $dias_falt);$paz++;
//$mat_prog_xdia = round(($r['nmetmat']/$r['ndiacamp']),1);
$mat_prog_xdia=$ind_xdia_act*$dias_falt;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $mat_prog_xdia);$paz++;
//$proy_dia_fal = round($dias_falt * $ind_xdia_act,0);
//$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $proy_dia_fal);$paz++;
//$proy_fin_cam = $r['total'] + $proy_dia_fal;
$proy_fin_cam=$r['total']+$mat_prog_xdia;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$proy_fin_cam);$paz++;
//$mat_falt_meta = $r['nmetmat'] - $r['total'];
$mat_falt_meta = $r['nmetmat'] - $proy_fin_cam;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $mat_falt_meta);$paz++;


/*	if($dias_falt == '0')	{	$ind_xdia_falt = $mat_falt_meta;							}
	else					{	$ind_xdia_falt = round(($mat_falt_meta/$dias_falt),2);	}
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $ind_xdia_falt);$paz++;
$esf_adic = $ind_xdia_falt - $ind_xdia_act;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $esf_adic);$paz++;*/

/*$totalmatriculados=$r["total"]-($r['mayor']+$r["menor"]);
$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial,$totalmatriculados);
$vacantes=$r['nmetmat']-$totalmatriculados-($r["mayor"]/2);
$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial,$vacantes);
$indice=round(1-($vacantes/$r['nmetmat']),2);
$objPHPExcel->getActiveSheet()->setCellValue("O".$valorinicial,$indice);*/
}

$valorinicial++;
	$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial,"TOTALES");
	$objPHPExcel->getActiveSheet()->getStyle('M'.$valorinicial.":"."AC".$valorinicial)->applyFromArray($styleAlignmentRight);
	$objPHPExcel->getActiveSheet()->getStyle("A".$valorinicial.":"."AC".$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD8E4BC');
	$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial,"=SUM(N".($valorinicial-$cont).":N".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("O".$valorinicial,"=SUM(O".($valorinicial-$cont).":O".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("P".$valorinicial,"=SUM(P".($valorinicial-$cont).":P".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("Q".$valorinicial,"=SUM(Q".($valorinicial-$cont).":Q".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("R".$valorinicial,"=SUM(R".($valorinicial-$cont).":R".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("S".$valorinicial,"=SUM(S".($valorinicial-$cont).":S".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("T".$valorinicial,"=SUM(T".($valorinicial-$cont).":T".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("U".$valorinicial,"=SUM(U".($valorinicial-$cont).":U".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("V".$valorinicial,"=SUM(V".($valorinicial-$cont).":V".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("Y".$valorinicial,"=SUM(Y".($valorinicial-$cont).":Y".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("AB".$valorinicial,"=SUM(AB".($valorinicial-$cont).":AB".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("AC".$valorinicial,"=SUM(AC".($valorinicial-$cont).":AC".($valorinicial-1).")");

$objPHPExcel->getActiveSheet()->getStyle('A5:AC'.$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
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