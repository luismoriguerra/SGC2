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
$ciclos="";
$inicios="";
$grupos="";

if(trim($_GET['cciclo'])!=''){
$ciclos=" AND gr.cciclo='".$_GET['cciclo']."' ";
}

if(trim($_GET['cinicio'])!=''){
$inicios=" AND gr.cinicio='".$_GET['cinicio']."' ";
}

if(trim($_GET['cgruaca'])!=''){
$grupos=" AND gr.cgracpr='".$_GET['cgruaca']."' ";
}

$validasemestre=" select DISTINCT(csemaca) as csemaca 
				from gracprp
				where cfilial='".$_GET['cfilial']."'
				and cinstit='".$_GET['cinstit']."'
				and csemaca>'".$_GET['csemaca']."'
				order by csemaca 
				limit 0,1";
$cn->setQuery($validasemestre);
$qsem=$cn->loadObjectList();
$semestre=$qsem[0]['csemaca'];

$sql="	Select i.cingalu,i.dcoduni,co.cconmat,gr.csemaca,ca.dcarrer,pe.dnomper,pe.dappape,pe.dapmape,ci.dciclo,
		GROUP_CONCAT(concat(
			(select de.nnoficu 
			 from decomap de 
			 where co.cconmat=de.cconmat 
			 and de.ccurpro=dg.ccuprpr),
			 '|',cu.dcurso,'|',dg.ncredit) SEPARATOR '^^') as cursos,		
		 (select sum(re.nmonrec) 
		 from recacap re
		 where (re.cingalu=i.cingalu or re.cperson=i.cperson)
		 and (re.cestpag='P' or re.cestpag='')) as deudas
		from ingalum i,personm pe,gracprp gr,cuprprp dg,cursom cu,conmatp co,cicloa ci,carrerm ca
		where i.cingalu=co.cingalu
		AND pe.cperson=i.cperson
		and gr.cgracpr=co.cgruaca
		and dg.cgracpr=gr.cgracpr
		and cu.ccurso=dg.ccurso
		AND ci.cciclo=gr.cciclo		
		AND ca.ccarrer=gr.ccarrer
		and i.cfilial='".$_GET['cfilial']."'
		and i.cinstit='".$_GET['cinstit']."'
		and i.ccarrer='".$_GET['ccarrer']."'
		and gr.csemaca='".$_GET['csemaca']."'
		".$ciclos."
		".$inicios."
		".$grupos."
		GROUP BY i.cingalu,co.cconmat";
$cn->setQuery($sql);
$alumno=$cn->loadObjectList();


$sqlconcep="SELECT  nprecio
			  FROM concepp 
			  WHERE cctaing like '701.01%' 
			  AND cfilial='".$_GET['cfilial']."' 
			  AND cinstit='".$_GET['cinstit']."' 
			  AND cmodali='".$_GET['cmodali']."' 
			  AND ctipcar='".$_GET['ctipcar']."' 
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
			and gr.csemaca='".$semestre."'
			and gr.cfilial='".$_GET['cfilial']."'
			and gr.cinstit='".$_GET['cinstit']."'
			GROUP BY cr.cgruaca,cr.cconcep
			HAVING count(cr.ccuota)>3
			order by cr.ccropag desc
			limit 0,1";
$cn->setQuery($sqlpagos);
$pagos=$cn->loadObjectList();


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
$objDrawing->setPath('includes/imagen.png');
$objDrawing->setHeight(61);
$objDrawing->setCoordinates('A1');
$objDrawing->setOffsetX(15);
$objDrawing->setOffsetY(10);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('PHPExcel');
$objDrawing->setDescription('PHPExcel');
$objDrawing->setPath('includes/foto.png');
//$objDrawing->setHeight(50);
$objDrawing->setCoordinates('J1');
$objDrawing->setOffsetY(10);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objPHPExcel->setActiveSheetIndex($pestana)
			->setCellValue('D1','PRE MATRÍCULA '.$semestre)
			->setCellValue('C3','CODIGO:')
			->setCellValue('C4','APELLIDOS Y NOMBRES:')
			->setCellValue('C5','CARRERA PROFESIONAL:')
			->setCellValue('F3',$rs['dcoduni'])
			->setCellValue('F4',$rs['dnombre']." ".$rs['dappape']." ".$rs['dapmape'])
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

$objPHPExcel->getActiveSheet()->setCellValue('A7','CICLO');
$objPHPExcel->getActiveSheet()->setCellValue('B7','ASIGNATURAS');
$objPHPExcel->getActiveSheet()->setCellValue('D7','PESO');
$objPHPExcel->getActiveSheet()->setCellValue('E7','NOTA');
$objPHPExcel->getActiveSheet()->mergeCells('B7:C7');
$objPHPExcel->getActiveSheet()->setCellValue('G7','CICLO');
$objPHPExcel->getActiveSheet()->setCellValue('H7',"ASIGNATURAS ".$semestre);
$objPHPExcel->getActiveSheet()->mergeCells('H7:J7');
$objPHPExcel->getActiveSheet()->getStyle('A7:J7')->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('A7:E7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');
$objPHPExcel->getActiveSheet()->getStyle('G7:J7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');
$dcursos=explode("^^",$rs['cursos']);
$detcic=explode(" ",$rs['dciclo']);
for($i=8;$i<(8+count($dcursos));$i++){ //Antiguo era hasta el 16
$ddc=explode("|",$dcursos[($i-8)]);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$detcic[0]);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$ddc[1]);
$objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':C'.$i);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$i,$ddc[2]);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$ddc[0]);
}
$posfin=$i;

for($i=8;$i<17;$i++){ // Nuevo
$objPHPExcel->getActiveSheet()->setCellValue('G'.$i,'4');
$objPHPExcel->getActiveSheet()->setCellValue('H'.$i,'Sin Definir Tb :D');
$objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':J'.$i);
}
if($posfin<$i){
$posfin=$i;
}

$pos=7;
for($i=$pos;$i<=$posfin;$i++){
$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15.5); // altura
$pos++;
}
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(2.75); // altura
$pos++;

$objPHPExcel->getActiveSheet()->getStyle('B8:C'.($posfin-1))->getFont()->setSize(8);
$objPHPExcel->getActiveSheet()->getStyle('A8:A'.($posfin-1))->applyFromArray($styleAlignment);
$objPHPExcel->getActiveSheet()->getStyle('G8:G'.($posfin-1))->applyFromArray($styleAlignment);

$objPHPExcel->getActiveSheet()->setCellValue('C'.$posfin,'PROMEDIO PONDERADO');
$objPHPExcel->getActiveSheet()->mergeCells('C'.$posfin.':D'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('C'.$posfin.':D'.$posfin)->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$posfin,'=ROUND(AVERAGE(E8:E'.($posfin-1).'),2)');

$objPHPExcel->getActiveSheet()->getStyle('A7:E'.($posfin-1))->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('G7:J'.($posfin-1))->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('C'.$posfin.':E'.$posfin)->applyFromArray($styleThinBlackBorderAllborders);
//18 vacio
$posfin++;
//
$posfin++;//19
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'PROGRAMA DE PAGOS '.$semestre);
$objPHPExcel->getActiveSheet()->setCellValue('A'.($posfin+1),'CUOTA');
$objPHPExcel->getActiveSheet()->setCellValue('C'.($posfin+1),'FECHA PAGO');
$objPHPExcel->getActiveSheet()->setCellValue('D'.($posfin+1),'IMPORTE');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$posfin,'PAGOS PARA LA MATRÍCULA');
$objPHPExcel->getActiveSheet()->setCellValue('G'.($posfin+1),'CONCEPTOS');
$objPHPExcel->getActiveSheet()->setCellValue('I'.($posfin+1),'FECHA');
$objPHPExcel->getActiveSheet()->setCellValue('J'.($posfin+1),'IMPORTE');

$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':E'.$posfin);
$objPHPExcel->getActiveSheet()->mergeCells('A'.($posfin+1).':B'.($posfin+1));
$objPHPExcel->getActiveSheet()->mergeCells('D'.($posfin+1).':E'.($posfin+1));
$objPHPExcel->getActiveSheet()->mergeCells('G'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->mergeCells('G'.($posfin+1).':H'.($posfin+1));
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.($posfin+1))->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':E'.($posfin+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');
$objPHPExcel->getActiveSheet()->getStyle('G'.$posfin.':J'.($posfin+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');
$posfin++;//20
$posfin++;//21
$contar=0;
$filpos=array('1ra','2da','3ra','4ta','5ta');
$monto_pension=0;
$fecha_pension="";
$dpagos="^^".$pagos[0]['pagos']; // los pagos
for($i=$posfin;$i<($posfin+6);$i++){
$contar++;
$datos=explode("^^".$contar."|",$dpagos);
$real=explode("^^",$datos[1]);
$dreal=explode("|",$real[0]);
	if($contar==1){
	$fecha_pension=$dreal[0];
	$monto_pension=$dreal[1];
	}
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$filpos[($contar-1)].' Cuota');
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$dreal[0]);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$i,$dreal[1]);
	if($contar==3){
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':B'.($i+1));
	$objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':C'.($i+1));
	$objPHPExcel->getActiveSheet()->mergeCells('D'.$i.':E'.($i+1));
	$i++;
	}
	else{
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':B'.$i);	
	$objPHPExcel->getActiveSheet()->mergeCells('D'.$i.':E'.$i);
	}
}

$objPHPExcel->getActiveSheet()->setCellValue('G'.$posfin,'Derecho de Matrícula');
$objPHPExcel->getActiveSheet()->mergeCells('G'.$posfin.':H'.$posfin);
$objPHPExcel->getActiveSheet()->setCellValue('G'.($posfin+1),'Pensión de la Carrera');
$objPHPExcel->getActiveSheet()->mergeCells('G'.($posfin+1).':H'.($posfin+1));
$objPHPExcel->getActiveSheet()->setCellValue('G'.($posfin+2),'MONTO TOTAL:');
$objPHPExcel->getActiveSheet()->mergeCells('G'.($posfin+2).':I'.($posfin+2));
$objPHPExcel->getActiveSheet()->setCellValue('I'.$posfin,$fecha_pension);
$objPHPExcel->getActiveSheet()->setCellValue('I'.($posfin+1),$fecha_pension);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$posfin,$concepto[0]['nprecio']);
$objPHPExcel->getActiveSheet()->setCellValue('J'.($posfin+1),$monto_pension);
$objPHPExcel->getActiveSheet()->getStyle('G'.($posfin+2).':I'.($posfin+2))->applyFromArray($styleAlignmentRight);
$objPHPExcel->getActiveSheet()->getStyle('G'.($posfin+2).':J'.($posfin+2))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');
$objPHPExcel->getActiveSheet()->setCellValue('J'.($posfin+2),'=SUM(J'.$posfin.':J'.($posfin+1).')');

$objPHPExcel->getActiveSheet()->setCellValue('G'.($posfin+4),'DEUDA PENDIENTE:');
$objPHPExcel->getActiveSheet()->mergeCells('G'.($posfin+4).':H'.($posfin+5));
$objPHPExcel->getActiveSheet()->getStyle('G'.($posfin+4).':H'.($posfin+5))->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('G'.($posfin+4).':H'.($posfin+5))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');

$objPHPExcel->getActiveSheet()->setCellValue('I'.($posfin+4),$rs['csemaca']);
$objPHPExcel->getActiveSheet()->mergeCells('I'.($posfin+4).':I'.($posfin+5));
$objPHPExcel->getActiveSheet()->getStyle('I'.($posfin+4).':I'.($posfin+5))->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->setCellValue('J'.($posfin+4),($rs['deudas']*1));
$objPHPExcel->getActiveSheet()->mergeCells('J'.($posfin+4).':J'.($posfin+5));

$objPHPExcel->getActiveSheet()->getStyle('A'.($posfin-2).':E'.($posfin+5))->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':E'.($posfin+5))->applyFromArray($styleAlignment);
$objPHPExcel->getActiveSheet()->getStyle('G'.($posfin-2).':J'.($posfin+2))->applyFromArray($styleThinBlackBorderAllborders);
$objPHPExcel->getActiveSheet()->getStyle('G'.($posfin+4).':J'.($posfin+5))->applyFromArray($styleThinBlackBorderAllborders);
$posfin++;//22
$posfin++;//23
$posfin++;//24
$posfin++;//25
$posfin++;//26
$posfin++;//27
$posfin++;//28
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'FECHA DE MATRICULA: Hasta '.$fecha_pension.', de 16:00 - 20:00 horas');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->applyFromArray($styleThinBlackBorderAllborders);

$posfin++;//29
$posfin++;//30
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'COMUNICACIÓN PARA REALIZAR EL PAGO A TRAVÉS DEL BSP');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'Que debo de decir');
$objPHPExcel->getActiveSheet()->mergeCells('A'.($posfin+1).':C'.($posfin+1));
$objPHPExcel->getActiveSheet()->setCellValue('D'.($posfin+1),'En la ventanilla del BSP');
$objPHPExcel->getActiveSheet()->mergeCells('D'.($posfin+1).':G'.($posfin+1));
$objPHPExcel->getActiveSheet()->setCellValue('H'.($posfin+1),'Al agente BSP');
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

$objPHPExcel->getActiveSheet()->setCellValue('D'.$posfin,'Deseo pagar a la universidad Telesup');
$objPHPExcel->getActiveSheet()->mergeCells('D'.$posfin.':G'.$posfin);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$posfin,'Deseo pagar a la cuenta recaudadora 6008');
$objPHPExcel->getActiveSheet()->mergeCells('H'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->setCellValue('D'.($posfin+1),'Deseo pagar al servicio pago sin descuento');
$objPHPExcel->getActiveSheet()->mergeCells('D'.($posfin+1).':J'.($posfin+1));
//$codigo='UT10100068';// codigo generado de la BD
$objPHPExcel->getActiveSheet()->setCellValue('D'.($posfin+2),'Mi código es: '.$rs['dcoduni']);
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
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'INFORMACIÓN IMPORTANTE');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->applyFromArray($styleAlignmentBold);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F1');

$posfin++;//38
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'Deberá haber cancelado toda cuota con vencimiento anterior a la fecha de la matrícula para que pueda proceder con esta.');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getAlignment()->setWrapText(true);

$posfin++;//39
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'El pago de la matricula y pensión se debe de efectuar en las agencias del banco de credito.');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getAlignment()->setWrapText(true);

$posfin++;//40
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'Deberá matricularse en la fecha y hora indicada; caso contrario será considerada matrícula extemporanea sujeto al pago de un derecho.');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getAlignment()->setWrapText(true);

$posfin++;//41
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'El acto de la matrícula constituye aceptación del reglamento académico en su totaldad.');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getAlignment()->setWrapText(true);

$posfin++;//42
$objPHPExcel->getActiveSheet()->setCellValue('A'.$posfin,'La institución pone a sus servicio la Intranet con el usuario(Es su DNI) y clave 123456. En caso de presentar deuda pendiente de pago, este servicio será suspendido temporalmente hasta la cancleación de la misma.');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$posfin.':J'.$posfin);
$objPHPExcel->getActiveSheet()->getStyle('A'.$posfin.':J'.$posfin)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.($posfin-5).':J'.$posfin)->applyFromArray($styleThinBlackBorderAllborders);

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
/* Continuacion de Arriba */


$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(2.75); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(2.75); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(2.75); // altura
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
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(2.75); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(31.25); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(29.75); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(15.5); // altura
$pos++;
$objPHPExcel->getActiveSheet()->getRowDimension($pos)->setRowHeight(32); // altura
$pos++;

if($pestana>0){
$objPHPExcel->getActiveSheet()->setTitle('Pre_Matricula_'.$pestana);
}
else{
$objPHPExcel->getActiveSheet()->setTitle('Pre_Matricula');
}

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex($pestana);
$pestana++;
} // Fin FOR
//$objPHPExcel->getActiveSheet()->getStyle("F10:".$az[4+count($cab)].$valorinicial)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);



// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Pre_Matricula_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>