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
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// $pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFont('helvetica', '', 8);
/* QUERYS */
$cursos = $_GET['cursos'];
$cursos = explode(',', $cursos);

$detalle = $_GET['detalle'];
$detalle = explode('_', $detalle);

$sec = $_GET['sec'];
$let = $_GET['let'];


$tr_grupo_info = '';
$tr_cursos = '';

foreach ($cursos as $id => $curso) { // Recorrido Profesor por Profesor

$sql = "
select de.ccurpro , de.cconmat , co.cingalu
,IFNULL(re2.testfin,'c') deudor
,re.cperson
,CONCAT_WS(' ',pe.dappape,pe.dapmape,pe.dnomper) nombre
from decomap de
inner join conmatp co on co.cconmat = de.cconmat
inner join recacap re on re.cingalu = co.cingalu 
left join recacap re2 on re2.cingalu = co.cingalu and re2.testfin = 'P'
inner join personm pe on pe.cperson = re.cperson
where de.ccurpro = '$curso' and de.cdetgra = $sec
group by co.cingalu
order by nombre asc
";

$cn->setQuery($sql);
$alumnos = $cn->loadObjectList();

//PASAR DE LINEAL A MULTIDIMENCIONAL
$listado = array();
$tr_alumnosaprobados = '';
$tr_alumnoscondeudas = '';


foreach($alumnos as $row){
//LA DIMENSION SOLO ES DIA
	if($row['deudor'] == 'c'){
		$tr_alumnosaprobados .= "<tr><td>". $row['nombre']."</td><td></td></tr>";
	}else{
		$tr_alumnoscondeudas .= "<tr><td>". $row['nombre']."</td><td></td></tr>";

	}

}


/***********ADD A PAGE************/
$pdf->AddPage('L', 'A4');





$html = <<<EOD

<div style='text-align:center'><h1>Listado de ALumnos</h1></div>

	<h3>Curso: {$detalle[0]}</h3>
	<h3>Seccion: {$let}</h3>
	<table border="1" style='width:100%' cellpadding="2" >
	<tr><td ><b>Alumnos Aprobados</b></td>
	<td><b>Firma del alumno</b></td>
	</tr>
	{$tr_alumnosaprobados}
	</table>
	<p></p>
	<table border="1" style='width:100%' cellpadding="2" >
	<tr><td ><b>Alumnos con deudas</b></td><td><b>Firma del alumno</b></td></tr>
	{$tr_alumnoscondeudas}
	</table>
	<p></p>
	<p></p>
	<br>
	<div style=''>
	___________________ <br>
	Firma del encargado
	</div>

EOD;


$pdf->writeHTML($html, true, false, true, false, '');
/*******FIN PROCESO*******/
// reset pointer to the last page
$pdf->lastPage();

}

// print $html;








//Close and output PDF document
$pdf->Output('AlumnosPagos.pdf', 'I');
?>