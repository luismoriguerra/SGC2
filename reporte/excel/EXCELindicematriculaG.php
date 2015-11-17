<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(3.5,18,9,26,5.7,14,11.6,7,2.9,11,5.3,5.3,6.6,6,6,11,5.9,5.9,5.9,5.9,5.9,5.9,10,10,10,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$fechas=" '".$_GET['fechini']."' AND '".$_GET['fechfin']."'";
$cfilial=str_replace(",","','",$_GET['cfilial']);
$cinstit=str_replace(",","','",$_GET['cinstit']);


$sql="	SELECT f.dfilial,i.dinstit,c.dcarrer
		,(	SELECT GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
			FROM diasm d 
			WHERE FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0
		) AS frec
		,concat(h.hinici,' - ',h.hfin) AS hora
		,g.csemaca,g.cinicio,DATE_FORMAT(g.finicio, '%d/%m/%Y') AS finicio
		,COUNT(DISTINCT(ing.cingalu)) AS inscritos,g.nmetmat,g.nmetmin
		,COUNT(DISTINCT( IF(co.fmatric=(CURDATE()-interval 2 day) AND ing.cestado='1',ing.cingalu,NULL) )) AS d1
		,COUNT(DISTINCT( IF(co.fmatric=(CURDATE()-interval 1 day) AND ing.cestado='1' ,ing.cingalu,NULL) )) AS d2
		,DATE_FORMAT(s.finimat, '%d/%m/%Y') AS inicamp
		,DateDiff(curdate(),s.finimat) AS ndiacamp
		,IF(DateDiff(curdate(),g.finicio) >=0,0,(DateDiff(g.finicio,curdate()) )) AS dias_falta
		,MAX(CONCAT(cc.cestado,IF(cc.ccarrer='','000',cc.ccarrer),cc.fusuari,'|',cc.nprecio)) precio
		FROM gracprp g
		INNER JOIN cropaga cr ON (cr.cgruaca=g.cgracpr AND cr.ccuota='2' AND cr.cestado='1')
		INNER JOIN concepp cc ON (cc.cconcep=cr.cconcep AND (cc.ccarrer in ('',g.ccarrer)) )
		INNER JOIN filialm f ON f.cfilial=g.cfilial
		INNER JOIN instita i ON i.cinstit=g.cinstit
		INNER JOIN carrerm c ON c.ccarrer=g.ccarrer
		INNER JOIN semacan s ON ( s.cfilial=g.cfilial AND s.cinstit=g.cinstit AND s.csemaca=g.csemaca AND s.cinicio=g.cinicio )
		INNER JOIN horam h ON h.chora=g.chora
		LEFT JOIN conmatp co ON co.cgruaca=g.cgracpr
		LEFT JOIN ingalum ing ON (ing.cingalu=co.cingalu AND ing.cestado='1')
		WHERE g.cesgrpr IN ('3','4')
		AND g.finicio BETWEEN $fechas
		AND g.cfilial IN ('$cfilial')
		AND g.cinstit IN ('$cinstit')
		GROUP BY g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,
		g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio
		ORDER BY f.dfilial,i.dinstit,c.dcarrer,frec";
$cn->setQuery($sql);
$rpt=$cn->loadObjectList();


$sql2="Select concat(dnomper,' ',dappape,' ',dapmape) as nombre
		FROM personm
		WHERE dlogper='".$_GET['usuario']."'";
$cn->setQuery($sql2);
$rpt2=$cn->loadObjectList();

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
$styleAlignmentLeft= array(
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
							 ->setTitle("Indice de Matriculacion para gerencia")
							 ->setSubject("Reporte IMG")
							 ->setDescription("Agiliza la toma de desiciones en los indice de matriculación realizadas según el filtro realizado.")
							 ->setKeywords("php")
							 ->setCategory("Reporte");

$objPHPExcel->getDefaultStyle()->getFont()->setName('Bookman Old Style');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(false);
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(89);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.7);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.2);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.1);
$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(0.20);
$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(0);


//$objPHPExcel->getActiveSheet()->setCellValue("A1",$sql);
$objPHPExcel->getActiveSheet()->setCellValue("A2","ÍNDICE DE MATRICULACIÓN PARA GERENCIA");
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells('A2:U2');
$objPHPExcel->getActiveSheet()->getStyle('A2:U2')->applyFromArray($styleAlignmentBold);

$cabecera=array('N°','ODE','INSTITUCION','CARRERA','PENSION','FREC','HORA','SEMESTRE','INICIO','FECHA INICIO','MATRIC.EN LOS ULT 2 DIAS','','INSCRITOS','META MÁXIMA','META MÍNIMA','INCIO CAMPAÑA','DIAS CAMPAÑA','INDICE POR DÍA','DIAS QUE FALTA','PROY. DIAS FALTANTES','PROY. FINAL','FALTA PARA LOGRAR META');


	for($i=0;$i<count($cabecera);$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."5",$cabecera[$i]);	
		if($i>=15 or $i==8){
			$objPHPExcel->getActiveSheet()->getStyle($az[$i]."5")->getAlignment()->setTextRotation(90);
		}	
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."5")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);	
	}
	$objPHPExcel->getActiveSheet()->getRowDimension("5")->setRowHeight(74.75); // altura
	$objPHPExcel->getActiveSheet()->mergeCells('K5:L5');	

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
$objPHPExcel->getActiveSheet()->setCellValue("L4","AL");
$objPHPExcel->getActiveSheet()->getStyle('L4')->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue("M4",$_GET['fechfin']);

$objPHPExcel->getActiveSheet()->getStyle('A5:V5')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle("A5:V5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFEBF1DE');
//$objPHPExcel->getActiveSheet()->getStyle("Q5:V5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFF0F000');	

$valorinicial=5;
$cont=0;
$total=0;
$pago="";
$fil="";
$cins="";
$frec="";
$hora="";
$concarrera=0;
$dcarrer='';
$sumatotal=array();

foreach($rpt as $r){	
	if($fil!=$r['dfilial'] /*or $cins!=$r['dinstit']*/){
		if($fil!=''){	
			/*if($dcarrer!=''){
			$objPHPExcel->getActiveSheet()->mergeCells( "D".($valorinicial-$concarrera).":D".($valorinicial) );
			$objPHPExcel->getActiveSheet()->getStyle("D".($valorinicial-$concarrera).":D".($valorinicial))->applyFromArray($styleAlignmentLeft);
			}*/		
		$valorinicial++;			
		$objPHPExcel->getActiveSheet()->getRowDimension($valorinicial)->setRowHeight(15.5); // altura
		$objPHPExcel->getActiveSheet()->setCellValue("J".$valorinicial,"TOTALES");
		$objPHPExcel->getActiveSheet()->getStyle('J'.$valorinicial.":"."V".$valorinicial)->applyFromArray($styleAlignmentRight);
		$objPHPExcel->getActiveSheet()->getStyle("A".$valorinicial.":"."V".$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD8E4BC');
		
		$objPHPExcel->getActiveSheet()->setCellValue("K".$valorinicial,"=SUM(K".($valorinicial-$cont).":K".($valorinicial-1).")");
		$objPHPExcel->getActiveSheet()->setCellValue("L".$valorinicial,"=SUM(L".($valorinicial-$cont).":L".($valorinicial-1).")");
		$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial,"=SUM(M".($valorinicial-$cont).":M".($valorinicial-1).")");
		$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial,"=SUM(N".($valorinicial-$cont).":N".($valorinicial-1).")");
		$objPHPExcel->getActiveSheet()->setCellValue("O".$valorinicial,"=SUM(O".($valorinicial-$cont).":O".($valorinicial-1).")");
		$objPHPExcel->getActiveSheet()->setCellValue("R".$valorinicial,"=SUM(R".($valorinicial-$cont).":R".($valorinicial-1).")");
		$objPHPExcel->getActiveSheet()->setCellValue("T".$valorinicial,"=SUM(T".($valorinicial-$cont).":T".($valorinicial-1).")");
		$objPHPExcel->getActiveSheet()->setCellValue("U".$valorinicial,"=SUM(U".($valorinicial-$cont).":U".($valorinicial-1).")");
		$objPHPExcel->getActiveSheet()->setCellValue("V".$valorinicial,"=SUM(V".($valorinicial-$cont).":V".($valorinicial-1).")");

		array_push($sumatotal, $valorinicial);
		/*$objPHPExcel->getActiveSheet()->setCellValue( "B".($valorinicial-$cont), $fil );
		$objPHPExcel->getActiveSheet()->mergeCells( "B".($valorinicial-$cont).":B".($valorinicial-1) );
		$objPHPExcel->getActiveSheet()->setCellValue( "C".($valorinicial-$cont), $cins );
		$objPHPExcel->getActiveSheet()->mergeCells( "C".($valorinicial-$cont).":C".($valorinicial-1) );
		$objPHPExcel->getActiveSheet()->getStyle( "B".($valorinicial-$cont).":C".($valorinicial-1) )->applyFromArray($styleAlignment);
		*/
		}

	$fil=$r['dfilial'];
	/*$cins=$r['dinstit'];*/
	$cont=0;
	/*$concarrera=0;
	$dcarrer='';*/
	}
$cont++;
//$concarrera++;
$valorinicial++;
$paz=0;

$objPHPExcel->getActiveSheet()->getRowDimension($valorinicial)->setRowHeight(15.5); // altura
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $cont);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dfilial']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dinstit']);$paz++;

/*if($r["dcarrer"]!=$dcarrer){
	if($dcarrer!=''){
		$objPHPExcel->getActiveSheet()->mergeCells( "D".($valorinicial-$concarrera).":D".($valorinicial-1) );
		$objPHPExcel->getActiveSheet()->getStyle("D".($valorinicial-$concarrera).":D".($valorinicial))->applyFromArray($styleAlignmentLeft);
	}
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dcarrer']);

$concarrera=0;
$dcarrer=$r["dcarrer"];
}*/
$precio=explode("|",$r['precio']);
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['dcarrer']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $precio[1]);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['frec']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['hora']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['csemaca']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['cinicio']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['finicio']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['d1']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['d2']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['inscritos']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['nmetmat']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['nmetmin']);$paz++;

$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['inicamp']);$paz++;
	if($r['ndiacamp']<0){
		$r['ndiacamp']=0;
	}
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $r['ndiacamp']);$paz++;

$dia_ejec = $r['ndiacamp'];	
$ind_xdia_act = 0;
	if($r['ndiacamp']>0){
	$ind_xdia_act = round( ($r['inscritos']/$r['ndiacamp']),2 );
	}
	else{
	$ind_xdia_act = 123.123;
	}

$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $ind_xdia_act);$paz++;
$dias_falt=$r['dias_falta'];
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $dias_falt);$paz++;
$mat_prog_xdia=$ind_xdia_act*$dias_falt;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $mat_prog_xdia);$paz++;
$proy_fin_cam=$r['inscritos']+$mat_prog_xdia;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$proy_fin_cam);$paz++;
$color="FFFF4848";
if( $proy_fin_cam>=$r['nmetmat'] ){
	$color="FF35FF35";
}
elseif( $proy_fin_cam>=$r['nmetmin'] ){
	$color="FFFFFF48";
}
$objPHPExcel->getActiveSheet()->getStyle($az[($paz-1)].$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
$mat_falt_meta = $r['nmetmat'] - $proy_fin_cam;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, $mat_falt_meta);$paz++;

//$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial, "$dia_ejec|$ind_xdia_act|$dias_falt|$mat_prog_xdia|$proy_fin_cam|$mat_falt_meta");$paz++;
}

	/*if($dcarrer!=''){
		$objPHPExcel->getActiveSheet()->mergeCells( "D".($valorinicial-$concarrera).":D".($valorinicial) );
		$objPHPExcel->getActiveSheet()->getStyle("D".($valorinicial-$concarrera).":D".($valorinicial))->applyFromArray($styleAlignmentLeft);
	}*/
$valorinicial++;
$objPHPExcel->getActiveSheet()->getRowDimension($valorinicial)->setRowHeight(15.5); // altura
	$objPHPExcel->getActiveSheet()->setCellValue("J".$valorinicial,"TOTALES");
	$objPHPExcel->getActiveSheet()->getStyle('J'.$valorinicial.":"."V".$valorinicial)->applyFromArray($styleAlignmentRight);
	$objPHPExcel->getActiveSheet()->getStyle("A".$valorinicial.":"."V".$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD8E4BC');
	
	$objPHPExcel->getActiveSheet()->setCellValue("K".$valorinicial,"=SUM(K".($valorinicial-$cont).":K".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("L".$valorinicial,"=SUM(L".($valorinicial-$cont).":L".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial,"=SUM(M".($valorinicial-$cont).":M".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial,"=SUM(N".($valorinicial-$cont).":N".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("O".$valorinicial,"=SUM(O".($valorinicial-$cont).":O".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("R".$valorinicial,"=SUM(R".($valorinicial-$cont).":R".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("T".$valorinicial,"=SUM(T".($valorinicial-$cont).":T".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("U".$valorinicial,"=SUM(U".($valorinicial-$cont).":U".($valorinicial-1).")");
	$objPHPExcel->getActiveSheet()->setCellValue("V".$valorinicial,"=SUM(V".($valorinicial-$cont).":V".($valorinicial-1).")");
	array_push($sumatotal, $valorinicial);
	/*$objPHPExcel->getActiveSheet()->setCellValue( "B".($valorinicial-$cont), $fil );
	$objPHPExcel->getActiveSheet()->mergeCells( "B".($valorinicial-$cont).":B".($valorinicial-1) );
	$objPHPExcel->getActiveSheet()->setCellValue( "C".($valorinicial-$cont), $cins );
	$objPHPExcel->getActiveSheet()->mergeCells( "C".($valorinicial-$cont).":C".($valorinicial-1) );
	$objPHPExcel->getActiveSheet()->getStyle( "B".($valorinicial-$cont).":C".($valorinicial-1) )->applyFromArray($styleAlignment);
	*/
$objPHPExcel->getActiveSheet()->getStyle('A5:V'.$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
$valorinicial++;$valorinicial++;
$objPHPExcel->getActiveSheet()->getRowDimension($valorinicial)->setRowHeight(15.5); // altura
	$objPHPExcel->getActiveSheet()->setCellValue("J".$valorinicial,"TOTALES");
	$objPHPExcel->getActiveSheet()->getStyle('J'.$valorinicial.":"."O".$valorinicial)->applyFromArray($styleAlignmentRight);
	$objPHPExcel->getActiveSheet()->getStyle("J".$valorinicial.":"."O".$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD8E4BC');
	$objPHPExcel->getActiveSheet()->setCellValue("K".$valorinicial,"=K".implode("+K",$sumatotal));
	$objPHPExcel->getActiveSheet()->setCellValue("L".$valorinicial,"=L".implode("+L",$sumatotal));
	$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial,"=M".implode("+M",$sumatotal));
	$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial,"=N".implode("+N",$sumatotal));
	$objPHPExcel->getActiveSheet()->setCellValue("O".$valorinicial,"=O".implode("+O",$sumatotal));
$objPHPExcel->getActiveSheet()->getStyle('J'.$valorinicial.":"."O".$valorinicial)->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('J'.$valorinicial.":"."O".$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);

$objPHPExcel->getActiveSheet()->getStyle('M6:M'.$valorinicial)->applyFromArray($styleAlignmentRight);
//$objPHPExcel->getActiveSheet()->getStyle('AA4:AA'.$valorinicial)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Indice_Matricula');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Indice_MatriculaG_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
