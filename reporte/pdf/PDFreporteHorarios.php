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
$lista_grupo = $_GET['grupos'];
$grupos = explode(',', $lista_grupo);





foreach ($grupos as $grupo) { // Inicio de Recorrido

$sql = "select cu.ccuprpr, cur.dcurso , CONCAT_WS(' ',dappape,dapmape,dnomper) dprofes,
cu.ncredit
from cuprprp cu 
left join profesm pro on pro.cprofes = cu.cprofes
left join personm per on per.cperson = pro.cperson
left join cursom  cur on cur.ccurso = cu.ccurso
where cu.cgracpr='$grupo'";
$cn->setQuery($sql);
// print $sql;
$cursos = $cn->loadObjectList();
 // print_r($cursos);

$tr_cursos = '';
$grupo_cursos =array();
$data_cursos = array();
foreach ($cursos as  $curso) {
	# code...
	$tr_cursos .="<tr><td>".$curso['dcurso']."</td><td>".$curso['dprofes']."</td><td style=\"text-align:center\">".$curso['ncredit']."</td></tr>";
	// print $tr_cursos;
	$grupo_cursos [] = "'". $curso["ccuprpr"] . "'";
	$data_cursos[$curso["ccuprpr"]] = $curso['dcurso'];

}

//GRUPO INFO
$sql = "select fi.dfilial filial , ins.dinstit institucion, car.dcarrer carrera , gr.csemaca semestre , gr.finicio , gr.ffin , gr.cinicio
from gracprp gr 
left join filialm fi on fi.cfilial = gr.cfilial
left join instita ins on ins.cinstit = gr.cinstit
left join carrerm car on car.ccarrer = gr.ccarrer
where gr.cgracpr = '$grupo'";
$cn->setQuery($sql);
$tr_grupo_info = '';
$grupo_info = $cn->loadObjectList();
foreach ($grupo_info as  $info) {
	list($semestre,$num) = explode("-", $info["semestre"]);
	if($num== 1){
		$num  = "I";
	}elseif($num== 2){
		$num  = "II";
	}elseif($num== 3){
		$num  = "III";
	}elseif($num== 4){
		$num  = "IV";
	}elseif($num== 5){
		$num  = "V";
	}
	$tr_grupo_info .="<tr><th style=\"width:20%\"><b>ODE</b></th><td  style=\"width:70%\">". $info["filial"]  ."</td></tr>";
	$tr_grupo_info .="<tr><th><b>Insitución</b></th><td>". $info["institucion"]  ."</td></tr>";
	$tr_grupo_info .="<tr><th><b>Carrera</b></th><td>". $info["carrera"] ."</td></tr>";
	$tr_grupo_info .="<tr><th><b>Semestre/Inicio</b></th><td>".$semestre . "-".$num ." / " .$info["cinicio"] ."</td></tr>";
	$tr_grupo_info .="<tr><th><b>Fecha de Inicio/Fin</b></th><td>". $info["finicio"] ." / ".$info["ffin"]  ."</td></tr>";
	;
}

//TABLA HORARIOS
$lista_cursos = implode(',', $grupo_cursos);
$sql = "
select  dia.dnomdia ,hora.hinici ini , hora.hfin fin,
group_concat(DISTINCT(select distinct in_ho.ccurpro from horprop in_ho where in_ho.cdia = '02' and in_ho.ccurpro = ho.ccurpro and in_ho.chora = ho.chora  ) SEPARATOR '<hr>')lunes,
group_concat(DISTINCT(select distinct in_ho.ccurpro from horprop in_ho where in_ho.cdia = '03' and in_ho.ccurpro = ho.ccurpro and in_ho.chora = ho.chora  ) SEPARATOR '<hr>')martes,
group_concat(DISTINCT(select distinct in_ho.ccurpro from horprop in_ho where in_ho.cdia = '04' and in_ho.ccurpro = ho.ccurpro and in_ho.chora = ho.chora  ) SEPARATOR '<hr>')miercoles,
group_concat(DISTINCT(select distinct in_ho.ccurpro from horprop in_ho where in_ho.cdia = '05' and in_ho.ccurpro = ho.ccurpro and in_ho.chora = ho.chora  ) SEPARATOR '<hr>')jueves,
group_concat(DISTINCT(select distinct in_ho.ccurpro from horprop in_ho where in_ho.cdia = '06' and in_ho.ccurpro = ho.ccurpro and in_ho.chora = ho.chora ) SEPARATOR '<hr>') viernes,
group_concat(DISTINCT(select distinct in_ho.ccurpro from horprop in_ho where in_ho.cdia = '07' and in_ho.ccurpro = ho.ccurpro and in_ho.chora = ho.chora ) SEPARATOR '<hr>') sabado,
group_concat(DISTINCT(select distinct in_ho.ccurpro from horprop in_ho where in_ho.cdia = '01' and in_ho.ccurpro = ho.ccurpro and in_ho.chora = ho.chora ) SEPARATOR '<hr>') domingo
from horprop ho
left join diasm dia on dia.cdia = ho.cdia
left join horam hora on hora.chora = ho.chora 
where ho.ccurpro in ($lista_cursos) and ho.cestado = 1
and hora.hinici is not null
 group by hora.hinici
order by hora.hinici asc";
// print( $sql);
$cn->setQuery($sql);
$horario = $cn->loadObjectList();

$tr_horario = '';
// $grupo_cursos =array();
foreach ($horario as  $row) {
	# code...
	// print '<pre>';
	// print_r($row);
	// print "</pre>";
	$tr_horario .="<tr><td>".$row['ini']. ' - '.$row['fin']."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['lunes'] ) ."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['martes'] ) ."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['miercoles'] ) ."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['jueves'] ) ."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['viernes'] ) ."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['sabado'] ) ."</td><td>"
	. str_replace(array_keys($data_cursos) , array_values($data_cursos), $row['domingo'] ) ."</td></tr>";
	// .$data_cursos[$row['martes']]."</td><td>"
	// .$data_cursos[$row['miercoles']]."</td><td>"
	// .$data_cursos[$row['jueves']]."</td><td>"
	// .$data_cursos[$row['viernes']]."</td></tr>";
	// print $tr_cursos;
	// $grupo_cursos [] = "'". $curso["ccuprpr"] . "'";
	// print $tr_horario;

}
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


<table style="text-align:center;">
<tr><td style="font-size: 1.5em;"><h1>GRUPO EDUCATIVO TELESUP</h1></td></tr>
<tr><td><h1>Horarios Programados</h1></td></tr>
</table>
<p></p>
<table class="cabecera" style='width:100%' cellpadding="2">
	<tr>
		<td style="text-align:left;">

			<table class="grupo_info" border="1" style='width:100%' cellpadding="2" >
					{$tr_grupo_info}
				</table>
		

		</td>
		<td style="text-align:left">

				<table class="prefesores_info" border="1" style='width:100%' cellpadding="3" >
					<tr>
						<th><b>Curso</b></th>
						<th><b>Profesor</b></th>
						<th style="width:10%;text-align:center"><b>Creditos</b></th>
					</tr>
					{$tr_cursos}
				</table>
		</td>
	</tr>

</table>

	

	<h3>Horario:</h3>
	<table border="1" style='width:100%' cellpadding="2" >
	<tr>
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
$pdf->Output('HorariosGrupo.pdf', 'I');
?>