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
(	select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
	from diasm d 
	where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0) as frecuencia,concat(h.hinici,' - ',h.hfin) as hora,
(select concat(ve.dapepat,' ',ve.dapemat,', ',ve.dnombre,'|',ve.demail,'|',ve.dtelefo) 
 from vendedm ve 
 where ve.cvended=po.crecepc) as recepcionista,
(select concat(p2.dappape,' ',p2.dapmape,', ',p2.dnomper) from personm p2 where p2.dlogper=po.cusuari limit 1) as cajero,po.cusuari,
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
) as p5,ins.dinstit,i.posbeca,m.dmoding,ins.cmodali,ci.dciclo,concat(i.certest,'\n',i.partnac,'\n',i.otrodni) as documentos,i.ddocval
from personm p
INNER JOIN ingalum i on (i.cperson=p.cperson)
LEFT JOIN postulm po on (po.cperson=p.cperson and i.cingalu=po.cingalu)
inner join filialm f on (f.cfilial=po.cfilial)
INNER JOIN tipcapa t on (i.ctipcap=t.ctipcap)
INNER JOIN conmatp c on (i.cingalu=c.cingalu)
INNER JOIN gracprp g on (c.cgruaca=g.cgracpr)
INNER JOIN turnoa tu on (tu.cturno=g.cturno)
INNER JOIN cicloa ci on (ci.cciclo=g.cciclo)
INNER JOIN horam h on (h.chora=g.chora)
INNER JOIN carrerm ca on (ca.ccarrer=g.ccarrer)
inner join filialm f2 on (f2.cfilial=g.cfilial)
INNER JOIN instita ins on (ins.cinstit=g.cinstit)
INNER JOIN modinga m on (m.cmoding=i.cmoding)
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




$cabecera=array('N°','CAJA CENTRO\nCAPTACIÓN','CAJERO QUE\nINSCRIBE','FICHA MATRIC Y/O RATIF','LIBRO DE CODIGO','AP_PATERNO','AP_MATERNO','NOMBRES','FECHA DE NACIMIENTO','"DEPARTAMENTO','PROVINCIA','DISTRITO','GENERO','TIPO DOCUMENTO','NRO DOCUMENTO','ESTADO CIVIL','DIRECCIÓN',	'URBANIZACION','DISTRITO','PROVINCIA','DEPARTAMENTO','REFERENCIA','TELEFONO','CELULAR','CORREO ELECTRONICO','COLEGIO DE PROCEDENCIA','REGIMEN','DIRECCION COLEGIO','INSTITUCION','SOLO POR BECA','MOD INGRE','CARRERA PROFESIONAL','SEMESTRE','INICIO','FECHA INICIO','MODAL','CICLO/MODULO','DURACION','LOCAL DE ESTUDIO','FRECUENCIA','HORARIO','INSCRIPCION','MATRICULA O RATIF','PENSION','MEDIO DE CAPTACION','RESPONSABLE DE CAPTACION','TELEFONO','E-MAIL','RECEPCIONISTA','DOCUMENTOS ENTREGADOS -ORDINARIO','DOCUME ENTRE CONVALIDA','FECHA_ADM','NRO B/V_ADM','MONTO_ADM','FECHA_MAT1','NRO B/V_MAT1','MONTO_MAT1','FECHA_MAT2','NRO B/V_MAT2','MONTO_MAT2','FECHA_1CUOTA','NRO B/V_1CUOTA','MONTO_1CUOTA','FECHA_1CUOTA','NRO B/V_1CUOTA','MONTO_1CUOTA','NOTA 1','NOTA 2','PROM','FECHA_2CUOTA','NRO B/V_2CUOTA','MONTO_2CUOTA','FECHA_2CUOTA','NRO B/V_2CUOTA','MONTO_2CUOTA','NOTA 1','NOTA 2','PROM','FECHA_3CUOTA','NRO B/V_3CUOTA','MONTO_3CUOTA','FECHA_3CUOTA','NRO B/V_3CUOTA','MONTO_3CUOTA','NOTA 1','NOTA 2','PROM','FECHA_4CUOTA','NRO B/V_4CUOTA','MONTO_4CUOTA','FECHA_4CUOTA','NRO B/V_4CUOTA','MONTO_4CUOTA','NOTA 1','NOTA 2','PROM','FECHA_5CUOTA','NRO B/V_5CUOTA','MONTO_5CUOTA','FECHA_5CUOTA','NRO B/V_5CUOTA','MONTO_5CUOTA','NOTA 1','NOTA 2','PROM','FECHA','NRO B/V','MONTO','FECHA','NRO B/V','MONTO','FECHA','NRO B/V','MONTO',"TOTAL\nINSCRIPCION","TOTAL\nMATRÍCULA","TOTAL\nPENSIÓN","TOTAL\nA PAGAR","MONTO\nPAGADO","DEUDA\nINSCRIPCION","DEUDA\nMATRÍCULA","DEUDA\nPENSIÓN","DEUDA\nTOTAL","DEUDA HASTA\nHOY ".date("Y-m-d"),'CONDICION','ESTADO DEL ALUMNO','OBSERVACION');

	for($i=0;$i<count($cabecera);$i++){
	$objPHPExcel->getActiveSheet()->setCellValue($az[$i]."2",$cabecera[$i]);
	$objPHPExcel->getActiveSheet()->getStyle($az[$i]."2")->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension($az[$i])->setWidth($azcount[$i]);
	}
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$az[($i-1)].'2')->applyFromArray($styleAlignmentBold);

$objPHPExcel->getActiveSheet()->setCellValue("A1","DATOS DE IDENTIFICACION");
$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
$objPHPExcel->getActiveSheet()->setCellValue("F1","DATOS PERSONALES");
$objPHPExcel->getActiveSheet()->mergeCells('F1:P1');
$objPHPExcel->getActiveSheet()->setCellValue("Q1","DATOS DOMICILIARIO");
$objPHPExcel->getActiveSheet()->mergeCells('Q1:AB1');
$objPHPExcel->getActiveSheet()->setCellValue("AC1","DATOS ACADEMICOS");
$objPHPExcel->getActiveSheet()->mergeCells('AC1:AY1');
$objPHPExcel->getActiveSheet()->setCellValue("AZ1","INSCRIPCION");
$objPHPExcel->getActiveSheet()->mergeCells('AZ1:BB1');
$objPHPExcel->getActiveSheet()->setCellValue("BC1","DERECHO DE MATRICULA");
$objPHPExcel->getActiveSheet()->mergeCells('BC1:BH1');
$objPHPExcel->getActiveSheet()->setCellValue("BI1","PRIMERA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('BI1:BN1');
$objPHPExcel->getActiveSheet()->setCellValue("BR1","SEGUNDA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('BR1:BW1');
$objPHPExcel->getActiveSheet()->setCellValue("CA1","TERCERA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('CA1:CF1');
$objPHPExcel->getActiveSheet()->setCellValue("CJ1","CUARTA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('CJ1:CO1');
$objPHPExcel->getActiveSheet()->setCellValue("CS1","QUINTA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('CS1:CX1');

$objPHPExcel->getActiveSheet()->setCellValue("DB1","PAGO PARA CONVALIDACIÓN");
$objPHPExcel->getActiveSheet()->mergeCells('DB1:DG1');
$objPHPExcel->getActiveSheet()->setCellValue("DH1","PAGO CARNET");
$objPHPExcel->getActiveSheet()->mergeCells('DH1:DJ1');
$objPHPExcel->getActiveSheet()->setCellValue("DK1","DATOS ESTADISTICOS");
$objPHPExcel->getActiveSheet()->mergeCells('DK1:DW1');


$objPHPExcel->getActiveSheet()->getStyle("A1:E2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDDD9C4');
$objPHPExcel->getActiveSheet()->getStyle("F1:P2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC65911');
$objPHPExcel->getActiveSheet()->getStyle("Q1:AB2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8EA9DB');
$objPHPExcel->getActiveSheet()->getStyle("AC1:AY2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92D050');
$objPHPExcel->getActiveSheet()->getStyle("AZ1:DJ2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF3399FF');
$objPHPExcel->getActiveSheet()->getStyle("AZ1:DJ2")->getFont()->getColor()->setARGB("FFF0F0F0");

$objPHPExcel->getActiveSheet()->setCellValue("BO1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("BO1:BQ1");
$objPHPExcel->getActiveSheet()->getStyle("BO1:BQ2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("BO1:BQ2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("BX1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("BX1:BZ1");
$objPHPExcel->getActiveSheet()->getStyle("BX1:BZ2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("BX1:BZ2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("CG1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("CG1:CI1");
$objPHPExcel->getActiveSheet()->getStyle("CG1:CI2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("CG1:CI2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("CP1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("CP1:CR1");
$objPHPExcel->getActiveSheet()->getStyle("CP1:CR2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("CP1:CR2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("CY1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("CY1:DA1");
$objPHPExcel->getActiveSheet()->getStyle("CY1:DA2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("CY1:DA2")->getFont()->getColor()->setARGB("FF000000");


$objPHPExcel->getActiveSheet()->getStyle("DK1:DW2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF3399');


//$objPHPExcel->getActiveSheet()->getStyle('A2:'.$az[($i-1)].'2')->applyFromArray($styleColor);

$valorinicial=2;
$cont=0;
//$objPHPExcel->getActiveSheet()->getStyle("A".$valorinicial.":O".$valorinicial)->getFont()->getColor()->setARGB("FFF0F0F0");  es para texto
foreach($control as $r){
$cont++;
$valorinicial++;
$objPHPExcel->getActiveSheet()->setCellValue("A".$valorinicial,$cont);
$objPHPExcel->getActiveSheet()->setCellValue("B".$valorinicial,$r['dfilial']);
$objPHPExcel->getActiveSheet()->setCellValue("C".$valorinicial,$r['cajero']);
$objPHPExcel->getActiveSheet()->setCellValue("D".$valorinicial,$r['sermatr']);
$objPHPExcel->getActiveSheet()->setCellValue("E".$valorinicial,$r['dcodlib']);
$objPHPExcel->getActiveSheet()->setCellValue("F".$valorinicial,$r['dappape']);
$objPHPExcel->getActiveSheet()->setCellValue("G".$valorinicial,$r['dapmape']);
$objPHPExcel->getActiveSheet()->setCellValue("H".$valorinicial,$r['dnomper']);
$objPHPExcel->getActiveSheet()->setCellValue("I".$valorinicial,$r['fnacper']);
$objPHPExcel->getActiveSheet()->setCellValue("J".$valorinicial,$r['depa']);
$objPHPExcel->getActiveSheet()->setCellValue("K".$valorinicial,$r['prov']);
$objPHPExcel->getActiveSheet()->setCellValue("L".$valorinicial,$r['dist']);
$objPHPExcel->getActiveSheet()->setCellValue("M".$valorinicial,$r['sexo']);
$objPHPExcel->getActiveSheet()->setCellValue("N".$valorinicial,$r['tipdocper']);
$objPHPExcel->getActiveSheet()->setCellValue("O".$valorinicial,$r['ndniper']);
$objPHPExcel->getActiveSheet()->setCellValue("P".$valorinicial,$r['estadoa']);

//cambio de color
$objPHPExcel->getActiveSheet()->setCellValue("Q".$valorinicial,$r['ddirper']);
$objPHPExcel->getActiveSheet()->setCellValue("R".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("S".$valorinicial,$r['dist']);
$objPHPExcel->getActiveSheet()->setCellValue("T".$valorinicial,$r['prov']);
$objPHPExcel->getActiveSheet()->setCellValue("U".$valorinicial,$r['depa']);
$objPHPExcel->getActiveSheet()->setCellValue("V".$valorinicial,$r['ddirref']);
$objPHPExcel->getActiveSheet()->setCellValue("W".$valorinicial,$r['tel']);
$objPHPExcel->getActiveSheet()->setCellValue("X".$valorinicial,$r['cel']);
$objPHPExcel->getActiveSheet()->setCellValue("Y".$valorinicial,$r['email1']);
$objPHPExcel->getActiveSheet()->setCellValue("Z".$valorinicial,$r['dcolpro']);
$objPHPExcel->getActiveSheet()->setCellValue("AA".$valorinicial,$r['tipo_colegio']);
$objPHPExcel->getActiveSheet()->setCellValue("AB".$valorinicial,'');
//cambio de color
$objPHPExcel->getActiveSheet()->setCellValue("AC".$valorinicial,$r['dinstit']);
$beca="NO";
if($r['posbeca']==1){
$beca="SI";
}
$objPHPExcel->getActiveSheet()->setCellValue("AC".$valorinicial,$r['dinstit']);
$objPHPExcel->getActiveSheet()->setCellValue("AD".$valorinicial,$beca);
$objPHPExcel->getActiveSheet()->setCellValue("AE".$valorinicial,$r['dmoding']);
$objPHPExcel->getActiveSheet()->setCellValue("AF".$valorinicial,$r['dcarrer']);
$objPHPExcel->getActiveSheet()->setCellValue("AG".$valorinicial,$r['csemaca']);
$objPHPExcel->getActiveSheet()->setCellValue("AH".$valorinicial,$r['cinicio']);
$objPHPExcel->getActiveSheet()->setCellValue("AI".$valorinicial,$r['finicio']);
//$objPHPExcel->getActiveSheet()->setCellValue("AH".$valorinicial,$r['dtipcap'].": ".$r['detalle_captacion']);
$modalidad="Virtual";
if($r['cmodali']==1){
$modalidad="Presencial";
}
$objPHPExcel->getActiveSheet()->setCellValue("AJ".$valorinicial,$modalidad);
$objPHPExcel->getActiveSheet()->setCellValue("AK".$valorinicial,$r['dciclo']);
$objPHPExcel->getActiveSheet()->setCellValue("AL".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("AM".$valorinicial,$r['dfilial_est']);
$objPHPExcel->getActiveSheet()->setCellValue("AN".$valorinicial,$r['frecuencia']);
$objPHPExcel->getActiveSheet()->setCellValue("AO".$valorinicial,$r['hora']);

$objPHPExcel->getActiveSheet()->setCellValue("AR".$valorinicial,$r['pago_pension']);
$objPHPExcel->getActiveSheet()->setCellValue("AS".$valorinicial,$r['dtipcap']);
$objPHPExcel->getActiveSheet()->setCellValue("AT".$valorinicial,$r['detalle_captacion']);
$drecep=explode("|",$r['recepcionista']);
$objPHPExcel->getActiveSheet()->setCellValue("AU".$valorinicial,$drecep[2]);
$objPHPExcel->getActiveSheet()->setCellValue("AV".$valorinicial,$drecep[1]);
$objPHPExcel->getActiveSheet()->setCellValue("AW".$valorinicial,$drecep[0]);

$objPHPExcel->getActiveSheet()->setCellValue("AX".$valorinicial,$r['documentos']);
$objPHPExcel->getActiveSheet()->setCellValue("AY".$valorinicial,$r['ddocval']);
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

$objPHPExcel->getActiveSheet()->setCellValue("AZ".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("BA".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("BB".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->getStyle("AZ".$valorinicial.":BB".$valorinicial)->getAlignment()->setWrapText(true);

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

$objPHPExcel->getActiveSheet()->setCellValue("BC".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("BD".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("BE".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("BF".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("BG".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("BH".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("BC".$valorinicial.":BH".$valorinicial)->getAlignment()->setWrapText(true);

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

$objPHPExcel->getActiveSheet()->setCellValue("BI".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("BJ".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("BK".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("BL".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("BM".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("BN".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("BI".$valorinicial.":BN".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("BO".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("BP".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("BQ".$valorinicial,'');

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

$objPHPExcel->getActiveSheet()->setCellValue("BR".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("BS".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("BT".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("BU".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("BV".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("BW".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("BR".$valorinicial.":BW".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("BX".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("BY".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("BZ".$valorinicial,'');

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

$objPHPExcel->getActiveSheet()->setCellValue("CA".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("CB".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("CC".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("CD".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("CE".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("CF".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("CA".$valorinicial.":CF".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("CG".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CH".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CI".$valorinicial,'');

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

$objPHPExcel->getActiveSheet()->setCellValue("CJ".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("CK".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("CL".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("CM".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("CN".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("CO".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("CJ".$valorinicial.":CO".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("CP".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CQ".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CR".$valorinicial,'');

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

$objPHPExcel->getActiveSheet()->setCellValue("CS".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("CT".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("CU".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("CV".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("CW".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("CX".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("CS".$valorinicial.":CX".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("CY".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CZ".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("DA".$valorinicial,'');
$total=$deudaalumno+$pagoalumno;
$totalins=$deudains+$pagoins;
$totalmat=$deudamat+$pagomat;
$totalpen=$deudap1+$pagop1;
$totalpen+=$deudap2+$pagop2;
$totalpen+=$deudap3+$pagop3;
$totalpen+=$deudap4+$pagop4;
$totalpen+=$deudap5+$pagop5;
$deudapen=$deudap1+$deudap2+$deudap3+$deudap4+$deudap5;
/*************************************************************************/
$objPHPExcel->getActiveSheet()->setCellValue("AP".$valorinicial,$totalins);
$objPHPExcel->getActiveSheet()->setCellValue("AQ".$valorinicial,$totalmat);
/*************************************************************************/
$objPHPExcel->getActiveSheet()->setCellValue("DK".$valorinicial,$totalins);
$objPHPExcel->getActiveSheet()->setCellValue("DL".$valorinicial,$totalmat);
$objPHPExcel->getActiveSheet()->setCellValue("DM".$valorinicial,$totalpen);
$objPHPExcel->getActiveSheet()->setCellValue("DN".$valorinicial,$total);
$objPHPExcel->getActiveSheet()->setCellValue("DO".$valorinicial,$pagoalumno);
$objPHPExcel->getActiveSheet()->setCellValue("DP".$valorinicial,$deudains);
$objPHPExcel->getActiveSheet()->setCellValue("DQ".$valorinicial,$deudamat);
$objPHPExcel->getActiveSheet()->setCellValue("DR".$valorinicial,$deudapen);
$objPHPExcel->getActiveSheet()->setCellValue("DS".$valorinicial,$deudaalumno);
$objPHPExcel->getActiveSheet()->setCellValue("DT".$valorinicial,$deudafecha);
$condicion="PAGANTE";
$pintar="FF99FF99";
if($deudafecha>0){
$pintar="FFFF7272";
$condicion="DEUDOR";
}
$objPHPExcel->getActiveSheet()->setCellValue("DU".$valorinicial,$condicion);
$objPHPExcel->getActiveSheet()->getStyle("DU".$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($pintar);
$objPHPExcel->getActiveSheet()->setCellValue("DV".$valorinicial,'ACTIVO');
$objPHPExcel->getActiveSheet()->setCellValue("DW".$valorinicial,'');

}
$objPHPExcel->getActiveSheet()->getStyle('A1:DW'.$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
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