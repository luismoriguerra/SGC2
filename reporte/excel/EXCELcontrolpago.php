<?php
/*conexion*/
set_time_limit(0);
ini_set('memory_limit','512M');
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';

/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

$az=array(  'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','AA','AB','AC','AD'
		  ,'AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH'
		  ,'BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL'
		  ,'CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP'
		  ,'DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ','EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU');
$azcount=array(5,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15
			   ,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15);

$cingalu=$_GET['cingalu'];
$cgracpr=$_GET['cgracpr'];
$alumno="";

$cfilial=str_replace(",","','",$_GET['cfilial']);
$cinstit=str_replace(",","','",$_GET['cinstit']);
$csemaca=explode(" | ",str_replace(",","','",$_GET['csemaca']));
$cciclo=$_GET['cciclo'];

$fechini=$_GET['fechini'];
$fechfin=$_GET['fechfin'];

$where='';

if($cingalu!=""){
$alumno=" AND c.cingalu='".$cingalu."' ";
}

if($cgracpr!=''){
$where=" WHERE c.cgruaca in ('".str_replace(",","','",$cgracpr)."') ".$alumno;
}
else{
$where=" WHERE g.cfilial in ('".$cfilial."') 
		 AND g.cinstit in ('".$cinstit."') 
		 AND g.csemaca='".$csemaca[0]."'
		 AND g.cinicio='".$csemaca[1]."'  
		 AND g.cciclo='".$cciclo."'";
	
	if($fechini!='' and $fechfin!=''){
$where.=" AND date(g.finicio) between '".$fechini."' and '".$fechfin."' ";
	}
}

$sql="SELECT 
		 f.dfilial
		,c.sermatr
		,replace(i.dcodlib,'-','') As dcodlib
		,p.dappape as dappape
		,p.dapmape as dapmape
		,p.dnomper as dnomper
		,p.fnacper
		,(Select GROUP_CONCAT(d.dnemdia SEPARATOR '-') From diasm d Where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0) As frecuencia
		,concat(h.hinici,'-',h.hfin) As hora
		,(Select Concat(ve.dapepat,' ',ve.dapemat,', ',ve.dnombre,'|',ve.demail,'|',ve.dtelefo) From vendedm ve Where ve.cvended=po.crecepc) As recepcionista
		,(Select Concat(p2.dappape,' ',p2.dapmape,', ',p2.dnomper) From personm p2 Where p2.dlogper=po.cusuari limit 1) As cajero,po.cusuari
		,If(p.coddpto>0,(Select dep.nombre From ubigeo dep Where dep.coddpto=p.coddpto And dep.codprov=0 And dep.coddist=0),'') As prov
		,If(p.codprov>0,(Select pro.nombre From ubigeo pro Where pro.coddpto=p.coddpto And pro.codprov=p.codprov And pro.coddist=0),'') As depa
		,If(p.coddist>0,(Select dis.nombre From ubigeo dis Where dis.coddpto=p.coddpto And dis.codprov=p.codprov And dis.coddist=p.coddist),'') As dist
		,If(p.tsexo='F','FEMENINO','MASCULINO') As sexo
		,IF(i.cestado='1','Activo','Retirado') as cestado
		,p.tipdocper
		,p.ndniper
		,'SOLTERO' As estadoa
		,p.ddirper
		,p.ddirref
		,p.ntelper As tel
		,p.ntelpe2 As cel
		,p.email1
		,p.dcolpro
		,If(p.tcolegi = '1', 'Nacional',
			If(p.tcolegi = '2', 'Particular',
				If(p.tcolegi = '3','Parroquia',
					If(p.tcolegi='4','FFAA',
						If(p.tcolegi='5','FFPP',''))))) As tipo_colegio
		,f2.dfilial As dfilial_est
		,g.csemaca
		,g.cinicio
		,g.finicio
		,ca.dcarrer
		,t.dtipcap
		,t.dclacap
		,If(i.cpromot!='',(Select concat(v.dapepat,' ',v.dapemat,', ',v.dnombre,' | ',v.codintv) From vendedm v Where v.cvended=i.cpromot),
			If(i.cmedpre!='',(Select m.dmedpre From medprea m Where m.cmedpre=i.cmedpre limit 1),
				If(i.destica!='',i.destica,''))) As detalle_captacion
		,tu.dturno
		,(Select concat(con.ncuotas,'C-',floor(con.nprecio)) From concepp con Where FIND_IN_SET (con.cconcep,GROUP_CONCAT(DISTINCT(r.cconcep)))  >  0 and con.cctaing like '701.03%') As pago_pension
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
		,(Select CONCAT(GROUP_CONCAT(
				IF(rr.testfin='C' OR (rr.cdocpag!='' and rr.testfin='S'),
			  		IF(rr.tdocpag='B',(select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) from boletap b where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) from vouchep v inner join bancosm b on (v.cbanco=b.cbanco) where v.cvouche=rr.cdocpag),''))
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' ),'')
			From recacap rr 
				INNER JOIN concepp co On (co.cconcep=rr.cconcep)
			Where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
			  And co.cctaing like '708%'
			  And (rr.testfin in ('C','P')
			  OR (rr.cdocpag!='' and rr.testfin='S'))
			GROUP BY rr.cingalu,rr.cgruaca ) As inscripcion
		,(Select CONCAT(GROUP_CONCAT(
				IF(rr.testfin='C' OR (rr.cdocpag!='' and rr.testfin='S'),
				  	IF(rr.tdocpag='B',(Select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) from boletap b Where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(Select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) from vouchep v Inner Join bancosm b on (v.cbanco=b.cbanco) Where v.cvouche=rr.cdocpag),''))
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' ),'')
			From recacap rr 
				INNER JOIN concepp co on (co.cconcep=rr.cconcep)
			Where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
			  And (co.cctaing like '701.01%' or co.cctaing like '701.02%')
			  And (rr.testfin in ('C','P')
			  OR (rr.cdocpag!='' and rr.testfin='S'))
			GROUP BY rr.cingalu,rr.cgruaca ) As matricula
		,IfNull((Select CONCAT(GROUP_CONCAT(
				IF(rr.testfin='C' OR (rr.cdocpag!='' and rr.testfin='S'),
			  		IF(rr.tdocpag='B',(Select Concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) From boletap b Where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(Select Concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) From vouchep v Inner Join bancosm b on (v.cbanco=b.cbanco) Where v.cvouche=rr.cdocpag),''))
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' ),'')
			From recacap rr 
				INNER JOIN concepp co on (co.cconcep=rr.cconcep)
			Where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
			  And co.cctaing like '701.03%'
			  And rr.ccuota='1'
			  And (rr.testfin in ('C','P')
			  OR (rr.cdocpag!='' and rr.testfin='S'))
			GROUP BY rr.cingalu,rr.cgruaca ),'') As p1
		,IfNull((Select CONCAT(GROUP_CONCAT(
				IF(rr.testfin='C' OR (rr.cdocpag!='' and rr.testfin='S'),
			  		IF(rr.tdocpag='B',(Select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) From boletap b Where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(Select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) From vouchep v Inner Join bancosm b on (v.cbanco=b.cbanco) Where v.cvouche=rr.cdocpag),''))
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' ),'')
			From recacap rr 
				INNER JOIN concepp co on (co.cconcep=rr.cconcep)
			Where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
			  And co.cctaing like '701.03%'
			  And rr.ccuota='2'
			  And (rr.testfin in ('C','P')
			  OR (rr.cdocpag!='' and rr.testfin='S'))
			GROUP BY rr.cingalu,rr.cgruaca),'') As p2
		,IfNull((Select CONCAT(GROUP_CONCAT(
				IF(rr.testfin='C' OR (rr.cdocpag!='' and rr.testfin='S'),
			  		IF(rr.tdocpag='B',(Select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) From boletap b Where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(Select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) From vouchep v Inner Join bancosm b on (v.cbanco=b.cbanco) Where v.cvouche=rr.cdocpag),''))
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' ),'')
			From recacap rr 
				INNER JOIN concepp co on (co.cconcep=rr.cconcep)
			Where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
			  And co.cctaing like '701.03%'
			  And rr.ccuota='3'
			  And (rr.testfin in ('C','P')
			  OR (rr.cdocpag!='' and rr.testfin='S'))
			GROUP BY rr.cingalu,rr.cgruaca),'') As p3
		,IfNull((Select CONCAT(GROUP_CONCAT(
				IF(rr.testfin='C' OR (rr.cdocpag!='' and rr.testfin='S'),
			  		IF(rr.tdocpag='B',(Select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) From boletap b Where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(Select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) From vouchep v Inner Join bancosm b on (v.cbanco=b.cbanco) Where v.cvouche=rr.cdocpag),''))
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' ),'')
			From recacap rr 
				INNER JOIN concepp co on (co.cconcep=rr.cconcep)
			Where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
			  And co.cctaing like '701.03%'
			  And rr.ccuota='4'
			  And (rr.testfin in ('C','P')
			  OR (rr.cdocpag!='' and rr.testfin='S'))
			GROUP BY rr.cingalu,rr.cgruaca),'') As p4
		,IfNull((Select CONCAT(GROUP_CONCAT(
				IF(rr.testfin='C' OR (rr.cdocpag!='' and rr.testfin='S'),
			  		IF(rr.tdocpag='B',(Select concat(b.dserbol,'-',b.dnumbol,'|',rr.nmonrec,'|',date(rr.festfin)) From boletap b Where b.cboleta=rr.cdocpag),
						IF(rr.tdocpag='V',(Select concat(v.numvou,'-',b.dbanco,'|',rr.nmonrec,'|',date(rr.festfin)) From vouchep v Inner Join bancosm b on (v.cbanco=b.cbanco) Where v.cvouche=rr.cdocpag),''))
				,CONCAT(rr.nmonrec,'_',rr.fvencim)) SEPARATOR '^^' ),'')
			From recacap rr
				INNER JOIN concepp co on (co.cconcep=rr.cconcep)
			Where FIND_IN_SET (rr.crecaca,GROUP_CONCAT(r.crecaca))  >  0
			  And co.cctaing like '701.03%'
			  And rr.ccuota='5'
			  And (rr.testfin in ('C','P')
			  OR (rr.cdocpag!='' and rr.testfin='S'))
			GROUP BY rr.cingalu,rr.cgruaca),'') As p5
		,ins.dinstit
		,i.posbeca
		,m.dmoding
		,ins.cmodali
		,ci.dciclo
		,concat(i.certest,'\n',i.partnac,'\n',i.otrodni) As documentos
		,i.ddocval,i.fusuari
	FROM personm p
		INNER JOIN ingalum i 	On (i.cperson  	= p.cperson)
		LEFT  JOIN paism pa 	On (i.cpais  	= pa.cpais)
		INNER  JOIN postulm po 	On (po.cperson 	= p.cperson And i.cingalu = po.cingalu)
		INNER JOIN filialm f 	On (f.cfilial  	= po.cfilial)
		INNER JOIN tipcapa t 	On (i.ctipcap  	= t.ctipcap)
		INNER JOIN conmatp c 	On (i.cingalu  	= c.cingalu)
		INNER JOIN gracprp g 	On (c.cgruaca  	= g.cgracpr)
		INNER JOIN turnoa tu 	On (tu.cturno 	= g.cturno)
		INNER JOIN cicloa ci 	On (ci.cciclo 	= g.cciclo)
		INNER JOIN horam h 		On (h.chora	   	= g.chora)
		INNER JOIN carrerm ca 	On (ca.ccarrer 	= g.ccarrer)
		INNER JOIN filialm f2 	On (f2.cfilial 	= g.cfilial)
		INNER JOIN instita ins 	On (ins.cinstit	= g.cinstit)
		INNER JOIN modinga m 	On (m.cmoding  	= i.cmoding)
		INNER JOIN recacap r 	On (r.cingalu  	= c.cingalu and r.cgruaca=c.cgruaca)
	".$where."
	AND r.`testfin`!='F' 
	GROUP BY c.cingalu,c.cgruaca
	ORDER BY p.dappape ASC, p.dapmape ASC, p.dnomper ASC, p.cperson DESC";
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




$cabecera=array('N°','CAJA - ODE-CENT. DE CAPTACIÓN','CAJERO QUE INSCRIBE','FICHA DE  MATRICULA ','LIBRO DE CODIGO','AP_PATERNO','AP_MATERNO','NOMBRES','FECHA DE NACIMIENTO','DEPARTAMENTO','PROVINCIA','DISTRITO','GENERO','TIPO DOCUMENTO','NRO DOCUMENTO','ESTADO CIVIL','DIRECCIÓN',	'URBANIZACION','DISTRITO','PROVINCIA','DEPARTAMENTO','REFERENCIA','TELEFONO','CELULAR','CORREO ELECTRONICO','COLEGIO DE PROCEDENCIA','REGIMEN','DIRECCION COLEGIO','INSTITUCION','SOLO POR BECA','MOD INGRE','CARRERA PROFESIONAL','SEMESTRE','INICIO','FECHA INICIO','MODAL','CICLO/MODULO','DURACION','LOCAL DE ESTUDIO','FRECUENCIA','HORARIO','INSCRIPCION','MATRICULA O RATIF','PENSION','MEDIO DE CAPTACION','RESPONSABLE DE CAPTACION'/*,'TELEFONO','E-MAIL'*/,'RECEPCIONISTA'/*,'DOCUMENTOS ENTREGADOS -ORDINARIO','DOCUME ENTRE CONVALIDA'*/,'NRO DE CERT. DE EST.','NRO DE PART. NACIM.','FOTOCOPIA DE DNI (N/S)','NRO DE FOTOS (1-6)','PAIS DE PROCED.','TIPO DE INSTIT','INST. DE PROCED','CARR. DE PROCEDENCIA','ULT. AÑO QUE ESTUDIÓ','ULT. CICLO REALIZADO','DOCUM. DEJADOS PARA LA CONVALIDACIO','FECHA_ADM','NRO B/V_ADM','MONTO_ADM','FECHA_MAT1','NRO B/V_MAT1','MONTO_MAT1','FECHA_MAT2','NRO B/V_MAT2','MONTO_MAT2','FECHA_1CUOTA','NRO B/V_1CUOTA','MONTO_1CUOTA','FECHA_1CUOTA','NRO B/V_1CUOTA','MONTO_1CUOTA','NOTA 1','NOTA 2','PROM','FECHA_2CUOTA','NRO B/V_2CUOTA','MONTO_2CUOTA','FECHA_2CUOTA','NRO B/V_2CUOTA','MONTO_2CUOTA','NOTA 1','NOTA 2','PROM','FECHA_3CUOTA','NRO B/V_3CUOTA','MONTO_3CUOTA','FECHA_3CUOTA','NRO B/V_3CUOTA','MONTO_3CUOTA','NOTA 1','NOTA 2','PROM','FECHA_4CUOTA','NRO B/V_4CUOTA','MONTO_4CUOTA','FECHA_4CUOTA','NRO B/V_4CUOTA','MONTO_4CUOTA','NOTA 1','NOTA 2','PROM','FECHA_5CUOTA','NRO B/V_5CUOTA','MONTO_5CUOTA','FECHA_5CUOTA','NRO B/V_5CUOTA','MONTO_5CUOTA','NOTA 1','NOTA 2','PROM','FECHA','NRO B/V','MONTO','FECHA','NRO B/V','MONTO','FECHA','NRO B/V','MONTO',"TOTAL INSCRIPCION","TOTAL MATRÍCULA","TOTAL PENSIÓN","TOTAL A PAGAR","MONTO PAGADO","DEUDA INSCRIPCION","DEUDA MATRÍCULA","COMPROMISOS PENDIENTES DE PENSIÓN","TOTAL COMPROMISOS PENDIENTES","DEUDA SEGÚN FECHA DE VENC. AL ".date("Y-m-d"),'CONDICION ECONOMICA','ESTADO ACADEMICO DEL ALUMNO','OBSERVACION','FECHA DIGITACION','TIPO CAPTACION','CODIGO RESPONSABLE CAPTACION');

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
$objPHPExcel->getActiveSheet()->mergeCells('AC1:AU1');
$objPHPExcel->getActiveSheet()->setCellValue("AV1","DOCUMENTOS ESCOLARES ENTREGADOS");
$objPHPExcel->getActiveSheet()->mergeCells('AV1:AY1');
$objPHPExcel->getActiveSheet()->setCellValue("AZ1","DATOS PARA EL PROCESO DE CONVALIDACION");
$objPHPExcel->getActiveSheet()->mergeCells('AZ1:BF1');
$objPHPExcel->getActiveSheet()->setCellValue("BG1","INSCRIPCION");
$objPHPExcel->getActiveSheet()->mergeCells('BG1:BI1');
$objPHPExcel->getActiveSheet()->setCellValue("BJ1","DERECHO DE MATRICULA");
$objPHPExcel->getActiveSheet()->mergeCells('BJ1:BO1');
$objPHPExcel->getActiveSheet()->setCellValue("BP1","PRIMERA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('BP1:BU1');
$objPHPExcel->getActiveSheet()->setCellValue("BY1","SEGUNDA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('BY1:CD1');
$objPHPExcel->getActiveSheet()->setCellValue("CH1","TERCERA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('CH1:CM1');
$objPHPExcel->getActiveSheet()->setCellValue("CQ1","CUARTA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('CQ1:CV1');
$objPHPExcel->getActiveSheet()->setCellValue("CZ1","QUINTA CUOTA");
$objPHPExcel->getActiveSheet()->mergeCells('CZ1:DE1');

$objPHPExcel->getActiveSheet()->setCellValue("DI1","PAGO PARA CONVALIDACIÓN");
$objPHPExcel->getActiveSheet()->mergeCells('DI1:DN1');
$objPHPExcel->getActiveSheet()->setCellValue("DO1","PAGO CARNET");
$objPHPExcel->getActiveSheet()->mergeCells('DO1:DQ1');
$objPHPExcel->getActiveSheet()->setCellValue("DR1","DATOS ESTADISTICOS");
$objPHPExcel->getActiveSheet()->mergeCells('DR1:EG1');


$objPHPExcel->getActiveSheet()->getStyle("A1:E2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDDD9C4');
$objPHPExcel->getActiveSheet()->getStyle("F1:P2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC65911');
$objPHPExcel->getActiveSheet()->getStyle("Q1:AB2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8EA9DB');
$objPHPExcel->getActiveSheet()->getStyle("AC1:BF2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92D050');
$objPHPExcel->getActiveSheet()->getStyle("BG1:DQ2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF3399FF');
$objPHPExcel->getActiveSheet()->getStyle("BG1:DQ2")->getFont()->getColor()->setARGB("FFF0F0F0");

$objPHPExcel->getActiveSheet()->setCellValue("BV1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("BV1:BX1");
$objPHPExcel->getActiveSheet()->getStyle("BV1:BX2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("BV1:BX2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("CE1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("CE1:CG1");
$objPHPExcel->getActiveSheet()->getStyle("CE1:CG2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("CE1:CG2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("CN1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("CN1:CP1");
$objPHPExcel->getActiveSheet()->getStyle("CN1:CP2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("CN1:CP2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("CW1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("CW1:CY1");
$objPHPExcel->getActiveSheet()->getStyle("CW1:CY2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("CW1:CY2")->getFont()->getColor()->setARGB("FF000000");

$objPHPExcel->getActiveSheet()->setCellValue("DF1","NOTA");
$objPHPExcel->getActiveSheet()->mergeCells("DF1:DH1");
$objPHPExcel->getActiveSheet()->getStyle("DF1:DH2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF8B4560');
$objPHPExcel->getActiveSheet()->getStyle("DF1:DH2")->getFont()->getColor()->setARGB("FF000000");


$objPHPExcel->getActiveSheet()->getStyle("DR1:EE2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF3399');

$objPHPExcel->getActiveSheet()->getStyle("EF2:EG2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF92D050');
// SOLO PARA LOS ULTIMOS CAMPOS ADICIONADOS

//$objPHPExcel->getActiveSheet()->getStyle('A2:'.$az[($i-1)].'2')->applyFromArray($styleColor);

$valorinicial=2;
$cont=0;
//$objPHPExcel->getActiveSheet()->getStyle("A".$valorinicial.":O".$valorinicial)->getFont()->getColor()->setARGB("FFF0F0F0");  es para texto
foreach($control As $r){
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
$modalidad="VIRTUAL";
if($r['cmodali']==1){
$modalidad="PRESENCIAL";
}
$objPHPExcel->getActiveSheet()->setCellValue("AJ".$valorinicial,$modalidad);
$objPHPExcel->getActiveSheet()->setCellValue("AK".$valorinicial,$r['dciclo']);
$objPHPExcel->getActiveSheet()->setCellValue("AL".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("AM".$valorinicial,$r['dfilial_est']);
$objPHPExcel->getActiveSheet()->setCellValue("AN".$valorinicial,$r['frecuencia']);
$objPHPExcel->getActiveSheet()->setCellValue("AO".$valorinicial,$r['hora']);

$objPHPExcel->getActiveSheet()->setCellValue("AR".$valorinicial,$r['pago_pension']);
$objPHPExcel->getActiveSheet()->setCellValue("AS".$valorinicial,$r['dtipcap']);

$detcap=explode("|",$r['detalle_captacion']);
$objPHPExcel->getActiveSheet()->setCellValue("AT".$valorinicial,$detcap[0]);

$drecep=explode("|",$r['recepcionista']);
$objPHPExcel->getActiveSheet()->setCellValue("AU".$valorinicial,$drecep[0]);
//$objPHPExcel->getActiveSheet()->setCellValue("AU".$valorinicial,$drecep[2]);
//$objPHPExcel->getActiveSheet()->setCellValue("AV".$valorinicial,$drecep[1]);
//$objPHPExcel->getActiveSheet()->setCellValue("AW".$valorinicial,$drecep[0]);

$objPHPExcel->getActiveSheet()->setCellValue("AV".$valorinicial,$r['certest']);
$objPHPExcel->getActiveSheet()->setCellValue("AW".$valorinicial,$r['partnac']);
$objPHPExcel->getActiveSheet()->setCellValue("AX".$valorinicial,$r['fotodni']);
$objPHPExcel->getActiveSheet()->setCellValue("AY".$valorinicial,$r['nfotos']);
//$objPHPExcel->getActiveSheet()->setCellValue("AX".$valorinicial,$r['documentos']);
//$objPHPExcel->getActiveSheet()->setCellValue("AY".$valorinicial,$r['ddocval']);

$objPHPExcel->getActiveSheet()->setCellValue("AZ".$valorinicial,$r['dpais']);
$objPHPExcel->getActiveSheet()->setCellValue("BA".$valorinicial,$r['tinstip']);
$objPHPExcel->getActiveSheet()->setCellValue("BB".$valorinicial,$r['dinstip']);
$objPHPExcel->getActiveSheet()->setCellValue("BC".$valorinicial,$r['dcarrep']);
$objPHPExcel->getActiveSheet()->setCellValue("BD".$valorinicial,$r['ultanop']);
$objPHPExcel->getActiveSheet()->setCellValue("BE".$valorinicial,$r['dciclop']);
$objPHPExcel->getActiveSheet()->setCellValue("BF".$valorinicial,$r['ddocval']);

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

$objPHPExcel->getActiveSheet()->setCellValue("BG".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("BH".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("BI".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->getStyle("BG".$valorinicial.":BI".$valorinicial)->getAlignment()->setWrapText(true);

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

$objPHPExcel->getActiveSheet()->setCellValue("BJ".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("BK".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("BL".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("BM".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("BN".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("BO".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("BJ".$valorinicial.":BO".$valorinicial)->getAlignment()->setWrapText(true);

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

$objPHPExcel->getActiveSheet()->setCellValue("BP".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("BQ".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("BR".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("BS".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("BT".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("BU".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("BP".$valorinicial.":BU".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("BV".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("BW".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("BX".$valorinicial,'');

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

$objPHPExcel->getActiveSheet()->setCellValue("BY".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("BZ".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("CA".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("CB".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("CC".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("CD".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("BY".$valorinicial.":CD".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("CE".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CF".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CG".$valorinicial,'');

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

$objPHPExcel->getActiveSheet()->setCellValue("CH".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("CI".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("CJ".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("CK".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("CL".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("CM".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("CH".$valorinicial.":CM".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("CN".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CO".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CP".$valorinicial,'');

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

$objPHPExcel->getActiveSheet()->setCellValue("CQ".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("CR".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("CS".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("CT".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("CU".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("CV".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("CQ".$valorinicial.":CV".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("CW".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CX".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("CY".$valorinicial,'');

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

$objPHPExcel->getActiveSheet()->setCellValue("CZ".$valorinicial,$fecha);
$objPHPExcel->getActiveSheet()->setCellValue("DA".$valorinicial,$nro);
$objPHPExcel->getActiveSheet()->setCellValue("DB".$valorinicial,$monto);
$objPHPExcel->getActiveSheet()->setCellValue("DC".$valorinicial,$fecha2);
$objPHPExcel->getActiveSheet()->setCellValue("DD".$valorinicial,$nro2);
$objPHPExcel->getActiveSheet()->setCellValue("DE".$valorinicial,$monto2);
$objPHPExcel->getActiveSheet()->getStyle("CZ".$valorinicial.":DE".$valorinicial)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue("DF".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("DG".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("DH".$valorinicial,'');
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
$objPHPExcel->getActiveSheet()->setCellValue("DR".$valorinicial,$totalins);
$objPHPExcel->getActiveSheet()->setCellValue("DS".$valorinicial,$totalmat);
$objPHPExcel->getActiveSheet()->setCellValue("DT".$valorinicial,$totalpen);
$objPHPExcel->getActiveSheet()->setCellValue("DU".$valorinicial,$total);
$objPHPExcel->getActiveSheet()->setCellValue("DV".$valorinicial,$pagoalumno);
$objPHPExcel->getActiveSheet()->setCellValue("DW".$valorinicial,$deudains);
$objPHPExcel->getActiveSheet()->setCellValue("DX".$valorinicial,$deudamat);
$objPHPExcel->getActiveSheet()->setCellValue("DY".$valorinicial,$deudapen);
$objPHPExcel->getActiveSheet()->setCellValue("DZ".$valorinicial,$deudaalumno);
$objPHPExcel->getActiveSheet()->setCellValue("EA".$valorinicial,$deudafecha);
$condicion="PAGANTE";
$pintar="FF99FF99";
	if($deudafecha>0){
	$pintar="FFFF7272";
	$condicion="DEUDOR";
	}
$objPHPExcel->getActiveSheet()->setCellValue("EB".$valorinicial,$condicion);
$objPHPExcel->getActiveSheet()->getStyle("EB".$valorinicial)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($pintar);
$objPHPExcel->getActiveSheet()->setCellValue("EC".$valorinicial,$r['cestado']);
$objPHPExcel->getActiveSheet()->setCellValue("ED".$valorinicial,'');
$objPHPExcel->getActiveSheet()->setCellValue("EE".$valorinicial,$r['fusuari']);


$dclacap="";
if($r['dclacap']==1){
$dclacap="NO COMISIONAN";
}
elseif($r['dclacap']==2){
$dclacap="SI COMISIONAN";
}
elseif($r['dclacap']==3){
$dclacap="MASIVOS";
}

$objPHPExcel->getActiveSheet()->setCellValue("EF".$valorinicial,$dclacap);
	if(count($detcap)>0){
		$objPHPExcel->getActiveSheet()->setCellValue("EG".$valorinicial,$detcap[1]);
	}
}

$objPHPExcel->getActiveSheet()->getStyle('A1:EG'.$valorinicial)->applyFromArray($styleThinBlackBorderAllborders);
////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('Control_Pago');
// Set active sheet index to the first sheet, so Excel opens this As the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client's web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ControlPago_Notas_'.date("Y-m-d_H-i-s").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>