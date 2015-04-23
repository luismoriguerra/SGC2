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
$azcount=array( 8,15,15,15,25,15,28,30,15,15,15,15,15,20,15,15,15,15,15,15,15,15,15,19,40,20,20,20,20,20,20,20,20,20,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$cingalu=$_GET['cingalu'];
$cgracpr=$_GET['cgracpr'];
$cusuari=$_GET['usuario'];
$alumno="";

$cfilial=str_replace(",","','",$_GET['cfilial']);
$cinstit=str_replace(",","','",$_GET['cinstit']);
$csemaca=explode(" | ",$_GET['csemaca']);
$cciclo=$_GET['cciclo'];

$fechini=$_GET['fechini'];
$fechfin=$_GET['fechfin'];

$where='';
$order=" ORDER BY f.dfilial, ins.dinstit, ca.dcarrer, p.dappape, p.dapmape, p.dnomper ";

if($cingalu!=""){
$alumno=" AND c.cingalu='".$cingalu."' ";
}

if($cgracpr!=''){
$where=" WHERE c.cgruaca in ('".str_replace(",","','",$cgracpr)."') ".$alumno;
}
else{//AND CONCAT(g.csemaca,' | ',g.cinicio) in ('".$csemaca."')
$where=" WHERE g.cfilial in ('".$cfilial."') ";		 
$where.=" AND g.cinstit in ('".$cinstit."') 
		  AND g.csemaca='".$csemaca[0]."'
		  AND g.cinicio='".$csemaca[1]."'  
		  AND g.cciclo='".$cciclo."' ";		

	if($fechini!='' and $fechfin!=''){
$where.=" AND date(g.finicio) between '".$fechini."' and '".$fechfin."' ";
	}	 
}

$sql="SELECT DISTINCT
		 p.dappape
		,p.dapmape
		,p.dnomper
		,ca.dcarrer
		,g.csemaca
		,g.cinicio
		,g.finicio
		,ins.dinstit
		,replace(i.dcodlib,'-','') As dcodlib
		,i.certest As certest
		,i.partnac As partnac
		,If(i.fotodni = '1', 'SI', If(i.fotodni = '0', 'NO', '')) As fotodni
		,i.nfotos As nfotos
		,IfNull(pa.dpais,'') As dpais
		,If(i.tinstip = '0', 'INSTITUTO', If(i.tinstip = '1','UNIVERSIDAD', '')) As tinstip
		,i.dinstip As dinstip
		,i.dcarrep As dcarrep
		,i.ultanop As ultanop
		,i.dciclop As dciclop
		,i.ddocval As ddocval
		,CONCAT(p.ntelper,' | ',p.ntelpe2) AS telefono
		,IF(i.cestado='1','Activo','Retirado') AS cestado
		,p.email1 AS email
		,(Select GROUP_CONCAT(d.dnemdia SEPARATOR '-') From diasm d Where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0) As frecuencia
		,concat(h.hinici,'-',h.hfin) As hora
		,f.dfilial
		,m.dmoding
		,i.fusuari
	FROM personm p
		INNER JOIN ingalum i 	On (i.cperson  	= p.cperson)	
		INNER JOIN modinga m 	On (m.cmoding  	= i.cmoding)
		LEFT JOIN paism pa ON (pa.cpais=i.cpais)	
		INNER JOIN conmatp c 	On (i.cingalu  	= c.cingalu)
		INNER JOIN gracprp g 	On (c.cgruaca  	= g.cgracpr)
		INNER JOIN filialm f 	On (f.cfilial  	= g.cfilial)
		INNER JOIN horam h 		On (h.chora	   	= g.chora)
		INNER JOIN carrerm ca 	On (ca.ccarrer 	= g.ccarrer)
		INNER JOIN instita ins 	On (ins.cinstit	= g.cinstit)		
 ".$where." ".$order;
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

$objPHPExcel->getActiveSheet()->setCellValue("A1","RESUMEN DE CONTROL DE PAGOS DE MATRICULADOS CON DOCUMENTOS");
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->applyFromArray($styleAlignmentBold);


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

$cabecera=array('N°','ESTADO','COD LIBRO','APELL PATERNO','APELL MATERNO','NOMBRES','TEL FIJO / CELULAR','CORREO ELECTRÓNICO','CARRERA','CICLO ACADEMICO','INICIO','FECHA DE INICIO','INSTITUCION','FREC','HORARIO','LOCAL DE ESTUDIOS','MOD. INGRESO','NRO DE CERT. DE EST.','NRO DE PART. NACIM.','FOTOCOPIA DE DNI (N/S)','NRO DE FOTOS (1-6)','PAIS DE PROCED.','TIPO DE INSTIT','INST. DE PROCED','CARR. DE PROCEDENCIA','ULT. AÑO QUE ESTUDIÓ','ULT. CICLO REALIZADO','DOCUM. DEJADOS PARA LA CONVALIDACIO','FECHA DIGITACION');

	for($i=0;$i<count($cabecera);$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."5",$cabecera[$i]);
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."5")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}
$objPHPExcel->getActiveSheet()->getStyle('A4:'.$az[($i)].'5')->applyFromArray($styleAlignmentBold);

$pos=1;
$objPHPExcel->getActiveSheet()->setCellValue($az[$pos]."4","DATOS BASICOS DEL ALUMNO");
$objPHPExcel->getActiveSheet()->getStyle($az[($pos-1)]."4:".$az[($pos+6)]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCFFFF');
$objPHPExcel->getActiveSheet()->mergeCells($az[$pos].'4:'.$az[($pos+6)].'4');$pos+=7;

$objPHPExcel->getActiveSheet()->setCellValue($az[$pos]."4","DATOS DE LA CARRERA");
$objPHPExcel->getActiveSheet()->getStyle($az[$pos]."4:".$az[($pos+8)]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFABF8F');
$objPHPExcel->getActiveSheet()->mergeCells($az[$pos].'4:'.$az[($pos+8)].'4');$pos+=9;

$objPHPExcel->getActiveSheet()->setCellValue($az[$pos]."4","DOCUMENTOS ESCOLARES ENTREGADOS");
$objPHPExcel->getActiveSheet()->getStyle($az[$pos]."4:".$az[($pos+3)]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF6699');
$objPHPExcel->getActiveSheet()->mergeCells($az[$pos].'4:'.$az[($pos+3)].'4');$pos+=4;

$objPHPExcel->getActiveSheet()->setCellValue($az[$pos]."4","DATOS PARA EL PROCESO DE CONVALIDACION");
$objPHPExcel->getActiveSheet()->getStyle($az[$pos]."4:".$az[($pos+6)]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF6699');
$objPHPExcel->getActiveSheet()->mergeCells($az[$pos].'4:'.$az[($pos+6)].'4');$pos+=7;

$objPHPExcel->getActiveSheet()->setCellValue($az[$pos].'4',"FECHA DIGITACION");
$objPHPExcel->getActiveSheet()->getStyle($az[$pos]."4:".$az[$pos]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF6699');
$objPHPExcel->getActiveSheet()->mergeCells($az[$pos].'4:'.$az[$pos].'5');

$objPHPExcel->getActiveSheet()->getStyle("B5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');


$valorinicial=5;
$cont=0;
//$objPHPExcel->getActiveSheet()->getStyle("A".$valorinicial.":O".$valorinicial)->getFont()->getColor()->setARGB("FFF0F0F0");  es para texto
foreach($control As $r){
$cont++;
$valorinicial++;
$paz=0;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$cont);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['cestado']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dcodlib']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dappape']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dapmape']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dnomper']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial," ".$r['telefono']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['email']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dcarrer']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['csemaca']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['cinicio']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['finicio']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dinstit']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['frecuencia']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['hora']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dfilial']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dmoding']);$paz++;

$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['certest']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['partnac']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['fotodni']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['nfotos']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dpais']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['tinstip']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dinstip']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dcarrep']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['ultanop']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dciclop']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['ddocval']);$paz++;

$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['fusuari']);$paz++;

}
$objPHPExcel->getActiveSheet()->getStyle("A6:AC".$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCECFF');
$objPHPExcel->getActiveSheet()->getStyle('A4:AC'.$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Documentos');
// Set active sheet index to the first sheet, so Excel opens this As the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Documentos_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>