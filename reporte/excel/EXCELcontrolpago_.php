<?php
/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
$azcount=array(5,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$cingalu=$_GET['cingalu'];
$cgracpr=$_GET['cgracpr'];
$alumno="";
if($cingalu!=""){
$alumno=" AND c.cingalu='".$cingalu."'";
}


$sql="SELECT f.dfilial,c.sermatr,i.dcodlib,p.dappape,p.dapmape,p.dnomper,p.fnacper,
if(p.coddpto>0,(select dep.nombre from ubigeo dep where dep.coddpto=p.coddpto and dep.codprov=0 and dep.coddist=0),'') as prov,
if(p.codprov>0,(select pro.nombre from ubigeo pro where pro.coddpto=p.coddpto and pro.codprov=p.codprov and pro.coddist=0),'') as depa,
if(p.coddist>0,(select dis.nombre from ubigeo dis where dis.coddpto=p.coddpto and dis.codprov=p.codprov and dis.coddist=p.coddist),'') as dist,
if(p.tsexo='F','Femenino','Masculino') as sexo,
p.tipdocper,p.ndniper,'Soltero' as estadoa,p.ddirper,p.ddirref,p.ntelper as tel,p.ntelpe2 as cel,p.email1,p.dcolpro,
if(p.tcolegi='1','Nacional',
		if(p.tcolegi='2','Particular',
			if(p.tcolegi='3','Parroquia',
				if(p.tcolegi='4','FFAA',
					if(p.tcolegi='5','FFPP','')
				)
			)
		)
) as tipo_colegio,f2.dfilial as dfilial_est,g.csemaca,g.cinicio,g.finicio,ca.dcarrer,t.dtipcap,
if(i.cpromot!='',(select concat(v.dapepat,' ',v.dapemat,', ',v.dnombre) 
									from vendedm v 
									where v.cvended=i.cpromot),
	if(i.cmedpre!='',(select m.dmedpre 
								 from medprea m
								 where m.cmedpre=i.cmedpre limit 1),
		if(i.destica!='',i.destica,'')
	)
) as detalle_captacion,tu.dturno,
(select concat(con.ncuotas,'C-',con.nprecio)
from concepp con
where FIND_IN_SET (con.cconcep,GROUP_CONCAT(DISTINCT(r.cconcep)))  >  0 
and con.cctaing like '701.03%') as pago_pension,
(select GROUP_CONCAT(
				IF(rr.testfin='C',
			  	IF(rr.tdocpag='B',(select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) from boletap b where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) from vouchep v inner join bancosm b on (v.cbanco=b.cbanco) where v.cvouche=rr.cdocpag),''
						)
					)
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' )
from recacap rr 
INNER JOIN concepp co on (co.cconcep=rr.cconcep)
where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
and co.cctaing like '708%'
and rr.testfin in ('C','P')
GROUP BY rr.cingalu,rr.cgruaca
) as inscripcion,
(select GROUP_CONCAT(
				IF(rr.testfin='C',
			  	IF(rr.tdocpag='B',(select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) from boletap b where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) from vouchep v inner join bancosm b on (v.cbanco=b.cbanco) where v.cvouche=rr.cdocpag),''
						)
					)
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' )
from recacap rr 
INNER JOIN concepp co on (co.cconcep=rr.cconcep)
where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
and (co.cctaing like '701.01%' or co.cctaing like '701.02%')
and rr.testfin in ('C','P')
GROUP BY rr.cingalu,rr.cgruaca
) as matricula,
(select GROUP_CONCAT(
				IF(rr.testfin='C',
			  	IF(rr.tdocpag='B',(select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) from boletap b where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) from vouchep v inner join bancosm b on (v.cbanco=b.cbanco) where v.cvouche=rr.cdocpag),''
						)
					)
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' )
from recacap rr 
INNER JOIN concepp co on (co.cconcep=rr.cconcep)
where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
and co.cctaing like '701.03%'
and rr.ccuota='1'
and rr.testfin in ('C','P')
GROUP BY rr.cingalu,rr.cgruaca
) as p1,
(select GROUP_CONCAT(
				IF(rr.testfin='C',
			  	IF(rr.tdocpag='B',(select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) from boletap b where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) from vouchep v inner join bancosm b on (v.cbanco=b.cbanco) where v.cvouche=rr.cdocpag),''
						)
					)
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' )
from recacap rr 
INNER JOIN concepp co on (co.cconcep=rr.cconcep)
where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
and co.cctaing like '701.03%'
and rr.ccuota='2'
and rr.testfin in ('C','P')
GROUP BY rr.cingalu,rr.cgruaca
) as p2,
(select GROUP_CONCAT(
				IF(rr.testfin='C',
			  	IF(rr.tdocpag='B',(select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) from boletap b where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) from vouchep v inner join bancosm b on (v.cbanco=b.cbanco) where v.cvouche=rr.cdocpag),''
						)
					)
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' )
from recacap rr 
INNER JOIN concepp co on (co.cconcep=rr.cconcep)
where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
and co.cctaing like '701.03%'
and rr.ccuota='3'
and rr.testfin in ('C','P')
GROUP BY rr.cingalu,rr.cgruaca
) as p3,
(select GROUP_CONCAT(
				IF(rr.testfin='C',
			  	IF(rr.tdocpag='B',(select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) from boletap b where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) from vouchep v inner join bancosm b on (v.cbanco=b.cbanco) where v.cvouche=rr.cdocpag),''
						)
					)
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' )
from recacap rr 
INNER JOIN concepp co on (co.cconcep=rr.cconcep)
where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
and co.cctaing like '701.03%'
and rr.ccuota='4'
and rr.testfin in ('C','P')
GROUP BY rr.cingalu,rr.cgruaca
) as p4,
(select GROUP_CONCAT(
				IF(rr.testfin='C',
			  	IF(rr.tdocpag='B',(select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) from boletap b where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) from vouchep v inner join bancosm b on (v.cbanco=b.cbanco) where v.cvouche=rr.cdocpag),''
						)
					)
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' )
from recacap rr 
INNER JOIN concepp co on (co.cconcep=rr.cconcep)
where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
and co.cctaing like '701.03%'
and rr.ccuota='5'
and rr.testfin in ('C','P')
GROUP BY rr.cingalu,rr.cgruaca
) as p5
from personm p
INNER JOIN ingalum i on (i.cperson=p.cperson)
inner join filialm f on (f.cfilial=i.cfilial)
INNER JOIN tipcapa t on (i.ctipcap=t.ctipcap)
INNER JOIN conmatp c on (i.cingalu=c.cingalu)
INNER JOIN gracprp g on (c.cgruaca=g.cgracpr)
INNER JOIN turnoa tu on (tu.cturno=g.cturno)
INNER JOIN carrerm ca on (ca.ccarrer=g.ccarrer)
inner join filialm f2 on (f2.cfilial=g.cfilial)
inner JOIN recacap r on (r.cingalu=c.cingalu and r.cgruaca=c.cgruaca)
where c.cgruaca in ('".str_replace(",","','",$cgracpr)."')
 ".$alumno."
GROUP BY c.cingalu,c.cgruaca
order by p.cperson desc";
$cn->setQuery($sql);
$control=$cn->loadObjectList();
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

$cabecera=array('N°','CAJA CENTRO\nCAPTACIÓN','CAJERO','FICHA MATRIC Y/O RATIF','LIBRO DE CODIGO','AP_PATERNO','AP_MATERNO','NOMBRES','FECHA DE NACIMIENTO','"DEPARTAMENTO','PROVINCIA','DISTRITO','GENERO','TIPO DOCUMENTO','NRO DOCUMENTO','ESTADO CIVIL','DIRECCIÓN',	'URBANIZACION','DISTRITO','PROVINCIA','DEPARTAMENTO','REFERENCIA','TELEFONO','CELULAR','CORREO ELECTRONICO','COLEGIO DE PROCEDENCIA','REGIMEN','DIRECCION COLEGIO','LOCAL DE ESTUDIO','SEMESTRE','INICIO','FECHA DE INCIO','CARRERA','MEDIO DE INFORMACION','TURNO','ESCALA','FECHA_ADM','NRO B/V_ADM','MONTO_ADM','FECHA_MAT1','NRO B/V_MAT1','MONTO_MAT1','FECHA_MAT2','NRO B/V_MAT2','MONTO_MAT2','FECHA_1CUOTA','NRO B/V_1CUOTA','MONTO_1CUOTA','FECHA_1CUOTA','NRO B/V_1CUOTA','MONTO_1CUOTA','NOTA 1','NOTA 2','PROM','FECHA_2CUOTA','NRO B/V_2CUOTA','MONTO_2CUOTA','FECHA_2CUOTA','NRO B/V_2CUOTA','MONTO_2CUOTA','NOTA 1','NOTA 2','PROM','FECHA_3CUOTA','NRO B/V_3CUOTA','MONTO_3CUOTA','FECHA_3CUOTA','NRO B/V_3CUOTA','MONTO_3CUOTA','NOTA 1','NOTA 2','PROM','FECHA_4CUOTA','NRO B/V_4CUOTA','MONTO_4CUOTA','FECHA_4CUOTA','NRO B/V_4CUOTA','MONTO_4CUOTA','NOTA 1','NOTA 2','PROM','FECHA_5CUOTA','NRO B/V_5CUOTA','MONTO_5CUOTA','FECHA_5CUOTA','NRO B/V_5CUOTA','MONTO_5CUOTA','NOTA 1','NOTA 2','PROM','FECHA','NRO B/V','MONTO','FECHA','NRO B/V','MONTO','FECHA','NRO B/V','MONTO',"TOTAL\nINSCRIPCION","TOTAL\nMATRÍCULA","TOTAL\nPENSIÓN","TOTAL\nA PAGAR","MONTO\nPAGADO","DEUDA\nINSCRIPCION","DEUDA\nMATRÍCULA","DEUDA\nPENSIÓN","DEUDA\nTOTAL","DEUDA HASTA\nHOY ".date("Y-m-d"),'CONDICION','ESTADO DEL ALUMNO','OBSERVACION');

	for($i=0;$i<count($cabecera);$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."2",$cabecera[$i]);
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."2")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$az[($i-1)].'2')->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->setCellValue("A1","DATOS PERSONALES");
$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
$objPHPExcel->getActiveSheet()->setCellValue("P1","DATOS DOMICILIARIO");
$objPHPExcel->getActiveSheet()->mergeCells('P1:AA1');
$objPHPExcel->getActiveSheet()->setCellValue("AB1","CARRERA PROFESIONAL A LA QUE POSTULA");
$objPHPExcel->getActiveSheet()->mergeCells('AB1:AI1');
$objPHPExcel->getActiveSheet()->setCellValue("AJ1","INSCRIPCION");
$objPHPExcel->getActiveSheet()->mergeCells('AJ1:AL1');
$objPHPExcel->getActiveSheet()->setCellValue("AM1","DERECHO DE MATRICULA");
$objPHPExcel->getActiveSheet()->mergeCells('AM1:AR1');
$objPHPExcel->getActiveSheet()->setCellValue("AS1","PRIMERA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('AS1:AX1');
$objPHPExcel->getActiveSheet()->setCellValue("BB1","SEGUNDA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('BB1:BG1');
$objPHPExcel->getActiveSheet()->setCellValue("BK1","TERCERA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('BK1:BP1');
$objPHPExcel->getActiveSheet()->setCellValue("BT1","CUARTA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('BT1:BY1');
$objPHPExcel->getActiveSheet()->setCellValue("CC1","QUINTA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('CC1:CH1');

$objPHPExcel->getActiveSheet()->setCellValue("CL1","PAGO PARA CONVALIDACIÓN");
$objPHPExcel->getActiveSheet()->mergeCells('CL1:CQ1');
$objPHPExcel->getActiveSheet()->setCellValue("CR1","PAGO CARNET");
$objPHPExcel->getActiveSheet()->mergeCells('CR1:CT1');
$objPHPExcel->getActiveSheet()->setCellValue("CU1","DATOS ESTADISTICOS");
$objPHPExcel->getActiveSheet()->mergeCells('CU1:DG1');


$objPHPExcel->getActiveSheet()->getStyle("A1:O2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC65911');
$objPHPExcel->getActiveSheet()->getStyle("P1:AA2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8EA9DB');
$objPHPExcel->getActiveSheet()->getStyle("AB1:AI2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92D050');
$objPHPExcel->getActiveSheet()->getStyle("AJ1:CT2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF3399FF');
$objPHPExcel->getActiveSheet()->getStyle("AJ1:CT2")->getFont()->getColor()->setARGB("FFF0F0F0");

$objPHPExcel->getActiveSheet()->setCellValue("AY1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("AY1:BA1");
$objPHPExcel->getActiveSheet()->getStyle("AY1:BA2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("AY1:BA2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("BH1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("BH1:BJ1");
$objPHPExcel->getActiveSheet()->getStyle("BH1:BJ2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("BH1:BJ2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("BQ1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("BQ1:BS1");
$objPHPExcel->getActiveSheet()->getStyle("BQ1:BS2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("BQ1:BS2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("BZ1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("BZ1:CB1");
$objPHPExcel->getActiveSheet()->getStyle("BZ1:CB2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("BZ1:CB2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("CI1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("CI1:CK1");
$objPHPExcel->getActiveSheet()->getStyle("CI1:CK2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("CI1:CK2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("AY1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("AY1:BA1");
$objPHPExcel->getActiveSheet()->getStyle("AY1:BA2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("AY1:BA2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->getStyle("CU1:DG2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF3399');


//$objPHPExcel->getActiveSheet()->getStyle('A2:'.$az[($i-1)].'2')->applyFromArray($styleColor);

$valorinicial=2;
$cont=0;
//$objPHPExcel->getActiveSheet()->getStyle("A".$valorinicial.":O".$valorinicial)->getFont()->getColor()->setARGB("FFF0F0F0");  es para texto
foreach($control as $r){
$cont++;
$valorinicial++;
$objPHPExcel->getActiveSheet()->setCellValue("A".$valorinicial,$cont);
$objPHPExcel->getActiveSheet()->setCellValue("B".$valorinicial,$r['dfilial']);
$objPHPExcel->getActiveSheet()->setCellValue("C".$valorinicial,$r['sermatr']);
$objPHPExcel->getActiveSheet()->setCellValue("D".$valorinicial,$r['dcodlib']);
$objPHPExcel->getActiveSheet()->setCellValue("E".$valorinicial,$r['dappape']);
$objPHPExcel->getActiveSheet()->setCellValue("F".$valorinicial,$r['dapmape']);
$objPHPExcel->getActiveSheet()->setCellValue("G".$valorinicial,$r['dnomper']);
$objPHPExcel->getActiveSheet()->setCellValue("H".$valorinicial,$r['fnacper']);
$objPHPExcel->getActiveSheet()->setCellValue("I".$valorinicial,$r['depa']);
$objPHPExcel->getActiveSheet()->setCellValue("J".$valorinicial,$r['prov']);
$objPHPExcel->getActiveSheet()->setCellValue("K".$valorinicial,$r['dist']);
$objPHPExcel->getActiveSheet()->setCellValue("L".$valorinicial,$r['sexo']);
$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial,$r['tipdocper']);
$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial,$r['ndniper']);
$objPHPExcel->getActiveSheet()->setCellValue("O".$valorinicial,$r['estadoa']);

//cambio de color
$objPHPExcel->getActiveSheet()->setCellValue("P".$valorinicial,$r['ddirper']);
$objPHPExcel->getActiveSheet()->setCellValue("Q".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("R".$valorinicial,$r['dist']);
$objPHPExcel->getActiveSheet()->setCellValue("S".$valorinicial,$r['prov']);
$objPHPExcel->getActiveSheet()->setCellValue("T".$valorinicial,$r['depa']);
$objPHPExcel->getActiveSheet()->setCellValue("U".$valorinicial,$r['ddirref']);
$objPHPExcel->getActiveSheet()->setCellValue("V".$valorinicial,$r['tel']);
$objPHPExcel->getActiveSheet()->setCellValue("W".$valorinicial,$r['cel']);
$objPHPExcel->getActiveSheet()->setCellValue("X".$valorinicial,$r['email1']);
$objPHPExcel->getActiveSheet()->setCellValue("Y".$valorinicial,$r['dcolpro']);
$objPHPExcel->getActiveSheet()->setCellValue("Z".$valorinicial,$r['tipo_colegio']);
$objPHPExcel->getActiveSheet()->setCellValue("AA".$valorinicial,'');
//cambio de color
$objPHPExcel->getActiveSheet()->setCellValue("AB".$valorinicial,$r['dfilial_est']);
$objPHPExcel->getActiveSheet()->setCellValue("AC".$valorinicial,$r['csemaca']);
$objPHPExcel->getActiveSheet()->setCellValue("AD".$valorinicial,$r['cinicio']);
$objPHPExcel->getActiveSheet()->setCellValue("AE".$valorinicial,$r['finicio']);
$objPHPExcel->getActiveSheet()->setCellValue("AF".$valorinicial,$r['dcarrer']);
$objPHPExcel->getActiveSheet()->setCellValue("AG".$valorinicial,$r['dtipcap'].": ".$r['detalle_captacion']);
$objPHPExcel->getActiveSheet()->setCellValue("AH".$valorinicial,$r['dturno']);
$objPHPExcel->getActiveSheet()->setCellValue("AI".$valorinicial,$r['pago_pension']);
//cambio de color
$inscripcion=explode("^^",$r['inscripcion']);
$fecha="";
$monto="";
$nro="";
$deudains=0;
$pagoins=0;
$deudaalumno=0;
$pagoalumno=0;
$deudafecha=0;
$contadoringresos=0;
	for($i=0;$i<count($inscripcion);$i++){
		$d=explode("|",$inscripcion[$i]);
		$br="";
		if(count($d)>1){
			if($contadoringresos>0){
			$br="|\n";
			}
		$fecha.=$br.$d[2];
		$monto.=$br.$d[1];
		$nro.=$br.$d[0];
		$contadoringresos++;
		$pagoalumno+=$d[1];
		$pagoins+=$d[1];
		}
		else{
		$d=explode("_",$inscripcion[$i]);
		$deudains+=$d[0];
			if($d[1]<=date("Y-m-d")){
			$deudafecha+=$d[0];
			}
		}
	}
	$deudaalumno+=$deudains;

$objPHPExcel->getActiveSheet()->setCellValue("AJ".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("AK".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("AL".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->getStyle("AJ".$valorinicial.":AL".$valorinicial)->getAlignment()->setWrapText(true);

$matricula=explode("^^",$r['matricula']);	
$fecha="";
$monto="";
$nro="";
$fecha2="";
$monto2="";
$nro2="";
$deudamat=0;
$pagomat=0;
$contadoringresos=0;
	for($i=0;$i<count($matricula);$i++){
		$d=explode("|",$matricula[$i]);
		$br="";
		if(count($d)>1){
			if($contadoringresos>1){
			$br="|\n";
			}
			if($contadoringresos==0){
			$fecha.=$br.$d[2];
			$monto.=$br.$d[1];
			$nro.=$br.$d[0];
			}
			else{
			$fecha2.=$br.$d[2];
			$monto2.=$br.$d[1];
			$nro2.=$br.$d[0];
			}
		$pagoalumno+=$d[1];
		$pagomat+=$d[1];
		$contadoringresos++;
		}
		else{
		$d=explode("_",$matricula[$i]);
		$deudamat+=$d[0];
			if($d[1]<=date("Y-m-d")){
			$deudafecha+=$d[0];
			}		
		}
	}
	$deudaalumno+=$deudamat;	

$objPHPExcel->getActiveSheet()->setCellValue("AM".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("AN".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("AO".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("AP".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("AQ".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("AR".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("AM".$valorinicial.":AR".$valorinicial)->getAlignment()->setWrapText(true);

$p=explode("^^",$r['p1']);	
$fecha="";
$monto="";
$nro="";
$fecha2="";
$monto2="";
$nro2="";
$deudap1=0;
$pagop1=0;
$contadoringresos=0;
	for($i=0;$i<count($p);$i++){
		$d=explode("|",$p[$i]);
		$br="";
		if(count($d)>1){
			if($contadoringresos>1){
			$br="|\n";
			}
			if($contadoringresos==0){
			$fecha.=$br.$d[2];
			$monto.=$br.$d[1];
			$nro.=$br.$d[0];
			}
			else{
			$fecha2.=$br.$d[2];
			$monto2.=$br.$d[1];
			$nro2.=$br.$d[0];
			}
		$pagoalumno+=$d[1];
		$pagop1+=$d[1];
		$contadoringresos++;
		}
		else{
		$d=explode("_",$p[$i]);
		$deudap1+=$d[0];
			if($d[1]<=date("Y-m-d")){
			$deudafecha+=$d[0];
			}
		}
	}
	$deudaalumno+=$deudap1;	

$objPHPExcel->getActiveSheet()->setCellValue("AS".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("AT".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("AU".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("AV".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("AW".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("AX".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("AS".$valorinicial.":AX".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("AY".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("AZ".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("BA".$valorinicial,'');

$p=explode("^^",$r['p2']);	
$fecha="";
$monto="";
$nro="";
$fecha2="";
$monto2="";
$nro2="";
$deudap2=0;
$pagop2=0;
$contadoringresos=0;
	for($i=0;$i<count($p);$i++){
		$d=explode("|",$p[$i]);
		$br="";
		if(count($d)>1){
			if($contadoringresos>1){
			$br="|\n";
			}
			if($contadoringresos==0){
			$fecha.=$br.$d[2];
			$monto.=$br.$d[1];
			$nro.=$br.$d[0];
			}
			else{
			$fecha2.=$br.$d[2];
			$monto2.=$br.$d[1];
			$nro2.=$br.$d[0];
			}
		$pagoalumno+=$d[1];
		$pagop2+=$d[1];
		$contadoringresos++;
		}
		else{
		$d=explode("_",$p[$i]);
		$deudap2+=$d[0];
			if($d[1]<=date("Y-m-d")){
			$deudafecha+=$d[0];
			}
		}
	}
	$deudaalumno+=$deudap2;

$objPHPExcel->getActiveSheet()->setCellValue("BB".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("BC".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("BD".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("BE".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("BF".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("BG".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("BB".$valorinicial.":BG".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("BH".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("BI".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("BJ".$valorinicial,'');

$p=explode("^^",$r['p3']);	
$fecha="";
$monto="";
$nro="";
$fecha2="";
$monto2="";
$nro2="";
$deudap3=0;
$pagop3=0;
$contadoringresos=0;
	for($i=0;$i<count($p);$i++){
		$d=explode("|",$p[$i]);
		$br="";
		if(count($d)>1){
			if($contadoringresos>1){
			$br="|\n";
			}
			if($contadoringresos==0){
			$fecha.=$br.$d[2];
			$monto.=$br.$d[1];
			$nro.=$br.$d[0];
			}
			else{
			$fecha2.=$br.$d[2];
			$monto2.=$br.$d[1];
			$nro2.=$br.$d[0];
			}
		$pagoalumno+=$d[1];
		$pagop3+=$d[1];
		$contadoringresos++;
		}
		else{
		$d=explode("_",$p[$i]);
		$deudap3+=$d[0];
			if($d[1]<=date("Y-m-d")){
			$deudafecha+=$d[0];
			}
		}
	}
	$deudaalumno+=$deudap3;

$objPHPExcel->getActiveSheet()->setCellValue("BK".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("BL".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("BM".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("BN".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("BO".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("BP".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("BK".$valorinicial.":BP".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("BQ".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("BR".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("BS".$valorinicial,'');

$p=explode("^^",$r['p4']);	
$fecha="";
$monto="";
$nro="";
$fecha2="";
$monto2="";
$nro2="";
$deudap4=0;
$pagop4=0;
$contadoringresos=0;
	for($i=0;$i<count($p);$i++){
		$d=explode("|",$p[$i]);
		$br="";
		if(count($d)>1){
			if($contadoringresos>1){
			$br="|\n";
			}
			if($contadoringresos==0){
			$fecha.=$br.$d[2];
			$monto.=$br.$d[1];
			$nro.=$br.$d[0];
			}
			else{
			$fecha2.=$br.$d[2];
			$monto2.=$br.$d[1];
			$nro2.=$br.$d[0];
			}
		$pagoalumno+=$d[1];
		$pagop4+=$d[1];
		$contadoringresos++;
		}
		else{
		$d=explode("_",$p[$i]);
		$deudap4+=$d[0];
			if($d[1]<=date("Y-m-d")){
			$deudafecha+=$d[0];
			}
		}
	}
	$deudaalumno+=$deudap4;

$objPHPExcel->getActiveSheet()->setCellValue("BT".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("BU".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("BV".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("BW".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("BX".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("BY".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("BT".$valorinicial.":BY".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("BZ".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CA".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CB".$valorinicial,'');

$p=explode("^^",$r['p5']);	
$fecha="";
$monto="";
$nro="";
$fecha2="";
$monto2="";
$nro2="";
$deudap5=0;
$pagop5=0;
$contadoringresos=0;
	for($i=0;$i<count($p);$i++){
		$d=explode("|",$p[$i]);
		$br="";
		if(count($d)>1){
			if($contadoringresos>1){
			$br="|\n";
			}
			if($contadoringresos==0){
			$fecha.=$br.$d[2];
			$monto.=$br.$d[1];
			$nro.=$br.$d[0];
			}
			else{
			$fecha2.=$br.$d[2];
			$monto2.=$br.$d[1];
			$nro2.=$br.$d[0];
			}
		$pagoalumno+=$d[1];
		$pagop5+=$d[1];
		$contadoringresos++;
		}
		else{
		$d=explode("_",$p[$i]);
		$deudap5+=$d[0];
			if($d[1]<=date("Y-m-d")){
			$deudafecha+=$d[0];
			}
		}
	}
	$deudaalumno+=$deudap5;

$objPHPExcel->getActiveSheet()->setCellValue("CC".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("CD".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("CE".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("CF".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("CG".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("CH".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("CC".$valorinicial.":CH".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("CI".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CJ".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CK".$valorinicial,'');
$total=$deudaalumno+$pagoalumno;
$totalins=$deudains+$pagoins;
$totalmat=$deudamat+$pagomat;
$totalpen=$deudap1+$pagop1;
$totalpen+=$deudap2+$pagop2;
$totalpen+=$deudap3+$pagop3;
$totalpen+=$deudap4+$pagop4;
$totalpen+=$deudap5+$pagop5;
$deudapen=$deudap1+$deudap2+$deudap3+$deudap4+$deudap5;
$objPHPExcel->getActiveSheet()->setCellValue("CU".$valorinicial,$totalins);
$objPHPExcel->getActiveSheet()->setCellValue("CV".$valorinicial,$totalmat);
$objPHPExcel->getActiveSheet()->setCellValue("CW".$valorinicial,$totalpen);
$objPHPExcel->getActiveSheet()->setCellValue("CX".$valorinicial,$total);
$objPHPExcel->getActiveSheet()->setCellValue("CY".$valorinicial,$pagoalumno);
$objPHPExcel->getActiveSheet()->setCellValue("CZ".$valorinicial,$deudains);
$objPHPExcel->getActiveSheet()->setCellValue("DA".$valorinicial,$deudamat);
$objPHPExcel->getActiveSheet()->setCellValue("DB".$valorinicial,$deudapen);
$objPHPExcel->getActiveSheet()->setCellValue("DC".$valorinicial,$deudaalumno);
$objPHPExcel->getActiveSheet()->setCellValue("DD".$valorinicial,$deudafecha);
$condicion="PAGANTE";
$pintar="FF99FF99";
if($deudafecha>0){
$pintar="FFFF7272";
$condicion="DEUDOR";
}
$objPHPExcel->getActiveSheet()->setCellValue("DE".$valorinicial,$condicion);
$objPHPExcel->getActiveSheet()->getStyle("DE".$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($pintar);
$objPHPExcel->getActiveSheet()->setCellValue("DF".$valorinicial,'ACTIVO');
$objPHPExcel->getActiveSheet()->setCellValue("DG".$valorinicial,'');

}
$objPHPExcel->getActiveSheet()->getStyle('A1:DG'.$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Control_Pago');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ControlPago_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>