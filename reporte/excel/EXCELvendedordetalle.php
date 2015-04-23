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
$azcount=array( 8,15,15,15,15,15,15,25,15,28,30,15,15,15,15,15,20,15,15,15,15,15,15,15,15,19,40,20,20,20,20,20,20,20,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$cusuari=$_GET['usuario'];
$alumno="";

$cfilial=str_replace(",","','",$_GET['cfilial']);
$cinstit=str_replace(",","','",$_GET['cinstit']);


$fechini=$_GET['fechini'];
$fechfin=$_GET['fechfin'];


$where='';
$order=" ORDER BY t.dtipcap,p.dappape ASC, p.dapmape ASC, p.dnomper ASC, p.cperson DESC";


$where=" WHERE g.cfilial in ('".$cfilial."') ";		 
$where.=" AND g.cinstit in ('".$cinstit."')
		  AND date(g.finicio) between '".$fechini."' and '".$fechfin."' 
		  AND  t.dclacap='2'
		  AND i.cpromot!='' ";



$sql="SELECT DISTINCT
		 p.dappape
		,p.dapmape
		,p.dnomper
		,ca.dcarrer
		,g.csemaca
		,g.cinicio
		,g.finicio
		,ins.dinstit
		,c.fmatric 
		,f2.dfilial as dfilial_po
		,c.sermatr
		,replace(i.dcodlib,'-','') As dcodlib 
		,(Select Concat(p2.dappape,' ',p2.dapmape,', ',p2.dnomper) From personm p2 Where p2.dlogper=po.cusuari limit 1) As cajero 
		,CONCAT(p.ntelper,' | ',p.ntelpe2) AS telefono
		,IF(i.cestado='1','Activo','Retirado') AS cestado
		,p.email1 AS email
		,(Select GROUP_CONCAT(d.dnemdia SEPARATOR '-') From diasm d Where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0) As frecuencia
		,concat(h.hinici,'-',h.hfin) As hora
		,f.dfilial
		,ifnull(pag_real_ins.monto,0) As pag_real_ins
		,ifnull(pag_real_mat.monto,0) As pag_real_mat
		,ifnull(pag_real_pen.monto,0) As pag_real_pen
		,ifnull(deu_real_mat.monto,0) As deu_real_mat
		,ifnull(deu_real_pen.monto,0) As deu_real_pen
		,t.dtipcap
		,t.dclacap
		,If(i.cpromot!='',(Select concat(v.dapepat,' ',v.dapemat,', ',v.dnombre,' | ',v.codintv) From vendedm v Where v.cvended=i.cpromot),
			If(i.cmedpre!='',(Select m.dmedpre From medprea m Where m.cmedpre=i.cmedpre limit 1),
				If(i.destica!='',i.destica,''))) As detalle_captacion,i.fusuari
	FROM personm p
		INNER JOIN ingalum i 	On (i.cperson  	= p.cperson)
		INNER  JOIN postulm po 	On (i.cingalu = po.cingalu)
		inner join filialm f2 on (po.cfilial=f2.cfilial) 
		INNER JOIN tipcapa t 	On (i.ctipcap  	= t.ctipcap)		
		INNER JOIN conmatp c 	On (i.cingalu  	= c.cingalu)
		INNER JOIN gracprp g 	On (c.cgruaca  	= g.cgracpr)
		INNER JOIN filialm f 	On (f.cfilial  	= g.cfilial)
		INNER JOIN horam h 		On (h.chora	   	= g.chora)
		INNER JOIN carrerm ca 	On (ca.ccarrer 	= g.ccarrer)
		INNER JOIN instita ins 	On (ins.cinstit	= g.cinstit)
		LEFT JOIN (	Select 
						 cingalu
						,cgruaca
						,sum(nmonrec) as monto
					From recacap
					Where cconcep IN (	Select cconcep
										From concepp
										Where cctaing like '708%')
					  And (cestpag = 'C'
					  OR (cdocpag!='' and testfin='S'))
					Group by cingalu, cgruaca
				)  pag_real_ins
			On pag_real_ins.cingalu = i.cingalu And pag_real_ins.cgruaca = c.cgruaca
		LEFT JOIN (	Select 
						 cingalu
						,cgruaca
						,sum(nmonrec) as monto
					From recacap
					Where cconcep IN (	Select cconcep
										From concepp
										Where cctaing like '701.01%')
					  And (cestpag = 'C'
					  OR (cdocpag!='' and testfin='S'))
					Group by cingalu, cgruaca
				)  pag_real_mat
			On pag_real_mat.cingalu = i.cingalu And pag_real_mat.cgruaca = c.cgruaca
		LEFT JOIN (	Select 
						 cingalu
						,cgruaca
						,sum(nmonrec) as monto
					From recacap
					Where cconcep IN (	Select cconcep
										From concepp
										Where cctaing like '701.03%')					  
					  And ccuota = '1'
					  And (cestpag = 'C'
					  OR (cdocpag!='' and testfin='S'))
					Group by cingalu, cgruaca
				)  pag_real_pen
			On pag_real_pen.cingalu = i.cingalu And pag_real_pen.cgruaca = c.cgruaca
		LEFT JOIN (	Select 
						 cingalu
						,cgruaca
						,sum(nmonrec) as monto
					From recacap
					Where cconcep IN (	Select cconcep
										From concepp
										Where cctaing like '701.01%')
					  And cestpag = 'P'
					Group by cingalu, cgruaca
				)  deu_real_mat
			On deu_real_mat.cingalu = i.cingalu And deu_real_mat.cgruaca = c.cgruaca
		LEFT JOIN (	Select 
						 cingalu
						,cgruaca
						,sum(nmonrec) as monto
					From recacap
					Where cconcep IN (	Select cconcep
										From concepp
										Where cctaing like '701.03%')
					  And cestpag = 'P'
					  And ccuota = '1'
					Group by cingalu, cgruaca
				)  deu_real_pen
			On deu_real_pen.cingalu = i.cingalu And deu_real_pen.cgruaca = c.cgruaca
 ".$where."
 ".$order;
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

$cabecera=array('N°','MEDIO CAPTACION','RESPONSABLE CAPTACION','CODIGO RESPONSABLE CAPTACION','LIBRO DE CODIGO','APELL PATERNO','APELL MATERNO','NOMBRES','TEL FIJO / CELULAR','CARRERA','INSTITUCION','LOCAL DE ESTUDIOS','INSCRIPCION','MATRIC','PENSION','MATRIC','PENSION','DEUDA TOTAL');

	for($i=0;$i<count($cabecera);$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."5",$cabecera[$i]);
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."5")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}
$objPHPExcel->getActiveSheet()->getStyle('A4:'.$az[($i)].'5')->applyFromArray($styleAlignmentBold);


$pos=1;
$objPHPExcel->getActiveSheet()->setCellValue($az[$pos]."4","VENDEDOR");
$objPHPExcel->getActiveSheet()->getStyle($az[($pos-1)]."4:".$az[($pos+2)]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF6699');
$objPHPExcel->getActiveSheet()->mergeCells($az[$pos].'4:'.$az[($pos+2)].'4');$pos+=3;

$objPHPExcel->getActiveSheet()->setCellValue($az[$pos]."4","DATOS BASICOS DEL ALUMNO");
$objPHPExcel->getActiveSheet()->getStyle($az[$pos]."4:".$az[($pos+7)]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCFFFF');
$objPHPExcel->getActiveSheet()->mergeCells($az[$pos].'4:'.$az[($pos+7)].'4');$pos+=8;

$posini=$pos;
$objPHPExcel->getActiveSheet()->setCellValue($az[$pos]."4","PAGOS REALIZADOS");
$objPHPExcel->getActiveSheet()->mergeCells($az[$pos].'4:'.$az[($pos+2)].'4');$pos+=3;

$objPHPExcel->getActiveSheet()->setCellValue($az[$pos]."4","PAGOS X REALIZAR");
$objPHPExcel->getActiveSheet()->mergeCells($az[$pos].'4:'.$az[($pos+1)].'4');$pos+=2;

$objPHPExcel->getActiveSheet()->setCellValue($az[$pos]."4","DEUDA TOTAL");
$objPHPExcel->getActiveSheet()->mergeCells($az[$pos].'4:'.$az[$pos].'5');$pos+=1;

$objPHPExcel->getActiveSheet()->getStyle($az[$posini]."4:".$az[($pos-1)]."5")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF6699');



$valorinicial=5;
$cont=0;
//$objPHPExcel->getActiveSheet()->getStyle("A".$valorinicial.":O".$valorinicial)->getFont()->getColor()->setARGB("FFF0F0F0");  es para texto
foreach($control As $r){
$cont++;
$valorinicial++;
$paz=0;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$cont);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dtipcap']);$paz++;
$detcap=explode("|",$r['detalle_captacion']);
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$detcap[0]);$paz++;

	if(count($detcap)>0){
		$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$detcap[1]);
	}$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dcodlib']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dappape']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dapmape']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dnomper']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial," ".$r['telefono']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dcarrer']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dinstit']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['dfilial']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['pag_real_ins']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['pag_real_mat']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['pag_real_pen']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['deu_real_mat']);$paz++;
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$r['deu_real_pen']);$paz++;
$totdeuda = $r['deu_real_mat'] + $r['deu_real_pen'];
$objPHPExcel->getActiveSheet()->setCellValue($az[$paz].$valorinicial,$totdeuda);$paz++;

}
$objPHPExcel->getActiveSheet()->getStyle("A6:".$az[($paz-1)].$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCECFF');
$objPHPExcel->getActiveSheet()->getStyle('A4:'.$az[($paz-1)].$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);

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