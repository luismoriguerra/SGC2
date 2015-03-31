<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

//var_dump($datos);exit();
/** PHPExcel */
require_once '../../php/includes/phpexcel/Classes/PHPExcel.php';
require_once '../../php/includes/phpexcel/Classes/PHPExcel/IOFactory.php';

// Create new PHPExcel object
//$objPHPExcel = PHPExcel_IOFactory::load("../../archivos/plantillas/PLANTILLACONFIGURACION.xls");//abro xls pq tuve problemas al abrir xlsx y esporto xlsx

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
$styleBold= array(
	'font'    => array(
		'bold'      => true
	),
);
$styleAlignment= array(
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	),
);
$styleRigth= array(
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
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

/* QUERYS*/
$cgracpr=$_GET['cgracpr'];
$cingalu=$_GET['cingalu'];
$semestre=$_GET['csemaca'];
$cfilial=$_GET['cfilial'];
$cinstit=$_GET['cinstit'];
$alumno="";

if(trim($cingalu)!=""){
$alumno=" AND co.cingalu='".$cingalu."'";
}

$sql="	Select i.cingalu,ins.durllog,i.dcoduni,i.dcodlib,co.cconmat,gr.csemaca,ca.dcarrer,pe.dnomper,pe.dappape,pe.dapmape,ci.dciclo,
		GROUP_CONCAT(concat(
			'0','|',cu.dcurso,'|',dg.ncredit) SEPARATOR '^^') as cursos,
		(select co.nprecio 
		from recacap rr 
		INNER JOIN concepp co on (co.cconcep=rr.cconcep)
		WHERE rr.cingalu=co.cingalu and rr.cgruaca=co.cgruaca
		and (co.cctaing like '701.01%' or co.cctaing like '701.02%')
		and rr.testfin in ('C','P')
		limit 0,1
		) as matricula,
		(select GROUP_CONCAT(concat(cr.ccuota,'|',cr.fvencim,'|',con.nprecio) SEPARATOR '^^') as pagos
		from cropaga cr		
		INNER JOIN concepp con on (con.cconcep=cr.cconcep)		
		where cr.cconcep in 
			( Select rr.cconcep
			FROM recacap rr
			INNER JOIN concepp con2 on (con2.cconcep=rr.cconcep)		
			WHERE rr.cingalu=co.cingalu and rr.cgruaca=co.cgruaca
			and con2.cctaing like '701.03%'
			and rr.testfin in ('C','P')
			)
		and cr.cgruaca=co.cgruaca
		GROUP BY cr.cgruaca,cr.cconcep) as pension
		from ingalum i
		INNER JOIN conmatp co ON (i.cingalu=co.cingalu)
		INNER JOIN personm pe ON (pe.cperson=i.cperson)
		INNER JOIN gracprp gr ON (gr.cgracpr=co.cgruaca)
		INNER JOIN instita ins on (ins.cinstit=gr.cinstit)
		LEFT JOIN cuprprp dg ON (dg.cgracpr=gr.cgracpr)
		LEFT JOIN cursom cu ON (cu.ccurso=dg.ccurso)
		INNER JOIN cicloa ci ON (ci.cciclo=gr.cciclo)
		INNER JOIN carrerm ca ON (ca.ccarrer=gr.ccarrer)
		where co.cgruaca in ('".str_replace(",","','",$cgracpr)."')	
		".$alumno."
		GROUP BY co.cingalu,co.cgruaca";
$cn->setQuery($sql);
$alumno=$cn->loadObjectList();

/*
$sqlconcep="SELECT  nprecio
			  FROM concepp 
			  WHERE cctaing like '701.01%' 
			  AND cfilial='".$cfilial."' 
			  AND cinstit='".$cinstit."' 
			  AND tinscri='O'   
			  AND cestado='1' 
			  GROUP BY dconcep 
			  ORDER BY dconcep desc 
				limit 0,1";
$cn->setQuery($sqlconcep);
$concepto=$cn->loadObjectList();

$sqlpagos="	select GROUP_CONCAT(concat(cr.ccuota,'|',cr.fvencim,'|',co.nprecio) SEPARATOR '^^') as pagos
			from cropaga cr, gracprp gr, concepp co
			where cr.cgruaca=gr.cgracpr
			and co.cconcep=cr.cconcep
			GROUP BY cr.cgruaca,cr.cconcep";
$cn->setQuery($sqlpagos);
$pagos=$cn->loadObjectList();*/


$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Jorge Salcedo")
							 ->setLastModifiedBy("Jorge Salcedo")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


$pestana=0;
foreach($alumno as $rs){ // Inicio de Recorrido
	if($pestana>0){
	$objPHPExcel->createSheet();
	$objPHPExcel->setActiveSheetIndex($pestana);
	}
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(85);
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(11);

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('PHPExcel');
$objDrawing->setDescription('PHPExcel');
$objDrawing->setPath('includes/'.$rs['durllog']);
$objDrawing->setHeight(61);
$objDrawing->setCoordinates('A1');
$objDrawing->setOffsetX(15);
$objDrawing->setOffsetY(10);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

/*$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('PHPExcel');
$objDrawing->setDescription('PHPExcel');
$objDrawing->setPath('includes/foto.png');
//$objDrawing->setHeight(50);
$objDrawing->setCoordinates('J1');
$objDrawing->setOffsetY(10);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());*/

$objPHPExcel->setActiveSheetIndex($pestana)
			->setCellValue('D1','PRE MATRÍCULA '.$semestre)
			->setCellValue('C3','CODIGO:')
			->setCellValue('C4','APELLIDOS Y NOMBRES:')
			->setCellValue('C5','CARRERA PROFESIONAL:')
			->setCellValue('F3',$rs['dcodlib'])
			->setCellValue('F4',$rs['dnomper']." ".$rs['dappape']." ".$rs['dapmape'])
			->setCellValue('F5',$rs['dcarrer'])
			;
		
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells('D1:I1');
$objPHPExcel->getActiveSheet()->mergeCells('C3:E3');
$objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
$objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
$objPHPExcel->getActiveSheet()->mergeCells('F3:I3');
$objPHPExcel->getActiveSheet()->mergeCells('F4:I4');
$objPHPExcel->getActiveSheet()->mergeCells('F5:I5');

$objPHPExcel->getActiveSheet()->getStyle('D1:I1')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('F3:I3')->applyFromArray($styleBold);
$objPHPExcel->getActiveSheet()->getStyle('F4:I4')->applyFromArray($styleBold);
$objPHPExcel->getActiveSheet()->getStyle('F5:I5')->applyFromArray($styleBold);
$objPHPExcel->getActiveSheet()->getStyle('C3:E3')->applyFromArray($styleRigth);
$objPHPExcel->getActiveSheet()->getStyle('C4:E4')->applyFromArray($styleRigth);
$objPHPExcel->getActiveSheet()->getStyle('C5:E5')->applyFromArray($styleRigth);

$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(2.75); // altura
$pos++;

$objPHPExcel->getActiveSheet()->setCellValue('A10','CICLO');
$objPHPExcel->getActiveSheet()->setCellValue('B10','ASIGNATURAS');
$objPHPExcel->getActiveSheet()->setCellValue('E10','CRED');
$objPHPExcel->getActiveSheet()->mergeCells('B10:D10');
$objPHPExcel->getActiveSheet()->setCellValue('G10','CUOTA');
$objPHPExcel->getActiveSheet()->setCellValue('I10','FECHA');
$objPHPExcel->getActiveSheet()->setCellValue('J10','IMPORTE');
//$objPHPExcel->getActiveSheet()->setCellValue('H9',"ASIGNATURAS ".$semestre);
$objPHPExcel->getActiveSheet()->mergeCells('G10:H10');
$objPHPExcel->getActiveSheet()->getStyle('A10:J10')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('A10:E10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');
$objPHPExcel->getActiveSheet()->getStyle('G10:J10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');
$dcursos=explode("^^",$rs['cursos']);
$detcic=explode(" ",$rs['dciclo']);
if(trim($rs['cursos'])==""){
$objPHPExcel->getActiveSheet()->setCellValue('A11','VALIDAR CURSOS');
$objPHPExcel->getActiveSheet()->mergeCells('A11:E11');
$objPHPExcel->getActiveSheet()->getStyle('A11:E11')->applyFromArray($styleAlignmentBold);
$posfin=12;
}
else{
for($i=11;$i<(11+count($dcursos));$i++){ //Antiguo era hasta el 16
	$ddc=explode("|",$dcursos[($i-11)]);
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$detcic[0]);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$ddc[1]);
	$objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':D'.$i);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$ddc[2]);
	}
$posfin=$i;
}


$contar=0;
$filpos=array('1ra','2da','3ra','4ta','5ta','6ta','7ta','8va','9na','10ma','11va','12va','13va','15va','16va','17va');
$monto_pension=0;
$fecha_pension="";

/*******************************/


$objPHPExcel->getActiveSheet()->setCellValue('A9','PROGRAMACIÓN ACADÉMICA '.$semestre);
$objPHPExcel->getActiveSheet()->setCellValue('G9','PROGRAMA DE PAGOS '.$semestre);
$objPHPExcel->getActiveSheet()->mergeCells('A9:E9');
$objPHPExcel->getActiveSheet()->mergeCells('G9:J9');
$objPHPExcel->getActiveSheet()->getStyle('A9:J9')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('A9:E9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');
$objPHPExcel->getActiveSheet()->getStyle('G9:J9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');
/*******************************/

$objPHPExcel->getActiveSheet()->getStyle('B10:C'.($posfin-1))->getFont()->setSize(8);
$objPHPExcel->getActiveSheet()->getStyle('A10:A'.($posfin-1))->applyFromArray($styleAlignment);
$objPHPExcel->getActiveSheet()->getStyle('E10:E'.$posfin)->applyFromArray($styleAlignment);


$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'TOTAL CRÉDITOS:');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$posfin,'=SUM(E11:E'.($posfin-1).')');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':D'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A9:E'.($posfin))->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':D'.$posfin)->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':E'.$posfin)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');

$pagostotal=explode("^^",$rs['pension']);
sort($pagostotal);
for($i=0;$i<count($pagostotal);$i++){
	$det=explode("|",$pagostotal[$i]);
	if($i==0){
	$fecha_pension=$det[1];
	$monto_pension=$det[2];
	}
$objPHPExcel->getActiveSheet()->setCellValue('G'.($i+11),$det[0].' CUOTA');
$objPHPExcel->getActiveSheet()->mergeCells('G'.($i+11).':H'.($i+11));
$objPHPExcel->getActiveSheet()->setCellValue('I'.($i+11),$det[1]);
$objPHPExcel->getActiveSheet()->setCellValue('J'.($i+11),$det[2]);
}

/**********************************************************************/
$objPHPExcel->getActiveSheet()->setCellValue('A7','FECHA DE MATRICULA: Hasta '.$fecha_pension.', de 16:00 - 20:00 horas');
$objPHPExcel->getActiveSheet()->mergeCells('A7:J7');
$objPHPExcel->getActiveSheet()->getStyle('A7:J7')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('A7:J7')->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('A7:J7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');
/************************************************************************/


$objPHPExcel->getActiveSheet()->getStyle('G9:J'.($i+10))->applyFromArray($styleThinBlackBorderAllborders);
$pospension=$i+11;
$objPHPExcel->getActiveSheet()->setCellValue('G'.$pospension,'Todo pago, pasada la fecha de vencimiento sufrirá un recargo adicional');
$objPHPExcel->getActiveSheet()->mergeCells('G'.$pospension.':J'.($pospension+1));
$objPHPExcel->getActiveSheet()->getStyle('G'.$pospension.':J'.($pospension+1))->getAlignment()->setWrapText(true);
$pospension++;
$pospension++;
$objPHPExcel->getActiveSheet()->setCellValue('G'.$pospension,'PAGOS PARA LA MATRÍCULA');
$objPHPExcel->getActiveSheet()->mergeCells('G'.$pospension.':J'.$pospension);
$pospension++;
$objPHPExcel->getActiveSheet()->setCellValue('G'.$pospension,'CONCEPTOS');
$objPHPExcel->getActiveSheet()->mergeCells('G'.$pospension.':H'.$pospension);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$pospension,'FECHA');
$objPHPExcel->getActiveSheet()->setCellValue('J'.$pospension,'IMPORTE');
$pospension++;
$objPHPExcel->getActiveSheet()->setCellValue('G'.$pospension,'Derecho de Matrícula');
$objPHPExcel->getActiveSheet()->mergeCells('G'.$pospension.':H'.$pospension);
$pospension++;
$objPHPExcel->getActiveSheet()->setCellValue('G'.$pospension,'Pensión de la Carrera');
$objPHPExcel->getActiveSheet()->mergeCells('G'.$pospension.':H'.$pospension);
$pospension++;
$objPHPExcel->getActiveSheet()->setCellValue('G'.$pospension,'MONTO TOTAL:');
$objPHPExcel->getActiveSheet()->mergeCells('G'.$pospension.':I'.$pospension);
$objPHPExcel->getActiveSheet()->getStyle('G'.$pospension.':I'.$pospension)->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue('I'.($pospension-1),$fecha_pension);
$objPHPExcel->getActiveSheet()->setCellValue('I'.($pospension-2),$fecha_pension);
$objPHPExcel->getActiveSheet()->setCellValue('J'.($pospension-1),$monto_pension);
$objPHPExcel->getActiveSheet()->setCellValue('J'.($pospension-2),$rs['matricula']);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$pospension,'=SUM(J'.($pospension-2).':J'.($pospension-1).')');
$objPHPExcel->getActiveSheet()->getStyle('G'.($pospension-4).':J'.$pospension)->applyFromArray($styleThinBlackBorderAllborders);

$objPHPExcel->getActiveSheet()->getStyle('G'.($pospension-4).':J'.($pospension-3))->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('G'.($pospension-4).':J'.($pospension-3))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');
$objPHPExcel->getActiveSheet()->getStyle('G'.$pospension.':J'.$pospension)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');

if($posfin<$pospension){
$posfin=$pospension;
}
$pos=$posfin;
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(2.75); // altura
$pos++;
$posfin++;//20
$posfin++;//20

$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'COMUNICACIÓN PARA REALIZAR EL PAGO A TRAVÉS DEL BCP');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->setCellValue('A'.($posfin+1),'Que debo de decir');
$objPHPExcel->getActiveSheet()->mergeCells('A'.($posfin+1).':C'.($posfin+1));
$objPHPExcel->getActiveSheet()->setCellValue('D'.($posfin+1),'En la ventanilla del BCP');
$objPHPExcel->getActiveSheet()->mergeCells('D'.($posfin+1).':G'.($posfin+1));
$objPHPExcel->getActiveSheet()->setCellValue('H'.($posfin+1),'Al agente BCP');
$objPHPExcel->getActiveSheet()->mergeCells('H'.($posfin+1).':J'.($posfin+1));
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.($posfin+1))->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.($posfin+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');

$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.($posfin+1))->getFont()->setSize(10);

$posfin++;//31
$posfin++;//32
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'Lo primero que debo de decir');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':C'.$posfin);
$objPHPExcel->getActiveSheet()->setCellValue('A'.($posfin+1),'Lo segundo que debo de decir');
$objPHPExcel->getActiveSheet()->mergeCells('A'.($posfin+1).':C'.($posfin+1));
$objPHPExcel->getActiveSheet()->setCellValue('A'.($posfin+2),'Finalmente, deberá indicar su código:');
$objPHPExcel->getActiveSheet()->mergeCells('A'.($posfin+2).':C'.($posfin+2));
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':C'.($posfin+2))->applyFromArray($styleAlignmentRight);

$objPHPExcel->getActiveSheet()->setCellValue('D'.$posfin,'Deseo pagar a la universidad Telesup');
$objPHPExcel->getActiveSheet()->mergeCells('D'.$posfin.':G'.$posfin);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$posfin,'Deseo pagar a la cuenta recaudadora 6008');
$objPHPExcel->getActiveSheet()->mergeCells('H'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->setCellValue('D'.($posfin+1),'Deseo pagar al servicio pago sin descuento');
$objPHPExcel->getActiveSheet()->mergeCells('D'.($posfin+1).':J'.($posfin+1));
//$codigo='UT10100068';// codigo generado de la BD
$objPHPExcel->getActiveSheet()->setCellValue('D'.($posfin+2),'Mi código es: '.$rs['dcodlib']);
$objPHPExcel->getActiveSheet()->mergeCells('D'.($posfin+2).':J'.($posfin+2));
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.($posfin+2))->getFont()->setSize(8);

$posfin++;//33
$posfin++;//34
$posfin++;//35
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'Antes de pagar, verificar que el nombre le corresponda a usted');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');

$objPHPExcel->getActiveSheet()->getStyle('A'.($posfin-5).':J'.$posfin)->applyFromArray($styleThinBlackBorderAllborders);

$posfin++;//36
$posfin++;//37
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'ACCESO A LA INTRANET');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');

$posfin++;//38
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'La institución pone a sus servicio la Intranet a través de www.cpdtelesup.com con el usuario y clave que tendrá que solicitar en cualquiera de nuestras ODEs. En caso de presentar deuda pendiente de pago, este servicio será suspendido temporalmente hasta la cancelación de la misma.');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->getStyle('A'.($posfin-1).':J'.$posfin)->applyFromArray($styleThinBlackBorderAllborders);

$posfin++;//36
$posfin++;//37
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'INFORMACIÓN IMPORTANTE');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');

$posfin++;//38
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'1.- Se considera alumno matriculado y goza de todos los derechos como tal, aquel que ha realizado el pago de la matricula, el pago de la  primera cuota como mínimo, ha presentado todos los documentos solicitados y ha registrado sus datos en la Ficha de Matrícula.');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getAlignment()->setWrapText(true);

$posfin++;//39
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'2.- Deberá matricularse en la fecha y hora indicada; caso contrario será considerada matrícula extemporanea.  El alumno matriculado en fecha extenporánea, que ha cumplido con todos los pagos y ha entregado todos los documentos solicitados,  deberá esperar 7 dias después de iniciado las clases para gozar de todos los derechos como alumno matriculado y se somete a la disponibilidad de inicios, asignaturas, ambientes, horarios y frecuencias de estudios.');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getAlignment()->setWrapText(true);

$posfin++;//40
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'3.- En tanto el alumno no cancele el integro del pago de sus pensiones educativas, la universidad retendrá los certificados correspondientes a los periodos no pagados.');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getAlignment()->setWrapText(true);

$posfin++;//41
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'4.- El alumno no podrá matricularse en el ciclo académico siguiente hasta la cancelación de la deuda por pensiones educativas, salvo existencia de convenio de pago.');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getAlignment()->setWrapText(true);

$posfin++;//42
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'5.- Las pensiones no pagadas generarán intereses moratorios. (LEY N° 29947) .');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.($posfin-5).':J'.($posfin-5))->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('A'.($posfin-4).':J'.$posfin)->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('A'.($posfin-4).':J'.$posfin)->getFont()->setSize(8);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.9); // ancho   14
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9.6); // ancho   86
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(19.9); // ancho  14
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7); // ancho   27
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11.5); // ancho  71
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(1.4); // ancho  83
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6.1); // ancho  43
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18.9); // ancho 14
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(11.5); // ancho  71
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(11.5); // ancho  71
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(26.75); // altura
$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(2.75); // altura
$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(16.25); // altura
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(16.25); // altura
$objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(16.25); // altura
$objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(3.5); // altura



$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;

$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(2.75); // altura
$pos++;

$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(52.25); // altura
$pos++;

$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(2.75); // altura
$pos++;

$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(25.25); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(47.75); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(24.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(26.0); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(2.75); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$objPHPExcel->getActiveSheet()->setCellValue('F'.$pos,'DIRECCIÓN ACADÉMICA DE LA ODE DE JULIACA');
$objPHPExcel->getActiveSheet()->mergeCells('F'.$pos.':J'.$pos);
$objPHPExcel->getActiveSheet()->getStyle('F'.$pos.':J'.$pos)->applyFromArray($styleBold);
$pos++;

$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$objPHPExcel->getActiveSheet()->setCellValue('E'.$pos,'JR. LOS ALAMOS 65 - JULIACA / TELF: 3698741 RPM:958689745');
$objPHPExcel->getActiveSheet()->mergeCells('E'.$pos.':J'.$pos);
$objPHPExcel->getActiveSheet()->getStyle('E'.$pos.':J'.$pos)->applyFromArray($styleBold);
$pos++;

$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(2.75); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;

$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$objPHPExcel->getActiveSheet()->setCellValue('A'.$pos,'RECLAMOS Y QUEJAS: OFIC. ASEGURAMIENTO DE LA CALIDAD - AV. AREQUIPA 3565 - LIMA / TELF.: 957879905');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$pos.':J'.$pos);
$objPHPExcel->getActiveSheet()->getStyle('A'.$pos.':J'.$pos)->applyFromArray($styleBold);
$pos++;

$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;

$objPHPExcel->getActiveSheet()->getProtection()->setPassword('SHEVCHENKo');
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);

$objPHPExcel->getSecurity()->setLockWindows(true);
$objPHPExcel->getSecurity()->setLockStructure(true);
$objPHPExcel->getSecurity()->setWorkbookPassword("SHEVCHENKo");

if($pestana>0){
$objPHPExcel->getActiveSheet()->setTitle('Pre_Matricula_ADM_'.$pestana);
}
else{
$objPHPExcel->getActiveSheet()->setTitle('Pre_Matricula_ADM');
}
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex($pestana);
$pestana++;

} // Fin FOR

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Pre_Matricula_ADM_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>