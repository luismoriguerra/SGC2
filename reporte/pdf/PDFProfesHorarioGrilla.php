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
,gra.csemaca
,gra.cinicio
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

// $grilla[$row['cprofes']][$row['chora']][$row['dnomdia']][] = $row['cfilial'] . ' - ' .$row['cinstit'] . ' - '.$row['ccarrer'] . ' - '.$row['ccurso'];

$grilla[$row['cprofes']][$row['chora']]['texto']= $row['dhora'];
$grilla[$row['cprofes']][$row['chora']]['dias'][$row['dnomdia']][] = $row['dfilial'] 
						. '<br>' .$row['dinstit'] 
						. '<br>SEMESTRE: ' . $row["csemaca"]. '/'.$row["cinicio"]

						. '<br>'.$row['dcarrer'] 
						. '<br>'.$row['dcurso'];

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
foreach ($profes as  $row) {
	# code...
	// print '<pre>';
	// print_r($row);
	// print "</pre>";
	// die();
	$tr_horario .="<tr><td class=\"text-th\">".$row['texto']."</td><td>"
	. @implode('<hr>', $row['dias']['LUNES']) ."</td><td>"
	. @implode('<hr>', $row['dias']['MARTES']) ."</td><td>"
	. @implode('<hr>', $row['dias']['MIERCOLES']) ."</td><td>"
	. @implode('<hr>', $row['dias']['JUEVES']) ."</td><td>"
	. @implode('<hr>', $row['dias']['VIERNES']) ."</td><td>"
	. @implode('<hr>', $row['dias']['SABADO']) ."</td><td>"
	. @implode('<hr>', $row['dias']['DOMINGO']) ."</td></tr>";
	


}
/***********ADD A PAGE************/
$pdf->AddPage('L', 'A4');



$mes = array("","enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
$fecha = "Lima, ".date("d").' de '.$mes[date('m')]. ' del '.date("Y");


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
.fondo-claro{
	background-color:#A6D2F7
}
.horario,  td{
	vertical-align:middle;
	text-align:center;
}
.text-1{font-size:3em}
.text-2{font-size:2em}
.text-n{font-weight:bold; font-size: 1.5em; vertical-align:middle}
.text-th{font-weight:bold;  vertical-align:middle}
</style>

<table>
<tr><td class="text-1">GRUPO EDUCATIVO TELESUP</td></tr>
<tr><td class="text-2">CARGA HORARIA ASIGNADA AL DOCENTE</td></tr>
</table>
<p></p>
<table>
<tr><td class="text-n" style="text-align:left">DOCENTE: {$profesor}</td><td class="text-n" style="text-align:right">{$fecha}</td></tr>

</table>

	<table border="1" style='width:100%' cellpadding="2" style="" class="horario">
	<tr class="fondo-claro" style="background:#A6D2F7">
		<th><b>Hora</b></th>
		<th><b>Lunes</b></th>
		<th><b>Martes</b></th>
		<th><b>Miercoles</b></th>
		<th><b>Jueves</b></th>
		<th><b>Viernes</b></th>
		<th><b>Sabado</b></th>
		<th><b>Domingo</b></th>
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
$pdf->Output('ProfesHorarioGrilla.pdf', 'I');
?>