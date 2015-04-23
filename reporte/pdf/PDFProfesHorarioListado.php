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
// $docentes = explode(',', $lista_docentes);

$sql = "
select  
ho.cprofes,
hora.chora
,CONCAT(hora.hinici,' - ',hora.hfin) dhora
,dia.dnomdia 
,cupr.ccurso
,cur.dcurso
,gra.ccarrer
,car.dcarrer
,gra.cinstit
,ins.dinstit
,gra.cfilial
,fil.dfilial
from horprop ho
inner join cuprprp cupr on cupr.ccuprpr = ho.ccurpro
inner join gracprp gra on gra.cgracpr = cupr.cgracpr
inner join diasm dia on dia.cdia = ho.cdia
inner join horam hora on hora.chora = ho.chora
inner join cursom cur on cur.ccurso = cupr.ccurso
inner join carrerm car on car.ccarrer = gra.ccarrer
inner join instita ins on ins.cinstit = gra.cinstit
inner join filialm fil on fil.cfilial= gra.cfilial
where  
ho.cprofes in ($lista_docentes)
and ho.cestado = 1
and gra.ffin >= CURRENT_DATE()
and hora.hinici is not null
order by hora.hinici asc
";

$cn->setQuery($sql);
$horarios = $cn->loadObjectList();

//PASAR DE LINEAL A MULTIDIMENCIONAL
$grilla = array();
foreach($horarios as $row){

//LA DIMENSION SOLO ES DIA
$grilla[$row['cprofes']][$row['dnomdia']][] = $row['dhora'] . ' - '.$row['dcurso'] . ' - '.$row['dcarrer']. ' - ' .$row['dinstit'] . $row['dfilial'];

}

// print "<pre>"; 
// print_r($grilla);
// print "</pre>";
// die();
$tr_grupo_info = '';
$tr_cursos = '';

foreach ($grilla as $id => $profes) { // Recorrido Profesor por Profesor
$sql2 = "select 
CONCAT(per.dnomper,' ',per.dappape,' ',per.dapmape) as nombre
from profesm pro
inner join personm per on pro.cperson = per.cperson
where pro.cprofes = $id";
$cn->setQuery($sql2);
$rs = $cn->loadObject();
$profesor = $rs->nombre;

$tr_horario = '';
$tr_horario .='<tr><td colspan="2">LUNES</td><td colspan="6">'.@implode('<hr>', $profes['LUNES']) . "</td></tr>";
$tr_horario .='<tr><td colspan="2">MARTES</td><td colspan="6">'.@implode('<hr>', $profes['MARTES']) . '</td></tr>';
$tr_horario .='<tr><td colspan="2">MIERCOLES</td><td colspan="6">'.@implode('<hr>', $profes['MIERCOLES']) . '</td></tr>';
$tr_horario .='<tr><td colspan="2">JUEVES</td><td colspan="6">'.@implode('<hr>', $profes['JUEVES']) . '</td></tr>';
$tr_horario .='<tr><td colspan="2">VIERNES</td><td colspan="6">'.@implode('<hr>', $profes['VIERNES']) . '</td></tr>';
$tr_horario .='<tr><td colspan="2">SABADO</td><td colspan="6">'.@implode('<hr>', $profes['SABADO']) . '</td></tr>';
$tr_horario .='<tr><td colspan="2">DOMINGO</td><td colspan="6">'.@implode('<hr>', $profes['DOMINGO']) . '</td></tr>';




/***********ADD A PAGE************/
$pdf->AddPage('L', 'A4');





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
<div style='text-align:center'><h1>Horario Académico Programado</h1></div>

	<h3>Horario:</h3>
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