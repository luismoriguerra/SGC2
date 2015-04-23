<?php
set_time_limit(0);
ini_set('memory_limit','512M');
//$idencuesta=$_GET['idenc'];
//$empresa=$_GET['empresa'];

/*conexion*/
require_once '../../conexion/MySqlConexion.php';
require_once '../../conexion/configMySql.php';
/*crea obj conexion*/
$cn=MySqlConexion::getInstance();

/****TCPDF Libreria****/
require_once '../../php/includes/tcpdf/config/lang/spa.php';
require_once '../../php/includes/tcpdf/tcpdf.php';

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);//hoja A4

/*****CONFIGURACION PDF****/
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Segura');

// remove default header
$pdf->setPrintHeader(false);//elimina cabecera

// remove default footer
$pdf->setPrintFooter(false);//elimina pie

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// $pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFont('helvetica', '', 8);
/* QUERYS */
$cgracpr = $_GET['cgracpr'];
$cingalu = $_GET['cingalu'];
$semestre = $_GET['csemaca'];
$cfilial = $_GET['cfilial'];
$cinstit = $_GET['cinstit'];
$alumno = "";

if (trim($cingalu) != "") {
  $listAlum = str_replace(",", "','", $cingalu);
  $alumno = " AND co.cingalu in ('" . $listAlum . "')";
}

$sql = "	Select i.cingalu,ins.durllog,fi.dfilial,i.dcoduni,replace(i.dcodlib,'-','') as dcodlib,co.cconmat,gr.csemaca,ca.dcarrer,ca.durlcam,pe.dnomper,pe.dappape,pe.dapmape,ci.dciclo,
		GROUP_CONCAT(concat(
			cu.codicur,'|',cu.dcurso,'|',dg.ncredit) SEPARATOR '^^') as cursos,
		(select CONCAT(co.nprecio,'|',rr.fvencim)
		from recacap rr 
		INNER JOIN concepp co on (co.cconcep=rr.cconcep)
		WHERE rr.cingalu=co.cingalu and rr.cgruaca=co.cgruaca
		and (co.cctaing like '701.01%' or co.cctaing like '701.02%')
		and rr.testfin in ('C','P')
		limit 0,1
		) as matricula_fecha,
		(select CONCAT(co.nprecio,'|',rr.fvencim)
		from recacap rr 
		INNER JOIN concepp co on (co.cconcep=rr.cconcep)
		WHERE rr.cingalu=co.cingalu and rr.cgruaca=co.cgruaca
		and (co.cctaing like '708%')
		and rr.testfin in ('C','P')
		limit 0,1
		) as inscripcion,
		(select GROUP_CONCAT(concat(cr.ccuota,'|',cr.fvencim,'|',IF(con.ctaprom>=cr.ccuota,con.mtoprom,con.nprecio)) SEPARATOR '^^') as pagos
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
		GROUP BY cr.cgruaca,cr.cconcep) as pension,fi.dfilial,gr.finicio,fi.ddirfil,fi2.dfilial as dfilial_est,
		concat(fi2.ddirfil,' | Tel/cel: ',fi2.ntelfil) as direccion_estudio
		from ingalum i
		INNER JOIN postulm po ON (po.cingalu=i.cingalu and po.cperson=i.cperson)
		INNER JOIN filialm fi2 ON (fi2.cfilial=po.cfilial)
		INNER JOIN filialm fi ON (fi.cfilial=i.cfilial)
		INNER JOIN conmatp co ON (i.cingalu=co.cingalu)
		INNER JOIN personm pe ON (pe.cperson=i.cperson)
		INNER JOIN gracprp gr ON (gr.cgracpr=co.cgruaca)
		INNER JOIN instita ins on (ins.cinstit=gr.cinstit)
		LEFT JOIN cuprprp dg ON (dg.cgracpr=gr.cgracpr)
		LEFT JOIN cursom cu ON (cu.ccurso=dg.ccurso)
		INNER JOIN cicloa ci ON (ci.cciclo=gr.cciclo)
		INNER JOIN carrerm ca ON (ca.ccarrer=gr.ccarrer)
		where co.cgruaca in ('" . str_replace(",", "','", $cgracpr) . "')	
		" . $alumno . "
		GROUP BY co.cingalu,co.cgruaca";
$cn->setQuery($sql);
$alumno = $cn->loadObjectList();

foreach ($alumno as $rs) { // Inicio de Recorrido

/***********ADD A PAGE************/
$pdf->AddPage();



  $detfechamatric = explode("|", $rs['matricula_fecha']);
  $rs['matricula'] = $detfechamatric[0];
  $rs['fecha_matric'] = $detfechamatric[1];
  $detfechainscrip = explode("|", $rs['inscripcion']);
  $monto_inscripcion = $detfechainscrip[0];
  $fecha_inscripcion = $detfechainscrip[1];


//TABLA PROGRAMACION ACADEMICA
  $dcursos = explode("^^", $rs['cursos']);
  $detcic = explode(" ", $rs['dciclo']);

  if (trim($rs['cursos']) == "") {
    
  } else {
  	$taproacatr ="";
  	$taproacatrtotal =0;
  	for ($i = 11; $i < (11 + count($dcursos)); $i++) { //Antiguo era hasta el 16
      $ddc = explode("|", $dcursos[($i - 11)]);
      //GENERAMOS LOS TR DE CURSOS
      $taproacatr .="<tr> <td class=\"textcenter\">{$detcic[0]}</td><td>$ddc[0]</td><td>$ddc[1]</td><td>$ddc[2]</td> </tr>";
      $taproacatrtotal += $ddc[2];
  }
  $taproacatr .="<tr><td colspan=\"3\" class=\"textright\"><b>TOTAL CREDITOS:</b></td><td>$taproacatrtotal</td></tr>";
}


//PROGRAMA DE PAGOS
$pagostotal=explode("^^",$rs['pension']);
sort($pagostotal);
$tapropagotr="";
for($i=0;$i<count($pagostotal);$i++){
	$det=explode("|",$pagostotal[$i]);
	if($i==0){
	$fecha_pension=$det[1];
	$monto_pension=$det[2];
	}
	$tapropagotr .="<tr> <td class=\"textcenter\">".$det[0].' CUOTA'."</td><td>$det[1]</td><td>$det[2]</td></tr>";
}

//PAGOS PARA LA MATRICULA
$tapagomat="";


$html = <<<EOD

<style>
body{

}
.textleft{
 text-align:left;
}
.textright{
text-align:right;
font-weight:bold;
}

.textcenter{
	text-align:center;
}

.tdcabecera{
	text-align:center;
	font-weight:bold;


}
</style>

<div class="cabecera" style="text-align:center">
	<h2>CONSTANCIA DE PREMATRICULA</h2>
	<table class="datosmatricula" >
			<tr>
				<td  class="textright">CODIGO:</td>
				<th class="textleft">{$rs['dcodlib']}</th>
			</tr>
			<tr>
				<td class="textright">APELLIDOS Y NOMBRES:</td>
				<th class="textleft">{$rs['dnomper']} {$rs['dappape']} {$rs['dapmape']}</th>
			</tr>
			<tr>
				<td class="textright">LOCAL DE ESTUDIOS:</td>
				<th class="textleft">{$rs['dfilial']}</th>
			</tr>
			<tr>
				<td class="textright">CARRERA PROFESIONAL:</td>
				<th class="textleft">{$rs['dcarrer']}</th>
			</tr>
		</table>
</div>
<div class="cuerpo">
	<table class="tabla1" style='width:100%' style='text-align:center;'>
		<tr>
			<td style="text-align:center; font-weight:bold;">FECHA DE MATRICULA: {$rs['fecha_matric']} / FECHA DE INICIO DE CLASES {$rs['finicio']}</td>
		</tr>
	</table>
	<table class="tabla2" style='width:100%' cellpadding="2" cellspacing="2">
		<tr>
			<td style="width:60%">
				
				<table class="proaca"  border="1"cellpadding="2">
					<tr>
						<td colspan="4" class="tdcabecera">PROGRAMACION ACADEMICA {$rs["csemaca"]}</td>
					</tr>
					<tr>
						<th width="9%" class="tdcabecera">CICLO</th>
						<th width="11%" class="tdcabecera">CODIG</th>
						<th width="70%" class="tdcabecera">ASIGNATURAS</th>
						<th width="10%" class="tdcabecera">CRED</th>
					</tr>
					{$taproacatr}
				</table>
			</td>


			<td  style="width:40%">
				
				<table class="propago" border="1" cellpadding="2">
					<tr>
						<td colspan="3" class="tdcabecera">PROGRAMACION DE PAGOS {$rs["csemaca"]}</td>
					</tr>
					<tr>
						<th class="tdcabecera">CUOTA</th>
						<th class="tdcabecera">FECHA</th>
						<th class="tdcabecera">IMPORTE</th>
					</tr>
					{$tapropagotr}
				</table>
				<div class="descriptpago">
					Todo pago, pasada la fecha de vencimiento sufrira un recargo adicional			
				</div>
				<br>
				
				<table class="pagomat" border="1" cellpadding="2">
					<tr>
						<td colspan="3" class="tdcabecera">PAGOS PARA LA MATRICULA {$rs["csemaca"]}</td>
					</tr>
					<tr>
						<th class="tdcabecera">CONCEPTO</th>
						<th class="tdcabecera">FECHA</th>
						<th class="tdcabecera">IMPORTE</th>
					</tr>
					<tr>
					<td>Inscripcion</td>
					<td>$fecha_inscripcion</td>
					<td>$monto_inscripcion</td>
					</tr>
					<tr><td>Derecho de matricula</td>
					<td>$fecha_pension</td>
					<td>{$rs['matricula']}</td></tr>
					<tr><td>Pension de la carrera</td>
					<td>$fecha_pension</td>
					<td>$monto_pension</td></tr>
				</table>



			</td>
		</tr>
	</table>
</div>

<table width="100%"   border="1"cellpadding="2">
<tr>
	<td colspan="3" class="tdcabecera">COMUNICACIÓN PARA REALIZAR EL PAGO A TRAVÉS DEL BCP		</td>
</tr>
<tr>
	<td class="tdcabecera">Qué debo de decir?			</td>
	<td class="tdcabecera">En la ventanilla del BCP				</td>
	<td class="tdcabecera">Al agente BCP			</td>
</tr>
<tr>
	<td class="" style="font-weight:bold">Lo primero que debo de decir				</td>
	<td class="">Deseo pagar a la universidad Telesup					</td>
	<td class="">Deseo pagar a la cuenta recaudadora 6008			</td>
</tr>
<tr>
	<td class="" style="font-weight:bold">Lo segundo que debo de decir					</td>
	<td class="" colspan="2">Deseo pagar al servicio pago sin descuento											</td>
</tr>
<tr>
	<td class="" style="font-weight:bold">Finalmente, deberá indicar su código:						</td>
	<td class="" colspan="2">Mi código es: {$rs['dcodlib']}														</td>
</tr>
<tr>
	<td colspan="3" class="tdcabecera"> Antes de pagar, verificar que el nombre le corresponda a usted		</td>
</tr>
</table>

<br>
<table width="100%"   border="1"cellpadding="2">
<tr>
	<td class="tdcabecera">ACCEDER A LA INTRANET Y AL CAMPUS VIRTUAL		</td>
</tr>
<tr>
	<td>Para que usted pueda registrar su matrícula, la institución pone a su servicio el acceso a la Intranet a través de www.cpdtelesup.com ; para ello use el código del alumno ({$rs['dcodlib']}) como usuario y como contraseña.  En caso de presentar deuda pendiente de pago, este servicio será suspendido temporalmente hasta la cancelación de la misma.									</td>
</tr>
</table>

<br>
<table width="100%"   border="1"cellpadding="2">
<tr>
	<td class="tdcabecera">INFORMACIÓN IMPORTANTE		</td>
</tr>
<tr>
	<td>
	<div>
		1.-  Se considera alumno matriculado y goza de todos los derechos como tal, aquel que ha realizado el pago de la matrícula, el pago de la  primera cuota como mínimo, ha presentado todos los documentos solicitados, ha registrado sus datos en la Ficha de Matrícula y se ha registrado por Intranet mediante www.cpdtelesup.com.									
	</div>
	<div>
	2.- Deberá matricularse en la fecha y hora indicada; caso contrario será considerada matrícula extemporanea.  El alumno matriculado en fecha extenporánea, que ha cumplido con todos los pagos y ha entregado todos los documentos solicitados,  deberá esperar 7 dias después de iniciado las clases para gozar de todos los derechos como alumno matriculado y se somete a la disponibilidad de inicios, asignaturas, ambientes, horarios y frecuencias de estudios.									</div>
	<div>
	3.- En tanto el alumno no cancele el integro del pago de sus pensiones educativas, la universidad retendrá los certificados correspondientes a los periodos no pagados.									</div>
	<div>
4.- El alumno no podrá matricularse en el ciclo académico siguiente hasta la cancelación de la deuda por pensiones educativas, salvo existencia de convenio de pago.									
	</div>
	<div>
	5.- Las pensiones no pagadas generarán intereses moratorios. (LEY N° 29947) .									</div>

	</td>
</tr>
</table>
<br>
<table>
<tr>
<td style="text-align:center;font-weight:bold;">DIRECCION ACADEMICA</td>
</tr>
<tr>
<td style="text-align:center;font-weight:bold;">RECLAMOS Y QUEJAS: OFIC. ASEGURAMIENTO DE LA CALIDAD - AV. AREQUIPA 3565 - LIMA / TELF.: 957879905									</td>
</tr>
</table>

EOD;


$pdf->writeHTML($html, true, false, true, false, '');
/*******FIN PROCESO*******/
// reset pointer to the last page
$pdf->lastPage();

}

// print $html;








//Close and output PDF document
$pdf->Output('preMatriculaAdm.pdf', 'I');
?>