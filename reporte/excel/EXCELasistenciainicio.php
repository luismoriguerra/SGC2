<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';
/*crea obj conexion*/

$cn=MySqlConexion::getInstance();
$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(20,5,46,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,8.5,10,10,10,10,10,10,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$cfilial=str_replace(",","','",$_GET['cfilial']);
$fechas =" DATE(gr.finicio) between '".$_GET['fechini']."' and '".$_GET['fechfin']."'"; 
$fechas2 =" DATE(g2.finicio) between '".$_GET['fechini']."' and '".$_GET['fechfin']."'"; 
$cinstit=str_replace(",","','",$_GET['cinstit']);

$sql="	SELECT 
			 fil.dfilial 					as filial
			,ins.dinstit					as instituto
			,car.dcarrer					as carrera
			,(SELECT GROUP_CONCAT(d.dnemdia SEPARATOR '-') From diasm d Where FIND_IN_SET (d.cdia,replace(gr.cfrecue,'-',','))  >  0)	as frecuencia
			,CONCAT(hor.hinici , ' - ' , hor.hfin) 	as hora
			,gr.csemaca						as semestre
			,gr.cinicio						as inicio
			,gr.finicio						as fec_ini
			,count(distinct(con.cingalu)) cant_insc
			,count(distinct(con.cingalu)) - sum(if(r.ccuota='',1,0)) tmat
			,sum(if(r.ccuota='1' and r.testfin='P',0,1)) - sum(if(r.ccuota='',1,0)) pag_cuo
			,( count(distinct(con.cingalu)) - sum(if(r.ccuota='',1,0)) ) - ( sum(if(r.ccuota='1' and r.testfin='P',0,1)) - sum(if(r.ccuota='',1,0)) )  pag_mat
			,sum(if(r.ccuota='1' and r.testfin='P',0,1)) penaux,sum(if(r.ccuota='',1,0)) mataux
			,(SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu) tt
			,ifnull((SELECT count(DISTINCT(s.cingalu)) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=gr.cgracpr),0) 	as cant_asist
			,(SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=gr.cgracpr
				AND a.fecha=gr.finicio) t1_1
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 0,1),0)				as asis_01
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 1,1),0)				as asis_02
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 2,1),0)				as asis_03
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 3,1),0)				as asis_04
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 4,1),0)				as asis_05
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 5,1),0)				as asis_06
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 6,1),0)				as asis_07
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 7,1),0)				as asis_08
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 8,1),0)				as asis_09
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 9,1),0)				as asis_10
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 10,1),0) 				as asis_11
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 11,1),0) 				as asis_12
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 12,1),0) 				as asis_13
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 13,1),0) 				as asis_14
			,ifnull((SELECT count(s.cingalu) ta
				FROM aluasist a
				INNER JOIN seinggr s ON (s.id=a.idseing)
				WHERE s.cgrupo=con.cgruaca AND s.cingalu=con.cingalu
				GROUP BY s.cgrupo,a.fecha
				limit 14,1) ,0)				as asis_15
		From gracprp	gr
		INNER JOIN  filialm fil On gr.cfilial = fil.cfilial
		INNER JOIN  instita ins On gr.cinstit = ins.cinstit
		INNER JOIN  carrerm car On gr.ccarrer = car.ccarrer
		INNER JOIN  horam hor On gr.chora = hor.chora
		INNER JOIN conmatp con ON con.cgruaca=gr.cgracpr
		INNER JOIN ingalum i ON i.cingalu=con.cingalu AND i.cestado=1
		LEFT JOIN recacap r ON r.cingalu=con.cingalu AND r.cgruaca=con.cgruaca AND ccuota IN ('1','')
							AND r.cconcep IN (SELECT cconcep From concepp Where cctaing like '701.01%' or cctaing like '701.03%')
							AND r.testfin='P'
		WHERE gr.cfilial IN ('".$cfilial."')
		AND gr.cinstit IN ('".$cinstit."')
		AND ".$fechas."
		AND gr.cesgrpr='3'
		GROUP BY gr.cgracpr
		ORDER BY filial, instituto";
$cn->setQuery($sql);
$rpt=$cn->loadObjectList();


$sql2="SELECT concat(dnomper,' ',dappape,' ',dapmape) as nombre
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

$styleBold= array(
    'font'    => array(
        'bold'      => true
    )
);

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
$styleThickBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
$styleThickBlackBorderAllborders = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
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

//$objPHPExcel->getActiveSheet()->setCellValue("A2",$sql);
$objPHPExcel->getActiveSheet()->setCellValue("A1","ASISTENCIAS POR INICIO");
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells('A1:AC1');
$objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->applyFromArray($styleAlignmentBold);


$objPHPExcel->getActiveSheet()->setCellValue("B3","FECHA DE IMPRESIÓN");	
$objPHPExcel->getActiveSheet()->getStyle("B3")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($styleBold);
$objPHPExcel->getActiveSheet()->setCellValue("C3",date("Y-m-d"));	
$objPHPExcel->getActiveSheet()->getStyle("C3")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($styleBold);

$objPHPExcel->getActiveSheet()->setCellValue("E3","PROGRAMADOS DEL:");	
$objPHPExcel->getActiveSheet()->getStyle("E3")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleBold);
$objPHPExcel->getActiveSheet()->setCellValue("F3",$_GET['fechini']);	
$objPHPExcel->getActiveSheet()->getStyle("F3")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($styleBold);

$objPHPExcel->getActiveSheet()->setCellValue("G3","AL:");	
$objPHPExcel->getActiveSheet()->getStyle("G3")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($styleBold);
$objPHPExcel->getActiveSheet()->setCellValue("H3",$_GET['fechfin']);
$objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
$objPHPExcel->getActiveSheet()->getStyle("H3")->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($styleBold);

$objPHPExcel->getActiveSheet()->setCellValue("J3","REPORTE");	
$objPHPExcel->getActiveSheet()->mergeCells('J3:L3');
$objPHPExcel->getActiveSheet()->getStyle('J3:L3')->applyFromArray($styleThickBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('J3:L3')->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->setCellValue("M3","PAGANTES");	
$objPHPExcel->getActiveSheet()->mergeCells('M3:N3');
$objPHPExcel->getActiveSheet()->getStyle('M3:N3')->applyFromArray($styleThickBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('M3:N3')->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->setCellValue("O3","ASISTENCIA");	
$objPHPExcel->getActiveSheet()->mergeCells('O3:AC3');
$objPHPExcel->getActiveSheet()->getStyle('O3:AC3')->applyFromArray($styleThickBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('O3:AC3')->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->getRowDimension("4")->setRowHeight(50); // altura



$cabecera=array('N°','ODE','INSTITUCIÓN','CARRERA','FREC','HORA','CICLO ACADEMICO','INI','FECHA OFICIAL INICIO','INSCRITO','ASISTENCIA','NO ASISTENCIA','MAT.','CUOTA','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15');
$tamanos=array(3, 22, 12, 25, 12, 12, 9, 2.3, 11, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5, 3.5);


	for($i=0;$i<count($cabecera);$i++){
		$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."4",$cabecera[$i]);	
		$objPHPExcel->getActiveSheet()->getStyle($az[$i]."4")->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($tamanos[$i]);

		if($i>=9 And $i<=13){
			$objPHPExcel->getActiveSheet()->getStyle($az[$i]."4")->getAlignment()->setTextRotation(90);
		}
		$objPHPExcel->getActiveSheet()->getStyle($az[$i]."4")->applyFromArray($styleThickBlackBorderAllborders);
		$objPHPExcel->getActiveSheet()->getStyle($az[$i]."4")->applyFromArray($styleAlignmentBold);
	}

	
$valorinicial=5;
$cont=0;
$total=0;
$pago="";
$fil="";
$instit="";

if(count($rpt)>0){
	foreach($rpt as $r){

		if(($fil != $r["filial"] And $fil != "") And ($instit != $r["instituto"] And $instit != "")){
			$objPHPExcel->getActiveSheet()->setCellValue($az[8].$valorinicial,"TOTALES");	
			$objPHPExcel->getActiveSheet()->setCellValue($az[9].$valorinicial,"=SUM(".$az[9].($valorinicial-$cont).":".$az[9].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[10].$valorinicial,"=SUM(".$az[10].($valorinicial-$cont).":".$az[10].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[11].$valorinicial,"=SUM(".$az[11].($valorinicial-$cont).":".$az[11].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[12].$valorinicial,"=SUM(".$az[12].($valorinicial-$cont).":".$az[12].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[13].$valorinicial,"=SUM(".$az[13].($valorinicial-$cont).":".$az[13].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[14].$valorinicial,"=SUM(".$az[14].($valorinicial-$cont).":".$az[14].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[15].$valorinicial,"=SUM(".$az[15].($valorinicial-$cont).":".$az[15].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[16].$valorinicial,"=SUM(".$az[16].($valorinicial-$cont).":".$az[16].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[17].$valorinicial,"=SUM(".$az[17].($valorinicial-$cont).":".$az[17].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[18].$valorinicial,"=SUM(".$az[18].($valorinicial-$cont).":".$az[18].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[19].$valorinicial,"=SUM(".$az[19].($valorinicial-$cont).":".$az[19].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[20].$valorinicial,"=SUM(".$az[20].($valorinicial-$cont).":".$az[20].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[21].$valorinicial,"=SUM(".$az[21].($valorinicial-$cont).":".$az[21].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[22].$valorinicial,"=SUM(".$az[22].($valorinicial-$cont).":".$az[22].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[23].$valorinicial,"=SUM(".$az[23].($valorinicial-$cont).":".$az[23].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[24].$valorinicial,"=SUM(".$az[24].($valorinicial-$cont).":".$az[24].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[25].$valorinicial,"=SUM(".$az[25].($valorinicial-$cont).":".$az[25].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[26].$valorinicial,"=SUM(".$az[26].($valorinicial-$cont).":".$az[26].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[27].$valorinicial,"=SUM(".$az[27].($valorinicial-$cont).":".$az[27].($valorinicial-1).")");
			$objPHPExcel->getActiveSheet()->setCellValue($az[28].$valorinicial,"=SUM(".$az[28].($valorinicial-$cont).":".$az[28].($valorinicial-1).")");

			$objPHPExcel->getActiveSheet()->getStyle($az[0].$valorinicial.":".$az[28].$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDBDBDB');

			$cont = 0;
			$valorinicial++;
		} /*IF PARA VALIDAR CAMBIO*/


		$cont++;

		$objPHPExcel->getActiveSheet()->setCellValue($az[0].$valorinicial,$cont);
		$objPHPExcel->getActiveSheet()->setCellValue($az[1].$valorinicial,$r["filial"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[2].$valorinicial,$r["instituto"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[3].$valorinicial,$r["carrera"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[4].$valorinicial,$r["frecuencia"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[5].$valorinicial,$r["hora"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[6].$valorinicial,$r["semestre"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[7].$valorinicial,$r["inicio"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[8].$valorinicial,$r["fec_ini"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[9].$valorinicial,$r["cant_insc"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[10].$valorinicial,$r["cant_asist"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[11].$valorinicial,"=(".$az[9].$valorinicial." - ".$az[10].$valorinicial.")");
		$mat=$r["pag_mat"];
		/*if($mat<0){
			$mat=0;
		}*/

		$objPHPExcel->getActiveSheet()->setCellValue($az[12].$valorinicial,$mat);
		$objPHPExcel->getActiveSheet()->setCellValue($az[13].$valorinicial,$r["pag_cuo"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[14].$valorinicial,$r["asis_01"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[15].$valorinicial,$r["asis_02"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[16].$valorinicial,$r["asis_03"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[17].$valorinicial,$r["asis_04"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[18].$valorinicial,$r["asis_05"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[19].$valorinicial,$r["asis_06"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[20].$valorinicial,$r["asis_07"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[21].$valorinicial,$r["asis_08"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[22].$valorinicial,$r["asis_09"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[23].$valorinicial,$r["asis_10"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[24].$valorinicial,$r["asis_11"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[25].$valorinicial,$r["asis_12"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[26].$valorinicial,$r["asis_13"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[27].$valorinicial,$r["asis_14"]);
		$objPHPExcel->getActiveSheet()->setCellValue($az[28].$valorinicial,$r["asis_15"]);

		$valorinicial++;

	}/*FOREACH*/


	$objPHPExcel->getActiveSheet()->setCellValue($az[8].$valorinicial,"TOTALES");	
	$objPHPExcel->getActiveSheet()->setCellValue($az[9].$valorinicial,"=SUM(".$az[9].($valorinicial-$cont).":".$az[9].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[10].$valorinicial,"=SUM(".$az[10].($valorinicial-$cont).":".$az[10].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[11].$valorinicial,"=SUM(".$az[11].($valorinicial-$cont).":".$az[11].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[12].$valorinicial,"=SUM(".$az[12].($valorinicial-$cont).":".$az[12].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[13].$valorinicial,"=SUM(".$az[13].($valorinicial-$cont).":".$az[13].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[14].$valorinicial,"=SUM(".$az[14].($valorinicial-$cont).":".$az[14].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[15].$valorinicial,"=SUM(".$az[15].($valorinicial-$cont).":".$az[15].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[16].$valorinicial,"=SUM(".$az[16].($valorinicial-$cont).":".$az[16].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[17].$valorinicial,"=SUM(".$az[17].($valorinicial-$cont).":".$az[17].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[18].$valorinicial,"=SUM(".$az[18].($valorinicial-$cont).":".$az[18].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[19].$valorinicial,"=SUM(".$az[19].($valorinicial-$cont).":".$az[19].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[20].$valorinicial,"=SUM(".$az[20].($valorinicial-$cont).":".$az[20].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[21].$valorinicial,"=SUM(".$az[21].($valorinicial-$cont).":".$az[21].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[22].$valorinicial,"=SUM(".$az[22].($valorinicial-$cont).":".$az[22].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[23].$valorinicial,"=SUM(".$az[23].($valorinicial-$cont).":".$az[23].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[24].$valorinicial,"=SUM(".$az[24].($valorinicial-$cont).":".$az[24].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[25].$valorinicial,"=SUM(".$az[25].($valorinicial-$cont).":".$az[25].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[26].$valorinicial,"=SUM(".$az[26].($valorinicial-$cont).":".$az[26].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[27].$valorinicial,"=SUM(".$az[27].($valorinicial-$cont).":".$az[27].($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue($az[28].$valorinicial,"=SUM(".$az[28].($valorinicial-$cont).":".$az[28].($valorinicial-1).")");

	$objPHPExcel->getActiveSheet()->getStyle($az[0].$valorinicial.":".$az[28].$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDBDBDB');
}/*VALIDACION SI EXISTE DATOS*/

$objPHPExcel->getActiveSheet()->getStyle('A5:'.$az[28].$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('A4:'."I".$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('J3:'."L".$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('M3:'."N".$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('O3:'."AC".$valorinicial)->applyFromArray($styleThickBlackBorderOutline);
//$objPHPExcel->getActiveSheet()->getStyle('AA4:AA'.$valorinicial)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Asistencia_Inicios');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Asistencia_Inicios_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
