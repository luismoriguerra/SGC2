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
$lista_docentes = $_GET['docentes'];
$docentes = explode(',', $lista_docentes);




$tr_grupo_info = '';
$tr_cursos = '';

foreach ($docentes as $id ) { // Recorrido Profesor por Profesor
$sql = "select 
di.dnomdia dia,
GROUP_CONCAT( CONCAT_WS('-',d.hini,d.hfin)  SEPARATOR '<hr>') horas 
from disprom d
inner join diasm  di on di.cdia = d.cdia
WHERE d.cestado = 1 and d.cprofes = $id
GROUP BY d.cdia
order by d.cdia asc, d.hini asc  ";
$cn->setQuery($sql);
$rs = $cn->loadObjectList();


$tr_horario = '';
foreach ($rs as $row) {
	$tr_horario .='<tr><td colspan="2">'. $row["dia"] .'</td><td colspan="6">'. $row["horas"] . "</td></tr>";
}

$sql2 = "select 
CONCAT(per.dnomper,' ',per.dappape,' ',per.dapmape) as nombre
from profesm pro
inner join personm per on pro.cperson = per.cperson
where pro.cprofes = $id";
$cn->setQuery($sql2);
$rs = $cn->loadObject();
$profesor = $rs->nombre;



/***********ADD A PAGE************/
$pdf->AddPage('P', 'A4');





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
<div style='text-align:center'><h1>Horario de Disponibilidad</h1></div>

	<h3>Profesor: {$profesor}</h3>
	<table border="1" style='width:100%' cellpadding="2" >
	<tr>
		<td colspan="2" style=''><b>Dia</b></td>
		<td colspan="6" style=''><b>Horario</b></td>
	</tr>
	{$tr_horario}

	</table>

EOD;


$pdf->writeHTML($html, true, false, true, false, '');
/*******FIN PROCESO*******/
// reset pointer to the last page
$pdf->lastPage();

}

// print $html;








//Close and output PDF document
$pdf->Output('ProfeHorarioListado.pdf', 'I');
?>